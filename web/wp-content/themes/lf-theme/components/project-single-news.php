<?php
/**
 * News related to a project
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

$project_name = get_the_title();

$related_args = array(
	'posts_per_page'     => 3,
	'ignore_custom_sort' => true,
	'post_type'          => array( 'post' ),
	'post_status'        => array( 'publish' ),
	'order'              => 'DESC',
	'orderby'            => 'date',
	'no_found_rows'      => true,
	's'                  => $project_name,
);

$related_query = new WP_Query( $related_args );

if ( ! $related_query->post_count ) {
	return;
}

?>
<div class="wp-block-group alignfull has-blue-100-background-color has-background">
<div class="wp-block-group__inner-container">
<div style="height:60px" aria-hidden="true" class="wp-block-spacer is-style-40-responsive"></div>

<div class="wp-block-columns is-style-section-header">
<div class="wp-block-column bh-01" style="flex-basis:70%">
<h3>Recent news about <?php the_title(); ?></h3>
</div>

<div class="wp-block-column bh-02" style="flex-basis:30%">
<h6 class="is-style-arrow-cta"><a href="<?php echo esc_url( '/?post_type=post&s=' . $project_name ); ?>">See all related news</a></h6>
</div>
</div>

<div class="wp-block-lf-newsroom">
<?php
while ( $related_query->have_posts() ) {
	$related_query->the_post();
	echo '<div class="newsroom-post-wrapper">';
	lf_newsroom_show_post( get_the_ID(), true, false );
	echo '</div>';
}
wp_reset_postdata();
?>
</div>

<div style="height:60px" aria-hidden="true" class="wp-block-spacer is-style-40-responsive"></div>
</div>
</div>
