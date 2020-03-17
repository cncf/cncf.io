<h2 class="nav-tab-wrapper woo-nav-tab-wrapper wt-nav-tab">
    <a href="<?php echo admin_url('admin.php?page=hf_wordpress_customer_im_ex&tab=expimp') ?>" class="nav-tab <?php echo ($tab == 'expimp') ? 'nav-tab-active' : ''; ?>"><?php _e('Import/Export', 'wf_customer_import_export'); ?></a>
    <a href="<?php echo admin_url('admin.php?page=hf_wordpress_customer_im_ex&tab=settings') ?>" class="nav-tab <?php echo ($tab == 'settings') ? 'nav-tab-active' : ''; ?>"><?php _e('FTP/Cron Settings', 'wf_customer_import_export'); ?></a>
    <?php
        $plugin_name = 'customercsvimportexport';
        $status = get_option($plugin_name . '_activation_status');
        if( !$status ) {
            $status_icon = '<span style="font-size: 16px" class="dashicons dashicons-warning"></span>';
        } else {
            $status_icon = '<span style="font-size: 16px" class="dashicons dashicons-yes"></span>';
        }
    ?>
    <a href="<?php echo admin_url('admin.php?page=hf_wordpress_customer_im_ex&tab=licence') ?>" class="nav-tab licence-tab <?php echo ($tab == 'licence') ? 'nav-tab-active' : ''; ?>"><?php _e('Licence', 'wf_customer_import_export'); echo '('.$status_icon.') ' ?></a>
    <a href="<?php echo admin_url('admin.php?page=hf_wordpress_customer_im_ex&tab=help') ?>" class="nav-tab <?php echo ($tab == 'help') ? 'nav-tab-active' : ''; ?>"><?php _e('Help', 'wf_customer_import_export'); ?></a>    
</h2>