<?php
    $settings = get_option('woocommerce_' . WT_CUSTOMER_IMP_EXP_ID . '_settings', null);

    wp_enqueue_script('woocommerce-user_impexp-test-ftp', plugins_url(basename(plugin_dir_path(WF_CustomerImpExpCsv_FILE)) . '/js/test-ftp-connection.js', basename(__FILE__)),array(),WT_CUSTOMER_IMP_EXP_VER);
    wp_localize_script('woocommerce-user_impexp-test-ftp', 'xa_user_impexp_test_ftp', array('admin_ajax_url' => admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce(WT_CUSTOMER_IMP_EXP_ID) ));
?>

<div class="cusimpexp tool-box">
    <div class="tool-box bg-white p-20p">
        <h3 class="title aw-title"><?php _e('FTP Settings for Import/Export', 'wf_customer_import_export'); ?></h3>
        <p>Import/Export users via FTP by setting up the FTP details</p>
        <?php
            if(!isset($settings['ftp'])){
        ?>
        <table class="form-table">
            <tr>
                <th>
                    <label for="add_profile"><?php _e('You have not setup any FTP profiles yet.', 'wf_customer_import_export'); ?></label>
                </th>
                <td>
                    <input type="button" id="add_profile" class="button button-primary" onclick="openProfileForm()" value="<?php _e('Add profile', 'wf_customer_import_export'); ?>" />
                </td>
            </tr>
        </table>
        <?php } else { ?>
        <div>
            <form method="get">
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
                <input type="hidden" name="tab" value="settings" />
                <?php $wfSettingsListTable->display(); ?>
            </form>
        </div>
        <input type="button" id="add_new_profile" class="button button-primary" onclick="openProfileForm()" value="<?php _e('Add new profile', 'wf_customer_import_export'); ?>" />
        <?php } ?>
        <div id="wt-form-div">
        <div class="overlay"></div>
        <div id="add_new_profile_form" class="form-popup">
            <h1 class="title aw-title"><?php _e('Add/Edit FTP profiles', 'wf_customer_import_export'); ?></h1>
            <form action="<?php echo admin_url('admin.php?page=hf_wordpress_customer_im_ex&action=settings&section=ftp'); ?>" method="post">
                <?php wp_nonce_field(WT_CUSTOMER_IMP_EXP_ID,'wt_nonce') ?>
                <table class="form-table" class="form-container">
                    <tr>
                        <th>
                            <label for="ftp_server"><?php _e('FTP Server Host/IP', 'wf_customer_import_export'); ?></label>
                        </th>
                        <td>
                            <input type="text" name="ftp_server" id="ftp_server" placeholder="<?php _e('XXX.XXX.XXX.XXX', 'wf_customer_import_export'); ?>" value="" class="input-text" />
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="ftp_user"><?php _e('FTP User Name', 'wf_customer_import_export'); ?></label>
                        </th>
                        <td>
                            <input type="text" name="ftp_user" id="ftp_user" value="" class="input-text" />
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="ftp_password"><?php _e('FTP Password', 'wf_customer_import_export'); ?></label>
                        </th>
                        <td>
                            <input type="password" name="ftp_password" id="ftp_password"  value="" class="input-text" />
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="ftp_port"><?php _e('FTP Port', 'wf_customer_import_export'); ?></label>
                        </th>
                        <td>
                            <input type="text" name="ftp_port" id="ftp_port"  value="" class="input-text" />
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="use_ftps"><?php _e('Use FTPS', 'wf_customer_import_export'); ?></label>
                        </th>
                        <td>
                            <input type="checkbox" name="use_ftps" id="use_ftps" class="checkbox" />
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="use_pasv"><?php _e('Enable Passive mode', 'wf_customer_import_export'); ?></label>
                        </th>
                        <td>
                            <input type="checkbox" name="use_pasv" id="use_pasv" class="checkbox" />
                        </td>
                    </tr>
                     <tr>
                        <th>
                            <label for="is_sFTP"><?php _e('Is sFTP ?', 'wf_customer_import_export'); ?></label>
                        </th>
                        <td>
                            <input type="checkbox" name="is_sftp" id="is_sftp"  />
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="profile_name"><?php _e('Profile name', 'wf_customer_import_export'); ?></label>
                        </th>
                        <td>
                            <input type="text" name="profile_name" id="profile_name" value="" class="input-text" required/>
                            <input type="button" id="test_ftp_connection" class="button button-primary" value="<?php _e('Test FTP', 'wf_customer_import_export'); ?>" />
                            <span class ="spinner"></span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center" id="test_ftp_connection_notice"></td>
                    </tr>
                </table>
                <input type="submit" id="save_profile" class="button button-primary" value="<?php _e('Save Profile', 'wf_customer_import_export'); ?>" />
                <input type="button" class="button button-primary" value="<?php _e('Cancel', 'wf_customer_import_export'); ?>" onclick="closeProfileForm()"/>
            </form>
        </div>
        </div>
    </div>
</div>
<script>
    function openProfileForm(key) {
        var setting = <?php echo json_encode($settings) ; ?>;
        if (key === undefined) {
            document.getElementById("ftp_server").value = '';
            document.getElementById("ftp_user").value = '';
            document.getElementById("ftp_password").value = '';
            document.getElementById("ftp_port").value = 21;
            document.getElementById("profile_name").value = '';
            document.getElementById("use_ftps").checked = false;
            document.getElementById("use_pasv").checked = false;
            document.getElementById("wt-form-div").style.display = "block";
        } else {
            document.getElementById("ftp_server").value = setting['ftp'][key]['ftp_server'];
            document.getElementById("ftp_user").value = setting['ftp'][key]['ftp_user'];
            document.getElementById("ftp_password").value = setting['ftp'][key]['ftp_password'];
            document.getElementById("ftp_port").value = setting['ftp'][key]['ftp_port'];
            document.getElementById("profile_name").value = key;
            if(setting['ftp'][key]['use_ftps'] === true){
                document.getElementById("use_ftps").checked = true;
            }
            if(setting['ftp'][key]['use_pasv'] === true){
                document.getElementById("use_pasv").checked = true;
            }
             if(setting['ftp'][key]['is_sftp'] === true){
                document.getElementById("is_sftp").checked = true;
            }
            document.getElementById("wt-form-div").style.display = "block";
        }
    }
    function closeProfileForm() {
        document.getElementById("ftp_server").value = '';
        document.getElementById("ftp_user").value = '';
        document.getElementById("ftp_password").value = '';
        document.getElementById("ftp_port").value = 21;
        document.getElementById("profile_name").value = '';
        document.getElementById("use_ftps").checked = false;
        document.getElementById("use_pasv").checked = false;
        document.getElementById("wt-form-div").style.display = "none";
    }
</script>