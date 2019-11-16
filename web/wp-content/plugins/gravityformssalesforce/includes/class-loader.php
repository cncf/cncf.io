<?php
/* @package   GFP_Salesforce\GFP_Salesforce_Loader
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
 * Class Loader
 *
 * Adapted from WP Metadata API UI
 *
 * @since  0.1
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
class GFP_Salesforce_Loader {

	private static $_autoload_classes = array(
		'GFP_Salesforce'                   => 'class-gfp-salesforce.php',
		'GFP_Salesforce_Addon'             => 'class-addon.php',
		'GFP_Salesforce_API'               => 'api/class-salesforce-api.php',
		'GFP_Salesforce_API_Logger'        => 'api/class-salesforce-api-logger.php',
		'GFP_Salesforce_OAuth2'            => 'api/class-oauth2.php',
		'GFP_Auto_Upgrader'                => 'class-auto-upgrader.php',
		'Psr\Log\LoggerInterface'          => 'api/Psr/Log/LoggerInterface.php',
		'Psr\Log\LoggerAwareInterface'     => 'api/Psr/Log/LoggerAwareInterface.php',
		'Psr\Log\NullLogger'               => 'api/Psr/Log/NullLogger.php',
		'Psr\Log\AbstractLogger'           => 'api/Psr/Log/AbstractLogger.php',
		'Psr\Log\InvalidArgumentException' => 'api/Psr/Log/InvalidArgumentException.php',
		'Psr\Log\LoggerAwareTrait'         => 'api/Psr/Log/LoggerAwareTrait.php',
		'Psr\Log\LoggerTrait'              => 'api/Psr/Log/LoggerTrait.php',
		'Psr\Log\LogLevel'                 => 'api/Psr/Log/LogLevel.php',
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