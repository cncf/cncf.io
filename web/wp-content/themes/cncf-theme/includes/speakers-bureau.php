<?php
/**
 * Speakers Bureau Code
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

/**
 * Callback for projects dropdown on the Speakers Bureau edit form.
 */
function um_projects_callback() {
	$terms = get_terms(
		array(
			'taxonomy' => 'cncf-project',
			'orderby' => 'name',
			'order' => 'ASC',
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
add_action( 'gform_pre_submission_2', 'pre_submission_handler' );
