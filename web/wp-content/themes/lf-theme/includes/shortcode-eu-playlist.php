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
			'count' => 2, // set default.
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
	$eu_playlist = get_transient( 'cncf_eu_playlist' );
	if ( false === $eu_playlist ) {

		$request = wp_remote_get( 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet,contentDetails&maxResults=' . $count . '&playlistId=PLj6h78yzYM2MiFgpFi1ci4i94A50LeZ40&key=' . $key );
		if ( is_wp_error( $request ) || ( wp_remote_retrieve_response_code( $request ) != 200 ) ) {
			return;
		}
		$eu_playlist = wp_remote_retrieve_body( $request );

		set_transient( 'cncf_eu_playlist', $eu_playlist, 6 * HOUR_IN_SECONDS );
	}
	$eu_playlist = json_decode( $eu_playlist );

	ob_start();
	?>
<section class="end-users-playlist">
	<?php
	for ( $i = 0; $i < $count; $i++ ) {
		if ( array_key_exists( $i, $eu_playlist->items ) ) {

			$pub_date = new DateTime( $eu_playlist->items[ $i ]->contentDetails->videoPublishedAt );

			?>
	<div class="newsroom-post-wrapper">
<div class="">
<div class="wp-block-lf-youtube-lite">
<lite-youtube videoid="<?php echo esc_attr( $eu_playlist->items[ $i ]->snippet->resourceId->videoId ); ?>">
</lite-youtube></div></div>

<h5 class="newsroom-title"><a href="https://www.youtube.com/watch?v=<?php echo esc_attr( $eu_playlist->items[ $i ]->snippet->resourceId->videoId ); ?>&list=PLj6h78yzYM2MiFgpFi1ci4i94A50LeZ40" target="_blank" title="<?php echo esc_attr( $eu_playlist->items[ $i ]->snippet->title ); ?> "><?php echo esc_attr( $eu_playlist->items[ $i ]->snippet->title ); ?></a></h5>

<span class="newsroom-date live-icon"><?php echo esc_html( $pub_date->format( 'F j, Y' ) ); ?></span>
</div>
			<?php
		}
	}
	?>

</section>
	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'eu_playlist', 'add_eu_playlist_shortcode' );
