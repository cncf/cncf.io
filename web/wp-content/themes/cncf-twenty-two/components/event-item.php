<?php
/**
 * Event Item
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

if ( ! $city && ! $country ) {
	$location = 'TBC';
} elseif ( ! $country ) {
	$location = $city;
} elseif ( ! $city ) {
	$location = $country;
} else {
	$location = $city . ', ' . $country;
}

$logo = get_post_meta( get_the_ID(), 'lf_event_logo', true );

$background = get_post_meta( get_the_ID(), 'lf_event_background', true );

$color = get_post_meta( get_the_ID(), 'lf_event_overlay_color', true );

$color ? $overlay_color = $color : $overlay_color = 'transparent';

?>
<div class="event-item has-animation-scale-2">

	<div class="event-item__overlay"
		style="background-color: <?php echo esc_html( $overlay_color ); ?> ">
	</div>

	<?php if ( $background ) : ?>
	<figure class="event-item__bg-figure">
		<?php
		LF_Utils::display_responsive_images( $background, 'event-380', '380px', 'event-item__bg-image', 'lazy', get_the_title() );

		?>
	</figure>
	<?php endif; ?>

	<a href="<?php echo esc_url( $external_url ); ?>"
	title="<?php the_title_attribute(); ?>">
	<div class="event-item__content">
		<div>
			<?php if ( $logo ) : ?>
				<?php
				LF_Utils::display_responsive_images( $logo, 'medium', '300px', 'event-item__logo', 'lazy', get_the_title() );
				?>
			<?php else : ?>
			<h3 class="event-item__title"><?php the_title(); ?>
			</h3>
			<?php endif; ?>

			<h4><span class="event-item__date">
					<?php
					echo esc_html( Lf_Utils::display_event_date( $event_start_date, $event_end_date ) );
					?>
				</span>
				<span
					class="event-item__city"><?php echo esc_html( $location ); ?></span>
			</h4>
		</div>
	</div>
	</a>
</div>
