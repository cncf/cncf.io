<?php
/**
 * Template Name: CNSC NA 23 Transparency
 * Template Post Type: lf_report
 *
 * File for the CNSC NA 2023 Transparency Report
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

// Report folder in images/ folder.
$report_folder = 'reports/cnsc-na-23/';

get_template_part( 'components/header' );

get_template_part( 'components/skip-link-target' );

wp_enqueue_style( 'cnsc-na-23', get_template_directory_uri() . '/build/cnsc-na-23-transparency.min.css', array(), filemtime( get_template_directory() . '/build/cnsc-na-23-transparency.min.css' ), 'all' );

wp_enqueue_style( 'wp-block-group' );
wp_enqueue_style( 'wp-block-column' );
wp_enqueue_style( 'wp-block-columns' );

// setup social share icons + data.
$caption      = 'Read the CloudNativeSecurityCon North America 2023 Transparency Report ';
$page_url     = rawurlencode( get_permalink() );
$caption      = htmlspecialchars( rawurlencode( html_entity_decode( $caption, ENT_COMPAT, 'UTF-8' ) ), ENT_COMPAT, 'UTF-8' );
$options      = get_option( 'lf-mu' );
$twitter      = $options && $options['social_twitter_handle'] ? $options['social_twitter_handle'] : null;
$twitter_url  = 'https://twitter.com/intent/tweet?text=' . $caption . '&amp;url=' . $page_url . '&amp;hashtags=cncf&amp;via=' . $twitter . '';
$linkedin_url = 'https://www.linkedin.com/shareArticle?mini=true&url=' . $page_url . '&summary=' . $caption;
$mailto_url   = 'mailto:?subject=' . $caption . '&body=' . $caption . '&nbsp;' . $page_url;
?>

<link rel="prefetch"
	href="<?php echo esc_url( get_template_directory_uri() . '/build/cnsc-na-23-transparency.min.css' ); ?>"
	as="style" crossorigin="anonymous" />

<main class="cnsc-na-23">
	<article class="container wrap">

		<!-- Hero -->
		<section class="hero alignfull background-image-wrapper">
			<figure class="background-image-figure darken-on-mobile">
				<?php LF_Utils::display_responsive_images( 84379, 'full', '1440px', false, 'eager', 'CloudNativeSecurityCon North America 2023 Transparency Report' ); ?>
			</figure>
			<div class="background-image-text-overlay">
				<div class="container wrap hero__container">

					<div class="hero__wrapper">
						<img class="hero__logo"
							src="<?php LF_Utils::get_svg( $report_folder . 'CloudNativeSecurityCon-Icon.svg', true ); ?>"
							width="309" height="119"
							alt="CloudNativeSecurityCon North America 2023 Logo"
							loading="eager">

						<h1 class="hero__title">Transparency<br>Report</h1>

						<div class="hero__hr"></div>

						<div class="hero__button-share-align">

							<div class="social-share">
								<p class="social-share__title">Share</p>

								<div class="social-share__wrapper">
									<!-- linkedin -->
									<?php if ( $linkedin_url ) : ?>
									<a aria-label="Share on Linkedin"
										title="Share on Linkedin"
										href="<?php echo esc_url( $linkedin_url ); ?>"><?php Lf_Utils::get_svg( 'reports/social-linkedin.svg' ); ?></a>
									<?php endif; ?>

									<!-- twitter -->
									<?php if ( $twitter_url ) : ?>
									<a aria-label="Share on Twitter"
										title="Share on Twitter"
										href="<?php echo esc_url( $twitter_url ); ?>"><?php Lf_Utils::get_svg( 'reports/social-twitter.svg' ); ?></a>
									<?php endif; ?>

									<!-- sendto email -->
									<?php if ( $mailto_url ) : ?>
									<a aria-label="Share by Email"
										title="Share by Email"
										href="<?php echo esc_url( $mailto_url ); ?>"><?php Lf_Utils::get_svg( 'reports/social-mail.svg' ); ?></a>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<!-- Intro -->
		<section class="section-01">
			<div class="lf-grid">
				<h2 class="section-01__title">Foreword</h2>
			</div>
			<div class="lf-grid section-01__grid">
				<div class="section-01__grid-col1">

					<p>What started as a co-located event alongside KubeCon + CloudNativeCon has officially grown into a major industry convention – in fact, the first cloud native security event of its kind. The inaugural CloudNativeSecurityCon drew almost 800 experts and practitioners from across the world to share insights and experiences on the unique security challenges faced by cloud native technology.</p>

					<p>Security is people-powered, and we all benefit by collaborating together as a knowledgeable, vendor-neutral community to develop the tools and processes that are going to uplevel our security posture. The conversations we had and the lessons we learned together at CNSC helped us make great strides towards tackling security challenges within the cloud native ecosystem.</p>

					<p>I hope you find this information valuable and look forward to seeing you in Amsterdam this April for <a href="#">KubeCon + CloudNativeCon Europe</a>.</p>

					<div class="section-01__author">
						<?php LF_Utils::display_responsive_images( 82008, 'full', '75px', null, 'lazy', 'Priyanka Sharma' ); ?>
						<p><strong>Priyanka Sharma</strong><br>
						Executive Director, CNCF</p>
					</div>
				</div>

				<div class="section-01__grid-col2">

					<!-- Icon 1  -->
					<div class="icon-box-1">
						<div class="icon">
							<img loading="lazy" width="39" height="43" src="<?php LF_Utils::get_svg( $report_folder . 'icon-badge.svg', true ); ?>" alt="Badge icon">
						</div>
						<div class="text">
							<span>778</span><br />
							Attendees
						</div>
					</div>

					<!-- Icon 2  -->
					<div class="icon-box-1">
						<div class="icon">
							<img loading="lazy" width="45" height="40" src="<?php LF_Utils::get_svg( $report_folder . 'icon-heart.svg', true ); ?>" alt="Heart icon">
						</div>
						<div class="text">
							<span>274</span><br />
							CFPs submitted
						</div>
					</div>

					<!-- Icon 3  -->
					<div class="icon-box-1">
						<div class="icon">
							<img loading="lazy" width="45" height="33" src="<?php LF_Utils::get_svg( $report_folder . 'icon-location.svg', true ); ?>" alt="Location icon">
						</div>
						<div class="text">
							<span>28</span><br />
							Countries represented
						</div>
					</div>
				</div>
			</div>
		</section>

		<!-- Photo Highlights  -->
		<section class="section-02">

			<div class="wp-block-group is-style-no-padding is-style-see-all">
				<div class="wp-block-columns are-vertically-aligned-centered">
					<div class="wp-block-column is-vertically-aligned-centered"
						style="flex-basis:80%">
						<h3 class="sub-header">Seattle photo highlights</h3>
					</div>
					<div class="wp-block-column is-vertically-aligned-bottom"
						style="flex-basis:20%">
						<p
							class="has-text-align-right is-style-link-cta"><a href="#" title="CNSC North America 2023 Photo Gallery">See more</a></p>
					</div>
				</div>

				<div class="section-02__slider">
					<div>
						<?php LF_Utils::display_responsive_images( 84381, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from CNSC North America 2023 Photo Gallery' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 84382, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from CNSC North America 2023 Photo Gallery' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 84383, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from CNSC North America 2023 Photo Gallery' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 84384, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from CNSC North America 2023 Photo Gallery' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 84385, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from CNSC North America 2023 Photo Gallery' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 84386, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from CNSC North America 2023 Photo Gallery' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 84387, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from CNSC North America 2023 Photo Gallery' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 84388, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from CNSC North America 2023 Photo Gallery' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 84389, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from CNSC North America 2023 Photo Gallery' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 84390, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from CNSC North America 2023 Photo Gallery' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 84391, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from CNSC North America 2023 Photo Gallery' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 84392, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from CNSC North America 2023 Photo Gallery' ); ?>
					</div>
				</div>
				<div class="section-02__controls">
					<button class="button-reset  section-02__prev"><svg
							width="12" height="19" viewBox="0 0 12 19"
							fill="none" xmlns="http://www.w3.org/2000/svg">
							<path
								d="M10.4131 17.627L2.41309 9.62695L10.4131 1.62695"
								stroke="black" stroke-width="3" />
						</svg>
						<span class="screen-reader-text">Previous
							Photo</span>
					</button>
					<button class="button-reset section-02__next"><svg
							width="12" height="19" viewBox="0 0 12 19"
							fill="none" xmlns="http://www.w3.org/2000/svg">
							<path
								d="M1.41309 1.62695L9.41309 9.62695L1.41309 17.627"
								stroke="black" stroke-width="3" />
						</svg>
						<span class="screen-reader-text">Next Photo</span>
					</button>
				</div>
			</div>
		</section>

		<!-- Demographics -->
		<section class="section-03 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">Demographics</h2>
					<div class="section-number">1/2</div>
				</div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>CloudNativeSecurityCon North America was attended by 778 individuals, who came mostly from the USA, but also from as far as New Zealand and Turkey. </p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="responsive-image">
					<?php Lf_Utils::get_svg( $report_folder . '/CNSC-NA-23-demographics.svg' ); ?>
				</div>

				<div aria-hidden="true" class="report-spacer-120"></div>

				<div class="quote-with-name-container">
					<p
						class="quote-with-name-container__quote">“I wrote about my excitement for CloudNativeSecurityCon when it was announced at KubeCon+CloudNativeCon 2022 because I believe these shows should be increasingly important for security teams and security vendors. CNSC has an opportunity to become a top security conference to help security teams support cloud native development.</p>
					<div class="quote-with-name-container__marks">
						<p
							class="quote-with-name-container__name">Melinda Marks</p>
						<p
							class="quote-with-name-container__position"><a href="https://www.techtarget.com/searchsecurity/opinion/Top-takeaways-from-first-CloudNativeSecurityCon">TechTarget</a></p>
					</div>
				</div>
			</div>
		</section>


		<!-- Content -->
		<section class="section-04 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">Content</h2>
					<div class="section-number">2/2</div>
				</div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>CloudNativeSecurityCon was packed with 72 sessions for all levels of technologists, curated by co-chairs Emily Fox, Cloud Security Services & Compliance Engineer, Apple; Liz Rice, Chief Open Source Officer, Isovalent; and Brandon Lum, OSS Security Software Engineer, Google.</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-120"></div>

				<div class="section-04__data-grid">
					<div class="data">
						<h3>109</h3>
						<h4>Speakers</h4>
					</div>
					<div class="data">
						<h3>26</h3>
						<h4>Women, non binary & other speakers</h4>
					</div>
					<div class="data">
						<h3>24</h3>
						<h4>Speakers who identify as a person of color</h4>
					</div>
					<div class="data">
						<h3>274</h3>
						<h4>Proposals submitted</h4>
					</div>
					<div class="data">
						<h3>66</h3>
						<h4>Breakout sessions</h4>
					</div>
					<div class="data">
						<h3>14</h3>
						<h4>Keynotes</h4>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header text-center">Watch the sessions</p>

				<div aria-hidden="true" class="report-spacer-70"></div>

				<div class="wp-block-lf-youtube-lite">
					<lite-youtube videoid="Q1cA0iGw84g"
						videotitle="Highlights from CloudNativeSecurityCon North America 2023"
						webpStatus="0" sdthumbStatus="1"
						title="Play Highlights">
					</lite-youtube>
				</div>

				<div aria-hidden="true" class="report-spacer-120"></div>

				<div class="quote-with-name-container">
					<p
						class="quote-with-name-container__quote">“One of the insights from the event was that the security community has come to realize it must focus more heavily on resolving vulnerabilities faster while taking a proactive approach toward thwarting breaches.</p>
					<div class="quote-with-name-container__marks">
						<p
							class="quote-with-name-container__name">Mark Albertson</p>
						<p
							class="quote-with-name-container__position"><a href="https://siliconangle.com/2023/02/06/first-ever-cloudnativesecuritycon-offers-insights-into-ongoing-challenge-of-protecting-vital-architectures-cnscon/">SiliconANGLE</a></p>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<div class="section-04__grid-col2">
					<div>
						<h3 class="sub-header">Diversity, Equity & Inclusivity</h3>

						<p>CNCF strived to ensure that everyone who participated in CloudNativeSecurityCon felt welcome, regardless of gender, gender identity, sexual orientation, disability, race, ethnicity, age, religion, or economic status. The Dan Kohn Scholarship Fund provided funding for 26 people to attend, and 13 speakers received travel funding. As part of our deep commitment to diversity, equity and inclusivity, we hosted workshops and networking opportunities to help connect individuals to opportunities within tech, such as the EmpowerUs Cloud Native Security Lunch.</p>
					</div>

					<div>
						<h3 class="sub-header">Gold chaoss D&I event badge</h3>

						<img class="hero__logo"
							src="<?php LF_Utils::get_image( $report_folder . 'dandigold.jpg', true ); ?>"
							width="291" height="70"
							alt="D&I Gold logo"
							loading="lazy">

						<p>Awarded to events in the open source community that foster healthy D&I practices</p>
					</div>
				</div>
			</div>
		</section>

		<!-- Sponsors -->
		<section class="section-05 is-style-down-gradient alignfull">

			<div class="container wrap">
				<h2 class="section-header text-center">Thank you to our sponsors</h2>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<p class="sub-header text-center">Diamond Sponsors</p>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<!-- Start of diamond sponsors  -->
				<div class="sponsors-logos largest even orphan-by-5">
					<div class="sponsors-logo-item"><a href="https://www.cisco.com/" target="_blank" rel="noopener"><img width="246" height="60" src="<?php LF_Utils::get_image( $report_folder . 'cisco.svg', true ); ?>" class="logo wp-post-image" alt="Cisco Logo" decoding="async" loading="lazy"></a></div>

					<div class="sponsors-logo-item"><a href="https://www.redhat.com/" target="_blank" rel="noopener"><img width="237" height="56" src="<?php LF_Utils::get_image( $report_folder . 'red-hat.svg', true ); ?>" class="logo wp-post-image" alt="Red Hat Logo" decoding="async" loading="lazy"></a></div>

					<div class="sponsors-logo-item"><a href="https://www.suse.com/" target="_blank" rel="noopener"><img width="112" height="97" src="<?php LF_Utils::get_image( $report_folder . 'suse.svg', true ); ?>" class="logo wp-post-image logo--suse" alt="Suse Logo" decoding="async" loading="lazy"></a></div>

					<div class="sponsors-logo-item"><a href="https://sysdig.com/" target="_blank" rel="noopener"><img width="202" height="72" src="<?php LF_Utils::get_image( $report_folder . 'sysdig.svg', true ); ?>" class="logo wp-post-image" alt="sysdig Logo" decoding="async" loading="lazy"></a></div>

					<div class="sponsors-logo-item"><a href="https://tetrate.io/" target="_blank" rel="noopener"><img width="217" height="50" src="<?php LF_Utils::get_image( $report_folder . 'tetrate.svg', true ); ?>" class="logo wp-post-image" alt="tetrate Logo" decoding="async" loading="lazy"></a></div>

					<div class="sponsors-logo-item"><a href="https://www.uptycs.com/" target="_blank" rel="noopener"><img width="185" height="56" src="<?php LF_Utils::get_image( $report_folder . 'uptycs.svg', true ); ?>" class="logo wp-post-image" alt="uptycs Logo" decoding="async" loading="lazy"></a></div>
				</div>
				<!-- End of diamond sponsors  -->

				<div class="shadow-hr"></div>

				<p class="sub-header text-center">Platinum sponsors</p>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<!-- Start of platinum sponsors  -->
				<div class="sponsors-logos larger odd orphan-by-4 orphan-by-8">
					<div class="sponsors-logo-item"><a href="https://www.checkpoint.com/" target="_blank" rel="noopener"><img width="219" height="46" src="<?php LF_Utils::get_image( $report_folder . 'check-point.svg', true ); ?>" class="logo wp-post-image" alt="Check Point Logo" decoding="async" loading="lazy"></a></div>

					<div class="sponsors-logo-item"><a href="https://about.gitlab.com/" target="_blank" rel="noopener"><img width="215" height="46" src="<?php LF_Utils::get_image( $report_folder . 'gitlab.svg', true ); ?>" class="logo wp-post-image" alt="Gitlab Logo" decoding="async" loading="lazy"></a></div>

					<div class="sponsors-logo-item"><a href="https://opensearch.org/" target="_blank" rel="noopener"><img width="250" height="47" src="<?php LF_Utils::get_image( $report_folder . 'opensearch.svg', true ); ?>" class="logo wp-post-image" alt="Open Search Logo" decoding="async" loading="lazy"></a></div>

					<div class="sponsors-logo-item"><a href="https://openssf.org/" target="_blank" rel="noopener"><img width="200" height="75" src="<?php LF_Utils::get_image( $report_folder . 'openssf.svg', true ); ?>" class="logo wp-post-image" alt="Open SSF Logo" decoding="async" loading="lazy"></a></div>

					<div class="sponsors-logo-item"><a href="https://www.sonatype.com/" target="_blank" rel="noopener"><img width="214" height="37" src="<?php LF_Utils::get_image( $report_folder . 'sonatype.svg', true ); ?>" class="logo wp-post-image" alt="Sonatype Logo" decoding="async" loading="lazy"></a></div>

					<div class="sponsors-logo-item"><a href="https://www.vmware.com/" target="_blank" rel="noopener"><img width="220" height="35" src="<?php LF_Utils::get_image( $report_folder . 'vmware.svg', true ); ?>" class="logo wp-post-image" alt="vmware Logo" decoding="async" loading="lazy"></a></div>
				</div>
				<!-- End of platinum sponsors -->

				<div class="wp-block-button"><a
						href="https://events.linuxfoundation.org/kubecon-cloudnativecon-europe/"
						title="See all Sponsors and Partners of CloudNativeSecurityCon North America 2023 Logo"
						class="wp-block-button__link">See
						all Sponsors and Partners</a>
				</div>

				<div class="shadow-hr"></div>

				<div class="lf-grid">
					<div class="restrictive-7-col">
						<p class="sub-header">KubeCon + CloudNativeCon Europe 2023</p>

						<p>Join adopters and technologists from leading open source and cloud native communities, alongside maintainers of <a href="https://www.cncf.io/projects/">CNCF Projects</a> for four days dedicated to advancing cloud native computing through practitioner-led education and collaboration.</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<a href="https://events.linuxfoundation.org/kubecon-cloudnativecon-europe/register/">
					<figure>
						<?php LF_Utils::display_responsive_images( 84378, 'full', '1200px', false, 'lazy', 'Kubecon + CloudNativeSecurityCon Europe 2023 - Amsterdam - April 18-21 - Register Now' ); ?>
					</figure>
				</a>

				<div class="shadow-hr"></div>

				<div class="social-share">
					<p class="social-share__title">Share this report</p>

					<div class="social-share__wrapper">
						<!-- twitter -->
						<?php if ( $twitter_url ) : ?>
							<a aria-label="Share on Twitter"
								title="Share on Twitter"
								href="<?php echo esc_url( $twitter_url ); ?>"><?php Lf_Utils::get_svg( 'reports/social-twitter.svg' ); ?></a>
						<?php endif; ?>

						<!-- linkedin -->
						<?php if ( $linkedin_url ) : ?>
							<a aria-label="Share on Linkedin"
								title="Share on Linkedin"
								href="<?php echo esc_url( $linkedin_url ); ?>"><?php Lf_Utils::get_svg( 'reports/social-linkedin.svg' ); ?></a>
						<?php endif; ?>

						<!-- sendto email -->
						<?php if ( $mailto_url ) : ?>
							<a aria-label="Share by Email" title="Share by Email"
								href="<?php echo esc_url( $mailto_url ); ?>"><?php Lf_Utils::get_svg( 'reports/social-mail.svg' ); ?></a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</section>
	</article>
</main>
<?php

// youtube lite script.
wp_enqueue_script(
	'youtube-lite-js',
	home_url() . '/wp-content/mu-plugins/wp-mu-plugins/lf-blocks/src/youtube-lite/scripts/lite-youtube.js',
	null,
	filemtime( WPMU_PLUGIN_DIR . '/wp-mu-plugins/lf-blocks/dist/blocks.build.js' ),
	true
);

// load slick css.
wp_enqueue_style( 'slick-css', get_template_directory_uri() . '/build/slick.min.css', array(), filemtime( get_template_directory() . '/build/slick.min.css' ), 'all' );

// load main slick.
wp_enqueue_script( 'slick', get_template_directory_uri() . '/source/js/libraries/slick.min.js', array( 'jquery' ), filemtime( get_template_directory() . '/source/js/libraries/slick.min.js' ), true );

// custom scripts.
wp_enqueue_script(
	'cnsc-na-23-report',
	get_template_directory_uri() . '/source/js/on-demand/cnsc-na-23-report.js',
	array( 'jquery', 'slick' ),
	filemtime( get_template_directory() . '/source/js/on-demand/cnsc-na-23-report.js' ),
	true
);

get_template_part( 'components/footer' );
