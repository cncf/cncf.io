<div class="ctf-fb-feedtypes-pp-ctn sb-fs-boss ctf-fb-center-boss" :data-screen="customizerFeedData != undefined ? 'customizer' : 'creationProcess'" v-if="viewsActive.feedtypesPopup">
	<div class="ctf-fb-feedtypes-popup ctf-fb-popup-inside">
        <div class="sb-button-no-border" v-if="customizerFeedData != undefined" @click.prevent.default="toggleFeedTypesChooserPopup()">
            <svg width="7" height="11" viewBox="0 0 7 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M6.3415 1.18184L5.1665 0.00683594L0.166504 5.00684L5.1665 10.0068L6.3415 8.83184L2.52484 5.00684L6.3415 1.18184Z" fill="#141B38"/>
            </svg>
            <span>{{genericText.back}}</span>
        </div>
        <div class="ctf-fb-popup-cls" v-if="customizerFeedData != undefined" @click.prevent.default="cancelFeedTypeAndSourcesCustomizer()">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M14 1.41L12.59 0L7 5.59L1.41 0L0 1.41L5.59 7L0 12.59L1.41 14L7 8.41L12.59 14L14 12.59L8.41 7L14 1.41Z" fill="#141B38"/>
            </svg>
        </div>
        <div class="ctf-fb-popup-cls" v-if="customizerFeedData == undefined" @click.prevent.default="viewsActive.feedtypesPopup = false">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M14 1.41L12.59 0L7 5.59L1.41 0L0 1.41L5.59 7L0 12.59L1.41 14L7 8.41L12.59 14L14 12.59L8.41 7L14 1.41Z" fill="#141B38"/>
            </svg>
        </div>

    <div class="ctf-fb-types ctf-fb-fs">

        <h4>{{selectFeedTypeScreen.anotherFeedTypeHeading}}</h4>
        <div class="ctf-fb-types-list">
            <div class="ctf-fb-type-el" v-for="(feedTypeEl, feedTypeIn) in feedTypes" :class="selectedFeed.includes(feedTypeEl.type) && feedTypeEl.type != 'socialwall' ? 'ctf-fb-tltp-parent' : ''" :data-active="selectedFeedPopup.includes(feedTypeEl.type) && feedTypeEl.type != 'socialwall'"  :data-already-selected="selectedFeed.includes(feedTypeEl.type) && feedTypeEl.type != 'socialwall'"  :data-type="feedTypeEl.type" @click.prevent.default="!selectedFeed.includes(feedTypeEl.type) && feedTypeEl.type != 'socialwall' ? selectFeedTypePopup(feedTypeEl) : false">
               <div class="ctf-fb-tltp-elem" v-if="selectedFeed.includes(feedTypeEl.type) && feedTypeEl.type != 'socialwall'"><span>{{feedTypeEl.title.replace(/ /g,"&nbsp;")}}{{genericText.isAlreadyAdded.replace(/ /g,"&nbsp;")}}</span></div>
                <div class="ctf-fb-type-el-img ctf-fb-fs" v-html="svgIcons[feedTypeEl.icon]"></div>
                <div class="ctf-fb-type-el-info ctf-fb-fs">
                    <p class="sb-small-p sb-bold sb-dark-text" v-html="feedTypeEl.title"></p>
                    <a href="" v-if="feedTypeEl.businessRequired != undefined && feedTypeEl.businessRequired" v-html="genericText.businessRequired"></a>
                    <span class="sb-caption sb-lightest sb-small-text">{{feedTypeEl.description}}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="ctf-fb-addsourtype-ctn ctf-fb-fs">
        <button class="ctf-fb-source-btn ctf-fb-fs sb-btn-orange"  @click.prevent.default="addFeedTypePopup()">
            <svg width="14" height="14" viewBox="0 0 10 10" fill="#fff" xmlns="http://www.w3.org/2000/svg"><path d="M9.66634 5.66634H5.66634V9.66634H4.33301V5.66634H0.333008V4.33301H4.33301V0.333008H5.66634V4.33301H9.66634V5.66634Z"></path></svg>
            {{genericText.add}}
        </button>
    </div>


</div>
</div>