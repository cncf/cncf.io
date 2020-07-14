<?php
/**
 * Template Name: Speaker
 * Template Post Type: post, page, lf_event, lf_speaker
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

get_template_part( 'components/header' );

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post(); ?>

<section class="hero">
	<div class="container wrap no-background">
		<p class="hero-parent-link"><a href="/speakers/"
				title="Go to Speakers Bureau">Speaker</a></p>
		<h1 class="hero-post-title" itemprop="headline">
			<?php
			the_title();
			?>
		</h1>
	</div>
</section>

<main class="page-content">
	<article class="container wrap entry-content">
		<?php the_content(); ?>
	</article>
</main>
		<?php
endwhile;
endif;

get_template_part( 'components/footer' );
