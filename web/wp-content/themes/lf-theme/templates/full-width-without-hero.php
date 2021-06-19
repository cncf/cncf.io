<?php
/**
 * Template Name: Full-width page without hero
 * Template Post Type: page
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

get_template_part( 'components/header' );

?>
<main class="page-content" id="maincontent">
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
