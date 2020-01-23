<?php
/**
 * Page content - the loop
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

?>

<section class="basic-content container">
	<main>
		<article>
			<div class="content">
				<?php if ( have_posts() ) : ?>
					<?php
					while ( have_posts() ) :
						the_post();
						?>
						<?php the_content(); ?>
				<?php endwhile ?>
				<?php endif; ?>
			</div>
		</article>
	</main>
</section>
