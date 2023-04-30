<?php
namespace ShortPixel\Model\AdminNotices;
use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;


class ListviewNotice extends \ShortPixel\Model\AdminNoticeModel
{
	protected $key = 'MSG_LISTVIEW_ACTIVE';

	public function __construct()
	{
		 $this->include_screens[] = 'upload';
		 parent::__construct();
	}

	/*public function load()
	{
		 parent::load();
		 // Reset this notice even when dismissed when condition changed.
		  if ($this->isDismissed() && $this->checkReset() === true)
			{
				$this->reset();
			}
	} */

	protected function checkTrigger()
	{
		// Don't check for this, when not on this screen.
		$screen_id = \wpSPIO()->env()->screen_id;
		if ($screen_id !== 'upload')
		{
			return false;
		}

		if (! function_exists('wp_get_current_user') )
		{
			return false;

		}

			$viewMode = get_user_option('media_library_mode', get_current_user_id() );

			if ($viewMode === "" || strlen($viewMode) == 0)
			{
					// If nothing is set, set it for them.
						update_user_option( get_current_user_id(), 'media_library_mode', 'list' );
					return false;
			}
			elseif ($viewMode !== "list")
			{
					return true;
			}
			else
			{
				if (is_object($this->getNoticeObj()))
					$this->reset();
			}

			return false;
	}

	protected function checkReset()
	{
		if (! function_exists('wp_get_current_user') )
		{
			return false;

		}

			$current_user = wp_get_current_user();
			$currentUserID = $current_user->ID;
			$viewMode = get_user_meta($currentUserID, "wp_media_library_mode", true);

			if ($viewMode == 'list')
			{
				 return true;
			}

			return false;
	}


	protected function getMessage()
	{

		$message = sprintf(__('You can see the actions and data of ShortPixel Image Optimiser only through the list view. Switch to the list view to use the plugin via the media library.  Click to%s switch to the list view%s now. ', 'shortpixel-image-optimiser'), '<a href="' . admin_url('upload.php?mode=list') . '">','</a>');

		return $message;

	}
}
