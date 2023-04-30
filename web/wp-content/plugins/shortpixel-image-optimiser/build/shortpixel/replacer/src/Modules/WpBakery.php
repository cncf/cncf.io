<?php
namespace ShortPixel\Replacer\Modules;
// Note! This class doubles as integration for both Visual Composer *and* WP Bakery. They both need URLENCODE.
class WpBakery
{
    private static $instance;

    protected $queryKey = 'wpbakery';

    public static function getInstance()
    {
        if (is_null(self::$instance))
          self::$instance = new WpBakery();

        return self::$instance;
    }

    public function __construct()
    {
      if ($this->bakery_is_active())   // elementor is active
      {
        add_filter('shortpixel/replacer/custom_replace_query', array($this, 'addURLEncoded'), 10, 4); // custom query for elementor \ // problem
      }
    }

    public function addUrlEncoded($items, $base_url, $search_urls, $replace_urls)
    {
      $base_url = $this->addEncode($base_url);
      $el_search_urls = array_map(array($this, 'addEncode'), $search_urls);
      $el_replace_urls = array_map(array($this, 'addEncode'), $replace_urls);
      $items[$this->queryKey] = array('base_url' => $base_url, 'search_urls' => $el_search_urls, 'replace_urls' => $el_replace_urls);
      return $items;
    }

    public function addEncode($value)
    {
        return urlencode($value);
    }

    protected function bakery_is_active()
    {
       $bool = false;

       // did_action -> wpbakery , VCV_version -> detect Visual Composer
       if (did_action('vc_plugins_loaded') || defined('VCV_VERSION'))
          $bool = true;

        return apply_filters('emr/externals/urlencode_is_active', $bool); // manual override
    }
}
