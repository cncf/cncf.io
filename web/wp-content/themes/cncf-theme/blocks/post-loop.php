<?php
/**
 * Post content - the loop
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

?>
<section class="basic-content container">
	<article class="content">
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<?php
			if ( has_post_thumbnail() ) {
				the_post_thumbnail( 'blog-feature-image' );
			}
			?>
		<h2><a
				href="<?php the_permalink(); ?>"><?php echo esc_html( get_the_title() ); ?></a>
		</h2>

		<p class="meta">
			Posted: <?php the_date(); ?> |
			<?php
			$categories_list = get_the_category_list( esc_html__( ', ', '_s' ) );
			if ( $categories_list ) {
				/* translators: Posted in %category name  */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', '_s' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}
			?>
			| <?php echo esc_html( get_comments_number() ); ?>
		</p>
			<?php the_content(); ?>
			<?php
			$prev = get_adjacent_post( true, '', true );
			$next = get_adjacent_post( true, '', false );
			?>
			<?php if ( $prev ) : ?>
		<a href="<?php echo esc_html( get_permalink( $prev->ID ) ); ?>"
			class="button smaller">Previous Post</a>
		<?php endif; ?>
			<?php if ( $next ) : ?>
		<a href="<?php echo esc_html( get_permalink( $next->ID ) ); ?>"
			class="button smaller">Next Post</a>
		<?php endif; ?>
		<hr>
			<?php
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;
			?>
		<?php endwhile; ?>
	</article>
</section>
