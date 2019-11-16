<?php
/* @package   GFP_Salesforce\GFP_Salesforce_OAuth2
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 * @copyright 2017-2019 gravity+
 * @license   GPL-2.0+
 * @since     0.1
 */

/**
 * @since  0.1
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
class GFP_Salesforce_OAuth2 {

	/**
	 * Consumer or client key
	 *
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @var string
	 */
	protected $_client_id;

	/**
	 * Consumer or client secret
	 *
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @var string
	 */
	protected $_client_secret;

	/**
	 * Callback or Redirect URL
	 *
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @var string
	 */
	protected $_callback;

	/**
	 * Access token returned by OAuth server
	 *
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @var string
	 */
	protected $_access_token;

	/**
	 * Unix timestamp for when token expires
	 *
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @var string
	 */
	protected $_expires;

	/**
	 * OAuth2 refresh token
	 *
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @var string
	 */
	protected $_refresh_token;

	/**
	 * OAuth2 token type
	 *
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @var string
	 */
	protected $_token_type;

	/**
	 * Set to true if a refresh token was used to update an access token
	 *
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @var bool
	 */
	protected $_access_token_updated = false;

	/**
	 * OAuth2 redirect type
	 *
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @var string
	 */
	protected $_redirect_type = 'code';

	/**
	 * OAuth2 scope
	 *
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @var string
	 */
	protected $_scope = array();

	/**
	 * Authorize URL
	 *
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @var string
	 */
	protected $_authorize_url;

	/**
	 * Access token URL
	 *
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @var string
	 */
	protected $_access_token_url;

	/**
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @var \GFP_Salesforce_Psr_Logger_Interface
	 */
	private $logger;

	/**
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @var int
	 */
	private $try_refreshing = 0;


	/**************************************************
	 * AUTHORIZATION                                  *
	 *                                                *
	 **************************************************/

	/**
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param string $base_url URL of the Salesforce instance
	 * @param string $client_key
	 * @param string $client_secret
	 * @param string $access_token
	 * @param string $access_token_expires
	 * @param string $callback
	 * @param string $scope
	 * @param string $refresh_token
	 */
	public function __construct( $base_url = null, $client_key = null, $client_secret = null, $access_token = null, $access_token_expires = null, $callback = null, $scope = null, $refresh_token = null ) {

		$this->_client_id           = $client_key;
		$this->_client_secret       = $client_secret;
		$this->_access_token        = $access_token;
		$this->_callback            = $callback;

		if ( $base_url ) {

			if ( ! $this->_access_token_url ) {

				$this->_access_token_url = $base_url . '/token';

			}

			if ( ! $this->_authorize_url ) {

				$this->_authorize_url = $base_url . '/authorize';

			}

		}

		if ( ! empty( $scope ) ) {

			$this->set_scope( $scope );

		}

		if ( ! empty( $access_token ) ) {

			$this->set_access_token_details(
				array(
					'access_token'        => $access_token,
					'expires'             => $access_token_expires,
					'refresh_token'       => $refresh_token
				)
			);
		}
	}

	/**
	 * Set authorization URL
	 *
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $url
	 *
	 * @return $this
	 */
	public function set_authorize_url( $url ) {

		$this->_authorize_url = $url;

		return $this;
	}

	/**
	 * Set access token URL
	 *
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $url
	 *
	 * @return $this
	 */
	public function set_access_token_url( $url ) {

		$this->_access_token_url = $url;

		return $this;
	}

	/**
	 * Set redirect type for OAuth2
	 *
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $type
	 *
	 * @return $this
	 */
	public function set_redirect_type( $type ) {

		$this->_redirect_type = $type;

		return $this;
	}

	/**
	 * Set OAuth2 scope
	 *
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param array|string $scope
	 *
	 * @return $this
	 */
	public function set_scope( $scope ) {

		if ( ! is_array( $scope ) ) {

			$this->_scope = explode( ',', $scope );

		} else {

			$this->_scope = $scope;

		}

		return $this;
	}

	/**
	 * Set an existing/already retrieved access token
	 *
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param array $access_token_details
	 *
	 * @return $this
	 */
	public function set_access_token_details( array $access_token_details ) {

		$this->_access_token        = isset( $access_token_details[ 'access_token' ] ) ? $access_token_details[ 'access_token' ] : null;
		
		$this->_expires             = isset( $access_token_details[ 'expires' ] ) ? $access_token_details[ 'expires' ] : null;
		
		$this->_refresh_token       = isset( $access_token_details[ 'refresh_token' ] ) ? $access_token_details[ 'refresh_token' ] : null;

		
		return $this;
	}

	/**
	 * Returns access token data
	 *
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return array
	 */
	public function get_access_token_data() {

		return array(
			'access_token'  => $this->_access_token,
			'expires'       => $this->_expires,
			'token_type'    => $this->_token_type,
			'refresh_token' => $this->_refresh_token
		);
	}

	/**
	 * Check to see if the access token was updated from a refresh token
	 *
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return bool
	 */
	public function access_token_updated() {

		return $this->_access_token_updated;
	}

	/**
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function is_authorized() {

		if ( ! empty( $this->_expires ) && $this->_expires < time() ) {
			
			return false;
		
		}

		if ( strlen( $this->_access_token ) > 0 ) {
			
			return true;
		
		}

		return false;
	}

	/**
	 * Request access token
	 *
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param string $method
	 * @param array  $params
	 * @param string $response_type
	 *
	 * @return bool
	 * @throws Exception
	 */
	public function request_access_token( $method = 'POST', array $params = array(), $response_type = 'flat' ) {

		$this->logger->debug( __METHOD__ );

		$parameters = array(
			'client_id'     => $this->_client_id,
			'redirect_uri'  => $this->_callback,
			'client_secret' => $this->_client_secret,
			'grant_type'    => 'authorization_code'
		);

		if ( isset( $_GET[ 'code' ] ) ) {

			$parameters[ 'code' ] = $_GET[ 'code' ];

		}

		if ( strlen( $this->_refresh_token ) > 0 ) {

			$this->logger->debug( 'Using refresh token' );

			$parameters[ 'grant_type' ] = 'refresh_token';

			$parameters[ 'refresh_token' ] = $this->_refresh_token;

		}

		$parameters = array_merge( $parameters, $params );


		$settings = array(
			'response_type'    => $response_type,
			'include_callback' => true,
			'include_verifier' => true
		);

		$params_request = $this->make_request( $this->_access_token_url, $parameters, $method, $settings );

		if ( is_array( $params_request ) && $params_request['success'] ) {
			
			$params = $params_request['response'];

			if ( isset( $params[ 'access_token' ] ) ) {

				$this->logger->debug( 'access token set as ' . $params[ 'access_token' ] );

				$this->_access_token         = $params[ 'access_token' ];

				$this->_token_type           = ( isset( $params[ 'token_type' ] ) ) ? $params[ 'token_type' ] : null;

				if ( isset( $params[ 'refresh_token' ] ) ) {

					$this->_refresh_token = $params[ 'refresh_token' ];

				}

				$this->_access_token_updated = true;

				return true;
			}

		}

		$this->logger->debug( 'response did not have an access token' );

		if ( is_array( $params ) ) {

			if ( isset( $params[ 'error' ] ) ) {

				$response = $params[ 'error' ];

			} else {

				$response = '???';

			}

		} else {

			$response = $params;

		}

		throw new Exception( 'Incorrect access token parameters returned: ' . $response );
	}

	/**
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param array  $scope
	 * @param string $scope_separator
	 * @param null   $attach
	 *
	 * @return string
	 */
	public function build_authorization_url( array $scope = array(), $scope_separator = ' ', $attach = null ) {

		$auth_url = $this->_authorize_url;

		$auth_url .= '?client_id=' . $this->_client_id . '&redirect_uri=' . rawurlencode( $this->_callback ) . '&scope=' . rawurlencode( implode( $scope_separator, $scope ) );


		$state = md5( time() . mt_rand() );


		update_option( 'gravityformssalesforce_auth_state', $state );


		$auth_url .= '&state=' . $state;

		$auth_url .= '&response_type=' . $this->_redirect_type;

		$this->logger->debug( 'Authorization URL:' . $auth_url );


		return $auth_url;

	}

	/**************************************************
	 * HELPERS                                        *
	 *                                                *
	 **************************************************/

	/**
	 * Make HTTP request
	 *
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param string        $api_url
	 * @param string|array  $parameters
	 * @param string        $method
	 * @param array         $settings
	 *
	 * @return array
	 */
	public function make_request( $api_url, $parameters = array(), $method = 'GET', array $settings = array() ) {

		$this->logger->debug( __METHOD__ );

		$response = array();

		$success = false;


		$original_api_url = $api_url;

		$original_parameters = $parameters;

		$original_method = $method;

		$original_settings = $settings;


		$method = strtoupper( $method );

		$this->logger->debug( "API URL: {$api_url}" );

		$this->logger->debug( 'Parameters:' . print_r( $parameters, true ) );

		$this->logger->debug( "Method: {$method}" );

		$arguments = array(
			'timeout'      => 30,
			'sslverify'    => false,
			'headers'      => empty( $parameters['grant_type'] ) ? array( 'Content-Type' => 'application/json' ) : array(),
			'body'         => empty( $parameters ) ? array() : $parameters
		);


		$add_access_token = true;

		if ( ( is_array( $parameters ) &&  ! empty( $parameters['grant_type'] ) ) || empty( $this->_access_token ) ) {

			$add_access_token = false;

		}

		if ( $add_access_token ) {

			$arguments[ 'headers' ][ 'Authorization' ] = "Bearer {$this->_access_token}";
		}

		$this->logger->debug( 'Arguments: ' . print_r( $arguments, true ) );

		switch ( $method ) {

			case 'GET':

				$raw_response = wp_remote_get( $api_url, $arguments );

				break;

			case 'POST':

				$raw_response = wp_remote_post( $api_url, $arguments );

				break;

			default:

				$raw_response = wp_remote_request( $api_url, array_merge( array( 'method' => $method ), $arguments ) );

				break;
		}

		$response = json_decode( wp_remote_retrieve_body( $raw_response ), true );

		if ( is_wp_error( $raw_response ) || ( ! in_array( wp_remote_retrieve_response_code( $raw_response ), array(
				200,
				201, 204
			) ) )
		) {

			$this->logger->error( 'Error: ' . print_r( $response, true ) );

			if ( 401 == wp_remote_retrieve_response_code( $raw_response ) && 2 > $this->try_refreshing ) {

				$this->try_refreshing ++;

				try {

					if ( $this->request_access_token() && $this->access_token_updated() ) {

						$new_access_token_data = $this->get_access_token_data();


						global $gravityformssalesforce;


						$current_settings = $gravityformssalesforce->get_addon_object()->get_plugin_settings();

						$current_settings[ 'oauth_data' ] = $new_access_token_data;


						update_option( 'gravityformsaddon_gravityformssalesforce_settings', $current_settings );


						return $this->make_request( $original_api_url, $original_parameters, $original_method, $original_settings );

					}

				} catch ( Exception $e ) {
				}
			}

		} else {

			if ( empty( $response ) ) {

				$response = $raw_response[ 'response' ][ 'message' ];

			}

			$this->logger->debug( "Success. " );

			$success = true;

		}


		return array( 'success' => $success, 'response' => $response );

	}

	/**
	 * Get the logger.
	 *
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return \GFP_Salesforce_Psr_Logger_Interface
	 */
	public function get_logger() {

		return $this->logger;

	}

	/**
	 * Sets a logger.
	 *
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param \GFP_Salesforce_Psr_Logger_Interface $logger
	 *
	 * @return $this
	 */
	public function set_logger( $logger ) {

		$this->logger = $logger;

		return $this;

	}

}
