(function($){

	// CUSTOM MAPPINGS option handling (Feed Source Meta)
	$(window).load( function(){
		// The mapping marker - where to add new mappings
		var marker = $('#wprss-ftp-custom-fields-marker');

		// The remove mapping button click function 
		var remove_mapping_action = function() {
			$(this).parent().remove();
		};

		// Add the click action to the 'Add Mapping' button
		$('#wprss-ftp-add-custom-mapping').click( function() {
			// Create the section div
			var section = $('<div>').addClass( wprss_ftp_custom_mappings_section_class );
			// Create the fields
			var namespace_dropdown = $(wprss_ftp_namespaces_dropdown).appendTo( section );
			var rss_tag_field = $(wprss_ftp_rss_tag_field).val('').appendTo( section );
			var custom_field = $(wprss_ftp_custom_field_field).val('').appendTo( section );
			// Create the remove btn
			var remove_btn = $(wprss_ftp_remove_custom_mapping).appendTo( section ).click( remove_mapping_action );

			// Add the section before the marker
			section.insertBefore( marker );
		});

		$('.wprss-ftp-remove-custom-mapping').click( remove_mapping_action );




		/* NAMESPACE AUTO DETECTOR */
		$('#wprss-ftp-namespace-detector-refresh').click( function() {
			// Get the URL from the URL fields
			var url = $('#wprss_url').val().trim();

			// If a URL has been entered
			if ( url !== '' ) {

				$('#wprss-ftp-namespace-detector-results').text(wprss_ftp_custom_mappings_scripts.please_wait);

				// SEND AJAX POST DATA
				$.ajax({
					url: ajaxurl,
					type: 'POST',
					data: {
						action: 'ftp_detect_namespaces',
						feed_source: url,
					},
					// When AJAX is complete
					complete: function( jqXHR, status ) {
						// Get the response text
						var data = jqXHR.responseText;
						// Attempt to parse as JSON
						try {
							// Parse JSON
    						var obj = JSON && JSON.parse(data) || $.parseJSON(data);
    						// Empty the results container
    						$('#wprss-ftp-namespace-detector-results').empty();
    						// Create an <ol> in the results container
    						var list = $('<ul>').appendTo( $('#wprss-ftp-namespace-detector-results') );
    						// Add an <li> for each namespace in the parsed JSON
    						for( i in obj ) {
    							$('<li><i class="fa fa-check"></i> ' + wprss_ftp_custom_mappings_scripts.namespace + ' <code>'+i+
    								'</code> ' + wprss_ftp_custom_mappings_scripts.with_url + ': <code>'+obj[i]+'</code></li>').appendTo( list );
    						}
    					}
    					// If failed to parse JSON, then the repsonse is an error message. Print it in the results container
    					catch (e) {
    						$('#wprss-ftp-namespace-detector-results').text( data );
    					}
					},
					dataType: 'json'
				});

			}
			// Else, if not URL has been entered
			else {
				$('#wprss-ftp-namespace-detector-results').text(wprss_ftp_custom_mappings_scripts.specify_feed_url);
			}
		});
	});
	
})(jQuery);