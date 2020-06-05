<?php
/**
 * Spotlight content - the loop
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

 // get author category.
$author_category = Cncf_Utils::get_term_names( get_the_ID(), 'cncf-author-category', true );
?>
<section class="hero">
	<div class="container wrap no-background">
		<p class="hero-parent-link"><a href="/spotlights/"
				title="Go to Spotlights">Spotlight</a></p>
		<h1 class="hero-post-title" itemprop="headline">
			<?php
			the_title();
			?>
		</h1>
	</div>
</section>
<main class="spotlight-single">
	<article class="container wrap">
		<?php
		while ( have_posts() ) :
			the_post();
			?>

<p>Posted on
			<?php
			the_date();
			?>
</p>

<div class="skew-box secondary centered margin-bottom-large">CNCF
			<?php echo esc_html( $author_category ); ?> Spotlight</div>
			<div class="entry-content">
			<?php the_content(); ?>
		</div>

			<?php
			get_template_part( 'components/social-share' );
			?>
		<?php endwhile; ?>


	</article>
</main>
