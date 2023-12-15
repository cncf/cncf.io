<?php
/**
 * Template Name: KCCNC NA 23 Transparency
 * Template Post Type: lf_report
 *
 * File for the KCCNC NA 2023 Transparency Report
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
$report_folder = 'reports/kccnc-na-23/'

?>

<link rel="prefetch"
	href="<?php echo esc_url( get_template_directory_uri() . '/build/kccnc-na-23-transparency.min.css' ); ?>"
	as="style" crossorigin="anonymous" />

<?php wp_enqueue_style( 'kccnc-na-23', get_template_directory_uri() . '/build/kccnc-na-23-transparency.min.css', array(), filemtime( get_template_directory() . '/build/kccnc-na-23-transparency.min.css' ), 'all' ); ?>

<main class="kccnc-na-23">
	<article class="container wrap">

		<section class="hero alignfull">

			<figure class="background-image-figure skyline">
				<picture>
					<?php
							LF_Utils::display_responsive_images(
								98810,
								'full',
								'1200px',
								null,
								'eager',
								'An illustration of the Shangahi city skyline.'
							);
							?>
				</picture>
			</figure>

			<div class="container wrap hero__wrap">
				<div class="hero__text-overlay">
					<div class="container hero__container">
						<div class="hero__wrapper">
							<img class="hero__logo"
								src="<?php LF_Utils::get_svg( $report_folder . 'kccnc-na-logo-23-color.svg', true ); ?>"
								width="295" height="128"
								alt="KubeCon + CloudNativeCon North America 2023 Logo"
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
				<figure class="hero__bg-gradient"></figure>
			</div>
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
					<a href="#dei" title="Jump to DEI section"
						class="box-link"></a>
					<img loading="lazy" width="36" height="36" src="
<?php LF_Utils::get_svg( $report_folder . 'nav-icon-people.svg', true ); ?>
" alt="People icon">DEI
				</div>

				<div class="nav-el__box">
					<a href="#colocated" title="Jump to Co-located Events"
						class="box-link"></a>
					<img loading="lazy" width="36" height="36" src="
<?php LF_Utils::get_svg( $report_folder . 'nav-icon-location.svg', true ); ?>
" alt="Map pin icon">Co-located Events
				</div>

				<div class="nav-el__box">
					<a href="#content" title="Jump to Content section"
						class="box-link"></a>
					<img loading="lazy" width="36" height="36" src="
<?php LF_Utils::get_svg( $report_folder . 'nav-icon-movie.svg', true ); ?>
" alt="Movie icon">
					Content
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
				<h2 class="section-01__title">What an amazing week in Chicago!
				</h2>
			</div>

			<div class="lf-grid section-01__grid">
				<div class="section-01__grid-col1">

					<p><strong>If there’s one resounding theme to come out of Chicago, it was undeniably AI. More than 20 presentations were included on the AI/ML track, and I expect to see this rise even higher at <a href="https://events.linuxfoundation.org/kubecon-cloudnativecon-europe/">KubeCon + CloudNativeCon in Paris</a> next March, given the foundational role Kubernetes and cloud native are playing in the AI ecosystem. In my keynote, I gave a demo on how to run an LLM and inference application on Kubernetes – check out the <a href="https://github.com/cncf/llm-starter-pack">Cloud Native LLM Starter Pack</a> and see what you can build too.</strong></p>
					<p>Security was also a key discussion in Chicago, and it was fantastic to host the Security Hub for the entire three days of the event, bringing #TeamCloudNative together to work on solutions that will continue to transform the cloud native security space. Equally, platform engineering emerged as a critical focus area, highlighting its vital role in enhancing developer experience, automation, and security. Attendees shared insights and strategies on advancing an everything-as-code philosophy, emphasizing the importance of creating efficient and secure layered abstractions on Kubernetes.</p>
					<p>Another theme that struck a chord was sustainability and ensuring that we are working towards net zero even as we continue to evolve the cloud native ecosystem. The environmental sustainability keynote panel, moderated by co-chair Frederick Kautz, was a highlight. On the ground, we also worked hard to ensure that this event was as sustainable as possible, and I encourage you to dig into the sustainability section of this report.</p>
					<p>There is much to unpack from this phenomenal event, and I’ve enjoyed looking back as we put this transparency report together for you. I hope you find the information valuable, and I look forward to seeing you next March in Paris for KubeCon + CloudNativeCon Europe!</p>

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
<?php LF_Utils::get_svg( $report_folder . 'icon-badge.svg', true ); ?>
" alt="Badge icon">
						</div>
						<div class="text">
							<span>54%</span><br />
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
							<span>1,871</span><br />
							CFPs submitted
						</div>
					</div>

					<!-- Icon 3  -->
					<div class="icon-box-1">
						<div class="icon">
							<img loading="lazy" width="34" height="45" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-person.svg', true ); ?>
" alt="People icon">
						</div>
						<div class="text">
							<span>1,940</span><br />
							Attendees thanks to <br class="show-over-1000">Dan
							Kohn Scholarship Fund
						</div>
					</div>

					<!-- Icon 4  -->
					<div class="icon-box-1">
						<div class="icon">
							<img loading="lazy" width="45" height="33" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-megaphone.svg', true ); ?>
" alt="Megaphone icon">
						</div>
						<div class="text">
							<span>5,763+</span><br />
							Pieces of media coverage
						</div>
					</div>

				

				</div>
			</div>
		</section>

		<!-- Tweet -->
		<section class="section-tweet">
			<a href="https://twitter.com/t1agoB/status/1722796405125751172?ref_src=twsrc%5Etfw">
			<?php LF_Utils::display_responsive_images( 98825, 'full', '1200px', null, 'lazy', 'Tweet screenshot' ); ?>
			</a>
		</section>

		<!-- Photo Highlights  -->
		<section class="section-02">

			<div class="wp-block-group is-style-no-padding is-style-see-all">
				<div class="wp-block-columns are-vertically-aligned-centered">
					<div class="wp-block-column is-vertically-aligned-centered"
						style="flex-basis:80%">
						<h3 class="sub-header">Chicago Photo Highlights</h3>
					</div>
					<div class="wp-block-column is-vertically-aligned-bottom"
						style="flex-basis:20%">
						<p
							class="has-text-align-right is-style-link-cta"><a href="https://www.flickr.com/photos/143247548@N03/albums/72177720312486917/" title="KubeCon + CloudNativeCon North America 2023 Photo Gallery">See more</a></p>
					</div>
				</div>

				<div class="section-02__slider">
					<div>
						<?php LF_Utils::display_responsive_images( 98801, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon North America 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 98800, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon North America 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 98802, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon North America 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 98803, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon North America 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 98804, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon North America 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 98805, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon North America 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 98806, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon North America 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 98807, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon North America 2023' ); ?>
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
					<div class="restrictive-9-col">
						<p
							class="opening-paragraph">It was fantastic to be back in the Midwest, following the 2022  KubeCon + CloudNativeCon in Detroit, and we were thrilled to see many new faces in attendance, alongside old friends.</p>
					</div>
				</div>

				<p class="sub-header">Demographics</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<picture>
					<source media="(max-width: 499px)"
						srcset="<?php echo esc_url( wp_get_attachment_image_url( 98882, 'full', false ) ); ?>">
					<source media="(min-width: 500px)"
						srcset="<?php echo esc_url( wp_get_attachment_image_url( 98820, 'full', false ) ); ?>">
					<?php
					LF_Utils::display_responsive_images(
						98820,
						'full',
						'1200px',
						'svg-image',
						'lazy',
						'13,666 total registered attendees'
					);
					?>
				</picture>

				<div aria-hidden="true" class="report-spacer-120"></div>

				<p class="sub-header">Attendee Geography</p>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<picture style="margin: auto;">
					<?php
					LF_Utils::display_responsive_images(
						98826,
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
							class="legend__key legend__dark-turquoise"></i>
						In-Person %
					</div>

					<div class="legend__wrapper"><i
							class="legend__key legend__red-pink"></i> Virtual %
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
								<img loading="lazy" width="52" height="52" src="<?php LF_Utils::get_svg( $report_folder . 'flag-usa.svg', true ); ?>
" alt="USA Flag">
							</div>
							<div class="text">
								<span class="country">USA</span><br />
								<span class="number">9,500</span>
							</div>
						</div>
						
						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon">
								<img loading="lazy" width="52" height="52" src="<?php LF_Utils::get_svg( $report_folder . 'flag-canada.svg', true ); ?>
" alt="Canada Flag">
							</div>
							<div class="text">
								<span class="country">Canada</span><br />
								<span class="number">620</span>
							</div>
						</div>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon">
								<img loading="lazy" width="52" height="52" src="<?php LF_Utils::get_svg( $report_folder . 'flag-india.svg', true ); ?>
" alt="India Flag">
							</div>
							<div class="text">
								<span class="country">India</span><br />
								<span class="number">474</span>
							</div>
						</div>
					</div>
					<div class="section-03__top-countries-col2">
						<p class="table-header">In-person</p>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon">
								<img loading="lazy" width="52" height="52" src="<?php LF_Utils::get_svg( $report_folder . 'flag-usa.svg', true ); ?>
" alt="USA Flag">
							</div>
							<div class="text">
								<span class="country">USA</span><br />
								<span class="number">6,797</span>
							</div>
						</div>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon">
								<img loading="lazy" width="52" height="52" src="<?php LF_Utils::get_svg( $report_folder . 'flag-canada.svg', true ); ?>
" alt="Canada Flag">
							</div>
							<div class="text">
								<span class="country">Canada</span><br />
								<span class="number">351</span>
							</div>
						</div>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon">
								<img loading="lazy" width="52" height="52" src="<?php LF_Utils::get_svg( $report_folder . 'flag-uk.svg', true ); ?>
" alt="UK Flag">
							</div>
							<div class="text">
								<span class="country">United Kingdom</span><br />
								<span class="number">186</span>
							</div>
						</div>

					</div>
					<div class="section-03__top-countries-col3">
						<p class="table-header">Virtual</p>


						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon">
								<img loading="lazy" width="52" height="52" src="<?php LF_Utils::get_svg( $report_folder . 'flag-usa.svg', true ); ?>
" alt="USA Flag">
							</div>
							<div class="text">
								<span class="country">USA</span><br />
								<span class="number">2,703</span>
							</div>
						</div>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon">
								<img loading="lazy" width="52" height="52" src="<?php LF_Utils::get_svg( $report_folder . 'flag-india.svg', true ); ?>
" alt="India Flag">
							</div>
							<div class="text">
								<span class="country">India</span><br />
								<span class="number">387</span>
							</div>
						</div>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon">
								<img loading="lazy" width="52" height="52" src="<?php LF_Utils::get_svg( $report_folder . 'flag-canada.svg', true ); ?>
" alt="Canada Flag">
							</div>
							<div class="text">
								<span class="country">Canada</span><br />
								<span class="number">269</span>
							</div>
						</div>

					</div>

				</div>

				<div aria-hidden="true" class="report-spacer-120"></div>

				<p class="sub-header is-centered">Top Three Job Functions</p>

				<div class="lf-grid section-03__top-jobs">
					<div class="section-03__top-jobs-col1">
						<p class="table-header">DevOps / SRE / Sysadmin</p>
						<span class="large">3,837</span>
					</div>
					<div class="section-03__top-jobs-col2">
						<p class="table-header">Developer</p>
						<span class="large">2,838</span>
					</div>
					<div class="section-03__top-jobs-col3">
						<p class="table-header">Architect</p>

						<span class="large">2,224</span>
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
												<th>%</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>Architect</td>
												<td>16%</td>
											</tr>
											<tr>
												<td>Business Operations</td>
												<td>2%</td>
											</tr>
											<tr>
												<td>Developer</td>
												<td>21%</td>
											</tr>
											<tr class="indent">
												<td>Data Scientist</td>
												<td>4%</td>
											</tr>
											<tr class="indent">
												<td>Full Stack Developer</td>
												<td>83%</td>
											</tr>
											<tr class="indent">
												<td>Machine Learning
													Specialist</td>
												<td>4%</td>
											</tr>
											<tr class="indent">
												<td>Web Developer</td>
												<td>9%</td>
											</tr>
											<tr class="indent">
												<td>Mobile Developer</td>
												<td>1%</td>
											</tr>
											<tr>
												<td>DevOps / SRE / SysAdmin</td>
												<td>28%</td>
											</tr>
											<tr>
												<td>Executive</td>
												<td>7%</td>
											</tr>
											<tr>
												<td>IT Operations</td>
												<td>2%</td>
											</tr>
											<tr class="indent">
												<td>DevOps</td>
												<td>28%</td>
											</tr>
											<tr class="indent">
												<td>Systems Admin</td>
												<td>49%</td>
											</tr>
											<tr class="indent">
												<td>Site Reliability Engineer
												</td>
												<td>13%</td>
											</tr>
											<tr class="indent">
												<td>Quality Assurance
													Engineer</td>
												<td>2%</td>
											</tr>
											<tr>
												<td>Sales / Marketing</td>
												<td>9%</td>
											</tr>
											<tr>
												<td>Media / Analyst</td>
												<td>1%</td>
											</tr>
											<tr>
												<td>Student</td>
												<td>2%</td>
											</tr>
											<tr>
												<td>Product Manager</td>
												<td>4%</td>
											</tr>
											<tr>
												<td>Professor / Academic</td>
												<td><1%</td>
											</tr>
											<tr>
												<td>Other</td>
												<td>7%</td>
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
												<th>%</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>Automotive</td>
												<td>2%</td>
											</tr>
											<tr>
												<td>Consumer Goods</td>
												<td>3%</td>
											</tr>
											<tr>
												<td>Energy</td>
												<td>1%</td>
											</tr>
											<tr>
												<td>Financials</td>
												<td>12%</td>
											</tr>
											<tr>
												<td>Health Care</td>
												<td>3%</td>
											</tr>
											<tr>
												<td>Industrials</td>
												<td>2%</td>
											</tr>
											<tr>
												<td>Information Technology</td>
												<td>67%</td>
											</tr>
											<tr>
												<td>Materials</td>
												<td><1%</td>
											</tr>
											<tr>
												<td>Non-Profit Organization</td>
												<td>3%</td>
											</tr>
											<tr>
												<td>Professional Services</td>
												<td>4%</td>
											</tr>
											<tr>
												<td>Telecommunications</td>
												<td>3%</td>
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

			</div>
		</section>

		<section class="section-05">

			<div class="shadow-hr"></div>

			<div class="kccnc-table-container">
				<table class="kccnc-table growth-table">
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
								<span>LA</span>
							</th>
							<th>2022
								<span>Detroit</span>
							</th>
							<th>2023
								<span>Chicago</span>
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
							<td>22,164</td>
							<td>16,986</td>
							<td>13,666</td>
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
							<td>31%</td>
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
							<td>7%</td>
						</tr>
						<tr>
							<td>Virtual All Access Pass</td>
							<td>N/A</td>
							<td>N/A</td>
							<td>N/A</td>
							<td>N/A</td>
							<td>67%</td>
							<td>68%</td>
							<td>48%</td>
							<td>28%</td>
						</tr>
						<tr>
							<td>Virtual Keynote + Solutions Showcase Only</td>
							<td>N/A</td>
							<td>N/A</td>
							<td>N/A</td>
							<td>N/A</td>
							<td>14%</td>
							<td>18%</td>
							<td>4.5%</td>
							<td>6%</td>
						</tr>
						<tr>
							<td>Speaker</td>
							<td>11%</td>
							<td>6%</td>
							<td>5%</td>
							<td>5%</td>
							<td>2%</td>
							<td>1%</td>
							<td>3%</td>
							<td>5%</td>
						</tr>
						<tr>
							<td>Sponsor</td>
							<td>17%</td>
							<td>16%</td>
							<td>17%</td>
							<td>15%</td>
							<td>17%</td>
							<td>7%</td>
							<td>12.5%</td>
							<td>19%</td>
						</tr>
						<tr>
							<td>Media</td>
							<td>3%</td>
							<td>1%</td>
							<td>1%</td>
							<td>1%</td>
							<td><1%</td>
							<td><1%</td>
							<td>1%</td>
							<td>1%</td>
						</tr>
						<tr>
							<td>Academic</td>
							<td>N/A</td>
							<td>2%</td>
							<td>2%</td>
							<td>3%</td>
							<td>N/A</td>
							<td><1%</td>
							<td>1%</td>
							<td>2%</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div aria-hidden="true" class="report-spacer-120"></div>

			<div class="quote-with-name-container">
					<p
						class="quote-with-name-container__quote">I was most impressed by the personal connections that drive innovation in this ever-expanding space. There's a deep sense of involvement and genuine warmth among contributors and end users in the CNCF community, which is borne out of a culture of knowledge sharing and acceptance one wouldn't expect from an engineering-focused trade organization.</p>
					<div class="quote-with-name-container__marks">
						<p
							class="quote-with-name-container__name">Jason English</p>
						<p
							class="quote-with-name-container__position">Silicon ANGLE </p>
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

		<section id="dei"
			class="is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">DEI</h2>
					<div class="section-number">2/6</div>
				</div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p class="opening-paragraph">CNCF strives to ensure that everyone who participates in KubeCon + CloudNativeCon feels welcome, regardless of gender, gender identity, sexual orientation, disability, race, ethnicity, age, religion, or economic status. Just over 11% of attendees identified as a person of color, and more than 7% preferred not to answer. It is worth noting that these were optional questions on the registration form, therefore these data points represent only those that chose to respond.</p>
						<p>As part of our deep commitment to diversity, equity and inclusivity, we hosted a number of workshops and networking opportunities to help connect individuals to opportunities within tech.</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="kccnc-table-container">
						<p class="sub-header is-centered">Diversity, Equity & Inclusivity Events
										and
										Mentoring</p>
						<div aria-hidden="true" class="report-spacer-40"></div>

						<table class="kccnc-table dei__table">
							<tbody>
								<tr>
									<td>Diversity Lunch participants</td>
									<td>115</td>
								</tr>
								<tr>
									<td>EmpowerUs participants</td>
									<td>102</td>
								</tr>
								<tr>
									<td>Peer Group Mentoring + Career Networking
										<strong>mentors</strong> - in-person
									</td>
									<td>9</td>
								</tr>
								<tr>
									<td>Peer Group Mentoring + Career Networking
										<strong>mentees</strong> - in-person
									</td>
									<td>40</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="col2">
						<p class="sub-header is-centered">Sponsors</p>

						<div class="sponsors-logos largest odd orphan-by-3 orphan-by-6">
							<div class="sponsors-logo-item"><a
									href="https://www.intel.com/"
									title="Go to Intel"
									rel="noopener" data-feathr-click-track="true"
									data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
									width="141" height="245"
										src="https://events.linuxfoundation.org/wp-content/uploads/2020/01/intel-01.svg"
										class="logo wp-post-image" alt="Intel logo"
										decoding="async" loading="lazy"></a></div>
							<div class="sponsors-logo-item"><a
									href="https://www.google.com/" title="Go to Google"
									rel="noopener"
									data-feathr-click-track="true"
									data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
										width="241" height="245"
										src="https://events.linuxfoundation.org/wp-content/uploads/google-logo-web.svg"
										class="logo wp-post-image" alt="Google logo"
										decoding="async" loading="lazy"></a></div>
						</div>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<div class="lf-grid">
					<div class="dei__col-1">
						<p class="sub-header">Gold CHAOSS D&I Event Badge</p>
						<p>Awarded to events in the open source community that foster healthy D&I practices.</p>
					</div>
					<div class="dei__col-2">
						<?php LF_Utils::display_responsive_images( 90434, 'full', '320px', 'svg-image badge', 'lazy', 'Gold CHAOSS D&I Event Badge' ); ?>
					</div>
				</div>
				<div aria-hidden="true" class="report-spacer-100"></div>

				<picture style="margin: auto;">
					<?php
					LF_Utils::display_responsive_images(
						98898,
						'full',
						'1200px',
						null,
						'lazy',
						'Group shot of people at a conference'
					);
					?>
				</picture>

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
							class="opening-paragraph">Co-located events feature industry experts covering topics like AI, app development, edge, observability, web assembly, and more.</p>
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
								<h3 class="large">49%</h3>
							</div>
							<div class="sub-grid__col2">
								<p>Women</p>
								<img src="<?php LF_Utils::get_svg( $report_folder . 'icon-female.svg', true ); ?>"
									width="60" height="70" alt="Icon Woman"
									loading="lazy">
								<h3 class="large">10%</h3>
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
							class="section-09__demographics-note"><span style="color: #CC4194;">40%</span> prefer not to answer</p>
					</div>
					<div class="section-09__demographics-col2">
						<p
							class="sub-header">Top Three Countries Represented</p>
						<div aria-hidden="true" class="report-spacer-60"></div>
						<div class="lf-grid sub-grid">
							<div class="sub-grid__col1">
								<p>USA<br>&nbsp;</p>
								<img src="<?php LF_Utils::get_svg( $report_folder . 'flag-usa.svg', true ); ?>"
									width="70" height="70" alt="Icon USA"
									loading="lazy">
								<h3 class="large">72%</h3>
							</div>
							<div class="sub-grid__col2">
								<p>Canada<br>&nbsp;</p>
								<img src="<?php LF_Utils::get_svg( $report_folder . 'flag-canada.svg', true ); ?>"
									width="70" height="70" alt="Icon Canada"
									loading="lazy">
								<h3 class="large">4%</h3>
							</div>
							<div class="sub-grid__col3">
								<p>United Kingdom<br>&nbsp;</p>
								<img src="<?php LF_Utils::get_svg( $report_folder . 'flag-uk.svg', true ); ?>"
									width="70" height="70"
									alt="Icon United Kingdom" loading="lazy">
								<h3 class="large">2%</h3>
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
								<h3 class="large purple">28%</h3>
							</div>
							<div class="sub-grid__col2">
								<p>Developer<br>&nbsp;</p>
								<h3 class="large purple">23%</h3>
							</div>
							<div class="sub-grid__col3">
								<p>Architect<br>&nbsp;</p>
								<h3 class="large purple">17%</h3>
							</div>
						</div>
					</div>
					<div class="section-09__demographics-col2">
						<p class="sub-header">Sponsors</p>
						<div aria-hidden="true" class="report-spacer-60"></div>
						<div class="lf-grid sub-grid">
							<div class="sub-grid__col1 two-cols">
								<p>Total Onsite Leads<br>&nbsp;</p>
								<h3 class="large purple">4,229</h3>
							</div>
							<div class="sub-grid__col2 two-cols">
								<p>Average Onsite Leads <br>Per Sponsor</p>
								<h3 class="large purple">176</h3>
								<p
									class="note">(119% increase from 2022)</p>
							</div>
						</div>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<?php LF_Utils::display_responsive_images( 98899, 'full', '1200px', 'section-09__banner', 'lazy', '4,769 people Registered for Co-Located Events - the largest audience ever' ); ?>
				<div aria-hidden="true" class="report-spacer-100"></div>

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

						<h2 class="section-10__title">Don’t miss out on the opportunity to position your thought-leadership to an engaged audience at the CNCF-hosted co-located events. Secure your sponsorship for CNCF-hosted co-located events in Europe 2024 today!</h2>
					</div>

					<div aria-hidden="true" class="report-spacer-120"></div>

				</div>
			</div>

		</section>

		<section
			class="section-09 is-style-down-gradient alignfull">
			<div class="container wrap">

				<h2 class="section-header">Reports</h2>

				<div aria-hidden="true" class="report-spacer-100"></div>


				<div class="masonry-grid">
					<?php LF_Utils::display_responsive_images( 98911, 'full', '400px', 'masonry-item', 'lazy', 'Stats for ArgoCon co-located event' ); ?>
					<?php LF_Utils::display_responsive_images( 98901, 'full', '400px', 'masonry-item', 'lazy', 'Stats for appdevelopercon co-located event' ); ?>
					<?php LF_Utils::display_responsive_images( 98902, 'full', '400px', 'masonry-item', 'lazy', 'Stats for backstagecon co-located event' ); ?>
					<?php LF_Utils::display_responsive_images( 98903, 'full', '400px', 'masonry-item', 'lazy', 'Stats for cloud native startupfest co-located event' ); ?>
					<?php LF_Utils::display_responsive_images( 98904, 'full', '400px', 'masonry-item', 'lazy', 'Stats for cloud-native telco day co-located event' ); ?>
					<?php LF_Utils::display_responsive_images( 98900, 'full', '400px', 'masonry-item', 'lazy', 'Stats for CiliumCon co-located event' ); ?>
					<?php LF_Utils::display_responsive_images( 98909, 'full', '400px', 'masonry-item', 'lazy', 'Stats for dok dok co-located event' ); ?>
					<?php LF_Utils::display_responsive_images( 98905, 'full', '400px', 'masonry-item', 'lazy', 'Stats for dbaas co-located event' ); ?>
					<?php LF_Utils::display_responsive_images( 98914, 'full', '400px', 'masonry-item', 'lazy', 'Stats for wasm-day co-located event' ); ?>
					<?php LF_Utils::display_responsive_images( 98907, 'full', '400px', 'masonry-item', 'lazy', 'Stats for istio-day co-located event' ); ?>
					<?php LF_Utils::display_responsive_images( 98908, 'full', '400px', 'masonry-item', 'lazy', 'Stats for kubernetes ai co-located event' ); ?>
					<?php LF_Utils::display_responsive_images( 98912, 'full', '400px', 'masonry-item', 'lazy', 'Stats for multi-tenancycon co-located event' ); ?>
					<?php LF_Utils::display_responsive_images( 98913, 'full', '400px', 'masonry-item', 'lazy', 'Stats for Observability Day co-located event' ); ?>
					<?php LF_Utils::display_responsive_images( 98906, 'full', '400px', 'masonry-item', 'lazy', 'Stats for envoycon co-located event' ); ?>
					<?php LF_Utils::display_responsive_images( 98910, 'full', '400px', 'masonry-item', 'lazy', 'Stats for Kubernetes on Edge Day co-located event' ); ?>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

			</div>
		</section>



		<section id="content"
			class="section-11 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">Content</h2>
					<div class="section-number">4/6</div>
				</div>


				<div class="quote-with-name-container">
					<p
						class="quote-with-name-container__quote">KubeCon 2023 presented a vibrant tapestry of an evolving cloud native ecosystem, grappling with its growth pains while simultaneously pushing the boundaries of innovation and inclusivity.</p>
					<div class="quote-with-name-container__marks">
						<p
							class="quote-with-name-container__name">Roy Chua</p>
						<p
							class="quote-with-name-container__position">Silverlinings</p>
					</div>
				</div>
				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="lf-grid">
					<div class="restrictive-10-col">
						<p
							class="opening-paragraph">We enjoyed 359 sessions in Chicago, including 98 maintainer sessions and more than <strong>270</strong> breakouts.</p>
					</div>
				</div>
				<div aria-hidden="true" class="report-spacer-40"></div>


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
								<td>20</td>
								<td>20</td>
								<td>0</td>
							</tr>
							<tr>
								<td>Total sessions (CFP & Maintainer)</td>
								<td>359</td>
								<td>351</td>
								<td>8</td>
							</tr>
							<tr>
								<td>- Breakouts</td>
								<td>271</td>
								<td>266</td>
								<td>5</td>
							</tr>
							<tr>
								<td>- Maintainer sessions</td>
								<td>88</td>
								<td>85</td>
								<td>3</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<p class="sub-header">Captioning Usage</p>

				<div class="lf-grid captioning">
					<div class="captioning-col1">
						<h3 class="large dark-purple">382 hours</h3>
						<p class="large">Using Wordly Captioning on Accelevents virtual platform</p>
						<h3 class="large dark-purple">Top languages</h3>
						<p class="large">English -> German -> French -> Polish -> Italian</p>
					</div>
					<div class="captioning-col2">
						<h3 class="large dark-purple">426 hrs and 8 min</h3>
						<p class="large">Using in-room Wordly Captioning on personal mobile device</p>
						<h3 class="large dark-purple">Top languages</h3>
						<p class="large">English -> Spanish -> German -> Japanese -> French</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<p class="sub-header">Thank you to our fabulous KubeCon + CloudNativeCon North America 2023 co-chairs Aparna Subramanian, Frederick Kautz, and Nikhita Raghunath.</p>

				<div class="lf-grid chairs">
					<div class="chairs__col1">
						<?php LF_Utils::display_responsive_images( 98966, 'full', '200px', 'chairs__image', 'lazy', 'Fog Dong' ); ?>
						<p>
<span class="chairs__name">Aparna Subramanian
</span><span
	class="chairs__title">Shopify <br/>
	Director of Production Engineering</span>
</p>
					</div>
					<div class="chairs__col2">
					<?php LF_Utils::display_responsive_images( 98968, 'full', '200px', 'chairs__image', 'lazy', 'Fog Dong' ); ?>
						<p>
<span class="chairs__name">Frederick Kautz
</span><span
	class="chairs__title">Computing Engineer Infra and <br/>
	Security Enterprise Architect</span>
</p>
					</div>

					<div class="chairs__col3">
					<?php LF_Utils::display_responsive_images( 98969, 'full', '200px', 'chairs__image', 'lazy', 'Fog Dong' ); ?>
						<p>
<span class="chairs__name">Nikhita Raghunath
</span><span
	class="chairs__title">VMware <br/>
	Software Engineer</span>
</p>					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-120"></div>
			</div>
		</section>

		<section class="section-10 alignfull background-image-wrapper">

					<figure class="background-image-figure">
						<?php LF_Utils::display_responsive_images( 98970, 'full', '1200px', 'section-10__image', 'lazy', 'Woman at a conference' ); ?>
					</figure>

					<div class="background-image-text-overlay">
						<div class="container wrap">

							<div aria-hidden="true" class="report-spacer-120"></div>

							<div class="quote-with-name-container">
								<p
									class="quote-with-name-container__quote">It was refreshing to see end users openly share information in keynotes and sessions about how they are addressing security. In the spirit of openness and community contribution, they shared their successes but also discussed challenges, breaches that they experienced, mistakes they made and lessons learned.</p>
								<div class="quote-with-name-container__marks">
									<p
										class="quote-with-name-container__name">Melinda Marks</p>
									<p
										class="quote-with-name-container__position">Tech Target</p>
								</div>
							</div>
							<div aria-hidden="true" class="report-spacer-120"></div>

						</div>
					</div>

		</section>


		<section
			class="section-11 is-style-grey-background alignfull">

			<div class="container wrap">

			<div class="lf-grid breakdown">
					<div class="breakdown__col1">

						<h2 class="section-header">Content <br />Breakdown</h2>

					</div>
					<div class="breakdown__col2">
						<div class="breakdown__text">
							<p>The schedule was curated by conference co-chairs, Aparna Subramanian, Director of Production Engineering, Shopify; Frederick Kautz, Cloud Native Infra and Security Enterprise Architect; and Nikhita Raghunath, Software Engineer, VMware; who led a program committee of 120 experts and 22 track chairs, comprised of project maintainers and CNCF Ambassadors.</p>
							<p>Talks are selected by the program committee through a rigorous, non-bias process where they are randomly assigned submissions to review within their area of expertise. You can read the details in our Submission Reviewer Guidelines, and specifically about the North America selection process.</p>
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
									<span class="number">1,871</span><br />
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
									<span class="number">554</span><br />
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
									<span class="number">120</span><br />
									<span class="description">program committee members</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			<div aria-hidden="true" class="report-spacer-120"></div>
			</div>
		</section>

		<section class="section-08 alignfull">
			<div class="container wrap">

				<div aria-hidden="true" class="report-spacer-120"></div>
				<h2 class="section-header">Speaker Diversity</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<p>CNCF enforces guidelines on gender and diversity equality among our speakers, including not accepting all-male panels.</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="kccnc-table-container">
					<table class="kccnc-table">
						<thead>
							<tr>
								<th> Diversity
								</th>
								<th>Percent</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Women + gender non-conforming
									(keynotes)</td>
								<td>45%</td>
							</tr>
							<tr>
								<td>Men (keynotes)</td>
								<td>55%</td>
							</tr>
							<tr>
								<td>Women + gender non-conforming
									(breakouts)</td>
								<td>24%</td>
							</tr>
							<tr>
								<td>Men (breakouts)</td>
								<td>76%</td>
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


		<section class="section-10 alignfull background-image-wrapper">

					<figure class="background-image-figure">
						<?php LF_Utils::display_responsive_images( 98976, 'full', '1200px', 'section-10__image', 'lazy', 'Man writing on a white board' ); ?>
					</figure>

					<div class="background-image-text-overlay">
						<div class="container wrap">

							<div aria-hidden="true" class="report-spacer-120"></div>

							<div class="quote-with-name-container">
								<p
									class="quote-with-name-container__quote">The resounding theme at KubeCon was clear — everyone wants more AI</p>
								<div class="quote-with-name-container__marks">
									<p
										class="quote-with-name-container__name">Chad Wilson</p>
									<p
										class="quote-with-name-container__position">Silicon ANGLE</p>
								</div>
							</div>
							<div aria-hidden="true" class="report-spacer-120"></div>

						</div>
					</div>

		</section>


		<section
			class="section-11 is-style-down-gradient alignfull">

			<div class="container wrap">






				<div class="lf-grid">
					<div class="restrictive-8-col">
						<p>Security was a key focal point at KubeCon + CloudNativeCon North America, where a number of new initiatives were hosted to foster a collaborative approach toward tackling security issues.</p>
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
						<p>We were pleased to announce <a href="https://research.nccgroup.com/2023/04/17/public-report-kubernetes-1-24-security-audit/">the latest refreshed Kubernetes third-party audit</a> based on the 1.24 release, at KubeCon + CloudNativeCon North America.<br><br>The goal of this security review was to identify any issues in the project architecture and code base which could adversely affect the security of Kubernetes users.<br><br>This audit was sponsored by CNCF and conducted over the summer of 2022 by <a href="https://www.nccgroup.com/">NCC Group</a> with the help of the <a href="https://github.com/kubernetes/sig-security/issues/13">Kubernetes SIG Security Third Party Audit Working Group</a>.</p>
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
							class="opening-paragraph">We're committed to sustainability at our events and KubeCon + CloudNativeCon North America was no exception.</p>

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

						<?php LF_Utils::display_responsive_images( 90397, 'full', '470px', null, 'lazy', 'Sustainability at Kubecon + CloudNativeCon North America 2023' ); ?>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<?php LF_Utils::display_responsive_images( 90398, 'full', '470px', null, 'lazy', 'Sustainability at Kubecon + CloudNativeCon North America 2023' ); ?>

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
						<p>Over the two weeks immediately after KubeCon + CloudNativeCon North America, we were made aware of 10 positive tests. Fortunately, no serious cases have been reported.</p>
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
									<br>North Americaan event </span>
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
						<p><strong>176 media and industry analysts attended</strong> both in person and virtually. They generated a huge amount of coverage from this year's North Americaan event hitting over <strong>4,200 articles and press releases</strong>, a <strong>69% increase</strong> from last year's North Americaan event. The CNCF PR and AR team hosted two media and analyst roundtables at the event focusing on platform engineering, and what's next in cloud native, in addition to an end user panel at the press and analyst conference.</p>
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

				<p><strong>More than 210</strong> original articles published from KubeCon + CloudNativeCon North America in leading outlets including:</p>

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
					<p>Al Gillen, IDC - <a href="https://www.idc.com/getdoc.jsp?containerId=lcUS50602023&pageType=PRINTFRIENDLY">KubeCon North America 2023 Highlights Linux Foundation's Expansion into North America</a></p>
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
						<p>Camberley Bates, Futurum - <a href="https://d2iq.com/blog/kubecon-North America-2023-platform-engineering">KubeCon North America 2023 Highlights Kubernetes Explosion and Need for Instant Platform Engineering</a></p>
						<p>Steven Dickens, Futurum - <a href="https://futurumresearch.com/research-notes/kubecon-2023-suse-launches-rancher-2-7-2-latest-version-of-rancher/">KubeCon 2023: SUSE Launches Rancher 2.7.2, Latest Version of Rancher</a></p>
						<p>Jon Collins, GigaOm - <a href="https://gigaom.com/2023/05/03/touchpoints-coalescence-and-multi-platform-engineering-thoughts-from-kubecon-2023/">Touchpoints, coalescence and multi-platform engineering — thoughts from Kubecon 2023</a></p>
						<p>Torsten Volk, EMA - <a href="https://faun.pub/opentelemetry-the-star-of-kubecon-2023-c1e2b504850d">OpenTelemetry: The Star of KubeCon 2023</a></p>
						<p>Larry Carvalho, Robustcloud - <a href="https://robustcloud.com/embracing-the-future-generative-ai-and-wasm/">Embracing the Future: Generative AI and Web Assembly (Wasm) Innovations at KubeCon CloudNativeCon EU 2023</a></p>
						<p>Sanjeev Mohan, SanjMo - <a href="https://www.youtube.com/watch?v=_txmAX5mTxA">It Depends: Gabriele Bartolini, EDB demystifies data on Kubernetes concepts</a></p>
						<p>Sanjeev Mohan, SanjMo - <a href="https://www.youtube.com/watch?v=N1CHs7E6dkY">Sanjeev Mohan, Matt Butcher, Fermyon and Justin Cormack | KubeCon CloudNativeCon EU 2023</a></p>
						<p>Jon Brown, ESG - <a href="https://www.techtarget.com/searchitoperations/opinion/At-KubeCon-2023-observability-and-FinOps-high-on-the-agenda">At KubeCon 2023, observability and FinOps high on the agenda</a></p>
						<p>Paul Nashawaty, ESG - <a href="https://www.techtarget.com/searchitoperations/opinion/Takeaways-and-emerging-trends-from-KubeCon-North America-2023">Takeaways and emerging trends from KubeCon North America 2023</a></p>
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
						href="https://events.linuxfoundation.org/kubecon-cloudnativecon-North America/sponsor-list/"
						title="See all Sponsors and Partners of KubeCon + CloudNativeCon North America 2023"
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
							videotitle="Highlights from KubeCon + CloudNativeCon North America 2023"
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

						<p>Check out our <a href="https://community.cncf.io/">calendar for community events near you</a> and don't forget to <a href="https://www.lfasiallc.com/kubecon-cloudnativecon-open-source-summit-china/">register for KubeCon + CloudNativeCon + Open Source Summit China</a> in Shanghai, 26 - 28 September, 2023, and <a href="https://events.linuxfoundation.org/kubecon-cloudnativecon-north-america/">KubeCon + CloudNativeCon North America</a> in Chicago, 6 - 9 November 2023.</p>
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
