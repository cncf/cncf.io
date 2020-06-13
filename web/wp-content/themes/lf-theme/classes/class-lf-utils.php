<?php
/**
 * Utilities
 *
 * Small helpers to improve code and readibility.
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

  /**
   * Utility Class
   *
   * Small helper utilities.
   *
   * @since 1.0.0
   */
class Lf_Utils {

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
	 * Get DateTime object from webinar date and time
	 *
	 * @param object $date Date object.
	 * @param string $time Time.
	 * @param string $time_period AM or PM.
	 * @param string $timezone TZ.
	 */
	public static function get_webinar_date_time( $date, $time, $time_period, $timezone ) {
		if ( ! $date ) {
			return false;
		}

		// time may not be provided for old webinars.
		if ( ! $time ) {
			$time        = '10:00';
			$time_period = 'AM';
			$timezone    = 'PST';
		} else {
			$time = substr( $time, 0, 2 ) . ':' . substr( $time, 2 );
		}

		$dt_date = new DateTime(
			$date . ' ' . $time . ' ' . $time_period,
			new DateTimeZone( str_replace( '-', '/', $timezone ) )
		);

		return isset( $dt_date ) ? $dt_date : false;
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
	public static function display_event_date( $event_date_start, $event_date_end = '' ) {

		if ( empty( $event_date_start ) ) {
			// No start date so return TBC.
			return 'TBC';
		}

		// turn in to date objects.
		$event_date_start = new DateTime(
			$event_date_start,
			new DateTimeZone( 'America/Los_Angeles' )
		);

		if ( ! empty( $event_date_end ) ) {
			$event_date_end = new DateTime(
				$event_date_end,
				new DateTimeZone( 'America/Los_Angeles' )
			);
		}

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

	/**
	 * Display Author if not CNCF.
	 *
	 * @param string  $the_post_id Post ID.
	 * @param boolean $with_class Adds surround tag.
	 */
	public static function display_author( $the_post_id, $with_class = false ) {

		// if no post id or not number, return.
		if ( ! $the_post_id || ! is_integer( $the_post_id ) ) {
			return;
		}

		$author_id = get_post_field( 'post_author', $the_post_id );
		$author    = get_the_author_meta( 'display_name', $author_id );

		// Basic match for CNCF admin user.
		if ( 'CNCF' === $author ) {
			return;
		}

		if ( $with_class ) {
			// Insert with surrounding class icon.
			$author = '<span class="author-name author-icon">By ' . $author . '</span>';
		} else {
			// Insert the author.
			$author = 'By ' . $author;
		}

		return $author;

	}

}
