<?php

$ftp_server = "";
$ftp_port = "";
$ftp_user = "";
$ftp_password = "";
$use_ftps = "";
$use_pasv = "";

$settings = get_option('woocommerce_' . WT_CUSTOMER_IMP_EXP_ID . '_settings', null);
$usr_auto_export_user_roles = !empty($settings['usr_auto_export_user_roles']) ? $settings['usr_auto_export_user_roles'] : array();
$usr_auto_export_limit=!empty($settings['usr_auto_export_limit']) ? $settings['usr_auto_export_limit'] : '';
$usr_auto_export_offset=!empty($settings['usr_auto_export_offset']) ? $settings['usr_auto_export_offset'] : '';
$usr_auto_user_ids=!empty($settings['usr_auto_user_ids']) ? $settings['usr_auto_user_ids'] : array();
$usr_auto_export_start_date=!empty($settings['usr_auto_export_start_date']) ? $settings['usr_auto_export_start_date'] : '';
$usr_auto_export_end_date=!empty($settings['usr_auto_export_end_date']) ? $settings['usr_auto_export_end_date'] : '';
$usr_auto_delimiter=!empty($settings['usr_auto_delimiter']) ? $settings['usr_auto_delimiter'] : '';

$usr_auto_export_path = !empty($settings['usr_auto_export_path']) ? $settings['usr_auto_export_path'] : '/';
$usr_auto_export_file_name = !empty($settings['usr_auto_export_file_name']) ? $settings['usr_auto_export_file_name'] : null;
$usr_auto_export = isset($settings['usr_auto_export']) ? $settings['usr_auto_export'] : '';
$usr_auto_export_start_time = isset($settings['usr_auto_export_start_time']) ? $settings['usr_auto_export_start_time'] : '';
$usr_auto_export_interval = isset($settings['usr_auto_export_interval']) ? $settings['usr_auto_export_interval'] : '';
$usr_auto_export_profile = isset($settings['user_auto_export_profile']) ? $settings['user_auto_export_profile'] : '';
$v_include_metadata_cron = isset($settings['v_include_metadata_cron']) ? $settings['v_include_metadata_cron'] : '';
$usr_auto_export_ftp_profile = isset($settings['usr_auto_export_ftp_profile']) ? $settings['usr_auto_export_ftp_profile'] : '';
if(!empty($usr_auto_export_ftp_profile)){
    $ftp_server = isset($settings['ftp'][$usr_auto_export_ftp_profile]['ftp_server']) ? $settings['ftp'][$usr_auto_export_ftp_profile]['ftp_server'] : '';
    $ftp_port = isset($settings['ftp'][$usr_auto_export_ftp_profile]['ftp_port']) ? $settings['ftp'][$usr_auto_export_ftp_profile]['ftp_port'] : '';
    $ftp_user = isset($settings['ftp'][$usr_auto_export_ftp_profile]['ftp_user']) ? $settings['ftp'][$usr_auto_export_ftp_profile]['ftp_user'] : '';
    $ftp_password = isset($settings['ftp'][$usr_auto_export_ftp_profile]['ftp_password']) ? $settings['ftp'][$usr_auto_export_ftp_profile]['ftp_password'] : '';
    $use_ftps = isset($settings['ftp'][$usr_auto_export_ftp_profile]['use_ftps']) ? $settings['ftp'][$usr_auto_export_ftp_profile]['use_ftps'] : '';
    $use_pasv = isset($settings['ftp'][$usr_auto_export_ftp_profile]['use_pasv']) ? $settings['ftp'][$usr_auto_export_ftp_profile]['use_pasv'] : '';
    $is_sftp = isset($settings['ftp'][$usr_auto_export_ftp_profile]['is_sftp']) ? $settings['ftp'][$usr_auto_export_ftp_profile]['is_sftp'] : false;
}

wp_enqueue_script('woocommerce-user_impexp-test-ftp', plugins_url(basename(plugin_dir_path(WF_CustomerImpExpCsv_FILE)) . '/js/test-ftp-connection.js', basename(__FILE__)),array(),WT_CUSTOMER_IMP_EXP_VER);
wp_localize_script('woocommerce-user_impexp-test-ftp', 'xa_user_impexp_test_ftp', array('admin_ajax_url' => admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce(WT_CUSTOMER_IMP_EXP_ID) ));

wp_localize_script('woocommerce-user-csv-importer', 'woocommerce_user_csv_cron_params', array('usr_auto_export' => $usr_auto_export));
if ($usr_scheduled_timestamp = wp_next_scheduled('hf_customer_im_ex_auto_export_user')) {
    $usr_scheduled_desc = sprintf(__('The next export is scheduled on <code>%s</code>', 'wf_customer_import_export'), get_date_from_gmt(date('Y-m-d H:i:s', $usr_scheduled_timestamp), get_option('date_format') . ' ' . get_option('time_format')));
} else {
    $usr_scheduled_desc = __('There is no export scheduled.', 'wf_customer_import_export');
}
?>
<div class="cusimpexp tool-box bg-white p-20p">
    <h3 class="title aw-title"><?php _e('Schedule an automatic export', 'wf_customer_import_export'); ?></h3>
    <p>Export users automatically by setting up the below details</p>
    <form action="<?php echo admin_url('admin.php?page=hf_wordpress_customer_im_ex&action=settings&section=export'); ?>" method="post">  
        <?php wp_nonce_field(WT_CUSTOMER_IMP_EXP_ID,'wt_nonce') ?>
        <table class="form-table">
            <tbody>
                <tr>
                    <th>
                        <label for="usr_auto_export"><?php _e('Enable automatic export', 'wf_customer_import_export'); ?></label>
                    </th>
                    <td>
                        <input type="checkbox" name="usr_auto_export" id="usr_auto_export" class="checkbox" <?php checked($usr_auto_export, 1); ?> />
                        <p style="font-size: 12px"><?php _e('Check to enable automatic export', 'wf_customer_import_export'); ?></p> 
                    </td>
                </tr>
                
                <tr>
                        <th>
                            <label class="wf-lbl" for="v_offset"><?php _e('Offset', 'wf_customer_import_export');?>
                                
                            </label>                           
                        </th>
                        <td>
                            <input type="text" name="offset" value="<?php echo !empty($usr_auto_export_offset) ? intval($usr_auto_export_offset) : ''; ?>" id="v_offset" placeholder="<?php _e('0', 'wf_customer_import_export'); ?>" class="input-text"/>
                             <p style="font-size: 12px"><?php _e('The number of users to skip before returning', 'wf_customer_import_export'); ?></p>
                        </td>
                    </tr>            
                    <tr>
                        <th>
                            <label class="wf-lbl" for="v_limit"><?php _e('Limit', 'wf_customer_import_export'); ?>
                 
                            </label>
                        </th>
                        <td>
                            <input type="text" name="limit" value="<?php echo !empty($usr_auto_export_limit) ? intval($usr_auto_export_limit) : ''; ?>" id="v_limit" placeholder="<?php _e('Unlimited', 'wf_customer_import_export'); ?>" class="input-text" />
                            <p style="font-size: 12px"><?php _e('The number of users to return', 'wf_customer_import_export'); ?></p>
                        </td>
                    </tr>
                
                <tr>
                        <th>
                            <label class="wf-lbl" for="v_user_roles"><?php _e('User Roles', 'wf_customer_import_export'); ?>
                                
                            </label>
                        </th>
                        <td>

                            <select id="v_user_roles" name="user_roles[]" data-placeholder="<?php _e('All Roles', 'wf_customer_import_export'); ?>"  class="wc-enhanced-select" multiple="multiple">

                                <?php
                                global $wp_roles;
                                foreach ($wp_roles->role_names as $role => $name) {
                                    if (in_array(strtolower($role), $usr_auto_export_user_roles)) {
                                        echo '<option value="' . esc_attr($role) . '" selected >' . $name . '</option>';
                                    } else {
                                        echo '<option value="' . esc_attr($role) . '">' . $name . '</option>';
                                    }
                                }
                                ?>
                            </select>
                            <p style="font-size: 12px"><?php _e('Users with these roles will be exported', 'wf_customer_import_export'); ?></p>
                        </td>
                    </tr>
                    
                    <tr>
                        <th>
                            <label class="wf-lbl" for="v_user_email"><?php _e('User Email', 'wf_customer_import_export'); ?>
                               
                            </label>
                        </th>
                        <td>
                            <select class="wc-customer-search" name="user_email[]" id="v_user_email" data-placeholder="<?php _e('All users', 'wf_customer_import_export'); ?>" multiple="multiple">
                                <?php
                                if(!empty($usr_auto_user_ids)){
                                    foreach ($usr_auto_user_ids as $user_id){
                                        $user    = get_user_by( 'id', absint($user_id) );
                                        $user_string = sprintf(
                                                /* translators: 1: user display name 2: user ID 3: user email */
                                                esc_html__( '%1$s', 'wf_customer_import_export' ),
                                                $user->user_email
                                        );
                                        echo '<option value="' .esc_attr( $user_id ) . '" selected='."selected".'>' . wp_kses_post( $user_string ) . '<option>';
                                    }
                                }
                                ?>
                            </select>
                            <p style="font-size: 12px"><?php _e('Users with these user emails will be exported', 'wf_customer_import_export'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label class="wf-lbl" for="u_start_date"><?php _e('From Date', 'wf_customer_import_export'); ?>
                                
                            </label>
                        </th>
                        <td>
                            <input id="u_start_date" value="<?php echo!empty($usr_auto_export_start_date) ? ($usr_auto_export_start_date) : ''; ?>" type="text" name="fromdate"/>
                            <p style="font-size: 12px"><?php _e('Format: YYYY-MM-DD. Pick a start user registration date to limit the results.', 'wf_customer_import_export'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label class="wf-lbl" for="u_end_date"><?php _e('To Date', 'wf_customer_import_export'); ?>
                                
                            </label>
                        </th>
                        <td>
                            <input id="u_end_date" value="<?php echo!empty($usr_auto_export_end_date) ? ($usr_auto_export_end_date) : ''; ?>" type="text" name="todate"/>
                            <p style="font-size: 12px"><?php _e('Format: YYYY-MM-DD. Pick an end user registration date to limit the results.', 'wf_customer_import_export'); ?></p>
                        </td>
                    </tr>
                    
                     <tr>
                <th>
                    <label for="v_delimiter"><?php _e('Delimiter', 'wf_customer_import_export'); ?></label>
                </th>
                <td>
                    <input type="text" name="delimiter" id="v_delimiter" value="<?php echo !empty($usr_auto_delimiter) ? ($usr_auto_delimiter) : ''; ?>" placeholder="<?php _e(',', 'wf_customer_import_export'); ?>" class="input-text" />
                    <p style="font-size: 12px"><?php _e('Column seperator for exported file', 'wf_customer_import_export'); ?></p>
                </td>
            </tr>
                <tr id="usr_export_section_all" style="">
                    <td colspan="2">
                        <div style=" ">
                            <table class="form-table" style="margin-left: 20px">
                                <tr>
                                    <th>
                                        <label for="usr_auto_export_ftp_profile"><?php _e('Choose FTP profile', 'wf_customer_import_export'); ?></label>
                                    </th>
                                    <td>
                                        <div style="display: flex;align-items: center;">
                                            <select id="usr_auto_export_ftp_profile" name="usr_auto_export_ftp_profile" onchange="validate(this.value)">
                                                <option value="" disabled selected hidden>Filename</option>
                                                <?php
                                                if(!empty($settings['ftp'])){
                                                    foreach ($settings['ftp'] as $key => $value) {
                                                        ($usr_auto_export_ftp_profile == $key) ? ($selected = 'selected') : ($selected = '');
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
                                        <label for="usr_auto_export_path"><?php _e('Export Path', 'wf_customer_import_export'); ?></label>
                                    </th>
                                    <td>
                                        <input type="text" name="usr_auto_export_path" id="usr_auto_export_path"  value="<?php echo $usr_auto_export_path; ?>" class="input-text" />
                                        <p style="font-size: 12px"><?php _e('Exported CSV will be stored in the above directory.', 'wf_customer_import_export'); ?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="usr_auto_export_file_name"><?php _e('Export Filename', 'wf_customer_import_export'); ?></label>
                                    </th>
                                    <td>
                                        <input type="text" name="usr_auto_export_file_name" id="usr_auto_export_file_name"  value="<?php echo $usr_auto_export_file_name; ?>" placeholder="For example sample.csv" class="input-text" />
                                        <p style="font-size: 12px"><?php _e('Exported CSV will have the above filename if specified.', 'wf_customer_import_export'); ?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="usr_auto_export_start_time"><?php _e('Export Start Time', 'wf_customer_import_export'); ?></label>
                                    </th>
                                    <td colspan="2">
                                        <input type="text" name="usr_auto_export_start_time" id="usr_auto_export_start_time"  value="<?php echo $usr_auto_export_start_time; ?>"/>
                                        <span class="description"><?php echo sprintf(__('Local time is <code>%s</code>.', 'wf_customer_import_export'), date_i18n(get_option('time_format'))) . ' ' . $usr_scheduled_desc; ?></span>
                                        <br>
                                        <p style="font-size: 12px"><?php _e('Enter the time at which the export will start in the format  6:18pm or 12:27am', 'wf_customer_import_export'); ?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="usr_auto_export_interval"><?php _e('Export Interval [ Minutes ]', 'wf_customer_import_export'); ?></label>
                                    </th>
                                    <td>
                                        <input type="text" name="usr_auto_export_interval" id="usr_auto_export_interval"  value="<?php echo $usr_auto_export_interval; ?>"  />
                                    </td>
                                </tr>
                                     <?php
                                    $user_exp_mapping_from_db = get_option('xa_user_csv_export_mapping');
                                    if (!empty($user_exp_mapping_from_db)) {
                                        ?>
                                        <tr>
                                            <th>
                                                <label for="user_auto_export_profile"><?php _e('Select an export mapping file.', 'wf_customer_import_export'); ?></label>
                                            </th>
                                            <td>
                                                <select name="user_auto_export_profile">
                                                    <option value="">--Select--</option>
                                                    <?php foreach ($user_exp_mapping_from_db as $mkey => $mvalue) { ?>
                                                        <option value="<?php echo $mkey; ?>" <?php selected($mkey, $usr_auto_export_profile); ?>><?php echo $mkey; ?></option>

                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <tr>
                                    <th>
                                        <label for="v_include_metadata_cron"><?php _e('Include hidden meta data', 'wf_customer_import_export'); ?></label>
                                    </th>
                                    <td>
                                        <input type="checkbox" name="v_include_metadata_cron" id="v_include_metadata_cron" class="checkbox" <?php checked($v_include_metadata_cron, 1); ?>/>
                                        <p style="font-size: 12px"><?php _e('Check this to include hidden meta data', 'wf_customer_import_export'); ?></p> 
                                    </td>
                                </tr>
                            </table>  
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <p class="submit"><input type="submit" class="button button-primary" value="<?php _e('Save Settings', 'wf_customer_import_export'); ?>" /></p>
    </form>
</div>
<script>
function validate(key){
    var setting = <?php echo json_encode($settings); ?>;
    if(key !== ''){    
        document.getElementById("ftp_server").value = setting['ftp'][key]['ftp_server'];
        document.getElementById("ftp_user").value = setting['ftp'][key]['ftp_user'];
        document.getElementById("ftp_password").value = setting['ftp'][key]['ftp_password'];
        document.getElementById("ftp_port").value = setting['ftp'][key]['ftp_port'];
        if(setting['ftp'][key]['use_ftps'] === true){
            document.getElementById("use_ftps").checked = true;
        }else{
            document.getElementById("use_ftps").checked = false;
        }
        if(setting['ftp'][key]['use_pasv'] === true){
            document.getElementById("use_pasv").checked = true;
        }else{
            document.getElementById("use_pasv").checked = false;
        }
          if(setting['ftp'][key]['is_sftp'] === true){
            document.getElementById("is_sftp").checked = true;
        }else{
            document.getElementById("is_sftp").checked = false;
        }
    }
}
</script>