<div id="ctf-settings" class="ctf-settings" :data-app-loaded="appLoaded ? 'true' : 'false'">
    <?php
        TwitterFeed\Admin\CTF_View::render( 'sections.header' );
        TwitterFeed\Admin\CTF_View::render( 'settings.content' );
        TwitterFeed\Admin\CTF_View::render( 'sections.sticky_widget' );
    ?>
    <div class="sb-control-elem-tltp-content" v-show="tooltip.hover" @mouseover.prevent.default="hoverTooltip(true)" @mouseleave.prevent.default="hoverTooltip(false)">
		<div class="sb-control-elem-tltp-txt" v-html="tooltip.text"></div>
	</div>

    <?php
	    include_once CTF_BUILDER_DIR . 'templates/sections/popup/license-learn-more-popup.php';
	    include_once CTF_BUILDER_DIR . 'templates/sections/popup/why-renew-license-popup.php';
    ?>
</div>