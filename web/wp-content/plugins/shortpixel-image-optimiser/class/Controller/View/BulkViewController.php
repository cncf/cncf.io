<?php
namespace ShortPixel\Controller\View;
use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;
use ShortPixel\Notices\NoticeController as Notices;

use ShortPixel\Controller\AdminNoticesController as AdminNoticesController;
use ShortPixel\Controller\ApiKeyController as ApiKeyController;
use ShortPixel\Controller\QuotaController as QuotaController;
use Shortpixel\Controller\OptimizeController as OptimizeController;
use ShortPixel\Controller\BulkController as BulkController;
use ShortPixel\Controller\StatsController as StatsController;
use ShortPixel\Controller\OtherMediaController as OtherMediaController;
use ShortPixel\Helper\UiHelper as UiHelper;

use ShortPixel\Model\AccessModel as AccessModel;


class BulkViewController extends \ShortPixel\ViewController
{

  protected $form_action = 'sp-bulk';
  protected $template = 'view-bulk';

  protected $quotaData;
  protected $pendingMeta;
  protected $selected_folders = array();


  public function load()
  {
    $quota = QuotaController::getInstance();
    $optimizeController = new OptimizeController();

    $this->view->quotaData = $quota->getQuota();

    $this->view->stats = $optimizeController->getStartupData();
    $this->view->approx = $this->getApproxData();

    $this->view->logHeaders = array(__('Images', 'shortpixel_image_optimiser'), __('Errors', 'shortpixel_image_optimizer'), __('Date', 'shortpixel_image_optimizer'));
    $this->view->logs = $this->getLogs();

    $keyControl = ApiKeyController::getInstance();

    $this->view->error = false;

    if ( ! $keyControl->keyIsVerified() )
    {
        $adminNoticesController = AdminNoticesController::getInstance();

        $this->view->error = true;
        $this->view->errorTitle = __('Missing API Key', 'shortpixel_image_optimiser');
        $this->view->errorContent = $this->getActivationNotice();
        $this->view->showError = 'key';
    }
    elseif ( ! $quota->hasQuota())
    {
        $this->view->error = true;
        $this->view->errorTitle = __('Quota Exceeded','shortpixel-image-optimiser');
        $this->view->errorContent = __('Can\'t start the Bulk Process due to lack of credits.', 'shortpixel-image-optimiser');
        $this->view->errorText = __('Please check or add quota and refresh the page', 'shortpixel-image-optimiser');
        $this->view->showError = 'quota';

    }

		$this->view->mediaErrorLog = $this->loadCurrentLog('media');
		$this->view->customErrorLog = $this->loadCurrentLog('custom');

		$this->view->buyMoreHref = 'https://shortpixel.com/' . ($keyControl->getKeyForDisplay() ? 'login/' . $keyControl->getKeyForDisplay() . '/spio-unlimited' : 'pricing');



    $this->loadView();

  }

	// Double with ApiNotice . @todo Fix.
	protected function getActivationNotice()
	{
		$message = "<p>" . __('In order to start the optimization process, you need to validate your API Key in the '
						. '<a href="options-general.php?page=wp-shortpixel-settings">ShortPixel Settings</a> page in your WordPress Admin.','shortpixel-image-optimiser') . "
		</p>
		<p>" .  __('If you don’t have an API Key, just fill out the form and a key will be created.','shortpixel-image-optimiser') . "</p>";
		return $message;
	}

  protected function getApproxData()
  {
		$otherMediaController = OtherMediaController::getInstance();

    $approx = new \stdClass; // guesses on basis of the statsController SQL.
    $approx->media = new \stdClass;
    $approx->custom = new \stdClass;
    $approx->total = new \stdClass;

    $sc = StatsController::getInstance();
    $sc->reset(); // Get a fresh stat.

    $excludeSizes = \wpSPIO()->settings()->excludeSizes;


    $approx->media->items = $sc->find('media', 'itemsTotal') - $sc->find('media', 'items');

    // ThumbsTotal - Approx thumbs in installation - Approx optimized thumbs (same query)
    $approx->media->thumbs = $sc->find('media', 'thumbsTotal') - $sc->find('media', 'thumbs');

    // If sizes are excluded, remove this count from the approx.
    if (is_array($excludeSizes) && count($excludeSizes) > 0)
      $approx->media->thumbs = $approx->media->thumbs - ($approx->media->items * count($excludeSizes));

    // Total optimized items + Total optimized (approx) thumbnails
    $approx->media->total = $approx->media->items + $approx->media->thumbs;


    $approx->custom->images = $sc->find('custom', 'itemsTotal') - $sc->find('custom', 'items');
		$approx->custom->has_custom = $otherMediaController->hasCustomImages();

    $approx->total->images = $approx->media->total + $approx->custom->images; // $sc->totalImagesToOptimize();

		$approx->media->isLimited = $sc->find('media', 'isLimited');

		// Prevent any guesses to go below zero.
		foreach($approx->media as $item => $value)
		{
				if (is_numeric($value))
			  	$approx->media->$item = max($value, 0);
		}
		foreach($approx->total as $item => $value)
		{
				if (is_numeric($value))
					$approx->total->$item = max($value, 0);
		}
    return $approx;

  }

	/* Function to check for and load the current Log.  This can be present on load time when the bulk page is refreshed during operations.
	*  Reload the past error and display them in the error box.
	* @param String $type  media or custom
	*/
	protected function loadCurrentLog($type = 'media')
	{
		$bulkController = BulkController::getInstance();

		$log = $bulkController->getLog('current_bulk_' . $type . '.log');

		if ($log == false)
			return false;

		 $content = $log->getContents();
		 $lines = array_filter(explode(';', $content));

		 $output = '';

		 foreach ($lines as $line)
		 {
			 	$cells = array_filter(explode('|', $line));

				if (count($cells) == 1)
					continue; // empty line.

				$date = $filename = $message = $item_id = false;

				$date = $cells[0];
				$filename = isset($cells[1]) ? $cells[1] : false;
				$item_id = isset($cells[2]) ? $cells[2] : false;
				$message = isset($cells[3]) ? $cells[3] : false;

				$kblink = UIHelper::getKBSearchLink($message);
				$kbinfo = '<span class="kbinfo"><a href="' . $kblink . '" target="_blank" ><span class="dashicons dashicons-editor-help">&nbsp;</span></a></span>';



				$output .= '<div class="fatal">';
				$output .= $date . ': ';
				if ($message)
					$output .= $message;
				if ($filename)
					$output .= ' ( '. __('in file ','shortpixel-image-optimiser') . ' ' . $filename . ' ) ' . $kbinfo;

				$output .= '</div>';
		 }


		 return $output;
	}

  public function getLogs()
  {
      $bulkController = BulkController::getInstance();
      $logs = $bulkController->getLogs();
      $fs = \wpSPIO()->filesystem();
      $backupDir = $fs->getDirectory(SHORTPIXEL_BACKUP_FOLDER);

      $view = array();

      foreach($logs as $logData)
      {


          $logFile = $fs->getFile($backupDir->getPath() . 'bulk_' . $logData['type'] . '_' . $logData['date'] . '.log');
          $errors = $logData['fatal_errors'];

          if ($logFile->exists())
					{
            $errors = '<a data-action="OpenLog" data-file="' . $logFile->getFileName() . '" href="' . $fs->pathToUrl($logFile) . '">' . $errors . '</a>';
					}

					$op = (isset($logData['operation'])) ? $logData['operation'] : false;

					// BulkName is just to compile a user-friendly name for the operation log.
					$bulkName = '';

					switch($logData['type'])
					{
						 case 'custom':
						 	$bulkName = __('Custom Media Bulk', 'shortpixel-image-optimiser');
						 break;
						 case 'media':
						 	$bulkName = __('Media Library Bulk', 'shortpixel-image-optimiser');
						 break;

					}

					$bulkName  .= ' '; // add a space.

					switch($op)
					{
							 case 'bulk-restore':
							 		 $bulkName .= __('Restore', 'shortpixel-image-optimiser');
							 break;
							 case 'migrate':
							 		 $bulkName .= __('Migrate old Metadata', 'shortpixel-image-optimiser');
							 break;
							 case 'removeLegacy':
								$bulkName = __('Remove Legacy Data', 'shortpixel-image-optimiser');
							 break;
							 default:
							 	 	 $bulkName .= __('Optimization', 'shortpixel-image-optimiser');
							 break;
					}

					$images = isset($logData['total_images']) ? $logData['total_images'] : $logData['processed'];

          $view[] = array('type' => $logData['type'], 'images' => $images, 'errors' => $errors, 'date' => UiHelper::formatTS($logData['date']), 'operation' => $op, 'bulkName' => $bulkName);

      }

      krsort($view);

      return $view;
  }

} // class
