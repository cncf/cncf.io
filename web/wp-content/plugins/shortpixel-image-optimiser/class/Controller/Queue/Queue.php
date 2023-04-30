<?php
namespace ShortPixel\Controller\Queue;

use ShortPixel\Model\Image\ImageModel as ImageModel;
use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;
use ShortPixel\Controller\CacheController as CacheController;
use ShortPixel\Controller\ResponseController as ResponseController;
use ShortPixel\Model\Converter\Converter as Converter;

use ShortPixel\Helper\UiHelper as UiHelper;

use ShortPixel\ShortQ\ShortQ as ShortQ;

abstract class Queue
{
    protected $q;
//    protected static $instance;
    protected static $results;

    const PLUGIN_SLUG = 'SPIO';

    // Result status for Run function
    const RESULT_ITEMS = 1;
    const RESULT_PREPARING = 2;
    const RESULT_PREPARING_DONE = 3;
    const RESULT_EMPTY = 4;
    const RESULT_QUEUE_EMPTY = 10;
    const RESULT_RECOUNT = 11;
    const RESULT_ERROR = -1;
    const RESULT_UNKNOWN = -10;


    abstract protected function prepare();
    abstract public function getType();

    public function createNewBulk()
    {
				$this->resetQueue();

        $this->q->setStatus('preparing', true, false);
				$this->q->setStatus('finished', false, false);
        $this->q->setStatus('bulk_running', true, true);

        $cache = new CacheController();
        $cache->deleteItem($this->cacheName);
    }

    public function startBulk()
    {
        $this->q->setStatus('preparing', false, false);
        $this->q->setStatus('running', true, true);
    }

    public function cleanQueue()
    {
       $this->q->cleanQueue();
    }

		public function resetQueue()
		{
			$this->q->resetQueue();
		}

    // gateway to set custom options for queue.
    public function setOptions($options)
    {
        return $this->q->setOptions($options);
    }

    /** Enqueues a single items into the urgent queue list
    *   - Should not be used for bulk images
    * @param ImageModel $mediaItem An ImageModel (CustomImageModel or MediaLibraryModel) object
    * @return mixed
    */
    public function addSingleItem(ImageModel $imageModel)
    {
       $qItem = $this->imageModelToQueue($imageModel);
       $counts = $qItem->counts;

			 $media_id = $imageModel->get('id');
			 // Check if this is a duplicate existing.
			 if ($imageModel->getParent() !== false)
			 {
				  $media_id = $imageModel->getParent();
			 }

			 $result = new \stdClass;

       $item = array('id' => $media_id, 'value' => $qItem, 'item_count' => $counts->creditCount);
       $this->q->addItems(array($item), false);
       $numitems = $this->q->withRemoveDuplicates()->enqueue(); // enqueue returns numitems

      // $this->q->setStatus('preparing', $preparing, true); // add single should not influence preparing status.
       $result = $this->getQStatus($result, $numitems);
       $result->numitems = $numitems;

       do_action('shortpixel_start_image_optimisation', $imageModel->get('id'), $imageModel);
       return $result;
    }

		/** Drop Item if it needs dropping. This can be needed in case of image alteration and it's in the queue */
		public function dropItem($item_id)
		{
				$this->q->removeItems(array(
						'item_id' => $item_id,
				));

		}


    public function run()
    {
       $result = new \stdClass();
       $result->qstatus = self::RESULT_UNKNOWN;
       $result->items = null;

       if ( $this->getStatus('preparing') === true) // When preparing a queue for bulk
       {
            $prepared = $this->prepare();
            $result->qstatus = self::RESULT_PREPARING;
            $result->items = $prepared['items']; // number of items.
            $result->images = $prepared['images'];
            if ($prepared['items'] == 0)
            {

               Log::addDebug( $this->queueName . ' Queue, prepared came back as zero ', array($prepared, $result->items));
               if ($prepared['results'] == 0) /// This means no results, empty query.
               {
                $result->qstatus = self::RESULT_PREPARING_DONE;
               }

            }
       }
       elseif ($this->getStatus('bulk_running') == true) // this is a bulk queue, don't start automatically.
       {
          if ($this->getStatus('running') == true)
          {
              $items = $this->deQueue();
          }
          elseif ($this->getStatus('preparing') == false && $this->getStatus('finished') == false)
          {
              $result->qstatus = self::RESULT_PREPARING_DONE;
          }
          elseif ($this->getStatus('finished') == true)
          {
              $result->qstatus = self::RESULT_QUEUE_EMPTY;
          }
       }
       else // regular queue can run whenever.
       {
            $items = $this->deQueue();
       }

       if (isset($items)) // did a dequeue.
       {
          $result = $this->getQStatus($result, count($items));
          $result->items = $items;

       }

       return $result;
    }


    protected function prepareItems($items)
    {
        $return = array('items' => 0, 'images' => 0, 'results' => 0);
				$settings = \wpSPIO()->settings();

          if (count($items) == 0)
          {
              $this->q->setStatus('preparing', false);
              Log::addDebug('PrepareItems: Items can back as empty array. Nothing to prepare');
              return $return;
          }

          $fs = \wpSPIO()->filesystem();

          $queue = array();
          $imageCount = $webpCount = $avifCount = $baseCount = 0;

          $operation = $this->getCustomDataItem('customOperation'); // false or value (or null)

					if (is_null($operation))
						$operation = false;


          // maybe while on the whole function, until certain time has elapsed?
          foreach($items as $item_id)
          {
							// Migrate shouldn't load image object at all since that would trigger the conversion.
							  if ($operation == 'migrate' || $operation == 'removeLegacy')
								{
                    $qObject = new \stdClass;  //$this->imageModelToQueue($mediaItem);
                    $qObject->action = $operation;
                    $queue[] = array('id' => $item_id, 'value' => $qObject, 'item_count' => 1);

										continue;
								}

								$mediaItem = $fs->getImage($item_id, $this->getType() );

            //checking if the $mediaItem actually exists
            if ( $mediaItem ) {
                if ($mediaItem->isProcessable() && $mediaItem->isOptimizePrevented() == false && ! $operation) // Checking will be done when processing queue.
                {

										// If PDF and not enabled, not processing.
										if ($mediaItem->getExtension() == 'pdf' && ! $settings->optimizePdfs)
										{
											continue;
										}

										if ($this->isDuplicateActive($mediaItem, $queue))
										{
											 continue;
										}

                    $qObject = $this->imageModelToQueue($mediaItem);

                    $counts = $qObject->counts;

									 $media_id = $mediaItem->get('id');
									 if ($mediaItem->getParent() !== false)
						 			 {
						 				  $media_id = $mediaItem->getParent();
						 			 }

                    $queue[] = array('id' => $media_id, 'value' => $qObject, 'item_count' => $counts->creditCount);

                    $imageCount += $counts->creditCount;
                    $webpCount += $counts->webpCount;
                    $avifCount += $counts->avifCount;
										$baseCount += $counts->baseCount; // base images (all minus webp/avif)

                    do_action('shortpixel_start_image_optimisation', $media_id, $mediaItem);

                }
                else
                {
                   if($operation !== false)
                   {
                      if ($operation == 'bulk-restore')
                      {
                          if ($mediaItem->isRestorable())
                          {
                            $qObject = new \stdClass; //$this->imageModelToQueue($mediaItem);
                            $qObject->action = 'restore';
                            $queue[] = array('id' => $mediaItem->get('id'), 'value' => $qObject);
                          }
                      }
                   }
                   elseif($mediaItem->isOptimized())
                   {
                   }
									 else
									 {
												$response = array(
							 					 	'is_error' => true,
							 						'item_type' => ResponseController::ISSUE_QUEUE_FAILED,
							 						'message ' => ' Item failed: ' . $mediaItem->getProcessableReason(),
							 				 );
							 				  ResponseController::addData($item_id, $response);
									 }

                }
			  }
			  else
			  {

				 $response = array(
					 	'is_error' => true,
						'item_type' => ResponseController::ISSUE_QUEUE_FAILED,
						'message ' => ' Enqueing of item failed : invalid post content or post type',
				 );
				 	ResponseController::addData($item_id, $response);
				  Log::addWarn('The item with id ' . $item_id . ' cannot be processed because it is either corrupted or an invalid post type');
			  }
          }


          $this->q->additems($queue);
          $numitems = $this->q->enqueue();

          $customData = $this->getStatus('custom_data');

          $customData->webpCount += $webpCount;
          $customData->avifCount += $avifCount;
					$customData->baseCount += $baseCount;

          $this->q->setStatus('custom_data', $customData, false);

          // mediaItem should be last_item_id, save this one.
          $this->q->setStatus('last_item_id', $item_id); // enum status to prevent a hang when no items are enqueued, thus last_item_id is not raised. save to DB.

          $qCount = count($queue);

          $return['items'] = $qCount;
          $return['images'] = $imageCount;
					/** NOTE! The count items is the amount of items queried and checked. It might be they never enqueued, just that the check process is running.
					*/
          $return['results'] = count($items); // This is the return of the query. Preparing should not be 'done' before the query ends, but it can return 0 on the qcount if all results are already optimized.

          return $return; // only return real amount.
    }

    // Used by Optimizecontroller on handlesuccess.
    public function getQueueName()
    {
          return $this->queueName;
    }


    public function getQStatus($result, $numitems)
    {
      if ($numitems == 0)
      {
        if ($this->getStatus('items') == 0 && $this->getStatus('errors') == 0 && $this->getStatus('in_process') == 0) // no items, nothing waiting in retry. Signal finished.
        {
          $result->qstatus = self::RESULT_QUEUE_EMPTY;
        }
        else
        {
          $result->qstatus = self::RESULT_EMPTY;
        }
      }
      else
      {
        $result->qstatus = self::RESULT_ITEMS;
      }

      return $result;
    }


    public function getStats()
    {
      $stats = new \stdClass; // For frontend reporting back.
      $stats->is_preparing = (bool) $this->getStatus('preparing');
      $stats->is_running = (bool) $this->getStatus('running');
      $stats->is_finished = (bool) $this->getStatus('finished');
      $stats->in_queue = (int) $this->getStatus('items');
      $stats->in_process = (int) $this->getStatus('in_process');
			$stats->awaiting = $stats->in_queue + $stats->in_process; // calculation used for WP-CLI.

      $stats->errors = (int) $this->getStatus('errors');
      $stats->fatal_errors = (int) $this->getStatus('fatal_errors');
      $stats->done = (int) $this->getStatus('done');
      $stats->bulk_running = (bool) $this->getStatus('bulk_running');

			$customData = $this->getStatus('custom_data');

			if ($this->isCustomOperation())
			{
					  $stats->customOperation = $this->getCustomDataItem('customOperation');
			}

      $stats->total = $stats->in_queue + $stats->fatal_errors + $stats->errors + $stats->done + $stats->in_process;
      if ($stats->total > 0)
			{
        $stats->percentage_done = round((100 / $stats->total) * ($stats->done + $stats->fatal_errors), 0, PHP_ROUND_HALF_DOWN);
			}
			else
        $stats->percentage_done = 100; // no items means all done.


      if (! $stats->is_running)
      {
        $stats->images = $this->countQueue();
      }

      return $stats;
    }


    /** Recounts the ItemSum for the Queue
    *
    * Note that this is not the same number as preparing adds to the cache, which counts across the installation how much images were already optimized. However, we don't want to stop and reset cache just for a few lost numbers so we should accept a flawed outcome here perhaps.
    */
    protected function countQueue()
    {
        $recount = $this->q->itemSum('countbystatus');
        $customData = $this->getStatus('custom_data');
        $count = (object) [
            'images' => $recount[ShortQ::QSTATUS_WAITING],
            'images_done' => $recount[ShortQ::QSTATUS_DONE],
            'images_inprocess' => $recount[ShortQ::QSTATUS_INPROCESS],
        ];

        $count->images_webp = 0;
        $count->images_avif = 0;
        if (is_object($customData))
        {
          $count->images_webp = (int) $customData->webpCount;
          $count->images_avif = (int) $customData->avifCount;
					$count->images_basecount = (int) $customData->baseCount;
        }

        return $count;
    }


    protected function getStatus($name = false)
    {
        if ($name == 'items')
          return $this->q->itemCount(); // This one also recounts once queue returns 0
        elseif ($name == 'custom_data')
        {
            $customData = $this->q->getStatus('custom_data');
            if (! is_object($customData))
            {
               $customData = $this->createCustomData();
            }
            return $customData;
        }
        return $this->q->getStatus($name);
    }

    public function setCustomBulk($type = null, $options = array() )
    {
        if (is_null($type))
          return false;

        $customData = $this->getStatus('custom_data');
        $customData->customOperation = $type;
        if (is_array($options) && count($options) > 0)
          $customData->queueOptions = $options;

        $this->getShortQ()->setStatus('custom_data', $customData);
    }

		// Return if this queue has any special operation outside of normal optimizing.
		// Use to give the go processing when out of credits (ie)
		public function isCustomOperation()
		{
			if ($this->getCustomDataItem('customOperation'))
			{
				return true;
			}
			return false;
		}

    public function getCustomDataItem($name)
    {
        $customData = $this->getStatus('custom_data');
        if (is_object($customData) && property_exists($customData, $name))
        {
           return $customData->$name;
        }
        return false;
    }

    protected function deQueue()
    {
       $items = $this->q->deQueue(); // Items, can be multiple different according to throttle.

       $items = array_map(array($this, 'queueToMediaItem'), $items);
       return $items;
    }

    protected function queueToMediaItem($qItem)
    {
        $item = new \stdClass;
        $item = $qItem->value;
        $item->_queueItem = $qItem;

        $item->item_id = $qItem->item_id;
        $item->tries = $qItem->tries;

				if (property_exists($item, 'files'))
				{ // This must be array & shite.
					$item->files = json_decode(json_encode($item->files), true);
				}

        return $item;
    }

    protected function mediaItemToQueue($item)
    {
        $mediaItem = clone $item;  // clone here, not to loose referenced data.
        unset($mediaItem->item_id);
        unset($mediaItem->tries);

        $qItem = $mediaItem->_queueItem;

        unset($mediaItem->_queueItem);

        $qItem->value = $mediaItem;
        return $qItem;
    }

    // This is a general implementation - This should be done only once!
    // The 'avif / webp left imp. is commented out since both API / and OptimizeController don't play well with this.
    protected function imageModelToQueue(ImageModel $imageModel)
    {
      //  $settings = \wpSPIO()->settings();
        $item = new \stdClass;
        $item->compressionType = \wpSPIO()->settings()->compressionType;

//        $urls = $imageModel->getOptimizeUrls();
				$data = $imageModel->getOptimizeData();
				$urls = $data['urls'];
				$params = $data['params'];

		//		$imagePreview = UIHelper::findBestPreview($imageModel, 800, true);
		//		$imagePreviewURL = (is_object($imagePreview)) ? $imagePreview->getURL() : false;

				list($u, $baseCount) = $imageModel->getCountOptimizeData('thumbnails');
				list($u, $webpCount) = $imageModel->getCountOptimizeData('webp');
				list($u, $avifCount) = $imageModel->getCountOptimizeData('avif');

        $counts = new \stdClass;
        $counts->creditCount = $baseCount + $webpCount + $avifCount;  // count the used credits for this item.
				$counts->baseCount = $baseCount; // count the base images.
        $counts->avifCount = $avifCount;
        $counts->webpCount = $webpCount;

			 	$removeKeys = array('image', 'webp', 'avif'); // keys not native to API / need to be removed.

				// Is UI info, not for processing.
				if (isset($data['params']['paths']))
				{
					 unset($data['params']['paths']);
				}

				foreach($data['params'] as $sizeName => $param)
				{
						$plus = false;
						$convertTo = array();
						if ($param['image'] === true)
						{
							 $plus = true;
						}
					  if ($param['webp'] === true)
						{
							 $convertTo[] = ($plus === true) ? '+webp' : 'webp';
						}
						if ($param['avif'] === true)
						{
							$convertTo[] = ($plus === true) ? '+avif' : 'avif';
						}

						foreach($removeKeys as $key)
						{
							 if (isset($param[$key]))
							 {
								  unset($data['params'][$sizeName][$key]);
							 }
						}

						if (count($convertTo) > 0)
						{
							$convertTo = implode('|', $convertTo);
							$data['params'][$sizeName]['convertto'] = $convertTo;
						}
				}

				//$converter =
				// @todo Adapt this.
				$converter = Converter::getConverter($imageModel, true);

				if ($baseCount > 0 && is_object($converter) && $converter->isConvertable())
				{
		        if ($converter->isConverterFor('png'))  // Flag is set in Is_Processable in mediaLibraryModel, when settings are on, image is png.
		        {
		          $item->action = 'png2jpg';
		        }
						elseif($converter->isConverterFor('heic'))
						{
							  foreach($data['params'] as $sizeName => $sizeData)
								{
									 if (isset($sizeData['convertto']))
									 {
										  $data['params'][$sizeName]['convertto'] = 'jpg';
									 }
								}

								// Run converter to create backup and make placeholder to block similar heics from overwriting.
								$args = array('runReplacer' => false);
								$converter->convert($args);

								//Lossless because thumbnails will otherwise be derived of compressed image, leaving to double compr..
								if (property_exists($item, 'compressionType'))
								{
									 $item->compressionTypeRequested = $item->compressionType;
								}
								// Process Heic as Lossless so we don't have double opts.
								$item->compressionType = ImageModel::COMPRESSION_LOSSLESS;

								// Reset counts
								$counts->baseCount = 1; // count the base images.
								$counts->avifCount = 0;
								$counts->webpCount = 0;
								$counts->creditCount = 1;
						}
				}
				// CompressionType can be integer, but not empty string. In cases empty string might happen, causing lossless optimization, which is not correct.
        if (! is_null($imageModel->getMeta('compressionType')) && is_int($imageModel->getMeta('compressionType')))
				{
          $item->compressionType = $imageModel->getMeta('compressionType');
				}

        // Former securi function, add timestamp to all URLS, for cache busting.
        $urls = $this->timestampURLS( array_values($urls), $imageModel->get('id'));

        $item->urls = apply_filters('shortpixel_image_urls', $urls, $imageModel->get('id'));
				if (count($data['params']) > 0)
				{
					$item->paramlist= array_values($data['params']);
				}

				if (count($data['returnParams']) > 0)
				{
					 $item->returndatalist = $data['returnParams'];
				}
		//		$item->preview = $imagePreviewURL;
        $item->counts = $counts;

        return $item;
    }

		// @internal
		public function _debug_imageModelToQueue($imageModel)
		{
			 return $this->imageModelToQueue($imageModel);
		}

    protected function timestampURLS($urls, $id)
    {
      // https://developer.wordpress.org/reference/functions/get_post_modified_time/
      $time = get_post_modified_time('U', false, $id );
      foreach($urls as $index => $url)
      {
        $urls[$index] = add_query_arg('ver', $time, $url); //has url
      }

      return $urls;
    }

    private function countQueueItem()
    {

    }

		// Check if item is in queue. Considered not in queue if status is done.
		public function isItemInQueue($item_id)
		{
				$itemObj = $this->q->getItem($item_id);

				$notQ = array(ShortQ::QSTATUS_DONE, ShortQ::QSTATUS_FATAL);
				if (is_object($itemObj) && in_array(floor($itemObj->status), $notQ) === false )
				{
					return true;
				}
				return false;
		}

    public function itemFailed($item, $fatal = false)
    {
			  if ($fatal)
			  {
					 Log::addError('Item failed while optimizing', $item);
				}
        $qItem = $this->mediaItemToQueue($item); // convert again
        $this->q->itemFailed($qItem, $fatal);
        $this->q->updateItemValue($qItem);
    }

		public function updateItem($item)
		{
			$qItem = $this->mediaItemToQueue($item); // convert again
			$this->q->updateItemValue($qItem);
		}

		public function isDuplicateActive($mediaItem, $queue = array() )
		{
			if ($mediaItem->get('type') === 'custom')
				return false;

			$WPMLduplicates = $mediaItem->getWPMLDuplicates();
			$qitems = array();
			if (count($queue) > 0)
			{
				 foreach($queue as $qitem)
				 {
					  $qitems[] = $qitem['id'];
				 }
			}

			if (is_array($WPMLduplicates) && count($WPMLduplicates) > 0)
			{
				 $duplicateActive = false;
				 foreach($WPMLduplicates as $duplicate_id)
				 {
					  if (in_array($duplicate_id, $qitems))
						{
							Log::addDebug('Duplicate Item is in queue already, skipping (ar). Duplicate:' . $duplicate_id);
							$duplicateActive = true;
							break;
						}
						elseif ($this->isItemInQueue($duplicate_id))
						{
							 Log::addDebug('Duplicate Item is in queue already, skipping (db). Duplicate:' . $duplicate_id);
							 $duplicateActive = true;
							 break;
						}
				 }
				 if (true === $duplicateActive)
				 {
						return $duplicateActive;
				 }
			}
			return false;
		}

    public function itemDone ($item)
    {
      $qItem = $this->mediaItemToQueue($item); // convert again
      $this->q->itemDone($qItem);
    }

    public function uninstall()
    {
        $this->q->uninstall();
    }

    public function activatePlugin()
    {
        $this->q->resetQueue();
    }

    public function getShortQ()
    {
        return $this->q;
    }

    // All custom Data in the App should be created here.
    private function createCustomData()
    {
        $data = new \stdClass;
        $data->webpCount = 0;
        $data->avifCount = 0;
				$data->baseCount = 0;
        $data->customOperation = false;

        return $data;
    }



} // class
