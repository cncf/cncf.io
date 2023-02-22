<?php

/**
 * The About Page
 *
 * @since 2.0
 */

namespace TwitterFeed\Admin;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

use TwitterFeed\Admin\CTF_View;
use TwitterFeed\Admin\CTF_Response;

class CTF_About_Us {
    /**
	 * Admin menu page slug.
	 *
	 * @since 2.0
	 *
	 * @var string
	 */
	const SLUG = 'ctf-about-us';

	/**
	 * Initializing the class
	 *
	 * @since 2.0
	 */
	function __construct(){
		$this->init();
	}

    /**
	 * Determining if the user is viewing the our page, if so, party on.
	 *
	 * @since 2.0
	 */
	public function init() {
		if ( ! is_admin() ) {
			return;
		}

		add_action( 'admin_menu', [ $this, 'register_menu' ] );
	}

	/**
	 * Register Menu.
	 *
	 * @since 2.0
	 */
	function register_menu() {
        $cap = current_user_can( 'manage_twitter_feed_options' ) ? 'manage_twitter_feed_options' : 'manage_options';
        $cap = apply_filters( 'ctf_settings_pages_capability', $cap );

       $about_us = add_submenu_page(
           'custom-twitter-feeds',
           __( 'About Us', 'custom-twitter-feeds' ),
           __( 'About Us', 'custom-twitter-feeds' ),
           $cap,
           self::SLUG,
           [$this, 'about_us'],
           4
       );
       add_action( 'load-' . $about_us, [$this,'about_us_enqueue_assets']);
   }

   	/**
	 * Enqueue About Us Page CSS & Script.
	 *
	 * Loads only for About Us page
	 *
	 * @since 2.0
	 */
    public function about_us_enqueue_assets(){
        if( ! get_current_screen() ) {
			return;
		}
		$screen = get_current_screen();
		if ( ! 'twitter-feed_page_ctf-about-us' === $screen->id ) {
            return;
		}

		wp_enqueue_style(
			'about-style',
			CTF_PLUGIN_URL . 'admin/assets/css/about.css',
			false,
			CTF_VERSION
		);

		wp_enqueue_script(
			'vue-main',
			'https://cdn.jsdelivr.net/npm/vue@2.6.12',
			null,
			'2.6.12',
			true
		);

		wp_enqueue_script(
			'about-app',
			CTF_PLUGIN_URL.'admin/assets/js/about.js',
			null,
			CTF_VERSION,
			true
		);

		$ctf_about = $this->page_data();

        wp_localize_script(
			'about-app',
			'ctf_about',
			$ctf_about
		);
    }

    /**
     * Page Data to use in front end
     *
     * @since 2.0
     *
     * @return array
     */
    public function page_data() {
        // get the WordPress's core list of installed plugins
        if ( ! function_exists( 'get_plugins' ) ) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }
        $license_key = null;
		if ( get_option('ctf_license_key') ) {
			$license_key = get_option('ctf_license_key');
		}

        $installed_plugins = get_plugins();

        $images_url = CTF_PLUGIN_URL . 'admin/assets/img/about/';

        // check whether the pro or free plugins are installed
        $is_facebook_installed = false;
        $facebook_plugin = 'custom-facebook-feed/custom-facebook-feed.php';
        if ( isset( $installed_plugins['custom-facebook-feed-pro/custom-facebook-feed.php'] ) ) {
            $is_facebook_installed = true;
            $facebook_plugin = 'custom-facebook-feed-pro/custom-facebook-feed.php';
        } else if ( isset( $installed_plugins['custom-facebook-feed/custom-facebook-feed.php'] ) ) {
            $is_facebook_installed = true;
        }

        $is_instagram_installed = false;
        $instagram_plugin = 'instagram-feed/instagram-feed.php';
        if ( isset( $installed_plugins['instagram-feed-pro/instagram-feed.php'] ) ) {
            $is_instagram_installed = true;
            $instagram_plugin = 'instagram-feed-pro/instagram-feed.php';
        } else if ( isset( $installed_plugins['instagram-feed/instagram-feed.php'] ) ) {
            $is_instagram_installed = true;
        }

        $is_twitter_installed = false;
        $twitter_plugin = 'custom-twitter-feeds/custom-twitter-feed.php';
        if ( isset( $installed_plugins['custom-twitter-feeds-pro/custom-twitter-feed.php'] ) ) {
            $is_twitter_installed = true;
            $twitter_plugin = 'custom-twitter-feeds-pro/custom-twitter-feed.php';
        } else if ( isset( $installed_plugins['custom-twitter-feeds/custom-twitter-feed.php'] ) ) {
            $is_twitter_installed = true;
        }

        $is_youtube_installed = false;
        $youtube_plugin = 'feeds-for-youtube/youtube-feed.php';
        if ( isset( $installed_plugins['youtube-feed-pro/youtube-feed.php'] ) ) {
            $is_youtube_installed = true;
            $youtube_plugin = 'youtube-feed-pro/youtube-feed.php';
        } else if ( isset( $installed_plugins['feeds-for-youtube/youtube-feed.php'] ) ) {
            $is_youtube_installed = true;
        }

        $license_key = null;
		if ( ctf_license_handler()->get_license_key ) {
			$license_key = ctf_license_handler()->get_license_key;
		}

        $return = array(
			'admin_url' 		=> admin_url(),
            'supportPageUrl'    => admin_url( 'admin.php?page=ctf-support' ),
			'ajax_handler'		=> admin_url( 'admin-ajax.php' ),
			'links'				=> \TwitterFeed\Builder\CTF_Feed_Builder::get_links_with_utm(),
			'nonce'		        =>  wp_create_nonce( 'ctf-admin' ),
			'socialWallLinks'   => \TwitterFeed\Builder\CTF_Feed_Builder::get_social_wall_links(),
			'socialWallActivated' => is_plugin_active( 'social-wall/social-wall.php' ),
			'licenseKey'		=> $license_key,
			'ctfLicenseInactiveState' => ctf_license_inactive_state() ? true : false,
			'ctfLicenseNoticeActive' =>  ctf_license_notice_active() ? true : false,
			'svgIcons' => \TwitterFeed\Builder\CTF_Feed_Builder::builder_svg_icons(),
			'genericText'       => array(
				'help' => __( 'Help', 'custom-twitter-feeds' ),
				'title' => __( 'About Us', 'custom-twitter-feeds' ),
				'title2' => __( 'Our Other Social Media Feed Plugins', 'custom-twitter-feeds' ),
				'title3' => __( 'Plugins we recommend', 'custom-twitter-feeds' ),
				'description2' => __( 'We’re more than just an Instagram plugin! Check out our other plugins and add more content to your site.', 'custom-twitter-feeds' ),
				'recheckLicense' => __( 'Recheck license', 'custom-twitter-feeds' ),
				'licenseValid' => __( 'License valid', 'custom-twitter-feeds' ),
				'licenseExpired' => __( 'License expired', 'custom-twitter-feeds' ),
                'notification' => array(
                    'licenseActivated'   => array(
                        'type' => 'success',
                        'text' => __( 'License Successfully Activated', 'custom-twitter-feeds' ),
                    ),
                    'licenseError'   => array(
                        'type' => 'error',
                        'text' => __( 'Couldn\'t Activate License', 'custom-twitter-feeds' ),
                    ),
                    'licenseKeyEmpty'   => array(
                        'type' => 'error',
                        'text' => __( 'Please enter a license key', 'custom-twitter-feeds' ),
                    ),
                )
            ),
            'aboutBox'      => array(
                'atSmashBalloon' => __( 'At Smash Balloon, we build software that helps you create beautiful responsive social media feeds for your website in minutes.', 'custom-twitter-feeds' ),
				'weAreOn' => __( 'We\'re on a mission to make it super simple to add social media feeds in WordPress. No more complicated setup steps, ugly iframe widgets, or negative page speed scores.', 'custom-twitter-feeds' ),
                'ourPlugins' => __( 'Our plugins aren\'t just easy to use, but completely customizable, reliable, and fast! Which is why over 1.6 million awesome users, just like you, choose to use them on their site.', 'custom-twitter-feeds' ),
                'teamAvatar' => CTF_PLUGIN_URL . 'admin/assets/img/team-avatar.png',
                'teamImgAlt' => __( 'Smash Balloon Team', 'custom-twitter-feeds' ),
            ),
            'pluginsInfo'      => array(
	            'instagram'  => array(
		            'plugin' => $instagram_plugin,
		            'download_plugin' => 'https://downloads.wordpress.org/plugin/instagram-feed.zip',
		            'title' => __( 'Instagram Feed', 'custom-twitter-feeds' ),
		            'description' => __( 'A quick and elegant way to add your Instagram posts to your website. ', 'custom-twitter-feeds' ),
		            'icon' => CTF_PLUGIN_URL . 'admin/assets/img/insta-icon.svg',
		            'installed' => $is_instagram_installed,
		            'activated' => is_plugin_active( $instagram_plugin ),
	            ),
	            'facebook'  => array(
                    'plugin' => $facebook_plugin,
                    'title' => __( 'Custom Facebook Feed', 'custom-twitter-feeds' ),
                    'description' => __( 'Add Facebook posts from your timeline, albums and much more.', 'custom-twitter-feeds' ),
                    'icon' => CTF_PLUGIN_URL . 'admin/assets/img/fb-icon.svg',
                    'installed' => $is_facebook_installed,
                    'activated' => is_plugin_active( $facebook_plugin ),
                ),
                'twitter'  => array(
                    'plugin' => $twitter_plugin,
                    'download_plugin' => 'https://downloads.wordpress.org/plugin/custom-twitter-feeds.zip',
                    'title' => __( 'Custom Twitter Feeds', 'custom-twitter-feeds' ),
                    'description' => __( 'A customizable way to display tweets from your Twitter account. ', 'custom-twitter-feeds' ),
                    'icon' => CTF_PLUGIN_URL . 'admin/assets/img/twitter-icon.svg',
                    'installed' => $is_twitter_installed,
                    'activated' => is_plugin_active( $twitter_plugin ),
                ),
                'youtube'  => array(
                    'plugin' => $youtube_plugin,
                    'download_plugin' => 'https://downloads.wordpress.org/plugin/feeds-for-youtube.zip',
                    'title' => __( 'Feeds for YouTube', 'custom-twitter-feeds' ),
                    'description' => __( 'A simple yet powerful way to display videos from YouTube. ', 'custom-twitter-feeds' ),
                    'icon' => CTF_PLUGIN_URL . 'admin/assets/img/youtube-icon.svg',
                    'installed' => $is_youtube_installed,
                    'activated' => is_plugin_active( $youtube_plugin ),
                )
            ),
            'social_wall'  => array(
                'plugin' => 'social-wall/social-wall.php',
                'title' => __( 'Social Wall', 'custom-twitter-feeds' ),
                'description' => __( 'Combine feeds from all of our plugins into a single wall', 'custom-twitter-feeds' ),
                'graphic' => CTF_PLUGIN_URL . 'admin/assets/img/social-wall-graphic.png',
                'permalink' => sprintf('https://smashballoon.com/social-wall/demo?license_key=%s&upgrade=true&utm_campaign=twitter-pro&utm_source=about&utm_medium=social-wall', $license_key),
                'installed' => isset( $installed_plugins['social-wall/social-wall.php'] ) ? true : false,
                'activated' => is_plugin_active('social-wall/social-wall.php'),
            ),
            'recommendedPlugins'      => array(
                'wpforms'  => array(
                    'plugin' => 'wpforms-lite/wpforms.php',
                    'download_plugin' => 'https://downloads.wordpress.org/plugin/wpforms-lite.zip',
                    'title' => __( 'WPForms', 'custom-twitter-feeds' ),
                    'description' => __( 'The most beginner friendly drag & drop WordPress forms plugin allowing you to create beautiful contact forms, subscription forms, payment forms, and more in minutes, not hours!', 'custom-twitter-feeds' ),
                    'icon' => $images_url . 'plugin-wpforms.png',
                    'installed' => isset( $installed_plugins['wpforms-lite/wpforms.php'] ) ? true : false,
                    'activated' => is_plugin_active('wpforms-lite/wpforms.php'),
                ),
                'monsterinsights'  => array(
                    'plugin' => 'google-analytics-for-wordpress/googleanalytics.php',
                    'download_plugin' => 'https://downloads.wordpress.org/plugin/google-analytics-for-wordpress.zip',
                    'title' => __( 'MonsterInsights', 'custom-twitter-feeds' ),
                    'description' => __( 'MonsterInsights makes it “effortless” to properly connect your WordPress site with Google Analytics, so you can start making data-driven decisions to grow your business.', 'custom-twitter-feeds' ),
                    'icon' => $images_url . 'plugin-mi.png',
                    'installed' => isset( $installed_plugins['google-analytics-for-wordpress/googleanalytics.php'] ) ? true : false,
                    'activated' => is_plugin_active('google-analytics-for-wordpress/googleanalytics.php'),
                ),
                'optinmonster'  => array(
                    'plugin' => 'optinmonster/optin-monster-wp-api.php',
                    'download_plugin' => 'https://downloads.wordpress.org/plugin/optinmonster.zip',
                    'title' => __( 'OptinMonster', 'custom-twitter-feeds' ),
                    'description' => __( 'Our high-converting optin forms like Exit-Intent® popups, Fullscreen Welcome Mats, and Scroll boxes help you dramatically boost conversions and get more email subscribers.', 'custom-twitter-feeds' ),
                    'icon' => $images_url . 'plugin-om.png',
                    'installed' => isset( $installed_plugins['optinmonster/optin-monster-wp-api.php'] ) ? true : false,
                    'activated' => is_plugin_active('optinmonster/optin-monster-wp-api.php'),
                ),
                'wp_mail_smtp'  => array(
                    'plugin' => 'wp-mail-smtp/wp_mail_smtp.php',
                    'download_plugin' => 'https://downloads.wordpress.org/plugin/wp-mail-smtp.zip',
                    'title' => __( 'WP Mail SMTP', 'custom-twitter-feeds' ),
                    'description' => __( 'Make sure your website\'s emails reach the inbox. Our goal is to make email deliverability easy and reliable. Trusted by over 1 million websites.', 'custom-twitter-feeds' ),
                    'icon' => $images_url . 'plugin-smtp.png',
                    'installed' => isset( $installed_plugins['wp-mail-smtp/wp_mail_smtp.php'] ) ? true : false,
                    'activated' => is_plugin_active('wp-mail-smtp/wp_mail_smtp.php'),
                ),
                'rafflepress'  => array(
                    'plugin' => 'rafflepress/rafflepress.php',
                    'download_plugin' => 'https://downloads.wordpress.org/plugin/rafflepress.zip',
                    'title' => __( 'RafflePress', 'custom-twitter-feeds' ),
                    'description' => __( 'Turn your visitors into brand ambassadors! Easily grow your email list, website traffic, and social media followers with powerful viral giveaways & contests.', 'custom-twitter-feeds' ),
                    'icon' => $images_url . 'plugin-rp.png',
                    'installed' => isset( $installed_plugins['rafflepress/rafflepress.php'] ) ? true : false,
                    'activated' => is_plugin_active('rafflepress/rafflepress.php'),
                ),
                'aioseo'  => array(
                    'plugin' => 'all-in-one-seo-pack/all_in_one_seo_pack.php',
                    'download_plugin' => 'https://downloads.wordpress.org/plugin/all-in-one-seo-pack.zip',
                    'title' => __( 'All in One SEO Pack', 'custom-twitter-feeds' ),
                    'description' => __( 'Out-of-the-box SEO for WordPress. Features like XML Sitemaps, SEO for custom post types, SEO for blogs, business sites, or ecommerce sites, and much more.', 'custom-twitter-feeds' ),
                    'icon' => $images_url . 'plugin-seo.png',
                    'installed' => isset( $installed_plugins['all-in-one-seo-pack/all_in_one_seo_pack.php'] ) ? true : false,
                    'activated' => is_plugin_active('all-in-one-seo-pack/all_in_one_seo_pack.php'),
                )
            ),
            'buttons'          => array(
                'add' => __( 'Add', 'custom-twitter-feeds' ),
                'viewDemo' => __( 'View Demo', 'custom-twitter-feeds' ),
                'install' => __( 'Install', 'custom-twitter-feeds' ),
                'installed' => __( 'Installed', 'custom-twitter-feeds' ),
                'activate' => __( 'Activate', 'custom-twitter-feeds' ),
                'deactivate' => __( 'Deactivate', 'custom-twitter-feeds' ),
                'open' => __( 'Open', 'custom-twitter-feeds' ),
            ),
            'icons' => array(
                'plusIcon' => '<svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.0832 6.83317H7.08317V11.8332H5.4165V6.83317H0.416504V5.1665H5.4165V0.166504H7.08317V5.1665H12.0832V6.83317Z" fill="white"/></svg>',
                'loaderSVG' => '<svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="20px" height="20px" viewBox="0 0 50 50" style="enable-background:new 0 0 50 50;" xml:space="preserve"><path fill="#fff" d="M43.935,25.145c0-10.318-8.364-18.683-18.683-18.683c-10.318,0-18.683,8.365-18.683,18.683h4.068c0-8.071,6.543-14.615,14.615-14.615c8.072,0,14.615,6.543,14.615,14.615H43.935z"><animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 25 25" to="360 25 25" dur="0.6s" repeatCount="indefinite"/></path></svg>',
                'checkmarkSVG' => '<svg width="13" height="10" viewBox="0 0 13 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M5.13112 6.88917L11.4951 0.525204L12.9093 1.93942L5.13112 9.71759L0.888482 5.47495L2.3027 4.06074L5.13112 6.88917Z" fill="#8C8F9A"/></svg>',
                'link'  => '<svg width="10" height="11" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0.333374 9.22668L7.39338 2.16668H3.00004V0.833344H9.66671V7.50001H8.33338V3.10668L1.27337 10.1667L0.333374 9.22668Z" fill="#141B38"/></svg>'
            ),
        );

        return $return;
    }

   	/**
	 * About Us Page View Template
	 *
	 * @since 2.0
	 */
	public function about_us(){
		return CTF_View::render( 'about.index' );
	}
}