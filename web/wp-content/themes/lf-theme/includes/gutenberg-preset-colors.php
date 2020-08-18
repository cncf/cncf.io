<?php
/**
 * Gutenberg Preset Colors
 *
 * Specify custom color swatches.
 *
 * After adding here, make sure your CSS for frontend and backend matches the rules that are generated. This should also match what is in _colors.scss as this is how the styles are generated.
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

add_theme_support(
	'editor-color-palette',
	array(
		array(
			'name'  => __( 'Pink' ),
			'slug'  => 'pink-400',
			'color' => '#DE176C',
		),
		array(
			'name'  => __( 'Purple' ),
			'slug'  => 'purple-700',
			'color' => '#2C2960',
		),
		array(
			'name'  => __( 'Blue (Light)' ),
			'slug'  => 'blue-100',
			'color' => '#F0F5F7',
		),
		array(
			'name'  => __( 'Blue' ),
			'slug'  => 'tertiary-400',
			'color' => '#436ca9',
		),
		array(
			'name'  => __( 'White' ),
			'slug'  => 'white',
			'color' => '#FFFFFF',
		),
		array(
			'name'  => __( 'Black' ),
			'slug'  => 'black',
			'color' => '#202020',
		),
	)
);
