<?php
namespace ShortPixel\Model\File;
use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;

use ShortPixel\Helper\UtilHelper as UtilHelper;


/* FileModel class.
*
*
* - Represents a -single- file.
* - Can handle any type
* - Usually controllers would use a collection of files
* - Meant for all low-level file operations and checks.
* - Every file can have a backup counterpart.
*
*/
class FileModel extends \ShortPixel\Model
{

  // File info
  protected $fullpath = null;
	protected $rawfullpath = null;
  protected $filename = null; // filename + extension
  protected $filebase = null; // filename without extension
  protected $directory = null;
  protected $extension = null;
  protected $mime = null;
	protected $filesize = null;

  // File Status
  protected $exists = null;
  protected $is_writable = null;
	protected $is_directory_writable = null;
  protected $is_readable = null;
  protected $is_file = null;
  protected $is_virtual = false;

  protected $status;

  protected $backupDirectory;

  const FILE_OK = 1;
  const FILE_UNKNOWN_ERROR = 2;

	public static $TRUSTED_MODE = false;


  /** Creates a file model object. FileModel files don't need to exist on FileSystem */
  public function __construct($path)
  {
		$this->rawfullpath = $path;

		if (is_null($path))
		{
			 Log::addWarn('FileModel: Loading null path! ');
			 return false;
		}

		if (strlen($path) > 0)
			$path = trim($path);

		$this->fullpath = $path;

		$this->checkTrustedMode();

    $fs = \wpSPIO()->filesystem();

    if ($fs->pathIsUrl($path)) // Asap check for URL's to prevent remote wrappers from running.
    {
      $this->UrlToPath($path);
    }
  }

  /* Get a string representation of file, the fullpath
  *  Note - this might be risky, without processedpath, in cases.
  * @return String  Full path  processed or unprocessed.
  */
  public function __toString()
  {
    return (string) $this->fullpath;
  }

  protected function setFileInfo()
  {
      $processed_path = $this->processPath($this->fullpath);
      if ($processed_path !== false)
        $this->fullpath = $processed_path; // set processed path if that went alright


      $info = $this->mb_pathinfo($this->fullpath);
      // Todo, maybe replace this with splFileINfo.
      if ($this->is_file()) // only set fileinfo when it's an actual file.
      {
        $this->filename = isset($info['basename']) ? $info['basename'] : null; // filename + extension
        $this->filebase = isset($info['filename']) ? $info['filename'] : null; // only filename
        $this->extension = isset($info['extension']) ? strtolower($info['extension']) : null; // only (last) extension
      }

  }

  /** Call when file status changed, so writable / readable / exists are not reliable anymore */
  public function resetStatus()
  {
      $this->is_writable = null;
			$this->is_directory_writable = null;
      $this->is_readable = null;
      $this->is_file = null;
      $this->exists = null;
      $this->is_virtual = null;
			$this->filesize = null;
  }

	/**
	* @param $forceCheck  Forces a filesystem check instead of using cached.  Use very sparingly. Implemented for retina on trusted mode.
	*/
  public function exists($forceCheck = false)
  {
    if (true === $forceCheck || is_null($this->exists))
    {
      $this->exists = (@file_exists($this->fullpath) && is_file($this->fullpath));
    }

    $this->exists = apply_filters('shortpixel_image_exists', $this->exists, $this->fullpath, $this); //legacy
    $this->exists = apply_filters('shortpixel/file/exists',  $this->exists, $this->fullpath, $this);
    return $this->exists;
  }

  public function is_writable()
  {
    if ($this->is_virtual())
    {
       $this->is_writable = false;  // can't write to remote files
    }
    elseif (is_null($this->is_writable))
    {
      if ($this->exists())
      {
        $this->is_writable = @is_writable($this->fullpath);
      }
      else // quite expensive check to see if file is writable.
      {
          $res = $this->create();
          $this->delete();
          $this->is_writable = $res;
      }

    }

    return $this->is_writable;
  }

	public function is_directory_writable()
	{
		if ($this->is_virtual())
		{
			 $this->is_directory_writable = false;  // can't write to remote files
		}
		elseif (is_null($this->is_directory_writable))
		{
			$directory = $this->getFileDir();
			if (is_object($directory) && $directory->exists())
			{
				$this->is_directory_writable = $directory->is_writable();
			}
			else {
				$this->is_directory_writable = false;
			}

		}

		return $this->is_directory_writable;
	}

  public function is_readable()
  {
    if (is_null($this->is_readable))
      $this->is_readable = @is_readable($this->fullpath);

    return $this->is_readable;
  }

  // A file is virtual when the file is remote  with URL and no local alternative is present.
  public function is_virtual()
  {
     if ( is_null($this->is_virtual))
      $this->is_virtual = false; // return bool
     return $this->is_virtual;
  }

  /* Function checks if path is actually a file. This can be used to check possible confusion if a directory path is given to filemodel */
  public function is_file()
  {
    if ($this->is_virtual()) // don't look further when virtual
    {
        $this->is_file = true;
        return $this->is_file;
    }
    elseif (is_null($this->is_file))
    {
      if ($this->exists())
      {
        if (basename($this->fullpath) == '..' || basename($this->fullpath) == '.')
          $this->is_file = false;
        else
          $this->is_file = is_file($this->fullpath);
      }
      else // file can not exist, but still have a valid filepath format. In that case, if file should return true.
      {

         /*  if file does not exist on disk, anything can become a file ( with/ without extension, etc). Meaning everything non-existing is a potential file ( or directory ) until created. */

         if (basename($this->fullpath) == '..' || basename($this->fullpath) == '.') // don't see this as file.
         {
            $this->is_file = false;
         }
         else if (! file_exists($this->fullpath) && ! is_dir($this->fullpath))
         {
              $this->is_file = true;
         }
         else //if (! is_file($this->fullpath)) // can be  a non-existing directory. /
         {
              $this->is_file = false;
         }

      }
    }
    return $this->is_file;
  }

  public function getModified()
  {
    return filemtime($this->fullpath);
  }

  public function hasBackup()
  {
      $directory = $this->getBackupDirectory();
      if (! $directory)
        return false;

      $backupFile =  $directory . $this->getBackupFileName();

      if (file_exists($backupFile) && ! is_dir($backupFile) )
        return true;
      else {
        return false;
      }
  }

  /** Tries to retrieve an *existing* BackupFile. Returns false if not present.
  * This file might not be writable.
  * To get writable directory reference to backup, use FileSystemController
  */
  public function getBackupFile()
  {
     if ($this->hasBackup())
        return new FileModel($this->getBackupDirectory() . $this->getBackupFileName() );
     else
       return false;
  }

	/** Function returns the filename for the backup.  This is an own function so it's possible to manipulate backup file name if needed, i.e. conversion or enumeration */
	public function getBackupFileName()
	{
		 return $this->getFileName();
	}

  /** Returns the Directory Model this file resides in
  *
  * @return DirectoryModel Directorymodel Object
  */
  public function getFileDir()
 {
      $fullpath = $this->getFullPath(); // triggers a file lookup if needed.
      // create this only when needed.
      if (is_null($this->directory) && strlen($fullpath) > 0)
      {
        // Feed to full path to DirectoryModel since it checks if input is file, or dir. Using dirname here would cause errors when fullpath is already just a dirpath ( faulty input )
          $this->directory = new DirectoryModel($fullpath);
      }

      return $this->directory;
  }

  public function getFileSize()
  {
		if (! is_null($this->filesize))
		{
			 return $this->filesize;
		}
    elseif ($this->exists() && false === $this->is_virtual() )
		{
       $this->filesize = filesize($this->fullpath);
			 return $this->filesize;
		}
    elseif (true === $this->is_virtual())
		{
			 return -1;
		}
		else
      return 0;
  }

  // Creates an empty file
  public function create()
  {
     if (! $this->exists() )
     {
      $fileDir = $this->getFileDir();

      if (! is_null($fileDir) && $fileDir->exists())
      {
        $res = @touch($this->fullpath);
        $this->exists = $res;
        return $res;
      }
    }
     else
      Log::addWarn('Could not create/write file: ' . $this->fullpath);

    return false;
  }

  public function append($message)
  {
       if (! $this->exists() )
          $this->create();

      if (! $this->is_writable() )
			{
          Log::addWarn('File append failed on ' . $this->getFullPath() . ' - not writable');
					return false;
			}
      $handle = fopen($this->getFullPath(), 'a');
      fwrite($handle, $message);
      fclose($handle);

			return true;
  }


  /** Copy a file to somewhere
  *
  * @param $destination String Full Path to new file.
  */
  public function copy(FileModel $destination)
  {
      $sourcePath = $this->getFullPath();
      $destinationPath = $destination->getFullPath();

      Log::addDebug("Copy from $sourcePath to $destinationPath ");

      if (! strlen($sourcePath) > 0 || ! strlen($destinationPath) > 0)
      {
        Log::addWarn('Attempted Copy on Empty Path', array($sourcePath, $destinationPath));
        return false;
      }

      if (! $this->exists())
      {
        Log::addWarn('Tried to copy non-existing file - '  . $sourcePath);
        return false;
      }

      $is_new = ($destination->exists()) ? false : true;
      $status = @copy($sourcePath, $destinationPath);

      if (! $status)
			{
        Log::addWarn('Could not copy file ' . $sourcePath . ' to' . $destinationPath);
			}
      else
			{
        $destination->resetStatus();
        $destination->setFileInfo(); // refresh info.
      }
      //
      do_action('shortpixel/filesystem/addfile', array($destinationPath, $destination, $this, $is_new));
      return $status;
  }

  /** Move a file to somewhere
  * This uses copy and delete functions and will fail if any of those fail.
  * @param $destination String Full Path to new file.
  */
  public function move(FileModel $destination)
  {
     $result = false;
     if ($this->copy($destination))
     {
       $result = $this->delete();
			 if ($result == false)
			 {
				 Log::addError('Move can\'t remove file ' . $this->getFullPath());
			 }

       $this->resetStatus();
       $destination->resetStatus();
     }
     return $result;
  }

  /** Deletes current file
  * This uses the WP function since it has a filter that might be useful
  */
  public function delete()
  {
     if ($this->exists())
		 {
      	\wp_delete_file($this->fullpath);  // delete file hook via wp_delete_file
		 }
		 else
		 {
			  Log::addWarn('Trying to remove non-existing file: ' . $this->getFullPath());
		 }

      if (! file_exists($this->fullpath))
      {
        $this->resetStatus();
        return true;
      }
      else {
				$writable = ($this->is_writable()) ? 'true' : 'false';
				Log::addWarn('File seems not removed - ' . $this->getFullPath() . ' (writable:' . $writable . ')');
        return false;
      }

  }

	public function getContents()
	{
			return file_get_contents($this->getFullPath());
	}

  public function getFullPath()
  {
		// filename here since fullpath is set unchecked in constructor, but might be a different take
    if (is_null($this->filename))
		{
      $this->setFileInfo();
		}

    return $this->fullpath;
  }

	// Testing this. Principle is that when the plugin is absolutely sure this is a file, not something remote, not something non-existing, get the fullpath without any check.
	// This function should *only* be used when processing mega amounts of files while not doing optimization or any processing.
	// So far, testing use for file Filter */
	public function getRawFullPath()
	{
			return $this->rawfullpath;
	}

  public function getFileName()
  {
    if (is_null($this->filename))
      $this->setFileInfo();

    return $this->filename;
  }

  public function getFileBase()
  {
    if (is_null($this->filebase))
      $this->setFileInfo();

    return $this->filebase;
  }


  public function getExtension()
  {
    if (is_null($this->extension))
      $this->setFileInfo();

    return $this->extension;
  }

  public function getMime()
  {
    if (is_null($this->mime))
        $this->setFileInfo();

    if ($this->exists() && ! $this->is_virtual() )
    {
        $this->mime = wp_get_image_mime($this->fullpath);
				if (false === $this->mime)
				{
					 $image_data = wp_check_filetype_and_ext($this->getFullPath(), $this->getFileName());
					 if (is_array($image_data) && isset($image_data['type']) && strlen($image_data['type']) > 0)
					 {
						 $this->mime = $image_data['type'];
					 }

				}
    }
    else
       $this->mime = false;

    return $this->mime;
  }
  /* Util function to get location of backup Directory.
	* @param Create - If true will try to create directory if it doesn't exist.
  * @return Boolean | DirectModel  Returns false if directory is not properly set, otherwhise with a new directoryModel
  */
  protected function getBackupDirectory($create = false)
  {

    if (is_null($this->getFileDir()))
    {
        Log::addWarn('Could not establish FileDir ' . $this->fullpath);
        return false;
    }
    $fs = \wpSPIO()->filesystem();

    if (is_null($this->backupDirectory))
    {
      $directory = $fs->getBackupDirectory($this, $create);

      if ($directory === false || ! $directory->exists()) // check if exists. FileModel should not attempt to create.
      {
        //Log::addWarn('Backup Directory not existing ' . $directory-);
        return false;
      }
      elseif ($directory !== false)
      {
        $this->backupDirectory = $directory;
      }
      else
      {
        return false;
      }
    }

    return $this->backupDirectory;
  }

  /* Internal function to check if path is a real path
  *  - Test for URL's based on http / https
  *  - Test if given path is absolute, from the filesystem root.
  * @param $path String The file path
  * @param String The Fixed filepath.
  */
  protected function processPath($path)
  {
    $original_path = $path;
    $fs = \wpSPIO()->filesystem();

    if ($fs->pathIsUrl($path))
    {
      $path = $this->UrlToPath($path);

    }

    if ($path === false) // don't process further
      return false;

  //  $path = wp_normalize_path($path);

		$path = UtilHelper::spNormalizePath($path);
		$abspath = $fs->getWPAbsPath();

		// Prevent file operation below if trusted.
		if (true === self::$TRUSTED_MODE)
		{
			 return $path;
		}

    if ( is_file($path) && ! is_dir($path) ) // if path and file exist, all should be okish.
    {
      return $path;
    }
		// If attempted file does not exist, but the file is in a dir that exists, that is good enough.
		elseif ( ! is_dir($path) && is_dir(dirname($path)) )
		{
			 return $path;
		}
		// If path is not in the abspath, it might be relative.
    elseif (strpos($path, $abspath->getPath()) === false)
    {
	    // if path does not contain basepath.
	    //$uploadDir = $fs->getWPUploadBase();
	    //$abspath = $fs->getWPAbsPath();

      $path = $this->relativeToFullPath($path);
    }
    $path = apply_filters('shortpixel/filesystem/processFilePath', $path, $original_path);
    /* This needs some check here on malformed path's, but can't be test for existing since that's not a requirement.
    if (file_exists($path) === false) // failed to process path to something workable.
    {
    //  Log::addInfo('Failed to process path', array($path));
      $path = false;
    } */

    return $path;
  }

	protected function checkTrustedMode()
	{
		// When in trusted mode prevent filesystem checks as much as possible.
		if (true === self::$TRUSTED_MODE)
		{
				$this->exists = true;
				$this->is_writable = true;
				$this->is_directory_writable = true;
				$this->is_readable = true;
				$this->is_file = true;
				// Set mime to prevent lookup in IsImage
				$this->mime = 'image/' . $this->getExtension();

				if (is_null($this->filesize))
				{
					$this->filesize = 0; 
				}
		}

	}


  /** Resolve an URL to a local path
  *  This partially comes from WordPress functions attempting the same
  * @param String $url  The URL to resolve
  * @return String/Boolean - False is this seems an external domain, otherwise resolved path.
  */
  private function UrlToPath($url)
  {
     //$uploadDir = wp_upload_dir();

     $site_url = str_replace('http:', '', home_url('', 'http'));
     $url = str_replace(array('http:', 'https:'), '', $url);
     $fs = \wpSPIO()->filesystem();

     if (strpos($url, $site_url) !== false)
     {
       // try to replace URL for Path
       $abspath =  \wpSPIO()->filesystem()->getWPAbsPath();
       $path = str_replace($site_url, rtrim($abspath->getPath(),'/'), $url);

       if (! $fs->pathIsUrl($path)) // test again.
       {

        return $path;
       }
     }

     $this->is_virtual = true;

		 // This filter checks if some supplier will be able to handle the file when needed.
     $path = apply_filters('shortpixel/image/urltopath', false, $url);

		 if ($path !== false)
     {
          $this->exists = true;
          $this->is_readable = true;
          $this->is_file = true;
     }
     else
     {
         $this->exists = false;
         $this->is_readable = false;
         $this->is_file = false;
     }


     return false; // seems URL from other server, use virtual mode.
  }

  /** Tries to find the full path for a perceived relative path.
  *
  * Relative path is detected on basis of WordPress ABSPATH. If this doesn't appear in the file path, it might be a relative path.
  * Function checks for expections on this rule ( tmp path ) and returns modified - or not - path.
  * @param $path The path for the file_exists
  * @returns String The updated path, if that was possible.
  */
  private function relativeToFullPath($path)
  {
      $originalPath = $path; // for safe-keeping

      // A file with no path, can never be created to a fullpath.
      if (strlen($path) == 0)
        return $path;

      // if the file plainly exists, it's usable /**
      if (file_exists($path))
      {
        return $path;
      }

      // Test if our 'relative' path is not a path to /tmp directory.

      // This ini value might not exist.
      $tempdirini = ini_get('upload_tmp_dir');
      if ( (strlen($tempdirini) > 0) && strpos($path, $tempdirini) !== false)
        return $path;

      $tempdir = sys_get_temp_dir();
      if ( (strlen($tempdir) > 0) && strpos($path, $tempdir) !== false)
        return $path;

      // Path contains upload basedir. This happens when upload dir is outside of usual WP.
      $fs = \wpSPIO()->filesystem();
      $uploadDir = $fs->getWPUploadBase();
      $abspath = $fs->getWPAbsPath();

      if (strpos($path, $uploadDir->getPath()) !== false) // If upload Dir is feature in path, consider it ok.
      {
        return $path;
      }
      elseif (file_exists($abspath->getPath() . $path)) // If upload dir is abspath plus return path. Exceptions.
      {
        return $abspath->getPath() . $path;
      }
      elseif(file_exists($uploadDir->getPath() . $path)) // This happens when upload_dir is not properly prepended in get_attachment_file due to WP errors
      {
          return $uploadDir->getPath() . $path;
      }

      // this is probably a bit of a sharp corner to take.
      // if path starts with / remove it due to trailingslashing ABSPATH
      $path = ltrim($path, '/');
      $fullpath = $abspath->getPath() . $path;

      // We can't test for file_exists here, since file_model allows non-existing files.
      // Test if directory exists, perhaps. Otherwise we are in for a failure anyhow.
      //if (is_dir(dirname($fullpath)))
          return $fullpath;
      //else
      //    return $originalPath;
  }

  /*private function getUploadPath()
  {
    $upload_dir = wp_upload_dir(null, false, false);
    $basedir = $upload_dir['basedir'];

    return $basedir;
  } */


  /** Fix for multibyte pathnames and pathinfo which doesn't take into regard the locale.
  * This snippet taken from PHPMailer.
  */
  private function mb_pathinfo($path, $options = null)
  {
        $ret = ['dirname' => '', 'basename' => '', 'extension' => '', 'filename' => ''];
        $pathinfo = [];
        if (preg_match('#^(.*?)[\\\\/]*(([^/\\\\]*?)(\.([^.\\\\/]+?)|))[\\\\/.]*$#m', $path, $pathinfo)) {
            if (array_key_exists(1, $pathinfo)) {
                $ret['dirname'] = $pathinfo[1];
            }
            if (array_key_exists(2, $pathinfo)) {
                $ret['basename'] = $pathinfo[2];
            }
            if (array_key_exists(5, $pathinfo)) {
                $ret['extension'] = $pathinfo[5];
            }
            if (array_key_exists(3, $pathinfo)) {
                $ret['filename'] = $pathinfo[3];
            }
        }
        switch ($options) {
            case PATHINFO_DIRNAME:
            case 'dirname':
                return $ret['dirname'];
            case PATHINFO_BASENAME:
            case 'basename':
                return $ret['basename'];
            case PATHINFO_EXTENSION:
            case 'extension':
                return $ret['extension'];
            case PATHINFO_FILENAME:
            case 'filename':
                return $ret['filename'];
            default:
                return $ret;
        }
    }

    public function __debuginfo()
    {
       return [
          'fullpath' => $this->fullpath,
          'filename' => $this->filename,
          'filebase' => $this->filebase,
          'exists' => $this->exists,
          'is_writable' => $this->is_writable,
          'is_readable' => $this->is_readable,
					'is_virtual' => $this->is_virtual,
       ];
    }


} // FileModel Class
