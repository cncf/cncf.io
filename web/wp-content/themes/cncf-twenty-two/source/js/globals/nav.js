/**
 * Menu / Navigation
 *
 * @package WordPress
 * @since 1.0.0
 */

// phpcs:disable PEAR.Functions.FunctionCallSignature.Indent
// phpcs:disable Generic.Formatting.MultipleStatementAlignment.NotSameWarning

( function () {
	document.addEventListener(
		'DOMContentLoaded',
		function () {
			// TODO: Refactor and neaten.
			/**
			 * Throttle.
			 *
			 * @param {*} callback Function name
			 * @param {*} limit    Time to wait.
			 * @return {Function} Callback.
			 */
			function throttle( callback,limit ) {
				let wait = false;
				return function () {
					if ( ! wait ) {
						callback.call();
						wait = true;
						setTimeout(
							function () {
								wait = false;
							},
							limit,
						);
					}
				};
			}

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

			// TODO: Integrate isMobile check.
			let isMobile = checkMobile();

			function checkMobile() {
				return window.innerWidth < 1000;
			}

			// Resize check for is mobile.
			// TODO: Move Throttle as global?
			window.addEventListener(
				'resize',
				throttle(
					function () {
						isMobile = checkMobile();
					},
					100,
				),
			);

			const hamburger = document.querySelector( '.hamburger' );

			const mainMenu = document.querySelector( '.main-menu' );

			if ( ! hamburger && ! mainMenu ) {
				return;
			}

			const searchButtons = document.querySelectorAll( '.search-toggle' );

			const searchBar = document.querySelector( '.header__search_wrapper' );

			searchButtons.forEach(
				function ( button ) {
					button.addEventListener(
						'click',
						function ( e ) {
							e.preventDefault();
							if ( isMobile ) {
								return;
							}
							searchBar.classList.toggle( 'is-active' );
						},
					);
				},
			);

			const menuItems = [].slice.call( document.querySelectorAll( '.menu-item-has-children' ) );

			const menuSubs = [].slice.call( document.querySelectorAll( '.sub-menu' ) );

			let closeDropdownTimeout;

			const startCloseTimeout = function () {
				closeDropdownTimeout = setTimeout( () => closeDropdown(),50 );
			};

			const stopCloseTimeout = function () {
				clearTimeout( closeDropdownTimeout );
			};

			// TODO: Use hoverintent.
			// https://github.com/svivian/sv-hover-intent-js .
			const openDropdown = function ( el ) {
				// Remove active menu.
				menuItems.forEach( ( items ) => items.classList.remove( 'is-open' ) );
				// Set current menu to active.
				el.classList.add( 'is-open' );
			};

			const closeDropdown = function () {
				// Remove active class from all menu items.
				menuItems.forEach( ( items ) => items.classList.remove( 'is-open' ) );
			};

			// Bind mouse event to each menu item.
			menuItems.forEach(
				( el ) => {
					// Mouse enter event.
					el.addEventListener(
						'mouseenter',
						function () {
							stopCloseTimeout();
							openDropdown( this );
						},
						false,
					);
					// Mouse leave event.
					el.addEventListener( 'mouseleave',() => startCloseTimeout(),false );
				},
			);

			// Bind mouse event to each sub-menu.
			menuSubs.forEach(
				( el ) => {
					el.addEventListener( 'mouseenter',() => stopCloseTimeout(),false );
					el.addEventListener( 'mouseleave',() => startCloseTimeout(),false );
				},
			);

			hamburger.addEventListener(
				'click',
				function ( e ) {
					e.preventDefault();
					if ( ! isMobile ) {
						return;
					}
					hamburger.classList.toggle( 'is-active' );
					mainMenu.classList.toggle( 'is-active' );
					document.body.classList.toggle( 'has-menu-active' );
				},
			);

			const menuHeadings = document.querySelectorAll( '.menu-item-has-children > a' );

			menuHeadings.forEach(
				function ( heading ) {
					heading.addEventListener(
						'click',
						function ( e ) {
							e.preventDefault();
							if ( isMobile ) {
								// TODO: Add will-change?
								heading.classList.toggle( 'is-open' );
								const subMenu = heading.nextElementSibling;
								slideToggle( subMenu,1000 );
							} else if ( heading.getAttribute( 'href' ) === '#' ) {
								e.preventDefault();
							}
						},
					);
				},
			);
			// end.
		},
	);
}() );
