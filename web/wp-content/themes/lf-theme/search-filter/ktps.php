<?php
/**
 * Search & Filter Pro
 *
 * Events
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

?>

<p class="results-count">
	<?php
	if ( $query->have_posts() ) :
		$full_count = $wpdb->get_var( "select count(*) from wp_posts where wp_posts.post_type = 'lf_ktp' and wp_posts.post_status = 'publish';" );
		if ( $full_count == $query->found_posts ) {
			echo 'Found ' . esc_html( $query->found_posts ) . ' KTPs';
		} else {
			echo 'Showing ' . esc_html( $query->found_posts ) . ' of ' . esc_html( $full_count ) . ' KTPs';
		}
		?>
</p>
<div class="events-wrapper">
		<?php
		while ( $query->have_posts() ) :
			$query->the_post();

			$logo  = get_post_meta( get_the_ID(), 'lf_ktp_logo', true );
			$image = new Image();

			$description    = get_post_meta( get_the_id(), 'lf_ktp_description', true );
			$external_url   = get_post_meta( get_the_ID(), 'lf_ktp_external_url', true );
			$github         = get_post_meta( get_the_ID(), 'lf_ktp_github', true );
			$stack_overflow = get_post_meta( get_the_ID(), 'lf_ktp_stack_overflow', true );
			$devstats       = get_post_meta( get_the_ID(), 'lf_ktp_devstats', true );
			$logos          = get_post_meta( get_the_ID(), 'lf_ktp_logos', true );
			$mail           = get_post_meta( get_the_ID(), 'lf_ktp_mail', true );
			$blog           = get_post_meta( get_the_ID(), 'lf_ktp_blog', true );
			$twitter        = get_post_meta( get_the_ID(), 'lf_ktp_twitter', true );
			$slack          = get_post_meta( get_the_ID(), 'lf_ktp_slack', true );
			$youtube        = get_post_meta( get_the_ID(), 'lf_ktp_youtube', true );
			$gitter         = get_post_meta( get_the_ID(), 'lf_ktp_gitter', true );

			?>
	<article class="event-box background-image-wrapper">
		<div class="event-content-wrapper background-image-text-overlay">

			<div class="event-logo">
			<?php if ( $logo ) : ?>
				<a href="<?php the_permalink(); ?>"
					title="<?php the_title(); ?>">
				<?php
						echo wp_get_attachment_image( $logo, 'medium', false );
				?>
						  </a>
		<?php else : ?>
						<h4 class="event-title"><a href="<?php the_permalink(); ?>"
					title="<?php the_title(); ?>"><?php the_title(); ?></a></h4>
						<?php endif; ?>
				</a>
			</div>

			<a href="<?php the_permalink(); ?>"
				class="button on-image">Learn More</a>
		</div>
	</article>
<?php endwhile; ?>
</div>
		<?php
else :
	echo 'No Results Found';
endif;
