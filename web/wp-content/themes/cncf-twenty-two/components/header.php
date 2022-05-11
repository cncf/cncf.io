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
				<img loading="eager" src="<?php echo esc_url( wp_get_attachment_url( $site_options['header_image_id'] ) ); ?>"
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
										'tax_query'      => array(
											array(
												'taxonomy' => 'lf-report-type',
												'field'    => 'slug',
												'terms'    => 'survey',
											),
										),
									);

									$annual_report_query = get_posts( $annual_report );
									$survey_query        = get_posts( $survey );
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


									get_template_part( 'components/next-event' );
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
									<li class="lf-menu-title">Latest Tech Radars
									</li>
								</ul>

<?php
// Get all radars.
$tech_radars_all = LF_utils::get_tech_radars();
// Limit to latest 3 items.
$tech_radars = array_slice( $tech_radars_all, 0, 3 );

if ( is_array( $tech_radars ) ) :
	?>
<div class="columns-one">
	<?php
	foreach ( $tech_radars as $tech_radar ) :

		$url         = 'https://radar.cncf.io/' . $tech_radar->key;
		$radar_title = $tech_radar->name;
		$date        = $tech_radar->date;
		$image       = $tech_radar->image;
		?>

<div class="main-menu-item radar-menu-item">
	<div
		class="main-menu-item__image-wrapper">

		<a href="<?php echo esc_url( $url ); ?>"
			title="<?php echo esc_html( $radar_title ); ?>" class="main-menu-item__link">

			<?php
			if ( $image ) {
				?>
<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_html( $radar_title ); ?>" class="main-menu-item__image" loading="lazy">
				<?php
			} else {
				// show generic.
				Lf_Utils::display_responsive_images( $site_options['generic_thumb_id'], 'newsroom-388', '400px', 'main-menu-item__image' );
			}
			?>
		</a>
	</div>
	<div class="main-menu-item__text-wrapper">

		<a class="author-category" title="See more tech radars" href="https://radar.cncf.io/">Tech Radar</a>

		<span class="main-menu-item__title">
			<a href="<?php echo esc_url( $url ); ?>"
				title="<?php echo esc_html( $radar_title ); ?>"><?php echo esc_html( $radar_title ); ?></a>
		</span>
		<span
			class="main-menu-item__date"><?php echo esc_html( $date ); ?></span>
	</div>
</div>
		<?php
endforeach;
	?>
</div>
	<?php
endif;
?>
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

			<div style="height:60px;" aria-hidden="true" class="wp-block-spacer show-upto-1000">
			</div>

			<?php if ( isset( $site_options['header_cta_text'] ) && isset( $site_options['header_cta_link'] ) && $site_options['header_cta_text'] && $site_options['header_cta_link'] ) : ?>

			<div class="header-cta">
				<a href="<?php echo esc_url( get_permalink( $site_options['header_cta_link'] ) ); ?>"
					class="wp-block-button__link"><?php echo esc_html( $site_options['header_cta_text'] ); ?></a>
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
							title="Search CNCF site"
							autocapitalize="off"
							spellcheck="false" maxlength="98" required>
						<input
							class="wp-block-button__link has-no-padding"
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
