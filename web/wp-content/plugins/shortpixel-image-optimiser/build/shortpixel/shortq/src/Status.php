<?php
namespace ShortPixel\ShortQ;

/* Status Object to hold all relevant values for Queue Status like counts, times run etc.
* Provider-agnostic so doesn't mingle in saving / loading .
*/

class Status
{

  // Protecting against direct writing so at later point we can still add quality checks on setters.
  protected $items = 0; // number of items waiting.
  protected $in_process = 0; // amount of items currently in process ..
  protected $preparing = false; // flag to signal queue is being created and items are being uploaded.  Don't run.
  protected $running = false; // flag to signal the queue is currently running
  protected $finished = false;  // flag to signal nothing can move this queue anymore.
  protected $bulk_running = false; // external flag to note if a large amount is being more [optional]
  protected $done = 0; // number of items processed
  protected $errors = 0;
  protected $fatal_errors = 0;
  protected $last_run = 0; // internal
  protected $last_update = 0; // internal
  protected $times_ran = 0; // internal
  protected $average_ask = 0; // internal

  protected $last_item_id = 0;

  protected $custom_data = null; // data for the application, shortq does nothing with it.

  public function isCounter($name)
  {
     if (  gettype($this->$name) == 'integer')
      return true;
    else
      return false;
  }

  public function get($name)
  {
    if (isset($this->$name))
      return $this->$name;
    else
      return null;
  }

  public function set($name, $value)
  {
     if(property_exists($this,$name))
     {
      if ($this->isCounter($name))
        $value = intval($value);

      $this->$name = $value;
      return true;
    }
    return false;
  }


}
