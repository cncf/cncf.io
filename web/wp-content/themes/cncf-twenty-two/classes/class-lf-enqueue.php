<?php
/**
 * Class Enqueue
 *
 * Any new styles and scripts should go in here.
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

/**
 * Enqueue class
 *
 * Helps manage script loading
 *
 * @since 1.0.0
 */
class LF_Enqueue {

	/**
	 * Initialize code
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

		// Annual report 21 optimisations.
		if ( is_page_template( 'templates/annual-report-2021.php' ) ) {
			wp_dequeue_style( 'wp-block-library' );
			wp_dequeue_style( 'search-filter-plugin-styles' );
			wp_dequeue_style( 'ctf_styles' );

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

		if ( WP_DEBUG === true ) {
			// Use un-minified versions.
			wp_enqueue_script( 'global-scripts', get_template_directory_uri() . '/build/globals.js', null, filemtime( get_template_directory() . '/build/globals.js' ), true );

		} else {
			wp_enqueue_script( 'global-scripts', get_template_directory_uri() . '/build/globals.min.js', null, filemtime( get_template_directory() . '/build/globals.min.js' ), true );
		}

		wp_enqueue_script(
			'modal',
			get_template_directory_uri() . '/source/js/on-demand/modal.js',
			array( 'jquery' ),
			filemtime( get_template_directory() . '/source/js/on-demand/modal.js' ),
			true
		);
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
			wp_enqueue_script( 'editor-scripts', get_template_directory_uri() . '/build/editor-scripts.js', array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-dom-ready', 'wp-data', 'wp-dom' ), filemtime( get_template_directory() . '/build/editor-scripts.js' ), true );

			wp_enqueue_style( 'editor-css', get_template_directory_uri() . '/build/editor-only.css', array( 'wp-edit-blocks' ), filemtime( get_template_directory() . '/build/editor-only.css' ), 'all' );

		} else {
			wp_enqueue_script( 'editor-scripts', get_template_directory_uri() . '/build/editor-scripts.js', array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-dom-ready', 'wp-data', 'wp-dom' ), filemtime( get_template_directory() . '/build/editor-scripts.min.js' ), true );

			wp_enqueue_style( 'editor-css', get_template_directory_uri() . '/build/editor-only.css', array( 'wp-edit-blocks' ), filemtime( get_template_directory() . '/build/editor-only.min.css' ), 'all' );

		}

	}

}
