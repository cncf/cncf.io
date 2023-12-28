<?php
/**
 * Training Newsletter Shortcode
 *
 * Usage
 * [training-newsletter]
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

/**
 * Add Training Newsletter shortcode.
 *
 * @param array $atts Attributes.
 */
function add_training_newsletter_shortcode( $atts ) {
	ob_start();
	?>
<div class="wp-block-group is-style-box-shadow has-white-background-color has-background kubeweekly-newsletter">
<p class="is-style-spaced-uppercase">Join The Training Mailing List</p>
<div style="height:25px" aria-hidden="true" class="wp-block-spacer"></div>
<p>Stay up-to-date on all things Training + Certification by signing up for our mailing list:</p>
<div style="height:25px" aria-hidden="true" class="wp-block-spacer"></div>
	<?php echo do_shortcode( '[hubspot type=form portal=8112310 id=d0e38e69-887b-42e6-af9f-923f5c0cf5f3]' ); ?>
</div>
	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'training-newsletter', 'add_training_newsletter_shortcode' );
