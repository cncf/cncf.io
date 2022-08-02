<?php
/**
 * Class CTF_Resizer
 *
 * Image resizing and local storage is done when there are no "medium"
 * sized images available from the API. This class handles this process
 * using the raw API data and a list of post IDs that need resizing.
 *
 * @since 3.14
 */
namespace TwitterFeed\Pro;

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class CTF_Resizer {
	/**
	 * @var array
	 */
	private $feed_id;

	private $post_ids_need_resizing;

	/**
	 * @var array
	 */
	private $resized_image_data;

	/**
	 * @var string|null
	 */
	private $upload_dir;

	/**
	 * @var string|null
	 */
	private $upload_url;

	private $resizing_tables_exist;

	private $limit;

	public function __construct( $post_ids_need_resizing = array(), $feed_id = '', $posts = array(), $feed_options = array() ) {
		$this->post_ids_need_resizing = $post_ids_need_resizing;

		$this->feed_id = $feed_id;
		$this->feed_options = $feed_options;

		$this->posts = $posts;

		$image_sizes = array( 700, 350 );

		$this->image_sizes = apply_filters( 'ctf_resized_image_sizes', $image_sizes );

		$upload = wp_upload_dir();
		$upload_dir = $upload['basedir'];
		$upload_dir = trailingslashit( $upload_dir ) . CTF_UPLOADS_NAME;

		$upload_url = trailingslashit( $upload['baseurl'] ) . CTF_UPLOADS_NAME;

		$this->upload_dir = $upload_dir;

		$this->upload_url = $upload_url;

		$this->limit = 200;
	}

	public function get_image_sizes() {
		return $this->image_sizes;
	}

	public function get_new_resized_image_data() {
		return $this->resized_image_data;
	}

	public function do_resizing() {
		$posts_iterated_through = 0;
		$number_resized = 0;
		$number_updated = 0;

		if ( CTF_Resizer::max_resizing_per_time_period_reached() ) {
			return;
		}

		foreach ( $this->posts as $post ) {
			$twitter_api_id = CTF_Parse_Pro::get_tweet_id( $post );

			$in_resizing_array = in_array( $twitter_api_id, $this->post_ids_need_resizing, true );
			if ( $in_resizing_array
				&& $posts_iterated_through < 60
				&& $number_resized < 30) {

				$single_post = new CTF_Post_Record( $post, $this->feed_id );

				if ( ! $single_post->exists_in_posts_table() ) {
					if ( CTF_Resizer::max_total_records_reached() ) {
						CTF_Resizer::delete_least_used_image();
					}
					$single_post->save_new_record();
					$single_post->resize_and_save_image( $this->image_sizes, $this->upload_dir );

					$number_resized++;
				} else {
					if ( ! $single_post->exists_in_feeds_posts_table() ) {
						$single_post->insert_ctf_feeds_posts();
					}
					$number_updated++;
				}

			}

			$posts_iterated_through ++;
		}

	}

	public function single_resize( $url, $new_file_name, $new_size ) {
		$escaped_url = esc_url_raw( $url );
		$response = wp_remote_get( $escaped_url );

		// Check the response code
		$response_code       = wp_remote_retrieve_response_code( $response );
		if ( $response_code !== 200 ) {
			return false;
		}
		$image_editor = wp_get_image_editor( $escaped_url );
		// not uncommon for the image editor to not work using it this way
		if ( ! is_wp_error( $image_editor ) ) {
			$sizes = $image_editor->get_size();

			$image_editor->resize( $new_size, null );
			$quality = apply_filters( 'ctf_local_image_quality', 80, $new_size );
			$image_editor->set_quality( $quality );

			$full_file_name = trailingslashit( $this->upload_dir ) . $new_file_name;

			$saved_image = $image_editor->save( $full_file_name );

			if ( ! $saved_image ) {

				return false;
				/*global $sb_instagram_posts_manager;

				$sb_instagram_posts_manager->add_error( 'image_editor_save', array(
					__( 'Error saving edited image.', 'custom-twitter-feeds' ),
					$full_file_name
				) );*/
			}

			return true;
		}
		return false;
	}

	public static function get_resized_image_data_for_set( $ids_or_feed_id, $args = array() ) {
		global $wpdb;

		$posts_table_name = $wpdb->prefix . CTF_POSTS_TABLE;
		$feeds_posts_table_name = $wpdb->prefix . CTF_FEEDS_POSTS_TABLE;

		if ( is_array( $ids_or_feed_id ) ) {
			$ids = $ids_or_feed_id;

			$id_string = "'" . implode( "','", $ids ) . "'";
			$results = $wpdb->get_results( "
			SELECT p.media_id, p.twitter_id, p.sizes
			FROM $posts_table_name AS p
			WHERE p.twitter_id IN($id_string)
		  	AND p.images_done = 1", ARRAY_A );

			$return = $results;
		} else {
			$feed_id_array = explode( '#', $ids_or_feed_id );
			$feed_id = $feed_id_array[0];
			$limit = isset( $args['limit'] ) ? $args['limit'] : 100;
			$offset = isset( $args['offset'] ) ? $args['offset'] : 0;

			$results = $wpdb->get_results( $wpdb->prepare( "
			SELECT p.media_id, p.twitter_id, p.aspect_ratio, p.sizes
			FROM $posts_table_name AS p
			INNER JOIN $feeds_posts_table_name AS f ON p.id = f.id
			WHERE f.feed_id = %s
		  	AND p.images_done = 1
			ORDER BY p.time_stamp
			DESC LIMIT %d, %d", $feed_id, $offset, (int)$limit ), ARRAY_A );

			$return = $results;
		}


		return $return;
	}

	public static function delete_resizing_table_and_images( $drop_tables = true ) {
		$upload = wp_upload_dir();

		global $wpdb;

		$posts_table_name = $wpdb->prefix . CTF_POSTS_TABLE;
		$feeds_posts_table_name = $wpdb->prefix . CTF_FEEDS_POSTS_TABLE;

		$image_files = glob( trailingslashit( $upload['basedir'] ) . trailingslashit( CTF_UPLOADS_NAME ) . '*'  ); // get all file names

		foreach ( $image_files as $file ) { // iterate files
			if ( is_file( $file ) ) {
				unlink( $file );
			}
		}

		if( $drop_tables === true ){
			//Delete tables
			$wpdb->query( "DROP TABLE IF EXISTS $posts_table_name" );
			$wpdb->query( "DROP TABLE IF EXISTS $feeds_posts_table_name" );
		}else{

			//Empty tables
			$wpdb->query( "TRUNCATE $posts_table_name" );
			$wpdb->query( "TRUNCATE $feeds_posts_table_name" );
		}

		delete_option( 'ctf_local_avatars' );
	}

	public static function create_resizing_table_and_uploads_folder() {
		$upload = wp_upload_dir();

		$upload_dir = $upload['basedir'];
		$upload_dir = trailingslashit( $upload_dir ) . CTF_UPLOADS_NAME;
		if ( ! file_exists( $upload_dir ) ) {
			$created = wp_mkdir_p( $upload_dir );
			if ( $created ) {
				//$this->remove_error( 'upload_dir' );
			} else {
				//$this->add_error( 'upload_dir', array( __( 'There was an error creating the folder for storing resized images.', 'custom-twitter-feeds' ), $upload_dir ) );
			}
		} else {
			//$this->remove_error( 'upload_dir' );
		}
		return ctf_create_database_table();
	}

	public static function delete_least_used_image() {
		global $wpdb;

		$posts_table_name = $wpdb->prefix . CTF_POSTS_TABLE;
		$feeds_posts_table_name = $wpdb->prefix . CTF_FEEDS_POSTS_TABLE;

		$image_sizes = array( 400, 250 );

		$image_sizes = apply_filters( 'ctf_resized_image_sizes', $image_sizes );

		$oldest_posts = $wpdb->get_results( "SELECT * FROM $posts_table_name ORDER BY last_requested ASC LIMIT 1", ARRAY_A );

		$upload = wp_upload_dir();

		foreach ( $oldest_posts as $post ) {
			$api_data = json_decode( $post['json_data'], true );

			$api_post_id = CTF_Parse_Pro::get_tweet_id( $api_data );

			foreach ( $image_sizes as $image_size ) {
				$image_source_set    = CTF_Parse_Pro::get_media_src_set( $api_data );

				$new_file_name       = $api_post_id;
				$i = 0;
				foreach ( $image_source_set as $image_file_to_resize ) {
					if ($i < 4) {
						foreach ( $image_file_to_resize as $resolution => $image_url ) {

							$suffix = $image_size;

							$this_image_file_name = trailingslashit( $upload['basedir'] ) . trailingslashit( CTF_UPLOADS_NAME ) . $new_file_name . '-' . $i . '-' .  $suffix . '.jpg';

							if ( is_file( $this_image_file_name ) ) {
								unlink( $this_image_file_name );
							}

						}
					}

					$i++;
				}

			}

			$wpdb->query( $wpdb->prepare( "DELETE FROM $posts_table_name WHERE id = %d", $post['id'] ) );
			$wpdb->query( $wpdb->prepare( "DELETE FROM $feeds_posts_table_name WHERE record_id = %d", $post['id'] ) );

		}

	}

	public function delete_image( $file ) {
		$this_image_file_name = trailingslashit( $this->upload_dir ) . $file;

		if ( is_file( $this_image_file_name ) ) {
			unlink( $this_image_file_name );
		}
	}

	/**
	 * Calculates how many records are in the database and whether or not it exceeds the limit
	 *
	 * @return bool
	 *
	 * @since 3.14
	 */
	public function max_total_records_reached() {
		global $wpdb;
		$table_name = $wpdb->prefix . CTF_POSTS_TABLE;

		$num_records = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name" );

		if ( !isset( $this->limit ) && (int)$num_records > CTF_MAX_RECORDS ) {
			$this->limit = (int)$num_records - CTF_MAX_RECORDS;
		}

		return ((int)$num_records > CTF_MAX_RECORDS);
	}

	/**
	 * The plugin caps how many new images are created in a 15 minute window to
	 * avoid overloading servers
	 *
	 * @return bool
	 *
	 * @since 3.14
	 */
	public static function max_resizing_per_time_period_reached() {
		global $wpdb;
		$table_name = $wpdb->prefix . CTF_POSTS_TABLE;

		$fifteen_minutes_ago = date( 'Y-m-d H:i:s', time() - 15 * 60 );

		$num_new_records = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE created_on > '$fifteen_minutes_ago'" );

		return ((int)$num_new_records > 100);
	}

	/**
	 * @return bool
	 *
	 * @since 3.14
	 */
	public function image_resizing_disabled() {
		$settings = get_option( 'ctf_options' );

		$disable_resizing = isset( $settings['resizing'] ) ? $settings['resizing'] === 'disabled' : false;

		return $disable_resizing;
	}

	/**
	 * Used to skip image resizing if the tables were never successfully
	 * created
	 *
	 * @return bool
	 *
	 * @since 3.14
	 */
	public function does_resizing_tables_exist() {
		return true;
	}

}
