/**
 * Dynamically populate field values
 *
 * @since 2.0.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 *
 */
jQuery(document).on('gform_post_render', gfp_dynamically_populate_values);

/**
 * @since 2.0.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 *
 * @param event
 * @param form_id
 * @param current_page
 */
function gfp_dynamically_populate_values(event, form_id, current_page) {

    if (gfp_dynamic_values.form_id == form_id) {

        for (var field_id in gfp_dynamic_values.dependees) {

            if (gfp_dynamic_values.dependees.hasOwnProperty(field_id)) {

                //TODO get proper input element for fields like radio, checkbox. This currently works for radio

                jQuery('#input_' + form_id + '_' + field_id).change({
                    dependents: gfp_dynamic_values.dependees[field_id]['dependents'],
                    field_id: field_id,
                    field_type: gfp_dynamic_values.dependees[field_id]['field_type'],
                    form_id: form_id
                }, gfp_dynamically_populate_dependents);

            }

        }

        /*for ( var i = 0; i < gfp_dynamic_values.field_info.length; i++ ) {

            if ( 0 == gfp_dynamic_values.field_info[i]['dependees'].length ) {

                gform.applyFilters( 'gfp_populate_value', {}, form_id, gfp_dynamic_values.field_info[i]['field_id'] );

            }

        }*/

        if ( gfp_dynamic_value_hook_condition() ) {

            gform.addFilter('gfp_populate_value', gfp_populate_source_value, 10, 'gform_post_render_core' );

        }

    }
}

/**
 * Whether or not hooks should get added, to prevent duplicates
 *
 * @since 2.1.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 *
 * @returns {boolean}
 */
function gfp_dynamic_value_hook_condition() {

    if (undefined == gform.hooks['filter']['gfp_populate_value']) {

        return true;
    }

    for (var i = 0; i < gform.hooks['filter']['gfp_populate_value'].length; i++) {

        if ( 'gform_post_render_core' === gform.hooks['filter']['gfp_populate_value'][i]['tag'] ) {

            return false;

        }

    }


    return true;
}

/**
 * Correctly get a field value, based on field type
 *
 * @since 2.1.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 *
 * @param field
 * @param field_type
 * @param form_id
 * @param field_id
 * @returns {*|string}
 */
function gfp_dynamic_value_get_field_value( field, field_type, form_id, field_id ) {

    var field_value = '';

    switch( field_type ) {

        case 'select':

            field_value = field.val();

            break;

        case 'radio':
        case 'checkbox':

            field_value = field.find( 'input:checked' ).val();

            break;

        default:

            field_value = field.val();
    }


    return field_value;

}

/**
 * Correctly populate a form field with a value, based on field type
 *
 * @since 2.1.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 *
 * @param form_id
 * @param field_id
 * @param field_type
 * @param value
 */
function gfp_dynamic_value_populate_field( form_id, field_id, field_type, value ) {

    var field = jQuery('#input_' + form_id + '_' + field_id);


    switch( field_type ) {

        case 'select':
        case 'radio':
        case 'checkbox':

            field.html( value );

            break;

        case 'html':

            jQuery('#field_' + form_id + '_' + field_id).html(value);

            break;

        default:

            field.val(value);

            break;

    }

}

/**
 *
 * @since 2.0.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 *
 * @param event
 */
function gfp_dynamically_populate_dependents(event) {

    jQuery(this).prop('disabled', true);


    var dependee_field_id = event.data.field_id;

    var dependents = event.data.dependents;

    if (0 < dependents.length) {

        var field_value = gfp_dynamic_value_get_field_value( jQuery(this), event.data.field_type, event.data.form_id, event.data.field_id );

        var dependee = [
            {field_id: dependee_field_id, value: field_value }
        ];

        for (var index in dependents) {

            if (dependents.hasOwnProperty(index)) {

                gfp_reset_dynamic_value_field(event.data.form_id, dependents[index]);

            }

        }

        for (var index in dependents) {

            if (dependents.hasOwnProperty(index)) {

                gfp_populate_value(event.data.form_id, dependents[index], dependee);

            }

        }

    }

    jQuery(this).prop('disabled', false);

}


/**
 *
 * @since 2.0.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 *
 * @param form_id
 * @param field_id
 */
function gfp_reset_dynamic_value_field(form_id, field_id) {

    var field = jQuery('#input_' + form_id + '_' + field_id);

    field.prop('disabled', true);

    var field_info = gfp_get_dynamic_value_field_info(field_id);

    var value = '';

    switch( field_info['field_type'] ) {

        case 'select':

            value = '<option value="' + field_info['placeholder']['value'] + '" selected="selected">' + field_info['placeholder']['text'] + '</option>';

            break;

        case 'radio':
        case 'checkbox':

            value = gfp_dynamic_values.generating_options_message + '...';

            break;

    }

    gfp_dynamic_value_populate_field( form_id, field_id, field_info['field_type'], value );

}

/**
 *
 * @since 2.0.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 *
 * @param field_id
 * @returns {Array}
 */
function gfp_get_dynamic_value_field_info(field_id) {

    var dynamic_field_info = [];

    for (var i = 0; i < gfp_dynamic_values.field_info.length; i++) {

        if (field_id == gfp_dynamic_values.field_info[i].field_id) {

            dynamic_field_info = gfp_dynamic_values.field_info[i];

            break;
        }
    }

    return dynamic_field_info;
}

/**
 * Get all fields a dynamic value depends on
 *
 * @since 2.0.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 *
 * @param field_id
 * @param form_id
 * @param dependees
 * @returns {*}
 */
function gfp_get_dynamic_value_dependees_for_field(field_id, form_id, dependees) {

    var field_info = gfp_get_dynamic_value_field_info(field_id);


    if (1 < field_info['dependees'].length) {

        for (var i = 0; i < field_info['dependees'].length; i++) {

            var addl_dependee_field_id = field_info['dependees'][i]['field_id'];

            if (addl_dependee_field_id != dependees[0].field_id) {

                var addl_dependee_field_value = gfp_dynamic_value_get_field_value( jQuery('#input_' + form_id + '_' + addl_dependee_field_id), field_info['dependees'][i]['field_type'], form_id, addl_dependee_field_id );

                if (0 < addl_dependee_field_value.length) {

                    dependees[dependees.length] = {field_id: addl_dependee_field_id, value: addl_dependee_field_value};

                }
                else {

                    dependees = [];

                    break;

                }

            }

        }

    }

    return dependees;
}

/**
 * Add info needed for GF filter processing
 *
 * @since 2.1.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 *
 * @param field_id
 * @param dependees
 * @returns {*}
 */
function gfp_add_gf_filter_info_to_dependees( field_id, dependees ) {

    var field_info = gfp_get_dynamic_value_field_info( field_id );

    for ( var j = 0; j < dependees.length; j++ ) {

        for ( var i = 0; i < field_info['dependees'].length; i++ ) {

            if ( ( field_info['dependees'][i]['field_id'] == dependees[j].field_id ) &&  'undefined' !== typeof( field_info['dependees'][i]['column'] ) ) {

                dependees[j].column = field_info['dependees'][i]['column'];

                dependees[j].operator = field_info['dependees'][i]['operator'];

                break;
            }
        }
    }

    return dependees;
}

/**
 * Dynamically populate field value
 *
 * @since 2.0.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 *
 * @param form_id
 * @param field_id
 * @param dependee
 */
function gfp_populate_value(form_id, field_id, dependee) {

    var dependees = gfp_get_dynamic_value_dependees_for_field(field_id, form_id, dependee);

    if (0 < dependees.length) {

        dependees = gfp_add_gf_filter_info_to_dependees( field_id, dependees );

        var field_info = gfp_get_dynamic_value_field_info(field_id);

        var post_data = {
            action: 'gfp_get_dynamic_field_value',
            form_id: form_id,
            field_id: field_id,
            feed_id: field_info['feed_id'],
            dependees: dependees
        };

        jQuery.post(gfp_dynamic_values.ajaxurl, post_data).done(function (response) {

            if (true === response.success) {

                var field = jQuery('#input_' + form_id + '_' + field_id);

                gform.applyFilters('gfp_populate_value', response.data, form_id, field_id);

                field.prop('disabled', false);

                if (true === response.data.trigger_change) {

                    //TODO this needs to be based on field type
                    field.change();

                }

            }

        });

    }

}

/**
 * Populate WPDB source value
 *
 * @since 2.1.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 *
 * @param data
 * @param form_id
 * @param field_id
 */
function gfp_populate_source_value(data, form_id, field_id ) {

    var field_info = gfp_get_dynamic_value_field_info( field_id );

    var allowed_sources = [ 'wpdb', 'posts', 'entries', 'users', 'taxonomy']; //TODO this needs to be dynamic. each source should just extend the filter

    if ( allowed_sources.includes( field_info['source'] ) ) {

        gfp_dynamic_value_populate_field( form_id, field_id, field_info['field_type'], data.value );

    }

}