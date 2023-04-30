<?php
namespace ShortPixel\Controller;
use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;

use ShortPixel\Model\ResponseModel as ResponseModel;
use ShortPixel\Model\Image\ImageModel as ImageModel;


class ResponseController
{

    protected static $items = array();

		protected static $queueName; // the current queueName.
		protected static $queueType;  // the currrent queueType.
		protected static $queueMaxTries;

		protected static $screenOutput  = 1; // see consts down

		// Some form of issue keeping
		const ISSUE_BACKUP_CREATE = 10; // Issues with backups in ImageModel
		const ISSUE_BACKUP_EXISTS = 11;
		const ISSUE_OPTIMIZED_NOFILE = 12; // Issues with missing files
		const ISSUE_QUEUE_FAILED = 13;  // Issues with enqueueing items ( Queue )
		const ISSUE_FILE_NOTWRITABLE = 20; // Issues with file writing
		const ISSUE_DIRECTORY_NOTWRITABLE = 30; // Issues with directory writing


		const ISSUE_API = 50; // Issues with API - general
		const ISSUE_QUOTA = 100; // Issues with Quota.

		const OUTPUT_MEDIA = 1; // Has context of image, needs simple language
		const OUTPUT_BULK = 2;
		const OUTPUT_CLI = 3;  // Has no context, needs more information


		/** Correlates type of item with the queue being used.  Be aware that usage *outside* the queue system needs to manually set type
		* @param Object QueueObject being used.
		*
		*/
		public static function setQ($q)
		{
			 $queueType = $q->getType();

			 self::$queueName = $q->getQueueName();
			 self::$queueType = $queueType;
			 self::$queueMaxTries = $q->getShortQ()->getOption('retry_limit');

			 if (! isset(self::$items[$queueType]))
			 {
				  self::$items[self::$queueType]  = array();
			 }
		}

		public static function setOutput($output)
		{
				self::$screenOutput = $output;
		}


		public static function getResponseItem($item_id)
		{
				if (is_null(self::$queueType)) // fail-safe
				{
					$itemType = "Unknown";
				}
				else {
					$itemType = self::$queueType;
				}

				if (isset(self::$items[$itemType][$item_id]))
				{
					 $item = self::$items[$itemType][$item_id];
				}
				else {
						$item = new ResponseModel($item_id, $itemType);
				}

				return $item;
		}

		protected static function updateResponseItem($item)
		{
				$itemType = $item->item_type;
			  self::$items[$itemType][$item->item_id] = $item;
		}

		// ?
		//
		public static function addData($item_id, $name, $value = null)
		{
			if (! is_array($name) && ! is_object($name) )
			{
				$data = array($name => $value);
			}
			else {
				$data = $name;
			}

			$item_type = (array_key_exists('item_type', $data)) ? $data['item_type'] : false;
			// If no queue / queue type is set, set it if item type is passed to ResponseController.  For items outside the queue system.
			if ($item_type && is_null(self::$queueType))
			{
				 self::$queueType = $item_type;
			}

			$resp = self::getResponseItem($item_id); // responseModel

			foreach($data as $prop => $val)
			{
					if (property_exists($resp, $prop))
					{

						 $resp->$prop = $val;
					}
					else {
					}

			}
			self::updateResponseItem($resp);
		}


		public static function formatItem($item_id)
		{
				 $item = self::getResponseItem($item_id); // ResponseMOdel
				 $text = $item->message;

				 if ($item->is_error)
				 	  $text = self::formatErrorItem($item, $text);
				 else {
					 	$text = self::formatRegularItem($item, $text);
				 }

				 return $text;
		}

		private static function formatErrorItem($item, $text)
		{
			switch($item->issue_type)
			{
				 case self::ISSUE_BACKUP_CREATE:
				 		if (self::$screenOutput < self::OUTPUT_CLI) // all but cli .
				 			$text .= sprintf(__(' - file %s', 'shortpixel-image-optimiser'), $item->fileName);
				 break;
			}

			switch($item->fileStatus)
			{
				  case ImageModel::FILE_STATUS_ERROR:
							$text .= sprintf(__('( %s %d ) ', 'shortpixel-image-optimizer'), (strtolower($item->item_type) == 'media') ?  __('Attachment ID ') : __('Custom Type '), $item->item_id);
					break;
			}

			switch($item->apiStatus)
			{
				  case ApiController::STATUS_FAIL:
							$text .= sprintf(__('( %s %d ) ', 'shortpixel-image-optimizer'), (strtolower($item->item_type) == 'media') ?  __('Attachment ID ') : __('Custom Type '), $item->item_id);
					break;
			}


			if (self::$screenOutput == self::OUTPUT_CLI)
			{
				 $text = '(' . self::$queueName . ' : ' . $item->fileName . ') ' . $text . ' ';
			}

			return $text;
		}

		private static function formatRegularItem($item, $text)
		{

			  if (! $item->is_done && $item->apiStatus == ApiController::STATUS_UNCHANGED)
				{
					 	$text = sprintf(__('Optimizing - waiting for results (%d/%d)','shortpixel-image-optimiser'), $item->images_done, $item->images_total);
				}
				if (! $item->is_done && $item->apiStatus == ApiController::STATUS_ENQUEUED)
				{
				  	$text = sprintf(__('Optimizing - Item has been sent to ShortPixel (%d/%d)','shortpixel-image-optimiser'), $item->images_done, $item->images_total);
				}

				switch($item->apiStatus)
				{
					 case ApiController::STATUS_SUCCESS:
					 	$text = __('Item successfully optimized', 'shortpixel-image-optimiser');
					 break;

					 case ApiController::STATUS_FAIL:
					 case ApiController::ERR_TIMEOUT:
						 if (self::$screenOutput < self::OUTPUT_CLI)
						 {
							// 		$text .= ' ' . sprintf(__('in %s', 'shortpixel_image_optimiser'), $item->fileName);
						 }
					 break;
				}

				if (self::$screenOutput == self::OUTPUT_CLI)
				{
					 $text = '(' . self::$queueName . ' : ' . $item->fileName . ') ' . $text . ' ';
					 $text .= sprintf(__('(cycle %d)', 'shortpixel-image-optimiser'), intval($item->tries) );
				}

				return $text;
		}


		private function responseStrings()
		{

		}


} // Class
