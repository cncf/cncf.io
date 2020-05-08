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
		var widget_1;var widget_2;
		var recaptcha_site_key = '6LdMldUUAAAAABG2vrZ1GT7Eo_TgI-UPlG14ocVH';

		if ( typeof PS.RECAPTCHA === 'undefined' ) {
			( function (a, $) {
				var retryTime = 300;
				var x = {
					init: function(){
						if (typeof grecaptcha != 'undefined') {

							// For Form 1 Initialization.
							if ($( '#sfmc-form1 #recaptcha-form1' ).length > 0) {
								var callbackFn = {
									action : function(){
										saveData( '1' );
									}
								}
								/*--- 'recaptcha-form-1' - reCaptcha div ID | 'form1' - Form ID ---*/
								widget_1 = x.renderInvisibleReCaptcha( 'recaptcha-form1',x.createCallbackFn( widget_1,'form1',callbackFn ) );
							}

							// For Form 2 Initialization.
							if ($( '#sfmc-form2 #recaptcha-form2' ).length > 0) {
								var callbackFn = {
									action : function(){
										saveData( '2' );
									}
								}
								/*--- 'recaptcha-form-2' - reCaptcha div ID | 'form2' - Form ID ---*/
								widget_2 = x.renderInvisibleReCaptcha( 'recaptcha-form2',x.createCallbackFn( widget_2,'form2',callbackFn ) );
							}

						} else {
							setTimeout( function(){ x.init();} , retryTime );
						}
					},
					renderInvisibleReCaptcha: function(recaptchaID,callbackFunction){
						return grecaptcha.render(
							recaptchaID,
							{
								'sitekey' 	: recaptcha_site_key,
								"theme"	: "light",
								'size'		: 'invisible',
								'badge'	: 'inline',
								'callback' 	: callbackFunction
							}
						);
					},
					createCallbackFn: function (widget,formID,callbackFn) {
						return function(token) {
							$( '#' + formID + ' .g-recaptcha-response' ).val( token );
							if ($.trim( token ) == '') {
								grecaptcha.reset( widget );
							} else {
								callbackFn.action();
							}
						}
					}
				}
				a.RECAPTCHA = x;
			})( PS, $ );
		}

		$( window ).load(
			function(){
				PS.RECAPTCHA.init();
			}
		);

		$( document ).ready(
			function () {
				var f1 = $( "#sfmc-form1" )
				f1.on(
					"click",
					"#sfmc-submit1",
					function (e) {
						if (f1[0].checkValidity()) {
							e.preventDefault();
							grecaptcha.execute( widget_1 );
						}
					}
				);
				var f2 = $( "#sfmc-form2" )
				f2.on(
					"click",
					"#sfmc-submit2",
					function (e) {
						if (f2[0].checkValidity()) {
							e.preventDefault();
							grecaptcha.execute( widget_2 );
						}
					}
				);
			}
		);

		function saveData(form){
			$.ajax(
				{
					type: 'POST',
					url:  $( "#sfmc-form" + form ).attr( 'action' ),
					data: $( "#sfmc-form" + form ).serialize(),
					beforeSend: function () {
						$( "#sfmc-form" + form ).toggle();
						$( "#sfmc-message" + form ).html( "Thank you for your submission.  Your request is being processed..." ).addClass( "callout success" );
					},
					success: function( response ) {
						var msg = $( response ).find( "p" ).text();
						$( "#sfmc-message" + form ).html( msg );
						switch (form) {
							case '1' : grecaptcha.reset( widget_1 ); break;
							case '2' : grecaptcha.reset( widget_2 ); break;
						}
					},
					error: function (xhr, status, error) {
						var errorMessage = xhr.status + ': ' + xhr.statusText;
						$( "#sfmc-message" + form ).html( "There was an error processing your submission.  Please try again or contact us directly at info@cncf.io.<br>(" + errorMessage + ")" ).removeClass( "success" ).addClass( "alert" );
						alert( "There was an error processing your submission.  Please try again or contact us directly at info@cncf.io." );
					}
				}
			);
		}

		window.saveData = saveData;
	}
);
