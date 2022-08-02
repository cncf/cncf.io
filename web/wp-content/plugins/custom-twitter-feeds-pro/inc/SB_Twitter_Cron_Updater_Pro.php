<?php

namespace TwitterFeed;

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

use TwitterFeed\CtfFeedPro;
use TwitterFeed\Pro\CTF_Feed_Pro;
use TwitterFeed\Builder\CTF_Feed_Saver;

class SB_Twitter_Cron_Updater_Pro {
	/**
	 * Loop through all feed cache transients and update the post and
	 * header caches.
	 *
	 * @since 2.0
	 */
	public static function do_feed_updates() {
		$cron_records = \TwitterFeed\Builder\CTF_Db::feed_caches_query( array( 'cron_update' => true ) );
		$num          = count( $cron_records );
		if ( $num === \TwitterFeed\Builder\CTF_Db::RESULTS_PER_CRON_UPDATE ) {
			wp_schedule_single_event( time() + 120, 'ctf_cron_additional_batch' );
		}

		self::update_batch( $cron_records );
	}

	/**
	 * Updates an array of caches using the feed ID
	 *
	 * @param array $cron_records
	 */
	public static function update_batch( $cron_records ) {
		$report = array(
			'notes' => array(
				'time_ran'             => date( 'Y-m-d H:i:s' ),
				'num_found_transients' => count( $cron_records ),
			),
		);

		foreach ( $cron_records as $feed_cache ) {
			$feed_id = $feed_cache['feed_id'];

			$result = self::do_single_feed_cron_update( $feed_id );

			$report[ $feed_id ] = $result;
		}

		update_option( 'ctf_cron_report', $report, false );
	}

	/**
	 * Updates a single feed cache based on the ID passed
	 *
	 * @param $feed_id
	 *
	 * @return array
	 */
	public static function do_single_feed_cron_update( $feed_id ) {
		$atts         = array( 'feed' => $feed_id );
		$atts['doingcronupdate'] = true;
		$twitter_feed = CtfFeedPro::init( $atts, null, 0, array(), 1, false );

		// if there is an error, display the error html, otherwise the feed
		if ( ! $twitter_feed->tweet_set || $twitter_feed->missing_credentials || ! isset( $twitter_feed->tweet_set[0]['created_at'] ) ) {
			if ( ! empty( $twitter_feed->tweet_set['errors'] ) ) {
				$twitter_feed->maybeCacheTweets();
			}

			return array(
				'success' => false,
				'error'   => $twitter_feed->tweet_set['errors'],
			);
		}

		if ( ! $twitter_feed->feed_options['persistentcache'] ) {
			$twitter_feed->maybeCacheTweets();
		}
		do_action( 'ctf_after_single_feed_cron_update', $twitter_feed->transient_name );

		return array(
			'success' => true,
		);
	}

	/**
	 * Start cron jobs based on user's settings for cron cache update frequency.
	 * This is triggered when settings are saved on the "Configure" tab.
	 *
	 * @param string $cache_time arbitrary name from one of the
	 *  settings on the "Configure" tab
	 * @param string $cache_time_unit hour of the day (1 = 1:00)
	 *
	 * @since 2.0/5.0
	 */
	public static function start_cron_job( $ctf_cache_cron_interval, $ctf_cache_cron_time, $ctf_cache_cron_am_pm  ) {

		wp_clear_scheduled_hook( 'ctf_feed_update' );

		if ( $ctf_cache_cron_interval === '12hours' || $ctf_cache_cron_interval === '24hours' ) {
			$relative_time_now = time() + ctf_get_utc_offset();
			$base_day = strtotime( date( 'Y-m-d', $relative_time_now ) );
			$add_time = $ctf_cache_cron_am_pm === 'pm' ? (int)$ctf_cache_cron_time + 12 : (int)$ctf_cache_cron_time;
			$utc_start_time = $base_day + (($add_time * 60 * 60) - ctf_get_utc_offset());

			if ( $utc_start_time < time() ) {
				if ( $ctf_cache_cron_interval === '12hours' ) {
					$utc_start_time += 60*60*12;
				} else {
					$utc_start_time += 60*60*24;
				}
			}

			if ( $ctf_cache_cron_interval === '12hours' ) {
				wp_schedule_event( $utc_start_time, 'twicedaily', 'ctf_feed_update' );
			} else {
				wp_schedule_event( $utc_start_time, 'daily', 'ctf_feed_update' );
			}

		} else {

			if ( $ctf_cache_cron_interval === '30mins' ) {
				wp_schedule_event( time(), 'sbi30mins', 'ctf_feed_update' );
			} else {
				wp_schedule_event( time(), 'hourly', 'ctf_feed_update' );
			}
		}
	}
}
