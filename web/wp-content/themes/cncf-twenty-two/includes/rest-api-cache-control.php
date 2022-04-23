<?php
/**
 * REST API Cache
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

/**
 * The WP REST API is cached heavily by Pantheon so we need to explicitly exclude certain calls from the cache.
 * Modified from https://pantheon.io/docs/mu-plugin#wp-rest-api-wp-json-endpoints-cache and corrected according to
 * this issue https://github.com/LF-Engineering/lfevents/issues/662
 */
$regex_json_path_patterns = array(
	'#^/wp-json/post-meta-controls/v1/?#',
);
foreach ( $regex_json_path_patterns as $regex_json_path_pattern ) {
	if ( preg_match( $regex_json_path_pattern, $_SERVER['REQUEST_URI'] ) ) { //phpcs:ignore
		// re-use the rest_post_dispatch filter in the Pantheon page cache plugin.
		add_filter( 'rest_post_dispatch', 'filter_rest_post_dispatch_send_cache_control', 12, 2 );

		/**
		 * Re-define the send_header value with any custom Cache-Control header.
		 *
		 * @param obj $response Response object.
		 * @param obj $server Server object.
		 */
		function filter_rest_post_dispatch_send_cache_control( $response, $server ) {
			$response->header( 'Cache-Control', 'no-cache, must-revalidate, max-age=0' );
			return $response;
		}
		break;
	}
}
