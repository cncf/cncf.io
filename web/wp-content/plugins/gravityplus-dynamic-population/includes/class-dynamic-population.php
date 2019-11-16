<?php
/**
 * @package   GFP_Dynamic_Population
 * @copyright 2014-2019 gravity+
 * @license   GPL-2.0+
 * @since     1.0.0
 * @author    Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */

/**
 * Main Class
 *
 * Loads everything
 *
 * @since 1.0.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
class GFP_Dynamic_Population {

	/**
	 * GFP_Dynamic_Population constructor.
	 *
	 * @since
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function __construct () {

	}

	/**
	 * Load WordPress functions
	 *
	 * @since 2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function run(){

		add_action( 'gform_loaded', array( $this, 'gform_loaded' ) );

	}

	/**
	 * Create GF Add-On
	 *
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function gform_loaded() {

		if ( ! method_exists( 'GFForms', 'include_addon_framework' ) ) {

			return;

		}

		GFForms::include_addon_framework();

		GFForms::include_feed_addon_framework();

		GFAddOn::register( 'GFP_Dynamic_Population_Addon' );


		new GFP_Dynamic_Population_Migrator();

		new GFP_Dynamic_Population_Form_Display();

		//require_once( trailingslashit( GFP_DYNAMIC_POPULATION_PATH ) . 'includes/sources/example-source/class-example-source.php' );

		//new GFP_Dynamic_Population_Example_Source();


		new GFP_Dynamic_Population_Taxonomy();

		new GFP_Dynamic_Population_Posts();

		new GFP_Dynamic_Population_Users();

		new GFP_Dynamic_Population_Entries();

		new GFP_Dynamic_Population_Date();

	}

}