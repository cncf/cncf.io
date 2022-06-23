<?php
/**
 * Template Name: KCCNC EU 22 Transparency
 * Template Post Type: lf_report
 *
 * File for the KCCNC EU 2022 Transparency Report
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

get_template_part( 'components/header' );

get_template_part( 'components/skip-link-target' );

// declare report PDF link to reference as variable.
$pdf_link = 'https://cncf.io/coming-soon.pdf';
// declare the next event link and alt as a variable.
$event_link = 'https://events.linuxfoundation.org/kubecon-cloudnativecon-north-america/';
$event_text = 'KubeCon + CloudNativeCon North America 2022 in Detroit from October 24th-28th';
// Report folder in images/ folder.
$report_folder = 'reports/kccnc-eu-22/'

?>

<link rel="prefetch"
	href="<?php echo esc_url( get_template_directory_uri() . '/build/kccnc-eu-22-transparency.min.css' ); ?>"
	as="style" crossorigin="anonymous" />

<?php wp_enqueue_style( 'kccnc-eu-22', get_template_directory_uri() . '/build/kccnc-eu-22-transparency.min.css', array(), filemtime( get_template_directory() . '/build/kccnc-eu-22-transparency.min.css' ), 'all' ); ?>

<?php
// setup social share content.
$caption  = 'Read the CNCF KubeCon + CloudNativeCon Europe 2022 Transparency Report: ';
$page_url = rawurlencode( get_permalink() );
$caption  = htmlspecialchars( rawurlencode( html_entity_decode( $caption, ENT_COMPAT, 'UTF-8' ) ), ENT_COMPAT, 'UTF-8' );

/**
 * Gets Twitter handle.
 */
$options = get_option( 'lf-mu' );
$options && $options['social_twitter_handle'] ? $twitter = $options['social_twitter_handle'] : $twitter = '';

$twitter_url  = 'https://twitter.com/intent/tweet?text=' . $caption . '&amp;url=' . $page_url . '&amp;hashtags=cncf&amp;via=' . $twitter . '';
$linkedin_url = 'https://www.linkedin.com/shareArticle?mini=true&url=' . $page_url . '&summary=' . $caption . '';
$mailto_url   = 'mailto:?subject=CNCF KubeCon + CloudNativeCon Europe 2022 Transparency Report&body=' . $caption . '&nbsp;' . $page_url . '';
?>

<main class="kccnc-eu-22">
	<article class="container wrap">

		<section class="hero alignfull">
			<div class="container wrap hero__wrap">
				<div class="hero__text-overlay">
					<div class="container hero__container">

						<div class="hero__wrapper">
							<img class="hero__logo"
								src="<?php LF_Utils::get_svg( $report_folder . 'kubecon-eu-2022-logo.svg', true ); ?>"
								width="309" height="135"
								alt="KubeCon + CloudNativeCon Europe 2022 Logo"
								loading="eager">

							<h1 class="hero__title uppercase">Transparency
								<br />Report
							</h1>

							<div class="hero__hr"></div>

							<div class="hero__button-share-align">

								<div class="wp-block-button hero__button"><a
										href="<?php echo esc_url( $pdf_link ); ?>"
										class="wp-block-button__link"
										title="Download full report as PDF">Download
										full
										PDF</a>
								</div>

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
							</div>
						</div>

						<div class="hero__jump">Jump to section:</div>
					</div>
				</div>

				<figure class="hero__bg-shape">
					<img width="1000" height="1070" loading="eager" src="
<?php
Lf_Utils::get_image( $report_folder . 'motif.png' );
?>
" alt="Background flower">
				</figure>
			</div>
			<figure class="hero__bg-gradient"></figure>

		</section>

		<!-- Navigation  -->
		<section style="position: relative;">
			<div class="nav-el">

				<div class="nav-el__box">
					<a href="#attendees"
						title="Jump to Attendee Overview section"
						class="box-link"></a>
					<img loading="lazy" width="36" height="36" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-bar-chart.svg', true ); ?>
" alt="Bar chart icon">Attendees Overview
				</div>

				<div class="nav-el__box">
					<a href="#endusers" title="Jump to End Users section"
						class="box-link"></a>
					<img loading="lazy" width="36" height="36" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-user.svg', true ); ?>
" alt="User icon">End Users
				</div>

				<div class="nav-el__box">
					<a href="#colocated" title="Jump to Co-located Events"
						class="box-link"></a>
					<img loading="lazy" width="36" height="36" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-pin.svg', true ); ?>
" alt="Map pin icon">Co-located Events
				</div>

				<div class="nav-el__box">
					<a href="#content" title="Jump to Content section"
						class="box-link"></a>
					<img loading="lazy" width="36" height="36" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-megaphone.svg', true ); ?>
" alt="Megaphone icon">
					Content
				</div>

				<div class="nav-el__box">
					<a href="#coverage" title="Jump to Media Coverage section"
						class="box-link"></a>
					<img loading="lazy" width="36" height="36" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-media.svg', true ); ?>
" alt="Media icon">
					Media Coverage
				</div>

				<div class="nav-el__box">
					<a href="#covid" title="Jump to COVID safety section"
						class="box-link"></a>
					<img loading="lazy" width="36" height="36"
						src="<?php LF_Utils::get_svg( $report_folder . 'icon-mask.svg', true ); ?>"
						alt="Mask icon">
					COVID Safety
				</div>
			</div>
		</section>

		<!-- Intro  -->
		<section class="section-01">

			<div class="lf-grid">
				<h2 class="section-01__title">What an amazing week in Valencia!
				</h2>
			</div>

			<div class="lf-grid section-01__grid">
				<div class="section-01__grid-col1">
					<p><strong>Wow, did it feel good to be back together! KubeCon + CloudNativeCon Valencia was the first time we'd gathered TeamCloudNative in Europe for two years and the atmosphere felt electric. It was such a great opportunity to greet our old friends and welcome many new folks to the family.</strong></p>

					<p>It was exciting for me personally to see how much this incredible community has evolved since my first KubeCon + CloudNativeCon in 2016 when just 1500 of us gathered together. In Valencia, we had more than 7,000 folks joining in-person plus 11,000 virtually! And what's more, 65% of you were first-time attendees.</p>

					<p>In fact, we had a lot of firsts in Valencia. Boeing joined us as a platinum member - the first airline to join CNCF. We hosted Cloud Native Telco Day for the very first time, gathering huge players like Deutsche Telekom and Orange who are advancing the industry. Plus, we hosted our first CTO Summit where we discussed how organizations achieve resiliency in multi-cloud strategies.</p>

					<p>I've really enjoyed looking back at the event as we put this transparency report together for you. Can't wait to see you this October in Detroit for KubeCon + CloudNativeCon North America! </p>

					<div class="author">
						<?php LF_Utils::display_responsive_images( 73892, 'full', '75px', '', 'lazy', 'Priyanka Sharma' ); ?>
						<p><strong>Priyanka Sharma</strong><br>
General Manager, CNCF</p>
					</div>
				</div>

				<div class="section-01__grid-col2">

					<!-- Icon 1  -->
					<div class="icon-box-1">
						<div class="icon">
							<img loading="lazy" width="52" height="52" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-badge-o.svg', true ); ?>
" alt="Badge icon">
						</div>
						<div class="text">
							<span>65%</span><br />
							First-time attendees
						</div>
					</div>

					<!-- Icon 2  -->
					<div class="icon-box-1">
						<div class="icon">
							<img loading="lazy" width="45" height="40" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-heart-o.svg', true ); ?>
" alt="Heart icon">
						</div>
						<div class="text">
							<span>7,084</span><br />
							In-person attendees
						</div>
					</div>

					<!-- Icon 3  -->
					<div class="icon-box-1">
						<div class="icon">
							<img loading="lazy" width="45" height="33" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-megaphone-o.svg', true ); ?>
" alt="Megaphone icon">
						</div>
						<div class="text">
							<span>2,300+</span><br />
							Pieces of media coverage
						</div>
					</div>

					<!-- Icon 4  -->
					<div class="icon-box-1">
						<div class="icon">
							<img loading="lazy" width="34" height="45" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-person-o.svg', true ); ?>
" alt="People icon">
						</div>
						<div class="text">
							<span>First in-person</span><br />
							Event in Europe since 2019
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
						<h3 class="sub-header">Valencia Photo Highlights</h3>
					</div>
					<div class="wp-block-column is-vertically-aligned-bottom"
						style="flex-basis:20%">
						<p
							class="has-text-align-right is-style-link-cta"><a href="https://www.flickr.com/photos/143247548@N03/albums/72177720298987342" title="KubeCon + CloudNativeCon Europe 2022 Photo Gallery">See more</a></p>
					</div>
				</div>
				<!-- TODO: Slider  -->
				<img src="https://picsum.photos/1200/500" alt=""
					class="section-02__slider">
			</div>

		</section>

		<section id="attendees"
			class="section-03 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">ATTENDEE <br />
						OVERVIEW</h2>
					<div class="section-number">1/6</div>
				</div>

				<p class="opening-paragraph max-w-1100">
				KubeCon + CloudNativeCon Valencia was our first time back together in-person since Barcelona in 2019 and <strong>we more than doubled the number of folks who joined us</strong>, both in Valencia and virtually. Our European community accounted for the largest number of attendees, but it was wonderful to see folks coming from as far as Africa, Australia and South America to be with us.</p>

				<p class="sub-header">Demographics</p>

				<div aria-hidden="true" class="report-spacer-75"></div>

				<figure class="floating-flowers floating-flowers-01">
					<img width="708" height="821" loading="lazy" src="
					<?php
					Lf_Utils::get_image( $report_folder . 'motif.png' );
					?>
					" alt="Background flower">
				</figure>

				<img width="500" height="481" src="
				<?php
				Lf_Utils::get_svg( $report_folder . 'attendees-mobile.svg', true );
				?>
				" alt="Showing 18,550 Registered attendees of which 45.2% were men, 6.5% women, 0.4% non-binary/other, and 47.9% preferred not to answer. Of the attendees 7.084 (38%) were in person, 11,466 (62%) were virtual. 65% of visitors were first timers."
					class="show-upto-500 section-03__demo-mobile"
					loading="lazy">

				<img width="1100" height="364" src="
				<?php
				Lf_Utils::get_svg( $report_folder . 'attendees-desktop.svg', true );
				?>
				" alt="Showing 18,550 Registered attendees of which 45.2% were men, 6.5% women, 0.4% non-binary/other, and 47.9% preferred not to answer. Of the attendees 7.084 (38%) were in person, 11,466 (62%) were virtual. 65% of visitors were first timers."
					class="show-over-500 section-03__demo-desktop"
					loading="lazy">

				<div aria-hidden="true" class="report-spacer-140"></div>

				<p class="sub-header">Attendee Geography</p>

				<div aria-hidden="true" class="report-spacer-75"></div>

				<img width="500" height="305" src="
				<?php
				Lf_Utils::get_svg( $report_folder . 'attendee-geography-map-mobile.svg', true );
				?>
				" alt="Map of attendee geography" class="show-upto-500" loading="lazy">

				<img width="1027" height="516" src="
				<?php
				Lf_Utils::get_svg( $report_folder . 'attendee-geography-map-desktop.svg', true );
				?>
				" alt="Map of attendee geography" class="show-over-500 section-03__map"
					loading="lazy">

				<div class="section-03__attendees">

					<div class="legend__wrapper"><i
							class="legend__key legend__green-700"></i> Virtual
					</div>

					<div class="legend__wrapper"><i
							class="legend__key legend__green-200"></i> In-Person
					</div>

				</div>


				<div aria-hidden="true" class="report-spacer-20"></div>

				<div class="shadow-hr"></div>

				<div class="quote-container">
					<p
						class="quote-container__quote">Having seen what KubeCon has to offer, I'm sorry I missed every previous KubeCon since 2015. For a veteran cloud blogger, this conference is a peek into the future of distributed development.</p>
					<div class="quote-container__marks">
						<p class="quote-container__name">Ofir Nachmani</p>
						<p class="quote-container__position">IamOnDemand</p>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p
					class="sub-header is-centered">Top Countries in attendance</p>

				<div class="lf-grid section-03__top-countries">
					<div class="section-03__top-countries-col1">
						<p class="table-header">Total</p>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon">
								<img loading="lazy" width="52" height="52" src="<?php LF_Utils::get_svg( $report_folder . 'icon-usa.svg', true ); ?>
" alt="USA Flag">
							</div>
							<div class="text">
								<span class="country">USA</span><br />
								<span class="number">3,035</span>
							</div>
						</div>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon">
								<img loading="lazy" width="52" height="52" src="<?php LF_Utils::get_svg( $report_folder . 'icon-germany.svg', true ); ?>
" alt="German Flag">
							</div>
							<div class="text">
								<span class="country">Germany</span><br />
								<span class="number">2,463</span>
							</div>
						</div>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon">
								<img loading="lazy" width="52" height="52" src="<?php LF_Utils::get_svg( $report_folder . 'icon-india.svg', true ); ?>
" alt="India Flag">
							</div>
							<div class="text">
								<span class="country">India</span><br />
								<span class="number">1,798</span>
							</div>
						</div>

					</div>
					<div class="section-03__top-countries-col2">
						<p class="table-header">In-person</p>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon">
								<img loading="lazy" width="52" height="52" src="<?php LF_Utils::get_svg( $report_folder . 'icon-usa.svg', true ); ?>
" alt="USA Flag">
							</div>
							<div class="text">
								<span class="country">USA</span><br />
								<span class="number">1,309</span>
							</div>
						</div>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon">
								<img loading="lazy" width="52" height="52" src="<?php LF_Utils::get_svg( $report_folder . 'icon-germany.svg', true ); ?>
" alt="German Flag">
							</div>
							<div class="text">
								<span class="country">Germany</span><br />
								<span class="number">1,060</span>
							</div>
						</div>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon">
								<img loading="lazy" width="52" height="52" src="<?php LF_Utils::get_svg( $report_folder . 'icon-uk.svg', true ); ?>
" alt="German Flag">
							</div>
							<div class="text">
								<span class="country">United
									Kingdom</span><br />
								<span class="number">725&nbsp;&nbsp;</span>
							</div>
						</div>

					</div>
					<div class="section-03__top-countries-col3">
						<p class="table-header">Virtual</p>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon">
								<img loading="lazy" width="52" height="52" src="<?php LF_Utils::get_svg( $report_folder . 'icon-usa.svg', true ); ?>
" alt="USA Flag">
							</div>
							<div class="text">
								<span class="country">USA</span><br />
								<span class="number">1,725</span>
							</div>
						</div>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon">
								<img loading="lazy" width="52" height="52" src="<?php LF_Utils::get_svg( $report_folder . 'icon-india.svg', true ); ?>
" alt="India Flag">
							</div>
							<div class="text">
								<span class="country">India</span><br />
								<span class="number">1,702</span>
							</div>
						</div>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon">
								<img loading="lazy" width="52" height="52" src="<?php LF_Utils::get_svg( $report_folder . 'icon-germany.svg', true ); ?>
" alt="German Flag">
							</div>
							<div class="text">
								<span class="country">Germany</span><br />
								<span class="number">1,403</span>
							</div>
						</div>

					</div>

				</div>

				<div aria-hidden="true" style="height: 40px;"></div>

				<p class="sub-header is-centered">Top Three Job Functions</p>

				<div class="lf-grid section-03__top-jobs">
					<div class="section-03__top-jobs-col1">
						<p class="table-header">DevOps / SRE / Sysadmin</p>
						<span class="large">6,395</span>
					</div>
					<div class="section-03__top-jobs-col2">
						<p class="table-header">Developer</p>
						<span class="large">3,867</span>
					</div>
					<div class="section-03__top-jobs-col3">
						<p class="table-header">Architect</p>

						<span class="large">3,127</span>
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
												<td>3127</td>
											</tr>
											<tr>
												<td>Business Operations</td>
												<td>189</td>
											</tr>
											<tr>
												<td>Developer</td>
												<td>3868</td>
											</tr>
											<tr>
												<td> – Data Scientist</td>
												<td>240</td>
											</tr>
											<tr>
												<td> – Full Stack Developer</td>
												<td>2945</td>
											</tr>
											<tr>
												<td> – Machine Learning
													Specialist</td>
												<td>118</td>
											</tr>
											<tr>
												<td> – Web Developer</td>
												<td>42</td>
											</tr>
											<tr>
												<td> – Mobile Developer</td>
												<td>523</td>
											</tr>
											<tr>
												<td>DevOps / SRE / SysAdmin</td>
												<td>6396</td>
											</tr>
											<tr>
												<td>Executive</td>
												<td>690</td>
											</tr>
											<tr>
												<td>IT Operations</td>
												<td>571</td>
											</tr>
											<tr>
												<td> – DevOps</td>
												<td>205</td>
											</tr>
											<tr>
												<td> – Systems Admin</td>
												<td>12</td>
											</tr>
											<tr>
												<td> – Site Reliability Engineer
												</td>
												<td>71</td>
											</tr>
											<tr>
												<td> – Quality Assurance
													Engineer</td>
												<td>283</td>
											</tr>
											<tr>
												<td>Sales / Marketing</td>
												<td>1097</td>
											</tr>
											<tr>
												<td>Media / Analyst</td>
												<td>158</td>
											</tr>
											<tr>
												<td>Student</td>
												<td>777</td>
											</tr>
											<tr>
												<td>Professor / Academic</td>
												<td>77</td>
											</tr>
											<tr>
												<td>Other</td>
												<td>1027</td>
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
												<td>533</td>
											</tr>
											<tr>
												<td>Consumer Goods</td>
												<td>578</td>
											</tr>
											<tr>
												<td>Energy</td>
												<td>229</td>
											</tr>
											<tr>
												<td>Finanacials</td>
												<td>1645</td>
											</tr>
											<tr>
												<td>Health Care</td>
												<td>351</td>
											</tr>
											<tr>
												<td>Industrials</td>
												<td>317</td>
											</tr>
											<tr>
												<td>Information Technology</td>
												<td>12631</td>
											</tr>
											<tr>
												<td>Materials</td>
												<td>45</td>
											</tr>
											<tr>
												<td>Non-Profit Organization</td>
												<td>391</td>
											</tr>
											<tr>
												<td>Professional Services</td>
												<td>835</td>
											</tr>
											<tr>
												<td>Telecommunications</td>
												<td>1023</td>
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

				<div aria-hidden="true" class="report-spacer-120"></div>

			</div>
		</section>

		<section class="section-04 alignfull background-image-wrapper">

			<figure class="background-image-figure">
				<?php LF_Utils::display_responsive_images( 73885, 'full', '1200px', '', 'lazy', 'Audience at Kubecon + CloudNativeCon Europe 2022' ); ?>
			</figure>

			<div class="background-image-text-overlay">
				<div class="container wrap">

					<div class="quote-container">
						<p
							class="quote-container__quote">At 7.1 million people the @CloudNativeFdn community is as big as Denmark! 🇩🇰 #kubecon</p>
						<div class="quote-container__marks">
							<p class="quote-container__name">Liz Rice</p>
							<p
								class="quote-container__position">Isovalent, via Twitter</p>
						</div>
					</div>

				</div>
			</div>
		</section>

		<section class="section-05">

			<p class="sub-header">Year on Year Growth - Europe Events</p>

			<div class="graph">
				<div class="graph__image">

					<div class="graph__image-key">

						<div class="legend__wrapper"><i
								class="legend__key legend__orange-400"></i>
							In-person
						</div>

						<div class="legend__wrapper"><i
								class="legend__key legend__green-100"></i>
							Virtual
						</div>

						<div class="legend__wrapper"><i
								class="legend__key legend__orange-700"></i>
							Hybrid
						</div>


					</div>

					<img loading="lazy" width="762" height="436" src="
							<?php LF_Utils::get_svg( $report_folder . 'attendees-yoy-growth.svg', true ); ?>
							" alt="Chart showing year on year attendee growth">
				</div>
				<div class="graph__explainer">
					<span class="graph__number">140%</span>

					<div class="graph__divider"></div>

					<p
						class="graph__text">From the last in-person KubeCon + CloudNativeCon in Barcelona, 2019, to 2022's event in Valencia, we saw a 140% increase in total attendees.</p>

					<div class="wp-block-button hero__button"><a
							href="<?php echo esc_url( $event_link ); ?>"
							title="<?php echo esc_html( $event_text ); ?>"
							class="wp-block-button__link has-black-background-color has-background">Register
							for North America</a>
					</div>

				</div>

			</div>

			<div class="shadow-hr"></div>

			<div class="kccnc-table-container">
				<table class="kccnc-table growth-table">
					<thead>
						<tr>
							<th>Ticket Type
							</th>
							<th>2017
								<span>Berlin</span>
							</th>
							<th>2018
								<span>Copenhagen</span>
							</th>
							<th>2019
								<span>Barcelona</span>
							</th>
							<th>2020
								<span>Virtual</span>
							</th>
							<th>2021
								<span>Virtual</span>
							</th>
							<th>2022
								<span>Valencia</span>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Total</td>
							<td>1,535</td>
							<td>4,300</td>
							<td>7,700</td>
							<td>18.682</td>
							<td>26,648</td>
							<td>18,550</td>
						</tr>
						<tr>
							<td class="nowrap">In-person Corporate</td>
							<td>58%</td>
							<td>62%</td>
							<td>63%</td>
							<td>N/A</td>
							<td>N/A</td>
							<td>18.7%</td>
						</tr>
						<tr>
							<td class="nowrap">In-person Individual
							</td>
							<td>12%</td>
							<td>10%</td>
							<td>13%</td>
							<td>N/A</td>
							<td>N/A</td>
							<td>7%</td>
						</tr>
						<tr>
							<td>Virtual All Access Pass</td>
							<td>N/A</td>
							<td>N/A</td>
							<td>N/A</td>
							<td>71%</td>
							<td>66.8%</td>
							<td>49.6%</td>
						</tr>
						<tr>
							<td>Virtual Keynote + Solutions Showcase Only</td>
							<td>N/A</td>
							<td>N/A</td>
							<td>N/A</td>
							<td>20%</td>
							<td>26.6%</td>
							<td>8.3%</td>
						</tr>
						<tr>
							<td>Speaker</td>
							<td>9%</td>
							<td>8%</td>
							<td>6%</td>
							<td>2%</td>
							<td>1.1%</td>
							<td>2.6%</td>
						</tr>
						<tr>
							<td>Sponsor</td>
							<td>17%</td>
							<td>16%</td>
							<td>14%</td>
							<td>6%</td>
							<td>4.7%</td>
							<td>11.7%</td>
						</tr>
						<tr>
							<td>Media</td>
							<td>2%</td>
							<td>2%</td>
							<td>1%</td>
							<td>&lt;1%</td>
							<td>0.6%</td>
							<td>0.9%</td>
						</tr>
						<tr>
							<td>Academic</td>
							<td>2%</td>
							<td>3%</td>
							<td>3%</td>
							<td>N/A</td>
							<td>N/A</td>
							<td>1.2%</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="shadow-hr"></div>

			<div class="lf-grid dei">
				<div class="dei__col-1">
					<p class="sub-header">Diversity, Equity & Inclusivity</p>
					<p>CNCF strives to ensure that everyone who participates in KubeCon + CloudNativeCon feels welcome, regardless of gender, gender identity, sexual orientation, disability, race, ethnicity, age, religion, or economic status. Just over 8% of attendees identified as a person of color and many preferred not to answer. As part of our deep commitment to diversity, equity, and inclusivity, we hosted a number of workshops and networking opportunities to help connect individuals to opportunities within tech.
</p>
				</div>
				<div class="dei__col-2">
					<p class="sub-header">Gold CHAOSS D&I Event Badge</p>
					<img width="291" height="70" src="
					<?php
					Lf_Utils::get_image( $report_folder . 'dandigold.png' );
					?>
					" alt="Gold CHAOSS D&I Event Badge" loading="lazy">
					<p>Awarded to events in the open source community that fosters healthy D&I practices. KubeCon + CloudNativeCon achieved this award for our DEI work in Valencia.</p>
				</div>
			</div>

			<div class="shadow-hr"></div>

			<div class="kccnc-table-container">
				<table class="kccnc-table dei__table">
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
							<td>35</td>
						</tr>
						<tr>
							<td>Allyship Workshop participants</td>
							<td>25</td>
						</tr>
						<tr>
							<td>EmpowerUs participants</td>
							<td>25</td>
						</tr>
						<tr>
							<td>Peer Group Mentoring + Career Networking mentors
								-
								in-person</td>
							<td>5</td>
						</tr>
						<tr>
							<td>Peer Group Mentoring + Career Networking mentees
								-
								in-person</td>
							<td>23</td>
						</tr>
						<tr>
							<td>Peer Group Mentoring + Career Networking mentors
								-
								virtual</td>
							<td>1</td>
						</tr>
						<tr>
							<td>Peer Group Mentoring + Career Networking mentees
								-
								virtual</td>
							<td>32</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div aria-hidden="true" class="report-spacer-120"></div>

			<p
				class="sub-header is-centered has-lines">Our Next Kubecon + CloudNativeCon</p>

			<div aria-hidden="true" class="report-spacer-60"></div>

			<a href="<?php echo esc_url( $event_link ); ?>"
				title="<?php echo esc_html( $event_text ); ?>">

				<?php LF_Utils::display_responsive_images( 73894, 'full', '414px', 'show-upto-500', 'lazy', esc_html( $event_text ) ); ?>

				<?php LF_Utils::display_responsive_images( 73893, 'full', '1200px', 'show-over-500', 'lazy', esc_html( $event_text ) ); ?>

			</a>

		</section>

		<section id="endusers"
			class="section-06 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">End <br />
						Users</h2>
					<div class="section-number">2/6</div>
				</div>

				<p class="opening-paragraph max-w-900">
	End users are an important part of #TeamCloudNative and played a significant role in Valencia by driving new initiatives and sharing valuable experiences in presentations.</p>

				<p class="sub-header">Key Stats</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid stats">
					<div class="stats__col1">

						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" width="58" height="58" src="<?php LF_Utils::get_svg( $report_folder . 'icon-share-o.svg', true ); ?>
							" alt="Share icon">
							</div>
							<div class="text">
								<span class="number">7,847</span><br />
								<span class="description">Attendees Work For
									End User Organizations</span>
							</div>
						</div>

					</div>
					<div class="stats__col2">


						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" width="50" height="64" src="<?php LF_Utils::get_svg( $report_folder . 'icon-building-o.svg', true ); ?>
							" alt="Building icon">
							</div>
							<div class="text">
								<span class="number">4,132</span><br />
								<span class="description">End User
									Organizations Attended</span>
							</div>
						</div>

					</div>
					<div class="stats__col3">


						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" width="103" height="58" src="<?php LF_Utils::get_svg( $report_folder . 'icon-users-o.svg', true ); ?>
							" alt="Users icon">
							</div>
							<div class="text">
								<span class="number">137</span><br />
								<span class="description">End User Members /
									Supporters Attended</span>
							</div>
						</div>

					</div>
				</div>

				<div class="shadow-hr"></div>

				<div class="lf-grid cto">

					<div class="cto__col1">
						<p class="sub-header">CTO Summit</p>
						<p>As teams adopt cloud native strategies with public, private, or hybrid clouds, it becomes apparent that achieving multi-cloud resiliency takes a radically different approach than what teams are familiar with implementing. At the inaugural CTO Summit we discussed the barriers and advantages to adopting a multi-cloud strategy that will help lead to higher team performance, service availability, and lower operational costs. </p>
					</div>

					<div class="cto__col2">

						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="text">
								<span class="number">21</span><br />
								<span class="description">CTO Summit
									Attendees</span>
							</div>
						</div>

					</div>

				</div>

				<div class="shadow-hr"></div>

				<div class="quote-container max-w-800">
					<p
						class="quote-container__quote">Culture is really what's important at the end of the day. People are always harder than processes or technology. It's always the people.</p>
					<div class="quote-container__marks">
						<p class="quote-container__name">Attendee</p>
						<p class="quote-container__position">CTO Summit</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-120"></div>

			</div>

		</section>

		<section class="section-07 has-gray-background alignfull">

			<div class="container wrap">

				<div aria-hidden="true" class="report-spacer-120"></div>

				<div class="lf-grid presentations">

					<div class="presentations__col1">

						<a href="https://www.youtube.com/playlist?list=PLj6h78yzYM2PfD9vkHopnzNNIVicOFtih"
							title="KubeCon + CloudNativeCon Europe 2022 [End User Sessions]">
							<?php LF_Utils::display_responsive_images( 73890, 'full', '600px', '', 'lazy', 'Screenshots of End User Sessions from KubeCon + CloudNativeCon Europe 2022' ); ?></a>
					</div>
					<div class="presentations__col2">

						<p class="sub-header">End User Presentations</p>

						<p>More than one third of talks at KubeCon + CloudNativeCon Valencia were from end users who shared insightful and valuable stories from across the stack.</p>

						<p>You can watch all 49 talks on our <a title="YouTube End User playlist" href="https://www.youtube.com/playlist?list=PLj6h78yzYM2PfD9vkHopnzNNIVicOFtih">end user playlist</a>.</p>

					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-120"></div>

			</div>

		</section>

		<section class="section-08">

			<div aria-hidden="true" class="report-spacer-120"></div>

			<p class="sub-header">Two New End User Initiatives  Launched</p>

			<div class="lf-grid initiatives">
				<div class="initiatives__col1">
					<a href="https://www.cncf.io/humans-of-cloud-native/"
						title="Humans of Cloud Native"><img
							src="<?php LF_Utils::get_svg( $report_folder . 'humans-of-cloud-native-logo.svg', true ); ?>"
							width="370" height="80"
							alt="Humans of cloud native logo"
							loading="lazy"></a>

					<p><a href="https://www.cncf.io/humans-of-cloud-native/" title="Humans of Cloud Native">Humans of Cloud Native</a><br>Telling the stories of amazing individuals and their contributions that make TeamCloudNative such a vibrant, exciting, and diverse space.</p>
				</div>
				<div class="initiatives__col2">

					<a href="https://www.cncf.io/certification/cnf/"
						title="Cloud Native Network Function (CNF) Certification Program"><img
							src="<?php LF_Utils::get_svg( $report_folder . 'certified-cnf-badge.svg', true ); ?>"
							width="90" height="134" alt="Certified CNF badge"
							loading="lazy"></a>

					<p><a href="https://www.cncf.io/certification/cnf/" title="Cloud Native Network Function (CNF) Certification Program">Cloud Native Network Function (CNF) Certification Program</a> (Beta)<br>Helping the telecom industry in its adoption of cloud native technologies and best practices. The certification is built on the CNF Test Suite framework and includes tests from CNCF-hosted projects.</p>

				</div>

			</div>

			<div aria-hidden="true" class="report-spacer-120"></div>

		</section>

		<section id="colocated"
			class="section-09 is-style-down-gradient alignfull">

			<div class="container wrap">

				<figure class="floating-flowers floating-flowers-02">
					<img width="708" height="821" loading="lazy" src="
					<?php
					Lf_Utils::get_image( $report_folder . 'motif.png' );
					?>
					" alt="Background flower">
				</figure>

				<div class="section-title-wrapper">
					<h2 class="section-header">Co-Located <Br />
						Events</h2>
					<div class="section-number">3/6</div>
				</div>

				<p class="opening-paragraph max-w-1000">
				Valencia played host to the inaugural <a href="https://events.linuxfoundation.org/cloud-native-telco-day-europe/" title="Cloud Native Telco Day">Cloud Native Telco Day</a> featuring speakers from major telco service providers like Deutsche Telekom, Bell Canada, Orange, and Swisscom.</p>
				<p
					class="opening-paragraph max-w-1000">Co-located events feature industry experts covering topics like security, web assembly, AI, GitOps, edge, and more.</p>

				<div class="lf-grid colocated">
					<div class="colocated__col1">
						<p class="sub-header">CNCF-Hosted Co-Located Events</p>
					</div>
					<div class="colocated__col2">

						<div class="legend__wrapper"><i
								class="legend__key legend__orange-700"></i>
							In-Person Registrants</div>

					</div>
				</div>

				<div aria-hidden="true" style="height: 40px"></div>

				<div class="lf-grid colocated colocated-data">
					<div class="colocated__col1">
						<div class="kccnc-table-container">
							<table class="kccnc-table">
								<tbody>
									<tr>
										<td>Cloud Native eBPF Day</td>
										<td>160</td>
									</tr>
									<tr>
										<td>Cloud Native SecurityCon</td>
										<td>333</td>
									</tr>
									<tr>
										<td>Cloud Native Telco Day</td>
										<td>88</td>
									</tr>
									<tr>
										<td>Cloud Native Wasm Day</td>
										<td>81</td>
									</tr>
									<tr>
										<td>FluentCon</td>
										<td>36</td>
									</tr>
									<tr>
										<td>GitOpsCon</td>
										<td>325</td>
									</tr>

								</tbody>
							</table>
						</div>
					</div>
					<div class="colocated__col2">
						<div class="kccnc-table-container">
							<table class="kccnc-table">
								<tbody>
									<tr>
										<td>KnativeCon</td>
										<td>84</td>
									</tr>
									<tr>
										<td>Kubernetes AI Day</td>
										<td>128</td>
									</tr>
									<tr>
										<td>Kubernetes Batch + HPC Day</td>
										<td>58</td>
									</tr>
									<tr>
										<td>Kubernetes on Edge Day</td>
										<td>135</td>
									</tr>
									<tr>
										<td>PrometheusDay</td>
										<td>149</td>
									</tr>
									<tr>
										<td>ServiceMeshCon</td>
										<td>144</td>
									</tr>

								</tbody>
							</table>
						</div>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-120"></div>
			</div>
		</section>

		<section class="section-10 alignfull background-image-wrapper">

			<figure class="background-image-figure">
				<?php LF_Utils::display_responsive_images( 73898, 'full', '1200px', '', 'lazy', 'Speaker at a colocated event' ); ?>
			</figure>

			<div class="background-image-text-overlay">
				<div class="container wrap">

					<div aria-hidden="true" class="report-spacer-120"></div>

					<div class="section-10__container">

						<h2 class="section-10__title">Interested in co-locating
							an
							event alongside KubeCon + CloudNativeCon North
							America
							2022?</h2>

						<div class="divider"></div>

						<p>Sponsor-hosted co-located event packages are solely available to level sponsors of KubeCon + CloudNativeCon North America 2022.</p>

						<div class="wp-block-button"><a
								href="https://events.linuxfoundation.org/kubecon-cloudnativecon-north-america/sponsor/"
								title="Sponsor KubeCon + CloudNativeCon North America 2022"
								class="wp-block-button__link">Co-Lo Events
								Packages</a>
						</div>
					</div>

					<div aria-hidden="true" class="custom-spacer"></div>

				</div>
			</div>
		</section>


		<section id="content"
			class="section-11 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">Content</h2>
					<div class="section-number">4/6</div>
				</div>

				<p class="opening-paragraph max-w-1000">
				We enjoyed 222 sessions in Valencia, from technical deep dives like <a href="https://kccnceu2022.sched.com/event/ytlM" title="Effective disaster recovery: The day we deleted production">Effective disaster recovery: The day we deleted production</a>, to thought provoking emotional topics like <a href="https://kccnceu2022.sched.com/event/ytmK" title="Been there, done that: Tales of burnout from the open source world">Been there, done that: Tales of burnout from the open source world</a>.</p>

				<div class="kccnc-table-container">
					<table class="kccnc-table">
						<thead>
							<tr>
								<th>Sessions</th>
								<th>Total</th>
								<th><span class="nowrap">In-person</span></th>
								<th>Virtual</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Keynotes (includes sponsored keynotes)</td>
								<td>17</td>
								<td>16</td>
								<td>1</td>
							</tr>
							<tr>
								<td>Total sessions (CFP & Maintainer)</td>
								<td>222</td>
								<td>189</td>
								<td>33</td>
							</tr>
							<tr>
								<td> - Breakouts</td>
								<td>146</td>
								<td>127</td>
								<td>19</td>
							</tr>
							<tr>
								<td> - Maintainer sessions</td>
								<td>76</td>
								<td>62</td>
								<td>14</td>
							</tr>
						</tbody>
					</table>
				</div>

				<p class="sub-header">Thank you to our Europe 2022 co-chairs</p>

				<div class="lf-grid chairs">
					<div class="chairs__col1">
						<?php LF_Utils::display_responsive_images( 73887, 'full', '200px', 'chairs__image', 'lazy', 'Jasmine James' ); ?>
						<p>
							<span class="chairs__name">Jasmine James
</span><span
								class="chairs__title">Twitter<br/>Senior Engineering
Manager</span>
						</p>
					</div>
					<div class="chairs__col2">
						<?php LF_Utils::display_responsive_images( 73886, 'full', '200px', 'chairs__image', 'lazy', 'Emily Fox' ); ?>
						<p>
							<span class="chairs__name">Emily Fox</span><span
							class="chairs__title">Apple <br/>
Security Engineer</span></p>
					</div>
					<div class="chairs__col3">
						<?php LF_Utils::display_responsive_images( 73888, 'full', '200px', 'chairs__image', 'lazy', 'Ricardo Rocha' ); ?>
						<p>
							<span class="chairs__name">Ricardo Rocha</span><span
							class="chairs__title"></span>CERN <br/>
Computing Engineer</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-120"></div>

			</div>
		</section>

		<section class="section-12 has-gray-background alignfull">

			<div class="container wrap">

				<div aria-hidden="true" class="report-spacer-120"></div>

				<div class="lf-grid breakdown">
					<div class="breakdown__col1">
						<h2 class="large-sub-header">Content Breakdown</h2>
					</div>
					<div class="breakdown__col2">
						<div class="breakdown__text">
							<p>The schedule was curated by conference co-chairs, Ricardo Rocha of CERN, Emily Fox of Apple, and Jasmine James of Twitter. The co-chairs selected 99 subject matter experts to form the program committee, and 36 experienced practitioners for the track chair selection committee, including project maintainers, active community members, and highly rated presenters from past events. </p>
							<p>Talks are selected by the program committee through a rigorous, non-bias process where they are randomly assigned submissions to review within their area of expertise. You can read the details in our <a href="https://events.linuxfoundation.org/kubecon-cloudnativecon-europe/program/scoring-guidelines/#general-info" title="CFP scoring guidelines">CFP scoring guidelines</a>. </p>
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
										src="<?php LF_Utils::get_svg( $report_folder . 'icon-inbox.svg', true ); ?>
							" alt="Inbox icon">
								</div>
								<div class="text">
									<span class="number">1,187</span><br />
									<span class="description">CFP
										Submissions</span>
								</div>
							</div>

							<!-- Icon Box 3  -->
							<div class="icon-box-3">
								<div class="icon">
									<img loading="lazy" width="37" height="51"
										src="<?php LF_Utils::get_svg( $report_folder . 'icon-mic.svg', true ); ?>
							" alt="Microphone icon">
								</div>
								<div class="text">
									<span class="number">243</span><br />
									<span class="description">Speakers</span>
								</div>
							</div>

							<!-- Icon Box 3  -->
							<div class="icon-box-3">
								<div class="icon">
									<img loading="lazy" width="36" height="48"
										src="<?php LF_Utils::get_svg( $report_folder . 'icon-person.svg', true ); ?>
							" alt="Person icon">
								</div>
								<div class="text">
									<span class="number">109</span><br />
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

		<section class="section-13">

			<div aria-hidden="true" class="report-spacer-120"></div>

			<h2 class="large-sub-header">Speaker <br />Diversity</h2>

			<div aria-hidden="true" class="report-spacer-40"></div>

			<p>CNCF enforces guidelines on gender and diversity equality among our speakers, including not accepting all-male panels.</p>

			<div aria-hidden="true" class="report-spacer-75"></div>

			<div class="kccnc-table-container">
				<table class="kccnc-table">
					<thead>
						<tr>
							<th>Diversity
							</th>
							<th>Overall</th>
							<th>Percent</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Speakers - women + gender non-conforming
								(keynotes)</td>
							<td>11</td>
							<td>48%</td>
						</tr>
						<tr>
							<td>Speakers - men (breakouts)</td>
							<td>171</td>
							<td>80%</td>
						</tr>
						<tr>
							<td>Speakers - women (breakouts)</td>
							<td>40</td>
							<td>19%</td>
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

			<div class="shadow-hr"></div>

			<h2 class="large-sub-header">The Next Generation</h2>

			<div aria-hidden="true" class="report-spacer-40"></div>

			<p
				class="opening-paragraph max-w-1000">More than <strong>2,400 people</strong> joined us for KubeCon + CloudNativeCon Europe thanks to the Dan Kohn Scholarship Fund, including diversity, need-based, and student scholarship recipients.</p>

			<div class="kccnc-table-container">
				<table class="kccnc-table">
					<thead>
						<tr>
							<th>Scholarships</th>
							<th>Total</th>
							<th class="nowrap">In-person</th>
							<th>Virtual</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Diversity scholarships</td>
							<td>354</td>
							<td>67</td>
							<td>287</td>
						</tr>
						<tr>
							<td>Need-based scholarships</td>
							<td>219</td>
							<td>13</td>
							<td>206</td>
						</tr>
						<tr>
							<td>Student scholarships</td>
							<td>1902</td>
							<td>N/A</td>
							<td>1902</td>
						</tr>

					</tbody>
				</table>
			</div>

			<div aria-hidden="true" class="report-spacer-75"></div>

			<div class="sub-header">Sponsored By</div>

			<div aria-hidden="true" class="report-spacer-75"></div>

			<div class="logo-grid">

				<div class="logo-grid__box">
					<img loading="lazy"
						src="<?php LF_Utils::get_svg( $report_folder . 'logo-cncf.svg', true ); ?>"
						alt="Logo for CNCF" class="logo-grid__image">
				</div>
				<div class="logo-grid__box">
					<img loading="lazy"
						src="<?php LF_Utils::get_svg( $report_folder . 'logo-form3.svg', true ); ?>"
						alt="Logo for Form3" class="logo-grid__image">
				</div>
				<div class="logo-grid__box">
					<img loading="lazy"
						src="<?php LF_Utils::get_svg( $report_folder . 'logo-golden-solutions.svg', true ); ?>"
						alt="Logo for Golden Solutions"
						class="logo-grid__image">
				</div>
				<div class="logo-grid__box">
					<img loading="lazy"
						src="<?php LF_Utils::get_svg( $report_folder . 'logo-grafana-labs.svg', true ); ?>"
						alt="Logo for Grafana Labs" class="logo-grid__image">
				</div>
				<div class="logo-grid__box">
					<img loading="lazy"
						src="<?php LF_Utils::get_svg( $report_folder . 'logo-section.svg', true ); ?>"
						alt="Logo for Section" class="logo-grid__image">
				</div>
				<div class="logo-grid__box">
					<img loading="lazy"
						src="<?php LF_Utils::get_svg( $report_folder . 'logo-vmware.svg', true ); ?>"
						alt="Logo for VMWare" class="logo-grid__image">
				</div>

			</div>

			<div class="shadow-hr"></div>

			<div class="scholarships">
				<?php LF_Utils::display_responsive_images( 73897, 'full', '800px', 'scholarships__image', 'lazy', 'People on Scholarships at KubeCon + CloudNativeCon Europe 2022' ); ?>

				<div class="scholarships__title-wrapper">
					<h2 class="scholarships__title">Check out our scholarship
						holders!</h2>
				</div>
				<div class="scholarships__text-wrapper">
					<h3 class="scholarships__text">Apply for a scholarship to
						join us at KubeCon + CloudNativeCon North America 2022
					</h3>
					<div class="wp-block-button"><a
							href="https://events.linuxfoundation.org/kubecon-cloudnativecon-north-america/attend/scholarships/"
							title="Apply for scholarship at KubeCon + CloudNativeCon North America 2022"
							class="wp-block-button__link has-black-background-color has-background">Apply</a>
					</div>
				</div>
			</div>

			<div aria-hidden="true" class="report-spacer-120"></div>

		</section>

		<section id="coverage"
			class="section-14 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">Media & Analyst <br
							class="show-over-1000">
						Coverage </h2>
					<div class="section-number">5/6</div>
				</div>

				<div class="quote-container">
					<p
						class="quote-container__quote">This is ground zero for the hottest area of the entire computing industry right now</p>
					<div class="quote-container__marks">
						<p class="quote-container__name">Paul Gillin</p>
						<p class="quote-container__position">Silicon Angle</p>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">Key Stats</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid media">
					<div class="media__col1">

						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" width="58" height="58" src="<?php LF_Utils::get_svg( $report_folder . 'icon-share-o.svg', true ); ?>
							" alt="Share icon">
							</div>
							<div class="text">
								<span class="number">250%</span><br />
								<span class="description">More media
									coverage</span>
								<span class="addendum">than Europe 2021 event
									(fully virtual)</span>
							</div>
						</div>

					</div>
					<div class="media__col2">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" width="64" height="64" src="<?php LF_Utils::get_svg( $report_folder . 'icon-bell-o.svg', true ); ?>
							" alt="Bell icon">
							</div>
							<div class="text">
								<span class="number">2,490</span><br />
								<span class="description">Mentions Of Kubecon
									+ Cloudnativecon</span>
								<span class="addendum">in media articles, press
									releases, and blogs</span>
							</div>
						</div>
					</div>
					<div class="media__col3">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" width="58" height="42" src="<?php LF_Utils::get_svg( $report_folder . 'icon-youtube-o.svg', true ); ?>
							" alt="YouTube icon">
							</div>
							<div class="text">
								<span class="number">159</span><br />
								<span class="description">Journalists &
									Analysts</span>
								<span class="addendum">attended virtually &
									in-person</span>
							</div>
						</div>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-120"></div>

			</div>
		</section>


		<section class="section-15 has-gray-background alignfull">

			<div class="container wrap">

				<div aria-hidden="true" class="report-spacer-120"></div>

				<h2 class="large-sub-header">What the media said</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid media-quotes">
					<div class="media-quotes__col1">

						<div class="quote-container">
							<p
								class="quote-container__quote">During the pandemic, Kubernetes provided the scaffolding for companies to become cloud-native, according to Priyanka Sharma, general manager of CNCF. Speaking at the KubeCon Europe 2022 conference in Valencia, she said: “I see cloud native becoming more relevant in the manufacture of cars, trains and aeroplanes.</p>
							<div class="quote-container__marks">
								<p class="quote-container__name">Cliff Saran</p>
								<p
									class="quote-container__position">ComputerWeekly</p>
							</div>
						</div>

					</div>
					<div class="media-quotes__col2">

						<div class="quote-container">
							<p
								class="quote-container__quote">The Cloud Native Computing Foundation's developer core was there in force, but so were users, executives and a large crowd of university students. Add the thousands more attending virtually, and the CNCF's goal of making cloud-native ubiquitous seems a lot more realistic than it did just a few years ago.</p>
							<div class="quote-container__marks">
								<p
									class="quote-container__name">Betsy Amy-Vogt</p>
								<p
									class="quote-container__position">SiliconANGLE</p>
							</div>
						</div>

					</div>

				</div>

				<div aria-hidden="true" class="report-spacer-120"></div>
			</div>
		</section>

		<section class="section-16">
			<div aria-hidden="true" class="report-spacer-120"></div>

			<p class="sub-header">Online Reach + Traffic</p>

			<div aria-hidden="true" class="report-spacer-60"></div>

			<div class="lf-grid reach">
				<div class="reach__col1">

					<div class="reach__holder">
						<span class="reach__number">14.6M</span>
					</div>
					<p class="reach__title">Twitter Impressions</p>

					<p class="reach__impressions"><span>35.4K </span>@CloudNativeFdn clicks<br />
					<span>376 </span>@CloudNativeFdn retweets<br />
					<span>6K </span>@CloudNativeFdn likes</p>
				</div>
				<div class="reach__col2">

					<div class="reach__holder">
						<span class="reach__number">

							<img loading="lazy" width="58" height="47"
								src="<?php LF_Utils::get_svg( $report_folder . 'icon-twitter.svg', true ); ?>"
								alt="YouTube icon">
						</span>
					</div>
					<p class="reach__title">Twitter Moments</p>

					<p>May 18 - <a href="https://twitter.com/i/events/1526963880869744650" title="Twitter Hightlights from Day One">Highlights from Day One</a><br/>
					May 19 - <a href="https://twitter.com/i/events/1527295881937989635" title="Twitter Hightlights from Day Two">Highlights from Day Two</a><br/>
					May 20 - <a href="https://twitter.com/i/events/1527652550983434240" title="Twitter Hightlights from Day Three">Highlights from Day Three</a></p>

				</div>
				<div class="reach__col3">

					<div class="reach__holder">
						<span class="reach__number">
							<img loading="lazy" width="59" height="42"
								src="<?php LF_Utils::get_svg( $report_folder . 'icon-youtube.svg', true ); ?>"
								alt="YouTube icon">
						</span>
					</div>
					<p class="reach__title">YouTube Playlist</p>

					<p>As of June 16, event session videos have garnered more than 17,000 views.</p>

					<p><a href="https://www.youtube.com/playlist?list=PLj6h78yzYM2MCEgkd8zH0vJWF7jdQ-GRR" title="View the YouTube Playlist">View the YouTube playlist</a>.</p>

				</div>

			</div>

			<div class="shadow-hr"></div>

			<h2 class="large-sub-header">Media Coverage</h2>

			<div aria-hidden="true" class="report-spacer-60"></div>

			<p
				class="opening-paragraph max-w-800">More than <a href="https://www.cncf.io/news/" title="See CNCF media coverage">2,490</a> articles published from KubeCon + CloudNativeCon Europe in leading outlets including:</p>

			<div class="logo-grid">

				<div class="logo-grid__box">
					<img loading="lazy"
						src="<?php LF_Utils::get_image( $report_folder . 'media-logo-business-insider.png' ); ?>"
						alt="Logo for Business Insider"
						class="logo-grid__image">
				</div>

				<div class="logo-grid__box">
					<img loading="lazy"
						src="<?php LF_Utils::get_image( $report_folder . 'media-logo-computerweekly.png' ); ?>"
						alt="Logo for Computer Weekly" class="logo-grid__image">
				</div>

				<div class="logo-grid__box">
					<img loading="lazy"
						src="<?php LF_Utils::get_image( $report_folder . 'media-logo-container-journal.png' ); ?>"
						alt="Logo for Container Journal"
						class="logo-grid__image">
				</div>

				<div class="logo-grid__box">
					<img loading="lazy"
						src="<?php LF_Utils::get_image( $report_folder . 'media-logo-forbes.jpg' ); ?>"
						alt="Logo for Forbes" class="logo-grid__image">
				</div>

				<div class="logo-grid__box">
					<img loading="lazy"
						src="<?php LF_Utils::get_image( $report_folder . 'media-logo-idg-news.png' ); ?>"
						alt="Logo for IDG News" class="logo-grid__image">
				</div>

				<div class="logo-grid__box">
					<img loading="lazy"
						src="<?php LF_Utils::get_svg( $report_folder . 'media-logo-infoq.svg', true ); ?>"
						alt="Logo for InfoQ" class="logo-grid__image">
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
						src="<?php LF_Utils::get_image( $report_folder . 'media-logo-protocol.png' ); ?>"
						alt="Logo for Protocol" class="logo-grid__image">
				</div>

				<div class="logo-grid__box">
					<img loading="lazy"
						src="<?php LF_Utils::get_svg( $report_folder . 'media-logo-sdx-central.svg', true ); ?>"
						alt="Logo for SDX Central" class="logo-grid__image">
				</div>

				<div class="logo-grid__box">
					<img loading="lazy"
						src="<?php LF_Utils::get_image( $report_folder . 'media-logo-silicon-angle.png' ); ?>"
						alt="Logo for Silicon Angle" class="logo-grid__image">
				</div>

				<div class="logo-grid__box">
					<img loading="lazy"
						src="<?php LF_Utils::get_image( $report_folder . 'media-logo-techcrunch.png' ); ?>"
						alt="Logo for TechCrunch" class="logo-grid__image">
				</div>

				<div class="logo-grid__box">
					<img loading="lazy"
						src="<?php LF_Utils::get_image( $report_folder . 'media-logo-techtarget.png' ); ?>"
						alt="Logo for Tech Target" class="logo-grid__image">
				</div>

				<div class="logo-grid__box">
					<img loading="lazy"
						src="<?php LF_Utils::get_image( $report_folder . 'media-logo-tfir.png' ); ?>"
						alt="Logo for TFIR" class="logo-grid__image">
				</div>

				<div class="logo-grid__box">
					<img loading="lazy"
						src="<?php LF_Utils::get_svg( $report_folder . 'media-logo-thenewstack.svg', true ); ?>"
						alt="Logo for The News Stack" class="logo-grid__image">
				</div>

				<div class="logo-grid__box">
					<img loading="lazy"
						src="<?php LF_Utils::get_image( $report_folder . 'media-logo-the-register.png' ); ?>"
						alt="Logo for The Register" class="logo-grid__image">
				</div>

				<div class="logo-grid__box">
					<img loading="lazy"
						src="<?php LF_Utils::get_image( $report_folder . 'media-logo-vmblog.png' ); ?>"
						alt="Logo for VM Blog" class="logo-grid__image">
				</div>

				<div class="logo-grid__box">
					<img loading="lazy"
						src="<?php LF_Utils::get_svg( $report_folder . 'media-logo-zdnet.svg', true ); ?>"
						alt="Logo for ZD Net" class="logo-grid__image">
				</div>
			</div>

			<div class="shadow-hr"></div>

			<h2 class="large-sub-header">Media Coverage <br />Highlights</h2>

			<div aria-hidden="true" class="report-spacer-60"></div>

			<div class="lf-grid coverage">
				<div class="coverage__col1">

					<?php LF_Utils::display_responsive_images( 73891, 'full', '300px', '', 'lazy', 'Example media coverage' ); ?>

				</div>
				<div class="coverage__col2">
					<p><a href="https://thenewstack.io/envoy-gateway-offers-to-standardize-kubernetes-ingress/">The New Stack</a> - Envoy Gateway Offers to Standardize Kubernetes Ingress</p>
					<p><a href="https://www.infoworld.com/article/3660637/cncf-launches-ethics-in-open-source-training-course.html">InfoWorld</a> - CNCF launches ethics in open source training course</p>
					<p><a href="https://techcrunch.com/2022/05/18/cncf-launches-a-new-program-to-help-telcos-adopt-kubernetes/">TechCrunch</a> - The Envoy Gateway project wants to bring Envoy to the masses</p>
					<p><a href="https://containerjournal.com/kubecon-cnc-eu-2022/cncf-launches-cloud-native-network-function-certification-program/">Container Journal</a> - CNCF Launches Cloud Native Network Function Certification Program</p>
					<p><a href="https://containerjournal.com/kubecon-cnc-eu-2022/prometheus-associate-certification-will-demonstrate-ability-to-monitor-infrastructure/">Container Journal</a> - Prometheus Associate Certification will Demonstrate Ability to Monitor Infrastructure</p>
					<p><a href="https://containerjournal.com/kubecon-cnc-eu-2022/replicated-accelerates-adoption-of-kubernetes-based-applications/">Container Journal</a> - Boeing Joins Cloud Native Computing Foundation as a Platinum Member</p>
					<p><a href="https://devclass.com/2022/05/18/cloud-native-developers-grow-proportion-knowingly-using-kubernetes-slides-report/">DevClass</a> - Cloud-native developers grow, proportion knowingly using Kubernetes slides-report</p>
					<p><a href="https://redmonk.com/kholterhoff/2022/05/18/notes-from-kubecon-cloudnativecon-europe-2022/">Redmonk</a> - Notes from KubeCon + CloudNativeCon Europe 2022</p>
					<p><a href="https://www.computerweekly.com/news/252518356/Adoption-of-cloud-native-architectures-on-the-rise">ComputerWeekly</a> - Adoption of cloud-native architectures on the rise</p>
					<p><a href="https://www.lemondeinformatique.fr/actualites/lire-kubecon-2022%C2%A0-la-cncf-installe-kubernetes-dans-les-telecoms-86848.html">LeMondeInformatique</a> - KubeCon 2022 : La CNCF installe Kubernetes dans les télécoms</p>
					<p><a href="https://rcrwireless.com/20220519/telco-cloud/simplifying-kubernetes-for-telcos-and-cloud-app-developers">RCRWireless</a> - CNCF makes inroads on efforts at KubeCon + CloudNativeCon Europe 2022</p>
					<p><a href="https://www.computing.co.uk/analysis/4049933/telcos-profitability-tackle">Computing</a> - Telcos' profitability problems - and how they might tackle them</p>

					<!-- https://www.lemagit.fr/actualites/252518363/KubeCON-Kubernetes-part-a-la-conquete-des-telecoms
https://siliconangle.com/2022/05/20/cncf-developer-ecosystem-expands-amid-cloud-native-adoption-kubecon/
https://www.techtarget.com/searchitoperations/news/252518485/Cisco-CNCF-leader-urges-corporate-open-source-contributions -->

				</div>
			</div>

			<div aria-hidden="true" class="report-spacer-120"></div>

		</section>

		<section id="covid" class="section-17 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">COVID-19 Health + Safety <br
							class="show-over-1000" />OnSite Overview</h2>
					<div class="section-number">6/6</div>
				</div>

				<p class="opening-paragraph max-w-900">
				We care deeply about our community. This is why we want to be honest and open about our COVID-19 policies at KubeCon + CloudNativeCon Europe, the measures that were put in place, and how these may have affected the attendee experience.</p>

				<p
					class="sub-header max-w-550">Kubecon + CloudNativeCon implemented the following safety precautions:</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid precautions">
					<div class="precautions__col1">

						<div class="icon-box-4">
							<div class="icon">
								<img width="100" height="100"
									src="<?php LF_Utils::get_svg( $report_folder . 'covid-vaccine.svg', true ); ?>"
									alt="Covid Vaccine icon" loading="lazy">
							</div>
							<div class="text">
								<span>Vaccinations required for in-person
									attendees</span>
							</div>
						</div>

						<div class="icon-box-4">
							<div class="icon">
								<img width="100" height="100"
									src="<?php LF_Utils::get_svg( $report_folder . 'covid-temps.svg', true ); ?>"
									alt="Covid Temperature icon" loading="lazy">
							</div>
							<div class="text">
								<span>Daily temperature & symptom check</span>
							</div>
						</div>

					</div>
					<div class="precautions__col2">

						<div class="icon-box-4">
							<div class="icon">
								<img width="100" height="100"
									src="<?php LF_Utils::get_svg( $report_folder . 'covid-test.svg', true ); ?>"
									alt="Covid tests icon" loading="lazy">
							</div>
							<div class="text">
								<span>Complimentary onsite COVID testing via
									EventScan</span>
							</div>
						</div>

						<div class="icon-box-4">
							<div class="icon">
								<img width="100" height="100"
									src="<?php LF_Utils::get_svg( $report_folder . 'covid-mask.svg', true ); ?>"
									alt="Covid mask icon" loading="lazy">
							</div>
							<div class="text">
								<span>Masks mandatory indoors </span>
							</div>
						</div>

					</div>
					<div class="precautions__col3">

						<div class="icon-box-4">
							<div class="icon">
								<img width="100" height="100"
									src="<?php LF_Utils::get_svg( $report_folder . 'covid-band.svg', true ); ?>"
									alt="Covid indicator icon" loading="lazy">
							</div>
							<div class="text">
								<span>Wearable indicators denoting social
									distance comfort levels</span>
							</div>
						</div>

					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">COVID Numbers</p>

				<p>Over the two weeks immediately after KubeCon + CloudNativeCon (20 May - 3 June), we were made aware of:</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid covid">
					<div class="covid__col1">
						<span class="covid__large">121</span>
						<span class="covid__text">Positive Tests from in-person
							attendees</span>
					</div>
					<div class="covid__col2">
						<span class="covid__large">1.7%</span>
						<span class="covid__text">Of In-Person Attendees Tested
							Positive Overall</span>
					</div>
					<div class="covid__col3">
						<span class="covid__large">0</span>
						<span class="covid__text">Serious Cases
							Reported</span>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<p>This information was compiled from:</p>

				<ul class="covid__table">
					<li>Those who contacted us to let us know of a positive test
					</li>
					<li>Records from our onsite testing company</li>
					<li>Reviewing #KubeCovid on Twitter</li>
					<li>Scanning Twitter for additional publicized cases </li>
				</ul>

				<div class="shadow-hr"></div>

				<p class="sub-header">Mask Mandate</p>

				<p
					class="max-w-900">As many are aware we ran into some issues onsite related to COVID-19 and the mask mandate, one of which was a general local staffing issue which is being felt on a global scale. This was reflected in a reduced number of taxis available, in the number of vendor staff working catering, and in many other places around the city and the event. This was exacerbated by a Spanish law that no Spanish employer could require an employee to wear a mask.</p>
				<p
					class="max-w-900">When Spain dropped its mask mandate on April 7 and put this law into effect (which we discovered would affect large groups on April 20) it resulted in a further reduction in local staffing for the event. Our vendors were only able to secure folx who would voluntarily wear a mask. This resulted in even lower staffing levels onsite which we know affected the attendee experience. With all of this taking place in the several weeks prior to the event, it was difficult to produce the event as our community expects. </p>
				<p
					class="max-w-900">Vendors were not the only challenge. A greater number of attendees were reluctant to comply with the mask mandate than we saw at our North America event last November. Events staff did their best to maintain enforcement, despite reduced staff, changing laws, and general mask fatigue.</p>
				<p
					class="max-w-900">We appreciate your support and partnership in this journey and hope to be in a more stable stage of pandemic management for upcoming events with a return to the standards we are all used to.</p>

				<div class="shadow-hr"></div>

				<p class="sub-header">Incident Transparency Report</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid incident">
					<div class="incident__col1">
						<span class="incident__large">1</span>
						<span class="incident__text">Code of Conduct report
							received on-site</span>
					</div>
					<div class="incident__col2">
						<span class="incident__large">2</span>
						<span class="incident__text">Code of Conduct reports
							received post-event</span>
					</div>
					<div class="incident__col3">
						<span class="incident__large">3</span>
						<span class="incident__text">1 attendee and 2 staff
							taken to urgent care during the event (this was not
							COVID-19 related and everyone is ok!)
							Reported</span>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-120"></div>
			</div>
		</section>

		<section class="section-18 is-style-down-gradient alignfull">

			<div class="container wrap">

				<figure class="floating-flowers floating-flowers-03">
					<img width="708" height="821" loading="lazy" src="
					<?php
					Lf_Utils::get_image( $report_folder . 'motif.png' );
					?>
					" alt="Background flower">
				</figure>

				<div class="section-title-wrapper">
					<h2 class="section-header">Sponsor <br />Information</h2>
				</div>

				<p
					class="opening-paragraph max-w-1000">A huge thank you to the sponsors, partners and supporters of KubeCon + CloudNativeCon Europe 2022. We couldn't do it without your support and collaboration.</p>

				<div class="kccnc-table-container">
					<table class="kccnc-table">
						<thead>
							<tr>
								<th>Booth Traffic</th>
								<th>Total</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Onsite leads total</td>
								<td>63,057</td>
							</tr>
							<tr>
								<td>Onsite leads average/booth</td>
								<td>367</td>
							</tr>
							<tr>
								<td>Virtual leads total</td>
								<td>45,897</td>
							</tr>
							<tr>
								<td>Virtual leads average/booth</td>
								<td>294</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div aria-hidden="true" class="report-spacer-120"></div>

				<div class="kccnc-table-container">
					<table class="kccnc-table yoy-table">
						<thead>
							<tr>
								<th>YOY SPONSORSHIP
								</th>
								<th>2017
									<span>Berlin</span>
								</th>
								<th>2018
									<span>Copenhagen</span>
								</th>
								<th>2019
									<span>Barcelona</span>
								</th>
								<th>2020
									<span>Virtual</span>
								</th>
								<th>2021
									<span>Virtual</span>
								</th>
								<th>2022
									<span>Valencia</span>
								</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Diamond</td>
								<td>5</td>
								<td>6*</td>
								<td>6*</td>
								<td>6*</td>
								<td>6*</td>
								<td>6*</td>
							</tr>
							<tr>
								<td>Platinum</td>
								<td>4</td>
								<td>7</td>
								<td>15</td>
								<td>7</td>
								<td>8</td>
								<td>17</td>
							</tr>
							<tr>
								<td>Gold</td>
								<td>7</td>
								<td>7</td>
								<td>14</td>
								<td>8</td>
								<td>12</td>
								<td>18</td>
							</tr>
							<tr>
								<td>Silver</td>
								<td>15</td>
								<td>51</td>
								<td>55</td>
								<td>35</td>
								<td>46</td>
								<td>95</td>
							</tr>
							<tr>
								<td class="nowrap">Start-up</td>
								<td>13</td>
								<td>25</td>
								<td>53</td>
								<td>26</td>
								<td>28</td>
								<td>49</td>
							</tr>
							<tr>
								<td class="nowrap">End User</td>
								<td>N/A</td>
								<td>N/A</td>
								<td>3</td>
								<td>3</td>
								<td>2</td>
								<td>2</td>
							</tr>
							<tr>
								<td>Marketing Opportunities</td>
								<td>8</td>
								<td>19</td>
								<td>27</td>
								<td>17</td>
								<td>25</td>
								<td>44</td>
							</tr>
							<tr>
								<td>Total Unique</td>
								<td>47</td>
								<td>96</td>
								<td>146</td>
								<td>87</td>
								<td>102</td>
								<td>189</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div aria-hidden="true" class="report-spacer-20"></div>

				<span>* Capped Maximum</span>

				<div class="shadow-hr"></div>

				<p class="sub-header is-centered">Diamond Sponsors</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="sponsors-logos largest even orphan-by-5">
					<div class="sponsors-logo-item"><a
							href="https://eti.cisco.com?eid=108103&amp;ccid=cc002838"><img
								width="400" height="245"
								src="<?php LF_Utils::get_svg( $report_folder . 'logo-cisco.svg', true ); ?>"
								class="logo" alt="Cisco logo"
								loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://www.huawei.com/"><img width="241"
								height="245"
								src="<?php LF_Utils::get_svg( $report_folder . 'logo-huawei.svg', true ); ?>"
								class="logo" alt="Huawei Logo"
								loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="http://www.intel.com/"><img width="338"
								height="139"
								src="<?php LF_Utils::get_svg( $report_folder . 'logo-intel.svg', true ); ?>"
								class="logo" alt="Intel Logo"
								loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://www.kasten.io/kubernetes-product-of-the-year"><img
								src="<?php LF_Utils::get_svg( $report_folder . 'logo-kasten.svg', true ); ?>"
								class="logo" alt="Kasten Logo"
								loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://www.redhat.com/"><img width="400"
								height="245"
								src="<?php LF_Utils::get_svg( $report_folder . 'logo-redhat.svg', true ); ?>"
								class="logo" alt="Redhat Logo"
								loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://www.vmware.com"><img width="400"
								height="245"
								src="<?php LF_Utils::get_svg( $report_folder . 'logo-vmware.svg', true ); ?>"
								class="logo" alt="VMWare Logo"
								loading="lazy"></a></div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header is-centered">Platinum Sponsors</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="sponsors-logos larger odd orphan-by-4 orphan-by-8">
					<div class="sponsors-logo-item"><a
							href="https://www.aquasec.com/"><img width="406"
								height="129"
								src="<?php LF_Utils::get_svg( $report_folder . 'logo-aqua.svg', true ); ?>"
								class="logo" alt="Aqua Logo" loading="lazy"></a>
					</div>
					<div class="sponsors-logo-item"><a
							href="https://aws.amazon.com/"><img width="400"
								height="245"
								src="<?php LF_Utils::get_svg( $report_folder . 'logo-aws.svg', true ); ?>"
								class="logo" alt="AWS Logo" loading="lazy"></a>
					</div>
					<div class="sponsors-logo-item"><a
							href="https://circleci.com/"><img width="290"
								height="242"
								src="<?php LF_Utils::get_svg( $report_folder . 'logo-circleci.svg', true ); ?>"
								class="logo" alt="Circle CI Logo"
								loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://www.cockroachlabs.com/"><img
								width="400" height="245"
								src="<?php LF_Utils::get_svg( $report_folder . 'logo-cockroach-labs.svg', true ); ?>"
								class="logo" alt="Cockroach Labs Logo"
								loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://www.datadoghq.com/"><img width="400"
								height="245"
								src="<?php LF_Utils::get_svg( $report_folder . 'logo-datadog.svg', true ); ?>"
								class="logo" alt="Datadog Logo"
								loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://about.gitlab.com/"><img
								src="<?php LF_Utils::get_svg( $report_folder . 'logo-gitlab.svg', true ); ?>"
								class="logo" alt="GitLab Logo"
								loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://cloud.google.com/"><img
								src="<?php LF_Utils::get_svg( $report_folder . 'logo-google-cloud.svg', true ); ?>"
								class="logo" alt="Google Cloud Logo"
								loading="lazy"></a>
					</div>
					<div class="sponsors-logo-item"><a
							href="https://azure.microsoft.com/en-us/overview/kubernetes-on-azure/"><img
								width="400" height="245"
								src="<?php LF_Utils::get_svg( $report_folder . 'logo-microsoft-azure.svg', true ); ?>"
								class="logo" alt="Microsoft Azure Logo"
								loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://www.oracle.com"><img width="412"
								height="67"
								src="<?php LF_Utils::get_svg( $report_folder . 'logo-oracle.svg', true ); ?>"
								class="logo" alt="Oracle Logo"
								loading="lazy"></a>
					</div>
					<div class="sponsors-logo-item"><a
							href="https://portworx.com/"><img width="406"
								height="158"
								src="<?php LF_Utils::get_svg( $report_folder . 'logo-portworx.svg', true ); ?>"
								class="logo" alt="Portworx Logo"
								loading="lazy"></a>
					</div>
					<div class="sponsors-logo-item"><a
							href="https://www.paloaltonetworks.com/prisma/cloud"><img
								src="<?php LF_Utils::get_svg( $report_folder . 'logo-prisma-cloud.svg', true ); ?>"
								class="logo" alt="Prisma Cloud Logo"
								loading="lazy"></a>
					</div>
					<div class="sponsors-logo-item"><a
							href="https://www.suse.com/products/suse-rancher/"><img
								src="<?php LF_Utils::get_svg( $report_folder . 'logo-rancher.svg', true ); ?>"
								class="logo" alt="SUSE Rancher Logo"
								loading="lazy"></a>
					</div>
					<div class="sponsors-logo-item"><a
							href="https://snyk.io/"><img width="400"
								height="245"
								src="<?php LF_Utils::get_svg( $report_folder . 'logo-snyk.svg', true ); ?>"
								class="logo" alt="Snyk Logo" loading="lazy"></a>
					</div>
					<div class="sponsors-logo-item"><a
							href="https://sysdig.com/"><img width="400"
								height="245"
								src="<?php LF_Utils::get_svg( $report_folder . 'logo-sysdig.svg', true ); ?>"
								class="logo" alt="Sysdig Logo"
								loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://goteleport.com/"><img
								src="<?php LF_Utils::get_svg( $report_folder . 'logo-teleport.svg', true ); ?>"
								class="logo" alt="Teleport Logo"
								loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://www.trilio.io/"><img width="396"
								height="114"
								src="<?php LF_Utils::get_svg( $report_folder . 'logo-trilio.svg', true ); ?>"
								class="logo" alt="Trilio Logo"
								loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://ubuntu.com/"><img
								src="<?php LF_Utils::get_svg( $report_folder . 'logo-canonical-ubuntu.svg', true ); ?>"
								class="logo" alt="Canonical  Ubuntu Logo"
								loading="lazy"></a>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<div class="wp-block-button"><a
						href="https://events.linuxfoundation.org/kubecon-cloudnativecon-europe/"
						title="See all Sponsors and Partners of KubeCon + CloudNativeCon Europe 2022"
						class="wp-block-button__link">See
						all Sponsors and Partners</a>
				</div>

				<div class="shadow-hr"></div>

				<div class="video">
					<h2 class="video__title">Video Highlights</h2>

					<div aria-hidden="true" class="report-spacer-60"></div>

					<div class="wp-block-lf-youtube-lite">
						<lite-youtube videoid="XqEflGXlErA" webpStatus="0"
							sdthumbStatus="1">
						</lite-youtube>
					</div>


				</div>

				<div aria-hidden="true" class="report-spacer-120"></div>

			</div>
		</section>

		<section class="section-19 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="lf-grid thanks">
					<div class="thanks__col1">
						<h2 class="large-sub-header">Thank You</h2>
						<div aria-hidden="true" class="report-spacer-60"></div>
						<p
							class="thanks__opening">We hope you enjoyed reflecting on a great event  in Valencia - let's do it again in Detroit!</p>
						<p
							class="thanks__comments">Your comments and feedback are welcome at <a href="mailto:events@cncf.io">events@cncf.io</a></p>
					</div>
					<div class="thanks__col2">
						<a href="<?php echo esc_url( $pdf_link ); ?>">
							<?php LF_Utils::display_responsive_images( 73895, 'full', '380px', '', 'lazy', 'Transparency Report for KubeCon + CloudNativeCon Europe 2022' ); ?>
						</a>
					</div>
					<div class="thanks__col3">

						<div class="wp-block-button"><a
								href="<?php echo esc_url( $pdf_link ); ?>"
								class="wp-block-button__link">Download Full
								Report</a>
						</div>

					</div>
					<div class="thanks__col4">
						<p>Check out our <a href="<?php echo esc_url( $event_link ); ?>">calendar for community events</a> near you and don't forget to <a href="<?php echo esc_url( $event_link ); ?>">register</a> for KubeCon+CloudNativeCon North America in Detroit, October 2022.</p>

					</div>
				</div>

				<div class="shadow-hr"></div>

				<a href="<?php echo esc_url( $event_link ); ?>"
					title="<?php echo esc_html( $event_text ); ?>">

					<?php LF_Utils::display_responsive_images( 73894, 'full', '414px', 'show-upto-500', 'lazy', esc_html( $event_text ) ); ?>


					<?php LF_Utils::display_responsive_images( 73893, 'full', '1200px', 'show-over-500', 'lazy', esc_html( $event_text ) ); ?>

				</a>

				<div class="shadow-hr"></div>

				<div class="social-share">
					<p class="social-share__title">Share report</p>

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

// custom scripts.
wp_enqueue_script(
	'kccnc-eu-22-report',
	get_template_directory_uri() . '/source/js/on-demand/kccnc-eu-22-report.js',
	array( 'jquery' ),
	filemtime( get_template_directory() . '/source/js/on-demand/kccnc-eu-22-report.js' ),
	true
);

get_template_part( 'components/footer' );
