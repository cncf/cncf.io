<?php
/**
 * REST API Authentication
 *
 * @since    2.4.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * REST API authentication class.
 *
 * @since 2.4-beta-1
 */
class GF_REST_Authentication {

	/**
	 * Authentication error.
	 *
	 * @since 2.4-beta-1
	 *
	 * @var WP_Error
	 */
	protected $error = null;

	/**
	 * Logged in user data.
	 *
	 * @since 2.4-beta-1
	 *
	 * @var stdClass
	 */
	protected $user = null;

	/**
	 * Current auth method.
	 *
	 * @since 2.4-beta-1
	 *
	 * @var string
	 */
	protected $auth_method = '';

	/**
	 * Initialize authentication actions.
	 *
	 * @since 2.4-beta-1
	 */
	public function __construct() {

		$this->init();
	}

	/***
	 * Initializes REST authentication by adding appropriate filters
	 *
	 * @since 2.4-beta-1
	 */
	public function init() {

		add_filter( 'determine_current_user', array( $this, 'authenticate' ), 15 );
		add_filter( 'rest_authentication_errors', array( $this, 'authentication_fallback' ) );
		add_filter( 'rest_authentication_errors', array( $this, 'check_authentication_error' ), 99 );
		add_filter( 'rest_pre_dispatch', array( $this, 'check_user_permissions' ), 99, 3 );
		add_filter( 'rest_post_dispatch', array( $this, 'send_unauthorized_headers' ), 50 );

	}

	/**
	 * If request is to our API and we did not set any authentication errors, override authentication errors that may
	 * be set by other REST API authenticators.
	 *
	 * @since 2.4-beta-1
	 *
	 * @deprecated 2.4.22
	 *
	 * @param $errors
	 *
	 * @return null
	 */
	public function override_rest_authentication_errors( $errors ) {
		_deprecated_function( __METHOD__, '2.4.22', 'GF_REST_Authentication::check_authentication_error' );

		if ( $this->is_request_to_rest_api() && ! $this->get_error() ) {
			return null;
		}

		return $errors;
	}


	/**
	 * Check if is request to Gravity Forms REST API.
	 *
	 * @since 2.4-beta-1
	 *
	 * @return bool Returns true if this is a request to the Gravity Forms REST API. False otherwise
	 */
	protected function is_request_to_rest_api() {
		if ( empty( $_SERVER['REQUEST_URI'] ) || ! ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
			return false;
		}

		$rest_prefix = trailingslashit( rest_get_url_prefix() );

		// Check if our endpoint.
		$is_gf_endpoint = ( strpos( $_SERVER['REQUEST_URI'], $rest_prefix . 'gf/' ) !== false );

		// Allow third party plugins use our authentication methods.
		$third_party = ( false !== strpos( $_SERVER['REQUEST_URI'], $rest_prefix . 'gf-' ) );

		if ( has_filter( 'gform_is_request_to_rest_api' ) ) {
			$this->log_debug( __METHOD__ . '(): Executing functions hooked to gform_is_request_to_rest_api.' );
		}

		/**
		 * Allows filtering of whether or not the current request is a request to the Gravity Forms REST API.
		 *
		 * @param bool $is_rest_api_request True if this is a request to the Gravity Forms REST API. False if not.
		 */
		return apply_filters( 'gform_is_request_to_rest_api', $is_gf_endpoint || $third_party );
	}

	/**
	 * Authenticate user.
	 *
	 * @since 2.4-beta-1
	 *
	 * @param int|false $user_id User ID if one has been determined, false otherwise.
	 * @return int|false Returns the User ID of the authenticated user.
	 */
	public function authenticate( $user_id ) {
		if ( ! $this->is_request_to_rest_api() ) {
			return $user_id;
		}

		if ( ! empty( $user_id ) ) {
			$this->log_debug( __METHOD__ . sprintf( '(): User #%d already authenticated.', $user_id ) );

			return $user_id;
		}

		$this->clear_errors();
		$this->log_debug( __METHOD__ . '(): Running.' );

		if ( is_ssl() ) {
			$user_id = $this->perform_basic_authentication();
			if ( $user_id ) {
				return $user_id;
			}

			$user_id = $this->perform_application_password_authentication();
			if ( $user_id ) {
				return $user_id;
			}
		}

		return $this->perform_oauth_authentication();
	}

	/**
	 * Authenticate the user if authentication wasn't performed during the determine_current_user action.
	 *
	 * Necessary in cases where wp_get_current_user() is called before Gravity Forms is loaded.
	 *
	 * @since 2.4.22
	 *
	 * @param WP_Error|null|bool $error Error data.
	 *
	 * @return WP_Error|null|bool
	 */
	public function authentication_fallback( $error ) {
		if ( ! empty( $error ) ) {
			// Another plugin has already declared a failure.
			return $error;
		}

		if ( empty( $this->error ) && empty( $this->auth_method ) && empty( $this->user ) && 0 === get_current_user_id() ) {
			// Authentication hasn't occurred during `determine_current_user`, so check auth.
			$user_id = $this->authenticate( false );
			if ( $user_id ) {
				wp_set_current_user( $user_id );

				return true;
			}
		}

		return $error;
	}

	/**
	 * Check for authentication error.
	 *
	 * @since 2.4-beta-1
	 *
	 * @param WP_Error|null|bool $error Error data.
	 *
	 * @return WP_Error|null|bool
	 */
	public function check_authentication_error( $error ) {
		if ( ! $this->is_request_to_rest_api() ) {
			// Pass through other errors.
			return $error;
		}

		$error = $this->get_error();
		if ( empty( $error ) ) {
			// Indicate auth succeeded.
			return true;
		}

		return $error;
	}

	/**
	 * Set authentication error.
	 *
	 * @since 2.4-beta-1
	 *
	 * @param WP_Error $error Authentication error data.
	 */
	protected function set_error( $error ) {
		// Reset user.
		$this->user = null;

		$this->error = $error;

		$this->log_error( __METHOD__ . '(): ' . json_encode( $error ) );
	}

	/***
	 * Clears all authentication errors and resets user.
	 *
	 * @since 2.4-beta-1
	 */
	protected function clear_errors() {

		// Reset user.
		$this->user = null;

		$this->error = null;
	}

	/**
	 * Get authentication error.
	 *
	 * @since 2.4-beta-1
	 *
	 * @return WP_Error|null.
	 */
	protected function get_error() {
		return $this->error;
	}

	/**
	 * Sets the user property for the authenticated user and clears the error property.
	 *
	 * @since 2.4.22
	 *
	 * @param object $user An object containing the user id and some other optional properties.
	 *
	 * @return int The ID of the authenticated user.
	 */
	protected function set_user( $user ) {
		$this->user  = $user;
		$this->error = null;

		return $this->user->user_id;
	}

	/**
	 * Attempts to authenticate the request using the application password feature introduced in WordPress 5.6.
	 *
	 * @since 2.4.22
	 *
	 * @return false|int False or the ID of the authenticated user.
	 */
	private function perform_application_password_authentication() {
		if ( ! function_exists( 'wp_validate_application_password' ) ) {
			return false;
		}

		$this->log_debug( __METHOD__ . '(): Running.' );
		$this->auth_method = 'application_password';
		$user_id           = wp_validate_application_password( false );

		if ( empty( $user_id ) ) {
			global $wp_rest_application_password_status;
			if ( is_wp_error( $wp_rest_application_password_status ) ) {
				$this->set_error( new WP_Error( 'gform_rest_authentication_error', $wp_rest_application_password_status->get_error_message(), array( 'status' => 401 ) ) );
			}

			$this->log_error( __METHOD__ . '(): Aborting; user not found.' );

			return false;
		}

		$this->log_debug( __METHOD__ . '(): Valid.' );

		return $this->set_user( (object) array( 'user_id' => $user_id ) );
	}

	/**
	 * Basic Authentication.
	 *
	 * SSL-encrypted requests are not subject to sniffing or man-in-the-middle
	 * attacks, so the request can be authenticated by simply looking up the user
	 * associated with the given consumer key and confirming the consumer secret
	 * provided is valid.
	 *
	 * @since 2.4-beta-1
	 *
	 * @return int|bool Returs the authenticated user's User ID if successfull. Otherwise, returns false.
	 */
	private function perform_basic_authentication() {
		$this->log_debug( __METHOD__ . '(): Running.' );

		$this->auth_method = 'basic_auth';
		$consumer_key      = '';
		$consumer_secret   = '';

		// If the $_GET parameters are present, use those first.
		if ( ! empty( $_GET['consumer_key'] ) && ! empty( $_GET['consumer_secret'] ) ) {
			$consumer_key    = $_GET['consumer_key']; // WPCS: sanitization ok.
			$consumer_secret = $_GET['consumer_secret']; // WPCS: sanitization ok.
		}

		// If the above is not present, we will do full basic auth.
		if ( ! $consumer_key && ! empty( $_SERVER['PHP_AUTH_USER'] ) && ! empty( $_SERVER['PHP_AUTH_PW'] ) ) {
			$consumer_key    = $_SERVER['PHP_AUTH_USER']; // WPCS: sanitization ok.
			$consumer_secret = $_SERVER['PHP_AUTH_PW']; // WPCS: sanitization ok.
		}

		// Stop if don't have any key.
		if ( ! $consumer_key || ! $consumer_secret ) {
			$this->log_error( __METHOD__ . '(): Aborting; credentials not found.' );

			return false;
		}

		// Get user data.
		$user = $this->get_user_data_by_consumer_key( $consumer_key );
		if ( empty( $user ) ) {
			$this->log_error( __METHOD__ . '(): Aborting; user not found.' );

			return false;
		}

		// Validate user secret.
		if ( ! hash_equals( $user->consumer_secret, $consumer_secret ) ) {
			$this->set_error( new WP_Error( 'gform_rest_authentication_error', __( 'Consumer secret is invalid.', 'gravityforms' ), array( 'status' => 401 ) ) );

			return false;
		}

		$this->log_debug( __METHOD__ . '(): Valid.' );

		return $this->set_user( $user );
	}

	/**
	 * Parse the Authorization header into parameters.
	 *
	 * @since 2.4-beta-1
	 *
	 * @param string $header Authorization header value (not including "Authorization: " prefix).
	 *
	 * @return array Map of parameter values.
	 */
	public function parse_header( $header ) {
		if ( 'OAuth ' !== substr( $header, 0, 6 ) ) {
			return array();
		}

		// From OAuth PHP library, used under MIT license.
		$params = array();
		if ( preg_match_all( '/(oauth_[a-z_-]*)=(:?"([^"]*)"|([^,]*))/', $header, $matches ) ) {
			foreach ( $matches[1] as $i => $h ) {
				$params[ $h ] = urldecode( empty( $matches[3][ $i ] ) ? $matches[4][ $i ] : $matches[3][ $i ] );
			}
			if ( isset( $params['realm'] ) ) {
				unset( $params['realm'] );
			}
		}

		return $params;
	}

	/**
	 * Get the authorization header.
	 *
	 * On certain systems and configurations, the Authorization header will be
	 * stripped out by the server or PHP. Typically this is then used to
	 * generate `PHP_AUTH_USER`/`PHP_AUTH_PASS` but not passed on. We use
	 * `getallheaders` here to try and grab it out instead.
	 *
	 * @since 2.4-beta-1
	 *
	 * @return string Authorization header if set.
	 */
	public function get_authorization_header() {
		if ( ! empty( $_SERVER['HTTP_AUTHORIZATION'] ) ) {
			return wp_unslash( $_SERVER['HTTP_AUTHORIZATION'] ); // WPCS: sanitization ok.
		}

		if ( function_exists( 'getallheaders' ) ) {
			$headers = getallheaders();
			// Check for the authoization header case-insensitively.
			foreach ( $headers as $key => $value ) {
				if ( 'authorization' === strtolower( $key ) ) {
					return $value;
				}
			}
		}

		return '';
	}

	/**
	 * Get oAuth parameters from $_GET, $_POST or request header.
	 *
	 * @since 2.4-beta-1
	 *
	 * @return array|WP_Error
	 */
	public function get_oauth_parameters() {
		$params = array_merge( $_GET, $_POST ); // WPCS: CSRF ok.
		$params = wp_unslash( $params );
		$header = $this->get_authorization_header();

		if ( ! empty( $header ) ) {
			// Trim leading spaces.
			$header        = trim( $header );
			$header_params = $this->parse_header( $header );

			if ( ! empty( $header_params ) ) {
				$params = array_merge( $params, $header_params );
			}
		}

		$param_names = array(
			'oauth_consumer_key',
			'oauth_timestamp',
			'oauth_nonce',
			'oauth_signature',
			'oauth_signature_method',
		);

		$errors   = array();
		$have_one = false;

		// Check for required OAuth parameters.
		foreach ( $param_names as $param_name ) {
			if ( empty( $params[ $param_name ] ) ) {
				$errors[] = $param_name;
			} else {
				$have_one = true;
			}
		}

		// All keys are missing, so we're probably not even trying to use OAuth.
		if ( ! $have_one ) {
			return array();
		}

		// If we have at least one supplied piece of data, and we have an error,
		// then it's a failed authentication.
		if ( ! empty( $errors ) ) {
			$message = sprintf(
				/* translators: %s: amount of errors */
				_n( 'Missing OAuth parameter %s', 'Missing OAuth parameters %s', count( $errors ), 'gravityforms' ),
				implode( ', ', $errors )
			);

			$this->set_error( new WP_Error( 'gform_rest_authentication_missing_parameter', $message, array( 'status' => 401 ) ) );

			return array();
		}

		return $params;
	}

	/**
	 * Perform OAuth 1.0a "one-legged" (http://oauthbible.com/#oauth-10a-one-legged) authentication for non-SSL requests.
	 *
	 * This is required so API credentials cannot be sniffed or intercepted when making API requests over plain HTTP.
	 *
	 * This follows the spec for simple OAuth 1.0a authentication (RFC 5849) as closely as possible, with two exceptions:
	 *
	 * 1) There is no token associated with request/responses, only consumer keys/secrets are used.
	 *
	 * 2) The OAuth parameters are included as part of the request query string instead of part of the Authorization header,
	 *    This is because there is no cross-OS function within PHP to get the raw Authorization header.
	 *
	 * @link http://tools.ietf.org/html/rfc5849 for the full spec.
	 *
	 * @since 2.4-beta-1
	 *
	 * @return int|bool
	 */
	private function perform_oauth_authentication() {
		$this->log_debug( __METHOD__ . '(): Running.' );

		$this->auth_method = 'oauth1';

		$params = $this->get_oauth_parameters();
		if ( empty( $params ) ) {
			$this->log_error( __METHOD__ . '(): Aborting; OAuth parameters not found.' );

			return false;
		}

		// Fetch WP user by consumer key.
		$user = $this->get_user_data_by_consumer_key( $params['oauth_consumer_key'] );

		if ( empty( $user ) ) {
			$this->set_error( new WP_Error( 'gform_rest_authentication_error', __( 'Consumer key is invalid.', 'gravityforms' ), array( 'status' => 401 ) ) );

			return false;
		}

		// Perform OAuth validation.
		$signature = $this->check_oauth_signature( $user, $params );
		if ( is_wp_error( $signature ) ) {
			$this->set_error( $signature );
			return false;
		}

		$timestamp_and_nonce = $this->check_oauth_timestamp_and_nonce( $user, $params['oauth_timestamp'], $params['oauth_nonce'] );
		if ( is_wp_error( $timestamp_and_nonce ) ) {
			$this->set_error( $timestamp_and_nonce );
			return false;
		}

		$this->log_debug( __METHOD__ . '(): Valid.' );

		return $this->set_user( $user );
	}

	/**
	 * Verify that the consumer-provided request signature matches our generated signature,
	 * this ensures the consumer has a valid key/secret.
	 *
	 * @since 2.4-beta-1
	 *
	 * @param stdClass $user   User data.
	 * @param array    $params The request parameters.
	 * @return true|WP_Error
	 */
	private function check_oauth_signature( $user, $params ) {
		$http_method  = isset( $_SERVER['REQUEST_METHOD'] ) ? strtoupper( $_SERVER['REQUEST_METHOD'] ) : ''; // WPCS: sanitization ok.
		$request_path = isset( $_SERVER['REQUEST_URI'] ) ? parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ) : ''; // WPCS: sanitization ok.
		$wp_base      = get_home_url( null, '/', 'relative' );
		if ( substr( $request_path, 0, strlen( $wp_base ) ) === $wp_base ) {
			$request_path = substr( $request_path, strlen( $wp_base ) );
		}
		$base_request_uri = rawurlencode( get_home_url( null, $request_path, is_ssl() ? 'https' : 'http' ) );

		// Get the signature provided by the consumer and remove it from the parameters prior to checking the signature.
		$consumer_signature = rawurldecode( str_replace( ' ', '+', $params['oauth_signature'] ) );
		unset( $params['oauth_signature'] );

		// Sort parameters.
		if ( ! uksort( $params, 'strcmp' ) ) {
			return new WP_Error( 'gform_rest_authentication_error', __( 'Invalid signature - failed to sort parameters.', 'gravityforms' ), array( 'status' => 401 ) );
		}

		// Normalize parameter key/values.
		$params         = $this->normalize_parameters( $params );
		$query_string   = implode( '%26', $this->join_with_equals_sign( $params ) ); // Join with ampersand.
		$string_to_sign = $http_method . '&' . $base_request_uri . '&' . $query_string;

		if ( 'HMAC-SHA1' !== $params['oauth_signature_method'] && 'HMAC-SHA256' !== $params['oauth_signature_method'] ) {
			return new WP_Error( 'gform_rest_authentication_error', __( 'Invalid signature - signature method is invalid.', 'gravityforms' ), array( 'status' => 401 ) );
		}

		$hash_algorithm = strtolower( str_replace( 'HMAC-', '', $params['oauth_signature_method'] ) );
		$secret         = $user->consumer_secret . '&';
		$signature      = base64_encode( hash_hmac( $hash_algorithm, $string_to_sign, $secret, true ) );

		if ( ! hash_equals( $signature, $consumer_signature ) ) {
			$this->log_debug( __METHOD__ . '(): Signature base: ' . $string_to_sign );

			return new WP_Error( 'gform_rest_authentication_error', __( 'Invalid signature - provided signature does not match.', 'gravityforms' ), array( 'status' => 401 ) );
		}

		return true;
	}

	/**
	 * Creates an array of urlencoded strings out of each array key/value pairs.
	 *
	 * @since 2.4-beta-1
	 *
	 * @param  array  $params       Array of parameters to convert.
	 * @param  array  $query_params Array to extend.
	 * @param  string $key          Optional Array key to append.
	 * @return string               Array of urlencoded strings.
	 */
	private function join_with_equals_sign( $params, $query_params = array(), $key = '' ) {
		foreach ( $params as $param_key => $param_value ) {
			if ( $key ) {
				$param_key = $key . '%5B' . $param_key . '%5D'; // Handle multi-dimensional array.
			}

			if ( is_array( $param_value ) ) {
				$query_params = $this->join_with_equals_sign( $param_value, $query_params, $param_key );
			} else {
				$string         = $param_key . '=' . $param_value; // Join with equals sign.
				$query_params[] = $this->urlencode_rfc3986( $string );
			}
		}

		return $query_params;
	}

	/**
	 * Normalize each parameter by assuming each parameter may have already been
	 * encoded, so attempt to decode, and then re-encode according to RFC 3986.
	 *
	 * Note both the key and value is normalized so a filter param like:
	 *
	 * 'filter[period]' => 'week'
	 *
	 * is encoded to:
	 *
	 * 'filter%255Bperiod%255D' => 'week'
	 *
	 * This conforms to the OAuth 1.0a spec which indicates the entire query string
	 * should be URL encoded.
	 *
	 * @since 2.4-beta-1
	 *
	 * @see rawurlencode()
	 * @param array $parameters Un-normalized parameters.
	 * @return array Normalized parameters.
	 */
	private function normalize_parameters( $parameters ) {
		$keys       = $this->urlencode_rfc3986( array_keys( $parameters ) );
		$values     = $this->urlencode_rfc3986( array_values( $parameters ) );
		$parameters = array_combine( $keys, $values );

		return $parameters;
	}

	/**
	 * Verify that the timestamp and nonce provided with the request are valid. This prevents replay attacks where
	 * an attacker could attempt to re-send an intercepted request at a later time.
	 *
	 * - A timestamp is valid if it is within 15 minutes of now.
	 * - A nonce is valid if it has not been used within the last 15 minutes.
	 *
	 * @since 2.4-beta-1
	 *
	 * @param stdClass $user      User data.
	 * @param int      $timestamp The unix timestamp for when the request was made.
	 * @param string   $nonce     A unique (for the given user) 32 alphanumeric string, consumer-generated.
	 * @return bool|WP_Error
	 */
	private function check_oauth_timestamp_and_nonce( $user, $timestamp, $nonce ) {
		global $wpdb;

		$valid_window = 15 * 60; // 15 minute window.

		if ( ( $timestamp < time() - $valid_window ) || ( $timestamp > time() + $valid_window ) ) {
			return new WP_Error( 'gform_rest_authentication_error', __( 'Invalid timestamp.', 'gravityforms' ), array( 'status' => 401 ) );
		}

		$used_nonces = maybe_unserialize( $user->nonces );

		if ( empty( $used_nonces ) ) {
			$used_nonces = array();
		}

		if ( in_array( $nonce, $used_nonces ) ) {
			return new WP_Error( 'gform_rest_authentication_error', __( 'Invalid nonce - nonce has already been used.', 'gravityforms' ), array( 'status' => 401 ) );
		}

		$used_nonces[ $timestamp ] = $nonce;

		// Remove expired nonces.
		foreach ( $used_nonces as $nonce_timestamp => $nonce ) {
			if ( $nonce_timestamp < ( time() - $valid_window ) ) {
				unset( $used_nonces[ $nonce_timestamp ] );
			}
		}

		$used_nonces = maybe_serialize( $used_nonces );

		$wpdb->update(
			$wpdb->prefix . 'gf_rest_api_keys',
			array( 'nonces' => $used_nonces ),
			array( 'key_id' => $user->key_id ),
			array( '%s' ),
			array( '%d' )
		);

		return true;
	}

	/**
	 * Return the user data for the given consumer_key.
	 *
	 * @since 2.4-beta-1
	 *
	 * @param string $consumer_key Consumer key.
	 * @return array
	 */
	private function get_user_data_by_consumer_key( $consumer_key ) {
		global $wpdb;

		$consumer_key = GFWebAPI::api_hash( sanitize_text_field( $consumer_key ) );
		$user         = $wpdb->get_row(
			$wpdb->prepare(
				"
			SELECT key_id, user_id, permissions, consumer_key, consumer_secret, nonces
			FROM {$wpdb->prefix}gf_rest_api_keys
			WHERE consumer_key = %s
		", $consumer_key
			)
		);

		return $user;
	}


	/**
	 * Check that the API keys provided have the proper key-specific permissions to either read or write API resources.
	 *
	 * @since 2.4-beta-1
	 *
	 * @param string $method Request method.
	 * @return bool|WP_Error
	 */
	private function check_permissions( $method ) {
		if ( ! $this->is_gf_auth_method() ) {
			return true;
		}

		$permissions = $this->user->permissions;

		switch ( $method ) {
			case 'HEAD':
			case 'GET':
				if ( 'read' !== $permissions && 'read_write' !== $permissions ) {
					return new WP_Error( 'gform_rest_authentication_error', __( 'The API key provided does not have read permissions.', 'gravityforms' ), array( 'status' => 401 ) );
				}
				break;
			case 'POST':
			case 'PUT':
			case 'PATCH':
			case 'DELETE':
				if ( 'write' !== $permissions && 'read_write' !== $permissions ) {
					return new WP_Error( 'gform_rest_authentication_error', __( 'The API key provided does not have write permissions.', 'gravityforms' ), array( 'status' => 401 ) );
				}
				break;
			case 'OPTIONS':
				return true;

			default:
				return new WP_Error( 'gform_rest_authentication_error', __( 'Unknown request method.', 'gravityforms' ), array( 'status' => 401 ) );
		}

		return true;
	}

	/**
	 * Updated API Key last access datetime.
	 *
	 * @since 2.4-beta-1
	 *
	 */
	private function update_last_access() {
		if ( ! $this->is_gf_auth_method() ) {
			return;
		}

		global $wpdb;

		$wpdb->update(
			$wpdb->prefix . 'gf_rest_api_keys',
			array( 'last_access' => current_time( 'mysql' ) ),
			array( 'key_id' => $this->user->key_id ),
			array( '%s' ),
			array( '%d' )
		);
	}

	/**
	 * If the consumer_key and consumer_secret $_GET parameters are NOT provided
	 * and the Basic auth headers are either not present or the consumer secret does not match the consumer
	 * key provided, then return the correct Basic headers and an error message.
	 *
	 * @since 2.4-beta-1
	 *
	 * @param WP_REST_Response $response Current response being served.
	 * @return WP_REST_Response
	 */
	public function send_unauthorized_headers( $response ) {
		if ( is_wp_error( $this->get_error() ) && 'basic_auth' === $this->auth_method ) {
			$auth_message = __( 'Gravity Forms API. Use a consumer key in the username field and a consumer secret in the password field.', 'gravityforms' );
			$response->header( 'WWW-Authenticate', 'Basic realm="' . $auth_message . '"', true );
		}

		return $response;
	}

	/**
	 * Check for user permissions and register last access.
	 *
	 * @since 2.4-beta-1
	 *
	 * @param mixed           $result  Response to replace the requested version with.
	 * @param WP_REST_Server  $server  Server instance.
	 * @param WP_REST_Request $request Request used to generate the response.
	 * @return mixed
	 */
	public function check_user_permissions( $result, $server, $request ) {
		if ( ! $this->user ) {
			return $result;
		}

		$this->log_debug( sprintf( '%s(): Running for user #%d.', __METHOD__, $this->user->user_id ) );

		// Check API Key permissions.
		$allowed = $this->check_permissions( $request->get_method() );
		if ( is_wp_error( $allowed ) ) {
			$this->log_error( __METHOD__ . '(): ' . print_r( $allowed, true ) );

			return $allowed;
		}

		// Register last access.
		$this->update_last_access();
		$this->log_debug( __METHOD__ . '(): Permissions valid.' );

		return null;
	}


	/**
	 * Encodes a value according to RFC 3986.
	 * Supports multidimensional arrays.
	 *
	 * @since 2.4-beta-1
	 *
	 * @param string|array $value The value to encode.
	 * @return string|array       Encoded values.
	 */
	public function urlencode_rfc3986( $value ) {
		if ( is_array( $value ) ) {
			return array_map( array( $this, 'urlencode_rfc3986' ), $value );
		} else {
			return str_replace( array( '+', '%7E' ), array( ' ', '~' ), rawurlencode( $value ) );
		}
	}

	/**
	 * Write an error message to the Gravity Forms API log.
	 *
	 * @since 2.4.11
	 *
	 * @param string $message The message to be logged.
	 */
	public function log_error( $message ) {
		GFAPI::log_error( $message );
	}

	/**
	 * Write a debug message to the Gravity Forms API log.
	 *
	 * @since 2.4.11
	 *
	 * @param string $message The message to be logged.
	 */
	public function log_debug( $message ) {
		GFAPI::log_debug( $message );
	}

	/**
	 * Determines if the request is authenticated using credentials generated by Gravity Forms.
	 *
	 * @since 2.4.22
	 *
	 * @return bool
	 */
	private function is_gf_auth_method() {
		return in_array( $this->auth_method, array( 'basic_auth', 'oauth1' ) );
	}

}

new GF_REST_Authentication();
