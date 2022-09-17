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
function get_event_ad_for_menu() {
	// find the next kubecon event.
	$the_query = new WP_Query(
		array(
			'post_type' => 'lf_event',
			'posts_per_page' => 1,
			's' => 'kubecon',
			'orderby' => 'meta_value',
			'meta_key'  => 'lf_event_date_end',
			'order' => 'ASC',
			'meta_query' => array(
				array(
					'key'     => 'lf_event_date_end',
					'value'   => gmdate( 'Y-m-d' ),
					'compare' => '>=',
				),
			),
		),
	);

	if ( $the_query->have_posts() ) {
		echo '<ul>';
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$end_date = get_post_meta( get_the_ID(), 'lf_event_date_end', true );
			echo '<li>' . get_the_title() . ' ' . $end_date . '</li>';
		}
		echo '</ul>';
	} else {
		// just grab the next event.
		$the_query = new WP_Query(
			array(
				'post_type' => 'lf_event',
				'posts_per_page' => 1,
				'orderby' => 'meta_value',
				'meta_key'  => 'lf_event_date_end',
				'order' => 'ASC',
				'meta_query' => array(
					array(
						'key'     => 'lf_event_date_end',
						'value'   => gmdate( 'Y-m-d' ),
						'compare' => '>=',
					),
				),
			),
		);
		if ( $the_query->have_posts() ) {
			echo '<ul>';
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				$end_date = get_post_meta( get_the_ID(), 'lf_event_date_end', true );
				echo '<li>' . get_the_title() . ' ' . $end_date . '</li>';
				}
			echo '</ul>';
		}
	}

	/* Restore original Post Data */
	wp_reset_postdata();
}

/**
 * Returns banner info for inclusion in homepage
 */
function get_event_banner_info() {

}

/**
 * Event Banner shortcode.
 */
function add_event_banner_shortcode() {

	ob_start();
	get_event_ad_for_menu();
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'event_banner', 'add_event_banner_shortcode' );
