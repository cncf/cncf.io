<div class="ctf-fd-lst-bigctn ctf-fb-fs" v-if="feedsList != null && feedsList.length > 0">

	<div class="ctf-fd-lst-bulk-ctn ctf-fb-fs">
		<select class="ctf-fd-lst-bulk-select ctf-fb-select sb-caption" v-model="selectedBulkAction">
			<option value="false">{{allFeedsScreen.bulkActions}}</option>
			<option value="delete">{{genericText.delete}}</option>
		</select>
		<button class="ctf-fd-lst-bulk-btn ctf-btn-grey sb-button-small sb-button" @click.prevent.default="bulkActionClick()">{{genericText.apply}}</button>
		<div class="ctf-fd-lst-pagination-ctn" v-if="feedPagination.feedsCount != null && feedPagination.feedsCount > 0">
			<span class="ctf-fd-lst-count sb-caption">{{feedPagination.feedsCount +' '+ (feedPagination.feedsCount > 1 ? genericText.items : genericText.item)}}</span>
			<div class="ctf-fd-lst-pagination" v-if="feedPagination.pagesNumber != null && feedPagination.pagesNumber > 1">
				<button class="ctf-fd-lst-pgnt-btn ctf-fd-pgnt-prev sb-btn-grey" :data-active="feedPagination.currentPage == 1 ? 'false' : 'true'" :disabled="feedPagination.currentPage == 1" @click.prevent.default="feedListPagination('prev')"><</button>
				<span class="ctf-fd-lst-pgnt-info">
					{{feedPagination.currentPage}} of {{feedPagination.pagesNumber}}
				</span>
				<button class="ctf-fd-lst-pgnt-btn ctf-fd-pgnt-next sb-btn-grey" :data-active="feedPagination.currentPage == feedPagination.pagesNumber ? 'false' : 'true'" :disabled="feedPagination.currentPage == feedPagination.pagesNumber" @click.prevent.default="feedListPagination('next')">></button>
			</div>
		</div>
	</div>
    <div class="ctf-table-wrap" v-bind:class="{ 'sb-onboarding-highlight' : viewsActive.onboardingStep === 2 && allFeedsScreen.onboarding.type === 'single' }">
	<table>
		<thead class="ctf-fd-lst-thtf ctf-fd-lst-thead">
			<tr>
				<th>
					<div class="ctf-fd-lst-chkbx" @click.prevent.default="selectAllFeedCheckBox()" :data-active="checkAllFeedsActive()"></div>
				</th>
				<th>
					<span class="sb-caption sb-lighter">{{allFeedsScreen.columns.nameText}}</span>
				</th>
				<th>
					<span class="sb-caption sb-lighter">{{allFeedsScreen.columns.shortcodeText}}</span>
				</th>
				<th>
					<span class="sb-caption sb-lighter">{{allFeedsScreen.columns.instancesText}}</span>
				</th>
				<th class="ctf-fd-lst-act-th">
					<span class="sb-caption sb-lighter">{{allFeedsScreen.columns.actionsText}}</span>
				</th>
			</tr>
		</thead>
		<tbody  class="ctf-fd-lst-tbody">
			<tr v-for="(feed, feedIndex) in feedsList">
				<td>
					<div class="ctf-fd-lst-chkbx" @click.prevent.default="selectFeedCheckBox(feed.id)" :data-active="feedsSelected.includes(feed.id)"></div>
				</td>
				<td>
					<a :href="builderUrl+'&feed_id='+feed.id" class="ctf-fd-lst-name sb-small-p sb-bold">{{feed.feed_name}}</a>
					<span class="ctf-fd-lst-type sb-caption sb-lighter">{{ checkNotEmpty(feed.settings.type) ? feed.settings.type : 'Mixed' }}</span>
				</td>
				<td>
                    <div class="sb-flex-center">
                        <span class="ctf-fd-lst-shortcode sb-caption sb-lighter">[custom-twitter-feeds feed={{feed.id}}]</span>
                        <div class="ctf-fd-lst-shortcode-cp ctf-fd-lst-btn ctf-fb-tltp-parent" @click.prevent.default="copyToClipBoard('[custom-twitter-feeds feed='+feed.id+']')">
                            <div class="ctf-fb-tltp-elem"><span>{{(genericText.copy +' '+ genericText.shortcode).replace(/ /g,"&nbsp;")}}</span></div>
                            <div v-html="svgIcons['copy']"></div>
                        </div>
                    </div>
				</td>
				<td class="sb-caption sb-lighter">
                    <div class="sb-instances-cell">
                        <span>{{genericText.usedIn}} <span class="ctf-fb-view-instances ctf-fb-tltp-parent" :data-active="feed.instance_count < 1 ? 'false' : 'true'" @click.prevent.default="feed.instance_count > 0 ? viewFeedInstances(feed) : checkAllFeedsActive()">{{feed.instance_count + ' ' + (feed.instance_count !== 1 ? genericText.places : genericText.place)}} <div class="ctf-fb-tltp-elem" v-if="feed.instance_count > 0"><span>{{genericText.clickViewInstances.replace(/ /g,"&nbsp;")}}</span></div></span></span>
                    </div>
                </td>
				<td class="ctf-fd-lst-actions">
                    <div class="sb-flex-center">
                        <a class="ctf-fd-lst-btn ctf-fb-tltp-parent":href="builderUrl+'&feed_id='+feed.id">
                            <div class="ctf-fb-tltp-elem"><span>{{genericText.edit.replace(/ /g,"&nbsp;")}}</span></div>
                            <div v-html="svgIcons['edit']"></div>
                        </a>
                        <button class="ctf-fd-lst-btn ctf-fb-tltp-parent" @click.prevent.default="feedActionDuplicate(feed)">
                            <div class="ctf-fb-tltp-elem"><span>{{genericText.duplicate.replace(/ /g,"&nbsp;")}}</span></div>
                            <div v-html="svgIcons['duplicate']"></div>
                        </button>
                        <button class="ctf-fd-lst-btn ctf-fd-lst-btn-delete ctf-fb-tltp-parent" @click.prevent.default="openDialogBox('deleteSingleFeed', feed)">
                            <div class="ctf-fb-tltp-elem"><span>{{genericText.delete.replace(/ /g,"&nbsp;")}}</span></div>
                            <div v-html="svgIcons['delete']"></div>
                        </button>
                    </div>
				</td>

			</tr>
		</tbody>
		<tfoot class="ctf-fd-lst-thtf ctf-fd-lst-tfoot">
			<tr>
				<td>
					<div class="ctf-fd-lst-chkbx" @click.prevent.default="selectAllFeedCheckBox()" :data-active="checkAllFeedsActive()"></div>
				</td>
				<td>
					<span>{{allFeedsScreen.columns.nameText}}</span>
				</td>
				<td>
					<span>{{allFeedsScreen.columns.shortcodeText}}</span>
				</td>
				<td>
					<span>{{allFeedsScreen.columns.instancesText}}</span>
				</td>
				<td>
					<span>{{allFeedsScreen.columns.actionsText}}</span>
				</td>
			</tr>
		</tfoot>
	</table>
    </div>
</div>