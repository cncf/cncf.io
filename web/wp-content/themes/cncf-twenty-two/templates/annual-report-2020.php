<?php
/**
 * Template Name: Annual Report 2020
 * Template Post Type: lf_report
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

get_template_part( 'components/header' );

// declare report PDF link to reference as variable.
$pdf_link = '/cncf-annual-report-2020-pdf';

?>

<link rel="prefetch"
	href="<?php echo esc_url( get_template_directory_uri() . '/build/annual-report-2020.min.css' ); ?>"
	as="style" crossorigin="anonymous" />

<?php
wp_enqueue_style( '2020', get_template_directory_uri() . '/build/annual-report-2020.min.css', array(), filemtime( get_template_directory() . '/build/annual-report-2020.min.css' ), 'all' );
?>

<main class="ar-2020">
	<div class="container wrap">
		<figure class="wp-block-image alignfull size-full"><img loading="eager"
				width="2500" height="1153"
				src="<?php echo esc_url( get_template_directory_uri() . '/images/annual-reports/2020/CNCF-Annual-Report-2020-graphics-New.jpg' ); ?>"
				alt="CNCF Annual Report 2020"
				sizes="(max-width: 2500px) 100vw, 2500px">
		</figure>
		<div style="height:40px" aria-hidden="true"
			class="wp-block-spacer is-style-40-responsive"></div>
		<div
			class="wp-container-623c529f7af13 wp-block-buttons is-content-justification-center">
			<div class="wp-block-button"><a
					class="wp-block-button__link no-border-radius"
					href="<?php echo esc_url( $pdf_link ); ?>"><strong>DOWNLOAD
						ANNUAL
						REPORT
						PDF</strong></a></div>
		</div>
		<div style="height:40px" aria-hidden="true"
			class="wp-block-spacer is-style-40-responsive"></div>
		<h3
			class="has-text-align-center is-style-max-width-100 has-blue-100-background-color has-background">
			<span class="has-inline-color has-purple-700-color">Table of
				Contents</span>
		</h3>
		<div class="wp-block-columns is-style-equal-height-responsive">
			<div class="wp-block-column">
				<h4 class="is-style-no-margins"><a
						href="#who-we-are"><strong>Who We
							Are</strong></a></h4>
				<p><a href="#dan-kohn">Remembering Dan Kohn</a><br><a href="#we-are-expanding">Momentum in 2020</a><br><a href="#membership">Membership</a><br></p>
				<h4 class="is-style-no-margins"><a
						href="#end-user-community"><strong>End User
							Community</strong></a></h4>
				<p><a href="#end-user-cncf-projects">End Users &amp; CNCF Projects / TOC</a><br><a href="#end-users-kubecon">End Users &amp; KubeCon + CloudNativeCon</a><br><a href="#end-user-tech-radar">CNCF End User Technology Radar</a><br><a href="#end-user-benefits">End User Training Benefits</a><br><a href="#end-user-case-studies">End User Case Studies</a><br><a href="#conferences">Conferences &amp; Events</a><br><a href="#wellness">Wellness Activities</a></p>
				<h4 class="is-style-bottom-margin"><strong><a
							href="#training">Training
							&amp; Certification</a><br></strong></h4>
			</div>
			<div class="wp-block-column">
				<h4 class="is-style-no-margins"><a
						href="#project-updates"><strong>Project Updates &amp;
							Satisfaction</strong></a></h4>
				<p><a href="#project-maturity-levels">Project Maturity Levels</a><br><a href="#project-maintainer-survey">CNCF Project Maintainer Survey Results</a><br><a href="#project-updates-releases">Project Updates &amp; Releases</a><br><a href="#services-assistance-projects">Services &amp; Assistance for Projects</a><br><a href="#documentation">Documentation, Websites, &amp; Blog Posts</a><br><a href="#service-desk">CNCF Service Desk</a></p>
				<h4 class="is-style-no-margins"><a
						href="#community-engagement"><strong>Community
							Engagement</strong></a></h4>
				<p><a href="#community-awards">Community Awards</a><br><a href="#meetups">CNCF Meetups</a><br><a href="#kubernetes-community-days">Kubernetes Community Days Update</a><br><a href="#cncf-ambassador">CNCF Ambassador Program</a><br><a href="#community-mentoring">Community Mentoring &amp; Internships</a></p>
			</div>
			<div class="wp-block-column">
				<h4 class="is-style-no-margins"><a
						href="#ecosystem-tools"><strong>Ecosystem
							Tools</strong></a>
				</h4>
				<p><a href="#cncf-job-board">CNCF Job Board</a><br><a href="#speakers-bureau">CNCF Speakers Bureau</a><br><a href="#devstats">DevStats</a><br><a href="#landscape">CNCF Landscape &amp; Cloud Native Trail Map</a><br><a href="#security-audits">CNCF Open Source Security Audits</a></p>
				<h4 class="is-style-bottom-margin"><strong><a
							href="#china">Growth in
							China</a><br></strong></h4>
				<h4 class="is-style-bottom-margin"><a
						href="#2021"><strong>Looking
							Forward to 2021</strong></a></h4>
			</div>
		</div>
		<div style="height:59px" aria-hidden="true" class="wp-block-spacer">
		</div>
		<hr
			class="wp-block-separator has-text-color has-background has-blue-100-background-color has-blue-100-color is-style-wide">
		<div style="height:20px" aria-hidden="true" class="wp-block-spacer">
		</div>
		<h4 class="is-style-max-width-100"><br>Welcome to the 2020 Cloud Native
			Computing Foundation annual report. </h4>
		<p
			class="is-style-max-width-900 has-header-4-font-size">Our themes for the year were end user driven open source, diversity-powered resilience, and a focus on education and training. Comments and feedback are welcome at <a href="mailto:info@cncf.io">info@cncf.io</a>.</p>
		<div style="height:20px" aria-hidden="true" class="wp-block-spacer">
		</div>
		<hr
			class="wp-block-separator has-text-color has-background has-blue-100-background-color has-blue-100-color is-style-wide">
		<div style="height:80px" aria-hidden="true"
			class="wp-block-spacer is-style-80-responsive"></div>
		<h2 class="is-style-divider-line" id="who-we-are">Who We Are</h2>
		<p
			class="is-style-max-width-900 has-header-3-font-size">The Cloud Native Computing Foundation (CNCF) is an open source software foundation dedicated to making cloud native computing universal and sustainable. </p>
		<p class="is-style-default"
			id="who-we-are">Cloud native technologies empower organizations to build and run scalable applications in modern, dynamic environments across public, private, and hybrid clouds. Containers, service meshes, microservices, immutable infrastructure, and declarative APIs exemplify the cloud native approach.</p>
		<p
			class="is-style-default">We are a community of open source projects, including Kubernetes, Prometheus, Envoy, and <a href="https://www.cncf.io/projects/">many others</a>. Kubernetes and other CNCF projects have quickly gained adoption and won community support, becoming some of the <a href="https://docs.google.com/presentation/d/1BoxFeENJcINgHbKfygXpXROchiRO2LBT-pzdaOFr4Zg/edit#slide=id.g39c264972c_182_493">highest velocity projects</a> in the history of open source.&nbsp;</p>
		<p
			class="is-style-default">CNCF employs <a href="https://www.cncf.io/people/staff/">34</a> people from various backgrounds and locations; 71% are women, 29% are men. CNCF’s Governance Leadership, comprising the Governing Board and Technical Oversight Committee, is 14% women and 86% men.</p>
		<figure class="wp-block-image alignwide size-large"><img loading="lazy"
				width="819" height="264"
				src="<?php echo esc_url( get_template_directory_uri() . '/images/annual-reports/2020/CNCF-Annual-Report-2020-graphics-01-1.svg' ); ?>"
				alt="CNCF Staff, Governance, Leadership" class="wp-image-59679">
		</figure>
		<p
			class="is-style-max-width-100">CNCF’s revenue is derived from four primary fundraising sources, including membership, event sponsorship, event registration, and training.</p>
		<figure class="wp-block-image alignwide size-large"><img loading="lazy"
				width="776" height="350"
				src="<?php echo esc_url( get_template_directory_uri() . '/images/annual-reports/2020/CNCF-Annual-Report-2020-graphics-NEW2-02.svg' ); ?>"
				alt="Funding and Expenditure" class="wp-image-59755"></figure>
		<p
			class="is-style-default">A basic premise behind CNCF, our conferences (including <a href="https://www.cncf.io/community/kubecon-cloudnativecon-events/">KubeCon + CloudNativeCon</a>), and open source, in general, is that interactions are positive-sum. There is no fixed amount of investment, mindshare, or development contribution allocated to specific projects. Just as open source development is based on the idea that, collectively, we are smarter than any one of us, open source foundations work for the betterment of the entire community. </p>
		<p
			class="is-style-default">Equally important, a neutral home for a project and community fosters this type of positive-sum thinking and drives the growth and diversity that we believe are core elements of a successful open source project.</p>
		<div style="height:80px" aria-hidden="true"
			class="wp-block-spacer is-style-80-responsive"></div>
		<h3 id="dan-kohn">Remembering Dan Kohn</h3>
		<div class="wp-block-columns is-style-equal-height-responsive">
			<div class="wp-block-column" style="flex-basis:50%">
				<p>CNCF and The Linux Foundation are deeply saddened at the recent passing of our longtime colleague and dear friend, <a href="https://www.linuxfoundation.org/in-memoriam-dan-kohn/">Dan Kohn</a>. Dan was one of the great open source leaders of our time, a brilliant mind –&nbsp; devoted to giving back to the community, and a loving husband and father who will truly be missed forever.</p>
				<p>Dan’s lifelong desire was to help others. From serving as a volunteer firefighter in college to founding <a href="http://lfph.io">Linux Foundation Public Health</a> at the height of the pandemic to assist in the worldwide fight against COVID-19, he never stopped finding ways to make a positive and lasting impact. We are forever grateful for Dan’s many contributions and accomplishments and will continue to honor his legacy of constant collaboration, sharing, and compassion in everything that we do.</p>
			</div>
			<div class="wp-block-column" style="flex-basis:50%">
				<figure class="wp-block-image size-large"><img loading="lazy"
						width="1024" height="683"
						src="<?php echo esc_url( get_template_directory_uri() . '/images/annual-reports/2020/49091729693_232894eafb_k-1024x683.jpg' ); ?>"
						alt="Dan Kohn" class="wp-image-59300"></figure>
			</div>
		</div>
		<div style="height:82px" aria-hidden="true"
			class="wp-block-spacer is-style-80-responsive"></div>
		<h3 id="we-are-expanding">Momentum in 2020</h3>
		<p
			class="is-style-default">Throughout its fifth year, CNCF achieved tremendous community engagement through steady membership growth, incredible virtual event attendance, strong end user participation, and broad industry commentary. At present, <strong>CNCF hosts 80+ projects with over 110,000 contributors </strong><strong>&nbsp;from nearly 1,000 organizations</strong><strong> representing 177 countries.&nbsp;</strong></p>
		<p
			class="is-style-default">Cloud native tech is not just for the cloud anymore. Builtin <a href="https://builtin.com/software-engineering-perspectives/enterprise-cloud-native-kubernetes">declared</a> that “cloud-native technology is moving to the enterprise” because “legacy tech is waking up to cloud native”. Cloud native technologies are also driving the expansion of the <a href="https://www.cloudpro.co.uk/leadership/cloud-essentials/8834/the-role-of-cloud-native-at-the-edge">“Wild West” of edge computing</a> with many firms realizing the “financial benefits to taking the cloud native path”.</p>
		<p
			class="is-style-default">As cloud native technologies continue to scale across the world, touching almost every industry, CNCF has actively embraced diversity. This diversity is at the heart of the open source movement. Together we are stronger, faster, better, and more innovative than alone and apart, and that diversity makes us more resilient to weather any challenge — even the loss of a great leader.&nbsp;</p>
		<p
			class="is-style-default">Additionally, CNCF is committed to creating end user-driven open source, where everyone is encouraged to participate and get involved irrespective of their level of expertise. This expands the horizon of valuable contributions and welcomes everyone within the cloud native community to participate.&nbsp;</p>
		<p
			class="is-style-max-width-100">CNCF is at the forefront of these revolutionary market and technology transitions.</p>
		<div style="height:80px" aria-hidden="true"
			class="wp-block-spacer is-style-80-responsive"></div>
		<h3 id="membership">Membership</h3>
		<div class="wp-block-columns is-style-equal-height-responsive">
			<div class="wp-block-column" style="flex-basis:55%">
				<p
					class="is-style-default">CNCF would not be what it is today without the support of our global membership community. </p>
				<p class="is-style-default"
					id="membership">Our members help CNCF and the Linux Foundation provide neutral governance, strong IP management, ecosystem building, training, events, developer marketing, rich tools to engage communities, and more to keep the wheels of innovation spinning for our project communities.&nbsp;<br><br>The CNCF ecosystem continues to grow across vendor and end user memberships, making CNCF one of the most successful open source foundations ever. </p>
				<p class="is-style-default"
					id="membership">Over the course of 2020, we added over 150 new members, an increase of more than 28% from 2019. Our now 20 Platinum members include some of the world’s largest public cloud and enterprise software companies and end users. </p>
				<p class="is-style-default"
					id="membership">Kasten by Veeam and Volcano Engine joined or upgraded to Platinum in 2020. Cox Communications, HCL Technologies, Hewlett Packard Enterprise, Intuit, SPD Bank, and T-Mobile all joined or upgraded to Gold in 2020. </p>
				<p class="is-style-default"
					id="membership">Investment from these leading organizations signifies a strong dedication to the advancement and sustainability of cloud native computing for years to come.</p>
			</div>
			<div class="wp-block-column is-vertically-aligned-top"
				style="flex-basis:45%">
				<div class="wp-block-image">
					<figure class="alignright size-full is-resized"><img
							loading="lazy"
							src="<?php echo esc_url( get_template_directory_uri() . '/images/annual-reports/2020/CNCF-Annual-Report-2020-graphics-03-1.svg' ); ?>"
							alt="CNCF Membership Growth" class="wp-image-59682"
							width="443" height="606"></figure>
				</div>
			</div>
		</div>
		<div style="height:60px" aria-hidden="true"
			class="wp-block-spacer is-style-60-responsive"></div>
		<h2 class="is-style-divider-line" id="end-user-community">End User
			Community
		</h2>
		<p
			class="is-style-max-width-900 has-header-3-font-size">CNCF prides itself on being an open source community driven by End Users. </p>
		<p
			class="is-style-default">End users are defined as companies that use cloud native technologies internally but do not sell any cloud native services externally. Companies that meet this definition are eligible to join the <a href="https://www.cncf.io/people/end-user-community/">End User Community</a>.&nbsp;</p>
		<p
			class="is-style-default">Our End User Community grew to over 145 members in 2020, indicating strong, continued interest in cloud native technologies. At present, the CNCF End User Community is the largest of any open source foundation.</p>
		<p
			class="is-style-default">The End User Community meets regularly and advises the CNCF Governing Board and Technical Oversight Committee (TOC) members on key challenges, emerging use cases, and areas of opportunity and new growth for cloud native technologies. End Users are also an important source for CNCF projects including Prometheus, Envoy, Argo, and Backstage.</p>
		<p
			class="is-style-default">A respondent of the <a href="https://github.com/cncf/surveys/tree/master/enduser/2020">2020 survey</a> commented that they “enjoy hearing other organizations discuss their experience implementing different flavors of the open source projects/software products. As we begin to mature our K8s offering, those conversations are very beneficial. Continue connecting end users and advocating for knowledge sharing and collaboration.” Among respondents, 100% would recommend CNCF to other companies, and <strong>the average satisfaction rating was 4.47 out of 5 (89%), up from 4.16 out of 5 in 2019 (83%)</strong>.&nbsp;</p>
		<p
			class="is-style-default">If you are using CNCF projects and meet the definition of an End User, we urge you to join our <a href="https://www.cncf.io/people/end-user-community/">End User Community</a> so you can participate in this influential group and provide your insights both to fellow end users and to the CNCF community as a whole. If you join, we are confident you will also learn from other end users who are deploying CNCF projects, praised as “a great way to share information between companies.”&nbsp;</p>
		<div style="height:40px" aria-hidden="true"
			class="wp-block-spacer is-style-40-responsive"></div>
		<figure class="wp-block-image alignwide size-large"><img loading="lazy"
				width="772" height="281"
				src="<?php echo esc_url( get_template_directory_uri() . '/images/annual-reports/2020/CNCF-Annual-Report-2020-graphics-04-1.svg' ); ?>"
				alt="End User Survey Results 2020" class="wp-image-59683">
		</figure>
		<div style="height:80px" aria-hidden="true"
			class="wp-block-spacer is-style-80-responsive"></div>
		<div class="wp-block-columns is-style-equal-height-responsive">
			<div class="wp-block-column" style="flex-basis:60%">
				<h4 id="end-user-cncf-projects">End Users and Technical
					Oversight
					Committee</h4>
				<p>During 2020 the number of End User representatives on the TOC doubled from 1 to 2, with representatives from Apple, Spotify, Intuit, and American Express. </p>
				<p>Dave Zolotusky from Spotify joined as the new TOC End User Representative from Spotify. &nbsp;This highlights the importance of End Users to the cloud native community.</p>
				<h4 id="end-user-projects">End User Projects</h4>
				<p>2020 has been a successful year for End User-xdriven projects. Envoy, Jaeger, Prometheus, TUF, and Vitess all continued to grow as graduated projects. Argo and Thanos moved from Sandbox to Incubating.&nbsp;At the Sandbox level <a href="http://backstage.io/">backstage.io</a> and OpenKruise also joined CNCF.</p>
				<h4 id="end-users-kubecon">End Users and KubeCon +
					CloudNativeCon</h4>
				<p>45% of attendees and 31% of talks came from end user companies, an increase of 10% from KubeCon CloudNativeCon NA 2019! 12% of attendees came solely from the End User Community, exceeding the goal of 10%. Our keynotes featured <a href="https://www.youtube.com/watch?v=Tx8qXC-U3KM">The Cloud Native Journey @Apple</a>, an incredible landmark for how far this community has come.</p>
			</div>
			<div class="wp-block-column" style="flex-basis:40%">
				<figure class="wp-block-image size-full"><img loading="lazy"
						width="407" height="573"
						src="<?php echo esc_url( get_template_directory_uri() . '/images/annual-reports/2020/CNCF-Annual-Report-2020-graphics-05.svg' ); ?>"
						alt="" class="wp-image-59572"></figure>
			</div>
		</div>
		<div style="height:80px" aria-hidden="true"
			class="wp-block-spacer is-style-80-responsive"></div>
		<h3 id="end-user-tech-radar">CNCF End User Technology Radar</h3>
		<div class="wp-block-columns is-style-equal-height-responsive">
			<div class="wp-block-column" style="flex-basis:60%">
				<p class="is-style-max-width-100"
					id="end-user-tech-radar">In June 2020, CNCF launched the <a href="https://radar.cncf.io/">End User Technology Radar</a>, a quarterly report on a single topic in cloud native. It is aimed at a technical audience who want to understand what cloud native solutions end users use and recommend.</p>
				<p
					class="is-style-max-width-100">For each report CNCF surveyed the CNCF End User Community and asked them to place solutions at one of three levels:</p>
				<ul>
					<li><strong>Adopt:</strong> The CNCF End User Community can
						clearly
						recommend this technology. We have used it for long
						periods of
						time in many teams, and it has proven to be stable and
						useful.
					</li>
					<li><strong>Trial:</strong> The CNCF End User Community has
						used it
						with success, and we recommend you have a closer look at
						the
						technology.</li>
					<li><strong>Assess:</strong> The CNCF End User Community has
						tried
						it out, and we find it promising. We recommend having a
						look at
						these items when you face a specific need for the
						technology in
						your project.</li>
				</ul>
				<p
					class="is-style-max-width-100">The first three End User Tech Radars explored <a href="https://radar.cncf.io/2020-06-continuous-delivery">Continuous Delivery</a>, <a href="https://radar.cncf.io/2020-09-observability">Observability</a>, and <a href="https://radar.cncf.io/2020-11-database-storage">Database Storage</a>. End users appreciated that “Tech radars provide clear data points that are easy to consume. It has worked very well in the community so far and we are happy to participate in it.”. The Tech Radars received significant press and analyst coverage including The New Stack (<a href="https://thenewstack.io/how-the-cncfs-radar-shows-reality/">here</a> and <a href="https://thenewstack.io/the-new-stack-context-the-cncf-technology-radar-evaluates-observability-tools/">here</a>), <a href="https://www.infoq.com/news/2020/09/cncf-observability-radar/">InfoQ</a>, <a href="https://devclass.com/2020/06/15/cncf-tech-radar-continuous-delivery/">DevClass</a>, <a href="https://containerjournal.com/topics/container-management/open-source-prevails-in-monitoring-cncf-finds/">Container Journal</a>, and <a href="https://siliconangle.com/2020/08/18/end-users-developers-collaborate-cloud-native-container-security-solutions-kubecon/">SiliconANGLE</a>.&nbsp;</p>
			</div>
			<div class="wp-block-column" style="flex-basis:40%">
				<figure class="wp-block-image size-full"><img loading="lazy"
						width="361" height="545"
						src="<?php echo esc_url( get_template_directory_uri() . '/images/annual-reports/2020/CNCF-Annual-Report-2020-graphics-06.svg' ); ?>"
						alt="" class="wp-image-59594"></figure>
			</div>
		</div>
		<div style="height:80px" aria-hidden="true"
			class="wp-block-spacer is-style-80-responsive"></div>
		<h3 id="end-user-benefits">End User Training Benefits (Launching January
			2021)
		</h3>
		<p
			class="is-style-default">One of the biggest concerns for organizations as they transition over to new architectures is the successful adoption and implementation of cloud native technologies.&nbsp; According to the <a href="https://www.cncf.io/cncf-cloud-native-survey-2020">CNCF’s Cloud Native Survey 2020</a>, 27% of respondents indicated a lack of training was one of the biggest challenges in deploying containers.</p>
		<p
			class="is-style-default">As a result, CNCF and The Linux Foundation are pleased to announce new training benefits for the CNCF End User Community.</p>
		<ul class="is-style-max-width-700">
			<li>Our End User Supporters will receive five 100% off coupon codes
				– a
				value of up to $2,500 – for any eLearning class, certification
				exam, or
				eLearning + Certification exam “bundle” in the Training and
				Certification Catalog.&nbsp;</li>
			<li>Our End User Members will receive a 15-Seat Starter Pack
				Subscription to
				eLearning and certification – a $7,500 value. This means that 15
				employees will be able to tap into unlimited access to the
				entire
				eLearning catalog and one certification exam for one year.&nbsp;
			</li>
		</ul>
		<div style="height:80px" aria-hidden="true"
			class="wp-block-spacer is-style-80-responsive"></div>
		<h3 id="end-user-case-studies">End User Case Studies</h3>
		<div class="wp-block-columns is-style-equal-height-responsive">
			<div class="wp-block-column" style="flex-basis:70%">
				<p>In 2020, we published 17 <a href="https://www.cncf.io/case-studies/">case studies</a> about a diverse group of end users, spanning the U.S., U.K., India, China, Sweden, El Salvador, Brazil, and Japan, and in industries ranging from software (Zendesk) and telecom (Vodafone) to travel (Booking.com) and government (U.S. Department of Defense). </p>
				<p>These end users shared their learnings to benefit the community and help accelerate the adoption of cloud native technologies around the world. </p>
				<p>The majority of the published case studies involved organizations that are using multiple CNCF projects in tandem, including not only Kubernetes, but also Fluentd, Prometheus, Envoy, Helm, Jaeger, NATS, Falco, Argo, Harbor, CoreDNS, etcd, gRPC, and Open Policy Agent.&nbsp;</p>
			</div>
			<div class="wp-block-column" style="flex-basis:30%">
				<figure class="wp-block-image size-full"><img loading="lazy"
						width="753" height="1020"
						src="<?php echo esc_url( get_template_directory_uri() . '/images/annual-reports/2020/CNCF-Annual-Report-2020-graphics-07-1.jpg' ); ?>"
						alt="End user case studies"></figure>
			</div>
		</div>
		<div style="height:40px" aria-hidden="true"
			class="wp-block-spacer is-style-40-responsive"></div>
		<h3 id="conferences">Conferences and Events</h3>
		<p
			class="is-style-default">CNCF put on its first virtual KubeCon + CloudNativeCon conferences in both <a href="https://events.linuxfoundation.org/wp-content/uploads/2020/09/KubeCon_EU_20_Report_final.pdf">Europe</a> (August 17-20) and <a href="https://events.linuxfoundation.org/kubecon-cloudnativecon-north-america/">North America</a> (November 17-20) and reached a record-breaking combined 41,000+ registrants with a 70% attendance rate each! Of this year’s registrants, 72% were first-time attendees at KubeCon + CloudNativeCon Europe and 67% at North America, an indication of rising interest and healthy ecosystem growth.&nbsp;</p>
		<p
			class="is-style-default">At each event, attendees had access – both live and on-demand – to over 215 sessions, including keynotes, breakout sessions, tutorials, maintainer track sessions, and the expanded 101 track sessions.&nbsp;</p>
		<figure class="wp-block-image size-full is-resized"><img
				src="<?php echo esc_url( get_template_directory_uri() . '/images/annual-reports/2020/CNCF-Annual-Report-2020-graphics-08.svg' ); ?>"
				alt="Industry and Job Function that attended KubeCon NA 2020"
				width="1000"></figure>
		<p
			class="is-style-default">While the pandemic limited our in-person interaction, going virtual allowed CNCF to massively increase its conference reach. North America attendance increased 90% over the prior year’s in-person KubeCon + CloudNativeCon North America event in San Diego. </p>
		<p
			class="is-style-default">The CNCF issued a <a href="<?php echo esc_url( get_template_directory_uri() . '/images/annual-reports/2020/KubeCon_NA_20_Virtual_Report.pdf' ); ?>">Transparency Report</a> to recap the event; the report included detailed data covering attendee demographics, attendee and speaker diversity, and attendee sentiment on their conference experience. The Transparency Report for <a href="<?php echo esc_url( get_template_directory_uri() . '/images/annual-reports/2020/KubeCon_CloudNativeCon_EU_2020_Post-Event-Report.pdf' ); ?>">KubeCon + CloudNativeCon Europe</a> is also available for 2020. The overall satisfaction scores from attendees were 87% for EU and 90% for NA.</p>
		<div style="height:80px" aria-hidden="true"
			class="wp-block-spacer is-style-80-responsive"></div>
		<h3 id="wellness">Wellness Activities&nbsp;</h3>
		<p
			class="is-style-default">We encouraged attendees to “Keep Cloud Native Well” at both KubeCon + CloudNativeCon Virtual events this year.&nbsp; While CNCF makes every effort to ensure the comfort, health, and happiness of KubeCon + CloudNativeCon attendees, there may still be some attendees who feel overwhelmed by the amount of information or from having to stay home while often being secluded from friends, family, and their usual activities.&nbsp;</p>
		<p
			class="is-style-default">For our 2020 events, we provided options for attendees to get active, watch some fuzzy friends, and discuss wellness. Activities included:</p>
		<ul class="is-style-max-width-800">
			<li>Session: Stress &amp; Mental Health in Technology, Dr. Jennifer
				Akullian, Founder | Psychologist, Growth Coaching Institute</li>
			<li>Access to <a
					href="<?php echo esc_url( get_template_directory_uri() . '/images/annual-reports/2020/OSMI-Handbook_KCCNCNA20_FINAL.pdf' ); ?>">Open
					Sourcing Mental Illness (OSMI) handbook</a> (available at
				NA)&nbsp;
			</li>
			<li>On-demand desk stretching</li>
			<li>On-demand desk yoga</li>
			<li>On-demand desktop meditation</li>
			<li>Live online puppy + kitty cams</li>
			<li>Keep Cloud Native Well Slack channel for conversations</li>
		</ul>
		<div style="height:40px" aria-hidden="true"
			class="wp-block-spacer is-style-40-responsive"></div>
		<h2 class="is-style-divider-line" id="training">Training and
			Certification</h2>
		<p
			class="is-style-max-width-100 has-header-3-font-size">CNCF’s training and certification program continued to grow this year. </p>
		<p>In 2020, these training courses and exams received considerable interest:</p>
		<ul>
			<li><a href="https://www.cncf.io/certification/training/">Kubernetes
					Massively Open Online Course (MOOC)</a> hit 165,000
				enrollments (65%
				increase from 2019).&nbsp;</li>
			<li><a href="https://www.cncf.io/certification/expert/">Certified
					Kubernetes
					Administrator (CKA) exam</a> hit 37,000 enrollments (121%
				increase
				from 2019).</li>
			<li><a href="https://www.cncf.io/certification/ckad/">Certified
					Kubernetes
					Application Developer (CKAD)</a> hit 18,300 exam
				registrations (143%
				increase from 2019).&nbsp;</li>
			<li><a href="https://www.cncf.io/certification/kcsp/">Kubernetes
					Certified
					Service Provider (KCSP)</a> program reached 179
				certifications in
				2020 (38% increase from 2019).</li>
			<li><a href="https://www.cncf.io/certification/training/">Kubernetes
					Training Partner (KTP)</a> program grew to 50 certified
				companies
				(40% increase from 2019).</li>
		</ul>
		<p
			class="is-style-default">In November 2020, CNCF launched the <a href="https://www.cncf.io/certification/cks/">Certified Kubernetes Security Specialist (CKS)</a> exam. This exam will provide assurance that a certificant has the skills, knowledge, and competence on a broad range of best practices for securing container-based applications and Kubernetes platforms during build, deployment, and runtime.</p>
		<p>Other courses that CNCF funded in 2020 include:</p>
		<ul>
			<li><a
					href="https://training.linuxfoundation.org/announcements/service-mesh-fundamentals-training-course-now-available/">Service
					Mesh Fundamentals</a>&nbsp;&nbsp;</li>
			<li><a
					href="https://training.linuxfoundation.org/announcements/new-training-course-teaches-kubernetes-application-management-with-helm/">Managing
					Kubernetes Applications with Helm</a></li>
			<li><a
					href="https://training.linuxfoundation.jp/training/cloud-native-logging-with-fluentd-lfs242/">Cloud
					Native Logging with Fluent</a></li>
			<li><a
					href="https://www.edx.org/course/introduction-to-service-mesh-with-linkerd">Intro
					to Service Mesh with Linkerd</a>&nbsp;&nbsp;</li>
			<li><a
					href="https://www.edx.org/course/introduction-to-serverless-on-kubernetes">Intro
					to Serverless on Kubernetes</a></li>
		</ul>
		<figure class="wp-block-image size-large is-resized"><img loading="lazy"
				src="<?php echo esc_url( get_template_directory_uri() . '/images/annual-reports/2020/CNCF-Annual-Report-2020-graphics-10-1.svg' ); ?>"
				alt="Kubernetes Training" class="wp-image-59684" width="500"
				height="NaN"></figure>
		<div style="height:40px" aria-hidden="true"
			class="wp-block-spacer is-style-40-responsive"></div>
		<h2 class="is-style-divider-line" id="project-updates">Project Updates
			and
			Satisfaction</h2>
		<p
			class="is-style-max-width-800 has-header-3-font-size">In 2020, CNCF-hosted projects Helm, Harbor, TikV, Rook, and etcd advanced to “graduated” status, for a total of 14 projects. </p>
		<p
			class="is-style-default">During 2020, Argo, Contour, and Operator Framework joined at the incubating level. Buildpacks, Cortex, Dragonfly, Falco, KubeEdge, SPIFFE/SPIRE, and Thanos joined our 20 incubating projects from the Sandbox level.&nbsp;</p>
		<h3 id="project-maturity-levels">Project Maturity Levels</h3>
		<p
			class="is-style-default">CNCF projects are classified by maturity level, ranging from sandbox to incubating to graduated. CNCF uses these maturity levels to indicate to enterprises the degree of project readiness for enterprise adoption. </p>
		<figure class="wp-block-image size-large is-resized"><img loading="lazy"
				src="<?php echo esc_url( get_template_directory_uri() . '/images/annual-reports/2020/CNCF-Annual-Report-2020-graphics-11.svg' ); ?>"
				alt="Project Maturity Levels" class="wp-image-59597" width="500"
				height="NaN"></figure>
		<p
			class="is-style-default">Graduated projects are suitable for the vast majority of enterprises. Incubating projects are suitable for early adopters, and sandbox projects are suitable for innovators. Projects increase their maturity level by demonstrating to the TOC that they have attained end user and vendor adoption, established a healthy rate of code commits and codebase changes, and attracted committers from multiple organizations. </p>
		<figure class="wp-block-image size-large is-resized"><img loading="lazy"
				src="<?php echo esc_url( get_template_directory_uri() . '/images/annual-reports/2020/CNCF-Annual-Report-2020-graphics-12.svg' ); ?>"
				alt="Project Stats 2020" class="wp-image-59598" width="500">
		</figure>
		<p
			class="is-style-default">All projects must adopt the CNCF <a href="https://github.com/cncf/foundation/blob/master/code-of-conduct.md">Code of Conduct</a> and commit to earning the Core Infrastructure Initiative <a href="https://bestpractices.coreinfrastructure.org/">Best Practices Badge</a> in order to become an accepted CNCF project. Full details are listed in <a href="https://github.com/cncf/toc/blob/master/process/graduation_criteria.adoc">Graduation Criteria v1.1</a>.</p>
		<p>In 2020 the <a href="https://github.com/cncf/toc">CNCF TOC</a> accepted 35 new projects:</p>
		<figure class="wp-block-image alignwide size-full"><img loading="lazy"
				width="2200" height="1700"
				src="<?php echo esc_url( get_template_directory_uri() . '/images/annual-reports/2020/CNCF-Annual-Report-2020-graphics16.jpg' ); ?>"
				alt="35 new projects accepted in 2020"></figure>
		<div style="height:80px" aria-hidden="true"
			class="wp-block-spacer is-style-80-responsive"></div>
		<h3 id="project-maintainer-survey">CNCF Project Maintainer Survey
			Results</h3>
		<div class="wp-block-columns is-style-equal-height-responsive">
			<div class="wp-block-column" style="flex-basis:45%">
				<p class="is-style-max-width-100"
					id="project-maintainer-survey">CNCF conducts a survey of our project maintainers twice a year. The overall satisfaction with CNCF increased in 2020, with an improved satisfaction rating on staff responsiveness. There was a 98% maintainer response rate across projects, and the super majority of maintainers recommended CNCF as a place to host an open source project.&nbsp;</p>
			</div>
			<div class="wp-block-column" style="flex-basis:65%">
				<figure class="wp-block-image size-large is-resized"><img
						loading="lazy"
						src="<?php echo esc_url( get_template_directory_uri() . '/images/annual-reports/2020/CNCF-Annual-Report-2020-graphics-13.svg' ); ?>"
						alt="Project Maintainer Survey Results"
						class="wp-image-59599" width="691" height="182">
				</figure>
			</div>
		</div>
		<div style="height:80px" aria-hidden="true"
			class="wp-block-spacer is-style-80-responsive"></div>
		<h3 id="project-updates">Project Updates&nbsp;</h3>
		<figure class="wp-block-image alignwide size-full"><img loading="lazy"
				width="2560" height="1083"
				src="<?php echo esc_url( get_template_directory_uri() . '/images/annual-reports/2020/CNCF-Annual-Report-2020-graphicsNEW-03-scaled.jpg' ); ?>"
				alt="Project updates" class="wp-image-59691"></figure>
		<p>Many incubation and graduation moves demonstrated steady forward progress for each of these projects:&nbsp;</p>
		<ul>
			<li>Graduations:<ul>
					<li><a
							href="https://www.cncf.io/announcements/2020/04/30/cloud-native-computing-foundation-announces-helm-graduation/">Helm</a>
					</li>
					<li><a
							href="https://www.cncf.io/announcements/2020/06/23/cloud-native-computing-foundation-announces-harbor-graduation/">Harbor</a>
					</li>
					<li><a
							href="https://www.cncf.io/announcements/2020/09/02/cloud-native-computing-foundation-announces-tikv-graduation/">TiKV</a>
					</li>
					<li><a
							href="https://www.cncf.io/announcements/2020/10/07/cloud-native-computing-foundation-announces-rook-graduation/">Rook</a>
					</li>
					<li><a
							href="https://www.cncf.io/announcements/2020/11/24/cloud-native-computing-foundation-announces-etcd-graduation/">Etcd</a>
					</li>
				</ul>
			</li>
			<li>Joined at the Incubation level of moved from Sandbox to
				Incubation:<ul>
					<li><a
							href="https://www.cncf.io/blog/2020/01/08/toc-votes-to-move-falco-into-cncf-incubator/">Falco</a>
					</li>
					<li><a
							href="https://www.cncf.io/blog/2020/04/07/toc-welcomes-argo-into-the-cncf-incubator/">Argo</a>
					</li>
					<li><a
							href="https://www.cncf.io/blog/2020/04/09/toc-votes-to-move-dragonfly-into-cncf-incubator/">Dragonfly</a>
					</li>
					<li><a
							href="https://www.cncf.io/blog/2020/06/22/toc-approves-spiffe-and-spire-to-incubation/">SPIRE</a>
					</li>
					<li><a
							href="https://www.cncf.io/blog/2020/06/22/toc-approves-spiffe-and-spire-to-incubation/">SPIFFE</a>
					</li>
					<li><a
							href="https://www.cncf.io/blog/2020/07/07/toc-accepts-contour-as-incubating-project/">Contour</a>
					</li>
					<li><a
							href="https://www.cncf.io/blog/2020/07/09/toc-approves-operator-framework-as-incubating-project/">Operator
							Framework</a></li>
					<li><a
							href="https://www.cncf.io/blog/2020/08/19/toc-approves-thanos-from-sandbox-to-incubation/">Thanos</a>
					</li>
					<li><a
							href="https://www.cncf.io/blog/2020/08/20/toc-welcomes-cortex-as-an-incubating-project/">Cortex</a>
					</li>
					<li><a
							href="https://www.cncf.io/blog/2020/09/16/toc-approves-kubeedge-as-incubating-project/">KubeEdge</a>
					</li>
					<li><a
							href="https://www.cncf.io/blog/2020/11/18/toc-approves-cloud-native-buildpacks-from-sandbox-to-incubation/">Buildpacks</a>
					</li>
				</ul>
			</li>
		</ul>
		<div style="height:80px" aria-hidden="true"
			class="wp-block-spacer is-style-80-responsive"></div>
		<h3 id="services-assistance-projects">Services and Assistance for
			Projects&nbsp;
		</h3>
		<p>CNCF provides a variety of <a href="https://github.com/cncf/servicedesk">services</a> to our projects to help make them more successful and sustainable.</p>
		<div class="wp-block-columns is-style-equal-height-responsive">
			<div class="wp-block-column" style="flex-basis:60%">
				<p><strong>Events</strong></p>
				<p>CNCF continues to invest in CNCF-hosted projects by assisting with their own specialized events. These may be in conjunction with KubeCon + CloudNativeCon or standalone conferences.</p>
				<p>CNCF Hosted – Co-located with KubeCon + CloudNativeCon:</p>
				<ul>
					<li><a
							href="https://events.linuxfoundation.org/cloud-native-security-day/">Cloud
							Native Security Day Europe</a> | 890 registered
						attendees
					</li>
					<li><a
							href="https://events.linuxfoundation.org/serverless-practitioners-summit/">Serverless
							Practitioners Summit Europe</a> | 496 registered
						attendees
					</li>
					<li><a
							href="https://events.linuxfoundation.org/servicemeshcon/">ServiceMeshCon
							Europe</a> | 891 registered attendees</li>
					<li><a
							href="https://events.linuxfoundation.org/cloud-native-security-day-north-america/">Cloud
							Native Security Day North America</a> | 1,606
						registered
						attendees</li>
					<li><a
							href="https://events.linuxfoundation.org/open-telemetry-community-day/">OpenTelemetry
							Community Day North America</a> | 913 registered
						attendees&nbsp;</li>
					<li><a
							href="https://events.linuxfoundation.org/production-identity-day/">Production
							Identity Day: SPIFFE + SPIRE North America </a>| 515
						registered attendees&nbsp;</li>
					<li><a
							href="https://events.linuxfoundation.org/servicemeshcon-north-america/">ServiceMeshCon
							North America</a> | 1,803 registered attendees</li>
				</ul>
				<p><br>CNCF Hosted – Standalone</p>
				<ul>
					<li><a
							href="https://events.linuxfoundation.org/kubernetes-forum-bengaluru/">Kubernetes
							Forum Bengaluru</a> (in-person) | 2121 registered
						attendees
					</li>
					<li><a
							href="https://events.linuxfoundation.org/kubernetes-forum-delhi/">Kubernetes
							Forum Delhi</a> (in-person) | 985 registered
						attendees</li>
					<li><a
							href="https://events.linuxfoundation.org/grpc-conf/">gRPConf</a>
						| 506 registered attendees</li>
					<li><a href="https://promcon.io/2020-online/">PromCon 2020
							Virtual</a> | 744 registered attendees&nbsp;</li>
					<li><a href="https://events.linuxfoundation.org/envoycon/">EnvoyCon
							2020 Virtual</a> | 417 registered attendees</li>
					<li><a
							href="https://events.linuxfoundation.org/helm-v3-workshop/">Helm
							Workshop: v2 to v3</a> | 306 registered attendees
					</li>
				</ul>
			</div>
			<div class="wp-block-column" style="flex-basis:40%">
				<figure class="wp-block-image size-large is-resized"><img
						loading="lazy"
						src="<?php echo esc_url( get_template_directory_uri() . '/images/annual-reports/2020/CNCF-Annual-Report-2020-graphics-events-862x1024.jpg' ); ?>"
						alt="CNCF Event Logos" class="wp-image-59756"
						width="448" height="531"></figure>
			</div>
		</div>
		<div style="height:81px" aria-hidden="true"
			class="wp-block-spacer is-style-80-responsive"></div>
		<h3 id="documentation">Documentation, Websites, and Blog Posts</h3>
		<div class="wp-block-columns is-style-equal-height-responsive">
			<div class="wp-block-column" style="flex-basis:60%">
				<ul>
					<li>We issued a series of project journey reports for CNCF
						graduated
						projects, including <a
							href="https://www.cncf.io/cncf-containerd-project-journey/">containerd</a>,
						<a
							href="https://www.cncf.io/cncf-fluentd-project-journey/">Fluentd</a>,
						<a
							href="https://www.cncf.io/cncf-helm-project-journey-report/">Helm</a>,
						and <a
							href="https://www.cncf.io/cncf-jaeger-project-journey-report/">Jaeger</a>.
					</li>
					<li>296 blog posts were published in 2020, with a blog
						readership of
						448,493 (21% higher than 2018).&nbsp;</li>
					<li>Top blog posts for 2020:<ul>
							<li><a
									href="https://www.cncf.io/blog/2020/10/29/kubernetes-1-19-the-future-of-traffic-ingress-and-routing/">Kubernetes
									1.19: The future of traffic ingress and
									routing</a>
								(eficode) (23,171 views)</li>
							<li><a
									href="https://www.cncf.io/blog/2020/03/06/the-difference-between-api-gateways-and-service-mesh/">The
									difference between API Gateways and Service
									Mesh</a>
								(Kong) (15,871 views)</li>
							<li><a
									href="https://www.cncf.io/blog/2020/07/27/logging-in-kubernetes-efk-vs-plg-stack/">Logging
									in Kubernetes: EFK vs PLG Stack</a> (MSys
								Technologies) (14,674 views)</li>
							<li><a
									href="https://www.cncf.io/blog/2019/11/04/building-a-large-scale-distributed-storage-system-based-on-raft/">Building
									a Large-scale Distributed Storage System
									Based on
									Raft</a> (InfraCloud) (12,976 page views)
							</li>
							<li><a
									href="https://www.cncf.io/blog/2019/01/14/9-kubernetes-security-best-practices-everyone-must-follow/">9
									Kubernetes security best practices everyone
									must
									follow</a> (StackRox) (11,012 page views)
							</li>
						</ul>
					</li>
					<li>We rebuilt the CNCF website from scratch to accomplish
						the
						following goals:<ul>
							<li>Improve the speed of the site, both for browsing
								and
								editing content</li>
							<li>Automate the administration of the site to make
								it
								easier to maintain and keep up-to-date</li>
							<li>Modernize the development process and codebase
								to
								facilitate ongoing improvements</li>
							<li>Improve accessibility</li>
							<li>Modernize the design</li>
						</ul>
					</li>
					<li>We added a <a
							href="https://www.cncf.io/spotlights/">Community
							Spotlights</a> content type to highlight
						contributions from
						the community,&nbsp;including CNCF ambassadors Paolo
						Simoes and
						Queeny Jin, community leaders Paris Pittman and Liz
						Rice, and
						project maintainers Torin Sandall and Goutham
						Veeramachaneni
					</li>
					<li>Some projects got brand new websites courtesy of CNCF in
						2020:
						<ul>
							<li><a href="https://dexidp.io/">Dex IDP</a></li>
							<li><a href="https://longhorn.io/">Longhorn</a></li>
							<li><a href="https://in-toto.io">In-toto</a></li>
							<li><a href="https://cni.dev">CNI</a></li>
							<li><a href="https://keda.sh/">Keda</a></li>
						</ul>
					</li>
					<li>Other projects got major documentation/web presence
						upgrades:
						<ul>
							<li><a href="https://grpc.io">gRPC</a></li>
							<li><a href="https://vitess.io">Vitess</a></li>
							<li><a href="https://serverlessworkflow.org/">Serverless
									Workflow</a></li>
						</ul>
					</li>
				</ul>
			</div>
			<div class="wp-block-column" style="flex-basis:40%">
				<figure class="wp-block-image size-full is-resized"><img
						loading="lazy"
						src="<?php echo esc_url( get_template_directory_uri() . '/images/annual-reports/2020/CNCF-Annual-Report-2020-graphics-15.jpg' ); ?>"
						alt="Web page example showing community spotlight"
						class="wp-image-59603" width="464" height="639">
				</figure>
			</div>
		</div>
		<div style="height:80px" aria-hidden="true"
			class="wp-block-spacer is-style-80-responsive"></div>
		<h3 id="service-desk">CNCF Service Desk</h3>
		<p
			class="is-style-max-width-100">To improve access to activities and services that CNCF offers to its hosted projects, the <a href="http://servicedesk.cncf.io">CNCF Service Desk</a> serves as a single access point for all CNCF services. If you’re a CNCF project&nbsp;maintainer, all you have to do is visit <a href="http://servicedesk.cncf.io/">http://servicedesk.cncf.io</a> to request support.&nbsp;</p>
		<figure class="wp-block-image alignwide size-large"><img loading="lazy"
				width="450" height="224"
				src="<?php echo esc_url( get_template_directory_uri() . '/images/annual-reports/2020/CNCF-Annual-Report-2020-graphics-16.svg' ); ?>"
				alt="Ticket status through 2020" class="wp-image-59627">
		</figure>
		<div style="height:40px" aria-hidden="true"
			class="wp-block-spacer is-style-40-responsive"></div>
		<h2 class="is-style-divider-line" id="community-engagement">Community
			Engagement
		</h2>
		<p
			class="is-style-max-width-800 has-header-3-font-size">The CNCF community spans the world across our contributors, members, meetups, and ambassadors.</p>
		<p
			class="is-style-default">CNCF continues to support the development of this incredible cloud native community while also striving to ensure that everyone who participates feels welcome regardless of gender, gender identity, sexual orientation, disability, race, ethnicity, age, religion, or economic status. </p>
		<p
			class="is-style-default">In 2020, women and gender non-conforming speakers made up 74% of the keynotes at <a href="https://events.linuxfoundation.org/kubecon-cloudnativecon-europe/">KubeCon + CloudNativeCon EU Virtual</a> and 52% at <a href="https://events.linuxfoundation.org/kubecon-cloudnativecon-north-america/">KubeCon + CloudNativeCon NA Virtual</a>. At our KubeCon + CloudNativeCon events, there were a number of activities designed to foster the diversity of the cloud native community, including: peer group mentoring and career networking, the EmpowerUs event, a Diversity &amp; Inclusion workshop, KubeCon + CloudNativeCon diversity and need-based scholarships and complimentary registration to CNCF hosted co-located events.&nbsp;</p>
		<p
			class="is-style-default">CNCF offered scholarships to 717 diversity applicants from traditionally underrepresented and/or marginalized groups and 185 need-based applicants in 2020.&nbsp; Scholarships and diversity programs were funded by sponsorships from Amazon Web Services, CarGurus, Cloud Native Computing Foundation, ITRenew, Legacy II Cloud, Palo Alto Networks, Two Sigma, and VMware.&nbsp;</p>
		<p
			class="is-style-default">Including the 2020 virtual events, CNCF has offered more than 2,300 diversity and need-based scholarships to attend KubeCon + CloudNativeCon and other CNCF hosted events over the course of its life.&nbsp;</p>
		<figure class="wp-block-image size-full"><img loading="lazy"
				width="2200" height="600"
				src="<?php echo esc_url( get_template_directory_uri() . '/images/annual-reports/2020/CNCF-Annual-Report-2020-graphicsNEWWW21.jpg' ); ?>"
				alt="727 diversity applications, 185 need-based scholarships"
				class="wp-image-59705"></figure>
		<div style="height:80px" aria-hidden="true"
			class="wp-block-spacer is-style-80-responsive"></div>
		<h3 id="community-awards">Community Awards</h3>
		<div class="wp-block-columns is-style-equal-height-responsive">
			<div class="wp-block-column" style="flex-basis:60%">
				<p>Now in their fifth year, the <a href="https://www.cncf.io/announcements/2020/11/20/cloud-native-computing-foundation-announces-2020-community-awards-winners/">CNCF Community Awards</a> highlighted the most active ambassador and top contributor across all CNCF projects. The awards included:</p>
				<ul>
					<li>Top Cloud Native Committer – an individual with
						incredible
						technical skills and notable technical achievements in
						one or
						multiple CNCF projects. The 2020 recipient was <a
							href="https://twitter.com/BenTheElder"><strong>Ben
								Elder</strong></a>.</li>
					<li>Top Cloud Native Ambassador – an individual with
						incredible
						community-oriented skills, focused on spreading the word
						and
						sharing knowledge with the entire cloud native community
						or
						within a specific project. The 2020 recipient was <a
							href="https://twitter.com/IanColdwater"><strong>Ian
								Coldwater</strong></a>.</li>
				</ul>
			</div>
			<div class="wp-block-column" style="flex-basis:40%">
				<figure class="wp-block-image size-full"><img loading="lazy"
						width="496" height="280"
						src="<?php echo esc_url( get_template_directory_uri() . '/images/annual-reports/2020/CNCF-Annual-Report-2020-graphics-17-2.jpg' ); ?>"
						alt="Community Award winners Ian Coldwater and Ben Elder">
				</figure>
			</div>
		</div>
		<p
			class="is-style-max-width-100">To recognize contributors who spend countless hours completing often mundane tasks, CNCF created the “<strong>Chop Wood and Carry Water”</strong> awards. CNCF was proud to acknowledge the amazing efforts of five individuals for their outstanding contributions in 2020: <a href="https://twitter.com/erinaboyd"><strong>Erin Boyd</strong></a><strong>, </strong><a href="https://twitter.com/fuzzychef"><strong>Josh Berkus</strong></a><strong>, </strong><a href="https://twitter.com/bridgetkromhout"><strong>Bridget Kromhout</strong></a><strong>, </strong><a href="https://twitter.com/bacongobbler"><strong>Matt Fisher</strong></a><strong>, and </strong><a href="https://twitter.com/TwitchiH"><strong>Richard Hartmann</strong></a><strong>.</strong></p>
		<figure class="wp-block-image size-full"><img loading="lazy"
				width="1270" height="280"
				src="<?php echo esc_url( get_template_directory_uri() . '/images/annual-reports/2020/CNCF-Annual-Report-2020-graphics-18-2.jpg' ); ?>"
				alt="Erin Boyd, Josh Berkus, Bridget Kromhout, Matt Fisher, and Richard Hartmann."
				class="wp-image-59699"></figure>
		<div style="height:40px" aria-hidden="true"
			class="wp-block-spacer is-style-40-responsive"></div>
		<p
			class="is-style-default">We also celebrate the contributions that end users make to our ecosystem, including providing upstream contributions to projects, creating and maintaining open source projects to expand the ecosystem, and providing significant insights into successes and failures. We were thrilled to grant our <a href="https://www.cncf.io/announcements/2020/08/20/cloud-native-computing-foundation-grants-zalando-the-top-end-user-award/#:~:text=%E2%80%93%20August%2020%2C%202020%20%E2%80%93%20The,contributions%20to%20the%20cloud%20native">Top End User Award to Zalando</a> in recognition of its notable contributions to the cloud native ecosystem, including chairing the CNCF Developer Experience SIG.</p>
		<figure class="wp-block-image size-full is-resized"><img loading="lazy"
				src="<?php echo esc_url( get_template_directory_uri() . '/images/annual-reports/2020/CNCF-Annual-Report-2020-graphics-19.jpg' ); ?>"
				alt="Zalando CNCF Award Winner 2020" class="wp-image-59633"
				width="747" height="417"></figure>
		<div style="height:80px" aria-hidden="true"
			class="wp-block-spacer is-style-80-responsive"></div>
		<h3 id="meetups">CNCF Meetups and Community Groups</h3>
		<p
			class="is-style-max-width-100">In 2020, CNCF supported more than 194 <a href="https://meetups.cncf.io/">Meetup</a> groups in 53 countries, with greater than 158,000 members. In 2020, we experienced a nearly 10% increase in CNCF Meetup members.</p>
		<figure class="wp-block-image alignwide size-full"><img loading="lazy"
				width="589" height="328"
				src="<?php echo esc_url( get_template_directory_uri() . '/images/annual-reports/2020/CNCF-Annual-Report-2020-graphics-20-1.svg' ); ?>"
				alt="CNCF Meetup member growth" class="wp-image-59700"></figure>
		<p
			class="is-style-max-width-100">CNCF also kicked off the <a href="https://community.cncf.io/">Cloud Native Community Groups</a> program, which will supersede the Meetup program in the future, and will become a single hosting place for the Cloud Native community initiatives.&nbsp;</p>
		<div style="height:80px" aria-hidden="true"
			class="wp-block-spacer is-style-80-responsive"></div>
		<h3 id="kubernetes-community-days">Kubernetes Community Days Update</h3>
		<div class="wp-block-columns is-style-equal-height-responsive">
			<div class="wp-block-column" style="flex-basis:60%">
				<p>In response to the cloud native community’s evolving needs, CNCF launched the <a href="https://kubernetescommunitydays.org/">Kubernetes Community Days (KCD)</a> program in 2019. </p>
				<p>KCDs are community-organized events that gather adopters and technologists from open source and cloud native communities to learn, collaborate, and network. </p>
				<p>The goal of the events is to further the adoption and improvement of Kubernetes. </p>
				<p>Unfortunately, due to the COVID-19 pandemic, the 2020 KCD events were postponed. CNCF plans to reboot the program in 2021 with the option to run virtual events.</p>
				<p>For additional information about the program, please <a href="https://kubernetescommunitydays.org/">visit the homepage</a>.</p>
			</div>
			<div class="wp-block-column" style="flex-basis:40%">
				<figure class="wp-block-image size-large"><img loading="lazy"
						width="1024" height="874"
						src="<?php echo esc_url( get_template_directory_uri() . '/images/annual-reports/2020/CNCF-Annual-Report-2020-graphics-21-1024x874.jpg' ); ?>"
						alt="Audience at CNCF event" class="wp-image-59631">
				</figure>
			</div>
		</div>
		<div style="height:80px" aria-hidden="true"
			class="wp-block-spacer is-style-80-responsive"></div>
		<h3 id="cncf-ambassador">CNCF Ambassador Program&nbsp;</h3>
		<p
			class="is-style-default">Cloud Native Ambassadors (CNAs) are individuals who are passionate about Cloud Native Computing Foundation technology and projects, recognized for their expertise, and willing to help others learn about the framework and community. These individuals are bloggers, influencers, and evangelists. CNCF has 118 <a href="https://www.cncf.io/people/ambassadors/">CNCF Ambassadors</a> around the globe educating the world on cloud native technologies and best practices.</p>
		<p
			class="is-style-default">We accepted 22 new CNCF ambassadors and provided financial support for ambassador-run meetups in 2020. We are excited to have this worldwide group of people with diverse interests, experiences, and technical backgrounds help drive local and global cloud native communities. Please check out the <a href="https://www.cncf.io/spotlights/?_sft_lf-spotlight-type=ambassador">interviews</a> with several of our CNCF ambassadors from the Ambassador Spotlights section on the <a href="https://www.cncf.io/">CNCF homepage</a>.</p>
		<figure class="wp-block-image size-full"><img loading="lazy"
				width="2560" height="1297"
				src="<?php echo esc_url( get_template_directory_uri() . '/images/annual-reports/2020/CNCF-Annual-Report-2020-graphicsNEW-02-scaled.jpg' ); ?>"
				alt="New ambassadors for 2020" class="wp-image-59701"></figure>
		<div style="height:80px" aria-hidden="true"
			class="wp-block-spacer is-style-80-responsive"></div>
		<h3 id="community-mentoring">Community Mentoring and Internships</h3>
		<div class="wp-block-columns is-style-equal-height-responsive">
			<div class="wp-block-column" style="flex-basis:60%">
				<p>CNCF proudly supports various mentoring and internship opportunities including the <a href="https://lfx.linuxfoundation.org/">LFX</a> mentorship platform (previously known as Community Bridge), <a href="https://summerofcode.withgoogle.com/">Google Summer of Code (GSoC)</a>, <a href="https://developers.google.com/season-of-docs">Google Summer of Docs (GSoD)</a> program, and <a href="https://www.outreachy.org/">Outreachy</a>. These programs are important catalysts for internships to have an impact on future technologies that we all depend on.&nbsp;</p>
				<p>Students accepted into the GSoC program have the opportunity to work with a mentor and become part of an active open source community. CNCF hosted 20 interns in 2020 (16 of them have graduated) – our largest class ever. Mentors from our community paired with interns and worked with them to help improve CNCF projects. You can find further details <a href="https://www.cncf.io/blog/2020/09/17/16-cncf-interns-graduate-from-summer-of-code-gsoc-2020/">here</a>.<br><br>Also, 2020 was the first year that CNCF participated in the Google Season of Docs (GSoD) program. GSoD is a mentoring initiative for technical writers; this year the CNCF matched 4 writers with projects and mentors and provided administrative support.</p>
				<p>Recently launched by The Linux Foundation, <a href="https://lfx.linuxfoundation.org/tools/mentorship">LFX Mentorship</a> aims to sustain open source projects while providing paid opportunities for new developers to join and learn from open source communities. In 2020, CNCF sponsored 50 students during three mentoring cycles to work on 21 CNCF projects.</p>
				<p>In November 2020, CNCF partnered with The Linux Foundation and <a href="https://www.ncwit.org/">National Center for Women &amp; Information Technology (NCWIT)</a> to <a href="https://training.linuxfoundation.org/announcements/linux-foundation-and-ncwit-release-free-training-course-on-diversity-in-open-source/">launch a new training course</a>, <a href="https://training.linuxfoundation.org/training/inclusive-open-source-community-orientation-lfc102/">Inclusive Open Source Community Orientation</a>.&nbsp; This course is designed to provide essential background knowledge and practical skills to create an inclusive culture in the open source community.&nbsp;</p>
			</div>
			<div class="wp-block-column" style="flex-basis:40%">
				<figure class="wp-block-image size-full is-resized"><img
						src="<?php echo esc_url( get_template_directory_uri() . '/images/annual-reports/2020/CNCF-Annual-Report-2020-graphics-22-scaled.jpg' ); ?>"
						alt="Mentorships web page" class="wp-image-59630"
						width="500"></figure>
			</div>
		</div>
		<div style="height:80px" aria-hidden="true"
			class="wp-block-spacer is-style-80-responsive"></div>
		<h2 class="is-style-divider-line" id="ecosystem-tools">Ecosystem
			Tools&nbsp;
		</h2>
		<p
			class="is-style-default">CNCF provides various tools to support the cloud native ecosystem.</p>
		<h3 id="cncf-job-board">CNCF Job Board</h3>
		<p
			class="is-style-default">According to the <a href="https://training.linuxfoundation.org/resources/2020-open-source-jobs-report/">2020 Linux Foundation Open Source Jobs Report</a>, cloud and containers continue to grow in popularity and importance; 69% of hiring managers are currently seeking cloud and container expertise, up from 64% in 2018. In response to this demand, CNCF launched its official job board in 2019. Since then, the job board has listed over 1,000 jobs from 2,000+ employers. More than 2,600 job seekers have applied for a job via email or on the site.&nbsp;</p>
		<p
			class="is-style-default">The CNCF Job Board is an excellent resource to connect with the world’s top cloud native developers and hire strong candidates. The job board is a free service for both posters and applicants, and CNCF member job openings receive a featured listing. We invite you to post your job, search for candidates, or find your next employment opportunity <a href="https://jobs.cncf.io/">through the CNCF Job Board</a>.</p>
		<div style="height:80px" aria-hidden="true"
			class="wp-block-spacer is-style-80-responsive"></div>
		<h3 id="speakers-bureau">CNCF Speakers Bureau</h3>
		<p
			class="is-style-default">Launched in 2018, the <a href="https://www.cncf.io/speakers/">CNCF Speakers Bureau</a> helps connect event organizers with speakers who have varied expertise in the cloud native ecosystem. Speakers consist of CNCF ambassadors, meetup organizers, and prominent community members who are willing to speak at events on the topics they are proficient in.</p>
		<p
			class="is-style-default">In 2020, CNCF made some <a href="https://www.cncf.io/blog/2020/01/31/cncf-speakers-bureau-a-great-resource/">exciting updates</a> to the Speakers Bureau page, including the option for CNCF members to bulk email speakers and a powerful faceted search feature.</p>
		<div style="height:80px" aria-hidden="true"
			class="wp-block-spacer is-style-80-responsive"></div>
		<h3 id="devstats">DevStats</h3>
		<div class="wp-block-columns is-style-equal-height-responsive">
			<div class="wp-block-column" style="flex-basis:60%">
				<p
					class="is-style-max-width-100">In 2017, CNCF developed <a href="https://devstats.cncf.io/">DevStats</a>, a tool to visualize various developer and community metrics for Kubernetes and other CNCF-hosted projects, as well as non-CNCF open source projects hosted on a public GitHub repository. </p>
				<p
					class="is-style-max-width-100">DevStats organizes and displays CNCF-hosted project data using <a href="https://grafana.com/">Grafana</a> dashboards. In 2020, we added DevStats API support, so others can connect to DevStats’ APIs and request data programmatically.</p>
				<p
					class="is-style-max-width-100">CNCF developer Lukasz Gryglicki, the primary developer on DevStats, is responsive to suggestions and <a href="https://github.com/cncf/devstats">pull requests</a> that provide additional insights into the development of CNCF’s hosted projects.</p>
			</div>
			<div class="wp-block-column" style="flex-basis:40%">
				<figure class="wp-block-image size-large"><img loading="lazy"
						width="1024" height="736"
						src="<?php echo esc_url( get_template_directory_uri() . '/images/annual-reports/2020/CNCF-Annual-Report-2020-graphics-23-1024x736.jpg' ); ?>"
						alt="Devstats web page" class="wp-image-59629"></figure>
			</div>
		</div>
		<div style="height:80px" aria-hidden="true"
			class="wp-block-spacer is-style-80-responsive"></div>
		<h3 id="landscape">CNCF Landscape and Cloud Native Trail Map</h3>
		<p
			class="is-style-default">The CNCF Cloud Native <a href="https://landscape.cncf.io/">Landscape</a> has become the standard way of charting the myriad options in the cloud native ecosystem. The landscape started in November 2016 as a static image of fewer than 100 projects and products. In 2020, it has grown through the power of collaborative editing to track more than 1,500 projects, products, and companies and includes a <a href="https://landscape.cncf.io/format=serverless">serverless</a> landscape and the CNCF <a href="https://landscape.cncf.io/format=members">member</a> landscape. The project has nearly 7,000 stars on GitHub.</p>
		<p
			class="is-style-default">The Cloud Native <a href="https://landscape.cncf.io/">Landscape</a> 2.0 is an interactive version that allows viewers to filter, obtain detailed information on a specific project or technology, and easily share via stateful URLs. The landscape also captures funding and financing information for companies that are fostering and building businesses around cloud native technologies. The code used to generate the interactive landscape is open source with the data stored in a yaml <a href="https://github.com/cncf/landscape/blob/master/landscape.yml">file</a>. Every night, a server downloads updated GitHub data, financing information from Crunchbase, market cap data from Yahoo Finance, and CII <a href="https://bestpractices.coreinfrastructure.org/en">Best Practices Badge</a> information.&nbsp;</p>
		<p
			class="is-style-default">The Cloud Native Trailmap continues to show a path for organizations to adopt the graduated and incubating projects hosted by CNCF.</p>
		<figure class="wp-block-image size-full"><img loading="lazy"
				width="2389" height="926"
				src="<?php echo esc_url( get_template_directory_uri() . '/images/annual-reports/2020/CNCF-Annual-Report-2020-graphics-24-1.jpg' ); ?>"
				alt="CNCF Landscape and Trail Map" class="wp-image-59641">
		</figure>
		<div style="height:80px" aria-hidden="true"
			class="wp-block-spacer is-style-80-responsive"></div>
		<h3 id="open-source-security-audits">CNCF Open Source Security Audits
		</h3>
		<p
			class="is-style-default">In 2018, the CNCF began performing and open sourcing security audits for its projects to improve the security of our ecosystem. </p>
		<p
			class="is-style-default">The goal was to audit several projects and gather feedback from the CNCF community as to whether the pilot program was useful. The first projects to undergo this process were <a href="https://github.com/kubernetes/community/blob/master/wg-security-audit/findings/Kubernetes%20Final%20Report.pdf">Kubernetes</a>, <a href="https://coredns.io/2018/03/15/cure53-security-assessment/">CoreDNS</a>, and <a href="https://github.com/envoyproxy/envoy/blob/master/docs/SECURITY_AUDIT.pdf">Envoy</a>. In 2019, CNCF invested in security audits for Vitess, Jaeger, Fluentd, Linkerd, Falco, Harbor, gRPC, Helm, and Kubernetes, totaling approximately half a million dollars. These first public audits identified a variety of security issues, ranging from general weaknesses to critical vulnerabilities. Project maintainers for CoreDNS, Envoy, and Prometheus have addressed the identified vulnerabilities and added documentation to help users, thus improving the security of these projects.</p>
		<p
			class="is-style-default">With funds provided by the CNCF community to conduct the Kubernetes security audit, the <a href="https://github.com/kubernetes/community/tree/master/wg-security-audit">Security Audit Working Group</a> was formed to lead the process of finding a reputable third-party vendor. The group created an open request for proposals. The group took responsibility for evaluating the proposals and recommending the vendor best suited to complete a security assessment against Kubernetes, bearing in mind the project’s high complexity and broad scope.</p>
		<p
			class="is-style-default">This audit process was partially inspired by the <a href="https://bestpractices.coreinfrastructure.org/en">Core Infrastructure Initiative (CII) Best Practices Badge program</a> that all CNCF projects are required to complete. Provided by the Linux Foundation, this badge offers a clear and easy-to-understand way for open source projects to show that they follow security best practices. Adopters of open source software can use the badge to quickly assess which open source projects are following best practices, and as a result, are more likely to produce higher-quality, secure software.</p>
		<p
			class="is-style-max-width-100">Findings from the Kubernetes audit conducted over a few months revealed:</p>
		<ol>
			<li>Key security policies may not be applied, leading to a false
				sense of
				security.</li>
			<li>Insecure TLS is in use by default.</li>
			<li>Credentials are exposed in environment variables and
				command-line
				arguments.&nbsp;</li>
			<li>Names of secrets are leaked in logs.</li>
			<li>Kubernetes lacked certificate revocation.</li>
			<li>seccomp is not enabled by default.</li>
		</ol>
		<p
			class="is-style-default">By open sourcing security audits and processes, the working group hopes to inspire other projects to undertake similar efforts in their respective open source communities. Full findings and recommendations from the audits are listed <a href="https://www.cncf.io/blog/2019/08/06/open-sourcing-the-kubernetes-security-audit/">here</a>.</p>
		<figure class="wp-block-image size-full"><img loading="lazy"
				width="2560" height="1182"
				src="<?php echo esc_url( get_template_directory_uri() . '/images/annual-reports/2020/CNCF-Annual-Report-2020-graphicsNEW-01-scaled.jpg' ); ?>"
				alt="Nine CNCF-hosted Projects received security audits in 2020">
		</figure>
		<div style="height:40px" aria-hidden="true"
			class="wp-block-spacer is-style-40-responsive"></div>
		<h2 class="is-style-divider-line" id="china">Growth in China</h2>
		<div class="wp-block-columns is-style-equal-height-responsive">
			<div class="wp-block-column" style="flex-basis:60%">
				<p>CNCF continues to grow the cloud native community in China. CNCF’s first virtual event in China,&nbsp;<a href="https://cncf.lfasiallc.cn/">Cloud Native + Open Source Virtual Summit China 2020</a>, attracted 5,800+ attendees.&nbsp;</p>
				<p>CNCF has grown from a few members in China in 2015 to over 50 in 2020. That number&nbsp; includes four Platinum (20% of Platinum members), six Gold (27% of Gold members), 55 Silver (nearly 8% of Silver members), and two End User Supporters (2% of End User Supporters). China now represents more than 8% of the CNCF total membership. China remains the&nbsp;<a href="https://all.devstats.cncf.io/d/50/countries-statistics-in-repository-groups?orgId=1&amp;from=1452153600000&amp;to=1606896000000&amp;var-period_name=Year&amp;var-countries=All&amp;var-repogroup_name=All&amp;var-metric=contributors&amp;var-cum=countries">third-largest contributor</a>&nbsp;to CNCF projects (in terms of contributors and committers) after the United States and Germany.</p>
				<p>According to the&nbsp;<a href="https://www.cncf.io/blog/2020/10/13/cncf-cloud-native-survey-china-2019/">Cloud Native Survey China 2019</a>, released this year, cloud native is continuing its growth in China, especially in production. Some 49% of respondents now use containers in production, with another 32% planning to do so. This is a significant increase from November 2018 when only 20% used containers in production. Further, 72% of respondents in China use Kubernetes in production, up from 40% in November 2018. We are in the process of conducting the Chinese survey for 2020, and will release the results early next year.&nbsp;</p>
				<p>Among Chinese contributors to CNCF-hosted projects, Huawei and PingCAP led the way with&nbsp;<a href="https://all.devstats.cncf.io/d/5/companies-table?orgId=1">66,554 and 84,816</a>&nbsp;contributions, respectively, and are the sixth- and eighth-largest contributors overall. CNCF also hosts 11 CNCF projects that were born in China:&nbsp;<a href="https://www.bfe-networks.net/en_us/">BFE</a> (Baidu), <a href="https://github.com/chaos-mesh/chaos-mesh">Chaos Mesh</a>&nbsp;(PingCAP), <a href="https://github.com/chubaofs/chubaofs">ChubaoFS</a> (JD.com),&nbsp;<a href="https://github.com/cni-genie/CNI-Genie">CNI-Genie</a> (Huawei), <a href="https://github.com/dragonflyoss/Dragonfly">Dragonfly</a>&nbsp;(Alibaba),&nbsp;<a href="https://github.com/goharbor/harbor">Harbor</a>&nbsp;(VMware China),&nbsp;<a href="https://github.com/kubeedge/kubeedge">KubeEdge</a>&nbsp;(Huawei),&nbsp; <a href="https://openkruise.io/en-us/">OpenKruise</a> (Alibaba), <a href="https://openyurt.io/en-us/">OpenYurt</a> (Alibaba),&nbsp;<a href="https://github.com/tikv/tikv">TiKV</a>&nbsp;(PingCAP), and <a href="https://github.com/volcano-sh/volcano">Volcano</a> (Huawei).&nbsp;</p>
				<p>Our Chinese community participated in a variety of certification programs and&nbsp;<a href="https://www.cncf.io/newsroom/case-studies-cn/">case studies</a>&nbsp;in 2020, including 17% of KCSPs, 16% of KTPs, and 24% of Certified Kubernetes Conformance companies. To help showcase best practices for this community, we published two Chinese case studies in 2020, featuring China Minsheng Bank and Platinum end user member JD.com.&nbsp;</p>
				<p>CNCF, in partnership with Alibaba, continues to offer the free&nbsp;<a href="https://www.cncf.io/blog/2019/04/17/cncf-and-alibaba-offer-free-cloud-native-course-for-chinese-developers/">Kubernetes and Cloud Native course</a>&nbsp;that was launched in 2019 in China.</p>
				<p>We’re excited to build on this success by hosting a KubeCon + CloudNativeCon China event in 2021.</p>
			</div>
			<div class="wp-block-column" style="flex-basis:40%">
				<figure class="wp-block-image size-full is-resized"><img
						loading="lazy"
						src="<?php echo esc_url( get_template_directory_uri() . '/images/annual-reports/2020/CNCF-Annual-Report-2020-graphics-china.jpg' ); ?>"
						alt="Growth in China, 50 new member, 3rd largest national contributor"
						class="wp-image-59734" width="518" height="702">
				</figure>
			</div>
		</div>
		<div style="height:40px" aria-hidden="true"
			class="wp-block-spacer is-style-40-responsive"></div>
		<h2 class="is-style-divider-line" id="2021">Looking Forward to
			2021<em><br></em>
		</h2>
		<p
			class="is-style-max-width-900 has-header-3-font-size">CNCF remains the fastest-growing foundation in the history of open source. The success of CNCF is directly attributable to our projects, the contributions of the community, our end users, and support from our member companies. Thank you!&nbsp;</p>
		<p
			class="is-style-default">As we look to 2021 and beyond, we remain committed to fostering and sustaining an ecosystem<strong> </strong>of open source, vendor-neutral projects, and to making technology accessible for everyone. To thrive, we believe CNCF must continue to provide a neutral home for projects, encourage diversity, and continue to cultivate community. All three are crucial elements for growth.</p>
		<p
			class="is-style-default">By continuing a wide array of initiatives, such as security audits, project journey reports, and documentation improvements, we are investing in the community to strengthen the cloud native ecosystem. We will continue with our core strategy of focusing on the developer community, helping developers progress into contributor and maintainer roles, and offering educational opportunities for those looking to grow and learn.</p>
		<p
			class="is-style-default">Previously, in-person learning opportunities were offered at our flagship KubeCon + CloudNativeCon events. We are now aggressively expanding these learning opportunities through virtual and hybrid events. We plan to expand our events, especially community ones,both initiatives in 2021 to continue supporting community learning.</p>
		<p
			class="is-style-default">Our sincere hope is that the CNCF community will continue to evolve as more and more new people join the ecosystem, thus furthering diversity and collaboration. We see signs of this as first-time attendees made up 69% of KubeCon + CloudNativeCon North America Virtual 2020. In 2021, we will also be launching a member referral program that will help support the growth and diversity of our community.</p>
		<p
			class="is-style-default">We also will continue to emphasize the growth of our end user community, with new initiatives such as the CNCF End User Technology Radar sharing the real experiences, feedback, and opinions of end users. We will continue our work to bring end users together to discuss best practices in the Telco, Research, and Financial Services sectors.</p>
		<p
			class="is-style-max-width-800 has-header-4-font-size">In summary, 2020 was an exceptional year for CNCF. We are well-positioned financially and organizationally to continue our mission to make cloud native computing ubiquitous and the de facto standard for software development and usage. We look forward to having you join us on this journey as we look to 2021 and beyond. </p>
		<p
			class="is-style-max-width-800 has-header-3-font-size">We are working diligently to iterate on our strategy for 2021. For the latest updates, please <a href="/blog">see the CNCF blog</a>.</p>
	</div>
	<div style="height:40px" aria-hidden="true"
			class="wp-block-spacer is-style-40-responsive"></div>
</main>
<?php

get_template_part( 'components/footer' );
