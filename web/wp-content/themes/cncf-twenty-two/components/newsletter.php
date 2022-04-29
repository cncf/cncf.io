<?php
/**
 * Newsletter
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

?>
<section class="newsletter" id="newsletter">

	<p
		class="newsletter__title is-style-max-width-800"><strong>Subscribe</strong> for updates, event info, webinars, and the latest community news</p>

	<div style="height:60px" aria-hidden="true"
		class="wp-block-spacer is-style-20-60"></div>

	<?php echo do_shortcode( '[hubspot type=form portal=8112310 id=afe5f966-bae5-4fce-bd5d-84f7ae89111b]' ); ?>

	<div style="height:30px" aria-hidden="true"
		class="wp-block-spacer is-style-30-40"></div>

	<p
		class="newsletter__privacy">By submitting this form, you acknowledge that your information is subject to The Linux Foundation's <a href="https://www.linuxfoundation.org/privacy/">Privacy Policy</a>.</p>

	<div style="height:60px" aria-hidden="true"
		class="wp-block-spacer is-style-30-60"></div>

</section>
