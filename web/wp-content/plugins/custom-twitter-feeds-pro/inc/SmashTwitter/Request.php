<?php
/**
 * Class Request
 *
 * Performs a request to the Smash Balloon Twitter API.
 *
 * @since 2.1
 */
namespace TwitterFeed\SmashTwitter;

class Request
{
	protected $endpoint;

	protected $term;

	protected $args;

	protected $auth_token;

	protected $license;

	public function __construct($endpoint, $term, $args = array(), $auth_token = false)
	{
		$this->endpoint = $endpoint;

		$this->term = $term;

		$this->args = $args;

		$this->auth_token = $auth_token;
	}

	public function fetch()
	{
		$headers = array(
			'Accept' => 'application/json',
			'Content-Type' => 'application/json'
		);

		if ($this->auth_token) {
			$headers['Authorization'] = 'Bearer ' . $this->auth_token;
		}

		$this->args['headers'] = $headers;

		$endpoint_relative_url = '';
		$method = 'post';
		$this->args['method']  = 'POST';
		if ( $this->endpoint === 'usertimeline' ) {
			$method = 'get';
			$this->args['method']  = 'GET';
			$endpoint_relative_url = SMASH_TWITTER_TIMELINE_PATH . '?tweet_mode=extended&screen_name=' . urlencode( $this->term );
		} elseif ( $this->endpoint === 'search' ) {
			$method = 'get';
			$this->args['method']  = 'GET';
			$endpoint_relative_url = SMASH_TWITTER_SEARCH_PATH . '?q=' . urlencode( $this->term );
		} elseif ( $this->endpoint === 'register' ) {
			$endpoint_relative_url = '1.1/auth/register';
		}elseif ( $this->endpoint === 'license' ) {
			$endpoint_relative_url = '1.1/auth/license';
		}

		$endpoint_url = SMASH_TWITTER_URL . $endpoint_relative_url . SMASH_TWITTER_URL_EXTRA_GET_PARAMS;

		$args = $this->args;
		if ( $method === 'get' ) {
			$return = wp_remote_get( $endpoint_url, $args );
		} else {
			$return = wp_remote_post( $endpoint_url, $args );
		}

		if (! is_wp_error( $return ) && isset( $return['body'] )) {
			$body = $return['body'];

			$decoded = json_decode( $body, true );

			if ( $decoded ) {
				return $decoded;
			}
		}

		return $return;
	}
}
