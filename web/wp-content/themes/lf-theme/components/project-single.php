<?php
/**
 * Case Study content - the loop
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

?>
<section class="hero" id="maincontent">
	<div class="container wrap no-background">
		<p class="hero-parent-link"><a href="/projects/"
				title="Go to online programs">Project</a></p>
		<h1 class="hero-post-title" itemprop="headline">
			<?php
			the_title();
			?>
		</h1>
	</div>
</section>

<main class="project-single">
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
