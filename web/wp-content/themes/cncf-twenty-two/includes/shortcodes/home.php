<?php
/**
 * Shortcode
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

/**
 * Display Case Studies rotator banner on home page.
 * [home_case_studies ids="34,22,122"]
 *
 * @param array $atts Attributes.
 */
function add_home_case_studies_shortcode( $atts ) {

	// Attributes.
	$atts = shortcode_atts(
		array(
			'ids' => '', // set default.
		),
		$atts,
		'home_case_studies'
	);

	$selected_ids = explode( ',', $atts['ids'] );
	shuffle( $selected_ids );
	$finals_ids = array_slice( $selected_ids, 0, 2 );

	ob_start();
	?>

<div class="featured-case-studies columns-two">

	<?php

	foreach ( $finals_ids as $id ) :

		$company     = get_the_title( $id );
		$description = get_post_meta( $id, 'lf_case_study_long_title', true );
		$url         = get_permalink( $id );
		$logo        = get_post_meta( $id, 'lf_case_study_homepage_company_logo', true );
		if ( ! $logo ) {
			$logo = get_post_meta( $id, 'lf_case_study_company_logo', true );
		}
		$background_image = get_post_meta( $id, 'lf_case_study_homepage_image', true );
		if ( ! $background_image ) {
			// use the regular listing background image if no homepage image exists.
			$image = get_post_thumbnail_id( $id );
		}
		?>
	<div class="featured-case-studies__item has-animation-scale-2">

		<a href="<?php echo esc_url( $url ); ?>" class="box-link"
			title="Read <?php echo esc_html( $company ); ?> case study"></a>

		<figure class="featured-case-studies__bg-figure">
			<?php
			LF_Utils::display_responsive_images( $background_image, 'case-study-590', '590px', 'featured-case-studies__bg-image', 'lazy', get_the_title() );
			?>
		</figure>

		<div class="featured-case-studies__text-overlay">

			<span class="author-category has-larger-style">Case Study</span>

			<figure class="featured-case-studies__logo-figure">
				<?php
				LF_Utils::display_responsive_images( $logo, 'full', '200px', 'featured-case-studies__logo', 'lazy', get_the_title() );
				?>
			</figure>
			<p class="featured-case-studies__description">
		<?php echo esc_html( $description ); ?>
</p>

		</div>

	</div>

		<?php
endforeach;
	?>
</div>

	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'home_case_studies', 'add_home_case_studies_shortcode' );

/**
 * Intro boxes shortcode.
 *
 * Usage:
 * [home_intro_boxes]
 */
function add_home_intro_boxes_shortcode() {

	ob_start();
	?>
<div class="home-intro-boxes columns-three">

	<div class="home-intro-box has-animation-bump">
		<h3 class="home-intro-box__title">Members</h3>
		<div class="home-intro-box__text-wrapper">
			<p><strong>Building and selling cloud native tech?</strong></p>
			<p
				class="home-intro-box__text">Shape the ecosystem and drive cross-company collaboration with more than 700 members.</p>
			<p
				class="is-style-link-cta"><a href="/about/join/">Become a Member</a></p>
		</div>
	</div>

	<div class="home-intro-box has-animation-bump">
		<h3 class="home-intro-box__title">Contributors</h3>
		<div class="home-intro-box__text-wrapper">
			<p><strong>Looking to get involved?</strong></p>
			<p
				class="home-intro-box__text">From coders to creatives, join our welcoming, global community and advance CNCF cloud native projects.</p>
			<p
				class="is-style-link-cta"><a href="http://contribute.cncf.io/">Start Contributing</a></p>
		</div>
	</div>

	<div class="home-intro-box has-animation-bump">
		<h3 class="home-intro-box__title">End Users</h3>
		<div class="home-intro-box__text-wrapper">
			<p><strong>Using cloud native technologies?</strong></p>
			<p
				class="home-intro-box__text">Accelerate your adoption in close collaboration with peers, project maintainers, and CNCF.</p>
			<p
				class="is-style-link-cta"><a href="/enduser/">Join the Community</a></p>
		</div>
	</div>

	<div class="home-intro-box has-animation-scale-2">
		<h3 class="home-intro-box__title">New to CNCF?</h3>
		<picture>
			<source srcset="<?php LF_utils::get_image( 'home-goldie.webp' ); ?>"
				type="image/webp">
			<img class="home-intro-box__goldie" loading="lazy" decoding="async"
				src="<?php LF_utils::get_image( 'home-goldie.png' ); ?>"
				alt="Goldie">
		</picture>
		<div class="home-intro-box__text-wrapper">
			<p
				class="is-style-link-cta"><a href="/about/who-we-are/" title="Learn more about CNCF">About CNCF</a></p>
		</div>
	</div>
</div>
	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'home_intro_boxes', 'add_home_intro_boxes_shortcode' );

/**
 * Home Ambassadors
 *
 * Usage:
 * [home_ambassadors]
 */
function add_home_ambassadors_shortcode() {

	ob_start();
	?>
<div class="home-ambassadors">

	<div class="home-ambassadors__text-wrapper">
		<h2 class="has-extra-extra-large-font-size">Together we are
			#TeamCloudNative
		</h2>

		<div style="height:40px" aria-hidden="true"
			class="wp-block-spacer is-style-20-40"></div>

		<p
			class="home-ambassadors__text">CNCF is deeply committed to the success of our community, from <a href="/people/ambassadors/">our ambassadors</a> to maintainers to first-time contributors. No matter your goals, we support your cloud native journey. </p>
	</div>

	<!-- Heptagon Clip Path  -->
	<svg class="hide-svg">
		<clipPath id="heptagon" clipPathUnits="objectBoundingBox">
			<path
				d="M0.465,0.008 L0.161,0.159 A0.078,0.078,0,0,0,0.121,0.207 L0.003,0.595 a0.077,0.077,0,0,0,0.012,0.069 l0.23,0.304 A0.079,0.078,0,0,0,0.308,1 h0.383 a0.079,0.079,0,0,0,0.063,-0.031 l0.23,-0.304 a0.078,0.078,0,0,0,0.012,-0.069 L0.879,0.206 a0.078,0.078,0,0,0,-0.04,-0.047 L0.535,0.008 a0.079,0.079,0,0,0,-0.07,0">
			</path>
		</clipPath>
	</svg>

	<!-- Small Heptagon -->
	<svg class="hide-svg" xmlns="http://www.w3.org/2000/svg">
		<symbol id="small-heptagon" viewbox="0 0 40 40" fill="currentColor"
			xmlns="http://www.w3.org/2000/svg">
			<g clip-path="url(#clip0_4409_1d889)">
				<path fill-rule="evenodd" clip-rule="evenodd"
					d="M18.594.333L6.434 6.364A3.136 3.136 0 0 0 4.83 8.261L.133 23.81a3.095 3.095 0 0 0 .497 2.768l9.19 12.173A3.14 3.14 0 0 0 12.335 40h15.33a3.162 3.162 0 0 0 2.515-1.248l9.19-12.173a3.105 3.105 0 0 0 .497-2.769L35.17 8.26a3.111 3.111 0 0 0-1.605-1.896L21.406.324a3.17 3.17 0 0 0-2.812.009z"
					fill="currentColor" />
			</g>
		</symbol>
	</svg>

	<?php
	$teamcloudnative = LF_utils::get_teamcloudnative();

	if ( $teamcloudnative && count( $teamcloudnative ) > 0 ) :

		// Grab first 5 for initial load.
		$initial_ambassadors = array_slice( $teamcloudnative, 12, 5 );
		?>
	<div class="home-ambassadors-heptagons">
		<?php
		$count = 1;
		foreach ( $initial_ambassadors as $ambassador ) {
			?>
		<a class="home-ambassadors-heptagons__link home-ambassadors-heptagons__animate home-ambassadors-heptagons__lg0<?php echo esc_html( $count ); ?>"
			title="<?php echo esc_html( 'View ' . $ambassador['title'] ); ?>"
			href="<?php echo esc_url( $ambassador['link'] ); ?>">
			<img alt="<?php echo esc_html( $ambassador['title'] ); ?>"
				loading="lazy" decoding="async"
				src="<?php echo esc_url( $ambassador['image'] ); ?>"
				class="home-ambassadors-heptagons__image"></a>
			<?php
			++$count;
		}
		?>

		<svg class="home-ambassadors-heptagons__sm01" aria-hidden="true">
			<use xlink:href="#small-heptagon"
				xmlns:xlink="http://www.w3.org/1999/xlink"></use>
		</svg>
		<svg class="home-ambassadors-heptagons__sm02" aria-hidden="true"
			width="44" height="40" viewBox="0 0 44 40" fill="none"
			xmlns="http://www.w3.org/2000/svg">
			<g clip-path="url(#clip0_5229_17420)">
				<path
					d="M23.7046 4.5188L21.7598 15.3867L24.8528 15.9402L24.0931 20.1852L33.3764 17.4655L40.0436 18.6586L41.9884 7.79072L23.7046 4.5188Z"
					stroke="url(#paint0_linear_5229_17420)"
					stroke-width="1.95529" stroke-miterlimit="10" />
				<path
					d="M34.9175 15.4629L34.0252 14.172L36.4482 12.4703L34.7656 10.0348L36.0503 9.13252L38.6251 12.8598L34.9175 15.4629Z"
					fill="black" />
				<path
					d="M27.6411 14.0615L25.0664 10.3341L28.774 7.73106L29.6661 9.02292L27.2423 10.7235L28.9257 13.1601L27.6411 14.0615Z"
					fill="black" />
				<path
					d="M33.6523 9.49402L29.3167 12.5379L30.2088 13.8298L34.5444 10.7859L33.6523 9.49402Z"
					fill="black" />
				<path
					d="M2.48911 31.331C2.48911 31.331 5.34328 27.7747 9.28414 28.4799L16.1843 29.7147C16.1843 29.7147 20.1299 30.4208 21.5688 34.7453"
					stroke="black" stroke-width="2.93294"
					stroke-miterlimit="10" />
				<path
					d="M13.2519 25.0067C15.8238 25.4669 18.2818 23.7551 18.7421 21.1832C19.2023 18.6113 17.4905 16.1532 14.9186 15.693C12.3467 15.2327 9.88862 16.9446 9.42837 19.5165C8.96812 22.0884 10.68 24.5464 13.2519 25.0067Z"
					stroke="black" stroke-width="2.93294"
					stroke-miterlimit="10" />
				<path d="M13.3599 24.4033L12.7189 27.9852" stroke="black"
					stroke-width="2.70221" stroke-miterlimit="10" />
				<path
					d="M31.7414 37.6959C30.7471 34.7222 28.0361 34.237 28.0361 34.237L23.6256 33.4478C22.4891 33.2442 21.3176 33.476 20.3442 34.0971V34.0971"
					stroke="black" stroke-width="2.05306"
					stroke-miterlimit="10" />
				<path
					d="M26.02 30.9961C27.7893 31.3127 29.4803 30.135 29.797 28.3657C30.1136 26.5963 28.9359 24.9053 27.1666 24.5887C25.3972 24.2721 23.7062 25.4497 23.3896 27.2191C23.073 28.9884 24.2506 30.6794 26.02 30.9961Z"
					stroke="black" stroke-width="1.85851"
					stroke-miterlimit="10" />
				<path d="M26.0942 30.5813L25.6532 33.0459" stroke="black"
					stroke-width="1.85851" stroke-miterlimit="10" />
			</g>
			<defs>
				<linearGradient id="paint0_linear_5229_17420" x1="21.337"
					y1="12.1994" x2="41.5455" y2="15.8158"
					gradientUnits="userSpaceOnUse">
					<stop stop-color="#ED779E" />
					<stop offset="1" stop-color="#EDA950" />
				</linearGradient>
				<clipPath id="clip0_5229_17420">
					<rect width="37" height="32.712" fill="white"
						transform="translate(6.70166 0.48291) rotate(10.1458)" />
				</clipPath>
			</defs>
		</svg>
		<svg class="home-ambassadors-heptagons__sm03" width="54" height="54"
			viewBox="0 0 54 54" fill="none" aria-hidden="true">
			<path
				d="M12.5812 37.4467L6.21875 38.6311L9.00004 53.5723L23.8923 50.8001L22.6962 44.3748L14.1664 45.9626L12.5812 37.4467Z"
				fill="#0086FF" />
			<path
				d="M44.6156 31.5558L46.1878 40.0018L37.658 41.5896L38.854 48.0149L53.7463 45.2428L50.965 30.3016L44.5327 31.4989L44.6156 31.5558Z"
				fill="#0086FF" />
			<path
				d="M3.4517 23.7667L9.88404 22.5693L9.80111 22.5124L8.22891 14.0664L16.7588 12.4786L15.5627 6.05326L0.67041 8.82544L3.4517 23.7667Z"
				fill="#0086FF" />
			<path
				d="M30.5244 3.26807L31.7205 9.69342L40.2503 8.1056L41.8356 16.6215L48.198 15.4371L45.4167 0.49589L30.5244 3.26807Z"
				fill="#0086FF" />
			<g opacity="0.8">
				<path opacity="0.8"
					d="M32.4689 18.3649L22.3539 11.4369L31.7227 9.6929L30.5266 3.26754L15.5645 6.05273L16.7605 12.4781L26.8756 19.4061L32.4689 18.3649Z"
					fill="#00CEFF" />
				<path opacity="0.8"
					d="M27.5451 34.661L21.9518 35.7022L30.3266 41.4423L31.9969 42.6433L22.698 44.3743L23.8941 50.7996L38.8563 48.0144L37.6472 41.5192L32.6014 38.1181L27.5451 34.661Z"
					fill="#00CEFF" />
				<path opacity="0.8"
					d="M41.8355 16.6217L43.5639 25.9066L41.8223 24.7117L33.4475 18.9716L34.5004 24.6278L39.4763 28.0419L44.5339 31.506L50.9662 30.3086L48.1979 15.4373L41.8355 16.6217Z"
					fill="#00CEFF" />
				<path opacity="0.8"
					d="M19.9186 29.4399L9.88645 22.5687L3.4541 23.7661L6.22107 38.6304L12.5835 37.4461L10.8551 28.1611L20.9715 35.0962L19.9186 29.4399Z"
					fill="#00CEFF" />
			</g>
		</svg>
		<svg class="home-ambassadors-heptagons__sm04" aria-hidden="true">
			<use xlink:href="#small-heptagon"
				xmlns:xlink="http://www.w3.org/1999/xlink"></use>
		</svg>
		<svg class="home-ambassadors-heptagons__sm05" aria-hidden="true"
			width="64" height="55" viewBox="0 0 64 55" fill="none"
			xmlns="http://www.w3.org/2000/svg">
			<path
				d="M63.0704 35.5326H39.4663V32.3911H59.9336V13.2496H17.5713V0.68335H63.0704V35.5326ZM20.7128 10.108H59.9289V3.8249H20.7128V10.108Z"
				fill="black" />
			<path
				d="M50.5571 8.53706C51.4246 8.53706 52.1279 7.8338 52.1279 6.96628C52.1279 6.09877 51.4246 5.39551 50.5571 5.39551C49.6896 5.39551 48.9863 6.09877 48.9863 6.96628C48.9863 7.8338 49.6896 8.53706 50.5571 8.53706Z"
				fill="black" />
			<path
				d="M55.27 8.53706C56.1375 8.53706 56.8408 7.8338 56.8408 6.96628C56.8408 6.09877 56.1375 5.39551 55.27 5.39551C54.4025 5.39551 53.6992 6.09877 53.6992 6.96628C53.6992 7.8338 54.4025 8.53706 55.27 8.53706Z"
				fill="black" />
			<path
				d="M34.3344 36.9697C34.3454 36.7356 34.3516 36.4984 34.3516 36.2612C34.355 33.5094 33.5707 30.8141 32.0913 28.4937L35.9334 25.2752L33.2254 22.0426L29.3361 25.3004C27.2175 23.4591 24.6085 22.2747 21.8278 21.8918V16.394H17.6103V21.9342C14.8552 22.3633 12.283 23.5804 10.2041 25.4386L6.15619 22.0488L3.4466 25.2815L7.49292 28.6697C6.08212 30.9526 5.33631 33.5839 5.33939 36.2675C5.33939 36.5078 5.33939 36.7388 5.35667 36.9854L0.29248 38.0566L1.16583 42.1831L6.17504 41.1228C7.21158 44.0162 9.13571 46.5082 11.6728 48.2431L9.67787 52.1952L13.4477 54.0958L15.4678 50.0951C18.3732 51.0117 21.4934 50.9914 24.3866 50.0369L26.4286 54.0896L30.1985 52.1889L28.1565 48.141C30.627 46.4081 32.4986 43.9508 33.5128 41.1087L38.5582 42.1768L39.4315 38.0503L34.3344 36.9697ZM21.8278 26.1753C23.3584 26.4741 24.8005 27.1189 26.0438 28.0602L21.8278 31.5882V26.1753ZM17.6103 26.2287V31.6447L13.4854 28.189C14.6948 27.2309 16.1048 26.5582 17.6103 26.2208V26.2287ZM10.7743 31.4201L14.9855 34.9481L9.56164 36.0963C9.58471 34.4603 10.0006 32.8539 10.7743 31.4122V31.4201ZM13.5922 44.4324C12.1674 43.3398 11.0516 41.8949 10.3549 40.24L16.349 38.9708L13.5922 44.4324ZM19.8455 46.5577C19.0198 46.5571 18.1971 46.4574 17.3951 46.2608L19.9382 41.2186L22.4624 46.2184C21.6081 46.4416 20.7285 46.553 19.8455 46.5498V46.5577ZM21.9896 37.6938L19.8518 38.7226L17.714 37.6859L17.1862 35.3722L18.6659 33.5171H21.0393L22.5174 35.3722L21.9896 37.6938ZM26.2307 44.3256L23.5447 39.0054L29.3377 40.2322C28.6623 41.8333 27.5942 43.2384 26.2323 44.3177L26.2307 44.3256ZM24.4652 34.8805L28.8178 31.2363C29.6512 32.7168 30.102 34.3819 30.1294 36.0806L24.4652 34.8805Z"
				fill="url(#paint0_linear_5380_17382)" />
			<defs>
				<linearGradient id="paint0_linear_5380_17382" x1="0.29248"
					y1="35.2402" x2="39.4362" y2="35.2402"
					gradientUnits="userSpaceOnUse">
					<stop stop-color="#3D6EDD" />
					<stop offset="0.22" stop-color="#4067E1" />
					<stop offset="0.54" stop-color="#4953EB" />
					<stop offset="0.92" stop-color="#5834FB" />
					<stop offset="1" stop-color="#5C2CFF" />
				</linearGradient>
			</defs>
		</svg>
		<svg class="home-ambassadors-heptagons__sm06" aria-hidden="true">
			<use xlink:href="#small-heptagon"
				xmlns:xlink="http://www.w3.org/1999/xlink"></use>
		</svg>
	</div>

	<script>
	(function() {
		document.addEventListener(
			'DOMContentLoaded',
			function() {

				// get the array of new elements.
				let ambassadors =
					<?php echo wp_json_encode( $teamcloudnative ); ?>;

				// Get matchMedia setting.
				let prefersReducedMotionQuery = window.matchMedia(
					'(prefers-reduced-motion: reduce)');
				let prefersReducedMotion = !prefersReducedMotionQuery ||
					prefersReducedMotionQuery.matches;

				// Stop script if user wants reduced motion.
				if (prefersReducedMotion) {
					return;
				}

				// get all the elements to change.
				let elements = document.querySelectorAll(
					'.home-ambassadors-heptagons__animate');

				// keep track of which to show next. Start at 4th element.
				let $i = 4;
				let $j = 0;

				// loop over each, and apply to each image.
				elements.forEach(function(element) {
					function getDelay() {
						const displayTimes = ["7000", "4750",
							"3500", "4000", "8000", "6000"
						];
						return parseInt(
							displayTimes[$j++]
						);
					}
					// Set Interval to loop.
					setInterval(function changeImage() {
						let nextAmbassador = ambassadors[
							$i++];
						if ($i == ambassadors.length) {
							$i = 0;
						}

						element.children[0]
							.src =
							nextAmbassador[
								'image'];
						element.children[0]
							.alt =
							nextAmbassador[
								'title'];
						element.title =
							'View ' +
							nextAmbassador[
								'title'];
						element.href =
							nextAmbassador[
								'link'];
					}, getDelay());
				});
			},
		);
	}());
	</script>
		<?php
endif;
	?>

	<div class="home-ambassadors__cta">
		<p
			class="is-style-link-cta"><a href="/people/ambassadors/">CNCF Ambassadors</a></p>
	</div>
</div>

	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'home_ambassadors', 'add_home_ambassadors_shortcode' );

/**
 * Home Terminal
 *
 * Usage:
 * [home_terminal]
 */
function add_home_terminal_shortcode() {
	ob_start();

	// load home-terminal.js.
	wp_enqueue_script( 'home-terminal', get_template_directory_uri() . '/source/js/on-demand/home-terminal.js', array(), filemtime( get_template_directory() . '/source/js/on-demand/home-terminal.js' ), false );
	?>
<div class="home-terminal">

	<div class="home-terminal__text-wrapper">

		<h2 class="has-extra-extra-large-font-size">We're redefining how
			software gets built</h2>

		<div style="height:40px" aria-hidden="true"
			class="wp-block-spacer is-style-20-40"></div>

		<p
			class="home-terminal__text">We drive team velocity through cross-industry collaboration, contributions, and guidance from experienced practitioners. Whether your background is technical or creative, everybody is welcome to join us in making cloud native ubiquitous.</p>

	</div>

	<div class="home-terminal__code-block">

		<div class="home-terminal__download">
			<a href="https://github.com/cncf/cncf.io/tree/main/web/wp-content/themes/cncf-twenty-two/source/terminal/"
				class="box-link" title="Download CNCF Theme for Terminal"></a>

			<img class="home-terminal__download-image" width="35" height="23"
				alt="" loading="lazy" decoding="async"
				src="<?php LF_utils::get_svg( 'cncf-icon-download-w.svg', true ); ?>">
			<p class="home-terminal__download-text">
Download Theme
</p>
		</div>

		<div class="home-terminal__status-bar">
			<div class="home-terminal__button"></div>
			<div class="home-terminal__button"></div>
			<div class="home-terminal__button"></div>
		</div>
		<div class="home-terminal__window">

			<img width="630" height="525"
				alt="Terminal displaying code examples for running Kubernetes cluster"
				class="home-terminal__image home-terminal__replace"
				loading="lazy"
				decoding="async"
				src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII="
				data-src="
	<?php
	LF_utils::get_svg( 'terminal.svg', true )
	?>
" data-reduced-motion-src="
	<?php
	LF_utils::get_svg( 'terminal-reduced-motion.svg', true )
	?>
	">
			<noscript>
				<img class="home-terminal__image" width="600" height="525" src="
				<?php
				LF_utils::get_svg( 'terminal.svg', true )
				?>
	" alt="Terminal displaying code examples for running Kubernetes cluster">
				<style>
				.home-terminal__replace {
					display: none;
				}

				</style>
			</noscript>
		</div>
	</div>
	<div class="home-terminal__cta">
		<p
			class="is-style-link-cta"><a href="https://contribute.cncf.io/">Contribute</a></p>
	</div>
</div>
	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'home_terminal', 'add_home_terminal_shortcode' );
