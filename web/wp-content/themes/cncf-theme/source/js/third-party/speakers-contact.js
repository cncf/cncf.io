jQuery(document).on('gform_post_render', function(event, form_id, current_page){
    if (form_id === 10 ) {

        jQuery(document).ready(function(){
            jQuery("li.gf_readonly select").attr("readonly","readonly");
        });

        if( typeof(jQuery.fn.select2) === "function" ){
            jQuery("#input_10_2").select2({
                allowClear: false,
                dropdownPosition: 'below',
                maximumSelectionLength: 50,
            });
        }

        jQuery('#input_10_8').on( 'change', function(e) {
            jQuery('#input_10_9').val(e.target.value);
        });
    }
});