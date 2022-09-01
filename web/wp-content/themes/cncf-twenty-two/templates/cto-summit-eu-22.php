<?php
/**
 * Template Name: CTO Summit EU 22
 * Template Post Type: lf_report
 *
 * File for the CTO Summit EU 22 Report
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

// Make use of the PDF report link in the editor.
// This way do not need to make a new commit just to update PDF link.
$pdf_url = get_post_meta( get_the_ID(), 'lf_report_pdf_url', true );

// Report folder in images/ folder.
$report_folder = 'reports/cto-summit-eu-22/';

get_template_part( 'components/header' );

?>

<link rel="prefetch"
	href="<?php echo esc_url( get_template_directory_uri() . '/build/cto-summit-eu-22.min.css' ); ?>"
	as="style" crossorigin="anonymous" />

<?php

wp_enqueue_style( 'cto-summit-eu-22', get_template_directory_uri() . '/build/cto-summit-eu-22.min.css', array(), filemtime( get_template_directory() . '/build/cto-summit-eu-22.min.css' ), 'all' );

// setup sharing icons data..
$caption  = 'Read the CTO Summit Report: Resiliency in Multi-Cloud ';
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

<main class="cto-summit-eu-22">
	<article class="container wrap">
		<section class="hero alignfull background-image-wrapper">

			<figure class="background-image-figure darken-on-mobile">
				<?php LF_Utils::display_responsive_images( 78067, 'full', '1440px', false, 'eager', 'Priyanka and Taylor on stahe at the CTO Summit EU 2022' ); ?>
			</figure>
			<div class="background-image-text-overlay">
				<div class="container wrap hero__container">

					<div class="hero__wrapper">
						<img class="hero__logo"
							src="<?php LF_Utils::get_svg( $report_folder . 'kubecon-eu-2022-logo.svg', true ); ?>"
							width="309" height="135"
							alt="KubeCon + CloudNativeCon Europe 2022 Logo"
							loading="eager">

						<h1 class="hero__title uppercase">CTO Summit <br /><span
								style="font-weight: 400">Resiliency in
								<br />Multi-Cloud</span>
						</h1>

						<div class="hero__hr"></div>

						<div class="hero__button-share-align">

							<div class="wp-block-button hero__button"><a
									href="<?php echo esc_url( $pdf_url ); ?>"
									class="wp-block-button__link"
									title="Download this report as a PDF">Download
									PDF</a>
							</div>

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
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="section-01">

			<div class="lf-grid">
				<h2 class="section-01__title uppercase">Foreword
				</h2>
			</div>

			<div class="lf-grid section-01__grid">
				<div class="section-01__grid-col1">
					<p>The goal of the Linux Foundation, and Cloud Native Computing Foundation (CNCF) is to share the best software innovations and practices to move technologies, and thereby companies, economies, and societies, forward. The rise of cloud computing, and cloud native computing, comprises one of the largest shifts that the computing industry has seen in decades. There are several benefits of cloud computing. Companies get the computing power that they need when they need it and can scale applications and workloads faster. Additionally, the cloud democratizes resources and makes them more accessible to more companies and entities of all sizes.</p>

					<p>The idea years ago that companies would move all applications to one cloud provider has not panned out, with good reason. Companies cannot afford to have their operations disrupted by cloud or network outages, which often occur. Resiliency in a cloud-defined world means being able to maintain operations under all circumstances and adjust accordingly, especially in the face of unexpected events.</p>

					<p><strong>Multi-Cloud</strong> is the practice of using services (e.g., computing, databases, and networking) from more than one cloud service provider (CSP) at the same time. Multi-Cloud can include public CSPs, such as Amazon Web Services (AWS) and Microsoft Azure, private clouds, or a combination of the two.</p>

					<p>Despite the advantages of Multi-Cloud, companies struggle to succeed with Multi-Cloud and achieve resilience and optimal operations under all conditions. This emerging arena inspired the Linux Foundation and the CNCF to host the first-ever Chief Technology Officer (CTO) Summit about Multi-Cloud resiliency and how to achieve it.</p>

					<div class="paragraph-quote">
						<p><strong>The May 18, 2022 summit included 21 participants from six business verticals. The participants represented diverse industry sectors and functions, including aeronautics, automotive, semiconductor, insurance, telecommunication, healthcare, business services, technology, banking, fintech and finance, e-commerce, social media, and audio streaming.</strong></p>

						<p><strong>Generally speaking, the participants held leading information technology roles in their companies, ranging from the chief Kubernetes architects to the CTO level.</strong></p>
					</div>

					<p>They all experience Multi-Cloud differently. Some companies deal with it within their organization, while others consult and support their customers on the subject. It is often a combination of both.</p>

					<p><strong>The following criteria were critical:</strong></p>

					<ul>
						<li>Experience in Multi-Cloud and associated
							technologies</li>
						<li>Decision-making and budget accountability </li>
						<li>Cloud native knowledge </li>
					</ul>

					<p>In addition, all participants are consumers of cloud services rather than providers, which the CNCF and the technology industry broadly define as the <a href="https://www.cncf.io/enduser/">end-user community</a>.</p>

					<p>The following report captures the significant findings of the Summit participants, the questions raised, and the concerns that must be addressed.</p>
				</div>

				<div class="section-01__grid-col2">
					<div class="section-01__grid-col2-inner">
						<h2 class="sub-header">
							CTO Summit commitee</h2>

						<div class="section-01__grid-col2-commitee-wrapper">
							<div class="commitee">
								<img class="commitee__image" loading="lazy"
									src="<?php LF_utils::get_image( $report_folder . 'Amr-Abdelhalem.jpg' ); ?>"
									alt="Amr Abdelhalem" width="100"
									height="100">
								<div class="commitee__text">
									<p><strong>Amr Abdelhalem</strong></p>
									<a href="https://www.fidelity.com/"
										title="Visit Fidelity Investments">
										<img class="commitee__logo"
											loading="lazy"
											src="<?php LF_utils::get_svg( $report_folder . 'logo-fidelity-investments.svg', true ); ?>"
											alt="Fidelity Investments Logo"
											width="180" height="38">
									</a>
								</div>
							</div>
							<div class="commitee">
								<img class="commitee__image" loading="lazy"
									src="<?php LF_utils::get_image( $report_folder . 'Arun-Gupta.jpg' ); ?>"
									alt="Arun Gupta" width="100" height="100">
								<div class="commitee__text">
									<p><strong>Arun Gupta</strong></p>
									<a href="https://www.intel.com/content/www/us/en/homepage.html"
										title="Visit Intel">
										<img class="commitee__logo"
											loading="lazy"
											src="<?php LF_utils::get_svg( $report_folder . 'logo-intel.svg', true ); ?>"
											alt="Intel Logo" width="180"
											height="38">
									</a>
								</div>
							</div>
							<div class="commitee">
								<img class="commitee__image" loading="lazy"
									src="<?php LF_utils::get_image( $report_folder . 'Ricardo-Torres.jpg' ); ?>"
									alt="Ricardo Torres" width="100"
									height="100">
								<div class="commitee__text">
									<p><strong>Ricardo Torres</strong></p>
									<a href="https://www.boeing.com/"
										title="Visit Boeing">
										<img class="commitee__logo"
											loading="lazy"
											src="<?php LF_utils::get_svg( $report_folder . 'logo-boeing.svg', true ); ?>"
											alt="Boeing Logo" width="180"
											height="38"></a>
								</div>
							</div>
							<div class="commitee">
								<img class="commitee__image" loading="lazy"
									src="<?php LF_utils::get_image( $report_folder . 'Pratik-Wadher.jpg' ); ?>"
									alt="Pratik Wadher" width="100"
									height="100">
								<div class="commitee__text">
									<p><strong>Pratik Wadher</strong></p>
									<a href="https://www.intuit.com/"
										title="Visit Intuit">
										<img class="commitee__logo"
											loading="lazy"
											src="<?php LF_utils::get_svg( $report_folder . 'logo-intuit.svg', true ); ?>"
											alt="Intuit Logo" width="180"
											height="38">
									</a>
								</div>
							</div>
							<div class="commitee">
								<img class="commitee__image" loading="lazy"
									src="<?php LF_utils::get_image( $report_folder . 'Priyanka-Sharma.jpg' ); ?>"
									alt="Priyanka Sharma" width="100"
									height="100">
								<div class="commitee__text">
									<p><strong>Priyanka Sharma</strong></p>
									<a href="https://cncf.io/"
										title="Visit CNCF">
										<img class="commitee__logo"
											loading="lazy"
											src="<?php LF_utils::get_svg( $report_folder . 'cncf-logo.svg', true ); ?>"
											alt="CNCF Logo" width="180"
											height="38">
									</a>
								</div>
							</div>
							<div class="commitee">
								<img class="commitee__image" loading="lazy"
									src="<?php LF_utils::get_image( $report_folder . 'Hilary-Carter.jpg' ); ?>"
									alt="Hilary Carter" width="100"
									height="100">
								<div class="commitee__text">
									<p><strong>Hilary Carter</strong></p>
									<a href="https://www.linuxfoundation.org/research/"
										title="Visit Linux Foundation Research">
										<img class="commitee__logo"
											loading="lazy"
											src="<?php LF_utils::get_image( $report_folder . 'logo-lf-research.png' ); ?>"
											alt="Linux Foundation Logo" width="180"
											height="38">
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="section-02 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">Executive <br />
						Summary</h2>
					<div class="section-number">1/6</div>
				</div>

				<div class="lf-grid">
					<div class="restrictive-column">

						<p>Today, Multi-Cloud is a reality for many companies and organizations and will become more so as cloud native architectures mature. The rise of Multi-Cloud is driven by several factors, including mergers and acquisitions that bring different clouds together into one entity and the desire to avoid widespread outages by spreading the workload and risk across multiple clouds.</p>

						<p>Currently, <a href="https://www.flexera.com/blog/cloud/cloud-computing-trends-2022-state-of-the-cloud-report/" title="Cloud Computing Trends 2022 Report">more than 90% of enterprises have a Multi-Cloud strategy</a>, 82% have a hybrid cloud strategy, and more of the same is to come. The COVID-19 pandemic has caused organizations to <a href="https://www.logicmonitor.com/resource/cloud-2025" title="Cloud 2025: The future of workloads in a cloud-first, post-COVID-19 world">accelerate their migration to the cloud</a>.</p>

						<p>Multi-Cloud resiliency means avoiding or mitigating an adverse event's impact and being ready for unexpected outcomes. Achieving Multi-Cloud resiliency requires different approaches than those that are used within a single cloud, no-cloud environments, or even hybrid cloud environments. Finding a path to federate Multi-Cloud architectures is a growing concern for many organizations.</p>

						<p>To paraphrase the Summit participants: <strong>Multi-Cloud is an inevitable and significant challenge.</strong></p>

						<p>In general, the Summit participants agreed that there is a clear need for a Multi-Cloud strategy to govern a rollout. There is also a need for proven best practices to better deal with multiple cloud providers. Best practices should include a framework to exchange ideas and experiences. </p>

						<p>Perhaps most importantly, the Summit participants largely agreed that while there is the potential for better team performance, service availability, and lower operating costs with a Multi-Cloud environment, it has not materialized for many companies. This is because they have varying levels of knowledge and experience in managing multiple cloud environments, building something that is cloud native, handling the exponentially increasing risks that are inherent in Multi-Cloud environments, connecting clouds, and getting data out of a cloud once it is in without a hefty price tag. </p>

						<p>The Summit participants pointed out that challenges grow exponentially when organizations add multiple cloud providers. To achieve Multi-Cloud resiliency, entities need best practices when leveraging people, processes, and technologies. The Summit participants geared their discussion toward offering insights and best practices to help companies and organizations to achieve Multi-Cloud Resiliency.</p>

						<p><strong>We thank all participants for sharing their experiences, knowledge, and insight.</strong></p>
					</div>
				</div>
			</div>
		</section>

		<section class="section-03 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">Key <br />
						Findings</h2>
					<div class="section-number">2/6</div>
				</div>

				<div class="lf-grid">
					<div class="restrictive-column">

						<h2 class="sub-header">Multi-Cloud is here to stay</h2>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<ul>
							<li>Multi-Cloud challenges all organizations,
								regardless of the industry sector, business
								model, or technological maturity.</li>
							<li>Multi-cloud architecture requires new thinking
								models, workflows, and cloud native projects.</li>
							<li>Implementing a resilient Multi-Cloud solution is
								where we will see the most diversity in adoption
								and maintenance. </li>
							<li>The basic questions and challenges are the same,
								regardless of your organization's size or
								business vertical.</li>
							<li>A clear architecture with blueprints that
								reflect your organization and use cases
								encourage adoption and compliance. </li>
							<li>The most prevalent concern with Multi-Cloud
								availability is network federation across an
								organization.</li>
							<li>It is worth checking to see how you can use it
								to increase or improve your operations and
								achieve high availability, which is neither easy
								nor obvious. </li>
						</ul>

						<div aria-hidden="true" class="report-spacer-20"></div>

						<div class="quote-container">
							<p
								class="quote-container__quote">No organization is alone in facing challenges <br class="show-over-1000">to become a Multi-Cloud operator.</p>
						</div>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<div class="lf-grid">
					<div class="restrictive-column">

						<h2 class="sub-header">People and processes are crucial
							for success</h2>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<ul>
							<li>Multi-Cloud is not a technology-only topic.
								People and processes should not be an
								afterthought.</li>
							<li>Success requires a culture of going the extra
								mile.</li>
							<li>Organizational setup and people management are
								essential, regardless of the technology used.
							</li>
							<li>Managing access can be difficult, and not all
								workflows must migrate entirely into the cloud.
							</li>
							<li>Cloud environments are new and unique, so
								processes and governance will have to change and
								evolve significantly. </li>
							<li>Education and training are necessary to increase
								existing talent's skill levels or bring in new
								talent to a cloud native environment.</li>
							<li>To help organizations master new cloud computing
								challenges, sharing information via forums like
								the Summit and sharing best practices or other
								valuable information is a great start.</li>
							<li>Community is part of the solution. Bringing
								developers together in the community and
								learning from the open source community is
								critical.</li>
						</ul>

						<div aria-hidden="true" class="report-spacer-20"></div>

						<div class="quote-container">
							<p
								class="quote-container__quote">Community is part of the solution. Bringing developers together in the community and learning from the open source community is critical.</p>
						</div>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<div class="lf-grid">
					<div class="restrictive-column">

						<h2 class="sub-header">There are gaps to be closed</h2>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<ul>
							<li>Multi-Cloud exponentially increases known
								challenges and adds new ones.</li>
							<li>There are still some open topics without a solid
								solution or set of approaches. </li>
							<li>Most of the gaps are related to seamlessly
								connecting clouds from different providers.</li>
							<li>Entities should think beyond CSPs with
								Multi-Cloud and include other global
								infrastructure services, such as hostname
								resolution or content management.</li>
							<li>Use cases are better than blueprints. Things
								like reference architectures are too theoretical
								and difficult to adapt to different industries.
								Use cases are easier to consume and more
								practical. By design, solutions must be
								topic-based and tailored to the industry sector.
							</li>
							<li>New user groups (UGs) are necessary. Special
								interest groups (SIGs) in the CNCF currently
								represent a deep focus on a technology topic or
								workflow. Many companies are not staffed or do
								not have the time to attend SIG meetings
								regularly. More UGs that are focused on
								solutions within a specific business vertical
								will be beneficial alongside the SIGs. Companies
								can engage with SIGs as needs arise and UGs for
								the long term. </li>
						</ul>

						<div aria-hidden="true" class="report-spacer-20"></div>

						<div class="quote-container">
							<p
								class="quote-container__quote">Use cases are better than blueprints.</p>
						</div>
					</div>
				</div>

			</div>
		</section>

		<div
			class="section-04 alignfull background-image-wrapper section-break">
			<figure class="background-image-figure">
				<?php LF_Utils::display_responsive_images( 77932, 'full', '1440px', false, 'lazy', 'Conference attendees relaxing' ); ?>
			</figure>
		</div>

		<section class="section-05 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">Discussion <br />
						Topics</h2>
					<div class="section-number">3/6</div>
				</div>

				<div class="lf-grid">
					<div class="restrictive-column">
						<p>The Summit participants chose to focus on the following two primary topics:</p>

						<div aria-hidden="true" class="report-spacer-40"></div>

						<div class="number-align">
							<p class="bold-number">1</p>
							<div>
								<p><strong>Managing the cloud native ecosystem in one's
							organization</strong><br/>This is critical because as
						cloud native and microservices environments grow,
						entities face challenges in managing them. Tools and
						services may need to change, along with developer access
						to such things as Kubernetes clusters, namespaces, or
						applications.</p>
							</div>
						</div>

						<div class="number-align">
							<p class="bold-number">2</p>
							<div>
								<p><strong>Multi-Cloud availability</strong><br/>This topic
						covered the services that are necessary to achieve a
						resilient Multi-Cloud platform that enables regular
						iteration and improvement.</p>
							</div>
						</div>

						<p>The Summit participants were broken into three smaller sub-groups to facilitate deeper discussion. They were asked to concentrate on how leveraging people, processes, and technology in both arenas should—and could—change to increase Multi-Cloud resiliency and to identify what the priorities should be.</p>

					</div>
				</div>

				<div class="shadow-hr"></div>

				<div class="lf-grid">
					<div class="restrictive-column">

						<h2 class="sub-header"><span class="orange-text">1.</span> Managing the Cloud Native
							Ecosystem</h2>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<p>The introductory statement was as follows:</p>

						<p
							class="paragraph-quote larger">Managing Kubernetes clusters, compute, and applications across multiple clouds requires a particular set of tools and comprehensive workflows. <br><br>This discussion aims to understand which kinds of workflows teams should implement to allow for massive infrastructure scaling without massively scaling team sizes or budgets.</p>

					</div>
				</div>

				<div class="shadow-hr"></div>

				<div class="lf-grid">
					<div class="restrictive-column">

						<h2 class="sub-header">Best Practices</h2>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<h3 class="small-header">Technologies</h3>
						<div aria-hidden="true" class="report-spacer-20"></div>
						<ul>
							<li><strong>Strong opinions, loosely held</strong>.
								To increase resiliency, accept that the
								solutions that work today may not be the
								solutions that work tomorrow, and solutions at
								the scale that you have today may not be the
								solutions when you scale tomorrow.</li>
							<li><strong>Reduce complexity</strong>. Automation
								can significantly help, i.e., integrating
								governance checks or security tests in the
								delivery pipelines. With Multi-Cloud, different
								approaches and ways of working can cause
								friction among teams, and the presence of
								inconsistent processes hinders teams from doing
								their best. </li>
							<li><strong>Eliminate the "not invented here"
									mindset</strong>. There is no right or wrong
								approach with self-hosted/made vs. managed. It
								depends on your particular setup, organization,
								and business. Decisions must be transparent and
								based on the available skill sets and current
								challenges, including project time frames. The
								right choice today might not be the best
								tomorrow. The solution to the business problem
								should be the driver and not a particular
								technical interest.
							</li>
							<li><strong>Embrace regulatory reality</strong>. We
								all exist in regulated industries, as the
								General Data Protection Regulation (GDPR)
								impacts everyone. In the future, regulation may
								require a Multi-Cloud approach to lessen the
								impacts of outages and breaches.</li>
							<li><strong>Select where you are going to
									standardize</strong>. To do this, you must
								define your goal of what you want from a cloud
								and your standardization to achieve that goal.
							</li>
						</ul>

						<div aria-hidden="true" class="report-spacer-20"></div>

						<div class="quote-container">
							<p
								class="quote-container__quote">The products you have... might need to change as you migrate to the cloud.</p>
						</div>

					</div>
				</div>

				<div class="shadow-hr"></div>

				<h3 class="small-header">People and Processes</h3>
				<div aria-hidden="true" class="report-spacer-20"></div>

				<div class="lf-grid">
					<div class="restrictive-column">
						<ul>
							<li><strong>People make the difference</strong>.
								Technology
								will support master challenges, but people will
								implement solutions and drive the necessary
								change.
								Things like end-to-end responsibility are done
								on a
								human level. Technology cannot "go the extra
								mile," but
								people can. Company culture—in general, and in
								particular—plays a key role. Take empowerment
								and
								enablement seriously, i.e. leave technical
								decisions to
								the technicians, and trust the judgment of your
								staff
								with first-hand experience and knowledge.
								Recognize that
								some legacy teams will hinder the progress of
								people
								doing the Kubernetes or cloud-based work because
								they
								are worried about losing their jobs and fear
								change.
							</li>
							<li><strong>Craft an open source strategy and engage
									with
									projects</strong>. Participate in open
								source
								projects to reflect your use cases and needs.
								This can
								also influence the roadmap of vendors. Be
								mindful when
								combining proprietary technology and free and
								open
								source software in a solution or software stack.
							</li>
							<li><strong>Retain and upskill talent</strong>. This
								entails
								<a href="https://training.linuxfoundation.org/resources/2022-open-source-jobs-report/ "
									title="10th Annual Open Source Jobs Report">attracting
									new team members</a> and keeping the
								existing talent engaged and empowered.
								Multi-Cloud adds
								the additional dimension of needing even more
								skills.
								Furthermore, it includes upskilling and training
								and
								detecting unknown talents within your
								organization and
								developing them.
							</li>
							<li><strong>Use standards and governance as
									frameworks
									without limiting innovation</strong>. A
								means of
								control is needed regarding where the budget is
								spent.
								That is even more true in a Multi-Cloud setup.
								However,
								these frameworks should be seen as guidelines
								rather
								than rigid cages. There should be a place for
								experimentation and trying out new things. </li>
						</ul>

						<div aria-hidden="true" class="report-spacer-20"></div>

						<div class="quote-container">
							<p
								class="quote-container__quote">You must scale up your people... Give them what they need.</p>
						</div>

					</div>
				</div>

				<div class="shadow-hr"></div>


				<h3 class="small-header">Gaps to be closed</h3>
				<div aria-hidden="true" class="report-spacer-20"></div>
				<div class="lf-grid">
					<div class="restrictive-column">
						<ul>
							<li><strong>Who owns the intellectual property that
									was
									created?</strong> An important part of the
								cloud
								native ecosystem is contributing to projects.
								Often, the
								fastest path is to pay somebody to do that. The
								code
								needs to be maintained, and bugs must be fixed.
								This
								becomes a problem if that upstream code is not
								picked up
								by the commercial offerings of vendors.</li>
							<li><strong>What about non-cloud native
									workloads?</strong>
								Although container and container orchestration
								have
								solved many problems, they have not yet
								addressed the
								entire picture. One example is real-time systems
								that
								are embedded in firmware. </li>
						</ul>
						<div aria-hidden="true" class="report-spacer-20"></div>
						<div class="quote-container">
							<p
								class="quote-container__quote">Not everything is a suitable [container] candidate.</p>
						</div>
					</div>
				</div>

			</div>
		</section>

		<div
			class="section-06 alignfull background-image-wrapper section-break">
			<figure class="background-image-figure">
				<?php LF_Utils::display_responsive_images( 77930, 'full', '1440px', false, 'lazy', 'Attendees at KubeCon+CloudNativeCon Europe 2022' ); ?>
			</figure>
		</div>

		<section class="section-07">

			<div class="lf-grid">
				<div class="restrictive-column">

					<h2 class="sub-header"><span class="orange-text">2.</span> Multi-Cloud Availability</h2>

					<div aria-hidden="true" class="report-spacer-60"></div>

					<p>The introductory statement was as follows:</p>

					<p
						class="paragraph-quote larger">Many services like domain name systems (DNSs), content distribution networks (CDNs), and artifact storage can be instantiated in public or private clouds. <br><br>This session covered which services are requirements for achieving a resilient Multi-Cloud platform that enables regular iteration and improvement.</p>

				</div>
			</div>

			<div class="shadow-hr"></div>

			<h2 class="sub-header">Best Practices</h2>

			<div aria-hidden="true" class="report-spacer-60"></div>

			<div class="lf-grid">
				<div class="restrictive-column">

					<h3 class="small-header">Technologies</h3>
					<div aria-hidden="true" class="report-spacer-20"></div>
					<ul>
						<li>Consider architecture and design as key. Multi-Cloud
							comes with new challenges and tasks. An example is
							the cross-CSP transfer of information, such as DNS.
							The dependency graphs are becoming very complicated
							to read and manage. The foundation of a solution
							starts at the drawing board. Although seasoned
							experience with a single CSP is handy, it is not
							sufficient. In-depth knowledge of each involved
							cloud is mandatory. </li>
					</ul>
					<div aria-hidden="true" class="report-spacer-20"></div>
					<div class="quote-container">
						<p
							class="quote-container__quote">Kubernetes is part of the solution.</p>
					</div>

					<div aria-hidden="true" style="height:40px"></div>

					<ul>
						<li>Recognize that data is both easy and complicated.
							Using Multi-Cloud to duplicate your data on
							different clouds is a positive and so-called easy
							win. The current pricing model supports that.
							However, you should carefully review the ingress and
							egress costs for your use case. The data location
							policy is more complicated. Due to a missing
							cross-CSP abstraction layer, data may end up in the
							wrong place if the specifics of a contributing cloud
							are not fully understood. </li>
						<li>Manage vendor lock-in to your advantage. To minimize
							egress costs, consider grouping the same types of
							business into different clouds. For example, direct
							all mobile connectivity into one cloud and all
							webpage and front end into another cloud. With
							little interaction between the two, the lock-in
							becomes less of an issue, and you can achieve the
							benefits of leveraging the price advantages.</li>
					</ul>

					<div aria-hidden="true" class="report-spacer-20"></div>

					<div class="quote-container">
						<p
							class="quote-container__quote">Data policies are important.</p>
					</div>

				</div>
			</div>

			<div class="shadow-hr"></div>

			<div class="lf-grid">
				<div class="restrictive-column">

					<h3 class="small-header">People and Processes</h3>
					<div aria-hidden="true" class="report-spacer-20"></div>
					<ul>
						<li><strong>Governance is crucial</strong>. Which
							permissions and access do you grant to whom? How do
							you make sure that the right locations are selected?
							What about data policy? How do you effectively deal
							with the different life cycles? The importance of
							governance with Multi-Cloud is much higher. Much
							more forethought is required to cover the different
							CSPs and their specifics.</li>
						<li><strong>Take a new approach to scale your
								teams</strong>. Above all, any new system has to
							reflect your organization. Hence, you must deal with
							specialized teams in a single CSP while covering
							multiple clouds.</li>
					</ul>

					<div aria-hidden="true" class="report-spacer-20"></div>

					<div class="quote-container">
						<p
							class="quote-container__quote">Understand the new rules.</p>
					</div>

				</div>
			</div>

			<div class="shadow-hr"></div>

			<h3 class="small-header">Gaps to be closed</h3>

			<div aria-hidden="true" class="report-spacer-20"></div>

			<div class="lf-grid">
				<div class="restrictive-column">

					<ul>
						<li><strong>Review your availability zone (AZ) setup and
								ask your CSP for details</strong>. One
							participant reported an outage due to a CSP design
							issue of the AZ regarding a particular network
							service, which was not replicated or distributed as
							expected. As a result, the failure of a single AZ
							resulted in an outage of the applications on the
							other zones. The information about missing
							replication
							or distribution was at the CSP side and not known by
							the organization of the participant reporting the
							issue.</li>
					</ul>
					<div aria-hidden="true" class="report-spacer-20"></div>

					<div class="quote-container">
						<p
							class="quote-container__quote">AZs are not really AZs.</p>
					</div>

					<div aria-hidden="true" style="height:40px"></div>

					<ul>
						<li><strong>Think beyond CSP</strong>. Core
							architectural cloud services do not currently have a
							Multi-Cloud implementation. Services like CDNs and
							DNS can be difficult to federate in a Multi-Cloud
							context. If they fail, which has happened recently,
							the business in the Cloud is impacted. Right now,
							there is no obvious solution to mitigate that.</li>
						<li><strong>New requirements</strong>. Different
							participants indicated that they became aware of
							potential new requirements or changes to existing
							ones. One said that regulatory authorities might
							mandate Multi-Cloud soon, which may also come with
							unique requirements about running/using Multi-Cloud.
							Another noted that using multiple regions could
							supersede the need for Multi-Cloud. </li>
					</ul>

					<div aria-hidden="true" class="report-spacer-20"></div>

					<div class="quote-container">
						<p
							class="quote-container__quote">New things will come.</p>
					</div>

				</div>
			</div>

		</section>

		<div
			class="section-08 alignfull background-image-wrapper section-break">
			<figure class="background-image-figure">
				<?php LF_Utils::display_responsive_images( 77931, 'full', '1440px', false, 'lazy', 'Conference attendee catching up on some work' ); ?>
			</figure>
		</div>

		<section class="section-09 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">The Collaboration <br />
						Work Continues</h2>
					<div class="section-number">4/6</div>
				</div>

				<div class="lf-grid">
					<div class="restrictive-column">
						<p>As the Summit participants noted, Multi-Cloud resiliency is only attainable with changes to the legacy processes, technologies, mindsets, and skillsets. Although it will be a long journey to true resiliency, early results show that the effort will be worth it in terms of an enhanced time to market, faster development cycles, and enhanced capabilities.</p>

						<p><strong>Multi-Cloud and its different aspects are still mostly undiscovered territory</strong>. Over time, we will be able to go deeper in our multi-cloud resiliency skills as we develop our expertise in a collaborative, global environment. Participants left the CTO Summit inspired with fresh perspectives and ideas to bring back to their organizations.</p>

						<p>The open discussions and experience exchange, including the logistics around the event, were very much welcomed by the participants. The following requests for continued collaboration and idea exchange were raised:</p>

						<div aria-hidden="true" class="report-spacer-20"></div>

						<ul>
							<li>Continue the discussion after the event</li>
							<li>Have a framework to easily contact peers or
								knowledgeable persons on Multi-Cloud topics</li>
							<li>Repeat the CTO summit with a new topic <a
									href="https://events.linuxfoundation.org/kubecon-cloudnativecon-north-america/apply-cto-summit/"
									title="CTO Summit at KubeCon+CloudNativeCon North America 2022">
									at the
									next conference
								</a></li>
						</ul>

						<div aria-hidden="true" class="report-spacer-20"></div>

						<p>The Linux Foundation and the CNCF are built on the notion that the best ideas come from anywhere and that collaboration is key to achieving the best results. We look forward to continuing this work with others as we work toward Multi-Cloud resiliency to improve efficiency, performance, and innovation.</p>

					</div>
				</div>

			</div>
		</section>

		<section class="section-10 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">Appendices</h2>
					<div class="section-number">5/6</div>
				</div>

				<h2 class="sub-header"><span class="orange-text">Appendix A:</span> Summit Process</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-column">

						<p>The participants received a brief introduction to the Multi-Cloud topic in general and several core elements in particular. This introduction synchronized the expectations of the Summit and served to broaden the understanding of the subject. Additionally, the participants were allowed to vote on which particular aspects of Multi-Cloud to discuss in breakout sessions.</p>

						<p>Three working groups deconstructed two critical topics. After the opening remarks, introductions, and logistics, the participants split up into three designated working groups with dedicated rooms, each separate from the opening plenary discussion area. Given the diversity of the participants, the resulting groups served as a measured representation of the different aspects and viewpoints of Multi-Cloud challenges and experiences across cloud computing.</p>

						<p>Each working group explored two topics and evaluated three key areas. Following a vote by a show of hands, the following sub-topics were selected and discussed separately:</p>

						<ul>
							<li>How to best manage the cloud native ecosystem in
								any
								organization</li>
							<li>Multi-Cloud availability</li>
						</ul>

						<p>To facilitate the discussion, the groups followed a common framework to focus their discussion using the following three key areas: </p>

						<ul>
							<li>Expand on or define the problem statement of the
								selected sub-topic.</li>
							<li>Solution design
								<ul>
									<li>People</li>
									<li>Processes</li>
									<li>Technology</li>
								</ul>
							</li>
							<li>Priorities</li>
						</ul>

						<p>The working group facilitators sparked discussion, managed the flow of ideas and solution design, and recorded the breakout group's key findings. There was one dedicated session per topic for each working group. Afterward, each group reported back on their results to the Summit participants, and then an open discussion ensued.</p>

					</div>
				</div>

				<div class="shadow-hr"></div>

				<h2 class="sub-header"><span class="orange-text">Appendix B:</span> Sub-topics</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-column">

						<p><strong>Multi-Cloud management</strong><br/>Multi-Cloud is inevitable. It creeps in through best-of-breed services, company acquisitions, and just plain sprawl. In such a world, managing Kubernetes clusters, computing, and applications across multiple clouds require a unique set of tools and comprehensive workflows. Using strategies like GitOps and declarative infrastructure creates consistent environments, which are essential for operating systems at scale. This discussion aims to understand which kinds of workflow teams should implement to allow for massive infrastructure scaling without massively scaling team sizes or budgets.</p>

						<p><strong>Managing the cloud native ecosystem in your organization</strong><br/>Do you use a CNCF project by itself? There are unique challenges when running and configuring a project directly rather than through a managed service. The cloud native ecosystem has a vibrant community of particular interest, working, and technical action groups that create boundless updates across the ecosystem that can be difficult to keep up with. During this session, we will cover the practices that high-performance teams implement to stay up to date on project updates without wasting their time.</p>

						<p><strong>What tenets of Multi-Cloud are essential for business?</strong><br/>Although cloud native technologies can help to support workload, workflow, data, and traffic portability, which tenants of Multi-Cloud are the most beneficial? Do you care about workflows that allow a consistent experience building applications, computing, networks, and storage? Maybe you'd like to write an application consistently and have the platform be dynamically configurable to meet your needs. In this session, we will discover which approaches are most beneficial to teams that operate at a Multi-Cloud scale, including examples of success that have been shared by our program committee from Boeing, Fidelity, Intel, and Intuit.</p>

						<p><strong>Multi-Cloud availability</strong><br/>Many services, such as DNS, CDNs, and artifact storage, can be instantiated in public or private clouds. Despite many of these services being offered in major public clouds, relying on managed services does not always make sense when resiliency is the end goal. Which services make the most sense to run as managed services or federate between your various cloud offerings? This session will cover which services are requirements for achieving a resilient Multi-Cloud platform that promotes regular iteration and improvement.</p>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<h2 class="sub-header"><span class="orange-text">Appendix C:</span> Discussion Framework</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-column">

						<p>To encourage a standard structure and flow for the breakout discussions and guide participants to share intelligence on how existing tactics are implemented either currently or in the future, the participants were asked to address the following points as they relate to each subtopic. This would enable the different discussion groups to be compared.</p>

						<ol>
							<li>Expand on/define the sub-topic problem
								statement.</li>
							<li>Solution design&nbsp;<ol class="alpha">
									<li>How can the following elements be
										leveraged as
										they relate to overcoming challenges?
									</li>
									<li>People<ol class="roman">
											<li>Team/community leaders,
												community
												members, employees, and the
												qualities of
												each&nbsp;</li>
											<li>Hard/soft skills</li>
											<li>Budgeting for people</li>
										</ol>
									</li>
									<li>Processes<ol class="roman">
											<li>Operational considerations—what
												workflows and aspects of
												workflows need
												to be implemented to overcome
												the
												current challenges?</li>
											<li>What is the budgeting for
												workflows?
											</li>
										</ol>
									</li>
									<li>Technology/Tooling<ol class="roman">
											<li>Which tech
												stacks/hardware/standards can
												be leveraged/implemented?&nbsp;
											</li>
											<li>Other tools?&nbsp;</li>
											<li>Financial/budget considerations?
											</li>
										</ol>
									</li>
								</ol>
							</li>
							<li>Priorities<ol class="alpha">
									<li>Where should teams focus their efforts?
										Choose
										three opportunities that should be
										implemented
										first.</li>
								</ol>
							</li>
						</ol>

					</div>
				</div>

				<div class="shadow-hr"></div>

				<h2 class="sub-header"><span class="orange-text">Appendix D:</span> Glossary</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-column">
						<ul>
							<li><strong>AWS</strong> - Amazon Web Services</li>
							<li><strong>AZ</strong> - Availability Zone</li>
							<li><strong>CDN</strong> - Content Delivery Network
							</li>
							<li><strong>CNCF</strong> - Cloud Native Computing
								Foundation</li>
							<li><strong>CSP</strong> - Cloud Service Provider
							</li>
							<li><strong>CTO</strong> - Chief Technology Officer
							</li>
							<li><strong>DNS</strong> - Domain Name System</li>
							<li><strong>GDPR</strong> - General Data Protection
								Regulation</li>
							<li><strong>SIG</strong> - Special Interest Group
							</li>
							<li><strong>UG</strong> - User Group</li>
						</ul>
					</div>
				</div>


				<div aria-hidden="true" class="report-spacer-120"></div>

				<!-- Photo Slider  -->
				<div
					class="wp-block-group is-style-no-padding is-style-see-all">
					<div
						class="wp-block-columns are-vertically-aligned-centered">
						<div class="wp-block-column is-vertically-aligned-centered"
							style="flex-basis:80%">
							<h2 class="sub-header">Valencia Photo Highlights
							</h2>
						</div>
						<div class="wp-block-column is-vertically-aligned-bottom"
							style="flex-basis:20%">
							<p
								class="has-text-align-right is-style-link-cta"><a href="https://www.flickr.com/photos/143247548@N03/albums/72177720298987342" title="KubeCon+CloudNativeCon Europe 2022 Photo Gallery">See more</a></p>
						</div>
					</div>


					<div class="section-10__slider">

						<div>
							<?php LF_Utils::display_responsive_images( 73940, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2022' ); ?>
						</div>
						<div>
							<?php LF_Utils::display_responsive_images( 73945, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2022' ); ?>
						</div>
						<div>
							<?php LF_Utils::display_responsive_images( 73936, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2022' ); ?>
						</div>
						<div>
							<?php LF_Utils::display_responsive_images( 73937, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2022' ); ?>
						</div>
						<div>
							<?php LF_Utils::display_responsive_images( 73938, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2022' ); ?>
						</div>
						<div>
							<?php LF_Utils::display_responsive_images( 73939, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2022' ); ?>
						</div>
						<div>
							<?php LF_Utils::display_responsive_images( 73946, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2022' ); ?>
						</div>
						<div>
							<?php LF_Utils::display_responsive_images( 73944, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2022' ); ?>
						</div>
						<div>
							<?php LF_Utils::display_responsive_images( 73943, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2022' ); ?>
						</div>
						<div>
							<?php LF_Utils::display_responsive_images( 73942, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2022' ); ?>
						</div>
						<div>
							<?php LF_Utils::display_responsive_images( 73941, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2022' ); ?>
						</div>

					</div>

					<div class="section-10__controls">
						<button class="button-reset  section-10__prev"><svg
								width="12" height="19" viewBox="0 0 12 19"
								fill="none" xmlns="http://www.w3.org/2000/svg">
								<path
									d="M10.4131 17.627L2.41309 9.62695L10.4131 1.62695"
									stroke="black" stroke-width="3" />
								</svg>
								<span class="screen-reader-text">Previous
									Photo</span>
						</button>
						<button class="button-reset section-10__next">
							<svg
								width="12" height="19" viewBox="0 0 12 19"
								fill="none" xmlns="http://www.w3.org/2000/svg">
								<path
									d="M1.41309 1.62695L9.41309 9.62695L1.41309 17.627"
									stroke="black" stroke-width="3" />
								</svg>
								<span class="screen-reader-text">Next
									Photo</span>
						</button>
					</div>
				</div>
			</div>
		</section>

		<section class="section-11 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header long-word">Acknowledgements</h2>
					<div class="section-number">6/6</div>
				</div>

				<div class="lf-grid">
					<div class="restrictive-column">
						<p>Thanks to the CNCF for creating an opportunity for leading end-user experts to convene at KubeCon+CloudNativeCon Europe to collectively discuss the struggles, opportunities, and new architectures for crafting a resilient Multi-Cloud strategy. </p>

						<p>Many thanks to the content committee members Pratik Wadher from Intuit, Ricardo Torres from Boeing, and Amr Abdelhalem from Fidelity, who steered the development of the discussion topics for this and future summits. Additional thanks go to Arun Gupta from Intel, who as the governing board chair, was involved in the preparation and execution of the event. Thanks also go to the facilitators Pratik Wadher and Henrik Blixt from Intuit and Ricardo Torres from Boeing, who managed to inspire a discussion on trending cloud native topics while giving participants plenty of room to explore the issues. In addition, this distinguished group of people was instrumental in reviewing this report and raising it to the needed and desired quality.</p>

						<p>Special thanks to <a href="https://orca.security" title="Visit Orca Security">Orca Security</a> and <a href="https://www.tigera.io" title="Visit Tigera">Tigera</a> for generously sponsoring the reception and dinner that followed the May 18 Summit. </p>

						<p>Thanks to the Linux Foundation and CNCF team members Taylor Dolezal, Paige O'Connor, and Kristi Tan for their contributions to the summit and to the events team, who took care of the logistics before, during, and after the event, in particular Vanessa Heric and Wendi West. Thanks also go to Hilary Carter, Linux Foundation Vice President of Research, for her work as the internal and external facilitator—not only related to the event but also for the management and production of this report.</p>

						<p>Finally, thanks go to Priyanka Sharma (executive director of the CNCF) and the more than 20 participants of the CTO summit. Where Priyanka's leadership and vision had set the tone and the spirit for the event, the participant's discussions and insights helped craft a rich foundation for this report. </p>

						<div class="author">
							<img src="<?php LF_utils::get_image( $report_folder . 'dr-udo-seidel.jpg' ); ?>" alt="Dr. Udo Seidel" width="200" height="200" loading="lazy" class="author__image">
							<p><strong>Dr. Udo Seidel </strong><br/>Report author</p>
						</div>


					</div>
				</div>

				<div class="shadow-hr"></div>

				<div class="lf-grid">
					<div class="restrictive-column">

						<h2 class="sub-header">About the Author</h2>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<p>Dr. Udo Seidel would have been a teacher for mathematics and physics if he had not been infected by the open source virus in 1996. After his PhD he worked as Linux/Unix instructor, system administrator, senior solution engineer, architect, digital evangelist, and account CTO. He regularly speaks at conferences and publishes articles in computer magazines.</p>

					</div>
				</div>

				<div class="shadow-hr"></div>

				<p
					class="disclaimer"><span class="uppercase"><strong>Disclaimer</strong></span><br/>This report is provided "as is". The Linux Foundation and its authors, contributors, and sponsors expressly disclaim any warranties (express, implied, or otherwise), including implied warranties of merchantability, noninfringement, fitness for a particular purpose, or title, related to this report. In no event will the Linux Foundation and its authors, contributors, and sponsors be liable to any other party for lost profits or any form of indirect, special, incidental, or consequential damages of any character from any causes of action of any kind with respect to this report, whether based on breach of contract, tort (including negligence), or otherwise, and whether they have been advised of the possibility of such damage. Sponsorship of the creation of this report does not constitute an endorsement of its findings by any of its sponsors.</p>
			</div>
		</section>

		<section class="section-12 is-style-down-gradient alignfull">

			<div class="container wrap">

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

				<div aria-hidden="true" class="report-spacer-120"></div>

				<h2 class="section-header">Thank You</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-column">
						<p>If you have any questions or comments about this report,<br class="show-over-1000">you can get in touch with us at <a href="mailto:cto-summit@cncf.io" title="Send an email to cto-summit@cncf.io">cto-summit@cncf.io</a></p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid authors">
					<div class="authors__col1">
						<a href="https://www.cncf.io"
							title="Cloud Native Computing Foundation"><img
								src="<?php LF_utils::get_svg( $report_folder . 'cncf-logo.svg', true ); ?>"
								alt="CNCF" width="280" height="54"
								loading="lazy"></a>
						<div aria-hidden="true" class="report-spacer-40"></div>
						<p>The <a href="https://www.cncf.io" title="Cloud Native Computing Foundation">Cloud Native Computing Foundation</a> (CNCF) hosts critical components of the global technology infrastructure. It brings together the world's top developers, end users, and vendors and run the largest open source developer conferences. CNCF is the open source, vendor-neutral hub of cloud native computing, hosting projects like Kubernetes and Prometheus to make cloud native universal and sustainable. The CNCF is part of the <a href="https://linuxfoundation.org/" title="The Linux Foundation">Linux Foundation</a>.</p>
					</div>
					<div class="authors__col2">
						<a href="https://www.linuxfoundation.org/research/"
							title="Linux Foundation Research"><img
								src="<?php LF_utils::get_image( $report_folder . 'logo-lf-research.png' ); ?>"
								alt="The Linux Foundation Research" width="269"
								height="48" loading="lazy"></a>
						<div aria-hidden="true" class="report-spacer-40"></div>
						<p>Founded in 2021, <a href="https://www.linuxfoundation.org/research/" title="Linux Foundation Research">Linux Foundation Research</a> explores the growing scale of open source collaboration, providing insight into emerging technology trends, best practices, and the global impact of open source projects. Through leveraging project databases and networks, and a commitment to best practices in quantitative and qualitative methodologies, Linux Foundation Research is creating the go-to library for open source insights for the benefit of organizations the world over.</p>
					</div>

				</div>

				<div class="shadow-hr"></div>

				<div class="lf-grid copyright">
					<div class="copyright__col1">
						<p>To reference this work, please cite: Udo Seidel, "CTO Summit Report EU 2022: Achieving Resiliency in Multi-Cloud" foreword by Amr Abdelhalem, Arun Gupta, Ricardo Torres, Pratik Wadher, The Linux Foundation, August 2022.</p>

						<p>August 2022. Copyright 2022 <a href="https://linuxfoundation.org/" title="The Linux Foundation">The Linux Foundation</a>.</p>
					</div>

					<div class="copyright__col2">

						<a href="https://creativecommons.org/licenses/by-nd/2.0/"
							title="Creative Commons">
							<img src="<?php LF_utils::get_image( $report_folder . 'copyright.png' ); ?>"
								alt="Attribution-NoDerivs 2.0 Generic (CC BY-ND 2.0)"
								loading="lazy" width="190" height="69">
						</a>
					</div>
				</div>

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
wp_enqueue_script( 'cto-summit-eu-22-report', get_template_directory_uri() . '/source/js/on-demand/cto-summit-eu-22-report.js', array( 'jquery', 'slick' ), filemtime( get_template_directory() . '/source/js/on-demand/cto-summit-eu-22-report.js' ), true );

get_template_part( 'components/footer' );
