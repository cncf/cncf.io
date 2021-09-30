<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.cncf.io/
 * @since      1.0.0
 *
 * @package    Lf_Mu
 * @subpackage Lf_Mu/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Lf_Mu
 * @subpackage Lf_Mu/public
 * @author     Chris Abraham <cjyabraham@gmail.com>
 */
class Lf_Mu_Public {

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

		$options = get_option( $this->plugin_name );
		$this->site        = ( isset( $options['site'] ) && ! empty( $options['site'] ) ) ? esc_attr( $options['site'] ) : '';
		$this->is_cncf     = ( 'cncf' === $this->site ) ? true : false;

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
		$options = get_option( $this->plugin_name );
		$current_domain = parse_url( home_url(), PHP_URL_HOST );
		$live_site_domain = 'www.' . $options['site'] . '.io';
		if ( ! $options['site'] || ! $options['gtm_id'] || $live_site_domain !== $current_domain || is_user_logged_in() ) {
			return;
		}

		$analytics_code = <<<EOD
	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','{$options['gtm_id']}');</script>
	<!-- End Google Tag Manager -->

	EOD;
		echo $analytics_code; //phpcs:ignore

	}

	/**
	 * Inserts the <body> Google Tag Manager code.
	 */
	public function insert_gtm_body() {
		$options = get_option( $this->plugin_name );
		$current_domain = parse_url( home_url(), PHP_URL_HOST );
		$live_site_domain = 'www.' . $options['site'] . '.io';
		if ( ! $options['site'] || ! $options['gtm_id'] || $live_site_domain !== $current_domain || is_user_logged_in() ) {
			return;
		}

		$analytics_code = <<<EOD
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id={$options['gtm_id']}"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->

	EOD;
		echo $analytics_code; //phpcs:ignore

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

			// used by HubSpot forms.
			$add_urls = array(
				'https://js.hscollectedforms.net',
				'https://js.hs-banner.com',
				'https://js.hs-analytics.net',
				'https://js.hsforms.net',
				'https://js.hs-scripts.com',
			);
			// add crossorigin, remove protocol.
			foreach ( $add_urls as $url ) {
				$url = array(
					'crossorigin',
					'href' => str_replace( array( 'http:', 'https:' ), '', $url ),
				);
				array_push( $hints, $url );
			}
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

	/**
	 *
	 * Header clean up of a few different things.
	 */
	public function wordpress_head_cleanup() {
		// category feeds.
		remove_action( 'wp_head', 'feed_links_extra', 3 );

		// post and comment feeds.
		remove_action( 'wp_head', 'feed_links', 2 );

		// EditURI link.
		remove_action( 'wp_head', 'rsd_link' );

		// windows live writer.
		remove_action( 'wp_head', 'wlwmanifest_link' );

		// previous link.
		remove_action( 'wp_head', 'parent_post_rel_link' );

		// start link.
		remove_action( 'wp_head', 'start_post_rel_link' );

		// links for adjacent posts.
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head' );

		// WP version.
		remove_action( 'wp_head', 'wp_generator' );

		// stop xmlrpc.
		add_filter( 'xmlrpc_enabled', '__return_false' );
	}

	/**
	 * Remove Emojis
	 *
	 * Because WordPress is serious business + speed
	 */
	public function disable_wp_emojicons() {
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		add_filter( 'emoji_svg_url', '__return_false' );
	}

	/**
	 * Remove Emojis
	 *
	 *  @param string $plugins Plugins.
	 */
	public function disable_emojicons_tinymce( $plugins ) {
		if ( is_array( $plugins ) ) {
			return array_diff( $plugins, array( 'wpemoji' ) );
		} else {
			return array();
		}
	}

	/**
	 *
	 * Disable pingbacks
	 *
	 * @param string $links Links.
	 */
	public function disable_pingback( &$links ) {
		foreach ( $links as $l => $link ) {
			if ( 0 === strpos( $link, get_option( 'home' ) ) ) {
				unset( $links[ $l ] );
			}
		}
	}

	/**
	 *
	 * Dequeue jQuery Migrate Script.
	 *
	 * @param string $scripts Scripts.
	 */
	public function dequeue_jquery_migrate( $scripts ) {
		if ( ! is_admin() && ! empty( $scripts->registered['jquery'] ) ) {
			$scripts->registered['jquery']->deps = array_diff(
				$scripts->registered['jquery']->deps,
				array( 'jquery-migrate' )
			);
		}
	}

	/**
	 * Remove Dashicons styles
	 *
	 * This might actually no longer be necessary, they were being loaded amongst the site styles
	 */
	public function wpdocs_dequeue_dashicon() {
		if ( ! is_user_logged_in() ) {
			wp_deregister_style( 'dashicons' );
		}
	}

	/**
	 * Remove the News category from the RSS feed.
	 *
	 * @param Object $query Query object.
	 */
	public function remove_news_from_rss( $query ) {
		if ( $query->is_feed ) {
			if ( $this->is_cncf ) {
				$query->set( 'cat', '-229' );
			} else {
				$query->set( 'cat', '-6' );
			}
		}
		return $query;
	}

	/**
	 * Remove the News category from the SEO Framework sitemap.
	 *
	 * @param array $args Query args.
	 */
	public function remove_news_from_sitemap( $args ) {
		if ( $this->is_cncf ) {
			$args['cat'] = -229;
		} else {
			$args['cat'] = -6;
		}

		return $args;
	}

	/**
	 * Remove the Kubeweekly archive from the SEO Framework sitemap.
	 *
	 * @param array $post_types Query args.
	 */
	public function remove_kubeweekly_from_sitemap( $post_types ) {
		$to_exclude = array( 'lf_kubeweekly' );
		return array_diff( $post_types, $to_exclude );
	}

}
