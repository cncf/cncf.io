<?php
/**
 * Registers controller for LF API endpoints.
 *
 * @link       https://www.cncf.io/
 * @since      1.0.0
 *
 * @package    Lf_Mu
 * @subpackage Lf_Mu/includes
 */

/**
 * Registers controller for LF API endpoints.
 * Class template comes from https://developer.wordpress.org/rest-api/extending-the-rest-api/adding-custom-endpoints/#examples.
 *
 * @since      1.0.0
 * @package    Lf_Mu
 * @subpackage Lf_Mu/includes
 * @author     Chris Abraham <cjyabraham@gmail.com>
 */
class LF_MU_REST_Controller extends WP_REST_Controller {

	/**
	 * Register the routes for the objects of the controller.
	 */
	public function register_routes() {
		$version = '1';
		$namespace = 'lf/v' . $version;
		$base = 'sync_people';
		register_rest_route( $namespace, '/' . $base, array(
			array(
			'methods'             => WP_REST_Server::ALLMETHODS,
			'callback'            => array( $this, 'sync_people' ),
			'permission_callback' => '__return_true',
			'args'                => array(
			),
			),
		) );
	}

	/**
	 * Sync People with the GitHub People repo.
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|WP_REST_Response
	 */
	public function sync_people( $request ) {
	
		if ( ! is_object( $request ) ) {
			return new WP_Error( 'error', esc_html__( 'Error with the request object.' ), array( 'status' => 500 ) );
		}

		$json = json_decode( $request->get_body() );

		if ( is_object( $json ) && property_exists( $json, 'repository' ) && property_exists( $json, 'action' ) && property_exists( $json, 'pull_request' ) ) {
			if ( 'nextarch' === $json->repository->name && 'closed' === $json->action && true === $json->pull_request->merged ) {
				// sync people.
				wp_schedule_single_event( time(), 'lf_sync_people' );
				return new WP_REST_Response( array( 'Success. People synched.' ), 200 );
			}
		}

		return new WP_REST_Response( array( 'Success' ), 200 );
	}

}
