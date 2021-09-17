<?php
/*
Plugin Name: Custom Twitter Feeds Pro Personal
Plugin URI: http://smashballoon.com/custom-twitter-feeds
Description: Customizable Twitter feeds for your website
Version: 1.14
Author: Smash Balloon
Author URI: http://smashballoon.com/
Text Domain: custom-twitter-feeds
*/
/*
Copyright 2021 Smash Balloon LLC (email: hey@smashballoon.com)
This program is paid software; you may not redistribute it under any
circumstances without the expressed written consent of the plugin author.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

if ( ! defined( 'CTF_URL' ) ) {
    //Update info
    define( 'CTF_PRODUCT_NAME', 'Custom Twitter Feeds Personal' );
    define( 'CTF_PRODUCT_ID', '177805' ); //177805, 188603, 188605
    define( 'CTF_VERSION', '1.14' );
	define( 'CTF_DBVERSION', '1.3' );

	//
    define( 'CTF_URL', plugin_dir_path( __FILE__ )  );
    define( 'CTF_JS_URL', plugins_url( '/js/ctf-scripts-1-10.min.js?ver=' . CTF_VERSION , __FILE__ ) );
    define( 'OAUTH_PROCESSOR_URL', 'https://api.smashballoon.com/twitter-login.php?return_uri=' );
    define( 'CTF_STORE_URL', 'https://smashballoon.com/' );
	define( 'CTF_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
	define( 'CTF_TC_LIMIT', 225 );

}
// Plugin Folder Path.
if ( ! defined( 'CTF_PLUGIN_DIR' ) ) {
	define( 'CTF_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}
if ( ! defined( 'CTF_UPLOADS_NAME' ) ) {
	define( 'CTF_UPLOADS_NAME', 'sb-twitter-feed-images' );
}
// Name of the database table that contains instagram posts
if ( ! defined( 'CTF_POSTS_TABLE' ) ) {
	define( 'CTF_POSTS_TABLE', 'ctf_posts' );
}
// Name of the database table that contains feed ids and the ids of posts
if ( ! defined( 'CTF_FEEDS_POSTS_TABLE' ) ) {
	define( 'CTF_FEEDS_POSTS_TABLE', 'ctf_feeds_posts' );
}
if ( ! defined( 'CTF_FEED_LOCATOR' ) ) {
	define( 'CTF_FEED_LOCATOR', 'ctf_feed_locator' );
}
if ( ! defined( 'CTF_MAX_RECORDS' ) ) {
	define( 'CTF_MAX_RECORDS', 300 );
}
if ( ! defined( 'CTF_MINIMUM_WALL_VERSION' ) ) {
	define( 'CTF_MINIMUM_WALL_VERSION', '1.0' );
}

if ( function_exists('ctf_init') ){
    wp_die( "Please deactivate the free version of the Custom Twitter Feeds plugin before activating this version.<br /><br />Back to the WordPress <a href='".get_admin_url(null, 'plugins.php')."'>Plugins page</a>." );
} else {
    include CTF_URL .'/inc/ctf-pro-functions.php';
}

function ctf_activate( $network_wide ) {
    $existing_deprecated_options = get_option( 'ctf_configure' );
    $existing_pro_options = get_option( 'ctf_options' );

    if ( ! empty( $existing_deprecated_options ) && empty( $existing_pro_options ) ) {
        $merged_options = $existing_deprecated_options;
        $merged_options = array_merge( $merged_options, get_option( 'ctf_customize', array() ) );
        $merged_options = array_merge( $merged_options, get_option( 'ctf_style', array() ) );

        update_option( 'ctf_options', $merged_options );
    }

	set_transient( '_ctf_activation_redirect', true, 30 );

	if ( ! wp_next_scheduled( 'ctf_notification_update' ) ) {
		$timestamp = strtotime( 'next monday' );
		$timestamp = $timestamp + (3600 * 24 * 7);
		$six_am_local = $timestamp + ctf_get_utc_offset() + (6*60*60);

		wp_schedule_event( $six_am_local, 'ctfweekly', 'ctf_notification_update' );
	}

	if ( is_multisite() && $network_wide && function_exists( 'get_sites' ) && class_exists( 'WP_Site_Query' ) ) {

		// Get all blogs in the network and activate plugin on each one
		$sites = get_sites();
		foreach ( $sites as $site ) {
			switch_to_blog( $site->blog_id );

			$upload     = wp_upload_dir();
			$upload_dir = $upload['basedir'];
			$upload_dir = trailingslashit( $upload_dir ) . CTF_UPLOADS_NAME;
			if ( ! file_exists( $upload_dir ) ) {
				$created = wp_mkdir_p( $upload_dir );
				if ( $created ) {
					//$sb_instagram_posts_manager->remove_error( 'upload_dir' );
				} else {
					/*$sb_instagram_posts_manager->add_error( 'upload_dir', array(
						__( 'There was an error creating the folder for storing resized images.', 'instagram-feed' ),
						$upload_dir
					) );*/
				}
			} else {
				//$sb_instagram_posts_manager->remove_error( 'upload_dir' );
			}

			ctf_create_database_table();
			restore_current_blog();
		}

	} else {
		$upload     = wp_upload_dir();
		$upload_dir = $upload['basedir'];
		$upload_dir = trailingslashit( $upload_dir ) . CTF_UPLOADS_NAME;
		if ( ! file_exists( $upload_dir ) ) {
			$created = wp_mkdir_p( $upload_dir );
			if ( $created ) {
				//$sb_instagram_posts_manager->remove_error( 'upload_dir' );
			} else {
				/*$sb_instagram_posts_manager->add_error( 'upload_dir', array(
					__( 'There was an error creating the folder for storing resized images.', 'instagram-feed' ),
					$upload_dir
				) );*/
			}
		} else {
			//$sb_instagram_posts_manager->remove_error( 'upload_dir' );
		}

		ctf_create_database_table();
	}
}
register_activation_hook( __FILE__, 'ctf_activate' );

function ctf_create_database_table() {
	global $wpdb;
	global $wp_version;

	$table_name = esc_sql( $wpdb->prefix . CTF_POSTS_TABLE );
	$feeds_posts_table_name = esc_sql( $wpdb->prefix . CTF_FEEDS_POSTS_TABLE );
	$charset_collate = '';

	if ( version_compare( $wp_version, '3.5', '>' ) ) {
		$charset_collate = $wpdb->get_charset_collate();
	}

	if ( $wpdb->get_var( "show tables like '$table_name'" ) != $table_name ) {
		$sql = "CREATE TABLE " . $table_name . " (
                id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                twitter_id VARCHAR(1000) DEFAULT '' NOT NULL,
                created_on DATETIME,
                last_requested DATE,
                time_stamp DATETIME,
                json_data LONGTEXT DEFAULT '' NOT NULL,
                media_id VARCHAR(1000) DEFAULT '' NOT NULL,
                sizes VARCHAR(1000) DEFAULT '' NOT NULL,
                aspect_ratio DECIMAL (4,2) DEFAULT 0 NOT NULL,
                images_done TINYINT(1) DEFAULT 0 NOT NULL
            ) $charset_collate;";
		$wpdb->query( $sql );
	}

	if ( $wpdb->get_var( "show tables like '$feeds_posts_table_name'" ) != $feeds_posts_table_name ) {
		$sql = "CREATE TABLE " . $feeds_posts_table_name . " (
				record_id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                id INT(11) UNSIGNED NOT NULL,
                feed_id VARCHAR(1000) DEFAULT '' NOT NULL,
                INDEX feed_id (feed_id(100))
            ) $charset_collate;";
		$wpdb->query( $sql );
	}

	return $wpdb->get_var( "show tables like '$table_name'" ) === $table_name;
}

//Plugin update script
if( !class_exists( 'EDD_SL_Plugin_Updater' ) ) {
    include( CTF_URL . '/inc/EDD_SL_Plugin_Updater.php' );
}
function sb_ctf_plugin_updater() {
    // Retrieve license key from the DB
    $ctf_license_key = trim( get_option( 'ctf_license_key' ) );

    // Setup the updater
    $edd_updater = new EDD_SL_Plugin_Updater( CTF_STORE_URL, __FILE__, array( 
            'version'   => CTF_VERSION,  // current version number
            'license'   => $ctf_license_key,  // license key
            'item_name' => CTF_PRODUCT_NAME,  // name of this plugin
            'author'    => 'Smash Balloon'  // author of this plugin
        )
    );
}
add_action( 'admin_init', 'sb_ctf_plugin_updater', 0 );

/**
 * Loads the javascript for the plugin front-end. Also localizes the admin-ajax file location for use in ajax calls
 */
function ctf_scripts_and_styles_pro( $enqueue = false ) {
    wp_enqueue_style( 'ctf_styles', plugins_url( '/css/ctf-styles.min.css', __FILE__ ), array(), CTF_VERSION );
	$ctf_options = get_option( 'ctf_options', array() );

	if ( isset( $ctf_options['headenqueue'] ) && $ctf_options['headenqueue'] ) {
		wp_enqueue_script( 'ctf_scripts', plugins_url( '/js/ctf-scripts-1-10.min.js', __FILE__ ), array( 'jquery' ), CTF_VERSION, false );
	} else {
		wp_register_script( 'ctf_scripts', plugins_url( '/js/ctf-scripts-1-10.min.js', __FILE__ ), array( 'jquery' ), CTF_VERSION, true );
	}
	wp_localize_script( 'ctf_scripts', 'ctfOptions', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'font_method' => 'svg',
			'placeholder' => trailingslashit( CTF_PLUGIN_URL ) . 'img/placeholder.png',
			'resized_url' => ctf_get_resized_uploads_url(),
		)
	);

	if ( $enqueue ) {
		wp_enqueue_style( 'ctf_styles' );
		wp_enqueue_script( 'ctf_scripts' );
	}

}
add_action( 'wp_enqueue_scripts', 'ctf_scripts_and_styles_pro' );

function ctf_get_resized_uploads_url() {
	$upload = wp_upload_dir();

	$base_url = $upload['baseurl'];
	$home_url = home_url();

	if ( strpos( $home_url, 'https:' ) !== false ) {
		$base_url = str_replace( 'http:', 'https:', $base_url );
	}

	$resize_url = apply_filters( 'ctf_resize_url', trailingslashit( $base_url ) . trailingslashit( CTF_UPLOADS_NAME ) );

	return $resize_url;
}

if ( ! function_exists( 'sb_remove_style_version' ) ) {
	function sb_remove_style_version( $src, $handle ){

		if ( $handle === 'sb-font-awesome' ) {
			$parts = explode( '?ver', $src );
			return $parts[0];
		} else {
			return $src;
		}

	}
	add_filter( 'style_loader_src', 'sb_remove_style_version', 15, 2 );
}

if ( ! function_exists( 'sb_remove_script_version' ) ) {
	function sb_remove_script_version( $src, $handle ){

		if ( $handle === 'sb-font-awesome-scripts' ) {
			$parts = explode( '?ver', $src );
			return $parts[0];
		} else {
			return $src;
		}

	}
	add_filter( 'script_loader_src', 'sb_remove_script_version', 15, 2 );
}

/**
 * Some CSS and JS needed in the admin area as well
 */
function ctf_admin_scripts_and_styles_pro() {
    wp_enqueue_style( 'ctf_admin_styles', plugins_url( '/css/ctf-admin-styles.css', __FILE__ ), array(), CTF_VERSION );
	wp_enqueue_style( 'sb-font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
	wp_enqueue_script( 'ctf_admin_scripts', plugins_url( '/js/ctf-admin-scripts.js', __FILE__ ) , array( 'jquery' ), CTF_VERSION, false );
    wp_localize_script( 'ctf_admin_scripts', 'ctf', array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'sb_nonce' => wp_create_nonce( 'ctf-smash-balloon' )
        )
    );
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'wp-color-picker' );
}
add_action( 'admin_enqueue_scripts', 'ctf_admin_scripts_and_styles_pro' );

// Add a Settings link to the plugin on the Plugins page
$ctf_plugin_file = 'custom-twitter-feeds-pro/custom-twitter-feed.php';
add_filter( "plugin_action_links_{$ctf_plugin_file}", 'ctf_add_settings_link_pro', 10, 2 );
function ctf_add_settings_link_pro( $links, $file ) {
    $ctf_settings_link = '<a href="' . admin_url( 'admin.php?page=custom-twitter-feeds' ) . '">' . __( 'Settings', 'custom-twitter-feeds' ) . '</a>';
    array_unshift( $links, $ctf_settings_link );
    return $links;
}

function ctf_text_domain() {
	load_plugin_textdomain( 'custom-twitter-feeds', false, basename( dirname(__FILE__) ) . '/languages' );
}

add_action( 'plugins_loaded', 'ctf_text_domain' );