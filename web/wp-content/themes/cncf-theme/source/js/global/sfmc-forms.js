/**
 * JS code for handling forms with recaptcha
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
		var PS = PS || {};
		let widget_1; let widget_2;
		let recaptcha_site_key = '6LdMldUUAAAAABG2vrZ1GT7Eo_TgI-UPlG14ocVH';

		if ( typeof PS.RECAPTCHA === 'undefined' ) {
			( function( a, $ ) {
				let retryTime = 300;
				var x = {
					init() {
						if ( typeof grecaptcha !== 'undefined' ) {
							// For Form 1 Initialization.
							if ( $( '#sfmc-form1 #recaptcha-form1' ).length > 0 ) {
								var callbackFn = {
									action() {
										saveData( '1' );
									},
								};
								/*--- 'recaptcha-form-1' - reCaptcha div ID | 'form1' - Form ID ---*/
								widget_1 = x.renderInvisibleReCaptcha( 'recaptcha-form1', x.createCallbackFn( widget_1, 'form1', callbackFn ) );
							}

							// For Form 2 Initialization.
							if ( $( '#sfmc-form2 #recaptcha-form2' ).length > 0 ) {
								var callbackFn = {
									action() {
										saveData( '2' );
									},
								};
								/*--- 'recaptcha-form-2' - reCaptcha div ID | 'form2' - Form ID ---*/
								widget_2 = x.renderInvisibleReCaptcha( 'recaptcha-form2', x.createCallbackFn( widget_2, 'form2', callbackFn ) );
							}
						} else {
							setTimeout(
								function() {
									x.init();
								},
								retryTime
							);
						}
					},
					renderInvisibleReCaptcha( recaptchaID, callbackFunction ) {
						return grecaptcha.render(
							recaptchaID,
							{
								sitekey: recaptcha_site_key,
								theme: 'light',
								size: 'invisible',
								badge: 'inline',
								callback: callbackFunction,
							}
						);
					},
					createCallbackFn( widget, formID, callbackFn ) {
						return function( token ) {
							$( '#' + formID + ' .g-recaptcha-response' ).val( token );
							if ( $.trim( token ) == '' ) {
								grecaptcha.reset( widget );
							} else {
								callbackFn.action();
							}
						};
					},
				};
				a.RECAPTCHA = x;
			}( PS, $ ) );
		}

		$( window ).load(
			function() {
				PS.RECAPTCHA.init();
			}
		);

		$( document ).ready(
			function() {
				let f1 = $( '#sfmc-form1' );
				f1.on(
					'click',
					'#sfmc-submit1',
					function( e ) {
						if ( f1[ 0 ].checkValidity() ) {
							e.preventDefault();
							grecaptcha.execute( widget_1 );
						}
					}
				);
				let f2 = $( '#sfmc-form2' );
				f2.on(
					'click',
					'#sfmc-submit2',
					function( e ) {
						if ( f2[ 0 ].checkValidity() ) {
							e.preventDefault();
							grecaptcha.execute( widget_2 );
						}
					}
				);
			}
		);

		function saveData( form ) {
			var message = document.getElementById( "sfmc-message" + form );
			$.ajax(
				{
					type: 'POST',
					url: $( '#sfmc-form' + form ).attr( 'action' ),
					data: $( '#sfmc-form' + form ).serialize(),
					beforeSend() {
						$( '#sfmc-form' + form ).toggle();
						$( '#sfmc-message' + form ).html( 'Thank you for your submission. Your request is being processed...' ).addClass( 'is-active' );
						message.scrollIntoView( { behavior: "smooth", block: 'center' } );
					},
					success( response ) {
						let msg = $( response ).find( 'p' ).text();
						$( '#sfmc-message' + form ).html( msg ).addClass( 'success' );
						message.scrollIntoView( { behavior: "smooth", block: 'center' } );
						switch ( form ) {
							case '1' : grecaptcha.reset( widget_1 ); break;
							case '2' : grecaptcha.reset( widget_2 ); break;
						}
					},
					error( xhr, status, error ) {
						let errorMessage = xhr.status + ': ' + xhr.statusText;
						$( '#sfmc-message' + form ).html( 'There was an error processing your submission. Please try again or contact us directly at info@cncf.io<br>Error code: (' + errorMessage + ')' ).addClass( 'error' );
						message.scrollIntoView( { behavior: "smooth", block: 'center' } );
					},
				}
			);
		}
		window.saveData = saveData;
	}
);
