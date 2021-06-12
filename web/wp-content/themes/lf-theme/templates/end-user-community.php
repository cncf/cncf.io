<?php
/**
 * Template Name: End User Community
 * Template Post Type: page
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

get_template_part( 'components/header' );

get_template_part( 'components/hero' );
?>

<?php
// This is loaded for the icons in the pricing table.
wp_enqueue_script( 'font-awesome', 'https://kit.fontawesome.com/5db798d128.js', array(), filemtime( get_template_directory() . '/build/global.js' ), 'all' );
?>

<main class="page-content end-user-page">
	<article class="container wrap entry-content">
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
