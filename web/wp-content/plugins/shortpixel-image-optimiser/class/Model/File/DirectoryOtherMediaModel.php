<?php
namespace ShortPixel\Model\File;
use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;
use ShortPixel\Notices\NoticeController as Notice;

use \ShortPixel\Model\File\DirectoryModel as DirectoryModel;
use \ShortPixel\Model\Image\ImageModel as ImageModel;

use ShortPixel\Controller\OptimizeController as OptimizeController;
use ShortPixel\Controller\OtherMediaController as OtherMediaController;

// extends DirectoryModel. Handles Shortpixel_meta database table
// Replacing main parts of shortpixel-folder
class DirectoryOtherMediaModel extends DirectoryModel
{

  protected $id = -1; // if -1, this might not exist yet in Dbase. Null is not used, because that messes with isset

  protected $name;
  protected $status = 0;
  protected $fileCount = 0; // inherent onreliable statistic in dbase. When insert / batch insert the folder count could not be updated, only on refreshFolder which is a relative heavy function to use on every file upload. Totals are better gotten from a stat-query, on request.
  protected $updated = 0;
  protected $created = 0;
  protected $path_md5;

  protected $is_nextgen = false;
  protected $in_db = false;
  protected $is_removed = false;

  //protected $stats;

	protected static $stats;

  const DIRECTORY_STATUS_REMOVED = -1;
  const DIRECTORY_STATUS_NORMAL = 0;
  const DIRECTORY_STATUS_NEXTGEN = 1;

  /** Path or Folder Object, from SpMetaDao
  *
  */
  public function __construct($path)
  {

    if (is_object($path)) // Load directly via Database object, this saves a query.
    {
       $folder = $path;
       $path = $folder->path;

       parent::__construct($path);
       $this->loadFolder($folder);
    }
    else
    {
      parent::__construct($path);
      $this->loadFolderbyPath($path);
    }
  }


  public function get($name)
  {
     if (property_exists($this, $name))
      return $this->$name;

     return null;
  }

  public function set($name, $value)
  {
     if (property_exists($this, $name))
     {
        $this->$name = $value;
        return true;
     }

     return null;
  }

	public static function getAllStats()
	{
			if (is_null(self::$stats))
			{
				global $wpdb;
			 	$sql = 'SELECT SUM(CASE WHEN status = 2 THEN 1 ELSE 0 END) optimized, SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) waiting, count(*) total, folder_id FROM  ' . $wpdb->prefix . 'shortpixel_meta GROUP BY folder_id';

				$result = $wpdb->get_results($sql, ARRAY_A);

				$stats = array();
				foreach($result as $data)
				{
					 $folder_id = $data['folder_id'];
					 unset($data['folder_id']);
					 $stats[$folder_id] = $data;
				}

				self::$stats = $stats;
			}

		 return self::$stats;
	}

  public function getStats()
  {
			$stats = self::getAllStats();  // Querying all stats is more efficient than one-by-one

			if (isset($stats[$this->id]))
			{
				 return $stats[$this->id];
			}
			else {
				global $wpdb;
	      $sql = "SELECT SUM(CASE WHEN status = 2 THEN 1 ELSE 0 END) optimized, "
	          . "SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) waiting, count(*) total "
	          . "FROM  " . $wpdb->prefix . "shortpixel_meta "
	          . "WHERE folder_id = %d";
	      $sql = $wpdb->prepare($sql, $this->id);
	      $res = $wpdb->get_row($sql, ARRAY_A);
				return $res;
			}

  }

  public function save()
  {
    // Simple Update
      global $wpdb;
        $data = array(
        //    'id' => $this->id,
            'status' => $this->status,
            'file_count' => $this->fileCount,
            'ts_updated' => $this->timestampToDB($this->updated),
            'name' => $this->name,
            'path' => $this->getPath(),
        );
        $format = array('%d', '%d', '%s', '%s', '%s');
        $table = $wpdb->prefix . 'shortpixel_folders';

        $is_new = false;
				$result = false;

        if ($this->in_db) // Update
        {
            $result = $wpdb->update($table, $data, array('id' => $this->id), $format);
        }
        else // Add new
        {
					 // Fallback.  In case some other process adds it. This happens with Nextgen.
						if (true === $this->loadFolderByPath($this->getPath()))
						{
								$result = $wpdb->update($table, $data, array('id' => $this->id), $format);
						}
						else
						{
							$this->id = $wpdb->insert($table, $data);
							if ($this->id !== false)
							{
								$is_new = true;
								$result = $this->id;
							}
						}
        }

				// reloading because action can create a new DB-entry, which will not be reflected (in id )
        if ($is_new)
				{
        	$this->loadFolderByPath($this->getPath());
				}

				return $result;
  }

  public function delete()
  {
      $id = $this->id;
      if (! $this->in_db)
      {
         Log::addError('Trying to remove Folder without being in the database (in_db false) ' . $id, $this->getPath());
      }

      global $wpdb;
			$otherMedia = OtherMediaController::getInstance();

			// Remove all files from this folder that are not optimized.
			$sql = "DELETE FROM " . $otherMedia->getMetaTable() . ' WHERE status <> 2 and folder_id = %d';
			$sql = $wpdb->prepare($sql, $this->id);
			$wpdb->query($sql);

			// Check if there are any images left.
			$sql = 'SELECT count(id) FROM ' . $otherMedia->getMetaTable() . ' WHERE folder_id = %d';
			$sql = $wpdb->prepare($sql, $this->id);
			$numImages = $wpdb->get_var($sql);

			if ($numImages > 0)
			{
					$sql = 'UPDATE ' . $otherMedia->getFolderTable() . ' SET status = -1 where id = %d';
					$sql = $wpdb->prepare($sql, $this->id);
					$result = $wpdb->query($sql);
			}
			else
			{
		      $sql = 'DELETE FROM ' . $otherMedia->getFolderTable() . ' where id = %d';
		      $sql = $wpdb->prepare($sql, $this->id);
		      $result = $wpdb->query($sql);
			}

			return $result;
  }

  public function isRemoved()
  {
      if ($this->is_removed)
        return true;
      else
        return false;
  }

  /** Updates the updated variable on folder to indicating when the last file change was made
  * @return boolean  True if file were changed since last update, false if not
  */
  public function updateFileContentChange()
  {
      if (! $this->exists() )
        return false;

      $old_time = $this->updated;

      $time = $this->recurseLastChangeFile();
      $this->updated = $time;
      $this->save();

      if ($old_time !== $time)
        return true;
      else
        return false;
  }



  /** Crawls the folder and check for files that are newer than param time, or folder updated
  * Note - last update timestamp is not updated here, needs to be done separately.
  */
  public function refreshFolder($force = false)
  {
      if ($force === false)
      {
        $time = $this->updated;
      }
      else
      {
        $time = 0; //force refresh of the whole.
      }


			if (! $this->checkDirectory(true))
			{
				Log::addWarn('Refreshing directory, something wrong in checkDirectory ' . $this->getPath());
				return false;
			}

      if ($this->id <= 0)
      {
        Log::addWarn('FolderObj from database is not there, while folder seems ok ' . $this->getPath() );
        return false;
      }
      elseif (! $this->exists())
      {
        Notice::addError( sprintf(__('Folder %s does not exist! ', 'shortpixel-image-optimiser'), $this->getPath()) );
        return false;
      }
      elseif (! $this->is_writable())
      {
        Notice::addWarning( sprintf(__('Folder %s is not writeable. Please check permissions and try again.','shortpixel-image-optimiser'),$this->getPath()) );
        return false;
      }

      $fs = \wpSPIO()->filesystem();
      $filter = ($time > 0)  ? array('date_newer' => $time) : array();
      $filter['exclude_files'] = array('.webp', '.avif');
			$filter['include_files'] = ImageModel::PROCESSABLE_EXTENSIONS;

      $files = $fs->getFilesRecursive($this, $filter);

      \wpSPIO()->settings()->hasCustomFolders = time(); // note, check this against bulk when removing. Custom Media Bulk depends on having a setting.
    	$result = $this->addImages($files);

    	// Reset stat.
			unset(self::$stats[$this->id]);
      $stats = $this->getStats();
      $this->fileCount = $stats['total'];

      $this->save();

  }

	/**  Check if a directory is allowed. Directory can't be media library, outside of root, or already existing in the database
	* @param $silent If not allowed, don't generate notices.
	*
	*/
	public function checkDirectory($silent = false)
	{
			$fs = \wpSPIO()->filesystem();
       $rootDir = $fs->getWPFileBase();
       $backupDir = $fs->getDirectory(SHORTPIXEL_BACKUP_FOLDER);
			 $otherMediaController = OtherMediaController::getInstance();

       if (! $this->exists())
       {
				 if ($silent === false)
				 {
          Notice::addError(__('Could not be added, directory not found: ' . $path ,'shortpixel-image-optimiser'));
				 }
          return false;
       }
       elseif (! $this->isSubFolderOf($rootDir) && $this->getPath() != $rootDir->getPath() )
       {
				 if ($silent === false)
			 	 {
          Notice::addError( sprintf(__('The %s folder cannot be processed as it\'s not inside the root path of your website (%s).','shortpixel-image-optimiser'),$this->getPath(), $rootDir->getPath()));
				}
          return false;
       }
       elseif($this->isSubFolderOf($backupDir) || $this->getPath() == $backupDir->getPath() )
       {
				 if ($silent === false)
				 {
          Notice::addError( __('This folder contains the ShortPixel Backups. Please select a different folder.','shortpixel-image-optimiser'));
				}
          return false;
       }
       elseif( $otherMediaController->checkIfMediaLibrary($this) )
       {
				 if ($silent === false)
				 {
          Notice::addError(__('This folder contains Media Library images. To optimize Media Library images please go to <a href="upload.php?mode=list">Media Library list view</a> or to <a href="upload.php?page=wp-short-pixel-bulk">ShortPixel Bulk page</a>.','shortpixel-image-optimiser'));
				}
          return false;
       }
       elseif (! $this->is_writable())
       {
				 if ($silent === false)
				 {
         	Notice::addError( sprintf(__('Folder %s is not writeable. Please check permissions and try again.','shortpixel-image-optimiser'),$this->getPath()) );
			 	 }
         return false;

       }
			 else
			 {
				 $folders = $otherMediaController->getAllFolders();

				 foreach($folders as $folder)
				 {
					   if ($this->isSubFolderOf($folder))
						 {
							 if ($silent === false)
							 {
							  Notice::addError(sprintf(__('This folder is a subfolder of an already existing Other Media folder. Folder %s can not be added', 'shortpixel-image-optimiser'), $this->getPath() ));
							 }
								return false;
						 }
				 }
			 }

			 return true;
	}

/*
  public function getFiles($args = array())
	{
			// Check if this directory if not forbidden.
			if (! $this->checkDirectory(true))
			{
				return array();
			}

			return parent::getFiles($args);
	}
*/
/*  public function getSubDirectories()
	  {
				$dirs = parent::getSubDirectories();
				$checked = array();
				foreach($dirs as $dir)
				{
					 if ($dir->checkDirectory(false))
					 {
					 	$checked[] = $dir;
					 }
					 else
					 {
					 	Log::addDebug('Illegal directory' . $dir->getPath());
					 }
				}

				return $checked;
		}
*/


    private function recurseLastChangeFile($mtime = 0)
    {
      $ignore = array('.','..');

			// Directories without read rights should not be checked at all.
			if (! $this->is_readable())
				return $mtime;

      $path = $this->getPath();

      $files = scandir($path);

			// no files, nothing to update.
			if (! is_array($files))
			{
					return $mtime;
			}

			$files = array_diff($files, $ignore);

      $mtime = max($mtime, filemtime($path));

      foreach($files as $file) {


          $filepath = $path . $file;

          if (is_dir($filepath)) {
              $mtime = max($mtime, filemtime($filepath));
              $subDirObj = new DirectoryOtherMediaModel($filepath);
              $subdirtime = $subDirObj->recurseLastChangeFile($mtime);
              if ($subdirtime > $mtime)
                $mtime = $subdirtime;
          }
      }
      return $mtime;
    }

    private function timestampToDB($timestamp)
    {
        if ($timestamp == 0) // when adding / or empty.
          $timestamp = time();
        return date("Y-m-d H:i:s", $timestamp);
    }

    private function DBtoTimestamp($date)
    {
        return strtotime($date);
    }

  /** This function is called by OtherMediaController / RefreshFolders. Other scripts should not call it
  * @public
  * @param Array of CustomMediaImageModel stubs.
  */
  public function addImages($files) {

      global $wpdb;
			if ( apply_filters('shortpixel/othermedia/addfiles', true, $files, $this) === false)
			{
				 return false;
			}


      $values = array();

      $optimizeControl = new OptimizeController();
			$otherMediaControl = OtherMediaController::getInstance();
			$activeFolders = $otherMediaControl->getActiveDirectoryIDS();

      $fs = \wpSPIO()->filesystem();

		//	Log::addDebug('activeFolders', $activeFolders);

      foreach($files as $fileObj)
      {
					// Note that load is set to false here.
          $imageObj = $fs->getCustomStub($fileObj->getFullPath(), false);

					// image already exists
          if ($imageObj->get('in_db') == true)
					{
						// Load meta to make it check the folder_id.
						$imageObj->loadMeta();

						// Check if folder id is something else. This might indicate removed or inactive folders.
						// If in inactive folder, move to current active.
						if ($imageObj->get('folder_id') !== $this->id)
						{
							 if (! in_array($imageObj->get('folder_id'), $activeFolders) )
							 {
								   $imageObj->setFolderId($this->id);
									 $imageObj->saveMeta();
							 }
						}

            continue;
					}
          elseif ($imageObj->isProcessable(true)) // Check strict on Processable here.
          {
  	         $imageObj->setFolderId($this->id);
             $imageObj->saveMeta();

             if (\wpSPIO()->env()->is_autoprocess)
             {
                $optimizeControl->addItemToQueue($imageObj);
             }
          }


      }

  }

		private function loadFolderById()
		{

		}

    private function loadFolderByPath($path)
    {
        //$folders = self::getFolders(array('path' => $path));
         global $wpdb;

         $sql = 'SELECT * FROM ' . $wpdb->prefix . 'shortpixel_folders where path = %s ';
         $sql = $wpdb->prepare($sql, $path);

        $folder = $wpdb->get_row($sql);
        if (! is_object($folder))
          return false;
        else
        {
          $this->loadFolder($folder);
          $this->in_db = true; // exists in database
          return true;
        }
    }

    /** Loads from database into model, the extra data of this model. */
    private function loadFolder($folder)
    {
      //  $class = get_class($folder);
				// Setters before action
        $this->id = $folder->id;

        if ($this->id > 0)
         $this->in_db = true;

        $this->updated = isset($folder->ts_updated) ? $this->DBtoTimestamp($folder->ts_updated) : time();
        $this->created = isset($folder->ts_created) ? $this->DBtoTimestamp($folder->ts_created) : time();
        $this->fileCount = isset($folder->file_count) ? $folder->file_count : 0; // deprecated, do not rely on.

        $this->status = $folder->status;

        if (strlen($folder->name) == 0)
          $this->name = basename($folder->path);
        else
          $this->name = $folder->name;

        do_action('shortpixel/othermedia/folder/load', $this->id, $this);

				// Making conclusions after action.
        if ($this->status == -1)
          $this->is_removed = true;

        if ($this->status == self::DIRECTORY_STATUS_NEXTGEN)
        {
          $this->is_nextgen = true;
        }

    }

}
