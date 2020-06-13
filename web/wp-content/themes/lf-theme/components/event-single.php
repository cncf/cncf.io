<?php
/**
 * Events content - the loop
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

// event host.
$event_host = Lf_Utils::get_term_names( get_the_ID(), 'lf-event-host', true );

// external URL.
$external_url = get_post_meta( get_the_ID(), 'lf_event_external_url', true );

$event_start_date = get_post_meta( get_the_ID(), 'lf_event_date_start', true );

$event_end_date = get_post_meta( get_the_ID(), 'lf_event_date_end', true );

$city = get_post_meta( get_the_ID(), 'lf_event_city', true );

$country = Lf_Utils::get_term_names( get_the_ID(), 'lf-country', true );

if ( ! $city && ! $country ) {
	$location = 'TBC';
} elseif ( ! $country ) {
	$location = $city;
} else {
	$location = $city . ', ' . $country;
}

$logo = get_post_meta( get_the_ID(), 'lf_event_logo', true );

$background = get_post_meta( get_the_ID(), 'lf_event_background', true );

$color = get_post_meta( get_the_ID(), 'lf_event_overlay_color', true );

$color ? $overlay_color = $color : $overlay_color = '#254AAB';

?>
<section class="hero">
	<div class="container wrap no-background">
		<p class="hero-parent-link"><a href="/events/"
				title="Go to Events">Event</a></p>
		<h1 class="hero-post-title" itemprop="headline">
			<?php
			the_title();
			?>
		</h1>
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
				?>
		<div class="skew-box secondary centered">
				<?php echo esc_html( $event_host ); ?> Event</div>
		<?php endif; ?>

		<div class="event-box background-image-wrapper">

			<div class="event-overlay"
				style="background-color: <?php echo esc_html( $overlay_color ); ?> ">
			</div>

			<?php if ( $background ) : ?>
			<figure class="background-image-figure">
				<?php echo wp_get_attachment_image( $background, 'medium', false ); ?>
			</figure>
			<?php endif; ?>

			<div class="event-content-wrapper background-image-text-overlay">

				<div class="event-logo">
					<?php if ( $logo ) : ?>
					<a href="<?php the_permalink(); ?>"
						title="<?php the_title(); ?>">
						<?php
						echo wp_get_attachment_image( $logo, 'medium', false );
						?>
					</a>
					<?php else : ?>
					<h3 class="event-title"><a href="<?php the_permalink(); ?>"
							title="<?php the_title(); ?>"><?php the_title(); ?></a>
					</h3>
					<?php endif; ?>
					</a>
				</div>

				<h4 class="event-date">
					<?php
					echo esc_html( Lf_Utils::display_event_date( $event_start_date, $event_end_date ) );
					?>
				</h4>
				<h3
					class="event-city"><?php echo esc_html( $location ); ?></h3>
			</div>
		</div>


		<div class="entry-content">

			<?php the_content(); ?>

		</div>


			<?php if ( $external_url ) : ?>
		<a href="<?php echo esc_url( $external_url ); ?>" class="button margin-top-large">Event
			Information</a>
		<?php endif; ?>

		<a href="mailto:meeting@cncf.io"
			class="button secondary-color margin-top-large">Arrange Meeting with
			CNCF</a>



		<?php endwhile; ?>
	</article>
</main>
