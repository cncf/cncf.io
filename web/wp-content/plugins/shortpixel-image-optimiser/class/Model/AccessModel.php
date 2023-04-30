<?php
namespace ShortPixel\Model;

use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;
use ShortPixel\Controller\QuotaController as QuotaController;

// Central place for user / access checking, roles etc.
class AccessModel
{

	private static $instance;

	private $caps;

	private $current_user_id;


	public function __construct()
	{
		 $this->setDefaultPermissions();
	}

	protected function setDefaultPermissions()
	{

			$spioCaps = array(
					'notices' =>  'activate_plugins',				// used in AdminNoticesController
					'quota-warning' => 'manage_options',    // used in AdminController
					'image_all' =>  'edit_others_posts',
					'image_user' => 'edit_post',
					'custom_all' => 'edit_others_posts',
					'actions' => array(),
			);

		 $spioCaps = apply_filters('shortpixel/init/permissions', $spioCaps);
		 // $this->cap_actions = bla.
		 $this->caps = $spioCaps;

	}

	public static function getInstance()
	{
			 if (is_null(self::$instance))
			 	 self::$instance = new AccessModel();

				return self::$instance;
	}

	/** Check for allowing a notice
	*  @param $notice Object of type notice.
	*/
	public function noticeIsAllowed($notice)
	{
			$cap = $this->getCap('notices');
			return $this->user()->has_cap($cap);
	}

	/*
	@param SPIO capability to check again the user WordPress permissions.
	*/
	public function userIsAllowed($cap)
	{
			$cap = $this->getCap($cap);
			return $this->user()->has_cap($cap);
	}

	public function imageIsEditable($mediaItem)
	{
			$type = $mediaItem->get('type');
			if ($type == 'custom' )
			{
				 return $this->user()->has_cap($this->getCap('custom_all'), $mediaItem->get('id'));
			}
		  elseif ($type == 'media') // media
			{
				if ($this->user()->has_cap($this->getCap('image_all'), $mediaItem->get('id')) || $this->user()->has_cap($this->getCap('image_user'), $mediaItem->get('id'))  )
				{
						return true;
				}
			}
			return false;
	}

	public function isFeatureAvailable($name)
	{
		 $available = true;

		 switch($name)
		 {
			  case 'avif':
					$quotaControl = QuotaController::getInstance();
					$quota = $quotaControl->getQuota();

					if (property_exists($quota, 'unlimited') && $quota->unlimited === true)
					{
						$available = false;
					}

				break;
				case 'webp':
				default:

				break;
		 }
		 return $available;
	}


	protected function user()
	{
				return wp_get_current_user();
	}

	/** Find the needed capability
	*
	* This translates a SPIO capability into the associated cap that is registered within WordPress.
	*
	* @param $cap The required Capability
	* @param $default The default value if not found. This is defaults to an admin cap to prevent access leaking.
	*/
	protected function getCap($cap, $default = 'manage_options')
	{
		  if (isset($this->caps[$cap]))
				return $this->caps[$cap];
			else
				return $default;
	}


} // CLASS
