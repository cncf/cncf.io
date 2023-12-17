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
			class="section-03 is-style-down-gradient alignfull">

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
							<p>Talks are selected by the program committee through a rigorous, non-bias process where they are randomly assigned submissions to review within their area of expertise. You can read the details in our <a href="https://events.linuxfoundation.org/kubecon-cloudnativecon-north-america/program/submission-reviewer-guidelines/">Submission Reviewer Guidelines</a>, and specifically about the <a href="https://www.cncf.io/blog/2022/08/03/inside-the-numbers-the-kubecon-cloudnativecon-selection-process-for-north-america-2022/">North America selection process</a>.</p>
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

				<div class="lf-grid kccnc-table-container">
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

				<!-- Tweet -->
				<section class="section-tweet">
					<a href="https://twitter.com/kiranmova/status/1723317410256556230">
					<?php LF_Utils::display_responsive_images( 98977, 'full', '1200px', null, 'lazy', 'Tweet screenshot' ); ?>
					</a>
				</section>

				<div aria-hidden="true" class="report-spacer-20"></div>

				<div class="shadow-hr"></div>

				<h2 class="section-header">Scholarships</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-10-col">
						<p class="opening-paragraph">More than <strong>1,940 people</strong> joined us for KubeCon + CloudNativeCon North America thanks to the Dan Kohn Scholarship Fund</p>
					</div>
				</div>

				<div class="lf-grid kccnc-table-container">
					<table class="kccnc-table">
						<thead>
							<tr>
								<th> Scholarships
								</th>
								<th>Total</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Travel Funding Scholarships</td>
								<td>226</td>
							</tr>
							<tr>
								<td>Registration Scholarships</td>
								<td>1,630</td>
							</tr>
							<tr>
								<td>Speaker Scholarships</td>
								<td>85</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<p class="sub-header">Sponsored by</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="sponsors-logos larger odd orphan-by-3 orphan-by-6">
				<div class="sponsors-logo-item">
					<a href="https://www.apple.com/jobs/us/" title="Go to apple" 
					style="-webkit-transform: scale(0.85); -ms-transform: scale(0.85); transform: scale(0.85);">
					<img decoding="async" width="400" height="245" src="https://events.linuxfoundation.org/wp-content/uploads/2020/01/apple-NEW2-01.svg" class="logo wp-post-image" alt="apple logo" loading="lazy" />
				</a></div>
				<div class="sponsors-logo-item">
					<a href="https://cloud.google.com/" title="Go to Google Cloud" 
					style="-webkit-transform: scale(1.1); -ms-transform: scale(1.1); transform: scale(1.1);">
					<img decoding="async" width="3016" height="626" src="https://events.linuxfoundation.org/wp-content/uploads/2020/06/lockup_GoogleCloud_FullColor_rgb_2900x512px.svg" class="logo wp-post-image" alt="Google Cloud logo" loading="lazy" />
				</a></div>
				<div class="sponsors-logo-item">
					<a href="https://www.intel.com/content/www/us/en/developer/topic-technology/open/overview.html" title="Go to Intel" 
					style="-webkit-transform: scale(0.6); -ms-transform: scale(0.6); transform: scale(0.6);">
					<img decoding="async" width="71" height="29" src="https://events.linuxfoundation.org/wp-content/uploads/2020/01/logo-classicblue-72px.svg" class="logo wp-post-image" alt="Intel logo" loading="lazy" />
				</a></div>
				<div class="sponsors-logo-item">
					<a href="https://isovalent.com/" title="Go to Isovalent">
						<img decoding="async" width="734" height="103" src="https://events.linuxfoundation.org/wp-content/uploads/2021/07/Isovalent_writing_black.svg" class="logo wp-post-image" alt="Isovalent logo" loading="lazy" />
				</a></div>
				<div class="sponsors-logo-item">
					<a href="https://www.strongdm.com/" title="Go to strongDM">
						<img decoding="async" width="463" height="111" src="https://events.linuxfoundation.org/wp-content/uploads/2023/01/strongdm_logo_color-1.svg" class="logo wp-post-image" alt="strongDM logo" loading="lazy" />
				</a></div>
				</div>

			</div>
		</section>

		<div aria-hidden="true" class="report-spacer-60"></div>
		<a href="https://events.linuxfoundation.org/kubecon-cloudnativecon-europe/attend/diversity-inclusion/#general">
		<?php LF_Utils::display_responsive_images( 98990, 'full', '1200px', 'section-09__banner', 'lazy', 'Apply for a scholarship to join us at KubeCon + CloudNativeCon Europe 2024' ); ?>
		</a>

		<!-- Tweet -->
		<section class="section-tweet">
			<a href="https://twitter.com/oshi1136/status/1722944812909756519">
			<?php LF_Utils::display_responsive_images( 98992, 'full', '1200px', null, 'lazy', 'Tweet screenshot' ); ?>
			</a>
		</section>

		<div aria-hidden="true" class="report-spacer-120"></div>

		<section
			class="section-11 is-style-grey-background alignfull">

			<div class="container wrap">
				<h2 class="section-header">Security Hub</h2>
				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="lf-grid">
					<div class="restrictive-10-col">
					<p class="opening-paragraph">
						The Security Hub provided a dedicated space for attendees to learn, share, and collaborate on the latest Cloud Native security practices across all three days of KubeCon + CloudNativeCon. Covering a range of security-related topics, from securing software supply chains to implementing zero-trust security, managing security for cloud native infrastructure and applications, or building a security-first culture, it also featured a two-day unconference.
					</p>
				</div></div>
			</div>
			<div aria-hidden="true" class="report-spacer-100"></div>

		</section>

		<section class="section-08 alignfull">
			<div class="container wrap">

				<div aria-hidden="true" class="report-spacer-120"></div>
				<p class="sub-header">Unconference topics included:</p>
				<div aria-hidden="true" class="report-spacer-40"></div>


				<div class="lf-grid unconference">
					<div class="unconference-col1">
					<ul>
						<li>The Active Observer of a Zero Trust Architecture</li>
						<li>Seccomp policy usage: why is there no adoption?</li>
						<li>STRIDE threat model for the vSphere CSI Driver</li>
					</ul>
					</div>
					<div class="unconference-col2">
					<ul>
						<li>gittuf: A Security Layer for Git Repositories</li>
						<li>Don't Sign your Containers!</li>
						<li>TAG Security Supply Chain WG</li>
					</ul>
					</div>
				</div>

				<div class="shadow-hr"></div>
				<h2 class="section-header">AI Hub</h2>
				<div aria-hidden="true" class="report-spacer-40"></div>
				<div class="lf-grid">
					<div class="restrictive-10-col">

					<p class="opening-paragraph">
					The first ever AI Hub explored AI topics impacting the cloud native community through a lively and well-attended unconference. The unconference opened with a keynote from CERN’s Ricardo Rocha, and featured a demo by Guillaume Salou of Hugging Face.
					</p>
				</div></div>

			</div>
		</section>

		<section class="section-10 alignfull background-image-wrapper">

			<figure class="background-image-figure">
				<?php LF_Utils::display_responsive_images( 98991, 'full', '1200px', 'section-10__image', 'lazy', 'Man writing on a white board' ); ?>
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
			class="section-08 is-style-down-gradient alignfull">

			<div class="container wrap">

			<p class="sub-header">Unconference topics included:</p>
				<div aria-hidden="true" class="report-spacer-40"></div>


				<div class="lf-grid unconference">
					<div class="unconference-col1">
					<ul>
						<li>Dynamic Resource Allocation + SLURMS vs K8's</li>
						<li>How Can Cloud Native Be Relevant to AI Developers</li>
						<li>Unconference Session - Autoscaling LLM's on K8's and From Zero</li>
					</ul>
					</div>
					<div class="unconference-col2">
					<ul>
						<li>AI/LLM Training + Interference Across Locations</li>
						<li>FastTrack ML Experiment Tracking</li>
						<li>Multi-Tenant AI Inference Clusters Weighing Security Against Resource Sharing</li>
					</ul>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<div class="lf-grid kids">
					<div class="kids-col1">

					<?php LF_Utils::display_responsive_images( 98993, 'full', '1200px', 'section-10__image', 'lazy', 'Man writing on a white board' ); ?>

					</div>
					<div class="kids-col2">
					<p class="opening-paragraph">
					On Sunday, November 5, we hosted a complimentary Kid’s Day in Chicago, in partnership with Chicago Public Schools. The event was attended by <strong>61</strong> participants, and featured four workshops:
					</p>
					<ol>
						<li>Minecraft Modding</li>
						<li>Phippy and Friends Raspberry Pi Zoo Rescue</li>
						<li>Stories and Games with Scratch</li>
						<li>Sonic Pi workshop for kids — Unleashing the magic of music through code</li>
					</ol>
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
					<div class="section-number">5/6</div>
				</div>


				<div class="lf-grid intro">
					<div class="intro-col1">
						<p class="opening-paragraph">
						We're committed to sustainability at our events and KubeCon + CloudNativeCon North America was no exception.
						</p>
						<p>
						Our venue, McCormick Place, proudly leads the way in hosting environmentally conscious meetings and events. They have pioneered innovative strategies to minimize their carbon footprint, earning recognition from third-party, independent validations like LEED, APEX, Green Seal, and the U.S. Environmental Protection Agency. You can read more about their Sustainability Program here. In addition to selecting an environmentally conscious venue, we also implemented the following practices at this year’s event:
						</p>

						<ul>
						<li>Conference lanyards were made from <strong>100% Recycled Polyethylene Terephthalate</strong>. Our lanyard sponsor, Portworx by Pure Storage, collected all remaining lanyards to be used at a future event.</li>
						<li>Materials left by the event and sponsors were donated to the local Salvation Army.</li>
						<li>Food that was not served was donated to Fight2Feed, a local charitable organization that stocks soup kitchens and shelters. More than <strong>4,800 pounds of food was donated</strong> from the event!</li>
						<li>All food and beverage disposable service ware was compostable and we were an active participant in the venue’s composting program. More than <strong>11,000 pounds of product from the event was composted</strong>.</li>
						<li>Participation in McCormick Place’s campus-wide carpet and cardboard recycling programs.</li>
						<li>90% of exhibitor floor carpet was repurposed.</li>
						<li>The venue was accessible from all conference hotels via the CTA train system.</li>
						</ul>

					</div>
					<div class="intro-col2">
					<?php LF_Utils::display_responsive_images( 98994, 'full', '1200px', 'section-10__image', 'lazy', 'People getting food' ); ?>
					<?php LF_Utils::display_responsive_images( 98995, 'full', '1200px', 'section-10__image', 'lazy', 'Man talking to woman' ); ?>

					
					</div>
				</div>
				<div aria-hidden="true" class="report-spacer-120"></div>

				</div>

</section>


<section
	class="section-12 is-style-down-gradient alignfull">

	<div class="container wrap">

		<p class="section-header">health & safety <br />on-site overview</p>
		<div aria-hidden="true" class="report-spacer-80"></div>

		<div class="lf-grid">
			<div class="restrictive-10-col">

			<p class="opening-paragraph">
			KubeCon + CloudNativeCon implemented the following health and safety measures:
			</p>
		</div></div>

		<div class="lf-grid threecols">
			<div class="threecols-col1">

				<div class="icon-box-5">
					<div class="icon-box-5__icon"><img loading="lazy"
							width="100" height="100"
							src="<?php LF_Utils::get_svg( $report_folder . 'icon-sanitisation.svg', true ); ?>"
							alt="Sanitisation icon">
					</div>
					<div class="icon-box-5__text">Hand sanitizing stations were available throughout the venue
					</div>
				</div>

		</div>
			<div class="threecols-col2">

				<div class="icon-box-5">
					<div class="icon-box-5__icon"><img loading="lazy"
							width="100" height="100"
							src="<?php LF_Utils::get_svg( $report_folder . 'icon-health-mask.svg', true ); ?>"
							alt="Health mask icon">
					</div>
					<div class="icon-box-5__text">Face masks were available upon request at registration
					</div>
				</div>

			</div>
			<div class="threecols-col3">

				<div class="icon-box-5">
					<div class="icon-box-5__icon"><img loading="lazy"
							width="100" height="100"
							src="<?php LF_Utils::get_svg( $report_folder . 'icon-health-band.svg', true ); ?>"
							alt="Health mask icon">
					</div>
					<div class="icon-box-5__text">Wearable indicators denoting social distance comfort levels
					</div>
				</div>

			</div>
		</div>

		<div aria-hidden="true" class="report-spacer-100"></div>

		<div class="lf-grid">
			<div class="restrictive-8-col">
				<p>Incident Transparency Report:</p>
				<ul>
					<li>Four Code of Conduct reports received onsite (involving an offsite incident and security response)</li>
					<li>Four attendees utilized on-site EMT services during the event.</li>
					<li>We received notification of two COVID-19 cases.</li>
				</ul>
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
			<div class="section-number">6/6</div>
		</div>

		<p class="sub-header">Key Stats</p>

		<div aria-hidden="true" class="report-spacer-60"></div>

		<div class="lf-grid section-14__coverage">

			<div class="section-14__coverage-col1">
				<!-- Icon Box 3  -->
				<div class="icon-box-3">
					<div class="icon">
						<img loading="lazy" width="64" height="64" src="<?php LF_Utils::get_svg( $report_folder . 'icon-bell.svg', true ); ?>" alt="Bell icon">
					</div>
					<div class="text">
						<span class="number">5,763</span><br />
						<span class="description">Mentions of Kubecon<br/>+ Cloudnativecon</span>
					</div>
				</div>
				<!-- End of Icon Box 3 -->
			</div>
			<div class="section-14__coverage-col2">
				<!-- Icon Box 3  -->
				<div class="icon-box-3">
					<div class="icon">
						<img loading="lazy" width="64" height="64" src="<?php LF_Utils::get_svg( $report_folder . 'icon-graph-b.svg', true ); ?>" alt="Graph icon">
					</div>
					<div class="text">
						<span class="number">50%&nbsp;</span>
						<img loading="lazy" width="40" height="24" src="<?php LF_Utils::get_svg( $report_folder . 'up-arrow.svg', true ); ?>" alt="Up arrow">
						<br />
						<span class="description">Increase from 2022<br/>North America event </span>

					</div>
				</div>
				<!-- End of Icon Box 3 -->
			</div>
			<div class="section-14__coverage-col3">
				<!-- Icon Box 3  -->
				<div class="icon-box-3">
					<div class="icon">
						<img loading="lazy" width="64" height="64" src="<?php LF_Utils::get_svg( $report_folder . 'icon-share-b.svg', true ); ?>" alt="Share icon">
					</div>
					<div class="text">
						<span class="number">461k</span><br />
						<span class="description">@CloudNativeFdn Twitter<br />handle impressions </span>
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
						<img loading="lazy" width="64" height="64" src="<?php LF_Utils::get_svg( $report_folder . 'icon-heart-b.svg', true ); ?>" alt="Heart icon">
					</div>
					<div class="text">
						<span class="number">461K+</span><br />
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
						<img loading="lazy" width="64" height="64" src="<?php LF_Utils::get_svg( $report_folder . 'icon-click.svg', true ); ?>" alt="Click icon">
					</div>
					<div class="text">
						<span class="number">10.5K</span><br />
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
						<img loading="lazy" width="64" height="64" src="<?php LF_Utils::get_svg( $report_folder . 'youtube.svg', true ); ?>" alt="Youtube icon">
					</div>
					<div class="text">
						<span class="number">6K+</span><br />
						<span class="description">EVENT SESSION
							VIEWS</span>
						<span class="addendum">As of December 8, event session videos have garnered more than <strong>9,036</strong> views</span>
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
						<span class="number">3,691</span><br />
						<span class="addendum">mentions in media
						articles, press<br/> releases, and blogs.</span>
					</div>
				</div>
				<!-- End of Icon Box 3 -->
			</div>
			<div class="section-14__analyst-col2">
				<!-- Icon Box 3  -->
				<div class="icon-box-3">
					<?php LF_Utils::display_responsive_images( 90436, 'full', '200px', 'svg-image', 'lazy', 'Kubernetes Logo' ); ?>
					<div class="text">
						<span class="number">4,412</span><br />
						<span class="addendum">mentions in media
							articles, press<br/> releases, and blogs.</span>
					</div>
				</div>
				<!-- End of Icon Box 3 -->
			</div>
			<div class="section-14__analyst-col3">
				<!-- Icon Box 3  -->
				<div class="icon-box-3">
					<?php LF_Utils::display_responsive_images( 90435, 'full', '200px', 'svg-image', 'lazy', 'KubeCon + CloudNativeCon Logo' ); ?>
					<div class="text">
						<span class="number">5,768</span><br />
						<span class="addendum">mentions in media
						articles, press<br/> releases, and blogs.</span>
					</div>
				</div>
				<!-- End of Icon Box 3 -->
			</div>
			<div aria-hidden="true" class="report-spacer-100"></div>
		</div>
		
	</div>
	</section>
	<section id="media" class="section-14 is-style-down-gradient alignfull">
	<div class="container wrap">

		<h2 class="section-header">Coverage Overview</h2>

		<div aria-hidden="true" class="report-spacer-40"></div>

		<div class="lf-grid">
			<div class="restrictive-9-col">
				<p>KubeCon + CloudNativeCon North America was attended both in person and virtually by 158 media and industry analysts. The coverage they generated has been immense, with a 50% increase since the Detroit event in 2022, hitting over 5,700 articles and press releases. The CNCF PR and AR team hosted two media and analyst roundtables at the event focusing on developer experience, and what’s next in cloud native, in addition to an end user panel at the press and analyst conference. The team also put on a stand-alone analyst event, which included an additional end user panel geared toward an analyst audience.</p>
			</div>
		</div>

		<div class="shadow-hr"></div>

		<h2 class="sub-header">Media Coverage Quote Highlights</h2>
		<div aria-hidden="true" class="report-spacer-60"></div>

		<div class="quote-with-name-container">
			<p class="quote-with-name-container__quote">There’s a growing recognition of the need for better collaboration across teams and leveraging community-driven patterns to avoid redundant efforts. A significant gap identified was the need to make infrastructure more invisible to developers, allowing them to focus more on strategic aspects of their work. This gap drives the popularity of CNCF projects like Backstage</p>
			<div class="quote-with-name-container__marks">
				<p class="quote-with-name-container__name">Roy Chua</p>
				<p class="quote-with-name-container__position">Silverlinings</p>
			</div>
		</div>
		<div aria-hidden="true" class="report-spacer-80"></div>


		<div class="quote-with-name-container">
			<p class="quote-with-name-container__quote">The road ahead is challenging but undeniably exciting, with Kubernetes still the helm of this transformative journey.</p>
			<div class="quote-with-name-container__marks">
				<p class="quote-with-name-container__name">Roy Chua</p>
				<p class="quote-with-name-container__position">Silverlinings</p>
			</div>
		</div>
		<div aria-hidden="true" class="report-spacer-80"></div>

		<button class="button-reset section-14__button"
			data-id="js-hidden-section-trigger-open">
			See Full List
			<?php LF_Utils::get_svg( $report_folder . 'arrow-down.svg' ); ?>
		</button>

		<div class="section-14__hidden-section"
			data-id="js-hidden-section">

			<div class="section-14__hidden-section-content">

				<div class="quote-with-name-container">
					<p class="quote-with-name-container__quote">Operators have arrived at KubeCon, signaling Kubernetes’ transition to a mature and important platform for organizations that make money.</p>
					<div class="quote-with-name-container__marks">
						<p class="quote-with-name-container__name">Justin Warren</p>
						<p class="quote-with-name-container__position">Forbes</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-80"></div>
				<div class="quote-with-name-container">
					<p class="quote-with-name-container__quote">Kubernetes is no longer just a science experiment used by giddy developers testing out new ideas, most of which fail. It now supports successful initiatives that make real money for businesses large and small. With revenue and profits on the line, the people tasked with keeping infrastructure alive—the operators—have well and truly arrived at KubeCon.</p>
					<div class="quote-with-name-container__marks">
					<p class="quote-with-name-container__name">Justin Warren</p>
						<p class="quote-with-name-container__position">Forbes</p>
					</div>
				</div>

		</div></div>

		<button
			class="button-reset section-14__button section-14__button-close"
			style="display: none;"
			data-id="js-hidden-section-trigger-close">
			<?php LF_Utils::get_svg( $report_folder . 'arrow-up.svg' ); ?>
			Close Full List
		</button>

		<div class="shadow-hr"></div>

		<p class="sub-header">Media Coverage</p>

<div aria-hidden="true" class="report-spacer-60"></div>

<div class="logo-grid">

	<div class="logo-grid__box">
		<?php LF_Utils::display_responsive_images( 53227, 'full', '600px', 'svg-image logo-grid__image', 'lazy', 'Business Insider Logo' ); ?>
	</div>
	<div class="logo-grid__box">
		<?php LF_Utils::display_responsive_images( 90420, 'full', '600px', 'svg-image logo-grid__image', 'lazy', 'ComputerWeekly Logo' ); ?>
	</div>
	<div class="logo-grid__box">
		<?php LF_Utils::display_responsive_images( 99007, 'full', '600px', 'svg-image logo-grid__image', 'lazy', 'Container Journal Logo' ); ?>
	</div>
	<div class="logo-grid__box">
		<?php LF_Utils::display_responsive_images( 90437, 'full', '600px', 'svg-image logo-grid__image', 'lazy', 'Forbes Logo' ); ?>
	</div>
	<div class="logo-grid__box">
		<?php LF_Utils::display_responsive_images( 99008, 'full', '600px', 'svg-image logo-grid__image', 'lazy', 'IDG Connect Logo' ); ?>
	</div>
	<div class="logo-grid__box">
		<?php LF_Utils::display_responsive_images( 99009, 'full', '600px', 'svg-image logo-grid__image', 'lazy', 'InfoQ Logo' ); ?>
	</div>
	<div class="logo-grid__box">
		<?php LF_Utils::display_responsive_images( 99010, 'full', '600px', 'svg-image logo-grid__image', 'lazy', 'InformationWeek Logo' ); ?>
	</div>
	<div class="logo-grid__box">
		<?php LF_Utils::display_responsive_images( 90423, 'full', '600px', 'svg-image logo-grid__image', 'lazy', 'Lemonde Logo' ); ?>
	</div>
	<div class="logo-grid__box">
		<?php LF_Utils::display_responsive_images( 99011, 'full', '600px', 'svg-image logo-grid__image', 'lazy', 'Protocol Logo' ); ?>
	</div>
	<div class="logo-grid__box">
		<?php LF_Utils::display_responsive_images( 90439, 'full', '600px', 'svg-image logo-grid__image', 'lazy', 'SDX Central Logo' ); ?>
	</div>
	<div class="logo-grid__box">
		<?php LF_Utils::display_responsive_images( 99016, 'full', '600px', 'svg-image logo-grid__image', 'lazy', 'SiliconAngle Logo' ); ?>
	</div>
	<div class="logo-grid__box">
		<?php LF_Utils::display_responsive_images( 99012, 'full', '600px', 'svg-image logo-grid__image', 'lazy', 'TechCrunch Logo' ); ?>
	</div>
	<div class="logo-grid__box">
		<?php LF_Utils::display_responsive_images( 90428, 'full', '600px', 'svg-image logo-grid__image', 'lazy', 'TechTarget Logo' ); ?>
	</div>
	<div class="logo-grid__box">
		<?php LF_Utils::display_responsive_images( 90430, 'full', '600px', 'svg-image logo-grid__image', 'lazy', 'TFIR Logo' ); ?>
	</div>
	<div class="logo-grid__box">
		<?php LF_Utils::display_responsive_images( 99013, 'full', '600px', 'svg-image logo-grid__image', 'lazy', 'The New Stack Logo' ); ?>
	</div>
	<div class="logo-grid__box">
		<?php LF_Utils::display_responsive_images( 99014, 'full', '600px', 'svg-image logo-grid__image', 'lazy', 'The Register Logo' ); ?>
	</div>
	<div class="logo-grid__box">
		<?php LF_Utils::display_responsive_images( 99015, 'full', '600px', 'svg-image logo-grid__image', 'lazy', 'VM Blog Logo' ); ?>
	</div>
	<div class="logo-grid__box">
		<?php LF_Utils::display_responsive_images( 53218, 'full', '600px', 'svg-image logo-grid__image', 'lazy', 'ZD Net Logo' ); ?>
	</div>
</div>

<div class="shadow-hr"></div>

		<p class="sub-header">Media Coverage Highlights</p>

		<div aria-hidden="true" class="report-spacer-60"></div>

		<div class="lf-grid">
			<div class="restrictive-9-col">
			<p>Over <strong>5,700</strong> articles and press release reposts published from KubeCon + CloudNativeCon North America in leading outlets (as of November 21)</p>
			</div>
		</div>

		<div aria-hidden="true" class="report-spacer-60"></div>

		</div>

</section>


<section class="section-14b alignfull">

	<div class="container wrap">

		<div class="lf-grid kccnc-table-container">
			<table class="kccnc-table">
				<tbody>
					<tr>
						<td>The New Stack</td>
						<td>Meet SIG Cluster Lifecycle and Cluster API Maintainers at KubeConMeet SIG Cluster Lifecycle and Cluster API Maintainers at KubeCon</td>
					</tr>
					<tr>
						<td>The New Stack</td>
						<td>What Will Be Hot at KubeCon? Platform Engineering, of Course</td>
					</tr>
					<tr>
						<td>Cloud Native Now</td>
						<td>Cloud-Native AI Workloads: Scalability, Sustainability and Security</td>
					</tr>
					<tr>
						<td>TechTarget</td>
						<td>Emergent observability topics at KubeCon 2023</td>
					</tr>
					<tr>
						<td>InfoWorld</td>
						<td>KubeCon points to the future of enterprise IT</td>
					</tr>
					<tr>
						<td>SiliconANGLE</td>
						<td>The new era of Kubernetes and AI: theCUBE kicks off day 1 at KubeCon</td>
					</tr>
					<tr>
						<td>Forbes</td>
						<td>AI Speculation Dominates Cloud Native Conference</td>
					</tr>
				</tbody>
			</table>
		</div>

		<button class="button-reset section-14b__button"
			data-id="js-hidden-section-trigger-open">
			See Full List
			<?php LF_Utils::get_svg( $report_folder . 'arrow-down.svg' ); ?>
		</button>

		<div class="section-14b__hidden-section"
			data-id="js-hidden-section">

			<div class="section-14b__hidden-section-content">


				<div class="lf-grid kccnc-table-container">
					<table class="kccnc-table">
						<tbody>
							<tr>
								<td>SiliconANGLE</td>
								<td>The role of Kubernetes in shaping the cloud and AI landscape: theCUBE’s analysis, KubeCon Day 2 kickoff</td>
							</tr>
							<tr>
								<td>SiliconANGLE</td>
								<td>KubeCon Day 1 review: Dissecting trends around the changing cloud-native landscape</td>
							</tr>
							<tr>
								<td>SiliconANGLE</td>
								<td>Ford revs up cloud-native innovation, tackles Kubernetes challenges with Portworx partnership</td>
							</tr>
							<tr>
								<td>SiliconANGLE</td>
								<td>Evolving security solutions in the AI era: No ‘silver bullet’ for cloud-native security</td>
							</tr>
							<tr>
								<td>SiliconANGLE</td>
								<td>Medical research team relies on Kubernetes-based IBM solution for sharing critical data</td>
							</tr>
							<tr>
								<td>The Register</td>
								<td>The Cloud Native Computing Foundation leaps aboard the AI bandwagon</td>
							</tr>
							<tr>
								<td>The New Stack</td>
								<td>Don’t Rely on eBPF Alone for Kubernetes</td>
							</tr>
							<tr>
								<td>SiliconANGLE</td>
								<td>AI, Kubernetes and more: Decoding trends shaping CNCF’s future</td>
							</tr>
							<tr>
								<td>Forbes</td>
								<td>The Serious Money Has Arrived At KubeCon</td>
							</tr>
							<tr>
								<td>Forbes</td>
								<td>Backstage Project Takes Center Stage At KubeCon North America 2023</td>
							</tr>
							<tr>
								<td>Sliverlinings</td>
								<td>Industry Voices: Kubernetes reigns — Observations from KubeCon</td>
							</tr>
							<tr>
								<td>InfoWorld</td>
								<td>Everyone in cloud computing is scurrying to find a genAI strategy</td>
							</tr>
							<tr>
								<td>SiliconANGLE</td>
								<td>CNCF Deaf and Hard of Hearing Working Group promotes inclusivity in tech by offering a level playing field</td>
							</tr>
						</tbody>
					</table>
				</div>
		</div></div>

		<button
			class="button-reset section-14b__button section-14b__button-close"
			style="display: none;"
			data-id="js-hidden-section-trigger-close">
			<?php LF_Utils::get_svg( $report_folder . 'arrow-up.svg' ); ?>
			Close Full List
		</button>

		<div class="shadow-hr"></div>


		</div>

</section>


<section class="section-14c alignfull">

	<div class="container wrap">

		<p class="sub-header">Industry Analyst Coverage Highlights</p>

		<div aria-hidden="true" class="report-spacer-60"></div>

		<div class="lf-grid">
			<div class="restrictive-9-col">
			<p>Analyst reports, blogs and articles published on topics related to Cloud Native ecosystem by attending KubeCon + CloudNativeCon North America analysts (as of November 10, 2022).</p>
			</div>
		</div>

		<div aria-hidden="true" class="report-spacer-80"></div>

		<div class="quote-with-name-container">
			<p class="quote-with-name-container__title">KubeCon Katchup: Managing Sprawl, Observability, And Cost</p>
			<p class="quote-with-name-container__quote">CHICAGO – KubeCon – A few things stuck out here at the KubeCon conference for cloud tech pros. Cloud-native technology has clearly taken the world by storm – but the explosion of cloud native tools, technologies, and gizmos is a bit overwhelming, and we have probably entered a digestion phase.</p>
			<div class="quote-with-name-container__marks">
				<p class="quote-with-name-container__name">R. Scott Raynovich</p>
				<p class="quote-with-name-container__position">Futuriom</p>
			</div>
		</div>
		<div aria-hidden="true" class="report-spacer-80"></div>

		<div class="quote-with-name-container">
			<p class="quote-with-name-container__title">Back from #KubeCon in Chicago. My notes</p>
			<p class="quote-with-name-container__quote">Software supply chain security is big. The CNCF has conducted audits on Argo and Prometheus. Good to hear about the work of the Open Source Security Foundation at KubeCon.</p>
			<div class="quote-with-name-container__marks">
				<p class="quote-with-name-container__name">Mark O’Neill</p>
				<p class="quote-with-name-container__position">Gartner</p>
			</div>
		</div>
		<div aria-hidden="true" class="report-spacer-40"></div>


		<button class="button-reset section-14c__button"
			data-id="js-hidden-section-trigger-open">
			See Full List
			<?php LF_Utils::get_svg( $report_folder . 'arrow-down.svg' ); ?>
		</button>

		<div class="section-14c__hidden-section"
			data-id="js-hidden-section">

			<div class="section-14c__hidden-section-content">

			<div class="quote-with-name-container">
			<p class="quote-with-name-container__title">KubeCon + CloudNativeCon 2023 cloud-native vendor highlights</p>
			<p class="quote-with-name-container__quote">KubeCon + CloudNativeCon North America 2023 attendees were left with a lasting impression of the cloud native innovative advancements for today and in the future. The event served as a hub for new ideas, collaborations, and advancements in cloud native technologies, highlighting the collective dedication to shaping the future of the industry.</p>
			<div class="quote-with-name-container__marks">
				<p class="quote-with-name-container__name">Paul Nashawaty</p>
				<p class="quote-with-name-container__position">ESG</p>
			</div>
		</div>
		<div aria-hidden="true" class="report-spacer-80"></div>

		<div class="quote-with-name-container">
			<p class="quote-with-name-container__title">Insights from KubeCon + CloudNativeCon 2023</p>
			<p class="quote-with-name-container__quote">YouTube video</p>
			<div class="quote-with-name-container__marks">
				<p class="quote-with-name-container__name">Paul Nashawaty,Melinda Marks, and Jon Brown</p>
				<p class="quote-with-name-container__position">ESG</p>
			</div>
		</div>
		<div aria-hidden="true" class="report-spacer-80"></div>

		<div class="quote-with-name-container">
			<p class="quote-with-name-container__title">Emergent observability topics at KubeCon 2023</p>
			<p class="quote-with-name-container__quote">New use cases like cost management, sustainability and scalability will lead observability discussions in the North American KubeCon + CloudNativeCon 2023 conference.</p>
			<div class="quote-with-name-container__marks">
				<p class="quote-with-name-container__name">Jon Brown</p>
				<p class="quote-with-name-container__position">ESG</p>
			</div>
		</div>
		<div aria-hidden="true" class="report-spacer-80"></div>

		<div class="quote-with-name-container">
			<p class="quote-with-name-container__title">At KubeCon NA 2023, finding cloud independence on the edges of Kubernetes</p>
			<p class="quote-with-name-container__quote">At KubeCon/CloudNativeCon North America 2023 this past week in Chicago, discussion turned from the ubiquity of the software container orchestrator Kubernetes as the heart of cloud native development to addressing a vast ecosystem of projects and vendors, which in turn are enabling applications and data to become more distributed and independent from any particular underlying cloud or on-premises infrastructure.</p>
			<div class="quote-with-name-container__marks">
				<p class="quote-with-name-container__name">Jason English</p>
				<p class="quote-with-name-container__position">Intellyx</p>
			</div>
		</div>
		<div aria-hidden="true" class="report-spacer-80"></div>

		<div class="quote-with-name-container">
			<p class="quote-with-name-container__title">eBPF and OpenTelemetry Rule At KubeCon 2023 in Chicago: Observability Is King</p>
			<p class="quote-with-name-container__quote">While the Kubernetes platform constituted the overall ‘backdrop’ for KubeCon 2023, OpenTelemetry and eBPF (extended Berkeley Packet Filter) were the most discussed topics of the show. Both technologies aim to standardize, simplify, and automate observability, visibility, and monitoring of cloud native applications across data centers, private clouds, public clouds, and edge locations.</p>
			<div class="quote-with-name-container__marks">
				<p class="quote-with-name-container__name">Torsten Volk</p>
				<p class="quote-with-name-container__position">EMA</p>
			</div>
		</div>
		<div aria-hidden="true" class="report-spacer-80"></div>

		<div class="quote-with-name-container">
			<p class="quote-with-name-container__title">Three insights you might have missed from KubeCon + CloudNativeCon NA</p>
			<p class="quote-with-name-container__quote">CNCF is known for providing open source and bringing this massive developer base into helping things out with the cloud, which they did a really good job [with]. If you look at all the projects that graduated, Kubernetes is right at the top.</p>
			<div class="quote-with-name-container__marks">
				<p class="quote-with-name-container__name">Andy Thurai</p>
				<p class="quote-with-name-container__position">Constellation Research, Inc</p>
			</div>
		</div>
		<div aria-hidden="true" class="report-spacer-40"></div>

		</div></div>

		<button
			class="button-reset section-14c__button section-14c__button-close"
			style="display: none;"
			data-id="js-hidden-section-trigger-close">
			<?php LF_Utils::get_svg( $report_folder . 'arrow-up.svg' ); ?>
			Close Full List
		</button>

		<div class="shadow-hr"></div>


	</div>
</section>

<!-- SPONSORS 8/8  -->
<section id="sponsors"
	class="section-15 alignfull">

	<div class="container wrap">

		<h2 class="section-header">Sponsor<br> Information</h2>
		<div aria-hidden="true" class="report-spacer-80"></div>

		<div class="lf-grid">
			<div class="restrictive-9-col">
				<p
					class="opening-paragraph">A huge thank you to our Sponsors!</p>
			</div>
		</div>


		<div class="kccnc-table-container">
			<table class="kccnc-table yoy-table">
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
						<td>Diamond</td>
						<td>8</td>
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
						<td>3</td>
						<td>17</td>
						<td>20</td>
						<td>35</td>
						<td>8</td>
						<td>20</td>
						<td>28</td>
						<td>27</td>
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
						<td>34</td>
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
						<td>124</td>
					</tr>
					<tr>
						<td class="nowrap">Start-up</td>
						<td>N/A</td>
						<td>30</td>
						<td>50</td>
						<td>73</td>
						<td>38</td>
						<td>76</td>
						<td>93</td>
						<td>81</td>
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
						<td>2</td>
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
						<td>50</td>
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
						<td>277</td>
					</tr>
				</tbody>
			</table>
		</div>

		<div aria-hidden="true" class="report-spacer-20"></div>

		<span>* Capped Maximum</span>

		<div aria-hidden="true" class="report-spacer-100"></div>

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
						<td>90,975</td>
					</tr>
					<tr>
						<td>Onsite leads average/booth</td>
						<td>342</td>
					</tr>
				</tbody>
			</table>
		</div>


		<div class="shadow-hr"></div>

		<p class="sub-header"
			style="margin:auto; text-align:center">Diamond Sponsors</p>

		<div aria-hidden="true" class="report-spacer-60"></div>


		<div class="sponsors-logos largest odd orphan-by-3 orphan-by-6">
			<div class="sponsors-logo-item"><a href="https://aws-kubecon-na-2023.splashthat.com/" title="Go to AWS" target="_blank" rel="noopener"><img decoding="async" width="400" height="245" src="https://events.linuxfoundation.org/wp-content/uploads/amazon-web-services-spn.svg" class="logo wp-post-image" alt="AWS logo" loading="lazy" /></a></div>
			<div class="sponsors-logo-item"><a href="https://technology.discover.com/" title="Go to discover" target="_blank" rel="noopener"><img decoding="async" width="197" height="39" src="https://events.linuxfoundation.org/wp-content/uploads/2020/01/Discover-Primary-RGB-Black-1.svg" class="logo wp-post-image" alt="discover logo" loading="lazy" /></a></div>
			<div class="sponsors-logo-item"><a href="https://azure.microsoft.com/en-us/overview/kubernetes-on-azure/" title="Go to Microsoft Azure" target="_blank" rel="noopener"><img decoding="async" width="400" height="245" src="https://events.linuxfoundation.org/wp-content/uploads/microsoft-azure-spn.svg" class="logo wp-post-image" alt="Microsoft Azure logo" loading="lazy" /></a></div>
			<div class="sponsors-logo-item"><a href="https://developer.oracle.com/open-source.html?source=:ex:sn:::::RC_WWMK220606P00116:KubeCon_NA_Website&#038;SC=:ex:sn:::::RC_WWMK220606P00116:KubeCon_NA_Website&#038;pcode=WWMK220606P00116" title="Go to Oracle Logo" style="-webkit-transform: scale(0.8); -ms-transform: scale(0.8); transform: scale(0.8);" target="_blank" rel="noopener"><img decoding="async" width="231" height="112" src="https://events.linuxfoundation.org/wp-content/uploads/2022/08/Oracle_Cloud-Infrastructure_stacked_rgb-1.svg" class="logo wp-post-image" alt="Oracle Logo logo" loading="lazy" /></a></div>
			<div class="sponsors-logo-item"><a href="https://www.suse.com/products/suse-rancher/" title="Go to rancher by suse" style="-webkit-transform: scale(0.99); -ms-transform: scale(0.99); transform: scale(0.99);" target="_blank" rel="noopener"><img decoding="async" width="146" height="35" src="https://events.linuxfoundation.org/wp-content/uploads/2020/01/rancher-suse-logo-horizontal_horizontal-color.svg" class="logo wp-post-image" alt="rancher by suse logo" loading="lazy" /></a></div>
			<div class="sponsors-logo-item"><a href="https://www.redhat.com/" title="Go to Red Hat" target="_blank" rel="noopener"><img decoding="async" width="400" height="245" src="https://events.linuxfoundation.org/wp-content/uploads/RedHat-new.svg" class="logo wp-post-image" alt="Red Hat logo" loading="lazy" /></a></div>
			<div class="sponsors-logo-item"><a href="http://www.veritas.com/solution/kubernetes" title="Go to Veritas KubeCon" target="_blank" rel="noopener"><img decoding="async" width="408" height="92" src="https://events.linuxfoundation.org/wp-content/uploads/2020/09/Veritas-01.svg" class="logo wp-post-image" alt="Veritas KubeCon logo" loading="lazy" /></a></div>
		</div>

		<div aria-hidden="true" class="report-spacer-100"></div>

		<p class="sub-header"
			style="margin:auto; text-align:center">Platinum Sponsors</p>

		<div aria-hidden="true" class="report-spacer-60"></div>

		<div class="sponsors-logos larger odd">
			<div class="sponsors-logo-item"><a href="https://www.arm.com/" title="Go to arm" target="_blank" rel="noopener"><img decoding="async" width="400" height="245" src="https://events.linuxfoundation.org/wp-content/uploads/arm-spn-1.svg" class="logo wp-post-image" alt="arm logo" loading="lazy" /></a></div>
			<div class="sponsors-logo-item"><a href="https://ubuntu.com/" title="Go to Canonical Ubuntu" style="-webkit-transform: scale(0.9); -ms-transform: scale(0.9); transform: scale(0.9);" target="_blank" rel="noopener"><img decoding="async" width="1381" height="452" src="https://events.linuxfoundation.org/wp-content/uploads/2021/08/canonical-logo.svg" class="logo wp-post-image" alt="Canonical Ubuntu logo" loading="lazy" /></a></div>
			<div class="sponsors-logo-item"><a href="http://www.crowdstrike.com" title="Go to Crowdstrike Logo" style="-webkit-transform: scale(0.85); -ms-transform: scale(0.85); transform: scale(0.85);" target="_blank" rel="noopener"><img decoding="async" width="425" height="89" src="https://events.linuxfoundation.org/wp-content/uploads/2022/07/CS_Logos_2022_Inline_Red-Black_RGB_SVG.svg" class="logo wp-post-image" alt="Crowdstrike Logo logo" loading="lazy" /></a></div>
			<div class="sponsors-logo-item"><a href="https://www.datadoghq.com/" title="Go to datadog" target="_blank" rel="noopener"><img decoding="async" width="400" height="245" src="https://events.linuxfoundation.org/wp-content/uploads/datadog-spn.svg" class="logo wp-post-image" alt="datadog logo" loading="lazy" /></a></div>
			<div class="sponsors-logo-item"><a href="https://www.delltechnologies.com/" title="Go to Dell Stacked" style="-webkit-transform: scale(0.8); -ms-transform: scale(0.8); transform: scale(0.8);" target="_blank" rel="noopener"><img decoding="async" width="334" height="197" src="https://events.linuxfoundation.org/wp-content/uploads/2020/01/delltech-logo-stk-blue.svg" class="logo wp-post-image" alt="Dell Stacked logo" loading="lazy" /></a></div>
			<div class="sponsors-logo-item"><a href="https://www.nginx.com/" title="Go to F5 NGINX" style="-webkit-transform: scale(0.9); -ms-transform: scale(0.9); transform: scale(0.9);" target="_blank" rel="noopener"><img decoding="async" width="156" height="65" src="https://events.linuxfoundation.org/wp-content/uploads/2020/01/NGINX-Part-of-F5-horiz-black-type-rgb-1.svg" class="logo wp-post-image" alt="F5 NGINX logo" loading="lazy" /></a></div>
			<div class="sponsors-logo-item"><a href="https://www.fortinet.com/" title="Go to Fortinet" target="_blank" rel="noopener"><img decoding="async" width="406" height="60" src="https://events.linuxfoundation.org/wp-content/uploads/2021/07/Fortinet.svg" class="logo wp-post-image" alt="Fortinet logo" loading="lazy" /></a></div>
			<div class="sponsors-logo-item"><a href="https://about.gitlab.com/" title="Go to GitLab" target="_blank" rel="noopener"><img decoding="async" width="721" height="177" src="https://events.linuxfoundation.org/wp-content/uploads/2020/01/gitlab-logo-rgb.svg" class="logo wp-post-image" alt="GitLab logo" loading="lazy" /></a></div>
			<div class="sponsors-logo-item"><a href="https://cloud.google.com/" title="Go to Google Cloud" style="-webkit-transform: scale(1.1); -ms-transform: scale(1.1); transform: scale(1.1);" target="_blank" rel="noopener"><img decoding="async" width="3016" height="626" src="https://events.linuxfoundation.org/wp-content/uploads/2020/06/lockup_GoogleCloud_FullColor_rgb_2900x512px.svg" class="logo wp-post-image" alt="Google Cloud logo" loading="lazy" /></a></div>
			<div class="sponsors-logo-item"><a href="https://www.ibm.com/us-en/" title="Go to IBM" style="-webkit-transform: scale(0.7); -ms-transform: scale(0.7); transform: scale(0.7);" target="_blank" rel="noopener"><img decoding="async" width="441" height="175" src="https://events.linuxfoundation.org/wp-content/uploads/2020/01/IBM_logo┬_pos_blue60_CMYK.svg" class="logo wp-post-image" alt="IBM logo" loading="lazy" /></a></div>
			<div class="sponsors-logo-item"><a href="http://incident.io/" title="Go to incident.io " target="_blank" rel="noopener"><img decoding="async" width="1038" height="293" src="https://events.linuxfoundation.org/wp-content/uploads/2023/08/incident.io_.svg" class="logo wp-post-image" alt="incident.io  logo" loading="lazy" /></a></div>
			<div class="sponsors-logo-item"><a href="https://www.intel.com/content/www/us/en/developer/topic-technology/open/overview.html" title="Go to Intel" style="-webkit-transform: scale(0.6); -ms-transform: scale(0.6); transform: scale(0.6);" target="_blank" rel="noopener"><img decoding="async" width="71" height="29" src="https://events.linuxfoundation.org/wp-content/uploads/2020/01/logo-classicblue-72px.svg" class="logo wp-post-image" alt="Intel logo" loading="lazy" /></a></div>
			<div class="sponsors-logo-item"><a href="https://jfrog.com/" title="Go to jfrog" target="_blank" rel="noopener"><img decoding="async" width="400" height="245" src="https://events.linuxfoundation.org/wp-content/uploads/jfrog-spn.svg" class="logo wp-post-image" alt="jfrog logo" loading="lazy" /></a></div>
			<div class="sponsors-logo-item"><a href="https://www.kasten.io/" title="Go to Kasten by Veeam" style="-webkit-transform: scale(0.9); -ms-transform: scale(0.9); transform: scale(0.9);" target="_blank" rel="noopener"><img decoding="async" width="254" height="101" src="https://events.linuxfoundation.org/wp-content/uploads/2021/03/Kasten-logo-2022.svg" class="logo wp-post-image" alt="Kasten by Veeam logo" loading="lazy" /></a></div>
			<div class="sponsors-logo-item"><a href="https://opensearch.org/" title="Go to OpenSearch" target="_blank" rel="noopener"><img decoding="async" width="386" height="85" src="https://events.linuxfoundation.org/wp-content/uploads/2022/03/SVG-Logo.svg" class="logo wp-post-image" alt="OpenSearch logo" loading="lazy" /></a></div>
			<div class="sponsors-logo-item"><a href="https://outshift.com/" title="Go to Outshift by Cisco" style="-webkit-transform: scale(1.1); -ms-transform: scale(1.1); transform: scale(1.1);" target="_blank" rel="noopener"><img decoding="async" width="765" height="332" src="https://events.linuxfoundation.org/wp-content/uploads/2022/07/outshift_bycisco.svg" class="logo wp-post-image" alt="Outshift by Cisco logo" loading="lazy" /></a></div>
			<div class="sponsors-logo-item"><a href="https://portworx.com/" title="Go to Portworx by Pure Storage" target="_blank" rel="noopener"><img decoding="async" width="3161" height="1074" src="https://events.linuxfoundation.org/wp-content/uploads/2020/10/Portworx_Logo_Color.svg" class="logo wp-post-image" alt="Portworx by Pure Storage logo" loading="lazy" /></a></div>
			<div class="sponsors-logo-item"><a href="https://www.paloaltonetworks.com/prisma/cloud" title="Go to Palo Alto Networks/Prisma Cloud Logo" style="-webkit-transform: scale(1.35); -ms-transform: scale(1.35); transform: scale(1.35);" target="_blank" rel="noopener"><img decoding="async" width="1008" height="141" src="https://events.linuxfoundation.org/wp-content/uploads/2021/12/Parent-with-GTM_PANW_Prisma_smallcut.svg" class="logo wp-post-image" alt="Palo Alto Networks/Prisma Cloud Logo logo" loading="lazy" /></a></div>
			<div class="sponsors-logo-item"><a href="https://snyk.io/" title="Go to snyk" style="-webkit-transform: scale(1.01); -ms-transform: scale(1.01); transform: scale(1.01);" target="_blank" rel="noopener"><img decoding="async" width="400" height="245" src="https://events.linuxfoundation.org/wp-content/uploads/Snyk-spn.svg" class="logo wp-post-image" alt="snyk logo" loading="lazy" /></a></div>
			<div class="sponsors-logo-item"><a href="https://www.sonatype.com/" title="Go to Sonatype" target="_blank" rel="noopener"><img decoding="async" width="265" height="54" src="https://events.linuxfoundation.org/wp-content/uploads/2021/07/Sonatype_logo_full_color.svg" class="logo wp-post-image" alt="Sonatype logo" loading="lazy" /></a></div>
			<div class="sponsors-logo-item"><a href="https://www.sony-semicon.com/en/" title="Go to Sony" target="_blank" rel="noopener"><img decoding="async" width="693" height="143" src="https://events.linuxfoundation.org/wp-content/uploads/2021/09/Sony_GPVI_Logo_SonyBlue90_RGB-1.svg" class="logo wp-post-image" alt="Sony logo" loading="lazy" /></a></div>
			<div class="sponsors-logo-item"><a href="https://www.splunk.com/en_us/devops.html" title="Go to splunk" target="_blank" rel="noopener"><img decoding="async" width="400" height="245" src="https://events.linuxfoundation.org/wp-content/uploads/splunk-spn.svg" class="logo wp-post-image" alt="splunk logo" loading="lazy" /></a></div>
			<div class="sponsors-logo-item"><a href="https://sysdig.com/" title="Go to sysdig" target="_blank" rel="noopener"><img decoding="async" width="638" height="209" src="https://events.linuxfoundation.org/wp-content/uploads/2020/01/sysdig-logo-black.svg" class="logo wp-post-image" alt="sysdig logo" loading="lazy" /></a></div>
			<div class="sponsors-logo-item"><a href="https://goteleport.com/" title="Go to Teleport" target="_blank" rel="noopener"><img decoding="async" width="187" height="45" src="https://events.linuxfoundation.org/wp-content/uploads/2021/03/teleport-kcsp.svg" class="logo wp-post-image" alt="Teleport logo" loading="lazy" /></a></div>
			<div class="sponsors-logo-item"><a href="https://www.uptycs.com/" title="Go to Uptycs" target="_blank" rel="noopener"><img decoding="async" width="415" height="134" src="https://events.linuxfoundation.org/wp-content/uploads/2022/07/uptycs_logo_2C_on-light_rgb.svg" class="logo wp-post-image" alt="Uptycs logo" loading="lazy" /></a></div>
			<div class="sponsors-logo-item"><a href="https://tanzu.vmware.com/tanzu" title="Go to vmware" style="-webkit-transform: scale(1.1); -ms-transform: scale(1.1); transform: scale(1.1);" target="_blank" rel="noopener"><img decoding="async" width="400" height="245" src="https://events.linuxfoundation.org/wp-content/uploads/vmware-spn.svg" class="logo wp-post-image" alt="vmware logo" loading="lazy" /></a></div>
			<div class="sponsors-logo-item"><a href="https://www.wiz.io/" title="Go to Wiz" style="-webkit-transform: scale(0.7); -ms-transform: scale(0.7); transform: scale(0.7);" target="_blank" rel="noopener"><img decoding="async" width="1472" height="736" src="https://events.linuxfoundation.org/wp-content/uploads/2022/05/wiz-autocropped.svg" class="logo wp-post-image" alt="Wiz logo" loading="lazy" /></a></div>
		</div>

		<div class="shadow-hr"></div>

		<div class="wp-block-button"><a
				href="https://events.linuxfoundation.org/kubecon-cloudnativecon-north-america/sponsor-list/"
				title="See all Sponsors and Partners of KubeCon + CloudNativeCon North America 2023"
				class="wp-block-button__link">See
				all Sponsors and Partners</a>
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
					class="thanks__opening">We hope you enjoyed reflecting on a great event in Chicago - let's do it again in Paris!</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<p
					class="thanks__comments">Your comments and feedback are welcome at <a href="mailto:events@cncf.io">events@cncf.io</a></p>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<p>Check out our <a href="https://community.cncf.io/">calendar for community events near you</a> and don't forget to <a href="https://events.linuxfoundation.org/kubecon-cloudnativecon-europe/">register for KubeCon + CloudNativeCon Europe</a> in Paris, March, 2024.</p>
			</div>
			<div class="thanks__col2">
				<?php
					LF_Utils::display_responsive_images( 99036, 'full', '400px', null, 'lazy', 'CNCF Mascot' );
				?>
			</div>
		</div>
		<div aria-hidden="true" class="report-spacer-120"></div>

		<?php
			echo do_shortcode( '[event_banner hide_title=true]' );
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
