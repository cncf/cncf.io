<?php
/**
 * Customizer Builder
 * CheckBox Section Control
 *
 * @since 2.0
 */
namespace TwitterFeed\Builder\Controls;

if(!defined('ABSPATH'))	exit;

class SB_Checkboxsection_Control extends SB_Controls_Base{

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
		return 'checkboxsection';
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
		<div class="sb-control-checkboxsection-header" v-if="control.header">
			<div class="sb-control-checkboxsection-name">
				<div v-html="svgIcons['preview']"></div>
				<strong class="">{{genericText.name}}</strong>
			</div>
			<strong>{{genericText.edit}}</strong>
		</div>
		<div class="sb-control-checkbox-ctn ctf-fb-fs" @click.prevent.default="control.section.controls.length > 0 ? switchNestedSection(control.section.id, control.section) : false">
			<div class="sb-control-checkbox-hover"></div>
			<div class="sb-control-checkbox" @click.stop.prevent.default="changeCheckboxSectionValue(control.id, control.value, control.ajaxAction != undefined ? control.ajaxAction : false, control.checkBoxAction != undefined ? control : false)"
			:data-active="checkActiveControl(control.id, control.options.enabled)"></div>
			<div class="ctf-fb-fs" :data-active="<?php echo $controlEditingTypeModel ?>[control.id] == control.options.enabled">
				<strong class="sb-control-label">{{control.label}}</strong>
			</div>
			<div v-if="control.section.controls.length > 0" class="sb-control-checkboxsection-btn"></div>
		</div>
		<?php
	}

}