<?php
/**
 * Template Name: Annual Survey 2023
 * Template Post Type: lf_report
 *
 * File for the Annual Survey 2023
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

// Report folder in images/ folder.
$report_folder = 'reports/annual-survey-23/';

get_template_part( 'components/header' );

get_template_part( 'components/skip-link-target' );

wp_enqueue_style( 'annual-survey-23', get_template_directory_uri() . '/build/annual-survey-2023.min.css', array(), filemtime( get_template_directory() . '/build/annual-survey-2023.min.css' ), 'all' );

wp_enqueue_style( 'wp-block-group' );
wp_enqueue_style( 'wp-block-column' );
wp_enqueue_style( 'wp-block-columns' );

// setup social share icons + data.
$caption      = 'Read the CNCF Annual Survey 2023 ';
$page_url     = rawurlencode( get_permalink() );
$caption      = htmlspecialchars( rawurlencode( html_entity_decode( $caption, ENT_COMPAT, 'UTF-8' ) ), ENT_COMPAT, 'UTF-8' );
$options      = get_option( 'lf-mu' );
$twitter      = $options && $options['social_twitter_handle'] ? $options['social_twitter_handle'] : null;
$twitter_url  = 'https://twitter.com/intent/tweet?text=' . $caption . '&amp;url=' . $page_url . '&amp;hashtags=cncf&amp;via=' . $twitter . '';
$linkedin_url = 'https://www.linkedin.com/shareArticle?mini=true&url=' . $page_url . '&summary=' . $caption;
$mailto_url   = 'mailto:?subject=' . $caption . '&body=' . $caption . '&nbsp;' . $page_url;
?>

<link rel="prefetch"
	href="<?php echo esc_url( get_template_directory_uri() . '/build/annual-survey-2023.min.css' ); ?>"
	as="style" crossorigin="anonymous">

<main class="as23">
	<article class="container wrap">
		<section class="hero alignfull">
			<div class="container wrap hero__container">
				<figure class="hero__container-bg-figure">
					<?php
					LF_Utils::display_responsive_images( 103549, 'full', '1200px', 'hero__container-bg-image', 'eager', 'A graphic of some stacked boxes to symbolise containers.' );
					?>
				</figure>
				<div class="hero__content">

					<picture>
						<source media="(max-width: 599px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'cncf-annual-survey-2023-logo-mobile.svg', true );
?>
">
						<source media="(min-width: 600px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'cncf-annual-survey-2023-logo-desktop.svg', true );
?>
">
						<img width="588" height="262" src="
<?php
Lf_Utils::get_svg( $report_folder . 'cncf-annual-survey-2023-logo-desktop.svg', true );
?>
" alt="CNCF Annual Survey 2023" loading="eager" class="hero__title">
					</picture>

					<div class="hero__button-share-align">

						<div class="wp-block-button hero__button"><a
								href="https://data.world/thelinuxfoundation"
								class="wp-block-button__link"
								title="View the full dataset">
								View the full dataset</a>
						</div>

						<?php
						get_template_part( 'components/social-share' );
						?>

					</div>

					<div class="hero__jump">Jump to section:</div>
				</div>
			</div>
		</section>

		<section class="nav-section">
			<!-- Navigation  -->
			<div class="nav-el">
				<div class="nav-el__box">
					<a href="#methodology" title="Jump to Methodology section"
						class="box-link"></a>
					<img loading="lazy" width="36" height="36" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-methodology.svg', true ); ?>
" alt="Methodology icon">Methodology
				</div>

				<div class="nav-el__box">
					<a href="#demographics" title="Jump to Demographics section"
						class="box-link"></a>
					<img loading="lazy" width="36" height="36" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-lanyard.svg', true ); ?>
" alt="Lanyard icon">Demographics
				</div>

				<div class="nav-el__box">
					<a href="#findings" title="Jump to Key Findings section"
						class="box-link"></a>
					<img loading="lazy" width="36" height="36" src="
<?php
LF_Utils::get_svg( $report_folder . 'icon-inspect.svg', true );
?>
" alt="Inspect icon">Key Findings
				</div>
			</div>
		</section>

		<section class="section-01">
			<h2 class="section-01__title">Cloud Native 2023: The Undisputed <br
					class="show-over-1000">Infrastructure of Global Technology</h2>

			<div class="lf-grid">
				<div class="restrictive-9-col">
					<p>Since 2015, the Cloud Native Computing Foundation has used its unique position in the cloud native community to survey the landscape, understand the dynamics and better serve users of open source, cloud native technologies. For this, our eleventh iteration of the CNCF Annual Survey, we set out to create a comprehensive and in-depth report that reflects the diverse experiences of the cloud native community.</p>
					<p>As always, we are happy to share our full dataset for the Annual Survey, available at <a href="https://data.world/thelinuxfoundation">data.world/thelinuxfoundation</a>.</p>
				</div>
			</div>
		</section>

		<section id="methodology"
			class="section-02 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">Methodology</h2>
					<div class="section-number">1/3</div>
				</div>

				<div class="lf-grid section-02__grid">
					<div class="section-02__grid-col1">
						<p><strong>This report is based on a web survey conducted by the Linux Foundation Research and its partners from August through December 2023, comprising 59 questions which addressed the topics of cloud native computing, containers, Kubernetes, cybersecurity, and WebAssembly. We encourage you to read the in-depth methodology and demographics at the end of the report, for greater insights into the make up of this survey.</strong><br><br>
						Respondents spanned many vertical industries and companies of all sizes, and we collected data from geographies including the Americas, Europe, and Asia Pacific. We then stratified the data collection by company size, geographic region, and organization type. Data was primarily segmented by geographic region, company size, and adoption of cloud native techniques.
						<br><br>
						Out of 3,735 candidates that started the survey, 988 records were used for analysis. More than 2,700 candidates were disqualified due to extensive pre-screening, survey screening questions, and data quality checks to ensure that respondents had sufficient cloud native familiarity and professional experience to answer questions accurately on behalf of the organization they worked for. This resulted in a margin of error of ± 2.6% at a 90% confidence level.
						<br><br>
						To focus research on real-world adoption, we also filtered out respondents whose main source of revenue is derived from providing cloud native products and services from answering questions about the adoption of cloud computing, containers, and Kubernetes. 
						<br><br>
						This year, we added a “don’t know or not sure” (DKNS) response to the list of responses for nearly all questions, to account for times when respondents were unable to answer because it was outside the scope of their role or experience. 
						<br><br>
						Please note that the percentage values in this report may not total to exactly 100% due to rounding.
					</p>
					</div>
					<div class="section-02__grid-col2">
						<p class="sub-header">Report By</p>

						<a href="https://www.cncf.io"
							title="Visit CNCF.io website">
							<img loading="lazy" width="317" height="50" src="
							<?php LF_Utils::get_svg( $report_folder . 'logo-cncf.svg', true ); ?>
							" alt="CNCF Logo">
						</a>

						<a href="https://www.linuxfoundation.org/research"
							title="Visit LF Research website">
							<img loading="lazy" width="317" height="56" src="
							<?php LF_Utils::get_svg( $report_folder . 'logo-lf-research.svg', true ); ?>
							" alt="Linux Foundation Research Logo">
						</a>
					</div>
				</div>
			</div>
		</section>

		<section id="demographics"
			class="section-03 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">Demographics</h2>
					<div class="section-number">2/3</div>
				</div>

				<div class="lf-grid">
					<div class="restrictive-8-col">
						The 2023 report is global in scope, drawing responses
						from six continents and from across business verticals,
						from public, private and NGOs, to start-ups to the
						enterprise sector.
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<p class="sub-header">Region Of Organization's Headquarters</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<picture>
					<source media="(max-width: 599px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'attendee-geography-map-mobile.svg', true );
?>
">
					<source media="(min-width: 600px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'attendee-geography-map-desktop.svg', true );
?>
">
					<img width="1200" height="604" src="
<?php
Lf_Utils::get_svg( $report_folder . 'attendee-geography-map-desktop.svg', true );
?>
" alt="Of all respondee organizations, 42% are from North America, 30% from Europe, 7% from Asia Pacific."
						loading="lazy">
				</picture>

				<div class="shadow-hr"></div>

				<p class="sub-header text-center">TOP 3 JOB FUNCTIONS</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="section-03__grid lf-grid">
					<div class="section-03__grid-col1">
						<p
							class="jf__title">SRE / <br/>DevOps ENGINEER</p>
						<div class="thin-hr jf__hr"></div>
						<span class="jf__number">39%</span>
					</div>
					<div class="section-03__grid-col2">
						<p class="jf__title">SOFTWARE <br/>ARCHITECT</p>
						<div class="thin-hr jf__hr"></div>
						<span class="jf__number">27%</span>
					</div>
					<div class="section-03__grid-col3">
						<p class="jf__title">DEVOPS <br/>MANAGEMENT</p>
						<div class="thin-hr jf__hr"></div>
						<span class="jf__number">20%</span>
					</div>
				</div>
				<div class="shadow-hr"></div>
				<p class="sub-header">Organization's Number Of Employees</p>
				<div aria-hidden="true" class="report-spacer-60"></div>
				<picture>
					<source media="(max-width: 599px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'organizations-employees-mobile.svg', true );
?>
">
					<source media="(min-width: 600px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'organizations-employees-desktop.svg', true );
?>
">
					<img width="1200" height="481" src="
<?php
Lf_Utils::get_svg( $report_folder . 'organizations-employees-desktop.svg', true );
?>
" alt="Respondents organizations - 1-99 employees was 24%, 100-999 employees was 30%, 1000-4999 employees was 20%, over 5000 was 26%."
						loading="lazy">
				</picture>

				<div class="shadow-hr"></div>

				<p class="sub-header">CNCF End Users Technical Experience</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<picture>
					<source media="(max-width: 599px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'end-users-technical-experience-mobile.svg', true );
?>
">
					<source media="(min-width: 600px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'end-users-technical-experience-desktop.svg', true );
?>
">
					<img width="1200" height="407" src="
<?php
Lf_Utils::get_svg( $report_folder . 'end-users-technical-experience-desktop.svg', true );
?>
" alt="42% of end user respondents have 6-10 years of technical experience."
						loading="lazy">
				</picture>

			</div>
		</section>

		<section id="findings"
			class="section-04 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">Key Findings</h2>
					<div class="section-number">3/3</div>
				</div>

				<div class="lf-grid">
					<div class="restrictive-10-col">
						<p class="larger-sub-header">Kubernetes solidifies its core technology status</p>
					</div>
				</div>
				<div aria-hidden="true" class="report-spacer-20"></div>

				<div class="lf-grid as23__grid">
					<div class="as23__grid-col1">
						<p>In the 2021 CNCF Annual Survey, we stated that Kubernetes had crossed the adoption chasm to become a mainstream global technology. Today, the laggards are finally catching up.

						<p>This year’s analysis of cloud adoption, containers, and Kubernetes did not include organizations whose primary revenue stream was derived from offering cloud native products and services – mostly vendors. By focusing our research on organizations that are not in the cloud business, but had a potential or actual reason to consume cloud services, we sought to get a more accurate view into the adoption, benefits, and challenges of consuming cloud products and services. We expected that adoption rates would be less than the 2022 metrics because they included both consumers and providers of cloud services – so we did not do any direct comparisons between 2023 and prior years. However, in 2022, 58% percent of providers and consumers (the entire sample) were using Kubernetes in production and 23% (81% total) were actively evaluating it. In 2023, 66% of potential/actual consumers were using Kubernetes in production and 18% were evaluating it (84% total).</p>

						<p>Compounding our findings, respondents reported that just 15% of organizations that consume cloud computing services have no plans to use Kubernetes. There is likely to be erosion to this number as the economics of cloud continues to improve and Kubernetes’ foundational role in the burgeoning AI movement solidifies the project’s status as a core technology, as intrinsic to the global technology ecosystem as the Linux Kernel.</p>
					</div>
					<div class="as23__grid-col2">
						<p class="sub-header">USING OR <br/>EVALUATING <br/>KUBERNTES</p>

						<span class="sidebar-number">84%</span>

						Up from 81% in 2022.
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<p
					class="question">To what extent has your organization adopted cloud native technologies?</p>
					<img loading="lazy" width="1186" height="531" src="
					<?php LF_Utils::get_svg( $report_folder . 'adoption-chart.svg', true ); ?>
					" alt="To what extent has your organization adopted cloud native technologies?">

				<div class="shadow-hr"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p class="larger-sub-header">Project usage trends upwards across incubating and graduating projects</p>
						<p class="larger-sub-sub-header">Largest usage gains (Growth in 2023) 2022 - 2023</p>
					</div>
				</div>
				<picture>
					<source media="(max-width: 599px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'project-usage-trends-mobile.svg', true );
?>
">
					<source media="(min-width: 600px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'project-usage-trends-desktop.svg', true );
?>
">
					<img width="1206" height="444" src="
<?php
Lf_Utils::get_svg( $report_folder . 'cproject-usage-trends-desktop.svg', true );
?>
" alt="Project usage trends upwards across incubating and graduating projects"
						loading="lazy">
				</picture>

				<div class="shadow-hr"></div>

				<div class="lf-grid">
				<div class="restrictive-9-col">
					<p>Use of CNCF projects didn’t just remain strong during the economic downturn – it grew. The technology sector was rocked with myriad layoffs in late 2022 and 2023. In fact, according to data compiled by Layoffs.fyi, more than 2,000 tech companies laid off around 428,000 staff during this time. However, a comparison of CNCF project involvement (combining production use and evaluation) showed unilateral gains across graduated and incubating projects, with gains for the top five growth leaders ranging between 17-35%.</p>

					<p>These gains were largely realized by projects related to container orchestration, observability, industry standard container runtimes, and container networking. For projects such as Kubernetes, Helm, and Prometheus, there is still room for increased production growth and penetration.</p>

					<p>However, there were project casualties from the economic downturn. Comparing responses from 2022 and 2023, we noticed decreased penetration rates for a variety of activities and products including service meshes (from 24% to 21%), service proxies (from 34% to 21%), and serverless architecture and/or functions as a service (from 22% to 13%).</p>

					<p>It’s natural that organizations would rein in discretionary spending and investments during this time, and while many of the techniques identified here are important to future productivity and competitiveness, they are not a necessary spend.</p>
					<p>As always, we are happy to share our full dataset for the Annual Survey, available at <a href="https://data.world/thelinuxfoundation">data.world/thelinuxfoundation</a>.</p>
				</div>
				</div>
				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p class="larger-sub-header">Penetration of CNCF top ten graduated or incubating CNCF projects being used in production or evaluated from 2022 to 2023</p>
					</div>
				</div>
				<div aria-hidden="true" class="report-spacer-60"></div>

				<img loading="lazy" width="1170" height="835" src="
					<?php LF_Utils::get_svg( $report_folder . 'project-pen.svg', true ); ?>
					" alt="Penetration of CNCF top ten graduated or incubating CNCF projects being used in production or evaluated from 2022 to 2023">

				<div class="shadow-hr"></div>

				<p class="question">Which of these graduated CNCF projects is your organization using in production or evaluating?</p>

				<picture>
					<source media="(max-width: 599px)" srcset="
						<?php
						Lf_Utils::get_svg( $report_folder . 'using-chart-mobile.svg', true );
						?>
						">
											<source media="(min-width: 600px)" srcset="
						<?php
						Lf_Utils::get_svg( $report_folder . 'using-chart-desktop.svg', true );
						?>
						">
											<img width="1200" height="341" src="
						<?php
						Lf_Utils::get_svg( $report_folder . 'using-chart-desktop.svg', true );
						?>
						" alt="Which of these graduated CNCF projects is your organization using in production or evaluating?"
						loading="lazy">
				</picture>

				<div class="shadow-hr"></div>

				<p class="question">Which of these incubating CNCF projects is your organization using in production or evaluating?</p>

				<picture>
					<source media="(max-width: 599px)" srcset="
						<?php
						Lf_Utils::get_svg( $report_folder . 'using-chart-incubating-mobile.svg', true );
						?>
						">
											<source media="(min-width: 600px)" srcset="
						<?php
						Lf_Utils::get_svg( $report_folder . 'using-chart-incubating-desktop.svg', true );
						?>
						">
											<img width="1200" height="341" src="
						<?php
						Lf_Utils::get_svg( $report_folder . 'using-chart-incubating-desktop.svg', true );
						?>
						" alt="Which of these incubating CNCF projects is your organization using in production or evaluating?"
						loading="lazy">
				</picture>

				<div class="shadow-hr"></div>

				<div class="lf-grid">
					<div class="restrictive-10-col">
						<p class="larger-sub-header">Public clouds widely adopted, with large organizations leaning towards hybrid solutions</p>
					</div>
				</div>
				<div aria-hidden="true" class="report-spacer-20"></div>

				<div class="lf-grid as23__grid">
					<div class="as23__grid-col1">
						<p>Public cloud use is the preferred path for organizations, thanks to its ease of adoption, robust security, and minimal vendor lock-in. In fact, regardless of how we segment the data, public cloud use comes out on top.</p>

						<p>Organizations who are just beginning their cloud journey favor public clouds (58%) but steer away from hybrid clouds (29%). This is likely because public clouds have a lower barrier to entry and can remain a key component of a cloud strategy once implemented.</p>

						<p>Large organizations are drawn to all cloud types (public, private, and hybrid) but are the primary consumers of hybrid clouds (56%) compared to medium (44%) and small (27%) organizations.</p>

						<p>Multi Cloud solutions are now the norm. The use of only public clouds is a strategy used by 28% of organizations and the average number of unique public cloud service providers in use for an organization is 2.3. Multi Cloud solutions (hybrid and other cloud combinations) are used by 56% of organizations. Multi cloud solutions increase the average number of unique cloud services providers by one, and, occasionally, by two.</p>
					</div>
					<div class="as23__grid-col2">
						<span class="sidebar-number">2.8</span>
						Average number of unique cloud service providers.
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>


				<p class="question">Which of the following combinations of data center and cloud architectures does your organization use?</p>
				<p class="larger-sub-sub-header">Segmented by Adoption</p>

!!!

				<p class="question">Which of the following combinations of data center and cloud architectures does your organization use?</p>
				<p class="larger-sub-sub-header">Segmented by Total Employees</p>

!!!


				<div class="shadow-hr"></div>

				<p class="question">Which of the following combinations of data center and cloud architectures does your organization use?</p>

!!!

				<div class="shadow-hr"></div>

				<p class="question">Which of the following combinations of data center and cloud architectures does your organization use?</p>

!!!
















				<div aria-hidden="true" class="report-spacer-40"></div>

				<p><strong>Just 30% of our respondents' organizations</strong> have adopted cloud native <br class="show-over-1000">approaches across nearly all development and deployment activities.</p>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<picture>
					<source media="(max-width: 599px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'container-adoption-mobile.svg', true );
?>
">
					<source media="(min-width: 600px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'container-adoption-desktop.svg', true );
?>
">
					<img width="1200" height="341" src="
<?php
Lf_Utils::get_svg( $report_folder . 'container-adoption-desktop.svg', true );
?>
" alt="62% of organizations with less developed cloud native techniques only have containers for pilot projects or limited production use cases"
						loading="lazy">
				</picture>

				<div class="shadow-hr"></div>

				<p
					class="question">What are your challenges in using / deploying containers?</p>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>The biggest challenges responders reported, in using and deploying containers, are lack of training and security. In fact, lack of training is the most significant barrier inhibiting adoption. It is the top challenge cited by 44% that have yet to deploy containers in production, and 41% of those that use containers on a limited basis. Once containers are used for nearly all applications, then security becomes the top challenge.</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<picture>
					<source media="(max-width: 599px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'challenges-using-containers-mobile.svg', true );
?>
">
					<source media="(min-width: 600px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'challenges-using-containers-desktop.svg', true );
?>
">
					<img width="1200" height="526" src="
<?php
Lf_Utils::get_svg( $report_folder . 'challenges-using-containers-desktop.svg', true );
?>
" alt="44% of respondents that have yet to deploy containers in production say lack of training is the most significant barrier inhibiting adoption."
						loading="lazy">
				</picture>

				<div class="shadow-hr"></div>

				<h2 class="section-header no-max-width">Cloud Native
					Organizations <br class="show-over-1000">favor GitOps</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>Organizations that have fully embraced cloud native techniques are more likely to be releasing applications and using GitOps. GitOps is maturing as a technology base with the Argo and Flux projects recently graduating in CNCF. Furthermore, GitOps principles are 4x as likely to be followed at mature cloud native organizations, versus those that have not embraced cloud native techniques.</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<p class="question">To what extent has your organization adopted practices and tools that adhere to GitOps principles?</p>

				<picture>
					<source media="(max-width: 599px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'adopted-gitops-principles-mobile.svg', true );
?>
">
					<source media="(min-width: 600px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'adopted-gitops-principles-desktop.svg', true );
?>
">
					<img width="1200" height="695" src="
<?php
Lf_Utils::get_svg( $report_folder . 'adopted-gitops-principles-desktop.svg', true );
?>
" alt="12% of respondents said that nearly all deployment practices and tools adhere to GitOps principles"
						loading="lazy">
				</picture>

				<div class="shadow-hr"></div>

				<p
					class="question">How often are your organization's release cycles?</p>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>Of organizations that widely use cloud native approaches, 76% are using containers for nearly all applications and business segments, and 48% release code at least daily. In comparison, only 20% of organizations with limited cloud native maturity use containers and 23% release applications daily.</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<picture>
					<source media="(max-width: 599px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'organizations-release-cycles-mobile.svg', true );
?>
">
					<source media="(min-width: 600px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'organizations-release-cycles-desktop.svg', true );
?>
">
					<img width="1200" height="624" src="
<?php
Lf_Utils::get_svg( $report_folder . 'organizations-release-cycles-desktop.svg', true );
?>
" alt="25% of respondents use cloud native techniques multiple times per day for nearly all development and deployments."
						loading="lazy">
				</picture>

				<div class="shadow-hr"></div>

				<h2 class="section-header">Kubernetes</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p
							class="random-larger-paragraphs"><a href="https://www.cncf.io/enduser/">CNCF End Users</a> are far more advanced in their adoption and use of Kubernetes, and are more likely to maintain Kubernetes environments with more than 10 <a href="https://glossary.cncf.io/cluster/">clusters</a>.</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<p class="question">Does your organization use Kubernetes?</p>

				<div class="lf-grid section-04__k8s">
					<div class="section-04__k8s-col1">
						<img width="465" height="233" src="
						<?php
						Lf_Utils::get_svg( $report_folder . 'k8s-end-users.svg', true );
						?>
						" alt="64% of end users using in production" loading="lazy">
					</div>
					<div class="section-04__k8s-col2">
						<img width="467" height="233" src="
						<?php
						Lf_Utils::get_svg( $report_folder . 'k8s-non-end-users.svg', true );
						?>
						" alt="49% of non-end users using in production" loading="lazy">
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p
					class="question">If your organization uses Kubernetes, how many production clusters do you have?</p>

				<picture>
					<source media="(max-width: 599px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'kubernetes-production-clusters-mobile.svg', true );
?>
">
					<source media="(min-width: 600px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'kubernetes-production-clusters-desktop.svg', true );
?>
">
					<img width="1200" height="367" src="
<?php
Lf_Utils::get_svg( $report_folder . 'kubernetes-production-clusters-desktop.svg', true );
?>
" alt="50% of end users have more than 10 clusters." loading="lazy">
				</picture>

			</div>
		</section>

		<section class="section-05 alignfull background-image-wrapper">

			<figure class="background-image-figure">
				<?php
				LF_Utils::display_responsive_images( 83147, 'full', '1200px', null, 'lazy', 'End users receiving awards at KubeCon + CloudNativeCon North America 2023' );
				?>
			</figure>

			<div class="background-image-text-overlay">
				<div class="container wrap">

					<div aria-hidden="true" class="report-spacer-80"></div>

					<h2 class="section-header">End Users</h2>

					<div aria-hidden="true" class="report-spacer-40"></div>

					<div class="lf-grid">
						<div class="restrictive-7-col">
							<p>CNCF End Users are member companies that use cloud native technologies internally, do not sell any cloud native services externally, and aren't vendors, consultancies, training partners, or telecommunications companies. Individuals within these end user companies are passionate about solving problems using cloud native architectures and providing teams with self-service solutions which create a more inclusive, iterative process.</p>
						</div>
					</div>

					<div aria-hidden="true" class="report-spacer-60"></div>

					<div class="wp-block-button"><a
							href="https://www.cncf.io/enduser/"
							title="Join as an End User"
							class="wp-block-button__link fit-content">Join</a>
					</div>

					<div aria-hidden="true" class="report-spacer-80"></div>

				</div>
			</div>
		</section>

		<section class="section-06">

			<div class="lf-grid">
				<div class="restrictive-7-col">
					<p
						class="larger-sub-header">Kubernetes yet to be fully deployed outside cloud native community</p>

				</div>
			</div>

			<div class="lf-grid">
				<div class="restrictive-9-col">
					<p>Outside of the cloud native community, Kubernetes has yet to be fully deployed into production, leaving the door open for alternative orchestrators and platforms. End users have a greater propensity to consider alternatives to Kubernetes, with 72% evaluating at least one tool while 48% of non-end users are evaluating container orchestration tools.</p>
				</div>
			</div>

			<div aria-hidden="true" class="report-spacer-60"></div>

			<p
				class="question">How many container orchestration tools that are not associated with Kubernetes is your organization actively evaluating / piloting?</p>

			<picture>
				<source media="(max-width: 599px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'container-orchestration-tools-mobile.svg', true );
?>
">
				<source media="(min-width: 600px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'container-orchestration-tools-desktop.svg', true );
?>
">
				<img width="1200" height="540" src="
<?php
Lf_Utils::get_svg( $report_folder . 'container-orchestration-tools-desktop.svg', true );
?>
" alt="72% of end users use 4 or more tools" loading="lazy">
			</picture>

			<div class="shadow-hr"></div>

			<div class="lf-grid">
				<div class="restrictive-9-col">
					<p
						class="sub-header">Number of non-kubernetes container orchestration tools being evaluated by organizations using kubernetes to some extent</p>

				</div>
			</div>

			<div aria-hidden="true" class="report-spacer-40"></div>

			<div class="lf-grid">
				<div class="restrictive-9-col">
					<p>Larger enterprises have embraced hybrid cloud architecture, which often have more than 10 Kubernetes clusters. Meanwhile production users with 1-5 clusters are less likely to be evaluating Kubernetes alternatives.</p>

				</div>
			</div>

			<div aria-hidden="true" class="report-spacer-60"></div>

			<picture>
				<source media="(max-width: 599px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'non-k8s-container-orchestration-tools-mobile.svg', true );
?>
">
				<source media="(min-width: 600px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'non-k8s-container-orchestration-tools-desktop.svg', true );
?>
">
				<img width="1200" height="587" src="
<?php
Lf_Utils::get_svg( $report_folder . 'non-k8s-container-orchestration-tools-desktop.svg', true );
?>
" alt="Larger enterprises have embraced hybrid cloud architecture, which often have more than 10 Kubernetes clusters. Production users with 1-5 clusters are less likely to be evaluating Kubernetes alternatives."
					loading="lazy">
			</picture>

			<div class="shadow-hr"></div>

			<p
				class="question">Which of the following combinations of data center and cloud architectures does your organization use? <br class="show-over-1000">(By organization size)</p>

			<div aria-hidden="true" style="height: 20px"></div>


			<picture>
				<source media="(max-width: 599px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'data-center-cloud-mobile.svg', true );
?>
">
				<source media="(min-width: 600px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'data-center-cloud-desktop.svg', true );
?>
">
				<img width="1200" height="483" src="
<?php
Lf_Utils::get_svg( $report_folder . 'data-center-cloud-desktop.svg', true );
?>
" alt="63% of companies with other 5000 employees use Hybrid cloud data center and cloud architecture."
					loading="lazy">
			</picture>

			<div class="shadow-hr"></div>

			<p
				class="question">If your organization uses Kubernetes, how many production clusters do you have? (By architecture type)</p>

			<picture>
				<source media="(max-width: 599px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'k8s-production-clusters-mobile.svg', true );
?>
">
				<source media="(min-width: 600px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'k8s-production-clusters-desktop.svg', true );
?>
">
				<img width="1200" height="764" src="
<?php
Lf_Utils::get_svg( $report_folder . 'k8s-production-clusters-desktop.svg', true );
?>
" alt="53% of respondents have 10+ hybrid clusters." loading="lazy">
			</picture>

			<div class="shadow-hr"></div>

			<h2 class="section-header">Kubernetes is emerging as the 'operating
				system' of the cloud</h2>

			<div aria-hidden="true" class="report-spacer-60"></div>

			<div class="lf-grid">
				<div class="restrictive-9-col">
					<p>According to Dynatrace's <a href="https://www.dynatrace.com/news/blog/kubernetes-in-the-wild-2023/">Kubernetes in the Wild 2023 report</a>, in 2021, in a typical Kubernetes cluster, application workloads accounted for most of the pods (59%). In contrast, all non-application workloads (system and auxiliary workloads) played a relatively smaller part.<br><br>
						In 2023, this picture was reversed. Auxiliary workloads outnumbered application workloads (63% vs. 37%) as organizations increasingly adopted advanced Kubernetes platform technologies like security controls, service meshes, messaging systems, and observability tools. At the same time, organizations used Kubernetes for a broader range of use cases like build pipelines, scheduled utility workloads, etc. Kubernetes became the platform for running almost anything - emerging as the “operating system” of the cloud.
</p>
				</div>
			</div>

			<div aria-hidden="true" class="report-spacer-80"></div>

			<p
				class="sub-header">Percentage of total workloads: application <br class="show-over-1000">versus auxiliary workloads, 2021 to 2023</p>

			<div aria-hidden="true" class="report-spacer-60"></div>

			<picture>
				<source media="(max-width: 599px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'total-workloads-mobile.svg', true );
?>
">
				<source media="(min-width: 600px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'total-workloads-desktop.svg', true );
?>
">
				<img width="1200" height="476" src="
<?php
Lf_Utils::get_svg( $report_folder . 'total-workloads-desktop.svg', true );
?>
" alt="30% increase in application workloads, vs 211% increase in auxillary workloads."
					loading="lazy">
			</picture>

			<div aria-hidden="true" class="report-spacer-60"></div>

			<div class="lf-grid">
				<div class="restrictive-9-col">
					<p>Over 2021 to 2023, the growth of total auxiliary workloads outpaced that of total application workloads. The total number of auxiliary workloads in a typical Kubernetes cluster grew by 211% YoY, while the total number of application workloads grew by 30% YoY.</p>

				</div>
			</div>

			<div class="shadow-hr"></div>

			<div class="quote-with-name-container">
				<p
					class="quote-with-name-container__quote">At Dynatrace, we use Kubernetes for any new software project, whether it's build pipelines or our SaaS offerings. We see the same trend with our customers. Kubernetes effectively has emerged as the operating system for the cloud.</p>
				<div class="quote-with-name-container__marks">
					<p
						class="quote-with-name-container__name">Anita Schreiner</p>
					<p
						class="quote-with-name-container__position">Dynatrace VP Delivery</p>
				</div>
			</div>

			<div class="shadow-hr"></div>

			<h2 class="section-header">CNCF projects</h2>

			<div aria-hidden="true" class="report-spacer-60"></div>

			<div class="lf-grid">
				<div class="restrictive-10-col">
					<p
						class="random-larger-paragraphs">The adoption of CNCF incubated and graduated projects once again increased in 2023, with <a href="https://www.cncf.io/projects/opentelemetry/">OpenTelemetry</a> and <a href="https://www.cncf.io/projects/argo/">Argo</a> scoring the largest jumps in usage. The former rose from 4% in 2020 to 20% in 2023 and the later from 10% to 28%. Meanwhile <a href="https://www.cncf.io/projects/containerd/">Containerd</a> (36% to 56%) and <a href="https://www.cncf.io/projects/coredns/">CoreDNS</a> (48% to 56%) are the graduated projects with the greatest increase in use and evaluation.</p>
				</div>
			</div>

			<div aria-hidden="true" class="report-spacer-80"></div>

			<p
				class="sub-header">Is your organization using in production or evaluating graduated / <br class="show-over-1000">incubating CNCF projects?</p>

			<div aria-hidden="true" class="report-spacer-60"></div>

			<div class="lf-grid">
				<div class="restrictive-9-col">
					<p>Small dips in adoption were felt by <a href="https://www.cncf.io/projects/linkerd/">Linkerd</a> and <a href="https://www.cncf.io/projects/open-policy-agent-opa/">OPA</a>. Both projects also saw fewer respondents evaluating the technologies, which is not shown in this chart. In 2021 25% were using or evaluating Linkerd, and that dropped to 17% in 2023. For OPA, it went from 30% to 23%.<br><br>Despite small drops in mindshare, there are also signs that usage among Linkerd's existing user base continues to increase. In fact, Buoyant, the creators of Linkerd, reported 100% year-on-year growth in 2023 Q3 of 30-day or older reporting clusters (the count of unique Linkerd-enabled clusters in the full open source Linkerd community).</p>
				</div>
			</div>

			<div aria-hidden="true" class="report-spacer-60"></div>

			<picture>
				<source media="(max-width: 599px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'use-of-cncf-projects-mobile.svg', true );
?>
">
				<source media="(min-width: 600px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'use-of-cncf-projects-desktop.svg', true );
?>
">
				<img width="1200" height="925" src="
<?php
Lf_Utils::get_svg( $report_folder . 'use-of-cncf-projects-desktop.svg', true );
?>
" alt="Use of Argo, containerd, Core DNS and Open Telemetry were all up in 2023."
					loading="lazy">
			</picture>

			<div class="shadow-hr"></div>

			<p class="sub-header">30 DAY OR OLDER REPORTING CLUSTERS</p>

			<div aria-hidden="true" class="report-spacer-60"></div>

			<div class="lf-grid">
				<div class="restrictive-10-col">
					<p>According to Linkerd maintainers: <a href="https://glossary.cncf.io/mutual-transport-layer-security/">mutual TLS</a> continues to be the primary, though not only, driver of Linkerd adoption. Adopters are looking for ways to secure the communication between <a href="https://glossary.cncf.io/nodes/">nodes</a> in a cluster, and Linkerd's drop-in mTLS provides not just encryption but authentication based on strong workload identity. <a href="https://glossary.cncf.io/zero-trust-architecture/">Zero trust</a> is a big topic of discussion, and Linkerd's sidecar-based approach is a natural fit for this: each proxy acts as the enforcement point for its pod.</p>
				</div>
			</div>

			<div aria-hidden="true" class="report-spacer-60"></div>

			<picture>
				<source media="(max-width: 599px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'reporting-clusters-mobile.svg', true );
?>
">
				<source media="(min-width: 600px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'reporting-clusters-desktop.svg', true );
?>
">
				<img width="1200" height="370" src="
<?php
Lf_Utils::get_svg( $report_folder . 'reporting-clusters-desktop.svg', true );
?>
" alt="100% Year-on-year growth in 2023 Q3 of 30-day or older reporting clusters"
					loading="lazy">
			</picture>

			<div aria-hidden="true" class="report-spacer-60"></div>

			<div class="lf-grid">
				<div class="restrictive-9-col">
					<p><strong>NOTES</strong><br>These numbers represent the normalized count unique Linkerd-enabled clusters in the full open source Linkerd community. Linkerd-enabled clusters younger than 30 days are excluded. All numbers have been normalized so that Q1 2020 is 100; actual cluster numbers are much higher but are not provided for competitive reasons. Not all clusters are reflected in these counts so they represent a lower bound on the true count.</p>
				</div>
			</div>

			<div class="shadow-hr"></div>

			<div class="lf-grid">
				<div class="restrictive-7-col">
					<p
						class="larger-sub-header">Observability tools show biggest growth in production</p>
				</div>
			</div>

			<div class="lf-grid">
				<div class="restrictive-9-col">
					<p>Dynatrace's data revealed a similar picture to CNCF survey responses: the percentage of organizations using Kubernetes security tools increased from 22% in 2021 to 34% in 2023 - corresponding to an annual growth rate of 55%. That trend will likely continue as security awareness grows and a new class of security solutions becomes available.<br><br>71% of all organizations ran databases and caches in Kubernetes, representing a 48% year-on-year increase. Together with messaging systems (36% growth), organizations were increasingly using databases and caches to persist application workload states.<br><br><a href="https://glossary.cncf.io/continuous-integration/">Continuous integration</a> and <a href="https://glossary.cncf.io/continuous-delivery/">delivery</a> (CI/CD) technologies grew by 43% year-on-year, indicating that organizations are dedicating significantly more Kubernetes clusters to running software build, test, and deployment pipelines.</p>
				</div>
			</div>
			<div aria-hidden="true" class="report-spacer-80"></div>

			<p class="sub-header">Kubernetes growth areas</p>

			<div aria-hidden="true" class="report-spacer-60"></div>

			<div class="lf-grid">
				<div class="restrictive-9-col">
					<p>Focusing on non-application workloads, enterprises used an increasing variety of technologies. This reflects the need to enhance Kubernetes with better observability, security, and service-to-service communications. Other technologies enable specific use cases like CI/CD tools or databases.<br><br>Across all categories, <strong>open source projects rank among the most frequently used solutions</strong>.</p>
				</div>
			</div>

			<div aria-hidden="true" class="report-spacer-60"></div>

			<picture>
				<source media="(max-width: 599px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'kubernetes-growth-areas-mobile.svg', true );
?>
">
				<source media="(min-width: 600px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'kubernetes-growth-areas-desktop.svg', true );
?>
">
				<img width="1200" height="562" src="
<?php
Lf_Utils::get_svg( $report_folder . 'kubernetes-growth-areas-desktop.svg', true );
?>
" alt="Through all categories of observability open source projects usage has grown."
					loading="lazy">
			</picture>

			<div class="shadow-hr"></div>

			<div class="lf-grid">
				<div class="restrictive-8-col">
					<p
						class="larger-sub-header">Technology adoption is much greater than previously thought</p>
				</div>
			</div>

			<div class="lf-grid">
				<div class="restrictive-9-col">
					<p>In our older surveys, we had only asked if technologies had been used in production. This year we differentiated between production, for most or all applications or business segments, and just selected usage.<br><br>Partly as a consequence, we saw a large bump in usage, with service mesh going from 27% in 2020 to 47% in 2023, and serverless architecture/<a href="https://glossary.cncf.io/function-as-a-service/">FaaS</a> moving from 30% to 53%. There has been a dramatic jump over the last year of service proxies being used among the CNCF community.</p>
				</div>
			</div>

			<div aria-hidden="true" class="report-spacer-60"></div>

			<p class="sub-header">Production Usage</p>

			<div aria-hidden="true" class="report-spacer-60"></div>

			<picture>
				<source media="(max-width: 599px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'production-usage-mobile.svg', true );
?>
">
				<source media="(min-width: 600px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'production-usage-desktop.svg', true );
?>
">
				<img width="1200" height="427" src="
<?php
Lf_Utils::get_svg( $report_folder . 'production-usage-desktop.svg', true );
?>
" alt="Usage of service mesh has gone from 27% in 2020 to 47% in 2023, and serverless architecture/FaaS has gone from 30% to 53% usage."
					loading="lazy">
			</picture>

			<div aria-hidden="true" class="report-spacer-80"></div>

			<p
				class="sub-header">End user organizations that have used WebAssembly, <br class="show-over-1000">with WasmEdge and WAMR being the top runtimes</p>

			<div aria-hidden="true" class="report-spacer-60"></div>

			<p
				style="font-weight: 800; font-size: 136.605px;line-height: 137px; color: #542AED;">37%</p>

			<div class="shadow-hr"></div>

			<p
				class="question">Have you or your organization ever deployed an <br class="show-over-1000">application using WebAssembly?</p>

			<p class="sub-header">End Users</p>

			<div aria-hidden="true" class="report-spacer-40"></div>

			<picture>
				<source media="(max-width: 599px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'wasm-end-users-mobile.svg', true );
?>
">
				<source media="(min-width: 600px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'wasm-end-users-desktop.svg', true );
?>
">
				<img width="1200" height="217" src="
<?php
Lf_Utils::get_svg( $report_folder . 'wasm-end-users-desktop.svg', true );
?>
" alt="61% of end user respondents have deployed an application using WebAssembly"
					loading="lazy">
			</picture>

			<div aria-hidden="true" class="report-spacer-120"></div>

			<p class="sub-header">Non-End Users</p>

			<div aria-hidden="true" class="report-spacer-40"></div>

			<picture>
				<source media="(max-width: 599px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'wasm-non-end-users-mobile.svg', true );
?>
">
				<source media="(min-width: 600px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'wasm-non-end-users-desktop.svg', true );
?>
">
				<img width="1200" height="204" src="
<?php
Lf_Utils::get_svg( $report_folder . 'wasm-non-end-users-desktop.svg', true );
?>
" alt="40% of non-end user respondents have deployed an application using WebAssembly"
					loading="lazy">
			</picture>

			<div class="shadow-hr"></div>

			<p
				class="question">Have you used or are aware of the following <br class="show-over-1000">WebAssembly runtimes?</p>

			<picture>
				<source media="(max-width: 599px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'wasm-runtimes-mobile.svg', true );
?>
">
				<source media="(min-width: 600px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'wasm-runtimes-desktop.svg', true );
?>
">
				<img width="1200" height="606" src="
<?php
Lf_Utils::get_svg( $report_folder . 'wasm-runtimes-desktop.svg', true );
?>
" alt="From all respondents they have used or are using the following WebAssembly runtimes - 53% WasmEdge, 51% WAMR, 40% Wasmer."
					loading="lazy">
			</picture>

			<div class="shadow-hr"></div>

			<div class="lf-grid">
				<div class="restrictive-9-col">
					<p
						class="larger-sub-header">Security, documentation, and inactivity are the top challenges CNCF project users expect</p>
				</div>
			</div>

			<div aria-hidden="true" class="report-spacer-60"></div>

			<div class="lf-grid">
				<div class="restrictive-9-col">
					<p
						class="random-larger-paragraphs">The greatest concern for respondents using cloud native open source projects was that a project would become inactive. This was followed closely by security vulnerabilities and lack of documentation.</p>
				</div>
			</div>

			<div class="shadow-hr"></div>

			<div class="quote-with-name-container">
				<p
					class="quote-with-name-container__quote">While we've archived a couple projects in the past, like rkt, opentracing etc. we don't have particularly inactive projects in CNCF that would meet the bar to be archived currently. Of course, adopting sandbox projects is a bit riskier than graduated ones, and this is reflected in CNCF's project maturity process - graduated projects are very safe to bet on.</p>
				<div class="quote-with-name-container__marks">
					<p
						class="quote-with-name-container__name">Chris Aniszczyk</p>
					<p class="quote-with-name-container__position">CTO, CNCF</p>
				</div>
			</div>

			<div class="shadow-hr"></div>

			<p
				class="sub-header">Challenges When Using CNCF Projects in Production</p>

			<div aria-hidden="true" class="report-spacer-60"></div>

			<div class="lf-grid">
				<div class="restrictive-9-col">
					<p>However, the survey demonstrated the ways users are mitigating these concerns. We see that the adoption of security policies and GitOps are highly correlated. Use of CNCF security projects is also an indicator of an advanced approach to security. Meanwhile, Observability tools are deployed in many different environments.</p>
				</div>
			</div>

			<div aria-hidden="true" class="report-spacer-60"></div>

			<picture>
				<source media="(max-width: 599px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'challenge-in-production-mobile.svg', true );
?>
">
				<source media="(min-width: 600px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'challenge-in-production-desktop.svg', true );
?>
">
				<img width="1200" height="212" src="
<?php
Lf_Utils::get_svg( $report_folder . 'challenge-in-production-desktop.svg', true );
?>
" alt="37% of respondents felt that becoming inactive was a challenge."
					loading="lazy">
			</picture>

			<div class="shadow-hr"></div>

			<p
				class="question">What is the status of the following security and compliance related activities in your IT organization?</p>

			<picture>
				<source media="(max-width: 599px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'sec-com-mobile.svg', true );
?>
">
				<source media="(min-width: 600px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'sec-com-desktop.svg', true );
?>
">
				<img width="1200" height="895" src="
<?php
Lf_Utils::get_svg( $report_folder . 'sec-com-desktop.svg', true );
?>
" alt="42% of respondents have fully implemented a security policy for software development that addresses open source software."
					loading="lazy">
			</picture>

			<div class="shadow-hr"></div>

			<p
				class="question">Fully implemented security / compliance activities by GitOps maturity</p>

			<picture>
				<source media="(max-width: 599px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'gitops-maturity-mobile.svg', true );
?>
">
				<source media="(min-width: 600px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'gitops-maturity-desktop.svg', true );
?>
">
				<img width="1200" height="922" src="
<?php
Lf_Utils::get_svg( $report_folder . 'gitops-maturity-desktop.svg', true );
?>
" alt="57% of respondents have a security policy for software development that addresses open source software and nearly all of our deployment practices and tools adhere to GitOps principles."
					loading="lazy">
			</picture>

			<div class="shadow-hr"></div>

			<p
				class="question">What is the status of the following security and compliance related activities in your IT organization?</p>

			<picture>
				<source media="(max-width: 599px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'sec-com-status-mobile.svg', true );
?>
">
				<source media="(min-width: 600px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'sec-com-status-desktop.svg', true );
?>
">
				<img width="1200" height="413" src="
<?php
Lf_Utils::get_svg( $report_folder . 'sec-com-status-desktop.svg', true );
?>
" alt="57% of respondents use a CNCF graduating/incubating project."
					loading="lazy">
			</picture>

			<div aria-hidden="true" class="report-spacer-120"></div>

			<p
				class="sub-header">Security projects at the time survey was fielded</p>

			<div aria-hidden="true" class="report-spacer-60"></div>

			<div class="logo-grid">
				<div class="logo-grid__box">
					<img loading="lazy" width="100" height="80" src="
						<?php
						LF_Utils::get_svg( $report_folder . 'logo-project-falco.svg', true );
						?>
						" alt="Falco Logo" class="logo-grid__image">
				</div>
				<div class="logo-grid__box">
					<img loading="lazy" width="100" height="80"  src="
						<?php
						LF_Utils::get_svg( $report_folder . 'logo-project-in-toto.svg', true );
						?>
						" alt="In-Toto Logo" class="logo-grid__image">
				</div>
				<div class="logo-grid__box">
					<img loading="lazy" width="100" height="80"  src="
						<?php
						LF_Utils::get_svg( $report_folder . 'logo-project-notary.svg', true );
						?>
						" alt="Notary Logo" class="logo-grid__image">
				</div>
				<div class="logo-grid__box">
					<img loading="lazy" width="100" height="80"  src="
						<?php
						LF_Utils::get_svg( $report_folder . 'logo-project-opa.svg', true );
						?>
						" alt="Open Policy Agent Logo" class="logo-grid__image">
				</div>
				<div class="logo-grid__box">
					<img loading="lazy" width="100" height="80"  src="
						<?php
						LF_Utils::get_svg( $report_folder . 'logo-project-tuf.svg', true );
						?>
						" alt="TUF Logo" class="logo-grid__image">
				</div>
			</div>
		</section>

		<section class="section-07 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="lf-grid thanks">
					<div class="thanks__col1">
						<h2 class="section-header">Thank You</h2>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<p
							class="thanks__opening">A huge thank you to everyone who participated in our survey.</p>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<div class="wp-block-button hero__button"><a
								href="https://github.com/cncf/surveys/tree/main/cloudnative"
								class="wp-block-button__link"
								title="View the full dataset">
								View the full dataset</a>
						</div>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<p>If you have any questions or feedback, please get in touch at <a href="mailto:info@cncf.io">info@cncf.io</a>. </p>

					</div>
					<div class="thanks__col2">
						<?php
							LF_Utils::display_responsive_images( 103549, 'full', '1200px', '', 'lazy', 'Stacked box-like shapes meant to symbolise containers' );
						?>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p><strong>Copyright © 2024 The Linux Foundation</strong><br>This report is licensed under the Creative Commons Attribution-NoDerivatives 4.0 International Public License. <br class="show-over-1000">To reference the work, please cite “Cloud Native Computing Foundation Annual Survey 2023.”</p>


			</div>
		</section>


	</article>
</main>
<?php
// 83148

get_template_part( 'components/footer' );
