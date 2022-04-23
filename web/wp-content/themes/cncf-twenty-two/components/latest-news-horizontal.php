<?php
/**
 * Latest News Horizontal
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

// TODO: Exclude current post via template_part control.
// 'post__not_in'       => array( get_the_ID() ) // phpcs:ignore.

$args  = array(
	'post_type'           => 'post',
	'post_status'         => array( 'publish' ),
	'posts_per_page'      => 3,
	'orderby'             => 'date',
	'order'               => 'DESC',
	'ignore_sticky_posts' => false,
	'category_name'       => 'blog,announcements',
);
$query = new WP_Query( $args );

if ( $query->have_posts() ) :
	?>
<div class="columns-three">
	<?php

	while ( $query->have_posts() ) {
		$query->the_post();

		get_template_part( 'components/news-item-vertical' );
	}
	?>
</div>

	<?php
endif;
wp_reset_postdata();
