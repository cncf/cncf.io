<?php
namespace ShortPixel;
use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;
use ShortPixel\Notices\NoticeController as Notices;

class CustomSuffixes
{
  public function __construct()
  {
      add_action('admin_init', array($this, 'addConstants'));
  }

  // This adds constants for mentioned plugins checking for specific suffixes on addUnlistedImages.
	// @integration Envira Gallery
	// @integration Soliloquy
  public function addConstants()
  {
    //if( !defined('SHORTPIXEL_CUSTOM_THUMB_SUFFIXES')) {
        if(\is_plugin_active('envira-gallery/envira-gallery.php') ||
					 \is_plugin_active('soliloquy-lite/soliloquy-lite.php') ||
					 \is_plugin_active('soliloquy/soliloquy.php') ||
					 \is_plugin_active('envira-gallery-lite/envira-gallery-lite.php')
			 )
		{

						add_filter('shortpixel/image/unlisted_suffixes', array($this, 'envira_suffixes'));
            //define('SHORTPIXEL_CUSTOM_THUMB_SUFFIXES', '_c,_tl,_tr,_br,_bl');
    //    }

		// not in use?
    //    elseif(defined('SHORTPIXEL_CUSTOM_THUMB_SUFFIX')) {
    //        define('SHORTPIXEL_CUSTOM_THUMB_SUFFIXES', SHORTPIXEL_CUSTOM_THUMB_SUFFIX);
    //    }
    }

  }

	public function envira_suffixes($suffixes)
	{

		 $envira_suffixes = array('_c','_tl','_tr','_br','_bl', '-\d+x\d+');
		 $suffixes = array_merge($suffixes, $envira_suffixes);

		 return $suffixes;
	}



} // class
$c = new CustomSuffixes();
