/**
 * Navigation
 *
 * @package WordPress
 * @since 1.0.0
 */

/* eslint-disable no-mixed-operators */

jQuery( document ).ready(
	function( $ ) {
		// Mobile Menu (hidden on desktop).
		$( '.hamburger' ).click(
			function( e ) {
				e.preventDefault();
				$( 'body' ).toggleClass( 'menu-is-active' );
				$( this ).toggleClass( 'is-active' );
				$( '.menu-container-with-search' ).toggleClass( 'is-active' );
			}
		);

		// Desktop Search (hidden on mobile).
		$( '.search-button' ).click(
			function( e ) {
				e.preventDefault();
				$( '.search-bar' ).toggleClass( 'is-active' );
				$( '.search-input' ).focus();
			}
		);

		// Mobile toggle to open menus on touch.
		if ( $( window ).width() < 1000 || $( window ).height() < 700 ) {
			$( 'li.menu-item-has-children > a' ).click(
				function( e ) {
					e.preventDefault();
					$( this ).toggleClass( 'is-open' );
					$( this ).parent().children( '.sub-menu:first' ).slideToggle( 500 );
				}
			);
		} else {
			// Desktop - Stop empty menu parents jumping to top of screen on click.
			$( '.main-navigation li.menu-item-has-children a' ).click(
				function( e ) {
					if ( $( this ).attr( 'href' ) === '#' ) {
						e.preventDefault();
					}
				}
			);
		}

		// Keep menu inside viewport.
		if ( $( window ).width() >= 1000 && $( window ).height() >= 700 ) {
			$( '.sub-menu li.menu-item-has-children' ).on(
				'mouseenter mouseleave',
				function() {
					if ( $( 'ul', this ).length ) {
						const elm = $( 'ul:first', this );
						const off = elm.offset();
						const position = $( this ).position();

						// width.
						const l = off.left;
						const w = elm.width();
						const docW = $( '.site-header' ).width();
						const outsideWidth = ( l + w <= docW );

						// height.
						const t = position.top;
						const h = elm.height();
						const docH = window.innerHeight;
						const outsideHeight = ( t + h + 100 <= docH );

						if ( ! outsideWidth ) {
							$( this ).addClass( 'is-edge' );
						} else {
							$( this ).removeClass( 'is-edge' );
						}

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
				}
			);
		}
	}
);
