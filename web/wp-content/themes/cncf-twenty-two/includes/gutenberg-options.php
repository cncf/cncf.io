<?php
/**
 * Gutenberg Options
 *
 * Additional settings and functions for Gutenberg
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

/**
 * Register a custom block pattern category
 *
 * @return void
 */
function lf_register_block_pattern_category() {
	register_block_pattern_category(
		'lf/pjr',
		array(
			'label' => __( 'Project Journey' ),
		)
	);
	register_block_pattern_category(
		'lf/pages',
		array(
			'label' => __( 'Pages' ),
		)
	);
}
add_action( 'init', 'lf_register_block_pattern_category' );
