/**
 * Tab Container JS
 *
 * @package WordPress
 * @since 1.0.0
 */

/* eslint-disable no-undef */
/* eslint-disable no-unused-vars */
/* eslint-disable array-callback-return */
/* eslint-disable no-var */

jQuery( document ).ready(
	function( $ ) {
		// Setup Sticky.
		let sticky;
		let setSticky;
		( setSticky = function() {
			sticky = new Sticky(
				'.sticky-element',
				{
					marginTop: getSpacing(),
					marginBottom: 100,
					stickyFor: 800,
				}
			);
		} )();

		// If page loads with hash, go to it nicely after 1s.
		if ( window.location.hash ) {
			// smooth scroll to the anchor id if exists after 1s.
			if ( $( window.location.hash ).length ) {
				let theHash = $( window.location.hash );
				let offsetNew = theHash === '#' ? 0 : theHash.offset().top - getSpacing();
				setTimeout(
					function() {
						$( 'html, body' )
							.animate(
								{
									scrollTop: offsetNew,
								},
								500
							);
					},
					1000
				);
			}
		}

		// create array of elements from nav links.
		let topMenu = $( '.tab-container-nav' );
		if ( topMenu.length > 0 ) {
			let lastId;
			let menuItems = topMenu.find( 'a' );
			let scrollItems = menuItems.map(
				function() {
					let item = $( $( this ).attr( 'href' ) );
					if ( item.length ) {
						return item;
					}
				}
			);

			// Check nav items are in view as user scrolls.
			$( window ).on( 'scroll', window.utils.isThrottled( navInView, 200, true ) );

			// Update nav and hash as user scrolls.
			$( window ).on( 'scroll', window.utils.isThrottled( navUpdate, 200, true ) );

			// Update Sticky on resize.
			$( window ).on( 'resize', window.utils.isThrottled( setSticky, 200, true ) );

			// Click handler for menu items so we can get a fancy scroll animation.
			menuItems.click(
				function( e ) {
					let href = $( this ).attr( 'href' );
					let offsetTop = href === '#' ? 0 : $( href ).offset()
						.top - getSpacing();
					$( 'html, body' )
						.stop()
						.animate(
							{
								scrollTop: offsetTop,
							},
							500
						);
					e.preventDefault();
				}
			);

			// Function to update nav and hash as user scrolls.
			function navUpdate() {
				let fromTop = $( this ).scrollTop();

				// Get id of current scroll item, add 20 for padding from header.
				let cur = scrollItems.map(
					function() {
						if ( $( this ).offset().top < fromTop + getSpacing() + 20 ) {
							return this;
						}
					}
				);

				// Get the id of the current element.
				cur = cur[ cur.length - 1 ];
				let id = cur && cur.length ? cur[ 0 ].id : '';

				if ( lastId !== id ) {
					lastId = id;
					// Set/remove active class.
					menuItems
						.parent()
						.removeClass( 'is-active' )
						.end()
						.filter( "[href='#" + id + "']" )
						.parent()
						.addClass( 'is-active' );
					if ( id ) {
						if ( history.pushState ) {
							window.history.replaceState(
								null,
								null,
								'#' + id
							);
						} else {
							// IE9, IE8, etc.
							window.location.hash = '#!' + id;
						}
					} else {
						removeHash();
					}
				}
			}
		}

		// Get spacing required from top of window for content.
		function getSpacing() {
			let spacingTotal = 0;
			let winH = $( window ).height();
			let winW = $( window ).width();
			const adminBar = $( '#wpadminbar' );

			if ( winH < 616 && winW > 514 ) {
				spacingTotal += 40;
			} else if ( winW < 800 ) {
				spacingTotal += 80;
			} else {
				spacingTotal += 125;
			}
			if ( adminBar.length > 0 ) {
				spacingTotal += 32;
			}
			return spacingTotal;
		}

		// Remove hash from URL.
		function removeHash() {
			let scrollV;
			let scrollH;
			let loc = window.location;

			if ( 'pushState' in history ) {
				history.pushState( '', document.title, loc.pathname + loc.search );
			} else {
				// Prevent scrolling by storing the page's current scroll offset.
				scrollV = document.body.scrollTop;
				scrollH = document.body.scrollLeft;

				loc.hash = '';

				// Restore the scroll offset, should be flicker free.
				document.body.scrollTop = scrollV;
				document.body.scrollLeft = scrollH;
			}
		}

		// Looks for nav item and checks its in view.
		function navInView() {
			let currentItem = $( '.tab-container-nav-item.is-active' );
			let winW = $( window ).width();

			if ( winW > 799 && currentItem.length ) {
				currentItem[ 0 ].scrollIntoView(
					{
						block: 'nearest',
					}
				);
			}
		}

		// END.
	}
);
