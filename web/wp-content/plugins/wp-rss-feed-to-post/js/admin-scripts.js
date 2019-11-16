jQuery(document).ready( function($) {

	metabox_terms_ajax_update = function() {
		tax = ( $('#wprss_ftp_post_taxonomy').is('select') )? $('#wprss_ftp_post_taxonomy').val() : '';
		$('#wprss_ftp_post_terms').parent().html('<p id="wprss_ftp_post_terms">' + wprss_ftp_admin_scripts.loading_taxonomies + '</p>');
		$.ajax({
			url: ajaxurl,
			type: 'POST',
			data: {
				action: 'ftp_get_taxonomy_terms',
				taxonomy: tax,
				post_id: $('#wprss-ftp-post-id').attr('data-post-id'),
				source: 'meta'
			},
			complete: function( jqXHR, status ) {
				data = jqXHR.responseText;
				// Update the element with the data recieved from server
				$('#wprss_ftp_post_terms').parent().html( data );
			},
			dataType: 'json'
		});
	};
	$('select#wprss_ftp_post_terms').on( 'change', metabox_terms_ajax_update );


	var post_type_label = $('td label[for="wprss_ftp_post_type"] span');
	var post_type_dropdown = $('#wprss_ftp_post_type');
	var original_post_type_label = post_type_label.text();

	var isPostTypeFeedItem = function () {
		return post_type_dropdown.val() === 'wprss_feed_item';
	};

	var updatePageForFeedItems = function () {
		var opts = [
			$('#wprss_ftp_post_format'),
			$('#wprss_ftp_post_status'),
			$('#wprss_ftp_comment_status'),
			$('#wprss_ftp_canonical_link'),
			$('#wprss_ftp_post_date'),
			$('#wprss_ftp_force_full_content'),
			$('#wprss_ftp_import_excerpt'),
			$('#wprss_ftp_allow_embedded_content'),
		];
		var boxes = [
			$('#postimagediv'),
			$('#wprss-ftp-images-metabox'),
			$('#wprss-ftp-taxonomy-metabox'),
			$('#wprss-ftp-author-metabox'),
			$('#wprss-ftp-wysiwyg-editor'),
			$('#wprss-ftp-prepend-metabox'),
			$('#wprss-ftp-append-metabox'),
			$('#wprss-ftp-extraction-metabox'),
			$('#wprss-ftp-custom-fields-metabox'),
			$('#wprss-ftp-integrations-metabox'),
			$('#wprss-ftp-word-trimming-metabox'),
			$('#wprss-ftp-url-shortening-metabox'),
		];

		var isFeedItem = isPostTypeFeedItem();

		for (var i in opts) {
			opts[i].closest('tr').toggle(!isFeedItem);
		}
		for (var j in boxes) {
			boxes[j].toggle(!isFeedItem);
		}

		if (isFeedItem) {
			post_type_label.html(wprss_ftp_admin_scripts.feed_post_type_warning);
		} else {
			post_type_label.text( original_post_type_label );
		}
	};

	post_type_dropdown.on( 'change', updatePageForFeedItems );
	updatePageForFeedItems();

	var save_images_checkbox = $('#wprss_ftp_save_images_locally');
	var save_all_sizes_row = $('#wprss_ftp_save_all_image_sizes').closest('tr');

	// Toggles the "save all image sizes" option depending on whether image importing is enabled
	var toggle_save_all_sizes_checkbox = function () {
		var save_all_images = save_images_checkbox.is(':checked');
		save_all_sizes_row.toggle(save_all_images);
	};

	save_images_checkbox.on( 'change', toggle_save_all_sizes_checkbox );
	toggle_save_all_sizes_checkbox();
});

jQuery(document).ready(function($) {
	// Word limit enabled dropdown field
	var word_limit_enabled = $( '#wprss_ftp_word_limit_enabled' );
	// The trimming type dropdown field
	var trimming_type = $('#wprss_ftp_trimming_type');
	// The ellipsis checkbox
	var ellipsis = $('#wprss_ftp_trimming_ellipsis');
	// The <tr> rows
	var rows = $('#wprss-ftp-word-trimming-metabox .wprss-form-table tbody tr');

	// Returns true|false if word limit is enabled or not
	var is_word_limit_enabled = function() {
		return word_limit_enabled.find('option:selected').val() == 'true';
	};
	// Returns true|false if trimming into the post excerpt
	var is_trimming_excerpt = function () {
		return trimming_type.find('option:selected').val() == 'excerpt';
	};

	// Updates which fields are visible and which are hidden
	var update_fields = function() {
		rows.not(':first-child').toggle( is_word_limit_enabled() );
		update_ellipsis();
	};
	// Updates the visible/hidden state of the ellipsis option
	var update_ellipsis = function () {
		ellipsis.closest('tr').toggle( is_trimming_excerpt() );
	};

	// When the word limit enabled field changes value, update the rows
	word_limit_enabled.on('change', update_fields);
	// When the trimming type changes value, the ellipsis option's state is updated
	trimming_type.on('change', update_ellipsis);
	// Also run for first time on page load
	update_fields();
});
