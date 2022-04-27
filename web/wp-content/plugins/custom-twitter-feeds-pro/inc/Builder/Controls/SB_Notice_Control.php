<?php
/**
 * Customizer Builder
 * Notice Control
 *
 * @since 2.0
 */
namespace TwitterFeed\Builder\Controls;

if(!defined('ABSPATH'))	exit;

class SB_Notice_Control extends SB_Controls_Base{

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
		return 'notice';
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
		<div class="sb-control-notice-ctn ctf-fb-fs" @click.prevent.default="control.containerAction != undefined ? noticeClickAction(control.containerAction) : false" :data-notice-action="control.containerAction != undefined ? 'true': false">
			<div class="sb-control-notice-content ctf-fb-fs">
				<div class="sb-control-notice-icon" v-if="control.noticeIcon != undefined" v-html="svgIcons[control.noticeIcon]"></div>
				<div v-html="control.noticeDescription"></div>
			</div>
			<div class="ctf-fb-fs">
				<div class="sb-control-notice-btn ctf-fb-hd-btn ctf-btn-grey sb-button-standard ctf-small-chevron" data-icon="right" v-if="control.buttonAction != undefined" @click.prevent.default="noticeClickAction(control.buttonAction)">
					<span v-html="control.buttonActionText"></span>
				</div>
			</div>
		</div>
		<?php
	}

}