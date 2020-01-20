$(document).ready(function() {
	// refresh page on browser resize (border lines)
	var windowWidth = $(window).width();

	// Resize Event
	$(window).resize(function() {
		// Check for iOS fake resize
		if ($(window).width() != windowWidth) {
			windowWidth = $(window).width();
			this.location.reload(false);

			/* false to get page from cache */
			/* true to fetch page from server */
		}
	});
}); // end of document.ready
