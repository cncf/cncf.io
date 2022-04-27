<div class="ctf-fb-full-wrapper ctf-fb-fs">
	<?php
	/**
	 * SBI Admin Notices
	 *
	 * @since 2.0
	 */
	do_action('ctf_admin_notices');
	?>
    <div class="ctf-oembeds-container">
        <div class="ctf-section-header">
            <h3>{{genericText.title}}</h3>
            <p>{{genericText.description}}</p>
        </div>

        <div class="ctf-oembed-plugin-box-group">
            <div class="ctf-oembed-plugin-box ctf-oembed-instagram">
                <span class="oembed-icon" v-html="images.instaIcon"></span>
                <span class="oembed-text" v-if="instagram.doingOembeds">{{genericText.instagramOEmbedsEnabled}}</span>
                <span class="oembed-text" v-else="instagram.doingOembeds">{{genericText.instagramOEmbeds}}</span>
                <span class="ctf-oembed-btn">

                    <button v-if="instagram.doingOembeds" @click="disableInstaoEmbed()" class="ctf-btn disable-oembed" :class="{loading: instaoEmbedLoader}">
                        <span v-if="instaoEmbedLoader" v-html="loaderSVG"></span>
                        {{genericText.disable}}
                    </button>
                    <a v-else :href="connectionURL" class="ctf-btn-blue ctf-btn" :class="{loading: instaoEmbedLoader}" @click="instaoEmbedLoader = true">
                        <span v-if="instaoEmbedLoader" v-html="loaderSVG"></span>
                        {{genericText.enable}}
                    </a>
                </span>
            </div>
            <div class="ctf-oembed-plugin-box ctf-oembed-facebook">
                <span class="oembed-icon" v-html="images.fbIcon"></span>
                <span class="oembed-text" v-if="facebook.doingOembeds">{{genericText.facebookOEmbedsEnabled}}</span>
                <span class="oembed-text" v-else="facebook.doingOembeds">{{genericText.facebookOEmbeds}}</span>
                <span class="ctf-oembed-btn">

                    <button v-if="facebook.doingOembeds" @click="disableFboEmbed()" class="ctf-btn disable-oembed" :class="{loading: fboEmbedLoader}">
                        <span v-if="fboEmbedLoader" v-html="loaderSVG"></span>
                        {{genericText.disable}}
                    </button>
                    <button v-else @click="FacebookShouldInstallOrEnable()" class="ctf-btn ctf-btn-blue" :class="{loading: fboEmbedLoader}">
                        <span v-if="fboEmbedLoader" v-html="loaderSVG"></span>
                        {{genericText.enable}}
                    </button>
                </span>
            </div>

        </div>

        <div class="ctf-oembed-information">
            <div class="sb-box-header">
                <h3 v-if="isoEmbedsEnabled()">{{genericText.whatElseOembeds}}</h3>
                <h3 v-else>{{genericText.whatAreOembeds}}</h3>
            </div>
			<?php
			TwitterFeed\Admin\CTF_View::render( 'oembeds.oembed_features' );
			TwitterFeed\Admin\CTF_View::render( 'oembeds.plugin_info' );
			?>
        </div>
    </div>
</div>
<?php
TwitterFeed\Admin\CTF_View::render( 'oembeds.modal' );
?>