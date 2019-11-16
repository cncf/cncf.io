<?php
/**
 * Customize the output of menus for Foundation mobile walker
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

/**
 * Big thanks to Brett Mason (https://github.com/brettsmason) for the awesome walker
 */

if ( ! class_exists( 'Foundationpress_Mobile_Walker' ) ) :
	/** Comment. */
	class Foundationpress_Mobile_Walker extends Walker_Nav_Menu {
		/**
		 * Comment.
		 *
		 * @param string $output Comment.
		 * @param int    $depth Comment.
		 * @param array  $args Comment.
		 */
		function start_lvl( &$output, $depth = 0, $args = array() ) { //phpcs:ignore
			$indent  = str_repeat( "\t", $depth );
			$output .= "\n$indent<ul class=\"vertical nested menu\">\n";
		}
	}
endif;
