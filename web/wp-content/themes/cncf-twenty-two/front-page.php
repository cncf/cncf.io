<?php
/**
 * Front Page
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

get_template_part( 'components/header' );

get_template_part( 'components/skip-link-target' );

get_template_part( 'components/home-hero' );
?>
<article class="container wrap">
	<?php
	get_template_part( 'components/home-projects' );

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
