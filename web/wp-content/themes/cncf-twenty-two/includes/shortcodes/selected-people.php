<?php
/**
 * Selected People Shortcode
 *
 * Usage:
 * [selected_people people_ids="66351,51177,51298,64375" profiles=false]
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

/**
 * Show Selected People shortcode.
 *
 * @param array $atts Attributes.
 */
function add_selected_people_shortcode( $atts ) {

	// Attributes.
	$atts = shortcode_atts(
		array(
			'people_ids' => '66351', // set default.
			'profiles'   => true, // set default.
		),
		$atts,
		'selected_people'
	);

	if ( ! $atts['people_ids'] ) {
		return;
	}

	$ids          = explode( ',', $atts['people_ids'] );
	$show_profile = filter_var( $atts['profiles'], FILTER_VALIDATE_BOOLEAN );

	ob_start();
	?>

	<div class="people-wrapper">

	<?php

	foreach ( $ids as $id ) {
		$args  = array(
			'p'         => $id,
			'post_type' => 'lf_person',
		);
		$query = new WP_Query( $args );

		if ( $query->have_posts() ) {

			$query->the_post();
			get_template_part( 'components/people-item', null, array( 'show_profile' => $show_profile ) );
		}
		wp_reset_postdata();
	}
	?>
	</div>
	<?php
	$block_content = ob_get_clean();
	return $block_content;

}
add_shortcode( 'selected_people', 'add_selected_people_shortcode' );
