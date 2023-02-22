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
    recheckLicenseStatus: null,
    licenseKey: ctf_about.licenseKey,
    svgIcons: ctf_about.svgIcons,
    viewsActive : {
        whyRenewLicense : false,
        licenseLearnMore : false,
    },
    ctfLicenseNoticeActive: (ctf_about.ctfLicenseNoticeActive === '1'),
    ctfLicenseInactiveState: (ctf_about.ctfLicenseInactiveState === '1'),
    licenseBtnClicked : false,
    notificationElement : {
        type : 'success', // success, error, warning, message
        text : '',
        shown : null
    },
}

var ctfAbout = new Vue({
    el: "#ctf-about",
    http: {
        emulateJSON: true,
        emulateHTTP: true
    },
    data: extensions_data,
    methods: {

        /**
         * Activate View
         *
         * @since 2.1.0
        */
        activateView : function(viewName){
            var self = this;
            self.viewsActive[viewName] = (self.viewsActive[viewName] == false ) ? true : false;
        },

        /**
         * Activate License
         *
         * @since 2.1.0
        */
        activateLicense: function() {
            this.licenseBtnClicked = true;

            if ( !this.licenseKey ) {
                this.licenseBtnClicked = false;
                this.processNotification("licenseKeyEmpty");
                return;
            }

            let data = new FormData();
            data.append( 'action', 'ctf_activate_license' );
            data.append( 'license_key', this.licenseKey );
            data.append( 'nonce', this.nonce );
            fetch(this.ajax_handler, {
                method: "POST",
                credentials: 'same-origin',
                body: data
            })
            .then(response => response.json())
            .then(data => {
                this.licenseBtnClicked = false;
                if ( data.success == false ) {
					this.processNotification("licenseError");
                    return;
                }
                if ( data.success == true ) {
					this.processNotification("licenseActivated");
                }
                return;
            });
        },

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
        recheckLicense: function( optionName = null ) {
            this.recheckLicenseStatus = 'loading';
			let licenseNoticeWrapper = document.querySelector('.sb-license-notice');

            let data = new FormData();
            data.append( 'action', 'ctf_recheck_connection' );
            data.append( 'license_key', this.licenseKey );
            data.append( 'nonce', this.nonce );
            fetch(this.ajax_handler, {
                method: "POST",
                credentials: 'same-origin',
                body: data
            })
            .then(response => response.json())
            .then(data => {
                if ( data.success == true ) {
                    if ( data.data.license == 'valid' ) {
                        this.recheckLicenseStatus = 'success';
                    }
                    if ( data.data.license != 'valid' ) {
                        this.recheckLicenseStatus = 'error';
                    }

                    setTimeout(function() {
                        self.recheckLicenseStatus = null;
                        if ( data.data.license == 'valid' ) {
                            licenseNoticeWrapper.remove();
                        }
                    }.bind(this), 3000);
                }
                return;
            });
        },
        recheckBtnText: function( btnName ) {
            if ( this.recheckLicenseStatus == null ) {
                return this.genericText.recheckLicense;
            } else if ( this.recheckLicenseStatus == 'loading' ) {
                return this.svgIcons.loaderSVG;
            } else if ( this.recheckLicenseStatus == 'success' ) {
                return this.svgIcons.checkmark + ' ' + this.genericText.licenseValid;
            } else if ( this.recheckLicenseStatus == 'error' ) {
                return this.svgIcons.times2SVG + ' ' + this.genericText.licenseExpired;
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

		/**
		 * Loading Bar & Notification
		 *
		 * @since 2.1.0
		 */
         processNotification : function( notificationType ){
			var self = this,
				notification = self.genericText.notification[ notificationType ];
			self.loadingBar = false;
			self.notificationElement =  {
				type : notification.type,
				text : notification.text,
				shown : "shown"
			};
			setTimeout(function(){
				self.notificationElement.shown =  "hidden";
			}, 5000);
		},
    }
})