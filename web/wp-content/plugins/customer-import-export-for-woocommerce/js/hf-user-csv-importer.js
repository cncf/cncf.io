jQuery(document).ready(function(a) {   
    "use strict";
     a("#u_start_date").datepicker({
        dateFormat: "yy-mm-dd",
        numberOfMonths: 1,
        showButtonPanel: !0,
        //showOn: "button",
        buttonImage: woocommerce_user_csv_import_params.calendar_icon,
        buttonImageOnly: !0
    }),a("#u_end_date").datepicker({
        dateFormat: "yy-mm-dd",
        numberOfMonths: 1,
        showButtonPanel: !0,
        //showOn: "button",
        buttonImage: woocommerce_user_csv_import_params.calendar_icon,
        buttonImageOnly: !0
    }),
    
    a("#usr_export_enable_ftp").click(function () {
        if (this.checked) {
            a("#usr_export_enable_ftp_section_all").show();
        }else{
            a("#usr_export_enable_ftp_section_all").hide();
        }
    });
   /* a('#usrselectall').click(function(event) {
            // Iterate each checkbox
           a(':checkbox').each(function() {
                this.checked = true;
            });
    });
    a('#usrunselectall').click(function(event) {   
            // Iterate each checkbox
           a(':checkbox').each(function() {
                this.checked = false;
            });
    });*/
    
      jQuery( "body" ).on( "click", "#usrselectall", function() {  // jQuery .live() has been removed in version 1.9 onwards. use .on()
        // Iterate each checkbox
        a('#datagrid :checkbox').each(function () {
            this.checked = true;
        });
    });
    
    jQuery( "body" ).on( "click", "#usrunselectall", function() {
        // Iterate each checkbox
        a('#datagrid :checkbox').each(function () {
            this.checked = false;
        });
    });
    
    
    a("select[name=usr_export_profile]").change(function () {

        var selected_profile = this.value;
        a("#v_usr_new_profile").val(selected_profile);
        var data = {
            action: 'user_csv_export_mapping_change',
            v_user_new_profile: selected_profile,
            wt_nonce: woocommerce_user_csv_export_params.nonce
        };
        a.ajax({
            url: woocommerce_user_csv_export_params.siteurl+'?page=hf_wordpress_customer_im_ex',
            data: data,
            type: 'POST',
            success: function (response) {
                a("#datagrid").html(response);
            }});
    });
        
    jQuery("#usr_save_import_mapping").click(function () {
        var profile_name = jQuery("input[name='profile']").val();
        if(profile_name==''){
            alert(woocommerce_user_csv_import_params.profile_empty_msg);
            return false;
        }
        jQuery('.spinner').addClass('is-active');
        
        var map_from = jQuery("select[name*='map_from[']").serializeArray();
        var eval_field = jQuery("input[name*='eval_field[']").serializeArray();   
        var data = {
            action: 'user_csv_import_mapping_save',
            profile_name: profile_name,
            map_from: map_from,
            eval_field: eval_field,
            wt_nonce: woocommerce_user_csv_import_params.nonce
            
        };
        jQuery.ajax({
            url: woocommerce_user_csv_export_params.siteurl + '?page=hf_wordpress_customer_im_ex',
            data: data,
            type: 'POST',
            
            success : function(response){
                jQuery('.spinner').removeClass('is-active');
                jQuery('#usr_save_mapping_msg').remove();
                jQuery('#usr_save_mapping_notice').prepend(response);
                jQuery("#usr_save_mapping_msg").delay(8000).fadeOut(300);
            }
        });
    });
    
    jQuery("#usr_save_export_mapping").click(function () {
        var profile_name = jQuery("input[name='usr_new_profile']").val();
        if(profile_name==''){
            alert(woocommerce_user_csv_import_params.profile_empty_msg);
            return false;
        }
        jQuery('.spinner').addClass('is-active');
        var columns = jQuery("input[name*='columns[']").serializeArray();
        var columns_name = jQuery("input[name*='columns_name[']").serializeArray(); 
        var wt_specific_metas = jQuery("#v_specifi_metas").val();
        var data = {
            action: 'user_csv_export_mapping_save',
            profile_name: profile_name,
            columns: columns,
            columns_name: columns_name,
            wt_specific_metas: wt_specific_metas,
            wt_nonce: woocommerce_user_csv_import_params.nonce

        };
        jQuery.ajax({
            url: woocommerce_user_csv_export_params.siteurl + '?page=hf_wordpress_customer_im_ex',
            data: data,
            type: 'POST',
            
            success : function(response){
			jQuery('.spinner').removeClass('is-active');
			jQuery('#usr_save_mapping_msg').remove();
			jQuery('#usr_save_mapping_notice').prepend(response);
			jQuery("#usr_save_mapping_msg").delay(8000).fadeOut(300);
		}
            });
    });
    
    jQuery("#save_profile").click(function(){
        var profile_name = jQuery("input[name='profile_name']").val();
        if(profile_name==''){
            alert(woocommerce_user_csv_import_params.profile_empty_msg);
            return false;
        }
    });
    
    jQuery("#v_delete_user_export_mapping").click(function () {  
        var profile_name = jQuery("select[name='usr_export_profile']").val();
        
        if(profile_name==''){
            alert("Please select a profile.");
            return false;
        }
        jQuery('.delete.spinner').addClass('is-active');
        var data = {
            action: 'user_csv_export_mapping_delete',
            profile_name: profile_name,
            wt_nonce: woocommerce_user_csv_export_params.nonce

        };
        jQuery.ajax({
            url: woocommerce_user_csv_export_params.siteurl + '?page=hf_wordpress_customer_im_ex',
            data: data,
            type: 'POST',
            
            success : function(response){
			jQuery('.spinner').removeClass('is-active');
			jQuery('#user_delete_mapping_msg').remove();
			jQuery('#user_delete_mapping_notice').prepend(response);
			jQuery("#user_delete_mapping_msg").delay(8000).fadeOut(300);
		}
            });
    });
    
    jQuery("#v_delete_user_import_mapping").click(function () {  
        var profile_name = jQuery("select[name='profile']").val();
        
        if(profile_name==''){
            alert("Please select a profile.");
            return false;
        }
        jQuery('.delete.spinner').addClass('is-active');
        var data = {
            action: 'user_csv_import_mapping_delete',
            profile_name: profile_name,
            wt_nonce: woocommerce_user_csv_export_params.nonce

        };
        jQuery.ajax({
            url: woocommerce_user_csv_export_params.siteurl + '?page=hf_wordpress_customer_im_ex',
            data: data,
            type: 'POST',
            
            success : function(response){
			jQuery('.spinner').removeClass('is-active');
			jQuery('#user_delete_imp_mapping_msg').remove();
			jQuery('#user_delete_imp_mapping_notice').prepend(response);
			jQuery("#user_delete_imp_mapping_msg").delay(8000).fadeOut(300);
		}
            });
    });
});