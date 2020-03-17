<?php
/**
 * Gutenberg Preset Gradients
 *
 * Specify custom gradients.
 *
 * After adding here, make sure your CSS for frontend and backend matches the rules that are generated.
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

add_theme_support(
	'editor-gradient-presets',
	array(
		array(
			'name'     => __( 'Pink to Purple' ),
			'slug'     => 'pink-to-purple',
			'gradient' => 'linear-gradient(90deg, #e00a6b 0, #c80e6a 7.28%, #971667 24.1%, #6d1d64 40.76%, #4d2262 56.93%, #362661 72.49%, #292860 87.15%, #242960 100%)',
		),
	)
);
