/**
 * Taxonomy source
 *
 * @since 1.5.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
jQuery(document).ready(function (jQuery) {

    gform.addAction('gfp_dynamic_choices_reset', 'gfp_dynamic_choices_reset_taxonomy');

    gform.addAction('gfp_dynamic_choices_source_settings_reset', 'gfp_dynamic_choices_taxonomy_settings_reset');

    gform.addAction('gfp_dynamic_choices_load_field_settings_set_source_settings', 'gfp_dynamic_choices_load_field_settings_set_taxonomy_settings');


    gfp_dynamic_choices_taxonomy_initialize_field_settings();

});

/**
 * Initialize field settings
 *
 * @since 1.5.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
function gfp_dynamic_choices_taxonomy_initialize_field_settings() {

    jQuery('#gfp_dynamic_choices_source_taxonomy_name').change(gfp_dynamic_choices_source_taxonomy_name_actions);

    jQuery('#gfp_dynamic_choices_source_taxonomy_label').change(gfp_dynamic_choices_source_taxonomy_label_actions);

    jQuery('#gfp_dynamic_choices_source_taxonomy_value').change(gfp_dynamic_choices_source_taxonomy_value_actions);

}

/**
 * Reset dynamic choices
 *
 * @since 1.5.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
function gfp_dynamic_choices_reset_taxonomy() {

    SetFieldProperty('dynamicChoicesTaxonomyName', '');

    jQuery('#gfp_dynamic_choices_source_taxonomy_name').val('');


    SetFieldProperty('dynamicChoicesTaxonomyObject', '');


    SetFieldProperty('dynamicChoicesTaxonomyLabel', '');

    jQuery('#gfp_dynamic_choices_source_taxonomy_label').val('');


    SetFieldProperty('dynamicChoicesTaxonomyValue', '');

    jQuery('#gfp_dynamic_choices_source_taxonomy_value').val('');

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
function gfp_dynamic_choices_taxonomy_settings_reset(source) {

    if ('taxonomy' === source) {

        gfp_dynamic_choices_reset_taxonomy();

    }

}

/**
 * Load field settings when source is taxonomy
 *
 * @since 1.5.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
function gfp_dynamic_choices_load_field_settings_set_taxonomy_settings(source) {

    if ('taxonomy' === source) {

        jQuery('#gfp_dynamic_choices_source_taxonomy_name').val(field['dynamicChoicesTaxonomyName']);


        jQuery('#gfp_dynamic_choices_source_taxonomy_label').val( field['dynamicChoicesTaxonomyLabel'] );


        jQuery('#gfp_dynamic_choices_source_taxonomy_value').val( field['dynamicChoicesTaxonomyValue'] );


        jQuery('.conditional_logic_dynamic_choice_setting').hide();

    }

}

/**
 *
 * @since 1.5.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
function gfp_dynamic_choices_source_taxonomy_name_actions() {

    SetFieldProperty('dynamicChoicesTaxonomyName', jQuery(this).val());

    SetFieldProperty('dynamicChoicesTaxonomyObject', 'all');

}

/**
 *
 * @since 1.5.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
function gfp_dynamic_choices_source_taxonomy_label_actions() {

    SetFieldProperty('dynamicChoicesTaxonomyLabel', jQuery(this).val());

}

/**
 *
 * @since 1.5.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
function gfp_dynamic_choices_source_taxonomy_value_actions() {

    SetFieldProperty('dynamicChoicesTaxonomyValue', jQuery(this).val());

}