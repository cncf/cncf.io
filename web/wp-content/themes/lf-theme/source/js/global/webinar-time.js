/**
 * Webinar Time-related Stuff
 *
 * Shows the user's local time for the webinar
 *
 * @package WordPress
 * @since 1.0.0
 */

jQuery( document ).ready(
	function( $ ) {
		if ( typeof( webinar_ts_start ) === 'undefined' || typeof( webinar_ts_end ) === 'undefined' ) {
			return;
		}
		var dat_start = new Date( webinar_ts_start );
		var dat_end = new Date( webinar_ts_end );
		$( '.webinar-local-date-time' ).text( dat_start.toString() );

		var myCalendar = createCalendar({
			options: {
			class: 'my-class',
			id: 'my-id'                               // You need to pass an ID. If you don't, one will be generated for you.
			},
			data: {
			title: webinar_title,     // Event title
			start: dat_start,   // Event start date
			end: dat_end,     // You can also choose to set an end time.
			}
		});

		document.querySelector('.webinar-add-to-cal').appendChild(myCalendar);
	}
);
