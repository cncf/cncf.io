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
	register_block_type( $block_directory . '/gallery-outlined-grid/block.json' );
	register_block_type( $block_directory . '/icon-text-stat/block.json' );
	register_block_type( $block_directory . '/post-breadcrumb/block.json' );
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

/**
 * Create new settings page using ACF
 *
 * @return void
 */
function lf_custom_settings_pages() {

	if ( function_exists( 'acf_add_options_page' ) ) {

		acf_add_options_sub_page(
			array(
				'page_title'  => 'Phippy',
				'menu_title'  => 'Phippy',
				'parent_slug' => 'lf-mu',
			)
		);
	}
}
add_action( 'acf/init', 'lf_custom_settings_pages' );
