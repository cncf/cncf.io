<?php
/**
 * Template Name: Full-width page layout
 * Template Post Type: post, page, lf_event
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

get_template_part( 'components/header' );

get_template_part( 'components/hero' );
?>
<main class="page-content">
	<article class="container-full-width wrap entry-content">
		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				 the_content();
			endwhile;
		endif;
		?>
	</article>
</main>

<?php
get_template_part( 'components/footer' );
