<?php
/**
 * Spotlight content - the loop
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

// get author category.
$spotlight_type = Lf_Utils::get_term_names( get_the_ID(), 'lf-spotlight-type', true );
$spotlight_type_slug = Lf_Utils::get_term_slugs( get_the_ID(), 'lf-spotlight-type', true );

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

			<?php
			if ( $spotlight_type ) :
				$spotlight_type_link = '/spotlights/?_sft_lf-spotlight-type=' . $spotlight_type_slug;
				?>
		<a class="skew-box secondary centered margin-bottom-small" title="See more <?php echo esc_attr( $spotlight_type ); ?> spotlights" href="<?php echo esc_url( $spotlight_type_link ); ?>">CNCF
				<?php echo esc_html( $spotlight_type ); ?> Spotlight</a>
		<?php endif; ?>

		<p><span class="posted-date date-icon">Posted on
			<?php
			the_date();
			?>
		</span></p>


		<div class="entry-content">
			<?php the_content(); ?>
		</div>

			<?php
			get_template_part( 'components/social-share' );
			?>
		<?php endwhile; ?>
	</article>
</main>
