<?php
/**
 * Template Name: Annual Report 2018
 * Template Post Type: lf_report
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

get_template_part( 'components/header' );

get_template_part( 'components/skip-link-target' );
?>

<link rel="prefetch"
	href="<?php echo esc_url( get_template_directory_uri() . '/build/annual-report-2018.min.css' ); ?>"
	as="style" crossorigin="anonymous" />

	<?php

	wp_enqueue_style( '2018', get_template_directory_uri() . '/build/annual-report-2018.min.css', array(), filemtime( get_template_directory() . '/build/annual-report-2018.min.css' ), 'all' );

	?>

<div id="ajax-content-wrap">
	<div class="home">
		<div class="main annual-report-page annual-report-2018">

<section class="hero-banner-section">

<div class="hero-image-container" style="background-image: url('/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/banner-home-low.jpg')">
</div>

<div class="cloud-native-logo-strip">
<div class="container">
<img src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/cncf-logo.svg">
</div></div>

<div class="hero-shade">
<div class="shade"></div>
<div class="not-shade"></div>
</div>


<div class="hero-intro-text">
<div class="report-text">
<div class="report-text-wrapper">
<span>CNCF</span>
<span class="strong">Annual</span>
<span class="strong">Report</span>
</div></div>
<div class="eighteen">
<span>18</span>
</div>
</div>


			</section>
			<div class="container-wrap download-section">
				<div class="container wrap">
					<div>
						<div class="wp-block-buttons aligncenter is-style-button-pdf">
							<div class="wp-block-button"><a class="wp-block-button__link" href="https://www.cncf.io/wp-content/uploads/2020/08/CNCF-Annual-Report-2018.pdf">DOWNLOAD THIS REPORT</a></div>
						</div>
					</div>
				</div>
			</div>
			<div class="container-wrap">
				<div class="container">
					<div class="row">
						<div class="col-sm-4 col-md-3 sidebar-wrap">
							<nav id="annual-report-sidebar" class="annual-report-sidebar">
								<h2>Overview</h2>
								<ul class="nav-items nav">
									<li>
										<a href="#welcome" target="_self" rel="noopener noreferrer">Welcome</a>
									</li>
									<li>
										<a href="#who-we-are" target="_self" rel="noopener noreferrer">Who
											We Are</a>
									</li>
									<li>
										<a href="#we-are-growing" target="_self" rel="noopener noreferrer">We Are Growing</a>
									</li>
									<li>
										<a href="#project-updates-and-satisfaction" target="_self" rel="noopener noreferrer">Project Updates and
											Satisfaction</a>
									</li>
									<li>
										<a href="#community-engagement" target="_self" rel="noopener noreferrer">Community Engagement
										</a>
									</li>
									<li>
										<a href="#ecosystem-tools" target="_self" rel="noopener noreferrer">Ecosystem Tools</a>
									</li>
									<li>
										<a href="#test-conformance-projects" target="_self" rel="noopener noreferrer">Test Conformance
											Projects</a>
									</li>
									<li>
										<a href="#international-china" target="_self" rel="noopener noreferrer">International: China
										</a>
									</li>
									<li>
										<a href="#looking-forward" target="_self" rel="noopener noreferrer">Looking Forward to
											2019</a>
									</li>
								</ul>
							</nav>
						</div>
						<div class="col-sm-8 col-md-9 content-wrap">
							<section id="welcome" class="welcome_section" style="background-image: url('/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/welcome-banner.jpg')">
								<div class="welcome_container white-links">
									<h2>Welcome</h2>
									<p>
							  Welcome to the 2018 Cloud Native Computing Foundation annual report. Comments and feedback are welcome at
							  <a href="mailto:info@cncf.io">info@cncf.io</a>
						   </p>
								</div>
							</section>
							<section id="who-we-are" class="who-we-are-section white-links">
								<h2>Who We Are</h2>
								<div class="cols">
									<p>
							  <span style="font-weight: 400;">The Cloud Native Computing Foundation (CNCF) is an open source software foundation dedicated to making cloud native computing universal and sustainable. Cloud native technologies empower organizations to build and run scalable applications in modern, dynamic environments such as public, private, and hybrid clouds. Containers, service meshes, microservices, immutable infrastructure, and declarative APIs exemplify this approach. </span>
						   </p>
									<p>
							  <span style="font-weight: 400;">We are a community of open source projects, including Kubernetes, Prometheus, Envoy, and </span>
							  <a href="https://www.cncf.io/projects/">
							  <span style="font-weight: 400;">many others</span>
							  </a>
							  <span style="font-weight: 400;">. Kubernetes and other CNCF projects are some of the </span>
							  <a href="https://www.cncf.io/blog/2017/06/05/30-highest-velocity-open-source-projects/">
							  <span style="font-weight: 400;">highest velocity projects</span>
							  </a>
							  <span style="font-weight: 400;"> in the history of open source.</span>
						   </p>
								</div>
								<ul class="items widthcol3">
									<li>
										<div class="content-wrap">
											<div class="icon-wrap">
												<img src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/CNCF_Annual_Report_2018_diagram-14.svg">
											</div>
											<div class="text-wrap" data-mh="whoweare-text-wrap">
												<div class="number">47,358</div>
												<h6># OF CONTRIBUTORS TO CNCF
													PROJECTS
												</h6>
											</div>
										</div>
									</li>
									<li>
										<div class="content-wrap">
											<div class="icon-wrap">
												<img src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/CNCF_Annual_Report_2018_diagram-15.svg">
											</div>
											<div class="text-wrap" data-mh="whoweare-text-wrap">
												<div class="number">89,112</div>
												<h6>CNCF MEETUP MEMBERS</h6>
											</div>
										</div>
									</li>
									<li>
										<div class="content-wrap">
											<div class="icon-wrap">
												<img src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/CNCF_Annual_Report_2018_diagram-16.svg">
											</div>
											<div class="text-wrap" data-mh="whoweare-text-wrap">
												<div class="number">54,255</div>
												<h6>REGISTERED FOR FREE
													KUBERNETES EDX COURSE
												</h6>
											</div>
										</div>
									</li>
								</ul>
							</section>
							<section id="" class="who-we-are-projects white-links">
								<div class="container">
									<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/diagram-revised-01.svg" alt="">
									<div class="copy-wrp">
										<p>
								 A basic premise behind CNCF, our
								 <a href="http://www.kubecon.io/">KubeCon + CloudNativeCon</a>
								 conferences, and open source in general is that many interactions are positive sum – making everyone involved better off – rather than zero sum, where there would be winners and losers. There is not a fixed amount of investment, mindshare, or development contributions that gets allocated between projects. Just as open source development is based on the idea that collectively we are smarter than any one of us, open source foundations work to make the entire community better off.
							  </p>
										<p>CNCF is committed to building sustainable ecosystems by hosting great open source projects. Companies use those projects and build commercial products and services, creating value in the form of profits. They can then reinvest a portion of the profits in the projects by funding developers, which results in more code, more improvements, and better products. This creates a virtuous cycle of investment, innovation, and economic activity.</p>
									</div>
								</div>
							</section>
							<section id="we-are-growing" class="we-are-growing">
								<h2 class="bg-title pink-to-purple">We are
									Growing
								</h2>
								<div class="growing-container">
									<div class="left-wrp">
										<div class="new-members number">195 New
											Members
										</div>
										<div class="new-members percent">
											<img src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/arrow-up-01.svg" alt="" class="new-members-arrow"> 130%
										</div>
										<div class="china-members">
											<span class="title-like new-members">China</span>
											<div class="content">
												<strong>39 Members</strong>
												<p>3 Platinum, 3 Gold, 33 Silver, Academic + Nonprofit</p>
												<div class="china-members-mockup">
													<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/china-mockup.png" alt="">
													<p>
										  <strong>10%</strong>
										  of the CNCF total membership
									   </p>
												</div>
											</div>
										</div>
									</div>
									<div class="right-wrp">
										<h3 class="new-members-title platinum">
											New Platinum Member
										</h3>
										<figure class="platinum-logo">
											<span>
												<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/jd.com-01-1-01.svg" alt="">
											</span>
											<figcaption class="big-data">
												<strong>17</strong>
												<span>Platinum Members in
													Total</span>
											</figcaption>
										</figure>
										<h3 class="new-members-title gold">New
											Gold Members
										</h3>
										<div class="members-logos-wrp">
											<figure class="gold-logo">
												<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/digital-ocean.svg" alt="cncf-annual-report-2018">
											</figure>
											<figure class="gold-logo">
												<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/Logo_sumologic-2.svg" alt="cncf-annual-report-2018">
											</figure>
											<figure class="gold-logo">
												<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/Hortonworks-2.svg" alt="cncf-annual-report-2018">
											</figure>
											<figure class="gold-logo">
												<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/capital-one.svg" alt="cncf-annual-report-2018">
											</figure>
										</div>
										<h3 class="new-members-title silver">+
											157 New Silver Members
										</h3>
										<div class="silver-members-content">
											<p>China is the third largest contributor to CNCF projects (in terms of contributors and committers) after the U.S. and Germany.</p>
										</div>
									</div>
								</div>
							</section>
							<section id="user_community-section" class="user-community-companies-section" style="background-image: url('/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/end-user-bg.png')">
								<div class="end-user-container white-links">
									<h2>End User Community</h2>
									<div class="cols">
										<p>
								 <span style="font-weight: 400;">We offer multiple opportunities for end users to contribute and have their voices heard. Companies that use cloud native technologies internally, but do not sell any cloud native services externally, are eligible to join the </span>
								 <a href="https://www.cncf.io/people/end-user-community/">
								 <span style="font-weight: 400;">End User Community</span>
								 </a>
								 <span style="font-weight: 400;">. </span>
							  </p>
										<p>
								 <span style="font-weight: 400;">Our End User Community is growing. We finished 2018 with 69 top companies and startups, which is the largest end-user community of any open source foundation. We published </span>
								 <a href="https://www.cncf.io/people/end-user-community/">
								 <span style="font-weight: 400;">16 case studies</span>
								 </a>
								 <span style="font-weight: 400;"> last year about the learnings from end users committed to accelerating the adoption of cloud native technologies and improving the deployment experience.</span>
							  </p>
									</div>
									<h4>69 COMPANIES IN THE END USER COMMUNITY
									</h4>
								</div>
								<ul class="items widthcol1">
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/adidas.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/amadeus-1.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/auditboard.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/bloomberg.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/box_blue.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/capital-one.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/comcast.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/cruise.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/curve.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/denso.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/didi-1.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/ebay.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/form3-1.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/github.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/goldman-sachs.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/indeed-01.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/intuit-1.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/jd.com-01-1-01.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/jp-morgan.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/Kuelap_logo-1.png" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/la-mobiliere-1.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/Layer-End-User-Supporter.png" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/mastercard.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/morgan-stanley.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/naic.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/nasdaq.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/ncsoft.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/nipr.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/olark.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/pinterest.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/postfinance.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/PusherLogo.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/reddit.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/ricardo.ch_.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/salesforce-01.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/sap-concur.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/shopify.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/showmax.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/simplenexus.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/spotify.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/spredfast.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/squarespace.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/statestreet.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/Steelhouse.jpg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/stix.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/testfire-labs-01.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/textkernel.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/thredup.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/new-york-times.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/ticketmaster.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/twilio.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/logo_twitter-1.png" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/Two-Sigma.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/mufg-union-bank.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/walmart-labs.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/werkspot.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/wework.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/wikimedia-foundation.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/woorank.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/workday.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/wpengine.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/yahoojapan.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/zalando.svg" alt="">
										</div>
									</li>
									<li>
										<div class="company">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/zendesk.svg" alt="">
										</div>
									</li>
								</ul>
								<div class="end-user-container award white-links">
									<div class="left-wrp">
										<p class="text-larger">In May 2018, we were thrilled to grant our first Top End User Award to Bloomberg for their innovative use of cloud native technologies and unique contributions to the CNCF ecosystem.</p>
										<p>The End User Community meets monthly and advises the CNCF Governing Board and Technical Oversight Committee (TOC) members on key challenges, emerging use cases, and areas of opportunity and new growth for cloud native technologies.</p>
										<p class="margin-bottom">If you’re using CNCF projects in interesting ways, we urge you to join our official
								 <a href="https://www.cncf.io/people/end-user-community/">End User Community</a>
								 so you have an official voice, and more importantly, learn from other end users deploying CNCF projects.
							  </p>
									</div>
									<div class="right-wrp">
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/CNCF_Annual_Report_2018_diagram-17.svg" alt="">
									</div>
								</div>
							</section>
							<section id="conferences_events" class="conferences-and-events">
								<div class="conferences-container">
									<div class="left-wrp">
										<h2>Conferences and Events</h2>
										<p>
								 <a href="http://www.kubecon.io/">
								 <span style="font-weight: 400;">KubeCon + CloudNativeCon</span>
								 </a>
								 <span style="font-weight: 400;"> has expanded from its start with 500 attendees in 2015 to become one of the largest and most successful open source conferences ever. The </span>
								 <a href="https://events.linuxfoundation.org/events/kubecon-cloudnativecon-north-america-2018/">
								 <span style="font-weight: 400;">KubeCon + CloudNativeCon North America event in Seattle</span>
								 </a>
								 <span style="font-weight: 400;">, held December 10-13, 2018, was our biggest yet and was sold out several weeks ahead of time with 8,000 attendees.</span>
							  </p>
										<p>
								 <span style="font-weight: 400;">KubeCon + CloudNativeCon co-chair Liz Rice of Aqua Security gave a CNCF community update, alongside a number of our project maintainers, including a Helm update from Michelle Noorali of Microsoft and an Envoy update from Matt Klein of Lyft.</span>
							  </p>
										<p>
								 <span style="font-weight: 400;">KubeCon + CloudNativeCon Seattle attendance increased 90% from last year’s KubeCon + CloudNativeCon North America event in Austin. And while the attendee numbers grew, the great developer conference experience remained the same.</span>
							  </p>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/event-chart-revised-01.svg" alt="">
									</div>
									<div class="right-wrp">
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/event-diagram-01.svg" alt="">
									</div>
								</div>
								<hr class="pink-blue-line">
								<div class="conferences-container">
									<div class="full-wrp">
										<div class="left-wrp">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/45635952904_aa691e4a51_k-1.jpg" alt="">
										</div>
										<div class="right-wrp">
											<p>KubeCon + CloudNativeCon co-chair Janet Kuo of Google explained that Kubernetes being boring was a good thing. As co-chair Liz Rice of Aqua Security said: “CNCF is not here to throw glitzy events, but to help us coordinate as a community and ensure we have proper governance in place.” Kelsey Hightower gave a shout out to the amazing real women of Hidden Figures, his mom, and the Queen of Motown, Diana Ross, in his serverless keynote.</p>
										</div>
										<div class="conference-additional">
											<p>
									The co-chairs select a program committee of around 80 experts, including project maintainers, active community members, and highly-rated presenters from past events, to review the CFP submissions. The keynote speakers are selected by the conference co-chairs from highly-rated CFP submissions, or in rare cases, by invitation from the co-chairs.
									<a href="https://events.linuxfoundation.org/events/kubecon-cloudnativecon-north-america-2018/">KubeCon + CloudNativeCon Seattle</a>
									included 318 sessions: CFP tracks sessions, lightning talks, BoFs, tutorials, and maintainer track sessions, which were offered in ~10 rooms as well as ~90 maintainer sessions spread across ~5 rooms.
								 </p>
										</div>
									</div>
								</div>
							</section>
							<section id="training_certification" class="training-certification-section white-links" style="background-image: url('/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/training-and-certification-bg.png')">
								<div class="training-container">
									<h2>Training &amp; Certification</h2>
									<div class="cols">
										<p>
								 <span style="font-weight: 400;">Adopting new technology can be challenging, especially when it’s hard to find qualified people. CNCF offers training and certification for key CNCF technologies such as Kubernetes to ensure that organizations can train their own employees or hire from a strong body of experienced talent. We offer the free </span>
								 <a href="https://www.cncf.io/certification/training/">
								 <span style="font-weight: 400;">Kubernetes Massively Open Online Course (MOOC)</span>
								 </a>
								 <span style="font-weight: 400;"> through our partnership with edX, as well as self-paced and instructor-led Kubernetes training. The official </span>
								 <a href="https://www.cncf.io/certification/expert/">
								 <span style="font-weight: 400;">Certified Kubernetes Administrator (CKA)</span>
								 </a>
								 <span style="font-weight: 400;"> certification ensures a high level of expertise in the ecosystem, and the </span>
								 <a href="https://www.cncf.io/certification/kcsp/">
								 <span style="font-weight: 400;">Kubernetes Certified Service Provider (KCSP)</span>
								 </a>
								 <span style="font-weight: 400;"> program is a pre-qualified tier of vetted service providers that offer Kubernetes support, consulting, and professional services for organizations embarking on their Kubernetes journey. </span>
							  </p>
										<p>
								 <span style="font-weight: 400;">In May 2018, CNCF announced the availability of the </span>
								 <a href="https://www.cncf.io/certification/training/">
								 <span style="font-weight: 400;">Kubernetes Training Partner (KTP)</span>
								 </a>
								 <span style="font-weight: 400;"> program, which offers qualified training providers with deep experience in cloud native technology training.</span>
							  </p>
									</div>
									<h3>18 Kubernetes Training Partners (KTP)
									</h3>
								</div>
								<ul class="items widthcol5">
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/Alauda_logo-01.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/boxboat.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/Caicloud_Logo.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/cloudops.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/cloudyuga.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/component-soft.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/creationline.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/container-solutions-ktp.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/daocloud-stacked.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/doit-intl-1.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/easy-stack-svg.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/inwinstack.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/lf-training.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/loodse.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/nebulaworks.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/prodyna.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/rx-m-.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/tenxcloud.svg" alt="">
									</li>
								</ul>
							</section>
							<section id="" class="software-conformance">
								<hr class="pink-blue-line">
								<div class="software-conformance-container">
									<h2>Software Conformance</h2>
									<div class="cols">
										<p>
								 It is unprecedented to get every cloud company, enterprise software provider, and startup in the industry to support a conformance program. CNCF has achieved this with the
								 <a href="https://www.cncf.io/certification/software-conformance/">Certified Kubernetes Conformance Program</a>
								 , which enables any Kubernetes implementation to demonstrate that it is conformant and interoperable. Nearly all of the world’s leading software vendors and cloud computing providers have
								 <a href="https://www.cncf.io/certification/software-conformance/#logos">Certified Kubernetes</a>
								 offerings.
							  </p>
										<p>It is an extraordinary accomplishment that there are no forks in our industry, which speaks to the commitment that companies of all sizes have made to be good partners in the community. CNCF has certified offerings from 76 vendors.</p>
									</div>
									<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/certified-kubernetes-03.svg" alt="">
								</div>
								<h3>76 Certified Kubernetes Partners</h3>
								<ul class="items widthcol5">
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/agilestacks.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/Alauda_logo-01.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/alibaba.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/amazon-elastic-container-service-for-kubernetes-eks-1.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/appscode.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/baidu-cloud-container-engine-1.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/bo-cloud-beyondcent-container-1.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/cablelabs.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/Caicloud_Logo.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/canonical-kcsp.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/catalyst-cloud.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/cisco.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/cloud-66-maestro-1.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/cloud-foundry.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/containership-1.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/logo_coreos_cncf.png" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/cstack.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/daocloud-stacked.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/diamanti.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/digital-ocean.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/docker.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/easy-stack-svg.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/e-bao-cloud-1.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/e-king-cloud-container-platform-1.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/elastx-private-kubernetes-1.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/enc-helium.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/giant-swarm-1.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/google.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/gravity-1.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/harmony-cloud.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/hasura-2.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/heptio.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/huawei.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/ibm-cloud.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/inspur-in-cloud-open-platform.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/inwinstack.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/jd-com-tig-jingdong-datacenter-os-1.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/logo_joyent-1.png" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/kinvolk.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/kontena-pharos-1.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/kops-1.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/kubernetes-distribution-by-containerum-1.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/kubernetes-the-easier-way-1.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/kublr-1.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/loodse.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/magnum-1.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/mesosphere.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/metal-k8s-1.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/microsoft-azure.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/mirantis-1.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/navops.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/netease-1.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/nirmata-stacked.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/nutanix.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/oracle-1.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/ovh.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/pivotal.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/platform9.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/portworx.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/qiniu.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/rackspace.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/rancher.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/redhat-01.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/robin-1.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/samsung-sds.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/SAP-01.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/stack-point-cloud-1.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/supergiant.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/symplegma-1.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/telekube-01.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/tencent.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/tenxcloud.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/typhoon-1.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/vmware.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/weaveworks-1.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/wise2-c-kcsp.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/woqutech.svg" alt="">
									</li>
									<li>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/zte-01.svg" alt="">
									</li>
								</ul>
							</section>
							<section id="project-updates-and-satisfaction" class="project-updates-and-satisfaction">
								<h2>Project Updates &amp; Satisfaction</h2>
								<div class="project-container">
									<p>
							  2018 was a very busy year for CNCF projects, including the graduations of Kubernetes, Prometheus, and Envoy. 7 CNCF projects were the winners out of the 13 awards in cloud computing in InfoWorld’s 2018 Best of Open Source Software (
							  <a href="https://www.infoworld.com/article/3306843/open-source-tools/bossies-2018-the-best-of-open-source-software-awards.html">BOSSIE</a>
							  )
						   </p>
									<p>We are pleased to share the results from the maintainer surveys we do twice a year:</p>
									<h3>CNCF Project Maintainer Survey Results
									</h3>
									<div class="data-wrp">
										<div class="big-data">
											<strong>4.20</strong>
											<span>MAINTAINER SATISFACTION:
												4.20/5</span>
										</div>
										<div class="big-data">
											<strong>100%</strong>
											<span>100% OF PROJECTS ARE
												REPRESENTED IN THE MAINTAINER
												SURVEY RESULTS</span>
										</div>
										<div class="big-data">
											<strong>4.22</strong>
											<span>A LARGE MAJORITY OF
												MAINTAINERS WOULD RECOMMEND CNCF
												TO OTHER PROJECTS:
												4.22/5.0</span>
										</div>
									</div>
									<div class="recommend-chart wrp-chart">
										<div class="chart">
											<h4>Recommend Cncf To Other
												Projects? (4.22/5)
											</h4>
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/recommend-chart.png" alt="">
										</div>
										<p>The overall satisfaction with CNCF increased in 2018 and reflected a 100% response rate across projects. For the first time, we asked if maintainers would recommend CNCF to other projects. Responses were positive with a score of 4.22/5.</p>
									</div>
								</div>
								<hr class="pink-blue-line">
								<div class="project-container">
									<h3>CNCF Charter Revisions</h3>
									<p>
							  <span style="font-weight: 400;">The CNCF </span>
							  <a href="https://github.com/cncf/foundation/blob/master/charter.md">
							  <span style="font-weight: 400;">charter</span>
							  </a>
							  <span style="font-weight: 400;"> was revised in November 2018 to incorporate the </span>
							  <a href="https://docs.google.com/document/d/1d9Ks3UvUV8sZj4ribAMwmq0MZwi1CwnOZWGtrCufOuk/edit">
							  <span style="font-weight: 400;">Cloud Native definition</span>
							  </a>
							  <span style="font-weight: 400;"> developed by the TOC. </span>
						   </p>
									<div class="project-maturity-levels">
										<h3>Project Maturity Levels</h3>
										<div class="copy-wrp">
											<p>
									CNCF projects have a maturity level of sandbox, incubating, or graduated. CNCF uses these maturity levels to signal to enterprises which projects they should adopt. Graduated projects are suitable for the vast majority of all enterprises. Incubating projects are suitable for early adopters, and sandbox projects are for innovators. Projects increase their maturity level by demonstrating to the TOC that they have adoption, healthy rate of changes, and committers from multiple organizations as well as adopting the CNCF
									<a href="https://github.com/cncf/foundation/blob/master/code-of-conduct.md">Code of Conduct</a>
									and earning the Core Infrastructure Initiative
									<a href="https://bestpractices.coreinfrastructure.org/">Best Practices Badge</a>
									. Full details are listed in
									<a href="https://github.com/cncf/toc/blob/master/process/graduation_criteria.adoc">Graduation Criteria v1.1</a>
									.
								 </p>
											<p>
									2018 highlights include the addition of 16 new projects by the
									<a href="https://github.com/cncf/toc">CNCF TOC</a>
									, listed in order of date accepted:
								 </p>
										</div>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/graphic-chasm-3-02-01.svg" alt="">
									</div>
									<div class="incubating-sandbox-wrp">
										<div class="project-incubating">
											<h3>Incubating</h3>
											<ul class="items">
												<li>
													<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/rook-01.svg" alt="">
												</li>
												<li>
													<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/vitess-stacked.svg" alt="">
												</li>
												<li>
													<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/nats-01.svg" alt="">
												</li>
												<li>
													<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/helm-01.svg" alt="">
												</li>
												<li>
													<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/harbor-stacked.svg" alt="">
												</li>
											</ul>
										</div>
										<div class="project-sandbox">
											<h3>Sandbox</h3>
											<ul class="items">
												<li>
													<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/spiffe-01.svg" alt="">
												</li>
												<li>
													<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/opa-stacked-color-01.svg" alt="">
												</li>
												<li>
													<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/cloudevents-01.svg" alt="">
												</li>
												<li>
													<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/telepresence-01.svg" alt="">
												</li>
												<li>
													<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/openmetrics-01.svg" alt="">
												</li>
												<li>
													<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/tikv-01.svg" alt="">
												</li>
												<li>
													<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/cortex-01.svg" alt="">
												</li>
												<li>
													<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/buildpacks-01.svg" alt="">
												</li>
												<li>
													<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/falco-01.svg" alt="">
												</li>
												<li>
													<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/dragonfly-01.svg" alt="">
												</li>
												<li>
													<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/virtualkubelet-stacked-color-01.svg" alt="">
												</li>
											</ul>
										</div>
									</div>
								</div>
							</section>
							<section id="projects-updates-and-releases" class="projects-updates-and-releases">
								<hr class="pink-blue-line">
								<div class="project-container">
									<h2>Project Updates And Releases</h2>
									<p>Many milestone releases demonstrated steady forward progress for each of these projects.</p>
									<figure>
										<span>
											<img src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/kubernetes-stacked-color-01.svg">
										</span>
										<figcaption>
											<p>
									<a href="https://kubernetes.io/blog/2018/12/03/kubernetes-1-13-release-announcement/">Kubernetes 1.13</a>
									was released in December 2018. New functionality included: simplified Kubernetes cluster management with kubeadm in GA and the
									<a href="https://github.com/container-storage-interface/spec">Container Storage Interface (CSI)</a>
									in GA.
								 </p>
										</figcaption>
									</figure>
									<figure>
										<span>
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/coredns-01.svg">
										</span>
										<figcaption>
											<p>
									<a href="https://coredns.io/">CoreDNS</a>
									replaced kube-dns as the default DNS server for Kubernetes.
								 </p>
										</figcaption>
									</figure>
									<figure>
										<span>
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/fluentd-01.svg">
										</span>
										<figcaption>
											<p>
									<a href="https://www.fluentd.org/">Fluentd</a>
									, the open source data collector for unified logging, added additional support for Splunk and Amazon Kinesis.
								 </p>
										</figcaption>
									</figure>
									<figure>
										<span>
											<img src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/opentracing-stacked-color.svg">
										</span>
										<figcaption>
											<p>OpenTracing added Lua support, and the Jaeger platform saw the addition of a Jaeger Operator to reduce the operational overhead of running this on Kubernetes.</p>
										</figcaption>
									</figure>
									<figure>
										<span>
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/nats-01.svg">
										</span>
										<figcaption>
											<p>
									The
									<a href="https://nats.io/">NATS</a>
									project, a simple, highperformance open source messaging system for cloud native applications, saw the inclusion of secure multitenancy and network topology optimizations over the past year.
								 </p>
										</figcaption>
									</figure>
									<figure>
										<span>
											<img src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/vitess-stacked.svg">
										</span>
										<figcaption>
											<p>
									<a href="https://vitess.io/">Vitess</a>
									, a database clustering system for horizontal scaling of
									<a href="https://www.mysql.com/">MySQL</a>
									through the use of
									<a href="https://github.com/vitessio/vitess#vitess">generalized sharding</a>
									outside of application logic, released
									<a href="https://vitess.io/blog/2018-12-10-introducing-vitess-3.0/">v3</a>
									, which included functionality such as
									<a href="https://vitess.io/docs/reference/vitess-replication/">VReplication</a>
									, Prometheus monitoring integration, and a series of performance enhancements.
								 </p>
										</figcaption>
									</figure>
									<figure>
										<span>
											<img src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/linkerd-stacked-color.svg">
										</span>
										<figcaption>
											<p>
									The Linkerd service mesh team released v2 (based on the previously
									<a href="https://www.cncf.io/blog/2018/09/18/linkerd-2-0-in-general-availability/">released</a>
									Conduit project), which enables execution in a service sidecar model.
								 </p>
										</figcaption>
									</figure>
									<figure>
										<span>
											<img src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/etcd-horizontal-1.svg">
										</span>
										<figcaption>
											<p>
									Most recently, the TOC voted to accept
									<a href="https://github.com/coreos/etcd">etcd</a>
									as an incubation-level hosted project. That’s important because etcd plays a huge role in the Kubernetes ecosystem, serving as the “brain” of Kubernetes clusters. It’s a distributed keyvalue store, first developed by CoreOS and designed for reliability and scalability in distributed cluster environments.
								 </p>
										</figcaption>
									</figure>
								</div>
							</section>
							<section id="services-and-assistance-for-projects" class="services-and-assistance-for-projects">
								<hr class="pink-blue-line">
								<div class="project-container">
									<h2>Services And Assistance For Projects
									</h2>
									<p>
							  CNCF provided a variety of
							  <a href="https://github.com/cncf/servicedesk">services</a>
							  to our projects to help make them more successful.
						   </p>
									<h3>Security Audits</h3>
									<p>CNCF funded and orchestrated security audits for:</p>
									<figure class="small">
										<a href="https://github.com/envoyproxy/envoy/blob/master/docs/SECURITY_AUDIT.pdf" rel="noopener noreferrer">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/envoy-stacked-color_BLACK.svg" alt="">
										</a>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/external-link-2.png" alt="" class="external-link">
									</figure>
									<figure class="small">
										<a href="https://github.com/prometheus/docs/pull/1065" rel="noopener noreferrer">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/prometheus-stacked-color.svg" alt="">
										</a>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/external-link-2.png" alt="" class="external-link">
									</figure>
									<figure class="small">
										<a href="https://coredns.io/2018/03/15/cure53-security-assessment/" rel="noopener noreferrer">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/coredns-01.svg" alt="">
										</a>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/external-link-2.png" alt="" class="external-link">
									</figure>
									<figure class="small">
										<a href="https://github.com/nats-io/nats-general/blob/master/reports/Cure53_NATS_Audit.pdf" rel="noopener noreferrer">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/nats-01.svg" alt="">
										</a>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/external-link-2.png" alt="" class="external-link">
									</figure>
									<blockquote>
										<div>
											<div>
												<em>“In spite of eight
													security-relevant findings,
													the team responsible for
													this assessment of the Envoy
													compound can attest to the
													overall good state of
													security matters at the
													tested project. After
													spending twenty days on the
													Envoy test target in
													February 2018, the
													penetration testers
													concluded that the software
													was appropriately built and
													deployed. Similarly, </em>
												positive
												<em> impression concerned the
													Envoy code, which the
													auditors found to be
													well-written.”</em>
											</div>
										</div>
									</blockquote>
									<figure class="big">
										<a href="https://github.com/open-policy-agent/opa/blob/master/SECURITY_AUDIT.pdf" rel="noopener noreferrer">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/opa-stacked-color-01.svg" alt="">
										</a>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/external-link-2.png" alt="" class="external-link">
									</figure>
									<figure class="big">
										<a href="https://github.com/theupdateframework/notary#security-audits" rel="noopener noreferrer">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/notary-stacked-color-01.svg" alt="">
										</a>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/external-link-2.png" alt="" class="external-link">
									</figure>
									<figure class="big">
										<a href="https://github.com/containerd/containerd/#security-audit" rel="noopener noreferrer">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/containerd-stacked-black.svg" alt="">
										</a>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/external-link-2.png" alt="" class="external-link">
									</figure>
								</div>
								<hr class="pink-blue-line">
								<div class="project-container">
									<h3>Events</h3>
									<div class="left-wrp">
										<ul>
											<li>
												CNCF has been investing in
												CNCF-hosted projects to hold
												their own specialized events,
												whether in conjunction with
												KubeCon + CloudNativeCon
												(including
												<a href="https://events.linuxfoundation.org/events/kubecon-cloudnativecon-north-america-2018/co-located-events/#envoycon">EnvoyCon</a>
												and the
												<a href="https://events.linuxfoundation.org/events/kubecon-cloudnativecon-north-america-2018/co-located-events/#observability-practitioners-summit">Observability
													Practitioner’s Summit</a>
												) or standalone conferences
												(including
												<a href="https://promcon.io/">PromCon</a>
												).
											</li>
											<li>
												The first-ever
												<a href="https://events.linuxfoundation.org/events/kubecon-cloudnativecon-north-america-2018/co-located-events/#envoycon">EnvoyCon</a>
												, which was held on December 10,
												2018, in Seattle as part of the
												KubeCon + CloudNativeCon
												<a href="https://events.linuxfoundation.org/events/kubecon-cloudnativecon-north-america-2018/">Community
													Events Day</a>
												, sold out weeks in advance with
												350 attendees.
											</li>
											<li>
												CNCF hosted and gathered
												sponsors for
												<a href="https://promcon.io/">PromCon
													2018</a>
												.
											</li>
										</ul>
									</div>
									<div class="right-wrp">
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/46307731422_cfe0673716_k.jpg" alt="">
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/promcon-1.jpg" alt="">
									</div>
									<hr class="pink-blue-line">
									<h3 class="margin-top-large">Documentation,
										Websites And Blogs
									</h3>
									<div class="cols">
										<ul>
											<li>
												Migrated Kubernetes community
												website
												<a href="https://github.com/kubernetes/website/pull/8316">infrastructure</a>
												from Jekyll to Hugo
											</li>
											<li>
												Added Kubernetes blog
												contribution
												<a href="https://github.com/kubernetes/website/pull/7646">guidelines</a>
											</li>
											<li>Contributed several guide-style
												documents to the Prometheus
												website regarding security
												(using Prometheus with SSL and
												basic auth, using Prometheus to
												monitor Docker containers,
												file-based service discovery,
												and more)
											</li>
											<li>
												Migrated the K8s blog to GitHub
												(from
												<a href="https://github.com/kubernetes/website/pull/7247">blogspot</a>
												)
											</li>
											<li>
												Designed the
												<a href="https://www.jaegertracing.io/">Jaeger
													website</a>
												and docs from scratch
											</li>
											<li>
												Successfully migrated the
												current
												<a href="https://opentracing.io/">OpenTracing
													website</a>
												from GitBook to Hugo, with a
												revamped aesthetic and inclusion
												of the OpenTracing
												specification, and set up an
												OpenTracing + OpenCensus meeting
												to resolve conflicts amongst
												communities
											</li>
											<li>
												Designed the
												<a href="https://vitess.io/">TikV
													project</a>
												website and docs from scratch
											</li>
											<li>
												Authored a
												<a href="https://www.cncf.io/blog/2018/10/24/grpc-web-is-going-ga/">blog
													post</a>
												for the gRPC-Web GA release
											</li>
											<li>
												Modernized the
												<a href="https://github.com/containerd/containerd/pull/2342">website
													build process</a>
												for containerd
											</li>
											<li>
												Helped craft a new non-technical
												contributor’s guide for
												Kubernetes (see
												<a href="https://kubernetes.io/blog/2018/10/04/introducing-the-non-code-contributors-guide/">blog</a>
												)
											</li>
											<li>
												<a href="https://kubernetes.cn/">kubernetes.cn</a>
												now offers a CDN of
												kubernetes.io content inside the
												Great Firewall
											</li>
										</ul>
									</div>
								</div>
								<hr class="pink-blue-line">
								<div class="project-container">
									<h3>Localization</h3>
									<ul>
										<li>
											Coordinated 3 new translation
											projects:
											<a href="https://github.com/kubernetes/kubernetes-docs-zh">Chinese</a>
											,
											<a href="https://github.com/kubernetes/kubernetes-docs-ja">Japanese</a>
											, and
											<a href="https://github.com/kubernetes/kubernetes-docs-ko">Korean</a>
										</li>
										<li>
											Established guidelines and standards
											for
											<a href="https://kubernetes.io/docs/contribute/localization/">localization</a>
											and branching strategy
										</li>
									</ul>
									<h3 class="margin-top-large">IT Support and
										Training
									</h3>
									<div class="cols">
										<ul>
											<li>
												Onboarded
												<a href="https://github.com/kubernetes/website/blob/master/OWNERS">4
													new maintainers and 2 new
													reviewers</a>
												for SIG Docs
											</li>
											<li>
												Organized site maintainers into
												<a href="https://github.com/kubernetes/website/wiki/PR-Wranglers">shifts
													for PR wrangling</a>
												to make sure that open PRs
												receive constant review for SIG
												Docs
											</li>
											<li>Trained a new SIG-PM subproject
												chair and a Kubernetes 1.12
												features lead
											</li>
											<li>6 doc sprints (IBM Index,
												KubeCon + CloudNativeCon EU,
												Write the Docs Portland, Write
												the Docs Cincinnati, KubeCon +
												CloudNativeCon Shanghai, KubeCon
												+ CloudNativeCon NA)
											</li>
											<li>Cost support for
												discuss.kubernetes.io
											</li>
											<li>Funded Kubernetes Storage SIG
												F2F
											</li>
											<li>Hired a documentation contractor
												to improve docs for Fluentd
											</li>
											<li>Supported the Github costs for
												NATS
											</li>
											<li>Supported sticker costs for Helm
												maintainers and at events
											</li>
											<li>Set up and supported PagerDuty
												costs for incident management
											</li>
											<li>Funded the KataCoda training
												course with an introduction
												course (NGINX &gt; Envoy)
											</li>
											<li>
												Set up and funded
												<a href="https://github.com/kubernetes/steering/issues/72">OpsGenie</a>
												for incident management
											</li>
										</ul>
									</div>
									<div class="wrp-chart margin-top">
										<div class="chart">
											<h4>CNCF Service Desk Request Burn
												Up Chart
											</h4>
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/burn-up-chart-02.svg" alt="">
										</div>
										<p>
								 To improve access to the above type of activities and services for projects, the
								 <a href="https://servicedesk.cncf.io/">CNCF Service Desk</a>
								 serves as a single access point for all CNCF services. If you’re a CNCF project maintainer, all you have to do is visit
								 <a href="https://servicedesk.cncf.io">https://servicedesk.cncf.io</a>
								 or email
								 <a href="mailto:servicedesk@cncf.io">servicedesk@cncf.io</a>
								 to request support.
							  </p>
									</div>
								</div>
							</section>
							<section id="community-engagement" class="community-engagement">
								<h2>Community Engagement</h2>
								<div class="community-container">
									<div class="cols">
										<p>Education, inclusion, and collaboration are vital to the future of the cloud native ecosystem.</p>
										<p>
								 Part of supporting the continued development of this amazing community is making sure that everyone who wants to participate feels welcome to do so regardless of gender, gender identity, sexual orientation, disability, race, ethnicity, age, religion, or economic status. While having more female speakers at
								 <a href="https://events.linuxfoundation.org/events/kubecon-cloudnativecon-north-america-2018/">KubeCon + CloudNativeCon Seattle</a>
								 was an important step forward, there were a number of other activities that brought together the diversity of the cloud native community: speed networking and mentoring, the diversity lunch, sessions on building a community through Meetups, and KubeCon + CloudNativeCon diversity scholarships.
							  </p>
										<p>
								 CNCF’s diversity program offered scholarships to 147 recipients from traditionally underrepresented and/or marginalized groups to attend
								 <a href="https://events.linuxfoundation.org/events/kubecon-cloudnativecon-north-america-2018/">KubeCon + CloudNativeCon Seattle</a>
								 . These scholarships cover both the cost of the ticket as well as airfare and lodging. The $300,000 for Seattle, the largest investment made by a conference in diversity, was mainly contributed by CNCF, along with donations from Aspen Mesh, MongoDB, Twistlock, Two Sigma, and VMware. Including Seattle, CNCF has to date offered more than 485 diversity scholarships to attend KubeCon + CloudNativeCon events.
							  </p>
										<p>
								 CNCF collaborated with the Kubernetes mentoring program to offer networking opportunities for mentees at
								 <a href="http://www.kubecon.io/">KubeCon + CloudNativeCon</a>
								 . 66 mentors and 180 mentees participated in this program in Seattle.
							  </p>
									</div>
									<div class="big-data">
										<strong>147</strong>
										<span>Scholarship Recipients In Seattle
											From Traditionally Underrepresented
											Groups</span>
									</div>
									<div class="big-data">
										<strong>485</strong>
										<span>Diversity Scholarships to attend
											Kubecon + CloudNativeCon Events To
											Date</span>
									</div>
									<div class="big-data bigger">
										<div class="left-wrp">
											<strong>$300,000</strong>
											<span>The Largest Investment Made By
												A Conference For
												Diversity</span>
										</div>
										<div class="right-wrp">
											<span>Donated Mainly By:</span><br>
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/cncf-logo.png" alt="" class="main-logo">
											<br>
											<span>Along With
												Donations From:</span>
											<span class="donators-wrp">
												<figure>
													<img src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/aspen-mesh.svg" alt="">
												</figure>
												<figure>
													<img src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/mongodb-01.svg" alt="">
												</figure>
												<figure>
													<img src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/twistlock.svg" alt="">
												</figure>
												<figure>
													<img src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/Two-Sigma.svg" alt="">
												</figure>
												<figure>
													<img src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/vmware.svg" alt="">
												</figure>
											</span>
										</div>
									</div>
								</div>
							</section>
							<section id="community-awards" class="community-awards">
								<hr class="pink-blue-line">
								<div class="community-container">
									<h2 class="margin-top-large">Community
										Awards
									</h2>
									<div class="left-wrp bigger">
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/44488188240_3cde6a8338_k.jpg" alt="">
									</div>
									<div class="right-wrp">
										<p>For the third year in a row, the CNCF Community Awards, sponsored by VMware, highlighted the most active ambassador and top contributor across all CNCF projects.</p>
										<ul>
											<li>
												<strong>Top Cloud Native
													Committer</strong>
												– an individual with incredible
												technical skills and notable
												technical achievements in one or
												multiple CNCF projects. The 2018
												recipient was Jordan Liggitt.
											</li>
											<li>
												<strong>Top Cloud Native
													Ambassador</strong>
												– an individual with incredible
												community-oriented skills,
												focused on spreading the word
												and sharing knowledge with the
												entire cloud native community or
												within a specific project. The
												2018 recipient was Michael
												Hausenblas.
											</li>
										</ul>
									</div>
									<div class="left-wrp">
										<p>It is essential not to overlook the individuals who give countless hours of their time to complete often mundane tasks, so CNCF created the Chop Wood/Carry Water awards. It was a proud moment for the cloud native community as CNCF recognized the tireless efforts of 14 individuals for their outstanding contributions from the past year: April Kyle Nassi, Babak “Bobby” Salamat, Christoph Blecker, Davanum Srinivas, Dianne Mueller, Jorge Castro, Kris Nova, Nikhita Raghunath, Paris Pittman, Reinhard Nagele, Richard Hartmann, Stephen Augustus, Tim Pepper, and Zach Arnold.</p>
									</div>
									<div class="right-wrp bigger">
										<figure>
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/community-1.jpg">
											<figcaption>Davanum Srinivas
											</figcaption>
										</figure>
										<figure>
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/community-2.jpg">
											<figcaption>Davanum Srinivas
											</figcaption>
										</figure>
										<figure>
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/community-3.jpg">
											<figcaption>Christoph Blecker
											</figcaption>
										</figure>
										<figure>
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/community-4.jpg">
											<figcaption>Nikhita Raghunath
											</figcaption>
										</figure>
										<figure>
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/community-5.jpg">
											<figcaption>Paris Pittman
											</figcaption>
										</figure>
										<figure>
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/community-6.jpg">
											<figcaption>Richard Hartmann
											</figcaption>
										</figure>
										<figure>
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/community-7.jpg">
											<figcaption>Tim Pepper</figcaption>
										</figure>
										<figure>
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/community-8.jpg">
											<figcaption>Stephen Augustus
											</figcaption>
										</figure>
										<figure>
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/community-9.jpg">
											<figcaption>Kris Nova</figcaption>
										</figure>
										<figure>
											<img src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/community-10.jpg">
											<figcaption>Zach Arnold</figcaption>
										</figure>
										<figure>
											<img src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/community-11.jpg">
											<figcaption>Reinhard Nagele
											</figcaption>
										</figure>
										<figure>
											<img src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/community-12.jpg">
											<figcaption>Babak “Bobby” Salamat
											</figcaption>
										</figure>
										<figure>
											<img src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/community-13.jpg">
											<figcaption>Jorge Castro
											</figcaption>
										</figure>
										<figure>
											<img src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/community-14.jpg">
											<figcaption>April Kyle Nassi
											</figcaption>
										</figure>
									</div>
								</div>
							</section>
							<section id="cncf-meetup" class="cncf-meetup" style="background-image:url('/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/cncf-meetups-bg.png');">
								<hr class="pink-blue-line">
								<h2>CNCF MEETUPS</h2>
								<div class="meetup-container">
									<p>
							  CNCF supported more than 160
							  <a href="https://meetups.cncf.io/">meetup</a>
							  groups in 38 countries, which have hosted more than 1,600 events and include more than 80,000 members. In 2018, we experienced a 60% increase in CNCF meetup members.
						   </p>
									<div class="big-data">
										<strong>160</strong>
										<span>Meetup Groups</span>
									</div>
									<div class="big-data">
										<strong>1600</strong>
										<span>Events</span>
									</div>
									<div class="big-data">
										<strong>80,000</strong>
										<span>Members</span>
									</div>
									<div class="big-data">
										<strong>60%</strong>
										<span>Increase in 2018</span>
									</div>
									<div class="wrp-chart">
										<div class="chart">
											<h3>CNCF Meetup Member Growth</h3>
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/meetup-chart-revised-01.svg" alt="">
										</div>
									</div>
								</div>
							</section>
							<section id="cncf-ambassador-program" class="cncf-ambassador-program">
								<div class="community-container">
									<h2>CNCF Ambassador Program</h2>
									<div class="cols">
										<p>
								 The CNCF community spans the world through our contributors, members, meetups, and ambassadors. We boast more than
								 <a href="https://all.devstats.cncf.io/d/8/dashboards?refresh=15m">45,000 contributors</a>
								 to our CNCF projects, and we have 65
								 <a href="https://www.cncf.io/people/ambassadors/">CNCF Ambassadors</a>
								 worldwide educating the world on cloud native technologies and best practices.
							  </p>
										<p>
								 We accepted 47 new CNCF ambassadors and provided financial support for ambassador-run meetups in 2018. Our vibrant community of successful ambassadors is comprised of developers, bloggers, influencers, and evangelists already engaged with a CNCF project in some way including contributing to development, online groups, and community events. We are excited to have this worldwide group of people with diverse interests, experiences, and technical backgrounds help drive local and global cloud native communities. Please check out the
								 <a href="https://www.youtube.com/playlist?list=PLj6h78yzYM2OaNjjefJi5UnN9KQt8Q0qf">video interviews</a>
								 with several of our CNCF ambassadors or
								 <a href="https://www.cncf.io/blog/2018/09/07/meet-the-cncf-ambassadors/">read</a>
								 about them.
							  </p>
									</div>
									<div class="data-wrp">
										<div class="big-data">
											<strong>65</strong>
											<span>Number Of Ambassadors</span>
										</div>
										<div class="big-data">
											<strong>50</strong>
											<span>Companies Represented</span>
										</div>
										<div class="big-data">
											<strong>15</strong>
											<span>Countries Represented</span>
										</div>
									</div>
									<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/cncf-ambassador-picture.png" alt="">
								</div>
							</section>
							<section id="phippy-and-friends-joined-cncf-family" class="phippy-and-friends-joined-cncf-family">
								<hr class="pink-blue-line">
								<div class="community-container">
									<h2>Phippy And Friends Joined CNCF Family
									</h2>
									<div class="cols">
										<p>
								 In 2016,
								 <a href="http://deis.io/">Deis</a>
								 (now part of Microsoft) Platform Architect Matt Butcher was looking for a way to explain Kubernetes to technical and non-technical people alike. Inspired by his daughter’s prolific stuffed animal collection, he came up with the idea of
								 <em>
								 <a href="https://www.cncf.io/phippy/the-childrens-illustrated-guide-to-kubernetes/">The Illustrated Children’s Guide to Kubernetes</a>
								 </em>
								 . Thus Phippy, the yellow giraffe and PHP application, along with her friends, were born.
							  </p>
										<p>
								 On the keynote stage during Day 1 of the
								 <a href="https://events.linuxfoundation.org/events/kubecon-cloudnativecon-north-america-2018/">KubeCon + CloudNativeCon Seattle</a>
								 conference, Matt and co-author Karen Chu announced
								 <a href="https://www.cncf.io/blog/2018/12/11/phippy-comes-to-cncf/">Microsoft’s donation of Phippy to CNCF</a>
								 and presented the official sequel in their live reading of
								 <em>Phippy Goes to the Zoo: A Kubernetes Story</em>
								 . As part of Microsoft’s donation of both books and the characters, CNCF has licensed all of this material under the Creative Commons Attribution License (CC-BY), is available to remix, transform, and build upon the material for any purpose, even commercially. See
								 <a href="https://phippy.io/">phippy.io</a>
								 for more information.
							  </p>
									</div>
									<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/phippy-screenshot.png" alt="" class="screenshot">
									<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/phippy-color-01.svg" alt="" class="illustration">
								</div>
							</section>
							<section id="ecosystem-tools" class="ecosystem-tools">
								<h2>Ecosystem Tools</h2>
								<div class="ecosystem-container">
									<h3>DEVSTATS</h3>
									<p>
							  CNCF developed
							  <a href="https://k8s.devstats.cncf.io/">DevStats</a>
							  starting in mid-2017 in response to requests from the Kubernetes Steering Committee and SIG-Contributor Experience to provide insight into how Kubernetes was dealing with nearly unprecedented growth. (It’s the second-largest community in open source, behind only Linux.) The tool, which is open source, downloads several terabytes of
							  <a href="https://www.gharchive.org/">data</a>
							  representing every public GitHub action of the last 5 years, throws out nearly all of it except for the ~100 repos of CNCF-hosted projects, processes the data and stores it in a
							  <a href="https://www.postgresql.org/">Postgres</a>
							  database, and then displays it using
							  <a href="https://grafana.com/">Grafana</a>
							  dashboards. DevStats now covers all CNCF-hosted projects and downloads updated data every hour. More recently, we have been iterating on several versions of a project status
							  <a href="https://all.devstats.cncf.io/d/53/projects-health?orgId=1">dashboard</a>
							  based on feedback from the TOC and project maintainers.
						   </p>
									<div class="dev-stats-data">
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/pastedImage0.png" alt="">
										<p class="margin-top">DevStats is one of the most powerful visualization tools available for understanding contributions to open source software. It is also a testament to the power of open source development, as CNCF developer Lukasz Gryglicki remains very responsive to suggestions and pull requests that provide additional insights into the development of CNCF’s hosted projects.</p>
									</div>
								</div>
							</section>
							<section id="cncf-landscape-and-cloud-native-trail-map" class="cncf-landscape-and-cloud-native-trail-map">
								<hr class="pink-blue-line">
								<div class="ecosystem-container">
									<h2>CNCF Landscape And Cloud Native Trail
										Map
									</h2>
									<p>
							  The CNCF Cloud Native
							  <a href="https://landscape.cncf.io/">Landscape</a>
							  is intended as a map through the previously uncharted terrain of cloud native technologies. The landscape started in November 2016 as a static image of fewer than 100 projects and products. It has grown through the power of collaborative editing to track more than 600 items and now includes a
							  <a href="https://landscape.cncf.io/serverless">serverless</a>
							  landscape. The project has more than 4,000 stars on GitHub.
						   </p>
									<p>
							  In March 2018, CNCF released the Cloud Native
							  <a href="https://landscape.cncf.io/">Landscape</a>
							  2.0, an interactive version that allows viewers to filter, obtain detailed information on a specific project or technology, and easily share via stateful URLs. The interactive landscape is open source with the data stored in a
							  <a href="https://github.com/cncf/landscape/blob/master/landscape.yml">yaml</a>
							  file. Every night, a server downloads updated GitHub data, financing information from Crunchbase, market cap data from Yahoo Finance, and CII
							  <a href="https://bestpractices.coreinfrastructure.org/en">Best Practices</a>
							  Badge information.
						   </p>
									<div class="landscape-image">
										<a href="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/landscape.png">
											<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/landscape.png" alt="" width="1719" height="1025"></a>
									</div>
									<div class="trail-map margin-top-large">
										<div> <a href="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/CNCF_TrailMap_latest.png">
												<img loading="lazy" class="" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/CNCF_TrailMap_latest.png" alt="" width="884" height="1025"></a>
										</div>
										<div>
											<p>
									In response to feedback that the landscape presents an overwhelming number of options, CNCF released the
									<a href="https://raw.githubusercontent.com/cncf/trailmap/master/CNCF_TrailMap_latest.png">Cloud Native Trail Map</a>
									, which provides an overview for enterprises starting their cloud native journey. While there are innumerable routes for deploying a cloud native application, CNCF projects represent a particularly well-traveled, tested, and trusted path.
								 </p>
											<p>No matter the exact path each organization chooses to travel on its way to becoming cloud native, the goal of these new interactive and introductory guides is to help a company progress on its cloud native journey.</p>
										</div>
									</div>
								</div>
							</section>
							<section id="style-guide-and-logos" class="style-guide-and-logos">
								<hr class="pink-blue-line">
								<div class="ecosystem-container">
									<h2>Style Guide And Logos</h2>
									<p>
							  We are excited to share the
							  <a href="https://github.com/cncf/foundation/blob/master/style-guide.md">CNCF Style Guide</a>
							  with the community. We published the style guide last year to help establish a consistent format for writing about cloud native technologies.
						   </p>
									<p>
							  CNCF also maintains a
							  <a href="https://github.com/cncf/artwork/">repository</a>
							  of project logos in standard formats, shapes, and colors. There are 3 formats (PNG/SVG/AI), 3 layouts – horizontal (also known as landscape format), stacked (which is closer to square), and icon (which does not include the name and is square) – and 3 versions (color/black/white), which results in 27 versions of each logo.
						   </p>
									<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/project-logos-04.svg" alt="">
								</div>
							</section>
							<section id="test-conformance-projects" class="test-conformance-projects">
								<h2>Test Conformance Projects</h2>
								<div class="conformance-projects-container">
									<p>
							  The
							  <a href="https://www.cncf.io/certification/software-conformance/">Certified Kubernetes</a>
							  software conformance program relies on the open source conformance tests included in each version of Kubernetes. However, these tests are not as comprehensive as the community would like, as they don’t yet cover all stable APIs. CNCF has been investing in test development to add conformance tests, particularly for portions of the API that get heavily exercised by different Kubernetes implementations. Philosophically, CNCF generally avoids hiring engineers because we don’t want to compete with our members. We made an exception in this case to try to address some of the technical debt of having features in the stable API without corresponding conformance tests.
						   </p>
									<p>
							  In 2018, CNCF negotiated a software development contract with a well-regarded test development company, Globant, to have 2 engineers work full-time on conformance test development. All tests are submitted as PRs and approved through the normal SIG-Testing review process and with approval from SIG-Architecture. Additionally, after
							  <a href="https://lists.cncf.io/g/cncf-k8s-conformance/message/358">consultation</a>
							  with CNCF staff, SIGArchitecture promulgated a new
							  <a href="https://github.com/kubernetes/community/pull/1806/files">requirement</a>
							  that new features in Kubernetes require conformance tests before becoming part of the
							  <a href="https://kubernetes.io/docs/reference/using-api/deprecation-policy/">stable API</a>
							  . Thus, this test development is intended to focus on paying off the past technical debt rather than an indefinite, ongoing commitment of resources.
						   </p>
									<div class="left-wrp">
										<h3>Apisnoop</h3>
										<p>
								 <a href="https://apisnoop.cncf.io/">APISnoop</a>
								 is being developed by CNCF-funded contractors to help measure the usage of the Kubernetes API by different applications. An initial goal is to provide a useful indicator as to which Kubernetes APIs are used the most and don’t yet have conformance tests. This ensures we are testing APIs that are relevant. The output below is one visualization of how API groups’ endpoints and verbs are used today.
							  </p>
									</div>
									<div class="right-wrp">
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/diagram3-2-1.jpg" alt="">
									</div>
								</div>
							</section>
							<section id="international-china" class="international-china" style="background-image: url('/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/end-user-bg.png')">
								<h2>International: China</h2>
								<div class="china-container">
									<div class="left-wrp">
										<div class="data-wrp">
											<div class="big-data">
												<strong>34,000+</strong>
												<span>Huawei Project
													Contributions</span>
											</div>
											<div class="big-data">
												<strong>32,000+</strong>
												<span>Pingcap Project
													Contributions</span>
											</div>
											<div class="big-data">
												<strong>3</strong>
												<span>CNCF Projects Were Born In
													China</span>
											</div>
										</div>
										<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/pasted-image-0.jpg" alt="">
									</div>
									<div class="right-wrp">
										<p>CNCF’s first ever conference in China, KubeCon + CloudNativeCon Shanghai in November 2018, exceeded our expectations for serving as a bridge between open source developers in China and the rest of the world. More than 17% of attendees were from outside China, enabling two-way communication about new development and best practices for cloud native computing.</p>
										<p>
								 Among Chinese contributors to CNCF-hosted projects, Huawei and PingCAP led the way with
								 <a href="https://all.devstats.cncf.io/d/5/companies-summary?orgId=1">34,000 and 32,000</a>
								 contributions, respectively, and are the fifth- and sixth-largest contributors overall. We also now host 3 CNCF projects that were born in China:
								 <a href="https://github.com/dragonflyoss/Dragonfly">Dragonfly</a>
								 (Alibaba),
								 <a href="https://github.com/goharbor/harbor">Harbor</a>
								 (VMware China), and
								 <a href="https://github.com/tikv/tikv">TiKV</a>
								 (PingCAP).
							  </p>
										<p>
								 We’re excited to build on this success by hosting
								 <a href="https://www.cncf.io/community/kubecon-cloudnativecon-events/">KubeCon + CloudNativeCon + Open Source Summit</a>
								 in Shanghai June 24-26, 2019.
							  </p>
									</div>
								</div>
							</section>
							<section id="happy-birthday-cncf" class="happy-birthday-cncf">
								<h2>Happy Birthday CNCF!</h2>
								<div class="birthday-container">
									<blockquote>Happy Birthday CNCF!
									</blockquote>
									<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/unnamed.png" alt="">
								</div>
							</section>
							<section id="looking-forward" class="looking-forward">
								<h2>Looking Forward To 2019</h2>
								<div class="looking-forward-container">
									<p class="forward-larger">Quite possibly, no software foundation has ever had a more successful year than CNCF did in 2018. The success of CNCF is directly attributable to the contributions and support of member companies,
							  developer
							  community, and end users. We are very grateful for that.
						   </p>
									<p>
							  CNCF is committed to
							  <strong>fostering and sustaining an ecosystem</strong>
							  of open source, vendor-neutral projects by democratizing state-of-the-art patterns to make technology accessible for everyone.
						   </p>
									<p>
							  Through initiatives like conformance test development, documentation improvements, and security audits, we are reinvesting the proceeds from membership and conferences into making the
							  <strong>cloud native platform more reliable</strong>
							  .
						   </p>
									<p>
							  Our core strategy in 2019 is to stay focused on the
							  <strong>developer community</strong>
							  who are the heart and soul of the
							  cloud native
							  ecosystem. We are eager to assist developers, particularly from
							  end user
							  organizations, progress into new roles like contributor and maintainer.
						   </p>
									<p>
							  In 2019, we will also focus on
							  <strong>increased engagement</strong>
							  with end users to ensure their voices are represented, their feedback is acted upon, and their organizations are set up for successfully adopting
							  cloud native.
						   </p>
									<p>
							  Our
							  <strong>flagship events</strong>
							  <a href="http://www.kubecon.io/">KubeCon + CloudNativeCon</a>
							  will continue to bring together the community and create opportunities for collaboration. We expect our three events –
							  <a href="https://events.linuxfoundation.org/events/kubecon-cloudnativecon-europe-2019/">Barcelona </a>
							  (May 20-23),
							  <a href="https://events.linuxfoundation.cn/events/kubecon-cloudnativecon-china-2019/">Shanghai</a>
							  (June 24-26), and
							  <a href="https://events.linuxfoundation.org/events/kubecon-cloudnativecon-north-america-2019/">San Diego</a>
							  (November 18-21) – to be the best yet. We will help CNCF projects accelerate to reach critical mass and achieve their maximum potential. We will also continue
							  <strong>investing</strong>
							  in new markets like
							  <strong>China and India</strong>
							  that are embracing cloud native and open source technologies at a phenomenal rate. Our first
							  <a href="https://events.linuxfoundation.org/events/kubernetes-day-india-2019/">Kubernetes Day</a>
							  event will be in Bengaluru on March 23.
						   </p>
									<p>
							  Another major focus of 2019 will be helping expand
							  cloud native
							  technologies to telcos. We will be demonstrating how they can evolve their Virtual Network Functions (VNFs) architectures into Cloud Native Network Functions (CNFs) running on Kubernetes.
						   </p>
									<p>
							  2018 was a stellar year for CNCF. We are well-positioned both financially and organizationally to continue our
							  <strong>mission</strong>
							  to make
							  <strong>cloud native computing ubiquitous</strong>
							  . We look forward to having you join us on this journey as we plan for a blockbuster 2019.
						   </p>
									<p>
							  <em>Dee Kumar, Vice President, Marketing, CNCF</em>
						   </p>
								</div>
							</section>
							<section id="contact_us" class="contact_us-section" style="background-image: url('/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/banner-home.jpg')">
								<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2018/logo-CNCF.png">
								<ul class="detail">
									<li>
										<a href="https://www.cncf.io">cncf.io</a>
									</li>
									<li>415-723-9709</li>
									<li>1 Letterman Drive, Suite D4700</li>
									<li>San Francisco, CA 94129</li>
									<li>United States</li>
								</ul>
							</section>
							<hr class="pink-blue-line">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php

	wp_enqueue_script(
		'annual-report-js',
		get_template_directory_uri() . '/source/js/on-demand/annual-report-pre-2020.js',
		array( 'jquery' ),
		filemtime( get_template_directory() . '/source/js/on-demand/annual-report-pre-2020.js' ),
		true
	);

	get_template_part( 'components/footer' );
