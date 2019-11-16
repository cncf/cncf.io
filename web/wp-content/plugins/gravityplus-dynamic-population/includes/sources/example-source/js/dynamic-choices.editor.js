/**
 * Example source
 *
 * @since 1.4.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
jQuery(document).ready(function (jQuery) {

    gform.addAction('gfp_dynamic_choices_reset', 'gfp_dynamic_choices_reset_example');

    gform.addAction('gfp_dynamic_choices_source_settings_reset', 'gfp_dynamic_choices_example_settings_reset');

    gform.addAction('gfp_dynamic_choices_load_field_settings_set_source_settings', 'gfp_dynamic_choices_load_field_settings_set_example_settings');


    gfp_dynamic_choices_example_initialize_field_settings();

});

/**
 * Initialize field settings
 *
 * @since 1.5.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
function gfp_dynamic_choices_example_initialize_field_settings() {

    jQuery('#gfp_dynamic_choices_source_example_something').change(gfp_dynamic_choices_source_example_something_actions);

    jQuery('#gfp_dynamic_choices_source_example_something_dependent').change(gfp_dynamic_choices_source_example_something_dependent_actions);

}

/**
 * Reset dynamic choices
 *
 * @since 1.4.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
function gfp_dynamic_choices_reset_example() {

    SetFieldProperty('dynamicChoicesExampleSomething', '');

    jQuery('#gfp_dynamic_choices_source_example_something').val('');


    SetFieldProperty('dynamicChoicesExampleSomethingDependent', '');

    var example_something_dependent = jQuery('#gfp_dynamic_choices_source_example_something_dependent');

    example_something_dependent.html('');

    example_something_dependent.prop( 'disabled', true );

}

/**
 * Reset source settings
 *
 * @since 1.4.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 *
 * @param source
 */
function gfp_dynamic_choices_example_settings_reset(source) {

    if ('example' === source) {

        SetFieldProperty('dynamicChoicesExampleSomething', '');

        jQuery('#gfp_dynamic_choices_source_example_something').val('');


        SetFieldProperty('dynamicChoicesExampleSomethingDependent', '');

        var example_something_dependent = jQuery('#gfp_dynamic_choices_source_example_something_dependent');

        example_something_dependent.html('');

        example_something_dependent.prop( 'disabled', true );

    }

}

/**
 * Load field settings when source is example
 *
 * @since 1.4.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
function gfp_dynamic_choices_load_field_settings_set_example_settings(source) {

    if ('example' === source) {

        var source_example_something = jQuery('#gfp_dynamic_choices_source_example_something');

        source_example_something.val(field['dynamicChoicesExampleSomething']);


        jQuery('#gfp_dynamic_choices_source_example_something_dependent').val( field['dynamicChoicesExampleSomethingDependent'] );


        gfp_dynamic_choices_example_load_dependent(field['dynamicChoicesExampleSomething']);


        jQuery('.conditional_logic_dynamic_choice_setting').hide();

    }

}

/**
 *
 * @since 1.4.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
function gfp_dynamic_choices_source_example_something_actions() {

    SetFieldProperty('dynamicChoicesExampleSomething', jQuery(this).val());

    gfp_dynamic_choices_example_load_dependent(jQuery(this).val());

}

/**
 * @since 1.4.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
function gfp_dynamic_choices_source_example_something_dependent_actions() {

    SetFieldProperty( 'dynamicChoicesExampleSomethingDependent', jQuery( this ).val() );

}

/**
 * @since 1.4.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 *
 * @param something
 */
function gfp_dynamic_choices_example_load_dependent(something) {

    var dependent_options = gfp_dynamic_population_example_data.dependents[something];

    var dependent_field = jQuery('#gfp_dynamic_choices_source_example_something_dependent');

    dependent_field.html(gfp_dynamic_choices_example_get_dependent_options_html(dependent_options, field['dynamicChoicesExampleSomethingDependent']));

    dependent_field.prop( 'disabled', false );

}

/**
 *
 * @since 1.4.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 *
 * @param dependent_options
 * @param selected_dependent
 * @returns {*}
 */
function gfp_dynamic_choices_example_get_dependent_options_html( dependent_options, selected_dependent ) {

    var str = gfp_dynamic_population_example_data.select_dependent_placeholder;

    var isAnySelected = false;


    for (var i = 0; i < dependent_options.length; i++) {

        var choiceValue = dependent_options[i];
        var isSelected = choiceValue == selected_dependent;
        var selected = isSelected ? "selected='selected'" : "";

        if (isSelected) {

            isAnySelected = true;

        }

        str += "<option value='" + choiceValue.replace(/'/g, "&#039;") + "' " + selected + ">" + dependent_options[i] + "</option>";

    }

    if (!isAnySelected && selected_dependent && '' != selected_dependent) {

        str += "<option value='" + selected_dependent.replace(/'/g, "&#039;") + "' selected='selected'>" + selected_dependent + "</option>";

    }

    return str;
}