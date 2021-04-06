<?php
/**
 * WIP - Home News
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

$blog_quantity    = 2;
$webinar_quantity = 1;
$classes          = '';
$category         = 230;
$show_images      = true;

// get sticky posts.
$sticky_post = null;
$sticky      = get_option( 'sticky_posts' );
if ( $sticky ) {
	$args        = array(
		'posts_per_page'      => 1,
		'post_type'           => array( 'post' ),
		'post_status'         => array( 'publish' ),
		'has_password'        => false,
		'post__in'            => $sticky,
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
		'tax_query'           => array(
			array(
				'taxonomy' => 'category',
				'field'    => 'term_id',
				'terms'    => $category,
			),
		),
	);
	$stickyquery = new WP_Query( $args );

	if ( $stickyquery->have_posts() ) {
		$stickyquery->the_post();
		--$blog_quantity;
		$sticky_post = get_the_ID();
	}
}

// setup the arguments.
$args = array(
	'posts_per_page'      => $blog_quantity,
	'post_type'           => array( 'post' ),
	'post_status'         => array( 'publish' ),
	'has_password'        => false,
	'ignore_sticky_posts' => true,
	'post__not_in'        => array( $sticky_post ),
	'order'               => 'DESC',
	'orderby'             => 'date',
	'no_found_rows'       => true,
	'tax_query'           => array(
		array(
			'taxonomy' => 'category',
			'field'    => 'term_id',
			'terms'    => $category,
		),
	),
);

$query = new WP_Query( $args );

// if no posts.
if ( ! $query->have_posts() && ! $sticky_post ) {
	return 'Sorry, there are no posts.';
}

if ( $query->have_posts() ) { ?>

<section class="home-news">
<div class="wp-block-group alignfull has-white-color has-tertiary-400-background-color has-text-color has-background"><div class="wp-block-group__inner-container">
<div style="height:40px" aria-hidden="true" class="wp-block-spacer is-style-40-responsive"></div>



<h2>Latest blog posts &amp; webinars</h2>



<div class="wp-block-columns better-responsive-columns">


	<?php
	if ( $sticky_post ) {
		echo '<div class="wp-block-column" style="flex-basis:33.33%">';
		lf_newsroom_show_post( $sticky_post, $show_images, true );
		echo '</div>';
	}

	if ( $blog_quantity > 0 ) :
		while ( $query->have_posts() ) :
			$query->the_post();
			echo '<div class="wp-block-column" style="flex-basis:33.33%">';
			lf_newsroom_show_post( get_the_ID(), $show_images, false );
			echo '</div>';
	endwhile;
endif;
	wp_reset_postdata();

}

// setup the arguments for the webinar.
$args = array(
	'posts_per_page' => $webinar_quantity,
	'post_type'      => array( 'lf_webinar' ),
	'post_status'    => array( 'publish' ),
	'meta_key'       => 'lf_webinar_date',
	'order'          => 'ASC',
	'meta_type'      => 'DATETIME',
	'orderby'        => 'meta_value',
	'no_found_rows'  => true,
	'meta_query'     => array(
		array(
			'key'     => 'lf_webinar_date',
			'value'   => date_i18n( 'Y-m-d' ),
			'compare' => '>=',
			'type'    => 'DATETIME',
		),
		array(
			'key'     => 'lf_webinar_recording',
			'compare' => 'NOT EXISTS',
		),
	),
);

$query = new WP_Query( $args );

if ( $query->have_posts() ) {
	?>
<div class="wp-block-column " style="flex-basis:33.33%">
		<?php
		while ( $query->have_posts() ) :
			$query->the_post();

			get_template_part(
				'components/upcoming-webinars-item',
				null,
				array(
					'show_images' => $show_images,
				)
			);
endwhile;
		wp_reset_postdata();
		?>
</div>



	<?php
}


?>
	</div>

</div>



<div style="height:40px" aria-hidden="true" class="wp-block-spacer is-style-40-responsive"></div>
</div></div>
</section>
