<?php
/**
 * Books Shortcode
 *
 * Usage example:
 * [books type="workshop"]
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

/**
 * Add Books shortcode.
 *
 * @param array $atts Attributes.
 */
function add_books_shortcode( $atts ) {

	// Attributes.
	$atts = shortcode_atts(
		array(
			'type'   => '',
		),
		$atts,
		'books'
	);

	$chosen_type = $atts['type'];

	$query_args = array(
		'post_type'      => 'lf_book',
		'post_status'    => array( 'publish' ),
		'posts_per_page' => 200,
		'orderby'        => 'date',
		'order'          => 'DESC',
	);

	if ( $chosen_type ) {
		$query_args['tax_query'] = array(
			array(
				'taxonomy' => 'lf-book-type',
				'field'    => 'slug',
				'terms'    => $chosen_type,
			),
		);
	}

	$book_query = new WP_Query( $query_args );

	ob_start();
	if ( $book_query->have_posts() ) {
		?>

	<div class="books-section columns-two">
		<?php
		while ( $book_query->have_posts() ) :
			$book_query->the_post();
			$book_type      = ucwords( Lf_Utils::get_term_names( get_the_ID(), 'lf-book-type', true ) );
			$book_type_slug = Lf_Utils::get_term_slugs( get_the_ID(), 'lf-book-type', true );
			$book_url       = get_post_meta( get_the_ID(), 'lf_book_url', true );
			?>
			<div class="book-item has-animation-scale-2">
			<?php if ( $book_url ) : ?>
				<a class="book-item__link" href="<?php the_permalink(); ?>"
					title="<?php echo esc_attr( the_title_attribute() ); ?>">
			<?php endif; ?>
					<?php
					if ( has_post_thumbnail() ) {
						Lf_Utils::display_responsive_images( get_post_thumbnail_id(), 'newsroom-388', '400px', 'book-item__image', 'lazy', get_the_title() );
					} else {
						$site_options = get_option( 'lf-mu' );
						Lf_Utils::display_responsive_images( $site_options['generic_thumb_id'], 'newsroom-388', '400px', 'book-item__image', 'lazy', get_the_title() );
					}
					?>
			<?php if ( $book_url ) : ?>
				</a>
			<?php endif; ?>

				<div class="book-item__text-wrapper">
					<h3 class="book-item__title">
					<?php if ( $book_url ) : ?>
						<a class="book-item__link" href="<?php the_permalink(); ?>"
							title="<?php echo esc_attr( the_title_attribute() ); ?>">
					<?php endif; ?>
							<?php the_title(); ?>
					<?php if ( $book_url ) : ?>
						</a>
					<?php endif; ?>
					</h3>

					<?php the_content(); ?>
				</div>
			</div>
			<?php
		endwhile;
		wp_reset_postdata();
	}
	?>
</div>
	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'books', 'add_books_shortcode' );
