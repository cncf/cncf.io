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
			'name'     => __( 'James Blue to Blue' ),
			'slug'     => 'blue-to-blue',
			'gradient' => 'linear-gradient(135deg,rgba(0,100,100,1) 0%,rgba(200,200,200,1) 100%)',
		),
	)
);
