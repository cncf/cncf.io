<?php
/**
 * Template Name: Argo PJR 2022
 * Template Post Type: lf_report
 *
 * File for the Argo PJR 2022
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

// Report folder in images/ folder.
$report_folder = 'reports/argo-pjr-22/';

get_template_part( 'components/header' );

?>

<link rel="prefetch"
	href="<?php echo esc_url( get_template_directory_uri() . '/build/argo-pjr-22.min.css' ); ?>"
	as="style" crossorigin="anonymous" />

<?php

wp_enqueue_style( 'argo-pjr-22', get_template_directory_uri() . '/build/argo-pjr-22.min.css', array(), filemtime( get_template_directory() . '/build/argo-pjr-22.min.css' ), 'all' );

// setup sharing icons data..
$caption  = 'Read the Argo Project Report ';
$page_url = rawurlencode( get_permalink() );
$caption  = htmlspecialchars( rawurlencode( html_entity_decode( $caption, ENT_COMPAT, 'UTF-8' ) ), ENT_COMPAT, 'UTF-8' );
$options  = get_option( 'lf-mu' );
$options && $options['social_twitter_handle'] ? $twitter = $options['social_twitter_handle'] : $twitter = '';
$twitter_url  = 'https://twitter.com/intent/tweet?text=' . $caption . '&amp;url=' . $page_url . '&amp;hashtags=cncf&amp;via=' . $twitter . '';
$linkedin_url = 'https://www.linkedin.com/shareArticle?mini=true&url=' . $page_url . '&summary=' . $caption;
$mailto_url   = 'mailto:?subject=' . $caption . '&body=' . $caption . '&nbsp;' . $page_url;
?>

<?php

get_template_part( 'components/skip-link-target' );
?>

<main class="argo-pjr-22">
	<article class="container wrap">

		<section class="hero">
			<div class="title-wrapper">
				<?php
				get_template_part( 'components/title-links' );
				?>
			</div>
			<div class="hero__container">
				<img class="hero__logo"
					src="<?php LF_Utils::get_svg( $report_folder . 'argo-horizontal-color.svg', true ); ?>"
					width="317" height="147" alt="Argo logo" loading="eager">

				<div aria-hidden="true" style="height: 20px"></div>

				<div class="lf-grid hero__grid">
					<div class="hero__grid-col1">
						<h1 class="hero__title">Project Journey Report</h1>
					</div>
					<div class="hero__grid-col2">
						<div class="social-share">
							<p class="social-share__title">Share</p>

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
								<a aria-label="Share by Email"
									title="Share by Email"
									href="<?php echo esc_url( $mailto_url ); ?>"><?php Lf_Utils::get_svg( 'reports/social-mail.svg' ); ?></a>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="thin-hr"></div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid hero__grid">
					<div class="hero__grid-col1 published">
						<?php Lf_Utils::get_svg( $report_folder . 'icon-calendar.svg' ); ?>
						<span>Published: <?php the_date(); ?></span>
					</div>
					<div class="hero__grid-col2 project-website">
						<?php Lf_Utils::get_svg( $report_folder . 'icon-globe.svg' ); ?>
						<a title="Argo Project website"
							href="https://argoproj.github.io">argoproj.github.io</a>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="thin-hr"></div>

				<div aria-hidden="true" class="report-spacer-100"></div>
			</div>
		</section>

		<section class="section-01">
			<div class="lf-grid section-01__grid">
				<div class="section-01__grid-col1">
					<h2 class="section-01__title uppercase">Introduction</h2>
					<p>Argo is a collection of four independent GitOps focused open-source tools - Argo Workflows, Argo CD, Argo Rollouts, and Argo Events — that help development and DevOps teams use GitOps fundamentals to run Kubernetes workflows and manage their clusters.</p>

					<p>Argo Workflows began at Applatix — later acquired by Intuit — as a framework for designing and orchestrating parallel jobs using a Kubernetes CRD. Argo CD takes a declarative and version-controlled GitOps approach, with massive success stories, like CERN spinning up thousands of nodes and GPUs to crunch data on black holes — and then turning it off again at the flip of a switch.</p>

					<p>Argo Rollouts and Argo Events build off that robust foundation with advanced deployments and workflow automation. If you want, you can run any Argo tool independently or chain them together for customizable and repeatable deployments.</p>

					<p>In this project journey report, we'll let GitHub data guide you through the remarkable growth journey Argo has experienced under CNCF's wing. We can't attribute every data point to specific inputs, but we can document and explore the correlations in search of successful decisions and actions. This report is part of a series of product journey reports published by the CNCF.</p>

					<div aria-hidden="true" class="report-spacer-60"></div>

					<div class="thin-hr"></div>

					<div aria-hidden="true" class="report-spacer-60"></div>

					<p>Jesse Suen made the <a href="https://github.com/argoproj/argo-workflows/commit/3ed1dfeb073829d3c4f92b95c9a74118caaec1b4" title="Argo first commit on GitHub">first commit to Argo's GitHub repo</a> on October 17, 2017. After years of multi-vendor and multi-end user development, Argo donated all four projects and was <a href="https://www.cncf.io/blog/2020/04/07/toc-welcomes-argo-into-the-cncf-incubator/" title="Blog post about Argo joining the CNCF as an incubating project">welcomed into the CNCF</a> as an incubating project on April 7, 2020.</p>

					<div aria-hidden="true" class="report-spacer-60"></div>

					<p
						class="small"><span class="sup">*</span> These statistics were collected with the DevStats tool, which CNCF built in collaboration with CNCF project communities. When we talk about “Contributor,” we mean somebody who made a review, commented, committed, or created a PR or issue.</p>
				</div>

				<div class="section-01__grid-col2">
					<h3 class="sub-header">Since joining, the Argo team and
						community have added:</h3>

					<div class="section-01__icon-col">
						<!-- Icon 1  -->
						<div class="icon-box-1">
							<div class="icon">
								<img loading="lazy" width="52" height="52" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-badge.svg', true ); ?>
" alt="Badge icon">
							</div>
							<div class="text">
								<span>7,134+</span><br />
								Contributors
							</div>
						</div>

						<!-- Icon 2  -->
						<div class="icon-box-1">
							<div class="icon">
								<img loading="lazy" width="45" height="35" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-code.svg', true ); ?>
" alt="Code icon">
							</div>
							<div class="text">
								<span>16,288+</span><br />
								Code commits
							</div>
						</div>

						<!-- Icon 3  -->
						<div class="icon-box-1">
							<div class="icon">
								<img loading="lazy" width="33" height="29" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-commit.svg', true ); ?>
" alt="Commit icon">
							</div>
							<div class="text">
								<span>11,557+</span><br />
								Pull requests
							</div>
						</div>

						<!-- Icon 4  -->
						<div class="icon-box-1">
							<div class="icon">
								<img loading="lazy" width="36" height="25" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-command-line.svg', true ); ?>
" alt="Command line icon">
							</div>
							<div class="text">
								<span>370,000+</span><br />
								Contributions
							</div>
						</div>

						<!-- Icon 5  -->
						<div class="icon-box-1">
							<div class="icon">
								<img loading="lazy" width="44" height="44" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-building.svg', true ); ?>
" alt="Building icon">
							</div>
							<div class="text">
								<span>1,931+</span><br />
								Contributing companies
							</div>
						</div>
					</div>

				</div>
			</div>

			<div class="shadow-hr"></div>

			<div class="quote-with-name-container">
				<p
					class="quote-with-name-container__quote">Without open source, and if you're only building for your organization, you have a narrow focus. Open source forces you to consider the use cases of other organization's needs, and it helps shape it to be an overall better product at the end of the day.</p>
				<div class="quote-with-name-container__marks">
					<p class="quote-with-name-container__name">Jesse Suen</p>
					<p
						class="quote-with-name-container__position">Co-founder and CTO of Akuity</p>
				</div>
			</div>

		</section>

		<section class="section-02 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">Code <br />
						Diversity</h2>
					<div class="section-number">1/7</div>
				</div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>Argo's four projects have increased in velocity and adoption thanks to healthy coordination and shared vision among its major vendor and end-user contributing communities. Since joining CNCF, Argo has tallied contributions from more than 1,900 organizations.</p>

						<p>The Argo team diligently maintains a healthy balance between the communities and their often disparate needs. Now that Argo is an incubating project within the CNCF, vendor and end-user contributors see value in the governance structure and guaranteed longevity — and they understand that Argo is not subject to the whims of any one company. Active vendor contributors include Intuit, Codefresh, Akuity, and RedHat. End users like Blackrock have contributed entire projects — Argo Events — and dozens more organizations like Swiss Post, Dyno, Alibaba.com, and Commonwealth Computer Research actively contribute today.</p>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<h2 class="sub-header-upper">Diversity Across Company Size and
					Type to-date <span>(End User, Vendor, Foundation)</span>
				</h2>

				<div class="lf-grid section-02__grid">
					<div class="section-02__grid-col1">

						<span class="large-number has-arrow-after">2,374</span>
						<span class="large-number-text">Companies contributing
							code </span>

					</div>
					<div class="thin-hr hr-for-mobile"></div>
					<div class="section-02__grid-col2">

						<span class="large-number has-arrow-after">124%</span>
						<span class="large-number-text">Increase in companies
							contributing <br class="show-over-1000">code since
							Argo joined CNCF </span>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="thin-hr"></div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-02__grid">
					<div class="section-02__grid-col1">

						<span class="large-number has-arrow-after">9</span>
						<span class="large-number-text">Countries with <br>100+
							individual <br>Argo contributors</span>

					</div>
					<div class="thin-hr hr-for-mobile"></div>
					<div class="section-02__grid-col2">
						<h3 class="uppercase orange-text">Top 3 Countries</h3>
						<div aria-hidden="true" style="height: 30px"></div>

						<div class="lf-grid countries-grid">
							<div class="countries-grid__col1">

								<img loading="lazy"
									src="<?php LF_Utils::get_image( $report_folder . 'flag-usa.png' ); ?>"
									alt="Flag of United States" width="45"
									height="45">
								<span class="large-number-text">United
									States</span>
							</div>
							<div class="countries-grid__col2">
								<img loading="lazy"
									src="<?php LF_Utils::get_image( $report_folder . 'flag-de.png' ); ?>"
									alt="Flag of Germany" width="45"
									height="45">
								<span class="large-number-text">Germany</span>
							</div>
							<div class="countries-grid__col3">
								<img loading="lazy"
									src="<?php LF_Utils::get_image( $report_folder . 'flag-uk.png' ); ?>"
									alt="Flag of United Kingdom" width="45"
									height="45">
								<span class="large-number-text">United
									Kingdom</span>
							</div>
						</div>

					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="thin-hr"></div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-02__grid">
					<div class="section-02__grid-col1">

						<span class="large-number has-arrow-after">8,337</span>
						<span class="large-number-text">Individuals
							<br>contributing code </span>

					</div>
					<div class="thin-hr hr-for-mobile"></div>
					<div class="section-02__grid-col2">

						<span class="large-number has-arrow-after">307%</span>
						<span class="large-number-text">Increase since Argo
							joined CNCF</span>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<p
						class="restrictive-9-col">The diversity of company contributors, and the healthy balance of vendor&lt;-&gt;end user input, continues to fuel growth and give users confidence in choosing Argo tools for accelerating their Kubernetes workflows.</p>
				</div>

				<div class="shadow-hr"></div>

				<div class="quote-with-name-container">
					<p
						class="quote-with-name-container__quote">When we started, we built Argo for CI/CD, the 'boring' stuff, but then we started to get interesting use cases... I never imagined Argo could be used to process CERN data for the Large Hadron Collider. It just blows my mind to see how useful Argo is outside of its original intent.</p>
					<div class="quote-with-name-container__marks">
						<p
							class="quote-with-name-container__name">Jesse Suen</p>
						<p
							class="quote-with-name-container__position">Co-founder and CTO of Akuity</p>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<h2 class="sub-header">Cumulative growth of Argo
					<span>Contributions by company from Q3 2017 - Q3 2022</span>
				</h2>

				<?php LF_Utils::display_responsive_images( 78916, 'full', '1440px', 'remove-bg', 'lazy', 'Chart showing upward cumulative growth of Argo Contributions by company from Q3 2017 - Q3 2022' ); ?>

				<div class="shadow-hr"></div>

				<h2 class="sub-header">Percentage breakdown of Argo
					<span>Contributions by company from Q3 2017 - Q3 2022</span>
				</h2>

				<?php LF_Utils::display_responsive_images( 78917, 'full', '1440px', 'remove-bg', 'lazy', 'Chart showing upward Percentage breakdown of Argo Contributions by company from Q3 2017 - Q3 2022' ); ?>

				<div class="shadow-hr"></div>

				<h2 class="sub-header">Cumulative number of companies <span>Q3
						2017 - Q3 2022</span> </h2>

				<?php LF_Utils::display_responsive_images( 78918, 'full', '1440px', 'remove-bg', 'lazy', 'Chart showing upward cumulative number of companies Q3 2017 - Q3 2022' ); ?>

				<div class="shadow-hr"></div>

				<h2 class="sub-header">Cumulative growth in contributors
					<span>Q3 2017 - Q3 2022</span>
				</h2>

				<?php LF_Utils::display_responsive_images( 78920, 'full', '1440px', 'remove-bg', 'lazy', 'Cumulative growth in contributors Q3 2017 - Q3 2022' ); ?>

			</div>
		</section>

		<section class="section-03 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">Geographic Diversity <br />
						of Contributors</h2>
					<div class="section-number">2/7</div>
				</div>

				<h2 class="sub-header-upper">Top contributing Countries</h2>

				<?php LF_Utils::display_responsive_images( 78919, 'full', '1440px', null, 'lazy', 'World map showing top contributing countries to Argo' ); ?>

				<div class="shadow-hr"></div>

				<h2 class="sub-header">Percentage breakdown of Argo
					<span>Contributions by company from Q3 2017 - Q3 2022</span>
				</h2>

				<?php LF_Utils::display_responsive_images( 78921, 'full', '1440px', 'remove-bg', 'lazy', 'Chart showing Percentage breakdown of Argo Contributions by company from Q3 2017 - Q3 2022' ); ?>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="quote-with-name-container">
					<p
						class="quote-with-name-container__quote">I remember the old days of our Slack channel, which was just me, Jesse, and other core contributors trying to answer questions about Argo Workflows. I could feel the difference, after one or two months, where community members joined, but not just to ask questions. I saw healthy interaction between community members, helping each other and answering questions without help from core contributors. That was the moment I felt the community was working and getting bigger.</p>
					<div class="quote-with-name-container__marks">
						<p class="quote-with-name-container__name">Hong Wang</p>
						<p
							class="quote-with-name-container__position">Founder and CEO of Akuity</p>
					</div>
				</div>

			</div>
		</section>

		<section class="section-04 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">Development <br />
						Velocity</h2>
					<div class="section-number">3/7</div>
				</div>

				<h2 class="sub-header">Monthly velocity of Argo</h2>

				<?php LF_Utils::display_responsive_images( 78922, 'full', '1440px', 'remove-bg', 'lazy', 'Chart showing upward monthly velocity of Argo project' ); ?>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p><strong>Based on velocity metrics since joining CNCF, Argo is undoubtedly growing at a robust and sustainable pace.</strong></p>
						<p>One way we track developer velocity is a simple formula — commits + PRs + issues + authors — over time. We also look at the cumulative contributors throughout Argo's history, and both illustrate that Argo's formula of multiple vendors and end users creates healthy, grassroots support.</p>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<h2 class="sub-header">Growth of Argo <span>pull requests, code
						commits, issues, and authors over time</span></h2>

				<?php LF_Utils::display_responsive_images( 78923, 'full', '1440px', 'remove-bg', 'lazy', 'Chart showing upward growth of Argo pull requests, code commits, issues, and authors over time' ); ?>

			</div>
		</section>

		<section class="section-05 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">Education, Events <br />
						and Sponsorship</h2>
					<div class="section-number">4/7</div>
				</div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>The more a project's community participates in education, events, and sponsorship, the healthier the project tends to be.</p>
						<p>On the educational side, Codefresh launched the GitOps Certification with Argo In January 2022. As of August 2022, the program is celebrating more than 10,000 students progressing through the three courses or leveraging their GitOps Fundamental certificate in the real world.</p>
						<p>The first ArgoCon was held virtually in December 2021 and amassed more than 4,000 attendees, 25 speakers, and support from Intuit, Codefresh, and Red Hat.</p>
					</div>
				</div>

			</div>
		</section>

		<section class="section-06 alignfull">
			<div class="container wrap">
				<div aria-hidden="true" class="report-spacer-120"></div>
				<h2 class="sub-header-upper">ArgoCon 2022</h2>
				<div class="lf-grid">
					<p
						class="restrictive-9-col"><a href="https://events.linuxfoundation.org/argocon/">ArgoCon 2022</a> (September 19-21, 2022), in Mountain View, California has dozens of breakout sessions for roadmap updates, hands-on workshops, lightning talks, use case walkthroughs, and more. The sponsorship slate is already full, with major support from Adobe, Akuity, Intuit, Red Hat, OpsMx, and many more.</p>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<a href="https://events.linuxfoundation.org/argocon/">
					<?php LF_Utils::display_responsive_images( 78915, 'full', '1440px', null, 'lazy', 'ArgoCon 2022 event artwork' ); ?></a>

				<div aria-hidden="true" class="report-spacer-120"></div>

			</div>

		</section>

		<section class="section-07 alignfull">
			<div class="container wrap">

				<div class="quote-with-name-container">
					<p
						class="quote-with-name-container__quote">I don't think you could have a vibrant, multi-vendor product like Argo without end-user participation. Without them, it would be a project that's primarily sponsored or dominated by one vendor. End-user involvement in the community is essential.</p>
					<div class="quote-with-name-container__marks">
						<p class="quote-with-name-container__name">Ed Lee</p>
						<p
							class="quote-with-name-container__position">Founder of Applatix</p>
					</div>
				</div>

			</div>

		</section>

		<section class="section-08 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">Marketing Growth <br />
						and Programs</h2>
					<div class="section-number">5/7</div>
				</div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p><strong>Upon Argo joining CNCF in Q3 2020, we've worked diligently to spread awareness of Argo and expand its community through two core principles:</strong></p>

						<ul>
							<li>Solving real problems and being genuine with our
								audiences.</li>
							<li>Listening to all inputs from vendors and end
								users to maintain balance and generate
								excitement.</li>
						</ul>

						<p>Thanks to these efforts, Argo's reach continues to grow rapidly, with Argo CD now in use at Capital One, Deloitte, Electronic Arts, MariaDB, PagerDuty, Sumo Logic, and other major organizations.</p>

					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-08__grid">
					<div class="section-08__grid-col1">
						<span class="large-number has-arrow-after">4,000</span>
						<span class="large-number-text">Attendees to the first
							<br>ArgoCon in Dec 21</span>

					</div>
					<div class="thin-hr hr-for-mobile"></div>
					<div class="section-08__grid-col2">
						<span class="large-number has-arrow-after">10.6K</span>
						<span class="large-number-text">Members in Argo's
							<br>Slack channels</span>

					</div>
					<div class="thin-hr hr-for-mobile"></div>
					<div class="section-08__grid-col3">

						<span class="large-number has-arrow-after">8.8K</span>
						<span class="large-number-text">Twitter Followers<br><a
								href="https://twitter.com/argoproj"
								class="link-normalise"
								title="Argo project on Twitter">twitter.com/argoproj</a></span>
					</div>
				</div>
			</div>
		</section>

		<section class="section-09 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">Project <br />
						Documentation</h2>
					<div class="section-number">6/7</div>
				</div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>Cloud native projects can't exist without robust documentation for educating new users and helping existing users solve problems. A healthy velocity of documentation changes is a great signal for the health of a project's community.</p>

						<p><strong>Since joining CNCF, hundreds of contributors from many backgrounds and motivations have added to and polished Argo's documentation.</strong></p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-09__grid">
					<div class="section-09__grid-col1">
						<span class="large-number has-arrow-after">5,464</span>
						<span class="large-number-text">Documentation
							<br>Commits</span>

					</div>
					<div class="thin-hr hr-for-mobile"></div>
					<div class="section-09__grid-col2">
						<span class="large-number has-arrow-after">1,190</span>
						<span class="large-number-text">Contributors</span>

					</div>
					<div class="thin-hr hr-for-mobile"></div>
					<div class="section-09__grid-col3">

						<span class="large-number has-arrow-after">579</span>
						<span class="large-number-text">Companies <br>committed
							docs</span>

					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p><span class="sup">*</span>Documentation for Argo is authored in .md files. CNCF uses the DevStats tool to automatically collect and count statistics of all relevant .md files in the Argo repositories in GitHub.</p>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<h3 class="sub-header">Growth in participation in Argo project
					documentation <span>(Q1 2017 - Q3 2022)</span></h3>

				<?php LF_Utils::display_responsive_images( 78924, 'full', '1440px', 'remove-bg', 'lazy', 'Chart showing upward growth in participation in Argo project documentation from Q1 2017 - Q3 2022' ); ?>

				<div class="shadow-hr"></div>

				<h3 class="sub-header">
					Cumulative growth of Argo project documentation commits
					<span>(Q1 2017 - Q3 2022)</span>
				</h3>

				<?php LF_Utils::display_responsive_images( 78925, 'full', '1440px', 'remove-bg', 'lazy', 'Chart showing upward cumulative growth of Argo project documentation commits  from Q1 2017 - Q3 2022' ); ?>
			</div>

		</section>

		<section class="section-10 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">Conclusion</h2>
					<div class="section-number">7/7</div>
				</div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>CNCF is committed to fostering and sustaining an ecosystem of open source, vendor-neutral projects by democratizing state-of-the-art software development and deployment patterns to make technology accessible for everyone.</p>

						<p>We hope this report is a useful portrait into how CNCF fosters and sustains the growth of Argo's projects, its team, and its founding principles.</p>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<h2 class="section-header">Thank You</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<p>Your comments and feedback are welcome at <a href="mailto:hello@cncf.io" title="Send an email to hello@cncf.io">hello@cncf.io</a></p>

				<div aria-hidden="true" class="report-spacer-120"></div>

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

get_template_part( 'components/footer' );
