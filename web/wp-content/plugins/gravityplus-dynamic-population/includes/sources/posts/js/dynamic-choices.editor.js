/**
 * Posts source
 *
 * @since 1.5.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
jQuery(document).ready(function (jQuery) {

    gform.addAction('gfp_dynamic_choices_reset', 'gfp_dynamic_choices_reset_posts');

    gform.addAction('gfp_dynamic_choices_source_settings_reset', 'gfp_dynamic_choices_posts_settings_reset');

    gform.addAction('gfp_dynamic_choices_load_field_settings_set_source_settings', 'gfp_dynamic_choices_load_field_settings_set_posts_settings');


    gfp_dynamic_choices_posts_initialize_field_settings();

});

/**
 * Initialize field settings
 *
 * @since 1.5.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
function gfp_dynamic_choices_posts_initialize_field_settings() {

    jQuery('#gfp_dynamic_choices_source_post_type').change(gfp_dynamic_choices_source_posts_type_actions);

    jQuery('#gfp_dynamic_choices_source_posts_taxonomy').change(gfp_dynamic_choices_source_posts_taxonomy_actions);

    jQuery('#gfp_dynamic_choices_source_posts_taxonomy_term').change(gfp_dynamic_choices_source_posts_taxonomy_term_actions);

    jQuery('#gfp_dynamic_choices_source_posts_label').change(gfp_dynamic_choices_source_posts_label_actions);

    jQuery('#gfp_dynamic_choices_source_posts_value').change(gfp_dynamic_choices_source_posts_value_actions);

}

/**
 * Reset dynamic choices
 *
 * @since 1.5.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
function gfp_dynamic_choices_reset_posts() {

    if( 'undefined' == typeof( gfp_dynamic_population_posts_data.reset_posts_counter )) {

        gfp_dynamic_population_posts_data.reset_posts_counter = 1;

    }
    else {
        gfp_dynamic_population_posts_data.reset_posts_counter++;
    }

    SetFieldProperty('dynamicChoicesPostsType', '');

    jQuery('#gfp_dynamic_choices_source_post_type').val('');


    SetFieldProperty('dynamicChoicesPostsTaxonomy', '');

    jQuery('#gfp_dynamic_choices_source_posts_taxonomy').val('');


   gfp_dynamic_choices_posts_reset_dependents( 'taxonomy' );


    SetFieldProperty('dynamicChoicesPostsLabel', '');

    jQuery('#gfp_dynamic_choices_source_posts_label').val('');


    SetFieldProperty('dynamicChoicesPostsValue', '');

    jQuery('#gfp_dynamic_choices_source_posts_value').val('');

}

/**
 * @since 1.5.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
function gfp_dynamic_choices_posts_reset_dependents( item ) {

    switch( item ) {

        case 'taxonomy':

            SetFieldProperty('dynamicChoicesPostsTaxonomyTerm', '');

            jQuery( '#gfp_dynamic_choices_source_posts_taxonomy_term' ).html( '' ).prop( 'disabled', true );


            jQuery( '#dynamic_choice_conditional_logic').prop( 'checked', false );

            SetDynamicChoiceConditionalLogic(false);

            ToggleConditionalLogic(false, 'dynamic_choice');

            jQuery( '.conditional_logic_dynamic_choice_setting').hide();


            break;
    }

}

/**
 * Reset source settings
 *
 * @since 1.5.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 *
 * @param source
 */
function gfp_dynamic_choices_posts_settings_reset(source) {

    if ('posts' === source) {

        gfp_dynamic_choices_reset_posts();

    }

}

/**
 * Load field settings when source is posts
 *
 * @since 1.5.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
function gfp_dynamic_choices_load_field_settings_set_posts_settings(source) {

    if ('posts' === source) {

        jQuery('#gfp_dynamic_choices_source_post_type').val(field['dynamicChoicesPostsType']);


        jQuery('#gfp_dynamic_choices_source_posts_taxonomy').val(field['dynamicChoicesPostsTaxonomy']);


        jQuery('#gfp_dynamic_choices_source_posts_taxonomy_term').val(field['dynamicChoicesPostsTaxonomyTerm']);


        jQuery('#gfp_dynamic_choices_source_posts_label').val( field['dynamicChoicesPostsLabel'] );


        jQuery('#gfp_dynamic_choices_source_posts_value').val( field['dynamicChoicesPostsValue'] );


        gfp_dynamic_choices_posts_load_current_settings( field['dynamicChoicesPostsTaxonomyTerm'] );


        gform.addFilter('gform_conditional_logic_description', 'gfp_dynamic_choice_posts_gform_conditional_logic_description');

        gform.addFilter('gform_conditional_logic_operators', 'gfp_dynamic_choice_posts_gform_conditional_logic_operators');

        gform.addFilter('gform_conditional_logic_values_input', 'gfp_dynamic_choice_posts_gform_conditional_logic_values_input');


        LoadFieldConditionalLogic(true, 'dynamic_choice');

    }

}

/**
 *
 * @since 1.5.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 *
 * @param taxonomy_term
 */
function gfp_dynamic_choices_posts_load_current_settings(taxonomy_term ) {

    if ( 0 !== gfp_dynamic_population_posts_data.current_settings.length ) {

        var field_options = gfp_dynamic_population_posts_data.current_settings[GetSelectedField()['id']];

        var placeholder = "<option value=''>-- " + gfp_dynamic_population_posts_data.placeholders['taxonomy_term'] + GetSelectedField()['dynamicChoicesPostsTaxonomy'] + " --</option>";

        jQuery( '#gfp_dynamic_choices_source_posts_taxonomy_term' ).html( gfp_dynamic_choices_get_options_html( field_options['taxonomy_term'], taxonomy_term, placeholder ) ).prop( 'disabled', false );

    }
}


/**
 *
 * @since 1.5.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
function gfp_dynamic_choices_source_posts_type_actions() {

    SetFieldProperty('dynamicChoicesPostsType', jQuery(this).val());

    SetFieldProperty('dynamicChoicesPostsTaxonomy', 'all');

    SetFieldProperty('dynamicChoicesPostsTaxonomyTerm', 'all');

}

/**
 *
 * @since 1.5.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
function gfp_dynamic_choices_source_posts_taxonomy_actions() {

    gfp_dynamic_choices_posts_reset_dependents( 'taxonomy' );

    var taxonomy = jQuery( this ).val();

    SetFieldProperty('dynamicChoicesPostsTaxonomy', taxonomy );

    gfp_dynamic_population_posts_data.chosen_taxonomy = taxonomy;

    if ( 'all' !== taxonomy ) {

        gfp_dynamic_choices_source_posts_load_terms(taxonomy);

    }

    gform.addFilter('gform_conditional_logic_description', 'gfp_dynamic_choice_posts_gform_conditional_logic_description');

    gform.addFilter('gform_conditional_logic_operators', 'gfp_dynamic_choice_posts_gform_conditional_logic_operators');

    gform.addFilter('gform_conditional_logic_values_input', 'gfp_dynamic_choice_posts_gform_conditional_logic_values_input');


    LoadFieldConditionalLogic(true, 'dynamic_choice');


    jQuery('.conditional_logic_dynamic_choice_setting').show('slow');

}

/**
 *
 * @since 1.5.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
function gfp_dynamic_choices_source_posts_taxonomy_term_actions() {

    SetFieldProperty('dynamicChoicesPostsTaxonomyTerm', jQuery(this).val());




}

/**
 *
 * @since 1.5.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
function gfp_dynamic_choices_source_posts_label_actions() {

    SetFieldProperty('dynamicChoicesPostsLabel', jQuery(this).val());

}

/**
 *
 * @since 1.5.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
function gfp_dynamic_choices_source_posts_value_actions() {

    SetFieldProperty('dynamicChoicesPostsValue', jQuery(this).val());

}

/**
 * @since 1.5.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 *
 * @param taxonomy
 */
function gfp_dynamic_choices_source_posts_load_terms( taxonomy ) {

    var post_data = {action: 'gfp_dynamic_population_posts_get_terms', taxonomy: taxonomy};

    jQuery.post( ajaxurl, post_data ).done( function ( response ) {

        if ( true === response.success ) {

            jQuery( '#gfp_dynamic_choices_source_posts_taxonomy_term' ).html( response.data.options ).prop( 'disabled', false );

            SetFieldProperty('dynamicChoicesPostsTaxonomyTerm', 'all');

        }

    } );

}

/**
 * @since 1.5.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 *
 * @param str
 * @param descPieces
 * @param objectType
 * @param obj
 * @returns {*}
 */
function gfp_dynamic_choice_posts_gform_conditional_logic_description( str, descPieces, objectType, obj ) {

    if ( 'dynamic_choice' === objectType && obj.conditionalLogic ) {

        var showSelected = obj.conditionalLogic.actionType == "show" ? "selected='selected'" : "";
        var allSelected = obj.conditionalLogic.logicType == "all" ? "selected='selected'" : "";

        descPieces.actionType = "<select id='" + objectType + "_action_type' onchange='SetConditionalProperty(\"" + objectType + "\", \"actionType\", jQuery(this).val());'><option value='show' " + showSelected + ">" + gf_vars.show + "</option></select>";
        descPieces.objectDescription = gfp_dynamic_population_posts_data.choice_filter_strings['objectDescription'];
        descPieces.logicType = "<select id='" + objectType + "_logic_type' onchange='SetConditionalProperty(\"" + objectType + "\", \"logicType\", jQuery(this).val());'><option value='all' " + allSelected + ">" + gf_vars.all + "</option></select>";

        var descPiecesArr = makeArray( descPieces );

        str = descPiecesArr.join( ' ' );

        var rules_container_header = '<div width="100%" class="gf_conditional_logic_rules_container_header"><br /><span class="inline"><strong>' + gfp_dynamic_population_posts_data.choice_filter_strings['form_field_header'] + '</strong></span><span class="inline" style="float: right;margin-right: 69px;"><strong>' + gfp_dynamic_population_posts_data.choice_filter_strings['values_column_header'] + '</strong></span></div>';

        str += rules_container_header;
    }

    return str;
}

/**
 * @since 1.5.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 *
 * @param operators
 * @param objectType
 * @param fieldId
 * @returns {*}
 */
function gfp_dynamic_choice_posts_gform_conditional_logic_operators( operators, objectType, fieldId ) {

    if ( 'dynamic_choice' === objectType ) {

        operators = {"is": "is"};

    }

    return operators;
}

/**
 * @since 1.5.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 *
 * @param str
 * @param objectType
 * @param ruleIndex
 * @param selectedFieldId
 * @param selectedValue
 * @returns {*}
 */
function gfp_dynamic_choice_posts_gform_conditional_logic_values_input( str, objectType, ruleIndex, selectedFieldId, selectedValue ) {

    if ( 'dynamic_choice' === objectType ) {

        var options = [];

        for ( var i = 0; i < gfp_dynamic_population_posts_data.filter_options.length; i++ ) {

                options.push( {
                    text: gfp_dynamic_population_posts_data.filter_options[i]['text'],
                    value: gfp_dynamic_population_posts_data.filter_options[i]['value']
                } );

        }

        str = GetRuleValuesDropDown( options, objectType, ruleIndex, selectedValue, false );
    }

    return str;
}