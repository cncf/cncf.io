/**
 * Go to Top
 *
 * Smoothyl scroll user to top of page
 *
 * @since  1.0.0
 */

jQuery(
	function( $ ) {
		$( "a[href='#top']" ).click(
			function() {
				$( 'html, body' ).animate( { scrollTop: 0 }, 'slow' );
				return false;
			}
		);
	}
);
