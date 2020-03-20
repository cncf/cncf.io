<?php
/**
 * Post content - the loop
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

?>
<section class="hero">
	<div class="container wrap">
		<h1 class="post-title" itemprop="headline"><?php the_title(); ?></h1>
	</div>
</section>
<main class="post-single content-styling">
	<article class="container wrap">
		<?php
		while ( have_posts() ) :
			the_post();
			?>
		<p class="post-single-meta">Posted on <?php the_date(); ?> by
			<?php the_author(); ?></p>
			<?php
			if ( has_post_thumbnail() ) {
				echo get_the_post_thumbnail( $post->ID, 'post-single-hero-image', array( 'class' => 'post-single-hero-image' ) );
			}
			?>
		<div class="post-entry-content">
			<?php the_content(); ?>

			<?php
			get_template_part( 'components/social-share' );
			?>

			<hr class="post-single-hr">
			<?php
			get_template_part( 'components/post-pagination' );
			?>
		</div>
			<?php
endwhile;
		?>
	</article>
</main>
