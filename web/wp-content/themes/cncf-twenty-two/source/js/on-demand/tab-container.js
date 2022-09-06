/**
 * Tab Container JS
 *
 * @package WordPress
 * @since 1.0.0
 */

jQuery( document ).ready(
	function( $ ) {

		// Get all the links in the sticky nav.
		let menuItems = $( '.sticky__nav' ).find( 'a' );
		// Set disableScroll.
		let disableScroll = false;
		// Set default animation speed.
		let animationSpeed = 500;
		// Get matchMedia setting.
		let prefersReducedMotionSetting = window.matchMedia( '(prefers-reduced-motion)' );
		let prefersReducedMotionQuery   = window.matchMedia( '(prefers-reduced-motion: reduce)' );
		let prefersReducedMotion        = ! prefersReducedMotionQuery || prefersReducedMotionQuery.matches;

		if ( $( '.sticky__nav' ).length == 0 ) {
			return;
		}

		/**
		* Sticky Menu.
		*/
		let setSticky;
		( setSticky = function() {
			sticky = new Sticky(
				'.sticky__element',
				{
					marginTop: getSpacing(),
					marginBottom: 0,
					stickyFor: 800,
				}
			);
		} )();

		/**
		 * Set Animation Speed based on Prefers Motion.
		 */
		function getAnimationSpeed() {
			if (prefersReducedMotion) {
				animationSpeed = 0
			} else {
				animationSpeed = 500
			}
		}
		getAnimationSpeed();

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
				spacingTotal += 100;
			} else {
				spacingTotal += 140;
			}
			if ( adminBar.length > 0 ) {
				spacingTotal += 32;
			}
			return spacingTotal;
		}

		/**
		 * Use menu items to confirm matching page sections.
		 */
		let pageSections = menuItems.map(
			function() {
				let item = $( $( this ).attr( 'href' ) );
				if ( item.length ) {
					return item;
				}
			}
		);

			/**
			 * Watch clicks to scroll smoothly to each.
			 */
		menuItems.click(
			function( e ) {
				e.preventDefault();
				disableScroll = true;
				let hash      = $( this ).attr( 'href' );
				let offsetTop = hash === '#' ? 0 : $( hash ).offset().top - getSpacing();
				$( 'html, body' )
				.stop()
				.animate(
					{
						scrollTop: offsetTop,
					},
					animationSpeed,
					function() {
						removeIsActiveFromMenu();
						$( '.sticky__nav a[href="#' + $( hash ).attr( 'id' ) + '"]' ).parent().addClass( 'is-active' );
						setHash( $( hash ) );
						disableScroll = false;
					}
				);
			}
		);

		/**
		 * Remove Is Active Class from all items in menu.
		 */
		function removeIsActiveFromMenu(){
			menuItems.parent().removeClass( 'is-active' );
		}

		/**
		 * Update the menu as the page scrolls.
		 */
		function navUpdate() {
			if (disableScroll == true) {
				return;
			}
			let fromTop    = $( this ).scrollTop();
			let headerSize = getSpacing();
			// Get all the page sections passed by scrolling.
			let currentItemElements = pageSections.map(
				function() {
					// If true, return the section name(s).
					if ( $( this ).offset().top < fromTop + headerSize ) {
						return this;
					}
				}
			);

			// Get the ID of the last section seen.
			let currentItemId = currentItemElements[ currentItemElements.length - 1 ];

			// if neither exist we're outside sections so removeHash.
			if (currentItemElements.length == 0 && ! currentItemId ) {
				removeHash();
				removeIsActiveFromMenu();
			}

			if ( ! currentItemId ) {
				return;
			}

			// Get the precise anchor ID to use.
			let id = currentItemId && currentItemId.length ? currentItemId[ 0 ].id : '';

			if ( id  ) {
				removeIsActiveFromMenu();
				menuItems.filter( "[href='#" + id + "']" )
				.parent()
				.addClass( 'is-active' )
				makeNavInView();
				setHash( currentItemId );

			}
		}

		/**
		 * Sets the URL hash
		 *
		 * @param {object} object
		 * @returns
		 */
		function setHash(object){
			let id = object && object.length ? object[ 0 ].id : '';

			// if no id, or the current hash is the same as the id, do nothing.
			if ( ! id || '#' + id === window.location.hash ) {
				return;
			}

			// Set hash.
			if ( history.pushState ) {
				window.history.replaceState(
					null,
					null,
					'#' + id
				);
			} else {
				// For older browsers, IE9, IE8, etc.
				window.location.hash = '#!' + id;
			}
		}

		/**
		 * Removes the URL hash.
		 */
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

		/**
		 * Make the navigation scroll in to view.
		 */
		function makeNavInView() {
			let currentItem = $( '.sticky__nav-item.is-active' );
			let winW        = $( window ).width();
			if ( winW > 799 && currentItem.length > 0 ) {
				currentItem[ 0 ].scrollIntoView(
					{
						block: 'center',
					}
				);
			}
		}

		/**
		 * Update nav and hash as user scrolls.
		 */
		$( window ).on( 'scroll', window.utils.isThrottled( navUpdate, 200, true ) );

		/**
		 * Update Sticky on resize.
		 */
		$( window ).on( 'resize', window.utils.isThrottled( setSticky, 250, true ) );

		/**
		 * Watches for change event to reload based on prefs.
		 */
		if (prefersReducedMotionSetting.addEventListener) {
			prefersReducedMotionSetting.addEventListener( 'change', getAnimationSpeed );
		}

		/**
		 * If page loads with hash, go to it nicely after 1s.
		 */
		if ( window.location.hash ) {
			if ( $( window.location.hash ).length ) {
				disableScroll           = true;
				let originalHash        = window.location.hash;
				let matchingHashElement = $( window.location.hash );
				let offsetNew           = matchingHashElement === '#' ? 0 : matchingHashElement.offset().top - getSpacing();
				setTimeout(
					function() {
						$( 'html, body' )
						.stop()
						.animate(
							{
								scrollTop: offsetNew,
							},
							animationSpeed,
							function() {
								removeIsActiveFromMenu();
								$( '.sticky__nav a[href="#' + $( originalHash ).attr( 'id' ) + '"]' ).parent().addClass( 'is-active' );
								makeNavInView();
								disableScroll = false;
							}
						);
					},
					1000
				);
			}
		}

		// END.
	}
);
