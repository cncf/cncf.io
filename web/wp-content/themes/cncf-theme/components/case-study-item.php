<?php
/**
 * Case Study Item
 *
 * Singular case studyr item.
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

global $query;

// if CPT set chinese conditional true.
if ( ! is_front_page() || ! $query ) {
	$ch = false;
} elseif ( 'cncf_case_study_ch' === $query->query['post_type'] ) {
	$ch = true;
} else {
	$ch = false;
}

// setup projects for both lang.
$projects = get_the_terms( get_the_ID(), 'cncf-project' );

if ( $ch ) {
	// get industry type override.
	$case_study_type = get_post_meta( get_the_ID(), 'cncf_case_study_ch_type', true );

	$industry = get_the_terms( get_the_ID(), 'cncf-industry-ch' );

	$read_case_study = '阅读';
	if ( $case_study_type ) {
		$read_case_study .= $case_study_type;
	}
	$read_case_study .= '案例研究';

} else {

	// get industry type override.
	$case_study_type = get_post_meta( get_the_ID(), 'cncf_case_study_type', true );

	$industry = get_the_terms( get_the_ID(), 'cncf-industry' );

	$read_case_study = 'Read Case Study';

}
?>

<div class="case-study-box background-image-wrapper">

	<div class="case-study-overlay"></div>

	<?php if ( get_post_thumbnail_id() ) : ?>
	<figure class="background-image-figure">
		<?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'medium', false ); ?>
	</figure>
	<?php endif; ?>

	<div class="case-study-content-wrapper background-image-text-overlay">

		<h5 class="case-study-title"><a title="<?php the_title(); ?>"
				href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h5>

		<div>
			<?php
			if ( $case_study_type ) {
				?>
			<span
				class="unskew-box secondary centered"><?php echo esc_html( $case_study_type ); ?></span>
				<?php
			} else {
				// if an array and no errors.
				if ( ! empty( $projects ) && ! is_wp_error( $projects ) ) {
					// limits to max 2 projects.
					$projects = array_slice( $projects, 0, 2 );

					// output for each.
					foreach ( $projects as $project ) {
						?>
			<span
				class="unskew-box secondary centered"><?php echo esc_html( $project->name ); ?></span>
						<?php
					}
				}
			}
			?>
		</div>

		<?php
		if ( ! empty( $industry ) && ! is_wp_error( $industry ) ) :
			?>
		<div class="margin-top-small">
			<?php
			// limits to max 2 industry.
			$industry = array_slice( $industry, 0, 2 );

			// output for each.
			foreach ( $industry as $each ) {
				?>
			<span
				class="unskew-box centered "><?php echo esc_html( $each->name ); ?></span>
				<?php
			}
			?>
		</div>
		<?php endif; ?>

		<div class="margin-y-small">
			<span
				class="unskew-box secondary centered"><?php echo get_the_date(); ?></span>
		</div>
		<?php if ( $read_case_study ) { ?>
		<a class="button on-image"
			href="<?php the_permalink(); ?>"><?php echo esc_html( $read_case_study ); ?></a>
		<?php } ?>

	</div>

</div>
