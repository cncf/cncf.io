<?php
/**
 * Projects Shortcode
 *
 * Usage:
 * [projects stage="graduated|incubating|sandbox"]
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
		'post_type'      => 'lf_project',
		'post_status'    => array( 'publish' ),
		'posts_per_page' => 200,
		'tax_query'      => array(
			array(
				'taxonomy' => 'lf-project-stage',
				'field'    => 'slug',
				'terms'    => $chosen_taxonomy,
			),
		),
		'orderby'        => 'title',
		'order'          => 'ASC',
	);

	$project_query = new WP_Query( $query_args );
	ob_start();
	if ( $project_query->have_posts() ) {
		?>

<div class="projects-archive columns-five">
		<?php
		while ( $project_query->have_posts() ) :
			$project_query->the_post();
			$date_accepted    = get_post_meta( get_the_ID(), 'lf_project_date_accepted', true ) ? ' (accepted to CNCF on ' . gmdate( 'n/j/Y', strtotime( get_post_meta( get_the_ID(), 'lf_project_date_accepted', true ) ) ) . ')' : '';
			$project_category = get_post_meta( get_the_ID(), 'lf_project_category', true );
			$logo             = get_post_meta( get_the_ID(), 'lf_project_logo', true );

			?>
	<div class="project-item has-animation-scale-2">
		<a href="<?php the_permalink(); ?>"
			title="<?php echo esc_html( the_title_attribute() . $date_accepted ); ?>"
			class="project-item__link">

			<img src="<?php echo esc_url( $logo ); ?>" loading="lazy"
				title="<?php echo esc_html( the_title_attribute() . $date_accepted ); ?>"
				class="project-item__image">
		</a>
			<?php if ( $project_category ) : ?>
		<span class="project-item__category">
					<?php echo esc_html( $project_category ); ?></span>
		<?php endif; ?>
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
