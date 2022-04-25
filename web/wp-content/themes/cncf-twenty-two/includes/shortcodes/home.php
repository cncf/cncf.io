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
	<div class="featured-case-studies__item">

		<a href="<?php echo esc_url( $url ); ?>" class="box-link"
			title="Read <?php echo esc_html( $company ); ?> case study"></a>

		<figure class="featured-case-studies__bg-figure">
			<?php
			LF_Utils::display_responsive_images( $background_image, 'case-study-590', '590px', 'featured-case-studies__bg-image' );
			?>
		</figure>

		<div class="featured-case-studies__text-overlay">

			<span class="author-category has-larger-style">Case Study</span>

			<figure class="featured-case-studies__logo-figure">
				<?php
				LF_Utils::display_responsive_images( $logo, 'full', '200px', 'featured-case-studies__logo' );
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

	<div class="home-intro-box">
		<h3 class="home-intro-box__title">Members</h3>
		<div class="home-intro-box__text-wrapper">
			<p><strong>Building and selling cloud native tech?</strong></p>
			<p
				class="home-intro-box__text">Shape the ecosystem and drive cross-company collaboration with more than 700 members.</p>
			<p
				class="is-style-link-cta"><a href="/about/join/">Become a Member</a></p>
		</div>
	</div>

	<div class="home-intro-box">
		<h3 class="home-intro-box__title">Contributors</h3>
		<div class="home-intro-box__text-wrapper">
			<p><strong>Looking to get involved?</strong></p>
			<p
				class="home-intro-box__text">From coders to creatives, join our welcoming, global community and advance CNCF cloud native projects.</p>
			<p
				class="is-style-link-cta"><a href="http://contribute.cncf.io/">Start Contributing</a></p>
		</div>
	</div>

	<div class="home-intro-box">
		<h3 class="home-intro-box__title">End Users</h3>
		<div class="home-intro-box__text-wrapper">
			<p><strong>Using cloud native technologies?</strong></p>
			<p
				class="home-intro-box__text">Accelerate your adoption in close collaboration with peers, project maintainers, and CNCF.</p>
			<p
				class="is-style-link-cta"><a href="/enduser/">Join the Community</a></p>
		</div>
	</div>

	<div class="home-intro-box">
		<h3 class="home-intro-box__title">New to CNCF?</h3>
		<img class="home-intro-box__goldie" loading="lazy"
			src="<?php LF_utils::get_image( 'home-goldie.png' ); ?>"
			alt="Goldie">
		<div class="home-intro-box__text-wrapper">
			<p
				class="is-style-link-cta"><a href="/about/who-we-are/">Learn More</a></p>
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

		<div style="height:60px" aria-hidden="true"
			class="wp-block-spacer is-style-30-60"></div>

		<p
			class="home-ambassadors__text">CNCF is deeply committed to the success of our community and ensure individuals carve their own path in the cloud native ecosystem, no matter their background or future goals. </p>
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
	$ambassadors = LF_utils::get_ambassadors();

	if ( $ambassadors && count( $ambassadors ) > 0 ) :

		// Grab first 4 for initial load.
		$initial_ambassadors = array_slice( $ambassadors, 0, 4 );
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
				loading="lazy"
				src="<?php echo esc_url( $ambassador['image'] ); ?>"
				class="home-ambassadors-heptagons__image"></a>
			<?php
			$count++;
		}
		?>
		<a class="home-ambassadors-heptagons__link home-ambassadors-heptagons__animate home-ambassadors-heptagons__lg05"
			title="Join the Foundation of Doers - with Priyanka Sharma"
			href="https://www.youtube.com/watch?v=u71aL6aVDPg">
			<img alt="Priyanka Sharma" loading="lazy"
				src="<?php echo esc_url( get_template_directory_uri() . '/images/home-ambassador-priyanka.jpg' ); ?>"
				class="home-ambassadors-heptagons__image"></a>

		<svg class="home-ambassadors-heptagons__sm01" aria-hidden="true">
			<use xlink:href="#small-heptagon"
				xmlns:xlink="http://www.w3.org/1999/xlink"></use>
		</svg>
		<svg class="home-ambassadors-heptagons__sm02" aria-hidden="true">
			<use xlink:href="#small-heptagon"
				xmlns:xlink="http://www.w3.org/1999/xlink"></use>
		</svg>
		<svg class="home-ambassadors-heptagons__sm03" aria-hidden="true">
			<use xlink:href="#small-heptagon"
				xmlns:xlink="http://www.w3.org/1999/xlink"></use>
		</svg>
		<svg class="home-ambassadors-heptagons__sm04" aria-hidden="true">
			<use xlink:href="#small-heptagon"
				xmlns:xlink="http://www.w3.org/1999/xlink"></use>
		</svg>
		<svg class="home-ambassadors-heptagons__sm05" aria-hidden="true">
			<use xlink:href="#small-heptagon"
				xmlns:xlink="http://www.w3.org/1999/xlink"></use>
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
					<?php echo wp_json_encode( $ambassadors ); ?>;

				// Get matchMedia setting.
				let motionMatchMedia = window.matchMedia(
					'(prefers-reduced-motion)');

				// Stop script if user wants reduced motion.
				if (motionMatchMedia.matches) {
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

					function preloadImage(url, callback){
						var img = new Image();
						img.src = url;
						console.log('image ' + url + ' has been loaded')
						img.onload = callback;
					}

					function getDelay() {
						const displayTimes = ["7000", "4750",
							"3500", "4000", "15500", "6000"
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

						preloadImage( nextAmbassador['image'], fadeAndSwitch() )

						function fadeAndSwitch(){
							console.log('fade and switch is called')
							element.classList.remove("fade-out");
							element.classList.add("fade-in");
							setTimeout(() => {
								element.children[0].alt = nextAmbassador['title'];
								element.title =	'View ' + nextAmbassador['title'];
								element.href = nextAmbassador['link'];
								element.children[0].src = nextAmbassador['image'];
								element.classList.remove("fade-in");
								element.classList.add("fade-out");
							}, 400);
						}
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

		<div style="height:60px" aria-hidden="true"
			class="wp-block-spacer is-style-30-60"></div>

		<p
			class="home-terminal__text">We drive team velocity through cross-industry collaboration, contributions, and guidance from experienced practitioners. Whether your background is technical or creative, everybody is welcome to join us in making cloud native ubiquitous.</p>

	</div>

	<div class="home-terminal__code-block">

		<div class="home-terminal__download">
			<a href="https://github.com/cncf/cncf.io/tree/main/web/wp-content/themes/cncf-twenty-two/source/terminal/"
				class="box-link" title="Download CNCF Theme for Terminal"></a>

			<img class="home-terminal__download-image" width="35" height="23" role="presentation"
				loading="lazy"
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
