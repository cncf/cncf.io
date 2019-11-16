/**
 * Handles the UI interactions with the Extraction Rules field option, for the adding
 * and removal of fields.
 * 
 * @since 2.6
 */
(function($){
	$(window).load( function(){

		var remove_btn_callback = function() {
			var input_section = $(this).parent();
			input_section.remove();
		}


		$('button.wprss-ftp-add-extraction-rule').click( function(){
			var section = $( wprss_input_field_template );
			section.find( 'input[type="text"]' ).val('');
			section.find( 'button.wprss-ftp-extraction-rule-remove' ).unbind('click').click( remove_btn_callback );
			section.insertBefore( $('#wprss-ftp-extraction-rules-end') );
		});

		$('button.wprss-ftp-extraction-rule-remove').click( remove_btn_callback );

	});
})(jQuery);