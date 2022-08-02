<?php

namespace TwitterFeed\Admin;
use TwitterFeed\Pro\CTF_Twitter_Card_Manager;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Custom Twitter Feed Cache Handler.
 *
 * @since 2.0
 */
class CTF_Cache_Handler {

	/**
	 * Clears all cache.
	 *
	 * @return void
	 */
	public function clear_all_cache() {
		$this->clear_db_caches();
		$this->clear_third_party_caches();
	}

	/**
	 * Clear the stored caches from the database.
	 *
	 * @since 2.0
	 */
	public function clear_db_caches() {
		global $wpdb;

		$cache_table_name = $wpdb->prefix . 'ctf_feed_caches';

		$sql = "UPDATE $cache_table_name
				SET cache_value = ''
				WHERE cache_key NOT LIKE 'ctf_!_%';";

		$wpdb->query( $sql );

		$sql = "DELETE FROM $cache_table_name
				WHERE feed_id LIKE '%_CUSTOMIZER';";

		$wpdb->query( $sql );

		$this->clear_legacy_caches();
	}

	public function clear_single_feed_cache( $feed_id ) {
		global $wpdb;

		$cache_table_name = $wpdb->prefix . 'ctf_feed_caches';

		$wpdb->query( $wpdb->prepare(
			"UPDATE $cache_table_name
				SET cache_value = ''
				WHERE cache_key NOT LIKE 'ctf_!_%'
				AND feed_id = %s;", $feed_id
		) );

		$wpdb->query( $wpdb->prepare(
			"UPDATE $cache_table_name
				SET last_updated = '2000-04-04 00:00:00'
				WHERE cache_key LIKE 'ctf_!_%'
				AND feed_id = %s;", $feed_id . '_CUSTOMIZER'
		) );

		$wpdb->query( $wpdb->prepare(
			"UPDATE $cache_table_name
				SET last_updated = '2000-04-04 00:00:00'
				WHERE cache_key LIKE 'ctf_!_%'
				AND feed_id = %s;", $feed_id
		) );
	}

	public function clear_legacy_caches() {
		global $wpdb;

		$cache_table_name = $wpdb->prefix . 'ctf_feed_caches';

		$sql = "UPDATE $cache_table_name
				SET cache_value = ''
				WHERE feed_id = 'legacy';";

		$wpdb->query( $sql );

		global $wpdb;

		//Delete all CTF transients
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
                    WHERE `option_name` LIKE ('%\_transient\_\$ctf\_%')
                    " );
		$wpdb->query( "
                    DELETE
                    FROM $table_name
                    WHERE `option_name` LIKE ('%\_transient\_timeout\_\$ctf\_%')
                    " );
	}

	/**
	 * Clears the third party cache.
	 *
	 * When certain events occur, page caches need to
	 * clear or errors occur or changes will not be seen
	 *
	 * @since 2.0
	 */
	public function clear_third_party_caches() {
		/**
		 * Filters whether to clear page caches.
		 *
		 * @since 2.0
		 *
		 * @param bool Whether to clear cache.
		 */
		$clear_page_caches = apply_filters( 'ctf_clear_page_caches', true );

		if ( ! $clear_page_caches ) {
			return;
		}

		// Clear WP Fastest Cache.
		if ( isset( $GLOBALS['wp_fastest_cache'] ) && method_exists( $GLOBALS['wp_fastest_cache'], 'deleteCache' ) ){
			$GLOBALS['wp_fastest_cache']->deleteCache();
		}

		// Clear WP Super Cache
		if ( function_exists( 'wp_cache_clear_cache' ) ) {
			wp_cache_clear_cache();
		}

		// Clear W3 Total Cache.
		if ( class_exists('W3_Plugin_TotalCacheAdmin') && function_exists( 'w3_instance' ) ) {
			$plugin_total_cache_admin = &w3_instance('W3_Plugin_TotalCacheAdmin');

			$plugin_total_cache_admin->flush_all();
		}

		// Clear WP Rocket cache.
		if ( function_exists( 'rocket_clean_domain' ) ) {
			rocket_clean_domain();
		}

		// Clear Autoptimize Cache.
		if ( class_exists( 'autoptimizeCache' ) ) {
			autoptimizeCache::clearall();
		}

		// Litespeed Cache.
		if ( method_exists( 'LiteSpeed_Cache_API', 'purge' ) ) {
			LiteSpeed_Cache_API::purge( 'esi.instagram-feed' );
		}
	}

	/**
	 * Clear the stored caches from the database.
	 *
	 * @since 2.0
	 */
	public function clear_persistent_cache() {
		global $wpdb;

		$cache_table_name = $wpdb->prefix . 'ctf_feed_caches';

		$sql = "UPDATE $cache_table_name
				SET cache_value = ''";
		$wpdb->query( $sql );
	}

	/**
	 * Clear the stored twitter card caches from the database.
	 *
	 * @since 2.0
	 */
	public function clear_twittercard_cache() {
		CTF_Twitter_Card_Manager::clear_all_local();
		delete_option( 'ctf_twitter_cards' );
		$this->clear_db_caches();
	}
}
