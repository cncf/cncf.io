/**
 * Dynamically populate and filter options
 *
 * @since
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
jQuery( document ).on( 'gform_post_render', gfp_dynamically_populate_options );

/**
 * @since
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 *
 * @param event
 * @param form_id
 * @param current_page
 */
function gfp_dynamically_populate_options( event, form_id, current_page ) {

	if ( gfp_dynamic_choices.form_id == form_id ) {

		for ( var i = 0; i < gfp_dynamic_choices.field_info.length; i++ ) {

			if ( 'filters' in gfp_dynamic_choices.field_info[i] ) {


				jQuery( '#input_' + form_id + '_' + gfp_dynamic_choices.field_info[i]['field_id'] ).change( {
																												field_position: i,
																												field_id: gfp_dynamic_choices.field_info[i]['field_id'],
                    																							field_type: gfp_dynamic_choices.field_info[i]['field_type'],
																												form_id: form_id
																											}, gfp_dynamically_filter_options );
			}
		}
	}
}

/**
 * @since
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 *
 * @param event
 */
function gfp_dynamically_filter_options( event ) {

	jQuery( this ).prop( 'disabled', true );


	var fields_to_filter = gfp_dynamic_choices.field_info[event.data.field_position]['filters'];

	if ( 0 < fields_to_filter.length ) {

		for ( var i = 0; i < fields_to_filter.length; i++ ) {

			gfp_reset_dynamic_option_field( event.data.form_id, fields_to_filter[i] );
		}

		var field_value = ('select' === event.data.field_type ) ? jQuery( this ).val() : jQuery( this ).find( 'input:checked' ).val();

		var filter = [
			{field_id: event.data.field_id, value: field_value}
		];

		for ( var i = 0; i < fields_to_filter.length; i++ ) {

			gfp_apply_filters( event.data.form_id, fields_to_filter[i], filter );
		}

		jQuery( this ).prop( 'disabled', false );
	}
}

/**
 * @since
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 *
 * @param field_id
 * @returns {Array}
 */
function gfp_get_dynamic_field_info( field_id ) {

	var dynamic_field_info = [];

	for ( var i = 0; i < gfp_dynamic_choices.field_info.length; i++ ) {

		if ( field_id == gfp_dynamic_choices.field_info[i].field_id ) {

			dynamic_field_info = gfp_dynamic_choices.field_info[i];

			break;
		}
	}

	return dynamic_field_info;
}

/**
 * @since
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 *
 * @param form_id
 * @param field_id
 */
function gfp_reset_dynamic_option_field( form_id, field_id ) {

	var field = jQuery( '#input_' + form_id + '_' + field_id );

	field.prop( 'disabled', true );

	var field_info = gfp_get_dynamic_field_info( field_id );

	switch( field_info['field_type'] ) {

		case 'select':

			field.html('<option value="' + field_info['placeholder']['value'] + '" selected="selected">' + field_info['placeholder']['text'] + '</option>');

		break;

		case 'radio':
		case 'checkbox':

			field.html( gfp_dynamic_choices.generating_options_message + '...');

			break;

    }
}

/**
 * @since
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 *
 * @param form_id
 * @param field_id
 * @param filter
 */
function gfp_apply_filters( form_id, field_id, filter ) {

	var filters = gfp_get_dynamic_choice_filters_for_field( field_id, form_id, filter );

	if ( 0 < filters.length ) {

		filters = gfp_build_dynamic_choice_filter( field_id, filters );

        var field_info = gfp_get_dynamic_field_info( field_id );

		var post_data = {action: 'gfp_get_dynamic_choices', form_id: form_id, field_id: field_id, feed_id: field_info['feed_id'], filters: filters};

		jQuery.post( gfp_dynamic_choices.ajaxurl, post_data ).done( function ( response ) {

			if ( true === response.success ) {

				var field = jQuery( '#input_' + form_id + '_' + field_id );

				field.html( response.data.options );

				field.prop( 'disabled', false );

				if ( true === response.data.trigger_change ) {
					field.change();
				}

			}

		} );
	}

}

/**
 * @since
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 *
 * @param field_id
 * @param form_id
 * @param filters
 * @returns {*}
 */
function gfp_get_dynamic_choice_filters_for_field( field_id, form_id, filters ) {

	var field_info = gfp_get_dynamic_field_info( field_id );

	if ( 1 < field_info['filtered_by'].length ) {

		for ( var i = 0; i < field_info['filtered_by'].length; i++ ) {

			var addl_filter_field_id = field_info['filtered_by'][i]['field_id'];

			if ( addl_filter_field_id != filters[0].field_id ) {

				var addl_filter_field_value = jQuery( '#input_' + form_id + '_' + addl_filter_field_id ).val();

				if ( 0 < addl_filter_field_value.length ) {

					filters[filters.length] = {field_id: addl_filter_field_id, value: addl_filter_field_value};

				}
				else {

					filters = [];

					break;

				}
			}
		}
	}

	return filters;
}

/**
 * @since
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 *
 * @param field_id
 * @param filter
 * @returns {*}
 */
function gfp_build_dynamic_choice_filter( field_id, filter ) {

	var field_info = gfp_get_dynamic_field_info( field_id );

	for ( var j = 0; j < filter.length; j++ ) {

		for ( var i = 0; i < field_info['filtered_by'].length; i++ ) {

			if ( field_info['filtered_by'][i]['field_id'] == filter[j].field_id ) {

				filter[j].column = field_info['filtered_by'][i]['column'];

				filter[j].operator = field_info['filtered_by'][i]['operator'];

				break;
			}
		}
	}

	return filter;
}