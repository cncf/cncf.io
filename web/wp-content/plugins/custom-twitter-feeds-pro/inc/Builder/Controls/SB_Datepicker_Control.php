<?php
/**
 * Customizer Builder
 * Date Picker Field Control
 *
 * @since 2.0
 */
namespace TwitterFeed\Builder\Controls;

if(!defined('ABSPATH'))	exit;

class SB_Datepicker_Control extends SB_Controls_Base{

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
		return 'datepicker';
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
		<div class="sb-control-input-ctn ctf-fb-fs">
			<input type="date" class="sb-control-input ctf-fb-fs" v-model="<?php echo $controlEditingTypeModel ?>[control.id]" @change.prevent.default="changeSettingValue(control.id, false,false, control.ajaxAction ? control.ajaxAction : false)"  :placeholder="control.placeholder ? control.placeholder : ''">
		</div>
		<?php
	}

}