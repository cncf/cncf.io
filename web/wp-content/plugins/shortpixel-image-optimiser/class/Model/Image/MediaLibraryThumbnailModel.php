<?php

namespace ShortPixel\Model\Image;
use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;

use \Shortpixel\Model\File\FileModel as FileModel;

// Represent a thumbnail image / limited image in mediaLibrary.
class MediaLibraryThumbnailModel extends \ShortPixel\Model\Image\ImageModel
{
  //abstract protected function saveMeta();
  //abstract protected function loadMeta();

  public $name;

/*  public $width;
  public $height;
  public $mime; */
  protected $prevent_next_try = false;
  protected $is_main_file = false;
	protected $is_retina = false; // diffentiate from thumbnail / retina.
  protected $id; // this is the parent attachment id
  protected $size; // size of image in WP, if applicable.

  public function __construct($path, $id, $size)
  {

        parent::__construct($path);
        $this->image_meta = new ImageThumbnailMeta();
        $this->id = $id;
				$this->imageType = self::IMAGE_TYPE_THUMB;
        $this->size = $size;
        $this->setWebp();
        $this->setAvif();
  }


  protected function loadMeta()
  {

  }

  protected function saveMeta()
  {

  }

  public function __debugInfo() {
     return array(
      'image_meta' => $this->image_meta,
      'name' => $this->name,
      'path' => $this->getFullPath(),
			'size' => $this->size,
      'exists' => ($this->exists()) ? 'yes' : 'no',

    );
  }

  /** Set the meta name of thumbnail. */
  public function setName($name)
  {
     $this->name = $name;
  }

	public function setImageType($type)
	{
		 $this->imageType = $type;
	}

  public function getRetina()
  {
			if ($this->is_virtual())
			{
				$fs = \wpSPIO()->filesystem();
				$filepath = apply_filters('shortpixel/file/virtual/translate', $this->getFullPath(), $this);
				$virtualFile = $fs->getFile($filepath);

				$filebase = $virtualFile->getFileBase();
	      $filepath = (string) $virtualFile->getFileDir();
	      $extension = $virtualFile->getExtension();
			}
			else {
				$filebase = $this->getFileBase();
	      $filepath = (string) $this->getFileDir();
	      $extension = $this->getExtension();
			}

      $retina = new MediaLibraryThumbnailModel($filepath . $filebase . '@2x.' . $extension, $this->id, $this->size); // mind the dot in after 2x
			$retina->setName($this->size);
			$retina->setImageType(self::IMAGE_TYPE_RETINA);

			$retina->is_retina = true;

			$forceCheck = true;
      if ($retina->exists($forceCheck))
        return $retina;

      return false;
  }



  public function isFileTypeNeeded($type = 'webp')
  {
      // pdf extension can be optimized, but don't come with these filetypes
      if ($this->getExtension() == 'pdf')
      {
        return false;
      }

      if ($type == 'webp')
        $file = $this->getWebp();
      elseif ($type == 'avif')
        $file = $this->getAvif();

      if ( ($this->isThumbnailProcessable() || $this->isOptimized()) && $file === false)  // if no file, it can be optimized.
        return true;
      else
        return false;
  }


	// @param FileDelete can be false. I.e. multilang duplicates might need removal of metadata, but not images.
  public function onDelete($fileDelete = true)
  {
			if ($fileDelete == true)
      	$bool = parent::onDelete();
			else {
				$bool = true;
			}

			// minimally reset all the metadata.
			if ($this->is_main_file)
			{
				 $this->image_meta = new ImageMeta();
			}
			else {
					$this->image_meta = new ImageThumbnailMeta();
			}

			return $bool;
  }



  protected function setMetaObj($metaObj)
  {
     $this->image_meta = clone $metaObj;
  }

  protected function getMetaObj()
  {
    return $this->image_meta;
  }



	// get_path param see MediaLibraryModel
	// This should be unused at the moment!
  public function getOptimizeUrls()
  {
    if (! $this->isProcessable() )
      return false;

		$url = $this->getURL();

    if (! $url)
		{
      return false; //nothing
		}

    return $url;
  }

  public function getURL()
  {
			$fs = \wpSPIO()->filesystem();

      if ($this->size == 'original' && ! $this->get('is_retina'))
			{
        $url = wp_get_original_image_url($this->id);
			}
      elseif ($this->isUnlisted())
			{
				$url = $fs->pathToUrl($this);
			}
			else
			{
				// We can't trust higher lever function, or any WP functions.  I.e. Woocommerce messes with the URL's if they like so.
				// So get it from intermediate and if that doesn't work, default to pathToUrl - better than nothing.
				// https://app.asana.com/0/1200110778640816/1202589533659780
				$size_array = image_get_intermediate_size($this->id, $this->size);

				if ($size_array === false || ! isset($size_array['url']))
				{
					 $url = $fs->pathToUrl($this);
				}
				elseif (isset($size_array['url']))
				{
					 $url = $size_array['url'];
					 // Even this can go wrong :/
					 if (strpos($url, $this->getFileName() ) === false)
					 {
						 // Taken from image_get_intermediate_size if somebody still messes with the filters.
							$mainurl = wp_get_attachment_url( $this->id);
							$url = path_join( dirname( $mainurl ), $this->getFileName() );
					 }
				}
				else {
						return false;
				}

			}

      return $this->fs()->checkURL($url);
  }

  // Just a placeholder for abstract, shouldn't do anything.
  public function getImprovements()
  {
     return parent::getImprovements();
  }


	public function getBackupFileName()
	{
			$mainFile = ($this->is_main_file) ? $this : $this->getMainFile();
			if (false == $mainFile)
			{
				return parent::getBackupFileName();
			}

		  if ($mainFile->getMeta()->convertMeta()->getReplacementImageBase() !== false)
			{
				 if ($this->is_main_file)
				 	return $mainFile->getMeta()->convertMeta()->getReplacementImageBase() . '.' . $this->getExtension();
				else {
//					 $fileBaseNoSize =
					 $name = str_replace($mainFile->getFileBase(), $mainFile->getMeta()->convertMeta()->getReplacementImageBase(), $this->getFileName());
					 Log::addDebug('New Thumbnail Backup Name: ' .  $name);
					 return $name;
				}
			}


			return parent::getBackupFileName();
	}


  protected function preventNextTry($reason = '')
  {
      $this->prevent_next_try = $reason;
  }

  // Don't ask thumbnails this, only the main image
  public function isOptimizePrevented()
  {
     return false;
  }

  // Don't ask thumbnails this, only the main image
  public function resetPrevent()
  {
     return null;
  }

  protected function isThumbnailProcessable()
  {
			// if thumbnail processing is off, thumbs are never processable.
			// This is also used by main file, so check for that!

      if ( $this->excludeThumbnails() && $this->is_main_file === false && $this->get('imageType') !== self::IMAGE_TYPE_ORIGINAL)
			{
				$this->processable_status = self::P_EXCLUDE_SIZE;
        return false;
			}
      else
      {
        $bool = parent::isProcessable();

				return $bool;
      }
  }

	/** Function to check if said thumbnail is a WP-native or something SPIO added as unlisted
	*
	*
	*/
	protected function isUnlisted()
	{
		 	 if (! is_null($this->getMeta('file')))
			 	return true;
			else
				return false;
	}


  // !Important . This doubles as  checking excluded image sizes.
  protected function isSizeExcluded()
  {
		if (true === $this->is_main_file)
		{
				return parent::isSizeExcluded();
		}

    $excludeSizes = \wpSPIO()->settings()->excludeSizes;
    if (is_array($excludeSizes) && in_array($this->name, $excludeSizes))
		{
			$this->processable_status = self::P_EXCLUDE_SIZE;
      return true;
		}
		return false;
	}

	public function isProcessableFileType($type = 'webp')
	{
			// Prevent webp / avif processing for thumbnails if this is off. Exclude main file
		  if ($this->excludeThumbnails() === true && $this->is_main_file === false )
				return false;

			return parent::isProcessableFileType($type);
	}

  protected function excludeThumbnails()
  {
    return (! \wpSPIO()->settings()->processThumbnails);
  }

  public function hasBackup($args = array())
  {
			$defaults = array(
				'forceConverted' => false,
				'noConversionCheck' => false,  // do not check on mainfile, this loops when used in loadMeta / legacyConversion
			);
			$args = wp_parse_args($args, $defaults);

			// @todo This can probably go.
			if (true === $args['noConversionCheck'])
			{
				return parent::hasBackup();
			}

			$mainFile = ($this->is_main_file) ? $this : $this->getMainFile();
			if (false == $mainFile)
			{
				return parent::hasBackup();

			}

			// When main file and converted and omitBackup is true ( only original backup ) and not forced.
			$loadRegular= (false === $mainFile->getMeta()->convertMeta()->isConverted() ||
			false === $mainFile->getMeta()->convertMeta()->omitBackup()) && false === $args['forceConverted'];

      if (true === $loadRegular)
      {
          return parent::hasBackup();
      }
      else
      {
        $directory = $this->getBackupDirectory();
				$converted_ext = $mainFile->getMeta()->convertMeta()->getFileFormat();

        if (! $directory)
          return false;


        $backupFile =  $directory . $this->getFileBase() . '.' . $converted_ext;

				// Issue with PNG not being scaled on the main file.
				if (! file_exists($backupFile) && $mainFile->isScaled())
				{
					 $backupFile = $directory . $mainFile->getOriginalFile()->getFileBase() . '.' . $converted_ext;
				}
        if (file_exists($backupFile) && ! is_dir($backupFile) )
          return true;
        else {
          return false;
        }
      }
  }

	public function hasDBRecord()
	{
			global $wpdb;


			$sql = 'SELECT id FROM ' . $wpdb->prefix . 'shortpixel_postmeta WHERE attach_id = %d AND size = %s';
			$sql = $wpdb->prepare($sql, $this->id, $this->size);

			$id = $wpdb->get_var($sql);

			if (is_null($id))
			{
				 return false;
			}
			elseif (is_numeric($id)) {
				return true;
			}

	}

  public function restore()
  {
    if ($this->is_virtual())
    {
       $fs = \wpSPIO()->filesystem();
       $filepath = apply_filters('shortpixel/file/virtual/translate', $this->getFullPath(), $this);

       $this->setVirtualToReal($filepath);
    }

    $bool = parent::restore();

		if ($bool === true)
		{
			 if ($this->is_main_file)
			 {
				 	// If item is converted and will not be moved back to original format ( but converted ) , keep the convert metadata
				  if (true === $this->getMeta()->convertMeta()->isConverted() && false === $this->getMeta()->convertMeta()->omitBackup() )
					{
							$convertMeta = clone $this->getMeta()->convertMeta();
							$imageMeta = new ImageMeta();
							$imageMeta->convertMeta()->fromClass($convertMeta);
							$bool = false; // Prevent cleanRestore from deleting the metadata.
					}
					else {
							$imageMeta = new ImageMeta();
					}

					$this->image_meta = $imageMeta;
			 }
			 else
			 {
				 $this->image_meta = new ImageThumbNailMeta();
			 }
		}

		return $bool;
  }

	/** Tries to retrieve an *existing* BackupFile. Returns false if not present.
  * This file might not be writable.
  * To get writable directory reference to backup, use FileSystemController
  */
  public function getBackupFile($args = array())
  {

		$defaults = array(
			'forceConverted' => false,
			'noConversionCheck' => false,  // do not check on mainfile, this loops when used in loadMeta / legacyConversion
		);
		$args = wp_parse_args($args, $defaults);

		if (true === $args['noConversionCheck'])
		{
			return parent::getBackupFile();
		}

		$mainFile = ($this->is_main_file) ? $this : $this->getMainFile();
		if (false == $mainFile)
		{
			return parent::getBackupFile();

		}
		// When main file and converted and omitBackup is true ( only original backup ) and not forced.
		$loadRegular= (false === $mainFile->getMeta()->convertMeta()->isConverted() ||
		false === $mainFile->getMeta()->convertMeta()->omitBackup()) && false === $args['forceConverted'];

		if (true === $loadRegular )
    {
        return parent::getBackupFile();
    }
    else
    {
     if ($this->hasBackup($args))
		 {

			  $directory = $this->getBackupDirectory();
				$converted_ext = $mainFile->getMeta()->convertMeta()->getFileFormat();

			  $backupFile = $directory . $this->getFileBase() . '.' . $converted_ext;

				/* Because WP doesn't support big PNG with scaled for some reason, it's possible it doesn't create them. Which means we end up with a scaled images without backup */
 				if (! file_exists($backupFile) && $mainFile->isScaled())
 				{
 					 $backupFile = $directory . $mainFile->getOriginalFile()->getFileBase() . '.' . $converted_ext;
 				}

				return new FileModel($backupFile);

		 }
     else
       return false;
    }
  }

  protected function createBackup()
  {
    if ($this->is_virtual()) // download remote file to backup.
    {
      $fs = \wpSPIO()->filesystem();
      $filepath = apply_filters('shortpixel/file/virtual/translate', $this->getFullPath(), $this);

      $result = $fs->downloadFile($this->getURL(), $filepath); // download remote file for backup.

      if ($result == false)
      {
        $this->preventNextTry(__('Fatal Issue: Remote virtual file could not be downloaded for backup', 'shortpixel-image-optimiser'));
        Log::addError('Remote file download failed to: ' . $filepath, $this->getURL());
        $this->error_message = __('Remote file could not be downloaded' . $this->getFullPath(), 'shortpixel-image-optimiser');

        return false;
      }

      $this->setVirtualToReal($filepath);
    }

    return parent::createBackup();

  }

  private function setVirtualToReal($fullpath)
  {
    $this->resetStatus();
    $this->fullpath = $fullpath;
    $this->directory = null; //reset directory
    $this->is_virtual = false; // stops being virtual
    $this->setFileInfo();
  }

	// @todo This is a breach of pattern to realize checking for changes to the main image path on conversion / duplicates.
	private function getMainFile()
	{
			$fs = \wpSPIO()->filesystem();
			return $fs->getMediaImage($this->id, true, true);
	}






} // class
