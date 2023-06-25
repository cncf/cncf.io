<?php
/**
 * Reports Shortcode
 *
 * Usage example:
 * [reports type="conference-transparency" search="KubeCon + CloudNativeCon" limit=3]
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

/**
 * Add Reports shortcode.
 *
 * @param array $atts Attributes.
 */
function add_reports_shortcode( $atts ) {

	// Attributes.
	$atts = shortcode_atts(
		array(
			'type'   => 'conference-transparency', // set default.
			'search' => '', // set default.
			'limit'  => '3', // set default.
		),
		$atts,
		'reports'
	);

	$chosen_type = $atts['type'];
	$search_term = $atts['search'];
	$limit       = $atts['limit'];

	$query_args = array(
		'post_type'      => 'lf_report',
		'post_status'    => array( 'publish' ),
		'posts_per_page' => 200,
		'tax_query'      => array(
			array(
				'taxonomy' => 'lf-report-type',
				'field'    => 'slug',
				'terms'    => $chosen_type,
			),
		),
		'orderby'        => 'date',
		'order'          => 'DESC',
	);

	if ( is_string( $search_term ) ) {
		$query_args['s'] = $search_term;
	}
	if ( is_numeric( $limit ) ) {
		$query_args['posts_per_page'] = $limit;
	}

	$report_query = new WP_Query( $query_args );
	ob_start();
	if ( $report_query->have_posts() ) {
		?>

	<div class="reports-section columns-three">
		<?php
		while ( $report_query->have_posts() ) :
			$report_query->the_post();
			$report_type      = ucwords( Lf_Utils::get_term_names( get_the_ID(), 'lf-report-type', true ) );
			$report_type_slug = Lf_Utils::get_term_slugs( get_the_ID(), 'lf-report-type', true );
			$report_year      = get_post_meta( get_the_ID(), 'lf_report_published_year', true );

			?>
			<div class="report-item has-animation-scale-2">
				<a class="report-item__link" href="<?php the_permalink(); ?>"
					title="<?php echo esc_attr( the_title_attribute() ); ?>">
					<?php
					if ( has_post_thumbnail() ) {
						Lf_Utils::display_responsive_images( get_post_thumbnail_id(), 'newsroom-388', '400px', 'report-item__image', 'lazy', get_the_title() );
					} else {
						$site_options = get_option( 'lf-mu' );
						Lf_Utils::display_responsive_images( $site_options['generic_thumb_id'], 'newsroom-388', '400px', 'report-item__image', 'lazy', get_the_title() );
					}
					?>
				</a>

				<div class="report-item__text-wrapper">
					<?php
					if ( $report_type ) :
						$report_type_link = '/reports/?_sft_lf-report-type=' . $report_type_slug . '';
						?>
					<a class="author-category"
						title="See more <?php echo esc_attr( $report_type ); ?> reports"
						href="<?php echo esc_url( $report_type_link ); ?>">
						<?php echo esc_html( $report_type ); ?> Report</a>
					<?php endif; ?>

					<h3 class="report-item__title"><a
							href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				</div>
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
add_shortcode( 'reports', 'add_reports_shortcode' );
