<?php
/**
 * Template Name: End User Community
 * Template Post Type: page
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

get_template_part( 'components/header' );

get_template_part( 'components/hero' );
?>

<?php
wp_enqueue_script( 'font-awesome', 'https://kit.fontawesome.com/5db798d128.js', array(), filemtime( get_template_directory() . '/build/global.js' ), 'all' );
?>
<main class="page-content end-user-page">
	<article class="container wrap entry-content">
		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				the_content();
				?>



		<!-- wp:spacer {"height":80,"className":"is-style-80-responsive"} -->
		<div style="height:80px" aria-hidden="true"
			class="wp-block-spacer is-style-80-responsive"></div>
		<!-- /wp:spacer -->

		<!-- wp:group {"align":"full","backgroundColor":"blue-100"} -->
		<div
			class="wp-block-group alignfull has-blue-100-background-color has-background">
			<div class="wp-block-group__inner-container">
				<!-- wp:spacer {"height":80,"className":"is-style-80-responsive"} -->
				<div style="height:80px" aria-hidden="true"
					class="wp-block-spacer is-style-80-responsive"></div>
				<!-- /wp:spacer -->


				<?php
				// setup the arguments.
				$args = array(
					'posts_per_page'      => 3,
					'post_type'           => array( 'post' ),
					'post_status'         => array( 'publish' ),
					'has_password'        => false,
					'ignore_sticky_posts' => true,
					'order'               => 'DESC',
					'orderby'             => 'date',
					'no_found_rows'       => true,
					'tax_query'           => array(
						array(
							'taxonomy' => 'category',
							'field'    => 'term_id',
							'terms'    => 1036,
						),
					),
				);

				$query = new WP_Query( $args );

				// if no posts.
				if ( ! $query->have_posts() ) {
					return 'Sorry, there are no posts.';
				}

				if ( $query->have_posts() ) {
					?>


				<!-- wp:columns {"className":"is-style-section-header-column"} -->
				<div class="wp-block-columns is-style-section-header-column">
					<!-- wp:column {"width":"90%","className":"bh-01"} -->
					<div class="wp-block-column bh-01" style="flex-basis:90%">
						<!-- wp:heading {"level":3,"placeholder":"Section header text","className":"is-style-max-width-100"} -->
						<h2 class="is-style-max-width-100">Latest news and
							insights from our end user community</h2>
						<!-- /wp:heading -->
					</div>
					<!-- /wp:column -->

					<!-- wp:column {"width":"10%","className":"bh-02"} -->
					<div class="wp-block-column bh-02" style="flex-basis:10%">
						<!-- wp:heading {"level":6,"placeholder":"View all...","className":"is-style-add-chevron-after"} -->
						<h6 class="is-style-add-chevron-after"><a
								href="/blog">See all blog posts</a></h6>
						<!-- /wp:heading -->
					</div>
					<!-- /wp:column -->
				</div>
				<!-- /wp:columns -->
				<div class="wp-block-columns better-responsive-columns">
					<?php
					while ( $query->have_posts() ) :
						$query->the_post();
						echo '<div class="wp-block-column" style="flex-basis:33.33%">';
						lf_newsroom_show_post( get_the_ID(), true, false );
						echo '</div>';
				endwhile;
					wp_reset_postdata();
					?>
				</div>

					<?php
				}
				?>
				<!-- end of newsroom -->

				<!-- wp:spacer {"height":20} -->
				<div style="height:20px" aria-hidden="true"
					class="wp-block-spacer"></div>
				<!-- /wp:spacer -->

				<!-- wp:shortcode -->
				<?php echo do_shortcode( '[eu_playlist key="AIzaSyB63Mb5LIvCSVuPQi778uxOAPl64QXK_-M"]' ); ?>
				<!-- /wp:shortcode -->

				<!-- wp:spacer {"height":80,"className":"is-style-80-responsive"} -->
				<div style="height:80px" aria-hidden="true"
					class="wp-block-spacer is-style-80-responsive"></div>
				<!-- /wp:spacer -->
			</div>
		</div>
		<!-- /wp:group -->

		<!-- wp:group {"align":"full","backgroundColor":"tertiary-400","className":"is-style-default"} -->
		<div
			class="wp-block-group alignfull is-style-default has-tertiary-400-background-color has-background">
			<div class="wp-block-group__inner-container">
				<!-- wp:spacer {"className":"is-style-40-responsive"} -->
				<div style="height:100px" aria-hidden="true"
					class="wp-block-spacer is-style-40-responsive"></div>
				<!-- /wp:spacer -->

				<!-- wp:heading {"level":3,"textColor":"white"} -->
				<h2 class="has-white-color has-text-color">End user
					representatives</h2>
				<!-- /wp:heading -->

				<div class="enduser-people-wrapper hide-descriptions">

					<div class="people-box">
						<!-- thumbnail  -->
						<button data-modal-content-id="modal-51113"
							data-modal-prefix-class="lf"
							data-modal-close-text="Close"
							class="js-modal button-reset" aria-label="Close"
							id="label_modal_3" aria-haspopup="dialog">
							<div
								class="background-image-wrapper people-profile-picture">
								<figure class="background-image-figure">
									<img loading="lazy" class=""
										src="/wp-content/uploads/2020/08/14233189_10101878603974740_6349536740498881867_n-1-1-250x250.jpg"
										srcset="/wp-content/uploads/2020/08/14233189_10101878603974740_6349536740498881867_n-1-1-250x250.jpg 250w, /wp-content/uploads/2020/08/14233189_10101878603974740_6349536740498881867_n-1-1-300x300.jpg 300w, /wp-content/uploads/2020/08/14233189_10101878603974740_6349536740498881867_n-1-1-150x150.jpg 150w, /wp-content/uploads/2020/08/14233189_10101878603974740_6349536740498881867_n-1-1-200x200.jpg 200w, /wp-content/uploads/2020/08/14233189_10101878603974740_6349536740498881867_n-1-1-170x170.jpg 170w, /wp-content/uploads/2020/08/14233189_10101878603974740_6349536740498881867_n-1-1-270x270.jpg 270w, /wp-content/uploads/2020/08/14233189_10101878603974740_6349536740498881867_n-1-1-340x340.jpg 340w, /wp-content/uploads/2020/08/14233189_10101878603974740_6349536740498881867_n-1-1-500x500.jpg 500w, /wp-content/uploads/2020/08/14233189_10101878603974740_6349536740498881867_n-1-1.jpg 576w"
										sizes="(max-width: 400px) 100vw, 400px"
										alt="">
								</figure>
							</div>
						</button>
						<!-- Name  -->
						<h4 class="people-title">Cheryl Hung</h4>
						<!-- Company  -->
						<h5 class="people-company">VP of Ecosystem</h5>
						<div class="social-modal-wrapper">
							<div class="people-social">
								<a href="https://www.linkedin.com/in/cheryljhung/"
									rel="noopener" target="_blank"><svg
										xmlns="http://www.w3.org/2000/svg"
										aria-label="LinkedIn" role="img"
										viewBox="0 0 512 512"
										fill="currentColor">
										<title>LinkedIn</title>
										<rect width="512" height="512" rx="15%"
											fill="currentColor"></rect>
										<circle cx="142" cy="138" r="37"
											fill="#FFF" class="inner-color">
										</circle>
										<path stroke="#FFF" stroke-width="66"
											d="M244 194v198M142 194v198"
											class="inner-color"></path>
										<path fill="#FFF"
											d="M276 282c0-20 13-40 36-40 24 0 33 18 33 45v105h66V279c0-61-32-89-76-89-34 0-51 19-59 32"
											class="inner-color"></path>
									</svg>

								</a>
								<a href="https://twitter.com/oicheryl"
									target="_blank" rel="noopener"><svg
										xmlns="http://www.w3.org/2000/svg"
										aria-label="Twitter" role="img"
										viewBox="0 0 512 512">
										<title>Twitter</title>
										<rect width="512" height="512" rx="15%"
											fill="currentColor"></rect>
										<path class="inner-color" fill="#fff"
											d="M437 152a72 72 0 0 1-40 12 72 72 0 0 0 32-40 72 72 0 0 1-45 17 72 72 0 0 0-122 65 200 200 0 0 1-145-74 72 72 0 0 0 22 94 72 72 0 0 1-32-7 72 72 0 0 0 56 69 72 72 0 0 1-32 1 72 72 0 0 0 67 50 200 200 0 0 1-105 29 200 200 0 0 0 309-179 200 200 0 0 0 35-37">
										</path>
									</svg></a>
								<a href="https://github.com/oicheryl"
									target="_blank" rel="noopener"><svg
										viewBox="0 0 512 512"
										xmlns="http://www.w3.org/2000/svg">
										<title>Github</title>
										<rect height="512" rx="15%" width="512"
											fill="currentColor"></rect>
										<path class="inner-color"
											d="m335 499c14 0 12 17 12 17h-182s-2-17 12-17c13 0 16-6 16-12l-1-50c-71 16-86-28-86-28-12-30-28-37-28-37-24-16 1-16 1-16 26 2 40 26 40 26 22 39 59 28 74 22 2-17 9-28 16-35-57-6-116-28-116-126 0-28 10-51 26-69-3-6-11-32 3-67 0 0 21-7 70 26 42-12 86-12 128 0 49-33 70-26 70-26 14 35 6 61 3 67 16 18 26 41 26 69 0 98-60 120-117 126 10 8 18 24 18 48l-1 70c0 6 3 12 16 12z"
											fill="#fff"></path>
									</svg></a>
							</div>
							<button data-modal-content-id="modal-51113"
								data-modal-prefix-class="lf"
								data-modal-close-text="Close" aria-label="Close"
								class="js-modal button smaller margin-top"
								id="label_modal_4" aria-haspopup="dialog">View
								profile</button>
							<!-- Modal -->
							<div class="modal-hide" id="modal-51113"
								aria-hidden="true">
								<div class="modal-content-wrapper">
									<div class="profile__header">
										<div
											class="background-image-wrapper people-profile-picture">
											<figure
												class="background-image-figure">
												<img loading="lazy" class=""
													src="/wp-content/uploads/2020/08/14233189_10101878603974740_6349536740498881867_n-1-1-250x250.jpg"
													srcset="/wp-content/uploads/2020/08/14233189_10101878603974740_6349536740498881867_n-1-1-250x250.jpg 250w, /wp-content/uploads/2020/08/14233189_10101878603974740_6349536740498881867_n-1-1-300x300.jpg 300w, /wp-content/uploads/2020/08/14233189_10101878603974740_6349536740498881867_n-1-1-150x150.jpg 150w, /wp-content/uploads/2020/08/14233189_10101878603974740_6349536740498881867_n-1-1-200x200.jpg 200w, /wp-content/uploads/2020/08/14233189_10101878603974740_6349536740498881867_n-1-1-170x170.jpg 170w, /wp-content/uploads/2020/08/14233189_10101878603974740_6349536740498881867_n-1-1-270x270.jpg 270w, /wp-content/uploads/2020/08/14233189_10101878603974740_6349536740498881867_n-1-1-340x340.jpg 340w, /wp-content/uploads/2020/08/14233189_10101878603974740_6349536740498881867_n-1-1-500x500.jpg 500w, /wp-content/uploads/2020/08/14233189_10101878603974740_6349536740498881867_n-1-1.jpg 576w"
													sizes="(max-width: 400px) 100vw, 400px"
													alt="">
											</figure>
										</div>
									</div>
									<div class="modal__content">
										<h3 class="modal__title margin-reset">
											Cheryl Hung</h3>
										<h5 class="margin-top-small">
											VP Ecosystem</h5>
										<p>Cheryl is the VP Ecosystem at the CNCF. Her mission is to make end users successful and productive with cloud native technologies such as Kubernetes and Prometheus. In addition to being a prolific public speaker, she founded and runs the Cloud Native London meetup.</p>
										<p>Previously Cheryl led product management and the DevOps engineering team at a container storage startup. As a software engineer at Google, she wrote backend and search infrastructure for Maps. She holds an MA in Computer Science from the University of Cambridge.</p>
									</div>
								</div>
							</div>
						</div>
					</div><!-- end of people box  -->

					<div class="people-box">
						<!-- thumbnail  -->
						<button data-modal-content-id="modal-58717"
							data-modal-prefix-class="lf"
							data-modal-close-text="Close"
							class="js-modal button-reset" aria-label="Close"
							id="label_modal_7" aria-haspopup="dialog">
							<div
								class="background-image-wrapper people-profile-picture">
								<figure class="background-image-figure">
									<img loading="lazy" class=""
										src="/wp-content/uploads/2020/11/ELxkBsqUUAEmp0h-250x250.jpeg"
										srcset="/wp-content/uploads/2020/11/ELxkBsqUUAEmp0h-250x250.jpeg 250w, /wp-content/uploads/2020/11/ELxkBsqUUAEmp0h-300x300.jpeg 300w, /wp-content/uploads/2020/11/ELxkBsqUUAEmp0h-150x150.jpeg 150w, /wp-content/uploads/2020/11/ELxkBsqUUAEmp0h-200x200.jpeg 200w, /wp-content/uploads/2020/11/ELxkBsqUUAEmp0h-170x170.jpeg 170w, /wp-content/uploads/2020/11/ELxkBsqUUAEmp0h-270x270.jpeg 270w, /wp-content/uploads/2020/11/ELxkBsqUUAEmp0h-340x340.jpeg 340w, /wp-content/uploads/2020/11/ELxkBsqUUAEmp0h-500x500.jpeg 500w, /wp-content/uploads/2020/11/ELxkBsqUUAEmp0h.jpeg 661w"
										sizes="(max-width: 400px) 100vw, 400px"
										alt="">
								</figure>
							</div>
						</button>
						<!-- Name  -->
						<h4 class="people-title">Katie Gamanji</h4>
						<!-- Company  -->
						<h5 class="people-company">Ecosystem Advocate</h5>
						<div class="people-excerpt">
							<p>Sailing open-source tooling and supporting the community as an Ecosystem Advocate</p>
						</div>
						<div class="social-modal-wrapper">
							<div class="people-social">
								<a href="https://www.linkedin.com/in/katie-gamanji/"
									rel="noopener" target="_blank"><svg
										xmlns="http://www.w3.org/2000/svg"
										aria-label="LinkedIn" role="img"
										viewBox="0 0 512 512"
										fill="currentColor">
										<title>LinkedIn</title>
										<rect width="512" height="512" rx="15%"
											fill="currentColor"></rect>
										<circle cx="142" cy="138" r="37"
											fill="#FFF" class="inner-color">
										</circle>
										<path stroke="#FFF" stroke-width="66"
											d="M244 194v198M142 194v198"
											class="inner-color"></path>
										<path fill="#FFF"
											d="M276 282c0-20 13-40 36-40 24 0 33 18 33 45v105h66V279c0-61-32-89-76-89-34 0-51 19-59 32"
											class="inner-color"></path>
									</svg>

								</a>
								<a href="https://twitter.com/k_gamanji"
									target="_blank" rel="noopener"><svg
										xmlns="http://www.w3.org/2000/svg"
										aria-label="Twitter" role="img"
										viewBox="0 0 512 512">
										<title>Twitter</title>
										<rect width="512" height="512" rx="15%"
											fill="currentColor"></rect>
										<path class="inner-color" fill="#fff"
											d="M437 152a72 72 0 0 1-40 12 72 72 0 0 0 32-40 72 72 0 0 1-45 17 72 72 0 0 0-122 65 200 200 0 0 1-145-74 72 72 0 0 0 22 94 72 72 0 0 1-32-7 72 72 0 0 0 56 69 72 72 0 0 1-32 1 72 72 0 0 0 67 50 200 200 0 0 1-105 29 200 200 0 0 0 309-179 200 200 0 0 0 35-37">
										</path>
									</svg></a>
							</div>
							<button data-modal-content-id="modal-58717"
								data-modal-prefix-class="lf"
								data-modal-close-text="Close" aria-label="Close"
								class="js-modal button smaller margin-top"
								id="label_modal_8" aria-haspopup="dialog">View
								profile</button>
							<!-- Modal -->
							<div class="modal-hide" id="modal-58717"
								aria-hidden="true">
								<div class="modal-content-wrapper">
									<div class="profile__header">
										<div
											class="background-image-wrapper people-profile-picture">
											<figure
												class="background-image-figure">
												<img loading="lazy" class=""
													src="/wp-content/uploads/2020/11/ELxkBsqUUAEmp0h-250x250.jpeg"
													srcset="/wp-content/uploads/2020/11/ELxkBsqUUAEmp0h-250x250.jpeg 250w, /wp-content/uploads/2020/11/ELxkBsqUUAEmp0h-300x300.jpeg 300w, /wp-content/uploads/2020/11/ELxkBsqUUAEmp0h-150x150.jpeg 150w, /wp-content/uploads/2020/11/ELxkBsqUUAEmp0h-200x200.jpeg 200w, /wp-content/uploads/2020/11/ELxkBsqUUAEmp0h-170x170.jpeg 170w, /wp-content/uploads/2020/11/ELxkBsqUUAEmp0h-270x270.jpeg 270w, /wp-content/uploads/2020/11/ELxkBsqUUAEmp0h-340x340.jpeg 340w, /wp-content/uploads/2020/11/ELxkBsqUUAEmp0h-500x500.jpeg 500w, /wp-content/uploads/2020/11/ELxkBsqUUAEmp0h.jpeg 661w"
													sizes="(max-width: 400px) 100vw, 400px"
													alt="">
											</figure>
										</div>
									</div>
									<div class="modal__content">
										<h3 class="modal__title margin-reset">
											Katie Gamanji</h3>
										<h5 class="margin-top-small">
											Ecosystem Advocate</h5>

										<p>Currently the Ecosystem Advocate for CNCF, Katie works closely with the End User Community.&nbsp; Katie’s main goals are to develop and execute programs to expand the visibility and growth of the End User Community while bridging the gap with other ecosystem units, such as TOCs and SIGs. </p>



										<p>In past roles, Katie contributed to the build-out of platforms that gravitate towards cloud-native principles and open-source tooling, with Kubernetes as the focal point. These projects started with the maintenance and automation of application delivery on OpenStack-based infrastructure, which transitioned into the creation of a centralized, globally distributed platform at Condé Nast.</p>
									</div>
								</div>
							</div>
						</div>
					</div><!-- end of people box  -->

					<div class="people-box">
						<!-- thumbnail  -->
						<button data-modal-content-id="modal-51812"
							data-modal-prefix-class="lf"
							data-modal-close-text="Close"
							class="js-modal button-reset" aria-label="Close"
							id="label_modal_1" aria-haspopup="dialog">
							<div
								class="background-image-wrapper people-profile-picture">
								<figure class="background-image-figure">
									<img loading="lazy" class=""
										src="/wp-content/uploads/2020/08/image-1-1-250x250.jpg"
										srcset="/wp-content/uploads/2020/08/image-1-1-250x250.jpg 250w, /wp-content/uploads/2020/08/image-1-1-300x300.jpg 300w, /wp-content/uploads/2020/08/image-1-1-150x150.jpg 150w, /wp-content/uploads/2020/08/image-1-1-200x200.jpg 200w, /wp-content/uploads/2020/08/image-1-1-170x170.jpg 170w, /wp-content/uploads/2020/08/image-1-1-270x270.jpg 270w, /wp-content/uploads/2020/08/image-1-1-340x340.jpg 340w, /wp-content/uploads/2020/08/image-1-1-500x500.jpg 500w, /wp-content/uploads/2020/08/image-1-1.jpg 690w"
										sizes="(max-width: 400px) 100vw, 400px"
										alt="">
								</figure>
							</div>
						</button>
						<!-- Name  -->
						<h4 class="people-title">Alena Prokharchyk</h4>
						<!-- Company  -->
						<h5 class="people-company">(Apple) TOC from an End User
							organization</h5>

						<div class="social-modal-wrapper">
							<div class="people-social">
								<a href="https://www.linkedin.com/in/alena-prokharchyk-a7b28213/"
									rel="noopener" target="_blank"><svg
										xmlns="http://www.w3.org/2000/svg"
										aria-label="LinkedIn" role="img"
										viewBox="0 0 512 512"
										fill="currentColor">
										<title>LinkedIn</title>
										<rect width="512" height="512" rx="15%"
											fill="currentColor"></rect>
										<circle cx="142" cy="138" r="37"
											fill="#FFF" class="inner-color">
										</circle>
										<path stroke="#FFF" stroke-width="66"
											d="M244 194v198M142 194v198"
											class="inner-color"></path>
										<path fill="#FFF"
											d="M276 282c0-20 13-40 36-40 24 0 33 18 33 45v105h66V279c0-61-32-89-76-89-34 0-51 19-59 32"
											class="inner-color"></path>
									</svg>

								</a>
								<a href="https://twitter.com/Lemonjet"
									target="_blank" rel="noopener"><svg
										xmlns="http://www.w3.org/2000/svg"
										aria-label="Twitter" role="img"
										viewBox="0 0 512 512">
										<title>Twitter</title>
										<rect width="512" height="512" rx="15%"
											fill="currentColor"></rect>
										<path class="inner-color" fill="#fff"
											d="M437 152a72 72 0 0 1-40 12 72 72 0 0 0 32-40 72 72 0 0 1-45 17 72 72 0 0 0-122 65 200 200 0 0 1-145-74 72 72 0 0 0 22 94 72 72 0 0 1-32-7 72 72 0 0 0 56 69 72 72 0 0 1-32 1 72 72 0 0 0 67 50 200 200 0 0 1-105 29 200 200 0 0 0 309-179 200 200 0 0 0 35-37">
										</path>
									</svg></a>
								<a href="https://github.com/alena1108"
									target="_blank" rel="noopener"><svg
										viewBox="0 0 512 512"
										xmlns="http://www.w3.org/2000/svg">
										<title>Github</title>
										<rect height="512" rx="15%" width="512"
											fill="currentColor"></rect>
										<path class="inner-color"
											d="m335 499c14 0 12 17 12 17h-182s-2-17 12-17c13 0 16-6 16-12l-1-50c-71 16-86-28-86-28-12-30-28-37-28-37-24-16 1-16 1-16 26 2 40 26 40 26 22 39 59 28 74 22 2-17 9-28 16-35-57-6-116-28-116-126 0-28 10-51 26-69-3-6-11-32 3-67 0 0 21-7 70 26 42-12 86-12 128 0 49-33 70-26 70-26 14 35 6 61 3 67 16 18 26 41 26 69 0 98-60 120-117 126 10 8 18 24 18 48l-1 70c0 6 3 12 16 12z"
											fill="#fff"></path>
									</svg></a>
							</div>
							<button data-modal-content-id="modal-51812"
								data-modal-prefix-class="lf"
								data-modal-close-text="Close" aria-label="Close"
								class="js-modal button smaller margin-top"
								id="label_modal_2" aria-haspopup="dialog">View
								profile</button>
							<!-- Modal -->
							<div class="modal-hide" id="modal-51812"
								aria-hidden="true">
								<div class="modal-content-wrapper">
									<div class="profile__header">
										<div
											class="background-image-wrapper people-profile-picture">
											<figure
												class="background-image-figure">
												<img loading="lazy" class=""
													src="/wp-content/uploads/2020/08/image-1-1-250x250.jpg"
													srcset="/wp-content/uploads/2020/08/image-1-1-250x250.jpg 250w, /wp-content/uploads/2020/08/image-1-1-300x300.jpg 300w, /wp-content/uploads/2020/08/image-1-1-150x150.jpg 150w, /wp-content/uploads/2020/08/image-1-1-200x200.jpg 200w, /wp-content/uploads/2020/08/image-1-1-170x170.jpg 170w, /wp-content/uploads/2020/08/image-1-1-270x270.jpg 270w, /wp-content/uploads/2020/08/image-1-1-340x340.jpg 340w, /wp-content/uploads/2020/08/image-1-1-500x500.jpg 500w, /wp-content/uploads/2020/08/image-1-1.jpg 690w"
													sizes="(max-width: 400px) 100vw, 400px"
													alt="">
											</figure>
										</div>
									</div>
									<div class="modal__content">
										<h3 class="modal__title margin-reset">
											Alena Prokharchyk</h3>
										<h5 class="margin-top-small">
											Apple</h5>

										<p>Alena is a Software Engineer at Apple. She drives the architecture and implementation of Kubernetes and CNCF technologies within Apple’s cloud infrastructure team. Alena has more than 10 years of experience developing open source cloud infrastructure software and more than 5 years of experience developing container orchestration software. She spoke at KubeCon in 2016, 2017, and 2018 and many other industry conferences in the past 10 years. Prior to joining Apple, Alena was a Senior Architect at Rancher and developed Apache CloudStack at Cloud.com.</p>
									</div>
								</div>
							</div>
						</div>
					</div><!-- end of people box  -->




					<div class="people-box">
						<!-- thumbnail  -->
						<button data-modal-content-id="modal-58136"
							data-modal-prefix-class="lf"
							data-modal-close-text="Close"
							class="js-modal button-reset" aria-label="Close"
							id="label_modal_27" aria-haspopup="dialog">
							<div
								class="background-image-wrapper people-profile-picture">
								<figure class="background-image-figure">
									<img loading="lazy" class=""
										src="/wp-content/uploads/2020/10/DaveZolotusky-250x250.jpg"
										srcset="/wp-content/uploads/2020/10/DaveZolotusky-250x250.jpg 250w, /wp-content/uploads/2020/10/DaveZolotusky-150x150.jpg 150w, /wp-content/uploads/2020/10/DaveZolotusky-500x500.jpg 500w"
										sizes="(max-width: 400px) 100vw, 400px"
										alt="">
								</figure>
							</div>
						</button>
						<!-- Name  -->
						<h4 class="people-title">Dave Zolotusky</h4>
						<!-- Company  -->
						<h5 class="people-company">(Spotify) End User appointed
							TOC</h5>
						<div class="people-excerpt">
							<p>Dave is an engineer in Spotify’s Platform team, where his focus has been core infrastructure, the data platform, and Spotify’s use of cloud services</p>
						</div>
						<div class="social-modal-wrapper">
							<div class="people-social">
								<a href="https://www.linkedin.com/in/dzolotusky/"
									rel="noopener" target="_blank"><svg
										xmlns="http://www.w3.org/2000/svg"
										aria-label="LinkedIn" role="img"
										viewBox="0 0 512 512"
										fill="currentColor">
										<title>LinkedIn</title>
										<rect width="512" height="512" rx="15%"
											fill="currentColor"></rect>
										<circle cx="142" cy="138" r="37"
											fill="#FFF" class="inner-color">
										</circle>
										<path stroke="#FFF" stroke-width="66"
											d="M244 194v198M142 194v198"
											class="inner-color"></path>
										<path fill="#FFF"
											d="M276 282c0-20 13-40 36-40 24 0 33 18 33 45v105h66V279c0-61-32-89-76-89-34 0-51 19-59 32"
											class="inner-color"></path>
									</svg>

								</a>
								<a href="https://twitter.com/dzolotusky"
									target="_blank" rel="noopener"><svg
										xmlns="http://www.w3.org/2000/svg"
										aria-label="Twitter" role="img"
										viewBox="0 0 512 512">
										<title>Twitter</title>
										<rect width="512" height="512" rx="15%"
											fill="currentColor"></rect>
										<path class="inner-color" fill="#fff"
											d="M437 152a72 72 0 0 1-40 12 72 72 0 0 0 32-40 72 72 0 0 1-45 17 72 72 0 0 0-122 65 200 200 0 0 1-145-74 72 72 0 0 0 22 94 72 72 0 0 1-32-7 72 72 0 0 0 56 69 72 72 0 0 1-32 1 72 72 0 0 0 67 50 200 200 0 0 1-105 29 200 200 0 0 0 309-179 200 200 0 0 0 35-37">
										</path>
									</svg></a>
								<a href="https://github.com/dzolotusky"
									target="_blank" rel="noopener"><svg
										viewBox="0 0 512 512"
										xmlns="http://www.w3.org/2000/svg">
										<title>Github</title>
										<rect height="512" rx="15%" width="512"
											fill="currentColor"></rect>
										<path class="inner-color"
											d="m335 499c14 0 12 17 12 17h-182s-2-17 12-17c13 0 16-6 16-12l-1-50c-71 16-86-28-86-28-12-30-28-37-28-37-24-16 1-16 1-16 26 2 40 26 40 26 22 39 59 28 74 22 2-17 9-28 16-35-57-6-116-28-116-126 0-28 10-51 26-69-3-6-11-32 3-67 0 0 21-7 70 26 42-12 86-12 128 0 49-33 70-26 70-26 14 35 6 61 3 67 16 18 26 41 26 69 0 98-60 120-117 126 10 8 18 24 18 48l-1 70c0 6 3 12 16 12z"
											fill="#fff"></path>
									</svg></a>
							</div>
							<button data-modal-content-id="modal-58136"
								data-modal-prefix-class="lf"
								data-modal-close-text="Close" aria-label="Close"
								class="js-modal button smaller margin-top"
								id="label_modal_28" aria-haspopup="dialog">View
								profile</button>
							<!-- Modal -->
							<div class="modal-hide" id="modal-58136"
								aria-hidden="true">
								<div class="modal-content-wrapper">
									<div class="profile__header">
										<div
											class="background-image-wrapper people-profile-picture">
											<figure
												class="background-image-figure">
												<img loading="lazy" class=""
													src="/wp-content/uploads/2020/10/DaveZolotusky-250x250.jpg"
													srcset="/wp-content/uploads/2020/10/DaveZolotusky-250x250.jpg 250w, /wp-content/uploads/2020/10/DaveZolotusky-150x150.jpg 150w, /wp-content/uploads/2020/10/DaveZolotusky-500x500.jpg 500w"
													sizes="(max-width: 400px) 100vw, 400px"
													alt="">
											</figure>
										</div>
									</div>
									<div class="modal__content">
										<h3 class="modal__title margin-reset">
											Dave Zolotusky</h3>
										<h5 class="margin-top-small">
											Platform Engineer at Spotify</h5>

										<p>Dave is an engineer in Spotify’s Platform team, where his focus has been core infrastructure, the data platform, and Spotify’s use of cloud services. A noted evangelist for cloud native and open source technologies, Dave spurred Spotify to join the CNCF and remain active in the community, launched the Stockholm CNCF meetup, and is both a CNCF Ambassador and a member of the KubeCon + CloudNativeCon Program Committee.</p>



										<p>In his work at Spotify, Dave has been essential to the adoption of CNCF projects like Kubernetes, gRPC, Envoy, and OpenTelemetry, as well as experimentation with Service Mesh. Prior to his time with Spotify, Dave worked at AWS, at VMware on cloud management software, and at Microsoft on the Office team.</p>
									</div>
								</div>
							</div>
						</div>
					</div><!-- end of people box  -->



					<div class="people-box">
						<!-- thumbnail  -->
						<button data-modal-content-id="modal-60715"
							data-modal-prefix-class="lf"
							data-modal-close-text="Close"
							class="js-modal button-reset" aria-label="Close"
							id="label_modal_17" aria-haspopup="dialog">
							<div
								class="background-image-wrapper people-profile-picture">
								<figure class="background-image-figure">
									<img loading="lazy" class=""
										src="/wp-content/uploads/2021/03/ricardo-250x250.jpg"
										srcset="/wp-content/uploads/2021/03/ricardo-250x250.jpg 250w, /wp-content/uploads/2021/03/ricardo-300x300.jpg 300w, /wp-content/uploads/2021/03/ricardo-150x150.jpg 150w, /wp-content/uploads/2021/03/ricardo-200x200.jpg 200w, /wp-content/uploads/2021/03/ricardo-170x170.jpg 170w, /wp-content/uploads/2021/03/ricardo-270x270.jpg 270w, /wp-content/uploads/2021/03/ricardo-340x340.jpg 340w, /wp-content/uploads/2021/03/ricardo-500x500.jpg 500w, /wp-content/uploads/2021/03/ricardo.jpg 631w"
										sizes="(max-width: 400px) 100vw, 400px"
										alt="">
								</figure>
							</div>
						</button>
						<!-- Name  -->
						<h4 class="people-title">Ricardo Rocha</h4>
						<!-- Company  -->
						<h5 class="people-company">(CERN) End User appointed
							TOC</h5>
						<div class="people-excerpt">
							<p>Ricardo is a Computing Engineer in the CERN cloud team focusing on containerized deployments, networking and more recently machine learning platforms. He has led for several years the internal effort to transition…</p>
						</div>
						<div class="social-modal-wrapper">
							<div class="people-social">
								<a href="https://www.linkedin.com/in/ricardo-rocha-739aa718/"
									rel="noopener" target="_blank"><svg
										xmlns="http://www.w3.org/2000/svg"
										aria-label="LinkedIn" role="img"
										viewBox="0 0 512 512"
										fill="currentColor">
										<title>LinkedIn</title>
										<rect width="512" height="512" rx="15%"
											fill="currentColor"></rect>
										<circle cx="142" cy="138" r="37"
											fill="#FFF" class="inner-color">
										</circle>
										<path stroke="#FFF" stroke-width="66"
											d="M244 194v198M142 194v198"
											class="inner-color"></path>
										<path fill="#FFF"
											d="M276 282c0-20 13-40 36-40 24 0 33 18 33 45v105h66V279c0-61-32-89-76-89-34 0-51 19-59 32"
											class="inner-color"></path>
									</svg>

								</a>
								<a href="https://twitter.com/ahcorporto"
									target="_blank" rel="noopener"><svg
										xmlns="http://www.w3.org/2000/svg"
										aria-label="Twitter" role="img"
										viewBox="0 0 512 512">
										<title>Twitter</title>
										<rect width="512" height="512" rx="15%"
											fill="currentColor"></rect>
										<path class="inner-color" fill="#fff"
											d="M437 152a72 72 0 0 1-40 12 72 72 0 0 0 32-40 72 72 0 0 1-45 17 72 72 0 0 0-122 65 200 200 0 0 1-145-74 72 72 0 0 0 22 94 72 72 0 0 1-32-7 72 72 0 0 0 56 69 72 72 0 0 1-32 1 72 72 0 0 0 67 50 200 200 0 0 1-105 29 200 200 0 0 0 309-179 200 200 0 0 0 35-37">
										</path>
									</svg></a>
							</div>
							<button data-modal-content-id="modal-60715"
								data-modal-prefix-class="lf"
								data-modal-close-text="Close" aria-label="Close"
								class="js-modal button smaller margin-top"
								id="label_modal_18" aria-haspopup="dialog">View
								profile</button>
							<!-- Modal -->
							<div class="modal-hide" id="modal-60715"
								aria-hidden="true">
								<div class="modal-content-wrapper">
									<div class="profile__header">
										<div
											class="background-image-wrapper people-profile-picture">
											<figure
												class="background-image-figure">
												<img loading="lazy" class=""
													src="/wp-content/uploads/2021/03/ricardo-250x250.jpg"
													srcset="/wp-content/uploads/2021/03/ricardo-250x250.jpg 250w, /wp-content/uploads/2021/03/ricardo-300x300.jpg 300w, /wp-content/uploads/2021/03/ricardo-150x150.jpg 150w, /wp-content/uploads/2021/03/ricardo-200x200.jpg 200w, /wp-content/uploads/2021/03/ricardo-170x170.jpg 170w, /wp-content/uploads/2021/03/ricardo-270x270.jpg 270w, /wp-content/uploads/2021/03/ricardo-340x340.jpg 340w, /wp-content/uploads/2021/03/ricardo-500x500.jpg 500w, /wp-content/uploads/2021/03/ricardo.jpg 631w"
													sizes="(max-width: 400px) 100vw, 400px"
													alt="">
											</figure>
										</div>
									</div>
									<div class="modal__content">
										<h3 class="modal__title margin-reset">
											Ricardo Rocha</h3>
										<h5 class="margin-top-small">
											CERN</h5>

										<p>Ricardo is a Computing Engineer in the CERN cloud team focusing on containerized deployments, networking and more recently machine learning platforms. He has led for several years the internal effort to transition services and workloads to use cloud native technologies, as well as dissemination and training efforts. Ricardo got CERN to join the CNCF and is a lead of the CNCF Research User Group. Prior to this work Ricardo helped develop the grid computing infrastructure serving the Large Hadron Collider (LHC).</p>
									</div>
								</div>
							</div>
						</div>
					</div><!-- end of people box  -->


					<div class="people-box">
						<!-- thumbnail  -->
						<button data-modal-content-id="modal-60401"
							data-modal-prefix-class="lf"
							data-modal-close-text="Close"
							class="js-modal button-reset" aria-label="Close"
							id="label_modal_9" aria-haspopup="dialog">
							<div
								class="background-image-wrapper people-profile-picture">
								<figure class="background-image-figure">
									<img loading="lazy" class=""
										src="/wp-content/uploads/2021/02/erin-250x250.jpeg"
										srcset="/wp-content/uploads/2021/02/erin-250x250.jpeg 250w, /wp-content/uploads/2021/02/erin-300x300.jpeg 300w, /wp-content/uploads/2021/02/erin-150x150.jpeg 150w, /wp-content/uploads/2021/02/erin-200x200.jpeg 200w, /wp-content/uploads/2021/02/erin-170x170.jpeg 170w, /wp-content/uploads/2021/02/erin-270x270.jpeg 270w, /wp-content/uploads/2021/02/erin-340x340.jpeg 340w, /wp-content/uploads/2021/02/erin.jpeg 400w"
										sizes="(max-width: 400px) 100vw, 400px"
										alt="">
								</figure>
							</div>
						</button>
						<!-- Name  -->
						<h4 class="people-title">Erin Boyd</h4>
						<!-- Company  -->
						<h5 class="people-company">(Apple) TOC from an End User
							organization</h5>
						<div class="people-excerpt">
							<p>I have been an active member of the TOC as a contributor from it’s inception. I have led and participated discussions on how to improve the impact of the CNCF through the…</p>
						</div>
						<div class="social-modal-wrapper">
							<div class="people-social">
								<a href="https://www.linkedin.com/in/erin-a-boyd-16871a12/"
									rel="noopener" target="_blank"><svg
										xmlns="http://www.w3.org/2000/svg"
										aria-label="LinkedIn" role="img"
										viewBox="0 0 512 512"
										fill="currentColor">
										<title>LinkedIn</title>
										<rect width="512" height="512" rx="15%"
											fill="currentColor"></rect>
										<circle cx="142" cy="138" r="37"
											fill="#FFF" class="inner-color">
										</circle>
										<path stroke="#FFF" stroke-width="66"
											d="M244 194v198M142 194v198"
											class="inner-color"></path>
										<path fill="#FFF"
											d="M276 282c0-20 13-40 36-40 24 0 33 18 33 45v105h66V279c0-61-32-89-76-89-34 0-51 19-59 32"
											class="inner-color"></path>
									</svg>

								</a>
								<a href="https://twitter.com/erinaboyd"
									target="_blank" rel="noopener"><svg
										xmlns="http://www.w3.org/2000/svg"
										aria-label="Twitter" role="img"
										viewBox="0 0 512 512">
										<title>Twitter</title>
										<rect width="512" height="512" rx="15%"
											fill="currentColor"></rect>
										<path class="inner-color" fill="#fff"
											d="M437 152a72 72 0 0 1-40 12 72 72 0 0 0 32-40 72 72 0 0 1-45 17 72 72 0 0 0-122 65 200 200 0 0 1-145-74 72 72 0 0 0 22 94 72 72 0 0 1-32-7 72 72 0 0 0 56 69 72 72 0 0 1-32 1 72 72 0 0 0 67 50 200 200 0 0 1-105 29 200 200 0 0 0 309-179 200 200 0 0 0 35-37">
										</path>
									</svg></a>
								<a href="https://github.com/erinboyd"
									target="_blank" rel="noopener"><svg
										viewBox="0 0 512 512"
										xmlns="http://www.w3.org/2000/svg">
										<title>Github</title>
										<rect height="512" rx="15%" width="512"
											fill="currentColor"></rect>
										<path class="inner-color"
											d="m335 499c14 0 12 17 12 17h-182s-2-17 12-17c13 0 16-6 16-12l-1-50c-71 16-86-28-86-28-12-30-28-37-28-37-24-16 1-16 1-16 26 2 40 26 40 26 22 39 59 28 74 22 2-17 9-28 16-35-57-6-116-28-116-126 0-28 10-51 26-69-3-6-11-32 3-67 0 0 21-7 70 26 42-12 86-12 128 0 49-33 70-26 70-26 14 35 6 61 3 67 16 18 26 41 26 69 0 98-60 120-117 126 10 8 18 24 18 48l-1 70c0 6 3 12 16 12z"
											fill="#fff"></path>
									</svg></a>
							</div>
							<button data-modal-content-id="modal-60401"
								data-modal-prefix-class="lf"
								data-modal-close-text="Close" aria-label="Close"
								class="js-modal button smaller margin-top"
								id="label_modal_10" aria-haspopup="dialog">View
								profile</button>
							<!-- Modal -->
							<div class="modal-hide" id="modal-60401"
								aria-hidden="true">
								<div class="modal-content-wrapper">
									<div class="profile__header">
										<div
											class="background-image-wrapper people-profile-picture">
											<figure
												class="background-image-figure">
												<img loading="lazy" class=""
													src="/wp-content/uploads/2021/02/erin-250x250.jpeg"
													srcset="/wp-content/uploads/2021/02/erin-250x250.jpeg 250w, /wp-content/uploads/2021/02/erin-300x300.jpeg 300w, /wp-content/uploads/2021/02/erin-150x150.jpeg 150w, /wp-content/uploads/2021/02/erin-200x200.jpeg 200w, /wp-content/uploads/2021/02/erin-170x170.jpeg 170w, /wp-content/uploads/2021/02/erin-270x270.jpeg 270w, /wp-content/uploads/2021/02/erin-340x340.jpeg 340w, /wp-content/uploads/2021/02/erin.jpeg 400w"
													sizes="(max-width: 400px) 100vw, 400px"
													alt="">
											</figure>
										</div>
									</div>
									<div class="modal__content">
										<h3 class="modal__title margin-reset">
											Erin Boyd</h3>
										<h5 class="margin-top-small">
											Apple</h5>

										<p>I have been an active member of the TOC as a contributor from it’s inception. I have led and participated discussions on how to improve the impact of the CNCF through the TOC and it’s wider community as well as performed the due diligence around countless projects. As an engineer at Apple and a member of the End User Community, I have an opportunity to take the knowledge of being a contributor to Kubernetes and other upstream projects outside the CNCF and focus my attention to the usability and consumption of these technologies and . I feel this can truly help foster projects in the open source way. I have seen the space of projects grow and fully understand the challenges associated with scaling projects while still trying to maintain legitimacy and fairness in this Cloud Native community. Being a committer to the Ambari project and contributor to Kubernetes, I have worked across industries and communities and am sought as a trusted advisor and technical architect for the Kubernetes Storage SIG. As part of the Storage SIG I helped establish an E2E testing framework focused on real use cases from customers and usability of the system. I have consulted with other Kubernetes SIGs from this work to help grow the ecosystem with the vision of a more stable environment. I am dedicated to open source and the growing of the cloud native community to incorporate the tools that make this ecosystem so powerful. I bring to the table the perspective of both a developer, tester and usability fanatic and continually reach across communities to accomplish these shared goals. With my new role at Apple participating as an end user of Kubernetes gives me a fully holistic view I can contribute to evaluating and identifying technologies to continue to grow our Cloud Native community.</p>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div><!-- end of people box  -->


			</div>
		</div>
		<!-- /wp:group -->
				<?php

			endwhile;
		endif;
		?>
	</article>
</main>

<?php
get_template_part( 'components/footer' );
