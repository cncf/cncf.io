<?php
/**
 * End User Playlist Shortcode
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

 /**
  * Add End User Playlist shortcode.
  *
  * @param array $atts Attributes.
  */
function add_eu_playlist_shortcode( $atts ) {

	// Attributes.
	$atts = shortcode_atts(
		array(
			'count' => 3, // set default.
			'key' => '',
		),
		$atts,
		'eu_playlist'
	);

	// need to enqueue youtube lite script.
	wp_enqueue_script(
		'youtube-lite-js',
		home_url() . '/wp-content/mu-plugins/wp-mu-plugins/lf-blocks/src/youtube-lite/scripts/lite-youtube.js',
		is_admin() ? array( 'wp-editor' ) : null,
		filemtime( WPMU_PLUGIN_DIR . '/wp-mu-plugins/lf-blocks/dist/blocks.build.js' ),
		true
	);

	$count = $atts['count'];
	$key = $atts['key'];

	if ( ! is_int( $count ) || ! $key ) {
		return;
	}
	$eu_playlist = wp_cache_get( 'cncf_eu_playlist' );
	if ( false === $eu_playlist ) {

		$request = wp_remote_get( 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=50&playlistId=PLj6h78yzYM2MiFgpFi1ci4i94A50LeZ40&key=' . $key );
		$eu_playlist = wp_remote_retrieve_body( $request );

		wp_cache_set( 'cncf_eu_playlist', $eu_playlist, '', 6 * HOUR_IN_SECONDS );
	}
	$eu_playlist = json_decode( $eu_playlist );

	ob_start();

	echo '<div class="wp-block-columns">';
	for ( $i = 0; $i < $count; $i++ ) {
		echo '<div class="wp-block-column">';
		if ( array_key_exists( $i, $eu_playlist->items ) ) {
			$pub_date = new DateTime( $eu_playlist->items[ $i ]->snippet->publishedAt );
			echo '<div class="wp-block-lf-youtube-lite"><lite-youtube videoid="' . esc_attr( $eu_playlist->items[ $i ]->snippet->resourceId->videoId ) . '"></lite-youtube></div>';
			echo '<h5 class="newsroom-title"><a href="https://www.youtube.com/watch?v=' . esc_attr( $eu_playlist->items[ $i ]->snippet->resourceId->videoId ) . '&list=PLj6h78yzYM2MiFgpFi1ci4i94A50LeZ40" target="_blank" title="' . esc_attr( $eu_playlist->items[ $i ]->snippet->title ) . '">' . esc_attr( $eu_playlist->items[ $i ]->snippet->title ) . '</a></h5>';
			echo '<span class="newsroom-date date-icon">' . esc_html( $pub_date->format( 'F j, Y' ) ) . '</span>';
		}
		echo '</div>';
	}
	echo '</div>';
	$block_content = ob_get_clean();
	return $block_content;

}
add_shortcode( 'eu_playlist', 'add_eu_playlist_shortcode' );
