<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

get_header();
get_template_part( 'template-parts/global-nav' );
?>

<?php get_template_part( 'template-parts/featured-image' ); ?>
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
							<?php foundationpress_entry_meta(); ?>
						</header>
						<div class="">
							<?php the_content(); ?>
							<?php edit_post_link( __( '(Edit)', 'foundationpress' ), '<span class="edit-link">', '</span>' ); ?>
						</div>
					</div>
				</article>
				<div class="entry-content large-padding-top large-padding-bottom">
					<div class="">
						<?php the_post_navigation(); ?>
						<div class="large-padding-top">
							<?php comments_template(); ?>
						</div>
					</div>
				</div>
			<?php endwhile; ?>
		</main>
	</div>
</div>
<?php
get_footer();
