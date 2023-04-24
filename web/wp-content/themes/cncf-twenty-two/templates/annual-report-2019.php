<?php
/**
 * Template Name: Annual Report 2019
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
	href="<?php echo esc_url( get_template_directory_uri() . '/build/annual-report-2019.min.css' ); ?>"
	as="style" crossorigin="anonymous" />

	<?php

	wp_enqueue_style( '2019', get_template_directory_uri() . '/build/annual-report-2019.min.css', array(), filemtime( get_template_directory() . '/build/annual-report-2019.min.css' ), 'all' );

	?>

<div id="fakebody">
	<div id="ajax-content-wrap">
		<div class="container-wrap">
			<div class="background-image-wrapper intro-2019">
				<figure class="background-image-figure">
					<img loading="eager" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/report-bg2-01-scaled.jpg" alt="">
				</figure>
				<div class="background-image-text-overlay logo-2019-max">
					<div class="logo-2019-container">
						<img loading="eager" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/image1logo-01.svg" alt="" class="logo-2019">
					</div>
				</div>
			</div>

		 <div class="container-wrap">
			<div class="container wrap" style="margin-top: 2rem">
			   <div>
				  <div class="wp-block-buttons aligncenter is-style-button-pdf">
					 <div class="wp-block-button"><a class="wp-block-button__link" href="https://www.cncf.io/wp-content/uploads/2020/08/CNCF-Annual-Report-2019.pdf">DOWNLOAD THIS REPORT</a></div>
				  </div>
			   </div>
			</div>
		 </div>

			<div class="container main-content">
				<div class="row">
					<div id="fws_5f3e995e10865" data-midnight="dark" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row standard_section" style="padding-top: 0px; padding-bottom: 0px; ">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg  using-bg-color  " style="background-color: #eeeeee; "></div>
							</div>
							<div class="row-bg-overlay"></div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-12 wpb_column column_container vc_column_container col centered-text padding-1-percent" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="left-right" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="nectar-gradient-text" data-direction="horizontal" data-color="extra-color-gradient-1" style="margin-top: 17px; margin-bottom: 17px; line-height:100% !important; ">
											<h2>Table of Contents</h2>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="wpb_row vc_row-fluid vc_row standard_section">
						<div class="col span_12 dark left">
							<div class="wpb_column column_container vc_column_container col no-extra-padding">
								<div class="toc-cols">
									<div class="wpb_wrapper">
										<h4 style="font-size: 1.2em;">
											<a href="#who">Who We
												Are</a>
											<br>
											<a href="#expanding">We Are
												Expanding</a>
											<br>
											<a href="#membership">Membership</a>
											<br>
											<a href="#end-user">End User
												Community</a>
											<br>
											<a href="#conferences">Conferences
												and Events</a>
											<br>
											<a href="#wellness">Wellness
												Activities</a>
										</h4>
									</div>
									<div class="wpb_wrapper">
										<h4 style="font-size: 1.2em;">
											<a href="#training">Training
												and
												Certification</a>
											<br>
											<a href="#updates">Project
												Updates and
												Satisfaction</a>
											<br>
											<a href="#maturity">Project
												Maturity Levels</a>
											<br>
											<a href="#survey">CNCF
												Project
												Maintainer Survey
												Results</a>
											<br>
											<a href="#releases">Project
												Updates and Releases</a>
											<br>
											<a href="#services">Services
												and
												Assistance for
												Projects</a>
										</h4>
									</div>
									<div class="wpb_wrapper">
										<h4 style="font-size: 1.2em;">
											<a href="#desk">CNCF Service
												Desk</a>
											<br>
											<a href="#engagement">Community
												Engagement</a>
											<br>
											<a href="#community-awards">Community
												Awards</a>
											<br>
											<a href="#meetups">CNCF
												Meetups</a>
											<br>
											<a href="#kubernetes">Kubernetes
												Community Days</a>
											<br>
											<a href="#ambassador">CNCF
												Ambassador Program</a>
										</h4>
									</div>
									<div class="wpb_wrapper">
										<h4 style="font-size: 1.2em;">
											<a href="#mentoring">Community
												Mentoring and
												Internships</a>
											<br>
											<a href="#ecosystem">Ecosystem
												Tools</a>
											<br>
											<a href="#landscape">CNCF
												Landscape and Cloud
												Native
												Trail Map</a>
											<br>
											<a href="#audits">CNCF
												Security
												Audits</a>
											<br>
											<a href="#china">Growth in
												China</a>
											<br>
											<a href="#2020">Looking
												Forward
												to 2020</a>
										</h4>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="who" data-midnight="dark" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row standard_section" style="padding: 20px 0px;">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap using-image">
								<div class="row-bg using-image" style="background-image: url(/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/image1-01.jpg); background-position: left top; background-repeat: no-repeat; ">
								</div>
							</div>
							<div class="row-bg-overlay" style="background: #2825f2; background: linear-gradient(90deg,#2825f2 0%,#e50994 100%);  opacity: 0.8; ">
							</div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-12 wpb_column column_container vc_column_container col centered-text padding-8-percent" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="divider-wrap" data-alignment="default">
											<div style="height: 35px;" class="divider"></div>
										</div>
										<div id="fws_5f3e995e12466" data-midnight="" data-column-margin="default" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row inner_row standard_section" style="padding-top: 0px; padding-bottom: 0px; ">
											<div class="row-bg-wrap">
												<div class="row-bg">
												</div>
											</div>
											<div class="col span_12  left">
												<div class="vc_col-sm-3 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-shadow="none" data-border-radius="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
													<div class="column-bg-overlay">
													</div>
													<div class="vc_column-inner">
														<div class="wpb_wrapper">
														</div>
													</div>
												</div>
												<div class="vc_col-sm-6 wpb_column column_container vc_column_container col centered-text no-extra-padding" data-t-w-inherits="default" data-shadow="none" data-border-radius="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
													<div class="column-bg-overlay">
													</div>
													<div class="vc_column-inner">
														<div class="wpb_wrapper">
															<div class="img-with-animation-wrap " data-max-width="100%" data-border-radius="none">
																<div class="inner">
																	<img loading="lazy" data-shadow="none" data-shadow-direction="middle" data-delay="0" height="378" width="1105" data-animation="none" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/welcome-02.svg" alt="">
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="vc_col-sm-3 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-shadow="none" data-border-radius="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
													<div class="column-bg-overlay">
													</div>
													<div class="vc_column-inner">
														<div class="wpb_wrapper">
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="wpb_text_column wpb_content_element ">
											<div class="wpb_wrapper">
												<h3 style="text-align: center;">
													<strong>
														<span style="color: #ffffff;">
															Welcome to the 2019
															<a style="color: #ffffff;" href="https://www.cncf.io" rel="noopener noreferrer">Cloud
																Native Computing
																Foundation</a>
															annual report.
															Comments
															and feedback are
															welcome
															at info@cncf.io.
														</span>
													</strong>
												</h3>
											</div>
										</div>
										<div class="divider-wrap" data-alignment="default">
											<div style="height: 35px;" class="divider"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="geographic-diversity-of-contributors" data-midnight="dark" data-top-percent="1%" data-bottom-percent="1%" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row standard_section" style="margin-top: 50px;">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg"></div>
							</div>
							<div class="row-bg-overlay" style="background: #e50994; background: linear-gradient(90deg,#e50994 0%,#2825f2 100%);  opacity: 1; ">
							</div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-12 wpb_column column_container vc_column_container col centered-text padding-2-percent" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="left-right" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div id="fws_5f3e995e130e0" data-midnight="" data-column-margin="default" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row inner_row standard_section" style="padding-top: 0px; padding-bottom: 0px; ">
											<div class="row-bg-wrap">
												<div class="row-bg">
												</div>
											</div>
											<div class="col span_12  left">
												<div class="vc_col-sm-4 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-shadow="none" data-border-radius="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
													<div class="column-bg-overlay">
													</div>
													<div class="vc_column-inner">
														<div class="wpb_wrapper">
														</div>
													</div>
												</div>
												<div class="vc_col-sm-4 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-shadow="none" data-border-radius="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
													<div class="column-bg-overlay">
													</div>
													<div class="vc_column-inner">
														<div class="wpb_wrapper">
															<div class="img-with-animation-wrap " data-max-width="100%" data-border-radius="none">
																<div class="inner">
																	<img loading="lazy" data-shadow="none" data-shadow-direction="middle" data-delay="0" height="91" width="440" data-animation="fade-in" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/who-01.svg" alt="">
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="vc_col-sm-4 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-shadow="none" data-border-radius="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
													<div class="column-bg-overlay">
													</div>
													<div class="vc_column-inner">
														<div class="wpb_wrapper">
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="geographic-diversity-of-contributors" data-midnight="dark" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row standard_section" style="padding-top: 0px; padding-bottom: 0px; ">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg"></div>
							</div>
							<div class="row-bg-overlay"></div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-12 wpb_column column_container vc_column_container col centered-text padding-1-percent" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="wpb_text_column wpb_content_element ">
											<div class="wpb_wrapper">
												<p class="p1" style="text-align: left;">
<span class="s1">The Cloud Native Computing Foundation (CNCF) is an open source software foundation dedicated to making cloud native computing universal and sustainable. </span>
</p>
												<p style="text-align: left;">
<span class="s3">Cloud native technologies empower organizations to build and run scalable applications in modern, dynamic environments across public, private, and hybrid clouds. Containers, service meshes, microservices, immutable infrastructure, and declarative APIs exemplify the cloud native approach.</span>
</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="geographic-diversity-of-contributors" data-midnight="dark" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row standard_section" style="padding-top: 0px; padding-bottom: 0px; ">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg"></div>
							</div>
							<div class="row-bg-overlay"></div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-12 wpb_column column_container vc_column_container col centered-text padding-1-percent" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="img-with-animation-wrap " data-max-width="100%" data-border-radius="none">
											<div class="inner">
												<img loading="lazy" height="409" width="1920" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/CNCF-Annual-Report-images-01-scaled.jpg" alt="">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="geographic-diversity-of-contributors" data-midnight="dark" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row standard_section" style="padding-top: 0px; padding-bottom: 0px; ">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg"></div>
							</div>
							<div class="row-bg-overlay"></div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-12 wpb_column column_container vc_column_container col centered-text padding-1-percent" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="wpb_text_column wpb_content_element ">
											<div class="wpb_wrapper">
												<p style="text-align: left;">
We are a community of open source projects, including Kubernetes, Prometheus, Envoy, and
<a href="https://www.cncf.io/projects/">many others</a>
. Kubernetes and other CNCF projects have quickly gained adoption and won community support, becoming some of the
<a href="https://docs.google.com/presentation/d/1BoxFeENJcINgHbKfygXpXROchiRO2LBT-pzdaOFr4Zg/edit#slide=id.g39c264972c_182_493">highest velocity projects</a>
in the history of open source. CNCF employs
<a href="https://www.cncf.io/people/staff/">31 </a>
from various backgrounds and locations; 63% are women, 36% are men, and less than 1% are non-binary.
</p>
												<p style="text-align: left;">
A basic premise behind CNCF, our conferences (including
<a href="https://www.cncf.io/community/kubecon-cloudnativecon-events/">KubeCon + CloudNativeCon</a>
), and open source in general, is that interactions are positive-sum. There is no fixed amount of investment, mindshare, or development contribution allocated to specific projects. Just as open source development is based on the idea that, collectively, we are smarter than any one of us, open source foundations work for the betterment of the entire community. Equally important, a neutral home for a project and community fosters this type of positive-sum thinking and drives the growth and diversity that we believe are core elements of a successful open source project.
</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="expanding" data-midnight="dark" data-top-percent="1%" data-bottom-percent="1%" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row standard_section" style="">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg"></div>
							</div>
							<div class="row-bg-overlay" style="background: #e50994; background: linear-gradient(90deg,#e50994 0%,#2825f2 100%);  opacity: 1; ">
							</div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-12 wpb_column column_container vc_column_container col centered-text padding-2-percent">
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div id="fws_5f3e995e14943" data-midnight="" data-column-margin="default" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row inner_row standard_section" style="padding-top: 0px; padding-bottom: 0px; ">
											<div class="row-bg-wrap">
												<div class="row-bg">
												</div>
											</div>
											<div class="col span_12  left">
												<div class="vc_col-sm-3 wpb_column column_container vc_column_container col no-extra-padding">
													<div class="column-bg-overlay">
													</div>
													<div class="vc_column-inner">
														<div class="wpb_wrapper">
														</div>
													</div>
												</div>
												<div class="vc_col-sm-6 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-shadow="none" data-border-radius="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
													<div class="column-bg-overlay">
													</div>
													<div class="vc_column-inner">
														<div class="wpb_wrapper">
															<div class="img-with-animation-wrap " data-max-width="100%" data-border-radius="none">
																<div class="inner">
																	<img loading="lazy" data-shadow="none" data-shadow-direction="middle" data-delay="0" height="91" width="647" data-animation="fade-in" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/titles-02.svg" alt="">
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="vc_col-sm-3 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-shadow="none" data-border-radius="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
													<div class="column-bg-overlay">
													</div>
													<div class="vc_column-inner">
														<div class="wpb_wrapper">
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="membership" data-midnight="dark" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row standard_section" style="padding-top: 0px; padding-bottom: 0px; ">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg"></div>
							</div>
							<div class="row-bg-overlay"></div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-6 wpb_column column_container vc_column_container col centered-text no-extra-padding" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="left-right" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="divider-wrap" data-alignment="default">
											<div style="height: 20px;" class="divider"></div>
										</div>
										<div class="wpb_text_column wpb_content_element ">
											<div class="wpb_wrapper">
												<p style="text-align: left;">As CNCF celebrated its fourth birthday in 2019, it achieved greater engagement through membership growth, event attendance growth, increased end user participation, and broad industry commentary. All of this underscored the growing role of Kubernetes in the cloud computing ecosystem.</p>
												<p style="text-align: left;">
For example, Barron’s
<a href="https://outline.com/nXRmRY">declared</a>
Kubernetes as the “future” of computing and the “next big thing in cloud computing.” Barron’s explained, “Kubernetes is accelerating the transition away from legacy client-server technology by making cloud native software development easier, better, and faster.”
</p>
												<p style="text-align: left;">CNCF is at the forefront of that revolutionary transition.</p>
											</div>
										</div>
										<div class="divider-wrap" data-alignment="default">
											<div style="height: 50px;" class="divider"></div>
										</div>
										<div id="fws_5f3e995e15614" data-midnight="" data-column-margin="default" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row inner_row standard_section  vc_custom_1579527701718" style="padding-top: 0px; padding-bottom: 0px; ">
											<div class="row-bg-wrap">
												<div class="row-bg">
												</div>
											</div>
											<div class="col span_12  left">
												<div class="vc_col-sm-12 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-shadow="none" data-border-radius="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
													<div class="column-bg-overlay">
													</div>
													<div class="vc_column-inner">
														<div class="wpb_wrapper">
															<div class="nectar-gradient-text" data-direction="horizontal" data-color="extra-color-gradient-1" style="margin-top: 17px; margin-bottom: 10px; ">
																<h2>Membership
																</h2>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="divider-wrap" data-alignment="default">
											<div style="height: 15px;" class="divider"></div>
										</div>
										<div class="wpb_text_column wpb_content_element ">
											<div class="wpb_wrapper">
												<p style="text-align: left;">The CNCF ecosystem has grown rapidly across vendor and end user memberships, making CNCF one of the most successful open source foundations ever. We started the year with 345 members. Over the course of 2019, we added 173 new members, an increase of more than 50%. Our 20 Platinum members include some of the world’s largest public cloud and enterprise software companies and end users. Apple, ARM, NetApp and Palo Alto Networks all joined or upgraded to Platinum in 2019. Ant Financial, Fidelity, Equinix, and Kingsoft joined as new Gold members in 2019.</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="vc_col-sm-6 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="img-with-animation-wrap " data-max-width="100%" data-border-radius="none">
											<div class="inner">
												<img loading="lazy" data-shadow="none" data-shadow-direction="middle" data-delay="0" height="1025" width="890" data-animation="none" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/CNCF-Annual-Report-images-02-scaled.jpg" alt="">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="end-user" data-midnight="dark" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row standard_section" style="padding-top: 0px; padding-bottom: 0px; ">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg"></div>
							</div>
							<div class="row-bg-overlay"></div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-8 wpb_column column_container vc_column_container col centered-text no-extra-padding" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="left-right" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="divider-wrap" data-alignment="default">
											<div style="height: 35px;" class="divider"></div>
										</div>
										<div id="fws_5f3e995e1622b" data-midnight="" data-column-margin="default" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row inner_row standard_section  vc_custom_1579527701718" style="padding-top: 0px; padding-bottom: 0px; ">
											<div class="row-bg-wrap">
												<div class="row-bg">
												</div>
											</div>
											<div class="col span_12  left">
												<div class="vc_col-sm-12 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-shadow="none" data-border-radius="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
													<div class="column-bg-overlay">
													</div>
													<div class="vc_column-inner">
														<div class="wpb_wrapper">
															<div class="nectar-gradient-text" data-direction="horizontal" data-color="extra-color-gradient-1" style="margin-top: 17px; margin-bottom: 10px; ">
																<h2>End User
																	Community
																</h2>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="divider-wrap" data-alignment="default">
											<div style="height: 15px;" class="divider"></div>
										</div>
										<div class="wpb_text_column wpb_content_element ">
											<div class="wpb_wrapper">
												<p style="text-align: left;">
End users are defined as companies that use cloud native technologies internally, but do not sell any cloud native services externally. Companies that meet this definition are eligible to join the
<a href="https://www.cncf.io/people/end-user-community/">End User Community</a>
.
</p>
												<p style="text-align: left;">Our End User Community grew by 89% in 2019, signaling clear and intense interest in cloud native technologies. We finished 2019 with 131 companies and startups. At present, CNCF enjoys the largest end user community of any open source foundation.</p>
												<p style="text-align: left;">
In the
<a href="https://docs.google.com/presentation/d/13s0X8GiCLCb0udqk7Mnm0459jsJayV0e0hLVJiq2SYc/edit?ts=5d810b63#slide=id.g60b1a45032_0_0">2019 survey</a>
respondents described the End User Community as a “healthy community that facilitates sharing of real-world experience” and a “great way to learn and share info with other end users.”
</p>
												<p style="text-align: left;">Another respondent description stated: “Being part of a community that are actually using these technologies in production at large scale is very useful, often meetups/conferences have a much broader set of people, many of which are only just starting out looking at these technologies.”</p>
												<p style="text-align: left;">Among respondents, 97% would recommend CNCF to other companies, and the average satisfaction rating was 4.16 out of 5. Of respondents, 94% also reported participating in End User-specific programs, such as the industry-specific End User Groups in Telecoms, Financial Services and Research.</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="vc_col-sm-4 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="img-with-animation-wrap " data-max-width="100%" data-border-radius="none">
											<div class="inner">
												<img loading="lazy" data-shadow="none" data-shadow-direction="middle" data-delay="0" height="1713" width="1268" data-animation="none" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/CNCF-Annual-Report-images-03.png" alt="">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div data-midnight="dark" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row standard_section" style="margin-top: 50px; padding-bottom: 0px; ">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg"></div>
							</div>
							<div class="row-bg-overlay" style="background: #e50994; background: linear-gradient(90deg,#e50994 0%,#2825f2 100%);  opacity: 1; ">
							</div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-12 wpb_column column_container vc_column_container col centered-text padding-4-percent" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="wpb_text_column wpb_content_element  vc_custom_1579610408451">
											<div class="wpb_wrapper">
												<p style="text-align: left;">
<span style="color: #ffffff;">
We published 38
<a style="color: #ffffff;" href="https://www.cncf.io/people/end-user-community/">case studies</a>
in 2019 detailing the learning of a diverse group of end users. These end users were committed to accelerating the adoption of cloud native technologies and improving the deployment experience, and shared their stories to benefit the community and the world. The published case studies expanded beyond Kubernetes to feature five other CNCF projects, including Vitess, Linkerd, Jaeger, Prometheus, and gRPC.&nbsp;
</span>
</p>
												<p style="text-align: left;">
<span style="color: #ffffff;">
Our case study on Booz Allen Hamilton was successfully pitched to the
<a style="color: #ffffff;" href="https://www.wsj.com/articles/seeking-happy-campers-government-offers-revamped-travel-portal-11570742343">WSJ (CIO Journal)</a>
, which ran a story that mentioned how Kubernetes was used to revamp the
<a style="color: #ffffff;" href="https://recreation.gov">recreation.gov</a>
site.
</span>
</p>
												<p style="text-align: left;">
<span style="color: #ffffff;">Other improvements for 2019 include: a new, easier-to-navigate case study page and layout; a powerful faceted search for quick filtering; and a new video format, which tells an engaging story while providing relevant technical details of the end user’s cloud native environment.</span>
</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="geographic-diversity-of-contributors" data-midnight="dark" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row standard_section" style="padding-top: 0px; padding-bottom: 0px; ">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg"></div>
							</div>
							<div class="row-bg-overlay"></div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-12 wpb_column column_container vc_column_container col centered-text padding-1-percent" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="img-with-animation-wrap " data-max-width="100%" data-border-radius="none">
											<div class="inner">
												<img loading="lazy" data-shadow="none" data-shadow-direction="middle" data-delay="0" height="393" width="800" data-animation="none" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/logos5-01.png" alt="">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="geographic-diversity-of-contributors" data-midnight="dark" data-top-percent="1%" data-bottom-percent="1%" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row standard_section" style="padding-top: calc(100vw * 0.01); padding-bottom: calc(100vw * 0.01); ">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg"></div>
							</div>
							<div class="row-bg-overlay" style="background: #e50994; background: linear-gradient(90deg,#e50994 0%,#2825f2 100%);  opacity: 1; ">
							</div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-12 wpb_column column_container vc_column_container col centered-text padding-2-percent" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="left-right" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div id="fws_5f3e995e17659" data-midnight="" data-column-margin="default" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row inner_row standard_section" style="padding-top: 0px; padding-bottom: 0px; ">
											<div class="row-bg-wrap">
												<div class="row-bg">
												</div>
											</div>
											<div class="col span_12  left">
												<div class="vc_col-sm-3 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-shadow="none" data-border-radius="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
													<div class="column-bg-overlay">
													</div>
													<div class="vc_column-inner">
														<div class="wpb_wrapper">
														</div>
													</div>
												</div>
												<div class="vc_col-sm-6 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-shadow="none" data-border-radius="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
													<div class="column-bg-overlay">
													</div>
													<div class="vc_column-inner">
														<div class="wpb_wrapper">
															<div class="img-with-animation-wrap " data-max-width="100%" data-border-radius="none">
																<div class="inner">
																	<img loading="lazy" data-shadow="none" data-shadow-direction="middle" data-delay="0" height="91" width="623" data-animation="fade-in" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/titles-03.svg" alt="">
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="vc_col-sm-3 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-shadow="none" data-border-radius="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
													<div class="column-bg-overlay">
													</div>
													<div class="vc_column-inner">
														<div class="wpb_wrapper">
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="fws_5f3e995e17e74" data-midnight="dark" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row standard_section" style="padding-top: 0px; padding-bottom: 20px; ">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg"></div>
							</div>
							<div class="row-bg-overlay"></div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-8 wpb_column column_container vc_column_container col padding-2-percent" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="right" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="divider-wrap" data-alignment="default">
											<div style="height: 25px;" class="divider"></div>
										</div>
										<div class="wpb_text_column wpb_content_element ">
											<div class="wpb_wrapper">
												<p>
In May 2019, we were thrilled to grant our second
<a href="https://www.cncf.io/announcement/2019/05/21/cloud-native-computing-foundation-announces-intuit-as-winner-of-top-end-user-award/">Top End User Award to Intuit </a>
for its innovative use of cloud native technologies and unique contributions to the CNCF ecosystem.
</p>
												<p>DiDi was the recipient of the Top End User in China award.</p>
												<p>
The End User Community meets regularly and advises the CNCF Governing Board and Technical Oversight Committee (TOC) members on key challenges, emerging use cases, and areas of opportunity and new growth for cloud native technologies. If you are using CNCF projects and meet the definition of an end user, we urge you to join our
<a href="https://www.cncf.io/people/end-user-community/">End User Community</a>
so you can participate in this influential group and provide your insights both to fellow end users and to the CNCF community as a whole. If you join, we are confident you will also learn from other end users who are deploying CNCF projects.
</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="vc_col-sm-4 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="img-with-animation-wrap " data-max-width="100%" data-border-radius="none">
											<div class="inner">
												<img loading="lazy" data-shadow="none" data-shadow-direction="middle" data-delay="0" height="1669" width="1975" data-animation="none" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/CNCF-Annual-Report-images2-05.svg" alt="">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="fws_5f3e995e1895e" data-midnight="dark" data-bottom-percent="0.5%" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row standard_section" style="padding-top: 0px; padding-bottom: calc(100vw * 0.00); ">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg"></div>
							</div>
							<div class="row-bg-overlay" style="background-color:#9e9e9e;  opacity: 1; ">
							</div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-12 wpb_column column_container vc_column_container col padding-1-percent" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="left-right" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="wpb_text_column wpb_content_element  vc_custom_1579612404512">
											<div class="wpb_wrapper">
												<h4 class="p1" style="text-align: center;">
													<span class="s1" style="color: #ffffff; font-weight: 700 !important;">2019
														END USER AWARD
														WINNERS</span>
												</h4>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="fws_5f3e995e18bdf" data-midnight="dark" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row  vc_row-o-equal-height vc_row-flex  vc_row-o-content-middle standard_section" style="padding-top: 0px; padding-bottom: 20px; ">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg"></div>
							</div>
							<div class="row-bg-overlay"></div>
						</div>
						<div class="col span_12 dark left">
							<div style="border: 2px solid rgba(255,255,255,0); " class="vc_col-sm-6 wpb_column column_container vc_column_container col padding-5-percent" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="2px" data-border-style="solid" data-border-color="#c4c4c4" data-bg-cover="" data-padding-pos="left-right" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<span class="border-wrap" style="border-color: #c4c4c4;">
									<span class="border-top"></span>
									<span class="border-right"></span>
									<span class="border-bottom"></span>
									<span class="border-left"></span>
								</span>
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="img-with-animation-wrap " data-max-width="100%" data-border-radius="none">
											<div class="inner">
												<img loading="lazy" data-shadow="none" data-shadow-direction="middle" data-delay="0" height="384" width="1098" data-animation="none" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/CNCF-Annual-Report-images-06.svg" alt="">
											</div>
										</div>
									</div>
								</div>
							</div>
							<div style="border: 2px solid rgba(255,255,255,0); " class="vc_col-sm-6 wpb_column column_container vc_column_container col padding-5-percent" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="2px" data-border-style="solid" data-border-color="#c4c4c4" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<span class="border-wrap" style="border-color: #c4c4c4;">
									<span class="border-top"></span>
									<span class="border-right"></span>
									<span class="border-bottom"></span>
									<span class="border-left"></span>
								</span>
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="img-with-animation-wrap " data-max-width="100%" data-border-radius="none">
											<div class="inner">
												<img loading="lazy" data-shadow="none" data-shadow-direction="middle" data-delay="0" height="384" width="1098" data-animation="none" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/CNCF-Annual-Report-images-07.svg" alt="">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="conferences" data-midnight="dark" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row  vc_row-o-equal-height vc_row-flex  vc_row-o-content-top standard_section" style="padding-top: 50px; padding-bottom: 35px; ">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg"></div>
							</div>
							<div class="row-bg-overlay"></div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-8 wpb_column column_container vc_column_container col centered-text no-extra-padding" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="left-right" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div id="fws_5f3e995e1b1fb" data-midnight="" data-column-margin="default" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row inner_row standard_section  vc_custom_1579527701718" style="padding-top: 0px; padding-bottom: 0px; ">
											<div class="row-bg-wrap">
												<div class="row-bg">
												</div>
											</div>
											<div class="col span_12  left">
												<div class="vc_col-sm-12 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-shadow="none" data-border-radius="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
													<div class="column-bg-overlay">
													</div>
													<div class="vc_column-inner">
														<div class="wpb_wrapper">
															<div class="nectar-gradient-text" data-direction="horizontal" data-color="extra-color-gradient-1" style="margin-top: 17px; margin-bottom: 10px; ">
																<h2>Conferences
																	and
																	Events</h2>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="divider-wrap" data-alignment="default">
											<div style="height: 5px;" class="divider"></div>
										</div>
										<div class="wpb_text_column wpb_content_element ">
											<div class="wpb_wrapper">
												<p style="text-align: left;">
<a href="http://www.kubecon.io">KubeCon + CloudNativeCon</a>
North America was the world’s largest open source developer conference in 2019. The event attracted 12,000 attendees, a 2000% increase from the first KubeCon event in 2015.
</p>
											</div>
										</div>
										<div class="img-with-animation-wrap " data-max-width="100%" data-border-radius="none">
											<div class="inner">
												<img loading="lazy" data-shadow="none" data-shadow-direction="middle" data-delay="0" height="897" width="1768" data-animation="none" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/CNCF-Annual-Report-images-08.svg" alt="">
											</div>
										</div>
										<div class="divider-wrap" data-alignment="default">
											<div style="height: 25px;" class="divider"></div>
										</div>
										<div class="wpb_text_column wpb_content_element ">
											<div class="wpb_wrapper">
												<p style="text-align: left;">At the event, Cheryl Hung, Director of Ecosystem at CNCF, delivered a CNCF community update highlighting new Platinum members ARM, NetApp, and Palo Alto Networks.</p>
												<p style="text-align: left;">
San Diego attendance increased 50% over the previous KubeCon + CloudNativeCon North America event in Seattle. The event welcomed many first-time attendees (65% of overall attendance), an indication of rising interest and healthy ecosystem growth. The CNCF issued a
<a href="https://www.cncf.io/wp-content/uploads/2020/08/KubeCon_NA_19_Report.pdf">Transparency Report</a>
to recap the event; the report included detailed data covering attendee demographics, attendee and speaker diversity, and attendee sentiment on their conference experience. Transparency Reports for KubeCon + Cloud NativeCon
<a href="https://www.cncf.io/blog/2019/07/01/kubecon-cloudnativecon-europe-2019-conference-transparency-report-another-record-breaking-cncf-event/">Europe</a>
and
<a href="https://www.cncf.io/blog/2019/07/26/kubecon-cloudnativecon-open-source-summit-china-2019-conference-transparency-report-a-record-breaking-cncf-and-lf-event/">China</a>
are also available for 2019. The overall satisfaction score for all CNCF events is 4.2 out of 5.
</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="vc_col-sm-4 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="img-with-animation-wrap " data-max-width="100%" data-border-radius="none">
											<div class="inner">
												<img loading="lazy" data-shadow="none" data-shadow-direction="middle" data-delay="0" height="1948" width="1397" data-animation="none" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/CNCF-Annual-Report-images-09.png" alt="">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="wellness" data-midnight="dark" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row  vc_row-o-equal-height vc_row-flex  vc_row-o-content-top standard_section" style="padding-top: 25px; padding-bottom: 35px; ">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg"></div>
							</div>
							<div class="row-bg-overlay"></div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-6 wpb_column column_container vc_column_container col centered-text no-extra-padding" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="left-right" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="img-with-animation-wrap " data-max-width="100%" data-border-radius="none">
											<div class="inner">
												<img loading="lazy" data-shadow="none" data-shadow-direction="middle" data-delay="0" height="1025" width="1379" data-animation="fade-in" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/CNCF-Annual-Report-images-10-scaled.jpg" alt="">
											</div>
										</div>
										<div class="divider-wrap" data-alignment="default">
											<div style="height: 25px;" class="divider"></div>
										</div>
										<div class="wpb_text_column wpb_content_element ">
											<div class="wpb_wrapper">
												<p style="text-align: left;">
San Diego co-chairs Vicki Cheung, of Lyft, and Bryan Liles, of VMware, provided updates on various CNCF projects, including the latest Kubernetes release and project graduations. The keynote stage also featured two live demos, showcasing a fully
<a href="https://www.youtube.com/watch?v=IL4nxbmUIX8"> containerized 5G network</a>
and
<a href="https://opentelemetry.io">OpenTelemetry</a>
prototypes running in labs around the world using open source technologies.
</p>
												<p style="text-align: left;">The three-day conference offered attendees 366 sessions, including keynotes, breakout sessions, lightning talks, BoFs, tutorials, and maintainer-track sessions.</p>
												<p style="text-align: left;">In addition to selected talks and keynotes, KubeCon + CloudNativeCon North America included 124 maintainer sessions. These were produced by the maintainers of CNCF-hosted projects to inform users about the projects, encourage and equip new adopters, and assist users in transitioning to become project contributors.</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="vc_col-sm-6 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div id="fws_5f3e995e1ce58" data-midnight="" data-column-margin="default" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row inner_row standard_section  vc_custom_1579527701718" style="padding-top: 0px; padding-bottom: 0px; ">
											<div class="row-bg-wrap">
												<div class="row-bg">
												</div>
											</div>
											<div class="col span_12  left">
												<div class="vc_col-sm-12 wpb_column column_container vc_column_container col centered-text no-extra-padding" data-t-w-inherits="default" data-shadow="none" data-border-radius="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
													<div class="column-bg-overlay">
													</div>
													<div class="vc_column-inner">
														<div class="wpb_wrapper">
															<div class="nectar-gradient-text" data-direction="horizontal" data-color="extra-color-gradient-1" style="margin-top: 17px; margin-bottom: 10px; ">
																<h2>Wellness
																	Activities
																</h2>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="wpb_text_column wpb_content_element ">
											<div class="wpb_wrapper">
												<p style="text-align: left;">
One focus in San Diego was to “Keep Cloud Native Well.” While CNCF makes every effort to ensure the comfort, health, and happiness of KubeCon + CloudNativeCon attendees, there may be some who feel overwhelmed or unhappy while at a busy live event. The Well-being Working Group (WG) was created in response to attendee feedback. In San Diego, we provided options for attendees to get active, find quiet time, get puppy cuddles, and discuss mental health. We also partnered with
<a href="https://osmihelp.org/">Open Sourcing Mental Illness (OSMI)</a>
to have an onsite booth for attendees. A full list of activities and additional information can be found in the
<a href="https://www.cncf.io/wp-content/uploads/2020/08/KubeCon_NA_19_Report.pdf">Transparency Report</a>
.
</p>
											</div>
										</div>
										<div class="divider-wrap" data-alignment="default">
											<div style="height: 35px;" class="divider"></div>
										</div>
										<div class="img-with-animation-wrap " data-max-width="100%" data-border-radius="none">
											<div class="inner">
												<img loading="lazy" data-shadow="none" data-shadow-direction="middle" data-delay="0" height="1025" width="1417" data-animation="fade-in" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/CNCF-Annual-Report-images-11-scaled.jpg" alt="">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="training" data-midnight="dark" class="wpb_row vc_row-fluid vc_row standard_section" style="padding-top: 0px; padding-bottom: 0px; margin-top: 2rem;">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg"></div>
							</div>
							<div class="row-bg-overlay" style="background: #e50994; background: linear-gradient(90deg,#e50994 0%,#2825f2 100%);  opacity: 1; ">
							</div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-12 wpb_column column_container vc_column_container col centered-text padding-3-percent" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div id="fws_5f3e995e1d7bb" data-midnight="" data-column-margin="default" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row inner_row standard_section" style="padding-top: 0px; padding-bottom: 0px; ">
											<div class="row-bg-wrap">
												<div class="row-bg">
												</div>
											</div>
											<div class="col span_12  left">
												<div class="vc_col-sm-8 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-shadow="none" data-border-radius="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
													<div class="column-bg-overlay">
													</div>
													<div class="vc_column-inner">
														<div class="wpb_wrapper">
															<div class="img-with-animation-wrap " data-max-width="100%" data-border-radius="none">
																<div class="inner">
																	<img loading="lazy" data-shadow="none" data-shadow-direction="middle" data-delay="0" height="91" width="977" data-animation="fade-in" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/titles-04.svg" alt="">
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="vc_col-sm-4 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-shadow="none" data-border-radius="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
													<div class="column-bg-overlay">
													</div>
													<div class="vc_column-inner">
														<div class="wpb_wrapper">
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="divider-wrap" data-alignment="default">
											<div style="height: 25px;" class="divider"></div>
										</div>
										<div id="fws_5f3e995e1de19" data-midnight="" data-column-margin="default" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row inner_row standard_section" style="padding-top: 0px; padding-bottom: 0px; ">
											<div class="row-bg-wrap">
												<div class="row-bg">
												</div>
											</div>
											<div class="col span_12  left">
												<div class="vc_col-sm-6 wpb_column column_container vc_column_container col padding-2-percent" data-t-w-inherits="default" data-shadow="none" data-border-radius="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="left" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
													<div class="column-bg-overlay">
													</div>
													<div class="vc_column-inner">
														<div class="wpb_wrapper">
															<div class="wpb_text_column wpb_content_element ">
																<div class="wpb_wrapper">
																	<p style="text-align: left;">
<span style="color: #ffffff;">In 2018, CNCF introduced a variety of training and certifications for key CNCF technologies, to ensure that organizations can train their employees or hire from a strong pool of experienced talent. In 2019, each training course received considerable interest:</span>
</p>
																	<p style="text-align: left;">
<span style="color: #ffffff;">
<a style="color: #ffffff;" href="https://www.cncf.io/certification/training/">
<strong>– Kubernetes Massively Open Online Course (MOOC)</strong>
</a>
hit 98,000 enrollments (80% increase from 2018).
</span>
<br>
<span style="color: #ffffff;">
<strong>
–
<a style="color: #ffffff;" href="https://www.cncf.io/certification/expert/">Certified Kubernetes Administrator (CKA)</a>
</strong>
hit 12,950 enrollments (142% increase from 2018).
</span>
<br>
<span style="color: #ffffff;">
<strong>
–
<a style="color: #ffffff;" href="https://www.cncf.io/certification/kcsp/">Kubernetes Certified Service Provider (KCSP)</a>
</strong>
hit 129 certifications in 2019 (52% increase from 2018).
</span>
<br>
<span style="color: #ffffff;">
<strong>
–
<a style="color: #ffffff;" href="https://www.cncf.io/certification/ckad/">Certified Kubernetes Application Developer (CKAD)</a>
</strong>
hit 5,754 exam registrations (297% increase from 2018).
</span>
</p>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="vc_col-sm-6 wpb_column column_container vc_column_container col padding-2-percent" data-t-w-inherits="default" data-shadow="none" data-border-radius="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="left" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
													<div class="column-bg-overlay">
													</div>
													<div class="vc_column-inner">
														<div class="wpb_wrapper">
															<div class="wpb_text_column wpb_content_element ">
																<div class="wpb_wrapper">
																	<p style="text-align: left;">
<span style="color: #ffffff;">
In May 2018, CNCF announced the availability of the
<a style="color: #ffffff;" href="https://www.cncf.io/certification/training/">Kubernetes Training Partner (KTP)</a>
program. KTPs have passed a rigorous qualification process overseen by CNCF. KTPs offer specialized instruction to individuals or corporations who are looking for training that maps directly to the Certified Kubernetes Administrator (CKA) or Certified Kubernetes Application Developer (CKAD) exams. In 2019, the ranks of Kubernetes Training Partners grew to 35, a 94% increase from 2018. Additionally, CNCF launched a
<a style="color: #ffffff;" href="https://training.linuxfoundation.org/training/cloud-native-logging-with-fluentd-lfs242/">Cloud Native Logging course with Fluentd</a>
that hit 425 registrations in 2019.
</span>
</p>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="divider-wrap" data-alignment="default">
											<div style="height: 15px;" class="divider"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="training" data-midnight="dark" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row standard_section" style="padding-top: 0px; padding-bottom: 35px; ">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg"></div>
							</div>
							<div class="row-bg-overlay"></div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-12 wpb_column column_container vc_column_container col centered-text no-extra-padding" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="img-with-animation-wrap " data-max-width="100%" data-border-radius="none">
											<div class="inner">
												<img loading="lazy" data-shadow="none" data-shadow-direction="middle" data-delay="0" height="314" width="804" data-animation="none" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/CNCF-Annual-Report-2019-images-01.png" style="padding-top: 50px; padding-bottom: 0px; margin-top: 2rem; display: block" alt="">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="updates" data-midnight="dark" data-top-percent="1%" data-bottom-percent="1%" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row standard_section" style="padding-top: calc(100vw * 0.01); padding-bottom: calc(100vw * 0.01); ">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg"></div>
							</div>
							<div class="row-bg-overlay" style="background: #e50994; background: linear-gradient(90deg,#e50994 0%,#2825f2 100%);  opacity: 1; ">
							</div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-12 wpb_column column_container vc_column_container col centered-text padding-2-percent" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="left-right" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div id="fws_5f3e995e1e88a" data-midnight="" data-column-margin="default" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row inner_row standard_section" style="padding-top: 0px; padding-bottom: 0px; ">
											<div class="row-bg-wrap">
												<div class="row-bg">
												</div>
											</div>
											<div class="col span_12  left">
												<div class="vc_col-sm-2 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-shadow="none" data-border-radius="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
													<div class="column-bg-overlay">
													</div>
													<div class="vc_column-inner">
														<div class="wpb_wrapper">
														</div>
													</div>
												</div>
												<div class="vc_col-sm-8 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-shadow="none" data-border-radius="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
													<div class="column-bg-overlay">
													</div>
													<div class="vc_column-inner">
														<div class="wpb_wrapper">
															<div class="img-with-animation-wrap " data-max-width="100%" data-border-radius="none">
																<div class="inner">
																	<img loading="lazy" data-shadow="none" data-shadow-direction="middle" data-delay="0" height="91" width="1237" data-animation="fade-in" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/titles-05.svg" alt="">
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="vc_col-sm-2 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-shadow="none" data-border-radius="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
													<div class="column-bg-overlay">
													</div>
													<div class="vc_column-inner">
														<div class="wpb_wrapper">
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="fws_5f3e995e1efc3" data-midnight="dark" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row standard_section" style="padding-top: 0px; padding-bottom: 25px; ">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg"></div>
							</div>
							<div class="row-bg-overlay"></div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-12 wpb_column column_container vc_column_container col centered-text no-extra-padding" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="left-right" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="wpb_text_column wpb_content_element ">
											<div class="wpb_wrapper">
												<p style="text-align: left; margin-top: 2rem;">In 2019, CNCF projects Fluentd, CoreDNS, containerd, Jaeger, and Vitess advanced to “graduated” status. This increased the total of graduated projects from two to six. During 2019, CloudEvents, Falco, and OPA joined our 14 incubating projects.</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="fws_5f3e995e1f1fb" data-midnight="dark" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row standard_section" style="margin-bottom: 2rem;">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg  using-bg-color  " style="background-color: #eeeeee; "></div>
							</div>
							<div class="row-bg-overlay"></div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-12 wpb_column column_container vc_column_container col centered-text padding-1-percent" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="left-right" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="nectar-gradient-text" data-direction="horizontal" data-color="extra-color-gradient-1" style="margin-top: 17px; margin-bottom: 10px; ">
											<h2>Project Maturity Levels</h2>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="maturity" data-midnight="dark" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row standard_section" style="padding-top: 0px; padding-bottom: 35px; ">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg"></div>
							</div>
							<div class="row-bg-overlay"></div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-3 wpb_column column_container vc_column_container col centered-text no-extra-padding" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="left-right" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="wpb_text_column wpb_content_element ">
											<div class="wpb_wrapper">
												<p style="text-align: left;">
CNCF projects are classified by maturity level, ranging from sandbox to incubating to graduated. CNCF uses these maturity levels to indicate to enterprises the degree of project readiness for enterprise adoption. Graduated projects are suitable for the vast majority of enterprises. Incubating projects are suitable for early adopters, and sandbox projects are suitable for innovators. Projects increase their maturity level by demonstrating to the TOC that they have attained end user and vendor adoption, established a healthy rate of code commits and codebase changes, and attracted committers from multiple organizations. All projects must adopt the CNCF
<a href="https://github.com/cncf/foundation/blob/master/code-of-conduct.md">Code of Conduct</a>
and commit to earning the Core Infrastructure Initiative
<a href="https://bestpractices.coreinfrastructure.org/">Best Practices Badge</a>
in order to become an accepted CNCF project. Full details are listed in
<a href="https://github.com/cncf/toc/blob/master/process/graduation_criteria.adoc">Graduation Criteria v1.1</a>
.
</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="vc_col-sm-9 wpb_column column_container vc_column_container col padding-1-percent" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="left" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="img-with-animation-wrap " data-max-width="100%" data-border-radius="none">
											<div class="inner">
												<img loading="lazy" data-shadow="none" data-shadow-direction="middle" data-delay="0" height="635" width="1768" data-animation="none" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/CNCF-Annual-Report-images-13.png" alt="" style="display: block;">
											</div>
										</div>
										<div id="fws_5f3e995e1fadf" data-midnight="" data-column-margin="default" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row inner_row standard_section  vc_custom_1579552893929" style="padding-top: 0px; padding-bottom: 0px; ">
											<div class="row-bg-wrap">
												<div class="row-bg">
												</div>
											</div>
											<div class="col span_12  left">
												<div class="vc_col-sm-12 wpb_column column_container vc_column_container col padding-1-percent" data-t-w-inherits="default" data-shadow="none" data-border-radius="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
													<div class="column-bg-overlay">
													</div>
													<div class="vc_column-inner">
														<div class="wpb_wrapper">
															<div class="wpb_text_column wpb_content_element  vc_custom_1579611436622">
																<div class="wpb_wrapper">
																	<h3 style="text-align: center;">
																		<span style="color: #ffffff;">
																			<strong>
																				In
																				2019
																				the
																				<a style="color: #ffffff; text-decoration: underline;" href="https://github.com/cncf/toc">CNCF
																					TOC</a>
																				accepted
																				12
																				new
																				projects:
																			</strong>
																		</span>
																	</h3>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="img-with-animation-wrap " data-max-width="100%" data-border-radius="none">
											<div class="inner">
												<img loading="lazy" data-shadow="none" data-shadow-direction="middle" data-delay="0" height="501" width="1768" data-animation="none" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/CNCF-Annual-Report-images-14.png" alt="">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="survey" data-midnight="dark" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row standard_section" style="padding-top: 0px; padding-bottom: 0px; ">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg  using-bg-color  " style="background-color: #eeeeee; "></div>
							</div>
							<div class="row-bg-overlay"></div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-12 wpb_column column_container vc_column_container col centered-text padding-1-percent" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="left-right" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="nectar-gradient-text" data-direction="horizontal" data-color="extra-color-gradient-1" style="margin-top: 17px; margin-bottom: 10px; ">
											<h2>CNCF Project Maintainer Survey
												Results</h2>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="fws_5f3e995e20348" data-midnight="dark" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row standard_section" style="padding-top: 0px; padding-bottom: 0px; ">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg"></div>
							</div>
							<div class="row-bg-overlay"></div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-6 wpb_column column_container vc_column_container col centered-text padding-3-percent" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="left-right" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="divider-wrap" data-alignment="default">
											<div style="height: 25px;" class="divider"></div>
										</div>
										<div class="wpb_text_column wpb_content_element ">
											<div class="wpb_wrapper">
												<p style="text-align: left;">CNCF conducts a survey of our project maintainers twice a year. The overall satisfaction with CNCF increased in 2019 between the first and second surveys. There was a 100% maintainer response rate across projects, and the super majority of maintainers recommended CNCF as a place to host an open source project.</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="vc_col-sm-6 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="img-with-animation-wrap " data-max-width="100%" data-border-radius="none">
											<div class="inner">
												<img loading="lazy" data-shadow="none" data-shadow-direction="middle" data-delay="0" height="464" width="1768" data-animation="none" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/CNCF-Annual-Report-images2-15.svg" alt="">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="releases" data-midnight="dark" style="margin-top: 2rem;" class="wpb_row vc_row-fluid vc_row standard_section">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg"></div>
							</div>
							<div class="row-bg-overlay" style="background: #e50994; background: linear-gradient(90deg,#e50994 0%,#2825f2 100%);  opacity: 1; ">
							</div>
						</div>
						<div class="col span_12 dark left" style="margin: 1rem 0 !important;">
							<div class="vc_col-sm-12 wpb_column column_container vc_column_container col centered-text" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="wpb_text_column wpb_content_element  vc_custom_1579552008425">
											<div class="wpb_wrapper">
												<h3 class="p1">
													<span style="color: #ffffff;">
														<strong>
															<span class="s1" style="font-weight: 700 !important; text-transform: uppercase">
																Project Updates
																and
																Releases
																<br>
															</span>
														</strong>
													</span>
												</h3>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="fws_5f3e995e20d00" data-midnight="dark" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row standard_section" style="padding-top: 25px; padding-bottom: 0px; ">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg"></div>
							</div>
							<div class="row-bg-overlay"></div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-4 wpb_column column_container vc_column_container col padding-2-percent" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="left-right" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="img-with-animation-wrap " data-max-width="100%" data-border-radius="none">
											<div class="inner">
												<img loading="lazy" data-shadow="none" data-shadow-direction="middle" data-delay="0" height="426" width="934" data-animation="none" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/CNCF-Annual-Report-images-17.svg" alt="">
											</div>
										</div>
										<div class="divider-wrap" data-alignment="default">
											<div style="height: 15px;" class="divider"></div>
										</div>
										<div class="wpb_text_column wpb_content_element ">
											<div class="wpb_wrapper">
												<p style="text-align: left;">
<a href="https://kubernetes.io/blog/2019/12/09/kubernetes-1-17-release-announcement/">Kubernetes 1.17</a>
was released in December 2019. New functionality included cloud provider labels reaching General Availability and CSI Migration Beta.
</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="vc_col-sm-4 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="img-with-animation-wrap " data-max-width="100%" data-border-radius="none">
											<div class="inner">
												<img loading="lazy" data-shadow="none" data-shadow-direction="middle" data-delay="0" height="426" width="934" data-animation="none" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/CNCF-Annual-Report-images-19.svg" alt="">
											</div>
										</div>
										<div class="wpb_text_column wpb_content_element ">
											<div class="wpb_wrapper">
												<p style="text-align: left;">
<a href="https://helm.sh/blog/helm-3-released/">Helm 3.0 </a>
debuted as the latest major release of the package manager, building on the success of Helm 2.0.
</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="vc_col-sm-4 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="img-with-animation-wrap " data-max-width="100%" data-border-radius="none">
											<div class="inner">
												<img loading="lazy" data-shadow="none" data-shadow-direction="middle" data-delay="0" height="426" width="934" data-animation="none" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/CNCF-Annual-Report-images-16.svg" alt="">
											</div>
										</div>
										<div class="wpb_text_column wpb_content_element ">
											<div class="wpb_wrapper">
												<p style="text-align: left;">
<a href="https://coredns.io/">CoreDNS</a>
issued its first post-graduation release, which included many plugins and enhancements.
</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="fws_5f3e995e21f89" data-midnight="dark" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row standard_section" style="padding-top: 0px; padding-bottom: 50px; ">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg"></div>
							</div>
							<div class="row-bg-overlay"></div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-4 wpb_column column_container vc_column_container col padding-2-percent" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="left-right" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="img-with-animation-wrap " data-max-width="100%" data-border-radius="none">
											<div class="inner">
												<img loading="lazy" data-shadow="none" data-shadow-direction="middle" data-delay="0" height="426" width="934" data-animation="none" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/CNCF-Annual-Report-images-20.svg" alt="">
											</div>
										</div>
										<div class="divider-wrap" data-alignment="default">
											<div style="height: 15px;" class="divider"></div>
										</div>
										<div class="wpb_text_column wpb_content_element ">
											<div class="wpb_wrapper">
												<p style="text-align: left;">
<a href="https://www.fluentd.org/">Fluentd</a>
, the open source data collector for unified logging, announced v0.12 is now security maintenance mode.
</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="vc_col-sm-4 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="img-with-animation-wrap " data-max-width="100%" data-border-radius="none">
											<div class="inner">
												<img loading="lazy" data-shadow="none" data-shadow-direction="middle" data-delay="0" height="426" width="934" data-animation="none" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/CNCF-Annual-Report-images-18.svg" alt="">
											</div>
										</div>
										<div class="wpb_text_column wpb_content_element ">
											<div class="wpb_wrapper">
												<p style="text-align: left;">
Ticketmaster announced it had used
<a href="https://medium.com/jaegertracing/ticketmaster-traces-100-million-transactions-per-day-with-jaeger-38ec6cf599f0">Jaeger</a>
to trace 100 million transactions per day in 2019.
</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="vc_col-sm-4 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="img-with-animation-wrap " data-max-width="100%" data-border-radius="none">
											<div class="inner">
												<img loading="lazy" data-shadow="none" data-shadow-direction="middle" data-delay="0" height="426" width="934" data-animation="none" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/CNCF-Annual-Report-images-21.svg" alt="">
											</div>
										</div>
										<div class="wpb_text_column wpb_content_element ">
											<div class="wpb_wrapper">
												<p style="text-align: left;">
<a href="https://vitess.io/blog/2019-11-05-vitess-4.0-has-been-released/">Vitess 4.0 </a>
was released to include improved SQL Query Support.
</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="services" data-midnight="dark" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row standard_section" style="margin-bottom: 1rem; padding-top: 0px; padding-bottom: 0px; ">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg  using-bg-color  " style="background-color: #eeeeee; "></div>
							</div>
							<div class="row-bg-overlay"></div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-12 wpb_column column_container vc_column_container col centered-text padding-1-percent" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="left-right" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="nectar-gradient-text" data-direction="horizontal" data-color="extra-color-gradient-1" style="margin-top: 17px; margin-bottom: 10px; ">
											<h2>Services and Assistance for
												Projects
											</h2>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="fws_5f3e995e2468a" data-midnight="dark" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row standard_section" style="padding-top: 0px; padding-bottom: 0px; margin-bottom: 1rem">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg"></div>
							</div>
							<div class="row-bg-overlay"></div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-12 wpb_column column_container vc_column_container col padding-2-percent" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="left-right" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="divider-wrap" data-alignment="default">
											<div style="height: 15px;" class="divider"></div>
										</div>
										<div class="wpb_text_column wpb_content_element ">
											<div class="wpb_wrapper">
												<p style="text-align: left;">
CNCF provided a variety of
<a href="https://github.com/cncf/servicedesk">services</a>
to our projects to help make them more successful and sustainable.
</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="fws_5f3e995e248b1" data-midnight="dark" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row  vc_row-o-equal-height vc_row-flex  vc_row-o-content-top standard_section" style="padding-top: 0px; padding-bottom: 35px; ">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg"></div>
							</div>
							<div class="row-bg-overlay"></div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-6 wpb_column column_container vc_column_container col padding-2-percent" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="left-right" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="wpb_text_column wpb_content_element ">
											<div class="wpb_wrapper">
												<ul>
													<li style="text-align: left;">
														CNCF continues to invest
														in
														CNCF-hosted projects by
														assisting with their own
														specialized events.
														These
														may be in conjunction
														with
														KubeCon + CloudNativeCon
														(including
														<a href="https://events.linuxfoundation.org/events/kubecon-cloudnativecon-north-america-2018/co-located-events/#envoycon">EnvoyCon</a>
														and the
														<a href="https://events.linuxfoundation.org/events/kubecon-cloudnativecon-north-america-2018/co-located-events/#observability-practitioners-summit">Observability
															Practitioner’s
															Summit</a>
														) or standalone
														conferences
														(including
														<a href="https://promcon.io/">PromCon</a>
														and
														<a href="https://events19.linuxfoundation.org/events/helm-summit-2019/">Helm
															Summit EU</a>
														).
													</li>
													<li style="text-align: left;">
														The second
														<a href="https://events.linuxfoundation.org/events/kubecon-cloudnativecon-north-america-2018/co-located-events/envoycon/">EnvoyCon</a>
														, which was held on
														November
														18, 2019, in San Diego,
														as
														part of the KubeCon +
														CloudNativeCon
														<a href="https://events.linuxfoundation.org/events/kubecon-cloudnativecon-north-america-2018/co-located-events/">Co-Located
															Events Day</a>
														, had 337 attendees.
													</li>
													<li style="text-align: left;">
														<a href="https://promcon.io/2019-munich/">PromCon
															2019</a>
														hosted 231 attendees in
														Munich on November 7-8,
														2019.
													</li>
													<li style="text-align: left;">
														<a href="https://events19.linuxfoundation.org/events/helm-summit-2019/">Helm
															Summit EU</a>
														gathered 152 attendees
														in
														Amsterdam on September
														11-12, 2019.
													</li>
												</ul>
											</div>
										</div>
										<div class="divider-wrap" data-alignment="default">
											<div style="height: 25px;" class="divider"></div>
										</div>
										<div class="img-with-animation-wrap " data-max-width="100%" data-border-radius="none">
											<div class="inner">
												<img loading="lazy" data-shadow="none" data-shadow-direction="middle" data-delay="0" height="1025" width="1416" data-animation="fade-in" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/CNCF-Annual-Report-images-22-scaled.jpg" alt="">
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="vc_col-sm-6 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="img-with-animation-wrap " data-max-width="100%" data-border-radius="none">
											<div class="inner">
												<img loading="lazy" data-shadow="none" data-shadow-direction="middle" data-delay="0" height="1025" width="1416" data-animation="fade-in" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/CNCF-Annual-Report-images-23-scaled.jpg" alt="">
											</div>
										</div>
										<div class="divider-wrap" data-alignment="default">
											<div style="height: 25px;" class="divider"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="fws_5f3e995e25617" data-midnight="dark" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row standard_section" style="padding-top: 0px; padding-bottom: 0px; ">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg  using-bg-color  " style="background-color: #eeeeee; "></div>
							</div>
							<div class="row-bg-overlay"></div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-12 wpb_column column_container vc_column_container col centered-text padding-1-percent" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="left-right" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="nectar-gradient-text" data-direction="horizontal" data-color="extra-color-gradient-1" style="margin-top: 17px; margin-bottom: 10px; ">
											<h2>Documentation, Websites and
												Blogs
											</h2>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="fws_5f3e995e25801" data-midnight="dark" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row standard_section" style="padding-top: 15px; padding-bottom: 35px; ">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg"></div>
							</div>
							<div class="row-bg-overlay"></div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-6 wpb_column column_container vc_column_container col padding-2-percent" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="left-right" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="wpb_text_column wpb_content_element ">
											<div class="wpb_wrapper">
												<ul>
													<li>
														We issued a series of
														project journey reports
														for
														CNCF graduated projects,
														including
														<a href="https://www.cncf.io/cncf-kubernetes-project-journey/">Kubernetes</a>
														,
														<a href="https://www.cncf.io/cncf-envoy-project-journey/">Envoy</a>
														, and
														<a href="https://www.cncf.io/cncf-prometheus-project-journey/">Prometheus</a>
														.
													</li>
													<li>134 blog posts were
														published in 2019, with
														a
														blog readership of
														371,352
														(51% higher than 2018).
													</li>
													<li>
														Top blog posts for 2019:
														<ul>
															<li>
																<a href="https://www.cncf.io/blog/2019/01/14/9-kubernetes-security-best-practices-everyone-must-follow/">9
																	Kubernetes
																	Security
																	Best
																	Practices
																	Everyone
																	Must
																	Follow</a>
																(StackRox)
																(44,379
																views)
															</li>
															<li>
																<a href="https://www.cncf.io/blog/2018/08/01/demystifying-rbac-in-kubernetes/">Demystifying
																	RBAC in
																	Kubernetes</a>
																(Bitnami)
																(20,327
																views)
															</li>
															<li>
																<a href="https://www.cncf.io/blog/2019/08/06/open-sourcing-the-kubernetes-security-audit/">Open
																	Sourcing the
																	Kubernetes
																	Security
																	Audit</a>
																(CNCF) (16,660
																views)
															</li>
															<li>
																<a href="https://www.cncf.io/blog/2019/11/04/building-a-large-scale-distributed-storage-system-based-on-raft/">Building
																	a
																	Large-scale
																	Distributed
																	Storage
																	System
																	Based on
																	Raft</a>
																(13,859 page
																views)
															</li>
															<li>
																<a href="https://www.cncf.io/blog/2019/05/10/kubernetes-core-concepts/">Kubernetes:
																	Core
																	Concepts</a>
																(YLD) (13,588
																page
																views)
															</li>
														</ul>
													</li>
													<li>
														We also improved the
														CNCF
														website to deliver a
														streamlined experience.
														Updates included:
														<ul>
															<li>New design and
																faceted search
																capability for
																case
																studies and CNCF
																webinars.</li>
															<li>More information
																on
																all the events
																that
																CNCF
																participates
																in, including
																third-party /
																non-CNCF events.
															</li>
															<li>Speakers bureau
																updates
																including
																enhanced
																profiles
																for the
																speakers,
																upgraded search,
																and
																functionality
																for
																members to email
																multiple
																speakers.
															</li>
														</ul>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="vc_col-sm-6 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="wpb_text_column wpb_content_element ">
											<div class="wpb_wrapper">
												<ul>
													<li>
														We created the
														<a href="https://branding.cncf.io/">CNCF
															Branding</a>
														web interface to provide
														easy access to projects’
														color schemes and logos.
													</li>
													<li>
														Some projects got brand
														new
														websites courtesy of
														CNCF in
														2019:
														<ul>
															<li>
																<a href="https://cloudevents.io">CloudEvents</a>
															</li>
															<li>
																<a href="https://theupdateframework.org">The
																	Update
																	Framework</a>
																(TUF)
															</li>
															<li>
																<a href="https://opentelemetry.io">OpenTelemetry</a>
															</li>
															<li>
																<a href="https://etcd.io">etcd</a>
															</li>
															<li>
																<a href="https://openpolicyagent.org">Open
																	Policy
																	Agent</a>
																(OPA)
															</li>
															<li>
																<a href="https://longhorn.io">Longhorn</a>
															</li>
															<li>
																<a href="https://networkservicemesh.io">Network
																	Service
																	Mesh</a>
																(NSM)
															</li>
															<li>
																<a href="https://fluxcd.io">Flux</a>
															</li>
														</ul>
													</li>
													<li>
														Other projects got major
														documentation/web
														presence
														upgrades:
														<ul>
															<li>
																<a href="https://helm.sh">Helm</a>
																(streamlined
																build
																system)
															</li>
															<li>
																<a href="https://vitess.io">Vitess</a>
																(translation
																into
																Chinese)
															</li>
															<li>
																<a href="https://www.jaegertracing.io/docs/latest">Jaeger</a>
																(advanced search
																capabilities)
															</li>
															<li>
																<a href="https://tikv.org/docs/deep-dive/introduction/">TiKV</a>
																(deep dive)
															</li>
															<li>
																<a href="https://kubernetes.io">Kubernetes</a>
																(major additions
																to
																existing
																translations
																plus
																new translations
																for
																Vietnamese,
																Russian,
																Bahasa
																Indonesia,
																and others)
															</li>
														</ul>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="desk" data-midnight="dark" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row standard_section" style="padding-top: 0px; padding-bottom: 0px; margin-bottom: 1rem">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg  using-bg-color  " style="background-color: #eeeeee; "></div>
							</div>
							<div class="row-bg-overlay"></div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-12 wpb_column column_container vc_column_container col centered-text padding-1-percent" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="left-right" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="nectar-gradient-text" data-direction="horizontal" data-color="extra-color-gradient-1" style="margin-top: 17px; margin-bottom: 17px; ">
											<h2>CNCF Service Desk</h2>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="fws_5f3e995e25f40" data-midnight="dark" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row standard_section" style="padding-top: 0px; padding-bottom: 25px; ">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg"></div>
							</div>
							<div class="row-bg-overlay"></div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-12 wpb_column column_container vc_column_container col padding-1-percent" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="left-right" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="wpb_text_column wpb_content_element ">
											<div class="wpb_wrapper">
												<p style="text-align: left;">
To improve access to activities and services that CNCF offers to its hosted projects, the
<a href="http://servicedesk.cncf.io">CNCF Service Desk</a>
serves as a single access point for all CNCF services. If you’re a CNCF project maintainer, all you have to do is visit
<a href="http://servicedesk.cncf.io/">http://servicedesk.cncf.io</a>
to request support.
</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="geographic-diversity-of-contributors" data-midnight="dark" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row standard_section" style="padding-top: 0px; padding-bottom: 0px; ">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg"></div>
							</div>
							<div class="row-bg-overlay" style="background: #e50994; background: linear-gradient(90deg,#e50994 0%,#2825f2 100%);  opacity: 1; ">
							</div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-12 wpb_column column_container vc_column_container col centered-text padding-1-percent" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="wpb_text_column wpb_content_element  vc_custom_1579627671323">
											<div class="wpb_wrapper">
												<h3 class="p1" style="text-align: center;">
													<span style="color: #ffffff;">
														<strong>
															<span class="s1" style="font-weight: 700 !important;">
																CNCF SERVICE
																DESK
																REQUEST BURN UP
																CHART
																<br>
															</span>
														</strong>
													</span>
												</h3>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="fws_5f3e995e2649d" data-midnight="dark" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row standard_section" style="padding-top: 0px; padding-bottom: 0px; ">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg"></div>
							</div>
							<div class="row-bg-overlay"></div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-12 wpb_column column_container vc_column_container col centered-text padding-2-percent" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="left-right" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="divider-wrap" data-alignment="default">
											<div style="height: 5px;" class="divider"></div>
										</div>
										<div class="img-with-animation-wrap " data-max-width="100%" data-border-radius="none">
											<div class="inner">
												<img loading="lazy" data-shadow="none" data-shadow-direction="middle" data-delay="0" height="842" width="1768" data-animation="none" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/CNCF-Annual-Report-images-24.svg" alt="">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="fws_5f3e995e26e6c" data-midnight="dark" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row standard_section" style="padding-top: 0px; padding-bottom: 25px; ">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg"></div>
							</div>
							<div class="row-bg-overlay"></div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-12 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="left-right" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="img-with-animation-wrap " data-max-width="100%" data-border-radius="none">
											<div class="inner">
												<img loading="lazy" data-shadow="none" data-shadow-direction="middle" data-delay="0" height="100" width="100" data-animation="none" src="" alt="">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="#engagement" data-midnight="dark" data-top-percent="1%" data-bottom-percent="1%" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row standard_section" style="padding-top: calc(100vw * 0.01); padding-bottom: calc(100vw * 0.01); ">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg"></div>
							</div>
							<div class="row-bg-overlay" style="background: #e50994; background: linear-gradient(90deg,#e50994 0%,#2825f2 100%);  opacity: 1; ">
							</div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-12 wpb_column column_container vc_column_container col centered-text padding-2-percent" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="left-right" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div id="fws_5f3e995e2718e" data-midnight="" data-column-margin="default" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row inner_row standard_section" style="padding-top: 0px; padding-bottom: 0px; ">
											<div class="row-bg-wrap">
												<div class="row-bg">
												</div>
											</div>
											<div class="col span_12  left">
												<div class="vc_col-sm-3 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-shadow="none" data-border-radius="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
													<div class="column-bg-overlay">
													</div>
													<div class="vc_column-inner">
														<div class="wpb_wrapper">
														</div>
													</div>
												</div>
												<div class="vc_col-sm-6 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-shadow="none" data-border-radius="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
													<div class="column-bg-overlay">
													</div>
													<div class="vc_column-inner">
														<div class="wpb_wrapper">
															<div class="img-with-animation-wrap " data-max-width="100%" data-border-radius="none">
																<div class="inner">
																	<img loading="lazy" data-shadow="none" data-shadow-direction="middle" data-delay="0" height="91" width="885" data-animation="fade-in" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/titles-06.svg" alt="">
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="vc_col-sm-3 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-shadow="none" data-border-radius="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
													<div class="column-bg-overlay">
													</div>
													<div class="vc_column-inner">
														<div class="wpb_wrapper">
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="fws_5f3e995e2794b" data-midnight="dark" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row standard_section" style="padding-top: 25px; padding-bottom: 0px; ">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg"></div>
							</div>
							<div class="row-bg-overlay"></div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-6 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="left-right" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="wpb_text_column wpb_content_element ">
											<div class="wpb_wrapper">
												<p style="text-align: left;">The CNCF community spans the world across our contributors, members, meetups, and ambassadors.</p>
												<p style="text-align: left;">
It is a high priority for CNCF to support the continued development of this amazing community while making sure that everyone who wants to participate feels welcome regardless of gender, gender identity, sexual orientation, disability, race, ethnicity, age, religion, or economic status. In 2019, women and non-binary speakers made up 65% of the keynotes at
<a href="https://events19.linuxfoundation.org/events/kubecon-cloudnativecon-north-america-2019/">KubeCon + CloudNativeCon San Diego.</a>
Additionally, there were a number of activities designed to foster the diversity of the cloud native community, including: speed networking and mentoring, the diversity lunch, sessions on building a community through Meetups, the OSMI booth, and KubeCon + CloudNativeCon diversity scholarships.
</p>
												<p style="text-align: left;">
CNCF’s diversity program offered scholarships to 115 recipients from traditionally underrepresented and/or marginalized groups to attend
<a href="https://events19.linuxfoundation.org/events/kubecon-cloudnativecon-north-america-2019/">KubeCon + CloudNativeCon San Diego</a>
. These scholarships cover the cost of the ticket as well as airfare and lodging. In 2019, over $300,000 was&nbsp; donated for all KubeCon + CloudNativeCon conferences,
</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="vc_col-sm-6 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="wpb_text_column wpb_content_element ">
											<div class="wpb_wrapper">
												<p style="text-align: left;">funded mainly by CNCF and included donations from Aspen Mesh, CarGurus, Decipher Technology Studios, Google Cloud, MUFG, Palo Alto Networks, Splunk, and VMware. This was the largest investment made by a technology conference in fostering diversity and diversity programs. Also in 2019, CNCF increased the maximum travel stipend (from $1,500 to $2,000) and included the visa application fee (up to $160) as a reimbursable expense. Complimentary registration was also included for a CNCF-organized Day Zero co-located event.</p>
												<p style="text-align: left;">
Scholarship recipients received priority signup for professional headshots (prior to the general public) and VMware sponsored a Career Workshop exclusively for scholarship recipients. CNCF collaborated with the Kubernetes mentoring program to offer networking opportunities for mentees at
<a href="http://www.kubecon.io">KubeCon + CloudNativeCon</a>
. More than 100 mentees and 50 mentors participated in this program in San Diego.
</p>
												<p style="text-align: left;">Including the San Diego show, over the course of its life CNCF has offered more than 600 diversity scholarships to attend KubeCon + CloudNativeCon events.</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="fws_5f3e995e27c49" data-midnight="dark" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row standard_section" style="padding-top: 0px; padding-bottom: 25px; ">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg"></div>
							</div>
							<div class="row-bg-overlay"></div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-12 wpb_column column_container vc_column_container col padding-1-percent" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="left-right" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="img-with-animation-wrap " data-max-width="100%" data-border-radius="none">
											<div class="inner">
												<img loading="lazy" data-shadow="none" data-shadow-direction="middle" data-delay="0" height="362" width="1768" data-animation="none" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/google-cloud-01.svg" alt="" style="display: block; margin-top: 2rem;">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="community-awards" data-midnight="dark" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row standard_section" style="padding-top: 0px; padding-bottom: 0px; margin-bottom: 1rem;">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg  using-bg-color  " style="background-color: #eeeeee; "></div>
							</div>
							<div class="row-bg-overlay"></div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-12 wpb_column column_container vc_column_container col centered-text padding-1-percent" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="left-right" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="nectar-gradient-text" data-direction="horizontal" data-color="extra-color-gradient-1" style="margin-top: 10px; margin-bottom: 10px; ">
											<h2>Community Awards</h2>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="fws_5f3e995e283b8" data-midnight="dark" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row standard_section" style="padding-top: 25px; padding-bottom: 35px; ">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg"></div>
							</div>
							<div class="row-bg-overlay"></div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-6 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="left-right" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="" data-max-width="100%" data-border-radius="none">
											<div class="inner">
												<img loading="lazy" height="1025" width="1417" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/CNCF-Annual-Report-images-26-scaled.jpg" alt="">
											</div>
										</div>
										<div class="divider-wrap" data-alignment="default">
											<div style="height: 25px;" class="divider"></div>
										</div>
										<div class="wpb_text_column wpb_content_element ">
											<div class="wpb_wrapper">
												<p>
Now in their fourth year, the
<a href="https://www.cncf.io/announcements/2019/11/20/cloud-native-computing-foundation-announces-2019-community-awards-winners/">CNCF Community Awards</a>
highlighted the most active ambassador and top contributor across all CNCF projects. The awards were sponsored in 2019 by VMWare and included:
</p>
												<ul>
													<li>
														Top Cloud Native
														Committer –
														an individual with
														incredible technical
														skills
														and notable technical
														achievements in one or
														multiple CNCF projects.
														The
														2019 recipient was
														<a href="https://twitter.com/fredbrancz">Frederic
															Branczyk</a>
														.
													</li>
													<li>
														Top Cloud Native
														Ambassador
														– an individual with
														incredible
														community-oriented
														skills,
														focused on spreading the
														word and sharing
														knowledge
														with the entire cloud
														native
														community or within a
														specific project. The
														2019
														recipient was
														<a href="https://twitter.com/LachlanEvenson">Lachlan
															Evenson</a>
														.
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="vc_col-sm-6 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="wpb_text_column wpb_content_element ">
											<div class="wpb_wrapper">
												<p style="text-align: left;">
It is essential not to overlook the individuals who spend countless hours of time completing often mundane tasks. To recognize these contributors, CNCF created the “Chop Wood and Carry Water” awards. It was a proud moment for the cloud native community as CNCF recognized the tireless efforts of six individuals for their outstanding contributions from the past year:
<a href="https://twitter.com/BenzairReda">Reda Benzair</a>
,
<a href="https://twitter.com/KatharineBerry">Katharine Berry</a>
,
<a href="https://twitter.com/karenhchu">Karen Chu</a>
,
<a href="https://twitter.com/MrBobbyTables">Bob Killen</a>
,
<a href="https://twitter.com/idealhack">Yang Li</a>
and
<a href="https://twitter.com/Vivian_zly7755">张丽颖 Liying (Vivian) Zhang</a>
.
</p>
											</div>
										</div>
										<div class="divider-wrap" data-alignment="default">
											<div style="height: 25px;" class="divider"></div>
										</div>
										<div class="img-with-animation-wrap " data-max-width="100%" data-border-radius="none">
											<div class="inner">
												<img loading="lazy" height="1025" width="1528" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/CNCF-Annual-Report-images-27-scaled.jpg" alt="">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="meetups" data-midnight="dark" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row standard_section" style="padding-top: 0px; padding-bottom: 0px; ">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg"></div>
							</div>
							<div class="row-bg-overlay" style="background: #e50994; background: linear-gradient(90deg,#e50994 0%,#2825f2 100%);  opacity: 1; ">
							</div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-12 wpb_column column_container vc_column_container col centered-text padding-6-percent" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="left-right" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<a class="column-link" target="_self" href="https://www.cncf.io/cncf-kubernetes-project-journey/#code-diversity" rel="noopener noreferrer"></a>
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="divider-wrap" data-alignment="default">
											<div style="height: 40px;" class="divider"></div>
										</div>
										<div id="fws_5f3e995e29245" data-midnight="" data-column-margin="default" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row inner_row standard_section" style="padding-top: 0px; padding-bottom: 0px; ">
											<div class="row-bg-wrap">
												<div class="row-bg">
												</div>
											</div>
											<div class="col span_12  left">
												<div class="vc_col-sm-3 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-shadow="none" data-border-radius="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
													<div class="column-bg-overlay">
													</div>
													<div class="vc_column-inner">
														<div class="wpb_wrapper">
														</div>
													</div>
												</div>
												<div class="vc_col-sm-6 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-shadow="none" data-border-radius="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
													<div class="column-bg-overlay">
													</div>
													<div class="vc_column-inner">
														<div class="wpb_wrapper">
															<div class="img-with-animation-wrap " data-max-width="100%" data-border-radius="none">
																<div class="inner">
																	<img loading="lazy" data-shadow="none" data-shadow-direction="middle" data-delay="0" height="91" width="514" data-animation="fade-in" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/titles-07.svg" alt="">
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="vc_col-sm-3 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-shadow="none" data-border-radius="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
													<div class="column-bg-overlay">
													</div>
													<div class="vc_column-inner">
														<div class="wpb_wrapper">
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="wpb_text_column wpb_content_element ">
											<div class="wpb_wrapper">
												<h4>
													<span style="color: #ffffff;">
														<strong>
															In 2019, CNCF
															supported
															more than 217
															<a style="color: #ffffff;" href="https://meetups.cncf.io/">meetup</a>
															groups in 53
															countries,
															with greater than
															140,000 members. In
															2019, we experienced
															a
															75% increase in CNCF
															meetup members.
														</strong>
													</span>
												</h4>
											</div>
										</div>
										<div class="divider-wrap" data-alignment="default">
											<div style="height: 25px;" class="divider"></div>
										</div>
										<div id="fws_5f3e995e29a55" data-midnight="" data-column-margin="default" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row inner_row standard_section" style="padding-top: 0px; padding-bottom: 0px; ">
											<div class="row-bg-wrap">
												<div class="row-bg">
												</div>
											</div>
											<div class="col span_12  left">
												<div class="vc_col-sm-12 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-shadow="none" data-border-radius="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
													<div class="column-bg-overlay">
													</div>
													<div class="vc_column-inner">
														<div class="wpb_wrapper">
															<div class="img-with-animation-wrap " data-max-width="100%" data-border-radius="none">
																<div class="inner">
																	<img loading="lazy" data-shadow="none" data-shadow-direction="middle" data-delay="0" height="336" width="1498" data-animation="fade-in" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/CNCF-Annual-Report-images-28-1.svg" alt="">
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="divider-wrap" data-alignment="default">
											<div style="height: 5px;" class="divider"></div>
										</div>
										<div class="wpb_text_column wpb_content_element ">
											<div class="wpb_wrapper">
												<h2 style="text-align: center;">
													<span style="color: #ffffff;">CNCF
														Meetup Member
														Growth</span>
												</h2>
											</div>
										</div>
										<div class="divider-wrap" data-alignment="default">
											<div style="height: 25px;" class="divider"></div>
										</div>
										<div class="img-with-animation-wrap " data-max-width="100%" data-border-radius="none">
											<div class="inner">
												<img loading="lazy" data-shadow="none" data-shadow-direction="middle" data-delay="0" height="161" width="495" data-animation="fade-in" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/charts2-reportnew-01.svg" alt="">
											</div>
										</div>
										<div class="divider-wrap" data-alignment="default">
											<div style="height: 25px;" class="divider"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="kubernetes" data-midnight="dark" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row  vc_row-o-equal-height vc_row-flex  vc_row-o-content-top standard_section" style="padding-top: 60px; padding-bottom: 35px; ">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg"></div>
							</div>
							<div class="row-bg-overlay"></div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-8 wpb_column column_container vc_column_container col centered-text no-extra-padding" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="left-right" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div id="fws_5f3e995e2a642" data-midnight="" data-column-margin="default" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row inner_row standard_section  vc_custom_1579527701718" style="padding-top: 0px; padding-bottom: 0px; ">
											<div class="row-bg-wrap">
												<div class="row-bg">
												</div>
											</div>
											<div class="col span_12  left">
												<div class="vc_col-sm-12 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-shadow="none" data-border-radius="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
													<div class="column-bg-overlay">
													</div>
													<div class="vc_column-inner">
														<div class="wpb_wrapper">
															<div class="nectar-gradient-text" data-direction="horizontal" data-color="extra-color-gradient-1" style="margin-top: 17px; margin-bottom: 10px; ">
																<h2>Kubernetes
																	Community
																	Days
																</h2>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="divider-wrap" data-alignment="default">
											<div style="height: 5px;" class="divider"></div>
										</div>
										<div class="wpb_text_column wpb_content_element ">
											<div class="wpb_wrapper">
												<p style="text-align: left;">
In response to the communities’ evolving needs, CNCF wanted to create the opportunity for participants to connect on a local level by introducing
<a href="https://kubernetescommunitydays.org/">Kubernetes Community Days (KCD)</a>
. Launched in 2019, KCDs are community-organized events that gather adopters and technologists from open source and cloud native communities to learn, collaborate, and network. The goal of the events is to further the adoption and improvement of Kubernetes.
</p>
												<p style="text-align: left;">The CNCF supports Kubernetes Community Days by providing guidance and tools, which cover all the aspects of holding a successful event. These events are decentralized and focused on community engagement. We hope they will be fun and prove to be a useful way to meet new people while also building community. Local event organizers handle sponsorships, registration, and all other logistics. Each event brings its own local flair, culture, diversity, and authenticity (and its own logo and t-shirts, of course!)</p>
												<p style="text-align: left;">
To date, more than 40 KCDs are planned for 2020 across the world, on five continents (so far). For additional information about finding a KCD in your area or instructions to get involved,
<a href="https://kubernetescommunitydays.org/">visit the KCD homepage</a>
.
</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="vc_col-sm-4 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="img-with-animation-wrap " data-max-width="100%" data-border-radius="none">
											<div class="inner">
												<img loading="lazy" data-shadow="none" data-shadow-direction="middle" data-delay="0" height="1025" width="983" data-animation="fade-in" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/CNCF-Annual-Report-images-30-scaled.jpg" alt="">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="ambassador" data-midnight="dark" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row standard_section" style="padding-top: 0px; padding-bottom: 35px; ">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg"></div>
							</div>
							<div class="row-bg-overlay"></div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-12 wpb_column column_container vc_column_container col centered-text no-extra-padding" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="left-right" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div id="fws_5f3e995e2af8e" data-midnight="" data-column-margin="default" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row inner_row standard_section  vc_custom_1579527701718" style="padding-top: 0px; padding-bottom: 0px; ">
											<div class="row-bg-wrap">
												<div class="row-bg">
												</div>
											</div>
											<div class="col span_12  left">
												<div class="vc_col-sm-12 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-shadow="none" data-border-radius="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
													<div class="column-bg-overlay">
													</div>
													<div class="vc_column-inner">
														<div class="wpb_wrapper">
															<div class="nectar-gradient-text" data-direction="horizontal" data-color="extra-color-gradient-1" style="margin-top: 17px; margin-bottom: 10px; ">
																<h2>CNCF
																	Ambassador
																	Program</h2>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="divider-wrap" data-alignment="default">
											<div style="height: 5px;" class="divider"></div>
										</div>
										<div class="wpb_text_column wpb_content_element ">
											<div class="wpb_wrapper">
												<p style="text-align: left;">
Cloud Native Ambassadors (CNAs) are individuals who are passionate about Cloud Native Computing Foundation technology and projects, recognized for their expertise, and willing to help others learn about the framework and community. These individuals are bloggers, influencers, and evangelists. CNCF has 95
<a href="https://www.cncf.io/people/ambassadors/">CNCF Ambassadors</a>
around the globe educating the world on cloud native technologies and best practices.
</p>
												<p style="text-align: left;">
We accepted 28 new CNCF ambassadors and provided financial support for ambassador-run meetups in 2019. We are excited to have this worldwide group of people with diverse interests, experiences, and technical backgrounds help drive local and global cloud native communities. Please check out the
<a href="https://www.youtube.com/playlist?list=PLj6h78yzYM2OaNjjefJi5UnN9KQt8Q0qf">video interviews</a>
with several of our CNCF ambassadors or
<a href="https://www.cncf.io/blog/2018/09/07/meet-the-cncf-ambassadors/">read</a>
about them.
</p>
											</div>
										</div>
										<div class="divider-wrap" data-alignment="default">
											<div style="height: 25px;" class="divider"></div>
										</div>
										<div class="wpb_text_column wpb_content_element  vc_custom_1579623342708">
											<div class="wpb_wrapper">
												<h4 class="p1" style="text-align: center;">
													<span class="s1" style="color: #ffffff; font-weight: 700 !important;">NEW
														CNCF AMBASSADORS FOR
														2019</span>
												</h4>
											</div>
										</div>
										<div class="img-with-animation-wrap " data-max-width="100%" data-border-radius="none">
											<div class="inner">
												<img loading="lazy" data-shadow="none" data-shadow-direction="middle" data-delay="0" height="786" width="1920" data-animation="none" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/ambassadors-02-1-scaled.jpg" alt="">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="mentoring" data-midnight="dark" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row standard_section" style="padding-top: 0px; padding-bottom: 0px; ">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg  using-bg-color  " style="background-color: #eeeeee; "></div>
							</div>
							<div class="row-bg-overlay"></div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-12 wpb_column column_container vc_column_container col centered-text padding-1-percent" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="left-right" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="nectar-gradient-text" data-direction="horizontal" data-color="extra-color-gradient-1" style="margin-top: 17px; margin-bottom: 10px; ">
											<h2>Community Mentoring and
												Internships
											</h2>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="fws_5f3e995e2b89f" data-midnight="dark" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row  vc_row-o-equal-height vc_row-flex  vc_row-o-content-top standard_section" style="padding-top: 0px; padding-bottom: 35px; ">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg"></div>
							</div>
							<div class="row-bg-overlay"></div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-8 wpb_column column_container vc_column_container col centered-text padding-2-percent" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="right" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="divider-wrap" data-alignment="default">
											<div style="height: 40px;" class="divider"></div>
										</div>
										<div class="wpb_text_column wpb_content_element ">
											<div class="wpb_wrapper">
												<p style="text-align: left;">
CNCF is a proud supporter of various mentoring and internship opportunities including the
<a href="https://summerofcode.withgoogle.com/">Google Summer of Code (GSoC)</a>
program,
<a href="https://communitybridge.org/">CommunityBridge</a>
platform, and
<a href="https://www.outreachy.org/">Outreachy</a>
. As open source continues to take over the world, both programs are important catalysts for internships to have an impact on future technologies that we all depend on.
</p>
												<p style="text-align: left;">
Students accepted into the GSoC program have the opportunity to work with a mentor and become part of an active open source community. CNCF hosted 17 interns in 2019 – our largest class ever. Mentors from our community paired with interns and worked with them to help improve CNCF projects. You can find further details
<a href="https://www.cncf.io/blog/2019/08/23/cncf-joins-google-summer-of-code-2019-with-17-interns-projects-for-containerd-coredns-kubernetes-opa-prometheus-rook-and-more/">here</a>
.
</p>
												<p style="text-align: left;">
Recently launched by The Linux Foundation,
<a href="https://people.communitybridge.org/">CommunityBridge</a>
is a platform that aims to sustain open source projects while providing paid opportunities for new developers to join and learn from open source communities. In 2019, CNCF
<a href="https://www.cncf.io/blog/2019/08/22/cncf-hosts-three-student-internships-for-kubernetes-and-coredns-projects-through-linux-foundations-communitybridge/">sponsored three students</a>
to work on Kubernetes and CoreDNS projects. Additionally, CNCF
<a href="https://www.cncf.io/blog/2019/12/05/cncf-to-participate-in-the-community-bridge-mentorship-program/">kicked off another round of internships</a>
in December 2019 that included nine interns participating in seven CNCF projects.
</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="vc_col-sm-4 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="img-with-animation-wrap " data-max-width="100%" data-border-radius="none">
											<div class="inner">
												<img loading="lazy" data-shadow="none" data-shadow-direction="middle" data-delay="0" height="1025" width="759" data-animation="fade-in" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/CNCF-Annual-Report-images-31-scaled.jpg" alt="">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="ecosystem" data-midnight="dark" data-top-percent="1%" data-bottom-percent="1%" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row standard_section" style="padding-top: calc(100vw * 0.01); padding-bottom: calc(100vw * 0.01); ">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg"></div>
							</div>
							<div class="row-bg-overlay" style="background: #e50994; background: linear-gradient(90deg,#e50994 0%,#2825f2 100%);  opacity: 1; ">
							</div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-12 wpb_column column_container vc_column_container col centered-text padding-2-percent" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="left-right" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div id="fws_5f3e995e2c136" data-midnight="" data-column-margin="default" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row inner_row standard_section" style="padding-top: 0px; padding-bottom: 0px; ">
											<div class="row-bg-wrap">
												<div class="row-bg">
												</div>
											</div>
											<div class="col span_12  left">
												<div class="vc_col-sm-3 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-shadow="none" data-border-radius="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
													<div class="column-bg-overlay">
													</div>
													<div class="vc_column-inner">
														<div class="wpb_wrapper">
														</div>
													</div>
												</div>
												<div class="vc_col-sm-6 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-shadow="none" data-border-radius="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
													<div class="column-bg-overlay">
													</div>
													<div class="vc_column-inner">
														<div class="wpb_wrapper">
															<div class="img-with-animation-wrap " data-max-width="100%" data-border-radius="none">
																<div class="inner">
																	<img loading="lazy" data-shadow="none" data-shadow-direction="middle" data-delay="0" height="91" width="645" data-animation="fade-in" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/titles-08.svg" alt="">
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="vc_col-sm-3 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-shadow="none" data-border-radius="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
													<div class="column-bg-overlay">
													</div>
													<div class="vc_column-inner">
														<div class="wpb_wrapper">
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="devstats" data-midnight="dark" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row  vc_row-o-equal-height vc_row-flex  vc_row-o-content-top standard_section" style="padding-top: 25px; padding-bottom: 35px; ">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg"></div>
							</div>
							<div class="row-bg-overlay"></div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-6 wpb_column column_container vc_column_container col centered-text no-extra-padding" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="left-right" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div id="fws_5f3e995e2dcb3" data-midnight="" data-column-margin="default" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row inner_row standard_section  vc_custom_1579527701718" style="padding-top: 0px; padding-bottom: 0px; ">
											<div class="row-bg-wrap">
												<div class="row-bg">
												</div>
											</div>
											<div class="col span_12  left">
												<div class="vc_col-sm-12 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-shadow="none" data-border-radius="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
													<div class="column-bg-overlay">
													</div>
													<div class="vc_column-inner">
														<div class="wpb_wrapper">
															<div class="nectar-gradient-text" data-direction="horizontal" data-color="extra-color-gradient-1" style="margin-top: 17px; margin-bottom: 10px; ">
																<h2>CNCF Job
																	Board
																</h2>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="divider-wrap" data-alignment="default">
											<div style="height: 15px;" class="divider"></div>
										</div>
										<div class="wpb_text_column wpb_content_element ">
											<div class="wpb_wrapper">
												<p style="text-align: left;">
According to the
<a href="https://www.linuxfoundation.org/publications/2018/06/open-source-jobs-report-2018/">2018 Linux Foundation Open Source Jobs Report</a>
, containers are rapidly growing in popularity and importance; 57% of hiring managers are currently seeking container expertise. In response, CNCF launched its official job board in 2019.
</p>
												<p style="text-align: left;">The CNCF job board leverages an engaged audience of our 500-plus members and tens of thousands of monthly visitors to help employers find the perfect candidate. The job board is a free service for both posters and applicants. CNCF member job openings receive a featured listing.</p>
												<p style="text-align: left;">
The CNCF Job Board is an excellent and affordable way to connect with the world’s top cloud native developers and hire strong candidates. We invite you to post your job, search for candidates, or find your next employment opportunity
<a href="https://jobs.cncf.io/">through the CNCF Job Board</a>
.
</p>
											</div>
										</div>
										<div class="divider-wrap" data-alignment="default">
											<div style="height: 35px;" class="divider"></div>
										</div>
										<div id="fws_5f3e995e2e00f" data-midnight="" data-column-margin="default" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row inner_row standard_section  vc_custom_1579527701718" style="padding-top: 0px; padding-bottom: 0px; ">
											<div class="row-bg-wrap">
												<div class="row-bg">
												</div>
											</div>
											<div class="col span_12  left">
												<div class="vc_col-sm-12 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-shadow="none" data-border-radius="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
													<div class="column-bg-overlay">
													</div>
													<div class="vc_column-inner">
														<div class="wpb_wrapper">
															<div class="nectar-gradient-text" data-direction="horizontal" data-color="extra-color-gradient-1" style="margin-top: 17px; margin-bottom: 10px; ">
																<h2>DevStats
																</h2>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="divider-wrap" data-alignment="default">
											<div style="height: 15px;" class="divider"></div>
										</div>
										<div class="wpb_text_column wpb_content_element ">
											<div class="wpb_wrapper">
												<p style="text-align: left;">
In 2017, CNCF developed
<a href="https://k8s.devstats.cncf.io/">DevStats</a>
to provide the Kubernetes Steering Committee and SIG-Contributor Experience with timely and relevant insights into how Kubernetes was dealing with nearly unprecedented growth; Kubernetes is the second-largest community in open source, behind only Linux. The DevStats tool, which is open source, downloads several terabytes of
<a href="https://www.gharchive.org/">data</a>
representing every public GitHub action of the last five years, throws out nearly all of it except for the ~100 repos of CNCF-hosted projects, processes the data and stores it in a
<a href="https://www.postgresql.org/">Postgres</a>
database. DevStats organizes and displays CNCF-hosted project data using
<a href="https://grafana.com/">Grafana</a>
dashboards. DevStats downloads updated data every hour. More recently, we have been iterating on several modified versions of a project status
<a href="https://all.devstats.cncf.io/d/53/projects-health?orgId=1">dashboard</a>
based on feedback from the TOC and project maintainers.
</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="vc_col-sm-6 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="wpb_text_column wpb_content_element ">
											<div class="wpb_wrapper">
												<p style="text-align: left;">
In 2019, DevStats moved from bare metal to Kubernetes. The tool now uses Kubernetes, Helm, OpenEBS, CoreDNS, Let’s Encrypt, Nginx, Kubernetes Ingress, MetalLB, Postgres 11, Patroni, Docker, Newest
<a href="https://grafana.com/">Grafana</a>
, and
<a href="https://packet.net"> Packet</a>
(which provides complimentary hosting through
<a href="https://www.cncf.io/community/infrastructure-lab/">CNCF’s Community Infrastructure Lab</a>
). Further enhancements added include automatic backup support. DevStats remains one of the most powerful visualization tools available for understanding contributions to open source software. It is also a testament to the power of open source development. CNCF developer Lukasz Gryglicki, the primary developer on DevStats, is responsive to suggestions and pull requests that provide additional insights into the development of CNCF’s hosted projects.
</p>
											</div>
										</div>
										<div class="img-with-animation-wrap " data-max-width="100%" data-border-radius="none">
											<div class="inner">
												<img loading="lazy" data-shadow="none" data-shadow-direction="middle" data-delay="0" height="1025" width="1288" data-animation="fade-in" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/CNCF-Annual-Report-images-32-scaled.jpg" alt="">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="landscape" data-midnight="dark" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row standard_section" style="padding-top: 0px; padding-bottom: 0px; ">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg  using-bg-color  " style="background-color: #eeeeee; "></div>
							</div>
							<div class="row-bg-overlay"></div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-12 wpb_column column_container vc_column_container col centered-text padding-1-percent" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="left-right" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="nectar-gradient-text" data-direction="horizontal" data-color="extra-color-gradient-1" style="margin-top: 17px; margin-bottom: 10px; ">
											<h2>CNCF Landscape and Cloud Native
												Trail Map</h2>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="fws_5f3e995e2f080" data-midnight="dark" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row standard_section" style="padding-top: 0px; padding-bottom: 35px; ">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg"></div>
							</div>
							<div class="row-bg-overlay"></div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-12 wpb_column column_container vc_column_container col centered-text no-extra-padding" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="left-right" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="divider-wrap" data-alignment="default">
											<div style="height: 5px;" class="divider"></div>
										</div>
										<div class="wpb_text_column wpb_content_element ">
											<div class="wpb_wrapper">
												<p style="text-align: left;">
The CNCF Cloud Native
<a href="https://landscape.cncf.io/">Landscape</a>
has become the standard way of charting the myriad options in the cloud native ecosystem. The landscape started in November 2016 as a static image of fewer than 100 projects and products. It has grown through the power of collaborative editing to track more than 1,200 projects, products, and companies and now includes a
<a href="https://landscape.cncf.io/serverless">serverless</a>
landscape and the CNCF
<a href="https://landscape.cncf.io/members">member</a>
landscape. The project has more than 6,000 stars on GitHub.
</p>
												<p style="text-align: left;">
In 2018, CNCF released the Cloud Native
<a href="https://landscape.cncf.io/">Landscape</a>
2.0, an interactive version that allows viewers to filter, obtain detailed information on a specific project or technology, and easily share via stateful URLs. The landscape also captures funding and financing information for companies that are fostering and building businesses around cloud native technologies. The code used to generate the interactive landscape is open source with the data stored in a yaml
<a href="https://github.com/cncf/landscape/blob/master/landscape.yml">file</a>
. Every night, a server downloads updated GitHub data, financing information from Crunchbase, market cap data from Yahoo Finance, and CII
<a href="https://bestpractices.coreinfrastructure.org/en">Best Practices Badge</a>
information.
</p>
												<p style="text-align: left;">The Cloud Native Trailmap continues to show a path for organizations to adopt the graduated and incubating projects hosted by CNCF.</p>
											</div>
										</div>
										<div class="divider-wrap" data-alignment="default">
											<div style="height: 50px;" class="divider"></div>
										</div>
										<div id="fws_5f3e995e2f352" data-midnight="" data-column-margin="default" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row inner_row standard_section" style="padding-top: 0px; padding-bottom: 0px; ">
											<div class="row-bg-wrap">
												<div class="row-bg">
												</div>
											</div>
											<div class="col span_12  left">
												<div class="vc_col-sm-8 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-shadow="none" data-border-radius="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
													<div class="column-bg-overlay">
													</div>
													<div class="vc_column-inner">
														<div class="wpb_wrapper">
															<div class="img-with-animation-wrap " data-max-width="100%" data-border-radius="none">
																<div class="inner">
																	<img loading="lazy" data-shadow="none" data-shadow-direction="middle" data-delay="0" height="1025" width="1822" data-animation="none" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/landscape2-scaled.jpg" alt="">
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="vc_col-sm-4 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-shadow="none" data-border-radius="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
													<div class="column-bg-overlay">
													</div>
													<div class="vc_column-inner">
														<div class="wpb_wrapper">
															<div class="img-with-animation-wrap " data-max-width="100%" data-border-radius="none">
																<div class="inner">
																	<img loading="lazy" data-shadow="none" data-shadow-direction="middle" data-delay="0" height="1025" width="885" data-animation="none" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/CNCF_TrailMap_latest.jpg" alt="">
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="audits" data-midnight="dark" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row standard_section" style="padding-top: 0px; padding-bottom: 0px; ">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg  using-bg-color  " style="background-color: #eeeeee; "></div>
							</div>
							<div class="row-bg-overlay"></div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-12 wpb_column column_container vc_column_container col centered-text padding-1-percent" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="left-right" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="nectar-gradient-text" data-direction="horizontal" data-color="extra-color-gradient-1" style="margin-top: 17px; margin-bottom: 10px; ">
											<h2>CNCF Open Source Security Audits
											</h2>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="fws_5f3e995e31f96" data-midnight="dark" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row standard_section" style="padding-top: 0px; padding-bottom: 25px; ">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg"></div>
							</div>
							<div class="row-bg-overlay"></div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-12 wpb_column column_container vc_column_container col centered-text no-extra-padding" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="left-right" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="divider-wrap" data-alignment="default">
											<div style="height: 5px;" class="divider"></div>
										</div>
										<div class="wpb_text_column wpb_content_element ">
											<div class="wpb_wrapper">
												<p style="text-align: left;">
In 2018, the CNCF began performing and open sourcing security audits for its projects to improve the security of our ecosystem. The goal was to audit several projects and gather feedback from the CNCF community as to whether the pilot program was useful. The first projects to undergo this process were
<a href="https://github.com/kubernetes/community/blob/master/wg-security-audit/findings/Kubernetes%20Final%20Report.pdf">Kubernetes</a>
,
<a href="https://coredns.io/2018/03/15/cure53-security-assessment/">CoreDNS</a>
, and
<a href="https://github.com/envoyproxy/envoy/blob/master/docs/SECURITY_AUDIT.pdf">Envoy</a>
. In 2019, CNCF invested in security audits for Vitess, Jaeger, Fluentd, Linkerd, Falco, Harbor, gRPC, Helm, and Kubernetes, totaling approximately half a million dollars. These first public audits identified a variety of security issues, ranging from general weaknesses to critical vulnerabilities. Project maintainers for CoreDNS, Envoy, and Prometheus have addressed the identified vulnerabilities and added documentation to help users, thus improving the security of these projects.
</p>
												<p style="text-align: left;">
With funds provided by the CNCF community to conduct the Kubernetes security audit, the
<a href="https://github.com/kubernetes/community/tree/master/wg-security-audit">Security Audit Working Group</a>
was formed to lead the process of finding a reputable third-party vendor. The group created an open request for proposals. The group took responsibility for evaluating the proposals and recommending the vendor best suited to complete a security assessment against Kubernetes, bearing in mind the project’s high complexity and broad scope.
</p>
												<p style="text-align: left;">
This audit process was partially inspired by the
<a href="https://bestpractices.coreinfrastructure.org/en">Core Infrastructure Initiative (CII) Best Practices Badge program</a>
that all CNCF projects are required to complete. Provided by the Linux Foundation, this badge offers a clear and easy-to-understand way for open source projects to show that they follow security best practices. Adopters of open source software can use the badge to quickly assess which open source projects are following best practices, and as a result, are more likely to produce higher-quality, secure software.
</p>
												<p style="text-align: left;">Findings from the Kubernetes audit conducted over a few months revealed:</p>
												<ol style="text-align: left;">
													<li>Key security policies
														may
														not be applied, leading
														to a
														false sense of security.
													</li>
													<li>Insecure TLS is in use
														by
														default.</li>
													<li>Credentials are exposed
														in
														environment variables
														and
														command-line arguments.
													</li>
													<li>Names of secrets are
														leaked
														in logs.</li>
													<li>Kubernetes lacked
														certificate revocation.
													</li>
													<li>seccomp is not enabled
														by
														default.</li>
												</ol>
												<p style="text-align: left;">
By open sourcing security audits and processes, the working group hopes to inspire other projects to undertake similar efforts in their respective open source communities. Full findings and recommendations from the audits are listed
<a href="https://www.cncf.io/blog/2019/08/06/open-sourcing-the-kubernetes-security-audit/">here</a>
.
</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="geographic-diversity-of-contributors" data-midnight="dark" data-top-percent="1%" data-bottom-percent="1%" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row standard_section" style="padding-top: calc(100vw * 0.01); padding-bottom: calc(100vw * 0.01); ">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg"></div>
							</div>
							<div class="row-bg-overlay" style="background: #e50994; background: linear-gradient(90deg,#e50994 0%,#2825f2 100%);  opacity: 1; ">
							</div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-12 wpb_column column_container vc_column_container col centered-text padding-2-percent" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="left-right" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div id="fws_5f3e995e32460" data-midnight="" data-column-margin="default" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row inner_row standard_section" style="padding-top: 0px; padding-bottom: 0px; ">
											<div class="row-bg-wrap">
												<div class="row-bg">
												</div>
											</div>
											<div class="col span_12  left">
												<div class="vc_col-sm-3 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-shadow="none" data-border-radius="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
													<div class="column-bg-overlay">
													</div>
													<div class="vc_column-inner">
														<div class="wpb_wrapper">
														</div>
													</div>
												</div>
												<div class="vc_col-sm-6 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-shadow="none" data-border-radius="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
													<div class="column-bg-overlay">
													</div>
													<div class="vc_column-inner">
														<div class="wpb_wrapper">
															<div class="img-with-animation-wrap " data-max-width="100%" data-border-radius="none">
																<div class="inner">
																	<img loading="lazy" data-shadow="none" data-shadow-direction="middle" data-delay="0" height="91" width="612" data-animation="fade-in" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/titles-09.svg" alt="">
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="vc_col-sm-3 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-shadow="none" data-border-radius="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
													<div class="column-bg-overlay">
													</div>
													<div class="vc_column-inner">
														<div class="wpb_wrapper">
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="china" data-midnight="dark" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row  vc_row-o-equal-height vc_row-flex  vc_row-o-content-top standard_section" style="padding-top: 0px; padding-bottom: 35px; ">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg"></div>
							</div>
							<div class="row-bg-overlay"></div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-8 wpb_column column_container vc_column_container col centered-text padding-2-percent" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="right" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="divider-wrap" data-alignment="default">
											<div style="height: 25px;" class="divider"></div>
										</div>
										<div class="wpb_text_column wpb_content_element ">
											<div class="wpb_wrapper">
												<p style="text-align: left;">
We continue to grow the CNCF community in China. In 2019, we hosted the second
<a href="https://www.cncf.io/community/kubecon-cloudnativecon-events/">KubeCon + CloudNativeCon + Open Source Summit</a>
China, which was again held in Shanghai. The event attracted 3,500 attendees, strengthening the bridge between open source developers in China and the rest of the world.
</p>
												<p style="text-align: left;">
CNCF has grown from a few members in China in 2015 to nearly 50 in 2019. That number&nbsp; includes three Platinum (15% of Platinum members), six Gold (33% of Gold members), 37 Silver (nearly 10% of Silver members), one Nonprofit (7% of Nonprofits), and one End User Supporter (1% of End User Supporters). China now represents more than 10% of the CNCF total membership. China is also the
<a href="https://all.devstats.cncf.io/d/50/countries-statistics-in-repository-groups?orgId=1&amp;from=1452153600000&amp;to=1575619199000&amp;var-period_name=Year&amp;var-countries=All&amp;var-repogroup_name=All&amp;var-metric=contributors&amp;var-cum=countries">third-largest contributor</a>
to CNCF projects (in terms of contributors and committers) after the United States and Germany.
</p>
												<p style="text-align: left;">
PingCAP and Huawei led the way with
<a href="https://all.devstats.cncf.io/d/5/companies-table?orgId=1">55,837 and 49,645</a>
contributions, respectively, and are the sixth- and eighth-largest contributors overall. CNCF also hosts four CNCF projects that were born in China:
<a href="https://github.com/dragonflyoss/Dragonfly">Dragonfly</a>
(Alibaba),
<a href="https://github.com/goharbor/harbor">Harbor</a>
(VMware China), KubeEdge (Huawei), and
<a href="https://github.com/tikv/tikv">TiKV</a>
(PingCAP).
</p>
												<p style="text-align: left;">
Our Chinese community participated in a variety of training programs and
<a href="https://www.cncf.io/newsroom/case-studies-cn/">case studies</a>
in 2019, including 16% of KCSPs, 21.6% of KTPs, and 10.8% of CKAs. To help showcase best practices for this community, we published eight different case studies in 2019 featuring a variety of Chinese member companies, including Platinum end user member JD.com. We also launched a
<a href="https://www.cncf.io/blog/2019/04/17/cncf-and-alibaba-offer-free-cloud-native-course-for-chinese-developers/">Kubernetes and Cloud Native course</a>
in China that has been taken by 20,000+ people.
</p>
												<p style="text-align: left;">
We’re excited to build on this success by hosting
<a href="https://www.cncf.io/community/kubecon-cloudnativecon-events/">KubeCon + CloudNativeCon + Open Source Summit</a>
in Shanghai July 28-30, 2020.
</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="vc_col-sm-4 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="img-with-animation-wrap " data-max-width="100%" data-border-radius="none">
											<div class="inner">
												<img loading="lazy" data-shadow="none" data-shadow-direction="middle" data-delay="0" height="1025" width="741" data-animation="none" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/CNCF-Annual-Report-images-33.png" alt="">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="2020" data-midnight="dark" data-top-percent="1%" data-bottom-percent="1%" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row standard_section" style="padding-top: calc(100vw * 0.01); padding-bottom: calc(100vw * 0.01); margin-bottom: 2rem;">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg"></div>
							</div>
							<div class="row-bg-overlay" style="background: #e50994; background: linear-gradient(90deg,#e50994 0%,#2825f2 100%);  opacity: 1; ">
							</div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-12 wpb_column column_container vc_column_container col centered-text padding-2-percent" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="left-right" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div id="fws_5f3e995e33442" data-midnight="" data-column-margin="default" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row inner_row standard_section" style="padding-top: 0px; padding-bottom: 0px; ">
											<div class="row-bg-wrap">
												<div class="row-bg">
												</div>
											</div>
											<div class="col span_12  left">
												<div class="vc_col-sm-2 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-shadow="none" data-border-radius="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
													<div class="column-bg-overlay">
													</div>
													<div class="vc_column-inner">
														<div class="wpb_wrapper">
														</div>
													</div>
												</div>
												<div class="vc_col-sm-8 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-shadow="none" data-border-radius="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
													<div class="column-bg-overlay">
													</div>
													<div class="vc_column-inner">
														<div class="wpb_wrapper">
															<div class="img-with-animation-wrap " data-max-width="100%" data-border-radius="none">
																<div class="inner">
																	<img loading="lazy" data-shadow="none" data-shadow-direction="middle" data-delay="0" height="91" width="939" data-animation="fade-in" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2019/titles2-10.svg" alt="">
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="vc_col-sm-2 wpb_column column_container vc_column_container col no-extra-padding" data-t-w-inherits="default" data-shadow="none" data-border-radius="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
													<div class="column-bg-overlay">
													</div>
													<div class="vc_column-inner">
														<div class="wpb_wrapper">
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="fws_5f3e995e33b43" data-midnight="dark" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row standard_section" style="padding-top: 0px; padding-bottom: 25px; ">
						<div class="row-bg-wrap" data-bg-animation="none">
							<div class="inner-wrap ">
								<div class="row-bg"></div>
							</div>
							<div class="row-bg-overlay"></div>
						</div>
						<div class="col span_12 dark left">
							<div class="vc_col-sm-12 wpb_column column_container vc_column_container col centered-text no-extra-padding" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="left-right" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
								<div class="column-bg-overlay"></div>
								<div class="vc_column-inner">
									<div class="wpb_wrapper">
										<div class="divider-wrap" data-alignment="default">
											<div style="height: 5px;" class="divider"></div>
										</div>
										<div class="wpb_text_column wpb_content_element ">
											<div class="wpb_wrapper">
												<h3 style="text-align: left;">
													CNCF
													remains the fastest-growing
													foundation in the history of
													open source. The success of
													CNCF
													is directly attributable to
													our
													projects, the contributions
													of
													the community, our end
													users,
													and support from our member
													companies. Thank you!</h3>
												<p>&nbsp;</p>
												<p style="text-align: left;">As we look to 2020 and beyond, we remain committed to fostering and sustaining an ecosystem of open source, vendor-neutral projects and to making technology accessible for everyone. To thrive, we believe CNCF must continue to provide a neutral home for projects, encourage diversity, and continue to cultivate community. All three are crucial elements for growth.</p>
												<p style="text-align: left;">By continuing a wide array of initiatives, such as security audits, project journey reports, and documentation improvements, we are investing in the community to strengthen the cloud native ecosystem. We will continue with our core strategy of focusing on the developer community, helping developers progress into contributor and maintainer roles, and offering educational opportunities for those looking to grow and learn.</p>
												<p style="text-align: left;">Previously, in-person learning opportunities were offered at our flagship KubeCon + CloudNativeCon events. We are now aggressively expanding these learning opportunities. In 2019, we held our first Kubernetes Forums and launched Kubernetes Community Days to make these learning opportunities available to more people. We plan to expand both initiatives in 2020 to continue supporting community learning.</p>
												<p style="text-align: left;">Our sincere hope is that the CNCF community will continue to evolve as more and more new people join the ecosystem, thus furthering diversity and collaboration. We see signs of this as first-time attendees made up 65% of KubeCon + CloudNativeCon North America in San Diego.</p>
												<p style="text-align: left;">We also will continue to emphasize the growth of our end user community. We plan to continue our work to bring end users together to discuss best practices in the Telco, Research, and Financial Services sectors, and will next create an Automotive user group.</p>
												<p style="text-align: left;">
In summary, 2019 was an exceptional year for CNCF. We are well-positioned financially and organizationally to continue our mission to make cloud native computing ubiquitous and the de facto standard for software development and usage. We look forward to having you join us on this journey as we look to 2020 and beyond. Learn more at
<a href="https://www.cncf.io/">www.cncf.io</a>
.
</p>
											</div>
										</div>
									</div>
								</div>
							</div>
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
