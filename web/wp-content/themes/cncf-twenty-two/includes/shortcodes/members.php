<?php
/**
 * Shortcodes for Members
 *
 * Usage:
 * [cncf_members_latest category="endusers|members|platinum" count=20 size="small|medium|large"]
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

/**
 *  Latest CNCF Members shortcode.
 *
 * @param array $atts Attributes.
 */
function add_cncf_members_latest_shortcode( $atts ) {

	// Attributes.
	$atts = shortcode_atts(
		array(
			'count'    => 10, // set default.
			'category' => 'endusers', // endusers, members, platinum.
			'size'     => 'large', // small, medium, large.
		),
		$atts,
		'cncf_members_latest'
	);

	// make sure we have a number.
	$count = intval( $atts['count'] );

	// if no number, something wrong.
	if ( ! is_int( $count ) ) {
		return;
	}

	$atts['category'] = strtolower( $atts['category'] );
	$atts['size']     = strtolower( $atts['size'] );

	if ( 'endusers' !== $atts['category'] ) {
		return;
	}

	$transient_name = 'cncf_latest_endusers';
	$remote_url     = 'https://landscape.cncf.io/api/members/end-users.json';
	$members_array  = get_transient( $transient_name );

	if ( false === $members_array ) {

		$request = wp_remote_get( $remote_url );

		if ( is_wp_error( $request ) || ( wp_remote_retrieve_response_code( $request ) != 200 ) ) {
			return;
		}

		$members_array = wp_remote_retrieve_body( $request );

		if ( WP_DEBUG === false ) {
			set_transient( $transient_name, $members_array, 6 * HOUR_IN_SECONDS );
		}
	}

	$members_array = json_decode( $members_array );

	// Loop through the array and remove non-object elements without "joined_at".
	foreach ( $members_array as $key => $item ) {
		if ( ! is_object( $item ) || ! property_exists( $item, 'joined_at' ) ) {
			unset( $members_array[ $key ] );
		}
	}

	usort(
		$members_array,
		function ( $a, $b ) {
			return -strcmp( $a->joined_at, $b->joined_at );
		}
	);

	if ( ! is_array( $members_array ) ) {
		return;
	}

	// if the array is smaller than the count then use the array count for the loop.
	$array_count = count( $members_array );
	if ( $array_count < $count ) {
		$count = $array_count;
	}

	ob_start();
	?>
<div class="members <?php echo esc_html( 'logo_' . $atts['size'] ); ?>">
	<?php
	for ( $i = 0; $i < $count; $i++ ) {
		echo '<img decoding="async" width="105" height="40" loading="lazy" src="' . esc_url( $members_array[ $i ]->logo_url ) . '" alt="' . esc_attr( $members_array[ $i ]->name ) . '">';
	}
	?>
</div>
	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'cncf_members_latest', 'add_cncf_members_latest_shortcode' );
