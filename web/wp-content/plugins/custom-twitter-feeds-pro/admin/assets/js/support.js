var support_data = {
    genericText: ctf_support.genericText,
    articles: ctf_support.articles,
    links: ctf_support.links,
    system_info: ctf_support.system_info,
    system_info_n: ctf_support.system_info_n,
    exportFeed: 'none',
    stickyWidget: false,
    feeds: ctf_support.feeds,
    supportUrl: ctf_support.supportUrl,
    socialWallActivated: ctf_support.socialWallActivated,
    socialWallLinks: ctf_support.socialWallLinks,
    siteSearchUrl: ctf_support.siteSearchUrl,
    siteSearchUrlWithArgs: null,
    searchKeywords: null,
    recheckLicenseStatus: null,
    buttons: ctf_support.buttons,
    links: ctf_support.links,
    supportPageUrl: ctf_support.supportPageUrl,
    systemInfoBtnStatus: 'collapsed',
    copyBtnStatus: null,
    ajax_handler: ctf_support.ajax_handler,
    nonce: ctf_support.nonce,
    icons: ctf_support.icons,
    images: ctf_support.images,
    svgIcons : ctf_support.svgIcons,
    licenseKey: ctf_support.licenseKey,
    viewsActive : {
        whyRenewLicense : false,
        licenseLearnMore : false,
    },
    ctfLicenseNoticeActive: (ctf_support.ctfLicenseNoticeActive === '1'),
    ctfLicenseInactiveState: (ctf_support.ctfLicenseInactiveState === '1'),
    licenseBtnClicked : false,
    notificationElement : {
        type : 'success', // success, error, warning, message
        text : '',
        shown : null
    },
}

var ctfsupport = new Vue({
    el: "#ctf-support",
    http: {
        emulateJSON: true,
        emulateHTTP: true
    },
    data: support_data,
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

        copySystemInfo: function() {
            let self = this;
            const el = document.createElement('textarea');
			el.className = 'ctf-fb-cp-clpboard';
			el.value = self.system_info_n;
			document.body.appendChild(el);
			el.select();
			document.execCommand('copy');
			document.body.removeChild(el);
            this.notificationElement =  {
                type : 'success',
                text : this.genericText.copiedToClipboard,
                shown : "shown"
            };

            setTimeout(function() {
                this.notificationElement.shown =  "hidden";
            }.bind(self), 3000);
        },
        expandSystemInfo: function() {
            this.systemInfoBtnStatus = ( this.systemInfoBtnStatus == 'collapsed' ) ? 'expanded' : 'collapsed';
        },
        expandBtnText: function() {
            if ( this.systemInfoBtnStatus == 'collapsed' ) {
                return this.buttons.expand;
            } else if ( this.systemInfoBtnStatus == 'expanded' ) {
                return this.buttons.collapse;
            }
        },
        exportFeedSettings: function() {
            // return if no feed is selected
            if ( this.exportFeed === 'none' ) {
                return;
            }

            let url = this.ajax_handler + '?action=ctf_export_settings_json&feed_id=' + this.exportFeed;
            window.location = url;
        },
        searchDoc: function() {
            let self = this;
            let searchInput = document.getElementById('ctf-search-doc-input');
            searchInput.addEventListener('keyup', function ( event ) {
                let url = new URL( self.siteSearchUrl );
                let search_params = url.searchParams;
                if ( self.searchKeywords ) {
                    search_params.set('search', self.searchKeywords);
                }
                search_params.set('plugin', 'instagram');
                url.search = search_params.toString();
                self.siteSearchUrlWithArgs = url.toString();

                if ( event.key === 'Enter' ) {
                    window.open( self.siteSearchUrlWithArgs, '_blank');
                }
            })
        },
        searchDocStrings: function() {
            let self = this;
            let url = new URL( this.siteSearchUrl );
            let search_params = url.searchParams;
            setTimeout(function() {
                search_params.set('search', self.searchKeywords);
                search_params.set('plugin', 'instagram');
                url.search = search_params.toString();
                self.siteSearchUrlWithArgs = url.toString();
            }, 10);
        },
        goToSearchDocumentation: function() {
            if ( this.searchKeywords !== null && this.siteSearchUrlWithArgs !== null ) {
                window.open( this.siteSearchUrlWithArgs, '_blank');
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
    },
})