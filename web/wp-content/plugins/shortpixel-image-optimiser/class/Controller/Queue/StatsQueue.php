<?php
namespace ShortPixel\Controller\Queue;

use ShortPixel\ShortQ\ShortQ as ShortQ;
use ShortPixel\Controller\CacheController as CacheController;
use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;

use ShortPixel\Controller\StatsController as StatsController;

class StatsMediaQueue extends MediaLibraryQueue
{
}

class StatsCustomQueue extends CustomQueue
{
}


class StatsQueue extends MediaLibraryQueue
{
  public function __construct($queueName = 'Stats')
  {
    $shortQ = new ShortQ(self::PLUGIN_SLUG);
    $this->q = $shortQ->getQueue($queueName);
    $this->queueName = $queueName;

    $options = array(
       'numitems' => 200,
       'mode' => 'direct',
       'process_timeout' => 7000,
       'retry_limit' => 20,
       'enqueue_limit' => 1000,
    );

    $options = apply_filters('shortpixel/statsqueue/options', $options);
    $this->q->setOptions($options);
  }

  public function prepareItems($items)
  {
    $statsControl = statsControl::getInstance();

    foreach($items as $imageObj)
    {
        if ($imageObj->isOptimized())
        {

        }
        else
        {

        }
    }

  }

  public function run()
  {
      $result = $this->prepare();
    //  $statsControl = statsControl::getInstance();



  }

} // class
