<?php

// Enqueue admin_init hook after licensing system initialization
add_action( 'wprss_init_licensing', function() {
	add_action( 'admin_init', 'wprss_ftp_init_updater' );
});

/**
 * Creates and initializes the updater for this addon.
 *
 * @uses Aventura\Wprss\Core\Licensing\Manager::initUpdaterInstance() To initialize the updater instance
 */
function wprss_ftp_init_updater() {
	if ( method_exists(wprss_licensing_get_manager(), 'initUpdaterInstance') ) {
		wprss_licensing_get_manager()->initUpdaterInstance('ftp', WPRSS_FTP_SL_ITEM_NAME, WPRSS_FTP_VERSION, WPRSS_FTP_PATH, WPRSS_FTP_SL_STORE_URL);
	}
}
