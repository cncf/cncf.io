<?php
/**
 * Latest News
 *
 * Usage:
 * [latest_news]
 *
 * Used on front page only.
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

/**
 * Latest news shortcode.
 *
 * @param array $atts Attributes.
 */
function add_latest_news_shortcode( $atts ) {

	// Attributes.
	$atts = shortcode_atts(
		array(),
		$atts,
		'latest_news'
	);

	ob_start();
	get_template_part( 'components/latest-news-horizontal' );
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'latest_news', 'add_latest_news_shortcode' );
