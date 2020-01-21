<?php
/**
 * Remove Gutenberg CSS
 */
add_action(
	'wp_enqueue_scripts',
	function () {
		wp_dequeue_style( 'wp-block-library' );
		wp_dequeue_style( 'wp-block-library-theme' );
	}
);
/**
 * Add Gutenberg features
 */
function gb_setup_theme_supported_features() {
	// Adds default styles to custom blocks
	add_theme_support( 'wp-block-styles' );
	// Supports wide images, galleries and videos.
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );
} // eof
add_action( 'after_setup_theme', 'gb_setup_theme_supported_features' );

/**
 * Setup theme colour swatches
 */
function gb_setup_theme_colors() {
	// remove custom colour picker
	add_theme_support( 'disable-custom-colors' );
	// add the custom colours
	add_theme_support(
		'editor-color-palette',
		array(
			array(
				'name'  => __( 'White' ),
				'slug'  => 'plain-white',
				'color' => '#FFFFFF',
			),
			array(
				'name'  => __( 'Off White' ),
				'slug'  => 'off-white',
				'color' => '#f8f9fe',
			),
			array(
				'name'  => __( 'Black' ),
				'slug'  => 'black',
				'color' => '#000000',
			),
			array(
				'name'  => __( 'Dark Gray' ),
				'slug'  => 'dark-gray',
				'color' => '#4a4a4a',
			),
			array(
				'name'  => __( 'Gray 400' ),
				'slug'  => 'gray-400',
				'color' => '#929292',
			),
			array(
				'name'  => __( 'Blue 700' ),
				'slug'  => 'dark-700',
				'color' => '#2c2f3d',
			),
			array(
				'name'  => __( 'Blue 500' ),
				'slug'  => 'blue-500',
				'color' => '#1b77ea',
			),
			array(
				'name'  => __( 'Blue 400' ),
				'slug'  => 'blue-400',
				'color' => '#2184ff',
			),
			array(
				'name'  => __( 'Blue 300' ),
				'slug'  => 'blue-300',
				'color' => '#bcdaff',
			),
			array(
				'name'  => __( 'Orange 400' ),
				'slug'  => 'orange-400',
				'color' => '#ff9d40',
			),
		)
	);
	// after adding here, add to colour options in SCSS file so the reference matches up
}
add_action( 'after_setup_theme', 'gb_setup_theme_colors' );

/**
 * Setup Gutenberg fonts and sizes
 */
function gb_setup_theme_fonts() {
	// removes custom font sizes
	add_theme_support( 'disable-custom-font-sizes' );
	add_theme_support(
		'editor-font-sizes',
		array(
			array(
				'name' => __( 'Small', 'resumecompanion' ),
				'size' => 12,
				'slug' => 'small',
			),
			array(
				'name' => __( 'Normal', 'resumecompanion' ),
				'size' => 18,
				'slug' => 'normal',
			),
			array(
				'name' => __( 'Large', 'resumecompanion' ),
				'size' => 36,
				'slug' => 'large',
			),
			array(
				'name' => __( 'Huge', 'resumecompanion' ),
				'size' => 50,
				'slug' => 'huge',
			),
		)
	);
}
add_action( 'after_setup_theme', 'gb_setup_theme_fonts' );

/**
 * Gutenberg Fonts and Styles in Admin
 */
function fonts_enqueue_gutenberg() {
	wp_register_style( 'gutenberg-fonts', 'https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,600,700,800&display=swap' );
	wp_enqueue_style( 'gutenberg-fonts' );
	// if you need to setup admin specific css + add to gulp
	// if ( WP_DEBUG == true ) {
	// ** use un minified for testing, minified for build */
	// wp_enqueue_style( 'site-block-editor-styles', get_theme_file_uri( '/build/css/admin.css' ), false, '1.0', 'all' );
	// } else {
	// wp_enqueue_style( 'site-block-editor-styles', get_theme_file_uri( '/build/css/admin.min.css' ), false, '1.0', 'all' );
	// }
}
add_action( 'enqueue_block_editor_assets', 'fonts_enqueue_gutenberg' );

/**
 * Register custom blocks script
 */
function ttp_gutenberg_register_files() {
	// script file
	if ( WP_DEBUG == true ) {
		wp_register_script(
			'ttp-block-script',
			get_stylesheet_directory_uri() . '/build/blocks.js',
			array( 'wp-blocks', 'wp-edit-post' )
		);
	} else {
		wp_register_script(
			'ttp-block-script',
			get_stylesheet_directory_uri() . '/build/blocks.min.js',
			array( 'wp-blocks', 'wp-edit-post' )
		);
	}
	// register block editor script
	register_block_type(
		'ttp/ma-block-files',
		array(
			'editor_script' => 'ttp-block-script',
		)
	);
}
add_action( 'init', 'ttp_gutenberg_register_files' );


/**
 * Allowed Blocks List (others not styled)
 */
function ttp_allowed_block_types( $allowed_blocks ) {
	return array(
		'core/image',
		'core/paragraph',
		'core/heading',
		'core/list',
		'core/button',
		'core/layout',
		'core/group',
		'core/columns',
		'core/text-columns',
		'core/separator',
		'core/shortcode',
		'core/spacer',
		'core/cover',
		'core/media-text',
	// 'acf/template-grid-row'
	);
}
add_filter( 'allowed_block_types', 'ttp_allowed_block_types' );
