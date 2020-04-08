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
 */

if ( $query->have_posts() ) {
	global $post;

	// get total list of speakers.
	$count_speakers = wp_count_posts( 'cncf_speaker' == $post_type );
	$full_count     = $count_speakers->publish;

	// if filter has found all speakers.
	if ( $full_count == $query->found_posts ) {
		echo '<p class="results-count">Found ' . esc_html( $query->found_posts ) . ' speakers </p>';
	} else {
		// else show partial number of speakers.
		echo '<p class="results-count">Showing ' . esc_html( $query->found_posts ) . ' of ' . esc_html( $full_count ) . ' speakers </p>';
	}

	echo ' | <a style="display:inline-block; padding-left: 2px;"';
	$bulk_message_href = '';
	if ( is_sb_bulk_email_allowed_user() ) {
		if ( 50 >= $query->found_posts && isset( $_SERVER['QUERY_STRING'] ) ) {
			$bulk_message_href = get_bloginfo( 'url' ) . '/speakers/email-matching-speakers?' . preg_replace( '/(sfid=\d*&)/', '', sanitize_text_field( wp_unslash( $_SERVER['QUERY_STRING'] ) ) );
			echo ' href="' . esc_attr( $bulk_message_href ) . '"';
		}
	} else {
		$bulk_message_href = '/cncf-member-instructions/';
		echo ' href="' . esc_attr( $bulk_message_href ) . '"';
	}

	echo ' class="email-matching-button';
	if ( ! $bulk_message_href ) {
		echo ' disabled';
		// TODO: add hover text here: "Use the filters to reduce the number of matching speakers. Bulk messaging is limited to 50 speakers at a time.".
	}
	echo '">Bulk Message Speakers</a>';

	?>
<div class="speakers-wrapper">
	<?php

	// setup options from UM.
	// Not sure where this comes from, not used? TODO.
	$corner = UM()->options()->get( 'profile_photocorner' );

	// get default picture size from UM.
	$default_size = UM()->options()->get( 'profile_photosize' );
	$default_size = str_replace( 'px', '', $default_size );

	while ( $query->have_posts() ) :
		$query->the_post();

		// check for user data.
		$user = get_userdata( $post->post_name );

		// if no user then return.
		if ( ! $user ) {
			continue;
		}

		// what use is this? TODO.
		$um_user = um_fetch_user( $user->ID );

		// makes the name capitalised.
		$display_name = ucwords( strtolower( um_user( 'display_name' ) ) );
		?>
<div class="speaker">
<div class="speaker-photo">
<a href="<?php echo esc_url( um_user_profile_url() ); ?>"
title="<?php echo esc_attr( $display_name ); ?>">
		<?php echo get_avatar( um_user( 'ID' ), $default_size ); ?>
</a>
</div>
<h4 class="speaker-title margin-reset margin-top"><a
href="<?php echo esc_url( um_user_profile_url( $user->ID ) ); ?>"
title="<?php echo esc_attr( $display_name ); ?>"><?php echo esc_html( $display_name ); ?></a>
</h4>

<span
class="speaker-location margin-top"><?php echo esc_html( um_user( 'country' ) ); ?></span>

<div class="speaker-badges">
		<?php
		$travel_range = um_user( 'cncf_travel_range' );
		?>

		<?php if ( 'International' == $travel_range ) : ?>
<div class="row">
<img src="https://via.placeholder.com/30x30/BAEE55/000000"
alt="">
<!-- <span>Will Travel</span> -->
</div>
<?php endif; ?>
		<?php
		$certifications = um_user( 'sb_certifications' );
		if ( is_array( $certifications ) ) {
			foreach ( $certifications as $certification ) {
				if ( 'CKA' == $certification ) :
					?>
<div class="row">
<img src="https://via.placeholder.com/30x30/EEDA55/000000"
alt="">
<!-- <span>CKA</span> -->
</div>
					<?php
				endif;
				if ( 'CKAD' == $certification ) :
					?>
<div class="row">
<img src="https://via.placeholder.com/30x30/BADA00/000000"
alt="">
<!-- <span>CKAD</span> -->
</div>
					<?php
				endif;
				if ( 'Ambassador' == $certification ) :
					?>
<div class="row">
<img src="https://via.placeholder.com/30x30/BDDA55/000000"
alt="">
<!-- <span>Ambassador</span> -->
</div>
					<?php
				endif;
			}
		}
		?>
</div>
</div>
		<?php
		um_reset_user_clean();
endwhile;
	?>
</div>
	<?php
	um_reset_user();
} else {
	echo 'No Results Found';
}
