<?php
/**
 * Gutenberg Preset Font Sizes
 *
 * Specify custom preset font sizes.
 *
 * After adding here, make sure your CSS for frontend and backend matches the rules that are generated.
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

add_theme_support(
	'editor-font-sizes',
	array(
		array(
			'name' => __( 'Small' ),
			'size' => 13,
			'slug' => 'small',
		),
		array(
			'name' => __( 'Normal' ),
			'size' => 16,
			'slug' => 'normal',
		),
		array(
			'name' => __( 'Large' ),
			'size' => 22,
			'slug' => 'large',
		),
		array(
			'name' => __( 'Huge' ),
			'size' => 50,
			'slug' => 'huge',
		),
		array(
			'name' => __( 'Testing' ),
			'size' => 60,
			'slug' => 'ext-large',
		),
	)
);
