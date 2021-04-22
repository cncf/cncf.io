<?php
/**
 * Latest End Users Shortcode
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

 /**
  * Add Latest End Users shortcode.
  *
  * @param array $atts Attributes.
  */
function add_eu_latest_shortcode( $atts ) {

	// Attributes.
	$atts = shortcode_atts(
		array(
			'count' => 10, // set default.
		),
		$atts,
		'eu_latest'
	);

	$count = intval( $atts['count'] );

	if ( ! is_int( $count ) ) {
		return;
	}

	$endusers = get_transient( 'cncf_latest_endusers' );
	if ( false === $endusers ) {

		$request = wp_remote_get( 'https://landscape.cncf.io/data/exports/end-users-reverse-chronological.json' );
		if ( is_wp_error( $request ) || ( wp_remote_retrieve_response_code( $request ) != 200 ) ) {
			return;
		}

		$endusers = wp_remote_retrieve_body( $request );

		if ( WP_DEBUG === false ) {
			set_transient( 'cncf_latest_endusers', $endusers, 6 * HOUR_IN_SECONDS );
		}
	}
	$endusers = json_decode( $endusers );

	ob_start();
	?>
<div class="enduser-latest-wrapper">
	<?php
	for ( $i = 0; $i < $count; $i++ ) {
		echo '<img src="' . esc_url( $endusers[ $i ]->logo ) . '" alt="' . esc_attr( $endusers[ $i ]->name ) . '">';
	}
	?>
</div>
	<?php
	$block_content = ob_get_clean();
	return $block_content;

}
add_shortcode( 'eu_latest', 'add_eu_latest_shortcode' );
