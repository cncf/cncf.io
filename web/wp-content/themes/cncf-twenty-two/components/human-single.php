<?php
/**
 * Humans of Cloud Native
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

?>

<main class="human">
	<article class="container wrap post-content">
		<?php

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
