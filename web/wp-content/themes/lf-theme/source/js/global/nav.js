/**
 * Navigation
 *
 * @package WordPress
 * @since 1.0.0
 */

 // phpcs:ignoreFile.

jQuery( document ).ready(
	($) => {
		// Mobile Menu (hidden on desktop).
			$( '.hamburger' ).click(
				function (e) {
					e.preventDefault();
					$( 'body' ).toggleClass( 'menu-is-active' );
					$( this ).toggleClass( 'is-active' );
					$( '.menu-container-with-search' ).toggleClass( 'is-active' );
				},
			);
	// Desktop Search (hidden on mobile).
	$( '.search-button' ).click(
		(e) => {
			e.preventDefault();
			$( '.search-bar' ).toggleClass( 'is-active' );
			$( '.search-input' ).focus();
		},
	);
	// Mobile toggle to open menus on touch.
	if ($( window ).width() < 1000) {
		$( 'li.menu-item-has-children > a' ).click(
			function (e) {
				e.preventDefault();
				$( this ).toggleClass( 'is-open' );
				$( this ).parent().children( '.sub-menu:first' ).slideToggle( 500 );
			},
		);
	} else {
		// Desktop - Stop empty menu parents jumping to top of screen on click.
		$( '.main-navigation li.menu-item-has-children a' ).click(
			function (e) {
				if ($( this ).attr( 'href' ) === '#') {
					  e.preventDefault();
				}
			},
		);
	}

	 // Keep menu inside viewport.
	$( '.sub-menu li.menu-item-has-children' ).on(
		'mouseenter mouseleave',
		function () {
			if ($( 'ul', this ).length) {
				const ul = $( 'ul:first', this ); // pick first ul after el.
				const r = this.getBoundingClientRect().right; // menu from the edge of screen.
				const w = ul.width(); // menu element size.
				const docW = $( '.site-header' ).width(); // size of header / screen.
				const docWidthPadding = docW - 5; // padding value from edge of screen.

				const isOutsideWidth = ((r + w) >= docWidthPadding);

				if (isOutsideWidth) {
					$( this ).addClass( 'is-off-right-edge' );
				} else {
					$( this ).removeClass( 'is-off-right-edge' );
				}

				// height.
				const position = $( this ).position();
				const t = position.top;
				const h = ul.height();
				const docH = window.innerHeight;
				const outsideHeight = (t + h + 100 <= docH);

				if ( ! outsideHeight) {
					// compare half height again plus buffer.
					if ((h / 2 + h + 100) >= docH) {
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
	},
);
