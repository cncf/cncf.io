<?php
/**
 * Class SB_Instagram_Feed
 *
 * Retrieves data and generates the html for each feed. The
 * "display_instagram" function in the if-functions.php file
 * is where this class is primarily used.
 *
 * @since 2.0/4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class CTF_Feed_Pro
{
	/**
	 * @var string
	 */
	private $regular_feed_transient_name;

	/**
	 * @var string
	 */
	private $header_transient_name;

	/**
	 * @var string
	 */
	private $backup_feed_transient_name;

	/**
	 * @var string
	 */
	private $backup_header_transient_name;

	/**
	 * @var array
	 */
	private $post_data;

	/**
	 * @var
	 */
	private $header_data;

	/**
	 * @var array
	 */
	private $next_pages;

	/**
	 * @var array
	 */
	private $transient_atts;

	/**
	 * @var int
	 */
	private $last_retrieve;

	/**
	 * @var bool
	 */
	private $should_paginate;

	/**
	 * @var int
	 */
	private $num_api_calls;

	/**
	 * @var array
	 */
	private $image_ids_post_set;

	/**
	 * @var bool
	 */
	private $should_use_backup;

	/**
	 * @var array
	 */
	private $report;

	/**
	 * @var array
	 *
	 * @since 2.1.1/5.2.1
	 */
	private $resized_images;

	/**
	 * @var array
	 *
	 * @since 2.1.3/5.2.3
	 */
	protected $one_post_found;

	private $last_id_data;

	/**
	 * SB_Instagram_Feed constructor.
	 *
	 * @param string $transient_name ID of this feed
	 *  generated in the SB_Instagram_Settings class
	 */
	public function __construct( $transient_name ) {
		$this->regular_feed_transient_name = $transient_name;

		$header_transient_name = str_replace( 'ctf_', 'ctf_header_', $transient_name );
		$header_transient_name = substr($header_transient_name, 0, 44);
		$this->header_transient_name = $header_transient_name;

		$this->post_data = array();
		$this->next_pages = array();
		$this->should_paginate = true;

		// this is a count of how many api calls have been made for each feed
		// type and term.
		// By default the limit is 10
		$this->num_api_calls = 0;
		$this->max_api_calls = 10;
		$this->should_use_backup = false;

		// used for errors and the sbi_debug report
		$this->report = array();

		$this->resized_images = array();

		$this->one_post_found = false;
	}

	/**
	 * @return array
	 *
	 * @since 2.0/5.0
	 */
	public function get_post_data() {
		return $this->post_data;
	}

	/**
	 * @return array
	 *
	 * @since 2.0/5.0
	 */
	public function set_post_data( $post_data ) {
		$this->post_data = $post_data;
	}

	/**
	 * @return array
	 *
	 * @since 2.1.1/5.2.1
	 */
	public function set_resized_images( $resized_image_data ) {
		$this->resized_images = $resized_image_data;
	}

	/**
	 * @return array
	 *
	 * @since 2.0/5.0
	 */
	public function get_next_pages() {
		return $this->next_pages;
	}

	/**
	 * @return array
	 *
	 * @since 2.1.1/5.2.1
	 */
	public function get_resized_images() {
		return $this->resized_images;
	}

	/**
	 * Checks the database option related the transient expiration
	 * to ensure it will be available when the page loads
	 *
	 * @return bool
	 *
	 * @since 2.0/4.0
	 */
	public function regular_cache_exists() {
		//Check whether the cache transient exists in the database and is available for more than one more minute
		if ( strpos( $this->regular_feed_transient_name, 'ctf_!' ) !== false ) {
			$transient_exists = get_option( $this->regular_feed_transient_name );
		} else {
			$transient_exists = get_transient( $this->regular_feed_transient_name );
		}

		return $transient_exists;
	}

	/**
	 * Checks the database option related the header transient
	 * expiration to ensure it will be available when the page loads
	 *
	 * @return bool
	 *
	 * @since 2.0/5.0
	 */
	public function regular_header_cache_exists() {
		$header_transient = get_transient( $this->header_transient_name );

		return $header_transient;
	}

	/**
	 * @return bool
	 *
	 * @since 2.0/5.0
	 */
	public function should_use_backup() {
		return $this->should_use_backup || empty( $this->post_data );
	}

	/**
	 * The header is only displayed when the setting is enabled and
	 * an account has been connected
	 *
	 * Overwritten in the Pro version
	 *
	 * @param array $settings settings specific to this feed
	 * @param array $feed_types_and_terms organized settings related to feed data
	 *  (ex. 'user' => array( 'smashballoon', 'custominstagramfeed' )
	 *
	 * @return bool
	 *
	 * @since 2.0/5.0
	 */
	public function need_header( $settings, $feed_types_and_terms ) {
		$showheader = ($settings['showheader'] === 'on' || $settings['showheader'] === 'true' || $settings['showheader'] === true);
		return ($showheader && isset( $feed_types_and_terms['users'] ));
	}

	/**
	 * Use the transient name to retrieve cached data for header
	 *
	 * @since 2.0/5.0
	 */
	public function set_header_data_from_cache() {
		$header_cache = get_transient( $this->header_transient_name );

		$header_cache = json_decode( $header_cache, true );

		if ( ! empty( $header_cache ) ) {
			$this->header_data = $header_cache;
		}
	}

	public function set_header_data( $header_data ) {
		$this->header_data = $header_data;
	}

	/**
	 * @since 2.0/5.0
	 */
	public function get_header_data() {
		return $this->header_data;
	}

	/**
	 * Sets the post data, pagination data, shortcode atts used (cron cache),
	 * and timestamp of last retrieval from transient (cron cache)
	 *
	 * @param array $atts available for cron caching
	 *
	 * @since 2.0/5.0
	 */
	public function set_post_data_from_cache( $atts = array() ) {
		if ( strpos( $this->regular_feed_transient_name, 'ctf_!' ) !== false ) {
			$transient_data = get_option( $this->regular_feed_transient_name );
		} else {
			$transient_data = get_transient( $this->regular_feed_transient_name );

		}

		$transient_data = json_decode( $transient_data, true );

		if ( $transient_data ) {
			$post_data = isset( $transient_data['data'] ) ? $transient_data['data'] : array();
			if ( empty( $post_data ) ) {
				$post_data = isset( $transient_data[0]['id_str'] ) ? $transient_data : array();
			}
			$this->post_data = $post_data;
			$this->next_pages = isset( $transient_data['pagination'] ) ? $transient_data['pagination'] : array();

			if ( isset( $transient_data['atts'] ) ) {
				$this->transient_atts = $transient_data['atts'];
				$this->last_retrieve = $transient_data['last_retrieve'];
			}
		}
	}

	/**
	 * Checks to see if there are enough posts available to create
	 * the current page of the feed
	 *
	 * @param int $num
	 * @param int $offset
	 *
	 * @return bool
	 *
	 * @since 2.0/5.0
	 */
	public function need_posts( $num, $offset = 0 ) {
		$num_existing_posts = is_array( $this->post_data ) ? count( $this->post_data ) : 0;
		$num_needed_for_page = (int)$num + (int)$offset;

		($num_existing_posts < $num_needed_for_page) ? $this->add_report( 'need more posts' ) : $this->add_report( 'have enough posts' );

		return ($num_existing_posts < $num_needed_for_page);
	}

	/**
	 * Checks to see if there are additional pages available for any of the
	 * accounts in the feed and that the max conccurrent api request limit
	 * has not been reached
	 *
	 * @return bool
	 *
	 * @since 2.0/5.0
	 */
	public function can_get_more_posts() {
		$one_type_and_term_has_more_ages = $this->next_pages !== false;
		$max_concurrent_api_calls_not_met = $this->num_api_calls < $this->max_api_calls;
		$max_concurrent_api_calls_not_met ? $this->add_report( 'max conccurrent requests not met' ) : $this->add_report( 'max concurrent met' );
		$one_type_and_term_has_more_ages ? $this->add_report( 'more pages available' ) : $this->add_report( 'no next page' );

		return ($one_type_and_term_has_more_ages && $max_concurrent_api_calls_not_met);
	}

	/**
	 * Appends one filtered API request worth of posts for each feed term
	 *
	 * @param $settings
	 * @param array $feed_types_and_terms organized settings related to feed data
	 *  (ex. 'user' => array( 'smashballoon', 'custominstagramfeed' )
	 * @param array $connected_accounts_for_feed connected account data for the
	 *  feed types and terms
	 *
	 * @since 2.0/5.0
	 * @since 2.0/5.1 added logic to make a second attempt at an API connection
	 * @since 2.0/5.1.2 remote posts only retrieved if API requests are not
	 *  delayed, terms shuffled if there are more than 5
	 * @since 2.2/5.3 added logic to refresh the access token for basic display
	 *  accounts if needed before using it in an API request
	 */
	public function add_remote_posts( $settings, $feed_types_and_terms ) {
		$new_post_sets = array();
		$next_pages = $this->next_pages;

		/**
		 * Number of posts to retrieve in each API call
		 *
		 * @param int               Minimum number of posts needed in each API request
		 * @param array $settings   Settings for this feed
		 *
		 * @since 2.0/5.0
		 */
		$num = apply_filters( 'ctf_num_in_request', $settings['apinum'], $settings );

		if ( ! $settings['includereplies'] && ! $settings['selfreplies'] ) {
			$num = min( 200, $num * 3 );
		}

		$one_successful_connection = false;
		$one_post_found = false;
		$next_page_found = false;
		$one_api_request_delayed = false;

		foreach ( $feed_types_and_terms as $type => $terms ) {
			if ( is_array( $terms ) && count( $terms ) > 5 ) {
				shuffle( $terms );
			}
			foreach ( $terms as $term_and_params ) {
				$params = array(
					'count' => $num
				);
				$this->add_report( 'num ' . $num );

				$term = $term_and_params['term'];
				$params = array_merge( $params, $term_and_params['params'] );

				if ( ! empty( $next_pages[ $term . '_' . $type ] ) ) {
					$params['count'] = min( $params['count'] + 1, 200 );
					$params['max_id'] = $next_pages[ $term . '_' . $type ];
				}

				$params['tweet_mode'] = 'extended';

				if ( $type === 'usertimeline' ) {
					if ( ! empty ( $term  ) ) {
						$params['screen_name'] = $term;
					}
					if ( $settings['includereplies'] || $settings['selfreplies'] ) {
						$params['exclude_replies'] = 'false';
					} else {
						$params['exclude_replies'] = 'true';
					}
				}

				if ( $type === 'hometimeline' ) {
					if ( $settings['includereplies'] || $settings['selfreplies'] ) {
						$params['exclude_replies'] = 'false';
					} else {
						$params['exclude_replies'] = 'true';
					}
				}

				if ( $type === 'search' || $type === 'hashtag' ) {
					$params['q'] = $term;
				}

				if ( $type === 'lists' ) {
					if ( ! empty ( $term  ) ) {
						$params['list_id'] = $term;
					}
				}

				if ( $type === 'userslookup' ) {
					if ( ! empty ( $term  ) ) {
						$params['screen_name'] = $term;
					}
				}

				// max_id parameter should only be included for the second set of posts
				$this->num_api_calls++;
				$api_obj = $this->apiConnectionResponse( $params, $type, $settings );
				$raw_tweet_data = json_decode( $api_obj->json , $assoc = true );
				if ( isset( $raw_tweet_data['errors'][0] ) ) {
					if ( empty( $api_obj ) ) {
						$api_obj = new stdClass();
					}
					$api_obj->api_error_no = $raw_tweet_data['errors'][0]['code'];
					$api_obj->api_error_message = $raw_tweet_data['errors'][0]['message'];
					$this->add_report( 'error ' . $api_obj->api_error_no . ' ' . $api_obj->api_error_message );

					$next_pages[ $term . '_' . $type ] = false;
				} else {
					if ( isset( $raw_tweet_data['statuses'] ) ) {
						$raw_tweet_data = $raw_tweet_data['statuses'];
					}

					if ( ! empty( $params['max_id'] ) ) {
						// remove the first tweet as it was returned in the paginated request
						array_shift( $raw_tweet_data );
					}

					if ( count( $raw_tweet_data ) > 0 ) {
						if ( isset( $raw_tweet_data[ count( $raw_tweet_data ) - 1 ] ) ) {
							$last_tweet = $raw_tweet_data[ count( $raw_tweet_data ) - 1 ];
							$this->add_report( 'normal last tweet' );

						} else {
							$last_tweet = $raw_tweet_data[0];
							$this->add_report( 'backup last tweet' );

						}

						$working_tweet_set = CTF_Feed_Pro::reduceTweetSetData( $raw_tweet_data );
						$working_tweet_set = CTF_Feed_Pro::filterTweetSet( $working_tweet_set, $settings );

						if ( count( $working_tweet_set ) > 1 ) {
							$last_tweet = $raw_tweet_data[ count( $working_tweet_set ) - 1 ];
						}
						$next_pages[ $term . '_' . $type ] = CTF_Parse_Pro::get_tweet_id( $last_tweet );

						$new_post_sets[] = $working_tweet_set;
						$one_post_found = true;
						$next_page_found = true;
					} else {
						$this->add_report( 'no raw tweet data' );
						$this->add_report( $api_obj->json );

						$next_pages[ $term . '_' . $type ] = false;
					}
				}
			}
		}



		$posts = $this->merge_posts( $new_post_sets, $settings );

		if ( ! empty( $this->post_data ) && is_array( $this->post_data ) ) {
			$posts = array_merge( $this->post_data, $posts );
		} elseif ( $one_post_found ) {
			$this->one_post_found = true;
		}

		$this->post_data = $posts;

		if ( isset( $next_page_found ) && $next_page_found ) {
			$this->next_pages = $next_pages;
		} else {
			$this->next_pages = false;
		}
	}

	/**
	 * attempts to connect and retrieve tweets from the Twitter api
	 *
	 * @return mixed|string object containing the response
	 */
	public function apiConnectionResponse( $get_fields, $end_point, $settings )
	{
		// Only can be set in the options page
		$request_settings = array(
			'consumer_key' => $settings['consumer_key'],
			'consumer_secret' => $settings['consumer_secret'],
			'access_token' => $settings['access_token'],
			'access_token_secret' => $settings['access_token_secret'],
		);

		include_once( CTF_URL . '/inc/CtfOauthConnect.php' );
		include_once( CTF_URL . '/inc/CtfOauthConnectPro.php' );

		// actual connection
		$twitter_connect = new CtfOauthConnectPro( $request_settings, $end_point );
		$twitter_connect->setUrlBase();
		$twitter_connect->setGetFields( $get_fields );
		$twitter_connect->setRequestMethod( $settings['request_method'] );

		return $twitter_connect->performRequest();
	}

	public static function reduceTweetSetData( $tweets ) {

		$tweet_count = count( $tweets );
		$len = count( $tweets );
		$trimmed_tweets = array();

		foreach ( $tweets as $tweet ) {

			$trimmed_tweet = array();

			$trimmed_tweet['user']['name']                    = $tweet['user']['name'];
			$trimmed_tweet['user']['screen_name']             = $tweet['user']['screen_name'];
			$trimmed_tweet['user']['verified']                = $tweet['user']['verified'];
			$trimmed_tweet['user']['profile_image_url_https'] = $tweet['user']['profile_image_url_https'];
			$trimmed_tweet['user']['utc_offset']              = $tweet['user']['utc_offset'];
			$trimmed_tweet['text']                            = isset( $tweet['text'] ) ? $tweet['text'] : $tweet['full_text'];
			$trimmed_tweet['id_str']                          = $tweet['id_str'];
			$trimmed_tweet['created_at']                      = $tweet['created_at'];
			$trimmed_tweet['retweet_count']                   = $tweet['retweet_count'];
			$trimmed_tweet['favorite_count']                  = $tweet['favorite_count'];

			if ( isset( $tweet['entities']['urls'][0] ) ) {
				foreach ( $tweet['entities']['urls'] as $url ) {
					$trimmed_tweet['entities']['urls'][] = array(
						'url'          => $url['url'],
						'expanded_url' => $url['expanded_url'],
						'display_url'  => $url['display_url'],

					);
				}
			}

			if ( isset( $tweet['retweeted_status'] ) ) {
				$trimmed_tweet['retweeted_status']['user']['name']                    = $tweet['retweeted_status']['user']['name'];
				$trimmed_tweet['retweeted_status']['user']['screen_name']             = $tweet['retweeted_status']['user']['screen_name'];
				$trimmed_tweet['retweeted_status']['user']['verified']                = $tweet['retweeted_status']['user']['verified'];
				$trimmed_tweet['retweeted_status']['user']['profile_image_url_https'] = $tweet['retweeted_status']['user']['profile_image_url_https'];
				$trimmed_tweet['retweeted_status']['user']['utc_offset']              = $tweet['retweeted_status']['user']['utc_offset'];
				$trimmed_tweet['retweeted_status']['text']                            = isset( $tweet['retweeted_status']['text'] ) ? $tweet['retweeted_status']['text'] : $tweet['retweeted_status']['full_text'];
				$trimmed_tweet['retweeted_status']['id_str']                          = $tweet['retweeted_status']['id_str'];
				$trimmed_tweet['retweeted_status']['created_at']                      = $tweet['retweeted_status']['created_at'];
				$trimmed_tweet['retweeted_status']['retweet_count']                   = $tweet['retweeted_status']['retweet_count'];
				$trimmed_tweet['retweeted_status']['favorite_count']                  = $tweet['retweeted_status']['favorite_count'];
				if ( isset( $tweet['retweeted_status']['entities']['urls'][0] ) ) {
					foreach ( $tweet['retweeted_status']['entities']['urls'] as $url ) {
						$trimmed_tweet['retweeted_status']['entities']['urls'][] = array(
							'url'          => $url['url'],
							'expanded_url' => $url['expanded_url'],
							'display_url'  => $url['display_url'],

						);
					}
				}

				if ( isset( $tweet['retweeted_status']['quoted_status'] ) ) {
					$trimmed_tweet['retweeted_status']['quoted_status']['user']['name']        = $tweet['retweeted_status']['quoted_status']['user']['name'];
					$trimmed_tweet['retweeted_status']['quoted_status']['user']['screen_name'] = $tweet['retweeted_status']['quoted_status']['user']['screen_name'];
					$trimmed_tweet['retweeted_status']['quoted_status']['user']['verified']    = $tweet['retweeted_status']['quoted_status']['user']['verified'];
					$trimmed_tweet['retweeted_status']['quoted_status']['user']['profile_image_url_https'] = $tweet['retweeted_status']['quoted_status']['user']['profile_image_url_https'];
					$trimmed_tweet['retweeted_status']['quoted_status']['text']                = isset( $tweet['retweeted_status']['quoted_status']['text'] ) ? $tweet['retweeted_status']['quoted_status']['text'] : $tweet['retweeted_status']['quoted_status']['full_text'];
					$trimmed_tweet['retweeted_status']['quoted_status']['id_str']              = $tweet['retweeted_status']['quoted_status']['id_str'];
					$trimmed_tweet['retweeted_status']['quoted_status']['created_at']          = $tweet['retweeted_status']['quoted_status']['created_at'];
					if ( isset( $tweet['retweeted_status']['quoted_status']['entities']['urls'][0] ) ) {
						foreach ( $tweet['retweeted_status']['quoted_status']['entities']['urls'] as $url ) {
							$trimmed_tweet['retweeted_status']['quoted_status']['entities']['urls'][] = array(
								'url'          => $url['url'],
								'expanded_url' => $url['expanded_url'],
								'display_url'  => $url['display_url'],
							);
						}
					}
				}
			}

			if ( isset( $tweet['quoted_status'] ) ) {
				$trimmed_tweet['quoted_status']['user']['name']        = $tweet['quoted_status']['user']['name'];
				$trimmed_tweet['quoted_status']['user']['screen_name'] = $tweet['quoted_status']['user']['screen_name'];
				$trimmed_tweet['quoted_status']['user']['profile_image_url_https'] = $tweet['quoted_status']['user']['profile_image_url_https'];
				$trimmed_tweet['quoted_status']['user']['verified']    = $tweet['quoted_status']['user']['verified'];
				$trimmed_tweet['quoted_status']['text']                = isset( $tweet['quoted_status']['text'] ) ? $tweet['quoted_status']['text'] : $tweet['quoted_status']['full_text'];
				$trimmed_tweet['quoted_status']['id_str']              = $tweet['quoted_status']['id_str'];
				$trimmed_tweet['quoted_status']['created_at']          = $tweet['quoted_status']['created_at'];
				if ( isset( $tweet['quoted_status']['entities']['urls'][0] ) ) {
					foreach ( $tweet['quoted_status']['entities']['urls'] as $url ) {
						$trimmed_tweet['quoted_status']['entities']['urls'][] = array(
							'url'          => $url['url'],
							'expanded_url' => $url['expanded_url'],
							'display_url'  => $url['display_url'],
						);
					}
				}
			}

			if ( isset( $tweet['in_reply_to_screen_name'] ) ) {
				$trimmed_tweet['in_reply_to_screen_name'] = $tweet['in_reply_to_screen_name'];
				$trimmed_tweet['entities']['user_mentions'][0]['name'] = isset( $tweet['entities']['user_mentions'][0]['name'] ) ? $tweet['entities']['user_mentions'][0]['name'] : '';
				$trimmed_tweet['in_reply_to_status_id_str'] = $tweet['in_reply_to_status_id_str'];
			}

			if ( isset( $tweet['extended_entities']['media'] ) ) {
				// if there is media, we need to remove the media url from the tweet text
				if ( isset( $tweet['extended_entities']['media'][0]['url'] ) ) {
					$trimmed_tweet['text'] = CTF_Feed_Pro::removeStringFromText( $tweet['extended_entities']['media'][0]['url'], $trimmed_tweet['text'] );
				}
				$num_media = count( $tweet['extended_entities']['media'] );
				for ( $i = 0; $i < $num_media; $i++ ) {
					$trimmed_tweet['extended_entities']['media'][$i]['media_url_https'] = $tweet['extended_entities']['media'][$i]['media_url_https'];
					$trimmed_tweet['extended_entities']['media'][$i]['type'] = $tweet['extended_entities']['media'][$i]['type'];
					if ( isset( $tweet['extended_entities']['media'][$i]['sizes'] ) ) {
						$trimmed_tweet['extended_entities']['media'][$i]['sizes'] = $tweet['extended_entities']['media'][$i]['sizes'];
					}
					if ( $tweet['extended_entities']['media'][$i]['type'] == 'video' || $tweet['extended_entities']['media'][$i]['type'] == 'animated_gif' ) {
						$preferred_variant = $tweet['extended_entities']['media'][$i]['video_info']['variants'][0]['url'];
						$highest_bitrate = 0;
						foreach ( $tweet['extended_entities']['media'][$i]['video_info']['variants'] as $variant ) {
							if ( isset( $variant['content_type'] )
							     && $variant['content_type'] == 'video/mp4'
								&& $variant['bitrate'] > $highest_bitrate ) {
								$highest_bitrate = $variant['bitrate'];
								$preferred_variant = $variant['url'];
							}
						}
						$trimmed_tweet['extended_entities']['media'][$i]['video_info']['variants'][0]['url'] = $preferred_variant;
						$trimmed_tweet['extended_entities']['media'][$i]['video_info']['variants'][0]['bitrate'] = $highest_bitrate;

					}
				}

			} elseif ( isset( $tweet['entities']['media'] ) ) {
				// if there is media, we need to remove the media url from the tweet text
				if ( isset( $tweet['entities']['media'][0]['url'] ) ) {
					$trimmed_tweet['text'] = CTF_Feed_Pro::removeStringFromText( $tweet['entities']['media'][0]['url'], $trimmed_tweet['text'] );
				}

				$num_media = count( $tweet['entities']['media'] );
				for ( $i = 0; $i < $num_media; $i++ ) {
					$trimmed_tweet['entities']['media'][$i]['media_url_https'] = $tweet['entities']['media'][$i]['media_url_https'];
					$trimmed_tweet['entities']['media'][$i]['type'] = $tweet['entities']['media'][$i]['type'];
					if ( isset( $tweet['entities']['media'][$i]['sizes'] ) ) {
						$trimmed_tweet['entities']['media'][$i]['sizes'] = $tweet['entities']['media'][$i]['sizes'];
					}
					if ( $tweet['entities']['media'][$i]['type'] == 'video' || $tweet['entities']['media'][$i]['type'] == 'animated_gif' ) {

						$preferred_variant = $tweet['entities']['media'][$i]['video_info']['variants'][0]['url'];
						$highest_bitrate = 0;
						foreach ( $tweet['entities']['media'][$i]['video_info']['variants'] as $variant ) {
							if ( isset( $variant['content_type'] )
							     && $variant['content_type'] == 'video/mp4'
							     && $variant['bitrate'] > $highest_bitrate ) {
								$highest_bitrate = $variant['bitrate'];
								$preferred_variant = $variant['url'];
							}
						}
						$trimmed_tweet['entities']['media'][$i]['video_info']['variants'][0]['url'] = $preferred_variant;
						$trimmed_tweet['entities']['media'][$i]['video_info']['variants'][0]['bitrate'] = $highest_bitrate;
					}
				}

			}

			if ( isset( $tweet['retweeted_status']['extended_entities']['media'] ) ) {
				// if there is media, we need to remove the media url from the tweet text
				$retweeted_text = isset( $tweet['retweeted_status']['full_text'] ) ? $tweet['retweeted_status']['full_text'] : $tweet['retweeted_status']['text'];
				if ( isset( $tweet['retweeted_status']['extended_entities']['media'][0]['url'] ) ) {
					$trimmed_tweet['retweeted_status']['text'] = CTF_Feed_Pro::removeStringFromText( $tweet['retweeted_status']['extended_entities']['media'][0]['url'], $retweeted_text );
				}

				$num_media = count( $tweet['retweeted_status']['extended_entities']['media'] );
				for ( $i = 0; $i < $num_media; $i++ ) {
					$trimmed_tweet['retweeted_status']['extended_entities']['media'][$i]['media_url_https'] = $tweet['retweeted_status']['extended_entities']['media'][$i]['media_url_https'];
					$trimmed_tweet['retweeted_status']['extended_entities']['media'][$i]['type'] = $tweet['retweeted_status']['extended_entities']['media'][$i]['type'];
					if ( isset( $tweet['retweeted_status']['extended_entities']['media'][$i]['sizes'] ) ) {
						$trimmed_tweet['retweeted_status']['extended_entities']['media'][$i]['sizes'] = $tweet['retweeted_status']['extended_entities']['media'][$i]['sizes'];
					}
					if ( $tweet['retweeted_status']['extended_entities']['media'][$i]['type'] == 'video' || $tweet['retweeted_status']['extended_entities']['media'][$i]['type'] == 'animated_gif' ) {
						foreach ( $tweet['retweeted_status']['extended_entities']['media'][$i]['video_info']['variants'] as $variant ) {
							if ( isset( $variant['content_type'] ) && $variant['content_type'] == 'video/mp4' ) {
								$trimmed_tweet['retweeted_status']['extended_entities']['media'][$i]['video_info']['variants'][$i]['url'] = $variant['url'];
							}
						}
						if ( ! isset( $trimmed_tweet['retweeted_status']['extended_entities']['media'][$i]['video_info']['variants'][$i]['url'] ) ) {
							$trimmed_tweet['retweeted_status']['extended_entities']['media'][$i]['video_info']['variants'][$i]['url'] = $tweet['retweeted_status']['extended_entities']['media'][$i]['video_info']['variants'][0]['url'];
						}
					}
				}

			} elseif ( isset( $tweet['retweeted_status']['entities']['media'] ) ) {
				// if there is media, we need to remove the media url from the tweet text
				$retweeted_text = isset( $tweet['retweeted_status']['full_text'] ) ? $tweet['retweeted_status']['full_text'] : $tweet['retweeted_status']['text'];
				if ( isset( $tweet['retweeted_status']['entities']['media'][0]['url'] ) ) {
					$trimmed_tweet['retweeted_status']['text'] = CTF_Feed_Pro::removeStringFromText( $tweet['retweeted_status']['entities']['media'][0]['url'], $retweeted_text );
				}

				$num_media = count( $tweet['retweeted_status']['entities']['media'] );
				for( $i = 0; $i < $num_media; $i++ ) {
					$trimmed_tweet['retweeted_status']['entities']['media'][$i]['media_url_https'] = $tweet['retweeted_status']['entities']['media'][$i]['media_url_https'];
					$trimmed_tweet['retweeted_status']['entities']['media'][$i]['type'] = $tweet['retweeted_status']['entities']['media'][$i]['type'];
					if ( isset( $tweet['retweeted_status']['entities']['media'][$i]['sizes'] ) ) {
						$trimmed_tweet['retweeted_status']['entities']['media'][$i]['sizes'] = $tweet['retweeted_status']['entities']['media'][$i]['sizes'];
					}
					if ( $tweet['retweeted_status']['entities']['media'][$i]['type'] == 'video' || $tweet['retweeted_status']['entities']['media'][$i]['type'] == 'animated_gif' ) {
						foreach ( $tweet['retweeted_status']['entities']['media'][$i]['video_info']['variants'] as $variant ) {
							if ( isset( $variant['content_type'] ) && $variant['content_type'] == 'video/mp4' ) {
								$trimmed_tweet['retweeted_status']['entities']['media'][$i]['video_info']['variants'][$i]['url'] = $variant['url'];
							}
						}
						if ( ! isset( $trimmed_tweet['retweeted_status']['entities']['media'][$i]['video_info']['variants'][$i]['url'] ) ) {
							$trimmed_tweet['retweeted_status']['entities']['media'][$i]['video_info']['variants'][$i]['url'] = $tweet['retweeted_status']['entities']['media'][$i]['video_info']['variants'][0]['url'];
						}
					}
				}

			} elseif ( isset( $tweet['quoted_status']['extended_entities']['media'] ) ) {
				// if there is media, we need to remove the media url from the tweet text
				$quoted_text = isset( $tweet['quoted_status']['full_text'] ) ? $tweet['quoted_status']['full_text'] : $tweet['quoted_status']['text'];
				if ( isset( $tweet['quoted_status']['extended_entities']['media'][0]['url'] ) ) {
					$trimmed_tweet['quoted_status']['text'] = CTF_Feed_Pro::removeStringFromText( $tweet['quoted_status']['extended_entities']['media'][0]['url'], $quoted_text );
				}

				$num_media = count( $tweet['quoted_status']['extended_entities']['media'] );
				for( $i = 0; $i < $num_media; $i++ ) {
					$trimmed_tweet['quoted_status']['extended_entities']['media'][$i]['media_url_https'] = $tweet['quoted_status']['extended_entities']['media'][$i]['media_url_https'];
					$trimmed_tweet['quoted_status']['extended_entities']['media'][$i]['type'] = $tweet['quoted_status']['extended_entities']['media'][$i]['type'];
					if ( $tweet['quoted_status']['extended_entities']['media'][$i]['type'] == 'video' || $tweet['quoted_status']['extended_entities']['media'][$i]['type'] == 'animated_gif' ) {
						foreach ( $tweet['quoted_status']['extended_entities']['media'][$i]['video_info']['variants'] as $variant ) {
							if ( isset( $variant['content_type'] ) && $variant['content_type'] == 'video/mp4' ) {
								$trimmed_tweet['quoted_status']['extended_entities']['media'][$i]['video_info']['variants'][$i]['url'] = $variant['url'];
							}
						}
						if ( ! isset( $trimmed_tweet['quoted_status']['extended_entities']['media'][$i]['video_info']['variants'][$i]['url'] ) ) {
							$trimmed_tweet['quoted_status']['extended_entities']['media'][$i]['video_info']['variants'][$i]['url'] = $tweet['quoted_status']['extended_entities']['media'][$i]['video_info']['variants'][0]['url'];
						}
					}
				}

			} elseif ( isset( $tweet['quoted_status']['entities']['media'] ) ) {
				// if there is media, we need to remove the media url from the tweet text
				$quoted_text = isset( $tweet['quoted_status']['full_text'] ) ? $tweet['quoted_status']['full_text'] : $tweet['quoted_status']['text'];
				if ( isset( $tweet['quoted_status']['entities']['media'][0]['url'] ) ) {
					$trimmed_tweet['quoted_status']['text'] = CTF_Feed_Pro::removeStringFromText( $tweet['quoted_status']['entities']['media'][0]['url'], $quoted_text );
				}

				$num_media = count( $tweet['quoted_status']['entities']['media'] );
				for( $i = 0; $i < $num_media; $i++ ) {
					$trimmed_tweet['quoted_status']['entities']['media'][$i]['media_url_https'] = $tweet['quoted_status']['entities']['media'][$i]['media_url_https'];
					$trimmed_tweet['quoted_status']['entities']['media'][$i]['type'] = $tweet['quoted_status']['entities']['media'][$i]['type'];
					if ( $tweet['quoted_status']['entities']['media'][$i]['type'] == 'video' || $tweet['quoted_status']['entities']['media'][$i]['type'] == 'animated_gif' ) {
						foreach ( $tweet['quoted_status']['entities']['media'][$i]['video_info']['variants'] as $variant ) {
							if ( isset( $variant['content_type'] ) && $variant['content_type'] == 'video/mp4' ) {
								$trimmed_tweet['quoted_status']['entities']['media'][$i]['video_info']['variants'][$i]['url'] = $variant['url'];
							}
						}
						if ( ! isset( $trimmed_tweet['quoted_status']['entities']['media'][$i]['video_info']['variants'][$i]['url'] ) ) {
							$trimmed_tweet['quoted_status']['entities']['media'][$i]['video_info']['variants'][$i]['url'] = $tweet['quoted_status']['entities']['media'][$i]['video_info']['variants'][0]['url'];
						}
					}
				}

			}

			if ( isset( $tweet['retweeted_status']['quoted_status']['extended_entities']['media'] ) ) {
				// if there is media, we need to remove the media url from the tweet text
				$retweeted_text = isset( $tweet['retweeted_status']['quoted_status']['full_text'] ) ? $tweet['retweeted_status']['quoted_status']['full_text'] : $tweet['retweeted_status']['quoted_status']['text'];
				if ( isset( $tweet['retweeted_status']['quoted_status']['extended_entities']['media'][0]['url'] ) ) {
					$trimmed_tweet['retweeted_status']['quoted_status']['text'] = CTF_Feed_Pro::removeStringFromText( $tweet['retweeted_status']['quoted_status']['extended_entities']['media'][0]['url'], $retweeted_text );
				}

				$num_media = count( $tweet['retweeted_status']['quoted_status']['extended_entities']['media'] );
				for ( $i = 0; $i < $num_media; $i++ ) {
					$trimmed_tweet['retweeted_status']['quoted_status']['extended_entities']['media'][$i]['media_url_https'] = $tweet['retweeted_status']['quoted_status']['extended_entities']['media'][$i]['media_url_https'];
					$trimmed_tweet['retweeted_status']['quoted_status']['extended_entities']['media'][$i]['type'] = $tweet['retweeted_status']['quoted_status']['extended_entities']['media'][$i]['type'];
					if ( isset( $tweet['retweeted_status']['quoted_status']['extended_entities']['media'][$i]['sizes'] ) ) {
						$trimmed_tweet['retweeted_status']['quoted_status']['extended_entities']['media'][$i]['sizes'] = $tweet['retweeted_status']['quoted_status']['extended_entities']['media'][$i]['sizes'];
					}
					if ( $tweet['retweeted_status']['quoted_status']['extended_entities']['media'][$i]['type'] == 'video' || $tweet['retweeted_status']['quoted_status']['extended_entities']['media'][$i]['type'] == 'animated_gif' ) {
						foreach ( $tweet['retweeted_status']['quoted_status']['extended_entities']['media'][$i]['video_info']['variants'] as $variant ) {
							if ( isset( $variant['content_type'] ) && $variant['content_type'] == 'video/mp4' ) {
								$trimmed_tweet['retweeted_status']['quoted_status']['extended_entities']['media'][$i]['video_info']['variants'][$i]['url'] = $variant['url'];
							}
						}
						if ( ! isset( $trimmed_tweet['retweeted_status']['quoted_status']['extended_entities']['media'][$i]['video_info']['variants'][$i]['url'] ) ) {
							$trimmed_tweet['retweeted_status']['quoted_status']['extended_entities']['media'][$i]['video_info']['variants'][$i]['url'] = $tweet['retweeted_status']['quoted_status']['extended_entities']['media'][$i]['video_info']['variants'][0]['url'];
						}
					}
				}

			} elseif ( isset( $tweet['retweeted_status']['quoted_status']['entities']['media'] ) ) {
				// if there is media, we need to remove the media url from the tweet text
				$retweeted_text = isset( $tweet['retweeted_status']['quoted_status']['full_text'] ) ? $tweet['retweeted_status']['quoted_status']['full_text'] : $tweet['retweeted_status']['quoted_status']['text'];
				if ( isset( $tweet['retweeted_status']['quoted_status']['entities']['media'][0]['url'] ) ) {
					$trimmed_tweet['retweeted_status']['quoted_status']['text'] = CTF_Feed_Pro::removeStringFromText( $tweet['retweeted_status']['quoted_status']['entities']['media'][0]['url'], $retweeted_text );
				}

				$num_media = count( $tweet['retweeted_status']['quoted_status']['entities']['media'] );
				for( $i = 0; $i < $num_media; $i++ ) {
					$trimmed_tweet['retweeted_status']['quoted_status']['entities']['media'][$i]['media_url_https'] = $tweet['retweeted_status']['quoted_status']['entities']['media'][$i]['media_url_https'];
					$trimmed_tweet['retweeted_status']['quoted_status']['entities']['media'][$i]['type'] = $tweet['retweeted_status']['quoted_status']['entities']['media'][$i]['type'];
					if ( isset( $tweet['retweeted_status']['quoted_status']['entities']['media'][$i]['sizes'] ) ) {
						$trimmed_tweet['retweeted_status']['quoted_status']['entities']['media'][$i]['sizes'] = $tweet['retweeted_status']['quoted_status']['entities']['media'][$i]['sizes'];
					}
					if ( $tweet['retweeted_status']['quoted_status']['entities']['media'][$i]['type'] == 'video' || $tweet['retweeted_status']['quoted_status']['entities']['media'][$i]['type'] == 'animated_gif' ) {
						foreach ( $tweet['retweeted_status']['quoted_status']['entities']['media'][$i]['video_info']['variants'] as $variant ) {
							if ( isset( $variant['content_type'] ) && $variant['content_type'] == 'video/mp4' ) {
								$trimmed_tweet['retweeted_status']['quoted_status']['entities']['media'][$i]['video_info']['variants'][$i]['url'] = $variant['url'];
							}
						}
						if ( ! isset( $trimmed_tweet['retweeted_status']['quoted_status']['entities']['media'][$i]['video_info']['variants'][$i]['url'] ) ) {
							$trimmed_tweet['retweeted_status']['quoted_status']['entities']['media'][$i]['video_info']['variants'][$i]['url'] = $tweet['retweeted_status']['quoted_status']['entities']['media'][$i]['video_info']['variants'][0]['url'];
						}
					}
				}

			}

			//remove the url from the text if it links to a quoted tweet that is already linked to
			if ( isset( $tweet['quoted_status'] ) ) {
				$maybe_remove_index = count( $tweet['entities']['urls'] ) - 1;
				if ( isset( $tweet['entities']['urls'][$maybe_remove_index]['url'] ) ) {
					$text = isset( $trimmed_tweet['full_text'] ) ? $trimmed_tweet['full_text'] : $trimmed_tweet['text'];
					$trimmed_tweet['text'] = CTF_Feed_Pro::removeStringFromText( $tweet['entities']['urls'][$maybe_remove_index]['url'], $text );
				}
			}


			// used to generate twitter cards
			if ( isset( $tweet['entities']['urls'][0]['expanded_url'] ) ) {

				$trimmed_tweet['entities']['urls'][0]['expanded_url'] = $tweet['entities']['urls'][0]['expanded_url'];

				$twitter_card = CTF_Feed_Pro::maybeGetTwitterCardData( $tweet['entities']['urls'][0]['expanded_url'], $trimmed_tweet['id_str'] );

				if ( ! empty( $twitter_card ) ) {
					$trimmed_tweet['twitter_card'] = $twitter_card;

					$remove_url_from_tweet = apply_filters( 'ctf_should_remove_url_from_text', true );
					if ( ! empty( $twitter_card["twitter:card"] ) && isset( $tweet['entities']['urls'][0]['url'] ) && $remove_url_from_tweet ) {
						$trimmed_tweet['text'] = CTF_Feed_Pro::removeStringFromText( $tweet['entities']['urls'][0]['url'], $trimmed_tweet['text'] );
					}
				} elseif ( $twitter_card !== false ) {
					$trimmed_tweet['twitter_card'] = $twitter_card;
				}

			}

			if ( isset( $tweet['retweeted_status']['entities']['urls'][0]['expanded_url'] ) ) {

				$trimmed_tweet['retweeted_status']['entities']['urls'][0]['expanded_url'] = $tweet['retweeted_status']['entities']['urls'][0]['expanded_url'];

				$twitter_card = CTF_Feed_Pro::maybeGetTwitterCardData( $tweet['retweeted_status']['entities']['urls'][0]['expanded_url'], $trimmed_tweet['retweeted_status']['id_str'] );

				if ( ! empty( $twitter_card ) ) {
					$trimmed_tweet['retweeted_status']['twitter_card'] = $twitter_card;
					$retweeted_text = isset( $tweet['retweeted_status']['full_text'] ) ? $tweet['retweeted_status']['full_text'] : $tweet['retweeted_status']['text'];

					$remove_url_from_tweet = apply_filters( 'ctf_should_remove_url_from_text', true );
					if ( ! empty( $twitter_card["twitter:card"] ) && isset( $tweet['retweeted_status']['entities']['urls'][0]['url'] ) && $remove_url_from_tweet ) {
						$trimmed_tweet['retweeted_status']['text'] = CTF_Feed_Pro::removeStringFromText( $tweet['retweeted_status']['entities']['urls'][0]['url'], $retweeted_text );
					}
				} elseif ( $twitter_card !== false ) {
					$trimmed_tweet['twitter_card'] = $twitter_card;
				}
			}

			$trimmed_tweets[] = $trimmed_tweet;

		}

		return $trimmed_tweets;
	}

	public static function filterTweetSet( $tweet_set, $settings )
	{
		$tweets_to_remove_strip_ctf = str_replace( 'ctf_', '', $settings['remove_by_id'] );
		$ids_of_tweets_to_remove = ! empty( $tweets_to_remove_strip_ctf ) ? explode( ',', str_replace( ' ', '', $tweets_to_remove_strip_ctf ) ) : '';

		$tweets_that_pass_filter = array();

		foreach ( $tweet_set as $tweet ) {
			$retweet_id = isset( $tweet['retweeted_status']['id_str'] ) ? $tweet['retweeted_status']['id_str'] : '';
			$keep = true;
			if ( ! empty( $retweet_id ) && ! $settings['includeretweets'] ) {
				$keep = false;
			} elseif ( !$settings['includereplies'] && !$settings['selfreplies'] && isset( $tweet['in_reply_to_screen_name'] ) ) {
				$keep = false;
			} elseif ( !$settings['includereplies']
			           && $settings['selfreplies']
			           && isset( $tweet['in_reply_to_screen_name'] )
			           && $tweet['in_reply_to_screen_name'] !== $tweet['user']['screen_name'] ) {
				$keep = false;
			} elseif ( ! empty( $ids_of_tweets_to_remove ) && in_array( $tweet['id_str'], $ids_of_tweets_to_remove ) ) {
				$keep = false;
			} elseif ( CTF_Feed_Pro::tweetShouldBeRemoved( $tweet, $settings ) ) {
				$keep = false;
			}

			if ( $keep ) {
				$tweets_that_pass_filter[] = $tweet;
			}
		}

		return $tweets_that_pass_filter;
	}

	public static function tweetShouldBeRemoved( $tweet, $settings )
	{
		$return = false;
		$good_text = ! empty( $settings['includewords'] ) ? explode( ',', str_replace( ' ', '', $settings['includewords'] ) ) : '';
		$bad_text = ! empty( $settings['excludewords'] ) ? explode( ',', str_replace( ' ', '', $settings['excludewords'] ) ) : '';
		$includewords_any_all = $settings['includeanyall'];
		$excludewords_any_all = $settings['excludeanyall'];
		$filter_and_or = $settings['filterandor'];
		if ( isset( $tweet['retweeted_status']['full_text'] ) ) {
			$tweet_text = $tweet['retweeted_status']['full_text'];
		} elseif ( isset( $tweet['retweeted_status']['text'] ) ) {
			$tweet_text = $tweet['retweeted_status']['text'];
		} elseif ( isset( $tweet['full_text'] ) ) {
			$tweet_text = $tweet['full_text'];
		} elseif ( isset( $tweet['text'] ) ) {
			$tweet_text = $tweet['text'];
		} else {
			$tweet_text = '';
		}
		$tweet_text = ' ' . preg_replace( '/[,.!?:;"]+/', '', $tweet_text )  . ' '; // spaces added so that we can use strpos instead of regex to find words
		$tweet_text = strtolower( preg_replace( '/[\n]+/', ' ', $tweet_text ) );
		// don't bother with filtering process if both filters are empty
		if ( ! empty( $good_text ) || ! empty( $bad_text ) ) {
			if ( $filter_and_or == 'and' && ! empty( $good_text ) && ! empty( $bad_text ) ) {
				if ( CTF_Feed_Pro::hasGoodText( $good_text, $includewords_any_all, $tweet_text, true ) && CTF_Feed_Pro::hasNoBadText( $bad_text, 'any', $tweet_text, true ) ) {
					$return = false;
				} else {
					$return = true;
				}
			} else {
				if ( CTF_Feed_Pro::hasGoodText( $good_text, $includewords_any_all, $tweet_text, false ) || CTF_Feed_Pro::hasNoBadText( $bad_text, $excludewords_any_all, $tweet_text, false ) ) {
					$return = false;
				} else {
					$return = true;
				}
			}
		}

		$return = apply_filters( 'ctf_filter_out_tweet', $return, $tweet_text, $tweet  );

		return $return;
	}

	public static function hasGoodText( $good_text, $any_or_all, $tweet_text, $default )
	{
		if ( empty( $good_text ) ) { // don't factor in the includewords if there aren't any
			return $default;
		} else {
			$encoded_text = ' ' . str_replace( array( '+', '%0A' ), ' ',  urlencode( str_replace( array( '#', '@' ), array( ' HASHTAG', ' MENTION' ), strtolower( $tweet_text ) ) ) ) . ' ';

			if ( $any_or_all == 'any' ) {
				// as soon as we find any of the includewords, stop searching and return true
				foreach ( $good_text as $good ) {
					$converted_includeword = trim( str_replace('+', ' ', urlencode( str_replace( array( '#', '@' ), array( ' HASHTAG', ' MENTION' ), strtolower( $good ) ) ) ) );

					if ( preg_match('/\b'.$converted_includeword.'\b/i', $encoded_text, $matches ) ) {
						return true;
					}
				}
				// if foreach finishes without finding any matches
				return false;
			} else {
				// to make sure all of the includewords are present, keep a count of
				// how many of the words are detected and compare it to the number that's needed
				$good_text_matches = 0;
				$number_of_good_text_to_look_for = count( $good_text );
				foreach ( $good_text as $good ) {
					$converted_includeword = trim( str_replace('+', ' ', urlencode( str_replace( array( '#', '@' ), array( ' HASHTAG', ' MENTION' ), strtolower( $good ) ) ) ) );

					if ( preg_match('/\b'.$converted_includeword.'\b/i', $encoded_text, $matches ) ) {
						$good_text_matches++;
					}

				}
				if ( $good_text_matches >= $number_of_good_text_to_look_for ) {
					return true;
				} else {
					return false;
				}
			}
		}

	}

	/**
	 * if a filter is applied to this feed, check and see if this tweet needs to
	 * or contains the excludewords text
	 *
	 * @param $bad_text array       words the tweet cannot have to be included in the feed
	 * @param $any_or_all enum      whether any or all of the bad text words need to be included
	 * @param $tweet_text string    content text of the tweet
	 * @param $default bool         the default return type if nothing is set
	 * @return bool                 whether the tweet meets the requirements for having no bad text
	 */
	public static function hasNoBadText( $bad_text, $any_or_all, $tweet_text, $default )
	{
		if ( empty( $bad_text ) ) { // don't factor in the excludewords if there aren't any
			return $default;
		} else {
			$encoded_text = ' ' . str_replace( array( '+', '%0A' ), ' ',  urlencode( str_replace( array( '#', '@' ), array( ' HASHTAG', ' MENTION' ), strtolower( $tweet_text ) ) ) ) . ' ';

			if ( $any_or_all == 'any' ) {
				// as soon as we find any of the excludewords, stop searching and return false
				foreach ( $bad_text as $bad ) {
					if ( empty( $bad ) ) {
						return true;
					}
					$converted_excludeword = trim( str_replace('+', ' ', urlencode( str_replace( array( '#', '@' ), array( ' HASHTAG', ' MENTION' ), strtolower( $bad ) ) ) ) );
					if ( preg_match('/\b'.$converted_excludeword.'\b/i', $encoded_text, $matches ) ) {
						return false;
					}
				}
				// if foreach finishes without finding any matches
				return true;
			} else {
				// under this circumstance, all excludewords need to be present to remove
				// the tweet so a count is kept and compared to the number of words
				$bad_text_matches = 0;
				$number_of_bad_text_to_look_for = count( $bad_text );
				foreach ( $bad_text as $bad ) {
					$converted_excludeword = trim( str_replace('+', ' ', urlencode( str_replace( '#', 'HASHTAG', strtolower( $bad ) ) ) ) );

					if ( preg_match('/\b'.$converted_excludeword.'\b/i', $encoded_text, $matches ) ) {
						$bad_text_matches++;
					}

				}
				if ( $bad_text_matches >= $number_of_bad_text_to_look_for ) {
					return false;
				} else {
					return true;
				}
			}
		}

	}

	public static function removeStringFromText( $string, $text, $expanded_url = '' ) {
		$exceptions = array( '://fb.me/' );

		if ( $expanded_url !== '' ) {

			foreach ( $exceptions as $exception ) {

				if ( strpos( $expanded_url, $exception ) !== false ) {
					return str_replace( $string, $expanded_url, $text );
				}

			}

		}

		return str_replace( $string, '', $text );
	}

	public static function maybeGetTwitterCardData( $url, $id ) {
		$url_key = str_replace('&','038',$url);
		$url_key = preg_replace( '~[^a-zA-Z0-9]+~', '', $url_key );

		$tc_data = get_option( 'ctf_twitter_cards', array() );

		$card = false;
		if ( isset( $tc_data[ $url_key ] ) ) {
			$card = $tc_data[ $url_key ];
		} elseif ( isset( $tc_data[ $id ] ) ) {
			$card = $tc_data[ $id ];
		}

		if ( $card && ! isset( $card['local'] ) ) {
			$card['local'] = CTF_Twitter_Card_Manager::add_local_image( $card, $id );
		}

		return $card;
	}

	public function set_next_pages( $next_pages ) {
		$this->next_pages = $next_pages;
	}

	private function merge_posts( $post_sets, $settings ) {
		$merged_posts = array();
		$settings['sortby'] = isset( $settings['sortby'] ) ? $settings['sortby'] : 'date';

		if ( $settings['sortby'] === 'alternate' ) {
			// don't bother merging posts if there is only one post set
			if ( isset( $post_sets[1] ) ) {
				$min_cycles = max( 1, (int)$settings['num'] );
				for( $i = 0; $i <= $min_cycles; $i++ ) {
					foreach ( $post_sets as $post_set ) {
						if ( isset( $post_set[ $i ] ) && isset( $post_set[ $i ]['id'] ) ) {
							$merged_posts[] = $post_set[ $i ];
						}
					}
				}
			} else {
				$merged_posts = isset( $post_sets[0] ) ? $post_sets[0] : array();
			}
		} elseif ( $settings['sortby'] === 'api' ) {
			if ( isset( $post_sets[0] ) ) {
				foreach ( $post_sets as $post_set ) {
					$merged_posts = array_merge( $merged_posts, $post_set );
				}
			}
		} else {
			// don't bother merging posts if there is only one post set
			if ( isset( $post_sets[1] ) ) {
				foreach ( $post_sets as $post_set ) {
					$merged_posts = array_merge( $merged_posts, $post_set );
				}
			} else {
				$merged_posts = isset( $post_sets[0] ) ? $post_sets[0] : array();
			}
		}


		return $merged_posts;
	}

	/**
	 * Connects to the Instagram API and records returned data
	 *
	 * @param $settings
	 * @param array $feed_types_and_terms organized settings related to feed data
	 *  (ex. 'user' => array( 'smashballoon', 'custominstagramfeed' )
	 * @param array $connected_accounts_for_feed connected account data for the
	 *  feed types and terms
	 *
	 * @since 2.0/5.0
	 * @since 2.2/5.3 added logic to append bio data from the related
	 *  connected account if not available in the API response
	 */
	public function set_remote_header_data( $settings, $feed_types_and_terms ) {
		$this->header_data = false;
		$endpoint = 'accountlookup';
		if ( $settings['type'] === 'usertimeline' ) {
			$endpoint = 'userslookup';
		}

		// Only can be set in the options page
		$request_settings = array(
			'consumer_key' => $settings['consumer_key'],
			'consumer_secret' => $settings['consumer_secret'],
			'access_token' => $settings['access_token'],
			'access_token_secret' => $settings['access_token_secret'],
		);

		$get_fields = $this->setGetFieldsArray( $endpoint, $settings['screenname'], $settings );

		include_once( CTF_URL . '/inc/CtfOauthConnect.php' );
		include_once( CTF_URL . '/inc/CtfOauthConnectPro.php' );

		// actual connection
		$twitter_connect = new CtfOauthConnectPro( $request_settings, $endpoint );
		$twitter_connect->setUrlBase();
		$twitter_connect->setGetFields( $get_fields );
		$twitter_connect->setRequestMethod( $settings['request_method'] );

		$request_results = $twitter_connect->performRequest();

		$header_json = isset( $request_results->json ) ? $request_results->json : false;

		$header_data = json_decode( $header_json, true );

		$this->header_data = $header_data;
	}

	protected function setGetFieldsArray( $end_point, $feed_term, $settings )
	{
		$feed_type = $end_point;

		$get_fields = array();

		$get_fields['tweet_mode'] = 'extended';

		if ( $feed_type === 'usertimeline' ) {
			if ( ! empty ( $feed_term  ) ) {
				$get_fields['screen_name'] = $feed_term;
			}
			if ( $settings['includereplies'] || $settings['selfreplies'] ) {
				$get_fields['exclude_replies'] = 'false';
			} else {
				$get_fields['exclude_replies'] = 'true';
			}
		}

		if ( $feed_type === 'hometimeline' ) {
			if ( $settings['includereplies'] || $settings['selfreplies'] ) {
				$get_fields['exclude_replies'] = 'false';
			} else {
				$get_fields['exclude_replies'] = 'true';
			}
		}

		if ( $feed_type === 'search' || $feed_type === 'hashtag' ) {
			$get_fields['q'] = $feed_term;
		}

		if ( $feed_type === 'lists' ) {
			if ( ! empty ( $feed_term  ) ) {
				$get_fields['list_id'] = $feed_term;
			}
		}

		if ( $feed_type === 'userslookup' ) {
			if ( ! empty ( $feed_term  ) ) {
				$get_fields['screen_name'] = $feed_term;
			}
		}

		return $get_fields;
	}


	/**
	 * Stores feed data in a transient for a specified time
	 *
	 * @param int $cache_time
	 * @param bool $save_backup
	 *
	 * @since 2.0/5.0
	 * @since 2.0/5.1 duplicate posts removed
	 */
	public function cache_feed_data( $cache_time, $save_backup = true ) {
		if ( ! empty( $this->post_data ) || ! empty( $this->next_pages ) ) {
			$this->remove_duplicate_posts();
			$this->trim_posts_to_max();

			$to_cache = array(
				'data' => $this->post_data,
				'pagination' => $this->next_pages
			);

			set_transient( $this->regular_feed_transient_name, wp_json_encode( $to_cache ), $cache_time );

			if ( $save_backup ) {
				update_option( $this->backup_feed_transient_name, wp_json_encode( $to_cache ), false );
			}
		} else {
			$this->add_report( 'no data not caching' );
		}
	}

	/**
	 * Stores header data for a specified time as a transient
	 *
	 * @param int $cache_time
	 * @param bool $save_backup
	 *
	 * @since 2.0/5.0
	 */
	public function cache_header_data( $cache_time, $save_backup = true ) {
		if ( $this->header_data ) {
			set_transient( $this->header_transient_name, wp_json_encode( $this->header_data ), $cache_time );

			if ( $save_backup ) {
				update_option( $this->backup_header_transient_name, wp_json_encode( $this->header_data ), false );
			}
		}
	}

	/**
	 * Determines if pagination can and should be used based on settings and available feed data
	 *
	 * @param array $settings
	 * @param int $offset
	 *
	 * @return bool
	 *
	 * @since 2.0/5.0
	 */
	public function should_use_pagination( $settings, $offset = 0 ) {

		if ( $settings['minnum'] < 1 ) {
			$this->add_report( 'minnum too small' );

			return false;
		}
		$posts_available = count( $this->post_data ) - ($offset + $settings['minnum']);
		$show_loadmore_button_by_settings = ($settings['showbutton'] == 'on' || $settings['showbutton'] == 'true' || $settings['showbutton'] == true ) && $settings['showbutton'] !== 'false';

		if ( $show_loadmore_button_by_settings ) {
			if ( $posts_available > 0 ) {
				$this->add_report( 'do pagination, posts available' );
				return true;
			}
			$pages = $this->next_pages;

			if ( $pages && ! $this->should_use_backup() ) {
				foreach ( $pages as $page ) {
					if ( ! empty( $page ) ) {
						return true;
					}
				}
			}

		}


		$this->add_report( 'no pagination, no posts available' );

		return false;
	}

	/**
	 * Overwritten in the Pro version
	 *
	 * @return object
	 */
	public function make_api_connection( $connected_account_or_page, $type = NULL, $params = NULL ) {
		return new SB_Instagram_API_Connect( $connected_account_or_page, $type, $params );
	}

	/**
	 * Overwritten in the Pro version
	 *
	 * @param $feed_types_and_terms
	 *
	 * @return string
	 *
	 * @since 2.1/5.2
	 */
	public function get_first_user( $feed_types_and_terms ) {
		if ( isset( $feed_types_and_terms['users'][0] ) ) {
			return $feed_types_and_terms['users'][0][1];
		} else {
			return '';
		}
	}

	/**
	 * Adds recorded strings to an array
	 *
	 * @param $to_add
	 *
	 * @since 2.0/5.0
	 */
	public function add_report( $to_add ) {
		$this->report[] = $to_add;
	}

	/**
	 * @return array
	 *
	 * @since 2.0/5.0
	 */
	public function get_report() {
		return $this->report;
	}

	/**
	 * Used for filtering a single API request worth of posts
	 *
	 * Overwritten in the Pro version
	 *
	 * @param array $post_set a single set of post data from the api
	 *
	 * @return mixed|array
	 *
	 * @since 2.0/5.0
	 */
	protected function filter_posts( $post_set, $settings = array() ) {
		// array_unique( $post_set, SORT_REGULAR);

		return $post_set;
	}

	protected function handle_no_posts_found( $settings = array(), $feed_types_and_terms = array() ) {

	}

	protected function remove_duplicate_posts() {
		$posts = $this->post_data;
		$ids_in_feed = array();
		$non_duplicate_posts = array();
		$removed = array();

		foreach ( $posts as $post ) {
			$post_id = SB_Instagram_Parse::get_post_id( $post );
			if ( ! in_array( $post_id, $ids_in_feed, true ) ) {
				$ids_in_feed[] = $post_id;
				$non_duplicate_posts[] = $post;
			} else {
				$removed[] = $post_id;
			}
		}

		$this->add_report( 'removed duplicates: ' . implode(', ', $removed ) );
		$this->set_post_data( $non_duplicate_posts );
	}

}
