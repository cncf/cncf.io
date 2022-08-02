<div class="ctf-fb-feedtypescustomizer-pp-ctn sb-fs-boss ctf-fb-center-boss" v-if="viewsActive.feedtypesCustomizerPopup">
    <div class="ctf-fb-feedtypes-popup ctf-fb-popup-inside">
        <div class="ctf-fb-popup-cls" @click.prevent.default="cancelFeedTypeAndSourcesCustomizer()"><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14 1.41L12.59 0L7 5.59L1.41 0L0 1.41L5.59 7L0 12.59L1.41 14L7 8.41L12.59 14L14 12.59L8.41 7L14 1.41Z" fill="#141B38"></path></svg></div>
    	<div class="ctf-fb-source-top ctf-fb-fs">
	        <h3>{{genericText.editSources}}</h3>
		</div>
    	<div class="ctf-fb-feedtypescustomizer-content ctf-fb-fs">
			<?php
				include CTF_BUILDER_DIR . 'templates/sections/create-feed/multiple-sources-list.php';
			?>
			<div v-if="! maxTypesAdded()" class="ctf-addsource-type-btn ctf-fb-fs" @click.prevent.default="toggleFeedTypesChooserPopup()">
				<svg width="14" height="14" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M9.66634 5.66634H5.66634V9.66634H4.33301V5.66634H0.333008V4.33301H4.33301V0.333008H5.66634V4.33301H9.66634V5.66634Z"/>
				</svg>
				<span>{{genericText.addSourceType}}</span>
			</div>
    	</div>
		<div class="ctf-fb-extppcustomizer-btns ctf-fb-fs">
			<button class="ctf-fb-source-btn ctf-fb-fs sb-btn-blue" @click.prevent.default="updateFeedTypeAndSourcesCustomizer()">
	            <div class="ctf-fb-icon-success"></div>
	            {{genericText.update}}
	        </button>
			<button class="ctf-fb-source-btn ctf-fb-fs sb-btn-grey" @click.prevent.default="cancelFeedTypeAndSourcesCustomizer()">
	            <div class="ctf-fb-icon-cancel"></div>
	            {{genericText.cancel}}
	        </button>
		</div>
	</div>
</div>