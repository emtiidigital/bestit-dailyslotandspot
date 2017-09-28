<?php
function tt_remove_wpautop($content) 
{
  return do_shortcode(shortcode_unautop($content));
}

//items list
function tt_event_items_list($atts, $content)
{
	extract(shortcode_atts(array(
		"class" => "",
	), $atts));
	
	$output = '';
	$output .= '
	<ul class="tt_event_items_list' . ($class!='' ? ' ' . $class : '') . '">
		' . tt_remove_wpautop($content) . '
	</ul>';
	return $output;
}
add_shortcode("tt_items_list", "tt_event_items_list");

//items list
function tt_event_item($atts, $content)
{
	extract(shortcode_atts(array(
		"type" => "",
		"border_color" => "",
		"text_color" => "",
		"value" => ""
	), $atts));
	
	$output = '';
	$output .= '
	<li' . ($type=="info" ? ' class="timetable_clearfix type_info"' : '') . ($border_color!='' ? ' style="border-bottom: ' . ($border_color=='none' ? 'none' : '1px solid #' . $border_color . '') . ';"' : '') . '>
		<' . ($type=="info" ? 'label' : 'span') . ($text_color!='' ? ' style="color: #' . $text_color . ';"' : '') . '>' . tt_remove_wpautop($content) . '</' . ($type=="info" ? 'label' : 'span') . '>';
		if($value!="")
			$output .= '<div class="tt_event_text">' . $value . '</div>';
	$output .= '
	</li>';
	return $output;
}
add_shortcode("tt_item", "tt_event_item");

//columns
function tt_event_columns($atts, $content)
{	
	extract(shortcode_atts(array(
		"class" => ""
	), $atts));
	return '<div class="tt_event_columns' . ($class!='' ? ' ' . $class : '') . '">' . tt_remove_wpautop($content) . '</div>';
}
add_shortcode("tt_columns", "tt_event_columns");

//column left
function tt_event_column_left($atts, $content)
{
	return '<div class="tt_event_column_left">' . tt_remove_wpautop($content) . '</div>';
}
add_shortcode("tt_column_left", "tt_event_column_left");

//column right
function tt_event_column_right($atts, $content)
{
	return '<div class="tt_event_column_right">' . tt_remove_wpautop($content) . '</div>';
}
add_shortcode("tt_column_right", "tt_event_column_right");

//event hours
function tt_event_hours($atts, $content)
{
	global $post;
	extract(shortcode_atts(array(
		"event_id" => $post->ID,
		"title" => "Event Hours",
		"time_format" => "H.i",
		"class" => "",
		"hour_category" => "",
		"text_color" => "",
		"border_color" => "",
		"columns" => ""
	), $atts));
	
	if($hour_category!=null && $hour_category!="-")
		$hour_category = array_values(array_diff(array_filter(array_map('trim', explode(",", $hour_category))), array("-")));
		
	if($columns!="")
	{
		$weekdays_explode = explode(",", $columns);
		$weekdays_in_query = "";
		foreach($weekdays_explode as $weekday_explode)
			$weekdays_in_query .= "'" . $weekday_explode . "'" . ($weekday_explode!=end($weekdays_explode) ? "," : "");
	}
	
	global $wpdb;
	$output = '';
	//The actual fields for data entry
	$query = "SELECT * FROM `" . $wpdb->prefix . "event_hours` AS t1 LEFT JOIN {$wpdb->posts} AS t2 ON t1.weekday_id=t2.ID 
		WHERE t1.event_id='" . (int)$event_id . "'";
		if($hour_category!=null && $hour_category!="-")
		$query .= "
			AND t1.category IN('" . join("','", $hour_category) . "')";
	if(isset($weekdays_in_query) && $weekdays_in_query!="")
		$query .= " AND t2.post_name IN(" . $weekdays_in_query . ")";
	$query .= " ORDER BY t2.menu_order, t1.start, t1.end";
	$event_hours = $wpdb->get_results($query);
	$event_hours_count = count($event_hours);
	
	if($event_hours_count)
	{
		//get weekdays
		$query = "SELECT ID, post_title FROM {$wpdb->posts}
				WHERE 
				post_type='timetable_weekdays'
				ORDER BY menu_order";
		$weekdays = $wpdb->get_results($query);
		if($title!="")
			$output .= '<h3 class="tt_event_margin_top_27">' . $title . '<span class="tt_event_hours_count">(' . $event_hours_count . ')</span></h3>';
		$output .= '
		<ul id="event_hours_list" class="timetable_clearfix tt_event_hours' . ($class!="" ? ' ' . $class : '') . '">';
			for($i=0; $i<$event_hours_count; $i++)
			{
				//get event color
				if($border_color=="")
					$border_color = "#" . get_post_meta($event_hours[$i]->event_id, "timetable_color", true);
				//get day by id
				$current_day = get_post($event_hours[$i]->weekday_id);
				$output .= '<li' . ($border_color!="" ? ' style="border-left-color:' . $border_color . ';"' : '') . ' id="event_hours_' . $event_hours[$i]->event_hours_id . '" class="event_hours_' . ($i%2==0 ? 'left' : 'right') . '"><h4' . ($text_color!="" ? ' style="color:' . $text_color . ';"' : '') . '>' . $current_day->post_title . '</h4><h4' . ($text_color!="" ? ' style="color:' . $text_color . ';"' : '') . '>' . date($time_format, strtotime($event_hours[$i]->start)) . ' - ' . date($time_format, strtotime($event_hours[$i]->end)) . '</h4>';
				if($event_hours[$i]->before_hour_text!="" || $event_hours[$i]->after_hour_text!="")
				{
					$output .= '<p' . ($text_color!="" ? ' style="color:' . $text_color . ';"' : '') . ' class="tt_event_padding_bottom_0">';
					if($event_hours[$i]->before_hour_text!="")
						$output .= $event_hours[$i]->before_hour_text;
					if($event_hours[$i]->after_hour_text!="")
						$output .= ($event_hours[$i]->before_hour_text!="" ? '<br>' : '') . $event_hours[$i]->after_hour_text;
					$output .= '</p>';
				}
				$output .= '</li>';
			}
		$output .= '</ul>';
	}
	return $output;
}
add_shortcode("tt_event_hours", "tt_event_hours");
?>