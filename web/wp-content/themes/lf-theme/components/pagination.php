<?php
/**
 * Posts Navigation
 *
 * Displaying a numeric nav.
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

$prev_text = sprintf(
	'%s <span class="nav-prev-text">%s</span>',
	'<span aria-hidden="true">&larr;</span>',
	__( 'Prev', 'cncf-theme' )
);
$next_text = sprintf(
	'<span class="nav-next-text">%s</span> %s',
	__( 'Next', 'cncf-theme' ),
	'<span aria-hidden="true">&rarr;</span>'
);

$posts_pagination = get_the_posts_pagination(
	array(
		'mid_size'  => 2,
		'end_size'  => 2,
		'prev_text' => $prev_text,
		'next_text' => $next_text,
	)
);

// If no previous page link, prepend a placeholder with `visibility: hidden` to take its place.
if ( strpos( $posts_pagination, 'prev page-numbers' ) === false ) {
	$posts_pagination = str_replace( '<div class="pagination">', '<div class="pagination"><span class="prev page-numbers placeholder" aria-hidden="true">' . $prev_text . '</span>', $posts_pagination );
}

// If no next page link, append a placeholder with `visibility: hidden` to take its place.
if ( strpos( $posts_pagination, 'next page-numbers' ) === false ) {
	$posts_pagination = str_replace( '</div>', '<span class="next page-numbers placeholder" aria-hidden="true">' . $next_text . '</span></div>', $posts_pagination );
}

if ( $posts_pagination ) :
	echo $posts_pagination; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- already escaped during generation.
endif;
