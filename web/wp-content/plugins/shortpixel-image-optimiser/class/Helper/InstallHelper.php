<?php
namespace ShortPixel\Helper;

use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;
use ShortPixel\Controller\OptimizeController as OptimizeController;
use ShortPixel\Controller\BulkController as BulkController;
use ShortPixel\Controller\FileSystemController as FileSystemController;
use ShortPixel\Controller\AdminNoticesController as AdminNoticesController;
use ShortPixel\Controller\StatsController as StatsController;
use ShortPixel\Controller\ApiKeyController as ApiKeyController;
use ShortPixel\Helper\UtilHelper as UtilHelper;


class InstallHelper
{


  public static function activatePlugin()
  {
      self::deactivatePlugin();
      $settings = \wpSPIO()->settings();

      $env = wpSPIO()->env();

      if(\WPShortPixelSettings::getOpt('deliverWebp') == 3 && ! $env->is_nginx) {
          UtilHelper::alterHtaccess(true,true); //add the htaccess lines
      }

      self::checkTables();

      AdminNoticesController::resetOldNotices();
      \WPShortPixelSettings::onActivate();

			$settings->currentVersion = SHORTPIXEL_IMAGE_OPTIMISER_VERSION;
  }

  public static function deactivatePlugin()
  {

    $settings = \wpSPIO()->settings();
		$settings::onDeactivate();

    $env = wpSPIO()->env();

    if (! $env->is_nginx)
		{
      UtilHelper::alterHtaccess(false, false);
		}

    // save remove.
    $fs = new FileSystemController();
    $log = $fs->getFile(SHORTPIXEL_BACKUP_FOLDER . "/shortpixel_log");

    if ($log->exists())
     $log->delete();

    global $wpdb;
    $sql = "delete from " . $wpdb->options . " where option_name like '%_transient_shortpixel%'";
    $wpdb->query($sql); // remove transients.

		// saved in settings object, reset all stats.
 		StatsController::getInstance()->reset();

  }

  public static function uninstallPlugin()
  {
   // $settings = \wpSPIO()->settings();
 //   $env = \wpSPIO()->env();

    OptimizeController::uninstallPlugin();
		ApiKeyController::uninstallPlugin();
  }

 // Removes everything  of SPIO 5.x .  Not recommended.
	public static function hardUninstall()
	{
		$env = \wpSPIO()->env();
		$settings = \wpSPIO()->settings();


		$nonce = (isset($_POST['tools-nonce'])) ? sanitize_key($_POST['tools-nonce']) : null;
		if ( ! wp_verify_nonce( $nonce, 'remove-all' ) ) {
          wp_nonce_ays( '' );
    }

		self::deactivatePlugin(); // deactivate
		self::uninstallPlugin(); // uninstall

		// Bulk Log
		BulkController::uninstallPlugin();

		$settings::resetOptions();

		if (! $env->is_nginx)
			insert_with_markers( get_home_path() . '.htaccess', 'ShortPixelWebp', '');

		self::removeTables();

		// Remove Backups
		$dir = \wpSPIO()->filesystem()->getDirectory(SHORTPIXEL_BACKUP_FOLDER);
		$dir->recursiveDelete();

		$plugin = basename(SHORTPIXEL_PLUGIN_DIR) . '/' . basename(SHORTPIXEL_PLUGIN_FILE);
		deactivate_plugins($plugin);

	}


  public static function deactivateConflictingPlugin()
  {
    if ( ! isset($_GET['_wpnonce']) || ! wp_verify_nonce( sanitize_key($_GET['_wpnonce']), 'sp_deactivate_plugin_nonce' ) ) {
          wp_nonce_ays( 'Nononce' );
    }

    $referrer_url = wp_get_referer();
    $url = wp_get_referer();
		$plugin = (isset($_GET['plugin'])) ? sanitize_text_field(wp_unslash($_GET['plugin'])) : null; // our target.

		if (! is_null($plugin))
	  	deactivate_plugins($plugin);

    wp_safe_redirect($url);
    die();


  }

	/**
	* Check if TableName exists
	* @param $tableName The Name of the Table without Prefix.
	*/
	public static function checkTableExists($tableName)
	{
		      global $wpdb;
					$tableName = $wpdb->prefix . $tableName;
		      $sql = $wpdb->prepare("
		               SHOW TABLES LIKE %s
		               ", $tableName);

		       $result = intval($wpdb->query($sql));

		       if ($result == 0)
		         return false;
		       else {
		         return true;
		       }
	}


	public static function checkTables()
	{
			global $wpdb;
    	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );


			dbDelta(self::getFolderTableSQL());

	    	dbDelta(self::getMetaTableSQL());

			dbDelta(self::getPostMetaSQL());


			self::checkIndexes();
	}

	private static function checkIndexes()
	{
			global $wpdb;

			$definitions = array(
				 'shortpixel_meta' => array(
					 	'path' => 'path'
				 ),
				 'shortpixel_folders' => array(
					  'path' => 'path'
				 ),
				 'shortpixel_postmeta' => array(
					   'attach_id' => 'attach_id',
						 'parent' => 'parent',
						 'size' => 'size',
						 'status' => 'status',
						 'compression_type' => 'compression_type'
				 )
			);

			foreach($definitions as $raw_tableName => $indexes)
			{
					$tableName = $wpdb->prefix . $raw_tableName;
					foreach($indexes as $indexName => $fieldName)
					{
							// Check exists
							$sql = 'SHOW INDEX FROM ' . $tableName . ' WHERE Key_name = %s';
							$sql = $wpdb->prepare($sql, $indexName);

							$res = $wpdb->get_row($sql);

							if (is_null($res))
							{
								// can't prepare for those, also not any user data here.
								 $sql = 'CREATE INDEX ' . $indexName . ' ON ' . $tableName . ' ( ' . $fieldName . ')';
								 $res = $wpdb->query($sql);
							}

					}
			}
	}

	private static function removeTables()
	{
		 global $wpdb;
			if (self::checkTableExists('shortpixel_folders') === true)
	    {
					$sql = 'DROP TABLE  ' . $wpdb->prefix . 'shortpixel_folders';
					$wpdb->query($sql);
			}
			if (self::checkTableExists('shortpixel_meta') === true)
			{
	 	    	$sql = 'DROP TABLE  ' . $wpdb->prefix . 'shortpixel_meta';
					$wpdb->query($sql);
			}
			if (self::checkTableExists('shortpixel_postmeta') === true)
			{
					$sql = 'DROP TABLE  ' . $wpdb->prefix . 'shortpixel_postmeta';
					error_log('Dropping postmeta' . $sql);
					$wpdb->query($sql);
			}
	}

  public static function getFolderTableSQL() {
		 global $wpdb;
		 $charsetCollate = $wpdb->get_charset_collate();
		 $prefix = $wpdb->prefix;

     return "CREATE TABLE {$prefix}shortpixel_folders (
          id mediumint(9) NOT NULL AUTO_INCREMENT,
          path varchar(512),
          name varchar(150),
          path_md5 char(32),
          file_count int,
          status SMALLINT NOT NULL DEFAULT 0,
          ts_updated timestamp,
          ts_created timestamp,
          PRIMARY KEY id (id)
        ) $charsetCollate;";

  }

  public static function getMetaTableSQL() {
		 	global $wpdb;
		 	$charsetCollate = $wpdb->get_charset_collate();
			$prefix = $wpdb->prefix;

     return "CREATE TABLE {$prefix}shortpixel_meta (
          id mediumint(10) NOT NULL AUTO_INCREMENT,
          folder_id mediumint(9) NOT NULL,
          ext_meta_id int(10),
          path varchar(512),
          name varchar(150),
          path_md5 char(32),
          compressed_size int(10) NOT NULL DEFAULT 0,
          compression_type tinyint,
          keep_exif tinyint DEFAULT 0,
          cmyk2rgb tinyint DEFAULT 0,
          resize tinyint,
          resize_width smallint,
          resize_height smallint,
          backup tinyint DEFAULT 0,
          status SMALLINT NOT NULL DEFAULT 0,
          retries tinyint NOT NULL DEFAULT 0,
          message varchar(255),
          ts_added timestamp,
          ts_optimized timestamp,
					extra_info LONGTEXT,
          PRIMARY KEY sp_id (id)
        ) $charsetCollate;";

  }

	public static function getPostMetaSQL()
	{
		 global $wpdb;
		 $charsetCollate = $wpdb->get_charset_collate();
		 $prefix = $wpdb->prefix;

		 $sql = "CREATE TABLE {$prefix}shortpixel_postmeta (
			 id bigint unsigned NOT NULL AUTO_INCREMENT ,
			 attach_id bigint unsigned NOT NULL,
			 parent bigint unsigned NOT NULL,
			 image_type tinyint default 0,
			 size varchar(200),
			 status tinyint default 0,
			 compression_type tinyint,
			 compressed_size  int,
			 original_size int,
			 tsAdded timestamp,
			 tsOptimized  timestamp,
			 extra_info LONGTEXT,
			 PRIMARY KEY id (id)
		 ) $charsetCollate;";

		 return $sql;
	}


} // InstallHelper
