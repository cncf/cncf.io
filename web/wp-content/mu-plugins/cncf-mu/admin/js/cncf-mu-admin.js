/**
 * Custom JS code for CNCF MU
 *
 * Description. (use period)
 *
 * @link   https://www.cncf.io/
 * @file   This files defines the MyClass class.
 * @author James Hunt
 * @since  1.1.0
 * @package Cncf_Mu
 */

(function( $ ) {
	'use strict';

	// alert("Hello! This is the CNCF MU page");
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

// Add media uploader
$(function() {

			// Uploading files
			var file_frame;
			var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
			var set_to_post_id = 0; // Set this

			jQuery('#upload_image_button').on('click', function( event ){

				event.preventDefault();

				// If the media frame already exists, reopen it.
				if ( file_frame ) {
					// Set the post ID to what we want
					file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
					// Open frame
					file_frame.open();
					return;
				} else {
					// Set the wp.media post id so the uploader grabs the ID we want when initialised
					wp.media.model.settings.post.id = set_to_post_id;
				}

				// Create the media frame.
				file_frame = wp.media.frames.file_frame = wp.media({
					title: 'Select a image to upload',
					button: {
						text: 'Use this image',
					},
					multiple: false	// Set to true to allow multiple files to be selected
				});

				// When an image is selected, run a callback.
				file_frame.on( 'select', function() {
					// We set multiple to false so only get one image from the uploader
					var attachment = file_frame.state().get('selection').first().toJSON();
					console.log(attachment);
					// Do something with attachment.id and/or attachment.url here
					$( '#image-preview' ).attr( 'src', attachment.url ).css( 'width', 'auto' );
					$( '#cncf-mu-header_image_id' ).val( attachment.id );

					// Restore the main post ID
					wp.media.model.settings.post.id = wp_media_post_id;
				});

					// Finally, open the modal
					file_frame.open();
			});

			jQuery('#clear_upload_image_button').on('click', function( event ){

				event.preventDefault();

				$( '#image-preview' ).attr( 'src', '' ).css( 'width', 'auto' );

				$( '#cncf-mu-header_image_id' ).val( '' );

			});

			// Restore the main ID when the add media button is pressed.
			jQuery( 'a.add_media' ).on( 'click', function() {
				wp.media.model.settings.post.id = wp_media_post_id;
			});
		});

		// add space above anchor points.
		window.addEventListener("hashchange", function () {
			window.scrollTo(window.scrollX, window.scrollY - 50);
		});

})( jQuery );
