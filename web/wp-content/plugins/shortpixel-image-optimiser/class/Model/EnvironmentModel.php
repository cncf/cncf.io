<?php
namespace ShortPixel\Model;
use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;

/** Loads a few environment variables handy to have nearby
*
* Notice - This is meant to be loaded via the plugin class. Easy access with wpSPIO()->getEnv().
*/
class EnvironmentModel extends \ShortPixel\Model
{
    // Server and PHP
    public $is_nginx;
    public $is_apache;
    public $is_gd_installed;
    public $is_curl_installed;
    private $disabled_functions = array();

    // MultiSite
    public $is_multisite;
    public $is_mainsite;

    // Integrations
    public $has_nextgen;

    // WordPress
    public $is_front = false;
    public $is_admin = false;
    public $is_ajaxcall = false;

    private $screen_is_set = false;
    public $is_screen_to_use = false; // where shortpixel optimizer loads
    public $is_our_screen = false; // where shortpixel hooks in more complicated functions.
		public $is_gutenberg_editor = false;
    public $is_bulk_page = false; // ShortPixel bulk screen.
    public $screen_id = false;

    // Debug flag
    public $is_debug = false;
    public $is_autoprocess = false;

    protected static $instance;


  public function __construct()
  {
     $this->setServer();
     $this->setWordPress();
     add_action('plugins_loaded', array($this, 'setIntegrations') ); // not set on construct.
     add_action('current_screen', array($this, 'setScreen') );  // Not set on construct
  }

  public static function getInstance()
  {
    if (is_null(self::$instance))
        self::$instance = new EnvironmentModel();

    /*if (! self::$instance->screen_is_set)
      self::$instance->setScreen(); */

    return self::$instance;
  }

  /** Check ENV is a specific function is allowed. Use this with functions that might be turned off on configurations
  * @param $function String  The name of the function being tested
  * Note: In future this function can be extended with other function edge cases.
  */
  public function is_function_usable($function)
  {
    if (count($this->disabled_functions) == 0)
    {
      $disabled = ini_get('disable_functions');
      $this->disabled_functions = explode(',', $disabled);
    }

    if (isset($this->disabled_functions[$function]))
      return false;

    if (function_exists($function))
      return true;

    return false;
  }

	public function checkPHPVersion($needed)
	{

		 if (version_compare(PHP_VERSION, $needed) >= 0 )
		 {
			 return true;
		 }
		 return false;
	}

	public function plugin_active($name)
	{
		 switch($name)
		 {
			  case 'wpml':
					$plugin = 'sitepress-multilingual-cms/sitepress.php';
				break;
				case 'polylang':
					$plugin = 'polylang/polylang.php';
				break;
				case 'spai':
					$plugin = 'shortpixel-adaptive-images/short-pixel-ai.php';
				break;
				case 's3-offload':
				  $plugin = 'amazon-s3-and-cloudfront/wordpress-s3.php';
				break;
				default:
				 	$plugin = 'none';
				break;
		 }

		 if (!function_exists('is_plugin_active')) {
    	include_once(ABSPATH . 'wp-admin/includes/plugin.php');
		 }

		 return \is_plugin_active($plugin);
	}

  //https://www.php.net/manual/en/function.sys-getloadavg.php
  public function getSystemLoad()
  {
      $load = sys_getloadavg();

  }

  /* https://github.com/WordPress/WordPress/blob/master/wp-includes/class-wp-image-editor-imagick.php */
  public function hasImagick()
  {
    $editor = wp_get_image_editor(\wpSPIO()->plugin_path('res/img/test.jpg'));
    $className = get_class($editor);

    if ($className == 'WP_Image_Editor_Imagick')
      return true;
    else
      return false;
  }

  private function setServer()
  {
    $this->is_nginx = ! empty($_SERVER["SERVER_SOFTWARE"]) && strpos(strtolower(wp_unslash($_SERVER["SERVER_SOFTWARE"])), 'nginx') !== false ? true : false;
    $this->is_apache = ! empty($_SERVER["SERVER_SOFTWARE"]) && strpos(strtolower(wp_unslash($_SERVER["SERVER_SOFTWARE"])), 'apache') !== false ? true : false;
    $this->is_gd_installed = function_exists('imagecreatefrompng') && function_exists('imagejpeg');
    $this->is_curl_installed = function_exists('curl_init');
  }


  private function setWordPress()
  {
    $this->is_multisite = (function_exists("is_multisite") && is_multisite()) ? true : false;
    $this->is_mainsite = is_main_site();

    $this->determineFrontBack();


    if (wp_doing_ajax())
    {
      $this->is_ajaxcall = true;
    }

    $this->is_debug = Log::debugIsActive();

    if (\wpSPIO()->settings()->autoMediaLibrary == 1)
      $this->is_autoprocess = true;

  }

  // check if this request is front or back.
  protected function determineFrontBack()
  {
    if ( is_admin() || wp_doing_ajax() )
      $this->is_admin = true;
    else
      $this->is_front = true;

  }

  public function setScreen($screen)
  {
    // WordPress pages where we'll be active on.
    // https://codex.wordpress.org/Plugin_API/Admin_Screen_Reference
    $use_screens = array(
        'edit-post_tag', // edit tags
        'upload', // media library
        'attachment', // edit media
        'post', // post screen
        'page', // page editor
        'edit-post', // edit post
        'new-post',  // new post
        'edit-page', // all pages
    );
    $use_screens = apply_filters('shortpixel/init/optimize_on_screens', $use_screens);

    $this->screen_id = $screen->id;
    if(is_array($use_screens) && in_array($screen->id, $use_screens)) {
          $this->is_screen_to_use = true;
    }

    // Our pages.
    $pages = \wpSPIO()->get_admin_pages();
    // the main WP pages where SPIO hooks a lot of functions into, our operating area.
    $wp_pages = array('upload', 'attachment');
    $pages = array_merge($pages, $wp_pages);

    /* pages can be null in certain cases i.e. plugin activation.
    * treat those cases as improper screen set.
    */
    if (is_null($pages))
    {
        return false;
    }

    if ( in_array($screen->id, $pages))
    {
       $this->is_screen_to_use = true;
       $this->is_our_screen = true;

       if ($screen->id == 'media_page_wp-short-pixel-bulk')
        $this->is_bulk_page = true;
    }
		elseif (is_object($screen) && method_exists( $screen, 'is_block_editor' ) && $screen->is_block_editor() ) {
			  $this->is_screen_to_use = true;
				$this->is_gutenberg_editor = true;
	  }

    $this->screen_is_set = true;
  }

  public function setIntegrations()
  {
    $ng = \ShortPixel\NextGenController::getInstance();
    $this->has_nextgen = $ng->has_nextgen();
  }

  //set default move as "list". only set once, it won't try to set the default mode again.
  public function setDefaultViewModeList()
  {
      $settings = \wpSPIO()->settings();
      if( $settings->mediaLibraryViewMode == false)
      {
          $settings->mediaLibraryViewMode = 1;
          $currentUserID = false;
          if ( function_exists('wp_get_current_user') ) {
              $current_user = wp_get_current_user();
              $currentUserID = $current_user->ID;
              update_user_meta($currentUserID, "wp_media_library_mode", "list");
          }
      }

  }

  public function getRelativePluginSlug()
  {
      $dir = SHORTPIXEL_PLUGIN_DIR;
      $file = SHORTPIXEL_PLUGIN_FILE;

      $fs = \wpSPIO()->filesystem();

      $plugins_dir = $fs->getDirectory($dir)->getParent();

      $slug = str_replace($plugins_dir->getPath(), '', $file);

      return $slug;
  }

  public function useDoubleWebpExtension()
  {
      if (defined('SHORTPIXEL_USE_DOUBLE_WEBP_EXTENSION') && SHORTPIXEL_USE_DOUBLE_WEBP_EXTENSION)
        return true;

      return false;
  }

	public function useDoubleAvifExtension()
  {
      if (defined('SHORTPIXEL_USE_DOUBLE_AVIF_EXTENSION') && SHORTPIXEL_USE_DOUBLE_AVIF_EXTENSION)
        return true;

      return false;
  }

	public function useTrustedMode()
	{
		 if (defined('SHORTPIXEL_TRUSTED_MODE') && true === SHORTPIXEL_TRUSTED_MODE)
		 {
			 	return true;
		 }
		 return false;
	}



}
