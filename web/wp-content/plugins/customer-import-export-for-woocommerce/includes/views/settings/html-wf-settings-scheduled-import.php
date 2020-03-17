<?php
$ftp_server = "";
$ftp_port = "";
$ftp_user = "";
$ftp_password = "";
$use_ftps = "";
$use_pasv = "";

$settings = get_option('woocommerce_' . WT_CUSTOMER_IMP_EXP_ID . '_settings', null);
$usr_auto_import_path = !empty($settings['usr_auto_import_path']) ? $settings['usr_auto_import_path'] : '/';
$usr_auto_import = isset($settings['usr_auto_import']) ? $settings['usr_auto_import'] : '';
$usr_auto_import_start_time = isset($settings['usr_auto_import_start_time']) ? $settings['usr_auto_import_start_time'] : '';
$usr_auto_import_interval = isset($settings['usr_auto_import_interval']) ? $settings['usr_auto_import_interval'] : '';
$usr_auto_import_ftp_profile = isset($settings['usr_auto_import_ftp_profile']) ? $settings['usr_auto_import_ftp_profile'] : '';
$usr_auto_import_merge = isset($settings['usr_auto_import_merge']) ? $settings['usr_auto_import_merge'] : 0;
$usr_auto_import_profile = isset($settings['usr_auto_import_profile']) ? $settings['usr_auto_import_profile'] : '';
if(!empty($usr_auto_import_ftp_profile)){
    $ftp_server = isset($settings['ftp'][$usr_auto_import_ftp_profile]['ftp_server']) ? $settings['ftp'][$usr_auto_import_ftp_profile]['ftp_server'] : '';
    $ftp_port = isset($settings['ftp'][$usr_auto_import_ftp_profile]['ftp_port']) ? $settings['ftp'][$usr_auto_import_ftp_profile]['ftp_port'] : '';
    $ftp_user = isset($settings['ftp'][$usr_auto_import_ftp_profile]['ftp_user']) ? $settings['ftp'][$usr_auto_import_ftp_profile]['ftp_user'] : '';
    $ftp_password = isset($settings['ftp'][$usr_auto_import_ftp_profile]['ftp_password']) ? $settings['ftp'][$usr_auto_import_ftp_profile]['ftp_password'] : '';
    $use_ftps = isset($settings['ftp'][$usr_auto_import_ftp_profile]['use_ftps']) ? $settings['ftp'][$usr_auto_import_ftp_profile]['use_ftps'] : '';
    $use_pasv = isset($settings['ftp'][$usr_auto_import_ftp_profile]['use_pasv']) ? $settings['ftp'][$usr_auto_import_ftp_profile]['use_pasv'] : '';
    $is_sftp = isset($settings['ftp'][$usr_auto_import_ftp_profile]['is_sftp']) ? $settings['ftp'][$usr_auto_import_ftp_profile]['is_sftp'] : '';
    
}

wp_enqueue_script('woocommerce-user_impexp-test-ftp', plugins_url(basename(plugin_dir_path(WF_CustomerImpExpCsv_FILE)) . '/js/test-ftp-connection.js', basename(__FILE__)),array(),WT_CUSTOMER_IMP_EXP_VER);
wp_localize_script('woocommerce-user_impexp-test-ftp', 'xa_user_impexp_test_ftp', array('admin_ajax_url' => admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce(WT_CUSTOMER_IMP_EXP_ID) ));

wp_localize_script('woocommerce-user-csv-importer', 'woocommerce_user_csv_cron_params', array('usr_auto_import' => $usr_auto_import));
if ($usr_scheduled_import_timestamp = wp_next_scheduled('wf_user_csv_im_ex_auto_import_user')) {
    $usr_scheduled_import_desc = sprintf(__('The next import is scheduled on <code>%s</code>', 'wf_customer_import_export'), get_date_from_gmt(date('Y-m-d H:i:s', $usr_scheduled_import_timestamp), get_option('date_format') . ' ' . get_option('time_format')));
} else {
    $usr_scheduled_import_desc = __('There is no import scheduled.', 'wf_customer_import_export');
}
?>
<div class="cusimpexp tool-box bg-white p-20p">
    <h3 class="title aw-title"><?php _e('Schedule an automatic Import', 'wf_customer_import_export'); ?></h3>
    <p>Import users automatically by setting up the below details</p>
    <form action="<?php echo admin_url('admin.php?page=hf_wordpress_customer_im_ex&action=settings&section=import'); ?>" method="post">
        <?php wp_nonce_field(WT_CUSTOMER_IMP_EXP_ID,'wt_nonce') ?>
        <table class="form-table">
            <tr>
                <th>
                    <label for="usr_auto_import"><?php _e('Enable automatic import', 'wf_customer_import_export'); ?></label>
                </th>
                <td>
                    <input type="checkbox" name="usr_auto_import" id="usr_auto_import" class="checkbox" <?php checked($usr_auto_import, 1); ?> />
                    <p style="font-size: 12px"><?php _e('Check to enable automatic import', 'wf_customer_import_export'); ?></p> 
                </td>
            </tr>
            <tr id="usr_import_section_all" style="">
                <td colspan="2">
                    <div style=" ">
            <table class="form-table" style="margin-left: 20px">
                <tr>
                    <th>
                        <label for="usr_auto_import_ftp_profile"><?php _e('Choose FTP profile', 'wf_customer_import_export'); ?></label>
                    </th>
                    <td>
                        <div style="display: flex;align-items: center;">
                            <select id="usr_auto_import_ftp_profile" name="usr_auto_import_ftp_profile" onchange="validate(this.value)">
                                <option value="" disabled selected hidden>Filename</option>
                                <?php
                                if(!empty($settings['ftp'])){
                                    foreach ($settings['ftp'] as $key => $value) {
                                        ($usr_auto_import_ftp_profile == $key) ? ($selected = 'selected') : ($selected = '');
                                        echo '<option '.$selected.' value="'.$key.'">'.$key.'</option>';
                                    }
                                }
                                ?>
                            </select>
                            <input type="hidden" id="ftp_server" value="<?php echo $ftp_server; ?>" name="ftp_server" />
                            <input type="hidden" id="ftp_port" value="<?php echo $ftp_port; ?>" name="ftp_port" />
                            <input type="hidden" id="ftp_user" value="<?php echo $ftp_user; ?>" name="ftp_user" />
                            <input type="hidden" id="ftp_password" value="<?php echo $ftp_password; ?>" name="ftp_password" />
                            <input type="checkbox" id="use_ftps" name="use_ftps" style="display: none" <?php checked($use_ftps, 1); ?> />
                            <input type="checkbox" id="use_pasv" name="use_pasv" style="display: none" <?php checked($use_pasv, 1); ?> />
                            <input type="checkbox" id="is_sftp" name="is_sftp" style="display: none" <?php checked($is_sftp, 1); ?> />
                            <input style="margin: 10px" type="button" id="test_ftp_connection" class="button button-primary" value="<?php _e('Test FTP', 'wf_customer_import_export'); ?>" />
                            <a href="<?php echo admin_url('admin.php?page=hf_wordpress_customer_im_ex&tab=settings&section=ftp') ?>">FTP Settings</a>
                            <span class ="spinner"></span>
                        </div>
                    </td>
                    <td style="text-align: center" id="test_ftp_connection_notice"></td>
                </tr>
                <tr>
                    <th>
                        <label for="usr_auto_import_path"><?php _e('Import path', 'wf_customer_import_export'); ?></label>
                    </th>
                    <td>
                        <input type="text" name="usr_auto_import_path" id="usr_auto_import_path" value="<?php echo $usr_auto_import_path; ?>"/>
                        <p style="font-size: 12px"><?php _e('Complete CSV path including filename.','wf_customer_import_export'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="usr_auto_import_start_time"><?php _e('Import Start Time', 'wf_customer_import_export'); ?></label>
                    </th>
                    <td colspan="2">
                        <input type="text" name="usr_auto_import_start_time" id="usr_auto_import_start_time"  value="<?php echo $usr_auto_import_start_time; ?>"/>
                        <span class="description"><?php echo sprintf(__('Local time is <code>%s</code>.', 'wf_customer_import_export'), date_i18n(get_option('time_format'))) . ' ' . $usr_scheduled_import_desc; ?></span>
                        <br>
                        <p style="font-size: 12px"><?php _e('Enter the time at which the import will start in the format 6:18pm or 12:27am', 'wf_customer_import_export'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="usr_auto_import_interval"><?php _e('Import Interval [ Minutes ]', 'wf_customer_import_export'); ?></label>
                    </th>
                    <td>
                        <input type="text" name="usr_auto_import_interval" id="usr_auto_import_interval"  value="<?php echo $usr_auto_import_interval; ?>"  />
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="usr_auto_import_merge"><?php _e('Update User if exist', 'wf_customer_import_export'); ?></label>
                    </th>
                    <td>
                        <input type="checkbox" name="usr_auto_import_merge" id="usr_auto_import_merge"  class="checkbox" <?php checked($usr_auto_import_merge, 1); ?> />
                    </td>
                </tr>
                <?php
                    $usr_mapping_from_db = get_option('wf_user_csv_imp_exp_mapping');
                    if (!empty($usr_mapping_from_db)) {
                ?>
                <tr>
                    <th>
                        <label for="usr_auto_import_profile"><?php _e('Select a mapping file.', 'wf_customer_import_export'); ?></label>
                    </th>
                    <td>
                        <select name="usr_auto_import_profile">
                            <option value="">--Select--</option>
                            <?php foreach ($usr_mapping_from_db as $key => $value) { ?>
                                <option value="<?php echo $key; ?>" <?php selected($key, $usr_auto_import_profile); ?>><?php echo $key; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <?php } ?>
            </table>  
                    </div>
                </td>
            </tr>
        </table>
        <p class="submit"><input type="submit" class="button button-primary" value="<?php _e('Save Settings', 'wf_customer_import_export'); ?>" /></p>
    </form>
</div>
<script>
function validate(value){
    var setting = <?php echo json_encode($settings) ; ?>;
    if(value !== ''){
        document.getElementById("ftp_server").value = setting['ftp'][value]['ftp_server'];
        document.getElementById("ftp_user").value = setting['ftp'][value]['ftp_user'];
        document.getElementById("ftp_password").value = setting['ftp'][value]['ftp_password'];
        document.getElementById("ftp_port").value = setting['ftp'][value]['ftp_port'];
        if(setting['ftp'][value]['use_ftps'] === true){
            document.getElementById("use_ftps").checked = true;
        }else{
            document.getElementById("use_ftps").checked = false;
        }
        if(setting['ftp'][value]['use_pasv'] === true){
            document.getElementById("use_pasv").checked = true;
        }else{
            document.getElementById("use_pasv").checked = false;
        }
         if(setting['ftp'][value]['is_sftp'] === true){
            document.getElementById("is_sftp").checked = true;
        }else{
            document.getElementById("is_sftp").checked = false;
        }
    }
}
</script>