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
		$version   = '1';
		$namespace = 'lf/v' . $version;

		register_rest_route(
			$namespace,
			'/sync_people',
			array(
				array(
					'methods'             => WP_REST_Server::ALLMETHODS,
					'callback'            => array( $this, 'sync_people' ),
					'permission_callback' => '__return_true',
					'args'                => array(),
				),
			)
		);

		register_rest_route(
			$namespace,
			'/get_hello',
			array(
				array(
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => array( $this, 'get_hello' ),
					'permission_callback' => '__return_true',
					'args'                => array(),
				),
			)
		);
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
			if ( 'people' === $json->repository->name && 'closed' === $json->action && true === $json->pull_request->merged ) {
				// sync people after 6 minutes.
				// This delay is required in order for GitHub to update its raw files with the people data.
				wp_schedule_single_event( time() + 360, 'lf_sync_people' );
				return new WP_REST_Response( array( 'Success. People synced.' ), 200 );
			}
		}

		return new WP_REST_Response( array( 'Success' ), 200 );
	}

	/**
	 * Get hello bar data.
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|WP_REST_Response
	 */
	public function get_hello( $request ) {
		$items = array();

		$options                    = get_option( 'lf-mu' );
		$items['show_hello_bar']    = ( isset( $options['show_hello_bar'] ) && ! empty( $options['show_hello_bar'] ) ) ? 1 : 0;
		$items['hello_bar_content'] = ( isset( $options['hello_bar_content'] ) && ! empty( $options['hello_bar_content'] ) ) ? $options['hello_bar_content'] : '';
		$items['hello_bar_bg']      = ( isset( $options['hello_bar_bg'] ) && ! empty( $options['hello_bar_bg'] ) ) ? esc_attr( $options['hello_bar_bg'] ) : '';
		$items['hello_bar_text']    = ( isset( $options['hello_bar_text'] ) && ! empty( $options['hello_bar_text'] ) ) ? esc_attr( $options['hello_bar_text'] ) : '';

		return new WP_REST_Response( $items, 200 );
	}
}
