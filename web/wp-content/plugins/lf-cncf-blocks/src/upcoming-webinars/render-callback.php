<?php

	/**
	 * Display webinar time
	 *
	 * @param object $date Date object.
	 * @param object $time Time.
	 */
	function fuerza_display_webinar_time( $date, $time ) {
		// TODO: Come back to fix this function and the way time displays.
		if ( empty( $time ) || ! ( $date instanceof DateTime ) ) {
			return;
		}

		$suffix      = trim( substr( $time, -3 ) );
		$time        = $time . ' (UTC';
		$is_daylight = $date->format( 'I' ) == 1;
		$hours       = ! $is_daylight ? '8' : '7';
		$hours       = 'PDT' == $suffix ? 7 : $hours;
		$signal      = 'CST' == $suffix ? '+' : '-';
		$time       .= "{$signal}{$hours})";

		return $time;
	}


/**
	 * Render the block
	 *
	 * @param array $attributes Block attributes.
	 * @return object block_content Output.
	 */
	function lf_upcoming_webinars_render_callback( $attributes ) {

		// get the quantity to display, if not default.
		$quantity = isset( $attributes['numberposts'] ) ? intval( $attributes['numberposts'] ) : 4;

		// get the classes set from the block if any.
		$classes = isset( $attributes['className'] ) ? $attributes['className'] : '';

		// setup the arguments.
		$args  = [
			'posts_per_page'     => $quantity,
			'ignore_custom_sort' => true,
			'post_type'          => array( 'cncf_webinar' ),
			'post_status'        => array( 'publish' ),
			'meta_key'           => 'cncf_webinar_date',
			'order'              => 'ASC',
			'orderby'            => 'meta_value',
			'meta_query'         => array(
				array(
					'key'     => 'cncf_webinar_date',
					'value'   => date_i18n( 'Y-m-d' ),
					'compare' => '>=',
				),
				array(
					'key'     => 'cncf_webinar_recording',
					'value'   => '',
					'compare' => 'NOT EXISTS',
				),
			),
		];
		$query = new WP_Query( $args );
		ob_start();

		// if no upcoming webinars.
		if ( ! $query->have_posts() ) {
			echo 'Sorry, there are no upcoming webinars.';
			return;
		}
		?>

<section
	class="wp-block-lf-upcoming-webinars <?php echo esc_html( $classes ); ?>">
	<div class="uw-wrapper">
		<?php
		while ( $query->have_posts() ) :
			$query->the_post();
			$recording    = get_post_meta( get_the_ID(), 'cncf_webinar_recording', true );
			$registration = get_post_meta( get_the_ID(), 'cncf_webinar_registration', true );
			$time         = get_post_meta( get_the_ID(), 'cncf_webinar_time', true );
			$terms        = get_the_terms( get_the_ID(), 'cncf-webinar-category' );
			$dt_date      = new DateTime(
				get_post_meta( get_the_ID(), 'cncf_webinar_date', true ),
				new DateTimeZone( 'America/Los_Angeles' )
			);
			?>
		<article class="uw-box">
			<a href="<?php the_permalink(); ?>" class="box-link"
				title="<?php the_title(); ?> on <?php echo esc_html( $dt_date->format( 'D j F Y' ) ); ?>"></a>
			<div class="uw-title-wrapper">
				<div class="uw-date-category-wrapper">
					<span
						class="uw-date skew-box"><?php echo esc_html( $dt_date->format( 'D j F Y' ) ); ?></span>
					<?php if ( ! empty( $terms ) ) : ?>
					<span class="uw-category skew-box">
						CNCF <?php echo esc_html( $terms[0]->name ); ?> Webinar
					</span>
					<?php endif; ?>
				</div>
				<h4 class="uw-title"><a href="<?php the_permalink(); ?>"
						title="<?php esc_html( the_title() ); ?> on <?php echo esc_html( $dt_date->format( 'D j F Y' ) ); ?>"><?php esc_html( the_title() ); ?></a>
				</h4>

				<?php if ( ! empty( $dt_date ) & ! empty( $time ) ) : ?>

				<span class="uw-time">Join live from
					<?php echo esc_html( fuerza_display_webinar_time( $dt_date, $time ) ); ?></span>
				<?php endif; ?>
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
