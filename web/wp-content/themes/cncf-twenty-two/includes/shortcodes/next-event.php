<?php
/**
 * Next Event
 *
 * Usage:
 *
 * [next_event]
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

/**
 * Next Event shortcode.
 */
function add_next_event_shortcode() {

	ob_start();
	get_template_part( 'components/next-event' );
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'next_event', 'add_next_event_shortcode' );
