<?php
/**
 * End Users Shortcode
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

 /**
  * Add End Users shortcode.
  *
  * @param array $atts Attributes.
  */
function add_endusers_shortcode( $atts ) {

	// Attributes.
	$atts = shortcode_atts(
		array(
			'count' => 5, // set default.
		),
		$atts,
		'endusers'
	);

	$count = $atts['count'];

	if ( ! is_int( $count ) ) {
		return;
	}

	if ( false === ( $endusers = wp_cache_get( 'cncf_latest_endusers' ) ) ) {

		$request = wp_remote_get( 'https://landscape.cncf.io/data/exports/end-users-reverse-chronological.json' );
		$endusers = wp_remote_retrieve_body( $request );

		wp_cache_set( 'cncf_latest_endusers', $endusers, '', HOUR_IN_SECONDS );
	}
	$endusers = json_decode( $endusers );

	ob_start();
	?>
<div class="enduser-wrapper">
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
add_shortcode( 'endusers', 'add_endusers_shortcode' );
