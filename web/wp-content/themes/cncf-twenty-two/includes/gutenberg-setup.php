<?php
/**
 * Gutenberg Setup
 *
 * Setup Block Editor and options as part of after_setup_theme
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

// Adds default styles to blocks.
add_theme_support( 'wp-block-styles' );

// changes embeds to fit aspect ratio.
add_theme_support( 'responsive-embeds' );

// Disable core block patterns.
remove_theme_support( 'core-block-patterns' );

// Disable new gutenberg widget screen.
remove_theme_support( 'widgets-block-editor' );

// Remove duotone SVG filter injection.
remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );

// Remove the absolutely terrible dropcap option.
add_filter(
	'block_editor_settings_all',
	function ( $editor_settings ) {
		$editor_settings['__experimentalFeatures']['typography']['dropCap'] = false;
		return $editor_settings;
	}
);

// Custom line height.
add_theme_support( 'custom-line-height' );
