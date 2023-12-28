<?php
/**
 * Newsletter
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

?>
<div class="newsletter" id="newsletter">

	<p
		class="newsletter__title is-style-max-width-800"><strong>Subscribe</strong> for updates, event info, webinars, and the latest community news</p>

	<div style="height:60px" aria-hidden="true"
		class="wp-block-spacer is-style-20-60"></div>

	<?php echo do_shortcode( '[hubspot type=form portal=8112310 id=be1b038f-98de-43b5-b211-d5f7bf6510c9]' ); ?>

	<div style="height:30px" aria-hidden="true"
		class="wp-block-spacer is-style-30-40"></div>

	<p
		class="newsletter__privacy">By submitting this form, you acknowledge that your information is subject to The Linux Foundation's <a href="https://www.linuxfoundation.org/privacy/">Privacy Policy</a>.</p>

	<div style="height:60px" aria-hidden="true"
		class="wp-block-spacer is-style-30-60"></div>

</div>
