<?php
/**
 * Post content - the loop
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

?><section class="hero">
	<div class="container wrap no-background">
		<?php
		// Category of the post.
		$all_categories = get_the_category();
		if ( $all_categories ) :
			?>
		<p class="hero-parent-link">
			<?php
			// Only get the first item in the array.
			$category = array_shift( $all_categories );
			echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="See Posts in ' . esc_html( $category->name ) . '">' . esc_html( $category->name ) . '</a>';
			?>
		</p>
			<?php
endif;
		?>
		<h1 class="hero-post-title" itemprop="headline">
			<?php
			the_title();
			?>
		</h1>
	</div>
</section>
<main class="newsroom-single">
	<article class="container wrap">
		<?php
		while ( have_posts() ) :
			the_post();
			?>

			<?php
			// Get the Category Author.
			$category_author = Cncf_Utils::get_term_names( get_the_ID(), 'cncf-author-category', true );

			// Get the guest author meta.
			$guest_author = get_post_meta( get_the_ID(), 'cncf_post_guest_author', true );

			if ( $category_author ) :
				?>
		<div class="skew-box secondary centered margin-bottom-large">CNCF
				<?php
				echo esc_html( $category_author );
				?>
			Blog Post</div>
				<?php
		endif;
			?>
		<p class="date-author-responsive"><span
				class="posted-date date-icon">Posted on
				<?php
				the_date();
				?>
			</span>
			<?php
			// Post author.
			if ( in_category( 'blog' ) ) :
				if ( $guest_author ) {
					?>
			<span class="author-name author-icon">
					<?php echo esc_html( $guest_author ); ?>
			</span>
					<?php
				} else {
					echo wp_kses_post( Cncf_Utils::display_author( get_the_ID(), true ) );
				}
				?>
			</span>
				<?php
		endif;
			?>
		</p>

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
			<?php
endwhile;
		?>
	</article>
</main>
