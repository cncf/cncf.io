/**
 * Users source
 *
 * @since 2.0.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
jQuery(document).ready(function (jQuery) {

    gform.addFilter('gfp_dynamic_choice_filter_conditional_operators', 'gfp_dynamic_choice_filter_users_conditional_operators');

    gform.addFilter( 'gfp_dynamic_choice_filter_conditional_fields', 'gfp_dynamic_choice_filter_users_conditional_fields' );

});

/**
 * @see DynamicChoiceFilterConditionalOperators
 *
 * @since 2.0.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 *
 * @param operators
 * @param objectType
 * @param fieldId
 * @returns {*}
 */
function gfp_dynamic_choice_filter_users_conditional_operators( operators, objectType, fieldId ) {

    if ( 'dynamic_choice_filter' === objectType && 'users' === gfp_dynamic_population_admin_strings.feed_source ) {

        operators = {"is": "is","isnot":"isNot"};

    }

    return operators;
}

/**
 * @see DynamicChoiceFilterConditionalFields
 *
 * @since 2.0.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 *
 * @param options
 * @returns {*}
 * @constructor
 */
function gfp_dynamic_choice_filter_users_conditional_fields( options ) {

        if ( 'users' === gfp_dynamic_population_admin_strings.feed_source ) {

            options = [];

            for ( var i = 0; i < gfp_dynamic_population_users_admin_strings.filter_options.length; i++ ) {

                options.push( {
                    label: gfp_dynamic_population_users_admin_strings.filter_options[i]['text'],
                    value: gfp_dynamic_population_users_admin_strings.filter_options[i]['value']
                } );

            }

        }


    return options;
}