<?php
namespace ShortPixel;

class QueryMonitor
{

	public function __construct()
	{

			if (false === \wpSPIO()->env()->is_debug)
				return;

			$this->hooks();
	}

	public function hooks()
	{
			add_action('qm/output/after', array($this, 'panelEnd'), 10, 2);
	}

	public function panelEnd($qmObj, $outputters)
	{
//		echo "<PRE>"; var_dump(get_class_methods($qmObj));
//		 var_dump(get_class_methods($outputters));
	// var_dump($outputters);
	}

}


$qm = new QueryMonitor();
