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
		<p class="newsroom-single-category">
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
		<h1 class="newsroom-single-title" itemprop="headline">
			<?php the_title(); ?></h1>
	</div>
</section>
<main class="newsroom-single">
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
		<p class="newsroom-single-author-category ">CNCF
				<?php echo $category_author; ?> Blog Post</p>
				<?php
		endif;
			?>
		<p class="newsroom-single-meta">Posted on <?php the_date(); ?></p>
			<?php
			if ( ! has_block( 'lf/guest-author' ) ) :
				?>
		<p class="newsroom-single-meta"><?php echo 'By ' . get_the_author(); ?>
		</p>
				<?php
		endif;
			?>
		<div class="entry-content">
			<?php
			the_content();
			get_template_part( 'components/social-share' );
			?>
			<hr class="newsroom-single-hr">
			<?php
			get_template_part( 'components/post-pagination' );
			?>
		</div>
			<?php
endwhile;
		?>
	</article>
</main>
