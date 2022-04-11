<?php
/**
 * Latest News Item - Vertical
 *
 * Styling in posts.scss
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

$sticky_status = is_sticky() ? 'is-sticky-news' : 'not-sticky';

?>

<div class="latest-news-vertical-item <?php echo esc_attr( $sticky_status ); ?>">

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
		title="<?php the_title_attribute(); ?>">
		<?php
		if ( has_post_thumbnail() ) {
			// display smaller news image.
			Lf_Utils::display_responsive_images( get_post_thumbnail_id(), 'newsroom-540', '540px', 'latest-news-vertical-item__image' );

		} else {
			// show generic.
			// get site options.
			$site_options = get_option( 'lf-mu' );
			Lf_Utils::display_responsive_images( $site_options['generic_thumb_id'], 'newsroom-540', '540px', 'latest-news-vertical-item__image' );

		}
		?>
		<h3 class="latest-news-vertical-item__title"><?php the_title(); ?></h3>
	</a>

	<span
		class="latest-news-vertical-item__date"><?php echo get_the_date( 'F j, Y' ); ?></span>

</div>
