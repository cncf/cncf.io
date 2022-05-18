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

<div style="height:60px" aria-hidden="true"
			class="wp-block-spacer is-style-40-60">
		</div>

		<?php

		if ( has_post_thumbnail() ) {
			Lf_Utils::display_responsive_images( get_post_thumbnail_id(), 'newsroom-post-width', '900px', 'spotlight__image', 'eager', get_the_title() );
		}

		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				the_content();
			endwhile;
		endif;
		?>
		<div style="height:80px"
			aria-hidden="true" class="wp-block-spacer is-style-60-100">
		</div>
		<?php
		get_template_part( 'components/social-share' );
		?>

	</article>
</main>
