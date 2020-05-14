<?php
/**
 * Search & Filter Pro
 *
 * Case Studies
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

if ( $query->have_posts() ) :
	// get total list of case studies.
	$count_case_study = wp_count_posts( 'cncf_case_study' );
	$full_count       = $count_case_study->publish;
	?>

<p class="results-count">
	<?php
	// if CPT set chinese conditional true.
	if ( 'cncf_case_study_ch' === $query->query['post_type'] ) {
		$ch = true;
		echo '发现' . esc_html( $query->found_posts ) . '个案例研究';
	} else {
		$ch = false;
		if ( $full_count == $query->found_posts ) {
			echo 'Found ' . esc_html( $query->found_posts ) . ' case studies';
		} else {
			echo 'Showing ' . esc_html( $query->found_posts ) . ' of ' . esc_html( $full_count ) . ' case studies';
		}
	}
	?>
</p>
<div class="case-studies-wrapper">
	<?php
	while ( $query->have_posts() ) :
		$query->the_post();

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
	<div class="case-study-box background-image-wrapper box-shadow">

		<div class="case-study-overlay"></div>

		<?php if ( get_post_thumbnail_id() ) : ?>
		<figure class="background-image-figure">
			<?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'medium', false ); ?>
		</figure>
		<?php endif; ?>

		<div class="case-study-content-wrapper background-image-text-overlay">

			<h3 class="case-study-title"><a title="<?php the_title(); ?>"
					href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h3>

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
			<div class="margin-y">
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

			<?php if ( $read_case_study ) { ?>
			<a class="button stocky outline transparent"
				href="<?php the_permalink(); ?>"><?php echo esc_html( $read_case_study ); ?></a>
			<?php } ?>

		</div>

	</div>
	<?php endwhile; ?>
	<?php
else :
	echo 'No Results Found';
endif;
