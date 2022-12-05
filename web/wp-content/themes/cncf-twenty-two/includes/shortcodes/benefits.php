<?php
/**
 * CNCF Benefits Shortcode
 *
 * Shows benefits of joining with pop-out modals.
 *
 * Usage
 * [benefits]
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

/**
 * Benefits shortcode
 */
function add_cncf_benefits_shortcode() {

	wp_enqueue_script(
		'modal',
		get_template_directory_uri() . '/source/js/on-demand/modal.js',
		array( 'jquery' ),
		filemtime( get_template_directory() . '/source/js/on-demand/modal.js' ),
		true
	);

	wp_enqueue_style( 'wp-block-paragraph' );
	wp_enqueue_style( 'wp-block-heading' );

	ob_start();
	?>
<section class="benefits columns-three columns-two-on-mobile">

	<div class="benefits__item">

		<button class="js-modal button-reset" data-modal-prefix-class="generic"
			data-modal-content-id="modal-amplify" title="">

			<div class="benefits__image-wrapper">
				<img src="<?php LF_utils::get_svg( 'cncf-icon-amplify.svg', true ); ?>"
					alt="Icon of sound being amplified" width="117" height="100"
					loading="lazy">
			</div>

			<div style="height:50px" aria-hidden="true"
				class="wp-block-spacer is-style-25-50"></div>

			<p
				class="has-larger-font-size">Amplify your brand & people across the industry</p>

			<div style="height:60px" aria-hidden="true"
				class="wp-block-spacer is-style-20-60"></div>

			<p class="is-style-link-cta">Learn More</p>

		</button>

		<!-- Modal -->
		<div class="modal-hide" id="modal-amplify" aria-hidden="true">
			<div class="modal-content-wrapper">

				<div class="benefits-col1">
					<img src="<?php LF_utils::get_svg( 'cncf-icon-amplify.svg', true ); ?>"
						alt="Icon of sound being amplified" width="117"
						height="100" loading="lazy">
				</div>

				<div class="modal__content">

					<p
						class="is-style-spaced-uppercase has-larger-font-size">Amplify your brand <br class="show-over-1000">across the industry</p>

					<div style="height:30px" aria-hidden="true"
						class="wp-block-spacer"></div>

					<h4 class="has-large-font-size">Leverage CNCF's global reach to drive your go-to-market strategies with CNCF marketing programs:</h4>

					<div style="height:30px" aria-hidden="true"
						class="wp-block-spacer"></div>

					<ul class="is-style-more-spacing">
						<li>CNCF Marketing Committee: Engage with your peers and
							hear first about program updates and marketing
							opportunities.</li>
						<li><a href="/blog">CNCF Blog</a>: Reach a 45,000+
							monthly audience by contributing informative,
							vendor-neutral content.</li>
						<li><a href="https://kubernetes.io/blog/">Kubernetes
								Blog</a> &amp; <a
								href="/kubeweekly">KubeWeekly</a>: Content by
							the community, for the community.</li>
						<li>Public Relations &amp; Analyst Relations Support:
							CNCF provides quarterly analyst reports including
							Top Analysts by keyword, quotes, and research
							highlights. </li>
						<li><a
								href="https://www.cncf.io/events/kubecon-cloudnativecon-north-america-2021/">KubeCon
								+ CloudNativeCon</a>: Take advantage of
							exclusive member-only opportunities at the world’s
							largest open source developer conferences focused on
							cloud native technologies, from keynotes to media
							engagement.</li>

					</ul>
				</div>
			</div>
		</div>
		<!-- end of modal  -->
	</div>

	<!-- 2 -->
	<div class="benefits__item">

		<button class="js-modal button-reset" data-modal-prefix-class="generic"
			data-modal-content-id="modal-showcase" title="">
			<div class="benefits__image-wrapper">
				<img src="<?php LF_utils::get_svg( 'cncf-icon-rocket.svg', true ); ?>"
					alt="Icon of rocket" width="116" height="116"
					loading="lazy">
			</div>
			<div style="height:50px" aria-hidden="true"
				class="wp-block-spacer is-style-25-50"></div>

			<p
				class="has-larger-font-size">Showcase thought leadership for key technology trends</p>

			<div style="height:60px" aria-hidden="true"
				class="wp-block-spacer is-style-20-60"></div>

			<p class="is-style-link-cta">Learn More</p>

		</button>

		<!-- Modal -->
		<div class="modal-hide" id="modal-showcase" aria-hidden="true">
			<div class="modal-content-wrapper">

				<div class="benefits-col1">
					<img src="<?php LF_utils::get_svg( 'cncf-icon-rocket.svg', true ); ?>"
						alt="Icon of rocket" width="116" height="116"
						loading="lazy">
				</div>

				<div class="modal__content">

					<p
						class="is-style-spaced-uppercase has-larger-font-size">Showcase thought leadership<br class="show-over-1000">across key technology trends</p>

					<div style="height:30px" aria-hidden="true"
						class="wp-block-spacer"></div>

					<h4 class="has-large-font-size">Engage with our project’s ecosystems, network with fellow members, and help shape the cloud-native market though:</h4>

					<div style="height:30px" aria-hidden="true"
						class="wp-block-spacer"></div>

					<ul class="is-style-more-spacing">
						<li><a href="/certification/software-conformance/">Certified
								Kubernetes</a>: Certification is free for
							members, allows the use of trademarked “Kubernetes”
							in your product name, and ensures that your version
							of Kubernetes supports the required APIs.</li>
						<li><a href="/certification/kcsp/">Kubernetes Certified
								Service Provider (KCSP):</a> Highlight your
							organisation as a pre-qualified and vetted service
							provider with deep experience helping enterprises
							successfully adopt Kubernetes.</li>
						<li><a
								href="/certification/training/#kubernetestrainingpartners">Kubernetes
								Training Partner (KTP)</a>: Join the KTP
							program, featuring training providers with deep
							experience in cloud native technology training.</li>
						<li><a
								href="https://github.com/cncf/toc/blob/master/CONTRIBUTING.md">TOC
								Contributor</a>: Have the opportunity to sit on
							CNCF’s Technical Oversight Committee (TOC), to
							provides technical leadership to the cloud native
							community.</li>
						<li><a href="https://landscape.cncf.io/">Interactive
								Landscape Placement:</a> Secure your spot on
							this comprehensive view of all the cloud native
							products and projects available in the ecosystem,
							which had 5.9M pageviews in 2020 alone.</li>
						<li><a href="/people/governing-board/">Governing Board
								Participation</a>: Vote in elections to serve on
							the <a
								href="https://www.cncf.io/people/governing-board/">Governing
								Board</a>, and oversee the vision of CNCF,
							working with the TOC.&nbsp;</li>
						<li>Market Research: CNCF provides independent market
							research so members can keep their pulse on the open
							source ecosystem and where technology trends are
							heading.</li>
					</ul>
				</div>
			</div>
		</div>
		<!-- end of modal  -->
	</div>

	<!-- 3 -->
	<div class="benefits__item">

		<button class="js-modal button-reset" data-modal-prefix-class="generic"
			data-modal-content-id="modal-engage" title="">
			<div class="benefits__image-wrapper">
				<img src="<?php LF_utils::get_svg( 'cncf-icon-meetups1.svg', true ); ?>"
					alt="Icon of meetup to imply community" width="124"
					height="110" loading="lazy">
			</div>
			<div style="height:50px" aria-hidden="true"
				class="wp-block-spacer is-style-25-50"></div>

			<p class="has-larger-font-size">Engage with the cloud
native community</p>

			<div style="height:60px" aria-hidden="true"
				class="wp-block-spacer is-style-20-60"></div>

			<p class="is-style-link-cta">Learn More</p>

		</button>

		<!-- Modal -->
		<div class="modal-hide" id="modal-engage" aria-hidden="true">
			<div class="modal-content-wrapper">

				<div class="benefits-col1">
					<img src="<?php LF_utils::get_svg( 'cncf-icon-meetups1.svg', true ); ?>"
						alt="Icon of meetup to imply community" width="124"
						height="110" loading="lazy">
				</div>

				<div class="modal__content">

					<p class="is-style-spaced-uppercase has-larger-font-size">Engage with the <br class="show-over-1000">cloud
native community</p>

					<div style="height:30px" aria-hidden="true"
						class="wp-block-spacer"></div>

					<h4 class="has-large-font-size">Connect with the foundation of doers to attract high calibre engineering talent and change the future of cloud native:</h4>

					<div style="height:30px" aria-hidden="true"
						class="wp-block-spacer"></div>

					<ul class="is-style-more-spacing">
						<li><a href="/newsroom/case-studies/">End User Case
								Studies</a>: Elevate technical conversations to
							business objectives and challenges, and showcase
							your journey on the CNCF homepage.</li>
						<li><a href="/people/ambassadors/">Ambassador
								Program</a>: Become a cloud native advocate,
							recognized for your expertise in the cloud native
							space.</li>
						<li><a href="https://kubernetes.io/partners/">Kubernetes.io
								Partner Placement: </a>Drive leads with
							inclusion on separate lists for Certified
							Kubernetes, KCSP, and KTP partners. One CNCF member
							reports 18% of incoming leads start from
							kubernetes.io or cncf.io.</li>
						<li><a href="https://kubernetescommunitydays.org/">Kubernetes
								Community Days</a>: Run a local event to bring
							together the cloud native community in your region.
							CNCF provides the platform, guidelines, and tooling
							to help make your event a success.</li>
						<li><a
								href="https://www.linuxfoundation.org/membership/">Linux
								Foundation Membership</a>: When you join CNCF,
							you also join the LF, so you can engage with the
							larger open source community, including
							representatives from more than 1,000 of the world's
							top technology companies.</li>
					</ul>
				</div>
			</div>
		</div>
		<!-- end of modal  -->
	</div>

</section>

	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'benefits', 'add_cncf_benefits_shortcode' );
