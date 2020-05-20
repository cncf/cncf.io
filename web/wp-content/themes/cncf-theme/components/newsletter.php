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
	<label for="FirstName"><h4 class="is-style-center-width-900">Subscribe to the CNCF newsletter to receive regular updates about
		webinars, events & latest news</h4></label>

	<form id="sfmc-form1" class="newsletter-form"
		action="https://cloud.email.thelinuxfoundation.org/CNCF-Newsletter-Subscriber-Form">
		<label for="FirstName" required>
		<span class="screen-reader-text">First Name</span>
			<input type="text" id="FirstName" name="FirstName" placeholder="Your First Name" autocomplete="given-name" spellcheck="false"
				required>
		</label>
		<label for="LastName" required>
		<span class="screen-reader-text">Last Name</span>
			<input type="text" id="LastName" name="LastName" placeholder="Your Last Name" autocomplete="family-name" spellcheck="false"
				required>
		</label>
		<label for="EmailAddress" required>
		<span class="screen-reader-text">Email Address</span>
			<input type="email" id="EmailAddress" name="EmailAddress"
				placeholder="Your Email Address" autocomplete="email" spellcheck="false" required>
		</label>
		<button type="submit" class="button stocky" id="sfmc-submit1">Subscribe</button>
		<div id="recaptcha-form1" style="display:none;"></div>
	</form>
	<div id="sfmc-message1" class="form-message"></div>
	<p class="smaller-text">By submitting this form, you acknowledge that your
		information is subject to The Linux Foundation’s <a
			href="https://www.linuxfoundation.org/privacy/"
			rel="norefferer noopener" class="external" target="_blank">Privacy Policy</a>.</p>
	</div>
</section>
