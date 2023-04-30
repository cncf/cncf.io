<?php
namespace ShortPixel\Controller;
use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;

use ShortPixel\Model\File\DirectoryModel as DirectoryModel;
use ShortPixel\Model\File\FileModel as FileModel;

use ShortPixel\Model\Image\MediaLibraryModel as MediaLibraryModel;
use ShortPixel\Model\Image\MediaLibraryThumbnailModel as MediaLibraryThumbnailModel;
use ShortPixel\Model\Image\CustomImageModel as CustomImageModel;

/** Controller for FileSystem operations
*
* This controller is used for -compound- ( complex ) FS operations, using the provided models File en Directory.
* USE via \wpSPIO()->filesystem();
*/
Class FileSystemController extends \ShortPixel\Controller
{
    protected $env;
		static $mediaItems = array();
		static $customItems = array();

    public function __construct()
    {
      $this->env = wpSPIO()->env();

    }

    /** Get FileModel for a certain path. This can exist or not
    *
    * @param String Path Full Path to the file
    * @return FileModel FileModel Object. If file does not exist, not all values are set.
    */
    public function getFile($path)
    {
      return new FileModel($path);
    }

    /** Get MediaLibraryModel for a Post_id
		* @param int $id
		* @param bool $useCache  If false then it will require a fresh copt from database. Use when meta has changed / saved
		* @param bool $cacheOnly Prevent fetching from Database. Used for checkLegacy and other places where conflicts with mainFile arise, checking for backups.
		*/
    public function getMediaImage($id, $useCache = true, $cacheOnly = false)
    {
				if ($useCache === true && isset(self::$mediaItems[$id]))
				{
					 return self::$mediaItems[$id];
				}

				if (true === $cacheOnly)
					return false;

        $filepath = get_attached_file($id);
        $filepath = apply_filters('shortpixel_get_attached_file', $filepath, $id);

        // Somehow get_attached_file can return other random stuff.
        if ($filepath === false || strlen($filepath) == 0)
          return false;

        $imageObj = new MediaLibraryModel($id, $filepath);

				if (is_object($imageObj))
				{
					 self::$mediaItems[$id] = $imageObj;
				}

        return $imageObj;
    }

		/**
		* @param int $id
		*/
    public function getCustomImage($id, $useCache = true)
    {
				if ($useCache === true && isset(self::$customItems[$id]))
				{
				 return self::$customItems[$id];
				}

        $imageObj = new CustomImageModel($id);

				if (is_object($imageObj))
				{
					 self::$customItems[$id] = $imageObj;
				}

        return $imageObj;
    }

		// Use sporadically, every time an angel o performance dies.
		// Required for files that change i.e. enable media replace or other filesystem changing operation.
		public function flushImageCache()
		{
					 self::$mediaItems = array();
					 self::$customItems = array();
					 MediaLibraryModel::onFlushImageCache();
		}

		public function flushImage($imageObj)
		{
				$id = $imageObj->get('id');
				 $type = $imageObj->get('type');

				if ('media' == $type && isset(self::$mediaItems[$id]))
				{
					 unset(self::$mediaItems[$id]);
					 MediaLibraryModel::onFlushImageCache();
				}
				if ('custom' == $type && isset(self::$customItems[$id]))
				{
					 unset(self::$customItems[$id]);
				}
		}

    /** Gets a custom Image Model without being in the database. This is used to check if path is a proper customModel path ( not mediaLibrary ) and see if the file should be included per excusion rules */
    public function getCustomStub( $path, $load = true)
    {
        $imageObj = new CustomImageModel(0);
        $imageObj->setStub($path, $load);
        return $imageObj;
    }

    /** Generic function to get the correct image Object, to prevent many switches everywhere
		* int $id
		* string $type
		*/
    public function getImage( $id,  $type, $useCache = true)
    {
			// False, OptimizeController does a hard check for false.
      $imageObj = false;

      if ($type == 'media')
        $imageObj = $this->getMediaImage($id, $useCache);
      elseif($type == 'custom')
        $imageObj = $this->getCustomImage($id, $useCache);
      else
        Log::addError('FileSystemController GetImage - no correct type given: ' . $type);

      return $imageObj;
    }


    /* wp_get_original_image_path with specific ShortPixel filter
		* @param int $id
     */
    public function getOriginalImage($id)
    {
      $filepath = \wp_get_original_image_path($id);
      $filepath = apply_filters('shortpixel_get_original_image_path', $filepath, $id);
      return new MediaLibraryThumbnailModel($filepath, $id, 'original');
    }

    /** Get DirectoryModel for a certain path. This can exist or not
    *
    * @param String $path Full Path to the Directory.
    * @return DirectoryModel Object with status set on current directory.
    */
    public function getDirectory($path)
    {
      return new DirectoryModel($path);
    }

    /** Get the BackupLocation for a FileModel. FileModel should be not a backup itself or it will recurse
    *
    *  For now this function should only be used for *new* backup files. Retrieving backup files via this method
    *  doesn't take into account legacy ways of storage.
    *
    * @param FileModel $file FileModel with file that needs a backup.
    * @return DirectoryModel | Boolean DirectoryModel pointing to the backup directory. Returns false if the directory could not be created, or initialized.
    */
    public function getBackupDirectory(FileModel $file, $create = false)
    {
			if (! function_exists('get_home_path'))
			{
				require_once(ABSPATH . 'wp-admin/includes/file.php');
			}
      $wp_home = \get_home_path();
      $filepath = $file->getFullPath();

      if ($file->is_virtual())
      {
         $filepath = apply_filters('shortpixel/file/virtual/translate', $filepath, $file);
      }

			//  translate can return false if not properly offloaded / not found there.
      if ($filepath !== $file->getFullPath() && $filepath !== false)
      {
         $file = $this->getFile($filepath);
      }

      $fileDir = $file->getFileDir();


      $backup_subdir = $fileDir->getRelativePath();

      if ($backup_subdir === false)
      {
         $backup_subdir = $this->returnOldSubDir($filepath);
      }

      $backup_fulldir = SHORTPIXEL_BACKUP_FOLDER . '/' . $backup_subdir;

      $directory = $this->getDirectory($backup_fulldir);

      $directory = apply_filters("shortpixel/file/backup_folder", $directory, $file);

      if ($create === false && $directory->exists())
        return $directory;
			elseif ($create === true && $directory->check()) // creates directory if needed.
				return $directory;
      else {
        return false;
      }
    }

    /** Get the base folder from where custom paths are possible (from WP-base / sitebase)

    */
    public function getWPFileBase()
    {
      if(\wpSPIO()->env()->is_mainsite) {
          $path = (string) $this->getWPAbsPath();
      } else {
          $up = wp_upload_dir();
          $path = realpath($up['basedir']);
      }
      $dir = $this->getDirectory($path);
      if (! $dir->exists())
        Log::addWarn('getWPFileBase - Base path doesnt exist');

      return $dir;

    }

    /** This function returns the WordPress Basedir for uploads ( without date and such )
    * Normally this would point to /wp-content/uploads.
    * @returns DirectoryModel
    */
    public function getWPUploadBase()
    {
      $upload_dir = wp_upload_dir(null, false);

      return $this->getDirectory($upload_dir['basedir']);
    }

    /** This function returns the Absolute Path of the WordPress installation where the **CONTENT** directory is located.
    * Normally this would be the same as ABSPATH, but there are installations out there with -cough- alternative approaches
    * @returns DirectoryModel  Either the ABSPATH or where the WP_CONTENT_DIR is located
    */
    public function getWPAbsPath()
    {
        $wpContentAbs = str_replace( 'wp-content', '', WP_CONTENT_DIR);
        if (ABSPATH == $wpContentAbs)
          $abspath = ABSPATH;
        else
          $abspath = $wpContentAbs;

				if (defined('UPLOADS')) // if this is set, lead.
					$abspath = trailingslashit(ABSPATH) . UPLOADS;

//	$abspath = wp_normalize_path($abspath);
        $abspath = apply_filters('shortpixel/filesystem/abspath', $abspath );


        return $this->getDirectory($abspath);
    }



    /** Not in use yet, do not use. Future replacement. */
    public function checkBackUpFolder($folder = SHORTPIXEL_BACKUP_FOLDER)
    {
				$dirObj = $this->getDirectory($folder);
				$result = $dirObj->check(true);  // check creates the whole structure if needed.
				return $result;
    }


    /** Utility function that tries to convert a file-path to a webURL.
    *
    * If possible, rely on other better methods to find URL ( e.g. via WP functions ).
    */
    public function pathToUrl(FileModel $file)
    {
      $filepath = $file->getFullPath();
      $directory = $file->getFileDir();

			$is_multi_site = $this->env->is_multisite;
			$is_main_site =  $this->env->is_mainsite;

      // stolen from wp_get_attachment_url
      if ( ( $uploads = wp_get_upload_dir() ) && (false === $uploads['error'] || strlen(trim($uploads['error'])) == 0  )  ) {
            // Check that the upload base exists in the file location.
            if ( 0 === strpos( $filepath, $uploads['basedir'] ) ) { // Simple as it should, filepath and basedir share.
                // Replace file location with url location.
                $url = str_replace( $uploads['basedir'], $uploads['baseurl'], $filepath );
						}
						// Multisite backups are stored under uploads/ShortpixelBackups/etc , but basedir would include uploads/sites/2 etc, not matching above
						// If this is case, test if removing the last two directories will result in a 'clean' uploads reference.
						// This is used by getting preview path ( backup pathToUrl) in bulk and for comparer..
					  elseif ($is_multi_site && ! $is_main_site  && 0 === strpos($filepath, dirname(dirname($uploads['basedir']))) )
						{

								$url = str_replace( dirname(dirname($uploads['basedir'])), dirname(dirname($uploads['baseurl'])), $filepath );
								$homeUrl = home_url();

								// The result didn't end in a full URL because URL might have less subdirs ( dirname dirname) .
								// This happens when site has blogs.dir (sigh) on a subdomain . Try to substitue the ABSPATH root with the home_url
								if (strpos($url, $homeUrl) === false)
								{
									 $url = str_replace( trailingslashit(ABSPATH), trailingslashit($homeUrl), $filepath);
								}

            } elseif ( false !== strpos( $filepath, 'wp-content/uploads' ) ) {
                // Get the directory name relative to the basedir (back compat for pre-2.7 uploads)
                $url = trailingslashit( $uploads['baseurl'] . '/' . _wp_get_attachment_relative_path( $filepath ) ) . wp_basename( $filepath );
            } else {
                // It's a newly-uploaded file, therefore $file is relative to the basedir.
                $url = $uploads['baseurl'] . "/$filepath";
            }
        }

        $wp_home_path = (string) $this->getWPAbsPath();
        // If the whole WP homepath is still in URL, assume the replace when wrong ( not replaced w/ URL)
        // This happens when file is outside of wp_uploads_dir
        if (strpos($url, $wp_home_path) !== false)
        {
          // This is SITE URL, for the same reason it should be home_url in FILEMODEL. The difference is when the site is running on a subdirectory
          // (1) ** This is a fix for a real-life issue, do not change if this causes issues, another fix is needed then.
		  // (2) ** Also a real life fix when a path is /wwwroot/assets/sites/2/ etc, in get site url, the home URL is the site URL, without appending the sites stuff. Fails on original image.
		    if ($is_multi_site && ! $is_main_site)
				{
					$wp_home_path = trailingslashit($uploads['basedir']);
					$home_url = trailingslashit($uploads['baseurl']);
				}
				else
          $home_url = trailingslashit(get_site_url()); // (1)
          $url = str_replace($wp_home_path, $home_url, $filepath);
        }

        // can happen if there are WP path errors.
        if (is_null($url))
          return false;

        $parsed = parse_url($url); // returns array, null, or false.

        // Some hosts set the content dir to a relative path instead of a full URL. Api can't handle that, so add domain and such if this is the case.
        if ( !isset($parsed['scheme']) ) {//no absolute URLs used -> we implement a hack

           if (isset($parsed['host'])) // This is for URL's for // without http or https. hackhack.
           {
             $scheme = is_ssl() ? 'https:' : 'http:';
             return $scheme. $url;
           }
           else
           {
           // From Metafacade. Multiple solutions /hacks.
              $home_url = trailingslashit((function_exists("is_multisite") && is_multisite()) ? trim(network_site_url("/")) : trim(home_url()));
              return $home_url . ltrim($url,'/');//get the file URL
           }
        }

        if (! is_null($parsed) && $parsed !== false)
          return $url;

        return false;
    }

    public function checkURL($url)
    {
        if (! $this->pathIsURL($url))
        {
           //$siteurl = get_option('siteurl');
           if (strpos($url, get_site_url()) == false)
           {
              $url = get_site_url(null, $url);

           }
        }

        return apply_filters('shortpixel/filesystem/url', $url);
    }

    /** Utility function to check if a path is an URL
    *  Checks if this path looks like an URL.
    * @param $path String  Path to check
    * @return Boolean If path seems domain.
    */
    public function pathIsUrl($path)
    {
      $is_http = (substr($path, 0, 4) == 'http') ? true : false;
      $is_https = (substr($path, 0, 5) == 'https') ? true : false;
      $is_neutralscheme = (substr($path, 0, 2) == '//') ? true : false; // when URL is relative like //wp-content/etc
      $has_urldots = (strpos($path, '://') !== false) ? true : false; // Like S3 offloads

      if ($is_http || $is_https || $is_neutralscheme || $has_urldots)
        return true;
      else
        return false;
    }

    /** Sort files / directories in a certain way.
    * Future dev to include options via arg.
    */
    public function sortFiles($array, $args = array() )
    {
        if (count($array) == 0)
          return $array;

        // what are we sorting.
        $class = get_class($array[0]);
        $is_files = ($class == 'ShortPixel\FileModel') ? true : false; // if not files, then dirs.

        usort($array, function ($a, $b) use ($is_files)
            {
              if ($is_files)
                return strcmp($a->getFileName(), $b->getFileName());
              else {
                return strcmp($a->getName(), $b->getName());
              }
            }
        );

        return $array;

    }

		// @todo Deprecate this, move some functs perhaps to DownloadHelper.
    public function downloadFile($url, $destinationPath)
    {
      $downloadTimeout = max(SHORTPIXEL_MAX_EXECUTION_TIME - 10, 15);
      $fs = \wpSPIO()->filesystem(); // @todo change this all to $this
    //  $fs = \wpSPIO()->fileSystem();
      $destinationFile = $fs->getFile($destinationPath);

      $args_for_get = array(
        'stream' => true,
        'filename' => $destinationPath,
				'timeout' => $downloadTimeout,
      );

      $response = wp_remote_get( $url, $args_for_get );

      if(is_wp_error( $response )) {
        Log::addError('Download file failed', array($url, $response->get_error_messages(), $response->get_error_codes() ));

        // Try to get it then via this way.
        $response = download_url($url, $downloadTimeout);
        if (!is_wp_error($response)) // response when alright is a tmp filepath. But given path can't be trusted since that can be reason for fail.
        {
          $tmpFile = $fs->getFile($response);
          $result = $tmpFile->move($destinationFile);

        } // download_url ..
        else {
          Log::addError('Secondary download failed', array($url, $response->get_error_messages(), $response->get_error_codes() ));
        }
      }
      else { // success, at least the download.
          $destinationFile = $fs->getFile($response['filename']);
      }

      Log::addDebug('Remote Download attempt result', array($url, $destinationPath));
      if ($destinationFile->exists())
        return true;
      else
        return false;
    }



    /** Get all files from a directory tree, starting at given dir.
    * @param DirectoryModel $dir to recursive into
    * @param Array $filters Collection of optional filters as accepted by FileFilter in directoryModel
    * @return Array Array of FileModel Objects
     **/
    public function getFilesRecursive(DirectoryModel $dir, $filters = array() )
    {
        $fileArray = array();

        if (! $dir->exists())
          return $fileArray;

        $files = $dir->getFiles($filters);
        $fileArray = array_merge($fileArray, $files);

        $subdirs = $dir->getSubDirectories();

        foreach($subdirs as $subdir)
        {
             $fileArray = array_merge($fileArray, $this->getFilesRecursive($subdir, $filters));
        }

        return $fileArray;
    }

		// Url very sparingly.
		public function url_exists($url)
		{
			 if (! \wpSPIO()->env()->is_function_usable('curl_init'))
			 {
				  return null;
			 }

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_NOBODY, true);
			curl_exec($ch);
			$responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);

			if ($responseCode == 200)
			{
				return true;
			}
			else {
				return false;
			}

		}

		/** Any files / directories loaded while this is active will not check for exists or other filesystem operations
		*
		*/
		public function startTrustedMode()
		{
				if (\wpSPIO()->env()->useTrustedMode())
				{
			 		FileModel::$TRUSTED_MODE = true;
					DirectoryModel::$TRUSTED_MODE = true;
				}
		}

		public function endTrustedMode()
		{
			if (\wpSPIO()->env()->useTrustedMode())
			{
				FileModel::$TRUSTED_MODE = false;
				DirectoryModel::$TRUSTED_MODE = false;
			}
		}

    /** Old method of getting a subDir. This is messy and hopefully should not be used anymore. It's added here for backward compat in case of exceptions */
    private function returnOldSubDir($file)
    {
              // Experimental FS handling for relativePath. Should be able to cope with more exceptions.  See Unit Tests
				Log::addWarn('Return Old Subdir was called, everything else failed');
              $homePath = get_home_path();
              if($homePath == '/') {
                  $homePath = $this->getWPAbsPath();
              }
              $hp = wp_normalize_path($homePath);
              $file = wp_normalize_path($file);

            //  $sp__uploads = wp_upload_dir();

              if(strstr($file, $hp)) {
                  $path = str_replace( $hp, "", $file);
              } elseif( strstr($file, dirname( WP_CONTENT_DIR ))) { //in some situations the content dir is not inside the root, check this also (ex. single.shortpixel.com)
                  $path = str_replace( trailingslashit(dirname( WP_CONTENT_DIR )), "", $file);
              } elseif( (strstr(realpath($file), realpath($hp)))) {
                  $path = str_replace( realpath($hp), "", realpath($file));
              } elseif( strstr($file, trailingslashit(dirname(dirname( SHORTPIXEL_UPLOADS_BASE )))) ) {
                  $path = str_replace( trailingslashit(dirname(dirname( SHORTPIXEL_UPLOADS_BASE ))), "", $file);
              } else {
                  $path = (substr($file, 1));
              }
              $pathArr = explode('/', $path);
              unset($pathArr[count($pathArr) - 1]);
              return implode('/', $pathArr) . '/';
    }



}
