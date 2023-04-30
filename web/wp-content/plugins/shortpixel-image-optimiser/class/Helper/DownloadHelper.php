<?php
namespace ShortPixel\Helper;

use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;
use ShortPixel\Controller\ResponseController as ResponseController;


class DownloadHelper
{
		  private static $instance;

			public function __construct()
			{
					$this->checkEnv();
			}

			public static function getInstance()
			{
				 if (is_null(self::$instance))
				 {
					  self::$instance = new DownloadHelper();
				 }

				 return self::$instance;
			}

			protected function checkEnv()
			{
				if ( ! function_exists( 'download_url' ) ) {
						require_once ABSPATH . 'wp-admin/includes/file.php';
				}
			}

			public function downloadFile($url, $args = array())
			{
					$defaults = array(
						'expectedSize' => null,

					);
					$args = wp_parse_args($args, $defaults);

					Log::addDebug('Downloading file :' . $url, $args);

					$fileURL = $this->setPreferredProtocol(urldecode($url));

					$downloadTimeout = max(ini_get('max_execution_time') - 10, 15);
					$tempFile = \download_url($fileURL, $downloadTimeout);

		      Log::addInfo(' Download ' . $fileURL . ' to : '. json_encode($tempFile) . '  (timeout: )' . $downloadTimeout);

					if(is_wp_error( $tempFile ))
		      { //try to switch the default protocol
		          $fileURL = $this->setPreferredProtocol(urldecode($fileURL), true); //force recheck of the protocol
		          $tempFile = \download_url($fileURL, $downloadTimeout);
		      }

					if (is_wp_error($tempFile))
					{
						//get_temp_dir
						$tmpfname = tempnam(get_temp_dir(), 'spiotmp');

						$args_for_get = array(
							'stream' => true,
							'filename' => $tmpfname,
							'timeout' => $downloadTimeout,
						);

						$tempFile = wp_remote_get( $url, $args_for_get );
					}

					if (is_wp_error($tempFile))
					{
						Log::addError('Failed to download File', $tempFile);
						ResponseController::addData('is_error', true);
						Responsecontroller::addData('message', $tempFile->get_error_message());
						return false;
					}

					$fs = \wpSPIO()->filesystem();
					$file = $fs->getFile($tempFile);

					return $file;
			}

			private function setPreferredProtocol($url, $reset = false) {
		      //switch protocol based on the formerly detected working protocol
		      $settings = \wpSPIO()->settings();

		      if($settings->downloadProto == '' || $reset) {
		          //make a test to see if the http is working
		          $testURL = 'http://' . SHORTPIXEL_API . '/img/connection-test-image.png';
		          $result = download_url($testURL, 10);
		          $settings->downloadProto = is_wp_error( $result ) ? 'https' : 'http';
		      }
		      return $settings->downloadProto == 'http' ?
		              str_replace('https://', 'http://', $url) :
		              str_replace('http://', 'https://', $url);
		  }
}
