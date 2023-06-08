<?php
/**
 * Event Banner - Multiple
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

// load slick css.
wp_enqueue_style( 'slick-css', get_template_directory_uri() . '/build/slick.min.css', array(), filemtime( get_template_directory() . '/build/slick.min.css' ), 'all' );

// load main slick.
wp_enqueue_script( 'slick', get_template_directory_uri() . '/source/js/libraries/slick.min.js', array( 'jquery' ), filemtime( get_template_directory() . '/source/js/libraries/slick.min.js' ), true );

// load slick events config.
wp_enqueue_script( 'slick-events-config', get_template_directory_uri() . '/source/js/on-demand/slick-events-config.js', array( 'jquery', 'slick' ), filemtime( get_template_directory() . '/source/js/on-demand/slick-events-config.js' ), true );

$the_query  = $args['the_query'];
$hide_title = $args['hide_title'];

if ( ! $hide_title ) {
	?>
<h3 class="has-normal-font-size header-lines">Upcoming Events</h3>
	<?php
}
?>
<div class="home-events-slider">
	<?php
	while ( $the_query->have_posts() ) {
		$the_query->the_post();
		get_template_part( 'components/event-banner' );
	}
	?>
</div>
<?php
if ( ! $hide_title ) {
	?>
<div style="height:40px" aria-hidden="true" class="wp-block-spacer"></div>
<div class="wp-block-separator is-style-thin-line"></div>
	<?php
}
?>
<?php // Keep this spacer as its conditionally needed based on an event being displayed. ?>
<div style="height:100px" aria-hidden="true"
	class="wp-block-spacer is-style-60-100"></div>
