<?php TwitterFeed\Builder\SB_Builder_Customizer::register_controls(); ?>
<div class="sb-customizer-sidebar" v-bind:class="{ 'sb-onboarding-highlight' : viewsActive.onboardingStep === 2 || viewsActive.onboardingStep === 3 }">
	<div class="sb-customizer-sidebar-sec1 ctf-fb-fs">
		<div class="sb-customizer-sidebar-tab-ctn ctf-fb-fs" v-if="customizerScreens.activeSection == null">
            <div class="sb-customizer-sidebar-tab" v-for="tab in customizerSidebarBuilder" :data-active="customizerScreens.activeTab == tab.id" @click.prevent.default="switchCustomizerTab(tab.id)"><span class="sb-standard-p sb-bold">{{tab.heading}}</span></div>
		</div>

		<div class="sb-customizer-sidebar-sec-ctn ctf-fb-fs" v-if="customizerScreens.activeSection == null">
			<div v-for="(section, sectionId) in customizerSidebarBuilder[customizerScreens.activeTab].sections">
				<div class="sb-customizer-sidebar-sec-el ctf-fb-fs" v-if="!section.isHeader" @click.prevent.default="switchCustomizerSection(sectionId, section)">
					<div class="sb-customizer-sidebar-sec-el-icon" v-html="svgIcons[section.icon]"></div>
					<span class="sb-small-p sb-bold sb-dark-text">{{section.heading}}</span>
                    <div class="sb-customizer-chevron">
                        <svg width="6" height="8" viewBox="0 0 6 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1.66656 0L0.726562 0.94L3.7799 4L0.726562 7.06L1.66656 8L5.66656 4L1.66656 0Z" fill="#141B38"/>
                        </svg>
                    </div>
				</div>
				<div class="sb-customizer-sidebar-sec-elhead ctf-fb-fs" v-if="section.isHeader" :data-header-id="sectionId">
					{{section.heading}}
				</div>
			</div>
			<div  class="sb-customizer-sidebar-cache-wrapper ctf-fb-fs">
				<button class="sb-control-action-button sb-btn ctf-fb-fs sb-btn-grey" v-if="customizerScreens.activeTab == 'settings'" @click.prevent.default="clearSingleFeedCache()">
					<div v-html="svgIcons['update']"></div>
					<span>{{genericText.clearFeedCache}}</span>
				</button>
			</div>
		</div>

		<div class="ctf-fb-fs" v-if="customizerScreens.activeSection != null">
			<div class="sb-customizer-sidebar-header ctf-fb-fs" :data-separator="customizerScreens.activeSectionData.separator ? customizerScreens.activeSectionData.separator : ''">
				<div class="sb-customizer-sidebar-breadcrumb ctf-fb-fs">
                    <a @click.prevent.default="switchCustomizerTab(customizerScreens.activeTab)">
                        <svg width="6" height="8" viewBox="0 0 6 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.27203 0.94L4.33203 0L0.332031 4L4.33203 8L5.27203 7.06L2.2187 4L5.27203 0.94Z" fill="#434960"/>
                        </svg>{{customizerScreens.activeTab}}
                    </a>
					<a v-if="customizerScreens.parentActiveSection != null" @click.prevent.default="switchCustomizerSection(customizerScreens.parentActiveSection, customizerScreens.parentActiveSectionData)" class="ctf-child-breadcrumb">
                        <svg width="6" height="8" viewBox="0 0 6 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.27203 0.94L4.33203 0L0.332031 4L4.33203 8L5.27203 7.06L2.2187 4L5.27203 0.94Z" fill="#434960"/>
                        </svg>{{customizerScreens.parentActiveSectionData.heading}}
                    </a>
                    <a v-if="customizerScreens.parentActiveSection == 'customize_posts' && nestedStylingSection.includes(customizerScreens.activeSection)" @click.prevent.default="backToPostElements()" class="ctf-child-breadcrumb">
                        <svg width="6" height="8" viewBox="0 0 6 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.27203 0.94L4.33203 0L0.332031 4L4.33203 8L5.27203 7.06L2.2187 4L5.27203 0.94Z" fill="#434960"/>
                        </svg>Elements
                    </a>
				</div>
				<h3>{{customizerScreens.activeSectionData.heading}}</h3>
				<span v-html="customizerScreens.activeSectionData.description"></span>
			</div>
			<div class="sb-customizer-sidebar-controls-ctn ctf-fb-fs">
				<div class="sb-control-ctn ctf-fb-fs" v-for="(control, ctlIndex) in customizerScreens.activeSectionData.controls">
					<?php TwitterFeed\Builder\SB_Builder_Customizer::get_controls_templates('settings'); ?>
				</div>
				<div class="sb-customizer-sidebar-sec-el ctf-fb-fs" v-if="customizerScreens.activeSectionData.nested_sections && ((nesetdSection.condition != undefined ? checkControlCondition(nesetdSection.condition) : false) || (nesetdSection.condition == undefined ))" v-for="(nesetdSection, nesetdSectionId) in customizerScreens.activeSectionData.nested_sections" @click.prevent.default="switchCustomizerSection(nesetdSectionId, nesetdSection, true)">
					<div class="sb-customizer-sidebar-sec-el-icon" v-html="svgIcons[nesetdSection.icon]"></div>
					<strong>{{nesetdSection.heading}}</strong>
                    <div class="sb-customizer-chevron">
                        <svg width="6" height="8" viewBox="0 0 6 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1.66656 0L0.726562 0.94L3.7799 4L0.726562 7.06L1.66656 8L5.66656 4L1.66656 0Z" fill="#141B38"/>
                        </svg>
                    </div>
                </div>
			</div>
		</div>


	</div>

</div>

<?php

#TwitterFeed\Builder\CFF_Builder_Customizer::get_controls_templates();
