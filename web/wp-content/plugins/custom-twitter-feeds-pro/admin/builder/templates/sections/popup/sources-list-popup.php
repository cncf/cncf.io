<div class="ctf-fb-sourcelist-pp-ctn sb-fs-boss ctf-fb-center-boss" v-if="viewsActive.sourcesListPopup" data-source="active">
	<div class="ctf-fb-source-popup ctf-fb-popup-inside ctf-fb-source-pp-customizer">
		<div class="ctf-fb-popup-cls" @click.prevent.default="toggleFeedTypesSourcesPopup()">
			<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M14 1.41L12.59 0L7 5.59L1.41 0L0 1.41L5.59 7L0 12.59L1.41 14L7 8.41L12.59 14L14 12.59L8.41 7L14 1.41Z" fill="#141B38"/>
			</svg>
		</div>
		<div class="ctf-fb-source-top ctf-fb-fs">
			<h3 v-html="feedTypeOnSourcePopup == 'user' ? selectSourceScreen.sourcesListPopup.user.mainHeading : selectSourceScreen.sourcesListPopup.tagged.mainHeading"></h3>
			<div class="ctf-fb-srcs-desc"  v-html="feedTypeOnSourcePopup == 'user' ? selectSourceScreen.sourcesListPopup.user.description : selectSourceScreen.sourcesListPopup.tagged.description"></div>
		</div>

		<div class="ctf-fb-sourcelist-pp">
			<div class="ctf-fb-srcslist-ctn ctf-fb-fs" v-if="sourcesList.length > 0">
				<div class="ctf-fb-srcs-item ctf-fb-srcs-new" @click.prevent.default="activateView('sourcePopup', 'creationRedirect')">
					<svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M9.66634 5.66634H5.66634V9.66634H4.33301V5.66634H0.333008V4.33301H4.33301V0.333008H5.66634V4.33301H9.66634V5.66634Z" fill="#0096CC"/>
					</svg>
					<span class="sb-small-p sb-bold">{{genericText.addNew}}</span>
				</div>
				<div class="ctf-fb-srcs-item ctf-fb-onbrd-tltp-parent ctf-fb-onbrd-tltp-center-top ctf-fb-onbrd-tltp-hover" v-for="(source, sourceIndex) in sourcesList" @click.prevent.default="selectSourcePopup(source)" :data-type="source.account_type" :data-active="isSourceSelectActivePopup(source)"  :data-disabled="checkSourceDisabledPopup(source)">
					<div class="ctf-fb-onbrd-tltp-elem" v-if="checkSourceDisabledPopup(source)">
						<p v-if="checkSourceDisabledPopup(source)" class="ctf-fb-onbrd-tltp-txt" v-for="perosnalAccountToolTipTxt in selectSourceScreen.perosnalAccountToolTipTxt" v-html="perosnalAccountToolTipTxt.replace(/ /g,' ')"></p>
					</div>

					<div class="ctf-fb-srcs-item-chkbx">
						<div class="ctf-fb-srcs-item-chkbx-ic"></div>
					</div>
                    <div class="ctf-fb-srcs-item-avatar" v-if="returnAccountAvatar(source)">
                        <img :src="returnAccountAvatar(source)">
                    </div>
					<div class="ctf-fb-srcs-item-inf">
						<div class="ctf-fb-srcs-item-name sb-small-p sb-bold"><span>{{source.username}}</span></div>
						<div class="ctf-fb-left-boss">
							<div class="ctf-fb-srcs-item-type">
								<div v-html="source.account_type == 'personal' ? svgIcons['user'] : svgIcons['flag']"></div>
								<span class="sb-small sb-lighter">{{source.account_type}}</span>
							</div>

							<div v-if="source.error !== ''" class="sb-source-error-wrap">
								<svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M6.50008 0.666664C3.28008 0.666664 0.666748 3.28 0.666748 6.5C0.666748 9.72 3.28008 12.3333 6.50008 12.3333C9.72008 12.3333 12.3334 9.72 12.3334 6.5C12.3334 3.28 9.72008 0.666664 6.50008 0.666664ZM7.08342 9.41667H5.91675V8.25H7.08342V9.41667ZM7.08342 7.08333H5.91675V3.58333H7.08342V7.08333Z" fill="#D72C2C"/>
								</svg>
								<span v-html="genericText.errorSource"></span><a href="#" @click.prevent.default="activateView('sourcePopupType', 'creation')" v-html="genericText.reconnect"></a>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>


		<div class="ctf-fb-addsourtype-ctn ctf-fb-fs">
			<button class="ctf-fb-source-btn ctf-fb-fs sb-btn-blue"  @click.prevent.default="addSourceToFeedType()">
				<div class="ctf-fb-icon-success"></div>
				{{genericText.add}}
			</button>
		</div>

	</div>
</div>