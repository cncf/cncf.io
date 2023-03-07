<?php
/**
 * Event - Mega Menu
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

$external_url     = get_post_meta( get_the_ID(), 'lf_event_external_url', true );
$event_start_date = get_post_meta( get_the_ID(), 'lf_event_date_start', true );
$event_end_date   = get_post_meta( get_the_ID(), 'lf_event_date_end', true );
$city             = get_post_meta( get_the_ID(), 'lf_event_city', true );
$country          = Lf_Utils::get_term_names( get_the_ID(), 'lf-country', true );
$logo_id          = get_post_meta( get_the_ID(), 'lf_event_logo', true );
$background       = get_post_meta( get_the_ID(), 'lf_event_background', true );
$color            = get_post_meta( get_the_ID(), 'lf_event_overlay_color', true );

$color ? $overlay_color = $color : $overlay_color = 'transparent';

if ( ! $city && ! $country ) {
	$location = 'TBC';
} elseif ( ! $country ) {
	$location = $city;
} elseif ( ! $city ) {
	$location = $country;
} else {
	$location = $city . ', ' . $country;
}
?>

<div class="main-menu-item">
	<div class="main-menu-item__image-wrapper">

		<a href="<?php echo esc_url( $external_url ); ?>"
			title="<?php the_title_attribute(); ?>"
			class="main-menu-item__link main-menu-item__event">

			<!-- event start  -->
			<div class="main-menu-item__event-overlay"
				style="background-color: <?php echo esc_html( $overlay_color ); ?> ">
			</div>

			<figure class="main-menu-item__event-bg-figure">
				<?php
				LF_Utils::display_responsive_images( $background, 'newsroom-194', '200px', 'main-menu-item__event-bg-image', 'lazy', get_the_title() );
				?>
			</figure>

			<div class="main-menu-item__event-content">
				<div>
						<?php
						LF_Utils::display_responsive_images( $logo_id, 'medium', '300px', 'main-menu-item__event-logo', 'lazy', get_the_title() );
						?>
					<h4><span
							class="main-menu-item__event-city"><?php echo esc_html( $location ); ?></span>
					</h4>
				</div>
			</div>

		</a>
	</div>
	<div class="main-menu-item__text-wrapper">

		<a class="author-category" title="See more in Events"
			href="<?php echo esc_url( home_url( 'events' ) ); ?>">Next Event</a>

		<span class="main-menu-item__title">
			<a href="<?php echo esc_url( $external_url ); ?>"
				title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
		</span>
		<span class="main-menu-item__date">
		<?php echo esc_html( Lf_Utils::display_event_date( $event_start_date, $event_end_date ) ); ?></span>
	</div>
</div>
