<?php
/**
 * WIP - Home Hero
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

		$query_args = array(
			'post_type'      => 'lf_project',
			'post_status'    => array( 'publish' ),
			'posts_per_page' => 200,
			'orderby'        => 'title',
			'order'          => 'ASC',
		);

		$project_query = new WP_Query( $query_args );

		$graduated_count   = 0;
		$incubating_count  = 0;
		$sandbox_count     = 0;
		$all_project_logos = array();

		if ( $project_query->have_posts() ) {
			while ( $project_query->have_posts() ) {
				$project_query->the_post();
				$stacked_logo_id  = get_post_meta( get_the_ID(), 'lf_project_stacked_logo', true );
				$stacked_logo_url = wp_get_attachment_image_url( $stacked_logo_id );
				if ( has_term( 'graduated', 'lf-project-stage', get_the_ID() ) ) {
					$graduated_count++;
				} elseif ( has_term( 'incubating', 'lf-project-stage', get_the_ID() ) ) {
					$incubating_count++;
				} elseif ( has_term( 'sandbox', 'lf-project-stage', get_the_ID() ) ) {
					$sandbox_count++;
				}
				if ( $stacked_logo_url ) {
					$all_project_logos[] = $stacked_logo_url;
				}
			}
		}
		wp_reset_postdata();
		?>

<section class="hosted-projects">
	<div class="">

		<h2>CNCF hosted projects</h2>

		<?php if ( $graduated_count && $incubating_count && $sandbox_count ) : ?>
		<ul class="data-display no-style h4">
			<li><a href="/projects/">
					<span><?php echo esc_html( $graduated_count ); ?></span>
					Graduated Projects
				</a></li>
			<li><a href="/projects/#incubating">
					<span><?php echo esc_html( $incubating_count ); ?></span>
					Incubating Projects
				</a></li>
			<li><a href="/sandbox-projects/">
					<span><?php echo esc_html( $sandbox_count ); ?></span>
					Sandbox Projects
				</a></li>
		</ul>
		<?php endif; ?>

		<p
			class="h5">The CNCF hosts critical components of the global technology infrastructure. CNCF brings together the world's top developers, end users, and vendors and runs the largest open source developer conferences. CNCF is part of the non-profit <a href="https://linuxfoundation.org" class="external is-primary-color" target="_blank">Linux Foundation</a>.</p>

		<p
			class="h4"><a href="/projects/" class="arrow-cta">Explore CNCF Projects</a></p>

		<div style="height:20px" aria-hidden="true" class="wp-block-spacer">
		</div>

	</div>

	<div>


		<?php

		if ( $all_project_logos ) :

			/**
			 * Partition an array
			 *
			 * @param array    $array Items.
			 * @param integrer $size Number of partitions required.
			 */
			function partition( $array, $size ) {
				$list_length = count( $array );
				$size_len    = floor( $list_length / $size );
				$size_rem    = $list_length % $size;
				$partition   = array();
				$mark        = 0;
				for ( $px = 0; $px < $size; $px++ ) {
					$incr             = ( $px < $size_rem ) ? $partlen + 1 : $size_len;
					$partition[ $px ] = array_slice( $array, $mark, $incr );
					$mark            += $incr;
				}
				return $partition;
			}

			$all_project_logos = partition( $all_project_logos, 3 );

			?>
		<div class="project-slider-wrapper">
			<?php
			$i = 0;
			foreach ( $all_project_logos as $project_logos ) {
				$i++;
				$direction = ( $i % 2 == 0 ) ? 'rtl' : 'ltr'; // phpcs:ignore

				?>
			<div class="slider project-slider-<?php echo esc_html( $i ); ?>"
				dir="<?php echo esc_html( $direction ); ?>">
				<?php foreach ( $project_logos as $project_logo ) { ?>
				<div class="project-slide" dir="ltr">
					<img src="<?php echo esc_url( $project_logo ); ?>"
						loading="lazy">
				</div>

					<?php
				}
				?>

			</div>
				<?php
			}
			?>
		</div>
		<?php endif; ?>

	</div>
</section>

<div style="height:40px" aria-hidden="true"
	class="wp-block-spacer is-style-40-responsive"></div>
