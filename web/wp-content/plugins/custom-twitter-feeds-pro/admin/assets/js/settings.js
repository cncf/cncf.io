var ctfSettings;

// Declaring as global variable for quick prototyping
var settings_data = {
    adminUrl: ctf_settings.admin_url,
    nonce: ctf_settings.nonce,
    ajaxHandler: ctf_settings.ajax_handler,
    model: ctf_settings.model,
    feeds: ctf_settings.feeds,
    links: ctf_settings.links,
    tooltipName: null,
    sourcesList : ctf_settings.sources,
    dialogBoxPopupScreen   : ctf_settings.dialogBoxPopupScreen,
    selectSourceScreen      : ctf_settings.selectSourceScreen,

    socialWallActivated: ctf_settings.socialWallActivated,
    socialWallLinks: ctf_settings.socialWallLinks,
    stickyWidget: false,
    exportFeed: 'none',
    locales: ctf_settings.locales,
    timezones: ctf_settings.timezones,
    genericText: ctf_settings.genericText,
    generalTab: ctf_settings.generalTab,
    feedsTab: ctf_settings.feedsTab,
    translationTab: ctf_settings.translationTab,
    advancedTab: ctf_settings.advancedTab,
    upgradeUrl: ctf_settings.upgradeUrl,
    supportPageUrl: ctf_settings.supportPageUrl,
    licenseKey: ctf_settings.licenseKey,
    pluginItemName: ctf_settings.pluginItemName,
    licenseType: 'pro',
    licenseStatus: ctf_settings.licenseStatus,
    licenseErrorMsg: ctf_settings.licenseErrorMsg,
    extensionsLicense: ctf_settings.extensionsLicense,
    extensionsLicenseKey: ctf_settings.extensionsLicenseKey,
    extensionFieldHasError: false,
    cronNextCheck: ctf_settings.nextCheck,
    currentView: null,
    selected: null,
    current: 0,
    sections: ["General", "Feeds", "Translation", "Advanced"],
    indicator_width: 0,
    indicator_pos: 0,
    forwards: true,
    currentTab: null,
    import_file: null,
    gdprInfoTooltip: null,
    loaderSVG: ctf_settings.loaderSVG,
    checkmarkSVG: ctf_settings.checkmarkSVG,
    uploadSVG: ctf_settings.uploadSVG,
    exportSVG: ctf_settings.exportSVG,
    reloadSVG: ctf_settings.reloadSVG,
    tooltipHelpSvg: ctf_settings.tooltipHelpSvg,
    tooltip : {
        text : '',
        hover : false
    },

    cogSVG: ctf_settings.cogSVG,
    deleteSVG: ctf_settings.deleteSVG,
    svgIcons : ctf_settings.svgIcons,
    accountDetails  : ctf_settings.accountDetails,
    newAccountData : ctf_settings.newAccountData,


    appCredentials : ctf_settings.appCredentials,
    connectAccountScreen : ctf_settings.connectAccountScreen,
    appOAUTH : ctf_settings.appOAUTH,
    testConnectionStatus: null,
    recheckLicenseStatus: null,
    btnStatus: null,
    uploadStatus: null,
    clearCacheStatus: null,
    optimizeCacheStatus: null,
    persistentCacheStatus: null,
    twittercardCacheStatus: null,

    dpaResetStatus: null,
    pressedBtnName: null,
    loading: false,
    hasError: ctf_settings.hasError,
    manualAccountResp : false,

    dialogBox : {
        active : false,
        type : null,
        heading : null,
        description : null,
        customButtons : undefined
    },
    sourceToDelete : {},
    viewsActive : {
        sourcePopup : false,
        sourcePopupScreen : 'redirect_1',
        sourcePopupType : 'creation',
        instanceSourceActive : null,
        connectAccountPopup : false,
        connectAccountStep : 'step_1',
        accountDetailsActive : false,
        appDetailsActive : false,
    },
    //Add New Source
    newSourceData        : ctf_settings.newSourceData ? ctf_settings.newSourceData : null,
    sourceConnectionURLs : ctf_settings.sourceConnectionURLs,
    returnedApiSourcesList : [],
    addNewSource : {
        typeSelected        : 'page',
        manualSourceID      : null,
        manualSourceToken   : null
    },
    selectedFeed : 'none',
    expandedFeedID : null,
    notificationElement : {
        type : 'success', // success, error, warning, message
        text : '',
        shown : null
    },
    selectedSourcesToConnect : [],

    //Loading Bar
    fullScreenLoader : false,
    appLoaded : false,
    previewLoaded : false,
    loadingBar : true,
    loadingAjax : false,

    notificationElement : {
        type : 'success', // success, error, warning, message
        text : '',
        shown : null
    }
};

// The tab component
Vue.component("tab", {
    props: ["section", "index"],
    template: `
        <a class='tab' :id='section.toLowerCase().trim()' @click='emitWidth($el);changeComponent(index);activeTab(section)'>{{section}}</a>
    `,
    created: () => {
        let urlParams = new URLSearchParams(window.location.search);
        let view = urlParams.get('view');
        if ( view === null ) {
            view = 'general';
        }
        settings_data.currentView = view;
        settings_data.currentTab = settings_data.sections[0];
        settings_data.selected = "app-1";
    },
    methods: {
        emitWidth: function(el) {
            settings_data.indicator_width = jQuery(el).outerWidth();
            settings_data.indicator_pos = jQuery(el).position().left;
        },
        changeComponent: function(index) {
            var prev = settings_data.current;
            if (prev < index) {
                settings_data.forwards = false;
            } else if (prev > index) {
                settings_data.forwards = true;
            }
            settings_data.selected = "app-" + (index + 1);
            settings_data.current = index;
        },
        activeTab: function(section) {
            this.setView(section.toLowerCase().trim());
            settings_data.currentTab = section;
        },
        setView: function(section) {
            history.replaceState({}, null, settings_data.adminUrl + 'admin.php?page=ctf-settings&view=' + section);
        }
    }
});

var ctfSettings = new Vue({
    el: "#ctf-settings",
    http: {
        emulateJSON: true,
        emulateHTTP: true
    },
    data: settings_data,
    created: function() {
        this.$nextTick(function() {
            let tabEl = document.querySelector('.tab');
            settings_data.indicator_width = tabEl.offsetWidth;
        });
        setTimeout(function(){
            settings_data.appLoaded = true;
        },350);
    },
    mounted: function(){
        var self = this;
        // set the current view page on page load
        let activeEl = document.querySelector('a.tab#' + settings_data.currentView);
        // we have to uppercase the first letter
        let currentView = settings_data.currentView.charAt(0).toUpperCase() + settings_data.currentView.slice(1);
        let viewIndex = settings_data.sections.indexOf(currentView) + 1;
        settings_data.indicator_width = activeEl.offsetWidth;
        settings_data.indicator_pos = activeEl.offsetLeft;
        settings_data.selected = "app-" + viewIndex;
        settings_data.current = viewIndex;
        settings_data.currentTab = currentView;

        setTimeout(function(){
            settings_data.appLoaded = true;
        },350);

    },
    computed: {
        getStyle: function() {
            return {
                position: "absolute",
                bottom: "0px",
                left: settings_data.indicator_pos + "px",
                width: settings_data.indicator_width + "px",
                height: "2px"
            };
        },
        chooseDirection: function() {
            if (settings_data.forwards == true) {
                return "slide-fade";
            } else {
                return "slide-fade";
            }
        }
    },
    methods:  {
        activateLicense: function() {
            this.hasError = false;
            this.loading = true;
            this.pressedBtnName = 'ctf';

            let data = new FormData();
            data.append( 'action', 'ctf_activate_license' );
            data.append( 'license_key', this.licenseKey );
            data.append( 'nonce', this.nonce );
            fetch(this.ajaxHandler, {
                method: "POST",
                credentials: 'same-origin',
                body: data
            })
            .then(response => response.json())
            .then(data => {
                if ( data.success == false ) {
                    this.licenseStatus = 'inactive';
                    this.hasError = true;
                    this.loading = false;
                    return;
                }
                if ( data.success == true ) {
                    let licenseData = data.data.licenseData;
                    this.licenseStatus = data.data.licenseStatus;
                    this.loading = false;
                    this.pressedBtnName = null;

                    if (
                        data.data.licenseStatus == 'inactive' ||
                        data.data.licenseStatus == 'invalid' ||
                        data.data.licenseStatus == 'expired'
                    ) {
                        this.hasError = true;
                        if( licenseData.error ) {
                            this.licenseErrorMsg = licenseData.errorMsg
                        }
                    }
                }
                return;
            });
        },
        deactivateLicense: function() {
            this.loading = true;
            this.pressedBtnName = 'ctf';
            let data = new FormData();
            data.append( 'action', 'ctf_deactivate_license' );
            data.append( 'nonce', this.nonce );
            fetch(this.ajaxHandler, {
                method: "POST",
                credentials: 'same-origin',
                body: data
            })
            .then(response => response.json())
            .then(data => {
                if ( data.success == true ) {
                    this.licenseStatus = data.data.licenseStatus ;
                    this.loading = false;
                    this.pressedBtnName = null;
                }
                return;
            });
        },

        /**
         * Activate Extensions License
         *
         * @since 2.0
         *
         * @param {object} extension
         */
        activateExtensionLicense: function( extension ) {
            let licenseKey = this.extensionsLicenseKey[extension.name];
            this.extensionFieldHasError = false;
            this.loading = true;
            this.pressedBtnName = extension.name;
            if ( ! licenseKey ) {
                this.loading = false;
                this.extensionFieldHasError = true;
                return;
            }
            let data = new FormData();
            data.append( 'action', 'ctf_activate_extension_license' );
            data.append( 'license_key', licenseKey );
            data.append( 'extension_name', extension.name );
            data.append( 'extension_item_name', extension.itemName );
            data.append( 'nonce', this.nonce );
            fetch(this.ajaxHandler, {
                method: "POST",
                credentials: 'same-origin',
                body: data
            })
            .then(response => response.json())
            .then(data => {
                this.loading = false;
                if ( data.success == true ) {
                    this.extensionFieldHasError = false;
                    this.pressedBtnName = null;
                    if ( data.data.licenseStatus == 'invalid' ) {
                        this.extensionFieldHasError = true;
                        this.notificationElement =  {
                            type : 'error',
                            text : this.genericText.invalidLicenseKey,
                            shown : "shown"
                        };
                    }
                    if ( data.data.licenseStatus == 'valid' ) {
                        this.notificationElement =  {
                            type : 'success',
                            text : this.genericText.licenseActivated,
                            shown : "shown"
                        };
                    }
                    extension.licenseStatus = data.data.licenseStatus;
                    extension.licenseKey = licenseKey;

                    setTimeout(function(){
                        this.notificationElement.shown =  "hidden";
                    }.bind(this), 3000);
                }
                return;
            });
        },

        /**
         * Deactivate Extensions License
         *
         * @since 2.0
         *
         * @param {object} extension
         */
        deactivateExtensionLicense: function( extension ) {
            let licenseKey = this.extensionsLicenseKey[extension.name];
            this.extensionFieldHasError = false;
            this.loading = true;
            this.pressedBtnName = extension.name;
            let data = new FormData();
            data.append( 'action', 'ctf_deactivate_extension_license' );
            data.append( 'extension_name', extension.name );
            data.append( 'extension_item_name', extension.itemName );
            data.append( 'nonce', this.nonce );
            fetch(this.ajaxHandler, {
                method: "POST",
                credentials: 'same-origin',
                body: data
            })
            .then(response => response.json())
            .then(data => {
                this.loading = false;
                if ( data.success == true ) {
                    this.extensionFieldHasError = false;
                    this.pressedBtnName = null;
                    if ( data.data.licenseStatus == 'deactivated' ) {
                        this.notificationElement =  {
                            type : 'success',
                            text : this.genericText.licenseDeactivated,
                            shown : "shown"
                        };
                    }
                    extension.licenseStatus = data.data.licenseStatus;
                    extension.licenseKey = licenseKey;

                    setTimeout(function(){
                        this.notificationElement.shown =  "hidden";
                    }.bind(this), 3000);
                }
                return;
            });
        },
        testConnection: function() {
            this.testConnectionStatus = 'loading';
            let data = new FormData();
            data.append( 'action', 'ctf_test_connection' );
            data.append( 'nonce', this.nonce );
            fetch(this.ajaxHandler, {
                method: "POST",
                credentials: 'same-origin',
                body: data
            })
            .then(response => response.json())
            .then(data => {
                if ( data.success == false ) {
                    this.testConnectionStatus = 'error';
                }
                if ( data.success == true ) {
                    this.testConnectionStatus = 'success';

                    setTimeout(function() {
                        this.testConnectionStatus = null;
                    }.bind(this), 3000);
                }
                return;
            });
        },
        recheckLicense: function( licenseKey, itemName, optionName = null ) {
            this.recheckLicenseStatus = 'loading';
            this.pressedBtnName = optionName;
            let data = new FormData();
            data.append( 'action', 'ctf_recheck_connection' );
            data.append( 'license_key', licenseKey );
            data.append( 'item_name', itemName );
            data.append( 'option_name', optionName );
            data.append( 'nonce', this.nonce );
            fetch(this.ajaxHandler, {
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
                    if ( data.data.license == 'expired' ) {
                        this.recheckLicenseStatus = 'error';
                    }

                    // if the api license status has changed from old stored license status
                    // then reload the page to show proper error message and notices
                    // or hide error messages and notices
                    if ( data.data.licenseChanged == true ) {
                        location.reload();
                    }

                    setTimeout(function() {
                        this.pressedBtnName = null;
                        this.recheckLicenseStatus = null;
                    }.bind(this), 3000);
                }
                return;
            });
        },
        recheckLicenseIcon: function() {
            if ( this.recheckLicenseStatus == null ) {
                return this.generalTab.licenseBox.recheckLicense;
            } else if ( this.recheckLicenseStatus == 'loading' ) {
                return this.loaderSVG;
            } else if ( this.recheckLicenseStatus == 'success' ) {
                return '<i class="fa fa-check-circle"></i> ' + this.generalTab.licenseBox.licenseValid;
            } else if ( this.recheckLicenseStatus == 'error' ) {
                return '<i class="fa fa-times-circle"></i> ' + this.generalTab.licenseBox.licenseExpired;
            }
        },
        recheckBtnText: function( btnName ) {
            if ( this.recheckLicenseStatus == null || this.pressedBtnName != btnName ) {
                return this.generalTab.licenseBox.recheckLicense;
            } else if ( this.recheckLicenseStatus == 'loading' && this.pressedBtnName == btnName  ) {
                return this.loaderSVG;
            } else if ( this.recheckLicenseStatus == 'success' ) {
                return '<i class="fa fa-check-circle"></i> ' + this.generalTab.licenseBox.licenseValid;
            } else if ( this.recheckLicenseStatus == 'error' ) {
                return '<i class="fa fa-times-circle"></i> ' + this.generalTab.licenseBox.licenseExpired;
            }
        },
        testConnectionIcon: function() {
            if ( this.testConnectionStatus == 'loading' ) {
                return this.loaderSVG;
            } else if ( this.testConnectionStatus == 'success' ) {
                return '<i class="fa fa-check-circle"></i> ' + this.generalTab.licenseBox.connectionSuccessful;
            } else if ( this.testConnectionStatus == 'error' ) {
                return `<i class="fa fa-times-circle"></i> ${this.generalTab.licenseBox.connectionFailed} <a href="#">${this.generalTab.licenseBox.viewError}</a>`;
            }
        },
        importFile: function() {
            document.getElementById("import_file").click();
        },
        uploadFile: function( event ) {
            this.uploadStatus = 'loading';
            let file = this.$refs.file.files[0];
            let data = new FormData();
            data.append( 'action', 'ctf_import_settings_json' );
            data.append( 'file', file );
            data.append( 'nonce', this.nonce );
            fetch(this.ajaxHandler, {
                method: "POST",
                credentials: 'same-origin',
                body: data
            })
            .then(response => response.json())
            .then(data => {
                this.uploadStatus = null;
                this.$refs.file.files[0] = null;
                if ( data.success == false ) {
                    this.notificationElement =  {
                        type : 'error',
                        text : this.genericText.failedToImportFeed,
                        shown : "shown"
                    };
                }
                if ( data.success == true ) {
                    this.feeds = data.data.feeds;
                    this.notificationElement =  {
                        type : 'success',
                        text : this.genericText.feedImported,
                        shown : "shown"
                    };
                }
                setTimeout(function(){
                    this.notificationElement.shown =  "hidden";
                }.bind(this), 3000);
            });
        },
        exportFeedSettings: function() {
            // return if no feed is selected
            if ( this.exportFeed === 'none' ) {
                return;
            }

            let url = this.ajaxHandler + '?action=ctf_export_settings_json&feed_id=' + this.exportFeed;
            window.location = url;
        },
        saveSettings: function() {
            this.btnStatus = 'loading';
            this.pressedBtnName = 'saveChanges';
            let data = new FormData();
            data.append( 'action', 'ctf_save_settings' );
            data.append( 'model', JSON.stringify( this.model ) );
            data.append( 'ctf_license_key', this.licenseKey );
            data.append( 'extensions_license_key', JSON.stringify( this.extensionsLicenseKey ) );
            data.append( 'nonce', this.nonce );
            fetch(this.ajaxHandler, {
                method: "POST",
                credentials: 'same-origin',
                body: data
            })
            .then(response => response.json())
            .then(data => {
                if ( data.success == false ) {
                    this.btnStatus = 'error';
                    return;
                }

                this.cronNextCheck = data.data.cronNextCheck;
                this.btnStatus = 'success';
                setTimeout(function() {
                    this.btnStatus = null;
                    this.pressedBtnName = null;
                }.bind(this), 3000);
            });
        },
        clearCache: function() {
            this.clearCacheStatus = 'loading';
            let data = new FormData();
            data.append( 'action', 'ctf_clear_cache_settings' );
            data.append( 'model', JSON.stringify( this.model ) );
            data.append( 'nonce', this.nonce );
            fetch(this.ajaxHandler, {
                method: "POST",
                credentials: 'same-origin',
                body: data
            })
            .then(response => response.json())
            .then(data => {
                if ( data.success == false ) {
                    this.clearCacheStatus = 'error';
                    return;
                }
                this.cronNextCheck = data.data.cronNextCheck;
                this.clearCacheStatus = 'success';
                setTimeout(function() {
                    this.clearCacheStatus = null;
                }.bind(this), 3000);
            });
        },
        showTooltip: function( tooltipName ) {
            this.tooltipName = tooltipName;
        },
        hideTooltip: function() {
            this.tooltipName = null;
        },
        gdprOptions: function() {
            this.gdprInfoTooltip = null;
        },
        gdprLimited: function() {
            this.gdprInfoTooltip = this.gdprInfoTooltip == null ? true : null;
        },
        clearImageResizeCache: function() {
            this.optimizeCacheStatus = 'loading';
            let data = new FormData();
            data.append( 'action', 'ctf_clear_image_resize_cache' );
            data.append( 'nonce', this.nonce );
            fetch(this.ajaxHandler, {
                method: "POST",
                credentials: 'same-origin',
                body: data
            })
            .then(response => response.json())
            .then(data => {
                if ( data.success == false ) {
                    this.optimizeCacheStatus = 'error';
                    return;
                }
                this.optimizeCacheStatus = 'success';
                setTimeout(function() {
                    this.optimizeCacheStatus = null;
                }.bind(this), 3000);
            });
        },
        clearPersistentCache: function() {
            this.persistentCacheStatus = 'loading';
            let data = new FormData();
            data.append( 'action', 'ctf_clear_persistent_cache' );
            data.append( 'nonce', this.nonce );
            fetch(this.ajaxHandler, {
                method: "POST",
                credentials: 'same-origin',
                body: data
            })
            .then(response => response.json())
            .then(data => {
                if ( data.success == false ) {
                    this.persistentCacheStatus = 'error';
                    return;
                }
                this.persistentCacheStatus = 'success';
                setTimeout(function() {
                    this.persistentCacheStatus = null;
                }.bind(this), 3000);
            });
        },
  clearTwittercardCache: function() {
    this.twittercardCacheStatus = 'loading';
    let data = new FormData();
    data.append( 'action', 'ctf_clear_twittercard_cache' );
    data.append( 'nonce', this.nonce );
    fetch(this.ajaxHandler, {
      method: "POST",
      credentials: 'same-origin',
      body: data
    })
      .then(response => response.json())
      .then(data => {
        if ( data.success == false ) {
          this.twittercardCacheStatus = 'error';
          return;
        }
        this.twittercardCacheStatus = 'success';
        setTimeout(function() {
          this.twittercardCacheStatus = null;
        }.bind(this), 3000);
      });
  },
        dpaReset: function() {
            this.dpaResetStatus = 'loading';
            let data = new FormData();
            data.append( 'action', 'ctf_dpa_reset' );
            data.append( 'nonce', this.nonce );
            fetch(this.ajaxHandler, {
                method: "POST",
                credentials: 'same-origin',
                body: data
            })
                .then(response => response.json())
                .then(data => {
                    if ( data.success == false ) {
                        this.dpaResetStatus = 'error';
                        return;
                    }
                    this.dpaResetStatus = 'success';
                    setTimeout(function() {
                        this.dpaResetStatus = null;
                    }.bind(this), 3000);
                });
        },
        saveChangesIcon: function() {
            if ( this.btnStatus == 'loading' ) {
                return this.loaderSVG;
            } else if ( this.btnStatus == 'success' ) {
                return this.checkmarkSVG;
            } else if ( this.btnStatus == 'error' ) {
                return `<i class="fa fa-times-circle"></i>`;
            }
        },
        importBtnIcon: function() {
            if ( this.uploadStatus === null ) {
                return this.uploadSVG;
            }
            if ( this.uploadStatus == 'loading' ) {
                return this.loaderSVG;
            } else if ( this.uploadStatus == 'success' ) {
                return this.checkmarkSVG;
            } else if ( this.uploadStatus == 'error' ) {
                return `<i class="fa fa-times-circle"></i>`;
            }
        },
        clearCacheIcon: function() {
            if ( this.clearCacheStatus === null ) {
                return this.reloadSVG;
            }
            if ( this.clearCacheStatus == 'loading' ) {
                return this.loaderSVG;
            } else if ( this.clearCacheStatus == 'success' ) {
                return this.checkmarkSVG;
            } else if ( this.clearCacheStatus == 'error' ) {
                return `<i class="fa fa-times-circle"></i>`;
            }
        },
        clearImageResizeCacheIcon: function() {
            if ( this.optimizeCacheStatus === null ) {
                return;
            }
            if ( this.optimizeCacheStatus == 'loading' ) {
                return this.loaderSVG;
            } else if ( this.optimizeCacheStatus == 'success' ) {
                return this.checkmarkSVG;
            } else if ( this.optimizeCacheStatus == 'error' ) {
                return `<i class="fa fa-times-circle"></i>`;
            }
        },
        clearPersistentCacheIcon: function() {
            if ( this.persistentCacheStatus === null ) {
                return;
            }
            if ( this.persistentCacheStatus == 'loading' ) {
                return this.loaderSVG;
            } else if ( this.persistentCacheStatus == 'success' ) {
                return this.checkmarkSVG;
            } else if ( this.persistentCacheStatus == 'error' ) {
                return `<i class="fa fa-times-circle"></i>`;
            }
        },
        clearTwittercardCacheIcon: function() {
          if ( this.twittercardCacheStatus === null ) {
            return;
          }
          if ( this.twittercardCacheStatus == 'loading' ) {
            return this.loaderSVG;
          } else if ( this.twittercardCacheStatus == 'success' ) {
            return this.checkmarkSVG;
          } else if ( this.twittercardCacheStatus == 'error' ) {
            return `<i class="fa fa-times-circle"></i>`;
          }
        },

        dpaResetStatusIcon: function() {
            if ( this.dpaResetStatus === null ) {
                return;
            }
            if ( this.dpaResetStatus == 'loading' ) {
                return this.loaderSVG;
            } else if ( this.dpaResetStatus == 'success' ) {
                return this.checkmarkSVG;
            } else if ( this.dpaResetStatus == 'error' ) {
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

        printUsedInText: function( usedInNumber ){
            if(usedInNumber == 0){
                return this.genericText.sourceNotUsedYet;
            }
            return this.genericText.usedIn + ' ' + usedInNumber + ' ' +(usedInNumber == 1 ? this.genericText.feed : this.genericText.feeds);
        },

        /**
         * Delete Source Ajax
         *
         * @since 2.0
        */
        deleteSource : function(sourceToDelete){
            var self = this;
             let data = new FormData();
            data.append( 'action', 'ctf_feed_saver_manager_delete_source' );
            data.append( 'source_id', sourceToDelete.id);
            data.append( 'nonce', this.nonce );
            fetch(self.ajaxHandler, {
                method: "POST",
                credentials: 'same-origin',
                body: data
            })
            .then(response => response.json())
            .then(data => {
                if (sourceToDelete.just_added) {
                    window.location.href = window.location.href.replace('ctf_access_token','ctf_null');
                }
                self.sourcesList = data;
            });
        },

        /**
         * Check if Value is Empty
         *
         * @since 2.0
         *
         * @return boolean
         */
        checkNotEmpty : function(value){
            return value != null && value.replace(/ /gi,'') != '';
        },

        /**
         * Activate View
         *
         * @since 2.0
        */
        activateView : function(viewName, sourcePopupType = 'creation', ajaxAction = false){
            var self = this;
            self.viewsActive[viewName] = (self.viewsActive[viewName] == false ) ? true : false;
            if(viewName == 'sourcePopup' && sourcePopupType == 'creationRedirect'){
                setTimeout(function(){
                    self.$refs.addSourceRef.processIFConnect()
                },3500);
            }

        },

        /**
         * Switch & Change Feed Screens
         *
         * @since 2.0
         */
        switchScreen: function(screenType, screenName){
            this.viewsActive[screenType] = screenName;
        },

        /**
         * Parse JSON
         *
         * @since 2.0
         *
         * @return jsonObject / Boolean
         */
        jsonParse : function(jsonString){
            try {
                return JSON.parse(jsonString);
            } catch(e) {
                return false;
            }
        },


        /**
         * Ajax Post Action
         *
         * @since 2.0
         */
        ajaxPost : function(data, callback){
            var self = this;
            self.$http.post(self.ajaxHandler,data).then(callback);
        },

        /**
         * Check if Object has Nested Property
         *
         * @since 2.0
         *
         * @return boolean
         */
        hasOwnNestedProperty : function(obj,propertyPath) {
          if (!propertyPath){return false;}var properties = propertyPath.split('.');
          for (var i = 0; i < properties.length; i++) {
            var prop = properties[i];
            if (!obj || !obj.hasOwnProperty(prop)) {
              return false;
            } else {
              obj = obj[prop];
            }
          }
          return true;
        },

        /**
         * Show Tooltip on Hover
         *
         * @since 2.0
         */
        toggleElementTooltip : function(tooltipText, type, align = 'center'){
            var self = this,
                target = window.event.currentTarget,
                tooltip = (target != undefined && target != null) ? document.querySelector('.sb-control-elem-tltp-content') : null;
            if(tooltip != null && type == 'show'){
                self.tooltip.text = tooltipText;
                var position = target.getBoundingClientRect(),
                    left = position.left + 10,
                    top = position.top - 10;
                tooltip.style.left = left + 'px';
                tooltip.style.top = top + 'px';
                tooltip.style.textAlign = align;
                self.tooltip.hover = true;
            }
            if(type == 'hide'){
                self.tooltip.hover = false;
            }
        },

        /**
         * Hover Tooltip
         *
         * @since 2.0
         */
        hoverTooltip : function(type){
            this.tooltip.hover = type;
        },

        /**
         * Open Dialog Box
         *
         * @since 2.0
        */
        openDialogBox : function(type, args = []){
            var self = this,
                heading = self.dialogBoxPopupScreen[type].heading,
                description = self.dialogBoxPopupScreen[type].description,
                customButtons = self.dialogBoxPopupScreen[type].customButtons;


            switch (type) {
                case "deleteSource":
                    self.sourceToDelete = args;
                    heading = heading.replace("#", self.sourceToDelete.username);
                break;
            }
            self.dialogBox = {
                active : true,
                type : type,
                heading : heading,
                description : description,
                customButtons : customButtons
            };
        },


        /**
         * Confirm Dialog Box Actions
         *
         * @since 2.0
         */
        confirmDialogAction : function(){
            var self = this;
            switch (self.dialogBox.type) {
                case 'deleteSource':
                    self.deleteSource(self.sourceToDelete);
                    break;
                case 'deleteAccount':
                    self.deleteAccount();
                    break;
                case 'deleteApp':
                    self.deleteAccount(true);
                    break;
            }
        },

        /**
         * Display Feed Sources Settings
         *
         * @since 2.0
         *
         * @param {object} source
         * @param {int} sourceIndex
         */
        displayFeedSettings: function(source, sourceIndex) {
            this.expandedFeedID = sourceIndex + 1;
        },

        /**
         * Hide Feed Sources Settings
         *
         * @since 2.0
         *
         * @param {object} source
         * @param {int} sourceIndex
         */
        hideFeedSettings: function() {
            this.expandedFeedID = null;
        },

		/**
		 * Copy text to clipboard
		 *
		 * @since 2.0
		 */
         copyToClipBoard : function(value){
			var self = this;
			const el = document.createElement('textarea');
			el.className = 'ctf-fb-cp-clpboard';
			el.value = value;
			document.body.appendChild(el);
			el.select();
			document.execCommand('copy');
			document.body.removeChild(el);
			self.notificationElement =  {
				type : 'success',
				text : this.genericText.copiedClipboard,
				shown : "shown"
			};
			setTimeout(function(){
				self.notificationElement.shown =  "hidden";
			}, 3000);
		},


        /**
         * View Source Instances
         *
         * @since 2.0
         */
        viewSourceInstances : function(source){
            var self = this;
            self.viewsActive.instanceSourceActive = source;
        },

        /**
         * Return Page/Group Avatar
         *
         * @since 2.0
         *
         * @return string
         */
        returnAccountAvatar : function(source){
            if (typeof source.local_avatar_url !== "undefined" && source.local_avatar_url !== '') {
                return source.local_avatar_url;
            }
            if (typeof source.avatar_url !== "undefined" && source.avatar_url !== '') {
                return source.avatar_url;
            }

            return false;
        },

        checkManualEmpty : function(){
            var self = this;
            return self.checkNotEmpty(self.appCredentials.access_token) && self.checkNotEmpty(self.appCredentials.access_token_secret);
        },

        closeConnectAccountPopup : function(){
            var self = this;
            self.appCredentials = {
                app_name        : '',
                consumer_key    : '',
                consumer_secret : '',
                access_token    : '',
                access_token_secret : ''
            };
            self.viewsActive.connectAccountPopup = false;
        },

        checkNewAccount : function(){
            var self = this;
            if( self.newAccountData !== undefined ){
                if( self.newAccountData['error'] !== undefined ){
                    self.accountDetails = self.newAccountData;
                }
            }
        },
        checkAccountDetails : function(){
             var self = this;
            return self.accountDetails !== undefined &&
                    self?.accountDetails?.access_token !== undefined &&
                    self?.accountDetails?.access_token_secret !== undefined &&
                     self.checkNotEmpty(self?.accountDetails?.access_token) &&
                    self.checkNotEmpty(self?.accountDetails?.access_token_secret);

        },

        checkAppData : function(){
            var self = this;
            return  self?.accountDetails?.app_name !== undefined &&
                    self?.accountDetails?.consumer_key !== undefined &&
                    self?.accountDetails?.consumer_secret !== undefined &&
                    self.checkNotEmpty(self?.accountDetails?.app_name) &&
                    self.checkNotEmpty(self?.accountDetails?.consumer_key) &&
                    self.checkNotEmpty(self?.accountDetails?.consumer_secret);
        },

        deleteAccount : function(deleteApp = false){
            var self = this;
            self.loadingAjax = true;
            var deleteData = {
                action : 'ctf_feed_saver_manager_delete_account',
                'nonce' : self.nonce,
                deleteApp : deleteApp
            };
            self.ajaxPost(deleteData, function(_ref){
                var data = _ref.data;
                self.accountDetails = data;
                self.loadingAjax = false;
            });
        },

        connectAccountLink : function(){
            window.location = this.appOAUTH;
        },

        /**
         * Connect Twitter Account Manually
         *
         * @since 2.0
         */
        connectManualAccount : function(){
            var self = this;
            if( self.checkManualEmpty() ){
                self.loadingAjax = true;
                var connectManualAccountData = {
                    action : 'ctf_feed_saver_manager_connect_manual_account',
                    'nonce' : self.nonce,
                    app_name : self.appCredentials.app_name,
                    consumer_key : self.appCredentials.consumer_key,
                    consumer_secret : self.appCredentials.consumer_secret,
                    access_token : self.appCredentials.access_token,
                    access_token_secret : self.appCredentials.access_token_secret
                };
                self.ajaxPost(connectManualAccountData, function(_ref){
                    var data = _ref.data;
                    if(data['error'] === undefined){
                        self.accountDetails = data;
                        self.manualAccountResp = 'success';
                        setTimeout(function(){
                            self.viewsActive['connectAccountPopup'] = false;
                            self.manualAccountResp = false;
                        }, 1000)
                    }else{
                        self.manualAccountResp = 'error';
                        setTimeout(function(){
                            self.manualAccountResp = false;
                        }, 3000)
                    }
                    self.loadingAjax = false;
                });
            }
        },

    }
});

