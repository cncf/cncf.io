/**
 * JS code to run only on pages that use a SFMC form.
 *
 * @package WordPress
 */

/**
 * Callback for form submission.
 *
 * @param {*} token callback token.
 */
jQuery(
	function( $ ) {
		function onSubmit(token) {
			var f = $( "#sfmc-form" );
			var redirectUrl = f.data( 'redirect' );
			$.ajax(
				{
					url: f.attr( "action" ),
					type: 'POST',
					data: f.serialize(),
					beforeSend: function () {
						$( "#sfmc-form" ).toggle();
						$( "#message" ).html( "Thank you for your submission.  Your request is being processed..." ).addClass( "callout success" );
					},
					success: function (data) {
						var msg = $( data ).find( "p" ).text();
						$( "#message" ).html( msg );
						if (redirectUrl) {
							window.location.href = redirectUrl;
						}
					},
					error: function (xhr, status, error) {
						var errorMessage = xhr.status + ': ' + xhr.statusText;
						$( "#message" ).html( "There was an error processing your submission.  Please try again or contact us directly at info@cncf.io.<br>(" + errorMessage + ")" ).removeClass( "success" ).addClass( "alert" );
						alert( "There was an error processing your submission.  Please try again or contact us directly at info@cncf.io." );
					}
				}
			);
		}
		window.onSubmit = onSubmit; // need to do this to export the onSubmit function from the module scope created by WebPack.

		$( document ).ready(
			function () {
				var f = $( "#sfmc-form" )
				f.on(
					"click",
					"#submitbtn",
					function (e) {
						if (f[0].checkValidity()) {
							e.preventDefault();
							grecaptcha.execute();
						}
					}
				);
			}
		);
	}
);
