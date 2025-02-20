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
class LF_Utils {

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
		} elseif ( false !== stripos( $url, 'https://youtube.com/live/' ) ) {
			$video_id = substr( $url, 25, 11 );
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
	 * Get Terms and Extract Slugs.
	 *
	 * @param integer $post_id Post ID.
	 * @param string  $taxonomy Taxonomy name.
	 * @param boolean $first_only To show only first result.
	 */
	public static function get_term_slugs( $post_id, $taxonomy, $first_only = false ) {

		if ( ! is_integer( $post_id ) || ! is_string( $taxonomy ) ) {
			return false;
		}

		$terms = get_the_terms( $post_id, $taxonomy );

		if ( empty( $terms ) || is_wp_error( $terms ) ) {
			return false;
		}

		if ( $first_only ) {
			$term   = array_shift( $terms );
			$result = $term->slug;
		} else {
			$result = join( ', ', wp_list_pluck( $terms, 'slug' ) );
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

		if ( 1 === $number ) {
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
			// Start and end are same day.
		} elseif ( $event_date_start == $event_date_end ) {
			$date = esc_html( $event_date_start->format( 'F j, Y' ) );
			// If start AND end month the same.
		} elseif ( $event_date_start->format( 'F' ) === $event_date_end->format( 'F' ) ) {
			$date = esc_html( $event_date_start->format( 'F j' ) ) . '-' . esc_html( $event_date_end->format( 'j, Y' ) );
			// Show both start and end month.
		} else {
			$date = esc_html( $event_date_start->format( 'M j' ) ) . ' - ' . esc_html( $event_date_end->format( 'M j, Y' ) );
		}
		return $date;
	}

	/**
	 * Display Author or Guest Author.
	 *
	 * @param number $the_post_id Post ID.
	 */
	public static function display_author( $the_post_id ) {

		// if no post id or not number, return.
		if ( ! $the_post_id || ! is_integer( $the_post_id ) ) {
			return;
		}

		$author = get_post_meta( get_the_ID(), 'lf_post_guest_author', true );

		if ( ! $author ) {
			// Authors we don't want to show a byline for.
			$authors_to_ignore = array( 3049, 3047, 2910, 3051, 3102, 3299 );
			$author_id         = get_post_field( 'post_author', $the_post_id );

			if ( in_array( $author_id, $authors_to_ignore, false ) ) {
				return;
			}

			$author = get_the_author_meta( 'display_name', $author_id );
		}

		// Basic match for admin user.
		if ( 'CNCF' === $author || 'admin' === $author ) {
			return;
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
	 * @param string $loading add lazy load attribute.
	 * @param string $alt alt text to use / override.
	 */
	public static function display_responsive_images( $image_id, $image_size, $max_width, $class_name = '', $loading = 'lazy', $alt = '' ) {

		// if no image id or not number, return.
		if ( ! $image_id ) {
			return;
		}

		if ( ! is_numeric( $image_id ) ) {
			return;
		}

		// Get the default src image size.
		$image_src = wp_get_attachment_image_url( $image_id, $image_size );

		// Get the srcset with various image sizes.
		$image_srcset = wp_get_attachment_image_srcset( $image_id, $image_size );

		// get the default size of the passed image sized.
		$size = wp_get_attachment_image_src( $image_id, $image_size );

		if ( $class_name ) {
			$class_name = rtrim( esc_html( $class_name ) );
		}

		if ( $alt ) {
			$alt_text = trim( esc_attr( wp_strip_all_tags( $alt ) ) );
		} else {
			$alt_text = self::get_img_alt( $image_id );
		}

		if ( $image_srcset ) {
			$fetchpriority = ( 'eager' === $loading ) ? ' fetchpriority="high"' : '';

			$html = '<img width="' . $size[1] . '" height="' . $size[2] . '" loading="' . $loading . '" decoding="async" class="' . $class_name . '" src="' . $image_src . '" srcset="' . $image_srcset . '" sizes="(max-width: ' . $max_width . ') 100vw, ' . $max_width . '"' . $fetchpriority . ' alt="' . $alt_text . '">';

		} else {
			$attributes = array(
				'loading="' . $loading . '"',
				'class="' . $class_name . '"',
				'src="' . $image_src . '"',
				'alt="' . $alt_text . '"',
			);

			if ( 'eager' === $loading ) {
				$attributes[] = 'fetchpriority="high"';
			}

			$width  = (int) $size[1] ?? null;
			$height = (int) $size[2] ?? null;

			if ( $width ) {
				$attributes[] = 'width="' . $width . '"';
			}

			if ( $height ) {
				$attributes[] = 'height="' . $height . '"';
			}

			$img           = '<img decoding="async" ' . implode( ' ', $attributes ) . '>';
			$img_meta      = wp_get_attachment_metadata( $image_id );
			$attachment_id = $image_id;
			$html          = wp_image_add_srcset_and_sizes( $img, $img_meta, $attachment_id );
		}

		echo wp_kses(
			$html,
			array(
				'img' => array(
					'src'      => true,
					'srcset'   => true,
					'sizes'    => true,
					'class'    => true,
					'id'       => true,
					'width'    => true,
					'height'   => true,
					'alt'      => true,
					'align'    => true,
					'style'    => true,
					'media'    => true,
					'loading'  => true,
					'decoding' => true,
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
		$img_alt_text = trim( wp_strip_all_tags( get_post_meta( $image_id, '_wp_attachment_image_alt', true ) ) );

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
				'2880' => 'hero-2880',
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
	<img src="' . $img[0] . '" decoding="async" class="' . $class_name . '" alt="' . self::get_img_alt( $image_id ) . '">
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
			'media'  => true,
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

	/**
	 * Retrieve homepage metrics from devstats and LFX.
	 */
	public static function get_homepage_metrics() {
		$metrics = get_transient( 'cncf_homepage_metrics' );

		if ( false === $metrics ) {

			// default values in case of failure.
			$metrics = array(
				'contributors'  => 143000,
				'contributions' => 7300000,
				'countries'     => 185,
				'projects'      => 117,
			);

			$data = wp_remote_post(
				'https://devstats.cncf.io/api/v1',
				array(
					'headers'     => array( 'Content-Type' => 'application/json; charset=utf-8' ),
					'body'        => '{"api":"SiteStats","payload":{"project":"all"}}',
					'method'      => 'POST',
					'data_format' => 'body',
				)
			);

			if ( is_wp_error( $data ) || ( wp_remote_retrieve_response_code( $data ) !== 200 ) ) {
				return $metrics;
			}

			$remote_body              = json_decode( wp_remote_retrieve_body( $data ) );
			$metrics['contributors']  = $remote_body->contributors;
			$metrics['contributions'] = $remote_body->contributions;
			$metrics['countries']     = $remote_body->countries;

			$args = array(
				'post_type'      => 'lf_project',
				'posts_per_page' => -1,
				'tax_query'      => array(
					array(
						'taxonomy' => 'lf-project-stage',
						'field'    => 'slug',
						'terms'    => array( 'graduated', 'incubating', 'sandbox' ),
						'operator' => 'IN',
					),
				),
				'fields'         => 'ids', // Only retrieve post IDs to minimize memory usage.
			);

			$query               = new WP_Query( $args );
			$metrics['projects'] = $query->found_posts;
			wp_reset_postdata();

			if ( WP_DEBUG === false ) {
				set_transient( 'cncf_homepage_metrics', $metrics, DAY_IN_SECONDS );
			}
		}
		return $metrics;
	}

	/**
	 * Get project data used on home page.
	 *
	 * @return array
	 */
	public static function get_homepage_project_metrics() {
		$query_args = array(
			'post_type'      => 'lf_project',
			'post_status'    => array( 'publish' ),
			'posts_per_page' => 500,
		);

		$project_query = new WP_Query( $query_args );

		$graduated_count   = 0;
		$incubating_count  = 0;
		$sandbox_count     = 0;
		$all_project_logos = array();

		if ( $project_query->have_posts() ) {
			while ( $project_query->have_posts() ) {
				$project_query->the_post();
				$stacked_logo_url = get_post_meta( get_the_ID(), 'lf_project_logo', true );
				if ( has_term( 'graduated', 'lf-project-stage', get_the_ID() ) ) {
					++$graduated_count;
					if ( $stacked_logo_url ) {
						$all_project_logos[] = array(
							'title' => get_the_title(),
							'logo'  => $stacked_logo_url,
							'url'   => get_the_permalink(),
						);
					}
				} elseif ( has_term( 'incubating', 'lf-project-stage', get_the_ID() ) ) {
					++$incubating_count;
					if ( $stacked_logo_url ) {
						$all_project_logos[] = array(
							'title' => get_the_title(),
							'logo'  => $stacked_logo_url,
							'url'   => get_the_permalink(),
						);
					}
				} elseif ( has_term( 'sandbox', 'lf-project-stage', get_the_ID() ) ) {
					++$sandbox_count;
				}
			}
		}

		$project_metrics = array(
			'graduated_count'  => $graduated_count,
			'incubating_count' => $incubating_count,
			'sandbox_count'    => $sandbox_count,
			'project_data'     => $all_project_logos,
		);

		wp_reset_postdata();

		return $project_metrics;
	}

	/**
	 * Retrieve metrics for Who We Are page block.
	 */
	public static function get_whoweare_metrics() {
		$metrics = get_transient( 'cncf_whoweare_metrics' );

		if ( false === $metrics ) {
			$metrics                      = self::get_homepage_metrics();
			$metrics['cncf-members']      = 630;
			$metrics['community-members'] = 630;

			$options           = get_option( 'lf-mu' );
			$community_api_key = $options['community_api_key'] ?? '';

			if ( ! $community_api_key ) {
				return $metrics;
			}

			$args = array(
				'headers' => array(
					'Authorization' => 'Token ' . $community_api_key,
				),
			);
			$data = wp_remote_get( 'https://community.cncf.io/api/user/counts', $args );
			if ( is_wp_error( $data ) || ( wp_remote_retrieve_response_code( $data ) !== 200 ) ) {
				return $metrics;
			}
			$remote_body                  = json_decode( wp_remote_retrieve_body( $data ) );
			$metrics['community-members'] = $remote_body->User; //phpcs:ignore.

			$data = wp_remote_get( 'https://landscape.cncf.io/api/members/count.json' );
			if ( is_wp_error( $data ) || ( wp_remote_retrieve_response_code( $data ) !== 200 ) ) {
				return $metrics;
			}

			$remote_body             = json_decode( wp_remote_retrieve_body( $data ) );
			$metrics['cncf-members'] = $remote_body->count;

			if ( WP_DEBUG === false ) {
				set_transient( 'cncf_whoweare_metrics', $metrics, DAY_IN_SECONDS );
			}
		}
		return $metrics;
	}

	/**
	 * Retrieve Tech Radars data.
	 */
	public static function get_tech_radars() {

		$tech_radars = get_transient( 'tech_radars' );

		if ( false === $tech_radars ) {

			$request = wp_remote_get( 'https://radar.cncf.io/radars.json' );

			if ( is_wp_error( $request ) || ( wp_remote_retrieve_response_code( $request ) !== 200 ) ) {
				return;
			}
			$tech_radars = wp_remote_retrieve_body( $request );

			if ( WP_DEBUG === false ) {
				set_transient( 'tech_radars', $tech_radars, 12 * HOUR_IN_SECONDS );
			}
		}
		return json_decode( $tech_radars );
	}

	/**
	 * Get Ambassadors and HOCN profiles
	 *
	 * Returns random array of Ambassadors and HOCN people.
	 * Array contains [url to image of person, url to link to person] for each entry.
	 * Phippy characters inserted for fun at position [0] and [6].
	 */
	public static function get_teamcloudnative() {
		global $post;

		$ambassadors = array();

		$args           = array(
			'post_type'      => 'lf_person',
			'posts_per_page' => 5,
			'no_found_rows'  => true,
			'orderby'        => 'rand',
			'post_status'    => array( 'publish' ),
			'tax_query'      => array(
				array(
					'taxonomy' => 'lf-person-category',
					'field'    => 'slug',
					'terms'    => 'ambassadors',
				),
			),
		);
		$query          = new WP_Query( $args );
		$ambassador_url = home_url( 'people/ambassadors' );
		while ( $query->have_posts() ) {

			$query->the_post();
			$person_title        = $post->post_title;
			$person_slug         = $post->post_name;
			$person_image_url    = get_post_meta( get_the_ID(), 'lf_person_image', true );
			$person_profile_link = $ambassador_url . '/?p=' . $person_slug;

			$ambassadors[] = array(
				'title' => $person_title,
				'image' => $person_image_url,
				'link'  => $person_profile_link,
			);
		}

		$hocn_people = array();

		$args  = array(
			'post_type'      => 'lf_human',
			'posts_per_page' => 15,
			'no_found_rows'  => true,
			'orderby'        => 'rand',
			'post_status'    => array( 'publish' ),
			'meta_query'     => array(
				array(
					'key'     => 'lf_human_image',
					'value'   => '0',
					'compare' => '>',
				),
			),
		);
		$query = new WP_Query( $args );
		while ( $query->have_posts() ) {
			$query->the_post();
			$person_title     = $post->post_title;
			$person_image_url = wp_get_attachment_image_src( get_post_meta( get_the_ID(), 'lf_human_image', true ), 'newsroom-post-width' )[0];

			$person_profile_link = get_post_meta( get_the_ID(), 'lf_human_post_url', true );
			if ( ! $person_profile_link ) {
				$person_profile_link = get_permalink();
			}

			$hocn_people[] = array(
				'title' => $person_title,
				'image' => $person_image_url,
				'link'  => $person_profile_link,
			);
		}

		$phippy = array(
			'title' => 'Phippy',
			'image' => get_template_directory_uri() . '/images/home-ambassador-phippy.jpg',
			'link'  => home_url( 'phippy' ),
		);

		$tiago = array(
			'title' => 'Tiago',
			'image' => get_template_directory_uri() . '/images/home-ambassador-tiago.jpg',
			'link'  => home_url( 'phippy' ),
		);

		// Add Ambassadors to end of HOCN people.
		$people = array_merge( $hocn_people, $ambassadors );

		// Insert Phippy at 4th spot (for initial display).
		array_splice( $people, 3, 0, array( $phippy ) );

		// Add Tiago to array.
		array_push( $people, $tiago );

		return $people;
	}

	/**
	 * Partition an array
	 *
	 * @param array   $array Items.
	 * @param integer $size Number of partitions required.
	 */
	public static function partition( $array, $size ) {
		$list_length = count( $array );
		$size_len    = floor( $list_length / $size );
		$size_rem    = $list_length % $size;
		$partition   = array();
		$mark        = 0;
		for ( $px = 0; $px < $size; $px++ ) {
			$incr             = ( $px < $size_rem ) ? $size_len + 1 : $size_len;
			$partition[ $px ] = array_slice( $array, $mark, $incr );
			$mark            += $incr;
		}
		return $partition;
	}

	/**
	 * Grab SVG from images folder
	 *
	 * Grabs an SVG from within the theme /images/ folder and outputs it. Add true for path.
	 *
	 * @since 1.0.0
	 *
	 * @see class/Image
	 *
	 * @param string  $file Filename relative to images directory.
	 * @param boolean $path Set true to return string for image.
	 */
	public static function get_svg( $file, $path = false ) {

		if ( $path ) {
			$output = get_stylesheet_directory_uri() . '/images/' . $file;
			echo esc_url( $output );
		} else {
			$abs_path = get_stylesheet_directory() . '/images/' . $file;
			if ( file_exists( $abs_path ) ) {
				ob_start();
				include $abs_path;
				$output = ob_get_contents();
				ob_end_clean();
				echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}
	}

	/**
	 * Grab image from theme
	 *
	 * Grabs an image from the specified URL, this is mainly used for images from the media library that are not base64 or SVGs.
	 *
	 * @since 1.0.0
	 *
	 * @see class/Image
	 *
	 * @param string $file Filename relative to images directory.
	 */
	public static function get_image( $file ) {
		$output = '';
		$output = get_stylesheet_directory_uri() . '/images/' . $file;
		echo esc_url( $output );
	}

	/**
	 * Wrap arrays utility.
	 *
	 * @param array $value Wrap in an array.
	 */
	public static function wrap( $value ) {
		if ( is_null( $value ) ) {
			return array();
		}

		return is_array( $value ) ? $value : array( $value );
	}

	/**
	 * Merge class names in to one string.
	 *
	 * @param array $array Array of class names.
	 * @return array
	 */
	public static function merge_classes( $array ) {
		$class_list = static::wrap( $array );

		$classes = array();

		foreach ( $class_list as $class => $constraint ) {
			if ( is_numeric( $class ) ) {
				$classes[] = $constraint;
			} elseif ( $constraint ) {
				$classes[] = $class;
			}
		}

		return rtrim( implode( ' ', $classes ) );
	}
}
