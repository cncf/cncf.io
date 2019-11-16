<?php
/**
 * The Global Nav for the site
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

if ( is_lfeventsci() ) {
	$home_img = 'logo_lfevents_white.svg';
} else {
	$home_img = 'logo_lfasiallc_white.svg';
}
?>

<div data-sticky-container>
	<header class="main-header sticky" data-sticky data-sticky-on="large" data-options="marginTop:0;">

		<button class="menu-toggler button alignright hide-for-large" data-toggle="main-menu">
			<span class="hamburger-icon"></span>
		</button>

		<a class="home-link" href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo get_stylesheet_directory_uri() . '/dist/assets/images/' . foundationpress_asset_path( $home_img ); //phpcs:ignore ?>"></a>

		<nav id="main-menu" class="main-menu show-for-large" data-toggler="show-for-large" role="navigation">
			<?php foundationpress_about_pages_nav(); ?>
		</nav>
	</header>
</div>
