<?php
/**
 * Template Name: Community Events
 * Template Post Type: lfe_about_page
 *
 * @package FoundationPress
 */

get_header();
get_template_part( 'template-parts/global-nav' );
?>

<div class="main-container">
	<div class="grid-container">
		<div class="grid-x grid-margin-x">
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<div class="cell">
					<header class="about-page-header">
						<h1 class="entry-title"><?php the_title(); ?></h1>
					</header>
				</div>
				<div class="cell large-8 xlarge-margin-bottom">
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<div class="entry-content">
							<div class="">
								<?php the_content(); ?>
							</div>
						</div>
					</article>
				</div>
			<?php endwhile; ?>
			<div class="cell large-4 sidebar-widgets">
				<?php dynamic_sidebar( 'community-events-widgets' ); ?>
			</div>
		</div>
	</div>
</div>
<?php
get_footer();
