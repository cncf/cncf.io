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

		// dequeue search filter js and css on front page.
		if ( ! is_admin() && is_front_page() ) {
			wp_dequeue_style( 'search-filter-plugin-styles' );
			wp_deregister_style( 'search-filter-plugin-styles' );
			wp_dequeue_script( 'search-filter-plugin-build' );
			wp_deregister_script( 'search-filter-plugin-build' );
			wp_dequeue_script( 'search-filter-plugin-chosen' );
			wp_deregister_script( 'search-filter-plugin-chosen' );
			wp_dequeue_style( 'ctf_styles' );
		}

		if ( is_front_page() ) {

			// load slick css.
			wp_enqueue_style( 'slick-css', get_template_directory_uri() . '/build/slick.min.css', array(), filemtime( get_template_directory() . '/build/slick.min.css' ), 'all' );

			// load main slick.
			wp_enqueue_script( 'slick', get_template_directory_uri() . '/source/js/third-party/slick.min.js', array( 'jquery' ), filemtime( get_template_directory() . '/source/js/third-party/slick.min.js' ), true );

			// load slick config.
			wp_enqueue_script( 'slick-config', get_template_directory_uri() . '/source/js/third-party/slick-config.js', array( 'jquery', 'slick' ), filemtime( get_template_directory() . '/source/js/third-party/slick-config.js' ), true );

			// youtube lite script.
			wp_enqueue_script(
				'youtube-lite-js',
				home_url() . '/wp-content/mu-plugins/wp-mu-plugins/lf-blocks/src/youtube-lite/scripts/lite-youtube.js',
				null,
				filemtime( WPMU_PLUGIN_DIR . '/wp-mu-plugins/lf-blocks/dist/blocks.build.js' ),
				true
			);

			// purecounter countup.
			wp_enqueue_script( 'purecounter', get_template_directory_uri() . '/source/js/third-party/purecounter_vanilla.js', array(), filemtime( get_template_directory() . '/source/js/third-party/purecounter_vanilla.js' ), false );
		}

		if ( is_singular( 'lf_case_study' ) || is_singular( 'lf_case_study_cn' ) ) {
			wp_enqueue_script( 'sidebar-subscription', get_template_directory_uri() . '/source/js/third-party/case-study-sidebar.js', array( 'jquery' ), filemtime( get_template_directory() . '/source/js/third-party/case-study-sidebar.js' ), true );
		}

		// if annual report 21.
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
			wp_enqueue_script( 'editor-scripts', get_template_directory_uri() . '/build/blocks.js', array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-dom-ready', 'wp-data', 'wp-dom' ), filemtime( get_template_directory() . '/build/blocks.js' ), true );

			wp_enqueue_style( 'editor-css', get_template_directory_uri() . '/build/editor-only.css', array( 'wp-edit-blocks' ), filemtime( get_template_directory() . '/build/editor-only.css' ), 'all' );

		} else {
			wp_enqueue_script( 'editor-scripts', get_template_directory_uri() . '/build/blocks.js', array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-dom-ready', 'wp-data', 'wp-dom' ), filemtime( get_template_directory() . '/build/blocks.min.js' ), true );

			wp_enqueue_style( 'editor-css', get_template_directory_uri() . '/build/editor-only.css', array( 'wp-edit-blocks' ), filemtime( get_template_directory() . '/build/editor-only.min.css' ), 'all' );

		}

	}

}
