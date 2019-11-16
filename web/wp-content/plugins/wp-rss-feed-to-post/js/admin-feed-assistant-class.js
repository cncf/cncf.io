;(function($, window, document) {
	var wprss = window.wprss = window.wprss || {};
	var feedAssistant = wprss.feedAssistant = wprss.feedAssistant || {};

	$.extend(feedAssistant, {
		/**
		@class 						FeedAssistant
		@description 				This class communicates via AJAX requests to the WP RSS Aggregator back-end,
		@... 						which fetches the RSS feed being configured and returns information about the feed
		@...						that the user may find helpful when configuring the settings.
		*/
		namespace: 	'wprss.feedAssistant',


		/**
		@function 	_showHints						Show the hints returned by the back-end
		@private
		@param 		{Object}		hints			A JSON Object of hint objects.
		*/
		_showHints: function(hints) {
			var i = 0;
			if (hints === undefined || hints.length === 0) {
				return;
			}

			for (i in hints) {
				this._showHint(hints[i]);
			}
		},


		/**
		@function 	_showHint						Show a single hint on the page.
		@private
		@param 		{Object}		hint			The hint JSON object.
		*/
		_showHint: function(hint) {		
			var element = $('#' + hint.id),
				hintHTML,
				hintSpan;
			
			// We were called without a hint.
			if (hint === undefined || element.length === 0) {
				return;
			}

			// Autoselect a value (if applicable)
			// if (hint.autoselectValue && this._shouldAutoselect(element) ) {
			// 	element.val(hint.autoselectValue);
			// }

			// Show autoselect mismatch warning
			if (hint.autoselectValue === 'checked' || hint.autoselectValue === 'unchecked') {
				if ( element.is(':checked') && hint.autoselectValue !== 'checked' ) {
					hint.type = 'warning';
					hint.text = 'If you encounter errors, try leaving this ' + hint.autoselectName + '.';
				}
			} else {
				if (hint.autoselectValue !== element.val()) {
					hint.type = 'warning';
					hint.text = 'If you encounter errors, try using the "' + hint.autoselectName + '" setting.';
				}
			}

			hintHTML = this._constructHintHTML(hint);
			hintSpan = this._getHintSpan(hint);
			hintSpan.html(hintHTML);

		},


		/**
		@function 	_constructHintHTML				Helper function to create the hint contents.
		@private
		@param 		{Object}		hint			The hint JSON object.
		@returns	{String}						HTML markup of the hint.
		*/
		_constructHintHTML: function(hint) {
			var html = '';

			if (hint.type === 'ok') {
				html += '<i class="fa fa-thumbs-up wprss-hint-green"></i>&nbsp;';
			} else if (hint.type === 'warning') {
				html += '<i class="fa fa-warning wprss-hint-yellow"></i>&nbsp;';
			} else if (hint.type === 'error') {
				html += '<i class="fa fa-thumbs-down wprss-hint-red"></i>&nbsp;';
			}

			if (hint.text.length) {
				html += '<small>' + hint.text + '</small>';
			}

			return html;
		},


		/**
		@function 	_getHintSpan					Helper function to get the <span> for the hint.
		@private
		@param 		{Object}		hint			The hint JSON object.
		@returns	{jQuery}						jQuery object for the hint <span>.
		*/
		_getHintSpan: function(hint) {
			var span = $('#' + hint.id + '_hint');

			if (span.length === 0) {
				span = $("<span/>", {
					'id': hint.id + '_hint',
					'class': 'wprss-fa-hint'
				});
				$('#' + hint.placement).after(span);
			}

			return span;
		},


		/**
		@function 	_shouldAutoselect				Helper function to decide whether to autoselect a value for a UI element.
		@private
		@param 		{jQuery}		element			The jQuery element who's value we'd set.
		@returns	{Boolean}						Whether we should set the element's value.
		*/
		_shouldAutoselect: function(element) {
			// Autoselect if the page is an "Add New" page versus an "Edit" page.
			if ( window.location.href.search('post-new.php') === -1) {
				return false;
			} else {
				return true;
			}
		},


		/**
		@function 	_showPreviews	 				Fills out the Feed Preview metabox
		@private
		@param 		{Array}			previews		Array of Preview JSON objects sent by the back-end
		*/
		_showPreviews: function(previews) {
			var i = 0,
				feedPreviewMB = $("#preview_meta_box"),
				previewDiv = feedPreviewMB.find('.inside'),
				feedPreviewHTML = '',
				itemPreviewHTML = '',
				item;

			if (previewDiv.find('#feed-preview-container').length) {
				previewDiv = previewDiv.find('#feed-preview-container');
			}

			// There's nothing to preview...
			if (previews === undefined || previews.length === 0) {
				feedPreviewHTML = '<h4 style="color:red;">No items to be previewed. Kindly ensure that this is a valid feed or try using the <em>Force Feed</em> option below.</h4>';
				previewDiv.html(feedPreviewHTML);
				return;
			}

			feedPreviewHTML += '<h4>Previewing latest ' + previews.length + ' feed items.</h4>';
			feedPreviewHTML += '<ul>';

			for (i = 0; i < previews.length; i++) {
				item = previews[i];

				feedPreviewHTML += this._showPreview(item);

				feedPreviewHTML += itemPreviewHTML;
			}

			feedPreviewHTML += '</ul>';

			previewDiv.html(feedPreviewHTML);
		},


		/**
		@function 	_showPreview					Show a single preview on the page.
		@private
		@param 		{Object}		preview			The preview JSON object.
		@returns	{String}						HTML markup of the item preview.
		*/
		_showPreview: function(preview) {
			var html  = '<li>';
			html += preview.title;
			
			if (preview.images && preview.images.locations.length) {
				html += '<div><small>Image found in ' + preview.images.locations.join(', ') + '</small></div>';
			}

			html += '<div class="rss-date"><small>' + preview.date + '</small></div>';

			return html;
		},


		/**
		 @function 	_showForceFeedOption			Shows the Force Feed option at the bottom of the Feed Preview
		 @private
		 @param 	{String}		forceFeed		The HTML markup of the Force Feed option
		 @deprecated 4.6.13
		 */
		_showForceFeedOption: function(forceFeed) {
			var feedPreviewMB = $("#preview_meta_box"),
				previewDiv = feedPreviewMB.find('.inside'),
				html = previewDiv.html() + forceFeed;
			previewDiv.html(html);
		},


		/**
		@function 	checkFeed	 					Checks a feed URL for information.
		@param 		{String}		url 			The URL of the feed source
		@param 		{Int}			num_items		Number of feed items to check and preview
		@returns	{Object} 		promise 	 	A jQuery Promise
		@promise 	{Object}		info			The feed source's info, if no errors.
		*/
		checkFeed: function(url, num_items) {
			return $.ajax({
				url: ajaxurl,
				dataType: 'json',
				data: {
					action: 'wprss_ajax_check_feed',
					url: url,
					num_items: num_items ? num_items : 1,
					post_id: $('#wprss-ftp-post-id').attr('data-post-id'),
					force_feed: $('#wprss-force-feed').attr('checked') == 'checked',
					full_content: $('#wprss_ftp_force_full_content').attr('checked') == 'checked',
				}
			}).then(function(response, textStatus, jqXHR) {
				if (response.hints !== undefined) {
					feedAssistant._showHints(response.hints);
				}

				if (response.preview !== undefined) {
					feedAssistant._showPreviews(response.preview);
				}

				if (response.force_feed !== undefined) {
					feedAssistant._showForceFeedOption(response.force_feed);
				}

				if (response.error !== undefined) {
					console.log('Feed Assistant Error: ', response.error);
					return $.Deferred().reject(jqXHR, response, 'Not YES').promise();
				}

				return response;
			});
		}

	});

})(jQuery, top, document);
