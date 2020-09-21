/**
 * Navigation
 *
 * @package WordPress
 * @since 1.0.0
 */

/* eslint-disable no-lonely-if */
/* eslint-disable no-mixed-operators */

jQuery( document ).ready(
	function( $ ) {
		// Mobile check.
		let isMobile = checkMobile();
		function checkMobile() {
			return ( ( $( window ).width() < 1000 ) );
		}

		// Mobile Menu hamburger (hidden on desktop).
		$( '.hamburger' ).click(
			function( e ) {
				e.preventDefault();
				if ( ! isMobile ) {
					return;
				}
				$( this ).toggleClass( 'is-active' );
				$( 'body' ).toggleClass( 'menu-is-active' );
				$( '.menu-container-with-search' ).toggleClass( 'is-active' );
			},
		);

		// Desktop Search (hidden on mobile).
		$( '.search-button' ).click(
			function( e ) {
				e.preventDefault();
				if ( isMobile ) {
					return;
				}

				if ( $( '.search-bar.is-active' ).length ) {
					$( '.search-bar' ).hide();
					$( '.search-bar' ).removeClass( 'is-active' );
					// removes focus / keyboard on iOS.
					$( window ).blur();
				} else {
					$( '.search-bar' ).show();
					$( '.search-bar' ).addClass( 'is-active' );
					// put the cursor in the input field.
					document.getElementById( "search-bar" ).focus();
					// de-select text and move cursor to the end.
					document.getElementById( "search-bar" ).setSelectionRange( 99, 99 );
				}
			},
		);

		$( 'li.menu-item-has-children > a' ).click(
			function( e ) {
				e.preventDefault();
				if ( isMobile ) {
					$( this ).toggleClass( 'is-open' );
					$( this ).parent().children( '.sub-menu:first' ).slideToggle( 500 );
				} else {
					// Stop empty menu parents jumping to top of screen on click.
					if ( $( this ).attr( 'href' ) === '#' ) {
						e.preventDefault();
					}
				}
			},
		);

		// add is-current class to control arrow state (desktop only).
		$( '.main-navigation > li.menu-item-has-children' ).hover(
			function() {
				if ( ! isMobile ) {
					$( this ).removeClass( 'is-current' );
					$( this ).addClass( 'is-current' );
				}
			},
			function() {
				if ( ! isMobile ) {
					$( this ).removeClass( 'is-current' );
				}
			}
		);

		// Keep menu inside viewport.
		$( '.sub-menu li.menu-item-has-children' ).on(
			'mouseenter mouseleave',
			function() {
				if ( $( 'ul', this ).length ) {
					// pick first ul after el.
					const ul = $( 'ul:first', this );

					// testing for menu off-screen at right.
					const r = this.getBoundingClientRect().right; // menu from the edge of screen.
					const w = ul.width(); // menu element size.
					const docW = $( '.site-header' ).width(); // size of header / screen.
					const docWidthPadding = docW - 5; // padding value from edge of screen.

					const isOutsideWidth = ( ( r + w ) >= docWidthPadding );

					if ( isOutsideWidth ) {
						$( this ).addClass( 'is-off-right-edge' );
					} else {
						$( this ).removeClass( 'is-off-right-edge' );
					}

					// testing for menu off-screen at bottom.
					const position = $( this ).position();
					const t = position.top;
					const h = ul.height();
					const docH = window.innerHeight;
					const outsideHeight = ( t + h + 100 <= docH );

					if ( ! outsideHeight ) {
						// compare half height again plus buffer.
						if ( ( h / 2 + h + 100 ) >= docH ) {
							// if submenu fits in middle of screen.
							$( this ).addClass( 'is-middle' );
						} else {
							// will be bottom aligned.
							$( this ).addClass( 'is-bottom' );
						}
					} else {
						$( this ).removeClass( 'is-bottom' );
						$( this ).removeClass( 'is-middle' );
					}
				}
			},
		);

		// Resize check for is mobile.
		function resizeHandle() {
			isMobile = checkMobile();
		}

		// Update on resize.
		$( window ).on( 'resize', window.utils.isThrottled( resizeHandle, 200, true ) );

		// END.
	},
);
