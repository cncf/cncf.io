<?php
/**
 * People Shortcode
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

 /**
  * Add People shortcode.
  *
  * @param array $atts Attributes.
  */
function add_people_shortcode( $atts ) {

	// Attributes.
	$atts = shortcode_atts(
		array(
			'tax' => 'staff', // set default.
		),
		$atts,
		'people'
	);

	$chosen_taxonomy = $atts['tax'];

	if ( ! is_string( $chosen_taxonomy ) ) {
		return;
	}
	$meta_key = 'lf_person_is_priority';

	$query_args = array(
		'post_type'      => 'lf_person',
		'post_status'    => array( 'publish' ),
		'posts_per_page' => -1,
		'tax_query'      => array(
			array(
				'taxonomy' => 'lf-person-category',
				'field'    => 'slug',
				'terms'    => $chosen_taxonomy,
			),
		),

		'meta_query'     => array(
			'relation' => 'OR',
			array(
				'key'     => $meta_key,
				'compare' => 'NOT EXISTS',
			),
			array(
				'relation' => 'OR',
				array(
					'key'   => $meta_key,
					'value' => 'on',
				),
				array(
					'key'     => $meta_key,
					'value'   => 'on',
					'compare' => '!=',
				),
			),
		),
		'orderby'        => array(
			'meta_value_num' => 'DESC',
			'title'          => 'ASC',
		),
	);

	$persons_query = new WP_Query( $query_args );
	if ( $persons_query->have_posts() ) {
		ob_start();
		?>
<div class="people-wrapper">
		<?php
		while ( $persons_query->have_posts() ) :
			$persons_query->the_post();

			get_template_part( 'components/people-block' );
		endwhile;
		wp_reset_postdata();
	}
	?>
</div>
	<?php
	$block_content = ob_get_clean();
	return $block_content;

}
add_shortcode( 'people', 'add_people_shortcode' );
