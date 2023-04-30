<?php
namespace ShortPixel\Model\Image;
use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;


class ImageThumbnailMeta
{
	/** @var int */
	public $databaseID = null;
	/** @var int */
  public $status = 0;
	/** @var int */
  public $compressionType;
	/** @var int */
  public $compressedSize;
	/** @var int */
  public $originalSize;
//  public $improvement;

	/** @var boolean */
  public $did_keepExif  = false;

	/** @var boolean */
  public $did_cmyk2rgb = false;

	// @todo Find all of those.
 // public $did_png2jpg = false; // Was this replaced?
//	public $tried_png2jpg = false; // Tried it, might not have working.

	/** @var int */
  public $resize;
	/** @var int */
  public $resizeWidth;
	/** @var int */
  public $resizeHeight;
	/** @var int */
	public $resizeType;
	/** @var int  */
  public $originalWidth;
	/** @var int */
  public $originalHeight;

  public $tsAdded;
  public $tsOptimized;
  public $webp;
  public $avif;

  public $file; // **Only for unlisted images. This defines an unlisted image */

  // Only for customImageModel! Exception to prevent having to create a whole class. Second var here, warrants a subclass.
  public $customImprovement;


  public function __construct()
  {
     $this->tsAdded = time(); // default
  }


  /** Load data from basic class to prevent issues when class definitions changes over time */
  public function fromClass($object)
  {

     foreach($object as $property => $value)
     {
        if ($property == 'customImprovement')
        {  continue;  }


        if (property_exists($this, $property))
        {
          $this->$property = $value;
        }
     }
  }


  /** Save data as basic class to prevent issues when class definitions changes over time */
  public function toClass()
  {
     $class = new \stdClass;
     $vars = get_object_vars($this);

     foreach($vars as $property => $value) // only used by media library.
     {
       if ($property == 'customImprovement')
       {  continue;  }

			 if ($property == 'convertMeta' && is_null($this->convertMeta))
			 {
				 	continue;
			 }
			 elseif ($property == 'convertMeta') {
			 		$class->$property = $this->$property->toClass();
					continue;
			 }
      // if (is_null($value)) // don't save default / values without init.
       //   continue;


       $class->$property = $this->$property;
     }

     return $class;
  }
}
