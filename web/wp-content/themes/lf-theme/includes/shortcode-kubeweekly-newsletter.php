<?php
/**
 * Kubeweekly Newsletter Shortcode
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

 /**
  * Add Kubeweekly Newsletter shortcode.
  *
  * @param array $atts Attributes.
  */
function add_kubeweekly_newsletter_shortcode( $atts ) {
	ob_start();
	?>
<div class="wp-block-group has-white-color has-tertiary-400-background-color has-text-color has-background"><div class="wp-block-group__inner-container">
<h4>Join the KubeWeekly mailing list</h4>
	<?php echo do_shortcode( '[hubspot type=form portal=8112310 id=cf924a1f-5b8b-40dc-9452-b207c494dae2]' ); ?>
<p class="has-small-font-size">By submitting this form, you acknowledge that your information is subject to The Linux Foundation’s <a href="https://www.linuxfoundation.org/privacy/" rel="noopener" class="external has-white-color" target="_blank">Privacy Policy</a>.</p>
</div></div>
	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'kubeweekly-newsletter', 'add_kubeweekly_newsletter_shortcode' );
