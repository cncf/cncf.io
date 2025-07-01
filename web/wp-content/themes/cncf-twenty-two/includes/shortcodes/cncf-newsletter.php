<?php
/**
 * CNCF Newsletter Form Shortcode
 *
 * Usage
 * [cncf-newsletter-form]
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

/**
 * Add CNCF Newsletter form shortcode.
 *
 * @param array $atts Attributes.
 */
function add_cncf_newsletter_form_shortcode( $atts ) {
	ob_start();
	?>
<div class="wp-block-group is-style-border has-white-background-color has-background kubeweekly-newsletter">
<h3 class="is-style-spaced-uppercase">SIGN UP FOR THE CNCF NEWSLETTER</h3>
<div style="height:25px" aria-hidden="true" class="wp-block-spacer"></div>
	<?php echo do_shortcode( '[hubspot type=form portal=8112310 id=09f362ba-f95c-4f58-9ad7-f879432e0a3d]' ); ?>
	<div style="height:15px" aria-hidden="true" class="wp-block-spacer is-style-40-responsive"></div>
</div>
	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'cncf-newsletter-form', 'add_cncf_newsletter_form_shortcode' );
