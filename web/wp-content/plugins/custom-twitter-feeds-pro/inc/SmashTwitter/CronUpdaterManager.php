<?php
/**
* Class Request
*
* Performs a request to the Smash Balloon Twitter API.
*
* @since 2.1
*/
namespace TwitterFeed\SmashTwitter;

use TwitterFeed\Builder\CTF_Feed_Builder;
use TwitterFeed\SB_Twitter_Cron_Updater_Pro;

class CronUpdaterManager
{
	private $frequency;

	private $max_batch;

	private $api_call_log;

	public function __construct() {
		$this->frequency = DAY_IN_SECONDS;

		$this->max_batch = 1;
		$this->api_call_log = get_option( 'ctf_api_call_log', array() );

		// Entry point for getting the site access token after the plugin update to be able to use the Smash Twitter.
		if (false === get_transient('ctf_smash_twitter_first_run')) {
			$this->maybe_setup_auth();

			$feeds = array_column($this->fetch_all_feeds(), 'id');
			update_option('ctf_smash_twitter_feeds_to_update', $feeds);

			set_transient('ctf_smash_twitter_first_run', date('Y-m-d h:i:s'), 0);
		}

		add_action('ctf_smash_twitter_feed_update', [$this, 'maybe_do_updates']);
	}

	public function can_update() {
		return true;
	}

	public function update_api_call_log( $type, $term ) {
		if ( ! is_array( $this->api_call_log ) ) {
			$this->api_call_log = array();
		}

		if ( is_array( $this->api_call_log ) && count( $this->api_call_log ) > 50 ) {
			reset( $this->api_call_log );
			unset( $this->api_call_log[ key($this->api_call_log ) ] );
		}

		$this->api_call_log[] = array(
			'time' => time(),
			'type' => $type,
			'term' => $term
		);

		update_option( 'ctf_api_call_log', $this->api_call_log, false );
	}

	public function get_api_call_log() {
		return $this->api_call_log;
	}

	public function init_additional_batch() {
		$this->do_updates();
	}

	public function should_do_updates() {
		if ( ! $this->is_past_first_allowed_update() ) {
			return false;
		}

		$api_call_log = $this->get_api_call_log();

		$last_log = end( $api_call_log );

		$last_call = $last_log['time'];

		$time_with_minute_buffer = time() + 60;

		if ( $last_call < ($time_with_minute_buffer - $this->frequency) ) {
			return true;
		}

		return false;
	}

	private function is_past_first_allowed_update() {
		$ctf_statuses_option = get_option( 'ctf_statuses', array() );
		if ( empty( $ctf_statuses_option['first_cron_update'] ) ) {
			return true;
		}
		return time() > $ctf_statuses_option['first_cron_update'];
	}

	public function do_updates() {
		$can_auth = $this->maybe_setup_auth();
		if ( ! $can_auth ) {
			return;
		}

		$batch_feeds = $this->get_next_batch_of_updatable_feeds();


		if (!count($batch_feeds)) {
			return;
		}
		$return = array();
		foreach ( $batch_feeds as $batch_feed ) {
			$updatable_feed_id = ! empty( $batch_feed['id'] ) ? $batch_feed['id'] : 'legacy';

			$return = SB_Twitter_Cron_Updater_Pro::do_single_feed_cron_update( $updatable_feed_id );
		}

		if ( ! empty( $return['data'] ))
		foreach ( $return['data'] as $item ) {
			if ( ! empty( $item ) ) {
				foreach ( $item as $feed_type_and_terms ) {
					$this->update_api_call_log( $feed_type_and_terms[0], $feed_type_and_terms[1]);
				}
			}
		}

		// Remove the current batch from the list of feeds to update.
		$remaining_feeds = get_option('ctf_smash_twitter_feeds_to_update');
		$remaining_feeds = array_diff($remaining_feeds, $batch_feeds);
		update_option('ctf_smash_twitter_feeds_to_update', $remaining_feeds);
	}

	public function maybe_setup_auth() {
		$ctf_options = get_option( 'ctf_options', array() );

		$ctf_license = get_option( 'ctf_license_key', '' );

		if ( empty( $ctf_license ) ) {
			return false;
		}

		if ( empty( $ctf_options['site_access_token'] ) ) {
			$auth_routine = new AuthRoutine();
			$result_token = $auth_routine->run_register();
			$results = $auth_routine->run_license_activation( $result_token );
			if ( ! empty( $results['data']['api_data'] ) ) {
				update_option( 'ctf_license_data', $results['data']['api_data'] );
				return true;
			} else {
				return false;
			}
		}

		return true;
	}

	public function fetch_all_feeds() {
		$feeds = CTF_Feed_Builder::get_feed_list();

		$builder = new CTF_Feed_Builder();
		$legacy_feeds = $builder->get_legacy_feed_list();

		return array_merge($feeds, $legacy_feeds);
	}

	public function get_next_batch_of_updatable_feeds()
	{
		/*$feeds = get_option('ctf_smash_twitter_feeds_to_update', []);

		if (!is_array($feeds)) {
			return [];
		}

		if (!count($feeds)) {
			return [];
		}

		$updatable_feeds = array_slice($feeds, 0, $this->max_batch);
*/
		return $this->get_updatable_feeds();
	}

	public function get_updatable_feeds() {
		$feeds = CTF_Feed_Builder::get_feed_list();

		if ( count( $feeds ) > $this->max_batch ) {
			$updatable_feeds = array_slice($feeds, 0, $this->max_batch );
		} else {
			$updatable_feeds = $feeds;
			$remaining = count( $updatable_feeds ) - $this->max_batch;

			if ( ! empty( $remaining ) ) {
				$builder = new CTF_Feed_Builder();
				$legacy_feeds = $builder->get_legacy_feed_list();
				$legacy_feeds_updatable = array_slice( $legacy_feeds, 0, $remaining );
				$updatable_feeds = array_merge( $updatable_feeds, $legacy_feeds_updatable );
			}
		}

		return $updatable_feeds;
	}

	public static function schedule_cron_job() {
		if ( ! wp_next_scheduled( 'ctf_smash_twitter_feed_update' ) ) {
			wp_schedule_event( time(), 'hourly', 'ctf_smash_twitter_feed_update' );
		}
	}

	/**
	 * Maybe do updates if 24 hours have passed since the plugin was updated.
	 *
	 * @return void
	 */
	public function maybe_do_updates() {
		if ( $this->should_do_updates() ) {
			$this->do_updates();
		}
	}
}
