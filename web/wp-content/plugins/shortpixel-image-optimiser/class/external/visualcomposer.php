<?php

// Visual Composer and compat class.
class visualComp
{

  public function __construct()
  {
     add_filter('shortpixel/init/automedialibrary', array($this, 'check_vcinline'));
  }

  // autolibrary should not do things when VC is being inline somewhere. 
  public function check_vcinline($bool)
  {
      if ( function_exists( 'vc_action' ) && vc_action() == 'vc_inline' )
        return false;
      else
        return $bool;
  }

} // Class

$vc = new visualComp();
