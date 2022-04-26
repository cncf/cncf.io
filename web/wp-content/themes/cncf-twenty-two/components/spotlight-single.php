<?php
/**
 * Spotlight
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

?>

<main class="spotlight">
	<article class="container wrap post-content">
<?php
get_template_part( 'components/post-author' );
?>

<div style="height:60px" aria-hidden="true"
			class="wp-block-spacer is-style-40-60">
		</div>

		<?php

		if ( has_post_thumbnail() ) {
			// display smaller news image.
			Lf_Utils::display_responsive_images( get_post_thumbnail_id(), 'newsroom-post-width', '900px', 'spotlight__image', 'lazy', get_the_title() );
		}

		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				the_content();
			endwhile;
		endif;
		?>
	</article>
</main>
