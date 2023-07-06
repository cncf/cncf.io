<?php
/**
 * CNCF Event Map
 *
 * Displays events on a world map.
 * Usage example:
 * [events-map search="KubeCon"]
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

/**
 * Geocodes an event location.
 *
 * @param int $id Events ID.
 */
function lf_geocode_event( $id ) {
	$city             = get_post_meta( get_the_ID(), 'lf_event_city', true );
	$country          = Lf_Utils::get_term_names( get_the_ID(), 'lf-country', true );

	if ( ! $city && ! $country ) {
		return;
	} elseif ( ! $country ) {
		$location = $city;
	} elseif ( ! $city ) {
		$location = $country;
	} else {
		$location = $city . ', ' . $country;
	}

	$options             = get_option( 'lf-mu' );
	$google_maps_api_key = $options['google_maps_api_key'] ?? '';

	if ( ! $google_maps_api_key ) {
		return;
	}

	$service_url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode( $location ) . '&key=' . $google_maps_api_key;

	$curl = curl_init( $service_url );
	curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
	$curl_response = curl_exec( $curl );
	if ( false === $curl_response ) {
		$info = curl_getinfo( $curl );
		curl_close( $curl );
		return;
	}
	curl_close( $curl );
	$decoded = json_decode( $curl_response );

	if ( isset( $decoded->results ) && array_key_exists( 0, $decoded->results ) ) {
		update_post_meta( $id, 'lf_event_location_lat', $decoded->results[0]->geometry->location->lat );
		update_post_meta( $id, 'lf_event_location_lng', $decoded->results[0]->geometry->location->lng );
	}
}

/**
 * Event map shortcode
 *
 * @param array $atts Attributes.
 */
function add_cncf_events_map_shortcode( $atts ) {

	// Attributes.
	$atts = shortcode_atts(
		array(
			'search' => '', // set default.
		),
		$atts,
		'events-map'
	);
	$search_term                = $atts['search'];
	$options                    = get_option( 'lf-mu' );
	$google_maps_api_public_key = $options['google_maps_api_public_key'] ?? null;

	if ( ! $google_maps_api_public_key ) {
		return;
	}

	wp_enqueue_script(
		'events-map',
		get_template_directory_uri() . '/source/js/on-demand/events-map.js',
		array( 'jquery' ),
		filemtime( get_template_directory() . '/source/js/on-demand/events-map.js' ),
		true
	);

	ob_start();
	?>
<section>
<div id="map"></div>
</section>
<!-- prettier-ignore -->
<script>(g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})
({key: "<?php echo esc_html( $google_maps_api_public_key ); ?>", v: "beta"});</script>

	<?php
	$query_args = array(
		'posts_per_page' => 200,
		'post_type'      => array( 'lf_event' ),
		'post_status'    => array( 'publish' ),
		'meta_key'       => 'lf_event_date_start',
		'order'          => 'ASC',
		'meta_type'      => 'DATETIME',
		'orderby'        => 'meta_value',
		'no_found_rows'  => true,
		'meta_query'     => array(
			array(
				'key'     => 'lf_event_date_end',
				'value'   => date_i18n( 'Y-m-d' ),
				'compare' => '>=',
				'type'    => 'DATETIME',
			),
		),
	);

	if ( is_string( $search_term ) ) {
		$query_args['s'] = $search_term;
	}

	global $post;
	$events = array();
	$query  = new WP_Query( $query_args );
	while ( $query->have_posts() ) {
		$query->the_post();
		$lat          = get_post_meta( $post->ID, 'lf_event_location_lat' );
		$lng          = get_post_meta( $post->ID, 'lf_event_location_lng' );
		$external_url = get_post_meta( get_the_ID(), 'lf_event_external_url', true );
		$event_start_date = get_post_meta( get_the_ID(), 'lf_event_date_start', true );
		$event_end_date   = get_post_meta( get_the_ID(), 'lf_event_date_end', true );

		if ( ! $lat || ! $lng ) {
			lf_geocode_event( get_the_ID() );
			$lat = get_post_meta( $post->ID, 'lf_event_location_lat' );
			$lng = get_post_meta( $post->ID, 'lf_event_location_lng' );
		}

		if ( false !== stripos( get_the_title(), 'KCD' ) ) {
			$icon = '/wp-content/themes/cncf-twenty-two/images/map-markers/kcd-event.svg';
		} elseif ( false !== stripos( get_the_title(), 'KubeCon' ) ) {
			$icon = '/wp-content/themes/cncf-twenty-two/images/map-markers/cncf-event.svg';
		} else {
			$icon = '/wp-content/themes/cncf-twenty-two/images/map-markers/generic-event.svg';
		}

		if ( $lat && $lng ) {
			$events[] = array(
				'lat'  => $lat,
				'lng'  => $lng,
				'name' => get_the_title(),
				'url'  => esc_attr( $external_url ),
				'id'   => get_the_ID(),
				'icon' => $icon,
				'date' => esc_html( Lf_Utils::display_event_date( $event_start_date, $event_end_date ) ),
			);
		}
	}
	wp_reset_postdata();
	?>
<script>
	let events = '<?php echo wp_json_encode( $events ); ?>'
</script>

	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'events-map', 'add_cncf_events_map_shortcode' );
