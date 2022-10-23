<?php
/**
 * ACF
 *
 * Registers ACF-related code.
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register all our custom ACF blocks.
 *
 * @return void
 */
function lf_register_all_our_blocks() {
	// Return early if this function does not exist.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	$blocks_directory = new RecursiveDirectoryIterator( get_template_directory() . '/blocks/' );

	$blocks_to_register = array();

	foreach ( new RecursiveIteratorIterator( $blocks_directory ) as $files ) {
		if ( $files->getFileName() === 'block.json' ) {
			array_push( $blocks_to_register, $files->getPathname() );
		}
	}

	$blocks_to_register = array_unique( $blocks_to_register );

	if ( count( $blocks_to_register ) > 0 ) {
		foreach ( $blocks_to_register as $block ) {
			register_block_type( $block );
		}
	}
}
add_action( 'init', 'lf_register_all_our_blocks' );
