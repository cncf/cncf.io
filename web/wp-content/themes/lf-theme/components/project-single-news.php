<?php
/**
 * News related to a project
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

$project_name = get_the_title();
?>

<div class="wp-block-columns is-style-section-header">
<div class="wp-block-column bh-01" style="flex-basis:70%">
<h3>Recent news about <?php the_title(); ?></h3>
</div>

<div class="wp-block-column bh-02" style="flex-basis:30%">
<h6 class="is-style-arrow-cta"><a href="/?post_type=post&s=<?php echo esc_attr( $project_name ); ?>">See all related news</a></h6>
</div>
</div>
