/**
 * Menu / Navigation
 *
 * @package WordPress
 * @since 1.0.0
 */

// phpcs:disable PEAR.Functions.FunctionCallSignature.Indent
// phpcs:disable Generic.Formatting.MultipleStatementAlignment.NotSameWarning

// =include ../libraries/hoverintent.min.js

( function () {
	document.addEventListener(
		'DOMContentLoaded',
		function () {
			/**
			 * Slideup
			 *
			 * @param {*} target   Element
			 * @param {*} duration Time in ms
			 * @return {void}
			 */
			const slideUp = ( target,duration = 500 ) => {
				target.style.transitionProperty = 'height, margin, padding';
				target.style.transitionDuration = duration + 'ms';
				target.style.boxSizing = 'border-box';
				target.style.height = target.offsetHeight + 'px';
				target.offsetHeight;
				target.style.overflow = 'hidden';
				target.style.height = 0;
				target.style.paddingTop = 0;
				target.style.paddingBottom = 0;
				target.style.marginTop = 0;
				target.style.marginBottom = 0;
				window.setTimeout(
					() => {
						target.style.display = 'none';
						target.style.removeProperty( 'height' );
						target.style.removeProperty( 'padding-top' );
						target.style.removeProperty( 'padding-bottom' );
						target.style.removeProperty( 'margin-top' );
						target.style.removeProperty( 'margin-bottom' );
						target.style.removeProperty( 'overflow' );
						target.style.removeProperty( 'transition-duration' );
						target.style.removeProperty( 'transition-property' );
					},
					duration
				);
			};
			/**
			 * Slide Down
			 *
			 * @param {*} target   Element.
			 * @param {*} duration Time in ms.
			 * @return {void}
			 */
			const slideDown = ( target,duration = 500 ) => {
				target.style.removeProperty( 'display' );
				let display = window.getComputedStyle( target ).display;
				if ( display === 'none' ) {
					display = 'block';
				}
				target.style.display = display;
				const height = target.offsetHeight;
				target.style.overflow = 'hidden';
				target.style.height = 0;
				target.style.paddingTop = 0;
				target.style.paddingBottom = 0;
				target.style.marginTop = 0;
				target.style.marginBottom = 0;
				target.offsetHeight;
				target.style.boxSizing = 'border-box';
				target.style.transitionProperty = 'height, margin, padding';
				target.style.transitionDuration = duration + 'ms';
				target.style.height = height + 'px';
				target.style.removeProperty( 'padding-top' );
				target.style.removeProperty( 'padding-bottom' );
				target.style.removeProperty( 'margin-top' );
				target.style.removeProperty( 'margin-bottom' );
				window.setTimeout(
					() => {
						target.style.removeProperty( 'height' );
						target.style.removeProperty( 'overflow' );
						target.style.removeProperty( 'transition-duration' );
						target.style.removeProperty( 'transition-property' );
					},
					duration,
				);
			};

			/**
			 * Toggle Slide
			 *
			 * @param {*} target   Element
			 * @param {*} duration Time in ms
			 * @return {Function} Slide toggle.
			 */
			const slideToggle = ( target,duration = 500 ) => {
				if ( window.getComputedStyle( target ).display === 'none' ) {
					return slideDown( target,duration );
				}
				return slideUp( target,duration );
			};

			const isMobile = function() {
				return window.innerWidth < 1000;
			}

			// Run on load.
			isMobile();

			// Resize check for is mobile.
			window.addEventListener( 'resize', window.utils.isThrottled( isMobile, 200, true ) );

			const searchButtons = document.querySelectorAll( '.search-toggle' );

			const searchBar = document.querySelector( '.header__search_wrapper' );

			const searchInput = document.querySelector( '.header .search-input' );

			// Find all search buttons and apply event listener to them to toggle is-active.
			searchButtons.forEach(
				function ( button ) {
					button.addEventListener(
						'click',
						function ( e ) {
							e.preventDefault();
							// Return if isMobile as this shouldn't do anything on mobile.
							if ( isMobile() ) {
								return;
							}
							searchBar.classList.toggle( 'is-active' );
							// put the cursor in the input field.
							searchInput.focus();
							searchInput.setSelectionRange( 98, 98 );
						},
					);
				},
			);

			const menuItems = [].slice.call( document.querySelectorAll( '.menu-item-has-children' ) );

			const menuSubs = [].slice.call( document.querySelectorAll( '.sub-menu' ) );

			let closeDropdownTimeout;

			// Start to close.
			const startCloseTimeout = function () {
				closeDropdownTimeout = setTimeout( () => closeDropdown(), 50 );
			};

			// Stop close.
			const stopCloseTimeout = function () {
				clearTimeout( closeDropdownTimeout );
			};

			const openDropdown = function ( el ) {
				// Remove active menu.
				menuItems.forEach(
					 ( item ) => {
							item.classList.remove( 'is-open' )
							item.blur();
				}
					);
				document.activeElement ? .blur();
				// Set current menu to active.
				el.classList.add( 'is-open' );
				el.focus();
			};

			const closeDropdown = function () {
				document.activeElement ? .blur();
				// Remove active class from all menu items.
				menuItems.forEach(
					 ( item ) => {
							item.classList.remove( 'is-open' );
							item.blur();
				}
					);
			};

			// HoverIntent.
			// Options: https://github.com/tristen/hoverintent.
			menuItems.forEach(
				item => {
					hoverintent(
					item,
						function () {
								stopCloseTimeout();
								openDropdown( this )
						},
					function () {
							stopCloseTimeout();
							startCloseTimeout();
					}
					).options(
							{
								sensitivity: 8,
								interval: 50,
						}
							)
					}
				);

			// Bind mouse event to each sub-menu.
			menuSubs.forEach(
				( element ) => {
					element.addEventListener( 'mouseenter',() => stopCloseTimeout(), false );
					element.addEventListener( 'mouseleave',() => startCloseTimeout(), false );
				},
			);

			// Let Escape key close the menu.
			document.addEventListener(
				'keydown',
				function(e) {
					// Target escape Key.
					if (e.keyCode == 27) {
						startCloseTimeout()
					}
				}
			);

			const hamburger = document.querySelector( '.hamburger' );

			const mainMenu = document.querySelector( '.main-menu' );

			// Hamburger - Mobile only.
			hamburger.addEventListener(
				'click',
				function ( e ) {
					e.preventDefault();
					if ( ! isMobile() ) {
						return;
					}
					hamburger.classList.toggle( 'is-active' );
					mainMenu.classList.toggle( 'is-active' );
					document.body.classList.toggle( 'has-menu-active' );
				},
			);

			// Select the titles that activate sub-menus on mobile.
			const menuHeadings = document.querySelectorAll( '.menu-item-has-children > a' );

			// Set default animation speed in ms.
			let animationSpeed = 1250;

			// Get matchMedia setting.
			let prefersReducedMotionSetting = window.matchMedia( '(prefers-reduced-motion)' );
			let prefersReducedMotionQuery = window.matchMedia( '(prefers-reduced-motion: reduce)' );
			let prefersReducedMotion = ! prefersReducedMotionQuery || prefersReducedMotionQuery.matches;

			/**
			 * Sets animation speed based on preferences.
			 */
			function getMotionMatch() {
				if (prefersReducedMotion) {
					animationSpeed = 0
				} else {
					animationSpeed = 1250
				}
			}
			// Watches for change event to reload based on prefs.
			if (prefersReducedMotionSetting.addEventListener) {
				prefersReducedMotionSetting.addEventListener( 'change', getMotionMatch );
			}
			// runs on first load.
			getMotionMatch();

			menuHeadings.forEach(
				function ( heading ) {
					heading.addEventListener(
						'click',
						function ( e ) {
							e.preventDefault();
							if ( isMobile() ) {
								heading.classList.toggle( 'is-open' );
								const subMenu = heading.nextElementSibling;
								slideToggle( subMenu, animationSpeed );
							} else {
								// Stop empty menu parents jumping to top of screen on click.
								if ( heading.getAttribute( 'href' ) === '#' ) {
									e.preventDefault();
								}
							}
						},
					);
				},
			);
			// end.
		},
	);
}() );
