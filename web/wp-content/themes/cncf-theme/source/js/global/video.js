jQuery(function($) {
	// wrap all youtube videos so they can be responsive.
	$(
		'iframe[src*="youtube.com"], iframe[src*="vimeo.com"], iframe[data-src*="youtube.com"], iframe[data-src*="vimeo.com"]'
	).each(function() {
		$(this).wrap('<div class="videowrapper"></div>');
	});
});
("use strict");
