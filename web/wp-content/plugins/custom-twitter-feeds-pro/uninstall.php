<?php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit();
}

//If the user is preserving the settings then don't delete them
$options = get_option( 'ctf_options' );
$ctf_preserve_settings = isset( $options['preserve_settings'] ) ? $options['preserve_settings'] : false;

// allow the user to preserve their settings in case they are upgrading
if ( ! $ctf_preserve_settings ) {
    // clean up options from the database
    delete_option( 'ctf_options' );
	delete_option( 'ctf_configure' );
	delete_option( 'ctf_customize' );
	delete_option( 'ctf_style' );
	delete_option( 'ctf_twitter_cards' );
	delete_option( 'ctf_statuses' );

	delete_option( 'ctf_rating_notice' );
	delete_option( 'ctf_notifications' );
	delete_option( 'ctf_local_avatars' );

	// delete tweet cache in transients
    global $wpdb;
    $table_name = $wpdb->prefix . "options";
    $wpdb->query( "
        DELETE
        FROM $table_name
        WHERE `option_name` LIKE ('%\_transient\_ctf\_%')
        " );
    $wpdb->query( "
        DELETE
        FROM $table_name
        WHERE `option_name` LIKE ('%\_transient\_timeout\_ctf\_%')
        " );

	//Delete all persistent caches (start with ctf_!)
	global $wpdb;
	$table_name = $wpdb->prefix . "options";
	$result = $wpdb->query("
        DELETE
        FROM $table_name
        WHERE `option_name` LIKE ('%ctf\_\!%')
        ");
	delete_option( 'ctf_cache_list' );

    // remove any scheduled cron jobs
    wp_clear_scheduled_hook( 'ctf_cron_job' );

	delete_option( 'ctf_usage_tracking_config' );
	delete_option( 'ctf_usage_tracking' );

	wp_clear_scheduled_hook( 'ctf_usage_tracking_cron' );
	wp_clear_scheduled_hook( 'ctf_feed_update' );

	delete_option( 'ctf_db_version' );
	delete_option( 'ctf_ver' );
	delete_option( 'ctf_welcome_seen' );
	delete_option( 'ctf_rating_notice' );
	delete_option( 'ctf_notifications' );
	delete_option( 'ctf_newuser_notifications' );
	delete_option( 'ctf_statuses' );
	delete_option( 'ctf_cron_report' );
	delete_option( 'ctf_legacy_feed_settings' );
	delete_option( 'ctf_check_license_api_when_expires' );
	delete_option( 'ctf_license_last_check_timestamp' );
	delete_option( 'ctf_license_data' );
	delete_option( 'ctf_license_key' );
	delete_option( 'ctf_license_status' );


	$upload = wp_upload_dir();

	global $wpdb;

	$posts_table_name = $wpdb->prefix . 'ctf_posts';
	$feeds_posts_table_name = $wpdb->prefix . 'ctf_feeds_posts';

	$image_files = glob( trailingslashit( $upload['basedir'] ) . trailingslashit( 'sb-twitter-feed-images' ) . '*'  ); // get all file names
	foreach ( $image_files as $file ) { // iterate files
		if ( is_file( $file ) ) {
			unlink( $file );
		}
	}

	//Delete tables
	$wpdb->query( "DROP TABLE IF EXISTS $posts_table_name" );
	$wpdb->query( "DROP TABLE IF EXISTS $feeds_posts_table_name" );

	$locator_table_name = $wpdb->prefix . 'ctf_feed_locator';
	$wpdb->query( "DROP TABLE IF EXISTS $locator_table_name" );

	global $wp_filesystem;

	$wp_filesystem->delete( trailingslashit( $upload['basedir'] ) . trailingslashit( 'sb-twitter-feed-images' ) , true );


	$feed_caches_table_name = $wpdb->prefix . 'ctf_feed_caches';
	$wpdb->query( "DROP TABLE IF EXISTS $feed_caches_table_name" );

	$feeds_table_name = $wpdb->prefix . 'ctf_feeds';
	$wpdb->query( "DROP TABLE IF EXISTS $feeds_table_name" );
}

