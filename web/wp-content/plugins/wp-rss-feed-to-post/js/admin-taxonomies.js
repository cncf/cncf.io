(function($){

	var table = null;
	var post_type_selector = null;

	$(document).ready( function(){
		// Settings page table fix
		$('#wprss-ftp-taxonomy-table-container').prev().remove();

		initTaxSections();

		var in_settings = $(document.body).hasClass('wprss_feed_page_wprss-aggregator-settings');
		post_type_selector = $( in_settings? '#ftp-post-type' : '#wprss_ftp_post_type' );
		table = $( in_settings? '#wprss-ftp-taxonomy-table' : '#wprss-ftp-taxonomy-metabox table' );

		/**
		 * Initialize the Add button click handler
		 */
		$('#ftp-add-taxonomy').click( function(){
			var _this = $(this);
			var originalText = $(this).html();
			$(this).html('<i class="fa fa-fw fa-refresh fa-spin"></i> ' + wprss_ftp_taxonomy_js.please_wait).prop('disabled', true);
			var post_type = post_type_selector.val();
			var id = table.find('.ftp-taxonomy-section').length;
			$.post(
				ajaxurl,
				{
					action: 'new_taxonomy_section',
					post_type: post_type,
					id: id
				},
				function( response ) {
					var tr = $(response);
					tr.css('visibility','hidden');
					tr.insertBefore( $('#wprss-ftp-taxonomies-add-section') );
					initTaxSections( tr );
					tr.hide().css('visibility','visible').fadeIn(300);
					_this.html(originalText).prop('disabled', false);
				}
			);
		});
		
		/**
		 * When the Post Type selector changes its value, the taxonomies options must change to show
		 * the taxonomies for that post type.
		 */
		post_type_selector.change( function(){
			var post_type = $(this).val();
			var post_id = $('#wprss-ftp-post-id').attr('data-post-id');
			$('.ftp-taxonomy-section').remove();
			var add_button = $('#ftp-add-taxonomy');
			var originalText = add_button.html();
			add_button.html('<i class="fa fa-fw fa-refresh fa-spin"></i> ' + wprss_ftp_taxonomy_js.please_wait).prop('disabled', true);
			$.post(
				ajaxurl,
				{
					action: 'wprss_taxonomies',
					post_id: post_id,
					post_type: post_type,
				},
				function( response ) {
					$(response).insertBefore( $('#wprss-ftp-taxonomies-add-section') );
					add_button.html(originalText);
					// If response is not the "no taxonomies found" message
					if ( $('#ftp-no-taxonomies').length == 0 ) {
						add_button.prop('disabled', false);
						initTaxSections();
					}
				}
			);
		});

	}); // End of document on ready event handler


	/**
	 * Initializes all, or one particular, taxonomy section.
	 */
	function initTaxSections( tr ) {
		initChosens( tr );
		initSectionButtons( tr );
		initEditLink( tr );
	}

	/**
	 * Initializes the edit link for all, or one particular, taxonomy section.
	 */
	function initEditLink( tr ) {
		var target = typeof tr === 'undefined' ? $('a.ftp-edit-tax') : tr.find('.ftp-edit-tax');
		target.each( function(){
			var id = $(this).parent().parent().data('id');
			// Get the selected tax id and anme
			var taxonomy_dropdown = $('#ftp-taxonomy-'+id);
			var tax_id = taxonomy_dropdown.val();
			var tax_name = taxonomy_dropdown.find(':selected').text();
			// Set the link href attr and child span text
			$(this).attr('href', $(this).data('base-url') + tax_id );
			$(this).find('span').text( tax_name );
		});
	}

	/**
	 * Initiaizes the Chosen dropdown elements
	 */
	function initChosens( tr ) {
		var term_selectors = tr ? tr.find('.ftp-terms') : $('.ftp-terms');
		term_selectors.chosen({
			no_results_text: wprss_ftp_taxonomy_js.no_matched_terms,
			placeholder_text_multiple: wprss_ftp_taxonomy_js.choose_terms
		});
		
		var taxonomy_selectors = tr ? tr.find('.ftp-taxonomy') : $('.ftp-taxonomy');
		// Set the texts
		taxonomy_selectors.chosen({
			no_results_text: wprss_ftp_taxonomy_js.no_matched_tax,
			placeholder_text_single: wprss_ftp_taxonomy_js.choose_tax
		})
		// Set the change handlers
		.chosen({ width: "100%" }).unbind('change').change( function(){
			var tr = $(this).parent().parent();
			var id = tr.data('id');
			update_terms_for_section( id );
			initEditLink( tr );
		});

		var filter_subject_selectors = tr ? tr.find('.ftp-tax-filter-subject') : $('.ftp-tax-filter-subject');
		filter_subject_selectors.chosen({
			no_results_text: wprss_ftp_taxonomy_js.no_matched_field,
			placeholder_text_multiple: wprss_ftp_taxonomy_js.choose_field,
			width: '100%'
		});


	}

	/**
	 * Initialize the buttons with click handlers
	 */
	function initSectionButtons( tr ) {
		var parent = typeof tr === 'undefined' ? document : tr;
		$(parent).find('.ftp-tax-section-remove').unbind('click').click( function(){
			$(this).parents('.ftp-taxonomy-section').remove();
		});
		$(parent).find('.ftp-tax-section-refresh').unbind('click').click( function(){
			var id = $(this).data('id');
			update_terms_for_section( id );
		});
	};


	/**
	 * Updates a section's terms, depending on the selected taxonomy for that section.
	 */
	function update_terms_for_section(id, callback){
		var tax_dropdown = $('#ftp-taxonomy-'+id)
		var terms_dropdown = $('#ftp-terms-'+id);
		var taxonomy = tax_dropdown.val();
		terms_dropdown.prop('disabled', true);
		terms_dropdown.trigger("chosen:updated");
		var noTermsMsg = $('tr[data-id="'+id+'"] span.ftp-tax-no-terms');
		noTermsMsg.addClass('disabled');
		$.post(
			ajaxurl,
			{
				action: 'wprss_terms',
				taxonomy: taxonomy,
				entry_id: id,
				post_id: $('#wprss-ftp-post-id').attr('data-post-id'),
				post_type: post_type_selector.val(),
				selected: terms_dropdown.val()
			},
			function( response ) {
				var html = $(response);
				noTermsMsg.remove();
				if ( html.is('span.ftp-tax-no-terms') ) {
					html.insertBefore( terms_dropdown );
					terms_dropdown.next().hide();
				}
				else {
					terms_dropdown.next().show();
					terms_dropdown.empty().html( response );
					terms_dropdown.prop('disabled', false);
					terms_dropdown.trigger("chosen:updated");
				}
				
				if ( callback !== null && typeof callback !== 'undefined' ) {
					callback( response );
				}
			}
		);
	}
		
})(jQuery);