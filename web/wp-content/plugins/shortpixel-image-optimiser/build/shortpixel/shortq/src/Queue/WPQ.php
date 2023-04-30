<?php
namespace ShortPixel\ShortQ\Queue;
use ShortPixel\ShortQ\Item as Item;
use ShortPixel\ShortQ\Status as Status;
use \ShortPixel\ShortQ\ShortQ as ShortQ;

class WPQ implements Queue
{
  private $statusName = 'shortqwp_';

  protected $qName; // queue Name
  protected $pSlug; // plugin slug
  protected $DataProvider;

  protected $status; // the status, the whole status and nothing but.
	protected $currentStatus; // working status, current queue name.
  protected $items = array();

  protected $options;

  // statistics and status
  protected $current_ask = 0;

  /*
  * @param qName - Name of the Queue requested by parent
  */
  public function __construct($slug, $qName, $DataProvider)
  {
    if ($slug == '' || $qName == '' )
      return false;

    $statusName = $this->statusName . $slug;
    if (strlen($statusName) >= 64) // max for wp_options
      $statusName = substr($statusName, 0, 64);

    $this->statusName = $statusName;

    $this->qName = $qName;
    $this->pSlug = $slug;
    $this->DataProvider = $DataProvider;

    $this->loadStatus();

    $this->options = new \stdclass;
    $this->options->numitems = 1; //amount to dequeue
    $this->options->mode = 'direct'; // direct | wait
    $this->options->enqueue_limit = 1000; // amount of items to deliver to DataProvider in one go.
    $this->options->process_timeout = 10000; //How long to wait 'IN_PROCESS' for a retry to happen (until retry_limit)
    $this->options->retry_limit = 5;
    $this->options->timeout_recount = 20000; // Time to recount and check stuff from datasource in MS
    $this->options->is_debug = false;

  }

  public function setOptions($options)
  {
      foreach($options as $option => $value)
      {
        $this->setOption($option, $value);
      }
  }

  public function setOption($name, $value)
  {
      if (property_exists($this->options, $name))
        $this->options->$name = $value;
  }

  public function getOption($name)
  {
     if (property_exists($this->options, $name))
        return $this->options->$name;
  }

  /** Prepare items for enqueue, if you want to deliver items in batch, but not flush to storage directly
  *    Every Item needs to have an (item)_id and (item)_value. That's the only thing remote app should be aware of.
  *    @param Array Item Array with fields: id, value [order]
	* 	 @param bool If status should be updated due to adding items.
  *
  *
  */
  public function addItems($items, $updateStatus = true)
  {
      foreach($items as $item)
      {

        if (! isset($item['id']))
          continue;

        $value = isset($item['value']) ? $item['value'] : '';
        $itemObj = new Item();
        $itemObj->item_id = $item['id'];
        $itemObj->value = $value;

        if (isset($item['item_count']))
          $itemObj->item_count = intval($item['item_count']);


        if (isset($item['order']))
            $itemObj->list_order = $item['order'];

        $this->items[] = $itemObj;

      }
      if (count($items) > 0 && true === $updateStatus)
      {
        $this->setStatus('preparing', true, false);
        $this->setStatus('finished', false, false); // can't be finished when adding items.
      }
  }

  /** Simple Enqueue.
  * @param $items Array List of Items to add, see @AddItems
  * @return int $numItems Number of Items in this Queue [Total]
  * Note that each addition does a save of option retaining the last_item_id. Ideally add as many items that can fit in memory / time limit  constraints
  */
  public function enqueue($items = array() )
  {
      if (count($items) > 0)
        $this->addItems($items);

      $chunks = array_chunk($this->items, $this->options->enqueue_limit );
      $numitems = $this->getStatus('items');


      foreach($chunks as $chunknum => $objItems)
      {
        $numitems += $this->DataProvider->enqueue($objItems);

        $last_id = end($objItems)->item_id;
        $this->setStatus('last_item_id', $last_id); // save this, as a script termination safeguard.
      }

      $this->items = array(); // empty the item cache after inserting
      $this->setStatus('items', $numitems, false);
      $this->saveStatus();

      return $numitems;
  }

  /** Accepts array of items with a certain priority
  * Usage: $queue->withOrder($items, $order)->enqueue();  will add items with a specific list order number
  * @param $items Items Array, see AddItems
  * @param $order Int List Order number to insert.
  * @return $Queue This Queue Object
  */
  public function withOrder($items, $order)
  {
      foreach($items as $index => $item)
      {
        $item['order'] = $order;
        $items[$index] = $item;
      }
      $this->addItems($items);
      return $this;
  }

    /* Remove from Queue possible duplicates
  *  Chained function. Removed items from queue
  *  *Note* This should be used with small selections of items, not by default. Only when changes to item are needed, or to status.
  */
  public function withRemoveDuplicates()
  {

     $item_ids = array();

     foreach($this->items as $item)
     {
          $item_ids[] = $item->item_id;
     }

     $count = $this->DataProvider->removeRecords(array('items' => $item_ids));

     if ($count > 0)
        $this->setStatusCount('items', -$count );

      // Probabably not the full solution, but this can happen if deleted items were already Dequeued with status Done.
      if ($this->getStatus('items') <= 0)
      {
        $this->resetInternalCounts();
      }

     return $this;
  }

	// Remove Items directly from queue. Expand this function when required (but use dequeue if possible). For now only support for item_id.
	public function removeItems($args)
	{
									 if (isset($args['item_id']))
									$this->DataProvider->removeRecords(array('item_id' => $args['item_id'] ));

	}

  // Dequeue a record, put it on done in queue.
  public function dequeue($args = array())
  {
    // Check if anything has a timeout, do that first.
    $this->inProcessTimeout();

    if ($this->currentStatus->get('items') <= 0)
    {
      $still_here = $this->checkQueue();
       // @todo if there is queue todo, update items, and go.
      if (! $still_here)
        return array();
    }

    $newstatus = ($this->options->mode == 'wait') ? ShortQ::QSTATUS_INPROCESS : ShortQ::QSTATUS_DONE;

    $defaults = array(
      'numitems' => $this->options->numitems,
      'newstatus' => $newstatus,
      'onlypriority' => false,
    );

    $args = wp_parse_args($args, $defaults);

    if ($args['onlypriority'])
    {
       $args['priority'] = array('operator' => '<', 'value' => 10);
      // unset($args['onlypriority']);
    }

    $items = $this->DataProvider->dequeue($args);

    $itemcount = count($items);

    // @todo Ask dprovder for dequeue
    // Update item count, average ask, last_run for this process
    // When Q is empty, reask for item count for DataProvider and check if it the same, if not, update number, continue.
    if ($itemcount == 0 && $args['onlypriority'] == false)
    { // This pieces prevents stalling. If the cached count is wrong, reset it, and if empty already will go to items_left / end queue system. Oterhwise resume.
        $this->resetInternalCounts();
        $items = $this->DataProvider->dequeue($args);
        $itemcount = count($items);
    }

     $items_left =  $this->getStatus('items') - $itemcount;
     $this->setStatus('items', $items_left , false);

     if ($newstatus == ShortQ::QSTATUS_DONE)
        $this->setStatusCount('done', $itemcount, false);
     elseif($newstatus == ShortQ::QSTATUS_INPROCESS)
        $this->setStatusCount('in_process', $itemcount, false);

     $this->current_ask += $itemcount;

     //$queue['average_ask'] = $this->calcAverageAsk($queue['average_ask']);
     //$this->updateQueue($queue);
     $this->setStatus('last_run', time(), false);
     if (! isset($args['priority']))
      $this->setStatus('running', true, false);
     $this->saveStatus();

     if ($items_left == 0)
        $this->checkQueue(); // possible need to end it.

     return $items;
  }



  /* Handles in processTimeOuts
    if TimeOut is reached:
    - Reset the status back to waiting
    - Increment Retries by 1
    -
  */
  public function inProcessTimeout()
  {
     // Not waiting for anything.
     if (! $this->options->mode == 'wait')
      return;

  /*  $fields = array('status' => ShortQ::QSTATUS_WAITING, 'tries' => 'tries + 1');
    $where = array('updated' => time() - $this->options->process_timeout,
                  'status' => ShortQ::QSTATUS_INPROCESS);

    $operators = array('updated' => '<=');
*/
    $args = array('status' => ShortQ::QSTATUS_INPROCESS, 'updated' => array('value' => time() - ($this->options->process_timeout/1000), 'operator' => '<='));

    $items = $this->DataProvider->getItems($args);
    $updated = 0;

    foreach($items as $item)
    {
       $item->tries++;
			 if ($item->tries > $this->getOption('retry_limit'))
			 {
				 do_action('shortpixel/modules/wpq/item/timeout', $item);
				 $this->itemFailed($item, true); // fatal fail
			 }
			 else
			 {
			 	$updated += $this->DataProvider->itemUpdate($item, array('status' => ShortQ::QSTATUS_WAITING, 'tries' => $item->tries));
			 }
    }



    return $updated;
  /*  if ($result >= 0)
    {
      $this->resetInternalCounts();
    } */

  }

  public function itemDone(Item $item)
  {
      if ($this->options->mode == 'direct')
      {
        $this->setStatusCount('items', -1, false);
      }
      elseif ($this->options->mode == 'wait')
      {
        $this->setStatusCount('in_process',-1, false);
      }
      else // no mode, no count, no nothing, mumble.
      {
        return false;
      }

      $this->setStatusCount('done', 1, false);

      $this->saveStatus();

      $this->DataProvider->itemUpdate($item, array('status' => ShortQ::QSTATUS_DONE));
  }

  public function itemFailed(Item $item, $fatal = false)
  {
    $status = ShortQ::QSTATUS_ERROR;
    if ($fatal)
    {
        $status = ShortQ::QSTATUS_FATAL;
        $this->setStatusCount('fatal_errors', 1 );
    }
    else
      $this->setStatusCount('errors', 1 );

    $item->tries++;
    $this->DataProvider->itemUpdate($item, array('status' => $status, 'tries' => $item->tries));

  }

  public function updateItemValue(Item $item)
  {
      if (!property_exists($item, 'value'))
      {
          return false;
      }

      return $this->DataProvider->itemUpdate($item, array('value' => $item->getRaw('value') ));
  }

  public function getItem($item_id)
  {
     return $this->DataProvider->getItem($item_id);

  }

  public function hasItems()
  {
    //$status = $this->getQueueStatus();
    $items = $this->itemCount(); // $status->get('items');
    if ($items > 0)
      return true;
    else
      return false;

  }

  public function itemCount()
  {
    //  $queue = $this->getQueueStatus();
      $num = $this->getStatus('items'); //$queue->items;
      if ($num <= 0)
      {
        $this->checkQueue(); // check and update left records before checking on Dprovider.
        $num = $this->DataProvider->itemCount();
        $this->setStatus('items', $num);
      }
      return (int) $num;
  }

  public function itemSum($status = ShortQ::QSTATUS_ALL)
  {
      $row = $this->DataProvider->itemSum($status);

      if ($status === 'countbystatus')
      {
        // check if all status are there. If they are unused, they are not in result.
        $status_ar = array(ShortQ::QSTATUS_WAITING, ShortQ::QSTATUS_DONE, ShortQ::QSTATUS_INPROCESS,   ShortQ::QSTATUS_ERROR, ShortQ::QSTATUS_FATAL);

        foreach($status_ar as $stat)
        {
            if (! isset($row[$stat]))
              $row[$stat] = 0;
        }
      }

      return $row;
  }

  /** Function to call when ending a queue process. The purpose is to purge all records and statistics.
  * Those need to be collected before calling this function. Also the reason this is not done automatically.
  */
  public function resetQueue()
  {
     $this->DataProvider->removeRecords(array('all' => true));
     $this->currentStatus = new Status();
     $this->saveStatus();
  }

  public function cleanQueue()
  {
     $this->DataProvider->removeRecords(array('status' => ShortQ::QSTATUS_DONE));
     $this->DataProvider->removeRecords(array('status' => ShortQ::QSTATUS_FATAL));
     $this->resetInternalCounts();
  }

  /** @todo Users must be able to control preparing / running status controls for resume / play the queue, but possibly not the counts.  */
  public function setStatus($name, $value, $savenow = true)
  {
    $r = $this->currentStatus->set($name, $value);
    $this->currentStatus->set('last_update', time());
		$bool = true;

    if (! $r)
      $bool = false;

    if ($savenow)
      $this->saveStatus(); // for now.


    return $bool;
  }

  /** Addition of substraction for the counters */
  public function setStatusCount($name, $change, $savenow = true)
  {
      if (! $this->currentStatus->isCounter($name))
      {
        return false;
      }

      $count = $this->getStatus($name);
      return $this->setStatus($name, $count + $change, $savenow);
  }


  /** Creates a Queue Data Array to keep
  */
	/*
  private function createStatus()
  {


  } */

  /** Get the current status of this slug / queue */
/*  protected function currentStatus()
  {
		 // This can happen when uninstalling/ removing queues.
		 if (! isset($this->status['queues']) || ! isset($this->status['queues'][$this->qName]))
		 		return false;
		else
     		return $this->status['queues'][$this->qName];
  } */

  private function createQueue()
  {
			if (is_null($this->status))
			{
				$this->status = array();
				$this->status['queues']  = array();
				$this->DataProvider->install(true);
			}

			$this->currentStatus = new Status();
      $this->saveStatus();

  }

  private function loadStatus()
  {
    $this->status = get_option($this->statusName, null);

    if (false === $this->status || is_null($this->status) || (! is_object($this->status) && ! is_array($this->status) ))
		{
      $this->createQueue();
		}
    elseif (! isset($this->status['queues'][$this->qName]))
		{
      $this->createQueue();
		}
		else {
			// ONLY status this reference.
			$this->currentStatus = $this->status['queues'][$this->qName];
		}
  }

  public function getStatus($item = false)
  {
			if (is_null($this->currentStatus))
				return false;
      elseif (! $item)
        return $this->currentStatus;
      elseif (is_object($this->currentStatus))
        return $this->currentStatus->get($item);
			else {
				return false;
			}
  }

  protected function saveStatus()
  {
     $status = get_option($this->statusName);  // two different Q's can run simulanously.


		 $currentStatus =  $this->currentStatus;
		 if( $currentStatus === false && isset($status['queues'][$this->qName]) ) // Don't save status which has been removed.
		 {
			  unset($status['queues'][$this->qName]);
		 }
		 else {
			 if (false === $status)
			 {
				  $status = array();
					$status['queues'] = array();
			 }
			 $status['queues'][$this->qName]  = $currentStatus;
		 }
     $res = update_option($this->statusName, $status);
  }

  /** Check Queue. This function intends to keep internal counts consistent with dataprovider without doing queries every run .
  * Should also be able to spot the moment when there is nothing waiting, but perhaps some tasks as in process with a timeout. (stale)
  */
  private function checkQueue()
  {
    $this->resetInternalCounts(); // retrieve accurate count from dataSource.

    $tasks_done = $this->getStatus('done');
    $tasks_open = $this->getStatus('items');
    $tasks_inprocess = $this->getStatus('in_process');
    $tasks_error = $this->getStatus('errors');

    $mode = $this->options->mode;
    $update_at_end = false;

    if ($tasks_error > 0)
    {
      $update_at_end = true;
      $error_args = array(
          'numitems' => $tasks_error,
          'status' => ShortQ::QSTATUS_ERROR,
      //    'status' => ShortQ::QSTATUS_ERROR,
      );

      $error_items = $this->DataProvider->dequeue($error_args);
      $retry_array = array();
      $failed_array = array();
      foreach($error_items as $errItem)
      {
        $errid = $errItem->item_id;
        if ($errItem->tries < $this->options->retry_limit)
        {
          //$retry_array = $erritem->id;
          $this->DataProvider->itemUpdate($errItem, array('status' => ShortQ::QSTATUS_WAITING));
        }
        else {
           $this->DataProvider->itemUpdate($errItem, array('status' => ShortQ::QSTATUS_FATAL));

        }
      }
    } // tasks_errors

    if($update_at_end)
    {
      $this->resetInternalCounts(); // retrieve accurate count from dataSource.
      $tasks_open = $this->currentStatus->get('items');
      $tasks_inprocess = $this->currentStatus->get('in_process');
    }

    if ($tasks_open > 0 || $tasks_inprocess > 0)
      return true;
    else {
      $this->finishQueue();
      return false;
    }

    return null;
  }

  private function resetInternalCounts()
  {
    $dataQ = $this->DataProvider->itemCount('countbystatus');
    $num_items = $num_done = $num_in_process = $num_errors = $num_fatal = 0;

		if (is_array($dataQ))
		{
	    foreach($dataQ as $qstatus => $count)
	    {
	         switch($qstatus)
	         {
	           case ShortQ::QSTATUS_WAITING:
	             $num_items = $count;
	           break;
	           case ShortQ::QSTATUS_DONE:
	             $num_done = $count;
	           break;
	           case ShortQ::QSTATUS_INPROCESS:
	             $num_in_process = $count;
	           break;
	           case ShortQ::QSTATUS_ERROR:
	             $num_errors = $count;
	           break;
	           case ShortQ::QSTATUS_FATAL;
	              $num_fatal = $count;
	           break;
	         }
	     }
		 }

     $this->setStatus('items', $num_items, false);
     $this->setStatus('done', $num_done, false);
     $this->setStatus('in_process', $num_in_process, false);
     $this->setStatus('errors', $num_errors, false);
     $this->setStatus('fatal_errors', $num_fatal, false);

     $this->saveStatus();
     // direct, to prevent loop.

  }

  private function calcAverageAsk($avg)
  {
    // @todo this is nonsense. Need a counter for X times run.
    return ($avg / $this->current_ask);
  }

  private function finishQueue()
  {
     $this->setStatus('running', false, false);
     $this->setStatus('finished', true, false);
     $this->setStatus('last_run', time(), false);
     $this->setStatusCount('times_ran', 1, false );
     $this->saveStatus();

    //@todo find some function to remove records, maybe check if all are either DONE OR FATAL
  /*
   Not true, if done are removed on queue finish it might impede getting stats from them. Since CheckQueue invokes both finishQueue and resetInternalCounter, removing from DB can end up with a 0 count, because the boss script is aware the queue is already empty.
    if ($this->options->mode == 'direct') // only direct should be removed straight.
    {
       $args = array('status' => QSTATUS_DONE);
       $this->DataProvider->removeRecords($args);
    } */

    //@todo find some way to report back what happened recently.
  }


  /** Function to call when uninstalling the plugin. This will remove only this current queue
  */
  public function unInstall()
  {
      // Remove the Queued Items

      // @todo this will only remove the records of current queue, probably not good for uninstall
      $this->DataProvider->removeRecords(array('all' => true));

      // Unset the WP Option queue
      //unset($this->status
      unset($this->status['queues'][$this->qName]);

      if (count($this->status['queues']) == 0)
        delete_option($this->statusName);
      else
        $this->saveStatus();


      // Signal to DataProvider to check if the whole thing can be removed. Won't happen when there are still records.
      $this->DataProvider->uninstall();
  }

}
