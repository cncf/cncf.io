<?php
namespace ShortPixel\Model;

use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;

use ShortPixel\Controller\OtherMediaController as OtherMediaController;
use ShortPixel\Model\Image\ImageModel as ImageModel;
use ShortPixel\Model\Image\MediaLibraryModel as MediaLibraryModel;


use ShortPixel\Helper\UtilHelper as UtilHelper;
use ShortPixel\Helper\InstallHelper as InstallHelper;


class StatsModel
{

  // Below are counted and saved in settings
  protected $totalOptimized; // combined filesize of optimized images
  protected $totalOriginal;  // combined filesize of original images

  // There are gotten via SQL and saved in stats
  //protected $totalImages;
  //protected $totalThumbnails

  protected $lastUpdate;
  protected $path = array();

  protected $currentStat;  // used for chaining it.

  protected $refreshStatTime;


  // Commented out stats were dropped.
  // Note: the difference in items / images including thumbs and the counts don't . This is due to technical difference in acquiring the data.
    protected $defaults = array(
      'media' => array('items' => -1, // total optimized media items found
                       'images' => -1, // total optimized images (+thumbs) found
                       'thumbs' => -1, // Optimized thumbs - SQL does thumbs, but queue doesn't. (imprecise query)
                       'itemsTotal' => -1, // Total items in media  ( sql )
                       'thumbsTotal' => -1, // Total thumbs in media ( sql ) - imprecise query
											 'isLimited' => false,
                  /*     'lossy' => 0, // processed x compression
                       'lossy_thumbs' => 0, // main / thumbs
                       'lossless' => 0, // main /thumbs
                       'lossless_thumbs' => 0,
                       'glossy' => 0,
                       'glossy_thumbs' => 0, */
      ),
      'custom' => array('items' => -1, // total optimized custom items
                        'images' => -1, // total optimized custom images
                        'itemsTotal' => -1,

                      /*  'lossy' => 0, // process x compression
                        'lossless' => 0,
                        'glossy' => 0, */
      ),
      'period' => array('months' =>  // amount of images compressed in x month
                    array('1' => -1,  /// count x months ago what was done.
                        '2' => -1,
                        '3' => -1,
                        '4' => -1,
                    ),
      ),
      'total' => array('items' => -1,
                       'images' => -1,
                       'thumbs' => -1,
                       'itemsTotal' => -1,
                       'thumbsTotal' => -1,
                     ),

    /*  'total' => array('items' => 0,  // total items found
                       'images' => 0, // total images found
      ), */
  );

  protected $stats;  // loaded as defaults, or from dbase.

  public function __construct()
  {
      $this->refreshStatTime = apply_filters('shortpixel/statistics/refresh', WEEK_IN_SECONDS);
      $this->load();
  }

  public function load()
  {
    $settings = \wpSPIO()->settings();

    $this->totalOptimized = $settings->totalOptimized;
    $this->totalOriginal = $settings->totalOriginal;

    $stats = $settings->currentStats;

    // Legacy. Stats from < 5.0 are loaded somehow. Don't load them.
    if (isset($stats['APIKeyValid']))
      $stats = $this->defaults;

    $this->lastUpdate = (isset($stats['time'])) ? $stats['time'] : 0;

    if ( ($this->lastUpdate + $this->refreshStatTime) >= time())
    {
       $this->stats = $stats;
    }
    else
      $this->stats = $this->defaults;

  }

  public function save()
  {
     $settings = \wpSPIO()->settings();
     $stats = $this->stats;
     $stats['time'] = time();

     $settings->currentStats = $stats;
  }

  public function reset()
  {
      $this->stats = $this->defaults;
			\wpSPIO()->settings()->deleteOption('currentStats');

  //    $this->save();
  }

  // @todo This is not functional
  public function add($stat)
  {
     if (property_exists($stat, 'images'))
         $this->stats[$stat->type][$images] += $stats->images;
     if (property_exists($stat, 'items'))
        $this->stats[$stat->type][$items] += $stats->items;


  }

  public function get($name)
  {
      if (property_exists($this, $name))
         return $this->$name;
      else
        return null;
  }

  public function getStat($type)
  {
      $this->currentStat = null;

      if (isset($this->stats[$type]))
      {
         $this->currentStat = $this->stats[$type];
         $this->path = [$type];
      }

      return $this;
  }

  public function grab($data)
  {

     if (is_null($this->currentStat))
          return null;

       if (array_key_exists($data, $this->currentStat))
       {
          $this->currentStat = $this->currentStat[$data];
          $this->path[] = $data;
       }


       if (! is_array($this->currentStat))
       {
         if ($this->currentStat === -1)
         {
            $this->currentStat = $this->fetchStatdata();  // if -1 stat might not be loaded, load.
         }

        return $this->currentStat;
       }
       else
			 {
        return $this;
			 }
  }

  private function fetchStatData()
  {
      $path = $this->path;
      $data = -1;

      if ($path[0] == 'period' && $path[1] == 'months' && isset($path[2]))
      {
          $month = $path[2];

          $data = $this->countMonthlyOptimized(intval($month));

          if ($data >= 0)
          {
            $this->stats['period']['months'][$month] = $data;
            $this->save();
          }

      }
      if ($path[0] == 'media')
      {
          switch($path[1])
          {
            case 'items':
              $data = $this->countMediaItems(['optimizedOnly' => true]);
            break;
            case 'thumbs': // unrealiable if certain thumbs are not optimized, but the main image is.
              $data = $this->countMediaThumbnails(['optimizedOnly' => true]);
            break;
            case 'images':
              $data = $this->getStat('media')->grab('items') + $this->getStat('media')->grab('thumbs');
            break;
            case 'itemsTotal':
              $data = $this->countMediaItems();
            break;
            case 'thumbsTotal':
               $data = $this->countMediaThumbnails();
            break;
						case 'isLimited':
								$data = $this->stats['media']['isLimited'];
						break;
          }

          if ($data >= 0)
          {
						 if (is_numeric($data))
						 {
							  $data = max($data, 0);
						 }
             $this->stats['media'][$path[1]] = $data; // never allow any data below zero.
             $this->save();
          }
      }


      if ($path[0] == 'custom')
      {
          switch($path[1])
          {
             case 'items':
                $data = $this->customItems(['optimizedOnly' => true]);
             break;
             case 'itemsTotal':
                $data = $this->customItems();
             break;
          }

          if ($data >= 0)
          {
             $this->stats['custom'][$path[1]] = $data;
             $this->save();
          }
      }

      if ($path[0] == 'total')
      {
         switch($path[1])
         {

            case 'items':
              $media = $this->getStat('media')->grab('items');
              $custom = $this->getStat('custom')->grab('items');
              $data = $media + $custom;
            break;
            case 'images':
              $media = $this->getStat('media')->grab('images');
              $custom = $this->getStat('custom')->grab('items'); // items == images
              $data = $media + $custom;
            break;
            case 'thumbs':
               $data = $this->getStat('media')->grab('thumbs');
            break;
            case 'itemsTotal':
                $media = $this->getStat('media')->grab('itemsTotal');
                $custom = $this->getStat('custom')->grab('itemsTotal');
                $data = $media + $custom;
            break;
            case 'thumbsTotal':
                $data = $this->getStat('media')->grab('thumbsTotal');
            break;

         }
         if ($data >= 0)
         {
            $this->stats['total'][$path[1]] = $data;
            $this->save();
         }
      }

      return $data;

  }


  // suboptimal over full stats implementation, but faster.
  private function countMediaThumbnails($args = array())
  {
     global $wpdb;

     $defaults = array(
       'optimizedOnly' => false,
			 'limit' => 50000,
     );

     $args = wp_parse_args($args,$defaults);
		 $prepare = array();

     if ($args['optimizedOnly'] == true)
     {
       $sql =  ' SELECT count(id) as thumbcount FROM ' . UtilHelper::getPostMetaTable() . ' WHERE status = %d AND (image_type = %d or image_type = %d)';
			 $prepare = array(ImageModel::FILE_STATUS_SUCCESS, MediaLibraryModel::IMAGE_TYPE_THUMB, MediaLibraryModel::IMAGE_TYPE_ORIGINAL);
     }
		 else {
			 // This query will return 2 positions after the thumbnail array declaration.  Value can be up to two positions ( 0-100 thumbnails) . If positions is 1-10 intval will filter out the string part.
	     $sql = "SELECT  meta_id, post_id, substr(meta_value, instr(meta_value,'sizes')+9,2) as thumbcount, LOCATE('original_image', meta_value) as originalImage FROM " . $wpdb->postmeta . " WHERE meta_key = '_wp_attachment_metadata' ";

	     $sql .= " AND post_id NOT IN ( SELECT post_id FROM " . $wpdb->postmeta . " where meta_key = '_shortpixel_prevent_optimize' )";  // exclude 'crashed items'

			 $sql .= " limit 0," . $args['limit'];
		 }


		 if (count($prepare) > 0)
		 {
			  $sql = $wpdb->prepare($sql, $prepare);
		 }

     $results = $wpdb->get_results($sql);

		 //og::addDebug('Limit and count results' . $args['limit'] . ' ' . count($results));
		 if ($args['limit'] <= count($results))
		 {
			 	$this->stats['media']['isLimited']= true;
		 }

     $thumbCount = 0;

     foreach($results as $row)
     {
        $count = intval($row->thumbcount);
        if ($count > 0)
           $thumbCount += $count;
        if (property_exists($row, 'originalImage') && $row->originalImage > 0) // add to count, return value is string pos
           $thumbCount++;
     }

     return intval($thumbCount);
  }

  private function countMediaItems($args = array())
  {
      global $wpdb;

      $defaults = array(
        'optimizedOnly' => false,
      );

      $args = wp_parse_args($args,$defaults);
			$prepare = array();

      if ($args['optimizedOnly'] == true)
      {
        //$sql .= ' AND post_id IN ( SELECT post_id FROM ' . $wpdb->postmeta . ' WHERE meta_key = "_shortpixel_optimized")';
				$sql = ' SELECT count(id) as count FROM ' . UtilHelper::getPostMetaTable() . ' WHERE status = %d AND parent = %d';
				$prepare = array(ImageModel::FILE_STATUS_SUCCESS, MediaLibraryModel::IMAGE_TYPE_MAIN);
      }
			else {
				$sql = 'SELECT count(meta_id) FROM ' . $wpdb->postmeta . ' WHERE meta_key = "_wp_attached_file"';
     		$sql .= " AND post_id NOT IN ( SELECT post_id FROM " . $wpdb->postmeta . " where meta_key = '_shortpixel_prevent_optimize' )";  // exclude 'crashed items'
			}

			if (count($prepare) > 0)
				$sql = $wpdb->prepare($sql, $prepare);

      $count = $wpdb->get_var($sql);


			if (is_null($count) && strpos($wpdb->last_error, 'exist') !== false)
			{
				 InstallHelper::checkTables();
				 return 0;
			}

      return intval($count);
  }

  private function countMonthlyOptimized($monthsAgo = 1)
  {
     global $wpdb;
     //$monthsAgo = 0 - $monthsAgo; // minus it for the sub.
     /*$sql = "select meta_id from wp_postmeta where meta_key = '_shortpixel_meta' HAVING substr(meta_value, instr(meta_value, 'tsOptimized')+15,10) as stamp >= %d and stamp <= %d"; */

		 $date = new \DateTime();
     $date->sub( new \DateInterval('P' . $monthsAgo . 'M'));

     $dateUntil = new \DateTime();
     $dateUntil->sub( new \DateInterval('P' . ($monthsAgo-1). 'M'));

     $sql = 'SELECT count(id) FROM '  . $wpdb->prefix . 'shortpixel_postmeta WHERE tsOptimized >= %s and tsOptimized <= %s';
     $sql = $wpdb->prepare($sql, $date->format('Y-m-d H:i:s'), $dateUntil->format('Y-m-d H:i:s') );
     $count_media = $wpdb->get_var($sql);

		 // Custom
		 $sql = 'SELECT count(id) FROM '  . $wpdb->prefix . 'shortpixel_meta WHERE ts_optimized >= %s and ts_optimized <= %s';
		 $sql = $wpdb->prepare($sql, $date->format('Y-m-d H:i:s'), $dateUntil->format('Y-m-d H:i:s') );
		 $count_custom = $wpdb->get_var($sql);

		 $count = 0;
		 if (! is_null($count_media) && is_numeric($count_media))
		 	$count += $count_media;

			if (! is_null($count_custom) && is_numeric($count_custom))
 		 	$count += $count_custom;


     return $count;
  }

  private function customItems($args = array())
  {
       global $wpdb;

       $defaults = array(
         'optimizedOnly' => false,
       );

       $args = wp_parse_args($args,$defaults);

       $otherMediaController = OtherMediaController::getInstance();
       if (! $otherMediaController->hasCustomImages() )
       {
          return 0;
       }

			 $activeDirectories = $otherMediaController->getActiveDirectoryIDS();
      // $foldersids = implode(',', $activeDirectories );

			 if (count($activeDirectories) == 0)
			 	  return 0; // no active folders

					$in_str_arr = array_fill( 0, count( $activeDirectories ), '%s' );
 				 $in_str = join( ',', $in_str_arr );

       $sql = 'SELECT COUNT(id) as count FROM ' . $wpdb->prefix . 'shortpixel_meta WHERE folder_id in (' . $in_str . ')';
			 $sql = $wpdb->prepare($sql, $activeDirectories);

       if ($args['optimizedOnly'] == true)
       {
         $sql .= ' AND status = %d';
         $sql = $wpdb->prepare($sql, ImageModel::FILE_STATUS_SUCCESS);
       }

        $count = $wpdb->get_var($sql);
        return $count;

  }


} // class
