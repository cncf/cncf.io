<?php
/**
 * Class FeedCache
 *
 * @since 1.0
 */
namespace TwitterFeed\SmashTwitter;

class TweetAggregator {

	/**
	 * @var array
	 */
	private $post_set = array();

	private $upload_dir;

	private $upload_url;

	public function __construct() {

		$upload           = wp_upload_dir();
		$upload_dir       = $upload['basedir'];
		$upload_dir       = trailingslashit( $upload_dir ) . CTF_UPLOADS_NAME;
		$this->upload_dir = $upload_dir;

		$upload_url                = trailingslashit( $upload['baseurl'] ) . CTF_UPLOADS_NAME;
		$this->upload_url          = $upload_url;
		$this->missing_media_found = false;
	}

	public function add( $post_set ) {
		return $this->post_set = array_merge( $this->post_set, $post_set );
	}

	public function db_post_set( $type, $term ) {
		global $wpdb;
		$posts_table_name = $wpdb->prefix . CTF_POSTS_TABLE;
		$feeds_posts_table_name = $wpdb->prefix . CTF_FEEDS_POSTS_TABLE;

		$results = $wpdb->get_results(
			$wpdb->prepare( "SELECT * FROM $posts_table_name as p
					LEFT JOIN $feeds_posts_table_name as f ON p.id = f.id
					WHERE f.type = %s AND f.term = %s ORDER BY p.time_stamp DESC LIMIT 150;", $type, $term ), ARRAY_A );

		return $results;
	}

	public function normalize_db_post_set( $results ) {
		$normalized_set = array();
		foreach ( $results as $result ) {
			if ( ! empty( $result['json_data'] ) ) {
				$post = json_decode( $result['json_data'], true );
				if ( ! empty( $post ) ) {
					$post = self::add_local_image_urls( $post, $result );
				}
				$normalized_set[] = $post;
			}
		}

		return $normalized_set;
	}

	public function add_local_image_urls( $post, $result ) {
		$return     = $post;
		return $return;
		$base_url   = $this->upload_url;
		$resize_url = apply_filters( 'sbr_resize_url', trailingslashit( $base_url ) );

		if ( ! empty( $post['reviewer']['avatar'] ) ) {
			if ( ! empty( $result['avatar_id'] ) && $result['avatar_id'] !== 'error' ) {
				$return['reviewer']['avatar_local'] = $resize_url . $result['avatar_id'] . '.png';
			}
		}

		if ( ! empty( $post['media'] ) ) {
			$sizes = ! empty( $result['sizes'] ) ? json_decode( $result['sizes'] ) : array();
			$i     = 0;
			foreach ( $post['media'] as $single_image ) {
				if ( ! empty( $result['media_id'] ) && $result['media_id'] !== 'error' ) {
					$return['media'][ $i ]['local'] = array();
					$media_id                       = $result['media_id'];
					foreach ( $sizes as $size ) {
						$local_url_for_size                      = $resize_url . $media_id . '-' . $i . '-' . $size . '.jpg';
						$return['media'][ $i ]['local'][ $size ] = $local_url_for_size;
					}
				}
				$i ++;
			}
		}

		return $return;
	}

	public function update_last_requested( $tweet_ids ) {

	}
}
