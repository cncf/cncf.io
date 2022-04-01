<?php
/**
 * Megamenu Helpers
 *
 * Helper functions for populating the megamenu
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

/**
 * Get featured reads for the About menu.
 */
function get_menu_featured_reads() {
	$args = array(
		'post_type' => 'lf_report',
		'post_status' => array( 'publish' ),
		'posts_per_page' => 1,
		'orderby' => 'date',
		'order'   => 'DESC',
		'tax_query' => array(
			array(
				'taxonomy' => 'lf-report-type',
				'field'    => 'slug',
				'terms'    => 'annual',
			),
		),
	);
	$query = new WP_Query( $args );
	if ( $query->have_posts() ) {
		$query->the_post();
		echo '<a href="' . esc_url( get_the_permalink() ) . '">';
		the_title();
		echo '</a>';
		echo '<br>';
	}

	$args = array(
		'post_type' => 'lf_report',
		'post_status' => array( 'publish' ),
		'posts_per_page' => 1,
		'orderby' => 'date',
		'order'   => 'DESC',
		'tax_query' => array(
			array(
				'taxonomy' => 'lf-report-type',
				'field'    => 'slug',
				'terms'    => 'survey',
			),
		),
	);
	$query = new WP_Query( $args );
	if ( $query->have_posts() ) {
		$query->the_post();
		echo '<a href="' . esc_url( get_the_permalink() ) . '">';
		the_title();
		echo '</a>';
		echo '<br>';
	}
	wp_reset_postdata();

	// Kubecon ad.
	?>
	<img src="https://via.placeholder.com/340x120/d9d9d9/000000" alt=""><br>
	<?php
}

/**
 * Get latest tech radars.
 */
function get_menu_tech_radars() {
	$t_radars = get_transient( 'megamenu_tech_radars' );
	if ( false === $t_radars ) {

		$request = wp_remote_get( 'https://radar.cncf.io/radars.json' );
		if ( is_wp_error( $request ) || ( wp_remote_retrieve_response_code( $request ) != 200 ) ) {
			return;
		}
		$t_radars = wp_remote_retrieve_body( $request );

		set_transient( 'megamenu_tech_radars', $t_radars, 12 * HOUR_IN_SECONDS );
	}
	$t_radars = json_decode( $t_radars );

	?>
	<?php
	for ( $i = 0; $i < 3; $i++ ) {
		$item_url = 'https://radar.cncf.io/' . $t_radars[ $i ]->key;
		$title    = $t_radars[ $i ]->name;
		$date     = $t_radars[ $i ]->date;
		?>
		<div>

			<a href="<?php echo esc_url( $item_url ); ?>"
				title="<?php echo esc_attr( $title ); ?>"></a>
			<img loading="lazy" src="<?php echo esc_url( $t_radars[ $i ]->image ); ?>" alt="<?php echo esc_attr( $title ); ?>">

			<p><a href="<?php echo esc_url( $item_url ); ?>"
				title="<?php echo esc_attr( $title ); ?>">
				<?php echo esc_html( $title ); ?></a>
			</p>
			<span><?php echo esc_html( $date ); ?>
			</span>
		</div>
		<?php
	}
}

/**
 * Get latest blog posts.
 */
function get_menu_blog_posts() {
	$args = array(
		'post_type' => 'post',
		'post_status' => array( 'publish' ),
		'posts_per_page' => 3,
		'orderby' => 'date',
		'order'   => 'DESC',
		'category_name' => 'blog,announcements',
	);
	$query = new WP_Query( $args );
	while ( $query->have_posts() ) {
		$query->the_post();
		echo '<a href="' . esc_url( get_the_permalink() ) . '">';
		the_title();
		echo '</a>';
		echo '<br>';
	}
	wp_reset_postdata();
}
