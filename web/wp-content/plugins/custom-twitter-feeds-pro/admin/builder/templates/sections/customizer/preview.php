<div class="sb-customizer-preview" :data-preview-device="customizerScreens.previewScreen">
	<?php
		/**
		 * CFF Admin Notices
		 *
		 * @since 2.0
		 */
		do_action('ctf_admin_notices');

		$feed_id = ! empty( $_GET['feed_id'] ) ? (int)$_GET['feed_id'] : 0;
	?>
	<div class="sb-preview-ctn sb-tr-2">
		<div class="sb-preview-top-chooser ctf-fb-fs">
			<strong :class="getModerationShoppableMode == true ? 'ctf-moderate-heading' :''" v-html="getModerationShoppableMode == false ? genericText.preview : ( svgIcons['eyePreview'] + '' + genericText.moderationModePreview )"></strong>
			<div class="sb-preview-chooser" v-if="getModerationShoppableMode == false">
				<button class="sb-preview-chooser-btn" v-for="device in previewScreens" v-bind:class="'sb-' + device" v-html="svgIcons[device]" @click.prevent.default="switchCustomizerPreviewDevice(device)" :data-active="customizerScreens.previewScreen == device"></button>
			</div>
		</div>

		<div class="ctf-preview-ctn ctf-fb-fs">
			<div>
				<component :is="{template}"></component>
			</div>
			<?php
				include_once CTF_BUILDER_DIR . 'templates/preview/light-box.php';
			?>
		</div>

	</div>
	<ctf-dummy-lightbox-component :dummy-light-box-screen="dummyLightBoxScreen" :customizer-feed-data="customizerFeedData"></ctf-dummy-lightbox-component>
</div>


