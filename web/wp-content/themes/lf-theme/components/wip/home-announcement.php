<?php
/**
 * WIP - Home Announcement
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

$args = array(
	'post_type'           => array( 'post' ),
	'post_status'         => array( 'publish' ),
	'has_password'        => false,
	'posts_per_page'      => '5',
	'ignore_sticky_posts' => true,
	'order'               => 'DESC',
	'orderby'             => 'date',
	'no_found_rows'       => true,
	'tax_query'           => array(
		array(
			'taxonomy' => 'category',
			'field'    => 'term_id',
			'terms'    => 787,
		),
	),
);

$query = new WP_Query( $args );

if ( $query->have_posts() ) { ?>

<section class="home-announcement home-padding">

<div class="home-announcement-icon">
	<?php
	$image = new Image();

	$image->get_svg( 'icon-newspaper.svg' );
	?>
</div>
<div class="announcement-slider-wrapper">

	<?php

	while ( $query->have_posts() ) {
		$query->the_post();
		?>
<div class="home-announcement-item">
<p class="is-style-max-width-100"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
<span class="date-icon"> <?php echo get_the_date( 'F j, Y' ); ?></span>
</div>
		<?php
	}
}
wp_reset_postdata();

?>
</div>

</section>

<div style="height:80px" aria-hidden="true" class="wp-block-spacer is-style-80-responsive"></div>
