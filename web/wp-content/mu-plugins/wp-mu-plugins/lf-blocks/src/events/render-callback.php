<?php
/**
 * Render Callback
 *
 * @package WordPress
 * @subpackage lf-blocks
 * @since 1.0.0
 */

/**
 * Render the block
 *
 * @param array $attributes Block attributes.
 * @return object block_content Output.
 */
function lf_events_render_callback( $attributes ) {
	// get the quantity to display, if not default.
	$quantity = isset( $attributes['numberposts'] ) ? intval( $attributes['numberposts'] ) : 4;

	// get the classes set from the block if any.
	$classes = isset( $attributes['className'] ) ? $attributes['className'] : '';

	// get the category to display.
	$category_id = isset( $attributes['category'] ) ? $attributes['category'] : '';

	if ( $category_id ) {
		$category_selected = get_term_by( 'id', $category_id, 'lf-event-host' );
	} else {
		$category_selected = '';
	}

	// setup the arguments.
	$args = array(
		'posts_per_page'     => $quantity,
		'post_type'          => array( 'lf_event' ),
		'post_status'        => array( 'publish' ),
		'meta_key'           => 'lf_event_date_start',
		'order'              => 'ASC',
		'meta_type'          => 'DATETIME',
		'orderby'            => 'meta_value',
		'no_found_rows'      => true,
		'meta_query'         => array(
			array(
				'key'     => 'lf_event_date_end',
				'value'   => date_i18n( 'Y-m-d' ),
				'compare' => '>=',
				'type' => 'DATETIME',
			),
		),
	);

	// if the host has been set, add the tax.
	if ( $category_selected && isset( $category_selected ) ) {

		$args['tax_query'] = array(
			array(
				'taxonomy' => 'lf-event-host',
				'field'    => 'slug',
				'terms'    => $category_selected,
			),
		);
	}

	$query = new WP_Query( $args );

	// if no posts.
	if ( ! $query->have_posts() ) {
		return 'Sorry, there are no posts.';
	}

	ob_start();
	?>
<section
	class="wp-block-lf-events <?php echo esc_html( $classes ); ?>">
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

	<article class="event-box background-image-wrapper box-shadow">

		<div class="event-overlay"
			style="background-color: <?php echo esc_html( $overlay_color ); ?> ">
		</div>

		<?php if ( $background ) : ?>
		<figure class="background-image-figure">
			<?php
			LF_Utils::display_responsive_images( $background, 'event-270', '250px' );
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
						title="<?php the_title(); ?>"><?php the_title(); ?></a>
				</h4>
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
