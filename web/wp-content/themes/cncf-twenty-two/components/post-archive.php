<?php
/**
 * Post Archive
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

 ?>

 <main class="post-archive">
	<div class="container wrap">

<?php
if ( is_archive() ) : ?>

<div class="is-style-opening-paragraph has-header-3-font-size">
	<?php echo category_description(); ?>
</div>

<div class="columns-one">

<?php
endif;

		if ( have_posts() ) :

			// Setup loop count.
			$count = 0;
			// Get page number.
			$page_number = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

			// Conditional checks.
			$is_in_the_news_category   = ( is_category( 'news' ) ) ? true : false;
			$is_announcements_category = ( is_category( 'announcements' ) ) ? true : false;
			$is_blog_category          = ( is_category( 'blog' ) ) ? true : false;
			$is_featured               = false;
			$is_sticky                 = false;

			// Get all sticky posts.
			$sticky_posts = get_option( 'sticky_posts' );

			// Check for sticky post, if on blog display it.
			if ( $sticky_posts && 1 === $page_number && $is_blog_category ) {
				$args        = array(
					'posts_per_page'      => 1,
					'post_type'           => array( 'post' ),
					'post_status'         => array( 'publish' ),
					'has_password'        => false,
					'post__in'            => $sticky_posts,
					'ignore_sticky_posts' => true,
					'no_found_rows'       => true,
				);
				$stickyquery = new WP_Query( $args );

				// Will only return one sticky post.
				if ( $stickyquery->have_posts() ) {

					$stickyquery->the_post();
					$sticky_post_id = get_the_ID();
					$count++;
					$is_featured = true;
					$is_sticky   = true;

					get_template_part( 'components/news-item', null, array(
						'is_featured' => $is_featured,
						'is_sticky' => $is_sticky,
						'is_in_the_news' => $is_in_the_news_category,
						'is_blog' => $is_blog_category,
					) );
				}
				wp_reset_postdata();
			}

			while ( have_posts() ) {
				the_post();

				// skip re-showing the sticky post.
				if ( isset( $sticky_post_id ) && get_the_ID() === $sticky_post_id ) {
					continue;
				}
				$count++;
				// If page number 1, count 1, and in blog or announcement, make post featured.
				// If count = 1 then there is no sticky.
				$is_featured = ( 1 == $page_number && 1 == $count && ( $is_blog_category || $is_announcements_category ) );

				get_template_part( 'components/news-item', null, array(
					'is_featured' => $is_featured,
					'is_sticky' => null,
					'is_in_the_news' => $is_in_the_news_category,
					'is_blog' => $is_blog_category,
				) );
			}
		endif;
		?>

</div>
		<?php get_template_part( 'components/pagination' ); ?>

	</div>
</main>
