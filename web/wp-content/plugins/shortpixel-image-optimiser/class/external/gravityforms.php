<?php
namespace ShortPixel;
use ShortPixel\Controller\OtherMediaController as OtherMediaController;


// Gravity Forms integrations.
class gravityForms
{

  public function __construct()
  {
		// @todo All this off, because it can only fatal error.
   // add_filter( 'gform_save_field_value', array($this,'shortPixelGravityForms'), 10, 5 );
  }

  function shortPixelGravityForms( $value, $lead, $field, $form ) {
      if($field->type == 'post_image') {
          $this->handleGravityFormsImageField($value);
      }
      return $value;
  }

  public function handleGravityFormsImageField($value) {


			$fs = \wpSPIO()->filesystem();
			$otherMediaController = OtherMediaController::getInstance();
			$uploadBase = $fs->getWPUploadBase();


			$gravFolder = $otherMediaController->getFolderByPath($uploadBase->getPath() . 'gravity_forms');

			if (! $gravFolder->exists())
			 	return false;

/* no clue what this legacy is suppposed to be.
      if(strpos($value , '|:|')) {
          $cleanup = explode('|:|', $value);
          $value = $cleanup[0];
      }
*/
			if (! $gravFolder->get('in_db'))
			{
				 $otherMediaController->addDirectory($gravFolder->getPath());
			}

      //ShortPixel is monitoring the gravity forms folder, add the image to queue
     // $uploadDir   = wp_upload_dir();
      //$localPath = str_replace($uploadDir['baseurl'], SHORTPIXEL_UPLOADS_BASE, $value);

      //return $shortPixelObj->addPathToCustomFolder($localPath, $folder->getId(), 0);
  }

} // class

$g = new gravityForms();
