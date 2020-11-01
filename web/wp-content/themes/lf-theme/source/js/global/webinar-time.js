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
		if ( typeof( webinar_ts_start ) === 'undefined' || typeof( webinar_ts_end ) === 'undefined' ) {
			return;
		}
		var dat_start = dayjs( new Date( webinar_ts_start ) );
		var dat_end   = dayjs( new Date( webinar_ts_end ) );
		$( '.webinar-local-date-time' ).text( dat_start.format('dddd MMMM D, YYYY, h:mm') + ' - ' + dat_end.format('h:mm A Z') );
	}
);
