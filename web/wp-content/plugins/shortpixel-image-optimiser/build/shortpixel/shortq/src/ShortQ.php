<?php
namespace ShortPixel\ShortQ;
//use \ShortPixel\ShortQ\Queue;
//use \ShortPixel\ShortQ\DataProvider;

// init
class ShortQ
{

  const QSTATUS_ALL = -1; // special status, for query use
  const QSTATUS_WAITING = 0;
  const QSTATUS_PULLED = 1; // not in use atm.
  const QSTATUS_INPROCESS = 2;
  const QSTATUS_DONE = 3;

  const QSTATUS_DELETE = -1; // this is a virtual status. If set to this, will be deleted.
  const QSTATUS_ERROR = -2;
  const QSTATUS_FATAL = -3;

  protected $pluginSlug; // unique plugin name using Q.
  protected $queueName;
	protected $queue;
	protected $dataProvider;

  protected static $queues = array();

  public function __construct($pluginSlug)
  {

     $this->pluginSlug = $pluginSlug;
      //self::$queues[$qname] = $this;
  }

  public function getQueue($qName, $lock = false)
  {
      // @todo get config from main parent file, or so.
      $this->queue = 'wp';
      $this->dataProvider = 'mysql';
      $this->queueName = $qName;

      // if nothing, then create a new Q.
      $q = $this->QLoader();
      return $q;
  }

  protected function QLoader()
  {
     $dataProvider = null;
      switch($this->dataProvider)
      {
        case 'mysql':
				default:
           $dataProvider = new DataProvider\MysqlDataProvider($this->pluginSlug, $this->queueName);
        break;
      }

      switch($this->queue)
      {
        case 'wp':
        default:
              $newQ = new Queue\WPQ($this->pluginSlug, $this->queueName, $dataProvider);
        break;
      }

    /*  if (defined('SHORTPIXEL_DEBUG') && SHORTPIXEL_DEBUG)
      {
            $test = new Tests\Tests($newQ);
      } */

      self::$queues[$this->queueName] = $this;
      return $newQ;
  }

}
