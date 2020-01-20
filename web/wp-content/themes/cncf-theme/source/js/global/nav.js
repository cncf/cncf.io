jQuery(function($) {
	$("a.show-menu").click(function(e) {
		e.preventDefault();
		$("body").toggleClass("menu-active");
		$(this).toggleClass("active");
		$(".menu-main-menu-container").toggleClass("active");
	});
});
