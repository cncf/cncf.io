<?php
/**
 * Customizer Builder
 * CheckBox List Control
 *
 * @since 2.0
 */
namespace TwitterFeed\Builder\Controls;

if(!defined('ABSPATH'))	exit;

class SB_Checkboxlist_Control extends SB_Controls_Base{

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
		return 'checkboxlist';
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
		<div class="sb-control-checkbox-ctn ctf-fb-fs" v-for="option in control.options" @click.prevent.default="changeCheckboxListValue(control.id, option.value)">
			<div class="sb-control-checkbox" :data-active="<?php echo $controlEditingTypeModel ?>[control.id].includes(option.value)"></div>
			<div class="sb-control-label sb-small-p sb-dark-text" v-html="option.label"></div>
		</div>
		<?php
	}

}