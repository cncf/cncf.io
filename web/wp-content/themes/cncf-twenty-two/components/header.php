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

if ( $site_options['show_hello_bar'] ) :
	get_template_part( 'components/hello-bar' );
endif;

?>

<header class="header">
	<div class="container wrap">

		<?php if ( $site_options['header_image_id'] ) { ?>
		<div class="logo">
			<a href="/" title="<?php echo bloginfo( 'name' ); ?>">
				<img src="<?php echo esc_url( wp_get_attachment_url( $site_options['header_image_id'] ) ); ?>"
					height="38" alt="<?php echo bloginfo( 'name' ); ?>">
			</a>
		</div>
		<?php } ?>

		<nav class="main-menu">
			<ul class="main-menu__wrapper">
				<li class="menu-item-has-children">
					<a href="#"><span>About</span></a>
					<ul class="sub-menu">
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

									<!-- // TODO: Welcome post from Priyanka? -->
									<img src="https://via.placeholder.com/340x120/d9d9d9/000000"
										alt="">
									<br>
									<img src="https://via.placeholder.com/340x120/d9d9d9/000000"
										alt="">
									<br>
									<img src="https://via.placeholder.com/340x120/d9d9d9/000000"
										alt="">

								</ul>
							</div>
						</div>
					</ul>
				</li>
				<li class="menu-item-has-children"><a
						href="#"><span>Projects</span></a>
					<ul class="sub-menu">
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

									<!-- // TODO: Radars loop -->
									<img src="https://via.placeholder.com/340x120/d9d9d9/000000"
										alt="">
									<br>
									<img src="https://via.placeholder.com/340x120/d9d9d9/000000"
										alt="">
									<br>
									<img src="https://via.placeholder.com/340x120/d9d9d9/000000"
										alt="">

								</ul>
							</div>
						</div>
					</ul>
				</li>
				<li class="menu-item-has-children"><a
						href="#"><span>Certification</span></a>
					<ul class="sub-menu">
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

									<!-- // TODO: Training advert -->
									<img src="https://via.placeholder.com/340x220/d9d9d9/000000"
										alt="">

								</ul>
							</div>
						</div>
					</ul>

				</li>
				<li class="menu-item-has-children"><a
						href="#"><span>Community</span></a>
					<ul class="sub-menu">
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
					</ul>

				</li>
				<li class="menu-item-has-children"><a href="#"><span>Blog &
							News</span></a>
					<ul class="sub-menu">
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

									<!-- // TODO: Welcome post from Priyanka? -->
									<img src="https://via.placeholder.com/340x120/d9d9d9/000000"
										alt="">
									<br>
									<img src="https://via.placeholder.com/340x120/d9d9d9/000000"
										alt="">
									<br>
									<img src="https://via.placeholder.com/340x120/d9d9d9/000000"
										alt="">

								</ul>
							</div>
						</div>
					</ul>

				</li>
			</ul>

			<div style="height:40px" aria-hidden="true" class="wp-block-spacer">
			</div>

			<?php if ( $site_options['header_cta_text'] && $site_options['header_cta_link'] ) : ?>

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

					<form class="search-form" method="get"
						action="<?php echo esc_url( home_url() ); ?>"
						role="search">
						<label for="search-bar"
							class="screen-reader-text">Search
							CNCF</label>
						<input class="search-input" type="search"
							id="search-bar"
							value="<?php echo esc_attr( get_search_query() ); ?>"
							name="s" placeholder="I'm looking for..."
							title="Search CNCF site" autocomplete="off"
							autocorrect="off" autocapitalize="off"
							spellcheck="false" maxlength="98" required>
						<input
							class="wp-block-button__link has-no-padding has-gray-700-background-color has-background"
							type="submit" value="Search" />
					</form>

					<div style="height:100px" aria-hidden="true"
						class="wp-block-spacer show-upto-1000"></div>

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
