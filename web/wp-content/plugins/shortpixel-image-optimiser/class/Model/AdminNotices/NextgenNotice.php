<?php
namespace ShortPixel\Model\AdminNotices;

class NextgenNotice extends \ShortPixel\Model\AdminNoticeModel
{
	protected $key = 'MSG_INTEGRATION_NGGALLERY';

	protected function checkTrigger()
	{

		$settings = \wpSPIO()->settings();

		if (! $settings->verifiedKey)
		{
			return false; // no key, no integrations.
		}

		if (\wpSPIO()->env()->has_nextgen && ! $settings->includeNextGen)
		{
			 return true;
		}

		return false; 
	}

	protected function getMessage()
	{
		$url = esc_url(admin_url('options-general.php?page=wp-shortpixel-settings&part=adv-settings'));
		$message = sprintf(__('You seem to be using NextGen Gallery. You can optimize your galleries with ShortPixel, but this is not currently enabled. To enable it, %sgo to settings and enable%s it!', 'shortpixel_image_optimiser'), '<a href="' . $url . '">', '</a>');

		return $message;

	}
}
