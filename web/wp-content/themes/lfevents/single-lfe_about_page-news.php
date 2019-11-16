<?php //phpcs:ignore
/**
 * The template for displaying a specific about page with the slug "news"
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

get_header();
get_template_part( 'template-parts/global-nav' );
?>

<div class="main-container">
	<div class="main-grid">
		<main class="main-content-full-width">
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="entry-content">
						<header class="about-page-header">
							<h1 class="entry-title"><?php the_title(); ?></h1>
						</header>
						<?php the_content(); ?>
						<?php edit_post_link( __( '(Edit)', 'foundationpress' ), '<span class="edit-link">', '</span>' ); ?>
					</div>
				</article>
				<?php comments_template(); ?>
			<?php endwhile; ?>
			<div class="entry-content">
				<div class="">
					<div class="grid-x grid-margin-x medium-up-2 large-up-3">
						<?php
						query_posts( 'posts_per_page=60' );
						// The Loop.
						if ( have_posts() ) :
							while ( have_posts() ) :
								the_post();
								echo '<div class="cell callout large-margin-bottom">';
								echo '<h4 class="no-margin line-height-tight"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h4>'; //phpcs:ignore
								echo '<p class="text-small">' . get_the_date() . '</p>'; //phpcs:ignore
								echo '<p class="">' . get_the_excerpt() . '</p>'; //phpcs:ignore
								echo '</div>';
						endwhile;
						endif;
						// Reset Query.
						wp_reset_query();
						?>
					</div>
				</div>
			</div>
		</main>
	</div>
</div>
<?php
get_footer();
