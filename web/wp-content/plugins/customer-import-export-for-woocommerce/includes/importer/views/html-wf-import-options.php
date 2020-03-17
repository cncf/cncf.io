<div class="tool-box bg-white p-20p" style="display: inline-block">
    <form action="<?php echo admin_url('admin.php?import=' . $this->import_page . '&step=2&section=import&use_same_password='.$use_same_password.'&insert_with_id='.$insert_with_id.'&merge=' . $merge .'&merge_with=' . $merge_with ); ?>" method="post">
        <?php wp_nonce_field('import-woocommerce'); ?>
        <input type="hidden" name="import_id" value="<?php echo $this->id; ?>" />
        <?php if ($this->file_url_import_enabled) : ?>
            <input type="hidden" name="import_url" value="<?php echo $this->file_url; ?>" />
        <?php endif; ?>
        <h3 class="title wf-title"><?php _e('Step 2: Import mapping', 'wf_customer_import_export'); ?></h3>
        <p><?php _e('Here you can map your imported columns to user data fields.', 'wf_customer_import_export'); ?></p>
        <?php
            if ($mapping_from_db && is_array($mapping_from_db) && count($mapping_from_db) == 2 && empty($_GET['clearmapping'])) {
                echo '<p>' . __('Columns are pre-selected using the Mapping file: "<b style="color:gray">' . $this->profile . '</b>".  <a href="' . $reset_action . '"> Delete</a> this mapping file.', 'wf_customer_import_export') . '</p>';
            }
        ?>
        <?php if($this->profile == ''){?>
            <table class="form-table">
                <tr>
                    <th>
                        <label for="profile" class="wf-lbl"><?php _e('Mapping file name:', 'wf_customer_import_export'); ?>
                            <div class="wt-help-tip wf-dvl" style="margin-right: 170px; margin-top: -20px">
                                <img src="<?php echo plugins_url( basename( plugin_dir_path( WF_CustomerImpExpCsv_FILE ) )); ?>/images/help.png" height="20" width="20"/>
                                <span class="tooltiptext" style="width: 750px;"><?php _e('Mapping the fields is necessary for a proper import of the customer data into the WooCommerce website. This is to ensure that the column headers of the CSV file are in sync with the WooCommerce customer data fields. The "column header" indicates the CSV column headers and "Map to" fields corresponds to the WooCommerce database. For a smooth import its important that these names match. When they dont match(in case of custom columns) you will see a "Do not import" under the colum header. In this case you have to map them manually. Columns with "Do not import" tags will not be imported.','wf_customer_import_export') ?></span>
                            </div>
                        </label>
                    </th>
                    <td>
                        <input type="text" id="profile" name="profile" value="" placeholder="Enter filename to save" />
                        <input type="button" name="save_import_mapping" id="usr_save_import_mapping"  class="button button-primary" value="<?php _e('Save', 'wf_customer_import_export'); ?>" >
                        <span style="float: none" class ="spinner " ></span>
                        <span id="usr_save_mapping_notice"></span>
                        <p style="font-size: 12px"><?php _e('Save the below mapping into a file to avoid repeated mapping for future imports.', 'wf_customer_import_export') ?></p>                       
                    </td>
                </tr>
            </table>
        <?php }else{ ?>
            <input type="hidden" name="profile" value="<?php echo $this->profile; ?>" />
        <?php } ?>
        <table class="widefat widefat_importer" id="ImpOptionsTable">
            <thead>
                <tr>
                    <th><?php _e('Map to', 'wf_customer_import_export'); ?></th>
                    <th><?php _e('Column Header', 'wf_customer_import_export'); ?></th>
                    <th><?php _e('Evaluation Field', 'wf_customer_import_export'); ?>
                        <?php if(function_exists('WC')){  ?>
                        <img class="help_tip" style="float:none;" data-tip="<?php _e('Assign desired value to user_email:</br>=test@test.com</br></br>Convert date to Woocommerce format by providing your valid PHP date format :</br>@ d/m/yy H:i:s</br>Append a value By HikeFoce to name:</br>&By HikeFoce</br>Prepend a value HikeFoce to name:</br>&HikeFoce [VAL].', 'wf_customer_import_export'); ?>" 
                             src="<?php echo plugins_url( basename( plugin_dir_path( WF_CustomerImpExpCsv_FILE ) )); ?>/images/help.png" height="20" width="20" /> 
                        <?php } ?>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                $wp_user_details = include( dirname(__FILE__) . '/../data/data-wf-reserved-fields-pair.php' );       

                $meats_form_csv = array();            
                foreach ($raw_headers as $key => $column) {

                    if(!empty($meats_form_csv[$key]))
                                continue;           

                    if (strstr($key, 'meta:')) {
                        $column = trim(str_replace('meta:', '', $key));
                        $meats_form_csv['meta:' . $column] = 'meta:' . $column . '| Custom Field:' . $column;
                    } 
                }
                foreach ($meats_form_csv as $key => $value) {
                    if(!empty($wp_user_details[$key]))
                                continue;
                    $wp_user_details[$key] = $value;
                }

                foreach ($wp_user_details as $key => $value) :
                    $sel_key = ($saved_mapping && isset($saved_mapping[$key])) ? $saved_mapping[$key] : $key;
                    $evaluation_value = ($saved_evaluation && isset($saved_evaluation[$key])) ? $saved_evaluation[$key] : '';
                    $evaluation_value = stripslashes($evaluation_value);
                    $values = explode('|',$value);
                    $value = $values[0];
                    $tool_tip = @$values[1];
                    ?>
                    <tr>
                        <td width="25%">
                            <?php if(function_exists('WC')){  ?>
                            <img class="help_tip" style="float:none;" data-tip="<?php echo $tool_tip; ?>" 
                                 src="<?php echo plugins_url( basename( plugin_dir_path( WF_CustomerImpExpCsv_FILE ) )); ?>/images/help.png" height="20" width="20" /> 
                            <?php } ?>
                            <select name="map_to[<?php echo $key; ?>]" disabled="true" 
                                    style=" -webkit-appearance: none;
                                        -moz-appearance: none;
                                        text-indent: 1px;
                                        text-overflow: '';
                                        background-color: #f1f1f1;
                                        border: none;
                                        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.07) inset;
                                        color: #32373c;
                                        outline: 0 none;
                                        transition: border-color 50ms ease-in-out 0s;">
                                <option value="<?php echo $key; ?>" <?php if($key == $key){ echo 'selected="selected"';} ?>><?php echo $value; ?></option>
                            </select>
                        </td>
                        <td width="25%">
                            <select name="map_from[<?php echo $key; ?>]">
                                <option value=""><?php _e('Do not import', 'wf_customer_import_export'); ?></option>
                                <?php
                                foreach ($row as $hkey => $hdr):
                                    $hdr = strlen($hdr) > 50 ? substr($hdr, 0, 50) . "..." : $hdr;
                                    ?>
                                    <option value="<?php echo $raw_headers[$hkey]; ?>" <?php selected($sel_key, $hkey); //selected(strtolower($sel_key), $hkey); ?>><?php echo $raw_headers[$hkey] . " &nbsp;  : &nbsp; " . $hdr; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td width="10%"><input type="text" name="eval_field[<?php echo $key; ?>]" value="<?php echo $evaluation_value; ?>"  /></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div style="text-align: center; margin-top: 10px">
            <input type="button" id="seeMoreRecords" value="<?php _e('Show all (meta data)...','wf_customer_import_export'); ?>" />
            <input type="button" id="seeLessRecords" value="<?php _e('Hide (meta data)...','wf_customer_import_export'); ?>" />
        </div>
        <p class="submit">
            <input type="submit" class="button button-primary" value="<?php esc_attr_e('Import', 'wf_customer_import_export'); ?>" />
            <input type="hidden" name="delimiter" value="<?php echo $this->delimiter ?>" />
            <input type="hidden" name="merge_empty_cells" value="<?php echo $this->merge_empty_cells ?>" />
            <input type="hidden" name="send_mail" value="<?php echo $this->send_mail; ?>" />
        </p>
    </form>
</div>
<script>
jQuery(document).ready(function($){
    var trs = $("#ImpOptionsTable tr");
    var btnMore = $("#seeMoreRecords");
    var btnLess = $("#seeLessRecords");
    var trsLength = trs.length;

    trs.hide();
    trs.slice(0, 45).show(); 
    checkButton();

    btnMore.click(function (e) {
        e.preventDefault();
        trs.show();
        checkButton();
    });
    
    btnLess.click(function (e) {
        e.preventDefault();
        trs.hide();
        trs.slice(0, 45).show();
        checkButton();
    });

    function checkButton() {
        var currentLength = $("#ImpOptionsTable tr:visible").length;

        if (currentLength >= trsLength) {
            btnMore.hide();            
        } else {
            btnMore.show();   
        }

        if (trsLength > 45 && currentLength > 45) {
            btnLess.show();
        } else {
            btnLess.hide();
        }
    }
});
</script>