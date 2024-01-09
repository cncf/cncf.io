<?php
/**
 * Template Name: Annual Report 2023
 * Template Post Type: lf_report
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

// Report folder in images/ folder.
$report_folder = 'annual-reports/2023/';

get_template_part( 'components/header' );

get_template_part( 'components/skip-link-target' );

wp_enqueue_style( 'ar-2023', get_template_directory_uri() . '/build/annual-report-2023.min.css', array(), filemtime( get_template_directory() . '/build/annual-report-2023.min.css' ), 'all' );

wp_enqueue_style( 'wp-block-group' );
wp_enqueue_style( 'wp-block-column' );
wp_enqueue_style( 'wp-block-columns' );

// setup social share icons + data.
$caption      = 'Read the CNCF Anunal Report 2023 ';
$page_url     = rawurlencode( get_permalink() );
$caption      = htmlspecialchars( rawurlencode( html_entity_decode( $caption, ENT_COMPAT, 'UTF-8' ) ), ENT_COMPAT, 'UTF-8' );
$options      = get_option( 'lf-mu' );
$twitter      = $options && $options['social_twitter_handle'] ? $options['social_twitter_handle'] : null;
$twitter_url  = 'https://twitter.com/intent/tweet?text=' . $caption . '&amp;url=' . $page_url . '&amp;hashtags=cncf&amp;via=' . $twitter . '';
$linkedin_url = 'https://www.linkedin.com/shareArticle?mini=true&url=' . $page_url . '&summary=' . $caption;
$mailto_url   = 'mailto:?subject=' . $caption . '&body=' . $caption . '&nbsp;' . $page_url;
?>

<link rel="prefetch"
	href="<?php echo esc_url( get_template_directory_uri() . '/build/annual-report-2023.min.css' ); ?>"
	as="style" crossorigin="anonymous" />

<main class="ar-2023">
	<article class="container wrap">

		<section class="hero alignfull">
			<div class="container wrap hero__container">
				<figure class="hero__container-bg-figure">
					<?php
					LF_Utils::display_responsive_images( 99525, 'full', '2400px', 'hero__container-bg-image', 'eager', 'City architecture diagram' );
					?>
				</figure>
				<div class="hero__content">

					<picture>
						<source media="(max-width: 599px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'hero-mobile.svg', true );
?>
">
						<source media="(min-width: 600px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'hero-desktop.svg', true );
?>
">
						<img width="632" height="262" src="
<?php
Lf_Utils::get_svg( $report_folder . 'hero-desktop.svg', true );
?>
" alt="CNCF Annual Report 2023 - Architect the Future" loading="eager" decoding="async" class="hero__title">
					</picture>



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
					<a href="#momentum" title="Jump to Momentum section"
						class="box-link"></a>
					<img loading="lazy" decoding="async" width="36" height="36" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-upward-chart.svg', true ); ?>
" alt="Upward trend chart icon">Momentum
				</div>

				<div class="nav-el__box">
					<a href="#events" title="Jump to Events section"
						class="box-link"></a>
					<img loading="lazy" decoding="async" width="36" height="36" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-lanyard.svg', true ); ?>
" alt="Lanyard icon">Events
				</div>

				<div class="nav-el__box">
					<a href="#training" title="Jump to Training section"
						class="box-link"></a>
					<img loading="lazy" decoding="async" width="36" height="36" src="
<?php
LF_Utils::get_svg( $report_folder . 'icon-teacher.svg', true );
?>
" alt="Teacher icon">Training
				</div>

				<div class="nav-el__box">
					<a href="#projects" title="Jump to Projects section"
						class="box-link"></a>
					<img loading="lazy" decoding="async" width="36" height="36" src="
<?php
LF_Utils::get_svg( $report_folder . 'icon-shape.svg', true );
?>
" alt="chart icon">Projects
				</div>

				<div class="nav-el__box">
					<a href="#community" title="Jump to Community section"
						class="box-link"></a>
					<img loading="lazy" decoding="async" width="36" height="36" src="
<?php
LF_Utils::get_svg( $report_folder . 'icon-relationship.svg', true );
?>
" alt="Relationship icon">Community
				</div>

				<div class="nav-el__box">
					<a href="#ecosystem" title="Jump to Ecosystem section"
						class="box-link"></a>
					<img loading="lazy" decoding="async" width="36" height="36" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-ecosystem.svg', true ); ?>
" alt="Ecosystem icon">Ecosystem
				</div>
			</div>
		</section>

		<section class="section-01">
			<h2 class="section-01__title">Welcome! It's been a <br
					class="show-over-1000">year to remember</h2>

			<div class="lf-grid section-01__grid">
				<div class="section-01__grid-col1">

					<p><strong>This year was a game changer for cloud native. Six years ago at KubeCon + CloudNativeCon Berlin OpenAI gave a talk titled <a href="https://www.youtube.com/watch?v=v4N3Krzb8Eg">Building the Infrastructure that Powers the Future of AI – the future is now</a>. Today, cloud native is providing the infrastructure for the AI movement, and it was particularly exciting for me to watch Adobe’s Joseph Sandoval lead a panel discussion during my <a href="https://www.youtube.com/watch?v=NcLAVtQ5H4A">KubeCon + CloudNativeCon North America keynote</a>, discussing how we can ensure cloud native supports AI’s rapid growth, and how we can do this whilst developing a more sustainable, safe ecosystem.</strong></p>

					<p>As Adobe exemplifies, end users are pivotal to the cloud native movement. This is why CNCF launched the End User Technical Advisory Board, which is instrumental in illuminating the path for adopting and operationalizing CNCF projects. Through their development and approval of reference architectures and showcasing of end user workflow patterns, the TAB provides critical clarity and guidance. These efforts support current use cases and lay the groundwork for a dynamic and thriving ecosystem that evolves with the changing landscape of cloud native technologies.</p>

					<p>CNCF’s Technical Advisory Groups continued to drive the evolution of impactful cloud native initiatives, from the maturity of platform engineering, to sustainability. On sustainability, it was amazing to see #TeamCloudNative gather throughout the world for the first Cloud Native Sustainability Week. Kudos to <a href="https://tag-env-sustainability.cncf.io/">TAG Environmental Sustainability</a> for your hard work.</p>

					<p>Congratulations to you, #TeamCloudNative, on another stellar year. Wishing you all very happy holidays, and I’m looking forward to seeing what we will achieve in 2024.</p>

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
							<img loading="lazy" decoding="async" width="71" height="74" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-projects.svg', true ); ?>
" alt="Projects icon">
						</div>
						<div class="text">
							<span>173 Projects</span><br />
							Driving worldwide <br>transformation
						</div>
					</div>

					<!-- Icon 2  -->
					<div class="icon-box-1">
						<div class="icon">
							<img loading="lazy" decoding="async" width="74" height="43" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-members.svg', true ); ?>
" alt="Members icon">
						</div>
						<div class="text">
							<span>827 Members</span><br />
							Across 6 continents
						</div>
					</div>

					<!-- Icon 3  -->
					<div class="icon-box-1">
						<div class="icon">
							<img loading="lazy" decoding="async" width="60" height="57" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-chapter.svg', true ); ?>
" alt="Chapter icon">
						</div>
						<div class="text">
							<span>220K+ Contributors</span><br />
							Fundamentally changing <br>computing
						</div>
					</div>

				</div>
			</div>
		</section>

		<!-- Tweet -->
		<section class="section-tweet">
			<a href="https://twitter.com/furrier/status/1722279020765872363?s=20">
			<?php LF_Utils::display_responsive_images( 99526, 'full', '1200px', null, 'lazy', 'Tweet screenshot' ); ?>
			</a>
		</section>


		<!-- Photo Highlights  -->
		<section class="section-02">

			<div class="wp-block-group is-style-no-padding is-style-see-all">
				<div class="wp-block-columns are-vertically-aligned-centered">
					<div class="wp-block-column is-vertically-aligned-centered"
						style="flex-basis:80%">
						<h3 class="sub-header">2023 Photo Highlights</h3>
					</div>
					<div class="wp-block-column is-vertically-aligned-bottom"
						style="flex-basis:20%">
						<p
							class="has-text-align-right is-style-link-cta"><a href="https://www.flickr.com/photos/143247548@N03/albums/with/72177720303164393" title="View the CNCF Flickr photo feed">See more</a></p>
					</div>
				</div>

				<div class="section-02__slider">
					<div>
						<?php LF_Utils::display_responsive_images( 99515, 'newsroom-post-width', '700px', null, 'lazy', 'Photo from KubeCon + CloudNativeCon Europe 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 99516, 'newsroom-post-width', '700px', null, 'lazy', 'Photo from KubeCon + CloudNativeCon North America 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 99517, 'newsroom-post-width', '700px', null, 'lazy', 'Photo from KubeCon + CloudNativeCon Europe 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 99518, 'newsroom-post-width', '700px', null, 'lazy', 'Photo from KubeCon + CloudNativeCon Europe 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 99519, 'newsroom-post-width', '700px', null, 'lazy', 'Photo from KubeCon + CloudNativeCon North America 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 99520, 'newsroom-post-width', '700px', null, 'lazy', 'Photo from KubeCon + CloudNativeCon North America 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 99521, 'newsroom-post-width', '700px', null, 'lazy', 'Photo from KubeCon + CloudNativeCon North America 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 99522, 'newsroom-post-width', '700px', null, 'lazy', 'Photo from KubeCon + CloudNativeCon North America 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 99523, 'newsroom-post-width', '700px', null, 'lazy', 'Photo from KubeCon + CloudNativeCon North America 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 99524, 'newsroom-post-width', '700px', null, 'lazy', 'Photo from KubeCon + CloudNativeCon North America 2023' ); ?>
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

		<section id="momentum"
			class="section-03 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">2023 <br />
						Momentum</h2>
					<div class="section-number">1/6</div>
				</div>

				<div class="lf-grid">
					<p
						class="opening-paragraph restrictive-10-col">CNCF is the open source software foundation dedicated to making cloud native computing ubiquitous. Since we were founded in 2015, we’ve pioneered <strong>cloud native technologies</strong> – hosting and growing some of the world’s <a href="https://docs.google.com/presentation/d/1UGewu4MMYZobunfKr5sOGXsspcLOH_5XeCLyOHKh9LU/edit#slide=id.g39c264972c_182_212">most successful</a> open source projects including Kubernetes, Prometheus, Envoy, ContainerD, and <a href="https://www.cncf.io/projects/">many others</a>.</p>
				</div>

				<div class="lf-grid">
					<div class="restrictive-10-col">
						<p>Today we are the powerhouse for visionary projects and people, hosting <strong>173 projects</strong>, driven by more than <strong>220,000 contributors</strong> representing <strong>190 countries</strong>, and there are no signs of this momentum slowing down.</p>
					</div>
				</div>
				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="lf-grid section-03__intro">
					<div class="section-03__intro-col1">
						<p class="sub-header">Contributor Growth</p>

						<div aria-hidden="true" class="report-spacer-40"></div>

						<img loading="lazy" decoding="async" width="561" height="400" src="
<?php LF_Utils::get_svg( $report_folder . 'contributors-chart.svg', true ); ?>
" alt="Chart showing upward trend of Contributors growth">

					</div>
					<div class="section-03__intro-col2">
						<p
							class="sub-header">Member, End User & Project Growth</p>
						<div aria-hidden="true" class="report-spacer-40"></div>

						<img loading="lazy" decoding="async" width="550" height="400" src="
<?php LF_Utils::get_svg( $report_folder . 'member-end-user-project-growth.svg', true ); ?>
" alt="Chart showing upward trend of Members, End User and Project growth">

					</div>

				</div>
			</div>
		</section>

		<section class="section-04 is-style-down-gradient alignfull">

			<div class="container wrap">

				<h2 class="section-header">Membership</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-04__membership">
					<div class="section-04__membership-col1">
						<p>The CNCF is supported by <strong>827 participating organizations</strong>, including the world’s largest public and private cloud companies, along with the innovative software companies and end user organizations. Despite the market slowdown, which saw industry mergers and acquisitions deals drop, on average, by 27.4% compared to 2022, CNCF has remained consistent in not only attracting new investment, but in retaining long-term relationships with key industry players. Investment from these leading organizations signifies a strong dedication to the advancement and sustainability of cloud native computing for years to come. </p>
					</div>
					<div class="section-04__membership-col2">

						<img loading="lazy" decoding="async" width="452" height="227" src="
	<?php LF_Utils::get_svg( $report_folder . 'new_members.svg', true ); ?>
	" alt="Members icon">

					</div>
				</div>

			</div>
		</section>

		<section class="section-06">

			<div class="lf-grid section-06__members">
				<div class="section-06__members-col1">
					<p class="sub-header ">New Gold Members</p>
					<div aria-hidden="true" class="report-spacer-60"></div>
					<div class="logo-grid smaller">

						<div class="logo-grid__box">
							<img loading="lazy" decoding="async" width="169" height="54" src="
<?php
LF_Utils::get_svg( $report_folder . 'daocloud_logo.svg', true );
?>
" alt="DaoCloud Logo" class="logo-grid__image">
						</div>

						<div class="logo-grid__box">
							<img loading="lazy" decoding="async" width="77" height="77" src="
<?php
LF_Utils::get_svg( $report_folder . 'ey_logo_2019.svg', true );
?>
" alt="EY Logo" class="logo-grid__image">
						</div>

						<div class="logo-grid__box">
							<img loading="lazy" decoding="async" width="138" height="23" src="
<?php
LF_Utils::get_svg( $report_folder . 'hitachi_logo.svg', true );
?>
" alt="Hitachi Logo" class="logo-grid__image">
						</div>
					</div>
				</div>
				<div class="section-06__members-col2">
					<p
						class="sub-header ">New Platinum Members</p>
					<div aria-hidden="true" class="report-spacer-60"></div>

					<div class="logo-grid">

						<div class="logo-grid__box">
							<img loading="lazy" decoding="async" width="133" height="24" src="
<?php
LF_Utils::get_svg( $report_folder . 'hcltech-logo.svg', true );
?>
" alt="HCLTech Logo" class="logo-grid__image">
						</div>

					</div>

				</div>

			</div>

			<div aria-hidden="true" class="report-spacer-100"></div>
			<a href="https://www.cncf.io/about/join/">
			<?php LF_Utils::display_responsive_images( 99538, 'full', '1200px', '', 'lazy', 'Join as CNCF Member' ); ?>
			</a>

			<div aria-hidden="true" class="report-spacer-60"></div>

		</section>

		<section class="section-08">

			<h2 class="section-header">End User Community</h2>

			<div aria-hidden="true" class="report-spacer-60"></div>

			<div class="quote-with-name-container">
				<p
					class="quote-with-name-container__quote">The essence of this community is more than technology adoption; it's about developing a culture of continuous learning, sharing, and improvement. The passion with which they engage with cloud-native tools and practices is instrumental in pushing the boundaries, setting new industry benchmarks, and driving the CNCF's mission forward. Through active participation, they contribute significantly to a vibrant, collaborative ecosystem that embodies the ethos of the Cloud Native Computing Foundation.</p>
				<div class="quote-with-name-container__marks">
					<p class="quote-with-name-container__name">Taylor Dolezal</p>
					<p class="quote-with-name-container__position">Head of Ecosystem, CNCF</p>
				</div>
			</div>

			<div aria-hidden="true" class="report-spacer-80"></div>
			<?php LF_Utils::display_responsive_images( 99539, 'full', '1200px', '', 'lazy', 'Panelists on stage at a conference' ); ?>
			<div aria-hidden="true" class="report-spacer-60"></div>


			<div class="lf-grid">
				<div class="restrictive-9-col">
					<p>The CNCF End User community is a group of innovative, forward-thinking organizations that constantly push the boundaries of cloud native technology. These organizations use cloud native architectures to power their operations and are not limited to the cloud native service industry. They are different from vendors, consultancies, training partners, or telecommunications companies because their primary goal is to <strong>harness the power of cloud native</strong> architectures to <strong>solve real-world problems</strong> rather than to sell cloud native services externally.</p>
					<p>The people leading these efforts within the end user companies are tech-savvy and cloud native enthusiasts. They face challenges and opportunities presented by cloud native architectures with great enthusiasm and devise self-service solutions that promote inclusivity and an iterative process. This culture of self-service empowers teams, catalyzes innovation, and accelerates the iterative feedback loop, which is essential for agile and resilient operations.</p>
				</div>
			</div>


		</section>

		<section class="section-09 alignfull">

			<div class="container wrap">

				<div aria-hidden="true" class="report-spacer-100"></div>

				<p class="sub-header">END USER TAB</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-09__cto">
					<div class="section-09__cto-col1">
						<p>The creation of the <strong>CNCF End User Technical Advisory Board</strong> (TAB) in 2023 was a significant milestone emphasizing the importance of <strong>collaboration</strong> and putting users at the center of the <strong>CNCF ecosystem</strong>. The End User TAB aims to amplify the voice and insights of the End User community by keeping them at the forefront of CNCF's activities. This approach will enable a responsive and inclusive environment that prioritizes the needs of end users and, in turn, will help to create a dynamic and thriving ecosystem.</p>
						<p><strong>The key responsibilities of the End User TAB include:</strong></p>

						<ul>
							<li>Offering feedback on project usability, reliability, and performance.</li>
							<li>Reviewing and authorizing the publication of reference architectures for cloud native technologies.</li>
							<li>Providing End User input to the Governing Board and Technical Oversight Committee.</li>
							<li>Elevating visibility around end user adoption of CNCF projects.</li>
						</ul>
					</div>
					<div class="section-09__cto-col2">
						<?php
						LF_Utils::display_responsive_images(
							'99540',
							'large',
							'500px',
							'',
							'lazy',
							'Cartoon characters giving thumbs up'
						);
						?>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-80"></div>

			</div>
		</section>

		<section class="section-10">
			<p class="sub-header">ZERO TO MERGE</p>

			<div aria-hidden="true" class="report-spacer-60"></div>

			<div class="lf-grid section-10__cto">
				<div class="section-10__cto-col1">
					<p>In 2023, we launched the groundbreaking <strong>Zero to Merge program</strong>, a four-week course designed to transform end users into effective contributors to CNCF projects. The program exceeded all expectations by attracting more than <strong>850 registrations</strong> from <strong>23 countries</strong>, ultimately accepting <strong>363 participants</strong>. The first meeting alone had <strong>197 attendees</strong>, showcasing the community's eagerness to engage in the cloud native ecosystem.</p>
					<p>The program's success went beyond metrics by creating a tangible impact with participant contributions spanning multiple CNCF projects, creating a ripple effect of positive enhancements. Our next cohort is set to kick off in Spring 2024. Don't miss your chance to transform your cloud native contributions and <strong>apply for the next cohort</strong>.</p>
					<div aria-hidden="true" class="report-spacer-40"></div>

						<div class="lf-grid section-10__groups">
						<div class="section-10__groups-col1">
							<div class="icon-box-3">
								<div class="icon">
									<img loading="lazy" decoding="async" width="80" height="47" src="
	<?php
	LF_Utils::get_svg( $report_folder . 'icon-members-p.svg', true );
	?>
	" alt="Members icon">
								</div>
								<div class="text">
									<span class="number">363</span>
									<span class="description">Participants</span>
								</div>
							</div>
						</div>
						<div class="section-10__groups-col2">
							<div class="icon-box-3">
								<div class="icon">
									<img loading="lazy" decoding="async" width="69" height="69" src="
	<?php
	LF_Utils::get_svg( $report_folder . 'icon-globe-p.svg', true );
	?>
	" alt="Globe icon">
								</div>
								<div class="text">
									<span class="number">23</span>
									<span class="description">Countries</span>
								</div>
							</div>
						</div>
						<div class="section-10__groups-col3">
							<div class="icon-box-3">
								<div class="icon">
									<img loading="lazy" decoding="async" width="56" height="63" src="
	<?php
	LF_Utils::get_svg( $report_folder . 'icon-lanyard-p.svg', true );
	?>
	" alt="Registrations icon">
								</div>
								<div class="text">
									<span class="number">850</span>
									<span class="description">Registrations</span>
								</div>
							</div>
						</div>
					</div>
					<div aria-hidden="true" class="report-spacer-60"></div>

					<div class="wp-block-button"><a href="https://project.linuxfoundation.org/cncf-zero-to-merge-application"
							title="APPLY TO ZERO TO MERGE"
							class="wp-block-button__link fit-content">APPLY TO ZERO TO MERGE</a>
					</div>


				</div>
				<div class="section-10__cto-col2">
					<?php
					LF_Utils::display_responsive_images(
						'99541',
						'large',
						'500px',
						'',
						'lazy',
						'Zero to Merge badge'
					);
					?>
				</div>
			</div>

			<div class="shadow-hr"></div>
			<p class="sub-header">End User Activity</p>

			<div aria-hidden="true" class="report-spacer-60"></div>

			<div class="lf-grid section-10__cto">
				<div class="section-10__cto-col1">

					<div class="lf-grid">
						<p
							class="opening-paragraph restrictive-10-col">Join our End User Community to learn from your peers and add your voice to this influential group. </p>
					</div>
				</div>
				<div class="section-10__cto-col2">
					<div class="wp-block-button"><a href="https://www.cncf.io/enduser/"
								title="Join CNCF"
								class="wp-block-button__link fit-content">Join CNCF</a>
					</div>
					<div aria-hidden="true" class="report-spacer-80"></div>
				</div>
			</div>

			<p class="sub-header">Top 10 CNCF Projects with Highest Contributions from End User Members </p>
			<div aria-hidden="true" class="report-spacer-60"></div>

			<div class="logo-grid smaller">
				<div class="logo-grid__box">
					<div class="logo-grid__image">
						<img loading="lazy" decoding="async" width="160" height="50" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'backstage.svg', true );
						?>
						" alt="Backstage Logo" >
					</div>
					<div class="logo-grid__number">
						4,188
					</div>
				</div>
				<div class="logo-grid__box">
					<div class="logo-grid__image">
						<img loading="lazy" decoding="async" width="160" height="50" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'prometheus.svg', true );
						?>
						" alt="Prometheus Logo" >
					</div>
					<div class="logo-grid__number">
						601
					</div>
				</div>
				<div class="logo-grid__box">
					<div class="logo-grid__image">
						<img loading="lazy" decoding="async" width="160" height="50" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'argo.svg', true );
						?>
						" alt="Argo Logo" >
					</div>
					<div class="logo-grid__number">
						548
					</div>
				</div>
				<div class="logo-grid__box">
					<div class="logo-grid__image">
						<img loading="lazy" decoding="async" width="160" height="50" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'kubernetes.svg', true );
						?>
						" alt="Kubernetes Logo" >
					</div>
					<div class="logo-grid__number">
						137
					</div>
				</div>
				<div class="logo-grid__box">
					<div class="logo-grid__image">
						<img loading="lazy" decoding="async" width="160" height="50" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'telepresence.svg', true );
						?>
						" alt="Telepresence Logo" >
					</div>
					<div class="logo-grid__number">
						127
					</div>
				</div>
				<div class="logo-grid__box">
					<div class="logo-grid__image">
						<img loading="lazy" decoding="async" width="160" height="50" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'buildpacks.svg', true );
						?>
						" alt="buildpacks Logo" >
					</div>
					<div class="logo-grid__number">
						77
					</div>
				</div>
				<div class="logo-grid__box">
					<div class="logo-grid__image">
						<img loading="lazy" decoding="async" width="160" height="50" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'tremor.svg', true );
						?>
						" alt="tremor Logo" >
					</div>
					<div class="logo-grid__number">
						71
					</div>
				</div>
				<div class="logo-grid__box">
					<div class="logo-grid__image">
						<img loading="lazy" decoding="async" width="160" height="50" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'opentelemetry.svg', true );
						?>
						" alt="opentelemetry Logo" >
					</div>
					<div class="logo-grid__number">
						70
					</div>
				</div>
				<div class="logo-grid__box">
					<div class="logo-grid__image">
						<img loading="lazy" decoding="async" width="160" height="50" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'envoy.svg', true );
						?>
						" alt="envoy Logo" >
					</div>
					<div class="logo-grid__number">
						48
					</div>
				</div>
				<div class="logo-grid__box">
					<div class="logo-grid__image">
						<img loading="lazy" decoding="async" width="160" height="50" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'openfeature.svg', true );
						?>
						" alt="openfeature Logo" >
					</div>
					<div class="logo-grid__number">
						36
					</div>
				</div>
								
			</div>

			<div aria-hidden="true" class="report-spacer-80"></div>

			<p class="sub-header">Top 10 Highest-Contributing CNCF End User Members </p>
			<div aria-hidden="true" class="report-spacer-60"></div>

			<div class="logo-grid smaller">
				<div class="logo-grid__box">
					<div class="logo-grid__image">
						<img loading="lazy" decoding="async" width="160" height="50" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'spotify.svg', true );
						?>
						" alt="Spotify Logo" >
					</div>
					<div class="logo-grid__number green">
						4,125
					</div>
				</div>
				<div class="logo-grid__box">
					<div class="logo-grid__image">
						<img loading="lazy" decoding="async" width="160" height="50" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'bloomberg.svg', true );
						?>
						" alt="Bloomberg Logo" >
					</div>
					<div class="logo-grid__number green">
						534
					</div>
				</div>
				<div class="logo-grid__box">
					<div class="logo-grid__image">
						<img loading="lazy" decoding="async" width="160" height="50" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'reddit.svg', true );
						?>
						" alt="Reddit Logo" >
					</div>
					<div class="logo-grid__number green">
						372
					</div>
				</div>
				<div class="logo-grid__box">
					<div class="logo-grid__image">
						<img loading="lazy" decoding="async" width="160" height="50" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'intuit.svg', true );
						?>
						" alt="Intuit Logo" >
					</div>
					<div class="logo-grid__number green">
						241
					</div>
				</div>
				<div class="logo-grid__box">
					<div class="logo-grid__image">
						<img loading="lazy" decoding="async" width="160" height="50" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'workday.svg', true );
						?>
						" alt="Workday Logo" >
					</div>
					<div class="logo-grid__number green">
						136
					</div>
				</div>
				<div class="logo-grid__box">
					<div class="logo-grid__image">
						<img loading="lazy" decoding="async" width="160" height="50" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'thought-machine.svg', true );
						?>
						" alt="Thought Machine Logo" >
					</div>
					<div class="logo-grid__number green">
						129
					</div>
				</div>
				<div class="logo-grid__box">
					<div class="logo-grid__image">
						<img loading="lazy" decoding="async" width="160" height="50" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'shopify.svg', true );
						?>
						" alt="Shopify Logo" >
					</div>
					<div class="logo-grid__number green">
						107
					</div>
				</div>
				<div class="logo-grid__box">
					<div class="logo-grid__image">
						<img loading="lazy" decoding="async" width="160" height="50" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'wayfair.svg', true );
						?>
						" alt="Wayfair Logo" >
					</div>
					<div class="logo-grid__number green">
						88
					</div>
				</div>
				<div class="logo-grid__box">
					<div class="logo-grid__image">
						<img loading="lazy" decoding="async" width="160" height="50" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'swiss-post.svg', true );
						?>
						" alt="swiss post Logo" >
					</div>
					<div class="logo-grid__number green">
						56
					</div>
				</div>
				<div class="logo-grid__box">
					<div class="logo-grid__image">
						<img loading="lazy" decoding="async" width="160" height="50" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'yahoo.svg', true );
						?>
						" alt="yahoo Logo" >
					</div>
					<div class="logo-grid__number green">
						50
					</div>
				</div>
								
			</div>

			<div class="shadow-hr"></div>
			<p class="sub-header">End User Awards</p>
			<div aria-hidden="true" class="report-spacer-60"></div>
			<div class="lf-grid">
				<p
					class="opening-paragraph restrictive-10-col">We were thrilled to award Mercedes Benz Tech Innovation and Spotify with our Top End User Awards this year in recognition of their notable contributions to the cloud native ecosystem.</p>
			</div>

			<div class="lf-grid section-10__vid">
				<div class="section-10__vid-col1">
				<a href="https://www.youtube.com/watch?v=ZPZSRFUNhMY">
					<?php
					LF_Utils::display_responsive_images(
						'99798',
						'full',
						'600px',
						null,
						'lazy',
						'Mercedes store'
					);
					?>
				</a>
				</div>
				<div class="section-10__vid-col2">
					<p class="sub-header">SPRING 2023 WINNER</p>
					<div aria-hidden="true" class="report-spacer-20"></div>

					<img loading="lazy" decoding="async" width="315" height="80" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'mercedes.svg', true );
						?>
						" alt="Merceds Logo" >
					<div aria-hidden="true" class="report-spacer-20"></div>
					<p>Mercedes Benz Tech Innovation GmbH is consistently one of the top end user companies that contributes to Kubernetes worldwide.</p>
				</div>
			</div>

			<div class="lf-grid section-10__vid tophr">
				<div class="section-10__vid-col1">
				<a href="https://www.cncf.io/reports/spotify-end-user-journey-report/">
					<?php
					LF_Utils::display_responsive_images(
						'99542',
						'full',
						'600px',
						null,
						'lazy',
						'People cheering on a conference stage'
					);
					?>
					</a>
				</div>
				<div class="section-10__vid-col2">
					<p class="sub-header">AUTUMN 2023 WINNER</p>
					<div aria-hidden="true" class="report-spacer-20"></div>
					<img loading="lazy" decoding="async" width="243" height="80" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'spotify.svg', true );
						?>
						" alt="Spotify Logo" >
					<div aria-hidden="true" class="report-spacer-20"></div>
					<p>This is the second time Spotify were recognised for significant and continuous contributions to CNCF projects, with over 23,000 contributions in 2023 alone.</p>
				</div>
			</div>

			<div class="lf-grid section-10__vid tophr">
				<div class="section-10__vid-col1">
				<a href="https://www.youtube.com/watch?v=gkZCnpDrjTQ">
					<?php
					LF_Utils::display_responsive_images(
						'99797',
						'full',
						'600px',
						null,
						'lazy',
						'Intuit workplace'
					);
					?>
				</a>
				</div>
				<div class="section-10__vid-col2">
					<p class="sub-header">AUTUMN 2022 WINNER</p>
					<div aria-hidden="true" class="report-spacer-20"></div>

					<img loading="lazy" decoding="async" width="209" height="60" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'intuit.svg', true );
						?>
						" alt="intuit Logo" >
					<div aria-hidden="true" class="report-spacer-20"></div>
					<p>Intuit were named our Top End User in 2022, but we wanted to take the opportunity to share this fantastic video with you, detailing some of the great open source work going on behind the scenes.</p>
				</div>
			</div>

		</section>

		<section id="events"
			class="section-11 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">Events</h2>
					<div class="section-number">2/6</div>
				</div>

				<div class="lf-grid">
					<p
						class="opening-paragraph restrictive-10-col">As a truly global community, events have always been important to us, providing opportunities to connect face-to-face, learn from peers, and drive the innovation that powers the cloud native ecosystem.</p>
				</div>

				<div class="lf-grid">
					<div class="restrictive-10-col">
						<p>As part of our commitment to the cloud native community, we invested heavily in events throughout 2023, introducing new opportunities for collaboration around security and WASM, and, excitingly for us, hosting KubeCon + CloudNativeCon in China after a three-year hiatus due to the pandemic.</p>
					</div>
				</div>
				<div aria-hidden="true" class="report-spacer-60"></div>

				<?php
					LF_Utils::display_responsive_images(
						'99562',
						'full',
						'1200px',
						null,
						'lazy',
						'Men cheering at a conference'
					);
					?>

				<div class="shadow-hr"></div>

				<h2 class="section-header">Kubernetes <br
						class="show-over-1000">Community Days</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>


				<div class="lf-grid">
					<p
						class="opening-paragraph restrictive-10-col">KCDs are community-organized events that gather adopters and technologists to learn, collaborate, and network, with a goal of furthering the adoption and improvement of Kubernetes and cloud native technologies around the world. In response to the <a href="https://www.cncf.io/kcds/ ">KCD community's</a> evolving needs in different regions, CNCF strengthened the program this year.</p>
				</div>

				<div class="lf-grid section-11__kcd">
					<div class="section-11__kcd-col1">

						<div class="icon-layout">

							<div class="icon-box-1">
								<div class="icon">
									<img loading="lazy" decoding="async" width="57" height="63"
										src="
<?php LF_Utils::get_svg( $report_folder . 'icon-lanyard-p2.svg', true ); ?>
" alt="Lanyard icon">
								</div>
								<div class="text">
									<span>32 KCDs</span><br />
									In-person, virtual and hybrid
									<div class="text-smaller">100% year over year increase
									</div>
								</div>
							</div>
							<div class="icon-box-1">
								<div class="icon">
									<img loading="lazy" decoding="async" width="63" height="63"
										src="
<?php LF_Utils::get_svg( $report_folder . 'icon-globe-p.svg', true ); ?>
" alt="Globe icon">
								</div>
								<div class="text">
									<span>24 Countries</span><br />
									Across the globe
								</div>
							</div>
							<div class="icon-box-1">
								<div class="icon">
									<img loading="lazy" decoding="async" width="63" height="63"
										src="
<?php LF_Utils::get_svg( $report_folder . 'icon-non-male.svg', true ); ?>
" alt="Non-male icon">
								</div>
								<div class="text">
									<span>20% non male</span><br />
									speaker average
								</div>
							</div>
						</div>
					</div>

					<div class="section-11__kcd-col2">

						<div class="icon-layout">

							<div class="icon-box-1">
								<div class="icon">
									<img loading="lazy" decoding="async" width="74" height="41"
										src="
<?php LF_Utils::get_svg( $report_folder . 'icon-members-p.svg', true ); ?>
" alt="Members icon">
								</div>
								<div class="text">
									<span>10,000+ attendees </span>
									<div class="text-smaller">43% year over year increase
									</div>
								</div>
							</div>
							<div class="icon-box-1">
								<div class="icon">
									<img loading="lazy" decoding="async" width="57" height="47"
										src="
<?php LF_Utils::get_svg( $report_folder . 'icon-megaphone-p.svg', true ); ?>
" alt="Globe icon">
								</div>
								<div class="text">
									<span>Presentations</span><br />
									in multiple languages
									<div class="text-smaller">
									(English, Slavic, Chinese, Spanish, Italian, and Indonesian)
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">Kube days</p>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="lf-grid section-10__cto">
					<div class="section-10__cto-col1">
						<p>We’re driven by #TeamCloudNative, so when many of you asked for more regional events that connect cloud native experts and adopters, so you can share ideas, best practices, and strengthen your communities, we took action!</p>
						<p>In late 2022 we launched the KubeDay event series, kicking off with <a href="https://www.cncf.io/reports/kubeday-japan-2022/">KubeDay Japan</a> in Yokohama in December. We followed up in 2023 with:</p>
						<ul>
							<li><strong>June: Tel Aviv, Israel</strong></li>
							<li><strong>December: Bangalore, India</strong></li>
							<li><strong>December: Singapore</strong></li>
						</ul>

					</div>
					<div class="section-10__cto-col2">
						<?php
						LF_Utils::display_responsive_images( 99561, 'large', '500px', null, 'lazy', 'Man speaking on microphone' );
						?>
					</div>
				</div>
			</div>
		</section>

		<section class="section-12 is-style-down-gradient alignfull">

			<div class="container wrap">

				<p class="sub-header">CloudNativeSecurityCon</p>
				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<p
						class="restrictive-9-col">What started as a co-located event alongside KubeCon + CloudNativeCon officially grew into a major industry convention in 2023 – in fact, the first cloud native security event of its kind. The inaugural CloudNativeSecurityCon drew almost 800 experts and practitioners from across the world to share insights and experiences on the unique security challenges faced by cloud native technology. Read the full <a href="https://www.cncf.io/reports/cloudnativesecuritycon-north-america-2023-transparency-report/">transparency report</a> for more details.</p>
				</div>
				<div aria-hidden="true" class="report-spacer-60"></div>

				<picture>
					<source media="(max-width: 499px)"
						srcset="<?php echo esc_url( wp_get_attachment_image_url( '99565', 'full', false ) ); ?>">
					<source media="(min-width: 500px)"
						srcset="<?php echo esc_url( wp_get_attachment_image_url( '99556', 'full', false ) ); ?>">
					<?php
					LF_Utils::display_responsive_images(
						'99556',
						'full',
						'1200px',
						null,
						'lazy',
						'CloudNativeSecurityCon attendee stats.'
					);
					?>
				</picture>

				<div class="shadow-hr"></div>


				<h2 class="section-header">KubeCon + <br
						class="show-over-1000">CloudNativeCon Europe</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<?php
				LF_Utils::display_responsive_images(
					'99563',
					'full',
					'1200px',
					null,
					'lazy',
					'Welcome to KubeCon + CloudNativeCon Europe 2023'
				);
				?>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<p class="sub-header">Attendee Demographics</p>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<picture>
					<source media="(max-width: 599px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'demographics-mobile-1.svg', true );
?>
">
					<source media="(min-width: 600px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'demographics-desktop-1.svg', true );
?>
">
					<img width="1200" height="584" src="
<?php
Lf_Utils::get_svg( $report_folder . 'demographics-desktop-1.svg', true );
?>
" alt="Showing 16,092 Registered attendees of which 42% were men, 6% women, <1% non-binary/other, and 52% preferred not to answer. Of the attendees 65% were in person, 35% were virtual. 51% of visitors were first timers."
						loading="lazy" decoding="async">
				</picture>
				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="lf-grid section-12__stats">
					<div class="section-12__stats-col1">
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" decoding="async" width="62" height="62" src="
<?php
LF_Utils::get_svg( $report_folder . 'icon-download-pink.svg', true );
?>
" alt="Download icon">
							</div>
							<div class="text">
								<span class="number" style="color: #FF1E15;" >1,767</span><br />
								<span class="description">CFP Submissions</span>
							</div>
						</div>

					</div>
					<div class="section-12__stats-col2">
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" decoding="async" width="82" height="67" src="
<?php
LF_Utils::get_svg( $report_folder . 'icon-megaphone-pink.svg', true );
?>
" alt="Megaphone icon">
							</div>
							<div class="text">
								<span class="number" style="color: #FF1E15;">556</span><br />
								<span class="description">Speakers</span>
							</div>
						</div>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<div class="lf-grid section-12__report">
					<div class="section-12__report-col1">

						<p class="sub-header">Have a look at the full details in our
transparency report</p>

						<div aria-hidden="true" class="report-spacer-40"></div>

						<div class="wp-block-button"><a href="https://www.cncf.io/reports/kubecon-cloudnativecon-europe-2023/"
								title="Read the KubeCon + CloudNativeCon Europe 2023 Transparency Report"
								class="wp-block-button__link fit-content">View
								Report</a>
						</div>

					</div>
					<div class="section-12__report-col2">
						<a href="https://www.cncf.io/reports/kubecon-cloudnativecon-europe-2023/">
							<?php
							LF_Utils::display_responsive_images( 90445, 'large', '500px', 'ds', 'lazy', 'Cover of the KubeCon + CloudNativeCon Europe 2023 Transparency Report' );
							?>
						</a>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">Video Highlights</p>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="wp-block-lf-youtube-lite">
					<lite-youtube videoid="tBDK_AYGv-k"
						videotitle="Highlights from KubeCon + CloudNativeCon Europe 2023"
						webpStatus="1" sdthumbStatus="0"
						title="Play Highlights">
					</lite-youtube>
				</div>

			</div>
		</section>

		<?php // Repeat this section as same layout as EU. ?>
		<section class="section-12 is-style-down-gradient alignfull">

			<div class="container wrap">

			<h2 class="section-header">KubeCon + CloudNativeCon <br
						class="show-over-1000">North America</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<?php
				LF_Utils::display_responsive_images(
					'99564',
					'full',
					'1200px',
					null,
					'lazy',
					'Welcome to KubeCon + CloudNativeCon North America 2023'
				);
				?>
				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<p
						class="restrictive-9-col">KubeCon + CloudNativeCon North America marked the first time we’d gathered in such big numbers in the Midwest, and Detroit was a wonderful host city. We launched a number of new initiatives, including <strong>Security Slam</strong>, in partnership with <strong>Sonatype</strong>. There were also some special surprises at KubeCon + CloudNativeCon, including welcoming our Senior Developer Advocate Ihor Dvoretskyi back in-person, who was granted short-term leave from serving in the Ukraine military.</p>
				</div>


				<div aria-hidden="true" class="report-spacer-100"></div>

				<p class="sub-header">Attendee Demographics</p>

				<picture>
					<source media="(max-width: 599px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'demographics-mobile2.svg', true );
?>
">
					<source media="(min-width: 600px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'demographics-desktop2.svg', true );
?>
">
					<img width="1200" height="584" src="
<?php
Lf_Utils::get_svg( $report_folder . 'demographics-desktop2.svg', true );
?>
" alt="Showing 13,666 Registered attendees of which 40% were men, 8% women, <1% non-binary/other, and 52% preferred not to answer. Of the attendees 66% were in person, 34% were virtual. 54% of visitors were first timers."
						loading="lazy" decoding="async">
				</picture>
				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="lf-grid section-12__stats">
					<div class="section-12__stats-col1">
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" decoding="async" width="62" height="62" src="
<?php
LF_Utils::get_svg( $report_folder . 'icon-download-yellow.svg', true );
?>
" alt="Download icon">
							</div>
							<div class="text">
								<span class="number" style="color: #C93566;" >1,871</span><br />
								<span class="description">CFP Submissions</span>
							</div>
						</div>

					</div>
					<div class="section-12__stats-col2">
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" decoding="async" width="82" height="67" src="
<?php
LF_Utils::get_svg( $report_folder . 'icon-megaphone-yellow.svg', true );
?>
" alt="Megaphone icon">
							</div>
							<div class="text">
								<span class="number" style="color: #C93566;">554</span><br />
								<span class="description">Speakers</span>
							</div>
						</div>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<div class="lf-grid section-12__report">
					<div class="section-12__report-col1">

						<p class="sub-header">Have a look at the full details in our
transparency report</p>

						<div aria-hidden="true" class="report-spacer-40"></div>

						<div class="wp-block-button"><a href="https://www.cncf.io/reports/kubecon-cloudnativecon-north-america-2023/"
								title="Read the KubeCon + CloudNativeCon North America 2023 Transparency Report"
								class="wp-block-button__link fit-content">View
								Report</a>
						</div>

					</div>
					<div class="section-12__report-col2">
						<a href="https://www.cncf.io/reports/kubecon-cloudnativecon-north-america-2023/">
							<?php
							LF_Utils::display_responsive_images( 98880, 'large', '500px', 'ds', 'lazy', 'Cover of the KubeCon + CloudNativeCon North America 2023 Transparency Report' );
							?>
						</a>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">Video Highlights</p>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="wp-block-lf-youtube-lite">
					<lite-youtube videoid="SvgfGo-33G4"
						videotitle="Highlights from KubeCon + CloudNativeCon North America 2023"
						webpStatus="1" sdthumbStatus="0"
						title="Play Highlights">
					</lite-youtube>
				</div>

			</div>
		</section>

		<section id="training"
			class="section-14 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">Training & <br
							class="show-over-1000">Certification</h2>
					<div class="section-number">3/6</div>
				</div>

				<div class="lf-grid">
					<p
						class="opening-paragraph restrictive-10-col">Education has always been one of the pillars of the CNCF. To ensure we are meeting the needs of our community, this year we conducted a microsurvey to outline the challenges and difficulties related to training and certifications.</p>
				</div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p><strong>The benefits of achieving new training and certifications were clear:</strong></p>
					</div>
				</div>
				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="lf-grid section-14__courses">
					<div class="course-box">
						<span class="course-box__number2">~ 55%</span>
						<p class="course-box__description">reported pursuing training and certifications helped them land a new job</p>
					</div>
					<div class="course-box">
						<span class="course-box__number2">67%</span>
						<p class="course-box__description">say it left them feeling more engaged and fulfilled in the their work</p>
					</div>
					<div class="course-box">
						<span class="course-box__number2">36%</span>
						<p class="course-box__description">received higher pay as a result of completing a new training or certification</p>
					</div>
				</div>
				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>To better serve our community, CNCF launched <strong>seven</strong> new trainings in 2023. The number of certifications has also been dramatically improved, adding <strong>five</strong> new certifications in 2023.</p>
					</div>
				</div>
				<div aria-hidden="true" class="report-spacer-60"></div>
				<p class="sub-header">NUMBERS OF CNCF CERTIFICATIONS AVAILABLE</p>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<picture>
					<source media="(max-width: 599px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'certifications-mobile.svg', true );
?>
">
					<source media="(min-width: 600px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'certifications-desktop.svg', true );
?>
">
					<img width="1200" height="445" src="
<?php
Lf_Utils::get_svg( $report_folder . 'certifications-desktop.svg', true );
?>
" alt="Shows growing number of certifications each year."
						loading="lazy" decoding="async">
				</picture>
				<div class="shadow-hr"></div>

				<h2 class="section-header">2023 Training <br
						class="show-over-1000">Courses</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-14__intro">
					<div class="section-14__intro-col1">
						<p>The evolution can also be seen within the participation numbers of training and certs</p>
					</div>
					<div class="section-14__intro-col2">
						<img width="582" height="124" loading="lazy" decoding="async" src="
<?php
Lf_Utils::get_svg( $report_folder . 'training-logos.svg', true );
?>
" alt="Cloud native training courses from LF">

					</div>

				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="lf-grid section-14__courses">

					<div class="course-box">
						<span class="course-box__number">13%</span>
						<span class="course-box__text">Increase</span>
						<div class="thin-hr course-box__hr"></div>
						<p
							class="course-box__description">Kubernetes Massively Open Online Course (MOOC) hit <a href="https://www.cncf.io/certification/training/">345,00 enrollments</a></p>
					</div>

					<div class="course-box">
						<span class="course-box__number">33%</span>
						<span class="course-box__text">Increase</span>
						<div class="thin-hr course-box__hr"></div>
						<p
							class="course-box__description">Certified Kubernetes Administrator (CKA) exam hit <a href="https://www.cncf.io/certification/expert/">176,000 enrollments</a></p>
					</div>

					<div class="course-box">
						<span class="course-box__number">31%</span>
						<span class="course-box__text">Increase</span>
						<div class="thin-hr course-box__hr"></div>
						<p
							class="course-box__description">Certified Kubernetes Application Developer (CKAD) hit <a href="https://www.cncf.io/certification/ckad/">79,000 exam registrations</a></p>
					</div>

					<div class="course-box">
						<span class="course-box__number">38%</span>
						<span class="course-box__text">Increase</span>
						<div class="thin-hr course-box__hr"></div>
						<p
							class="course-box__description">Certified Kubernetes Security Specialist (CKS) exam hit <a href="https://www.cncf.io/certification/cks/">36,000 registrations</a></p>
					</div>
					<div class="course-box">
						<span class="course-box__number">43%</span>
						<span class="course-box__text">Increase</span>
						<div class="thin-hr course-box__hr"></div>
						<p
							class="course-box__description">Kubernetes and Cloud Native Associate (KCNA) exam <a href="https://www.cncf.io/certification/kcna/">hit 8,800 registrations</a> (since its launch in November 2021)</p>
					</div>
					<div class="course-box">
						<span class="course-box__number">1,500+</span>
						<span class="course-box__text">Registrations</span>
						<div class="thin-hr course-box__hr"></div>
						<p
							class="course-box__description">Prometheus Certified Associate (PCA) exam hit <a href="https://www.cncf.io/certification/pca/">1500+ registrations</a> (since its launch on September, 2022)</p>
					</div>
					<div class="course-box">
						<span class="course-box__number">60+</span>
						<span class="course-box__text">Registrations</span>
						<div class="thin-hr course-box__hr"></div>
						<p
							class="course-box__description">Istio Certified Associate (ICA) exam hit 1500+ registrations (since its launch on September, 2023)</p>
					</div>
				</div>
			</div>
		</section>

		<section id="projects"
			class="section-15 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">Project Updates & <br
							class="show-over-1000">Satisfaction</h2>
					<div class="section-number">4/6</div>
				</div>

				<div class="lf-grid">
					<p
						class="opening-paragraph restrictive-10-col">Throughout 2023, CNCF underscored our commitment to making cloud native ubiquitous - hosting <a href="https://www.cncf.io/projects/">24 graduated projects</a>, <a href="https://www.cncf.io/projects/">36 incubating</a> and <a href="https://www.cncf.io/sandbox-projects/">109 sandbox projects</a>.</p>
				</div>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<?php echo do_shortcode( '[projects-maturity-chart]' ); ?>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<p class="sub-header">New Projects</p>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="lf-grid section-15__projects">
					<div class="section-15__projects-col1">

						<p>In 2023, the <a href="/people/technical-oversight-committee/">Technical Oversight Committee</a> (TOC) accepted <strong>17 new projects</strong></p>

					</div>
					<div class="section-15__projects-col2">
						<div class="icon-box-4">
							<div class="icon">
								<img loading="lazy" decoding="async" width="71" height="74" src="
	<?php LF_Utils::get_svg( $report_folder . 'icon-projects.svg', true ); ?>
	" alt="Projects icon">
							</div>
							<div class="text">
								<span>2</span><br />
								Incubating
							</div>
						</div>
					</div>
					<div class="section-15__projects-col3">
						<div class="icon-box-4">
							<div class="icon">
								<img loading="lazy" decoding="async" width="61" height="62" src="
	<?php LF_Utils::get_svg( $report_folder . 'icon-chapters-g.svg', true ); ?>
	" alt="Sandbox icon">
							</div>
							<div class="text">
								<span>15</span><br />
								Sandbox
							</div>
						</div>

					</div>
				</div>

			</div>
	</section>
	<section class="section-15 is-style-down-gradient alignfull">

			<div class="container wrap">

				<h2 class="section-header">Project Moves</h2>
				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>Projects increase their maturity level by demonstrating to the <a href="https://www.cncf.io/people/technical-oversight-committee/">TOC</a> that they have attained end user and vendor adoption, established a healthy rate of code commits and codebase changes, and attracted committers from multiple organizations. In 2023, four projects graduated, and five moved to the incubating level.</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<p class="sub-header">Graduations</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="logo-grid smaller">
					<div class="logo-grid__box">
						<img loading="lazy" decoding="async" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'logo-project-cilium.svg', true );
						?>
						" alt="Cilium Logo" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" decoding="async" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'logo-project-cri-o.svg', true );
						?>
						" alt="cri-o Logo" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" decoding="async" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'logo-project-istio.svg', true );
						?>
						" alt="Istio Logo" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" decoding="async" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'logo-project-keda.svg', true );
						?>
						" alt="Keda Logo" class="logo-grid__image">
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<p class="sub-header">CNCF Project Velocity</p>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="lf-grid">
					<p
						class="restrictive-10-col">Consistently looking into <a href="https://www.cncf.io/blog/2023/10/27/october-2023-where-we-are-with-velocity-of-cncf-lf-and-top-30-open-source-projects/">CNCF project’s velocity and the top open source projects</a> give us a very good indication of trends that are resonating with developers and end users. As a result, we can get insight into platforms that will likely be successful. This graph shows the 30 projects that experienced the most significant growth in 2023:</p>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="lf-grid legend-grid">

					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #4065C5"></div>
						<span><strong>Kubernetes</strong><br>Authors 3662</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #CB4727">
						</div><span><strong>OpenTelemetry</strong><br>Authors
						1419</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #F19E38">
						</div><span><strong>Argo</strong><br>Authors
						927</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #449431">
						</div><span><strong>Backstage</strong><br>Authors
						641</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #8C1A94">
						</div><span><strong>Prometheus</strong><br>Authors 457</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #4397C2">
						</div><span><strong>Cilium</strong><br>Authors 440</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #CC5077">
						</div><span><strong>gRPC</strong><br>Authors
						439</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #76A832">
						</div><span><strong>Istio</strong><br>Authors 399</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #A93A35">
						</div><span><strong>Envoy</strong><br>Authors
						396</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #3E6291">
						</div><span><strong>Meshery</strong><br>Authors 325</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #8E4995">
						</div><span><strong>Keycloak</strong><br>Authors
						311</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #52A799">
						</div><span><strong>Dapr</strong><br>Authors
						296</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #AAAA39">
						</div><span><strong>containerd</strong><br>Authors
						295</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #5F36C4">
						</div><span><strong>Fluentd</strong><br>Authors 274</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #D7792D">
						</div><span><strong>NATS</strong><br>Authors
						261</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #7F1A13">
						</div><span><strong>Fluid</strong><br>Authors
						252</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #5C1863">
						</div><span><strong>Crossplane</strong><br>Authors 251</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #4F9066">
						</div><span><strong>OPA</strong><br>Authors 228</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #5B73A2">
						</div><span><strong>Knative</strong><br>Authors 210</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #3C3EA6">
						</div><span><strong>KubeVirt</strong><br>Authors 208</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #AD7635">
						</div><span><strong>Kubeflow</strong><br>Authors 199</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #63D346">
						</div><span><strong>KEDA</strong><br>Authors
						193</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #AA2980">
						</div><span><strong>Falco</strong><br>Authors
						190</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #E1489B">
						</div><span><strong>Flux</strong><br>Authors
						188</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #935C3C">
						</div><span><strong>OpenCost</strong><br>Authors
						185</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #AEC341">
						</div><span><strong>Kyverno</strong><br>Authors
						183</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #40758A">
						</div><span><strong>Helm</strong><br>Authors
						182</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #6E8C32">
						</div><span><strong>etcd</strong><br>Authors
						171</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #BAA539">
						</div><span><strong>TiKV</strong><br>Authors
						168</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #285829">
						</div><span><strong>Harbor</strong><br>Authors
						152</span>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<picture>
					<source media="(max-width: 599px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'project-chart-mobile.svg', true );
?>
">
					<source media="(min-width: 600px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'project-chart-desktop.svg', true );
?>
">
					<img width="1200" height="445" src="
<?php
Lf_Utils::get_svg( $report_folder . 'project-chart-desktop.svg', true );
?>
" alt="CNCF Project Velocity chart"
						loading="lazy" decoding="async">
				</picture>

				<div class="shadow-hr"></div>

				<p class="sub-header">Project Velocity Key Takeaways</p>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="lf-grid">
					<ul class="restrictive-10-col" style="margin-bottom: 0;">
						<li><strong>Kubernetes</strong> continues to mature with the largest contributor base.</li>
						<li><strong>OpenTelemetry</strong> continues to grow its contributor base and remains the second highest velocity project in the CNCF ecosystem.</li>
						<li><strong>Backstage</strong> continues to grow, solving an important pain point around cloud native developer experience.</li>
						<li><strong>GitOps</strong> continues to be important in the cloud native ecosystem, where projects like <strong>Argo</strong> and <strong>Flux</strong> continue to cultivate large communities.</li>
						<li>The importance of cost management in tight economic times has resulted in <strong>OpenCost</strong> appearing in the top 30 CNCF project list for the first time. I expect to see OpenCost continue to grow along with the rise of the <strong>FinOps</strong> movement worldwide.</li>
						<li>As <strong>Kubernetes</strong> matures, many organizations turn to service mesh technology and those projects in CNCF like Envoy, Cilium, and Istio continue to cultivate large contributor communities to meet the demand. <strong>Cilium</strong> recently graduated inside of CNCF and moved up a couple spots in the top 30 CNCF project list.</li>
						<li>In many cases, CNCF projects <a href="https://www.cncf.io/case-studies/openai/">underpin large scale AI infrastructure</a> and we have <strong>Kubeflow</strong> appearing on the top 30 CNCF project list for the first time.</li>
					</ul>
				</div>

				<div class="section-01__author">
					<?php LF_Utils::display_responsive_images( 82110, 'full', '75px', null, 'lazy', 'Chris Aniszczyk' ); ?>
					<p><strong>Chris Aniszczyk</strong><br>
CTO, CNCF</p>
				</div>
			</div>
		</section>

		<section class="section-16 is-style-down-gradient alignfull">

			<div class="container wrap">

				<h2 class="section-header">Security</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>CNCF conducted a number of <a href="https://www.cncf.io/blog/2022/08/08/improving-cncf-security-posture-with-independent-security-audits/">open source security audits</a> throughout 2023, in strategic partnership with the <strong>Open Source Technology Improvement Fund (OSTIF)</strong>.</p>
						<p>The following CNCF projects have completed security audits or associated work:</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-80"></div>
				
				<p class="sub-header">Fuzzing Audits</p>
				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="logo-grid smaller">
					<div class="logo-grid__box">
						<img loading="lazy" decoding="async" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'kyverno.svg', true );
						?>
						" alt="kyverno Logo" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" decoding="async" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'dapr.svg', true );
						?>
						" alt="dapr Logo" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" decoding="async" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'knative.svg', true );
						?>
						" alt="knative Logo" class="logo-grid__image">
					</div>
				</div>
				<div aria-hidden="true" class="report-spacer-60"></div>
				<p class="sub-header">Security Audits</p>
				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="logo-grid smaller">
					<div class="logo-grid__box">
						<img loading="lazy" decoding="async" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'crossplane.svg', true );
						?>
						" alt="crossplane Logo" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" decoding="async" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'dapr.svg', true );
						?>
						" alt="dapr Logo" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" decoding="async" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'dragonfly.svg', true );
						?>
						" alt="dragonfly Logo" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" decoding="async" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'kubernetes-stacked.svg', true );
						?>
						" alt="Kubernetes Logo" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" decoding="async" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'notary.svg', true );
						?>
						" alt="notary Logo" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" decoding="async" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'vitess.svg', true );
						?>
						" alt="vitess Logo" class="logo-grid__image">
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="quote-with-name-container">
				<p
					class="quote-with-name-container__quote">If we truly are moving to standardize cloud-native technologies, to lock them down and further secure them and to build an increasingly comprehensive set of standards and protocols, then we can feasibly also now turn our attention towards being more sustainable in our software application development and more sustainable in terms of how much of the planet's resources that software uses.</p>
				<div class="quote-with-name-container__marks">
					<p class="quote-with-name-container__name">Adrian Bridgwater</p>
					<p class="quote-with-name-container__position">Forbes</p>
				</div>
				</div>
			</div>
		</section>

		<section class="section-17 is-style-down-gradient alignfull">

			<div class="container wrap">

				<h2 class="section-header">Phippy & Friends</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>From a humble PHP app, Phippy has gone on to help thousands of folx take their first steps to understanding cloud native computing - from containerisation to automation. Today, Phippy and Friends’ mission is to demystify cloud native computing and explain complicated concepts in a compelling, engaging and easy-to-understand manner.</p>
					</div>
				</div>
				<div aria-hidden="true" class="report-spacer-100"></div>

				<p
					class="sub-header">In 2023, two projects donated characters</p>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<div class="lf-grid section-17__characters">
					<?php
						LF_Utils::display_responsive_images( 99594, 'full', '1100px', null, 'lazy', 'New Phippy characters, Obee the Cilium Bee and Tai the TUF elephant' );
					?>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<p class="sub-header">NEW PHIPPY BOOK</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-10__cto">
					<div class="section-10__cto-col1">
						<p>We were also thrilled to see Phippy dive into new adventures in WASM in <strong>Phippy's Field Guide to Wasm</strong> Thanks to our friends at <strong>Fermyon!</strong></p>
					</div>
					<div class="section-10__cto-col2">
						<div class="wp-block-button"><a href="https://drive.google.com/file/d/1M465JPam7rdi5uf5_WOaatayU5RRJ9hm/view"
						title="Read now"
						class="wp-block-button__link fit-content">Read now</a>
						</div>
						<div aria-hidden="true" class="report-spacer-40"></div>

					</div>
				</div>
						
				<a href="https://drive.google.com/file/d/1M465JPam7rdi5uf5_WOaatayU5RRJ9hm/view"
						title="Read now"
						><?php
						LF_Utils::display_responsive_images( 99595, 'full', '1100px', null, 'lazy', 'Phippys Field Guide to Wasm book cover' );
				?>
				</a>

				<div class="shadow-hr"></div>

				<p class="sub-header">Join The Phippy & Friends Family!</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="section-17__banner">
					<div class="section-17__banner-wrapper">
						<div class="lf-grid section-10__cto">
							<div class="section-10__cto-col1">
								<h2 class="section-17__banner-title">Are you a
									maintainer on
									a
									graduated project?</h2>
								<p class="section-17__banner-text">Do you want to help others better understand the concepts of cloud native computing? Donate a character to the Phippy and Friends family.</p>

								<div aria-hidden="true" class="report-spacer-40"></div>

								<div class="wp-block-button"><a href="https://github.com/cncf/foundation/blob/master/phippy-guidelines.md"
								title="Donate a character"
								class="wp-block-button__link fit-content">Donate a
								character</a>
								</div>
							</div>
							<div class="section-10__cto-col2">
								<?php
								LF_Utils::display_responsive_images( 99596, 'large', '500px', null, 'lazy', 'Confused Goldie character' );
								?>
							</div>
						</div>
					</div>
				</div>
				<div aria-hidden="true" class="report-spacer-40"></div>

			</div>
		</section>
		<section id="community"
			class="section-19 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">Community & Diversity <br
							class="show-over-1000">Engagement</h2>
					<div class="section-number">5/6</div>
				</div>

				<div class="lf-grid">
					<p
						class="opening-paragraph restrictive-10-col">The CNCF community spans the world, across our contributors, members, meetups, and ambassadors.</p>
				</div>

				<div class="lf-grid">
					<p
						class="restrictive-9-col">We doubled down on our commitment to #TeamCloudNative in 2023, investing in community-driven initiatives to fuel sustained momentum, expansion, growth and adoption. Importantly, we continued to sharpen focus on our DEI initiatives, ensuring that the ecosystem is a welcoming place where everybody can thrive.</p>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<?php
					LF_Utils::display_responsive_images( 99611, 'full', '1200px', null, 'lazy', 'Diversity group on stage cheering at Kubecon NA' );
				?>
				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="lf-grid section-12__report">
					<div class="section-12__report-col1">

						<p class="sub-header">Deaf & HOH Working Group</p>

						<div aria-hidden="true" class="report-spacer-40"></div>

						<p>This year saw the launch of the <a href="https://contribute.cncf.io/about/deaf-and-hard-of-hearing/">CNCF Deaf and Hard of Hearing</a> (deaf/hoh) working group, which aims to empower and include individuals who are deaf or hard of hearing in the cloud native and open source communities. The group’s mission is to create a <strong>supportive</strong> and <strong>inclusive environment</strong> within the cloud native and open source community.</p>

					</div>
					<div class="section-12__report-col2">
						<?php
						LF_Utils::display_responsive_images( 99610, 'full', '600px', null, 'lazy', 'Laptop with CNBC article showing on it' );
						?>
					</div>
				</div>

				<div class="shadow-hr"></div>


				<p class="sub-header">DEI</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>CNCF continues to support the development of this incredible cloud native community while also striving to ensure that everyone who participates feels welcome regardless of gender, gender identity, sexual orientation, disability, race, ethnicity, age, religion, or economic status. To date, we’ve offered more than <strong>6,000 diversity</strong> and need-based scholarships, through the <strong>Dan Kohn Scholarship Fund</strong>.</p>
						<p>In 2023 we supported <strong>744 speakers</strong> and scholarship recipients with travel funding to attend CNCF events. The travel fund recipients are from traditionally underrepresented or marginalized groups; as well as active community members who would not otherwise have been able to attend due to financial reasons. Additionally, we offered 1,080 complimentary registration passes to those in need.</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<p
					class="sub-header">Scholarships were funded by sponsorships from</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="logo-grid smallest">

					<div class="logo-grid__box">
						<img loading="lazy" decoding="async" src="
						<?php
							LF_Utils::get_svg( $report_folder . 'logo-adevinta.svg', true );
						?>
							" alt="Logo for Adevinta" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" decoding="async" src="
						<?php
							LF_Utils::get_svg( $report_folder . 'logo-apple.svg', true );
						?>
							" alt="Logo for Apple" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" decoding="async" src="
						<?php
							LF_Utils::get_svg( $report_folder . 'logo-cncf.svg', true );
						?>
							" alt="Logo for CNCF" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" decoding="async" src="
						<?php
							LF_Utils::get_svg( $report_folder . 'logo-form3.svg', true );
						?>
							" alt="Logo for Form 3" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" decoding="async" src="
						<?php
							LF_Utils::get_svg( $report_folder . 'logo-google.svg', true );
						?>
							" alt="Logo for Google" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" decoding="async" src="
						<?php
							LF_Utils::get_svg( $report_folder . 'logo-honeycomb.svg', true );
						?>
							" alt="Logo for Honeycomb" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" decoding="async" src="
						<?php
							LF_Utils::get_svg( $report_folder . 'logo-isovalent.svg', true );
						?>
							" alt="Logo for Isovalent" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" decoding="async" src="
						<?php
							LF_Utils::get_svg( $report_folder . 'logo-orcasio.svg', true );
						?>
							" alt="Logo for Orcasio" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" decoding="async" src="
						<?php
							LF_Utils::get_svg( $report_folder . 'logo-strongdm.svg', true );
						?>
							" alt="Logo for Strong DM" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" decoding="async" src="
						<?php
							LF_Utils::get_svg( $report_folder . 'logo-tailscale.svg', true );
						?>
							" alt="Logo for Tailscale" class="logo-grid__image">
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">Humans of Cloud Native</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<p
						class="opening-paragraph restrictive-10-col">At the heart of CNCF is our welcoming community of doers, working together to make cloud native ubiquitous. This year we were privileged to publish <a href="https://www.cncf.io/humans-of-cloud-native/">12 Humans of Cloud Native features</a>, telling the stories of amazing individuals and their contributions that make team cloud native such a vibrant, exciting and diverse space. We also held the first Humans of Cloud Native Panel at KubeCon + CloudNativeCon North America, moderated by Bart Farrel. </p>
				</div>
				<a href="https://www.cncf.io/humans-of-cloud-native/">
				<picture>
					<source media="(max-width: 499px)" srcset="
					<?php
					Lf_Utils::get_image( $report_folder . 'hocn-mobile.jpg' );
					?>
					">
										<source media="(min-width: 500px)" srcset="
					<?php
					Lf_Utils::get_image( $report_folder . 'hocn-desktop.jpg' );
					?>
					">
										<img width="1200" height="200" src="
					<?php
					Lf_Utils::get_image( $report_folder . 'hocn-desktop.jpg' );
					?>
					" alt="Collage of multiple HOCN" loading="lazy" decoding="async">
				</picture>
				</a>
				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p><strong>Do you know somebody doing incredible things in the cloud native ecosystem?</strong>
						<br/>Nominate them for the Humans of Cloud Native.</p>
					</div>
				</div>
				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="wp-block-button"><a href="mailto:humans@cncf.io"
								title="Nominate"
								class="wp-block-button__link fit-content">Nominate</a>
								</div>

			</div>
		</section>
		<section
			class="section-19 is-style-down-gradient alignfull">

				<div class="container wrap">

				<h2 class="section-header">Community Awards</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>Now in their sixth year, the <a href="https://www.cncf.io/announcements/2023/11/08/cloud-native-computing-foundation-announces-2023-community-awards-winners/">CNCF Community Awards</a> highlighted the most active ambassador and top contributor across all CNCF projects. The awards included:</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="lf-grid section-19__ca">
					<div class="section-19__ca-col1">
						<img loading="lazy" decoding="async" width="64" height="66" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'icon-first-place.svg', true );
						?>
						" alt="First place icon">

						<div aria-hidden="true" class="report-spacer-40"></div>

						<p class="sub-header">Top cloud Native Committer</p>

						<div aria-hidden="true" class="report-spacer-20"></div>

						<p>An individual with incredible technical skills and notable technical achievements in one or multiple CNCF projects</p>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<div class="section-19__person">
							<?php LF_Utils::display_responsive_images( 99807, 'full', '175px', 'section-19__person-image', 'lazy', 'Akihiro Suda' ); ?>
							<p class="section-19__person-text-wrapper">
							<span class="section-19__person-name">Akihiro Suda</span>
							<span
							class="section-19__person-title"><a href="https://www.twitter.com/_AkihiroSuda_">@_AkihiroSuda_</a></span></p>
						</div>

					</div>
					<div class="section-19__ca-col2">
						<img loading="lazy" decoding="async" width="54" height="64" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'icon-doc-check.svg', true );
						?>
						" alt="Document with check icon">

						<div aria-hidden="true" class="report-spacer-40"></div>

						<p class="sub-header">Top Documentarian</p>

						<div aria-hidden="true" class="report-spacer-20"></div>

						<p>This award recognizes excellence in documentation contributions to CNCF and its projects</p>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<div class="section-19__person-align">

							<div class="section-19__person">
								<?php LF_Utils::display_responsive_images( 99803, 'full', '175px', 'section-19__person-image', 'lazy', 'Divya Mohan' ); ?>
								<p class="section-19__person-text-wrapper">
							<span class="section-19__person-name">Divya Mohan</span>
							<span
							class="section-19__person-title"><a href="https://twitter.com/divya_mohan02">@divya_mohan02</a></span></p>
							</div>

						</div>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<img loading="lazy" decoding="async" width="73" height="73" src="
<?php
LF_Utils::get_svg( $report_folder . 'icon-chop.svg', true );
?>
" alt="Axe icon">

						<div aria-hidden="true" class="report-spacer-40"></div>

						<p class="sub-header">Chop Wood & Carry Water awards</p>
						<div aria-hidden="true" class="report-spacer-20"></div>

						<p>To recognize contributors who spend countless hours completing often mundane tasks, CNCF created the <strong>"Chop Wood and Carry Water"</strong> awards. CNCF was proud to acknowledge the amazing efforts of five individuals for their outstanding contributions in 2023:</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="section-19__person-align">

					<div class="section-19__person">
						<?php LF_Utils::display_responsive_images( 99802, 'full', '175px', 'section-19__person-image', 'lazy', 'Kaslin Fields' ); ?>
						<p class="section-19__person-text-wrapper">
							<span class="section-19__person-name">Kaslin Fields</span>
							<span
							class="section-19__person-title"><a href="https://www.twitter.com/kaslinfields">@kaslinfields</a></span></p>
					</div>

					<div class="section-19__person">
						<?php LF_Utils::display_responsive_images( 99805, 'full', '175px', 'section-19__person-image', 'lazy', 'Fassela k' ); ?>
						<p class="section-19__person-text-wrapper">
							<span class="section-19__person-name">Fassela k</span>
							<span
							class="section-19__person-title"><a href="https://www.twitter.com/FaseelaDilshan">@FaseelaDilshan</a></span></p>
					</div>

					<div class="section-19__person">
						<?php LF_Utils::display_responsive_images( 99806, 'full', '175px', 'section-19__person-image', 'lazy', 'Arnaud Meukam' ); ?>
						<p class="section-19__person-text-wrapper">
							<span class="section-19__person-name">Arnaud Meukam</span>
							<span
							class="section-19__person-title"><a href="https://www.twitter.com/ameukam">@ameukam</a></span></p>
					</div>

					<div class="section-19__person">
						<?php LF_Utils::display_responsive_images( 99804, 'full', '175px', 'section-19__person-image', 'lazy', 'Lin Sun' ); ?>
						<p class="section-19__person-text-wrapper">
							<span class="section-19__person-name">Lin Sun</span>
							<span
							class="section-19__person-title"><a href="https://www.twitter.com/linsun_unc">@linsun_unc</a></span></p>
					</div>

					<div class="section-19__person">
						<?php LF_Utils::display_responsive_images( 99808, 'full', '175px', 'section-19__person-image', 'lazy', 'Rajas Kakodkar' ); ?>
						<p class="section-19__person-text-wrapper">
							<span class="section-19__person-name">Rajas Kakodkar</span>
							<span
							class="section-19__person-title"><a href="https://www.twitter.com/RajasKakodkar">@RajasKakodkar</a></span></p>
					</div>
				</div>
				<div aria-hidden="true" class="report-spacer-120"></div>


				<div class="lf-grid">
					<p
						class="opening-paragraph restrictive-10-col">In 2023, CNCF introduced two new awards to spotlight valuable work creating positive ripples throughout the ecosystem.</p>
				</div>


				<div class="lf-grid section-19__ca">
					<div class="section-19__ca-col1">
						<img loading="lazy" decoding="async" width="64" height="67" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'icon-first-place.svg', true );
						?>
						" alt="First place icon">

						<div aria-hidden="true" class="report-spacer-40"></div>

						<p class="sub-header">THE TAGGIE</p>

						<div aria-hidden="true" class="report-spacer-20"></div>

						<p>Presented to the person who has done the most to advance CNCF’s <a href="https://github.com/cncf/toc/tree/main/tags">Technical Advisory Groups (TAGs)</a>. TAGs scale contributions by the CNCF technical and user community, while retaining integrity and increasing quality in support of CNCF’s mission of making cloud native ubiquitous. The very first recipient of this award was:</p>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<div class="section-19__person">
							<?php LF_Utils::display_responsive_images( 82199, 'full', '175px', 'section-19__person-image', 'lazy', 'Catherine Paganini' ); ?>
							<p class="section-19__person-text-wrapper">
							<span class="section-19__person-name">Catherine Paganini</span>
							<span
							class="section-19__person-title"><a href="https://www.twitter.com/CathPaga">@CathPaga</a></span></p>
						</div>

					</div>
					<div class="section-19__ca-col2">
						<img loading="lazy" decoding="async" width="67" height="67" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'icon-chapters-g.svg', true );
						?>
						" alt="Document with check icon">

						<div aria-hidden="true" class="report-spacer-40"></div>

						<p class="sub-header">small but mighty</p>

						<div aria-hidden="true" class="report-spacer-20"></div>

						<p>This award recognizes the company or organization in the community with the largest impact. CNCF is made up of hundreds of thousands of individuals and organizations, each providing valuable contributions, but this award is presented to an organization punching above its weight. CNCF is pleased to present this award to:<br><br></p>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<div class="section-19__person-align">

							<div class="section-19__person">
								<?php LF_Utils::display_responsive_images( 99809, 'full', '175px', 'section-19__person-image', 'lazy', 'Weaveworks' ); ?>
								<p class="section-19__person-text-wrapper">
							<span class="section-19__person-name">Weaveworks</span>
							<span
							class="section-19__person-title"><a href="https://twitter.com/Weaveworks">@Weaveworks</a></span></p>
							</div>

						</div>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<?php LF_Utils::display_responsive_images( 99801, 'full', '1200px', '', 'lazy', 'All award recipients on a stage' ); ?>

			</div>
		</section>

		<section id="ecosystem"
			class="section-20 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">Mentoring & <br
							class="show-over-1000">Ecosystem Resources</h2>
					<div class="section-number">6/6</div>
				</div>

				<div class="lf-grid">
					<p
						class="opening-paragraph restrictive-10-col">CNCF worked closely in <strong>partnership</strong> with individual contributors and community groups throughout 2023, developing programs to navigate and manage the <strong>fast-growing ecosystem</strong> - rising to meet the growing global demand for cloud native technologies.</p>
				</div>

				<?php LF_Utils::display_responsive_images( 99822, 'full', '1200px', '', 'lazy', 'Conference participants doing a selfie' ); ?>
				<div aria-hidden="true" class="report-spacer-100"></div>

				<h2 class="section-header">Community Mentoring</h2>
				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<p
						class="opening-paragraph restrictive-10-col">CNCF proudly supported more than 140 individuals through various <a href="https://github.com/cncf/mentoring">mentoring and internship</a> opportunities in 2023, including the <a href="https://lfx.linuxfoundation.org/">LFX mentorship platform</a>, <a href="https://summerofcode.withgoogle.com/">Google Summer of Code (GSoC)</a>, <a href="https://developers.google.com/season-of-docs">Google Summer of Docs (GSoD)</a> program, and <a href="https://www.outreachy.org/">Outreachy</a>. These programs are important catalysts for internships to have an impact on future technologies that we all depend on.</p>
				</div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>The TAG Contributor Strategy Mentoring Working Group recruited a community administrator for Google Summer of Code, and added a Technical Lead for data analytics to help measure the effectiveness of the program against the Working Group goals.</p>
					</div>
				</div>


				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="lf-grid section-20__mentoring">

					<div class="section-20__mentoring-col1">
					<p class="sub-header">We sponsored 132 students to work on 30 CNCF Projects</p>
					<div aria-hidden="true" class="report-spacer-20"></div>
						<img loading="lazy" decoding="async" width="308" height="276" src="
<?php LF_Utils::get_svg( $report_folder . 'lf-mentorship-group.svg', true ); ?>
" alt="Mentorship metrics">
					</div>
					<div class="section-20__mentoring-col2">
					<p class="sub-header">And helped CNCF Projects participate in other open source mentoring opportunities:</p>
					<div aria-hidden="true" class="report-spacer-20"></div>
					<img loading="lazy" decoding="async" width="458" height="276" src="
<?php LF_Utils::get_svg( $report_folder . 'mentoring-opps-group.svg', true ); ?>
" alt="Mentoring opportunities metrics">
					</div>

				</div>

			</div>
		</section>

		<section class="section-21 is-style-down-gradient alignfull">

			<div class="container wrap">

				<h2 class="section-header">Funding</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<p
						class="opening-paragraph restrictive-10-col">CNCF’s revenue is derived from four primary fundraising sources, including membership, event sponsorship, event registration, and training.</p>
				</div>

				<p class="sub-header">Four Funding Sources</p>

				<div aria-hidden="true" class="report-spacer-60"></div>
				<picture>
						<source media="(max-width: 599px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'funding-mobile.svg', true );
?>
">
						<source media="(min-width: 600px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'funding-desktop.svg', true );
?>
">
						<img width="1098" height="502" src="
<?php
Lf_Utils::get_svg( $report_folder . 'funding-desktop.svg', true );
?>
" alt="CNCF Funding breakdown pie chart" loading="lazy" decoding="async">
					</picture>

				<div class="shadow-hr"></div>

				<p class="sub-header">Expenditures</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<picture>
						<source media="(max-width: 599px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'expenditures-mobile.svg', true );
?>
">
						<source media="(min-width: 600px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'expenditures-desktop.svg', true );
?>
">
						<img width="1200" height="700" src="
<?php
Lf_Utils::get_svg( $report_folder . 'expenditures-desktop.svg', true );
?>
" alt="expenditures breakdown" loading="lazy" decoding="async">
					</picture>

					<div aria-hidden="true" class="report-spacer-100"></div>

					<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>A basic premise behind CNCF, our conferences (including <a href="https://www.cncf.io/kubecon-cloudnativecon-events/">KubeCon + CloudNativeCon</a>), and open source, in general, is that interactions are positive-sum. There is no fixed amount of investment, mindshare, or development contribution allocated to specific projects. Equally important, a neutral home for a project and community fosters this type of positive-sum thinking and drives the growth and diversity that we believe are core elements of a successful open source project.</p>
					</div>
				</div>
			</div>
		</section>

		<section class="section-22 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="lf-grid thanks">
					<div class="thanks__col1">
						<h2 class="section-header">Thank You</h2>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<p
							class="thanks__opening">We hope you enjoyed reflecting on all the great things we accomplished together in 2023.</p>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<p
							class="thanks__comments">Your comments and feedback are welcome at <a href="mailto:info@cncf.io">info@cncf.io</a></p>

						<div aria-hidden="true" class="report-spacer-80"></div>

						<p>We’re looking forward to seeing you in 2024! Check out our <strong>calendar for community events</strong> near you and don’t forget to <strong>register</strong> for KubeCon+CloudNativeCon Europe in Paris in April.</p>
					</div>
					<div class="thanks__col2">

				<figure class="thanks__col2-bg-figure">
					<?php
					LF_Utils::display_responsive_images( 99525, 'full', '2400px', 'thanks__col2-bg-image', 'lazy', 'City architecture diagram' );
					?>
				</figure>
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

// custom scripts.
wp_enqueue_script(
	'annual-report-23',
	get_template_directory_uri() . '/source/js/on-demand/annual-report-23.js',
	array( 'jquery', 'slick' ),
	filemtime( get_template_directory() . '/source/js/on-demand/annual-report-23.js' ),
	true
);

get_template_part( 'components/footer' );
