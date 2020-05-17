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
<div class="spotlights-wrapper">
		<?php
		while ( $query->have_posts() ) :
			$query->the_post();

			$subtitle = get_post_meta( get_the_ID(), 'cncf_spotlight_subtitle', true );

			// get spotlight type.
			$spotlight_type = Cncf_Utils::get_term_names( get_the_ID(), 'cncf-spotlight-type', true );

			?>
	<div class="spotlight-box box-shadow">

		<div class="spotlight-photo">
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
				<?php
				if ( has_post_thumbnail() ) {
					echo wp_get_attachment_image( get_post_thumbnail_id(), 'thumbnail', false, array( 'class' => 'spotlight-thumbnail' ) );
				} else {
					$options = get_option( 'cncf-mu' );
					echo wp_get_attachment_image( $options['generic_avatar_id'], 'thumbnail', false, array( 'class' => 'spotlight-thumbnail' ) );
				}
				?>
			</a>
		</div>

		<div class="skew-box secondary centered">CNCF
			<?php echo esc_html( $spotlight_type ); ?> Spotlight</div>

		<h5 class="spotlight-title"><a
				href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>

		<div class="spotlight-date">
			<?php echo get_the_date( 'F Y' ); ?></div>

			<?php echo esc_html( $subtitle ); ?>

	</div>
	<?php endwhile; ?>
</div>
		<?php
else :
	echo 'No Results Found';
endif;
