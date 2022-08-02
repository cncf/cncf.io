var ctfoembeds_data = {
    nonce: ctf_oembeds.nonce,
    genericText: ctf_oembeds.genericText,
    images: ctf_oembeds.images,
    modal: ctf_oembeds.modal,
    links: ctf_oembeds.links,
    supportPageUrl: ctf_oembeds.supportPageUrl,
    socialWallActivated: ctf_oembeds.socialWallActivated,
    socialWallLinks: ctf_oembeds.socialWallLinks,
    stickyWidget: false,
    facebook: ctf_oembeds.facebook,
    instagram: ctf_oembeds.instagram,
    connectionURL: ctf_oembeds.connectionURL,
    isFacebookActivated: ctf_oembeds.facebook.active,
    facebookInstallBtnText: null,
    fboEmbedLoader: false,
    instaoEmbedLoader: false,
    openFacebookInstaller: false,
    loaderSVG: ctf_oembeds.loaderSVG,
    checkmarkSVG: ctf_oembeds.checkmarkSVG,
    installerStatus: null
}

var ctfoEmbeds = new Vue({
    el: "#ctf-oembeds",
    http: {
        emulateJSON: true,
        emulateHTTP: true
    },
    data: ctfoembeds_data,
    methods: {
        openFacebookllModal: function() {
            this.openFacebookInstaller = true
        },
        closeModal: function() {
            this.openFacebookInstaller = false
        },
        isoEmbedsEnabled: function() {
            if ( this.facebook.doingOembeds && this.instagram.doingOembeds ) {
                return true;
            }
            return;
        },
        FacebookShouldInstallOrEnable: function() {
            // if the plugin is activated and installed then just enable oEmbed
            if( this.isFacebookActivated ) {
                this.enableFacebookOembed();
                return;
            }
            // if the plugin is not activated and installed then open the modal to install and activate the plugin
            if( !this.isFacebookActivated ) {
                this.openFacebookllModal();
                return;
            }
        },
        installFacebook: function() {
            this.installerStatus = 'loading';
            let data = new FormData();
            data.append( 'action', ctf_oembeds.facebook.installer.action );
            data.append( 'nonce', ctf_oembeds.nonce );
            data.append( 'plugin', ctf_oembeds.facebook.installer.plugin );
            data.append( 'type', 'plugin' );
            fetch(ctf_oembeds.ajax_handler, {
                method: "POST",
                credentials: 'same-origin',
                body: data
            })
                .then(response => response.json())
                .then(data => {
                    if( data.success == false ) {
                        this.installerStatus = 'error'
                    }
                    if( data.success == true ) {
                        this.isFacebookActivated = true;
                        this.installerStatus = 'success'
                    }
                    this.facebookInstallBtnText = data.data.msg;
                    setTimeout(function() {
                        this.installerStatus = null;
                    }.bind(this), 3000);
                    return;
                });
        },
        enableFboEmbed: function() {
            this.fboEmbedLoader = true;
            window.location = this.connectionURL;
            return;
        },
        enableFacebookOembed: function() {
            this.facebookoEmbedLoader = true;
            window.location = this.connectionURL;
            return;
        },
        disableFboEmbed: function() {
            this.fboEmbedLoader = true;
            let data = new FormData();
            data.append( 'action', 'disable_facebook_oembed_from_instagram' );
            data.append( 'nonce', this.nonce );
            fetch(ctf_oembeds.ajax_handler, {
                method: "POST",
                credentials: 'same-origin',
                body: data
            })
                .then(response => response.json())
                .then(data => {
                    if( data.success == true ) {
                        this.fboEmbedLoader = false;
                        this.facebook.doingOembeds = false;
                        // get the updated connection URL after disabling oEmbed
                        this.connectionURL = data.data.connectionUrl;
                    }
                    return;
                });
        },
        disableInstaoEmbed: function() {
            this.instaoEmbedLoader = true;
            let data = new FormData();
            data.append( 'action', 'disable_instagram_oembed_from_instagram' );
            data.append( 'nonce', this.nonce );
            fetch(ctf_oembeds.ajax_handler, {
                method: "POST",
                credentials: 'same-origin',
                body: data
            })
                .then(response => response.json())
                .then(data => {
                    if( data.success == true ) {
                        this.instaoEmbedLoader = false;
                        this.instagram.doingOembeds = false;
                        // get the updated connection URL after disabling oEmbed
                        this.connectionURL = data.data.connectionUrl;
                    }
                    return;
                });
        },
        installButtonText: function( buttonText = null ) {
            if ( buttonText ) {
                return buttonText;
            } else if ( this.facebook.installer.nextStep == 'free_install' ) {
                return this.modal.install;
            } else if ( this.facebook.installer.nextStep == 'free_activate' ) {
                return this.modal.activate;
            }
        },
        installIcon: function() {
            if ( this.isFacebookActivated ) {
                return;
            }
            if( this.installerStatus == null ) {
                return this.modal.plusIcon;
            } else if( this.installerStatus == 'loading' ) {
                return this.loaderSVG;
            } else if( this.installerStatus == 'success' ) {
                return this.checkmarkSVG;
            } else if( this.installerStatus == 'error' ) {
                return `<i class="fa fa-times-circle"></i>`;
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
    },
    created() {
        // Display the "Install" button text on modal depending on condition
        if ( this.facebook.installer.nextStep == 'free_install' ) {
            this.facebookInstallBtnText = this.modal.install;
        } else if ( this.facebook.installer.nextStep == 'free_activate' || this.facebook.installer.nextStep == 'pro_activate' ) {
            this.facebookInstallBtnText = this.modal.activate;
        }
    }
})