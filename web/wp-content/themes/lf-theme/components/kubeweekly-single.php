<?php
/**
 * Kubeweekly content - the loop
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

?>
<section class="hero">
	<div class="container wrap no-background">

		<div class="wp-block-columns">
		<div class="wp-block-column" style="flex-basis:60%">
		<p class="hero-parent-link">
			<a href="<?php echo esc_url( get_home_url() ); ?>/kubeweekly/" title="See all Kubeweeklys">Kubeweekly</a>
		</p>
		<h1 class="hero-post-title" itemprop="headline">
			<?php
			the_title();
			?>
		</h1>
		<p class="date-author-row kubeweekly-date-author-row"><span
			class="posted-date date-icon">Posted on
			<?php
			echo get_the_date();
			?>
		</span>
		</p>
		</div>

		<div class="wp-block-column" style="flex-basis:40%">
		<?php echo do_shortcode( '[kubeweekly-newsletter]' ); ?>
	</div>
		</div>

	</div>
</section>
<main class="kubeweekly-single">
	<article class="container wrap">
	<div class="entry-content post-content">
		<?php
		the_content();
		get_template_part( 'components/social-share' );
		?>
	</div>
	</article>
</main>

