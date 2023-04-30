<?php
namespace ShortPixel\Controller;
use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;

use ShortPixel\Model\CacheModel as CacheModel;
// Future replacement for everything that needs temporary storage
// Storage agnostic -> called function should not need to know what is stored where, this is job of controller.
// Works with cache-model, which handles the data representation and storage.
//

class CacheController extends \ShortPixel\Controller
{
  protected static $cached_items = array();

  public function __construct()
  {
  }

  public function storeItem($name, $value, $expires = HOUR_IN_SECONDS)
  {
     $cache = $this->getItem($name);
     $cache->setValue($value);
     $cache->setExpires($expires);

     $cache->save();
     $cache = apply_filters('shortpixel/cache/save', $cache, $name);
     self::$cached_items[$name] = $cache;

     return $cache;
  }

  /** Store a cacheModel Object.
  * This can be used after requesting a cache item for instance.
  *  @param CacheModel $cache The Cache Model Item.
  */
  public function storeItemObject(CacheModel $cache)
  {
       self::$cached_items[$cache->getName()] = $cache;
       $cache->save();
  }

  public function getItem($name)
  {
     if (isset(self::$cached_items[$name]))
      return self::$cached_items[$name];

     $cache = new CacheModel($name);
     $cache = apply_filters('shortpixel/cache/get', $cache, $name);
     self::$cached_items[$name] = $cache;

     return $cache;
  }

  public function deleteItem($name)
  {
    $cache = $this->getItem($name);

    if ($cache->exists())
    {
      $cache->delete();
    }

  }

  public function deleteItemObject(CacheModel $cache)
  {
    $cache->delete();
  }

}
