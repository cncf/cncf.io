<?php
/**
 * Blocks Initializer
 *
 * Enqueue CSS/JS of all the blocks.
 *
 * @since   1.0.0
 * @package CGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue Gutenberg block assets for frontend and backend.
 *
 * Assets enqueued:
 * 1. blocks.style.build.css - Frontend + Backend.
 *
 * @uses {wp-editor} for WP editor styles.
 * @since 1.0.0
 */
function lf_cncf_blocks_frontend_assets() {
	// Register block styles for both frontend + backend.

	/*
	// Exclude the enqueue - styles covered in theme.
	wp_enqueue_style(
		'lf_cncf_blocks_style',
		plugins_url( 'dist/blocks.style.build.css', dirname( __FILE__ ) ),
		is_admin() ? array( 'wp-editor' ) : null,
		filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.style.build.css' )
	);
	*/

	if ( has_block( 'lf/twitter-feed' ) ) {
		wp_enqueue_script(
			'twitter-feed',
			'//platform.twitter.com/widgets.js',
			is_admin() ? array( 'wp-editor' ) : null,
			filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.build.js' ),
			true
		);
	}
}
add_action( 'enqueue_block_assets', 'lf_cncf_blocks_frontend_assets' );

/**
 * Enqueue Gutenberg block assets for backend.
 *
 * Assets enqueued:
 * 1. blocks.build.js - Backend.
 * 2. blocks.editor.build.css - Backend.
 *
 * @uses {wp-blocks} for block type registration & related functions.
 * @uses {wp-element} for WP Element abstraction — structure of blocks.
 * @uses {wp-i18n} to internationalize the block's text.
 * @uses {wp-editor} for WP editor styles.
 * @since 1.0.0
 */
function lf_cncf_blocks_editor_assets() {
	// Register block editor script for backend.
	wp_enqueue_script(
		'lf_cncf_blocks_script',
		plugins_url( '/dist/blocks.build.js', dirname( __FILE__ ) ),
		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ),
		filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.build.js' ),
		true
	);
	// Register block editor styles for backend.
	wp_enqueue_style(
		'lf_cncf_blocks_editor_style',
		plugins_url( 'dist/blocks.editor.build.css', dirname( __FILE__ ) ),
		array( 'wp-edit-blocks' ),
		filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.editor.build.css' )
	);
	// WP Localized globals. Use dynamic PHP stuff in JavaScript via `cgbGlobal` object.
	// phpcs:disable
	wp_localize_script(
		'lf_cncf_blocks_script',
		'cgbGlobal', // Array containing dynamic data for a JS Global.
		[
			'pluginDirPath' => plugin_dir_path( __DIR__ ),
			'pluginDirUrl'  => plugin_dir_url( __DIR__ ),
		   // Add more data here that you want to access from `cgbGlobal` object.
		]
	);
	// phpcs:enable

}
add_action( 'enqueue_block_editor_assets', 'lf_cncf_blocks_editor_assets' );

/**
 * Register Dynamic Blocks
 *
 * @since 1.0.0
 */
function lf_cncf_blocks_register_dynamic_blocks() {

	// Upcoming Webinars Block.
	require_once 'upcoming-webinars/render-callback.php';
	register_block_type(
		'lf/upcoming-webinars',
		array(
			'attributes'      => array(
				'className' => array(
					'type' => 'string',
				),
			),
			'render_callback' => 'lf_upcoming_webinars_render_callback',
		)
	);

	// Upcoming Events Block.
	require_once 'upcoming-events/render-callback.php';
	register_block_type(
		'lf/upcoming-events',
		array(
			'attributes'      => array(
				'className' => array(
					'type' => 'string',
				),
			),
			'render_callback' => 'lf_upcoming_events_render_callback',
		)
	);

	// Twitter Feed block.
	require_once 'twitter-feed/render-callback.php';
	register_block_type(
		'lf/twitter-feed',
		array(
			'attributes'      => array(
				'className' => array(
					'type' => 'string',
				),
			),
			'render_callback' => 'lf_twitter_feed_render_callback',
		)
	);

	// Newsroom Block.
	require_once 'newsroom/render-callback.php';
	register_block_type(
		'lf/newsroom',
		array(
			'attributes'      => array(
				'className'  => array(
					'type' => 'string',
				),
				'showImages' => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'order'      => array(
					'type' => 'string',
				),
				'category'   => array(
					'type' => 'string',
				),
			),
			'render_callback' => 'lf_newsroom_render_callback',
		)
	);

}
add_action( 'init', 'lf_cncf_blocks_register_dynamic_blocks' );

/**
 * Add custom block category
 *
 * This makes a new category selection in the Block Editor called CNCF.
 *
 * @param array $categories List of categories.
 */
function cncf_block_categories( $categories ) {
	$category_slugs = wp_list_pluck( $categories, 'slug' );
	return in_array( 'cncf', $category_slugs, true ) ? $categories : array_merge(
		array(
			array(
				'slug'  => 'cncf',
				'title' => __( 'CNCF' ),
				'icon'  => null,
			),
		),
		$categories
	);
}
add_filter( 'block_categories', 'cncf_block_categories' );
