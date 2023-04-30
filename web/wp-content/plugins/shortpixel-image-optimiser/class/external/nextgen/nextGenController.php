<?php
namespace ShortPixel;
use ShortPixel\Notices\NoticeController as Notice;
use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;

use ShortPixel\Model\File\DirectoryOtherMediaModel as DirectoryOtherMediaModel;
use ShortPixel\Controller\OtherMediaController as OtherMediaController;
use ShortPixel\Controller\AdminNoticesController as AdminNoticesController;

use ShortPixel\NextGenViewController as NextGenViewController;

// @integration NextGen Gallery
class NextGenController
{
  protected static $instance;
//  protected $view;
	private $enableOverride = false; // when activating NG will not report active yet, but try to refresh folders. Do so.

// ngg_created_new_gallery
  public function __construct()
  {
    add_filter('shortpixel/init/optimize_on_screens', array($this, 'add_screen_loads'));

    add_action('plugins_loaded', array($this, 'hooks'));
    add_action('deactivate_nextgen-gallery/nggallery.php', array($this, 'resetNotification'));
  }

  public function hooks()
  {
		$controller = new NextGenViewController();

    if ($this->optimizeNextGen()) // if optimization is on, hook.
    {
      add_action('ngg_update_addgallery_page', array( $this, 'addNextGenGalleriesToCustom'));
      add_action('ngg_added_new_image', array($this,'handleImageUpload'));
    }

    if ($this->has_nextgen())
    {
			add_action('ngg_delete_image', array($this, 'OnDeleteImage'),10, 2); // this works only on single images!

      add_action('shortpixel/othermedia/folder/load', array($this, 'loadFolder'), 10, 2);
			add_action('shortpixel/othermedia/addfiles', array($this, 'checkAddFiles'), 10, 3);

      add_filter( 'ngg_manage_images_columns', array( $controller, 'nggColumns' ) );
      add_filter( 'ngg_manage_images_number_of_columns', array( $controller, 'nggCountColumns' ) );
      add_filter( 'ngg_manage_images_column_7_header', array( $controller, 'nggColumnHeader' ) );
      add_filter( 'ngg_manage_images_column_7_content', array( $this, 'loadNextGenItem' ), 10,2 );
			add_filter('ngg_manage_gallery_fields', array($this, 'refreshFolderOnLoad'), 10, 2);

    }

  }

  // Use GetInstance, don't use the construct.
  public static function getInstance()
  {
    if (is_null(self::$instance))
      self::$instance = new NextGenController();

     return self::$instance;
  }

  public function has_nextgen()
  {
     if (defined('NGG_PLUGIN'))
      return true;
     else
       return false;
  }

  public function optimizeNextGen()
  {
		 if (true === $this->enableOverride || \wpSPIO()->settings()->includeNextGen == 1)
		 {
		 	 return true;
		 }

     return false;
  }

  public function isNextGenScreen()
  {
      $screens = $this->add_screen_loads(array());
			if (! is_admin())
			{
				 return false;
			}
			if (! function_exists('get_current_screen'))
			{
				 return false;
			}
			$screen_id = \wpSPIO()->env()->screen_id;

      if (in_array($screen_id, $screens))
        return true;
      else
        return false;

  }

  /** called from settingController when enabling the nextGen settings */
  public function enableNextGen($silent)
  {
		 $this->enableOverride = true;
     $this->addNextGenGalleriesToCustom($silent);
  }


  public function add_screen_loads($use_screens)
  {

    $use_screens[] = 'toplevel_page_nextgen-gallery'; // toplevel
    $use_screens[] = 'nextgen-gallery_page_ngg_addgallery';  // add gallery
    $use_screens[] = 'nextgen-gallery_page_nggallery-manage-album'; // manage album
    $use_screens[] = 'nextgen-gallery_page_nggallery-manage-gallery'; // manage toplevel gallery
    $use_screens[] = 'nggallery-manage-images'; // images in gallery overview

    return $use_screens;
  }

  public function loadNextGenItem($unknown, $picture)
  {
       $viewController = new NextGenViewController();
       $viewController->loadItem($picture);
  }

	public function refreshFolderOnLoad($array, $gallery)
	{
		 $galleries = $this->getGalleries($gallery->gid);
		 if (isset($galleries[0]))
		 {
			  $otherMedia = OtherMediaController::getInstance();
			  $galleryFolder = $galleries[0];
				$folder = $otherMedia->getFolderByPath($galleryFolder->getPath());
				$folder->refreshFolder(true);
		 }
		 return $array;
	}
  /** Enables nextGen, add galleries to custom folders
  * @param boolean $silent Throw a notice or not. This seems to be based if nextgen was already activated previously or not.
  */
  /*
  public function nextGenEnabled($silent)
  {
    $this->addNextGenGalleriesToCustom($silent);
  }  */

  /** Tries to find a nextgen gallery for a shortpixel folder.
  * Purpose is to test if this folder is a nextgen gallery
  * Problem is that NG stores folders in a short format, not from root while SPIO stores whole path
  * Assumption: The last two directory names should lead to an unique gallery and if so, it's nextgen
  * @param $id int Folder ID
  * @param $directory DirectoryOtherMediaModel  Directory Object
  */
  public function loadFolder($id, $directory)
  {
      $path = $directory->getPath();
			// No reason to check this?
			if ($directory->get('status') == DirectoryOtherMediaModel::DIRECTORY_STATUS_NEXTGEN)
			{	return;  }

      $path_split = array_filter(explode('/', $path));

      $searchPath = trailingslashit(implode('/', array_slice($path_split, -2, 2)));

      global $wpdb;
      $sql = "SELECT gid FROM {$wpdb->prefix}ngg_gallery WHERE path LIKE %s";
      $sql = $wpdb->prepare($sql, '%' . $searchPath . '');
      $gid = $wpdb->get_var($sql);


      if (! is_null($gid) && is_numeric($gid))
			{
        $res = $directory->set('status', DirectoryOtherMediaModel::DIRECTORY_STATUS_NEXTGEN);
				$directory->save();
				//echo $gid;
			}
  }

	/** Hook. If there is a refreshFolder action on a nextGen Directory, but the optimize Nextgen setting is off, it should not add those files to the custom Media */
	public function checkAddFiles($bool, $files, $dirObj)
	{
			// Nothing nextgen.
			if ($dirObj->get('is_nextgen') === false)
		  {
				 return $bool;
			}

			// If it's nextgen, but the setting is not on, reject those files.
			if ($this->optimizeNextGen() === false)
			{
				 	return false;
			}

			return $bool;
	}

  /* @return DirectoryModel */
  public function getGalleries($id = null)
  {
    global $wpdb;
    $fs = \wpSPIO()->filesystem();
    $homepath = $fs->getWPFileBase();

		$sql = "SELECT path FROM {$wpdb->prefix}ngg_gallery";
		if (! is_null($id))
		{
			 $sql .= ' WHERE gid = %d';
			 $sql = $wpdb->prepare($sql, $id);
		}
    $result = $wpdb->get_results($sql);

    $galleries = array();

    foreach($result as $row)
    {
      $directory = $fs->getDirectory($homepath->getPath() . $row->path);
      if ($directory->exists())
        $galleries[] = $directory;
    }

    return $galleries;
  }

  /** Adds nextGen galleries to custom table
  * Note - this function does *Not* check if nextgen is enabled, not if checks custom Tables. Use nextgenEnabled for this.
  * Enabled checks are not an external class issue, so must be done before calling.
  */
   public function addNextGenGalleriesToCustom($silent = true) {
      $fs = \wpSPIO()->filesystem();
      $homepath = $fs->getWPFileBase();

      //add the NextGen galleries to custom folders
      $ngGalleries = $this->getGalleries(); // DirectoryModel return.

      $otherMedia = OtherMediaController::getInstance();

      foreach($ngGalleries as $gallery)
			{
          $folder = $otherMedia->getFolderByPath($gallery->getPath());

          if ($folder->get('in_db') === true)
          {
						if ($folder->get('status') !== 1)
						{
							 $folder->set('status', DirectoryOtherMediaModel::DIRECTORY_STATUS_NEXTGEN);
							 $folder->save();
						}
            continue;
          }
					else
					{
						// Try to silently fail this if directory is not allowed.
						if (false === $folder->checkDirectory(true))
						{
							continue;
						}
          	$directory = $otherMedia->addDirectory($gallery->getPath());
						if (! $directory)
						{
							Log::addWarn('Could not add this directory' . $gallery->getPath() );
						}
						else
						{
							 $directory->set('status', DirectoryOtherMediaModel::DIRECTORY_STATUS_NEXTGEN);
							 $directory->save();
						}
					}


      }

      if (count($ngGalleries) > 0)
      {
        // put timestamp to this setting.
        $settings = \wpSPIO()->settings();
        $settings->hasCustomFolders = time();
      }


  }

  public function handleImageUpload($image)
  {
    $otherMedia = OtherMediaController::getInstance();
    //$fs = \wpSPIO()->filesystem();

    if ($this->optimizeNextGen() === true) {
          $imageFsPath = $this->getImageAbspath($image);

          $otherMedia->addImage($imageFsPath, array('is_nextgen' => true));
      }
  }

  public function resetNotification()
  {
    Notice::removeNoticeByID('MSG_INTEGRATION_NGGALLERY');
  }

  public function onDeleteImage($nggId, $size)
  {

	  	$image = $this->getNGImageByID($nggId);

			$paths = array();

			if ($size === false)
			{
				$imageSizes = $this->getImageSizes($image);
				foreach($imageSizes as $size)
				{
					$paths[] = $this->getImageAbspath($image, $size);

				}
			}
			else {
				$paths = array_merge($paths, $this->getImageAbspath($image, $size));
			}

			foreach($paths as $path)
			{
				$otherMediaController = OtherMediaController::getInstance();
				$mediaItem = $otherMediaController->getCustomImageByPath($path);
				$mediaItem->onDelete();
			}
  }



  public function updateImageSize($nggId, $path) {

      $image = $this->getNGImageByID($nggId);

      $dimensions = getimagesize($this->getImageAbspath($image));
      $size_meta = array('width' => $dimensions[0], 'height' => $dimensions[1]);
      $image->meta_data = array_merge($image->meta_data, $size_meta);
      $image->meta_data['full'] = $size_meta;
      $this->saveToNextGen($image);
  }

  protected function getNGImageByID($nggId)
  {
    $mapper = \C_Image_Mapper::get_instance();
    $image = $mapper->find($nggId);
    return $image;
  }

  /* @param NextGen Image */
  protected function saveToNextGen($image)
  {
    $mapper = \C_Image_Mapper::get_instance();
    $mapper->save($image);
  }

  protected function getImageAbspath($image, $size = 'full') {
      $storage = \C_Gallery_Storage::get_instance();
      return $storage->get_image_abspath($image, $size);
  }

  protected function getImageSizes($image)
	{
		 $storage = \C_Gallery_Storage::get_instance();

		 return $storage->get_image_sizes($image);
	}

} // class.

$ng = NextGenController::getInstance();
