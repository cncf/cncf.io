<?php
/**
 * Class SinglePostCache
 *
 * @since 1.0
 */
namespace TwitterFeed\SmashTwitter;
class SinglePostCache {

	/**
	 * @var array
	 */
	private $post_data;

	private $storage_data;
	private $endpoint;
	private $term;

	private $posts_table_name;

	private $feeds_posts_table_name;

	public function __construct( $post_data, $endpoint, $term ) {
		$this->post_data = $post_data;

		$this->storage_data = array(
			'media_id'     => '',
			'sizes'        => '[]',
			'aspect_ratio' => 1,
			'images_done'  => 0
		);
		$this->endpoint = $endpoint;

		$this->term = $term;

		global $wpdb;

		$this->posts_table_name = $wpdb->prefix . CTF_POSTS_TABLE;
		$this->feeds_posts_table_name = $wpdb->prefix . CTF_FEEDS_POSTS_TABLE;
	}

	public function get_storage_data() {
		return $this->storage_data;
	}

	public function get_post_data() {
		return $this->post_data;
	}

	public function set_storage_data( $key, $value ){
		return $this->storage_data[ $key ] = $value;
	}

	public function db_record_exists() {
		$feed_id_match = $this->db_record();
		if ( ! empty( $feed_id_match ) ) {
			$this->storage_data['id'] = $feed_id_match['id'];

			$this->storage_data['media_id'] = $feed_id_match['media_id'];
			$this->storage_data['sizes'] = $feed_id_match['sizes'];
			$this->storage_data['aspect_ratio'] = $feed_id_match['aspect_ratio'];
			$this->storage_data['images_done'] = $feed_id_match['images_done'];
			$this->storage_data['json_data'] = $feed_id_match['json_data'];
		}
		return null !== $feed_id_match;
	}

	public function db_record_exists_for_endpoint_and_term() {
		global $wpdb;
		$feeds_posts_table_name    = $this->feeds_posts_table_name;

		if( isset( $this->post_data['id_str'] ) ){
			$feed_id_match = $wpdb->get_results( $wpdb->prepare(
				"SELECT * FROM $feeds_posts_table_name
                        WHERE id = %s AND type = %s and term = %s LIMIT 1", $this->storage_data['id'], $this->endpoint, $this->term ), ARRAY_A );

			if ( ! empty( $feed_id_match[0] ) ) {
				return $feed_id_match[0];
			}
		}

		return null;
	}

	public function db_record() {
		global $wpdb;
		$table_name    = $this->posts_table_name;
		if( isset( $this->post_data['id_str'] ) ){
			$feed_id_match = $wpdb->get_results( $wpdb->prepare(
				"SELECT * FROM $table_name
                        WHERE twitter_id = %s LIMIT 1", $this->post_data['id_str'] ), ARRAY_A );

			if ( ! empty( $feed_id_match[0] ) ) {
				return $feed_id_match[0];
			}
		}

		return null;
	}

	public function store() {

		$to_store = array(
			array( 'twitter_id', $this->post_data['id_str'], '%s' ),
			array( 'created_on', date( 'Y-m-d H:i:s' ), '%s' ),
			array( 'last_requested', date( 'Y-m-d H:i:s' ), '%s' ),
			array( 'time_stamp', date('Y-m-d H:i:s', strtotime( $this->post_data['created_at'] ) ), '%s' ),
			array( 'json_data', json_encode( $this->post_data ), '%s' ),
			array( 'media_id', '', '%s' ),
			array( 'sizes', '{}', '%s' ),
			array( 'aspect_ratio', 1, '%d' ),
			array( 'images_done', 0, '%d' ),
		);
		$data = array();
		$format = array();
		foreach ( $to_store as $single_store ) {
			$data[ $single_store[0] ] = $single_store[1];
			$format[] = $single_store[2];
		}

		global $wpdb;
		$table_name = $this->posts_table_name;
		$error      = $wpdb->insert( $table_name, $data, $format );

		if ( $error !== false ) {
			$insert_id = $wpdb->insert_id;
			$to_store = array(
				array( 'id', $insert_id, '%s' ),
				array('feed_id', $this->term . '_' . $this->endpoint, '%s'),
				array('type', $this->endpoint, '%s'),
				array('term', $this->term, '%s'),
			);
			$data = array();
			$format = array();
			foreach ( $to_store as $single_store ) {
				$data[ $single_store[0] ] = $single_store[1];
				$format[] = $single_store[2];
			}

			$table_name = $this->feeds_posts_table_name;
			$error      = $wpdb->insert( $table_name, $data, $format );

		} else {
			// log error
		}

	}

    public function update_single( $insert_feeds_posts )
    {
        $to_store = array(
            array('time_stamp', date('Y-m-d H:i:s', strtotime( $this->post_data['created_at'] ) ), '%s'),
            array('last_requested', date('Y-m-d H:i:s'), '%s'),
        );
        $data = array();
        $format = array();
        foreach ($to_store as $single_store) {
            $data[$single_store[0]] = $single_store[1];
            $format[] = $single_store[2];
        }

        global $wpdb;
        $table_name = $this->posts_table_name;
        $where = array();
        $where_format = array();
        $where['twitter_id'] = $this->post_data['id_str'];
        $where_format[] = '%s';

        $error = $wpdb->update($table_name, $data, $where, $format, $where_format);

		if ( $insert_feeds_posts ) {
			$to_store = array(
				array('id', $this->storage_data['id'], '%s'),
				array('feed_id', $this->term . '_' . $this->endpoint, '%s'),
				array('type', $this->endpoint, '%s'),
				array('term', $this->term, '%s'),
			);
			$data = array();
			$format = array();
			foreach ($to_store as $single_store) {
				$data[$single_store[0]] = $single_store[1];
				$format[] = $single_store[2];
			}
			$error = $wpdb->insert($this->feeds_posts_table_name, $data, $format);

		}

        if ($error !== false) {
            $insert_id = $wpdb->insert_id;
        } else {
            // log error
        }
    }
}
