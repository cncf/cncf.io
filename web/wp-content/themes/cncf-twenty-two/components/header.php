<?php
/**
 * Header
 *
 * Header section - contains the navigation.
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

get_header();

$site_options = get_option( 'lf-mu' );

if ( isset( $site_options['show_hello_bar'] ) && $site_options['show_hello_bar'] ) :
	get_template_part( 'components/hello-bar' );
endif;
?>

<header class="header">
	<div class="container wrap">

		<?php if ( isset( $site_options['header_image_id'] ) && $site_options['header_image_id'] ) { ?>
		<div class="logo">
			<a href="/" title="<?php echo bloginfo( 'name' ); ?>">
				<img loading="eager"
					src="<?php echo esc_url( wp_get_attachment_url( $site_options['header_image_id'] ) ); ?>"
					width="210" height="40"
					alt="<?php echo bloginfo( 'name' ); ?>">
			</a>
		</div>
		<?php } ?>

		<nav class="main-menu">
			<ul class="main-menu__wrapper">
				<li class="menu-item-has-children">
					<a href="#"><span>About</span></a>
					<div class="sub-menu">
						<div class="col-container">
							<div class="col1">
								<?php
								wp_nav_menu(
									array(
										'theme_location' => 'about_01',
										'container'      => false,
									)
								);
								?>
							</div>
							<div class="col2">
								<?php
								wp_nav_menu(
									array(
										'theme_location' => 'about_02',
										'container'      => false,
									)
								);
								?>
							</div>
							<div class="col3">

								<ul class="menu">
									<li class="lf-menu-title">Featured Reads
									</li>
								</ul>
								<div class="columns-one">
									<?php
									$annual_report = array(
										'fields'         => 'ids',
										'post_type'      => 'lf_report',
										'post_status'    => array( 'publish' ),
										'posts_per_page' => 1,
										's'              => '"CNCF Annual Report"',
										'orderby'        => 'date',
										'order'          => 'DESC',
										'tax_query'      => array(
											array(
												'taxonomy' => 'lf-report-type',
												'field'    => 'slug',
												'terms'    => 'annual',
											),
										),
									);

									$survey = array(
										'fields'         => 'ids',
										'post_type'      => 'lf_report',
										'post_status'    => array( 'publish' ),
										'posts_per_page' => 1,
										'orderby'        => 'date',
										'order'          => 'DESC',
									);

									$annual_report_query = get_posts( $annual_report );
									if ( $annual_report_query ) {
										$survey['post__not_in'] = $annual_report_query;
									}
									$survey_query = get_posts( $survey );

									// Merge the two results.
									$post_ids = array_merge( $annual_report_query, $survey_query );

									// Finalise the query.
									if ( $post_ids ) :
										$final_args = array(
											'post_type' => array( 'lf_report' ),
											'post__in'  => $post_ids,
											'orderby'   => 'post__in',
											'order'     => 'ASC',
										);
										$query      = new WP_Query( $final_args );

										if ( $query->have_posts() ) :
											while ( $query->have_posts() ) :
												$query->the_post();
												get_template_part( 'components/main-menu-item' );
									endwhile;
									endif;
									endif;
									wp_reset_postdata();

									show_event_in_menu();
									?>
								</div>
							</div>
						</div>
					</div>
				</li>
				<li class="menu-item-has-children"><a
						href="#"><span>Projects</span></a>
					<div class="sub-menu">
						<div class="col-container">
							<div class="col1">
								<?php
								wp_nav_menu(
									array(
										'theme_location' => 'projects_01',
										'container'      => false,
									)
								);
								?>
							</div>
							<div class="col2">
								<?php
								wp_nav_menu(
									array(
										'theme_location' => 'projects_02',
										'container'      => false,
									)
								);
								?>
							</div>
							<div class="col3">
								<ul class="menu">
									<li class="lf-menu-title">Latest Project Journey Reports
									</li>
								</ul>
								<div class="columns-one">
									<?php
									$pj_reports = array(
										'post_type'      => 'lf_report',
										'post_status'    => array( 'publish' ),
										'posts_per_page' => 3,
										'orderby'        => 'date',
										'order'          => 'DESC',
										'tax_query'      => array(
											array(
												'taxonomy' => 'lf-report-type',
												'field'    => 'slug',
												'terms'    => 'project-journey',
											),
										),
									);

									$query = new WP_Query( $pj_reports );

									if ( $query->have_posts() ) :
										while ( $query->have_posts() ) :
											$query->the_post();
											get_template_part( 'components/main-menu-item' );
										endwhile;
									endif;
									wp_reset_postdata();
									?>
								</div>

							</div>
						</div>
					</div>
				</li>
				<li class="menu-item-has-children"><a
						href="#"><span>Training</span></a>
					<div class="sub-menu">
						<div class="col-container">
							<div class="col1">
								<?php
								wp_nav_menu(
									array(
										'theme_location' => 'certifications_01',
										'container'      => false,
									)
								);
								?>
							</div>
							<div class="col2">
								<?php
								wp_nav_menu(
									array(
										'theme_location' => 'certifications_02',
										'container'      => false,
									)
								);
								?>
							</div>
							<div class="col3">
								<ul class="menu">
									<li class="lf-menu-title">Recommended Links
									</li>
								</ul>

								<div class="columns-one">

									<?php
									get_template_part( 'components/promotion' );
									?>
								</div>

							</div>
						</div>
					</div>

				</li>
				<li class="menu-item-has-children"><a
						href="#"><span>Community</span></a>
					<div class="sub-menu">
						<div class="col-container">
							<div class="col1">
								<?php
								wp_nav_menu(
									array(
										'theme_location' => 'community_01',
										'container'      => false,
									)
								);
								?>
							</div>
							<div class="col2">
								<?php
								wp_nav_menu(
									array(
										'theme_location' => 'community_02',
										'container'      => false,
									)
								);
								?>
							</div>
							<div class="col3">
								<?php
								wp_nav_menu(
									array(
										'theme_location' => 'community_03',
										'container'      => false,
									)
								);
								?>
							</div>
						</div>
					</div>

				</li>
				<li class="menu-item-has-children"><a href="#"><span>Blog &
							News</span></a>
					<div class="sub-menu">
						<div class="col-container">
							<div class="col1">
								<?php
								wp_nav_menu(
									array(
										'theme_location' => 'blog_01',
										'container'      => false,
									)
								);
								?>
							</div>
							<div class="col2">
								<?php
								wp_nav_menu(
									array(
										'theme_location' => 'blog_02',
										'container'      => false,
									)
								);
								?>
							</div>
							<div class="col3">
								<ul class="menu">
									<li class="lf-menu-title">Latest Blog Posts
									</li>
								</ul>

								<?php
								$args  = array(
									'post_type'           => 'post',
									'post_status'         => array( 'publish' ),
									'posts_per_page'      => 3,
									'orderby'             => 'date',
									'order'               => 'DESC',
									'ignore_sticky_posts' => false,
									'category_name'       => 'blog,announcements',
								);
								$query = new WP_Query( $args );

								if ( $query->have_posts() ) :
									?>
								<div class="columns-one">
									<?php

									while ( $query->have_posts() ) {
										$query->the_post();

										get_template_part( 'components/main-menu-item' );
									}

									?>
								</div>

									<?php
								endif;
								wp_reset_postdata();
								?>

							</div>
						</div>
					</div>

				</li>
			</ul>

			<div style="height:60px;" aria-hidden="true"
				class="wp-block-spacer show-upto-1000">
			</div>

			<?php if ( isset( $site_options['header_cta_text'] ) && isset( $site_options['header_cta_link'] ) && $site_options['header_cta_text'] && $site_options['header_cta_link'] ) : ?>

			<div class="header-cta">
				<div class="wp-block-button">
					<a href="<?php echo esc_url( get_permalink( $site_options['header_cta_link'] ) ); ?>"
						class="wp-block-button__link wp-element-button"><?php echo esc_html( $site_options['header_cta_text'] ); ?></a>
				</div>
			</div>

			<div style="height:20px" aria-hidden="true"
				class="wp-block-spacer show-upto-1000">
			</div>
			<?php endif; ?>

			<!-- Button to open the search menu  -->
			<button
				class="header__search_open search-toggle button-reset show-over-1000"
				type="button" aria-label="Search">
				<?php LF_utils::get_svg( 'icon-search.svg' ); ?>
			</button>

			<div class="header__search_wrapper">
				<div class="header__search_container">

					<form class="search-form" method="get" autocomplete="off"
						action="<?php echo esc_url( home_url() ); ?>"
						role="search">
						<label for="search-bar"
							class="screen-reader-text">Search
							CNCF</label>
						<input class="search-input" type="search"
							id="search-bar"
							value="<?php echo esc_attr( get_search_query() ); ?>"
							name="s" placeholder="I'm looking for..."
							title="Search CNCF site" autocapitalize="off"
							spellcheck="false" maxlength="98" required>
						<input class="search-input-button wp-block-button__link has-no-padding"
							type="submit" value="Search" />
					</form>

					<div style="height:100px" aria-hidden="true"
						class="wp-block-spacer show-upto-1000">
					</div>

					<button class="button-reset search-toggle show-over-1000"
						type="button" aria-label="Close">
						<?php LF_utils::get_svg( 'icon-close.svg' ); ?>
					</button>
				</div>
			</div>
		</nav>

		<button class="hamburger" type="button" aria-label="Toggle Menu">
			<span class="hamburger-box">
				<span class="hamburger-inner"></span>
			</span>
		</button>

	</div>
</header>
