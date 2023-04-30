<?php
namespace ShortPixel\Model\Image;
use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;

use ShortPixel\Controller\ResponseController as ResponseController;
use ShortPixel\Controller\ApiController as API;

use Shortpixel\Model\File\FileModel as FileModel;
use ShortPixel\Model\AccessModel as AccessModel;

use ShortPixel\Model\Converter\Converter as Converter;

/* ImageModel class.
*
*
* - Represents a -single- image entity *not file*.
* - Can be either MediaLibrary, or Custom .
* - Not a replacement of Meta, but might be.
* - Goal: Structural ONE method calls of image related information, and combining information. Same task is now done on many places.
* -- ShortPixel Class should be able to blindly call model for information, correct metadata and such.
*/

abstract class ImageModel extends \ShortPixel\Model\File\FileModel
{
    // File Status Constants
    const FILE_STATUS_ERROR = -1;
    const FILE_STATUS_UNPROCESSED = 0;
    const FILE_STATUS_PENDING = 1;
    const FILE_STATUS_SUCCESS = 2;
    const FILE_STATUS_RESTORED = 3;
    const FILE_STATUS_TORESTORE = 4; // Used for Bulk Restore

    // Compression Option Consts
    const COMPRESSION_LOSSLESS = 0;
    const COMPRESSION_LOSSY = 1;
    const COMPRESSION_GLOSSY = 2;

    // Extension that we process .
    const PROCESSABLE_EXTENSIONS = array('jpg', 'jpeg', 'gif', 'png', 'pdf');

    //
    const P_PROCESSABLE = 0;
    const P_FILE_NOT_EXIST  = 1;
    const P_EXCLUDE_EXTENSION = 2;
    const P_EXCLUDE_SIZE  = 3;
    const P_EXCLUDE_PATH  = 4;
    const P_IS_OPTIMIZED = 5;
    const P_FILE_NOTWRITABLE = 6;
		const P_BACKUPDIR_NOTWRITABLE = 7;
		const P_BACKUP_EXISTS = 8;
		const P_OPTIMIZE_PREVENTED = 9;
		const P_DIRECTORY_NOTWRITABLE = 10;


		// For restorable status
		const P_RESTORABLE = 109;
		const P_BACKUP_NOT_EXISTS = 110;
		const P_NOT_OPTIMIZED = 111;

		const IMAGE_TYPE_MAIN = 0;
		const IMAGE_TYPE_THUMB = 1;
		const IMAGE_TYPE_ORIGINAL = 2;
		const IMAGE_TYPE_RETINA = 3;
		const IMAGE_TYPE_DUPLICATE = 4;

		const FILETYPE_BIGGER = -10;

    protected $image_meta; // metadata Object of the image.
		protected $recordChanged = false;

    // ImageModel properties are not stored but is generated data.  Only storage should happen to the values in Meta.
		/** @var string */
    protected $width;

		/** @var string */
    protected $height;

		/** @var string */
    protected $mime;
   // protected $url; // possibly not in use.

	  /** @var string */
    protected $error_message;

		/** @var int */
    protected $id;

		/** @var string */
		protected $imageType;

		/** @var int */
    protected $processable_status = 0;

		/** @var int */
		protected $restorable_status = 0;

		// Public var that can be set by OptimizeController to prevent double queries.
		/** @var boolean */
		public $is_in_queue;

    abstract public function getOptimizeUrls();
    abstract protected function saveMeta();
    abstract protected function loadMeta();

    abstract protected function getImprovements();
   // abstract protected function getOptimizeFileType();

    // Function to prevent image from doing anything automatically - after fatal error.
    abstract protected function preventNextTry($reason = '');
    abstract public function isOptimizePrevented();
    abstract public function resetPrevent(); // to get going.

    // Construct
    public function __construct($path)
    {
      parent::__construct($path);
    }

    protected function setImageSize()
    {
      $this->width = false;  // to prevent is_null check on get to loop if something is off.
      $this->height = false;

      if (! $this->isExtensionExcluded() && $this->isImage() && $this->is_readable() && ! $this->is_virtual() )
      {
         list($width, $height) = @getimagesize($this->getFullPath());
         if ($width)
         {
          $this->width = $width;
         }
         if ($height)
         {
          $this->height = $height;
         }
      }

    }
    /* Check if an image in theory could be processed. Check only exclusions, don't check status etc */
    public function isProcessable()
    {
        if ( $this->isOptimized() || ! $this->exists()  || $this->isPathExcluded() || $this->isExtensionExcluded() || $this->isSizeExcluded() || (! $this->is_virtual() && ! $this->is_writable()) || (! $this->is_virtual() && ! $this->is_directory_writable())
				|| $this->isOptimizePrevented() !== false  )
        {
          if(! $this->is_writable() && $this->processable_status == 0)
					{
            $this->processable_status = self::P_FILE_NOTWRITABLE;
					}
					elseif(! $this->is_directory_writable() && $this->processable_status == 0)
					{
            $this->processable_status = self::P_DIRECTORY_NOTWRITABLE;
					}
          return false;
        }
        else
				{
					$this->processable_status = 0;
          return true;
				}
    }

    public function isProcessableFileType($type = 'webp')
    {
        $settings = \WPSPIO()->settings();

				if ( AccessModel::getInstance()->isFeatureAvailable($type) === false)
				{
					 return false;
				}

				if ($type == 'webp' && ! $settings->createWebp)
          return false;

        if ($type == 'avif' && ! $settings->createAvif)
            return false;

				// Pdf, no special files.
				if ($this->getExtension() == 'pdf')
					return false;

				$imgObj = $this->getImageType($type);

				// if this image doesn't have webp / avif, it can be processed.
        if ($imgObj === false && $this->getMeta($type) !== self::FILETYPE_BIGGER)
          return true;
        else
          return false;
    }

		public function isProcessableAnyFileType()
		{
			  $webp = $this->isProcessableFileType('webp');
				$avif = $this->isProcessableFileType('avif');

				if ($webp === false && $avif === false)
					return false;
				else {
					return true;
				}
		}



    public function exists($forceCheck = false)
    {
       $result = parent::exists($forceCheck);
       if ($result === false)
       {
          $this->processable_status = self::P_FILE_NOT_EXIST;
       }
       return $result;
    }

		/** In time this should replace the other. This one added for semantic reasons. */
		public function getReason($name = 'processable')
		{
				$status = null;

			 if ($name == 'processable')
			 	$status = $this->processable_status;
			 elseif($name == 'restorable')
			 	$status = $this->restorable_status;

			 return $this->getProcessableReason($status);
		}

    public function getProcessableReason($status = null)
    {
      $message = false;
			$status = (! is_null($status)) ? $status : $this->processable_status;

      switch($status)
      {
         case self::P_PROCESSABLE:
            $message = __('Image Processable', 'shortpixel-image-optimiser');
         break;
         case self::P_FILE_NOT_EXIST:
            $message = __('File does not exist', 'shortpixel-image-optimiser');
         break;
         case self::P_EXCLUDE_EXTENSION:
            $message = __('Image Extension not processable', 'shortpixel-image-optimiser');
         break;
         case self::P_EXCLUDE_SIZE:
            $message = __('Image Size Excluded', 'shortpixel-image-optimiser');
         break;
         case self::P_EXCLUDE_PATH:
            $message = __('Image Excluded', 'shortpixel-image-optimiser');
         break;
         case self::P_IS_OPTIMIZED:
            $message = __('Image is already optimized', 'shortpixel-image-optimiser');
         break;
         case self::P_FILE_NOTWRITABLE:
            $message = sprintf(__('Image %s is not writable in %s', 'shortpixel-image-optimiser'), $this->getFileName(), (string) $this->getFileDir());
         break;
				 case self::P_DIRECTORY_NOTWRITABLE:
						$message = sprintf(__('Image directory %s is not writable', 'shortpixel-image-optimiser'), (string) $this->getFileDir());
				 break;
				 case self::P_BACKUPDIR_NOTWRITABLE:
				 		$message = __('Backup directory is not writable', 'shortpixel-image-optimiser');
				 break;
				 case self::P_BACKUP_EXISTS:
				 		$message = __('Backup already exists', 'shortpixel-image-optimiser');
				 break;
				 case self::P_OPTIMIZE_PREVENTED:
				 		$message = __('Fatal error preventing processing', 'shortpixel-image-optimiser');
						if (property_exists($this, 'optimizePreventedReason'))
						$message = $this->get('optimizePreventedReason');
				 break;
				 // Restorable Reasons
				 case self::P_RESTORABLE:
				 		$message = __('Image restorable', 'shortpixel-image-optimiser');
				 break;
				 case self::P_BACKUP_NOT_EXISTS:
				 		$message = __('Backup does not exist', 'shortpixel-image-optimiser');
				 break;
				 case self::P_NOT_OPTIMIZED:
				 		$message = __('Image is not optimized', 'shortpixel-image-optimiser');
				 break;
         default:
            $message = __(sprintf('Unknown Issue, Code %s',  $this->processable_status), 'shortpixel-image-optimiser');
         break;
      }

      return $message;
    }

    public function isImage()
    {
        if (! $this->exists())
          return false;
        if ($this->is_virtual()) // if virtual, don't filecheck on image.
        {
            if (! $this->isExtensionExcluded() )
              return true;
            else
              return false;
        }

				if (! is_null($this->mime))
				{
					return true;
				}

				if (\wpSPIO()->env()->is_function_usable('finfo_open')) // Faster function for getting mime types
					 {
						 $fileinfo = finfo_open(FILEINFO_MIME_TYPE);
						 $this->mime = finfo_file($fileinfo, $this->getFullPath());
						 finfo_close($fileinfo);
					 	 //FILEINFO_MIME_TYPE
					}
					elseif(\wpSPIO()->env()->is_function_usable('mime_content_type')) {
						$this->mime = mime_content_type($this->getFullPath());
					}
					else {
						return true; // assume without check, that extension says what it is.
						// @todo This should probably trigger a notice in adminNoticesController.
					}

	        if (strpos($this->mime, 'image') >= 0)
	           return true;
	        else
	          return false;

    }

    public function get($name)
    {
       if (property_exists($this, $name))
       {
          if ( ($name == 'width' || $name == 'height') && is_null($this->$name))  // dynamically load this.
          {
            $this->setImageSize();
          }

        return $this->$name;
       }

       return null;
    }


    public function __get($name)
    {
        return $this->get($name);
    }

    public function getMeta($name = false)
    {
      if ($name === false)
      {
        return $this->image_meta;
      }

      if (! property_exists($this->image_meta, $name))
      {
          Log::addWarn('GetMeta on Undefined Property : ' . $name);
          return null;
      }

      return $this->image_meta->$name;
    }

		/* Get counts of what needs to be optimized still
		* @param String What to count: thumbnails, webp, avif.
		*/
		public function getCountOptimizeData($param = 'thumbnails')
		{
				$optimizeData = $this->getOptimizeData();

				if (! isset($optimizeData['params']) || ! isset($optimizeData['urls']))
				{
					array(array(), 0);
				}

				$count = 0;
				$urls = array();
				$i = 0;

				$params = $optimizeData['params'];

				if ($param == 'thumbnails')
					$param = 'image';

				// Take the optimizeData and take key - param column, then check if the param (image/webp/avif) is true (filter) .
				$combinedArray = array_filter(array_combine(array_keys($params), array_column($params, $param)));

				$count = count($combinedArray);
				foreach($combinedArray as $sizeName => $unneeded)
				{
					 $urls[] = $optimizeData['paths'][$sizeName];
				}
				return array($urls, $count);

		}

	  protected function getImageType($type = 'webp')
	  {
	    $fs = \wpSPIO()->filesystem();
			if ($this->getMeta($type) === self::FILETYPE_BIGGER)
				return false;

	    if (! is_null($this->getMeta($type)))
	    {
				// Filter to disable assumption(s) on the file basis of imageType.  Active when something has manually been deleted.
				$metaCheck = apply_filters('shortpixel/image/filecheck', false);
	      $filepath = $this->getFileDir() . $this->getMeta($type);
	      $file = $fs->getFile($filepath);

				if ($metaCheck === false)
				{
					 return $file;
				}
	    }

			if ($type == 'webp')
			{
	    	$is_double = \wpSPIO()->env()->useDoubleWebpExtension();
			}
			if ($type == 'avif')
			{
				$is_double = \wpSPIO()->env()->useDoubleAvifExtension();
			}

			$double_filepath = $this->getFileDir() .  $this->getFileName() . '.' . $type;
		  $filepath = $this->getFileDir() . $this->getFileBase() . '.' . $type;

			if ($is_double)
				$file = $fs->getFile($double_filepath);
			else
	    	$file = $fs->getFile($filepath);

			// If double extension is enabled, but no file, check the alternative.
			if (! $file->is_virtual() && ! $file->exists())
			{
				 if ($is_double)
				 		$file = $fs->getFile($filepath);
				 else
				 		$file = $fs->getFile($double_filepath);
			}

	    if (! $file->is_virtual() && $file->exists())
	      return $file;

	    return false;
	  }

		public function getWebp()
		{
				return $this->getImageType('webp');
		}

	  public function getAvif()
	  {
	    	return $this->getImageType('avif');
	  }

	  protected function setWebp()
	  {
	      $webp = $this->getWebp();
	      if ($webp !== false && $webp->exists())
	        $this->setMeta('webp', $webp->getFileName() );

	  }

	  protected function setAvif()
	  {
	      $avif = $this->getAvif();
	      if ($avif !== false && $avif->exists())
	        $this->setMeta('avif', $avif->getFileName() );

	  }

    public function setMeta($name, $value)
    {
      if (! $this->hasMeta($name))
      {
          Log::addDebug('Writing meta non existing' . $name);
          return false;
      }
      else
			{
				if ($this->image_meta->$name !== $value)
				{
					 $this->recordChanged(true, $this->image_meta->$name, $value);
				}
        $this->image_meta->$name = $value;

			}
    }

		// Indicates this image has changed data.  Parameters optional for future use.
		protected function recordChanged($bool = true, $old_value = null, $new_value = null)
		{
			 $this->recordChanged = $bool; // Updated record for this image.
		}

    public function hasMeta($name)
    {
        return  (property_exists($this->image_meta, $name));

    }

    public function isOptimized()
    {
      if ($this->getMeta('status') == self::FILE_STATUS_SUCCESS)
      {
          $this->processable_status = self::P_IS_OPTIMIZED;
          return true;
      }

      return false;
    }

    /* Returns the improvement of Image by optimizing
    * @param boolean $int When true, returns only integer, otherwise a formatted number for display
    */
    public function getImprovement($int = false)
    {
        if ($this->isOptimized())
        {
            $original = $this->getMeta('originalSize');
            $optimized = $this->getMeta('compressedSize');

            //$diff = $original - $optimized;
            if ($original <= 0 || $optimized <= 0)
              return null;

            if (! $int)
              return round(100.0 * (1.0 - $optimized / $original), 2);
            else
              return $original - $optimized;

        }
        else
          return 0;
    }


    /** Handles an Optimized Image in a general way
    *
    * - This function doesn't handle any specifics like custom / thumbnails or anything else, just for a general image
    * - This function doesn't save metadata, that's job of subclass
    *
    * @param Array Result Array. One image result array. ie.
		*
    */
		/*
						[image] => Array
                (
                    [url] =>
                    [originalSize] => 46188
                    [optimizedSize] => 21200
                    [status] => 2
                )

            [webp] => Array
                (
                    [url] =>
                    [size] => 14280
                    [status] => 2
                )

            [avif] => Array
                (
                    [url] =>
                    [size] => 14094
                    [status] => 2
                )
		*/
    public function handleOptimized($results, $args = array())
    {
        $settings = \wpSPIO()->settings();
        $fs = \wpSPIO()->filesystem();

				$defaults = array('isConverted' => false,
				);

				$args = wp_parse_args($args, $defaults);

				$status = $results['image']['status'];

          if ($settings->backupImages)
          {
							// If conversion to jpg is done, this function also does the backup.
							if (true === $args['isConverted'])
							{
									 $backupok = true;
							}
							else
							{
              	 $backupok = $this->createBackup();
							}

              if (! $backupok)
              {
                Log::addError('Backup Not OK - ' . $this->getFileName(), $args);

								$response = array(
										'is_error' => true,
										'issue_type' => ResponseController::ISSUE_BACKUP_CREATE,
										'message' => __('Could not create backup. Please check file permissions', 'shortpixel-image-optimiser'),
										'fileName' => $this->getFileName(),
								);

								ResponseController::addData($this->get('id'), $response);

								$this->preventNextTry(__('Could not create backup'));
                return false;
              }
          }

					if (true === $this->is_virtual())
					{
						$originalSize = $results['image']['originalSize'];
					}
					else {
						$originalSize = $this->getFileSize();
					}

          if ($status == API::STATUS_UNCHANGED || $status == API::STATUS_OPTIMIZED_BIGGER)
          {
            $copyok = true;
            $optimizedSize = $this->getFileSize();
            $tempFile = null;
          }
          else
          {
						$tempFile = $fs->getFile($results['image']['file']);

            if ($this->is_virtual())
            {
                $filepath = apply_filters('shortpixel/file/virtual/translate', $this->getFullPath(), $this);

                $virtualFile = $fs->getFile($filepath);
                $copyok = $tempFile->copy($virtualFile);
            }
            else
                $copyok = $tempFile->copy($this);

            $optimizedSize  = $tempFile->getFileSize();
            $this->setImageSize();
          } // else

          if ($copyok)
          {
             $this->setMeta('status', self::FILE_STATUS_SUCCESS);
             $this->setMeta('tsOptimized', time());
             $this->setMeta('compressedSize', $optimizedSize);
             $this->setMeta('originalSize', $originalSize);
          //   $this->setMeta('improvement', $originalSize - $optimizedSize);
             if ($this->hasMeta('did_keepExif'))
              $this->setMeta('did_keepExif', $settings->keepExif);
             if ($this->hasMeta('did_cmyk2rgb'))
              $this->setMeta('did_cmyk2rgb', $settings->CMYKtoRGBconversion);

             // Not set before in this case.
             if (is_null($this->getMeta('compressionType')) || $this->getMeta('compressionType') === false)
             {
                $this->setMeta('compressionType', $settings->compressionType);
             }

             if ($settings->resizeImages)
             {

               $resizeWidth = $settings->resizeWidth;
               $resizeHeight = $settings->resizeHeight;

							 $originalWidth = $this->getMeta('originalWidth');
							 $originalHeight = $this->getMeta('originalHeight');

							 $width = $this->get('width'); // image width
							 $height = $this->get('height');

               if ( ($resizeWidth == $width && $width != $originalWidth)  || ($resizeHeight == $height && $height != $originalHeight ) ) // resized.
               {
                   $this->setMeta('resizeWidth', $this->get('width') );
                   $this->setMeta('resizeHeight', $this->get('height') );
                   $this->setMeta('resize', true);
									 $resizeType = ($settings->resizeType == 1) ? __('Cover', 'shortpixel-image-optimiser') : __('Contain', 'shortpixel-image-optimiser');
									 $this->setMeta('resizeType', $resizeType);
               }
               else
                 $this->setMeta('resize', false);
             }

          }
          else
          {
            Log::addError('Copy failed for  ' . $this->getFullPath() );

						$response = array(
								'is_error' => true,
								'issue_type' => ResponseController::ISSUE_BACKUP_CREATE,
								'message' => __('Could not copy optimized image from temporary files. Check file permissions', 'shortpixel-image-optimiser'),
								'fileName' => $this->getFileName(),
						);

						ResponseController::addData($this->get('id'), $response);;

            return false;
          }
          return true;

        Log::addWarn('Could not find images of this item in tempfile -' . $this->id . '(' . $this->getFullPath() . ')', array_keys($downloadResults) );

				$response = array(
					 'is_error' => true,
					 'issue_type' => ResponseController::ISSUE_OPTIMIZED_NOFILE,
					 'message' => __('Image is reporting as optimized, but file couldn\'t be found in the downloaded files', 'shortpixel-image-optimiser'),
					 'fileName' => $this->getFileName(),

				);

				ResponseController::addData($this->get('id'), $response);

        return null;
    }

    public function handleOptimizedFileType($downloadResult)
    {
				 $fs = \wpSPIO()->filesystem();

          if (isset($downloadResult['webp']) && isset($downloadResult['webp']['file'])) // check if there is webp with same filename
          {
						$tmpFile = $fs->getFile($downloadResult['webp']['file']);

             $webpResult = $this->handleWebp($tmpFile);
              if ($webpResult === false)
                Log::addWarn('Webps available, but copy failed ' . $downloadResults['webp']['file']->getFullPath());
              else
                $this->setMeta('webp', $webpResult->getFileName());
          }
					elseif(isset($downloadResult['webp']) && isset($downloadResult['webp']['status']))
					{
						 if ($downloadResult['webp']['status'] == API::STATUS_OPTIMIZED_BIGGER)
						 {
							  $this->setMeta('webp', self::FILETYPE_BIGGER);
						 }
					}

          if (isset($downloadResult['avif']) && isset($downloadResult['avif']['file'])) // check if there is webp with same filename
          {
						 $tmpFile = $fs->getFile($downloadResult['avif']['file']);
             $avifResult = $this->handleAvif($tmpFile);
              if ($avifResult === false)
                Log::addWarn('Avif available, but copy failed ' . $tmpFile->getFullPath());
              else
                $this->setMeta('avif', $avifResult->getFileName());
          }
					elseif(isset($downloadResult['avif']) && isset($downloadResult['avif']['status']))
					{

						 if ($downloadResult['avif']['status'] == API::STATUS_OPTIMIZED_BIGGER)
						 {
								$this->setMeta('avif', self::FILETYPE_BIGGER);
						 }
					}
    }

    public function isRestorable()
    {

			// Check for both optimized and hasBackup, because even if status for some reason is not optimized, but backup is there, restore anyhow.
        if (! $this->isOptimized() && ! $this->hasBackup())
        {
					 $this->restorable_status = self::P_NOT_OPTIMIZED;
           return false;  // not optimized, done.
        }
        elseif ($this->hasBackup() && ($this->is_virtual() || ($this->is_writable() && $this->is_directory_writable()) ))
        {
					$this->restorable_status = self::P_RESTORABLE;
          return true;
        }
        else
        {
          if (! $this->is_writable())
          {
						  $response = array(
									'is_error' => true,
									'issue_type' => ResponseController::ISSUE_FILE_NOTWRITABLE,
									'message' => __('This file can\'t be restored, not writable', 'shortpixel-image-optimiser'),

							);
							ResponseController::addData($this->get('id'), $response);

							$this->restorable_status = self::P_FILE_NOTWRITABLE;
              Log::addWarn('Restore - Not Writable ' . $this->getFullPath() );
          }
					elseif (! $this->is_directory_writable())
					{
							$response = array(
									'is_error' => true,
									'issue_type' => ResponseController::ISSUE_DIRECTORY_NOTWRITABLE,
									'message' => __('This file can\'t be restored, directory is not writable', 'shortpixel-image-optimiser'),

							);
							ResponseController::addData($this->get('id'), $response);

							$this->restorable_status = self::P_DIRECTORY_NOTWRITABLE;
							Log::addWarn('Restore - Directory noot Writable ' . $this->getFileDir() );
					}
          elseif (! $this->hasBackup())
					{
						$this->restorable_status = self::P_BACKUP_NOT_EXISTS;
						$response = array(
								'is_error' => true,
								'issue_type' => ResponseController::ISSUE_BACKUP_EXISTS,
								'message' => __('Can\'t restore, backup file doesn\'t exist', 'shortpixel-image-optimiser'),

						);
						ResponseController::addData($this->get('id'), $response);
            Log::addDebug('Backup not found for file: ', $this->getFullPath());
					}
           return false;
        }
    }

    /** Restores a backup to original file *
    *
    * **NOTE** This function only moves the file but doesn't save the meta, which should reflect the changes!
    */
    public function restore()
    {
        if (! $this->isRestorable())
        {
            Log::addWarn('Trying restore action on non-restorable: ' . $this->getFullPath(), $this->getReason('restorable'));
            return false; // no backup / everything not writable.
        }

        $backupFile = $this->getBackupFile();
				$type = $this->get('type');
				$id = $this->get('id');

        if (! $backupFile)
        {
          Log::addWarn('Issue with restoring BackupFile, probably missing - ', $backupFile);
          return false; //error
        }

        if (! $backupFile->is_readable())
        {
						Log::addError('BackupFile not readable' . $backupFile->getFullPath());
						$response = array(
								'is_error' => true,
								'issue_type' => ResponseController::ISSUE_BACKUP_EXISTS,
								'message' => __('BackupFile not readable. Check file and/or file permissions', 'shortpixel-image-optimiser'),
						);
						ResponseController::addData($this->get('id'), $response);

           return false; //error
         }
				 elseif (! $backupFile->is_writable())
				 {
 						Log::addError('BackupFile not writable' . $backupFile->getFullPath());
						 $response = array(
								 'is_error' => true,
								 'issue_type' => ResponseController::ISSUE_FILE_NOTWRITABLE,
								 'message' => __('BackupFile not writable. Check file and/or file permissions', 'shortpixel-image-optimiser'),

						 );
						 ResponseController::addData($this->get('id'), $response);
            return false; //error
				 }
				 if (! $this->is_writable())
				 {
					 	 Log::addError('Target File not writable' . $this->getFullPath());

						 $response = array(
								 'is_error' => true,
								 'issue_type' => ResponseController::ISSUE_FILE_NOTWRITABLE,
								 'message' => __('Target file not writable. Check file permissions', 'shortpixel-image-optimiser'),

						 );
						 ResponseController::addData($this->get('id'), $response);

						 return false;
				 }

				$bool = $backupFile->move($this);

        if ($bool !== true)
        {
					Log::addError('Moving backupFile failed -' . $this->getFullpath() );
					$response = array(
							'is_error' => true,
							'issue_type' => ResponseController::ISSUE_FILE_NOTWRITABLE,
							'message' => __('Moving Backup file failed', 'shortpixel-image-optimiser'),

					);
					ResponseController::addData($this->get('id'), $response);
        }
				else {
					$this->width = null;
					$this->height = null;
					$this->mime = null;

				}
        return $bool;
    }

    /** When an image is deleted
    *
    *  Handle an image delete i.e. by WordPress or elsehow.
    */
    public function onDelete()
    {
        if ($this->hasBackup())
        {
           $file = $this->getBackupFile();
           $file->delete();
        }

        $webp = $this->getWebp();
        $avif = $this->getAvif();

        if ($webp !== false && $webp->exists())
          $webp->delete();

        if ($avif !== false && $avif->exists())
           $avif->delete();

    }


    protected function handleWebp(FileModel $tempFile)
    {
         $fs = \wpSPIO()->filesystem();
				 if ($this->is_virtual())
				 {
					 	$fullpath = apply_filters('shortpixel/file/virtual/translate', $this->getFullPath(), $this);
						$fileObj = $fs->getFile($fullpath);
						$fileDir = $fileObj->getFileDir();
				 }
				 else {
				 		$fileDir = $this->getFileDir();
				 }

         $target = $fs->getFile( (string) $fileDir . $this->getFileBase() . '.webp');

            // only copy when this constant is set.
            if( (defined('SHORTPIXEL_USE_DOUBLE_WEBP_EXTENSION') && SHORTPIXEL_USE_DOUBLE_WEBP_EXTENSION) == true ) {
                 $target = $fs->getFile((string) $fileDir . $this->getFileName() . '.webp'); // double extension, if exists.
            }

            $result = false;

            if (! $target->exists()) // don't copy if exists.
            {
							$result = $tempFile->copy($target);
						}
            else
						{
              $result = true; // if already exists, all fine by us.
						}

            if (false === $result)
						{
              Log::addWarn('Could not copy Webp to destination ' . $target->getFullPath() );
							return false;
						}
            return $target;
      //   }

         return false;
    }


    protected function handleAvif(FileModel $tempFile)
    {
         $fs = \wpSPIO()->filesystem();
				 if ($this->is_virtual())
				 {
						$fullpath = apply_filters('shortpixel/file/virtual/translate', $this->getFullPath(), $this);
						$fileObj = $fs->getFile($fullpath);
						$fileDir = $fileObj->getFileDir();
				 }
				 else {
						$fileDir = $this->getFileDir();
				 }

            $target = $fs->getFile( (string) $fileDir . $this->getFileBase() . '.avif');

						// only copy when this constant is set.
            if( (defined('SHORTPIXEL_USE_DOUBLE_AVIF_EXTENSION') && SHORTPIXEL_USE_DOUBLE_AVIF_EXTENSION) == true ) {
                 $target = $fs->getFile((string) $fileDir . $this->getFileName() . '.avif'); // double extension, if exists.
            }

            $result = $tempFile->copy($target);
            if (! $result)
              Log::addWarn('Could not copy Avif to destination ' . $target->getFullPath() );
            return $target;
      //   }

         return false;
    }

    protected function isPathExcluded()
    {
        $excludePatterns = \wpSPIO()->settings()->excludePatterns;

        if(!$excludePatterns || !is_array($excludePatterns)) { return false; }

        foreach($excludePatterns as $item) {
            $type = trim($item["type"]);
            if(in_array($type, array("name", "path", 'regex-name','regex-path'))) {
                $pattern = trim($item["value"]);
                $target = ($type == "name") ? $this->getFileName() : $this->getFullPath();

                if ($type == 'regex-name' || $type == 'regex-path')
                {
                    $result = $this->matchExludeRegexPattern($target, $pattern);
                }
                else {
                    $result =  $this->matchExcludePattern($target, $pattern);
                }
                if($result === true) { //search as a substring if not
                    $this->processable_status = self::P_EXCLUDE_PATH;
                    return true;
                }
            }
        }
        return false;
    }

		// Checks Processable extensions. The other way of approval is having the file be convertable.
    protected function isExtensionExcluded()
    {

        if (! is_null($this->getExtension()) && in_array( strtolower($this->getExtension()) , self::PROCESSABLE_EXTENSIONS))
        {
            return false;
        }

				// If extension not in allowed list, check converters.
				// @todo Most likely move this higher up the chain.
				if (true === $this->is_main_file)
				{
					$converter = Converter::getConverter($this, true);
					if (is_object($converter))
					{
							// Yes can convert, so do not exclude.
							if (true === $converter->isConvertable())
							{
								 return false;
							}
					}
				}
        $this->processable_status = self::P_EXCLUDE_EXTENSION;
        return true;
    }

    protected function matchExcludePattern($target, $pattern) {
        if(strlen($pattern) == 0)  // can happen on faulty input in settings.
          return false;

        if (strpos($target, $pattern) !== false)
        {
          return true;
        }

        return false;
    }

    protected function matchExludeRegexPattern($target, $pattern)
    {
      if(strlen($pattern) == 0)  // can happen on faulty input in settings.
        return false;

			$matches = array();
      $m = preg_match($pattern,  $target, $matches);

      if ($m !== false && $m > 0) // valid regex, more hits than zero
      {
        return true;
      }

      return false;
    }

		protected function isSizeExcluded()
		{
			$excludePatterns = \wpSPIO()->settings()->excludePatterns;

			if (! $excludePatterns || ! is_array($excludePatterns) ) // no patterns, nothing excluded
				return false;

			$bool = false;

			foreach($excludePatterns as $item) {
					$type = trim($item["type"]);
					if($type == "size") {

							$width = $this->get('width');
							$height = $this->get('height');

							if( $width && $height
									 && $this->isProcessableSize($width, $height, $item["value"]) === false){
										 $this->processable_status = self::P_EXCLUDE_SIZE;
										return true; // exit directly because we have our exclusion
								}
							else
									$bool = false; // continue and check all patterns, there might be multiple.
						}
			 }

			 return $bool;
		}

		private function isProcessableSize($width, $height, $excludePattern)
		{
				$ranges = preg_split("/(x|×|X)/",$excludePattern);
				$widthBounds = explode("-", $ranges[0]);
				$minWidth = intval($widthBounds[0]);
				$maxWidth = (!isset($widthBounds[1])) ? intval($widthBounds[0]) : intval($widthBounds[1]);

				$heightBounds = isset($ranges[1]) ? explode("-", $ranges[1]) : false;
				$minHeight = $maxHeight = 0;

				if ($heightBounds)
				{
					$minHeight = intval($heightBounds[0]);
					$maxHeight = (!isset($heightBounds[1])) ? intval($heightBounds[0]) : intval($heightBounds[1]);
				}

				if(   $width >= $minWidth && $width <= $maxWidth
					 && ( $heightBounds === false
							 || ($height >= $minHeight && $height <= $maxHeight) )) {
						return false;
				}
				return true;
		}

    /** Convert Image Meta to A Class */
    protected function toClass()
    {
        return $this->image_meta->toClass();
    }


    protected function createBackup()
    {
        // Safety: It should absolutely not be possible to overwrite a backup file.
       if ($this->hasBackup())
       {
          $backupFile = $this->getBackupFile();

          // If backupfile is bigger (indicating original file)
          if ($backupFile->getFileSize() == $this->getFileSize())
          {
             return true;
          }
          else
          {
            // Return the backup for a retry.
            if ($this->isRestorable() && ($backupFile->getFileSize() > $this->getFileSize()))
            {
                Log::addWarn('Backup Failed, File is restorable, try to recover. ' . $this->getFullPath() );
                $this->restore();

								$this->error_message = __('Backup already exists, but image is recoverable and the plugin will rollback. Will retry to optimize again. ', 'shortpixel-image-optimiser');
            }
/*						elseif ($backupFile->getFileSize() > $this->getFileSize() && ! $backupFile->is_virtual() ) // Where there is a backup and it's bigger, assume some hickup, but there is backup so hooray
						{
						 		Log::addWarn('Backup already exists. Backup file is bigger, so assume that all is good with backup and proceed');
							 return true; // ok it.
						} */
            else
            {
              $this->preventNextTry(__('Fatal Issue: The Backup file already exists. The backup seems not restorable, or the original file is bigger than the backup, indicating an error.', 'shortpixel-image-optimiser'));

              Log::addError('The backup file already exists and it is bigger than the original file. BackupFile Size: ' . $backupFile->getFileSize() . ' This Filesize: ' . $this->getFileSize(), $this->fullpath);

              $this->error_message = __('Backup not possible: it already exists and the original file is bigger.', 'shortpixel-image-optimiser');
            }

            return false;
          }
          exit('Fatal error, createbackup protection - this should never reach');
       }
       $directory = $this->getBackupDirectory(true);
       $fs = \wpSPIO()->filesystem();

       // @Deprecated
       if(apply_filters('shortpixel_skip_backup', false, $this->getFullPath(), $this->is_main_file)){
           return true;
       }
       if(apply_filters('shortpixel/image/skip_backup', false, $this->getFullPath(), $this->is_main_file)){
           return true;
       }

       if (! $directory)
       {
          Log::addWarn('Could not create Backup Directory for ' . $this->getFullPath());
          $this->error_message = __('Could not create backup Directory', 'shortpixel-image-optimiser');
          return false;
       }

       $backupFile = $fs->getFile($directory . $this->getBackupFileName());

       // Same file exists as backup already, don't overwrite in that case.
       if ($backupFile->exists() && $this->hasBackup() && $backupFile->getFileSize() == $this->getFileSize())
       {
          $result = true;
       }
       else
       {
         $result = $this->copy($backupFile);
       }

       if (! $result)
       {
          Log::addWarn('Creating Backup File failed for ' . $this->getFullPath());
          return false;
       }

       if ($this->hasBackup())
         return true;
       else
       {
          Log::addWarn('FileModel returns no Backup File for (failed) ' . $this->getFullPath());
          return false;
       }
    }

    protected function fs()
    {
       return \wpSPIO()->filesystem();
    }

		protected function createParamList()
		{
			$settings = \wpSPIO()->settings();

		 $resize = false;
		 $hasResizeSizes = (intval($settings->resizeImages) > 0) ? true : false;
		 $result = array();

		 $useSmartcrop = false;

		 if ($settings->useSmartcrop == true && $this->getExtension() !== 'pdf')
		 {
		 	$resize = 4 ;
			$useSmartcrop = true;
		 }
		 elseif ( $hasResizeSizes)
		 {
		 	$resize = $settings->resizeImages ? 1 + 2 * ($settings->resizeType == 'inner' ? 1 : 0) : 0;
		 }

		 if ($resize > 0)
		 {
			 $resize_width = $resize_height = 0; // can be not set.
 	 		 $width = $this->get('width');
			 $height = $this->get('height');

			 if ($hasResizeSizes)
			 {
			 		$resize_width = intval($settings->resizeWidth);
			 		$resize_height = intval($settings->resizeHeight);
					// If retina, allowed resize sizes is doubled, otherwise big image / big retina would end up same sizes.
					if ($this->get('imageType') == self::IMAGE_TYPE_RETINA)
					{
						 $resize_width = $resize_width * 2;
						 $resize_height = $resize_height * 2;
					}
				}

				$width =  ($width <= $resize_width || $resize_width === 0) ? $width : $resize_width;
				$height = ($height <= $resize_height || $resize_height === 0) ? $height : $resize_height;

			 	$result = array('resize' => $resize, 'resize_width' => $width, 'resize_height' => $height);
			}

		 // Check if the image is not excluded
		 $imageOk = ($this->isProcessable(true) || $this->isOptimized()) ? true : false ;

		 $result['image'] = $this->isProcessable(true);
		 $result['webp']  = ($imageOk && $this->isProcessableFileType('webp')) ? true : false;
		 $result['avif']  = ($imageOk && $this->isProcessableFileType('avif')) ? true : false;

		 return $result;

		}



} // model
