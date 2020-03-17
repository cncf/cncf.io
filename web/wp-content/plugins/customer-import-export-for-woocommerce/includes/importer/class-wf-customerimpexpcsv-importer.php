<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WF_CustomerImpExpCsv_Importer {

	/**
	 * User Exporter Tool
	 */
	public static function load_wp_importer() {
		// Load Importer API
		require_once ABSPATH . 'wp-admin/includes/import.php';

		if ( ! class_exists( 'WP_Importer' ) ) {
			$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
			if ( file_exists( $class_wp_importer ) ) {
				require $class_wp_importer;
			}
		}
	}

	/**
	 * User Importer Tool
	 */
	public static function customer_importer() {
		if ( ! defined( 'WP_LOAD_IMPORTERS' ) ) {
			return;
		}

		self::load_wp_importer();

		// includes
		require_once 'class-wf-customerimpexpcsv-customer-import.php';
		require_once 'class-wf-csv-parser.php';

		// Dispatch
		$GLOBALS['WF_CSV_Customer_Import'] = new WF_CustomerImpExpCsv_Customer_Import();
		$GLOBALS['WF_CSV_Customer_Import'] ->dispatch();
	}	
}