<?php
namespace ShortPixel\Controller;
use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;
use ShortPixel\Notices\NoticeController as Notices;
use ShortPixel\Helper\UtilHelper as UtilHelper;

use ShortPixel\ShortPixelImgToPictureWebp as ShortPixelImgToPictureWebp;

/** Handle everything that SP is doing front-wise */
class FrontController extends \ShortPixel\Controller
{
  // DeliverWebp option settings for front-end delivery of webp
  const WEBP_GLOBAL = 1;
  const WEBP_WP = 2;
  const WEBP_NOCHANGE = 3;

  public function __construct()
  {

    if (\wpSPIO()->env()->is_front) // if is front.
    {
      $this->initWebpHooks();

    }

  }

  protected function initWebpHooks()
  {
    $webp_option = \wpSPIO()->settings()->deliverWebp;

    if ( $webp_option ) {  // @tood Replace this function with the one in ENV.
        if(UtilHelper::shortPixelIsPluginActive('shortpixel-adaptive-images/short-pixel-ai.php')) {
            Notices::addWarning(__('Please deactivate the ShortPixel Image Optimizer\'s
                <a href="options-general.php?page=wp-shortpixel-settings&part=adv-settings">Deliver the next generation versions of the images in the front-end</a>
                option when the ShortPixel Adaptive Images plugin is active.','shortpixel-image-optimiser'), true);
        }
        elseif( $webp_option == self::WEBP_GLOBAL ){
            //add_action( 'wp_head', array($this, 'addPictureJs') ); // adds polyfill JS to the header || Removed. Browsers without picture support?
            add_action( 'init',  array($this, 'startOutputBuffer'), 1 ); // start output buffer to capture content
        } elseif ($webp_option == self::WEBP_WP){
            add_filter( 'the_content', array($this, 'convertImgToPictureAddWebp'), 10000 ); // priority big, so it will be executed last
            add_filter( 'the_excerpt', array($this, 'convertImgToPictureAddWebp'), 10000 );
            add_filter( 'post_thumbnail_html', array($this,'convertImgToPictureAddWebp') );
        }
    }
  }


  /* Picture generation, hooked on the_content filter
  * @param $content String The content to check and convert
  * @return String Converted content
  */
  public function convertImgToPictureAddWebp($content) {

      if(function_exists('is_amp_endpoint') && is_amp_endpoint()) {
          //for AMP pages the <picture> tag is not allowed
					// phpcs:ignore WordPress.Security.NonceVerification.Recommended  -- This is not a form
          return $content . (isset($_GET['SHORTPIXEL_DEBUG']) ? '<!-- SPDBG is AMP -->' : '');
      }
      require_once(\wpSPIO()->plugin_path('class/front/img-to-picture-webp.php'));

      $webpObj = new ShortPixelImgToPictureWebp();
      return $webpObj->convert($content);
  }



  public function startOutputBuffer() {
      $env = wpSPIO()->env();
      if ($env->is_admin || $env->is_ajaxcall)
        return;

      $call = array($this, 'convertImgToPictureAddWebp');
      ob_start( $call );
  }



} // class
