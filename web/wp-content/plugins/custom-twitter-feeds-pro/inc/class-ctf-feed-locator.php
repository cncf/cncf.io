<?php
/**
 * Class CTF_Feed_Locator
 *
 * Locates feeds on the site and logs information about them in the database.
 *
 * @since 1.14
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class CTF_Feed_Locator
{
	private $feed_details;

	private $expiration_time;

	private $matching_entries;

	public function __construct( $feed_details ) {
		/**
		 * Example of how $feed_details is structured
		 *
		 * $feed_details = array(
		 *   'feed_id' => $transient_name,
		 *   'atts' => $atts,
		 *   'location' => array(
		 *       'post_id' => get_the_ID(),
		 *       'html' => 'unknown'
		 *   )
		 * );
		 */
		$this->feed_details = $feed_details;

		$this->matching_entries = array();

		$this->expiration_time = time() - 2 * WEEK_IN_SECONDS;
	}

	/**
	 * Returns records that match the post ID and feed ID
	 * of the feed being located
	 *
	 * @return array
	 *
	 * @since 1.14
	 */
	public function retrieve_matching_entries() {
		global $wpdb;
		$feed_locator_table_name = esc_sql( $wpdb->prefix . CTF_FEED_LOCATOR );

		$results = $wpdb->get_results( $wpdb->prepare("
			SELECT *
			FROM $feed_locator_table_name
			WHERE post_id = %d
		  	AND feed_id = %s", $this->feed_details['location']['post_id'], $this->feed_details['feed_id'] ),ARRAY_A );

		return $results;
	}

	/**
	 * Add feed being located to the database
	 *
	 * @since 1.14
	 */
	public function insert_entry() {
		global $wpdb;

		$feed_locator_table_name = esc_sql( $wpdb->prefix . CTF_FEED_LOCATOR );

		$affected = $wpdb->query( $wpdb->prepare( "INSERT INTO $feed_locator_table_name
      	(feed_id,
      	post_id,
      	html_location,
      	shortcode_atts,
      	last_update) 
      	VALUES (
            %s,
	        %d,
	        %s,
	        %s,
	        %s);",
			$this->feed_details['feed_id'],
			$this->feed_details['location']['post_id'],
			$this->feed_details['location']['html'],
			ctf_json_encode( $this->feed_details['atts'] ),
			date( 'Y-m-d H:i:s' ) ) );
	}

	/**
	 * Update a record based on the existing "id" column. Location can change
	 * from "unknown" to one of footer, content, header, or sidebar.
	 *
	 * @param $id
	 * @param $location
	 *
	 * @since 1.14
	 */
	public function update_entry( $id, $location ) {
		global $wpdb;

		$feed_locator_table_name = esc_sql( $wpdb->prefix . CTF_FEED_LOCATOR );

		$query = $wpdb->query( $wpdb->prepare( "
			UPDATE $feed_locator_table_name
			SET last_update = %s, html_location = %s
			WHERE id = %d;", date( 'Y-m-d H:i:s' ), $location, $id ) );
	}

	/**
	 * Processes a feed being located based on whether or not the record
	 * exists as well as whether or not an unknown location needs to be
	 * updated.
	 *
	 * @since 1.14
	 */
	public function add_or_update_entry() {
		if ( empty( $this->feed_details['feed_id'] ) ) {
			return;
		}

		$this->matching_entries = $this->retrieve_matching_entries();

		if ( empty( $this->matching_entries ) ) {
			$this->insert_entry();
		} else {
			$matching_indices = array();
			$matched_location = false;
			$non_unknown_match = false;
			$unknown_match = false;

			foreach ( $this->matching_entries as $index => $matching_entry ) {
				$details_atts = is_array( $this->feed_details['atts'] ) ? $this->feed_details['atts'] : array();
				$matching_atts = json_decode( $matching_entry['shortcode_atts'], true );
				if ( ! is_array( $matching_atts ) ) {
					$matching_atts = array();
				}
				$atts_diff = array_diff( $matching_atts, $details_atts ); // determines if the shortcode settings match the shortcode settings of an existing feed
				if ( empty( $atts_diff ) ) {
					$matching_indices[] = $matching_entry['id'];
					if ( $matching_entry['html_location'] === $this->feed_details['location']['html'] ) {
						$matched_location = $index;
						$this->update_entry( $matching_entry['id'], $matching_entry['html_location'] );
					}
					if ( $matching_entry['html_location'] !== 'unknown' ) {
						$non_unknown_match = $index;
					} else {
						$unknown_match = $index;
					}
				}
			}

			if ( false === $matched_location ) {
				// if there is no matched location, there is only one feed on the page, and the feed being checked has an unknown location, update the known location
				if ( count( $matching_indices ) === 1
				     && $this->feed_details['location']['html'] === 'unknown'
				     && false !== $non_unknown_match ) {
					$this->update_entry( $this->matching_entries[ $non_unknown_match ]['id'], $this->matching_entries[ $non_unknown_match ]['html_location'] );
				} else {
					if ( $this->feed_details['location']['html'] !== 'unknown'
					     && false !== $unknown_match ) {
						$this->update_entry( $this->matching_entries[ $unknown_match ]['id'], $this->feed_details['location']['html'] );
					} else {
						$this->insert_entry();
					}

				}
			}

		}
	}

	/**
	 * Old feeds are only detected once a day to keep load on the server low.
	 *
	 * @return bool
	 *
	 * @since 1.14
	 */
	public static function should_clear_old_locations() {
		$ctf_statuses_option = get_option( 'ctf_statuses', array() );
		$last_old_feed_check = isset( $ctf_statuses_option['feed_locator']['last_check'] ) ? $ctf_statuses_option['feed_locator']['last_check'] : 0;

		return $last_old_feed_check < time() - DAY_IN_SECONDS;
	}

	/**
	 * Old feeds are removed if they haven't been updated in two weeks.
	 *
	 * @since 1.14
	 */
	public static function delete_old_locations() {
		global $wpdb;

		$feed_locator_table_name = esc_sql( $wpdb->prefix . CTF_FEED_LOCATOR );
		$two_weeks_ago = date( 'Y-m-d H:i:s', time() - 2 * WEEK_IN_SECONDS );

		$affected = $wpdb->query( $wpdb->prepare(
			"DELETE FROM $feed_locator_table_name WHERE last_update < %s;", $two_weeks_ago ) );

		$ctf_statuses_option = get_option( 'ctf_statuses', array() );
		$ctf_statuses_option['feed_locator']['last_check'] = time();
		if ( ! isset( $ctf_statuses_option['feed_locator']['initialized'] ) ) {
			$ctf_statuses_option['feed_locator']['initialized'] = time();
		}

		update_option( 'ctf_statuses', $ctf_statuses_option, true );
	}

	/**
	 * Feeds are located with the page load randomly (5% or 1/30 loads)
	 * to decrease load on the server.
	 *
	 * If the locating just started (within 5 minutes) it is run more often
	 * to collect feed locations quickly.
	 *
	 * @return bool
	 *
	 * @since 1.14
	 */
	public static function should_do_locating() {
		$ctf_statuses_option = get_option( 'ctf_statuses', array() );
		if ( isset( $ctf_statuses_option['feed_locator']['initialized'] )
		     && $ctf_statuses_option['feed_locator']['initialized'] < (time() - 300) ) {
			$should_do_locating = rand( 1, 10 ) === 10;
		} else {
			$should_do_locating = rand( 1, 30 ) === 30;
		}
		$should_do_locating = apply_filters( 'ctf_should_do_locating', $should_do_locating );

		return $should_do_locating;
	}

	/**
	 * Simliar to the should_do_locating method but will add an additional
	 * database query to see if there is a feed with an unknown location that
	 * matches the details of the feed in question.
	 *
	 * @param $feed_id
	 * @param $post_id
	 *
	 * @return bool
	 *
	 * @since 1.14
	 */
	public static function should_do_ajax_locating( $feed_id, $post_id ) {
		$should_do_locating = rand( 1, 50 ) === 50;

		$should_do_locating = apply_filters( 'ctf_should_do_ajax_locating', $should_do_locating );

		return $should_do_locating;
	}

	/**
	 * Feeds are located with the page load randomly (1/30 loads)
	 * to decrease load on the server.
	 *
	 * If the locating just started (within 5 minutes) it is run more often
	 * to collect feed locations quickly.
	 *
	 * @param $feed_id
	 * @param $post_id
	 *
	 * @return bool
	 *
	 * @since 1.14
	 */
	public static function entries_need_locating( $feed_id, $post_id ) {
		global $wpdb;
		$feed_locator_table_name = esc_sql( $wpdb->prefix . CTF_FEED_LOCATOR );

		$one_day_ago = date( 'Y-m-d H:i:s', time() - DAY_IN_SECONDS );

		$results = $wpdb->get_results( $wpdb->prepare("
			SELECT id
			FROM $feed_locator_table_name
			WHERE html_location = 'unknown'
			AND last_update < %s
			AND feed_id = %s
			AND post_id = %d
			LIMIT 1;", $one_day_ago, $feed_id, $post_id ),ARRAY_A );

		return isset( $results[0] );
	}

	/**
	 * A custom table stores locations
	 *
	 * @since 1.14
	 */
	public static function create_table() {
		global $wpdb;

		$feed_locator_table_name = esc_sql( $wpdb->prefix . CTF_FEED_LOCATOR );

		if ( $wpdb->get_var( "show tables like '$feed_locator_table_name'" ) != $feed_locator_table_name ) {
			$sql = "CREATE TABLE " . $feed_locator_table_name . " (
				id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                feed_id VARCHAR(50) DEFAULT '' NOT NULL,
                post_id BIGINT(20) UNSIGNED NOT NULL,
                html_location VARCHAR(50) DEFAULT 'unknown' NOT NULL,
                shortcode_atts LONGTEXT NOT NULL,
                last_update DATETIME
            );";
			$wpdb->query( $sql );
		}
		$error = $wpdb->last_error;
		$query = $wpdb->last_query;
		$had_error = false;
		if ( $wpdb->get_var( "show tables like '$feed_locator_table_name'" ) != $feed_locator_table_name ) {
			$had_error = true;
		}

		if ( ! $had_error ) {
			$wpdb->query( "ALTER TABLE $feed_locator_table_name ADD INDEX feed_id (feed_id)" );
			$wpdb->query( "ALTER TABLE $feed_locator_table_name ADD INDEX post_id (post_id)" );
		}
	}

	/**
	 * Counts the number of unique feeds in the database.
	 *
	 * @return int
	 *
	 * @since 1.14
	 */
	public static function count_unique() {
		global $wpdb;

		$feed_locator_table_name = esc_sql( $wpdb->prefix . CTF_FEED_LOCATOR );
		$results_content = $wpdb->get_results( "
			SELECT COUNT(*) AS num_entries
            FROM $feed_locator_table_name 
            WHERE html_location = 'content'
            ", ARRAY_A );


		$results_other = $wpdb->get_results( "
			SELECT COUNT(*) AS num_entries
            FROM $feed_locator_table_name 
            WHERE html_location != 'content'
            AND html_location != 'unknown'
            GROUP BY feed_id
            ", ARRAY_A );

		$total = 0;
		if ( isset( $results_content[0]['num_entries'] ) ) {
			$total += (int)$results_content[0]['num_entries'];
		}
		if ( isset( $results_other[0]['num_entries'] ) ) {
			$total += (int)$results_other[0]['num_entries'];
		}

		return $total;
	}

	/**
	 * Creates a summary of the located feeds in an array
	 *
	 * @return array
	 *
	 * @since 1.14
	 */
	public static function summary() {
		global $wpdb;

		$feed_locator_table_name = esc_sql( $wpdb->prefix . CTF_FEED_LOCATOR );

		$locations = array(
			array(
				'label' => __( 'Content', 'custom-twitter-feeds' ),
				'html_locations' => array( 'content', 'unknown' )
			),
			array(
				'label' => __( 'Header', 'custom-twitter-feeds' ),
				'html_locations' => array( 'header' ),
				'group_by' => 'feed_id'
			),
			array(
				'label' => __( 'Sidebar', 'custom-twitter-feeds' ),
				'html_locations' => array( 'sidebar' ),
				'group_by' => 'feed_id'
			),
			array(
				'label' => __( 'Footer', 'custom-twitter-feeds' ),
				'html_locations' => array( 'footer' ),
				'group_by' => 'feed_id'
			)
		);

		$one_result_found = false;

		foreach ( $locations as $key => $location ) {
			$in = implode( "', '", $location['html_locations'] );
			$group_by = isset( $location['group_by'] ) ? "GROUP BY " . $location['group_by'] : "";
			$results = $wpdb->get_results("
			SELECT *
			FROM $feed_locator_table_name
			WHERE html_location IN ('$in')
		  	$group_by
		  	ORDER BY last_update ASC",ARRAY_A );

			if ( isset( $results[0] ) ) {
				$one_result_found = true;
			}

			$locations[ $key ]['results'] = $results;
		}

		if ( ! $one_result_found ) {
			return array();
		}

		return $locations;
	}
}