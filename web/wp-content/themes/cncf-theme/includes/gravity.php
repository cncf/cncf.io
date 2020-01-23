<?php
/**
 * Gravity Forms Options
 *
 * Settings that affect Gravity Forms plugins
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

/**
 * Disable Gravity Forms CSS
 */
add_filter( 'pre_option_rg_gforms_disable_css', '__return_true' );

/**
 *  Gravity Forms Load JQuery in Footer
 */
function gf_init_scripts() {
	return true;
}
add_filter( 'gform_init_scripts_footer', 'gf_init_scripts' );

/**
 *  Gravity Forms inline JS to footer - open
 *
 * @param string $content returns the cdata.
 */
function wrap_gform_cdata_open( $content = '' ) {
	$content = 'document.addEventListener( "DOMContentLoaded", function() { ';
	return $content;
}
add_filter( 'gform_cdata_open', 'wrap_gform_cdata_open' );

/**
 *  Gravity Forms inline JS to footer - close
 *
 * @param string $content returns the end of cdata.
 */
function wrap_gform_cdata_close( $content = '' ) {
	$content = ' }, false );';
	return $content;
}
add_filter( 'gform_cdata_close', 'wrap_gform_cdata_close' );

/**
 *  Add Gravity Forms to Capabilities
 */
function add_gf_cap() {
	 $role = get_role( 'editor' );
	$role->add_cap( 'gform_full_access' );
}

add_action( 'admin_init', 'add_gf_cap' );

/**
 *   Make submit button a button not input
 *
 * @param int $button_input Button input ID.
 * @param int $form Form ID.
 */
function gf_make_submit_input_into_a_button_element( $button_input, $form ) {

	// save attribute string to $button_match[1].
	preg_match( '/<input([^\/>]*)(\s\/)*>/', $button_input, $button_match );

	// remove value attribute.
	$button_atts = str_replace( "value='" . $form['button']['text'] . "' ", '', $button_match[1] );

	return '<button ' . $button_atts . '>' . $form['button']['text'] . '<i class="fa fa-refresh"></i></button>';
}
add_filter( 'gform_submit_button', 'gf_make_submit_input_into_a_button_element', 10, 2 );
// otherwise see https://gist.github.com/Bobz-zg/f4aa2dd9c8eeb508f5982803d2735fff // URL.
