<?php
/**
 * Case Study Item
 *
 * Singular case studyr item.
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

global $query;

// if CPT set chinese conditional true.
if ( ! is_front_page() || ! $query ) {
	$cn = false;
} elseif ( 'lf_case_study_cn' === $query->query['post_type'] ) {
	$cn = true;
} else {
	$cn = false;
}

// setup projects for both lang.
$projects = get_the_terms( get_the_ID(), 'lf-project' );

if ( $cn ) {
	// get industry type override.
	$case_study_type = get_post_meta( get_the_ID(), 'lf_case_study_cn_type', true );

	$industry = get_the_terms( get_the_ID(), 'lf-industry-cn' );

	$read_case_study = '阅读';
	if ( $case_study_type ) {
		$read_case_study .= $case_study_type;
	}
	$read_case_study .= '案例研究';

} else {

	// get industry type override.
	$case_study_type = get_post_meta( get_the_ID(), 'lf_case_study_type', true );

	$industry = get_the_terms( get_the_ID(), 'lf-industry' );

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

<div class="case-study-title-wrapper">
		<h3 class="case-study-title"><a title="<?php the_title(); ?>"
				href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h3>
</div>
<div>
<?php if ( ! is_front_page() ) : ?>
		<p class="margin-bottom-small"><?php echo get_the_date(); ?></p>
<?php endif; ?>

		<div>
			<?php
			if ( $case_study_type ) {
				?>
			<span
				class="skew-box tertiary centered margin-top"><?php echo esc_html( $case_study_type ); ?></span>
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
				class="skew-box tertiary centered margin-top"><?php echo esc_html( $project->name ); ?></span>
						<?php
					}
				}
			}
			?>
		</div>

		<?php
		if ( ! empty( $industry ) && ! is_wp_error( $industry ) ) :
			?>
		<div class="margin-top">
			<?php
			// limits to max 2 industry.
			$industry = array_slice( $industry, 0, 2 );

			// output for each.
			foreach ( $industry as $each ) {
				?>
			<span
				class="skew-box centered secondary"><?php echo esc_html( $each->name ); ?></span>
				<?php
			}
			?>
		</div>
		<?php endif; ?>

		<?php if ( $read_case_study ) { ?>
		<a class="button on-image"
			href="<?php the_permalink(); ?>"><?php echo esc_html( $read_case_study ); ?></a>
		<?php } ?>
		</div>
	</div>

</div>
