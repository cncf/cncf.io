<div class="ctf-feedtype-section ctf-fb-fs" v-for="(feedType, feedTypeID) in selectSourceScreen.multipleTypes" v-if="checkMultipleFeedTypeActive(feedTypeID)" :data-type="feedTypeID">
    <button class="ctf-fd-lst-btn ctf-fd-lst-btn-delete ctf-fb-tltp-parent" :data-greyed="selectedFeed.length == 1 ? 'true' : false" @click.prevent.default="removeFeedTypeSource(feedTypeID)">
         <div class="ctf-fb-tltp-elem"><span v-html="selectedFeed.length == 1 ? genericText.atLeastOneSource.replace(/ /g,'&nbsp;') : genericText.removeSource.replace(/ /g,'&nbsp;')">{{}}</span></div>
         <div v-html="svgIcons['delete']"></div>
     </button>
     <div class="ctf-feedtype-sec-heading ctf-fb-fs">
        <div class="ctf-feedtype-icon-wrap" v-html="svgIcons[feedType.icon]"></div>
        <div class="ctf-feedtype-sec-wrap">
            <div class="ctf-feedtype-sec-icon-heading ctf-fb-fs">
                <span v-html="feedType.heading"></span>
            </div>
            <div class="ctf-feedtype-sec-desc ctf-fb-fs sb-caption sb-lighter" v-html="feedType.description"></div>

            <div class="ctf-fb-fs" v-if="feedType.actionType == 'inputField'">
                <input type="text" v-if="customizerFeedData" class="ctf-fb-wh-inp ctf-fb-fs" v-model="selectedFeedModelPopup[feedTypeID]" :placeholder="feedType.placeHolder">
                <input type="text" v-else class="ctf-fb-wh-inp ctf-fb-fs" v-model="selectedFeedModel[feedTypeID]" :placeholder="feedType.placeHolder">
            </div>

            <div class="ctf-fb-fs" v-if="feedType.actionType == 'connectAccount'">
                <div class="ctf-selected-source-item">
                    <div class="ctf-selected-source-item-avatar">
                        <img :src="accountDetails.account_avatar">
                    </div>
                    <span>@{{accountDetails.account_handle}}</span>
                </div>
                <button data-icon="left" class="ctf-fb-hd-btn sb-btn-blue sb-button-standard" @click.prevent.default="activateView('connectAccountPopup')">
                    <span v-html="svgIcons['twitter']"></span>
                    <span>{{genericText.connectDifferentAccount}}</span>
                </button>
            </div>

            <div class="ctf-fb-fs" v-if="feedType.actionType == 'customList'">

                <div class="ctf-customlist-chooser-ctn ctf-fb-fs">

                    <!-- Selected Top Begin -->
                    <div class="ctf-customlist-chooser-selected ctf-fb-fs">
                        <div class="ctf-customlist-chooser-selected-hd ctf-fb-fs">
                            <strong>{{genericText.selected}}</strong>
                            <a class="ctf-link-underlined" @click.prevent.default="removeAllLists()"  v-if="customizerFeedData ? selectedFeedModelPopup.listsObject.length > 0 : selectedFeedModel.listsObject.length > 0">{{genericText.deselectAll}}</a>
                        </div>

                        <div class="ctf-customlist-selected-list ctf-fb-fs">
                            <div class="ctf-customlist-selected-item" v-for="listItem in (customizerFeedData ? selectedFeedModelPopup.listsObject : selectedFeedModel.listsObject)">
                                <div class="ctf-customlist-selected-item-icon" v-html="svgIcons['lists']"></div>
                                <div class="ctf-customlist-selected-item-info">
                                    {{listItem.name}} (ID: {{listItem.id}})
                                </div>
                                <div class="ctf-customlist-selected-item-cls" @click.prevent.default="removeSingleItemFromList(listItem)"></div>
                            </div>

                        </div>
                    </div>

                    <!-- Add List Inputs -->
                    <div class="ctf-customlist-inputs-ctn ctf-fb-fs">

                        <div class="ctf-customlist-input-item ctf-customlist-input-addlist">
                            <div class="ctf-customlist-input-item-heading ctf-fb-fs">
                                <div v-html="svgIcons['addNewList']"></div>
                                <span>{{genericText.addNewList}}</span>
                            </div>
                            <div class="ctf-customlist-input-ctn ctf-fb-fs">
                                <input type="text" :placeholder="genericText.enterListID" v-model="listIdInputModel" v-on:keyup.enter="checkTwitterListById()">
                                <button class="sb-btn sb-btn-blue" @click.prevent.default="checkTwitterListById()">
                                    <span v-html="svgIcons['plus']"></span>
                                    {{genericText.add}}
                                </button>
                            </div>
                        </div>

                        <div class="ctf-customlist-input-item ctf-customlist-input-search">
                            <div class="ctf-customlist-input-item-heading ctf-fb-fs">
                                <div v-html="svgIcons['search']"></div>
                                <span>{{genericText.searchListUser}}</span>
                            </div>
                            <div class="ctf-customlist-input-ctn ctf-fb-fs">
                                <input type="text" :placeholder="genericText.enterUserName" v-model="listUserNameInputModel" v-on:keyup.enter="searchUserNameList()" v-on:keyup="noListFound = null">
                                <button class="sb-btn sb-btn-grey" @click.prevent.default="searchUserNameList()">
                                    <span v-html="svgIcons['search']"></span>
                                    {{genericText.showLists}}
                                </button>
                            </div>
                        </div>

                    </div>


                    <!-- List Results -->
                    <div class="ctf-customlist-results-ctn ctf-fb-fs">
                        <div class="ctf-customlist-results-success ctf-fb-fs" v-if="noListFound == null && listUserNameResult.length > 0">
                            <div class="ctf-customlist-results-success-hd ctf-fb-fs">
                                {{genericText.showingPublicLists}} <strong>{{printUserNameTwitterHandle(listUserNameInputModelSearched)}}</strong>
                            </div>

                            <div class="ctf-customlist-results-items ctf-fb-fs">

                                <div class="ctf-customlist-results-item" v-for="listItem in listUserNameResult"  @click.prevent.default="addItemtoList(listItem)" :data-active="checkListItemIncluded(listItem)">
                                    <div class="ctf-customlist-results-chkbx">
                                        <div><span></span></div>
                                    </div>
                                    <div class="ctf-customlist-results-item-info">
                                        <strong>{{listItem.name}}</strong>
                                        <span>ID: {{listItem.id}}</span>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="ctf-customlist-results-error ctf-fb-fs" v-if="noListFound === true">
                            <div class="ctf-customlist-error-icon">!</div>
                            <div class="ctf-customlist-error-msg">
                                <span>{{genericText.couldntFetchList}} <strong>{{printUserNameTwitterHandle(listUserNameInputModel)}}</strong>.</span><br/>
                                <span>{{genericText.tryDifferentName}}</span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>
</div>