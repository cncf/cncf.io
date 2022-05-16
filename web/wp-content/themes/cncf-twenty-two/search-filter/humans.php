<?php
/**
 * Search & Filter Pro
 *
 * Spotlights
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

if ( $query->have_posts() ) : ?>
<div class="humans columns-three">
		<?php
		while ( $query->have_posts() ) :
			$query->the_post();

			get_template_part( 'components/human-item' );

	endwhile;
		?>
</div>
		<?php
endif;
