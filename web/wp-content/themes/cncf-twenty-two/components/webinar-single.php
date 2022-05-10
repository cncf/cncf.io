<?php
/**
 * Webinar content - the loop
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

// Get date and time now.
$dat_now = new DateTime( '', new DateTimeZone( 'America/Los_Angeles' ) );

// Get date and time of webinar for comparison.
$webinar_date              = get_post_meta( get_the_ID(), 'lf_webinar_date', true );
$webinar_start_time        = get_post_meta( get_the_ID(), 'lf_webinar_start_time', true );
$webinar_start_time_period = get_post_meta( get_the_ID(), 'lf_webinar_start_time_period', true );
$webinar_end_time          = get_post_meta( get_the_ID(), 'lf_webinar_end_time', true );
$webinar_end_time_period   = get_post_meta( get_the_ID(), 'lf_webinar_end_time_period', true );
$webinar_timezone          = get_post_meta( get_the_ID(), 'lf_webinar_timezone', true );
$dat_webinar_start         = Lf_Utils::get_webinar_date_time( $webinar_date, $webinar_start_time, $webinar_start_time_period, $webinar_timezone );
$dat_webinar_end           = Lf_Utils::get_webinar_date_time( $webinar_date, $webinar_end_time, $webinar_end_time_period, $webinar_timezone );

// Get the timezone this way since we lose case otherwise and the Google cal entry won't work.
$tzlist = DateTimeZone::listIdentifiers( DateTimeZone::ALL );
$tzs    = array();
foreach ( $tzlist as $tz ) {
	$slug         = strtolower( str_replace( '/', '-', $tz ) );
	$tzs[ $slug ] = $tz;
}
$dat_webinar_start_tz = $tzs[ $webinar_timezone ];

// get recording URL.
$recording_url = get_post_meta( get_the_ID(), 'lf_webinar_recording_url', true );

// extract YouTube video ID.
$video_id = Lf_Utils::get_youtube_id_from_url( $recording_url );

// get companies (presented by).
$company = Lf_Utils::get_term_names( get_the_ID(), 'lf-company' );

// get registration URL.
$registration_url = get_post_meta( get_the_ID(), 'lf_webinar_registration_url', true );

// get slides URL.
$slides_url = get_post_meta( get_the_ID(), 'lf_webinar_slides_url', true );

// get webinar views.
$webinar_views = get_post_meta( get_the_ID(), 'lf_webinar_recording_views', true );

// date period.
if ( $dat_webinar_end > $dat_now ) {
	$period_status = 'upcoming';
} elseif ( ( $dat_webinar_end < $dat_now ) && ( $recording_url ) ) {
	$period_status = 'recorded';
} else {
	$period_status = 'past';
}

?>
<main class="webinar-single">
	<article class="container wrap">
		<?php
		while ( have_posts() ) :
			the_post();

			if ( 'upcoming' === $period_status ) :
				// Upcoming state added just in case URL is visible.
				?>
		<p>This webinar is upcoming but we don't have the registration URL - it's details may have updated. <a href="https://community.cncf.io/events/#/list">Visit CNCF Community Groups</a> to find out more about it.</p>
				<?php
		else :
			?>

			<?php
			// the company - presented by.
			if ( $company ) :
				?>
		<div class="webinar-single__company">Presented by:
				<?php echo esc_html( $company ); ?></div>

		<div style="height:50px" aria-hidden="true" class="wp-block-spacer"></div>

		<?php endif; ?>

		<div class="webinar-single__meta-wrapper">

				<?php
				if ( is_a( $dat_webinar_start, 'DateTime' ) ) :
					?>

			<div class="webinar-single__date">
					<?php
					if ( 'recorded' === $period_status ) {
						?>
							<img src="<?php LF_utils::get_svg( 'icon-camera.svg', true ); ?>" alt="Camera Icon" class="webinar-single__svg"> Recorded:
						<?php
					} else {
						?>
				Broadcast:
						<?php
					}
					echo esc_html( $dat_webinar_start->format( 'l F j, Y' ) );
					?>
			</div>

					<?php
				endif;
				if ( $webinar_views ) :
					?>
			<div class="webinar-single__views">

			<img src="<?php LF_utils::get_svg( 'icon-views.svg', true ); ?>" alt="Views Icon" class="webinar-single__svg">

			Views: <?php echo esc_html( number_format( $webinar_views ) ); ?>
			</div>
			<?php endif; ?>

		</div>

		<div style="height:90px" aria-hidden="true" class="wp-block-spacer is-style-70-90">
		</div>

			<?php
			// Video.
			if ( $video_id ) :
				?>
		<figure
			class="wp-block-embed is-type-video is-provider-youtube wp-block-embed-youtube wp-embed-aspect-16-9 wp-has-aspect-ratio">
			<div class="wp-block-embed__wrapper">
				<iframe
					src="https://www.youtube-nocookie.com/embed/<?php echo esc_html( $video_id ); ?>"
					title="Video of <?php the_title_attribute(); ?>" loading="lazy"
					frameborder="0" width="500" height="281"
					allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
					allowfullscreen></iframe>
			</div>
		</figure>

		<div style="height:80px" aria-hidden="true" class="wp-block-spacer is-style-40-80">
		</div>


			<?php endif; ?>

				<?php
				// Slides.
				if ( $slides_url ) :
					?>

		<div class="wp-block-buttons">
			<div class="wp-block-button"><a
					href="<?php echo esc_url( $slides_url ); ?>"
					title="Download slides for <?php the_title(); ?> Program"
					class="wp-block-button__link has-black-background-color has-background">Download
					Slides</a></div>
		</div>

		<div style="height:80px" aria-hidden="true" class="wp-block-spacer is-style-40-80">
		</div>

		<?php endif; ?>

		<div class="post-content">

			<?php the_content(); ?>

		</div>

			<?php
		endif;
endwhile;
		?>
	</article>
</main>
