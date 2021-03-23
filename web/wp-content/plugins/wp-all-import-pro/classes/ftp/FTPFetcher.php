<?php
/**
 * PMXI_FTPFetcher Class.
 *
 * @version 1.0.0
 */

defined('ABSPATH') || exit;

require_once(WP_ALL_IMPORT_ROOT_DIR . '/classes/filesystem/RemoteFilesystem.php');

/**
 * Class PMXI_FTPFetcher
 */
class PMXI_FTPFetcher {

    /**
     * Fetch files from FTP server using retry logic.
     *
     * @param $options
     * @throws Exception
     */
    public static function fetch($options) {

    	$ftp = new RemoteFilesystem($options);

    	$files = $ftp->copy();

        if (empty($files)) {
            throw new Exception(__('Uploaded file is empty', PMXI_Plugin::LANGUAGE_DOMAIN));
        }
        return $files;
    }

}