<?php
namespace ShortPixel\ShortQ\DataProvider;
use ShortPixel\ShortQ\Item as Item;


/* DataProvider handles where the data is stored, and retrieval upon queue request
*
* DataProvider is responsible for creating it's own environment, and cleanup when uninstall is being called.
*
*/
interface DataProvider
{

  function __construct($pluginSlug, $queueName);

  //function add($items);
  function enqueue($items);
  function dequeue($args); // @return Items removed from queue and set to status. Returns Item Object
  function alterQueue($changes, $conditions, $operators); // @return Item Count / Boolean . Mass alteration of queue. ( changes, what to change, conditions, basically where statement)
  function itemUpdate(Item $item, $new_status);
  function getItem($item_id);
  function getItems($args); // get items on basis of status / updated date /etc


  // Returns number of items left in Queue.
  function itemCount($status = ShortQ::QSTATUS_WAITING);

  // Sum of a arbitrary number of items set by user.
  function itemSum($status = ShortQ::QSTATUS_ALL);

  function install($nocheck = false);
  function uninstall();
}
