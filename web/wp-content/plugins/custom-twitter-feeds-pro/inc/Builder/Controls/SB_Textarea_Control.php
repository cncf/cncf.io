<?php
/**
 * Customizer Builder
 * TextArea Field Control
 *
 * @since 2.0
 */
namespace TwitterFeed\Builder\Controls;

if(!defined('ABSPATH'))	exit;

class SB_Textarea_Control extends SB_Controls_Base{

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
		return 'textarea';
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
		<div class="sb-control-textarea-ctn ctf-fb-fs">
			<textarea class="sb-control-input-textrea ctf-fb-fs" v-model="<?php echo $controlEditingTypeModel ?>[control.id]" :placeholder="control.placeholder ? control.placeholder : ''" @focusout.prevent.default="changeSettingValue(false,false,false, control.ajaxAction ? control.ajaxAction : false)"></textarea>
		</div>
		<?php
	}

}