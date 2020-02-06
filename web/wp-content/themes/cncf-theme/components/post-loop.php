<?php
/**
 * Post content - the loop
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

?>
<main class="post-content content-styling">
	<article class="container wrap">
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<?php
			if ( has_post_thumbnail() ) {
				the_post_thumbnail();
			}
			?>
		<h1><a
				href="<?php the_permalink(); ?>"><?php echo esc_html( get_the_title() ); ?></a>
		</h1>

		<p class="meta">
			Posted: <?php the_date(); ?>
		</p>
			<?php the_content(); ?>
			<?php
			$prev = get_adjacent_post( true, '', true );
			$next = get_adjacent_post( true, '', false );
			?>
			<?php if ( $prev ) : ?>
		<a href="<?php echo esc_html( get_permalink( $prev->ID ) ); ?>"
			class="button smaller">Next Old Post</a>
		<?php endif; ?>
			<?php if ( $next ) : ?>
		<a href="<?php echo esc_html( get_permalink( $next->ID ) ); ?>"
			class="button smaller">Next New Post</a>
				<?php
		endif;
endwhile;
		?>
	</article>
</main>
