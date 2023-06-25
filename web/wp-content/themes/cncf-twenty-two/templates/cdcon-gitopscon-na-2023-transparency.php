<?php
/**
 * Template Name: cdCon + GitOpsCon NA 23 Transparency
 * Template Post Type: lf_report
 *
 * File for the cdCon + GitOpsCon NA 2023 Transparency Report
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

// Report folder in images/ folder.
$report_folder = 'reports/cdcon-gitopscon-na-2023/';

get_template_part( 'components/header' );

get_template_part( 'components/skip-link-target' );

wp_enqueue_style( 'cdcon-gitopscon-na-2023', get_template_directory_uri() . '/build/cdcon-gitopscon-na-2023-transparency.min.css', array(), filemtime( get_template_directory() . '/build/cdcon-gitopscon-na-2023-transparency.min.css' ), 'all' );

wp_enqueue_style( 'wp-block-group' );
wp_enqueue_style( 'wp-block-column' );
wp_enqueue_style( 'wp-block-columns' );

?>

<link rel="preload"
	href="<?php echo esc_url( get_template_directory_uri() . '/build/cdcon-gitopscon-na-2023-transparency.min.css' ); ?>"
	as="style" crossorigin="anonymous" />

<main class="cdcon-gitopscon-na-2023">
	<article class="container wrap">

		<!-- Hero -->
		<section class="hero alignfull background-image-wrapper">
			<figure class="background-image-figure">

				<picture>
					<source media="(max-width: 499px)"
						srcset="<?php echo esc_url( wp_get_attachment_image_url( 91082, 'full', false ) ); ?>">
					<source media="(min-width: 500px)"
						srcset="<?php echo esc_url( wp_get_attachment_image_url( 91089, 'full', false ) ); ?>">
					<?php
					LF_Utils::display_responsive_images(
						91089,
						'full',
						'1200px',
						null,
						'eager',
						'A graphical representation of the city skyline in Vancouver Canada against the mountains.'
					);
					?>
				</picture>

			</figure>
			<div class="background-image-text-overlay">
				<div class="container wrap hero__container">

					<div class="hero__wrapper">
						<img class="hero__logo"
							src="<?php LF_Utils::get_svg( $report_folder . 'cdcon-gitopscon-na-23-logo.svg', true ); ?>"
							width="293" height="119"
							alt="cdCon + GitOpsCon Logo" loading="eager">

						<img class=""
							src="<?php LF_Utils::get_svg( $report_folder . 'cdcon-gitopscon-na-23-hero-text.svg', true ); ?>"
							width="625" height="184" alt="Transparency Report"
							loading="eager">

						<div class="hero__button-share-align">

							<?php
							get_template_part( 'components/social-share' );
							?>
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

					<p>In the fast-moving cloud native ecosystem, empowering end users to stay ahead of the curve is imperative. With so many organizations using CD and GitOps practices and technologies to build new features quickly, reliably, and securely, it was a natural evolution for the CNCF and CD Foundation to combine <a href="https://events.linuxfoundation.org/cdcon-gitopscon/">cdCon + GitOpsCon</a> into an event specifically designed for CD and GitOps practitioners.</p>

					<p>Bringing together the CD and GitOps communities at this event enables projects, users, and organizations to collaborate and shape the future of CD and GitOps, and I was delighted to see highly experienced and respected engineers from all across the world helping organizations to evolve their processes.</p>

					<p>I hope you find this information valuable and look forward to seeing you in Shanghai this September for <a href="https://www.lfasiallc.com/kubecon-cloudnativecon-open-source-summit-china/">KubeCon + CloudNativeCon + Open Source Summit China</a>, or at another CNCF event this year.</p>

					<div class="section-01__author">
						<?php LF_Utils::display_responsive_images( 91084, 'full', '75px', null, 'lazy', 'Priyanka Sharma - Executive Director, CNCF' ); ?>
						<p><strong>Priyanka Sharma</strong><br>
						Executive Director, CNCF</p>
					</div>
				</div>

				<div class="section-01__grid-col2">

					<!-- Icon 1  -->
					<div class="icon-box-1">
						<div class="icon">
							<img loading="lazy" width="39" height="43"
								src="<?php LF_Utils::get_svg( $report_folder . 'icon-badge.svg', true ); ?>"
								alt="Badge icon">
						</div>
						<div class="text">
							<span>284</span><br />
							Attendees
						</div>
					</div>

					<!-- Icon 2  -->
					<div class="icon-box-1">
						<div class="icon">
							<img loading="lazy" width="45" height="40"
								src="<?php LF_Utils::get_svg( $report_folder . 'icon-heart.svg', true ); ?>"
								alt="Heart icon">
						</div>
						<div class="text">
							<span>259</span><br />
							CFPs submitted
						</div>
					</div>

					<!-- Icon 3  -->
					<div class="icon-box-1">
						<div class="icon">
							<img loading="lazy" width="40" height="50"
								src="<?php LF_Utils::get_svg( $report_folder . 'icon-location.svg', true ); ?>"
								alt="Location icon">
						</div>
						<div class="text">
							<span>79</span><br />
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
						<h3 class="sub-header">Photo Highlights</h3>
					</div>
					<div class="wp-block-column is-vertically-aligned-bottom"
						style="flex-basis:20%">
						<p
							class="has-text-align-right is-style-link-cta"><a href="https://www.flickr.com/photos/143247548@N03/sets/72177720308143215/" title="cdCon + GitOpsCon North America 2023 Photo Gallery">See more</a></p>
					</div>
				</div>

				<div class="section-02__slider">
					<div>
						<?php LF_Utils::display_responsive_images( 91071, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from cdCon + GitOpsCon North America 2023 Photo Gallery' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 91072, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from cdCon + GitOpsCon North America 2023 Photo Gallery' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 91073, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from cdCon + GitOpsCon North America 2023 Photo Gallery' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 91074, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from cdCon + GitOpsCon North America 2023 Photo Gallery' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 91075, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from cdCon + GitOpsCon North America 2023 Photo Gallery' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 91076, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from cdCon + GitOpsCon North America 2023 Photo Gallery' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 91077, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from cdCon + GitOpsCon North America 2023 Photo Gallery' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 91078, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from cdCon + GitOpsCon North America 2023 Photo Gallery' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 91079, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from cdCon + GitOpsCon North America 2023 Photo Gallery' ); ?>
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


				<?php LF_Utils::display_responsive_images( 91080, 'full', '1200px', null, 'lazy', 'Demographics from  cdCon + GitOpsCon North America 2023 - 52% Men, 13% Women, 1% Non-Binary/Other, 34% preferred not to say.' ); ?>

				<div aria-hidden="true" class="report-spacer-120"></div>

				<div class="quote-with-name-container">
					<p
						class="quote-with-name-container__quote">Many people talk about GitOps and Kubernetes, but when Brendan Burns, a Microsoft Corporate Vice President, a Distinguished Engineer at Microsoft Azure, and, oh yeah, co-founder of Kubernetes, talks, I listen. Burns spoke at The Linux Foundation's GitOpsCon about how GitOps is an evolutionary step for Kubernetes.</p>
					<div class="quote-with-name-container__marks">
						<h3 class="quote-with-name-container__name">Steven J.
							Vaughan Nichols</h3>
						<p
							class="quote-with-name-container__position">The New Stack</p>
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

				<div class="section-04__data-grid">
					<div class="data">
						<h3>259</h3>
						<h4>CFP Submissions</h4>
					</div>
					<div class="data">
						<h3>107</h3>
						<h4>Speakers</h4>
					</div>
					<div class="data">
						<h3>23</h3>
						<h4>Women, Non-Binary & Other</h4>
					</div>
					<div class="data">
						<h3>59</h3>
						<h4>Breakout Sessions</h4>
					</div>
					<div class="data">
						<h3>17</h3>
						<h4>Lightning Talks & Demos</h4>
					</div>
					<div class="data">
						<h3>11</h3>
						<h4>Keynotes</h4>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<h3 class="larger-sub-header text-center">Watch the sessions
				</h3>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="wp-block-lf-youtube-lite">
					<lite-youtube videoid="V1e6bFJMvn4"
						videotitle="Watch Welcoming Remarks from cdCon + GitOpsCon North America 2023"
						webpStatus="1" sdthumbStatus="0"
						title="Play Welcoming Remarks">
					</lite-youtube>
				</div>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<div class="wp-block-button aligncenter"><a href="https://www.youtube.com/playlist?list=PLj6h78yzYM2M3-reG8FBlsE5s7P_UOvl4"
						title="Watch the cdCon + GitOpsCon North America 2023 Sessions on the CNCF YouTube"
						class="wp-block-button__link fit-content">Watch on CNCF
						YouTube</a>
					<a href="https://www.youtube.com/playlist?list=PL2KXbZ9-EY9TV7_fwDCl1Wid8_ugpE08h"
						title="Watch the cdCon + GitOpsCon North America 2023 Sessions on the CDF YouTube"
						class="wp-block-button__link fit-content">Watch on CDF
						YouTube</a>
				</div>

				<div class="shadow-hr"></div>

				<div class="lf-grid section-04__grid">
					<div class="section-04__grid-col1">
						<h3 class="sub-header">Diversity, Equity & Inclusivity
						</h3>

						<p>CNCF strived to ensure that everyone who participated in cdCon + GitOpsCon felt welcome, regardless of gender, gender identity, sexual orientation, disability, race, ethnicity, age, religion, or economic status. The Dan Kohn Scholarship Fund provided funding for 2 people to attend, and 18 speakers received travel funding. Further, we provided 22 attendees with Registration Scholarships. As part of our deep commitment to diversity, equity and inclusivity, we hosted workshops and networking opportunities to help connect individuals to opportunities within tech, such as the EmpowerUs Lunch.</p>
					</div>

					<div class="section-04__grid-col2">
						<h3 class="sub-header">Gold CHAOSS D&I Event Badge</h3>

						<img src="<?php LF_Utils::get_image( $report_folder . 'logo-d&i-gold.svg', true ); ?>"
							width="291" height="70" alt="D&I Gold logo"
							loading="lazy">

						<div aria-hidden="true" class="report-spacer-40"></div>

						<p>Awarded to events in the open source community that <a href="https://events.linuxfoundation.org/cdcon-gitopscon/attend/diversity-inclusion/#chaoss-badge">foster healthy D&I practices</a>.</p>
					</div>
				</div>
			</div>
		</section>

		<!-- Sponsors -->
		<section class="section-05 is-style-down-gradient alignfull">

			<div class="container wrap">
				<h2 class="section-header text-center">Thank you to our sponsors
				</h2>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<h3 class="sub-header text-center">Gold Sponsors</h3>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<!-- Start of gold sponsors  -->
				<div class="sponsors-logos largest even">
					<div class="sponsors-logo-item"><a
							href="https://www.armory.io/"
							title="Go to Armory KubeCon" target="_blank"
							rel="no"><img width="352" height="105"
								src="https://events.linuxfoundation.org/wp-content/uploads/2022/06/Armory-blue-01.svg"
								class="logo wp-post-image"
								alt="Armory KubeCon logo" decoding="async"
								loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://www.opsmx.com/" title="Go to OpsMx"
							target="_blank" rel="noopener"><img width="1153"
								height="373"
								src="https://events.linuxfoundation.org/wp-content/uploads/2020/09/OpsMx-logo-New.svg"
								class="logo wp-post-image" alt="OpsMx logo"
								decoding="async" loading="lazy"></a></div>
				</div>
				<!-- End of gold sponsors  -->

				<div class="shadow-hr"></div>

				<h3 class="sub-header text-center">Silver sponsors</h3>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<!-- Start of silver sponsors  -->
				<div class="sponsors-logos larger even">
					<div class="sponsors-logo-item"><a
							href="https://harness.io/" title="Go to harness"
							target="_blank" rel="noopener"><img width="400"
								height="245"
								src="https://events.linuxfoundation.org/wp-content/uploads/harness-spn.svg"
								class="logo wp-post-image" alt="harness logo"
								decoding="async" loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://www.puppet.com/"
							title="Go to puppet by perforce" target="_blank"
							rel="noopener"><img width="237" height="98"
								src="https://events.linuxfoundation.org/wp-content/uploads/2023/03/logo-puppet-reg-tagline.svg"
								class="logo wp-post-image"
								alt="puppet by perforce logo logo"
								decoding="async" loading="lazy"></a></div>
				</div>
				<!-- End of silver sponsors -->

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="wp-block-button"><a href="https://events.linuxfoundation.org/cdcon-gitopscon/"
						title="See all Sponsors and Partners of cdCon + GitOpsCon North America 2023"
						class="wp-block-button__link">See all Sponsors &
						Partners</a>
				</div>

				<div class="shadow-hr"></div>

				<div class="lf-grid">
					<div class="restrictive-7-col">
						<h3 class="sub-header">Upcoming Events</h3>
						<div aria-hidden="true" class="report-spacer-40"></div>
						<p>Join adopters and technologists from leading open source and cloud native communities, alongside maintainers of <a href="https://www.cncf.io/projects/">CNCF Projects</a>, at our events dedicated to advancing cloud native computing through practitioner-led education and collaboration.</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<?php
				echo do_shortcode( '[event_banner hide_title=true]' );
				?>

				<div class="social-share">
					<?php
					get_template_part( 'components/social-share' );
					?>
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
	'cdcon-gitopscon-na-2023-report',
	get_template_directory_uri() . '/source/js/on-demand/cdcon-gitopscon-na-2023-report.js',
	array( 'jquery', 'slick' ),
	filemtime( get_template_directory() . '/source/js/on-demand/cdcon-gitopscon-na-2023-report.js' ),
	true
);

get_template_part( 'components/footer' );
