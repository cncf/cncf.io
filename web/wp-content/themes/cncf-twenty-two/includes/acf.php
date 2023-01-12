<?php
/**
 * ACF
 *
 * Registers ACF-related code.
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register all our custom ACF blocks.
 *
 * @return void
 */
function lf_register_all_our_blocks() {
	$block_directory = get_template_directory() . '/blocks';
	register_block_type( $block_directory . '/gallery-slider/block.json' );
	register_block_type( $block_directory . '/quote-with-quote-mark/block.json' );
	register_block_type( $block_directory . '/section-header/block.json' );
	// if ( get_post_type() == 'lf_report' ) {

	// }
}
add_action( 'init', 'lf_register_all_our_blocks' );

/**
 * Remove ACF Shortcode option (for security)
 *
 * See https://www.advancedcustomfields.com/blog/acf-6-0-3-release-security-changes-to-the-acf-shortcode-and-ui-improvements/
 *
 * @return void
 */
function lf_set_acf_settings() {
	acf_update_setting( 'enable_shortcode', false );
}
add_action( 'acf/init', 'lf_set_acf_settings' );