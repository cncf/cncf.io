<?php
/* @package   GFP_Salesforce
 * @copyright 2017-2019 gravity+
 * @license   GPL-2.0+
 * @since     0.1
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class GFP_Salesforce_API
 *
 * Handles Salesforce API calls
 *
 * @since  0.1
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
class GFP_Salesforce_API {

	/**
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @var GFP_Salesforce_OAuth2
	 */
	protected $auth = null;

	/**
	 * PSR-3 compliant logger
	 *
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *         
	 * @var GFP_Salesforce_API_Logger
	 */
	protected $logger = null;

	/**
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *         
	 * @var string
	 */
	protected $base_url = '';

	/**
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @var string
	 */
	protected $version = '40.0';


	/**************************************************
	 * AUTHORIZATION                                  *
	 *                                                *
	 **************************************************/

	/**
	 * Setup authorization settings
	 *
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $instance
	 * @param $client_key
	 * @param $client_secret
	 * @param $callback
	 * @param $oauth_data
	 */
	public function __construct( $instance, $sandbox, $client_key, $client_secret, $callback, $oauth_data ) {

		$access_token = empty( $oauth_data ) ? null : $oauth_data[ 'access_token' ];
		
		$refresh_token = empty( $oauth_data ) ? null : $oauth_data[ 'refresh_token' ];

		$this->base_url = "https://{$instance}.salesforce.com/services/data/";

		$salesforce_auth_prefix = empty( $sandbox ) ? 'login' : 'test';

		$this->auth = new GFP_Salesforce_OAuth2( "https://{$salesforce_auth_prefix}.salesforce.com/services/oauth2", $client_key, $client_secret, $access_token, null, $callback, null, $refresh_token );

		$this->logger = new GFP_Salesforce_API_Logger();

		$this->auth->set_logger( $this->logger->log );

		$versions = $this->versions();

		if ( $versions['success'] ) {

			$latest_version = end( $versions['response'] );

			$this->version = $latest_version['version'];

		}

	}

	/**
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return string
	 */
	public function get_authorization_url() {

		$this->logger->log->debug( __METHOD__ );

		$authorization_url = '';

		$already_authorized = $this->auth->is_authorized();

		if ( ! $already_authorized ) {

			$authorization_url = $this->auth->build_authorization_url( array('full', 'refresh_token'));

		}


		return $authorization_url;

	}

	/**
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return bool
	 */
	public function validate_access_token() {

		$this->logger->log->debug( __METHOD__ );

		$valid = false;

		$access_token_data = $this->auth->get_access_token_data();

		if ( ! empty( $access_token_data[ 'access_token' ] ) ) {

			$valid = true;

		}

		return $valid;
	}

	/**
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function save_new_access_token_data() {

		$this->logger->log->debug( __METHOD__ );

		
		$new_access_token_data = $this->auth->get_access_token_data();


		global $gravityformssalesforce;
		
		$addon_object = $gravityformssalesforce->get_addon_object();

		
		$current_settings = $addon_object->get_plugin_settings();

		$current_settings[ 'oauth_data' ] = $new_access_token_data;


		update_option( 'gravityformsaddon_' . $addon_object->get_slug() . '_settings', $current_settings );

	}

	/**
	 * Salesforce authorization step 2
	 *
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return bool
	 */
	public function finish_authorization() {

		$this->logger->log->debug( __METHOD__ );

		if ( isset( $_GET[ 'code' ] ) ) {

			if ( get_option( 'gravityformssalesforce_auth_state' ) != $_GET[ 'state' ] ) {

				delete_option( 'gravityformssalesforce_auth_state' );

				return false;

			}

			delete_option( 'gravityformssalesforce_auth_state' );

			try {

				$this->auth->request_access_token( 'POST', array(), 'json' );

				if ( $this->auth->access_token_updated() ) {

					$this->save_new_access_token_data();

					//TODO get list of objects to make sure instance name is correct

					return true;

				} else {

					return false;
				}

			} catch ( Exception $e ) {

				return false;

			}

		} else {

			return false;
		}

	}

	/**************************************************
	 * MAIN                                           *
	 *                                                *
	 **************************************************/

	/**
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return array
	 */
	public function versions() {
		
		return $this->auth->make_request( $this->base_url );
	}

	/**
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return array
	 */
	public function resources_by_version() {

		return $this->auth->make_request( "{$this->base_url}v{$this->version}/" );

	}

	/**
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return array
	 */
	public function describe_global() {

		return $this->auth->make_request( "{$this->base_url}v{$this->version}/sobjects/" );

	}

	/**
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $object
	 *
	 * @return array
	 */
	public function basic_information( $object ) {

		return $this->auth->make_request( "{$this->base_url}v{$this->version}/sobjects/{$object}/" );

	}

	/**
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $object
	 *
	 * @return array
	 */
	public function describe( $object ) {

		return $this->auth->make_request( "{$this->base_url}v{$this->version}/sobjects/{$object}/describe/" );
	}

	/**
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $object
	 * @param $data
	 * @param $settings
	 *
	 * @return array
	 */
	public function create_record( $object, $data, $settings ) {
		
		return $this->auth->make_request( "{$this->base_url}v{$this->version}/sobjects/{$object}/", json_encode( $data ), 'POST' );

	}

	/**
	 * @since  1.3.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $object
	 * @param $data
	 * @param $settings
	 *
	 * @return array
	 */
	public function create_composite_record( $object, $data, $settings ) {

		return $this->auth->make_request( "{$this->base_url}v{$this->version}/composite/tree/{$object}/", json_encode( $data ), 'POST' );

	}

	/**
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $object
	 * @param $id
	 * @param $data
	 *
	 * @return array
	 */
	public function update_record( $object, $id, $data ) {
		
		return $this->auth->make_request( "{$this->base_url}v{$this->version}/sobjects/{$object}/{$id}/", json_encode( $data ), 'PATCH' );

	}

	/**
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $object
	 * @param $id
	 *
	 * @return array
	 */
	public function retrieve_record( $object, $id ) {

		return $this->auth->make_request( "{$this->base_url}v{$this->version}/sobjects/{$object}/{$id}/" );

	}

	/**
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $object
	 * @param $id
	 */
	public function delete_record( $object, $id ) {
	}

	/**
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $object
	 * @param $start_time
	 * @param $end_time
	 *
	 * @return array
	 */
	public function get_updated( $object, $start_time, $end_time ) {
		
		return $this->auth->make_request( "{$this->base_url}v{$this->version}/sobjects/{$object}/updated/", array( 'start' => $start_time, 'end' => $end_time ) );

	}

	/**
	 * SOQL
	 *
	 * SOQL statements cannot exceed 20,000 characters in length
	 *
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $query
	 *
	 * @return array
	 */
	public function query( $query ) {

		return $this->auth->make_request( "{$this->base_url}v{$this->version}/query/", array( 'q' => $query ) );

	}

	/**************************************************
	 * HELPERS                                        *
	 *                                                *
	 **************************************************/

}