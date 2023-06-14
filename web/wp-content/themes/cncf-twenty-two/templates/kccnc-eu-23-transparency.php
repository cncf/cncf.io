<?php
/**
 * Template Name: KCCNC EU 23 Transparency
 * Template Post Type: lf_report
 *
 * File for the KCCNC EU 2023 Transparency Report
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

wp_enqueue_style( 'wp-block-column' );
wp_enqueue_style( 'wp-block-columns' );
wp_enqueue_style( 'wp-block-group' );

get_template_part( 'components/header' );

get_template_part( 'components/skip-link-target' );

// Report folder in images/ folder.
$report_folder = 'reports/kccnc-eu-23/'

?>

<link rel="prefetch"
	href="<?php echo esc_url( get_template_directory_uri() . '/build/kccnc-eu-23-transparency.min.css' ); ?>"
	as="style" crossorigin="anonymous" />

<?php wp_enqueue_style( 'kccnc-eu-23', get_template_directory_uri() . '/build/kccnc-eu-23-transparency.min.css', array(), filemtime( get_template_directory() . '/build/kccnc-eu-23-transparency.min.css' ), 'all' ); ?>

<main class="kccnc-eu-23">
	<article class="container wrap">

		<section class="hero alignfull">
			<div class="container wrap hero__wrap">
				<div class="hero__text-overlay">
					<div class="container hero__container">
						<div class="hero__wrapper">
							<img class="hero__logo"
								src="<?php LF_Utils::get_svg( $report_folder . 'logo-kccnc-eu-23.svg', true ); ?>"
								width="295" height="128"
								alt="KubeCon + CloudNativeCon Europe 2023 Logo"
								loading="eager">
							<h1 class="hero__title uppercase">Transparency
								<br />Report
							</h1>

							<div class="hero__hr"></div>

							<div class="hero__button-share-align">

								<?php
								get_template_part( 'components/social-share' );
								?>
							</div>

							<div class="hero__jump">Jump to section:</div>
						</div>
					</div>
				</div>
				<figure class="hero__bg-shape">
					<?php LF_Utils::display_responsive_images( 90407, 'full', '1000px', null, 'lazy', 'Hero' ); ?>
				</figure>
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
<?php LF_Utils::get_svg( $report_folder . 'nav-icon-graph-up.svg', true ); ?>
" alt="Bar chart icon">Attendee Overview
				</div>

				<div class="nav-el__box">
					<a href="#content" title="Jump to Content section"
						class="box-link"></a>
					<img loading="lazy" width="36" height="36" src="
<?php LF_Utils::get_svg( $report_folder . 'nav-icon-movie.svg', true ); ?>
" alt="Movie icon">Content
				</div>

				<div class="nav-el__box">
					<a href="#colocated" title="Jump to Co-located Events"
						class="box-link"></a>
					<img loading="lazy" width="36" height="36" src="
<?php LF_Utils::get_svg( $report_folder . 'nav-icon-location.svg', true ); ?>
" alt="Map pin icon">Co-located Events
				</div>

				<div class="nav-el__box">
					<a href="#security" title="Jump to Security section"
						class="box-link"></a>
					<img loading="lazy" width="36" height="36" src="
<?php LF_Utils::get_svg( $report_folder . 'nav-icon-lock.svg', true ); ?>
" alt="Lock icon">
					Security
				</div>

				<div class="nav-el__box">
					<a href="#sustainability"
						title="Jump to Sustainability section"
						class="box-link"></a>
					<img loading="lazy" width="36" height="36" src="
<?php LF_Utils::get_svg( $report_folder . 'nav-icon-leaf.svg', true ); ?>
" alt="Leaf icon">
					Sustainability
				</div>

				<div class="nav-el__box">
					<a href="#media" title="Jump to Media Coverage section"
						class="box-link"></a>
					<img loading="lazy" width="36" height="36"
						src="<?php LF_Utils::get_svg( $report_folder . 'nav-icon-megaphone.svg', true ); ?>"
						alt="Megaphone icon">
					Media Coverage
				</div>
			</div>
		</section>

		<!-- Intro  -->
		<section class="section-01">

			<div class="lf-grid">
				<h2 class="section-01__title">What an amazing week in Amsterdam!
				</h2>
			</div>

			<div class="lf-grid section-01__grid">
				<div class="section-01__grid-col1">
					<p><strong>This KubeCon + CloudNativeCon was one for the books, with more than 10,500 of you joining us in-person and almost 6,000 virtually - making it Europe's largest vendor-neutral, open source conference. DataCenter-Insider reporter Ulrike Ostler wrote that "<a href="https://www.datacenter-insider.de/neue-aufgaben-fuer-die-cncf-community-a-09b9e28ca42f08cb2414a304c4e91a5e/">Cloud Native's popularity continues unabated</a>," and #TeamCloudNative agrees - you rated this event 4 out of 5!</strong></p>

					<p>Numbers aside, in-person events are so important for our community and the cloud native ecosystem. The real-time interactions that KubeCon + CloudNativeCon engenders sparks the collaboration that consistently uplevel our projects and continues to change the way we build and deliver software. In fact, attendees said the top two reasons they joined us in Amsterdam were networking and breakout sessions. Everybody benefits when we provide a welcoming space for vendor-neutral engagement, and we will continue to do this throughout the year at events, from <a href="https://www.lfasiallc.com/kubecon-cloudnativecon-open-source-summit-china/">KubeCon + CloudNativeCon China</a> and <a href="https://events.linuxfoundation.org/kubecon-cloudnativecon-north-america-2023/">North America</a>, to the hugely popular <a href="https://community.cncf.io/events/#/list">Kubernetes Community Days</a> and regional <a href="https://events.linuxfoundation.org/kubeday-israel/">KubeDays</a>.</p>

					<p>It wouldn't be KubeCon + CloudNativeCon without firsts - and we had many in Amsterdam including the addition of the new Startup track, which demonstrated how to build a business based on cloud native technologies. We also hosted the Security Village, alongside TAG Security, to bolster collaboration on the ecosystem's security posture.</p>

					<p>While I was disappointed to miss out on the in-person action, it was an honor to share my personal evolution with you. As I begin my maternity leave, I am warmed by your kind words of support and congratulations. I'm looking forward to seeing the community together again soon in Shanghai and Chicago, and I hope that I might be able to introduce my little one to their first KubeCon + CloudNativeCon.</p>

					<p>There is much to unpack from this phenomenal event and I've really enjoyed looking back as we put this transparency report together for you. I hope you find this information valuable.</p>

					<div class="author">
						<?php LF_Utils::display_responsive_images( 90396, 'full', '75px', '', 'lazy', 'Priyanka Sharma' ); ?>
						<p><strong>Priyanka Sharma</strong><br>
Executive Director, CNCF</p>
					</div>
				</div>

				<div class="section-01__grid-col2">

					<!-- Icon 1  -->
					<div class="icon-box-1">
						<div class="icon">
							<img loading="lazy" width="52" height="52" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-badge-p.svg', true ); ?>
" alt="Badge icon">
						</div>
						<div class="text">
							<span>51%</span><br />
							First-time attendees
						</div>
					</div>

					<!-- Icon 2  -->
					<div class="icon-box-1">
						<div class="icon">
							<img loading="lazy" width="45" height="40" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-heart-p.svg', true ); ?>
" alt="Heart icon">
						</div>
						<div class="text">
							<span>1,767</span><br />
							CFPs Submitted
						</div>
					</div>

					<!-- Icon 3  -->
					<div class="icon-box-1">
						<div class="icon">
							<img loading="lazy" width="45" height="33" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-megaphone-p.svg', true ); ?>
" alt="Megaphone icon">
						</div>
						<div class="text">
							<span>4,202</span><br />
							Pieces of media coverage
						</div>
					</div>

					<!-- Icon 4  -->
					<div class="icon-box-1">
						<div class="icon">
							<img loading="lazy" width="34" height="45" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-person-p.svg', true ); ?>
" alt="People icon">
						</div>
						<div class="text">
							<span>1,622</span><br />
							Attendees thanks to <br class="show-over-1000">Dan
							Kohn Scholarship Fund
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
						<h3 class="sub-header">Amsterdam Photo Highlights</h3>
					</div>
					<div class="wp-block-column is-vertically-aligned-bottom"
						style="flex-basis:20%">
						<p
							class="has-text-align-right is-style-link-cta"><a href="https://www.flickr.com/photos/143247548@N03/albums/72177720307596641" title="KubeCon + CloudNativeCon Europe 2023 Photo Gallery">See more</a></p>
					</div>
				</div>

				<div class="section-02__slider">
					<div>
						<?php LF_Utils::display_responsive_images( 90399, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 90380, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 90381, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 90382, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 90383, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 90384, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 90385, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 90386, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 90387, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 90388, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 90389, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 90390, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 90391, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 90392, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 90393, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 90394, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 90400, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 90402, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 90403, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 90404, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2023' ); ?>
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
						<span class="screen-reader-text">Previous Photo</span>
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
					<div class="section-number">1/8</div>
				</div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p
							class="opening-paragraph">We enjoyed the largest in-person European KubeCon + CouldNativeCon to-date, with more than 10,500 joining us in Amsterdam - a <strong>48%</strong> increase in in-person attendees from our 2022 European event.</p>
					</div>
				</div>

				<p class="sub-header">Demographics</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<picture>
					<source media="(max-width: 499px)"
						srcset="<?php echo esc_url( wp_get_attachment_image_url( 90409, 'full', false ) ); ?>">
					<source media="(min-width: 500px)"
						srcset="<?php echo esc_url( wp_get_attachment_image_url( 90408, 'full', false ) ); ?>">
					<?php
					LF_Utils::display_responsive_images(
						90408,
						'full',
						'1200px',
						'svg-image',
						'lazy',
						'16,092 total registered attendees'
					);
					?>
				</picture>

				<div aria-hidden="true" class="report-spacer-120"></div>

				<p class="sub-header">Attendee Geography</p>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<picture style="margin: auto;">
					<source media="(max-width: 499px)"
						srcset="<?php echo esc_url( wp_get_attachment_image_url( 90444, 'full', false ) ); ?>">
					<source media="(min-width: 500px)"
						srcset="<?php echo esc_url( wp_get_attachment_image_url( 90443, 'full', false ) ); ?>">
					<?php
					LF_Utils::display_responsive_images(
						90443,
						'full',
						'1200px',
						'svg-image section-03__map',
						'lazy',
						'Map of attendee geography'
					);
					?>
				</picture>

				<div class="section-03__no-answer">
					<strong>2%</strong> of in-person attendees did not answer
				</div>
				<div class="section-03__attendees">
					<div class="legend__wrapper"><i
							class="legend__key legend__purple-700"></i>
						In-Person %
					</div>

					<div class="legend__wrapper"><i
							class="legend__key legend__pink-200"></i> Virtual %
					</div>

				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">Top Countries in attendance</p>

				<div class="lf-grid section-03__top-countries">
					<div class="section-03__top-countries-col1">
						<p class="table-header">Total</p>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon">
								<img loading="lazy" width="52" height="52" src="<?php LF_Utils::get_svg( $report_folder . 'flag-germany.svg', true ); ?>
" alt="German Flag">
							</div>
							<div class="text">
								<span class="country">German</span><br />
								<span class="number">2,874</span>
							</div>
						</div>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon">
								<img loading="lazy" width="52" height="52" src="<?php LF_Utils::get_svg( $report_folder . 'flag-usa.svg', true ); ?>
" alt="USA Flag">
							</div>
							<div class="text">
								<span class="country">USA</span><br />
								<span class="number">1,955</span>
							</div>
						</div>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon">
								<img loading="lazy" width="52" height="52" src="<?php LF_Utils::get_svg( $report_folder . 'flag-netherlands.svg', true ); ?>
" alt="Netherlands Flag">
							</div>
							<div class="text">
								<span class="country">Netherlands</span><br />
								<span class="number">1,673</span>
							</div>
						</div>

					</div>
					<div class="section-03__top-countries-col2">
						<p class="table-header">In-person</p>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon">
								<img loading="lazy" width="52" height="52" src="<?php LF_Utils::get_svg( $report_folder . 'flag-germany.svg', true ); ?>
" alt="German Flag">
							</div>
							<div class="text">
								<span class="country">Germany</span><br />
								<span class="number">2,008</span>
							</div>
						</div>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon">
								<img loading="lazy" width="52" height="52" src="<?php LF_Utils::get_svg( $report_folder . 'flag-netherlands.svg', true ); ?>
" alt="Netherlands Flag">
							</div>
							<div class="text">
								<span class="country">Netherlands</span><br />
								<span class="number">1,378&nbsp;</span>
							</div>
						</div>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon">
								<img loading="lazy" width="52" height="52" src="<?php LF_Utils::get_svg( $report_folder . 'flag-usa.svg', true ); ?>
" alt="USA Flag">
							</div>
							<div class="text">
								<span class="country">USA</span><br />
								<span class="number">1,377&nbsp;</span>
							</div>
						</div>

					</div>
					<div class="section-03__top-countries-col3">
						<p class="table-header">Virtual</p>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon">
								<img loading="lazy" width="52" height="52" src="<?php LF_Utils::get_svg( $report_folder . 'flag-india.svg', true ); ?>
" alt="India Flag">
							</div>
							<div class="text">
								<span class="country">India</span><br />
								<span class="number">925</span>
							</div>
						</div>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon">
								<img loading="lazy" width="52" height="52" src="<?php LF_Utils::get_svg( $report_folder . 'flag-germany.svg', true ); ?>
" alt="German Flag">
							</div>
							<div class="text">
								<span class="country">Germany</span><br />
								<span class="number">866</span>
							</div>
						</div>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon">
								<img loading="lazy" width="52" height="52" src="<?php LF_Utils::get_svg( $report_folder . 'flag-usa.svg', true ); ?>
" alt="USA Flag">
							</div>
							<div class="text">
								<span class="country">USA</span><br />
								<span class="number">578</span>
							</div>
						</div>

					</div>

				</div>

				<div aria-hidden="true" class="report-spacer-120"></div>

				<p class="sub-header is-centered">Top Three Job Functions</p>

				<div class="lf-grid section-03__top-jobs">
					<div class="section-03__top-jobs-col1">
						<p class="table-header">DevOps / SRE / Sysadmin</p>
						<span class="large">6,392</span>
					</div>
					<div class="section-03__top-jobs-col2">
						<p class="table-header">Developer</p>
						<span class="large">2,971</span>
					</div>
					<div class="section-03__top-jobs-col3">
						<p class="table-header">Architect</p>

						<span class="large">2,419</span>
					</div>

				</div>

				<button class="button-reset section-03__button"
					data-id="js-hidden-section-trigger-open">
					See Full List
					<?php LF_Utils::get_svg( $report_folder . 'arrow-down.svg' ); ?>
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
												<td>2,419</td>
											</tr>
											<tr>
												<td>Business Operations</td>
												<td>169</td>
											</tr>
											<tr>
												<td>Developer</td>
												<td>2,971</td>
											</tr>
											<tr>
												<td> - Data Scientist</td>
												<td>136</td>
											</tr>
											<tr>
												<td> - Full Stack Developer</td>
												<td>2,306</td>
											</tr>
											<tr>
												<td> - Machine Learning
													Specialist</td>
												<td>86</td>
											</tr>
											<tr>
												<td> - Web Developer</td>
												<td>418</td>
											</tr>
											<tr>
												<td> - Mobile Developer</td>
												<td>25</td>
											</tr>
											<tr>
												<td>DevOps / SRE / SysAdmin</td>
												<td>6,392</td>
											</tr>
											<tr>
												<td>Executive</td>
												<td>670</td>
											</tr>
											<tr>
												<td>IT Operations</td>
												<td>493</td>
											</tr>
											<tr>
												<td> - DevOps</td>
												<td>205</td>
											</tr>
											<tr>
												<td> - Systems Admin</td>
												<td>213</td>
											</tr>
											<tr>
												<td> - Site Reliability Engineer
												</td>
												<td>63</td>
											</tr>
											<tr>
												<td> - Quality Assurance
													Engineer</td>
												<td>12</td>
											</tr>
											<tr>
												<td>Sales / Marketing</td>
												<td>845</td>
											</tr>
											<tr>
												<td>Media / Analyst</td>
												<td>161</td>
											</tr>
											<tr>
												<td>Student</td>
												<td>482</td>
											</tr>
											<tr>
												<td>Product Manager</td>
												<td>486</td>
											</tr>
											<tr>
												<td>Professor / Academic</td>
												<td>68</td>
											</tr>
											<tr>
												<td>Other</td>
												<td>911</td>
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
												<td>468</td>
											</tr>
											<tr>
												<td>Consumer Goods</td>
												<td>481</td>
											</tr>
											<tr>
												<td>Energy</td>
												<td>242</td>
											</tr>
											<tr>
												<td>Financials</td>
												<td>1,521</td>
											</tr>
											<tr>
												<td>Health Care</td>
												<td>203</td>
											</tr>
											<tr>
												<td>Industrials</td>
												<td>253</td>
											</tr>
											<tr>
												<td>Information Technology</td>
												<td>10,789</td>
											</tr>
											<tr>
												<td>Materials</td>
												<td>44</td>
											</tr>
											<tr>
												<td>Non-Profit Organization</td>
												<td>382</td>
											</tr>
											<tr>
												<td>Professional Services</td>
												<td>698</td>
											</tr>
											<tr>
												<td>Telecommunications</td>
												<td>595</td>
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
					<?php LF_Utils::get_svg( $report_folder . 'arrow-up.svg' ); ?>
					Close Full List
				</button>

				<div aria-hidden="true" class="report-spacer-120"></div>

			</div>
		</section>

		<section class="section-04 alignfull background-image-wrapper">

			<figure class="background-image-figure darken-on-mobile">
				<?php LF_Utils::display_responsive_images( 90395, 'full', '1200px', null, 'lazy', 'Audience at Kubecon + CloudNativeCon Europe 2023' ); ?>
			</figure>

			<div class="background-image-text-overlay">
				<div class="container wrap">

					<div class="quote-with-name-container">
						<p
							class="quote-with-name-container__quote">Cloud Native's popularity continues unabated; while there were around 7,000 visitors in Valencia, where the event took place last year, it was bursting at the seams with more than 10,000 visitors...</p>
						<div class="quote-with-name-container__marks">
							<p
								class="quote-with-name-container__name">Ulrike Ostler</p>
							<p
								class="quote-with-name-container__position">DataCenter-Insider</p>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="section-05">

			<p class="sub-header">Year on Year Growth - European Events</p>

			<div class="section-05__yoy">
				<div class="legend__wrapper"><i
						class="legend__key legend__blue-700"></i>
					In-person
				</div>

				<div class="legend__wrapper"><i
						class="legend__key legend__blue-200"></i>
					Virtual
				</div>
			</div>

			<div aria-hidden="true" class="report-spacer-40"></div>

			<div class="lf-grid section-05__chart">
				<div class="section-05__chart-col1">
					<img loading="lazy" width="800" height="480" src="
			<?php LF_Utils::get_svg( $report_folder . 'yoy-growth-european-events.svg', true ); ?>
			" alt="Chart showing year on year attendee growth">
				</div>

				<div class="section-05__chart-col2">
					<div class="section-05__chart-key">
						<img loading="lazy" width="290" height="90"
							src="
						<?php LF_Utils::get_svg( $report_folder . 'yoy-growth-increase.svg', true ); ?>"
							class="section-05__chart-key-image"
							alt="48% increase">

						<div class="thin-hr section-05__chart-key-hr"></div>

						<p
							class="section-05__chart-key-text">From KubeCon + CloudNativeCon 2022 in Valencia to the event in Amsterdam, we saw a 48% increase in in-person attendees.</p>

						<div class="wp-block-button"><a
								href="https://www.kubecon.io"
								class="wp-block-button__link">JOIN THE NEXT
								KUBECON + CLOUDNATIVE CON</a>
						</div>

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
							<th>2023
								<span>Amsterdam</span>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Total</td>
							<td>1,535</td>
							<td>4,300</td>
							<td>7,700</td>
							<td>18,682</td>
							<td>26,648</td>
							<td>18,550</td>
							<td>16,092</td>
						</tr>
						<tr>
							<td class="nowrap">In-person Corporate</td>
							<td>58%</td>
							<td>62%</td>
							<td>63%</td>
							<td>N/A</td>
							<td>N/A</td>
							<td>19%</td>
							<td>33%</td>
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
							<td>13%</td>
						</tr>
						<tr>
							<td>Virtual All Access Pass</td>
							<td>N/A</td>
							<td>N/A</td>
							<td>N/A</td>
							<td>71%</td>
							<td>67%</td>
							<td>50%</td>
							<td>27%</td>
						</tr>
						<tr>
							<td>Virtual Keynote + Solutions Showcase Only</td>
							<td>N/A</td>
							<td>N/A</td>
							<td>N/A</td>
							<td>20%</td>
							<td>27%</td>
							<td>8%</td>
							<td>8%</td>
						</tr>
						<tr>
							<td>Speaker</td>
							<td>9%</td>
							<td>8%</td>
							<td>6%</td>
							<td>2%</td>
							<td>1%</td>
							<td>3%</td>
							<td>4%</td>
						</tr>
						<tr>
							<td>Sponsor</td>
							<td>17%</td>
							<td>16%</td>
							<td>14%</td>
							<td>6%</td>
							<td>5%</td>
							<td>12%</td>
							<td>13%</td>
						</tr>
						<tr>
							<td>Media</td>
							<td>2%</td>
							<td>2%</td>
							<td>1%</td>
							<td>&lt;1%</td>
							<td>0.6%</td>
							<td>1%</td>
							<td>1%</td>
						</tr>
						<tr>
							<td>Academic</td>
							<td>2%</td>
							<td>3%</td>
							<td>3%</td>
							<td>N/A</td>
							<td>N/A</td>
							<td>1%</td>
							<td>2%</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="shadow-hr"></div>

			<p class="sub-header">Diversity, Equity & Inclusivity</p>
			<div aria-hidden="true" class="report-spacer-60"></div>
			<div class="lf-grid">
				<div class="dei__intro">
					<p>CNCF strives to ensure that everyone who participates in KubeCon + CloudNativeCon feels welcome, regardless of gender, gender identity, sexual orientation, disability, race, ethnicity, age, religion, or economic status.<br><br>Our commitment to cultivating a friendly, welcoming, and inclusive environment extends to the facilities and resources we provide at events. In Amsterdam, these included:</p>
				</div>
			</div>
			<div aria-hidden="true" class="report-spacer-60"></div>
			<div class="lf-grid dei__commitments">
				<div class="dei__commitments-col1">
					<div class="icon-box-5">
						<div class="icon-box-5__icon"><img loading="lazy"
								width="100" height="100"
								src="<?php LF_Utils::get_svg( $report_folder . 'icon-prayer.svg', true ); ?>"
								alt="Prayer icon">
						</div>
						<div class="icon-box-5__text">Prayer Room</div>
					</div>
					<div class="icon-box-5">
						<div class="icon-box-5__icon"><img loading="lazy"
								width="100" height="100"
								src="<?php LF_Utils::get_svg( $report_folder . 'icon-sticky-note.svg', true ); ?>"
								alt="Sticky note icon">
						</div>
						<div class="icon-box-5__text">Pronoun & Communication
							Stickers</div>
					</div>
					<div class="icon-box-5">
						<div class="icon-box-5__icon"><img loading="lazy"
								width="100" height="100"
								src="<?php LF_Utils::get_svg( $report_folder . 'icon-child-care.svg', true ); ?>"
								alt="Child Care icon">
						</div>
						<div class="icon-box-5__text">Complimentary Onsite Child
							Care</div>
					</div>
				</div>
				<div class="dei__commitments-col2">
					<div class="icon-box-5">
						<div class="icon-box-5__icon"><img loading="lazy"
								width="100" height="100"
								src="<?php LF_Utils::get_svg( $report_folder . 'icon-mixed-gender.svg', true ); ?>"
								alt="Mixed gender icon">
						</div>
						<div class="icon-box-5__text">All Gender Restrooms</div>
					</div>
					<div class="icon-box-5">
						<div class="icon-box-5__icon"><img loading="lazy"
								width="100" height="100"
								src="<?php LF_Utils::get_svg( $report_folder . 'icon-pacifier.svg', true ); ?>"
								alt="Pacifier icon">
						</div>
						<div class="icon-box-5__text">Baby Care & Nursing Rooms
						</div>
					</div>
				</div>
				<div class="dei__commitments-col3">
					<div class="icon-box-5">
						<div class="icon-box-5__icon"><img loading="lazy"
								width="100" height="100"
								src="<?php LF_Utils::get_svg( $report_folder . 'icon-mute.svg', true ); ?>"
								alt="Mute icon">
						</div>
						<div class="icon-box-5__text">Quiet Rooms</div>
					</div>
					<div class="icon-box-5">
						<div class="icon-box-5__icon"><img loading="lazy"
								width="100" height="100"
								src="<?php LF_Utils::get_svg( $report_folder . 'icon-closed-captions.svg', true ); ?>"
								alt="Closed Captions icon">
						</div>
						<div class="icon-box-5__text">Captioning for all
							attendees in 20+ languages through Wordly
						</div>
					</div>
				</div>
			</div>

			<div aria-hidden="true" class="report-spacer-60"></div>

			<div class="lf-grid">
				<div class="dei__intro">
					<p>As part of our deep commitment to diversity, equity and inclusivity, we hosted a number of popular onsite experiences to help connect individuals to opportunities within tech, including:</p>
					<ul>
						<li>EmpowerUs Breakfast</li>
						<li>Diversity Lunch</li>
						<li>Peer Group Networking</li>
					</ul>
				</div>
			</div>

			<div class="shadow-hr"></div>

			<div class="lf-grid">
				<div class="dei__col-1">
					<p class="sub-header">Gold CHAOSS D&I Event Badge</p>
					<div aria-hidden="true" class="report-spacer-40"></div>
					<?php LF_Utils::display_responsive_images( 90434, 'full', '320px', 'svg-image badge', 'lazy', 'Gold CHAOSS D&I Event Badge' ); ?>
					<div aria-hidden="true" class="report-spacer-40"></div>
					<p>Awarded to events in the open source community that foster healthy D&I practices.</p>
				</div>
				<div class="dei__col-2">
					<div class="kccnc-table-container">
						<table class="kccnc-table dei__table">
							<thead>
								<tr>
									<th>Diversity, Equity & Inclusivity Events
										and
										Mentoring
									</th>
									<th>Total</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Diversity Lunch participants</td>
									<td>125</td>
								</tr>
								<tr>
									<td>EmpowerUs participants</td>
									<td>50</td>
								</tr>
								<tr>
									<td>Peer Group Mentoring + Career Networking
										<strong>mentors</strong>
									</td>
									<td>8</td>
								</tr>
								<tr>
									<td>Peer Group Mentoring + Career Networking
										<strong>mentees</strong>
									</td>
									<td>42</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>

			<div aria-hidden="true" class="report-spacer-120"></div>

			<p
				class="sub-header has-lines">Our Next Kubecon + CloudNativeCon</p>

			<div aria-hidden="true" class="report-spacer-80"></div>

			<?php
			echo do_shortcode( '[event_banner hide_title=true]' );
			?>
		</section>

		<section id="content"
			class="section-06 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">Content</h2>
					<div class="section-number">2/8</div>
				</div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p
							class="opening-paragraph">With more than 300 sessions, KubeCon + CloudNativeCon Europe featured a diverse line-up of topics ranging from introductory sessions through to technical deep-dives. Talks are available now on our <a href="https://www.youtube.com/playlist?list=PLj6h78yzYM2PyrvCoOii4rAopBswfz1p7">YouTube playlist</a>.</p>
					</div>
				</div>

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
								<td>22</td>
								<td>22</td>
								<td>0</td>
							</tr>
							<tr>
								<td>Total sessions (CFP & Maintainer)</td>
								<td>308</td>
								<td>287</td>
								<td>21</td>
							</tr>
							<tr>
								<td> - Breakouts</td>
								<td>210</td>
								<td>198</td>
								<td>12</td>
							</tr>
							<tr>
								<td> - Maintainer sessions</td>
								<td>98</td>
								<td>89</td>
								<td>9</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<p
					class="sub-header">Thank you to our KubeCon + CloudNativeCon Europe 2023 co-chairs</p>

				<div class="lf-grid chairs">
					<div class="chairs__col1">
						<?php LF_Utils::display_responsive_images( 90376, 'full', '200px', 'chairs__image', 'lazy', 'Aparna Subramanian' ); ?>
						<p>
<span class="chairs__name">Aparna Subramanian
</span><span
	class="chairs__title">Shopify <br/>
Director of Production Engineering</span>
</p>
					</div>
					<div class="chairs__col2">
						<?php LF_Utils::display_responsive_images( 90378, 'full', '200px', 'chairs__image', 'lazy', 'Emily Fox' ); ?>
						<p>
<span class="chairs__name">Emily Fox</span><span
class="chairs__title">Apple <br/>
Security Engineer</span></p>
					</div>
					<div class="chairs__col3">
						<?php LF_Utils::display_responsive_images( 90379, 'full', '200px', 'chairs__image', 'lazy', 'Frederick Kautz' ); ?>
						<p>
<span class="chairs__name">Frederick Kautz</span><span
class="chairs__title"></span>Computing Engineer Infra and <br/>
Security Enterprise Architect</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-120"></div>
			</div>
		</section>

		<section class="section-07 alignfull">
			<div class="container wrap">

				<div aria-hidden="true" class="report-spacer-120"></div>

				<h2 class="section-header">Content <br />Breakdown</h2>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<div class="lf-grid">
					<div class="restrictive-10-col">
						<p>The schedule was curated by conference co-chairs, Aparna Subramanian of Shopify, Emily Fox of Apple, and independent consultant Frederick Kautz, who led a program committee of experts and track chairs, including project maintainers, active community members, and highly rated presenters from past events.<br><br>
Talks are selected by the program committee through a rigorous, non-bias process, where they are randomly assigned submissions to review within their area of expertise. You can read the details in our <a href="https://events.linuxfoundation.org/kubecon-cloudnativecon-europe/program/scoring-guidelines/#general-info">CFP scoring guidelines</a>, and specifically about the <a href="https://www.cncf.io/blog/2021/03/08/a-look-inside-the-kubecon-cloudnativecon-schedule-selection-process/">Europe selection process</a>.<br><br>
For KubeCon + CloudNativeCon Europe, 1767 submissions were received from 2672 proposed speakers at 632 companies. Of those, we were able to accept 186 talks with 347 total speakers - an acceptance rate of 11%. You can <a href="https://www.cncf.io/blog/2023/02/08/inside-the-numbers-the-kubecon-cloudnativecon-selection-process-for-europe-2023/">read more in this announcement blog</a>.<br><br>
In addition, we heard from 209 maintainer speakers, who ran maintainer sessions - which were not part of the CFP process.</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<p class="sub-header">Key stats</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-07__content-breakdown">

					<div class="section-07__content-breakdown-col1">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" width="64" height="64" src="<?php LF_Utils::get_svg( $report_folder . 'icon-inbox-b.svg', true ); ?>
" alt="Bell icon">
							</div>
							<div class="text">
								<span class="number">1,767</span><br />
								<span class="description">CFP submissions</span>
							</div>
						</div>
						<!-- End of Icon Box 3 -->
					</div>
					<div class="section-07__content-breakdown-col2">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" width="64" height="64" src="<?php LF_Utils::get_svg( $report_folder . 'icon-microphone-b.svg', true ); ?>
" alt="Bell icon">
							</div>
							<div class="text">
								<span class="number">556</span><br />
								<span class="description">Speakers</span>

							</div>
						</div>
						<!-- End of Icon Box 3 -->
					</div>
					<div class="section-07__content-breakdown-col3">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" width="64" height="64" src="<?php LF_Utils::get_svg( $report_folder . 'icon-person-b.svg', true ); ?>
" alt="Bell icon">
							</div>
							<div class="text">
								<span class="number">273</span><br />
								<span class="description">first-time
									speakers</span>
							</div>
						</div>
						<!-- End of Icon Box 3 -->
					</div>
				</div>
				<div aria-hidden="true" class="report-spacer-120"></div>
			</div>
		</section>

		<section class="section-08 alignfull">
			<div class="container wrap">

				<div aria-hidden="true" class="report-spacer-120"></div>

				<h2 class="section-header">Speaker Diversity</h2>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<p>CNCF enforces guidelines on gender and diversity equality among our speakers, including not accepting all-male panels.</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

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
								<td>9</td>
								<td>41%</td>
							</tr>
							<tr>
								<td>Speakers - men (breakouts)</td>
								<td>245</td>
								<td>73%</td>
							</tr>
							<tr>
								<td>Speakers - women + gender non-conforming
									(breakouts)</td>
								<td>90</td>
								<td>27%</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div class="shadow-hr"></div>

				<h2 class="section-header">Startup Track</h2>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>New to KubeCon + CloudNativeCon Europe this year was the Startup Track. Inspired by an idea from <a href="https://www.cncf.io/people/governing-board/?p=liz-rice">Liz Rice</a>, the Startup Track demonstrates how you can build a business based on open source and cloud native technologies as part of <a href="https://www.linkedin.com/feed/hashtag/teamcloudnative">#TeamCloudNative</a>.<br><br><strong>It featured two talks, hosted by cloud native veterans:</strong></p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="shadow-outline-box">
					<div>
						<p class="sub-header">From Community to Customers</p>

						<p
							class="shadow-outline-box__by">Kelsey Hightower, Distinguished Engineer, Google Cloud</p>

						<p>An open discussion on building a business around open source projects, where Kelsey shared his learnings from Puppet Labs, CoreOS, Google, and advising startups behind some of the most successful open source projects in the Cloud Native space.</p>
					</div>

					<div class="shadow-outline-box__video">
						<div class="wp-block-lf-youtube-lite">
							<lite-youtube videoid="eb0442K_zmY"
								videotitle="From Community to Customers"
								webpStatus="1" sdthumbStatus="0" title="Play">
							</lite-youtube>
						</div>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<div class="shadow-outline-box">
					<div>
						<p
							class="sub-header">Building a Successful Business <br class="show-over-1000">in Cloud Native</p>

						<p
							class="shadow-outline-box__by">Liz Rice, Chief Open Source Officer, Isovalent; Kelsey Hightower, Distinguished Engineer, Google Cloud; Guillermo Rauch, CEO and Founder, Vercel; Sheng Liang, Cofounder and CEO, Acorn Labs; Tom Manville, VP Engineering, Kasten by Veeam</p>

						<p>This panel discussed how start-ups and smaller vendors can best take advantage of opportunities to succeed within the cloud native ecosystem, including how contributing to open source projects helps a business, how vendors can make their products appeal to a community centered around open source, and how the cloud native business environment differs from traditional markets.</p>
					</div>

					<div class="shadow-outline-box__video">
						<div class="wp-block-lf-youtube-lite">
							<lite-youtube videoid="XFtrxLiUjKw"
								videotitle="Building a Successful Business in Cloud Native"
								webpStatus="1" sdthumbStatus="0" title="Play">
							</lite-youtube>
						</div>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<div class="quote-with-name-container">
					<p
						class="quote-with-name-container__quote">With more than 52,000 community group members, 406 group chapters and 24 Kubernetes community days, it is obvious the interest is real. And given the conversations I had with CIOs, cloud-native modernization is top of mind -- if not the highest priority -- for many organizations.</p>
					<div class="quote-with-name-container__marks">
						<p
							class="quote-with-name-container__name">Paul Nashawaty</p>
						<p
							class="quote-with-name-container__position">TechTarget</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-120"></div>
			</div>
		</section>

		<section id="colocated"
			class="section-09 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">Co-Located <Br />
						Events</h2>
					<div class="section-number">3/8</div>
				</div>

				<div class="lf-grid">
					<div class="restrictive-10-col">
						<p
							class="opening-paragraph">CNCF-hosted co-located events feature industry experts covering topics like observability, web assembly, telco, edge, and more. This year we took a fresh approach, offering all-access passes that allowed attendees to join any of the CNCF-hosted co-located events, and even switch between multiple events.</p>
					</div>
				</div>

				<h2 class="section-header">Demographics</h2>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<div class="lf-grid section-09__demographics">
					<div class="section-09__demographics-col1">
						<p class="sub-header">Attendees by Gender</p>
						<div aria-hidden="true" class="report-spacer-60"></div>
						<div class="lf-grid sub-grid">
							<div class="sub-grid__col1">
								<p>Men</p>
								<img src="<?php LF_Utils::get_svg( $report_folder . 'icon-male.svg', true ); ?>"
									width="60" height="70" alt="Icon Male"
									loading="lazy">
								<h3 class="large">50%</h3>
							</div>
							<div class="sub-grid__col2">
								<p>Women</p>
								<img src="<?php LF_Utils::get_svg( $report_folder . 'icon-female.svg', true ); ?>"
									width="60" height="70" alt="Icon Woman"
									loading="lazy">
								<h3 class="large">8%</h3>
							</div>
							<div class="sub-grid__col3">
								<p>Non binary<br>/ other</p>
								<img src="<?php LF_Utils::get_svg( $report_folder . 'icon-non-binary.svg', true ); ?>"
									width="60" height="70"
									alt="Icon Non-Gender Specific"
									loading="lazy">
								<h3 class="large">1%</h3>
							</div>
						</div>
						<p
							class="section-09__demographics-note"><span style="color: #FF85C1;">41%</span> prefer not to answer</p>
					</div>
					<div class="section-09__demographics-col2">
						<p
							class="sub-header">Top Three Countries Represented</p>
						<div aria-hidden="true" class="report-spacer-60"></div>
						<div class="lf-grid sub-grid">
							<div class="sub-grid__col1">
								<p>Germany<br>&nbsp;</p>
								<img src="<?php LF_Utils::get_svg( $report_folder . 'flag-germany.svg', true ); ?>"
									width="70" height="70" alt="Icon Germany"
									loading="lazy">
								<h3 class="large">19%</h3>
							</div>
							<div class="sub-grid__col2">
								<p>USA<br>&nbsp;</p>
								<img src="<?php LF_Utils::get_svg( $report_folder . 'flag-usa.svg', true ); ?>"
									width="70" height="70" alt="Icon USA"
									loading="lazy">
								<h3 class="large">15%</h3>
							</div>
							<div class="sub-grid__col3">
								<p>Netherlands<br>&nbsp;</p>
								<img src="<?php LF_Utils::get_svg( $report_folder . 'flag-netherlands.svg', true ); ?>"
									width="70" height="70"
									alt="Icon Netherlands" loading="lazy">
								<h3 class="large">9%</h3>
							</div>
						</div>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<div class="lf-grid section-09__demographics">
					<div class="section-09__demographics-col1">
						<p class="sub-header">Top Three Job Functions</p>
						<div aria-hidden="true" class="report-spacer-60"></div>
						<div class="lf-grid sub-grid">
							<div class="sub-grid__col1">
								<p>DevOps / SRE /<br> Sysadmin</p>
								<h3 class="large purple">41%</h3>
							</div>
							<div class="sub-grid__col2">
								<p>Developer<br>&nbsp;</p>
								<h3 class="large purple">19%</h3>
							</div>
							<div class="sub-grid__col3">
								<p>Architect<br>&nbsp;</p>
								<h3 class="large purple">16%</h3>
							</div>
						</div>
					</div>
					<div class="section-09__demographics-col2">
						<p class="sub-header">Sponsors</p>
						<div aria-hidden="true" class="report-spacer-60"></div>
						<div class="lf-grid sub-grid">
							<div class="sub-grid__col1 two-cols">
								<p>Total Onsite Leads<br>&nbsp;</p>
								<h3 class="large purple">2,315</h3>
							</div>
							<div class="sub-grid__col2 two-cols">
								<p>Average Onsite Leads <br>Per Sponsor</p>
								<h3 class="large purple">178</h3>
								<p
									class="note"><span style="color: #763FAB;">119%</span> increase from 2022</p>
							</div>
						</div>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<?php LF_Utils::display_responsive_images( 90487, 'full', '600px', 'section-09__banner', 'lazy', '3,650 people Registered for Co-Located Events - the largest audience ever' ); ?>

				<div class="shadow-hr"></div>

				<h2 class="section-header">Reports</h2>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<p>You can rewatch the session recordings via the <a href="https://www.youtube.com/@cncf/playlists">co-located events web page</a>.</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="masonry-grid">
					<?php LF_Utils::display_responsive_images( 90410, 'full', '400px', 'masonry-item', 'lazy', 'Stats for Argo co-located event' ); ?>

					<?php LF_Utils::display_responsive_images( 90411, 'full', '400px', 'masonry-item', 'lazy', 'Stats for CiliumCon co-located event' ); ?>

					<?php LF_Utils::display_responsive_images( 90412, 'full', '400px', 'masonry-item', 'lazy', 'Stats for Cloud Native Telco Day co-located event' ); ?>

					<?php LF_Utils::display_responsive_images( 90413, 'full', '400px', 'masonry-item', 'lazy', 'Stats for Cloud Native WASM Day  co-located event' ); ?>

					<?php LF_Utils::display_responsive_images( 90414, 'full', '400px', 'masonry-item', 'lazy', 'Stats for ISTIO Day Europe co-located event' ); ?>

					<?php LF_Utils::display_responsive_images( 90415, 'full', '400px', 'masonry-item', 'lazy', 'Stats for Kubernetes Batch + HPC Day Europe co-located event' ); ?>

					<?php LF_Utils::display_responsive_images( 90418, 'full', '400px', 'masonry-item', 'lazy', 'Stats for Observability Day co-located event' ); ?>

					<?php LF_Utils::display_responsive_images( 90416, 'full', '400px', 'masonry-item', 'lazy', 'Stats for Kubernetes on Edge Day co-located event' ); ?>

					<?php LF_Utils::display_responsive_images( 90417, 'full', '400px', 'masonry-item', 'lazy', 'Stats for Linkerd Day Europe co-located event' ); ?>
				</div>

				<div aria-hidden="true" class="report-spacer-120"></div>

			</div>
		</section>

		<section class="section-10 alignfull background-image-wrapper">

			<figure class="background-image-figure">
				<?php LF_Utils::display_responsive_images( 90377, 'full', '1200px', 'section-10__image', 'lazy', 'Speaker at a colocated event' ); ?>
			</figure>

			<div class="background-image-text-overlay">
				<div class="container wrap">

					<div aria-hidden="true" class="report-spacer-120"></div>

					<div class="section-10__container">

						<h2 class="section-10__title">Interested in learning
							more about hosting a co-located event alongside
							future KubeCon + CloudNativeCons? We're launching
							available packages at the end of June</h2>
					</div>

					<div aria-hidden="true" class="report-spacer-120"></div>

				</div>
			</div>
		</section>

		<section id="security"
			class="section-11 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">Security</h2>
					<div class="section-number">4/8</div>
				</div>

				<div class="lf-grid">
					<div class="restrictive-10-col">
						<p
							class="opening-paragraph">Security is people-powered, and we all benefit by collaborating together as a knowledgeable, vendor-neutral community to develop tools and processes to uplevel our security posture.</p>
					</div>
				</div>

				<div class="lf-grid">
					<div class="restrictive-8-col">
						<p>Security was a key focal point at KubeCon + CloudNativeCon Europe, where a number of new initiatives were hosted to foster a collaborative approach toward tackling security issues.</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<div class="quote-with-name-container">
					<p
						class="quote-with-name-container__quote">If we truly are moving to standardize cloud-native technologies, to lock them down and further secure them and to build an increasingly comprehensive set of standards and protocols, then we can feasibly also now turn our attention towards being more sustainable in our software application development and more sustainable in terms of how much of the planet's resources that software uses.</p>
					<div class="quote-with-name-container__marks">
						<p
							class="quote-with-name-container__name">Adrian Bridgwater</p>
						<p
							class="quote-with-name-container__position">Forbes</p>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">SECURITY VILLAGE</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-8-col">
						<p><a href="https://tag-security.cncf.io/blog/security-village-at-kubecon-eu/">The Security Village</a>, a dedicated space for attendees to learn, share, and collaborate about the latest security practices and tools in the Kubernetes and cloud-native ecosystem, <a href="https://kccnceu2023.sched.com/type/Security+%2B+Identity/TAG+Security+Recommended">featured a series of talks</a>, open spaces for security-related discussions, and a daily afternoon unconference.</p>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">SECURITY TAG UNCONFERENCE</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-8-col">
						<p>Security TAG hosted a <a href="https://en.wikipedia.org/wiki/Unconference">daily afternoon unconference</a>, covering a range of security-related topics, from securing software supply chains to implementing zero-trust security, managing security for cloud-native infrastructure and applications, or building a security-first culture.<br><br>Each morning attendees could submit topics for that afternoon's unconference session, to be answered by industry experts, practitioners, and fellow attendees.</p>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">SECURITY AUDIT ANNOUNCEMENTS</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>We were pleased to announce <a href="https://research.nccgroup.com/2023/04/17/public-report-kubernetes-1-24-security-audit/">the latest refreshed Kubernetes third-party audit</a> based on the 1.24 release, at KubeCon + CloudNativeCon Europe.<br><br>The goal of this security review was to identify any issues in the project architecture and code base which could adversely affect the security of Kubernetes users.<br><br>This audit was sponsored by CNCF and conducted over the summer of 2022 by <a href="https://www.nccgroup.com/">NCC Group</a> with the help of the <a href="https://github.com/kubernetes/sig-security/issues/13">Kubernetes SIG Security Third Party Audit Working Group</a>.</p>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">SLSAs FOR GRADUATED PROJECTS</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>To continue efforts to improve the security of CNCF graduated and incubating projects, we worked with <a href="https://www.chainguard.dev/">Chainguard</a> to assess the software supply chain security practices of two graduated projects: Argo and Prometheus.</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<div class="lf-grid slsa">
					<div class="slsa__box">
						<a
							href="https://github.com/argoproj/argoproj/blob/master/docs/software_supply_chain_slsa_assessment_chainguard_2023.pdf">
							<p
								class="slsa__title">ARGO SLSA <br>ASSESSMENT REPORT</p>
							<div class="slsa__image-wrapper">
								<?php LF_Utils::display_responsive_images( 90441, 'full', '600px', 'slsa__image svg-image', 'lazy', 'Logo of Argo' ); ?>
							</div>
						</a>
					</div>

					<div class="slsa__box">
						<a
							href="https://prometheus.io/docs/operating/security/#external-audits">
							<p
								class="slsa__title">PROMETHEUS SLSA <br>ASSESSMENT REPORT</p>
							<div class="slsa__image-wrapper">
								<?php LF_Utils::display_responsive_images( 90442, 'full', '600px', 'slsa__image svg-image', 'lazy', 'Logo of Prometheus' ); ?>
							</div>
						</a>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>The assessments were based on <a href="https://slsa.dev/">Supply-chain Levels for Software Artifacts</a> (SLSA), which provides a framework for software supply chain integrity. SLSA is housed under the <a href="https://openssf.org/">Open Source Security Foundation</a> (OpenSSF) and details standards and technical controls that can be adopted to improve artifact integrity and build resilient systems.<br><br>These efforts build on the security work CNCF has been doing with <a href="https://www.cncf.io/blog/2022/08/08/improving-cncf-security-posture-with-independent-security-audits/">independent security audits with OSTIF</a> and <a href="https://www.cncf.io/blog/2022/06/28/improving-security-by-fuzzing-the-cncf-landscape/">fuzzing audits with ADA Logics</a> and address a crucial aspect of security health in the software supply chain.</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<div class="quote-with-name-container">
					<p
						class="quote-with-name-container__quote">As we've continued to see an increase in frequency and severity of attacks across the software supply chain, we felt it was more important than ever to ensure our projects are taking steps to continuously improve their security practices with SLSA.</p>
					<div class="quote-with-name-container__marks">
						<p
							class="quote-with-name-container__name">Chris Anisczyck</p>
						<p
							class="quote-with-name-container__position">CTO, CNCF</p>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<div class="lf-grid kids-day">
					<div class="kids-day-col1">
						<?php LF_Utils::display_responsive_images( 90419, 'full', '470px', null, 'lazy', 'Phippy at Kids Day' ); ?>
					</div>
					<div class="kids-day-col2">
						<p
							class="opening-paragraph">On Sunday, April 16, we hosted a complimentary Kid's Day in Amsterdam featuring three workshops:</p>

						<ol>
							<li>Minecraft Modding</li>
							<li>Phippy and Friends Raspberry Pi Zoo Rescue</li>
							<li>Stories and Games with Scratch</li>
						</ol>

						<p>The Minecraft and Scratch workshops were taught primarily in Dutch, while the Raspberry Pi Workshop was taught primarily in English. Both English and Dutch-speaking volunteers assisted in each workshop.<br><br>We'll host Kids Day again at KubeCon + CloudNativeCon North America in Chicago this coming November, for all children (ages 8-14) who are interested in technology, coding, and STEAM fields.</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-120"></div>

			</div>
		</section>

		<section id="sustainability"
			class="section-12 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">Sustainability</h2>
					<div class="section-number">5/8</div>
				</div>

				<div class="lf-grid section-12__intro">
					<div class="section-12__intro-col1">
						<p
							class="opening-paragraph">We're committed to sustainability at our events and KubeCon + CloudNativeCon Europe was no exception.</p>

						<p>We do our best to balance sustainability with various rules and regulations (especially where food service is concerned) in the cities and countries in which we host our events. See below for ways we are partnering with our vendors and community to create more sustainable events and minimize environmental impacts.</p>

						<ul>
							<li>We carefully plan for the attendee numbers based
								on historical data to minimize waste from the
								start</li>
							<li>Food & beverage items are sourced from local
								suppliers</li>
							<li>Leftover food was donated to a local food bank 
							</li>
							<li>All disposable cups were biodegradable</li>
							<li>Lunch bags were made from recycled paper</li>
							<li>CNCF and sponsors donated left over items,
								including apparel, napkins, coffee cups, toys &
								games, office supplies, cleaning/sanitizing
								supplies, and other miscellaneous items to <a
									href="https://hvoquerido.nl/">
									HVO
									Querido Amsterdam
								</a></li>
							<li>Conference lanyards were made from 100% recycled
								materials</li>
							<li>Learn more about the <a
									href="https://www.rai.nl/en/corporate-social-responsibility">
									RAI's corporate social
									responsibility initiatives
								</a></li>
							<li>Learn more about <a
									href="https://acsaudiovisual.com/about/social-responsibility/">ACS</a>'
								(audio visual provider)
								corporate social responsibility initiatives</li>
						</ul>

						<p></p>
					</div>
					<div class="section-12__intro-col2">

						<?php LF_Utils::display_responsive_images( 90397, 'full', '470px', null, 'lazy', 'Sustainability at Kubecon + CloudNativeCon Europe 2023' ); ?>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<?php LF_Utils::display_responsive_images( 90398, 'full', '470px', null, 'lazy', 'Sustainability at Kubecon + CloudNativeCon Europe 2023' ); ?>

					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-120"></div>

			</div>
		</section>

		<section id="health"
			class="section-13 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">Health & Safety<br> On-Site
						Overview</h2>
					<div class="section-number">6/8</div>
				</div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p
							class="opening-paragraph">KubeCon + CloudNativeCon implemented the following health & safety measures:</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<p class="sub-header">COVID-19 safety</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid covid">
					<div class="covid-col1">
						<div class="icon-box-5">
							<div class="icon-box-5__icon"><img loading="lazy"
									width="100" height="100"
									src="<?php LF_Utils::get_svg( $report_folder . 'icon-sanitisation.svg', true ); ?>"
									alt="Sanitisation icon">
							</div>
							<div class="icon-box-5__text">Provided plentiful
								hand sanitizing stations throughout the venue
							</div>
						</div>
						<div class="icon-box-5">
							<div class="icon-box-5__icon"><img loading="lazy"
									width="100" height="100"
									src="<?php LF_Utils::get_svg( $report_folder . 'icon-health-mask.svg', true ); ?>"
									alt="Health mask icon">
							</div>
							<div class="icon-box-5__text">Masks were recommended
							</div>
						</div>

					</div>
					<div class="covid-col2">
						<div class="icon-box-5">
							<div class="icon-box-5__icon"><img loading="lazy"
									width="100" height="100"
									src="<?php LF_Utils::get_svg( $report_folder . 'icon-health-test.svg', true ); ?>"
									alt="Health test icon">
							</div>
							<div class="icon-box-5__text">Complimentary onsite
								COVID-19 testing</div>
						</div>
						<div class="icon-box-5">
							<div class="icon-box-5__icon"><img loading="lazy"
									width="100" height="100"
									src="<?php LF_Utils::get_svg( $report_folder . 'icon-health-band.svg', true ); ?>"
									alt="Health band icon">
							</div>
							<div class="icon-box-5__text">Wearable indicators
								denoting social distance comfort levels</div>
						</div>
					</div>
					<div class="covid-col3">
						<div class="icon-box-5">
							<div class="icon-box-5__icon"><img loading="lazy"
									width="100" height="100"
									src="<?php LF_Utils::get_svg( $report_folder . 'icon-clean.svg', true ); ?>"
									alt="Clean icon">
							</div>
							<div class="icon-box-5__text">Conducted frequent
								onsite cleaning
							</div>
						</div>

						<div class="icon-box-5">
							<div class="icon-box-5__icon"><img loading="lazy"
									width="100" height="100"
									src="<?php LF_Utils::get_svg( $report_folder . 'icon-microphone.svg', true ); ?>"
									alt="Microphone icon">
							</div>
							<div class="icon-box-5__text">Sanitized microphones
								between each speaker's use
							</div>
						</div>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">COVID-19 Numbers</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>Over the two weeks immediately after KubeCon + CloudNativeCon Europe, we were made aware of 10 positive tests. Fortunately, no serious cases have been reported.</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid tests">
					<div class="tests__col1">
						<span class="tests__large">10</span>
						<span class="tests__text">Positive Tests from
							<br>in-person attendees</span>
					</div>
					<div class="tests__col2">
						<span class="tests__large">0</span>
						<span class="tests__text">Serious Cases Reported</span>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">Incident Transparency Report</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid incidents">
					<div class="incidents__col1">
						<span class="incidents__large">0</span>
						<span class="incidents__text">Code of conduct reports
							<br>received on-site</span>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-120"></div>

			</div>
		</section>

		<!-- MEDIA 7/8  -->
		<section id="media" class="section-14 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">Media & Analyst<br> Coverage</h2>
					<div class="section-number">7/8</div>
				</div>

				<p class="sub-header">Key Stats</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-14__coverage">

					<div class="section-14__coverage-col1">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" width="64" height="64" src="<?php LF_Utils::get_svg( $report_folder . 'icon-share-b.svg', true ); ?>
" alt="Share icon">
							</div>
							<div class="text">
								<span class="number">176</span><br />
								<span class="description">media & industry
									analysts <br>in attendance</span>
							</div>
						</div>
						<!-- End of Icon Box 3 -->
					</div>
					<div class="section-14__coverage-col2">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" width="64" height="64" src="<?php LF_Utils::get_svg( $report_folder . 'icon-bell-b.svg', true ); ?>
" alt="Bell icon">
							</div>
							<div class="text">
								<span class="number">4,202</span><br />
								<span class="description">Mentions Of Kubecon
									<br>+ Cloudnativecon</span>

							</div>
						</div>
						<!-- End of Icon Box 3 -->
					</div>
					<div class="section-14__coverage-col3">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" width="64" height="64" src="<?php LF_Utils::get_svg( $report_folder . 'icon-graph-b.svg', true ); ?>
" alt="Graph up icon">
							</div>
							<div class="text">
								<span class="number">69%</span><br />
								<span class="description">Increase from 2022
									<br>European event </span>
							</div>
						</div>
						<!-- End of Icon Box 3 -->
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">Online Reach + Traffic</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-14__reach">

					<div class="section-14__reach-col1">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" width="64" height="64" src="<?php LF_Utils::get_svg( $report_folder . 'icon-heart-b.svg', true ); ?>
" alt="Heart icon">
							</div>
							<div class="text">
								<span class="number">547K</span><br />
								<span class="description">SOCIAL
									IMPRESSIONS</span>
							</div>
						</div>
						<!-- End of Icon Box 3 -->
					</div>
					<div class="section-14__reach-col2">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" width="64" height="64" src="<?php LF_Utils::get_svg( $report_folder . 'icon-click-b.svg', true ); ?>
" alt="Click icon">
							</div>
							<div class="text">
								<span class="number">11K+</span><br />
								<span class="description">SOCIAL
									ENAGEMENTS</span>
							</div>
						</div>
						<!-- End of Icon Box 3 -->
					</div>
					<div class="section-14__reach-col3">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" width="64" height="64" src="<?php LF_Utils::get_svg( $report_folder . 'icon-youtube-b.svg', true ); ?>
" alt="Youtube icon">
							</div>
							<div class="text">
								<span class="number">3.4K+</span><br />
								<span class="description">EVENT SESSION
									VIEWS</span>
								<span class="addendum">As of May 11, event
									session videos have garnered more than
									<strong>3,400</strong> views</span>
							</div>
						</div>
						<!-- End of Icon Box 3 -->
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">Media + Analyst Results</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-14__analyst">

					<div class="section-14__analyst-col1">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<?php LF_Utils::display_responsive_images( 90433, 'full', '200px', 'svg-image', 'lazy', 'Logo' ); ?>
							<div class="text">
								<span class="number">3,301</span><br />
								<span class="addendum">mentions in media
									articles, press releases, and blogs that
									were shared <strong>664</strong> times on
									Twitter.</span>
							</div>
						</div>
						<!-- End of Icon Box 3 -->
					</div>
					<div class="section-14__analyst-col2">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<?php LF_Utils::display_responsive_images( 90436, 'full', '200px', 'svg-image', 'lazy', 'Kubernetes Logo' ); ?>
							<div class="text">
								<span class="number">3,152</span><br />
								<span class="addendum">mentions in media
									articles, press releases, and blogs that
									were shared <strong>622</strong> times
									across social
									platforms.</span>
							</div>
						</div>
						<!-- End of Icon Box 3 -->
					</div>
					<div class="section-14__analyst-col3">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<?php LF_Utils::display_responsive_images( 90435, 'full', '200px', 'svg-image', 'lazy', 'KubeCon + CloudNativeCon Logo' ); ?>
							<div class="text">
								<span class="number">4,202</span><br />
								<span class="addendum">mentions in media
									articles, press releases, and blogs that
									were shared <strong>731</strong> times
									across social
									platforms.</span>
							</div>
						</div>
						<!-- End of Icon Box 3 -->
					</div>
				</div>

				<div class="shadow-hr"></div>

				<h2 class="section-header">Coverage Overview</h2>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p><strong>176 media and industry analysts attended</strong> both in person and virtually. They generated a huge amount of coverage from this year's European event hitting over <strong>4,200 articles and press releases</strong>, a <strong>69% increase</strong> from last year's European event. The CNCF PR and AR team hosted two media and analyst roundtables at the event focusing on platform engineering, and what's next in cloud native, in addition to an end user panel at the press and analyst conference.</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="quote-with-name-container">
					<p
						class="quote-with-name-container__quote">If DevOps was about combining the workflows of operations and development, then platform engineering aims to be the solution to the problems that are created. It's not an either/or proposition between the two, but platform engineering is an evolution of the DevOps movement, said a KubeCon + CloudNativeCon EU panel organized for the media.</p>
					<div class="quote-with-name-container__marks">
						<p
							class="quote-with-name-container__name">Loraine Lawson</p>
						<p
							class="quote-with-name-container__position">The New Stack</p>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">Media Coverage</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<p><strong>176 journalists and analysts</strong> attended both in-person and online.<br>A list of publications can be found below:</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-14__publications">
					<div class="section-14__publications-col1">
						<ul>
							<li>Amazic</li>
							<li>Cloud Security Podcast</li>
							<li>Computable</li>
							<li>Computerweekly.de</li>
							<li>DataCenter-Insider</li>
							<li>De Nederlandse Kubernetes Podcast</li>
							<li>Freelance</li>
							<li>Heise c't</li>
							<li>Heise Developer</li>
							<li>Heise iX</li>
							<li>ICT Magazine</li>
							<li>InfoQ</li>
							<li>IT Daily</li>
							<li>ITmedia Inc.</li>
							<li>ITPro</li>
							<li>L'informaticien</li>
							<li>Le Mag IT</li>
						</ul>

					</div>
					<div class="section-14__publications-col2">
						<ul>
							<li>Le Monde Informatique</li>
							<li>Linux Magazin</li>
							<li>NetMedia Group</li>
							<li>opensource.com</li>
							<li>Programmez</li>
							<li>Radio Tux</li>
							<li>Reshift</li>
							<li>SDxCentral</li>
							<li>Sigs Datacom</li>
							<li>SiliconANGLE</li>
							<li>Silverlinings</li>
							<li>Software Defined Podcast</li>
							<li>Software Defined Talk</li>
							<li>Software Engineering Daily</li>
							<li>Software Guru</li>
							<li>Springer Nature</li>
							<li>Storage Newsletter</li>
						</ul>

					</div>
					<div class="section-14__publications-col3">
						<ul>
							<li>Tech.eu</li>
							<li>Techstrong Group</li>
							<li>TechTarget</li>
							<li>Techzine</li>
							<li>TFIR</li>
							<li>The Cloudcast</li>
							<li>theCUBE</li>
							<li>The New Stack</li>
							<li>The Stack</li>
							<li>ThinkIT</li>
							<li>Toolinux</li>
							<li>VMblog</li>
							<li>Vogel IT</li>
							<li>ZDNet</li>
							<li>ZeCloud</li>
							<li>Zona Movilidad</li>
						</ul>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">Media Coverage Highlights</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<p><strong>More than 210</strong> original articles published from KubeCon + CloudNativeCon Europe in leading outlets including:</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="logo-grid">

					<div class="logo-grid__box">
						<?php LF_Utils::display_responsive_images( 90420, 'full', '600px', 'svg-image logo-grid__image', 'lazy', 'ComputerWeekly Logo' ); ?>
					</div>
					<div class="logo-grid__box">
						<?php LF_Utils::display_responsive_images( 90421, 'full', '600px', 'svg-image logo-grid__image', 'lazy', 'DevOps Logo' ); ?>
					</div>
					<div class="logo-grid__box">
						<?php LF_Utils::display_responsive_images( 90437, 'full', '600px', 'svg-image logo-grid__image', 'lazy', 'Forbes Logo' ); ?>
					</div>
					<div class="logo-grid__box">
						<?php LF_Utils::display_responsive_images( 90438, 'full', '600px', 'svg-image logo-grid__image', 'lazy', 'Heise Online Logo' ); ?>
					</div>
					<div class="logo-grid__box">
						<?php LF_Utils::display_responsive_images( 90422, 'full', '600px', 'svg-image logo-grid__image', 'lazy', 'LeMagIT Logo' ); ?>
					</div>
					<div class="logo-grid__box">
						<?php LF_Utils::display_responsive_images( 90423, 'full', '600px', 'svg-image logo-grid__image', 'lazy', 'Lemonde Logo' ); ?>
					</div>
					<div class="logo-grid__box">
						<?php LF_Utils::display_responsive_images( 90424, 'full', '600px', 'svg-image logo-grid__image', 'lazy', 'Linformatien Logo' ); ?>
					</div>
					<div class="logo-grid__box">
						<?php LF_Utils::display_responsive_images( 90425, 'full', '600px', 'svg-image logo-grid__image', 'lazy', 'Linux Magzin Logo' ); ?>
					</div>
					<div class="logo-grid__box">
						<?php LF_Utils::display_responsive_images( 90426, 'full', '600px', 'svg-image logo-grid__image', 'lazy', 'Programmez Logo' ); ?>
					</div>
					<div class="logo-grid__box">
						<?php LF_Utils::display_responsive_images( 90439, 'full', '600px', 'svg-image logo-grid__image', 'lazy', 'SDX Central Logo' ); ?>
					</div>
					<div class="logo-grid__box">
						<?php LF_Utils::display_responsive_images( 90427, 'full', '600px', 'svg-image logo-grid__image', 'lazy', 'SiliconAngle Logo' ); ?>
					</div>
					<div class="logo-grid__box">
						<?php LF_Utils::display_responsive_images( 90428, 'full', '600px', 'svg-image logo-grid__image', 'lazy', 'TechTarget Logo' ); ?>
					</div>
					<div class="logo-grid__box">
						<?php LF_Utils::display_responsive_images( 90429, 'full', '600px', 'svg-image logo-grid__image', 'lazy', 'Techzine Logo' ); ?>
					</div>
					<div class="logo-grid__box">
						<?php LF_Utils::display_responsive_images( 90430, 'full', '600px', 'svg-image logo-grid__image', 'lazy', 'TFIR Logo' ); ?>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">Industry Analyst Coverage Highlights</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="quote-with-name-container">
					<p
						class="quote-with-name-container__quote">#kubecon2023 Omdia on the way back from two full days at a great non vendor event. The future of cloud native is now living up to its promise, the ecosystem has matured and the audience is now looking at more aspects of running K8s in production. The takeaway is that platform engineering is now the hot topic.</p>
					<div class="quote-with-name-container__marks">
						<p
							class="quote-with-name-container__name">Roy Illsley</p>
						<p class="quote-with-name-container__position">Omdia</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<div class="quote-with-name-container">
					<p
						class="quote-with-name-container__quote">There is a lot more to say about this conference, but the key take-away for manufacturers is that Kubernetes and its ecosystem is no longer only about IT. It's about OT as well.</p>
					<div class="quote-with-name-container__marks">
						<p
							class="quote-with-name-container__name">Harry Forbes</p>
						<p
							class="quote-with-name-container__position">ARC Advisory Group</p>
					</div>
				</div>

				<div class="shadow-hr"></div>
				<div class="section-14__links">
					<p>Michael Azoff, Omdia - <a href="https://omdia.tech.informa.com/OM030310/Kubernetes-maturity-and-other-highlights-at-KubeCon-Amsterdam-2023">Kubernetes maturity and other highlights at KubeCon Amsterdam 2023</a></p>
					<p>Charlotte Dunlap, Global Data - <a href="https://itconnection.wordpress.com/2023/05/02/kubecon-eu-modernizing-it-operations-through-genai/">KubeCon EU: Modernizing IT Operations Through GenAI</a></p>
					<p>William Fellows, 451 Research - <a href="https://clients.451research.com/reports/202306?searchTerms=kubecon">Solo.io's Gloo Fabric aims to offer a holistic approach to application networking</a></p>
					<p>William Fellows, 451 Research - <a href="https://clients.451research.com/reports/202305?searchTerms=kubecon">Isovalent aggregates components, extends from Kubernetes to multicloud, bare metal</a></p>
					<p>Al Gillen, IDC - <a href="https://www.idc.com/getdoc.jsp?containerId=lcUS50602023&pageType=PRINTFRIENDLY">KubeCon Europe 2023 Highlights Linux Foundation's Expansion into Europe</a></p>
					<p>Krista Macomber, Futurum - <a href="https://futurumresearch.com/research-notes/open-versus-closed-source-what-is-the-state-of-kubernetes-protection">Open Versus Closed Source: What is the State of Kubernetes Protection?</a></p>
				</div>

				<button class="button-reset section-14__button"
					data-id="js-hidden-section-trigger-open">
					See Full List
					<?php LF_Utils::get_svg( $report_folder . 'arrow-down.svg' ); ?>
				</button>

				<div class="section-14__hidden-section"
					data-id="js-hidden-section">

					<div class="section-14__hidden-section-content">

						<p>Steven Dickens, Futurum - <a href="https://futurumresearch.com/research-notes/gitlab-and-oracle-partner-to-accelerate-ai-ml-development/">GitLab and Oracle Partner to Accelerate AI/ML Development</a></p>
						<p>Steven Dickens, Futurum - <a href="https://futurumresearch.com/research-notes/vmware-doubles-down-on-cross-cloud-services/">VMware Doubles Down on Cross-Cloud Services</a></p>
						<p>Camberley Bates, Futurum - <a href="https://d2iq.com/blog/kubecon-europe-2023-platform-engineering">KubeCon Europe 2023 Highlights Kubernetes Explosion and Need for Instant Platform Engineering</a></p>
						<p>Steven Dickens, Futurum - <a href="https://futurumresearch.com/research-notes/kubecon-2023-suse-launches-rancher-2-7-2-latest-version-of-rancher/">KubeCon 2023: SUSE Launches Rancher 2.7.2, Latest Version of Rancher</a></p>
						<p>Jon Collins, GigaOm - <a href="https://gigaom.com/2023/05/03/touchpoints-coalescence-and-multi-platform-engineering-thoughts-from-kubecon-2023/">Touchpoints, coalescence and multi-platform engineering — thoughts from Kubecon 2023</a></p>
						<p>Torsten Volk, EMA - <a href="https://faun.pub/opentelemetry-the-star-of-kubecon-2023-c1e2b504850d">OpenTelemetry: The Star of KubeCon 2023</a></p>
						<p>Larry Carvalho, Robustcloud - <a href="https://robustcloud.com/embracing-the-future-generative-ai-and-wasm/">Embracing the Future: Generative AI and Web Assembly (Wasm) Innovations at KubeCon CloudNativeCon EU 2023</a></p>
						<p>Sanjeev Mohan, SanjMo - <a href="https://www.youtube.com/watch?v=_txmAX5mTxA">It Depends: Gabriele Bartolini, EDB demystifies data on Kubernetes concepts</a></p>
						<p>Sanjeev Mohan, SanjMo - <a href="https://www.youtube.com/watch?v=N1CHs7E6dkY">Sanjeev Mohan, Matt Butcher, Fermyon and Justin Cormack | KubeCon CloudNativeCon EU 2023</a></p>
						<p>Jon Brown, ESG - <a href="https://www.techtarget.com/searchitoperations/opinion/At-KubeCon-2023-observability-and-FinOps-high-on-the-agenda">At KubeCon 2023, observability and FinOps high on the agenda</a></p>
						<p>Paul Nashawaty, ESG - <a href="https://www.techtarget.com/searchitoperations/opinion/Takeaways-and-emerging-trends-from-KubeCon-Europe-2023">Takeaways and emerging trends from KubeCon Europe 2023</a></p>
						<p>Brent Ellis, Andrew Cornwall, Forrester - <a href="https://www.forrester.com/blogs/what-is-wasm-and-why-it-matters-to-the-enterprise-part-1-2/?ref_search=0_1683585373775">What Is WASM, And Why Does It Matter To The Enterprise? (Part 1 Of 2)</a></p>
						<p>Brent Ellis, Andrew Cornwall, Forrester - <a href="https://www.forrester.com/blogs/what-is-wasm-and-why-it-matters-to-the-enterprise-part-2-2/?ref_search=0_1683585373775">What Is WASM, And Why Does It Matter To The Enterprise? (Part 2 Of 2)</a></p>
						<p>Brent Ellis,  Forrester - <a href="https://www.forrester.com/blogs/taking-webassembly-wasm-to-the-enterprise-and-beyond/?ref_search=0_1683585422060">Taking WebAssembly/WASM To The Enterprise And Beyond</a></p>
						<p>Lee Sustar, Forrester - <a href="https://www.forrester.com/report/selecting-your-kubernetes-strategy/RES179211?ref_search=0_1683669328173">Selecting Your Kubernetes Strategy</a></p>
						<p>Rob Strechay ESG - <a href="https://siliconangle.com/2023/05/02/reflections-kubecon-cloudnativecon-eu/">Reflections on Kubecon + CloudNativeCon EU</a></p>
						<p>Ameer Gaili, Analysys Mason - <a href="https://www.analysysmason.com/research/content/articles/kubecon-cloud-automation-rma16-rma14-rma21/">KubeCon 2023: telcos increasingly turn to open-source solutions to unlock cloud-native network benefits</a></p>
						<p>Jason Bloomberg, Intellyx - <a href="https://www.youtube.com/watch?v=QqXKC9-T6s8">KubeCon CloudNativeCon EU 2023 - Jason Bloomberg - YouTube</a></p>
						<p>Jason Bloomberg, Intellyx - <a href="https://siliconangle.com/2023/04/22/plenty-gas-innovations-continue-apace-first-post-pandemic-kubecon/">Plenty of gas: Innovations continue apace at the first post-pandemic KubeCon</a></p>
						<p>Jason Bloomberg, Intellyx - <a href="https://intellyx.com/2023/04/22/cloudfabrix-adding-an-observability-data-modernization-service/">CloudFabrix: Adding an Observability Data Modernization Service</a></p>
						<p>Jason Bloomberg, Intellyx - <a href="https://intellyx.com/2023/04/22/direktiv-automating-infrastructure-integration-processes-with-knative/">Direktiv: Automating Infrastructure Integration Processes with Knative</a></p>
						<p>Jason Bloomberg, Intellyx - <a href="https://intellyx.com/2023/04/22/observiq-observability-pipeline-built-for-opentelemetry-now-in-the-cloud/">ObservIQ: Observability Pipeline Built for OpenTelemetry, Now in the Cloud</a></p>
						<p>Jason Bloomberg, Intellyx - <a href="https://intellyx.com/2023/04/22/perfectscale-right-sizing-kubernetes-clusters-for-governance-and-cost-savings/">PerfectScale: Right-Sizing Kubernetes Clusters for Governance and Cost Savings</a></p>
						<p>Jason Bloomberg, Intellyx - <a href="https://intellyx.com/2023/04/22/traefik-cloud-native-api-management-and-service-mesh/">Traefik: Cloud Native API Management and Service Mesh</a></p>
						<p>Jason Bloomberg, Intellyx - <a href="https://intellyx.com/2023/04/22/netris-virtual-private-cloud-across-multiple-clouds-on-prem-and-edge/">Netris: Virtual Private Cloud across Multiple Clouds, On-Prem, and Edge</a></p>
						<p>Jason Bloomberg, Intellyx - <a href="https://intellyx.com/2023/04/22/ksoc-real-time-kubernetes-security-operations-center/">KSOC: Real-Time Kubernetes Security Operations Center</a></p>
						<p>Jason Bloomberg, Intellyx - <a href="https://intellyx.com/2023/04/22/slim-ai-generating-sboms-when-slimming-containers/">Slim.ai: Generating SBOMs when Slimming Containers</a></p>

					</div>
				</div>

				<button
					class="button-reset section-14__button section-14__button-close"
					style="display: none;"
					data-id="js-hidden-section-trigger-close">
					<?php LF_Utils::get_svg( $report_folder . 'arrow-up.svg' ); ?>
					Close Full List
				</button>

				<div aria-hidden="true" class="report-spacer-120"></div>

			</div>
		</section>

		<!-- SPONSORS 8/8  -->
		<section id="sponsors"
			class="section-15 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">Sponsor<br> Information</h2>
					<div class="section-number">8/8</div>
				</div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p
							class="opening-paragraph">KubeCon + CloudNativeCon would not be possible without the support of our wonderful sponsors. And attendees agree - 89% visited the Solutions Showcase during the event. </p>
					</div>
				</div>

				<div class="kccnc-table-container">
					<table class="kccnc-table booth">
						<thead>
							<tr>
								<th>Booth Traffic</th>
								<th>Total</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Onsite leads total</td>
								<td>94,587</td>
							</tr>
							<tr>
								<td>Onsite leads average/booth</td>
								<td>446</td>
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
								<th>2023
									<span>Amsterdam</span>
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
								<td>7*</td>
							</tr>
							<tr>
								<td>Platinum</td>
								<td>4</td>
								<td>7</td>
								<td>15</td>
								<td>7</td>
								<td>8</td>
								<td>17</td>
								<td>18</td>
							</tr>
							<tr>
								<td>Gold</td>
								<td>7</td>
								<td>7</td>
								<td>14</td>
								<td>8</td>
								<td>12</td>
								<td>18</td>
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
								<td>111</td>
							</tr>
							<tr>
								<td class="nowrap">Start-up</td>
								<td>13</td>
								<td>25</td>
								<td>53</td>
								<td>26</td>
								<td>28</td>
								<td>49</td>
								<td>63</td>
							</tr>
							<tr>
								<td class="nowrap">End User</td>
								<td>N/A</td>
								<td>N/A</td>
								<td>3</td>
								<td>3</td>
								<td>2</td>
								<td>2</td>
								<td>1</td>
							</tr>
							<tr>
								<td>Marketing Opportunities</td>
								<td>8</td>
								<td>19</td>
								<td>27</td>
								<td>17</td>
								<td>25</td>
								<td>44</td>
								<td>45</td>
							</tr>
							<tr>
								<td>Total Unique</td>
								<td>47</td>
								<td>96</td>
								<td>146</td>
								<td>87</td>
								<td>102</td>
								<td>189</td>
								<td>221</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div aria-hidden="true" class="report-spacer-20"></div>

				<span>* Capped Maximum</span>

				<div class="shadow-hr"></div>

				<p class="sub-header"
					style="margin:auto; text-align:center">Diamond Sponsors</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="sponsors-logos largest odd orphan-by-3 orphan-by-6">
					<div class="sponsors-logo-item"><a
							href="https://aws-kubecon-eu.splashthat.com/"
							title="Go to aws-kceu23" target="_blank"
							rel="noopener" data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="400" height="245"
								src="https://events.linuxfoundation.org/wp-content/uploads/amazon-web-services-spn.svg"
								class="logo wp-post-image" alt="aws-kceu23 logo"
								decoding="async" loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://www.huawei.com/" title="Go to Huawei"
							target="_blank" rel="noopener"
							data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="241" height="245"
								src="https://events.linuxfoundation.org/wp-content/uploads/2020/02/Huawei.svg"
								class="logo wp-post-image" alt="Huawei logo"
								decoding="async" loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://azure.microsoft.com/en-us/overview/kubernetes-on-azure/"
							title="Go to Microsoft_Azure_KubeCon"
							target="_blank" rel="noopener"
							data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="400" height="245"
								src="https://events.linuxfoundation.org/wp-content/uploads/microsoft-azure-spn.svg"
								class="logo wp-post-image"
								alt="Microsoft_Azure_KubeCon logo"
								decoding="async" loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://outshift.com/"
							title="Go to Outshift by Cisco"
							style="-webkit-transform: scale(1.1); -ms-transform: scale(1.1); transform: scale(1.1);"
							target="_blank" rel="noopener"
							data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="765" height="332"
								src="https://events.linuxfoundation.org/wp-content/uploads/2022/07/outshift_bycisco.svg"
								class="logo wp-post-image"
								alt="Outshift by Cisco logo" decoding="async"
								loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://www.suse.com/products/suse-rancher/"
							title="Go to rancher by suse"
							style="-webkit-transform: scale(0.99); -ms-transform: scale(0.99); transform: scale(0.99);"
							target="_blank" rel="noopener"
							data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="146" height="35"
								src="https://events.linuxfoundation.org/wp-content/uploads/2020/01/rancher-suse-logo-horizontal_horizontal-color.svg"
								class="logo wp-post-image"
								alt="rancher by suse logo" decoding="async"
								loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://www.redhat.com/"
							title="Go to Red Hat Logo" target="_blank"
							rel="noopener" data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="400" height="245"
								src="https://events.linuxfoundation.org/wp-content/uploads/RedHat-new.svg"
								class="logo wp-post-image"
								alt="Red Hat Logo logo" decoding="async"
								loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://www.veritas.com/"
							title="Go to Veritas" target="_blank" rel="noopener"
							data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="408" height="92"
								src="https://events.linuxfoundation.org/wp-content/uploads/2020/09/Veritas-01.svg"
								class="logo wp-post-image" alt="Veritas logo"
								decoding="async" loading="lazy"></a></div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header"
					style="margin:auto; text-align:center">Platinum Sponsors</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="sponsors-logos larger even">
					<div class="sponsors-logo-item"><a href="https://ubuntu.com"
							title="Go to canonical" target="_blank"
							rel="noopener" data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="400" height="245"
								src="https://events.linuxfoundation.org/wp-content/uploads/canonical-spn.svg"
								class="logo wp-post-image" alt="canonical logo"
								decoding="async" loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://www.datadoghq.com/"
							title="Go to datadog" target="_blank" rel="noopener"
							data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="400" height="245"
								src="https://events.linuxfoundation.org/wp-content/uploads/datadog-spn.svg"
								class="logo wp-post-image" alt="datadog logo"
								decoding="async" loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://www.delltechnologies.com/"
							title="Go to dell"
							style="-webkit-transform: scale(1.3); -ms-transform: scale(1.3); transform: scale(1.3);"
							target="_blank" rel="noopener"
							data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="400" height="245"
								src="https://events.linuxfoundation.org/wp-content/uploads/dell-spn.svg"
								class="logo wp-post-image" alt="dell logo"
								decoding="async" loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://about.gitlab.com/"
							title="Go to gitlab" target="_blank" rel="noopener"
							data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="721" height="177"
								src="https://events.linuxfoundation.org/wp-content/uploads/2020/01/gitlab-logo-rgb.svg"
								class="logo wp-post-image" alt="gitlab logo"
								decoding="async" loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://cloud.google.com/"
							title="Go to Google Cloud"
							style="-webkit-transform: scale(1.1); -ms-transform: scale(1.1); transform: scale(1.1);"
							target="_blank" rel="noopener"
							data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="3016" height="626"
								src="https://events.linuxfoundation.org/wp-content/uploads/2020/06/lockup_GoogleCloud_FullColor_rgb_2900x512px.svg"
								class="logo wp-post-image"
								alt="Google Cloud logo" decoding="async"
								loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://www.ibm.com/us-en/"
							title="Go to ibm-horizontal-color"
							style="-webkit-transform: scale(0.7); -ms-transform: scale(0.7); transform: scale(0.7);"
							target="_blank" rel="noopener"
							data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="441" height="175"
								src="https://events.linuxfoundation.org/wp-content/uploads/2020/01/IBM_logo┬_pos_blue60_CMYK.svg"
								class="logo wp-post-image"
								alt="ibm-horizontal-color logo" decoding="async"
								loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://incident.io/" title="Go to incident"
							target="_blank" rel="noopener"
							data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="1038" height="293"
								src="https://events.linuxfoundation.org/wp-content/uploads/2023/01/logo-colour-dark.svg"
								class="logo wp-post-image" alt="incident logo"
								decoding="async" loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://www.intel.com/content/www/us/en/developer/topic-technology/open/overview.html"
							title="Go to intel"
							style="-webkit-transform: scale(0.6); -ms-transform: scale(0.6); transform: scale(0.6);"
							target="_blank" rel="noopener"
							data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="338" height="139"
								src="https://events.linuxfoundation.org/wp-content/uploads/2020/01/intel-01.svg"
								class="logo wp-post-image" alt="intel logo"
								decoding="async" loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a href="https://jfrog.com/"
							title="Go to jfrog" target="_blank" rel="noopener"
							data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="400" height="245"
								src="https://events.linuxfoundation.org/wp-content/uploads/jfrog-spn.svg"
								class="logo wp-post-image" alt="jfrog logo"
								decoding="async" loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://www.kasten.io/"
							title="Go to Kasten by Veeam - KubeCon"
							style="-webkit-transform: scale(0.9); -ms-transform: scale(0.9); transform: scale(0.9);"
							target="_blank" rel="noopener"
							data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="254" height="101"
								src="https://events.linuxfoundation.org/wp-content/uploads/2021/03/Kasten-logo-2022.svg"
								class="logo wp-post-image"
								alt="Kasten by Veeam - KubeCon logo"
								decoding="async" loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://opensource.mercedes-benz.com/"
							title="Go to Mercedes-Benz" target="_blank"
							rel="noopener" data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="382" height="77"
								src="https://events.linuxfoundation.org/wp-content/uploads/2023/02/Mercedes-Benz-Logo.svg"
								class="logo wp-post-image"
								alt="Mercedes-Benz logo" decoding="async"
								loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://opensearch.org/"
							title="Go to OpenSearch" target="_blank"
							rel="noopener" data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="386" height="85"
								src="https://events.linuxfoundation.org/wp-content/uploads/2022/03/SVG-Logo.svg"
								class="logo wp-post-image" alt="OpenSearch logo"
								decoding="async" loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://portworx.com/"
							title="Go to Portworx by Pure Storage"
							target="_blank" rel="noopener"
							data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="406" height="158"
								src="https://events.linuxfoundation.org/wp-content/uploads/2020/10/portworx-by-purestorage-01.svg"
								class="logo wp-post-image"
								alt="Portworx by Pure Storage logo"
								decoding="async" loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://www.paloaltonetworks.com/prisma/cloud"
							title="Go to Prisma Cloud by Palo Alto Networks"
							style="-webkit-transform: scale(1.25); -ms-transform: scale(1.25); transform: scale(1.25);"
							target="_blank" rel="noopener"
							data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="1626" height="262"
								src="https://events.linuxfoundation.org/wp-content/uploads/2021/12/Palo_Alto_Prisma_Cloud_logo_RGB_Horizontal.svg"
								class="logo wp-post-image"
								alt="Prisma Cloud by Palo Alto Networks logo"
								decoding="async" loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a href="https://snyk.io/"
							title="Go to snyk" target="_blank" rel="noopener"
							data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="400" height="245"
								src="https://events.linuxfoundation.org/wp-content/uploads/Snyk-spn.svg"
								class="logo wp-post-image" alt="snyk logo"
								decoding="async" loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://sysdig.com/" title="Go to sysdig"
							target="_blank" rel="noopener"
							data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="400" height="245"
								src="https://events.linuxfoundation.org/wp-content/uploads/sysdig-spn.svg"
								class="logo wp-post-image" alt="sysdig logo"
								decoding="async" loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://goteleport.com/"
							title="Go to Teleport" target="_blank"
							rel="noopener" data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="187" height="45"
								src="https://events.linuxfoundation.org/wp-content/uploads/2021/03/teleport-kcsp.svg"
								class="logo wp-post-image" alt="Teleport logo"
								decoding="async" loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://tanzu.vmware.com/"
							title="Go to vmware" target="_blank" rel="noopener"
							data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="400" height="245"
								src="https://events.linuxfoundation.org/wp-content/uploads/vmware-spn.svg"
								class="logo wp-post-image" alt="vmware logo"
								decoding="async" loading="lazy"></a></div>
				</div>

				<div class="shadow-hr"></div>

				<div class="wp-block-button"><a
						href="https://events.linuxfoundation.org/kubecon-cloudnativecon-europe/sponsor-list/"
						title="See all Sponsors and Partners of KubeCon + CloudNativeCon Europe 2023"
						class="wp-block-button__link">See
						all Sponsors and Partners</a>
				</div>

				<div class="shadow-hr"></div>

				<div class="video">
					<h2 class="video__title">Video Highlights</h2>

					<div aria-hidden="true" class="report-spacer-60">
					</div>

					<div class="wp-block-lf-youtube-lite">
						<lite-youtube videoid="tBDK_AYGv-k"
							videotitle="Highlights from KubeCon + CloudNativeCon Europe 2023"
							webpStatus="1" sdthumbStatus="0"
							title="Play Highlights">
						</lite-youtube>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-120"></div>

			</div>
		</section>

		<section class="section-16 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="lf-grid thanks">
					<div class="thanks__col1">
						<h2 class="section-header">Thank You</h2>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<p
							class="thanks__opening">We hope you enjoyed reflecting on a great event in Amsterdam - let's do it again soon!</p>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<p
							class="thanks__comments">Your comments and feedback are welcome at <a href="mailto:events@cncf.io">events@cncf.io</a></p>

						<div aria-hidden="true" class="report-spacer-80"></div>

						<p>Check out our <a href="https://community.cncf.io/">calendar for community events near you</a> and don't forget to <a href="https://events.linuxfoundation.org/kubecon-cloudnativecon-north-america/">register for KubeCon + CloudNativeCon + Open Source Summit China</a> in Shanghai, 26 - 28 September, 2023, and <a href="https://events.linuxfoundation.org/kubecon-cloudnativecon-north-america/">KubeCon + CloudNativeCon North America</a> in Chicago, 6 - 9 November 2023.</p>
					</div>
					<div class="thanks__col2">
						<?php
							LF_Utils::display_responsive_images( 90431, 'full', '400px', null, 'lazy', 'CNCF Mascot' );
						?>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<?php
				get_template_part( 'components/social-share' );
				?>
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

// load masonry.
wp_enqueue_script( 'masonry', get_template_directory_uri() . '/source/js/libraries/masonry.min.js', array( 'jquery' ), filemtime( get_template_directory() . '/source/js/libraries/masonry.min.js' ), true );

// custom scripts.
wp_enqueue_script(
	'kccnc-eu-23-report',
	get_template_directory_uri() . '/source/js/on-demand/kccnc-eu-23-report.js',
	array( 'jquery', 'slick' ),
	filemtime( get_template_directory() . '/source/js/on-demand/kccnc-eu-23-report.js' ),
	true
);

get_template_part( 'components/footer' );
