<?php
/**
 *
 * LF Navigation Tools
 *
 * Plugin Name: LF Navigation Tools
 * Description: Allows for dividers and unlinked entries to be added to WordPress menu navigations.
 * Author: James Hunt
 * Author URI: https://www.cncf.io
 * Version: 1.0
 * License: GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: lf-mu
 *
 * @package WordPress
 * @subpackage lf-mu
 */

/**
 * LF Nav Tools
 */
class LF_Navigation_Tools {

	/**
	 * Construct
	 */
	public function __construct() {
		add_filter( 'walker_nav_menu_start_el', array( $this, 'lf_nav_menu_tools' ), 10, 2 );
		add_filter( 'walker_nav_menu_start_el', array( $this, 'lf_add_descriptions_to_specified_menus' ), 10, 4 );
		add_filter( 'nav_menu_css_class', array( $this, 'lf_nav_menu_tool_classes' ), 10, 2 );
	}

	/**
	 * Nav Menu Tools
	 *
	 * @param object $item_output Output.
	 * @param array  $item Item.
	 * @return object
	 */
	public function lf_nav_menu_tools( $item_output, $item ) {
		if ( '---' === $item->post_title ) {
			// Show Divider.
				return apply_filters(
					'lf_divider',
					'<div class="lf-menu-divider"></div>',
					$item
				);
		} elseif ( '###' === $item->url ) {
			// Show Title (no link).
			return apply_filters(
				'lf_title',
				$item->post_title,
				$item
			);
		} else {
			// Return unmodified output.
			return $item_output;
		}
	}

	/**
	 * Add classes to menu to match the walker.
	 *
	 * @param array $classes Classes.
	 * @param array $item Item.
	 * @return array
	 */
	public function lf_nav_menu_tool_classes( $classes, $item ) {

		if ( '###' === $item->url ) {
			$classes[] = 'lf-menu-title';
		}

		return $classes;
	}

	/**
	 * Output description to selected menus menu items.
	 *
	 * @param array   $item_output Output.
	 * @param array   $item Item.
	 * @param integer $depth Depth.
	 * @param array   $args Arguments.
	 * @return array
	 */
	public function lf_add_descriptions_to_specified_menus( $item_output, $item, $depth, $args ) {

		$selected_menus = array(
			'about_01',
			'about_02',
			'projects_01',
			'projects_02',
			'certifications_01',
			'certifications_02',
			'community_01',
			'community_02',
			'blog_01',
			'blog_02',
		);

		// if menu matches selected, top level and has a description.
		if ( in_array( $args->theme_location, $selected_menus, true ) && ! $depth && $item->description ) {
			$item_output = str_replace( '</a>', '<span class="lf-menu-description">' . $item->description . '</span></a>', $item_output );
		}
		return $item_output;

	}
}

new LF_Navigation_Tools();
