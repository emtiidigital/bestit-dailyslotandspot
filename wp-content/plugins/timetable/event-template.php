<?php
/*
Template Name: Timetable Event
*/
get_header(); 
?>
<div class="tt_event_theme_page timetable_clearfix">
	<div class="tt_event_page_left">
		<?php
			the_post_thumbnail("event-post-thumb", array("alt" => get_the_title(), "title" => ""));
		?>
		<h2><?php the_title();?></h2>
		<?php
		$subtitle = get_post_meta(get_the_ID(), "timetable_subtitle", true);
		if($subtitle!=""):
		?>
			<h5><?php echo $subtitle; ?></h5>
		<?php
		endif;
		if(have_posts()) : while (have_posts()) : the_post();
			echo apply_filters('the_content', tt_remove_wpautop(get_the_content()));
		endwhile; endif;
		?>
	</div>
	<?php if(is_active_sidebar('sidebar-event')): ?>
	<div class="tt_event_page_right">
		<?php
			dynamic_sidebar('sidebar-event');
		?>
	</div>
	<?php endif; ?>
</div>
<?php
get_footer();
?>