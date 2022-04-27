<?php
/**
 * Next Event
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

$site_options = get_option( 'lf-mu' );

$event_logo_id             = $site_options['event_logo_id'] ?? '';
$event_background_image_id = $site_options['event_background_image_id'] ?? '';
$event_background_color    = $site_options['event_background_color'] ?? '';
$event_cta_color           = $site_options['event_cta_color'] ?? '';
$event_cta_text            = $site_options['event_cta_text'] ?? '';
$event_cta_link            = $site_options['event_cta_link'] ?? '';
$event_text                = $site_options['event_text'] ?? '';

if ( $event_logo_id && $event_cta_text && $event_cta_link ) :
	?>
<div class="next-event has-animation-scale-2" role="banner"
	style="background: <?php echo esc_attr( $event_background_color ); ?>;">
	<a class="box-link"	href="<?php echo esc_url( $event_cta_link ); ?>" title="The next event from CNCF"></a>

	<div class="next-event__column-wrapper">
		<div class="next-event__col1">

			<div class="next-event__text-wrapper">
				<?php
				Lf_Utils::display_responsive_images( $event_logo_id, 'full', '200px', 'next-event__logo', 'lazy', 'The next event from CNCF' );
				?>

				<span
					class="next-event__text"><?php echo esc_html( $event_text ); ?></span>

				<button
					class="wp-block-button__link button-reset has-background"
					style="background: <?php echo esc_attr( $event_cta_color ); ?>;"><?php echo esc_html( $event_cta_text ); ?></button>
			</div>
		</div>

		<div class="next-event__col2">
			<figure class="next-event__figure">
				<?php
				Lf_Utils::display_responsive_images( $event_background_image_id, 'full', '600px', 'next-event__bg-image' );
				?>
			</figure>
		</div>

	</div>


</div>

	<?php
endif
?>
