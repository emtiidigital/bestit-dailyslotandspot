<?php
class tt_upcoming_events_widget extends WP_Widget 
{
	/** constructor */
    function __construct() 
	{
		$widget_options = array(
			'classname' => 'tt_upcoming_events_widget',
			'description' => 'Displays upcoming events scrolling list'
		);

       parent::__construct('timetable_upcoming_events', __('Upcoming Events', 'timetable'), $widget_options);
    }
	
	/** @see WP_Widget::widget */
    function widget($args, $instance) 
	{
		global $wpdb;
		global $wp_locale;
		$timetable_events_settings = get_option("timetable_events_settings");
		extract($args);

		//these are our widget options
		$title = (isset($instance['title']) ? $instance['title'] : "");
		$title_color = (isset($instance['title_color']) ? $instance['title_color'] : "");
		$count = (isset($instance['count']) ? $instance['count'] : "");
		$display_settings = (isset($instance['display_settings']) ? $instance['display_settings'] : "");
		$within_next = (isset($instance['within_next']) ? $instance['within_next'] : "");
		$time_format = (isset($instance['time_format']) ? $instance['time_format'] : "");
		$time_format_custom = (isset($instance['time_format_custom']) ? $instance['time_format_custom'] : "");
		$time_mode = (isset($instance['time_mode']) ? $instance['time_mode'] : "");
		$timezone = (isset($instance['timezone']) ? $instance['timezone'] : "");
		$auto_scroll = (isset($instance['auto_scroll']) ? $instance['auto_scroll'] : "");
		$event_featured_image = (isset($instance['event_featured_image']) ? $instance['event_featured_image'] : "");
		$disable_url = (isset($instance['disable_url']) ? $instance['disable_url'] : false);
		$custom_url = (isset($instance['custom_url']) ? $instance['custom_url'] : "");
		$categories = (isset($instance['categories']) ? $instance['categories'] : "");
		$hour_categories = (isset($instance['hour_categories']) ? $instance['hour_categories'] : "");
		$background_color = (isset($instance['background_color']) ? $instance['background_color'] : "");
		$hover_background_color = (isset($instance['hover_background_color']) ? $instance['hover_background_color'] : "");
		$text_color = (isset($instance['text_color']) ? $instance['text_color'] : "");
		$hover_text_color = (isset($instance['hover_text_color']) ? $instance['hover_text_color'] : "");
		$item_border_color = (isset($instance['item_border_color']) ? $instance['item_border_color'] : "");
		$hover_item_border_color = (isset($instance['hover_item_border_color']) ? $instance['hover_item_border_color'] : "");

		echo $before_widget;
		
		if($time_mode=="server")
		{
			$phpDayNumber = date('w', current_time('timestamp', ($timezone=="utc" ? 1 : 0)));
			if($phpDayNumber==0)
				$phpDayNumber = 7;
			/*else
				$phpDayNumber++;*/
		}
		
		//get all weekdays order numbers
		if($display_settings=="all")
		{
			$query = "SELECT menu_order FROM {$wpdb->posts}
					WHERE
					post_status='publish'
					AND
					menu_order=" . ($time_mode=="server" ? $phpDayNumber : "CASE WHEN DATE_FORMAT(CURDATE(), '%w') = 0 THEN 7 ELSE DATE_FORMAT(CURDATE(), '%w') END");
			$current_day_number = $wpdb->get_row($query);
			$query = "SELECT menu_order FROM {$wpdb->posts}
					WHERE
					post_type='timetable_weekdays'
					AND 
					post_status='publish'
					ORDER BY menu_order";
			$weekdays_orders = $wpdb->get_results($query);
			$count_weekdays_orders = count($weekdays_orders);
			$weekdays_orders_sql = "";
			$weekdays_orders_array = array();
			for($i=0; $i<$count_weekdays_orders; $i++)	
				$weekdays_orders_array[] = $weekdays_orders[$i]->menu_order;
			$weekdays_orders_array = array_values(array_unique($weekdays_orders_array));
			$current_day_number_index = array_search($current_day_number->menu_order, $weekdays_orders_array);
			$weekdays_before_current = array_slice($weekdays_orders_array, 0, $current_day_number_index);
			$weekdays_after_current = array_slice($weekdays_orders_array, $current_day_number_index+1, $count_weekdays_orders-$current_day_number_index);
			$weekdays_orders_array_sorted = array_merge($weekdays_after_current, $weekdays_before_current);
			if((int)$within_next>0)
				$weekdays_orders_array_sorted = array_slice($weekdays_orders_array_sorted, 0, (int)$within_next);
			$count_weekdays_orders_sorted = count($weekdays_orders_array_sorted);
			for($i=0; $i<$count_weekdays_orders_sorted; $i++)
				$weekdays_orders_sql .= "'" . $weekdays_orders_array_sorted[$i] . "'" . ($i+1<$count_weekdays_orders_sorted ? "," : "");
		}
		
		$query = "SELECT TIME_FORMAT(t1.start, '%H.%i') AS start, TIME_FORMAT(t1.end, '%H.%i') AS end, t1.event_id AS event_id, t1.before_hour_text AS description1, t1.after_hour_text AS description2, t2.post_title, t2.post_name, t3.post_title as weekday FROM ".$wpdb->prefix."event_hours AS t1 
			LEFT JOIN {$wpdb->posts} AS t2 ON t1.event_id=t2.ID 
			LEFT JOIN {$wpdb->posts} AS t3 ON t1.weekday_id=t3.ID";
		if(!empty($categories) && count($categories))
			$query .= "
				LEFT JOIN $wpdb->term_relationships ON(t2.ID = $wpdb->term_relationships.object_id)
				LEFT JOIN $wpdb->term_taxonomy ON($wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id)
				LEFT JOIN $wpdb->terms ON($wpdb->term_taxonomy.term_id = $wpdb->terms.term_id)
				WHERE $wpdb->terms.slug IN ('" . join("','", (array)$categories) . "')
				AND $wpdb->term_taxonomy.taxonomy = 'events_category'
				AND";
		else
			$query .= "
				WHERE";
				
		//global $post;	
		$query .= "
			t2.post_type='" . $timetable_events_settings["slug"] . "' 
			AND t2.post_status='publish'
			AND 
			t3.post_type='timetable_weekdays'
			AND 
			t3.post_status='publish'";
		//AND t2.ID='" . $post->ID . "'";
		
		if($hour_categories!=null && $hour_categories!="-")
			$query .= "
				AND t1.category IN('" . join("','", $hour_categories) . "')";
		if($display_settings=="today")
			$query .= "	AND 
			t3.menu_order=" . ($time_mode=="server" ? $phpDayNumber : "CASE WHEN DATE_FORMAT(CURDATE(), '%w') = 0 THEN 7 ELSE DATE_FORMAT(CURDATE(), '%w') END") . " 
			AND 
			SUBTIME(t1.start, " . ($time_mode=="server" ? "TIME('" . date('H:i:s', current_time('timestamp', ($timezone=="utc" ? 1 : 0))) . "')" : "CURRENT_TIME()") . ")>0";
		else if($display_settings=="current")
			$query .= "	AND 
			t3.menu_order=" . ($time_mode=="server" ? $phpDayNumber : "CASE WHEN DATE_FORMAT(CURDATE(), '%w') = 0 THEN 7 ELSE DATE_FORMAT(CURDATE(), '%w') END") . " 
			AND 
			SUBTIME(t1.end, " . ($time_mode=="server" ? "TIME('" . date('H:i:s', current_time('timestamp', ($timezone=="utc" ? 1 : 0))) . "')" : "CURRENT_TIME()") . ")>0
			AND
			SUBTIME(t1.end, " . ($time_mode=="server" ? "TIME('" . date('H:i:s', current_time('timestamp', ($timezone=="utc" ? 1 : 0))) . "')" : "CURRENT_TIME()") . ")<SUBTIME(t1.end, t1.start)";
		else
			$query .= "	AND(
			(t3.menu_order=" . ($time_mode=="server" ? $phpDayNumber : "CASE WHEN DATE_FORMAT(CURDATE(), '%w') = 0 THEN 7 ELSE DATE_FORMAT(CURDATE(), '%w') END") . " 
			AND 
			SUBTIME(t1.start, " . ($time_mode=="server" ? "TIME('" . date('H:i:s', current_time('timestamp', ($timezone=="utc" ? 1 : 0))) . "')" : "CURRENT_TIME()") . ")>0)
			OR t3.menu_order IN(" . $weekdays_orders_sql . "))";
		$query .= " GROUP BY t1.event_hours_id";
		if($display_settings=="today" || $display_settings=="current")
			$query .= " ORDER BY t1.start, t1.end";
		else
			$query .= " ORDER BY FIELD(t3.menu_order," . ($time_mode=="server" ? $phpDayNumber : "CASE WHEN DATE_FORMAT(CURDATE(), '%w') = 0 THEN 7 ELSE DATE_FORMAT(CURDATE(), '%w') END") . "," . $weekdays_orders_sql . "), t1.start, t1.end";
		if((int)$count>0)
			$query .= " LIMIT " . $count;
		$event_hours = $wpdb->get_results($query);
		$event_hours_count = count($event_hours);
		$output = '';
		$output .= '<div class="tt_upcoming_events_widget">';
				if($title) 
				{
					if($title_color!="")
						$before_title = str_replace(">", " style='color: #" . $title_color . ";'>",$before_title);
					$output .= $before_title . $title . $after_title;
				}
		$output .= '<div class="tt_upcoming_events_wrapper page_margin_top">';
		if($event_hours_count):
				$output .= '<ul class="tt_upcoming_events clearfix autoscroll-' . (int)$auto_scroll . '">';
				for($i=0; $i<$event_hours_count; $i++)
				{
					$event_hours[$i]->start = date($time_format_custom, strtotime($event_hours[$i]->start));
					$event_hours[$i]->end = date($time_format_custom, strtotime($event_hours[$i]->end));
					//$output .= '<li' . ($text_color!='' ? ' value_color="' . $text_color . '"' : '') . ($item_border_color!='' ? ' border_color="' . $item_border_color . '"' : '') . ' value="' .  $event_hours[$i]->start . ' - ' .  $event_hours[$i]->end . '"]<a href="' . get_permalink($event_hours[$i]->ID) . '" title="' . $event_hours[$i]->post_title . '">' . $event_hours[$i]->post_title . '</a></li>';
					//get event color
					$reset_bg_color = false;
					$reset_border_color = false;
					if($hover_background_color=="" || $item_border_color=="")
					{
						$event_color = get_post_meta($event_hours[$i]->event_id, "timetable_color", true);
						if($hover_background_color=="")
						{
							$hover_background_color = $event_color;
							$reset_bg_color = true;
						}
						if($item_border_color=="")
						{
							$item_border_color = $event_color;
							$hover_item_border_color = $event_color;
							$reset_border_color = true;
						}
					}
					$event_custom_url = "";
					$event_custom_url = get_post_meta($event_hours[$i]->event_id, "timetable_custom_url", true);
					if($event_custom_url!="")
						$custom_url = $event_custom_url;
					$output .= '<li><' . ((int)$disable_url ? 'span' : 'a') . ' class="tt_upcoming_events_event_container"' . ($background_color!="" || $item_border_color!="" || $text_color!="" ? ' style="' . ($background_color!="" ? 'background-color: #' . $background_color . ';' : '') . ($item_border_color!="" ? 'border-' . ($wp_locale->text_direction=='rtl' ? 'right' : 'left') . '-color: #' . $item_border_color . ';' : '') . ($text_color!="" ? 'color: #' . $text_color . ';' : '') . '"' : '') . ($background_color!="" || $hover_background_color!="" || $item_border_color!="" || $hover_item_border_color!="" || $text_color!="" || $hover_text_color!="" ? ' onMouseOver="' . ($background_color!="" || $hover_background_color!="" ? 'this.style.backgroundColor=\'#'.($hover_background_color!="" ? $hover_background_color : '00A27C').'\';' : '') . ($item_border_color!="" || $hover_item_border_color!="" ? 'this.style.borderColor=\'#'.($hover_item_border_color!="" ? $hover_item_border_color : '00A27C').'\';' : '' ) . ($text_color!="" || $hover_text_color!="" ? 'this.style.color=\'#'.($hover_text_color!="" ? $hover_text_color : 'FFFFFF') . '\';' : '' ) . '" onMouseOut="' . ($background_color!="" || $hover_background_color!="" || $item_border_color!="" || $hover_item_border_color!="" || $text_color!="" || $hover_text_color!="" ? ($background_color!="" || $hover_background_color!="" ? 'this.style.backgroundColor=\'#'.($background_color!="" ? $background_color : 'FFF').'\';' : '') . ($item_border_color!="" || $hover_item_border_color!="" ? 'this.style.borderColor=\'#EFEFEF\';this.style.border' . ($wp_locale->text_direction=='rtl' ? 'Right' : 'Left') . 'Color=\'#'.($item_border_color!="" ? $item_border_color : 'EFEFEF').'\';' : '' ) . ($text_color!="" || $hover_text_color!="" ? 'this.style.color=\'#'.($text_color!="" ? $text_color : '34495E').'\';' : '') : '' ). '"' : '') . (!(int)$disable_url ? ' href="' . ($custom_url!="" ? esc_attr($custom_url) : get_permalink($event_hours[$i]->event_id)) . '"' : '') . ' title="' . $event_hours[$i]->post_title . '">' . ($event_hours[$i]->description1!="" || $event_hours[$i]->description2!="" ? '<span class="tt_upcoming_events_arrow"></span>' : '') . $event_hours[$i]->post_title . '<span class="tt_upcoming_events_hours timetable_clearfix"><span class="tt_calendar_icon"></span>' . $event_hours[$i]->weekday . ', ' . $event_hours[$i]->start . ' - ' .  $event_hours[$i]->end . '</span>' . ($event_hours[$i]->description1!="" || $event_hours[$i]->description2!="" ? '<span class="tt_event_hours_description">' . $event_hours[$i]->description1 . ($event_hours[$i]->description1!="" && $event_hours[$i]->description2!="" ? '<br>' : '') . $event_hours[$i]->description2 . '</span>' : '') . ((int)$event_featured_image==1 ? get_the_post_thumbnail($event_hours[$i]->event_id) : '') . '</' . ((int)$disable_url ? 'span' : 'a') . '></li>';
					if($reset_bg_color)
						$hover_background_color = "";
					if($reset_border_color)
					{
						$item_border_color = "";
						$hover_item_border_color = "";
					}
				}
		$output .= '</ul><div class="tt_upcoming_event_controls">
			<a href="#" id="upcoming_event_prev"><span class="tt_upcoming_event_prev_arrow"></span></a>
			<a href="#" id="upcoming_event_next"><span class="tt_upcoming_event_next_arrow"></span></a>
		</div>';
		else:
			$output .= '<p class="message">' . sprintf(__('No upcoming %s for today' , 'timetable'), strtolower($timetable_events_settings['label_plural'])) . '</p>';
		
		endif;
		$output .= '</div>
		</div>';

		echo do_shortcode($output);
        echo $after_widget;
    }
	
	/** @see WP_Widget::update */
    function update($new_instance, $old_instance) 
	{
		$instance = $old_instance;
		$instance['title'] = (isset($new_instance['title']) ? strip_tags($new_instance['title']) : "");
		$instance['title_color'] = (isset($new_instance['title_color']) ? strip_tags($new_instance['title_color']) : "");
		$instance['count'] = (isset($new_instance['count']) ? strip_tags($new_instance['count']) : "");
		$instance['display_settings'] = (isset($new_instance['display_settings']) ? strip_tags($new_instance['display_settings']) : "");
		$instance['within_next'] = (isset($new_instance['within_next']) ? strip_tags($new_instance['within_next']) : "");
		$instance['time_format'] = (isset($new_instance['time_format']) ? strip_tags($new_instance['time_format']) : "");
		$instance['time_format_custom'] = (isset($new_instance['time_format_custom']) ? strip_tags($new_instance['time_format_custom']) : "");
		$instance['time_mode'] = (isset($new_instance['time_mode']) ? strip_tags($new_instance['time_mode']) : "");
		$instance['timezone'] = (isset($new_instance['timezone']) ? strip_tags($new_instance['timezone']) : "");
		$instance['categories'] = (isset($new_instance['categories']) ? $new_instance['categories'] : "");
		$instance['hour_categories'] = (isset($new_instance['hour_categories']) ? $new_instance['hour_categories'] : "");
		$instance['auto_scroll'] = (isset($new_instance['auto_scroll']) ? $new_instance['auto_scroll'] : "");
		$instance['event_featured_image'] = (isset($new_instance['event_featured_image']) ? $new_instance['event_featured_image'] : "");
		$instance['disable_url'] = (isset($new_instance['disable_url']) ? $new_instance['disable_url'] : "");
		$instance['custom_url'] = (isset($new_instance['custom_url']) ? strip_tags($new_instance['custom_url']) : "");
		$instance['background_color'] = (isset($new_instance['background_color']) ? strip_tags($new_instance['background_color']) : "");
		$instance['hover_background_color'] = (isset($new_instance['hover_background_color']) ? strip_tags($new_instance['hover_background_color']) : "");
		$instance['text_color'] = (isset($new_instance['text_color']) ? strip_tags($new_instance['text_color']) : "");
		$instance['hover_text_color'] = (isset($new_instance['hover_text_color']) ? strip_tags($new_instance['hover_text_color']) : "");
		$instance['item_border_color'] = (isset($new_instance['item_border_color']) ? strip_tags($new_instance['item_border_color']) : "");
		$instance['hover_item_border_color'] = (isset($new_instance['hover_item_border_color']) ? strip_tags($new_instance['hover_item_border_color']) : "");
		return $instance;
    }
	
	 /** @see WP_Widget::form */
	function form($instance) 
	{	
		$timetable_events_settings = get_option("timetable_events_settings");
		
		$title = (isset($instance['title']) ? esc_attr($instance['title']) : "");
		$title_color = (isset($instance['title_color']) ? esc_attr($instance['title_color']) : "");
		$count = (isset($instance['count']) ? esc_attr($instance['count']) : "");
		$display_settings = (isset($instance['display_settings']) ? esc_attr($instance['display_settings']) : "");
		$within_next = (isset($instance['within_next']) ? esc_attr($instance['within_next']) : "");
		$time_format = (isset($instance['time_format']) ? esc_attr($instance['time_format']) : "");
		$time_format_custom = (isset($instance['time_format_custom']) ? esc_attr($instance['time_format_custom']) : "");
		$time_mode = (isset($instance['time_mode']) ? esc_attr($instance['time_mode']) : "");
		$timezone = (isset($instance['timezone']) ? esc_attr($instance['timezone']) : "");
		$categories = (isset($instance['categories']) ? $instance['categories'] : "");
		$hour_categories = (isset($instance['hour_categories']) ? $instance['hour_categories'] : "");
		$auto_scroll = (isset($instance['auto_scroll']) ? $instance['auto_scroll'] : "");
		$event_featured_image = (isset($instance['event_featured_image']) ? $instance['event_featured_image'] : "");
		$disable_url = (isset($instance['disable_url']) ? $instance['disable_url'] : "");
		$custom_url = (isset($instance['custom_url']) ? $instance['custom_url'] : "");
		$background_color = (isset($instance['background_color']) ? esc_attr($instance['background_color']) : "");
		$hover_background_color = (isset($instance['hover_background_color']) ? esc_attr($instance['hover_background_color']) : "");
		$text_color = (isset($instance['text_color']) ? esc_attr($instance['text_color']) : "");
		$hover_text_color = (isset($instance['hover_text_color']) ? esc_attr($instance['hover_text_color']) : "");
		$item_border_color = (isset($instance['item_border_color']) ? esc_attr($instance['item_border_color']) : "");
		$hover_item_border_color = (isset($instance['hover_item_border_color']) ? esc_attr($instance['hover_item_border_color']) : "");
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'timetable'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('title_color'); ?>"><?php _e('Title color', 'timetable'); ?></label>
			<span class="color_preview" style="background-color: #<?php echo ($title_color!="" ? $title_color : 'FFFFFF'); ?>;"></span>
			<input class="regular-text color" id="<?php echo $this->get_field_id('title_color'); ?>" name="<?php echo $this->get_field_name('title_color'); ?>" type="text" value="<?php echo $title_color; ?>" data-default-color="FFFFFF" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Count', 'timetable'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo $count; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('display_settings'); ?>"><?php _e('Display settings', 'timetable'); ?></label>
			<select id="<?php echo $this->get_field_id('display_settings'); ?>" name="<?php echo $this->get_field_name('display_settings'); ?>">
				<option value="today"<?php echo ($display_settings=="today" ? " selected='selected'" : ""); ?>><?php _e('today upcoming', 'timetable'); ?></option>
				<option value="all"<?php echo ($display_settings=="all" ? " selected='selected'" : ""); ?>><?php _e('all upcoming', 'timetable'); ?></option>
				<option value="current"<?php echo ($display_settings=="current" ? " selected='selected'" : ""); ?>><?php _e('current events', 'timetable'); ?></option>
			</select>
		</p>
		<p <?php echo ($display_settings=="today" || $display_settings=="current" || $display_settings=="" ? ' style="display: none;"' : ''); ?>>
			<label for="<?php echo $this->get_field_id('within_next'); ?>"><?php _e('All upcoming within next', 'timetable'); ?></label>
			<input class="widefat" style="width: 60px;" id="<?php echo $this->get_field_id('within_next'); ?>" name="<?php echo $this->get_field_name('within_next'); ?>" type="text" value="<?php echo $within_next; ?>" /> <?php _e("day(s)", 'timetable'); ?>
		</p>
		<p>
			<label for="time_format">
				<?php _e("Time format", "timetable"); ?>
			</label>
			<br>
			<label title="H.i">
				<input type="radio" <?php echo ($time_format=="H.i" ? 'checked="checked"' : ''); ?> value="H.i" name="<?php echo $this->get_field_name('time_format'); ?>"> 
				<span>09.03</span>
			</label>
			<br>
			<label title="H:i">
				<input type="radio" <?php echo ($time_format=="H:i" ? 'checked="checked"' : ''); ?> value="H:i" name="<?php echo $this->get_field_name('time_format'); ?>"> 
				<span>09:03</span>
			</label>
			<br>
			<label title="g:i a">
				<input type="radio" <?php echo ($time_format=="g:i a" ? 'checked="checked"' : ''); ?> value="g:i a" name="<?php echo $this->get_field_name('time_format'); ?>"> 
				<span>9:03 am</span>
			</label>
			<br>
			<label title="g:i A">
				<input type="radio" <?php echo ($time_format=="g:i A" ? 'checked="checked"' : ''); ?> value="g:i A" name="<?php echo $this->get_field_name('time_format'); ?>"> 
				<span>9:03 AM</span>
			</label>
			<br>
			<label>
				<input type="radio" <?php echo ($time_format=="custom" ? 'checked="checked"' : ''); ?> value="custom" id="time_format_custom_radio" name="<?php echo $this->get_field_name('time_format'); ?>"> 
				<?php _e("Custom: ", "timetable"); ?>
			</label>
			<input type="text" class="small-text" value="<?php echo ($time_format_custom!="" ? $time_format_custom : "g:i a"); ?>" name="<?php echo $this->get_field_name('time_format_custom'); ?>" id="<?php echo $this->get_field_id('time_format_custom'); ?>"> 
			<span class="example"> 9:03 am</span>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('time_mode'); ?>"><?php _e('Time from', 'timetable'); ?></label>
			<select id="upcoming_events_time_from" name="<?php echo $this->get_field_name('time_mode'); ?>">
				<option value="server"<?php echo ($time_mode=="server" ? " selected='selected'" : ""); ?>><?php _e('server', 'timetable'); ?></option>
				<option value="database"<?php echo ($time_mode=="database" ? " selected='selected'" : ""); ?>><?php _e('database', 'timetable'); ?></option>
			</select>
		</p>
		<p class="upcoming_events_timezone_row" <?php echo ($time_mode=="database" ? " style='display: none;'" : ""); ?>>
			<label for="<?php echo $this->get_field_id('timezone'); ?>"><?php _e('Timezone', 'timetable'); ?></label>
			<select name="<?php echo $this->get_field_name('timezone'); ?>">
				<option value="localtime"<?php echo ($timezone=="localtime" ? " selected='selected'" : ""); ?>><?php _e('localtime', 'timetable'); echo " (now: " .  date('H:i:s', current_time('timestamp')) . ")"; ?></option>
				<option value="utc"<?php echo ($timezone=="utc" ? " selected='selected'" : ""); ?>><?php _e('utc', 'timetable'); echo " (now: " .  date('H:i:s', current_time('timestamp', 1)) . ")"; ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('categories'); ?>"><?php _e('Categories', 'timetable'); ?></label>
			<select multiple="multiple" id="<?php echo $this->get_field_id('categories'); ?>" name="<?php echo $this->get_field_name('categories'); ?>[]">
			<?php
			$events_categories = get_terms("events_category");
			foreach((array)$events_categories as $events_category)
			{
			?>
				<option <?php echo (is_array($categories) && in_array($events_category->slug, $categories) ? ' selected="selected"':'');?> value='<?php echo $events_category->slug;?>'><?php echo $events_category->name; ?></option>
			<?php
			}
			?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('hour_categories'); ?>"><?php _e('Hour categories', 'timetable'); ?></label>
			<select multiple="multiple" id="<?php echo $this->get_field_id('hour_categories'); ?>" name="<?php echo $this->get_field_name('hour_categories'); ?>[]">
			<?php
			//get all hour categories
			global $wpdb;
			$query = "SELECT distinct(category) AS category FROM " . $wpdb->prefix . "event_hours AS t1
					LEFT JOIN {$wpdb->posts} AS t2 ON t1.event_id=t2.ID 
					WHERE 
					t2.post_type='" . $timetable_events_settings["slug"] . "'
					AND t2.post_status='publish'
					AND category<>''";
			$hour_categories_array = $wpdb->get_results($query);
			foreach((array)$hour_categories_array as $hour_category)
			{
			?>
				<option <?php echo (is_array($hour_categories) && in_array($hour_category->category, $hour_categories) ? ' selected="selected"':'');?> value='<?php echo $hour_category->category;?>'><?php echo $hour_category->category; ?></option>
			<?php
			}
			?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('auto_scroll'); ?>"><?php _e('Auto scroll', 'timetable'); ?></label>
			<select id="<?php echo $this->get_field_id('auto_scroll'); ?>" name="<?php echo $this->get_field_name('auto_scroll'); ?>">
				<option value="0"<?php echo ((int)$auto_scroll==0 ? " selected='selected'" : ""); ?>><?php _e('no', 'timetable'); ?></option>
				<option value="1"<?php echo ((int)$auto_scroll==1 ? " selected='selected'" : ""); ?>><?php _e('yes', 'timetable'); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('custom_url'); ?>"><?php _e('Custom event url', 'timetable'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('custom_url'); ?>" name="<?php echo $this->get_field_name('custom_url'); ?>" type="text" value="<?php echo $custom_url; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('event_featured_image'); ?>"><?php _e('Event featured image', 'timetable'); ?></label>
			<select id="<?php echo $this->get_field_id('event_featured_image'); ?>" name="<?php echo $this->get_field_name('event_featured_image'); ?>">
				<option value="0"<?php echo ((int)$event_featured_image==0 ? " selected='selected'" : ""); ?>><?php _e('Hide', 'timetable'); ?></option>
				<option value="1"<?php echo ((int)$event_featured_image==1 ? " selected='selected'" : ""); ?>><?php _e('Show', 'timetable'); ?></option>				
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('disable_url'); ?>"><?php _e('Disable event url', 'timetable'); ?></label>
			<select id="<?php echo $this->get_field_id('disable_url'); ?>" name="<?php echo $this->get_field_name('disable_url'); ?>">
				<option value="0"<?php echo ((int)$disable_url==0 ? " selected='selected'" : ""); ?>><?php _e('no', 'timetable'); ?></option>
				<option value="1"<?php echo ((int)$disable_url==1 ? " selected='selected'" : ""); ?>><?php _e('yes', 'timetable'); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('background_color'); ?>"><?php _e('Background color', 'timetable'); ?></label>
			<span class="color_preview" style="background-color: #<?php echo ($background_color!="" ? $background_color : 'FFFFFF'); ?>;"></span>
			<input class="regular-text color" id="<?php echo $this->get_field_id('background_color'); ?>" name="<?php echo $this->get_field_name('background_color'); ?>" type="text" value="<?php echo $background_color; ?>" data-default-color="FFFFFF" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('hover_background_color'); ?>"><?php _e('Hover background color', 'timetable'); ?></label>
			<span class="color_preview" style="background-color: #<?php echo ($hover_background_color!="" ? $hover_background_color : '00A27C'); ?>;"></span>
			<input class="regular-text color" id="<?php echo $this->get_field_id('hover_background_color'); ?>" name="<?php echo $this->get_field_name('hover_background_color'); ?>" type="text" value="<?php echo $hover_background_color; ?>" data-default-color="00A27C" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('text_color'); ?>"><?php _e('Text color', 'timetable'); ?></label>
			<span class="color_preview" style="background-color: #<?php echo ($text_color!="" ? $text_color : '34495E'); ?>;"></span>
			<input class="regular-text color" id="<?php echo $this->get_field_id('text_color'); ?>" name="<?php echo $this->get_field_name('text_color'); ?>" type="text" value="<?php echo $text_color; ?>" data-default-color="34495E" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('hover_text_color'); ?>"><?php _e('Hover text color', 'timetable'); ?></label>
			<span class="color_preview" style="background-color: #<?php echo ($hover_text_color!="" ? $hover_text_color : 'FFFFFF'); ?>;"></span>
			<input class="regular-text color" id="<?php echo $this->get_field_id('hover_text_color'); ?>" name="<?php echo $this->get_field_name('hover_text_color'); ?>" type="text" value="<?php echo $hover_text_color; ?>" data-default-color="FFFFFF" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('item_border_color'); ?>"><?php _e('Item border color', 'timetable'); ?></label>
			<span class="color_preview" style="background-color: #<?php echo ($item_border_color!="" ? $item_border_color : '00A27C'); ?>;"></span>
			<input class="regular-text color" id="<?php echo $this->get_field_id('item_border_color'); ?>" name="<?php echo $this->get_field_name('item_border_color'); ?>" type="text" value="<?php echo $item_border_color; ?>" data-default-color="00A27C" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('hover_item_border_color'); ?>"><?php _e('Hover item border color', 'timetable'); ?></label>
			<span class="color_preview" style="background-color: #<?php echo ($hover_item_border_color!="" ? $hover_item_border_color : '00A27C'); ?>;"></span>
			<input class="regular-text color" id="<?php echo $this->get_field_id('hover_item_border_color'); ?>" name="<?php echo $this->get_field_name('hover_item_border_color'); ?>" type="text" value="<?php echo $hover_item_border_color; ?>" data-default-color="00A27C" />
		</p>
		<script type="text/javascript">
		jQuery(document).ready(function($){
			$("[name='<?php echo $this->get_field_name('time_format'); ?>']").change(function(){
				if($(this).val()!="custom")
				{
					$(this).parent().siblings("input:last").val($(this).val());
					$(this).parent().siblings(".example").html($(this).next().html());
				}
			});
			$("[name='<?php echo $this->get_field_name('time_format_custom'); ?>']").on('focus', function(){
				$(this).prev().children().prop("checked", true);
			});
			$("[name='<?php echo $this->get_field_name('time_format_custom'); ?>']").on('change', function(){
				var format = $(this).val();
				var self = $(this);
				$.ajax({
						url: ajaxurl,
						type: 'post',
						data: {
							action: 'time_format',
							date: format
						},
						success: function(data){
							self.next().html(data);
						}
				});
			});
			$("#<?php echo $this->get_field_id('display_settings');?>").change(function(){
				if($(this).val()=="all")
					$(this).parent().next().css("display", "block");
				else
					$(this).parent().next().css("display", "none");
			});
			//colorpicker
			if($(".color").length)
			{
				$(".color").ColorPicker({
					onChange: function(hsb, hex, rgb, el) {
						$(el).val(hex);
						$(el).prev(".color_preview").css("background-color", "#" + hex);
					},
					onSubmit: function(hsb, hex, rgb, el){
						$(el).val(hex);
						$(el).ColorPickerHide();
					},
					onBeforeShow: function (){
						var color = (this.value!="" ? this.value : $(this).attr("data-default-color"));
						$(this).ColorPickerSetColor(color);
						$(this).prev(".color_preview").css("background-color", color);
					}
				}).on('keyup', function(event, param){
					$(this).ColorPickerSetColor(this.value);
					
					var default_color = ($("#color_scheme").val()!="blue" && typeof($(this).attr("data-default-color-" + $("#color_scheme").val()))!="undefined" ? $(this).attr("data-default-color-" + $("#color_scheme").val()) : $(this).attr("data-default-color"));
					$(this).prev(".color_preview").css("background-color", (this.value!="none" ? (this.value!="" ? "#" + (typeof(param)=="undefined" ? $(".colorpicker:visible .colorpicker_hex input").val() : this.value) : (default_color!="transparent" ? "#" + default_color : default_color)) : "transparent"));
				});
			}
		});
		</script>
		<?php
	}
}
//register widget
add_action('widgets_init', create_function('', 'return register_widget("tt_upcoming_events_widget");'));
?>