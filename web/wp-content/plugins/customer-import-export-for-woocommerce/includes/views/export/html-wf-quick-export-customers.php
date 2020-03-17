<div class="tool-box bg-white p-20p uipe-view">
    <form action="<?php echo admin_url('admin.php?page=hf_wordpress_customer_im_ex&action=quickexport'); ?>" method="post">
        <h3 class="title wf-title"><?php _e('Export Users into CSV', 'wf_customer_import_export'); ?></h3>
        <p>To quickly export the users select the required information from below and export users into CSV. This file can be used to import users back into your Woocommerce shop.</p>
        <?php wp_nonce_field(WT_CUSTOMER_IMP_EXP_ID,'wt_nonce') ?>
        <table>
            <tr>
                <td>
                    <table id="datagrid">
                        <!-- select all boxes -->
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
                            </tr>
                        <?php } ?>
                    </table>
                </td>
            </tr>
        </table>
        <p class="submit"><input type="submit" class="button button-primary" value="<?php _e('Export Users', 'wf_customer_import_export'); ?>" /></p>
        <div class="clear"></div>
    </form>
</div>

