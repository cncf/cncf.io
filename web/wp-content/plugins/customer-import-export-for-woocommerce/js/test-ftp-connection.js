// Triggered When Test FTP Button is clicked for User Import Export

jQuery('#test_ftp_connection').click(function(){
	jQuery('.spinner').addClass('is-active');
	var use_ftp = jQuery("#use_ftps").prop("checked") ? 1 : 0;
        var is_sftp = jQuery("#is_sftp").prop("checked") ? 1 : 0; 

	jQuery.ajax({
		url : xa_user_impexp_test_ftp.admin_ajax_url,
		type:       'POST',
		data : {
				action			:	'user_impexp_test_ftp_connection',
				ftp_host		:	jQuery('#ftp_server').val(),
				ftp_port		:	jQuery('#ftp_port').val(),
				ftp_userid		:	jQuery('#ftp_user').val(),
				ftp_password	:	jQuery('#ftp_password').val(),
				use_ftps		:	use_ftp,
				is_sftp			:	is_sftp,
				wt_nonce: xa_user_impexp_test_ftp.nonce
				},
		success : function(response){
			jQuery('.spinner').removeClass('is-active');
			jQuery('#user_impexp_ftp_test_msg').remove();
			jQuery('#test_ftp_connection_notice').prepend(response);
			jQuery("#user_impexp_ftp_test_msg").delay(8000).fadeOut(300);
		}
	    });
});