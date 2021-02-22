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
		$full_count = $wpdb->get_var( "select count(*) from wp_posts join wp_postmeta on wp_posts.ID = wp_postmeta.post_id where wp_posts.post_type = 'lf_event' and wp_posts.post_status = 'publish' and meta_key='lf_event_date_end' and meta_value >= CURDATE();" );
		if ( $full_count == $query->found_posts ) {
			echo 'Found ' . esc_html( $query->found_posts ) . ' upcoming events';
		} else {
			echo 'Showing ' . esc_html( $query->found_posts ) . ' of ' . esc_html( $full_count ) . ' upcoming events';
		}
		?>
</p>
<div class="events-wrapper">
		<?php
		while ( $query->have_posts() ) :
			$query->the_post();

			$event_start_date = get_post_meta( get_the_ID(), 'lf_event_date_start', true );

			$event_end_date = get_post_meta( get_the_ID(), 'lf_event_date_end', true );

			$city = get_post_meta( get_the_ID(), 'lf_event_city', true );

			$country = Lf_Utils::get_term_names( get_the_ID(), 'lf-country', true );

			if ( ! $city && ! $country ) {
				$location = 'TBC';
			} elseif ( ! $country ) {
				$location = $city;
			} elseif ( ! $city ) {
				$location = $country;
			} else {
				$location = $city . ', ' . $country;
			}

			$logo = get_post_meta( get_the_ID(), 'lf_event_logo', true );

			$background = get_post_meta( get_the_ID(), 'lf_event_background', true );

			$color = get_post_meta( get_the_ID(), 'lf_event_overlay_color', true );

			$color ? $overlay_color = $color : $overlay_color = 'transparent';

			?>
	<article class="event-box background-image-wrapper">

		<div class="event-overlay"
			style="background-color: <?php echo esc_html( $overlay_color ); ?> ">
		</div>

			<?php if ( $background ) : ?>
		<figure class="background-image-figure">
				<?php
				LF_Utils::display_responsive_images( $background, 'event-415', '415px' );

				?>
		</figure>
		<?php endif; ?>

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

			<h6 class="event-date">
				<?php
						echo esc_html( Lf_Utils::display_event_date( $event_start_date, $event_end_date ) );
				?>
			</h6>
			<h5
				class="event-city"><?php echo esc_html( $location ); ?></h5>
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
