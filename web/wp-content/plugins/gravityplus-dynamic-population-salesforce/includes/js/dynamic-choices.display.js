/**
 * Dynamically populate form with Salesforce record
 *
 * @since 1.2.0
 */
jQuery( document ).on( 'gform_post_render', gfp_add_dynamic_salesforce_events );


function gfp_add_dynamic_salesforce_events( event, form_id, current_page ) {

    if ( form_id == gfp_dynamic_salesforce.form_id ) {

        for (var i = 0; i < gfp_dynamic_salesforce.search_fields.length; i++) {

            jQuery( '#input_' + gfp_dynamic_salesforce.form_id + '_' + gfp_dynamic_salesforce.search_fields[i].replace('.', '_') ).change( {
                field_id: gfp_dynamic_salesforce.search_fields[i],
                form_id: form_id
            }, gfp_maybe_populate_salesforce_record );

        }

    }
}

function gfp_maybe_populate_salesforce_record( event ) {

    var field_id = event.data.field_id;

    if ( 'undefined' == typeof( gfp_dynamic_salesforce.search_field_values ) ) {

        gfp_dynamic_salesforce.search_field_values = {};

    }

    var field_value = jQuery(this).val();

    var search_field_count = {}, field_in_feeds = [];

    for (var feed_id in gfp_dynamic_salesforce.field_info) {

        if (gfp_dynamic_salesforce.field_info.hasOwnProperty(feed_id)) {

            search_field_count[feed_id] = gfp_dynamic_salesforce.field_info[feed_id].length;

            if ( 'undefined' == typeof( gfp_dynamic_salesforce.search_field_values[feed_id] ) ) {

                gfp_dynamic_salesforce.search_field_values[feed_id] = {};

            }

            for (var i = 0; i < search_field_count[feed_id]; i++) {

                if ( ( field_id == gfp_dynamic_salesforce.field_info[feed_id][i] ) && 0 < field_value.length ) {

                    field_in_feeds.push( feed_id );

                    gfp_dynamic_salesforce.search_field_values[feed_id][field_id] = field_value;


                    break;
                }

            }

        }

    }

    for (var p = 0; p < field_in_feeds.length; p++) {

        feed_id = field_in_feeds[p];

        if ( Object.keys(gfp_dynamic_salesforce.search_field_values[feed_id]).length == search_field_count[feed_id] ) {

            gfp_populate_salesforce_record(event.data.form_id, feed_id );

        }

    }

}

function gfp_populate_salesforce_record( form_id, feed_id ) {

    gfp_disable_form_elements( form_id );

		var post_data = {
		    action: 'gfp_get_salesforce_record',
            feed_id: feed_id
		};

    Object.keys( gfp_dynamic_salesforce.search_field_values[feed_id] ).forEach( function( key ){

        post_data['field_' + key ] = gfp_dynamic_salesforce.search_field_values[feed_id][key];

    } );

		jQuery.post({
            url: gfp_dynamic_salesforce.ajaxurl,
            data: post_data,
            context: form_id
		    } )
            .done( function ( response ) {

                    if ( true === response.success ) {

                        response.data.field_values.forEach( function( key, index ) {

                            jQuery('#input_' + form_id + '_' + response.data.field_values[index].field_id.replace('.', '_') ).val( response.data.field_values[index].value );

                        });

                    }

                    gfp_enable_form_elements( form_id );

				//if ( true === response.data.trigger_change ) {
					//field.change();
				//}

			//jQuery( '#gform_ajax_spinner_' + form_id + '_dynamic_choice' ).remove();
		} );

}

function gfp_disable_form_elements( form_id ){

    var inputs = document.getElementById('gform_' + form_id).elements;

    for (i = 0; i < inputs.length; i++) {

        inputs[i].setAttribute('disabled', '');

    }

}

function gfp_enable_form_elements( form_id ){

    var inputs = document.getElementById('gform_' + form_id).elements;

    for (i = 0; i < inputs.length; i++) {

        inputs[i].removeAttribute('disabled');

    }

}