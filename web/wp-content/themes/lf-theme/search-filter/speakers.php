<?php
/**
 * Search & Filter Pro
 *
 * Speakers
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

if ( $query->have_posts() ) {
	global $post;

	// get total list of speakers.
	$count_speakers = wp_count_posts( 'lf_speaker' );
	$full_count     = $count_speakers->publish;

	// get currently filtered number of speakers.
	$filter_speakers_count = $query->found_posts;
	?>

<p class="results-count">
	<span>
		<?php
		// if filter has found all speakers.
		if ( $full_count == $query->found_posts ) {
			echo esc_html( 'Found ' . esc_html( $query->found_posts ) . ' speaker' . Lf_Utils::plural( $filter_speakers_count ) );
		} else {
			// else show partial number of speakers.
			echo esc_html( 'Showing ' . esc_html( $query->found_posts ) . ' of ' . esc_html( $full_count ) . ' speakers' );
		}
		?>
	</span><span class="show-tablet-only">&nbsp;&#124;&nbsp;</span><br
		class="show-mobile-only" />

	<?php
	// check if users account is allowed to send bulk emails.
	if ( ! is_sb_bulk_email_allowed_user() ) {
		?>
	<a href="/cncf-member-instructions/">Bulk message speakers</a>
		<?php
	} else {
		// if the number of speakers found is less than 50.
		if ( 50 >= $filter_speakers_count && isset( $_SERVER['QUERY_STRING'] ) ) {
			$bulk_message_href = get_bloginfo( 'url' ) . '/speakers/email-matching-speakers?' . preg_replace( '/(sfid=\d*&)/', '', sanitize_text_field( wp_unslash( $_SERVER['QUERY_STRING'] ) ) );
			?>
	<a href="<?php echo esc_url( $bulk_message_href ); ?>">Bulk message
			<?php echo esc_html( $filter_speakers_count ); ?>
		speaker<?php echo esc_html( Lf_Utils::plural( $filter_speakers_count ) ); ?></a>
	<?php } else { ?>
	<span class="is-disabled">Bulk messaging is limited to 50 speakers at a
		time.</span>
			<?php
	}
	}
	?>
</p>

<div class="speakers-wrapper">
	<?php
	while ( $query->have_posts() ) :
		$query->the_post();

		// check for user data.
		$user = get_userdata( $post->post_name );

		// if no user then return.
		if ( ! $user ) {
			continue;
		}

		get_template_part( 'components/speaker-item' );

		um_reset_user_clean();
	endwhile;
	?>
</div>
	<?php
	um_reset_user();
} else {
	echo 'No Results Found';
}
