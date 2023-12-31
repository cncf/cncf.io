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
" alt="CNCF Annual Report 2023 - Architect the Future" loading="eager" class="hero__title">
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
					<img loading="lazy" width="36" height="36" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-upward-chart.svg', true ); ?>
" alt="Upward trend chart icon">Momentum
				</div>

				<div class="nav-el__box">
					<a href="#events" title="Jump to Events section"
						class="box-link"></a>
					<img loading="lazy" width="36" height="36" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-lanyard.svg', true ); ?>
" alt="Lanyard icon">Events
				</div>

				<div class="nav-el__box">
					<a href="#training" title="Jump to Training section"
						class="box-link"></a>
					<img loading="lazy" width="36" height="36" src="
<?php
LF_Utils::get_svg( $report_folder . 'icon-teacher.svg', true );
?>
" alt="Teacher icon">Training
				</div>

				<div class="nav-el__box">
					<a href="#projects" title="Jump to Projects section"
						class="box-link"></a>
					<img loading="lazy" width="36" height="36" src="
<?php
LF_Utils::get_svg( $report_folder . 'icon-shape.svg', true );
?>
" alt="chart icon">Projects
				</div>

				<div class="nav-el__box">
					<a href="#community" title="Jump to Community section"
						class="box-link"></a>
					<img loading="lazy" width="36" height="36" src="
<?php
LF_Utils::get_svg( $report_folder . 'icon-relationship.svg', true );
?>
" alt="Relationship icon">Community
				</div>

				<div class="nav-el__box">
					<a href="#ecosystem" title="Jump to Ecosystem section"
						class="box-link"></a>
					<img loading="lazy" width="36" height="36" src="
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
							<img loading="lazy" width="71" height="74" src="
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
							<img loading="lazy" width="74" height="43" src="
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
							<img loading="lazy" width="60" height="57" src="
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

						<img loading="lazy" width="561" height="400" src="
<?php LF_Utils::get_svg( $report_folder . 'contributors-chart.svg', true ); ?>
" alt="Chart showing upward trend of Contributors growth">

					</div>
					<div class="section-03__intro-col2">
						<p
							class="sub-header">Member, End User & Project Growth</p>
						<div aria-hidden="true" class="report-spacer-40"></div>

						<img loading="lazy" width="550" height="400" src="
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

						<img loading="lazy" width="452" height="227" src="
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
							<img loading="lazy" width="169" height="54" src="
<?php
LF_Utils::get_svg( $report_folder . 'daocloud_logo.svg', true );
?>
" alt="DaoCloud Logo" class="logo-grid__image">
						</div>

						<div class="logo-grid__box">
							<img loading="lazy" width="77" height="77" src="
<?php
LF_Utils::get_svg( $report_folder . 'ey_logo_2019.svg', true );
?>
" alt="EY Logo" class="logo-grid__image">
						</div>

						<div class="logo-grid__box">
							<img loading="lazy" width="138" height="23" src="
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
							<img loading="lazy" width="133" height="24" src="
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
				<div class="restrictive-10-col">
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
									<img loading="lazy" width="80" height="47" src="
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
									<img loading="lazy" width="69" height="69" src="
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
									<img loading="lazy" width="56" height="63" src="
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
						<img loading="lazy" width="160" height="50" src="
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
						<img loading="lazy" width="160" height="50" src="
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
						<img loading="lazy" width="160" height="50" src="
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
						<img loading="lazy" width="160" height="50" src="
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
						<img loading="lazy" width="160" height="50" src="
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
						<img loading="lazy" width="160" height="50" src="
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
						<img loading="lazy" width="160" height="50" src="
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
						<img loading="lazy" width="160" height="50" src="
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
						<img loading="lazy" width="160" height="50" src="
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
						<img loading="lazy" width="160" height="50" src="
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
						<img loading="lazy" width="160" height="50" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'spotify.svg', true );
						?>
						" alt="spotify Logo" >
					</div>
					<div class="logo-grid__number green">
						4,125
					</div>
				</div>
				<div class="logo-grid__box">
					<div class="logo-grid__image">
						<img loading="lazy" width="160" height="50" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'bloomberg.svg', true );
						?>
						" alt="bloomberg Logo" >
					</div>
					<div class="logo-grid__number green">
						534
					</div>
				</div>
				<div class="logo-grid__box">
					<div class="logo-grid__image">
						<img loading="lazy" width="160" height="50" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'reddit.svg', true );
						?>
						" alt="reddit Logo" >
					</div>
					<div class="logo-grid__number green">
						372
					</div>
				</div>
				<div class="logo-grid__box">
					<div class="logo-grid__image">
						<img loading="lazy" width="160" height="50" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'intuit.svg', true );
						?>
						" alt="intuit Logo" >
					</div>
					<div class="logo-grid__number green">
						241
					</div>
				</div>
				<div class="logo-grid__box">
					<div class="logo-grid__image">
						<img loading="lazy" width="160" height="50" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'workday.svg', true );
						?>
						" alt="workday Logo" >
					</div>
					<div class="logo-grid__number green">
						136
					</div>
				</div>
				<div class="logo-grid__box">
					<div class="logo-grid__image">
						<img loading="lazy" width="160" height="50" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'thought-machine.svg', true );
						?>
						" alt="thought machine Logo" >
					</div>
					<div class="logo-grid__number green">
						129
					</div>
				</div>
				<div class="logo-grid__box">
					<div class="logo-grid__image">
						<img loading="lazy" width="160" height="50" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'shopify.svg', true );
						?>
						" alt="shopify Logo" >
					</div>
					<div class="logo-grid__number green">
						107
					</div>
				</div>
				<div class="logo-grid__box">
					<div class="logo-grid__image">
						<img loading="lazy" width="160" height="50" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'wayfair.svg', true );
						?>
						" alt="wayfair Logo" >
					</div>
					<div class="logo-grid__number green">
						88
					</div>
				</div>
				<div class="logo-grid__box">
					<div class="logo-grid__image">
						<img loading="lazy" width="160" height="50" src="
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
						<img loading="lazy" width="160" height="50" src="
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
					<?php
					LF_Utils::display_responsive_images(
						'99544',
						'full',
						'600px',
						null,
						'lazy',
						'Mercedes store'
					);
					?>
				</div>
				<div class="section-10__vid-col2">
					<p class="sub-header">SPRING 2023 WINNER</p>
					<div aria-hidden="true" class="report-spacer-20"></div>

					<img loading="lazy" width="315" height="80" src="
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
				</div>
				<div class="section-10__vid-col2">
					<p class="sub-header">AUTUMN 2023 WINNER</p>
					<div aria-hidden="true" class="report-spacer-20"></div>

					<img loading="lazy" width="243" height="80" src="
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
					<?php
					LF_Utils::display_responsive_images(
						'99543',
						'full',
						'600px',
						null,
						'lazy',
						'Intuit workplace'
					);
					?>
				</div>
				<div class="section-10__vid-col2">
					<p class="sub-header">AUTUMN 2022 WINNER</p>
					<div aria-hidden="true" class="report-spacer-20"></div>

					<img loading="lazy" width="209" height="60" src="
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
						class="opening-paragraph restrictive-10-col">KCDs are community-organized events that gather adopters and technologists to learn, collaborate, and network, with a goal of furthering the adoption and improvement of Kubernetes and cloud native technologies around the world. In response to the KCD community’s evolving needs in different regions, CNCF strengthened the program this year.</p>
				</div>

				<div class="lf-grid section-11__kcd">
					<div class="section-11__kcd-col1">

						<div class="icon-layout">

							<div class="icon-box-1">
								<div class="icon">
									<img loading="lazy" width="57" height="63"
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
									<img loading="lazy" width="63" height="63"
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
									<img loading="lazy" width="63" height="63"
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
									<img loading="lazy" width="74" height="41"
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
									<img loading="lazy" width="57" height="47"
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
						loading="lazy">
				</picture>
				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="lf-grid section-12__stats">
					<div class="section-12__stats-col1">
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" width="62" height="62" src="
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
								<img loading="lazy" width="82" height="67" src="
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
							LF_Utils::display_responsive_images( 99568, 'large', '500px', 'ds', 'lazy', 'Cover of the KubeCon + CloudNativeCon Europe 2023 Transparency Report' );
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

				<div aria-hidden="true" class="report-spacer-40"></div>

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
						loading="lazy">
				</picture>
				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="lf-grid section-12__stats">
					<div class="section-12__stats-col1">
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" width="62" height="62" src="
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
								<img loading="lazy" width="82" height="67" src="
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
							LF_Utils::display_responsive_images( 99569, 'large', '500px', 'ds', 'lazy', 'Cover of the KubeCon + CloudNativeCon North America 2023 Transparency Report' );
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
						loading="lazy">
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
						<img width="582" height="124" loading="lazy" src="
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
						class="opening-paragraph restrictive-10-col">Throughout 2023, CNCF underscored our commitment to making cloud native ubiquitous - hosting <a href="https://www.cncf.io/projects/">20 graduated projects</a>, <a href="https://www.cncf.io/projects/">35 incubating</a> and <a href="https://www.cncf.io/sandbox-projects/">102 sandbox projects</a>, driven by more than <strong>178,000 contributors</strong> representing <strong>189 countries</strong>.</p>
				</div>

				<p class="sub-header">Projects Accepted Over Time</p>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<?php echo do_shortcode( '[projects-maturity-chart]' ); ?>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="lf-grid">
					<p
						class="restrictive-10-col">The <a href="https://www.cncf.io/people/technical-oversight-committee/">Technical Oversight Committee</a> doubled down on cloud native security in 2023, and approved the formation of a new Technical Advisory Group, TAG Environmental Sustainability focusing on carbon outputs around cloud native computing.</p>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">CNCF Project Velocity</p>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="lf-grid">
					<p
						class="restrictive-10-col"><a href="https://github.com/cncf/velocity">Consistently looking into CNCF project's velocity</a> and the top open source projects gives us a very good indication of trends that are resonating with developers and end users. As a result, we can get insight into platforms that will likely be successful:</p>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="lf-grid legend-grid">

					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #feb95a"></div>
						<span><strong>Argo</strong><br>Authors 814</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #68b86a">
						</div><span><strong>Backstage</strong><br>Authors
							580</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #853e81">
						</div><span><strong>containerd</strong><br>Authors
							255</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #da575f">
						</div><span><strong>CoreDNS</strong><br>Authors
							69</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #5fb9d6">
						</div><span><strong>Envoy</strong><br>Authors 399</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #cb7070">
						</div><span><strong>etcd</strong><br>Authors 115</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #e46991">
						</div><span><strong>Fluentd</strong><br>Authors
							275</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #b65f5f">
						</div><span><strong>Flux</strong><br>Authors 258</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #a396b7">
						</div><span><strong>Harbor</strong><br>Authors
							126</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #35ab9b">
						</div><span><strong>Helm</strong><br>Authors 160</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #bdb844">
						</div><span><strong>Jaeger</strong><br>Authors
							145</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #4e22c8">
						</div><span><strong>Kubernetes</strong><br>Authors
							3619</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #e0a343">
						</div><span><strong>Linkerd</strong><br>Authors
							122</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #be5ab9">
						</div><span><strong>OPA</strong><br>Authors 259</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #e45f40">
						</div><span><strong>OpenTelemetry</strong><br>Authors
							1133</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #9fc45a">
						</div><span><strong>Prometheus</strong><br>Authors
							424</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #81925c">
						</div><span><strong>Rook</strong><br>Authors 99</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #4dd957">
						</div><span><strong>Spiffe</strong><br>Authors 44</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #e2e898">
						</div><span><strong>Spire</strong><br>Authors 54</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #6181a8">
						</div><span><strong>TiKV</strong><br>Authors 257</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #f2aa90">
						</div><span><strong>TUF</strong><br>Authors 51</span>
					</div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #9e6399">
						</div><span><strong>Vitess</strong><br>Authors
							101</span>
					</div>




				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<img loading="lazy" width="1200" height="700" src="
<?php LF_Utils::get_svg( $report_folder . 'cncf-project-velocity.svg', true ); ?>
" alt="CNCF Project Velocity chart">

				<div class="shadow-hr"></div>

				<p class="sub-header">Project Velocity Key Takeaways</p>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="lf-grid">
					<ul class="restrictive-10-col" style="margin-bottom: 0;">
						<li>With the largest contributor base,
							<strong>Kubernetes</strong> continues to mature
						</li>
						<li><strong>OpenTelemetry</strong> has become the second
							highest velocity project in the CNCF ecosystem,
							increasing its contributor base</li>
						<li><strong>Backstage</strong> has seen one of the
							fastest growth trajectories this year - solving an
							important pain point around cloud native developer
							experience</li>
						<li><strong>GitOps</strong> remains an important
							technique in the cloud native ecosystem, where
							projects like <strong>Argo</strong> and
							<strong>Flux</strong> continue to cultivate large
							communities
						</li>
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
						<p>CNCF conducted a number of <a href="https://www.cncf.io/blog/2023/08/08/improving-cncf-security-posture-with-independent-security-audits/">open source security audits</a> throughout 2023, in strategic partnership with the <strong>Open Source Technology Improvement Fund (OSTIF)</strong>. A number of projects completed security audits, resulting in 132 security fixes and improvements, <strong>45 CVE's fixed</strong>, and <strong>51 security tools built</strong>. We also announced the inaugural <a href="https://events.linuxfoundation.org/cloud-native-securitycon-north-america/">CloudNative SecurityCon</a>, which will launch in 2023, and bring application developers and modern security experts not just propose solutions that incrementally improve what has come before, but to give room to cutting edge projects and advances in modern security approaches.

						<br><br>Furthermore, <a href="https://www.cncf.io/blog/2023/06/28/improving-security-by-fuzzing-the-cncf-landscape/">CNCF funded fuzzing audits</a> for a variety of projects that have resulted in hundreds of bugs being found.</p>

					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<p
					class="sub-header">The following CNCF projects have completed security audits or associated work</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="logo-grid smaller">
					<div class="logo-grid__box">
						<img loading="lazy" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'logo-project-argo.svg', true );
						?>
						" alt="Argo Logo" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'logo-project-backstage.svg', true );
						?>
						" alt="Backstage Logo" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'logo-project-cilium.svg', true );
						?>
						" alt="Cilium Logo" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'logo-project-cloudevents.svg', true );
						?>
						" alt="Cloud Events Logo" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'logo-project-containerd.svg', true );
						?>
						" alt="ContainerD Logo" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'logo-project-contour.svg', true );
						?>
						" alt="Contour Logo" class="logo-grid__image">
					</div>

					<div class="logo-grid__box">
						<img loading="lazy" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'logo-project-crio.svg', true );
						?>
						" alt="Crio Logo" class="logo-grid__image">
					</div>

					<div class="logo-grid__box">
						<img loading="lazy" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'logo-project-envoy.svg', true );
						?>
						" alt="Envoy Logo" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'logo-project-falco.svg', true );
						?>
						" alt="Falco Logo" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'logo-project-flux.svg', true );
						?>
						" alt="Flux Logo" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'logo-project-istio.svg', true );
						?>
						" alt="Istio Logo" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'logo-project-keda.svg', true );
						?>
						" alt="Keda Logo" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'logo-project-kubeedge.svg', true );
						?>
						" alt="Kube Edge Logo" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'logo-project-kubernetes.svg', true );
						?>
						" alt="Kubernetes Logo" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'logo-project-linkerd.svg', true );
						?>
						" alt="Linkerd Logo" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'logo-project-tuf.svg', true );
						?>
						" alt="TUF Logo" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'logo-project-vitess.svg', true );
						?>
						" alt="Vitess Logo" class="logo-grid__image">
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">Improvements At A Glance</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-16__improvements">

					<div class="section-16__improvements-col1">
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" width="40" height="50" src="
<?php
LF_Utils::get_svg( $report_folder . 'icon-checkmark.svg', true );
?>
" alt="Checkmark icon">
							</div>
							<div class="text">
								<span class="number">132</span><br />
								<span class="description">Security Fixes and
									Improvements</span>
							</div>
						</div>
					</div>

					<div class="section-16__improvements-col2">
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" width="25" height="50" src="
<?php
LF_Utils::get_svg( $report_folder . 'icon-flag.svg', true );
?>
" alt="Flag icon">
							</div>
							<div class="text">
								<span class="number">45</span><br />
								<span class="description">CVE's Reported and
									Fixed</span>
								<span class="addendum">
									Includes 5 critical and 10 high severity
									findings fixed
								</span>
							</div>
						</div>
					</div>


					<div class="section-16__improvements-col3">
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" width="51" height="52" src="
<?php
LF_Utils::get_svg( $report_folder . 'icon-tools.svg', true );
?>
" alt="Tool icon">
							</div>
							<div class="text">
								<span class="number">51</span><br />
								<span class="description">Security Tools
									Built</span>
							</div>
						</div>
					</div>

					<div class="section-16__improvements-col4">
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" width="62" height="62" src="
<?php
LF_Utils::get_svg( $report_folder . 'icon-checklist.svg', true );
?>
" alt="Checklist icon">
							</div>
							<div class="text">
								<span class="number small">Denial of service,
									XSS, Path Traversal, Privilege Escalation,
									RCE</span><br />
								<span class="description">Types of
									Vulnerabilities Fixed</span>
							</div>
						</div>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<h2 class="section-header">Telcom Advances</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>CNCF's footprint in the Telecom domain increased throughout 2023. In May, the <a href="https://www.cncf.io/certification/cnf/">Cloud Native Network Function (CNF) Certification Program (beta)</a> was announced to help Communication Service Providers (CSPs) validate how well their vendors' products follow cloud native principles, and to advise vendors on following cloud native best practices. This is supported by CSPs like Vodafone, Deutsche Telekom and DISH Wireless, and guided by best practices from the <a href="https://github.com/cncf/cnf-wg">Cloud Native Network Function (CNF) Working Group</a> and runs certification tests on the <a href="https://github.com/cncf/cnf-testsuite">CNF Test Suite</a>.</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<p class="sub-header">Highlights</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-16__highlights">

					<div class="section-16__highlights-col1">
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" width="40" height="50" src="
<?php
LF_Utils::get_svg( $report_folder . 'icon-building-pink.svg', true );
?>
" alt="Building icon">
							</div>
							<div class="text">
								<span class="number">4</span><br />
								<span class="description">CNF vendor
									organizations</span>
								<span class="addendum">Earned "Certified CNF"
									status - for <a
										href="https://www.prnewswire.com/news-releases/cncf-announces-first-products-certified-under-cloud-native-network-function-certification-program-301657188.html">a total of 6 products</a></span>
							</div>
						</div>
					</div>
					<div class="section-16__highlights-col2">
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" width="40" height="50" src="
<?php
LF_Utils::get_svg( $report_folder . 'icon-calendar-pink.svg', true );
?>
" alt="Calendar icon">
							</div>
							<div class="text">
								<span class="number">2</span><br />
								<span class="description">Cloud Native Telco
									Days</span>
							</div>
						</div>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<h2 class="section-header">Kubernetes API <br
						class="show-over-1000">Endpoint Testing</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>Significant progress has been made in 2023 towards the goal of 100% conformance test coverage of the Kubernetes API, managed through <a href="https://apisnoop.cncf.io/about">APISnoop</a> - a community-driven project spearheaded by long-time CNCF contributor and community leader <a href="https://twitter.com/hippiehacker">Hippie Hacker</a>, which tracks the testing and conformance coverage of Kubernetes by analyzing the audit logs created by e2e test runs.</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<p>At the start of 2023 there were 85 untested endpoints remaining. </p>

				<div aria-hidden="true" class="report-spacer-20"></div>

				<p><strong>Conformance test was added across the three release:</strong><br>
1.24 - 16 endpoints tested<br>
1.25 - 23 endpoints tested<br>
1.26 - 10 endpoints tested</p>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<p class="sub-header">Endpoint testing results</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<img loading="lazy" width="1200" height="600" src="
<?php LF_Utils::get_svg( $report_folder . 'endpoint-testing-results.svg', true ); ?>
" alt="Endpoint testing results chart">

				<div aria-hidden="true" class="report-spacer-80"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>At the same time 26 endpoints have been identified as being ineligible for conformance testing and <a href="https://apisnoop.cncf.io/conformance-progress/ineligible-endpoints">move to the ineligible endpoints list</a>. By the end of 2023 only <a href="https://apisnoop.cncf.io/conformance-progress/endpoints/1.26.0/?filter=untested">10 endpoints</a> (2.5%) remain untested. We anticipate cleaning up the last <a href="https://apisnoop.cncf.io/conformance-progress">technical debt</a> by Kubecon + CloudNativeCon North America 2023.

						<br><br>The automation for CNCF Kubernetes Conformance Certification repo has been updated for an <a href="https://www.cncf.io/blog/2023/10/19/kubernetes-conformance-updates-for-october-2023/">enhanced user experience</a> with improved functionality under the hood. The CNCF-CI bot also gives more detailed explanations of requirements when a submission fails and supporting documentation has also been improved. These changes help to reduce the complexity of reviewing and approving Kubernetes conformance submissions.</p>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<h2 class="section-header">Project Moves</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<p class="sub-header">CNCF PROJECTS ACCEPTED</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<p>In 2023, the <a href="https://github.com/cncf/toc">CNCF TOC</a> accepted 35 new projects:</p>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<img loading="lazy" width="1200" height="500" src="
<?php LF_Utils::get_svg( $report_folder . 'projects-accepted-2023.svg', true ); ?>
" alt="Chart showing projects accepted by year - 2023 had 35 new projects accepted">

				<div aria-hidden="true" class="report-spacer-80"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>Projects increase their maturity level by demonstrating to the <a href="https://www.cncf.io/people/technical-oversight-committee/">TOC</a> that they have attained end user and vendor adoption, established a healthy rate of code commits and codebase changes, and attracted committers from multiple organizations.
							</p>

					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">Graduations</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="logo-grid smaller">
					<div class="logo-grid__box">
						<img loading="lazy" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'logo-project-argo.svg', true );
						?>
						" alt="Argo Logo" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'logo-project-flux.svg', true );
						?>
						" alt="Flux Logo" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'logo-project-spiffe.svg', true );
						?>
						" alt="Spiffe Logo" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'logo-project-spire.svg', true );
						?>
						" alt="Spire Logo" class="logo-grid__image">
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">Incubation Level</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<p>Joined at the Incubation level or moved from Sandbox to Incubation.</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="logo-grid smallest">
					<div class="logo-grid__box">
						<img loading="lazy" src="
	<?php
	LF_Utils::get_svg( $report_folder . 'logo-project-backstage.svg', true );
	?>
	" alt="Backstage Logo" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" src="
	<?php
	LF_Utils::get_svg( $report_folder . 'logo-project-cert-manager.svg', true );
	?>
	" alt="Cert Manager Logo" class="logo-grid__image">
					</div>

					<div class="logo-grid__box">
						<img loading="lazy" src="
	<?php
	LF_Utils::get_svg( $report_folder . 'logo-project-chaosmesh.svg', true );
	?>
	" alt="Chaos Mesh Logo" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" src="
	<?php
	LF_Utils::get_svg( $report_folder . 'logo-project-cloud-custodian.svg', true );
	?>
	" alt="Cloud Custodian Logo" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" src="
	<?php
	LF_Utils::get_svg( $report_folder . 'logo-project-cube-fs.svg', true );
	?>
	" alt="Cube FS Logo" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" src="
	<?php
	LF_Utils::get_svg( $report_folder . 'logo-project-in-toto.svg', true );
	?>
	" alt="In Toto Logo" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" src="
	<?php
	LF_Utils::get_svg( $report_folder . 'logo-project-istio.svg', true );
	?>
	" alt="Istio Logo" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" src="
	<?php
	LF_Utils::get_svg( $report_folder . 'logo-project-litmus.svg', true );
	?>
	" alt="Litmus Logo" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" src="
	<?php
	LF_Utils::get_svg( $report_folder . 'logo-project-knative.svg', true );
	?>
	" alt="Knative Logo" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" src="
	<?php
	LF_Utils::get_svg( $report_folder . 'logo-project-kube-virt.svg', true );
	?>
	" alt="Kube Virt Logo" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" src="
	<?php
	LF_Utils::get_svg( $report_folder . 'logo-project-kyverno.svg', true );
	?>
	" alt="Kyverno Logo" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" src="
	<?php
	LF_Utils::get_svg( $report_folder . 'logo-project-open-metrics.svg', true );
	?>
	" alt="Open Metrics Logo" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" src="
	<?php
	LF_Utils::get_svg( $report_folder . 'logo-project-volcano.svg', true );
	?>
	" alt="Volcano Logo" class="logo-grid__image">
					</div>
				</div>
			</div>
		</section>

		<section class="section-17 is-style-down-gradient alignfull">

			<div class="container wrap">

				<h2 class="section-header">Phippy & Friends Explain <br
						class="show-over-1000">Cloud Native Computing </h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>From a humble PHP app, Phippy has gone on to help thousands of folx take their first steps to understanding cloud native computing - from containerisation to automation. Today, Phippy and Friends' mission is to demystify cloud native computing and explain complicated concepts in a compelling, engaging and easy-to-understand manner.</p>
					</div>
				</div>
				<div aria-hidden="true" class="report-spacer-100"></div>

				<p
					class="sub-header">In 2023, two projects donated characters</p>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="lf-grid section-17__characters">
					<?php
						LF_Utils::display_responsive_images( 82207, 'full', '1000px', null, 'lazy', 'New Phippy characters, Owlina The Owl, donated by Open Policy Agent and Cappy The Turtle' );
					?>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<p class="sub-header">Phippy and Friends got a 3D makeover</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="wp-block-lf-youtube-lite">
					<lite-youtube videoid="-etekNAO2Xc"
						videotitle="Phippy gets a 3D makeover" webpStatus="1"
						sdthumbStatus="0" title="Play Phippy 3D">
					</lite-youtube>
				</div>
				<div class="shadow-hr"></div>

				<p class="sub-header">Join The Phippy & Friends Family!</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="section-17__banner">
					<div class="section-17__banner-wrapper">
						<h2 class="section-17__banner-title">Are you a
							maintainer on
							a
							graduated project?</h2>
						<p
							class="section-17__banner-text">Do you want to help others better understand the concepts of cloud native computing? Donate a character to the Phippy and Friends family.</p>
					</div>
					<div class="wp-block-button"><a href="https://github.com/cncf/foundation/blob/master/phippy-guidelines.md"
							title="Donate a character"
							class="wp-block-button__link fit-content">Donate a
							character</a>
					</div>
				</div>

			</div>
		</section>

		<section class="section-18 is-style-down-gradient alignfull">

			<div class="container wrap">

				<h2 class="section-header">Introducing: <br
						class="show-over-1000">Documentaries</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-10-col">
						<p>This year CNCF helped launch two documentary films that supported our mission to humanize developers by telling their story of development in this dynamic medium. In January 2023,  <a href="https://youtu.be/BE77h7dmoQU">The Origins of Kubernetes</a> debuted on YouTube. The two part documentary has since garnered a combined 463,000 views and continues to attract viewers from across the world.</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="wp-block-lf-youtube-lite">
					<lite-youtube videoid="BE77h7dmoQU"
						videotitle="Kubernetes The Documentary" webpStatus="1"
						sdthumbStatus="0"
						title="Play Kubernetes The Documentary">
					</lite-youtube>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p><a href="https://youtu.be/rT4fJNbfe14">Inside Prometheus</a> debuted in October 2023 at Prometheus Day North America as part of KubeCon + CloudNativeCon NA and has so far garnered 59,000 views on YouTube. Both films succeed in giving a voice and face to the forward-looking engineers who tackled adversity and technical challenges in their quest to change the way we work and live today.</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="wp-block-lf-youtube-lite">
					<lite-youtube videoid="rT4fJNbfe14"
						videotitle="Inside Prometheus" webpStatus="1"
						sdthumbStatus="0" title="Play Inside Prometheus">
					</lite-youtube>
				</div>
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

				<div aria-hidden="true" class="report-spacer-100"></div>

				<p class="sub-header">Diversity, Equity, and Inclusivity</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<p
						class="restrictive-9-col">CNCF continues to support the development of this incredible cloud native community while also striving to ensure that everyone who participates feels welcome regardless of gender, gender identity, sexual orientation, disability, race, ethnicity, age, religion, or economic status. To date, <strong>we've offered more than 5,000 diversity and need-based scholarships</strong>, through the Dan Kohn Scholarship Fund.</p>
				</div>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<p
					class="sub-header">Women And Gender Non-Conforming Speakers - 2023</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-19__dei">
					<div class="section-19__dei-col1">
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" width="95" height="61" src="
<?php
LF_Utils::get_svg( $report_folder . 'icon-female-non-binary.svg', true );
?>
" alt="Female and Non Binary person icon">
							</div>
							<div class="text">
								<span class="number">48%</span><br />
								<span class="description">of Keynotes</span>
								<span class="addendum">
									at <a href="https://events.linuxfoundation.org/archive/2023/kubecon-cloudnativecon-europe/">KubeCon + CloudNativeCon
										Europe</a> </span>
							</div>
						</div>

					</div>
					<div class="section-19__dei-col2">
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" width="95" height="61" src="
<?php
LF_Utils::get_svg( $report_folder . 'icon-female-non-binary.svg', true );
?>
" alt="Female and Non Binary person icon">
							</div>
							<div class="text">
								<span class="number">44%</span><br />
								<span class="description">of Keynotes</span>
								<span class="addendum">
									at <a href="https://events.linuxfoundation.org/kubecon-cloudnativecon-north-america/">KubeCon + CloudNativeCon North
										America</a></span>
							</div>
						</div>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<h2 class="section-header">Scholarships Offered</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<p class="sub-header">We offered scholarships to:</p>

				<div aria-hidden="true" class="report-spacer-60"></div>


				<div class="lf-grid section-19__dei">
					<div class="section-19__dei-col1">
						<div class="icon-box-3">
							<div class="text">
								<span class="number">749</span><br />
								<span class="description">Diversity
									Applicants</span>
								<span class="addendum">from traditionally
									underrepresented and / or marginalized
									groups</span>
							</div>
						</div>

					</div>
					<div class="section-19__dei-col2">
						<div class="icon-box-3">
							<div class="text">
								<span class="number">726</span><br />
								<span class="description">Need-Based
									Applicants</span>
								<span class="addendum">
									attended KubeCon + CloudNativeCons and CNCF
									hosted co-located events</span>
							</div>
						</div>
					</div>
				</div>
				<div aria-hidden="true" class="report-spacer-100"></div>

				<p
					class="sub-header">Scholarships were funded by sponsorships from</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="logo-grid smallest">

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
							LF_Utils::get_svg( $report_folder . 'logo-form3.svg', true );
						?>
							" alt="Logo for Form 3" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" src="
						<?php
							LF_Utils::get_svg( $report_folder . 'logo-golden-solutions.svg', true );
						?>
							" alt="Logo for Golden Solutions" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" src="
						<?php
							LF_Utils::get_svg( $report_folder . 'logo-grafana-labs.svg', true );
						?>
							" alt="Logo for Grafana Labs" class="logo-grid__image">
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
					<div class="logo-grid__box">
						<img loading="lazy" src="
						<?php
							LF_Utils::get_svg( $report_folder . 'logo-vmware.svg', true );
						?>
							" alt="Logo for VM Ware" class="logo-grid__image">
					</div>
				</div>

				<div class="shadow-hr"></div>

				<h2 class="section-header">Community Awards</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-10-col">
						<p>Now in their sixth year, the <a href="https://www.cncf.io/announcements/2020/11/20/cloud-native-computing-foundation-announces-2020-community-awards-winners/">CNCF Community Awards</a> highlighted the most active ambassador and top contributor across all CNCF projects. The awards included:</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="lf-grid section-19__ca">
					<div class="section-19__ca-col1">
						<img loading="lazy" width="64" height="66" src="
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
							<?php LF_Utils::display_responsive_images( 82196, 'full', '175px', 'section-19__person-image', 'lazy', 'Carolyn Van Slyck' ); ?>
							<p class="section-19__person-text-wrapper">
							<span class="section-19__person-name">Carolyn Van Slyck</span>
							<span
							class="section-19__person-title"><a href="https://www.twitter.com/carolynvs">@carolynvs</a></span></p>
						</div>

					</div>
					<div class="section-19__ca-col2">
						<img loading="lazy" width="54" height="64" src="
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
								<?php LF_Utils::display_responsive_images( 82199, 'full', '175px', 'section-19__person-image', 'lazy', 'Catherine Paganini' ); ?>
								<p class="section-19__person-text-wrapper">
							<span class="section-19__person-name">Catherine Paganini</span>
							<span
							class="section-19__person-title"><a href="https://www.twitter.com/CathPaga">@CathPaga</a></span></p>
							</div>

							<div class="section-19__person">
								<?php LF_Utils::display_responsive_images( 82198, 'full', '175px', 'section-19__person-image', 'lazy', 'Rey Lejano' ); ?>
								<p class="section-19__person-text-wrapper">
							<span class="section-19__person-name">Rey Lejano</span>
							<span
							class="section-19__person-title"><a href="https://www.twitter.com/reylejano">@reylejano</a></span></p>
							</div>

						</div>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<img loading="lazy" width="73" height="73" src="
<?php
LF_Utils::get_svg( $report_folder . 'icon-chop.svg', true );
?>
" alt="Axe icon">

						<div aria-hidden="true" class="report-spacer-40"></div>

						<p class="sub-header">Chop Wood & Carry Water awards</p>
						<div aria-hidden="true" class="report-spacer-20"></div>

						<p>To recognize contributors who spend countless hours completing often mundane tasks, CNCF created the “<strong>Chop Wood and Carry Water</strong>” awards. CNCF was proud to acknowledge the amazing efforts of five individuals for their outstanding contributions in 2023:</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="section-19__person-align">

					<div class="section-19__person">
						<?php LF_Utils::display_responsive_images( 82194, 'full', '175px', 'section-19__person-image', 'lazy', 'Adolfo García Veytia' ); ?>
						<p class="section-19__person-text-wrapper">
							<span class="section-19__person-name">Adolfo García Veytia</span>
							<span
							class="section-19__person-title"><a href="https://www.twitter.com/puerco">@puerco</a></span></p>
					</div>

					<div class="section-19__person">
						<?php LF_Utils::display_responsive_images( 82195, 'full', '175px', 'section-19__person-image', 'lazy', 'Alex Chircop' ); ?>
						<p class="section-19__person-text-wrapper">
							<span class="section-19__person-name">Alex Chircop</span>
							<span
							class="section-19__person-title"><a href="https://www.twitter.com/chira001">@chira001</a></span></p>
					</div>

					<div class="section-19__person">
						<?php LF_Utils::display_responsive_images( 82199, 'full', '175px', 'section-19__person-image', 'lazy', 'Catherine Paganini' ); ?>
						<p class="section-19__person-text-wrapper">
							<span class="section-19__person-name">Catherine Paganini</span>
							<span
							class="section-19__person-title"><a href="https://www.twitter.com/CathPaga">@CathPaga</a></span></p>
					</div>

					<div class="section-19__person">
						<?php LF_Utils::display_responsive_images( 82193, 'full', '175px', 'section-19__person-image', 'lazy', 'Patrick Ohly' ); ?>
						<p class="section-19__person-text-wrapper">
							<span class="section-19__person-name">Patrick Ohly</span>
							</p>
					</div>

					<div class="section-19__person">
						<?php LF_Utils::display_responsive_images( 82197, 'full', '175px', 'section-19__person-image', 'lazy', 'Xing Yang' ); ?>
						<p class="section-19__person-text-wrapper">
							<span class="section-19__person-name">Xing Yang</span>
							<span
							class="section-19__person-title"><a href="https://www.twitter.com/2000xyang">@2000xyang</a></span></p>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<h2 class="section-header">CNCF Meetups become <br
						class="show-over-1000">Community Groups</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>2023 saw the cloud native community switch from the Meetup platform to <a href="https://community.cncf.io/">Cloud Native Community Groups</a> and the new platform has taken off. It has become the singular place where meetups, online programs, project office hours, and community events are run. The platform now hosts over 31,500 unique chapter members and we are excited to see this platform continue to grow.</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<p class="sub-header">Community Groups 2023</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-19__groups">
					<div class="section-19__groups-col1">
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" width="103" height="57" src="
<?php
LF_Utils::get_svg( $report_folder . 'icon-attendees-g.svg', true );
?>
" alt="People icon">
							</div>
							<div class="text">
								<span class="number">31,500+</span><br />
								<span class="description">Attendees</span>
							</div>
						</div>
					</div>
					<div class="section-19__groups-col2">
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" width="62" height="68" src="
<?php
LF_Utils::get_svg( $report_folder . 'icon-calendar-g.svg', true );
?>
" alt="Calendar icon">
							</div>
							<div class="text">
								<span class="number">574</span><br />
								<span class="description">Events</span>
							</div>
						</div>
					</div>
					<div class="section-19__groups-col3">
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" width="62" height="62" src="
<?php
LF_Utils::get_svg( $report_folder . 'icon-chapters-g.svg', true );
?>
" alt="Chapters icon">
							</div>
							<div class="text">
								<span class="number">335</span><br />
								<span class="description">Chapters</span>
							</div>
						</div>
					</div>
				</div>

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
						class="opening-paragraph restrictive-10-col">CNCF worked closely in partnership with individual contributors and community groups throughout 2023, developing programs to navigate and manage the fast-growing ecosystem - rising to meet the growing global demand for cloud native technologies.</p>
				</div>

				<p class="sub-header">New End User Group</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<img width="378" height="109" loading="lazy" src="
<?php
Lf_Utils::get_image( $report_folder . 'transportation-user-group.png' );
?>
" alt=" CNCF Transportation User Group logo">

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<p class="restrictive-9-col">The CNCF Transportation User Group's purpose is to function as a focal meeting point for the discussion and advancement of cloud native in transportation and logistics organizations. This includes enumerating current practices, identifying gaps, and directing efforts to help improve workflows.
</p>
				</div>

				<div class="shadow-hr"></div>

				<h2 class="section-header">CNCF Glossary</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>The <a href="https://glossary.cncf.io/">Cloud Native Glossary</a> is a project led by the CNCF Business Value Subcommittee. Its goal is to explain cloud native concepts in clear and simple language without requiring any previous technical knowledge.</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<p
					class="sub-header">Seven new translations of the CNCF Glossary were donated this year</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<picture>
					<source media="(max-width: 499px)" srcset="
<?php
Lf_Utils::get_image( $report_folder . 'glossary-banner-mobile.png' );
?>
">
					<source media="(min-width: 500px)" srcset="
<?php
Lf_Utils::get_image( $report_folder . 'glossary-banner-desktop.png' );
?>
">
					<img width="1200" height="200" src="
<?php
Lf_Utils::get_image( $report_folder . 'glossary-banner-desktop.png' );
?>
" alt="Seven new translations of the CNCF Glossary were donated this year" loading="lazy">
				</picture>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="section-20__banner">
					<p
						class="section-20__banner-text">The Glossary is a community-driven effort and everyone is welcome to contribute new terms, update current ones, or help translate into different languages.</p>
					<div class="wp-block-button"><a href="https://glossary.cncf.io/contribute/"
							title="Contribute to the Glossary"
							class="wp-block-button__link fit-content"
							style="white-space: nowrap;">Contribute</a>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<h2 class="section-header">Community Mentoring</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-10-col">
						<p>CNCF proudly supported more than 100 individuals through various <a href="https://github.com/cncf/mentoring">mentoring and internship opportunities</a> in 2023, including the <a href="https://lfx.linuxfoundation.org/tools/mentorship">LFX mentorship platform</a>, <a href="https://summerofcode.withgoogle.com/">Google Summer of Code (GSoC)</a>, <a href="https://developers.google.com/season-of-docs">Google Summer of Docs (GSoD)</a> program, and <a href="https://www.outreachy.org/">Outreachy</a>. These programs are important catalysts for internships to have an impact on future technologies that we all depend on.<br><br>
						In August, the TAG Contributor Strategy approved a Mentoring Working Group. The primary goals of this Working Group are to have the community administer CNCF mentorship initiatives and, by doing so, to help provide the capacity needed to grow and add new mentorship programs.
					</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<p
					class="sub-header">We sponsored 106 students to work on 28 CNCF Projects</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-20__mentoring">

					<div class="section-20__mentoring-col1">
						<p class="section-20__mentoring-number">86</p>
						<img loading="lazy" width="274" height="41" src="
<?php LF_Utils::get_svg( $report_folder . 'logo-lfx-mentorship.svg', true ); ?>
" alt="Logo of LFX Mentorship">
					</div>
					<div class="section-20__mentoring-col2">
						<p class="section-20__mentoring-number">3</p>
						<img loading="lazy" width="280" height="72" src="
<?php LF_Utils::get_image( $report_folder . 'logo-gsod.png' ); ?>
" alt="Logo of Google Season of Docs">
					</div>
					<div class="section-20__mentoring-col3">
						<p class="section-20__mentoring-number">16</p>
						<img loading="lazy" width="287" height="80" src="
<?php LF_Utils::get_svg( $report_folder . 'logo-gsoc.svg', true ); ?>
" alt="Logo of Google Summer of Code">

					</div>
					<div class="section-20__mentoring-col4">
						<p class="section-20__mentoring-number">1</p>
						<img loading="lazy" width="260" height="60" src="
<?php LF_Utils::get_svg( $report_folder . 'logo-outreachy.svg', true ); ?>
" alt="Logo of Outreachy">
					</div>

				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="wp-block-button"><a href="https://github.com/cncf/mentoring" title="Get involved with mentoring"
						class="wp-block-button__link fit-content"
						style="white-space: nowrap;">Get involved</a>
				</div>

				<div class="shadow-hr"></div>

				<h2 class="section-header">Who we are</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>Internally, <a href="https://www.cncf.io/people/staff/" title="See CNCF staff">we employ 41 people from various backgrounds and locations</a>; 61% women, 39% men. CNCF's Governance Leadership, comprising the Governing Board and Technical Oversight Committee, is 20% women and 80% men.</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="lf-grid section-20__staff">
					<div class="section-20__staff-col1">
						<p class="sub-header">Staff</p>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<img loading="lazy" width="585" height="585" src="
<?php LF_Utils::get_svg( $report_folder . 'staff-chart.svg', true ); ?>
" alt="Chart of CNCF staff - showing 61% women, 39% men">

					</div>
					<div class="section-20__staff-col2">

						<p class="sub-header">Governance Leadership</p>

						<div aria-hidden="true" class="report-spacer-40"></div>

						<img loading="lazy" width="389" height="214" src="
<?php LF_Utils::get_svg( $report_folder . 'governance-chart.svg', true ); ?>
" alt="Governance Leadership chart showing 20% women, 80% men">

						<div aria-hidden="true" class="report-spacer-80"></div>

						<p class="sub-header">Executive Leadership</p>

						<div aria-hidden="true" class="report-spacer-40"></div>

						<img loading="lazy" width="389" height="214" src="
<?php LF_Utils::get_svg( $report_folder . 'executive-leadership-chart.svg', true ); ?>
" alt="Chart of Executive Leadership - showing 62.5% women, 37.5% men">

					</div>
				</div>
			</div>
		</section>

		<section class="section-21 is-style-down-gradient alignfull">

			<div class="container wrap">

				<h2 class="section-header">Funding</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-8-col">
						<p>CNCF's revenue is derived from four primary fundraising sources, including membership, event sponsorship, event registration, and training.</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<p class="sub-header">Four Funding Sources</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-21__funding">
					<div class="section-21__funding-col1">
						<img loading="lazy" width="585" height="276" src="
<?php LF_Utils::get_svg( $report_folder . 'funding-1.svg', true ); ?>
" alt="7.1% from training, 26.9% from Membership">
					</div>
					<div class="section-21__funding-col2">
						<img loading="lazy" width="585" height="276" src="
<?php LF_Utils::get_svg( $report_folder . 'funding-2.svg', true ); ?>
" alt="27.9% from event registration, 38% from event sponorship">

					</div>

				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">Expenditures</p>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="lf-grid section-21__expenses">

					<img loading="lazy" width="380" height="167" src="
	<?php LF_Utils::get_svg( $report_folder . 'expenses-1.svg', true ); ?>
	" alt="6.6% for Marketing, Comms and Busiess Development">
					<img loading="lazy" width="380" height="167" src="
	<?php LF_Utils::get_svg( $report_folder . 'expenses-2.svg', true ); ?>
	" alt="50.5% for Events">
					<img loading="lazy" width="380" height="167" src="
	<?php LF_Utils::get_svg( $report_folder . 'expenses-3.svg', true ); ?>
	" alt="17.4% for Developer Collaboration & IT">
					<img loading="lazy" width="380" height="167" src="
	<?php LF_Utils::get_svg( $report_folder . 'expenses-4.svg', true ); ?>
	" alt="1.9% for Training & Certification">
					<img loading="lazy" width="380" height="167" src="
	<?php LF_Utils::get_svg( $report_folder . 'expenses-5.svg', true ); ?>
	" alt="1.2% for Legal">
					<img loading="lazy" width="380" height="167" src="
	<?php LF_Utils::get_svg( $report_folder . 'expenses-6.svg', true ); ?>
	" alt="10.8% for Leadership & Coordination">
					<img loading="lazy" width="380" height="167" src="
	<?php LF_Utils::get_svg( $report_folder . 'expenses-7.svg', true ); ?>
	" alt="1.0% for Operations">
					<img loading="lazy" width="380" height="167" src="
	<?php LF_Utils::get_svg( $report_folder . 'expenses-8.svg', true ); ?>
	" alt="5.8% for LG General & Adminstrative">
					<img loading="lazy" width="380" height="167" src="
	<?php LF_Utils::get_svg( $report_folder . 'expenses-9.svg', true ); ?>
	" alt="4.8% for Reserve">

				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="lf-grid">
					<div class="restrictive-8-col">
						<p>A basic premise behind CNCF, our conferences (including <a href="https://www.cncf.io/community/kubecon-cloudnativecon-events/">KubeCon + CloudNativeCon</a>), and open source, in general, is that interactions are positive-sum. There is no fixed amount of investment, mindshare, or development contribution allocated to specific projects. Equally important, a neutral home for a project and community fosters this type of positive-sum thinking and drives the growth and diversity that we believe are core elements of a successful open source project.</p>
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

						<p>Check out our <a href="https://community.cncf.io" title="Community Events">calendar for community events</a> near you and don't forget to <a href="https://events.linuxfoundation.org/kubecon-cloudnativecon-europe/register/" title="Register for KubeCon+ CloudNativeCon North America">register</a> for KubeCon + CloudNativeCon Europe in Amsterdam, April 2023.</p>
					</div>
					<div class="thanks__col2">
						<?php
							LF_Utils::display_responsive_images( 82121, 'full', '450px', '', 'lazy', 'CNCF Mascots' );
						?>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<a href="https://events.linuxfoundation.org/kubecon-cloudnativecon-europe/register/"
					title="Register for KubeCon+ CloudNativeCon North America">
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
							'Register for KubeCon+ CloudNativeCon North America'
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
	'annual-report-23',
	get_template_directory_uri() . '/source/js/on-demand/annual-report-23.js',
	array( 'jquery', 'slick' ),
	filemtime( get_template_directory() . '/source/js/on-demand/annual-report-23.js' ),
	true
);

get_template_part( 'components/footer' );
