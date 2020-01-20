<?php

/**
 * Class Enqueue
 *
 * Any new styles and scripts should go in here, although do you really need to add anything more in here. Try to build any new CSS / JS into the main Gulp Workflows
 */
class Enqueue {

	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );
	}

	public function styles() {

		if ( WP_DEBUG === true ) {
			/** use un minified */
			wp_enqueue_style( 'main-css', get_template_directory_uri() . '/build/styles.css', false );
		} else {
			wp_enqueue_style( 'main-css', get_template_directory_uri() . '/build/styles.min.css', false );
		}
		// wp_enqueue_style('google-fonts', '//fonts.googleapis.com/css?family=Montserrat:300,400,500,700|Nunito:300,400,500,700,900');
	}

	public function scripts() {

		/** Jquery to footer */
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', includes_url( '/js/jquery/jquery.js' ), false, null, true );
		wp_enqueue_script( 'jquery' );

		if ( WP_DEBUG === true ) {
			/** use un minified */

			wp_enqueue_script( 'global-scripts', get_template_directory_uri() . '/build/global.js', array( 'jquery' ), '', true );

			// wp_enqueue_script( 'vendor-scripts', get_template_directory_uri() . '/build/vendors.js', array( 'jquery' ), '', true );

			// wp_enqueue_script('tiny-slider', get_template_directory_uri() . '/source/third-party/tiny-slider.js', array(), '', true);

		} else {

			/** use minified for live */
			wp_enqueue_script( 'global-scripts', get_template_directory_uri() . '/build/global.min.js', array( 'jquery' ), '', true );

			// wp_enqueue_script( 'vendor-scripts', get_template_directory_uri() . '/build/vendors.min.js', array( 'jquery' ), '', true );

			// wp_enqueue_script('tiny-slider', get_template_directory_uri() . '/source/third-party/tiny-slider.js', array(), '', true);
		}

		// start Mailchimp custom AJAX + script
		wp_register_script( 'mailchimp-script', get_template_directory_uri() . '/source/js/enqueued/mailchimp.js', array( 'jquery' ) );
		$script_array = array(
			'ajaxurl'  => admin_url( 'admin-ajax.php' ),
			'security' => wp_create_nonce( 'subscribe_user' ),
		);
		wp_localize_script( 'mailchimp-script', 'aw', $script_array );
		wp_enqueue_script( 'mailchimp-script' );

	}

}
