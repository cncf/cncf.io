<?php
/**
 * Customizer Builder
 * Separator Control
 *
 * @since 2.0
 */
namespace TwitterFeed\Builder\Controls;

if(!defined('ABSPATH'))	exit;

class SB_Separator_Control extends SB_Controls_Base{

	/**
	 * Get control type.
	 *
	 * Getting the Control Type
	 *
	 * @since 2.0
	 * @access public
	 *
	 * @return string
	*/
	public function get_type(){
		return 'separator';
	}

	/**
	 * Output Control
	 *
	 *
	 * @since 2.0
	 * @access public
	 *
	 * @return HTML
	*/
	public function get_control_output($controlEditingTypeModel){
		?>
			<div class="sb-control-elem-separator ctf-fb-fs" :style="'margin-top:'+ (control.top ? control.top : 0) +'px;margin-bottom:'+ (control.bottom ? control.bottom : 0) +'px;'"></div>
		<?php
	}

}