<?php
/**
 * Customizer Builder
 * Number Field Control
 *
 * @since 2.0
 */
namespace TwitterFeed\Builder\Controls;

if(!defined('ABSPATH'))	exit;

class SB_Number_Control extends SB_Controls_Base{

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
		return 'number';
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
		<div class="sb-control-input-ctn ctf-fb-fs" :data-contains-suffix="control.fieldSuffix !== undefined ? 'true' : 'false'">
			<div class="sb-control-input-info" :class="control.fieldPrefixAction != undefined ? 'sb-cursor-pointer' : ''" v-if="control.fieldPrefix" @click.prevent.default="control.fieldPrefixAction != undefined ? fieldCustomClickAction(control.fieldPrefixAction) : false">{{control.fieldPrefix.replace(/ /g,"&nbsp;")}}</div>
			<input type="number" class="sb-control-input ctf-fb-fs" :placeholder="control.placeholder ? control.placeholder : ''" :step="control.step ? control.step : 1" :max="control.max ? control.max : 1000" :min="control.min ? control.min : 0" v-model="<?php echo $controlEditingTypeModel ?>[control.id]"  @change.prevent.default="changeSettingValue(control.id,false,false, control.ajaxAction ? control.ajaxAction : false)">
			<div class="sb-control-input-info" :class="control.fieldSuffixAction != undefined ? 'sb-cursor-pointer' : ''" v-if="control.fieldSuffix" @click.prevent.default="control.fieldSuffixAction != undefined ? fieldCustomClickAction(control.fieldSuffixAction) : false">{{control.fieldSuffix.replace(/ /g,"&nbsp;")}}</div>
		</div>
		<?php
	}

}