<?php
namespace ShortPixel;
use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;

use ShortPixel\Model\AccessModel as AccessModel;


class ViewController extends Controller
{
  protected static $controllers = array();
	protected static $viewsLoaded = array();


  protected $model; // connected model to load.
  protected $template = null; // template name to include when loading.

  protected $data = array(); // data array for usage with databases data and such
  protected $postData = array(); // data coming from form posts.

  protected $mapper; // Mapper is array of View Name => Model Name. Convert between the two
  protected $is_form_submit = false; // Was the form submitted?

  protected $view; // object to use in the view.
  protected $url; // if controller is home to a page, sets the URL here. For redirects and what not.

  protected $form_action = 'sp-action';

  public static function init()
  {
    foreach (get_declared_classes() as $class) {
      if (is_subclass_of($class, 'ShortPixel\Controller') )
        self::$controllers[] = $class;
    }
  }

  public function __construct()
  {
		parent::__construct();
    $this->view = new \stdClass;
    // Basic View Construct
    $this->view->notices =  null; // Notices of class notice, for everything noticable
    $this->view->data = null;  // Data(base), to separate from regular view data

  }

  /* Check if postData has been submitted.
  * This function should always be called at any ACTION function ( load, load_$action etc ).
  */
  protected function checkPost()
  {

		if(count($_POST) === 0) // no post, nothing to check, return silent.
		{
			return true;
		}
    elseif (! isset($_POST['sp-nonce']) || ! wp_verify_nonce( sanitize_key($_POST['sp-nonce']), $this->form_action))
    {
      Log::addInfo('Check Post fails nonce check, action : ' . $this->form_action, array($_POST) );
			exit('Nonce Failed');
      return false;
    }
    elseif (isset($_POST) && count($_POST) > 0)
    {
      check_admin_referer( $this->form_action, 'sp-nonce' ); // extra check, when we are wrong here, it dies.
     // unset($_POST['sp-nonce']);
     // unset($_POST['_wp_http_referer']);
      $this->is_form_submit = true;
      $this->processPostData($_POST);

    }
		return true;
	}

	public function access()
	{
		 return AccessModel::getInstance();
	}

  /** Loads a view
  *
  * @param String View Template in view directory to load. When empty will search for class attribute
  */
  public function loadView($template = null, $unique = true)
  {
      // load either param or class template.
      $template = (is_null($template)) ? $this->template : $template;

      if (is_null($template) )
      {
        return false;
      }
      elseif (strlen(trim($template)) == 0)
			{
        return false;
			}


      $view = $this->view;
      $controller = $this;

      $template_path = \wpSPIO()->plugin_path('class/view/' . $template  . '.php');
     	if (file_exists($template_path) === false)
			{
        Log::addError("View $template could not be found in " . $template_path,
        array('class' => get_class($this)));
      }
      elseif ($unique === false || ! in_array($template, self::$viewsLoaded))
      {
        include($template_path);
				self::$viewsLoaded[] = $template;
      }


  }

  /** Accepts POST data, maps, checks missing fields, and applies sanitization to it.
  * @param array $post POST data
  */
  protected function processPostData($post)
  {

    // If there is something to map, map.
    if ($this->mapper && is_array($this->mapper) && count($this->mapper) > 0)
    {
      foreach($this->mapper as $item => $replace)
      {
        if ( isset($post[$item]))
        {
          $post[$replace] = $post[$item];
          unset($post[$item]);
        }
      }
    }

    if (is_null($this->model))
    {
      foreach($post as $name => $value )
      {
        $this->postData[sanitize_text_field($name)] = sanitize_text_field($value);
        return true;
      }
    }
    else
    {
      $model = $this->model;
      $this->postData = $model->getSanitizedData($post);
    }

    return $this->postData;

  }

  /** Sets the URL of the admin page */
  public function setControllerURL($url)
  {
    $this->url = $url;
  }



} // controller
