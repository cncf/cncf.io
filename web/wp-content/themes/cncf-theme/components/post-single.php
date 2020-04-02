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
		$all_categories = get_the_category();
		if ( $all_categories ) :
			?>
<p class="post-single-category">
			<?php
			// Only get the first item in the array.
			$category = array_shift( $all_categories );
			// $category = $the_category->name;
			echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="See Posts in ' . esc_html( $category->name ) . '">' . esc_html( $category->name ) . '</a>';
			?>
	</p>
			<?php
endif;
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

<?php
			// Get the Category Author terms associated if any.
			$terms = get_the_terms( $post->ID, 'cncf-author-category' );
			if ( $terms ) {
				// Only get the first item in the array.
				$term            = array_shift( $terms );
				$category_author = $term->name;
			}
			if ( ! empty( $category_author ) ) :
				?>
		<p class="post-single-author-category ">CNCF <?php echo $category_author; ?> Blog Post</p>
				<?php
			endif;
			?>

			<?php
			// TODO: substitute this block name for the Guest Post block.
			// if ( has_block( 'guest-byline' ) : //phpcs:ignore.
			if ( ! has_block( 'core/headings' ) ) :
				?>
		<p class="post-single-meta">Posted on <?php the_date(); ?></p>
		<p class="post-single-meta"><?php echo 'By ' . get_the_author(); ?></p>
				<?php
endif;
			?>


		<div class="entry-content">

			<?php

			the_content();

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
