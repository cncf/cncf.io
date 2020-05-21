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

// Supports wide blocks (100% width).
add_theme_support( 'align-wide' );

// changes embeds to fit aspect ratio.
add_theme_support( 'responsive-embeds' );

// remove custom color picker.
add_theme_support( 'disable-custom-colors' );

// add preset custom colors.
require_once 'gutenberg-preset-colors.php';

// Add preset gradients.
require_once 'gutenberg-preset-gradients.php';

// Disable custom gradient creation.
add_theme_support( 'disable-custom-gradients' );

// Disable custom font sizes.
add_theme_support( 'disable-custom-font-sizes' );

// add preset font sizes.
require_once 'gutenberg-preset-font-sizes.php';

// include custom block styles.
require_once 'gutenberg-block-styles.php';

// Remove Block Editor basic theme styles.
add_action(
	'wp_print_styles',
	function (): void {
		wp_dequeue_style( 'wp-block-library-theme' );
	}
);
