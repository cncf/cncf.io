<?php
/**
 * Page content - the loop
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

?>

<main class="page-content" id="maincontent">
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
</main>
