<section class="basic-content full container">
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
