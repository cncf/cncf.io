<?php
namespace ShortPixel\Replacer\Modules;

class Elementor
{
    private static $instance;

    protected $queryKey = 'elementor';

    public static function getInstance()
    {
        if (is_null(self::$instance))
          self::$instance = new Elementor();

        return self::$instance;
    }

    public function __construct()
    {
      if ($this->elementor_is_active())   // elementor is active
      {
        add_filter('shortpixel/replacer/custom_replace_query', array($this, 'addElementor'), 10, 4); // custom query for elementor \ // problem
				// @todo Fix this for SPIO
        //add_action('enable-media-replace-upload-done', array($this, 'removeCache') );
      }
    }

    public function addElementor($items, $base_url, $search_urls, $replace_urls)
    {
      $base_url = $this->addSlash($base_url);
      $el_search_urls = $search_urls; //array_map(array($this, 'addslash'), $search_urls);
      $el_replace_urls = $replace_urls; //array_map(array($this, 'addslash'), $replace_urls);
      $items[$this->queryKey] = array('base_url' => $base_url, 'search_urls' => $el_search_urls, 'replace_urls' => $el_replace_urls);
      return $items;
    }

    public function addSlash($value)
    {
        global $wpdb;
        $value= ltrim($value, '/'); // for some reason the left / isn't picked up by Mysql.
        $value= str_replace('/', '\/', $value);
        $value =  $wpdb->esc_like(($value)); //(wp_slash) / str_replace('/', '\/', $value);

        return $value;
    }

    protected function elementor_is_active()
    {
       $bool = false;

       if (defined('ELEMENTOR_VERSION'))
          $bool = true;

        return apply_filters('emr/externals/elementor_is_active', $bool); // manual override
    }

    public function removeCache()
    {
       \Elementor\Plugin::$instance->files_manager->clear_cache();
    }
}
