<div class="ctf-fb-types-ctn ctf-fb-templates-ctn ctf-fb-fs sb-box-shadow" v-if="viewsActive.selectedFeedSection == 'selectTemplate'">
	<div class="ctf-fb-types ctf-fb-fs">
		<h4>{{selectFeedTemplateScreen.feedTemplateHeading}}</h4>
		<p class="sb-caption sb-lighter">{{selectFeedTemplateScreen.feedTemplateDescription}}</p>
		<div class="ctf-fb-templates-list">
			<div class="ctf-fb-type-el" v-for="(feedTemplateEl, feedTemplateIn) in feedTemplates" :data-active="selectedFeedTemplate === feedTemplateEl.type" @click.prevent.default="chooseFeedTemplate(feedTemplateEl)">
				<div :class="['ctf-fb-type-el-img ctf-fb-fs', 'ctf-feedtemplate-' + feedTemplateEl.type]" v-html="svgIcons[feedTemplateEl.icon]"></div>
				<div class="ctf-fb-type-el-info ctf-fb-fs">
					<p class="sb-small-p sb-bold sb-dark-text" v-html="feedTemplateEl.title"></p>
				</div>
			</div>
		</div>
	</div>
</div>