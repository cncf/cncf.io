<?php
/**
 * Sets the excerpt length.
 *
 * @param int $length Number of words.
 */
function custom_excerpt_length( $length ) {
	 return 18;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

/**
 * Shorten Excerpt for a post
 *
 * @param int $id     - ID of post
 * @param int $length - number of characters required
 *
 * @return string
 */
function excerpt( $id, $length = 18 ) {
	 $content_post = get_post( $id );
	$content      = $content_post->post_content;

	$content = apply_filters( 'the_content', $content );
	$content = str_replace( ']]>', ']]&gt;', $content );
	$content = strip_tags( $content );
	$content = preg_replace( "/\r|\n/", '', $content );

	preg_match( "/(?:\w+(?:\W+|$)){0,$length}/", $content, $matches );
	echo $matches[0] . '...';

}
