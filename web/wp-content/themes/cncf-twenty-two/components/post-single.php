<?php
/**
 * Post - Single
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

while ( have_posts() ) :
	the_post();
	?>
<main>
	<article class="container wrap post-content">

		<?php
		// Post author section.
		if ( in_category( 'blog' ) ) :
			get_template_part( 'components/post-author' );
		endif;

		the_content();
		?>

		<div style="height:80px"
			aria-hidden="true" class="wp-block-spacer is-style-80-120">
		</div>
		<?php
		get_template_part( 'components/social-share' );
		?>

		<div style="height:80px"
			aria-hidden="true" class="wp-block-spacer is-style-80-120">
		</div>
	</article>

	<aside class="container wrap">
		<?php
			echo do_shortcode( '[event_banner hide_title=true]' );
		?>
		<h2>Other posts to check out</h2>
		<div style="height:60px"
			aria-hidden="true" class="wp-block-spacer">
		</div>

		<?php
		get_template_part( 'components/latest-news-horizontal' );
		?>
		<div style="height:80px"
			aria-hidden="true" class="wp-block-spacer is-style-80-120">
		</div>

	</aside>
</main>
	<?php
endwhile;
?>
