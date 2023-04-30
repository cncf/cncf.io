<?php
namespace ShortPixel;
use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;
use ShortPixel\Controller\OptimizeController as OptimizeController;
use ShortPixel\Controller\BulkController as BulkController;

use ShortPixel\Controller\Queue\Queue as Queue;
use ShortPixel\Controller\ApiController as ApiController;
use ShortPixel\Controller\ResponseController as ResponseController;

use ShortPixel\Helper\UiHelper as UiHelper;


class WpCliController
{
    public static $instance;

    protected static $ticks = 0;
    protected static $emptyq = 0;

    public function __construct()
    {
				$log = \ShortPixel\ShortPixelLogger\ShortPixelLogger::getInstance();
				if (\ShortPixel\ShortPixelLogger\ShortPixelLogger::debugIsActive())
					$log->setLogPath(SHORTPIXEL_BACKUP_FOLDER . "/shortpixel_log_wpcli");

        $this->initCommands();
    }

    public static function getInstance()
    {
        if (is_null(self::$instance))
          self::$instance = new WpCliController();



        return self::$instance;
    }


    protected function initCommands()
    {
        \WP_CLI::add_command('spio', '\ShortPixel\SpioSingle');
				\WP_CLI::add_command('spio bulk', '\ShortPixel\SpioBulk');
    }

} // class WpCliController

/**
* ShortPixel Image Optimizer
*
*
*/
class SpioCommandBase
{

     protected static $runs = 0;
		 protected $last_combinedStatus;

      /**
     * Adds a single item to the queue(s), then processes the queue(s).
     *
     * ## OPTIONS
     *
     * <id>
     * : Media Library ID or Custom Media ID
     *
     *
	   * [--type=<type>]
	   * : media or custom
	   * ---
	   * default: media
	   * options:
	   *   - media
	   *   - custom
	   * ---
	 	 *
   	 * [--halt]
     * : Stops (does not process the queues) after the item is added.
     *
     *
     * ## EXAMPLES
     *
     *   wp spio [bulk] add 123
     *   wp spio [bulk] add 21 --type=custom --halt
     *
     * @when after_wp_load
     */
    public function add($args, $assoc)
    {
        $controller = $this->getOptimizeController();

				$type = isset($assoc['type']) ? sanitize_text_field($assoc['type']) : 'media';

        if (! isset($args[0]))
        {
          \WP_CLI::Error(__('Specify an Media Library Item ID', 'shortpixel-image-optimiser'));
          return;
        }
        $id = intval($args[0]);

        $fs = \wpSPIO()->filesystem();
        $imageObj = $fs->getImage($id, $type);

				if ($imageObj === false)
				{
					 \WP_CLI::Error(__('Image object not found / non-existing in database by this ID', 'shortpixel-image-optimiser'));
				}

        $result = $controller->addItemtoQueue($imageObj);

			//	$complete = isset($assoc['complete']) ? true : false;

        if ($result->status == 1)
				{

          \WP_CLI::Success($result->result->message);


					if (! isset($assoc['halt']))
					{
							$this->run($args, $assoc);
					}
					else {
						\WP_CLI::Line (__('You can optimize images via the run command', 'shortpixel-image-optimiser'));
					}
				}
        elseif ($result->status == 0)
        {
          \WP_CLI::Error(sprintf(__("while adding item: %s", 'shortpixel_image_optimiser'), $result->result->message) );
        }

				$this->status($args, $assoc);
    }



   /**
   * Starts processing what has been added to the processing queue(s), optionally stopping after a specified number of "ticks".
   *
         * A tick (or cycle) means a request sent to the API, either to send an image to be processed or to check if the API has completed processing. Use the ticks (cycles) if you want to run the script regularly (every few minutes) want to run the script.
	 *
	 * If you do not define ticks, the queue will run until everything has been processed.
   *
   * ## OPTIONS
   *
   * [--ticks=<number>]
   * : How often the queue runs (how many ticks/cycles)
	 * ---
   *
   * [--wait=<seconds>]
   * : How many seconds the system waits for next tick (cycle).
	 * ---
	 * default: 3
	 * ---
	 *
   * [--queue=<name>]
   * : Either 'media' or 'custom'. Omit the parameter to run both queues.
   * ---
   * default: media,custom
   * ---
   * options:
   *   - media
   *   - custom
   * ---
   *
   * ## EXAMPLES
   *
   *   wp spio [bulk] run													  | Complete all processes
   *   wp spio [bulk] run --ticks=20 --wait=3				| Ticks and wait time.
   *   wp spio [bulk] run --queue=media							| Only run a specific queue.
   *
   *
   * @when after_wp_load
   */
    public function run($args, $assoc)
    {
        if ( isset($assoc['ticks']))
          $ticks = intval($assoc['ticks']);

        if (isset($assoc['wait']))
          $wait = intval($assoc['wait']);
        else
          $wait = 3;

				// Prepare limit
				if (isset($assoc['limit']))
				{
					$limit = intval($assoc['limit']);
				}
				else {
					 $limit = false;
				}

				$complete = false;
        if (! isset($assoc['ticks']))
        {
            $ticks = -1;
						$complete = true; // run until all is done.
        }

				$queue = $this->getQueueArgument($assoc);

        while($ticks > 0 || $complete == true)
        {
           $bool = $this->runClick($queue);
           if ($bool === false)
           {
						 $this->status($args, $assoc);
             break;
           }

					 if (false !== $limit)
					 {
						  $status = $this->getStatus();
							$total = $this->unFormatNumber($status->total->stats->total);
							$is_preparing = $status->total->stats->is_preparing;
							if ($total >= $limit && $is_preparing)
							{
								\WP_CLI::log(sprintf('Bulk Preparing is done. Limit reached of %s items (%s items). Use start command to signal ready. Use run to process after starting.', $limit, $status->total->stats->total));
								$this->status($args, $assoc);

								 $bool = false;
								 break;
							}
					 }

           $ticks--;

					if (ob_get_length() !== false)
					{
						ob_flush();
					}

         	sleep($wait);

        }

				// Done.
				$this->showResponses();

    }

    protected function runClick($queueTypes)
    {
			  ResponseController::setOutput(ResponseController::OUTPUT_CLI);

        $controller = $this->getOptimizeController();
        $results = $controller->processQueue($queueTypes);

	 			$totalStats = (property_exists($results, 'total') && property_exists($results->total, 'stats')) ? $results->total->stats : null;

				// Trouble
				if (is_object($results) && property_exists($results, 'status') && $results->status === false)
				{
					 	\WP_CLI::error($results->message);
				}

				foreach($queueTypes as $qname)
				{

					$qresult = $results->$qname; // qname really is type.

	        if (! is_null($qresult->message))
	        {

						// Queue Empty not interesting for CLI.
						if ($qresult->qstatus == Queue::RESULT_QUEUE_EMPTY || $qresult->qstatus == Queue::RESULT_EMPTY)
						{

						}
						// Result / Results have more interesting information than how much was fetched here probably.
						elseif (! property_exists($qresult, 'result') && ! property_exists($qresult, 'results'))
						{
	          	\WP_CLI::log( ucfirst($qname) . ' : ' . $qresult->message); // Single Response ( ie prepared, enqueued etc )
						}
	        }

		        // Result after optimizing items and such.
		        if (property_exists($qresult, 'results') && is_array($qresult->results))
		        {
		           foreach($qresult->results as $item)
		           {
								   // Non-result results can happen ( ie. with PNG conversion ). Probably just ignore.
								 	 if (! is_object($item->result))
									 {
										  continue;
									 }

		               $result = $item->result;
									 $counts = $item->counts;

									 $apiStatus = property_exists($result, 'apiStatus') ? $result->apiStatus : null;

									 $this->displayResult($result, $qname, $counts);

									 // prevent spamming.
									 if (! is_null($totalStats) && $apiStatus == ApiController::STATUS_SUCCESS )
									 {
									 	 $this->displayStatsLine('Total', $totalStats);
									 }

		           }
	        	}
						if (property_exists($qresult, 'result') && is_object($qresult->result))
						{
								$this->displayResult($qresult->result);
						}

				}

				// Combined Status. Implememented from shortpixel-processor.js
	      $mediaStatus = $customStatus = 100;

				if (property_exists($results, 'media') && property_exists($results->media, 'qstatus') )
				{
					 $mediaStatus = $results->media->qstatus;
				}
				if (property_exists($results, 'custom') && property_exists($results->custom, 'qstatus') )
				{
					 $customStatus = $results->custom->qstatus;
				}

	        // The lowest queue status (for now) equals earlier in process. Don't halt until both are done.
	        if ($mediaStatus <= $customStatus)
	          $combinedStatus = $mediaStatus;
	        else
	          $combinedStatus = $customStatus;

      	if ($combinedStatus == Queue::RESULT_QUEUE_EMPTY)
        {
           \WP_CLI::log('All Queues report processing has finished');

           return false;
        }
        elseif($combinedStatus == Queue::RESULT_PREPARING_DONE)
        {
           \WP_CLI::log(sprintf('Bulk Preparing is done. %s items. Use start command to signal ready. Use run to process after starting.', $results->total->stats->total));
					 return false;
        }

				$this->last_combinedStatus = $combinedStatus;

      //  if ($mediaResult->status !==)
      return true;
    }

		// Function for Showing JSON output of Optimizer regarding the process.
		protected function displayResult($result, $type, $counts = null)
		{
				$apiStatus = property_exists($result, 'apiStatus') ? $result->apiStatus : null;


					if ($apiStatus == ApiController::STATUS_SUCCESS)
					{
							\WP_CLI::line(' ');
							\WP_CLI::line('---------------------------------------');
							\WP_CLI::line(' ');
							\WP_CLI::line(' ' . $result->message); // testing

							 if (property_exists($result, 'improvements'))
							 {
								  $outputTable = array();
									$improvements = $result->improvements;

									if (isset($improvements['main']))
									{
										 $outputTable[] = array('name' => 'main', 'improvement' => $improvements['main'][0] .'%');
									}
										// \WP_CLI::Success( sprintf(__('Image optimized by %d %% ', 'shortpixel-image-optimiser'), $improvements['main'][0]));

									if (isset($improvements['thumbnails']))
									{
										foreach($improvements['thumbnails'] as $thumbName => $optData)
										{
											$outputTable[] = array('name' => $thumbName, 'improvement' => $optData[0] . '%');
										}
									}

									$outputTable[] = array('name' => ' ', 'improvement' => ' ');
									$outputTable[] = array('name' => __('Total', 'shortpixel-image-optimiser'), 'improvement' => $improvements['totalpercentage']. '%');

									\WP_CLI\Utils\format_items('table', $outputTable, array('name', 'improvement'));

									if (! is_null($counts))
									{
										 $baseMsg = sprintf(' This job, %d credit(s) were used. %d for images ', $counts->creditCount,
										 $counts->baseCount);

										 if ($counts->webpCount > 0)
										 	 $baseMsg .= sprintf(', %d for webps ', $counts->webpCount);
										if ( $counts->avifCount > 0)
											 $baseMsg .= sprintf(', %d for avifs ', $counts->avifCount);

										 \WP_CLI::line($baseMsg);
									}
									\WP_CLI::line(' ');
									\WP_CLI::line('---------------------------------------');
									\WP_CLI::line(' ');
							 }

				 } // success
				 else
				 {
					  if ($result->is_error)
						{
							\WP_CLI::error($result->message, false);
						}
						else {
							\WP_CLI::line($result->message);
						}
				 }

		}

		protected function displayStatsLine($name, $stats)
		{

				$line = sprintf('Current Status for %s : (%s\%s) Done (%s%%), %s awaiting %s errors --', $name, ($stats->done + $stats->fatal_errors), $stats->total, $stats->percentage_done, ( $stats->awaiting ), $stats->fatal_errors);

				\WP_CLI::line($line);
		}

	 /**
	 * Displays the current status of the processing queue(s)
	 *
	 * [--show-debug]
	 * :  Dumps more information for debugging purposes
	 * ---
	 *
	 * ## EXAMPLES
	 *
	 *   wp spio [bulk] status [--show-debug]
	 *
	 */
		public function status($args, $assoc)
		{

				$queue = $this->getQueueArgument($assoc);
				$startupData = $this->getStatus();


				$items = array();
				$fields = array('queue name', 'in queue', 'in process', 'fatal errors', 'done', 'total', 'preparing', 'running', 'finished');

				foreach($queue as $queue_name)
				{
					  	//$Q = $optimizeController->getQueue($queue_name);
							$stats = $startupData->$queue_name->stats;

							$item = array(
									'queue name' => $queue_name,
									'in queue' => $stats->in_queue,
									'in process' => $stats->in_process,
									'fatal errors' => $stats->fatal_errors,
									'done' => $stats->done,
									'total' => $stats->total,
									'preparing' => ($stats->is_preparing) ? __('Yes', 'shortpixel-image-optimiser') : __('No', 'shortpixel-image-optimiser'),
									'running' => ($stats->is_running) ? __('Yes', 'shortpixel-image-optimiser') : __('No', 'shortpixel-image-optimiser'),
									'finished' => ($stats->is_finished) ? __('Yes', 'shortpixel-image-optimiser') : __('No', 'shortpixel-image-optimiser'),
							);

							$items[] = $item;

							if (isset($assoc['show-debug']))
							{
								 print_r($stats);
							}
				}

				\WP_CLI::Line("--- Current Status ---");
				\WP_CLI\Utils\format_items('table', $items, $fields);
				\WP_CLI::Line($this->displayStatsLine('Total', $startupData->total->stats));
		}

	 /**
	 * Displays the key settings that are applied when executing commands with WP-CLI.
	 *
	 *
   * ---
   *
   * ## EXAMPLES
   *
   *   wp spio [bulk] settings
   *
	 */
		public function settings()
		{
			  $settings = \WPspio()->settings();

				$items = array();
				$fields = array('setting', 'value');

				$items[] = array('setting' => 'Compression', 'value' => UiHelper::compressionTypeToText($settings->compressionType));
				$items[] = array('setting' => 'Image Backup', 'value' => $this->textBoolean($settings->backupImages, true));
				$items[] = array('setting' => 'Processed Thumbnails', 'value' => $this->textBoolean($settings->processThumbnails, true));
				$items[] = array('setting' => ' ', 'value' => ' ');
				$items[] = array('setting' => 'Creates Webp', 'value' => $this->textBoolean($settings->createWebp));
				$items[] = array('setting' => 'Creates Avif', 'value' =>  $this->textBoolean($settings->createAvif));

				\WP_CLI\Utils\format_items('table', $items, $fields);
		}

		/**
		* Clears the Queue(s)
		*
		*
		* [--queue=<name>]
		* : Either 'media' or 'custom'. Omit the parameter to clear both queues.
		* ---
		* default: media,custom
		* options:
		*   - media
		*   - custom
		*
		* ## EXAMPLES
		*
		*   wp spio [bulk] clear
		*/
		public function clear($args, $assoc)
		{
			  $queues = $this->getQueueArgument($assoc);
				$optimizeController = $this->getOptimizeController();

				foreach($queues as $type)
				{
					$queue = $optimizeController->getQueue($type);
					$queue->resetQueue();
				}

				\WP_CLI::Success(__('Queue(s) cleared', 'shortpixel-image-optimiser'));

		}

    //  Colored is buggy, so off for now -> https://github.com/wp-cli/php-cli-tools/issues/134
		private function textBoolean($bool, $colored = false)
		{
			 	$colored = false;
				$values = array('','');

				if ($bool)
				{
					if ($colored)
					{
						$values = array('%g', '%n');
					}
					$res =  vsprintf(__('%sYes%s', 'shortpixel-image-optimiser'), $values);
					if ($colored)
						$res = \WP_CLI::colorize($res);
				}
				else
				{
					if ($colored)
					{
						$values = array('%r', '');
					}
					$res = vsprintf(__('%sNo%s', 'shortpixel-image-optimiser'), $values);
					if ($colored)
							$res = \WP_CLI::colorize($res);
				}

				return $res;
		}

		protected function getStatus()
		{
				$optimizeController = $this->getOptimizeController();
 				$startupData = $optimizeController->getStartupData();
				return $startupData;

		}

		protected function showResponses()
		{
				return false; // @todo Pending responseControl, offf.

         /*$responses = ResponseController::getAll();

         foreach ($responses as $response)
         {
             if ($response->is('error'))
                \WP_CLI::Error($response->message, false);
             elseif ($response->is('success'))
                \WP_CLI::Success($response->message);
             else
               \WP_CLI::line($response->message);
         } */
		}

		protected function getQueueArgument($assoc)
		{

	        if (isset($assoc['queue']))
	        {
	          if (strpos($assoc['queue'], ',') !== false)
	          {
	              $queue = explode(',', $assoc['queue']);
	              $queue = array_map('sanitize_text_field', $queue);
	          }
	          else
	            $queue = array(sanitize_text_field($assoc['queue']));
	        }
	        else
	          $queue = array('media', 'custom');

				return $queue;
		}

		// To ensure the bulk switch is ok.
		protected function getOptimizeController()
		{
						$optimizeController = new OptimizeController();
						return $optimizeController;
		}

		private function unFormatNumber($string)
		{
			 $string = str_replace(',', '', $string);
			 $string = str_replace('.', '', $string);

			 return $string;
		}

} // Class SpioCommandBase
