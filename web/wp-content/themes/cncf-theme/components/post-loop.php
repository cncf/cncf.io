<?php
/**
 * Post content - the loop
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

$image = new Image();
?>
<main class="newsroom-archive">
	<div class="container wrap newsroom-archive-container">
		<?php
		if ( have_posts() ) :
			// setup options.
			$options = get_option( 'cncf-mu' );
			// setup loop count.
			$count       = 0;

			$archive_page = (get_query_var('paged')) ? get_query_var('paged') : 1;

			while ( have_posts() ) :
				the_post();
				$count++;
				$is_featured = ( 1 == $archive_page && 1 == $count ? ' featured' : '' );
				?>
		<div
			class="newsroom-archive-item <?php echo esc_html( $is_featured ); ?>">
			<div class="newsroom-archive-image-wrapper"><a href="<?php the_permalink(); ?>"
					title="<?php the_title(); ?>">

				<?php
				if ( has_post_thumbnail() ) {
					echo wp_get_attachment_image( get_post_thumbnail_id(), 'newsroom-image', false, array( 'class' => 'newsroom-image' ) );
				} elseif ( isset( $options['generic_thumb_id'] ) && $options['generic_thumb_id'] ) {
					echo wp_get_attachment_image( $options['generic_thumb_id'], 'newsroom-image', false, array( 'class' => 'newsroom-image' ) );
				} else {
					echo '<img src="' . esc_url( get_stylesheet_directory_uri() )
					. '/images/thumbnail-default.svg" alt="CNCF" class="newsroom-image"/>';
				}
				?>
				</a>
			</div>
<div class="newsroom-archive-text-wrapper">
			<p class="newsroom-archive-title"><a href="<?php the_permalink(); ?>"
					title="<?php the_title(); ?>">
					<?php the_title(); ?>
				</a></p>
			<span class="newsroom-archive-date date-icon">
				<?php echo get_the_date( 'j F Y' ); ?></span>
			<p class="newsroom-archive-excerpt"><?php the_excerpt(); ?></p>
			</div>
		</div>
				<?php
endwhile;
endif;
		?>
	</div>
</main>
