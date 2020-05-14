<?php
/**
 * Search & Filter Pro
 *
 * Speakers
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

if ( $query->have_posts() ) {
	global $post;

	$image = new Image();

	// get total list of speakers.
	$count_speakers = wp_count_posts( 'cncf_speaker' );
	$full_count     = $count_speakers->publish;

	// get currently filtered number of speakers.
	$filter_speakers_count = $query->found_posts;
	?>

<p class="results-count">
	<span>
		<?php
		// if filter has found all speakers.
		if ( $full_count == $query->found_posts ) {
			echo esc_html( 'Found ' . esc_html( $query->found_posts ) . ' speaker' . Cncf_Utils::plural( $filter_speakers_count ) );
		} else {
			// else show partial number of speakers.
			echo esc_html( 'Showing ' . esc_html( $query->found_posts ) . ' of ' . esc_html( $full_count ) . ' speakers' );
		}
		?>
	</span><span class="show-desktop-only">&nbsp;&#124;&nbsp;</span><br
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
		speaker<?php echo esc_html( Cncf_Utils::plural( $filter_speakers_count ) ); ?></a>
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

		$um_user = um_fetch_user( $user->ID );
		// makes the name capitalised.
		$display_name = ucwords( strtolower( um_user( 'display_name' ) ) );
		?>
	<div class="speaker box-shadow">
		<div class="speaker-photo">
			<a href="<?php echo esc_url( um_user_profile_url() ); ?>"
				title="<?php echo esc_attr( $display_name ); ?>">
				<?php echo get_avatar( um_user( 'ID' ), $default_size ); ?>
			</a>
		</div>
		<h5 class="speaker-title margin-reset margin-top-small"><a
				href="<?php echo esc_url( um_user_profile_url( $user->ID ) ); ?>"
				title="<?php echo esc_attr( $display_name ); ?>"><?php echo esc_html( $display_name ); ?></a>
		</h5>

		<?php if ( um_user( 'country' ) ) : ?>
		<span
			class="speaker-location unskew-box secondary margin-top centered"><?php echo esc_html( um_user( 'country' ) ); ?></span>
		<?php endif; ?>

		<div class="speaker-badges">
			<?php
			$travel_range = um_user( 'cncf_travel_range' );
			?>
			<?php if ( 'International' == $travel_range ) : ?>
			<div class="column">

			<span class="hint--top" aria-label="Willing to travel internationally">
				<?php $image->get_svg( 'speakers/international.svg' ); ?>
			</span>
			</div>
			<?php endif; ?>
			<?php
			$affiliations = um_user( 'sb_certifications' );
			if ( is_array( $affiliations ) ) {
				foreach ( $affiliations as $affiliation ) {
					if ( 'CKA' == $affiliation ) :
						?>
			<div class="column">

			<span class="hint--top" aria-label="CKA - Certified Kubernetes Administrator">
						<?php $image->get_svg( 'speakers/cka-logo.svg' ); ?>
			</span>

			</div>
						<?php
					endif;
					if ( 'CKAD' == $affiliation ) :
						?>
			<div class="column">

			<span class="hint--top" aria-label="CKAD - Certified Kubernetes Application Developer">
						<?php $image->get_svg( 'speakers/ckad-logo.svg' ); ?>
			</span>

			</div>
						<?php
					endif;
					if ( 'Ambassador' == $affiliation ) :
						?>
			<div class="column">

			<span class="hint--top" aria-label="CNCF Ambassador">
						<?php $image->get_svg( 'speakers/ambassador.svg' ); ?>
			</span>

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
