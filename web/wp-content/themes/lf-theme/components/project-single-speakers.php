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
?>

<div class="wp-block-columns is-style-section-header">
<div class="wp-block-column bh-01" style="flex-basis:70%">
<h3>Speakers with <?php the_title(); ?> expertise</h3>
</div>

<div class="wp-block-column bh-02" style="flex-basis:30%">
<h6 class="is-style-arrow-cta"><a href="/speakers/?_sft_lf-project=<?php echo esc_attr( $project_slug ); ?>">See all</a></h6>
</div>
</div>
