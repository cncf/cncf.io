<?php
/*
Plugin Name: miniOrange SSO using SAML 2.0
Plugin URI: http://miniorange.com/
Description: (Standard)miniOrange SAML 2.0 SSO enables user to perform Single Sign On with any SAML 2.0 enabled Identity Provider.
Version: 16.0.1
Author: miniOrange
Author URI: http://miniorange.com/
*/


include_once dirname(__FILE__) . "\57\x6d\157\x5f\x6c\157\x67\x69\156\x5f\x73\141\155\154\137\163\163\x6f\137\x77\x69\x64\x67\145\x74\x2e\160\x68\x70";
include_once "\x78\155\154\163\145\x63\x6c\x69\142\163\x2e\160\x68\x70";
use RobRichards\XMLSecLibs\XMLSecurityKey;
use RobRichards\XMLSecLibs\XMLSecurityDSig;
use RobRichards\XMLSecLibs\XMLSecEnc;
require "\155\157\55\x73\x61\155\x6c\x2d\143\154\x61\163\163\x2d\143\165\x73\164\157\x6d\x65\x72\56\x70\150\160";
require "\x6d\157\137\x73\141\x6d\x6c\137\x73\x65\x74\x74\x69\x6e\147\163\x5f\x70\x61\x67\145\56\160\150\160";
require "\115\x65\x74\141\x64\141\x74\x61\122\x65\x61\x64\x65\x72\x2e\160\x68\x70";
require "\143\145\162\x74\x69\x66\x69\143\x61\164\x65\137\x75\164\151\x6c\x69\x74\x79\x2e\160\150\x70";
require_once "\111\155\160\x6f\x72\x74\55\145\170\x70\157\x72\x74\56\x70\x68\160";
require_once "\155\x6f\55\163\x61\155\154\x2d\x70\x6c\165\x67\x69\156\55\x76\145\162\x73\151\157\156\x2d\165\160\x64\141\x74\x65\x2e\160\x68\x70";
class saml_mo_login
{
    function __construct()
    {
        add_action("\141\x64\x6d\x69\x6e\137\x6d\x65\156\165", array($this, "\155\x69\156\151\157\x72\x61\x6e\x67\x65\x5f\x73\163\157\x5f\x6d\145\156\x75"));
        add_action("\141\144\x6d\x69\156\x5f\x69\156\151\164", array($this, "\x6d\151\x6e\x69\x6f\x72\x61\156\x67\145\137\154\157\x67\151\x6e\x5f\x77\151\x64\x67\145\x74\x5f\x73\141\155\x6c\137\x73\141\x76\x65\x5f\163\x65\164\164\151\156\147\x73"));
        add_action("\x61\x64\x6d\x69\x6e\137\x65\x6e\x71\x75\145\165\x65\x5f\163\143\162\x69\x70\x74\163", array($this, "\x70\x6c\165\x67\x69\x6e\137\163\x65\164\164\x69\156\x67\163\137\163\x74\171\x6c\x65"));
        register_deactivation_hook(__FILE__, array($this, "\x6d\x6f\137\x73\163\157\137\x73\x61\155\x6c\137\x64\145\x61\x63\x74\x69\x76\x61\x74\x65"));
        add_action("\141\144\x6d\x69\x6e\137\145\156\x71\x75\145\x75\x65\x5f\163\143\x72\151\x70\x74\163", array($this, "\x70\154\165\x67\x69\x6e\137\163\x65\x74\x74\x69\156\147\x73\x5f\163\x63\162\x69\160\x74"));
        remove_action("\141\x64\x6d\151\156\137\x6e\x6f\164\x69\x63\145\163", array($this, "\x6d\x6f\x5f\163\x61\155\154\137\163\x75\143\143\x65\163\163\137\155\145\x73\x73\141\147\145"));
        remove_action("\x61\144\x6d\x69\x6e\x5f\x6e\157\x74\x69\x63\x65\163", array($this, "\x6d\x6f\x5f\x73\x61\x6d\x6c\137\145\x72\x72\157\162\137\155\x65\x73\x73\x61\x67\145"));
        add_action("\x77\160\137\141\165\x74\x68\x65\156\x74\151\x63\x61\x74\145", array($this, "\155\157\x5f\x73\x61\x6d\x6c\137\141\x75\164\x68\145\156\164\151\x63\x61\x74\x65"));
        add_action("\167\160", array($this, "\x6d\157\x5f\x73\141\x6d\x6c\x5f\x61\x75\164\x6f\x5f\162\x65\144\x69\x72\145\x63\164"));
        add_action("\141\144\155\x69\x6e\x5f\151\x6e\x69\x74", "\155\x6f\137\x73\x61\155\154\x5f\144\157\x77\x6e\154\157\x61\144");
        add_action("\x6c\x6f\x67\x69\156\137\146\157\162\155", array($this, "\x6d\157\137\163\141\155\154\137\155\x6f\x64\x69\x66\171\137\x6c\157\147\x69\x6e\x5f\146\x6f\x72\x6d"));
        add_shortcode("\x4d\x4f\x5f\x53\101\115\114\x5f\x46\x4f\122\115", array($this, "\155\x6f\x5f\147\x65\x74\x5f\x73\x61\x6d\x6c\137\163\x68\157\162\164\143\x6f\x64\145"));
        add_action("\x61\x64\155\x69\156\x5f\x69\156\151\x74", array($this, "\x64\145\x66\141\x75\154\164\x5f\143\x65\x72\164\151\x66\x69\143\141\x74\145"));
        register_activation_hook(__FILE__, array($this, "\x6d\x6f\137\163\x61\x6d\x6c\x5f\x63\x68\x65\143\153\137\x6f\160\x65\156\163\x73\154"));
        add_action("\160\x6c\165\x67\x69\x6e\x5f\x61\143\164\x69\157\x6e\x5f\154\151\156\x6b\163\x5f" . plugin_basename(__FILE__), array($this, "\x6d\x6f\137\163\x61\x6d\154\137\x70\x6c\165\147\x69\156\x5f\x61\143\x74\151\157\156\137\x6c\x69\156\153\163"));
    }
    function default_certificate()
    {
        $wA = file_get_contents(plugin_dir_path(__FILE__) . "\162\145\163\157\165\162\143\145\163" . DIRECTORY_SEPARATOR . "\163\160\x2d\x63\145\162\x74\x69\x66\x69\x63\x61\164\x65\x2e\143\162\164");
        $QL = file_get_contents(plugin_dir_path(__FILE__) . "\162\145\163\157\x75\162\143\x65\x73" . DIRECTORY_SEPARATOR . "\163\x70\x2d\153\145\171\56\153\x65\x79");
        update_option("\155\157\x5f\163\141\155\154\137\x63\145\x72\164", $wA);
        update_option("\155\x6f\137\x73\x61\x6d\154\137\x63\x65\162\164\x5f\160\162\151\x76\x61\x74\x65\137\x6b\x65\x79", $QL);
    }
    function mo_login_widget_saml_options()
    {
        global $wpdb;
        update_option("\x6d\x6f\x5f\x73\x61\x6d\x6c\x5f\150\x6f\x73\x74\x5f\156\x61\x6d\145", "\150\164\164\160\x73\72\x2f\x2f\154\x6f\147\x69\156\x2e\x78\145\143\165\x72\151\146\171\56\x63\157\x6d");
        $gs = get_option("\155\157\137\x73\141\155\x6c\x5f\150\157\x73\164\137\156\x61\x6d\x65");
        mo_register_saml_sso();
    }
    function mo_saml_check_openssl()
    {
        if (mo_saml_is_extension_installed("\157\x70\145\x6e\163\163\x6c")) {
            goto HS;
        }
        wp_die("\120\x48\x50\x20\157\x70\145\156\163\x73\154\x20\x65\x78\x74\x65\156\163\151\157\x6e\x20\x69\163\x20\156\x6f\164\x20\x69\x6e\x73\164\141\x6c\x6c\x65\144\x20\x6f\x72\40\144\151\163\141\142\x6c\x65\144\x2c\x70\x6c\x65\141\x73\145\40\x65\156\x61\142\x6c\x65\x20\151\x74\x20\164\x6f\x20\x61\143\164\151\x76\x61\x74\x65\x20\164\150\x65\40\160\154\165\147\x69\x6e\x2e");
        HS:
        add_option("\101\x63\x74\151\166\x61\164\x65\x64\137\x50\x6c\x75\147\151\x6e", "\x50\x6c\165\147\151\156\55\x53\x6c\165\x67");
    }
    function mo_saml_success_message()
    {
        $jN = "\145\162\162\x6f\162";
        $QT = get_option("\x6d\157\137\x73\x61\155\x6c\137\x6d\x65\163\163\x61\147\x65");
        echo "\x3c\x64\x69\x76\x20\143\154\141\163\163\75\x27" . $jN . "\x27\x3e\40\74\x70\x3e" . $QT . "\x3c\57\x70\76\x3c\57\144\x69\166\76";
    }
    function mo_saml_error_message()
    {
        $jN = "\165\x70\x64\141\164\145\x64";
        $QT = get_option("\x6d\x6f\x5f\163\x61\x6d\154\137\x6d\145\x73\163\x61\147\x65");
        echo "\x3c\144\151\x76\x20\x63\154\141\163\163\x3d\47" . $jN . "\47\x3e\x20\74\160\x3e" . $QT . "\x3c\57\x70\x3e\74\x2f\x64\151\x76\x3e";
    }
    public function mo_sso_saml_deactivate()
    {
        if (!is_multisite()) {
            goto Px;
        }
        global $wpdb;
        $uH = $wpdb->get_col("\x53\x45\x4c\x45\103\x54\x20\x62\x6c\x6f\x67\x5f\x69\144\40\106\122\117\115\x20{$wpdb->blogs}");
        $ZU = get_current_blog_id();
        do_action("\x6d\x6f\137\163\x61\155\154\x5f\x66\x6c\165\x73\150\x5f\143\141\x63\x68\x65");
        foreach ($uH as $blog_id) {
            switch_to_blog($blog_id);
            delete_option("\155\x6f\137\163\141\155\154\x5f\150\x6f\163\164\x5f\x6e\141\155\x65");
            delete_option("\x6d\157\x5f\163\x61\155\x6c\137\156\x65\167\x5f\x72\x65\147\x69\163\x74\162\x61\x74\x69\157\x6e");
            delete_option("\155\157\x5f\163\141\x6d\154\137\141\144\x6d\151\156\x5f\x70\150\157\156\145");
            delete_option("\x6d\x6f\x5f\x73\x61\155\x6c\137\x61\144\x6d\151\156\x5f\x70\141\163\163\167\x6f\162\x64");
            delete_option("\x6d\x6f\137\x73\x61\x6d\x6c\x5f\166\145\162\151\x66\x79\x5f\143\x75\163\x74\x6f\155\x65\x72");
            delete_option("\x6d\x6f\137\x73\x61\155\x6c\x5f\141\144\x6d\x69\156\x5f\x63\x75\x73\164\x6f\x6d\145\162\x5f\x6b\145\x79");
            delete_option("\155\x6f\137\163\x61\155\x6c\x5f\141\x64\155\151\x6e\137\x61\160\x69\x5f\153\145\171");
            delete_option("\x6d\x6f\x5f\x73\x61\155\x6c\x5f\143\x75\x73\x74\x6f\155\145\162\x5f\x74\x6f\x6b\x65\156");
            delete_option("\155\x6f\x5f\163\x61\x6d\x6c\x5f\155\x65\x73\163\141\x67\145");
            delete_option("\x6d\157\137\x73\x61\155\154\137\x72\145\x67\151\x73\x74\x72\x61\164\151\157\x6e\x5f\x73\x74\141\x74\165\163");
            delete_option("\x6d\157\x5f\163\x61\155\154\137\151\144\x70\x5f\143\x6f\156\x66\x69\147\x5f\143\x6f\155\x70\154\x65\164\145");
            delete_option("\x6d\157\x5f\163\x61\x6d\154\x5f\164\x72\141\156\x73\141\x63\164\x69\x6f\x6e\x49\144");
            delete_option("\166\154\x5f\143\x68\145\143\x6b\x5f\164");
            delete_option("\166\x6c\x5f\143\x68\145\x63\x6b\x5f\163");
            delete_option("\x6d\x6f\137\x73\141\155\154\x5f\x63\145\x72\164");
            delete_option("\x6d\x6f\x5f\x73\x61\x6d\x6c\137\x63\x65\x72\x74\x5f\160\x72\x69\x76\141\164\145\x5f\153\x65\x79");
            delete_option("\155\x6f\x5f\x73\x61\155\154\x5f\x65\x6e\141\142\x6c\145\x5f\143\x6c\157\165\144\x5f\x62\x72\x6f\153\x65\x72");
            DN:
        }
        V4:
        switch_to_blog($ZU);
        goto qi;
        Px:
        do_action("\x6d\157\x5f\x73\141\155\154\x5f\x66\154\x75\163\150\x5f\143\141\x63\150\x65");
        delete_option("\x6d\x6f\137\x73\x61\155\154\137\x68\x6f\163\164\137\x6e\141\x6d\x65");
        delete_option("\x6d\x6f\x5f\163\x61\x6d\x6c\137\x6e\x65\167\137\x72\145\147\x69\163\x74\162\141\x74\x69\157\x6e");
        delete_option("\155\157\137\x73\141\155\x6c\x5f\141\x64\155\151\156\x5f\x70\150\x6f\x6e\x65");
        delete_option("\155\157\x5f\x73\141\155\x6c\137\141\x64\155\151\x6e\137\x70\141\x73\x73\x77\157\x72\x64");
        delete_option("\155\x6f\137\163\141\155\x6c\x5f\166\x65\162\x69\x66\171\x5f\143\x75\x73\x74\x6f\x6d\145\162");
        delete_option("\x6d\x6f\x5f\x73\141\x6d\x6c\x5f\141\144\155\x69\156\137\143\x75\163\x74\x6f\x6d\x65\x72\x5f\x6b\145\x79");
        delete_option("\155\x6f\x5f\163\141\x6d\x6c\137\141\x64\x6d\x69\156\137\141\x70\151\x5f\153\x65\171");
        delete_option("\x6d\x6f\137\163\x61\x6d\154\137\x63\x75\163\164\x6f\155\145\162\137\x74\157\153\x65\x6e");
        delete_option("\x6d\x6f\137\x73\141\155\154\137\155\145\x73\x73\141\x67\145");
        delete_option("\155\157\x5f\163\x61\155\154\x5f\162\145\x67\x69\163\x74\162\x61\x74\x69\157\156\137\163\164\x61\164\165\163");
        delete_option("\x6d\x6f\137\x73\x61\155\154\x5f\151\x64\160\x5f\x63\157\x6e\146\x69\x67\137\x63\157\x6d\160\x6c\145\x74\x65");
        delete_option("\x6d\x6f\137\x73\x61\155\x6c\137\164\x72\x61\x6e\x73\x61\x63\164\151\x6f\x6e\x49\144");
        delete_option("\166\154\x5f\143\x68\x65\x63\x6b\137\x74");
        delete_option("\166\154\137\143\x68\x65\143\x6b\x5f\x73");
        delete_option("\155\x6f\137\163\x61\155\154\137\x63\145\x72\164");
        delete_option("\x6d\157\x5f\x73\x61\x6d\154\x5f\143\x65\162\164\137\x70\162\151\166\141\164\145\x5f\x6b\145\171");
        delete_option("\155\157\137\163\141\155\154\137\145\156\x61\142\154\145\137\x63\154\157\165\144\137\142\x72\157\153\145\x72");
        qi:
    }
    function mo_saml_show_success_message()
    {
        remove_action("\141\144\x6d\x69\x6e\137\x6e\x6f\x74\x69\x63\145\x73", array($this, "\155\x6f\x5f\x73\141\x6d\x6c\x5f\163\165\x63\x63\145\163\x73\x5f\155\145\x73\163\141\147\145"));
        add_action("\x61\x64\155\x69\156\x5f\x6e\x6f\164\x69\x63\145\x73", array($this, "\x6d\157\137\x73\141\155\x6c\x5f\145\x72\162\x6f\x72\137\155\x65\163\x73\141\x67\x65"));
    }
    function mo_saml_show_error_message()
    {
        remove_action("\x61\144\x6d\151\x6e\x5f\x6e\157\164\x69\143\x65\x73", array($this, "\155\157\137\163\141\x6d\x6c\x5f\145\x72\162\157\x72\x5f\155\145\163\x73\141\147\x65"));
        add_action("\x61\144\x6d\x69\x6e\137\156\157\164\151\143\x65\163", array($this, "\155\157\137\x73\141\155\154\137\163\165\143\143\x65\x73\x73\x5f\x6d\x65\x73\163\141\x67\145"));
    }
    function plugin_settings_style($aZ)
    {
        if (!("\x74\157\x70\154\145\166\x65\x6c\137\160\141\147\145\137\155\157\x5f\x73\x61\155\154\137\x73\x65\x74\x74\x69\156\x67\163" != $aZ)) {
            goto V5;
        }
        return;
        V5:
        if (!(isset($_REQUEST["\164\x61\x62"]) && $_REQUEST["\164\141\142"] == "\x6c\151\x63\145\x6e\163\x69\x6e\x67")) {
            goto Xo;
        }
        wp_enqueue_style("\155\157\x5f\x73\141\155\x6c\x5f\142\157\x6f\164\x73\164\162\x61\x70\137\x63\x73\x73", plugins_url("\151\x6e\143\x6c\165\144\145\163\x2f\x63\x73\163\57\x62\157\157\x74\x73\x74\x72\141\160\57\142\157\157\164\163\164\162\x61\x70\x2e\x6d\151\156\56\143\x73\163", __FILE__), array(), "\x31\x36\x2e\x30\x2e\60", "\141\x6c\x6c");
        Xo:
        wp_enqueue_style("\155\x6f\137\x73\141\x6d\x6c\137\x61\144\155\151\156\x5f\163\145\x74\x74\151\156\147\163\137\163\x74\x79\x6c\x65\x5f\x74\x72\141\x63\153\x65\x72", plugins_url("\x69\156\143\154\x75\x64\x65\163\x2f\143\163\x73\57\x70\x72\157\147\x72\145\163\163\x2d\x74\x72\141\x63\153\x65\x72\56\143\163\163", __FILE__), array(), "\61\66\56\60\56\60", "\x61\154\x6c");
        wp_enqueue_style("\x6d\x6f\x5f\163\x61\155\x6c\x5f\141\x64\155\151\156\137\x73\x65\x74\x74\151\x6e\147\163\137\x73\164\171\x6c\x65", plugins_url("\x69\x6e\143\x6c\x75\144\x65\163\x2f\x63\163\x73\x2f\163\164\171\x6c\x65\137\163\145\164\164\151\156\147\163\56\155\x69\156\56\x63\163\163", __FILE__), array(), "\x31\66\56\60\x2e\60", "\141\154\154");
        wp_enqueue_style("\155\157\x5f\163\141\x6d\154\137\141\x64\x6d\x69\156\x5f\x73\145\164\x74\151\156\x67\163\137\x70\x68\x6f\x6e\145\137\163\x74\171\154\145", plugins_url("\x69\156\x63\154\x75\x64\x65\163\57\x63\x73\x73\57\160\x68\x6f\156\x65\x2e\155\151\x6e\x2e\143\163\x73", __FILE__), array(), "\61\x36\x2e\60\x2e\x30", "\x61\154\154");
        wp_enqueue_style("\155\x6f\x5f\x73\141\x6d\154\137\167\x70\142\x2d\x66\141", plugins_url("\x69\x6e\x63\x6c\165\x64\145\x73\57\143\163\x73\x2f\146\x6f\156\x74\55\x61\167\145\x73\157\x6d\145\x2e\x6d\151\156\x2e\x63\163\x73", __FILE__), array(), "\61\66\x2e\60\56\60", "\x61\154\154");
    }
    function plugin_settings_script($aZ)
    {
        if (!("\164\157\x70\x6c\145\x76\x65\x6c\x5f\x70\x61\147\145\x5f\155\x6f\137\x73\141\x6d\x6c\x5f\163\x65\164\164\x69\x6e\x67\163" != $aZ)) {
            goto A1;
        }
        return;
        A1:
        wp_enqueue_script("\152\161\165\x65\162\x79");
        wp_enqueue_script("\x6d\157\137\x73\141\x6d\x6c\x5f\141\144\x6d\151\156\137\x73\x65\164\164\x69\x6e\x67\163\137\163\143\162\151\160\x74", plugins_url("\x69\156\x63\x6c\165\144\x65\163\x2f\x6a\x73\x2f\163\145\x74\x74\151\156\x67\163\56\x6d\151\x6e\x2e\152\x73", __FILE__), array(), "\61\x36\56\x30\56\60", "\141\x6c\x6c");
        wp_enqueue_script("\155\x6f\x5f\x73\x61\x6d\x6c\137\x61\x64\155\151\156\x5f\x73\145\164\164\151\x6e\x67\x73\137\160\x68\157\x6e\145\x5f\x73\x63\162\x69\160\164", plugins_url("\151\x6e\x63\154\x75\x64\145\x73\57\152\163\57\x70\150\x6f\156\x65\56\155\x69\156\56\152\163", __FILE__), array(), "\61\x36\56\x30\56\x30", "\141\x6c\x6c");
        if (!(isset($_REQUEST["\164\x61\x62"]) && $_REQUEST["\164\x61\142"] == "\154\151\143\145\x6e\163\x69\156\147")) {
            goto WH;
        }
        wp_enqueue_script("\155\x6f\x5f\x73\x61\155\154\x5f\155\x6f\x64\x65\162\156\151\172\162\x5f\x73\143\x72\151\x70\x74", plugins_url("\151\156\x63\154\165\x64\145\x73\57\x6a\163\x2f\x6d\157\144\x65\x72\x6e\151\x7a\x72\x2e\152\x73", __FILE__), array(), "\x31\x36\56\60\x2e\x30", "\141\154\154");
        wp_enqueue_script("\x6d\x6f\137\x73\x61\155\154\x5f\x70\157\160\x6f\166\x65\162\x5f\163\143\x72\x69\x70\164", plugins_url("\151\x6e\x63\x6c\x75\x64\x65\x73\57\152\x73\x2f\x62\x6f\157\164\x73\164\162\141\160\x2f\x70\157\x70\x70\x65\x72\x2e\155\151\156\x2e\152\x73", __FILE__), array(), "\x31\x36\56\60\x2e\60", "\x61\154\154");
        wp_enqueue_script("\155\157\x5f\163\x61\155\x6c\137\142\x6f\x6f\164\x73\x74\162\x61\160\x5f\x73\x63\162\151\160\164", plugins_url("\151\x6e\143\154\x75\144\145\163\x2f\152\163\57\x62\157\157\164\163\x74\x72\141\160\x2f\x62\157\157\164\x73\x74\x72\141\160\x2e\155\151\156\x2e\x6a\163", __FILE__), array(), "\61\x36\x2e\x30\56\x30", "\141\x6c\x6c");
        WH:
    }
    function mo_saml_activation_message()
    {
        $jN = "\x75\160\144\x61\164\145\x64";
        $QT = get_option("\x6d\x6f\x5f\163\141\155\x6c\x5f\155\145\163\163\x61\147\x65");
        echo "\x3c\144\151\166\x20\x63\154\141\x73\163\75\x27" . $jN . "\47\x3e\x20\x3c\160\x3e" . $QT . "\x3c\57\160\76\74\57\x64\x69\x76\x3e";
    }
    static function mo_check_option_admin_referer($WI)
    {
        return isset($_POST["\157\160\x74\151\x6f\x6e"]) and $_POST["\x6f\x70\x74\x69\157\156"] == $WI and check_admin_referer($WI);
    }
    function miniorange_login_widget_saml_save_settings()
    {
        if (!current_user_can("\x6d\x61\x6e\x61\147\145\x5f\157\x70\x74\x69\157\x6e\x73")) {
            goto jk;
        }
        if (!(is_admin() && get_option("\x41\143\164\151\x76\x61\x74\145\x64\137\120\x6c\165\x67\151\x6e") == "\120\x6c\165\147\151\156\x2d\123\154\x75\147")) {
            goto G_;
        }
        delete_option("\101\143\164\x69\x76\x61\164\x65\144\x5f\120\x6c\x75\x67\x69\156");
        update_option("\155\157\x5f\163\x61\155\154\x5f\x6d\145\x73\x73\x61\x67\145", "\107\157\40\x74\x6f\40\160\154\x75\147\151\156\40\74\142\x3e\74\141\40\x68\x72\145\146\x3d\x22\x61\144\x6d\x69\156\x2e\160\x68\160\77\160\141\x67\145\x3d\155\157\137\163\x61\155\154\137\163\145\x74\x74\x69\156\x67\x73\42\76\x73\145\164\164\151\x6e\147\163\74\x2f\x61\x3e\74\57\x62\76\x20\x74\x6f\40\x63\157\x6e\x66\x69\147\165\x72\x65\x20\x53\101\x4d\x4c\x20\123\x69\156\147\x6c\145\40\x53\x69\x67\x6e\x20\x4f\x6e\40\142\x79\x20\x6d\x69\x6e\151\x4f\x72\x61\156\147\145\x2e");
        add_action("\x61\144\155\151\156\137\x6e\x6f\164\x69\143\145\x73", array($this, "\155\157\x5f\163\x61\x6d\x6c\x5f\x61\x63\x74\151\x76\x61\164\151\157\156\137\x6d\145\x73\163\x61\x67\145"));
        G_:
        if (!self::mo_check_option_admin_referer("\154\157\x67\151\156\137\x77\x69\x64\x67\x65\x74\x5f\163\141\x6d\x6c\x5f\163\141\x76\x65\137\163\x65\x74\164\151\156\x67\163")) {
            goto TR;
        }
        if (mo_saml_is_extension_installed("\x63\x75\x72\154")) {
            goto Ew;
        }
        update_option("\155\157\x5f\163\x61\x6d\154\137\x6d\x65\x73\x73\141\x67\x65", "\105\122\122\x4f\x52\72\x50\110\120\x20\143\x55\122\114\40\145\x78\x74\x65\x6e\163\151\x6f\x6e\40\x69\163\40\x6e\157\164\40\151\x6e\x73\x74\x61\x6c\154\145\144\40\x6f\162\x20\144\x69\163\141\142\x6c\x65\144\56\x20\x53\141\x76\x65\40\x49\144\145\156\164\151\164\x79\x20\120\162\x6f\x76\x69\144\x65\x72\x20\x43\x6f\x6e\146\x69\147\165\x72\141\x74\151\157\156\x20\x66\x61\x69\x6c\145\144\56");
        $this->mo_saml_show_error_message();
        return;
        Ew:
        $Qz = '';
        $jw = '';
        $HF = '';
        $xZ = '';
        $oz = '';
        $Ou = '';
        $gF = '';
        $ei = '';
        if ($this->mo_saml_check_empty_or_null($_POST["\163\x61\155\154\x5f\151\144\145\156\x74\151\x74\x79\x5f\x6e\x61\155\145"]) || $this->mo_saml_check_empty_or_null($_POST["\163\141\x6d\x6c\137\x6c\x6f\x67\151\x6e\137\x75\162\x6c"]) || $this->mo_saml_check_empty_or_null($_POST["\x73\141\x6d\154\137\151\x73\x73\165\x65\x72"]) || $this->mo_saml_check_empty_or_null($_POST["\x73\x61\155\154\x5f\x6e\141\155\x65\x69\144\x5f\x66\x6f\162\155\141\x74"])) {
            goto Cr;
        }
        if (!preg_match("\57\136\134\167\52\x24\57", $_POST["\x73\141\155\x6c\137\151\x64\145\156\x74\151\164\x79\x5f\x6e\x61\155\145"])) {
            goto b9;
        }
        $Qz = htmlspecialchars(trim($_POST["\x73\141\155\x6c\x5f\151\x64\145\x6e\164\x69\x74\x79\137\156\x61\x6d\x65"]));
        $HF = htmlspecialchars(trim($_POST["\163\x61\x6d\x6c\137\154\157\147\151\156\x5f\x75\162\x6c"]));
        if (!array_key_exists("\x73\x61\155\x6c\137\154\x6f\x67\151\x6e\137\142\151\156\x64\151\x6e\x67\137\x74\x79\160\145", $_POST)) {
            goto ra;
        }
        $jw = htmlspecialchars($_POST["\163\x61\x6d\x6c\x5f\x6c\x6f\x67\x69\x6e\x5f\142\x69\x6e\x64\151\x6e\147\x5f\164\171\160\145"]);
        ra:
        $Ou = htmlspecialchars(trim($_POST["\163\x61\x6d\154\137\151\x73\163\x75\145\162"]));
        $Rf = htmlspecialchars(trim($_POST["\x73\141\155\154\x5f\151\x64\x65\156\x74\x69\164\171\x5f\x70\x72\x6f\166\x69\x64\x65\162\137\147\165\151\x64\145\x5f\x6e\141\x6d\x65"]));
        $gF = $_POST["\x73\141\x6d\154\137\x78\65\x30\x39\x5f\143\145\x72\x74\151\x66\151\143\x61\x74\145"];
        $oz = htmlspecialchars($_POST["\x73\x61\x6d\154\137\156\141\x6d\x65\x69\144\x5f\146\157\162\x6d\x61\164"]);
        goto aO;
        b9:
        update_option("\x6d\157\137\x73\141\155\154\137\x6d\145\163\x73\x61\x67\145", "\120\x6c\x65\x61\163\x65\x20\x6d\141\164\143\150\40\164\150\x65\x20\x72\145\x71\165\x65\x73\x74\x65\144\x20\146\157\x72\x6d\x61\164\40\x66\x6f\162\40\x49\x64\x65\x6e\164\151\x74\x79\x20\x50\162\157\x76\151\144\145\162\40\116\141\155\145\56\x20\x4f\x6e\x6c\171\40\x61\x6c\160\x68\141\x62\145\x74\163\54\40\x6e\165\x6d\142\145\x72\x73\40\141\x6e\x64\x20\165\156\144\x65\162\x73\x63\157\162\145\40\151\163\x20\141\154\154\157\x77\x65\x64\56");
        $this->mo_saml_show_error_message();
        return;
        aO:
        goto mn;
        Cr:
        update_option("\x6d\x6f\137\x73\141\x6d\x6c\137\155\145\x73\x73\141\147\x65", "\101\154\154\x20\164\x68\x65\x20\x66\151\145\x6c\144\x73\x20\x61\162\145\40\x72\145\161\165\x69\162\145\x64\56\x20\120\x6c\x65\141\x73\145\40\145\x6e\x74\x65\x72\x20\x76\x61\154\x69\x64\40\145\x6e\x74\162\x69\145\163\x2e");
        $this->mo_saml_show_error_message();
        return;
        mn:
        update_option("\x73\141\x6d\x6c\137\151\144\145\156\164\x69\164\171\137\x6e\x61\x6d\x65", $Qz);
        update_option("\163\x61\155\154\x5f\x6c\x6f\x67\151\x6e\x5f\142\x69\x6e\144\x69\x6e\x67\137\164\171\x70\145", $jw);
        update_option("\163\141\155\154\x5f\x6c\x6f\147\151\x6e\137\165\162\154", $HF);
        update_option("\x73\141\155\x6c\x5f\x6c\x6f\x67\157\x75\x74\137\142\151\x6e\x64\151\156\x67\x5f\x74\x79\x70\145", $xZ);
        update_option("\x73\x61\155\154\137\151\163\163\165\145\162", $Ou);
        update_option("\x73\x61\155\x6c\137\x6e\x61\x6d\x65\151\144\x5f\x66\157\x72\x6d\141\x74", $oz);
        update_option("\163\141\x6d\154\137\151\x64\x65\156\164\x69\x74\171\x5f\160\162\x6f\x76\151\144\145\162\137\147\165\151\144\145\x5f\156\x61\x6d\x65", $Rf);
        if (isset($_POST["\163\141\155\x6c\137\x72\x65\x71\x75\145\163\x74\x5f\x73\x69\147\x6e\x65\144"])) {
            goto r8;
        }
        update_option("\x73\141\x6d\x6c\x5f\162\x65\x71\165\145\x73\164\x5f\x73\x69\147\x6e\x65\144", "\165\156\x63\x68\x65\143\x6b\x65\144");
        goto EV;
        r8:
        update_option("\x73\x61\x6d\x6c\137\162\x65\x71\165\145\163\x74\x5f\163\x69\147\156\145\144", "\143\x68\145\143\x6b\x65\x64");
        EV:
        foreach ($gF as $ld => $g2) {
            if (empty($g2)) {
                goto B3;
            }
            $gF[$ld] = SAMLSPUtilities::sanitize_certificate($g2);
            if (@openssl_x509_read($gF[$ld])) {
                goto Xb;
            }
            update_option("\x6d\157\137\163\x61\155\154\x5f\x6d\145\x73\163\141\x67\x65", "\111\156\x76\x61\x6c\x69\144\x20\143\x65\162\164\151\146\151\143\x61\x74\x65\x3a\40\120\x6c\145\x61\163\x65\40\x70\162\157\x76\151\144\x65\40\x61\x20\x76\141\x6c\151\x64\40\143\145\x72\164\x69\x66\x69\x63\141\164\145\x2e");
            $this->mo_saml_show_error_message();
            delete_option("\x73\141\x6d\x6c\x5f\170\65\x30\x39\x5f\x63\145\162\x74\151\146\x69\x63\x61\164\x65");
            return;
            Xb:
            goto W3;
            B3:
            unset($gF[$ld]);
            W3:
            SW:
        }
        sv:
        if (!empty($gF)) {
            goto d7;
        }
        update_option("\155\x6f\x5f\x73\141\155\x6c\137\x6d\x65\163\163\141\x67\145", "\x49\x6e\166\x61\154\151\x64\40\103\x65\162\164\151\146\x69\143\141\x74\145\x3a\120\x6c\145\141\163\145\x20\160\x72\157\x76\x69\144\x65\40\141\x20\x63\x65\x72\164\151\x66\151\x63\x61\x74\145");
        $this->mo_saml_show_error_message();
        return;
        d7:
        update_option("\163\141\x6d\x6c\x5f\x78\x35\60\x39\x5f\x63\x65\x72\x74\x69\146\x69\x63\141\164\x65", maybe_serialize($gF));
        if (isset($_POST["\x73\141\x6d\154\x5f\x72\x65\163\x70\157\156\163\145\x5f\x73\151\x67\156\x65\x64"])) {
            goto RP;
        }
        update_option("\163\141\155\x6c\137\x72\145\x73\x70\x6f\x6e\163\x65\137\x73\x69\147\156\x65\144", "\x59\145\163");
        goto Oo;
        RP:
        update_option("\163\x61\x6d\x6c\137\x72\x65\163\x70\x6f\x6e\x73\145\137\163\151\147\x6e\x65\x64", "\143\x68\x65\143\153\145\144");
        Oo:
        if (isset($_POST["\x73\x61\x6d\x6c\x5f\141\x73\163\145\162\164\x69\x6f\x6e\137\163\151\x67\x6e\x65\144"])) {
            goto Xu;
        }
        update_option("\163\141\155\x6c\137\141\x73\x73\145\162\164\151\x6f\x6e\x5f\x73\x69\147\x6e\145\x64", "\131\145\x73");
        goto RN;
        Xu:
        update_option("\x73\141\155\x6c\x5f\141\163\163\x65\x72\164\151\157\x6e\x5f\x73\x69\147\156\145\x64", "\x63\x68\x65\143\153\x65\144");
        RN:
        if (array_key_exists("\145\x6e\141\x62\x6c\x65\137\x69\x63\x6f\156\x76", $_POST)) {
            goto l3;
        }
        update_option("\155\x6f\137\x73\x61\155\x6c\137\x65\x6e\x63\157\144\151\156\x67\x5f\x65\x6e\x61\x62\154\145\x64", '');
        goto AS1;
        l3:
        update_option("\x6d\157\x5f\163\141\x6d\154\137\145\156\143\157\144\151\156\x67\x5f\145\x6e\x61\x62\154\x65\144", "\x63\x68\145\x63\153\x65\144");
        AS1:
        update_option("\155\x6f\x5f\x73\x61\x6d\154\x5f\155\145\163\x73\x61\x67\145", "\x49\144\x65\156\x74\151\164\x79\x20\x50\162\x6f\166\151\144\x65\x72\40\144\x65\x74\141\x69\154\163\40\x73\141\x76\145\144\40\163\165\143\143\145\163\x73\146\165\154\x6c\171\x2e");
        $this->mo_saml_show_success_message();
        TR:
        if (!self::mo_check_option_admin_referer("\x6c\x6f\147\151\x6e\137\167\x69\x64\147\x65\164\137\x73\141\155\154\137\x61\164\164\x72\151\x62\165\x74\145\x5f\155\141\x70\x70\x69\x6e\147")) {
            goto gd;
        }
        if (mo_saml_is_extension_installed("\x63\x75\x72\x6c")) {
            goto KC;
        }
        update_option("\155\x6f\x5f\163\141\x6d\x6c\137\155\145\x73\x73\x61\147\x65", "\x45\x52\x52\x4f\x52\72\120\x48\x50\x20\143\125\x52\x4c\x20\145\x78\x74\x65\x6e\x73\151\x6f\156\40\x69\x73\x20\x6e\157\164\x20\151\x6e\x73\164\x61\x6c\x6c\x65\x64\40\157\162\40\x64\151\x73\x61\142\x6c\145\144\x2e\40\x53\x61\x76\x65\x20\101\164\164\162\151\x62\165\164\x65\x20\x4d\141\x70\160\151\156\147\40\146\x61\x69\x6c\x65\144\56");
        $this->mo_saml_show_error_message();
        return;
        KC:
        update_option("\163\141\x6d\154\x5f\141\155\x5f\x75\x73\x65\162\156\141\155\x65", htmlspecialchars(stripslashes($_POST["\x73\x61\155\x6c\x5f\x61\x6d\x5f\x75\163\x65\162\x6e\x61\155\x65"])));
        update_option("\x73\x61\x6d\154\137\x61\155\x5f\145\x6d\x61\151\x6c", htmlspecialchars(stripslashes($_POST["\x73\141\155\x6c\x5f\141\155\x5f\x65\x6d\x61\x69\x6c"])));
        update_option("\163\141\x6d\x6c\x5f\x61\155\137\146\x69\x72\163\x74\x5f\156\141\155\x65", htmlspecialchars(stripslashes($_POST["\x73\x61\x6d\x6c\137\x61\x6d\x5f\146\x69\x72\163\164\x5f\156\141\x6d\x65"])));
        update_option("\x73\141\155\x6c\137\141\x6d\x5f\x6c\141\x73\164\137\x6e\x61\x6d\x65", htmlspecialchars(stripslashes($_POST["\x73\141\x6d\x6c\137\141\x6d\x5f\x6c\141\163\164\137\x6e\x61\x6d\145"])));
        update_option("\163\x61\155\x6c\x5f\x61\155\x5f\144\151\x73\160\154\141\171\x5f\x6e\141\155\145", htmlspecialchars(stripslashes($_POST["\163\141\155\x6c\x5f\x61\x6d\137\x64\x69\163\x70\154\x61\171\137\x6e\x61\x6d\x65"])));
        update_option("\155\x6f\x5f\163\x61\155\x6c\137\155\145\x73\163\141\147\145", "\x41\164\164\x72\151\142\x75\164\145\x20\x4d\x61\x70\160\151\x6e\x67\x20\144\x65\x74\141\x69\x6c\163\40\x73\x61\166\x65\144\x20\163\165\143\143\x65\163\x73\x66\x75\154\x6c\x79");
        $this->mo_saml_show_success_message();
        gd:
        if (!self::mo_check_option_admin_referer("\x63\x6c\145\141\162\x5f\x61\x74\x74\162\163\137\x6c\x69\x73\x74")) {
            goto BD;
        }
        delete_option("\155\157\137\x73\x61\155\154\137\164\145\163\x74\x5f\x63\x6f\156\x66\151\147\137\x61\164\x74\x72\x73");
        update_option("\155\x6f\137\x73\141\155\154\137\x6d\145\163\x73\x61\147\x65", "\101\164\x74\x72\x69\x62\x75\x74\x65\163\x20\154\x69\163\x74\40\162\x65\x6d\x6f\166\145\144\x20\x73\165\x63\143\x65\x73\x73\x66\x75\154\154\x79");
        $this->mo_saml_show_success_message();
        BD:
        if (!self::mo_check_option_admin_referer("\154\157\x67\151\156\x5f\x77\151\x64\147\145\x74\137\163\141\155\154\137\x72\157\154\145\x5f\155\x61\160\160\151\x6e\147")) {
            goto xQ;
        }
        if (mo_saml_is_extension_installed("\x63\165\x72\x6c")) {
            goto qz;
        }
        update_option("\x6d\157\x5f\163\141\x6d\x6c\137\x6d\x65\x73\x73\141\147\x65", "\x45\x52\122\117\122\x3a\x50\x48\120\40\x63\125\x52\x4c\x20\145\170\x74\145\156\x73\151\x6f\x6e\40\x69\x73\40\x6e\x6f\164\x20\x69\x6e\x73\x74\x61\154\x6c\145\144\x20\x6f\162\x20\144\151\163\141\x62\x6c\x65\x64\x2e\x20\123\141\166\145\40\x52\x6f\x6c\x65\40\x4d\x61\x70\x70\x69\156\147\40\146\141\151\154\145\144\x2e");
        $this->mo_saml_show_error_message();
        return;
        qz:
        if (isset($_POST["\155\x6f\137\163\x61\x6d\x6c\137\144\x6f\156\164\x5f\165\160\x64\141\164\145\x5f\x65\x78\151\163\164\x69\x6e\147\137\165\163\145\162\137\162\157\154\145"])) {
            goto X8;
        }
        update_option("\x73\x61\x6d\x6c\x5f\x61\x6d\x5f\144\x6f\x6e\164\137\165\x70\144\141\164\x65\137\x65\x78\151\x73\x74\151\156\x67\x5f\165\163\x65\x72\x5f\x72\157\x6c\x65", "\x75\x6e\143\150\145\x63\153\x65\144");
        goto mk;
        X8:
        update_option("\x73\x61\155\x6c\137\141\x6d\137\144\x6f\156\164\137\165\x70\144\x61\164\145\x5f\x65\170\x69\x73\164\151\156\x67\137\x75\x73\145\162\x5f\162\157\x6c\145", "\143\x68\x65\x63\x6b\x65\144");
        mk:
        if (!isset($_POST["\163\x61\x6d\154\137\x61\155\x5f\x64\145\146\x61\x75\x6c\x74\137\x75\x73\145\x72\137\162\x6f\154\145"])) {
            goto X1;
        }
        $Am = htmlspecialchars($_POST["\163\x61\x6d\x6c\x5f\141\155\x5f\x64\145\x66\141\165\x6c\164\x5f\165\163\145\x72\137\162\x6f\x6c\x65"]);
        update_option("\x73\141\155\154\x5f\x61\155\x5f\x64\x65\146\141\165\154\164\137\165\163\145\162\x5f\x72\x6f\154\145", $Am);
        X1:
        update_option("\x6d\x6f\137\x73\x61\x6d\154\137\155\x65\x73\x73\x61\x67\x65", "\x52\x6f\x6c\x65\x20\115\x61\160\x70\151\156\x67\40\x64\x65\164\x61\151\x6c\x73\x20\163\x61\x76\x65\144\40\163\165\143\x63\x65\x73\x73\146\165\x6c\x6c\x79\x2e");
        $this->mo_saml_show_success_message();
        xQ:
        if (!self::mo_check_option_admin_referer("\x6d\157\137\163\141\155\154\137\165\x70\x64\x61\x74\x65\137\151\x64\160\137\x73\145\164\x74\x69\156\x67\x73\x5f\157\x70\x74\x69\157\156")) {
            goto LZ;
        }
        if (!(isset($_POST["\x6d\157\137\163\x61\x6d\154\137\163\x70\x5f\x62\x61\x73\145\137\165\162\154"]) && isset($_POST["\155\x6f\x5f\x73\141\x6d\154\137\163\x70\x5f\x65\156\164\151\x74\x79\x5f\151\x64"]))) {
            goto af;
        }
        $co = sanitize_text_field($_POST["\x6d\157\137\163\141\155\154\137\163\x70\x5f\x62\141\x73\x65\137\x75\x72\154"]);
        $J4 = sanitize_text_field($_POST["\155\157\137\x73\x61\x6d\154\137\163\160\137\145\156\x74\151\164\171\137\151\144"]);
        if (!(substr($co, -1) == "\x2f")) {
            goto ij;
        }
        $co = substr($co, 0, -1);
        ij:
        update_option("\155\x6f\137\x73\141\155\x6c\137\163\x70\137\x62\x61\163\145\x5f\x75\162\154", $co);
        update_option("\x6d\157\137\163\141\x6d\154\137\163\160\137\145\x6e\x74\x69\x74\x79\137\x69\x64", $J4);
        af:
        update_option("\x6d\x6f\x5f\163\x61\155\154\x5f\x6d\x65\163\163\141\147\x65", "\x53\145\164\x74\151\156\x67\163\x20\x75\x70\x64\x61\x74\x65\144\x20\163\x75\x63\x63\145\163\163\146\x75\x6c\154\x79\x2e");
        $this->mo_saml_show_success_message();
        LZ:
        if (!self::mo_check_option_admin_referer("\x73\141\x6d\154\137\x75\x70\154\157\141\x64\x5f\155\145\x74\141\144\141\x74\141")) {
            goto pu;
        }
        if (function_exists("\x77\160\x5f\x68\x61\156\x64\x6c\x65\137\165\160\x6c\157\x61\x64")) {
            goto uR;
        }
        require_once ABSPATH . "\x77\x70\55\141\144\155\x69\156\x2f\x69\156\143\x6c\x75\x64\145\163\x2f\x66\x69\154\145\56\x70\150\x70";
        uR:
        $this->_handle_upload_metadata();
        pu:
        if (!self::mo_check_option_admin_referer("\155\x6f\137\x73\141\x6d\154\137\x72\x65\154\141\x79\x5f\x73\164\141\164\x65\137\157\x70\164\x69\157\156")) {
            goto GW;
        }
        $f6 = sanitize_text_field($_POST["\x6d\157\137\163\x61\155\154\x5f\x72\x65\154\x61\x79\137\x73\164\141\x74\145"]);
        update_option("\x6d\157\137\x73\x61\155\x6c\137\x72\145\x6c\x61\x79\x5f\163\164\x61\164\145", $f6);
        update_option("\155\157\137\163\141\x6d\x6c\x5f\x6d\x65\163\163\x61\147\145", "\x53\123\x4f\x20\160\x61\147\x65\x20\x75\160\144\141\x74\145\x64\x20\x73\165\143\143\x65\163\x73\146\165\x6c\x6c\x79\x2e");
        $this->mo_saml_show_success_message();
        GW:
        if (!self::mo_check_option_admin_referer("\x6d\x6f\137\x73\141\155\x6c\x5f\x77\x69\144\x67\x65\x74\x5f\157\160\x74\151\157\x6e")) {
            goto wZ;
        }
        $K2 = sanitize_text_field($_POST["\x6d\x6f\137\163\141\155\x6c\137\x63\x75\163\x74\x6f\x6d\x5f\154\157\x67\x69\x6e\x5f\x74\145\x78\x74"]);
        update_option("\155\157\x5f\x73\141\x6d\x6c\137\x63\165\163\164\x6f\155\x5f\x6c\157\x67\151\x6e\x5f\x74\145\x78\164", stripcslashes($K2));
        $FX = sanitize_text_field($_POST["\155\157\137\163\141\155\x6c\x5f\143\165\163\x74\x6f\x6d\x5f\147\x72\145\145\x74\151\x6e\147\137\164\x65\170\x74"]);
        update_option("\x6d\157\x5f\x73\x61\x6d\x6c\x5f\143\165\x73\164\157\155\137\x67\162\x65\x65\x74\151\x6e\x67\x5f\x74\145\x78\164", stripcslashes($FX));
        $rM = sanitize_text_field($_POST["\155\x6f\x5f\163\x61\x6d\x6c\x5f\147\x72\x65\x65\x74\x69\x6e\147\x5f\156\x61\155\145"]);
        update_option("\x6d\x6f\137\163\x61\155\154\137\x67\x72\145\145\x74\x69\x6e\147\x5f\x6e\x61\155\x65", stripcslashes($rM));
        $t2 = sanitize_text_field($_POST["\155\157\x5f\163\141\x6d\x6c\x5f\x63\x75\x73\164\x6f\155\137\x6c\157\147\x6f\165\164\137\164\x65\170\x74"]);
        update_option("\155\157\137\x73\141\x6d\154\x5f\143\x75\163\x74\157\x6d\137\154\x6f\x67\x6f\x75\164\x5f\x74\145\170\x74", stripcslashes($t2));
        update_option("\x6d\157\137\163\141\155\x6c\137\155\x65\163\163\141\x67\145", "\127\151\144\147\145\164\40\x53\145\x74\164\x69\156\147\x73\40\165\160\x64\141\x74\145\144\x20\x73\x75\143\x63\x65\x73\x73\146\165\154\x6c\x79\x2e");
        $this->mo_saml_show_success_message();
        wZ:
        if (!self::mo_check_option_admin_referer("\163\x61\x6d\x6c\x5f\147\x65\x6e\145\x72\141\x74\145\x5f\143\145\x72\x74\x69\x66\151\x63\141\164\145")) {
            goto pY;
        }
        $Ns = array("\143\x6f\165\156\164\162\171\116\x61\155\145" => htmlspecialchars($_POST["\143\157\165\156\x74\162\x79"]), "\x73\x74\141\164\145\x4f\x72\x50\x72\157\166\151\x6e\x63\145\116\x61\155\145" => htmlspecialchars($_POST["\163\164\141\164\x65"]), "\x6c\x6f\143\x61\x6c\151\x74\x79\x4e\141\155\145" => htmlspecialchars($_POST["\154\x6f\143\x61\x6c\151\164\171"]), "\157\x72\147\141\x6e\151\172\x61\x74\x69\157\x6e\x4e\x61\x6d\x65" => htmlspecialchars($_POST["\x6f\x72\x67"]), "\157\162\147\x61\x6e\151\172\141\x74\x69\x6f\156\x61\x6c\x55\156\151\x74\x4e\x61\x6d\145" => htmlspecialchars($_POST["\x6f\162\147\137\165\x6e\x69\x74"]), "\143\157\155\x6d\x6f\156\116\141\x6d\x65" => htmlspecialchars($_POST["\x63\x6e"]), "\145\155\x61\x69\x6c\101\144\x64\162\x65\163\x73" => htmlspecialchars($_POST["\x65\x6d\141\x69\x6c"]));
        $kL = array("\x64\x69\147\145\163\164\137\x61\x6c\x67" => htmlspecialchars($_POST["\x68\x61\x73\x68\x5f\x61\154\x67\157\x72\x69\164\150\x6d"]), "\x78\x35\60\x39\x5f\x65\x78\164\x65\156\x73\151\157\156\163" => "\x76\63\137\x63\x61", "\x70\162\151\166\x61\164\x65\137\x6b\x65\171\137\x62\151\x74\163" => 2048, "\x70\x72\151\166\141\164\145\x5f\153\x65\x79\137\x74\x79\160\x65" => OPENSSL_KEYTYPE_RSA, "\x65\x6e\143\162\x79\160\x74\x5f\x6b\145\x79" => false);
        $zX = CertificateUtility::generate_certificate($Ns, $kL, (int) $_POST["\x65\170\x70\151\162\171\137\x64\141\171\x73"]);
        $HW = plugin_dir_path(__FILE__) . "\x72\x65\x73\157\165\x72\x63\145\163" . DIRECTORY_SEPARATOR . "\x73\160\x2d\143\x65\162\164\x69\x66\151\143\141\164\x65\x2e\x63\162\x74";
        $t8 = plugin_dir_path(__FILE__) . "\x72\145\163\x6f\165\x72\143\x65\163" . DIRECTORY_SEPARATOR . "\x73\160\55\x6b\145\171\x2e\x6b\x65\x79";
        $cI = plugin_dir_path(__FILE__) . "\x72\145\x73\x6f\x75\162\x63\x65\163" . DIRECTORY_SEPARATOR . "\163\x70\55\143\x65\162\x74\151\146\x69\143\x61\164\145\56\x63\x72\164\56\142\x61\x63\x6b\165\160";
        if (file_exists($cI)) {
            goto Ih;
        }
        $vV = plugin_dir_path(__FILE__) . "\162\x65\x73\x6f\165\162\x63\x65\x73" . DIRECTORY_SEPARATOR . "\x73\160\x2d\x6b\145\x79\x2e\x6b\x65\x79\x2e\142\x61\143\153\165\160";
        copy($HW, $cI);
        copy($t8, $vV);
        Ih:
        $Ad = file_put_contents($HW, $zX["\x70\x75\x62\x6c\x69\x63\x5f\153\x65\x79"]);
        $Ad = $Ad && file_put_contents($t8, $zX["\160\x72\151\166\x61\164\145\137\x6b\x65\x79"]);
        if ($Ad) {
            goto Qi;
        }
        update_option("\155\x6f\137\163\141\x6d\154\137\155\145\163\163\141\147\145", "\105\162\x72\x6f\x72\x20\157\x63\143\x75\x72\x65\144\x20\x77\150\151\x6c\145\40\x67\x65\x6e\x65\x72\141\x74\151\x6e\x67\x20\x74\150\145\40\143\145\x72\164\151\146\151\x63\141\x74\145\163\56\x20\123\145\x65\x20\120\x48\120\x20\x65\162\162\157\x72\40\154\157\147\x73\x20\141\x6e\x64\x20\x6d\141\153\x65\40\x73\x75\162\145\x20\150\x61\x76\145\40\x73\x65\164\x20\167\162\151\164\145\x20\160\145\162\155\151\x73\x73\x69\157\x6e\56");
        $this->mo_saml_show_error_message();
        goto eo;
        Qi:
        update_option("\x6d\x6f\137\163\141\155\x6c\x5f\x6d\x65\x73\x73\x61\147\145", "\x4e\145\167\40\143\145\x72\164\x69\x66\x69\x63\141\x74\x65\163\40\x67\x65\156\x65\x72\141\164\x65\x64\x20\163\165\143\x63\145\163\163\x66\165\x6c\154\171\56");
        $this->mo_saml_show_success_message();
        eo:
        pY:
        if (!self::mo_check_option_admin_referer("\155\x6f\137\x73\141\155\154\137\162\x65\x67\x69\163\x74\x65\x72\137\x63\x75\163\x74\x6f\155\145\x72")) {
            goto TI;
        }
        if (mo_saml_is_extension_installed("\143\165\x72\154")) {
            goto Qc;
        }
        update_option("\x6d\157\x5f\x73\141\x6d\x6c\137\155\145\x73\x73\x61\147\145", "\x45\122\x52\x4f\122\72\x20\x50\110\120\x20\x63\125\x52\x4c\40\x65\x78\x74\x65\156\x73\x69\x6f\x6e\x20\151\163\x20\x6e\157\x74\x20\x69\x6e\x73\x74\x61\154\x6c\x65\x64\x20\157\x72\x20\144\151\163\x61\142\154\145\x64\56\40\122\x65\147\151\x73\x74\162\x61\x74\151\x6f\156\x20\x66\x61\x69\x6c\x65\144\56");
        $this->mo_saml_show_error_message();
        return;
        Qc:
        $hy = '';
        $Uf = '';
        $JV = '';
        $y7 = '';
        if ($this->mo_saml_check_empty_or_null($_POST["\145\155\x61\x69\154"]) || $this->mo_saml_check_empty_or_null($_POST["\x70\x61\x73\163\167\x6f\x72\144"]) || $this->mo_saml_check_empty_or_null($_POST["\143\x6f\x6e\146\x69\x72\155\120\x61\x73\163\x77\x6f\162\x64"])) {
            goto nV;
        }
        if (strlen($_POST["\x70\141\163\x73\x77\157\162\x64"]) < 6 || strlen($_POST["\x63\157\x6e\x66\151\162\x6d\120\141\x73\x73\x77\157\x72\144"]) < 6) {
            goto CU;
        }
        if (!filter_var($_POST["\145\x6d\x61\x69\x6c"], FILTER_VALIDATE_EMAIL)) {
            goto KY;
        }
        if ($this->checkPasswordPattern(strip_tags($_POST["\160\141\163\x73\x77\157\x72\144"]))) {
            goto LY;
        }
        $hy = sanitize_email($_POST["\145\x6d\141\x69\154"]);
        $Uf = sanitize_text_field($_POST["\x70\150\157\156\145"]);
        $JV = stripslashes(strip_tags($_POST["\160\x61\163\x73\167\x6f\x72\144"]));
        $y7 = stripslashes(strip_tags($_POST["\143\157\156\x66\x69\x72\155\120\x61\163\x73\167\x6f\x72\x64"]));
        goto sP;
        LY:
        update_option("\155\x6f\x5f\x73\141\155\x6c\137\155\145\x73\x73\x61\x67\x65", "\115\x69\x6e\x69\x6d\x75\x6d\x20\x36\x20\x63\150\x61\162\x61\143\x74\145\x72\163\x20\x73\x68\x6f\x75\x6c\x64\x20\142\x65\40\160\x72\x65\x73\x65\x6e\x74\56\40\115\141\x78\x69\x6d\165\x6d\x20\x31\65\x20\143\x68\141\162\141\x63\x74\x65\162\x73\x20\163\x68\x6f\165\154\144\40\x62\x65\x20\x70\162\x65\x73\x65\156\164\x2e\40\117\156\154\x79\40\146\x6f\x6c\x6c\x6f\167\x69\156\x67\x20\163\x79\155\x62\157\154\163\x20\50\x21\x40\x23\x2e\44\45\x5e\46\52\x2d\137\x29\x20\163\x68\157\x75\x6c\144\x20\142\145\x20\x70\162\x65\x73\x65\156\164\x2e");
        $this->mo_saml_show_error_message();
        return;
        sP:
        goto mR;
        KY:
        update_option("\155\157\137\x73\141\x6d\154\137\155\x65\x73\x73\x61\x67\x65", "\x50\154\145\141\x73\145\x20\145\x6e\x74\x65\x72\40\x61\x20\x76\x61\x6c\x69\x64\40\145\155\x61\x69\x6c\x20\x61\144\x64\162\145\163\163\56");
        $this->mo_saml_show_error_message();
        return;
        mR:
        goto MF;
        CU:
        update_option("\155\x6f\x5f\x73\x61\155\154\x5f\155\x65\x73\x73\141\147\x65", "\x43\x68\x6f\157\163\x65\x20\141\40\x70\x61\163\163\167\x6f\x72\x64\40\x77\151\164\x68\x20\155\151\156\x69\x6d\x75\x6d\x20\x6c\x65\x6e\x67\x74\x68\40\66\56");
        $this->mo_saml_show_error_message();
        return;
        MF:
        goto vk;
        nV:
        update_option("\155\157\137\x73\141\155\154\137\x6d\x65\163\163\141\x67\x65", "\x41\154\x6c\40\x74\150\x65\x20\146\x69\145\x6c\x64\x73\40\x61\x72\x65\40\x72\x65\x71\x75\151\162\145\x64\x2e\40\x50\154\x65\x61\163\145\x20\145\x6e\x74\145\x72\x20\166\x61\154\151\x64\x20\x65\x6e\164\162\x69\145\x73\56");
        $this->mo_saml_show_error_message();
        return;
        vk:
        update_option("\x6d\x6f\x5f\x73\x61\155\154\x5f\141\x64\155\x69\156\137\145\x6d\x61\x69\x6c", $hy);
        update_option("\155\157\137\163\x61\x6d\x6c\x5f\x61\x64\155\x69\156\137\x70\x68\157\156\145", $Uf);
        if (strcmp($JV, $y7) == 0) {
            goto Qk;
        }
        update_option("\x6d\x6f\x5f\163\141\x6d\x6c\137\x6d\145\x73\163\141\x67\145", "\120\141\x73\x73\167\157\162\x64\x73\40\x64\157\x20\x6e\157\164\40\x6d\x61\x74\x63\x68\56");
        delete_option("\155\x6f\x5f\x73\141\x6d\154\137\166\145\x72\151\x66\171\137\143\x75\163\164\157\155\x65\162");
        $this->mo_saml_show_error_message();
        goto jY;
        Qk:
        update_option("\155\x6f\137\163\141\x6d\x6c\x5f\141\144\x6d\x69\156\x5f\x70\x61\163\x73\167\x6f\162\x64", $JV);
        $hy = get_option("\x6d\x6f\x5f\x73\x61\x6d\x6c\x5f\141\144\x6d\151\x6e\137\x65\155\141\151\154");
        $ko = new CustomerSaml();
        $Gs = $ko->check_customer();
        if ($Gs) {
            goto aN;
        }
        return;
        aN:
        $Gs = json_decode($Gs, true);
        if (strcasecmp($Gs["\x73\x74\141\164\x75\163"], "\x43\125\123\x54\x4f\x4d\x45\x52\137\116\x4f\x54\x5f\x46\x4f\x55\116\x44") == 0) {
            goto Wj;
        }
        $this->get_current_customer();
        goto HY;
        Wj:
        $Gs = $ko->send_otp_token($hy, '');
        if ($Gs) {
            goto Sc;
        }
        return;
        Sc:
        $Gs = json_decode($Gs, true);
        if (strcasecmp($Gs["\x73\164\x61\164\165\x73"], "\x53\125\x43\103\x45\123\123") == 0) {
            goto hG;
        }
        update_option("\155\157\137\x73\x61\x6d\154\x5f\x6d\x65\x73\x73\x61\147\x65", "\124\x68\x65\x72\145\x20\167\x61\163\x20\x61\x6e\40\145\162\162\x6f\x72\40\151\x6e\40\163\145\x6e\x64\151\x6e\x67\40\x65\155\141\x69\154\56\40\x50\154\145\141\163\x65\x20\x76\x65\x72\x69\146\x79\40\171\157\165\162\40\x65\x6d\x61\x69\154\x20\141\156\144\x20\164\x72\171\x20\141\147\141\x69\x6e\x2e");
        update_option("\x6d\x6f\x5f\x73\x61\x6d\x6c\x5f\162\x65\x67\151\163\164\162\141\x74\x69\157\156\x5f\x73\x74\141\164\x75\163", "\x4d\117\x5f\x4f\x54\120\137\104\x45\114\x49\x56\x45\x52\x45\x44\x5f\106\x41\x49\114\125\x52\x45\x5f\x45\115\101\111\114");
        $this->mo_saml_show_error_message();
        goto Dd;
        hG:
        update_option("\155\x6f\137\x73\141\x6d\x6c\137\155\145\x73\x73\141\x67\x65", "\x20\101\40\x6f\156\145\x20\164\x69\155\145\40\160\x61\x73\x73\x63\x6f\144\145\x20\151\x73\40\163\x65\156\164\x20\164\157\40" . get_option("\x6d\157\x5f\163\x61\155\154\137\141\144\x6d\151\156\x5f\145\x6d\141\x69\154") . "\56\x20\120\x6c\x65\141\x73\145\40\x65\156\x74\x65\x72\x20\x74\x68\x65\40\x6f\x74\x70\x20\150\145\x72\145\40\164\157\40\x76\145\x72\151\146\171\x20\x79\x6f\x75\x72\40\x65\x6d\x61\151\x6c\x2e");
        update_option("\x6d\x6f\137\163\141\155\154\137\164\162\x61\156\x73\x61\143\x74\151\157\156\111\x64", $Gs["\164\170\x49\144"]);
        update_option("\155\x6f\x5f\163\x61\155\x6c\x5f\162\x65\147\151\x73\164\162\x61\164\151\157\x6e\x5f\163\x74\x61\x74\165\x73", "\115\x4f\137\x4f\x54\120\137\104\x45\x4c\111\x56\x45\122\x45\104\137\x53\x55\103\x43\x45\x53\x53\x5f\105\x4d\x41\x49\x4c");
        $this->mo_saml_show_success_message();
        Dd:
        HY:
        jY:
        TI:
        if (self::mo_check_option_admin_referer("\x6d\x6f\137\163\x61\155\x6c\x5f\166\141\154\151\x64\x61\164\145\x5f\157\164\160")) {
            goto uC;
        }
        if (self::mo_check_option_admin_referer("\155\157\x5f\x73\141\x6d\154\x5f\x76\x65\x72\x69\146\171\x5f\154\151\x63\145\x6e\x73\145")) {
            goto vM;
        }
        if (self::mo_check_option_admin_referer("\x6d\157\137\x73\141\155\154\137\x63\x6f\x6e\164\x61\143\164\x5f\x75\163\137\161\165\x65\162\x79\137\157\x70\164\x69\157\156")) {
            goto fZ;
        }
        if (self::mo_check_option_admin_referer("\155\x6f\137\x73\x61\155\154\137\162\x65\x73\x65\x6e\144\x5f\x6f\164\160\137\x65\155\141\x69\154")) {
            goto nu;
        }
        if (self::mo_check_option_admin_referer("\x6d\x6f\x5f\x73\x61\155\x6c\137\x72\x65\163\145\x6e\x64\x5f\x6f\164\x70\x5f\x70\x68\x6f\x6e\145")) {
            goto YS;
        }
        if (self::mo_check_option_admin_referer("\155\157\x5f\x73\x61\x6d\154\137\147\157\x5f\x62\x61\143\153")) {
            goto u6;
        }
        if (self::mo_check_option_admin_referer("\155\157\137\x73\141\155\x6c\137\162\x65\147\151\x73\x74\145\x72\137\x77\x69\x74\x68\x5f\160\150\x6f\x6e\145\x5f\x6f\160\164\151\157\156")) {
            goto GQ;
        }
        if (self::mo_check_option_admin_referer("\x6d\x6f\137\x73\x61\x6d\x6c\x5f\162\145\147\x69\x73\x74\145\x72\x65\144\137\x6f\x6e\154\171\137\141\x63\143\145\163\163\137\x6f\x70\164\x69\x6f\x6e")) {
            goto e9;
        }
        if (self::mo_check_option_admin_referer("\155\157\137\163\141\155\x6c\x5f\x66\x6f\162\143\x65\x5f\x61\x75\164\150\x65\x6e\164\x69\143\x61\x74\x69\157\156\137\157\x70\x74\x69\x6f\156")) {
            goto vC;
        }
        if (self::mo_check_option_admin_referer("\155\157\x5f\163\x61\x6d\154\x5f\145\156\x61\x62\x6c\145\x5f\x72\163\163\x5f\x61\x63\x63\x65\x73\x73\x5f\157\x70\164\151\157\x6e")) {
            goto bl;
        }
        if (self::mo_check_option_admin_referer("\155\157\137\163\x61\155\154\x5f\145\x6e\x61\x62\154\145\137\154\x6f\147\151\x6e\x5f\x72\145\x64\x69\x72\x65\x63\164\x5f\157\x70\x74\151\x6f\x6e")) {
            goto Kn;
        }
        if (self::mo_check_option_admin_referer("\x6d\157\137\x73\x61\155\x6c\137\141\154\x6c\x6f\167\x5f\x77\160\x5f\163\x69\x67\156\x69\156\x5f\157\x70\164\151\x6f\x6e")) {
            goto Eg;
        }
        if (isset($_POST["\x6f\x70\x74\151\157\156"]) && $_POST["\x6f\160\164\x69\x6f\156"] == "\x6d\x6f\x5f\163\x61\x6d\x6c\x5f\x66\157\x72\x67\157\164\137\x70\141\x73\x73\x77\157\162\x64\x5f\x66\157\x72\x6d\137\x6f\x70\x74\151\x6f\156") {
            goto p8;
        }
        if (!self::mo_check_option_admin_referer("\155\x6f\137\163\141\x6d\x6c\137\166\145\162\x69\x66\171\x5f\x63\x75\163\x74\157\x6d\x65\x72")) {
            goto aw;
        }
        if (mo_saml_is_extension_installed("\143\x75\162\154")) {
            goto Cf;
        }
        update_option("\x6d\x6f\x5f\163\141\x6d\x6c\137\155\x65\163\x73\141\x67\x65", "\105\122\122\x4f\x52\x3a\x20\x50\110\x50\x20\x63\125\x52\x4c\x20\x65\x78\x74\145\156\163\151\x6f\x6e\x20\x69\x73\x20\156\x6f\x74\x20\151\x6e\163\x74\x61\154\154\x65\144\x20\157\x72\40\x64\151\x73\141\x62\x6c\145\144\x2e\40\114\157\x67\151\156\x20\x66\x61\151\x6c\145\144\56");
        $this->mo_saml_show_error_message();
        return;
        Cf:
        $hy = '';
        $JV = '';
        if ($this->mo_saml_check_empty_or_null($_POST["\x65\155\x61\x69\x6c"]) || $this->mo_saml_check_empty_or_null($_POST["\x70\x61\163\x73\167\x6f\x72\144"])) {
            goto Hq;
        }
        if ($this->checkPasswordPattern(strip_tags($_POST["\x70\x61\163\163\167\157\x72\x64"]))) {
            goto Sv;
        }
        $hy = sanitize_email($_POST["\145\x6d\141\151\x6c"]);
        $JV = stripslashes(strip_tags($_POST["\160\x61\163\x73\x77\157\162\144"]));
        goto aQ;
        Sv:
        update_option("\155\157\137\163\x61\155\154\x5f\x6d\x65\x73\163\x61\147\x65", "\115\x69\x6e\151\x6d\165\x6d\x20\66\40\143\150\x61\162\141\x63\164\145\x72\163\40\163\150\x6f\165\154\144\x20\x62\145\40\x70\162\x65\163\145\156\164\x2e\x20\x4d\141\x78\x69\x6d\165\x6d\40\61\65\x20\x63\150\141\162\x61\x63\164\145\x72\163\40\x73\x68\x6f\x75\x6c\x64\x20\x62\x65\x20\x70\162\145\163\x65\156\164\x2e\40\117\x6e\154\171\x20\x66\157\154\154\x6f\x77\x69\x6e\147\40\163\171\x6d\x62\157\x6c\x73\40\x28\x21\x40\43\56\44\45\x5e\46\x2a\55\x5f\51\x20\163\150\157\165\x6c\144\x20\x62\145\x20\160\x72\145\x73\145\x6e\164\56");
        $this->mo_saml_show_error_message();
        return;
        aQ:
        goto xp;
        Hq:
        update_option("\x6d\x6f\x5f\163\141\155\154\x5f\x6d\x65\163\x73\x61\147\x65", "\101\154\154\40\x74\x68\x65\40\146\151\x65\154\x64\x73\40\141\162\145\x20\162\x65\x71\165\x69\x72\x65\144\x2e\x20\120\154\145\x61\x73\x65\x20\145\156\x74\x65\x72\x20\166\141\x6c\x69\x64\40\145\x6e\164\162\x69\145\x73\x2e");
        $this->mo_saml_show_error_message();
        return;
        xp:
        update_option("\x6d\157\137\x73\x61\155\x6c\137\x61\x64\x6d\151\156\137\145\x6d\x61\151\x6c", $hy);
        update_option("\x6d\x6f\137\163\x61\x6d\154\x5f\x61\144\x6d\x69\156\x5f\x70\x61\163\x73\167\157\x72\144", $JV);
        $ko = new Customersaml();
        $Gs = $ko->get_customer_key();
        if ($Gs) {
            goto lV;
        }
        return;
        lV:
        $zs = json_decode($Gs, true);
        if (json_last_error() == JSON_ERROR_NONE) {
            goto oU;
        }
        update_option("\x6d\x6f\x5f\x73\141\x6d\154\137\x6d\145\163\x73\x61\x67\x65", "\111\156\x76\x61\154\x69\144\x20\x75\163\x65\162\156\141\x6d\145\x20\157\162\40\160\141\163\163\167\157\162\144\56\40\120\x6c\145\141\x73\145\40\164\162\171\x20\x61\147\141\151\x6e\56");
        $this->mo_saml_show_error_message();
        goto oO;
        oU:
        update_option("\155\157\x5f\163\141\x6d\x6c\x5f\x61\144\x6d\151\156\137\143\x75\x73\164\157\x6d\145\162\137\x6b\145\x79", $zs["\x69\144"]);
        update_option("\155\x6f\x5f\x73\x61\x6d\154\137\x61\144\155\151\x6e\137\141\160\x69\137\153\x65\171", $zs["\141\x70\x69\113\x65\x79"]);
        update_option("\155\x6f\x5f\x73\141\155\x6c\137\143\x75\163\x74\x6f\155\145\162\137\x74\157\153\145\x6e", $zs["\x74\157\x6b\x65\x6e"]);
        if (empty($zs["\x70\150\x6f\156\145"])) {
            goto hA;
        }
        update_option("\155\157\x5f\x73\x61\155\x6c\x5f\x61\144\x6d\151\x6e\x5f\160\x68\157\156\x65", $zs["\160\x68\157\156\145"]);
        hA:
        update_option("\155\157\x5f\x73\141\x6d\154\x5f\141\x64\x6d\151\x6e\137\160\x61\163\x73\167\x6f\x72\x64", '');
        update_option("\155\x6f\137\163\141\x6d\154\x5f\155\145\x73\163\141\x67\145", "\x43\165\163\x74\x6f\x6d\x65\x72\40\162\x65\164\x72\151\145\x76\x65\x64\x20\x73\165\143\x63\x65\163\163\146\x75\154\154\171");
        update_option("\155\x6f\x5f\163\141\155\x6c\x5f\x72\145\147\x69\x73\x74\x72\141\164\x69\x6f\x6e\137\x73\164\141\164\x75\x73", "\x45\x78\x69\163\164\x69\x6e\147\40\125\x73\x65\x72");
        delete_option("\x6d\x6f\x5f\163\141\155\154\137\x76\145\162\x69\x66\171\137\143\x75\x73\x74\x6f\155\x65\x72");
        if (get_option("\x73\x6d\x6c\x5f\154\x6b")) {
            goto Xj;
        }
        $this->mo_saml_show_success_message();
        goto iS;
        Xj:
        $ld = get_option("\x6d\157\137\x73\141\x6d\154\x5f\x63\x75\x73\164\x6f\x6d\x65\162\137\164\157\153\x65\x6e");
        $V5 = AESEncryption::decrypt_data(get_option("\x73\x6d\154\x5f\154\x6b"), $ld);
        $Gs = $ko->mo_saml_vl($V5, false);
        if ($Gs) {
            goto j_;
        }
        return;
        j_:
        $Gs = json_decode($Gs, true);
        update_option("\x76\x6c\137\143\150\x65\143\x6b\x5f\164", time());
        if (strcasecmp($Gs["\x73\x74\141\164\x75\x73"], "\123\x55\x43\x43\105\x53\123") == 0) {
            goto yB;
        }
        update_option("\155\x6f\137\163\141\x6d\x6c\x5f\x6d\145\x73\x73\141\147\145", "\114\151\x63\145\x6e\163\x65\x20\153\145\x79\40\x66\157\162\40\164\150\151\163\40\x69\156\x73\x74\141\x6e\143\145\x20\x69\163\40\151\x6e\x63\157\162\162\145\143\164\56\40\115\x61\x6b\x65\40\163\165\162\145\40\x79\x6f\165\x20\x68\141\x76\145\x20\156\x6f\x74\40\x74\141\x6d\x70\x65\162\x65\144\40\167\x69\164\x68\x20\151\x74\x20\141\164\x20\141\x6c\x6c\56\40\x50\x6c\x65\x61\163\x65\x20\x65\156\164\145\x72\40\141\x20\x76\141\x6c\x69\x64\40\x6c\x69\143\x65\x6e\163\x65\x20\153\x65\171\56");
        delete_option("\x73\x6d\x6c\x5f\x6c\x6b");
        $this->mo_saml_show_error_message();
        goto mu;
        yB:
        $R4 = plugin_dir_path(__FILE__);
        $Fw = home_url();
        $Fw = trim($Fw, "\x2f");
        if (preg_match("\43\136\x68\164\x74\x70\x28\163\51\x3f\72\x2f\x2f\x23", $Fw)) {
            goto L0;
        }
        $Fw = "\150\x74\164\x70\x3a\x2f\x2f" . $Fw;
        L0:
        $jh = parse_url($Fw);
        $Js = preg_replace("\57\136\x77\167\x77\x5c\x2e\x2f", '', $jh["\x68\157\x73\164"]);
        $OI = wp_upload_dir();
        $D9 = $Js . "\x2d" . $OI["\142\141\x73\145\144\151\162"];
        $yu = hash_hmac("\163\x68\141\x32\65\x36", $D9, "\64\104\110\146\152\x67\146\x6a\141\x73\156\x64\x66\163\x61\152\x66\110\107\112");
        $aT = $this->djkasjdksa();
        $Sl = round(strlen($aT) / rand(2, 20));
        $aT = substr_replace($aT, $yu, $Sl, 0);
        $EK = base64_decode($aT);
        if (is_writable($R4 . "\154\151\x63\145\x6e\163\x65")) {
            goto b2;
        }
        $aT = str_rot13($aT);
        $FO = base64_decode("\142\x47\116\x6b\141\155\164\x68\x63\62\x70\153\141\x33\x4e\150\131\x32\x77\75");
        update_option($FO, $aT);
        goto hO;
        b2:
        file_put_contents($R4 . "\x6c\x69\x63\145\156\x73\x65", $EK);
        hO:
        update_option("\154\143\x77\162\x74\x6c\146\x73\x61\155\x6c", true);
        $this->mo_saml_show_success_message();
        mu:
        iS:
        oO:
        update_option("\155\157\x5f\x73\x61\155\x6c\137\141\x64\x6d\x69\156\137\x70\141\163\x73\167\157\162\x64", '');
        aw:
        goto F2;
        p8:
        if (mo_saml_is_extension_installed("\143\x75\162\154")) {
            goto C5;
        }
        update_option("\x6d\157\137\163\141\x6d\x6c\137\155\145\x73\163\x61\x67\x65", "\x45\x52\x52\117\122\x3a\x20\x50\110\x50\40\x63\125\x52\x4c\40\x65\170\164\x65\156\163\x69\x6f\x6e\40\151\x73\x20\156\x6f\164\40\151\x6e\x73\x74\x61\154\x6c\x65\x64\x20\x6f\x72\x20\144\x69\x73\141\x62\154\145\144\x2e\x20\122\x65\163\x65\x6e\x64\x20\117\124\x50\40\x66\141\x69\154\x65\144\56");
        $this->mo_saml_show_error_message();
        return;
        C5:
        $hy = get_option("\x6d\x6f\137\x73\141\x6d\154\x5f\x61\144\155\x69\156\x5f\145\x6d\x61\x69\154");
        $ko = new Customersaml();
        $Gs = $ko->mo_saml_forgot_password($hy);
        if ($Gs) {
            goto ud;
        }
        return;
        ud:
        $Gs = json_decode($Gs, true);
        if (strcasecmp($Gs["\x73\x74\x61\x74\x75\x73"], "\x53\x55\x43\x43\105\x53\x53") == 0) {
            goto nS;
        }
        update_option("\x6d\x6f\x5f\x73\x61\x6d\154\137\155\x65\x73\163\x61\147\x65", "\101\156\x20\145\162\162\157\x72\40\x6f\143\143\165\162\x65\144\40\x77\150\x69\154\145\x20\160\162\x6f\143\x65\x73\163\x69\156\147\40\171\x6f\x75\162\40\x72\145\x71\x75\x65\163\x74\56\x20\120\154\145\x61\x73\x65\x20\x54\x72\x79\40\141\x67\x61\151\156\56");
        $this->mo_saml_show_error_message();
        goto gy;
        nS:
        update_option("\155\x6f\137\163\141\x6d\154\x5f\x6d\145\x73\x73\x61\147\145", "\x59\157\165\x72\x20\x70\141\163\x73\167\157\x72\x64\x20\150\x61\x73\x20\x62\x65\145\x6e\40\162\145\x73\x65\164\x20\163\x75\x63\x63\x65\x73\x73\146\165\x6c\154\171\56\40\x50\154\145\141\163\145\x20\145\x6e\x74\145\x72\x20\164\150\145\40\156\145\x77\40\160\141\163\163\x77\x6f\162\x64\x20\163\x65\156\x74\40\x74\157\40" . $hy . "\56");
        $this->mo_saml_show_success_message();
        gy:
        F2:
        goto VP;
        Eg:
        $HA = "\146\x61\x6c\163\145";
        if (array_key_exists("\x6d\x6f\x5f\163\141\155\x6c\x5f\141\154\x6c\x6f\x77\137\167\x70\137\163\x69\x67\156\x69\156", $_POST)) {
            goto OM;
        }
        $AX = "\146\141\x6c\x73\x65";
        goto Ad;
        OM:
        $AX = htmlspecialchars($_POST["\x6d\157\x5f\163\141\x6d\x6c\x5f\141\x6c\x6c\x6f\167\137\167\x70\x5f\163\151\147\x6e\151\x6e"]);
        Ad:
        if ($AX == "\164\x72\165\x65") {
            goto Tz;
        }
        update_option("\155\157\x5f\x73\141\155\154\x5f\x61\154\154\157\167\137\x77\x70\137\x73\x69\x67\x6e\x69\156", "\x46\x61\x6c\x73\x65");
        goto lQ;
        Tz:
        update_option("\x6d\x6f\x5f\x73\x61\155\154\137\141\154\x6c\x6f\x77\137\167\x70\137\163\151\147\x6e\151\156", "\x74\162\165\145");
        lQ:
        if (!array_key_exists("\155\x6f\137\x73\141\155\x6c\137\142\141\x63\153\144\157\157\162\x5f\x75\x72\154", $_POST)) {
            goto ha;
        }
        $HA = htmlspecialchars(trim($_POST["\x6d\x6f\137\x73\x61\x6d\154\137\142\x61\143\x6b\x64\157\x6f\x72\137\x75\x72\x6c"]));
        ha:
        update_option("\155\157\x5f\163\141\x6d\154\137\142\141\143\153\x64\x6f\157\x72\x5f\165\x72\154", $HA);
        update_option("\x6d\x6f\137\x73\x61\x6d\x6c\137\x6d\x65\x73\163\x61\147\145", "\123\x69\147\x6e\x20\x49\156\x20\x73\145\164\164\x69\156\147\163\x20\165\160\x64\x61\x74\x65\x64\56");
        $this->mo_saml_show_success_message();
        VP:
        goto V6;
        Kn:
        if (mo_saml_is_sp_configured()) {
            goto p1;
        }
        update_option("\x6d\157\137\x73\x61\x6d\154\x5f\x6d\x65\163\x73\141\x67\x65", "\120\154\145\x61\163\145\x20\143\x6f\155\160\154\x65\x74\x65\40" . addLink("\x53\145\162\166\151\x63\x65\40\x50\x72\157\x76\x69\144\x65\162", add_query_arg(array("\x74\141\142" => "\x73\x61\x76\x65"), $_SERVER["\122\x45\x51\125\105\123\x54\x5f\125\122\111"])) . "\x20\143\157\x6e\146\151\x67\x75\162\141\x74\x69\x6f\156\40\146\x69\x72\x73\x74\x2e");
        $this->mo_saml_show_error_message();
        goto kj;
        p1:
        if (array_key_exists("\155\x6f\137\x73\141\155\x6c\x5f\x65\156\x61\x62\154\145\x5f\x6c\157\x67\x69\x6e\x5f\162\145\144\151\x72\145\x63\x74", $_POST)) {
            goto Vn;
        }
        $lH = "\x66\141\x6c\163\x65";
        goto sJ;
        Vn:
        $lH = htmlspecialchars($_POST["\155\157\x5f\x73\x61\155\x6c\x5f\x65\156\x61\142\x6c\x65\137\154\x6f\147\x69\156\x5f\162\x65\144\x69\x72\x65\143\164"]);
        sJ:
        if ($lH == "\x74\x72\165\x65") {
            goto Y6;
        }
        update_option("\x6d\157\137\x73\x61\x6d\x6c\137\x65\x6e\141\142\154\x65\137\154\x6f\x67\x69\x6e\x5f\x72\145\144\151\x72\x65\x63\164", "\146\141\154\x73\145");
        update_option("\155\157\137\x73\x61\155\154\x5f\x61\x6c\154\x6f\x77\137\x77\x70\137\163\x69\x67\x6e\x69\156", "\106\141\x6c\163\145");
        goto eq;
        Y6:
        update_option("\x6d\157\x5f\x73\x61\x6d\154\137\x65\x6e\x61\142\x6c\x65\x5f\x6c\157\x67\x69\156\137\162\145\144\x69\x72\x65\143\x74", "\164\x72\165\145");
        update_option("\155\157\137\163\x61\x6d\x6c\137\x61\x6c\x6c\x6f\167\137\x77\160\137\163\151\x67\x6e\151\x6e", "\164\x72\165\x65");
        eq:
        update_option("\155\x6f\x5f\163\x61\x6d\154\x5f\x6d\x65\163\163\x61\147\x65", "\123\x69\x67\156\40\151\x6e\x20\157\160\164\151\x6f\156\163\x20\165\160\x64\141\164\x65\144\x2e");
        $this->mo_saml_show_success_message();
        kj:
        V6:
        goto se;
        bl:
        if (mo_saml_is_sp_configured()) {
            goto FD;
        }
        update_option("\155\157\x5f\x73\141\x6d\x6c\137\x6d\x65\x73\x73\141\x67\145", "\x50\x6c\145\141\x73\145\40\143\x6f\x6d\160\x6c\145\x74\x65\40" . addLink("\123\145\x72\166\151\x63\x65\40\120\162\x6f\x76\x69\x64\x65\162", add_query_arg(array("\164\141\x62" => "\163\141\x76\145"), $_SERVER["\122\x45\121\x55\x45\123\x54\x5f\125\122\111"])) . "\40\143\x6f\156\146\x69\147\165\162\x61\x74\x69\157\x6e\40\x66\151\x72\163\x74\56");
        $this->mo_saml_show_error_message();
        goto pw;
        FD:
        if (array_key_exists("\155\x6f\x5f\x73\x61\155\x6c\x5f\x65\156\x61\142\154\x65\137\162\163\x73\137\141\143\143\145\x73\x73", $_POST)) {
            goto Tv;
        }
        $Ef = false;
        goto tK;
        Tv:
        $Ef = htmlspecialchars($_POST["\155\x6f\x5f\163\x61\x6d\154\x5f\145\156\x61\x62\x6c\x65\x5f\x72\x73\163\x5f\x61\143\x63\145\x73\x73"]);
        tK:
        if ($Ef == "\x74\x72\x75\145") {
            goto tx;
        }
        update_option("\155\x6f\x5f\163\x61\155\154\137\x65\156\141\142\x6c\145\x5f\x72\x73\x73\137\x61\x63\x63\145\x73\x73", "\x66\x61\154\163\x65");
        goto p4;
        tx:
        update_option("\155\x6f\137\x73\141\155\x6c\137\x65\156\x61\142\154\x65\137\x72\x73\163\137\141\143\143\x65\x73\x73", "\x74\x72\165\145");
        p4:
        update_option("\155\x6f\137\163\141\x6d\154\137\x6d\145\x73\x73\141\147\x65", "\122\x53\123\x20\106\145\x65\x64\40\157\160\164\x69\x6f\x6e\40\165\x70\144\x61\x74\x65\144\x2e");
        $this->mo_saml_show_success_message();
        pw:
        se:
        goto hR;
        vC:
        if (mo_saml_is_sp_configured()) {
            goto aU;
        }
        update_option("\x6d\157\x5f\163\x61\x6d\154\x5f\x6d\145\163\x73\141\147\x65", "\x50\154\145\x61\163\x65\x20\143\x6f\155\160\154\145\x74\x65\x20" . addLink("\123\145\x72\x76\151\x63\x65\40\x50\162\x6f\166\x69\144\145\162", add_query_arg(array("\164\x61\142" => "\163\141\166\145"), $_SERVER["\x52\x45\121\125\x45\x53\x54\137\x55\x52\x49"])) . "\x20\x63\x6f\156\x66\x69\147\x75\162\x61\164\151\157\156\x20\146\151\x72\163\x74\x2e");
        $this->mo_saml_show_error_message();
        goto Nu;
        aU:
        if (array_key_exists("\155\x6f\x5f\163\141\155\154\137\146\157\x72\143\x65\137\x61\165\164\150\145\156\164\151\x63\x61\164\x69\157\x6e", $_POST)) {
            goto Z2;
        }
        $lH = "\146\141\154\x73\145";
        goto Zb;
        Z2:
        $lH = htmlspecialchars($_POST["\x6d\x6f\x5f\163\x61\x6d\x6c\x5f\x66\x6f\x72\x63\145\137\x61\x75\164\150\x65\156\x74\151\x63\x61\164\x69\157\x6e"]);
        Zb:
        if ($lH == "\x74\162\x75\145") {
            goto fU;
        }
        update_option("\155\157\137\x73\x61\155\154\137\x66\157\162\x63\145\137\x61\x75\164\x68\145\156\164\151\143\x61\164\151\x6f\156", "\x66\141\x6c\163\x65");
        goto Em;
        fU:
        update_option("\x6d\x6f\137\163\141\155\154\137\146\x6f\162\x63\x65\137\141\165\x74\150\x65\156\164\x69\143\x61\164\151\157\x6e", "\164\162\165\145");
        Em:
        update_option("\155\x6f\x5f\163\141\155\x6c\x5f\155\145\x73\163\x61\x67\145", "\x53\x69\x67\x6e\x20\151\x6e\40\157\x70\x74\151\x6f\x6e\163\x20\x75\160\144\x61\164\x65\x64\56");
        $this->mo_saml_show_success_message();
        Nu:
        hR:
        goto Uo;
        e9:
        if (mo_saml_is_sp_configured()) {
            goto mp;
        }
        update_option("\x6d\157\137\163\x61\x6d\x6c\137\155\145\163\163\x61\147\145", "\x50\x6c\145\x61\163\145\x20\x63\157\x6d\160\154\145\x74\145\x20" . addLink("\x53\x65\162\166\151\143\x65\40\x50\x72\157\x76\151\x64\x65\x72", add_query_arg(array("\164\x61\142" => "\163\141\x76\x65"), $_SERVER["\122\105\x51\x55\105\123\124\x5f\125\122\x49"])) . "\x20\143\x6f\156\x66\x69\x67\165\x72\141\164\151\x6f\x6e\x20\146\x69\162\163\164\56");
        $this->mo_saml_show_error_message();
        goto px;
        mp:
        if (array_key_exists("\x6d\157\137\x73\141\155\154\137\x72\145\x67\x69\163\x74\x65\x72\x65\144\x5f\157\x6e\x6c\171\x5f\x61\x63\143\145\163\x73", $_POST)) {
            goto jx;
        }
        $lH = "\x66\x61\x6c\163\x65";
        goto KD;
        jx:
        $lH = htmlspecialchars($_POST["\x6d\157\137\x73\x61\x6d\x6c\137\x72\145\x67\x69\163\164\145\x72\145\x64\x5f\x6f\x6e\x6c\x79\x5f\x61\143\x63\x65\163\163"]);
        KD:
        if ($lH == "\164\162\x75\x65") {
            goto Th;
        }
        update_option("\155\157\137\x73\x61\155\x6c\137\x72\145\147\x69\x73\164\x65\x72\145\144\137\157\156\154\x79\137\141\x63\143\145\163\x73", "\146\141\x6c\x73\145");
        goto ah;
        Th:
        update_option("\155\157\137\x73\141\x6d\x6c\x5f\162\145\147\151\x73\x74\x65\x72\145\144\x5f\157\156\154\x79\137\x61\x63\143\x65\x73\x73", "\164\162\165\x65");
        ah:
        update_option("\x6d\x6f\137\163\141\x6d\x6c\137\x6d\x65\x73\163\x61\147\x65", "\123\x69\x67\156\40\151\x6e\40\x6f\160\x74\x69\x6f\156\163\40\165\160\x64\141\x74\x65\144\56");
        $this->mo_saml_show_success_message();
        px:
        Uo:
        goto uX;
        GQ:
        if (mo_saml_is_extension_installed("\143\165\162\154")) {
            goto ul;
        }
        update_option("\155\157\x5f\x73\x61\155\154\x5f\x6d\x65\x73\163\x61\147\x65", "\105\122\x52\x4f\122\72\40\x50\x48\120\x20\x63\125\x52\114\40\145\170\x74\x65\156\163\x69\157\156\40\x69\163\40\156\x6f\x74\40\x69\156\x73\164\x61\154\x6c\145\144\40\157\162\40\x64\151\x73\x61\x62\x6c\145\144\x2e\40\122\145\163\145\x6e\144\40\x4f\x54\x50\40\146\141\151\154\x65\x64\x2e");
        $this->mo_saml_show_error_message();
        return;
        ul:
        $Uf = sanitize_text_field($_POST["\160\150\x6f\x6e\x65"]);
        $Uf = str_replace("\40", '', $Uf);
        $Uf = str_replace("\x2d", '', $Uf);
        update_option("\155\157\137\163\x61\155\154\137\141\x64\x6d\151\x6e\137\160\x68\157\156\145", $Uf);
        $ko = new CustomerSaml();
        $Gs = $ko->send_otp_token('', $Uf, FALSE, TRUE);
        if ($Gs) {
            goto A8;
        }
        return;
        A8:
        $Gs = json_decode($Gs, true);
        if (strcasecmp($Gs["\163\164\x61\164\x75\163"], "\123\125\x43\103\x45\x53\x53") == 0) {
            goto Eq;
        }
        update_option("\x6d\157\137\163\141\155\x6c\137\x6d\145\x73\x73\141\147\145", "\x54\x68\145\162\x65\x20\x77\141\163\x20\x61\156\x20\145\162\x72\x6f\162\x20\x69\x6e\40\x73\145\156\x64\151\x6e\x67\40\123\115\x53\56\x20\120\x6c\145\141\163\145\x20\x63\154\x69\x63\153\40\x6f\x6e\40\122\x65\x73\x65\x6e\144\40\x4f\x54\120\40\x74\157\40\164\162\x79\x20\x61\147\141\x69\x6e\x2e");
        update_option("\155\157\x5f\x73\x61\155\x6c\137\162\145\x67\x69\x73\x74\x72\x61\164\x69\x6f\156\x5f\x73\x74\x61\164\x75\163", "\115\117\137\117\124\120\x5f\x44\105\114\x49\126\x45\x52\105\104\137\106\x41\111\x4c\x55\x52\x45\x5f\120\x48\117\x4e\x45");
        $this->mo_saml_show_error_message();
        goto Kg;
        Eq:
        update_option("\x6d\157\137\x73\x61\155\154\137\x6d\145\x73\163\x61\147\145", "\40\x41\40\x6f\156\145\x20\x74\151\x6d\145\x20\x70\x61\163\x73\x63\157\x64\x65\40\151\x73\x20\163\x65\x6e\164\x20\164\x6f\x20" . get_option("\155\157\137\163\141\x6d\154\137\x61\144\x6d\x69\x6e\137\160\150\x6f\x6e\145") . "\56\x20\x50\x6c\145\x61\163\145\x20\145\x6e\x74\145\162\40\164\150\145\x20\157\x74\160\x20\x68\x65\162\145\x20\x74\157\40\166\x65\x72\x69\x66\171\40\x79\157\165\x72\x20\145\x6d\141\151\154\56");
        update_option("\155\x6f\137\163\141\x6d\x6c\137\164\162\x61\x6e\x73\x61\x63\x74\151\157\156\111\x64", $Gs["\x74\170\x49\x64"]);
        update_option("\x6d\x6f\x5f\163\141\155\154\137\162\x65\x67\151\163\164\162\x61\x74\151\x6f\156\x5f\163\164\141\x74\165\163", "\x4d\x4f\x5f\x4f\x54\x50\x5f\x44\105\x4c\x49\x56\x45\122\x45\x44\137\123\125\103\103\x45\123\123\x5f\x50\110\x4f\x4e\x45");
        $this->mo_saml_show_success_message();
        Kg:
        uX:
        goto OD;
        u6:
        update_option("\x6d\x6f\x5f\163\x61\155\154\137\x72\x65\x67\x69\x73\x74\162\x61\x74\x69\157\156\x5f\163\164\x61\164\x75\x73", '');
        update_option("\155\x6f\x5f\163\x61\x6d\x6c\137\166\x65\162\x69\146\x79\x5f\x63\x75\x73\164\157\x6d\x65\x72", '');
        delete_option("\155\x6f\x5f\163\141\x6d\154\x5f\156\x65\167\137\162\x65\x67\151\163\164\x72\141\x74\x69\157\156");
        delete_option("\155\x6f\137\163\141\x6d\154\137\x61\x64\155\151\x6e\137\x65\155\141\151\x6c");
        delete_option("\x6d\x6f\137\x73\x61\x6d\x6c\137\141\144\155\151\156\x5f\x70\150\157\x6e\x65");
        delete_site_option("\x73\155\x6c\x5f\154\153");
        delete_site_option("\x74\x5f\163\x69\x74\145\x5f\x73\x74\x61\x74\x75\x73");
        delete_site_option("\163\151\164\145\137\143\x6b\137\x6c");
        OD:
        goto ai;
        YS:
        if (mo_saml_is_extension_installed("\x63\x75\x72\154")) {
            goto KL;
        }
        update_option("\155\x6f\x5f\x73\141\155\154\137\155\x65\163\163\141\x67\145", "\105\122\x52\x4f\122\x3a\x20\x50\x48\x50\x20\143\x55\x52\114\40\x65\170\x74\x65\x6e\x73\x69\157\x6e\40\151\163\40\x6e\157\x74\x20\x69\156\163\164\x61\x6c\154\145\144\40\x6f\162\40\144\151\x73\x61\142\154\145\144\56\40\122\145\163\x65\156\144\x20\117\x54\x50\40\146\141\151\x6c\x65\x64\x2e");
        $this->mo_saml_show_error_message();
        return;
        KL:
        $Uf = get_option("\x6d\157\x5f\x73\x61\155\154\137\x61\144\x6d\x69\156\x5f\160\x68\x6f\x6e\145");
        $ko = new CustomerSaml();
        $Gs = $ko->send_otp_token('', $Uf, FALSE, TRUE);
        if ($Gs) {
            goto rD;
        }
        return;
        rD:
        $Gs = json_decode($Gs, true);
        if (strcasecmp($Gs["\163\164\x61\x74\165\163"], "\x53\x55\x43\x43\x45\123\123") == 0) {
            goto wD;
        }
        update_option("\x6d\x6f\137\163\x61\x6d\x6c\x5f\x6d\145\x73\x73\141\147\x65", "\x54\x68\145\162\145\40\x77\x61\x73\x20\x61\x6e\x20\145\162\162\x6f\162\x20\x69\156\40\163\145\156\x64\151\x6e\147\x20\145\x6d\141\x69\x6c\56\40\120\154\145\141\163\x65\x20\x63\154\x69\143\153\x20\157\x6e\40\122\145\x73\x65\156\144\40\117\x54\x50\40\164\157\x20\x74\x72\171\40\x61\147\141\x69\156\56");
        update_option("\155\157\x5f\163\x61\155\154\x5f\162\x65\x67\151\x73\164\162\x61\164\151\x6f\156\137\163\164\x61\164\165\163", "\x4d\117\137\x4f\124\x50\137\x44\x45\x4c\x49\x56\105\x52\x45\104\137\106\x41\x49\x4c\x55\122\x45\137\x50\x48\x4f\x4e\105");
        $this->mo_saml_show_error_message();
        goto Yi;
        wD:
        update_option("\x6d\x6f\137\x73\x61\x6d\154\x5f\x6d\145\163\x73\141\147\145", "\x20\101\x20\x6f\156\x65\x20\x74\x69\x6d\x65\40\x70\141\163\x73\x63\x6f\x64\x65\x20\151\163\40\x73\x65\x6e\164\x20\x74\x6f\x20" . $Uf . "\x20\141\x67\x61\151\x6e\56\40\120\154\145\x61\x73\x65\40\143\150\145\143\153\40\x69\146\40\x79\x6f\x75\40\147\x6f\164\x20\164\x68\145\x20\157\164\160\x20\x61\156\x64\40\145\156\164\x65\162\x20\151\x74\40\x68\145\x72\x65\56");
        update_option("\155\x6f\x5f\x73\x61\x6d\154\x5f\164\x72\x61\x6e\x73\141\143\x74\151\x6f\156\111\x64", $Gs["\164\170\111\x64"]);
        update_option("\x6d\157\x5f\163\x61\155\x6c\137\x72\145\x67\151\163\164\x72\141\x74\x69\x6f\156\137\163\164\x61\x74\165\163", "\x4d\117\137\x4f\124\x50\x5f\x44\x45\x4c\x49\126\105\122\105\x44\137\123\125\x43\x43\105\x53\x53\x5f\x50\x48\117\x4e\105");
        $this->mo_saml_show_success_message();
        Yi:
        ai:
        goto xu;
        nu:
        if (mo_saml_is_extension_installed("\143\x75\162\154")) {
            goto j1;
        }
        update_option("\155\157\x5f\x73\x61\155\154\137\155\145\163\x73\x61\x67\145", "\x45\x52\x52\x4f\x52\x3a\x20\120\110\120\x20\143\x55\122\114\x20\145\x78\164\x65\x6e\163\151\157\x6e\x20\151\x73\40\156\157\164\x20\151\x6e\163\x74\141\x6c\154\x65\144\x20\x6f\162\40\x64\151\163\x61\x62\154\145\144\x2e\x20\x52\145\163\145\156\144\x20\117\x54\x50\x20\146\x61\151\x6c\145\x64\56");
        $this->mo_saml_show_error_message();
        return;
        j1:
        $hy = get_option("\x6d\157\x5f\x73\x61\155\154\137\x61\x64\x6d\x69\156\137\145\x6d\x61\x69\x6c");
        $ko = new CustomerSaml();
        $Gs = $ko->send_otp_token($hy, '');
        if ($Gs) {
            goto DX;
        }
        return;
        DX:
        $Gs = json_decode($Gs, true);
        if (strcasecmp($Gs["\163\x74\141\x74\165\163"], "\x53\125\x43\x43\x45\x53\123") == 0) {
            goto us;
        }
        update_option("\x6d\x6f\137\163\x61\x6d\154\137\155\145\163\x73\x61\147\145", "\124\x68\x65\162\145\40\167\x61\x73\40\x61\x6e\x20\145\162\x72\x6f\162\40\151\x6e\40\x73\x65\156\x64\151\156\x67\40\x65\x6d\141\x69\154\x2e\40\120\x6c\x65\141\163\x65\x20\143\154\x69\143\x6b\40\x6f\156\40\x52\145\x73\x65\156\144\40\117\124\120\x20\164\x6f\40\164\x72\171\40\141\x67\x61\151\156\x2e");
        update_option("\155\x6f\x5f\x73\141\155\154\x5f\x72\145\147\151\163\x74\x72\141\x74\x69\x6f\156\x5f\163\x74\x61\164\x75\163", "\x4d\117\137\117\x54\120\x5f\x44\105\x4c\111\126\105\122\105\104\x5f\106\x41\111\x4c\x55\122\x45\137\105\115\x41\x49\114");
        $this->mo_saml_show_error_message();
        goto tH;
        us:
        update_option("\155\x6f\137\163\x61\155\x6c\137\155\145\x73\x73\x61\147\145", "\x20\101\40\x6f\156\145\x20\x74\x69\155\x65\40\x70\x61\x73\163\x63\157\144\145\40\151\163\x20\x73\145\156\164\x20\x74\157\40" . get_option("\x6d\x6f\137\163\141\x6d\x6c\137\x61\x64\155\x69\x6e\x5f\145\155\141\151\154") . "\x20\141\147\x61\x69\x6e\x2e\x20\x50\154\x65\x61\163\145\40\143\x68\x65\x63\x6b\x20\151\x66\40\x79\157\165\x20\147\157\164\x20\x74\150\x65\x20\x6f\164\x70\x20\141\156\144\x20\x65\x6e\x74\145\162\x20\x69\164\x20\x68\x65\162\x65\x2e");
        update_option("\155\157\137\163\141\x6d\154\x5f\164\x72\x61\x6e\163\141\143\x74\151\157\x6e\x49\144", $Gs["\x74\x78\111\x64"]);
        update_option("\x6d\x6f\x5f\163\141\155\x6c\137\x72\x65\147\151\163\x74\x72\141\x74\x69\x6f\x6e\x5f\163\x74\141\164\x75\x73", "\115\x4f\137\x4f\124\x50\137\104\105\114\111\x56\x45\x52\x45\104\x5f\x53\x55\x43\103\x45\x53\123\x5f\105\115\x41\111\x4c");
        $this->mo_saml_show_success_message();
        tH:
        xu:
        goto Lp;
        fZ:
        if (mo_saml_is_extension_installed("\143\x75\162\154")) {
            goto Uf;
        }
        update_option("\x6d\x6f\137\163\x61\155\x6c\x5f\155\145\163\163\141\147\x65", "\x45\x52\x52\x4f\x52\72\x20\120\x48\x50\40\143\x55\122\114\40\145\x78\164\145\x6e\163\151\157\x6e\40\151\163\x20\156\x6f\164\40\151\156\163\164\x61\x6c\x6c\145\x64\40\x6f\162\x20\x64\x69\x73\x61\x62\x6c\x65\144\56\x20\x51\x75\145\x72\171\40\x73\x75\x62\x6d\151\164\40\x66\141\151\x6c\145\144\56");
        $this->mo_saml_show_error_message();
        return;
        Uf:
        $hy = htmlspecialchars($_POST["\155\157\137\163\x61\x6d\154\137\143\157\x6e\x74\x61\143\164\137\165\163\x5f\145\155\x61\x69\154"]);
        $Uf = htmlspecialchars($_POST["\x6d\x6f\137\x73\x61\155\154\x5f\143\x6f\x6e\x74\x61\x63\x74\137\165\x73\x5f\160\x68\157\156\145"]);
        $ye = htmlspecialchars($_POST["\x6d\157\137\x73\141\x6d\154\x5f\x63\x6f\x6e\164\141\x63\164\137\x75\163\137\x71\x75\x65\162\x79"]);
        if (array_key_exists("\163\x65\156\144\x5f\x70\x6c\165\x67\151\x6e\137\x63\x6f\x6e\x66\151\x67", $_POST) === true) {
            goto vZ;
        }
        update_option("\x73\x65\x6e\144\137\160\154\x75\x67\x69\156\x5f\x63\x6f\x6e\146\151\x67", "\157\x66\146");
        goto MM;
        vZ:
        $Yl = miniorange_import_export(true, true);
        $ye .= $Yl;
        delete_option("\x73\x65\156\x64\x5f\x70\154\x75\x67\x69\x6e\x5f\143\x6f\156\x66\x69\147");
        MM:
        $ko = new CustomerSaml();
        if ($this->mo_saml_check_empty_or_null($hy) || $this->mo_saml_check_empty_or_null($ye)) {
            goto Z6;
        }
        if (!filter_var($hy, FILTER_VALIDATE_EMAIL)) {
            goto OA;
        }
        $Zq = $ko->submit_contact_us($hy, $Uf, $ye);
        if ($Zq) {
            goto jM;
        }
        return;
        jM:
        update_option("\155\157\137\163\141\x6d\154\x5f\x6d\145\163\163\x61\147\145", "\124\150\x61\x6e\153\163\x20\x66\x6f\162\x20\147\145\x74\164\151\156\x67\40\x69\156\x20\164\x6f\165\143\150\41\40\127\145\x20\x73\x68\x61\x6c\x6c\40\147\x65\x74\40\x62\x61\143\153\40\164\x6f\x20\171\157\x75\x20\x73\150\157\162\164\154\x79\56");
        $this->mo_saml_show_success_message();
        goto bF;
        OA:
        update_option("\155\157\137\x73\x61\x6d\x6c\x5f\x6d\145\x73\x73\141\x67\x65", "\120\154\145\x61\163\145\x20\145\x6e\x74\145\162\40\141\40\166\141\x6c\151\x64\x20\x65\x6d\141\151\154\40\x61\x64\x64\x72\x65\163\163\x2e");
        $this->mo_saml_show_error_message();
        bF:
        goto I_;
        Z6:
        update_option("\155\157\x5f\x73\x61\x6d\x6c\x5f\155\x65\x73\x73\141\x67\145", "\x50\154\x65\141\x73\x65\40\146\151\154\154\40\165\160\40\x45\155\141\151\154\40\141\156\144\40\x51\x75\x65\x72\x79\40\x66\151\x65\x6c\144\x73\40\164\157\x20\x73\x75\x62\155\151\x74\40\171\x6f\x75\162\40\x71\165\145\x72\171\56");
        $this->mo_saml_show_error_message();
        I_:
        Lp:
        goto nG;
        vM:
        if (!$this->mo_saml_check_empty_or_null($_POST["\x73\x61\x6d\154\137\x6c\151\x63\x65\x6e\x63\x65\137\x6b\x65\x79"])) {
            goto tg;
        }
        update_option("\x6d\x6f\x5f\163\141\155\x6c\x5f\x6d\x65\163\x73\x61\x67\x65", "\x41\154\x6c\x20\164\x68\145\40\146\x69\x65\154\144\x73\40\x61\162\145\x20\x72\145\x71\165\151\162\145\x64\x2e\40\120\154\x65\141\163\x65\x20\x65\156\x74\x65\162\40\x76\x61\x6c\x69\x64\40\154\151\x63\145\x6e\x73\x65\40\153\x65\171\x2e");
        $this->mo_saml_show_error_message();
        return;
        tg:
        $V5 = htmlspecialchars(trim($_POST["\x73\x61\155\154\x5f\x6c\x69\x63\x65\x6e\x63\x65\x5f\x6b\x65\171"]));
        $ko = new Customersaml();
        $Gs = $ko->check_customer_ln();
        if ($Gs) {
            goto PW;
        }
        return;
        PW:
        $Gs = json_decode($Gs, true);
        if (strcasecmp($Gs["\x73\x74\x61\x74\165\x73"], "\123\x55\x43\103\x45\x53\x53") == 0) {
            goto L5;
        }
        $ld = get_option("\x6d\x6f\137\163\x61\155\x6c\137\143\x75\x73\x74\x6f\x6d\x65\162\137\164\157\153\x65\x6e");
        update_option("\163\x69\164\x65\x5f\143\x6b\137\154", AESEncryption::encrypt_data("\x66\x61\154\163\x65", $ld));
        $px = add_query_arg(array("\164\x61\x62" => "\x6c\151\x63\145\x6e\163\x69\156\x67"), $_SERVER["\122\x45\x51\x55\x45\123\x54\137\x55\122\x49"]);
        update_option("\155\x6f\x5f\163\x61\x6d\x6c\137\155\145\x73\163\141\x67\x65", "\x59\x6f\165\40\150\141\x76\x65\40\x6e\157\x74\x20\x75\160\x67\162\141\144\145\x64\40\171\145\x74\56\40" . addLink("\x43\x6c\151\x63\x6b\x20\150\x65\162\x65", $px) . "\x20\x74\x6f\x20\x75\x70\147\x72\x61\144\x65\40\x74\157\40\160\x72\145\x6d\x69\x75\155\40\x76\x65\162\163\x69\157\156\x2e");
        $this->mo_saml_show_error_message();
        goto pQ;
        L5:
        $Gs = $ko->mo_saml_vl($V5, false);
        if ($Gs) {
            goto t3;
        }
        return;
        t3:
        $Gs = json_decode($Gs, true);
        update_option("\166\x6c\x5f\x63\x68\x65\143\153\137\164", time());
        if (strcasecmp($Gs["\x73\164\141\x74\165\163"], "\x53\x55\x43\103\x45\x53\123") == 0) {
            goto Fb;
        }
        if (strcasecmp($Gs["\x73\164\x61\x74\x75\163"], "\x46\x41\111\x4c\x45\104") == 0) {
            goto e_;
        }
        update_option("\x6d\x6f\x5f\163\141\155\x6c\137\x6d\x65\x73\163\141\x67\145", "\x41\x6e\x20\x65\x72\x72\157\162\40\x6f\x63\143\165\162\145\x64\x20\x77\150\x69\x6c\145\x20\160\x72\157\143\x65\x73\163\x69\x6e\x67\40\171\x6f\165\x72\40\162\145\x71\165\145\x73\164\x2e\x20\x50\x6c\145\x61\163\145\x20\x54\x72\171\40\141\147\x61\151\156\56");
        $this->mo_saml_show_error_message();
        goto Zy;
        e_:
        if (strcasecmp($Gs["\x6d\145\163\x73\x61\147\145"], "\103\157\x64\x65\40\150\141\x73\x20\x45\x78\x70\x69\x72\x65\144") == 0) {
            goto qh;
        }
        update_option("\155\157\x5f\x73\x61\x6d\x6c\x5f\x6d\145\x73\x73\x61\x67\x65", "\x59\157\x75\40\x68\141\166\x65\x20\145\156\x74\145\162\x65\144\40\141\x6e\x20\x69\156\166\141\154\151\144\40\x6c\151\143\x65\x6e\163\145\x20\x6b\x65\171\x2e\40\x50\154\145\141\x73\145\40\145\156\164\145\162\x20\141\x20\166\x61\154\x69\144\x20\x6c\151\x63\x65\156\163\145\40\153\145\x79\x2e");
        goto TJ;
        qh:
        $px = add_query_arg(array("\164\x61\x62" => "\154\x69\143\145\156\x73\151\x6e\147"), $_SERVER["\x52\x45\121\125\105\x53\x54\137\125\x52\111"]);
        update_option("\x6d\x6f\x5f\163\141\155\x6c\x5f\x6d\145\x73\x73\x61\147\x65", "\114\151\x63\x65\156\163\145\40\x6b\145\171\x20\171\157\x75\x20\x68\x61\166\145\x20\145\x6e\164\145\x72\x65\144\40\x68\x61\163\40\x61\154\162\145\141\144\171\x20\x62\145\x65\156\40\x75\163\x65\x64\x2e\x20\120\154\145\141\163\145\40\x65\156\x74\x65\x72\x20\x61\40\x6b\x65\x79\40\167\150\x69\x63\150\x20\150\x61\x73\x20\x6e\157\164\x20\142\145\145\x6e\x20\x75\163\145\144\40\142\x65\146\157\x72\145\x20\x6f\x6e\x20\x61\x6e\x79\40\157\164\x68\145\x72\x20\151\156\163\x74\x61\x6e\x63\x65\x20\x6f\162\40\x69\x66\40\171\x6f\165\40\x68\x61\x76\x65\x20\145\x78\x61\165\x73\164\x65\144\x20\x61\154\154\40\171\x6f\x75\x72\40\153\x65\171\x73\x20\x74\150\145\x6e\x20" . addLink("\x43\x6c\x69\x63\x6b\x20\x68\x65\162\145", $px) . "\x20\164\157\40\142\165\x79\x20\155\157\x72\x65\56");
        TJ:
        $this->mo_saml_show_error_message();
        Zy:
        goto dE;
        Fb:
        $ld = get_option("\155\x6f\137\163\141\x6d\x6c\x5f\x63\x75\163\x74\x6f\155\145\x72\137\x74\157\x6b\145\x6e");
        update_option("\163\x6d\154\137\x6c\153", AESEncryption::encrypt_data($V5, $ld));
        $QT = "\x59\x6f\x75\x72\40\154\151\143\x65\156\163\145\x20\x69\163\40\x76\x65\x72\x69\x66\151\x65\144\56\40\x59\157\165\x20\x63\141\156\40\156\x6f\x77\40\163\145\164\x75\160\40\164\150\145\x20\x70\154\x75\147\x69\x6e\x2e";
        update_option("\155\157\137\x73\141\x6d\154\x5f\155\x65\x73\x73\x61\x67\145", $QT);
        $ld = get_option("\155\x6f\137\163\x61\155\x6c\137\143\x75\x73\164\x6f\x6d\145\x72\x5f\x74\157\x6b\x65\156");
        update_option("\x73\x69\x74\145\137\143\153\x5f\x6c", AESEncryption::encrypt_data("\164\x72\165\145", $ld));
        update_option("\x74\137\x73\x69\x74\x65\137\x73\x74\141\x74\x75\163", AESEncryption::encrypt_data("\x66\141\154\x73\145", $ld));
        $R4 = plugin_dir_path(__FILE__);
        $Fw = home_url();
        $Fw = trim($Fw, "\57");
        if (preg_match("\43\x5e\x68\164\x74\160\50\x73\51\x3f\x3a\57\57\x23", $Fw)) {
            goto qK;
        }
        $Fw = "\x68\164\x74\x70\72\57\x2f" . $Fw;
        qK:
        $jh = parse_url($Fw);
        $Js = preg_replace("\57\136\x77\167\x77\x5c\x2e\57", '', $jh["\150\x6f\163\164"]);
        $OI = wp_upload_dir();
        $D9 = $Js . "\55" . $OI["\142\141\163\145\x64\151\x72"];
        $yu = hash_hmac("\x73\150\141\62\x35\66", $D9, "\x34\104\110\x66\152\x67\x66\x6a\141\x73\x6e\x64\x66\163\x61\x6a\146\x48\x47\x4a");
        $aT = $this->djkasjdksa();
        $Sl = round(strlen($aT) / rand(2, 20));
        $aT = substr_replace($aT, $yu, $Sl, 0);
        $EK = base64_decode($aT);
        if (is_writable($R4 . "\x6c\x69\143\x65\x6e\x73\x65")) {
            goto iq;
        }
        $aT = str_rot13($aT);
        $FO = base64_decode("\142\x47\x4e\x6b\141\x6d\x74\x68\143\x32\160\x6b\141\63\x4e\150\x59\62\x77\75");
        update_option($FO, $aT);
        goto vR;
        iq:
        file_put_contents($R4 . "\154\x69\143\145\156\163\145", $EK);
        vR:
        update_option("\154\x63\167\162\x74\154\x66\163\141\x6d\154", true);
        $px = add_query_arg(array("\x74\141\142" => "\147\145\156\145\162\x61\154"), $_SERVER["\x52\105\121\125\x45\x53\124\x5f\x55\122\x49"]);
        $this->mo_saml_show_success_message();
        dE:
        pQ:
        nG:
        goto xc;
        uC:
        if (mo_saml_is_extension_installed("\143\x75\x72\x6c")) {
            goto il;
        }
        update_option("\x6d\x6f\137\163\141\155\x6c\x5f\x6d\145\x73\163\141\147\145", "\105\x52\x52\x4f\122\x3a\120\x48\120\40\x63\x55\x52\x4c\40\x65\170\x74\145\x6e\163\151\157\x6e\40\x69\163\x20\156\x6f\164\40\x69\x6e\163\164\x61\x6c\154\145\x64\x20\x6f\162\x20\144\151\163\141\x62\x6c\145\144\56\x20\x56\x61\154\x69\x64\141\x74\145\40\117\x54\120\40\x66\141\x69\x6c\145\144\56");
        $this->mo_saml_show_error_message();
        return;
        il:
        $wV = '';
        if ($this->mo_saml_check_empty_or_null($_POST["\x6f\164\160\x5f\x74\157\153\x65\156"])) {
            goto CV;
        }
        $wV = sanitize_text_field($_POST["\157\x74\160\x5f\164\x6f\153\x65\x6e"]);
        goto Ao;
        CV:
        update_option("\155\x6f\x5f\163\x61\155\x6c\x5f\x6d\145\163\x73\141\x67\145", "\x50\x6c\145\141\163\x65\40\145\156\164\x65\x72\40\x61\x20\x76\x61\154\x75\145\40\151\156\40\157\164\x70\40\x66\151\x65\154\x64\x2e");
        $this->mo_saml_show_error_message();
        return;
        Ao:
        $ko = new CustomerSaml();
        $Gs = $ko->validate_otp_token(get_option("\x6d\157\x5f\163\141\155\154\137\x74\162\141\x6e\163\141\x63\164\151\157\x6e\111\144"), $wV);
        if ($Gs) {
            goto GJ;
        }
        return;
        GJ:
        $Gs = json_decode($Gs, true);
        if (strcasecmp($Gs["\x73\164\141\164\x75\163"], "\123\x55\x43\103\105\x53\x53") == 0) {
            goto p6;
        }
        update_option("\155\x6f\x5f\163\141\155\154\137\155\145\163\163\141\x67\145", "\111\156\166\141\x6c\x69\144\40\x6f\156\x65\40\x74\x69\155\x65\40\x70\141\163\x73\143\157\x64\145\56\40\120\154\x65\141\x73\145\40\145\156\x74\145\x72\40\141\40\x76\141\x6c\x69\x64\40\x6f\164\x70\x2e");
        $this->mo_saml_show_error_message();
        goto ue;
        p6:
        $this->create_customer();
        ue:
        xc:
        if (!self::mo_check_option_admin_referer("\x6d\157\x5f\163\141\x6d\154\x5f\146\x72\145\x65\x5f\164\x72\151\x61\154")) {
            goto mB;
        }
        if (decryptSamlElement()) {
            goto WN;
        }
        $V5 = postResponse();
        $ko = new Customersaml();
        $Gs = $ko->mo_saml_vl($V5, false);
        if ($Gs) {
            goto m2;
        }
        return;
        m2:
        $Gs = json_decode($Gs, true);
        if (strcasecmp($Gs["\163\x74\x61\x74\x75\x73"], "\x53\125\103\103\x45\123\x53") == 0) {
            goto id;
        }
        if (strcasecmp($Gs["\x73\164\141\164\x75\x73"], "\x46\101\x49\114\x45\x44") == 0) {
            goto mr;
        }
        update_option("\155\x6f\137\163\141\155\154\x5f\x6d\145\163\163\141\147\145", "\x41\x6e\x20\145\x72\x72\x6f\x72\40\x6f\x63\143\x75\x72\145\x64\x20\x77\x68\151\x6c\145\40\x70\162\157\143\x65\163\163\x69\156\147\x20\171\157\x75\162\40\162\x65\161\x75\x65\163\164\56\x20\120\x6c\x65\141\x73\x65\x20\124\162\x79\x20\x61\147\141\x69\156\x2e");
        $this->mo_saml_show_error_message();
        goto Va;
        mr:
        update_option("\x6d\x6f\137\x73\141\x6d\x6c\x5f\155\145\x73\x73\141\147\145", "\x54\150\145\162\145\x20\x77\x61\163\40\141\x6e\x20\145\x72\162\x6f\x72\x20\x61\143\164\151\166\141\164\x69\156\147\40\x79\157\165\x72\x20\x54\x52\x49\x41\114\40\166\145\162\x73\151\157\x6e\56\x20\x50\154\x65\x61\163\145\x20\x63\157\156\164\141\x63\164\40\x69\x6e\x66\x6f\100\170\x65\143\x75\162\151\x66\x79\x2e\x63\157\155\40\x66\x6f\x72\40\x67\x65\164\x74\151\x6e\147\x20\156\x65\x77\x20\x6c\151\143\145\156\163\x65\40\146\x6f\x72\40\164\162\151\141\x6c\40\166\x65\x72\x73\151\157\156\x2e");
        $this->mo_saml_show_error_message();
        Va:
        goto i5;
        id:
        $ld = get_option("\x6d\x6f\x5f\x73\141\x6d\154\137\x63\x75\x73\x74\157\155\145\162\137\164\157\153\x65\156");
        $ld = get_option("\x6d\157\x5f\x73\141\155\x6c\137\x63\165\163\x74\x6f\155\x65\162\137\x74\157\x6b\x65\156");
        update_option("\164\137\x73\151\x74\x65\137\x73\x74\x61\164\x75\x73", AESEncryption::encrypt_data("\x74\x72\165\x65", $ld));
        update_option("\x6d\x6f\137\x73\141\x6d\154\137\x6d\145\x73\163\x61\x67\x65", "\131\157\165\162\40\65\x20\x64\x61\171\163\40\124\122\111\101\114\x20\151\163\x20\x61\143\164\x69\x76\x61\x74\145\x64\56\40\x59\157\x75\x20\x63\141\x6e\x20\156\157\x77\40\163\x65\x74\165\160\x20\x74\x68\145\x20\x70\154\x75\147\x69\x6e\56");
        $this->mo_saml_show_success_message();
        i5:
        goto tC;
        WN:
        update_option("\155\157\137\x73\x61\x6d\154\x5f\155\x65\x73\163\141\x67\x65", "\x54\x68\x65\162\145\40\167\141\163\40\x61\156\40\x65\x72\162\x6f\x72\40\141\143\164\151\166\141\164\151\x6e\x67\40\x79\157\165\162\x20\124\x52\111\101\114\x20\166\x65\x72\x73\151\157\x6e\56\40\x45\x69\164\150\145\x72\x20\x79\x6f\165\x72\40\164\x72\x69\x61\154\x20\160\145\x72\151\157\x64\40\x69\x73\x20\x65\170\160\151\x72\x65\144\x20\157\x72\x20\x79\157\x75\40\x61\162\145\x20\165\163\x69\156\x67\x20\167\x72\x6f\156\x67\40\x74\x72\151\x61\154\x20\x76\145\162\x73\151\x6f\156\56\x20\120\x6c\145\141\x73\x65\x20\x63\157\156\x74\141\143\x74\x20\151\156\146\x6f\x40\x78\145\x63\165\x72\151\146\x79\56\143\157\155\x20\x66\157\x72\40\x67\145\x74\164\x69\156\x67\40\x6e\145\167\40\x6c\151\x63\145\x6e\163\145\40\146\157\x72\x20\x74\x72\151\141\x6c\x20\x76\x65\162\x73\151\157\x6e\x2e");
        $this->mo_saml_show_error_message();
        tC:
        mB:
        if (!self::mo_check_option_admin_referer("\x6d\157\137\163\x61\x6d\x6c\x5f\x63\150\145\x63\x6b\x5f\154\x69\x63\145\x6e\163\x65")) {
            goto F3;
        }
        $ko = new Customersaml();
        $Gs = $ko->check_customer_ln();
        if ($Gs) {
            goto XQ;
        }
        return;
        XQ:
        $Gs = json_decode($Gs, true);
        if (strcasecmp($Gs["\x73\x74\141\164\x75\163"], "\x53\x55\103\x43\105\123\123") == 0) {
            goto g7;
        }
        $ld = get_option("\x6d\x6f\137\x73\x61\x6d\154\137\143\x75\x73\164\x6f\x6d\x65\x72\x5f\164\x6f\x6b\145\156");
        update_option("\x73\151\164\x65\137\x63\x6b\137\154", AESEncryption::encrypt_data("\x66\141\154\163\145", $ld));
        $px = add_query_arg(array("\x74\141\142" => "\154\x69\143\x65\x6e\163\x69\x6e\147"), $_SERVER["\122\105\121\x55\105\123\x54\x5f\x55\x52\x49"]);
        update_option("\155\x6f\x5f\163\x61\155\154\x5f\x6d\145\x73\x73\141\147\x65", "\x59\x6f\165\40\150\141\166\x65\x20\x6e\x6f\x74\40\x75\x70\147\162\141\x64\x65\144\40\x79\145\164\56\40" . addLink("\x43\x6c\151\143\153\x20\150\x65\x72\x65", $px) . "\x20\164\x6f\40\x75\160\147\x72\141\144\145\40\x74\157\40\x70\x72\x65\x6d\x69\165\155\x20\x76\x65\x72\163\x69\157\x6e\56");
        $this->mo_saml_show_error_message();
        goto fA;
        g7:
        if (array_key_exists("\154\x69\x63\145\x6e\163\145\x50\x6c\141\156", $Gs) && !$this->mo_saml_check_empty_or_null($Gs["\x6c\x69\143\145\x6e\x73\145\120\x6c\141\x6e"])) {
            goto o9;
        }
        $ld = get_option("\155\x6f\x5f\x73\x61\x6d\154\x5f\x63\165\x73\164\157\x6d\145\162\137\164\157\x6b\x65\156");
        update_option("\x73\x69\x74\x65\137\143\153\x5f\x6c", AESEncryption::encrypt_data("\x66\141\154\x73\x65", $ld));
        $px = add_query_arg(array("\164\x61\x62" => "\154\151\143\x65\x6e\163\151\x6e\147"), $_SERVER["\122\105\121\125\105\123\124\137\125\122\x49"]);
        update_option("\155\157\x5f\x73\141\155\x6c\x5f\x6d\145\x73\x73\x61\147\x65", "\131\x6f\x75\x20\x68\x61\166\x65\x20\156\x6f\164\40\165\160\147\x72\x61\144\x65\x64\40\171\x65\x74\56\x20" . addLink("\103\x6c\151\143\153\x20\x68\145\x72\x65", $px) . "\x20\x74\x6f\40\165\x70\147\162\x61\x64\x65\x20\164\x6f\x20\x70\162\145\x6d\x69\165\155\40\166\x65\162\x73\x69\157\156\x2e");
        $this->mo_saml_show_error_message();
        goto eW;
        o9:
        update_option("\x6d\x6f\137\163\141\x6d\154\137\x6c\x69\143\x65\x6e\163\x65\x5f\156\x61\155\145", base64_encode($Gs["\x6c\x69\x63\145\156\x73\x65\120\154\141\x6e"]));
        $ld = get_option("\155\157\137\x73\141\155\154\x5f\x63\165\x73\164\157\155\x65\x72\137\164\x6f\153\x65\x6e");
        if (!(array_key_exists("\x6e\157\117\x66\125\x73\x65\x72\x73", $Gs) && !$this->mo_saml_check_empty_or_null($Gs["\156\157\x4f\146\x55\163\x65\x72\x73"]))) {
            goto K0;
        }
        update_option("\155\x6f\x5f\x73\x61\x6d\154\137\165\163\162\x5f\154\155\164", AESEncryption::encrypt_data($Gs["\x6e\157\117\x66\x55\163\145\x72\x73"], $ld));
        K0:
        update_option("\163\x69\164\x65\x5f\x63\x6b\137\154", AESEncryption::encrypt_data("\164\162\165\145", $ld));
        $R4 = plugin_dir_path(__FILE__);
        $Fw = home_url();
        $Fw = trim($Fw, "\x2f");
        if (preg_match("\x23\136\150\164\164\160\50\163\51\77\72\x2f\x2f\43", $Fw)) {
            goto aM;
        }
        $Fw = "\x68\164\x74\x70\72\x2f\x2f" . $Fw;
        aM:
        $jh = parse_url($Fw);
        $Js = preg_replace("\x2f\x5e\167\x77\x77\x5c\x2e\x2f", '', $jh["\150\157\x73\x74"]);
        $OI = wp_upload_dir();
        $D9 = $Js . "\55" . $OI["\142\141\x73\x65\x64\151\x72"];
        $yu = hash_hmac("\x73\x68\x61\x32\65\x36", $D9, "\64\x44\x48\146\152\x67\146\152\x61\x73\x6e\x64\x66\x73\141\x6a\x66\x48\107\112");
        $aT = $this->djkasjdksa();
        $Sl = round(strlen($aT) / rand(2, 20));
        $aT = substr_replace($aT, $yu, $Sl, 0);
        $EK = base64_decode($aT);
        if (is_writable($R4 . "\x6c\151\143\x65\x6e\x73\145")) {
            goto kM;
        }
        $aT = str_rot13($aT);
        $FO = base64_decode("\142\107\x4e\153\x61\x6d\x74\x68\x63\x32\x70\x6b\141\63\116\x68\x59\x32\167\75");
        update_option($FO, $aT);
        goto uT;
        kM:
        file_put_contents($R4 . "\x6c\x69\143\x65\x6e\x73\145", $EK);
        uT:
        update_option("\154\x63\x77\162\x74\154\146\x73\x61\x6d\154", true);
        $px = add_query_arg(array("\x74\141\142" => "\147\x65\x6e\145\x72\x61\154"), $_SERVER["\122\x45\x51\125\x45\123\124\137\x55\122\x49"]);
        update_option("\x6d\x6f\x5f\163\141\155\154\137\155\x65\x73\163\141\147\145", "\x59\x6f\165\x20\x68\x61\x76\x65\x20\x73\x75\143\143\145\x73\163\x66\x75\154\154\x79\x20\x75\x70\x67\x72\x61\x64\x65\144\x20\171\x6f\165\x72\40\x6c\x69\x63\x65\x6e\163\145\x2e");
        $this->mo_saml_show_success_message();
        eW:
        fA:
        F3:
        if (!self::mo_check_option_admin_referer("\155\x6f\x5f\163\141\155\x6c\x5f\162\x65\155\157\x76\x65\137\141\x63\x63\157\x75\156\x74")) {
            goto HT;
        }
        $this->mo_sso_saml_deactivate();
        add_option("\155\157\x5f\163\x61\155\x6c\137\162\145\147\x69\163\x74\162\141\164\x69\157\156\137\163\164\141\164\165\x73", "\162\x65\x6d\157\166\x65\x64\137\x61\x63\x63\157\x75\x6e\164");
        $px = add_query_arg(array("\x74\x61\142" => "\x6c\157\147\151\x6e"), $_SERVER["\x52\x45\x51\125\x45\x53\x54\x5f\125\x52\111"]);
        header("\x4c\x6f\x63\x61\x74\x69\157\x6e\x3a\x20" . $px);
        HT:
        jk:
    }
    function create_customer()
    {
        $ko = new CustomerSaml();
        $zs = $ko->create_customer();
        if ($zs) {
            goto zX;
        }
        return;
        zX:
        $Gs = json_decode($Gs, true);
        if (strcasecmp($zs["\163\164\141\164\x75\x73"], "\x43\125\x53\x54\117\x4d\x45\122\137\x55\x53\105\x52\116\101\115\105\137\101\114\x52\x45\101\104\131\137\105\130\111\x53\124\x53") == 0) {
            goto Ea;
        }
        if (!(strcasecmp($zs["\x73\164\x61\164\x75\163"], "\123\125\103\x43\105\x53\x53") == 0)) {
            goto T1;
        }
        update_option("\x6d\x6f\x5f\x73\x61\x6d\154\137\x61\x64\x6d\x69\x6e\x5f\143\x75\x73\x74\157\155\x65\162\x5f\x6b\x65\171", $zs["\151\x64"]);
        update_option("\155\x6f\x5f\x73\141\x6d\x6c\x5f\141\144\x6d\151\156\137\141\x70\x69\x5f\x6b\145\171", $zs["\x61\x70\151\x4b\x65\171"]);
        update_option("\155\x6f\x5f\163\141\155\154\137\x63\165\163\164\157\155\145\162\137\164\x6f\x6b\x65\x6e", $zs["\x74\157\153\x65\x6e"]);
        update_option("\155\x6f\x5f\163\141\155\154\137\x61\144\x6d\151\156\137\160\x61\163\163\x77\x6f\x72\x64", '');
        update_option("\155\157\137\163\x61\155\x6c\137\x6d\145\x73\x73\141\x67\x65", "\x54\150\x61\x6e\153\x20\171\157\x75\40\x66\157\162\40\x72\145\147\x69\x73\164\x65\162\151\x6e\x67\x20\x77\x69\x74\150\40\x58\x65\x63\165\x72\151\146\x79\56");
        update_option("\155\157\x5f\163\x61\155\x6c\137\162\145\147\151\x73\164\162\x61\x74\151\157\156\137\163\164\x61\164\x75\163", '');
        delete_option("\155\x6f\137\163\141\x6d\154\x5f\166\x65\x72\151\x66\171\137\143\165\163\164\157\x6d\145\x72");
        delete_option("\155\157\137\163\x61\x6d\154\137\x6e\x65\x77\x5f\162\x65\x67\151\x73\x74\162\141\x74\151\157\x6e");
        $this->mo_saml_show_success_message();
        T1:
        goto r9;
        Ea:
        $this->get_current_customer();
        r9:
        update_option("\155\157\x5f\163\x61\x6d\x6c\x5f\141\x64\x6d\151\156\137\x70\141\163\x73\167\x6f\162\x64", '');
    }
    function get_current_customer()
    {
        $ko = new CustomerSaml();
        $Gs = $ko->get_customer_key();
        if ($Gs) {
            goto ey;
        }
        return;
        ey:
        $zs = json_decode($Gs, true);
        if (json_last_error() == JSON_ERROR_NONE) {
            goto iN;
        }
        update_option("\x6d\157\137\x73\x61\x6d\154\x5f\155\145\x73\163\141\147\x65", "\131\x6f\x75\x20\141\154\x72\x65\x61\x64\171\40\150\141\x76\x65\40\x61\x6e\x20\141\143\143\157\165\156\164\40\167\x69\164\150\x20\155\x69\x6e\x69\x4f\162\x61\156\147\145\x2e\x20\120\154\x65\141\x73\145\40\145\156\x74\x65\x72\x20\x61\40\x76\x61\154\x69\144\x20\160\141\x73\163\167\157\x72\144\56");
        update_option("\x6d\x6f\x5f\163\141\x6d\x6c\137\166\x65\162\151\146\x79\137\x63\x75\x73\164\157\x6d\x65\162", "\164\162\x75\x65");
        delete_option("\x6d\x6f\x5f\163\x61\155\154\137\x6e\x65\x77\x5f\x72\x65\147\x69\x73\164\162\x61\164\x69\x6f\156");
        $this->mo_saml_show_error_message();
        goto R3;
        iN:
        update_option("\155\x6f\137\163\141\x6d\x6c\137\141\144\x6d\151\x6e\x5f\x63\x75\163\x74\x6f\x6d\x65\x72\137\x6b\x65\x79", $zs["\151\x64"]);
        update_option("\x6d\x6f\137\163\141\x6d\154\137\141\144\155\151\x6e\x5f\141\x70\151\x5f\x6b\145\171", $zs["\x61\160\x69\x4b\145\x79"]);
        update_option("\x6d\x6f\x5f\x73\x61\x6d\154\x5f\x63\x75\x73\x74\157\155\145\162\x5f\x74\157\x6b\145\x6e", $zs["\x74\x6f\x6b\x65\x6e"]);
        update_option("\155\157\x5f\163\x61\x6d\154\137\141\144\x6d\151\x6e\137\160\141\163\163\167\157\162\144", '');
        update_option("\155\x6f\137\x73\x61\x6d\154\x5f\x6d\145\x73\163\x61\x67\145", "\x59\x6f\165\x72\x20\x61\x63\x63\x6f\x75\x6e\x74\x20\150\141\x73\40\x62\145\x65\156\x20\162\145\x74\x72\x69\x65\x76\145\x64\x20\163\165\143\x63\x65\x73\163\x66\x75\154\154\x79\x2e");
        delete_option("\155\x6f\137\163\141\x6d\154\137\166\x65\162\x69\x66\x79\137\x63\x75\x73\x74\157\x6d\145\162");
        delete_option("\155\157\137\163\141\x6d\x6c\137\156\x65\x77\x5f\162\x65\147\x69\163\x74\x72\x61\164\x69\x6f\x6e");
        $this->mo_saml_show_success_message();
        R3:
    }
    public function mo_saml_check_empty_or_null($g2)
    {
        if (!(!isset($g2) || empty($g2))) {
            goto SU;
        }
        return true;
        SU:
        return false;
    }
    function miniorange_sso_menu()
    {
        $aZ = add_menu_page("\x4d\x4f\40\123\101\115\114\x20\123\x65\x74\164\151\x6e\147\163\40" . __("\x43\157\x6e\x66\x69\147\165\x72\145\x20\123\x41\115\114\x20\x49\144\x65\x6e\164\151\164\x79\40\120\x72\x6f\166\x69\x64\145\x72\x20\146\x6f\x72\40\x53\x53\117", "\x6d\x6f\x5f\x73\x61\x6d\x6c\x5f\163\145\x74\x74\151\x6e\x67\x73"), "\x6d\151\156\x69\117\x72\x61\156\147\145\x20\123\x41\x4d\x4c\x20\62\56\60\x20\x53\123\x4f", "\141\144\155\151\x6e\151\163\x74\162\x61\164\157\162", "\155\157\137\x73\x61\155\154\137\163\145\x74\164\151\156\x67\163", array($this, "\155\157\137\154\x6f\x67\151\x6e\137\167\151\x64\x67\145\x74\x5f\x73\141\155\x6c\137\x6f\160\x74\x69\157\156\163"), plugin_dir_url(__FILE__) . "\x69\x6d\141\x67\145\163\x2f\155\151\x6e\x69\157\162\141\x6e\147\145\x2e\160\x6e\x67");
    }
    function mo_saml_redirect_for_authentication($f6)
    {
        if (!mo_saml_is_customer_license_key_verified()) {
            goto sm;
        }
        if (!(mo_saml_is_sp_configured() && !is_user_logged_in())) {
            goto PY;
        }
        $co = get_option("\x6d\x6f\137\163\141\x6d\x6c\x5f\163\x70\137\142\x61\x73\x65\x5f\165\x72\x6c");
        if (!empty($co)) {
            goto Lx;
        }
        $co = home_url();
        Lx:
        if (!(get_option("\155\157\137\163\141\x6d\x6c\x5f\162\x65\154\x61\171\x5f\163\x74\141\164\x65") && get_option("\155\x6f\x5f\163\141\155\154\137\x72\145\154\141\x79\x5f\163\x74\x61\x74\x65") != '')) {
            goto Zx;
        }
        $f6 = get_option("\155\157\137\163\141\x6d\154\x5f\x72\145\154\x61\x79\137\x73\x74\x61\x74\145");
        Zx:
        $f6 = parse_url($f6, PHP_URL_PATH);
        $lB = empty($f6) ? "\57" : $f6;
        $ef = get_option("\x73\x61\155\154\137\x6c\x6f\x67\x69\156\x5f\x75\162\154");
        $jR = get_option("\163\x61\x6d\154\x5f\154\x6f\x67\151\156\x5f\x62\151\x6e\144\x69\156\x67\137\x74\x79\x70\x65");
        $eJ = get_option("\155\157\137\163\141\x6d\154\x5f\146\157\162\143\x65\137\141\x75\164\150\145\x6e\x74\151\x63\141\164\151\157\156");
        $dZ = $co . "\57";
        $J4 = get_option("\x6d\157\137\163\x61\x6d\154\137\163\x70\137\145\156\x74\151\x74\x79\x5f\x69\x64");
        $oz = get_option("\163\141\x6d\154\x5f\156\141\x6d\145\x69\144\137\146\x6f\162\155\x61\164");
        if (!empty($J4)) {
            goto p9;
        }
        $J4 = $co . "\57\x77\160\x2d\143\157\x6e\x74\x65\x6e\164\57\x70\154\x75\x67\x69\x6e\163\x2f\155\x69\156\151\x6f\x72\x61\x6e\x67\x65\55\163\x61\155\x6c\55\62\60\x2d\163\151\x6e\147\154\x65\55\163\151\147\x6e\55\x6f\156\57";
        p9:
        $Qo = SAMLSPUtilities::createAuthnRequest($dZ, $J4, $ef, $eJ, $jR, $oz);
        if (empty($jR) || $jR == "\x48\x74\x74\x70\x52\145\144\x69\x72\145\x63\x74") {
            goto bB;
        }
        if (!(get_option("\x73\x61\x6d\x6c\137\x72\145\161\165\x65\163\x74\x5f\x73\151\147\x6e\x65\x64") == "\165\x6e\x63\x68\x65\143\153\145\144")) {
            goto L2;
        }
        $VR = base64_encode($Qo);
        SAMLSPUtilities::postSAMLRequest($ef, $VR, $lB);
        die;
        L2:
        $X3 = plugin_dir_path(__FILE__) . "\162\145\163\157\x75\x72\x63\145\163" . DIRECTORY_SEPARATOR . "\x73\x70\x2d\153\145\x79\x2e\153\x65\171";
        $p2 = plugin_dir_path(__FILE__) . "\162\145\163\x6f\x75\162\143\145\163" . DIRECTORY_SEPARATOR . "\163\x70\55\x63\145\x72\x74\151\146\x69\143\141\164\x65\56\143\162\164";
        $VR = SAMLSPUtilities::signXML($Qo, $p2, $X3, "\116\x61\155\x65\x49\104\x50\x6f\154\151\x63\171");
        SAMLSPUtilities::postSAMLRequest($ef, $VR, $lB);
        goto oR1;
        bB:
        $sy = $ef;
        if (strpos($ef, "\77") !== false) {
            goto OS;
        }
        $sy .= "\77";
        goto lE;
        OS:
        $sy .= "\46";
        lE:
        if (!(get_option("\x73\x61\x6d\154\x5f\x72\x65\161\x75\145\163\164\x5f\x73\151\147\156\145\x64") == "\x75\x6e\143\150\145\143\153\x65\x64")) {
            goto ip;
        }
        $sy .= "\123\101\x4d\114\122\x65\x71\165\x65\x73\x74\x3d" . $Qo . "\x26\x52\x65\154\x61\171\123\x74\141\x74\x65\75" . urlencode($lB);
        header("\114\157\x63\141\x74\151\157\x6e\x3a\x20" . $sy);
        die;
        ip:
        $Qo = "\123\101\115\114\x52\145\x71\165\x65\163\x74\x3d" . $Qo . "\x26\x52\x65\154\141\171\123\x74\x61\164\145\75" . urlencode($lB) . "\x26\x53\x69\x67\101\154\147\x3d" . urlencode(XMLSecurityKey::RSA_SHA256);
        $hO = array("\164\x79\x70\x65" => "\160\162\151\x76\x61\x74\x65");
        $ld = new XMLSecurityKey(XMLSecurityKey::RSA_SHA256, $hO);
        $x0 = plugin_dir_path(__FILE__) . "\162\145\163\x6f\x75\x72\143\145\x73" . DIRECTORY_SEPARATOR . "\163\x70\x2d\x6b\x65\x79\56\153\145\171";
        $ld->loadKey($x0, TRUE);
        $E9 = new XMLSecurityDSig();
        $fJ = $ld->signData($Qo);
        $fJ = base64_encode($fJ);
        $sy .= $Qo . "\x26\123\x69\147\x6e\x61\x74\x75\162\x65\75" . urlencode($fJ);
        header("\x4c\x6f\143\x61\164\151\157\x6e\x3a\x20" . $sy);
        die;
        oR1:
        PY:
        sm:
    }
    function mo_saml_authenticate()
    {
        $Kz = '';
        if (!isset($_REQUEST["\162\145\x64\151\x72\x65\143\164\137\x74\157"])) {
            goto RG;
        }
        $Kz = htmlspecialchars($_REQUEST["\162\x65\144\x69\x72\145\x63\x74\137\164\157"]);
        RG:
        if (!is_user_logged_in()) {
            goto hg;
        }
        if (!empty($Kz)) {
            goto Jp;
        }
        header("\114\157\143\141\164\x69\157\156\x3a\40" . home_url());
        goto SN;
        Jp:
        header("\114\x6f\x63\x61\164\151\157\156\x3a\x20" . $Kz);
        SN:
        die;
        hg:
        if (!(get_option("\x6d\157\x5f\x73\x61\155\x6c\137\145\x6e\141\x62\154\145\137\x6c\x6f\147\x69\156\x5f\x72\x65\144\x69\162\145\x63\x74") == "\164\x72\165\145")) {
            goto WO;
        }
        $mt = get_option("\x6d\157\137\x73\x61\155\x6c\x5f\142\x61\143\x6b\144\x6f\x6f\162\137\x75\x72\x6c") ? trim(get_option("\155\x6f\137\163\x61\x6d\x6c\137\x62\x61\143\x6b\144\x6f\157\x72\137\x75\x72\x6c")) : "\146\141\154\163\145";
        if (isset($_GET["\154\157\147\x67\145\x64\157\x75\164"]) && $_GET["\x6c\x6f\x67\x67\145\x64\x6f\165\164"] == "\164\x72\x75\x65") {
            goto CH;
        }
        if (get_option("\x6d\157\x5f\x73\x61\155\x6c\x5f\141\154\154\x6f\167\x5f\x77\160\x5f\163\151\147\156\x69\x6e") == "\x74\x72\x75\145") {
            goto uJ;
        }
        goto KS;
        CH:
        header("\x4c\157\x63\x61\164\151\157\156\x3a\x20" . home_url());
        die;
        goto KS;
        uJ:
        if (isset($_GET["\163\x61\x6d\x6c\137\163\163\x6f"]) && $_GET["\x73\141\x6d\x6c\137\163\163\157"] == $mt || isset($_POST["\x73\x61\x6d\154\x5f\x73\163\157"]) && $_POST["\163\141\155\x6c\137\163\163\157"] == $mt) {
            goto j7;
        }
        if (isset($_REQUEST["\x72\x65\144\151\x72\x65\x63\x74\x5f\164\x6f"])) {
            goto Qz;
        }
        goto Lh;
        j7:
        return;
        goto Lh;
        Qz:
        $Kz = htmlspecialchars($_REQUEST["\x72\145\144\151\162\145\x63\164\137\164\157"]);
        if (!(strpos($Kz, "\x77\x70\55\x61\x64\x6d\x69\x6e") !== false && strpos($Kz, "\x73\141\155\154\x5f\x73\163\x6f\x3d" . $mt) !== false)) {
            goto FP;
        }
        return;
        FP:
        Lh:
        KS:
        $this->mo_saml_redirect_for_authentication($Kz);
        WO:
    }
    function mo_saml_auto_redirect()
    {
        if (!current_user_can("\x72\145\141\144")) {
            goto ol;
        }
        return;
        ol:
        if (!(get_option("\155\157\137\x73\141\x6d\x6c\x5f\162\145\147\x69\x73\164\145\x72\x65\144\x5f\x6f\156\x6c\171\x5f\141\143\x63\x65\163\163") == "\x74\162\165\x65")) {
            goto Rc;
        }
        if (!(get_option("\x6d\157\x5f\x73\x61\x6d\154\137\145\x6e\141\142\154\145\x5f\x72\163\x73\x5f\141\143\143\x65\163\163") == "\164\162\165\x65" && is_feed())) {
            goto LD;
        }
        return;
        LD:
        $f6 = saml_get_current_page_url();
        $this->mo_saml_redirect_for_authentication($f6);
        Rc:
    }
    function mo_saml_modify_login_form()
    {
        $mt = get_option("\x6d\157\x5f\163\x61\155\154\137\142\141\x63\153\x64\x6f\x6f\x72\x5f\x75\x72\x6c") ? trim(get_option("\155\157\x5f\163\141\x6d\154\137\x62\141\143\153\144\157\x6f\x72\137\x75\162\154")) : "\x66\141\154\163\x65";
        echo "\x3c\151\156\x70\x75\x74\x20\164\171\x70\x65\x3d\x22\150\x69\144\144\145\x6e\42\x20\x6e\141\155\x65\x3d\x22\163\x61\155\x6c\x5f\x73\163\x6f\x22\40\x76\141\x6c\165\145\x3d\42" . $mt . "\x22\x3e" . "\12";
    }
    function djkasjdksa()
    {
        $tn = "\41\x7e\x40\x23\44\x25\x5e\x26\x2a\50\51\137\53\174\173\x7d\x3c\x3e\77\60\x31\62\x33\x34\x35\66\x37\70\x39\141\x62\x63\x64\145\146\147\x68\x69\152\153\154\155\x6e\x6f\x70\161\162\163\164\x75\x76\x77\x78\171\172\x41\102\x43\x44\x45\x46\x47\x48\111\112\x4b\114\115\116\117\120\121\122\x53\x54\125\x56\127\130\x59\x5a";
        $m9 = strlen($tn);
        $m3 = '';
        $oM = 0;
        NB:
        if (!($oM < 10000)) {
            goto L3;
        }
        $m3 .= $tn[rand(0, $m9 - 1)];
        II:
        $oM++;
        goto NB;
        L3:
        return $m3;
    }
    function mo_get_saml_shortcode()
    {
        if (!is_user_logged_in()) {
            goto S3;
        }
        $current_user = wp_get_current_user();
        $FX = "\x48\x65\x6c\154\x6f\54";
        if (!get_option("\155\157\x5f\x73\141\x6d\154\137\143\165\163\x74\x6f\155\x5f\x67\x72\x65\x65\x74\151\156\x67\x5f\x74\x65\170\164")) {
            goto YW;
        }
        $FX = get_option("\155\x6f\x5f\163\x61\x6d\x6c\x5f\x63\165\x73\164\157\x6d\137\147\x72\x65\145\164\x69\156\147\x5f\164\145\170\164");
        YW:
        $rM = '';
        if (!get_option("\155\157\x5f\x73\141\155\x6c\137\x67\162\x65\x65\164\x69\x6e\x67\x5f\156\x61\155\x65")) {
            goto Mc;
        }
        switch (get_option("\x6d\x6f\x5f\163\141\x6d\154\137\x67\162\145\x65\164\151\x6e\x67\137\x6e\141\x6d\145")) {
            case "\x55\x53\105\x52\x4e\x41\115\105":
                $rM = $current_user->user_login;
                goto Zu;
            case "\x45\x4d\101\111\x4c":
                $rM = $current_user->user_email;
                goto Zu;
            case "\x46\116\x41\x4d\105":
                $rM = $current_user->user_firstname;
                goto Zu;
            case "\114\x4e\x41\x4d\x45":
                $rM = $current_user->user_lastname;
                goto Zu;
            case "\x46\116\x41\115\x45\x5f\114\116\101\115\105":
                $rM = $current_user->user_firstname . "\40" . $current_user->user_lastname;
                goto Zu;
            case "\x4c\116\101\115\x45\137\106\x4e\101\x4d\x45":
                $rM = $current_user->user_lastname . "\40" . $current_user->user_firstname;
                goto Zu;
            default:
                $rM = $current_user->user_login;
        }
        bv:
        Zu:
        Mc:
        if (!empty(trim($rM))) {
            goto Oy;
        }
        $rM = $current_user->user_login;
        Oy:
        $EW = $FX . "\40" . $rM;
        $FB = "\114\x6f\147\157\165\x74";
        if (!get_option("\155\157\137\163\x61\155\x6c\137\143\165\163\x74\157\x6d\x5f\x6c\157\x67\157\165\164\x5f\x74\145\170\x74")) {
            goto sG;
        }
        $FB = get_option("\x6d\157\137\163\x61\155\154\x5f\x63\x75\163\164\x6f\155\137\x6c\x6f\147\x6f\x75\x74\x5f\164\x65\x78\164");
        sG:
        $bZ = $EW . "\x20\x7c\x20\x3c\x61\x20\150\x72\145\x66\75\42" . wp_logout_url(home_url()) . "\x22\x20\x74\x69\x74\154\x65\x3d\42\x6c\157\147\x6f\165\x74\42\40\76" . $FB . "\74\57\141\x3e\74\57\x6c\x69\x3e";
        $px = saml_get_current_page_url();
        update_option("\x6c\157\147\157\x75\164\x5f\162\145\144\151\x72\x65\143\164\x5f\x75\x72\x6c", $px);
        goto Zh;
        S3:
        $co = get_option("\155\x6f\x5f\x73\141\x6d\x6c\x5f\x73\x70\x5f\x62\x61\x73\145\x5f\165\162\x6c");
        if (!empty($co)) {
            goto rG;
        }
        $co = home_url();
        rG:
        if (mo_saml_is_sp_configured() && mo_saml_is_customer_license_key_verified()) {
            goto jE;
        }
        $bZ = "\x53\x50\40\x69\x73\40\x6e\157\164\40\x63\157\x6e\146\151\147\x75\162\145\144\x2e";
        goto OU;
        jE:
        $Qe = "\x4c\x6f\x67\151\x6e\x20\167\x69\164\x68\x20" . get_option("\x73\x61\x6d\154\x5f\x69\144\145\156\x74\151\x74\171\x5f\x6e\x61\x6d\x65");
        if (!get_option("\x6d\x6f\137\x73\x61\x6d\154\x5f\x63\x75\163\164\x6f\155\x5f\x6c\157\x67\x69\156\137\x74\145\x78\x74")) {
            goto vH;
        }
        $Qe = get_option("\x6d\157\137\163\141\155\154\137\143\x75\x73\x74\157\155\137\154\157\147\151\156\137\x74\x65\170\x74");
        vH:
        $h7 = get_option("\163\141\x6d\x6c\x5f\x69\144\145\x6e\164\151\164\171\137\x6e\x61\x6d\145");
        $Qe = str_replace("\43\43\x49\x44\x50\43\43", $h7, $Qe);
        $Kz = urlencode(saml_get_current_page_url());
        $bZ = "\x3c\x61\40\x68\x72\145\146\75\42" . $co . "\57\x3f\x6f\x70\164\151\157\x6e\75\x73\x61\155\x6c\x5f\x75\x73\x65\162\x5f\154\157\147\151\x6e\x26\162\145\144\151\162\x65\x63\164\x5f\164\x6f\x3d" . $Kz . "\42\x3e" . $Qe . "\74\57\141\76";
        OU:
        Zh:
        return $bZ;
    }
    function _handle_upload_metadata()
    {
        if (!(isset($_FILES["\155\145\x74\141\144\141\x74\x61\x5f\146\x69\x6c\x65"]) || isset($_POST["\155\145\x74\141\x64\x61\x74\141\x5f\165\x72\x6c"]))) {
            goto PZ;
        }
        if (!empty($_FILES["\155\x65\x74\141\x64\141\x74\x61\x5f\x66\151\x6c\145"]["\164\155\160\137\156\x61\155\x65"])) {
            goto nM;
        }
        if (mo_saml_is_extension_installed("\143\165\162\x6c")) {
            goto Qo;
        }
        update_option("\155\x6f\137\163\141\155\154\x5f\x6d\x65\163\163\141\147\145", "\120\x48\x50\x20\x63\x55\x52\x4c\40\x65\x78\164\x65\x6e\163\x69\x6f\156\x20\x69\x73\x20\156\x6f\x74\x20\x69\156\x73\x74\x61\154\x6c\145\144\40\x6f\162\x20\x64\x69\x73\141\142\154\x65\x64\56\x20\103\141\x6e\x6e\157\164\40\x66\x65\164\x63\150\x20\x6d\145\x74\x61\x64\x61\x74\x61\x20\146\162\x6f\x6d\x20\125\122\114\x2e");
        $this->mo_saml_show_error_message();
        return;
        Qo:
        $px = filter_var(htmlspecialchars($_POST["\155\145\164\141\144\x61\x74\x61\137\165\162\154"]), FILTER_SANITIZE_URL);
        $CS = SAMLSPUtilities::mo_saml_wp_remote_call($px, array("\x73\x73\154\166\x65\x72\151\146\x79" => false), true);
        if (!is_null($CS)) {
            goto Pw;
        }
        $su = null;
        goto FT;
        Pw:
        $su = $CS;
        FT:
        goto Dr;
        nM:
        $su = @file_get_contents($_FILES["\x6d\x65\x74\141\144\141\x74\141\137\x66\x69\154\145"]["\164\155\x70\x5f\156\141\x6d\x65"]);
        Dr:
        if (!is_null($su)) {
            goto BX;
        }
        update_option("\155\x6f\137\x73\141\155\154\137\x6d\145\x73\x73\x61\x67\145", "\111\156\x76\141\154\x69\x64\40\x4d\x65\164\x61\144\141\x74\x61\40\106\151\154\x65\40\157\x72\40\x55\x52\x4c");
        return;
        goto WK;
        BX:
        $this->upload_metadata($su);
        WK:
        PZ:
    }
    function upload_metadata($su)
    {
        $DO = set_error_handler(array($this, "\150\x61\156\144\x6c\145\x58\x6d\x6c\105\162\x72\157\162"));
        $BE = new DOMDocument();
        $BE->loadXML($su);
        restore_error_handler();
        $LF = $BE->firstChild;
        if (!empty($LF)) {
            goto ND;
        }
        if (!empty($_FILES["\x6d\x65\x74\141\x64\141\164\x61\x5f\x66\151\154\145"]["\x74\x6d\x70\x5f\x6e\x61\155\x65"])) {
            goto z6;
        }
        if (!empty($_POST["\x6d\145\x74\141\x64\x61\164\141\x5f\165\162\154"])) {
            goto wV;
        }
        update_option("\x6d\157\137\163\141\155\x6c\137\155\x65\163\163\141\x67\145", "\120\154\145\141\163\x65\x20\160\x72\x6f\x76\151\144\145\x20\x61\x20\166\x61\154\x69\x64\40\155\145\x74\x61\144\x61\164\141\40\146\x69\154\145\40\x6f\x72\40\x61\x20\166\x61\154\x69\x64\x20\x55\122\x4c\56");
        $this->mo_saml_show_error_message();
        return;
        goto vg;
        wV:
        update_option("\x6d\x6f\137\x73\x61\155\154\x5f\155\145\163\163\x61\x67\x65", "\120\154\x65\141\x73\145\40\x70\162\x6f\x76\x69\x64\145\x20\x61\40\x76\141\x6c\x69\144\x20\x6d\x65\x74\x61\144\x61\164\141\x20\x55\x52\x4c\x2e");
        $this->mo_saml_show_error_message();
        return;
        vg:
        goto IE;
        z6:
        update_option("\155\157\137\163\x61\x6d\154\x5f\x6d\145\163\163\x61\x67\x65", "\120\x6c\x65\141\163\145\x20\x70\x72\x6f\166\x69\x64\x65\40\141\40\166\141\x6c\151\144\40\x6d\145\164\141\x64\x61\164\x61\40\x66\151\x6c\145\56");
        $this->mo_saml_show_error_message();
        return;
        IE:
        goto BJ;
        ND:
        $OJ = new IDPMetadataReader($BE);
        $C2 = $OJ->getIdentityProviders();
        if (!(empty($C2) && !empty($_FILES["\x6d\145\164\141\144\x61\164\141\x5f\146\151\154\145"]["\164\x6d\160\x5f\156\x61\155\x65"]))) {
            goto iC;
        }
        update_option("\155\157\x5f\x73\x61\x6d\154\x5f\155\145\163\x73\141\147\145", "\120\x6c\x65\x61\163\x65\x20\160\x72\157\166\151\144\x65\x20\x61\40\x76\141\x6c\151\144\40\x6d\x65\x74\141\144\141\164\141\40\146\x69\x6c\145\56");
        $this->mo_saml_show_error_message();
        return;
        iC:
        if (!(empty($C2) && !empty($_POST["\x6d\145\x74\x61\x64\x61\164\141\x5f\x75\x72\154"]))) {
            goto qU;
        }
        update_option("\x6d\x6f\x5f\163\x61\155\154\x5f\x6d\145\x73\x73\x61\147\x65", "\x50\154\145\x61\x73\145\40\x70\162\157\x76\x69\x64\x65\40\x61\40\x76\x61\154\151\x64\40\155\145\164\x61\144\x61\x74\141\x20\125\x52\114\x2e");
        $this->mo_saml_show_error_message();
        return;
        qU:
        foreach ($C2 as $ld => $f2) {
            $Qz = htmlspecialchars($_POST["\163\x61\155\x6c\x5f\x69\144\145\x6e\x74\151\x74\171\x5f\x6d\145\164\141\144\141\164\141\x5f\160\162\157\x76\x69\144\x65\162"]);
            $jw = "\110\x74\x74\x70\122\145\144\151\162\145\143\164";
            $HF = '';
            if (array_key_exists("\x48\x54\124\x50\x2d\122\x65\144\151\162\145\143\164", $f2->getLoginDetails())) {
                goto Ft;
            }
            if (!array_key_exists("\x48\124\x54\x50\x2d\120\x4f\123\x54", $f2->getLoginDetails())) {
                goto DY;
            }
            $jw = "\x48\x74\164\160\x50\x6f\x73\x74";
            $HF = $f2->getLoginURL("\x48\x54\124\x50\x2d\x50\x4f\123\x54");
            DY:
            goto l4;
            Ft:
            $HF = $f2->getLoginURL("\110\124\x54\x50\x2d\x52\x65\x64\x69\162\145\143\164");
            l4:
            $xZ = "\x48\x74\x74\160\x52\145\144\x69\x72\x65\x63\164";
            $Ig = '';
            if (array_key_exists("\x48\124\124\120\x2d\122\145\x64\x69\162\145\143\x74", $f2->getLogoutDetails())) {
                goto Zf;
            }
            if (!array_key_exists("\x48\124\124\120\x2d\120\x4f\x53\124", $f2->getLogoutDetails())) {
                goto IC;
            }
            $xZ = "\110\x74\164\160\120\x6f\163\x74";
            $Ig = $f2->getLogoutURL("\110\124\x54\120\55\x50\x4f\x53\x54");
            IC:
            goto c9;
            Zf:
            $Ig = $f2->getLogoutURL("\110\x54\124\120\x2d\x52\145\144\151\162\145\x63\164");
            c9:
            $Ou = $f2->getEntityID();
            $gF = $f2->getSigningCertificate();
            update_option("\x73\141\x6d\x6c\137\x69\144\145\156\164\x69\x74\171\137\156\141\x6d\x65", $Qz);
            update_option("\x73\x61\x6d\154\137\154\x6f\147\151\156\x5f\x62\x69\156\144\151\x6e\147\137\x74\x79\x70\145", $jw);
            update_option("\163\141\x6d\x6c\x5f\154\157\147\151\156\137\x75\x72\x6c", $HF);
            update_option("\163\141\x6d\154\137\x6c\x6f\147\x6f\165\x74\137\142\x69\x6e\x64\151\x6e\x67\137\164\171\160\x65", $xZ);
            update_option("\163\141\x6d\x6c\x5f\154\x6f\x67\157\165\x74\137\165\162\x6c", $Ig);
            update_option("\x73\141\x6d\154\x5f\x69\x73\163\x75\x65\x72", $Ou);
            update_option("\163\141\x6d\154\137\x6e\x61\x6d\145\151\x64\x5f\x66\x6f\x72\x6d\x61\164", "\x31\x2e\61\x3a\x6e\141\x6d\145\x69\x64\55\146\157\x72\x6d\x61\x74\x3a\165\x6e\x73\x70\145\x63\x69\146\151\145\144");
            update_option("\x73\x61\x6d\154\137\170\x35\60\x39\137\143\x65\x72\x74\151\146\x69\x63\141\164\x65", maybe_serialize($gF));
            goto aP;
            kD:
        }
        aP:
        update_option("\155\x6f\x5f\x73\141\155\x6c\x5f\155\145\x73\163\141\x67\145", "\x49\144\x65\156\164\151\x74\x79\x20\120\x72\157\166\x69\144\145\162\40\x64\x65\164\141\151\x6c\163\40\x73\141\x76\145\144\40\x73\x75\x63\x63\x65\x73\x73\146\165\154\154\171\x2e");
        $this->mo_saml_show_success_message();
        BJ:
    }
    function handleXmlError($KM, $ji, $lA, $f0)
    {
        if ($KM == E_WARNING && substr_count($ji, "\x44\x4f\x4d\x44\157\x63\x75\x6d\145\x6e\x74\72\x3a\154\157\141\x64\130\x4d\x4c\x28\x29") > 0) {
            goto g0;
        }
        return false;
        goto ZQ;
        g0:
        return;
        ZQ:
    }
    function mo_saml_plugin_action_links($qp)
    {
        $qp = array_merge(array("\x3c\141\x20\150\162\x65\x66\75\42" . esc_url(admin_url("\141\x64\155\151\x6e\x2e\x70\150\x70\77\160\x61\x67\x65\x3d\x6d\157\x5f\163\141\155\154\137\163\x65\164\x74\x69\156\147\163")) . "\x22\x3e" . __("\x53\145\x74\x74\x69\x6e\147\163", "\164\145\x78\164\x64\157\x6d\141\x69\156") . "\x3c\57\x61\76"), $qp);
        return $qp;
    }
    function checkPasswordPattern($JV)
    {
        $U6 = "\x2f\136\x5b\50\134\167\51\52\x28\134\x21\x5c\x40\134\x23\134\44\x5c\x25\x5c\x5e\134\46\134\x2a\x5c\x2e\134\x2d\134\x5f\x29\52\135\53\44\x2f";
        return !preg_match($U6, $JV);
    }
}
new saml_mo_login();
