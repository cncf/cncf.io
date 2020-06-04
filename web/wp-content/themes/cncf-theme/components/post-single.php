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
		<div class="skew-box secondary centered">CNCF
				<?php
				echo esc_html( $category_author );
				?>
			Blog Post</div>
				<?php
	endif;
			?>
		<p class="newsroom-single-meta date-icon">Posted on
			<?php
			the_date();
			?>
		</p>

			<?php
			if ( in_category( 'blog' ) ) :

				if ( $guest_author ) {
					?>
		<p class="newsroom-guest-author">
					<?php echo esc_html( $guest_author ); ?></p>
					<?php
				} else {
					?>
		<p class="newsroom-single-meta">
					<?php echo esc_html( Cncf_Utils::display_author( get_the_ID() ) ); ?>

			</p>
					<?php
				}
			endif;
			?>

		<div class="entry-content post-content">
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
