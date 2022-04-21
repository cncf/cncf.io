<?php
/**
 * Front Page
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

get_template_part( 'components/header' );
get_template_part( 'components/home-hero' );
get_template_part( 'components/home-projects' );
?>

<article class="container wrap">
	<?php
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			the_content();
		endwhile;
	endif;
	?>
</article>
<?php
get_template_part( 'components/footer' );
