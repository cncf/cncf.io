<?php
$settings = get_option('woocommerce_' . WT_CUSTOMER_IMP_EXP_ID . '_settings', null);
wp_enqueue_script('woocommerce-user_impexp-test-ftp', plugins_url( basename( plugin_dir_path( WF_CustomerImpExpCsv_FILE ) ) . '/js/test-ftp-connection.js', basename( __FILE__ )),array(),WT_CUSTOMER_IMP_EXP_VER);
wp_localize_script('woocommerce-user_impexp-test-ftp', 'xa_user_impexp_test_ftp', array('admin_ajax_url' => admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce(WT_CUSTOMER_IMP_EXP_ID) ));
?>
<div class="tool-box bg-white p-20p uipe-view">
    <div class="fpdiv">
            <a href="#" class="button button-primary" onclick="history.back();return false;">Go back</a>
        </div>
    <form action="<?php echo admin_url('admin.php?page=hf_wordpress_customer_im_ex&action=export'); ?>" method="post">
        <h3 class="title wf-title"><?php _e('Step 2: Map and transform', 'wf_customer_import_export'); ?></h3>        
        <?php wp_nonce_field(WT_CUSTOMER_IMP_EXP_ID,'wt_nonce') ?>
        <input type="hidden" name="limit" value="<?php echo $que_args['limit']; ?>"/>
        <input type="hidden" name="offset" value="<?php echo $que_args['offset']; ?>"/>
        <?php
        foreach ($que_args['user_roles'] as $value) {
            echo '<input type="hidden" name="user_roles[]" value="' . $value . '">';
        }
        foreach ($que_args['user_ids'] as $id) {
            echo '<input type="hidden" name="user_ids[]" value="' . $id . '">';
        }
         foreach ($que_args['sortby'] as $s_value) {
            echo '<input type="hidden" name="user_sortby[]" value="' . $s_value . '">';
        }
        ?>
        <input type="hidden" name="sort_order" value="<?php echo $que_args['sort_order']; ?>"/>
        <input type="hidden" name="start_date" value="<?php echo $que_args['fromdate']; ?>"/>
        <input type="hidden" name="end_date" value="<?php echo $que_args['todate']; ?>"/>
        <table class="form-table">
            <?php
            $export_mapping_from_db = get_option('xa_user_csv_export_mapping');
            if (!empty($export_mapping_from_db)) {
                ?>
                <tr>
                    <th>
                        <label for="usr_export_profile"><?php _e('Select a mapping file for export.', 'wf_customer_import_export'); ?></label>
                    </th>
                    <td>
                        <select name="usr_export_profile">
                            <option value="">--Select--</option>
                            <?php foreach ($export_mapping_from_db as $key => $value) { ?>
                                <option value="<?php echo $key; ?>"><?php echo $key; ?></option>
                            <?php } ?>
                        </select>
                        <input type="button" name="delete_user_export_mapping" id="v_delete_user_export_mapping"  class="button button-primary" value="<?php _e('Delete Mapping Profile', 'wf_customer_import_export'); ?>" >
                        <span style="float: none" class ="delete spinner " ></span>
                        <span id="user_delete_mapping_notice"></span>
                    </td>
                </tr>
            <?php } ?>               
            <tr>
                <th>
                    <label for="v_columns"><?php _e('Columns', 'wf_customer_import_export'); ?></label>
                </th>
                <td>
                    <table class="form-table" id="datagrid">
                        <!-- select all boxes -->
                        <tr>
                            <th style="text-align: left;">
                                <label for="v_columns"><?php _e('Column', 'wf_customer_import_export'); ?></label>
                            </th>
                            <th style="text-align: left;">
                                <label for="v_columns_name"><?php _e('Column Name', 'wf_customer_import_export'); ?></label>
                            </th>
                        </tr>
                        <tr>
                            <td style="padding: 10px;">
                                <a href="#" id="usrselectall" onclick="return false;" >Select all</a> &nbsp;/&nbsp;
                                <a href="#" id="usrunselectall" onclick="return false;">Unselect all</a>
                            </td>
                        </tr>
                        <?php foreach ($post_columns as $pkey => $pcolumn) {
                            ?>
                            <tr>
                                <td>
                                    <input name= "columns[<?php echo $pkey; ?>]" type="checkbox" value="<?php echo $pkey; ?>" checked>
                                    <label for="columns[<?php echo $pkey; ?>]"><?php _e($pcolumn, 'wf_customer_import_export'); ?></label>
                                </td>
                                <td>
                                    <input type="text" name="columns_name[<?php echo $pkey; ?>]"  value="<?php echo $pkey; ?>" class="input-text" />
                                </td>
                            </tr>
                        <?php } ?>
                             <tr>
                                <td>
                                    <label for="v_specifi_metas"><?php _e('Additional metadata', 'wf_customer_import_export'); ?></label>
                                </td>
                                <td>
                                    <input type="text" name="wt_specific_metas" id="v_specifi_metas" placeholder="<?php _e('meta:key_name1,meta:key_name2', 'wf_customer_import_export'); ?>" class="input-text" />
                                    <p style="font-size: 12px"><?php _e('The meta key name of the additional metadata you wish to export.', 'wf_customer_import_export'); ?></p>
                                </td>
                            </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <th>
                    <label for="v_usr_new_profile"><?php _e('Mapping filename', 'wf_customer_import_export'); ?></label>
                </th>
                <td>
                    <input type="text" name="usr_new_profile" id="v_usr_new_profile" class="input-text" />
                    <input type="button" name="save_export_mapping" id="usr_save_export_mapping"  class="button button-primary" value="<?php _e('Save', 'wf_customer_import_export'); ?>" >
                    <span style="float: none" class ="spinner " ></span>
                    <span id="usr_save_mapping_notice"></span>
                    <p style="font-size: 12px"><?php _e('Save the above mapping into a file to avoid repeated mapping for future exports.', 'wf_customer_import_export'); ?></p>
                </td>
            </tr>
            <tr>
                <th>
                    <label for="v_delimiter"><?php _e('Delimiter', 'wf_customer_import_export'); ?></label>
                </th>
                <td>
                    <input type="text" name="delimiter" id="v_delimiter" placeholder="<?php _e(',', 'wf_customer_import_export'); ?>" class="input-text" />
                    <p style="font-size: 12px"><?php _e('Column seperator for exported file', 'wf_customer_import_export'); ?></p>
                </td>
            </tr>
            <tr>
                <th>
                    <label for="v_export_guest_user"><?php _e('Export guest users', 'wf_customer_import_export'); ?></label>
                </th>
                <td>
                    <input type="checkbox" name="v_export_guest_user" id="v_export_guest_user" class="checkbox" />
                    <p style="font-size: 12px"><?php _e('Check this to export guest users', 'wf_customer_import_export'); ?></p> 
                </td>
            </tr>
            <tr>
                <th>
                    <label for="v_include_metadata"><?php _e('Include hidden meta data', 'wf_customer_import_export'); ?></label>
                </th>
                <td>
                    <input type="checkbox" name="v_include_metadata" id="v_include_metadata" class="checkbox" />
                    <p style="font-size: 12px"><?php _e('Check this to include hidden meta data', 'wf_customer_import_export'); ?></p> 
                </td>
            </tr>
            <tr>
                <th>
                    <label for="usr_export_enable_ftp"><?php _e('FTP export', 'wf_customer_import_export'); ?></label>
                </th>
                <td>
                    <input type="checkbox" name="usr_export_enable_ftp" id="usr_export_enable_ftp" class="checkbox" onload="check_val()"/> 
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div style=" ">
                        <table class="form-table" id="usr_export_enable_ftp_section_all" style="margin-left: 20px;">
                            <tr>
                                <th>
                                    <label for="usr_export_ftp_profile"><?php _e('Choose FTP profile', 'wf_customer_import_export'); ?></label>
                                </th>
                                <td>
                                    <div style="display: flex;align-items: center;">
                                        <select id="usr_export_ftp_profile" name="usr_export_ftp_profile" onchange="validate(this.value)">
                                            <option value="" disabled selected hidden>Filename</option>
                                            <?php
                                            if(!empty($settings['ftp'])){
                                                foreach ($settings['ftp'] as $key => $value) {
                                                    echo '<option value="'.$key.'">'.$key.'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                        <input type="hidden" id="ftp_server" value="" name="ftp_server" />
                                        <input type="hidden" id="ftp_port" value=21 name="ftp_port" />
                                        <input type="hidden" id="ftp_user" value="" name="ftp_user" />
                                        <input type="hidden" id="ftp_password" value="" name="ftp_password" />
                                        <input type="checkbox" id="use_ftps" name="use_ftps" class="checkbox" style="display: none" />
                                        <input type="checkbox" id="use_pasv" name="use_pasv" class="checkbox" style="display: none" />
                                       <input type="checkbox" id="is_sftp" name="is_sftp" class="checkbox" style="display: none" />
                                        <input style="margin: 10px"type="button" id="test_ftp_connection" class="button button-primary" value="<?php _e('Test FTP', 'wf_customer_import_export'); ?>" />
                                        <a href="<?php echo admin_url('admin.php?page=hf_wordpress_customer_im_ex&tab=settings&section=ftp') ?>">FTP Settings</a>
                                        <span class ="spinner"></span>
                                    </div>
                                </td>
                                <td style="text-align: center" id="test_ftp_connection_notice"></td>                                
                            </tr>                         
                            <tr>
                                <th>
                                    <label for="usr_export_ftp_path"><?php _e('Export path', 'wf_customer_import_export'); ?></label>
                                </th>
                                <td>
                                    <input id="usr_export_ftp_path" name="usr_export_ftp_path" type="text" value="/" />
                                    <p style="font-size: 12px"><?php _e('Exported CSV will be stored in the above directory.', 'wf_customer_import_export') ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="usr_export_ftp_file_name"><?php _e('Export filename', 'wf_customer_import_export'); ?></label>
                                </th>
                                <td>
                                    <input id="usr_export_ftp_file_name" name="usr_export_ftp_file_name" type="text" value="" placeholder="For example sample.csv"/>
                                    <p style="font-size: 12px"><?php _e('Exported CSV will have the above filename if specified.', 'wf_customer_import_export') ?></p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
        <p class="submit"><input type="submit" class="button button-primary" value="<?php _e('Export Users', 'wf_customer_import_export'); ?>" /></p>
        <div class="dpdiv">
            <a href="#" onclick="history.back();return false;">Go back</a>
        </div>
        <div class="clear"></div>
    </form>
</div>
<script>
function validate(key){
    var setting = <?php echo json_encode($settings) ; ?>;
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
window.onload = function(){
    var setting = <?php echo json_encode($settings) ; ?>;
    var key = document.getElementById("usr_export_ftp_profile").value;
    if(document.getElementById("usr_export_enable_ftp").checked === true){
        document.getElementById("usr_export_enable_ftp_section_all").style.display = "block";
        if(key !== ''){
            document.getElementById("ftp_server").value = setting['ftp'][key]['ftp_server'];
            document.getElementById("ftp_user").value = setting['ftp'][key]['ftp_user'];
            document.getElementById("ftp_password").value = setting['ftp'][key]['ftp_password'];
            document.getElementById("ftp_port").value = setting['ftp'][key]['ftp_port'];
            if(setting['ftp'][key]['use_ftps'] === true){
                document.getElementById("use_ftps").checked = true;
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
    }else{
        document.getElementById("usr_export_enable_ftp_section_all").style.display = "none";
    }
};
</script>