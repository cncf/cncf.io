<?php
/**
 * Template Name: KCCNC OSS 23 Transparency
 * Template Post Type: lf_report
 *
 * File for the KCCNC OSS CN 2023 Transparency Report
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
$report_folder = 'reports/kccnc-oss-23/'

?>

<link rel="prefetch"
	href="<?php echo esc_url( get_template_directory_uri() . '/build/kccnc-oss-23-transparency.min.css' ); ?>"
	as="style" crossorigin="anonymous" />

<?php wp_enqueue_style( 'kccnc-oss-23', get_template_directory_uri() . '/build/kccnc-oss-23-transparency.min.css', array(), filemtime( get_template_directory() . '/build/kccnc-oss-23-transparency.min.css' ), 'all' ); ?>

<main class="kccnc-oss-23">
	<article class="container wrap">

		<section class="hero alignfull background-image-wrapper">
			<figure class="background-image-figure swirl">
				<?php
					LF_Utils::display_responsive_images( 98536, 'full', '1200px', null, 'eager', 'Swirl illustration' );
				?>
			</figure>
			<figure class="background-image-figure skyline">
				<picture>
					<source media="(max-width: 599px)"
						srcset="<?php echo esc_url( wp_get_attachment_image_url( 98535, 'full', false ) ); ?>">
					<source media="(min-width: 600px)"
						srcset="<?php echo esc_url( wp_get_attachment_image_url( 98534, 'full', false ) ); ?>">
					<?php
							LF_Utils::display_responsive_images(
								98534,
								'full',
								'1200px',
								null,
								'eager',
								'An illustration of the Shangahi city skyline.'
							);
							?>
				</picture>
			</figure>

			<div class="background-image-text-overlay">
				<div class="container wrap hero__container">
					<div class="hero__wrapper">
						<img class="hero__logo"
							src="<?php LF_Utils::get_svg( $report_folder . 'logo-kccnc-oss-23.svg', true ); ?>"
							width="204" height="132"
							alt="KubeCon + CloudNativeCon + Open Source Summit China 2023 Logo"
							loading="eager"
							decoding="async"
							>
						<h1 class="hero__title uppercase">Transparency
							<br />Report
						</h1>

						<div class="hero__hr"></div>

						<div class="hero__button-share-align">

							<?php
							get_template_part( 'components/social-share' );
							?>

							<div class="wp-block-button hero__button"><a
									href="#" class="wp-block-button__link"
									title="中文版">中文版</a>
							</div>

						</div>

					</div>
				</div>
			</div>
		</section>

		<!-- Intro  -->
		<section class="section-01">

			<div class="lf-grid">
				<h2 class="section-01__title">你好 Shanghai!</h2>
			</div>

			<div class="lf-grid section-01__grid">
				<div class="section-01__grid-col1">
					<p>It took a few years longer than we'd hoped, but it was fantastic to finally bring our China community together in Shanghai for KubeCon + CloudNativeCon + Open Source Summit China 2023. And it was important to us that we could make this happen, because China is a key player in the cloud native ecosystem. </p>

					<p>China contributes more to CNCF projects than any other country apart from the USA - accounting for an incredible 9% of all contributions since the CNCF was founded in 2015. In fact, this year 12% of cloud native open source contributions to the CNCF came from China-based maintainers and organizations. Plus, 32 CNCF projects originated in China, including graduated projects like Harbor and TiKV.</p>

					<p>For me personally, it was an opportunity to reconnect in person with maintainers and contributors who are shaping the future of cloud native technology. It was inspiring to learn about cloud native at China scale, and how the initiatives you are driving are changing the way that software is built - from powering AI workloads and accelerating AI applications, to large-scale, financial-grade engineering practices.</p>

					<p>There is much to unpack from this insightful event, and I've enjoyed looking back as we put this transparency report together for you. I hope you find this information valuable.</p>

					<div class="author">
						<?php LF_Utils::display_responsive_images( 98512, 'full', '75px', null, 'lazy', 'Chris Aniszczyk' ); ?>
						<p><strong>Chris Aniszczyk</strong><br>
					CTO, CNCF</p>
					</div>
				</div>

				<div class="section-01__grid-col2">
					<h3 class="sub-header">KubeCon + CloudNativeCon + Open
						Source Summit China <br>at a glance</h3>
					<!-- Icon 1  -->
					<div class="icon-box-1">
						<div class="icon">
							<img
							loading="lazy"
							decoding="async"
							width="65"
							height="65"
							src="<?php LF_Utils::get_svg( $report_folder . 'icon-badge.svg', true ); ?>"
							alt="Badge icon"
>
						</div>
						<div class="text">
							<span>61%</span><br />
							First-time attendees
						</div>
					</div>

					<!-- Icon 2  -->
					<div class="icon-box-1">
						<div class="icon">
							<img loading="lazy" decoding="async" width="65" height="65" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-heart.svg', true ); ?>
" alt="Heart icon">
						</div>
						<div class="text">
							<span>589</span><br />
							CFPs Submitted
						</div>
					</div>

					<!-- Icon 3  -->
					<div class="icon-box-1">
						<div class="icon">
							<img loading="lazy" decoding="async" width="65" height="65" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-person.svg', true ); ?>
" alt="Person icon">
						</div>
						<div class="text">
							<span>86</span><br />
							Attendees thanks to <br class="show-over-1000">Dan
							Kohn Scholarship Fund
						</div>
					</div>

					<!-- Icon 4  -->
					<div class="icon-box-1">
						<div class="icon">
							<img loading="lazy" decoding="async" width="65" height="65" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-megaphone.svg', true ); ?>
" alt="Megaphone icon">
						</div>
						<div class="text">
							<span>184</span><br />
							Pieces of media coverage
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
						<h3 class="sub-header">Shanghai Photo Highlights</h3>
					</div>
					<div class="wp-block-column is-vertically-aligned-bottom"
						style="flex-basis:20%">
						<p
							class="has-text-align-right is-style-link-cta"><a href="https://www.flickr.com/photos/143247548@N03/albums/72177720311405294/" title="KubeCon + CloudNativeCon + Open Source Summit China 2023 Photo Gallery">See more</a></p>
					</div>
				</div>

				<div class="section-02__slider">
					<div>
						<?php LF_Utils::display_responsive_images( 98516, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon + Open Source Summit China 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 98517, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon + Open Source Summit China 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 98518, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon + Open Source Summit China 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 98519, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon + Open Source Summit China 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 98520, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon + Open Source Summit China 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 98521, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon + Open Source Summit China 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 98522, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon + Open Source Summit China 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 98523, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon + Open Source Summit China 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 98524, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon + Open Source Summit China 2023' ); ?>
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

				<div class="lf-grid">
					<div class="restrictive-10-col">
						<p
							class="opening-paragraph">It was fantastic to bring our China community together in person, with more than <strong>1900</strong> people joining us in Shanghai, and a further <strong>139</strong> logging in online to view the Keynote Livestream.</p>
					</div>
				</div>

				<p class="sub-header">Demographics</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<picture>
					<source media="(max-width: 599px)"
						srcset="<?php LF_Utils::get_svg( $report_folder . 'demographics-mobile.svg', true ); ?>">
					<source media="(min-width: 600px)"
						srcset="<?php LF_Utils::get_svg( $report_folder . 'demographics-desktop.svg', true ); ?>">
					<img loading="lazy" decoding="async" width="1200" height="404"
						src="<?php LF_Utils::get_svg( $report_folder . 'demographics-desktop.svg', true ); ?>"
						alt="Total Registered attendees 1910, 84% in person, 61% first timers.">
				</picture>

				<div class="shadow-hr"></div>

				<p class="sub-header">Attendee Geography</p>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<img loading="lazy" decoding="async" width="1200" height="404" src="<?php LF_Utils::get_svg( $report_folder . 'attendee-geography-map-desktop.svg', true ); ?>
" alt="Map of attendee geography, 89% of attendees were from China.">

				<div class="shadow-hr"></div>

				<p class="sub-header is-centered">Top Three Job Functions</p>

				<div class="lf-grid section-03__top-jobs">
					<div class="section-03__top-jobs-col1">
						<p class="table-header">Developer</p>
						<span class="large">607</span>
					</div>
					<div class="section-03__top-jobs-col2">
						<p class="table-header">Architect</p>
						<span class="large">345</span>
					</div>
					<div class="section-03__top-jobs-col3">
						<p class="table-header">DevOps / SRE / SysAdmin</p>
						<span class="large">258</span>
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
												<td>345</td>
											</tr>
											<tr>
												<td>Business Operations</td>
												<td>84</td>
											</tr>
											<tr>
												<td>Developer</td>
												<td>607</td>
											</tr>
											<tr>
												<td> - Data Scientist</td>
												<td>31</td>
											</tr>
											<tr>
												<td> - Full Stack Developer</td>
												<td>185</td>
											</tr>
											<tr>
												<td> - Machine Learning
													Specialist</td>
												<td>25</td>
											</tr>
											<tr>
												<td> - Web Developer</td>
												<td>7</td>
											</tr>
											<tr>
												<td> - Mobile Developer</td>
												<td>42</td>
											</tr>
											<tr>
												<td>DevOps / SRE / SysAdmin</td>
												<td>258</td>
											</tr>
											<tr>
												<td>Executive</td>
												<td>149</td>
											</tr>
											<tr>
												<td>IT Operations</td>
												<td>46</td>
											</tr>
											<tr>
												<td> - DevOps</td>
												<td>9</td>
											</tr>
											<tr>
												<td> - Systems Admin</td>
												<td>6</td>
											</tr>
											<tr>
												<td> - Site Reliability Engineer
												</td>
												<td>2</td>
											</tr>
											<tr>
												<td> - Quality Assurance
													Engineer</td>
												<td>2</td>
											</tr>
											<tr>
												<td>Sales / Marketing</td>
												<td>80</td>
											</tr>
											<tr>
												<td>Media / Analyst</td>
												<td>60</td>
											</tr>
											<tr>
												<td>Student</td>
												<td>69</td>
											</tr>
											<tr>
												<td>Product Manager</td>
												<td>93</td>
											</tr>
											<tr>
												<td>Professor / Academic</td>
												<td>31</td>
											</tr>
											<tr>
												<td>Other</td>
												<td>88</td>
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
												<td>85</td>
											</tr>
											<tr>
												<td>Consumer Goods</td>
												<td>31</td>
											</tr>
											<tr>
												<td>Energy</td>
												<td>23</td>
											</tr>
											<tr>
												<td>Financials</td>
												<td>104</td>
											</tr>
											<tr>
												<td>Health Care</td>
												<td>26</td>
											</tr>
											<tr>
												<td>Industrials</td>
												<td>46</td>
											</tr>
											<tr>
												<td>Information Technology</td>
												<td>1,338</td>
											</tr>
											<tr>
												<td>Materials</td>
												<td>9</td>
											</tr>
											<tr>
												<td>Non-Profit Organization</td>
												<td>64</td>
											</tr>
											<tr>
												<td>Professional Services</td>
												<td>110</td>
											</tr>
											<tr>
												<td>Telecommunications</td>
												<td>74</td>
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

				<div class="shadow-hr"></div>

				<p class="sub-header">Year On Year registration</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<img loading="lazy" decoding="async" width="1200" height="604" src="
			<?php LF_Utils::get_svg( $report_folder . 'yoy-growth-chart.svg', true ); ?>
			" alt="Chart showing year on year attendee growth">
			</div>
		</section>

		<section class="section-05">
			<div class="kccnc-table-container">
				<table class="kccnc-table growth-table">
					<thead>
						<tr>
							<th>Ticket Type</th>
							<th>2018</th>
							<th>2019</th>
							<th>2021</th>
							<th>2023</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Total</td>
							<td>2,500</td>
							<td>3,500</td>
							<td>7,160</td>
							<td>1,910</td>
						</tr>
						<tr>
							<td class="nowrap">All Access Attendee</td>
							<td>63%</td>
							<td>46%</td>
							<td>78%</td>
							<td>54%</td>
						</tr>
						<tr>
							<td class="nowrap">All Access VIP</td>
							<td>5%</td>
							<td>5%</td>
							<td>N/A</td>
							<td>3%</td>
						</tr>
						<tr>
							<td class="nowrap">All Access Individual or Academic
							</td>
							<td>5%</td>
							<td>8%</td>
							<td>N/A</td>
							<td>10%</td>
						</tr>
						<tr>
							<td>Speaker</td>
							<td>8%</td>
							<td>9%</td>
							<td>2%</td>
							<td>13%</td>
						</tr>
						<tr>
							<td>Sponsor</td>
							<td>3%</td>
							<td>22%</td>
							<td>5%</td>
							<td>11%</td>
						</tr>
						<tr>
							<td>Media</td>
							<td>10%</td>
							<td>2%</td>
							<td>&gt;1%</td>
							<td>2%</td>
						</tr>
						<tr>
							<td>Virtual Keynote</td>
							<td>N/A</td>
							<td>N/A</td>
							<td>17%</td>
							<td>7%</td>
						</tr>
					</tbody>
				</table>
			</div>

		</section>

		<section id="content"
			class="section-06 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">Content</h2>
					<div class="section-number">2/6</div>
				</div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p
							class="opening-paragraph">With 115 sessions, KubeCon + CloudNativeCon + Open Source Summit China featured a diverse line-up of topics ranging from introductory sessions through technical deep-dives. <a href="https://www.youtube.com/playlist?list=PLj6h78yzYM2OJcjIuAsbbhXAaDrAnuKRB" title="Talks from KubeCon + CloudNativeCon + Open Source Summit China 2023 on YouTube">Talks are available now on our YouTube playlist</a>.</p>
					</div>
				</div>

				<div class="kccnc-table-container">
					<table class="kccnc-table">
						<thead>
							<tr>
								<th>Content</th>
								<th>Total</th>
								<th><span class="nowrap">In-person</span></th>
								<th>Virtual</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>CFP submissions</td>
								<td>589</td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>CFP acceptance rate</td>
								<td>17%</td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>Keynotes (includes sponsored keynotes)</td>
								<td>13</td>
								<td>13</td>
								<td></td>
							</tr>
							<tr>
								<td>Breakouts</td>
								<td>85</td>
								<td>85</td>
								<td>0</td>
							</tr>
							<tr>
								<td>Maintainer Track sessions</td>
								<td>30</td>
								<td>26</td>
								<td>4</td>
							</tr>
							<tr>
								<td>Total sessions (Breakout + Maintainer)</td>
								<td>115</td>
								<td>111</td>
								<td>4</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<p
					class="sub-header">Thank you to our KubeCon + CloudNativeCon + Open Source Summit China 2023 co-chairs</p>

				<div class="lf-grid chairs">
					<div class="chairs__col1">
						<?php LF_Utils::display_responsive_images( 98513, 'full', '200px', 'chairs__image', 'lazy', 'Fog Dong' ); ?>
						<p>
<span class="chairs__name">Fog Dong
</span><span
	class="chairs__title">Senior Engineer <br/>
<strong>BentoML</strong></span>
</p>
					</div>
					<div class="chairs__col2">
						<?php LF_Utils::display_responsive_images( 98514, 'full', '200px', 'chairs__image', 'lazy', 'Kevin Wang' ); ?>
						<p>
<span class="chairs__name">Kevin Wang</span><span
class="chairs__title">Lead of Cloud Native Open Source <br/>
<strong>Huawei</strong></span></p>
					</div>

					<div class="chairs__col3">
						<?php LF_Utils::display_responsive_images( 98515, 'news-image', '482px', null, 'lazy', 'Our KubeCon + CloudNativeCon + Open Source Summit China 2023 co-chairs' ); ?>
					</div>
				</div>
			</div>
		</section>

		<div class="shadow-hr"></div>

		<section class="section-07 alignfull">
			<div class="container wrap">

				<div aria-hidden="true" class="report-spacer-40"></div>

				<h2 class="section-header-small">Content Breakdown</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-10-col">
						<p>The schedule was curated by conference co-chairs Fog Dong, Senior Engineer, BentoML; and Kevin Wang, Lead of Cloud Native Open Source, Huawei; who led a program committee of 69 experts, including project maintainers and CNCF Ambassadors.
							<br>
							<br>
							Talks are selected by the program committee through a rigorous, non-bias process, where they are randomly assigned submissions to review within their area of expertise. You can read the details in our <a href="https://www.lfasiallc.com/kubecon-cloudnativecon-open-source-summit-china/program/submission-reviewer-guidelines/">CFP scoring guidelines</a> and specifically about the <a href="https://www.cncf.io/blog/2021/03/08/a-look-inside-the-kubecon-cloudnativecon-schedule-selection-process/">selection process</a>.
							<br>
							<br>
							For KubeCon + CloudNativeCon + Open Source Summit China, 568 submissions were received. Of those, we were able to accept 115 talks with 206 total speakers - an acceptance rate of 17%.</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<p class="sub-header">Key stats</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-07__content-breakdown">

					<div class="section-07__content-breakdown-col1">

						<div class="icon-box-6">
							<div class="text">
								<span class="number">568</span><br />
								<span class="description">CFP
									<br>submissions</span>
							</div>
						</div>
					</div>
					<div class="section-07__content-breakdown-col2">

						<div class="icon-box-6">
							<div class="text">
								<span class="number">206</span><br />
								<span class="description">Speakers</span>
							</div>
						</div>
					</div>
					<div class="section-07__content-breakdown-col3">

						<div class="icon-box-6">
							<div class="text">
								<span class="number">24</span><br />
								<span class="description">End User
									<br>Talks</span>
							</div>
						</div>
					</div>
					<div class="section-07__content-breakdown-col4">

						<div class="icon-box-6">
							<div class="text">
								<span class="number">160</span><br />
								<span class="description">Vendor <br>Speakers
									<br>(Breakouts)</span>
							</div>
						</div>
					</div>
					<div class="section-07__content-breakdown-col5">

						<div class="icon-box-6">
							<div class="text">
								<span class="number">41</span><br />
								<span class="description">End User <br>Speakers
									<br>(Breakouts)</span>
							</div>
						</div>
					</div>
					<div class="section-07__content-breakdown-col6">

						<div class="icon-box-6">
							<div class="text">
								<span class="number">9.1</span><br />
								<span class="description">Sched.com Session
									Rating Out of 10</span>
							</div>
						</div>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-80"></div>


				<p class="sub-header">Captioning Usage Data</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-07__captioning">
					<div class="section-07__captioning-col1"><span
							class="large">200</span> Hours using captioning
						<br>in-person
					</div>
					<div class="section-07__captioning-col2"><span
							class="large">214</span> Attendees using <br>in-room
						captioning</div>
					<div class="section-07__captioning-col3"><span
							class="large">356</span> Hours using in-room AI
						<br>Captioning on mobile
					</div>
					<div class="section-07__captioning-col4"><span
							class="large">2</span> Languages captioned:
						<br>English & Chinese
					</div>
				</div>
			</div>
		</section>

		<div class="shadow-hr"></div>

		<section class="section-08 alignfull">
			<div class="container wrap">

				<h2 class="section-header-small">Speaker Diversity</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<p>CNCF enforces guidelines on gender and diversity equality among our speakers, including not accepting all-male panels.</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="kccnc-table-container">
					<table class="kccnc-table">
						<thead>
							<tr>
								<th>Speaker Diversity
								</th>
								<th>Overall</th>
								<th>Percent</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Women + gender non-conforming
									(keynotes)</td>
								<td>5</td>
								<td>35%</td>
							</tr>
							<tr>
								<td>Men (keynotes)</td>
								<td>9</td>
								<td>65%</td>
							</tr>
							<tr>
								<td>Women + gender non-conforming
									(breakouts)</td>
								<td>40</td>
								<td>21%</td>
							</tr>
							<tr>
								<td>Men (breakouts)</td>
								<td>153</td>
								<td>79%</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div class="shadow-hr"></div>

				<h2 class="section-header-small">Dan Kohn Scholarship Fund</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<p>The Dan Kohn Scholarship Fund provided opportunities to <strong>86</strong> applicants, including diversity, needs-based, maintainers, and speakers, to attend in person.</p>

				<div class="lf-grid section-08__scholarships">
					<div class="section-08__scholarships-col1">
						<p
							class="table-header">Travel Funding <br>Scholarships</p>
						<span class="large">27</span>
					</div>
					<div class="section-08__scholarships-col2">
						<p
							class="table-header">Registration <br>Scholarships</p>
						<span class="large">39</span>
					</div>
					<div class="section-08__scholarships-col3">
						<p class="table-header">Speaker <br>Scholarships</p>
						<span class="large">20</span>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<p><a href="https://events.linuxfoundation.org/kubecon-cloudnativecon-europe/attend/scholarships/">Apply for a scholarship</a> to join us at KubeCon + CloudNativeCon Europe 2024.</p>

				<div aria-hidden="true" class="report-spacer-120"></div>
			</div>
		</section>

		<section id="colocated"
			class="section-09 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">Co-Located <Br />
						Events</h2>
					<div class="section-number">3/6</div>
				</div>

				<div class="lf-grid">
					<div class="restrictive-10-col">
						<p
							class="opening-paragraph">Co-located with KubeCon + CloudNativeCon + Open Source Summit China on September 26, CNCF hosted <a href="https://www.lfasiallc.com/kubecon-cloudnativecon-open-source-summit-china/co-located-events/istiocon/">IstioCon</a> - an event dedicated to the leading service mesh in the industry, offering a platform to explore insights drawn from real-world Istio deployments, interactive hands-on activities, and opportunities to connect with maintainers spanning the entire Istio ecosystem.</p>
					</div>
				</div>

				<div class="lf-grid section-09__colo">
					<div class="section-09__colo-col1">
						<p>Alongside, sponsors hosted four co-located events:</p>

						<ul>
							<li>Cloud Native Open Day, hosted by Alibaba Cloud
							</li>
							<li>GOSIM: Global Open Source Innovation Meetup
							</li>
							<li>ONE Summit Regional Day, hosted by LF Networking
								and LF Edge</li>
							<li>OpenJS World, hosted by the OpenJS Foundation
							</li>
						</ul>
					</div>
					<div class="section-09__colo-col2">
						<p class="sub-header">Key Stats</p>
						<div class="icon-box-6">
							<div class="text">
								<span class="number">1</span><br />
								<span class="description">CNCF-Hosted
									<br>Co-Lo</span>
							</div>
						</div>
					</div>
					<div class="section-09__colo-col3">
						<p class="sub-header">&nbsp;</p>
						<div class="icon-box-6">
							<div class="text">
								<span class="number">4</span><br />
								<span class="description">Sponsor-<br>
									hosted Co-Los</span>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div aria-hidden="true" class="report-spacer-120"></div>

		</section>

		<section id="dei" class="section-11 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">Diversity + Equity + Inclusion
					</h2>
					<div class="section-number">4/6</div>
				</div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p
							class="opening-paragraph">CNCF strives to ensure that everyone who participates in KubeCon + CloudNativeCon feels welcome, regardless of gender, gender identity, sexual orientation, disability, race, ethnicity, age, religion, or economic status.</p>
					</div>
				</div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>Our commitment to cultivating a friendly, welcoming, and inclusive environment extends to the facilities and resources we provide at events. In Shanghai, these included:</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid incl">
					<div class="incl-col1">
						<div class="icon-box-5">
							<div class="icon-box-5__icon"><img loading="lazy" decoding="async"
									width="100" height="100"
									src="<?php LF_Utils::get_svg( $report_folder . 'icon-mute.svg', true ); ?>"
									alt="Mute icon">
							</div>
							<div class="icon-box-5__text">Quiet Rooms
							</div>
						</div>
						<div class="icon-box-5">
							<div class="icon-box-5__icon"><img loading="lazy" decoding="async"
									width="100" height="100"
									src="<?php LF_Utils::get_svg( $report_folder . 'icon-mixed-gender.svg', true ); ?>"
									alt="Mixed gender icon">
							</div>
							<div class="icon-box-5__text">All Gender Restrooms
							</div>
						</div>
					</div>
					<div class="incl-col2">
						<div class="icon-box-5">
							<div class="icon-box-5__icon"><img loading="lazy"
									width="100" height="100"
									src="<?php LF_Utils::get_svg( $report_folder . 'icon-pacifier.svg', true ); ?>"
									alt="Pacifier icon">
							</div>
							<div class="icon-box-5__text">Baby Care &amp;
								<br>Nursing Rooms
							</div>
						</div>

						<div class="icon-box-5">
							<div class="icon-box-5__icon"><img loading="lazy" decoding="async"
									width="100" height="100"
									src="<?php LF_Utils::get_svg( $report_folder . 'icon-sticky-note.svg', true ); ?>"
									alt="Sticky note icon">
							</div>
							<div class="icon-box-5__text">Pronoun &
								<br>Communication Stickers
							</div>
						</div>
					</div>
					<div class="incl-col3">
						<div class="icon-box-5">
							<div class="icon-box-5__icon"><img loading="lazy" decoding="async"
									width="100" height="100"
									src="<?php LF_Utils::get_svg( $report_folder . 'icon-child-blocks.svg', true ); ?>"
									alt="Toy blocks icon">
							</div>
							<div class="icon-box-5__text">Complimentary
								<br>Onsite Child Care
							</div>
						</div>

						<div class="icon-box-5">
							<div class="icon-box-5__icon"><img loading="lazy" decoding="async"
									width="100" height="100"
									src="<?php LF_Utils::get_svg( $report_folder . 'icon-closed-captions.svg', true ); ?>"
									alt="Closed caption icon">
							</div>
							<div class="icon-box-5__text">Captioning available
								<br>for keynote and <br>breakout sessions
							</div>
						</div>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>As part of our deep commitment to diversity, equity and inclusivity, we also hosted EmpowerUs - a networking break for attendees who identify as women, non-binary individuals, or allies, to have open discussions with fellow attendees about challenges, leadership innovation, and empowerment in our fast-growing ecosystem.</p>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<div class="lf-grid">
					<div class="dei__col-1">
						<div class="kccnc-table-container">
							<table class="kccnc-table dei__table">
								<thead>
									<tr>
										<th>Diversity, Equity & Inclusivity
											Events
											and
											Mentoring
										</th>
										<th>Total</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Attendees - identifies as a person
											of color</td>
										<td>1,077</td>
									</tr>
									<tr>
										<td>Attendees - age 0-19</td>
										<td>112</td>
									</tr>
									<tr>
										<td>Travel funding scholarships</td>
										<td>27</td>
									</tr>
									<tr>
										<td>Registration scholarships</td>
										<td>39</td>
									</tr>
									<tr>
										<td>Speaker scholarships</td>
										<td>20</td>
									</tr>
									<tr>
										<td>EmpowerUs participants</td>
										<td>15</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>

					<div class="dei__col-2">
						<p class="sub-header">Gold CHAOSS D&I Event Badge</p>
						<div aria-hidden="true" class="report-spacer-40"></div>
						<?php LF_Utils::display_responsive_images( 90434, 'full', '320px', 'svg-image badge', 'lazy', 'Gold CHAOSS D&I Event Badge' ); ?>
						<div aria-hidden="true" class="report-spacer-40"></div>
						<p>Awarded to events in the open source community that foster healthy D&I practices.</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-120"></div>

				<p
					class="sub-header has-lines">Our Next Kubecon + CloudNativeCon</p>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<?php echo do_shortcode( '[event_banner hide_title=true]' ); ?>

			</div>
		</section>

		<section id="media" class="section-14 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">Media & Analyst<br> Coverage</h2>
					<div class="section-number">5/6</div>
				</div>

				<p class="sub-header">Key Stats</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-14__coverage">

					<div class="section-14__coverage-col1">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" decoding="async" width="49" height="55" src="<?php LF_Utils::get_svg( $report_folder . 'icon-share.svg', true ); ?>
" alt="Share icon">
							</div>
							<div class="text">
								<span class="number">29</span><br />
								<span class="description">media & industry
									analysts <br>in attendance</span>
								<span class="addendum">25 media attended from
									leading Chinese technology publications;
									4 English-speaking media and analysts
									attended from outside China, representing
									organizations including InfoQ, Gartner, and
									The Register</span>
							</div>
						</div>
						<!-- End of Icon Box 3 -->
					</div>
					<div class="section-14__coverage-col2">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" decoding="async" width="54" height="54" src="<?php LF_Utils::get_svg( $report_folder . 'icon-bell.svg', true ); ?>
" alt="Bell icon">
							</div>
							<div class="text">
								<span class="number">184</span><br />
								<span class="description">Mentions of <br>the
									event</span>
								<span class="addendum">Kubecon
									+ Cloudnativecon + Open Source Summit was
									mentioned in English-language media
									articles, press releases, and blogs</span>
							</div>
						</div>
						<!-- End of Icon Box 3 -->
					</div>
					<div class="section-14__coverage-col3">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" decoding="async" width="74" height="52" src="<?php LF_Utils::get_svg( $report_folder . 'icon-youtube.svg', true ); ?>
" alt="Graph up icon">
							</div>
							<div class="text">
								<span class="number">2.5K+</span><br />
								<span class="description">Event Session
									<br>YouTube Views</span>
								<span class="addendum">As of October 25 (one
									week after uploading), event session videos
									have garnered more than
									<strong>2,500</strong> views</span>
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
								<span class="number">145</span><br />
								<span class="addendum">mentions of CNCF in media
									articles, press releases, and blogs.</span>
							</div>
						</div>
						<!-- End of Icon Box 3 -->
					</div>
					<div class="section-14__analyst-col2">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<?php LF_Utils::display_responsive_images( 90436, 'full', '200px', 'svg-image', 'lazy', 'Kubernetes Logo' ); ?>
							<div class="text">
								<span class="number">152</span><br />
								<span class="addendum">mentions of Kubernetes in
									media articles, press releases, and
									blogs</span>
							</div>
						</div>
						<!-- End of Icon Box 3 -->
					</div>
					<div class="section-14__analyst-col3">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<?php LF_Utils::display_responsive_images( 90435, 'full', '200px', 'svg-image', 'lazy', 'KubeCon + CloudNativeCon Logo' ); ?>
							<div class="text">
								<span class="number">184</span><br />
								<span class="addendum">mentions of KubeCon +
									CloudNativeCon in media articles, press
									releases, and blogs</span>
							</div>
						</div>
						<!-- End of Icon Box 3 -->
					</div>
				</div>

				<div class="shadow-hr"></div>

				<h2 class="sub-header">Chinese Coverage Snapshot</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>CSDN, this event's marketing promotion and PR partner, provided the following Chinese Coverage Snapshot:</p>
						<ul>
							<li>Published a total of 22 posts related to the
								conference topic </li>
							<li>Reached more than 60 communities</li>
							<li>Produced 26 Weibo</li>
							<li>Received more than 900,000 views across CSDN
								accounts </li>
							<li>Received more than 1,145,000 across external
								media websites</li>
						</ul>

					</div>
				</div>

				<div class="shadow-hr"></div>

				<h2 class="sub-header">Coverage Highlights</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="logo-grid">

					<div class="logo-grid__box">
						<a href="https://www.infoq.com/news/2023/09/kubecon-oss-china-2023/"
							class="logo-grid__link">
							<img class="logo-grid__image" width="224"
								height="55"
								src="<?php LF_Utils::get_svg( $report_folder . 'logo-infoq.svg', true ); ?>"
								alt="InfoQ Logo" loading="lazy" decoding="async">
						</a>
					</div>
					<div class="logo-grid__box">
						<a href="https://www.theregister.com/2023/09/29/cncf_cto_chris_aniszczyk_talks/"
							class="logo-grid__link">
							<img class="logo-grid__image" width="224"
								height="55"
								src="<?php LF_Utils::get_svg( $report_folder . 'logo-the-register.svg', true ); ?>"
								alt="The Register Logo" loading="lazy" decoding="async">
						</a>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<h2 class="sub-header">Industry Analyst Coverage Highlights</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="logo-grid">

					<div class="logo-grid__box">
						<a href="https://www.gartner.com/document/4773031?ref=solrResearch&refval=381968834&"
							class="logo-grid__link">
							<img class="logo-grid__image" width="224"
								height="55"
								src="<?php LF_Utils::get_svg( $report_folder . 'logo-gartner.svg', true ); ?>"
								alt="Gartner Logo" loading="lazy" decoding="async">
						</a>
					</div>
					<div class="logo-grid__box">
						<a href="https://www.forrester.com/report/the-forrester-wave-tm-ai-ml-platforms-in-china-q4-2023/RES178518?ref_search=3540126_1697828200487"
							class="logo-grid__link">
							<img class="logo-grid__image" width="224"
								height="55"
								src="<?php LF_Utils::get_svg( $report_folder . 'logo-forrester.svg', true ); ?>"
								alt="Forrester Logo" loading="lazy" decoding="async">
						</a>
					</div>
					<div class="logo-grid__box">
						<a href="https://www.gartner.com/document/4779931?ref=solrResearch&refval=381969332&"
							class="logo-grid__link">
							<img class="logo-grid__image" width="224"
								height="55"
								src="<?php LF_Utils::get_svg( $report_folder . 'logo-gartner.svg', true ); ?>"
								alt="Gartner Logo" loading="lazy" decoding="async">
						</a>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-120"></div>

			</div>
		</section>

		<section id="sponsors"
			class="section-15 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">Sponsor<br> Information</h2>
					<div class="section-number">6/6</div>
				</div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>KubeCon + CloudNativeCon + Open Source Summit China would not be possible without the support of our wonderful sponsors. And attendees agree, 81% visited the solutions showcase during the event. </p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<h2 class="sub-header">Overall Event Rating</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-15__rating">
					<div class="section-15__rating-col1">

						<div class="icon-box-7">
							<div class="image-container">
								<img width="45" height="45"
									src="<?php LF_Utils::get_svg( $report_folder . 'icon-growth.svg', true ); ?>"
									alt="Growth icon" loading="lazy" decoding="async">
							</div>
							<span class="large">#1</span>
							<span class="text">For career growth,
								<br>advancement,
								or training</span>
						</div>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<div class="icon-box-7">
							<div class="image-container">
								<img width="45" height="45"
									src="<?php LF_Utils::get_svg( $report_folder . 'icon-networking.svg', true ); ?>"
									alt="Networking icon" loading="lazy" decoding="async">
							</div>
							<span class="large">#2</span>
							<span class="text">For networking + meeting
								<br>others in the industry</span>
						</div>

					</div>
					<div class="section-15__rating-col2">

						<div class="icon-box-7">
							<div class="image-container">
								<img width="45" height="45"
									src="<?php LF_Utils::get_svg( $report_folder . 'icon-showcase.svg', true ); ?>"
									alt="Showcase icon" loading="lazy" decoding="async">
							</div>
							<span class="large">81%</span>
							<span class="text">of attendees visited <br>the
								sponsor showcase</span>
						</div>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-80"></div>

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
								<td>4,595</td>
							</tr>
							<tr>
								<td>Onsite leads average/booth</td>
								<td>287</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div class="shadow-hr"></div>

				<div class="kccnc-table-container">
					<table class="kccnc-table yoy-table">
						<thead>
							<tr>
								<th>YOY SPONSORSHIP </th>
								<th>2018
									<span>&nbsp;</span>
								</th>
								<th>2019
									<span>&nbsp;</span>
								</th>
								<th>2021
									<span>Virtual</span>
								</th>
								<th>2023
									<span>&nbsp;</span>
								</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Strategic</td>
								<td>N/A</td>
								<td>1</td>
								<td>1</td>
								<td>1</td>

							</tr>
							<tr>
								<td class="nowrap">Double Diamond</td>
								<td>N/A</td>
								<td>1</td>
								<td>N/A</td>
								<td>N/A</td>

							</tr>
							<tr>
								<td>Diamond</td>
								<td>4</td>
								<td>2</td>
								<td>2</td>
								<td>2</td>
							</tr>
							<tr>
								<td>Platinum</td>
								<td>8</td>
								<td>2</td>
								<td>0</td>
								<td>0</td>
							</tr>
							<tr>
								<td>Gold</td>
								<td>1</td>
								<td>10</td>
								<td>3</td>
								<td>1</td>

							</tr>
							<tr>
								<td>Silver</td>
								<td>12</td>
								<td>14</td>
								<td>3</td>
								<td>10</td>

							</tr>
							<tr>
								<td class="nowrap">Start-up</td>
								<td>13</td>
								<td>12</td>
								<td>5</td>
								<td>3</td>

							</tr>
							<tr>
								<td class="nowrap">End User</td>
								<td>N/A</td>
								<td>0</td>
								<td>0</td>
								<td>0</td>
							</tr>
							<tr>
								<td class="nowrap">Marketing Opportunities</td>
								<td>4</td>
								<td>12</td>
								<td>2</td>
								<td>1</td>
							</tr>
							<tr>
								<td class="nowrap">Total Unique</td>
								<td>38</td>
								<td>42</td>
								<td>14</td>
								<td>18</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header"
					style="margin:auto; text-align:center">Strategic Sponsor</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="sponsors-logos jumbo odd orphan-by-3 orphan-by-6">

					<div class="sponsors-logo-item"><a
							href="https://www.huawei.com/" title="Go to Huawei"
							target="_blank" rel="noopener">
							<img width="241" height="245"
								src="<?php LF_Utils::get_svg( $report_folder . 'logo-huawei.svg', true ); ?>"
								class="logo wp-post-image" alt="Huawei logo"
								decoding="async" loading="lazy"></a>

					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-120"></div>

				<p class="sub-header"
					style="margin:auto; text-align:center">Diamond Sponsors</p>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="sponsors-logos larger odd">
					<div class="sponsors-logo-item"><a
							href="https://developer.aliyun.com/cloudnative/"
							title="Go to Alibaba Cloud"
							style="-webkit-transform: scale(1.2); -ms-transform: scale(1.2); transform: scale(1.2);"
							target="_blank" rel="noopener">
							<img decoding="async" width="399" height="63"
								src="<?php LF_Utils::get_svg( $report_folder . 'logo-alibaba-cloud.svg', true ); ?>"
								class="logo wp-post-image"
								alt="Alibaba Cloud logo" loading="lazy"></a>
					</div>
					<div class="sponsors-logo-item"><a
							href="https://aws.amazon.com/" title="Go to AWS"
							target="_blank" rel="noopener">
							<img decoding="async" width="165" height="53"
								src="<?php LF_Utils::get_svg( $report_folder . 'logo-amazon-cloud-technologies-china.svg', true ); ?>"
								class="logo wp-post-image" alt="AWS logo"
								loading="lazy"></a></div>

					<div class="sponsors-logo-item"><a
							href="https://www.intel.cn/content/www/cn/zh/developer/topic-technology/cloud/overview.html"
							title="Go to Intel"
							style="-webkit-transform: scale(0.75); -ms-transform: scale(0.75); transform: scale(0.75);"
							target="_blank" rel="noopener">
							<img decoding="async" width="338" height="139"
								src="<?php LF_Utils::get_svg( $report_folder . 'logo-intel.svg', true ); ?>"
								class="logo wp-post-image" alt="Intel logo"
								loading="lazy"></a></div>
				</div>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="wp-block-button"><a
						href="https://www.lfasiallc.com/kubecon-cloudnativecon-open-source-summit-china/sponsor-list/"
						title="See all Sponsors of KubeCon + CloudNativeCon + Open Source Summit China 2023"
						class="wp-block-button__link">See
						all Sponsors</a>
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
							class="thanks__opening">We hope you enjoyed reflecting on a great event in Shanghai - let's do it again in Paris!</p>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<p
							class="thanks__comments">Your comments and feedback are welcome at <a href="mailto:events@cncf.io">events@cncf.io</a></p>

						<div aria-hidden="true" class="report-spacer-80"></div>

						<p>Check out our <a href="https://community.cncf.io/">calendar for community events near you</a> and don't forget to <a href="https://www.cncf.io/kubecon-cloudnativecon-events/">register for KubeCon + CloudNativeCon Europe in Paris, 19 - 22 March, 2024</a>.</p>
					</div>
					<div class="thanks__col2">

					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<?php echo do_shortcode( '[event_banner hide_title=true]' ); ?>

				<?php
				get_template_part( 'components/social-share' );
				?>
			</div>
		</section>
	</article>
</main>

<?php

// load slick css.
wp_enqueue_style( 'slick-css', get_template_directory_uri() . '/build/slick.min.css', array(), filemtime( get_template_directory() . '/build/slick.min.css' ), 'all' );

// load main slick.
wp_enqueue_script( 'slick', get_template_directory_uri() . '/source/js/libraries/slick.min.js', array( 'jquery' ), filemtime( get_template_directory() . '/source/js/libraries/slick.min.js' ), true );

// custom scripts.
wp_enqueue_script(
	'kccnc-oss-23-report',
	get_template_directory_uri() . '/source/js/on-demand/kccnc-oss-23-report.js',
	array( 'jquery', 'slick' ),
	filemtime( get_template_directory() . '/source/js/on-demand/kccnc-oss-23-report.js' ),
	true
);

get_template_part( 'components/footer' );
