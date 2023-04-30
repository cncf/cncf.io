<?php
namespace ShortPixel\Model;
use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;


/* Model for storing cached data
*
* Use this in conjunction with cache controller, don't call it stand-alone.
*/
class CacheModel
{

  protected $name;
  protected $value;
  protected $expires = HOUR_IN_SECONDS;  // This is the expires, when saved without SetExpires! This value is not a representation of any expire time when loading something cache!
  protected $exists = false;


  public function __construct($name)
  {
     $this->name = $name;
     $this->load();
  }

  /** Set the expiration of this item. In seconds
  * @param $time Expiration in Seconds
  */
  public function setExpires($time)
  {
    $this->expires = $time;
  }

  public function setValue($value)
  {
    $this->value = $value;
  }

  public function exists()
  {
    return $this->exists;
  }

  public function getValue()
  {
      return $this->value;
  }

  public function getName()
  {
      return $this->name;
  }

  public function save()
  {
     $this->exists = set_transient($this->name, $this->value, $this->expires);
  }

  public function delete()
  {
     delete_transient($this->name);
     $this->exists = false;
  }

  protected function load()
  {
    $item = get_transient($this->name);
    if ($item !== false)
    {
      $this->value = $item;
      $this->exists = true;
    }
  }

}
