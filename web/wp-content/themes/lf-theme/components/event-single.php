<?php
/**
 * Events content - the loop
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

// event host.
$event_host      = Lf_Utils::get_term_names( get_the_ID(), 'lf-event-host', true );
$event_host_slug = Lf_Utils::get_term_slugs( get_the_ID(), 'lf-event-host', true );

// external URL.
$external_url     = get_post_meta( get_the_ID(), 'lf_event_external_url', true );
$event_start_date = get_post_meta( get_the_ID(), 'lf_event_date_start', true );
$event_end_date   = get_post_meta( get_the_ID(), 'lf_event_date_end', true );
$city             = get_post_meta( get_the_ID(), 'lf_event_city', true );
$country          = Lf_Utils::get_term_names( get_the_ID(), 'lf-country', true );

if ( ! $city && ! $country ) {
	$location = 'TBC';
} elseif ( ! $country ) {
	$location = $city;
} elseif ( ! $city ) {
	$location = $country;
} else {
	$location = $city . ', ' . $country;
}

// Get date and time now.
$now           = new DateTime( '', new DateTimeZone( 'America/Los_Angeles' ) );
$date_now      = $now->format( 'Y-m-d' );
$period_status = '';

// Event status. check for start date on event, otherwise don't show anything.
if ( $event_start_date ) {
	if ( $event_start_date > $date_now ) {
		$period_status = 'upcoming';
	} elseif ( ( $event_start_date <= $date_now ) && ( $event_end_date >= $date_now ) ) {
		$period_status = 'current';
	} else {
		$period_status = 'past';
	}
}

?>
<section class="hero" id="maincontent">
	<div class="container wrap no-background">
		<p class="hero-parent-link"><a href="/events/"
				title="Go to Events">Event</a></p>
		<h1 class="hero-post-title" itemprop="headline">
			<?php
			the_title();
			?>
		</h1>
		<p class="h3 event-location">Location: <?php echo esc_html( $location ); ?></p>
	</div>
</section>
<main class="event-single">
	<article class="container wrap">
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<?php if ( $event_start_date ) : ?>
		<div class="skew-box centered">
				<?php
				echo esc_html( Lf_Utils::display_event_date( $event_start_date, $event_end_date ) );
				?>
		</div>
		<?php endif; ?>
			<?php
			if ( $event_host ) :
				$event_host_link = '/events/?_sft_lf-event-host=' . $event_host_slug;
				?>
		<a class="skew-box secondary centered" title="See other <?php echo esc_attr( $event_host ); ?> events" href="<?php echo esc_url( $event_host_link ); ?>">
				<?php echo esc_html( $event_host ); ?> Event</a>
		<?php endif; ?>

			<?php if ( 'past' == $period_status ) : ?>
		<h3 class="margin-y">This event has passed.</h3>
		<?php endif; ?>

		<div class="entry-content">
			<?php the_content(); ?>
		</div>
			<?php if ( $external_url ) : ?>
		<a href="<?php echo esc_url( $external_url ); ?>" class="button margin-top-large external is-white" target="_blank" rel="noopener">Full Event
			Information</a>
		<?php endif; ?>
		<a href="mailto:meeting@cncf.io"
			class="button secondary-color margin-top-large">Arrange Meeting with
			CNCF</a>
		<?php endwhile; ?>
	</article>
</main>
