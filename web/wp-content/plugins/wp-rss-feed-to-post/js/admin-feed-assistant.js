jQuery( document ).ready( function($) {
	var feedAssistant = window.wprss.feedAssistant,
		debouncing = undefined;

	/**
	@function 	showBusy						Shows/hides the various busy UI indicators.
	@param 		{Boolean}		busy 			TRUE to show busy indicators, FALSE to hide the indicators.
	*/
	showBusy = function(busy) {
		var feedPreviewMB = $("#preview_meta_box"),
			previewDiv = feedPreviewMB.find('.inside');

		if (previewDiv.find('#feed-preview-container').length) {
			previewDiv = previewDiv.find('#feed-preview-container');
		}

		$("#wprss-url-error").empty();		

		if (busy) {
			previewDiv.html('<h4>Fetching feed preview...</h4>');
			$("#wprss-url-spinner").addClass("wprss-show");
		} else {
			$("#wprss-url-spinner").removeClass("wprss-show");
		}
	};

	/**
	@function 	showError						Shows an error under the RSS Feed URL textbox.
	@param 		{String}		error 			The error message to show.
	*/
	showError = function(error) {
		$("#wprss-url-error").html('<small><strong>' + error + '</small></strong>');
		feedAssistant._showPreviews(undefined);
	};

	/**
	@function 	runFeedAssistant				Call the Feed Assistant's feed checker.
	*/
	runFeedAssistant = function() {
		var url = $('#wprss_url').val();

		if (url === undefined || url === '') {
			return;
		}

		showBusy(true);

		feedAssistant.checkFeed( url, 5 ).
		then(function(response) {
			showBusy(false);
		}, function (jqXHR, response) {
			showBusy(false);
			showError(response.error);
		});
	};

	/**
	@function 	debounceFeedAssistant			Debounce so we don't fire off a bunch of AJAX calls.
	*/
	debounceFeedAssistant = function() {
		if (debouncing !== undefined) {
			clearTimeout(debouncing);
		}

		debouncing = setTimeout(function() {
			runFeedAssistant();
		}, 1000);
	};

	runFeedAssistant();
	$('#wprss_url').on('input propertychange paste', debounceFeedAssistant);
	$('#wprss-force-feed').on( 'change', runFeedAssistant );
	$('#wprss_ftp_force_full_content').on( 'change', runFeedAssistant );
});
