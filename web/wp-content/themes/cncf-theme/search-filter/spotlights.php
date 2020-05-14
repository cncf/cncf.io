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

?>

<p class="results-count">
	<?php
	if ( $query->have_posts() ) :
		$full_count = $wpdb->get_var( "select count(*) from wp_posts where wp_posts.post_type = 'cncf_spotlight' and wp_posts.post_status = 'publish';" );
		if ( $full_count == $query->found_posts ) {
			echo 'Found ' . esc_html( $query->found_posts ) . ' spotlights';
		} else {
			echo 'Showing ' . esc_html( $query->found_posts ) . ' of ' . esc_html( $full_count ) . ' spotlights';
		}
		?>
</p>
<div class="webinars-wrapper">
		<?php
		while ( $query->have_posts() ) :
			$query->the_post();

			// get spotlight type.
			$spotlight_type = Cncf_Utils::get_term_names( get_the_ID(), 'cncf-spotlight-type', true );

			?>
	<div class="webinar-recorded-box box-shadow">
		<div class="skew-box secondary">CNCF
			<?php echo esc_html( $spotlight_type ); ?> Spotlight</div>

		<div class="speaker-photo">
			<a href="<?php the_permalink(); ?>"
				title="<?php the_title(); ?>">
				<?php echo get_the_post_thumbnail(); ?>
			</a>
		</div>

		<h5 class="webinar-title"><a
				href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>

		<div class="spotlight-date">
				<?php echo get_the_date(); ?></div>
	</div>
<?php endwhile; ?>
</div>
		<?php
else :
	echo 'No Results Found';
endif;
