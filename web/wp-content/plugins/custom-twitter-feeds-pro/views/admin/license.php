<?php

//License page
// function ctf_license_page() {
$ctf_license    = trim( get_option( 'ctf_license_key' ) );
$ctf_status     = get_option( 'ctf_license_status' );

?>

<form name="form1" method="post" action="options.php">

<?php
// Get license data to see whether it's expired so we can display "Expired" text
$ctf_api_params = array(
    'edd_action'=> 'check_license',
    'license'   => $ctf_license,
    'item_name' => urlencode( CTF_PRODUCT_NAME ) // the name of our product in EDD
);

// Call the custom API.
$ctf_response = wp_remote_get( add_query_arg( $ctf_api_params, CTF_STORE_URL ), array( 'timeout' => 60, 'sslverify' => false ) );

// decode the license data
$ctf_license_data = (array) json_decode( wp_remote_retrieve_body( $ctf_response ) );

//Store license data in db unless the data comes back empty as wasn't able to connect to our website to get it
if( !empty($ctf_license_data) ) update_option( 'ctf_license_data', $ctf_license_data );

?>

<?php settings_fields('ctf_license'); ?>

<table class="form-table">
    <tbody>
    <h3><?php _e('License'); ?></h3>

    <tr valign="top">
        <th scope="row" valign="top">
            <?php _e('Enter your license key'); ?>
        </th>
        <td>
            <input id="ctf_license_key" name="ctf_license_key" type="text" class="regular-text" value="<?php esc_attr_e( $ctf_license ); ?>" />

            <?php if( false !== $ctf_license ) { ?>

                <?php if( $ctf_status !== false && $ctf_status == 'valid' ) { ?>
                    <?php wp_nonce_field( 'ctf_nonce', 'ctf_nonce' ); ?>
                    <input type="submit" class="button-secondary" name="ctf_license_deactivate" value="<?php _e('Deactivate License'); ?>"/>

                    <?php if($ctf_license_data['license'] == 'expired'){ ?>
                        <span class="ctf_license_status" style="color:red;"><?php _e('Expired'); ?></span>
                    <?php } else { ?>
                        <span class="ctf_license_status" style="color:green;"><?php _e('Active'); ?></span>
                    <?php } ?>

                <?php } else {
                    wp_nonce_field( 'ctf_nonce', 'ctf_nonce' ); ?>
                    <input type="submit" class="button-secondary" name="ctf_license_activate" value="<?php _e('Activate License'); ?>"/>

                    <?php if($ctf_license_data['license'] == 'expired'){ ?>
                        <span class="ctf_license_status" style="color:red;"><?php _e('Expired'); ?></span>
                    <?php } else { ?>
                        <span class="ctf_license_status" style="color:red;"><?php _e('Inactive'); ?></span>
                    <?php } ?>

                <?php } ?>
            <?php } ?>

            <br />
            <i style="color: #666; font-size: 11px;"><?php _e('The license key you received when purchasing the plugin.'); ?></i>
            <p style="font-size: 13px;">
                <a href='https://smashballoon.com/checkout/?edd_license_key=<?php echo trim($ctf_license) ?>&amp;download_id=<?php echo CTF_PRODUCT_ID ?>' target='_blank'><?php _e("Renew your license"); ?></a>
                &nbsp;&nbsp;&nbsp;&middot;
                <a class="ctf-tooltip-link" href="JavaScript:void(0);"><?php _e("Upgrade your license"); ?></a>
                &nbsp;&nbsp;&nbsp;&middot;
                <a href="https://smashballoon.com/custom-twitter-feeds/docs/" target="_blank" style="margin-left: 10px;">Questions?</a>

                <span class="ctf-tooltip ctf-more-info" style="width: 80%;">
                    <?php _e("You can upgrade your license in two ways:<br />
                    &bull;&nbsp; Log into <a href='https://smashballoon.com/account' target='_blank'>your Account</a> and click on the <b>'Upgrade my License'</b> tab<br />
                    &bull;&nbsp; <a href='https://smashballoon.com/contact/' target='_blank'>Contact us directly</a>"); ?>
                </span>
            </p>

        </td>
    </tr>

    </tbody>
    </table>

    <p style="margin: 20px 0 0 0; height: 35px;">
        <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes" style="margin-right: 10px;">
        <button name="ctf-test-license" id="ctf-test-license-btn" class="button button-secondary">Test Connection</button>
    </p>

    <div id="ctf-test-license-connection" style="display: none;">
        <?php
        if( isset( $ctf_license_data['item_name']) ){
            echo '<p class="ctf-success" style="display: inline-block; padding: 10px 15px; border-radius: 5px; margin: 0; background: #dceada; border: 1px solid #6ca365; color: #3e5f1c;"><i class="fa fa-check"></i> &nbsp;Connection Successful</p>';
        } else {
            echo '<div class="ctf-test-license-error">';
                highlight_string( var_export($ctf_response, true) );
                echo '<br />';
                highlight_string( var_export($ctf_license_data, true) );
            echo '</div>';
        }
        ?>
    </div>
    <script type="text/javascript">
    jQuery('#ctf-test-license-btn').on('click', function(e){
        e.preventDefault();
        jQuery('#ctf-test-license-connection').toggle();
    });
    </script>

</form>
<?php //} // End license page ?>