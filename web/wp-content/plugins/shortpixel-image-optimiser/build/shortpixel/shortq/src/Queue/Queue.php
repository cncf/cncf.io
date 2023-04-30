<?php
namespace ShortPixel\ShortQ\Queue;
use ShortPixel\ShortQ\Item as Item;



/* Needed features
 - Database / Table agnostic Queue system (as in not dependent on specific ID's).
 - Check if Queue is in Use / Lock system
 - Multiple ways to say / restore should be possible
 - Multiplugin ready
*/

/* Queue is the main iterator for the queue */
interface Queue
{

  // needs to sync with DataProvider!
/*  const QSTATUS_WAITING = 0; //Waiting for process
  const QSTATUS_PULLED = 1;
  const QSTATUS_INPROCESS = 2; // Doing process now
  const QSTATUS_DONE = 3; // Is Done.

  const QSTATUS_DELETE = -1; // this is a virtual status. If set to this, will be deleted.
  const QSTATUS_ERROR = -2;
  const QSTATUS_FATAL = -3; */
  //private $name; // queue name

  public function __construct($pluginSlug, $queue_name, $dataProvider);
  public function setOptions($options); // set options via array, such as how much to pull / type of queue

  /* @param Mixed $items Items, or array of items. */
  public function addItems($items);
  public function enqueue();
  public function withOrder($items, $order); // chained method for adding items with an order. Returns Queue Object
  public function dequeue($args = array());

  /** Functions for async processing. Process should return item_id, put them on done or fail. */
  public function itemDone(Item $item);
  public function itemFailed(Item $item, $fatal = false);
  public function getItem($item_id);

  // return status object, for app to check what is going on.
  public function getStatus();



  public function hasItems();
  public function itemCount();
  public function itemSum($status = SHORTQ::QSTATUS_ALL);

  // reset, start fresh
  public function resetQueue();

  //public function setDataProvider($DataProvider); // DataProvider Object
  public function uninstall();

} // class
