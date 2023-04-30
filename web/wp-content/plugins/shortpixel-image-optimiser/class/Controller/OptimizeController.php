<?php
namespace ShortPixel\Controller;

use ShortPixel\Controller\ApiKeyController as ApiKeyController;
use ShortPixel\Controller\Queue\MediaLibraryQueue as MediaLibraryQueue;
use ShortPixel\Controller\Queue\CustomQueue as CustomQueue;
use ShortPixel\Controller\Queue\Queue as Queue;

use ShortPixel\Controller\AjaxController as AjaxController;
use ShortPixel\Controller\QuotaController as QuotaController;
use ShortPixel\Controller\StatsController as StatsController;

use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;
use ShortPixel\Controller\ResponseController as ResponseController;

use ShortPixel\Model\Image\ImageModel as ImageModel;
use ShortPixel\Helper\UiHelper as UiHelper;

use ShortPixel\Helper\DownloadHelper as DownloadHelper;

use ShortPixel\Model\Converter\Converter as Converter;

class OptimizeController
{
    //protected static $instance;
    protected static $results;

    protected $isBulk = false; // if queueSystem should run on BulkQueues;

		protected static $lastId; // Last item_id received / send. For catching errors.

    public function __construct()
    {

    }

    // If OptimizeController should use the bulkQueues.
    public function setBulk($bool)
    {
       $this->isBulk = $bool;
    }

		/** Gets the correct queue type */
		// @todo Check how much this is called during run. Perhaps cachine q's instead of new object everytime is more efficient.
    public function getQueue($type)
    {
        $queue = null;

        if ($type == 'media')
        {
            $queueName = ($this->isBulk == true) ? 'media' : 'mediaSingle';
            $queue = new MediaLibraryQueue($queueName);
        }
        elseif ($type == 'custom')
        {
          $queueName = ($this->isBulk == true) ? 'custom' : 'customSingle';
          $queue = new CustomQueue($queueName);
        }
				else
				{
					Log::addInfo("Get Queue $type seems not a queue");
					return false;
				}

        $options = $queue->getCustomDataItem('queueOptions');
        if ($options !== false)
        {
            $queue->setOptions($options);
        }
        return $queue;
    }


    // Queuing Part
    /* Add Item to Queue should be used for starting manual Optimization
    * Enqueue a single item, put it to front, remove duplicates.
		* @param Object $mediaItem
    @return int Number of Items added
    */
    public function addItemToQueue($mediaItem)
    {
        $fs = \wpSPIO()->filesystem();

				$json = $this->getJsonResponse();
        $json->status = 0;
        $json->result = new \stdClass;

				if (! is_object($mediaItem))  // something wrong
				{

					$json->result = new \stdClass;
					$json->result->message = __("File Error. File could not be loaded with this ID ", 'shortpixel-image-optimiser');
					$json->result->apiStatus = ApiController::STATUS_NOT_API;
					$json->fileStatus = ImageModel::FILE_STATUS_ERROR;
					$json->result->is_done = true;
					$json->result->is_error = true;

					ResponseController::addData($item->item_id, 'message', $item->result->message);

					Log::addWarn('Item with id ' . $json->result->item_id . ' is not restorable,');

					 return $json;
				}

        $id = $mediaItem->get('id');
        $type = $mediaItem->get('type');

        $json->result->item_id = $id;

        // Manual Optimization order should always go trough
        if ($mediaItem->isOptimizePrevented() !== false)
            $mediaItem->resetPrevent();

        $queue = $this->getQueue($mediaItem->get('type'));

        if ($mediaItem === false)
        {
          $json->is_error = true;
          $json->result->is_error = true;
          $json->result->is_done = true;
          $json->result->message = __('Error - item could not be found', 'shortpixel-image-optimiser');
          $json->result->fileStatus = ImageModel::FILE_STATUS_ERROR;
        }

        if (! $mediaItem->isProcessable())
        {
          $json->result->message = $mediaItem->getProcessableReason();
          $json->result->is_error = true;
          $json->result->is_done = true;
          $json->result->fileStatus = ImageModel::FILE_STATUS_ERROR;
        }
				elseif($queue->isDuplicateActive($mediaItem))
				{
					$json->result->fileStatus = ImageModel::FILE_STATUS_UNPROCESSED;
					$json->result->is_error = false;
					$json->result->is_done = true;
					$json->result->message = __('A duplicate of this item is already active in queue. ', 'shortpixel-image-optimiser');
				}
        else
        {
          $result = $queue->addSingleItem($mediaItem); // 1 if ok, 0 if not found, false is not processable
          if ($result->numitems > 0)
          {
            $json->result->message = sprintf(__('Item %s added to Queue. %d items in Queue', 'shortpixel-image-optimiser'), $mediaItem->getFileName(), $result->numitems);
            $json->status = 1;

          }
          else
          {
            $json->message = __('No items added to queue', 'shortpixel-image-optimiser');
            $json->status = 0;
          }

            $json->qstatus = $result->qstatus;
            $json->result->fileStatus = ImageModel::FILE_STATUS_PENDING;
            $json->result->is_error = false;
            $json->result->message = __('Item has been added to the queue and will be optimized on the next run', 'shortpixel-image-optimiser');
        }

        return $json;
    }

		/** Check if item is in queue. || Only checks the single queue!
		* @param Object $mediaItem
		*/
		public function isItemInQueue($mediaItem)
		{
				if (! is_null($mediaItem->is_in_queue))
					return $mediaItem->is_in_queue;

				$type = $mediaItem->get('type');

			  $q = $this->getQueue($type);

				$bool = $q->isItemInQueue($mediaItem->get('id'));

			  // Preventing double queries here
				$mediaItem->is_in_queue = $bool;
				return $bool;
		}

		/** Restores an item
		*
		* @param Object $mediaItem
		*/
    public function restoreItem($mediaItem)
    {
        $fs = \wpSPIO()->filesystem();

        $json = $this->getJsonResponse();
        $json->status = 0;
        $json->result = new \stdClass;

				$item_id = $mediaItem->get('id');

        if (! is_object($mediaItem))  // something wrong
        {

					$json->result = new \stdClass;
					$json->result->message = __("File Error. File could not be loaded with this ID ", 'shortpixel-image-optimiser');
					$json->result->apiStatus = ApiController::STATUS_NOT_API;
					$json->fileStatus = ImageModel::FILE_STATUS_ERROR;
					$json->result->is_done = true;
					$json->result->is_error = true;

					ResponseController::addData($item_id, 'is_error', true);
					ResponseController::addData($item_id, 'is_done', true);
					ResponseController::addData($item_id, 'message', $item->result->message);

          Log::addWarn('Item with id ' . $item_id . ' is not restorable,');

           return $json;
        }

				$data = array(
					'item_type' => $mediaItem->get('type'),
					'fileName' => $mediaItem->getFileName(),
				);
				ResponseController::addData($item_id, $data);

        $item_id = $mediaItem->get('id');

				$json->result->item_id = $item_id;

				$optimized = $mediaItem->getMeta('tsOptimized');

				if ($mediaItem->isRestorable())
				{
        	$result = $mediaItem->restore();
				}
				else
				{
					 $result = false;
					 $json->result->message = ResponseController::formatItem($mediaItem->get('id')); // $mediaItem->getReason('restorable');
				}

				// Compat for ancient WP
				$now = function_exists('wp_date') ? wp_date( 'U', time() ) : time();

				// Reset the whole thing after that.
				$mediaItem = $fs->getImage($item_id, $mediaItem->get('type'));

				// Dump this item from server if optimized in the last hour, since it can still be server-side cached.
				if ( ( $now   - $optimized) < HOUR_IN_SECONDS )
				{
					 $api = $this->getAPI();
					 $item = new \stdClass;
					 $item->urls = $mediaItem->getOptimizeUrls();
					 $api->dumpMediaItem($item);
				}


        if ($result)
        {
           $json->status = 1;
           $json->result->message = __('Item restored', 'shortpixel-image-optimiser');
           $json->fileStatus = ImageModel::FILE_STATUS_RESTORED;
           $json->result->is_done = true;
        }
        else
        {

					 $json->result->message = ResponseController::formatItem($mediaItem->get('id'));

           $json->result->is_done = true;
           $json->fileStatus = ImageModel::FILE_STATUS_ERROR;
           $json->result->is_error = true;

        }


        return $json;
    }

		/** Reoptimize an item
		*
		* @param Object $mediaItem
		*/
		public function reOptimizeItem($mediaItem, $compressionType)
    {
      $json = $this->restoreItem($mediaItem);

      if ($json->status == 1) // successfull restore.
      {
					$fs = \wpSPIO()->filesystem();
					$fs->flushImageCache();

          // Hard reload since metadata probably removed / changed but still loaded, which might enqueue wrong files.
            $mediaItem = $fs->getImage($mediaItem->get('id'), $mediaItem->get('type'));

            $mediaItem->setMeta('compressionType', $compressionType);
            $json = $this->addItemToQueue($mediaItem);
            return $json;
      }

     return $json;

    }

    /** Returns the state of the queue so the startup JS can decide if something is going on and what.  **/
    public function getStartupData()
    {

        $mediaQ = $this->getQueue('media');
        $customQ = $this->getQueue('custom');

				// Clean queue upon starting a load.
				$mediaQ->cleanQueue();
				$customQ->cleanQueue();

        $data = new \stdClass;
        $data->media = new \stdClass;
        $data->custom = new \stdClass;
        $data->total = new \stdClass;

        $data->media->stats = $mediaQ->getStats();
        $data->custom->stats = $customQ->getStats();

        $data->total = $this->calculateStatsTotals($data);
				$data = $this->numberFormatStats($data);

        return $data;
    }



    // Processing Part

    // next tick of items to do.
    // @todo Implement a switch to toggle all processing off.
    /* Processes one tick of the queue
    *
    * @return Object JSON object detailing results of run
    */
    public function processQueue($queueTypes = array())
    {

        $keyControl = ApiKeyController::getInstance();

        if ($keyControl->keyIsVerified() === false)
        {
           $json = $this->getJsonResponse();
           $json->status = false;
           $json->error = AjaxController::APIKEY_FAILED;
           $json->message =  __('Invalid API Key', 'shortpixel-image-optimiser');
           $json->status = false;
           return $json;
        }

        $quotaControl = QuotaController::getInstance();
        if ($quotaControl->hasQuota() === false)
        {
					// If we are doing something special (restore, migrate etc), it should runs without credits, so we shouldn't be using any.
					$isCustomOperation = false;
					foreach($queueTypes as $qType)
					{
						$queue = $this->getQueue($qType);
						if ($queue && true === $queue->isCustomOperation())
						{
								$isCustomOperation = true;
								break;
						}
					}

					// Break out of quota if we are on normal operations.
					if (false === $isCustomOperation )
					{
						$quotaControl->forceCheckRemoteQuota(); // on next load check if something happenend when out and asking.
	          $json = $this->getJsonResponse();
	          $json->error = AjaxController::NOQUOTA;
	          $json->status = false;
	          $json->message =   __('Quota Exceeded','shortpixel-image-optimiser');
	          return $json;
					}
        }

        // @todo Here prevent bulk from running when running flag is off
        // @todo Here prevent a runTick is the queue is empty and done already ( reliably )
        $results = new \stdClass;
        if ( in_array('media', $queueTypes))
        {
          $mediaQ = $this->getQueue('media');
          $results->media = $this->runTick($mediaQ); // run once on mediaQ
        }
        if ( in_array('custom', $queueTypes))
        {
          $customQ = $this->getQueue('custom');
          $results->custom = $this->runTick($customQ);
        }

        $results->total = $this->calculateStatsTotals($results);
				$results = $this->numberFormatStats($results);

    //    $this->checkCleanQueue($results);

        return $results;
    }

    private function runTick($Q)
    {
      $result = $Q->run();
      $results = array();

			ResponseController::setQ($Q);

      // Items is array in case of a dequeue items.
      $items = (isset($result->items) && is_array($result->items)) ? $result->items : array();

      /* Only runs if result is array, dequeued items.
				 Item is a MediaItem subset of QueueItem

			*/
      foreach($items as $mainIndex => $item)
      {
               //continue; // conversion done one way or another, item will be need requeuing, because new urls / flag.
						$item = $this->sendToProcessing($item, $Q);

            $item = $this->handleAPIResult($item, $Q);
            $result->items[$mainIndex] = $item; // replace processed item, should have result now.
      }

      $result->stats = $Q->getStats();
      $json = $this->queueToJson($result);
      $this->checkQueueClean($result, $Q);

      return $json;
    }


    /** Checks and sends the item to processing
    * @param Object $item Item is a stdClass object from Queue. This is not a model, nor a ShortQ Item.
    * @param Object $q  Queue Object
		*/
    public function sendToProcessing($item, $q)
    {
      $api = $this->getAPI();
			$this->setLastID($item->item_id);

			$fs = \wpSPIO()->filesystem();
			$qtype = $q->getType();
			$qtype = strtolower($qtype);

			$imageObj = $fs->getImage($item->item_id, $qtype);
			if (is_object($imageObj))
			{
				ResponseController::addData($item->item_id, 'fileName', $imageObj->getFileName());

			}

			// If item is blocked (handling success), skip over. This can happen if internet is slow or process too fast.
			if (property_exists($item, 'blocked') && true === $item->blocked )
			{
					$item = $this->handleAPIResult($item, $q);
			}
      elseif (property_exists($item, 'action'))
      {
            $item->result = new \stdClass;
            $item->result->is_done = true; // always done
            $item->result->is_error = false; // for now
            $item->result->apiStatus = ApiController::STATUS_NOT_API;

					 if ($imageObj === false) // not exist error.
					 {
					 	 return $this->handleAPIResult($item, $q);
					 }
           switch($item->action)
           {
              case 'restore';
//							 Log::addError('Restore tick is off in sendToProcessing!');
                 $imageObj->restore(array('keep_in_queue' => true));
              break;
              case 'migrate':
									$imageObj->migrate(); // hard migrate in bulk, to check if all is there / resync on problems.
              break;
							case 'png2jpg':
								$item = $this->convertPNG($item, $q);
								$item->result->is_done = false;  // if not, finished to newly enqueued
							break;
							case 'removeLegacy':
									 $imageObj->removeLegacyShortPixel();
							break;
           }
      }
      else // as normal
      {
				$item = $api->processMediaItem($item, $imageObj);

      }
      return $item;
    }

    protected function convertPNG($item, $mediaQ)
    {
			$item->blocked = true;
			$mediaQ->updateItem($item);

      $settings = \wpSPIO()->settings();
      $fs = \wpSPIO()->filesystem();

      $imageObj = $fs->getMediaImage($item->item_id);

			 if ($imageObj === false) // not exist error.
			 {
				 $item->blocked = false;
				 $q->updateItem($item);

			 	 return $item; //$this->handleAPIResult($item, $mediaQ);
			 }

				$converter = Converter::getConverter($imageObj, true);
				$bool = false; // init
				if (false === $converter)
				{
					 Log::addError('Converter on Convert function returned false ' . $imageObj->get('id'));
					 $bool = false;
				}
				elseif ($converter->isConvertable())
				{
					$bool = $converter->convert();
				}

			if ($bool)
			{
				 ResponseController::addData($item->item_id, 'message', __('PNG2JPG converted', 'shortpixel-image-optimiser'));
			}
			else {
				 ResponseController::addData($item->item_id, 'message', __('PNG2JPG not converted', 'shortpixel-image-optimiser'));
			}

			// Regardless if it worked or not, requeue the item otherwise it will keep trying to convert due to the flag.
      $imageObj = $fs->getMediaImage($item->item_id);

			// Keep compressiontype from object, set in queue, imageModelToQueue
			$imageObj->setMeta('compressionType', $item->compressionType);

			$item->blocked = false;
			$mediaQ->updateItem($item);

// @todo Turn this back on!
      $this->addItemToQueue($imageObj);

      return $item;
    }


    // This is everything sub-efficient.
    /* Handles the Queue Item API result .
    */
    protected function handleAPIResult($item, $q)
    {
      $fs = \wpSPIO()->filesystem();

      $qtype = $q->getType();
      $qtype = strtolower($qtype);

      $imageItem = $fs->getImage($item->item_id, $qtype);

      // If something is in the queue for long, but somebody decides to trash the file in the meanwhile.
      if ($imageItem === false)
      {
				$item->result = new \stdClass;
        $item->result->message = __("File Error. File could not be loaded with this ID ", 'shortpixel-image-optimiser');
        $item->result->apiStatus = ApiController::STATUS_NOT_API;
        $item->fileStatus = ImageModel::FILE_STATUS_ERROR;
        $item->result->is_done = true;
        $item->result->is_error = true;

				ResponseController::addData($item->item_id, 'message', $item->result->message);
      }
			elseif(property_exists($item, 'blocked') && true === $item->blocked)
			{
				$item->result = new \stdClass;
				$item->result->apiStatus = ApiController::STATUS_UNCHANGED;
				$item->result->message = __('Item is waiting (blocked)', 'shortpixel-image-optimiser');
				$item->result->is_done = false;
				$item->result->is_error = false;
				Log::addWarn('Encountered blocked item, processing success? ', $item->item_id);
			}
      else
			{
				// This used in bulk preview for formatting filename.
        $item->result->filename = $imageItem->getFileName();
				// Used in WP-CLI
				ResponseController::addData($item->item_id, 'fileName', $imageItem->getFileName());
			}

      $result = $item->result;

			$quotaController = QuotaController::getInstance();
			$statsController = StatsController::getInstance();

      if ($result->is_error)
      {
          // Check ApiStatus, and see what is what for error
          // https://shortpixel.com/api-docs
          $apistatus = $result->apiStatus;

          if ($apistatus == ApiController::STATUS_ERROR ) // File Error - between -100 and -300
          {
              $item->fileStatus = ImageModel::FILE_STATUS_ERROR;
          }
          // Out of Quota (partial / full)
          elseif ($apistatus == ApiController::STATUS_QUOTA_EXCEEDED)
          {
              $item->result->error = AjaxController::NOQUOTA;
							$quotaController->setQuotaExceeded();
          }
          elseif ($apistatus == ApiController::STATUS_NO_KEY)
          {
              $item->result->error = AjaxController::APIKEY_FAILED;
          }
          elseif($apistatus == ApiController::STATUS_QUEUE_FULL || $apistatus == ApiController::STATUS_MAINTENANCE ) // Full Queue / Maintenance mode
          {
              $item->result->error = AjaxController::SERVER_ERROR;
          }

					$response = array(
						 'is_error' => true,
						 'message' => $item->result->message, // These mostly come from API
					);
					ResponseController::addData($item->item_id, $response);

          if ($result->is_done )
          {
             $q->itemFailed($item, true);
             $this->HandleItemError($item, $qtype);

						 ResponseController::addData($item->item_id, 'is_done', true);
          }

      }
      elseif ($result->is_done)
      {
         if ($result->apiStatus == ApiController::STATUS_SUCCESS ) // Is done and with success
         {

           $tempFiles = array();

           // Set the metadata decided on APItime.
           if (isset($item->compressionType))
           {
             $imageItem->setMeta('compressionType', $item->compressionType);
           }

					 if (count($result->files) > 0 )
           {
              //$optimizeResult = $imageItem->handleOptimized($result->files); // returns boolean or null

							$status = $this->handleOptimizedItem($q, $item, $imageItem, $result->files);

              $item->result->improvements = $imageItem->getImprovements();

              if (ApiController::STATUS_SUCCESS == $status)
              {
                 $item->result->apiStatus = ApiController::STATUS_SUCCESS;
                 $item->fileStatus = ImageModel::FILE_STATUS_SUCCESS;

                 do_action('shortpixel_image_optimised', $imageItem->get('id'));
								 do_action('shortpixel/image/optimised', $imageItem);
               }
							 elseif(ApiController::STATUS_CONVERTED == $status)
							 {
								 $item->result->apiStatus = ApiController::STATUS_CONVERTED;
								 $item->fileStatus = ImageModel::FILE_STATUS_SUCCESS;

								 $fs = \wpSPIO()->filesystem();
		 						 $imageItem = $fs->getMediaImage($item->item_id);

								 if (property_exists($item, 'compressionTypeRequested'))
								 {
										$item->compressionType = $item->compressionTypeRequested;
								 }
								 // Keep compressiontype from object, set in queue, imageModelToQueue
								 $imageItem->setMeta('compressionType', $item->compressionType);
							 }
               else
               {
                 $item->result->apiStatus = ApiController::STATUS_ERROR;
                 $item->fileStatus = ImageModel::FILE_STATUS_ERROR;
              //   $item->result->message = sprintf(__('Image not optimized with errors', 'shortpixel-image-optimiser'), $item->item_id);
              //   $item->result->message = $imageItem->getLastErrorMessage();
                 $item->result->is_error = true;

               }

              unset($item->result->files);

              $item->result->queuetype = $qtype;

							$showItem = UiHelper::findBestPreview($imageItem); // find smaller / better preview

							if ($showItem->getExtension() == 'pdf') // non-showable formats here
							{
								 $item->result->original = false;
								 $item->result->optimized = false;
							}
							elseif ($showItem->hasBackup())
              {
                $backupFile = $showItem->getBackupFile(); // attach backup for compare in bulk
                $backup_url = $fs->pathToUrl($backupFile);
                $item->result->original = $backup_url;
								$item->result->optimized = $fs->pathToUrl($showItem);
              }
              else
							{
                $item->result->original = false;
								$item->result->optimized = $fs->pathToUrl($showItem);
							}

							// Dump Stats, Dump Quota. Refresh
							//$quotaController->forceCheckRemoteQuota();
							$statsController->reset();

							$this->deleteTempFiles($item);

           }
           // This was not a request process, just handle it and mark it as done.
           elseif ($result->apiStatus == ApiController::STATUS_NOT_API)
           {
              // Nothing here.
           }
           else
           {
              Log::addWarn('Api returns Success, but result has no files', $result);
              $item->result->is_error = true;
              $message = sprintf(__('Image API returned succes, but without images', 'shortpixel-image-optimiser'), $item->item_id);
							ResponseController::addData($item->item_id, 'message', $message );

              $item->result->apiStatus = ApiController::STATUS_FAIL;
           }


         }  // Is Done / Handle Success

				 // This is_error can happen not from api, but from handleOptimized
         if ($item->result->is_error)
         {
					 Log::addDebug('Item failed, has error on done ', $item);
          $q->itemFailed($item, true);
          $this->HandleItemError($item, $qtype);
         }
         else
         {
           if ($imageItem->isProcessable() && $result->apiStatus !== ApiController::STATUS_NOT_API)
           {
              Log::addDebug('Item with ID' . $imageItem->item_id . ' still has processables (with dump)', $imageItem->getOptimizeUrls());
 						  $api = $this->getAPI();
							$newItem = new \stdClass;
							$newItem->urls = $imageItem->getOptimizeUrls();

							// Add to URLs also the possiblity of images with only webp / avif needs. Otherwise URLs would end up emtpy.

							// It can happen that only webp /avifs are left for this image. This can't influence the API cache, so dump is not needed. Just don't send empty URLs for processing here.
							if (count($newItem->urls) > 0)
							{
								$api->dumpMediaItem($newItem);
							}

              $this->addItemToQueue($imageItem); // requeue for further processing.
           }
           elseif (ApiController::STATUS_CONVERTED !== $result->apiStatus)
					 {
            $q->itemDone($item); // Unbelievable but done.
					 }
         }
      }
      else
      {
          if ($result->apiStatus == ApiController::STATUS_UNCHANGED || $result->apiStatus === Apicontroller::STATUS_PARTIAL_SUCCESS)
          {
              $item->fileStatus = ImageModel::FILE_STATUS_PENDING;
							$retry_limit = $q->getShortQ()->getOption('retry_limit');

							if ($result->apiStatus === ApiController::STATUS_PARTIAL_SUCCESS)
							{
									if (count($result->files) > 0 )
									{
										 //$optimizeResult = $imageItem->handleOptimized($result->files); // returns boolean or null
										 $this->handleOptimizedItem($q, $item, $imageItem, $result->files);
									}
									else {
										Log::addWarn('Status is partial success, but no files followed. ');
									}

									// Let frontend follow unchanged / waiting procedure.
									$result->apiStatus = ApiController::STATUS_UNCHANGED;

							}
							// Try to replace the item ID with the filename.
						//	$item->result->message = substr_replace( $item->result->message,  $imageItem->getFileName() . ' ', strpos($item->result->message, '#' . $item->item_id), 0);
             // $item->result->message .= sprintf(__('(cycle %d)', 'shortpixel-image-optimiser'), intval($item->tries) );


							if ($retry_limit == $item->tries || $retry_limit == ($item->tries -1))
							{

									$item->result->apiStatus = ApiController::ERR_TIMEOUT;
									$message = __('Retry Limit reached. Image might be too large, limit too low or network issues.  ', 'shortpixel-image-optimiser');
									$item->result->message = $message;

									ResponseController::addData($item->item_id, 'message', $message);
									ResponseController::addData($item->item_id, 'is_error', true);
									ResponseController::addData($item->item_id, 'is_done', true);

									$item->result->is_error = true;
									$item->result->is_done = true;

									$this->HandleItemError($item, $qtype);

									// @todo Remove temp files here
							}
							else {
									ResponseController::addData($item->item_id, 'message', $item->result->message); // item is waiting base line here.
							}
						/* Item is not failing here:  Failed items come on the bottom of the queue, after all others so might cause multiple credit eating if the time is long. checkQueue is only done at the end of the queue.
						* Secondly, failing it, would prevent it going to TIMEOUT on the PROCESS in WPQ - which would mess with correct timings on that.
						*/
            //  $q->itemFailed($item, false); // register as failed, retry in x time, q checks timeouts
          }
      }

			// Not relevant for further returning.
			if (property_exists($item, 'paramlist'))
				 unset($item->paramlist);

			if (property_exists($item, 'returndatalist'))
				 unset($item->returndatalist);

			// Cleaning up the debugger.
			$debugItem = clone $item;
			unset($debugItem->_queueItem);
			unset($debugItem->counts);

			Log::addDebug('Optimizecontrol - Item has a result ', $debugItem);


			ResponseController::addData($item->item_id, array(
				'is_error' => $item->result->is_error,
				'is_done' => $item->result->is_done,
				'apiStatus' => $item->result->apiStatus,
				'tries' => $item->tries,

			));

			if (property_exists($item, 'fileStatus'))
			{
				 ResponseController::addData($item->item_id, 'fileStatus', $item->fileStatus);
			}

			// For now here, see how that goes
			$item->result->message = ResponseController::formatItem($item->item_id);

			if ($item->result->is_error)
				$item->result->kblink = UiHelper::getKBSearchLink($item->result->message);

      return $item;

    }


		protected function handleOptimizedItem($q, $item, $mediaObj, $successData)
		{
				$imageArray = $successData['files'];

				$downloadHelper = DownloadHelper::getInstance();
				$converter = Converter::getConverter($mediaObj, true);

				$item->blocked = true;
				$q->updateItem($item);

				if (! property_exists($item, 'files'))
				{
					$item->files = array();
				}

				foreach($imageArray as $imageName => $image)
				{
					 if (! isset($item->files[$imageName]))
					 {
						 $item->files[$imageName]  = array();
					 }

					 if (isset($item->files[$imageName]['image']) && file_exists($item->files[$imageName]['image']))
					 {
						  // All good.
					 }
					 // If status is success.  When converting (API) allow files that are bigger
					 elseif ($image['image']['status'] == ApiController::STATUS_SUCCESS ||
					 				($image['image']['status'] == ApiController::STATUS_OPTIMIZED_BIGGER && is_object($converter))
									)
					 {
						  $tempFile = $downloadHelper->downloadFile($image['image']['url']);
							if (is_object($tempFile))
							{
								$item->files[$imageName]['image'] = $tempFile->getFullPath();
								$imageArray[$imageName]['image']['file'] = $tempFile->getFullPath();
							}
					 }


					 if (! isset($item->files[$imageName]['webp']) &&  $image['webp']['status'] == ApiController::STATUS_SUCCESS)
					 {
						 $tempFile = $downloadHelper->downloadFile($image['webp']['url']);
						 if (is_object($tempFile))
						 {
						 		$item->files[$imageName]['webp'] = $tempFile->getFullPath();
						 		$imageArray[$imageName]['webp']['file'] = $tempFile->getFullPath();
					 		}
				 	 }
					 elseif ($image['webp']['status'] == ApiController::STATUS_OPTIMIZED_BIGGER) {
					 		$item->files[$imageName]['webp'] = ApiController::STATUS_OPTIMIZED_BIGGER;
					 }

					 if (! isset($item->files[$imageName]['avif']) && $image['avif']['status'] == ApiController::STATUS_SUCCESS)
					 {
						 $tempFile = $downloadHelper->downloadFile($image['avif']['url']);
						 if (is_object($tempFile))
						 {
						 		$item->files[$imageName]['avif'] = $tempFile->getFullPath();
						 		$imageArray[$imageName]['avif']['file'] = $tempFile->getFullPath();
						 }
					 }
					 elseif ($image['avif']['status'] == ApiController::STATUS_OPTIMIZED_BIGGER) {
					 		$item->files[$imageName]['avif'] = ApiController::STATUS_OPTIMIZED_BIGGER;

					 }
				}

				$successData['files']  = $imageArray;

				$converter = Converter::getConverter($mediaObj, true);
				$optimizedArgs = array();
				if (is_object($converter) && $converter->isConverterFor('heic') )
				{
					$optimizedResult = $converter->handleConverted($successData);
					if (true === $optimizedResult)
					{
						ResponseController::addData($item->item_id, 'message', __('File Converted', 'shortpixel-image-optimiser'));
						$status = ApiController::STATUS_CONVERTED;

					}
					else {
						ResponseController::addData($item->item_id, 'message', __('File conversion failed.', 'shortpixel-image-optimiser'));
						$q->itemFailed($item, true);
						$status = ApiController::STATUS_FAIL;
					}

				}
				else
				{
					$optimizedResult = $mediaObj->handleOptimized($successData);
					if (true === $optimizedResult)
					  $status = ApiController::STATUS_SUCCESS;
					else {
						$status = ApiController::STATUS_FAIL;
					}
				}

				$item->blocked = false;
				$q->updateItem($item);

				return $status;
		}


    /**
		* @integration Regenerate Thumbnails Advanced
		* Called via Hook when plugins like RegenerateThumbnailsAdvanced Update an thumbnail
		*/
    public function thumbnailsChangedHook($postId, $originalMeta, $regeneratedSizes = array(), $bulk = false)
    {
       $fs = \wpSPIO()->filesystem();
       $settings = \wpSPIO()->settings();
       $imageObj = $fs->getMediaImage($postId);

			 Log::addDebug('Regenerated Thumbnails reported', $regeneratedSizes);

       if (count($regeneratedSizes) == 0)
        return;

        $metaUpdated = false;
        foreach($regeneratedSizes as $sizeName => $size) {
            if(isset($size['file']))
            {

                //$fileObj = $fs->getFile( (string) $mainFile->getFileDir() . $size['file']);
                $thumb = $imageObj->getThumbnail($sizeName);
                if ($thumb !== false)
                {
                  $thumb->setMeta('status', ImageModel::FILE_STATUS_UNPROCESSED);
									$thumb->onDelete();

                  $metaUpdated = true;
                }
            }
        }

        if ($metaUpdated)
           $imageObj->saveMeta();

				if (\wpSPIO()->env()->is_autoprocess)
				{
						if($imageObj->isOptimized())
						{

							$this->addItemToQueue($imageObj);
						}
				}
    }


		private function HandleItemError($item, $type)
    {
			 // Perhaps in future this might be taken directly from ResponseController
        if ($this->isBulk)
				{
					$responseItem = ResponseController::getResponseItem($item->item_id);
          $fs = \wpSPIO()->filesystem();
          $backupDir = $fs->getDirectory(SHORTPIXEL_BACKUP_FOLDER);
          $fileLog = $fs->getFile($backupDir->getPath() . 'current_bulk_' . $type . '.log');

          $time = UiHelper::formatTs(time());

          $fileName = $responseItem->fileName;
          $message = ResponseController::formatItem($item->item_id);
          $item_id = $item->item_id;

          $fileLog->append($time . '|' . $fileName . '| ' . $item_id . '|' . $message . ';' .PHP_EOL);
        }
    }

    protected function checkQueueClean($result, $q)
    {
        if ($result->qstatus == Queue::RESULT_QUEUE_EMPTY && ! $this->isBulk)
        {
            $stats = $q->getStats();

            if ($stats->done > 0 || $stats->fatal_errors > 0)
            {
               $q->cleanQueue(); // clean the queue
            }
        }
    }

    protected function getAPI()
    {
       return ApiController::getInstance();
    }

    /** Convert a result Queue Stdclass to a JSON send Object */
    protected function queueToJson($result, $json = false)
    {
        if (! $json)
          $json = $this->getJsonResponse();

        switch($result->qstatus)
        {
          case Queue::RESULT_PREPARING:
            $json->message = sprintf(__('Prepared %s items', 'shortpixel-image-optimiser'), $result->items );
          break;
          case Queue::RESULT_PREPARING_DONE:
            $json->message = sprintf(__('Preparing is done, queue has %s items ', 'shortpixel-image-optimiser'), $result->stats->total );
          break;
          case Queue::RESULT_EMPTY:
              $json->message  = __('Queue returned no active items', 'shortpixel-image-optimiser');
          break;
          case Queue::RESULT_QUEUE_EMPTY:
              $json->message = __('Queue empty and done', 'shortpixel-image-optimiser');
          break;
          case Queue::RESULT_ITEMS:
            $json->message = sprintf(__("Fetched %d items",  'shortpixel-image-optimiser'), count($result->items));
            $json->results = $result->items;
          break;
          case Queue::RESULT_RECOUNT: // This one should probably not happen.
             $json->has_error = true;
             $json->message = sprintf(__('Bulk preparation seems to be interrupted. Restart the queue or continue without accurate count', 'shortpixel-image-optimiser'));
          break;
          default:
             $json->message = sprintf(__('Unknown Status %s ', 'shortpixel-image-optimiser'), $result->qstatus);
          break;
        }
        $json->qstatus = $result->qstatus;
        //$json->

        if (property_exists($result, 'stats'))
          $json->stats = $result->stats;

      /*  Log::addDebug('JSON RETURN', $json);
        if (property_exists($result,'items'))
          Log::addDebug('Result Items', $result->items); */


        return $json;
    }

    // Communication Part
    protected function getJsonResponse()
    {

      $json = new \stdClass;
      $json->status = null;
      $json->result = null;
      $json->results = null;
//      $json->actions = null;
    //  $json->has_error = false;// probably unused
      $json->message = null;

      return $json;
    }

    /** Tries to calculate total stats of the process for bulk reporting
    *  Format of results is   results [media|custom](object) -> stats
    */
    private function calculateStatsTotals($results)
    {
        $has_media = $has_custom = false;

        if (property_exists($results, 'media') &&
            is_object($results->media) &&
            property_exists($results->media,'stats') && is_object($results->media->stats))
        {
          $has_media = true;
        }

        if (property_exists($results, 'custom') &&
            is_object($results->custom) &&
            property_exists($results->custom, 'stats') && is_object($results->custom->stats))
        {
          $has_custom = true;
        }

        $object = new \stdClass;  // total

        if ($has_media && ! $has_custom)
        {
           $object->stats = $results->media->stats;
           return $object;
        }
        elseif(! $has_media && $has_custom)
        {
           $object->stats = $results->custom->stats;
           return $object;
        }
        elseif (! $has_media && ! $has_custom)
        {
            return null;
        }

        // When both have stats. Custom becomes the main. Calculate media stats over it. Clone, important!
        $object->stats = clone $results->custom->stats;

        if (property_exists($object->stats, 'images'))
          $object->stats->images = clone $results->custom->stats->images;

        foreach ($results->media->stats as $key => $value)
        {
            if (property_exists($object->stats, $key))
            {
							 if ($key == 'percentage_done')
							 {
								  if (property_exists($results->custom->stats, 'total') && $results->custom->stats->total == 0)
										 $perc = $value;
								  elseif(property_exists($results->media->stats, 'total') && $results->media->stats->total == 0)
									{
										 $perc = $object->stats->$key;
									}
									else
									{
										$total = $results->custom->stats->total + $results->media->stats->total;
										$done = $results->custom->stats->done + $results->media->stats->done;
										$fatal = $results->custom->stats->fatal_errors + $results->media->stats->fatal_errors;
										$perc = round((100 / $total) * ($done + $fatal), 0, PHP_ROUND_HALF_DOWN);
								 //		$perc = round(($object->stats->$key + $value) / 2); //exceptionnes.
									}
									$object->stats->$key  = $perc;
							 }
               elseif (is_numeric($object->stats->$key)) // add only if number.
               {
                $object->stats->$key += $value;
               }
               elseif(is_bool($object->stats->$key))
               {
                  // True > False in total since this status is true for one of the items.
                  if ($value === true && $object->stats->$key === false)
                     $object->stats->$key = true;
               }
               elseif (is_object($object->stats->$key)) // bulk object, only numbers.
               {
                  foreach($results->media->stats->$key as $bKey => $bValue)
                  {
                      $object->stats->$key->$bKey += $bValue;
                  }
               }
            }
        }


        return $object;
    }

		private function numberFormatStats($results) // run the whole stats thing through the numberFormat.
		{
			//qn: array('media', 'custom', 'total')
			 foreach($results as $qn => $item)
			 {
				  if (is_object($item) && property_exists($item, 'stats'))
					{
					  foreach($item->stats as $key => $value)
						{
								 $raw_value = $value;
								 if (is_object($value))
								 {
									  foreach($value as $key2 => $val2) // embedded 'images' can happen here.
										{
										 $value->$key2 = UiHelper::formatNumber($val2, 0);
										}
								 }
								 elseif (strpos($key, 'percentage') !== false)
								 {
								 	  $value = UiHelper::formatNumber($value, 2);
								 }
								 else
								 {
								 		$value = UiHelper::formatNumber($value, 0);
								 }

								$results->$qn->stats->$key = $value;
							/*	if (! property_exists($results->$qn->stats, 'raw'))
									$results->$qn->stats->raw = new \stdClass;

								$results->$qn->stats->raw->$key = $raw_value; */
						}
					}
			 }
			 return $results;
		}

		protected function deleteTempFiles($item)
		{
				if (! property_exists($item, 'files'))
				{
					return false;
				}

				$files = $item->files;
				$fs = \wpSPIO()->filesystem();

				foreach($files as $name => $data)
				{
						foreach($data as $tmpPath)
						{
							 if (is_numeric($tmpPath)) // Happens when result is bigger status is set.
							 	continue;

								$tmpFile = $fs->getFile($tmpPath);
								if ($tmpFile->exists())
									$tmpFile->delete();
						}
				}

		}

		protected function setLastID($item_id)
		{
			 self::$lastId = $item_id;
		}

		public static function getLastId()
		{
			 return self::$lastId;
		}

    public static function resetQueues()
    {
	      $queues = array('media', 'mediaSingle', 'custom', 'customSingle');
	      foreach($queues as $qName)
	      {
	          $q = new MediaLibraryQueue($qName);
	          $q->activatePlugin();
	      }
    }

    public static function uninstallPlugin()
    {
      //$mediaQ = MediaLibraryQueue::getInstance();
      //$queue = new MediaLibraryQueue($queueName);
      $queues = array('media', 'mediaSingle', 'custom', 'customSingle');
      foreach($queues as $qName)
      {
          $q = new MediaLibraryQueue($qName);
          $q->uninstall();
      }

    }


} // class
