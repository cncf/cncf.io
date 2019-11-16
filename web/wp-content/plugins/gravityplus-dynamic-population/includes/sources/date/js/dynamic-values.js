/**
 * Dynamically populate date source values
 * 
 * @since 2.0.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 *
 */
jQuery( document ).ready( function( jQuery ) {

    if ( gfp_dynamic_value_date_hook_condition() ) {

        gform.addFilter('gfp_populate_value', gfp_populate_date_value, 10, 'gfp_populate_value_date');

    }

} );

/**
 * Whether or not hooks should get added, to prevent duplicates
 *
 * @since 2.1.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 *
 * @returns {boolean}
 */
function gfp_dynamic_value_date_hook_condition() {

    if (undefined == gform.hooks['filter']['gfp_populate_value']) {

        return true;
    }

    for (var i = 0; i < gform.hooks['filter']['gfp_populate_value'].length; i++) {

        if ( 'gfp_populate_value_date' === gform.hooks['filter']['gfp_populate_value'][i]['tag'] ) {

            return false;

        }

    }


    return true;
}

/**
 * Dynamically populate field value
 *
 * @since 2.0.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 *
 * @param data
 * @param form_id
 * @param field_id
 */
function gfp_populate_date_value(data, form_id, field_id ) {

    var field_info = gfp_get_dynamic_value_field_info( field_id );

    if ( 'date' == field_info['source'] ) {

        var date_field = jQuery( '#input_' + form_id + '_' + field_id );

        if ( 0 < data['value'].value.length ) {

            date_field.val( data['value'].value);

        }

        if ( 0 < data['value'].min.length ) {

            gfp_limit_date_range_vars.fields[field_id]['min'] = data['value'].min;

        }

        if ( 0 < data['value'].max.length ) {

            gfp_limit_date_range_vars.fields[field_id]['max'] = data['value'].max;

        }

        gfp_datepicker_apply_limit( date_field );

    }

    return data;

}