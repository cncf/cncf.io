<?php
/**
 * Excertps
 *
 * Different options to dealing with excerpts.
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

/**
 * Sets the excerpt length.
 *
 * @param int $length Number of words.
 */
function custom_excerpt_length( $length ) {
	 return 32;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

/**
 * Sets custom excerpt ellipsis.
 *
 * @param string $more Ending.
 */
function custom_excerpt_more( $more ) {
	return '...';
}
add_filter( 'excerpt_more', 'custom_excerpt_more' );

/**
 * Shorten Excerpt for a post
 *
 * @param int $id ID of post.
 * @param int $length Number of characters required.
 */
function excerpt( $id, $length = 18 ) {
	$content_post = get_post( $id );
	$content      = $content_post->post_content;

	$content = apply_filters( 'the_content', $content );
	$content = str_replace( ']]>', ']]&gt;', $content );
	$content = strip_tags( $content );
	$content = preg_replace( "/\r|\n/", '', $content );

	preg_match( "/(?:\w+(?:\W+|$)){0,$length}/", $content, $matches );
	echo esc_html( $matches[0] . '...' );

}
