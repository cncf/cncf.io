/**
 * Summary. (use period)
 *
 * Description. (use period)
 *
 * @link   URL
 * @file   This files defines the MyClass class.
 * @author AuthorName.
 * @since  x.x.x
 * @package xxx
 */

(function( $ ) {
	'use strict';

	alert("Hello! This is the CNCF MU page");
	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

// Add Color Picker to all inputs that have 'color-field' class.
	$(function() {
	$('.color_field').wpColorPicker({
		defaultColor: true,
		palettes: ['#DE176C', '#444444',
			'#000000', '#436ca9', '#416FD9',
			'#252b5f', '#111111', '#48549C'
		]
	});
});

})( jQuery );
