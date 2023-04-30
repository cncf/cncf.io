<?php
namespace ShortPixel\Controller;
use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;
use ShortPixel\Notices\NoticeController as Notices;
use ShortPixel\Controller\Queue\Queue as Queue;

use \ShortPixel\ShortPixelPng2Jpg as ShortPixelPng2Jpg;
use ShortPixel\Model\Converter\Converter as Converter;
use ShortPixel\Model\Converter\ApiConverter as ApiConverter;

use ShortPixel\Model\AccessModel as AccessModel;


/* AdminController is meant for handling events, hooks, filters in WordPress where there is *NO* specific or more precise  ShortPixel Page active.
*
* This should be a delegation class connection global hooks and such to the best shortpixel handler.
*/
class AdminController extends \ShortPixel\Controller
{
    protected static $instance;

		private static $preventUploadHook = array();

    public function __construct()
    {

    }

    public static function getInstance()
    {
      if (is_null(self::$instance))
          self::$instance = new AdminController();

      return self::$instance;
    }

    /** Handling upload actions
    * @hook wp_generate_attachment_metadata
    */
    public function handleImageUploadHook($meta, $id)
    {

        // Media only hook
				if ( in_array($id, self::$preventUploadHook))
				{
					 return $meta;
				}

// todo add check here for mediaitem
			  $fs = \wpSPIO()->filesystem();
				$fs->flushImageCache(); // it's possible file just changed by external plugin.
        $mediaItem = $fs->getImage($id, 'media');

				if ($mediaItem === false)
				{
					 Log::addError('Handle Image Upload Hook triggered, by error in image :' . $id );
					 return $meta;
				}

				if ($mediaItem->getExtension()  == 'pdf')
				{
					$settings = \wpSPIO()->settings();
					if (! $settings->optimizePdfs)
					{
						 Log::addDebug('Image Upload Hook detected PDF, which is turned off - not optimizing');
						 return $meta;
					}
				}

				if ($mediaItem->isProcessable())
				{
					$converter = Converter::getConverter($mediaItem, true);
					if (is_object($converter) && $converter->isConvertable())
					{
							$args = array('runReplacer' => false);

						 	$converter->convert($args);
							$mediaItem = $fs->getImage($id, 'media');
							$meta = $converter->getUpdatedMeta();
					}

        	$control = new OptimizeController();
        	$control->addItemToQueue($mediaItem);
				}
				else {
					Log::addWarn('Passed mediaItem is not processable', $mediaItem);
				}
        return $meta; // It's a filter, otherwise no thumbs
    }

		public function preventImageHook($id)
		{
			  self::$preventUploadHook[] = $id;
		}

		// Placeholder function for heic and such, return placeholder URL in image to help w/ database replacements after conversion.
		public function checkPlaceHolder($url, $post_id)
		{
			 if (false === strpos($url, 'heic'))
			 	 return $url;

			$extension = pathinfo($url,  PATHINFO_EXTENSION);
			if (false === in_array($extension, ApiConverter::CONVERTABLE_EXTENSIONS))
			{
				 return $url;
			}

			$fs = \wpSPIO()->filesystem();
			$mediaImage = $fs->getImage($post_id, 'media');

			if (false === $mediaImage)
			{
				 return $url;
			}

			if (false === $mediaImage->getMeta()->convertMeta()->hasPlaceholder())
			{
				return $url;
			}

			$url = str_replace($extension, 'jpg', $url);

			return $url;
		}

		public function processQueueHook($args = array())
		{
				$defaults = array(
					'wait' => 3, // amount of time to wait for next round. Prevents high loads
					'run_once' => false, //  If true queue must be run at least every few minutes. If false, it tries to complete all.
					'queues' => array('media','custom'),
					'bulk' => false,
				);

				if (wp_doing_cron())
				{
					 $this->loadCronCompat();
				}

				$args = wp_parse_args($args, $defaults);

			  $control = new OptimizeController();
				if ($args['bulk'] === true)
				{
					 $control->setBulk(true);
				}

			 	if ($args['run_once'] === true)
				{
					 return	$control->processQueue($args['queues']);
				}

				$running = true;
				$i = 0;

				while($running)
				{
							 	$results = $control->processQueue($args['queues']);
								$running = false;

								foreach($args['queues'] as $qname)
								{
									  if (property_exists($results, $qname))
										{
											  $result = $results->$qname;
												// If Queue is not completely empty, there should be something to do.
												if ($result->qstatus != QUEUE::RESULT_QUEUE_EMPTY)
												{
													 $running = true;
													 continue;
												}
										}
								}

							sleep($args['wait']);
				}


		}

		// WP functions that are not loaded during Cron Time.
		protected function loadCronCompat()
		{
			  if (! function_exists('download_url'))
				{
					 include(ABSPATH . "wp-admin/includes/admin.php");
				}
		}


    /**
		* When replacing happens.
    * @hook wp_handle_replace
		* @integration Enable Media Replace
    */
    public function handleReplaceHook($params)
    {
      if(isset($params['post_id'])) { //integration with EnableMediaReplace - that's an upload for replacing an existing ID

          $post_id = intval($params['post_id']);
          $fs = \wpSPIO()->filesystem();

          $imageObj = $fs->getImage($post_id, 'media');
          $imageObj->onDelete();
      }

    }

		/** This function is bound to enable-media-replace hook and fire when a file was replaced
		*
		*
		*/
		public function handleReplaceEnqueue($target, $source, $post_id)
		{
		/*		$fs = \wpSPIO()->filesystem();
        $imageObj = $fs->getImage($post_id, 'media');
				$optimizeController = new OptimizeController();
				$optimizeController->addItemToQueue($imageObj); */

				// Delegate this to the hook, so all checks are done there.
				$this->handleImageUploadHook(array(), $post_id);

		}

    public function generatePluginLinks($links) {
        $in = '<a href="options-general.php?page=wp-shortpixel-settings">Settings</a>';
        array_unshift($links, $in);
        return $links;
    }

    /** Allow certain mime-types if we will be using those.
    *
    */
    public function addMimes($mimes)
    {
        $settings = \wpSPIO()->settings();
        if ($settings->createWebp)
        {
            if (! isset($mimes['webp']))
              $mimes['webp'] = 'image/webp';
        }
        if ($settings->createAvif)
        {
            if (! isset($mimes['avif']))
              $mimes['avif'] = 'image/avif';
        }

				if (! isset($mimes['heic']))
				{
					$mimes['heic'] = 'image/heic';
				}

				if (! isset($mimes['heif']))
				{
					$mimes['heif'] = 'image/heif';
				}

        return $mimes;
    }

    /** When an image is deleted
    * @hook delete_attachment
    * @param int $post_id  ID of Post
    * @return itemHandler ItemHandler object.
    */
    public function onDeleteAttachment($post_id) {
        Log::addDebug('onDeleteImage - Image Removal Detected ' . $post_id);
        $result = null;
        $fs = \wpSPIO()->filesystem();

        try
        {
          $imageObj = $fs->getImage($post_id, 'media');
					//Log::addDebug('OnDelete ImageObj', $imageObj);
          if ($imageObj !== false)
            $result = $imageObj->onDelete();
        }
        catch(\Exception $e)
        {
          Log::addError('OndeleteImage triggered an error. ' . $e->getMessage(), $e);
        }
        return $result;
    }



    /** Displays an icon in the toolbar when processing images
    *   hook - admin_bar_menu
    *  @param Obj $wp_admin_bar
    */
    public function toolbar_shortpixel_processing( $wp_admin_bar ) {

        if (! \wpSPIO()->env()->is_screen_to_use )
          return; // not ours, don't load JS and such.

        $settings = \wpSPIO()->settings();
        $access = AccessModel::getInstance();
				$quotaController = QuotaController::getInstance();

        $extraClasses = " shortpixel-hide";
        /*translators: toolbar icon tooltip*/
        $id = 'short-pixel-notice-toolbar';
        $tooltip = __('ShortPixel optimizing...','shortpixel-image-optimiser');
        $icon = "shortpixel.png";
        $successLink = $link = admin_url(current_user_can( 'edit_others_posts')? 'upload.php?page=wp-short-pixel-bulk' : 'upload.php');
        $blank = "";

        if($quotaController->hasQuota() === false)
				{
            $extraClasses = " shortpixel-alert shortpixel-quota-exceeded";
            /*translators: toolbar icon tooltip*/
            $id = 'short-pixel-notice-exceed';
            $tooltip = '';

            if ($access->userIsAllowed('quota-warning'))
            {
              $exceedTooltip = __('ShortPixel quota exceeded. Click for details.','shortpixel-image-optimiser');
              //$link = "http://shortpixel.com/login/" . $this->_settings->apiKey;
              $link = "options-general.php?page=wp-shortpixel-settings";
            }
            else {
              $exceedTooltip = __('ShortPixel quota exceeded. Click for details.','shortpixel-image-optimiser');
              //$link = "http://shortpixel.com/login/" . $this->_settings->apiKey;
              $link = false;
            }
        }

        $args = array(
                'id'    => 'shortpixel_processing',
                'title' => '<div id="' . $id . '" title="' . $tooltip . '"><span class="stats hidden">0</span><img alt="' . __('ShortPixel icon','shortpixel-image-optimiser') . '" src="'
                         . plugins_url( 'res/img/'.$icon, SHORTPIXEL_PLUGIN_FILE ) . '" success-url="' . $successLink . '"><span class="shp-alert">!</span>'
                         . '<div class="controls">
                              <span class="dashicons dashicons-controls-pause pause" title="' . __('Pause', 'shortpixel-image-optimiser') . '">&nbsp;</span>
                              <span class="dashicons dashicons-controls-play play" title="' . __('Resume', 'shortpixel-image-optimiser') . '">&nbsp;</span>
                            </div>'

                         .'<div class="cssload-container"><div class="cssload-speeding-wheel"></div></div></div>',
    //            'href'  => 'javascript:void(0)', // $link,
                'meta'  => array('target'=> $blank, 'class' => 'shortpixel-toolbar-processing' . $extraClasses)
        );
        $wp_admin_bar->add_node( $args );

        if($quotaController->hasQuota() === false)
				{
            $wp_admin_bar->add_node( array(
                'id'    => 'shortpixel_processing-title',
                'parent' => 'shortpixel_processing',
                'title' => $exceedTooltip,
                'href'  => $link
            ));

        }
    }

} // class
