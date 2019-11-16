<?php
/**
 * Plugin Name: WP RSS Aggregator - Feed to Post
 * Plugin URI: https://www.wprssaggregator.com/#utm_source=wpadmin&utm_medium=plugin&utm_campaign=wpraplugin
 * Description: Adds feed-to-post conversion functionality to WP RSS Aggregator.
 * Version: 3.10
 * Author: RebelCode
 * Author URI: https://www.wprssaggregator.com
 * Text Domain: wprss
 * Domain Path: /languages/
 * License: GPLv3
 */

/**
 * Copyright (C) 2012-2019 RebelCode Ltd.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

use Aventura\Wprss\FeedToPost\Addon;
use Aventura\Wprss\FeedToPost\Factory;
use Psr\Container\ContainerInterface;

/* Set the version number of the plugin. */
if( !defined( 'WPRSS_FTP_VERSION' ) )
	define( 'WPRSS_FTP_VERSION', '3.10' );

/* Set the database version number of the plugin. */
if( !defined( 'WPRSS_FTP_DB_VERSION' ) )
	define( 'WPRSS_FTP_DB_VERSION', '6' );

/* Set constant path to the plugin directory. */
if( !defined( 'WPRSS_FTP_DIR' ) )
	define( 'WPRSS_FTP_DIR', plugin_dir_path( __FILE__ ) );

/* Set constant URI to the plugin URL. */
if( !defined( 'WPRSS_FTP_URI' ) )
	define( 'WPRSS_FTP_URI', plugin_dir_url( __FILE__ ) );

/* Set constant path to the main plugin file. */
if( !defined( 'WPRSS_FTP_PATH' ) )
	define( 'WPRSS_FTP_PATH', __FILE__ );

/* Set the constant path to the plugin's includes directory. */
if( !defined( 'WPRSS_FTP_INC' ) )
	define( 'WPRSS_FTP_INC', WPRSS_FTP_DIR . trailingslashit( 'includes' ) );

/* Set the constant path to the plugin's includes directory. */
if( !defined( 'WPRSS_FTP_LIB' ) )
	define( 'WPRSS_FTP_LIB', WPRSS_FTP_INC . trailingslashit( 'libraries' ) );

/* Set the constant path to the plugin's css directory. */
if( !defined( 'WPRSS_FTP_CSS' ) )
	define( 'WPRSS_FTP_CSS', WPRSS_FTP_URI . trailingslashit( 'css' ) );

/* Set the constant path to the plugin's css directory. */
if( !defined( 'WPRSS_FTP_JS' ) )
	define( 'WPRSS_FTP_JS', WPRSS_FTP_URI . trailingslashit( 'js' ) );

if ( !defined( 'WPRSS_FTP_SL_STORE_URL' ) ) {
	define( 'WPRSS_FTP_SL_STORE_URL', 'http://www.wprssaggregator.com/edd-sl-api/' );
}

if ( !defined( 'WPRSS_FTP_SL_ITEM_NAME' ) ) {
	define( 'WPRSS_FTP_SL_ITEM_NAME', 'Feed to Post' );
}

if ( !defined( 'WPRSS_FTP_LOG_FILE' ) ) {
	if ( defined( 'WPRSS_LOG_FILE' ) ) {
		define( 'WPRSS_FTP_LOG_FILE', WPRSS_LOG_FILE );
	} else {
		define( 'WPRSS_FTP_LOG_FILE', WPRSS_FTP_DIR . '/log.txt' );
	}
}

// Full Text RSS KEY
if ( !defined( 'WPRSS_FTP_FULL_TEXT_RSS_KEY' ) ) {
	define( 'WPRSS_FTP_FULL_TEXT_RSS_KEY', 'a490502e-0cca-11e4-a6f4-005056a548e6' );
}

// FeedsAPI Request URL Format
if ( !defined( 'WPRSS_FTP_FEEDS_API_REQUEST_FORMAT' ) ) {
	define( 'WPRSS_FTP_FEEDS_API_REQUEST_FORMAT', 'http://www.feedsapi.org/fetch.php?url={{url}}&key={{key}}&max=-1' );
}

// If total number of users is greater than this, Chosen Ajax will be used
if( !defined( 'WPRSS_FTP_USER_AJAX_COUNT_THRESHOLD' ) ) {
    define('WPRSS_FTP_USER_AJAX_COUNT_THRESHOLD', 20);
}

// Amount of seconds for cache files to be considered valid
if ( !defined( 'WPRSS_FTP_IMAGE_CACHE_TTL' ) )
	define( 'WPRSS_FTP_IMAGE_CACHE_TTL', 60 * 60 * 24 * 7 ); // 1 week

// Amount of seconds for image resource to respond during download
if ( !defined( 'WPRSS_FTP_IMAGE_CACHE_DOWNLOAD_REQUEST_TIMEOUT' ) )
	define( 'WPRSS_FTP_IMAGE_CACHE_DOWNLOAD_REQUEST_TIMEOUT', 60 ); // 1 minute

// Amount of chars of the original image filename to preserve. Changing this may lead to cache invalidation
if ( !defined( 'WPRSS_FTP_IMAGE_CACHE_ORIG_FILENAME_LENGTH' ) )
        define( 'WPRSS_FTP_IMAGE_CACHE_ORIG_FILENAME_LENGTH', 25 ); // Characters

/**
* Load required files.
*/

// Adding autoload paths
add_action('plugins_loaded', function() {
	$coreActive = defined('WPRSS_VERSION');

	if (!$coreActive || version_compare(WPRSS_VERSION, WPRSS_FTP::WPRSS_MIN_VERSION, '<')) {
		add_action('admin_notices', 'wprss_f2p_missing_core_notice');

		return;
	}

    // Set the "active" constant
    define('WPRSS_FTP_ACTIVE', true);

    if (!WPRSS_FTP_ACTIVE) {
        return;
    }

	// Load Composer autoloader if it exists
	if (file_exists(WPRSS_FTP_DIR . 'vendor/autoload.php')) {
		require_once WPRSS_FTP_DIR . 'vendor/autoload.php';
	}

	// Register the old aventura namespace for autoloading
	wprss_autoloader()->add('Aventura\\Wprss\\FeedToPost', WPRSS_FTP_INC);

	// Load required files
    require_once ( WPRSS_FTP_INC . 'licensing.php' );
    require_once ( WPRSS_FTP_INC . 'wprss-ftp-utils.php' );
    require_once ( WPRSS_FTP_INC . 'wprss-ftp-appender.php' );
    require_once ( WPRSS_FTP_INC . 'wprss-ftp-settings.php' );
    require_once ( WPRSS_FTP_INC . 'wprss-ftp-meta.php' );
    require_once ( WPRSS_FTP_INC . 'wprss-ftp-converter.php' );
    require_once ( WPRSS_FTP_INC . 'wprss-ftp-images.php' );
    require_once ( WPRSS_FTP_INC . 'wprss-ftp-display.php' );
    require_once ( WPRSS_FTP_INC . 'wprss-ftp-extractor.php' );
    require_once ( WPRSS_FTP_INC . 'wprss-ftp-custom-conversions.php' );
    require_once ( WPRSS_FTP_INC . 'wprss-ftp-debug.php' );
    require_once ( WPRSS_FTP_INC . 'wprss-ftp-url-shortener.php' );
    require_once ( WPRSS_FTP_INC . 'wprss-ftp-legacy.php' );
    require_once ( WPRSS_FTP_INC . 'wprss-ftp-taxonomies.php' );
    require_once ( WPRSS_FTP_INC . 'wprss-ftp-help.php' );
    require_once ( WPRSS_FTP_INC . 'wprss-ftp-edit-flow.php' );
    require_once ( WPRSS_FTP_INC . 'wprss-ftp-admin-user-ajax.php' );
    require_once ( WPRSS_FTP_INC . 'wprss-ftp-feed-assistant.php' );
    require_once ( WPRSS_FTP_INC . 'wprss-ftp-logger.php' );

    // Load text domain
	load_plugin_textdomain('wprss', false, dirname(plugin_basename(__FILE__)) . '/languages/');

	// Begin "execution"
    WPRSS_FTP::get_instance();
    wprss_feedtopost_addon();

    if (get_transient('wprss_f2p_activated') === '1') {
        delete_transient('wprss_f2p_activated');

	    // Add the database version setting.
	    update_option( 'wprss_ftp_db_version', WPRSS_FTP_DB_VERSION );

	    WPRSS_FTP_Meta::multisite_fix();

	    // Close append/prepend metaboxes for user
	    WPRSS_FTP_Utils::close_ftp_metabox_for_user_by_default( get_current_user_id(), 'wprss-ftp-prepend-metabox' );
	    WPRSS_FTP_Utils::close_ftp_metabox_for_user_by_default( get_current_user_id(), 'wprss-ftp-append-metabox' );
	    WPRSS_FTP_Utils::close_ftp_metabox_for_user_by_default( get_current_user_id(), 'wprss-ftp-extraction-metabox' );
	    WPRSS_FTP_Utils::close_ftp_metabox_for_user_by_default( get_current_user_id(), 'wprss-ftp-custom-fields-metabox' );
    }
});

add_action('wpra_after_run', function ($c = null) {
    if ($c instanceof ContainerInterface) {
        // Removes the handler from Core 4.14 that removes the WordPress featured image meta box
        // Feed to Post needs this meta box until is image importing it completely delegated to core.
        remove_action('add_meta_boxes', $c->get('wpra/images/ft_image/meta_box/handler'));
    }
});

register_activation_hook(__FILE__, 'wprss_f2p_on_activation');
/**
 * Runs when the plugin is activated. Checks WP version, and prepares the DB
 *
 * @since 1.0
 */
function wprss_f2p_on_activation() {
	/* Prevents activation of plugin if compatible version of WordPress not found */
	if ( version_compare( get_bloginfo( 'version' ),  WPRSS_FTP::WP_MIN_VERSION, '<' ) ) {
		require_once(ABSPATH . 'wp-admin/includes/plugin.php');
		deactivate_plugins(basename(__FILE__));     // Deactivate plugin
		wp_die(wprss_f2p_wp_version_message(), array('back_link' => true));
	}

	set_transient('wprss_f2p_activated', '1');
}

/**
 * Throw an error if WP RSS Aggregator is not installed.
 *
 * @since 3.9.1
 */
function wprss_f2p_missing_core_notice()
{
	printf(
		'<div class="notice notice-error"><p>%s</p></div>',
		sprintf(
			__(
				'The <b>WP RSS Aggregator - Feed to Post</b> add-on requires the <b>WP RSS Aggregator</b> plugin to be installed and activated, at version <b>%s</b> or later.',
				'wprss'
			),
			'<b>' . WPRSS_FTP::WPRSS_MIN_VERSION . '</b>'
		)
	);
}


/**
 * Throw an error if the WordPress version is too old.
 *
 * @since 3.9.1
 */
function wprss_f2p_wp_version_message()
{
	return sprintf(
        __(
            'The <b>WP RSS Aggregator - Feed to Post</b> add-on requires the WordPress version <b>%s</b> or later.',
            'wprss'
        ),
        '<b>' . WPRSS_FTP::WP_MIN_VERSION . '</b>'
    );
}


/**
 * The main plugin class.
 * It handles the core of the add-on, registering all basic hooks for activation and deactiviation, as
 * well as all foundation initialization.
 *
 * @since 1.0
 */
final class WPRSS_FTP {

	/**
	 * Add-on Version. Same as the defined constant.
	 */
	const VERSION = WPRSS_FTP_VERSION;

	/** This string will previous various proprietary codes by default. */
	const CODE_PREFIX = 'wprss_ftp_';

	/** This string in the beginning of prefixable codes indicates that it shoult not get prefixed. */
	const OVERRIDE_DEFAULT_PREFIX = '!';

	/**
	 * Dependency versions.
	 */
	const WP_MIN_VERSION = '4.0';
	const WPRSS_MIN_VERSION = '4.10';

	const ADMIN_INIT_JS_HANDLE = 'wprss-f2p-admin-init';

	/**
	 * Instance Singleton
	 */
	private static $instance = NULL;

	/**
	 * The settings class
	 */
	private $settings;

	/**
	 * The meta class
	 */
	private $meta;

	/**
	 * The images class
	 */
	private $images;

	/**
	 * The debug class
	 */
	private $debug;

	/**
	 * The feed assistant class
	 */
	private $assistant;

	/*==== CONSTRUCTOR ===================================================================================*/

	/**
	 * Class Constructor. Sets up the hooks and inititalizes the class.
	 *
	 * @since 1.0
	 */
	public function __construct() {
		// Initialize variables
		$this->meta = WPRSS_FTP_Meta::get_instance();
		$this->settings = WPRSS_FTP_Settings::get_instance();
		$this->images = WPRSS_FTP_Images::get_instance();
		$this->debug = WPRSS_FTP_Debug::get_instance();
		$this->assistant = WPRSS_FTP_Feed_Assistant::get_instance();

		add_action( 'init', array( $this, 'check_request' ) );

		add_filter( 'wprss_register_addon', array($this, 'register_addon') );

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts_and_styles' ) );
		add_action( 'admin_head', array( $this, 'wprss_ftp_admin_head' ) );
		add_action( 'admin_footer', array( $this, 'wprss_ftp_admin_footer' ) );

		// Adds custom post type arguments for wprss_feed
		add_filter( 'wpra/feeds/sources/cpt/args', array( $this, 'custom_post_type_args' ) );

		// Conversion hook
		add_filter( 'wprss_insert_post_item_conditionals', array( 'WPRSS_FTP_Converter', 'convert_to_post' ), 15, 3 );
		add_filter( 'wprss_still_update_import_count', '__return_true' );

		add_filter( 'wprss_feed_tags_to_strip', array( 'WPRSS_FTP_Converter', 'feed_tags_to_strip' ), 10, 2 );

		// Full Text RSS hook
		add_filter( 'wprss_feed_source_url', array( 'WPRSS_FTP_Converter', 'check_force_full_content' ), 10, 2 );

		// Add the truncation post types
		add_filter( 'wprss_truncation_post_types', array( $this, 'truncation_post_types' ) );

		// Filters that change row action texts and titles
		add_filter( 'wprss_view_feed_items_row_action_link', array( $this, 'view_feed_items_row_action_link' ), 10, 2 );
		add_filter( 'wprss_view_feed_items_row_action_text', array( $this, 'view_feed_items_row_action_text' ) );
		add_filter( 'wprss_fetch_items_row_action_text', array( $this, 'fetch_items_row_action_text' ) );
		add_filter( 'wprss_purge_feeds_row_action_text', array( $this, 'delete_posts_row_action_text' ) );
		add_filter( 'wprss_purge_feeds_row_action_title', array( $this, 'delete_posts_row_action_title' ) );

		// Filter the query that shows the feed items per source
		add_filter( 'wprss_view_feed_items_meta_query', array( $this, 'view_posts_from_source_meta_query' ), 10 , 2 );
		// Filter the query that deletes feed items per source
		add_filter( 'wprss_delete_per_source_query', array( $this, 'delete_posts_from_source_query' ), 10 , 2 );

		// Filter to change post title
		//add_filter( 'the_title', array( $this, 'link_posts_to_external'), 10 , 2 );
		add_filter( 'post_link', array( $this, 'link_posts_to_external'), 10 , 2 );
		add_filter( 'post_type_link', array( $this, 'link_posts_to_external'), 10 , 2 );

		// Override's the core's shortcode output
		add_filter( 'wprss_shortcode_output', array( $this, 'override_shortcode' ) );

		// Change the post type for the wprss_get_feed_items_for_source function
		add_filter( 'wprss_get_feed_items_for_source_args', array( $this, 'get_feed_items_for_source_args' ), 10, 2 );

		// Add columns to the Feed Sources table
		add_filter( 'wprss_set_feed_custom_columns', array( $this, 'add_wprss_feed_columns' ) );
		// Add the action to render the added columns
		add_action( 'manage_wprss_feed_posts_custom_column', array( $this, 'render_wprss_feed_columns' ), 10, 2 );

		// Action to show admin notices for activation hooks
		add_action( 'admin_init', array( $this, 'admin_notices_for_activation_hooks' ) );

		/** Allow local requests. See {@link wp_http_validate_url()} */
		add_filter( 'http_request_host_is_external', '__return_true' );

		// Adds the Feed to Post settings to the exporting mechanism in the core plugin
		add_filter( 'wprss_fields_export', array( $this, 'add_settings_to_export' ) );
		add_action( 'wprss_export_section', array( $this, 'export_section' ) );

		add_filter( 'wprss_item_import_time_limit', array( $this, 'item_import_time_limit' ) );
		add_filter( 'wprss_feed_fetch_time_limit', array( $this, 'feed_fetch_time_limit' ) );

		add_theme_support( 'post-thumbnails', array('wprss_feed') );

		do_action('wprss_ftp_init', $this);
	}


	/**
	 * Returns the Singleton instance. Or creates it if it does not exist.
	 *
	 * @since 1.0
	 */
	public static function get_instance() {
		if ( self::$instance === NULL ) {
			self::$instance = new WPRSS_FTP();
		}
		return self::$instance;
	}


	/**
	 * Returns the settings
	 *
	 * @since 1.0
	 */
	public function settings(/** $suboption, $default */) {
		$args = func_get_args();
		return call_user_func_array( array( $this->settings, 'get' ) , $args );
	}


	/**
	 * Returns the meta
	 *
	 * @since 1.0
	 */
	public function meta(/** $suboption, $default */) {
		$args = func_get_args();
		return call_user_func_array( array( $this->meta, 'get' ) , $args );
	}



	/*==== METHODS ===========================================================================================*/


	/**
	 * @param string $string The string to check.
	 * @return bool Whether or not the code passed indicates that it overrides the default code prefix.
	 * @since 3.5
	 */
	public static function is_overrides_default_prefix( $string ) {
		return strpos( $string, self::OVERRIDE_DEFAULT_PREFIX ) === 0;
	}


	/**
	 * Get the class code prefix, or the specified string prefixed with it.
	 *
	 * @param string $string A string to prefix.
	 * @return string The code prefix or the prefixed string.
	 * @since 3.5
	 */
	public static function get_code_prefix( $string = '' ) {
		return self::CODE_PREFIX . (string)$string;
	}

	/**
	 * Optionally prefix a string with the class code prefix, unless it
	 * contains the "!" character in the very beginning, in which case it will
	 * simply be removed.
	 *
	 * @param string $string The string to consider for prefixing.
	 * @return string The prefixed or clean string.
	 * @since 3.5
	 */
	public static function prefix( $string ) {
		return self::is_overrides_default_prefix( $string )
				? substr( $string, 1 )
				: self::get_code_prefix( $string );
	}


	/**
	 * Registers the Feed to Post add-on in the core.
	 *
	 * @since 3.0
	 * @param array $addons The registered add-ons
	 * @return array The registered add-ons, now also including Feed to Post
	 */
	public function register_addon( $addons ) {
		$addons['ftp'] = 'Feed to Post';
		return $addons;
	}


	/**
	 * Overrides the core's shortcode output
	 *
	 * @since 1.8
	 */
	public function override_shortcode( $output ) {
		if ( version_compare( WPRSS_VERSION, '4.13', '>=' ) )
			return $output;
		else {
			ob_start();
			if ( current_user_can( 'manage_options' ) ) :
			?>
				<p>
					<?php
					printf(
						__(
							'The Feed to Post add-on disables the shortcode functionality by default. <a href="%1$s" target="_blank">Read why here</a> and <a href="%2$s" target="_blank">how to re-enable it here.</a>',
							WPRSS_TEXT_DOMAIN
						),
						'http://www.wprssaggregator.com/docs/add-compatibility',
						'http://www.wprssaggregator.com/docs/using-the-shortcodes'
					);
					?>
				</p>
			<?php
			endif;
			return ob_get_clean();
		}
	}


	/**
	 * Adds arguments to the wprss_feed custom post type
	 *
	 * @since 1.8
	 */
	public function custom_post_type_args( $args ) {
		// Make sure the 'supports' key exists in the args
		if ( !array_key_exists( 'supports', $args ) ) {
			$args['supports'] = array();
		}
		// If the thumbnail support is not in the supports array, add it
		if ( !in_array( 'thumbnail', $args['supports'] ) ) {
			$args['supports'][] = 'thumbnail';
		}
		// Return the args
		return $args;
	}

	/**
	 * Checks for the transient that indicates the need to show admin notices, and shows the notices accordingly.
	 *
	 * @since 2.4
	 */
	public function admin_notices_for_activation_hooks() {
		$transient = get_transient( 'wprss_ftp_admin_notices' );
		if ( $transient !== FALSE ) {
			add_action( 'all_admin_notices', $transient );
			delete_transient( 'wprss_ftp_admin_notices' );
		}
	}


	/**
	 * Returns a list of GET requests, and the actions that are to be executed when recieved.
	 *
	 * @since 1.3
	 */
	public function get_request_actions() {
		return apply_filters(
			'wprss_ftp_request_actions',
			array(
				// request => callback
			)
		);
	}


	/**
	 * Checks the GET data for the presence of a know request, and executes its matching action.
	 *
	 * @since 1.3
	 */
	public function check_request() {
		$actions = $this->get_request_actions();
		foreach ( $actions as $key => $callback ) {
			if ( isset( $_GET[$key] ) ) {
				$param = $_GET[$key];
				call_user_func_array( $callback, array( $param ) );
			}
		}
	}

	/**
	 * Shows a message that notifies the user that the posts for a particular source are being deleted in the background.
	 *
	 * @since 1.0
	 */
	public function notify_about_deleting_source_posts(){
		?>
		<div class="updated">
			<p>
				<?php echo self::wprss_ftp_deleting_source_posts_msg(); ?>
			</p>
		</div>
		<?php
	}


	/**
	 * Enqueues scripts and styles
	 *
	 * @since 1.0
	 */
	public function enqueue_scripts_and_styles() {
		$screen = get_current_screen();
		do_action( 'wprss_ftp_enqueue_scripts_before' );

		do_action( 'wprss_ftp_enqueue_admin_init_js_before' );
		$script = apply_filters( 'wprss_ftp_enqueue_admin_init_js', WPRSS_FTP_JS . 'wprss-f2p-admin-init.js' );
		$deps = array( 'jquery' );
		if( defined( 'WPRSS_ADMIN_INIT_JS_HANDLE' ) ) $deps[] = WPRSS_ADMIN_INIT_JS_HANDLE;
		$deps = apply_filters( 'wprss_ftp_enqueue_admin_init_js_deps', $deps );
		wp_enqueue_script( self::ADMIN_INIT_JS_HANDLE, $script, $deps );

		do_action( 'wprss_ftp_enqueue_admin_init_js_after' );

		wp_register_style( 'wprss_ftp_admin_styles', WPRSS_FTP_CSS . 'admin-styles.css' );
		wp_enqueue_style( 'wprss_ftp_admin_styles', WPRSS_FTP_CSS . 'admin-styles.css' );

		// If a WP RSS Agg page
		if ( $screen->post_type === 'wprss_feed' ) {
			do_action( 'wprss_ftp_enqueue_wprss_feed_scripts_before' );

			wp_enqueue_script( 'wprss_ftp_admin_scripts', WPRSS_FTP_JS . 'admin-scripts.js', array( self::ADMIN_INIT_JS_HANDLE ) );
			wp_localize_script( 'wprss_ftp_admin_scripts', 'wprss_ftp_admin_scripts', array(
				'loading_taxonomies' 		=> __('Loading taxonomies...', WPRSS_TEXT_DOMAIN),
				'feed_post_type_warning'	=> __('You are importing into WP RSS Aggregator\'s <strong>Feed Items</strong>.<br/>Some Feed to Post settings will <strong>not</strong> affect the items imported.', WPRSS_TEXT_DOMAIN)
			) );

			wp_register_script( 'wprss-ftp-jquery-chosen', WPRSS_FTP_JS . 'jquery-chosen/chosen.jquery.min.js', array('jquery') );
			wp_register_script( 'wprss-ftp-taxonomy-js', WPRSS_FTP_JS . 'admin-taxonomies.js', array('jquery', 'wprss-ftp-jquery-chosen') );
			wp_localize_script( 'wprss-ftp-taxonomy-js', 'wprss_ftp_taxonomy_js', array(
				'please_wait'		=> __('Please Wait...', WPRSS_TEXT_DOMAIN),
				'choose_terms'		=> __('Choose terms', WPRSS_TEXT_DOMAIN),
				'choose_tax'		=> __('Choose a taxonomy', WPRSS_TEXT_DOMAIN),
				'choose_field'		=> __('Choose a field to filter on', WPRSS_TEXT_DOMAIN),
				'no_matched_terms'	=> __('No terms matched ', WPRSS_TEXT_DOMAIN),
				'no_matched_tax'	=> __('No taxonomy matched ', WPRSS_TEXT_DOMAIN),
				'no_matched_field'	=> __('No fields matched ', WPRSS_TEXT_DOMAIN)


			) );

			// If in an edit page
			if ( $screen->base === 'post' || $screen->base === 'edit' ) {
				do_action( 'wprss_ftp_enqueue_edit_scripts_before' );
				wp_enqueue_script( 'wprss_ftp_extraction_rules_scripts', WPRSS_FTP_JS . 'post-appender.js', array('jquery-ui-tabs') );
				wp_enqueue_script( 'wprss_ftp_custom_mappings_scripts', WPRSS_FTP_JS . 'custom-mappings.js', array('jquery') );
				wp_localize_script( 'wprss_ftp_custom_mappings_scripts', 'wprss_ftp_custom_mappings_scripts', array(
					'please_wait'			=> __('Please Wait...', WPRSS_TEXT_DOMAIN),
					'namespace'				=> __('Namespace', WPRSS_TEXT_DOMAIN),
					'with_url'				=> __('with URL', WPRSS_TEXT_DOMAIN),
					'specify_feed_url'		=> __('Please specify a feed source URL first.', WPRSS_TEXT_DOMAIN),

				) );
				wp_enqueue_script( 'wprss_ftp_appender_scripts', WPRSS_FTP_JS . 'extraction-rules.js' );
				wp_enqueue_script( 'wprss-ftp-taxonomy-js' );
				wp_enqueue_style( 'wprss-ftp-jquery-chosen-style', WPRSS_FTP_JS . 'jquery-chosen/chosen.min.css' );
				do_action( 'wprss_ftp_enqueue_edit_scripts_after' );
			}

			// If the settings page
			if ( $screen->id === 'wprss_feed_page_wprss-aggregator-settings' ) {
				do_action('wprss_ftp_enqueue_settings_scripts_before');
				wp_enqueue_script( 'wprss-ftp-taxonomy-js' );
				wp_enqueue_style( 'wprss-ftp-jquery-chosen-style', WPRSS_FTP_JS . 'jquery-chosen/chosen.min.css' );
				wp_enqueue_script( 'wprss_ftp_settings_scripts', WPRSS_FTP_JS . 'admin-settings.js', array('jquery-ui-core', 'jquery-ui-sortable') );

				wp_localize_script( 'wprss_ftp_settings_scripts', 'wprss_ftp_settings_scripts', array(
					'name'	=> __('Name', WPRSS_TEXT_DOMAIN),
					'url'	=> __('URL', WPRSS_TEXT_DOMAIN)
				) );
				do_action( 'wprss_ftp_enqueue_settings_scripts_after' );
			}

			do_action( 'wprss_ftp_enqueue_wprss_feed_scripts_after' );
		}

		do_action( 'wprss_ftp_enqueue_scripts_after' );
	}


	public function wprss_ftp_admin_head() {
		do_action( 'wprss_admin_head_before' );
		ob_start();
		// Put below HTML that is to appear in the head, after enqueued scripts
		?>

		<?php
		do_action( 'wprss_admin_head_after' );
		$admin_head = ob_get_clean();
		echo apply_filters( 'wprss_admin_head', $admin_head );
	}


	public function wprss_ftp_admin_footer() {
		do_action( 'wprss_admin_footer_before' );
		ob_start();
		// Put below HTML that is to appear in the footer
		?>

		<?php
		do_action( 'wprss_admin_footer_after' );
		$admin_footer = ob_get_clean();
		echo apply_filters( 'wprss_admin_footer', $admin_footer );
	}


	/**
	 * Trashes all imported feed items
	 *
	 * @since 1.0
	 */
	public function remove_imported_feed_items() {
		// Get all feed items
		$args = array(
			'post_type'			=>	'wprss_feed_item',
			'posts_per_page'	=>	-1
		);
		$feed_items = get_posts( $args );
		foreach( $feed_items as $item ) {
			// Delete each feed item
			wp_delete_post( $item->ID, true );
		}
	}


	/**
	 * Adds the truncation post types
	 *
	 * @since 1.0
	 */
	public function truncation_post_types( $in ) {
		$feed_sources = get_posts( array( 'post_type' => 'wprss_feed' ) );
		$post_types = array();
		foreach ( $feed_sources as $source ) {
			$options = $this->settings->get_computed_options( $source->ID );
			$post_type = $options['post_type'];
			if ( ! in_array( $post_type, $post_types ) )
				$post_types[] = $post_type;
		}
		return array_merge( $in, $post_types );
	}


	/**
	 * Removes the post_type argument from the get_feed_items_for_source()
	 * function in the core.
	 *
	 * @since 1.0
	 */
	public function get_feed_items_for_source_args( $args, $source_id ) {
		if ( wprss_ftp_using_feed_items( $source_id ) ) return $args;
		// Get the Meta class instance
		$meta = WPRSS_FTP_Meta::get_instance();
		// Get the post type
		$post_type = $meta->get_meta( $source_id, 'post_type' );
		$post_status = $meta->get_meta( $source_id, 'post_status' );
		// Adjust the args
		$args['post_type'] = $post_type;
		$args['post_status'] = $post_status;
		$args['order_by'] = 'date';
		// Remove the old query key
		unset( $args['meta_key'] );
		// Modify the meta query key
		$args['meta_query'][0]['key'] = 'wprss_ftp_feed_source';
		$args['meta_query'][0]['compare'] = '=';
		return $args;
	}


	/**
	 * Adds custom columns to the feed sources table
	 *
	 * @since 2.5
	 */
	public function add_wprss_feed_columns( $columns ) {
		$columns['post-type'] = __( "Post Type", WPRSS_TEXT_DOMAIN );
		return $columns;
	}


	/**
	 * Renders the custom wprss feed columns added by the add-on.
	 *
	 * @since 2.5
	 */
	public function render_wprss_feed_columns( $column, $post_id ) {
		switch ( $column ) {
			case 'post-type':
				$settings = $this->settings->get_computed_options( $post_id );

				$post_type = $settings['post_type'];
				$post_type_obj = get_post_type_object( $post_type );

				if( $post_type_obj ) {
					$label = $post_type_obj->labels->singular_name;
					$post_type_class = array('wprss-post-type-label');
				}
				else {
					$label = $post_type;
					$post_type_class = array('wprss-post-type-name');
				}

				$status_str = '';
				if ($post_type !== 'wprss_feed_item') {
					$post_status = $settings['post_status'];
					$post_statuses = WPRSS_FTP_Settings::get_post_statuses();
					$post_status_name = $post_statuses[$post_status];
					$status_str = sprintf(' (<span class="wprss-post-status-name">%s</span>)', $post_status_name);
				}

				echo sprintf(
						'<p><span class="%1$s">%2$s</span> %3$s</p>',
						implode(' ', $post_type_class),
						$label,
						$status_str
				);

				break;
		}
	}


	/**
	* Returns an array of the default license settings. Used for plugin activation.
	*
	* @since 1.0
	*
	*/
	public function get_default_settings_licenses() {
		// Set up the default license settings
		$settings = apply_filters(
			'wprss_ftp_get_default_settings_licenses',
			array(
				'ftp_license_key' => FALSE,
				'ftp_license_status' => 'invalid'
			)
		);

		// Return the default settings
		return $settings;
	}


	/**
	 * Returns the saved license code.
	 *
	 * @since 2.9.6
	 */
	public function get_license_key() {
		$defaults = $this->get_default_settings_licenses();
		$keys = get_option( 'wprss_settings_license_keys', array() );
		$ftp_license = ( isset( $keys['ftp_license_key'] ) )? $keys['ftp_license_key'] : $defaults['ftp_license_key'];
		return $ftp_license;
	}


	/**
	 * Returns the saved license code.
	 *
	 * @since 2.9.6
	 */
	public function get_license_status_from_db() {
		$defaults = $this->get_default_settings_licenses();
		$statuses = get_option( 'wprss_settings_license_statuses', array() );
		$ftp_status = ( isset( $statuses['ftp_license_status'] ) ) ? $statuses['ftp_license_status'] : $defaults['ftp_license_status'];
		return $ftp_status;
	}


	/**
	 * Returns the license status. Also updates the status in the DB.
	 *
	 * @since 2.9.6
	 */
	public function get_license_status() {
		// Get the license key
		$license_key = $this->get_license_key();
		// Get the license status from the DB
		$license_status = $this->get_license_status_from_db();

		// data to send in our API request
		$api_params = array(
			'edd_action'	=> 'check_license',
			'license'		=> $license_key,
			'item_name'		=> urlencode( WPRSS_FTP_SL_ITEM_NAME )
		);

		// Call the custom API.
		$response = wp_remote_get( add_query_arg( $api_params, WPRSS_FTP_SL_STORE_URL ) );

		// If the response is an error, return the value in the DB
		if ( is_wp_error( $response ) ) return $license_status;

		// decode the license data
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		// Update the DB option
		$license_statuses['ftp_license_status'] = $license_data->license;
		update_option( 'wprss_settings_license_statuses', $license_statuses );

		// Return TRUE if it is 'active', FALSE otherwise
		return $license_data->license;
	}


	/**
	 * Hooks into the core and modifies the link for the view feed items per source row action
	 *
	 * @since 2.9
     * @param string $link The URL of the "View Posts" link.
     * @param int $id The ID of the post, for which the action is being rendered.
	 */
	public function view_feed_items_row_action_link( $link, $id ) {
		$options = $this->settings->get_computed_options( $id );
		$post_type = $options['post_type'];

		$params = array(
			'post_type'	    => $post_type,
			'wprss_feed'	=> $id
		);
		defined( 'ICL_SITEPRESS_VERSION' ) && ($params['lang'] = 'all');

		return admin_url( 'edit.php?' . http_build_query($params) );
	}


	/**
	 * Hooks into the core and modifies the text for the fetch feed items per source row action
	 *
	 * @since 2.9
	 */
	public function fetch_items_row_action_text( $text ) {
		return __( "Fetch Posts", WPRSS_TEXT_DOMAIN );
	}


	/**
	 * Hooks into the core and modifies the text for the view feed items per source row action
	 *
	 * @since 2.9
	 */
	public function view_feed_items_row_action_text( $text ) {
		return __( "View Posts", WPRSS_TEXT_DOMAIN );
	}


	/**
	 * Hooks into the core and modifies the text for the delete feed items per source row action
	 *
	 * @since 1.3
	 */
	public function delete_posts_row_action_text( $text ) {
		return __( 'Delete Posts', WPRSS_TEXT_DOMAIN );
	}


	/**
	 * Hooks into the core and modifies the title for the delete feed items per source row action
	 *
	 * @since 1.3
	 */
	public function delete_posts_row_action_title( $title ) {
		return __( 'Delete posts imported by this feed source', WPRSS_TEXT_DOMAIN );
	}


	/**
	 * Hooks into the core and modifies the meta key for the custom meta query
	 * when showing posts for a single feed source.
	 *
	 * @since 2.9
	 */
	public function view_posts_from_source_meta_query( $query, $source_id ) {
		if ( wprss_ftp_using_feed_items( $source_id ) ) return $query;
		$query['key'] = 'wprss_ftp_feed_source';
		return $query;
	}


	/**
	 * Deletes all posts generated by the source identified by the given source id.
	 *
	 * @param $source_id The ID of the feed source, to which the posts to be deleted belong to.
	 * @since 1.3
	 */
	public function delete_posts_from_source_query( $query, $source_id ) {
		if ( wprss_ftp_using_feed_items( $source_id ) ) return $query;
		return new WP_Query(
			array(
					'meta_key'              => 'wprss_ftp_feed_source',
					'meta_value'            => $source_id,
					'post_type'             => 'any',
					'post_status'           => 'any',
					'posts_per_page'        => -1,
                    'ignore_sticky_posts'   => true,
				)
		);
	}


	/**
	 * Adds the Feed to Post settings to the exporting mechanism in the core plugin.
	 *
	 * @since 2.9
	 */
	public function add_settings_to_export( $options ) {
		$options['wprss_settings_ftp'] = get_option( 'wprss_settings_ftp' );
		unset( $options['wprss_settings_ftp']['post_terms'] );
		return $options;
	}


	/**
	 * Adds a message on the export section of the Import & Export page
	 * that informs the user that post terms and licenses are not exported
	 *
	 * @since 2.9
	 */
	public function export_section() {
		?>
		<p>
			<?php _e( '<strong>Note:</strong> Your <em>license codes</em> and your Category <em>Post Terms</em> options for Feed to Post add-on are not exported.', WPRSS_TEXT_DOMAIN ); ?>
		</p>
		<?php
	}


	/**
	 * Changes the post title links to the original source. This is turned on through
	 * the wprss_ftp_link_post_title filter, when the value returned is TRUE.
	 *
	 * @since 1.6
     * @param string $url The URL of the post titile link.
     * @param WP_Post $post The instance of the post, for which the title link URL is filtered.
     * @returl string The eventual title link URL.
	 */
	public function link_posts_to_external( $url, $post ) {
		// If the id parameter was not passed, do nothing and return the title.
		if ( $url === NULL || $post === NULL ) return $url;

        $postId = $post->ID;
		// Get the feed source for the post
		$source = WPRSS_FTP_Meta::get_instance()->get_meta( $postId, 'feed_source' );


		// IF AN IMPORTED POST
		if ( $source !== '' && !is_single() ) {
			// Check whether the title is to be linked to the external, original post
			$filter_value = apply_filters( 'wprss_ftp_link_post_title', FALSE );
			// Get the permalink meta data for the post
			$permalink = get_post_meta( $postId, 'wprss_item_permalink', TRUE );

			// If the permalink is empty, return the regular WordPress post url
			if ( $permalink === '' ) return $url;

			// If the filter value is an array, check if the source ID is in the array
			if ( is_array( $filter_value ) ) {
				$link_external = in_array( $source , $filter_value );
			}
			// If the filter value is not an array, check if it is TRUE or if it is the ID of the source
			else {
				$link_external = ( $filter_value === TRUE || strval($filter_value) === strval($source) );
			}

			// If link_external is TRUE, return the permalink of the original article.
			// Otherwise, return the regular WordPress post url
			return ( ( $link_external === TRUE )? $permalink : $url );
		}
		else {
			return $url;
		}
	}


	/**
	 * Sets the time limit for each item import to 1 minute to cater for the time taken
	 * to retrieve potential responses from APIs such as WordAi and full text RSS.
	 *
	 * @since 3.2.4
	 */
	public function item_import_time_limit( $time ) {
		return 60;
	}

	/**
	 * Sets the time limit for a feed fetch operation to 1 minute to cater for extra
	 * time that might be required to fetch larger feeds due to full text.
	 *
	 * @since 3.2.4
	 */
	public function feed_fetch_time_limit( $time ) {
		return 60;
	}


	/**
	 * Returns the message that notifies the user that posts are being deleted in the background.
	 *
	 * @since 3.0
	 * @return string
	 */
	public static function wprss_ftp_deleting_source_posts_msg() {
		return __( 'The posts for the selected feed source are being deleted in the background.', WPRSS_TEXT_DOMAIN );
	}


	/**
	 * Returns whether or not a URL is allowed.
	 *
	 * @since 2.8.6
	 * @deprecated 3.0
	 * @param bool $is_allowed Whether or not the request is originally allowed
	 * @param string $host This server's host name
	 * @param string $url URL of the request
	 */
	public static function is_allow_local_requests( $is_allowed, $host, $url ) {
		$allow_local_requests = WPRSS_FTP_Settings::get_instance()->get( 'allow_local_requests' );
		if ( true === $allow_local_requests || WPRSS_FTP_Utils::multiboolean( $allow_local_requests ) ) {
			return true;
		}

		return $is_allowed;
	}


	/**
	 * Runs all handlers associated with an event code.
	 *
	 * This is a wrapper for WP `add_action()`, but with some very helpful differences.
	 *
	 * - Automatic prefixing of event code by prepending a special string (typically "!");
	 * - Overriding of almost every parameter of the event before it happens via the 'wprss_ftp_do_action_before' hook;
	 * - Uniform handler arguments.
	 *
	 * The handler of all hooks, including 'wprss_ftp_do_action_before', 'wprss_ftp_do_action'
	 * and 'wprss_ftp_do_action_after', will always receive one argument, which
	 * will be an object with the following public properties:
	 *
	 * - 'orig_action' - The original event code, as specified when calling this method. Guaranteed to be present and the same all the time;
	 * - 'action' - The eventual event code, after prefixing and filtering. This may change multiple times.
	 * - 'args' - Unless changed in filters, guaranteed to be an array (possibly empty) of arguments.
	 *
	 * It is possible to change main event parameters in the 'wprss_ftp_do_action_before' and
	 * 'wprss_ftp_do_action' event handlers. In both cases, it is possible via
	 * directly modifying properties of the event object; however in the second case modifying
	 * the 'action' property will have no effect: the changed value must be instead
	 * returned from the handler.
	 *
	 * This completely eliminates the need for 2 previously necessary factors:
	 *
	 * - Specifying the number of arguments for handlers. All handlers receive 1 argument containing all data.
	 * - Creation of separate filters to modify a value. All action handlers can modify any value.
	 *
	 * The returned object will contain eventual values in it's 'args' property.
	 *
	 * @param string $action The code of the action to run. Must evaluate to a non-empty string.
	 * @param array|null $args A value or array of values to pass to the hook. `null` indicates empty array.
	 * @return object An object containing event arguments.
	 * @since 3.5
	 */
	public static function do_action( $action, $args = null ) {
		$args = (array) $args;
		$orig_action = $action;
		$event_args = (object) array( 'orig_action' => $orig_action, 'action' => self::prefix( $action ), 'args' => $args );
		do_action( self::prefix( 'do_action_before' ), $event_args );

		// Revert original action in case it changed
		$event_args->orig_action = $orig_action;

		// A filter, for consistency
		$event_args->action = apply_filters( self::prefix( 'do_action' ), $event_args->action, $event_args );

		// Revert original action in case it changed
		$event_args->orig_action = $orig_action;

		$event_args->is_performed = !empty( $event_args->action );
		if ( $event_args->is_performed )
			do_action( $event_args->action, $event_args );

		// Revert original action in case it changed
		$event_args->orig_action = $orig_action;

		do_action( self::prefix( 'do_action_after' ), clone $event_args );
		return $event_args;

	}


	/**
	 *
	 * @param string $action
	 * @param callable $callback
	 * @param int $priority
	 * @return object An object containing parameters of the action.
	 * @since 3.5
	 */
	public static function add_action( $action, $callback, $priority = 10 ) {
		$orig_action = $action;
		$event_args = (object) array( 'orig_action' => $orig_action, 'action' => self::prefix( $action ), 'callback' => $callback, 'priority' => $priority );
		do_action( self::prefix( 'add_action_before' ), $event_args );

		// Revert original action in case it changed
		$event_args->orig_action = $orig_action;

		// A filter, for consistency
		$event_args->action = apply_filters( self::prefix( 'add_action' ), $event_args->action, $event_args );

		// Revert original action in case it changed
		$event_args->orig_action = $orig_action;

		$event_args->is_added = !empty( $event_args->action );
		if ( $event_args->is_added )
			$event_args->is_added = add_action( $event_args->action, $event_args->callback, $event_args->priority, 1 );

		// Revert original action in case it changed
		$event_args->orig_action = $orig_action;

		do_action( self::prefix( 'add_action_after' ), clone $event_args );
		return $event_args;
	}

    /**
     * Retrieve the notices collection.
     *
     * @since 3.7
     * @return WPRSS_Admin_Notices
     */
    public function getNotices()
    {
        return wprss_admin_notice_get_collection();
    }

    /**
     * Whether or not currently on a WPRA admin page.
     *
     * @since 3.7
     * @return bool True if on a WPRA page; otherwise false.
     */
    public function isAdminWpraPage()
    {
        return wprss_is_wprss_page()
            || (!empty($_GET['post_type']) && ($_GET['post_type'] == 'wprss_feed' || $_GET['post_type'] == 'wprss_feed_item'));
    }
}

/**
 * Returns the Feed to Post add-on singleton instance.
 *
 * @return Addon
 *
 * @throws Exception
 */
function wprss_feedtopost_addon()
{
	static $addon = null;

	// One time initialization
	if (is_null($addon)) {
		$addon = Factory::create(array(
			'basename' => __FILE__,
			'name' => WPRSS_FTP_SL_ITEM_NAME,
		));
	}

	return $addon;
}
