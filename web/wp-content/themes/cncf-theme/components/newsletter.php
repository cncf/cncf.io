<?php
/**
 * Newsletter
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

?>
<section class="newsletter">
<div class="container wrap">
	<h4 class="is-style-center-width-900">Subscribe to the CNCF newsletter to receive regular updates about
		webinars, events & latest news</h4>

	<form id="sfmc-form" class="newsletter-form"
		action="https://cloud.email.thelinuxfoundation.org/CNCF-Newsletter-Subscriber-Form">
		<label for="FirstName" required>
			<input type="text" name="FirstName" placeholder="Your First Name"
				required>
		</label>
		<label for="LastName" required>
			<input type="text" name="LastName" placeholder="Your Last Name"
				required>
		</label>
		<label for="EmailAddress" required>
			<input type="email" name="EmailAddress"
				placeholder="Your Email Address" required>
		</label>
		<button type="submit" class="button stocky" id="submitbtn">Subscribe</button>
		<div data-callback="onSubmit"
			data-sitekey="6LdMldUUAAAAABG2vrZ1GT7Eo_TgI-UPlG14ocVH"
			class="g-recaptcha" data-size="invisible"></div>
	</form>
	<p class="smaller-text">By submitting this form, you acknowledge that your
		information is subject to The Linux Foundation’s <a
			href="https://www.linuxfoundation.org/privacy/"
			rel="norefferer noopener" target="_blank">Privacy Policy</a>.</p>
	<div id="message"></div>
	</div>
</section>
