<?php
namespace ShortPixel\Model\Image;

// Base Class for ImageMeta
class ImageMeta extends ImageThumbnailMeta
{

  public $errorMessage;
  public $wasConverted = false; // Was converted from legacy format

	protected $convertMeta;

	public function __construct()
	{
		parent::__construct();
		$this->convertMeta = new ImageConvertMeta();

	}

	public function fromClass($object)
	{
		if (property_exists($object, 'convertMeta'))
		{

			$this->convertMeta->fromClass($object->convertMeta);
			unset($object->convertMeta);
		}
		// legacy.
		if (property_exists($object, 'tried_png2jpg') && $object->tried_png2jpg)
		{
			 $this->convertMeta()->setTried($object->tried_png2jpg);
		}
		elseif (property_exists($object, 'did_png2jpg')  && $object->did_png2jpg)
		{
			 $this->convertMeta()->setFileFormat('png');
			 $this->convertMeta()->setConversionDone();

		}

		parent::fromClass($object);
	}


		public function convertMeta()
		{
			 return $this->convertMeta;
		}

} // class
