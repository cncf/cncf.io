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
		let setSticky;
		let stickyMenu = $( '.sticky__nav' );
		// Set default animation speed.
		let animationSpeed = 500;
		// Get matchMedia setting.
		let prefersReducedMotionSetting = window.matchMedia( '(prefers-reduced-motion)' );
		let prefersReducedMotionQuery   = window.matchMedia( '(prefers-reduced-motion: reduce)' );
		let prefersReducedMotion        = ! prefersReducedMotionQuery || prefersReducedMotionQuery.matches;

		/**
		 * Apply Sticky
		 */
		( setSticky = function() {
			sticky = new Sticky(
				'.sticky__element',
				{
					marginTop: getSpacing(),
					marginBottom: 100,
					stickyFor: 800,
				}
			);
		} )();

		/**
		 Sets animation speed based on preferences.
		 */
		function getMotionMatch() {
			if (prefersReducedMotion) {
				animationSpeed = 0
			} else {
				animationSpeed = 500
			}
		}
		getMotionMatch();

		/**
		 * Get spacing required from top of window for content.
		 *
		 * @returns integer
		 */
		function getSpacing() {
			let spacingTotal = 0;
			let winH         = $( window ).height();
			let winW         = $( window ).width();
			const adminBar   = $( '#wpadminbar' );

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

		if ( stickyMenu.length > 0 ) {
			// Get all the links in the sticky nav.
			let menuItems = stickyMenu.find( 'a' );
			// Use the links to confirm matching page sections.
			let pageSections = menuItems.map(
				function() {
					let item = $( $( this ).attr( 'href' ) );
					if ( item.length ) {
						return item;
					}
				}
			);

			/**
			 * Listen for clicks on menu items then fancy scroll to page section.
			 */
			menuItems.click(
				function( e ) {
					e.preventDefault();
					let href      = $( this ).attr( 'href' );
					let offsetTop = href === '#' ? 0 : $( href ).offset().top - getSpacing();
					$( 'html, body' )
					.stop()
					.animate(
						{
							scrollTop: offsetTop,
						},
						animationSpeed
					);
					menuItems
						.parent()
						.removeClass( 'is-active' );
					$( this ).parent().addClass( 'is-active' );
				}
			);

			/**
			 * Update Nav, Hash as user scrolls.
			 */
			function navUpdate() {
				let fromTop    = $( this ).scrollTop();
				let headerSize = getSpacing();
				// Get all the page sections passed by scrolling.
				let currentItemElements = pageSections.map(
					function() {
						// If true, return the section name(s).
						if ( $( this ).offset().top < fromTop + headerSize ) {
							// console.log($( this ).offset().top)
							// console.log(fromTop + headerSize)
							return this;
						}
					}
				);

				// Get the ID of the last section seen.
				let currentItemId = currentItemElements[ currentItemElements.length - 1 ];

				// if neither exist we're outside sections so removeHash.
				if (currentItemElements.length == 0 && ! currentItemId ) {
					removeHash();
					menuItems
						.parent()
						.removeClass( 'is-active' )
				}

				if ( ! currentItemId ) {
					return;
				}

				// Get the precise anchor ID to use.
				let id = currentItemId && currentItemId.length ? currentItemId[ 0 ].id : '';

				if ( id  ) {
						// Set/remove active class.
						menuItems
						.parent()
						.removeClass( 'is-active' )
						.end()
						.filter( "[href='#" + id + "']" )
						.parent()
						.addClass( 'is-active' );

						// Set hash.
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
				}
			}
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
				scrollV  = document.body.scrollTop;
				scrollH  = document.body.scrollLeft;
				loc.hash = '';
				// Restore the scroll offset, should be flicker free.
				document.body.scrollTop  = scrollV;
				document.body.scrollLeft = scrollH;
			}
		}

		// Looks for nav item and checks its in view.
		// TODO: This fucks up initial scrolling. Should only activate if the nav is sticky!!!
		function navInView() {

			let currentItem = $( '.sticky__nav-item.is-active' );
			let winW        = $( window ).width();

			if ( winW > 799 && currentItem.length > 0 ) {
				console.log( 'Update scroll in to view' )
				currentItem[ 0 ].scrollIntoView(
					{
						behavior: 'instant',
						block: 'end',
						// inline: 'start'
					}
				);
			}
		}

		// Check nav items are in view as user scrolls.
		// $( window ).on( 'scroll', window.utils.isThrottled( navInView, 200, true ) );

		// Update nav and hash as user scrolls.
		$( window ).on( 'scroll', window.utils.isThrottled( navUpdate, 200, true ) );

		// Update Sticky on resize.
		$( window ).on( 'resize', window.utils.isThrottled( setSticky, 200, true ) );

		// Watches for change event to reload based on prefs.
		if (prefersReducedMotionSetting.addEventListener) {
			prefersReducedMotionSetting.addEventListener( 'change', getMotionMatch );
		}

		// If page loads with hash, go to it nicely after 1s.
		if ( window.location.hash ) {
			// smooth scroll to the anchor id if exists after 1s.
			if ( $( window.location.hash ).length ) {
				let theHash   = $( window.location.hash );
				let offsetNew = theHash === '#' ? 0 : theHash.offset().top - getSpacing();
				setTimeout(
					function() {
						$( 'html, body' )
						.animate(
							{
								scrollTop: offsetNew,
							},
							animationSpeed
						);
					},
					1000
				);
			}
		}

		// END.
	}
);
