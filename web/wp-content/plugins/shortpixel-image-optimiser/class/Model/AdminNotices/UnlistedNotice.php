<?php
namespace ShortPixel\Model\AdminNotices;

class UnlistedNotice extends \ShortPixel\Model\AdminNoticeModel
{

	protected $key = 'MSG_UNLISTED_FOUND';

	protected function checkTrigger()
	{
		return false;
	}

// @todo This message is not properly stringF'ed.
	protected function getMessage()
	{
		$settings = \wpSPIO()->settings();

		//$unlisted = isset($settings->currentStats['foundUnlistedThumbs']) ? $settings->currentStats['foundUnlistedThumbs'] : null;
		$unlisted_id = $this->getData('id');
		$unlisted_name = $this->getData('name');
		$unlistedFiles = (is_array($this->getData('filelist'))) ? $this->getData('filelist') : array();

		$admin_url = esc_url(admin_url('options-general.php?page=wp-shortpixel-settings&part=adv-settings'));


		$message = __("<p>ShortPixel has found thumbnails that are not registered in the metadata, but are present alongside the other thumbnails. These thumbnails could be created and needed by a plugin or the theme. Let ShortPixel optimize them too?</p>", 'shortpixel-image-optimiser');
		$message .= '<p>' . __("For example, the image", 'shortpixel-image-optimiser') . '
				<a href="post.php?post=' . $unlisted_id . '&action=edit" target="_blank">
						' . $unlisted_name . '
				</a> also has these thumbnails that are not listed in the metadata: '  . (implode(', ', $unlistedFiles)) . '
				</p>';

		$message .= '<p>' . sprintf(__('You can enable optimizing %s Unlisted Images %s in the %s settings %s', 'shortpixel-image-optimiser'), '<b>', '</b>', '<a href="'. $admin_url . '">','</a>') . '</p>';

		return $message;

	}
}
