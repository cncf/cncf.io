<?php
/**
 * Speakers Bureau changes
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

/**
 * Callback for projects dropdown on the Speakers Bureau edit form.
 */
function um_projects_callback() {
	$terms = get_terms(
		array(
			'taxonomy'   => 'lf-project',
			'orderby'    => 'name',
			'order'      => 'ASC',
			'hide_empty' => false,
		)
	);

	$list = array();

	foreach ( $terms as $term ) {
		$list[ $term->name ] = $term->name;
	}

	return $list;

}

/**
 * Populates the user id field in the Speaker contact form.
 *
 * @param int $value Value.
 */
function ultimate_member_user_id( $value ) {
	return um_profile_id();
}
add_filter( 'gform_field_value_um_u_id', 'ultimate_member_user_id' );

/**
 * Gets the speakers email for the Speaker contact form.
 *
 * @param object $form Form.
 */
function pre_submission_handler( $form ) {
	if ( isset( $_POST['input_12'] ) ) { //phpcs:ignore
		$user_info = get_userdata( filter_var( wp_unslash( $_POST['input_12'] ), FILTER_VALIDATE_INT ) ); //phpcs:ignore
		$_POST['input_13'] = $user_info->user_email;
	}
}
add_action( 'gform_pre_submission_1', 'pre_submission_handler' );


/**
 * Is user allowed to send bulk emails in Speakers Bureau.
 */
function is_sb_bulk_email_allowed_user() {
	if ( ! is_user_logged_in() ) {
		return false;
	}

	$allowed_roles = array( 'administrator', 'um_member' );
	$user          = wp_get_current_user();
	$is_allowed    = false;

	foreach ( $user->roles as $role ) {
		if ( in_array( $role, $allowed_roles ) ) {
			$is_allowed = true;
		}
	}

	return $is_allowed;
}

/**
 * Is user a speaker.
 */
function is_sb_speaker() {
	if ( ! is_user_logged_in() ) {
		return false;
	}

	$user       = wp_get_current_user();
	$is_speaker = false;

	foreach ( $user->roles as $role ) {
		if ( 'um_speaker' === $role ) {
			$is_speaker = true;
		}
	}

	return $is_speaker;
}

/**
 * SB subnav buttons shortcode.
 */
function shortcode_sb_subnav() {
	ob_start(); ?>

<div class="speakers-subnav">
	<?php
	if ( ! is_user_logged_in() ) {
		?>
	<a href="/speakers/register/">Sign Up as a Speaker</a>&nbsp;|&nbsp;
	<a href="/lf-member-instructions/">Learn more about Bulk Speaker
		Messaging</a>&nbsp;|&nbsp;
	<a href="/speakers/login/">Login</a>
		<?php
	} elseif ( is_sb_speaker() ) {
		?>
	<a href="/speaker/">My Profile</a>&nbsp;|&nbsp;
	<a href="/account/">My Account</a>&nbsp;|&nbsp;
	<a href="/logout/">Logout</a>
		<?php
	} else {
		?>
	<a href="/lf-member-instructions/">Learn more about Bulk Speaker
		Messaging</a>&nbsp;|&nbsp;
	<a href="/logout/">Logout</a>
		<?php
	}
	?>
</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'speakers_bureau_subnav', 'shortcode_sb_subnav' );

/**
 * Adds CNCF affiliation in to SB Profile FE.
 */
function add_lf_fields_after_header_name() {

	// Only show in Viewing.
	if ( UM()->fields()->viewing == false ) {
		return;
	}

	$affiliations = um_user( 'sb_certifications' );
	$image        = new Image();

	if ( is_array( $affiliations ) ) {
		?>
<div class="affiliations-box">
	<label>CNCF Affiliations</label>
	<div class="affiliations-box-badges">
		<?php
		foreach ( $affiliations as $affiliation ) {
			if ( 'CKA' === $affiliation ) :
				?>
		<div class="column">
			<span class="hint--top"
				aria-label="CKA - Certified Kubernetes Administrator">
				<?php $image->get_svg( 'speakers/cka-logo.svg' ); ?>
			</span>
		</div>
				<?php
		endif;
			if ( 'CKAD' === $affiliation ) :
				?>
		<div class="column">
			<span class="hint--top"
				aria-label="CKAD - Certified Kubernetes Application Developer">
				<?php $image->get_svg( 'speakers/ckad-logo.svg' ); ?>
			</span>
		</div>
				<?php
		endif;
			if ( 'Ambassador' === $affiliation ) :
				?>
		<div class="column">
			<span class="hint--top" aria-label="CNCF Ambassador">
				<?php $image->get_svg( 'speakers/ambassador.svg' ); ?>
			</span>
		</div>
				<?php
		endif;
		}
		?>
	</div>
</div>
		<?php
	}
}
add_action( 'um_after_header_meta', 'add_lf_fields_after_header_name' );
