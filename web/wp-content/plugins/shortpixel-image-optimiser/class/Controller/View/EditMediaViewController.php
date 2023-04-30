<?php
namespace ShortPixel\Controller\View;
use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;

use ShortPixel\Helper\UiHelper as UiHelper;
use ShortPixel\Controller\OptimizeController as OptimizeController;
use ShortPixel\Controller\ErrorController as ErrorController;


//use ShortPixel\Model\ImageModel as ImageModel;

// Future contoller for the edit media metabox view.
class EditMediaViewController extends \ShortPixel\ViewController
{
      protected $template = 'view-edit-media';
  //    protected $model = 'image';

      protected $post_id;
      protected $legacyViewObj;

      protected $imageModel;
      protected $hooked;

      public function __construct()
      {
        parent::__construct();
      }

      protected function loadHooks()
      {
            add_action( 'add_meta_boxes_attachment', array( $this, 'addMetaBox') );
            $this->hooked = true;
      }

      public function load()
      {
        if (! $this->hooked)
          $this->loadHooks();

					$fs = \wpSPIO()->filesystem();
					$fs->startTrustedMode();
      }

      public function addMetaBox()
      {
          add_meta_box(
              'shortpixel_info_box',          // this is HTML id of the box on edit screen
              __('ShortPixel Info', 'shortpixel-image-optimiser'),    // title of the box
              array( $this, 'doMetaBox'),   // function to be called to display the info
              null,//,        // on which edit screen the box should appear
              'side'//'normal',      // part of page where the box should appear
              //'default'      // priority of the box
          );
      }


      public function dometaBox($post)
      {
          $this->post_id = $post->ID;
					$this->view->debugInfo = array();
					$this->view->id = $this->post_id;
					$this->view->list_actions = '';

          $fs = \wpSPIO()->filesystem();
          $this->imageModel = $fs->getMediaImage($this->post_id);

					// Asking for something non-existing.
					if ($this->imageModel === false)
					{
						$this->view->status_message = __('File Error. This could be not an image or the file is missing', 'shortpixel-image-optimiser');

						$this->loadView();
						return false;
					}



          $this->view->status_message = null;

          $this->view->text = UiHelper::getStatusText($this->imageModel);
          $this->view->list_actions = UiHelper::getListActions($this->imageModel);
          if ( count($this->view->list_actions) > 0)
            $this->view->list_actions = UiHelper::renderBurgerList($this->view->list_actions, $this->imageModel);
          else
            $this->view->list_actions = '';

          $this->view->actions = UiHelper::getActions($this->imageModel);

          $this->view->stats = $this->getStatistics();

          if (! $this->userIsAllowed)
          {
            $this->view->actions = array();
            $this->view->list_actions = '';
          }

					// @todo remove this if not DEVMODE
          $this->view->debugInfo = $this->getDebugInfo();

          $this->loadView();
      }

      protected function getStatusMessage()
      {
          return UIHelper::renderSuccessText($this->imageModel);
      }

      protected function getStatistics()
      {
        //$data = $this->data;
        $stats = array();
        $imageObj = $this->imageModel;
        $did_keepExif = $imageObj->getMeta('did_keepExif');

				$did_convert = $imageObj->getMeta()->convertMeta()->isConverted();
        $resize = $imageObj->getMeta('resize');

				// Not optimized, not data.
				if (! $imageObj->isOptimized())
					return array();

        if ($did_keepExif)
          $stats[] = array(__('EXIF kept', 'shortpixel-image-optimiser'), '');
        elseif ( $did_keepExif === false) {
          $stats[] = array(__('EXIF removed', 'shortpixel-image-optimiser'), '');
        }

        if (true === $did_convert )
        {
					$ext = $imageObj->getMeta()->convertMeta()->getFileFormat();
          $stats[] = array(  sprintf(__('Converted from %s','shortpixel-image-optimiser'), $ext), '');
        }
				elseif (false !== $imageObj->getMeta()->convertMeta()->didTry()) {
					$ext = $imageObj->getMeta()->convertMeta()->getFileFormat();
					$error = $imageObj->getMeta()->convertMeta()->getError(); // error code.
					$stats[] = array(UiHelper::getConvertErrorReason($error, $ext), '');


				}

        if ($resize == true)
        {
            $from = $imageObj->getMeta('originalWidth') . 'x' . $imageObj->getMeta('originalHeight');
            $to  = $imageObj->getMeta('resizeWidth') . 'x' . $imageObj->getMeta('resizeHeight');
						$type = ($imageObj->getMeta('resizeType') !== null) ? '(' . $imageObj->getMeta('resizeType') . ')' : '';
            $stats[] = array(sprintf(__('Resized %s %s to %s'), $type, $from, $to), '');
        }

        $tsOptimized = $imageObj->getMeta('tsOptimized');
        if ($tsOptimized !== null)
          $stats[] = array(__("Optimized on :", 'shortpixel-image-optimiser') . "<br /> ", UiHelper::formatTS($tsOptimized) );

				if ($imageObj->isOptimized())
				{
					$stats[] = array( sprintf(__('%s %s Read more about theses stats %s ', 'shortpixel-image-optimiser'), '
					<p><img alt=' . esc_html('Info Icon', 'shortpixel-image-optimiser')  . ' src=' . esc_url( wpSPIO()->plugin_url('res/img/info-icon.png' )) . ' style="margin-bottom: -4px;"/>', '<a href="https://shortpixel.com/knowledge-base/article/553-the-stats-from-the-shortpixel-column-in-the-media-library-explained" target="_blank">', '</a></p>'), '');
				}

        return $stats;
      }

      protected function getDebugInfo()
      {
          if(! \wpSPIO()->env()->is_debug )
          {
            return array();
          }

          $meta = \wp_get_attachment_metadata($this->post_id);

          $fs = \wpSPIO()->filesystem();

					$imageObj = $this->imageModel;

					if ($imageObj->isProcessable())
					{
						 //$urls = $imageObj->getOptimizeUrls();
						 $optimizeData = $imageObj->getOptimizeData();
						 $urls = $optimizeData['urls'];

					}

					$thumbnails = $imageObj->get('thumbnails');
					$processable = ($imageObj->isProcessable()) ? '<span class="green">Yes</span>' : '<span class="red">No</span> (' . $imageObj->getReason('processable') . ')';
					$anyFileType = ($imageObj->isProcessableAnyFileType()) ? '<span class="green">Yes</span>' : '<span class="red">No</span>';
					$restorable = ($imageObj->isRestorable()) ? '<span class="green">Yes</span>' : '<span class="red">No</span> (' . $imageObj->getReason('restorable') . ')';

					$hasrecord = ($imageObj->hasDBRecord()) ? '<span class="green">Yes</span>' : '<span class="red">No</span> ';

          $debugInfo = array();
          $debugInfo[] = array(__('URL (get attachment URL)', 'shortpixel_image_optiser'), wp_get_attachment_url($this->post_id));
          $debugInfo[] = array(__('File (get attached)'), get_attached_file($this->post_id));

					if ($imageObj->is_virtual())
					{
						$debugInfo[] = array(__('Is Virtual true: '), $imageObj->getFullPath() );
					}

          $debugInfo[] = array(__('Size and Mime (ImageObj)'), $imageObj->get('width') . 'x' . $imageObj->get('height'). ' (' . $imageObj->get('mime') . ')');
          $debugInfo[] = array(__('Status (ShortPixel)'), $imageObj->getMeta('status') . ' '   );

					$debugInfo[] = array(__('Processable'), $processable);
					$debugInfo[] = array(__('Avif/Webp needed'), $anyFileType);
					$debugInfo[] = array(__('Restorable'), $restorable);
					$debugInfo[] = array(__('Record'), $hasrecord);

					if ($imageObj->getMeta()->convertMeta()->didTry())
					{
						 $debugInfo[] = array(__('Converted'), ($imageObj->getMeta()->convertMeta()->isConverted() ?'<span class="green">Yes</span>' : '<span class="red">No</span> '));
						 $debugInfo[] = array(__('Checksum'), $imageObj->getMeta()->convertMeta()->didTry());
						 $debugInfo[] = array(__('Error'), $imageObj->getMeta()->convertMeta()->getError());
					}

          $debugInfo[] = array(__('WPML Duplicates'), json_encode($imageObj->getWPMLDuplicates()) );

					if ($imageObj->getParent() !== false)
					{
						 $debugInfo[] = array(__('WPML duplicate - Parent: '), $imageObj->getParent());
					}

					if (isset($urls))
					{
						 $debugInfo[] = array(__('To Optimize URLS'),  $urls);
					}
					if (isset($optimizeData))
					{
						 $debugInfo[] = array(__('Optimize Data'), $optimizeData);

						 $optControl = new optimizeController();
						 $q = $optControl->getQueue($imageObj->get('type'));

						 $debugInfo[] = array(__('Image to Queue'), $q->_debug_imageModelToQueue($imageObj) );
					}

          $debugInfo['imagemetadata'] = array(__('ImageModel Metadata (ShortPixel)'), $imageObj);
					$debugInfo[] = array('', '<hr>');

          $debugInfo['wpmetadata'] = array(__('WordPress Get Attachment Metadata'), $meta );
					$debugInfo[] = array('', '<hr>');


						if ($imageObj->hasBackup())
            	$backupFile = $imageObj->getBackupFile();
						else {
							 $backupFile = $fs->getFile($fs->getBackupDirectory($imageObj) . $imageObj->getBackupFileName());
						}

            $debugInfo[] = array(__('Backup Folder'), (string) $backupFile->getFileDir() );
						if ($imageObj->hasBackup())
							$backupText = __('Backup File :');
						else {
							$backupText = __('Target Backup File after optimization (no backup) ');
						}
            $debugInfo[] = array( $backupText, (string) $backupFile . '(' . UiHelper::formatBytes($backupFile->getFileSize()) . ')' );

            $debugInfo[] =  array(__("No Main File Backup Available"), '');



					if ($imageObj->getMeta()->convertMeta()->isConverted())
					{
							$convertedBackup = ($imageObj->hasBackup(array('forceConverted' => true))) ? '<span class="green">Yes</span>' : '<span class="red">No</span>';
							$backup = $imageObj->getBackupFile(array('forceConverted' => true));
						 $debugInfo[] = array('Has converted backup', $convertedBackup);
						 if (is_object($backup))
						 	$debugInfo[] = array('Backup: ', $backup->getFullPath() );
				}

          if ($or = $imageObj->hasOriginal())
          {
             $original = $imageObj->getOriginalFile();
             $debugInfo[] = array(__('Has Original File: '), $original->getFullPath()  . '(' . UiHelper::formatBytes($original->getFileSize()) . ')');
             $orbackup = $original->getBackupFile();
             if ($orbackup)
              $debugInfo[] = array(__('Has Backup Original Image'), $orbackup->getFullPath() . '(' . UiHelper::formatBytes($orbackup->getFileSize()) . ')');
						$debugInfo[] = array('', '<hr>');

          }


          if (! isset($meta['sizes']) )
          {
             $debugInfo[] = array('',  __('Thumbnails were not generated', 'shortpixel-image-optimiser'));
          }
          else
          {
            foreach($thumbnails as $thumbObj)
            {
							$size = $thumbObj->get('size');

              $display_size = ucfirst(str_replace("_", " ", $size));
              //$thumbObj = $imageObj->getThumbnail($size);

              if ($thumbObj === false)
              {
                $debugInfo[] =  array(__('Thumbnail not found / loaded: ', 'shortpixel-image-optimiser'), $size );
                continue;
              }

              $url = $thumbObj->getURL(); //$fs->pathToURL($thumbObj); //wp_get_attachment_image_src($this->post_id, $size);
              $filename = $thumbObj->getFullPath();

							$backupFile = $thumbObj->getBackupFile();
							if ($thumbObj->hasBackup())
							{
								$backup = $backupFile->getFullPath();
								$backupText = __('Backup File :');
							}
							else {
								$backupFile = $fs->getFile($fs->getBackupDirectory($thumbObj) . $thumbObj->getBackupFileName());
								$backup = $backupFile->getFullPath();
								$backupText = __('Target Backup File after optimization (no backup) ');
							}

              $width = $thumbObj->get('width');
              $height = $thumbObj->get('height');

					$processable = ($thumbObj->isProcessable()) ? '<span class="green">Yes</span>' : '<span class="red">No</span> (' . $thumbObj->getReason('processable') . ')';
					$restorable = ($thumbObj->isRestorable()) ? '<span class="green">Yes</span>' : '<span class="red">No</span> (' . 		$thumbObj->getReason('restorable') . ')';
					$hasrecord = ($thumbObj->hasDBRecord()) ? '<span class="green">Yes</span>' : '<span class="red">No</span> ';

					$dbid = $thumbObj->getMeta('databaseID');

              $debugInfo[] = array('', "<div class='$size previewwrapper'><img src='" . $url . "'><p class='label'>
							<b>URL:</b> $url ( $display_size - $width X $height ) <br><b>FileName:</b>  $filename <br> <b> $backupText </b> $backup </p>
							<p><b>Processable: </b> $processable <br> <b>Restorable:</b>  $restorable <br> <b>Record:</b> $hasrecord ($dbid) </p>
							<hr></div>");
            }
          }
          return $debugInfo;
      }



} // controller .
