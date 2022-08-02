<script type="text/x-template" id="sb-add-source-component">
    <div class="ctf-fb-source-ctn sb-fs-boss ctf-fb-center-boss" v-if="viewsActive.sourcePopup">
        <!--START Source Popup on the Customizer-->
        <div class="ctf-fb-source-popup ctf-fb-popup-inside ctf-fb-source-pp-customizer" v-bind:class="{ 'ctf-narrower-modal' : typeof viewsActive.sourcePopupScreen !== 'undefined' && viewsActive.sourcePopupScreen === 'step_4' }" v-if="viewsActive.sourcePopupType == 'customizer'">
            <div class="ctf-fb-popup-cls" @click.prevent.default="$parent.closeSourceCustomizer()">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14 1.41L12.59 0L7 5.59L1.41 0L0 1.41L5.59 7L0 12.59L1.41 14L7 8.41L12.59 14L14 12.59L8.41 7L14 1.41Z" fill="#141B38"/>
                </svg>
            </div>
            <div class="ctf-fb-source-top ctf-fb-fs">
                <h3>{{selectSourceScreen.updateHeading}}</h3>
                <div class="ctf-fb-srcs-desc">{{selectSourceScreen.updateDescription}}</div>
                <div class="ctf-fb-srcslist-ctn ctf-fb-fs">
                    <div class="ctf-fb-srcs-item ctf-fb-srcs-new" @click.prevent.default="$parent.activateView('sourcePopup', 'creationRedirect')">
                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.66634 5.66634H5.66634V9.66634H4.33301V5.66634H0.333008V4.33301H4.33301V0.333008H5.66634V4.33301H9.66634V5.66634Z" fill="#0096CC"/>
                        </svg>
                        <span class="sb-small-p sb-bold">{{genericText.addNew}}</span>
                    </div>
                    <div class="ctf-fb-srcs-item" v-for="(source, sourceIndex) in sourcesList" @click.prevent.default="$parent.selectSourceCustomizer(source)" :data-type="source.account_type"
                         :data-active="$parent.isSourceActiveCustomizer(source)"
                         :data-test="(Array.isArray($parent.customizerFeedData.settings.sources.map) || $parent.customizerFeedData.settings.sources instanceof Object ) && $parent.customizerFeedData.settings.sources.map(s => s.account_id).includes(source.account_id)"
                    >
                        <div class="ctf-fb-srcs-item-chkbx">
                            <div class="ctf-fb-srcs-item-chkbx-ic"></div>
                        </div>
                        <div class="ctf-fb-srcs-item-avatar" v-if="$parent.returnAccountAvatar(source)">
                            <img :src="$parent.returnAccountAvatar(source)">
                        </div>
                        <div class="ctf-fb-srcs-item-inf">
                            <div class="ctf-fb-srcs-item-name"><span class="sb-small-p sb-bold" v-html="source.username"></span></div>
                            <div class="ctf-fb-left-boss">
                                <div class="ctf-fb-srcs-item-type">
                                    <div v-html="source.account_type == 'business' ? svgIcons['users'] : svgIcons['flag']"></div>
                                    <span class="sb-small sb-lighter" v-html="source.account_type"></span>
                                </div>
                                <div v-if="source.error !== ''" class="sb-source-error-wrap">
                                    <span v-html="genericText.invalid"></span><a href="#" @click.prevent.default="$parent.activateView('sourcePopupType', 'creation')" v-html="genericText.reconnect"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ctf-fb-srcs-update-ctn ctf-fb-fs">
                    <button class="ctf-fb-srcs-update sb-btn ctf-fb-fs sb-btn-orange" @click.prevent.default="$parent.activateView('sourcePopup', 'updateCustomizer', 'feedFlyPreview')">
                        <svg width="16" height="12" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M6.08058 8.36133L14.0355 0.406383L15.8033 2.17415L6.08058 11.8969L0.777281 6.59357L2.54505 4.8258L6.08058 8.36133Z" fill="white"/>
                        </svg>
                        <span>{{genericText.update}}</span>
                    </button>
                </div>
            </div>
        </div>
        <!--END Source Popup on the Customizer-->

        <div class="ctf-fb-source-popup ctf-fb-popup-inside" v-bind:class="{ 'ctf-narrower-modal' : typeof viewsActive.sourcePopupScreen !== 'undefined' && viewsActive.sourcePopupScreen === 'step_4' }" v-if="viewsActive.sourcePopupType != 'customizer'" :data-step="viewsActive.sourcePopupScreen">
            <div class="ctf-fb-popup-cls" @click.prevent.default="$parent.activateView('sourcePopup')" v-if="viewsActive.sourcePopupScreen != 'redirect_1'">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14 1.41L12.59 0L7 5.59L1.41 0L0 1.41L5.59 7L0 12.59L1.41 14L7 8.41L12.59 14L14 12.59L8.41 7L14 1.41Z" fill="#141B38"/>
                </svg>
            </div>
            <!-- Step One Select Source -->
            <div class="ctf-fb-source-step1 ctf-fb-fs" v-if="viewsActive.sourcePopupScreen == 'step_1'" v-bind:class="{ 'ctf-has-alert' : typeof window.ctfSelectedFeed !== 'undefined' && window.ctfSelectedFeed !== 'user'}">
                <div class="ctf-fb-source-top ctf-fb-fs">
                    <div class="ctf-fb-fs" v-if="viewsActive.sourcePopupType === 'customizer'">
                        <div class="ctf-fb-src-back-top" @click.prevent.default="$parent.activateView('sourcePopup', 'updateCustomizer')">
                            <svg width="6" height="9" viewBox="0 0 6 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.27398 1.44L4.33398 0.5L0.333984 4.5L4.33398 8.5L5.27398 7.56L2.22065 4.5L5.27398 1.44Z" fill="#434960"/>
                            </svg>
                            {{selectSourceScreen.mainHeading}}
                        </div>
                    </div>
                    <h3>{{selectSourceScreen.modal.addNew}}</h3>
                    <div class="sb-alert" v-if="checkDisclaimer()">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.99935 0.666504C4.39935 0.666504 0.666016 4.39984 0.666016 8.99984C0.666016 13.5998 4.39935 17.3332 8.99935 17.3332C13.5993 17.3332 17.3327 13.5998 17.3327 8.99984C17.3327 4.39984 13.5993 0.666504 8.99935 0.666504ZM9.83268 13.1665H8.16602V11.4998H9.83268V13.1665ZM9.83268 9.83317H8.16602V4.83317H9.83268V9.83317Z" fill="#995C00"></path>
                        </svg>
                        <span class="sb-caption" v-html="printDisclaimer()"></span>
                    </div>
                    <div class="ctf-fb-stp1-elm ctf-fb-fs">
                        <div class="ctf-fb-stp1-elm-ic">1</div>
                        <div class="ctf-fb-stp1-elm-txt">
                            <div class="ctf-fb-stp1-elm-head sb-small-p sb-bold sb-dark-text">{{selectSourceScreen.modal.selectSourceType}}</div>
                        </div>
                        <div class="ctf-fb-stp1-elm-act ctf-fb-stp-src-ctn">
                            <div class="ctf-fb-stp-src-type sb-small-p sb-dark-text" :data-disabled="(typeof window.ctfSelectedFeed !== 'undefined' && window.ctfSelectedFeed[0] !== 'user')" :data-active="(typeof window.ctfSelectedFeed === 'undefined' || window.ctfSelectedFeed[0] === 'user') && addNewSource.typeSelected !== 'business'" @click.prevent.default="typeof window.ctfSelectedFeed === 'undefined' || window.ctfSelectedFeed[0] === 'user' ? addNewSource.typeSelected = 'personal' : addNewSource.typeSelected = 'business'">
                                <div class="ctf-fb-chbx-round"></div>{{selectSourceScreen.personal}}
                            </div>
                            <div class="ctf-fb-stp-src-type sb-small-p sb-dark-text" :data-active="addNewSource.typeSelected == 'business'" @click.prevent.default="addNewSource.typeSelected = 'business'">
                                <div class="ctf-fb-chbx-round"></div>{{selectSourceScreen.business}}
                            </div>

                            <div class="ctf-fb-stp-src-type ctf-not-sure-wrap sb-small-p sb-dark-text">
                                <span class="ctf-flex-center-center"><svg viewBox="0 0 14 14" width="14px" fill="#434960"><path d="M6.33203 4.99992H7.66536V3.66659H6.33203V4.99992ZM6.9987 12.3333C4.0587 12.3333 1.66536 9.93992 1.66536 6.99992C1.66536 4.05992 4.0587 1.66659 6.9987 1.66659C9.9387 1.66659 12.332 4.05992 12.332 6.99992C12.332 9.93992 9.9387 12.3333 6.9987 12.3333ZM6.9987 0.333252C6.12322 0.333252 5.25631 0.50569 4.44747 0.840722C3.63864 1.17575 2.90371 1.66682 2.28465 2.28587C1.03441 3.53612 0.332031 5.23181 0.332031 6.99992C0.332031 8.76803 1.03441 10.4637 2.28465 11.714C2.90371 12.333 3.63864 12.8241 4.44747 13.1591C5.25631 13.4941 6.12322 13.6666 6.9987 13.6666C8.76681 13.6666 10.4625 12.9642 11.7127 11.714C12.963 10.4637 13.6654 8.76803 13.6654 6.99992C13.6654 6.12444 13.4929 5.25753 13.1579 4.4487C12.8229 3.63986 12.3318 2.90493 11.7127 2.28587C11.0937 1.66682 10.3588 1.17575 9.54992 0.840722C8.74108 0.50569 7.87418 0.333252 6.9987 0.333252ZM6.33203 10.3333H7.66536V6.33325H6.33203V10.3333Z"></path></svg>
                                    {{selectSourceScreen.notSure}}</span>

                                <div class="ctf-fb-onbrd-tltp-elem ctf-not-sure-tooltip sb-tr-2">
                                    <div class="ctf-fb-onbrd-tltp-txt sb-small-p sb-lighter">
                                        {{selectSourceScreen.modal.notSureTooltip}}
                                    </div>
                                    <div class="sb-pointer sb-bottom-pointer">
                                        <svg width="20" height="10" viewBox="0 0 20 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M11.4142 8.58579C10.6332 9.36683 9.36684 9.36683 8.58579 8.58579L0 0L20 0L11.4142 8.58579Z" fill="white"/>
                                        </svg>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="ctf-fb-stp1-elm ctf-fb-fs">
                        <div class="ctf-fb-stp1-elm-ic">2</div>
                        <div class="ctf-fb-stp1-elm-txt">
                            <div class="ctf-fb-stp1-elm-head sb-small-p sb-bold sb-dark-text">{{selectSourceScreen.modal.connectAccount}}</div>
                            <div class="ctf-fb-stp1-elm-desc sb-caption sb-caption-lighter">{{selectSourceScreen.modal.connectAccountDescription}}</div>
                        </div>
                        <div class="ctf-fb-stp1-elm-act">
                            <button class="sb-btn ctf-fb-stp1-connect sb-btn-blue" @click.prevent.default="processIFConnect()">
                                <a class="ctf-fb-fs-link"></a>
                                <div v-html="svgIcons['instagram']"></div>
                                {{selectSourceScreen.modal.connect}}
                            </button>
                        </div>
                    </div>

                </div>
                <div class="ctf-fb-source-bottom ctf-fb-fs">
                    <div class="ctf-manual-question">
                        <svg width="20" height="15" viewBox="0 0 20 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19.6004 7.4998L15.0748 12.0254L13.9436 10.8942L17.338 7.4998L13.9436 4.1054L15.0748 2.9742L19.6004 7.4998ZM2.66279 7.4998L6.05719 10.8942L4.92599 12.0254L0.400391 7.4998L4.92599 2.9742L6.05639 4.1054L2.66279 7.4998ZM8.23079 14.6998H6.52839L11.77 0.299805H13.4724L8.23079 14.6998Z" fill="#141B38"/>
                        </svg>

                        <div class="ctf-fb-source-btm-hd sb-small-p sb-bold sb-dark-text">{{selectSourceScreen.modal.alreadyHave}}</div>
                    </div>
                    <button class="ctf-fb-hd-btn ctf-fb-src-add-manual sb-btn-grey" @click.prevent.default="$parent.switchScreen('sourcePopupScreen','step_3')">
                        <svg width="12" height="13" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11.8327 7.33317H6.83268V12.3332H5.16602V7.33317H0.166016V5.6665H5.16602V0.666504H6.83268V5.6665H11.8327V7.33317Z" fill="#141B38"/>
                        </svg>
                        <span class="sb-small-p sb-bold sb-dark-text">{{selectSourceScreen.modal.addManuallyLink}}</span>
                    </button>
                </div>
            </div>

            <div class="sb-fb-source-redirect sb-fb-fs" v-if="viewsActive.sourcePopupScreen == 'redirect_1'" >
                <div class="sb-fb-source-redirect-ld sb-fb-fs">
                    <div></div>
                </div>
                <div class="sb-fb-source-redirect-info sb-fb-fs">
                    <strong class="sb-fb-fs">{{genericText.redirectLoading.heading}}</strong>
                    <p class="sb-fb-fs">{{genericText.redirectLoading.description}}</p>
                </div>
            </div>

            <!-- Step Two Show Accounts Connected to -->
            <div class="ctf-fb-source-step2 ctf-fb-fs" v-if="viewsActive.sourcePopupScreen == 'step_2'">
                <div class="ctf-fb-source-top ctf-fb-fs">
                    <div class=" ctf-fb-fs">
                        <div class="ctf-fb-src-back-top" @click.prevent.default="$parent.switchScreen('sourcePopupScreen','step_1')">
                            <svg width="6" height="9" viewBox="0 0 6 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.27398 1.44L4.33398 0.5L0.333984 4.5L4.33398 8.5L5.27398 7.56L2.22065 4.5L5.27398 1.44Z" fill="#434960"/>
                            </svg>
                            {{selectSourceScreen.modal.addNew}}
                        </div>
                    </div>
                    <div v-if="typeof $parent.newSourceData !== 'undefined' && typeof $parent.newSourceData.error !== 'undefined'" class="ctf-businesses-connect-actions">
                        <div class="sb-alert">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.99935 0.666504C4.39935 0.666504 0.666016 4.39984 0.666016 8.99984C0.666016 13.5998 4.39935 17.3332 8.99935 17.3332C13.5993 17.3332 17.3327 13.5998 17.3327 8.99984C17.3327 4.39984 13.5993 0.666504 8.99935 0.666504ZM9.83268 13.1665H8.16602V11.4998H9.83268V13.1665ZM9.83268 9.83317H8.16602V4.83317H9.83268V9.83317Z" fill="#995C00"/>
                            </svg>
                            <span><strong v-html="$parent.genericText.errorNotice"></strong></span><br>
                            <span class="sb-caption"><span v-html="$parent.genericText.error"></span> <span v-html="typeof $parent.newSourceData.error.code !== 'undefined' ? $parent.newSourceData.error.code : ''"></span><br><span v-html="$parent.newSourceData.error.message"></span></span>
                            <br><span class="sb-caption" v-html="$parent.genericText.errorDirections"></span>
                        </div>
                    </div>
                    <div v-if="typeof $parent.newSourceData === 'undefined' || typeof $parent.newSourceData.error === 'undefined'" >
                        <h3>{{selectSourceScreen.modal.selectAccount}}</h3>
                        <div class="ctf-fb-source-account-info ctf-fb-fs">
                            <span class="sb-small-p sb-bold">{{selectSourceScreen.modal.showing}} <strong>{{selectSourceScreen.modal.businesses}}</strong> {{selectSourceScreen.modal.connectedTo}}</span>
                            <img :src="$parent.hasOwnNestedProperty(newSourceData,'user.picture.data.url') ? newSourceData.user.picture.data.url : ''"> <strong v-if="$parent.hasOwnNestedProperty(newSourceData,'user.name')" v-html="newSourceData.user.name"></strong>
                            <button class="ctf-fb-hd-btn ctf-fb-src-change sb-btn-grey" @click="processIFConnect()">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0.5 12.3749V15.4999H3.625L12.8417 6.2832L9.71667 3.1582L0.5 12.3749ZM15.8417 3.2832L12.7167 0.158203L10.6083 2.27487L13.7333 5.39987L15.8417 3.2832Z" fill="#141B38"/>
                                </svg>
                                <span class="sb-small-p sb-bold sb-dark-text">{{genericText.change}}</span>
                            </button>
                        </div>
                        <div class="ctf-fb-source-list ctf-fb-fs">
                            <div class="ctf-fb-srcs-item" v-for="(source, sourceIndex) in returnedApiSourcesList" @click.prevent.default="selectSourcesToConnect(source)" :data-active="selectedSourcesToConnect.includes(source.account_id)" >
                                <div class="ctf-fb-srcs-item-chkbx">
                                    <div class="ctf-fb-srcs-item-chkbx-ic"></div>
                                </div>
                                <div class="ctf-fb-srcs-item-avatar" v-if="returnAccountAvatar(source)">
                                    <img :src="returnAccountAvatar(source)">
                                </div>
                                <div class="ctf-fb-srcs-item-inf">
                                    <div class="ctf-fb-srcs-item-name"><span class="sb-small-p sb-bold sb-dark-text" v-html="source.username"></span></div>
                                    <div class="ctf-fb-srcs-item-type">
                                        <div class="sb-details-wrap ctf-flex-center-center">
                                            <div class="ctf-fb-srcs-item-svg" v-html="svgIcons['flag']"></div>
                                            <span class="sb-small" v-html="selectSourceScreen.business"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button v-if="addNewSource.typeSelected !== 'business'" class="ctf-fb-source-btn ctf-fb-fs sb-btn-blue"  @click.prevent.default="addSourcesOnConnect()">
                            <div class="ctf-fb-icon-success"></div>
                            {{genericText.add}}
                        </button>
                        <div class="ctf-businesses-connect-actions" v-if="addNewSource.typeSelected === 'business'">
                            <div class="sb-alert">
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8.99935 0.666504C4.39935 0.666504 0.666016 4.39984 0.666016 8.99984C0.666016 13.5998 4.39935 17.3332 8.99935 17.3332C13.5993 17.3332 17.3327 13.5998 17.3327 8.99984C17.3327 4.39984 13.5993 0.666504 8.99935 0.666504ZM9.83268 13.1665H8.16602V11.4998H9.83268V13.1665ZM9.83268 9.83317H8.16602V4.83317H9.83268V9.83317Z" fill="#995C00"/>
                                </svg>
                                <span class="sb-caption" v-html="selectSourceScreen.modal.disclaimer"></span>
                            </div>
                            <button class="ctf-fb-source-btn ctf-fb-source-btn-next ctf-fb-fs sb-btn-blue"  @click.prevent.default="$parent.switchScreen('sourcePopupScreen','step_4')" :data-active="typeof window.ctfSelected !== 'undefined' && window.ctfSelected.length ? 'true' : 'false'">
                                <span>{{genericText.next}}</span>
                                <svg width="7" height="11" viewBox="0 0 7 11" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.3332 0.00683594L0.158203 1.18184L3.97487 5.00684L0.158203 8.83184L1.3332 10.0068L6.3332 5.00684L1.3332 0.00683594Z" fill="white"></path></svg>
                            </button>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Step Three Connect Manually-->
            <div class="ctf-fb-source-step3 ctf-fb-fs" v-if="viewsActive.sourcePopupScreen == 'step_3'">
                <div class="ctf-fb-source-top ctf-fb-fs">
                    <div class=" ctf-fb-fs">
                        <div class="ctf-fb-src-back-top" @click.prevent.default="$parent.switchScreen('sourcePopupScreen','step_1')">
                            <svg width="6" height="9" viewBox="0 0 6 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.27398 1.44L4.33398 0.5L0.333984 4.5L4.33398 8.5L5.27398 7.56L2.22065 4.5L5.27398 1.44Z" fill="#434960"/>
                            </svg>
                            {{selectSourceScreen.modal.addNew}}
                        </div>
                    </div>
                    <h3>{{selectSourceScreen.modal.addManually}}</h3>
                    <div class="ctf-fb-fs">
                        <div class="ctf-fb-source-inp-label ctf-fb-fs"><span class="sb-caption sb-caption-lighter">{{selectSourceScreen.modal.sourceType}}</span></div>
                        <div class="ctf-fb-source-mnl-type ctf-fb-fs">
                            <div class="ctf-fb-stp1-elm-act ctf-fb-stp-src-ctn">
                                <div class="ctf-fb-stp-src-type" :data-active="addNewSource.typeSelected == 'personal'" @click.prevent.default="addNewSource.typeSelected = 'personal'">
                                    <div class="ctf-fb-chbx-round"></div><span class="sb-small-p sb-dark-text">{{selectSourceScreen.personal}}</span>
                                </div>
                                <div class="ctf-fb-stp-src-type" :data-active="addNewSource.typeSelected == 'business'" @click.prevent.default="addNewSource.typeSelected = 'business'">
                                    <div class="ctf-fb-chbx-round"></div><span class="sb-small-p sb-dark-text">{{selectSourceScreen.business}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ctf-fb-source-inputs ctf-fb-fs">
                        <div class="ctf-fb-source-inp-label ctf-fb-fs"><span class="sb-caption sb-caption-lighter">{{selectSourceScreen.modal.accountID}}</span></div>
                        <input type="text" class="ctf-fb-source-inp ctf-fb-fs" v-model="addNewSource.manualSourceID" :placeholder="selectSourceScreen.modal.enterID">
                        <div class="ctf-fb-source-inp-label ctf-fb-fs"><span class="sb-caption sb-caption-lighter">{{selectSourceScreen.modal.accessToken}}</span></div>
                        <input type="text" class="ctf-fb-source-inp ctf-fb-fs" v-model="addNewSource.manualSourceToken" :placeholder="selectSourceScreen.modal.enterToken">
                    </div>
                    <button class="ctf-fb-source-btn ctf-fb-fs sb-btn-blue sb-account-connection-button" @click.prevent.default="addSourceManually()" :data-active="checkManualEmpty() && loadingAjax == false ? 'true' : 'false'">
                        <div v-if="loadingAjax === false" class="ctf-fb-icon-success"></div>
                        <span v-if="loadingAjax === false">{{genericText.add}}</span>
                        <span v-if="loadingAjax" class="spinner" style="display: inline-block;visibility: visible;margin: 1px;"></span>
                    </button>

                </div>
            </div>

            <!-- Step Four Business Account Exists Notice -->
            <div class="ctf-fb-source-step4 ctf-fb-fs" v-if="viewsActive.sourcePopupScreen == 'step_4'">
                <div class="ctf-source-account-box ctf-fb-fs">
                    <div class="ctf-connecting-account-item" v-for="(source, sourceIndex) in returnedApiSourcesList" @click.prevent.default="selectSourcesToConnect(source)" :data-active="selectedSourcesToConnect.includes(source.account_id)" >
                        <div class="ctf-fb-srcs-item-avatar" v-if="$parent.returnAccountAvatar(source)">
                            <img :src="$parent.returnAccountAvatar(source)">
                        </div>
                        <div class="ctf-connecting-account-info">
                            <div class="ctf-fb-srcs-item-name">
                                <span class="sb-small-p sb-bold sb-dark-text" v-html="source.username"></span>
                            </div>
                            <div class="ctf-fb-srcs-item-type">
                                <div class="sb-details-wrap ctf-flex-center-center">
                                    <div class="ctf-fb-srcs-item-svg" v-html="svgIcons['users']"></div>
                                    <span class="sb-small" v-html="selectSourceScreen.personal"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ctf-fb-source-top ctf-fb-fs">
                    <h3>{{selectSourceScreen.modal.alreadyExists}}</h3>
                    <p>{{selectSourceScreen.modal.alreadyExistsExplanation}}</p>
                </div>
                <div class="sb-two-buttons-wrap">
                    <button class="ctf-fb-source-btn sb-btn-blue" @click.prevent.default="addSourcesOnConnect()">
                        {{selectSourceScreen.modal.replaceWithPersonal}}
                    </button>
                    <button class="ctf-fb-source-btn sb-btn-grey" @click.prevent.default="$parent.switchScreen('sourcePopupScreen','step_1')">
                        {{genericText.cancel}}
                    </button>
                </div>
            </div>

        </div>
    </div>
</script>