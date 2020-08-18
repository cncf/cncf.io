<?php
/**
 * Gutenberg Preset Gradients
 *
 * Specify custom gradients.
 *
 * After adding here, make sure your CSS for frontend and backend matches the rules that are generated. To disable the custom opionated gradients you need to specify at least one custom gradient.
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

add_theme_support(
	'editor-gradient-presets',
	array(
		array(
			'name'     => __( 'Gradients Aren\'t Cool' ),
			'slug'     => 'is-black',
			'gradient' => 'linear-gradient(90deg, #000000 0, #000000 100%)',
		),
	)
);
