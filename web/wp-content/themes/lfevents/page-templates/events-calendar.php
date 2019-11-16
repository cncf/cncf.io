<?php
/**
 * Template Name: Events Calendar
 * Template Post Type: lfe_about_page
 *
 * @package FoundationPress
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
						<header id="event-calendar-header" class="about-page-header">
							<h1 class="entry-title"><?php the_title(); ?></h1>
						</header>
						<div class="">
							<div class="event-calendar-container">
								<?php the_content(); ?>
							</div>
						</div>
					</div>
				</article>
			<?php endwhile; ?>
		</main>
	</div>
</div>
<?php
get_footer();
