<?php
/**
 * Search & Filter Pro
 *
 * Sample Results Template
 *
 * @package   Search_Filter
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 *
 * Note: these templates are not full page templates, rather
 * just an encaspulation of the your results loop which should
 * be inserted in to other pages by using a shortcode - think
 * of it as a template part
 *
 * This template is an absolute base example showing you what
 * you can do, for more customisation see the WordPress docs
 * and using template tags -
 *
 * http://codex.wordpress.org/Template_Tags
 */

if ( $query->have_posts() ) {
	?>

	Found <?php echo esc_html( $query->found_posts ); ?> Events<br />
	<?php
	while ( $query->have_posts() ) {
		$query->the_post();
		$start_date = new DateTime( get_post_meta( $post->ID, 'cncf_event_date_start', true ) );
		$end_date = new DateTime( get_post_meta( $post->ID, 'cncf_event_date_end', true ) );
		$external_url = get_post_meta( $post->ID, 'cncf_event_external_url', true );

		$city = get_post_meta( $post->ID, 'cncf_event_city', true );
		$country = get_the_terms( $post->ID, 'cncf-country' );
		$country = join( ', ', wp_list_pluck( $country, 'name' ) );
		if ( $country ) {
			$location = $city . ', ' . $country;
		} else {
			$location = $city;
		}

		?>
		<div class="result-item">
			<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<div><?php echo esc_html( $start_date->format( 'F j, Y' ) ) . ' to ' . esc_html( $end_date->format( 'F j, Y' ) ); ?></div>
			<div><?php echo esc_html( $location ); ?></div>
			<div><?php echo esc_html( $external_url ); ?></div>
			<p><br /><?php the_excerpt(); ?></p>
		</div>
		<hr />
		<?php
	}
} else {
	echo 'No Results Found';
}
