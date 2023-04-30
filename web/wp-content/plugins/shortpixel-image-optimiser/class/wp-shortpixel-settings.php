<?php
use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;


/** Settings Model **/
class WPShortPixelSettings extends \ShortPixel\Model {
    private $_apiKey = '';
    private $_compressionType = 1;
    private $_keepExif = 0;
    private $_processThumbnails = 1;
    private $_CMYKtoRGBconversion = 1;
    private $_backupImages = 1;
    private $_verifiedKey = false;

    private $_resizeImages = false;
    private $_resizeWidth = 0;
    private $_resizeHeight = 0;

    private static $_optionsMap = array(
        //This one is accessed also directly via get_option
        'frontBootstrap' => array('key' => 'wp-short-pixel-front-bootstrap', 'default' => null, 'group' => 'options'), //set to 1 when need the plugin active for logged in user in the front-end
      //  'lastBackAction' => array('key' => 'wp-short-pixel-last-back-action', 'default' => null, 'group' => 'state'), //when less than 10 min. passed from this timestamp, the front-bootstrap is ineffective.

        //optimization options
        'apiKey' => array('key' => 'wp-short-pixel-apiKey', 'default' => '', 'group' => 'options'),
        'verifiedKey' => array('key' => 'wp-short-pixel-verifiedKey', 'default' => false, 'group' => 'options'),
        'compressionType' => array('key' => 'wp-short-pixel-compression', 'default' => 1, 'group' => 'options'),
        'processThumbnails' => array('key' => 'wp-short-process_thumbnails', 'default' => 1, 'group' => 'options'),
				'useSmartcrop' => array('key' => 'wpspio-usesmartcrop', 'default' => 0, 'group' => 'options'),
        'keepExif' => array('key' => 'wp-short-pixel-keep-exif', 'default' => 0, 'group' => 'options'),
        'CMYKtoRGBconversion' => array('key' => 'wp-short-pixel_cmyk2rgb', 'default' => 1, 'group' => 'options'),
        'createWebp' => array('key' => 'wp-short-create-webp', 'default' => null, 'group' => 'options'),
        'createAvif' => array('key' => 'wp-short-create-avif', 'default' => null, 'group' => 'options'),
        'deliverWebp' => array('key' => 'wp-short-pixel-create-webp-markup', 'default' => 0, 'group' => 'options'),
        'optimizeRetina' => array('key' => 'wp-short-pixel-optimize-retina', 'default' => 1, 'group' => 'options'),
        'optimizeUnlisted' => array('key' => 'wp-short-pixel-optimize-unlisted', 'default' => 0, 'group' => 'options'),
        'backupImages' => array('key' => 'wp-short-backup_images', 'default' => 1, 'group' => 'options'),
        'resizeImages' => array('key' => 'wp-short-pixel-resize-images', 'default' => false, 'group' => 'options'),
        'resizeType' => array('key' => 'wp-short-pixel-resize-type', 'default' => null, 'group' => 'options'),
        'resizeWidth' => array('key' => 'wp-short-pixel-resize-width', 'default' => 0, 'group' => 'options'),
        'resizeHeight' => array('key' => 'wp-short-pixel-resize-height', 'default' => 0, 'group' => 'options'),
        'siteAuthUser' => array('key' => 'wp-short-pixel-site-auth-user', 'default' => null, 'group' => 'options'),
        'siteAuthPass' => array('key' => 'wp-short-pixel-site-auth-pass', 'default' => null, 'group' => 'options'),
        'autoMediaLibrary' => array('key' => 'wp-short-pixel-auto-media-library', 'default' => 1, 'group' => 'options'),
        'optimizePdfs' => array('key' => 'wp-short-pixel-optimize-pdfs', 'default' => 1, 'group' => 'options'),
        'excludePatterns' => array('key' => 'wp-short-pixel-exclude-patterns', 'default' => array(), 'group' => 'options'),
        'png2jpg' => array('key' => 'wp-short-pixel-png2jpg', 'default' => 0, 'group' => 'options'),
        'excludeSizes' => array('key' => 'wp-short-pixel-excludeSizes', 'default' => array(), 'group' => 'options'),
				'currentVersion' => array('key' => 'wp-short-pixel-currentVersion', 'default' => null, 'group' => 'options'),

        //CloudFlare
        'cloudflareEmail'   => array( 'key' => 'wp-short-pixel-cloudflareAPIEmail', 'default' => '', 'group' => 'options'),
        'cloudflareAuthKey' => array( 'key' => 'wp-short-pixel-cloudflareAuthKey', 'default' => '', 'group' => 'options'),
        'cloudflareZoneID'  => array( 'key' => 'wp-short-pixel-cloudflareAPIZoneID', 'default' => '', 'group' => 'options'),
        'cloudflareToken'   => array( 'key' => 'wp-short-pixel-cloudflareToken', 'default' => '', 'group' => 'options'),

        //optimize other images than the ones in Media Library
        'includeNextGen' => array('key' => 'wp-short-pixel-include-next-gen', 'default' => null, 'group' => 'options'),
        'hasCustomFolders' => array('key' => 'wp-short-pixel-has-custom-folders', 'default' => false, 'group' => 'options'),
        'customBulkPaused' => array('key' => 'wp-short-pixel-custom-bulk-paused', 'default' => false, 'group' => 'options'),

        //uninstall
  //      'removeSettingsOnDeletePlugin' => array('key' => 'wp-short-pixel-remove-settings-on-delete-plugin', 'default' => false, 'group' => 'options'),

        //stats, notices, etc.
				// @todo Most of this can go. See state machine comment.
        'currentStats' => array('key' => 'wp-short-pixel-current-total-files', 'default' => null, 'group' => 'state'),
        'fileCount' => array('key' => 'wp-short-pixel-fileCount', 'default' => 0, 'group' => 'state'),
        'thumbsCount' => array('key' => 'wp-short-pixel-thumbnail-count', 'default' => 0, 'group' => 'state'),
        'under5Percent' => array('key' => 'wp-short-pixel-files-under-5-percent', 'default' => 0, 'group' => 'state'),
        'savedSpace' => array('key' => 'wp-short-pixel-savedSpace', 'default' => 0, 'group' => 'state'),
        'apiRetries' => array('key' => 'wp-short-pixel-api-retries', 'default' => 0, 'group' => 'state'),
        'totalOptimized' => array('key' => 'wp-short-pixel-total-optimized', 'default' => 0, 'group' => 'state'),
        'totalOriginal' => array('key' => 'wp-short-pixel-total-original', 'default' => 0, 'group' => 'state'),
        'quotaExceeded' => array('key' => 'wp-short-pixel-quota-exceeded', 'default' => 0, 'group' => 'state'),
        'httpProto' => array('key' => 'wp-short-pixel-protocol', 'default' => 'https', 'group' => 'state'),
        'downloadProto' => array('key' => 'wp-short-pixel-download-protocol', 'default' => null, 'group' => 'state'),

				'downloadArchive' => array('key' => 'wp-short-pixel-download-archive', 'default' => -1, 'group' => 'state'),

        'activationDate' => array('key' => 'wp-short-pixel-activation-date', 'default' => null, 'group' => 'state'),
        'mediaLibraryViewMode' => array('key' => 'wp-short-pixel-view-mode', 'default' => false, 'group' => 'state'),
        'redirectedSettings' => array('key' => 'wp-short-pixel-redirected-settings', 'default' => null, 'group' => 'state'),
        'convertedPng2Jpg' => array('key' => 'wp-short-pixel-converted-png2jpg', 'default' => array(), 'group' => 'state'),
				'unlistedCounter' => array('key' => 'wp-short-pixel-unlisted-counter', 'default' => 0, 'group' => 'state'),
    );

    // This  array --  field_name -> (s)anitize mask
    protected $model = array(
        'apiKey' => array('s' => 'string'), // string
    //    'verifiedKey' => array('s' => 'string'), // string
        'compressionType' => array('s' => 'int'), // int
        'resizeWidth' => array('s' => 'int'), // int
        'resizeHeight' => array('s' => 'int'), // int
        'processThumbnails' => array('s' => 'boolean'), // checkbox
				'useSmartcrop' => array('s' => 'boolean'),
        'backupImages' => array('s' => 'boolean'), // checkbox
        'keepExif' => array('s' => 'int'), // checkbox
        'resizeImages' => array('s' => 'boolean'),
        'resizeType' => array('s' => 'string'),
        'includeNextGen' => array('s' => 'boolean'), // checkbox
        'png2jpg' => array('s' => 'int'), // checkbox
        'CMYKtoRGBconversion' => array('s' => 'boolean'), //checkbox
        'createWebp' => array('s' => 'boolean'), // checkbox
        'createAvif' => array('s' => 'boolean'),  // checkbox
        'deliverWebp' => array('s' => 'int'), // checkbox
        'optimizeRetina' => array('s' => 'boolean'), // checkbox
        'optimizeUnlisted' => array('s' => 'boolean'), // $checkbox
        'optimizePdfs' => array('s' => 'boolean'), //checkbox
        'excludePatterns' => array('s' => 'exception'), //  - processed, multi-layer, so skip
        'siteAuthUser' => array('s' => 'string'), // string
        'siteAuthPass' => array('s' => 'string'), // string
        'frontBootstrap' => array('s' =>'boolean'), // checkbox
        'autoMediaLibrary' => array('s' => 'boolean'), // checkbox
        'excludeSizes' => array('s' => 'array'), // Array
        'cloudflareEmail' => array('s' => 'string'), // string
        'cloudflareAuthKey' => array('s' => 'string'), // string
        'cloudflareZoneID' => array('s' => 'string'), // string
        'cloudflareToken' => array('s' => 'string'),
        'savedSpace' => array('s' => 'skip'),
        'fileCount' => array('s' => 'skip'), // int
        'under5Percent' => array('s' => 'skip'), // int
    );

      public static function resetOptions() {
        foreach(self::$_optionsMap as $key => $val) {
            delete_option($val['key']);
        }
        delete_option("wp-short-pixel-bulk-previous-percent");
    }

    public static function onActivate() {
        if(!self::getOpt('wp-short-pixel-verifiedKey', false)) {
            update_option('wp-short-pixel-activation-notice', true, 'no');
        }
        update_option( 'wp-short-pixel-activation-date', time(), 'no');

			  delete_option( 'wp-short-pixel-bulk-last-status'); // legacy shizzle
        delete_option( 'wp-short-pixel-current-total-files');
				delete_option('wp-short-pixel-remove-settings-on-delete-plugin');

				if (isset(self::$_optionsMap['removeSettingsOnDeletePlugin']) && isset(self::$_optionsMap['removeSettingsOnDeletePlugin']['key']))
				{
        	delete_option(self::$_optionsMap['removeSettingsOnDeletePlugin']['key']);
				}
        // Dismissed now via Notices Controller.

    }

    public static function onDeactivate() {

        delete_option('wp-short-pixel-activation-notice');
				delete_option('wp-short-pixel-bulk-last-status'); // legacy shizzle
				delete_option('wp-short-pixel-current-total-files');
				delete_option('wp-short-pixel-remove-settings-on-delete-plugin');

				// Bulk State machine legacy
				$bulkLegacyOptions = array(
						'wp-short-pixel-bulk-type',
						'wp-short-pixel-bulk-last-status',
						'wp-short-pixel-query-id-start',
						'wp-short-pixel-query-id-stop',
						'wp-short-pixel-bulk-count',
						'wp-short-pixel-bulk-previous-percent',
						'wp-short-pixel-bulk-processed-items',
						'wp-short-pixel-bulk-done-count',
						'wp-short-pixel-last-bulk-start-time',
						'wp-short-pixel-last-bulk-success-time',
						'wp-short-pixel-bulk-running-time',
						'wp-short-pixel-cancel-pointer',
						'wp-short-pixel-skip-to-custom',
						'wp-short-pixel-bulk-ever-ran',
						'wp-short-pixel-flag-id',
						'wp-short-pixel-failed-imgs',
						'bulkProcessingStatus',
						'wp-short-pixel-prioritySkip',
				);

				$removedStats = array(
						'wp-short-pixel-helpscout-optin',
						'wp-short-pixel-activation-notice',
						'wp-short-pixel-dismissed-notices',
						'wp-short-pixel-media-alert',
				);

				$removedOptions = array(
						'wp-short-pixel-remove-settings-on-delete-plugin',
						'wp-short-pixel-custom-bulk-paused',
						'wp-short-pixel-last-back-action',
						'wp-short-pixel-front-bootstrap',
				);

				$toRemove = array_merge($bulkLegacyOptions, $removedStats, $removedOptions);

				foreach($toRemove as $option)
				{
					 delete_option($option);
				}
    }


    public function __get($name)
    {
        if (array_key_exists($name, self::$_optionsMap)) {
            return $this->getOpt(self::$_optionsMap[$name]['key'], self::$_optionsMap[$name]['default']);
        }
        $trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): ' . esc_html($name) .
            ' in ' . esc_html($trace[0]['file']) .
            ' on line ' . esc_html($trace[0]['line']),
            E_USER_NOTICE);
        return null;
    }

    public function __set($name, $value) {
        if (array_key_exists($name, self::$_optionsMap)) {
            if($value !== null) {
                $this->setOpt(self::$_optionsMap[$name]['key'], $value);
            } else {
                delete_option(self::$_optionsMap[$name]['key']);
            }
        }
    }

		// Remove option. Only deletes with defined key!
		public function deleteOption($key)
		{
			  if(isset(self::$_optionsMap[$key]) && isset(self::$_optionsMap[$key]['key']))
				{
						$deleteKey = self::$_optionsMap[$key]['key'];
						delete_option($deleteKey);
				}
		}

    public static function getOpt($key, $default = null) {

				// This function required the internal Key. If this not given, but settings key, overwrite.
        if(isset(self::$_optionsMap[$key]['key'])) { //first try our name
						$default = self::$_optionsMap[$key]['default']; // first do default do to overwrite.
						$key = self::$_optionsMap[$key]['key'];
        }

        $opt = get_option($key, $default);
				return $opt;
    }

    public function setOpt($key, $val) {
        $autoload = true;
        /*if (isset(self::$_optionsMap[$key]))
        {
            if (self::$_optionsMap[$key]['group'] == 'options')
               $autoload = true;  // add most used to autoload, because performance.

        } */

        $ret = update_option($key, $val, $autoload);

        //hack for the situation when the option would just not update....
        if($ret === false && !is_array($val) && $val != get_option($key)) {
            delete_option($key);
            $alloptions = wp_load_alloptions();
            if ( isset( $alloptions[$key] ) ) {
                wp_cache_delete( 'alloptions', 'options' );
            } else {
                wp_cache_delete( $key, 'options' );
            }
            delete_option($key);
            add_option($key, $val, '', $autoload);

            // still not? try the DB way...
            if($ret === false && $val != get_option($key)) {
                global $wpdb;
                $sql = "SELECT * FROM {$wpdb->prefix}options WHERE option_name = '" . $key . "'";
                $rows = $wpdb->get_results($sql);
                if(count($rows) === 0) {
                    $wpdb->insert($wpdb->prefix.'options',
                                 array("option_name" => $key, "option_value" => (is_array($val) ? serialize($val) : $val), "autoload" => $autoload),
                                 array("option_name" => "%s", "option_value" => (is_numeric($val) ? "%d" : "%s")));
                } else { //update
                    $sql = "update {$wpdb->prefix}options SET option_value=" .
                           (is_array($val)
                               ? "'" . serialize($val) . "'"
                               : (is_numeric($val) ? $val : "'" . $val . "'")) . " WHERE option_name = '" . $key . "'";
                    $rows = $wpdb->get_results($sql);
                }

                if($val != get_option($key)) {
                    //tough luck, gonna use the bomb...
                    wp_cache_flush();
                    delete_option($key);
                    add_option($key, $val, '', $autoload);
                }
            }
        }
    }

} // class
