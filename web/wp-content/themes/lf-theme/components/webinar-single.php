<?php
/**
 * Webinar content - the loop
 *
 * @package WordPress
 * @subpackage lf-theme
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

// get author category.
$author_category = Lf_Utils::get_term_names( get_the_ID(), 'lf-author-category', true );
$author_category_slug = Lf_Utils::get_term_slugs( get_the_ID(), 'lf-author-category', true );

// get companies (presented by).
$company = Lf_Utils::get_term_names( get_the_ID(), 'lf-company' );

// get registration URL.
$registration_url = get_post_meta( get_the_ID(), 'lf_webinar_registration_url', true );

// get slides URL.
$slides_url = get_post_meta( get_the_ID(), 'lf_webinar_slides_url', true );

// get webinar speakers.
$speakers = get_post_meta( get_the_ID(), 'lf_webinar_speakers', true );

// enqueue calendar and date js.
wp_enqueue_script(
	'add-to-calendar-js',
	get_stylesheet_directory_uri() . '/source/js/third-party/add-to-calendar.min.js',
	array(),
	filemtime( get_template_directory() . '/source/js/third-party/add-to-calendar.min.js' ),
	false
);
wp_enqueue_script(
	'day-js',
	get_stylesheet_directory_uri() . '/source/js/third-party/dayjs.min.js',
	array(),
	filemtime( get_template_directory() . '/source/js/third-party/dayjs.min.js' ),
	false
);


// date period.
if ( $dat_webinar_start > $dat_now ) {
	$period_status = 'upcoming';
} elseif ( ( $dat_webinar_start < $dat_now ) && ( $recording_url ) ) {
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
			if ( 'upcoming' == $period_status ) :
				?>
		<span
			class="skew-box centered margin-bottom"><?php echo esc_html( str_replace( ':00', '', $dat_webinar_start->format( 'l F j, Y, g:iA T' ) ) ); ?></span>
		<?php endif; ?>

			<?php
			if ( $author_category ) :
				$author_category_link = '/lf-author-category/' . $author_category_slug . '/';
				?>
		<a class="skew-box secondary centered" title="See more content from <?php echo esc_attr( $author_category ); ?>" href="<?php echo esc_url( $author_category_link ); ?>">CNCF
				<?php echo esc_html( $author_category ); ?> Webinar
			</a>
		<?php endif; ?>

			<?php
			// the company - presented by.
			if ( $company ) :
				?>
		<div class="presented-by">Presented by:
				<?php echo esc_html( $company ); ?></div>
		<?php endif; ?>

			<?php if ( 'past' == $period_status ) : ?>
		<h3 class="margin-y">This webinar has passed.</h3>
				<?php if ( $dat_webinar_start ) { ?>
		<p class="date-icon">Broadcast on <?php echo esc_html( $dat_webinar_start->format( 'l F j, Y, g:iA T' ) ); ?>
		</p>
				<?php } ?>
		<?php endif; ?>

			<?php
			if ( 'upcoming' == $period_status && $registration_url ) :
				?>
		<p class="wp-block-buttons"><a target="_blank" href="<?php echo esc_url( $registration_url ); ?>"
				rel="noopener" class="button margin-top-large "
				title="Register for <?php the_title(); ?> Webinar">Register
				Now</a></p>
		<?php endif; ?>

			<?php
			if ( 'recorded' == $period_status && $dat_webinar_start ) :
				?>
		<div class="recorded">
			<p class="live-icon">Recorded:
				<?php echo esc_html( $dat_webinar_start->format( 'l F j, Y' ) ); ?>
			</p>
		</div>
		<?php endif; ?>


			<?php if ( $video_id ) : ?>
		<iframe
			src="https://www.youtube-nocookie.com/embed/<?php echo esc_html( $video_id ); ?>"
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
				<h3>Webinar Summary</h3>
				<p class="is-style-max-width-900"><strong>Webinar:</strong>
					<?php the_title(); ?></p>

				<?php if ( $speakers ) : ?>
				<p><strong>Speakers:</strong>
					<?php echo esc_html( $speakers ); ?></p>
				<?php endif; ?>


				<p class="is-style-max-width-100"><strong>Date:</strong>
					<?php echo esc_html( $dat_webinar_start->format( 'l F jS, Y' ) ); ?>,
					<?php echo esc_html( $dat_webinar_start->format( 'g:i' ) . ' - ' . $dat_webinar_end->format( 'g:i A T' ) ); ?>
				</p>

				<p class="is-style-max-width-100 webinar-local-date-time"><strong>Date (localized to your timezone):</strong>
					<span></span>
					<script>
					var webinar_ts_start = <?php echo esc_html( $dat_webinar_start->format( 'U' ) ); ?> * 1000;
					var webinar_ts_end   = <?php echo esc_html( $dat_webinar_end->format( 'U' ) ); ?> * 1000;
					var webinar_tz       = '<?php echo esc_html( $dat_webinar_end->format( 'O' ) ); ?>';
					</script>
				</p>

				<p><strong>How to attend:</strong>
				<?php if ( $registration_url ) : ?>
					<a target="_blank" href="<?php echo esc_url( $registration_url ); ?>" rel="noopener" class="external is-primary-color is-inline"
				title="Register for <?php the_title(); ?> Webinar">Register for this
					webinar</a>
					<?php
						else :
							?>
						Registration link coming soon
						<?php endif; ?>
				</p>

				<div title="Add to Calendar" class="add-to-calendar">
					<span class="start"><?php echo esc_html( $dat_webinar_start->format( 'm/d/Y g:i A' ) ); ?></span>
					<span class="timezone"><?php echo esc_html( $dat_webinar_start_tz ); ?></span>
					<span class="end"><?php echo esc_html( $dat_webinar_end->format( 'm/d/Y g:i A' ) ); ?></span>
					<span class="title">CNCF webinar: <?php the_title(); ?></span>
					<span class="description">Webinar details: <?php the_permalink(); ?></span>
				</div>

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
