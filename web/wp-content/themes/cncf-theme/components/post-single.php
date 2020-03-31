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

	<?php
	// Category of the post.
	foreach ( get_the_category() as $category ) {
		echo '<p class="post-single-category">';
		if ( $category->name ) :
			echo '<a href="' . get_category_link( $category->term_id ) . '" title="See Posts in ' . $category->name . '">' . $category->name . '</a>';
		endif;
		echo '</p>';
	}
	?>

		<h1 class="post-title" itemprop="headline"><?php the_title(); ?></h1>
	</div>
</section>
<main class="post-single">
	<article class="container wrap">
		<?php
		while ( have_posts() ) :
			the_post();
			?>
		<p class="post-single-meta">Posted on <?php the_date(); ?> <?php echo 'by ' . get_the_author(); ?></p>
			<?php
			// Get the terms associated.
			$term_obj_list   = get_the_terms( $post->ID, 'cncf-author-category' );
			$category_author = join( ', ', wp_list_pluck( $term_obj_list, 'name' ) );
			if ( ! empty( $category_author ) ) :
				?>
			<p class="post-single-author-category"><?php echo $category_author; ?></p>
				<?php
			endif;
			?>


		<div class="entry-content">
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
