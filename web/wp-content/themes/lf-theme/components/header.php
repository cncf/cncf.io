<?php
/**
 * Header
 *
 * Header section - can contain the navigation.
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

get_header();

$image   = new Image();
$options = get_option( 'lf-mu' );

if ( $options['show_hello_bar'] ) :
	get_template_part( 'components/hello-bar' );
endif;
?>

<header class="site-header">

	<div class="container-full-width wrap">

		<?php if ( $options['header_image_id'] ) { ?>
		<div class="logo">
			<a href="/" title="<?php echo bloginfo( 'name' ); ?>">
				<img src="<?php echo esc_url( wp_get_attachment_url( $options['header_image_id'] ) ); ?>"
					height="38" alt="<?php echo bloginfo( 'name' ); ?>">
			</a>
		</div>
		<?php } ?>

		<div class="menu-container-with-search" role="navigation">
			<nav class="site-navigation">
				<?php
				wp_nav_menu(
					array(
						'menu'       => 'Main Menu',
						'menu_class' => 'main-navigation',
						'depth'      => 3,
						'container'  => '',
					)
				);
				?>

				<?php if ( $options['header_cta_text'] && $options['header_cta_link'] ) : ?>
				<div class="header-cta">
					<a href="<?php echo esc_url( get_permalink( $options['header_cta_link'] ) ); ?>"
						class="button header-align"><?php echo esc_html( $options['header_cta_text'] ); ?></a>
				</div>
				<?php endif; ?>

				<div class="header-search">
					<button
						class="button
						search-toggle
						search-button
						header-align"
						type="button" aria-label="Search">
						<?php $image->get_svg( 'search.svg' ); ?>
					</button>

					<div class="search-bar">
						<div class="container-full-width wrap search-wrapper">
							<form class="search-form" method="get"
								action="<?php echo esc_url( home_url() ); ?>"
								role="search">
								<label for="search-bar"
									class="screen-reader-text">Search
									CNCF</label>
								<input class="search-input" type="search"
									id="search-bar"
									value="<?php echo esc_attr( get_search_query() ); ?>"
									name="s" placeholder="Search for..."
									title="Search for" autocomplete="off"
									autocorrect="off" autocapitalize="off"
									spellcheck="false"
									maxlength="98"
									required>
								<label>
									<input class="button transparent
									header-align
									search-submit"
										type="submit" value="Search" />
								</label>
							</form>
							<button
							class="button
							search-toggle
							search-button
							header-align"
							type="button" aria-label="Close">
								<?php $image->get_svg( 'close.svg' ); ?>
							</button>
						</div>

					</div>
				</div>
			</nav>
		</div>

		<button class="hamburger hamburger--spin" type="button"
			aria-label="Toggle Menu">
			<span class="hamburger-box">
				<span class="hamburger-inner"></span>
			</span>
		</button>

	</div>
</header>
