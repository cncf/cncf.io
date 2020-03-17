<?php
$settings = get_option('wt_' . WT_CUSTOMER_IMP_EXP_ID . '_mail_option', null);
$enable_email_templates = !empty($settings['enable_email_templates']) && $settings['enable_email_templates'] == 1? true : false;
$subject_mail = !empty($settings['subject_mail']) ? $settings['subject_mail'] : '';
$body_mail = !empty($settings['body_mail']) ? $settings['body_mail'] : '';

$enable_update_mail_template = !empty($settings['enable_update_mail_template']) && $settings['enable_update_mail_template'] == 1? true : false;
$subject_mail_update = !empty($settings['subject_mail_update']) ? $settings['subject_mail_update'] : '';
$body_mail_update = !empty($settings['body_mail_update']) ? $settings['body_mail_update'] : '';
if(!isset($settings)){
  $register_msg = "<p>Hi###DISPLAYNAME###,
Thanks for creating an account on ###SITENAME### .Your username is ###EMAIL###. You can access your account area to view orders, change your password.
Your password has been generated: ###PASSWORD###
We look forward to seeing you soon.
###SITENAME###</p>";
  
  $update_msg = 'Hi ###USERNAME###,
This notice confirms that your password was changed on ###SITENAME### to ###PASSWORD###.
This email has been sent to ###EMAIL###
Regards,
All at ###SITENAME###
###SITEURL###';
  $body_mail = $register_msg ;
  $body_mail_update = $update_msg;
  $subject_mail = "Your account has been created!";
  $subject_mail_update = "Your account updated!";
}
?>
<div class="cusimpexp tool-box">
    <div class="tool-box bg-white p-20p">
        <h3 class="title aw-title"><?php _e('Email Settings', 'wf_customer_import_export'); ?></h3>
        <p>Send customized email to users on import.</p>        
            <form method="POST" enctype="multipart/form-data" action="admin.php?page=hf_wordpress_customer_im_ex&action=settings&section=email" accept-charset="utf-8">                
                <?php wp_nonce_field(WT_CUSTOMER_IMP_EXP_ID,'wt_nonce') ?>
                <table class="form-table">
                <tr>
                    <td>
                        <h3 class="title"><?php _e('New Users', 'wf_customer_import_export'); ?></h3>
                    </td></tr>
                <tr>
                    <th>
                        <label for="enable_mail_template" style="float: left;"><?php _e('Customize Email Template', 'wf_customer_import_export'); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                        <input id="enable_mail_template" name="enable_email_templates" value="yes" type="checkbox" <?php checked($enable_email_templates); ?>>
                    </th></tr>

                <tr>
                    <td>
                        <table class="form-table" id="email_reg_section">

                            <tr>
                                <td>
                                    <p><?php _e('Email Subject :', 'wf_customer_import_export'); ?><input name="subject_mail" size="100" value="<?php echo $subject_mail; ?>" id="title" autocomplete="off" type="text"></p>
                                </td></tr>
                            <tr>
                                <td>
                                    <?php
                                    $wpsettings = array(
                                        'editor_height' => 450, // In pixels, takes precedence and has no default value
                                    );
                                    wp_editor($body_mail, 'body_mail', $wpsettings);
                                    ?>
                                </td> </tr>


                        </table>
                    </td></tr>
                <tr>
                    <td>
                        <h3 class="title"><?php _e('Update users', 'wf_customer_import_export'); ?></h3>
                    </td></tr>
                <tr>
                    <th>
                        <label for="enable_update_mail_template" style="float: left;"><?php _e('Customize Email Template', 'wf_customer_import_export'); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                        <input id="enable_update_mail_template" name="enable_update_mail_template" value="yes" type="checkbox" <?php checked($enable_update_mail_template); ?>>
                    </th></tr>
                <tr>
                    <td>
                        <table class="form-table" id="email_update_section">

                            <tr>
                                <td>
                                    <p><?php _e('Email Subject :', 'wf_customer_import_export'); ?> &nbsp;<input name="subject_mail_update" size="100" value="<?php echo $subject_mail_update; ?>" id="subject_update" type="text"></p>
                                </td></tr>
                            <tr>
                                <td>
                                    <?php
                                    $wpsettings = array(
                                        'editor_height' => 450, // In pixels, takes precedence and has no default value
                                    );
                                    wp_editor($body_mail_update, 'body_mail_update', $wpsettings);
                                    ?>
                                </td> </tr>

                        </table>
                    </td></tr>
                <tr>
                    <td>
                        <input class="button-primary" type="submit" value="<?php _e('Save template', 'wf_customer_import_export'); ?>" id="save_mail_template_options"/>
                    </td> </tr> 
                </table>
        </form>
    
        <p><?php _e('You can use', 'wf_customer_import_export'); ?></p>
        <ul style="list-style-type:disc; margin-left:2em;">
            <li>###EMAIL### = <?php _e('user email', 'wf_customer_import_export'); ?></li>
            <li>###USERNAME### = <?php _e('username to login', 'wf_customer_import_export'); ?></li>
            <li>###PASSWORD### = <?php _e('user password', 'wf_customer_import_export'); ?></li>
            <li>###LOGINURL### = <?php _e('current site login url', 'wf_customer_import_export'); ?></li>
            <li>###LOSTPASSWORDURL### = <?php _e('lost password url', 'wf_customer_import_export'); ?></li>
            <li>###DISPLAYNAME### = <?php _e('display name', 'wf_customer_import_export'); ?></li>
            <li>###SITENAME### = <?php _e('sitename', 'wf_customer_import_export'); ?></li>
            <li>###SITEURL### = <?php _e('site url', 'wf_customer_import_export'); ?></li>
        </ul>
    </div>
</div>
<script>
 jQuery("#enable_mail_template").click(function () {
        if (this.checked) {
            jQuery("#email_reg_section").show();
        } else {
            jQuery("#email_reg_section").hide();
        }
    });
     jQuery("#enable_update_mail_template").click(function () {
        if (this.checked) {
            jQuery("#email_update_section").show();
        } else {
            jQuery("#email_update_section").hide();
        }
    });
    
jQuery(document).ready(function()
{
    if(jQuery("#enable_mail_template").is(':checked')){
        jQuery("#email_reg_section").show();
    }else{
        jQuery("#email_reg_section").hide();
    }
    if(jQuery("#enable_update_mail_template").is(':checked')){
        jQuery("#email_update_section").show();
    }else{
        jQuery("#email_update_section").hide();
    }
    
});
</script>