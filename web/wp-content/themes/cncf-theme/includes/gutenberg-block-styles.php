<?php
/**
 * Gutenberg Block Styles
 *
 * Specify custom block styles
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

/**
 * Block Template basic setup
 */
function slug_post_type_template() {
	$page_type_object           = get_post_type_object( 'page' );
	$page_type_object->template = array(
		array(
			'core/heading',
			array(
				'level'   => '1',
				'content' => 'Title of page',
				'className' => 'is-style-max-900',
			),
		),
		array( 'core/paragraph' ),
		array(
			'core/heading',
			array(
				'level'   => '2',
				'content' => 'Sub header',
			),
		),
		array( 'core/paragraph' ),
	);
};
add_action( 'init', 'slug_post_type_template' );
