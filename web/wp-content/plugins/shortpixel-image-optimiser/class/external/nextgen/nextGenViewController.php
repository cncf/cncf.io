<?php
namespace ShortPixel;
use ShortPixel\Notices\NoticeController as Notice;
use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;

use ShortPixel\Helper\UiHelper as UiHelper;
use ShortPixel\Controller\OtherMediaController as OtherMediaController;

/* Class for View integration in the Nextgen gallery */
class NextGenViewController extends \ShortPixel\ViewController
{
  protected static $nggColumnIndex = 0;

  protected $template = 'view-list-media';


   protected function hooks()
   {

   }

   public function nggColumns( $defaults ) {
       self::$nggColumnIndex = count($defaults) + 1;
  /*     add_filter( 'ngg_manage_images_column_' . self::$nggColumnIndex . '_header', array( '\ShortPixel\nextGenViewController', 'nggColumnHeader' ) );
       add_filter( 'ngg_manage_images_column_' . self::$nggColumnIndex . '_content', array( '\ShortPixel\nextGenViewController', 'nggColumnContent' ), 10, 2 );
       $defaults['wp-shortPixelNgg'] = 'ShortPixel Compression'; */
       return $defaults;
   }

   public function nggCountColumns( $count ) {
       return $count + 1;
   }

   public function nggColumnHeader( $default ) {

		 	 wp_enqueue_style('dashicons');
			 $this->loadView('snippets/part-comparer');


       return __('ShortPixel Compression','shortpixel-image-optimiser');
   }

   public function loadItem( $nextGenObj ) {

       $this->view = new \stdClass; // reset every row

       $otherMediaController = OtherMediaController::getInstance();
       $mediaItem = $otherMediaController->getCustomImageByPath($nextGenObj->imagePath);
       $this->view->mediaItem = $mediaItem;
       $this->view->text = UiHelper::getStatusText($mediaItem);

       $this->view->list_actions = UiHelper::getListActions($mediaItem);
       if ( count($this->view->list_actions) > 0)
         $this->view->list_actions = UiHelper::renderBurgerList($this->view->list_actions, $mediaItem);
       else
         $this->view->list_actions = '';

       $this->view->actions = UiHelper::getActions($mediaItem);
       //$this->view->actions = $actions;

       if (! $this->userIsAllowed)
       {
         $this->view->actions = array();
         $this->view->list_actions = '';
       }

       $this->loadView($this->template, false);
   }



} // class
