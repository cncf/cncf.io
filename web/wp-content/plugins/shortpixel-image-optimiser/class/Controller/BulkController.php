<?php
namespace ShortPixel\Controller;

use ShortPixel\Controller\Queue\MediaLibraryQueue as MediaLibraryQueue;
use ShortPixel\Controller\Queue\CustomQueue as CustomQueue;
use ShortPixel\Controller\Queue\Queue as Queue;
use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;

// Class for controlling bulk and reporting.
class BulkController
{
   protected static $instance;
   protected static $logName = 'shortpixel-bulk-logs';

   public function __construct()
   {

   }

   public static function getInstance()
   {
      if ( is_null(self::$instance))
         self::$instance = new BulkController();

     return self::$instance;
   }

   /** Create a new bulk, enqueue items for bulking
   * @param $type String media or custom is supported.
   * @param $customOp String   Not a usual optimize queue, but something else. options:
   * 'bulk-restore', or 'migrate'.
   */
   public function createNewBulk($type = 'media', $customOp = null)
   {
   //  $this->q->createNewBulk();
      $optimizeController = new OptimizeController();
      $optimizeController->setBulk(true);

			$fs = \wpSPIO()->filesystem();
			$backupDir = $fs->getDirectory(SHORTPIXEL_BACKUP_FOLDER);
			$current_log = $fs->getFile($backupDir->getPath() . 'current_bulk_' . $type . '.log');

			// When starting new bulk remove any open 'current logs';
			if ($current_log->exists() && $current_log->is_writable())
			{
				 $current_log->delete();
			}

      $Q = $optimizeController->getQueue($type);

      $Q->createNewBulk();

			$Q = $optimizeController->getQueue($type);

      if (! is_null($customOp))
      {
        $options = array();
        if ($customOp == 'bulk-restore')
        {
          $options['numitems'] = 5;
          $options['retry_limit'] = 5;
          $options['process_timeout'] = 3000;
        }
        if ($customOp == 'migrate' || $customOp == 'removeLegacy')
        {
           $options['numitems'] = 200;

        }
        $Q->setCustomBulk($customOp, $options);
      }

      return $Q->getStats();
   }

	 public function isBulkRunning($type = 'media')
	 {
       $optimizeControl = new OptimizeController();
       $optimizeControl->setBulk(true);

		   $queue = $optimizeControl->getQueue($type);

			 $stats = $queue->getStats();

			 if ( $stats->is_finished === false && $stats->total > 0)
			 {
			 	return true;
		 	 }
			 else
			 {
			 	return false;
			}
	 }

	 public function isAnyBulkRunning()
	 {
		   $bool = $this->isBulkRunning('media');
			 if ($bool === false)
			 {
				   $bool = $this->isBulkRunning('custom');
			 }

			 return $bool;
	 }

   /*** Start the bulk run. Must deliver all queues at once due to processQueue bundling */
   public function startBulk($types = 'media')
   {
       $optimizeControl = new OptimizeController();
       $optimizeControl->setBulk(true);

			 if (! is_array($types))
			 	 $types = array($types);

			 foreach($types as $type)
			 {
	       $q = $optimizeControl->getQueue($type);
	       $q->startBulk();
			 }

       return $optimizeControl->processQueue($types);
   }

   public function finishBulk($type = 'media')
   {
     $optimizeControl = new OptimizeController();
     $optimizeControl->setBulk(true);

     $q = $optimizeControl->getQueue($type);

		 $this->addLog($q);

		 $op = $q->getCustomDataItem('customOperation');

		 // When finishing, remove the Legacy Notice
		 if ($op == 'migrate')
		 {
			 	AdminNoticesController::resetLegacyNotice();
		 }

     $q->resetQueue();
   }

   public function getLogs()
   {
        $logs = get_option(self::$logName, array());
        return $logs;
   }

	 public function getLog($logName)
	 {
  		 $fs = \wpSPIO()->filesystem();
			 $backupDir = $fs->getDirectory(SHORTPIXEL_BACKUP_FOLDER);

			 $log = $fs->getFile($backupDir->getPath() . $logName);
			 if ($log->exists())
			 	 return $log;
			 else
			 	return false;
	 }

	 public function getLogData($fileName)
	 {
		 		$logs = $this->getLogs();

				foreach($logs as $log)
				{
					 if (isset($log['logfile']) && $log['logfile'] == $fileName)
					 	 return $log;
				}

				return false;
	 }

   protected function addLog($q)
   {
        //$data = (array) $stats;
				$stats = $q->getStats(); // for the log
				$type = $q->getType();
			//	$customData = $q->getCustomDataItem('');

        if ($stats->done == 0 && $stats->fatal_errors == 0)
				{
          return; // nothing done, don't log
				}

        $data['processed'] = $stats->done;
        $data['not_processed'] = $stats->in_queue;
        $data['errors'] = $stats->errors;
        $data['fatal_errors'] = $stats->fatal_errors;

				$webpcount = $q->getCustomDataItem('webpcount');
				$avifcount = $q->getCustomDataItem('avifcount');
				$basecount = $q->getCustomDataItem('basecount');

				if (property_exists($stats, 'images'))
					$data['total_images'] = $stats->images->images_done;

        $data['type'] = $type;
				if ($q->getCustomDataItem('customOperation'))
				{
					$data['operation'] = $q->getCustomDataItem('customOperation');
				}
        $data['date'] = time();

        $logs = $this->getLogs();
        $fs = \wpSPIO()->filesystem();
        $backupDir = $fs->getDirectory(SHORTPIXEL_BACKUP_FOLDER);

        if (count($logs) == 10) // remove logs if more than 10.
        {
          $log = array_shift($logs);
          //$log_date = $log['date'];
					//$log_type = $log['type'];
					if (isset($data['logfile']))
					{
						$logfile = $data['logfile'];

	          $fileLog = $fs->getFile($backupDir->getPath() . $logfile);
	          if ($fileLog->exists())
	            $fileLog->delete();
					}
        }

        $fileLog = $fs->getFile($backupDir->getPath() . 'current_bulk_' . $type . '.log');
        $moveLog = $fs->getFile($backupDir->getPath() . 'bulk_' . $type. '_' . $data['date'] . '.log');

        if ($fileLog->exists())
          $fileLog->move($moveLog);

				$data['logfile'] = 'bulk_' . $type . '_' . $data['date'] . '.log';
        $logs[] = $data;

        $this->saveLogs($logs);
   }

   protected function saveLogs($logs)
   {
        if (is_array($logs) && count($logs) > 0)
          update_option(self::$logName, $logs, false);
        else
          delete_option(self::$logName);
   }

	 // Removes Bulk Log .
   public static function uninstallPlugin()
   {
      delete_option(self::$logName);
   }

}  // class
