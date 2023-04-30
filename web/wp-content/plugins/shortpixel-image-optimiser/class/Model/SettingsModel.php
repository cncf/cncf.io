<?php
namespace ShortPixel\Model;
use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;

class SettingsModel
{
		protected static $instance;

		private $option_name = 'spio_settings';
		private $state_name = 'spio_states';

		protected $model = array(
        'apiKey' => array('s' => 'string'), // string
        'verifiedKey' => array('s' => 'int'), // string
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

		protected $state = array(

		);

		protected $settings;
		protected $states; 

		public function __construct()
		{
			 $this->checkLegacy();
			 $this->loadSettings();

		}

		public static function getInstance()
		{
			 if (is_null(self::$instance))
			 {
					self::$instance = new SettingsModel;
			 }
			 return self::$instance;
		}

		protected function load()
		{
			 $settings = get_option($this->option_name);
		}

		protected function save()
		{
				update_option($this->option_name, $this->settings);
		}

		public function __get($name)
		{
			 if (isset($this->settings[$name]))
			 {
				  return $this->sanitize($name, $this->settings[$name]);
			 }
		}

		protected function checkLegacy()
		{
				$this->deleteLegacy(); // very legacy, unused
				$this->convertLegacy(); // legacy, move to new format.
		}

		public function convertLegacy()
		{
				$options = array(
		        //optimization options
		        'apiKey' => array('key' => 'wp-short-pixel-apiKey'),
		        'verifiedKey' => array('key' => 'wp-short-pixel-verifiedKey'),
		        'compressionType' => array('key' => 'wp-short-pixel-compression'),
		        'processThumbnails' => array('key' => 'wp-short-process_thumbnails'),
						'useSmartcrop' => array('key' => 'wpspio-usesmartcrop'),
		        'keepExif' => array('key' => 'wp-short-pixel-keep-exif'),
		        'CMYKtoRGBconversion' => array('key' => 'wp-short-pixel_cmyk2rgb'),
		        'createWebp' => array('key' => 'wp-short-create-webp'),
		        'createAvif' => array('key' => 'wp-short-create-avif'),
		        'deliverWebp' => array('key' => 'wp-short-pixel-create-webp-markup'),
		        'optimizeRetina' => array('key' => 'wp-short-pixel-optimize-retina'),
		        'optimizeUnlisted' => array('key' => 'wp-short-pixel-optimize-unlisted'),
		        'backupImages' => array('key' => 'wp-short-backup_images'),
		        'resizeImages' => array('key' => 'wp-short-pixel-resize-images'),
		        'resizeType' => array('key' => 'wp-short-pixel-resize-type'),
		        'resizeWidth' => array('key' => 'wp-short-pixel-resize-width'),
		        'resizeHeight' => array('key' => 'wp-short-pixel-resize-height'),
		        'siteAuthUser' => array('key' => 'wp-short-pixel-site-auth-user'),
		        'siteAuthPass' => array('key' => 'wp-short-pixel-site-auth-pass'),
		        'autoMediaLibrary' => array('key' => 'wp-short-pixel-auto-media-library'),
		        'optimizePdfs' => array('key' => 'wp-short-pixel-optimize-pdfs'),
		        'excludePatterns' => array('key' => 'wp-short-pixel-exclude-patterns'),
		        'png2jpg' => array('key' => 'wp-short-pixel-png2jpg'),
		        'excludeSizes' => array('key' => 'wp-short-pixel-excludeSizes'),
						'currentVersion' => array('key' => 'wp-short-pixel-currentVersion'),

		        //CloudFlare
		        'cloudflareEmail'   => array( 'key' => 'wp-short-pixel-cloudflareAPIEmail'),
		        'cloudflareAuthKey' => array( 'key' => 'wp-short-pixel-cloudflareAuthKey'),
		        'cloudflareZoneID'  => array( 'key' => 'wp-short-pixel-cloudflareAPIZoneID'),
		        'cloudflareToken'   => array( 'key' => 'wp-short-pixel-cloudflareToken'),

		        //optimize other images than the ones in Media Library
		        'includeNextGen' => array('key' => 'wp-short-pixel-include-next-gen'),
		        'hasCustomFolders' => array('key' => 'wp-short-pixel-has-custom-folders'),
		        'customBulkPaused' => array('key' => 'wp-short-pixel-custom-bulk-paused'),

		        //stats, notices, etc.
						// @todo Most of this can go. See state machine comment.

		        'currentStats' => array('key' => 'wp-short-pixel-current-total-files'),
		        'fileCount' => array('key' => 'wp-short-pixel-fileCount'),
		        'thumbsCount' => array('key' => 'wp-short-pixel-thumbnail-count'),
		        'under5Percent' => array('key' => 'wp-short-pixel-files-under-5-percent'),
		        'savedSpace' => array('key' => 'wp-short-pixel-savedSpace'),
		        'apiRetries' => array('key' => 'wp-short-pixel-api-retries'),
		        'totalOptimized' => array('key' => 'wp-short-pixel-total-optimized'),
		        'totalOriginal' => array('key' => 'wp-short-pixel-total-original'),
		        'quotaExceeded' => array('key' => 'wp-short-pixel-quota-exceeded'),
		        'httpProto' => array('key' => 'wp-short-pixel-protocol'),
		        'downloadProto' => array('key' => 'wp-short-pixel-download-protocol'),

						'downloadArchive' => array('key' => 'wp-short-pixel-download-archive'),

		        'activationDate' => array('key' => 'wp-short-pixel-activation-date'),
		        'mediaLibraryViewMode' => array('key' => 'wp-short-pixel-view-mode'),
		        'redirectedSettings' => array('key' => 'wp-short-pixel-redirected-settings'),
		        'convertedPng2Jpg' => array('key' => 'wp-short-pixel-converted-png2jpg'),
		    );
		}

		private function deleteLegacy()
		{
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

} // class
