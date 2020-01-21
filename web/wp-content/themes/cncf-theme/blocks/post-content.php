<section class="basic-content container">
	<article class="content">
		<?php while ( have_posts() ) :
			the_post(); ?>

			<?php
			if ( has_post_thumbnail() ) {
				the_post_thumbnail( 'blog-feature-image' );

				echo '<h2>' . get_the_title() . '</h2>';

			}
			?>

		<p class="meta">
			Posted: <?php the_date(); ?> | <?php echo get_the_category_list( ', ' ); ?> | <svg aria-hidden="true" data-prefix="fal" data-icon="comment-alt-lines" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-comment-alt-lines fa-w-16 fa-2x"><path fill="currentColor" d="M448 0H64C28.7 0 0 28.7 0 64v288c0 35.3 28.7 64 64 64h96v84c0 7.1 5.8 12 12 12 2.4 0 4.9-.7 7.1-2.4L304 416h144c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64zm32 352c0 17.6-14.4 32-32 32H293.3l-8.5 6.4L192 460v-76H64c-17.6 0-32-14.4-32-32V64c0-17.6 14.4-32 32-32h384c17.6 0 32 14.4 32 32v288zM280 240H136c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8h144c4.4 0 8-3.6 8-8v-16c0-4.4-3.6-8-8-8zm96-96H136c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8h240c4.4 0 8-3.6 8-8v-16c0-4.4-3.6-8-8-8z" class=""></path></svg> <?php echo get_comments_number(); ?>
		</p>


			<?php the_content(); ?>


			<?php
			$prev = get_adjacent_post( true, '', true );
			$next = get_adjacent_post( true, '', false );
			?>

			<?php if ( $prev ) : ?>
		<a href="<?php echo get_permalink( $prev->ID ); ?>" class="button smaller">Previous Post</a>
			<?php endif; ?>
			<?php if ( $next ) : ?>
		<a href="<?php echo get_permalink( $next->ID ); ?>" class="button smaller">Next Post</a>
			<?php endif; ?>

		<hr>

			<?php
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;
			?>

		<?php endwhile; ?>

	</article>
</section>
