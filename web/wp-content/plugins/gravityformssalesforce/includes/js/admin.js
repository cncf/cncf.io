/**
 * @since 1.3.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 *
 * @param args
 * @constructor
 */

jQuery( 'document' ).ready( function() {

    if ( 'undefined' !== typeof( genericMapother_fields ) ) {

        genericMapother_fields.UI.closest('form').on('submit', function (event) {

            var other_fields = jQuery('#other_fields');

            var other_fields_value = other_fields.val();

            if ( '' === other_fields_value ) {

                return;
            }

            if( '[]' === other_fields_value ) {

                other_fields.val( "" );

                return;
            }

            var data = jQuery.parseJSON(other_fields_value);

            data = jQuery.extend({}, data);

            for (var i = 0; i < Object.keys(data).length; i++) {

                data[i].type = jQuery('.key_' + i).find('option:selected').data('type');

            }

            var updated_data = JSON.stringify(data);

            other_fields.val(updated_data);

        });

    }

});