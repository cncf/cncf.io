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
		<?php echo wp_get_attachment_image( get_post_thumbnail_id(), false, false, array( 'sizes' => '(min-width: 1200px) 315px, (min-width: 940px) calc(12.92vw + 165px), (min-width: 640px) calc(50vw - 33px), (min-width: 500px) calc(100vw - 50px), 97.78vw' ) ); ?>
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

				if ( $case_study_type ) {
					?>
			<span
				class="skew-box tertiary centered"><?php echo esc_html( $case_study_type ); ?></span>
					<?php
				}
				if ( $case_study_type_additional ) {
					?>
				<span
					class="skew-box tertiary centered"><?php echo esc_html( $case_study_type_additional ); ?></span>
					<?php
				}
			} else {
				// if an array and no errors.
				if ( ! empty( $projects ) && ! is_wp_error( $projects ) ) {
					// limits to max 2 projects.
					$projects = array_slice( $projects, 0, 2 );

					// output for each.
					foreach ( $projects as $project ) {
						?>
			<span
				class="skew-box tertiary centered"><?php echo esc_html( $project->name ); ?></span>
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
