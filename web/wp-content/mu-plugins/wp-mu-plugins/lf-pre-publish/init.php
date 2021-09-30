<?php
/**
 * Blocks Initializer
 *
 * @since   1.0.0
 * @package WordPress
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue Gutenberg asset for backend.
 */
function lf_ppc_block_editor_assets() {
	wp_enqueue_script(
		'pre-publish-checklist',
		plugins_url( 'lf-pre-publish/build/index.js', dirname( __FILE__ ) ),
		is_admin() ? array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-dom-ready', 'wp-data', 'wp-dom', 'word-count' ) : null,
		filemtime( plugin_dir_path( __DIR__ ) . 'lf-pre-publish/build/index.js' ),
		true
	);
}
add_action( 'enqueue_block_editor_assets', 'lf_ppc_block_editor_assets' );
