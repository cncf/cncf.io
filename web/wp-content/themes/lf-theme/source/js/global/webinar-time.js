/**
 * Webinar Time-related Stuff
 *
 * Shows the user's local time for the webinar.
 *
 * @package WordPress
 * @since 1.0.0
 */

jQuery( document ).ready(
	function( $ ) {
		if ( typeof( webinar_ts_start ) === 'undefined' ) {
			return;
		}
		var dat_start = new Date( webinar_ts_start );
		$( '.webinar-local-date-time' ).text( dat_start.toString() );
	}
);
