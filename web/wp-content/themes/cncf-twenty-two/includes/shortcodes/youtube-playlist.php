<?php
/**
 * YouTube Playlist
 *
 * Usage:
 * [youtube_playlist playlist="members|endusers" count=4]
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

/**
 * YouTube Playlist shortcode.
 *
 * @param array $atts Attributes.
 */
function add_playlist_shortcode( $atts ) {

	// Attributes.
	$atts = shortcode_atts(
		array(
			'count'    => 2, // set default.
			'playlist' => 'endusers', // set default.
		),
		$atts,
		'youtube_playlist'
	);

	$site_options = get_option( 'lf-mu' );
	if ( isset( $site_options['youtube_api_key'] ) && $site_options['youtube_api_key'] ) {
		$youtube_api_key = $site_options['youtube_api_key'];
	} else {
		echo 'Please set YouTube API key in site options.';
		return;
	}

	$count    = intval( $atts['count'] );
	$playlist = trim( $atts['playlist'] );

	if ( ! is_int( $count ) || ! $youtube_api_key ) {
		return;
	}

	// need to enqueue youtube lite script.
	wp_enqueue_script(
		'youtube-lite-js',
		home_url() . '/wp-content/mu-plugins/wp-mu-plugins/lf-blocks/src/youtube-lite/scripts/lite-youtube.js',
		null,
		filemtime( WPMU_PLUGIN_DIR . '/wp-mu-plugins/lf-blocks/dist/blocks.build.js' ),
		true
	);

	switch ( $playlist ) {
		case 'endusers':
			$playlist_id    = 'PLj6h78yzYM2MiFgpFi1ci4i94A50LeZ40';
			$transient_name = 'cncf_eu_playlist';
			break;
		case 'members':
			$playlist_id    = 'PLj6h78yzYM2Mh0PGvD6jcn_MSNlvg4cWn';
			$transient_name = 'cncf_member_playlist';
			break;
		default:
			$playlist_id    = 'PLj6h78yzYM2MiFgpFi1ci4i94A50LeZ40';
			$transient_name = 'cncf_eu_playlist';
			break;
	}

	$composed_playlist = get_transient( $transient_name );

	if ( false === $composed_playlist || WP_DEBUG === true ) {

		$request = wp_remote_get( 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet,contentDetails&maxResults=20&playlistId=' . $playlist_id . '&key=' . $youtube_api_key );

		if ( is_wp_error( $request ) || ( wp_remote_retrieve_response_code( $request ) !== 200 ) ) {
			return;
		}

		$composed_playlist = wp_remote_retrieve_body( $request );

		if ( WP_DEBUG === false ) {
			set_transient( $transient_name, $composed_playlist, 6 * HOUR_IN_SECONDS );
		}
	}

	$composed_playlist = json_decode( $composed_playlist );

	ob_start();
	?>
<section class="youtube-playlist columns-two">
	<?php

	// we want to find the first $count non-private vids from the 20 we grabbed.
	$j = 0;
	for ( $i = 0; $i < 20; $i++ ) {
		if ( array_key_exists( $i, $composed_playlist->items ) && property_exists( $composed_playlist->items[ $i ]->contentDetails, 'videoPublishedAt' ) ) {
			// if videoPublishedAt exists then we know this is a public vid.
			$pub_date = new DateTime( $composed_playlist->items[ $i ]->contentDetails->videoPublishedAt );

			?>
	<div class="youtube-playlist__item has-animation-scale-2">
		<div class="wp-block-lf-youtube-lite">
			<lite-youtube
				videoid="<?php echo esc_attr( $composed_playlist->items[ $i ]->snippet->resourceId->videoId ); ?>"
				webpStatus="0" sdthumbStatus="1">
			</lite-youtube>
		</div>

		<div class="youtube-playlist__text-wrapper">
		<h3 class="youtube-playlist__title"><a class="youtube-playlist__link" href="https://www.youtube.com/watch?v=<?php echo esc_attr( $composed_playlist->items[ $i ]->snippet->resourceId->videoId ); ?>&list=<?php echo esc_attr( $playlist_id ); ?>"
				title="<?php echo esc_attr( $composed_playlist->items[ $i ]->snippet->title ); ?> "><?php echo esc_attr( $composed_playlist->items[ $i ]->snippet->title ); ?></a>
		</h3>

		<span class="youtube-playlist__date" ><?php echo esc_html( $pub_date->format( 'F j, Y' ) ); ?></span>
		</div>
	</div>
			<?php
			++$j;
			if ( $count === $j ) {
				// we got our $count public vids.
				break;
			}
		}
	}
	?>

</section>
	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'youtube_playlist', 'add_playlist_shortcode' );
