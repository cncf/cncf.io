/**
 * Salesforce source
 *
 * @since 1.3.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
jQuery(document).ready(function (jQuery) {

    gform.addFilter('gfp_dynamic_choice_filter_conditional_operators', 'gfp_dynamic_choice_filter_salesforce_conditional_operators');

    gform.addFilter( 'gfp_dynamic_choice_filter_conditional_fields', 'gfp_dynamic_choice_filter_salesforce_conditional_fields' );

    if ( 'record_list' === gfp_dynamic_population_salesforce_admin_strings.population_type ) {

        gform.removeFilter('gform_conditional_logic_values_input');

        gform.addFilter('gform_conditional_logic_values_input', 'gfp_dynamic_value_filter_salesforce_conditional_logic_values_input');

    }

});

/**
 * @see DynamicChoiceFilterConditionalOperators
 *
 * @since 1.3.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 *
 * @param operators
 * @param objectType
 * @param fieldId
 * @returns {*}
 */
function gfp_dynamic_choice_filter_salesforce_conditional_operators( operators, objectType, fieldId ) {

    if ( 'dynamic_choice_filter' === objectType
        && 'salesforce' === gfp_dynamic_population_admin_strings.feed_source
        && 'record_list' === gfp_dynamic_population_salesforce_admin_strings.population_type ) {

        gf_vars['doesNotContain'] = 'does not contain';

        operators = {"is":"is","isnot":"isNot", ">":"greaterThan", "<":"lessThan", "contains":"contains", "does_not_contain":"doesNotContain", "starts_with":"startsWith", "ends_with":"endsWith"};

    }

    return operators;
}

/**
 * @see DynamicChoiceFilterConditionalFields
 *
 * @since 1.3.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 *
 * @param options
 * @returns {*}
 * @constructor
 */
function gfp_dynamic_choice_filter_salesforce_conditional_fields( options ) {

        if ( 'salesforce' === gfp_dynamic_population_admin_strings.feed_source
            && 'record_list' === gfp_dynamic_population_salesforce_admin_strings.population_type ) {

            options = [];

            for ( var i = 0; i < gfp_dynamic_population_salesforce_admin_strings.filter_options.length; i++ ) {

                options.push( {
                    label: gfp_dynamic_population_salesforce_admin_strings.filter_options[i]['text'],
                    value: gfp_dynamic_population_salesforce_admin_strings.filter_options[i]['value']
                } );

            }

        }


    return options;
}

/**
 * @see GetRuleValues
 *
 * @since 1.3.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 *
 * @param str
 * @param objectType
 * @param ruleIndex
 * @param selectedFieldId
 * @param selectedValue
 * @returns {*}
 * @constructor
 */
function gfp_dynamic_value_filter_salesforce_conditional_logic_values_input( str, objectType, ruleIndex, selectedFieldId, selectedValue ) {

    if ( 'dynamic_choice_filter' === objectType && 'record_list' === gfp_dynamic_population_salesforce_admin_strings.population_type ) {

        if ( -1 !== str.indexOf( "<input type='text'") ) {

            var search = "onchange='SetRuleProperty(\"" + objectType + "\", " + ruleIndex + ", \"value\", jQuery(this).val());' onkeyup='SetRuleProperty(\"" + objectType + "\", " + ruleIndex + ", \"value\", jQuery(this).val());'";

            var replace = "onchange='SetRuleProperty(\"" + objectType + "\", " + ruleIndex + ", \"value\", jQuery(this).val());SetRuleProperty(\"" + objectType + "\", " + ruleIndex + ", \"custom_value\", true);' onkeyup='SetRuleProperty(\"" + objectType + "\", " + ruleIndex + ", \"value\", jQuery(this).val());SetRuleProperty(\"" + objectType + "\", " + ruleIndex + ", \"custom_value\", true);';"

            str = str.replace( search, replace );
        }

    }


    return str;
}