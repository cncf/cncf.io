<?php
namespace ShortPixel;
use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;

class UncodeController
{
	 function __construct()
	 {
		  $this->addHooks();
	 }

	 protected function addHooks()
	 {
		  add_action('uncode_delete_crop_image', array($this, 'removedMetaData'), 10, 2);
	 }

	 public function removedMetaData($attach_id, $filePath)
	 {
		  	$fs = \wpSPIO()->filesystem();
				$imageObj = $fs->getImage($attach_id, 'media', false);
				$imageObj->saveMeta();

				$fileObj = $fs->getFile($filePath);
				if ($fileObj->hasBackup())
				{
						$backupObj = $fileObj->getBackupFile();
						$backupObj->delete();
				}

				// Check Webp
				$webpObj = $fs->getFile( (string) $fileObj->getFileDir() . $fileObj->getFileBase() . '.webp');
				if ($webpObj->exists())
					 $webpObj->delete();

			  // Check Avif
 				$avifObj = $fs->getFile( (string) $fileObj->getFileDir() . $fileObj->getFileBase() . '.avif');
 				if ($avifObj->exists())
 					 $avifObj->delete();

	 }
}

$u = new UncodeController();
