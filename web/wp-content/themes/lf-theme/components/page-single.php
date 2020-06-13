<?php
/**
 * Page content - the loop
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

?>

<main class="page-content">
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
