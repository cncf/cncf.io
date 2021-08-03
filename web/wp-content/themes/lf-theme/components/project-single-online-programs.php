<?php
/**
 * Online programs related to a project
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

global $post;
$project_slug = $post->post_name;

$the_project = wp_get_post_terms( $post->ID, 'lf-project', array( 'fields' => 'ids' ) );

// state number of related posts required.
$number_related_posts = 3;

// setup the arguments.
$related_args = array(
	'posts_per_page'     => $number_related_posts,
	'ignore_custom_sort' => true,
	'post_type'          => array( 'lf_webinar' ),
	'post_status'        => array( 'publish' ),
	'meta_key'           => 'lf_webinar_date',
	'order'              => 'DESC',
	'orderby'            => 'meta_value',
	'no_found_rows'      => true,
	'meta_query'         => array(
		array(
			'key'     => 'lf_webinar_recording_url',
			'value'   => 0,
			'compare' => '>',
		),
	),
	'tax_query'          => array(
		array(
			'taxonomy' => 'lf-project',
			'field'    => 'slug',
			'terms'    => $project_slug,
		),
	),
);

$related_query = new WP_Query( $related_args );

if ( ! $related_query->post_count ) {
	return;
}

?>

<div class="wp-block-columns is-style-section-header">
<div class="wp-block-column bh-01" style="flex-basis:70%">
<h3>Related recorded programs</h3>
</div>

<div class="wp-block-column bh-02" style="flex-basis:30%">
<h6 class="is-style-arrow-cta"><a href="/upcoming-online-programs/?_sft_lf-project=<?php echo esc_attr( $project_slug ); ?>">See upcoming programs</a></h6>
</div>
</div>

<div class="webinars-wrapper">
<?php
while ( $related_query->have_posts() ) {
	$related_query->the_post();
	get_template_part( 'components/recorded-webinars-item' );
}
wp_reset_postdata();
?>
</div>
