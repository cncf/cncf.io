<?php
/**
 * Newsletter
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

?>
<section class="newsletter" id="newsletter">
	<h3>Subscribe to the CNCF newsletter to receive regular updates about
		webinars, events & latest news</h3>

	<form id="sfmc-form1" class="newsletter-form"
		action="https://cloud.email.thelinuxfoundation.org/CNCF-Newsletter-Subscriber-Form">
		<label for="FirstName" required>
		<span class="screen-reader-text">First Name</span>
			<input type="text" id="FirstName" name="FirstName" placeholder="First Name" autocomplete="given-name" spellcheck="false"
				required>
		</label>
		<label for="LastName" required>
		<span class="screen-reader-text">Last Name</span>
			<input type="text" id="LastName" name="LastName" placeholder="Last Name" autocomplete="family-name" spellcheck="false"
				required>
		</label>
		<label for="EmailAddress" required>
		<span class="screen-reader-text">Email Address</span>
			<input type="email" id="EmailAddress" name="EmailAddress"
				placeholder="Email Address" autocomplete="email" spellcheck="false" required>
		</label>
		<label for="Language" required>
		<span class="screen-reader-text">Language</span>
			<select id="Language" name="Language" class="form-control select-css newsletter-select" required onchange="this.dataset.selected = this.value;">
			<option value="" disabled>Language</option>
				<option value="English">English</option>
				<option value="Chinese">中文</option>
			</select>
		</label>
		<button type="submit" class="button" id="sfmc-submit1">Subscribe</button>
		<div id="recaptcha-form1" style="display:none;"></div>
	</form>
	<div id="sfmc-message1" class="form-message"></div>
	<p class="privacy-agreement">By submitting this form, you acknowledge that your
		information is subject to The Linux Foundation’s <a
			href="https://www.linuxfoundation.org/privacy/"
			rel="noopener" class="external is-white" target="_blank">Privacy Policy</a>.</p>
</section>
