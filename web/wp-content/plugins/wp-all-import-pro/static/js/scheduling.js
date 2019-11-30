/**
 * plugin javascript
 */
(function($){$(function () {

	if ( ! $('body.wpallimport-plugin').length) return; // do not execute any code if we are not on plugin page

	var hasActiveLicense = false;

		// Main accordion logic
	$('input[name="scheduling_enable"]').change(function () {

		if ($('input[name="scheduling_enable"]:checked').val() == 1) {
			$('#automatic-scheduling').slideDown();
			$('.manual-scheduling').slideUp();
			setTimeout(function () {
				$('.timezone-select').slideDown(275);
			}, 200);
		}
		else if ($('input[name="scheduling_enable"]:checked').val() == 2) {
			$('.timezone-select').slideUp(275);
			$('#automatic-scheduling').slideUp();
			$('.manual-scheduling').slideDown();
		} else {
			$('.timezone-select').hide();
			$('#automatic-scheduling').slideUp();
			$('.manual-scheduling').slideUp();
		}
	});

	// help scheduling template
	$('.help_scheduling').click(function(){

		$('.wp-all-import-scheduling-help').css('left', ($( document ).width()/2) - 255 ).show();
		$('#wp-all-import-scheduling-help-inner').css('max-height', $( window ).height()-150).show();
		$('.wpallimport-overlay').show();
		return false;
	});

	var saveSubscription = false;

	$('#add-subscription').click(function(){
		$('#add-subscription-field').show();
		$('#add-subscription-field').animate({width:'400px'}, 225);
		$('#add-subscription-field').animate({left:'0'}, 225);
		$('#subscribe-button .button-subscribe').css('background-color','#46ba69');
		$('.text-container p').fadeOut();

		setTimeout(function () {
			$('#find-subscription-link').show();
			$('#find-subscription-link').animate({left: '410px'}, 300, 'swing');
		}, 225);
		$('.subscribe-button-text').html('Activate');
		saveSubscription = true;
		return false;
	});

	$('.wp_all_import_scheduling_help').find('h3').click(function(){
		var $action = $(this).find('span').html();
		$('.wp_all_import_scheduling_help').find('h3').each(function(){
			$(this).find('span').html("+");
		});
		if ( $action == "+" ) {
			$('.wp_all_import_help_tab').slideUp();
			$('.wp_all_import_help_tab[rel=' + $(this).attr('id') + ']').slideDown();
			$(this).find('span').html("-");
		}
		else{
			$('.wp_all_import_help_tab[rel=' + $(this).attr('id') + ']').slideUp();
			$(this).find('span').html("+");
		}
	});

	function openSchedulingAccordeonIfClosed() {
		if ($('.wpallimport-file-options').hasClass('closed')) {
			// Open accordion
			$('#scheduling-title').trigger('click');
		}
	}

    window.openSchedulingDialog = function(itemId, element, preloaderSrc) {
        $('.wpallimport-overlay').show();
        $('.wpallimport-loader').show();

        var $self = element;
        $.ajax({
            type: "POST",
            url: ajaxurl,
            context: element,
            data: {
                'action': 'wpai_scheduling_dialog_content',
                'id': itemId,
                'security' : wp_all_import_security
            },
            success: function (data) {

                $('.wpallimport-loader').hide();
                $(this).pointer({
                    content: '<div id="scheduling-popup">' + data + '</div>',
                    position: {
                        edge: 'right',
                        align: 'center'
                    },
                    pointerWidth: 815,
                    show: function (event, t) {

                        $('.timepicker').timepicker();

                        var $leftOffset = ($(window).width() - 715) / 2;

                        var $pointer = $('.wp-pointer').last();
                        $pointer.css({'position': 'absolute', 'top': '50px', 'left': $leftOffset + 'px'});

                        $pointer.find('a.close').remove();
                        $pointer.find('.wp-pointer-buttons').append('<button class="save-changes button button-primary button-hero wpallimport-large-button scheduling-save-button" style="float: right; background-image: none;">Save</button>');
                        $pointer.find('.wp-pointer-buttons').append('<button class="close-pointer button button-primary button-hero wpallimport-large-button scheduling-cancel-button" style="float: right; background: #F1F1F1 none;text-shadow: 0 0 black; color: #777; margin-right: 10px;">Cancel</button>');

                        $(".close-pointer, .wpallimport-overlay").unbind('click').click(function () {
                            $self.pointer('close');
                            $self.pointer('destroy');
                        });

                        if(!window.pmxiHasSchedulingSubscription) {
                            $('.save-changes ').addClass('disabled');
                        }

                        $(".save-changes").unbind('click').click(function () {
                            if($(this).hasClass('disabled')) {
                                return false;
                            }

                            var formValid = pmxeValidateSchedulingForm();

                            if (formValid.isValid) {

                                var schedulingEnable = $('input[name="scheduling_enable"]:checked').val();

                                var formData = $('#scheduling-form').serializeArray();
                                formData.push({name: 'security', value: wp_all_import_security});
                                formData.push({name: 'action', value: 'save_import_scheduling'});
                                formData.push({name: 'element_id', value: itemId});
                                formData.push({name: 'scheduling_enable', value: schedulingEnable});

                                $('.close-pointer').hide();
                                $('.save-changes').hide();

                                $('.wp-pointer-buttons').append('<img id="pmxe_button_preloader" style="float:right" src="' + preloaderSrc + '" /> ');
                                $.ajax({
                                    type: "POST",
                                    url: ajaxurl,
                                    data: formData,
                                    dataType: "json",
                                    success: function (data) {
                                        $('#pmxe_button_preloader').remove();
                                        $('.close-pointer').show();
                                        $(".wpallimport-overlay").trigger('click');
                                    },
                                    error: function () {
                                        alert('There was a problem saving the schedule');
                                        $('#pmxe_button_preloader').remove();
                                        $('.close-pointer').show();
                                        $(".wpallimport-overlay").trigger('click');
                                    }
                                });

                            } else {
                                alert(formValid.message);
                            }
                            return false;
                        });
                    },
                    close: function () {
                        jQuery('.wpallimport-overlay').hide();
                    }
                }).pointer('open');
            },
            error: function () {
                alert('There was a problem saving the schedule');
                $('#pmxe_button_preloader').remove();
                $('.close-pointer').show();
                $(".wpallimport-overlay").trigger('click');
                $('.wpallimport-loader').hide();
            }
        });
	};

	window.pmxiValidateSchedulingForm = function () {

		var schedulingEnabled = $('input[name="scheduling_enable"]:checked').val() == 1;

		if (!schedulingEnabled) {
			return {
				isValid: true
			};
		}

		var runOn = $('input[name="scheduling_run_on"]:checked').val();

		// Validate weekdays
		if (runOn == 'weekly') {
			var weeklyDays = $('#weekly_days').val();

			if (weeklyDays == '') {
				$('#weekly li').addClass('error');
				return {
					isValid: false,
					message: 'Please select at least a day on which the import should run'
				}
			}
		} else if (runOn == 'monthly') {
			var monthlyDays = $('#monthly_days').val();

			if (monthlyDays == '') {
				$('#monthly li').addClass('error');
				return {
					isValid: false,
					message: 'Please select at least a day on which the import should run'
				}
			}
		}

		// Validate times
		var timeValid = true;
		var timeMessage = 'Please select at least a time for the import to run';
		var timeInputs = $('.timepicker');
		var timesHasValues = false;

		timeInputs.each(function (key, $elem) {

			if($(this).val() !== ''){
				timesHasValues = true;
			}

			if (!$(this).val().match(/^(0?[1-9]|1[012])(:[0-5]\d)[APap][mM]$/) && $(this).val() != '') {
				$(this).addClass('error');
				timeValid = false;
			} else {
				$(this).removeClass('error');
			}
		});

		if(!timesHasValues) {
			timeValid = false;
			$('.timepicker').addClass('error');
		}

		if (!timeValid) {
			return {
				isValid: false,
				message: timeMessage
			};
		}

		return {
			isValid: true
		};
	};

	$('#weekly li').click(function () {

		$('#weekly li').removeClass('error');

		if ($(this).hasClass('selected')) {
			$(this).removeClass('selected');
		} else {
			$(this).addClass('selected');
		}

		$('#weekly_days').val('');

		$('#weekly li.selected').each(function () {
			var val = $(this).data('day');
			$('#weekly_days').val($('#weekly_days').val() + val + ',');
		});

		$('#weekly_days').val($('#weekly_days').val().slice(0, -1));

	});

	$('#monthly li').click(function () {

		$('#monthly li').removeClass('error');
		$(this).parent().parent().find('.days-of-week li').removeClass('selected');
		$(this).addClass('selected');

		$('#monthly_days').val($(this).data('day'));
	});

	$('input[name="scheduling_run_on"]').change(function () {
		var val = $('input[name="scheduling_run_on"]:checked').val();
		if (val == "weekly") {

			$('#weekly').slideDown({
				queue: false
			});
			$('#monthly').slideUp({
				queue: false
			});

		} else if (val == "monthly") {

			$('#weekly').slideUp({
				queue: false
			});
			$('#monthly').slideDown({
				queue: false
			});
		}
	});

	$('.timepicker').timepicker();

	var selectedTimes = [];

	var onTimeSelected = function () {

		selectedTimes.push([$(this).val(), $(this).val() + 1]);

		var isLastChild = $(this).is(':last-child');
		if (isLastChild) {
			$(this).parent().append('<input class="timepicker" name="scheduling_times[]" style="display: none;" type="text" />');
			$('.timepicker:last-child').timepicker({
				'disableTimeRanges': selectedTimes
			});
			$('.timepicker:last-child').fadeIn('fast');
			$('.timepicker').on('changeTime', onTimeSelected);
		}
	};

	$('.timepicker').on('changeTime', onTimeSelected);

	$('#timezone').chosen({width: '320px'});

	$('.wpai-import-complete-save-button').click(function (e) {

		if($('.wpai-save-button').hasClass('disabled')) {
			return false;
		}

		var initialValue = $(this).find('.save-text').html();
		var schedulingEnable = $('input[name="scheduling_enable"]:checked').val() == 1;

		var validationResponse = pmxiValidateSchedulingForm();
		if (!validationResponse.isValid) {

			openSchedulingAccordeonIfClosed();
			e.preventDefault();
			return false;
		}

		$(this).find('.easing-spinner').toggle();

		var $button = $(this);

		var formData = $('#scheduling-form :input').serializeArray();

		formData.push({name: 'security', value: wp_all_import_security});
		formData.push({name: 'action', value: 'save_import_scheduling'});
		formData.push({name: 'element_id', value: import_id});
		formData.push({name: 'scheduling_enable', value: $('input[name="scheduling_enable"]:checked').val()});

		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data: formData,
			success: function (response) {
				$button.find('.easing-spinner').toggle();
				$button.find('.save-text').html(initialValue);
				$button.find('svg').show();
				$button.find('svg').fadeOut(3000);

			},
			error: function () {
				$button.find('.easing-spinner').toggle();
				$button.find('.save-text').html(initialValue);
			}
		});
	});

	$('#subscribe-button').click(function(){

		if(saveSubscription) {
			$('#subscribe-button .easing-spinner').show();
			var license = $('#add-subscription-field').val();
			$.ajax({
				url:ajaxurl+'?action=wp_all_import_api&q=schedulingLicense/saveSchedulingLicense&security=' + wp_all_import_security,
				type:"POST",
				data: {
					license: license
				},
				dataType:"json",
				success: function(response){

					$('#subscribe-button .button-subscribe').css('background-color','#425f9a');
					if(response.success) {
						hasActiveLicense = true;
						$('.wpai-save-button').removeClass('disabled');
						$('#subscribe-button .easing-spinner').hide();
						$('#subscribe-button svg.success').show();
						$('#subscribe-button svg.success').fadeOut(3000, function () {
							$('.subscribe').hide({queue: false});
							$('#subscribe-filler').show({queue: false});
						});

						$('.wpai-no-license').hide();
						$('.wpai-license').show();
                        $('#scheduling_has_license').val('1');
					} else {
						$('#subscribe-button .easing-spinner').hide();
						$('#subscribe-button svg.error').show();
						$('.subscribe-button-text').html('Subscribe');
						$('#subscribe-button svg.error').fadeOut(3000, function () {
							$('#subscribe-button svg.error').hide({queue: false});

						});

						$('#add-subscription').html('Invalid license, try again?');
						$('.text-container p').fadeIn();

						$('#find-subscription-link').animate({width: 'toggle'}, 300, 'swing');

						setTimeout(function () {
							$('#add-subscription-field').animate({width:'140px'}, 225);
							$('#add-subscription-field').animate({left:'-161px'}, 225);
						}, 300);

						$('#add-subscription-field').val('');

						$('#subscribe-button-text').html('Subscribe');
						saveSubscription = false;
					}
				}
			});

			return false;
		}
	});

    $('.wpai-save-scheduling-button, .wpai-save-scheduling-button-blue').click(function (e) {

    	var saveOnly = $(this).hasClass('save_only');

    	var hasActiveLicense = $('#scheduling_has_license').val();

    	if(hasActiveLicense === '1') {
    		hasActiveLicense = true;
		} else {
    		hasActiveLicense = false;
		}

        var initialValue = $(this).find('.save-text').html();
        var schedulingEnable = $('input[name="scheduling_enable"]:checked').val() == 1;
        if(!hasActiveLicense) {
            if (!$(this).data('iunderstand') && schedulingEnable) {
                $('#no-subscription').slideDown();
                $(this).find('.save-text').html('I Understand');
                $(this).find('.save-text').addClass('wpai-iunderstand');
                $(this).find('.save-text').css('left', '100px');
                $(this).data('iunderstand', 1);

                openSchedulingAccordeonIfClosed();
                e.preventDefault();
                return;
            } else {
            	if(saveOnly) {
            		$('#save_only_field').prop('disabled', false);
				}
                $('#wpai-submit-confirm-form').submit();
                return;
            }
        }

        // Don't process scheduling
        if (!schedulingEnable) {
            if(saveOnly) {
                $('#save_only_field').prop('disabled', false);
            }
            $('#wpai-submit-confirm-form').submit();

            return;
        }

        var validationResponse = pmxiValidateSchedulingForm();
        if (!validationResponse.isValid) {

            openSchedulingAccordeonIfClosed();
            $('html, body').animate({
                scrollTop: $("#scheduling-title").offset().top-100
            }, 500);
            e.preventDefault();
            return false;
        }

        var $button = $(this);

        var formData = $('#scheduling-form :input').serializeArray();

        formData.push({name: 'security', value: wp_all_import_security});
        formData.push({name: 'action', value: 'save_import_scheduling'});
        formData.push({name: 'element_id', value: $('#scheduling_import_id').val()});
        formData.push({name: 'scheduling_enable', value: $('input[name="scheduling_enable"]:checked').val()});

        $button.find('.easing-spinner').toggle();

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: formData,
            success: function (response) {
                $button.find('.easing-spinner').toggle();
                $button.find('.save-text').html(initialValue);
                $button.find('.save-text').removeClass('wpai-iunderstand');
                $button.find('svg').show();

                setTimeout(function(){
                    if(saveOnly) {
                        $('#save_only_field').prop('disabled', false);
                    }
                    $('#wpai-submit-confirm-form').submit();
                }, 1000);

            },
            error: function () {
                $button.find('.easing-spinner').toggle();
                $button.find('.save-text').html(initialValue);
                $button.find('.save-text').removeClass('wpai-iunderstand');
            }
        });
    });
	
});})(jQuery);