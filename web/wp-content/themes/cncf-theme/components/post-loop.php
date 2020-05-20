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
	<div class="container wrap archive-container">
		<?php
		if ( have_posts() ) :
			// setup options.
			$options = get_option( 'cncf-mu' );
			// setup loop count.
			$count = 0;

			$archive_page = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

			$is_in_the_news_category = ( in_category( 'news' ) ) ? true : false;

			while ( have_posts() ) :
				the_post();
				$count++;
				$is_featured = ( 1 == $archive_page && 1 == $count ? ' featured' : '' );

				if ( $is_in_the_news_category ) :
					?>
		<div class="archive-item in-news-item">
			<div class="archive-image-wrapper">
							<?php
							if ( has_post_thumbnail() ) {
								echo wp_get_attachment_image( get_post_thumbnail_id(), 'newsroom-media-coverage', false, array( 'class' => 'newsroom-media-coverage' ) );

							} elseif ( isset( $options['generic_thumb_id'] ) && $options['generic_thumb_id'] ) {
								echo wp_get_attachment_image( $options['generic_thumb_id'], 'newsroom-image', false, array( 'class' => 'newsroom-image' ) );
							} else {
								echo '<img src="' . esc_url( get_stylesheet_directory_uri() )
								. '/images/thumbnail-default.svg" alt="CNCF" class="newsroom-image"/>';
							}
							?>
			</div>
			<div class="archive-text-wrapper">
				<p class="archive-title">
					<?php the_title(); ?>
				</p>
				<span class="archive-date date-icon">
					<?php echo get_the_date( 'j F Y' ); ?></span>
				<p class="archive-excerpt"><?php the_content(); ?></p>
			</div>
		</div>
					<?php
		else :
			?>
		<div class="archive-item <?php echo esc_html( $is_featured ); ?>">

			<div class="archive-image-wrapper box-shadow"><a
					href="<?php the_permalink(); ?>"
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
			<div class="archive-text-wrapper">
				<p class="archive-title"><a href="<?php the_permalink(); ?>"
						title="<?php the_title(); ?>">
						<?php the_title(); ?>
					</a></p>
				<span class="archive-date date-icon">
					<?php echo get_the_date( 'j F Y' ); ?></span>
				<p class="archive-excerpt"><?php the_excerpt(); ?></p>
			</div>
		</div>
				<?php
				endif;
		endwhile;
endif;
		?>
	</div>
</main>
