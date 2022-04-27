/**
 * Custom Facebook Tooltip Manager
 *
 * @since 2.0
 */
'use strict';

var SBITooltipWizard = window.SBITooltipWizard || ( function( document, window, $ ) {

	/**
	 * Public functions and properties.
	 *
	 * @since 2.0
	 *
	 * @type {object}
	 */
	var app = {

		/**
		 * Start the engine.
		 *
		 * @since 2.0
		 */
		init: function() {

			//$( app.ready );
			$( window ).on( 'load', function() {
				if ( $.isFunction( $.ready.then ) ) {
					$.ready.then( app.load );
				} else {
					app.load();
				}
			} );
		},


		/**
		 * Window load.
		 *
		 * @since 2.0
		 */
		load: function() {
			if(ctf_admin_tooltip_wizard.ctf_wizard_gutenberg){
				app.initGutenbergTooltip();
			}
		},


		initGutenbergTooltip : function(){
			if ( typeof $.fn.tooltipster === 'undefined' ) {
				return;
			}
			var $dot = $( '<span class="wpforms-admin-form-embed-wizard-dot">&nbsp;</span>' );
			var anchor = '.block-editor .edit-post-header-toolbar__inserter-toggle';
			var tooltipsterArgs = {
				content          : $( '#ctf-gutenberg-tooltip-content' ),
				trigger          : 'custom',
				interactive      : true,
				animationDuration: 0,
				delay            : 0,
				theme            : [ 'tooltipster-default', 'ctf-tooltip-wizard' ],
				side             : 'bottom',
				distance         : 3,
				functionReady    : function( instance, helper ) {
					instance._$tooltip.on( 'click', '.ctf-tlp-wizard-close', function() {
						instance.close();
            $('.ctf-tooltip-wizard').hide();
					} );

					instance.reposition();
				},
			};

			$('.components-button.edit-post-header-toolbar__inserter-toggle').on('click',function() {
				$('.ctf-tooltip-wizard.tooltipster-sidetip').hide();
			});

			$dot.insertAfter( anchor ).tooltipster( tooltipsterArgs ).tooltipster( 'open' );
		},

		/**
		 * Check if we're in Gutenberg editor.
		 *
		 * @since 2.0
		 *
		 * @returns {boolean} Is Gutenberg or not.
		 */
		isGutenberg: function() {

			return typeof wp !== 'undefined' && Object.prototype.hasOwnProperty.call( wp, 'blocks' );
		},
	}

	return app;
}( document, window, jQuery ) );

SBITooltipWizard.init();
