<?php
/**
 * Latest News Item - Horizontal
 *
 * Styling in posts.scss
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

$sticky_status = is_sticky() ? 'is-sticky-news' : 'not-sticky';
?>
<div class="main-menu-item">
	<div
		class="main-menu-item__image-wrapper <?php echo esc_attr( $sticky_status ); ?>">
		<?php
		if ( is_sticky() ) {
			?>
		<div class="sticky-news-tag">
			Featured
		</div>
			<?php
		}
		?>
		<a href="<?php the_permalink(); ?>"
			title="<?php the_title_attribute(); ?>" class="main-menu-item__link">
			<?php
			if ( has_post_thumbnail() ) {
				// display smaller news image.
				Lf_Utils::display_responsive_images( get_post_thumbnail_id(), 'newsroom-194', '200px', 'main-menu-item__image', 'lazy', get_the_title() );
			} else {
				// show generic.
				$site_options = get_option( 'lf-mu' );
				Lf_Utils::display_responsive_images( $site_options['generic_thumb_id'], 'newsroom-194', '200px', 'main-menu-item__image', 'lazy', get_the_title() );
			}
			?>
		</a>
	</div>
	<div class="main-menu-item__text-wrapper">
		<?php
		// Get the Category Author.
		$category = Lf_Utils::get_term_names( get_the_ID(), 'lf-author-category', true );

		$category_slug = Lf_Utils::get_term_slugs( get_the_ID(), 'lf-author-category', true );

		$parent_link = get_home_url() . '/lf-author-category/' . $category_slug . '/';

		$type_of_post = 'Post';
		// Overwrite if report.
		if ( 'lf_report' == $post->post_type ) {

			$category = ucwords( Lf_Utils::get_term_names( get_the_ID(), 'lf-report-type', true ) );

			$category_slug = Lf_Utils::get_term_slugs( get_the_ID(), 'lf-report-type', true );

			$parent_link = get_home_url() . '/reports/?_sft_lf-report-type=' . $category_slug;

			$type_of_post = 'Report';

		}

		if ( $category ) :
			?>
		<a class="author-category" title="See more in <?php echo esc_attr( $category ); ?> category" href="<?php echo esc_url( $parent_link ); ?>"><?php echo esc_html( $category ); ?> <?php echo esc_html( $type_of_post ); ?></a>
		<?php endif; ?>

		 <span class="main-menu-item__title">
			<a href="<?php the_permalink(); ?>"
				title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
		</span>
		<span
			class="main-menu-item__date"><?php echo get_the_date( 'F j, Y' ); ?></span>
	</div>
</div>
