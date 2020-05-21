<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.cncf.io/
 * @since      1.0.0
 *
 * @package    Cncf_Mu
 * @subpackage Cncf_Mu/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Cncf_Mu
 * @subpackage Cncf_Mu/public
 * @author     Chris Abraham <cjyabraham@gmail.com>
 */
class Cncf_Mu_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param  string $plugin_name       The name of the plugin.
	 * @param  string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cncf-mu-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/cncf-mu-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Remove wp-embed script to speed things up https://kinsta.com/knowledgebase/disable-embeds-wordpress/.
	 */
	public function deregister_scripts() {
		wp_dequeue_script( 'wp-embed' );
	}

	/**
	 * Inserts <head> Google Tag Manager code.
	 */
	public function insert_gtm_head() {
		$current_domain = parse_url( home_url(), PHP_URL_HOST );
		$analytics_code = <<<EOD
	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-KNXFWV');</script>
	<!-- End Google Tag Manager -->

	EOD;

		if ( 'www.cncf.io' == $current_domain && ! is_user_logged_in() ) {
			// this is a live site so output the analytics code.
			echo $analytics_code; //phpcs:ignore
		}
	}

	/**
	 * Inserts the <body> Google Tag Manager code.
	 */
	public function insert_gtm_body() {
		$current_domain = parse_url( home_url(), PHP_URL_HOST );
		$analytics_code = <<<EOD
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KNXFWV"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->

	EOD;

		if ( 'www.cncf.io' == $current_domain && ! is_user_logged_in() ) {
			// this is a live site so output the analytics code.
			echo $analytics_code; //phpcs:ignore
		}
	}

	/**
	 * Fix preconnect and preload to better optimize loading. Preconnect is priority, must have crossorigin; Prefetch just opens connection.
	 *
	 * @param string $hints returns hints.
	 * @param string $relation_type returns priority.
	 */
	public function change_to_preconnect_resource_hints( $hints, $relation_type ) {

		if ( 'preconnect' === $relation_type ) {
			// Used for analytics inserted by insert_google_analytics().
			$hints[] = array(
				'crossorigin' => '',
				'href'        => '//www.googletagmanager.com',
			);
			// Used by ReCaptcha.
			$hints[] = array(
				'crossorigin' => '',
				'href'        => '//www.gstatic.com',
			);
		}
		if ( 'dns-prefetch' === $relation_type ) {
			// create array of URLs to remove from prefetch.
			$url_arr = array( 'code.jquery.com', 's.w.org' );

			foreach ( $url_arr as $url ) {
				$key = array_search( $url, $hints );
				if ( false !== $key ) {
					unset( $hints[ $key ] );
				}
			}
			// add in any addresses here that you want to prefetch.
			$hints[] = '';
		}
		return $hints;
	}

}
