<div class="ctf-fb-feedtypes-pp-ctn ctf-fb-feedtemplates-ctn sb-fs-boss ctf-fb-center-boss" v-if="viewsActive.feedtemplatesPopup">
	<div class="ctf-fb-feedtypes-popup ctf-fb-popup-inside">
		<div class="ctf-fb-popup-cls" @click.prevent.default="activateView('feedtemplatesPopup')"><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M14 1.41L12.59 0L7 5.59L1.41 0L0 1.41L5.59 7L0 12.59L1.41 14L7 8.41L12.59 14L14 12.59L8.41 7L14 1.41Z" fill="#141B38"/>
            </svg>
        </div>
        <div class="ctf-fb-source-top ctf-fb-fs">
            <h2>{{selectFeedTemplateScreen.updateHeading}}</h2>
            <p class="ctf-fb-feedtemplate-alert ctf-fb-fs">
                <span v-html="svgIcons['info']"></span>
                {{selectFeedTemplateScreen.updateHeadingWarning}}
            </p>
            <div class="ctf-fb-types ctf-fb-fs">
                <div class="ctf-fb-templates-list ctf-fb-templates-ctn">
                    <div :class="['ctf-fb-type-el', 'ctf-feed-template-' + feedTemplateEl.type]" v-for="(feedTemplateEl, feedTemplateIn) in feedTemplates" :data-active="choosedFeedTemplateCustomizer(feedTemplateEl.type)" @click.prevent.default="chooseFeedTemplate(feedTemplateEl, true)">
                        <div class="ctf-fb-type-el-img ctf-fb-fs" v-html="svgIcons[feedTemplateEl.icon]"></div>
                        <div class="ctf-fb-type-el-info ctf-fb-fs">
                            <p class="sb-small-p sb-bold sb-dark-text" v-html="feedTemplateEl.title"></p>
                            <!--<span class="sb-caption sb-lightest">{{feedTemplateEl.description}}</span>-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="ctf-fb-extppcustomizer-btns ctf-fb-fs">

                <button class="ctf-fb-srcs-update ctf-fb-btn ctf-fb-fs ctf-btn-orange" @click.prevent.default="updateFeedTemplateCustomizer()">
                    <svg width="16" height="12" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M6.08058 8.36133L14.0355 0.406383L15.8033 2.17415L6.08058 11.8969L0.777281 6.59357L2.54505 4.8258L6.08058 8.36133Z" fill="white"/>
                    </svg>
                    <span>{{genericText.update}}</span>
                </button>
                <button class="ctf-fb-source-btn ctf-fb-fs sb-btn-grey" @click.prevent.default="viewsActive.feedtemplatesPopup = false">
                    <div class="ctf-fb-icon-cancel"></div>
                    {{genericText.cancel}}
                </button>

            </div>
        </div>
	</div>
</div>