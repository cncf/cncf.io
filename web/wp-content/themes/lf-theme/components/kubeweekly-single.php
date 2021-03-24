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
		<p class="date-author-row"><span
			class="posted-date date-icon">Posted on
			<?php
			the_date();
			?>
		</span>
		</p>
		<div style="height:160px" aria-hidden="true" class="wp-block-spacer is-style-60-responsive"></div>
		</div>

		<div class="wp-block-column" style="flex-basis:40%">
		<div class="wp-block-group has-white-color has-tertiary-400-background-color has-text-color has-background"><div class="wp-block-group__inner-container">

		<h4>Join the KubeWeekly mailing list</h4>
		<?php echo do_shortcode( '[hubspot type=form portal=8112310 id=cf924a1f-5b8b-40dc-9452-b207c494dae2]' ); ?>
		<p class="has-small-font-size">By submitting this form, you acknowledge that your information is subject to The Linux Foundation’s <a href="https://www.linuxfoundation.org/privacy/" rel="noopener" class="external" target="_blank">Privacy Policy</a>.</p>

		</div></div>
		</div>
		</div>

	</div>
</section>
<main class="newsroom-single">
	<article class="container wrap">
	<div class="entry-content post-content">
		<?php
		the_content();
		get_template_part( 'components/social-share' );
		?>
		<hr class="hr-light">
		<?php
		get_template_part( 'components/post-pagination' );
		?>
	</div>
	</article>
</main>

