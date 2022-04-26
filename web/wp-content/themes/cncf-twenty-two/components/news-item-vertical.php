<?php
/**
 * News Item - Vertical
 *
 * Styling in posts.scss
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

$is_in_the_news_category = ( in_category( 'news' ) ) ? true : false;

// Merge classes.
$classes = LF_Utils::merge_classes(
	array(
		$is_in_the_news_category ? 'news-item-vertical in-the-news-item' : 'news-item-vertical ',
		is_sticky() ? 'is-sticky-news' : 'not-sticky',
	)
);
?>

<div class="<?php echo esc_attr( $classes ); ?>">

	<?php
	if ( $is_in_the_news_category ) :

		$link_url = get_post_meta( get_the_ID(), 'lf_post_external_url', true );

		if ( ! $link_url ) {
			$link_url = get_the_permalink();
		}
		?>

	<a href="<?php echo esc_url( $link_url ); ?>"
		class="news-item-vertical__link"
		title="<?php the_title_attribute(); ?>">

		<div class="news-item-vertical__media-image-wrapper">
			<?php
			if ( has_post_thumbnail() ) {
				Lf_Utils::display_responsive_images( get_post_thumbnail_id(), 'newsroom-400', '400px', 'news-item-vertical__image', 'lazy', the_title_attribute() );
			} else {
				echo '<img class="news-item-vertical__image" src="' . esc_url( get_template_directory_uri() )
				. '/images/default-media-logo.svg" alt="CNCF Media Coverage" />';
			}
			?>
		</div>
		<h3 class="news-item-vertical__title"><?php the_title(); ?></h3>
	</a>
		<?php
else :

	if ( is_sticky() ) {
		?>
	<div class="sticky-news-tag">
		Featured
	</div>
		<?php
	}
	?>

	<a href="<?php the_permalink(); ?>" class="news-item-vertical__link"
		title="<?php the_title_attribute(); ?>">

		<?php
		if ( has_post_thumbnail() ) {
			// display smaller news image.
			Lf_Utils::display_responsive_images( get_post_thumbnail_id(), 'newsroom-400', '400px', 'news-item-vertical__image', 'lazy', the_title_attribute() );

		} else {
			// show generic.
			// get site options.
			$site_options = get_option( 'lf-mu' );
			Lf_Utils::display_responsive_images( $site_options['generic_thumb_id'], 'newsroom-400', '400px', 'news-item-vertical__image', 'lazy', the_title_attribute() );
		}
		?>
		<h3 class="news-item-vertical__title"><?php the_title(); ?></h3>
	</a>
	<?php
endif;
?>
	<span
		class="news-item-vertical__date"><?php echo get_the_date( 'F j, Y' ); ?></span>

</div>
