<?php
/**
 * Excerpts
 *
 * Different options to dealing with excerpts.
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

/**
 * Sets the default excerpt length.
 *
 * @param int $length Number of words.
 */
function custom_excerpt_length( $length ) {
	 return 40;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

/**
 * Sets default custom excerpt ellipsis.
 *
 * @param string $more Ending.
 */
function custom_excerpt_more( $more ) {
	return '...';
}
add_filter( 'excerpt_more', 'custom_excerpt_more' );
