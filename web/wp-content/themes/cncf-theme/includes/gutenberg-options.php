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
 * Allowed Blocks List (others not styled)
 *
 * @param array $allowed_blocks Blocks array.
 */
function ttp_allowed_block_types( $allowed_blocks ) {
	return array(
		'core/image',
		'core/paragraph',
		'core/heading',
		'core/list',
		'core/button',
		'core/layout',
		'core/group',
		'core/columns',
		'core/text-columns',
		'core/separator',
		'core/shortcode',
		'core/spacer',
		'core/cover',
		'core/media-text',
	);
}
// add_filter( 'allowed_block_types', 'ttp_allowed_block_types' ); // phpcsignore.
