/**
 * Navigation
 *
 * @package WordPress
 * @since 1.0.0
 */

/* eslint-disable no-mixed-operators */

jQuery( document ).ready(
	function( $ ) {
		// Check for mobile.
		let isMobile = ( ( $( window ).width() < 1000 ) || ( $( window ).height() < 700 ) );

		if ( isMobile ) {
			// Mobile Menu (hidden on desktop).
			$( '.hamburger' ).on( 'click', hamburgerMenu );

			// Toggle open menus on touch.
			$( 'li.menu-item-has-children > a' ).on( 'click', toggleMenu );
		} else {
			// On desktop.

			// Desktop Search (hidden on mobile).
			$( '.search-button' ).on( 'click', toggleSearch );

			// Stop empty parents creating hash.
			$( 'li.menu-item-has-children > a' ).on( 'click', preventClick );

			// Keep menu inside viewport.
			$( '.sub-menu li.menu-item-has-children' ).on(
				'mouseenter mouseleave',
				edgeDetector
			);
		}

		// Makes Hamburger Menu active.
		function hamburgerMenu( e ) {
			e.preventDefault();
			$( 'body' ).toggleClass( 'menu-is-active' );
			$( this ).toggleClass( 'is-active' );
			$( '.menu-container-with-search' ).toggleClass( 'is-active' );
		}

		// Slides down Mobile menu.
		function toggleMenu( e ) {
			e.preventDefault();
			$( this ).toggleClass( 'is-open' );
			$( this ).parent().children( '.sub-menu:first' ).slideToggle( 500 );
		}

		// Stops empty links being clicked.
		function preventClick( e ) {
			e.preventDefault();
		}

		// Displays Search bar.
		function toggleSearch( e ) {
			e.preventDefault();
			$( '.search-bar' ).toggleClass( 'is-active' );
			$( '.search-input' ).focus();
		}

		// Detects if menu goes over bottom or right of screen.
		function edgeDetector() {
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

		// Resize watch throttler.
		$( window ).bind(
			'resize',
			function( ) {
				window.resizeEvt;
				$( window ).resize(
					function() {
						clearTimeout( window.resizeEvt );
						window.resizeEvt = setTimeout(
							function() {
								// Check for mobile.
								let isMobileResize = ( ( $( window ).width() < 1000 ) || ( $( window ).height() < 700 ) );
								if ( isMobileResize ) {
									// Mobile Menu (hidden on desktop).
									$( '.hamburger' ).on( 'click', hamburgerMenu );

									  // Toggle open menus on touch.
									  $( 'li.menu-item-has-children > a' ).on( 'click', toggleMenu );
								} else {
									// Stop empty parents creating hash.
									$( 'li.menu-item-has-children > a' ).on( 'click', preventClick );

									// Keep menu inside viewport.
									$( '.sub-menu li.menu-item-has-children' ).on(
										'mouseenter mouseleave',
										edgeDetector
									);
								}
							},
							250
						);
					}
				);
			}
		);
	}
);
