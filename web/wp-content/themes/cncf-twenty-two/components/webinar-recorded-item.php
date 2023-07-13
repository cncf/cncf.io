<?php
/**
 * Recorded Webinar Item
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

// get webinar date.
$webinar_date = new DateTime( get_post_meta( get_the_ID(), 'lf_webinar_date', true ) );

// get recording URL (for video thumb).
$recording_url = get_post_meta( get_the_ID(), 'lf_webinar_recording_url', true );

// extract YouTube video ID.
$video_id = Lf_Utils::get_youtube_id_from_url( $recording_url );

// get views.
$webinar_views        = get_post_meta( get_the_ID(), 'lf_webinar_recording_views', true );

// get companies (presented by).
$company = Lf_Utils::get_term_names( get_the_ID(), 'lf-company' );
?>

<div class="webinar-recorded-item has-animation-scale-2">

	<figure class="webinar-recorded-item__figure">
		<a href="<?php the_permalink(); ?>"  class="webinar-recorded-item__figure-link">

		<?php
		if ( $video_id ) {
			// Applying loading lazy to this YouTueb image stops it appearing.
			?>
			<img loading="lazy" src="https://img.youtube.com/vi/<?php echo esc_html( $video_id ); ?>/hqdefault.jpg"
				alt="<?php the_title_attribute(); ?>" class="webinar-recorded-item__image">

<svg class="webinar-recorded-item__overlay" width="70" height="71">
 <use xlink:href="#play-button" xmlns:xlink="http://www.w3.org/1999/xlink"></use>
</svg>

			<?php
		} else {
			// setup options.
			$site_options = get_option( 'lf-mu' );
			Lf_Utils::display_responsive_images( $site_options['generic_thumb_id'], 'full', '400px', 'webinar-recorded-item__image', 'lazy', get_the_title() );
		}
		?>
		</a>
	</figure>

	<div class="webinar-recorded-item__text-wrapper">

	<h3 class="webinar-recorded-item__title"><a  class="webinar-recorded-item__link"
			href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

		<?php
		if ( $company ) :
			?>
	<span class="webinar-recorded-item__presented">Presented by:
			<?php echo esc_html( $company ); ?></span>
			<?php
			endif;
		?>

<div class="webinar-recorded-item__date-views-wrapper">
		<?php
		if ( $webinar_date ) :
			?>
	<span class="webinar-recorded-item__date">
			<?php
			echo esc_html( $webinar_date->format( 'F j, Y' ) );
			?>
</span>
<?php endif; ?>

<?php if ( $webinar_views ) : ?>
	<span class="webinar-recorded-item__views">
		<?php
		echo esc_html( number_format( $webinar_views ) ) . ' views';
		?>
		</span>
			<?php
			endif;
?>
</div>
</div>
</div>
