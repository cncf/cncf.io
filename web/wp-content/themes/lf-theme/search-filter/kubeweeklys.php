<?php
/**
 * Search & Filter Pro
 *
 * Kubeweeklys
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

if ( $query->have_posts() ) :
	?>
	<div class="events-wrapper">
		<?php
		$first_issue = true;
		while ( $query->have_posts() ) :
			$query->the_post();
			?>
				<div class="archive-item">
				<div class="archive-text-wrapper">
				<?php
				if ( $first_issue ) {
					$first_issue = false;
					echo '<p>Current issue</p>';
				}
				?>
				<p class="archive-title"><a
						href="<?php echo esc_url( $link_url ); ?>"
						title="<?php the_title(); ?>">
						<?php the_title(); ?>
				</a></p>
				<p class="date-author-row"><span class="posted-date date-icon">
				<?php echo get_the_date( 'F j, Y' ); ?></span></p>
				</div>
				</div>
		<?php endwhile; ?>
	</div>
		<?php
else :
	echo 'No Results Found';
endif;
