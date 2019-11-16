<?php
/* @package   GFP_Salesforce\GFP_Salesforce
 * @author    Naomi C. Bush for gravity+ <support@gravityplus.pro>
 * @copyright 2017-2019 gravity+
 * @license   GPL-2.0+
 * @since     0.1
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class GFP_Salesforce
 *
 * Main plugin class
 *
 * @since  0.1
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
class GFP_Salesforce {

	/**
	 * Constructor
	 *
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function construct() {
	}

	/**
	 * Register WordPress hooks
	 *
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function run() {

		add_action( 'gform_loaded', array( $this, 'gform_loaded' ) );

	}

	/**
	 * Create GF Add-On
	 *
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function gform_loaded() {

		if ( ! method_exists( 'GFForms', 'include_addon_framework' ) ) {

			return;

		}

		GFForms::include_addon_framework();

		GFForms::include_feed_addon_framework();

		GFAddOn::register( 'GFP_Salesforce_Addon' );

		/**
		 * Used to make sure all Salesforce Add-Ons are loaded after the main plugin
		 *
		 * @since 1.6.0
		 */
		do_action( 'gform_salesforce_loaded' );

	}

	/**
	 * Return GF Add-On object
	 *
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return GFP_Salesforce_Addon
	 */
	public function get_addon_object() {

		return GFP_Salesforce_Addon::get_instance();

	}

}