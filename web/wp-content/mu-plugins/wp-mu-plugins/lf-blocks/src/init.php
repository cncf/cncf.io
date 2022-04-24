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
 * @since 1.0.0
 */
function lf_blocks_frontend_assets() {
	// Register block styles for both frontend + backend.

	if ( has_block( 'lf/landscape' ) ) {
		wp_enqueue_script(
			'landscape-resize',
			'//landscape.cncf.io/iframeResizer.js',
			array( 'jquery' ),
			filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.build.js' ),
			true
		);
	}

	if ( has_block( 'lf/youtube-lite' ) ) {
		wp_enqueue_script(
			'youtube-lite-js',
			plugins_url( '/src/youtube-lite/scripts/lite-youtube.js', dirname( __FILE__ ) ),
			null,
			filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.build.js' ),
			true
		);
	}
}
add_action( 'enqueue_block_assets', 'lf_blocks_frontend_assets' );

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
 * @since 1.0.0
 */
function lf_blocks_editor_assets() {

	// Register block editor script for backend.
	wp_enqueue_script(
		'lf_blocks_script',
		plugins_url( '/dist/blocks.build.js', dirname( __FILE__ ) ),
		array( 'wp-blocks', 'wp-i18n', 'wp-element' ),
		filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.build.js' ),
		true
	);

	// Register block editor styles for backend.
	wp_enqueue_style(
		'lf_blocks_editor_style',
		plugins_url( 'dist/blocks.editor.build.css', dirname( __FILE__ ) ),
		null,
		filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.editor.build.css' )
	);

}
add_action( 'enqueue_block_editor_assets', 'lf_blocks_editor_assets' );

/**
 * Register Dynamic Blocks
 *
 * @since 1.0.0
 */
function lf_blocks_register_dynamic_blocks() {

	// Case Studies Block.
	require_once 'case-studies/render-callback.php';
	register_block_type(
		'lf/case-studies',
		array(
			'attributes'      => array(
				'className'   => array(
					'type' => 'string',
				),
				'numberposts' => array(
					'type' => 'number',
				),
			),
			'render_callback' => 'lf_case_studies_render_callback',
		)
	);

	// Case Study Highlights block.
	require_once 'case-study-highlights/render-callback.php';
	register_block_type(
		'lf/case-study-highlights',
		array(
			'attributes'      => array(
				'className'     => array(
					'type' => 'string',
				),
				'headingText01' => array(
					'type' => 'string',
				),
				'headingText02' => array(
					'type' => 'string',
				),
				'headingText03' => array(
					'type' => 'string',
				),
				'smallerText01' => array(
					'type' => 'string',
				),
				'smallerText02' => array(
					'type' => 'string',
				),
				'smallerText03' => array(
					'type' => 'string',
				),
			),
			'render_callback' => 'lf_case_study_highlights_render_callback',
		)
	);

	// Case Study Overview block.
	require_once 'case-study-overview/render-callback.php';
	register_block_type(
		'lf/case-study-overview',
		array(
			'attributes'      => array(
				'className' => array(
					'type' => 'string',
				),
			),
			'render_callback' => 'lf_case_study_overview_render_callback',
		)
	);

	// Hero block.
	require_once 'hero/render-callback.php';
	register_block_type(
		'lf/hero',
		array(
			'attributes'      => array(
				'className' => array(
					'type' => 'string',
				),
			),
			'render_callback' => 'lf_hero_render_callback',
		)
	);

	// iFrame block.
	register_block_type(
		'lf/iframe',
		array(
			'attributes' => array(
				'className' => array(
					'type' => 'string',
				),
			),
		),
	);

	// Landscape block.
	require_once 'landscape/render-callback.php';
	register_block_type(
		'lf/landscape',
		array(
			'attributes'      => array(
				'className' => array(
					'type' => 'string',
				),
			),
			'render_callback' => 'lf_landscape_render_callback',
		),
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
				'showBorder' => array(
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

	// Tab Container block.
	register_block_type(
		'lf/tab-container-block',
		array(
			'attributes' => array(
				'className' => array(
					'type' => 'string',
				),
				'menuTitle' => array(
					'type' => 'string',
				),
				'id'        => array(
					'type' => 'string',
				),
			),
		),
	);

	// YouTube Lite block.
	register_block_type(
		'lf/youtube-lite',
		array(
			'attributes' => array(
				'className' => array(
					'type' => 'string',
				),
			),
		),
	);
}
add_action( 'init', 'lf_blocks_register_dynamic_blocks' );

/**
 * Add custom block category
 *
 * This makes a new category selection in the Block Editor called LF.
 *
 * @param array $categories List of categories.
 */
function add_lf_block_categories( $categories ) {
	$category_slugs = wp_list_pluck( $categories, 'slug' );
	return in_array( 'lf', $category_slugs, true ) ? $categories : array_merge(
		array(
			array(
				'slug'  => 'lf',
				'title' => __( 'LF' ),
				'icon'  => null,
			),
		),
		$categories
	);
}
add_filter( 'block_categories_all', 'add_lf_block_categories' );



function lf_register_meta() {
    register_post_meta(
        'lf_case_study',
        'lf_case_study_long_title',
        [
            'show_in_rest' => true,
            'single'       => true,
            'type'         => 'string',
        ]
    );
}
add_action( 'init', 'lf_register_meta');
