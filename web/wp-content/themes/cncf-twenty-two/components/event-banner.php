<?php
/**
 * Event Banner
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

$mobile_image_id  = get_post_meta( get_the_ID(), 'lf_event_mobile_banner', true );
$desktop_image_id = get_post_meta( get_the_ID(), 'lf_event_desktop_banner', true );
$external_url     = get_post_meta( get_the_ID(), 'lf_event_external_url', true );

if ( $desktop_image_id && $mobile_image_id ) :
	?>
<div class="event-banner has-animation-scale-2" role="banner">
	<a href="<?php echo esc_url( $external_url ); ?>" title="<?php the_title_attribute( get_the_ID() ); ?>">
		<picture>
			<source media="(max-width: 499px)"
				srcset="<?php echo esc_url( wp_get_attachment_image_url( $mobile_image_id, 'full', false ) ); ?>">
			<source media="(min-width: 500px)"
				srcset="<?php echo esc_url( wp_get_attachment_image_url( $desktop_image_id, 'full', false ) ); ?>">
			<?php
			LF_Utils::display_responsive_images(
				$desktop_image_id,
				'full',
				'1200px',
				null,
				'lazy',
				the_title_attribute(
					array(
						'post' => get_the_ID(),
						'echo' => 0,
					)
				)
			);
			?>
		</picture>
	</a>
</div>
	<?php // Keep this spacer as its conditionally needed based on an event being displayed. ?>
<div style="height:100px" aria-hidden="true"
	class="wp-block-spacer is-style-60-100"></div>
	<?php
endif;
