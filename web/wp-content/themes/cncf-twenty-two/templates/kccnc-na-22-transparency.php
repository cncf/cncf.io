<?php
/**
 * Template Name: KCCNC NA 22 Transparency
 * Template Post Type: lf_report
 *
 * File for the KCCNC NA 2022 Transparency Report
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

// declare the next event link and alt as a variable.
$event_link = 'https://events.linuxfoundation.org/kubecon-cloudnativecon-europe/';
$event_text = 'KubeCon + CloudNativeCon Europe 2023 from 17th-21st April';

// Report folder in images/ folder.
$report_folder = 'reports/kccnc-na-22/';

get_template_part( 'components/header' );

get_template_part( 'components/skip-link-target' );

wp_enqueue_style( 'kccnc-na-22', get_template_directory_uri() . '/build/kccnc-na-22-transparency.min.css', array(), filemtime( get_template_directory() . '/build/kccnc-na-22-transparency.min.css' ), 'all' );

wp_enqueue_style( 'wp-block-group' );
wp_enqueue_style( 'wp-block-column' );
wp_enqueue_style( 'wp-block-columns' );

// setup social share icons + data.
$caption      = 'Read the CNCF KubeCon + CloudNativeCon North America 2022 Transparency Report ';
$page_url     = rawurlencode( get_permalink() );
$caption      = htmlspecialchars( rawurlencode( html_entity_decode( $caption, ENT_COMPAT, 'UTF-8' ) ), ENT_COMPAT, 'UTF-8' );
$options      = get_option( 'lf-mu' );
$twitter      = $options && $options['social_twitter_handle'] ? $options['social_twitter_handle'] : null;
$twitter_url  = 'https://twitter.com/intent/tweet?text=' . $caption . '&amp;url=' . $page_url . '&amp;hashtags=cncf&amp;via=' . $twitter . '';
$linkedin_url = 'https://www.linkedin.com/shareArticle?mini=true&url=' . $page_url . '&summary=' . $caption;
$mailto_url   = 'mailto:?subject=' . $caption . '&body=' . $caption . '&nbsp;' . $page_url;
?>

<link rel="prefetch"
	href="<?php echo esc_url( get_template_directory_uri() . '/build/kccnc-na-22-transparency.min.css' ); ?>"
	as="style" crossorigin="anonymous" />

<main class="kccnc-na-22">
	<article class="container wrap">

		<section class="hero alignfull">
			<div class="container wrap hero__container">
				<figure class="hero__container-bg-figure">
					<?php
					LF_Utils::display_responsive_images( 82010, 'full', '1200px', 'hero__container-bg-image', 'eager', 'A cloud network graphic' );
					?>
				</figure>
				<div class="hero__content">
					<img class="hero__logo" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'kccnc-na-22-logo.svg', true );
						?>
						" width="309" height="132"
						alt="KubeCon + CloudNativeCon North America 2022 Logo"
						loading="eager">

					<h1 class="hero__title">Transparency <br />Report</h1>

					<div class="hero__hr"></div>

					<div class="social-share">
						<p class="social-share__title">Share</p>

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
							<a aria-label="Share by Email"
								title="Share by Email"
								href="<?php echo esc_url( $mailto_url ); ?>"><?php Lf_Utils::get_svg( 'reports/social-mail.svg' ); ?></a>
							<?php endif; ?>
						</div>
					</div>

					<div class="hero__jump">Jump to section:</div>
				</div>
			</div>
		</section>
		<section>
			<!-- Navigation  -->
			<div class="nav-el">
				<div class="nav-el__box">
					<a href="#attendees"
						title="Jump to Attendee Overview section"
						class="box-link"></a>
					<img loading="lazy" width="36" height="36" src="
				<?php LF_Utils::get_svg( $report_folder . 'icon-attendees.svg', true ); ?>
				" alt="Attendees icon">Attendees Overview
				</div>

				<div class="nav-el__box">
					<a href="#colocated" title="Jump to Co-located Events"
						class="box-link"></a>
					<img loading="lazy" width="36" height="36" src="
				<?php LF_Utils::get_svg( $report_folder . 'icon-colo.svg', true ); ?>
				" alt="Map pin icon">Co-located Events
				</div>

				<div class="nav-el__box">
					<a href="#content" title="Jump to Content section"
						class="box-link"></a>
					<img loading="lazy" width="36" height="36" src="
				<?php LF_Utils::get_svg( $report_folder . 'icon-content.svg', true ); ?>
				" alt="Content icon">
					Content
				</div>

				<div class="nav-el__box">
					<a href="#endusers" title="Jump to End Users section"
						class="box-link"></a>
					<img loading="lazy" width="36" height="36" src="
				<?php LF_Utils::get_svg( $report_folder . 'icon-users.svg', true ); ?>
				" alt="User icon">End Users
				</div>

				<div class="nav-el__box">
					<a href="#health" title="Jump to Health & Safety section"
						class="box-link"></a>
					<img loading="lazy" width="36" height="36"
						src="<?php LF_Utils::get_svg( $report_folder . 'icon-mask.svg', true ); ?>"
						alt="Mask icon">
					Health & Safety
				</div>

				<div class="nav-el__box">
					<a href="#media" title="Jump to Media Coverage section"
						class="box-link"></a>
					<img loading="lazy" width="36" height="36" src="
					<?php LF_Utils::get_svg( $report_folder . 'icon-media.svg', true ); ?>
					" alt="Media icon">
					Media Coverage
				</div>
			</div>
		</section>

		<!-- Intro -->
		<section class="section-01">
			<div class="lf-grid">
				<h2 class="section-01__title">What an amazing week in Detroit!
				</h2>
			</div>
			<div class="lf-grid section-01__grid">
				<div class="section-01__grid-col1">

					<p><strong>This KubeCon + CloudNativeCon #TeamCloudNative roared back. Detroit marked the first time we'd gathered in such big numbers in the Midwest, and the city did not disappoint! For many of us, we explored a new region, enjoyed some great food, and broke stereotypes with the renaissance of Detroit.</strong></p>

					<p>Project maintainers, who are the backbone of CNCF projects, were the focus and highlight at KubeCon + CloudNativeCon North America and rightly so. There are approximately 1,000 maintainers in the cloud native ecosystem catering to 175,000+ contributors and serving 7 million+ developers. Without maintainers, there is no ecosystem and it was an honor to support them with initiatives such as Security Slam and ContribFest that strengthened our security posture and brought more contributors to projects at the event.</p>

					<p>One of my personal highlights was interviewing Heba Elayoty and Yuan Tang on the keynote stage. From them we learned what research has demonstrated time and again - maintainers' biggest ask is for their employers to support them in investing working hours on open source. Companies take note!</p>

					<p>As always, KubeCon + CloudNativeCon was the place for big announcements in our industry. AWS for instance shared their commitment to supporting the Kubernetes project with cloud credits and engineering resources as the project goes on its own multi-cloud journey.</p>

					<p>There is much to unpack from this phenomenal event and I've really enjoyed looking back as we put this transparency report together for you. I hope you find the information valuable and look forward to seeing you next April in Amsterdam for <a href="<?php echo esc_url( $event_link ); ?>">KubeCon + CloudNativeCon Europe</a>!</p>

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
							<img loading="lazy" width="39" height="43" src="
						<?php LF_Utils::get_svg( $report_folder . 'icon-badge.svg', true ); ?>
						" alt="Badge icon">
						</div>
						<div class="text">
							<span>61%</span><br />
							First-time attendees
						</div>
					</div>

					<!-- Icon 2  -->
					<div class="icon-box-1">
						<div class="icon">
							<img loading="lazy" width="45" height="40" src="
						<?php LF_Utils::get_svg( $report_folder . 'icon-heart.svg', true ); ?>
						" alt="Heart icon">
						</div>
						<div class="text">
							<span>1,551</span><br />
							CFPs submitted
						</div>
					</div>

					<!-- Icon 3  -->
					<div class="icon-box-1">
						<div class="icon">
							<img loading="lazy" width="45" height="33" src="
						<?php LF_Utils::get_svg( $report_folder . 'icon-megaphone.svg', true ); ?>
						" alt="Megaphone icon">
						</div>
						<div class="text">
							<span>3,833+</span><br />
							Pieces of media coverage
						</div>
					</div>

					<!-- Icon 4  -->
					<div class="icon-box-1">
						<div class="icon">
							<img loading="lazy" width="40" height="57" src="
						<?php LF_Utils::get_svg( $report_folder . 'icon-person.svg', true ); ?>
						" alt="People icon">
						</div>
						<div class="text">
							<span>3,508</span><br />
							Scholarship recipients thanks to Dan Kohn
							Scholarship Fund
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
						<h3 class="sub-header">Detroit Photo Highlights</h3>
					</div>
					<div class="wp-block-column is-vertically-aligned-bottom"
						style="flex-basis:20%">
						<p
							class="has-text-align-right is-style-link-cta"><a href="https://www.flickr.com/photos/143247548@N03/albums/72177720303164393" title="KubeCon + CloudNativeCon North America 2022 Photo Gallery">See more</a></p>
					</div>
				</div>

				<div class="section-02__slider">
					<div>
						<?php LF_Utils::display_responsive_images( 81986, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from KubeCon + CloudNativeCon North America 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 81987, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from KubeCon + CloudNativeCon North America 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 81988, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from KubeCon + CloudNativeCon North America 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 81989, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from KubeCon + CloudNativeCon North America 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 81990, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from KubeCon + CloudNativeCon North America 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 81991, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from KubeCon + CloudNativeCon North America 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 81992, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from KubeCon + CloudNativeCon North America 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 81993, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from KubeCon + CloudNativeCon North America 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 81994, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from KubeCon + CloudNativeCon North America 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 81995, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from KubeCon + CloudNativeCon North America 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 81996, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from KubeCon + CloudNativeCon North America 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 81997, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from KubeCon + CloudNativeCon North America 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 81998, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from KubeCon + CloudNativeCon North America 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 81999, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from KubeCon + CloudNativeCon North America 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 82000, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from KubeCon + CloudNativeCon North America 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 82001, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from KubeCon + CloudNativeCon North America 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 82002, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from KubeCon + CloudNativeCon North America 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 82003, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from KubeCon + CloudNativeCon North America 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 82004, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from KubeCon + CloudNativeCon North America 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 82005, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from KubeCon + CloudNativeCon North America 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 82006, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from KubeCon + CloudNativeCon North America 2022' ); ?>
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


		<section id="attendees"
			class="section-03 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">ATTENDEE <br />
						OVERVIEW</h2>
					<div class="section-number">1/7</div>
				</div>

				<div class="lf-grid">
					<div class="restrictive-11-col">
						<p
							class="opening-paragraph">This year's <strong>KubeCon + CloudNativeCon</strong> in Detroit was our first time hosting #TeamCloudNative's flagship event in the Midwest, and we were thrilled to see so many of you there.<br><br>It's no surprise that our US community accounted for the largest number of attendees, but it was wonderful to see so many folks coming from Canada and Israel to join us in person, and from as far afield as India and even New Zealand to be with us both in person and virtually.</p>
					</div>
				</div>

				<p class="sub-header">Demographics</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<picture>
					<source media="(max-width: 499px)"
						srcset="<?php echo esc_url( wp_get_attachment_image_url( '82038', 'full', false ) ); ?>">
					<source media="(min-width: 500px)"
						srcset="<?php echo esc_url( wp_get_attachment_image_url( '82037', 'full', false ) ); ?>">
					<?php
					LF_Utils::display_responsive_images(
						'82037',
						'full',
						'1200px',
						null,
						'lazy',
						'Showing 16,986 registered attendees. 7403 in person attendees. 64% of attendees were first timers.'
					);
					?>
				</picture>

				<div aria-hidden="true" class="report-spacer-140"></div>

				<div class="shadow-hr"></div>

				<p class="sub-header">Attendee Geography</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="legend">
					<div class="legend__wrapper"><i
							class="legend__key legend__navy-700"></i> Virtual
					</div>

					<div class="legend__wrapper"><i
							class="legend__key legend__pink-700"></i> In-Person
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<picture class="text-center block">
					<source media="(max-width: 499px)" srcset="
						<?php
						LF_Utils::get_svg( $report_folder . 'attendee-geography-map-mobile.svg', true );
						?>
						">
					<source media="(min-width: 500px)" srcset="
						<?php
						LF_Utils::get_svg( $report_folder . 'attendee-geography-map-desktop.svg', true );
						?>
						">
					<img src="
					<?php
					LF_Utils::get_svg( $report_folder . 'attendee-geography-map-desktop.svg', true );
					?>
					" alt="Map of the world showing attendee geography - 81% of in-person attendees were from the USA. 56.1% of online attendees were from the USA."
						loading="lazy">
				</picture>

				<div class="shadow-hr"></div>

				<div class="quote-with-name-container">
					<p
						class="quote-with-name-container__quote">To me, the beating heart of cloud native security is most definitely KubeCon.</p>
					<div class="quote-with-name-container__marks">
						<p
							class="quote-with-name-container__name">Fernando Montenegro</p>
						<p
							class="quote-with-name-container__position"><a href="https://www.darkreading.com/omdia/cloud-native-security-was-in-the-air-at-kubecon-cloudnativecon-2022">Dark Reading</a></p>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p
					class="sub-header text-center">Top Countries in attendance</p>

				<div class="lf-grid section-03__top-countries">
					<div class="section-03__top-countries-col1">
						<p class="section-03__header">Total</p>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon">
								<img loading="lazy" width="45" height="45" src="
								<?php
								LF_Utils::get_svg( $report_folder . 'icon-flag-usa.svg', true );
								?>
" alt="USA Flag">
							</div>
							<div class="text">
								<span class="country">USA</span><br />
								<span class="number">10,568</span>
							</div>
						</div>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon">
								<img loading="lazy" width="45" height="45" src="
								<?php
								LF_Utils::get_svg( $report_folder . 'icon-flag-india.svg', true );
								?>
" alt="Indian Flag">
							</div>
							<div class="text">
								<span class="country">India</span><br />
								<span class="number">1,739</span>
							</div>
						</div>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon">
								<img loading="lazy" width="45" height="45" src="
								<?php
								LF_Utils::get_svg( $report_folder . 'icon-flag-canada.svg', true );
								?>
								" alt="Canadian Flag">
							</div>
							<div class="text">
								<span class="country">Canada</span><br />
								<span class="number">748</span>
							</div>
						</div>

					</div>
					<div class="section-03__top-countries-col2">
						<p class="section-03__header">In-person</p>


						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon">
								<img loading="lazy" width="45" height="45" src="
								<?php
								LF_Utils::get_svg( $report_folder . 'icon-flag-usa.svg', true );
								?>
" alt="USA Flag">
							</div>
							<div class="text">
								<span class="country">USA</span><br />
								<span class="number">5,744</span>
							</div>
						</div>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon">
								<img loading="lazy" width="45" height="45" src="
								<?php
								LF_Utils::get_svg( $report_folder . 'icon-flag-canada.svg', true );
								?>
" alt="Canadian Flag">
							</div>
							<div class="text">
								<span class="country">Canada</span><br />
								<span class="number">291</span>
							</div>
						</div>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon">
								<img loading="lazy" width="45" height="45" src="
								<?php
								LF_Utils::get_svg( $report_folder . 'icon-flag-israel.svg', true );
								?>
" alt="Israel Flag">
							</div>
							<div class="text">
								<span class="country">Israel</span><br />
								<span class="number">184</span>
							</div>
						</div>


					</div>
					<div class="section-03__top-countries-col3">
						<p class="section-03__header">Virtual</p>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon">
								<img loading="lazy" width="45" height="45" src="
								<?php
								LF_Utils::get_svg( $report_folder . 'icon-flag-usa.svg', true );
								?>
" alt="USA Flag">
							</div>
							<div class="text">
								<span class="country">USA</span><br />
								<span class="number">4,824</span>
							</div>
						</div>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon">
								<img loading="lazy" width="45" height="45" src="
								<?php
								LF_Utils::get_svg( $report_folder . 'icon-flag-india.svg', true );
								?>
" alt="India Flag">
							</div>
							<div class="text">
								<span class="country">India</span><br />
								<span class="number">1,664</span>
							</div>
						</div>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon">
								<img loading="lazy" width="45" height="45" src="
								<?php
								LF_Utils::get_svg( $report_folder . 'icon-flag-canada.svg', true );
								?>
" alt="Canada Flag">
							</div>
							<div class="text">
								<span class="country">Canada</span><br />
								<span class="number">457</span>
							</div>
						</div>

					</div>

				</div>

				<div aria-hidden="true" class="report-spacer-120"></div>

				<p
					class="sub-header text-center">Top Three Job Functions of attendees</p>

				<div class="lf-grid section-03__top-jobs">
					<div class="section-03__top-jobs-col1">
						<p
							class="section-03__header">DevOps / SRE / Sysadmin</p>
						<span class="large">4,557</span>
					</div>
					<div class="section-03__top-jobs-col2">
						<p class="section-03__header">Developer</p>
						<span class="large">3,378</span>
					</div>
					<div class="section-03__top-jobs-col3">
						<p class="section-03__header">Architect</p>
						<span class="large">2,777</span>
					</div>

				</div>

				<button class="button-reset section-03__button"
					data-id="js-hidden-section-trigger-open">
					See Full List
					<?php
					LF_Utils::get_svg( $report_folder . 'icon-arrow-down.svg' );
					?>
				</button>

				<div class="section-03__hidden-section"
					data-id="js-hidden-section">

					<div class="section-03__hidden-section-content">
						<div class="lf-grid section-03__jobs">
							<div class="section-03__jobs-col1">

								<div class="kccnc-table-container">
									<table class="kccnc-table">
										<thead>
											<tr>
												<th>Attendee Job Function
												</th>
												<th>Total</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>Architect</td>
												<td>2,777</td>
											</tr>
											<tr>
												<td>Business Operations</td>
												<td>283</td>
											</tr>
											<tr>
												<td>Developer</td>
												<td>3,378</td>
											</tr>
											<tr>
												<td><span class="dash"> -
													</span>Data Scientist</td>
												<td>156</td>
											</tr>
											<tr>
												<td><span class="dash"> -
													</span>Full Stack Developer
												</td>
												<td>2,648</td>
											</tr>
											<tr>
												<td><span class="dash"> -
													</span>Machine Learning
													Specialist</td>
												<td>104</td>
											</tr>
											<tr>
												<td><span class="dash"> -
													</span>Web Developer</td>
												<td>422</td>
											</tr>
											<tr>
												<td><span class="dash"> -
													</span>Mobile Developer</td>
												<td>58</td>
											</tr>
											<tr>
												<td>DevOps / SRE / SysAdmin</td>
												<td>4,557</td>
											</tr>
											<tr>
												<td>Executive</td>
												<td>865</td>
											</tr>
											<tr>
												<td>IT Operations</td>
												<td>456</td>
											</tr>
											<tr>
												<td><span class="dash"> -
													</span>DevOps</td>
												<td>179</td>
											</tr>
											<tr>
												<td><span class="dash"> -
													</span>Systems Admin</td>
												<td>190</td>
											</tr>
											<tr>
												<td><span class="dash"> -
													</span>Site Reliability
													Engineer
												</td>
												<td>67</td>
											</tr>
											<tr>
												<td><span class="dash"> -
													</span>Quality Assurance
													Engineer</td>
												<td>20</td>
											</tr>
											<tr>
												<td>Sales / Marketing</td>
												<td>1,654</td>
											</tr>
											<tr>
												<td>Media / Analyst</td>
												<td>142</td>
											</tr>
											<tr>
												<td>Student</td>
												<td>872</td>
											</tr>
											<tr>
												<td>Professor / Academic</td>
												<td>46</td>
											</tr>
											<tr>
												<td>Other</td>
												<td>1,359</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<div class="section-03__jobs-col2">

								<div class="kccnc-table-container">
									<table class="kccnc-table">
										<thead>
											<tr>
												<th>Attendee Industry
												</th>
												<th>Total</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>Automotive</td>
												<td>330</td>
											</tr>
											<tr>
												<td>Consumer Goods</td>
												<td>512</td>
											</tr>
											<tr>
												<td>Energy</td>
												<td>147</td>
											</tr>
											<tr>
												<td>Financials</td>
												<td>1,668</td>
											</tr>
											<tr>
												<td>Health Care</td>
												<td>411</td>
											</tr>
											<tr>
												<td>Industrials</td>
												<td>254</td>
											</tr>
											<tr>
												<td>Information Technology</td>
												<td>11,724</td>
											</tr>
											<tr>
												<td>Materials</td>
												<td>66</td>
											</tr>
											<tr>
												<td>Non-Profit Organization</td>
												<td>393</td>
											</tr>
											<tr>
												<td>Professional Services</td>
												<td>727</td>
											</tr>
											<tr>
												<td>Telecommunications</td>
												<td>541</td>
											</tr>
										</tbody>
									</table>
								</div>


							</div>
						</div>
					</div>

				</div>

				<button
					class="button-reset section-03__button section-03__button-close"
					style="display: none;"
					data-id="js-hidden-section-trigger-close">
					<?php LF_Utils::get_svg( $report_folder . 'icon-arrow-up.svg' ); ?>
					Close Full List
				</button>
			</div>
		</section>

		<section class="section-04 alignfull background-image-wrapper">

			<figure class="background-image-figure">
				<?php
				LF_Utils::display_responsive_images( 81984, 'full', '1200px', '', 'lazy', 'Audience at KubeCon + CloudNativeCon North America 2022' );
				?>
			</figure>

			<div class="background-image-text-overlay">
				<div class="container wrap">

					<div aria-hidden="true" class="report-spacer-120"></div>

					<div class="quote-with-name-container">
						<p
							class="quote-with-name-container__quote">The hallway track conversations are shifting towards adjusting to the enterprise... all of these big companies that we know and love are becoming software companies right before our eyes.</p>
						<div class="quote-with-name-container__marks">
							<p
								class="quote-with-name-container__name">Lisa Martin</p>
							<p
								class="quote-with-name-container__position"><a href="https://siliconangle.com/2022/10/31/security-enterprise-support-and-collaboration-emerge-as-major-themes-during-kubecon-na-kubecon/">SiliconANGLE</a></p>
						</div>
					</div>


					<div aria-hidden="true" class="report-spacer-120"></div>

				</div>
			</div>
		</section>

		<section class="section-05">

			<div aria-hidden="true" class="report-spacer-120"></div>

			<p
				class="sub-header">Year on Year Growth - North American Events</p>

			<div aria-hidden="true" class="report-spacer-60"></div>

			<div class="legend">
				<div class="legend__wrapper"><i
						class="legend__key legend__purple-700"></i> In-Person
				</div>

				<div class="legend__wrapper"><i
						class="legend__key legend__green-700"></i> Virtual
				</div>
			</div>

			<div aria-hidden="true" class="report-spacer-40"></div>

			<div class="lf-grid section-05__chart">
				<div class="section-05__chart-col1">
					<img loading="lazy" width="800" height="480" src="
			<?php LF_Utils::get_svg( $report_folder . 'attendees-yoy-growth.svg', true ); ?>
			" alt="Chart showing year on year attendee growth">
				</div>

				<div class="section-05__chart-col2">
					<div class="section-05__chart-key">
						<img loading="lazy" width="290" height="90"
							src="
						<?php LF_Utils::get_svg( $report_folder . 'attendees-110-percent.svg', true ); ?>"
							class="section-05__chart-key-image"
							alt="110% increase">

						<div class="thin-hr section-05__chart-key-hr"></div>

						<p
							class="section-05__chart-key-text">From KubeCon + CloudNativeCon 2021 in Los Angeles to the event in Detroit, we saw a 110% increase in in-person attendees.</p>

						<div class="wp-block-button"><a
								href="<?php echo esc_url( $event_link ); ?>"
								title="<?php echo esc_attr( $event_text ); ?>"
								class="wp-block-button__link">Register for
								Europe 2023</a>
						</div>

					</div>

				</div>
			</div>

			<div class="shadow-hr"></div>

			<div class="kccnc-table-container">
				<table class="kccnc-table section-05__growth-table">
					<thead>
						<tr>
							<th>Ticket Type
							</th>
							<th>2016
								<span>Seattle</span>
							</th>
							<th>2017
								<span>Austin</span>
							</th>
							<th>2018
								<span>Seattle</span>
							</th>
							<th>2019
								<span>San Diego</span>
							</th>
							<th>2020
								<span>Virtual</span>
							</th>
							<th>2021
								<span>Los Angeles</span>
							</th>
							<th>2022
								<span>Detroit</span>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Total</td>
							<td>1,139</td>
							<td>4,212</td>
							<td>8,000</td>
							<td>11,981</td>
							<td>22,816</td>
							<td>23,164</td>
							<td>16,986</td>
						</tr>
						<tr>
							<td class="nowrap">In-person Corporate</td>
							<td>38%</td>
							<td>64%</td>
							<td>68%</td>
							<td>67%</td>
							<td>N/A</td>
							<td>5%</td>
							<td>17%</td>
						</tr>
						<tr>
							<td class="nowrap">In-person Individual
							</td>
							<td>23%</td>
							<td>7%</td>
							<td>6%</td>
							<td>9%</td>
							<td>N/A</td>
							<td>1%</td>
							<td>4%</td>
						</tr>
						<tr>
							<td>Virtual All Access Pass</td>
							<td>N/A</td>
							<td>N/A</td>
							<td>N/A</td>
							<td>N/A</td>
							<td>67.34%</td>
							<td>68%</td>
							<td>48%</td>
						</tr>
						<tr>
							<td>Virtual Keynote + Solutions Showcase Only</td>
							<td>N/A</td>
							<td>N/A</td>
							<td>N/A</td>
							<td>N/A</td>
							<td>13.97%</td>
							<td>18%</td>
							<td>4.5%</td>
						</tr>
						<tr>
							<td>Speaker</td>
							<td>11%</td>
							<td>6%</td>
							<td>5%</td>
							<td>5%</td>
							<td>1.51%</td>
							<td>1%</td>
							<td>3%</td>
						</tr>
						<tr>
							<td>Sponsor</td>
							<td>17%</td>
							<td>16%</td>
							<td>17%</td>
							<td>15%</td>
							<td>16.55%</td>
							<td>7%</td>
							<td>21.5%</td>
						</tr>
						<tr>
							<td>Media</td>
							<td>3%</td>
							<td>1%</td>
							<td>1%</td>
							<td>1%</td>
							<td>0.63%</td>
							<td>&lt;1%</td>
							<td>1%</td>
						</tr>
						<tr>
							<td>Academic</td>
							<td>N/A</td>
							<td>2%</td>
							<td>2%</td>
							<td>3%</td>
							<td>N/A</td>
							<td>&lt;1%</td>
							<td>1%</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="shadow-hr"></div>

			<div class="lf-grid section-05__dei">
				<div class="section-05__dei-col1">
					<p class="sub-header">Diversity, Equity & Inclusivity</p>
					<p>CNCF strives to ensure that everyone who participates in KubeCon + CloudNativeCon feels welcome, regardless of gender, gender identity, sexual orientation, disability, race, ethnicity, age, religion, or economic status. Just over 12% of attendees identified as a person of color, and more than 50% preferred not to answer. As part of our deep commitment to diversity, equity and inclusivity, we hosted a number of workshops and networking opportunities to help connect individuals to opportunities within tech.</p>
				</div>
				<div class="section-05__dei-col2">
					<p class="sub-header">Gold CHAOSS D&I Event Badge</p>
					<p><img width="291" height="70" src="
				<?php
				Lf_Utils::get_image( $report_folder . 'dandigold.png' );
				?>
				" alt="Gold CHAOSS D&I Event Badge" loading="lazy"></p>
					<p>Awarded to events in the open source community that foster healthy D&I practices</p>
				</div>
			</div>

			<div class="shadow-hr"></div>

			<div class="kccnc-table-container">
				<table class="kccnc-table section-05__dei-table">
					<thead>
						<tr>
							<th>Diversity, Equity & Inclusivity Events and
								Mentoring
							</th>
							<th>Total</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Diversity Lunch participants</td>
							<td>12</td>
						</tr>
						<tr>
							<td>Allyship Workshop participants</td>
							<td>16</td>
						</tr>
						<tr>
							<td>EmpowerUs participants</td>
							<td>35</td>
						</tr>
						<tr>
							<td>Peer Group Mentoring + Career Networking mentors
								-
								in-person</td>
							<td>10</td>
						</tr>
						<tr>
							<td>Peer Group Mentoring + Career Networking mentees
								-
								in-person</td>
							<td>50</td>
						</tr>
						<tr>
							<td>Peer Group Mentoring + Career Networking mentors
								-
								virtual</td>
							<td>3</td>
						</tr>
						<tr>
							<td>Peer Group Mentoring + Career Networking mentees
								-
								virtual</td>
							<td>28</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div aria-hidden="true" class="report-spacer-120"></div>

			<h2 class="has-normal-font-size header-lines">Our next Kubecon +
				CloudNativeCon</h2>

			<a href="<?php echo esc_url( $event_link ); ?>"
				title="<?php echo esc_html( $event_text ); ?>">
				<picture>
					<source media="(max-width: 499px)"
						srcset="<?php echo esc_url( wp_get_attachment_image_url( '80844', 'full', false ) ); ?>">
					<source media="(min-width: 500px)"
						srcset="<?php echo esc_url( wp_get_attachment_image_url( '80843', 'full', false ) ); ?>">
					<?php
					LF_Utils::display_responsive_images(
						'80843',
						'full',
						'1200px',
						null,
						'lazy',
						esc_attr( $event_text )
					);
					?>
				</picture>
			</a>
		</section>

		<section id="colocated"
			class="section-06 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">Co-Located <br />
						Events</h2>
					<div class="section-number">2/7</div>
				</div>

				<div class="lf-grid">
					<div class="restrictive-10-col">
						<p
							class="opening-paragraph">Co-located events feature industry experts covering topics like security, web assembly, AI, GitOps, edge, and more.<br><br>The list of co-located events at KubeCon + CloudNativeCon has been steadily growing for the past few years, so much that we are now spinning off the highly successful <a href="https://events.linuxfoundation.org/cloudnativesecuritycon-north-america/">CloudNativeSecurityCon</a> into a stand-alone event.</p>
					</div>
				</div>

				<p
					class="sub-header">CNCF-Hosted Co-Located Events Attendance</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="kccnc-table-container section-06__colo">
					<table class="kccnc-table">
						<tbody>
							<tr>
								<td>BackstageCon</td>
								<td>187</td>
							</tr>
							<tr>
								<td>CloudNativeSecurityCon</td>
								<td>228</td>
							</tr>
							<tr>
								<td>Cloud Native eBPF Day</td>
								<td>84</td>
							</tr>
							<tr>
								<td>Cloud Native Telco Day</td>
								<td>72</td>
							</tr>
							<tr>
								<td>Cloud Native Wasm Day</td>
								<td>115</td>
							</tr>
						</tbody>
					</table>
					<table class="kccnc-table">
						<tbody>
							<tr>
								<td>EnvoyCon</td>
								<td>92</td>
							</tr>
							<tr>
								<td>GitOpsCon</td>
								<td>191</td>
							</tr>
							<tr>
								<td>KnativeCon</td>
								<td>100</td>
							</tr>
							<tr>
								<td>Kubernetes AI Day</td>
								<td>152</td>
							</tr>
							<tr>
								<td>Kubernetes Batch + HPC Day</td>
								<td>81</td>
							</tr>
						</tbody>
					</table>
					<table class="kccnc-table">
						<tbody>
							<tr>
								<td>Kubernetes on Edge Day</td>
								<td>112</td>
							</tr>
							<tr>
								<td>Open Observability Day</td>
								<td>161</td>
							</tr>
							<tr>
								<td>PrometheusDay</td>
								<td>103</td>
							</tr>
							<tr>
								<td>ServiceMeshCon</td>
								<td>165</td>
							</tr>
							<tr>
								<td>SigstoreCon</td>
								<td>82</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div class="shadow-hr"></div>

				<h2 class="section-header">CO-LOCATED EVENT REPORTS</h2>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<p>Co-located events feature industry experts covering topics like security, web assembly, AI, GitOps, edge, and more.</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="section-06__colo-reports">

					<?php
					LF_Utils::display_responsive_images(
						'81934',
						'large',
						'265px',
						null,
						'lazy',
						'View the Backstage Con report'
					);

					LF_Utils::display_responsive_images(
						'81938',
						'large',
						'265px',
						null,
						'lazy',
						'View the Cloud Native Security Con report'
					);

					LF_Utils::display_responsive_images(
						'81945',
						'large',
						'265px',
						null,
						'lazy',
						'View the Open Observability Day report'
					);

					LF_Utils::display_responsive_images(
						'81946',
						'large',
						'265px',
						null,
						'lazy',
						'View the PrometheusDay report'
					);
					?>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="wp-block-button"><a
						href="https://www.cncf.io/reports/kubecon-cloudnativecon-north-america-2022-cncf-hosted-co-located-events-transparency-reports/"
						title="Browse all co-located event reports"
						class="wp-block-button__link">Browse all co-lo
						reports</a>
				</div>
			</div>
		</section>

		<section class="section-07 alignfull background-image-wrapper">

			<figure class="background-image-figure">
				<?php LF_Utils::display_responsive_images( 82029, 'full', '1200px', '', 'lazy', 'Speaker on stage at KubeCon + CloudNativeCon North America 2022' ); ?>
			</figure>

			<div class="background-image-text-overlay">
				<div class="container wrap">

					<div aria-hidden="true" class="report-spacer-120"></div>

					<div class="lf-grid">
						<div class="restrictive-8-col">

							<h3 class="section-07__headline">Interested in
								learning more about hosting a co-located event
								alongside KubeCon + CloudNativeCon Europe 2023?
							</h3>

							<div class="thin-hr"></div>

							<div class="wp-block-button"><a
									href="https://events.linuxfoundation.org/kubecon-cloudnativecon-europe/sponsor/#additional-opportunities"
									title="Learn more about hosting a co-located event"
									class="wp-block-button__link">Co-located
									Event Options</a>
							</div>
							<div aria-hidden="true" class="report-spacer-120">
							</div>

						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="section-08 is-style-down-gradient alignfull"
			id="content">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">Content</h2>
					<div class="section-number">3/7</div>
				</div>

				<div class="quote-with-name-container">
					<p
						class="quote-with-name-container__quote">Thankfully this year's KubeCon + CloudNativeCon North America did something a little different. It still had a lot of the newest, shiniest technologies as well as plenty of discussions for elite DevOps organizations. But the schedule was also packed with a 101 track and welcomes to many Special Interest Groups (SIGs). It also gave a lot of advice on how to support these highly distributed, often voluntary communities.</p>
					<div class="quote-with-name-container__marks">
						<p
							class="quote-with-name-container__name">Jennifer Riggins</p>
						<p
							class="quote-with-name-container__position"><a href="https://thenewstack.io/what-do-cloud-native-and-kubernetes-even-mean/">The New Stack</a></p>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p>We enjoyed 266 sessions in Detroit, including 90 maintainer sessions.</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="kccnc-table-container">
					<table class="kccnc-table">
						<thead>
							<tr>
								<th>Sessions</th>
								<th>Total</th>
								<th>In-Person</th>
								<th>Virtual</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Keynotes (includes sponsored keynotes)</td>
								<td>18</td>
								<td>16</td>
								<td>3</td>
							</tr>
							<tr>
								<td>Total sessions (CFP & Maintainer)</td>
								<td>266</td>
								<td>233</td>
								<td>33</td>
							</tr>
							<tr>
								<td><span class="dash"> -
									</span>Breakouts</td>
								<td>176</td>
								<td>154</td>
								<td>22</td>
							</tr>
							<tr>
								<td><span class="dash"> -
									</span>Maintainer sessions
								</td>
								<td>90</td>
								<td>79</td>
								<td>11</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<p
					class="sub-header">Thank you to our fabulous KubeCon + CloudNativeCon North America 2022 co-chairs</p>

				<div class="lf-grid section-08__chairs">
					<div class="section-08__chairs__col1">
						<?php LF_Utils::display_responsive_images( 73888, 'full', '200px', 'section-08__chairs__image', 'lazy', 'Ricardo Rocha' ); ?>
						<p>
							<span class="section-08__chairs__name">Ricardo Rocha</span><span
							class="section-08__chairs__title"></span>CERN <br/>
Computing Engineer</p>
					</div>
					<div class="section-08__chairs__col2">
						<?php LF_Utils::display_responsive_images( 73886, 'full', '200px', 'section-08__chairs__image', 'lazy', 'Emily Fox' ); ?>
						<p>
							<span class="section-08__chairs__name">Emily Fox</span><span
							class="section-08__chairs__title">Apple <br/>Security Engineer</span></p>
					</div>
					<div class="section-08__chairs__col3">

						<?php LF_Utils::display_responsive_images( 82036, 'full', '200px', 'section-08__chairs__image', 'lazy', 'Frederick Kautz' ); ?>
						<p>
							<span class="section-08__chairs__name">Frederick Kautz</span><span
								class="section-08__chairs__title">Computing Engineer Infra &<br/>Security Enterprise Architect
Manager</span>
						</p>
					</div>
				</div>
			</div>
		</section>

		<section class="section-09 alignfull">

			<div class="container wrap">

				<div aria-hidden="true" class="report-spacer-120"></div>

				<div class="lf-grid breakdown">
					<div class="breakdown__col1">

						<h2 class="section-header">Content <br />Breakdown</h2>

					</div>
					<div class="breakdown__col2">
						<div class="breakdown__text">
							<p>The schedule was curated by conference co-chairs, Richardo Rocha of CERN, Emily Fox of Apple, and Frederick Kautz of Doc.ai, who led a program committee of 93 experts and 34 track chairs, including project maintainers, active community members, and highly rated presenters from past events.<br><br>Talks are selected by the program committee through a rigorous, non-bias process, where they are randomly assigned submissions to review within their area of expertise. You can read the details in our <a href="https://events.linuxfoundation.org/kubecon-cloudnativecon-europe/program/scoring-guidelines/">CFP scoring guidelines</a>, and specifically about the <a href="https://www.cncf.io/blog/2022/08/03/inside-the-numbers-the-kubecon-cloudnativecon-selection-process-for-north-america-2022/">North America selection process</a>.
						</p>
						</div>
					</div>
					<div class="breakdown__col3">
						<p class="sub-header">Key Stats</p>
					</div>
					<div class="breakdown__col4">
						<div class="breakdown__icons">

							<!-- Icon Box 3  -->
							<div class="icon-box-3">
								<div class="icon">
									<img loading="lazy" width="60" height="50"
										src="
										<?php
										LF_Utils::get_svg( $report_folder . 'icon-inbox.svg', true );
										?>
							" alt="Inbox icon">
								</div>
								<div class="text">
									<span class="number">1,551</span><br />
									<span class="description">CFP
										Submissions</span>
								</div>
							</div>

							<!-- Icon Box 3  -->
							<div class="icon-box-3">
								<div class="icon">
									<img loading="lazy" width="37" height="51"
										src="
										<?php
										LF_Utils::get_svg( $report_folder . 'icon-mic.svg', true );
										?>
										" alt="Microphone icon">
								</div>
								<div class="text">
									<span class="number">531</span><br />
									<span class="description">Speakers</span>
								</div>
							</div>

							<!-- Icon Box 3  -->
							<div class="icon-box-3">
								<div class="icon">
									<img loading="lazy" width="36" height="48"
										src="
										<?php
										LF_Utils::get_svg( $report_folder . 'icon-person-b.svg', true );
										?>
										" alt="Person icon">
								</div>
								<div class="text">
									<span class="number">136</span><br />
									<span class="description">First-time
										Speakers</span>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-120"></div>

			</div>
		</section>

		<section class="section-10">

			<div aria-hidden="true" class="report-spacer-120"></div>

			<h2 class="section-header">Speaker Diversity</h2>

			<div aria-hidden="true" class="report-spacer-40"></div>

			<p>CNCF enforces guidelines on gender and diversity equality among our speakers, including not accepting all-male panels.</p>

			<div aria-hidden="true" class="report-spacer-60"></div>

			<div class="kccnc-table-container">
				<table class="kccnc-table">
					<thead>
						<tr>
							<th>Diversity</th>
							<th>Overall</th>
							<th>Percent</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Speakers - men (keynotes)</td>
							<td>10</td>
							<td>56%</td>
						</tr>
						<tr>
							<td>Speakers - women + gender non-conforming
								(keynotes)</td>
							<td>8</td>
							<td>44%</td>
						</tr>
						<tr>
							<td>Speakers - men (breakouts)</td>
							<td>217</td>
							<td>78%</td>
						</tr>
						<tr>
							<td>Speakers - women (breakouts)</td>
							<td>58</td>
							<td>21%</td>
						</tr>
						<tr>
							<td>Speakers - gender non-conforming (breakouts)
							</td>
							<td>2</td>
							<td>1%</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div aria-hidden="true" class="report-spacer-120"></div>
		</section>

		<section id="endusers"
			class="section-11 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">End <Br />
						Users</h2>
					<div class="section-number">4/7</div>
				</div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p
							class="opening-paragraph">End users are an important part of #TeamCloudNative and played a significant role in Detroit by driving new initiatives and sharing valuable experiences in presentations.</p>
					</div>
				</div>

				<p class="sub-header">Key Stats</p>

				<div aria-hidden="true" class="report-spacer-60"></div>


				<div class="lf-grid section-11__stats">
					<!-- Icon Box 3  -->
					<div class="icon-box-3" style="grid-column: span 12">
						<div class="icon">
							<img loading="lazy" width="60" height="50" src="
							<?php
										LF_Utils::get_svg( $report_folder . 'icon-cloud-download.svg', true );
							?>
							" alt="Cloud download icon">
						</div>
						<div class="text">
							<span class="number">COMING SOON</span><br />
							<span class="description">Additional end user data
								<br class="show-over-1000">is on the way</span>
						</div>
					</div>
				</div>

				<div class="lf-grid section-11__stats" style="display:none">
					<!-- Icon Box 3  -->
					<div class="icon-box-3">
						<div class="icon">
							<img loading="lazy" width="60" height="50" src="
							<?php
										LF_Utils::get_svg( $report_folder . 'icon-share.svg', true );
							?>
							" alt="Share icon">
						</div>
						<div class="text">
							<span class="number">8,986</span><br />
							<span class="description">attendees work for <br
									class="show-over-1000">
								end user organizations</span>
						</div>
					</div>

					<!-- Icon Box 3  -->
					<div class="icon-box-3">
						<div class="icon">
							<img loading="lazy" width="60" height="50" src="
							<?php
										LF_Utils::get_svg( $report_folder . 'icon-building.svg', true );
							?>
							" alt="Building icon">
						</div>
						<div class="text">
							<span class="number">3,187</span><br />
							<span class="description">end user
								organizations <br
									class="show-over-1000">attended</span>
						</div>
					</div>

					<!-- Icon Box 3  -->
					<div class="icon-box-3">
						<div class="icon">
							<img loading="lazy" width="60" height="50" src="
							<?php
										LF_Utils::get_svg( $report_folder . 'icon-members.svg', true );
							?>
							" alt="Members icon">
						</div>
						<div class="text">
							<span class="number">170</span><br />
							<span class="description">end user members / <br
									class="show-over-1000">supporters
								attended</span>
						</div>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">CTO SUMMIT</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-11__cto">
					<div class="section-11__cto-col1">
						<p>The CTO Summit gathered a tight-knit group of technology leaders from some of cloud native's biggest end users to discuss what maturity means in the cloud native world. Focusing on the intersection between <a href="https://landscape.cncf.io/guide#provisioning">provisioning</a> and the <a href="https://github.com/cncf/cartografos/blob/main/reference/prologue.md">Cloud Native Maturity Model</a>, leaders openly discussed the challenges, cultural shifts, and technical solutions they've seen on their journey to improve the maturity and resiliency of their cloud native infrastructure.</p>
					</div>
					<div class="section-11__cto-col2">

						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="text">
								<span class="number">21</span><br />
								<span class="description">CTO Summit
									attendees</span>
							</div>
						</div>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<p
					class="sub-header">Thanks to our CTO Summit Dinner Sponsor</p>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<a href="https://www.uptycs.com/" title="Visit Uptycs">
					<img loading="lazy" width="300" height="105" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'logo-uptycs.svg', true );
						?>
						" alt="Logo for Uptycs">
				</a>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<div class="quote-with-name-container">
					<p
						class="quote-with-name-container__quote">We started this CTO Summit where end users, like Fidelity and Intuit, and many others can come together and have a private conversation, in a secure space, about how they are handling challenges in their organizations. We all have each other to learn from.</p>
					<div class="quote-with-name-container__marks">
						<p
							class="quote-with-name-container__name">Priyank Sharma</p>
						<p
							class="quote-with-name-container__position">Executive Director, CNCF</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-120"></div>

			</div>
		</section>

		<section class="section-12 alignfull">
			<div class="container wrap">

				<div aria-hidden="true" class="report-spacer-120"></div>

				<div class="lf-grid section-12__presentations">

					<div class="section-12__presentations-col1">
						<?php LF_Utils::display_responsive_images( 82030, 'large', '600px', null, 'lazy', 'End User Presentations' ); ?>
					</div>

					<div class="section-12__presentations-col2">

						<p class="sub-header">End User Presentations</p>

						<p>More than one third of talks at KubeCon + CloudNativeCon North America were from end users who shared insightful and valuable stories from across the stack.<br><br><a href="https://www.youtube.com/playlist?list=PLj6h78yzYM2O5aNpRM71NQyx3WUe1xpTn">Watch all talks on our YouTube playlist</a>.</p>

					</div>

				</div>

				<div aria-hidden="true" class="report-spacer-120"></div>

			</div>
		</section>

		<section class="section-13 alignfull">

			<div class="container wrap">

				<div aria-hidden="true" class="report-spacer-120"></div>

				<h2 class="section-header">The Next Generation</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-10-col">
						<p
							class="opening-paragraph">More than <strong>3,400</strong> people joined us for KubeCon + CloudNativeCon North America thanks to the Dan Kohn Scholarship Fund, including diversity, need-based, and student scholarship opportunities.</p>
					</div>
				</div>

				<div class="kccnc-table-container">
					<table class="kccnc-table">
						<thead>
							<tr>
								<th>Scholarships</th>
								<th>Total</th>
								<th>In-Person</th>
								<th>Virtual</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Diversity scholarships</td>
								<td>395</td>
								<td>73</td>
								<td>322</td>
							</tr>
							<tr>
								<td>Need-based scholarships</td>
								<td>507</td>
								<td>24</td>
								<td>483</td>
							</tr>
							<tr>
								<td>Student scholarships</td>
								<td>2606</td>
								<td>N/A</td>
								<td>2606</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<p class="sub-header">Sponsored by</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="logo-grid">

					<div class="logo-grid__box">
						<img loading="lazy" src="
						<?php
							LF_Utils::get_svg( $report_folder . 'logo-apple.svg', true );
						?>
							" alt="Logo for Apple" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" src="
						<?php
							LF_Utils::get_svg( $report_folder . 'logo-apptio.svg', true );
						?>
							" alt="Logo for Apptio" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" src="
						<?php
							LF_Utils::get_svg( $report_folder . 'logo-cncf.svg', true );
						?>
							" alt="Logo for CNCF" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" src="
						<?php
							LF_Utils::get_svg( $report_folder . 'logo-doppler.svg', true );
						?>
							" alt="Logo for Doppler" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" src="
						<?php
							LF_Utils::get_svg( $report_folder . 'logo-finops-foundation.svg', true );
						?>
							" alt="Logo for Fin Ops Foundation" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" src="
						<?php
							LF_Utils::get_svg( $report_folder . 'logo-isovalent.svg', true );
						?>
							" alt="Logo for Isovalent" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" src="
						<?php
							LF_Utils::get_svg( $report_folder . 'logo-section.svg', true );
						?>
							" alt="Logo for Section" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" src="
						<?php
							LF_Utils::get_svg( $report_folder . 'logo-shopify.svg', true );
						?>
							" alt="Logo for Shopify" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" src="
						<?php
							LF_Utils::get_svg( $report_folder . 'logo-styra.svg', true );
						?>
							" alt="Logo for Styra" class="logo-grid__image">
					</div>


				</div>

				<div class="shadow-hr"></div>

				<div class="banner">
					<?php
					LF_Utils::display_responsive_images( 82032, 'full', '800px', 'banner__image', 'lazy', 'Scholarship recipients at KubeCon + CloudNativeCon North America 2022' );
					?>
					<div class="banner__title-wrapper">
						<h2 class="banner__title">Check out our scholarship
							recipients!</h2>
					</div>
					<div class="banner__text-wrapper">
						<h3 class="banner__text">Apply for a scholarship to join
							us at KubeCon + CloudNativeCon Europe 2023</h3>
						<div class="wp-block-button"><a
								href="https://events.linuxfoundation.org/kubecon-cloudnativecon-europe/attend/diversity-inclusion/"
								title="Apply for scholarship at KubeCon + CloudNativeCon Europe 2023"
								class="wp-block-button__link">Apply</a>
						</div>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<h2 class="section-header">Security Slam</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-10-col">
						<p
							class="opening-paragraph">This year we partnered with <a href="https://www.sonatype.com/" title="Visit Sonatype">Sonatype</a> to host the first ever <a href="https://community.cncf.io/cloud-native-security-slam/" title="Security Slam">Security Slam</a> virtual event on November 21, 2022. Thirteen projects participated, leveraging existing CNCF tools to increase their open source security posture, awareness, and compliance. <strong>Google donated $27,500 to the Dan Kohn Scholarship Fund</strong> in the name of the projects that made it to 100% security.</p>
					</div>
				</div>

				<p class="sub-header">Projects That Made It To 100%</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="logo-grid smaller">
					<div class="logo-grid__box">
						<img loading="lazy" src="
						<?php
							LF_Utils::get_svg( $report_folder . 'project-logo-argo.svg', true );
						?>
							" alt="Logo for Argo" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" src="
						<?php
							LF_Utils::get_svg( $report_folder . 'project-logo-artifacthub.svg', true );
						?>
							" alt="Logo for ArtifactHub" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" src="
						<?php
							LF_Utils::get_svg( $report_folder . 'project-logo-chaosmesh.svg', true );
						?>
							" alt="Logo for Chaos Mesh" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" src="
						<?php
							LF_Utils::get_svg( $report_folder . 'project-logo-cloudevents.svg', true );
						?>
							" alt="Logo for CloudEvents" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" src="
						<?php
							LF_Utils::get_svg( $report_folder . 'project-logo-cortex.svg', true );
						?>
							" alt="Logo for Cortex" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" src="
						<?php
							LF_Utils::get_svg( $report_folder . 'project-logo-flagger.svg', true );
						?>
							" alt="Logo for Flagger" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" src="
						<?php
							LF_Utils::get_svg( $report_folder . 'project-logo-flux.svg', true );
						?>
							" alt="Logo for Flux" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" src="
						<?php
							LF_Utils::get_svg( $report_folder . 'project-logo-k8gb.svg', true );
						?>
							" alt="Logo for K8GB" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" src="
						<?php
							LF_Utils::get_svg( $report_folder . 'project-logo-kubewarden.svg', true );
						?>
							" alt="Logo for KubeWarden" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" src="
						<?php
							LF_Utils::get_svg( $report_folder . 'project-logo-openfeature.svg', true );
						?>
							" alt="Logo for OpenFeature" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" src="
						<?php
							LF_Utils::get_svg( $report_folder . 'project-logo-pixie.svg', true );
						?>
							" alt="Logo for Pixie" class="logo-grid__image">
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="lf-grid section-13__slam">
					<div class="section-13__slam-col1">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="text">
								<span class="number">13</span><br />
								<span class="description">Projects
									Participating</span>
							</div>
						</div>
					</div>
					<div class="section-13__slam-col2">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="text">
								<span class="number">11</span><br />
								<span class="description">Projects successfully
									made it to 100% security within their
									CLOmonitoring scorecard</span>
							</div>
						</div>
					</div>
					<div class="section-13__slam-col3">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="text">
								<span class="number">$27,500</span><br />
								<span class="description">Donated by Google to
									the Dan Kohn Scholarship Fund</span>
							</div>
						</div>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<?php LF_Utils::display_responsive_images( 82011, 'full', '230px', 'section-13__kids-logo', 'lazy', 'Kids Day' ); ?>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-13__kids">
					<div class="section-13__kids-col1">
						<p
							class="opening-paragraph">On Sunday, October 23, we hosted our first complimentary Kid's Day in Detroit. Featuring two workshops:</p>

						<ol>
							<li>Minecraft Modding</li>
							<li>Gotta Catch 'em All! Raspberry Pi And Java
								Pokemon Training</li>
						</ol>

						<p>We'll host Kid's Day again at <a href="<?php echo esc_url( $event_link ); ?>">KubeCon + CloudNativeCon Europe in Amsterdam</a> this coming April, for all children (ages 8-14) who are interested in technology, coding, and STEAM fields.</p>

						<div aria-hidden="true" class="report-spacer-40"></div>
					</div>
					<div class="section-13__kids-col2">
						<?php
							LF_Utils::display_responsive_images( 82007, 'newsroom-post-width', '600px', null, 'lazy', 'Kids Day' );
						?>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-120"></div>

			</div>
		</section>

		<section id="health"
			class="section-14 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">Health &amp; Safety</h2>
					<div class="section-number">5/7</div>
				</div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p
							class="opening-paragraph">We care deeply about our community. This is why we want to be honest and open about our COVID-19 policies at KubeCon + CloudNativeCon, the measures that were put in place, and how these may have affected the attendee experience.</p>
					</div>
				</div>

				<p
					class="sub-header">Kubecon + Cloudnativecon implemented <br class="show-over-1000">the following safety precautions:</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-14__covid">

					<div class="section-14__covid-col1">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" width="60" height="50" src="
										<?php
										LF_Utils::get_svg( $report_folder . 'icon-health-vaccine.svg', true );
										?>
							" alt="Vaccine icon icon">
							</div>
							<div class="text">
								<span class="description">Vaccinations <br
										class="show-over-1000">or negative
									test</span>
								<span class="addendum">Proof required for
									in-person
									attendees</span>
							</div>
						</div>
					</div>
					<div class="section-14__covid-col2">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" width="60" height="50" src="
										<?php
										LF_Utils::get_svg( $report_folder . 'icon-health-mask.svg', true );
										?>
							" alt="Mask icon">
							</div>
							<div class="text">
								<span class="description">Mandatory <br
										class="show-over-1000">Masks</span>
								<span class="addendum">Required usage of masks
									indoors</span>
							</div>
						</div>
					</div>
					<div class="section-14__covid-col3">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" width="60" height="50" src="
										<?php
										LF_Utils::get_svg( $report_folder . 'icon-health-test.svg', true );
										?>
							" alt="Test icon">
							</div>
							<div class="text">
								<span class="description">COVID <br
										class="show-over-1000">testing</span>
								<span class="addendum">Complimentary onsite
									COVID testing</span>
							</div>
						</div>
					</div>
					<div class="section-14__covid-col4">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" width="60" height="50" src="
										<?php
										LF_Utils::get_svg( $report_folder . 'icon-health-band.svg', true );
										?>
							" alt="Wristband icon">
							</div>
							<div class="text">
								<span class="description">Wearable <br
										class="show-over-1000">indicators</span>
								<span class="addendum">Social distance comfort
									levels</span>
							</div>
						</div>
					</div>





				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">COVID Numbers</p>

				<div aria-hidden="true" class="report-spacer-60"></div>


				<p>Over the two weeks immediately after KubeCon + CloudNativeCon <br class="show-over-1000">(October 31 - November 11), we were made aware of:</p>


				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-14__numbers">
					<div class="section-14__numbers-col1">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="text">
								<span class="number">66</span><br />
								<span class="description">Positive Tests from
									<br class="show-over-1000">in-person
									attendees</span>
							</div>
						</div>
					</div>
					<div class="section-14__numbers-col2">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="text">
								<span class="number">1%</span><br />
								<span class="description">Of In-Person Attendees
									Tested <br class="show-over-1000">Positive
									Overall</span>
							</div>
						</div>
					</div>
					<div class="section-14__numbers-col3">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="text">
								<span class="number">0</span><br />
								<span class="description">Serious Cases
									Reported</span>
							</div>
						</div>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<p><strong>This information was compiled from:</strong></p>

				<ul>
					<li>Those who contacted us to let us know of a positive test
					</li>
					<li>Records from our onsite testing company</li>
					<li>Scanning Twitter for additional publicized cases </li>
				</ul>

				<div class="shadow-hr"></div>

				<p class="sub-header">Incident Transparency Report</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-14__incident">
					<div class="section-14__incident-col1">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="text">
								<span class="number">1</span><br />
								<span class="description">Code of Conduct report
									received on-site </span>
								<span class="addendum">(involving an offsite
									incident and security response)</span>
							</div>
						</div>
					</div>
					<div class="section-14__incident-col2">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="text">
								<span class="number">1</span><br />
								<span class="description">Attendee taken to the
									hospital</span>
								<span class="addendum">(after a scooter
									accident)</span>
							</div>
						</div>
					</div>
				</div>
				<div class="shadow-hr"></div>

				<h2 class="section-header">Sustainability</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-14__sustainability">
					<div class="section-14__sustainability-col1">
						<p
							class="opening-paragraph">We're committed to sustainability at our events and this KubeCon + CloudNativeCon was no exception.</p>

						<p>The venue, Huntington Place, is also committed to environmental stewardship in the community and makes continuous efforts to investigate, validate and implement new and innovative Green initiatives throughout the facility.</p>

						<p>You can read their <a href="https://huntingtonplace.production.carbonhouse.com/assets/doc/2022-Green-Facility-Statement-c4476e57dd.pdf">extensive sustainability initiatives</a>, including:</p>

						<ul>
							<li>CNCF and sponsor companies donated left-over
								conference swag, office supplies, furniture and
								more to <a
									href="https://huntingtonplace.production.carbonhouse.com/assets/doc/2022-Local-Agency-Network-4d576a74c1.pdf">local
									organizations</a> for reuse and
								upcycling.</li>
							<li>Huntington Place is a LEED Gold Certified
								Facility.</li>
							<li>Housekeeping staff use products that are
								environmentally safe and non-toxic.</li>
							<li>All pallets are recycled to a local area vendor.
							</li>
							<li>Food that has not been served is donated to
								Forgotten Harvest, a local Detroit company that
								delivers the food to pantries, soup kitchens and
								shelters throughout Southeastern Michigan.</li>
							<li>Conference lanyards were made from recycled
								water bottles.</li>
						</ul>
					</div>

					<div class="section-14__sustainability-col2">

						<?php LF_Utils::display_responsive_images( 82047, 'newsroom-post-width', '500px', null, 'lazy', 'Photo from KubeCon + CloudNativeCon North America 2022' ); ?>

						<div aria-hidden="true" class="report-spacer-20"></div>

						<?php LF_Utils::display_responsive_images( 82048, 'newsroom-post-width', '500px', null, 'lazy', 'Photo from KubeCon + CloudNativeCon North America 2022' ); ?>

					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-120"></div>

			</div>
		</section>

		<section id="media" class="section-15 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">Media &amp; Analyst <br>Coverage
					</h2>
					<div class="section-number">6/7</div>
				</div>

				<div class="quote-with-name-container">
					<p
						class="quote-with-name-container__quote">The event itself, as always, was fantastic with lots of good information. If you are involved with K8s or cloud-native computing, KubeCon continues to be THE EVENT that you should attend.</p>
					<div class="quote-with-name-container__marks">
						<p
							class="quote-with-name-container__name">Tom Fenton</p>
						<p
							class="quote-with-name-container__position"><a href="https://virtualizationreview.com/articles/2022/11/10/small-kubecon-companies.aspx?m=1">Virtualization & Cloud Review</a></p>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">Key stats</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-15__stats">
					<!-- Icon Box 3  -->
					<div class="icon-box-3">
						<div class="icon">
							<img loading="lazy" width="60" height="50" src="
							<?php
										LF_Utils::get_svg( $report_folder . 'icon-share.svg', true );
							?>
							" alt="Share icon">
						</div>
						<div class="text">
							<span class="number">150%</span><br />
							<span class="description">More Media Coverage <br
									class="show-over-1000">than last year</span>
							<span class="addendum">Compared with KubeCon +
								CloudNativeCon North America 2021 (Los Angeles
								and virtual)</span>
						</div>
					</div>

					<!-- Icon Box 3  -->
					<div class="icon-box-3">
						<div class="icon">
							<img loading="lazy" width="60" height="50" src="
							<?php
										LF_Utils::get_svg( $report_folder . 'icon-bell.svg', true );
							?>
							" alt="Bell icon">
						</div>
						<div class="text">
							<span class="number">3,833</span><br />
							<span class="description">Mentions Of Kubecon <br
									class="show-over-1000">+
								Cloudnativecon</span>
							<span class="addendum">In media articles, press
								releases, and blogs</span>
						</div>
					</div>

					<!-- Icon Box 3  -->
					<div class="icon-box-3">
						<div class="icon">
							<img loading="lazy" width="60" height="50" src="
							<?php
										LF_Utils::get_svg( $report_folder . 'icon-twitter.svg', true );
							?>
							" alt="Twitter icon">
						</div>
						<div class="text">
							<span class="number">11.3M</span><br />
							<span class="description">Twitter Handle <br
									class="show-over-1000">Impressions</span>
							<span class="addendum">Visit <a
									href="https://twitter.com/CloudNativeFdn"
									title="CNCF on Twitter">@CloudNativeFdn</a></span>
						</div>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">Online Reach + Traffic</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-15__reach">

					<div class="section-15__reach-col1">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" width="60" height="50" src="
							<?php
										LF_Utils::get_svg( $report_folder . 'icon-youtube.svg', true );
							?>
							" alt="YouTube icon">
							</div>
							<div class="text">
								<span class="number">10K+</span><br />
								<span class="description">YouTube Channel
									Views<br><a
										href="https://www.youtube.com/playlist?list=PLj6h78yzYM2O5aNpRM71NQyx3WUe1xpTn">View
										the
										playlist</a></span>
							</div>
						</div>
					</div>

					<div class="section-15__reach-col2">

						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" width="60" height="50" src="
							<?php
										LF_Utils::get_svg( $report_folder . 'icon-click.svg', true );
							?>
							" alt="Click icon">
							</div>
							<div class="text">
								<span class="number">22.2K</span><br />
								<span class="description">Clicks on
									Twitter</span>
							</div>
						</div>

					</div>
					<div class="section-15__reach-col3">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" width="60" height="50" src="
							<?php
										LF_Utils::get_svg( $report_folder . 'icon-heart-b.svg', true );
							?>
							" alt="Heart icon">
							</div>
							<div class="text">
								<span class="number">3.2K</span><br />
								<span class="description">Likes on Twitter
								</span>
							</div>
						</div>
					</div>
					<div class="section-15__reach-col4">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" width="60" height="50" src="
							<?php
										LF_Utils::get_svg( $report_folder . 'icon-retweet.svg', true );
							?>
							" alt="Retweet icon">
							</div>
							<div class="text">
								<span class="number">190</span><br />
								<span class="description">Retweets</span>
							</div>
						</div>
					</div>



				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">Media + Analyst Results</p>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="lf-grid section-15__media">
					<div class="section-15__media-col1">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="text">
								<span class="number">3085</span><br />
								<span class="description">"CNCF"</span>
								<span class="addendum">mentions in media
									articles, press releases, and blogs that
									were shared <strong>1,113</strong> times on
									Twitter.</span>
							</div>
						</div>
					</div>
					<div class="section-15__media-col2">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="text">
								<span class="number">4,358</span><br />
								<span class="description">"Kubernetes"</span>
								<span class="addendum">mentions in media
									articles, press releases, and blogs that
									were shared <strong>952</strong> times
									across social platforms.</span>
							</div>
						</div>
					</div>
					<div class="section-15__media-col3">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="text">
								<span class="number">3,833</span><br />
								<span class="description">"KubeCon +
									CloudNativeCon"</span>
								<span class="addendum">mentions in media
									articles, press releases, and blogs that
									were shared <strong>1,290</strong> times
									across social platforms.</span>
							</div>
						</div>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<h2 class="section-header">Coverage Overview</h2>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<div class="lf-grid">
					<div class="restrictive-10-col">
						<p
							class="opening-paragraph"><strong>153</strong> media and industry analysts attended both in person and virtually. The CNCF PR and AR team hosted two media and analyst roundtables at the event focusing on developer experience, and what's next in cloud native, in addition to an end user panel at the press and analyst conference.</p>

						<p>These inspiring panel conversations lead to a number of interesting deep dives from <a href="https://www.techtarget.com/searchitoperations/news/252526594/Platform-engineers-plug-abstraction-leaks">TechTarget</a> on the end user panel, and two articles from the "What's next in cloud native" panel: <a href="https://www.computing.co.uk/news/4059039/enterprises-support-open-source-software">Computing</a> and <a href="https://www.sdxcentral.com/articles/opinion-editorial/op-ed-cloud-natives-success-is-cloud-natives-strife/2022/11/">SDxCentral</a>. In addition, the stand-alone analyst event featured a maintainer panel, which resulted in analyst blog coverage of top trends including FinOps, Wasm and cloud native security.</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="logo-grid smaller">

					<div class="logo-grid__box">
						<img loading="lazy"
							src="<?php LF_Utils::get_image( $report_folder . 'media-logo-business-insider.png' ); ?>"
							alt="Logo for Business Insider"
							class="logo-grid__image">
					</div>

					<div class="logo-grid__box">
						<img loading="lazy"
							src="<?php LF_Utils::get_image( $report_folder . 'media-logo-computing.jpg' ); ?>"
							alt="Logo for Computing" class="logo-grid__image">
					</div>

					<div class="logo-grid__box">
						<img loading="lazy"
							src="<?php LF_Utils::get_image( $report_folder . 'media-logo-container-journal.png' ); ?>"
							alt="Logo for Container Journal"
							class="logo-grid__image">
					</div>

					<div class="logo-grid__box">
						<img loading="lazy"
							src="<?php LF_Utils::get_image( $report_folder . 'media-logo-forrester.png' ); ?>"
							alt="Logo for Forrester Research Inc"
							class="logo-grid__image">
					</div>

					<div class="logo-grid__box">
						<img loading="lazy"
							src="<?php LF_Utils::get_svg( $report_folder . 'media-logo-gartner.svg', true ); ?>"
							alt="Logo for Gartner" class="logo-grid__image">
					</div>

					<div class="logo-grid__box">
						<img loading="lazy"
							src="<?php LF_Utils::get_image( $report_folder . 'media-logo-heise.png' ); ?>"
							alt="Logo for Heise IX" class="logo-grid__image">
					</div>

					<div class="logo-grid__box">
						<img loading="lazy"
							src="<?php LF_Utils::get_image( $report_folder . 'media-logo-idg-news.png' ); ?>"
							alt="Logo for IDG News" class="logo-grid__image">
					</div>

					<div class="logo-grid__box">
						<img loading="lazy"
							src="<?php LF_Utils::get_svg( $report_folder . 'media-logo-informationweek.svg', true ); ?>"
							alt="Logo for Information Week"
							class="logo-grid__image">
					</div>

					<div class="logo-grid__box">
						<img loading="lazy"
							src="<?php LF_Utils::get_image( $report_folder . 'media-logo-le-monde-infomatique.png' ); ?>"
							alt="Logo for Le Monde Informatique"
							class="logo-grid__image">
					</div>

					<div class="logo-grid__box">
						<img loading="lazy"
							src="<?php LF_Utils::get_image( $report_folder . 'media-logo-sed.png' ); ?>"
							alt="Logo for Software Engineering Daily"
							class="logo-grid__image">
					</div>

					<div class="logo-grid__box">
						<img loading="lazy"
							src="<?php LF_Utils::get_svg( $report_folder . 'media-logo-techrepublic.svg', true ); ?>"
							alt="Logo for Tech Republic"
							class="logo-grid__image">
					</div>

					<div class="logo-grid__box">
						<img loading="lazy"
							src="<?php LF_Utils::get_image( $report_folder . 'media-logo-vmblog.png' ); ?>"
							alt="Logo for VM Blog" class="logo-grid__image">
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header text-center">Quote Highlights</p>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="section-15__quote-slider">

					<!-- Quote 1 -->
					<div class="quote-with-name-container">

						<a
							href="https://siliconangle.com/2022/10/31/security-enterprise-support-and-collaboration-emerge-as-major-themes-during-kubecon-na-kubecon/">
							<img loading="lazy" width="140" height="80"
								src="<?php LF_Utils::get_image( $report_folder . 'media-logo-silicon-angle.png' ); ?>"
								alt="Logo for SiliconANGLE"
								class="section-15__quote-slider-logo">
						</a>

						<div aria-hidden="true" class="report-spacer-20"></div>

						<p
							class="quote-with-name-container__quote">The big story was security; the software supply chain was the number one consistent theme. The growth of open source exposes potential vulnerabilities with security, so software supply chain gets my vote.</p>
						<div class="quote-with-name-container__marks">
							<p
								class="quote-with-name-container__name">John Furrier</p>
							<p
								class="quote-with-name-container__position">SiliconANGLE</p>

						</div>
					</div>

					<!-- Slider 2 -->
					<div class="quote-with-name-container">

						<a
							href="https://www.techtarget.com/searchitoperations/opinion/Looking-back-on-KubeCon-CloudNativeCon">
							<img loading="lazy" width="140" height="80"
								src="<?php LF_Utils::get_image( $report_folder . 'media-logo-techtarget.png' ); ?>"
								alt="Logo for Tech Target"
								class="section-15__quote-slider-logo">
						</a>

						<div aria-hidden="true" class="report-spacer-20"></div>

						<p
							class="quote-with-name-container__quote">One common theme across the event was that the economy is top of mind for vendors and organizations. Cost control and management is a major focus.</p>
						<div class="quote-with-name-container__marks">
							<p
								class="quote-with-name-container__name">Paul Nashawaty</p>
							<p
								class="quote-with-name-container__position">TechTarget</p>

						</div>
					</div>

					<!-- Slider 3 -->
					<div class="quote-with-name-container">

						<a
							href="https://siliconangle.com/2022/10/28/industrializing-kubernetes-platform-kubecon-2022/">
							<img loading="lazy" width="140" height="80"
								src="<?php LF_Utils::get_image( $report_folder . 'media-logo-silicon-angle.png' ); ?>"
								alt="Logo for SiliconANGLE"
								class="section-15__quote-slider-logo">
						</a>

						<div aria-hidden="true" class="report-spacer-20"></div>

						<p
							class="quote-with-name-container__quote">If there was one big takeaway this year, it would be the re-emergence of the platform paradigm in cloud-native clothing.</p>
						<div class="quote-with-name-container__marks">
							<p
								class="quote-with-name-container__name">Jason English</p>
							<p
								class="quote-with-name-container__position">SiliconANGLE</p>

						</div>
					</div>
					<!-- Slider 4 -->
					<div class="quote-with-name-container">

						<a
							href="https://www.sdxcentral.com/articles/news/open-source-maintainers-key-to-healthy-cloud-native-ecosystem/2022/10/">
							<img loading="lazy" width="140" height="80"
								src="<?php LF_Utils::get_svg( $report_folder . 'media-logo-sdx-central.svg', true ); ?>"
								alt="Logo for SDX Central"
								class="section-15__quote-slider-logo">
						</a>

						<div aria-hidden="true" class="report-spacer-20"></div>

						<p
							class="quote-with-name-container__quote">The roughly 1,000 maintainers in the CNCF community make decisions that affect and support more than 7 million cloud-native developers globally. “If you really think about it, it's 1,000 people supporting millions. Maintainers are holding up the cloud-native ecosystem,” [Sharma] said.</p>
						<div class="quote-with-name-container__marks">
							<p
								class="quote-with-name-container__name">Emma Chervek</p>
							<p
								class="quote-with-name-container__position">SDxCentral</p>

						</div>
					</div>

					<!-- Slider 5 -->
					<div class="quote-with-name-container">

						<a
							href="https://www.techtarget.com/searchitoperations/opinion/Looking-back-on-KubeCon-CloudNativeCon">
							<img loading="lazy" width="140" height="80"
								src="<?php LF_Utils::get_image( $report_folder . 'media-logo-techtarget.png' ); ?>"
								alt="Logo for Tech Target"
								class="section-15__quote-slider-logo">
						</a>

						<div aria-hidden="true" class="report-spacer-20"></div>

						<p
							class="quote-with-name-container__quote">Another topic was ease of use to reduce complexity, as well as the need to hire highly skilled staff to meet business KPIs. Organizations are turning to vendors to provide fewer, more consolidated products that reduce complexity and to act as trusted advisors.</p>
						<div class="quote-with-name-container__marks">
							<p
								class="quote-with-name-container__name">Paul Nashawaty</p>
							<p
								class="quote-with-name-container__position">TechTarget</p>

						</div>
					</div>

				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">Coverage Highlights</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<p>Over <strong>3,833</strong> articles published from KubeCon + CloudNativeCon North America in leading outlets (as of November 10).</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="section-15__coverage lf-grid">

					<div class="section-15__coverage-col1">

						<?php
						LF_Utils::display_responsive_images( 82033, 'medium', '300px', null, 'lazy', 'Coverage of KubeCon + CloudNativeCon in SD Times' );
						?>

					</div>

					<div class="section-15__coverage-col2">
						<p><a href="https://www.computing.co.uk/news/4059039/enterprises-support-open-source-software">Computing</a> - Why enterprises must do more to support open source software they use</p>
						<p><a href="https://www.darkreading.com/omdia/cloud-native-security-was-in-the-air-at-kubecon-cloudnativecon-2022">Dark Reading</a> - Cloud-Native Security Was in the Air at KubeCon/CloudNativeCon 2022</p>
						<p><a href="https://www.datanami.com/2022/10/25/kubernetes-goes-big-and-small-at-kubecon/">Datanami</a> - Kubernetes Goes Big and Small at KubeCon</p>
						<p><a href="https://devops.com/cncf-survey-predicts-growing-wasm-momentum/">DevOps.com</a> - CNCF Survey Predicts Growing Wasm Momentum</p>
						<p><a href="https://erp.today/hello-caller-cncf-cloud-native-network-function-certification-engages/">ERP Today</a> - Hello caller, CNCF cloud-native network function certification engages</p>
						<p><a href="https://www.evaluatorgroup.com/kubecon-2022-from-devops-to-platformops/">Evaluator Group</a> - KubeCon 2022: From DevOps to PlatformOps</p>
						<p><a href="https://www.forrester.com/blogs/webassemblywasm-will-be-big-early-news-from-kubecon-2022/">Forrester</a> - WebAssembly (Wasm) Will Be Big — Early News From KubeCon 2022</p>
						<p><a href="https://sdtimes.com/software-development/kubecon-keynote-address-stresses-the-importance-of-supporting-maintainers-and-upstream-commitments/">SD Times</a> - KubeCon Keynote stresses the importance of supporting maintainers and upstream commitments</p>
						<p><a href="https://www.sdxcentral.com/articles/news/open-source-maintainers-key-to-healthy-cloud-native-ecosystem/2022/10/">SDX Central</a> - Open Source Maintainers Key to Healthy Cloud-Native Ecosystem</p>
						<p><a href="https://siliconangle.com/2022/10/06/continued-rapid-adoption-kubernetes-hints-historic-kubecon-event-cubeconversation-kubecon/">SiliconANGLE</a> - Continued rapid adoption of Kubernetes hints at a historic KubeCon event</p>
						<p><a href="https://siliconangle.com/2022/10/28/ford-motors-early-experience-cloud-native-smoothed-road-digital-transformation-kubecon/">SiliconANGLE</a> - Ford Motor's early experience with cloud-native smoothed the road for its digital transformation</p>
						<p><a href="https://www.techtarget.com/searchitoperations/news/252526594/Platform-engineers-plug-abstraction-leaks">TechTarget</a> - Platform engineers plug abstraction leaks</p>
						<p><a href="https://thenewstack.io/meet-sig-cluster-lifecycle-and-cluster-api-maintainers-at-kubecon/">The New Stack</a> - Meet SIG Cluster Lifecycle and Cluster API Maintainers at KubeCon</p>
						<p><a href="https://thenewstack.io/ukraine-has-a-bright-future/">The New Stack</a> - Ukraine Has a Bright Future</p>
						<p><a href="https://www.infoq.com/news/2022/11/cloud-native-wasm-day/">InfoQ</a> - Developer Tooling for Cloud-Native Wasm Is Going Mainstream</p>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">Industry Analyst Coverage Highlights</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="quote-with-name-container">
					<p
						class="quote-with-name-container__quote">This show is about developers; it's not a business show; it's not about industry posturing or marketing. This show is about creating products for builders and creating products that people can consume. The community isn't just vendors, and that's the interesting thing.</p>
					<div class="quote-with-name-container__marks">
						<p
							class="quote-with-name-container__name">John Furrier</p>
						<p
							class="quote-with-name-container__position"><a href="https://siliconangle.com/2022/10/27/opening-day-at-kubecon-shines-a-spotlight-on-influence-of-cloud-native-developers-kubecon/">theCUBE</a></p>
					</div>
				</div>


				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="kccnc-table-container">
					<table class="kccnc-table section-15__analysts">
						<tbody>
							<tr>
								<td>Torsten Volk, ESG</td>
								<td><a
										href="https://torstenvolk.medium.com/kubecon-2022-3-product-highlights-34d28ebf0c5e">KubeCon
										2022: 3 Product Highlights</a></td>
							</tr>
							<tr>
								<td>Carlos Casanova, Forrester</td>
								<td><a
										href="https://www.forrester.com/report/introducing-the-forrester-observability-reference-architecture/RES178154">Introducing
										The Forrester Observability Reference
										Architecture</a></td>
							</tr>
							<tr>
								<td>Jim Mercer, IDC</td>
								<td><a
										href="https://www.idc.com/getdoc.jsp?containerId=US49716922">IDC
										PlanScape: DevSecOps Adoption for
										Digital Innovators</a></td>
							</tr>
							<tr>
								<td>Beth Pariseau, Tech Target</td>
								<td><a
										href="https://www.techtarget.com/searchitoperations/news/252526594/Platform-engineers-plug-abstraction-leaks">Platform
										engineers plug abstraction leaks</a>
								</td>
							</tr>
							<tr>
								<td>Pete Townsend, Principal CTO Advisor</td>
								<td><a
										href="https://siliconangle.com/2022/10/28/future-enterprise-needs-shape-analyst-dialogue-kubecon-na-day-2-kubecon/">Analysts
										lay out new technologies to solve
										enterprise needs at KubeCon NA Day 2</a>
								</td>
							</tr>
							<tr>
								<td>Nancy Gohring, IDC</td>
								<td><a
										href="https://www.idc.com/getdoc.jsp?containerId=US48597522">IDC
										FutureScape: Worldwide Developer and
										DevOps 2023 Predictions</a></td>
							</tr>
							<tr>
								<td>Charlie Dai, Lee Sustar, Forrester</td>
								<td><a
										href="https://www.forrester.com/report/navigate-the-cloud-native-ecosystem-in-2022/RES133445?ref_search=3485345_1667207994046">Navigate
										The Cloud-Native Ecosystem In 2022</a>
								</td>
							</tr>
							<tr>
								<td>Fernando Montenegro, Omdia</td>
								<td><a
										href="https://www.darkreading.com/omdia/cloud-native-security-was-in-the-air-at-kubecon-cloudnativecon-2022">Cloud-Native
										Security Was in the Air at
										KubeCon/CloudNativeCon 2022</a></td>
							</tr>
							<tr>
								<td>Charlotte Dunlap, GlobalData</td>
								<td><a
										href="https://itconnection.wordpress.com/2022/11/04/kubecon-2022-key-trends-include-webassembly-finops-and-security/">KubeCon
										2022: Key Trends Include WebAssembly,
										FinOps, and Security</a></td>
							</tr>
							<tr>
								<td>Greg Zwakman, Jay Lyman, 451 Research</td>
								<td><a
										href="https://streaklinks.com/BQxobdl8vCnznL0tzg-00vSB/https%3A%2F%2Fclients.451research.com%2Freports%2F201424%3FsearchTerms%3D%2522A10%2522">Application
										Container Ecosystem Market Monitor:
										Application Container Ecosystem Data
										File</a></td>
							</tr>
						</tbody>
					</table>
				</div>

				<button class="button-reset section-03__button"
					data-id="js-hidden-analysts-trigger-open">
					See Full List
					<?php
					LF_Utils::get_svg( $report_folder . 'icon-arrow-down.svg' );
					?>
				</button>

				<div class="section-03__hidden-section"
					data-id="js-hidden-analysts">

					<div class="">

						<div class="kccnc-table-container">
							<table class="kccnc-table section-15__analysts">
								<tbody>

									<tr>
										<td>Sharyn Leaver, Forrester</td>
										<td><a
												href="https://www.forrester.com/report/predictions-2023/RES178290?ref_search=0_1667542373904">Predictions
												2023</a></td>
									</tr>
									<tr>
										<td>Lee Sustar, Forrester</td>
										<td><a
												href="https://www.forrester.com/blogs/the-era-of-cloud-native-transformation-is-here/">The
												Era Of Cloud-Native
												Transformation Is Here</a></td>
									</tr>
									<tr>
										<td>Lee Sustar, Forrester</td>
										<td><a
												href="https://www.forrester.com/blogs/predictions-2023-cloud/?ref_search=0_1667542373904">Predictions
												2023: Tech Leaders Double Down
												On Cloud-Native While Google
												Buys More Market Share</a></td>
									</tr>
									<tr>
										<td>Brent Ellis, Forrester</td>
										<td><a
												href="https://www.forrester.com/blogs/webassemblywasm-will-be-big-early-news-from-kubecon-2022/?ref_search=0_1667542907002">WebAssembly
												(Wasm) Will Be Big — Early News
												From KubeCon 2022</a></td>
									</tr>
									<tr>
										<td>Lee Sustar, Forrester</td>
										<td><a
												href="https://www.forrester.com/report/predictions-2023-cloud-computing/RES178164?ref_search=0_1667542373904">Predictions
												2023: Cloud Computing</a></td>
									</tr>
									<tr>
										<td>Charlie Dai, Forrester</td>
										<td><a
												href="https://www.forrester.com/blogs/take-a-pragmatic-approach-to-embrace-a-cloud-native-first-strategy/">Take
												A Pragmatic Approach To Embrace
												A Cloud-Native-First
												Strategy</a></td>
									</tr>
									<tr>
										<td>Chris Gardner, Forrester</td>
										<td><a
												href="https://www.forrester.com/report/predictions-2023-software-development/RES178160">Predictions
												2023: Software Development</a>
										</td>
									</tr>
									<tr>
										<td>Jean Atelsek, 451 Research</td>
										<td><a
												href="https://clients.451research.com/reportaction/201285/Marketing">Coverage
												Initiation: Isovalent seeks to
												establish a next-generation
												networking frontier with
												eBPF</a></td>
									</tr>
									<tr>
										<td>Charlotte Dunlap, Global Data</td>
										<td><a
												href="https://technology.globaldata.com/Analysis/details/KubeCon-2022-Rise-of-Kubernetes-Drives-New-Cost-Management-Monitoring-and-Security-Methods127819">KubeCon
												2022: Rise of Kubernetes Drives
												New Cost Management, Monitoring,
												and Security Methods </a></td>
									</tr>
									<tr>
										<td>Paul Nashawaty, ESG</td>
										<td><a
												href="https://www.techtarget.com/searchitoperations/opinion/Looking-back-on-KubeCon-CloudNativeCon">Looking
												back on KubeCon + CloudNativeCon
												2022 - TechTarget</a></td>
									</tr>
									<tr>
										<td>Verdict</td>
										<td><a
												href="https://www.verdict.co.uk/webassembly-kubecon-kubernetes-devops/">KubeCon
												highlights include new buzzword
												- WebAssembly</a></td>
									</tr>
									<tr>
										<td>Camberley Bates, Evaluator Group
										</td>
										<td><a
												href="https://www.evaluatorgroup.com/kubecon-2022-from-devops-to-platformops/">KubeCon
												2022: From DevOps to
												PlatformOps</a></td>
									</tr>
									<tr>
										<td>Krista Macomber, Evaluator Group
										</td>
										<td><a
												href="https://www.evaluatorgroup.com/kubecon-2022-data-security-and-protection-insights/">KubeCon
												2022: Data Security and
												Protection Insights</a></td>
									</tr>
									<tr>
										<td>Janae Stow Lee, Evaluator Group</td>
										<td><a
												href="https://www.evaluatorgroup.com/kubecon-2022-the-road-ahead-takes-kubernetes-to-the-edge/">Kubecon
												2022: The Road Ahead Takes
												Kubernetes to the Edge</a></td>
									</tr>
									<tr>
										<td>Christian Canales, Gartner</td>
										<td><a
												href="https://www.gartner.com/document/4020647?ref=solrResearch&refval=344852815">Emerging
												Tech Impact Radar:
												Communications</a></td>
									</tr>
									<tr>
										<td>Wataru Katsurashima, Gartner</td>
										<td><a
												href="https://www.gartner.com/document/4020561?ref=solrResearch&refval=344853078">Emerging
												Tech Impact Radar: Cloud
												Computing</a></td>
									</tr>
									<tr>
										<td>Jouni Forsman, Gartner</td>
										<td><a
												href="https://www.gartner.com/document/4020621?ref=solrResearch&refval=344853078">Magic
												Quadrant for IT Services for
												Communications Service Providers
												Worldwide</a></td>
									</tr>
									<tr>
										<td>Uko Tian, Gartner</td>
										<td><a
												href="https://www.gartner.com/document/4020628?ref=solrResearch&refval=344853078">Competitive
												Landscape: Chinese HCI Large,
												Specialist and Crossover
												Vendors</a></td>
									</tr>
									<tr>
										<td>Sam Grinter, Gartner</td>
										<td><a
												href="https://www.gartner.com/document/4020558?ref=solrResearch&refval=344853078">Magic
												Quadrant for Cloud HCM Suites
												for 1,000+ Employee
												Enterprises</a></td>
									</tr>
									<tr>
										<td>Cameron Haight, Gartner</td>
										<td><a
												href="https://www.gartner.com/document/4020565?ref=solrResearch&refval=344853078">Research
												Roundup for DevOps, 2022</a>
										</td>
									</tr>
									<tr>
										<td>Andrew Brown, Omdia</td>
										<td><a
												href="https://omdia.tech.informa.com/OM023894/Hyperscaler-IoT-Cloud-Strategies">Hyperscaler
												IoT Cloud Strategies</a></td>
									</tr>

								</tbody>
							</table>
						</div>

					</div>

				</div>

				<button
					class="button-reset section-03__button section-03__button-close"
					style="display: none;"
					data-id="js-hidden-analysts-trigger-close">
					<?php LF_Utils::get_svg( $report_folder . 'icon-arrow-up.svg' ); ?>
					Close Full List
				</button>


				<div aria-hidden="true" class="report-spacer-120"></div>

			</div>
		</section>

		<section id="sponsors"
			class="section-16 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">Sponsor <br />
						Information</h2>
					<div class="section-number">7/7</div>
				</div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p
							class="opening-paragraph">KubeCon + CloudNativeCon would not be possible without the support of our wonderful sponsors.</p>
					</div>
				</div>

				<div class="kccnc-table-container">
					<table class="kccnc-table section-16__booth">
						<thead>
							<tr>
								<th>Booth Traffic</th>
								<th>Total</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Onsite leads total</td>
								<td>73,026</td>
							</tr>
							<tr>
								<td>Onsite leads average/booth</td>
								<td>252</td>
							</tr>
							<tr>
								<td>Virtual leads total</td>
								<td>33,427</td>
							</tr>
							<tr>
								<td>Virtual leads average/booth</td>
								<td>140</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="kccnc-table-container">
					<table class="kccnc-table section-16__yoy">
						<thead>
							<tr>
								<th>YOY SPONSORSHIP
								</th>
								<th>2016
									<span>Seattle</span>
								</th>
								<th>2017
									<span>Austin</span>
								</th>
								<th>2018
									<span>Seattle</span>
								</th>
								<th>2019
									<span>San Diego</span>
								</th>
								<th>2020
									<span>Virtual</span>
								</th>
								<th>2021
									<span>Los Angeles</span>
								</th>
								<th>2022
									<span>Detroit</span>
								</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Diamond</td>
								<td>8</td>
								<td>5</td>
								<td>6*</td>
								<td>6*</td>
								<td>6*</td>
								<td>6*</td>
								<td>6*</td>
							</tr>
							<tr>
								<td>Platinum</td>
								<td>3</td>
								<td>17</td>
								<td>20</td>
								<td>35</td>
								<td>8</td>
								<td>20</td>
								<td>28</td>
							</tr>
							<tr>
								<td>Gold</td>
								<td>10</td>
								<td>23</td>
								<td>20</td>
								<td>19</td>
								<td>21</td>
								<td>26</td>
								<td>32</td>
							</tr>
							<tr>
								<td>Silver</td>
								<td>13</td>
								<td>30</td>
								<td>87</td>
								<td>100</td>
								<td>63</td>
								<td>91</td>
								<td>135</td>
							</tr>
							<tr>
								<td class="nowrap">Start-up</td>
								<td>N/A</td>
								<td>30</td>
								<td>50</td>
								<td>73</td>
								<td>38</td>
								<td>76</td>
								<td>94</td>
							</tr>
							<tr>
								<td class="nowrap">End User</td>
								<td>N/A</td>
								<td>N/A</td>
								<td>5</td>
								<td>10</td>
								<td>2</td>
								<td>7</td>
								<td>6</td>
							</tr>
							<tr>
								<td>Marketing Opportunities</td>
								<td>13</td>
								<td>26</td>
								<td>27</td>
								<td>34</td>
								<td>29</td>
								<td>35</td>
								<td>65</td>
							</tr>
							<tr>
								<td>Total Unique</td>
								<td>39</td>
								<td>107</td>
								<td>193</td>
								<td>246</td>
								<td>143</td>
								<td>228</td>
								<td>303</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header text-center">Diamond Sponsors</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<!-- Start of diamond sponsors  -->
				<div class="sponsors-logos largest even orphan-by-5">
					<div class="sponsors-logo-item">
						<a href="https://aws.amazon.com/" target="_blank"
							rel="noopener" title="Visit the Amazon AWS website">
							<img width="400" height="245" loading="lazy"
								decoding="async" src="
							<?php
								LF_Utils::get_svg( $report_folder . 'amazon-web-services-spn.svg', true );
							?>
							" alt="Logo for Amazon" class="logo wp-post-image"></a>
					</div>
					<div class="sponsors-logo-item"><a
							href="http://eti.cisco.com/" target="_blank"
							rel="noopener"
							title="Visit the Cisco: Emerging Tech and Incubation website">
							<img width="192" height="144" loading="lazy"
								decoding="async" src="
							<?php
								LF_Utils::get_svg( $report_folder . 'Cisco_ETI_ProgramID-1-01.svg', true );
							?>
							" alt="Logo for Cisco ETI" class="logo wp-post-image"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://www.intel.com/content/www/us/en/developer/topic-technology/open/overview.html"
							style="-webkit-transform: scale(0.7); -ms-transform: scale(0.7); transform: scale(0.7);"
							target="_blank" rel="noopener"
							title="Visit the Intel website">
							<img width="338" height="139" loading="lazy"
								decoding="async" src="
							<?php
								LF_Utils::get_svg( $report_folder . 'intel-01.svg', true );
							?>
							" alt="Logo for Intel" class="logo wp-post-image"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://www.kasten.io/"
							style="-webkit-transform: scale(0.9); -ms-transform: scale(0.9); transform: scale(0.9);"
							target="_blank" rel="noopener"
							title="Visit the Kasten website">
							<img width="192" height="144" loading="lazy"
								decoding="async" src="
							<?php
								LF_Utils::get_svg( $report_folder . 'Kasten-logo-2022.svg', true );
							?>
							" alt="Logo for Kasten" class="logo wp-post-image"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://www.paloaltonetworks.com/prisma/cloud"
							style="-webkit-transform: scale(1.15); -ms-transform: scale(1.15); transform: scale(1.15);"
							target="_blank" rel="noopener"
							title="Visit the Prisma Cloud website">
							<img width="192" height="144" loading="lazy"
								decoding="async" src="
							<?php
								LF_Utils::get_svg( $report_folder . 'Palo_Alto_Prisma_Cloud_logo_RGB_Horizontal.svg', true );
							?>
							" alt="Logo for Prisma Cloud" class="logo wp-post-image"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://www.vmware.com" target="_blank"
							rel="noopener" title="Visit the VMware website">
							<img width="400" height="245" loading="lazy"
								decoding="async" src="
							<?php
								LF_Utils::get_svg( $report_folder . 'vmware-spn.svg', true );
							?>
							" alt="Logo for VMware" class="logo wp-post-image"></a></div>
				</div>
				<!-- End of diamond sponsors  -->

				<div class="shadow-hr"></div>

				<p class="sub-header text-center">Platinum Sponsors</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="sponsors-logos larger even orphan-by-3">
					<div class="sponsors-logo-item"><a
							href="https://www.aquasec.com/"
							style="-webkit-transform: scale(0.9); -ms-transform: scale(0.9); transform: scale(0.9);"
							target="_blank" rel="noopener"
							title="Visit the Aqua website">
							<img width="128" height="128" loading="lazy"
								decoding="async" src="
							<?php
								LF_Utils::get_svg( $report_folder . 'Aqua-Logo-Color-RGB-2022.svg', true );
							?>
							" alt="Logo for Aqua" class="logo wp-post-image"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://ubuntu.com/"
							style="-webkit-transform: scale(0.9); -ms-transform: scale(0.9); transform: scale(0.9);"
							target="_blank" rel="noopener"
							title="Visit the Ubuntu website">
							<img width="128" height="128" loading="lazy"
								decoding="async" src="
							<?php
								LF_Utils::get_svg( $report_folder . 'Canonical-Ubuntulogo-2021_RGB.svg', true );
							?>
							" alt="Logo for Ubuntu" class="logo wp-post-image"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://circleci.com/"
							style="-webkit-transform: scale(0.9); -ms-transform: scale(0.9); transform: scale(0.9);"
							target="_blank" rel="noopener"
							title="Visit the CircleCI website">
							<img width="290" height="242" loading="lazy"
								decoding="async" src="
							<?php
								LF_Utils::get_svg( $report_folder . 'circle-ci.svg', true );
							?>
							" alt="Logo for CircleCI" class="logo wp-post-image"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://www.cockroachlabs.com/"
							target="_blank" rel="noopener"
							title="Visit the Cockroach Labs website">
							<img width="400" height="245" loading="lazy"
								decoding="async" src="
							<?php
								LF_Utils::get_svg( $report_folder . 'Cockroach-Labs-01.svg', true );
							?>
							" alt="Logo for Cockroach Labs" class="logo wp-post-image"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://www.datadoghq.com/" target="_blank"
							rel="noopener" title="Visit the Datadog website">
							<img width="400" height="245" loading="lazy"
								decoding="async" src="
							<?php
								LF_Utils::get_svg( $report_folder . 'datadog-spn.svg', true );
							?>
							" alt="Logo for Datadog" class="logo wp-post-image"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://www.datastax.com/" target="_blank"
							rel="noopener" title="Visit the DataStax website">
							<img width="407" height="74" loading="lazy"
								decoding="async" src="
							<?php
								LF_Utils::get_svg( $report_folder . 'datastax-logo.svg', true );
							?>
							" alt="Logo for DataStax" class="logo wp-post-image"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://www.delltechnologies.com/"
							style="-webkit-transform: scale(1.05); -ms-transform: scale(1.05); transform: scale(1.05);"
							target="_blank" rel="noopener"
							title="Visit the Dell Technologies website">
							<img width="400" height="245" loading="lazy"
								decoding="async" src="
							<?php
								LF_Utils::get_svg( $report_folder . 'dell-spn.svg', true );
							?>
							" alt="Logo for Dell Technologies" class="logo wp-post-image"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://www.dynatrace.com/technologies/kubernetes-monitoring/"
							target="_blank" rel="noopener"
							title="Visit the Dynatrace website">
							<img width="400" height="245" loading="lazy"
								decoding="async" src="
							<?php
								LF_Utils::get_svg( $report_folder . 'dynatrace-spn.svg', true );
							?>
							" alt="Logo for Dynatrace" class="logo wp-post-image"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://about.gitlab.com/" target="_blank"
							rel="noopener" title="Visit the GitLab website">
							<img width="128" height="128" loading="lazy"
								decoding="async" src="
							<?php
								LF_Utils::get_svg( $report_folder . 'gitlab-logo-rgb.svg', true );
							?>
							" alt="Logo for GitLab" class="logo wp-post-image"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://cloud.google.com/"
							style="-webkit-transform: scale(1.1); -ms-transform: scale(1.1); transform: scale(1.1);"
							target="_blank" rel="noopener"
							title="Visit the Google Cloud website">
							<img width="128" height="128" loading="lazy"
								decoding="async" src="
							<?php
								LF_Utils::get_svg( $report_folder . 'lockup_GoogleCloud_FullColor_rgb_2900x512px.svg', true );
							?>
							" alt="Logo for Google Cloud" class="logo wp-post-image"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://www.ibm.com/us-en/"
							style="-webkit-transform: scale(0.8); -ms-transform: scale(0.8); transform: scale(0.8);"
							target="_blank" rel="noopener"
							title="Visit the IBM website">
							<img width="128" height="128" loading="lazy"
								decoding="async" src="
							<?php
								LF_Utils::get_svg( $report_folder . 'IBM_logo.svg', true );
							?>
							" alt="Logo for IBM" class="logo wp-post-image"></a></div>
					<div class="sponsors-logo-item"><a href="https://jfrog.com/"
							target="_blank" rel="noopener"
							title="Visit the jFrog website">
							<img width="400" height="245" loading="lazy"
								decoding="async" src="
							<?php
								LF_Utils::get_svg( $report_folder . 'jfrog-spn.svg', true );
							?>
							" alt="Logo for jFrog" class="logo wp-post-image"></a></div>
					<div class="sponsors-logo-item"><a
							href="http://www.eggplantsoftware.com"
							target="_blank" rel="noopener"
							title="Visit the Keysight website">
							<img width="128" height="128" loading="lazy"
								decoding="async" src="
							<?php
								LF_Utils::get_svg( $report_folder . 'Keysight-Horizontal-Logo-RGB-Color-1.svg', true );
							?>
							" alt="Logo for Keysight" class="logo wp-post-image"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://lightstep.com/" target="_blank"
							rel="noopener" title="Visit the Lightstep website">
							<img width="128" height="128" loading="lazy"
								decoding="async" src="
							<?php
								LF_Utils::get_svg( $report_folder . 'Lightstep.svg', true );
							?>
							" alt="Logo for Lightstep" class="logo wp-post-image"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://azure.microsoft.com/en-us/overview/kubernetes-on-azure/"
							target="_blank" rel="noopener"
							title="Visit the Microsoft Azure website">
							<img width="400" height="245" loading="lazy"
								decoding="async" src="
							<?php
								LF_Utils::get_svg( $report_folder . 'microsoft-azure-spn.svg', true );
							?>
							" alt="Logo for Microsoft Azure" class="logo wp-post-image"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://www.nginx.com/"
							style="-webkit-transform: scale(0.9); -ms-transform: scale(0.9); transform: scale(0.9);"
							target="_blank" rel="noopener"
							title="Visit the NGINX website">
							<img width="128" height="128" loading="lazy"
								decoding="async" src="
							<?php
							LF_Utils::get_svg( $report_folder . 'NGINX-Part-of-F5-horiz-black-type-rgb-1.svg', true );
							?>
							" alt="Logo for NGINX" class="logo wp-post-image"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://developer.oracle.com/?source=:ex:sn:::::RC_WWMK220606P00116:KubeConNASite&amp;SC=:ex:sn:::::RC_WWMK220606P00116:KubeConNASite&amp;pcode=WWMK220606P00116"
							target="_blank" rel="noopener"
							title="Visit the Oracle for Developers website">
							<img width="128" height="128" loading="lazy"
								decoding="async" src="
							<?php
								LF_Utils::get_svg( $report_folder . 'OCI_RED_Horizontal_rgb_C74634.svg', true );
							?>
							" alt="Logo for Oracle Cloud" class="logo wp-post-image"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://portworx.com/" target="_blank"
							rel="noopener" title="Visit the Portworx website">
							<img width="406" height="158" loading="lazy"
								decoding="async" src="
							<?php
								LF_Utils::get_svg( $report_folder . 'portworx-by-purestorage-01.svg', true );
							?>
							" alt="Logo for Portworx" class="logo wp-post-image"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://www.suse.com/products/suse-rancher/"
							style="-webkit-transform: scale(0.9); -ms-transform: scale(0.9); transform: scale(0.9);"
							target="_blank" rel="noopener"
							title="Visit the Rancher website">
							<img width="128" height="128" loading="lazy"
								decoding="async" src="
							<?php
								LF_Utils::get_svg( $report_folder . 'rancher-suse-logo-horizontal_horizontal-color.svg', true );
							?>
							" alt="Logo for Rancher" class="logo wp-post-image"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://www.redhat.com/" target="_blank"
							rel="noopener" title="Visit the Red Hat website">
							<img width="400" height="245" loading="lazy"
								decoding="async" src="
							<?php
								LF_Utils::get_svg( $report_folder . 'RedHat-new.svg', true );
							?>
							" alt="Logo for Red Hat" class="logo wp-post-image"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://www.replicated.com" target="_blank"
							rel="noopener" title="Visit the Replicated website">
							<img width="128" height="128" loading="lazy"
								decoding="async" src="
							<?php
								LF_Utils::get_svg( $report_folder . 'replicated-logo-red-22.svg', true );
							?>
							" alt="Logo for Replicated" class="logo wp-post-image"></a></div>
					<div class="sponsors-logo-item"><a href="https://snyk.io/"
							target="_blank" rel="noopener"
							title="Visit the Snyk website">
							<img width="400" height="245" loading="lazy"
								decoding="async" src="
							<?php
								LF_Utils::get_svg( $report_folder . 'Snyk-spn.svg', true );
							?>
							" alt="Logo for Snyk" class="logo wp-post-image"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://www.splunk.com/en_us/devops.html"
							target="_blank" rel="noopener"
							title="Visit the Splunk website">
							<img width="400" height="245" loading="lazy"
								decoding="async" src="
							<?php
								LF_Utils::get_svg( $report_folder . 'splunk-spn.svg', true );
							?>
							" alt="Logo for Splunk" class="logo wp-post-image"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://sysdig.com/" target="_blank"
							rel="noopener" title="Visit the Sysdig website">
							<img width="400" height="245" loading="lazy"
								decoding="async" src="
							<?php
								LF_Utils::get_svg( $report_folder . 'sysdig-spn.svg', true );
							?>
							" alt="Logo for Sysdig" class="logo wp-post-image"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://goteleport.com/" target="_blank"
							rel="noopener" title="Visit the Teleport website">
							<img width="128" height="128" loading="lazy"
								decoding="async" src="
							<?php
								LF_Utils::get_svg( $report_folder . 'teleport-kcsp.svg', true );
							?>
							" alt="Logo for Teleport" class="logo wp-post-image"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://www.trilio.io/"
							style="-webkit-transform: scale(0.9); -ms-transform: scale(0.9); transform: scale(0.9);"
							target="_blank" rel="noopener"
							title="Visit the Trilio website">
							<img width="396" height="114" loading="lazy"
								decoding="async" src="
							<?php
								LF_Utils::get_svg( $report_folder . 'Trilio-2020.svg', true );
							?>
							" alt="Logo for Trilio" class="logo wp-post-image"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://www.wiz.io/"
							style="-webkit-transform: scale(0.65); -ms-transform: scale(0.65); transform: scale(0.65);"
							target="_blank" rel="noopener"
							title="Visit the Wiz website">
							<img width="128" height="128" loading="lazy"
								decoding="async" src="
							<?php
								LF_Utils::get_svg( $report_folder . 'New_Logo_Blue-1.svg', true );
							?>
							" alt="Logo for Wiz" class="logo wp-post-image"></a></div>
					<div class="sponsors-logo-item"><a href="http://wso2.com"
							style="-webkit-transform: scale(0.75); -ms-transform: scale(0.75); transform: scale(0.75);"
							target="_blank" rel="noopener"
							title="Visit the WSO2 website">
							<img width="128" height="128" loading="lazy"
								decoding="async" src="
							<?php
								LF_Utils::get_svg( $report_folder . 'wso2-logo.svg', true );
							?>
							" alt="Logo for WSO2" class="logo wp-post-image"></a></div>
				</div>

				<div class="shadow-hr"></div>

				<div class="wp-block-button"><a
						href="https://events.linuxfoundation.org/kubecon-cloudnativecon-north-america/sponsor-list/"
						title="See all Sponsors &
						Partners" class="wp-block-button__link">See all Sponsors &
						Partners</a>
				</div>

				<div>

					<div class="shadow-hr"></div>

					<p class="sub-header text-center">Video Highlights</p>

					<div aria-hidden="true" class="report-spacer-60"></div>

					<div class="wp-block-lf-youtube-lite">
						<lite-youtube videoid="Q1cA0iGw84g"
							videotitle="Highlights from KubeCon + CloudNativeCon North America 2022"
							webpStatus="1" sdthumbStatus="0"
							title="Play Highlights">
						</lite-youtube>
					</div>

				</div>

				<div aria-hidden="true" class="report-spacer-120"></div>

			</div>
		</section>

		<section class="section-17 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="lf-grid thanks">
					<div class="thanks__col1">
						<h2 class="section-header">Thank You</h2>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<p
							class="thanks__opening">We hope you enjoyed reflecting on a great event in Detroit - let's do it again in Amsterdam!</p>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<p
							class="thanks__comments">Your comments and feedback are welcome at <a href="mailto:events@cncf.io">events@cncf.io</a></p>

						<div aria-hidden="true" class="report-spacer-80"></div>

						<p>Check out our <a href="https://community.cncf.io" title="Community Events">calendar for community events</a> near you and don't forget to <a href="<?php echo esc_url( $event_link ); ?>register" title="Register for KubeCon+CloudNativeCon North America">register</a> for KubeCon+CloudNativeCon Europe in Amsterdam, April 2023.</p>
					</div>
					<div class="thanks__col2">
						<?php
							LF_Utils::display_responsive_images( 82035, 'full', '300px', null, 'lazy', 'CNCF Mascot' );
						?>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<a href="<?php echo esc_url( $event_link ); ?>"
					title="<?php echo esc_html( $event_text ); ?>">
					<picture>
						<source media="(max-width: 499px)"
							srcset="<?php echo esc_url( wp_get_attachment_image_url( '80844', 'full', false ) ); ?>">
						<source media="(min-width: 500px)"
							srcset="<?php echo esc_url( wp_get_attachment_image_url( '80843', 'full', false ) ); ?>">
						<?php
						LF_Utils::display_responsive_images(
							'80843',
							'full',
							'1200px',
							null,
							'lazy',
							esc_attr( $event_text )
						);
						?>
					</picture>
				</a>

				<div class="shadow-hr"></div>

				<div class="social-share">
					<p class="social-share__title">Share this report</p>

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
	'kccnc-na-22-report',
	get_template_directory_uri() . '/source/js/on-demand/kccnc-na-22-report.js',
	array( 'jquery', 'slick' ),
	filemtime( get_template_directory() . '/source/js/on-demand/kccnc-na-22-report.js' ),
	true
);

get_template_part( 'components/footer' );
