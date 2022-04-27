<div class="ctf-fb-types-ctn ctf-fb-fs sb-box-shadow" v-if="viewsActive.selectedFeedSection == 'feedsType'">
	<div class="ctf-fb-types ctf-fb-fs">
		<h4>{{selectFeedTypeScreen.feedTypeHeading}}</h4>
		<span class="ctf-fb-types-desc">{{selectFeedTypeScreen.mainDescription}}</span>
		<div class="ctf-fb-types-list">
			<div class="ctf-fb-type-el" v-for="(feedTypeEl, feedTypeIn) in feedTypes" :data-active="selectedFeed.includes(feedTypeEl.type) && feedTypeEl.type != 'socialwall'" :data-type="feedTypeEl.type" @click.prevent.default="chooseFeedType(feedTypeEl)">
				<div class="ctf-fb-type-el-img ctf-fb-fs" v-html="svgIcons[feedTypeEl.icon]"></div>
				<div class="ctf-fb-type-el-info ctf-fb-fs">
					<span class="sb-small-p sb-bold sb-dark-text" v-html="feedTypeEl.title"></span>

					<span class="sb-caption sb-lightest sb-small-text">{{feedTypeEl.description}}</span>
				</div>
			</div>

		</div>
	</div>

</div>