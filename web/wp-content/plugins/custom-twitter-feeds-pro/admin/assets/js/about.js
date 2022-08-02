var extensions_data = {
    genericText: ctf_about.genericText,
    links: ctf_about.links,
    extentions_bundle: ctf_about.extentions_bundle,
    supportPageUrl: ctf_about.supportPageUrl,
    plugins: ctf_about.pluginsInfo,
    stickyWidget: false,
    socialWallActivated: ctf_about.socialWallActivated,
    socialWallLinks: ctf_about.socialWallLinks,
    recommendedPlugins: ctf_about.recommendedPlugins,
    social_wall: ctf_about.social_wall,
    aboutBox: ctf_about.aboutBox,
    ajax_handler: ctf_about.ajax_handler,
    nonce: ctf_about.nonce,
    buttons: ctf_about.buttons,
    icons: ctf_about.icons,
    btnClicked: null,
    btnStatus: null,
    btnName: null,
}

var ctfAbout = new Vue({
    el: "#ctf-about",
    http: {
        emulateJSON: true,
        emulateHTTP: true
    },
    data: extensions_data,
    methods: {
        activatePlugin: function( plugin, name, index, type ) {
            this.btnClicked = index + 1;
            this.btnStatus = 'loading';
            this.btnName = name;

            let data = new FormData();
            data.append( 'action', 'ctf_activate_addon' );
            data.append( 'nonce', this.nonce );
            data.append( 'plugin', plugin );
            data.append( 'type', 'plugin' );
            if ( this.extentions_bundle && type == 'extension' ) {
                data.append( 'extensions_bundle', this.extentions_bundle );
            }
            fetch(this.ajax_handler, {
                method: "POST",
                credentials: 'same-origin',
                body: data
            })
            .then(response => response.json())
            .then(data => {
                if( data.success == true ) {
                    if ( name === 'social_wall' ) {
                        this.social_wall.activated = true;
                    } else if ( type === 'recommended_plugin' ) {
                        this.recommendedPlugins[name].activated = true;
                    } else {
                        this.plugins[name].activated = true;
                    }
                    this.btnClicked = null;
                    this.btnStatus = null;
                    this.btnName = null;
                }
            });
        },
        deactivatePlugin: function( plugin, name, index, type  ) {
            this.btnClicked = index + 1;
            this.btnStatus = 'loading';
            this.btnName = name;

            let data = new FormData();
            data.append( 'action', 'ctf_deactivate_addon' );
            data.append( 'nonce', this.nonce );
            data.append( 'plugin', plugin );
            data.append( 'type', 'plugin' );
            if ( this.extentions_bundle && type == 'extension' ) {
                data.append( 'extensions_bundle', this.extentions_bundle );
            }
            fetch(this.ajax_handler, {
                method: "POST",
                credentials: 'same-origin',
                body: data
            })
            .then(response => response.json())
            .then(data => {
                if( data.success == true ) {
                    if ( name === 'social_wall' ) {
                        this.social_wall.activated = false;
                    } else if ( type === 'recommended_plugin' ) {
                        this.recommendedPlugins[name].activated = false;
                    } else {
                        this.plugins[name].activated = false;
                    }
                    this.btnClicked = null;
                    this.btnName = null;
                    this.btnStatus = null;
                }
                return;
            });
        },
        installPlugin: function( plugin, name, index, type ) {
            this.btnClicked = index + 1;
            this.btnStatus = 'loading';
            this.btnName = name;

            let data = new FormData();
            data.append( 'action', 'ctf_install_addon' );
            data.append( 'nonce', this.nonce );
            data.append( 'plugin', plugin );
            data.append( 'type', 'plugin' );
            fetch(this.ajax_handler, {
                method: "POST",
                credentials: 'same-origin',
                body: data
            })
            .then(response => response.json())
            .then(data => {
                if( data.success == true ) {
                    if ( type === 'recommended_plugin' ) {
                        this.recommendedPlugins[name].installed = true;
                        this.recommendedPlugins[name].activated = true;
                    } else {
                        this.plugins[name].installed = true;
                        this.plugins[name].activated = true;
                    }
                    this.btnClicked = null;
                    this.btnName = null;
                    this.btnStatus = null;
                }
                return;
            });
        },
        buttonIcon: function() {
            if ( this.btnStatus == 'loading' ) {
                return this.icons.loaderSVG
            }
        },

        /**
         * Toggle Sticky Widget view
         *
         * @since 2.0
         */
         toggleStickyWidget: function() {
            this.stickyWidget = !this.stickyWidget;
        },
    }
})