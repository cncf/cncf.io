<?php
/**
 * Webinar Footer
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

$image = new Image();
?>
<section class="webinar-footer">
	<div class="wrap background-image-wrapper">

		<figure class="background-image-figure">
			<img src="<?php $image->get_image( 'get-involved.jpg' ); ?>"
				alt="Get involved">
		</figure>

		<div class="background-image-text-overlay webinar-footer-text-wrap">

			<h2>Get involved</h2>
			<h5>CNCF webinars are a great way to educate new and existing
				community members about trends and new technologies. We’re
				looking for project maintainers, CNCF members, and community
				experts to share their knowledge. Webinars are non-promotional
				and focus on education and thought-leadership within the cloud
				native space.</h5>

			<h5 class="margin-bottom-large">Interested in hosting a CNCF
				webinar?</h5>

			<a title="Host a CNCF webinar" href="mailto:webinars@cncf.io"
				class="button outline transparent">Let us know</a>

		</div>

	</div>
</section>
