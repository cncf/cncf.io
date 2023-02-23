<?php
/**
 * Template Name: CTO Summit NA 22
 * Template Post Type: lf_report
 *
 * File for the CTO Summit NA 22 Report
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

wp_enqueue_style( 'wp-block-column' );
wp_enqueue_style( 'wp-block-columns' );
wp_enqueue_style( 'wp-block-group' );

// Make use of the PDF report link in the editor.
// This way do not need to make a new commit just to update PDF link.
$pdf_url = get_post_meta( get_the_ID(), 'lf_report_pdf_url', true );

// Report folder in images/ folder.
$report_folder = 'reports/cto-summit-na-22/';

get_template_part( 'components/header' );
?>

<link rel="prefetch"
	href="<?php echo esc_url( get_template_directory_uri() . '/build/cto-summit-na-22.min.css' ); ?>"
	as="style" crossorigin="anonymous" />

<?php

wp_enqueue_style( 'cto-summit-na-22', get_template_directory_uri() . '/build/cto-summit-na-22.min.css', array(), filemtime( get_template_directory() . '/build/cto-summit-na-22.min.css' ), 'all' );

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

<main class="cto-summit-na-22">
	<article class="container wrap">

		<section class="hero alignfull background-image-wrapper">
			<figure class="background-image-figure darken-on-mobile">
				<?php LF_Utils::display_responsive_images( 84201, 'full', '1440px', false, 'eager', '' ); ?>
			</figure>
			<div class="background-image-text-overlay">
				<div class="container wrap hero__container">

					<div class="hero__wrapper">
						<img class="hero__logo"
							src="<?php LF_Utils::get_svg( $report_folder . 'kubecon-na-2022.svg', true ); ?>"
							width="309" height="119"
							alt="KubeCon + CloudNativeCon North America 2022 Logo"
							loading="eager">

						<h1 class="hero__title">CTO SUMMIT</h1>

						<h2 class="hero__subtitle">Exploring The <br />Foundations Of <br />Cloud Native Maturity</h2>

						<div class="hero__hr"></div>

						<div class="hero__button-share-align">

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
				</div>
			</div>
		</section>

		<section class="section-01">

			<div class="lf-grid section-01__grid">
				<div class="section-01__grid-col">
					<h2 class="section-01__title uppercase">Foreword
					</h2>
					<p class="section-01__lead">Based around in-depth conversations from technology leaders at the 2022 CTO Summit at KubeCon + Cloud Native Con 2022, this report details the findings, recommendations, and solutions for end user organizations eager to inform strategies for adopting and accelerating the use of cloud native technology.</p>
				</div>
			</div>

			<div class="lf-grid section-01__grid">
				<div class="section-01__grid-col1">
					<p>This report is made possible because the cloud native community has always prioritized learning and sharing. Every day, countless individual contributors volunteer their time and knowledge to teach others despite the projects they contribute to, their organizations, their personal and professional education, or the challenges they face in their daily lives. Under the Cloud Native Computing Foundation (CNCF), the community diligently maintains these traditions to make cloud native computing a sustainable solution for more real-world problems.</p>

					<p>The need for collective learning begins as end user organizations approach adopting cloud native technology, a process that starts with the <a href="https://landscape.cncf.io/guide#provisioning">provisioning</a> layer of the <a href="https://landscape.cncf.io/card-mode?category=provisioning&grouping=category">Cloud Native Landscape</a>. Provisioning tools are those used to automatically configure, create, and manage cloud native infrastructure, providing the foundation on which all their applications are built. The first tools an organization chooses initially have an impact for years to come.</p>

					<p>As organizations continue to adopt and integrate cloud native technologies and practices into their applications and infrastructure, they often seek frameworks to gauge the maturity of various cloud native patterns and architectures to inform their strategies for adopting new tools, paradigms, and architectures. The availability of community support and resources is a crucial factor in these decision-making processes.</p>

					<p><strong>Cloud native maturity</strong> is defined as the level-by-level progression of an organization as it moves from initial adoption to full integration of cloud native technology in its applications and infrastructure. With goals, minimum standards, and KPIs for each level, cloud native maturity is more than a technical assessment. Culture dramatically impacts how an organization builds and deploys software, and business goals and customer demands must drive all technology decisions. An organization’s maturity quantifies where technology, culture, and business intersect. The larger it is, the more likely it is that different units operate at varying levels of cloud native maturity.</p>

					<p>Building off the successful first CTO Summit at KubeCon + CloudNativeCon Europe, this iteration featured a diverse cast of 21 participants to encourage more discussion around how the cloud native community can expand the application of maturity-driven thinking. Participants are leading information technologists in their organizations, with the responsibility to scope new opportunities and lead multiple teams toward a common goal.</p>

					<div class="paragraph-quote">
						<p><strong>How can an organization better apply this model to its respective cloud native journey, and how can it continue to refine the stages and markers of success based on real-world usage?</strong></p>
					</div>

					<p><strong>We looked for the following criteria in the Summit’s participants:</strong></p>

					<ul>
						<li>Ownership of technical decision-making, budget, and platform/application KPIs</li>
						<li>Awareness of the cloud native landscape, but with a diversity of practical experience, to best explore the practical applications of theCloud Native Maturity Model</li>
						<li>Experience in implementing cloud native provisioning tools from amanagerial perspective</li>
					</ul>

					<p>Industries represented at the Summit included financial services, aerospace, automotive, e-commerce, media services, retail, lifestyle, manufacturing, and more.</p>

					<p>But, perhaps most importantly, all the Summit’s participants are part of CNCF’s <a href="/enduser/">end user community</a> in that they are organizations that use cloud native technologies internally and don’t sell any cloud native services externally. The End User community excludes vendors, consultancies, training partners, and telecommunications companies. To make cloud native ubiquitous, learning from those using these tools is essential to drive business value across industries.</p>

					<p>In this report, we’ll cover the broad strokes from this year’s CTO Summit and showcase opportunities where members of this community can continue to learn from one another.</p>

				</div>

				<div class="section-01__grid-col2">
					<div class="section-01__grid-col2-inner">
						<h2 class="sub-header">CTO Summit commitee</h2>

						<div class="section-01__grid-col2-commitee-wrapper">
							<div class="commitee">
								<img class="commitee__image" loading="lazy"
									src="<?php LF_utils::get_image( $report_folder . 'Amr-Abdelhalem.jpg' ); ?>"
									alt="Amr Abdelhalem" width="80"
									height="80">
								<div class="commitee__text">
									<p><strong>Amr Abdelhalem</strong></p>
									<a href="https://www.fidelity.com/"
										title="Visit Fidelity Investments">
										<img class="commitee__logo"
											loading="lazy"
											src="<?php LF_utils::get_svg( $report_folder . 'logo-fidelity-investments.png', true ); ?>"
											alt="Fidelity Investments Logo"
											width="137" height="30">
									</a>
								</div>
							</div>
							<div class="commitee">
								<img class="commitee__image" loading="lazy"
									src="<?php LF_utils::get_image( $report_folder . 'Arun-Gupta.jpg' ); ?>"
									alt="Arun Gupta" width="80" height="80">
								<div class="commitee__text">
									<p><strong>Arun Gupta</strong></p>
									<a href="https://www.intel.com/content/www/us/en/homepage.html"
										title="Visit Intel">
										<img class="commitee__logo"
											loading="lazy"
											src="<?php LF_utils::get_svg( $report_folder . 'logo-intel.png', true ); ?>"
											alt="Intel Logo" width="87"
											height="34">
									</a>
								</div>
							</div>
							<div class="commitee">
								<img class="commitee__image" loading="lazy"
									src="<?php LF_utils::get_image( $report_folder . 'Ricardo-Torres.jpg' ); ?>"
									alt="Ricardo Torres" width="80"
									height="80">
								<div class="commitee__text">
									<p><strong>Ricardo Torres</strong></p>
									<a href="https://www.boeing.com/"
										title="Visit Boeing">
										<img class="commitee__logo"
											loading="lazy"
											src="<?php LF_utils::get_svg( $report_folder . 'logo-boeing.svg', true ); ?>"
											alt="Boeing Logo" width="149"
											height="35"></a>
								</div>
							</div>
							<div class="commitee">
								<img class="commitee__image" loading="lazy"
									src="<?php LF_utils::get_image( $report_folder . 'Pratik-Wadher.jpg' ); ?>"
									alt="Pratik Wadher" width="80"
									height="80">
								<div class="commitee__text">
									<p><strong>Pratik Wadher</strong></p>
									<a href="https://www.intuit.com/"
										title="Visit Intuit">
										<img class="commitee__logo"
											loading="lazy"
											src="<?php LF_utils::get_svg( $report_folder . 'logo-intuit.svg', true ); ?>"
											alt="Intuit Logo" width="120"
											height="35">
									</a>
								</div>
							</div>
							<div class="commitee">
								<img class="commitee__image" loading="lazy"
									src="<?php LF_utils::get_image( $report_folder . 'Henrik-Blixt.jpg' ); ?>"
									alt="Henrik Blixt" width="80"
									height="80">
								<div class="commitee__text">
									<p><strong>Henrik Blixt</strong></p>
									<a href="https://www.intuit.com/"
										title="Visit Intuit">
										<img class="commitee__logo"
											loading="lazy"
											src="<?php LF_utils::get_svg( $report_folder . 'logo-intuit.svg', true ); ?>"
											alt="Intuit Logo" width="120"
											height="35">
									</a>
								</div>
							</div>
							<div class="commitee">
								<img class="commitee__image" loading="lazy"
									src="<?php LF_utils::get_image( $report_folder . 'Hilary-Carter.jpg' ); ?>"
									alt="Hilary Carter" width="80"
									height="80">
								<div class="commitee__text">
									<p><strong>Hilary Carter</strong></p>
									<a href="https://www.linuxfoundation.org/research/"
										title="Visit Linux Foundation Research">
										<img class="commitee__logo"
											loading="lazy"
											src="<?php LF_utils::get_image( $report_folder . 'logo-lf-research.png' ); ?>"
											alt="Linux Foundation Logo" width="180"
											height="32">
									</a>
								</div>
							</div>
							<div class="commitee">
								<img class="commitee__image" loading="lazy"
									src="<?php LF_utils::get_image( $report_folder . 'Priyanka-Sharma.jpg' ); ?>"
									alt="Priyanka Sharma" width="80"
									height="80">
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
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="section-02 is-style-down-gradient alignfull text-blue">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">Executive <br />
						Summary</h2>
					<div class="section-number">1/6</div>
				</div>

				<div class="lf-grid">
					<div class="restrictive-9-col">

						<p>The cloud native ecosystem, from projects to events to memberships and the community at large, continued its growth momentum throughout 2022, with 157 projects, over 178,000 contributors, and a total community of <a href="#">7.1 million cloud native developers.</a></p>

						<p>CNCF’s data, pulled from GitHub repositories and regular surveys, is correlated by research by <a href="#">Gartner</a>, which predicts that cloud native technologies will be “pervasive, not just popular,” with 95% of new digital workloads deployed on cloud native platforms by 2025. In addition, Gartner envisions most organizations shifting to a product-oriented operating model, where the “entire value stream of the business and IT will have to be aligned by products,” meaning there will be more intense emphasis on communicating the business value of cloud native technology.</p>

						<p>Even the <a href="/enduser/">end user community</a>, the doers who push the leading edge of cloud native, grew 17% in the last year, with representatives from Fidelity, Apple, Boeing, Intuit, Spotify, and more than a hundred more. Even better: 100% of them would recommend CNCF, and cloud native technologies to their technologist peers in other verticals. That’s a decisive vote of confidence for the entire cloud native landscape. But perhaps even more importantly, it’s an opportunity for huge-scale adoption, which drives feedback about the efficacy and business value of cloud native technology in real-world scenarios.</p>

						<p>Right now is a critical moment for productive discussions around not just technology decisions at the provisioning layer of the cloud native landscape but also how organizations should effectively solve real business challenges through a holistic approach that includes people, process, and policy.</p>

						<p>The Summit’s participants agreed that every question they had about cloud native likely already had a technical solution in the landscape. Instead, they were concerned whether any solutions were optimized for their current level of cloud native maturity. A compounding worry is that organizations are not monoliths, and participants oversee thousands of developers, hundreds of teams, tens of thousands of deployments, all of which might operate under different tools, skill sets, and cultures. Mapping a single technical solution to a single level of maturity is no easy task.</p>

						<p>To create alignment on the levels of cloud native maturity, the CNCF worked with internal collaborators and industry representatives on the <strong>Cloud Native Maturity Model</strong> <a href="#appendix-b">(see Appendix B for details)</a>. Thanks to the <a href="https://github.com/cncf/cartografos">Cartografos Working Group</a>, with contributing members from Fairwinds, Stackegy, and Accenture, the cloud native community has a framework, in five dimensions and five levels of maturity, for identifying goals and unlocking the business benefits of running scalable applications in modern environments.</p>

						<p><strong>The Model maps to several organizational archetypes:</strong></p>

						<ul>
							<li>Businesses starting down the path of digital transformation</li>
							<li>Organizations wanting to adopt projects of the CNCF landscape with a trusted framework</li>
							<li>Open source and CNCF projects and practitioners wishing to use or contribute to the Model</li>
							<li>Executive leadership looking to understand the benefits of cloud native, scope of effort, and level of investment</li>
							<li>Technologists wishing to implement cloud native technology but need to understand the journey better ahead from a technology and business perspective</li>
						</ul>

						<p>Continuing to discuss and promote the Cloud Native Maturity Model, and further investigate ways to integrate its standards and KPI goals into the culture of end user organizations, is paramount to how end user organizations formalize and optimize their cloud native strategies.</p>

						<p>Participants also agreed that culture remains a difficult roadblock for successfully adopting cloud native technology, particularly at the provisioning layer, which is always the step in adoption and migration. Multiple participants noted that as newer members of their organization, they face additional headwinds in rolling out cloud native technologies. They would prefer to create a “paved road” experience for their developers, a standardized toolkit that solves configuration, security, and compliance concerns for them. But they must tread carefully and find a delicate balance between providing repeatable patterns and not creating an unsustainable workload at consolidating development, operations, DevOps, and security.</p>

						<p>Part of this resistance is, as many Summit participants pointed out, an unfamiliarity with translating the value of cloud native technology to their peers in business units. This was true regardless of their background, experience, or industry vertical. But rather than this being a challenge for Summit participants and other end user leadership to solve on their own, it’s a signal that the Cloud Native Maturity Model is shaping up to be a viable framework for creating a common language between technology and business units.</p>

						<p><strong>We’re enormously grateful to the Summit’s participants for the spirit of transparency and learning from one another toward a common goal of improving the ways they, as end users, leverage cloud native tools and projects to solve real-world business problems.</strong></p>

					</div>
				</div>
			</div>
		</section>

		<div
			class="section-03 alignfull background-image-wrapper section-break">
			<figure class="background-image-figure">
				<?php LF_Utils::display_responsive_images( 84199, 'full', '1440px', false, 'lazy', 'Conference attendees relaxing' ); ?>
			</figure>
		</div>

		<section class="section-04 alignfull text-blue">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">Key <br />
						Findings</h2>
					<div class="section-number">2/6</div>

				</div>
				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>While CTO Summit participants presented many challenges and solutions to help their peers on each cloud native journey, they aligned on a specific calls to action based on internal success stories:</p>
					</div>

					<div class="restrictive-9-col">

						<h2 class="sub-header">Drive informed organizational strategies by understanding an organization’s place in the Cloud Native Maturity Model</h2>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<p>Many end user organizations have codified methods of tracking their cloud native migration and adoption, a dynamic first step. But when people create a system in a vacuum, they miss out on essential lessons from the cloud native community based on real world results.</p>

						<p>For example, based on comments from the Summit's participants, maturity levels can vary application by application, team by team, database by database, cloud provider by cloud provider. Being at a single level of maturity across an organization is rare or even impossible.</p>

						<p>The people behind the Cloud Native Maturity Model have worked with many end user organizations to define the states and KPIs for each combination of Level and dimension. Instead of reinventing the wheel, organizations looking to define their strategies can immediately benefit from standards and goals validated by other end user leadership.</p>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">

						<h2 class="sub-header text-blue">Explore the Cloud Native Landscape to make tool and architecture choices</h2>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<p>Technology leaders struggle over whether to dictate a “paved road” of approved cloud native tools or let teams self-organize around technology that works best for a particular use case. Tool choice remains a difficult balance between flexibility and efficiency and typically is only possible after a latent period, without innovation, where teams standardize, refactor, and “cut the fat” to make way for cloud native technology.</p>

						<p>Many participants coalesced around taking a supportive, rather than dictatorship, approach by making the paved road more appealing than custom frameworks. For example, in a major CVE, an organization can fix deployments based on standard tooling with a single bot for creating PRs with an approved fix versus engineers spending time diagnosing, testing, and deploying a patch for their custom toolkit. When platform engineering teams can design and standardize a rich and effective environment, developers suddenly don’t have a reason not to use the paved road.</p>

						<p>Ideally, the paved road integrates many valuable tools into as simple an output as possible—a red or green light—to prevent building an unsustainable ecosystem inside an organization. Developing that green light solution is a multi-year challenge, and all these decisions get far more complex when an organization goes multi-region. Still, leaders should continue turning to the Cloud Native Landscape for insights on new technologies that can simplify tool choice for everyone.</p>

						<div aria-hidden="true" class="report-spacer-50"></div>

						<div class="quote-container">
							<p
								class="quote-container__quote">“Organizations need to be wary of packaging too much complexity into their toolkits, or else they’ll overwhelm developers with having to also work as operators, platform engineers, security experts, and more.</p>
						</div>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">

						<h2 class="sub-header text-blue">Amplify maturity through organizational <br /> culture aligned to cloud native values</h2>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<p>Cloud native adoption is as much a people and process equation as a technology one. An organization can shift left security and implement every technological solution, from multi-tenant models and policy checks. However, it still needs cultural collaboration to keep teams aware of troubling trends and best practices.</p>

						<p>But changing an established software development culture takes far more work than convincing the CIO/CTO to dictate how things should work and get teams in line. This is even more true for those traditionally underrepresented in technology spaces. An entire organization, including business units, must buy-in to the positive impacts of a technological shift on responsibility and collaboration.</p>

						<p>Organizations will face challenges like an “old guard,” which is alive and well. According to CTO Summit participants, these folks do not resist technological change at face value, but rather shifts that affect their day-to-day operations. Even the best-intentioned practices, like modern DevSecOps, can hinder cloud native maturity, too. Suddenly, a frontend developer is responsible for the frontend, the backend, the entire product lifecycle, configuration and deployment of the infrastructure, and ensuring it’s secure and encrypted throughout its entire lifecycle.</p>

						<p>To work best with cloud native technology, developers need to transition from a mindset of “DevOps will take care of this deployment for me” to “I have to develop and run this myself.” It’s a big step, which means organizations need to support developers with guideposts and best practices that let them experiment with the confidence they won’t spark an all-hands-on-deck incident.</p>

						<div aria-hidden="true" class="report-spacer-50"></div>

						<div class="quote-container">
							<p
								class="quote-container__quote">“At each level of an organization’s maturity, they should communicate the value of this whole movement.</p>
						</div>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">

						<h2 class="sub-header text-blue">Incorporate and communicate business value into cloud native adoption</h2>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<p>For many business leaders, the migration and continuing adoption of cloud native technology are not as clear-cut as “lifting and shifting” workloads from on-premises to hybrid/public clouds. They are unlikely to sign off on major technological shifts, which inevitably create process and cultural change, without understanding the tangible benefits to them.</p>

						<p>Organizations must develop meaningful processes for sharing information and results between technology and business units. Still, even sophisticated organizations need more specialized personnel who understand the technology and have the skills to educate others about its value adequately.</p>

						<p>The highest-performing organizations were actively courting these folks through recruiting or up-skilling internally to help all leaders feel like they were taking fewer bets and making more educated decisions.</p>

						<p>Participants strongly agreed in wanting more open discussions over what their peers in the end user community are using to solve their technological challenges. Knowledge-sharing programs like the CTO Summit, which provide a forum for discussing wins and opportunities, help leadership better build bridges between the technology and business units within their organization.</p>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">

						<h2 class="sub-header text-blue">Create information-sharing councils for quick alignment on cloud native strategy</h2>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<p>According to the Summit’s participants, culture and people are the most challenging part of an organization to move and mature, but that’s never because they’re incapable of adapting. Instead, they’re often still reeling from the sheer amount of change their world has experienced in the last few years, beginning with dev vs. ops, then front- vs. back-end, then DevOps, and sending with the tide of shift-left complexity.</p>

						<p>At the same time, the participants strongly agreed that talented employees are also the solution if they’re given ample opportunity to share their knowledge and learn from one another.</p>

						<p>One proven solution is councils, which consist of a single senior member or leader from each time across the organization. By getting these folks in the same room, they can discuss and disseminate opportunities for improving security and compliance, lessening the individual burden to learn the modern best practices or make collective decisions on what success looks like. It’s a top-down approach that prioritizes peer-to-peer education, prioritizing people and improving culture.</p>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">

						<h2 class="sub-header text-blue">Transition from free tool choice to a paved road strategy unlocks</h2>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<p>The era of free tool choice, whether through ClickOps or giving developers console access to deploy infrastructure on their whim, inevitably needs to end as an organization matures its cloud native posture. CTOs will fight a losing battle against security and compliance issues or struggle with maintaining a competitive velocity. They can stand up quickly and optimize freely if they don’t have an agreed-upon package.</p>

						<p>The CTO’s Summits participants offered many options for exploring and defining a paved road of cloud native tools that works for an organization’s unique needs, culture, and business/governance environment:</p>

						<ul>
							<li>Create as many POCs as possible, using them as opportunities to review open source code and/or their vendors.</li>
							<li>Evaluate vendors by looking at size (LinkedIn), funding, their place on Gartner’s Magic Quadrant, and analyst reviews.</li>
							<li>Freely dogfood new tools and clusters for internal use cases to deeply test new projects without interrupting the customer experience.</li>
							<li>Slowly prove out cloud native toolchains, recognizing an organization might only use the technology for 3-4 years as the Cloud Native Landscape adopts new ideas.</li>
						</ul>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">

						<h2 class="sub-header text-blue">Engage in opportunities to contribute to the convergence of tool and architecture choice</h2>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<p>As much as the Summit’s participants advocated for a paved road and wished they could simply implement a stack of “best practices” tools and configurations, defining that goes against the CNCF’s mission of neutrality. CNCF leverages groups like the <a href="https://www.cncf.io/people/technical-oversight-committee/">Technical Oversight Committee</a> (TOC) not to pick favorites but to accept feedback from the end user community to define the visions, standardizations, and best practices to be applied across the landscape.</p>

						<p>The cloud native landscape should thrive where it’s most proven by driving business value, and it hasn’t yet converged on a single paved road.</p>

						<p>A valuable opportunity for any end user organization is the ability to influence the direction of the cloud native community by sharing their experiences and insights on how these tools have effectively addressed real-world business challenges and delivered value to customers. By sharing their knowledge and expertise, end users have the power to shape the development of future cloud native solutions.</p>
					</div>
				</div>
			</div>
		</section>

		<div
			class="section-05 alignfull background-image-wrapper section-break">
			<figure class="background-image-figure">
				<?php LF_Utils::display_responsive_images( 84200, 'full', '1440px', false, 'lazy', 'Conference attendees relaxing' ); ?>
			</figure>
		</div>

		<section class="section-06 alignfull text-blue">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">Discussion <br />
						Topics</h2>
					<div class="section-number">3/6</div>

				</div>
				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>During this Summit’s breakout rooms, participants focused on the intersection between the Cloud Native Maturity Model and the provisioning layer of the cloud native landscape.</p>

						<p>The Cloud Native Maturity Model has five dimensions and five levels, and the provisioning layer is broken up into four subcategories. If participants in the breakout sessions tried to focus on each of these combinations, they’d have to wrestle with 100 points of conversation. Instead, participants focused on the four subcategories of the provisioning layers in terms of people, process, policy, and technology.</p>

						<p><strong>Provisioning</strong> is the first layer in the cloud native landscape, encompassing tools used to create and harden the foundation on which cloud native applications are built and deployed. This extends into tools for applying security and governance policy, managing keys and secrets, and how an organization delivers containers, the fundamental cloud native building block, to its clusters.</p>

						<div aria-hidden="true" class="report-spacer-40"></div>

						<div class="number-align">
							<p class="bold-number">1</p>
							<div>
								<p><strong>Automation & Configuration</strong><br/>These tools speed up the creation and configuration of compute resources, allowing developers to iterate and deploy far more rapidly than on infrastructure of the past. With declarative configuration and infrastructure-as-code (IaC), one can reproduce any cloud native infrastructure or application with a single click.</p>
							</div>
						</div>

						<div class="number-align">
							<p class="bold-number">2</p>
							<div>
								<p><strong>Container Registry</strong><br/>Registries store and categorize repositories of containers, allowing users to pull, build, and run containers from a centralized, standardized, and secured source. These tools are more than a web API that returns an image, scanning the underlying code for CVEs or policy violations that would put an organization at unnecessary risk.</p>
							</div>
						</div>

						<div class="number-align">
							<p class="bold-number">3</p>
							<div>
								<p><strong>Security & Compliance</strong><br/>This subcategory of tools provides assurance and confidence that despite how quickly cloud native applications are iterated on and deployed, it always happens in a secure and policy-driven way. Use cases include automatically detecting vulnerabilities, flagging misconfigurations, and hardening containers or the Kubernetes control plane.</p>
							</div>
						</div>

						<div class="number-align">
							<p class="bold-number">4</p>
							<div>
								<p><strong>Key Management</strong><br/>To meet many of those security and compliance requirements, along with the on-demand nature of cloud native infrastructure, organizations need to securely store sensitive data, like encryption keys, in a way that’s programmatic and automated. These tools maintain proper access by introducing authentication and authorization, understanding whether a request is valid, and having permission to take action.</p>
							</div>
						</div>

						<div aria-hidden="true" class="report-spacer-40"></div>

						<p>The following two sections contain the condensed takeaways and advice from the two breakout sessions.</p>

						<p>The points below represent advice, opinions, and proposed best practices from more than a dozen end user organizations from many verticals. They should not be considered as recommendations from the CNCF, endorsements of any particular strategy, or a checklist required to reach any level in cloud native maturity.</p>
					</div>
				</div>

				<div class="shadow-hr"></div>
				<div class="lf-grid">
					<div class="restrictive-9-col">
						<h2 class="sub-header-large"><span>Breakout session 1</span>Automation & Configuration + Container Registry</h2>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<h3 class="small-header">Levels 1 and 2 of the Cloud Native Maturity Model</h3>

						<div aria-hidden="true" class="report-spacer-40"></div>

						<ul class="list">
							<li>
								<p><strong>Agree on internal definitions for automation and configuration (and configuration automation)</strong></p>
								<p>Registries store and categorize repositories of containers, allowing users to pull, build, and run containers from a centralized, standardized, and secured source. These tools are more than a web API that returns an image, scanning the underlying code for CVEs or policy violations that would put an organization at unnecessary risk.</p>
							</li>
							<li>
								<p><strong>Spend more time validating tool choices when bare metal is involved</strong></p>
								<p>Organizations responsible for the foundation beneath the cloud native foundation must spend additional time validating their toolkits and running proof of concept infrastructure.</p>
							</li>
							<li>
								<p><strong>Be aware of where containers come from</strong></p>
								<p>Containers from popular public registries can include vulnerabilities, low-quality code, or unknown third-party libraries.</p>
							</li>
							<li>
								<p><strong>Balance between risk and efficiency through automation</strong></p>
								<p>Setting up a complete auto-scaling solution, from the tooling one uses to close negotiations with their public cloud provider, is often not the cheapest. But it will likely come at a lower overall cost, factoring in time and additional development effort for an organization.</p>
							</li>
							<li>
								<p><strong>Determine the level of container scanning security that’s ‘good enough.’</strong></p>
								<p>All organizations should scan all their containers, whether self-hosted or on a public registry, for known CVEs during development and deployment as a baseline.</p>
							</li>
						</ul>

						<div aria-hidden="true" class="report-spacer-70"></div>

						<h3 class="small-header">Levels 3 AND 4</h3>

						<div aria-hidden="true" class="report-spacer-40"></div>

						<ul class="list">
							<li><p><strong>The maturation process will feel like a crawl for a long time</strong></p><p>Transitioning to a cloud native foundation, including every process from code commit to shipping a product to production, requires considerable planning and oversight.</p></li>

							<li><p><strong>Recognize that automation has a litany of complicated subplots</strong></p><p>Aside from standing up a Kubernetes cluster, automation and configuration tools are also responsible for resiliency, resource optimization, developer productivity, horizontal/vertical scaling, resourcing with cloud providers, load balancing, and more.</p></li>

							<li><p><strong>Start hosting containers internally</strong></p><p>An organization can scan and generate reports based entirely on its organization’s security, governance, and risk profiles, disallow public registries, and guarantee its cluster never runs a container without explicit approval.</p></li>

							<li><p><strong>GitOps enables powerful ‘cloud native, but not in the cloud’ experiences</strong></p><p>With a single repository for stamping out many instances of a valuable stack, one can enable localized, experimental, or air-gapped teams to launch infrastructure based on cloud native technology without being run in the cloud.</p></li>

							<li><p><strong>The ratio between cloud native tooling vs. internal “glue” code is a good maturity signal</strong></p><p>Many organizations balance processes built ten years ago with brand-new cloud native infrastructure and applications. But, if an organization has dispensed with many of the custom Bash scripts and internal Go libraries for automation and configuration, it’s on the right track.</p></li>

							<li><p><strong>Resist the urge to give developers direct web console access to cloud providers</strong></p><p>When they want to spin up cloud native resources to experiment, they often mistakenly believe they need every option, service, and API. They’re asking for a platform engineer-like experience, similar to what they might have had with “ClickOps,” but with more flexibility, simplicity, and guideposts for their protection.</p></li>

							<li><p><strong>When an organization is done crawling, it’ll start walking and running even faster</strong></p><p>As organizations tie-up the latent period to standardize their provisioning tools and move into innovation, they’ll unlock new technological and cultural complexity levels.</p></li>
						</ul>

						<div aria-hidden="true" class="report-spacer-70"></div>

						<h3 class="small-header">Level 5</h3>

						<div aria-hidden="true" class="report-spacer-40"></div>

						<ul class="list">
							<li><p><strong>Create different experiences for platform teams and developers</strong></p><p>Those building platforms on top of infrastructure—think stream processing and AI workloads—require lower-level automation and configuration. By separating infrastructure configuration from application configuration, an organization can provide a cloud native experience for both teams that work at their level.</p></li>

							<li><p><strong>Prepare automation for the unexpected (and expected)</strong></p><p>For example, organizations running e-commerce sites must create advanced plans on a provisioning level to override or bypass established configurations to deal with holiday rushes or unexpected events.</p></li>

							<li><p><strong>The container registry becomes a CDN-like service with ‘Tier 0’ uptime requirements</strong></p><p>To keep clusters pulling containers happily, one must prevent a self-inflicted DDoS with a multi-region, multi-cloud resilient service.</p></li>

							<li><p><strong>Continuously educate teams</strong></p><p>Run internal classes to teach development teams best practices on auto-scaling (vertical and horizontal), the differences between node and pod auto-scaling, resource planning, and more.</p></li>

							<li><p><strong>Prioritize making lives easier over chasing diminishing efficiency returns</strong></p><p>At this point in an organization’s journey, additional cost optimization might inadvertently increase its risk. Instead, focus on improving developer experience and productivity.</p></li>
						</ul>
					</div>
				</div>

				<div class="shadow-hr"></div>
				<div class="lf-grid">
					<div class="restrictive-9-col">
						<h2 class="sub-header-large"><span>Breakout session 2</span>Security & Compliance + Key Management</h2>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<h3 class="small-header">Levels 1 and 2</h3>

						<div aria-hidden="true" class="report-spacer-40"></div>

						<ul class="list">
							<li><p><strong>Know that security and compliance are two distinct (but converging) conversations</strong></p><p>Security is about locking down and protecting applications and infrastructure. Compliance is about defining a policy and doing what that policy demands.</p></li>
							<li><p><strong>Feel comfortable experimenting with new security tools</strong></p><p>Unlike the tool(s) an organization uses to configure or automate clusters, it can more quickly adopt a tool that scans containers for CVEs or runs a policy engine to check Kubernetes manifests for misconfigurations.</p></li>
							<li><p><strong>Plan ahead for the expense of security maturity</strong></p><p>Development teams must implement secret, key, certificate management, network protection, penetration testing, and regulations requiring years of audit logs to do security right. Proper planning accounts for both operational and capital expenditures.</p></li>
							<li><p><strong>Know that making a million mistakes along the way is normal</strong></p><p>Recognize that every organization can and will get things wrong on its journey toward standardized platforms that abstract security away to simplify workflows for application development teams. This is true even for a simple service, like an API endpoint with authentication with OAuth.</p></li>
							<li><p><strong>Create standards for key management</strong></p><p>An organization should, for example, know how long the process would take to rotate all its keys in case of a breach or governance requirement. How automated of a process would that be?</p></li>
						</ul>

						<div aria-hidden="true" class="report-spacer-70"></div>

						<h3 class="small-header">Levels 3 AND 4</h3>

						<div aria-hidden="true" class="report-spacer-40"></div>

						<ul class="list">
							<li><p><strong>Continuously build a culture of shifting security left into early applications</strong></p><p>But, instead of leaving all the pressure on software developers who are not security experts, consider running security architecture reviews (SAR) to assess the security of any new application across infrastructure, application, people, and processes.</p></li>

							<li><p><strong>Empower security teams with administrative roles</strong></p><p>If they receive data about a potential vulnerability, they can meet with the relevant team to discuss the implications and design a fix. If the service isn’t patched within an agreed-upon timeline, the security team has the right to shut the service down.</p></li>

							<li><p><strong>Good governance requires strong alignment on tool alignment</strong></p><p>To create a solution that meets an organization’s cloud native maturity, it will need a “paved road” toolkit that includes data security, data access, customer access, and much more.</p></li>

							<li><p><strong>Going multi-region uncovers new security and compliance issues</strong></p><p>For example, how do teams move workloads in a way compliant with all the regions they collect, store, and send user data to? How do they design and enforce these policies?</p></li>
						</ul>

						<div aria-hidden="true" class="report-spacer-70"></div>

						<h3 class="small-header">Level 5</h3>

						<div aria-hidden="true" class="report-spacer-40"></div>

						<ul class="list">
							<li><p><strong>Create security councils for disseminating best practices</strong></p><p>Organizations should regularly get its development team leads into the same room as security leadership to organically educate and spread awareness of dangerous trends or new opportunities.</p></li>
							<li><p><strong>Investigate how to monitor compliance levels and determine success criteria</strong></p><p>Some organizations might aim for a specific percentage of compliance, such as 70%, while others might rely on compliance engines that regularly generate reports on misconfigured policies for manual review. DevOps teams often use key performance indicators (KPIs) such as mean time to recovery (MTTR) to measure resiliency, but determining the success of compliance efforts can be less straightforward. It is important for organizations to consider their specific compliance needs and goals carefully and to establish clear metrics and processes for monitoring and evaluating compliance levels.</p></li>
						</ul>
					</div>
				</div>
			</div>
		</section>

		<div
			class="section-07 alignfull background-image-wrapper section-break">
			<figure class="background-image-figure">
				<?php LF_Utils::display_responsive_images( 84202, 'full', '1440px', false, 'lazy', 'Conference attendees relaxing' ); ?>
			</figure>
		</div>

		<section class="section-08 is-style-down-gradient alignfull text-blue">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">Maturing the definition of Cloud Native maturity</h2>
					<div class="section-number">4/6</div>

				</div>
				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>Throughout the Summit, participants noted how refreshing it was to speak candidly with other end users about real-world usage of cloud native provisioning tools. In this setting, they could compare and contrast their definitions of maturity against other organizations and what’s already codified in the Cloud Native Maturity Model.</p>

						<p>The content of their discussions is a valuable signal, for the CNCF and the Cartografos Working Group, as they work on refining the KPIs and goals for each level and each dimension of the Model.</p>

						<div aria-hidden="true" class="report-spacer-40"></div>
					</div>
				</div>

				<div class="lf-grid">

					<div class="restrictive-9-col">

						<h2 class="sub-header">Cloud native maturity model</h2>

						<div aria-hidden="true" class="report-spacer-40"></div>

						<img class=""
							src="<?php LF_Utils::get_svg( $report_folder . 'cloud-maturity-model.svg', true ); ?>"
							width="890" height="346"
							alt=""
							loading="lazy">

						<div aria-hidden="true" class="report-spacer-120"></div>

						<p>As referenced more than once in this report, cloud native maturity isn’t an all-in, perfectly-linear journey. Every end user organization, and the many parts with them, will progress at different speeds. Participants welcomed the honest discussions and recognized that cloud native maturity isn’t a race. We aren’t competitors trying to leave one another behind, but mountaineers tethered to one another as we try to reach a common goal.</p>

						<p>In the spirit of collaboration, participants generally agreed on the following practical takeaways, aside from the key findings covered above:</p>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<ul>
							<li><strong>Encourage more discussion from end user contributors</strong> to the CNCF around how to set KPIs for cloud native maturity and build cultures eager to meet those challenges.</li>
							<li><strong>Investigate novel ways to communicate the business value of cloud native,</strong> both within end user organizations and through the CNCF.</li>
							<li><strong>Continue the CTO Summit at the next KubeCon + CloudNativeCon gathering in 2023</strong> with a focus on different layers of the <a href="https://landscape.cncf.io/guide">Cloud Native Landscape</a>, such as Runtime, Orchestration & Management, App Definition & Development, Observability & Analysis, or Platform.</li>
						</ul>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<p>Given the CNCF’s mission for enabling collective learning for every organization, whether contributing to the landscape or building new end user experiences with the tools represented, we’ll continue to explore better ways to disseminate information about the Cloud Native Maturity Model. We’re also eager to detail the utilization of this framework by some of the CNCF’s most prominent end user member organizations.</p>
					</div>
				</div>
			</div>
		</section>

		<section class="section-09 is-style-down-gradient alignfull text-blue">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">Appendices</h2>
					<div class="section-number">5/6</div>
				</div>

				<h2 class="sub-header"><span class="text-purple">Appendix A:</span> Summit Process and Discussion Framework</h2>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">

						<p><strong>The Summit began with introductory remarks from Taylor Dolezal, Head of Ecosystem at CNCF.</strong> Dolezal got participants on the same page regarding the areas and levels of the Cloud Native Maturity Model and then detailed the provisioning layer of the cloud native landscape, which includes significant subcategories: Automation & Configuration, Container Registry, Security & Compliance, and Key Management.</p>

						<p><strong>The Summit operated under Chatham House Rule.</strong> This verbal agreement between participants in a meeting or discussion states that they are free to use any information they gather from their conversation but not attribute any comments to a particular person or organization.</p>

						<p>This rule applied during the introduction and breakout sessions. Participants spoke freely about their journeys as leading technologists into cloud native, even if they expressed views at odds with their organizations or executive leadership peers. This also allowed participants to candidly discuss the effectiveness and promise of cloud native projects, based on real-world applications without concern for how the community might receive their comments.</p>

						<p><strong>Participants split into two breakout sessions based on role and business vertical.</strong> Each breakout session had a facilitator responsible for generating discussion and moving conversations between four subcategories, as indicated by the Summit’s schedule. CNCF recorded each breakout session, with additional notes taken by contributors to the CTO Summit, to discover and collate critical findings in this report.</p>

						<p><strong>There was no formal discussion framework for the breakout sessions.</strong> Unlike the previous CTO Summit, participants had more unstructured time to create more open discussions, letting them expound on specific topics or track down unexpected but fruitful conversations. Participants still had the Summit’s core discussion points, the Cloud Native Maturity Model and the four subcategories of provisioning tools, to guide their discussions with the help of the facilitator.</p>

					</div>
				</div>

				<div class="shadow-hr"></div>

				<h2 class="sub-header" id="appendix-b" ><span class="text-purple">Appendix B:</span> What is the cloud native maturity model?</h2>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">

						<p>Organizations begin on their cloud native maturity journey as soon as they’ve driven consensus on the business outcomes they would like to achieve. Technological transformation via the cloud native landscape is a productive journey but not always straightforward. A shared organizational goal helps guide technology leadership through the inevitable difficult decisions ahead.</p>

						<p>Achieving the right business outcome happens at the intersection of technology and culture. The Cloud Native Maturity Model helps organizations align on a single set of goals, KPIs, success stories, and opportunities that incorporate both.</p>

						<p>In addition, the Model is flexible enough to be applied to multiple units within a single organization or even from application to application to identify small-scale and organization-wide states, which drive more confident and precise strategies for continued improvement.</p>

						<p>There are five dimensions of the Cloud Native Maturity Model, which ask essential questions about the nature and structure of an organization:</p>

						<ul class="list">
							<li>
								<p><strong>People</strong></p>
								<p>How does an organization work, and what skills does it require to move from adoption to immersion in cloud native technology?</p>
							</li>
							<li>
								<p><strong>Process</strong></p>
								<p>How does an organization leverage technology to codify workflows and security in code and CI/CD?</p>
							</li>
							<li>
								<p><strong>Policy</strong></p>
								<p>What policies are required to meet security and compliance standards, and how are teams using tools like CI/CD to shift left security?</p>
							</li>
							<li>
								<p><strong>Technology</strong></p>
								<p>How does cloud native technology support and augment the organization’s people and processes for better observability, security, and more?</p>
							</li>
							<li>
								<p><strong>Business Outcomes</strong></p>
								<p>How does cloud native drive genuine business value for the organization, and how does it communicate that value to leadership?</p>
							</li>
						</ul>

						<div aria-hidden="true" class="report-spacer-40"></div>

						<p>And within each dimension, an organization can progress through five maturity levels:</p>

						<div aria-hidden="true" class="report-spacer-40"></div>

						<ul class="list">
							<li><p><strong>Level 1: Build</strong></p><p>Teams have baseline cloud native implementations and successful proof of concepts (POCs). Initial findings are found and shared on how cloud native will help improve applications and services.</p></li>
							<li><p><strong>Level 2: Operate</strong></p><p>Cloud native is an established solution, and workflows are moving to production. The ability to evaluate the benefits of the migrations. Most organizations reach this level of maturity and plateau.</p></li>
							<li><p><strong>Level 3: Scale</strong></p><p>Cloud native teams build their confidence, security, efficiency, and competence while implementing processes for scale. Organizations have started to notice that services are more scalable.</p></li>
							<li><p><strong>Level 4: Improve</strong></p><p>The organization focuses on improving security, policy, and governance across environments, and time gets spent on business problems instead of cloud native maintenance.</p></li>
							<li><p><strong>Level 5: Optimize</strong></p><p>Teams continue to revisit earlier decisions and optimize workloads, in a continuous cycle of improvement, based on advanced and performance metrics created by observability tools.</p></li>
						</ul>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<h2 class="sub-header"><span class="text-purple">Appendix C:</span> Glossary</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">

						<p><strong>API:</strong> application programming interface</p>
						<p><strong>CNCF:</strong> Cloud Native Computing Foundation</p>
						<p><strong>CTO:</strong> Chief Technology Officer</p>
						<p><strong>CVE:</strong> Common Vulnerabilities and Exposures system</p>
						<p><strong>MTTR:</strong> mean time to recovery</p>
						<p><strong>SAR:</strong> security architecture review</p>

					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-200"></div>

				<div class="wp-block-group is-style-see-all">
					<div class="wp-block-columns are-vertically-aligned-centered">
						<div class="wp-block-column is-vertically-aligned-centered"
							style="flex-basis:80%">
							<h2 class="sub-header">DETROIT photo highlights
							</h2>
						</div>
						<div class="wp-block-column is-vertically-aligned-bottom"
							style="flex-basis:20%">
							<p class="has-text-align-right is-style-link-cta"><a href="#" title="KubeCon+CloudNativeCon Europe 2022 Photo Gallery">See more</a></p>
						</div>
					</div>
					<div aria-hidden="true" class="report-spacer-50"></div>
					<div class="columns-two columns-two--images">
						<figure class="">
							<?php LF_Utils::display_responsive_images( 84203, 'full', '685px', false, 'lazy', 'Conference attendees relaxing' ); ?>
						</figure>
						<figure class="">
							<?php LF_Utils::display_responsive_images( 84204, 'full', '503px', false, 'lazy', 'Conference attendees relaxing' ); ?>
						</figure>
					</div>
				</div>
			</div>
		</section>

		<section class="section-10 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header long-word">Acknowledgements</h2>
					<div class="section-number">6/6</div>
				</div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>A big thank-you to the CNCF for designing and hosting the second CTO Summit this year at KubeCon + CloudNativeCon in Detroit.</p>

						<p>We’re all indebted to the CTO Summit committee, whose members are responsible for deciding the content discussed and creating bridges with other end user organizations still ramping up their participation in CNCF and CTO Summit activities:</p>

						<ul>
							<li><strong>Amr Abdelhalem</strong> (Fidelity Investments)</li>
							<li><strong>Arun Gupta</strong> (Intel)</li>
							<li><strong>Henrik Blixt</strong> (Intuit)</li>
							<li><strong>Ricardo Torres</strong> (Boeing)</li>
							<li><strong>Pratik Wadher</strong> (Intuit)</li>
							<li><strong>Priyanka Sharma</strong> (Cloud Native Computing Foundation)</li>
							<li><strong>Hilary Carter</strong> (Linux Foundation Research)</li>
						</ul>

						<p>The breakout sessions were home to vibrant and valuable conversations thanks to our three facilitators: Henrik Blixt (Intuit), Ricardo Torres (Boeing), and Jeff Sica (CNCF). We’re indebted to their conversational natures and deep knowledge of the cloud native landscape, which established a spirit of transparency that got participants talking openly about their challenges and opportunities. A special thanks to our note-takers, Danielle Cook (Fairwinds), John Forman (Accenture), and Simon Forster (Stackegy). Their hard work helped create this report and, more importantly, helped the CNCF and Cartografos Working Group internalize many vital lessons.</p>

						<p>The Cartografos Working Group has spearheaded the Cloud Native Maturity Model and worked enormously hard to codify its dimensions, levels, and guidelines. The entire cloud native ecosystem is grateful for these efforts.</p>

						<p>Thanks to Uptycs for generously sponsoring the Summit, including the reception and dinner that followed this event on October 26, 2022.</p>

						<p>We’ve gone long enough without thanking Taylor Dolezal, the Head of Ecosystem at CNCF, for being a bright waypoint for the end user community. Without him, we wouldn’t have such an inviting culture of openness and willingness to learn from one another. We’re also enormously indebted to the 21 participants of this autumn’s CTO Summit, who contributed invaluable insight not only for this report but also for the continuous improvement of the CNCF’s End User Community and Cloud Native Maturity Model.</p>
					</div>
				</div>
			</div>
		</section>

		<section class="section-11 is-style-down-gradient alignfull">

			<div class="container wrap">

				<h2 class="section-header">Thank You</h2>

				<div aria-hidden="true" class="report-spacer-50"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p class="lead">Your comments and feedback at <a href="mailto:cto-summit@cncf.io" title="Send an email to cto-summit@cncf.io">cto-summit@cncf.io</a></p>

						<p>The Cloud Native Computing Foundation (CNCF) hosts critical components of the global technology infrastructure. It brings together the world’s top developers, end users, and vendors and run the largest open source developer conferences. CNCF is the open source, vendor-neutral hub of cloud native computing, hosting projects like Kubernetes and Prometheus to make cloud native universal and sustainable. The CNCF is part of the Linux Foundation.</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="columns-three">
					<a href="https://www.linuxfoundation.org/research/"
						title="Linux Foundation Research"><img
							src="<?php LF_utils::get_image( $report_folder . 'logo-lf-research.png' ); ?>"
							alt="The Linux Foundation Research" width="269"
								height="48" loading="lazy"></a>
					<a href="https://www.cncf.io"
						title="Cloud Native Computing Foundation"><img
							src="<?php LF_utils::get_svg( $report_folder . 'cncf-logo.svg', true ); ?>"
							alt="CNCF" width="280" height="54"
							loading="lazy"></a>
				</div>

				<div class="shadow-hr"></div>

				<div class="lf-grid copyright">
					<div class="copyright__col1">
						<p>Founded in 2021, Linux Foundation Research explores the growing scale of open source collaboration, providing insight into emerging technology trends, best practices, and the global impact of open source projects. Through leveraging project databases and networks, and a commitment to best practices in quantitative and qualitative methodologies, Linux Foundation Research is creating the go-to library for open source insights for the benefit of organizations the world over.</p>

						<p>To reference this work, please cite as follows: “CTO Summit Report NA 2022: Exploring the Foundations of Cloud Native Maturity,” foreword by Amr Abdelhalem, Arun Gupta, Ricardo Torres, Pratik Wadher, and Hendrik Blixt, The Cloud Native Computing Foundation.</p>

					</div>

					<div class="copyright__col2">

						<a href="https://creativecommons.org/licenses/by-nd/2.0/"
							title="Creative Commons">
							<img src="<?php LF_utils::get_image( $report_folder . 'copyright.png' ); ?>"
								alt="Attribution-NoDerivs 2.0 Generic (CC BY-ND 2.0)"
								loading="lazy" width="190" height="69">
						</a>

						<p>August 2022<br>Copyright 2022<br>The Linux Foundation</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="social-share">
					<p class="social-share__title">Share this report</p>

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
							<a aria-label="Share by Email" title="Share by Email"
								href="<?php echo esc_url( $mailto_url ); ?>"><?php Lf_Utils::get_svg( 'reports/social-mail.svg' ); ?></a>
						<?php endif; ?>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<p class="disclaimer"><span class="uppercase">Disclaimer</span><br/>This report is provided “as is.” The Linux Foundation and its authors, contributors, and sponsors expressly disclaim any warranties (express, implied, or otherwise), including implied warranties of merchantability, noninfringement, fitness for a particular purpose, or title, related to this report. In no event will the Linux Foundation and its authors, contributors, and sponsors be liable to any other party for lost profits or any form of indirect, special, incidental, or consequential damages of any character from any causes of action of any kind with respect to this report, whether based on breach of contract, tort (including negligence), or otherwise, and whether they have been advised of the possibility of such damage. Sponsorship of the creation of this report does not constitute an endorsement of itsfindings by any of its sponsors.</p>
			</div>

		</section>

	</article>
</main>
<?php
get_template_part( 'components/footer' );
