<?php
namespace ShortPixel\Controller;
use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;

use ShortPixel\Model\ApiKeyModel as ApiKeyModel;

/* Main function of this controller is to load key on runtime
This should probably in future incorporate some apikey checking functions that shouldn't be in model.
*/
class ApiKeyController extends \ShortPixel\Controller
{
    private static $instance;

    public function __construct()
    {
      $this->model = new ApiKeyModel();
      $this->load();
    }

    public static function getInstance()
    {
        if (is_null(self::$instance))
           self::$instance = new ApiKeyController();

        return self::$instance;
    }


    public function load()
    {
      $this->model->loadKey();
    }

		public function getKeyModel()
		{
			 return $this->model;
		}

    public function getKeyForDisplay()
    {
       if (! $this->model->is_hidden())
       {
          return $this->model->getKey();
       }
       else
         return false;
    }

    /** Warning: NEVER use this for displaying API keys. Only for internal functions */
    public function forceGetApiKey()
    {
      return $this->model->getKey();
    }

    public function keyIsVerified()
    {
       return $this->model->is_verified();
    }

		public function uninstall()
		{
			 $this->model->uninstall();
		}

		public static function uninstallPlugin()
		{
			 $controller = self::getInstance();
			 $controller->uninstall();
		}

}
