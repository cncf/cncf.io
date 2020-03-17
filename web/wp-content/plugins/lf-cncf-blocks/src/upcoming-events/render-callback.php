<?php

/**
	 * Display Event Date
	 *
	 * @param date $event_date_start Date object.
	 * @param date $event_date_end Date object.
	 */

	function cncf_display_event_dates( $event_date_start, $event_date_end ) {
		if ( empty( $event_date_start ) ) {
			// No start date so return blank.
			return;
		}
		// If no end date, show start date in full.
		if ( ! $event_date_end ) {
			$date = esc_html( $event_date_start->format( 'F j, Y' ) );
		} else {
			// If start AND end month the same.
			if ( $event_date_start->format( 'F' ) === $event_date_end->format( 'F' ) ) {
				$date = esc_html( $event_date_start->format( 'F j' ) ) . '-' . esc_html( $event_date_end->format( 'j, Y' ) );
			} else {
				// Show both start and end month.
				$date = esc_html( $event_date_start->format( 'F j' ) ) . ' - ' . esc_html( $event_date_end->format( 'F j, Y' ) );
			}
		}
		return $date;
	}


	/**
	 * Render the block
	 *
	 * @param array $attributes Block attributes.
	 * @return object block_content Output.
	 */
	function lf_upcoming_events_render_callback( $attributes ) {
		// get the quantity to display, if not default.
		$quantity = isset( $attributes['numberposts'] ) ? intval( $attributes['numberposts'] ) : 4;
		// get the classes set from the block if any.
		$classes = isset( $attributes['className'] ) ? $attributes['className'] : '';
		// setup the arguments.
		$args  = [
			'posts_per_page'     => $quantity,
			'ignore_custom_sort' => true,
			'post_type'          => array( 'cncf_event' ),
			'post_status'        => array( 'publish' ),
			'ignore_custom_sort' => true,
			'post_type'          => array( 'cncf_event' ),
			'post_status'        => array( 'publish' ),
			'meta_key'           => 'cncf_event_date_start',
			'order'              => 'ASC',
			'orderby'            => 'meta_value',
			'meta_query'         => array(
				array(
					'key'     => 'cncf_event_date_start',
					'value'   => date_i18n( 'Y-m-d' ),
					'compare' => '>=',
				),
			),
		];
		$query = new WP_Query( $args );
		ob_start();
		// if no upcoming events.
		if ( ! $query->have_posts() ) {
			echo 'Sorry, there are no upcoming events.';
			return;
		}
		?>
<section
	class="wp-block-lf-upcoming-events <?php echo esc_html( $classes ); ?>">
	<div class="ue-wrapper">
		<?php
		while ( $query->have_posts() ) :
			$query->the_post();
			$event_date_start = new DateTime(
				get_post_meta( get_the_ID(), 'cncf_event_date_start', true ),
				new DateTimeZone( 'America/Los_Angeles' )
			);
			$event_date_end   = new DateTime(
				get_post_meta( get_the_ID(), 'cncf_event_date_end', true ),
				new DateTimeZone( 'America/Los_Angeles' )
			);
			$external_url     = get_post_meta( get_the_ID(), 'cncf_event_external_url', true );
			$event_hosts      = get_the_terms( get_the_ID(), 'cncf_event_hosts' );
			$event_city       = get_post_meta( get_the_ID(), 'cncf_event_city', true );
			?>
		<article class="ue-event-box background-image-wrapper">
			<?php
				// TODO: Pull in from Meta. Pull in real images.
			?>
			<div class="ue-overlay" style="background-color: #254AAB"></div>
			<figure class="background-image-figure">
				<img src="https://events.linuxfoundation.org/wp-content/uploads/44152343305_38fa81a9ed_3k.jpg"
					alt="<?php the_title(); ?>">
			</figure>
			<div class="ue-content-wrapper background-image-text-overlay">
				<div class="ue-logo">
					<a href="<?php the_permalink(); ?>"
						title="<?php the_title(); ?>"><img
							src="https://events.linuxfoundation.org/wp-content/uploads/kccnc-eu-2020-white.svg"
							alt="<?php the_title(); ?>"></a>
				</div>
				<span class="ue-event-date">
					<?php
						echo esc_html( cncf_display_event_dates( $event_date_start, $event_date_end ) );
					?>
				</span>
				<span class="ue-event-city"><?php echo esc_html( $event_city ); ?></span>
				<a href="<?php the_permalink(); ?> title="
					<?php the_title(); ?>"
					class="button transparent outline ue-button">Learn More</a>
			</div>
		</article>
			<?php
		endwhile;
		wp_reset_postdata();
		?>
	</div>
</section>
		<?php
		$block_content = ob_get_clean();
		return $block_content;
	}
