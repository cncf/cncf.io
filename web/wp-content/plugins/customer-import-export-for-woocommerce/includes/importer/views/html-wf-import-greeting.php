<?php
$ftp_server		= '';
$ftp_user		= '';
$ftp_password		= '';
$ftp_port		= 21;
$use_ftps		= '';
$usr_enable_ftp_ie	= '';
$ftp_server_path	= '';

if (!empty($ftp_settings)) {
    $ftp_server		= $ftp_settings['ftp_server'];
    $ftp_user		= $ftp_settings['ftp_user'];
    $ftp_password	= $ftp_settings['ftp_password'];
    $ftp_port		= !empty($ftp_settings['ftp_port']) ? $ftp_settings['ftp_port'] : 21;
    $use_ftps		= $ftp_settings['use_ftps'];
    $usr_enable_ftp_ie	= $ftp_settings['usr_enable_ftp_ie'];
    $ftp_server_path	= $ftp_settings['ftp_server_path'];
}

wp_enqueue_script('woocommerce-user_impexp-test-ftp', plugins_url( basename( plugin_dir_path( WF_CustomerImpExpCsv_FILE ) ) . '/js/test-ftp-connection.js', basename( __FILE__ )),array(),WT_CUSTOMER_IMP_EXP_VER);
wp_localize_script('woocommerce-user_impexp-test-ftp', 'xa_user_impexp_test_ftp', array( 'admin_ajax_url'	=> admin_url( 'admin-ajax.php' ), 'nonce' => wp_create_nonce(WT_CUSTOMER_IMP_EXP_ID)  ) );
?>

<div>

    <p><?php _e('You can import users/customers (in CSV format) in to the shop using any of below methods.', 'wf_customer_import_export'); ?></p>



<?php if (!empty($upload_dir['error'])) : ?>

        <div class="error"><p><?php _e('Before you can upload your import file, you will need to fix the following error:', 'wf_customer_import_export'); ?></p>

            <p><strong><?php echo $upload_dir['error']; ?></strong></p></div>

    <?php else : ?>

        <form enctype="multipart/form-data" id="import-upload-form" method="post" action="<?php echo esc_attr(wp_nonce_url($action, 'import-upload')); ?>">

            <table class="form-table">

                <tbody>

                    <tr>

                        <th>

                            <label for="upload"><?php _e('Method 1: Select a file from your computer', 'wf_customer_import_export'); ?></label>

                        </th>

                        <td>

                            <input type="file" id="upload" name="import" size="25" />

                            <input type="hidden" name="action" value="save" />

                            <input type="hidden" name="max_file_size" value="<?php echo $bytes; ?>" />

                            <small><?php printf(__('Maximum size: %s'), $size); ?></small>

                        </td>

                    </tr>

    <?php
    $mapping_from_db = get_option('wf_user_csv_imp_exp_mapping');

    if (!empty($mapping_from_db)) {
        ?>

                        <tr>

                            <th>

                                <label for="profile"><?php _e('Select a mapping file.', 'wf_customer_import_export'); ?></label>

                            </th>

                            <td>

                                <select name="profile">

                                    <option value="">--Select--</option>

        <?php foreach ($mapping_from_db as $key => $value) { ?>

                                        <option value="<?php echo $key; ?>"><?php echo $key; ?></option>



        <?php } ?>

                                </select>

                            </td>

                        </tr>

                                <?php } ?>

                    <tr>

                        <th>

                            <label for="ftp"><?php _e('Method 2: Provide FTP Details:', 'wf_customer_import_export'); ?></label>

                        </th>

                        <td>

                            <table class="form-table">

                                <tr>

                                    <th>

                                        <label for="usr_enable_ftp_ie"><?php _e('Enable FTP import/export', 'wf_customer_import_export'); ?></label>

                                    </th>

                                    <td>

                                        <input type="checkbox" name="usr_enable_ftp_ie" id="usr_enable_ftp_ie" class="checkbox" <?php checked($usr_enable_ftp_ie, 1); ?> />

                                    </td>

                                </tr>

                                <tr>

                                    <th>

                                        <label for="ftp_server"><?php _e('FTP Server Host/IP', 'wf_customer_import_export'); ?></label>

                                    </th>

                                    <td>

                                        <input type="text" name="ftp_server" id="ftp_server" placeholder="<?php _e('XXX.XXX.XXX.XXX', 'wf_customer_import_export'); ?>" value="<?php echo $ftp_server; ?>" class="input-text" />

                                    </td>

                                </tr>

                                <tr>

                                    <th>

                                        <label for="ftp_user"><?php _e('FTP User Name', 'wf_customer_import_export'); ?></label>

                                    </th>

                                    <td>

                                        <input type="text" name="ftp_user" id="ftp_user"  value="<?php echo $ftp_user; ?>" class="input-text" />

                                    </td>

                                </tr>

                                <tr>

                                    <th>

                                        <label for="ftp_password"><?php _e('FTP Password', 'wf_customer_import_export'); ?></label>

                                    </th>

                                    <td>

                                        <input type="password" name="ftp_password" id="ftp_password"  value="<?php echo $ftp_password; ?>" class="input-text" />

                                    </td>

                                </tr>
				
				<tr>
                                    <th>
                                        <label for="ftp_port"><?php _e('FTP Port', 'wf_customer_import_export'); ?></label>
                                    </th>
                                    <td>
                                        <input type="text" name="ftp_port" id="ftp_port"  value="<?php echo $ftp_port; ?>" class="input-text" />
                                    </td>
                                </tr>

                                <tr>

                                    <th>

                                        <label for="ftp_server_path"><?php _e('FTP Server Path', 'wf_customer_import_export'); ?></label>

                                    </th>

                                    <td>

                                        <input type="text" name="ftp_server_path" id="ftp_server_path"  value="<?php echo $ftp_server_path; ?>" class="input-text" />

                                    </td>

                                </tr>



                                <tr>

                                    <th>

                                        <label for="use_ftps"><?php _e('Use FTPS', 'wf_customer_import_export'); ?></label>

                                    </th>

                                    <td>

                                        <input type="checkbox" name="use_ftps" id="use_ftps" class="checkbox" <?php checked($use_ftps, 1); ?> />

                                    </td>

                                </tr>
				
				<tr>
					<th>
						<input type="button" id="test_ftp_connection" class="button button-primary" value="<?php _e( 'Test FTP', 'wf_customer_import_export' ); ?>" />
						<span class ="spinner " ></span>
					</th>
					<td id="test_ftp_connection_notice"></td>
				</tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th><label><?php _e('Delimiter', 'wf_customer_import_export'); ?></label><br/></th>
                        <td><input type="text" name="delimiter" placeholder="," size="2" /></td>
                    </tr>
                    <tr>
                            <th>
                                <label for="send_mail"><?php _e('Send Mail to New Users', 'wf_customer_import_export'); ?></label>
                            </th>
                            <td>
                                <input type="checkbox" name="send_mail" id="send_mail" class="checkbox" <?php checked(0, 1); ?> />
                            </td>
                    </tr>
                </tbody>
            </table>
            <p class="submit">
                <input type="submit" class="button button-primary" value="<?php esc_attr_e('Upload file and import'); ?>" />
            </p>
        </form>

<?php endif; ?>

</div>