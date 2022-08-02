<div id="ctf-builder-app" class="ctf-fb-fs ctf-builder-app" :data-app-loaded="appLoaded ? 'true' : 'false'">
	<?php
		$icons = TwitterFeed\Builder\CTF_Feed_Builder::builder_svg_icons();
		include_once CTF_BUILDER_DIR . 'templates/sections/header.php';
		include_once CTF_BUILDER_DIR . 'templates/screens/select-feed.php';
		include_once CTF_BUILDER_DIR . 'templates/screens/welcome.php';
		include_once CTF_BUILDER_DIR . 'templates/screens/customizer.php';
		include_once CTF_BUILDER_DIR . 'templates/sections/footer.php';
	?>
	<div class="sb-control-elem-tltp-content" v-show="tooltip.hover" @mouseover.prevent.default="hoverTooltip(true, 'inside')" @mouseleave.prevent.default="hoverTooltip(false, 'outside')">
		<div class="sb-control-elem-tltp-txt" v-html="tooltip.text" :data-align="tooltip.align"></div>
	</div>
</div>