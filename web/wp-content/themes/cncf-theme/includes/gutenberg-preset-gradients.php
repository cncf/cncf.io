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
	'__experimental-editor-gradient-presets',
	array(
		array(
			'name'     => __( 'Vivid cyan blue to vivid purple' ),
			'slug'     => 'vivid-cyan-blue-to-vivid-purple',
			'gradient' => 'linear-gradient(135deg,rgba(6,147,227,1) 0%,rgb(155,81,224) 100%)',
		),
		array(
			'name'     => __( 'Vivid green cyan to vivid cyan blue' ),
			'slug'     => 'vivid-green-cyan-to-vivid-cyan-blue',
			'gradient' => 'linear-gradient(135deg,rgba(0,208,132,1) 0%,rgba(6,147,227,1) 100%)',
		),
		array(
			'name'     => __( 'Red to Blue' ),
			'slug'     => 'red-to-blue',
			'gradient' => 'linear-gradient(135deg,rgba(0,208,100,1) 0%,rgba(6,147,200,1) 100%)',
		),
	)
);
