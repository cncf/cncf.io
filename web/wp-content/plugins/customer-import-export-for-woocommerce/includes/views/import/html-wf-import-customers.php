<?php
$settings = get_option('woocommerce_' . WT_CUSTOMER_IMP_EXP_ID . '_settings', null);

wp_enqueue_script('woocommerce-user_impexp-test-ftp', plugins_url(basename(plugin_dir_path(WF_CustomerImpExpCsv_FILE)) . '/js/test-ftp-connection.js', basename(__FILE__)),array(),WT_CUSTOMER_IMP_EXP_VER);
wp_localize_script('woocommerce-user_impexp-test-ftp', 'xa_user_impexp_test_ftp', array('admin_ajax_url' => admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce(WT_CUSTOMER_IMP_EXP_ID) ));
?>
<div class="cusimpexp tool-box bg-white p-20p">
    <h3 class="title wf-title"><?php _e('Step 1: Import settings', 'wf_customer_import_export'); ?></h3>
    <p><?php _e('Import Users in CSV format from different sources (  from your computer OR from another server via FTP )', 'wf_customer_import_export'); ?></p>
    <?php if (!empty($upload_dir['error'])) : ?>
        <div class="error">
            <p><?php _e('Before you can upload your import file, you will need to fix the following error:', 'wf_customer_import_export'); ?></p>
            <p><strong><?php echo $upload_dir['error']; ?></strong></p>
        </div>
    <?php else : ?>
        <form enctype="multipart/form-data" id="import-upload-form" method="post" action="<?php echo esc_attr(wp_nonce_url($action, 'import-upload')); ?>">
            <table class="form-table">
                <tbody>
                    <tr>
                        <th>
                            <label for="method"><?php _e('Choose a method for import', 'wf_customer_import_export'); ?></label>
                        </th>
                        <td>
                            <select style="width: 200px" id="method" name="method" onchange="method_change(this.value)">
                                <option value="" disabled selected hidden>Select</option>
                                <option value="file">via local file</option>
                                <option value="ftp">via FTP</option>
                            </select>
                            <input type="file" id="upload" name="import" size="25"/>
                            <input type="hidden" name="action" value="save" />
                            <input type="hidden" name="max_file_size" value="<?php echo $bytes; ?>" />
                            <small id="upload-size"><?php printf(__('Maximum size: %s'), $size); ?></small>
                        </td>
                    </tr>
                    <tr id="ftp_row">
                        <td colspan="2">
                            <div style=" ">
                                <table class="form-table" id="usr_import_ftp" style="margin-left: 20px">
                                    <tr>
                                        <th>
                                            <label for="usr_import_ftp_profile"><?php _e('Choose FTP profile', 'wf_customer_import_export'); ?></label>
                                        </th>
                                        <td>
                                            <div style="display: flex;align-items: center;">
                                                <select id="usr_import_ftp_profile" name="usr_import_ftp_profile" onchange="validate(this.value)">
                                                    <option value="" disabled selected hidden>Filename</option>
                                                    <?php
                                                    if (!empty($settings['ftp'])) {
                                                        foreach ($settings['ftp'] as $key => $value) {
                                                            echo '<option value="' . $key . '">' . $key . '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <input type="hidden" id="ftp_server" value="" name="ftp_server" />
                                                <input type="hidden" id="ftp_port" value="" name="ftp_port" />
                                                <input type="hidden" id="ftp_user" value="" name="ftp_user" />
                                                <input type="hidden" id="ftp_password" value="" name="ftp_password" />
                                                <input type="checkbox" id="use_ftps" name="use_ftps" class="checkbox" style="display: none" />
                                                <input type="checkbox" id="use_pasv" name="use_pasv" class="checkbox" style="display: none" />
                                                <input type="checkbox" id="is_sftp" name="is_sftp" class="checkbox" style="display: none" />
                                                <input style="margin: 10px" type="button" id="test_ftp_connection" class="button button-primary" value="<?php _e('Test FTP', 'wf_customer_import_export'); ?>" />
                                                <a href="<?php echo admin_url('admin.php?page=hf_wordpress_customer_im_ex&tab=settings&section=ftp') ?>">FTP Settings</a>
                                                <span class ="spinner"></span>
                                            </div>
                                        </td>
                                        <td style="text-align: center" id="test_ftp_connection_notice"></td>
                                    </tr>
                                    <tr>
                                        <th>
                                            <label for="ftp_server_path"><?php _e('Import path', 'wf_customer_import_export'); ?></label>
                                        </th>
                                        <td>
                                            <input type="text" name="ftp_server_path" id="ftp_server_path" value="/" class="input-text" />
                                            <p style="font-size: 12px"><?php _e('Complete CSV path including filename.', 'wf_customer_import_export') ?></p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
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
                                <select name="profile" style="width: 200px">
                                    <option value="">--Select--</option>
                                    <?php foreach ($mapping_from_db as $key => $value) { ?>
                                        <option value="<?php echo $key; ?>"><?php echo $key; ?></option>
                                    <?php } ?>
                                </select>
                                <input type="button" name="delete_user_import_mapping" id="v_delete_user_import_mapping"  class="button button-primary" value="<?php _e('Delete Mapping Profile', 'wf_customer_import_export'); ?>" >
                                <span style="float: none" class ="delete spinner " ></span>
                                <span id="user_delete_imp_mapping_notice"></span>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <th>
                            <label for="delimiter"><?php _e('Delimiter', 'wf_customer_import_export'); ?></label>
                        </th>
                        <td><input type="text" id="delimiter" name="delimiter" placeholder="," size="2" /></td>
                    </tr>
                    <tr>
                        <th>
                            <label for="insert_with_id"><?php _e('Use the same ID for users on import', 'wf_customer_import_export'); ?></label>
                        </th>
                        <td>
                            <input type="checkbox" id="insert_with_id" name="insert_with_id" class="checkbox" <?php checked(0, 1); ?> />
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="use_same_password"><?php _e('Use the same Password for users on import', 'wf_customer_import_export'); ?></label>
                        </th>
                        <td>
                            <input type="checkbox" id="use_same_password" name="use_same_password" class="checkbox" checked="" <?php checked(0, 1); ?> />
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="send_mail"><?php _e('Send Mail to New Users', 'wf_customer_import_export'); ?></label>
                        </th>
                        <td>
                            <input type="checkbox" name="send_mail" id="send_mail" class="checkbox" <?php checked(0, 1); ?> />
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="merge"><?php _e('Update User if exists', 'wf_customer_import_export'); ?></label>
                        </th>
                        <td>
                            <input type="checkbox" id="merge" name="merge" class="checkbox" <?php checked(0, 1); ?> onchange="valueChanged()"/>
                        </td>
                    </tr>

                    <tr id="merg_option_row" style="display:none;">

                        <td>
                            <input type="radio" id="email" name="merge_with" value="email" checked>
                            <label for="email">Update with email</label>&nbsp;&nbsp;&nbsp;
                            <input type="radio" id="id" name="merge_with" value="id" >
                            <label for="id">Update with id</label>
                        </td>
                    </tr>
                </tbody>
            </table>
            <p class="submit">
                <input type="submit" class="button button-primary" value="<?php esc_attr_e('Step 2: Map and import >>'); ?>" />
            </p>
        </form>
    <?php endif; ?>
</div>
<script>
    var setting = <?php echo json_encode($settings); ?>;
    function validate(key) {
        if (key !== '') {
            document.getElementById("ftp_server").value = setting['ftp'][key]['ftp_server'];
            document.getElementById("ftp_user").value = setting['ftp'][key]['ftp_user'];
            document.getElementById("ftp_password").value = setting['ftp'][key]['ftp_password'];
            document.getElementById("ftp_port").value = setting['ftp'][key]['ftp_port'];
            if (setting['ftp'][key]['use_ftps'] === true) {
                document.getElementById("use_ftps").checked = true;
            } else {
                document.getElementById("use_ftps").checked = false;
            }
            if (setting['ftp'][key]['use_pasv'] === true) {
                document.getElementById("use_pasv").checked = true;
            } else {
                document.getElementById("use_pasv").checked = false;
            }
            if(setting['ftp'][key]['is_sftp'] === true){
                document.getElementById("is_sftp").checked = true;
            }else{
                document.getElementById("is_sftp").checked = false;
            }
        }
    }
    function method_change(val) {
        if (val === "ftp") {
            document.getElementById("upload-size").style.display = "none";
            document.getElementById("upload").style.display = "none";
            document.getElementById("ftp_row").style.display = "";
        } else if (val === "file") {
            document.getElementById("upload-size").style.display = "";
            document.getElementById("upload").style.display = "";
            document.getElementById("ftp_row").style.display = "none";
        } else {
            document.getElementById("ftp_row").style.display = "none";
            document.getElementById("upload-size").style.display = "none";
            document.getElementById("upload").style.display = "none";
        }
    }
    window.onload = function () {
        var val = document.getElementById("method").value;
        var key = document.getElementById("usr_import_ftp_profile").value;
        if (val === "ftp") {
            document.getElementById("ftp_row").style.display = "tr";
            document.getElementById("upload-size").style.display = "none";
            document.getElementById("upload").style.display = "none";
        } else if (val === "file") {
            document.getElementById("upload-size").style.display = "";
            document.getElementById("upload").style.display = "";
            document.getElementById("ftp_row").style.display = "none";
        } else {
            document.getElementById("ftp_row").style.display = "none";
            document.getElementById("upload-size").style.display = "none";
            document.getElementById("upload").style.display = "none";
        }
        if (key !== '') {
            document.getElementById("ftp_server").value = setting['ftp'][key]['ftp_server'];
            document.getElementById("ftp_user").value = setting['ftp'][key]['ftp_user'];
            document.getElementById("ftp_password").value = setting['ftp'][key]['ftp_password'];
            document.getElementById("ftp_port").value = setting['ftp'][key]['ftp_port'];
            if (setting['ftp'][key]['use_ftps'] === true) {
                document.getElementById("use_ftps").checked = true;
            } else {
                document.getElementById("use_ftps").checked = false;
            }
            if (setting['ftp'][key]['use_pasv'] === true) {
                document.getElementById("use_pasv").checked = true;
            } else {
                document.getElementById("use_pasv").checked = false;
            }
            if(setting['ftp'][key]['is_sftp'] === true){
                document.getElementById("is_sftp").checked = true;
            }else{
                document.getElementById("is_sftp").checked = false;
            }
        }
    };

    function valueChanged()
    {
        if (jQuery('#merge').is(":checked"))
            jQuery('#merg_option_row').show();
        else
            jQuery('#merg_option_row').hide();
    }
</script>

