<?php
 namespace ShortPixel\Model\Converter;

 use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;
 use ShortPixel\Model\Image\ImageModel as ImageModel;
 use ShortPixel\Model\File\DirectoryModel as DirectoryModel;
 use ShortPixel\Model\File\FileModel as FileModel;
 use ShortPixel\Notices\NoticeController as Notices;

 use ShortPixel\Controller\ResponseController as ResponseController;

 use ShortPixel\Helper\DownloadHelper as DownloadHelper;


class PNGConverter extends MediaLibraryConverter
{
		protected $instance;

    protected $current_image; // The current PHP image resource in memory
		protected $newFile; // The newFile Object.
		protected $replacer; // Replacer class Object.

		protected $converterActive = false;
		protected $forceConvertTransparent = false;

		protected $lastError;

		protected $settingCheckSum;


		public function __construct($imageModel)
		{
			parent::__construct($imageModel);

			$settings = \wpSPIO()->settings();
			$env = \wpSPIO()->env();


			$this->converterActive = (intval($settings->png2jpg) > 0) ? true : false;

			if ($env->is_gd_installed === false)
			{
				 $this->converterActive = false;
				 $this->lastError = __('GD library is not active on this installation. Can\'t convert images to PNG', 'shortpixel-image-optimiser');
			}

			$this->forceConvertTransparent = ($settings->png2jpg == 2) ? true : false;

			// If conversion is tried, but failed somehow, it will never try it again, even after changing settings. This should prevent that switch.
			$this->settingCheckSum = intval($settings->png2jpg) + intval($settings->backupImages);


		}

		public function isConvertable()
		{
				$imageModel = $this->imageModel;

				// Settings
			  if ($this->converterActive === false)
				{
					return false;
				}

				// Extension
				if ($imageModel->getExtension() !== 'png') // not a png ext. fail silently.
				{
					return false;
				}

				// Existence
				if (! $imageModel->exists())
				{
					 return false;
				}

				if (true === $imageModel->getMeta()->convertMeta()->isConverted() || true === $this->hasTried($imageModel->getMeta()->convertMeta()->didTry()) )
				{
					return false;
				}


				return true;
		}

		protected function hasTried($checksum)
		{
			 if ( intval($checksum) === $this->getCheckSum())
			 {
				  return true;
			 }
			 return false;
		}

		public function convert($args = array())
		{
			 if (! $this->isConvertable($this->imageModel))
			 {
				 return false;
			 }

			 $fs = \wpSPIO()->filesystem();


			 $defaults = array(
				 	'runReplacer' => true, // The replacer doesn't need running when the file is just uploaded and doing in handle upload hook.
			 );

			 $conversionArgs = array('checksum' => $this->getCheckSum());

			 $this->setupReplacer();
			 $this->raiseMemoryLimit();

			 $replacementPath = $this->getReplacementPath();
			 if (false === $replacementPath)
			 {
				 Log::addWarn('ApiConverter replacement path failed');
				 $this->imageModel->getMeta()->convertMeta()->setError(self::ERROR_PATHFAIL);

				 return false; // @todo Add ResponseController something here.
			 }

			 $replaceFile = $fs->getFile($replacementPath);
			 Log::addDebug('Image replacement base : ' . $replaceFile->getFileBase());
			 $this->imageModel->getMeta()->convertMeta()->setReplacementImageBase($replaceFile->getFileBase());

			 $prepared = $this->imageModel->conversionPrepare($conversionArgs);
 			 if (false === $prepared)
 			 {
				  return false;
			 }

			 $args = wp_parse_args($args, $defaults);


			 if ($this->forceConvertTransparent === false && $this->isTransparent())
			 {
				 	$this->imageModel->getMeta()->convertMeta()->setError(self::ERROR_TRANSPARENT);
					$this->imageModel->conversionFailed($conversionArgs);
					return false;
			 }

			 Log::addDebug('Starting PNG conversion of #' . $this->imageModel->get('id'));
			 $bool = $this->run();

			 if (true === $bool)
			 {
				  $params = array('success' => true);
        	$this->updateMetaData($params);

					$result = true;
					if (true === $args['runReplacer'])
					{
						$result = $this->replacer->replace();
					}

					if (is_array($result))
					{
							foreach($result as $error)
								 Notices::addError($error);
					}


					$this->imageModel->conversionSuccess($conversionArgs);

					// new hook.
					do_action('shortpixel/image/convertpng2jpg_success', $this->imageModel);

					return true;
			 }

			 $this->imageModel->conversionFailed($conversionArgs);

			 //legacy. Note at this point metadata has not been updated.
			 do_action('shortpixel/image/convertpng2jpg_after', $this->imageModel, $args);

			 return false;
		}

		public function getCheckSum()
		{
			 return intval($this->settingCheckSum);
		}


		protected function run()
		{
			do_action('shortpixel/image/convertpng2jpg_before', $this->imageModel);

			$img = $this->getPNGImage();
			$fs = \wpSPIO()->filesystem();

			$width = $this->imageModel->get('width');
			$height = $this->imageModel->get('height');

			// If imageModel doesn't have proper width / height set. This can happen with remote files.
			if (! is_int($width) && ! $width > 0)
			{
				 $width = imagesx($img);
			}
			if (! is_int($height) && ! $height > 0)
			{
				 $height = imagesx($img);
			}

			Log::addDebug("PNG2JPG doConvert width $width height $height", memory_get_usage());
			$bg = imagecreatetruecolor($width, $height);

			if(false === $bg || false === $img)
			{
				Log::addError('ImageCreateTrueColor failed');
				if (false === $bg)
				{
					$msg = __('Creating an TrueColor Image failed - Possible library error', 'shortpixel-image-optimiser');
				}
				elseif (false === $img)
				{
					$msg = __('Image source failed - Check if source image is PNG and library is working', 'shortpixel-image-optimiser');
				}

				$this->imageModel->getMeta()->convertMeta()->setError(self::ERROR_LIBRARY);
				ResponseController::addData($this->imageModel->get('id'), 'message', $msg);
				return false;
			}

			imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
			imagealphablending($bg, 1);
			imagecopy($bg, $img, 0, 0, 0, 0, $width, $height);

		//  $fsFile = $fs->getFile($image); // the original png file
		// @todo Add ResponseController support to here and getReplacementPath.
			$replacementPath = $this->getReplacementPath();
			if (false === $replacementPath)
			{
				Log::addWarn('Png2Jpg replacement path failed');
				$this->imageModel->getMeta()->convertMeta()->setError(self::ERROR_PATHFAIL);

				return false; // @todo Add ResponseController something here.
			}

			// check old filename, replace with uniqued filename.
			// @todo Probably not needed anymore
		//	$newUrl = str_replace($filename, $uniqueFile->getFileName(), $url);

			if ($bool = imagejpeg($bg, $replacementPath, 90)) {
					Log::addDebug("PNG2JPG doConvert created JPEG at $replacementPath");
					$newSize = filesize($replacementPath); // $uniqueFile->getFileSize();
					$origSize = $this->imageModel->getFileSize();

					// Reload the file we just wrote.
					$newFile = $fs->getFile($replacementPath);


					if($newSize > $origSize * 0.95 || $newSize == 0) {
							//if the image is not 5% smaller, don't bother.
							//if the size is 0, a conversion (or disk write) problem happened, go on with the PNG
							Log::addDebug("PNG2JPG converted image is larger ($newSize vs. $origSize), keeping the PNG");
							$msg = __('Converted file is larger. Keeping original file', 'shortpixel-image-optimiser');
							ResponseController::addData($this->imageModel->get('id'), 'message', $msg);
							$newFile->delete();
							$this->imageModel->getMeta()->convertMeta()->setError(self::ERROR_RESULTLARGER);

							return false;
					}
					elseif (! $newFile->exists())
					{
						 Log::addWarn('PNG imagejpeg file not written!', $uniqueFile->getFileName() );
						 $msg = __('Error - PNG file not written', 'shortpixel-image-optimiser');
						 ResponseController::addData($this->imageModel->get('id'), 'message', $msg);
						 $this->imageModel->getMeta()->convertMeta()->setError(self::ERROR_WRITEERROR);

						 return false;
					}
					else {
						$this->newFile = $newFile;
					}


					Log::addDebug('PNG2jPG Converted');
			}

			$fs->flushImageCache();

			return true;
		}

		public function restore()
		{
			$params = array(
				'restore' => true,
			);
			$fs = \wpSPIO()->filesystem();

			$this->setupReplacer();

			$oldFileName = $this->imageModel->getFileName(); // Old File Name, Still .jpg
			$newFileName =  $this->imageModel->getFileBase() . '.png';

			if ($this->imageModel->isScaled())
			{
				 $oldFileName = $this->imageModel->getOriginalFile()->getFileName();
				 $newFileName = $this->imageModel->getOriginalFile()->getFileBase() . '.png';
			}

			$fsNewFile = $fs->getFile($this->imageModel->getFileDir() . $newFileName);

			$this->newFile = $fsNewFile;
			$this->setTarget($fsNewFile);

			$this->updateMetaData($params);
			$result = $this->replacer->replace();

			$fs->flushImageCache();

		}

		protected function isTransparent() {
				$isTransparent = false;
				$transparent_pixel = $bg = false;

				$imagePath = $this->imageModel->getFullPath();

				// Check for transparency at the bit path.
				if(ord(file_get_contents($imagePath, false, null, 25, 1)) & 4) {
						Log::addDebug("PNG2JPG: 25th byte has third bit 1 - transparency");
						$isTransparent = true;
						//		return true;
				} else {

						$contents = file_get_contents($imagePath);
						if (stripos($contents, 'PLTE') !== false && stripos($contents, 'tRNS') !== false) {
								$isTransparent = true;
						}
						if (false === $isTransparent) {

								$width = $this->imageModel->get('width');
								$height = $this->imageModel->get('height');
								Log::addDebug("PNG2JPG Image width: " . $width . " height: " . $height . " aprox. size: " . round($width*$height*5/1024/1024) . "M memory limit: " . ini_get('memory_limit') . " USED: " . memory_get_usage());

								$image = $this->getPNGImage();
								if (false === $image)
								{
									 return false;
								}
								Log::addDebug("PNG2JPG width $width height $height. Now checking pixels.");
										//run through pixels until transparent pixel is found:
										for ($i = 0; $i < $width; $i++) {
												for ($j = 0; $j < $height; $j++) {
														$rgba = imagecolorat($image, $i, $j);
														if (($rgba & 0x7F000000) >> 24) {
																$isTransparent = true;
																break;
														}
												}
											}
						}
				} // non-transparant.

				Log::addDebug("PNG2JPG is " . (false ===  $isTransparent ? " not" : "") . " transparent");

				return $isTransparent;

		}

		/** Try to load resource and an PNG via library */
		protected function getPNGImage()
		{
			if (is_object($this->current_image))
			{
				 return $this->current_image;
			}

			if ($this->imageModel->isScaled())
			{
				$imagePath = $this->imageModel->getOriginalFile()->getFullPath();
			}
			else {
				$imagePath = $this->imageModel->getFullPath();
			}

			if (true === $this->imageModel->is_virtual())
			{
				$downloadHelper = DownloadHelper::getInstance();
				Log::addDebug('PNG converter: Item is remote, attempting to download');

				$tempFile = $downloadHelper->downloadFile($this->imageModel->getURL());
				if (is_object($tempFile))
				{
					 $imagePath = $tempFile->getFullPath();
				}
			}


			$image = @imagecreatefrompng($imagePath);
			if (! $image)
			{
				$this->current_image = false;
			}
			else
			{
				$this->current_image = $image;
			}

			return $this->current_image;
		}



		// Try to increase limits when doing heavy processing
    private function raiseMemoryLimit()
    {
      if(function_exists('wp_raise_memory_limit')) {
          wp_raise_memory_limit( 'image' );
      }
    }


} // class
