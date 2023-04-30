<?php
namespace ShortPixel\Replacer\Modules;
use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;

// Integration to reset indexes of Yoast  (used for Og:image) when something is converted.
class YoastSeo
{

	private $yoastTable;
	private static $instance;

	public static function getInstance()
	{
			if (is_null(self::$instance))
				self::$instance = new YoastSeo();

			return self::$instance;
	}

	public function __construct()
	{
		if (true === $this->yoast_is_active())   // elementor is active
		{
			 global $wpdb;
			 $this->yoastTable = $wpdb->prefix . 'yoast_indexable';

			 add_action('shortpixel/replacer/replace_urls', array($this, 'removeIndexes'),10,2);
		}
	}

	public function removeIndexes($search_urls, $replace_urls)
	{
		 global $wpdb;

			$sql = 'DELETE FROM  ' . $this->yoastTable . ' WHERE ';
			$prepare = array();

			$base = isset($search_urls['base']) ? $search_urls['base'] : null;
			$file = isset($search_urls['file']) ? $search_urls['file'] : null;

			if (! is_null($base))
			{
						$querySQL = $sql . ' twitter_image like %s or open_graph_image like %s ';
						$querySQL = $wpdb->prepare($querySQL, '%' . $base . '%', '%' . $base . '%');

						$wpdb->query($querySQL);
			}

			if (! is_null($file))
			{
						$querySQL = $sql . ' twitter_image like %s or open_graph_image like %s ';
						$querySQL = $wpdb->prepare($querySQL, '%' . $file . '%', '%' . $file . '%');

						$wpdb->query($querySQL);
			}

	}

	protected function yoast_is_active()
	{
		 if (defined('WPSEO_VERSION'))
		 {
			  return true;
		 }
		 return false;
	}




}
