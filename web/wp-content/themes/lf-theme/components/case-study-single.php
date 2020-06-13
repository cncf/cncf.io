<?php
/**
 * Case Study content - the loop
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

?>

<main class="case-study-single">
	<article class="container wrap">
		<?php
		while ( have_posts() ) :
			the_post();
			?>
		<div class="entry-content">
			<?php
			the_content();
			?>
		</div>
			<?php
		endwhile;
		?>
	</article>
</main>
