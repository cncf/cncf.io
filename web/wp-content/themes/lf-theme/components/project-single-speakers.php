<?php
/**
 * Speakers with expertise in a project
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

global $post;
$project_slug = $post->post_name;

$related_args = array(
	'posts_per_page'     => 5,
	'ignore_custom_sort' => true,
	'post_type'          => array( 'lf_speaker' ),
	'post_status'        => array( 'publish' ),
	'order'              => 'DESC',
	'orderby'            => 'date',
	'no_found_rows'      => true,
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
<h3>Speakers with <?php the_title(); ?> expertise</h3>
</div>

<div class="wp-block-column bh-02" style="flex-basis:30%">
<h6 class="is-style-arrow-cta"><a href="/speakers/?_sft_lf-project=<?php echo esc_attr( $project_slug ); ?>">See all</a></h6>
</div>
</div>

<div class="speakers-wrapper">
	<?php
	while ( $related_query->have_posts() ) {
		$related_query->the_post();
		// check for user data.
		$user = get_userdata( $post->post_name );

		// if no user then return.
		if ( ! $user ) {
			continue;
		}

		get_template_part( 'components/speaker-item' );
		um_reset_user_clean();

	}
	um_reset_user();
	wp_reset_postdata();
	?>
</div>
<div style="height:80px" aria-hidden="true" class="wp-block-spacer is-style-80-responsive"></div>
