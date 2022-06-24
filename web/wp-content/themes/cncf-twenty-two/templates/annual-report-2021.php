<?php
/**
 * Template Name: Annual Report 2021
 * Template Post Type: lf_report
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

get_template_part( 'components/header' );

get_template_part( 'components/skip-link-target' );

// declare report PDF link to reference as variable.
$pdf_link = 'https://www.cncf.io/wp-content/uploads/2022/01/CNCF_Annual_Report_2021.pdf';

?>

<link rel="prefetch"
	href="<?php echo esc_url( get_template_directory_uri() . '/build/annual-report-2021.min.css' ); ?>"
	as="style" crossorigin="anonymous" />

<?php wp_enqueue_style( '2021', get_template_directory_uri() . '/build/annual-report-2021.min.css', array(), filemtime( get_template_directory() . '/build/annual-report-2021.min.css' ), 'all' ); ?>

<?php
// setup social share content.
$caption  = '2021 has been a huge year of growth at CNCF, which now hosts 120+ projects with over 142,000 contributors representing 189 countries. Read the CNCF Annual Report 2021: ';
$page_url = rawurlencode( get_permalink() );
$caption  = htmlspecialchars( rawurlencode( html_entity_decode( $caption, ENT_COMPAT, 'UTF-8' ) ), ENT_COMPAT, 'UTF-8' );

/**
 * Gets Twitter handle.
 */
$options = get_option( 'lf-mu' );
$options && $options['social_twitter_handle'] ? $twitter = $options['social_twitter_handle'] : $twitter = '';

$twitter_url  = 'https://twitter.com/intent/tweet?text=' . $caption . '&amp;url=' . $page_url . '&amp;hashtags=cncf&amp;via=' . $twitter . '';
$linkedin_url = 'https://www.linkedin.com/shareArticle?mini=true&url=' . $page_url . '&summary=' . $caption . '';
$mailto_url   = 'mailto:?subject=CNCF Annual Report 2021&body=' . $caption . '&nbsp;' . $page_url . '';
?>

<main class="ar-2021">
	<article class="container wrap">

		<section class="background-image-wrapper is-hero alignfull" height="500"
			style="min-height: 500px;">

			<div class="background-image-text-overlay">
				<div class="container wrap">

					<div aria-hidden="true" class="ar-spacer-120"></div>

					<h2 class="hero-title uppercase add-blob smaller">
						CNCF 2021</h2>

					<div aria-hidden="true" class="ar-spacer-30"></div>

					<div class="hero-align">
						<h1 class="hero-title-main uppercase">Annual <br />
							Report</h1>

						<div aria-hidden="true"
							class="ar-spacer-40 show-upto-700"></div>

						<h2 class="hero-subheader uppercase">The <br
								class="show-over-700"> evolution <br />of us
						</h2>
					</div>

					<div aria-hidden="true" class="ar-spacer-40"></div>

					<div class="hero-grid">

						<div class="ar-social-share">
							<p class="ss-title lh-100 mb-0 fw-semi">Share</p>

							<div class="ss-wrapper">
								<!-- twitter -->
								<?php if ( $twitter_url ) : ?>
								<a  aria-label="Share on Twitter"
									title="Share on Twitter"
									href="<?php echo esc_url( $twitter_url ); ?>"><?php Lf_Utils::get_svg( 'annual-reports/2021/social-twitter.svg' ); ?></a>
								<?php endif; ?>

								<!-- linkedin -->
								<?php if ( $linkedin_url ) : ?>
								<a
									aria-label="Share on Linkedin"
									title="Share on Linkedin"
									href="<?php echo esc_url( $linkedin_url ); ?>"><?php Lf_Utils::get_svg( 'annual-reports/2021/social-linkedin.svg' ); ?></a>
								<?php endif; ?>

								<!-- sendto email -->
								<?php if ( $mailto_url ) : ?>
								<a  aria-label="Share by Email"
									title="Share by Email"
									href="<?php echo esc_url( $mailto_url ); ?>"><?php Lf_Utils::get_svg( 'annual-reports/2021/social-mail.svg' ); ?></a>
								<?php endif; ?>
							</div>
						</div>

						<div class="hero-report-cta">

						<a href="<?php echo esc_url( $pdf_link ); ?>"
							title="Download CNCF Annual Report 2021 as a PDF"
							class="ar-button">Download<br class="show-over-500">
							full report</a>

							<p
							class="fw-semi text-smaller mb-0 uppercase lh-125"><a href="https://www.cncf.io/wp-content/uploads/2022/05/CNCF_Annual_Report_2021-ja.pdf" title="Download CNCF Annual Report 2021 in Japanese as PDF">or get the
							<?php
							Lf_Utils::get_svg( 'annual-reports/2021/jp.svg' );
							?>
							 Japanese version</a></p>

						</div>


						<p
							class="fw-semi text-medium mb-0">Navigate using the section headings<br class="show-over-1200"> or simply by scrolling.</p>

					</div>

					<div aria-hidden="true" class="ar-spacer-100 "></div>

					<div aria-hidden="true" class="ar-spacer-20 show-over-414">
					</div>

				</div>
			</div>

			<div class="overlay-layer nude-green-gradient-50"></div>

			<figure class="background-image-shape">
				<img width="1000" height="1070" loading="lazy" src="
				<?php
				Lf_Utils::get_svg( 'annual-reports/2021/shapes.svg', true );
				?>
				" alt="Background shapes">
			</figure>

			<figure class="background-image-figure green-gradient">
			</figure>

		</section>

		<section style="position: relative;">
			<div class="nav-el">
				<div class="nav-box">
					<a href="#momentum" title="Jump to Momentum section"
						class="box-link"></a>
					<img loading="lazy" width="36" height="36" src="
					<?php
					Lf_Utils::get_svg( 'annual-reports/2021/nav-01-bar.svg', true );
					?>
					" alt="Chart icon"> <span class="show-upto-1000">Momentum</span><span
						class="show-over-1000">2021<br />
						Momentum</span>
				</div>
				<div class="nav-box">
					<a href="#events" title="Jump to Events section"
						class="box-link"></a>
					<img loading="lazy" width="36" height="36" src="
					<?php
					Lf_Utils::get_svg( 'annual-reports/2021/nav-02-target.svg', true );
					?>
					" alt="Bullseye icon">
					<span class="show-upto-1000">Events</span><span
						class="show-over-1000">Virtual & <br /> hybrid
						events</span>
				</div>
				<div class="nav-box">
					<a href="#training" title="Jump to Training section"
						class="box-link"></a>
					<img loading="lazy" width="36" height="36" src="
					<?php
					Lf_Utils::get_svg( 'annual-reports/2021/nav-03-code.svg', true );
					?>
					" alt="Code document icon">
					<span class="show-upto-1000">Training</span><span
						class="show-over-1000">Training &
						Certification</span>
				</div>
				<div class="nav-box">
					<a href="#projects" title="Jump to Projects section"
						class="box-link"></a>
					<img loading="lazy" width="36" height="36" src="
					<?php
					Lf_Utils::get_svg( 'annual-reports/2021/nav-04-megaphone.svg', true );
					?>
					" alt="Megaphone icon">
					<span class="show-upto-1000">Projects</span><span
						class="show-over-1000">Project Updates &
						Satisfaction</span>
				</div>
				<div class="nav-box">
					<a href="#community" title="Jump to Community section"
						class="box-link"></a>
					<img loading="lazy" width="36" height="36" src="
					<?php
					Lf_Utils::get_svg( 'annual-reports/2021/nav-05-expand.svg', true );
					?>
					" alt="Expanding community icon">
					<span class="show-upto-1000">Community</span><span
						class="show-over-1000">Community
						& Diversity </span>
				</div>
				<div class="nav-box">
					<a href="#ecosystem" title="Jump to Ecosystem section"
						class="box-link"></a>
					<img loading="lazy" width="36" height="36" src="
					<?php
					Lf_Utils::get_svg( 'annual-reports/2021/nav-06-eye.svg', true );
					?>
					" alt="Eye icon">
					<span class="show-upto-1000">Ecosystem</span><span
						class="show-over-1000">Mentoring & Ecosystem</span>
				</div>
			</div>
		</section>

		<section>

			<div aria-hidden="true" class="ar-spacer-80"></div>

			<div class="section-header-grid">

				<div class="shg-01">
					<h2 class="section-title uppercase"><span
							class="text-purple">Welcome</span><br />
						it's been a year to remember</h2>
					<div aria-hidden="true" class="ar-spacer-80"></div>
				</div>

				<div class="shg-02">
					<p
						class="fw-bold">When I look back at 2021, I'm amazed by what we have achieved together on our journey towards making cloud native ubiquitous.</p>

					<p
						class="mb-0">I want to thank you #TeamCloudNative, for your passion and commitment to this community. Despite all the challenges of <br class="show-over-1200">the past 12 months, you've made 2021 a year to remember.</p>
					<div aria-hidden="true" class="ar-spacer-80"></div>
				</div>

				<div class="shg-03">
					<img loading="lazy" width="525" height="625" src="
					<?php
					Lf_Utils::get_image( 'annual-reports/2021/blob-gm.jpg', true );
					?>
					" alt="Priyanka Sharma">
				</div>

				<div class="shg-04">
					<div class="quote-container">
						<p
							class="quote">The power of us is the <br/>power of our culture.</p>
						<div class="add-quote-marks">
							<p class="by-name fw-semi">Priyanka Sharma</p>
							<p class="by-position">General Manager, CNCF</p>
						</div>
					</div>
				</div>
			</div>

			<div aria-hidden="true" class="ar-spacer-80"></div>

			<div class="section-grid-01">
				<div>
					<p>We've seen record growth across all areas — from projects, events and the cloud native ecosystem, to membership and community. Most importantly, this year the definition of “us” has evolved to encompass a truly global, welcoming community of doers, working collaboratively to fundamentally change how technology is built and delivered.</p>

					<p>In the spirit of our evolution, the Annual Report is a little different this year. This web version shares all the great highlights of 2021, but if you're after more please <a href="<?php echo esc_url( $pdf_link ); ?>" title="Download the CNCF Annual Report 2021">download the PDF version</a> which sets out an in-depth analysis of the past 12 months.</p>

					<p>I hope you enjoy reading these fantastic milestones and reflecting back on the incredible progress we've achieved together this year.</p>
				</div>
				<div>
					<div aria-hidden="true" class="ar-spacer-20 show-upto-700">
					</div>

					<div class="icon-callout-1">
						<div class="icon">
							<img loading="lazy" width="89" height="52" src="
							<?php
							Lf_Utils::get_svg( 'annual-reports/2021/icon-members.svg', true );
							?>
							" alt="People icon">
						</div>
						<p><span class="fw-bold">740+ Members</span><br/>Across 6 continents</p>
					</div>
					<div class="icon-divider"></div>

					<div class="icon-callout-1">
						<div class="icon">
							<img loading="lazy" width="90" height="94" src="
							<?php
							Lf_Utils::get_svg( 'annual-reports/2021/icon-projects.svg', true );
							?>
							" alt="Multiple shapes icon">
						</div>
						<p><span class="fw-bold">120+ Projects</span><br/>Driving worldwide <br/>transformation</p>
					</div>
					<div class="icon-divider"></div>

					<div class="icon-callout-1">
						<div class="icon">
							<img loading="lazy" width="67" height="67" src="
							<?php
							Lf_Utils::get_svg( 'annual-reports/2021/icon-world.svg', true );
							?>
							" alt="Globe icon">
						</div>
						<p><span class="fw-bold">142,000+ Contributors</span><br/>Fundamentally changing computing</p>
					</div>
				</div>
			</div>

			<div aria-hidden="true" class="ar-spacer-160"></div>

		</section>

		<section class="background-image-wrapper alignfull is-section-hero"
			id="momentum">
			<div class="background-image-text-overlay">
				<div class="container wrap">
					<h2 class="header-title fw-extrabold">
						<span class="add-blob">2021</span><br />
						Momentum
					</h2>
				</div>
			</div>

			<div class="overlay-layer nude-green-gradient-75"></div>

			<figure class="background-image-shape">
				<img loading="lazy" src="
				<?php
				Lf_Utils::get_svg( 'annual-reports/2021/shapes.svg', true );
				?>
				" alt="Background shapes">
			</figure>

			<figure class="background-image-figure is-gray green-gradient">
				<?php
				Lf_Utils::display_responsive_images( 66456, 'large', '1200px', '', 'lazy' );
				?>
			</figure>
		</section>

		<section>

			<div aria-hidden="true" class="ar-spacer-160"></div>

			<h2 class="section-intro max-w-1000">CNCF is an open source software
				foundation
				dedicated to making cloud native computing ubiquitous</h2>

			<div class="section-grid-02">
				<div>
					<p
						class="fw-bold">Since we were founded in 2015, we've pioneered cloud native technologies — hosting and growing some of the world's <a href="https://docs.google.com/presentation/d/1UGewu4MMYZobunfKr5sOGXsspcLOH_5XeCLyOHKh9LU/edit?usp=sharing">most successful</a> open source projects including Kubernetes, Prometheus, Envoy, ContainerD, and many <a href="/projects/">others</a>.</p>
					<p>Today we are a powerhouse for visionary projects and people. If cloud native was fast becoming mainstream before 2020, then the global pandemic pushed adoption into the stratosphere. Now, CNCF hosts 120+ projects with over 142,000 contributors representing 189 countries, and there are no signs of slowing down. In fact, cloud native is actively being adopted by multiple industries, driven by our global community.</p>
					<p>This year, the <a href="https://github.com/cncf/cnf-wg">Cloud Native Network Function (CNF) Working Group</a> launched as the newest CNCF Telecom Initiative, with representatives from Telecom and cloud native communities. Thanks to our strategic partner <a href="http://vulk.coop">vulk.coop</a>, by the end 2021, the <a href="https://github.com/cncf/cnf-testsuite">CNF Test Suite</a> had more than 60 tests across many important categories. This tool provides feedback on the use of Kubernetes and cloud native best practices in networking applications and platforms, with contributions from 16 organizations.</p>

					<div aria-hidden="true" class="ar-spacer-40 show-over-700">
					</div>

					<div class="quote-container">
						<p
							class="quote">Remember when digital transformation used to be a buzzword?</p>
						<div class="add-quote-marks">
							<p class="by-name fw-semi">Priyanka Sharma</p>
							<p class="by-position">General Manager, CNCF</p>
						</div>
					</div>

					<div aria-hidden="true" class="ar-spacer-80 show-upto-1000">
					</div>

				</div>
				<div>
					<div class="sub-section-header-container">
						<h3 class="sub-section-header">Relentless <br
								class="show-upto-700">Momentum</h3>
					</div>

					<div class="chart-controls">

						<button id="data1"
							class="is-selected-data">Projects</button>
						<button id="data2">Contributors</button>
						<button id="data3">Members</button>
						<button id="data4">End Users</button>
					</div>

					<div class="chart-container">
						<canvas id="ar21chart"></canvas>
					</div>

				</div>
			</div>

			<div aria-hidden="true" class="ar-spacer-160"></div>

		</section>

		<section class="bg-gray-gradient alignfull">
			<div class="container wrap">

				<div aria-hidden="true" class="ar-spacer-160"></div>

				<h2 class="section-title uppercase">Membership</h2>

				<div aria-hidden="true" class="ar-spacer-80"></div>

				<div class="section-grid-03">

					<div class="shg-01">
						<p class="secondary-sub-section">
The CNCF ecosystem continues to grow across vendor and end user memberships, making CNCF one of the most successful open source foundations ever.</p>
					</div>
					<div class="shg-02">

						<div aria-hidden="true"
							class="ar-spacer-60 show-upto-700"></div>

						<img loading="lazy" width="525" height="423" src="
						<?php
						Lf_Utils::get_image( 'annual-reports/2021/blob-membership.png', true );
						?>
						" alt="Masked people walking at conference">
						<div aria-hidden="true"
							class="ar-spacer-80 show-upto-700"></div>
					</div>

					<div class="shg-03">
						<p
							class="fw-bold">In 2021, we welcomed over 200 new members to CNCF, equating to a 23% increase from 2020.</p>

						<p>Today, CNCF has over 740+ organizations participating, including the world's largest public and private cloud companies, along with the world's most innovative software companies and end user organizations. Investment from these leading organizations signifies a strong dedication to the advancement and sustainability of cloud native computing for years to come.</p>
					</div>
				</div>

				<div aria-hidden="true" class="ar-spacer-20 show-over-700">
				</div>

				<div class="sub-section-header-container">
					<h3 class="sub-section-header">CNCF <br
							class="show-upto-700">Membership <br
							class="show-upto-700">Growth</h3>
				</div>

				<div class="graph-explainer-container">
					<div class="graph"><img loading="lazy" width="762"
							height="436" src="
							<?php
							Lf_Utils::get_svg( 'annual-reports/2021/chart-membership-growth.svg', true );
							?>
							" alt="Chart showing CNCF Member growth"></div>
					<div class="graph-explainer">
						<span class="number-largest has-arrow-after">23%</span>

						<div class="divider"></div>

						<p>Organizations that sell cloud native technologies built on, or integrated with, CNCF projects are eligible to join as general members.</p>

						<a href="/join" class="ar-button is-pink">Become a CNCF
							Member</a>
					</div>

				</div>

				<div aria-hidden="true" class="ar-spacer-160"></div>
			</div>
		</section>


		<section class="bg-gray-gradient alignfull">
			<div class="container wrap">

				<div aria-hidden="true" class="ar-spacer-160"></div>

				<h2 class="section-title uppercase">Member Movers and Shakers
				</h2>

				<div aria-hidden="true" class="ar-spacer-80"></div>

				<div class="section-grid-04">

					<div>
						<div class="sub-section-header-container">
							<h3 class="sub-section-header">Upgraded to <br
									class="show-upto-700">Platinum</h3>
						</div>

						<div class="project-display-3">
							<div class="project-item">
								<a href="https://www.att.com/"><img width="140"
										height="100" loading="lazy" src="
										<?php
										Lf_Utils::get_svg( 'annual-reports/2021/logo-att.svg', true );
										?>
										" alt="AT&T"></a>
							</div>
							<div class="project-item">
								<a href="https://grafana.com"><img width="140"
										height="100" loading="lazy" src="
										<?php
										Lf_Utils::get_svg( 'annual-reports/2021/logo-grafana.svg', true );
										?>
										" alt="Grafana Labs"></a>
							</div>
							<div class="project-item">
								<a href="https://newrelic.com/"><img
										height="100" loading="lazy" src="
										<?php
										Lf_Utils::get_svg( 'annual-reports/2021/logo-new-relic.svg', true );
										?>
										" alt="New Relic"></a>
							</div>
						</div>

						<div aria-hidden="true" class="ar-spacer-80"></div>

						<div class="sub-section-header-container">
							<h3 class="sub-section-header">New Gold <br
									class="show-upto-700">Members</h3>
						</div>

						<div class="project-display-3">
							<div class="project-item">
								<a href="https://www.americanexpress.com/"><img
										height="100" loading="lazy" src="
										<?php
										Lf_Utils::get_svg( 'annual-reports/2021/logo-amex.svg', true );
										?>
										" alt="American Express"></a>
							</div>
							<div class="project-item">
								<a href="https://corporate.charter.com/"><img
										width="140" height="100" loading="lazy"
										src="
										<?php
										Lf_Utils::get_svg( 'annual-reports/2021/logo-charter.svg', true );
										?>
										" alt="Charter Communications"></a>
							</div>
							<div class="project-item">
								<a href="https://www.h3c.com/en"><img
										width="140" height="100" loading="lazy"
										src="
										<?php
										Lf_Utils::get_svg( 'annual-reports/2021/logo-hbc.svg', true );
										?>
										" alt="H3C"></a>
							</div>
						</div>

					</div>
					<div>
						<div aria-hidden="true" class="ar-spacer-80"></div>

						<div aria-hidden="true"
							class="ar-spacer-60 show-upto-700"></div>

						<div class="icon-callout-1 justify-center">
							<div class="icon">
								<img loading="lazy" width="89" height="52"
									src="<?php Lf_Utils::get_svg( 'annual-reports/2021/icon-members.svg', true ); ?>"
									alt="People icon">
							</div>
							<p><span class="fw-bold">200+ new members</span><br/>80 new members<br/>
from China</p>
						</div>
						<div class="icon-divider"></div>
						<div class="icon-callout-1 justify-center">
							<div class="icon">
								<img loading="lazy"
									src="<?php Lf_Utils::get_svg( 'annual-reports/2021/icon-building.svg', true ); ?>"
									alt="Building icon">
							</div>
							<p><span class="fw-bold">740+ member <br/> organizations</span><br/>23% growth from 2020</p>
						</div>
					</div>

				</div>

				<div aria-hidden="true" class="ar-spacer-160"></div>

			</div>
		</section>

		<section class="background-image-wrapper alignfull is-section-image">

			<div class="background-image-text-overlay">
				<div class="container wrap">

					<div class="quote-container on-picture max-w-600">
						<p
							class="quote">End users are not passive, they're becoming leaders in open source projects.</p>
						<div class="add-quote-marks is-green">
							<p class="by-name fw-semi">Cheryl Hung</p>
							<p class="by-position">Engineering Lead, Apple</p>
						</div>
					</div>
				</div>
			</div>

			<figure class="background-image-figure black-gradient">
				<?php
				Lf_Utils::display_responsive_images( 66457, 'large', '1200px', '', 'lazy' );
				?>
			</figure>
		</section>

		<section class="alignfull">
			<div class="container wrap">

				<div aria-hidden="true" class="ar-spacer-160"></div>

				<h2 class="section-title uppercase">End User Community</h2>

				<div aria-hidden="true" class="ar-spacer-80"></div>

				<div class="section-grid-04">

					<div>
						<p class="secondary-sub-section">
At our heart, CNCF is driven by a welcoming foundation of doers at the leading edge of cloud native. We're committed to creating end user-driven open source and this year, more than ever, we've seen End Users actively shape the ecosystem — driving huge-scale adoption and growth of CNCF projects.</p>

						<div aria-hidden="true"
							class="ar-spacer-60 show-upto-700"></div>

					</div>

					<div>
						<div class="icon-callout-2">
							<div class="icon">
								<img loading="lazy"
									src="<?php Lf_Utils::get_svg( 'annual-reports/2021/icon-thumbup.svg', true ); ?>"
									alt="Thumbs up icon">
							</div>
							<p><span class="number-large text-purple">100%</span><br/>would recommend CNCF <br/>to other companies<br/>
<span class="text-smaller">(2021 End User survey)</span></p>
						</div>
						<div class="icon-divider"></div>
						<div class="icon-callout-2">
							<div class="icon">
								<img loading="lazy" width="89" height="52"
									src="<?php Lf_Utils::get_svg( 'annual-reports/2021/icon-members.svg', true ); ?>"
									alt="People icon">
							</div>
							<p><span class="number-large text-purple">164+</span><br/>End Users</span></p>
						</div>
					</div>
				</div>

				<div aria-hidden="true" class="ar-spacer-60 show-upto-700">
				</div>

				<div aria-hidden="true" class="ar-spacer-80"></div>

				<div class="sub-section-header-container">
					<h3 class="sub-section-header">CNCF <br
							class="show-upto-700">End User
						<br class="show-upto-700">
						Growth
					</h3>
				</div>

				<div class="graph-explainer-container">
					<div class="graph"><img loading="lazy" width="772"
							height="399"
							src="<?php Lf_Utils::get_svg( 'annual-reports/2021/chart-end-user-growth.svg', true ); ?>"
							alt="Chart showing CNCF end user growth"></div>
					<div class="graph-explainer">
						<span class="number-largest has-arrow-after">17%</span>

						<div class="divider"></div>

						<p>End Users leverage cloud native technologies internally, but don't sell cloud native products or services. Come shape the cloud native ecosystem with us!</p>

						<a href="/enduser" class="ar-button is-pink">Join
							CNCF</a>
					</div>

				</div>

				<div aria-hidden="true" class="ar-spacer-160"></div>

			</div>
		</section>

		<section class="background-image-wrapper alignfull is-spotify-section">

			<div class="background-image-text-overlay">
				<div class="container wrap text-white">

					<div class="sub-section-header-container">
						<h3 class="sub-section-header text-white">Award <br
								class="show-upto-700">Announcement</h3>
					</div>

					<div aria-hidden="true" class="ar-spacer-40"></div>

					<div class="section-grid-04">

						<div>
							<a href="https://open.spotify.com">
								<img loading="lazy" class="image-spotify"
									src="<?php Lf_Utils::get_svg( 'annual-reports/2021/logo-spotify.svg', true ); ?>"
									alt="Spotify logo">
							</a>

							<div aria-hidden="true" class="ar-spacer-40"></div>

							<p
								class="text-small lh-150">We were thrilled to grant <strong>Spotify</strong> our <strong>Top End User Award</strong> this year, in recognition of its notable contributions to the cloud native ecosystem.</p>

						</div>

						<div aria-hidden="true"
							class="ar-spacer-40 show-upto-700"></div>

						<div>

							<div class="icon-callout-2 text-white">
								<div class="icon">
									<img loading="lazy"
										src="<?php Lf_Utils::get_svg( 'annual-reports/2021/icon-w-contributions.svg', true ); ?>"
										alt="Clipboard icon">
								</div>
								<p><span class="number-large text-white">26,648</span><br/>contributions <br/>to 13 different projects</p>
							</div>
							<div class="icon-divider"></div>

							<p
								class="secondary-sub-section mb-0 text-white">Contributed project</p>

							<div aria-hidden="true" class="ar-spacer-30"></div>

							<a href="/projects/backstage/">
								<img loading="lazy"
									src="<?php Lf_Utils::get_svg( 'annual-reports/2021/logo-backstage.svg', true ); ?>"
									alt="Backstage logo">
							</a>

							<div aria-hidden="true"
								class="ar-spacer-20 show-upto-700"></div>

						</div>
					</div>


				</div>
			</div>

			<figure class="background-image-figure">
				<?php
				Lf_Utils::display_responsive_images( 66458, 'large', '1200px', '', 'lazy' );
				?>
			</figure>
		</section>

		<section>

			<div aria-hidden="true" class="ar-spacer-100"></div>

			<div class="quote-container">
				<p
					class="quote">We love being a part of this community, where you can not only learn from other end users in your position but also have a voice in the direction of the community and its projects. We have come a long way from our early days of learning about cloud native to making Spotify a technology innovator and good open source citizen, and can't wait to see what milestones we reach next!</p>
				<div class="add-quote-marks">
					<p class="by-name fw-semi">Dave Zolotusky</p>
					<p
						class="by-position">Principal Engineer, Spotify & CNCF TOC member</p>
				</div>
			</div>


			<div aria-hidden="true" class="ar-spacer-160"></div>
			<div class="hr-divider"></div>
			<div aria-hidden="true" class="ar-spacer-100"></div>
			<div class="more-wrapper">
				<p
					class="secondary-sub-section lh-100 mb-0">Enjoyed our 2021 member highlights? Get more details in the full report...</p>
				<div aria-hidden="true" class="ar-spacer-40 show-upto-700">
				</div>
				<a href="<?php echo esc_url( $pdf_link ); ?>"
					class="ar-button is-pink is-larger">Download Full Report</a>
			</div>

			<div aria-hidden="true" class="ar-spacer-160"></div>

		</section>

		<section class="background-image-wrapper alignfull is-section-hero"
			id="events">
			<div class="background-image-text-overlay">
				<div class="container wrap">
					<h2 class="header-title fw-extrabold">
						<span class="add-blob">Virtual &amp;</span><br />
						Hybrid Events
					</h2>
				</div>
			</div>

			<div class="overlay-layer nude-green-gradient-75"></div>

			<figure class="background-image-shape">
				<img loading="lazy" src="
				<?php
				Lf_Utils::get_svg( 'annual-reports/2021/shapes.svg', true );
				?>
				" alt="Background shapes">
			</figure>

			<figure class="background-image-figure is-gray green-gradient">
				<?php
				Lf_Utils::display_responsive_images( 66459, 'large', '1200px', '', 'lazy' );
				?>
			</figure>
		</section>

		<section>

			<div aria-hidden="true" class="ar-spacer-160"></div>

			<h2 class="section-intro max-w-800">Despite all our hopes, the
				COVID-19
				pandemic continued to shape 2021</h2>

			<div class="section-grid-16">

				<div class="shg-01">
					<p
						class="fw-bold">To ensure the safety of our growing cloud native community, CNCF doubled down on digital last year, launching a suite of programs to bring #TeamCloudNative together and providing opportunities for collaboration, learning, and networking from every corner of the globe. </p>

				</div>

				<div class="shg-02">
					<img loading="lazy" width="525" height="627" src="
					<?php
					Lf_Utils::get_image( 'annual-reports/2021/blob-events.jpg', true );
					?>
					" alt="Masked man at a conference">
				</div>

				<div class="shg-03">
					<div class="quote-container">
						<p
							class="quote">KubeCon + CloudNativeCon has always been a celebration of that community spirit, a place where contributors and users from across the world get to meet <br class="show-over-1200">and share ideas face-to-face.</p>
						<div class="add-quote-marks">
							<p class="by-name fw-semi">Betsy Amy-Vogt</p>
							<p class="by-position">SiliconANGLE</p>
						</div>
					</div>
				</div>

			</div>

			<div aria-hidden="true" class="ar-spacer-160"></div>

			<div class="section-grid-05">

				<div class="shg-01">
					<h2 class="section-title uppercase text-purple">Kubernetes
						Community
						Days</h2>

					<div aria-hidden="true" class="ar-spacer-80"></div>

				</div>

				<div class="shg-02">

					<p class="fw-bold">In response to the cloud native community's evolving needs and geographies, CNCF relaunched the <a href="https://kubernetescommunitydays.org/">Kubernetes Community Days (KCD)</a> program in 2021 — community-organized events that gather adopters and technologists to learn, collaborate, and network. The goal of the events is to further the adoption and improvement of Kubernetes and cloud native technologies around the world.
</p>

				</div>

				<div class="shg-03">
					<img loading="lazy" width="419" height="393419" src="
					<?php
					Lf_Utils::get_image( 'annual-reports/2021/clipart-kcd.png', true );
					?>
					" alt="Drawing of man and woman talking">
				</div>
			</div>

			<div aria-hidden="true" class="ar-spacer-60"></div>

			<div class="sub-section-header-container">
				<h3 class="sub-section-header">Program <br
						class="show-upto-700">relaunched to <br
						class="show-upto-700">massive demand</h3>
			</div>

			<div aria-hidden="true" class="ar-spacer-30"></div>

			<div class="section-grid-06">

				<div>
					<div class="icon-callout-1">
						<div class="icon">
							<img loading="lazy"
								src="<?php Lf_Utils::get_svg( 'annual-reports/2021/icon-frame.svg', true ); ?>"
								alt="Person in frame icon">
						</div>
						<p><span class="fw-bold">12 KCDs</span><br/>In-person, virtual and <br class="show-upto-700">hybrid</p>
					</div>
					<div class="icon-divider"></div>

					<div class="icon-callout-1">
						<div class="icon">
							<img loading="lazy"
								src="<?php Lf_Utils::get_svg( 'annual-reports/2021/icon-mic.svg', true ); ?>"
								alt="Microphone icon">
						</div>
						<div>
							<p><span class="lh-125 fw-bold mb-20">Presentations</span><br/>in multiple languages</p>

							<p
								class="text-smaller lh-150">(English, Chinese, Indonesian, <br />Italian, Korean, and Spanish)</p>
						</div>
					</div>
				</div>

				<div class="icon-divider show-upto-700"></div>

				<div>
					<div class="icon-callout-1">
						<div class="icon">
							<img loading="lazy" width="89" height="52"
								src="<?php Lf_Utils::get_svg( 'annual-reports/2021/icon-members.svg', true ); ?>"
								alt="People icon">
						</div>
						<p><span class="fw-bold">7,500+ attendees</span><br/>Adopters & technologists</p>
					</div>

					<div class="icon-divider"></div>

					<div class="icon-callout-1">
						<div class="icon">
							<img loading="lazy" width="67" height="67"
								src="<?php Lf_Utils::get_svg( 'annual-reports/2021/icon-world.svg', true ); ?>"
								alt="Globe icon">
						</div>
						<p><span class="fw-bold">12 countries</span><br/>Across the <br/>globe</p>
					</div>
				</div>

				<div aria-hidden="true" class="ar-spacer-160"></div>

		</section>

		<section class="bg-gray-gradient alignfull">
			<div class="container wrap">

				<div aria-hidden="true" class="ar-spacer-160"></div>

				<h2 class="section-title uppercase max-w-900">Kubecon +
					CloudNativeCon
					Europe 2021 (Virtual)</h2>

				<div aria-hidden="true" class="ar-spacer-80"></div>

				<a
					href="https://events.linuxfoundation.org/archive/2021/kubecon-cloudnativecon-europe/">
					<img loading="lazy" width="1150" height="296"
						src="<?php Lf_Utils::get_image( 'annual-reports/2021/banner-kubecon-eu-21.png', true ); ?>"
						alt="Kubecon EU 2021 banner">
				</a>

				<div aria-hidden="true" class="ar-spacer-60"></div>

				<p
					class="secondary-sub-section max-w-900">May saw <a href="https://events.linuxfoundation.org/archive/2021/kubecon-cloudnativecon-europe/">KubeCon + CloudNativeCon EU Virtual</a> once again set record-breaking registration and attendance, with 26,648 registrants (a 42.5% increase on 2020).</p>

				<div aria-hidden="true" class="ar-spacer-60 show-over-700">
				</div>

				<div class="section-grid-04">

					<div>
						<a href="https://youtu.be/8hV-ml4WuVM"
							 class="image-link"><img
								loading="lazy" width="525" height="324"
								src="<?php Lf_Utils::get_image( 'annual-reports/2021/kubecon-macbook.png', true ); ?>"
								alt="Laptop playing a video of keynote talk"></a>

						<div aria-hidden="true"
							class="ar-spacer-60 show-upto-700"></div>
					</div>

					<div>
						<div class="sub-section-header-container">
							<h3 class="sub-section-header">Featured <br
									class="show-upto-700">keynote</h3>
						</div>

						<p
							class="mb-20 lh-150"><a href="https://youtu.be/8hV-ml4WuVM"   class="text-larger  text-purple fw-semi lh-125">How Cloud Native Tech Helped Peloton Ride to Exponential Growth</a></p>

						<p class="fw-semi">Jim Haughwout, VP, Peloton </p>

						<a href="/wp-content/uploads/2021/06/KubeCon_EU_21_Virtual_TransparencyReport_FINAL.pdf"
							class="ar-button is-pink w-full">Download Event
							<br />transparency report</a>

					</div>
				</div>

				<div aria-hidden="true" class="ar-spacer-100"></div>

				<div class="sub-section-header-container">
					<h3 class="sub-section-header">The event <br
							class="show-upto-700">in numbers</h3>
				</div>

				<div aria-hidden="true" class="ar-spacer-40"></div>

				<div class="section-grid-06">
					<div class="icon-callout-3">
						<div class="icon">
							<img loading="lazy" width="89" height="52"
								src="<?php Lf_Utils::get_svg( 'annual-reports/2021/icon-members.svg', true ); ?>"
								alt="People icon">
						</div>
						<p><span class="number-large text-purple">26,648</span><br/><span class="text-green uppercase fw-bold">Total Registrations</span></p>
					</div>

					<div aria-hidden="true" class="ar-spacer-120 show-upto-700">
					</div>

					<div class="icon-callout-3">
						<div class="icon">
							<img loading="lazy"
								src="<?php Lf_Utils::get_svg( 'annual-reports/2021/icon-mic.svg', true ); ?>"
								alt="Microphone icon">
						</div>

						<div>
							<p><span class="number-large text-purple">624</span><span class="text-green uppercase fw-bold"> Submissions</span></p>

							<div aria-hidden="true" class="ar-spacer-30"></div>

							<p><span class="number-large text-purple">145</span><span class="text-green uppercase fw-bold"> Speakers</span></p>
						</div>

					</div>
				</div>

				<div aria-hidden="true" class="ar-spacer-80"></div>

				<div class="border-outline">

					<p
						class="secondary-sub-section">Breakdown of attendees by location</p>

					<div class="section-grid-06">

						<div class="icon-callout-3">
							<div class="icon">
								<img loading="lazy" width="67" height="67"
									src="<?php Lf_Utils::get_svg( 'annual-reports/2021/icon-world.svg', true ); ?>"
									alt="Globe icon">
							</div>
							<p><span class="number-large text-purple">168</span><br/><span class="text-green uppercase fw-bold">Countries</span>
<span class="text-medium"><br/>Attendees from six continents
</span></p>
						</div>

						<div aria-hidden="true"
							class="ar-spacer-100 show-upto-700"></div>

						<img loading="lazy" width="445" height="247"
							src="<?php Lf_Utils::get_svg( 'annual-reports/2021/chart-kceu21-attendees.svg', true ); ?>"
							alt="Chart showing breakdown of Kubecon 2021 EU attendees by country">

					</div>
				</div>

				<div aria-hidden="true" class="ar-spacer-60"></div>

				<div class="border-outline">

					<p
						class="secondary-sub-section">Breakdown of particpating companies</p>

					<div class="section-grid-06">
						<div class="icon-callout-3">
							<div class="icon">
								<img loading="lazy"
									src="<?php Lf_Utils::get_svg( 'annual-reports/2021/icon-building.svg', true ); ?>"
									alt="Building icon">
							</div>
							<p><span class="number-large text-purple">9,092</span><br/><span class="text-green uppercase fw-bold">Companies <br/>participated</span></p>
						</div>

						<div aria-hidden="true"
							class="ar-spacer-100 show-upto-700"></div>

						<img loading="lazy" width="445" height="261"
							src="<?php Lf_Utils::get_svg( 'annual-reports/2021/chart-kceu21-companies.svg', true ); ?>"
							alt="Chart showing breakdown of Kubecon 2021 EU attendees by company type">
					</div>
				</div>

				<div aria-hidden="true" class="ar-spacer-160"></div>

			</div>
		</section>

		<section class="bg-gray-gradient alignfull">
			<div class="container wrap">

				<div aria-hidden="true" class="ar-spacer-160"></div>

				<h2 class="section-title uppercase max-w-900">Kubecon +
					CloudNativeCon
					North America 2021</h2>

				<div aria-hidden="true" class="ar-spacer-80"></div>

				<a
					href="https://events.linuxfoundation.org/archive/2021/kubecon-cloudnativecon-north-america/">
					<img loading="lazy" width="1150" height="282"
						src="<?php Lf_Utils::get_image( 'annual-reports/2021/banner-kubecon-na-21.png', true ); ?>"
						alt="Kubecon NA 2021 banner">
				</a>

				<div aria-hidden="true" class="ar-spacer-60"></div>

				<p
					class="fw-bold max-w-800">As a truly global community, gathering for our first hybrid <a href="https://events.linuxfoundation.org/archive/2021/kubecon-cloudnativecon-north-america/">KubeCon + CloudNativeCon in Los Angeles</a> in October was a special moment. We welcomed 3,531 attendees in-person, and 19,633 through our virtual event platform — setting a new standard in hybrid events.</p>

				<p
					class="max-w-800">Research from David Sally tells us that cooperation and collaboration increases 45% when meeting in person and having face-to-face interactions, so we're committed to driving more future opportunities for #TeamCloudNative to collaborate and learn together in-person.</p>

				<div aria-hidden="true"
					class="ar-spacer-60 show-over-700 show-upto-1000"></div>

				<div aria-hidden="true" class="ar-spacer-30 show-over-1000">
				</div>

				<div class="section-grid-06">

					<div>
						<div class="sub-section-header-container">
							<h3 class="sub-section-header">Featured <br
									class="show-upto-700">keynote</h3>
						</div>

						<p
							class="mb-20 lh-125"><a   href="https://youtu.be/VzuyyESy9oA" class="text-larger text-purple fw-semi lh-125">Building support for your <br class="show-over-700">Cloud Native journey</a></p>

						<p class="fw-semi">Robert Duffy, Expedia</p>

					</div>

					<div>

						<a href="https://youtu.be/VzuyyESy9oA"
							 class="image-link"><img
								loading="lazy" width="525" height="432"
								src="<?php Lf_Utils::get_image( 'annual-reports/2021/blob-speaker.png', true ); ?>"
								alt="Robert Duffy speaking at conference"></a>

						<div aria-hidden="true" class="ar-spacer-60"></div>

					</div>

				</div>

				<div class="sub-section-header-container">
					<h3 class="sub-section-header">The event <br
							class="show-upto-700">in numbers</h3>
				</div>

				<div class="section-grid-06">

					<div class="icon-callout-3">
						<div class="icon">
							<img loading="lazy" width="89" height="52"
								src="<?php Lf_Utils::get_svg( 'annual-reports/2021/icon-members.svg', true ); ?>"
								alt="People icon">
						</div>
						<p><span class="number-large text-purple">23,164</span><br/><span class="text-green uppercase fw-bold">Total Registrations</span></p>
					</div>

					<div aria-hidden="true" class="ar-spacer-100 show-upto-700">
					</div>

					<div class="icon-callout-3">
						<div class="icon">
							<img loading="lazy" width="67" height="67"
								src="<?php Lf_Utils::get_svg( 'annual-reports/2021/icon-world.svg', true ); ?>"
								alt="Globe icon">
						</div>
						<p><span class="number-large text-purple">154</span><br/><span class="text-green uppercase fw-bold">Countries</span>
<span class="text-medium"><br/>Attendees from six continents
</span></p>
					</div>

				</div>

				<div aria-hidden="true" class="ar-spacer-80"></div>

				<div class="section-grid-07">

					<div class="border-outline">

						<p
							class="secondary-sub-section">Breakdown of in-person attendees by location</p>

						<div class="icon-callout-3">
							<div class="icon">
								<img loading="lazy"
									src="<?php Lf_Utils::get_svg( 'annual-reports/2021/icon-lanyard.svg', true ); ?>"
									alt="Lanyard icon">
							</div>
							<p><span class="number-large text-purple">3,531</span><br/><span class="text-green uppercase fw-bold">In-person</span></p>
						</div>

						<div aria-hidden="true" class="ar-spacer-60"></div>

						<p
							class="secondary-sub-section">Most represented countries in attendance</p>

						<img loading="lazy" width="405" height="181"
							src="<?php Lf_Utils::get_svg( 'annual-reports/2021/chart-kcna21-inperson.svg', true ); ?>"
							alt="Map showing countries with most in-person representation at Kubecon NA 2021">


					</div>

					<div aria-hidden="true" class="ar-spacer-60 show-upto-1000">
					</div>

					<div class="border-outline">

						<p
							class="secondary-sub-section">Breakdown of virtual attendees by location</p>

						<div class="icon-callout-3">
							<div class="icon">
								<img loading="lazy"
									src="<?php Lf_Utils::get_svg( 'annual-reports/2021/icon-laptop.svg', true ); ?>"
									alt="Laptop icon">
							</div>
							<p><span class="number-large text-purple">19,633</span><br/><span class="text-green uppercase fw-bold">Virtual</span></p>
						</div>

						<div aria-hidden="true" class="ar-spacer-60"></div>

						<p
							class="secondary-sub-section">Most represented countries in attendance</p>

						<img loading="lazy" width="405" height="172"
							src="<?php Lf_Utils::get_svg( 'annual-reports/2021/chart-kcna21-virtual.svg', true ); ?>"
							alt="Map showing countries with most virtual representation at Kubecon NA 2021">

					</div>
				</div>

				<div aria-hidden="true" class="ar-spacer-100"></div>

				<p
					class="secondary-sub-section">Breakdown of parcticpating companies</p>

				<div class="section-grid-06">

					<div class="icon-callout-3">
						<div class="icon">
							<img loading="lazy"
								src="<?php Lf_Utils::get_svg( 'annual-reports/2021/icon-building.svg', true ); ?>"
								alt="Building icon">
						</div>
						<p><span class="number-large text-purple">7,290</span><br/><span class="text-green uppercase fw-bold">Companies <br/>participated</span></p>
					</div>

					<div aria-hidden="true" class="ar-spacer-100 show-upto-700">
					</div>

					<img loading="lazy" width="482" height="342"
						src="<?php Lf_Utils::get_svg( 'annual-reports/2021/chart-kcna21-companies.svg', true ); ?>"
						alt="Breakdown of Kubecon NA 2021 participants by company type">

				</div>

				<div aria-hidden="true" class="ar-spacer-160"></div>

			</div>
		</section>

		<section class="background-image-wrapper alignfull is-speakers-section">

			<div class="background-image-text-overlay">
				<div class="container wrap">

					<div class="section-grid-08">

						<div class="icon-callout-3 align-start">
							<div class="icon">
								<img loading="lazy"
									src="<?php Lf_Utils::get_svg( 'annual-reports/2021/icon-w-mic.svg', true ); ?>"
									alt="Microphone icon">
							</div>
							<p
								class="text-large"><span class="text-white uppercase fw-bold">Speakers </span><br/><span class="text-green uppercase fw-bold">North America 2021</span></p>
						</div>

						<div aria-hidden="true"
							class="ar-spacer-80 show-upto-1000"></div>

						<div class="speakers-grid-wrapper">

							<div class="speakers-grid">

								<div>
									<p><span class="number-largest text-white lh-100">976</span><br/><span class="text-green uppercase text-larger fw-bold">Submissions</span></p>
								</div>

								<div>
									<p><span class="number-largest text-white lh-100">227</span><br/><span class="text-green text-larger uppercase fw-bold">Speakers</span></p>
								</div>

								<a href="/wp-content/uploads/2021/11/KubeCon_NA_21_Report.pdf"
									class="ar-button is-pink w-full">Download
									Event<br />
									Transparency Report</a>

							</div>
						</div>
					</div>

				</div>
			</div>

			<figure class="background-image-figure">
				<?php
				Lf_Utils::display_responsive_images( 66482, 'large', '1200px', '', 'lazy' );
				?>
			</figure>
		</section>

		<section>

			<div aria-hidden="true" class="ar-spacer-160"></div>

			<div class="section-grid-05">

				<div class="shg-01">
					<h2 class="section-title uppercase text-purple">COVID
						response</h2>

					<div aria-hidden="true" class="ar-spacer-80"></div>

				</div>

				<div class="shg-02">

					<p
						class="fw-bold">Our commitment to enabling collaboration also means we're deeply committed to keeping #TeamCloudNative safe.</p>

					<p>CNCF has a long-standing relationship with <a href="https://www.futurehealth.live/bio">Dr. Joel Selanikio</a>, a physician, former CDC epidemiologist and outbreak investigator, and consultant epidemiologist to the DC Department of Health and to FEMA for the COVID-19 response over 2020-21.</p>

					<p>Thanks to Dr. Selanikio's continuous council, we have been able to take educated and well-thought out steps to ensure the safety of our community members as we navigate COVID-19. </p>

				</div>

				<div class="shg-03">
					<img loading="lazy" class="image-covid" width="348"
						height="396"
						src="<?php Lf_Utils::get_image( 'annual-reports/2021/chart-covid-response.png', true ); ?>"
						alt="COVID practices icons">

				</div>
			</div>

			<div aria-hidden="true" class="ar-spacer-160"></div>

		</section>

		<section class="bg-gray-gradient alignfull">
			<div class="container wrap">

				<div aria-hidden="true" class="ar-spacer-160"></div>

				<h2 class="section-title uppercase">Kubecon +
					CloudNativeCon<br />China 2021</h2>

				<div aria-hidden="true" class="ar-spacer-80"></div>

				<p
					class="fw-bold max-w-800">We don't yet have all our statistics available from this virtual December 9+10 event, but we'll share them as soon as they're ready! </p>

				<div aria-hidden="true" class="ar-spacer-30"></div>

				<div class="section-grid-09">

					<a
						href="https://www.lfasiallc.com/kubecon-cloudnativecon-open-source-summit-china/">
						<img loading="lazy" width="616" height="369"
							src="<?php Lf_Utils::get_image( 'annual-reports/2021/banner-kubecon-cn-21.png', true ); ?>"
							alt="Kubecon China 2021 banner">
					</a>

					<div>
						<div aria-hidden="true" class="ar-spacer-30"></div>

						<div aria-hidden="true"
							class="ar-spacer-80 show-upto-700"></div>

						<div class="icon-callout-3">
							<div class="icon">
								<img loading="lazy" width="89" height="52"
									src="<?php Lf_Utils::get_svg( 'annual-reports/2021/icon-members.svg', true ); ?>"
									alt="People icon">
							</div>
							<p><span class="number-large text-purple">7,160</span><br/><span class="text-green uppercase fw-bold">Registered Attendees</span></p>
						</div>

						<div class="icon-divider"></div>

						<div class="icon-callout-3">
							<div class="icon">
								<img loading="lazy"
									src="<?php Lf_Utils::get_svg( 'annual-reports/2021/icon-mic.svg', true ); ?>"
									alt="Microphone icon">
							</div>
							<p><span class="number-large text-purple">161</span><br/><span class="text-green uppercase fw-bold">Speakers</span></p>
						</div>
					</div>

					<div aria-hidden="true" class="ar-spacer-160"></div>

				</div>
		</section>

		<section class="bg-gray-gradient alignfull">
			<div class="container wrap">

				<div aria-hidden="true" class="ar-spacer-160"></div>

				<p
					class="secondary-sub-section max-w-700">See you at our next KubeCon + CloudNativeCon in Valencia!</p>

				<a
					href="https://events.linuxfoundation.org/kubecon-cloudnativecon-europe/">
					<img loading="lazy" width="1150" height="241"
						src="<?php Lf_Utils::get_image( 'annual-reports/2021/banner-kubecon-eu-22.png', true ); ?>"
						alt="KubeCon + CloudNativeCon EU 2022 banner">
				</a>

				<div aria-hidden="true" class="ar-spacer-160"></div>
				<div class="hr-divider"></div>
				<div aria-hidden="true" class="ar-spacer-100"></div>
				<div class="more-wrapper">
					<p
						class="secondary-sub-section lh-100 mb-0">Enjoyed our 2021 event highlights? Get more details in the full report...</p>
					<div aria-hidden="true" class="ar-spacer-40 show-upto-700">
					</div>
					<a href="<?php echo esc_url( $pdf_link ); ?>"
						class="ar-button is-pink is-larger">Download Full
						Report</a>
				</div>

				<div aria-hidden="true" class="ar-spacer-160"></div>

			</div>
		</section>

		<section class="background-image-wrapper alignfull is-section-hero"
			id="training">
			<div class="background-image-text-overlay">
				<div class="container wrap">
					<h2 class="header-title fw-extrabold">
						<span class="add-blob">Training &amp;</span><br />
						Certification
					</h2>
				</div>
			</div>

			<div class="overlay-layer nude-green-gradient-75"></div>

			<figure class="background-image-shape">
				<img loading="lazy" src="
				<?php
				Lf_Utils::get_svg( 'annual-reports/2021/shapes.svg', true );
				?>
				" alt="Background shapes">
			</figure>

			<figure class="background-image-figure is-gray green-gradient">
				<?php
				Lf_Utils::display_responsive_images( 66461, 'large', '1200px', '', 'lazy' );
				?>
			</figure>
		</section>

		<section>

			<div aria-hidden="true" class="ar-spacer-160"></div>

			<h2 class="section-intro max-w-1000">CNCF doubled down on our
				commitment to #TeamCloudNative in 2021 by expanding our globally
				recognized certifications, boosting employment opportunities,
				and helping more folx to upskill their practical application of
				cloud native technologies. </h2>

			<div class="section-grid-10">

				<div>
					<p
						class="fw-bold">This year we launched the <a href="/certification/kcna/">Kubernetes and Cloud Native Associate (KCNA)</a> — a pre-professional certification designed for candidates interested in working with cloud native technologies. The KCNA underscores conceptual knowledge of the entire cloud native ecosystem, particularly focusing on Kubernetes, and is meant for more than just developers.</p>

					<p>Alongside, we launched a new practical training course — <a href="https://training.linuxfoundation.org/training/inclusive-strategies-for-open-source-lfc103/?utm_source=lftraining&utm_medium=pr&utm_campaign=lfc103">Inclusive Strategies for Open Source (LFC103)</a> — designed to ​​provide specific strategies for creating inclusive open source communities and codebases, and advice on executing those in communities.</p>

					<div aria-hidden="true" class="ar-spacer-80 show-upto-1000">
					</div>

					<div aria-hidden="true"
						class="ar-spacer-160 show-over-1000"></div>

				</div>

				<img loading="lazy" width="350" height="500"
					class="image-training"
					src="<?php Lf_Utils::get_image( 'annual-reports/2021/clipart-training.png', true ); ?>"
					alt="Drawing of woman reading a book">

			</div>

		</section>

		<section class="bg-gray-gradient alignfull">
			<div class="container wrap">

				<div aria-hidden="true" class="ar-spacer-160"></div>

				<h2 class="section-title uppercase text-purple">2021
					<br />Training Courses
				</h2>

				<div aria-hidden="true" class="ar-spacer-80"></div>


				<div class="section-grid-11">
					<p
						class="secondary-sub-section mb-0">CNCF's training and certification program continued to grow. These training courses and exams received considerable interest:</p>

					<div aria-hidden="true" class="ar-spacer-40 show-upto-700">
					</div>

					<img loading="lazy"
						src="<?php Lf_Utils::get_svg( 'annual-reports/2021/certifications.svg', true ); ?>"
						alt="Certification logos">

				</div>

				<div aria-hidden="true" class="ar-spacer-120"></div>

				<div class="training-stats">

					<div>
						<span
							class="number-largest has-arrow-after text-purple lh-100">39%</span>
						<span
							class="text-green uppercase fw-bold block">Increase</span>
						<div class="icon-divider smaller"></div>
						<p><a href="/certification/training/">Kubernetes Massively Open Online Course (MOOC)</a> hit 229,000 enrollments.</p>
					</div>

					<div>
						<span
							class="number-largest has-arrow-after text-purple lh-100">86%</span>
						<span
							class="text-green uppercase fw-bold block">Increase</span>
						<div class="icon-divider smaller"></div>
						<p><a href="/certification/ckad/">Certified Kubernetes Application Developer (CKAD)</a> hit 34,000 exam registrations.</p>
					</div>

					<div>
						<span
							class="number-largest has-arrow-after text-purple lh-100">89%</span>
						<span
							class="text-green uppercase fw-bold block">Increase</span>
						<div class="icon-divider smaller"></div>
						<p><a href="/certification/cka/">Certified Kubernetes Administrator (CKA)</a> exam hit 70,000 enrollments.</p>
					</div>

					<div>
						<span
							class="number-large has-arrow-after text-purple lh-140">8,450</span>
						<span
							class="text-green uppercase fw-bold block">Registrations</span>
						<div class="icon-divider smaller"></div>
						<p><a href="/certification/cks/">Certified Kubernetes Security Specialist (CKS)</a> launched in November 2020.</p>
					</div>

					<div>
						<span
							class="number-largest has-arrow-after text-purple lh-100">28%</span>
						<span
							class="text-green uppercase fw-bold block">Increase</span>
						<div class="icon-divider smaller"></div>
						<p><a href="/certification/kcsp/">Kubernetes Certified Service Provider (KCSP)</a> program reached 230 certifications in 2021.</p>
					</div>

					<div>
						<span
							class="number-largest has-arrow-after text-purple lh-100">14%</span>
						<span
							class="text-green uppercase fw-bold block">Increase</span>
						<div class="icon-divider smaller"></div>
						<p><a href="/certification/kubernetes-training-partners/">Kubernetes Training Partner (KTP)</a> program grew to 57 certified companies.</p>
					</div>

				</div>

				<div aria-hidden="true" class="ar-spacer-100"></div>

				<div class="section-grid-12">

					<div>
						<div class="sub-section-header-container">
							<h3 class="sub-section-header">CNCF <br
									class="show-upto-1000">Funded <br
									class="show-upto-700">Training</h3>
						</div>

						<p
							class="secondary-sub-section">Courses that CNCF funded in 2021:</p>

						<p><a href="https://training.linuxfoundation.org/training/introduction-to-kubernetes-on-edge-with-k3s-lfs156x/" class="lh-125 text-purple"><strong>Introduction to Kubernetes on Edge with k3s</strong></a><br/>
A deep dive into the use cases and applications of Kubernetes at the edge using examples, labs, and a technical overview of the K3s project and the cloud native edge ecosystem.</p>

						<p><a href="https://training.linuxfoundation.org/training/inclusive-strategies-for-open-source-lfc103/" class="lh-125 text-purple"><strong>Inclusive Strategies for Open Source (LFC103)</strong></a><br/>
Delivers effective strategies for creating inclusive open source communities and code bases.</p>

					</div>

					<img loading="lazy" width="571" height="495"
						src="<?php Lf_Utils::get_image( 'annual-reports/2021/blob-funded-training.png', true ); ?>"
						alt="Man and woman working on laptops">

				</div>

				<div aria-hidden="true" class="ar-spacer-160"></div>
				<div class="hr-divider"></div>
				<div aria-hidden="true" class="ar-spacer-100"></div>
				<div class="more-wrapper">
					<p
						class="secondary-sub-section lh-100 mb-0">Enjoyed our 2021 training highlights? Get more details in the full report...</p>
					<div aria-hidden="true" class="ar-spacer-40 show-upto-700">
					</div>
					<a href="<?php echo esc_url( $pdf_link ); ?>"
						class="ar-button is-pink is-larger">Download Full
						Report</a>
				</div>

				<div aria-hidden="true" class="ar-spacer-160"></div>


			</div>
		</section>

		<section class="background-image-wrapper alignfull is-section-hero"
			id="projects">
			<div class="background-image-text-overlay">
				<div class="container wrap">
					<h2 class="header-title fw-extrabold">
						<span class="add-blob">Project Updates
							&</span><br />Satisfaction
					</h2>
				</div>
			</div>

			<div class="overlay-layer nude-green-gradient-75"></div>

			<figure class="background-image-shape">
				<img loading="lazy" src="
				<?php
				Lf_Utils::get_svg( 'annual-reports/2021/shapes.svg', true );
				?>
				" alt="Background shapes">
			</figure>

			<figure class="background-image-figure is-gray green-gradient">
				<?php
				Lf_Utils::display_responsive_images( 66462, 'large', '1200px', '', 'lazy' );
				?>
			</figure>
		</section>

		<section>

			<div aria-hidden="true" class="ar-spacer-160"></div>

			<h2 class="section-intro max-w-1000">Throughout 2021, CNCF
				underscored our commitment to making cloud native ubiquitous. We
				hosted <a href="/projects/">16 graduated projects</a>, <a
					href="/projects/">26 incubating</a>, and <a
					href="/sandbox-projects/">78 sandbox
					projects</a>, driven by more than 142,000 contributors from
				189
				countries.</h2>


			<div class="section-grid-02">

				<div>
					<p
						class="fw-bold">Reflecting the evolution of cloud native, this was the year that solidified Kubernetes' place as the de facto container orchestration tool. In fact, <a href="https://www.redhat.com/en/resources/kubernetes-adoption-security-market-trends-2021-overview">RedHat's Kubernetes adoption, security, and market trends report 2021</a> noted that: “Kubernetes is used by nearly everyone… (and) is living up to its title as the de facto container orchestrator.”</p>

					<p>Complementing this maturation in CNCF's graduated projects, in 2021 the <a href="/people/technical-oversight-committee/">Technical Oversight Committee</a> continued to sharpen focus on app delivery and the ease of creating Kubernetes applications, as well as bolstering the range of increasingly-mature storage projects.</p>

					<p>With security coming under increased global scrutiny this year the <a href="https://github.com/cncf/tag-security">CNCF Security Technical Advisory Group</a> published <a href="/announcements/2021/05/14/cncf-paper-defines-best-practices-for-supply-chain-security/">Software Supply Chain Security Best Practices</a>, to provide a holistic approach to supply chain security. Sarah Allen, then co-chair of the CNCF Security TAG stated: “It's exciting to see CNCF projects, like <a href="/projects/in-toto/">in-toto</a>, providing a key part of supply chain security.”</p>

				</div>

				<div aria-hidden="true"
					class="ar-spacer-60 show-over-700 show-upto-1000"></div>

				<img loading="lazy" width="545" height="440"
					src="<?php Lf_Utils::get_image( 'annual-reports/2021/blob-projects.jpg', true ); ?>"
					alt="Man talking to woman with masks on at conference">

				<div aria-hidden="true"
					class="ar-spacer-40 show-over-700 show-upto-1000"></div>

			</div>

			<div aria-hidden="true" class="ar-spacer-100"></div>

			<div class="sub-section-header-container">
				<h3 class="sub-section-header">CNCF Graduated <br
						class="show-upto-700">Project <br
						class="show-upto-375">Velocity</h3>
			</div>

			<div aria-hidden="true" class="ar-spacer-30"></div>

			<img loading="lazy" width="1150" height="633"
				src="<?php Lf_Utils::get_svg( 'annual-reports/2021/chart-project-velocity.svg', true ); ?>"
				alt="Chart showing CNCF project velocity">

			<div aria-hidden="true" class="ar-spacer-80"></div>

			<div class="sub-section-header-container">
				<h3 class="sub-section-header">CNCF <br
						class="show-upto-700">Projects <br
						class="show-upto-375">Accepted</h3>
			</div>

			<div aria-hidden="true" class="ar-spacer-30"></div>

			<img loading="lazy" width="1150" height="433"
				src="<?php Lf_Utils::get_svg( 'annual-reports/2021/chart-projects-accepted.svg', true ); ?>"
				alt="Chart showing number of projects accepted to CNCF each year">

			<div aria-hidden="true" class="ar-spacer-160"></div>

		</section>

		<section class="bg-gray-gradient alignfull">
			<div class="container wrap">

				<div aria-hidden="true" class="ar-spacer-160"></div>

				<h2 class="section-title uppercase">Project Moves
				</h2>

				<div aria-hidden="true" class="ar-spacer-80"></div>

				<div class="section-grid-02">

					<p
						class="secondary-sub-section">Projects increase their maturity level by demonstrating to the TOC that they have attained end user and vendor adoption, established a healthy rate of code commits and codebase changes, and attracted committers from multiple organizations.</p>

					<div>
						<div class="sub-section-header-container">
							<h3 class="sub-section-header">Graduations</h3>
						</div>

						<div class="project-display-2">
							<div class="project-item">
								<a href="/projects/linkerd/"><img loading="lazy"
										width="140" height="100"
										src="<?php Lf_Utils::get_svg( 'annual-reports/2021/logo-linkerd.svg', true ); ?>"
										alt="Linkerd logo"></a>
							</div>
							<div class="project-item">
								<a href="/projects/open-policy-agent-opa/"><img
										width="140" height="100" loading="lazy"
										src="<?php Lf_Utils::get_svg( 'annual-reports/2021/logo-opa.svg', true ); ?>"
										alt="OPA logo"></a>
							</div>
						</div>
					</div>
				</div>

				<div aria-hidden="true" class="ar-spacer-80"></div>

				<div class="sub-section-header-container">
					<h3 class="sub-section-header">Incubation <br
							class="show-upto-375">Level</h3>
				</div>

				<p
					class="fw-bold">Joined at the Incubation level or moved from Sandbox to Incubation</p>

				<div class="project-display-4">
					<div class="project-item">
						<a href="/projects/flux/"><img width="140" height="100"
								loading="lazy"
								src="<?php Lf_Utils::get_svg( 'annual-reports/2021/logo-flux.svg', true ); ?>"
								alt="Flux logo"></a>
					</div>
					<div class="project-item">
						<a href="/projects/keda/"><img width="140" height="100"
								loading="lazy"
								src="<?php Lf_Utils::get_svg( 'annual-reports/2021/logo-keda.svg', true ); ?>"
								alt="Keda logo"></a>
					</div>
					<div class="project-item">
						<a href="/projects/crossplane/"><img loading="lazy"
								width="140" height="100"
								src="<?php Lf_Utils::get_svg( 'annual-reports/2021/logo-crossplane.svg', true ); ?>"
								alt="Crossplane logo"></a>
					</div>
					<div class="project-item">
						<a href="/projects/longhorn/"><img loading="lazy"
								width="140" height="100"
								src="<?php Lf_Utils::get_svg( 'annual-reports/2021/logo-longhorn.svg', true ); ?>"
								alt="Longhorn logo"></a>
					</div>

					<div class="project-item">
						<a href="/projects/emissary-ingress/"><img
								loading="lazy" width="140" height="100"
								src="<?php Lf_Utils::get_svg( 'annual-reports/2021/logo-emissary.svg', true ); ?>"
								alt="Emissary logo"></a>
					</div>
					<div class="project-item">
						<a href="/projects/cilium/"><img loading="lazy"
								width="140" height="100"
								src="<?php Lf_Utils::get_svg( 'annual-reports/2021/logo-cilium.svg', true ); ?>"
								alt="Cilium logo"></a>
					</div>
					<div class="project-item">
						<a href="/projects/dapr/"><img loading="lazy"
								height="100"
								src="<?php Lf_Utils::get_svg( 'annual-reports/2021/logo-dapr.svg', true ); ?>"
								alt="Dapr logo"></a>
					</div>
				</div>

				<div aria-hidden="true" class="ar-spacer-160"></div>

			</div>
		</section>

		<section class="bg-gray-gradient alignfull">
			<div class="container wrap">

				<div aria-hidden="true" class="ar-spacer-160"></div>

				<h2 class="section-title uppercase">Kubernetes API Endpoint
					Testing</h2>

				<div aria-hidden="true" class="ar-spacer-80"></div>

				<p
					class="secondary-sub-section">2021 saw the update of APISnoop, a visual insight into Kubernetes test coverage.</p>

				<div class="section-grid-09">

					<div>
						<p
							class="fw-bold max-w-500"><a href="https://apisnoop.cncf.io/about">APISnoop</a> is a community-driven project spearheaded by long-time CNCF contributor and community leader <a href="https://twitter.com/hippiehacker">Hippie Hacker</a>, which tracks the testing and conformance coverage of Kubernetes by analyzing the audit logs created by e2e test runs.</p>

						<div aria-hidden="true" class="ar-spacer-80"></div>

						<div class="sub-section-header-container">
							<h3 class="sub-section-header">Endpoint <br
									class="show-upto-1000">Testing <br
									class="show-upto-375">Results</h3>
						</div>

						<div aria-hidden="true"
							class="ar-spacer-20 show-upto-700"></div>

					</div>

					<img loading="lazy" width="364" height="281"
						src="<?php Lf_Utils::get_svg( 'annual-reports/2021/chart-endpoint-testing-key.svg', true ); ?>"
						alt="Endpoint testing chart legend">

					<div aria-hidden="true" class="ar-spacer-30"></div>

					<div aria-hidden="true" class="ar-spacer-60 show-upto-700">
					</div>

				</div>

				<img loading="lazy" width="1150" height="428"
					src="<?php Lf_Utils::get_svg( 'annual-reports/2021/chart-endpoint-testing.svg', true ); ?>"
					alt="Chart showing Kubernetes endpoint testing coverage in different versions">

				<div aria-hidden="true" class="ar-spacer-160"></div>

			</div>
		</section>

		<section class="bg-gray-gradient alignfull">
			<div class="container wrap">

				<div aria-hidden="true" class="ar-spacer-160"></div>

				<h2 class="section-title uppercase">Phippy and friends</h2>

				<div aria-hidden="true" class="ar-spacer-80"></div>

				<div class="phippy-align">
					<p
						class="secondary-sub-section">From a humble PHP app, Phippy has gone on to help thousands of folx take their first steps to understanding cloud native computing — from containerization to automation. Today, Phippy and Friends' mission is to demystify cloud native computing and explain complicated concepts in a compelling, engaging, and easy-to-understand manner.</p>


					<img loading="lazy" width="250" height="400"
						class="image-phippy"
						src="<?php Lf_Utils::get_svg( 'annual-reports/2021/phippy-phippy.svg', true ); ?>"
						alt="Phippy">
				</div>

				<div aria-hidden="true" class="ar-spacer-80"></div>

				<div class="friends-group">

					<div class="friends-item center">

						<img loading="lazy" width="343" height="250"
							class="image-friend"
							src="<?php Lf_Utils::get_svg( 'annual-reports/2021/phippy-hazel.svg', true ); ?>"
							alt="Hazel">

						<span class="text-largest block uppercase">Hazel</span>
						<span
							class="text-medium fw-bold uppercase block text-purple">The
							Hedgehog</span>

						<div class="project-item no-border">
							<a href="/projects/helm/"><img loading="lazy"
									width="140" height="100"
									src="<?php Lf_Utils::get_svg( 'annual-reports/2021/logo-helm.svg', true ); ?>"
									alt="Helm logo"></a>
						</div>

					</div>


					<div class="friends-item center">

						<img loading="lazy" width="343" height="250"
							class="image-friend"
							src="<?php Lf_Utils::get_svg( 'annual-reports/2021/phippy-linky.svg', true ); ?>"
							alt="linky">

						<span class="text-largest block uppercase">Linky</span>
						<span
							class="text-medium fw-bold uppercase block text-purple">The
							Lobster</span>

						<div class="project-item no-border">
							<a href="/projects/linkerd/"><img loading="lazy"
									width="140" height="100"
									src="<?php Lf_Utils::get_svg( 'annual-reports/2021/logo-linkerd.svg', true ); ?>"
									alt="Linkerd logo"></a>
						</div>

					</div>

					<div class="friends-item center">

						<img loading="lazy" width="343" height="250"
							class="image-friend"
							src="<?php Lf_Utils::get_svg( 'annual-reports/2021/phippy-tiago.svg', true ); ?>"
							alt="tiago">

						<span class="text-largest block uppercase">Tiago</span>
						<span
							class="text-medium fw-bold uppercase block text-purple">The
							Tiger</span>

						<div class="project-item no-border">
							<a href="/projects/tikv/"><img loading="lazy"
									width="140" height="100"
									src="<?php Lf_Utils::get_svg( 'annual-reports/2021/logo-tikv.svg', true ); ?>"
									alt="Tikv logo"></a>
						</div>

					</div>
				</div>

				<div aria-hidden="true" class="ar-spacer-80"></div>

				<div aria-hidden="true" class="ar-spacer-40 show-over-1000">
				</div>

				<div class="sub-section-header-container">
					<h3 class="sub-section-header">New <br
							class="show-upto-700">Phippy <br
							class="show-upto-700">Adventures</h3>
				</div>

				<p
					class="fw-bold">We enjoyed new Phippy Adventures in three books:</p>

				<div class="book-group">
					<div>
						<a title="Download Admiral Bash's Island Adventur"
							href="/wp-content/uploads/2021/10/Admiral-Bash.pdf">
							<?php
							Lf_Utils::display_responsive_images( 66485, 'large', '600px', '', 'lazy' );
							?>
						</a>
						<p><span class="fw-bold"><a href="/wp-content/uploads/2021/10/Admiral-Bash.pdf">Admiral Bash's <br/>Island Adventure</a></span><br/>
By the Cartografos Group</p>
					</div>

					<div>
						<a title="Download From 00-K8s, with Love"
							href="/wp-content/uploads/2021/10/From-00-K8s-with-Love_Digital.pdf">
							<?php
							Lf_Utils::display_responsive_images( 66486, 'large', '600px', '', 'lazy' );
							?>
						</a>

						<p><span class="fw-bold"><a href="/wp-content/uploads/2021/10/From-00-K8s-with-Love_Digital.pdf">From 00-K8s, with Love</a></span><br/>
Donated by Microsoft Azure</p>
					</div>

					<div>
						<a title="Download The Illustrated Children's Guide to Kubernetes"
							href="/wp-content/uploads/2021/11/The-Illustrated-Childrens-Guide-to-Kubernetes-Italian-Spark.pdf">
							<?php
							Lf_Utils::display_responsive_images( 66487, 'large', '600px', '', 'lazy' );
							?>
						</a>

						<p><span class="fw-bold"><a href="/wp-content/uploads/2021/11/The-Illustrated-Childrens-Guide-to-Kubernetes-Italian-Spark.pdf">The Illustrated Children's <br/>Guide to Kubernetes</a></span><br/>
In Italian, thanks to SparkFabrik</p>
					</div>
				</div>

				<div aria-hidden="true" class="ar-spacer-60"></div>

				<div class="book-cta">
					<a title="Donate a character"
						href="https://github.com/cncf/foundation/blob/master/phippy-guidelines.md"
						class="box-link"></a>
					<div class="max-w-600">
						<p>Are you a maintainer on a graduated project? Do you want to help others better understand the concepts of cloud native computing?</p>

						<p class="fw-bold uppercase mb-0">Donate a character</p>
					</div>

					<img loading="lazy"
						src="<?php Lf_Utils::get_image( 'annual-reports/2021/phippy-gang.png', true ); ?>"
						alt="Multiple Phippy characters" class="image-book">
				</div>


				<div aria-hidden="true" class="ar-spacer-160"></div>
				<div class="hr-divider"></div>
				<div aria-hidden="true" class="ar-spacer-100"></div>
				<div class="more-wrapper">
					<p
						class="secondary-sub-section lh-100 mb-0">Enjoyed our 2021 project highlights? Get more details in the full report...</p>
					<div aria-hidden="true" class="ar-spacer-40 show-upto-700">
					</div>
					<a href="<?php echo esc_url( $pdf_link ); ?>"
						class="ar-button is-pink is-larger">Download Full
						Report</a>
				</div>

				<div aria-hidden="true" class="ar-spacer-160"></div>

			</div>
		</section>

		<section class="background-image-wrapper alignfull is-section-hero"
			id="community">
			<div class="background-image-text-overlay">
				<div class="container wrap">
					<h2 class="header-title fw-extrabold">
						<span class="add-blob">Community &amp;
						</span><br />Diversity Engagement
					</h2>
				</div>
			</div>

			<div class="overlay-layer nude-green-gradient-75"></div>

			<figure class="background-image-shape">
				<img loading="lazy" src="
				<?php
				Lf_Utils::get_svg( 'annual-reports/2021/shapes.svg', true );
				?>
				" alt="Background shapes">
			</figure>

			<figure class="background-image-figure is-gray green-gradient">
				<?php
				Lf_Utils::display_responsive_images( 66483, 'large', '1200px', '', 'lazy' );
				?>
			</figure>
		</section>

		<section>

			<div aria-hidden="true" class="ar-spacer-160"></div>

			<h2 class="section-intro max-w-1000">The CNCF community spans the
				world, across our contributors, members, meetups, and
				ambassadors. </h2>

			<div class="section-grid-03">

				<div class="shg-01">
					<p
						class="fw-bold">We strengthened our commitment to #TeamCloudNative in 2021, investing in community-driven initiatives to fuel sustained momentum, expansion, growth, and adoption. Importantly, we continued to sharpen focus on our DEI initiatives, ensuring that the ecosystem is a welcoming place where everybody can thrive.</p>

				</div>

				<div class="shg-02">

					<img loading="lazy" width="525" height="426"
						src="<?php Lf_Utils::get_image( 'annual-reports/2021/blob-community.jpg', true ); ?>"
						alt="Kubecon NA 2021 hosts on stage">
				</div>

				<div class="shg-03">

					<div aria-hidden="true" class="ar-spacer-30"></div>

					<div aria-hidden="true" class="ar-spacer-60 show-upto-700">
					</div>

					<h2 class="section-title uppercase">Diversity, equity and
						inclusion
					</h2>

					<div aria-hidden="true" class="ar-spacer-40"></div>

					<div aria-hidden="true" class="ar-spacer-40 show-upto-700">
					</div>

					<p>CNCF continues to support the development of this incredible cloud native community while also striving to ensure that everyone who participates feels welcome, regardless of gender, gender identity, sexual orientation, disability, race, ethnicity, age, religion, or economic status. To date, we've offered close to 3,800 diversity and need-based scholarships.</p>

				</div>
			</div>

			<div aria-hidden="true" class="ar-spacer-40"></div>

			<div class="sub-section-header-container">
				<h3 class="sub-section-header">Women &amp; <br
						class="show-upto-1000">Gender <br />Non-conforming <br
						class="show-upto-1000">Speakers</h3>
			</div>

			<div aria-hidden="true" class="ar-spacer-30"></div>


			<div class="section-grid-13">

				<div>

					<div class="dei-grid">
						<div>
							<span
								class="number-largest text-purple lh-100">43%</span>
							<span class="text-green uppercase fw-bold block">of
								keynotes at <br />
								Kubecon EU</span>
						</div>

						<div aria-hidden="true"
							class="ar-spacer-80 show-upto-700"></div>

						<div>
							<span
								class="number-largest text-purple lh-100">46%</span>
							<span class="text-green uppercase fw-bold block">of
								keynotes at <br />
								Kubecon NA</span>
						</div>
					</div>

					<div aria-hidden="true" class="ar-spacer-80"></div>

					<div class="sub-section-header-container">
						<h3 class="sub-section-header">Scholarships</h3>
					</div>

					<div aria-hidden="true" class="ar-spacer-30"></div>

					<p>Scholarships were funded by sponsorships from Apple, Cisco, Cloud Native Computing Foundation, Cockroach Labs, Google Cloud, Iguazio, Meltwater, Salesforce, Scaleway, StackPulse, and Styra. Recipients were able to attend Kubecon + CloudNativeCon NA.</p>

					<div class="dei-grid">
						<div>
							<span
								class="number-largest text-purple lh-100">685</span>
							<span
								class="text-green uppercase fw-bold block">Diversity
								Recipients</span>
						</div>

						<div aria-hidden="true"
							class="ar-spacer-80 show-upto-700"></div>

						<div>
							<span
								class="number-largest text-purple lh-100">807</span>
							<span
								class="text-green uppercase fw-bold block">need-based
								recipients</span>
						</div>
					</div>

				</div>

				<div aria-hidden="true" class="ar-spacer-80 show-upto-1000">
				</div>

				<div class="align-end">
					<img loading="lazy" width="383" height="359"
						src="<?php Lf_Utils::get_svg( 'annual-reports/2021/clipart-community.png', true ); ?>"
						alt="Drawing of two people talking">
				</div>

				<div aria-hidden="true" class="ar-spacer-160"></div>

		</section>

		<section class="bg-gray-gradient alignfull">
			<div class="container wrap">

				<div aria-hidden="true" class="ar-spacer-160"></div>

				<h2 class="section-title uppercase">Community Awards</h2>

				<div aria-hidden="true" class="ar-spacer-80"></div>

				<p
					class="secondary-sub-section max-w-800">Now in their fifth year, the CNCF Community Awards highlighted the most active ambassador and top contributors across all CNCF projects. The awards included:</p>

				<div aria-hidden="true" class="ar-spacer-40 show-over-700">
				</div>

				<div class="section-grid-14">

					<div>

						<div class="community-item">

							<img loading="lazy" width="250" height="250"
								src="<?php Lf_Utils::get_svg( 'annual-reports/2021/community-awards-01.png', true ); ?>"
								alt="Nikhita Raghunath">

							<div aria-hidden="true"
								class="ar-spacer-60 show-upto-700"></div>
							<div>
								<p
									class="text-medium fw-bold"><span class="text-purple">TOP</span> Cloud Native Committer</p>
								<p>An individual with incredible technical skills and notable technical achievements in one or multiple CNCF projects. The 2021 recipient was <strong><a href="https://twitter.com/thenikhita">Nikhita Raghunath</a></strong>.</p>
							</div>

						</div>
						<div class="icon-divider"></div>
						<div class="community-item">

							<img loading="lazy" width="250" height="250"
								src="<?php Lf_Utils::get_svg( 'annual-reports/2021/community-awards-02.png', true ); ?>"
								alt="Anaïs Urlichs">

							<div aria-hidden="true"
								class="ar-spacer-60 show-upto-700"></div>

							<div>
								<p
									class="text-medium fw-bold"><span class="text-purple">TOP</span> Cloud Native Ambassador</p>
								<p>An individual with incredible community-oriented skills, focused on spreading the word and sharing knowledge with the entire cloud native community or within a specific project. The 2021 recipient was <strong><a href="https://twitter.com/urlichsanais">Anaïs Urlichs</a></strong>.</p>
							</div>

						</div>
						<div class="icon-divider"></div>
						<div class="community-item">

							<img loading="lazy" width="250" height="250"
								src="<?php Lf_Utils::get_svg( 'annual-reports/2021/community-awards-03.png', true ); ?>"
								alt="Tim Bannister">

							<div aria-hidden="true"
								class="ar-spacer-60 show-upto-700"></div>
							<div>
								<p
									class="text-medium fw-bold"><span class="text-purple">TOP</span> Documentarian <span class="text-smaller">(new in 2021)</span></p>
								<p>This award recognizes excellence in documentation contributions to CNCF and its projects. Excellent technical documentation is one of the best ways projects can lower the barrier to contribution. The 2021 recipient was <strong><a href="https://github.com/sftim">Tim Bannister</a></strong>.</p>
							</div>

						</div>

					</div>

					<div aria-hidden="true"
						class="ar-spacer-120 show-upto-1000"></div>

					<div class="align-end">

						<div class="icon">
							<img loading="lazy" width="89" height="52"
								src="<?php Lf_Utils::get_svg( 'annual-reports/2021/icon-members.svg', true ); ?>"
								alt="People icon">
						</div>

						<p
							class="text-medium fw-bold uppercase text-purple mb-20">"Chop Wood and <br class="show-upto-700">Carry Water"</p>

						<div class="icon-divider no-spacing"></div>

						<p>To recognize contributors who spend countless hours completing often mundane tasks, CNCF created the “Chop Wood and Carry Water” awards. CNCF was proud to acknowledge the amazing efforts of five individuals for their outstanding contributions in 2021:</p>

						<p><strong><a href="https://twitter.com/TheMoxieFox">Emily Fox</a>, <a href="https://twitter.com/aevavoom">Aeva Black</a>, <a href="https://twitter.com/TashaDrew">Tasha Drew</a>, <a href="https://twitter.com/comedordexis">Carlos Panato</a>, <a href="https://twitter.com/carolynvs">Carolyn Van Slyck</a></strong>.</p>

						<img loading="lazy"
							src="<?php Lf_Utils::get_svg( 'annual-reports/2021/community-chop.png', true ); ?>"
							alt="Photos of several people">

						<div aria-hidden="true" class="ar-spacer-30"></div>

						<div aria-hidden="true"
							class="ar-spacer-60 show-over-1000"></div>

					</div>

				</div>

				<div aria-hidden="true" class="ar-spacer-160"></div>

			</div>
		</section>

		<section class="bg-gray-gradient alignfull">
			<div class="container wrap">

				<div aria-hidden="true" class="ar-spacer-160"></div>

				<h2 class="section-title uppercase">CNCF Meetups become <br
						class="show-over-1000">Community Groups</h2>

				<div aria-hidden="true" class="ar-spacer-80"></div>

				<p
					class="secondary-sub-section max-w-900">2021 saw the cloud native community switch from the Meetup platform to <a href="https://community.cncf.io/">Cloud Native Community Groups</a> and the new platform has taken off. It has become the singular place where meetups, online programs, project office hours, and community events are run. The platform now hosts over 29,000 members and we are excited to see this platform continue to grow.</p>


				<div class="sub-section-header-container">
					<h3 class="sub-section-header">Community <br
							class="show-upto-700">Groups 2021</h3>
				</div>

				<div aria-hidden="true" class="ar-spacer-30"></div>

				<div class="section-grid-15">

					<div class="icon-callout-3">
						<div class="icon">
							<img loading="lazy" width="89" height="52"
								src="<?php Lf_Utils::get_svg( 'annual-reports/2021/icon-members.svg', true ); ?>"
								alt="People icon">
						</div>
						<p><span class="number-large text-purple">27,000+</span><br/><span class="text-green uppercase fw-bold">Attendees</span></p>
					</div>

					<div class="icon-callout-3">
						<p><span class="number-large text-purple">922</span><br/><span class="text-green uppercase fw-bold">Events</span></p>
					</div>
					<div class="icon-callout-3">
						<p><span class="number-large text-purple">356</span><br/><span class="text-green uppercase fw-bold">Chapters</span></p>
					</div>
				</div>

				<div aria-hidden="true" class="ar-spacer-80"></div>

				<div class="sub-section-header-container">
					<h3 class="sub-section-header">CNCF <br
							class="show-upto-700">Meetup <br
							class="show-upto-375">Members</h3>
				</div>

				<div aria-hidden="true" class="ar-spacer-30"></div>

				<img loading="lazy" width="1150" height="379"
					src="<?php Lf_Utils::get_svg( 'annual-reports/2021/chart-meetup-members.svg', true ); ?>"
					alt="Chart showing number of members in CNCF meetup group over time">

				<div aria-hidden="true" class="ar-spacer-160"></div>
				<div class="hr-divider"></div>
				<div aria-hidden="true" class="ar-spacer-100"></div>
				<div class="more-wrapper">
					<p
						class="secondary-sub-section lh-100 mb-0">Enjoyed our 2021 community highlights? Get more details in the full report...</p>
					<div aria-hidden="true" class="ar-spacer-40 show-upto-700">
					</div>
					<a href="<?php echo esc_url( $pdf_link ); ?>"
						class="ar-button is-pink is-larger">Download Full
						Report</a>
				</div>

				<div aria-hidden="true" class="ar-spacer-160"></div>

			</div>
		</section>

		<section class="background-image-wrapper alignfull is-section-hero"
			id="ecosystem">
			<div class="background-image-text-overlay">
				<div class="container wrap">
					<h2 class="header-title fw-extrabold">
						<span class="add-blob">Mentoring &
						</span><br />Ecosystem Resources
					</h2>
				</div>
			</div>

			<div class="overlay-layer nude-green-gradient-75"></div>

			<figure class="background-image-shape">
				<img loading="lazy" src="
				<?php
				Lf_Utils::get_svg( 'annual-reports/2021/shapes.svg', true );
				?>
				" alt="Background shapes">
			</figure>

			<figure class="background-image-figure is-gray green-gradient">
				<?php
				// Mentoring section header.
				Lf_Utils::display_responsive_images( 66464, 'large', '1200px', '', 'lazy' );
				?>
			</figure>
		</section>

		<section>

			<div aria-hidden="true" class="ar-spacer-160"></div>

			<h2 class="section-intro max-w-1000">CNCF worked closely in
				partnership with individual contributors and community groups
				throughout 2021, developing programs to navigate and manage the
				fast-growing ecosystem, rising to meet the growing global demand
				for cloud native technologies.</h2>


			<div class="section-grid-02">

				<div>
					<h2 class="section-title uppercase text-purple">Cloud Native
						Landscape
						Guide
					</h2>

					<div aria-hidden="true" class="ar-spacer-40"></div>

					<p
						class="fw-bold">If you've researched cloud native applications and technologies, you've probably come across the <a href="https://landscape.cncf.io/">CNCF cloud native landscape</a>. Unsurprisingly, the sheer scale of it can be overwhelming, with so many categories and so many technologies. In 2021, to help make sense of this important tool, we launched the <a href="https://landscape.cncf.io/guide">Cloud Native Landscape Guide</a>. This breaks down our mammoth landscape and provides a high-level overview of its layers, columns, and categories.</p>

					<p>A huge thank you to those who made the guide possible! The cloud native landscape guide was initiated by the <a href="https://github.com/cncf/business-value">CNCF Business Value Subcommittee</a> and <a href="https://github.com/cncf/cartografos">Cartografos group</a>. It was authored by <a href="https://www.linkedin.com/in/jasonmorgan2/">Jason Morgan</a> and <a href="https://www.linkedin.com/in/catherinepaganini/">Catherine Paganini</a>, edited and reviewed by <a href="https://www.linkedin.com/in/forsters/">Simon Forster</a> and <a href="https://twitter.com/idvoretskyi">Ihor Dvoretskyi</a>, and built by <a href="https://www.linkedin.com/in/jordinoguera/">Jordi Noguera</a>, with UX consultation from <a href="https://www.linkedin.com/in/andreavelazquez1/">Andrea Velázquez</a>. </p>

				</div>

				<div aria-hidden="true" class="ar-spacer-40 show-upto-700">
				</div>

				<img loading="lazy" width="545" height="457"
					src="<?php Lf_Utils::get_image( 'annual-reports/2021/blob-mentoring.jpg', true ); ?>"
					alt="Two men in masks talking at conference">

			</div>

			<div aria-hidden="true" class="ar-spacer-160"></div>

		</section>

		<section class="bg-gray-gradient alignfull">
			<div class="container wrap">

				<div aria-hidden="true" class="ar-spacer-160"></div>

				<div class="glossary-align">

					<h2 class="section-title uppercase">CNCF Glossary</h2>

					<div aria-hidden="true" class="ar-spacer-60"></div>

					<p
						class="secondary-sub-section  max-w-700">In May, we introduced the new <a href="https://glossary.cncf.io/">CNCF Cloud Native Glossary</a> to provide anyone getting started with cloud native an introduction that is largely free of jargon and assumptions of pre-existing familiarity.</p>

					<p
						class="fw-bold">It <a href="https://github.com/cncf/glossary/blob/main/cloudnative-glossary.pdf">launched with 25 terms</a> and more will be added with time. The project is spearheaded by the <a href="https://docs.google.com/document/d/1ktepjTLoxtxiM7rEoPD803FZFC_DnEuIAsBZU6yZY4Y/edit?usp=sharing">Business Value Subcommittee (BVS)</a>, whose primary goal is to provide tools to educate executives, business leaders, and non-technical audiences on cloud native technologies and their business value. </p>

					<img loading="lazy" class="image-glossary"
						src="<?php Lf_Utils::get_image( 'annual-reports/2021/clipart-glossary.png', true ); ?>"
						alt="Drawing of woman walking">

				</div>

				<div aria-hidden="true" class="ar-spacer-40 show-over-700">
				</div>

				<div class="quote-container max-w-800">
					<p
						class="quote">As technologists we have a moral obligation to ensure that business stakeholders understand the transformative change that cloud native allows, and that cloud native isn't seen only as a set of technologies.</p>
					<div class="add-quote-marks">
						<p class="by-name fw-semi">Daniel Jones</p>
						<p
							class="by-position">Managing Director of EngineerBetter</p>
					</div>
				</div>

				<div aria-hidden="true" class="ar-spacer-60"></div>

				<div class="glossary-cta">
					<div class="max-w-600">
						<p
							class="fw-bold mb-0 text-smallish">The Glossary is a community-driven effort and everyone is welcome to contribute new terms, update current ones, or help translate into different languages.</p>
					</div>

					<div class="glossary-button">

						<div aria-hidden="true"
							class="ar-spacer-40 show-upto-700"></div>

						<a href="https://glossary.cncf.io/contribute/"
							class="ar-button is-pink">Contribute</a>
					</div>
				</div>

				<div aria-hidden="true" class="ar-spacer-160"></div>

			</div>
		</section>

		<section class="bg-gray-gradient alignfull">
			<div class="container wrap">

				<div aria-hidden="true" class="ar-spacer-160"></div>

				<h2 class="section-title uppercase">Community Mentoring</h2>

				<div aria-hidden="true" class="ar-spacer-80"></div>

				<p
					class="secondary-sub-section max-w-800">CNCF proudly supported more than 100 individuals through various <a href="https://github.com/cncf/mentoring">mentoring and internship</a> opportunities in 2021, including the <a href="https://lfx.linuxfoundation.org/">LFX mentorship platform</a> (previously known as Community Bridge), <a href="https://summerofcode.withgoogle.com/">Google Summer of Code (GSoC)</a>, <a href="https://developers.google.com/season-of-docs">Google Summer of Docs (GSoD)</a>, and <a href="https://www.outreachy.org/">Outreachy</a>. These programs are important catalysts for internships to have an impact on future technologies that we all depend on.</p>

				<div aria-hidden="true" class="ar-spacer-60"></div>

			</div>
		</section>

		<section
			class="background-image-wrapper alignfull is-mentoring-section">

			<div class="background-image-text-overlay">
				<div class="container wrap">

					<div class="icon-callout-3">
						<div class="icon">
							<img loading="lazy"
								src="<?php Lf_Utils::get_svg( 'annual-reports/2021/icon-w-members.svg', true ); ?>"
								alt="People icon">
						</div>
						<p
							class="text-large"><span class="text-white uppercase fw-bold">Mentoring </span><br/><span class="text-light-green uppercase fw-bold">In Numbers</span></p>
					</div>

					<div aria-hidden="true" class="ar-spacer-60"></div>

					<p><span class="number-large text-light-green">104 </span><span class="text-white uppercase fw-bold text-medium">Mentorships</span></p>

					<div class="mentoring-numbers">
						<div>
							<p class="text-white"><strong>86</strong> LFX MENTORSHIP<br/>
<strong>16</strong> GOOGLE SUMMER OF CODE<br/>
<strong>1</strong> GOOGLE SUMMER OF DOCS<br/>
<strong>1</strong> OUTREACHY</p>
						</div>
						<div>
							<div aria-hidden="true"
								class="ar-spacer-80 show-upto-700"></div>

							<a href="https://github.com/cncf/mentoring"
								class="ar-button is-pink">Get involved</a>
						</div>
					</div>

				</div>
			</div>

			<!-- Mentoring in numbers section  -->
			<figure class="background-image-figure">
				<?php
				Lf_Utils::display_responsive_images( 66484, 'large', '1200px', '', 'lazy' );
				?>
			</figure>
		</section>

		<section>

			<div aria-hidden="true" class="ar-spacer-160"></div>

			<h2 class="section-title uppercase">Who we are</h2>

			<div aria-hidden="true" class="ar-spacer-80"></div>

			<p
				class="secondary-sub-section max-w-800">The Cloud Native Computing Foundation (CNCF) is an open source software foundation dedicated to making cloud native computing universal and sustainable. </p>

			<p
				class="max-w-700">Presently folx on our staff and governing board self-identify as she/her or he/him. We welcome all individuals and encourage applications for future opportunities on the <a href="https://jobs.cncf.io">CNCF Job board</a>.</p>

			<div aria-hidden="true" class="ar-spacer-60"></div>

			<div class="section-grid-14">

				<div>

					<div class="sub-section-header-container">
						<h3 class="sub-section-header">Staff</h3>
					</div>

					<img loading="lazy" width="679" height="650"
						src="<?php Lf_Utils::get_image( 'annual-reports/2021/who-staff.png', true ); ?>"
						alt="Data visulization showing proportion of men and women in staff">

				</div>

				<div>

					<div aria-hidden="true" class="ar-spacer-80 show-upto-1000">
					</div>

					<div class="sub-section-header-container">
						<h3 class="sub-section-header">Executive <br
								class="show-upto-700">Leadership</h3>
					</div>

					<img loading="lazy"
						src="<?php Lf_Utils::get_svg( 'annual-reports/2021/who-exec.svg', true ); ?>"
						alt="Data visulization showing proportion of men and women in exec leadership">

					<div aria-hidden="true" class="ar-spacer-80 "></div>

					<div class="sub-section-header-container">
						<h3 class="sub-section-header">Governance <br
								class="show-upto-700">Leadership</h3>
					</div>

					<img loading="lazy"
						src="<?php Lf_Utils::get_svg( 'annual-reports/2021/who-governance.svg', true ); ?>"
						alt="Data visulization showing proportion of men and women in governance leadership">

				</div>
			</div>

			<div aria-hidden="true" class="ar-spacer-160"></div>

		</section>

		<section class="bg-gray-gradient alignfull">
			<div class="container wrap">

				<div aria-hidden="true" class="ar-spacer-160"></div>

				<h2 class="section-title uppercase">Funding</h2>

				<div aria-hidden="true" class="ar-spacer-80"></div>

				<p
					class="secondary-sub-section max-w-800">CNCF's revenue is derived from four primary fundraising sources, including membership, event sponsorship, event registration, and training. </p>

				<div class="sub-section-header-container">
					<h3 class="sub-section-header">Four <br
							class="show-upto-700">Funding <br
							class="show-upto-375">Sources</h3>
				</div>

				<img loading="lazy" width="1150" height="515"
					src="<?php Lf_Utils::get_image( 'annual-reports/2021/chart-funding.png', true ); ?>"
					alt="Data visulization showing CNCF funding sources">

				<p
					class="max-w-700 fw-bold">A basic premise behind CNCF, our conferences (including <a href="https://kubecon.io/">KubeCon + CloudNativeCon</a>), and open source, in general, is that interactions are positive-sum. There is no fixed amount of investment, mindshare, or development contribution allocated to specific projects.</p>

				<p
					class="max-w-700">Equally important, a neutral home for a project and community fosters this type of positive-sum thinking and drives the growth and diversity that we believe are core elements of a successful open source project.</p>

				<div aria-hidden="true" class="ar-spacer-160"></div>

			</div>
		</section>

		<section class="bg-gray-gradient alignfull">
			<div class="container wrap">

				<div aria-hidden="true" class="ar-spacer-160"></div>

				<div class="section-grid-17">

					<div class="shg-01">
						<h2 class="section-title uppercase">Thank You</h2>

						<div aria-hidden="true" class="ar-spacer-60"></div>

						<h3 class="section-intro outro">We hope you enjoyed
							reflecting on <br class="show-over-1200">all the
							great things we accomplished <br
								class="show-over-1200">together
							in 2021.</h3>

						<p
							class="text-medium fw-semi">Your comments and feedback are welcome at <a href="mailto:info@cncf.io">info@cncf.io</a>.</p>

					</div>

					<div class="shg-02">

						<a href="<?php echo esc_url( $pdf_link ); ?>"
							title="Download CNCF Annual Report 2021 PDF">
							<?php
							Lf_Utils::display_responsive_images( 66630, 'large', '500px', '', 'lazy' );
							?>
						</a>

						<div aria-hidden="true" class="ar-spacer-60"></div>

						<a href="<?php echo esc_url( $pdf_link ); ?>"
							title="Download CNCF Annual Report 2021 PDF"
							class="ar-button is-pink is-larger w-full">Download
							Full
							Report</a>

						<div aria-hidden="true"
							class="ar-spacer-120 show-upto-700"></div>
					</div>

					<div class="shg-03">

						<div class="ar-social-share is-pink">
							<p class="ss-title lh-100 mb-0">Share</p>

							<div class="ss-wrapper">
								<!-- twitter -->
								<?php if ( $twitter_url ) : ?>
								<a  aria-label="Share on Twitter"
									title="Share on Twitter"
									href="<?php echo esc_url( $twitter_url ); ?>"><?php Lf_Utils::get_svg( 'annual-reports/2021/social-twitter.svg' ); ?></a>
								<?php endif; ?>

								<!-- linkedin -->
								<?php if ( $linkedin_url ) : ?>
								<a
									aria-label="Share on Linkedin"
									title="Share on Linkedin"
									href="<?php echo esc_url( $linkedin_url ); ?>"><?php Lf_Utils::get_svg( 'annual-reports/2021/social-linkedin.svg' ); ?></a>
								<?php endif; ?>

								<!-- sendto email -->
								<?php if ( $mailto_url ) : ?>
								<a  aria-label="Share by Email"
									title="Share by Email"
									href="<?php echo esc_url( $mailto_url ); ?>"><?php Lf_Utils::get_svg( 'annual-reports/2021/social-mail.svg' ); ?></a>
								<?php endif; ?>
							</div>
						</div>

						<div aria-hidden="true" class="ar-spacer-80"></div>

						<p
							class="event-push"><span class="fw-bold text-purple">We're looking forward to seeing you in 2022!</span><br>Check out our calendar for community events near you and don't forget to register for <a href="https://events.linuxfoundation.org/kubecon-cloudnativecon-europe">KubeCon+CloudNativeCon Europe</a> in Valencia, May 2022.</p>


					</div>

				</div>

				<div aria-hidden="true" class="ar-spacer-40 show-over-1000">
				</div>

				<a
					href="https://events.linuxfoundation.org/kubecon-cloudnativecon-europe">
					<img loading="lazy" width="1150" height="241"
						src="<?php Lf_Utils::get_image( 'annual-reports/2021/banner-kubecon-eu-22.png', true ); ?>"
						alt="Kubecon EU 2022 banner">
				</a>

				<div aria-hidden="true" class="ar-spacer-160"></div>

				<!-- end of article/page container -->
	</article>
</main>
<?php

// chart js.
wp_enqueue_script(
	'chart-js',
	get_template_directory_uri() . '/source/js/libraries/chart.min.js',
	null,
	filemtime( get_template_directory() . '/source/js/libraries/chart.min.js' ),
	true
);

// custom scripts.
wp_enqueue_script(
	'annual-report-21',
	get_template_directory_uri() . '/source/js/on-demand/annual-report-21.js',
	array( 'jquery', 'chart-js' ),
	filemtime( get_template_directory() . '/source/js/on-demand/annual-report-21.js' ),
	true
);

get_template_part( 'components/footer' );
