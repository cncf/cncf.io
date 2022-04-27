<?php
/**
 * Customizer Builder Control Base
 *
 * @since 2.0
 */
namespace TwitterFeed\Builder\Controls;

if(!defined('ABSPATH'))	exit;

abstract class SB_Controls_Base{

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
		return '';
	}

	/**
	 * Get control info.
	 *
	 * Getting the Control information []
	 *
	 * @since 2.0
	 * @access public
	 *
	 * @return array
	*/
	public function get_info(){
		return [
			'id' 			=> '',
			'type' 			=> '',
			'modelname' 	=> '',
			'layout' 		=> 'full',
			'reverse' 		=> 'false',
			'default' 		=> '',
			'seperator' 	=> 'none',
			'heading' 		=> '',
			'description' 	=> '',
			'tooltip' 		=> '',
		];
	}

	/**
	 * Control Output
	 *
	 *
	 * @since 2.0
	 * @access public
	 *
	 * @return HTML
	*/
	public function get_control_output($controlEditingTypeModel){}

	/**
	 * Getting Editing Control Type
	 *
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return String
	*/
	public function get_control_edit_type($editingType){
		switch ($editingType) {
			case 'settings':
				return 'customizerFeedData.settings';
			break;
		}
	}

	/**
	 * Get Control HTML.
	 *
	 *
	 * @since 2.0
	 * @access public
	 *
	 * @return HTML
	*/
	public function print_control_wrapper($editingType){
		$control_type = $this->get_type();
		$controlEditingTypeModel = $this->get_control_edit_type($editingType);
	?>

	<div class="sb-control-elem-ctn ctf-fb-fs" v-if="control.type == '<?php echo $control_type ?>'"
		v-show="isControlShown(control)"
		:data-child="control.child ? 'true' : false"
		:data-separator="control.separator != undefined ? control.separator : 'none'"
		:data-type="control.type" :data-layout="control.layout == undefined ? 'block' : 'half'"
		:data-reverse="control.reverse != undefined ? 'true' : 'false'" :data-stacked="control.stacked ? 'true' : 'false'"
		:data-heading="control.strongHeading != undefined && control.strongHeading != 'true' ? '' : 'strong'"
		:data-disabled="control.disabledInput != undefined ? isControlShown(control) : false"
		:data-switcher-top="control.switcherTop != undefined ? 'true' : false"
		:data-align-description="control.alignDescription != undefined ? 'true' : false"

		>

		<div class="sb-control-elem-overlay"
			v-show="control.condition != undefined || control.checkExtension != undefined || control.checkExtensionDimmed != undefined  ? !checkControlCondition(control.condition, control.checkExtension, control.checkExtensionDimmed) : false"
			@click.prevent.default="control.checkExtensionPopup != undefined && !checkExtensionActive(control.checkExtensionPopup) ? viewsActive.extensionsPopupElement = control.checkExtensionPopup : false"
			:class="control.checkExtensionPopup != undefined && !checkExtensionActive(control.checkExtensionPopup) ? 'sb-cursor-pointer' : ''"
		>
		</div>

		<div class="sb-control-elem-label" v-if="(control.heading == undefined && control.description == undefined) ? false : true &&  control.type != 'customview'">
			<div class="sb-control-elem-label-title ctf-fb-fs">
				<div v-if="control.icon != undefined" class="sb-control-elem-icon" v-html="svgIcons[control.icon]"></div>
				<div class="sb-control-elem-heading sb-small-p sb-dark-text" :data-underline="control.underline" :class="control.enableViewAction != undefined && control.enableViewAction != false ? 'sb-cursor-pointer' : ''" v-html="control.heading" @click.prevent.default="control.enableViewAction != undefined && control.enableViewAction != false ? switchNestedSection(control.enableViewAction, null ) : false"></div>
				<div class="sb-control-elem-tltp" v-if="control.tooltip != undefined" @mouseover.prevent.default="toggleElementTooltip(control.tooltip, 'show', control.tooltipAlign ? control.tooltipAlign : 'center' )" @mouseleave.prevent.default="toggleElementTooltip('', 'hide')">
					<div class="sb-control-elem-tltp-icon" v-html="svgIcons['info']"></div>
				</div>
			</div>
			<div class="sb-control-elem-description" v-if="control.descriptionPosition != 'bottom'" v-html="control.description"></div>
		</div>
		<div class="sb-control-elem-output">
			<?php $this->get_control_output($controlEditingTypeModel); ?>
			<div class="sb-control-elem-description" v-if="control.descriptionPosition != undefined && control.descriptionPosition == 'bottom'" v-html="control.description"></div>
		</div>
	</div>
	<?php
	}

}