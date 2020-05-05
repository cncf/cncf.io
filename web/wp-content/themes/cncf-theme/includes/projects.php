<?php
/**
 * People Shortcode
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

 /**
  * Add Projects shortcode.
  *
  * @param array $atts Attributes.
  */
function add_projects_shortcode( $atts ) {

	// Attributes.
	$atts = shortcode_atts(
		array(
			'stage' => 'graduated', // set default.
		),
		$atts,
		'projects'
	);

	$chosen_taxonomy = $atts['stage'];

	if ( ! is_string( $chosen_taxonomy ) ) {
		return;
	}

	$query_args = array(
		'post_type'      => 'cncf_project',
		'post_status'    => array( 'publish' ),
		'posts_per_page' => -1,
		'tax_query'      => array(
			array(
				'taxonomy' => 'cncf-project-stage',
				'field'    => 'slug',
				'terms'    => $chosen_taxonomy,
			),
		),
		'orderby'        => 'title',
		'order'          => 'ASC',
	);

	$project_query = new WP_Query( $query_args );
	if ( $project_query->have_posts() ) {
		ob_start();
		?>
<div class="projects-wrapper">
		<?php
		while ( $project_query->have_posts() ) :
			$project_query->the_post();
			?>
<div class="project-box">
			<?php the_title(); ?>
</div>
			<?php
		endwhile;
		wp_reset_postdata();
	}
	?>
</div>
	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'projects', 'add_projects_shortcode' );
