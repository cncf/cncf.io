<?php
/**
 * Case Study Item
 *
 * Singular case study item.
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

// if cn CPT set chinese conditional true.
if ( isset( $query ) && ( 'lf_case_study_cn' === $query->query['post_type'] ) ) {
	$cn = true;
} else {
	$cn = false;
}

// setup projects for both lang.
$projects = get_the_terms( get_the_ID(), 'lf-project' );

if ( $cn ) {

	// get project overrides.
	$case_study_type            = get_post_meta( get_the_ID(), 'lf_case_study_cn_type', true );
	$case_study_type_additional = get_post_meta( get_the_ID(), 'lf_case_study_cn_type_additional', true );

	$read_case_study = '阅读 案例研究';

} else {

	// get project overrides.
	$case_study_type            = get_post_meta( get_the_ID(), 'lf_case_study_type', true );
	$case_study_type_additional = get_post_meta( get_the_ID(), 'lf_case_study_type_additional', true );

	$read_case_study = 'Read Case Study';

}
?>

<div class="case-study-box background-image-wrapper">

	<div class="case-study-overlay"></div>

	<?php if ( get_post_thumbnail_id() ) : ?>
	<figure class="background-image-figure">
		<?php
		LF_Utils::display_responsive_images( get_post_thumbnail_id(), 'case-study-640', '600px' );
		?>
	</figure>
	<?php endif; ?>

	<div class="case-study-content-wrapper background-image-text-overlay">

<h3 class="case-study-title margin-bottom"><a title="<?php the_title(); ?>"
				href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h3>

<?php if ( ! is_front_page() ) : ?>
		<p class="case-study-date margin-bottom"><?php echo get_the_date(); ?></p>
<?php endif; ?>

		<div class="case-study-project-type margin-bottom-small">
			<?php
			if ( $case_study_type || $case_study_type_additional ) {
				if ( $cn ) {
					$projects_link = '/case-studies-cn?_sft_lf-project=' . strtolower( $case_study_type );
					$projects_link_additional = '/case-studies-cn?_sft_lf-project=' . strtolower( $case_study_type_additional );
				} else {
					$projects_link = '/case-studies?_sft_lf-project=' . strtolower( $case_study_type );
					$projects_link_additional = '/case-studies?_sft_lf-project=' . strtolower( $case_study_type_additional );
				}

				if ( $case_study_type ) {
					?>
			<a class="skew-box tertiary centered" title="See all <?php echo esc_attr( $case_study_type ); ?> case studies" href="<?php echo esc_url( $projects_link ); ?>"><?php echo esc_html( $case_study_type ); ?></a>
					<?php
				}
				if ( $case_study_type_additional ) {
					?>
				<a class="skew-box tertiary centered" title="See all <?php echo esc_attr( $case_study_type_additional ); ?> case studies" href="<?php echo esc_url( $projects_link ); ?>"><?php echo esc_html( $case_study_type_additional ); ?></a>
					<?php
				}
			} else {
				// if an array and no errors.
				if ( ! empty( $projects ) && ! is_wp_error( $projects ) ) {
					// limits to max 2 projects.
					$projects = array_slice( $projects, 0, 2 );

					// output for each.
					foreach ( $projects as $project ) {
						if ( $cn ) {
							$projects_link = '/case-studies-cn?_sft_lf-project=' . $project->slug;
						} else {
							$projects_link = '/case-studies?_sft_lf-project=' . $project->slug;
						}

						?>
			<a class="skew-box tertiary centered" title="See all <?php echo esc_attr( $project->name ); ?> case studies" href="<?php echo esc_url( $projects_link ); ?>"><?php echo esc_html( $project->name ); ?></a>
						<?php
					}
				}
			}
			?>
		</div>

		<?php if ( $read_case_study ) : ?>
		<a class="button on-image"
			href="<?php the_permalink(); ?>"><?php echo esc_html( $read_case_study ); ?></a>
		<?php endif; ?>

	</div>
</div>
