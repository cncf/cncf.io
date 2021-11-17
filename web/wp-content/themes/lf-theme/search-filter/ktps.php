<?php
/**
 * Search & Filter Pro
 *
 * Events
 *
 * @package    WordPress
 * @subpackage LF-theme
 * @since      1.0.0
 */

if ( $query->have_posts() ) :
	?>
<p class="results-count">
	<?php
	$full_count = $wpdb->get_var( "select count(*) from wp_posts where wp_posts.post_type = 'lf_ktp' and wp_posts.post_status = 'publish';" );
	if ( $full_count == $query->found_posts ) {
		echo 'Found ' . esc_html( $query->found_posts ) . ' KTPs';
	} else {
		echo 'Showing ' . esc_html( $query->found_posts ) . ' of ' . esc_html( $full_count ) . ' KTPs';
	}
	?>
</p>
<div class="ktp-results single-column-spaced-items">
	<?php
	while ( $query->have_posts() ) :
		$query->the_post();
		$target_attr       = 'rel="noopener" target="_blank"';
		$add_external_icon = ' external is-primary-color';
		$description       = get_post_meta( get_the_id(), 'lf_ktp_description', true );
		$external_url      = get_post_meta( get_the_ID(), 'lf_ktp_external_url', true );
		$logo              = get_post_meta( get_the_ID(), 'lf_ktp_logo', true );
		$image             = new Image();
		$country           = Lf_Utils::get_term_names( get_the_ID(), 'lf-country', true );
		$slug              = Lf_Utils::get_term_slugs( get_the_ID(), 'lf-country' );
		$small_title       = str_replace( '(KTP)', '', get_the_title() );
		?>

	<div class="archive-item in-news-item">

		<div class="archive-image-wrapper">
			<a href="<?php echo esc_url( $external_url ); ?>"
				<?php echo $target_attr; //phpcs:ignore ?>
				title="<?php echo esc_attr( $small_title ); ?>">
				<img src="<?php echo esc_url( $logo ); ?>" loading="lazy"
					title="<?php echo esc_html( $small_title ); ?>"
					class="media-logo">
			</a>
		</div>

		<div class="archive-text-wrapper">
			<h4 class="archive-title">
				<a class="<?php echo esc_html( $add_external_icon ); ?>"
					href="<?php echo esc_url( $external_url ); ?>"
					<?php echo $target_attr;  //phpcs:ignore ?>
					title="<?php echo esc_attr( $small_title ); ?>">
					<?php echo esc_html( $small_title ); ?>
				</a>
			</h4>

			<a class="skew-box secondary centered margin-bottom-small"
				title="Filter by Country"
				href="?_sft_lf-country=<?php echo esc_html( $slug ); ?>"><?php echo esc_html( $country ); ?></a>

			<p class="archive-excerpt">
		<?php echo esc_html( $description ); ?>
			</p>

		</div>
	</div>
	<?php endwhile; ?>
</div>
	<?php
else :
	echo 'No Results Found';
endif;
