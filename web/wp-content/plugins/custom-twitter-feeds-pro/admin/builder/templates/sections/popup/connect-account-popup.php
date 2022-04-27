<div class="ctf-fb-connectaccount-pp-ctn sb-fs-boss ctf-fb-center-boss" v-if="viewsActive.connectAccountPopup">
	<div class="ctf-fb-connectaccount-popup ctf-fb-popup-inside" data-step="1" v-if="viewsActive.connectAccountStep == 'step_1'">

		<div class="ctf-fb-popup-cls" @click.prevent.default="activateView('connectAccountPopup')">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M14 1.41L12.59 0L7 5.59L1.41 0L0 1.41L5.59 7L0 12.59L1.41 14L7 8.41L12.59 14L14 12.59L8.41 7L14 1.41Z" fill="#141B38"/>
            </svg>
        </div>

        <div class="ctf-fb-types ctf-fb-fs">
    	    <h4>{{connectAccountScreen.heading}}</h4>
    	    <div class="ctf-fb-srcs-desc">{{connectAccountScreen.description}}</div>
	    </div>

        <div class="ctf-fb-fs">
        	<button class="sb-btn ctf-fb-connectaccount-btn sb-btn-blue" @click.prevent.default="connectAccountLink()">
        		<div v-html="svgIcons['twitter']"></div>
        		{{genericText.connect}}
        	</button>
        </div>

        <div class="ctf-fb-source-bottom ctf-fb-fs">
        	<div class="ctf-manual-question">
        		<svg width="20" height="15" viewBox="0 0 20 15" fill="none" xmlns="http://www.w3.org/2000/svg">
        			<path d="M19.6004 7.4998L15.0748 12.0254L13.9436 10.8942L17.338 7.4998L13.9436 4.1054L15.0748 2.9742L19.6004 7.4998ZM2.66279 7.4998L6.05719 10.8942L4.92599 12.0254L0.400391 7.4998L4.92599 2.9742L6.05639 4.1054L2.66279 7.4998ZM8.23079 14.6998H6.52839L11.77 0.299805H13.4724L8.23079 14.6998Z" fill="#141B38"/>
        		</svg>

        		<div class="ctf-fb-source-btm-hd sb-small-p sb-bold sb-dark-text">{{connectAccountScreen.preferManually}}</div>
        	</div>
        	<button class="ctf-fb-hd-btn ctf-fb-src-add-manual sb-btn-grey" @click.prevent.default="switchScreen('connectAccountStep','step_2')">
        		<svg width="12" height="13" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg">
        			<path d="M11.8327 7.33317H6.83268V12.3332H5.16602V7.33317H0.166016V5.6665H5.16602V0.666504H6.83268V5.6665H11.8327V7.33317Z" fill="#141B38"/>
        		</svg>
        		<span class="sb-small-p sb-bold sb-dark-text">{{connectAccountScreen.addAppCred}}</span>
        	</button>
        </div>
	</div>

	<div class="ctf-fb-connectaccount-popup ctf-fb-popup-inside" data-step="2" v-if="viewsActive.connectAccountStep == 'step_2'">
		<div class="ctf-fb-popup-cls" @click.prevent.default="closeConnectAccountPopup()">
			<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M14 1.41L12.59 0L7 5.59L1.41 0L0 1.41L5.59 7L0 12.59L1.41 14L7 8.41L12.59 14L14 12.59L8.41 7L14 1.41Z" fill="#141B38"/>
			</svg>
		</div>
		<div class="ctf-fb-types ctf-fb-fs">
			<div class="ctf-fb-fs">
				<div class="ctf-fb-src-back-top" @click.prevent.default="switchScreen('connectAccountStep','step_1')">
					<svg width="6" height="9" viewBox="0 0 6 9" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M5.27398 1.44L4.33398 0.5L0.333984 4.5L4.33398 8.5L5.27398 7.56L2.22065 4.5L5.27398 1.44Z" fill="#434960"/>
					</svg>
					{{connectAccountScreen.connectNewAccount}}
				</div>
			</div>
			<h3>{{connectAccountScreen.heading_2}}</h3>
			<div class="ctf-fb-source-inputs ctf-fb-fs">
				<div class="ctf-fb-fs">
					<div class="ctf-fb-source-inp-label ctf-fb-fs"><span class="sb-caption sb-caption-lighter">{{connectAccountScreen.manualModal.name}}</span></div>
					<input type="text" class="ctf-fb-source-inp ctf-fb-fs" v-model="appCredentials.app_name" :placeholder="connectAccountScreen.manualModal.namePlhdr">
				</div>

				<div class="ctf-fb-source-inp-half ctf-fb-fs">
					<div class="ctf-fb-fs">
						<div class="ctf-fb-source-inp-label ctf-fb-fs"><span class="sb-caption sb-caption-lighter">{{connectAccountScreen.manualModal.consumerKey}}</span></div>
						<input type="text" class="ctf-fb-source-inp ctf-fb-fs" v-model="appCredentials.consumer_key" :placeholder="connectAccountScreen.manualModal.consumerKeyPlhdr">
					</div>
					<div class="ctf-fb-fs">
						<div class="ctf-fb-source-inp-label ctf-fb-fs"><span class="sb-caption sb-caption-lighter">{{connectAccountScreen.manualModal.consumerSecret}}</span></div>
						<input type="text" class="ctf-fb-source-inp ctf-fb-fs" v-model="appCredentials.consumer_secret" :placeholder="connectAccountScreen.manualModal.consumerSecretPlhdr">
					</div>
				</div>
				<div class="ctf-fb-source-inp-half ctf-fb-fs">
					<div class="ctf-fb-fs">
						<div class="ctf-fb-source-inp-label ctf-fb-fs"><span class="sb-caption sb-caption-lighter">{{connectAccountScreen.manualModal.accessToken}}</span></div>
						<input type="text" class="ctf-fb-source-inp ctf-fb-fs" v-model="appCredentials.access_token" :placeholder="connectAccountScreen.manualModal.accessTokenPlhdr">
					</div>
					<div class="ctf-fb-fs">
						<div class="ctf-fb-source-inp-label ctf-fb-fs"><span class="sb-caption sb-caption-lighter">{{connectAccountScreen.manualModal.accessTokenSecret}}</span></div>
						<input type="text" class="ctf-fb-source-inp ctf-fb-fs" v-model="appCredentials.access_token_secret" :placeholder="connectAccountScreen.manualModal.accessTokenSecretPlhdr">
					</div>
				</div>
				<strong v-show="manualAccountResp != false" class="ctf-fb-source-msg" :class="manualAccountResp === 'success' ? 'ctf-fb-source-msg-success' : 'ctf-fb-source-msg-error'" v-html="manualAccountResp === 'success' ? genericText.successManualAccount : genericText.errorManualAccount"></strong>
				<button class="ctf-fb-source-btn ctf-fb-fs sb-btn-blue sb-account-connection-button" :data-active="checkManualEmpty() && loadingAjax == false ? 'true' : 'false'" @click.prevent.default="connectManualAccount()">
					<div v-if="loadingAjax === false && manualAccountResp === 'success'" class="ctf-fb-icon-success"></div>
					<span v-if="loadingAjax === false">{{genericText.add}}</span>
					<span v-if="loadingAjax" class="spinner" style="display: inline-block;visibility: visible;margin: 1px;"></span>
				</button>

			</div>

		</div>
	</div>


</div>