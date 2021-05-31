<?php
/**
 * Template Name: End User Community
 * Template Post Type: page
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

get_template_part( 'components/header' );

get_template_part( 'components/hero' );
?>

<?php
wp_enqueue_script( 'font-awesome', 'https://kit.fontawesome.com/5db798d128.js', array(), filemtime( get_template_directory() . '/build/global.js' ), 'all' );
?>
<main class="page-content end-user-page">
	<article class="container wrap entry-content">
		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				the_content();
				?>



		<!-- wp:spacer {"height":80,"className":"is-style-80-responsive"} -->
		<div style="height:80px" aria-hidden="true"
			class="wp-block-spacer is-style-80-responsive"></div>
		<!-- /wp:spacer -->

		<!-- wp:group {"align":"full","backgroundColor":"blue-100"} -->
		<div
			class="wp-block-group alignfull has-blue-100-background-color has-background">
			<div class="wp-block-group__inner-container">
				<!-- wp:spacer {"height":80,"className":"is-style-80-responsive"} -->
				<div style="height:80px" aria-hidden="true"
					class="wp-block-spacer is-style-80-responsive"></div>
				<!-- /wp:spacer -->


				<?php
				// setup the arguments.
				$args = array(
					'posts_per_page'      => 3,
					'post_type'           => array( 'post' ),
					'post_status'         => array( 'publish' ),
					'has_password'        => false,
					'ignore_sticky_posts' => true,
					'order'               => 'DESC',
					'orderby'             => 'date',
					'no_found_rows'       => true,
					'tax_query'           => array(
						array(
							'taxonomy' => 'category',
							'field'    => 'term_id',
							'terms'    => 1036,
						),
					),
				);

				$query = new WP_Query( $args );

				// if no posts.
				if ( ! $query->have_posts() ) {
					return 'Sorry, there are no posts.';
				}

				if ( $query->have_posts() ) {
					?>


				<!-- wp:columns {"className":"is-style-section-header-column"} -->
				<div class="wp-block-columns is-style-section-header-column">
					<!-- wp:column {"width":"90%","className":"bh-01"} -->
					<div class="wp-block-column bh-01" style="flex-basis:90%">
						<!-- wp:heading {"level":3,"placeholder":"Section header text","className":"is-style-max-width-100"} -->
						<h2 class="is-style-max-width-100">Latest news and
							insights from our end user community</h2>
						<!-- /wp:heading -->
					</div>
					<!-- /wp:column -->

					<!-- wp:column {"width":"10%","className":"bh-02"} -->
					<div class="wp-block-column bh-02" style="flex-basis:10%">
						<!-- wp:heading {"level":6,"placeholder":"View all...","className":"is-style-add-chevron-after"} -->
						<h6 class="is-style-add-chevron-after"><a
								href="/blog">See all blog posts</a></h6>
						<!-- /wp:heading -->
					</div>
					<!-- /wp:column -->
				</div>
				<!-- /wp:columns -->
				<div class="wp-block-columns better-responsive-columns">
					<?php
					while ( $query->have_posts() ) :
						$query->the_post();
						echo '<div class="wp-block-column" style="flex-basis:33.33%">';
						lf_newsroom_show_post( get_the_ID(), true, false );
						echo '</div>';
				endwhile;
					wp_reset_postdata();
					?>
				</div>

					<?php
				}
				?>
				<!-- end of newsroom -->

				<!-- wp:spacer {"height":20} -->
				<div style="height:20px" aria-hidden="true"
					class="wp-block-spacer"></div>
				<!-- /wp:spacer -->

				<!-- wp:shortcode -->
				<?php echo do_shortcode( '[eu_playlist key="AIzaSyB63Mb5LIvCSVuPQi778uxOAPl64QXK_-M"]' ); ?>
				<!-- /wp:shortcode -->

				<!-- wp:spacer {"height":80,"className":"is-style-80-responsive"} -->
				<div style="height:80px" aria-hidden="true"
					class="wp-block-spacer is-style-80-responsive"></div>
				<!-- /wp:spacer -->
			</div>
		</div>
		<!-- /wp:group -->

		<!-- wp:group {"align":"full","backgroundColor":"tertiary-400","className":"is-style-default"} -->
		<div
			class="wp-block-group alignfull is-style-default has-tertiary-400-background-color has-background">
			<div class="wp-block-group__inner-container">
				<!-- wp:spacer {"className":"is-style-40-responsive"} -->
				<div style="height:100px" aria-hidden="true"
					class="wp-block-spacer is-style-40-responsive"></div>
				<!-- /wp:spacer -->

				<!-- wp:heading {"level":3,"textColor":"white"} -->
				<h2 class="has-white-color has-text-color">End user
					representatives</h2>
				<!-- /wp:heading -->

				<?php echo do_shortcode( '[eu_reps person_ids="51113,58717,51812,58136,60715,60401"]' ); ?>
		</div>
		<!-- /wp:group -->
				<?php

			endwhile;
		endif;
		?>
	</article>
</main>

<?php
get_template_part( 'components/footer' );
