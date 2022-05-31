<?php
/**
 * Search & Filter Pro
 *
 * Events
 *
 * @package    WordPress
 * @subpackage cncf-theme
 * @since      1.0.0
 */

if ( $query->have_posts() ) : ?>
<p class="search-filter-results-count">
	<?php
	$full_count = $wpdb->get_var( "select count(*) from wp_posts where wp_posts.post_type = 'lf_ktp' and wp_posts.post_status = 'publish';" );

	// if filter matches all.
	if ( $full_count == $query->found_posts ) {
		echo 'Found ' . esc_html( $query->found_posts ) . ' KTPs';
	} else {
		// else show partial count.
		echo 'Showing ' . esc_html( $query->found_posts ) . ' of ' . esc_html( $full_count ) . ' KTPs';
	}
	?>
</p>
<div style="height:40px" aria-hidden="true"
	class="wp-block-spacer is-style-30-40"></div>

<hr
	class="wp-block-separator has-text-color has-background has-gray-500-background-color has-gray-500-color is-style-horizontal-rule">

	<div style="height:50px" aria-hidden="true"
	class="wp-block-spacer is-style-30-50"></div>

<div class="ktp columns-two">
	<?php
	while ( $query->have_posts() ) :
		$query->the_post();

		$name         = trim( str_replace( '(KTP)', '', get_the_title() ) );
		$description  = get_post_meta( get_the_id(), 'lf_ktp_description', true );
		$external_url = get_post_meta( get_the_ID(), 'lf_ktp_external_url', true );
		$logo         = get_post_meta( get_the_ID(), 'lf_ktp_logo', true );
		$country      = Lf_Utils::get_term_names( get_the_ID(), 'lf-country', true );
		$country_slug = Lf_Utils::get_term_slugs( get_the_ID(), 'lf-country' );

		?>

	<div class="ktp-item has-animation-scale-2">

		<a href="<?php echo esc_url( $external_url ); ?>"
			title="<?php echo esc_attr( $name ); ?>"
			class="ktp-item__image-link">

			<img src="<?php echo esc_url( $logo ); ?>" loading="lazy"
				title="Visit <?php echo esc_html( $name ); ?>"
				class="ktp-item__image">
		</a>

		<a class="ktp-item__link" href="<?php echo esc_url( $external_url ); ?>"
			title="Visit <?php echo esc_attr( $name ); ?>">
			<?php echo esc_html( $name ); ?>
		</a>

		<a class="ktp-item__country is-style-spaced-uppercase has-text-color has-gray-700-color" title="Filter by Country"
			href="?_sft_lf-country=<?php echo esc_html( $country_slug ); ?>"><?php echo esc_html( $country ); ?></a>

		<p class="ktp-item__description"><?php echo esc_html( $description ); ?></p>

	</div>
	<?php endwhile; ?>
</div>
	<?php
else :
	echo 'No Results Found';
endif;
