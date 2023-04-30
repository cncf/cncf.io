<?php
namespace ShortPixel;

use ShortPixel\Helper\UiHelper as UiHelper;

/**  Proto parent class for all controllers.
*
* So far none of the controller need or implement similar enough functions for a parent to make sense. * Perhaps this will change of time, so most are extending this parent.
**/

// @todo Think how to do this better.
class Controller
{

	protected $model;
	protected $userIsAllowed = false;

	public function __construct()
	{
    $this->userIsAllowed = $this->checkUserPrivileges();
	}


	  protected function checkUserPrivileges()
	  {
	    if ((current_user_can( 'manage_options' ) || current_user_can( 'upload_files' ) || current_user_can( 'edit_posts' )))
	      return true;

	    return false;
	  }

		// helper for a helper.
		protected function formatNumber($number, $precision = 2)
		{
			 return UIHelper::formatNumber($number, $precision);
		}

} // class
