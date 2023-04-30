<?php
namespace ShortPixel\Model\Image;
use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;

class ImageConvertMeta
{

	 protected $fileFormat; // png / heic etc
	 protected $isConverted = false;
	 protected $placeholder = false;
	 protected $replacementImageBase = false;
	// protected $doConversion = false;
	 protected $triedConversion = false;
	 protected $errorReason = false;
	 protected $omitBackup = true; // Don't backup the converted image (again), keeping only the original format. if not, make a backup of the converted file and treat that as the default backup/restore

	 public function __construct()
	 {

	 }

	 public function isConverted()
	 {
		 	return $this->isConverted;
	 }

	 public function didTry()
	 {
		   return $this->triedConversion;
	 }

	 public function setTried($value)
	 {
		  $this->triedConversion = $value;
	 }

	 public function setConversionDone($omitBackup = true)
	 {
		  $this->isConverted = true;
			$this->omitBackup = $omitBackup;
	 }

	 public function setError($code)
	 {
		  $this->errorReason = $code;
	 }

	 public function getError()
	 {
		  return $this->errorReason;
	 }

	 public function setFileFormat($ext)
	 {
		  if (is_null($this->fileFormat))
		  	$this->fileFormat = $ext;
	 }

	 public function getFileFormat()
	 {
		  return $this->fileFormat;
	 }

	 public function omitBackup()
	 {
		  return $this->omitBackup;
	 }

	 // bool for now, otherwise if needed.
	 public function setPlaceHolder($placeholder = true)
	 {
		 	$this->placeholder = $placeholder;
	 }

	 public function hasPlaceHolder()
	 {
		  return $this->placeholder;
	 }

	 public function setReplacementImageBase($name)
	 {
		  $this->replacementImageBase = $name;

	 }

	 public function getReplacementImageBase()
	 {
		  return $this->replacementImageBase;

	 }


	 public function fromClass($object)
   {
      foreach($object as $property => $value)
      {
				if (property_exists($this, $property))
        {
          $this->$property = $value;
        }
     	}
  	}

	 public function toClass()
	 {
		 $class = new \stdClass;
		 $vars = get_object_vars($this);

		 foreach($vars as $property => $value) // only used by media library.
		 {
			  $class->$property = $this->$property;
		 }
		 return $class;
	 }

}
