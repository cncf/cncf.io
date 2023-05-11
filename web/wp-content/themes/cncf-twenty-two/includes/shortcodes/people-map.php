<?php
/**
 * CNCF People Map
 *
 * Displays people on a world map.
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

/**
 * People map shortcode
 */
function add_cncf_people_map_shortcode() {

	wp_enqueue_script(
		'people-map',
		get_template_directory_uri() . '/source/js/on-demand/people-map.js',
		array( 'jquery' ),
		filemtime( get_template_directory() . '/source/js/on-demand/people-map.js' ),
		true
	);
	wp_enqueue_script(
		'markerclusterer',
		get_template_directory_uri() . '/source/js/libraries/markerclusterer.min.js',
		array(),
		filemtime( get_template_directory() . '/source/js/libraries/markerclusterer.min.js' ),
		true
	);

	$options = get_option( 'lf-mu' );
	$google_maps_api_public_key = $options['google_maps_api_public_key'] ?? '';

	if ( ! $google_maps_api_public_key ) {
		return;
	}

	ob_start();
	?>
<section>
<div id="map"></div>
</section>
<!-- prettier-ignore -->
<script>(g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})
({key: "<?php echo esc_html( $google_maps_api_public_key ); ?>", v: "beta"});</script>

	<?php
	$args = array(
		'posts_per_page'     => -1,
		'post_type'          => array( 'lf_person' ),
		'post_status'        => array( 'publish' ),
		'no_found_rows'      => true,
		'lf-person-category' => 'ambassadors',
	);

	global $post;
	$people = array();
	$query = new WP_Query( $args );
	while ( $query->have_posts() ) {
		$query->the_post();
		$lat = get_post_meta( $post->ID, 'lf_person_location_lat' );
		$lng = get_post_meta( $post->ID, 'lf_person_location_lng' );

		if ( $lat && $lng ) {
			$people[] = array(
				'lat' => $lat,
				'lng' => $lng,
				'name' => get_the_title(),
				'slug' => $post->post_name,
				'id'  => get_the_ID(),
			);
		}
	}
	wp_reset_postdata();
	?>
<script>
	let people = '<?php echo json_encode( $people ); ?>'
</script>

	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'people-map', 'add_cncf_people_map_shortcode' );
