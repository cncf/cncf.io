<?php
/**
 * Search & Filter Pro
 *
 * Events
 *
 * @package     WordPress
 * @subpackage  cncf-theme
 * @since       1.0.0
 */

if ( $query->have_posts() ) : ?>
<p class="search-filter-results-count">
	<?php
	$full_count = $wpdb->get_var( "select count(*) from wp_posts join wp_postmeta on wp_posts.ID = wp_postmeta.post_id where wp_posts.post_type = 'lf_event' and wp_posts.post_status = 'publish' and meta_key='lf_event_date_end' and meta_value >= CURDATE();" );

	// if filter matches all.
	if ( $full_count == $query->found_posts ) {
		echo 'Found ' . esc_html( $query->found_posts ) . ' upcoming events';
	} else {
		// else show partial count.
		echo 'Showing ' . esc_html( $query->found_posts ) . ' of ' . esc_html( $full_count ) . ' upcoming events';
	}
	?>
</p>
<div style="height:50px" aria-hidden="true"
	class="wp-block-spacer is-style-30-50"></div>

<hr
	class="wp-block-separator has-text-color has-background has-gray-500-background-color has-gray-500-color is-style-horizontal-rule">

<div style="height:50px" aria-hidden="true"
	class="wp-block-spacer is-style-30-50"></div>

<div class="events columns-three">
	<?php
	while ( $query->have_posts() ) :
		$query->the_post();

		$external_url     = get_post_meta( get_the_ID(), 'lf_event_external_url', true );
		$event_start_date = get_post_meta( get_the_ID(), 'lf_event_date_start', true );
		$event_end_date   = get_post_meta( get_the_ID(), 'lf_event_date_end', true );
		$city             = get_post_meta( get_the_ID(), 'lf_event_city', true );
		$country          = Lf_Utils::get_term_names( get_the_ID(), 'lf-country', true );

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
	<div class="event-item">

		<div class="event-item__overlay"
			style="background-color: <?php echo esc_html( $overlay_color ); ?> ">
		</div>

		<?php if ( $background ) : ?>
		<figure class="event-item__bg-figure">
			<?php
			LF_Utils::display_responsive_images( $background, 'event-415', '415px', 'event-item__bg-image' );

			?>
		</figure>
		<?php endif; ?>

		<div class="event-item__content">

			<div>
				<?php if ( $logo ) : ?>
				<a href="<?php echo esc_url( $external_url ); ?>"
					title="<?php the_title(); ?>">
					<?php
					LF_Utils::display_responsive_images( $logo, 'medium', '300px', 'event-item__logo' );
					?>
				</a>
				<?php else : ?>
				<h3 class="event-item__title"><a
						href="<?php echo esc_url( $external_url ); ?>"
						title="<?php the_title(); ?>"><?php the_title(); ?></a>
				</h3>
				<?php endif; ?>

				<h4><span class="event-item__date">
					<?php
					echo esc_html( Lf_Utils::display_event_date( $event_start_date, $event_end_date ) );
					?>
				</span>
				<span
				class="event-item__city"><?php echo esc_html( $location ); ?></span>
			</h4>
		</div>

		</div>
	</div>
	<?php endwhile; ?>
</div>
	<?php
else :
	echo 'No Results Found';
endif;
