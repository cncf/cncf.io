jQuery(function($) {
	$("body").on("click", ".subscribe", function(e) {
		e.preventDefault();

		$(".loading").show();

		email = $("#email").val();
		name = $("#name").val();

		if (isEmail(email)) {
			var data = {
				action: "subscribe_user",
				email: email,
				name: name,
				security: aw.security
			};

			$.post(aw.ajaxurl, data, function(response) {
				// $('.loading').hide();
				if (200 == response) {
					// alert('You have subscribed successfully.');
					$(".loading").hide();
					$(".success-message").addClass("is-active");
				} else {
					// alert(response);
					$(".loading").hide();
					$(".error-message").addClass("is-active");
					$(".error-message").append(response);
				}
			});
		} else {
			// alert('This is not a valid email');
			$(".loading").hide();
			$(".email-message").css("display", "");
			$(".email-message").addClass("is-active");
			$(".email-message").fadeOut(5000, function() {
				$(this).removeClass("is-active");
			});
		}
	});
});

function isEmail(email) {
	var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

	return regex.test(email);
}
