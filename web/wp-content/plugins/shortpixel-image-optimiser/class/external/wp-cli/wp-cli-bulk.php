<?php
namespace ShortPixel;
use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;
use ShortPixel\Controller\OptimizeController as OptimizeController;
use ShortPixel\Controller\BulkController as BulkController;

use ShortPixel\Controller\Queue\Queue as Queue;
use ShortPixel\Controller\ApiController as ApiController;
use ShortPixel\Controller\ResponseController as ResponseController;

/**
* Actions for running bulk operations from WP-CLI
*/
class SpioBulk extends SpioCommandBase
{
	   /**
	   * Starts the prepared queue(s). The bulk needs an express command to start processing.
		 * Once started, the queue(s) can be processed and finished with the run command.
	   *
	   * ## OPTIONS

	   * [--queue=<name>]
	   * : Either 'media' or 'custom'. Omit the parameter to start both queues.
	   * ---
	   * default: media,custom
	   * options:
	   *   - media
	   *   - custom
	   * ---
	   *
	   * ## EXAMPLES
	   *
	   * wp spio bulk start
	   *
	   *
	   * @when after_wp_load
	   */
	  public function start($args, $assoc)
	  {
			 $bulkControl = BulkController::getInstance();

			 $queue = $this->getQueueArgument($assoc);

			 foreach($queue as $qname)
			 {
			 	$result = $bulkControl->startBulk($qname);
			 }

			 \WP_CLI::Line('Start signal for Bulk Processing given.');

			// $this->run($args, $assoc);
	     //$controller = new OptimizeController();
	     //$result = $controller->startBulk();
	  }


	   /**
	   * Automatically Bulk Processes everything that needs to be done.
	   *
	   * [--queue=<name>]
	   * : Either 'media' or 'custom'. Omit the parameter to process both queues.
		 *
		 * [--limit=<num>]
		 * : Limit the amount of items being prepared.
		 *
	   * ---
	   * default: media,custom
	   * options:
	   *   - media
	   *   - custom
	   * ---
	   *
	   * ## EXAMPLES
	   *
	   * wp spio bulk auto
	   *
	   *
	   */
		public function auto($args, $assoc)
		{
			 	$queue = $this->getQueueArgument($assoc);
				$optimizeController = $this->getOptimizeController();

				$bulkControl = BulkController::getInstance();

				$running = true;
				$created = false;

				 $this->settings();
				 sleep(2); // user can digest settings

				while($running)
				{
						 	$data = $optimizeController->getStartupData();
							$combined = $data->total->stats;

							// Is_finished is no queue running.
							if ($combined->is_preparing)
							{
								\WP_CLI::line('[Auto Bulk] Preparing .. ');
								 $this->prepare($args, $assoc);
								 $this->start($args, $assoc);
								 \WP_CLI::line('Preparing Run done');
							}
							elseif ($combined->is_running)
							{
								\WP_CLI::line('Bulk Running ...');
								 $this->run($args, $assoc); // Run All
							}
							elseif ($combined->total > 0 && $combined->done == 0 && $combined->is_running == false && $combined->is_preparing == false && $combined->is_finished == false)
							{
								 \WP_CLI::line('[Auto Bulk] Starting to process');
								 $this->status($args, $assoc);
 								 $this->start($args, $assoc);
							}
						  elseif ($combined->is_finished)
							{
								  if ($combined->done > 0 || $created == true) // means we already ran the whole thing once.
									{
										\WP_CLI::Line('[Auto Bulk] Seems finished and done running');
										$running = false;

										$this->finishBulk($args, $assoc);

										break;
									}
									\WP_CLI::Line('[Auto Bulk] Creating New Queue');
									$this->create($args, $assoc);
									$created = true;
							}
							else
							{
								 \WP_CLI::error("[Auto Bulk] : Encountered nothing to do", true);
								 $running = false; // extra fallback
							}

				}


				\WP_CLI::log('Automatic Bulk ended');
				$this->status($args, $assoc);
		}

	 /**
	 * Creates the queue(s) for bulk optimization of media library and/or custom media items.
	 *
	 * ## OPTIONS
	 *
	 * [--queue=<name>]
	 * : Either 'media' or 'custom'. Omit the parameter to create both queues.
	 * ---
	 * default: media,custom
	 * options:
	 *   - media
	 *   - custom
	 * ---
	 *
	 * ## EXAMPLES
	 *
	 *  wp spio bulk create
	 *
	 *
	 * @when after_wp_load
	 */
	  public function create($args, $assoc)
	  {
	    $bulkControl = BulkController::getInstance();
	    $json = new \stdClass;
	    $json->media = new \stdClass;
	    $json->custom = new \stdClass;

			$queues = $this->getQueueArgument($assoc);

			foreach($queues as $qname)
			{
	    	$stats = $bulkControl->createNewBulk($qname);
	    	$json->$qname->stats = $stats;

				\WP_CLI::Line("Bulk $qname created. Ready to prepare");

			}

			$this->showResponses();
			return $stats;
	  }

	 /**
	 * ## OPTIONS
	 *
	 * <start-id>
	 * : ID to start restore
	 *
	 * <end-id>
	 * : ID to stop restore
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
	 * ## EXAMPLES
	 *
	 *   wp spio bulk restore 0 100
	 *
	 *
	 * @when after_wp_load
	 */
		/*public function restore($args, $assoc)
		{
				\WP_CLI::Line('Not yet implemented');
		} */


		protected function finishBulk($args, $assoc)
		{
		    $bulkControl = BulkController::getInstance();
	 			$queues = $this->getQueueArgument($assoc);

				foreach($queues as $queue_name)
				{
					 $bulkControl->finishBulk($queue_name);
				}

		}

		// To ensure the bulk switch is ok.
		protected function getOptimizeController()
		{
				$optimizeController = new OptimizeController();
				$optimizeController->setBulk(true);
				return $optimizeController;
		}

		/**
		* Prepares the items by adding them to the queue(s). It runs only when the queue is in the preparing phase and finishes when everything is prepared.
		*
		*
		* [--queue=<name>]
		* : Either 'media' or 'custom'. Omit the parameter to run both queues.
		* ---
		* default: media,custom
		* options:
		*   - media
		*   - custom
		* ---
		*
		* [--limit=<num>]
		* : Limit the amount of items being prepared.
		*
		* ## EXAMPLES
		*
		*   wp spio bulk prepare
		*
		*/
			public function prepare($args, $assoc)
			{
					 $queues = $this->getQueueArgument($assoc);
					 $optimizeController = $this->getOptimizeController();

						$data = $optimizeController->getStartupData();

						if (! $data->total->stats->is_preparing)
						{
							 \WP_CLI::Error("No queues have status preparing, aborting");
					//		 break;
						}
						else
						{
//							 $assoc['complete']  = true;
							 //$assoc['ticks']  = 5;
							 //$assoc['queue'] = $qname;
							 $assoc['wait'] = 0.5;
							 print_r($args); print_r($assoc);
							 $bool = $this->run($args, $assoc);
						}

						//$this->showResponses();
			}




} // CLASS
