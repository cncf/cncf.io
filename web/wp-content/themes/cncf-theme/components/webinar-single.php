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
$webinar_date        = get_post_meta( get_the_ID(), 'cncf_webinar_date', true );
$webinar_time        = get_post_meta( get_the_ID(), 'cncf_webinar_time', true );
$formatted_date_time = Cncf_Utils::display_webinar_date_time( $webinar_date, $webinar_time, true );
$dat_webinar         = new DateTime( $formatted_date_time );

// Get date and time to display.
$date_and_time = Cncf_Utils::display_webinar_date_time( $webinar_date, $webinar_time );

// get recording URL.
$recording_url = get_post_meta( get_the_ID(), 'cncf_webinar_recording_url', true );

// extract YouTube video ID.
$video_id = Cncf_Utils::get_youtube_id_from_url( $recording_url );

// get author category.
$author_category = Cncf_Utils::get_term_names( get_the_ID(), 'cncf-author-category', true );

// get companies (presented by).
$company = Cncf_Utils::get_term_names( get_the_ID(), 'cncf-company' );

$topic = Cncf_Utils::get_term_names( get_the_ID(), 'cncf-topic' );

// get registration URL.
$registration_url = get_post_meta( get_the_ID(), 'cncf_webinar_registration_url', true );

// get slides URL.
$slides_url = get_post_meta( get_the_ID(), 'cncf_webinar_slides_url', true );

// get webinar speakers.
$speakers = get_post_meta( get_the_ID(), 'cncf_webinar_speakers', true );

// date period.
if ( $dat_webinar > $dat_now ) {
	$period_status = 'upcoming';
} elseif ( ( $dat_webinar < $dat_now ) && ( $recording_url ) ) {
	$period_status = 'recorded';
} else {
	$period_status = 'past';
}

?>
<section class="hero">
	<div class="container wrap no-background">
		<p class="hero-parent-link"><a href="/webinars/"
				title="Go to Webinars">Webinar</a></p>
		<h1 class="hero-post-title" itemprop="headline">
			<?php
			the_title();
			?>
		</h1>
	</div>
</section>

<main class="webinar-single">
	<article class="container wrap">
		<?php
		while ( have_posts() ) :
			the_post();
			?>

			<?php
			if ( 'upcoming' == $period_status && $date_and_time ) :
				?>
		<span class="skew-box centered"><?php echo esc_html( $date_and_time ); ?></span>
			<?php endif; ?>

		<div class="skew-box secondary centered">CNCF
			<?php echo esc_html( $author_category ); ?> Webinar</div>

			<?php
			// the company - presented by.
			if ( $company ) :
				?>
		<div class="presented-by">Presented by:
					<?php echo esc_html( $company ); ?></div>
				<?php endif; ?>

			<?php if ( 'past' == $period_status ) : ?>
		<h5>This webinar has passed.</h5>
					<?php endif; ?>

				<?php
				if ( 'upcoming' == $period_status && $registration_url ) :
					?>
		<p><a target="_blank" href="<?php echo esc_url( $registration_url ); ?>" rel="noopener noreferrer"
				class="button margin-top-large"
				title="Register for <?php the_title(); ?> Webinar">Register
				Now</a></p>
			<?php endif; ?>

			<?php
			if ( 'recorded' == $period_status ) :
				?>
		<div class="recorded">
			<p class="live-icon">Recorded:
				<?php echo esc_html( $dat_webinar->format( 'l F j, Y' ) ); ?>
			</p>
		</div>
		<?php endif; ?>


			<?php if ( $video_id ) : ?>
		<iframe
			src="https://www.youtube.com/embed/<?php echo esc_html( $video_id ); ?>"
			frameborder="0"
			allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
			allowfullscreen></iframe>
		<?php endif; ?>

			<?php
			if ( $slides_url ) :
				?>
		<p><a target="_blank" href="<?php echo esc_url( $slides_url ); ?>"
				class="button margin-top"
				title="Download slides for <?php the_title(); ?> Webinar">Download
				Slides</a></p>
		<?php endif; ?>



		<div class="entry-content">

			<?php if ( $speakers ) : ?>
			<h5 class="speakers">Webinar Speakers:
				<?php echo esc_html( $speakers ); ?></h5>
			<?php endif; ?>

			<?php the_content(); ?>


			<?php if ( 'upcoming' == $period_status ) : ?>

			<div class="webinar-summary margin-y-large">
				<h3 class="margin-reset margin-bottom">Webinar Summary</h3>
				<p>Webinar: <?php the_title(); ?></p>

				<?php if ( $speakers ) : ?>
				<p>Speakers: <?php echo esc_html( $speakers ); ?></p>
				<?php endif; ?>


				<p>Date:
					<?php echo esc_html( $dat_webinar->format( 'l jS F Y' ) ); ?>
				</p>

				<?php
				// encode the title of webinar.
				$msg = urlencode( html_entity_decode( str_replace( array( '&laquo;', '&quot;', '&#8220;', '&#8221;', '&#039;' ), '', 'CNCF Webinar: ' . get_the_title() ), ENT_COMPAT, 'UTF-8' ) );
				// setup the date, time and timezone.
				$iso = $dat_webinar->format( 'Ymd' ) . 'T' . $dat_webinar->format( 'H' );
				// these timezones seem to be hardcoded.
				if ( 'CST' == $dat_webinar->format( 'e' ) ) {
					$p1_value = 33;
				} else {
					$p1_value = 137;
				}
				// create the conversion URL.
				$conversion_url = 'https://www.timeanddate.com/worldclock/fixedtime.html?msg=' . $msg . '&iso=' . $iso . '&p1=' . $p1_value . '&ah=1';
				?>

				<p>Time: <?php echo esc_html( $webinar_time ); ?>. <a
						href="<?php echo esc_url( $conversion_url ); ?>"
						target="_blank">Convert to your local time</a>.</p>

				Attend: <a target="_blank" href="<?php echo esc_url( $registration_url ); ?>" rel="noopener noreferrer"
				title="Register for <?php the_title(); ?> Webinar">Register for this
					webinar</a>.
			</div>
			<?php endif; ?>

		</div>

		<?php endwhile; ?>
	</article>
</main>

<?php

if ( 'recorded' == $period_status || 'past' == $period_status ) :

	get_template_part( 'components/webinar-related' );

endif;
?>
