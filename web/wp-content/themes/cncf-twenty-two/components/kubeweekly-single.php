<?php
/**
 * Kubeweekly content - the loop
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

?>

<main class="kubeweekly-single">
	<article class="container wrap page-content">

	<section class="hero alignfull">

		<figure class="hero__figure">
			<?php
			$site_options = get_option( 'lf-mu' );
			Lf_Utils::display_picture( 114723, 'hero', 'hero__image' );
			?>
		</figure>

		<div class="container wrap hero__text-overlay title-wrapper lf-grid">

		<div class="col1">
			<h1 class="is-style-case-study-title"><?php the_title(); ?></h1>
			<div style="height:30px"
				aria-hidden="true" class="wp-block-spacer">
			</div>
			<p class="is-style-spaced-uppercase has-small-font-size">Published: <?php echo get_the_date(); ?></p>
		</div>
		<div class="col2">
			<img width="180" src="/wp-content/themes/cncf-twenty-two/images/projects/kubernetes-icon-color.svg" alt="Kubernetes">
		</div>

		</section>

		<?php
		while ( have_posts() ) :
			the_post();
			the_content();
		endwhile;
		?>
		<div style="height:80px"
			aria-hidden="true" class="wp-block-spacer is-style-60-100">
		</div>
		<?php
		get_template_part( 'components/social-share' );
		?>
		<div style="height:80px"
			aria-hidden="true" class="wp-block-spacer is-style-60-100">
		</div>

	</article>

	<aside class="container wrap">
		<?php
			echo do_shortcode( '[event_banner hide_title=true]' );
		?>
	</aside>
</main>