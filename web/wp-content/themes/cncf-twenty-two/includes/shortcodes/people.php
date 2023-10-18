<?php
/**
 * People Shortcode
 *
 * Usage
 * [people tax="staff"]
 * [people tax="technical-oversight-committee" profiles=true]
 * [people tax="toc-contributors" profiles=false]
 *
 * @package WordPress
 * @subpackage cncf-theme
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
			'tax'      => 'staff', // set default.
			'profiles' => true, // set default.
		),
		$atts,
		'people'
	);

	$chosen_taxonomy = $atts['tax'];
	$show_profile    = filter_var( $atts['profiles'], FILTER_VALIDATE_BOOLEAN );

	if ( ! is_string( $chosen_taxonomy ) ) {
		return;
	}

	$query_args = array(
		'post_type'      => 'lf_person',
		'post_status'    => array( 'publish' ),
		'posts_per_page' => 200,
		'no_found_rows'  => true,
		'tax_query'      => array(
			array(
				'taxonomy' => 'lf-person-category',
				'field'    => 'slug',
				'terms'    => $chosen_taxonomy,
			),
		),
		'meta_key'       => 'lf_person_is_priority',
		'orderby'        => array(
			'meta_value_num' => 'DESC',
			'title'          => 'ASC',
		),
	);

	$persons_query = new WP_Query( $query_args );

	if ( $persons_query->have_posts() ) {

		wp_enqueue_script(
			'modal',
			get_template_directory_uri() . '/source/js/on-demand/modal.js',
			array( 'jquery' ),
			filemtime( get_template_directory() . '/source/js/on-demand/modal.js' ),
			true
		);

		ob_start();
		?>
<div class="people-wrapper">
		<?php
		while ( $persons_query->have_posts() ) :
			$persons_query->the_post();

			get_template_part( 'components/people-item', null, array( 'show_profile' => $show_profile ) );

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
