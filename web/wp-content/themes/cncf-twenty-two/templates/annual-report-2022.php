<?php
/**
 * Template Name: Annual Report 2022
 * Template Post Type: lf_report
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

// Report folder in images/ folder.
$report_folder = 'annual-reports/2022/';

get_template_part( 'components/header' );

get_template_part( 'components/skip-link-target' );

wp_enqueue_style( 'ar-2022', get_template_directory_uri() . '/build/annual-report-2022.min.css', array(), filemtime( get_template_directory() . '/build/annual-report-2022.min.css' ), 'all' );

wp_enqueue_style( 'wp-block-group' );
wp_enqueue_style( 'wp-block-column' );
wp_enqueue_style( 'wp-block-columns' );

// setup social share icons + data.
$caption      = 'Read the CNCF Anunal Report 2022 ';
$page_url     = rawurlencode( get_permalink() );
$caption      = htmlspecialchars( rawurlencode( html_entity_decode( $caption, ENT_COMPAT, 'UTF-8' ) ), ENT_COMPAT, 'UTF-8' );
$options      = get_option( 'lf-mu' );
$twitter      = $options && $options['social_twitter_handle'] ? $options['social_twitter_handle'] : null;
$twitter_url  = 'https://twitter.com/intent/tweet?text=' . $caption . '&amp;url=' . $page_url . '&amp;hashtags=cncf&amp;via=' . $twitter . '';
$linkedin_url = 'https://www.linkedin.com/shareArticle?mini=true&url=' . $page_url . '&summary=' . $caption;
$mailto_url   = 'mailto:?subject=' . $caption . '&body=' . $caption . '&nbsp;' . $page_url;
?>

<link rel="prefetch"
	href="<?php echo esc_url( get_template_directory_uri() . '/build/annual-report-2022.min.css' ); ?>"
	as="style" crossorigin="anonymous" />

<main class="ar-2022">
	<article class="container wrap">

		<section class="hero alignfull">
			<div class="container wrap hero__container">
				<figure class="hero__container-bg-figure">
					<?php
					LF_Utils::display_responsive_images( 82117, 'full', '2400px', 'hero__container-bg-image', 'eager', 'A cloud network graphic' );
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
" alt="CNCF Annual Report 2022 - Building for the road ahead" loading="eager" class="hero__title">
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
LF_Utils::get_svg( $report_folder . 'icon-smile.svg', true );
?>
" alt="Smiling face icon">Projects
				</div>

				<div class="nav-el__box">
					<a href="#community" title="Jump to Community section"
						class="box-link"></a>
					<img loading="lazy" width="36" height="36" src="
<?php
LF_Utils::get_svg( $report_folder . 'icon-directions.svg', true );
?>
" alt="Multiple directions icon">Community
				</div>

				<div class="nav-el__box">
					<a href="#ecosystem" title="Jump to Ecosystem section"
						class="box-link"></a>
					<img loading="lazy" width="36" height="36" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-relationship.svg', true ); ?>
" alt="Relationship icon">Ecosystem
				</div>
			</div>
		</section>

		<section class="section-01">
			<h2 class="section-01__title">Welcome! It's been a <br
					class="show-over-1000">year to remember</h2>

			<div class="lf-grid section-01__grid">
				<div class="section-01__grid-col1">

					<p><strong>When I look back on 2022, it's with a deep sense of pride for what we have overcome and achieved together. Despite the collective challenges we've faced, and continue to tackle, the cloud native ecosystem has soared. We've welcomed new industries, projects, and swelled our community to 7.1 million cloud native developers, surpassing the population of Denmark!</strong></p>

					<p>Cloud native has crossed the chasm and more organizations than ever before are becoming software companies. This was reflected at our KubeCon + CloudNativeCon events, where businesses like Mercedes Benz and Boeing headlined keynotes alongside well-known tech brands.</p>

					<p>Of course, none of this would be possible without our truly global, welcoming community of doers - #TeamCloudNative. I want to personally thank each and every one of you, all 178,000, for your commitment and contributions, no matter how big or small, we're on this journey together.</p>

					<p>I hope you enjoy reading about our milestones and reflecting back on the impressive progress we've achieved together this year.</p>

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
							<span>157 Projects</span><br />
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
							<span>853 Members</span><br />
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
							<span>178K Contributors</span><br />
							Fundamentally changing <br>computing
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
						<h3 class="sub-header">2022 Photo Highlights</h3>
					</div>
					<div class="wp-block-column is-vertically-aligned-bottom"
						style="flex-basis:20%">
						<p
							class="has-text-align-right is-style-link-cta"><a href="https://www.flickr.com/photos/143247548@N03/albums/with/72177720303164393" title="View the CNCF Flickr photo feed">See more</a></p>
					</div>
				</div>

				<div class="section-02__slider">
					<div>
						<?php LF_Utils::display_responsive_images( 82129, 'newsroom-post-width', '700px', null, 'lazy', 'Photo from KubeCon + CloudNativeCon Europe 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 82130, 'newsroom-post-width', '700px', null, 'lazy', 'Photo from KubeCon + CloudNativeCon North America 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 82131, 'newsroom-post-width', '700px', null, 'lazy', 'Photo from KubeCon + CloudNativeCon Europe 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 82132, 'newsroom-post-width', '700px', null, 'lazy', 'Photo from KubeCon + CloudNativeCon Europe 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 82133, 'newsroom-post-width', '700px', null, 'lazy', 'Photo from KubeCon + CloudNativeCon North America 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 82134, 'newsroom-post-width', '700px', null, 'lazy', 'Photo from KubeCon + CloudNativeCon North America 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 82135, 'newsroom-post-width', '700px', null, 'lazy', 'Photo from KubeCon + CloudNativeCon North America 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 82136, 'newsroom-post-width', '700px', null, 'lazy', 'Photo from KubeCon + CloudNativeCon North America 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 82137, 'newsroom-post-width', '700px', null, 'lazy', 'Photo from KubeCon + CloudNativeCon North America 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 82138, 'newsroom-post-width', '700px', null, 'lazy', 'Photo from KubeCon + CloudNativeCon North America 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 82139, 'newsroom-post-width', '700px', null, 'lazy', 'Photo from KubeCon + CloudNativeCon North America 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 82140, 'newsroom-post-width', '700px', null, 'lazy', 'Photo from KubeCon + CloudNativeCon North America 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 82141, 'newsroom-post-width', '700px', null, 'lazy', 'Photo from KubeCon + CloudNativeCon Europe 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 82142, 'newsroom-post-width', '700px', null, 'lazy', 'Photo from KubeCon + CloudNativeCon Europe 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 82143, 'newsroom-post-width', '700px', null, 'lazy', 'Photo from KubeCon + CloudNativeCon North America 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 82144, 'newsroom-post-width', '700px', null, 'lazy', 'Photo from KubeCon + CloudNativeCon North America 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 82145, 'newsroom-post-width', '700px', null, 'lazy', 'Photo from KubeCon + CloudNativeCon Europe 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 82146, 'newsroom-post-width', '700px', null, 'lazy', 'Photo from KubeCon + CloudNativeCon North America 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 82147, 'newsroom-post-width', '700px', null, 'lazy', 'Photo from KubeCon + CloudNativeCon North America 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 82148, 'newsroom-post-width', '700px', null, 'lazy', 'Photo from KubeCon + CloudNativeCon North America 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 82149, 'newsroom-post-width', '700px', null, 'lazy', 'Photo from KubeCon + CloudNativeCon Europe 2022' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 82150, 'newsroom-post-width', '700px', null, 'lazy', 'Photo from KubeCon + CloudNativeCon North America 2022' ); ?>
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
					<h2 class="section-header">2022 <br />
						Momentum</h2>
					<div class="section-number">1/6</div>
				</div>

				<div class="quote-with-name-container">
					<p
						class="quote-with-name-container__quote">The (KubeCon + CloudNativeCon) hallway track conversations are shifting towards adjusting to the enterprise. We had Ford on the show, Mass Mutual, ING and Home Depot. We are seeing all of these big companies that we know and love become software companies right before our eyes.</p>
					<div class="quote-with-name-container__marks">
						<p
							class="quote-with-name-container__name">Lisa Martin</p>
						<p
							class="quote-with-name-container__position">SiliconANGLE</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>CNCF is an open source software foundation dedicated to making cloud native computing ubiquitous. Since we were founded in 2015, we've pioneered cloud native technologies - <a href="https://docs.google.com/presentation/d/1UGewu4MMYZobunfKr5sOGXsspcLOH_5XeCLyOHKh9LU/edit?usp=sharing" title="See a CNCF overview">hosting and growing some of the world's most successful open source projects</a> including Kubernetes, Prometheus, Envoy, ContainerD, and <a href="https://www.cncf.io/projects/" title="See all Graduated & Incubating Projects">many others</a>.<br><br>Today we are a powerhouse for visionary projects and people, hosting <strong>157 projects</strong> with over <strong>178,000 contributors</strong> representing <strong>189 countries</strong>, and there are no signs of this growth slowing down.</p>
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

						<div class="legend-wrapper">
							<div class="legend-item">
								<div class="legend-box"></div>Contributors
							</div>
						</div>

					</div>
					<div class="section-03__intro-col2">
						<p
							class="sub-header">Member, End User & Project Growth</p>
						<div aria-hidden="true" class="report-spacer-40"></div>

						<img loading="lazy" width="550" height="400" src="
<?php LF_Utils::get_svg( $report_folder . 'member-end-user-project-growth.svg', true ); ?>
" alt="Chart showing upward trend of Members, End User and Project growth">

						<div class="legend-wrapper">
							<div class="legend-item">
								<div class="legend-box"></div>Members
							</div>
							<div class="legend-item">
								<div class="legend-box"
									style="background-color: #d72190;"></div>End
								Users
							</div>
							<div class="legend-item">
								<div class="legend-box"
									style="background-color: #87dfcf;"></div>
								Projects
							</div>
						</div>
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
						<p>The CNCF ecosystem continues to grow across vendor and end user memberships, making CNCF one of the most successful open source foundations ever. In fact, we welcomed more than 220 new members to CNCF this year.<br><br>Today, CNCF has over 850 participating organizations, including the world's largest public and private cloud companies, along with the world's most innovative software companies and end user organizations. Investment from these leading organizations signifies a strong dedication to the advancement and sustainability of cloud native computing for years to come.</p>
					</div>
					<div class="section-04__membership-col2">

						<div class="icon-box-1">
							<div class="icon">
								<img loading="lazy" width="74" height="43" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-members.svg', true ); ?>
" alt="Members icon">
							</div>
							<div class="text">
								<span>220+ new members</span><br />
								19 new members from China
							</div>
						</div>

						<div class="icon-box-1">
							<div class="icon">
								<img loading="lazy" width="51" height="64" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-building.svg', true ); ?>
" alt="Building icon">
							</div>
							<div class="text">
								<span>853 member <br>organizations</span><br />
								15% growth from 2021
							</div>
						</div>
					</div>
				</div>

			</div>
		</section>

		<section class="section-05 alignfull">

			<div class="container wrap">

				<div aria-hidden="true" class="report-spacer-120"></div>

				<p class="sub-header">CNCF Membership Growth</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-05__growth">
					<div class="section-05__growth-col1">
						<img loading="lazy" width="800" height="480" src="
<?php
LF_Utils::get_svg( $report_folder . 'CNCF-Membership-Growth.svg', true );
?>
" alt="Chart showing CNCF Membership growth with a rising trend line.">
					</div>
					<div class="section-05__growth-col2">
						<div class="section-05__growth-key">
							<img loading="lazy" width="255" height="57" src="
<?php
LF_Utils::get_svg( $report_folder . 'CNCF-Membership-Growth-increase.svg', true );
?>
" class="section-05__growth-key-image"
								alt="A 15% increase of membership growth compared to 2021">

							<div class="thin-hr section-05__growth-key-hr">
							</div>

							<p
								class="section-05__growth-key-text">Organizations that sell cloud native technologies built on, or integrated with, CNCF projects are eligible to join as general members.</p>

							<div class="wp-block-button"><a
									href="https://cncf.io/about/join/" title="Become a CNCF
Member" class="wp-block-button__link">Become a CNCF
									Member</a>
							</div>

						</div>

					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-120"></div>

			</div>
		</section>

		<section class="section-06">

			<p class="sub-header">Member Movers and Shakers</p>

			<div aria-hidden="true" class="report-spacer-60"></div>

			<div class="lf-grid section-06__members">
				<div class="section-06__members-col1">
					<p class="sub-header has-purple-text">New Gold Members</p>
					<div aria-hidden="true" class="report-spacer-60"></div>
					<div class="logo-grid smaller">

						<div class="logo-grid__box">
							<img loading="lazy" width="212" height="50" src="
<?php
LF_Utils::get_svg( $report_folder . 'member-logo-cecloud.svg', true );
?>
" alt="Cecloud Logo" class="logo-grid__image">
						</div>

						<div class="logo-grid__box">
							<img loading="lazy" width="212" height="30" src="
<?php
LF_Utils::get_svg( $report_folder . 'member-logo-china-telecom.svg', true );
?>
" alt="China Telecom Logo" class="logo-grid__image">
						</div>

						<div class="logo-grid__box">
							<img loading="lazy" width="212" height="38" src="
<?php
LF_Utils::get_svg( $report_folder . 'member-logo-coinbase.svg', true );
?>
" alt="Coinbase Logo" class="logo-grid__image">
						</div>

						<div class="logo-grid__box">
							<img loading="lazy" width="210" height="50" src="
<?php
LF_Utils::get_svg( $report_folder . 'member-logo-oppo.svg', true );
?>
" alt="Oppo Logo" class="logo-grid__image">
						</div>

						<div class="logo-grid__box">
							<img loading="lazy" width="212" height="64" src="
<?php
LF_Utils::get_svg( $report_folder . 'member-logo-isoftstone.svg', true );
?>
" alt="iSoftStone Logo" class="logo-grid__image">
						</div>

					</div>
				</div>
				<div class="section-06__members-col2">
					<p
						class="sub-header has-purple-text">New Platinum Members</p>
					<div aria-hidden="true" class="report-spacer-60"></div>

					<div class="logo-grid">

						<div class="logo-grid__box">
							<img loading="lazy" width="290" height="66" src="
<?php
LF_Utils::get_svg( $report_folder . 'member-logo-boeing.svg', true );
?>
" alt="Boeing Logo" class="logo-grid__image">
						</div>

					</div>

				</div>

			</div>

		</section>

		<section class="section-07 alignfull background-image-wrapper">

			<figure class="background-image-figure">
				<?php
				LF_Utils::display_responsive_images( 82112, 'full', '1200px', null, 'lazy', 'Audience at KubeCon + CloudNativeCon North America 2022' );
				?>
			</figure>

			<div class="background-image-text-overlay">
				<div class="container wrap">

					<div aria-hidden="true" class="report-spacer-120"></div>

					<div class="quote-with-name-container">
						<p
							class="quote-with-name-container__quote">The cloud native ecosystem is getting bigger and better; end users' trust in open source is steering it forward!</p>
						<div class="quote-with-name-container__marks">
							<p
								class="quote-with-name-container__name">Aparna Subramanian</p>
							<p
								class="quote-with-name-container__position">Director of Production Engineering, Shopify</p>
						</div>
					</div>

					<div aria-hidden="true" class="report-spacer-120"></div>

				</div>
			</div>
		</section>

		<section class="section-08">

			<h2 class="section-header">End User Community</h2>

			<div aria-hidden="true" class="report-spacer-60"></div>

			<div class="lf-grid section-08__grid">
				<div class="section-08__grid-col1">
					<p>End Users within the Cloud Native Computing Foundation (CNCF) are member companies that use cloud native technologies internally, do not sell any cloud native services externally, and aren't vendors, consultancies, training partners, or telecommunications companies.<br><br>Individuals within end user companies are passionate about solving problems using cloud native architectures and providing teams with self-service solutions which create a more inclusive, iterative process.</p>
				</div>
				<div class="section-08__grid-col2">

					<div class="icon-box-1">
						<div class="icon">
							<img loading="lazy" width="53" height="54" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-like.svg', true ); ?>
" alt="Like icon">
						</div>
						<div class="text">
							<span>100%</span><br />
							would recommend CNCF to other companies (<a href="https://github.com/cncf/surveys/tree/main/enduser/2022" title="See End User Sruvey results">
								2022 End
								User survey
							</a>)
						</div>
					</div>

					<div class="icon-box-1">
						<div class="icon">
							<img loading="lazy" width="74" height="43" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-members.svg', true ); ?>
" alt="Members icon">
						</div>
						<div class="text">
							<span>170</span><br />
							End User Members
						</div>
					</div>

				</div>
			</div>

			<div aria-hidden="true" class="report-spacer-120"></div>

			<picture>
				<source media="(max-width: 599px)"
					srcset="<?php echo esc_url( wp_get_attachment_image_url( '82815', 'full', false ) ); ?>">
				<source media="(min-width: 600px)"
					srcset="<?php echo esc_url( wp_get_attachment_image_url( '82814', 'full', false ) ); ?>">
				<?php
				LF_Utils::display_responsive_images(
					'82814',
					'full',
					'1200px',
					null,
					'lazy',
					'We were thrilled to grant Intuit our Top End User Award this year in recognition of their notable contributions to the cloud native ecosystem.'
				);
				?>
			</picture>

			<div aria-hidden="true" class="report-spacer-100"></div>

			<div class="quote-with-name-container">
				<p
					class="quote-with-name-container__quote">CNCF has become an embodiment of the <strong>spirit of open source, the spirit of freedom</strong> and choice, and at the same time has become synonymous with <strong>high quality cloud software</strong>. Every time we have requirements to build software for our Cloud Infrastructure, <strong>the first thing we do is go to the CNCF landscape</strong> and evaluate the choices available.</p>
				<div class="quote-with-name-container__marks">
					<p class="quote-with-name-container__name">Madhu CS</p>
					<p class="quote-with-name-container__position">Robinhood</p>
				</div>
			</div>
		</section>

		<section class="section-09 alignfull">

			<div class="container wrap">

				<div aria-hidden="true" class="report-spacer-120"></div>

				<p class="sub-header">CTO Summit</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-09__cto">
					<div class="section-09__cto-col1">
						<p>As teams adopt cloud native strategies, it's clear that there is no "one size fits all" solution to the challenges organizations face. That's why, in 2022, CNCF launched the CTO Summit. This Chatham House-governed summit convenes CTOs from end user enterprises to discuss how organizations can leverage people, processes, and technologies to improve resiliency in cloud native computing.</p>

						<div aria-hidden="true" class="report-spacer-40"></div>

						<div class="quote-with-name-container">
							<p
								class="quote-with-name-container__quote">We've started this CTO Summit where end users, like Boeing, Fidelity, Intuit, and many others can come together and have a private conversation about how they are handling technical challenges in their organizations. Often the most impactful lessons come from our peers.</p>
							<div class="quote-with-name-container__marks">
								<p
									class="quote-with-name-container__name">Priyanka Sharma</p>
								<p
									class="quote-with-name-container__position">Executive Director, CNCF</p>
							</div>

						</div>
					</div>

					<div class="section-09__cto-col2">

						<a href="https://www.cncf.io/reports/cto-summit-eu-2022/"
							title="Read the CTO Summit report">
							<?php
							LF_Utils::display_responsive_images(
								'78054',
								'large',
								'500px',
								'ds',
								'lazy',
								'CTO Summit Report - KubeCon + CloudNativeCon Europe 2022'
							);
							?>
						</a>

						<div aria-hidden="true" class="report-spacer-40">
						</div>

						<div class="wp-block-button"><a
								href="https://www.cncf.io/reports/cto-summit-eu-2022/"
								title="Read the CTO Summit report"
								class="wp-block-button__link fit-content">View
								Report</a>
						</div>

						<div class="thin-hr section-09__cto-hr"></div>

						<p><strong>Coming January 2023</strong><br>KubeCon + CloudNativeCon North America <br>CTO Summit Report</p>

					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-120"></div>

			</div>
		</section>

		<section class="section-10">

			<p class="sub-header">The new CNCF.io</p>

			<div aria-hidden="true" class="report-spacer-60"></div>

			<div class="lf-grid">
				<div class="restrictive-9-col">
					<p>In May we launched the redesigned and rebuilt <a href="https://www.cncf.io">CNCF.io</a>. The site increases focus on representing the community in more effective, vibrant, and interactive ways. It provides additional areas to share CNCF and End User content, events, news, and blog articles. It also features improved UX and navigation, thanks to the dynamic mega menu and simplified navigation throughout. Importantly, we're doubling down on accessibility - following the <a href="https://www.cncf.io/accessibility-statement/">Web Content Accessibility Guidelines (WCAG) 2.1</a> and aiming for Level AA accessibility on CNCF.io. Throughout the year we rolled out the new design to CNCF subsites, including <a href="https://contribute.cncf.io">Contributors</a>, as well as applying WCAG guidelines to all of our sites. </p>
				</div>
			</div>

			<div aria-hidden="true" class="report-spacer-60"></div>

			<div class="lf-grid">
				<div class="restrictive-9-col">
					<?php
					LF_Utils::display_responsive_images( 82217, 'full', '920px', null, 'lazy', 'The CNCF.io website on various websites' );
					?>
				</div>
			</div>

			<div class="shadow-hr"></div>

			<p class="sub-header">Humans Of Cloud Native</p>

			<div aria-hidden="true" class="report-spacer-60"></div>

			<div class="lf-grid">
				<div class="restrictive-9-col">
					<p>At the heart of CNCF is our welcoming community of doers, working together to make cloud native ubiquitous. This year we launched the <a href="https://www.cncf.io/humans-of-cloud-native/" title="View Humans of Cloud Native">Humans of Cloud Native</a> project to tell the stories of amazing individuals and their contributions that make team cloud native such a vibrant, exciting and diverse space.</p>
				</div>
			</div>

			<div aria-hidden="true" class="report-spacer-60"></div>

			<div class="banner">
				<?php
				LF_Utils::display_responsive_images( 82169, 'full', '800px', 'banner__image', 'lazy', 'Attendees at KubeCon + CloudNativeCon North America 2022' );
				?>
				<div class="banner__title-wrapper">
					<h2 class="banner__title">Join our amazing set of humans!
					</h2>
				</div>
				<div class="banner__text-wrapper">
					<p class="banner__text">Do you know somebody doing
						incredible things in the cloud native ecosystem?<br><br>
						<strong>Nominate them for the Humans of Cloud Native</strong></p>
					<div class="wp-block-button"><a href="mailto:humans@cncf.io"
							title="Send an email your nomination"
							class="wp-block-button__link fit-content">Nominate</a>
					</div>
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

				<div class="quote-with-name-container">
					<p
						class="quote-with-name-container__quote">Having seen what KubeCon has to offer, I'm sorry I missed every previous KubeCon since (they began in) 2015. For a veteran cloud blogger, this conference is a peek into the future of distributed development.</p>
					<div class="quote-with-name-container__marks">
						<p
							class="quote-with-name-container__name">Ofir Nachmani</p>
						<p
							class="quote-with-name-container__position">IamOnDemand</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<?php
				LF_Utils::display_responsive_images(
					'82113',
					'full',
					'1200px',
					null,
					'lazy',
					'Some of the crowd at KubeCon + CloudNativeCon North America 2022'
				);
				?>
				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>This year we welcomed our community safely back to in-person events. At the same time, CNCF continued to double down on digital, offering virtual access to all our major events to provide opportunities for collaboration, learning, and networking from every corner of the globe.</p>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<h2 class="section-header">Kubernetes <br
						class="show-over-1000">Community Days</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>In response to the cloud native community's evolving needs in different regions, CNCF strengthened the <a href="https://kubernetescommunitydays.org/">Kubernetes Community Days (KCD)</a> program this year. KCDs are community-organized events that gather adopters and technologists to learn, collaborate, and network, with a goal of furthering the adoption and improvement of Kubernetes and cloud native technologies around the world.</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="lf-grid section-11__kcd">
					<div class="section-11__kcd-col1">

						<div class="icon-layout">

							<div class="icon-box-1">
								<div class="icon">
									<img loading="lazy" width="57" height="63"
										src="
<?php LF_Utils::get_svg( $report_folder . 'icon-lanyard-p.svg', true ); ?>
" alt="Lanyard icon">
								</div>
								<div class="text">
									<span>16 KCDs</span><br />
									In-person, virtual and hybrid
									<div class="text-smaller">An increase of
										<strong>33%</strong> from 2021
									</div>
								</div>
							</div>
							<div class="icon-box-1">
								<div class="icon">
									<img loading="lazy" width="57" height="44"
										src="
<?php LF_Utils::get_svg( $report_folder . 'icon-megaphone-p.svg', true ); ?>
" alt="Megaphone icon">
								</div>
								<div class="text">
									<span>Presentations</span><br />
									in multiple languages
									<div class="text-smaller">(English, Slavic,
										Chinese, Spanish, Italian, <br
											class="show-over-1000">and
										Indonesian)
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="section-11__kcd-col2">

						<div class="icon-layout">

							<div class="icon-box-1">
								<div class="icon">
									<img loading="lazy" width="74" height="42"
										src="
<?php LF_Utils::get_svg( $report_folder . 'icon-members-p.svg', true ); ?>
" alt="Members icon">
								</div>
								<div class="text">
									<span>6,500+ attendees</span><br />
									An increase of <strong>85%</strong> from
									2021
									<div class="text-smaller">&nbsp;
									</div>
								</div>
							</div>
							<div class="icon-box-1">
								<div class="icon">
									<img loading="lazy" width="71" height="74"
										src="
<?php LF_Utils::get_svg( $report_folder . 'icon-globe-p.svg', true ); ?>
" alt="Globe icon">
								</div>
								<div class="text">
									<span>14 Countries</span><br />
									Across the globe
									<div class="text-smaller">&nbsp;
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">KCD Evolution</p>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>We also implemented additional measures to help support our KCD communities and organizers to ensure program success:</p>

						<ul>
							<li>
								Our organizer terms and conditions in the KCD
								GitHub repository were updated to include new
								provisions in addition to the pre-existing
								requirement of organizers to take the <a
									href="https://training.linuxfoundation.org/training/inclusive-open-source-community-orientation-lfc102/">Inclusive Open Source Community
									Orientation</a>. The new terms are as
								follows:

								<ul style="margin-left: 20px; margin-top: 20px; margin-bottom: 20px;">
									<li>Agree to ensure the final program
										schedule is diverse (e.g., not all
										speakers of one gender, one culture, or
										age)</li>
									<li>To assure a diverse lineup, you must
										send a copy of your program to <a
											href="mailto:kcd@cncf.io">kcd@cncf.io</a>
										for review and approval before
										publication.</li>
									<li>Organizers will ensure the speaker
										lineup is diverse in terms of companies
										represented.</li>
								</ul>

							</li>
							<li>We encourage KCD organizers to consider and
								include talks that are non-technical and
								non-code contributions.</li>
							<li>In July, we started hosting a one-hour monthly
								organizer meeting with topics to help guide
								organizers during their planning process.
								August's topic was “How to Curate a Diverse
								Lineup.” This meeting featured resources and
								recommendations for organizers on how to build
								and recruit diversity within their schedules. <a href="https://docs.google.com/presentation/d/1fzT_BdavVKh3mnxxU-PBWyJq9JUfasKwHqekkbYVbw8/edit#slide=id.g56245ab439_0_106">We
									provide slides</a>, as well as <a href="https://www.youtube.com/watch?v=E46lH_eJwRM&feature=youtu.be">recording the
									session</a>.</li>
						</ul>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<h2 class="section-header">Code of Conduct <br
						class="show-over-1000">Process Improvements</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>When we returned to having in-person events, both the number and severity of Code of Conduct incidents increased. Our increased focus on Code of Conduct highlighted the need to modernize our processes, which had previously been entirely foundation-managed, by including community representation and providing greater transparency. As a result, this year:</p>

						<div aria-hidden="true" class="report-spacer-20"></div>

						<ul>
							<li>We launched a <a href="https://www.cncf.io/blog/2022/10/13/the-cncf-code-of-conduct-working-group-has-launched/">Code of Conduct
									Working Group</a> to develop an updated
								structure and set of procedures. Their work is
								ongoing, and anyone in the community is welcome
								to participate and contribute. <a
									href="https://github.com/cncf/wg-coc">Visit
									the working group's repository</a> to
								participate, view progress, and learn more.</li>
							<div aria-hidden="true" class="report-spacer-20">
							</div>
							<li>We also launched an <a href="https://www.cncf.io/blog/2022/06/23/cncfs-interim-cncf-code-of-conduct-committee-has-launched/">Interim Code of
									Conduct Committee</a> - composed of both
								community members and staff-to adjudicate
								incidents while a more permanent structure is
								under development by the working group. The <a
									href="https://www.cncf.io/conduct/procedures/">Incident Resolution Procedures</a>
								that the committee is operating under were
								published earlier this year and finalized after
								a public comment period.</li>
						</ul>
					</div>
				</div>

			</div>
		</section>

		<section class="section-12 is-style-down-gradient alignfull">

			<div class="container wrap">

				<h2 class="section-header">KubeCon + <br
						class="show-over-1000">CloudNativeCon Europe</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>KubeCon + CloudNativeCon Valencia was the first time we'd gathered #TeamCloudNative in Europe for three years and the atmosphere felt electric. In fact, we had a lot of firsts in Valencia. Boeing joined us as a platinum member - the first aerospace organization to join CNCF. We hosted <a href="https://events.linuxfoundation.org/cloud-native-telco-day-europe/">Cloud Native Telco Day</a> for the first time, gathering huge players like Deutsche Telekom and Orange who are advancing the industry. Plus, we hosted our first <a href="https://www.cncf.io/reports/cto-summit-eu-2022/">CTO Summit</a> where we discussed how organizations achieve resiliency in multi-cloud strategies.</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<?php
				LF_Utils::display_responsive_images(
					'82189',
					'full',
					'1200px',
					null,
					'lazy',
					'Welcome to KubeCon + CloudNativeCon Europe 2022'
				);
				?>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<p class="sub-header">Attendee Demographics</p>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<figure class="section-12__flowers">
					<img width="708" height="821" loading="lazy" src="
<?php
Lf_Utils::get_image( $report_folder . 'motif.png' );
?>
" alt="Background flower">
				</figure>

				<picture>
					<source media="(max-width: 599px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'eu-attendees-mobile.svg', true );
?>
">
					<source media="(min-width: 600px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'eu-attendees-desktop.svg', true );
?>
">
					<img width="1100" height="364" src="
<?php
Lf_Utils::get_svg( $report_folder . 'eu-attendees-desktop.svg', true );
?>
" alt="Showing 18,550 Registered attendees of which 45.2% were men, 6.5% women, 0.4% non-binary/other, and 47.9% preferred not to answer. Of the attendees 7.084 (38%) were in person, 11,466 (62%) were virtual. 65% of visitors were first timers."
						loading="lazy">
				</picture>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<p class="sub-header">Content</p>

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
								<span class="number">1,187</span><br />
								<span class="description">Submissions</span>
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
								<span class="number">243</span><br />
								<span class="description">Speakers</span>
							</div>
						</div>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">Top Countries In Attendance</p>

				<div class="lf-grid section-12__top-countries">
					<div class="section-12__top-countries-col1">
						<p class="section-12__header">Total</p>

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
								<span class="number">3.035</span>
							</div>
						</div>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon">
								<img loading="lazy" width="45" height="45" src="
<?php
LF_Utils::get_svg( $report_folder . 'icon-flag-germany.svg', true );
?>
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
								<img loading="lazy" width="45" height="45" src="
<?php
LF_Utils::get_svg( $report_folder . 'icon-flag-india.svg', true );
?>
" alt="Indian Flag">
							</div>
							<div class="text">
								<span class="country">India</span><br />
								<span class="number">1,798</span>
							</div>
						</div>

					</div>
					<div class="section-12__top-countries-col2">
						<p class="section-12__header">In-person</p>

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
								<span class="number">1,309</span>
							</div>
						</div>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon">
								<img loading="lazy" width="45" height="45" src="
<?php
LF_Utils::get_svg( $report_folder . 'icon-flag-germany.svg', true );
?>
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
								<img loading="lazy" width="45" height="45" src="
<?php
LF_Utils::get_svg( $report_folder . 'icon-flag-uk.svg', true );
?>
" alt="UK Flag">
							</div>
							<div class="text">
								<span class="country">United
									Kingdom</span><br />
								<span class="number">725</span>
							</div>
						</div>
					</div>
					<div class="section-12__top-countries-col3">
						<p class="section-12__header">Virtual</p>

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
								<span class="number">1,725</span>
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
								<span class="number">1,702</span>
							</div>
						</div>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon">
								<img loading="lazy" width="45" height="45" src="
<?php
LF_Utils::get_svg( $report_folder . 'icon-flag-germany.svg', true );
?>
" alt="German Flag">
							</div>
							<div class="text">
								<span class="country">Germany</span><br />
								<span class="number">1,403</span>
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

						<div class="wp-block-button"><a href="https://www.cncf.io/reports/kubecon-cloudnativecon-europe-2022/"
								title="Read the KubeCon + CloudNativeCon Europe 2022 Transparency Report"
								class="wp-block-button__link fit-content">View
								Report</a>
						</div>

					</div>
					<div class="section-12__report-col2">
						<a href="https://www.cncf.io/reports/kubecon-cloudnativecon-europe-2022/">
							<?php
							LF_Utils::display_responsive_images( 73896, 'large', '500px', 'ds', 'lazy', 'Cover of the KubeCon + CloudNativeCon Europe 2022 Transparency Report' );
							?>
						</a>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">Video Highlights</p>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="wp-block-lf-youtube-lite">
					<lite-youtube videoid="SqesB4xcAUY"
						videotitle="Highlights from KubeCon + CloudNativeCon Europe 2022"
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

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>KubeCon + CloudNativeCon North America marked the first time we'd gathered in such big numbers in the Midwest, and Detroit was a wonderful host city. We launched a number of new initiatives, including <a href="https://community.cncf.io/cloud-native-security-slam/">Security Slam</a>, in partnership with <a href="https://www.sonatype.com/">Sonatype</a>. There were also some special surprises at KubeCon + CloudNativeCon, including welcoming our Senior Developer Advocate Ihor Dvoretskyi back in-person, who was granted short-term leave from serving in the Ukraine military.</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<?php
				LF_Utils::display_responsive_images(
					'82116',
					'full',
					'1200px',
					null,
					'lazy',
					'Presenters on stage at KubeCon + CloudNativeCon North America 2022'
				);
				?>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<p class="sub-header">Attendee Demographics</p>

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

				<p class="sub-header">Content</p>

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
								<span class="number">1,551</span><br />
								<span class="description">Submissions</span>
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
								<span class="number">531</span><br />
								<span class="description">Speakers</span>
							</div>
						</div>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">Top Countries In Attendance</p>

				<div class="lf-grid section-12__top-countries">
					<div class="section-12__top-countries-col1">
						<p class="section-12__header">Total</p>

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
					<div class="section-12__top-countries-col2">
						<p class="section-12__header">In-person</p>

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
					<div class="section-12__top-countries-col3">
						<p class="section-12__header">Virtual</p>

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

				<div class="shadow-hr"></div>

				<div class="lf-grid section-12__report">
					<div class="section-12__report-col1">

						<p class="sub-header">Have a look at the full details in our
transparency report</p>

						<div aria-hidden="true" class="report-spacer-40"></div>

						<div class="wp-block-button"><a href="https://www.cncf.io/reports/kubecon-cloudnativecon-north-america-2022-transparency-report/"
								title="Read the KubeCon + CloudNativeCon North America 2022 Transparency Report"
								class="wp-block-button__link fit-content">View
								Report</a>
						</div>

					</div>
					<div class="section-12__report-col2">

						<a href="https://www.cncf.io/reports/kubecon-cloudnativecon-north-america-2022-transparency-report/">
							<?php
							LF_Utils::display_responsive_images( 81929, 'large', '500px', 'ds', 'lazy', 'Cover of the KubeCon + CloudNativeCon North America 2022 Transparency Report' );
							?>
						</a>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">Video Highlights</p>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="wp-block-lf-youtube-lite">
					<lite-youtube videoid="Q1cA0iGw84g"
						videotitle="Highlights from KubeCon + CloudNativeCon North America 2022"
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
						class="opening-paragraph restrictive-10-col">CNCF strengthened our commitment to growing the cloud native ecosystem in 2022 - expanding our globally recognized certifications, boosting employment opportunities and helping more folks to upskill their practical application of cloud native technologies.</p>
				</div>

				<div class="lf-grid">
					<div class="restrictive-10-col">
						<p>This year we launched the <a href="https://training.linuxfoundation.org/certification/prometheus-certified-associate/">Prometheus Certified Associate (PCA)</a> - a certification that demonstrates and engineers foundational knowledge of observability and skills using Prometheus, the open source monitoring and alerting toolkit.<br><br>A new set of credentials were also launched this year: <a href="https://training.linuxfoundation.org/blog/skillcreds/">SkillCreds</a>. These allow learners to gain credentials on specific topics related to their experience. Two of the first SkillCreds include <a href="https://training.linuxfoundation.org/certification/helm/">Developing Helm Charts (SC104)</a> and <a href="https://training.linuxfoundation.org/certification/yaml/">Open Data Formats: YAML (SC101)</a>. These micro-credentials are short, topic-specific, and cost effective.<br><br>The importance of training and certifications, and the regard that CNCF courses are held in, was highlighted this year in China where foreign nations are able to <a href="https://training.linuxfoundation.cn/news/294">apply for visas for Beijing if they earn a CKA certification</a>. </p>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<h2 class="section-header">2022 Training <br
						class="show-over-1000">Courses</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-14__intro">
					<div class="section-14__intro-col1">
						<p>CNCF's training and certification program continued to grow. In 2022, these training courses and exams received considerable interest:</p>
					</div>
					<div class="section-14__intro-col2">
						<img width="582" height="124" loading="lazy" src="
<?php
Lf_Utils::get_image( $report_folder . 'training-logos.png' );
?>
" alt="Cloud native training courses from LF">

					</div>

				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="lf-grid section-14__courses">

					<div class="course-box">
						<span class="course-box__number">25%</span>
						<span class="course-box__text">Increase</span>
						<div class="thin-hr course-box__hr"></div>
						<p
							class="course-box__description"><a href="https://www.cncf.io/certification/training/#introduction">Kubernetes Massively Open Online Course (MOOC)</a> hit 290,000 enrollments</p>
					</div>

					<div class="course-box">
						<span class="course-box__number">49%</span>
						<span class="course-box__text">Increase</span>
						<div class="thin-hr course-box__hr"></div>
						<p
							class="course-box__description"><a href="https://www.cncf.io/certification/expert/">Certified Kubernetes Administrator (CKA)</a> exam hit 104,000 enrollments</p>
					</div>

					<div class="course-box">
						<span class="course-box__number">44%</span>
						<span class="course-box__text">Increase</span>
						<div class="thin-hr course-box__hr"></div>
						<p
							class="course-box__description"><a href="https://www.cncf.io/certification/ckad/">Certified Kubernetes Application Developer (CKAD)</a> hit 49,000 exam registrations</p>
					</div>

					<div class="course-box">
						<span class="course-box__number">113%</span>
						<span class="course-box__text">Increase</span>
						<div class="thin-hr course-box__hr"></div>
						<p
							class="course-box__description"><a href="https://www.cncf.io/certification/cks/">Certified Kubernetes Security Specialist (CKS)</a> exam hit 18,000 registrations</p>
					</div>
					<div class="course-box">
						<span class="course-box__number">4,000</span>
						<span class="course-box__text">Registrations</span>
						<div class="thin-hr course-box__hr"></div>
						<p
							class="course-box__description"><a href="https://www.cncf.io/certification/kcna/">Kubernetes and Cloud Native Associate (KCNA)</a> exam hit 4,000 registrations (since its launch in November 2021)</p>
					</div>
					<div class="course-box">
						<span class="course-box__number">280+</span>
						<span class="course-box__text">Registrations</span>
						<div class="thin-hr course-box__hr"></div>
						<p
							class="course-box__description"><a href="https://www.cncf.io/certification/pca/">Prometheus Certified Associate (PCA)</a> exam hit 280+ registrations (since its launch on September 8, 2022)</p>
					</div>
					<div class="course-box">
						<span class="course-box__number">14%</span>
						<span class="course-box__text">Increase</span>
						<div class="thin-hr course-box__hr"></div>
						<p
							class="course-box__description"><a href="https://cncf.io/certification/kubernetes-training-partners/">Kubernetes Training Partner (KTP)</a> program grew to 57 certified companies</p>
					</div>
					<div class="course-box">
						<span class="course-box__number">8.5%</span>
						<span class="course-box__text">Increase</span>
						<div class="thin-hr course-box__hr"></div>
						<p
							class="course-box__description"><a href="https://www.cncf.io/certification/kcsp/">Kubernetes Certified Service Provider (KCSP)</a> program grew to 254 companies</p>
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
						class="opening-paragraph restrictive-10-col">Throughout 2022, CNCF underscored our commitment to making cloud native ubiquitous - hosting <a href="https://www.cncf.io/projects/">20 graduated projects</a>, <a href="https://www.cncf.io/projects/">35 incubating</a> and <a href="https://www.cncf.io/sandbox-projects/">102 sandbox projects</a>, driven by more than <strong>178,000 contributors</strong> representing <strong>189 countries</strong>.</p>
				</div>

				<p class="sub-header">Projects Accepted Over Time</p>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<?php echo do_shortcode( '[projects-maturity-chart]' ); ?>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="lf-grid">
					<p
						class="restrictive-10-col">The <a href="https://www.cncf.io/people/technical-oversight-committee/">Technical Oversight Committee</a> doubled down on cloud native security in 2022, and approved the formation of a new Technical Advisory Group, TAG Environmental Sustainability focusing on carbon outputs around cloud native computing.</p>
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
						<p>CNCF conducted a number of <a href="https://www.cncf.io/blog/2022/08/08/improving-cncf-security-posture-with-independent-security-audits/">open source security audits</a> throughout 2022, in strategic partnership with the <strong>Open Source Technology Improvement Fund (OSTIF)</strong>. A number of projects completed security audits, resulting in 132 security fixes and improvements, <strong>45 CVE's fixed</strong>, and <strong>51 security tools built</strong>. We also announced the inaugural <a href="https://events.linuxfoundation.org/cloud-native-securitycon-north-america/">CloudNative SecurityCon</a>, which will launch in 2023, and bring application developers and modern security experts not just propose solutions that incrementally improve what has come before, but to give room to cutting edge projects and advances in modern security approaches.

						<br><br>Furthermore, <a href="https://www.cncf.io/blog/2022/06/28/improving-security-by-fuzzing-the-cncf-landscape/">CNCF funded fuzzing audits</a> for a variety of projects that have resulted in hundreds of bugs being found.</p>

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
" alt="Checlist icon">
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
						<p>CNCF's footprint in the Telecom domain increased throughout 2022. In May, the <a href="https://www.cncf.io/certification/cnf/">Cloud Native Network Function (CNF) Certification Program (beta)</a> was announced to help Communication Service Providers (CSPs) validate how well their vendors' products follow cloud native principles, and to advise vendors on following cloud native best practices. This is supported by CSPs like Vodafone, Deutsche Telekom and DISH Wireless, and guided by best practices from the <a href="https://github.com/cncf/cnf-wg">Cloud Native Network Function (CNF) Working Group</a> and runs certification tests on the <a href="https://github.com/cncf/cnf-testsuite">CNF Test Suite</a>.</p>
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
						<p>Significant progress has been made in 2022 towards the goal of 100% conformance test coverage of the Kubernetes API, managed through <a href="https://apisnoop.cncf.io/about">APISnoop</a> - a community-driven project spearheaded by long-time CNCF contributor and community leader <a href="https://twitter.com/hippiehacker">Hippie Hacker</a>, which tracks the testing and conformance coverage of Kubernetes by analyzing the audit logs created by e2e test runs.</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<p>At the start of 2022 there were 85 untested endpoints remaining. </p>

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
						<p>At the same time 26 endpoints have been identified as being ineligible for conformance testing and <a href="https://apisnoop.cncf.io/conformance-progress/ineligible-endpoints">move to the ineligible endpoints list</a>. By the end of 2022 only <a href="https://apisnoop.cncf.io/conformance-progress/endpoints/1.26.0/?filter=untested">10 endpoints</a> (2.5%) remain untested. We anticipate cleaning up the last <a href="https://apisnoop.cncf.io/conformance-progress">technical debt</a> by Kubecon + CloudNativeCon Europe 2023.

						<br><br>The automation for CNCF Kubernetes Conformance Certification repo has been updated for an <a href="https://www.cncf.io/blog/2022/10/19/kubernetes-conformance-updates-for-october-2022/">enhanced user experience</a> with improved functionality under the hood. The CNCF-CI bot also gives more detailed explanations of requirements when a submission fails and supporting documentation has also been improved. These changes help to reduce the complexity of reviewing and approving Kubernetes conformance submissions.</p>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<h2 class="section-header">Project Moves</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<p class="sub-header">CNCF PROJECTS ACCEPTED</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<p>In 2022, the <a href="https://github.com/cncf/toc">CNCF TOC</a> accepted 35 new projects:</p>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<img loading="lazy" width="1200" height="500" src="
<?php LF_Utils::get_svg( $report_folder . 'projects-accepted-2022.svg', true ); ?>
" alt="Chart showing projects accepted by year - 2022 had 35 new projects accepted">

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
					class="sub-header">In 2022, two projects donated characters</p>

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
						<p>This year CNCF helped launch two documentary films that supported our mission to humanize developers by telling their story of development in this dynamic medium. In January 2022,  <a href="https://youtu.be/BE77h7dmoQU">The Origins of Kubernetes</a> debuted on YouTube. The two part documentary has since garnered a combined 463,000 views and continues to attract viewers from across the world.</p>
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
						<p><a href="https://youtu.be/rT4fJNbfe14">Inside Prometheus</a> debuted in October 2022 at Prometheus Day North America as part of KubeCon + CloudNativeCon NA and has so far garnered 59,000 views on YouTube. Both films succeed in giving a voice and face to the forward-looking engineers who tackled adversity and technical challenges in their quest to change the way we work and live today.</p>
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
						class="restrictive-9-col">We doubled down on our commitment to #TeamCloudNative in 2022, investing in community-driven initiatives to fuel sustained momentum, expansion, growth and adoption. Importantly, we continued to sharpen focus on our DEI initiatives, ensuring that the ecosystem is a welcoming place where everybody can thrive.</p>
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
					class="sub-header">Women And Gender Non-Conforming Speakers - 2022</p>

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
									at <a href="https://events.linuxfoundation.org/archive/2022/kubecon-cloudnativecon-europe/">KubeCon + CloudNativeCon
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

						<p>To recognize contributors who spend countless hours completing often mundane tasks, CNCF created the “<strong>Chop Wood and Carry Water</strong>” awards. CNCF was proud to acknowledge the amazing efforts of five individuals for their outstanding contributions in 2022:</p>
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
						<p>2022 saw the cloud native community switch from the Meetup platform to <a href="https://community.cncf.io/">Cloud Native Community Groups</a> and the new platform has taken off. It has become the singular place where meetups, online programs, project office hours, and community events are run. The platform now hosts over 31,500 unique chapter members and we are excited to see this platform continue to grow.</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<p class="sub-header">Community Groups 2022</p>

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
						class="opening-paragraph restrictive-10-col">CNCF worked closely in partnership with individual contributors and community groups throughout 2022, developing programs to navigate and manage the fast-growing ecosystem - rising to meet the growing global demand for cloud native technologies.</p>
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
						<p>CNCF proudly supported more than 100 individuals through various <a href="https://github.com/cncf/mentoring">mentoring and internship opportunities</a> in 2022, including the <a href="https://lfx.linuxfoundation.org/tools/mentorship">LFX mentorship platform</a>, <a href="https://summerofcode.withgoogle.com/">Google Summer of Code (GSoC)</a>, <a href="https://developers.google.com/season-of-docs">Google Summer of Docs (GSoD)</a> program, and <a href="https://www.outreachy.org/">Outreachy</a>. These programs are important catalysts for internships to have an impact on future technologies that we all depend on.<br><br>
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
							class="thanks__opening">We hope you enjoyed reflecting on all the great things we accomplished together in 2022.</p>

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
	'annual-report-22',
	get_template_directory_uri() . '/source/js/on-demand/annual-report-22.js',
	array( 'jquery', 'slick' ),
	filemtime( get_template_directory() . '/source/js/on-demand/annual-report-22.js' ),
	true
);

get_template_part( 'components/footer' );
