<?php
if ( ! function_exists('wp_all_import_secure_file') ) {
	function wp_all_import_secure_file( $targetDir, $importID = false, $remove_dir = false, $generateDir = true ) {
		$is_secure_import = PMXI_Plugin::getInstance()->getOption('secure');
		if ( $is_secure_import ) {
		    $nonce_salt = defined('NONCE_SALT') ? NONCE_SALT : wp_salt('nonce');
			$dir = $targetDir . DIRECTORY_SEPARATOR . ( ( $importID ) ? md5( $importID . $nonce_salt ) : md5( time() . $nonce_salt ) );
			if ( @is_dir($dir) and $remove_dir ) wp_all_import_remove_source($dir . DIRECTORY_SEPARATOR . 'index.php' );
			if ( $generateDir ) @wp_mkdir_p($dir);
			if (@is_writable($dir) and @is_dir($dir)) {
				$targetDir = $dir;					
				if (!@file_exists($dir . DIRECTORY_SEPARATOR . 'index.php') && $generateDir)  {
					@touch( $dir . DIRECTORY_SEPARATOR . 'index.php' );
				}				
			}
		}
		return $targetDir;
	}
}	