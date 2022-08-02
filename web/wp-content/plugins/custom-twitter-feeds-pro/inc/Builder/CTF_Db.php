<?php
/**
 * Twitter Feed Database
 *
 * @since 2.0
 */

namespace TwitterFeed\Builder;

class CTF_Db {

	const RESULTS_PER_PAGE = 20;

	const RESULTS_PER_CRON_UPDATE = 6;


	/**
	 * Query the to get feeds list for Elementor
	 *
	 * @return array|bool
	 *
	 * @since 2.0
	 */
	public static function elementor_feeds_query() {
		global $wpdb;
		$feeds_elementor = [];
		$feeds_table_name = $wpdb->prefix . 'ctf_feeds';
		$feeds_list = $wpdb->get_results( "
			SELECT id, feed_name FROM $feeds_table_name;
			"
		);
		if ( ! empty( $feeds_list ) ) {
			foreach($feeds_list as $feed) {
				$feeds_elementor[$feed->id] =  $feed->feed_name;
			}
		}
		return $feeds_elementor;
	}


	/**
	 * Count the ctf_feeds table
	 *
	 * @param array $args
	 *
	 * @return array|bool
	 *
	 * @since 2.0
	 */
	public static function feeds_count() {
		global $wpdb;
		$feeds_table_name = $wpdb->prefix . 'ctf_feeds';
		$results = $wpdb->get_results(
			"SELECT COUNT(*) AS num_entries FROM $feeds_table_name", ARRAY_A
		);
		return isset($results[0]['num_entries']) ? (int)$results[0]['num_entries'] : 0;
	}


	/**
	 * Query the ctf_feeds table
	 *
	 * @param array $args
	 *
	 * @return array|bool
	 *
	 * @since 2.0
	 */
	public static function feeds_query( $args = array() ) {
		global $wpdb;
		$feeds_table_name = $wpdb->prefix . 'ctf_feeds';
		$page = 0;
		if ( isset( $args['page'] ) ) {
			$page = (int)$args['page'] - 1;
			unset( $args['page'] );
		}

		$offset = max( 0, $page * self::RESULTS_PER_PAGE );

		if ( isset( $args['id'] ) ) {
			$sql = $wpdb->prepare( "
			SELECT * FROM $feeds_table_name
			WHERE id = %d;
		 ", $args['id'] );
		} else {
			$sql = $wpdb->prepare( "
			SELECT * FROM $feeds_table_name
			LIMIT %d
			OFFSET %d;", self::RESULTS_PER_PAGE, $offset );
		}

		return $wpdb->get_results( $sql, ARRAY_A );
	}

	/**
	 * Update feed data in the ctf_feed table
	 *
	 * @param array $to_update
	 * @param array $where_data
	 *
	 * @return false|int
	 *
	 * @since 2.0
	 */
	public static function feeds_update( $to_update, $where_data ) {
		global $wpdb;
		$feeds_table_name = $wpdb->prefix . 'ctf_feeds';

		$data = array();
		$where = array();
		$format = array();
		foreach ( $to_update as $single_insert ) {
			if ( $single_insert['key'] ) {
				$data[ $single_insert['key'] ] = $single_insert['values'][0];
				$format[] = '%s';
			}
		}

		if ( isset( $where_data['id'] ) ) {
			$where['id'] = $where_data['id'];
			$where_format = array( '%d' );
		} elseif ( isset( $where_data['feed_name'] ) ) {
			$where['feed_name'] = $where_data['feed_name'];
			$where_format = array( '%s' );
		} else {
			return false;
		}

		$data['last_modified'] = date( 'Y-m-d H:i:s' );
		$format[] = '%s';

		$affected = $wpdb->update( $feeds_table_name, $data, $where, $format, $where_format );

		return $affected;
	}

	/**
	 * New feed data is added to the ctf_feeds table and
	 * the new insert ID is returned
	 *
	 * @param array $to_insert
	 *
	 * @return false|int
	 *
	 * @since 2.0
	 */
	public static function feeds_insert( $to_insert ) {
		global $wpdb;
		$feeds_table_name = $wpdb->prefix . 'ctf_feeds';

		$data = array();
		$format = array();
		foreach ( $to_insert as $single_insert ) {
			if ( $single_insert['key'] ) {
				$data[ $single_insert['key'] ] = $single_insert['values'][0];
				$format[] = '%s';
			}
		}

		$data['last_modified'] = date( 'Y-m-d H:i:s' );
		$format[] = '%s';

		$data['author'] = get_current_user_id();
		$format[] = '%d';

		$wpdb->insert( $feeds_table_name, $data, $format );
		return $wpdb->insert_id;
	}

	/**
	 * Query the ctf_feeds table
	 * Porcess to define the name of the feed when adding new
	 *
	 * @param array $args
	 *
	 * @return array|bool
	 *
	 * @since 2.0
	 */
	public static function feeds_query_name( $feedname ) {
		global $wpdb;
		$feeds_table_name = $wpdb->prefix . 'ctf_feeds';
		$sql = $wpdb->prepare(
			"SELECT * FROM $feeds_table_name
			WHERE feed_name LIKE %s;",
			$wpdb->esc_like($feedname) . '%'
		);
		$count = sizeof($wpdb->get_results( $sql, ARRAY_A ));
		return ($count == 0) ? $feedname : $feedname .' ('. ($count+1) .')';
	}



	/**
	 * Query to Remove Feeds from Database
	 *
	 * @param array $args
	 *
	 * @return array|bool
	 *
	 * @since 2.0
	 */
	public static function delete_feeds_query( $feed_ids_array ) {
		global $wpdb;
		$feeds_table_name = $wpdb->prefix . 'ctf_feeds';
		$feed_caches_table_name = $wpdb->prefix . 'ctf_feed_caches';
		$feed_ids_array = implode(',', $feed_ids_array);
		$wpdb->query(
			$wpdb->prepare(
				"DELETE FROM $feeds_table_name WHERE id IN ($feed_ids_array)"
			)
		);
		$wpdb->query(
			$wpdb->prepare(
				"DELETE FROM $feed_caches_table_name WHERE feed_id IN ($feed_ids_array)"
			)
		);

		echo ctf_json_encode(CTF_Feed_Builder::get_feed_list());
		wp_die();
	}


	/**
	 * Query to Duplicate a Single Feed
	 *
	 * @param array $args
	 *
	 * @return array|bool
	 *
	 * @since 2.0
	 */
	public static function duplicate_feed_query( $feed_id ){
		global $wpdb;
		$feeds_table_name = $wpdb->prefix . 'ctf_feeds';
		$wpdb->query(
			$wpdb->prepare(
				"INSERT INTO $feeds_table_name (feed_name, settings, author, status)
				SELECT CONCAT(feed_name, ' (copy)'), settings, author, status
				FROM $feeds_table_name
				WHERE id = %d; ", $feed_id
			)
		);



		echo ctf_json_encode(CTF_Feed_Builder::get_feed_list());
		wp_die();
	}


	/**
	 * Get cache records in the ctf_feed_caches table
	 *
	 * @param array $args
	 *
	 * @return array|object|null
	 */
	public static function feed_caches_query( $args ) {
		global $wpdb;
		$feed_cache_table_name = $wpdb->prefix . 'ctf_feed_caches';

		if ( ! isset( $args['cron_update'] ) ) {
			$sql = "
			SELECT * FROM $feed_cache_table_name;";
		} else {
			if ( ! isset( $args['additional_batch'] ) ) {
				$sql = $wpdb->prepare( "
					SELECT * FROM $feed_cache_table_name
					WHERE cron_update = 'yes'
					AND feed_id != 'legacy'
					ORDER BY last_updated ASC
					LIMIT %d;", self::RESULTS_PER_CRON_UPDATE );
			} else {
				$sql = $wpdb->prepare( "
					SELECT * FROM $feed_cache_table_name
					WHERE cron_update = 'yes'
					AND last_updated < %s
					AND feed_id != 'legacy'
					ORDER BY last_updated ASC
					LIMIT %d;", date( 'Y-m-d H:i:s', time() - HOUR_IN_SECONDS ), self::RESULTS_PER_CRON_UPDATE );
			}

		}

		return $wpdb->get_results( $sql, ARRAY_A );
	}


	/**
	 * Creates all database tables used in the new admin area in
	 * the 6.0 update.
	 *
	 * TODO: Add error reporting
	 *
	 * @since 2.0
	 */
	public static function create_tables() {
		if ( !function_exists( 'dbDelta' ) ) {
			require_once ABSPATH . '/wp-admin/includes/upgrade.php';
		}

		global $wpdb;
		$max_index_length = 191;
		$charset_collate = '';
		if ( method_exists( $wpdb, 'get_charset_collate' ) ) { // get_charset_collate introduced in WP 3.5
			$charset_collate = $wpdb->get_charset_collate();
		}

		$feeds_table_name = $wpdb->prefix . 'ctf_feeds';

		if ( $wpdb->get_var( "show tables like '$feeds_table_name'" ) != $feeds_table_name ) {
			$sql = "
			CREATE TABLE $feeds_table_name (
			 id bigint(20) unsigned NOT NULL auto_increment,
			 feed_name text NOT NULL default '',
			 feed_title text NOT NULL default '',
			 settings longtext NOT NULL default '',
			 author bigint(20) unsigned NOT NULL default '1',
			 status varchar(255) NOT NULL default '',
			 last_modified datetime NOT NULL default '0000-00-00 00:00:00',
			 PRIMARY KEY  (id),
			 KEY author (author)
			) $charset_collate;
			";
			$wpdb->query( $sql );
		}
		$error = $wpdb->last_error;
		$query = $wpdb->last_query;
		$had_error = false;
		if ( $wpdb->get_var( "show tables like '$feeds_table_name'" ) != $feeds_table_name ) {
			$had_error = true;
			//$sb_instagram_posts_manager->add_error( 'database_create', '<strong>' . __( 'There was an error when trying to create the database tables used to locate feeds.', 'custom-twitter-feeds' ) .'</strong><br>' . $error . '<br><code>' . $query . '</code>' );
		}

		if ( ! $had_error ) {
			//$sb_instagram_posts_manager->remove_error( 'database_create' );
		}

		$feed_caches_table_name = $wpdb->prefix . 'ctf_feed_caches';

		if ( $wpdb->get_var( "show tables like '$feed_caches_table_name'" ) != $feed_caches_table_name ) {
			$sql = "
				CREATE TABLE " . $feed_caches_table_name . " (
				id bigint(20) unsigned NOT NULL auto_increment,
				feed_id varchar(255) NOT NULL default '',
                cache_key varchar(255) NOT NULL default '',
                cache_value longtext NOT NULL default '',
                cron_update varchar(20) NOT NULL default 'yes',
                last_updated datetime NOT NULL default '0000-00-00 00:00:00',
                PRIMARY KEY  (id),
                KEY feed_id (feed_id)
            ) $charset_collate;";
			$wpdb->query( $sql );
		}
		$error = $wpdb->last_error;
		$query = $wpdb->last_query;
		$had_error = false;
		if ( $wpdb->get_var( "show tables like '$feed_caches_table_name'" ) != $feed_caches_table_name ) {
			$had_error = true;
			//$sb_instagram_posts_manager->add_error( 'database_create', '<strong>' . __( 'There was an error when trying to create the database tables used to locate feeds.', 'custom-twitter-feeds' ) .'</strong><br>' . $error . '<br><code>' . $query . '</code>' );
		}

		if ( ! $had_error ) {
			//$sb_instagram_posts_manager->remove_error( 'database_create' );
		}


		if ( ! $had_error ) {
			//$sb_instagram_posts_manager->remove_error( 'database_create' );
		}
	}



	public static function clear_ctf_feed_caches() {
		global $wpdb;
		$feed_caches_table_name = $wpdb->prefix . 'ctf_feed_caches';

		if ( $wpdb->get_var( "show tables like '$feed_caches_table_name'" ) === $feed_caches_table_name ) {
			$wpdb->query( "DELETE FROM $feed_caches_table_name" );
		}
	}


	public static function reset_tables() {
		global $wpdb;
		$feeds_table_name = $wpdb->prefix . 'ctf_feeds';

		$wpdb->query( "DROP TABLE IF EXISTS $feeds_table_name" );
		$feed_caches_table_name = $wpdb->prefix . 'ctf_feed_caches';

		$wpdb->query( "DROP TABLE IF EXISTS $feed_caches_table_name" );

	}

	public static function reset_db_update() {
		update_option( 'ctf_db_version', 1.3 );
		delete_option( 'ctf_legacy_feed_settings' );

		// are there existing feeds to toggle legacy onboarding?
		$ctf_statuses_option = get_option( 'ctf_statuses', array() );

		if ( isset( $ctf_statuses_option['legacy_onboarding'] ) ) {
			unset( $ctf_statuses_option['legacy_onboarding'] );
		}
		if ( isset( $ctf_statuses_option['support_legacy_shortcode'] ) ) {
			unset( $ctf_statuses_option['support_legacy_shortcode'] );
		}

		global $wpdb;

		$table_name = $wpdb->prefix . "usermeta";
		$wpdb->query( "
        DELETE
        FROM $table_name
        WHERE `meta_key` LIKE ('ctf\_%')
        " );


		$feed_locator_table_name = esc_sql( $wpdb->prefix . CTF_FEED_LOCATOR );

		$results = $wpdb->query( "
			DELETE
			FROM $feed_locator_table_name
			WHERE feed_id LIKE '*%';" );

		update_option( 'ctf_statuses', $ctf_statuses_option );
	}

	public static function reset_legacy() {

		//Settings
		delete_option( 'ctf_statuses' );
		delete_option( 'ctf_options' );
		delete_option( 'ctf_ver' );
		delete_option( 'ctf_db_version' );

		// Clear backup caches
		global $wpdb;
		$table_name = $wpdb->prefix . "options";
		$wpdb->query( "
        DELETE
        FROM $table_name
        WHERE `option_name` LIKE ('%!ctf\_%')
        " );
		$wpdb->query( "
        DELETE
        FROM $table_name
        WHERE `option_name` LIKE ('%\_transient\_&ctf\_%')
        " );
		$wpdb->query( "
        DELETE
        FROM $table_name
        WHERE `option_name` LIKE ('%\_transient\_timeout\_&ctf\_%')
        " );
		$wpdb->query( "
    DELETE
    FROM $table_name
    WHERE `option_name` LIKE ('%sb_wlupdated_%')
    " );

		//image resizing
		$upload                 = wp_upload_dir();
		$posts_table_name       = $wpdb->prefix . 'ctf_posts';
		$feeds_posts_table_name = esc_sql( $wpdb->prefix . 'ctf_feeds_posts' );

		$image_files = glob( trailingslashit( $upload['basedir'] ) . trailingslashit( CTF_UPLOADS_NAME ) . '*' ); // get all file names
		foreach ( $image_files as $file ) { // iterate files
			if ( is_file( $file ) ) {
				unlink( $file );
			} // delete file
		}

		//global $wp_filesystem;

		//$wp_filesystem->delete( trailingslashit( $upload['basedir'] ) . trailingslashit( CTF_UPLOADS_NAME ) , true );
		//Delete tables
		$wpdb->query( "DROP TABLE IF EXISTS $posts_table_name" );
		$wpdb->query( "DROP TABLE IF EXISTS $feeds_posts_table_name" );
		$locator_table_name = $wpdb->prefix . CTF_FEED_LOCATOR;
		$wpdb->query( "DROP TABLE IF EXISTS $locator_table_name" );

		$table_name = $wpdb->prefix . "options";
		$wpdb->query( "
			        DELETE
			        FROM $table_name
			        WHERE `option_name` LIKE ('%\_transient\_\$ctf\_%')
			        " );
		$wpdb->query( "
			        DELETE
			        FROM $table_name
			        WHERE `option_name` LIKE ('%\_transient\_timeout\_\$ctf\_%')
			        " );
		delete_option( 'ctf_usage_tracking' );
		delete_option( 'ctf_usage_tracking_config' );
		delete_option( 'ctf_configure' );
		delete_option( 'ctf_customize' );
		delete_option( 'ctf_style' );
		delete_option( 'ctf_options' );
		delete_option( 'ctf_statuses' );
		delete_option( 'ctf_local_avatars' );
		delete_option( 'ctf_db_version' );
		delete_option( 'ctf_cache_list' );
		delete_option( 'ctf_twitter_cards' );
		delete_option( 'ctf_errors' );

		global $wp_roles;
		$wp_roles->remove_cap( 'administrator', 'manage_twitter_feed_options' );
		wp_clear_scheduled_hook( 'ctf_feed_update' );
		wp_clear_scheduled_hook( 'ctf_usage_tracking_cron' );
	}
}
