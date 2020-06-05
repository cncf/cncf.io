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

			$is_blog_category = ( in_category( 'blog' ) ) ? true : false;

			while ( have_posts() ) :
				the_post();
				$count++;
				$is_featured = ( 1 == $archive_page && 1 == $count ? ' featured' : '' );

				if ( $is_in_the_news_category ) :
					$link_url = get_post_meta( get_the_ID(), 'cncf_post_external_url', true );

					$target_attr = 'rel="noopener" target="_blank"';

					$add_external_icon = ' external is-primary-color';

					if ( ! $link_url ) {
						$target_attr       = '';
						$link_url          = get_the_permalink();
						$add_external_icon = '';
					}
					?>
		<div class="archive-item in-news-item">
			<div class="archive-image-wrapper"><a
					href="<?php echo esc_url( $link_url ); ?>"
					<?php echo esc_attr( $target_attr ); ?>
					title="<?php the_title(); ?>">
					<?php
					if ( has_post_thumbnail() ) {
						echo wp_get_attachment_image( get_post_thumbnail_id(), 'newsroom-media-coverage', false, array( 'class' => 'newsroom-media-coverage media-logo' ) );

					} else {
						echo '<img src="' . esc_url( get_stylesheet_directory_uri() )
						. '/images/thumbnail-default.svg" alt="CNCF Media Coverage" class="newsroom-media-coverage"/>';
					}
					?>
				</a>
			</div>
			<div class="archive-text-wrapper">
				<p class="archive-title"><a
						class="<?php echo esc_html( $add_external_icon ); ?>"
						href="<?php echo esc_url( $link_url ); ?>"
						<?php echo esc_attr( $target_attr ); ?>
						title="<?php the_title(); ?>">
						<?php the_title(); ?>
					</a></p>
				<span class="archive-date date-icon">
					<?php echo get_the_date( 'F j, Y' ); ?></span>
				<div class="archive-excerpt"><?php the_content(); ?></div>
			</div>
		</div>
					<?php
		else :

			// Get the Category Author.
			$category_author = Cncf_Utils::get_term_names( get_the_ID(), 'cncf-author-category', true );

			?>
		<div class="archive-item <?php echo esc_html( $is_featured ); ?>">

			<div class="archive-image-wrapper"><a
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
				<?php if ( $is_blog_category && $category_author ) : ?>
				<div class="skew-box secondary centered margin-bottom">CNCF
					<?php
					echo esc_html( $category_author );
					?>
					Blog Post</div>
					<?php
		endif;
				?>

				<p class="archive-title"><a href="<?php the_permalink(); ?>"
						title="<?php the_title(); ?>">
						<?php the_title(); ?>
					</a></p>

				<p class="date-author-row"><span class="posted-date date-icon">
						<?php
						the_date();
						?>
					</span>
					<?php
					// Post author.
					if ( in_category( 'blog' ) ) :
							echo wp_kses_post( Cncf_Utils::display_author( get_the_ID(), true ) );
		endif;
					?>
				</p>
				</span>
				<div class="archive-excerpt"><?php the_excerpt(); ?></div>
			</div>
		</div>
			<?php
		endif;
		endwhile;
endif;
		?>
	</div>
</main>
