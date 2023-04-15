<?php
/**
 * Class TweetRepository
 *
 * Aggregates Tweets stored in cache.
 *
 * @since 2.1
 */
namespace TwitterFeed\SmashTwitter;

use TwitterFeed\CtfCache;
use TwitterFeed\Pro\CTF_Feed_Pro;

class TweetRepository
{
	protected $endpoint;

	protected $term;

	protected $cache_id;

	/**
	 * @var TweetAggregator
	 */
	protected $tweet_aggregator;

	/**
	 * @var CtfCache
	 */
	protected $feed_cache;

	protected $tweets;

	protected $header_data;

	public function __construct( $endpoint, $term, TweetAggregator $tweet_aggregator, CtfCache $feed_cache)
	{
		$this->endpoint = $endpoint;

		$this->term = $term;

		$this->tweet_aggregator = $tweet_aggregator;

		$this->feed_cache = $feed_cache;

		$this->cache_id = $term . '_' . $endpoint;

	}

	public function get_errors()
	{
		return $this->statuses['errors'];
	}

	public function set_errors( $errors_array )
	{
		$this->statuses['errors'] = $errors_array;
	}

	public function add_error( $message, $instructions )
	{
		$this->statuses['errors'][] = array(
			'message' => $message,
			'directions' => $instructions
		);
	}

	public function set_tweets($tweets)
	{
		$this->tweets = $tweets;
	}

	public function set_header_data($header_data)
	{
		$this->header_data = $header_data;
	}

	public function get_tweets()
	{
		return $this->tweets;
	}

	public function get_set_cache( $doing_cron_update = false )
	{
		if ( ! $doing_cron_update ) {
			$this->tweets = $this->feed_cache->get_transient( $this->cache_id );
		} else {
			$this->tweets = false;
		}

		// Cache might come as empty or as an empty array string.
		if ( ! $this->tweets ) {
			$this->tweets = $this->update_posts_cache();
			if ( $this->endpoint === 'usertimeline' && ! empty( $this->tweets[0]['user'] ) ) {
				$this->set_header_data( $this->tweets[0]['user'] );
				$this->update_header_cache();
			}
		} else {
			$this->tweets = json_decode( $this->tweets, true );
			$header_data = $this->feed_cache->get_transient( $this->cache_id . '_header' );
			$this->set_header_data( $header_data );
		}

		$this->set_tweets($this->tweets);
	}

	public function update_posts_cache()
	{
		$remote_posts = $this->get_remote_posts();

		if ( isset( $remote_posts[0]['id_str'] ) ) {
			$remote_posts = CTF_Feed_Pro::reduceTweetSetData( $remote_posts );

			$this->cache_single_posts_from_set($remote_posts);
			$posts = $this->posts_from_db();

		} else {
			$this->cache_single_posts_from_set(array());
			$posts = $this->posts_from_db();
		}

		$this->update_cache( $posts );

		return $posts;
	}

	public function posts_from_db() {
		$aggregator = new TweetAggregator();
		$posts = $aggregator->db_post_set( $this->endpoint, $this->term );

		$posts = $aggregator->normalize_db_post_set( $posts );

		return $posts;
	}

	public function update_cache( $posts ) {
		$this->feed_cache->set_transient( $this->cache_id, json_encode( $posts ) );
	}

	public function update_header_cache()
	{
		$this->feed_cache->set_transient( $this->cache_id . '_header', json_encode( $this->header_data ) );
	}

	public function get_remote_posts()
	{
		$ctf_options = get_option( 'ctf_options', array() );

		if ( empty( $ctf_options['site_access_token'] ) ) {
			return array();
		}

		$request = new Request( $this->endpoint, $this->term, array(), $ctf_options['site_access_token'] );

		$response = $request->fetch();

		// Prevent showing fatal error if the site access token is invalid.
		if ( is_wp_error( $response ) ) {
			// @TODO replace with an error.
			return [];
		}

		return $response;
	}

	public function cache_single_posts_from_set( $posts )
	{
		foreach ( $posts as $single_tweet ) {
			$single_post_cache = new SinglePostCache( $single_tweet, $this->endpoint, $this->term );

			if ( ! $single_post_cache->db_record_exists() ) {
				$single_post_cache->store();
			} else {
				if ( ! $single_post_cache->db_record_exists_for_endpoint_and_term() ) {
					$single_post_cache->update_single( true );
				}
			}
		}
	}

	public function get_post_set_page($page = 1)
	{
		$posts = $this->get_posts();

		$max = $this->settings['numPostDesktop'];
		if ($this->settings['numPostTablet'] > $this->settings['numPostDesktop']) {
			$max = $this->settings['numPostTablet'];
		}
		if ($this->settings['numPostMobile'] > $this->settings['numPostTablet']) {
			$max = $this->settings['numPostMobile'];
		}

		$offset = ($page - 1) * $max;
		return is_array( $posts ) ? array_slice($posts, $offset, $max) : [];
	}

	public function is_last_page($page)
	{
		$posts = $this->get_posts();
		$posts_per_page = $this->settings['numPostDesktop'];
		if ($this->settings['numPostTablet'] > $this->settings['numPostDesktop']) {
			$posts_per_page = $this->settings['numPostTablet'];
		}
		if ($this->settings['numPostMobile'] > $this->settings['numPostTablet']) {
			$posts_per_page = $this->settings['numPostMobile'];
		}

		return count($posts) <= ($page * (int) $posts_per_page);
	}
}