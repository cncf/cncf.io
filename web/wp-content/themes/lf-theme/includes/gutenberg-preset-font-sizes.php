<?php
/**
 * Gutenberg Preset Font Sizes
 *
 * Specify custom preset font sizes.
 *
 * After adding here, make sure your CSS for frontend and backend matches the rules that are generated.
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

add_theme_support(
	'editor-font-sizes',
	array(
		array(
			'name' => __( 'Smallest' ),
			'size' => 13,
			'slug' => 'smallest',
		),
		array(
			'name' => __( 'Small' ),
			'size' => 14,
			'slug' => 'small',
		),
		array(
			'name' => __( 'Normal' ),
			'size' => 16,
			'slug' => 'normal',
			'isdefault' => true,
		),
		array(
			'name' => __( 'H5 Size' ),
			'size' => 18,
			'slug' => 'header-5',
		),
		array(
			'name' => __( 'H4 Size' ),
			'size' => 20,
			'slug' => 'header-4',
		),
		array(
			'name' => __( 'H3' ),
			'size' => 24,
			'slug' => 'header-3',
		),
		array(
			'name' => __( 'H2' ),
			'size' => 36,
			'slug' => 'header-2',
		),
		array(
			'name' => __( 'Huge' ),
			'size' => 50,
			'slug' => 'huge',
		),
	)
);
