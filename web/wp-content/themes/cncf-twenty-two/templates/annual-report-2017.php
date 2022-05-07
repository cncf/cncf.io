<?php
/**
 * Template Name: Annual Report 2017
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
	href="<?php echo esc_url( get_template_directory_uri() . '/build/annual-report-2017.min.css' ); ?>"
	as="style" crossorigin="anonymous" />

	<?php

	wp_enqueue_style( '2017', get_template_directory_uri() . '/build/annual-report-2017.min.css', array(), filemtime( get_template_directory() . '/build/annual-report-2017.min.css' ), 'all' );

	?>

<div id="ajax-content-wrap">
   <div class="home">
	  <div class="main annual-report-page">
		 <section class="banner-section" style="background-image: url('/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/GettyImages-banner-low.jpg')">
			<div class="container">
			   <img class="banner_logo" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/cncf_17_icon_image.png">
			</div>
		 </section>
		 <div class="container-wrap">
			<div class="container wrap">
			   <div>
				  <div class="wp-block-buttons aligncenter is-style-button-pdf">
					 <div class="wp-block-button"><a class="wp-block-button__link" href="https://www.cncf.io/wp-content/uploads/2020/08/CNCF-Annual-Report-2017.pdf">DOWNLOAD THIS REPORT</a></div>
				  </div>
			   </div>
			</div>
		 </div>
		 <div class="container-wrap">
			<div class="container">
			   <div class="row">
				  <div class="col-sm-12 col-md-3 sidebar-wrap">
					 <nav id="annual-report-sidebar" class="annual-report-sidebar">
						<h2>Overview</h2>
						<ul class="nav-items nav">
						   <li>
							  <a href="#welcome" rel="noopener">Welcome</a>
						   </li>
						   <li>
							  <a href="#who_we_are" rel="noopener">Who
							  We Are</a>
						   </li>
						   <li>
							  <a href="#cncf_membership" rel="noopener">CNCF Membership</a>
						   </li>
						   <li>
							  <a href="#end_user" rel="noopener">CNCF End User
							  Community</a>
						   </li>
						   <li>
							  <a href="#toc_projects" rel="noopener">TOC &amp; Project Updates</a>
						   </li>
						   <li>
							  <a href="#conferences_events" rel="noopener">Conferences and
							  Events</a>
						   </li>
						   <li>
							  <a href="#diversity" rel="noopener">Importance of
							  Diversity</a>
						   </li>
						   <li>
							  <a href="#community_awards" rel="noopener">Community Awards</a>
						   </li>
						   <li>
							  <a href="#training" rel="noopener">Training &amp;
							  Certification </a>
						   </li>
						   <li>
							  <a href="#software_conformance" rel="noopener">Software
							  Conformance</a>
						   </li>
						   <li>
							  <a href="#contact" rel="noopener">Contact Us</a>
						   </li>
						</ul>
					 </nav>
				  </div>
				  <div class="col-sm-12 col-md-9 content-wrap">
					 <section id="welcome" class="welcome_section" style="background-image: url('/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/welcome_image.jpg')">
						<div class="welcome_container">
						   <h2>Welcome</h2>
						   <p>Welcome to the 2017 Cloud Native Computing Foundation annual report. Comments and feedback are welcome at info@cncf.io.</p>
						</div>
					 </section>
					 <section id="who_we_are" class="who-we-are-section pink-blue-section">
						<h2>Who We Are</h2>
						<p>Cloud Native Computing Foundation (CNCF) is an open source software foundation dedicated to making cloud native computing universal and sustainable. Cloud native computing uses an open source software stack to deploy applications as microservices, packaging each part into its own container, and dynamically orchestrating those containers to optimize resource utilization. Cloud native technologies enable software developers to build great products faster.</p>
						<p>We are a community of open source projects, including Kubernetes, Envoy and Prometheus. Kubernetes and other CNCF projects are some of the highest velocity projects in the history of open source.</p>
						<ul class="items widthcol3">
						   <li>
							  <div class="content-wrap">
								 <div class="icon-wrap">
									<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Who_We_Are_icon_1.png">
								 </div>
								 <div class="text-wrap" data-mh="whoweare-text-wrap">
									<div class="number">18,687</div>
									<h6># OF CONTRIBUTORS TO CNCF
									   PROJECTS
									</h6>
								 </div>
							  </div>
						   </li>
						   <li>
							  <div class="content-wrap">
								 <div class="icon-wrap">
									<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Who_We_Are_icon_2.png">
								 </div>
								 <div class="text-wrap" data-mh="whoweare-text-wrap">
									<div class="number">20,322</div>
									<h6>REGISTERED FOR FREE
									   KUBERNETES EDX COURSE
									</h6>
								 </div>
							  </div>
						   </li>
						   <li>
							  <div class="content-wrap">
								 <div class="icon-wrap">
									<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Who_We_Are_icon_3.png">
								 </div>
								 <div class="text-wrap" data-mh="whoweare-text-wrap">
									<div class="number">53,925</div>
									<h6>CNCF MEETUP MEMBERS</h6>
								 </div>
							  </div>
						   </li>
						</ul>
					 </section>
					 <section id="cncf_membership" class="membership-section" style="background-image: url('/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/image_5.jpg')">
						<h2>Membership</h2>
						<p>It’s amazing to look back at the contributions that the cloud native community made last year. We started 2017 with 63 members and 4 projects (Kubernetes, Prometheus, Fluentd, and OpenTracing).</p>
						<p>We finished the year with 170 members and 14 projects. We added 8 platinum members from among the world’s largest public cloud and enterprise software companies: Alibaba Cloud, AWS, Dell Technologies, Microsoft, Oracle, Pivotal, SAP, and VMware. New Gold members last year were Baidu, JFrog, and Salesforce. 75 new members joined at the Silver level.</p>
						<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/MAMBERSHIP_number_img.png" alt="Membership">
					 </section>
					 <section id="end_user" class="members-and-growing-section">
						<h2>170 Members and Growing</h2>
						<div class="members_type_items">
						   <div class="members_type_item">
							  <h4>Platinum</h4>
							  <ul class="items widthcol5 ">
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/icon-1.png" alt="Alibaba Cloud">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/icon-2.png" alt="AWS">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/icon-3.png" alt="Azure">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/icon-4.png" alt="cisco">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/icon-5.png" alt="coreOS">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/icon-6.png" alt="Dell Technologies">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/icon-7.png" alt="Docker">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/icon-8.png" alt="Fujitsu">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/icon-9.png" alt="Google Cloud">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/icon-10.png" alt="Huawei">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/icon-11.png" alt="IBM">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/icon-12.png" alt="Intel">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/icon-13.png" alt="Mesosphere">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/icon-14.png" alt="Oracal">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/icon-15.png" alt="Pivotal">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/icon-16.png" alt="Redhat">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/icon-17.png" alt="Samsung">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/icon-18.png" alt="SAP">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/icon-19.png" alt="Vmware">
									</div>
								 </li>
							  </ul>
						   </div>
						   <div class="members_type_item">
							  <h4>Gold</h4>
							  <ul class="items widthcol5 ">
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/gold_1.png" alt="AT&amp;T">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/gold_2.png" alt="Baidu">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/gold_3.png" alt="Jfrog">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/gold_4.png" alt="NetApp">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/gold_5.png" alt="Salesforce">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/gold_6.png" alt="Suse">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/gold_7.png" alt="Tencent Cloud">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/gold_8.png" alt="ZTE">
									</div>
								 </li>
							  </ul>
						   </div>
						   <div class="members_type_item">
							  <h4>End User Members</h4>
							  <ul class="items widthcol5 ">
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/End_User_Members_1.png" alt="Bloomberg">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/End_User_Members_2.png" alt="Capital One">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/End_User_Members_3.png" alt="Ebay">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/End_User_Members_4.png" alt="Wikimedia">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/End_User_Members_5.png" alt="Goldman Sachs">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/End_User_Members_6.png" alt="Morgan Stanley">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/End_User_Members_7.png" alt="Ncsoft">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/End_User_Members_8.png" alt="GitHub">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/End_User_Members_9.png" alt="Pinterest">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/End_User_Members_10.png" alt="Salesforces">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/End_User_Members_11.png" alt="Twitter">
									</div>
								 </li>
							  </ul>
						   </div>
						   <div class="members_type_item">
							  <h4>End User Supporters</h4>
							  <ul class="items widthcol5 ">
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/End_User_Supporters_1.png" alt="Box">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/End_User_Supporters_2.png" alt="Cruise">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/End_User_Supporters_3.png" alt="Concur">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/End_User_Supporters_4.png" alt="Kuetap">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/End_User_Supporters_5.png" alt="zendesk">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/End_User_Supporters_6.png" alt="olark">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/End_User_Supporters_7.png" alt="Shopify">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/End_User_Supporters_8.png" alt="Showwax">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/End_User_Supporters_9.png" alt="Nasdaq">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/End_User_Supporters_10.png" alt="The new work time">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/End_User_Supporters_11.png" alt="Spredfast">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/End_User_Supporters_12.png" alt="SteelHouse">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/End_User_Supporters_13.png" alt="Ticketmaster">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/End_User_Supporters_14.png" alt="Vevo">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/End_User_Supporters_15.png" alt="Wpengin">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/End_User_Supporters_16.png" alt="zalando">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/End_User_Supporters_17.png" alt="reddit">
									</div>
								 </li>
							  </ul>
						   </div>
						   <div class="members_type_item">
							  <h4>Academic/Nonprofit</h4>
							  <ul class="items widthcol5 floatleft">
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Academic_Nonprofit_1.png" alt="CloudFoundry">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Academic_Nonprofit_2.png" alt="SEL">
									</div>
								 </li>
								 <li>
									<div class="member">
									   <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Academic_Nonprofit_3.png" alt="Wikimedia">
									</div>
								 </li>
							  </ul>
						   </div>
						</div>
					 </section>
					 <section class="user_community-section" style="background-image: url('/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/image_1.jpg')">
						<h2>End User Community</h2>
						<div class="row">
						   <div class="col-xs-12 col-sm-12 col-md-4 col-md-push-8">
							  <p class="qoute">
							  </p><p class="qoute">
								 Our end user community is growing and
								 <br>
								 we finished
								 <br>
								 2017 with top
								 <span>32 </span>
								 companies &amp; startups
							  </p>
							  <p></p>
						   </div>
						   <div class="col-xs-12 col-sm-12 col-md-8 col-md-pull-4">
							  <p>We offer multiple opportunities for end users to contribute and have their voices heard. Companies that use cloud native technologies internally, but do not sell any cloud native services externally, are eligible to join the end user community. Our end user community is growing and we finished 2017 with 32 top companies and startups that are committed to accelerating the adoption of cloud native technologies and improving the deployment experience. Also in 2017 the End User Community elected Sam Lambert of GitHub to the CNCF Technical Oversight Committee (TOC) to represent their interests.</p>
							  <p>Cruise, Olark, Pinterest, SAP Concur, Showmax, Spredfast, and WP Engine join other end user companies including Box, Capital One, eBay, GitHub, Goldman Sachs, NCSOFT, Ticketmaster, Twitter, Vevo, and Zalando in CNCF’s End User Community. This group meets monthly and advises CNCF Governing Board and TOC members on key challenges, emerging use cases, and areas of opportunity and new growth for cloud native technologies.</p>
						   </div>
						</div>
					 </section>
					 <section class="user-community-companies-section">
						<h2>32 Companies in the End User Community</h2>
						<ul class="items widthcol4">
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Companies_End_User_Community_1.png" alt="Bloomberg">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Companies_End_User_Community_2.png" alt="box">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Companies_End_User_Community_3.png" alt="Capital One">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Companies_End_User_Community_4.png" alt="Concur">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Companies_End_User_Community_5.png" alt="Cruise ">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Companies_End_User_Community_6.png" alt="ebay">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Companies_End_User_Community_7.png" alt="GitHub">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Companies_End_User_Community_8.png" alt="Goldman">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Companies_End_User_Community_9.png" alt="Kuelap">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Companies_End_User_Community_10.png" alt="Morgan Stanley">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Companies_End_User_Community_11.png" alt="Nasdaq">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Companies_End_User_Community_12.png" alt="Ncsoft">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Companies_End_User_Community_13.png" alt="The New work times">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Companies_End_User_Community_14.png" alt="Olark">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Companies_End_User_Community_15.png" alt="Pinterest">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Companies_End_User_Community_16.png" alt="reddit">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Companies_End_User_Community_17.png" alt="Salesforce">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Companies_End_User_Community_18.png" alt="Shopify">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Companies_End_User_Community_19.png" alt="Showwax">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Companies_End_User_Community_20.png" alt="Zendesk">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Companies_End_User_Community_21.png" alt="Spredfast">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Companies_End_User_Community_22.png" alt="SteelHouse">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Companies_End_User_Community_23.png" alt="Ticketmaster">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Companies_End_User_Community_24.png" alt="Twitter">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Companies_End_User_Community_25.png" alt="Vevo">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Companies_End_User_Community_26.png" alt="Wikimedia">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Companies_End_User_Community_27.png" alt="Wp engine">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Companies_End_User_Community_28.png" alt="Zalando">
							  </div>
						   </li>
						</ul>
						<p>To better listen to our community, we conducted a survey to learn more about the state of Kubernetes’ deployments and other container management platforms, as well the progress of container deployment in general. More than 550 community members responded. The future of cloud-native is exciting, with more than 93% of respondents recommending CNCF technologies.</p>
					 </section>
					 <div class="pink-blue-line"></div>
					 <section id="toc_projects" class="toc-section">
						<h2>
						   Technical Oversight Committee
						   <br>
						   (TOC) and Project Updates
						</h2>
						<div class="toc-content">
						   <p>2017 was very busy in terms of project activity. Many milestone releases demonstrated steady forward progress for each of these projects. Highlights include the addition of 10 new projects (listed in order of date accepted) accepted by the CNCF TOC:</p>
						   <ul style="width: 50%; float: left;">
							  <li>Linkerd</li>
							  <li>gRPC</li>
							  <li>CoreDNS</li>
							  <li>Containerd</li>
							  <li>rkt</li>
						   </ul>
						   <ul style="width: 50%; float: left;">
							  <li>CNI</li>
							  <li>Envoy</li>
							  <li>Jaeger</li>
							  <li>Notary</li>
							  <li>TUF</li>
						   </ul>
						   <p>
							  <strong>Kubernetes 1.9</strong>
							  release offers a stable core workloads API and beta support for windows server containers enabling customers to run .Net and Windows-based apps on Kubernetes.
						   </p>
						   <p>The communities working on CNCF projects continue to be active. In fact, 6 projects reached their 1.0 milestone in 2017, and Prometheus reached 2.0, with significant performance improvements.</p>
						   <ul>
							  <li>
								 <strong>Containerd:</strong>
								 announced stable API exposed via
								 gRPC
							  </li>
							  <li>
								 <strong>Fluentd:</strong>
								 announced native TLS/SSL support for
								 secure logging
							  </li>
							  <li>
								 <strong>Jaeger:</strong>
								 announced a new C++ library and
								 integration with other CNCF projects
								 like Kubernetes, Prometheus, Envoy
							  </li>
							  <li>
								 <strong>Envoy:</strong>
								 announced gRPC v2 API as production
								 ready
							  </li>
						   </ul>
						   <p>
							  <strong>Prometheus</strong>
							  2.0 was a particularly notable release with a brand new storage engine resulting in significant performance: 3x reduction in CPU usage, ~2x reduction in disk space, and ~100x reduction in I/O.
						   </p>
						   <p>CNCF has a thriving technical community, with oversight provided by its TOC. In 2017, the TOC created the following working groups to investigate and evaluate approaches for the following topics:</p>
						   <ul>
							  <li>
								 <strong>Continuous Integration
								 (CI):</strong>
								 The main focus is deploying the
								 cross-cloud CI project to
								 demonstrate deploying each CNCF
								 project across each of the major
								 public clouds and bare metal
								 provided by CNCF’s Community
								 Infrastructure Lab.
							  </li>
							  <li>
								 <strong>Networking:</strong>
								 Exploring cloud native networking
								 technology and concepts around the
								 Container Networking Interface
								 (CNI).
							  </li>
							  <li>
								 <strong>Serverless:</strong>
								 Investigating how serverless is an
								 important part of the cloud native
								 ecosystem.
							  </li>
							  <li>
								 <strong>Storage:</strong>
								 Exploring cloud native storage
								 technology and concepts.
							  </li>
						   </ul>
						</div>
					 </section>
					 <section id="conferences_events" class="conferences-section" style="background-image: url('/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/image_6.jpg')">
						<h2>Conferences and Events</h2>
						<p>KubeCon + CloudNativeCon North America, held December 6-8, 2017 in Austin, was a major success with record-breaking registrations, attendance, sponsorships, and co-located events. The event generated 4,212 registrations with an unusually high 97% attending. Audience engagement was incredibly high with 1,101 companies participating from 51 countries across 6 continents and representation from 133 CNCF members and 968 ecosystem companies.</p>
						<p>Co-chairs, Kelsey Hightower of Google, and Michelle Noorali of Microsoft led a program committee of more than 50 to carefully curate the content. Keynote speakers included Clayton Coleman of Red Hat, Jesse Newland of GitHub, Sarah Novotny and Brian Grant of Google, and Zihao Yu and Ilya Chekrygin of HBO.</p>
						<p>Sponsor count for KubeCon + CloudNativeCon in December more than doubled to 106 in 2017 compared to 40 the previous year.</p>
						<ul class="items widthcol5">
						   <li class="whoweare-item">
							  <div class="text-wrap" data-mh="whoweare-text-wrap">
								 <div class="number">4,212</div>
								 <h6>REGISTRATIONS</h6>
							  </div>
						   </li>
						   <li class="whoweare-item">
							  <div class="text-wrap" data-mh="whoweare-text-wrap">
								 <div class="number">106</div>
								 <h6>SPONSORS</h6>
							  </div>
						   </li>
						   <li class="whoweare-item">
							  <div class="text-wrap" data-mh="whoweare-text-wrap">
								 <div class="number">
									97
									<span>%</span>
								 </div>
								 <h6>ATTENDANCE</h6>
							  </div>
						   </li>
						   <li class="whoweare-item">
							  <div class="text-wrap" data-mh="whoweare-text-wrap">
								 <div class="number">51</div>
								 <h6>COUNTRIES</h6>
							  </div>
						   </li>
						   <li class="whoweare-item">
							  <div class="text-wrap" data-mh="whoweare-text-wrap">
								 <div class="number">1,101</div>
								 <h6>COMPANIES</h6>
							  </div>
						   </li>
						</ul>
					 </section>
					 <section id="diversity" class="importance-of-diversity-section">
						<h2>Importance of Diversity</h2>
						<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/image_4.jpg">
						<p class="quote">
						   <span>103</span>
						   Diversity and need-based registration scholarships
						</p>
						<p>Part of supporting the continued development of this amazing community is making sure that everyone who wants to participate feels welcome to do so regardless of gender, gender identity, sexual orientation, disability, race, ethnicity, age, religion, or economic status. Education, inclusion, and collaboration are vital to the future of the cloud native ecosystem. To increase and encourage multiple perspectives, and with extraordinary contributions from Google Cloud and Microsoft Azure, CNCF was able to provide $250,000 in diversity scholarships, an unprecedented investment in increasing the diversity of a tech conference. With additional contributions from AWS and Twistlock, CNCF was able to provide 103 diversity scholarships. We are a community of open source projects, including Kubernetes, Envoy, and Prometheus. Kubernetes and other CNCF projects are some of the highest velocity projects in the history of open source.</p>
					 </section>
					 <div class="pink-blue-line"></div>
					 <section id="community_awards" class="community-awards-section">
						<h2>Community Awards</h2>
						<p>With large open source projects, it is important to recognize essential contributors who complete the myriad community building tasks. That is why CNCF created the Chop Wood/Carry Water awards.</p>
						<div class="recipients">
						   <h3>2017 TOP CLOUD-NATIVE RECIPIENTS</h3>
						   <div class="content">
							  <div class="row">
								 <div class="col-sm-5">
									<h4>Committer</h4>
									<ul class="items widthcol1">
									   <li>
										  <div class="item">
											 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Community_Awards_member_1.png" alt="Clayton Coleman">
											 <span class="name">Clayton
											 Coleman</span>
											 <span class="company">Red
											 Hat</span>
										  </div>
									   </li>
									</ul>
								 </div>
								 <div class="col-sm-7">
									<h4>Ambassador</h4>
									<ul class="items widthcol2">
									   <li>
										  <div class="item">
											 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Community_Awards_member_2.png" alt="Sarah Novotny">
											 <span class="name">Sarah
											 Novotny</span>
											 <span class="company">Google</span>
										  </div>
									   </li>
									   <li>
										  <div class="item">
											 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Community_Awards_member_3.png" alt="Lucas Käldström">
											 <span class="name">Lucas
											 Käldström</span>
											 <span class="company">Kubernetes</span>
										  </div>
									   </li>
									</ul>
								 </div>
							  </div>
						   </div>
						</div>
					 </section>
					 <section id="training_certification" class="training-certification-section" style="background-image: url('/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/image_3.jpg')">
						<div class="row">
						   <div class="col-sm-12 col-md-6">
							  <h2>Training &amp; Certification</h2>
							  <p>Adopting new technology can be challenging, especially when it’s hard to find qualified people. CNCF offers training and certification for key CNCF technologies like Kubernetes to ensure that organizations can train their own employees or hire from a strong body of experienced talent. In July 2017, we announced the free Kubernetes Massively Open Online Course (MOOC), self-paced and instructor-led Kubernetes training, through our partnership with edX.</p>
							  <p>In September 2017, we offered the official Certified Kubernetes Administrator certification to ensure a high level of expertise in the ecosystem. Kubernetes Certified Service Provider (KCSP) program is a pre-qualified tier of vetted service providers that offer Kubernetes support, consulting, professional services, and training for organizations embarking on their Kubernetes journey. The KCSP program ensures enterprises get the support needed to roll out new applications faster and more efficiently than before, while feeling secure that there’s a trusted and vetted partner available to support their production and operational needs.</p>
						   </div>
						   <div class="col-sm-12 col-md-6" id="software_conformance">
							  <h2>Software Conformance</h2>
							  <p>It is nearly unprecedented to get every cloud company, enterprise software provider, and startup in the industry to support a conformance program. It is an extraordinary accomplishment that there are no forks in our industry, which speaks to the commitment that companies of all sizes have made to be good partners in the community.</p>
							  <p>The community response was overwhelming; CNCF has certified offerings from 44 vendors.</p>
						   </div>
						</div>
					 </section>
					 <section class="certified-kubernetes-item-section pink-blue-section">
						<ul class="items widthcol3">
						   <li class="whoweare-item">
							  <div class="text-wrap" data-mh="whoweare-text-wrap">
								 <div class="number">44</div>
								 <h6>CERTIFIED KUBERNETES PARTNERS
								 </h6>
							  </div>
						   </li>
						   <li class="whoweare-item">
							  <div class="text-wrap" data-mh="whoweare-text-wrap">
								 <div class="number">28</div>
								 <h6>CERTIFIED KUBERNETES SERVICE
									PROVIDERS
								 </h6>
							  </div>
						   </li>
						   <li class="whoweare-item">
							  <div class="text-wrap" data-mh="whoweare-text-wrap">
								 <div class="number">20,322</div>
								 <h6>REGISTERED FOR FREE EDX
									KUBERNETES COURSE
								 </h6>
							  </div>
						   </li>
						</ul>
					 </section>
					 <section class="certified-kubernetes-section">
						<h2>44 Certified Kubernetes Partners</h2>
						<ul class="items widthcol4">
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Certi-ed_Kubernetes_Partners_1.png" alt="Alacdo">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Certi-ed_Kubernetes_Partners_2.png" alt="Alibaba Cloud">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Certi-ed_Kubernetes_Partners_3.png" alt="apprenda ">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Certi-ed_Kubernetes_Partners_4.png" alt="appscode">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Certi-ed_Kubernetes_Partners_5.png" alt="caicloud">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Certi-ed_Kubernetes_Partners_6.png" alt="canonical">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Certi-ed_Kubernetes_Partners_7.png" alt="cisco">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Certi-ed_Kubernetes_Partners_8.png" alt="cloud foundry">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Certi-ed_Kubernetes_Partners_9.png" alt="CoreOS">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Certi-ed_Kubernetes_Partners_10.png" alt="Daocloud">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Certi-ed_Kubernetes_Partners_11.png" alt="EasySack">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Certi-ed_Kubernetes_Partners_12.png" alt="GhostCloud">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Certi-ed_Kubernetes_Partners_13.png" alt="Giant Swarm">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Certi-ed_Kubernetes_Partners_14.png" alt="Docker">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Certi-ed_Kubernetes_Partners_15.png" alt="Google Cloud">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Certi-ed_Kubernetes_Partners_16.png" alt="Hasura">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Certi-ed_Kubernetes_Partners_17.png" alt="Heptio">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Certi-ed_Kubernetes_Partners_18.png" alt="Huawei">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Certi-ed_Kubernetes_Partners_19.png" alt="IBM">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Certi-ed_Kubernetes_Partners_20.png" alt="ise2c">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Certi-ed_Kubernetes_Partners_21.png" alt="inwinstack">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Certi-ed_Kubernetes_Partners_22.png" alt="joyent">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Certi-ed_Kubernetes_Partners_23.png" alt="kinvolk">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Certi-ed_Kubernetes_Partners_24.png" alt="kublr">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Certi-ed_Kubernetes_Partners_25.png" alt="loodse">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Certi-ed_Kubernetes_Partners_26.png" alt="mesosphere">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Certi-ed_Kubernetes_Partners_27.png" alt="Microsoft">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Certi-ed_Kubernetes_Partners_28.png" alt="Mirantis">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Certi-ed_Kubernetes_Partners_29.png" alt="Samsung">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Certi-ed_Kubernetes_Partners_30.png" alt="SAP">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Certi-ed_Kubernetes_Partners_31.png" alt="Nirmata">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Certi-ed_Kubernetes_Partners_32.png" alt="NetEase Cloud ">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Certi-ed_Kubernetes_Partners_33.png" alt="Oracle">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Certi-ed_Kubernetes_Partners_34.png" alt="pivotal">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Certi-ed_Kubernetes_Partners_35.png" alt="Platform">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Certi-ed_Kubernetes_Partners_36.png" alt="typhoon">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Certi-ed_Kubernetes_Partners_37.png" alt="Rancher">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Certi-ed_Kubernetes_Partners_38.png" alt="Redhat">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Certi-ed_Kubernetes_Partners_39.png" alt="Vmware">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Certi-ed_Kubernetes_Partners_40.png" alt="weaveWorks">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Certi-ed_Kubernetes_Partners_41.png" alt="Stack Point Cloud">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Certi-ed_Kubernetes_Partners_42.png" alt="Suse">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Certi-ed_Kubernetes_Partners_43.png" alt="Tencent Cloud">
							  </div>
						   </li>
						   <li>
							  <div class="company">
								 <img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/Certi-ed_Kubernetes_Partners_44.png" alt="Alavda ">
							  </div>
						   </li>
						</ul>
					 </section>
					 <section id="contact" class="contact_us-section" style="background-image: url('/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/image_2.jpg')">
						<p>
						   CNCF will continue to build sustainable ecosystems and foster a community around a constellation of high quality projects that orchestrate containers as part of a microservices architecture. We hope you will join us on our mission in 2018. Learn more at
						   <a href="https://www.cncf.io/">
						   <strong>www.cncf.io</strong>
						   </a>
						   .
						</p>
						<img loading="lazy" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2017/logo-CNCF.png">
						<ul class="detail">
						   <li>cncf.io</li>
						   <li>415-723-9709</li>
						   <li>1 Letterman Drive, Suite D4700</li>
						   <li>San Francisco, CA 94129</li>
						   <li>United States</li>
						</ul>
					 </section>
					 <div class="pink-blue-line"></div>
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
