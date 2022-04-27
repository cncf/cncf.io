<?php
/**
 * Customizer Builder
 * Custom View
 *	This control will used for custom HTMlL controls like (source, feed type...)
 * @since 2.0
 */
namespace TwitterFeed\Builder\Controls;

if(!defined('ABSPATH'))	exit;

class SB_Customview_Control extends SB_Controls_Base{

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
		return 'customview';
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
		$this->get_control_sources_output($controlEditingTypeModel);
		$this->get_control_feedtemplate_output($controlEditingTypeModel);
	}








	/**
	 * Feed Type Output Control
	 *
	 *
	 * @since 2.0
	 * @access public
	 *
	 * @return HTML
	*/
	public function get_control_sources_output($controlEditingTypeModel){
	?>
	<div class="sb-control-feedtype-ctn" v-if="control.viewId == 'sources'">

		<div class="sb-control-feedtype-item ctf-fb-fs" v-for="(feedType, feedTypeID) in selectSourceScreen.multipleTypes" v-if="checkMultipleFeedTypeActiveCustomizer(feedTypeID)">
			<div class="sb-control-elem-label-title ctf-fb-fs">
				<div class="sb-control-elem-heading sb-small-p sb-dark-text" v-html="feedType.heading"></div>
				<!--<div class="sb-control-elem-tltp" @mouseover.prevent.default="toggleElementTooltip(feedType.description, 'show', 'center' )" @mouseleave.prevent.default="toggleElementTooltip('', 'hide')">
					<div class="sb-control-elem-tltp-icon" v-html="svgIcons['info']"></div>
				</div>-->
			</div>
			<div class="sb-control-feedtype-list ctf-fb-fs" v-if="feedTypeID != 'mentionstimeline' && feedTypeID != 'hometimeline'">
				<div class="sb-control-feedtype-list-item" v-for="selectedSource in returnSelectedSourcesByTypeCustomizer(feedTypeID)">
					<div class="sb-control-feedtype-list-item-icon" v-html="svgIcons[selectSourceScreen.multipleTypes[feedTypeID].icon]"></div>
					<span v-html="feedTypeID == 'lists' ? selectedSource.name : selectedSource"></span>
				</div>
			</div>

			<div class="sb-control-feedtype-list ctf-fb-fs" v-if="feedTypeID == 'mentionstimeline' || feedTypeID == 'hometimeline'">
				<div class="sb-control-feedtype-list-item">
					<div class="sb-control-feedtype-list-item-icon" v-html="svgIcons['user']"></div>
					<span v-html="accountDetails.account_handle"></span>
				</div>
			</div>

		</div>

		<button class="sb-control-action-button sb-btn sb-btn-grey ctf-fb-fs" @click.prevent.default="openFeedTypesPopupCustomizer()">
			<div v-html="svgIcons['edit']"></div>
			<span>{{genericText.editSources}}</span>
		</button>

	</div>
	<?php
	}

	/**
	 * Feed Templates Output Control
	 *
	 *
	 * @since 4.0
	 * @access public
	 *
	 * @return HTML
	*/
	public function get_control_feedtemplate_output($controlEditingTypeModel){
	?>
		<div :class="['sb-control-feedtype-ctn sb-control-feedtemplate-ctn', 'ctf-feedtemplate-' + customizerScreens.printedTemplate.type]" v-if="control.viewId == 'feedtemplate'">
			<div class="ctf-fb-type-el" v-if="customizerFeedTemplatePrint()"  @click.prevent.default="activateView('feedtemplatesPopup')">
				<div class="ctf-fb-type-el-img ctf-fb-fs" v-html="svgIcons[customizerScreens.printedTemplate.icon]"></div>
				<div class="ctf-fb-type-el-info ctf-fb-fs">
					<strong class="ctf-fb-fs" v-html="customizerScreens.printedTemplate.title"></strong>
				</div>
			</div>
			<button class="sb-control-action-button sb-btn ctf-fb-fs sb-btn-grey" @click.prevent.default="activateView('feedtemplatesPopup')">
				<div v-html="svgIcons['edit']"></div>
				<span>{{genericText.change}}</span>
			</button>
			<p class="ctf-fb-feedtemplate-alert ctf-fb-fs">
                <span v-html="svgIcons['info']"></span>
                {{selectFeedTemplateScreen.updateHeadingWarning2}}
            </p>
		</div>

	<?php
	}

}