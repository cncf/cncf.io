<?php
namespace ShortPixel\Model\AdminNotices;

class SmartcropNotice extends \ShortPixel\Model\AdminNoticeModel
{
	protected $key = 'MSG_FEATURE_SMARTCROP';

	public function __construct()
	{
		 $this->exclude_screens[] = 'settings_page_wp-shortpixel-settings';
		 parent::__construct();
	}

	protected function checkTrigger()
	{

		$settings = \wpSPIO()->settings();

		if (! $settings->verifiedKey)
		{
			return false; // no key, no integrations.
		}

		if (! $settings->useSmartcrop)
		{
			 return true;
		}

		return false;
	}

	protected function checkReset()
	{
		$settings = \wpSPIO()->settings();
		 if ($settings->useSmartcrop == true)
		 {
			  return true;
		 }
		 return false;
	}

	protected function getMessage()
	{
		$link = 'https://shortpixel.com/knowledge-base/article/182-what-is-smart-cropping';
		$link2 = 'https://shortpixel.com/blog/how-to-smart-crop-wordpress-images/#how-to-crop-wordpress-images-automatically-smart-solution';
		$link3 = esc_url(admin_url('options-general.php?page=wp-shortpixel-settings'));

		$message = sprintf(__('%s With ShortPixel you can now %ssmartly crop%s thumbnails on your website. This is especially useful for eCommerce websites %s(read more)%s. %s %s Enable the option on the %sShortPixel Settings%s page. %s', 'shortpixel-image-optimiser'),
		 '<p>' ,
		 '<a href="' . $link . '" target="_blank">', '</a>',
		 '<a href="' . $link2 . '" target="_blank">', '</a>',
		 '</p>', '<p>',
		 '<a href="' . $link3 . '" >', '</a>',
		 '</p>'
	 );
		return $message;

	}
}
