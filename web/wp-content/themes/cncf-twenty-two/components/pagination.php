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

?>
<div class="pagination">

	<?php

	$prev_text = sprintf(
		'%s <span class="screen-reader-text">%s</span>',
		'<span aria-hidden="true" class="arrows">&#10094;&nbsp;</span>',
		__( 'Prev' )
	);
	$next_text = sprintf(
		'<span class="screen-reader-text">%s</span> %s',
		__( 'Next' ),
		'<span aria-hidden="true" class="arrows">&nbsp;&#10095;</span>'
	);

	$posts_pagination = get_the_posts_pagination(
		array(
			'mid_size'  => 5,
			'end_size'  => 1,
			'prev_text' => $prev_text,
			'next_text' => $next_text,
			'class' => 'pagination-wrapper',
		)
	);

	// If no previous page link, prepend a placeholder with `visibility: hidden` to take its place.
	if ( strpos( $posts_pagination, 'prev page-numbers' ) === false ) {
		$posts_pagination = str_replace( '<div class="pagination">', '<div class="pagination"><span class="prev page-numbers" aria-hidden="true">' . $prev_text . '</span>', $posts_pagination );
	}

	// If no next page link, append a placeholder with `visibility: hidden` to take its place.
	if ( strpos( $posts_pagination, 'next page-numbers' ) === false ) {
		$posts_pagination = str_replace( '</div>', '<span class="next page-numbers" aria-hidden="true">' . $next_text . '</span></div>', $posts_pagination );
	}

	if ( $posts_pagination ) :
		echo $posts_pagination; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- already escaped during generation.
	endif;

	?>
</div>
