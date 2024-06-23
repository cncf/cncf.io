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

	<?php echo do_shortcode( '[hubspot type=form portal=8112310 id=8b58547e-6341-48d5-9440-764ed4f15e13]' ); ?>

	<div style="height:30px" aria-hidden="true"
		class="wp-block-spacer is-style-30-40"></div>

	<p
		class="newsletter__privacy">By submitting this form, I consent to receive marketing emails from the LF and its projects regarding their events, training, research, developments, and related announcements. I understand that I can unsubscribe at any time using the links in the footers of the emails I receive. <a href="https://www.linuxfoundation.org/privacy/">Privacy Policy</a>.</p>

	<div style="height:60px" aria-hidden="true"
		class="wp-block-spacer is-style-30-60"></div>

</div>
