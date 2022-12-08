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
$event_text = 'KubeCon + CloudNativeCon North Amercia 2023 from 17th-21st April';

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
					<img src="https://via.placeholder.com/2400x1603/d9d9d9/000000"
						alt="" class="hero__container-bg-image">
				</figure>
				<div class="hero__content">
					<img class="hero__logo"
						src="<?php LF_Utils::get_svg( $report_folder . 'kccnc-na-22-logo.svg', true ); ?>"
						width="309" height="132"
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

					<p><strong>This KubeCon + CloudNativeCon #TeamCloudNative roared back. Detroit marked the first time we’d gathered in such big numbers in the Midwest, and the city did not disappoint! For many of us, we explored a new region, enjoyed some great food, and broke stereotypes with the renaissance of Detroit.</strong></p>

					<p>Project maintainers, who are the backbone of CNCF projects, were the focus and highlight at KubeCon + CloudNativeCon North America and rightly so. There are approximately 1,000 maintainers in the cloud native ecosystem catering to 175,000+ contributors and serving 7 million+ developers. Without maintainers, there is no ecosystem and it was an honor to support them with initiatives such as Security Slam and ContribFest that strengthened our security posture and brought more contributors to projects at the event.</p>

					<p>One of my personal highlights was interviewing Heba Elayoty and Yuan Tang on the keynote stage. From them we learned what research has demonstrated time and again – maintainers’ biggest ask is for their employers to support them in investing working hours on open source. Companies take note!</p>

					<p>As always, KubeCon + CloudNativeCon was the place for big announcements in our industry. AWS for instance shared their commitment to supporting the Kubernetes project with cloud credits and engineering resources as the project goes on its own multi-cloud journey.</p>

					<p>There is much to unpack from this phenomenal event and I’ve really enjoyed looking back as we put this transparency report together for you. I hope you find the information valuable and look forward to seeing you next April in Amsterdam for <a href="#">KubeCon + CloudNativeCon Europe</a>!</p>

					<div class="section-01__author">
						<?php LF_Utils::display_responsive_images( 73892, 'full', '75px', null, 'lazy', 'Priyanka Sharma' ); ?>
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
							<span>64%</span><br />
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
						<?php LF_Utils::display_responsive_images( 73940, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from KubeCon + CloudNativeCon North Amercia 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 73945, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from KubeCon + CloudNativeCon North Amercia 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 73936, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from KubeCon + CloudNativeCon North Amercia 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 73937, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from KubeCon + CloudNativeCon North Amercia 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 73938, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from KubeCon + CloudNativeCon North Amercia 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 73939, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from KubeCon + CloudNativeCon North Amercia 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 73946, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from KubeCon + CloudNativeCon North Amercia 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 73944, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from KubeCon + CloudNativeCon North Amercia 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 73943, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from KubeCon + CloudNativeCon North Amercia 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 73942, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from KubeCon + CloudNativeCon North Amercia 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 73941, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from KubeCon + CloudNativeCon North Amercia 2022' ); ?>
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
							class="opening-paragraph">This year’s <strong>KubeCon + CloudNativeCon</strong> in Detroit was our first time hosting #TeamCloudNative’s flagship event in the Midwest, and we were thrilled to see so many of you there.<br><br>It’s no surprise that our US community accounted for the largest number of attendees, but it was wonderful to see so many folx coming from Canada and Israel to join us in-person, and from as far afield as India and even New Zealand to be with us both in-person and virtually.</p>
					</div>
				</div>

				<p class="sub-header">Demographics</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<picture>
					<source media="(max-width: 499px)"
						srcset="<?php echo esc_url( wp_get_attachment_image_url( '79248', 'full', false ) ); ?>">
					<source media="(min-width: 500px)"
						srcset="<?php echo esc_url( wp_get_attachment_image_url( '79247', 'full', false ) ); ?>">
					<?php
					LF_Utils::display_responsive_images(
						'79247',
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
					<source media="(max-width: 499px)"
						srcset="<?php LF_Utils::get_svg( $report_folder . 'attendee-geography-map-mobile.svg', true ); ?>">
					<source media="(min-width: 500px)"
						srcset="<?php LF_Utils::get_svg( $report_folder . 'attendee-geography-map-desktop.svg', true ); ?>">
					<img src="<?php LF_Utils::get_svg( $report_folder . 'attendee-geography-map-desktop.svg', true ); ?>"
						alt="Map of the world showing attendee geography - - 81% of in-person attendees were from the USA. 56.1% of online attendees were from the USA."
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
							class="quote-with-name-container__position">Dark Reading</p>
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
								<img loading="lazy" width="45" height="45" src="<?php LF_Utils::get_svg( $report_folder . 'icon-flag-usa.svg', true ); ?>
" alt="USA Flag">
							</div>
							<div class="text">
								<span class="country">USA</span><br />
								<span class="number">10,556</span>
							</div>
						</div>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon">
								<img loading="lazy" width="45" height="45" src="<?php LF_Utils::get_svg( $report_folder . 'icon-flag-india.svg', true ); ?>
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
								<img loading="lazy" width="45" height="45" src="<?php LF_Utils::get_svg( $report_folder . 'icon-flag-canada.svg', true ); ?>
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
								<img loading="lazy" width="45" height="45" src="<?php LF_Utils::get_svg( $report_folder . 'icon-flag-usa.svg', true ); ?>
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
								<img loading="lazy" width="45" height="45" src="<?php LF_Utils::get_svg( $report_folder . 'icon-flag-canada.svg', true ); ?>
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
								<img loading="lazy" width="45" height="45" src="<?php LF_Utils::get_svg( $report_folder . 'icon-flag-israel.svg', true ); ?>
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
								<img loading="lazy" width="45" height="45" src="<?php LF_Utils::get_svg( $report_folder . 'icon-flag-usa.svg', true ); ?>
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
								<img loading="lazy" width="45" height="45" src="<?php LF_Utils::get_svg( $report_folder . 'icon-flag-india.svg', true ); ?>
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
								<img loading="lazy" width="45" height="45" src="<?php LF_Utils::get_svg( $report_folder . 'icon-flag-canada.svg', true ); ?>
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
					<?php LF_Utils::get_svg( $report_folder . 'icon-arrow-down.svg' ); ?>
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
				<?php LF_Utils::display_responsive_images( 73885, 'full', '1200px', '', 'lazy', 'Audience at KubeCon + CloudNativeCon North Amercia 2022' ); ?>
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
								class="quote-with-name-container__position">SiliconANGLE</p>
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
						class="legend__key legend__purple-700"></i> Virtual
				</div>

				<div class="legend__wrapper"><i
						class="legend__key legend__green-700"></i> In-Person
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
							alt="110% increase"></span>

						<div class="thin-hr section-05__chart-key-hr"></div>

						<p
							class="section-05__chart-key-text">From KubeCon + CloudNativeCon 2021 in Los Angeles to the event in Detroit, we saw a 110% increase in in-person attendees.</p>

						<div class="wp-block-button"><a href="#" title="###"
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
							<td>16.8%</td>
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
							<td>3.7%</td>
						</tr>
						<tr>
							<td>Virtual All Access Pass</td>
							<td>N/A</td>
							<td>N/A</td>
							<td>N/A</td>
							<td>N/A</td>
							<td>67.34%</td>
							<td>68%</td>
							<td>47.3%</td>
						</tr>
						<tr>
							<td>Virtual Keynote + Solutions Showcase Only</td>
							<td>N/A</td>
							<td>N/A</td>
							<td>N/A</td>
							<td>N/A</td>
							<td>13.97%</td>
							<td>18%</td>
							<td>4.3%</td>
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
							<td>21%</td>
						</tr>
						<tr>
							<td>Media</td>
							<td>3%</td>
							<td>1%</td>
							<td>1%</td>
							<td>1%</td>
							<td>0.63%</td>
							<td>&lt;1%</td>
							<td>0.9%</td>
						</tr>
						<tr>
							<td>Academic</td>
							<td>N/A</td>
							<td>2%</td>
							<td>2%</td>
							<td>3%</td>
							<td>N/A</td>
							<td>&lt;1%</td>
							<td>0.98%</td>
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

			<a href="#">
				<picture>
					<source media="(max-width: 499px)"
						srcset="<?php echo esc_url( wp_get_attachment_image_url( '73894', 'full', false ) ); ?>">
					<source media="(min-width: 500px)"
						srcset="<?php echo esc_url( wp_get_attachment_image_url( '73893', 'full', false ) ); ?>">
					<?php
					LF_Utils::display_responsive_images(
						'73893',
						'full',
						'1200px',
						null,
						'lazy',
						'Our next Kubecon event TODO #'
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
							class="opening-paragraph">Co-located events feature industry experts covering topics like security, web assembly, AI, GitOps, edge, and more.<br><br>The list of co-located events at KubeCon + CloudNativeCon has been steadily growing for the past few years, so much that we are now spinning off the highly successful <a href="#">CloudNativeSecurityCon</a> into a stand-alone event.</p>
					</div>
				</div>

				<p class="sub-header">CNCF-HOSTED CO-LOCATED EVENTS</p>

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
						'73893',
						'full',
						'265px',
						null,
						'lazy',
						'TODO'
					);
					?>
					<?php
					LF_Utils::display_responsive_images(
						'73893',
						'full',
						'265px',
						null,
						'lazy',
						'TODO'
					);
					?>
					<?php
					LF_Utils::display_responsive_images(
						'73893',
						'full',
						'265px',
						null,
						'lazy',
						'TODO'
					);
					?>
					<?php
					LF_Utils::display_responsive_images(
						'73893',
						'full',
						'265px',
						null,
						'lazy',
						'TODO'
					);
					?>

				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="wp-block-button"><a href="#" title="###"
						class="wp-block-button__link">Browse all co-lo
						reports</a>
				</div>
			</div>
		</section>

		<section class="section-07 alignfull background-image-wrapper">

			<figure class="background-image-figure">
				<?php LF_Utils::display_responsive_images( 73885, 'full', '1200px', '', 'lazy', 'Audience at KubeCon + CloudNativeCon North Amercia 2022' ); ?>
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

							<p>Co-Located events are solely available to level sponsors and packages will launch shortly.</p>

							<div class="wp-block-button"><a href="#" title="###"
									class="wp-block-button__link">Co-located
									Event Options</a>
							</div>

						</div>
					</div>


					<div aria-hidden="true" class="report-spacer-120"></div>

				</div>
			</div>
		</section>

		<section class="section-08
		is-style-down-gradient alignfull" id="content">

			<div class="container wrap">


				<div class="section-title-wrapper">
					<h2 class="section-header">Content</h2>
					<div class="section-number">3/7</div>
				</div>

				<div class="quote-with-name-container">
					<p
						class="quote-with-name-container__quote">Thankfully this year’s <strong>KubeCon + CloudNativeCon North America</strong> did something a little different. It still had a lot of the newest, shiniest technologies as well as plenty of discussions for elite DevOps organizations. But the schedule was also packed with a 101 track and welcomes to many Special Interest Groups (SIGs). It also gave a lot of advice on how to support these highly distributed, often voluntary communities.</p>
					<div class="quote-with-name-container__marks">
						<p
							class="quote-with-name-container__name">Jennifer Riggins</p>
						<p
							class="quote-with-name-container__position">The New Stack</p>
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

						<?php LF_Utils::display_responsive_images( 73887, 'full', '200px', 'section-08__chairs__image', 'lazy', 'Frederick Kautz' ); ?>
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
							<p>The schedule was curated by conference co-chairs, Richardo Rocha of CERN, Emily Fox of Apple, and Frederick Kautz of Doc.ai, who led a program committee of 93 experts and 34 track chairs, including project maintainers, active community members, and highly rated presenters from past events.<br><br>Talks are selected by the program committee through a rigorous, non-bias process, where they are randomly assigned submissions to review within their area of expertise. You can read the details in our <a href="#">CFP scoring guidelines</a>, and specifically about the <a href="#">North America selection process</a>.
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
							<td>66</td>
							<td>23%</td>
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
						<p>The CTO Summit gathered a tight-knit group of technology leaders from some of cloud native’s biggest end users to discuss what maturity means in the cloud native world. Focusing on the intersection between <a href="#">provisioning</a> and the <a href="#">Cloud Native Maturity Model</a>, leaders openly discussed the challenges, cultural shifts, and technical solutions they’ve seen on their journey to improve the maturity and resiliency of their cloud native infrastructure.</p>
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

				<img loading="lazy" width="35" height="110"
					src="<?php LF_Utils::get_svg( $report_folder . 'logo-uptycs.svg', true ); ?>"
					alt="Logo for Uptycs" class="logo-grid__image">

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
						<?php LF_Utils::display_responsive_images( 73892, 'large', '600px', null, 'lazy', 'End User Presentations' ); ?>
					</div>

					<div class="section-12__presentations-col2">

						<p class="sub-header">End User Presentations</p>

						<p>More than one third of talks at KubeCon + CloudNativeCon North America were from end users who shared insightful and valuable stories from across the stack.<br><br><a href="#">Watch all talks on our YouTube playlist</a>.</p>

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
							class="opening-paragraph">More than <strong>3,500</strong> people joined us for KubeCon + CloudNativeCon North America thanks to the Dan Kohn Scholarship Fund, including diversity, need-based, and student scholarship opportunities.</p>
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
					LF_Utils::display_responsive_images( 73897, 'full', '800px', 'banner__image', 'lazy', 'People on banner at KubeCon + CloudNativeCon Europe 2022' );
					?>
					<div class="banner__title-wrapper">
						<h2 class="banner__title">Check out our scholarship
							recipients!</h2>
					</div>
					<div class="banner__text-wrapper">
						<h3 class="banner__text">Apply for a scholarship to join
							us at KubeCon + CloudNativeCon Europe 2023</h3>
						<div class="wp-block-button"><a href="#"
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
							class="opening-paragraph">This year we partnered with <a href="#">Sonatype</a> to host the first ever <a href="#">Security Slam</a> virtual event on November 21, 2022. Thirteen projects participated, leveraging existing CNCF tools to increase their open source security posture, awareness, and compliance. <strong>Google donated $27,500 to the Dan Kohn Scholarship Fund</strong> in the name of the projects that made it to 100% security.</p>
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

				<?php LF_Utils::display_responsive_images( 73892, 'full', '230px', null, 'lazy', 'Kids Day' ); ?>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-13__kids">
					<div class="section-13__kids-col1">
						<p
							class="opening-paragraph">On Sunday, October 23, we hosted our first complimentary Kid’s Day in Detroit. Featuring two workshops:</p>

						<ol>
							<li>Minecraft Modding</li>
							<li>Gotta Catch ‘em All! Raspberry Pi And Java
								Pokemon Training</li>
						</ol>

						<p>We’ll host Kid’s Day again at <a href="#">KubeCon + CloudNativeCon Europe in Amsterdam</a> this coming April, for all children (ages 8-14) who are interested in technology, coding, and STEAM fields.</p>

						<div aria-hidden="true" class="report-spacer-40"></div>

						<div class="wp-block-button"><a href="#" title="###"
								class="wp-block-button__link">See Gallery</a>
						</div>
					</div>
					<div class="section-13__kids-col2">
						<a href="#">
							<?php
							LF_Utils::display_responsive_images( 73940, 'newsroom-post-width', '600px', null, 'lazy', 'Kids Day' );
							?>
						</a>
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
