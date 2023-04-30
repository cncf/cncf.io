<?php
namespace ShortPixel\Model\Image;
use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;
use \ShortPixel\ShortPixelPng2Jpg as ShortPixelPng2Jpg;
use ShortPixel\Controller\ResponseController as ResponseController;
use ShortPixel\Controller\AdminNoticesController as AdminNoticesController;
use ShortPixel\Controller\OptimizeController as OptimizeController;
use ShortPixel\Controller\QuotaController as QuotaController;

use ShortPixel\Helper\InstallHelper as InstallHelper;
use ShortPixel\Helper\UtilHelper as UtilHelper;

use ShortPixel\Model\Converter\Converter as Converter;

class MediaLibraryModel extends \ShortPixel\Model\Image\MediaLibraryThumbnailModel
{

	/** @var array */
  protected $thumbnails = array(); // thumbnails of this // MediaLibraryThumbnailModel .

	/** @var array */
  protected $retinas; // retina files - MediaLibraryThumbnailModel (or retina / webp and move to thumbnail? )
  //protected $webps = array(); // webp files -

	/** @var boolean */
  protected $original_file = false; // the original instead of the possibly _scaled one created by WP 5.3

	/** @var boolean */
  protected $is_scaled = false; // if this is WP 5.3 scaled
  //protected $do_png2jpg = false; // option to flag this one should be checked / converted to jpg.

  protected $wp_metadata;
	private $parent; // In case of WPML Duplicates

	/** @var string **/
  protected $type = 'media';

	/** @var boolean */
  protected $is_main_file = true; // for checking

	/** @var array */
  private static $unlistedChecked = array(); // limit checking unlisted.

	/** @var boolean */
	private static $unlistedNoticeChecked = false; // check for notice only one item per run. This is a performance killer otherwise.

	/** @var boolean */
  protected $optimizePrevented; // cache if there is any reason to prevent optimizing

	/** @var string */
	protected $optimizePreventedReason;

	/** @var boolean */
	private $justConverted = false; // check if legacy conversion happened on same run, to prevent double runs.


	private $optimizeData; // cache to prevent running this more than once per run.

	/** @var string */
	protected $mainImageKey = 'shortpixel_main_donotuse';

	/** @var string */
	protected $originalImageKey = 'shortpixel_original_donotuse';

  public function __construct($post_id, $path)
  {
      $this->id = $post_id;

      parent::__construct($path, $post_id, null);

			// Set AFTER PARENT, because it's overwritten.
			$this->imageType = self::IMAGE_TYPE_MAIN;
			$this->image_meta = new ImageMeta();

      // WP 5.3 and higher. Check for original file.
      if (function_exists('wp_get_original_image_path'))
      {
        $this->setOriginalFile();
      }

			if ($this->id > 0)
			 	$this->loadMeta();

      if (false === $this->isExtensionExcluded())
      {
				 $this->checkUnlistedForNotice();
			}
  }

	public function getOptimizeUrls()
	{
			$data = $this->getOptimizeData();
			return array_values($data['urls']);
	}

	// Path will only return the filepath.  For reasons, see getOptimizeFileType
  public function getOptimizeData()
  {
		if (! is_null($this->optimizeData))
		{
			return $this->optimizeData;
		}

		$parameters = array(
				'urls' => array(),
				'params' => array(),
				// doubles are items that will have same result, but is diffent file.  duplicates are same files, same result - only meta update.
				'returnParams' => array('sizes' => array(), 'doubles' => array(), 'duplicates'  => array() ),
		);

		$settings = \wpSPIO()->settings();
		$url = $this->getURL();

		 if (! $url) // If the whole image URL can't be found
		 {
			return $parameters;
		 }

		 $isSmartCrop = ($settings->useSmartcrop == true && $this->getExtension() !== 'pdf') ? true : false;
		 $doubles = array(); // check via hash if same command / result is there.

     if ($this->isProcessable(true) || ($this->isProcessableAnyFileType() && $this->isOptimized()) )
		 {
				$paramList = $this->createParamList();
				$parameters['urls'][$this->mainImageKey] = $url;
				$parameters['paths'][$this->mainImageKey] = $this->getFullPath();
				$parameters['params'][$this->mainImageKey] = $paramList;
				$parameters['returnParams']['sizes'][$this->mainImageKey] = $this->getFileName();

				if ($isSmartCrop )
				{
					 $parameters['returnParams']['fileSizes'][$this->mainImageKey] = $this->getFileSize();
				}

				$hash = md5( serialize($paramList) . $url);
				$doubles[$hash] = $this->mainImageKey;
		 }

		 $thumbObjs = $this->getThumbObjects();

		 $unProcessable = array();

		 foreach($thumbObjs as $name => $thumbObj)
		 {
			 if ($thumbObj->isThumbnailProcessable() || ($thumbObj->isProcessableAnyFileType() && $thumbObj->isOptimized()) )
			 {

				 if (! $isSmartCrop)
				 {
				 	$url = $thumbObj->getURL();
			   }

				 $paramList = $thumbObj->createParamList();
				 $hash = md5( serialize($paramList) . $url); // Hash the paramlist + url to find identical results.

// This thing fly to sep function? Retutrn liast  duplicat/double name => name
				 if (isset($doubles[$hash]))
				 {
					  $doubleName = $doubles[$hash];

						if ($doubleName === $this->mainImageKey)
						{
							 $compareObj = $this;
						}
						else {
							 $compareObj = $thumbObjs[$doubleName];
						}

						if ($thumbObj->getFileName() == $compareObj->getFileName())
						{
							$parameters['returnParams']['duplicates'][$name] = $doubleName;
						}
						else
						{
							// Check if in a duplicate item is in doubles, so we don't double-double it.
							$aDuplicate = false;
							foreach($parameters['returnParams']['doubles'] as $doubleNameInDoubles => $unneeded)
							{
								 if ($doubleNameInDoubles !== $this->mainImageKey && $doubleNameInDoubles !== $this->originalImageKey && $thumbObjs[$doubleNameInDoubles]->getFileName() == $thumbObj->getFileName())
								 {
									 $aDuplicate = true;
									 $parameters['returnParams']['duplicates'][$name] = $doubleNameInDoubles;
								 }
							}

							if (false === $aDuplicate)
							{
					  		$parameters['returnParams']['doubles'][$name] = $doubleName;
							}
						}
				 }
				 else {
					 $parameters['urls'][$name] = $url;
					 $parameters['paths'][$name] =  $thumbObj->getFullPath();
					 $parameters['params'][$name] = $paramList;
					 $parameters['returnParams']['sizes'][$name] = $thumbObj->getFileName();
					 if ($isSmartCrop)
					 {
							$parameters['returnParams']['fileSizes'][$name] = $thumbObj->getFileSize();
					 }
					 $doubles[$hash]  = $name;
			 	}

			 }
			 else {
				 	// Save rejected thumbs, because they might be a duplicate of something that goes on the processing.
				  $unProcessable[] = $thumbObj;
			 }
		 }

		// If one or more thumbnails were not processable, still check them against the process list in case identical sizes are being processed and it should be marked as a duplicate.
		 if (isset($parameters['paths']) && count($unProcessable) > 0)
		 {
			   $pathVal = array_values($parameters['paths']);
				 $pathLookup = array_flip($parameters['paths']); // lookup fullpath -> size.

				 foreach($unProcessable as $thumbObj)
				 {
					  if (in_array($thumbObj->getFullPath(), $pathVal) === true)
						{
							 $parameters['returnParams']['duplicates'][$thumbObj->get('name')] = $pathLookup[$thumbObj->getFullPath()];
						}
				 }
		 }

		 $this->optimizeData = $parameters;
     return $parameters;
  }



	public function flushOptimizeData()
	{
		 $this->optimizeData = null;
	}

  // Try to get the URL via WordPress
	// This is now officially a heavy function.  Take times, other plugins (like s3) might really delay it
  public function getURL()
  {
     $url = $this->fs()->checkURL(wp_get_attachment_url($this->id));
		 if (true === $this->getMeta()->convertMeta()->hasPlaceHolder())
		 {
			  $extension = pathinfo($url, PATHINFO_EXTENSION);
			  $url = str_replace($extension, $this->getMeta()->convertMeta()->getFileFormat(), $url);
		 }

		 return $url;
  }

  public function getWPMetaData()
  {
      if (is_null($this->wp_metadata))
        $this->wp_metadata = wp_get_attachment_metadata($this->id);

      return $this->wp_metadata;
  }

	/** Check if image is scaled by WordPress
	*
	*	@return boolean
	*/
  public function isScaled()
  {
     return $this->is_scaled;
  }


  /** Loads an array of Thumbnailmodels based on sizes available in WordPress metadata
  **  @return Array consisting ofMediaLibraryThumbnailModel
  **/
  protected function loadThumbnailsFromWP()
  {
    $wpmeta = $this->getWPMetaData();
    $width = null; $height = null;

    if (! isset($wpmeta['width']))
    {
       if ($this->getExtension == 'pdf')
       {
          $width = $wpmeta['full']['width'];
       }
    }
    else
      $width = $wpmeta['width'];


    if (! isset($wpmeta['height']))
    {
       if ($this->getExtension == 'pdf')
       {
          $height = $wpmeta['full']['height'];
       }
    }
    else
      $height = $wpmeta['height'];

		if (isset($wpmeta['filesize']))
		{
			 $this->filesize = $wpmeta['filesize'];
		}

    if (is_null($width) || is_null($height) && ! $this->is_virtual())
    {
       $width = (is_null($width)) ? $this->get('width') : $width;
       $height = (is_null($height)) ? $this->get('height') : $height;
    }

    if (is_null($this->getMeta('originalWidth')))
      $this->setMeta('originalWidth',$width);

    if (is_null($this->getMeta('originalWidth')))
			$this->setMeta('originalHeight',$height);


    $thumbnails = array();
    if (isset($wpmeta['sizes']))
    {
          foreach($wpmeta['sizes'] as $name => $data)
          {
             if (isset($data['file']))
             {
               $thumbObj = $this->getThumbnailModel($this->getFileDir() . $data['file'], $name);
               $meta = new ImageThumbnailMeta();
               $meta->originalWidth = (isset($data['width'])) ? $data['width'] : null; // get from WP
               $meta->originalHeight = (isset($data['height'])) ? $data['height'] : null;
							 $thumbObj->setName($name); // name is size mostly
               $thumbObj->setMetaObj($meta);

							 if (isset($data['filesize']))
							 	$thumbObj->filesize = $data['filesize'];

               $thumbnails[$name] = $thumbObj;
             }
          }
    }

    return $thumbnails;
  }


	protected function getRetinas()
	{
			// Don't load retina's if option is off.
			if (! \wpSPIO()->settings()->optimizeRetina)
				return;

			if (! is_null($this->retinas))
			{
				return $this->retinas;
			}

			if (! isset($this->retinas[$this->mainImageKey]))
			{
	      $main = $this->getRetina();

	      if ($main)
				{
					$main->setName($this->mainImageKey);
	        $this->retinas[$this->mainImageKey] = $main; // to prevent any custom image sizes to get overwritten.
				}
			}

      if ($this->isScaled() && ! isset($this->retinas[$this->originalImageKey]))
      {
        $retscaled = $this->original_file->getRetina();
        if ($retscaled)
				{
					$retscaled->setName($this->originalImageKey);
          $this->retinas[$this->originalImageKey] = $retscaled; //see main
				}
      }

      foreach ($this->thumbnails as $thumbname => $thumbObj)
      {
				if (! isset($this->retinas[$thumbname]))
				{
	        $retinaObj = $thumbObj->getRetina();
	        if ($retinaObj)
	           $this->retinas[$retinaObj->get('name')] = $retinaObj;
				}
      }

			return $this->retinas;

  }

  protected function getWebps()
  {
      $webps = array();

      $main = $this->getWebp();
      if ($main)
        $webps[$this->mainImageKey] = $main;  // on purpose not a string, but number to prevent any custom image sizes to get overwritten.

      foreach($this->thumbnails as $thumbname => $thumbObj)
      {
         $webp = $thumbObj->getWebp();
         if ($webp)
          $webps[$thumbname] = $webp;
      }

			if (! is_null($this->retinas))
			{
				foreach ($this->retinas as $retinaName => $retinaObj)
				{
					 $webp = $retinaObj->getWebp();
					 if ($webp)
					 		$webps['retina-' . $retinaName]  = $webp; // adding a prefix to make sure it will not overwrite thumbnames, they share the same name.
				}
			}
      if ($this->isScaled())
      {
        $webp = $this->original_file->getWebp();
        if ($webp)
          $webps[$this->originalImageKey] = $webp; //see main
      }

      return $webps;
  }

  protected function getAvifs()
  {
      $avifs = array();
      $main = $this->getAvif();

      if ($main)
        $avifs[$this->mainImageKey] = $main;  // on purpose not a string, but number to prevent any custom image sizes to get overwritten.

      foreach($this->thumbnails as $thumbname => $thumbObj)
      {
         $avif = $thumbObj->getAvif();
         if ($avif)
          $avifs[$thumbname] = $avif;
      }

			if (! is_null($this->retinas))
			{
				foreach ($this->retinas as $retinaName => $retinaObj)
				{
					 $avif = $retinaObj->getAvif();
					 if ($avif)
							$avifs['retina-' . $retinaName]  = $avif; // adding a prefix to make sure it will not overwrite thumbnames, they share the same name.
				}
			}

      if ($this->isScaled())
      {
        $avif = $this->original_file->getAvif();
        if ($avif)
          $avifs[$this->originalImageKey] = $avif; //see main
      }

      return $avifs;
  }

  // @todo Needs unit test.
  public function count($type)
  {
      switch($type)
      {
         case 'thumbnails' :
           $count = count($this->thumbnails);
         break;
         case 'webps':
            $count = count(array_unique($this->getWebps()));
         break;
         case 'avifs':
            $count = count(array_unique($this->getAvifs()));
         break;
         case 'retinas':
           $count = count(array_unique($this->getRetinas()));
         break;
      }

      return $count;

  }

  public function handleOptimized($optimizeData, $args = array())
  {
      $return = true;
			$wpmeta = wp_get_attachment_metadata($this->get('id'));
			$WPMLduplicates = $this->getWPMLDuplicates();
			$fs = \wpSPIO()->filesystem();

			if (isset($optimizeData['files']) && isset($optimizeData['data']))
			{
				 $files = $optimizeData['files'];
				 $data = $optimizeData['data'];
			}
			else {
				Log::addError('Something went wrong with handleOptimized', $optimizeData);
			}

			$optimized = array();

			// Main file has a  index.
			$mainFile = (isset($files) && isset($files[$this->mainImageKey])) ? $files[$this->mainImageKey] : false;

			// If converted and not using regular backup as leading.
			$isConverted = (true === $this->getMeta()->convertMeta()->isConverted() && true === $this->getMeta()->convertMeta()->omitBackup());

			$args['isConverted'] = $isConverted;

      if (! $this->isOptimized() && isset($mainFile['image']) ) // main file might not be contained in results
      {
          $result = parent::handleOptimized($mainFile, $args);
          if (! $result)
          {
             return false;
          }

					if ($this->getMeta('resize') == true)
					{
						 $wpmeta['width'] = $this->get('width');
 						 $wpmeta['height'] = $this->get('height');
					}
					$wpmeta['filesize'] = $this->getFileSize();

      }

      $this->handleOptimizedFileType($mainFile);

			$compressionType = $this->getMeta('compressionType'); // CompressionType not set on subimages etc.

      // If thumbnails should not be optimized, they should not be in result Array.
			// #### THUMBNAILS ####
			$thumbObjs = $this->getThumbObjects();

			// Add doubles to the processing list. Doubles are sizes with the same result, but should be copied to it's respective thumbnail file + backup.
			if (isset($data['doubles']))
			{
				 foreach($data['doubles'] as $doubleName => $doubleRef)
				 {
					  $files[$doubleName] = $files[$doubleRef];
						$doubleObj = $thumbObjs[$doubleName];
						$data['sizes'][$doubleName] = $doubleObj->getFileName();
				 }
			}

      foreach($data['sizes'] as $sizeName => $fileName)
      {
				 // Check if thumbnail is in the tempfiles return set. This might not always be the case
				 if (! isset($files[$sizeName]) )
				 {
					  continue;
				 }

				 if ($sizeName === $this->mainImageKey)
				 {
				 	continue;
				 }

				 $resultData = $files[$sizeName];
				 $thumbnail = (isset($thumbObjs[$sizeName])) ? $thumbObjs[$sizeName] : false;

				 if (! is_object($thumbnail))
 			 	 {
					 	Log::addError('Thumbnail with size name'  . $sizeName . ' is not registered in this image. This should not happen, skipping.', $thumbObjs);
						Log::addError('OptimizeData', $optimizeData);
						continue;
 			 	 }

         $thumbnail->handleOptimizedFileType($resultData); // check for webps /etc

         if ($thumbnail->isOptimized())
         {
					  continue;
				 }
         if (!$thumbnail->isProcessable())
				 {
           continue; // when excluded.
				 }

         $result = false;

				 $thumbnail->setMeta('compressionType', $compressionType);
          $result = $thumbnail->handleOptimized($resultData, $args);

				 // Always update the WP meta - except for unlisted files.
				 if ($thumbnail->get('imageType') == self::IMAGE_TYPE_THUMB && $thumbnail->getMeta('file') === null)
				 {

						 $size = $thumbnail->get('size');
						 if ($thumbnail->getMeta('resize') == true)
						 {
									$wpmeta['sizes'][$size]['width'] = $thumbnail->get('width');
									$wpmeta['sizes'][$size]['height']  = $thumbnail->get('height');
						 }

						 	$wpmeta['sizes'][$size]['filesize'] = $thumbnail->getFileSize();
				 }


         if ($thumbnail->get('prevent_next_try') !== false) // in case of fatal issues.
         {
              $this->preventNextTry($thumbnail->get('prevent_next_try'));
              $return = false; //failed
         }
      }

			// Add duplicates. Duplicates are metadata sizes that have a same file ( identical ) defined pointing.
			if (isset($data['duplicates']))
			{

				 foreach($data['duplicates'] as $duplicateName => $duplicateRef)
				 {
					 	if ($duplicateName === $this->mainImageKey)
						{
							$thumbnail = $this;
						}
						elseif ($duplicateName === $this->originalImageKey)
						{
							 $thumbnail = $this->getOriginalFile();
						}
						else
						{
							$thumbnail = $thumbObjs[$duplicateName];
						}

						if ($duplicateRef === $this->mainImageKey)
						{
							 $duplicateObj = $this;
						}
						elseif ($duplicateRef === $this->originalImageKey)
						{
							 $duplicateObj = $this->getOriginalFile();
						}
						else
						{
							 $duplicateObj = $thumbObjs[$duplicateRef];
						}

						$databaseID = $thumbnail->getMeta('databaseID');
						$thumbnail->setMetaObj($duplicateObj->getMetaObj());
						$thumbnail->setMeta('databaseID', $databaseID);  // keep dbase id the same, otherwise it won't write this thumb to DB due to same ID.

				 }
			}

			// Remove Temp Files
			$this->flushOptimizeData();

      $this->saveMeta();
			update_post_meta($this->get('id'), '_wp_attachment_metadata', $wpmeta);

			if (is_array($WPMLduplicates) && count($WPMLduplicates) > 0)
			{
				// Run the WPML duplicates
				foreach($WPMLduplicates as $duplicate_id)
				{
						// Get this Object cacheless, because it can create records when loading.
						$duplicateObj = $fs->getImage($duplicate_id, 'media', false);

						// Save the exact same data under another post. Don't duplicate it, when already there.
						if ($duplicateObj->getParent() === false)
						{
							$this->createDuplicateRecord($duplicate_id);
						}
						$duplicate_meta = wp_get_attachment_metadata($duplicate_id);
						$duplicate_meta = array_merge($duplicate_meta, $wpmeta);

						update_post_meta($duplicate_id, '_wp_attachment_metadata', $duplicate_meta);
				}
			}

      return $return;
  }

  public function getImprovements()
  {
        $improvements = array();
        $count = 0;
        $totalsize = 0;
        $totalperc = 0;

        if ($this->isOptimized())
        {
           $perc = $this->getImprovement();
           $size = $this->getImprovement(true);
					 if (! is_null($size))
           	$totalsize += $size;
					 if (! is_null($perc))
					 	$totalperc += $perc;

           $improvements['main'] = array($perc, $size);
           $count++;
        }

        foreach($this->thumbnails as $thumbObj)
        {
           if (! $thumbObj->isOptimized())
             continue;

           if (! isset($improvements['thumbnails']))
           {
                $improvements['thumbnails'] = array();
           }
           $perc = $thumbObj->getImprovement();
           $size = $thumbObj->getImprovement(true);
					 if (! is_null($size))
					 {
           	$totalsize += $size;
					 }
					 if (! is_null($perc))
					 {
           	$totalperc += $perc;
				 	 }

           $improvements['thumbnails'][$thumbObj->name] = array($perc, $size);
           $count++;
        }

        if ($count == 0)
          return false; // no improvements;

        $improvements['totalpercentage']  = round($totalperc / $count);
        $improvements['totalsize'] = $totalsize;
        return $improvements;
  }


  /** Function to go from path -> thumbnail mode.  This should be used for unlisted etc, but nothing that already is loaded in thumbnails.
	*  @param String Full Path to the Thumbnail File
  *   @return Object ThumbnailModel
  * */
  private function getThumbnailModel($path, $size)
  {
      $thumbObj = new MediaLibraryThumbnailModel($path, $this->id, $size);
      return $thumbObj;
  }

  protected function loadMeta()
  {
			$metadata = $this->getDBMeta();
      $settings = \wpSPIO()->settings();

      $this->image_meta = new ImageMeta();
      $fs = \wpSPIO()->fileSystem();

      if (! $metadata)
      {
          // Thumbnails is a an array of ThumbnailModels
          $this->thumbnails = $this->loadThumbnailsFromWP();

          $result = $this->checkLegacy();
          if ($result)
          {
            $this->saveMeta();
						//$metadata = $this->GetDbMeta();
          }
      }
      elseif (is_object($metadata) )
      {
          $this->image_meta->fromClass($metadata->image_meta);

          // Loads thumbnails from the WordPress installation to ensure fresh list, discover later added, etc.
          $thumbnails = $this->loadThumbnailsFromWP();

          foreach($thumbnails as $name => $thumbObj)
          {
             if (isset($metadata->thumbnails[$name])) // Check WP thumbs against our metadata.
             {
                $thumbMeta = new ImageThumbnailMeta();
                $thumbMeta->fromClass($metadata->thumbnails[$name]); // Load Thumbnail data from our saved Meta in model

                // Only get data from WordPress meta if we don't have that yet.

                if (is_null($thumbMeta->originalWidth))
                  $thumbObj->setMeta('originalWidth', $thumbObj->get('width'));

                if (is_null($thumbMeta->originalHeight))
                  $thumbObj->setMeta('originalHeight', $thumbObj->get('height'));

                if (is_null($thumbMeta->tsAdded))
                  $thumbObj->setMeta('tsAdded', time());

                $thumbnails[$name]->setMetaObj($thumbMeta);
                unset($metadata->thumbnails[$name]);
             }
          }

          // Load Unlisted Thumbnails.
          if (property_exists($metadata,'thumbnails') && count($metadata->thumbnails) > 0) // unlisted in WordPress metadata sizes. Might be special unlisted one, one that was removed etc.
          {
             foreach($metadata->thumbnails as $name => $thumbMeta) // <!-- ThumbMeta is Object
             {
               // Load from Class and file, might be an unlisted one. Meta doesn't save file info, so without might prove a problem!

               // If file is not set, it's indication it's not a unlisted image, we can't add it.
               if (! property_exists($thumbMeta, 'file'))
                 continue;

               $thumbObj = $this->getThumbnailModel($this->getFileDir() . $thumbMeta->file, $name);

               $newMeta = new ImageThumbnailMeta();
               $newMeta->fromClass($thumbMeta);
               $thumbObj->setMetaObj($newMeta);
               $thumbObj->setName($name);

               if ($thumbObj->exists()) // if we exist.
               {
                $thumbnails[$name] = $thumbObj;
               }

             }
          }
          $this->thumbnails = $thumbnails;

          if (property_exists($metadata, 'retinas') && count($metadata->retinas) > 0 )
          {
              $retinas = $this->getRetinas();
              foreach($metadata->retinas as $name => $retinaMeta)
              {
                  if (isset($retinas[$name]))
                  {
                    $retfile = $retinas[$name];
                    $retinaObj = $this->getThumbnailModel($retfile->getFullPath(), $name);
                    $retMeta = new ImageThumbnailMeta();
                    $retMeta->fromClass($retinaMeta);
                    $retinaObj->setMetaObj($retMeta);
										$retinaObj->setName($name);
										$retinaObj->setImageType(self::IMAGE_TYPE_RETINA);
										$retinaObj->is_retina = true;

                    $this->retinas[$name] = $retinaObj;
                  }
              }
          }


          $orFile = $this->getOriginalFile();

          if ($orFile)
          {
            $orMeta = new ImageThumbnailMeta();
						if (property_exists($metadata, 'original_file') && is_object($metadata->original_file))
						{
            	$orMeta->fromClass($metadata->original_file);
						}
            $orFile->setMetaObj($orMeta);
						$orFile->setName($this->originalImageKey);
            $this->original_file = $orFile;
          }


      }

      // settings defaults
      if (is_null($this->getMeta('originalHeight')))
        $this->setMeta('originalHeight', $this->get('height') );

      if (is_null($this->getMeta('originalWidth')))
        $this->setMeta('originalWidth', $this->get('width') );

				$this->loadLooseItems();
  }

	protected function getDBMeta()
	{
		 global $wpdb;

		 // Main Image.
		 $sqlQuery = 'SELECT * FROM ' . $wpdb->prefix . 'shortpixel_postmeta WHERE attach_id = %d ORDER BY parent ASC';
		 $sqlPrep = $wpdb->prepare($sqlQuery, $this->id);
		 $meta = $wpdb->get_results($sqlPrep);

		 // If metadata is null and the last-error discussed about exist (and probably doesn't exist), check the table. s
		 if (count($meta) == 0 && strpos($wpdb->last_error, 'exist') !== false)
		 {
			  InstallHelper::checkTables();
				return false;
		 }
		 elseif (count($meta) == 1 && $meta[0]->image_type == self::IMAGE_TYPE_DUPLICATE)
		 {
				$duplicate_id = (int) $meta[0]->parent;
				$sqlPrep = $wpdb->prepare($sqlQuery, $duplicate_id);
				$meta = $wpdb->get_results($sqlPrep);
				$this->parent =  $duplicate_id;

		 }
		 elseif (count($meta) == 0) // no records, no object.
		 {

			 $duplicates = $this->getWPMLDuplicates();
			 if (count($duplicates) > 0) //duplicates found, but not saved.
			 {
				 $in_str_arr = array_fill( 0, count( $duplicates ), '%s' );
				 $in_str = join( ',', $in_str_arr );

				 $prepare = array_merge( array(self::IMAGE_TYPE_MAIN), $duplicates);

				 $sql = 'SELECT attach_id FROM ' . $wpdb->prefix . 'shortpixel_postmeta WHERE image_type = %d and attach_id in ( ' . $in_str . ') ';
				 $sql = $wpdb->prepare($sql, $prepare);

				 $parent_id = $wpdb->get_var($sql);

				 if (is_numeric($parent_id))
				 {
					  $this->createDuplicateRecord($this->id, $parent_id);

						$sqlPrep = $wpdb->prepare($sqlQuery, $parent_id);
						$meta = $wpdb->get_results($sqlPrep); // get the parent meta.
				 }
				 else {
				 	  return false;
				 }
			 }
			 else {
			 		 return false;
			 }

		 }

		 // Thumbnails

		// Mimic the previous SPixel solution regarding the return Metadata Object needed, with all thumbnails there.
		 $metadata = new \stdClass;
		 $metadata->image_meta = new \stdClass;
		 $metadata->thumbnails = array();

		 //$metadata = new \stdClass; // main image
	   for($i = 0; $i < count($meta); $i++)
		 {
			 	 	$record = $meta[$i];

					// @todo Here goes all the table stuff looking like metadata objects.
					$data = new \stdClass;
					$data->databaseID = $record->id;
					$data->status = $record->status;
					$data->compressionType = $record->compression_type;
					$data->compressedSize = $record->compressed_size;
					$data->originalSize = $record->original_size;

					// @todo This needs to be Mysql TimeStamp -> Unix TS-ilized.
					$data->tsAdded = UtilHelper::DBtoTimestamp($record->tsAdded);
					$data->tsOptimized = UtilHelper::DBtoTimestamp($record->tsOptimized);

					// [...]
					$extra_info = json_decode($record->extra_info);

					// @todo Extra info should probably be stored as JSON?
					if (! is_null($extra_info))
					{
						foreach($extra_info as $name => $val)
						{
							 $data->$name = $val;
						}

						if ($record->parent == 0 && $record->image_type == self::IMAGE_TYPE_MAIN)
						{
							// Database ID should probably also be stored for the thumbnails, so updating / insert into the database will be easier. We have a free primary key, so why not use it?
								$metadata->image_meta  = $data;
						}
						elseif ($record->parent == 0 && $record->image_type = self::IMAGE_TYPE_RETINA)
						{
									$metadata->retinas[$this->mainImageKey] = $data;
						}
						elseif($record->parent > 0)  // Thumbnails
						{
							 switch($record->image_type)
							 {
								 	 case self::IMAGE_TYPE_THUMB:
									 	$metadata->thumbnails[$record->size] = $data;
									 break;
									 case self::IMAGE_TYPE_RETINA:
									 	$metadata->retinas[$record->size] = $data;
									 break;
									 case self::IMAGE_TYPE_ORIGINAL:
									 	$metadata->original_file = $data;
									 break;
							 }

						}
				} // extra info if
		 } // loop

		 return $metadata;
	}

	/*
	*
	*/
	// @todo Test with retinas, they probably won't work because named after thumbname or 0

	protected function saveDBMeta()
	{
	  $records = array();
		$records[] = $this->createRecord($this->toClass(), self::IMAGE_TYPE_MAIN);


		$thumbObjs = $this->getThumbObjects();
		foreach($thumbObjs as $thumbObj)
		{

			$name = $thumbObj->get('name');
			$type = $thumbObj->get('imageType');

			if ($type == self::IMAGE_TYPE_ORIGINAL)
				$name = null;

			$records[] = $this->createRecord($thumbObj->toClass(), $type, $name);

		}

		 $this->cleanupDatabase($records);

	}


	private function createRecord($data, $imageType, $sizeName = null)
	{
		 global $wpdb;
		 $table = $wpdb->prefix . 'shortpixel_postmeta';

		 $attach_id = $this->id;

		 $parent = ($imageType == self::IMAGE_TYPE_MAIN) ? 0 : $this->id;

		 if ($imageType == self::IMAGE_TYPE_DUPLICATE)
		 {
			  $attach_id = $data->attach_id;
				$parent = $data->parent;

				unset($data->attach_id);
				unset($data->parent);
		 }


		 $fields = array(
			 	'attach_id' => $attach_id,
				'parent' => $parent,
				'image_type' => $imageType,
				'size' => $sizeName,
				'status' => $data->status,
				'compression_type' => $data->compressionType,
				'compressed_size' => $data->compressedSize,
				'original_size' => $data->originalSize,
				'tsAdded' => UtilHelper::timestampToDB($data->tsAdded),
				'tsOptimized' => UtilHelper::timestampToDB($data->tsOptimized),
		 );

		 unset($data->status);
		 unset($data->compressionType);
		 unset($data->compressedSize);
		 unset($data->originalSize);
		 unset($data->tsAdded);
		 unset($data->tsOptimized);

		 if (property_exists($data, 'databaseID') && intval($data->databaseID) > 0)
		 {
			 $databaseID = $data->databaseID;
			 $insert = false;
		 }
		 else {
		 	 $insert = true;
		 }

		 if(property_exists($data, 'databaseID')) // It can be null on init.
		 {
			 unset($data->databaseID);
		 }

		 if (property_exists($data, 'errorMessage'))
		 {
			  if (is_null($data->errorMessage) || strlen(trim($data->errorMessage)) == 0)
				{
					 unset($data->errorMessage);
				}
		 }

		 foreach ($data as $index => $value)
		 {
			   if (is_null($value)) // don't store things that are null
				 	{
						unset($data->$index);
					}
		 }

		 $fields['extra_info'] = wp_json_encode($data); // everything else

		 $format = array('%d', '%d','%d', '%s', '%d', '%d', '%d', '%d', '%s', '%s', '%s');

		 if ($insert === true)
		 {
			  $result = $wpdb->insert($table, $fields, $format);
				$database_id = $wpdb->insert_id;

				if (false === $result)
				{
					 Log::addError('Database error inserting metadata: ',$fields);
				}

				switch($imageType)
				{
					 case self::IMAGE_TYPE_MAIN:
					 		$this->setMeta('databaseID', $database_id);
					 break;
					 case self::IMAGE_TYPE_THUMB:
					 		$this->thumbnails[$sizeName]->setMeta('databaseID', $database_id);
					 break;
					 case self::IMAGE_TYPE_RETINA:
					 		$this->retinas[$sizeName]->setMeta('databaseID', $database_id);
					 break;
					 case self::IMAGE_TYPE_ORIGINAL:
					 		$this->original_file->setMeta('databaseID', $database_id);
					 break;
				}
		 }
		 else {
			 	$result = $wpdb->update($table, $fields,  array('id' => $databaseID),$format, array('%d'));
				$database_id = $databaseID;
				if (false === $result)
				{
					 Log::addError('Database error updating metadata: ',$fields);
				}

		 }



		 return $database_id;
	}

	private function createDuplicateRecord($duplicate_id, $parent = null)
	{
		  $data = new \StdClass;

			$data->parent = ($parent === null) ? $this->id : $parent;
			$data->attach_id = $duplicate_id;
			$imageType = self::IMAGE_TYPE_DUPLICATE;

			$data->status = null;
			$data->tsOptimized = null;
			$data->tsAdded = null;
			$data->compressionType = null;;
			$data->originalSize = null;
			$data->compressedSize = null;

			$this->parent = $data->parent;

		  $this->createRecord($data, $imageType);
	}

	private function cleanupDatabase($records)
	{
		 global $wpdb;

		 // Empty numbers might erase the whole thing.
		 $records = array_filter($records, 'intval');
		 if (count($records) == 0)
		 	return;


		 $in_str_arr = array_fill( 0, count( $records ), '%s' );
		 $in_str = join( ',', $in_str_arr );

		 $prepare = array_merge( array($this->id), $records);

		 $sql = 'DELETE FROM ' . $wpdb->prefix . 'shortpixel_postmeta WHERE attach_id = %d and id not in (' . $in_str . ') ';
		 $sql = $wpdb->prepare($sql, $prepare);

		 $wpdb->query($sql);
	}



 public function saveMeta()
 {
	   global $wpdb;

		 $this->saveDBMeta();

  }

  /** Delete the ShortPixel Meta. */
  public function deleteMeta()
  {
		global $wpdb;

     $this->resetPrevent();


		 $sql = 'DELETE FROM ' . $wpdb->prefix . 'shortpixel_postmeta WHERE attach_id = %s';
		 $sql = $wpdb->prepare($sql, $this->id);

		 $bool = $wpdb->query($sql);

     return $bool;
  }

  /** Ondelete is trigger by WordPress deleting an image. SPIO should delete it's data, and backups */
	// FileDelete param for subclass compat.
  public function onDelete($fileDelete = false)
  {
			$WPMLduplicates = $this->getWPMLDuplicates();

			$fileDelete = (count($WPMLduplicates) == 0) ? true : false;
			$fs = \wpSPIO()->filesystem();

			// Load before removing meta.
			$isConverted = $this->getMeta()->convertMeta()->isConverted();


			// If file is converted, the backup path can live somewhere else ( on the converted item ), so search in this context instead of imagemodel which will only look for same extension backups.
			if (true === $isConverted)
			{
				 $args = array('forceConverted' => true);
				 if ($this->hasBackup($args))
				 {
					  $file = $this->getBackupFile($args);

						if ($file->exists())
							$file->delete();
				 }

				 $thumbObjs = $this->getThumbObjects();
				 foreach($thumbObjs as $thumbObj)
				 {
					  if ($thumbObj->hasBackup($args))
						{
							 $file = $thumbObj->getBackupFile($args);
							 if ($file->exists())
							 {
								  $file->delete();
							 }
						}
				 }


			}

			if (true === $this->getMeta()->convertMeta()->hasPlaceHolder())
			{
		 				$placeholderFile = $fs->getFile($this->getFileDir() . $this->getMeta()->convertMeta()->getReplacementImageName());

						if (true === $placeholderFile->exists())
						{
								$placeholderFile->delete();
						}
			}

			if ($fileDelete === true)
			   	parent::onDelete();


      foreach($this->thumbnails as $thumbObj)
      {
				if ($fileDelete === true)
        	$thumbObj->onDelete($fileDelete);
      }

      if ($this->isScaled())
      {
         $originalFile = $this->getOriginalFile();
				 if ($fileDelete === true)
				 		$originalFile->onDelete($fileDelete);
      }

			if (! is_null($this->retinas))
			{
				foreach($this->retinas as $retinaObj)
				{
					if ($fileDelete === true)
					{
						$retinaObj->onDelete($fileDelete);
					}
				}
			}


		 	$this->removeLegacy();
      $this->deleteMeta();
			$this->dropFromQueue();

			$current_id = $this->id;

			/* perhaps not needed if (is_array($WPMLduplicates) && count($WPMLduplicates) > 0)
			{
				foreach($WPMLduplicates as $duplicate_id)
				{
					  $this->id = $duplicate_id;
						$this->removeLegacy();
						$this->deleteMeta();
						$this->dropFromQueue();
				}
			} */
  }

	public function dropFromQueue()
	{

		 $optimizeController = new OptimizeController();

		 $q = $optimizeController->getQueue($this->type);
		 $q->dropItem($this->get('id'));

		 // Drop also from bulk if there.

		 $optimizeController->setBulk(true);

		 $q = $optimizeController->getQueue($this->type);
		 $q->dropItem($this->get('id'));
	}

  public function getThumbNail($name)
  {
     if (isset($this->thumbnails[$name]))
        return $this->thumbnails[$name];

      return false;
  }

  /* Check if an image in theory could be processed. Check exclusions, thumbnails etc. */
  /* @param Strict Boolean Check only the main image, don't check thumbnails */
  public function isProcessable($strict = false)
  {
      $bool = true;
      $bool = parent::isProcessable();

      $settings = \wpSPIO()->settings();

			// If already true, this item can be processed. No need for further checks.
      if($strict || true === $bool)
			{
        return $bool;
			}

			// Never allow optimizePrevented to be processable
			if (true === $this->isOptimizePrevented())
			{
				 return false;
			}

			// The exclude size on the main image - via regex - if fails, prevents the whole thing from optimization.
			if ($this->processable_status == ImageModel::P_EXCLUDE_SIZE || $this->processable_status == ImageModel::P_EXCLUDE_PATH)
			{
				 return $bool;
			}

      if (! $bool) // if parent is not processable, check if thumbnails are, can still have a work to do.
      {

					$thumbObjs = $this->getThumbObjects();

          foreach($thumbObjs as $thumbnail)
          {

            $bool = $thumbnail->isThumbnailProcessable();

            if ($bool === true) // Is Processable just needs one job
              return true;

						if ($thumbnail->isOptimized() && true === $thumbnail->isProcessableAnyFileType())
              return true;

          }

      }

			// First test if this file isn't unprocessable for any other reason, then check.
			if (($this->isProcessable(true) || $this->isOptimized() ) && $this->isProcessableAnyFileType() === true)
			{
				if (false === $this->is_directory_writable())
				{
					$this->processable_status = ImageModel::P_DIRECTORY_NOTWRITABLE;
					$bool = false;
				}
				else {
					$bool = true;
				}
			}

      return $bool;
  }



  public function isRestorable()
  {
      $bool = true;
      $bool = parent::isRestorable();


      if (! $bool) // if parent is not processable, check if thumbnails are, can still have a work to do.
      {
          foreach($this->thumbnails as $thumbnail)
          {
            if (! $thumbnail->isOptimized())
               continue;

            $bool = $thumbnail->isRestorable();

            if ($bool === true) // Is Restorable just needs one job
              return true;
          }
          if ($this->isScaled() && ! $bool)
          {
             $originalFile = $this->getOriginalFile();
             $bool = $originalFile->isRestorable();
          }
      }

      return $bool;
  }



  public function conversionPrepare($args = array())
	{
		$settings = \wpSPIO()->settings();
		$bool = false;

		$defaults = array(
			'checksum' => 1,
			'replacementPath' => null,
		);
		$args = wp_parse_args($args, $defaults);

		if ($settings->backupImages == 1)
		{
			// only one file needed.
			if ($this->isScaled())
			{
				 $backupok = $this->getOriginalFile()->createBackup();
			}
			else {
					$backupok = $this->createBackup();
			}

			 if (! $backupok)
			 {
				 $response = array(
						'is_error' => true,
						'item_type' => ResponseController::ISSUE_FILE_NOTWRITABLE,
						'message ' => __('ConvertPNG could not create backup. Please check file permissions', 'shortpixel-image-optimiser'),
				 );
					ResponseController::addData($this->get('id'), $response);

					// Bail out with setting flag, so not to repeat.
				 $this->getMeta()->convertMeta()->setTried($args['checksum']);
				 $this->getMeta()->convertMeta()->setError(Converter::ERROR_BACKUPERROR);

				 $this->saveMeta();

				 return false;
			 }

			 $thumbObjs = $this->getThumbObjects();
			 foreach($thumbObjs as $thumbObj)
			 {
				 $result = $thumbObj->createBackup();
				 if (false === $result)
				 {
					  Log::addWarning('Backup failed on Thumbitem ' . $thumbObj->getFullPath());
				 }
			 }

		}

		// Saving Meta to keep filesizes in case everything is offload-deleted.
		$this->saveMeta();

		 return true;
	}

	public function conversionFailed($args = array())
	{
		$settings = \wpSPIO()->settings();

		$defaults = array('checksum' => 1);
		$args = wp_parse_args($args, $defaults);

		if ($settings->backupImages == 1)
		{
			 // When failed, delete the backups. This can't be done via restore since image is not optimized.
			 $backupFile = $this->getBackupFile();
			 if (is_object($backupFile) && $backupFile->exists())
			 {
				 $backupFile->delete();
			 }

			 $thumbObjs = $this->getThumbObjects();
			 foreach($thumbObjs as $thumbnail)
			 {
					$backupFile = $thumbnail->getBackupFile();
					// check if there is backup and if file exists.
					if (is_object($backupFile) && $backupFile->exists())
						 $backupFile->delete();
			 }

		}
		// Prevent from retrying next time, since stuff will be requeued.
		$this->getMeta()->convertMeta()->setTried($args['checksum']);
		$this->getMeta()->convertMeta()->setReplacementImageBase(false);

		$this->flushOptimizeData();
		$this->saveMeta();

	}

	public function conversionSuccess($args = array())
	{
		 $fs = \wpSPIO()->filesystem();
		 $defaults = array(
			 'checksum' => 1,
			 'omit_backup' => true,
	 			);

 	   $args = wp_parse_args($args, $defaults);

		 $this->getMeta()->convertMeta()->setConversionDone($args['omit_backup']);
		 $mainfile = \wpSPIO()->filesystem()->getfile($this->getFileDir() . $this->getFileBase() . '.jpg');

		 if ($this->exists()) // success, remove converted file.
		 {
				 $this->delete(); // remove the old file.
				 $this->fullpath = $mainfile->getFullPath();
				 $this->resetStatus();
				 $this->setFileInfo();
		 }

		 // After Convert, reload new meta.
		$this->thumbnails = $this->loadThumbnailsFromWP();
		$this->retinas = null;

		$thumbnails = $this->getThumbObjects();

		 foreach($thumbnails as $thumbObj)
		 {
				 $file = $fs->getFile($thumbObj->getFileDir() . $thumbObj->getFileBase() . '.jpg');

				 if ($thumbObj->exists()) // if new exists, remove old
				 {
						 $thumbObj->delete(); // remove the old file.
						 $thumbObj->fullpath = $file->getFullPath();
						 $thumbObj->resetStatus();
						 $thumbObj->setFileInfo();
				 }

		 }

		$this->wp_metadata = null;  // Remove caching on this one.

		$fs->flushImageCache();
		$this->flushOptimizeData();
		$this->getMeta()->convertMeta()->setTried($args['checksum']);
		$this->getMeta()->convertMeta()->setReplacementImageBase(false);

		$this->saveMeta();
	}

  protected function setOriginalFile()
  {
    $fs = \wpSPIO()->filesystem();

    if (is_null($this->id))
      return false;

    $originalFile = $fs->getOriginalImage($this->id);
		$originalFile->setName($this->originalImageKey); // required for named API requests et al.
		$originalFile->setImageType(self::IMAGE_TYPE_ORIGINAL);

    if ($originalFile->exists() && $originalFile->getFullPath() !== $this->getfullPath() )
    {
      $this->original_file = $originalFile;
      $this->is_scaled = true;
    }

  }

  public function hasOriginal()
  {
     if ($this->original_file)
      return true;
    else
      return false;
  }

  public function getOriginalFile()
  {
      if ($this->hasOriginal())
        return $this->original_file;
      else
        return false;
  }


	// Check if this Image has a Parent indicating it's a WPML Duplicate.
	public function getParent()
	{
			if (is_null($this->parent))
			{
				 return false;
			}
			if (is_numeric($this->parent))
			{
				 return $this->parent;
			}

			// Dunno.
			return false;
	}


	/**  Try to find language duplicates in WPML and add the same status to it.
	** @integration WPML
	*
	* Old _icl_lang_duplicate_of method have been removed, seems legacy.
	*/
  public function getWPMLDuplicates()
  {
    global $wpdb;
    $fs = \wpSPIO()->filesystem();
		$env = \wpSPIO()->env();

		$duplicates = array();


		if ($env->plugin_active('wpml'))
		{
				$sql = "select element_id from " . $wpdb->prefix . "icl_translations where trid in (select trid from " . $wpdb->prefix . "icl_translations where element_id = %d) and element_id <> %d";

				$sql = $wpdb->prepare($sql, $this->id, $this->id);


				$results = $wpdb->get_results($sql);

					if (is_array($results))
					{
						foreach($results as $result)
						{
							 	 if ($result->element_id == $this->id)  // don't select your own.
								 {
									 continue;
								 }
								 //$duplicateFile = $fs->getMediaImage($result->element_id);

								 // Check if the path is the same. WPML translations can be linked to different images, so this is important.
								 // Add. Prev. it loaded to whole media Image but this doesn't go well with loadDbMeta checks, so a rougher check now to see if files are similar. In any case if not identifical, should not be threated as such
								 if (get_attached_file($this->id) == get_attached_file($result->element_id))
								 {
								 		$duplicates[] = $result->element_id;
							 	 }

						}
					}
		}  // wpml
		if ($env->plugin_active('polylang')) // polylang
		{
				// unholy sql where guid is duplicated.
				$sql = 'SELECT id FROM ' . $wpdb->prefix . 'posts WHERE guid in (select guid from ' . $wpdb->prefix . 'posts where id = %d ) and post_type = %s and id <> %d';

				$sql = $wpdb->prepare($sql, $this->id, 'attachment', $this->id);
				$results = $wpdb->get_col($sql);

				foreach($results as $index => $element_id)
				{
					 $duplicates[]= intval($element_id);
				}

		}

    return array_unique($duplicates);
  }

  /* Protect this image from being optimized. This flag should be unset by UX / Retry button on front */
  protected function preventNextTry($reason = 1)
  {
      //Log::addError('Call resulted in preventNextTry on thumbnailModel');
      //exit('Fatal error : Prevent Next Try should not be run on thumbnails');
      Log::addWarn($this->get('id') . ' preventing next try: ' . $reason);
      update_post_meta($this->id, '_shortpixel_prevent_optimize', $reason);

  }

  public function isOptimizePrevented()
  {
       if (! is_null($this->optimizePrevented))
			 {
         return $this->optimizePrevented;
			 }

       $reason = get_post_meta($this->id, '_shortpixel_prevent_optimize', true);

       if ($reason === false || strlen($reason) == 0)
       {
         $this->optimizePrevented = false;
         return false;
       }
       else
       {
 			   $this->processable_status = self::P_OPTIMIZE_PREVENTED;
				 $this->optimizePreventedReason  = $reason;
         $this->optimizePrevented = true;
         return true;
       }
  }

  public function resetPrevent()
  {
      delete_post_meta($this->id, '_shortpixel_prevent_optimize');
  }

  /** Removed the current attachment, with hopefully removing everything we set.
  */
  public function restore($args = array())
  {
		$defaults = array(
			'keep_in_queue' => false, // used for bulk restore.
		);

		$args = wp_parse_args($args, $defaults);

    $fs = \wpSPIO()->filesystem();

    do_action('shortpixel_before_restore_image', $this->get('id'));
    do_action('shortpixel/image/before_restore', $this);

    $cleanRestore = true;
		$wpmeta = wp_get_attachment_metadata($this->get('id'));


		// Get them early in case the filename changes ( ie png to jpg ) because it will stop getting it.
		$WPMLduplicates = $this->getWPMLDuplicates();


		$is_resized = $this->getMeta('resize');
		$convertMeta = $this->getMeta()->convertMeta();
		$was_converted = $convertMeta->isConverted() && true == $convertMeta->omitBackup();
		$converter = Converter::getConverter( clone $this); // ugly, but no way around.

		// ** Warning - This will also reset metadata ****
    $bool = parent::restore();


		if ($is_resized)
		{
			$wpmeta['width'] = $this->get('width');
			$wpmeta['height'] = $this->get('height');
		}
		$wpmeta['filesize'] = $this->getFileSize();

		// Loading this early because of all the resetting.
		$webps = $this->getWebps();
		$avifs = $this->getAvifs();

		if ($was_converted)
		{
			 if ($bool)
			 {
			 	$bool = $this->restoreConversion($convertMeta, $converter);
				$wpmeta = wp_get_attachment_metadata($this->get('id')); // png2jpg resets WP metadata.
				$this->resetStatus();
				$this->setFileInfo();
			 }
			 else
			 {
		 	 	return $bool;
			 }
		}


    if (! $bool)
    {
       $cleanRestore = false;
    }

    $restored = array();

    foreach($this->thumbnails as $thumbObj)
    {
          $filebase = $thumbObj->getFileBase();
					$is_resized = $thumbObj->getMeta('resize');
					$size = $thumbObj->get('size');
					$unlisted_file = $thumbObj->getMeta('file');

					// **** AFTER THIS IMAGE DATA IS WIPED! **** /
          if (isset($restored[$filebase]))
          {
            $bool = true;  // this filebase already restored. In case of duplicate sizes.
            $thumbObj->image_meta = new ImageThumbnailMeta();
          }
          elseif ($thumbObj->isRestorable())
					{
            $bool = $thumbObj->restore(); // resets metadata
						if (! $bool)
						{
							$cleanRestore = false;
						}
						else
						{
							 $restored[$filebase] = true;
						}
					}
					else {
						Log::addWarn('Thumbnail not restorable ' . $size,  $this->getReason('restorable'));
					}

					if ($unlisted_file === null)
					{

						if ($is_resized)
						{
								$wpmeta['sizes'][$size]['width'] = $thumbObj->get('width');
								$wpmeta['sizes'][$size]['height']  = $thumbObj->get('height');
						}

						$wpmeta['sizes'][$size]['filesize'] = $thumbObj->getFileSize();
					}

					$thumbObj->resetStatus();
					$thumbObj->setFileInfo();

    }

		if (! is_null($this->retinas))
		{
			$restored = array();

			foreach($this->retinas as $name => $retinaObj)
			{
					$filebase = $retinaObj->getFileBase();
					$size = $retinaObj->get('size');

					if (isset($restored[$filebase]))
          {
            $bool = true;  // this filebase already restored. In case of duplicate sizes.
            $retinaObj->image_meta = new ImageThumbnailMeta();
          }
				  elseif ($retinaObj->isRestorable())
					{
						 $bool = $retinaObj->restore();

						 if (! $bool)
						 {
							 $cleanRestore = false;
						 }
						 else
						 {
								$restored[$filebase] = true;
						 }
					}

			}
		}

    if ($this->isScaled() )
    {
       $originalFile = $this->getOriginalFile();
			 if ($originalFile->isRestorable())
		 	 {
       		$bool = $originalFile->restore();
			 }

    }

        foreach($webps as $webpFile)
				{
						if ($webpFile->exists() && false === $webpFile->is_virtual())
            	$webpFile->delete();
				}

        foreach($avifs as $avifFile)
				{
						if ($avifFile->exists() && false === $avifFile->is_virtual())
            	$avifFile->delete();
				}

				// Any legacy will have false information by now; remove.
				$this->removeLegacy();

        if ($cleanRestore)
        {
            $this->deleteMeta();
        }
        else
				{
          $this->saveMeta(); // Save if something is not restored.
				}

				if ($args['keep_in_queue'] === false)
				{
					$this->dropFromQueue();
				}

				update_post_meta($this->get('id'), '_wp_attachment_metadata', $wpmeta);

        do_action('shortpixel_after_restore_image', $this->id, $cleanRestore); // legacy
				do_action('shortpixel/image/after_restore', $this, $this->id, $cleanRestore);

				if (is_array($WPMLduplicates) && count($WPMLduplicates) > 0 )
				{
					$current_id = $this->id;

					foreach($WPMLduplicates as $duplicate_id)
					{
						 $this->id = $duplicate_id;
						 $this->removeLegacy();

						 $duplicate_meta = wp_get_attachment_metadata($duplicate_id);
						 $duplicate_meta = array_merge($duplicate_meta, $wpmeta);
						 update_post_meta($duplicate_id, '_wp_attachment_metadata', $duplicate_meta);

						 if ($cleanRestore)
						 {
							 	$this->deleteMeta();
						 }
						 else
						 {
							  $this->saveMeta();
						 }
						 do_action('shortpixel_after_restore_image', $this->id, $cleanRestore);
						 do_action('shortpixel/image/after_restore', $this, $this->id,  $cleanRestore);

					}
					$this->id = $current_id;
				}

			// @todo Restore can be false if last item failed, which doesn't sound right.
	    return $bool;
  }

	// This is check for the mainFile.
	public function hasDBRecord()
	{

			global $wpdb;

				$sql = 'SELECT id FROM ' . $wpdb->prefix . 'shortpixel_postmeta WHERE attach_id = %d AND size IS NULL and image_type = %d';
				$sql = $wpdb->prepare($sql, $this->id, self::IMAGE_TYPE_MAIN);

			$id = $wpdb->get_var($sql);

			if (is_null($id))
			{
				 return false;
			}
			elseif (is_numeric($id)) {
				return true;
			}

	}


	/** New Setup of RestorePNG2JPG. Runs after copying backupfile back to uploads.
	* Important: The metadata will be CLEARED already
	*/
	protected function restoreConversion($convertMeta, $converter)
	{
			$fs = \wpSPIO()->filesystem();
			$ext = $convertMeta->getFileFormat();
			// ImageModel restore, restored png file to .jpg file ( due to $this)
			// File has just been restored, but it will be wrong extension in uploads
			//
		//	$backupFile = //$this->getBackupFile(); // Should return as PNG file

		 	$destination = $fs->getFile($this->getFileDir() . $this->getFileBase() . '.' . $ext);

			// If scaled in the name, revert to originalFile.
			if ($this->isScaled())
			{
					$originalFile = $this->getOriginalFile();
					$destination = $fs->getFile($this->getFileDir() . $originalFile->getFileBase() . '.' . $ext);

			}

			// We can't remove files until the end of process because some plugins will block it.
			$toRemove = array();

			// Destination is image.png, the original.
			if (! $destination->exists())
			{
					// This is a PNG content file, that has been restored as a .jpg file which is now main.
					$copyok = $this->copy($destination);
					if (false === $copyok)
					{
						 Log::addError('Copy to destination failed!');
						 ResponseController::addData('message', __('Restore PNG2JPG : Copying PNG to destination failed', 'shortpixel-image-optimiser'));
						 ResponseController::addData('is_error', true);
					}

					$toRemove[] = $this;
			}
			else
			{
				 Log::addError('Restoring Converted image not possible, target already exists');
					ResponseController::addData('message', __('Restore PNG2JPG : Restoring to target that already exists', 'shortpixel-image-optimiser'));
					ResponseController::addData('is_error', true);

					return false;
			}

			$thumbObjs = $this->getThumbObjects();

    	foreach($thumbObjs as $thumbObj)
    	{
							if ($thumbObj->hasBackup())
							{
									$backupFile = $thumbObj->getBackupFile();

									if (is_object($backupFile))
									{
										// This should delete in restore function.
										$backupFile->delete();

										$backupFileJPG = $fs->getFile($backupFile->getFileDir() . $backupFile->getFileBase() . '.jpg');
										if (is_object($backupFileJPG) && $backupFileJPG->exists())
										{
											 $backupFileJPG->delete();
										}
									}
							}

							$toRemove[] = $thumbObj;

    		}

				// Fullpath now will still be .jpg
				// PNGconvert is first, because some plugins check for _attached_file metadata and prevent deleting files if still connected to media library. Exmaple: polylang.
				$converter->restore();

				foreach($toRemove as $fileObj)
				{
					 if (false === $this->is_virtual())
					 {
						 $fileObj->delete();
						 $fileObj->resetStatus();
					 }

					 if ($fileObj->get('is_main_file') == false)
					 {
					 	$fileObj->image_meta = new ImageThumbNailMeta();
					 }
				}

				$this->wp_metadata = null;  // restore changes the metadata.
				$this->thumbnails = $this->loadThumbnailsFromWP();
				$this->retinas = null;

				return true;
	}

  /** This function will recreate thumbnails. This is -only- needed for very special cases, i.e. offload */
  public function wpCreateImageSizes()
  {
    add_filter('as3cf_wait_for_generate_attachment_metadata', array($this, 'returnTrue'));

    $fullpath = $this->getFullPath();
    if ($this->isScaled()) // if scaled, the original file is the main file for thumbnail base
    {
       $originalFile = $this->getOriginalFile();
       $fullpath = $originalFile->getFullPath();
    }
    $res = \wp_create_image_subsizes($fullpath, $this->id);

    remove_filter('as3cf_wait_for_generate_attachment_metadata', array($this, 'returnTrue'));
  }

  public function returnTrue()
  {
     return true;
  }

	// Function to remove all shortpixel related data
	// It's separated from the private function.
	public function removeLegacyShortPixel()
	{
		 $bool = $this->removeLegacy();
		 if ($bool)
		 {
		 		delete_post_meta($this->id, '_shortpixel_was_converted');
				delete_post_meta($this->id, '_shortpixel_status');
		 }
	}

	/** Utility function to create a loopable object of thumbnails, retinas and scaled (if so) and other object with thumbnailModel . Goal is to prevent several functions having to do the same operation on array with different names ( optimized, getOptimizeUrl, etc )
	* @return Object Iterator
	*/
	private function getThumbObjects()
	{
			$objects = $this->thumbnails;
			$retinas = $this->getRetinas();

			if (! is_null($retinas) && is_array($retinas))
			{
					foreach($retinas as $retinaObj)
					{
						 $objects['retina_' . $retinaObj->get('name')] = $retinaObj;
					}
//				 $objects = array_merge($objects, $this->retinas);
			}
			if ($this->isScaled())
			{
				 $objects[$this->originalImageKey] = $this->getOriginalFile();
			}

			return $objects;
	}

	 // Load items that might be processable but not in WP metadata or other meta's .
	 // used for IsProcessable ( check if we have something ) and handleOptimized ( to check against the optimized stuff )
	private function loadLooseItems()
	{
			// Load items that might be not recorded when loading.
			$this->addUnlisted();
			$this->getRetinas();
	}

	private function generateThumbnails()
	{
	 	 $metadata = wp_generate_attachment_metadata($this->get('id'), $this->getFullPath());
		 return $metadata;
	}

	// Check and remove legacy data.
	// If metadata is removed in a restore process, the legacy data will be reimported, which should not happen.
	/* @return bool If legacy data was found and removed or not */
	private function removeLegacy()
	{
		$metadata = $this->getWPMetaData();
		$updated = false;


		$unset = array('ShortPixel', 'ShortPixelImprovement', 'ShortPixelPng2Jpg');

		foreach($unset as $key)
		{
			 if (isset($metadata[$key]))
			 {
				  unset($metadata[$key]);
					$updated = true;
			 }
		}

		if ($updated === true)
		{
			wp_update_attachment_metadata($this->id, $metadata);
		}

		return $updated;
	}

	// Function to be called only by migrate all bulk and certain debug cases.
	public function migrate()
	{
		$this->resetPrevent();

		// Don't double.
		if ($this->justConverted === true)
			return;

		delete_post_meta($this->id, '_shortpixel_was_converted');
		$result = $this->checkLegacy();

		// Check the whole thing to find any images that have a backup, but are not marked as optimized, and just mark them.
		if (! $this->isOptimized() && $this->hasBackup() )
		{
			$this->setMeta('status', self::FILE_STATUS_SUCCESS);
			$result = true;
		}
		if ($this->hasOriginal())
		{
			 $originalFile = $this->getOriginalFile();
			 if (! $originalFile->isOptimized() && $originalFile->hasBackup() )
			 {
				  $originalFile->setMeta('status', self::FILE_STATUS_SUCCESS);
					$result = true;
			 }
		}
		if (is_array($this->thumbnails) && count($this->thumbnails) > 0)
		{
			 foreach($this->thumbnails as $thumbObj)
			 {
				   if (! $thumbObj->isOptimized() && $thumbObj->hasBackup())
					 {
						  $thumbObj->setMeta('status', self::FILE_STATUS_SUCCESS);
							$result = true;
					 }
			 }
		}
		if (is_array($this->retinas) && count($this->retinas) > 0)
		{
			 foreach($this->retinas as $retinaObj)
			 {
				 	if (! $retinaObj->isOptimized() && $retinaObj->hasBackup())
					{
						 $retinaObj->setMeta('status', self::FILE_STATUS_SUCCESS);
						 $result = true;
					}

			 }
		}


		if ($result)
		{
			$this->saveMeta();
		}
	}

  // Convert from old metadata if needed.
  private function checkLegacy()
  {
      $metadata = $this->getWPMetaData();

      if (! isset($metadata['ShortPixel']))
      {
        return false;
      }

      $data = $metadata['ShortPixel'];

      if (count($data) == 0)  // This can happen. Empty array is still nothing to convert.

        return false;

			// Waiting for processing is a state where it's not optimized, or should be.
			// The last check is because it seems that it can be both improved and waiting something ( sigh ) // 04/07/22
			if (count($data) == 1 && isset($data['WaitingProcessing']) && ! isset($data['ShortPixelImprovement']))
			{
				 return false;
			}

      // This is a switch to prevent converted items to reconvert when the new metadata is removed ( i.e. restore )
      $was_converted = get_post_meta($this->id, '_shortpixel_was_converted', true);
      if ($was_converted == true || is_numeric($was_converted))
      {
				$updateTs = 1656892800; // July 4th 2022 - 00:00 GMT
				if ($was_converted < $updateTs && $this->hasBackup(array('noConversionCheck' => true)))
				{
					$this->resetPrevent();  // reset any prevented optimized. This would have prob. thrown a backup issue.
					if ($this->isProcessable())
					{
						 $this->deleteMeta();
						 Log::addDebug('Conversion pre-bug detected with backup and still processable. Trying to fix by redoing legacy.');
					}

				}
				else {
				   Log::addDebug('No SPIO5 metadata, but this item was converted, not converting again');
					 return false;
				}
      }

			$quotaController = QuotaController::getInstance();
			if ($quotaController->hasQuota() === true)
			{
				$adminNotices = AdminNoticesController::getInstance();
				$adminNotices->invokeLegacyNotice();
			}

        Log::addDebug("Conversion of legacy: " . $this->get('id'), array($metadata));

       $type = isset($data['type']) ? $this->legacyConvertType($data['type']) : '';

       $improvement = (isset($metadata['ShortPixelImprovement']) && is_numeric($metadata['ShortPixelImprovement']) && $metadata['ShortPixelImprovement'] > 0) ? $metadata['ShortPixelImprovement'] : 0;

       $status = $this->legacyConvertStatus($data, $metadata);

       $error_message = isset($metadata['ShortPixelImprovement']) && ! is_numeric($metadata['ShortPixelImprovement']) ? $metadata['ShortPixelImprovement'] : '';

    //   $retries = isset($data['Retries']) ? intval($data['Retries']) : 0;
       $optimized_thumbnails = (isset($data['thumbsOptList']) && is_array($data['thumbsOptList'])) ? $data['thumbsOptList'] : array();
       $exifkept = (isset($data['exifKept']) && $data['exifKept']  == 1) ? true : false;

       $tsAdded = time();

			 if ($this->hasDBRecord() === false)
			 {
				 if ($status == self::FILE_STATUS_SUCCESS)
	       {
	         //strtotime($tsOptimized)
					 $thedate = (isset($data['date'])) ? $data['date'] : false;
					 $newdate = \DateTime::createFromFormat('Y-m-d H:i:s', $thedate);

					 if ($newdate === false)
					 {
						 $newdate = \DateTime::createFromFormat('Y-m-d H:i:s', get_post_time('Y-m-d H:i:s', false, $this->id));
					 }

					 /// If not date could be established just omit.
					 if ($newdate !== false)
					 {
	         	$newdate = $newdate->getTimestamp();
	         	$tsOptimized = $newdate;
	         	$this->image_meta->tsOptimized = $tsOptimized;
					 }
	       }

	       $this->image_meta->wasConverted = true;
	       $this->image_meta->status = $status;
	       //$this->image_meta->type = $type;
	       $this->image_meta->improvement = $improvement;
	       $this->image_meta->compressionType = $type;
	       $this->image_meta->compressedSize = $this->getFileSize();
	     //  $this->image_meta->retries = $retries;
	       $this->image_meta->tsAdded = $tsAdded;
	     //  $this->image_meta->has_backup = $this->hasBackup();
	       $this->image_meta->errorMessage = $error_message;

	       $this->image_meta->did_keepExif = $exifkept;

		      if ($this->hasBackup(array('noConversionCheck' => true)))
		      {
		        $backup = $this->getBackupFile(array('noConversionCheck' => true));
						if (is_object($backup))
		        	$this->image_meta->originalSize = $backup->getFileSize();
		      }
					elseif ( isset($metadata['ShortPixelImprovement']))
					{
						 // If the improvement is set, calculate back originalsize.
						 $imp = intval($metadata['ShortPixelImprovement']); // try to make int. Legacy can contain errors / message / crap here.
		 			   if ($imp > 0)
		 				  	$this->image_meta->originalSize = ($this->getFileSize() / (100 - $imp)) * 100;
					}


	        $this->image_meta->webp = $this->checkLegacyFileTypeFileName($this, 'webp');
					$this->image_meta->avif = $this->checkLegacyFileTypeFileName($this, 'avif');


	       $this->width = isset($metadata['width']) ? $metadata['width'] : false;
	       $this->height = isset($metadata['height']) ? $metadata['height'] : false;

				 $this->recordChanged(true);
			 }

       if (isset($metadata['ShortPixelPng2Jpg']))
       {

           $this->image_meta->did_png2jpg = true; //setMeta('did_png2jpg', true);
					 $this->getMeta()->convertMeta()->setFileFormat('png');
					 $this->getMeta()->convertMeta()->setConversionDone();
           $did_jpg2png = true;
       }
       else
           $did_jpg2png = false;
    //   $this->image_meta->did_cmyk2rgb = $exifkept;
      // $this->image_meta->tsOptimized =

       foreach($this->thumbnails as $thumbname => $thumbnailObj) // ThumbnailModel
       {
				  if ($thumbnailObj->hasDBRecord() === true)
					{
						continue;
					}

          if (in_array($thumbnailObj->getFileName(), $optimized_thumbnails) || $thumbnailObj->hasBackup(array('noConversionCheck' => true)) )
          {
              $thumbnailObj->image_meta->status = $status;
              $thumbnailObj->image_meta->compressionType = $type;
              $thumbnailObj->image_meta->compressedSize = $thumbnailObj->getFileSize();
							/*if (true == $did_jpg2png)
							{
								$thumbnailObj->convertMeta()->setConversionDone();
							}*/


          //    $thumbnailObj->image_meta->improvement = -1; // n/a
              if ($thumbnailObj->hasBackup(array('noConversionCheck' => true)))
              {
                $backup = $thumbnailObj->getBackupFile(array('noConversionCheck' => true));
								if (is_object($backup))
								{
                	$thumbnailObj->image_meta->originalSize = $backup->getFileSize();
									$thumbnailObj->has_backup = true;
								}
              }
							else
							{
								$thumbnailObj->has_backup = false;
							}

              $thumbnailObj->image_meta->tsAdded = $tsAdded;
              if (isset($tsOptimized))
                $thumbnailObj->image_meta->tsOptimized = $tsOptimized;

							$thumbnailObj->image_meta->webp = $this->checkLegacyFileTypeFileName($thumbnailObj, 'webp');
							$thumbnailObj->image_meta->avif = $this->checkLegacyFileTypeFileName($thumbnailObj, 'avif');

              if (strpos($thumbname, 'sp-found') !== false) // File is 'unlisted', also save file information.
              {
                 $thumbnailObj->image_meta->file = $thumbnailObj->getFileName();
              }

							$thumbnailObj->recordChanged(true);
              $this->thumbnails[$thumbname] = $thumbnailObj;

          }
       }

       if ($this->isScaled() && $this->original_file->hasDBRecord() === false)
       {
         $originalFile = $this->original_file;

         if (isset($metadata['original_image']) || $originalFile->hasBackup(array('noConversionCheck' => true)))
         {

           $originalFile->image_meta->status = $status;
           $originalFile->image_meta->compressionType = $type;
           $originalFile->image_meta->compressedSize = $originalFile->getFileSize();
					 /*if (true == $did_jpg2png)
					 {
						 $originalFile->convertMeta()->setConversionDone();
					 } */

			     if ($originalFile->hasBackup(array('noConversionCheck' => true)))
           {
             $backup = $originalFile->getBackupFile(array('noConversionCheck' => true));
						 if (is_object($backup))
						 {
             	$originalFile->image_meta->originalSize = $backup->getFileSize();
						 	$originalFile->has_backup = true;
						 }
           }
					 else {
					 	$originalFile->has_backup = false;
					 }

           $originalFile->image_meta->tsAdded = $tsAdded;
				   if (isset($tsOptimized))
				 	 {
						 $originalFile->image_meta->tsOptimized = $tsOptimized;
					 }

					 $originalFile->image_meta->webp = $this->checkLegacyFileTypeFileName($originalFile, 'webp');
					 $originalFile->image_meta->avif = $this->checkLegacyFileTypeFileName($originalFile, 'avif');


           if (strpos($thumbname, 'sp-found') !== false) // File is 'unlisted', also save file information.
           {
              $originalFile->image_meta->file = $originalFile->getFileName();
           }

					  $originalFile->recordChanged(true);
						$this->original_file = $originalFile;
          }
       }

       if (isset($data['retinasOpt']))
       {
           $count = $data['retinasOpt']; // a number.
					 $addedCounter = 0;

					 $retinasOpt = $data['retinasOpt'];
           $retinas = $this->getRetinas();

					 if ( intval($retinasOpt) > 0 && is_array($retinas))
					 {
	           foreach($retinas as $index => $retinaObj) // Thumbnail Model
	           {
			 					if ($retinaObj->hasDBRecord() === true)
			  				{
			  						continue;
			  				}

								// Check if thumbnail ('parent') is Optimized, if so, then retina probably should be optimized as well.
								if ( (isset($this->thumbnails[$index]) &&
											is_object($this->thumbnails[$index]) &&
										  $this->thumbnails[$index]->isOptimized) || $retinaObj->hasBackup(array('noConversionCheck' => true)) )
								{
			              $retinaObj->image_meta->status = $status;
			              $retinaObj->image_meta->compressionType = $type;
			              if ($status == self::FILE_STATUS_SUCCESS)
			                $retinaObj->image_meta->compressedSize = $retinaObj->getFileSize();
			              else
			                $retinaObj->image_meta->originalSize = $retinaObj->getFileSize();
			            //  $retinaObj->image_meta->improvement = -1; // n/a
			              $retinaObj->image_meta->tsAdded = $tsAdded;
										if (isset($tsOptimized))
										{
			              	$retinaObj->image_meta->tsOptimized = $tsOptimized;
										}

										/*if (true == $did_jpg2png)
										{
											$retinaObj->convertMeta()->setConversionDone();
										} */

			              if ($retinaObj->hasBackup(array('noConversionCheck' => true)))
			              {
			                $retinaObj->has_backup = true;
			                if ($status == self::FILE_STATUS_SUCCESS)
			                  $retinaObj->image_meta->originalSize = $retinaObj->getBackupFile(array('noConversionCheck' => true))->getFileSize();
			              }

										$retinaObj->recordChanged(true);
			              $retinas[$index] = $retinaObj;
										$addedCounter++;
			           }
							 } // foreach
							 $this->retinas = $retinas;
						 } // is array.
	           if ($count !== $addedCounter)
	           {
	              Log::addWarning("Conversion: $count retinas expected in legacy, " . $addedCounter . 'found. This can be due to overlapping image sizes.');
	           }
       }

       update_post_meta($this->id, '_shortpixel_was_converted', time());
       delete_post_meta($this->id, '_shortpixel_status');

			 $this->justConverted = true;
      return true;
  }

	private function checkLegacyFileTypeFileName($fileObj, $type)
	{
		 	$fileType = $fileObj->getImageType($type);
			if ($fileType !== false)
			{
				return $fileType->getFileName();
			}

			$env = \wpSPIO()->env();
			$fs = \wpSPIO()->filesystem();

// try the whole thing, but fetching remote URLS, test if really S3 not in case something went wrong with is_virtual, or it's just something messed up.
			if ($fileObj->is_virtual() && $env->plugin_active('s3-offload') )
			{


				if ($type == 'webp')
				{
					$is_double = \wpSPIO()->env()->useDoubleWebpExtension();
				}
				if ($type == 'avif')
				{
					$is_double = \wpSPIO()->env()->useDoubleAvifExtension();
				}

				$url = str_replace('.' . $fileObj->getExtension(), '.' . $type, $fileObj->getURL());
				$double_url = $fileObj->getURL() . '.' . $type;

				$double_filename = $fileObj->getFileName() . '.' . $type;
				$filename =  $fileObj->getFileBase() . '.' . $type;

				if ($is_double)
				{
					$url_exists = $fs->url_exists($double_url);
					if ($url_exists === true)
						return $double_filename;
				}
				else
				{
					$url_exists = $fs->url_exists($url);
					if ($url_exists === true)
						 return $filename;
				}

				// If double extension is enabled, but no file, check the alternative.
					 if ($is_double)
					 {
							$url_exists = $fs->url_exists($url);
							if ($url_exists === true)
								 return $filename;
					 }
					 else
					 {
							$url_exists = $fs->url_exists($double_url);
							if ($url_exists === true)
								 return $double_filename;
					 }
			} // is_virtual

			return null;
	}

  private function legacyConvertType($string_type)
  {
    switch($string_type)
    {
        case 'lossy':
          $type = self::COMPRESSION_LOSSY;
        break;
        case 'lossless':
           $type = self::COMPRESSION_LOSSLESS;
        break;
        case 'glossy':
           $type = self::COMPRESSION_GLOSSY;
        break;
        default:
            $type = -1; //unknown state.
        break;
    }
    return $type;
  }

  /** Old Status can be anything*/
  private function legacyConvertStatus($data, $metadata)
  {

    $waiting = isset($data['WaitingProcessing']) ? true : false;
    $error = isset($data['ErrCode']) ? $data['ErrCode'] : -500;

    if (isset($metadata['ShortPixelImprovement']) &&
        is_numeric($metadata["ShortPixelImprovement"]) &&
        is_numeric($metadata["ShortPixelImprovement"]) > 0)
    {
      $status = self::FILE_STATUS_SUCCESS;
    }
    elseif($waiting)
    {
       $status = self::FILE_STATUS_PENDING;
    }
		elseif($error == 'backup-fail' || $error == 'write-fail' )
		{
			$status = self::FILE_STATUS_ERROR;
		}
    elseif ($error < 0)
    {
      $status = $error;
    }


    return $status;
  }

  public function __debugInfo() {

      return array(
        'id' => $this->id,
        'image_meta' => $this->image_meta,
        'thumbnails' => $this->thumbnails,
        'retinas' => $this->retinas,
        'original_file' => $this->original_file,
        'is_scaled' => $this->is_scaled,
				'imageType' => $this->imageType,
      );


  }

	// Check for UnlistedNotice.  Check if in this image has unlisted without adding them
	private function checkUnlistedForNotice()
	{
			// Prevent running this more than once per run.
			if (true === self::$unlistedNoticeChecked )
			{
					return;
			}

			self::$unlistedNoticeChecked = true;

			$settings = \wpSPIO()->settings();
			$control = AdminNoticesController::getInstance();
			$notice =  $control->getNoticeByKey('MSG_UNLISTED_FOUND');

			// already active
			if ($settings->optimizeUnlisted === true)
				return;

			// already notice.
			if (is_object($notice->getNoticeObj()))
			{
				 return;
			}

			// todo get counter to indicate
			$counter = $settings->unlistedCounter;

			if ($counter < 100)
			{
				 $settings->unlistedCounter++;
				 return;
			}

			// check unlisted.
			$unlisted = $this->addUnlisted(true);


			if (is_array($unlisted) && count($unlisted) > 0)
			{
					// trigger notice.
					$args = array(
						'count' => count($unlisted),
						'filelist' => $unlisted,
						'name' => $this->getFileName(),
						'id' => $this->get('id'),
					);
					$notice->addManual($args);

			}
			$settings->unlistedCounter = 0;
	}

  /** Adds Unlisted Image to the Media Library Item
  * This function is called in IsProcessable
  */
  protected function addUnlisted($check_only = false)
  {
       // Setting must be active.
       /*if (! \wpSPIO()->settings()->optimizeUnlisted )
         return; */
			$searchUnlisted = \wpSPIO()->settings()->optimizeUnlisted;

      // Don't check this more than once per run-time.
      if ( in_array($this->get('id'), self::$unlistedChecked ) && $check_only === false)
      {
          return;
      }

			if (defined('SHORTPIXEL_CUSTOM_THUMB_SUFFIXES'))
			{
					$suffixes = explode(',', SHORTPIXEL_CUSTOM_THUMB_SUFFIXES);
			}
			else
				 $suffixes = array();

      if( defined('SHORTPIXEL_CUSTOM_THUMB_INFIXES') ){
	       $infixes = explode(',', SHORTPIXEL_CUSTOM_THUMB_INFIXES);
			}
			else
			{
				 $infixes = array();
			}

			$searchSuffixes = array_unique(apply_filters('shortpixel/image/unlisted_suffixes', $suffixes));
			$searchInfixes =  array_unique(apply_filters('shortpixel/image/unlisted_infixes', $infixes));

      // addUnlisted is called by IsProcessable, file might not exist.
      // If virtual, we can't read dir, don't do it.
      if (! $this->exists() || $this->is_virtual())
      {
				 self::$unlistedChecked[] = $this->get('id');
         return;
      }

			// if all have nothing to do, do nothing.
			if ($searchUnlisted == false && count($searchSuffixes) == 0 && count($searchInfixes) == 0 && $check_only === false)
			{
				 self::$unlistedChecked[] = $this->get('id');
				 return;
			}

        $currentFiles = array($this->getFileName());
        foreach($this->thumbnails as $thumbObj)
				{
				   $currentFiles[] = $thumbObj->getFileName();
				}

        if ($this->isScaled())
           $currentFiles[] = $this->getOriginalFile()->getFileName();

				if (is_array($this->retinas))
				{
					 foreach($this->retinas as $retinaObj)
					 {
						  $currentFiles[] = $retinaObj->getFileName();
					 }
				}

				$processFiles = array();
				$unlisted = array();

				$processFiles[] = $this;
				if ($this->isScaled())
					$processFiles[] = $this->getOriginalFile();

  			$all_files = scandir($this->getFileDir(),  SCANDIR_SORT_NONE);
				$all_files = array_diff($all_files, $currentFiles);

				foreach($processFiles as $mediaItem)
				{

	        $base = $mediaItem->getFileBase();
	        $ext = $mediaItem->getExtension();
	        $path = (string) $mediaItem->getFileDir();

					if ($searchUnlisted || $check_only === true)
					{
	        	$pattern = '/^' . preg_quote($base, '/') . '-\d+x\d+\.'. $ext .'/';
	        	$thumbs = array();
	        	$result_files = array_values(preg_grep($pattern, $all_files));
					}
					else
					{
						$result_files = array();
					}

					$unlisted = array_merge($unlisted, $result_files);

	        if( count($searchSuffixes) > 0){
	           // $suffixes = explode(',', SHORTPIXEL_CUSTOM_THUMB_SUFFIXES);
	            if (is_array($searchSuffixes))
	                {
	                  foreach ($searchSuffixes as $suffix){

	                      $pattern = '/^' . preg_quote($base, '/') . '-\d+x\d+'. $suffix . '\.'. $ext .'/';
	                      $thumbs = array_values(preg_grep($pattern, $all_files));

	                      if (count($thumbs) > 0)
	                        $unlisted = array_merge($unlisted, $thumbs);
	                  }
	                }
	            }
	            if( count($searchInfixes) > 0 ){
	               // $infixes = explode(',', SHORTPIXEL_CUSTOM_THUMB_INFIXES);
	                if (is_array($searchInfixes))
	                {
	                  foreach ($searchInfixes as $infix){
	                      //$thumbsCandidates = @glob($base . $infix  . "-*." . $ext);
	                      $pattern = '/^' . preg_quote($base, '/') . $infix . '-\d+x\d+' . '\.'. $ext .'/';
	                      $thumbs = array_values(preg_grep($pattern, $all_files));
	                      if (count($thumbs) > 0)
	                        $unlisted = array_merge($unlisted, $thumbs);

	                  }
	                }
	            }

			}  // processFiles loop

      // Quality check on the thumbs. Must exist,  must be same extension.
      $added = false;

			$foundUnlisted = array(); // found and ready. Used for notice / check only

      foreach($unlisted as $unName)
      {
				  if (isset($this->thumbnails[$unName]))
					{
						continue; // don't re-add if not needed.
					}
          $thumbObj = $this->getThumbnailModel($path . $unName, $unName);
          if ($thumbObj->getExtension() == 'webp' || $thumbObj->getExtension() == 'avif') // ignore webp/avif files.
          {
            continue;
          }
          elseif ($thumbObj->is_readable()) // exclude webps
          {
						if (true === $check_only)
						{
								$foundUnlisted[] = $unName;
						}
						else {
	            $thumbObj->setName($unName);
	            $thumbObj->setMeta('originalWidth', $thumbObj->get('width'));
	            $thumbObj->setMeta('originalHeight', $thumbObj->get('height'));
	            $thumbObj->setMeta('file', $thumbObj->getFileName() );
	            $this->thumbnails[$unName] = $thumbObj;
	            $added = true;
						}

          }
          else
          {
            Log::addWarn("Unlisted Image $unName is not readable (permission error?)");
          }
      }

			if (true === $check_only)
			{
				 return $foundUnlisted;
			}
			self::$unlistedChecked[] = $this->get('id');
  }

	// If image is flushed and then reloaded, the unlisted items might go omit, if these are not loaded again.
	public static function onFlushImageCache()
	{
		 self::$unlistedChecked = array();
	}

} // class
