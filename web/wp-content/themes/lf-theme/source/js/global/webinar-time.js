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
			title: 'Get on the front page of HN',     // Event title
			start: new Date('June 15, 2013 19:00'),   // Event start date
			duration: 120,                            // Event duration (IN MINUTES)
			end: new Date('June 15, 2013 23:00'),     // You can also choose to set an end time.
														// If an end time is set, this will take precedence over duration
			address: 'The internet',
			description: 'Get on the front page of HN, then prepare for world domination.'
			}
		});

		document.querySelector('.new-cal').appendChild(myCalendar);
	}
);
