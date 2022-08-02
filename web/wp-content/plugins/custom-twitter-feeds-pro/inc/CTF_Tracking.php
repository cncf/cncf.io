<?php
/**
 * Tracking functions for reporting plugin usage to the Smash Balloon site for users that have opted in
 *
 * @copyright   Copyright (c) 2018, Chris Christoff
 * @since
 */
namespace TwitterFeed;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Usage tracking
 *
 * @access public
 * @since  5.6
 * @return void
 */
class CTF_Tracking {

	public function __construct() {
		add_action( 'init', array( $this, 'schedule_send' ) );
		add_filter( 'cron_schedules', array( $this, 'add_schedules' ) );
		add_action( 'ctf_usage_tracking_cron', array( $this, 'send_checkin' ) );
		add_action( 'admin_init', array( $this, 'save_setting' ) );
	}

	private function normalize_and_format( $key, $value ) {
		$normal_bools = array(
			'ajax_theme',
			'have_own_tokens',
			'use_own_consumer',
			'preserve_settings',
			'usertimeline_includereplies',
			'hometimeline_includereplies',
			'mentionstimeline_includereplies',
			'usertimeline_includeretweets',
			'hometimeline_includeretweets',
			'mentionstimeline_includeretweets',
			'includereplies',
			'includeretweets',
			'include_retweeter',
			'include_avatar',
			'include_author',
			'include_text',
			'include_date',
			'include_actions',
			'include_twitterlink',
			'include_linkbox',
			'include_logo',
			'creditctf',
			'showbutton',
			'showheader',
			'persistentcache',
			'selfreplies',
			'autores',
			'disableintents',
      'customtemplates',
			'shorturls',
			'curlcards',
			'sslonly',
			'disablelightbox',
			'include_media',
			'include_twittercards',
			'include_replied_to',
			'masonry',
			'carousel',
			'carouselpag',
			'autoscroll',
			'showbio',
			'disablelinks',
			'linktexttotwitter',
		);
		$custom_text_settings = array(
			'retweetedtext',
			'twitterlinktext',
			'buttontext',
			'usertimeline_text',
			'hashtag_text',
			'search_text',
			'lists_id',
			'lists_owner',
			'inreplytotext',
			'custom_css',
			'custom_js'
		);
		$comma_separate_counts_settings = array(
			'includewords',
			'excludewords',
			'remove_by_id'
		);
		$defaults = array(
			'ajax_theme' => '0',
			'have_own_tokens' => '',
			'use_own_consumer' => '',
			'preserve_settings' => '',
			'usertimeline_includereplies' => '',
			'hometimeline_includereplies' => '',
			'mentionstimeline_includereplies' => '',
			'usertimeline_includeretweets' => '',
			'hometimeline_includeretweets' => '1',
			'mentionstimeline_includeretweets' => '',
			'tab' => 'configure',
			'consumer_key' => '',
			'consumer_secret' => '',
			'access_token' => '',
			'access_token_secret' => '',
			'type' => 'usertimeline',
			'usertimeline_text' => '',
			'hashtag_text' => '',
			'search_text' => '',
			'lists_id' => '',
			'lists_owner' => '',
			'num' => '5',
			'cache_time' => '1',
			'cache_time_unit' => '3600',
			'includereplies' => '',
			'includeretweets' => '',
			'width_mobile_no_fixed' => '0',
			'include_retweeter' => '1',
			'include_avatar' => '1',
			'include_author' => '1',
			'include_text' => '1',
			'include_date' => '1',
			'include_actions' => '1',
			'include_twitterlink' => '1',
			'include_linkbox' => '1',
			'include_logo' => '1',
			'creditctf' => '0',
			'showbutton' => '1',
			'showheader' => '1',
			'persistentcache' => '1',
			'selfreplies' => '1',
			'autores' => '1',
			'disableintents' => '0',
	      'customtemplates' => '0',
			'shorturls' => '0',
			'curlcards' => '1',
			'sslonly' => '0',
			'disablelightbox' => '0',
			'include_media' => '1',
			'include_twittercards' => '1',
			'include_replied_to' => '1',
			'masonry' => '0',
			'carousel' => '0',
			'carouselpag' => '0',
			'carouselautoplay' => '0',
			'autoscroll' => '1',
			'width' => '100',
			'width_unit' => '%',
			'height' => '',
			'height_unit' => '%',
			'class' => '',
			'layout' => 'list',
			'masonrycols' => '3',
			'masonrymobilecols' => '1',
			'carouselcols' => '3',
			'carouselmobilecols' => '1',
			'carouselloop' => 'none',
			'carouselarrows' => 'onhover',
			'carouselheight' => 'tallest',
			'carouseltime' => '5000',
			'maxmedia' => '4',
			'imagecols' => 'auto',
			'autoscrolldistance' => '200',
			'includewords' => '',
			'excludewords' => '',
			'includeanyall' => 'any',
			'filterandor' => 'and',
			'excludeanyall' => 'any',
			'remove_by_id' => '',
			'custom_css' => '',
			'custom_js' => '',
			'request_method' => 'auto',
			'cron_cache_clear' => 'unset',
			'multiplier' => '1.25',
			'font_method' => 'svg',
			'include_media_placeholder' => '1',
			'showbio' => '1',
			'disablelinks' => '',
			'linktexttotwitter' => '',
			'bgcolor' => '#',
			'tweetbgcolor' => '#',
			'headerbgcolor' => '#',
			'headertextcolor' => '#',
			'headertext' => '',
			'timezone' => 'default',
			'dateformat' => '1',
			'datecustom' => '',
			'mtime' => '',
			'htime' => '',
			'nowtime' => '',
			'datetextsize' => 'inherit',
			'datetextweight' => 'inherit',
			'authortextsize' => 'inherit',
			'authortextweight' => 'inherit',
			'logosize' => 'inherit',
			'logocolor' => '#',
			'tweettextsize' => 'inherit',
			'tweettextweight' => 'inherit',
			'textcolor' => '#',
			'textlength' => '280',
			'retweetedtext' => 'Retweeted',
			'linktextcolor' => '#',
			'quotedauthorsize' => 'inherit',
			'quotedauthorweight' => 'inherit',
			'iconsize' => 'inherit',
			'iconcolor' => '#',
			'twitterlinktext' => 'Twitter',
			'buttoncolor' => '#',
			'buttontextcolor' => '#',
			'buttontext' => 'Load More',
			'inreplytotext' => 'In reply to'
		);

		if ( is_array( $value ) ) {
			if ( empty( $value ) ) {
				return 0;
			}
			return count( $value );
			// 0 for anything that might be false, 1 for everything else
		} elseif ( in_array( $key, $normal_bools, true ) ) {
			if ( in_array( $value, array( false, 0, '0', 'false', '' ), true ) ) {
				return 0;
			}
			return 1;

			// if a custom text setting, we just want to know if it's different than the default
		} elseif ( in_array( $key, $custom_text_settings, true ) ) {
			if ( $defaults[ $key ] === $value ) {
				return 0;
			}
			return 1;
		} elseif ( in_array( $key, $comma_separate_counts_settings, true ) ) {
			if ( str_replace( ' ', '', $value ) === '' ) {
				return 0;
			}
			$split_at_comma = explode( ',', $value );
			return count( $split_at_comma );
		}

		return $value;

	}

	private function get_data() {
		$data = array();

		// Retrieve current theme info
		$theme_data    = wp_get_theme();

		$count_b = 1;
		if ( is_multisite() ) {
			if ( function_exists( 'get_blog_count' ) ) {
				$count_b = get_blog_count();
			} else {
				$count_b = 'Not Set';
			}
		}

		$php_version = rtrim( ltrim( sanitize_text_field( phpversion() ) ) );
		$php_version = ! empty( $php_version ) ? substr( $php_version, 0, strpos( $php_version, '.', strpos( $php_version, '.' ) + 1 ) ) : phpversion();

		global $wp_version;
		$data['this_plugin'] = 'tw';
		$data['php_version']   = $php_version;
		$data['mi_version']    = CTF_VERSION;
		$data['wp_version']    = $wp_version;
		$data['server']        = isset( $_SERVER['SERVER_SOFTWARE'] ) ? $_SERVER['SERVER_SOFTWARE'] : '';
		$data['multisite']     = is_multisite();
		$data['url']           = home_url();
		$data['themename']     = $theme_data->Name;
		$data['themeversion']  = $theme_data->Version;
		$data['settings']      = array();
		$data['pro']           = ctf_is_pro_version() ? '1' : '';
		$data['sites']         = $count_b;
		$data['usagetracking'] = get_option( 'ctf_usage_tracking_config', false );
		$num_users = function_exists( 'count_users' ) ? count_users() : 'Not Set';
		$data['usercount']     = is_array( $num_users ) ? $num_users['total_users'] : 1;
		$data['timezoneoffset']= date('P');

		$settings_to_send = array();
		$raw_settings = get_option( 'ctf_options', array() );

		foreach ( $raw_settings as $key => $value ) {
			if ( $key === 'consumer_key'
			     || $key === 'consumer_secret'
			     || $key === 'access_token'
			     || $key === 'access_token_secret'
			     || $key === 'tab' ) {
				// do not sent
			} elseif ( $key === 'connected_accounts' ) {
				if ( is_array( $raw_settings['connected_accounts'] ) ) {
					$settings_to_send['connected_accounts'] = count( $raw_settings['connected_accounts'] );
				} else {
					$settings_to_send['connected_accounts'] = 0;
				}
			} else {
				$value = $this->normalize_and_format( $key, $value );
				if ( $value !== false ) {
					$settings_to_send[ $key ] = $value;
				}
			}

		}
		global $wpdb;
		$feed_caches = array();

		$results = $wpdb->get_results( "
		SELECT option_name
        FROM $wpdb->options
        WHERE `option_name` LIKE ('%\_transient\_ctf\_%')
        AND `option_name` NOT LIKE ('%\_transient\_ctf\_header%');", ARRAY_A );

		if ( isset( $results[0] ) ) {
			$feed_caches = $results;
		}
		$settings_to_send['num_found_feed_caches'] = count( $feed_caches );

		$data['settings']      = $settings_to_send;

		// Retrieve current plugin information
		if( ! function_exists( 'get_plugins' ) ) {
			include ABSPATH . '/wp-admin/includes/plugin.php';
		}

		$plugins = get_plugins();
		$active_plugins = get_option( 'active_plugins', array() );
		$plugins_to_send = array();

		foreach ( $plugins as $plugin_path => $plugin ) {
			// If the plugin isn't active, don't show it.
			if ( ! in_array( $plugin_path, $active_plugins ) )
				continue;

			$plugins_to_send[] = $plugin['Name'];
		}

		$data['active_plugins']   = $plugins_to_send;
		$data['locale']           = get_locale();

		return $data;
	}

	public function send_checkin( $override = false, $ignore_last_checkin = false ) {

		$home_url = trailingslashit( home_url() );

		if ( strpos( $home_url, 'smashballoon.com' ) !== false ) {
			return false;
		}

		if( ! $this->tracking_allowed() && ! $override ) {
			return false;
		}

		// Send a maximum of once per week
		$usage_tracking = get_option( 'ctf_usage_tracking', array( 'last_send' => 0, 'enabled' => ctf_is_pro_version() ) );
		if ( is_numeric( $usage_tracking['last_send'] ) && $usage_tracking['last_send'] > strtotime( '-1 week' ) && ! $ignore_last_checkin ) {
			return false;
		}

		$request = wp_remote_post( 'https://usage.smashballoon.com/v1/checkin/', array(
			'method'      => 'POST',
			'timeout'     => 5,
			'redirection' => 5,
			'httpversion' => '1.1',
			'blocking'    => false,
			'body'        => $this->get_data(),
			'user-agent'  => 'MI/' . CTF_VERSION . '; ' . get_bloginfo( 'url' )
		) );

		// If we have completed successfully, recheck in 1 week
		$usage_tracking['last_send'] = time();
		update_option( 'ctf_usage_tracking', $usage_tracking, false );
		return true;
	}

	private function tracking_allowed() {
		$usage_tracking = get_option( 'ctf_usage_tracking', array( 'last_send' => 0, 'enabled' => ctf_is_pro_version() ) );
		$tracking_allowed = isset( $usage_tracking['enabled'] ) ? $usage_tracking['enabled'] : ctf_is_pro_version();

		return $tracking_allowed;
	}

	public function schedule_send() {
		if ( ! wp_next_scheduled( 'ctf_usage_tracking_cron' ) ) {
			$tracking             = array();
			$tracking['day']      = rand( 0, 6  );
			$tracking['hour']     = rand( 0, 23 );
			$tracking['minute']   = rand( 0, 59 );
			$tracking['second']   = rand( 0, 59 );
			$tracking['offset']   = ( $tracking['day']    * DAY_IN_SECONDS    ) +
			                        ( $tracking['hour']   * HOUR_IN_SECONDS   ) +
			                        ( $tracking['minute'] * MINUTE_IN_SECONDS ) +
			                        $tracking['second'];
			$last_sunday = strtotime("next sunday") - (7 * DAY_IN_SECONDS);
			if ( ($last_sunday + $tracking['offset']) > time() + 6 * HOUR_IN_SECONDS ) {
				$tracking['initsend'] = $last_sunday + $tracking['offset'];
			} else {
				$tracking['initsend'] = strtotime("next sunday") + $tracking['offset'];
			}

			wp_schedule_event( $tracking['initsend'], 'weekly', 'ctf_usage_tracking_cron' );
			update_option( 'ctf_usage_tracking_config', $tracking );
		}
	}

	public function add_schedules( $schedules = array() ) {
		// Adds once weekly to the existing schedules.
		$schedules['weekly'] = array(
			'interval' => 604800,
			'display'  => __( 'Once Weekly', 'custom-twitter-feeds' )
		);
		return $schedules;
	}

	public function save_setting() {
		if ( isset( $_POST['ctf_usage_tracking_enable'] ) ) {
			$usage_tracking['enabled'] = false;
			if ( isset( $_POST['ctf_usage_tracking_enable'] ) && $_POST['ctf_usage_tracking_enable'] === 'on' ) {
				$usage_tracking['enabled'] = true;
			}
			update_option( 'ctf_usage_tracking', $usage_tracking, false );
		}
	}
}
new CTF_Tracking();