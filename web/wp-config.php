<?php
/**
 * WP Config
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

/*
 * Don't show deprecations
 */
error_reporting( E_ALL ^ E_DEPRECATED );

/**
 * Set root path
 */
$root_path = realpath( __DIR__ . '/..' );

/**
 * Include the Composer autoload
 */
require_once $root_path . '/vendor/autoload.php';

/*
 * Fetch .env
 */
if ( ! isset( $_ENV['PANTHEON_ENVIRONMENT'] ) && file_exists( $root_path . '/.env' ) ) {
	$dotenv = Dotenv\Dotenv::create( $root_path );
	$dotenv->load();
	$dotenv->required(
		array(
			'DB_NAME',
			'DB_USER',
			'DB_HOST',
		)
	)->notEmpty();
}

/*
 * If NOT on Pantheon / Lando (which is?)
 */
if ( ! isset( $_ENV['PANTHEON_ENVIRONMENT'] ) ) :
	/**
	 * Define site and home URLs
	 */
	// HTTP is still the default scheme for now.
	$scheme = 'http';
	// If we have detected that the end use is HTTPS, make sure we pass that
	// through here, so <img> tags and the like don't generate mixed-mode
	// content warnings.
	if ( isset( $_SERVER['HTTP_USER_AGENT_HTTPS'] ) && 'ON' == $_SERVER['HTTP_USER_AGENT_HTTPS'] ) {
		$scheme = 'https';
	}

	if ( isset( $_SERVER['HTTP_HOST'] ) ) {
		$site_url = getenv( 'WP_HOME' ) !== false ? getenv( 'WP_HOME' ) : $scheme . '://' . wc_clean( wp_unslash( $_SERVER['HTTP_HOST'] ) ) . '/';
	}

	define( 'WP_HOME', $site_url );
	define( 'WP_SITEURL', $site_url . 'wp/' );

	/**
	 * Set Database Details
	 */
	define( 'DB_NAME', getenv( 'DB_NAME' ) );
	define( 'DB_USER', getenv( 'DB_USER' ) );
	define( 'DB_PASSWORD', getenv( 'DB_PASSWORD' ) !== false ? getenv( 'DB_PASSWORD' ) : '' );
	define( 'DB_HOST', getenv( 'DB_HOST' ) );

	define( 'IS_LOCAL', getenv( 'IS_LOCAL' ) !== false ? true : false );

	/**#@+
	 * Authentication Unique Keys and Salts.
	 *
	 * Change these to different unique phrases!
	 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
	 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
	 *
	 * @since 2.6.0
	 */
	define( 'AUTH_KEY', '^J/U[^{cOJxhcmmCq2MX%nUs}i_^7nm[w+VsetLZ[JXW9Un/IiyWVEXk;s}X=?u$' );
	define( 'SECURE_AUTH_KEY', 'dT,wlW20L5V3ChmTEHFGVtUE-r&A)y+G%Pnql&eKdVAWvdIr9FO4lh_Gc9ZVn!1|' );
	define( 'LOGGED_IN_KEY', '{0E{}k_e7!XRt*}h}nuMP[sKn$gb(O@|[>?bUs}B{>:|+|lL%czE/!Tlc Uk53#:' );
	define( 'NONCE_KEY', '|M9$H1t9D@AR6>JM[]?9RoA^dmOCHt6ldAE%x|0 Iqpi+m32>1>?0*_?*#|6f7|W' );
	define( 'AUTH_SALT', 'CA-BmAsS|o_P|!I8Wfu%a=qXC;!3p[8]W_:N2{oI]HhpLP(%2]zWLH+aHTHDw9>%' );
	define( 'SECURE_AUTH_SALT', 'pi-EA,AOXk*U[VZ|t]R;@K<WMcbD)>k* ;8+hKX:A|$.Z@HL@0`SE?W0:-?-IRd!' );
	define( 'LOGGED_IN_SALT', 'e+6%u)u@RZn-$}_Q[N;Na<|A-[Am_$#nhD~}ci:%R&B*oiq<sPF$v)d1r<-V-5W|' );
	define( 'NONCE_SALT', 'r%oyx_`[A-~<LB)]I.,^//}/&]a)H|fzk3IUWrZn[L4qf#Pp#lsB-B}+/ai&u,/|' );

endif;

/*
 * If on Pantheon
 */
if ( isset( $_ENV['PANTHEON_ENVIRONMENT'] ) ) :

	// ** MySQL settings - included in the Pantheon Environment ** //
	/** The name of the database for WordPress */
	define( 'DB_NAME', $_ENV['DB_NAME'] );

	/** MySQL database username */
	define( 'DB_USER', $_ENV['DB_USER'] );

	/** MySQL database password */
	define( 'DB_PASSWORD', $_ENV['DB_PASSWORD'] );

	/** MySQL hostname; on Pantheon this includes a specific port number. */
	define( 'DB_HOST', $_ENV['DB_HOST'] . ':' . $_ENV['DB_PORT'] );

	/** Database Charset to use in creating database tables. */
	define( 'DB_CHARSET', 'utf8' );

	/** The Database Collate type. Don't change this if in doubt. */
	define( 'DB_COLLATE', '' );

	/**#@+
	 * Authentication Unique Keys and Salts.
	 *
	 * Change these to different unique phrases!
	 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
	 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
	 *
	 * Pantheon sets these values for you also. If you want to shuffle them you
	 * can do so via your dashboard.
	 *
	 * @since 2.6.0
	 */
	define( 'AUTH_KEY', $_ENV['AUTH_KEY'] );
	define( 'SECURE_AUTH_KEY', $_ENV['SECURE_AUTH_KEY'] );
	define( 'LOGGED_IN_KEY', $_ENV['LOGGED_IN_KEY'] );
	define( 'NONCE_KEY', $_ENV['NONCE_KEY'] );
	define( 'AUTH_SALT', $_ENV['AUTH_SALT'] );
	define( 'SECURE_AUTH_SALT', $_ENV['SECURE_AUTH_SALT'] );
	define( 'LOGGED_IN_SALT', $_ENV['LOGGED_IN_SALT'] );
	define( 'NONCE_SALT', $_ENV['NONCE_SALT'] );
	/**#@-*/

	/** A couple extra tweaks to help things run well on Pantheon. */
	if ( isset( $_SERVER['HTTP_HOST'] ) ) {
		// HTTP is still the default scheme for now.
		$scheme = 'http';
		// If we have detected that the end use is HTTPS, make sure we pass that
		// through here, so <img> tags and the like don't generate mixed-mode
		// content warnings.
		if ( isset( $_SERVER['HTTP_USER_AGENT_HTTPS'] ) && $_SERVER['HTTP_USER_AGENT_HTTPS'] == 'ON' ) {
			$scheme = 'https';
		}
		define( 'WP_HOME', $scheme . '://' . $_SERVER['HTTP_HOST'] );
		define( 'WP_SITEURL', $scheme . '://' . $_SERVER['HTTP_HOST'] . '/wp' );

	}
	// Don't show deprecations; useful under PHP 5.5.
	error_reporting( E_ALL ^ E_DEPRECATED );
	// Force the use of a safe temp directory when in a container.
	if ( defined( 'PANTHEON_BINDING' ) ) :
		define( 'WP_TEMP_DIR', sprintf( '/srv/bindings/%s/tmp', PANTHEON_BINDING ) );
	endif;

	// FS writes aren't permitted in test or live, so we should let WordPress know to disable relevant UI.
	if ( in_array( $_ENV['PANTHEON_ENVIRONMENT'], array( 'test', 'live' ) ) && ! defined( 'DISALLOW_FILE_MODS' ) ) :
		define( 'DISALLOW_FILE_MODS', true );
	endif;

	// if environment is Lando run in debug.
	if ( 'lando' === $_ENV['PANTHEON_ENVIRONMENT'] ) :
		define( 'WP_DEBUG', true );
		define( 'WP_DEBUG_DISPLAY', true ); // false to go to log.
		define( 'SCRIPT_DEBUG', true );
		define( 'WP_DISABLE_FATAL_ERROR_HANDLER', true ); // stops admin email sent.

		// fixes small problem with LH-HSTS
		if ( ! isset( $_SERVER['HTTP_HOST'] ) ) {
			$_SERVER['HTTP_HOST'] = 'localhost';
		}

	endif;

endif;

/*
* Define wp-content directory outside of WordPress core directory.
*/
define( 'WP_CONTENT_DIR', dirname( __FILE__ ) . '/wp-content' );
define( 'WP_CONTENT_URL', getenv( 'WP_HOME' ) . '/wp-content' );

/**
 * Disallow on server file edits
 */
define( 'DISALLOW_FILE_EDIT', true );
define( 'DISALLOW_FILE_MODS', true );

/**
 * Force SSL
 */
define( 'FORCE_SSL_ADMIN', true );

/**
 * Limit post revisions
 */
define( 'WP_POST_REVISIONS', 10 );

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = getenv( 'DB_PREFIX' ) !== false ? getenv( 'DB_PREFIX' ) : 'wp_';

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}
/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

if ( isset( $_ENV['PANTHEON_ENVIRONMENT'] ) && php_sapi_name() != 'cli' ) {
	// Redirect to https://$primary_domain in the Live environment.
	if ( 'live' === $_ENV['PANTHEON_ENVIRONMENT'] && 'lfeventsci' === $_ENV['PANTHEON_SITE_NAME'] ) {
		$primary_domain = 'events.linuxfoundation.org';
	} elseif ( 'live' === $_ENV['PANTHEON_ENVIRONMENT'] && 'lfasiallcci' === $_ENV['PANTHEON_SITE_NAME'] && $_SERVER['HTTP_HOST'] != 'events.linuxfoundation.cn' ) {
		$primary_domain = 'www.lfasiallc.com';
	} else {
		// Redirect to HTTPS on every Pantheon environment.
		$primary_domain = $_SERVER['HTTP_HOST']; //phpcs:ignore
	}
	$requires_redirect = false;

	// Ensure the site is being served from the primary domain.
	if ( $_SERVER['HTTP_HOST'] != $primary_domain ) {
		$requires_redirect = true;
	}

	// If you're not using HSTS in the pantheon.yml file, uncomment this next block.
	if ( ! isset( $_SERVER['HTTP_USER_AGENT_HTTPS'] ) || $_SERVER['HTTP_USER_AGENT_HTTPS'] != 'ON' ) {
		$requires_redirect = true;
	}

	if ( true === $requires_redirect ) {
		// Name transaction "redirect" in New Relic for improved reporting (optional).
		if ( extension_loaded( 'newrelic' ) ) {
			newrelic_name_transaction( 'redirect' );
		}

		header( 'HTTP/1.0 301 Moved Permanently' );
		header( 'Location: https://' . $primary_domain . $_SERVER['REQUEST_URI'] );
		exit();
	}
}
