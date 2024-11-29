<?php
/**
 * Banner ad Shortcode
 *
 * Usage example:
 * [banner-ad desktop_image_id=120425 mobile_image_id=120426
 * external_url="https://training.linuxfoundation.org/cyber-monday-cncf-2024/"
 * alt_txt="CNCF Cyber Monday - Save up to 60%"]
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

/**
 * Add Banner ad shortcode.
 *
 * @param array $atts Attributes.
 */
function add_banner_ad_shortcode( $atts ) {

	// Attributes.
	$atts = shortcode_atts(
		array(
			'desktop_image_id' => '', // set default.
			'mobile_image_id'  => '', // set default.
			'external_url'     => '', // set default.
			'alt_txt'          => '', // set default.
		),
		$atts,
		'banner-ad'
	);
	$desktop_image_id = $atts['desktop_image_id'];
	$mobile_image_id  = $atts['mobile_image_id'];
	$external_url     = $atts['external_url'];
	$alt_txt          = $atts['alt_txt'];

	ob_start();
	?>
<div class="has-animation-scale-2" role="banner">
	<a href="<?php echo esc_url( $external_url ); ?>" title="<?php echo esc_attr( $alt_txt ); ?>">
		<picture>
			<source media="(max-width: 499px)"
				srcset="<?php echo esc_url( wp_get_attachment_image_url( $mobile_image_id, 'full', false ) ); ?>">
			<source media="(min-width: 500px)"
				srcset="<?php echo esc_url( wp_get_attachment_image_url( $desktop_image_id, 'full', false ) ); ?>">
			<img src="<?php echo esc_url( wp_get_attachment_image_url( $desktop_image_id, 'full', false ) ); ?>"
				alt="<?php echo esc_attr( $alt_txt ); ?>">
		</picture>
	</a>
</div>
<div style="height:60px" aria-hidden="true" class="wp-block-spacer"></div>

	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'banner-ad', 'add_banner_ad_shortcode' );
