<?php
/**
 * Events Shortcode
 *
 * Usage example:
 * [events search="KubeCon + CloudNativeCon" limit=9]
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

/**
 * Add Events shortcode.
 *
 * @param array $atts Attributes.
 */
function add_events_shortcode( $atts ) {

	// Attributes.
	$atts = shortcode_atts(
		array(
			'search' => '', // set default.
			'limit'  => '9', // set default.
		),
		$atts,
		'events'
	);

	$search_term = $atts['search'];
	$limit       = $atts['limit'];

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
	if ( is_numeric( $limit ) ) {
		$query_args['posts_per_page'] = $limit;
	}

	$event_query = new WP_Query( $query_args );

	// if no posts.
	if ( ! $event_query->have_posts() ) {
		return '<h3>Sorry, there are no events to show right now.</h3>';
	}

	ob_start();
	if ( $event_query->have_posts() ) {
		?>

	<div class="events-section columns-three">
		<?php
		while ( $event_query->have_posts() ) :
			$event_query->the_post();
			get_template_part( 'components/event-item' );
		endwhile;
		wp_reset_postdata();
	}
	?>
</div>
	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'events', 'add_events_shortcode' );
