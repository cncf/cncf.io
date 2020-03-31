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
	global $post;
	$full_count = $wpdb->get_var( "select count(*) from wp_posts where wp_posts.post_type = 'cncf_speaker' and wp_posts.post_status = 'publish';" );
	if ( $full_count == $query->found_posts ) {
		echo '<p class="results-count">Found ' . esc_html( $query->found_posts ) . ' speakers</p>';
	} else {
		echo '<p class="results-count">Showing ' . esc_html( $query->found_posts ) . ' of ' . esc_html( $full_count ) . ' speakers</p>';
	}

	if ( 50 < $query->found_posts ) {
		$email_disabled = true;
	} else {
		$email_disabled = false;
	}
	$user = wp_get_current_user();
	if ( ( in_array( 'um_member', (array) $user->roles ) || in_array( 'administrator', (array) $user->roles ) ) && isset( $_SERVER['QUERY_STRING'] ) ) {
		echo '<a';
		if ( ! $email_disabled ) {
			echo ' href="' . esc_url( get_bloginfo( 'url' ) ) . '/speakers/email-matching-speakers?' . esc_attr( preg_replace( '/(sfid=\d*&)/', '', sanitize_text_field( wp_unslash( $_SERVER['QUERY_STRING'] ) ) ) ) . '" ';
		}
		echo 'class="email-matching-button">Email Matching Speakers</a>';
	}

	while ( $query->have_posts() ) {
		$query->the_post();
		$user = get_userdata( $post->post_name );
		if ( ! $user ) {
			continue;
		}
		$um_user = um_fetch_user( $user->ID );

		?>
		<div class="speaker">
			<h3><a href="<?php echo esc_url( um_user_profile_url( $user->ID ) ); ?>"><?php echo esc_html( um_user( 'display_name' ) ); ?></a></h3>

			<?php
			$corner = UM()->options()->get( 'profile_photocorner' );
			$default_size = UM()->options()->get( 'profile_photosize' );
			$default_size = str_replace( 'px', '', $default_size );
			?>
			<div class="um-member-photo radius-<?php echo esc_attr( $corner ); ?>">
			<a href="<?php echo esc_url( um_user_profile_url() ); ?>" title="<?php echo esc_attr( um_user( 'display_name' ) ); ?>">
			<?php echo get_avatar( um_user( 'ID' ), $default_size ); ?>
			</a>
			</div>
			<span class="um-member-meta-location"><?php echo esc_html( um_user( 'country' ) ); ?></span>

			<div class="um-member-badges">
				<?php
				// This section needs markup and styling.
				if ( um_user( 'cncf_travel_range' ) ) {
					var_dump( um_user( 'cncf_travel_range' ) );
				}
				if ( um_user( 'sb_certifications' ) ) {
					var_dump( um_user( 'sb_certifications' ) );
				}
				?>
			</div>
		</div>
		<?php
		um_reset_user_clean();
	}

	um_reset_user();
} else {
	echo 'No Results Found';
}
