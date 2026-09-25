<?php
// phpcs:ignoreFile
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
	}

	/**
	 * Remove wp-embed script to speed things up https://kinsta.com/knowledgebase/disable-embeds-wordpress/.
	 */
	public function deregister_scripts() {
		wp_dequeue_script( 'wp-embed' );
	}

	/**
	 * Check if we should load GTM.
	 *
	 * @return boolean
	 */
	public function should_load_gtm() {
		$options          = get_option( $this->plugin_name );
		$current_domain   = wp_parse_url( home_url(), PHP_URL_HOST );
		$live_site_domain = 'www.cncf.io';

		if ( ! $options['gtm_id'] || $live_site_domain !== $current_domain || is_user_logged_in() ) {
			return false;
		}
		return true;
	}

	/**
	 * Inserts <head> Transcend Consent Management code.
	 *
	 * Must load before any other tracking scripts so it can gate them.
	 */
	public function insert_transcend_head() {

		if ( ! $this->should_load_gtm() ) {
			return;
		}

		$transcend_code = <<<EOD
	<!-- Transcend Consent Management -->
	<script
		src="https://transcend-cdn.com/cm/f484e2d0-ad2e-43a9-9d64-d07f6fa20966/airgap.js"
		data-cfasync="false"
		data-prompt="auto"
	></script>
	<!-- End Transcend Consent Management -->

	EOD;
		echo $transcend_code; //phpcs:ignore
	}

	/**
	 * Inserts <head> Google Tag Manager code.
	 */
	public function insert_gtm_head() {

		if ( ! $this->should_load_gtm() ) {
			return;
		}

		$options = get_option( $this->plugin_name );

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
		if ( ! $this->should_load_gtm() ) {
			return;
		}

		$options = get_option( $this->plugin_name );

		$analytics_code = <<<EOD
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id={$options['gtm_id']}"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->

	EOD;
		echo $analytics_code; //phpcs:ignore
	}

	/**
	 * Inserts LFX code.
	 */
	function lfe_insert_lfx_head() {
		wp_enqueue_script(
			'lfx-segment',
			'https://lfx-segment.platform.linuxfoundation.org/latest/lfx-segment-analytics.min.js',
			array(),
			null,
			false
		);

		wp_add_inline_script(
			'lfx-segment',
			"if(window.LfxAnalytics&&window.LfxAnalytics.LfxSegmentsAnalytics){var analytics=window.LfxAnalytics.LfxSegmentsAnalytics.getInstance();analytics.init().then(function(){}).catch(function(error){console.error('Failed to initialize analytics:',error)});}else{console.warn('LfxAnalytics not found');}"
		);
	}

	/**
	 * Fix preconnect and preload to better optimize loading. Preconnect is priority, must have crossorigin; Prefetch just opens connection.
	 *
	 * @param string $hints returns hints.
	 * @param string $relation_type returns priority.
	 */
	public function change_to_preconnect_resource_hints( $hints, $relation_type ) {

		if ( 'preconnect' === $relation_type ) {
			$add_urls = array(
				'https://js.hscollectedforms.net',
				'https://js.hs-banner.com',
				'https://js.hs-analytics.net',
				'https://js.hsforms.net',
				'https://js.hs-scripts.com',
				'https://landscape.cncf.io',
				'//www.googletagmanager.com',
				'//www.gstatic.com',
				'https://browser-update.org',
				'https://js-agent.newrelic.com',
			);
			// add crossorigin, remove protocol.
			foreach ( $add_urls as $url ) {
				$url = array(
					'crossorigin',
					'href' => str_replace( array( 'http:', 'https:' ), '', $url ),
				);
				array_push( $hints, $url );
			}
		} elseif ( 'dns-prefetch' === $relation_type ) {
			// create array of URLs to remove from prefetch.
			$url_arr = array( 'code.jquery.com', 's.w.org' );

			foreach ( $url_arr as $url ) {
				$key = array_search( $url, $hints, true );
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

		// controls whether XML-RPC methods requiring authentication are enabled.
		add_filter( 'xmlrpc_enabled', '__return_false' );

		// Unregister the whole XML-RPC method space.
		add_filter( 'xmlrpc_methods', fn( $methods ) => array() );

		// deactivate x-pingback HTTP header.
		add_filter(
			'wp_headers',
			function ( $headers ) {
				unset( $headers['X-Pingback'] );
				return $headers;
			}
		);

		// remove application passwords.
		add_filter( 'wp_is_application_passwords_available', '__return_false' );

		 // Add strict-origin-when-cross-origin referrer policy.
		 add_action( 'wp_head', 'wp_strict_cross_origin_referrer' );

		 // Add X-Frame-Options SAMEORIGIN.
		 add_action( 'send_headers', 'send_frame_options_header', 10, 0 );
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
			$query->set( 'cat', '-229' );
		}
		return $query;
	}

	/**
	 * Remove the News category from the SEO Framework sitemap.
	 *
	 * @param array $args Query args.
	 */
	public function remove_news_from_sitemap( $args ) {
		$args['cat'] = -229;

		return $args;
	}

	/**
	 * Remove the Newsletter archives from the SEO Framework sitemap.
	 *
	 * @param array $post_types Query args.
	 */
	public function remove_newsletters_from_sitemap( $post_types ) {
		$to_exclude = array( 'lf_kubeweekly', 'lf_eu_newsletter', 'lf_course' );
		return array_diff( $post_types, $to_exclude );
	}

	/**
	 * Adds Content-Signal directives (see https://contentsignals.org) to robots.txt.
	 *
	 * Runs after The SEO Framework so the line lands inside its `User-agent: *` group,
	 * then adds an explicit group welcoming known AI crawlers.
	 *
	 * @param string $output robots.txt output.
	 * @return string
	 */
	public function add_content_signal_to_robots( $output ) {
		$signal = 'Content-Signal: search=yes, ai-input=yes, ai-train=yes';

		if ( false !== stripos( $output, 'Content-Signal:' ) ) {
			return $output;
		}

		$count  = 0;
		$output = preg_replace( '/^(User-agent:\s*\*\s*\R)/mi', '$1' . $signal . "\n", $output, 1, $count );

		$groups = 0 === $count ? "User-agent: *\n" . $signal . "\n\n" : '';

		$ai_agents = array(
			'GPTBot',
			'OAI-SearchBot',
			'ChatGPT-User',
			'ClaudeBot',
			'Claude-Web',
			'Claude-User',
			'Claude-SearchBot',
			'anthropic-ai',
			'Google-Extended',
			'PerplexityBot',
			'Perplexity-User',
			'Applebot-Extended',
			'CCBot',
			'Bytespider',
			'Meta-ExternalAgent',
			'Amazonbot',
			'cohere-ai',
			'MistralAI-User',
			'DuckAssistBot',
		);

		$groups .= "# Explicitly welcomed AI crawlers\n";
		foreach ( $ai_agents as $agent ) {
			$groups .= 'User-agent: ' . $agent . "\n";
		}
		$groups .= $signal . "\n";

		// Keep Sitemap lines last; they are not part of any user-agent group.
		$count  = 0;
		$output = preg_replace( '/^(?=Sitemap:)/mi', $groups . "\n", $output, 1, $count );

		if ( 0 === $count ) {
			$output = ltrim( rtrim( (string) $output ) . "\n\n" . $groups );
		}

		return $output;
	}

	/**
	 * Overrides the default cache headers.
	 */
	public function add_header_cache() {
		if ( ! is_admin() && ! is_user_logged_in() ) {
			header( 'Cache-Control: public, max-age=60, s-maxage=43200, stale-while-revalidate=86400, stale-if-error=604800' );
		}
	}

	/**
	 * Serves /llms.txt as plain-text markdown (see https://llmstxt.org).
	 *
	 * Hooked on parse_request rather than a rewrite rule because mu-plugins
	 * cannot flush rewrite rules on activation.
	 *
	 * @param WP $wp Current WordPress environment instance.
	 */
	public function maybe_serve_llms_txt( $wp ) {
		if ( 'llms.txt' !== $wp->request ) {
			return;
		}

		status_header( 200 );
		header( 'Content-Type: text/plain; charset=utf-8' );
		$this->add_header_cache();

		echo $this->build_llms_txt(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Plain-text body; values sanitized in builder.
		exit;
	}

	/**
	 * Builds the llms.txt markdown document.
	 *
	 * @return string
	 */
	private function build_llms_txt() {
		$name        = $this->llms_text( get_bloginfo( 'name' ) );
		$description = $this->llms_text( get_bloginfo( 'description' ) );
		if ( ! $description ) {
			$description = 'CNCF is the open source, vendor-neutral hub of cloud native computing, hosting projects like Kubernetes and Prometheus to make cloud native universal and sustainable.';
		}

		$lines   = array();
		$lines[] = '# ' . $name;
		$lines[] = '';
		$lines[] = '> ' . $description;
		$lines[] = '';
		$lines[] = 'The Cloud Native Computing Foundation (CNCF) is part of the Linux Foundation. This site covers CNCF-hosted open source projects, end user case studies, training and certification, events such as KubeCon + CloudNativeCon, research reports, and community programs.';
		$lines[] = '';
		$lines[] = 'URL patterns: projects live at /projects/{slug}/, case studies at /case-studies/{slug}/, reports at /reports/{slug}/, blog posts at /blog/YYYY/MM/DD/{slug}/ and press releases at /announcements/YYYY/MM/DD/{slug}/.';

		$sections = include plugin_dir_path( __FILE__ ) . 'partials/llms-txt-sections.php';
		foreach ( $sections as $heading => $items ) {
			$lines[] = '';
			$lines[] = '## ' . $heading;
			$lines[] = '';
			foreach ( $items as $item ) {
				$lines[] = $this->llms_link_line( home_url( $item['path'] ), $item['title'], $item['description'] );
			}
		}

		$dynamic = array(
			'Latest Blog Posts'    => array(
				'post_type'     => 'post',
				'category_name' => 'blog',
			),
			'Latest Announcements' => array(
				'post_type'     => 'post',
				'category_name' => 'announcements',
			),
			'Latest Reports'       => array( 'post_type' => 'lf_report' ),
			'Latest Case Studies'  => array( 'post_type' => 'lf_case_study' ),
		);
		foreach ( $dynamic as $heading => $args ) {
			$posts = get_posts(
				array_merge(
					array(
						'post_status'         => 'publish',
						'numberposts'         => 5,
						'no_found_rows'       => true,
						'ignore_sticky_posts' => true,
					),
					$args
				)
			);
			if ( ! $posts ) {
				continue;
			}
			$lines[] = '';
			$lines[] = '## ' . $heading;
			$lines[] = '';
			foreach ( $posts as $post ) {
				$lines[] = $this->llms_link_line( get_permalink( $post ), get_the_title( $post ), get_the_date( 'Y-m-d', $post ) );
			}
		}

		return implode( "\n", $lines ) . "\n";
	}

	/**
	 * Formats a single llms.txt list item.
	 *
	 * @param string $url         Absolute URL.
	 * @param string $title       Link text.
	 * @param string $description Optional trailing description.
	 * @return string
	 */
	private function llms_link_line( $url, $title, $description = '' ) {
		$line = '- [' . $this->llms_text( $title ) . '](' . esc_url_raw( $url ) . ')';
		if ( $description ) {
			$line .= ': ' . $this->llms_text( $description );
		}
		return $line;
	}

	/**
	 * Normalizes a string for plain-text markdown output.
	 *
	 * @param string $text Raw text.
	 * @return string
	 */
	private function llms_text( $text ) {
		$text = html_entity_decode( wp_strip_all_tags( (string) $text ), ENT_QUOTES, 'UTF-8' );
		return trim( preg_replace( '/\s+/', ' ', $text ) );
	}

	/**
	 * Filters the author for RSS feeds to use the guest author if appropriate
	 * or ignore certain other authors.
	 *
	 * @param string $display_name Display name.
	 *
	 */
	public function rss_author_prep( $display_name ) {
		if ( is_feed() ) {
			$author = get_post_meta( get_the_ID(), 'lf_post_guest_author', true );
			if ( $author ) {
				// Return guest author if there is one.
				return $author;
			}

			$authors_to_ignore = array( 'Jessie', 'Katie Meinders', 'Libby Schulze', 'Valerie' );
			if ( in_array( $display_name, $authors_to_ignore, false ) ) {
				// return "CNCF" if the author is in the ignore list.
				return 'CNCF';
			} else {
				return $display_name;
			}
		}

		return $display_name;
	}
}
