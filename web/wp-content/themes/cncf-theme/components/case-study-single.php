<?php
/**
 * Case Study content - the loop
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

?>

<section class="hero">
	<div class="container wrap">
		<p class="hero-post-parent-link"><a href="/case-studies/"
				title="Go to Case Studies">Case Study</a></p>
	</div>
</section>

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
