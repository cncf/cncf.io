<?php
/**
 * Event Banner
 *
 * Usage:
 * [event_banner]
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

/**
 * Returns the banner info for inclusion in megamenu.
 * It grabs the next Kubecon event, if there is one, otherwise returns the next event.
 */
function show_event_in_menu() {
	// find the next kubecon event with logo and background color.
	$args = array(
		'post_type'      => 'lf_event',
		'posts_per_page' => 1,
		's'              => 'kubecon',
		'orderby'        => 'meta_value',
		'meta_key'       => 'lf_event_date_end',
		'order'          => 'ASC',
		'meta_query'     => array(
			array(
				'key'     => 'lf_event_date_end',
				'value'   => gmdate( 'Y-m-d' ),
				'compare' => '>=',
			),
			array(
				'key'     => 'lf_event_logo',
				'compare' => 'EXISTS',
			),
			array(
				'key'     => 'lf_event_background',
				'compare' => 'EXISTS',
			),
		),
	);

	$the_query = new WP_Query( $args );

	if ( $the_query->have_posts() ) {
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			get_template_part( 'components/event-mega-menu' );
		}
	} else {

		// there being no kubecon, just grab the next event.
		unset( $args['s'] );
		$the_query = new WP_Query( $args );

		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				get_template_part( 'components/event-mega-menu' );
			}
		}
	}
	/* Restore original Post Data */
	wp_reset_postdata();
}

/**
 * Returns banner info for inclusion in homepage.
 * Grabs max of 10 upcoming events with a desktop image.
 *
 * @param bool $hide_title Hide Title.
 * @return void
 */
function show_event_banner( $hide_title ) {
	$the_query = new WP_Query(
		array(
			'post_type'      => 'lf_event',
			'posts_per_page' => 10,
			'orderby'        => 'meta_value',
			'meta_key'       => 'lf_event_date_end',
			'order'          => 'ASC',
			'meta_query'     => array(
				'relation' => 'AND',
				array(
					'key'     => 'lf_event_date_end',
					'value'   => gmdate( 'Y-m-d' ),
					'compare' => '>=',
				),
				array(
					'key'     => 'lf_event_desktop_banner',
					'value'   => '0',
					'compare' => '!=',
				),
				array(
					'key'     => 'lf_event_mobile_banner',
					'value'   => '0',
					'compare' => '!=',
				),
			),
		)
	);

	if ( $the_query->have_posts() ) {
		if ( 1 === $the_query->post_count ) {
			$the_query->the_post();
			get_template_part( 'components/event-single-banner', null, array( 'hide_title' => $hide_title ) );
		} else {
			get_template_part(
				'components/event-multiple-banner',
				null,
				array(
					'the_query'  => $the_query,
					'hide_title' => $hide_title,
				)
			);
		}
	}
}

/**
 * Event Banner shortcode.
 *
 * @param array $atts Atts.
 * @return string $block_content Block Content.
 */
function add_event_banner_shortcode( $atts ) {

	// Attributes.
	$atts = shortcode_atts(
		array(
			'hide_title' => false, // set default.
		),
		$atts,
		'event_banner'
	);

	$hide_title = filter_var( $atts['hide_title'], FILTER_VALIDATE_BOOLEAN );

	ob_start();
	show_event_banner( $hide_title );
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'event_banner', 'add_event_banner_shortcode' );
