<?php

/**
 * Adapted from WP Metadata API UI
 */
class GFP_Dynamic_Population_Loader {

	private static $_autoload_classes = array(
		'GFP_Dynamic_Population'              => 'class-dynamic-population.php',
		'GFP_Dynamic_Population_Addon'        => 'class-addon.php',
		'GFP_Dynamic_Population_Form_Display' => 'form-display/class-form-display.php',
		'GFP_Dynamic_Population_API'          => 'api/class-api.php',
		'GFP_Dynamic_Population_Custom_Data'  => 'data/class-custom-data.php',
		'GFP_Dynamic_Population_Taxonomy'     => 'sources/taxonomy/class-taxonomy.php',
		'GFP_Dynamic_Population_Posts'        => 'sources/posts/class-posts.php',
		'GFP_Dynamic_Population_Users'        => 'sources/users/class-users.php',
		'GFP_Dynamic_Population_Entries'      => 'sources/entries/class-entries.php',
		'GFP_Dynamic_Population_Date'         => 'sources/date/class-date.php',
		'GFP_Auto_Upgrader'                   => 'class-auto-upgrader.php',
		'GFP_Dynamic_Population_Migrator'     => 'class-migrator.php',
	);

	static function load() {
		spl_autoload_register( array( __CLASS__, '_autoloader' ) );
	}

	/**
	 * @param string $class_name
	 * @param string $class_filepath
	 *
	 * @return bool Return true if it was registered, false if not.
	 */
	static function register_autoload_class( $class_name, $class_filepath ) {

		if ( ! isset( self::$_autoload_classes[ $class_name ] ) ) {

			self::$_autoload_classes[ $class_name ] = $class_filepath;

			return true;

		}

		return false;

	}

	/**
	 * @param string $class_name
	 */
	static function _autoloader( $class_name ) {

		if ( isset( self::$_autoload_classes[ $class_name ] ) ) {

			$filepath = self::$_autoload_classes[ $class_name ];

			/**
			 * @todo This needs to be made to work for Windows...
			 */
			if ( '/' == $filepath[ 0 ] ) {

				require_once( $filepath );

			} else {

				require_once( dirname( __FILE__ ) . "/{$filepath}" );

			}

		}

	}
}