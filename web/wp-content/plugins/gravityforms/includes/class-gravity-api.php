<?php

if ( ! class_exists( 'GFForms' ) ) {
	die();
}

if ( ! defined( 'GRAVITY_API_URL' ) ) {
	define( 'GRAVITY_API_URL', 'https://gravityapi.com/wp-json/gravityapi/v1' );
}

if ( ! class_exists( 'Gravity_Api' ) ) {

	/**
	 * Client-side API wrapper for interacting with the Gravity APIs.
	 *
	 * @package    Gravity Forms
	 * @subpackage Gravity_Api
	 * @since      1.9
	 * @access     public
	 */

	class Gravity_Api {

		private static $instance = null;

		public static function get_instance() {
			if ( null == self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;
		}

		/**
		 * Retrieves site key and site secret key from remote API and stores them as WP options. Returns false if license key is invalid; otherwise, returns true.
		 *
		 * @since  2.3
		 * @access public
		 *
		 * @param string $license_key License key to be registered
		 * @param boolean $is_md5 Specifies if $license_key provided is an MD5 or unhashed license key.
		 *
		 * @return bool Success
		 */
		public function register_current_site( $license_key, $is_md5 = false ) {

			$body = array();
			$body['site_name'] = get_bloginfo( 'name' );
			$body['site_url']  = get_bloginfo( 'url' );

			if ( $is_md5 ) {

				$body['license_key_md5'] = $license_key;

			} else {

				$body['license_key'] = $license_key;

			}

			GFCommon::log_debug( __METHOD__ . '(): registering site' );

			$result = $this->request( 'sites', $body, 'POST', array( 'headers' => $this->get_license_auth_header( $license_key ) ) );
			$result = $this->prepare_response_body( $result );

			if ( is_wp_error( $result ) || ! is_object( $result ) ) {
				GFCommon::log_error( __METHOD__ . '(): error registering site. ' . print_r( $result, true ) );
				return $result;
			}

			// Updating site key and secret
			update_option( 'gf_site_key', $result->key );
			update_option( 'gf_site_secret', $result->secret );

			GFCommon::log_debug( __METHOD__ . '(): site registration successful. Site Key: ' . $result->key );

			return true;
		}

		/**
		 * Updates license key for a site that has already been registered.
		 *
		 * @since  2.3
		 * @access public
		 *
		 * @param string $new_license_key_md5 Hash license key to be updated
		 *
		 * @return bool Success
		 */
		public function update_current_site( $new_license_key_md5 ) {

			$site_key = $this->get_site_key();
			$site_secret = $this->get_site_secret();
			if ( empty( $site_key ) || empty( $site_secret ) ) {

				return false;
			}

			$body = GFCommon::get_remote_post_params();
			$body['site_name'] = get_bloginfo( 'name' );
			$body['site_url']  = get_bloginfo( 'url' );
			$body['site_key'] = $site_key;
			$body['site_secret'] = $site_secret;
			$body['license_key_md5'] = $new_license_key_md5;

			GFCommon::log_debug( __METHOD__ . '(): refreshing license info' );

			$result = $this->request( 'sites/' . $site_key, $body, 'PUT', array( 'headers' => $this->get_site_auth_header( $site_key, $site_secret ) ) );
			$result = $this->prepare_response_body( $result );

			if ( is_wp_error( $result ) ) {

				GFCommon::log_debug( __METHOD__ . '(): error updating site registration. ' . print_r( $result, true ) );
				return $result;

			}

			return true;
		}

		/***
		 * Removes a license key from a registered site. NOTE: It doesn't actually deregister the site.
		 *
		 * @deprecated Use gapi()->update_current_site('') instead.
		 *
		 * @return bool|WP_Error
		 */
		public function deregister_current_site() {

			$site_key = $this->get_site_key();
			$site_secret = $this->get_site_secret();

			if ( empty( $site_key ) ) {
				return false;
			}

			GFCommon::log_debug( __METHOD__ . '(): deregistering' );

			$body = array(
				'license_key_md5' => '',
			);

			$result = $this->request( 'sites/' . $site_key, $body, 'PUT', array( 'headers' => $this->get_site_auth_header( $site_key, $site_secret ) ) );
			$result = $this->prepare_response_body( $result );

			if ( is_wp_error( $result ) ) {

				GFCommon::log_debug( __METHOD__ . '(): error updating site registration. ' . print_r( $result, true ) );
				return $result;

			}

			return true;
		}


		// # HELPERS

		private function get_site_auth_header( $site_key, $site_secret ) {

			$auth = base64_encode( "{$site_key}:{$site_secret}" );
			return array( 'Authorization' => 'GravityAPI ' . $auth );

		}

		private function get_license_auth_header( $license_key_md5 ) {

			$auth = base64_encode( "license:{$license_key_md5}" );
			return array( 'Authorization' => 'GravityAPI ' . $auth );

		}

		public function prepare_response_body( $raw_response ) {

			if ( is_wp_error( $raw_response ) ) {
				return $raw_response;
			} elseif ( $raw_response['response']['code'] != 200 ) {
				return new WP_Error( 'server_error', 'Error from server: ' . $raw_response['response']['message'] );
			}

			$response_body = json_decode( $raw_response['body'] );

			if ( $response_body === null ) {
				return new WP_Error( 'invalid_response', 'Invalid response from server: ' . $raw_response['body'] );
			}

			return $response_body;
		}

		public function purge_site_credentials() {

			delete_option( 'gf_site_key' );
			delete_option( 'gf_site_secret' );
		}

		public function request( $resource, $body, $method = 'POST', $options = array() ) {
			$body['timestamp'] = time();

			// set default options
			$options = wp_parse_args( $options, array(
				'method'  => $method,
				'timeout' => 10,
				'body'    => in_array( $method, array( 'GET', 'DELETE' ) ) ? null : json_encode( $body ),
				'headers' => array(),
				'sslverify' => false,
			) );

			// set default header options
			$options['headers'] = wp_parse_args( $options['headers'], array(
				'Content-Type'   => 'application/json; charset=' . get_option( 'blog_charset' ),
				'User-Agent'     => 'WordPress/' . get_bloginfo( 'version' ),
				'Referer'        => get_bloginfo( 'url' ),
			) );

			// WP docs say method should be uppercase
			$options['method'] = strtoupper( $options['method'] );

			$request_url  = $this->get_gravity_api_url() . $resource;
			$raw_response = wp_remote_request( $request_url, $options );


			return $raw_response;
		}

		public function get_site_key() {

			if ( defined( 'GRAVITY_API_SITE_KEY' ) ) {
				return GRAVITY_API_SITE_KEY;
			}

			$site_key = get_option( 'gf_site_key' );
			if ( empty( $site_key ) ) {
				return false;
			}
			return $site_key;

		}

		public function get_site_secret() {
			if ( defined( 'GRAVITY_API_SITE_SECRET' ) ) {
				return GRAVITY_API_SITE_SECRET;
			}
			$site_secret = get_option( 'gf_site_secret' );
			if ( empty( $site_secret ) ) {
				return false;
			}
			return $site_secret;
		}

		public function get_gravity_api_url() {
			return trailingslashit( GRAVITY_API_URL );
		}

		public function is_site_registered() {
			return $this->get_site_key() && $this->get_site_secret();
		}

	}

	function gapi() {
		return Gravity_Api::get_instance();
	}

	gapi();

}