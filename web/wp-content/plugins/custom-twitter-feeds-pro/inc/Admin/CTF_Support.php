<?php

/**
 * The Settings Page
 *
 * @since 2.0
 */

namespace TwitterFeed\Admin;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

use TwitterFeed\Admin\CTF_View;
use TwitterFeed\Admin\CTF_Response;
use TwitterFeed\Builder\CTF_Db;
//use TwitterFeed\CTF_Feed_Locator;
use TwitterFeed\Builder\CTF_Feed_Builder;
//use TwitterFeed\CTF_GDPR_Integrations;
use TwitterFeed\Builder\CTF_Feed_Saver_Manager;

class CTF_Support {
    /**
     * Admin menu page slug.
     *
     * @since 2.0
     *
     * @var string
     */
    const SLUG = 'ctf-support';

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
        add_action( 'wp_ajax_ctf_export_settings_json', [$this, 'ctf_export_settings_json'] );
    }

    /**
     * Register Menu.
     *
     * @since 2.0
     */
    function register_menu() {
        $cap = current_user_can( 'manage_twitter_feed_options' ) ? 'manage_twitter_feed_options' : 'manage_options';
        $cap = apply_filters( 'ctf_settings_pages_capability', $cap );
       $support_page = add_submenu_page(
           'custom-twitter-feeds',
           __( 'Support', 'custom-twitter-feeds' ),
           __( 'Support', 'custom-twitter-feeds' ),
           $cap,
           self::SLUG,
           [$this, 'support_page'],
           4
       );
       add_action( 'load-' . $support_page, [$this,'support_page_enqueue_assets']);
   }

    /**
     * Enqueue Extension CSS & Script.
     *
     * Loads only for Extension page
     *
     * @since 2.0
     */
    public function support_page_enqueue_assets(){
        if( ! get_current_screen() ) {
            return;
        }
        $screen = get_current_screen();

        if ( ! 'twitter-feed_page_ctf-support' === $screen->id ) {
            return;
        }

        wp_enqueue_style(
            'ctf-fira-code-font',
            'https://fonts.googleapis.com/css2?family=Fira+Code&display=swap',
            false,
            CTF_VERSION
        );

        wp_enqueue_style(
            'support-style',
            CTF_PLUGIN_URL . 'admin/assets/css/support.css',
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
            'support-app',
            CTF_PLUGIN_URL.'admin/assets/js/support.js',
            null,
            CTF_VERSION,
            true
        );

        $ctf_support = $this->page_data();

        wp_localize_script(
            'support-app',
            'ctf_support',
            $ctf_support
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
        $exported_feeds = CTF_Db::feeds_query();
        $feeds = array();
        foreach( $exported_feeds as $feed_id => $feed ) {
            $feeds[] = array(
                'id' => $feed['id'],
                'name' => $feed['feed_name']
            );
        }

        $return = array(
            'admin_url'         => admin_url(),
            'ajax_handler'      => admin_url( 'admin-ajax.php' ),
            'nonce'             =>  wp_create_nonce( 'ctf-admin' ),
            'links'             => \TwitterFeed\Builder\CTF_Feed_Builder::get_links_with_utm(),
            'supportPageUrl'    => admin_url( 'admin.php?page=ctf-support' ),
            'siteSearchUrl'     => 'https://smashballoon.com/search/',
            'system_info'       => $this->get_system_info(),
            'system_info_n'     => str_replace("</br>", "\n", $this->get_system_info()),
            'feeds'             => $feeds,
            'supportUrl'        => $this->get_support_url(),
            'svgIcons'          => CTF_Feed_Builder::builder_svg_icons(),
            'socialWallLinks'   => \TwitterFeed\Builder\CTF_Feed_Builder::get_social_wall_links(),
            'socialWallActivated' => is_plugin_active( 'social-wall/social-wall.php' ),
            'genericText'       => array(
                'help' => __( 'Help', 'custom-twitter-feeds' ),
                'title' => __( 'Support', 'custom-twitter-feeds' ),
                'gettingStarted' => __( 'Getting Started', 'custom-twitter-feeds' ),
                'someHelpful' => __( 'Some helpful resources to get you started', 'custom-twitter-feeds' ),
                'docsN' => __( 'Docs & Troubleshooting', 'custom-twitter-feeds' ),
                'runInto' => __( 'Run into an issue? Check out our help docs.', 'custom-twitter-feeds' ),
                'additionalR' => __( 'Additional Resources', 'custom-twitter-feeds' ),
                'toHelp' => __( 'To help you get the most out of the plugin', 'custom-twitter-feeds' ),
                'needMore' => __( 'Need more support? We’re here to help.', 'custom-twitter-feeds' ),
                'ourFast' => __( 'Our fast and friendly support team is always happy to help!', 'custom-twitter-feeds' ),
                'systemInfo' => __( 'System Info', 'custom-twitter-feeds' ),
                'exportSettings' => __( 'Export Settings', 'custom-twitter-feeds' ),
                'shareYour' => __( 'Share your plugin settings easily with Support', 'custom-twitter-feeds' ),
                'copiedToClipboard' => __( 'Copied to clipboard', 'custom-twitter-feeds' ),
            ),
            'buttons'          => array(
                'searchDoc' => __( 'Search Documentation', 'custom-twitter-feeds' ),
                'moreHelp' => __( 'More help on Getting started', 'custom-twitter-feeds' ),
                'viewDoc' => __( 'View Documentation', 'custom-twitter-feeds' ),
                'viewBlog' => __( 'View Blog', 'custom-twitter-feeds' ),
                'submitTicket' => __( 'Submit a Support Ticket', 'custom-twitter-feeds' ),
                'copy' => __( 'Copy', 'custom-twitter-feeds' ),
                'copied' => __( 'Copied', 'custom-twitter-feeds' ),
                'copy' => __( 'Copy', 'custom-twitter-feeds' ),
                'export' => __( 'Export', 'custom-twitter-feeds' ),
                'expand' => __( 'Expand', 'custom-twitter-feeds' ),
                'collapse' => __( 'Collapse', 'custom-twitter-feeds' ),
            ),
            'icons' => array(
                'rocket' => CTF_PLUGIN_URL . 'admin/assets/img/rocket-icon.png',
                'book' => CTF_PLUGIN_URL . 'admin/assets/img/book-icon.png',
                'save' => CTF_PLUGIN_URL . 'admin/assets/img/save-plus-icon.png',
                'magnify' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5.91667 0.5C7.35326 0.5 8.73101 1.07068 9.74683 2.08651C10.7627 3.10233 11.3333 4.48008 11.3333 5.91667C11.3333 7.25833 10.8417 8.49167 10.0333 9.44167L10.2583 9.66667H10.9167L15.0833 13.8333L13.8333 15.0833L9.66667 10.9167V10.2583L9.44167 10.0333C8.45879 10.8723 7.20892 11.3333 5.91667 11.3333C4.48008 11.3333 3.10233 10.7627 2.08651 9.74683C1.07068 8.73101 0.5 7.35326 0.5 5.91667C0.5 4.48008 1.07068 3.10233 2.08651 2.08651C3.10233 1.07068 4.48008 0.5 5.91667 0.5ZM5.91667 2.16667C3.83333 2.16667 2.16667 3.83333 2.16667 5.91667C2.16667 8 3.83333 9.66667 5.91667 9.66667C8 9.66667 9.66667 8 9.66667 5.91667C9.66667 3.83333 8 2.16667 5.91667 2.16667Z" fill="#141B38"/></svg>',
                'rightAngle' => '<svg width="7" height="11" viewBox="0 0 5 8" fill="#000" xmlns="http://www.w3.org/2000/svg"><path d="M1.00006 0L0.0600586 0.94L3.11339 4L0.0600586 7.06L1.00006 8L5.00006 4L1.00006 0Z" fill="#000"/></svg>',
                'linkIcon' => '<svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0.166626 10.6583L8.99163 1.83329H3.49996V0.166626H11.8333V8.49996H10.1666V3.00829L1.34163 11.8333L0.166626 10.6583Z" fill="#141B38"/></svg>',
                'plusIcon' => '<svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.0832 6.83317H7.08317V11.8332H5.4165V6.83317H0.416504V5.1665H5.4165V0.166504H7.08317V5.1665H12.0832V6.83317Z" fill="white"/></>',
                'loaderSVG' => '<svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="20px" height="20px" viewBox="0 0 50 50" style="enable-background:new 0 0 50 50;" xml:space="preserve"><path fill="#fff" d="M43.935,25.145c0-10.318-8.364-18.683-18.683-18.683c-10.318,0-18.683,8.365-18.683,18.683h4.068c0-8.071,6.543-14.615,14.615-14.615c8.072,0,14.615,6.543,14.615,14.615H43.935z"><animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 25 25" to="360 25 25" dur="0.6s" repeatCount="indefinite"/></path></svg>',
                'checkmarkSVG' => '<svg width="13" height="10" viewBox="0 0 13 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M5.13112 6.88917L11.4951 0.525204L12.9093 1.93942L5.13112 9.71759L0.888482 5.47495L2.3027 4.06074L5.13112 6.88917Z" fill="#8C8F9A"/></svg>',
                'forum' => '<svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M19.8335 14V3.50004C19.8335 3.19062 19.7106 2.89388 19.4918 2.67508C19.273 2.45629 18.9762 2.33337 18.6668 2.33337H3.50016C3.19074 2.33337 2.894 2.45629 2.6752 2.67508C2.45641 2.89388 2.3335 3.19062 2.3335 3.50004V19.8334L7.00016 15.1667H18.6668C18.9762 15.1667 19.273 15.0438 19.4918 14.825C19.7106 14.6062 19.8335 14.3095 19.8335 14ZM24.5002 7.00004H22.1668V17.5H7.00016V19.8334C7.00016 20.1428 7.12308 20.4395 7.34187 20.6583C7.56066 20.8771 7.85741 21 8.16683 21H21.0002L25.6668 25.6667V8.16671C25.6668 7.85729 25.5439 7.56054 25.3251 7.34175C25.1063 7.12296 24.8096 7.00004 24.5002 7.00004Z" fill="#141B38"/></svg>',
                'copy' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 1.33334H6C5.26667 1.33334 4.66667 1.93334 4.66667 2.66667V10.6667C4.66667 11.4 5.26667 12 6 12H12C12.7333 12 13.3333 11.4 13.3333 10.6667V2.66667C13.3333 1.93334 12.7333 1.33334 12 1.33334ZM12 10.6667H6V2.66667H12V10.6667ZM2 10V8.66667H3.33333V10H2ZM2 6.33334H3.33333V7.66667H2V6.33334ZM6.66667 13.3333H8V14.6667H6.66667V13.3333ZM2 12.3333V11H3.33333V12.3333H2ZM3.33333 14.6667C2.6 14.6667 2 14.0667 2 13.3333H3.33333V14.6667ZM5.66667 14.6667H4.33333V13.3333H5.66667V14.6667ZM9 14.6667V13.3333H10.3333C10.3333 14.0667 9.73333 14.6667 9 14.6667ZM3.33333 4V5.33334H2C2 4.6 2.6 4 3.33333 4Z" fill="#141B38"/></svg>',
                'downAngle' => '<svg width="8" height="6" viewBox="0 0 8 6" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0.94 0.226685L4 3.28002L7.06 0.226685L8 1.16668L4 5.16668L0 1.16668L0.94 0.226685Z" fill="#141B38"/></svg>',
                'exportSVG' => '<svg class="btn-icon" width="12" height="15" viewBox="0 0 12 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0.166748 14.6667H11.8334V13H0.166748V14.6667ZM11.8334 5.5H8.50008V0.5H3.50008V5.5H0.166748L6.00008 11.3333L11.8334 5.5Z" fill="#141B38"/></svg>',
            ),
            'images' => array(
                'supportMembers' => CTF_PLUGIN_URL . 'admin/assets/img/support-members.png'
            ),
            'articles' => array(
                'gettingStarted' => array(
                    array(
                        'title' => __( 'Creating your first Twitter feed', 'custom-twitter-feeds' ),
                        'link' => 'https://smashballoon.com/custom-twitter-feeds/docs/setup/?utm_campaign=twitter-pro&utm_source=support&utm_medium=docs&utm_content=Creating your first Twitter feed'
                    ),
                    array(
                        'title' => __( 'How to Build a Search Feed', 'custom-twitter-feeds' ),
                        'link' => 'https://smashballoon.com/how-to-build-a-search-feed/?utm_campaign=twitter-pro&utm_source=support&utm_medium=docs&utm_content=How to Build a Search Feed'
                    ),
                    array(
                        'title' => __( 'How to Create a Twitter List', 'custom-twitter-feeds' ),
                        'link' => 'https://smashballoon.com/how-do-i-create-a-twitter-list/?utm_campaign=twitter-pro&utm_source=support&utm_medium=docs&utm_content=How to Create a Twitter List'
                    ),
                ),
                'docs' => array(
                    array(
                        'title' => __( 'There is a Problem With Twitter Card Links in My Feed', 'custom-twitter-feeds' ),
                        'link' => 'https://smashballoon.com/doc/there-is-a-problem-with-twitter-card-links-in-my-feed/?twitter&utm_campaign=twitter-pro&utm_source=support&utm_medium=docs&utm_content=There is a Problem With Twitter Card Links in My Feed'
                    ),
                    array(
                        'title' => __( 'How to Resolve Error Messages', 'custom-twitter-feeds' ),
                        'link' => 'https://smashballoon.com/custom-twitter-feeds/docs/errors/?utm_campaign=twitter-pro&utm_source=support&utm_medium=docs&utm_content=How to Resolve Error Messages'
                    ),
                    array(
                        'title' => __( 'My Feed Stopped Updating', 'custom-twitter-feeds' ),
                        'link' => 'https://smashballoon.com/my-feed-wont-show-the-latest-tweets/?utm_campaign=twitter-pro&utm_source=support&utm_medium=docs&utm_content=My Feed Stopped Updating'
                    ),
                ),
                'resources' => array(
                    array(
                        'title' => __( 'How to Create a Twitter Developer App', 'custom-twitter-feeds' ),
                        'link' => 'https://smashballoon.com/custom-twitter-feeds/docs/create-twitter-app/?utm_campaign=twitter-pro&utm_source=support&utm_medium=docs&utm_content=How to Create a Twitter Developer App'
                    ),
                    array(
                        'title' => __( 'How to Display Tweets From a Specific Account That Have a Specific Hashtag', 'custom-twitter-feeds' ),
                        'link' => 'https://smashballoon.com/doc/can-i-display-tweets-from-a-specific-screen-name-that-has-a-certain-hashtag/?twitter?utm_campaign=twitter-pro&utm_source=support&utm_medium=docs&utm_content=How to Display Tweets From a Specific Account That Have a Specific Hashtag'
                    ),
                    array(
                        'title' => __( 'Combine Multiple Feed Types into a Single Feed', 'custom-twitter-feeds' ),
                        'link' => 'https://smashballoon.com/doc/combine-multiple-feed-types-into-one-single-twitter-feed/?twitter?utm_campaign=twitter-pro&utm_source=support&utm_medium=docs&utm_content=Combine Multiple Feed Types into a Single Feed'
                    ),
                ),
            )
        );

        return $return;
    }

    /**
     * Get System Info
     *
     * @since 2.0
     */
    public function get_system_info() {
        $output = '';

        // Build the output strings
        $output .= self::get_site_n_server_info();
        $output .= self::get_active_plugins_info();
        $output .= self::get_global_settings_info();
        $output .= self::get_feeds_settings_info();
	    $output .= self::get_api_info();
	    $output .= self::get_cron_report();
	    $output .= self::get_image_resizing_info();
        $output .= self::get_posts_table_info();
        $output .= self::get_errors_info();
        #$output .= self::get_action_logs_info();
        #$output .= self::get_oembeds_info();

        return $output;
    }

    /**
     * Get Site and Server Info
     *
     * @since 2.0
     *
     * @return string
     */
    public static function get_site_n_server_info() {
        $allow_url_fopen = ini_get( 'allow_url_fopen' ) ? "Yes" : "No";
        $php_curl = is_callable('curl_init') ? "Yes" : "No";
        $php_json_decode = function_exists("json_decode") ? "Yes" : "No";
        $php_ssl = in_array('https', stream_get_wrappers()) ? "Yes" : "No";

        $output = '## SITE/SERVER INFO: ##' . "</br>";
        $output .= 'Plugin Version:' . self::get_whitespace( 11 ) . CTF_PLUGIN_NAME . "</br>";
        $output .= 'Site URL:' . self::get_whitespace( 17 ) . site_url() . "</br>";
        $output .= 'Home URL:' . self::get_whitespace( 17 ) . home_url() . "</br>";
        $output .= 'WordPress Version:' . self::get_whitespace( 8 ) . get_bloginfo( 'version' ) . "</br>";
        $output .= 'PHP Version:' . self::get_whitespace( 14 ) . PHP_VERSION . "</br>";
        $output .= 'Web Server Info:' . self::get_whitespace( 10 ) . $_SERVER['SERVER_SOFTWARE'] . "</br>";
        $output .= 'PHP allow_url_fopen:' . self::get_whitespace( 6 ) . $allow_url_fopen . "</br>";
        $output .= 'PHP cURL:' . self::get_whitespace( 17 ) . $php_curl . "</br>";
        $output .= 'JSON:' . self::get_whitespace( 21 ) . $php_json_decode . "</br>";
        $output .= 'SSL Stream:' . self::get_whitespace( 15 ) . $php_ssl . "</br>";
        $output .= "</br>";

        return $output;
    }

    /**
     * Get Active Plugins
     *
     * @since 2.0
     *
     * @return string
     */
    public static function get_active_plugins_info() {
        $plugins = get_plugins();
        $active_plugins = get_option('active_plugins');
        $output = "## ACTIVE PLUGINS: ## </br>";

        foreach ( $plugins as $plugin_path => $plugin ) {
            if ( in_array( $plugin_path, $active_plugins ) ) {
                $output .= $plugin['Name'] . ': ' . $plugin['Version'] ."</br>";
            }
        }

        $output .= "</br>";

        return $output;
    }

    /**
     * Get Global Settings
     *
     * @since 2.0
     *
     * @return string
     */
    public static function get_global_settings_info() {
        $output = "## GLOBAL SETTINGS: ## </br>";
        $ctf_license_key = get_option( 'ctf_license_key' );
        $ctf_license_data = get_option( 'ctf_license_data' );
        $ctf_license_status = get_option( 'ctf_license_status' );
        $ctf_settings = ctf_get_database_settings();
        $usage_tracking = get_option( 'ctf_usage_tracking', array( 'last_send' => 0, 'enabled' => \ctf_is_pro_version() ) );

        $output .= 'License key: ';
        if ( $ctf_license_key ) {
            $output .= $ctf_license_key;
        } else {
            $output .= ' Not added';;
        }
        $output .= "</br>";
        $output .= 'License status: ';
        if ( $ctf_license_status ) {
            $output .= $ctf_license_status;
        } else {
            $output .= ' Inactive';
        }
        $output .= "</br>";
        $output .= 'Preserve settings if plugin is removed: ';
       # $output .= ( $ctf_settings['sb_instagram_preserve_settings'] ) ? 'Yes' : 'No';
        $output .= "</br>";
        $output .= "Connected Accounts: ";
        $output .= 'Placeholder!';

        $output .= "</br>";
        $output .= 'Caching: ';
        if ( wp_next_scheduled( 'ctf_feed_update' ) ) {
            $time_format = get_option( 'time_format' );
            if ( ! $time_format ) {
                $time_format = 'g:i a';
            }
            //
            $schedule = wp_get_schedule( 'ctf_feed_update' );
            if ( $schedule == '30mins' ) $schedule = __( 'every 30 minutes', 'custom-twitter-feeds' );
            if ( $schedule == 'twicedaily' ) $schedule = __( 'every 12 hours', 'custom-twitter-feeds' );
            $ctf_next_cron_event = wp_next_scheduled( 'ctf_feed_update' );
            $output = __( 'Next check', 'custom-twitter-feeds' ) . ': ' . date( $time_format, $ctf_next_cron_event + ctf_get_utc_offset() ) . ' (' . $schedule . ')';

        } else {
            $output .= 'Nothing currently scheduled';
        }
        $output .= "</br>";
        $output .= 'GDPR: ';
        $output .= isset( $ctf_settings[ 'gdpr' ] ) ? $ctf_settings[ 'gdpr' ] : ' Not setup';
        $output .= "</br>";
        $output .= 'Custom CSS: ';
        $output .= isset( $ctf_settings['custom_css'] ) && ! empty( $ctf_settings['custom_css'] ) ? $ctf_settings['custom_css'] : 'Empty';
        $output .= "</br>";
        $output .= 'Custom JS: ';
        $output .= isset( $ctf_settings['custom_js'] ) && ! empty( $ctf_settings['custom_js'] ) ? $ctf_settings['custom_js'] : 'Empty';
        $output .= "</br>";
        $output .= 'Optimize Images: ';
        $output .= isset( $ctf_settings[ 'resizing' ] ) && $ctf_settings[ 'resizing' ] ? 'Enabled' : 'Disabled';
        $output .= "</br>";
        $output .= 'Usage Tracking: ';
        $output .= isset( $usage_tracking['enabled'] ) && $usage_tracking['enabled'] == true ? 'Enabled' : 'Disabled';
        $output .= "</br>";
        $output .= 'AJAX theme loading fix: ';
        $output .= isset( $ctf_settings[ 'ajax_theme' ] ) && $ctf_settings[ 'ajax_theme' ] == true ? 'Enabled' : 'Disabled';
        $output .= "</br>";
        $output .= 'Enqueue in Head: ';
        $output .= isset( $ctf_settings['headenqueue'] ) && $ctf_settings['headenqueue'] == true ? 'Enabled' : 'Disabled';
        $output .= "</br>";
        $output .= "</br>";
        return $output;
    }

    /**
     * Get Feeds Settings
     *
     * @since 2.0
     *
     * @return string
     */
    public static function get_feeds_settings_info() {
        $output = "## FEEDS: ## </br>";

        $feeds_list = CTF_Feed_Builder::get_feed_list();
        $i = 0;
        foreach( $feeds_list as $feed ) {

            $type = ! empty( $feed['settings']->type ) ? $feed['settings']->type : 'user';
            if ( $i >= 25 ) {
                break;
            }
            $output .= $feed['feed_name'];
            if ( isset( $feed['settings'] ) ) {
                $source = array();
                $output .= ' - ' . ucfirst( $type );
                $output .= '</br>';

            }
            $output .= "</br>";
            if ( isset( $feed['location_summary'] ) && count( $feed['location_summary'] ) > 0 ) {
                $first_feed = $feed['location_summary'][0];
                $output .= $first_feed['link'] . '?sb_debug';
            }
            $output .= "</br>";

            $i++;
        }
        $output .= "</br>";

        return $output;
    }

	/**
	 * Get API Response Info
	 *
	 * @since 2.0
	 *
	 * @return string
	 */
	public static function get_api_info() {
		$options = get_option( 'ctf_options' );
		$consumer_key = ! empty( $options['consumer_key'] ) && ! empty( $options['have_own_tokens'] ) ? $options['consumer_key'] : 'FPYSYWIdyUIQ76Yz5hdYo5r7y';
		$consumer_secret = ! empty( $options['consumer_secret'] ) && ! empty( $options['have_own_tokens'] ) ? $options['consumer_secret'] : 'GqPj9BPgJXjRKIGXCULJljocGPC62wN2eeMSnmZpVelWreFk9z';
		$request_settings = array(
			'consumer_key' => $consumer_key,
			'consumer_secret' => $consumer_secret,
			'access_token' => $options['access_token'],
			'access_token_secret' => $options['access_token_secret']
		);
		$output = '';
		if ( isset( $options['request_method'] ) ) {
			$request_method = isset( $options['request_method'] ) ? $options['request_method'] : 'auto';

			$twitter_api = new \TwitterFeed\CtfOauthConnect( $request_settings, 'usertimeline' );
			$twitter_api->setUrlBase();
			$get_fields = array( 'count' => '1' );
			$twitter_api->setGetFields( $get_fields );
			$twitter_api->setRequestMethod( $request_method );

			$twitter_api->performRequest();
			$response    = json_decode( $twitter_api->json, $assoc = true );
			$screen_name = isset( $response[0] ) ? $response[0]['user']['screen_name'] : 'error';
			if ( $screen_name === 'error' ) {
				if ( isset( $response['errors'][0] ) ) {
					$twitter_api->api_error_no      = $response['errors'][0]['code'];
					$twitter_api->api_error_message = $response['errors'][0]['message'];
				}
			}

			$output .= '## Twitter API RESPONSE: ## <br>';
			if ( ! empty( $twitter_api->api_error_no ) ) {
				$output .= 'Error No:   ' . esc_html( $twitter_api->api_error_no ) . '<br>';
				$output .= 'Error Message:   ' . esc_html( $twitter_api->api_error_message ) . '<br>';
			} else {
				$output .= 'Connection was successful! <br>';
				$output .= 'Account Screen Name:   ' . esc_html( $screen_name ) . '<br>';
			}

		} //End isset check

		$output .= "</br>";

		return $output;
	}

	/**
	 * Get Reports
	 *
	 * @since 6.0
	 *
	 * @return string
	 */
	public static function get_cron_report() {
		$output      = '## Cron Cache Report: ## </br>';
		$cron_report = get_option( 'ctf_cron_report', array() );
		if ( ! empty( $cron_report ) ) {
			$output .= 'Time Ran: ' . esc_html( $cron_report['notes']['time_ran'] );
			$output .= '</br>';
			$output .= 'Found Feeds: ' . esc_html( $cron_report['notes']['num_found_transients'] );
			$output .= '</br>';
			$output .= '</br>';

			foreach ( $cron_report as $key => $value ) {
				if ( $key !== 'notes' ) {
					$output .= esc_html( $key ) . ':';
					$output .= '</br>';
					if ( ! empty( $value['last_retrieve'] ) ) {
						$output .= 'Last Retrieve: ' . esc_html( $value['last_retrieve'] );
						$output .= '</br>';
					}
					if ( ! empty( $value['did_update'] ) ) {
						$output .= 'Did Update: ' . esc_html( $value['did_update'] );
					}
					$output .= '</br>';
					$output .= '</br>';
				}
			}
		} else {
			$output .= 'No Cron Report </br></br>';
		}

		$cron = _get_cron_array();
		foreach ( $cron as $key => $data ) {
			$is_target = false;
			foreach ( $data as $key2 => $val ) {
				if ( strpos( $key2, 'ctf' ) !== false || strpos( $key2, 'twitter' ) !== false ) {
					$is_target = true;
					$output   .= esc_html( $key2 );
					$output   .= '</br>';
				}
			}
			if ( $is_target ) {
				$output .= esc_html( date( 'Y-m-d H:i:s', $key ) );
				$output .= '</br>';
				$output .= esc_html( 'Next Scheduled: ' . round( ( (int) $key - time() ) / 60 ) . ' minutes' );
				$output .= '</br>';
				$output .= '</br>';
			}
		}

		return $output;
	}

    /**
     * Get Image Resizing Info
     *
     * @since 2.0
     *
     * @return string
     */
    public static function get_image_resizing_info() {
        $output = "## IMAGE RESIZING: ##" . "</br>";

        $upload  = wp_upload_dir();
        $upload_dir = $upload['basedir'];
        $upload_dir = trailingslashit( $upload_dir ) . CTF_UPLOADS_NAME;
        if ( file_exists( $upload_dir ) ) {
            $output .= 'upload directory exists' . "</br>";
        } else {
            $created = wp_mkdir_p( $upload_dir );
            if ( ! $created ) {
                $output .= 'cannot create upload directory';
            }
        }
        $output .= "</br>";

        return $output;
    }

    /**
     * Get Posts Table Info
     *
     * @since 2.0
     *
     * @return string
     */
    public static function get_posts_table_info() {
        $output = "## POSTS: ## </br>";

        global $wpdb;
        $table_name      = esc_sql( $wpdb->prefix . CTF_POSTS_TABLE );
        $feeds_posts_table_name = esc_sql( $wpdb->prefix . CTF_FEEDS_POSTS_TABLE );

        if ( $wpdb->get_var( "show tables like '$feeds_posts_table_name'" ) != $feeds_posts_table_name ) {
            $output .= 'no feeds posts table' . "</br>";
        } else {
            $last_result = $wpdb->get_results( "SELECT * FROM $feeds_posts_table_name ORDER BY id DESC LIMIT 1;" );
            if ( is_array( $last_result ) && isset( $last_result[0] ) ) {
                $output .= '## FEEDS POSTS TABLE ##' . "</br>";
                foreach ( $last_result as $column ) {
                    foreach ( $column as $key => $value ) {
                        $output .= $key . ': ' . esc_html( $value ) . "</br>";;
                    }
                }
            } else {
                $output .= 'feeds posts has no rows';
                $output .= "</br>";
            }
        }
        $output .= "</br>";
        if ( $wpdb->get_var( "show tables like '$table_name'" ) != $table_name ) {
            $output .= 'no posts table' . "</br>";
        } else {
            $last_result = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY id DESC LIMIT 1;" );
            if ( is_array( $last_result ) && isset( $last_result[0] ) ) {
                $output .= '## POSTS TABLE ##';
                $output .= "</br>";
                foreach ( $last_result as $column ) {
                    foreach ( $column as $key => $value ) {
                        $output .= $key . ': ' . esc_html( $value ) . "</br>";;
                    }
                }
            } else {
                $output .= 'posts has no rows' . "</br>";
            }
        }
        $output .= "</br>";

        return $output;
    }

    /**
     * SBI Get Errors Info
     *
     * @since 2.0
     *
     * @return string
     */
    public static function get_errors_info() {
	    $errors = get_option( 'ctf_errors', array() );
	    $output = "## ERRORS: ##" . "</br>";
		if ( ! empty( $errors ) ) {
			foreach ( $errors as $error ) {
				$output .=  esc_html( $error )  . "</br>";
			}
		} else {
			$output .=  "No Error Information Stored</br>";
		}

        return $output;
    }

    /**
     * Get Action Logs Info
     *
     * @since 2.0
     *
     * @return string
     */
    public static function get_action_logs_info() {
        $output = "## ACTION LOG ##" . "</br>";
        global $sb_instagram_posts_manager;

        $actions = $sb_instagram_posts_manager->get_action_log();
        if ( ! empty( $actions ) ) :
            foreach ( $actions as $action ) :
                $output .= strip_tags($action) . "</br>";
            endforeach;
        endif;
        $output .= "</br>";

        return $output;
    }

    /**
     * Get Feeds Settings
     *
     * @since 2.0
     *
     * @return string
     */
    public static function get_oembeds_info() {
        $output = "## OEMBED: ##" . "</br>";
        $oembed_token_settings = get_option( 'ctf_oembed_token', array() );
        foreach( $oembed_token_settings as $key => $value ) {
            $output .= $key . ': ' . esc_attr( $value ) . "</br>";
        }

        return $output;
    }

    /**
     * SBI Get Support URL
     *
     * @since 2.0
     *
     * @return string $url
     */
    public function get_support_url() {
        $url = 'https://smashballoon.com/custom-twitter-feeds/support/';
        $license_type = ctf_is_pro_version() ? 'pro' : 'free';

        $args = array();
        $license_key = get_option( 'ctf_license_key' );
        if ( $license_key ) {
            $license_key = ctf_encrypt_decrypt( 'encrypt', $license_key );
            $args['license'] = $license_key;
        }

        $args['license_type'] = $license_type;
        $args['version'] = CTF_VERSION;
        $url = add_query_arg( $args, $url );
        return $url;
    }

    /**
     * SBI Export Feed Settings JSON
     *
     * @since 2.0
     *
     * @return CTF_Response
     */
    public function ctf_export_settings_json() {
        \TwitterFeed\Builder\CTF_Feed_Builder::check_privilege();

        if ( ! isset( $_GET['feed_id'] ) ) {
            return;
        }
        $feed_id = filter_var( $_GET['feed_id'], FILTER_SANITIZE_NUMBER_INT );
        $feed = CTF_Feed_Saver_Manager::get_export_json( $feed_id );
        $feed_info = CTF_Db::feeds_query( array('id' => $feed_id) );
        $feed_name = strtolower( $feed_info[0]['feed_name'] );
        $filename = 'ctf-feed-' . $feed_name . '.json';
        // Creates a new csv file and store it in tmp directory
        $file = fopen( '/tmp/' . $filename, 'w' );
        fwrite($file, $feed);
        fclose($file);
        // output headers so that the file is downloaded rather than displayed
        header( "Content-type: application/json" );
        header( "Content-disposition: attachment; filename = " . $filename );
        readfile( "/tmp/" . $filename );
        exit;
    }

    /**
     * SBI Get Whitespace
     *
     * @since 2.0
     *
     * @param int $times
     *
     * @return string
     */
    public static function get_whitespace( $times ) {
        return str_repeat('&nbsp;', $times );
    }

    /**
     * Extensions Manager Page View Template
     *
     * @since 2.0
     */
    public function support_page(){
        return CTF_View::render( 'support.index' );
    }
}
