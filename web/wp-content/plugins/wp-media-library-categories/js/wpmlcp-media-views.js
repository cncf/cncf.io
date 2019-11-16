window.wp = window.wp || {};
window.wpmlc = window.wpmlc || { l10n: {} };


( function( $, _ ) {

    var media = wp.media,
        l10n = media.view.l10n,
        l10n_defaults = { media_orderby: 'date', media_order: 'DESC' },
        mediaTrash = media.view.settings.mediaTrash,
        original = {};


    _.extend( wpmlc.l10n, wpmlcp_media_views_l10n );
    _.defaults( wpmlc.l10n, l10n_defaults );



    /**
     * wp.media.controller.Library
     *
     */
    original.controllerLibrary = {

        activate: media.controller.Library.prototype.activate
    };

    _.extend( media.controller.Library.prototype.defaults, {
        idealColumnWidth   : $( window ).width() < 640 ? 120 : 135
    });

    _.extend( media.controller.Library.prototype, {

        activate: function() {

            original.controllerLibrary.activate.apply( this, arguments );

            wp.Uploader.queue.on( 'add', this.beforeUpload, this );
            wp.Uploader.queue.on( 'reset', this.afterUpload, this );
        },

        beforeUpload: function() {

            if ( wp.Uploader.queue.length == 1 ) {
                $('.attachment-filters:has(option[value!="all"]:selected)').val( 'all' ).change();
            }
        },

        afterUpload: function() {

            var library = this.get( 'library' ),
                selection = this.get( 'selection' ),
                orderby = library.props.get( 'orderby' );


            if ( 'menuOrder' === orderby ) {
                library.saveMenuOrder();
            }

            library.reset( library.models );

            selection.trigger( 'selection:unsingle', selection.model, selection );
            selection.trigger( 'selection:single', selection.model, selection );
        },

        uploading: function( attachment ) {

            var content = this.frame.content,
                selection = this.get( 'selection' );


            if ( 'upload' === content.mode() ) {
                this.frame.content.mode('browse');
            }

            if ( this.get( 'autoSelect' ) ) {

                if ( wp.Uploader.queue.length == 1 && selection.length ) {
                    selection.reset();
                }
                selection.add( attachment );
                selection.trigger( 'selection:unsingle', selection.model, selection );
                selection.trigger( 'selection:single', selection.model, selection );
            }
        }
    });



    /**
     * wp.media.view.AttachmentCompat
     *
     */

    _.extend( media.view.AttachmentCompat.prototype, {

        save: function( event ) {

            var data = {},
                spinner;


            if ( event ) {
                event.preventDefault();
            }

            if ( this.controller.isModeActive( 'wpmlc-grid' ) ) {
                spinner = this.controller.browserView.toolbar.get( 'spinner' );
            }

            _.each( this.$el.serializeArray(), function( pair ) {
                data[ pair.name ] = pair.value;
            });

            $( 'input', this.$el ).prop('disabled', true);
            if ( spinner ) {
                spinner.show();
            }

            this.noRender = true;
            //media.model.Query.cleanQueries();

            this.controller.trigger( 'attachment:compat:waiting', ['waiting'] );
            this.model.saveCompat( data ).done( _.bind( this.postSave, this, 1 ) ).fail( _.bind( this.postSave, this, 0 ) );
        },

        postSave: function( success ) {

            var toolbar,
                spinner,
                wpmlcMessage;


            if ( 'edit-attachment' !== this.controller._state ) {
                toolbar = this.controller.toolbar.get();
            }

            if ( this.controller.isModeActive( 'wpmlc-grid' ) ) {
                spinner = this.controller.browserView.toolbar.get( 'spinner' );
            }


            $( 'input', this.$el ).prop('disabled', false);

            if ( spinner ) {
                spinner.hide();
            }

            if ( toolbar ) {
                wpmlcMessage = success ? toolbar.get( 'wpmlcAttachmentSuccess' ) : toolbar.get( 'wpmlcAttachmentError' );

                wpmlcMessage.$el.fadeIn( 200 );
                setTimeout( function() {
                    wpmlcMessage.$el.fadeOut( 100 );
                }, 800 );
            }

            this.controller.trigger( 'attachment:compat:ready', ['ready'] );
        },

        render: function() {

            var compat = this.model.get('compat'),
                $compat_el = this.$el,
                tcount = this.model.get('tcount');

            _.each( tcount, function( count, term_id ) {

                var $option = $( '.wpmlc-taxonomy-filters option[value="'+term_id+'"]' ),
                    text = $option.text();

                text = text.replace( /\(.*?\)/, '('+count+')' );
                $option.text( text );
            });

            if ( ! compat || ! compat.item ) {
                return;
            }

            if ( this.noRender ) {
                return this;
            }

            this.views.detach();
            this.$el.html( compat.item );
            this.views.render();

            return this;
        }
    });



    /**
     * wp.media.view.AttachmentFilters
     *
     */
    _.extend( media.view.AttachmentFilters.prototype, {

        change: function() {

            var filter = this.filters[ this.el.value ],
                selection = this.controller.state().get( 'selection' ),
                resetFilterButton = this.controller.content.get().toolbar.get( 'resetFilterButton' ),


                all = $('.attachment-filters').length,
                unchanged = $('.attachment-filters').map(function(){
                    return this.value
                }).get().filter( function( val ){
                    return 'all' === val
                }).length;


            if ( filter ) {
                this.model.set( filter.props );
            }


            if ( filter && selection && selection.length && wp.Uploader.queue.length !== 1 ) {
                selection.reset();
            }


            if ( filter && mediaTrash && ! _.isUndefined( this.controller.toolbar ) ) {
                this.controller.toolbar.get().$('.media-selection').toggleClass( 'trash', 'trash' === filter.props.status );
            }


            if ( _.isUndefined( resetFilterButton ) ) {
                return;
            }

            resetFilterButton.model.set( 'disabled', all === unchanged );
        },

        select: function() {

            var model = this.model,
                value = 'all',
                props = model.toJSON();


            props = _.omit( props, 'orderby', 'order' );

            _.find( this.filters, function( filter, id ) {

                var filterProps = _.omit( filter.props, 'orderby', 'order' );
                var equal = _.all( filterProps, function( prop, key ) {
                    return prop === ( _.isUndefined( props[ key ] ) ? null : props[ key ] );
                });

                if ( equal ) {
                    return value = id;
                }
            });

            this.$el.val( value );
        }
    });




    /**
     * wp.media.view.AttachmentFilters
     *
     */
    original.AttachmentFilters = {

        All: {
            createFilters: media.view.AttachmentFilters.All.prototype.createFilters
        },

        Uploaded: {
            createFilters: media.view.AttachmentFilters.Uploaded.prototype.createFilters
        }
    };



    /**
     * wp.media.view.AttachmentFilters.All
     *
     */
    _.extend( media.view.AttachmentFilters.All.prototype, {

        createFilters: function() {

            var uncategorizedProps,
                taxonomies = _.intersection( _.keys( wpmlc.l10n.taxonomies ), wpmlc.l10n.filter_taxonomies );


            original.AttachmentFilters.All.createFilters.apply( this, arguments );

            _.each( this.filters, function( filter, key ) {
                filter.props['uncategorized'] = null;
                filter.props['orderby'] = wpmlc.l10n.media_orderby;
                filter.props['order'] = wpmlc.l10n.media_order;
            });

            this.filters.uncategorized = {
                text:  wpmlc.l10n.uncategorized,
                props: {
                    uploadedTo    : null,
                    uncategorized : true,
                    status        : null,
                    type          : null,
                    orderby       : wpmlc.l10n.media_orderby,
                    order         : wpmlc.l10n.media_order
                },
                priority: 60
            };


            uncategorizedProps = this.filters.uncategorized.props;

            _.each( taxonomies, function( taxonomy ) {
                uncategorizedProps[taxonomy] = null;
            });


            if ( mediaTrash &&
                ( this.controller.isModeActive( 'grid' ) ||
                this.controller.isModeActive( 'wpmlc-grid' ) ) ) {

                this.filters.trash = {
                    text:  l10n.trash,
                    props: {
                        uploadedTo : null,
                        status     : 'trash',
                        type       : null,
                        orderby    : 'date',
                        order      : 'DESC'
                    },
                    priority: 70
                };
            }
        }
    });



    /**
     * wp.media.view.AttachmentFilters.Uploaded
     *
     */
    _.extend( media.view.AttachmentFilters.Uploaded.prototype, {

        createFilters: function() {

            var uncategorizedProps,
                taxonomies = _.intersection( _.keys( wpmlc.l10n.taxonomies ), wpmlc.l10n.filter_taxonomies );


            original.AttachmentFilters.Uploaded.createFilters.apply( this, arguments );

            _.each( this.filters, function( filter, key ) {
                filter.props['orderby'] = wpmlc.l10n.media_orderby;
                filter.props['order'] = wpmlc.l10n.media_order;
            });
        }
    });



    /**
     * wp.media.view.AttachmentFilters.Taxonomy
     *
     */
    media.view.AttachmentFilters.Taxonomy = media.view.AttachmentFilters.extend({

        id: function() {

            return 'media-attachment-'+this.options.taxonomy+'-filters';
        },

        className: function() {

            // TODO: get rid of excess class name that duplicates id
            return 'attachment-filters wpmlc-taxonomy-filters attachment-'+this.options.taxonomy+'-filter';
        },

        createFilters: function() {

            var filters = {},
                self = this;


            _.each( self.options.termList || {}, function( term, key ) {

                var term_id = term.term_id,
                    term_row = $("<div/>").html(term.term_row).text();

                filters[ term_id ] = {
                    text: term_row,
                    props: {
                        uncategorized : null,
                        orderby       : wpmlc.l10n.media_orderby,
                        order         : wpmlc.l10n.media_order
                    },
                    priority: key+4
                };

                filters[term_id]['props'][self.options.taxonomy] = term_id;
            });

            filters.all = {
                text: wpmlc.l10n.filter_by,
                props: {
                    uncategorized : null,
                    orderby       : wpmlc.l10n.media_orderby,
                    order         : wpmlc.l10n.media_order
                },
                priority: 1
            };

            filters['all']['props'][self.options.taxonomy] = null;

            this.filters = filters;
        }
    });



    /**
     * wp.media.view.AttachmentFilters.Authors
     *
     */
    media.view.AttachmentFilters.Authors = media.view.AttachmentFilters.extend({

        createFilters: function() {

            var filters = {},
                self = this;


            _.each( self.options.users || {}, function( user, key ) {

                var user_id = user.user_id,
                    user_name = user.user_name;

                filters[ user_id ] = {
                    text: user_name,
                    props: {
                        author        : user_id,
                        orderby       : wpmlc.l10n.media_orderby,
                        order         : wpmlc.l10n.media_order
                    },
                    priority: key+2
                };
            });

            filters.all = {
                text: wpmlc.l10n.in + ' ' + wpmlc.l10n.authors,
                props: {
                    author        : null,
                    orderby       : wpmlc.l10n.media_orderby,
                    order         : wpmlc.l10n.media_order
                },
                priority: 1
            };

            this.filters = filters;
        }
    });



    /**
     * wp.media.view.Button.resetFilters
     *
     */
    media.view.Button.resetFilters = media.view.Button.extend({

        id: 'reset-all-filters',

        initialize: function() {

            media.view.Button.prototype.initialize.apply( this, arguments );
            this.controller.on( 'select:activate select:deactivate', this.toogleResetFilters, this );
        },

        click: function( event ) {

            if ( '#' === this.attributes.href ) {
                event.preventDefault();
            }

            $('.attachment-filters:has(option[value!="all"]:selected)').each( function( index ) {
                $(this).val( 'all' ).change();
            });
        },

        toogleResetFilters: function() {
            this.$el.toggleClass( 'hidden' );
        }
    });



    /**
     * wp.media.view.wpmlcAttachmentDetailsEditMessage
     *
     */
    media.view.wpmlcAttachmentDetailsEditMessage = media.View.extend({

        tagName:    'div',
        id:         'wpmlc-save-changes-message',

        initialize: function() {
            this.text = this.options.text;
            this.class = this.options.class;
        },

        render: function() {
            this.$el.addClass( this.class );
            this.$el.html( '<p><strong>'+this.text+'</strong></p>' );

            return this;
        }
    });



    /**
     * wp.media.view.Attachment.Details
     *
     */

    _.extend( media.view.Attachment.Details.prototype, {

        deleteAttachment: function( event ) {
            event.preventDefault();

            if ( window.confirm( l10n.warnDelete ) ) {
                this.model.destroy();
                // Keep focus inside media modal
                // after image is deleted
                if ( this.controller.modal ) {
                    this.controller.modal.focusManager.focus();
                }
            }
        },
    });



    /**
     * wp.media.view.AttachmentsBrowser
     *
     */
    original.AttachmentsBrowser = {

        initialize: media.view.AttachmentsBrowser.prototype.initialize,
        createToolbar: media.view.AttachmentsBrowser.prototype.createToolbar,
        createSidebar: media.view.AttachmentsBrowser.prototype.createSidebar,
        createSingle: media.view.AttachmentsBrowser.prototype.createSingle,
        disposeSingle: media.view.AttachmentsBrowser.prototype.disposeSingle
    };

    _.extend( media.view.AttachmentsBrowser.prototype, {

        initialize: function() {

            original.AttachmentsBrowser.initialize.apply( this, arguments );

            this.on( 'ready', this.fixLayout, this );
            this.$window = $( window );
            this.$window.on( 'resize', _.debounce( _.bind( this.fixLayout, this ), 15 ) );

            if ( $('.notice-dismiss').length ) {
                $( document ).on( 'click', '.notice-dismiss', _.debounce( _.bind( this.fixLayout, this), 250 ) );
            }
        },

        fixLayout: function() {

            var $browser = this.$el,
                $attachments = $browser.find('.attachments'),
                $uploader = $browser.find('.uploader-inline'),
                $toolbar = $browser.find('.media-toolbar'),
                $messages = $('.wpmlc-media-css .updated:visible, .wpmlc-media-css .error:visible, .wpmlc-media-css .notice:visible, .wpmlc-media-css .notice-error:visible, .wpmlc-media-css .notice-warning:visible, .wpmlc-media-css .notice-success:visible, .wpmlc-media-css .notice-info:visible'),
                $update_nag = $('.wpmlc-media-css .update-nag');


            if ( $update_nag.length ) {
                $update_nag.css( 'margin-left', 15 + 'px' );
                $browser.closest('.wrap').css( 'top', $update_nag.outerHeight() + 25 + 'px' );
            }


            if ( ! this.controller.isModeActive( 'select' ) &&
                 ! this.controller.isModeActive( 'wpmlc-grid' ) ) {
                return;
            }

            if ( this.controller.isModeActive( 'select' ) ) {

                $attachments.css( 'top', $toolbar.height() + 10 + 'px' );
                $uploader.css( 'top', $toolbar.height() + 10 + 'px' );
                $browser.find('.wpmlc-loader').css( 'top', $toolbar.height() + 10 + 'px' );

                // TODO: find a better place for it, something like fixLayoutOnce
                $toolbar.find('.media-toolbar-secondary').prepend( $toolbar.find('.instructions') );
            }

            if ( this.controller.isModeActive( 'wpmlc-grid' ) )
            {
                var messagesOuterHeight = 0;


                if ( ! _.isUndefined( $messages ) )
                {
                    $messages.each( function() {
                        messagesOuterHeight += $(this).outerHeight( true );
                    });

                    messagesOuterHeight = messagesOuterHeight ? messagesOuterHeight - 15 : 0;
                }

                $browser.css( 'top', $toolbar.outerHeight() + messagesOuterHeight + 15 + 'px' );
                $toolbar.css( 'top', - $toolbar.outerHeight() - 25 + 'px' );
            }
        },

        createToolbar: function() {

            var LibraryViewSwitcher, Filters, toolbarOptions,
                self = this,
                i = 1,
                isResetButton = false;


            toolbarOptions = {
                controller: this.controller
            };

            if ( this.controller.isModeActive( 'grid' ) ||
                this.controller.isModeActive( 'wpmlc-grid' ) ) {

                toolbarOptions.className = 'media-toolbar wp-filter';
            }

            /**
            * @member {wp.media.view.Toolbar}
            */
            this.toolbar = new media.view.Toolbar( toolbarOptions );

            this.views.add( this.toolbar );

            this.toolbar.set( 'spinner', new media.view.Spinner({
                priority: -40
            }) );


            if ( this.controller.isModeActive( 'grid' ) ||
                this.controller.isModeActive( 'wpmlc-grid' ) ) {

                LibraryViewSwitcher = media.View.extend({
                    className: 'view-switch media-grid-view-switch',
                    template: media.template( 'media-library-view-switcher')
                });

                this.toolbar.set( 'libraryViewSwitcher', new LibraryViewSwitcher({
                    controller: this.controller,
                    priority: -90
                }).render() );
            }


            if ( -1 !== $.inArray( this.options.filters, [ 'uploaded', 'all' ] ) ||
                ( parseInt( wpmlc.l10n.force_filters ) &&
                ! this.controller.isModeActive( 'wpmlc-bulk-edit' ) &&
                'gallery-edit' !== this.controller._state &&
                'playlist-edit' !== this.controller._state &&
                'video-playlist-edit' !== this.controller._state ) ||
                'customize' === wpmlc.l10n.current_screen ||
                'widgets' === wpmlc.l10n.current_screen ) {

                if ( wpmlc.l10n.wp_version >= '5.3' ) {
                    /*
                    * Create a h2 heading before the select elements that filter attachments.
                    * This heading is visible in the modal and visually hidden in the grid.
                    */
                    this.toolbar.set( 'filters-heading', new wp.media.view.Heading( {
                        priority:   -100,
                        text:       l10n.filterAttachments,
                        level:      'h2',
                        className:  'media-attachments-filter-heading'
                    }).render() );
                }

                if ( -1 !== $.inArray( 'types', wpmlc.l10n.filters_to_show ) ) {

                    this.toolbar.set( 'filtersLabel', new media.view.Label({
                        value: l10n.filterByType,
                        attributes: {
                            'for':  'media-attachment-filters'
                        },
                        priority:   -80
                    }).render() );

                    if ( 'uploaded' === this.options.filters ) {
                        this.toolbar.set( 'filters', new media.view.AttachmentFilters.Uploaded({
                            controller: this.controller,
                            model:      this.collection.props,
                            priority:   -80
                        }).render() );
                    } else {
                        Filters = new media.view.AttachmentFilters.All({
                            controller: this.controller,
                            model:      this.collection.props,
                            priority:   -80
                        });

                        this.toolbar.set( 'filters', Filters.render() );
                    }
                }

                if ( wpmlc.l10n.wp_version >= '4.0' && -1 !== $.inArray( 'dates', wpmlc.l10n.filters_to_show ) && media.view.settings.months.length ) {

                    this.toolbar.set( 'dateFilterLabel', new media.view.Label({
                        value: l10n.filterByDate,
                        attributes: {
                            'for': 'media-attachment-date-filters'
                        },
                        priority: -75
                    }).render() );
                    this.toolbar.set( 'dateFilter', new media.view.DateFilter({
                        controller: this.controller,
                        model:      this.collection.props,
                        priority: -75
                    }).render() );
                }

                if ( wpmlc.l10n.users.length > 1 && -1 !== $.inArray( 'authors', wpmlc.l10n.filters_to_show ) ) {

                    this.toolbar.set( 'authorFilterLabel', new media.view.Label({
                        value: wpmlc.l10n.filter_by + ' ' + wpmlc.l10n.author,
                        attributes: {
                            'for':  'author-filter',
                        },
                        priority: -70 + i++
                    }).render() );
                    this.toolbar.set( 'author-filter', new media.view.AttachmentFilters.Authors({
                        controller: this.controller,
                        model: this.collection.props,
                        priority: -70 + i++,
                        users: wpmlc.l10n.users,
                    }).render() );
                }

                if ( -1 !== $.inArray( 'taxonomies', wpmlc.l10n.filters_to_show ) ) {
                    $.each( wpmlc.l10n.taxonomies, function( taxonomy, values ) {

                        if ( -1 !== _.indexOf( wpmlc.l10n.filter_taxonomies, taxonomy ) && values.term_list.length ) {

                            self.toolbar.set( taxonomy+'FilterLabel', new media.view.Label({
                                value: wpmlc.l10n.filter_by,
                                attributes: {
                                    'for':  'media-attachment-' + taxonomy + '-filters',
                                },
                                priority: -70 + i++
                            }).render() );
                            self.toolbar.set( taxonomy+'-filter', new media.view.AttachmentFilters.Taxonomy({
                                controller: self.controller,
                                model: self.collection.props,
                                priority: -70 + i++,
                                taxonomy: taxonomy,
                                termList: values.term_list
                            }).render() );
                        }
                    });
                }

                if ( this.toolbar.$el.find('.attachment-filters').length > 1 ) {
                    this.toolbar.set( 'resetFilterButton', new media.view.Button.resetFilters({
                        controller: this.controller,
                        text: wpmlc.l10n.reset_filters,
                        disabled: true,
                        priority: -70 + i++
                    }).render() );
                }

            } // endif


            if ( this.controller.isModeActive( 'wpmlc-grid' ) ) {

                var toolbar = this.controller.toolbar.get();

                if ( $('body').hasClass('wpmlc-pro-media-css') ) {
                    toolbar.set( 'wpmlcSelectAllButton', new media.view.wpmlcSelectAllButton({
                        filters: Filters,
                        disabled: true,
                        text: wpmlc.l10n.select_all,
                        controller: this.controller,
                        priority: -80
                    }).render() );
                }

                toolbar.set( 'wpmlcDeselectButton', new media.view.wpmlcDeselectButton({
                    filters: Filters,
                    disabled: true,
                    text: l10n.cancelSelection,
                    controller: this.controller,
                    priority: -70
                }).render() );

                toolbar.set( 'wpmlcDeleteSelectedButton', new media.view.wpmlcDeleteSelectedButton({
                    filters: Filters,
                    style: 'primary',
                    disabled: true,
                    text: mediaTrash ? l10n.trashSelected : l10n.deleteSelected,
                    controller: this.controller,
                    priority: -60
                }).render() );

                if ( mediaTrash ) {
                    toolbar.set( 'wpmlcDeleteSelectedPermanentlyButton', new media.view.wpmlcDeleteSelectedPermanentlyButton({
                        filters: Filters,
                        style: 'primary',
                        disabled: true,
                        text: l10n.deleteSelected,
                        controller: this.controller,
                        priority: -50
                    }).render() );
                }
            }


            // in case it is not wpmlc-grid but the original grid somewhere
            if ( this.controller.isModeActive( 'grid' ) ) {

                // BulkSelection is a <div> with subviews, including screen reader text
                this.toolbar.set( 'selectModeToggleButton', new media.view.SelectModeToggleButton({
                    text: l10n.bulkSelect,
                    controller: this.controller,
                    priority: -70
                }).render() );

                this.toolbar.set( 'deleteSelectedButton', new media.view.DeleteSelectedButton({
                    filters: Filters,
                    style: 'primary',
                    disabled: true,
                    text: mediaTrash ? l10n.trashSelected : l10n.deleteSelected,
                    controller: this.controller,
                    priority: -60,
                    click: function() {
                        var changed = [], removed = [],
                            selection = this.controller.state().get( 'selection' ),
                            library = this.controller.state().get( 'library' );

                        if ( ! selection.length ) {
                            return;
                        }

                        if ( ! mediaTrash && ! window.confirm( l10n.warnBulkDelete ) ) {
                            return;
                        }

                        if ( mediaTrash &&
                            'trash' !== selection.at( 0 ).get( 'status' ) &&
                            ! window.confirm( l10n.warnBulkTrash ) ) {

                            return;
                        }

                        selection.each( function( model ) {
                            if ( ! model.get( 'nonces' )['delete'] ) {
                                removed.push( model );
                                return;
                            }

                            if ( mediaTrash && 'trash' === model.get( 'status' ) ) {
                                model.set( 'status', 'inherit' );
                                changed.push( model.save() );
                                removed.push( model );
                            } else if ( mediaTrash ) {
                                model.set( 'status', 'trash' );
                                changed.push( model.save() );
                                removed.push( model );
                            } else {
                                model.destroy({wait: true});
                            }
                        } );

                        if ( changed.length ) {
                            selection.remove( removed );

                            $.when.apply( null, changed ).then( _.bind( function() {
                                library._requery( true );
                                this.controller.trigger( 'selection:action:done' );
                            }, this ) );
                        } else {
                            this.controller.trigger( 'selection:action:done' );
                        }
                    }
                }).render() );

                if ( mediaTrash ) {
                    this.toolbar.set( 'deleteSelectedPermanentlyButton', new wp.media.view.DeleteSelectedPermanentlyButton({
                        filters: Filters,
                        style: 'primary',
                        disabled: true,
                        text: l10n.deleteSelected,
                        controller: this.controller,
                        priority: -55,
                        click: function() {
                            var removed = [], selection = this.controller.state().get( 'selection' );

                            if ( ! selection.length || ! window.confirm( l10n.warnBulkDelete ) ) {
                                return;
                            }

                            selection.each( function( model ) {
                                if ( ! model.get( 'nonces' )['delete'] ) {
                                    removed.push( model );
                                    return;
                                }

                                model.destroy({wait: true});
                            } );

                            this.controller.trigger( 'selection:action:done' );
                        }
                    }).render() );
                }
            }

            if ( this.options.search ) {

                this.toolbar.set( 'searchLabel', new media.view.Label({
                    value: l10n.searchMediaLabel,
                    attributes: {
                        'for': 'media-search-input'
                    },
                    priority:   -30
                }).render() );

                this.toolbar.set( 'search', new media.view.Search({
                    controller: this.controller,
                    model:      this.collection.props,
                    attributes: {
                        type:        'search',
                        value: l10n.searchMediaLabel,
                        placeholder: l10n.searchMediaPlaceholder
                    },
                    priority:   -30
                }).render() );
            }

            if ( this.options.dragInfo ) {
                this.toolbar.set( 'dragInfo', new media.View({
                    el: $( '<div class="instructions">' + l10n.dragInfo + '</div>' )[0],
                    priority: -40
                }) );
            }

            // if ( 'edit-attachment' !== this.controller._state ) {

            //     var toolbar = this.controller.toolbar.get();

            //     toolbar.set( 'wpmlcAttachmentSuccess', new media.view.wpmlcAttachmentDetailsEditMessage({
            //         text: wpmlc.l10n.saveButton_success,
            //         class: 'updated',
            //         controller: this.controller,
            //         priority:   200
            //     }) );

            //     toolbar.set( 'wpmlcAttachmentError', new media.view.wpmlcAttachmentDetailsEditMessage({
            //         text: wpmlc.l10n.saveButton_failure,
            //         class: 'error',
            //         controller: this.controller,
            //         priority:   220
            //     }) );
            // }
        },

        createSidebar: function() {
            original.AttachmentsBrowser.createSidebar.apply( this, arguments );

            if ( this.controller.isModeActive( 'wpmlc-grid' ) ) {
                this.toggleSidebar();
            }
        },

        toggleSidebar: function() {

            var selection = this.controller.state().get( 'selection' );

            if ( selection.length ) {
                this.sidebar.$el.removeClass( 'hidden' );
                this.$el.children('.attachments').css( 'right', '300px' );
                this.$el.children('.uploader-inline').css( 'right', '310px' );
            }
            else {
                this.sidebar.$el.addClass( 'hidden' );
                this.$el.children('.attachments').css( 'right', 0 );
                this.$el.children('.uploader-inline').css( 'right', '10px' );
            }
        },

        createSingle: function() {

            original.AttachmentsBrowser.createSingle.apply( this, arguments );

            if ( this.controller.isModeActive( 'wpmlc-grid' ) ) {

                var sidebar = this.sidebar,
                    single = this.options.selection.single();

                if ( 'trash' !== this.options.selection.at( 0 ).get( 'status' ) ) {
                    sidebar.set( 'details', new wp.media.view.wpmlcGridAttachmentDetails({
                        controller: this.controller,
                        model:      single,
                        priority:   80
                    }) );
                }

                this.toggleSidebar();
            }
        },

        disposeSingle: function() {

            original.AttachmentsBrowser.disposeSingle.apply( this, arguments );

            if ( this.controller.isModeActive( 'wpmlc-grid' ) ) {
                this.toggleSidebar();
            }
        },

        updateContent: function() {

            var view = this,
                noItemsView;

            if ( this.controller.isModeActive( 'grid' ) ||
                 this.controller.isModeActive( 'wpmlc-grid' ) ) {
                noItemsView = view.attachmentsNoResults;
            } else {
                noItemsView = view.uploader;
            }

            if ( ! this.collection.length ) {

                this.toolbar.get( 'spinner' ).show();

                this.dfd = this.collection.more().done( function() {

                    if ( ! view.collection.length ) {
                        noItemsView.$el.removeClass( 'hidden' );
                    } else {
                        noItemsView.$el.addClass( 'hidden' );
                    }
                    view.toolbar.get( 'spinner' ).hide();
                } );

            } else {

                noItemsView.$el.addClass( 'hidden' );
                view.toolbar.get( 'spinner' ).hide();
            }
        },

        createUploader: function() {

            this.uploader = new media.view.UploaderInline({
                controller: this.controller,
                status:     false,
                message:    this.controller.isModeActive( 'grid' ) || this.controller.isModeActive( 'wpmlc-grid' ) ? '' : l10n.noItemsFound,
                canClose:   this.controller.isModeActive( 'grid' ) || this.controller.isModeActive( 'wpmlc-grid' )
            });

            this.uploader.$el.addClass( 'hidden' );
            this.views.add( this.uploader );
        },

        // createAttachments: function() {
        //     this.attachments = new media.view.Attachments({
        //         controller:           this.controller,
        //         collection:           this.collection,
        //         selection:            this.options.selection,
        //         model:                this.model,
        //         sortable:             this.options.sortable,
        //         scrollElement:        this.options.scrollElement,
        //         idealColumnWidth:     this.options.idealColumnWidth,
        //
        //         // The single `Attachment` view to be used in the `Attachments` view.
        //         AttachmentView: this.options.AttachmentView
        //     });
        //
        //     // Add keydown listener to the instance of the Attachments view
        //     this.attachments.listenTo( this.controller, 'attachment:keydown:arrow',     this.attachments.arrowEvent );
        //     this.attachments.listenTo( this.controller, 'attachment:details:shift-tab', this.attachments.restoreFocus );
        //
        //     this.views.add( this.attachments );
        //
        //     if ( this.controller.isModeActive( 'grid' ) ||
        //         this.controller.isModeActive( 'wpmlc-grid' ) ) {
        //
        //         this.attachmentsNoResults = new media.View({
        //             controller: this.controller,
        //             tagName: 'p'
        //         });
        //
        //         this.attachmentsNoResults.$el.addClass( 'hidden no-media' );
        //         this.attachmentsNoResults.$el.html( l10n.noItemsFound );
        //
        //         this.views.add( this.attachmentsNoResults );
        //     }
        // }
    });



    /**
     * wp.media.view.MediaFrame.Post
     *
     */
    original.MediaFrame = {

        Post: {
            activate: media.view.MediaFrame.Post.prototype.activate
        }
    };

    _.extend( media.view.MediaFrame.Post.prototype, {

        activate: function() {

            var content = this.content.get();

            original.MediaFrame.Post.activate.apply( this, arguments );

            this.on( 'open', content.fixLayout, content );
            if ( typeof acf !== 'undefined' && $('.acf-expand-details').length ) {
                $( document ).on( 'click', '.acf-expand-details', _.debounce( _.bind( content.fixLayout, content ), 250 ) );
            }
        }
    });



    $( document ).ready( function() {

        // TODO: find a better place for this
        $( document ).on( 'mousedown', '.media-frame .attachments-browser .attachments li', function ( event ) {

            if ( event.ctrlKey || event.shiftKey ) {
                event.preventDefault();
            }
        });
    });



    // TODO: move to the PHP side
    $('body').addClass('wpmlc-media-css');

})( jQuery, _ );
