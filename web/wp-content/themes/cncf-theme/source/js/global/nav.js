/**
 * Navigation
 *
 * Basic mobile navigation
 *
 * @package WordPress
 * @since 1.0.0
 */

jQuery(
	function( $ ) {
		$( 'a.show-menu' ).click(
			function( e ) {
				e.preventDefault();
				$( 'body' ).toggleClass( 'menu-active' );
				$( this ).toggleClass( 'active' );
				$( '.menu-container-with-search' ).toggleClass( 'active' );
			}
		);
	}
);
