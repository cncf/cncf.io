<?php
/**
 * Customizer Builder
 * Color Override Field Control
 *
 * @since 2.0
 */
namespace TwitterFeed\Builder\Controls;

if(!defined('ABSPATH'))	exit;

class SB_Coloroverride_Control extends SB_Controls_Base{

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
		return 'coloroverride';
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
		<div class="sb-control-input-ctn ctf-fb-fs sb-control-coloroverride-ctn">
			<div class="sb-control-coloroverride-content">
				<div class="sb-control-coloroverride-txt" v-html="<?php echo $controlEditingTypeModel ?>[control.id]"></div>
				<div class="sb-control-coloroverride-swatch" :style="'background:'+<?php echo $controlEditingTypeModel ?>[control.id]"></div>
			</div>
			<div class="sb-control-colorpicker-btn" @click.prevent.default="resetColorOverride(control.id)">{{genericText.reset}}</div>
		</div>
		<?php
	}

}