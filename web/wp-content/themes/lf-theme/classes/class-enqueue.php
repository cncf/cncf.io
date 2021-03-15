<?php
/**
 * Class Enqueue
 *
 * Any new styles and scripts should go in here.
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

/**
 * Enqueue class
 *
 * Helps manage script loading
 *
 * @since 1.0.0
 */
class Enqueue {

	/**
	 * Initialise code
	 *
	 * @since 1.0.0
	 *
	 * @see class/Enqueue
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );
		add_action( 'enqueue_block_editor_assets', array( $this, 'editor' ) );
	}

	/**
	 * Load frontend styles.
	 *
	 * @since 1.0.0
	 *
	 * @see class/Enqueue
	 */
	public function styles() {

		if ( WP_DEBUG === true ) {
			// Use un-minified versions.
			wp_enqueue_style( 'main', get_template_directory_uri() . '/build/styles.css', array(), filemtime( get_template_directory() . '/build/styles.css' ), 'all' );
		} else {
			wp_enqueue_style( 'main', get_template_directory_uri() . '/build/styles.min.css', array(), filemtime( get_template_directory() . '/build/styles.min.css' ), 'all' );
		}

		// dequeue search filter css on front page.
		if ( ! is_admin() && is_front_page() ) {
			wp_dequeue_style( 'search-filter-plugin-styles' );
			wp_deregister_style( 'search-filter-plugin-styles' );
		}
	}

	/**
	 * Load frontend scripts.
	 *
	 * @since 1.0.0
	 *
	 * @see class/Enqueue
	 */
	public function scripts() {

		if ( ! is_admin() ) {

			wp_deregister_script( 'jquery' );
			// Load updated version of jquery.
			wp_register_script( 'jquery', get_template_directory_uri() . '/source/js/third-party/jquery-3.5.1.min.js', false, '3.5.1', true );
			wp_enqueue_script( 'jquery' );

		}

		if ( WP_DEBUG === true ) {
			// Use un-minified versions.
			wp_enqueue_script( 'global-scripts', get_template_directory_uri() . '/build/global.js', array( 'jquery' ), filemtime( get_template_directory() . '/build/global.js' ), true );

		} else {
			wp_enqueue_script( 'global-scripts', get_template_directory_uri() . '/build/global.min.js', array( 'jquery' ), filemtime( get_template_directory() . '/build/global.min.js' ), true );
		}

	}

	/**
	 * Load scripts and styles in the backend (editor).
	 *
	 * @since 1.0.0
	 *
	 * @see class/Enqueue
	 */
	public function editor() {

		if ( WP_DEBUG === true ) {
			// Use un-minified versions.
			wp_enqueue_script( 'editor-scripts', get_template_directory_uri() . '/build/blocks.js', array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-data' ), filemtime( get_template_directory() . '/build/blocks.js' ), true );

			wp_enqueue_style( 'editor-css', get_template_directory_uri() . '/build/editor-only.css', array( 'wp-edit-blocks' ), filemtime( get_template_directory() . '/build/editor-only.css' ), 'all' );

		} else {
			wp_enqueue_script( 'editor-scripts', get_template_directory_uri() . '/build/blocks.js', array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-data' ), filemtime( get_template_directory() . '/build/blocks.min.js' ), true );

			wp_enqueue_style( 'editor-css', get_template_directory_uri() . '/build/editor-only.css', array( 'wp-edit-blocks' ), filemtime( get_template_directory() . '/build/editor-only.min.css' ), 'all' );

		}

	}

}
