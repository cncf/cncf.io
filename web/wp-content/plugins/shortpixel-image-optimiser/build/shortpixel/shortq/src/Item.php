<?php
namespace ShortPixel\ShortQ;

/* The Queue Item
*
* The items must correspond 1-on-1 with Storage Items invoked
*/
class Item
{

  protected $id;
  protected $created; // as a timestamp
  protected $updated; // as a timestamp
  protected $item_id; // the item id of the processor.
  protected $value; // something of value to the processor
  protected $item_count = 1; // Amount of items this record represents.
  protected $json_was_array;
  protected $status = 0;
  protected $list_order;
  protected $tries = 0;

  public function __construct()
  {

  }

  // Without magic conversion. Used for methods such as database insertion of value
  public function getRaw($name)
  {
     if (isset($this->$name))
      return $this->$name;

    return null;
  }

  public function __get($name)
  {
    $value= null;

     switch($name)
     {
       case 'value':
       case 'json_was_array':
          if ($this->isJson($this->value))
          {
            $jsonObj = json_decode($this->value);
            $this->json_was_array = $jsonObj->was_array;

            if ($name == 'value')
            {
              if ($this->json_was_array)  // since it's being set after decode, redo this.
              {   $json_array = json_decode($this->value, $this->json_was_array);
                  $value = $json_array['value'];
              }
              else
              {
                $value = $jsonObj->value;
              }
            }
            elseif($name = 'json_was_array') // this is an internal item that normally shouldn't be requested.
              $value = $jsonObj->was_array;
          }
          elseif (isset($this->$name))
              $value = $this->$name;
       break;
       default:
       {
         if (isset($this->$name))
            $value = $this->$name;
       }
     }

    return $value;
  }

  public function __set($name, $value)
  {
      switch($name)
      {
         case 'created':
         case 'updated':
            if (! is_numeric($value))
             {
               $dateObj = \DateTime::createFromFormat('Y-m-d H:i:s', $value);
               $value = $dateObj->format('U');
             }
            $this->$name = $value;
         break;
         case 'value':
            if (is_array($value) || is_object($value))
            {
              $this->json_was_array = (is_array($value)) ? true : false;
              $jsonObj = new \stdClass;
              $jsonObj->was_array = $this->json_was_array;
              $jsonObj->value = $value;

              $value = json_encode($jsonObj, JSON_UNESCAPED_UNICODE);
            }

            $this->$name = $value;
         break;
         default:
            if (property_exists($this, $name))
              $this->$name = $value;
         break;
      }

      return $this;
  }

  private function isJson($value)
  {
    if (is_int($value) || is_numeric($value)) // solo-integer is not a json but will validate.
      return false;

    json_decode($value);
    return (json_last_error() == JSON_ERROR_NONE);
  }

}
