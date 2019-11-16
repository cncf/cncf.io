/**
 * Salesforce source
 *
 * @since 1.0.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
jQuery( document ).ready( function ( jQuery ) {

    gform.addAction('gfp_dynamic_choices_reset', 'gfp_dynamic_choices_reset_salesforce');

    gform.addAction('gfp_dynamic_choices_source_settings_reset', 'gfp_dynamic_choices_salesforce_settings_reset');

    gform.addAction( 'gfp_dynamic_choices_source_select', 'gfp_dynamic_choices_source_salesforce_select' );

    gform.addAction('gfp_dynamic_choices_load_field_settings_set_source_settings', 'gfp_dynamic_choices_load_field_settings_set_salesforce_settings');


    gfp_dynamic_choices_salesforce_initialize_field_settings();

} );

/**
 * Initialize field settings
 *
 * @since 1.1.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
function gfp_dynamic_choices_salesforce_initialize_field_settings() {

    jQuery( '#gfp_dynamic_choices_source_salesforce_object' ).change( gfp_dynamic_choices_salesforce_select_object_actions );

    jQuery( '#gfp_dynamic_choices_source_salesforce_object_field' ).change( gfp_dynamic_choices_salesforce_select_object_field_actions );

}

/**
 * @since 1.0.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
function gfp_dynamic_choices_salesforce_reset_dependents( item ) {

	switch( item ){

		case 'sobject':

            SetFieldProperty( 'dynamicChoicesSalesforceObjectField', '' );
            jQuery( '#gfp_dynamic_choices_source_salesforce_object_field' ).html( '' ).prop( 'disabled', true );

			break;
	}

}

/**
 * Reset dynamic choices
 *
 * @since 1.0.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
function gfp_dynamic_choices_reset_salesforce() {

	SetFieldProperty( 'dynamicChoicesSalesforceObject', '' );
    jQuery( '#gfp_dynamic_choices_source_salesforce_object' ).val('');

    gfp_dynamic_choices_salesforce_reset_dependents('sobject');

}

/**
 * Reset source settings
 *
 * @since 1.0.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 *
 * @param source
 */
function gfp_dynamic_choices_salesforce_settings_reset(source) {

    if ('salesforce' === source) {

        gfp_dynamic_choices_reset_salesforce();

    }

}

/**
 * Load field settings when source is Salesforce
 *
 * @since 1.0.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
function gfp_dynamic_choices_load_field_settings_set_salesforce_settings(source) {

    if ('salesforce' === source) {

        jQuery( '#gfp_dynamic_choices_source_salesforce_object' ).val( field['dynamicChoicesSalesforceObject'] );

        jQuery( '#gfp_dynamic_choices_source_salesforce_object_field' ).val( field['dynamicChoicesSalesforceObjectField'] );


		gfp_dynamic_choices_salesforce_load_current_settings( field['dynamicChoicesSalesforceObject'], field['dynamicChoicesSalesforceObjectField'] );


		jQuery('.conditional_logic_dynamic_choice_setting').hide();

    }

}

/**
 *
 * @since 1.0.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 *
 * @param sobject
 * @param object_field
 */
function gfp_dynamic_choices_salesforce_load_current_settings(sobject, object_field ) {

    if ( 0 !== gfp_dynamic_population_salesforce_data.current_settings.length ) {

        var field_options = gfp_dynamic_population_salesforce_data.current_settings[GetSelectedField()['id']];

        jQuery( '#gfp_dynamic_choices_source_salesforce_object_field' ).html( gfp_dynamic_choices_get_options_html( field_options['object_field'], object_field, gfp_dynamic_population_salesforce_data.placeholders['object_field'] ) ).prop( 'disabled', false );

    }
}

/**
 * @since 1.0.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 *
 * @param source
 */
function gfp_dynamic_choices_source_salesforce_select( source ) {

    if( 'salesforce' == source ) {

        gfp_dynamic_choices_salesforce_settings_reset( source );

    }

}

/**
 * @since 1.0.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
function gfp_dynamic_choices_salesforce_select_object_actions() {

    gfp_dynamic_choices_salesforce_reset_dependents( 'sobject' );

    var sobject = jQuery( this ).val();

    SetFieldProperty( 'dynamicChoicesSalesforceObject', sobject );

    gfp_dynamic_population_salesforce_data.chosen_object = sobject;

    gfp_dynamic_choices_salesforce_load_object_fields( sobject );

}

/**
 * @since 1.0.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
function gfp_dynamic_choices_salesforce_select_object_field_actions() {

    var object_field = jQuery( this ).val();

    SetFieldProperty( 'dynamicChoicesSalesforceObjectField', object_field );

    gfp_dynamic_population_salesforce_data.chosen_object_field = object_field;

}

/**
 * @since 1.0.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 *
 * @param sobject
 */
function gfp_dynamic_choices_salesforce_load_object_fields(sobject ) {

    var post_data = {action: 'gfp_dynamic_population_salesforce_get_picklist_fields', sobject: sobject};

    jQuery.post( ajaxurl, post_data ).done( function ( response ) {

        if ( true === response.success ) {

            jQuery( '#gfp_dynamic_choices_source_salesforce_object_field' ).html( response.data.options ).prop( 'disabled', false );

        }

    } );

}