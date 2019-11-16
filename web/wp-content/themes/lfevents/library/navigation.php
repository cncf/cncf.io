<?php
/**
 * Register Menus
 *
 * @link http://codex.wordpress.org/Function_Reference/register_nav_menus#Examples
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

register_nav_menus(
	array(
		'about-pages-nav' => esc_html__( 'About Pages Nav', 'foundationpress' ),
	)
);


/**
 * About Pages nav
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_nav_menu
 */
if ( ! function_exists( 'foundationpress_about_pages_nav' ) ) {
	/** Comment */
	function foundationpress_about_pages_nav() {
		wp_nav_menu(
			array(
				'container'      => false,
				'menu_class'     => 'menu',
				'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
				'theme_location' => 'about-pages-nav',
				'depth'          => 3,
				'fallback_cb'    => false,
			)
		);
	}
}
