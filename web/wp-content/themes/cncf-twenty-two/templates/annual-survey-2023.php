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
								href="https://data.world/thelinuxfoundation/2023-cncf-annual-survey"
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
					<p>As always, we are happy to share our full dataset for the Annual Survey, available at <a href="https://data.world/thelinuxfoundation/2023-cncf-annual-survey">data.world/thelinuxfoundation</a>.</p>
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
						<p class="sub-header">USING OR <br/>EVALUATING <br/>KUBERNETES</p>

						<span class="sidebar-number">84%</span>

						Up from 81% in 2022
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
						Average number of unique cloud service providers
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>


				<p class="question">Which of the following combinations of data center and cloud architectures does your organization use?</p>
				<p class="larger-sub-sub-header">Segmented by Adoption</p>

				<picture>
					<source media="(max-width: 599px)" srcset="
						<?php
						Lf_Utils::get_svg( $report_folder . 'data-center-sba-mobile.svg', true );
						?>
						">
											<source media="(min-width: 600px)" srcset="
						<?php
						Lf_Utils::get_svg( $report_folder . 'data-center-sba-desktop.svg', true );
						?>
						">
											<img width="1200" height="341" src="
						<?php
						Lf_Utils::get_svg( $report_folder . 'data-center-sba-desktop.svg', true );
						?>
						" alt="Which of the following combinations of data center and cloud architectures does your organization use? Segmented by Adoption."
						loading="lazy">
				</picture>
				<div aria-hidden="true" class="report-spacer-100"></div>

				<p class="question">Which of the following combinations of data center and cloud architectures does your organization use?</p>
				<p class="larger-sub-sub-header">Segmented by Total Employees</p>

				<picture>
					<source media="(max-width: 599px)" srcset="
						<?php
						Lf_Utils::get_svg( $report_folder . 'data-center-sbe-mobile.svg', true );
						?>
						">
											<source media="(min-width: 600px)" srcset="
						<?php
						Lf_Utils::get_svg( $report_folder . 'data-center-sbe-desktop.svg', true );
						?>
						">
											<img width="1200" height="341" src="
						<?php
						Lf_Utils::get_svg( $report_folder . 'data-center-sbe-desktop.svg', true );
						?>
						" alt="Which of the following combinations of data center and cloud architectures does your organization use? Segmented by Employees."
						loading="lazy">
				</picture>


				<div class="shadow-hr"></div>

				<p class="question">Which of the following combinations of data center and cloud architectures does your organization use?</p>

				<picture>
					<source media="(max-width: 599px)" srcset="
						<?php
						Lf_Utils::get_svg( $report_folder . 'data-centers-mobile.svg', true );
						?>
						">
											<source media="(min-width: 600px)" srcset="
						<?php
						Lf_Utils::get_svg( $report_folder . 'data-centers-desktop.svg', true );
						?>
						">
											<img width="1200" height="341" src="
						<?php
						Lf_Utils::get_svg( $report_folder . 'data-centers-desktop.svg', true );
						?>
						" alt="Which of the following combinations of data center and cloud architectures does your organization use?"
						loading="lazy">
				</picture>

				<div class="shadow-hr"></div>

				<p class="question">Which of the following combinations of data center and cloud architectures does your organization use?</p>

				<picture>
					<source media="(max-width: 599px)" srcset="
						<?php
						Lf_Utils::get_svg( $report_folder . 'data-centers-bubble-mobile.svg', true );
						?>
						">
											<source media="(min-width: 600px)" srcset="
						<?php
						Lf_Utils::get_svg( $report_folder . 'data-centers-bubble-desktop.svg', true );
						?>
						">
											<img width="1386" height="670" src="
						<?php
						Lf_Utils::get_svg( $report_folder . 'data-centers-bubble-desktop.svg', true );
						?>
						" alt="Which of the following combinations of data center and cloud architectures does your organization use?"
						loading="lazy">
				</picture>

				<div class="shadow-hr"></div>

				<div class="lf-grid">
				<div class="restrictive-9-col">
					<p
						class="larger-sub-header">APAC cloud native computing usage lags behind North America and Europe</p>

				</div>
				</div>
				<div aria-hidden="true" class="report-spacer-20"></div>

				<div class="lf-grid as23__grid">
					<div class="as23__grid-col1">
						<p>Asia-Pacific (APAC) lags significantly behind North America and Europe in the adoption of cloud native technologies across end user organizations (those whose primary revenue is not derived from selling cloud native products and services). When we filter the data to remove vendors and focus on end user organizations, 26% in Asia-Pacific either have not started or are just beginning to use cloud native techniques compared to 9% for the Americas and 6% for Europe. Similarly, only 9% of end user organizations in Asia-Pacific do nearly all of their development and 21% do much of their development using cloud native techniques – for a total of 30%. In the Americas, this total (nearly all or much development and deployment use cloud native techniques) is 64% and in Europe, 61%.</p>
						<p>A segmentation at the country level for Asia-Pacific shows that the share of organizations who have not started, or are just beginning, to use cloud native techniques is a dominant theme in every country – but especially so in Japan. Japan’s penetration of organizations who have not started or are just beginning to use cloud native techniques is 18% – triple the rate of India (6%), a country with nearly the same GDP. Even in China, which has a GDP that is more than four times larger than Japan, the not started/just beginning penetration rate is 13%.</p>
						<p>There are many challenges to overcome in Asia-Pacific, including the lack of high-speed internet services, the cost to transition systems and staff to cloud computing paradigms, concerns about security, control, and reliability, skills shortages, and a deeply entrenched reliance on legacy systems. However, governmental investment in digital transformation has never been higher, suggesting that the pace of cloud adoption is rapidly changing.</p>
					</div>
					<div class="as23__grid-col2">
						“Some” or “much/all” development and deployment is cloud native
						<span class="sidebar-number-green">82% Europe</span>
						<span class="sidebar-number-purple">70% The Americas</span>
						<span class="sidebar-number-gold">40% Asia-Pacific</span>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<p class="question">What is the location of your organization's headquarters?</p>
				<p class="larger-sub-sub-header">Segmented By Extent Organization Has Adopted Cloud Native Techniques </p>

				<img loading="lazy" width="1170" height="835" src="
					<?php LF_Utils::get_svg( $report_folder . 'location-sba-desktop.svg', true ); ?>
					" alt="What is the location of your organization's headquarters?">

				<div class="shadow-hr"></div>


				<p class="question">What is the location of your organization's headquarters?</p>
				<p class="larger-sub-sub-header">Segmented By Extent Organization Has Adopted Cloud Native Techniques </p>

				<picture>
					<source media="(max-width: 599px)" srcset="
						<?php
						Lf_Utils::get_svg( $report_folder . 'location-sbe-mobile.svg', true );
						?>
						">
											<source media="(min-width: 600px)" srcset="
						<?php
						Lf_Utils::get_svg( $report_folder . 'location-sbe-desktop.svg', true );
						?>
						">
											<img width="1226" height="885" src="
						<?php
						Lf_Utils::get_svg( $report_folder . 'location-sbe-desktop.svg', true );
						?>
						" alt="What is the location of your organization's headquarters?"
						loading="lazy">
				</picture>

				<div class="shadow-hr"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>However, it’s worth noting that Asia Pacific’s IT vendors and service providers have a stronger affinity for new technologies than North America or Europe – reporting higher adoption of WebAssembly, service proxies, service meshes, and serverless architectures. This is particularly evident in the adoption of WebAssembly, adopted by 21% of organizations, compared to 14% for Europe and 11% for the Americas.</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<p class="question">Have you or your organization ever deployed an application using webAssembly?</p>
				<p class="larger-sub-sub-header">Segmented by what is the Location of your Organization’s Headquarters</p>

				<img loading="lazy" width="1202" height="815" src="
					<?php LF_Utils::get_svg( $report_folder . 'wasm-desktop.svg', true ); ?>
					" alt="Have you or your organization ever deployed an application using webAssembly?">

				<div class="shadow-hr"></div>

				<div class="lf-grid">
				<div class="restrictive-9-col">
					<p
						class="larger-sub-header">Containers core to delivering cloud native solutions, but not without challenges</p>

				</div>
				</div>
				<div aria-hidden="true" class="report-spacer-20"></div>

				<div class="lf-grid as23__grid">
					<div class="as23__grid-col1">
						<p>Container use (including those organizations piloting or actively evaluating containers) is greater than 90% and more than 90% of organizations where much, or nearly all, of their app development and deployment is cloud native rely on containers containers.</p>
						<p>However, using containers is not without challenges.Security is the leading challenge as reported by 40% of organizations who potentially or are generally consumers of cloud services.</p>
						<p>Monitoring and observability are fast becoming more challenging, especially for systems with large numbers of containers. Running containers at scale requires real-time data collection of metrics, events, and logs in order to support proactive system management, so it’s not surprising that projects like Prometheus and Open Telemetry were more widely adopted in 2023. (See: Project Penetration trends upwards across incubating and graduating projects.)</p>
					</div>
					<div class="as23__grid-col2">
						<span class="sidebar-number">46%</span>
						say lack of training is the biggest challenge facing organizations that have not started, or are just beginning, their cloud native journey
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<p class="question">How are Containers Used Within your Organization?</p>
				<p class="larger-sub-sub-header">Segmented by Extent Organization Has Adopted Cloud Native Technologies </p>

				<picture>
					<source media="(max-width: 599px)" srcset="
						<?php
						Lf_Utils::get_svg( $report_folder . 'containers-mobile.svg', true );
						?>
						">
											<source media="(min-width: 600px)" srcset="
						<?php
						Lf_Utils::get_svg( $report_folder . 'containers-desktop.svg', true );
						?>
						">
											<img width="1226" height="885" src="
						<?php
						Lf_Utils::get_svg( $report_folder . 'containers-desktop.svg', true );
						?>
						" alt="How are Containers Used Within your Organization?"
						loading="lazy">
				</picture>

				<div class="shadow-hr"></div>

				<p class="question">What are your Challenges in Using / Deploying Containers?</p>
				<p class="larger-sub-sub-header">Segmented by Extent Organization Has Adopted Cloud Native Technologies </p>

				<picture>
					<source media="(max-width: 599px)" srcset="
						<?php
						Lf_Utils::get_svg( $report_folder . 'challenges-desktop.svg', true );
						?>
						">
											<source media="(min-width: 600px)" srcset="
						<?php
						Lf_Utils::get_svg( $report_folder . 'challenges-desktop.svg', true );
						?>
						">
											<img width="1226" height="885" src="
						<?php
						Lf_Utils::get_svg( $report_folder . 'challenges-desktop.svg', true );
						?>
						" alt="What are your Challenges in Using / Deploying Containers?"
						loading="lazy">
				</picture>








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
