<?php
/**
 * Webinar related posts
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

	$the_topic = wp_get_post_terms( $post->ID, 'lf-topic', array( 'fields' => 'ids' ) );

	$the_project = wp_get_post_terms( $post->ID, 'lf-project', array( 'fields' => 'ids' ) );

	$the_company = wp_get_post_terms( $post->ID, 'lf-company', array( 'fields' => 'ids' ) );

	// state number of related posts required.
	$number_related_posts = 3;

	// setup the arguments.
	$related_args = array(
		'posts_per_page'     => $number_related_posts,
		'ignore_custom_sort' => true,
		'post_type'          => array( 'lf_webinar' ),
		'post__not_in'       => array( get_the_ID() ),
		'post_status'        => array( 'publish' ),
		'meta_key'           => 'lf_webinar_date',
		'order'              => 'ASC',
		'orderby'            => 'meta_value',
		'no_found_rows'      => true,
		'meta_query'         => array(
			array(
				'key'     => 'lf_webinar_date',
				'value'   => date_i18n( 'Y-m-d' ),
				'compare' => '>',
			),
			array(
				'key'     => 'lf_webinar_recording',
				'value'   => '',
				'compare' => 'NOT EXISTS',
			),
		),
		'tax_query'          => array(
			array(
				'relation' => 'OR',
				array(
					'taxonomy' => 'lf-topic',
					'field'    => 'term_id',
					'terms'    => $the_topic,
				),
				array(
					'taxonomy' => 'lf-project',
					'field'    => 'term_id',
					'terms'    => $the_project,
				),
				array(
					'taxonomy' => 'lf-company',
					'field'    => 'term_id',
					'terms'    => $the_company,
				),
			),
		),
	);

	$related_query = new WP_Query( $related_args );

	if ( $related_query->have_posts() ) :
		?>

<div
	class="wp-block-lf-upcoming-webinars entry-content center-align margin-bottom-large">
<div class="container wrap">
	<h3 class="margin-top-large">Related upcoming programs</h3>
	</div>
	<div class="webinars-upcoming-wrapper container wrap">
		<?php
		while ( $related_query->have_posts() ) {
			$related_query->the_post();

			get_template_part( 'components/upcoming-webinars-item' );
		}
		wp_reset_postdata();

		if ( count( $related_query->posts ) < $number_related_posts ) {

			$additional_posts_required = $number_related_posts - count( $related_query->posts );

			$args = array(
				'posts_per_page'     => $additional_posts_required,
				'ignore_custom_sort' => true,
				'post_type'          => array( 'lf_webinar' ),
				'post__not_in'       => array( get_the_ID() ),
				'post_status'        => array( 'publish' ),
				'meta_key'           => 'lf_webinar_date',
				'order'              => 'ASC',
				'orderby'            => 'meta_value',
				'no_found_rows'      => true,
				'meta_query'         => array(
					array(
						'key'     => 'lf_webinar_date',
						'value'   => date_i18n( 'Y-m-d' ),
						'compare' => '>',
					),
					array(
						'key'     => 'lf_webinar_recording',
						'value'   => '',
						'compare' => 'NOT EXISTS',
					),
				),
			);

			$additional_query = new WP_Query( $args );

			if ( $additional_query->have_posts() ) {
				while ( $additional_query->have_posts() ) {
					$additional_query->the_post();

					get_template_part( 'components/upcoming-webinars-item' );

				}
				wp_reset_postdata();
			}
		}
		?>
	</div>
</div>
		<?php
		endif;
	?>
