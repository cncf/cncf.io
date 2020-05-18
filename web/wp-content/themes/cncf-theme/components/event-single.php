<?php
/**
 * Events content - the loop
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

// event host.
$event_host = Cncf_Utils::get_term_names( get_the_ID(), 'cncf-event-host', true );

// external URL.
$external_url = get_post_meta( get_the_ID(), 'cncf_event_external_url', true );

$event_start_date = get_post_meta( get_the_ID(), 'cncf_event_date_start', true );

$event_end_date = get_post_meta( get_the_ID(), 'cncf_event_date_end', true );

$city = get_post_meta( get_the_ID(), 'cncf_event_city', true );

$country = Cncf_Utils::get_term_names( get_the_ID(), 'cncf-country', true );

if ( ! $city && ! $country ) {
	$location = 'TBC';
} elseif ( ! $country ) {
	$location = $city;
} else {
	$location = $city . ', ' . $country;
}

$logo = get_post_meta( get_the_ID(), 'cncf_event_logo', true );

$background = get_post_meta( get_the_ID(), 'cncf_event_background', true );

$color = get_post_meta( get_the_ID(), 'cncf_event_overlay_color', true );

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

			<?php
			if ( $event_host ) :
				?>
		<div class="skew-box centered"><?php echo esc_html( $event_host ); ?> Event</div>
			<?php endif; ?>

<div class="event-box background-image-wrapper box-shadow">

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
			title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
				<?php endif; ?>
		</a>
	</div>

	<span class="event-date">
			<?php
				echo esc_html( Cncf_Utils::display_event_date( $event_start_date, $event_end_date ) );
			?>
	</span>
	<span
		class="event-city"><?php echo esc_html( $location ); ?></span>
</div>
</div>


			<div class="entry-content">

			<?php the_content(); ?>

		</div>


			<?php if ( $external_url ) : ?>
		<a href="<?php echo esc_url( $external_url ); ?>" class="button">Event Information</a>
<?php endif; ?>

<a href="mailto:meeting@cncf.io" class="button secondary-color margin-top-large">Arrange Meeting with CNCF</a>



		<?php endwhile; ?>
	</article>
</main>
