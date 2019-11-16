/**
 * @since 2.0.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 *
 * @param args
 * @constructor
 */
var DynamicChoiceFilterObj = function( args ) {

    this.strings = isSet( args.strings ) ? args.strings : {};
    this.logicObject = args.logicObject;

    this.init = function() {

        var dcfobj = this;

        gform.addFilter( 'gform_conditional_object', 'DynamicChoiceFilterConditionalObject' );

        gform.addFilter( 'gform_conditional_logic_description', 'DynamicChoiceFilterConditionalDescription' );

        gform.addFilter('gform_conditional_logic_operators', 'DynamicChoiceFilterConditionalOperators');

        gform.addFilter( 'gform_conditional_logic_fields', 'DynamicChoiceFilterConditionalFields' );

        gform.addFilter('gform_conditional_logic_values_input', 'DynamicChoiceFilterConditionalValuesInput');


        jQuery(document).ready(function(){

            ToggleConditionalLogic( true, "dynamic_choice_filter" );

        });

        jQuery('input#dynamic_choice_filter_conditional_logic').parents('form').on('submit', function() {

            jQuery('input#dynamic_choice_filter_conditional_logic_object').val( JSON.stringify( dcfobj.logicObject ) );

        });

    };

    this.init();

};

/**
 * @see GetConditionalObject
 *
 * @since 2.0.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 *
 * @param object
 * @param objectType
 * @returns {*}
 * @constructor
 */
function DynamicChoiceFilterConditionalObject( object, objectType ) {

    if( 'dynamic_choice_filter' != objectType ) {

        return object;

    }

    return dynamicChoiceFilter.logicObject;
}

/**
 * @see CreateConditionalLogic
 *
 * @since 2.0.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 *
 * @param description
 * @param descPieces
 * @param objectType
 * @param obj
 * @returns {*}
 * @constructor
 */
function DynamicChoiceFilterConditionalDescription( description, descPieces, objectType, obj ) {

    if( 'dynamic_choice_filter' != objectType ) {

        return description;

    }

    var allSelected = obj.conditionalLogic.logicType == "all" ? "selected='selected'" :"";

    descPieces.actionType = descPieces.actionType.replace('<select', '<select style="display:none;"');

    descPieces.objectDescription = dynamicChoiceFilter.strings.objectDescription;

    descPieces.logicType = "<select id='" + objectType + "_logic_type' onchange='SetConditionalProperty(\"" + objectType + "\", \"logicType\", jQuery(this).val());'><option value='all' " + allSelected + ">" + gf_vars.all + "</option></select>";


    var descPiecesArr = makeArray( descPieces );

    description = descPiecesArr.join(' ');


    var filter_container_header = '<div width="100%" class="gf_conditional_logic_rules_container_header"><br /><span class="inline" style="width:120px;"><strong>' + dynamicChoiceFilter.strings.fields_column_header + '</strong></span><span class="inline" style="width:120px;">&nbsp;</span><span class="inline" style="width:120px;"><strong>' + dynamicChoiceFilter.strings.values_column_header + '</strong></span></div>';

    description += filter_container_header;

    dynamicChoiceFilter.rules_to_set = obj.conditionalLogic.rules.length;


    return description;
}

/**
 * @see GetRuleOperators
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
function DynamicChoiceFilterConditionalOperators( operators, objectType, fieldId ) {

    if ( 'dynamic_choice_filter' === objectType ) {

        operators = gform.applyFilters( 'gfp_dynamic_choice_filter_conditional_operators', {"is": "is", "contains": "contains", "starts_with": "startsWith", "ends_with": "endsWith"}, objectType, fieldId );

    }

    return operators;
}

/**
 * @see GetRuleFields
 *
 * @since 2.0.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 *
 * @param options
 * @param form
 * @param selectedFieldId
 * @returns {*}
 * @constructor
 */
function DynamicChoiceFilterConditionalFields( options, form, selectedFieldId ) {

    if ( 'undefined' !== typeof( dynamicChoiceFilter.rules_to_set ) && 0 < dynamicChoiceFilter.rules_to_set ) {

        if ( 'wpdb' === gfp_dynamic_population_admin_strings.feed_source ) {

            options = [];

            var wpdb_value_table_column = gfp_dynamic_population_admin_strings.feed_wpdb_value_table_column;

            var wpdb_table_columns = gfp_dynamic_population_admin_strings.feed_wpdb_table_columns;

            for (var i = 0; i < wpdb_table_columns.length; i++) {

                if (wpdb_value_table_column !== wpdb_table_columns[i]) {

                    options.push({
                        label: wpdb_table_columns[i],
                        value: wpdb_table_columns[i]
                    });

                }

            }

        }

        options = gform.applyFilters( 'gfp_dynamic_choice_filter_conditional_fields', options );

        dynamicChoiceFilter.rules_to_set -= 1;

    }


    return options;
}

/**
 * @see GetRuleValues
 *
 * @since 2.0.0
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
function DynamicChoiceFilterConditionalValuesInput( str, objectType, ruleIndex, selectedFieldId, selectedValue ) {

    if ( 'dynamic_choice_filter' === objectType ) {

            var options = [];

            for( var i = 0; i < form.fields.length; i++ ) {

                var field = form.fields[i];

                if( ( field.id != gfp_dynamic_population_admin_strings.feed_field_to_populate ) && IsConditionalLogicField( field ) ) {

                    if( field.inputs && jQuery.inArray( GetInputType( field ), [ 'checkbox', 'email' ] ) == -1 ) {

                        for( var j = 0; j < field.inputs.length; j++ ) {

                            var input = field.inputs[j];

                            if( ! input.isHidden ) {

                                options.push( {
                                    text: GetLabel( field, input.id ),
                                    value: input.id
                                } );

                            }

                        }

                    } else {

                        options.push( {
                            text: GetLabel( field ),
                            value: field.id
                        } );

                    }

                }

            }

            // get entry meta fields and append to existing fields
            jQuery.merge(options, GetEntryMetaFields( selectedFieldId ) );


        options = gform.applyFilters( 'gfp_dynamic_choice_filter_conditional_values_options', options );


        str = GetRuleValuesDropDown( options, objectType, ruleIndex, selectedValue, false );

    }


    return str;
}