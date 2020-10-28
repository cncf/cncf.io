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
        if ( ! webinar_ts_start || ! webinar_ts_end ) {
            return;
        }
        var dat_start = new Date( webinar_ts_start );
        var dat_end = new Date( webinar_ts_end );
        $('.webinar-local-date-time').text( dat_start.toString() );
    }
);
