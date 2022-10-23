<?php
/**
 * Event Banner - Singular Data
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

$mobile_image_id  = get_post_meta( get_the_ID(), 'lf_event_mobile_banner', true );
$desktop_image_id = get_post_meta( get_the_ID(), 'lf_event_desktop_banner', true );
$external_url     = get_post_meta( get_the_ID(), 'lf_event_external_url', true );

?>
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
