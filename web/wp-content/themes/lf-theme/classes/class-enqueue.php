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
			// load WP copy of jQuery in the footer.
			wp_register_script( 'jquery', includes_url( '/js/jquery/jquery.js' ), false, '1.3.2', true );
			wp_enqueue_script( 'jquery' );

			wp_enqueue_script( 'recaptcha', 'https://www.recaptcha.net/recaptcha/api.js?render=explicit', false, false, true ); // phpcs:ignore

		}

		if ( WP_DEBUG === true ) {
			// Use un-minified versions.
			wp_enqueue_script( 'global-scripts', get_template_directory_uri() . '/build/global.js', array( 'jquery' ), filemtime( get_template_directory() . '/build/global.js' ), true );

			// wp_enqueue_script( 'vendor-scripts', get_template_directory_uri() . '/build/vendors.js', array( 'jquery' ), filemtime( get_template_directory() . '/build/vendors.js' ), true ); // phpcs:ignore.

			// wp_enqueue_script('tiny-slider', get_template_directory_uri() . '/source/third-party/tiny-slider.js', array(), filemtime( get_template_directory() . '/build/tiny-slider.js' ), true); // phpcs:ignore.

		} else {
			wp_enqueue_script( 'global-scripts', get_template_directory_uri() . '/build/global.min.js', array( 'jquery' ), filemtime( get_template_directory() . '/build/global.min.js' ), true );

			// wp_enqueue_script( 'vendor-scripts', get_template_directory_uri() . '/build/vendors.min.js', array( 'jquery' ), '', true ); // phpcs:ignore.

			// wp_enqueue_script('tiny-slider', get_template_directory_uri() . '/source/third-party/tiny-slider.js', array(), '', true); // phpcs:ignore.
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
