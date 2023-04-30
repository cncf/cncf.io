<?php
 namespace ShortPixel;

 use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;
 use ShortPixel\Model\Image\ImageModel as ImageModel;
 use ShortPixel\Model\Image\MediaLibraryModel as MediaLibraryModel;
 use ShortPixel\Model\File\DirectoryModel as DirectoryModel;
 use ShortPixel\Model\File\FileModel as FileModel;

 use ShortPixel\Replacer\Replacer as Replacer;
 use ShortPixel\Notices\NoticeController as Notices;

 //use ShortPixel\Model\FileModel as FileModel;
 //use ShortPixel\Model\Directorymodel as DirectoryModel;

//TODO decouple from directly using WP metadata, in order to be able to use it for custom images
class ShortPixelPng2Jpg {

    private $current_image;
		private $replacer;

		private $reason;

    public function __construct()
    {

    }

    public function convert(ImageModel $imageObj)
    {
         $settings = \wpSPIO()->settings();
				 $env = \wpSPIO()->env();
				 $fs = \wpSPIO()->filesystem();

         // check for possible conversion. From system heaviest to lowest.
         if ($settings->png2jpg == 0) // conversion is off
          return false;

         if (! $imageObj->getExtension() == 'png') // not a png ext. fail silently.
           return false;

				if ($env->is_gd_installed === false)
				{
					 Log::addWarn('Convert in png2jpg called without proper installation of GD! . Aborting ');
					 return false;
				}

					$this->raiseMemoryLimit();
          $this->current_image = $this->getPNGImage($imageObj);

          if (is_null($this->current_image)) // image creation failed. @todo Error back
             return false;

          if ($this->isTransparent($imageObj) && $settings->png2jpg < 2) // 2 means force conversion for transparent images.
             return false;

					$this->replacer = new Replacer();

					$this->replacer->setSource($fs->pathToUrl($imageObj));
					if ($imageObj->get('type') == 'media')
					{
						 $this->replacer->setSourceMeta($imageObj->getWPMetaData());
					}

          // Returns an Array with success or not, new file name.
          $result = $this->doConvertPng2Jpg($imageObj);
          if ($result !== false && is_array($result))
          {

             if ($result['success'])
             {
							 $this->replacer->setTarget($result['target_url']);

               $res = $this->updateMetaData($result, $imageObj);
               if ($res === false)
							 {
                 Log::addWarn('Png2Jpg Update Metadata failed');
							 }
							 else
							 {
					 				$this->replacer->setTargetMeta($res);

							 }
               $file = $result['file'];

							 // All is done, run the replacer.
							 $result = $this->replacer->replace();

							 if (is_array($result))
							 {
									 foreach($result as $error)
									 	  Notices::addError($error);
							 }

							 // new hook.
							 do_action('shortpixel/image/convertpng2jpg_success', $imageObj);

							  return true;
             } // success

          } // result.
					else
					{
						return false;
					}

        //  return $imageObj;
        return true;
    }


    protected function isTransParent(ImageModel $imageObj) {
        $transparent = 0;
        $transparent_pixel = $img = $bg = false;


        $imagePath = $imageObj->getFullPath();
        $contents = file_get_contents($imagePath);

        if(ord(file_get_contents($imagePath, false, null, 25, 1)) & 4) {
            Log::addDebug("PNG2JPG: 25th byte has third bit 1 - transparency");
            $transparent = 1;
            return true;
        } else {

            if (stripos($contents, 'PLTE') !== false && stripos($contents, 'tRNS') !== false) {
                $transparent = 1;
            }
            if (!$transparent) {

                //$is = getimagesize($image);
                $width = $imageObj->get('width');
                $height = $imageObj->get('height');
                Log::addDebug("PNG2JPG Image width: " . $width . " height: " . $height . " aprox. size: " . round($width*$height*5/1024/1024) . "M memory limit: " . ini_get('memory_limit') . " USED: " . memory_get_usage());
                if (is_null($this->current_image))
                   $img = $this->getPNGImage($imageObj);
                else
                   $img = $this->current_image; //imagecreatefrompng($imageObj->getFullPath());

                if (is_null($img)) // still error, bye.
                  return false;

                Log::addDebug("PNG2JPG created from png");

                    Log::addDebug("PNG2JPG is PNG");
                    $w = imagesx($img); // Get the width of the image
                    $h = imagesy($img); // Get the height of the image
                    Log::addDebug("PNG2JPG width $w height $h. Now checking pixels.");
                    //run through pixels until transparent pixel is found:
                    for ($i = 0; $i < $w; $i++) {
                        for ($j = 0; $j < $h; $j++) {
                            $rgba = imagecolorat($img, $i, $j);
                            if (($rgba & 0x7F000000) >> 24) {
                                $transparent_pixel = true;
                                return true;
                                break;
                            }
                        }
                      }
            }
        } // non-transparant.

        Log::addDebug("PNG2JPG is " . (!$transparent && !$transparent_pixel ? " not" : "") . " transparent");
        //pass on the img too, if it was already loaded from PNG, matter of performance
        //return array('notTransparent' => !$transparent && !$transparent_pixel, 'img' => $img);
        if ($transparent || $transparent_pixel)
          return true;
        else
          return false;
    }

    /** Try to load resource and an PNG via library */
    protected function getPNGImage($imageObj)
    {
      $image = @imagecreatefrompng($imageObj->getFullPath());
      if (! $image)
        return null;
      else
      {
        return $image;
      }
    }

    /**
     *
     * @param array $params
     * @param string $backupPath
     * @param string $suffixRegex for example [0-9]+x[0-9]+ - a thumbnail suffix - to add the counter of file name collisions files before that suffix (img-2-150x150.jpg).
     * @param image $img - the image if it was already created from png. It will be destroyed at the end.
     * @return string
     */

    protected function doConvertPng2Jpg($imageObj) {
        do_action('shortpixel/image/convertpng2jpg_before', $imageObj);

        $fs = \wpSPIO()->filesystem();
        $settings = \wpSPIO()->settings();

        $img = $this->current_image;

        $url = $fs->pathToUrl($imageObj);
        $params = array();
        $params['success'] = false;
        $params['file'] = $imageObj;

        $x = imagesx($img);
        $y = imagesy($img);
        Log::addDebug("PNG2JPG doConvert width $x height $y", memory_get_usage());
        $bg = imagecreatetruecolor($x, $y);
        if(!$bg)
        {
          Log::addError('ImageCreateTrueColor failed');
          return false;
        }

        imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
        imagealphablending($bg, 1);
        imagecopy($bg, $img, 0, 0, 0, 0, $x, $y);
    //    imagedestroy($img);
        //$newPath = preg_replace("/\.png$/i", ".jpg", $image);

      //  $fsFile = $fs->getFile($image); // the original png file
        $filename = $imageObj->getFileName();
        $newFileName = $imageObj->getFileBase() . '.jpg'; // convert extension to .png

        $fsNewFile = $fs->getFile($imageObj->getFileDir() . $newFileName);

        $uniqueFile = $this->unique_file( $imageObj->getFileDir(), $fsNewFile);
        $newPath =  $uniqueFile->getFullPath(); //(string) $fsFile->getFileDir() . $uniquepath;

        if (! $imageObj->getFileDir()->is_writable())
        {
          Log::addWarn('Replacement path for PNG not writable ' . $imageObj->getFileDir()->getPath());
          return false;
        }

        // check old filename, replace with uniqued filename.
        // @todo Probably not needed anymore
        $newUrl = str_replace($filename, $uniqueFile->getFileName(), $url); //preg_replace("/\.png$/i", ".jpg", $params['url']);

        if ($bool = imagejpeg($bg, $newPath, 90)) {
            Log::addDebug("PNG2JPG doConvert created JPEG at $newPath");
            $newSize = filesize($newPath); // $uniqueFile->getFileSize();
            $origSize = $imageObj->getFileSize();

						// Reload the file we just wrote.
						$newFile = $fs->getFile($newPath);

            if($newSize > $origSize * 0.95 || $newSize == 0) {
                //if the image is not 5% smaller, don't bother.
                //if the size is 0, a conversion (or disk write) problem happened, go on with the PNG
                Log::addDebug("PNG2JPG converted image is larger ($newSize vs. $origSize), keeping the PNG");
                //unlink($newPath);

						//		$newFile = $fs->getFile($newPath);
								$newFile->delete();
								return false;
            }


            if (! $newFile->exists())
						{
               Log::addWarn('PNG imagejpeg file not written!', $uniqueFile->getFileName() );
							 $params['success'] = false;
						}
						else
						{
            	$params['success'] = true;
            	$params['file'] = $uniqueFile;
        //    $params['old_url'] = $url;
            	$params['target_url'] = $newUrl;

						}

						Log::addDebug('PNG2jPG Converted', $params);
        }

				//legacy. Not at this point metadata has not been updated.
        do_action('shortpixel/image/convertpng2jpg_after', $imageObj, $params);
        return $params;
    }

    /** Own function to get a unique filename since the WordPress wp_unique_filename seems to not function properly w/ thumbnails */
    private function unique_file(DirectoryModel $dir, FileModel $file, $number = 0)
    {
      if (! $file->exists())
        return $file;

      $number = 0;
      $fs = \wpSPIO()->filesystem();

      $base = $file->getFileBase();
      $ext = $file->getExtension();

      while($file->exists())
      {
        $number++;
        $numberbase = $base . '-' . $number;
        Log::addDebug('check for unique file -- ' . $dir->getPath() . $numberbase . '.' . $ext);
        $file = $fs->getFile($dir->getPath() . $numberbase . '.' . $ext);
      }

      return $file;
    }


    /**
     * Convert an uploaded image from PNG to JPG
     * @param type $params ( file, url, type )  - Connected to https://developer.wordpress.org/reference/hooks/wp_handle_upload/
     * @return string
     */
    public function convertPng2Jpg($params) {
        $settings = \wpSPIO()->settings();
        $fs = \wpSPIO()->filesystem();

        $image = isset($params['file']) ? $params['file'] : false;

        if (! $image)
          return $params;

        $imageObj = $fs->getFile($params['file']);

        if(!$settings->png2jpg || $imageObj->getExtension() !== '.png') {
            return $params;
        }

        Log::addDebug("Convert Media PNG to JPG on upload: {$image}");

        $ret = $this->doConvertPng2Jpg($params, $settings->backupImages, false, isset($ret['img']) ? $ret['img'] : false);
        if($ret->unlink) @unlink($ret->unlink);
        $paramsC = $ret->params;
        if($paramsC['type'] == 'image/jpeg') {
            // we don't have metadata, so save the information in a temporary map
            $conv = $settings->convertedPng2Jpg;
            //do a cleanup first
            foreach($conv as $key => $val) {
                if(time() - $val['timestamp'] > 3600) unset($conv[$key]);
            }
            $conv[$paramsC['file']] = array('pngFile' => $paramsC['original_file'], 'backup' => $settings->backupImages,
                'optimizationPercent' => round(100.0 * (1.00 - $paramsC['jpg_size'] / $paramsC['png_size'])),
                'timestamp' => time());
            $settings->convertedPng2Jpg = $conv;
        }
        return $paramsC;

      //  return $params;
    }

		/*
		* @param $imageObj Object will come to us, still in old .jpg format, while the file on the drive might / should also have returned to it's .png backup state. $imageObj is expected to serve outdated information, which will build the source.
		*/
		public function restorePng2Jpg(ImageModel $imageObj)
		{
					$params = array('restore' => true);
					$fs = \wpSPIO()->filesystem();

					// This URL will be the 'base URL' in the replacement.
					$url = $fs->pathToUrl($imageObj);

					if ($imageObj->isScaled())
					{
						$url = $fs->pathToUrl($imageObj->getOriginalFile());
					}

					$this->replacer = new Replacer();
					$this->replacer->setSource($url);

					if ($imageObj->get('type') == 'media') // old stuff
					{
						 $this->replacer->setSourceMeta($imageObj->getWPMetaData());
					}

					// @todo Combine this script with the one at doConvertPng2Jpg into a function. Perhaps.
					$oldFileName = $imageObj->getFileName(); // Old File Name, Still .jpg
					$newFileName =  $imageObj->getFileBase() . '.png';

					if ($imageObj->isScaled())
					{
						 $oldFileName = $imageObj->getOriginalFile()->getFileName();
						 $newFileName = $imageObj->getOriginalFile()->getFileBase() . '.png';
					}

					$fsNewFile = $fs->getFile($imageObj->getFileDir() . $newFileName);

        	$newUrl = str_replace($oldFileName, $fsNewFile->getFileName(), $url);

					$params['file'] = $fsNewFile;

					$result = $this->updateMetaData($params, $imageObj);

					if ($result !== false)
					{
					 	$this->replacer->setTarget($newUrl);
						$this->replacer->setTargetMeta($result);
						$this->replacer->replace();
				 	}
		}

/*
    protected function updateMetaData($params, ImageModel $imageObj)
    {
        if (! isset($params['success']) && ! isset($params['restore']))
          return false;

        $newFile = $params['file'];
        $attach_id = $imageObj->get('id');

				$WPMLduplicates = $imageObj->getWPMLDuplicates();

				// This action prevents images from being regenerated on the thumbnail hook.
			  	do_action('shortpixel-thumbnails-before-regenerate', $attach_id );

        // Update attached_file
        $bool = update_attached_file($attach_id, $newFile->getFullPath() );
        if (! $bool)
          return false;

        // Update post mime on attachment
				if (isset($params['success']))
        	$post_ar = array('ID' => $attach_id, 'post_mime_type' => 'image/jpeg');
				elseif ( isset($params['restore']) )
					$post_ar = array('ID' => $attach_id, 'post_mime_type' => 'image/png');

        $result = wp_update_post($post_ar);
        if ($result === 0 || is_wp_error($result))
				{
				  Log::addError('Issue updating WP Post png2jpg - ' . $attach_id);
          return false;
				}

        $metadata = wp_get_attachment_metadata($attach_id);

        $new_metadata = wp_generate_attachment_metadata($attach_id, $newFile->getFullPath());

				// Metadata might not be array when add_attachment is calling this hook via AdminController ( PNG2JPG)
				if (is_array($metadata))
				{
					// Original Image in the new situation can not be there. Don't preserve it.
					if (isset($metadata['original_image']) && ! isset($new_metadata['original_image']) )
					{
						 	unset($metadata['original_image']);
					}

        	$new_metadata = array_merge($metadata, $new_metadata); // merge to preserve other custom metadata

				}
        Log::addDebug('Png2Jpg New Metadata' . $attach_id, $new_metadata);
		//		wp_update_post(array('ID' => $attach_id, 'post_mime_type' => 'image/jpeg' ));
        $bool = wp_update_attachment_metadata($attach_id, $new_metadata);


				if (is_array($WPMLduplicates) && count($WPMLduplicates) > 0)
				{
					 foreach ($WPMLduplicates as $duplicate_id)
					 {
						  update_attached_file($duplicate_id, $newFile->getFullPath() );
							wp_update_attachment_metadata($duplicate_id, $new_metadata);

							$post_ar["ID"]  = $duplicate_id;
							wp_update_post($post_ar);
					 }
				}

        return $new_metadata;

    }
*/

    // Try to increase limits when doing heavy processing
    private function raiseMemoryLimit()
    {
      if(function_exists('wp_raise_memory_limit')) {
          wp_raise_memory_limit( 'image' );
      }
    }


} // class
