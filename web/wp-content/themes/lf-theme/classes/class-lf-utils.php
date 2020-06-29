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

	/**
	 * Custom responsive images.
	 *
	 * When WordPress generates the srcset attribute, it will only include images that match the same aspect ratio of the src image.
	 *
	 * @param int    $image_id image ID.
	 * @param string $image_size thumbnail name.
	 * @param string $max_width width with unit.
	 * @param string $class_name class to apply to img tag.
	 */
	public static function display_responsive_images( $image_id, $image_size, $max_width, $class_name = '' ) {

		// if no image id or not number, return.
		if ( ! $image_id || ! is_integer( $image_id ) ) {
			return;
		}

		// Get the default src image size.
		$image_src = wp_get_attachment_image_url( $image_id, $image_size );

		// Get the srcset with various image sizes.
		$image_srcset = wp_get_attachment_image_srcset( $image_id, $image_size );

		if ( $class_name ) {
			$class_name = rtrim( esc_html( $class_name ) );
		}

		if ( ! $image_srcset ) {

			$img           = '<img class="' . $class_name . '"  src="' . $image_src . '">';
			$img_meta      = wp_get_attachment_metadata( $image_id );
			$attachment_id = $image_id;
			$html          = wp_image_add_srcset_and_sizes( $img, $img_meta, $attachment_id );

		} else {

			$html = '<img class="' . $class_name . '" src="' . $image_src . '" srcset="' . $image_srcset . '" sizes="(max-width: ' . $max_width . ') 100vw, ' . $max_width . '">';

		}

		echo wp_kses(
			$html,
			array(
				'img' => array(
					'src'    => true,
					'srcset' => true,
					'sizes'  => true,
					'class'  => true,
					'id'     => true,
					'width'  => true,
					'height' => true,
					'alt'    => true,
					'align'  => true,
					'style'  => true,
				),
			)
		);

		return $html;
	}

	/**
	 * Get image alt text.
	 *
	 * @param int $image_id image ID.
	 */
	public static function get_img_alt( $image_id ) {

		if ( ! wp_attachment_is_image( $image_id ) ) {
			return false;
		}
		$img_alt_text = trim( strip_tags( get_post_meta( $image_id, '_wp_attachment_image_alt', true ) ) );

		return $img_alt_text;
	}

	/**
	 * Get src of each image.
	 *
	 * @param int   $image_id image ID.
	 * @param array $sizes_array Array of sizes.
	 */
	public static function get_picture_srcsets( $image_id, $sizes_array ) {

		if ( ! wp_attachment_is_image( $image_id ) ) {
			return false;
		}
		$arr = array();
		foreach ( $sizes_array as $size => $type ) {
			$image_src = wp_get_attachment_image_src( $image_id, $type );

			$arr[] = '<source srcset="' . $image_src[0] . '" media="(min-width: ' . $size . 'px)">';

		}
		return implode( array_reverse( $arr ) );
	}

	/**
	 * Generate Picture element.
	 *
	 * @param int    $image_id image ID.
	 * @param array  $sizes_array array of image sizes.
	 * @param string $class_name Class to apply.
	 */
	public static function display_picture( $image_id, $sizes_array = 'default', $class_name = '' ) {

		// if no image id or not number, return.
		if ( ! $image_id || ! is_integer( $image_id ) || ! wp_attachment_is_image( $image_id ) ) {
			return;
		}

		if ( 'hero' === $sizes_array ) {
			$mappings = array(
				'0'    => 'hero-320',
				'375'  => 'hero-375',
				'414'  => 'hero-414',
				'600'  => 'hero-600',
				'768'  => 'hero-768',
				'1024' => 'hero-1024',
				'1200' => 'hero-1200',
				'1440' => 'hero-1440',
				'1920' => 'hero-1920',
				'2560' => 'hero-2560',
			);
		} else {
			// default WordPress sizes.
			$mappings = array(
				'0'    => 'thumbnail',
				'300'  => 'medium',
				'768'  => 'medium_large',
				'1024' => 'large',
				'1400' => 'full',
			);
		}

		$img = wp_get_attachment_image_src( $image_id, $mappings[0] );
		if ( $class_name ) {
			$class_name = rtrim( esc_html( $class_name ) );
		}
		$html = '<picture>' . self::get_picture_srcsets( $image_id, $mappings ) . '
		<img src="' . $img[0] . '" class="' . $class_name . '" alt="' . self::get_img_alt( $image_id ) . '">
		</picture>';

		$allowed_elements = array(
			'src'    => true,
			'srcset' => true,
			'sizes'  => true,
			'class'  => true,
			'id'     => true,
			'width'  => true,
			'height' => true,
			'alt'    => true,
			'align'  => true,
			'style'  => true,
		);

		echo wp_kses(
			$html,
			array(
				'source'  => $allowed_elements,
				'picture' => $allowed_elements,
				'img'     => $allowed_elements,
			)
		);

		return $html;
	}

}
