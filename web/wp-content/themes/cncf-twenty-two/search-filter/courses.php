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

wp_enqueue_style( 'wp-block-separator' );

if ( $query->have_posts() ) : ?>

	<?php
	// get total list of case studies.
	$count_course = wp_count_posts( 'lf_course' );
	$full_count   = $count_course->publish;
	?>

<p class="search-filter-results-count">
	<?php
	if ( $full_count == $query->found_posts ) {
		echo 'Found ' . esc_html( $query->found_posts ) . ' courses';
	} else {
		echo 'Showing ' . esc_html( $query->found_posts ) . ' of ' . esc_html( $full_count ) . ' courses';
	}
	?>
</p>
<div style="height:40px" aria-hidden="true"
	class="wp-block-spacer is-style-30-40"></div>

<hr
	class="wp-block-separator has-text-color has-background has-gray-500-background-color has-gray-500-color is-style-horizontal-rule">

<div style="height:50px" aria-hidden="true"
	class="wp-block-spacer is-style-30-50"></div>

<div class="courses">
	<?php
	while ( $query->have_posts() ) :
		$query->the_post();

		$free            = get_post_meta( get_the_ID(), 'lf_course_free', true );
		$cost            = get_post_meta( get_the_ID(), 'lf_course_cost', true );
		$cost_cn         = get_post_meta( get_the_ID(), 'lf_course_cost_cn', true );
		$course_url      = get_post_meta( get_the_ID(), 'lf_course_course_url', true );
		$course_url_cn   = get_post_meta( get_the_ID(), 'lf_course_course_url_cn', true );
		$length          = get_post_meta( get_the_ID(), 'lf_course_length', true );
		$who             = get_post_meta( get_the_ID(), 'lf_course_who', true );
		$difficulty      = Lf_Utils::get_term_names( get_the_ID(), 'lf-course-difficulty', true );
		$difficulty_slug = Lf_Utils::get_term_slugs( get_the_ID(), 'lf-course-difficulty' );

		?>
	<div class="course-item">
		<h2 class="course-item__title" class="wp-block-heading">
			<a href="<?php echo esc_url( $course_url ); ?>"><?php the_title(); ?></a>
		</h2>

		<?php
		if ( $free ) {
			?>
			<p class="is-style-boxed-uppercase">FREE</p>
			<?php
		}
		?>

		<div style="height:100px" aria-hidden="true" class="wp-block-spacer is-style-20-40"></div>

		<div class="wp-block-columns is-style-70px-gap is-layout-flex wp-container-core-columns-layout-6 wp-block-columns-is-layout-flex">
			<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:60%">
				<?php the_content(); ?>
				<div style="height:30px" aria-hidden="true" class="wp-block-spacer"></div>
			</div>

			<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:40%">

				<?php
				if ( $difficulty ) {
					?>
					<p><strong>Difficulty:</strong>&nbsp;<?php echo esc_html( $difficulty ); ?></p>
					<?php
				}

				if ( $length ) {
					?>
					<p><strong>Length:</strong>&nbsp;<?php echo esc_html( $length ); ?></p>
					<?php
				}

				if ( $who ) {
					?>
					<p><strong>Who It’s For:</strong>&nbsp;<?php echo esc_html( $who ); ?></p>
					<?php
				}
				?>

				<div style="height:18px" aria-hidden="true" class="wp-block-spacer"></div>

				<?php
				if ( $course_url ) {
					?>
				<div class="wp-block-columns is-layout-flex wp-container-core-columns-layout-4 wp-block-columns-is-layout-flex">
					<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:40%">

						<?php
						if ( ! $free ) {
							?>
							<p><strong>Cost: $<?php echo esc_html( $cost ); ?></strong></p>
							<?php
						} else {
							?>
							<p><strong>Cost: FREE</strong></p>
							<?php
						}
						?>
						<div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>
					</div>

					<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:60%">
						<div class="wp-block-buttons is-layout-flex wp-block-buttons-is-layout-flex">
						<div class="wp-block-button">
							<a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $course_url ); ?>">register</a>
						</div>
						</div>
						<div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>
					</div>
				</div>
				<div style="height:18px" aria-hidden="true" class="wp-block-spacer"></div>
					<?php
				}
				if ( $course_url_cn ) {
					?>
				<div class="wp-block-columns is-layout-flex wp-container-core-columns-layout-5 wp-block-columns-is-layout-flex">
					<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:40%">
						<?php
						if ( ! $free ) {
							?>
						<p><strong>培训费: ¥<?php echo esc_html( $cost_cn ); ?> (含税)</strong></p>
							<?php
						} else {
							?>
							<p><strong>培训费: 免费</strong></p>
							<?php
						}
						?>
					<div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>
					</div>

					<div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:60%">
						<div class="wp-block-buttons is-layout-flex wp-block-buttons-is-layout-flex">
						<div class="wp-block-button">
							<a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $course_url_cn ); ?>">报名</a>
						</div>
						</div>
						<div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>
					</div>
				</div>
					<?php
				}
				?>

			</div>
		</div>
		<div style="height:100px" aria-hidden="true" class="wp-block-spacer is-style-30-60"></div>
		<hr class="wp-block-separator has-css-opacity is-style-shadow-line"/>
		<div style="height:40px" aria-hidden="true" class="wp-block-spacer is-style-40-80"></div>
	</div>
		<?php
endwhile;
	?>
</div>
	<?php
else :
	echo 'No Results Found';
endif;
