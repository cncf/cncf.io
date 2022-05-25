<?php
settings_errors(); ?>
<p class="ctf-contents-links" id="general">
    <span>Quick links: </span>
    <?php
    $quick_links = array();
    $quick_links = apply_filters( 'ctf_admin_customize_quick_links', $quick_links );

    foreach ( $quick_links as $quick_link ) {
        echo '<a href="#' . $quick_link[0] . '">' . $quick_link[1] . '</a>';
    }
    ?>
</p>
<form method="post" action="options.php">
    <input type="hidden" name="ctf_options[tab]" value="customize" />
    <?php settings_fields( 'ctf_options' ); // matches the options name ?>
    <?php do_settings_sections( 'ctf_options_general' ); // matches the section name ?>
    <hr>
    <a id="layout"></a>
    <?php do_settings_sections( 'ctf_options_layout' ); // matches the section name ?>
    <hr>
    <a id="showhide"></a>
    <?php do_settings_sections( 'ctf_options_showandhide' ); // matches the section name ?>
    <p class="submit"><input class="button-primary" type="submit" name="save" value="<?php esc_attr_e( 'Save Changes' ); ?>" /></p>
    <hr>
    <a id="media"></a>
    <?php do_settings_sections( 'ctf_options_media' ); // matches the section name ?>
    <hr>
    <?php do_action( 'ctf_admin_add_settings_sections_to_customize' ); ?>
    <a id="misc"></a>
    <?php do_settings_sections( 'ctf_options_misc' ); // matches the section name ?>
    <hr>
    <a id="gdpr"></a>
	<?php do_settings_sections( 'ctf_options_gdpr' ); // matches the section name ?>
    <hr>
    <a id="advanced"></a>
    <?php do_settings_sections('ctf_options_advanced'); // matches the section name
    $usage_tracking = get_option( 'ctf_usage_tracking', false );
    $text_domain = 'custom-twitter-feeds';

    $ctf_usage_tracking_enable = isset( $usage_tracking['enabled'] ) ? $usage_tracking['enabled'] : true;

    // only show this setting after they have opted in or opted out using the admin notice
    ?>
    <table class="form-table" role="presentation">
        <tbody>
        <tr>

            <th scope="row"><label class="bump-left"><?php _e("Enable Usage Tracking", $text_domain ); ?></label></th>
            <td>
                <input name="ctf_usage_tracking_enable" type="hidden" value="off" />
                <input name="ctf_usage_tracking_enable" type="checkbox" id="ctf_usage_tracking_enable" <?php if( $ctf_usage_tracking_enable ) echo "checked"; ?> />
                <label for="ctf_usage_tracking_enable"><?php _e('Yes', $text_domain); ?></label>
                <a class="ctf-tooltip-link" href="JavaScript:void(0);"><?php _e('What is usage tracking?', $text_domain ); ?></a>
                <p class="ctf-tooltip ctf-more-info"><?php _e("Custom Twitter Feeds will record information and statistics about your site in order for the team at Smash Balloon to learn more about how our plugins are used. The plugin will never collect any sensitive information like access tokens, email addresses, or user information.", $text_domain ); echo sprintf( ' ' . __( '%sMore Information%s', 'custom-twitter-feeds'), '<a href="https://smashballoon.com/custom-twitter-feeds/docs/usage-tracking/" target="_blank" rel="noopener noreferrer">', '</a>') ?></p>
            </td>
        </tr>
        </tbody>
    </table>
    <p class="submit"><input class="button-primary" type="submit" name="save" value="<?php esc_attr_e( 'Save Changes' ); ?>" /></p>
</form>
<p><i class="fa fa-chevron-circle-right" aria-hidden="true"></i>&nbsp; <?php _e('<b>Next Step:</b> <a href="?page=custom-twitter-feeds&tab=style">Style your Feed</a>'); ?></p>
