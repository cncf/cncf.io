<?php
namespace ShortPixel\Controller;

use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;

use ShortPixel\Model\StatsModel as StatsModel;
use ShortPixel\Controller\Queue\StatsQueue as StatsQueue;

class StatsController extends \ShortPixel\Controller
{

    protected $model;
    protected $queue;
    protected static $instance;

    protected $stats =  array(
        //  'processed'
    );

    public function __construct()
    {
         $this->model = new StatsModel();
    }

    public static function getInstance()
    {
         if (is_null(self::$instance))
           self::$instance = new StatsController();

         return self::$instance;
    }

    public function find(... $params)
    {
        if (count($params) == 1)
        {
           $stat = $this->model->get($params[0]); // check if stat is simple property
           if (! is_null($stat) )
           {
              return $stat;
           }
        }

        $stat = $this->model->getStat(array_shift($params));

        for($i = 0; $i < count($params); $i++)
        {
            $stat = $stat->grab($params[$i]);
        }

        if (is_object($stat)) // failed to get statistic.
        {
            Log::addWarn('Statistics for this path failed', $params );
            return 0;

        }
        else
          return $stat;
    }

    public function reset()
    {
       $this->model->reset();
    }

    public function getAverageCompression()
    {
      $totalOptimized = $this->model->get('totalOptimized');
      $totalOriginal = $this->model->get('totalOriginal');

			$average = 0;

			if ($totalOptimized > 0 && $totalOriginal > 0)
			{
				 $average = round(( 1 -  ( $totalOptimized / $totalOriginal ) ) * 100, 2);
			}

      return $average;
    }

    // This is not functional @todo
    public function addImage($stats)
    {
       $stats->type = 'media';
       $stats->compression = 'lossy';
       $stats->images = 6;
       $stats->items = 1;
       $stats->timestamp = 0;

       $this->model->add($stats);
    }

    /** This is a different calculation since the thumbs and totals are products of a database query without taking into account optimizable, excluded thumbs etc. This is a performance thing */
    public function thumbNailsToOptimize()
    {
       $totalThumbs = $this->find('media',
               'thumbsTotal'); // according to database.
       $totalThumbsOptimized = $this->find('media', 'thumbs');

       $excludedThumbnails = \wpSPIO()->settings()->excludeSizes;
       $excludeCount = (is_array($excludedThumbnails)) ? count($excludedThumbnails) : 0;

        // Totalthumbs - thumbsOptimized - minus amount of excluded (guess)
       $toOptimize = $totalThumbs - $totalThumbsOptimized - ($this->find('media', 'items') * $excludeCount);


       return $toOptimize;

    }

    /** This count all possible optimizable images (approx). Not checking settings like excludesizes / webp / original images etc. More fine-grained approx in BulkViewController  */
    public function totalImagesToOptimize()
    {
        $totalImagesOptimized = $this->find('total', 'images');
        $totalImages = $this->find('total', 'itemsTotal') + $this->find('total', 'thumbsTotal');

        $toOpt = $totalImages - $totalImagesOptimized;

        return $toOpt;

    }





} // class
