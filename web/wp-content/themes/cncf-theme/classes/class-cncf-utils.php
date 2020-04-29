<?php
/**
 * Utilities
 *
 * Small helpers to improve code and readibility.
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

  /**
   * Utility Class
   *
   * Small helper utilities.
   *
   * @since 1.0.0
   */
class Cncf_Utils {

	/**
	 * Get YouTube ID from URL.
	 *
	 * @param string $url YouTube URL.
	 */
	public static function get_youtube_id_from_url( $url ) {

		if ( ! is_string( $url ) ) {
			return false;
		}

		if ( false !== stripos( $url, 'https://www.youtube.com/watch?v=' ) ) {
			$video_id = substr( $url, 32, 11 );
		} elseif ( false !== stripos( $url, 'https://youtu.be/' ) ) {
			$video_id = substr( $url, 17, 11 );
		}

		return isset( $video_id ) ? $video_id : false;
	}

	/**
	 * Get Terms and Extract Names.
	 *
	 * @param integer $post_id Post ID.
	 * @param string  $taxonomy Taxonomy name.
	 * @param boolean $first_only To show only first result.
	 */
	public static function get_term_names( $post_id, $taxonomy, $first_only = false ) {

		if ( ! is_integer( $post_id ) || ! is_string( $taxonomy ) ) {
			return false;
		}

		$terms = get_the_terms( $post_id, $taxonomy );

		if ( empty( $terms ) || is_wp_error( $terms ) ) {
			return false;
		}

		if ( $first_only ) {
			$term   = array_shift( $terms );
			$result = $term->name;
		} else {
			$result = join( ', ', wp_list_pluck( $terms, 'name' ) );
		}

		return isset( $result ) ? $result : false;
	}

	/**
	 * Display webinar date and time
	 *
	 * @param object  $date Date object.
	 * @param string  $time Time.
	 * @param boolean $formatted Formatted for DateTime object.
	 */
	public static function display_webinar_date_time( $date, $time, $formatted = false ) {

		if ( ! $date ) {
			return;
		}

		$dt_date = new DateTime(
			$date,
			new DateTimeZone( 'America/Los_Angeles' )
		);

		// time is sometimes deleted by editors? Fix.
		if ( $time ) {

			// explode the string in to array.
			$time_elements = explode( ' ', $time );

			// this may mean time has been entered incorrectly.
			if ( count( $time_elements ) < 5 ) {
				$time          = str_replace( '-', ' - ', $time );
				$time_elements = explode( ' ', $time );
			}

			if ( ! is_array( $time_elements ) || empty( $time_elements ) ) {
				return;
			}

			// Check an AM or PM period is set.
			$period = strtoupper( trim( $time_elements[3] ) );
			if ( ! in_array( $period, array( 'AM', 'PM' ) ) ) {
				return;
			}

			// Format the start time and pad it out if needed.
			$padded_starting_time = str_pad( trim( $time_elements[0] ), 5, '0', STR_PAD_LEFT );

			// Check time is actually a valid time.
			$format        = 'H:i';
			$date_object   = DateTime::createFromFormat( $format, $padded_starting_time );
			$starting_time = gmdate( 'G', strtotime( $padded_starting_time ) );

			if ( ! $date_object && ! $date_object->format( $format ) == $starting_time ) {
				return;
			}

			// get the timezone.
			$timezone = trim( substr( $time, -3 ) );

		} else {
			// set some defaults just in case.
			$starting_time        = '10';
			$padded_starting_time = '10:00';
			$timezone             = 'PST';
			$period               = 'AM';
		}

		// format the webinar date.
		$webinar_date = $dt_date->format( 'l j F Y' );

		// setup the results.
		if ( $formatted ) {

			// fix abbreviation timezone.
			if ( 'PT' == $timezone ) {
				$timezone = 'PST';
			}

			// output in way suitable for DateTime.
			$result = $date . ' ' . $padded_starting_time . ' ' . $timezone;

		} else {
			// output in readable format.
			$result = $webinar_date . ' ' . $starting_time . $period . ' ' . $timezone;
		}
		return isset( $result ) ? $result : false;
	}

	/**
	 * Helps to add pluralise words when unknown counts.
	 *
	 * Default is for s, i.e. speaker, speakers.
	 *
	 * @param integer $number Number value.
	 * @param string  $singular String to show for singular words.
	 * @param string  $plural String to show for singular words.
	 */
	public static function plural( $number, $singular = '', $plural = 's' ) {

		if ( 1 == $number ) {
			return $singular;
		}
		return $plural;
	}

	/**
	 * Display Event Date.
	 *
	 * @param string $event_date_start Date string.
	 * @param string $event_date_end Date string.
	 */
	public static function display_event_date( $event_date_start, $event_date_end ) {

		if ( empty( $event_date_start ) ) {
			// No start date so return TBC.
			return 'TBC';
		}

		// turn in to date objects.
		$event_date_start = new DateTime(
			$event_date_start,
			new DateTimeZone( 'America/Los_Angeles' )
		);

		$event_date_end = new DateTime(
			$event_date_end,
			new DateTimeZone( 'America/Los_Angeles' )
		);

		// If no end date, show start date in full.
		if ( ! $event_date_end ) {
			$date = esc_html( $event_date_start->format( 'F j, Y' ) );
		} elseif ( $event_date_start == $event_date_end ) {
			// Start and end are same day.
			$date = esc_html( $event_date_start->format( 'F j, Y' ) );
		} else {
			// If start AND end month the same.
			if ( $event_date_start->format( 'F' ) === $event_date_end->format( 'F' ) ) {
				$date = esc_html( $event_date_start->format( 'F j' ) ) . '-' . esc_html( $event_date_end->format( 'j, Y' ) );
			} else {
				// Show both start and end month.
				$date = esc_html( $event_date_start->format( 'M j' ) ) . ' - ' . esc_html( $event_date_end->format( 'M j, Y' ) );
			}
		}
		return $date;
	}

}
