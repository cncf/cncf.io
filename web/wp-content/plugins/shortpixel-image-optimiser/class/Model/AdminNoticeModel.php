<?php
namespace ShortPixel\Model;
use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;
use ShortPixel\Notices\NoticeController as Notice;
use ShortPixel\Notices\NoticeController as Notices;


abstract class AdminNoticeModel
{
	 protected $key; // abstract
	 protected $notice;

	 protected $errorLevel = 'normal';
	 protected $suppress_delay = YEAR_IN_SECONDS;
	 protected $callback;

	 protected $include_screens = array();
	 protected $exclude_screens = array();

	 protected $data;

	 // No stuff loading here, low init
	 public function __construct()
	 {

	 }

	 // The main init, ty.
	 public function load()
	 {
		 $noticeController = Notices::getInstance();
		 $notice = $noticeController->getNoticeByID($this->key);

		 if (is_object($notice))
		 {
		 	$this->notice = $notice;
		 }

		 if (is_object($notice) && $notice->isDismissed())
		 {
			 return false;
		 }

		 if (is_null($this->notice) && $this->checkTrigger() === true)
		 {
			  $this->add();
		 }
		 elseif ( is_object($this->notice) && $this->checkReset() === true)
		 {
			  $this->reset();
		 }
	 }

	 public function getKey()
	 {
		  return $this->key;
	 }

	 public function reset($key = null)
	 {
		  $key = (is_null($key)) ? $this->key : $key;
		 	Notices::removeNoticeByID($key);
	 }

	 protected function checkReset()
	 {
		  return false;
	 }

	 // For when trigger condition is not applicable.
	 public function addManual($args = array())
	 {
		  foreach($args as $key => $val)
			{
				 $this->addData($key, $val);
			}
		 	$this->add();
	 }

	 public function getNoticeObj()
	 {
		  return $this->notice;  // can be null!
	 }

	 // Proxy for noticeModel dismissed
	 public function isDismissed()
	 {
		 	$notice = $this->getNoticeObj();
			if (is_null($notice) || $notice->isDismissed() === false)
				return false;

			return true;
	 }


	 protected function add()
	 {

		 switch ($this->errorLevel)
		 {
			 case 'warning':
			 	$notice = Notices::addWarning($this->getMessage());
			 break;
			 case 'normal';
			 default:
			 	$notice = Notices::addNormal($this->getMessage());

			 break;
		 }

		 /// Todo implement include / exclude screens here.
		 if (count($this->exclude_screens) > 0)
		 {
			 $notice->limitScreens('exclude', $this->exclude_screens);
		 }

		 if (count($this->include_screens) > 0)
		 {
			 $notice->limitScreens('include', $this->include_screens);
		 }

		 if (! is_null($this->callback))
		 	Notices::makePersistent($notice, $this->key, $this->suppress_delay, $this->callback);
		 else
		 	Notices::makePersistent($notice, $this->key, $this->suppress_delay);

		 $this->notice = $notice;
	 }

	 protected function addData($name, $value)
	 {
		  $this->data[$name] = $value;
	 }

	 protected function getData($name)
	 {
		  	if (isset($this->data[$name]))
				{
					 return $this->data[$name];
				}
				return false;
	 }

// ?? abstract proteced removeCondition();

	 abstract protected function checkTrigger();
	 abstract protected function getMessage();


}
