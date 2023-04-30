<?php
namespace ShortPixel\Model\AdminNotices;

use \ShortPixel\Controller\CacheController as CacheController;
use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;


class AvifNotice extends \ShortPixel\Model\AdminNoticeModel
{
	protected $key = 'MSG_AVIF_ERROR';
	protected $errorLevel = 'error';

	protected $error_message;
	protected $error_detail;

	protected function checkTrigger()
	{
			// No Automatic Trigger.
		 return false;
	}

	public function check()
	{
		$cache = new CacheController();
		if (apply_filters('shortpixel/avifcheck/override', false) === true)
		{ return; }


		if ($cache->getItem('avif_server_check')->exists() === false)
		{
			 $url = \WPSPIO()->plugin_url('res/img/test.avif');
			 $headers = get_headers($url);
			 $is_error = true;

			 $this->addData('headers', $headers);
			 // Defaults.
			 $this->error_message = __('AVIF server test failed. Your server may not be configured to display AVIF files correctly. Serving AVIF might cause your images not to load. Check your images, disable the AVIF option, or update your web server configuration.', 'shortpixel-image-optimiser');
			 $this->error_detail = __('The request did not return valid HTTP headers. Check if the plugin is allowed to access ' . $url, 'shortpixel-image-optimiser');

			 $contentType = null;
			 $response = $headers[0];

			 if (is_array($headers) )
			 {
					foreach($headers as $index => $header)
					{
							if ( strpos(strtolower($header), 'content-type') !== false )
							{
								// This is another header that can interrupt.
								if (strpos(strtolower($header), 'x-content-type-options') === false)
								{
									$contentType = $header;
								}
							}
					}

					// http not ok, redirect etc. Shouldn't happen.
					 if (is_null($response) || strpos($response, '200') === false)
					 {
						 $this->error_detail = sprintf(__('AVIF check could not be completed because the plugin could not retrieve %s %s %s. %s Please check the security/firewall settings and try again', 'shortpixel-image-optimiser'), '<a href="' . $url . '">', $url, '</a>', '<br>');
					 }
					 elseif(is_null($contentType) || strpos($contentType, 'avif') === false)
					 {
						 $this->error_detail = sprintf(__('The required Content-type header for AVIF files was not found. Please check this with your hosting and/or CDN provider. For more details on how to fix this issue, %s see this article %s', 'shortpixel_image_optimiser'), '<a href="https://shortpixel.com/blog/avif-mime-type-delivery-apache-nginx/" target="_blank"> ', '</a>');
					 }
					 else
					 {
							$is_error = false;
					 }
			 }

			 if ($is_error)
			 {
				   if (is_null($this->notice) || $this->notice->isDismissed() === false)
					 {
						  $this->addManual();
					 }

			 }
			 else
			 {
				 		$this->reset();

						 $item = $cache->getItem('avif_server_check');
						 $item->setValue(time());
						 $item->setExpires(MONTH_IN_SECONDS);
						 $cache->storeItemObject($item );
			 }
		}

	}

	protected function getMessage()
	{
			$headers = $this->getData('headers');
			$message = '<h4>' . $this->error_message . '</h4><p>' . $this->error_detail . '</p><p class="small">' . __('Returned headers for:<br>', 'shortpixel-image-optimiser') . print_r($headers, true) .  '</p>';
			return $message;
	}
}
