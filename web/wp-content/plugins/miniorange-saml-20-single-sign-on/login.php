<?php
/*
Plugin Name: miniOrange SSO using SAML 2.0
Plugin URI: http://miniorange.com/
Description: (Standard)miniOrange SAML 2.0 SSO enables user to perform Single Sign On with any SAML 2.0 enabled Identity Provider.
Version: 16.0.2
Author: miniOrange
Author URI: http://miniorange.com/
*/


include_once dirname(__FILE__) . "\x2f\x6d\157\x5f\154\157\147\151\x6e\137\163\141\155\x6c\x5f\163\163\x6f\137\x77\x69\x64\x67\145\164\56\x70\x68\160";
include_once "\x78\155\154\x73\x65\x63\154\x69\142\163\56\x70\150\x70";
use RobRichards\XMLSecLibs\XMLSecurityKey;
use RobRichards\XMLSecLibs\XMLSecurityDSig;
use RobRichards\XMLSecLibs\XMLSecEnc;
require "\x6d\157\x2d\x73\141\x6d\154\x2d\143\x6c\x61\163\x73\x2d\x63\165\x73\x74\x6f\155\x65\162\56\160\x68\x70";
require "\155\x6f\137\x73\x61\x6d\x6c\x5f\163\x65\164\x74\151\156\x67\163\x5f\x70\x61\x67\x65\x2e\x70\x68\x70";
require "\115\145\x74\x61\144\141\x74\141\122\x65\x61\144\145\x72\56\160\x68\160";
require "\x63\145\162\164\x69\146\151\x63\141\x74\145\x5f\x75\x74\151\154\151\x74\171\x2e\160\150\x70";
require_once "\111\155\x70\x6f\x72\164\x2d\145\170\160\157\x72\164\56\x70\x68\x70";
require_once "\155\157\x2d\x73\x61\x6d\154\x2d\160\x6c\165\x67\x69\x6e\55\x76\x65\x72\x73\151\x6f\x6e\55\165\160\144\x61\x74\x65\x2e\x70\150\x70";
class saml_mo_login
{
    function __construct()
    {
        add_action("\141\144\155\x69\x6e\x5f\155\145\156\165", array($this, "\155\151\156\x69\x6f\162\141\x6e\147\x65\137\163\163\x6f\x5f\155\145\x6e\x75"));
        add_action("\141\144\x6d\151\156\137\151\156\151\164", array($this, "\x6d\x69\x6e\x69\x6f\162\x61\156\147\145\137\x6c\157\x67\x69\x6e\x5f\x77\x69\144\x67\x65\x74\137\163\x61\x6d\x6c\137\163\x61\x76\145\137\x73\145\x74\164\x69\x6e\147\163"));
        add_action("\x61\144\155\151\156\137\145\x6e\161\x75\x65\x75\x65\137\163\x63\x72\151\x70\x74\x73", array($this, "\x70\x6c\x75\x67\x69\x6e\x5f\x73\145\x74\164\x69\x6e\x67\163\x5f\163\164\171\x6c\x65"));
        register_deactivation_hook(__FILE__, array($this, "\x6d\157\137\163\163\157\x5f\163\141\x6d\154\x5f\144\x65\x61\143\164\151\x76\141\x74\x65"));
        add_action("\141\144\155\151\156\137\145\x6e\x71\x75\x65\165\145\137\x73\x63\162\x69\x70\164\x73", array($this, "\x70\x6c\x75\x67\x69\156\x5f\163\145\164\x74\x69\x6e\147\163\137\163\143\162\x69\x70\164"));
        remove_action("\141\144\x6d\151\156\x5f\156\157\164\151\x63\x65\x73", array($this, "\x6d\x6f\x5f\163\x61\x6d\154\x5f\163\165\x63\143\145\163\163\x5f\155\x65\163\x73\141\147\145"));
        remove_action("\x61\x64\155\x69\156\x5f\156\157\164\151\x63\x65\x73", array($this, "\155\x6f\137\x73\x61\x6d\154\x5f\x65\x72\162\157\162\x5f\x6d\x65\163\x73\141\147\145"));
        add_action("\x77\160\x5f\141\165\x74\150\145\x6e\164\151\x63\141\x74\145", array($this, "\x6d\x6f\x5f\163\x61\155\x6c\137\x61\x75\x74\150\145\156\x74\x69\143\x61\164\145"));
        add_action("\167\160", array($this, "\155\x6f\x5f\x73\141\155\x6c\x5f\x61\165\164\157\137\x72\x65\x64\151\x72\x65\143\164"));
        add_action("\x61\144\155\x69\156\x5f\x69\x6e\x69\x74", "\155\157\137\163\x61\x6d\x6c\137\x64\157\x77\x6e\154\157\141\x64");
        add_action("\x6c\157\147\151\x6e\x5f\146\x6f\x72\155", array($this, "\x6d\x6f\137\163\141\155\154\x5f\155\x6f\144\x69\x66\x79\x5f\154\x6f\147\x69\x6e\x5f\146\x6f\x72\155"));
        add_shortcode("\x4d\117\x5f\123\x41\x4d\114\137\x46\x4f\x52\115", array($this, "\x6d\x6f\x5f\x67\x65\x74\137\x73\141\x6d\154\x5f\x73\x68\157\162\164\143\157\x64\145"));
        add_action("\141\x64\x6d\151\156\137\x69\x6e\151\x74", array($this, "\144\x65\146\141\x75\x6c\164\137\143\x65\x72\x74\x69\x66\x69\143\141\x74\x65"));
        register_activation_hook(__FILE__, array($this, "\155\157\137\x73\x61\155\x6c\x5f\x63\x68\145\x63\153\137\x6f\160\145\x6e\x73\163\x6c"));
        add_action("\160\x6c\165\147\x69\156\x5f\141\x63\x74\151\157\156\x5f\x6c\x69\156\153\163\x5f" . plugin_basename(__FILE__), array($this, "\x6d\x6f\x5f\x73\141\155\154\x5f\160\154\165\147\x69\156\137\141\x63\x74\151\x6f\x6e\137\x6c\151\156\x6b\x73"));
    }
    function default_certificate()
    {
        $eV = file_get_contents(plugin_dir_path(__FILE__) . "\162\145\x73\x6f\x75\162\x63\x65\163" . DIRECTORY_SEPARATOR . "\x6d\x69\x6e\x69\x6f\x72\141\156\x67\145\x5f\163\160\x5f\62\60\62\60\56\x63\x72\164");
        $Dy = file_get_contents(plugin_dir_path(__FILE__) . "\162\145\x73\157\x75\x72\x63\x65\163" . DIRECTORY_SEPARATOR . "\x6d\x69\x6e\151\157\x72\141\x6e\147\145\137\x73\160\137\62\60\62\60\137\x70\162\x69\x76\56\x6b\145\x79");
        if (!(!get_option("\155\x6f\137\163\x61\x6d\154\x5f\x63\x75\162\x72\145\x6e\164\x5f\143\x65\162\164") && !get_option("\x6d\157\x5f\163\141\155\154\137\x63\x75\162\162\145\156\x74\137\x63\x65\x72\x74\x5f\x70\x72\x69\166\141\x74\x65\x5f\153\145\171"))) {
            goto w9;
        }
        if (get_option("\155\x6f\137\163\x61\155\x6c\137\x63\x65\162\164") && get_option("\x6d\157\137\x73\x61\x6d\154\x5f\x63\x65\x72\x74\137\160\162\151\166\141\164\x65\137\x6b\145\171")) {
            goto Eu;
        }
        update_option("\x6d\157\x5f\x73\141\x6d\154\x5f\143\165\x72\x72\145\156\164\137\x63\x65\x72\x74", $eV);
        update_option("\155\x6f\137\x73\x61\155\x6c\137\x63\x75\162\x72\145\x6e\x74\x5f\x63\145\x72\x74\137\x70\162\x69\166\x61\x74\x65\137\153\x65\171", $Dy);
        goto Xb;
        Eu:
        update_option("\x6d\x6f\137\163\141\x6d\154\137\143\165\x72\x72\x65\156\x74\x5f\x63\x65\162\x74", get_option("\155\157\x5f\163\x61\155\x6c\137\x63\145\x72\x74"));
        update_option("\x6d\157\137\x73\x61\155\154\137\x63\165\x72\x72\145\x6e\164\x5f\143\x65\x72\x74\137\x70\x72\x69\166\141\x74\x65\137\153\x65\171", get_option("\x6d\157\x5f\x73\x61\155\154\137\x63\x65\162\164\x5f\x70\162\151\166\141\x74\x65\x5f\x6b\x65\x79"));
        Xb:
        w9:
    }
    function mo_login_widget_saml_options()
    {
        global $wpdb;
        update_option("\x6d\x6f\137\x73\x61\x6d\154\137\150\x6f\163\x74\137\156\x61\x6d\x65", "\150\x74\x74\160\x73\72\57\57\x6c\157\x67\x69\156\x2e\x78\x65\143\165\x72\151\x66\x79\x2e\x63\157\155");
        $FI = get_option("\x6d\x6f\137\x73\141\x6d\x6c\137\150\x6f\163\164\x5f\156\141\x6d\x65");
        mo_register_saml_sso();
    }
    function mo_saml_check_openssl()
    {
        if (mo_saml_is_extension_installed("\x6f\160\x65\156\163\163\x6c")) {
            goto kf;
        }
        wp_die("\x50\x48\120\x20\157\160\x65\156\x73\x73\154\40\145\x78\x74\x65\156\x73\151\157\156\x20\x69\163\40\156\x6f\164\40\x69\x6e\163\164\141\154\x6c\145\144\40\157\162\40\144\151\x73\x61\142\x6c\x65\144\x2c\x70\x6c\145\x61\x73\x65\x20\x65\156\141\142\x6c\x65\x20\x69\x74\x20\x74\x6f\x20\141\x63\164\151\166\x61\x74\x65\x20\x74\150\x65\40\160\154\x75\147\x69\156\56");
        kf:
        add_option("\x41\x63\x74\151\x76\x61\x74\145\144\x5f\x50\154\x75\147\151\156", "\120\154\165\x67\151\156\55\x53\154\x75\x67");
    }
    function mo_saml_success_message()
    {
        $So = "\145\162\162\157\162";
        $AA = get_option("\x6d\x6f\x5f\163\x61\x6d\154\x5f\155\x65\x73\163\141\x67\x65");
        echo "\x3c\144\151\x76\x20\x63\154\141\x73\163\75\x27" . $So . "\x27\76\x20\74\160\x3e" . $AA . "\x3c\x2f\x70\x3e\x3c\x2f\144\x69\x76\x3e";
    }
    function mo_saml_error_message()
    {
        $So = "\165\x70\144\141\164\x65\144";
        $AA = get_option("\155\157\137\163\x61\x6d\154\137\155\145\163\x73\x61\147\x65");
        echo "\74\x64\x69\x76\x20\143\x6c\x61\x73\x73\75\x27" . $So . "\47\76\40\x3c\x70\76" . $AA . "\74\57\x70\76\x3c\57\144\x69\166\76";
    }
    public function mo_sso_saml_deactivate()
    {
        if (!is_multisite()) {
            goto Su;
        }
        global $wpdb;
        $dD = $wpdb->get_col("\x53\x45\x4c\105\103\124\40\x62\154\x6f\147\x5f\x69\x64\x20\x46\x52\117\x4d\40{$wpdb->blogs}");
        $x8 = get_current_blog_id();
        do_action("\x6d\157\x5f\x73\x61\x6d\x6c\x5f\146\154\165\163\150\137\143\141\x63\x68\x65");
        foreach ($dD as $blog_id) {
            switch_to_blog($blog_id);
            delete_option("\x6d\x6f\x5f\x73\x61\x6d\x6c\x5f\150\157\x73\x74\137\156\141\155\145");
            delete_option("\x6d\157\x5f\163\141\x6d\154\x5f\x6e\145\167\137\x72\145\x67\x69\x73\x74\x72\141\x74\x69\157\x6e");
            delete_option("\155\x6f\137\x73\x61\155\x6c\x5f\141\144\x6d\x69\x6e\x5f\x70\x68\x6f\x6e\145");
            delete_option("\155\157\137\163\141\155\154\x5f\141\144\x6d\x69\156\137\x70\x61\163\163\x77\x6f\x72\x64");
            delete_option("\x6d\x6f\137\x73\x61\155\x6c\x5f\166\145\x72\151\x66\171\x5f\143\x75\x73\164\x6f\x6d\x65\162");
            delete_option("\x6d\157\x5f\163\x61\x6d\x6c\x5f\141\144\x6d\x69\156\x5f\x63\x75\x73\x74\157\x6d\145\x72\137\x6b\145\x79");
            delete_option("\x6d\x6f\137\163\x61\155\154\137\x61\144\x6d\x69\156\137\141\160\x69\x5f\x6b\x65\171");
            delete_option("\x6d\157\137\x73\141\x6d\x6c\137\x63\x75\x73\x74\157\x6d\x65\x72\x5f\164\x6f\153\145\156");
            delete_option("\x6d\157\x5f\x73\x61\155\154\137\x6d\x65\163\163\x61\x67\145");
            delete_option("\155\x6f\137\163\x61\x6d\x6c\x5f\162\x65\147\x69\x73\x74\162\141\x74\151\157\156\x5f\163\x74\141\164\165\163");
            delete_option("\155\157\x5f\x73\x61\x6d\154\x5f\151\x64\x70\137\143\157\x6e\146\x69\147\137\x63\x6f\155\160\154\x65\164\145");
            delete_option("\x6d\x6f\137\x73\141\x6d\x6c\137\164\x72\141\156\x73\141\143\164\151\157\156\111\x64");
            delete_option("\x76\x6c\x5f\143\x68\145\143\x6b\x5f\x74");
            delete_option("\x76\x6c\x5f\143\150\145\x63\153\x5f\163");
            delete_option("\155\157\137\x73\141\155\154\137\x63\145\162\x74");
            delete_option("\155\x6f\137\x73\141\x6d\x6c\137\143\145\162\x74\137\x70\162\x69\166\141\164\x65\137\153\x65\171");
            delete_option("\155\x6f\x5f\163\x61\155\x6c\137\x65\x6e\x61\142\x6c\145\137\x63\154\157\x75\144\x5f\142\x72\157\x6b\145\162");
            El:
        }
        N0:
        switch_to_blog($x8);
        goto Av;
        Su:
        do_action("\155\157\x5f\163\x61\155\154\x5f\x66\x6c\165\x73\150\x5f\x63\x61\143\x68\145");
        delete_option("\x6d\x6f\137\163\141\x6d\154\x5f\150\x6f\x73\164\137\x6e\141\155\x65");
        delete_option("\x6d\157\137\163\x61\x6d\x6c\x5f\x6e\145\167\x5f\162\x65\147\x69\x73\x74\x72\x61\164\x69\x6f\156");
        delete_option("\x6d\157\x5f\163\x61\x6d\x6c\x5f\x61\144\155\x69\x6e\x5f\x70\150\157\156\145");
        delete_option("\155\x6f\137\x73\x61\x6d\x6c\137\141\144\x6d\x69\156\x5f\x70\141\163\163\x77\157\162\x64");
        delete_option("\x6d\x6f\137\163\x61\x6d\154\x5f\166\145\x72\151\146\171\137\x63\x75\163\x74\157\x6d\x65\x72");
        delete_option("\155\x6f\137\163\141\x6d\x6c\x5f\141\x64\155\151\156\x5f\143\x75\163\164\x6f\155\145\x72\137\153\x65\x79");
        delete_option("\x6d\157\137\x73\x61\155\x6c\x5f\x61\144\x6d\x69\156\x5f\141\x70\x69\137\x6b\145\x79");
        delete_option("\155\157\137\x73\141\x6d\x6c\x5f\143\x75\x73\x74\157\155\x65\x72\x5f\x74\x6f\153\x65\x6e");
        delete_option("\155\157\137\163\x61\x6d\154\x5f\x6d\x65\x73\163\141\x67\145");
        delete_option("\155\157\137\163\x61\155\154\x5f\162\145\147\x69\x73\164\x72\141\x74\151\x6f\156\x5f\x73\x74\x61\164\x75\163");
        delete_option("\155\x6f\x5f\163\141\x6d\154\x5f\151\144\160\137\x63\157\156\146\151\x67\137\143\x6f\155\x70\154\x65\x74\145");
        delete_option("\x6d\x6f\x5f\x73\x61\x6d\154\137\164\162\141\x6e\x73\141\x63\164\151\x6f\x6e\x49\x64");
        delete_option("\x76\x6c\x5f\143\x68\x65\x63\153\137\164");
        delete_option("\x76\x6c\x5f\143\x68\x65\143\153\x5f\163");
        delete_option("\x6d\x6f\x5f\163\x61\x6d\x6c\x5f\x63\145\x72\x74");
        delete_option("\155\x6f\137\x73\141\x6d\154\137\143\145\x72\164\x5f\x70\x72\x69\166\x61\x74\x65\x5f\153\145\x79");
        delete_option("\155\x6f\x5f\x73\141\x6d\x6c\x5f\145\x6e\141\x62\154\145\137\x63\154\x6f\x75\144\x5f\142\162\x6f\153\x65\162");
        Av:
    }
    function mo_saml_show_success_message()
    {
        remove_action("\141\x64\155\x69\156\x5f\156\157\x74\151\x63\x65\163", array($this, "\x6d\157\137\x73\141\x6d\x6c\137\163\x75\x63\143\x65\163\x73\137\x6d\x65\163\163\141\147\x65"));
        add_action("\141\144\155\151\x6e\137\x6e\157\x74\151\143\145\x73", array($this, "\155\x6f\137\163\141\x6d\154\137\x65\x72\x72\x6f\x72\x5f\155\x65\163\x73\x61\x67\x65"));
    }
    function mo_saml_show_error_message()
    {
        remove_action("\x61\144\155\151\156\x5f\156\x6f\164\151\x63\x65\163", array($this, "\155\x6f\137\163\x61\x6d\x6c\137\145\162\162\157\x72\x5f\x6d\145\163\x73\141\x67\x65"));
        add_action("\141\144\x6d\151\156\x5f\x6e\x6f\164\151\143\145\x73", array($this, "\155\x6f\137\x73\x61\155\x6c\x5f\x73\x75\x63\x63\x65\x73\163\x5f\x6d\145\x73\x73\141\x67\x65"));
    }
    function plugin_settings_style($Xz)
    {
        if (!("\x74\x6f\160\154\x65\166\145\154\x5f\x70\x61\147\145\137\155\x6f\x5f\x73\141\x6d\154\137\163\x65\164\x74\151\156\147\163" != $Xz)) {
            goto B5;
        }
        return;
        B5:
        if (!(isset($_REQUEST["\x74\x61\x62"]) && $_REQUEST["\x74\x61\142"] == "\x6c\x69\143\145\x6e\x73\151\156\x67")) {
            goto AT;
        }
        wp_enqueue_style("\155\x6f\137\163\x61\155\154\x5f\142\157\157\164\x73\x74\162\x61\160\137\143\163\163", plugins_url("\x69\x6e\143\154\165\144\x65\x73\x2f\x63\163\163\57\x62\157\x6f\164\x73\164\162\141\x70\57\x62\157\157\x74\163\164\x72\141\160\x2e\155\151\156\x2e\x63\163\x73", __FILE__), array(), mo_options_plugin_constants::Version, "\141\x6c\x6c");
        AT:
        wp_enqueue_style("\155\x6f\x5f\x73\x61\x6d\x6c\137\141\x64\x6d\x69\156\x5f\163\145\164\164\151\156\x67\163\x5f\163\x74\171\154\x65\137\x74\x72\x61\143\x6b\145\162", plugins_url("\151\156\x63\154\x75\x64\x65\x73\x2f\x63\x73\x73\x2f\x70\162\157\x67\162\x65\163\163\55\164\162\141\143\153\145\162\x2e\x63\163\163", __FILE__), array(), mo_options_plugin_constants::Version, "\x61\154\x6c");
        wp_enqueue_style("\155\x6f\x5f\163\141\155\x6c\137\x61\x64\155\151\x6e\x5f\x73\x65\x74\x74\151\x6e\147\163\137\x73\164\171\154\145", plugins_url("\151\x6e\x63\154\x75\x64\145\163\x2f\x63\163\x73\57\163\164\x79\154\145\137\163\145\x74\164\151\156\x67\163\x2e\155\151\156\x2e\x63\x73\163", __FILE__), array(), mo_options_plugin_constants::Version, "\141\x6c\154");
        wp_enqueue_style("\x6d\157\x5f\163\141\155\x6c\x5f\141\x64\x6d\151\x6e\x5f\x73\145\x74\x74\x69\156\147\163\137\160\x68\x6f\x6e\x65\137\163\x74\171\154\145", plugins_url("\151\x6e\x63\154\x75\x64\x65\x73\x2f\143\x73\163\x2f\160\x68\x6f\156\x65\x2e\155\x69\156\56\x63\163\x73", __FILE__), array(), mo_options_plugin_constants::Version, "\141\x6c\154");
        wp_enqueue_style("\x6d\157\137\163\x61\x6d\x6c\x5f\x77\x70\142\x2d\x66\x61", plugins_url("\151\x6e\143\x6c\165\144\x65\x73\x2f\143\163\163\x2f\146\x6f\x6e\164\x2d\x61\x77\145\163\x6f\155\145\x2e\x6d\151\x6e\56\143\163\163", __FILE__), array(), mo_options_plugin_constants::Version, "\x61\x6c\154");
    }
    function plugin_settings_script($Xz)
    {
        if (!("\164\157\160\154\145\x76\x65\154\137\160\141\147\145\137\x6d\x6f\x5f\x73\141\x6d\154\137\x73\145\164\x74\151\156\147\163" != $Xz)) {
            goto wJ;
        }
        return;
        wJ:
        wp_enqueue_script("\x6a\161\165\x65\162\171");
        wp_enqueue_script("\x6d\x6f\x5f\163\141\155\x6c\137\141\x64\x6d\x69\x6e\x5f\142\157\x6f\x74\x73\x74\x72\x61\x70\x5f\x73\143\162\151\160\164", plugins_url("\x69\156\143\x6c\165\144\x65\163\x2f\152\x73\57\x62\x6f\157\164\163\164\162\141\160\56\152\163", __FILE__), array(), mo_options_plugin_constants::Version, false);
        wp_enqueue_script("\x6d\x6f\137\163\x61\x6d\x6c\137\x61\144\155\x69\156\x5f\x73\145\x74\164\151\x6e\147\163\x5f\163\143\162\151\x70\x74", plugins_url("\x69\156\x63\154\x75\144\145\163\57\152\163\x2f\x73\x65\164\x74\x69\156\147\x73\x2e\x6d\151\x6e\x2e\152\163", __FILE__), array(), mo_options_plugin_constants::Version, false);
        wp_enqueue_script("\155\x6f\137\x73\x61\155\x6c\x5f\x61\144\155\x69\156\137\x73\x65\x74\x74\x69\x6e\x67\163\x5f\160\x68\x6f\156\x65\x5f\163\x63\x72\x69\160\164", plugins_url("\x69\x6e\143\x6c\165\x64\145\163\x2f\152\x73\x2f\160\150\157\156\x65\56\x6d\x69\x6e\x2e\152\163", __FILE__), array(), mo_options_plugin_constants::Version, false);
        if (!(isset($_REQUEST["\x74\141\x62"]) && $_REQUEST["\x74\141\142"] == "\x6c\151\x63\x65\x6e\163\x69\x6e\x67")) {
            goto oK;
        }
        wp_enqueue_script("\x6d\157\137\163\141\x6d\154\x5f\155\x6f\144\145\162\x6e\x69\172\x72\x5f\163\x63\x72\x69\160\x74", plugins_url("\151\x6e\143\154\x75\144\x65\163\57\x6a\163\x2f\155\157\144\145\x72\156\x69\x7a\x72\56\x6a\163", __FILE__), array(), mo_options_plugin_constants::Version, false);
        wp_enqueue_script("\x6d\x6f\x5f\163\x61\155\x6c\x5f\160\157\x70\x6f\166\145\x72\137\163\x63\162\151\x70\164", plugins_url("\x69\x6e\x63\154\165\x64\x65\x73\x2f\152\x73\57\x62\157\157\164\163\164\x72\141\160\57\x70\x6f\x70\x70\145\x72\x2e\155\151\156\x2e\152\163", __FILE__), array(), mo_options_plugin_constants::Version, false);
        wp_enqueue_script("\155\x6f\x5f\x73\x61\155\154\x5f\x62\157\157\164\163\164\162\141\x70\137\x73\143\162\x69\x70\164", plugins_url("\151\x6e\x63\154\x75\144\x65\163\57\152\x73\57\x62\157\157\164\x73\x74\162\x61\x70\x2f\x62\x6f\157\x74\x73\x74\162\x61\x70\x2e\155\x69\156\x2e\x6a\163", __FILE__), array(), mo_options_plugin_constants::Version, false);
        oK:
    }
    function mo_saml_activation_message()
    {
        $So = "\x75\160\144\141\164\x65\x64";
        $AA = get_option("\155\x6f\137\163\141\155\x6c\x5f\155\145\x73\x73\141\x67\x65");
        echo "\74\144\x69\x76\x20\x63\154\141\163\163\x3d\x27" . $So . "\x27\x3e\x20\74\160\x3e" . $AA . "\74\57\160\x3e\74\57\x64\x69\x76\x3e";
    }
    static function mo_check_option_admin_referer($ip)
    {
        return isset($_POST["\x6f\x70\164\151\x6f\x6e"]) and $_POST["\x6f\x70\164\151\157\156"] == $ip and check_admin_referer($ip);
    }
    function miniorange_login_widget_saml_save_settings()
    {
        if (!current_user_can("\155\141\156\x61\x67\145\137\x6f\160\x74\151\x6f\156\x73")) {
            goto S5;
        }
        if (!(is_admin() && get_option("\x41\143\x74\151\166\141\x74\145\144\x5f\120\x6c\165\x67\x69\x6e") == "\120\154\x75\147\x69\156\x2d\123\154\x75\147")) {
            goto ub;
        }
        delete_option("\101\143\x74\x69\166\141\164\x65\x64\x5f\x50\154\165\x67\x69\156");
        update_option("\x6d\157\137\x73\141\155\154\137\155\x65\163\x73\x61\147\145", "\x47\157\x20\x74\x6f\40\x70\x6c\165\147\x69\156\40\74\142\x3e\74\x61\40\x68\x72\145\x66\x3d\x22\141\x64\155\151\156\56\160\x68\x70\x3f\x70\x61\147\x65\x3d\155\157\137\x73\141\155\154\137\x73\145\164\164\151\156\x67\163\x22\x3e\163\145\x74\164\x69\x6e\x67\163\x3c\57\141\x3e\74\57\142\x3e\40\x74\157\40\x63\x6f\156\146\151\147\x75\162\145\40\x53\x41\x4d\x4c\40\x53\151\x6e\147\x6c\x65\40\123\151\147\x6e\x20\117\x6e\40\142\171\x20\155\151\x6e\151\x4f\162\141\x6e\147\x65\x2e");
        add_action("\x61\144\155\151\x6e\137\156\157\164\x69\x63\x65\163", array($this, "\155\157\137\163\x61\155\154\x5f\141\143\x74\151\166\x61\164\x69\157\x6e\137\x6d\145\x73\x73\x61\147\x65"));
        ub:
        if (!self::mo_check_option_admin_referer("\154\157\147\151\156\137\x77\151\144\147\x65\x74\x5f\163\141\x6d\154\137\163\x61\x76\x65\137\163\x65\x74\164\151\156\x67\163")) {
            goto PX;
        }
        if (mo_saml_is_extension_installed("\143\x75\162\154")) {
            goto dK;
        }
        update_option("\x6d\157\137\163\141\155\154\137\155\x65\x73\x73\x61\x67\x65", "\x45\x52\122\x4f\x52\72\x50\110\120\x20\x63\x55\x52\114\40\x65\170\x74\145\x6e\x73\151\x6f\156\x20\x69\163\x20\x6e\157\164\40\151\156\163\164\141\154\x6c\145\144\40\x6f\162\x20\144\x69\x73\x61\142\154\145\144\x2e\40\x53\x61\x76\145\40\111\144\145\x6e\x74\151\x74\171\40\120\x72\x6f\166\151\x64\x65\162\x20\x43\x6f\x6e\x66\x69\x67\165\x72\141\164\x69\x6f\x6e\40\x66\x61\x69\x6c\x65\x64\x2e");
        $this->mo_saml_show_error_message();
        return;
        dK:
        $Ov = '';
        $nJ = '';
        $yK = '';
        $xM = '';
        $Ss = '';
        $xQ = '';
        $tV = '';
        $Pm = '';
        if ($this->mo_saml_check_empty_or_null($_POST["\x73\141\x6d\x6c\x5f\x69\x64\x65\156\x74\151\164\x79\137\x6e\141\x6d\145"]) || $this->mo_saml_check_empty_or_null($_POST["\x73\141\x6d\154\x5f\x6c\157\147\x69\156\137\165\x72\x6c"]) || $this->mo_saml_check_empty_or_null($_POST["\x73\141\x6d\154\137\151\163\163\165\x65\x72"]) || $this->mo_saml_check_empty_or_null($_POST["\x73\141\x6d\x6c\137\156\141\x6d\x65\x69\144\x5f\146\157\162\155\141\x74"])) {
            goto di;
        }
        if (!preg_match("\57\x5e\134\167\52\x24\57", $_POST["\163\141\155\154\x5f\x69\x64\x65\x6e\164\151\x74\171\137\156\x61\x6d\145"])) {
            goto Dd;
        }
        $Ov = htmlspecialchars(trim($_POST["\163\x61\155\154\x5f\151\144\x65\x6e\164\151\164\x79\x5f\156\141\155\x65"]));
        $yK = htmlspecialchars(trim($_POST["\163\x61\155\x6c\137\x6c\x6f\x67\x69\x6e\x5f\165\162\154"]));
        if (!array_key_exists("\163\x61\x6d\154\137\x6c\157\x67\x69\x6e\137\142\151\156\144\151\x6e\147\x5f\x74\x79\160\x65", $_POST)) {
            goto Zn;
        }
        $nJ = htmlspecialchars($_POST["\163\x61\x6d\154\x5f\x6c\157\147\x69\x6e\137\x62\151\156\x64\151\156\147\x5f\x74\171\160\145"]);
        Zn:
        $xQ = htmlspecialchars(trim($_POST["\163\141\155\x6c\x5f\151\163\x73\x75\x65\162"]));
        $De = htmlspecialchars(trim($_POST["\x73\141\155\154\x5f\151\144\x65\x6e\164\151\164\171\137\x70\162\157\166\x69\x64\145\x72\137\x67\165\151\x64\x65\x5f\156\x61\x6d\x65"]));
        $tV = $_POST["\163\x61\x6d\x6c\x5f\170\65\x30\71\x5f\143\145\162\x74\151\x66\151\143\141\x74\x65"];
        $Ss = htmlspecialchars($_POST["\x73\x61\x6d\154\137\x6e\x61\155\145\x69\x64\137\x66\x6f\x72\155\141\x74"]);
        goto fY;
        Dd:
        update_option("\x6d\x6f\x5f\x73\x61\x6d\154\x5f\155\145\x73\x73\x61\147\x65", "\120\154\x65\141\163\x65\x20\x6d\x61\164\x63\150\40\164\x68\x65\40\162\145\161\x75\x65\x73\x74\x65\144\x20\146\x6f\162\x6d\x61\x74\x20\x66\x6f\x72\40\111\144\x65\156\x74\151\x74\171\40\x50\x72\157\166\151\x64\145\162\40\116\x61\155\x65\56\40\117\x6e\154\171\x20\x61\x6c\160\x68\141\x62\x65\x74\x73\x2c\x20\156\165\155\142\145\x72\x73\40\x61\156\x64\x20\165\x6e\x64\145\x72\x73\143\x6f\162\x65\x20\x69\163\40\x61\154\x6c\157\x77\x65\x64\56");
        $this->mo_saml_show_error_message();
        return;
        fY:
        goto sS;
        di:
        update_option("\x6d\157\137\x73\141\155\x6c\x5f\x6d\145\x73\163\x61\x67\x65", "\101\154\x6c\x20\x74\x68\x65\40\x66\151\x65\154\144\163\x20\141\162\145\x20\162\x65\x71\165\x69\x72\x65\x64\x2e\x20\x50\x6c\x65\141\163\x65\40\145\156\x74\145\x72\x20\x76\x61\x6c\151\144\x20\145\x6e\164\x72\151\x65\x73\x2e");
        $this->mo_saml_show_error_message();
        return;
        sS:
        update_option("\x73\141\155\154\137\151\144\x65\x6e\164\x69\164\x79\x5f\156\x61\x6d\x65", $Ov);
        update_option("\163\x61\x6d\x6c\137\154\157\x67\x69\156\137\x62\x69\x6e\144\x69\x6e\147\x5f\164\171\160\x65", $nJ);
        update_option("\163\x61\x6d\154\137\154\x6f\147\151\x6e\x5f\x75\162\154", $yK);
        update_option("\x73\x61\x6d\x6c\137\x6c\157\147\157\x75\x74\x5f\142\151\x6e\144\151\x6e\x67\x5f\x74\x79\160\x65", $xM);
        update_option("\x73\141\x6d\154\x5f\151\163\x73\165\145\162", $xQ);
        update_option("\x73\x61\x6d\154\137\156\x61\155\x65\x69\x64\137\x66\157\x72\155\141\164", $Ss);
        update_option("\163\141\x6d\x6c\x5f\151\144\x65\156\x74\151\x74\x79\x5f\x70\x72\157\166\x69\x64\x65\162\137\147\x75\151\x64\x65\137\x6e\141\155\145", $De);
        if (isset($_POST["\x73\x61\x6d\154\137\x72\145\161\165\x65\x73\164\x5f\163\x69\x67\x6e\x65\x64"])) {
            goto UI;
        }
        update_option("\x73\141\155\154\x5f\x72\x65\x71\165\145\x73\x74\x5f\x73\151\x67\156\145\144", "\165\156\143\150\x65\143\153\x65\144");
        goto mc;
        UI:
        update_option("\163\x61\155\154\137\x72\145\x71\x75\x65\x73\164\137\163\151\x67\156\145\x64", "\143\150\145\143\x6b\x65\144");
        mc:
        foreach ($tV as $uZ => $Ka) {
            if (empty($Ka)) {
                goto lt;
            }
            $tV[$uZ] = SAMLSPUtilities::sanitize_certificate($Ka);
            if (@openssl_x509_read($tV[$uZ])) {
                goto uL;
            }
            update_option("\155\157\x5f\x73\141\x6d\154\x5f\155\145\x73\x73\141\147\x65", "\x49\156\x76\x61\154\x69\144\40\143\145\x72\164\151\146\151\143\141\164\x65\72\x20\x50\154\x65\141\x73\x65\40\x70\162\x6f\x76\x69\x64\145\x20\141\x20\x76\141\154\x69\144\x20\x63\145\x72\164\x69\x66\151\143\141\x74\x65\56");
            $this->mo_saml_show_error_message();
            delete_option("\x73\x61\155\154\x5f\x78\x35\x30\x39\x5f\x63\x65\162\164\151\x66\x69\143\x61\x74\145");
            return;
            uL:
            goto K1;
            lt:
            unset($tV[$uZ]);
            K1:
            HG:
        }
        T4:
        if (!empty($tV)) {
            goto eR;
        }
        update_option("\x6d\157\x5f\163\x61\155\x6c\137\155\145\x73\x73\x61\x67\145", "\x49\156\166\x61\154\151\144\40\103\145\162\x74\151\146\x69\x63\141\x74\x65\72\x50\x6c\145\141\163\145\40\160\162\157\x76\x69\144\x65\x20\x61\x20\x63\145\x72\x74\151\146\x69\143\x61\x74\x65");
        $this->mo_saml_show_error_message();
        return;
        eR:
        update_option("\163\x61\x6d\154\x5f\170\65\x30\x39\x5f\143\x65\162\x74\151\146\151\143\x61\164\x65", maybe_serialize($tV));
        if (isset($_POST["\x73\141\155\x6c\137\162\145\x73\160\157\156\163\x65\x5f\x73\151\x67\x6e\145\x64"])) {
            goto NN;
        }
        update_option("\x73\141\x6d\x6c\137\x72\x65\163\160\x6f\156\x73\145\137\163\151\147\x6e\145\144", "\131\x65\163");
        goto gG;
        NN:
        update_option("\163\x61\155\x6c\x5f\162\x65\x73\x70\x6f\x6e\x73\145\x5f\x73\151\x67\x6e\x65\x64", "\x63\150\145\143\153\x65\x64");
        gG:
        if (isset($_POST["\163\141\155\154\137\141\x73\163\145\x72\x74\151\x6f\x6e\137\x73\151\x67\156\145\144"])) {
            goto B0;
        }
        update_option("\x73\x61\x6d\154\137\141\x73\163\145\x72\x74\x69\x6f\x6e\x5f\163\151\x67\x6e\145\144", "\x59\145\x73");
        goto Kz;
        B0:
        update_option("\x73\141\x6d\154\137\141\x73\x73\145\x72\164\x69\x6f\x6e\x5f\x73\x69\147\156\145\x64", "\143\150\145\143\x6b\145\144");
        Kz:
        if (array_key_exists("\x65\156\141\x62\154\145\137\151\143\x6f\156\x76", $_POST)) {
            goto ib;
        }
        update_option("\x6d\157\x5f\x73\x61\x6d\154\137\x65\156\143\157\x64\x69\x6e\147\137\145\x6e\x61\x62\154\x65\144", '');
        goto my;
        ib:
        update_option("\155\x6f\137\163\x61\x6d\154\137\x65\x6e\x63\157\144\151\x6e\147\137\x65\x6e\141\142\154\145\x64", "\143\x68\145\x63\153\145\144");
        my:
        update_option("\x6d\157\x5f\163\x61\x6d\154\137\x6d\145\x73\x73\x61\x67\145", "\111\144\x65\x6e\164\x69\x74\x79\x20\120\x72\157\166\x69\144\145\162\40\x64\145\164\x61\x69\154\x73\x20\163\x61\x76\145\x64\40\x73\x75\x63\143\x65\163\x73\146\165\154\154\171\56");
        $this->mo_saml_show_success_message();
        PX:
        if (!self::mo_check_option_admin_referer("\x6c\157\x67\151\156\137\x77\x69\144\147\145\x74\x5f\163\x61\x6d\x6c\137\x61\164\164\x72\x69\x62\x75\x74\145\137\155\x61\160\160\151\156\x67")) {
            goto Kf;
        }
        if (mo_saml_is_extension_installed("\143\x75\x72\154")) {
            goto W3;
        }
        update_option("\x6d\157\137\163\141\x6d\x6c\x5f\x6d\x65\163\x73\141\x67\145", "\105\122\x52\x4f\122\72\x50\110\x50\x20\x63\x55\122\x4c\40\145\x78\164\145\156\x73\x69\157\156\x20\x69\x73\40\x6e\157\x74\40\x69\x6e\163\164\141\x6c\154\145\x64\40\x6f\162\40\x64\151\x73\x61\x62\154\x65\144\56\x20\x53\141\x76\x65\x20\101\164\x74\162\x69\x62\x75\x74\145\40\x4d\x61\x70\160\x69\x6e\147\x20\x66\x61\151\x6c\x65\144\56");
        $this->mo_saml_show_error_message();
        return;
        W3:
        update_option("\163\141\x6d\154\x5f\x61\x6d\137\x75\x73\145\162\156\x61\155\145", htmlspecialchars(stripslashes($_POST["\x73\141\x6d\x6c\137\x61\x6d\x5f\x75\x73\x65\x72\x6e\x61\x6d\x65"])));
        update_option("\163\x61\x6d\154\137\x61\155\x5f\x65\x6d\x61\151\154", htmlspecialchars(stripslashes($_POST["\163\141\x6d\x6c\137\x61\155\137\145\155\x61\x69\154"])));
        update_option("\163\141\x6d\x6c\137\x61\x6d\137\146\151\162\x73\164\137\x6e\141\155\x65", htmlspecialchars(stripslashes($_POST["\163\141\x6d\x6c\x5f\x61\155\x5f\x66\x69\162\163\164\x5f\x6e\141\155\145"])));
        update_option("\163\x61\155\154\137\x61\x6d\x5f\x6c\x61\x73\x74\x5f\x6e\141\x6d\x65", htmlspecialchars(stripslashes($_POST["\163\x61\x6d\154\x5f\x61\x6d\x5f\x6c\141\163\164\137\x6e\x61\x6d\145"])));
        update_option("\x73\x61\155\154\x5f\x61\155\x5f\x64\151\x73\x70\154\141\x79\137\x6e\x61\x6d\x65", htmlspecialchars(stripslashes($_POST["\x73\141\x6d\x6c\137\x61\x6d\137\x64\x69\x73\x70\154\x61\x79\137\156\141\155\145"])));
        update_option("\155\x6f\137\x73\x61\x6d\154\x5f\x6d\x65\163\x73\x61\147\145", "\x41\164\x74\162\151\142\165\x74\145\x20\x4d\x61\x70\x70\x69\156\x67\x20\144\x65\x74\x61\x69\x6c\x73\x20\x73\x61\166\x65\144\x20\x73\x75\x63\x63\x65\x73\x73\x66\x75\x6c\x6c\171");
        $this->mo_saml_show_success_message();
        Kf:
        if (!self::mo_check_option_admin_referer("\x63\x6c\145\x61\x72\137\x61\x74\164\x72\x73\x5f\154\x69\x73\164")) {
            goto qm;
        }
        delete_option("\x6d\x6f\x5f\163\141\155\154\137\x74\145\x73\x74\x5f\143\157\x6e\146\x69\147\x5f\141\164\x74\x72\163");
        update_option("\155\x6f\x5f\x73\x61\155\x6c\137\155\145\163\163\141\147\x65", "\101\164\164\162\151\142\165\164\145\163\40\x6c\x69\163\x74\40\x72\x65\x6d\x6f\x76\145\x64\x20\163\165\143\x63\145\163\x73\x66\x75\154\154\171");
        $this->mo_saml_show_success_message();
        qm:
        if (!self::mo_check_option_admin_referer("\x6c\x6f\147\x69\x6e\137\x77\151\x64\147\145\x74\137\163\141\x6d\x6c\137\162\x6f\x6c\145\x5f\x6d\x61\x70\160\151\x6e\x67")) {
            goto m_;
        }
        if (mo_saml_is_extension_installed("\143\x75\x72\154")) {
            goto dO1;
        }
        update_option("\x6d\157\137\x73\x61\x6d\154\x5f\155\x65\163\x73\141\147\145", "\x45\x52\x52\117\122\72\120\x48\x50\40\143\x55\x52\x4c\40\145\170\x74\145\156\x73\151\x6f\156\40\151\x73\x20\156\x6f\164\x20\x69\156\x73\x74\141\x6c\x6c\x65\144\x20\157\x72\x20\144\151\163\x61\142\x6c\145\144\x2e\x20\123\141\x76\145\40\x52\x6f\x6c\x65\x20\115\141\x70\160\x69\156\x67\x20\x66\141\151\x6c\x65\x64\x2e");
        $this->mo_saml_show_error_message();
        return;
        dO1:
        if (isset($_POST["\155\x6f\137\163\141\x6d\154\137\x64\x6f\x6e\164\x5f\165\x70\x64\x61\164\x65\137\x65\170\x69\163\164\151\156\147\x5f\x75\163\x65\x72\x5f\x72\x6f\x6c\145"])) {
            goto uy;
        }
        update_option("\163\141\x6d\154\x5f\x61\x6d\137\x64\x6f\156\164\137\x75\160\x64\x61\x74\x65\x5f\145\x78\151\163\x74\151\156\147\137\165\x73\145\x72\x5f\162\157\x6c\145", "\x75\x6e\143\150\145\143\x6b\x65\x64");
        goto yj;
        uy:
        update_option("\x73\x61\x6d\x6c\x5f\141\155\x5f\x64\157\156\164\137\165\x70\144\x61\164\145\137\x65\x78\x69\x73\164\x69\156\147\137\165\x73\x65\x72\x5f\162\157\x6c\145", "\143\x68\145\x63\x6b\x65\x64");
        yj:
        if (!isset($_POST["\163\x61\155\x6c\137\x61\155\137\144\145\x66\x61\165\x6c\x74\x5f\x75\163\145\162\x5f\x72\157\154\145"])) {
            goto yS;
        }
        $A4 = htmlspecialchars($_POST["\163\x61\x6d\x6c\137\141\155\137\144\145\146\x61\165\154\164\x5f\165\x73\145\162\x5f\162\157\x6c\145"]);
        update_option("\163\141\155\x6c\x5f\x61\x6d\137\x64\145\146\141\165\x6c\164\137\x75\163\145\x72\137\x72\x6f\154\145", $A4);
        yS:
        update_option("\155\157\137\x73\x61\x6d\154\137\x6d\145\x73\x73\x61\147\x65", "\122\157\154\x65\x20\x4d\141\160\x70\x69\x6e\147\40\x64\145\164\141\x69\x6c\163\40\163\141\166\x65\x64\x20\163\165\x63\x63\145\163\x73\x66\x75\x6c\x6c\171\56");
        $this->mo_saml_show_success_message();
        m_:
        if (!self::mo_check_option_admin_referer("\x6d\157\137\x73\141\x6d\x6c\137\165\160\144\x61\x74\x65\x5f\x69\144\x70\x5f\163\145\x74\x74\x69\156\147\163\137\157\x70\x74\x69\157\156")) {
            goto H8;
        }
        if (!(isset($_POST["\155\157\x5f\163\141\x6d\154\x5f\x73\x70\137\142\141\163\145\x5f\x75\x72\154"]) && isset($_POST["\x6d\157\x5f\x73\141\x6d\154\x5f\163\x70\137\145\x6e\164\151\164\x79\137\151\x64"]))) {
            goto PE;
        }
        $Ko = sanitize_text_field($_POST["\x6d\x6f\137\163\141\155\154\x5f\x73\x70\x5f\x62\141\163\x65\137\165\162\x6c"]);
        $Eq = sanitize_text_field($_POST["\155\x6f\x5f\x73\x61\155\x6c\137\163\160\x5f\145\x6e\x74\x69\164\x79\x5f\151\x64"]);
        if (!(substr($Ko, -1) == "\x2f")) {
            goto yF;
        }
        $Ko = substr($Ko, 0, -1);
        yF:
        update_option("\155\157\137\163\141\155\154\x5f\x73\x70\x5f\x62\141\x73\x65\137\x75\x72\x6c", $Ko);
        update_option("\155\157\x5f\x73\141\x6d\x6c\x5f\x73\x70\x5f\145\156\164\x69\164\171\x5f\151\144", $Eq);
        PE:
        update_option("\155\x6f\x5f\163\141\x6d\x6c\x5f\155\145\163\x73\x61\147\x65", "\123\x65\164\164\151\x6e\x67\x73\40\x75\x70\x64\141\164\x65\144\40\x73\165\143\x63\x65\163\x73\146\165\154\x6c\x79\x2e");
        $this->mo_saml_show_success_message();
        H8:
        if (!self::mo_check_option_admin_referer("\x73\x61\155\154\x5f\165\160\154\x6f\x61\144\137\x6d\145\164\141\144\x61\x74\141")) {
            goto iO;
        }
        if (function_exists("\167\160\x5f\150\141\156\144\x6c\145\x5f\x75\160\154\157\x61\144")) {
            goto lL;
        }
        require_once ABSPATH . "\x77\160\x2d\141\x64\x6d\151\156\x2f\x69\156\x63\x6c\165\144\145\x73\57\x66\151\x6c\145\x2e\x70\x68\x70";
        lL:
        $this->_handle_upload_metadata();
        iO:
        if (!self::mo_check_option_admin_referer("\165\160\x67\162\141\144\145\x5f\x63\145\x72\x74")) {
            goto jL;
        }
        $eV = file_get_contents(plugin_dir_path(__FILE__) . "\162\x65\163\x6f\165\x72\143\145\x73" . DIRECTORY_SEPARATOR . "\155\x69\156\151\x6f\x72\141\x6e\147\145\137\163\160\137\x32\60\62\x30\x2e\143\162\164");
        $Dy = file_get_contents(plugin_dir_path(__FILE__) . "\x72\145\163\x6f\165\162\143\145\x73" . DIRECTORY_SEPARATOR . "\x6d\151\x6e\151\157\162\x61\156\147\145\137\163\160\137\x32\60\62\60\x5f\160\162\151\x76\x2e\153\145\x79");
        update_option("\155\x6f\x5f\x73\141\155\154\137\143\165\162\162\145\x6e\164\137\x63\x65\x72\x74", $eV);
        update_option("\155\x6f\137\x73\x61\155\154\x5f\x63\x75\x72\x72\145\x6e\164\137\143\x65\162\164\137\160\x72\151\166\141\164\145\x5f\153\145\x79", $Dy);
        update_option("\x6d\157\x5f\163\x61\155\x6c\x5f\143\x65\162\x74\x69\146\151\x63\141\164\145\137\x72\157\x6c\x6c\137\x62\x61\x63\x6b\137\141\166\x61\x69\154\x61\x62\x6c\x65", true);
        update_option("\155\x6f\137\x73\141\x6d\x6c\x5f\x6d\x65\163\x73\x61\x67\145", "\x43\x65\x72\x74\x69\x66\x69\143\141\164\x65\40\125\x70\x67\162\x61\144\x65\144\40\163\x75\x63\143\x65\163\x73\146\x75\x6c\x6c\171");
        $this->mo_saml_show_success_message();
        jL:
        if (!self::mo_check_option_admin_referer("\x72\x6f\154\154\x62\141\x63\x6b\x5f\x63\145\162\x74")) {
            goto IO;
        }
        $eV = file_get_contents(plugin_dir_path(__FILE__) . "\x72\x65\x73\x6f\165\162\x63\145\x73" . DIRECTORY_SEPARATOR . "\163\160\55\x63\145\x72\164\151\x66\x69\143\x61\164\145\56\143\162\x74");
        $Dy = file_get_contents(plugin_dir_path(__FILE__) . "\x72\145\x73\x6f\165\x72\143\145\x73" . DIRECTORY_SEPARATOR . "\163\x70\x2d\153\145\171\x2e\x6b\145\171");
        update_option("\155\157\x5f\163\141\155\154\137\143\165\162\162\145\x6e\164\137\143\145\162\x74", $eV);
        update_option("\155\157\137\163\x61\x6d\154\x5f\x63\165\x72\162\145\156\x74\137\x63\145\x72\164\137\160\162\x69\x76\x61\x74\145\137\x6b\x65\171", $Dy);
        update_option("\155\157\137\163\141\x6d\x6c\x5f\155\x65\x73\x73\x61\x67\145", "\x43\145\x72\x74\151\x66\x69\143\x61\164\145\40\x52\x6f\x6c\x6c\x2d\142\141\143\153\145\x64\x20\163\165\x63\143\x65\x73\163\146\x75\x6c\154\x79");
        delete_option("\155\157\x5f\163\141\155\x6c\x5f\143\145\162\164\x69\x66\151\x63\x61\x74\145\x5f\162\157\154\x6c\x5f\142\x61\x63\153\137\x61\x76\141\151\154\141\x62\154\145");
        $this->mo_saml_show_success_message();
        IO:
        if (!self::mo_check_option_admin_referer("\x6d\x6f\137\x73\141\x6d\x6c\137\162\145\154\x61\x79\137\163\164\141\x74\x65\137\x6f\160\164\151\157\156")) {
            goto Hu;
        }
        $ml = sanitize_text_field($_POST["\x6d\157\137\x73\x61\155\x6c\137\x72\145\x6c\x61\x79\x5f\x73\x74\141\x74\145"]);
        update_option("\x6d\x6f\137\x73\141\x6d\154\137\162\x65\154\x61\171\x5f\163\164\141\x74\x65", $ml);
        update_option("\155\157\x5f\x73\141\155\x6c\137\x6d\145\163\163\141\x67\145", "\123\x53\x4f\x20\160\141\147\145\40\x75\x70\144\141\x74\x65\x64\40\x73\165\x63\143\145\x73\x73\x66\x75\x6c\154\171\x2e");
        $this->mo_saml_show_success_message();
        Hu:
        if (!self::mo_check_option_admin_referer("\x6d\x6f\x5f\163\141\x6d\x6c\x5f\167\151\x64\147\x65\164\137\157\160\x74\151\157\x6e")) {
            goto zf;
        }
        $UK = sanitize_text_field($_POST["\x6d\x6f\137\163\x61\155\154\x5f\143\x75\163\164\157\x6d\x5f\154\157\x67\151\x6e\137\164\145\170\x74"]);
        update_option("\x6d\x6f\137\x73\x61\155\154\x5f\143\165\x73\164\x6f\x6d\137\x6c\x6f\x67\151\156\x5f\x74\x65\170\x74", stripcslashes($UK));
        $Oc = sanitize_text_field($_POST["\155\157\x5f\x73\x61\155\154\137\x63\x75\163\164\x6f\155\x5f\x67\x72\145\145\x74\151\x6e\147\x5f\x74\x65\x78\x74"]);
        update_option("\x6d\157\x5f\163\x61\155\154\x5f\143\x75\163\x74\157\155\x5f\147\162\x65\x65\164\x69\x6e\147\x5f\x74\x65\x78\164", stripcslashes($Oc));
        $xl = sanitize_text_field($_POST["\155\157\x5f\163\x61\x6d\154\137\147\162\145\145\x74\x69\156\x67\137\156\x61\x6d\x65"]);
        update_option("\x6d\157\x5f\163\x61\x6d\154\137\x67\x72\145\x65\x74\x69\156\x67\137\156\x61\155\x65", stripcslashes($xl));
        $oY = sanitize_text_field($_POST["\155\x6f\x5f\x73\141\x6d\x6c\137\x63\x75\163\x74\157\x6d\137\x6c\157\x67\157\x75\x74\x5f\x74\145\x78\x74"]);
        update_option("\x6d\x6f\137\163\x61\155\x6c\x5f\x63\x75\x73\x74\x6f\155\x5f\154\x6f\147\157\x75\x74\137\x74\x65\170\x74", stripcslashes($oY));
        update_option("\x6d\157\137\x73\141\155\x6c\x5f\x6d\145\163\163\141\x67\145", "\x57\151\x64\147\145\x74\40\123\145\164\164\x69\x6e\x67\x73\x20\165\160\x64\141\x74\x65\x64\x20\x73\x75\x63\143\145\163\163\146\165\154\154\x79\x2e");
        $this->mo_saml_show_success_message();
        zf:
        if (!self::mo_check_option_admin_referer("\155\x6f\x5f\163\141\x6d\x6c\x5f\x72\x65\x67\x69\163\164\145\162\x5f\x63\165\163\x74\x6f\x6d\x65\162")) {
            goto WP;
        }
        if (mo_saml_is_extension_installed("\143\x75\162\154")) {
            goto wj;
        }
        update_option("\155\157\x5f\163\141\x6d\x6c\137\x6d\x65\x73\163\x61\x67\145", "\x45\122\122\117\122\72\40\x50\x48\120\x20\x63\x55\x52\x4c\40\145\170\164\x65\156\163\151\x6f\156\40\151\163\x20\x6e\x6f\x74\40\x69\x6e\163\164\x61\x6c\x6c\145\144\x20\x6f\x72\40\144\151\163\x61\x62\x6c\145\144\x2e\x20\x52\145\x67\x69\x73\164\x72\x61\164\151\x6f\x6e\x20\146\141\151\x6c\x65\144\x2e");
        $this->mo_saml_show_error_message();
        return;
        wj:
        $bz = '';
        $VP = '';
        $Sc = '';
        $Q8 = '';
        if ($this->mo_saml_check_empty_or_null($_POST["\145\x6d\x61\151\x6c"]) || $this->mo_saml_check_empty_or_null($_POST["\x70\141\x73\x73\x77\x6f\x72\144"]) || $this->mo_saml_check_empty_or_null($_POST["\143\157\156\x66\151\x72\x6d\x50\141\163\163\x77\x6f\x72\x64"])) {
            goto w6;
        }
        if (strlen($_POST["\x70\x61\163\163\167\157\x72\x64"]) < 6 || strlen($_POST["\143\157\x6e\x66\151\x72\155\120\141\x73\x73\x77\157\x72\144"]) < 6) {
            goto lh;
        }
        if (!filter_var($_POST["\145\155\141\x69\154"], FILTER_VALIDATE_EMAIL)) {
            goto AP;
        }
        if ($this->checkPasswordPattern(strip_tags($_POST["\160\141\163\x73\x77\x6f\162\x64"]))) {
            goto yf;
        }
        $bz = sanitize_email($_POST["\145\155\x61\x69\x6c"]);
        $VP = sanitize_text_field($_POST["\x70\x68\157\156\145"]);
        $Sc = stripslashes(strip_tags($_POST["\160\141\x73\163\167\x6f\162\x64"]));
        $Q8 = stripslashes(strip_tags($_POST["\x63\157\156\x66\151\162\x6d\120\x61\x73\163\x77\x6f\162\x64"]));
        goto EP;
        yf:
        update_option("\155\157\137\x73\x61\x6d\154\x5f\155\x65\x73\163\141\147\145", "\115\x69\156\151\155\x75\155\40\66\40\143\150\141\x72\x61\143\x74\x65\x72\163\x20\163\x68\157\x75\x6c\x64\x20\x62\x65\x20\160\x72\x65\x73\145\156\164\56\x20\115\141\x78\151\x6d\165\155\x20\x31\65\x20\x63\x68\x61\162\x61\143\164\145\x72\163\40\163\150\157\165\154\x64\x20\142\x65\x20\160\162\x65\x73\x65\156\x74\56\40\117\x6e\x6c\171\40\x66\157\154\x6c\157\167\151\x6e\147\40\163\x79\155\x62\x6f\154\x73\40\50\41\100\43\56\44\x25\136\x26\x2a\x2d\x5f\51\40\163\x68\x6f\x75\x6c\144\x20\142\x65\x20\x70\162\x65\x73\x65\x6e\x74\x2e");
        $this->mo_saml_show_error_message();
        return;
        EP:
        goto ne;
        AP:
        update_option("\x6d\x6f\x5f\163\x61\155\x6c\137\x6d\x65\163\163\x61\x67\145", "\x50\x6c\145\x61\x73\145\x20\145\x6e\164\145\x72\x20\141\40\x76\x61\x6c\151\x64\x20\145\155\x61\x69\x6c\40\x61\x64\x64\x72\x65\163\163\x2e");
        $this->mo_saml_show_error_message();
        return;
        ne:
        goto f2;
        lh:
        update_option("\x6d\x6f\137\163\141\155\x6c\137\x6d\145\163\163\x61\x67\x65", "\x43\150\x6f\157\163\x65\40\141\x20\x70\x61\x73\x73\x77\157\162\x64\x20\167\x69\x74\x68\x20\x6d\151\156\151\155\x75\155\x20\x6c\145\x6e\x67\164\x68\40\x36\x2e");
        $this->mo_saml_show_error_message();
        return;
        f2:
        goto iQ;
        w6:
        update_option("\155\157\137\x73\x61\155\154\x5f\155\x65\x73\x73\x61\x67\145", "\101\154\154\40\164\150\145\40\x66\x69\x65\154\x64\163\x20\x61\x72\145\x20\x72\145\x71\165\x69\x72\145\144\56\x20\120\154\x65\141\163\x65\x20\145\x6e\164\145\162\40\x76\x61\x6c\151\x64\40\145\x6e\164\162\151\x65\x73\56");
        $this->mo_saml_show_error_message();
        return;
        iQ:
        update_option("\x6d\x6f\137\x73\x61\x6d\x6c\x5f\x61\x64\155\x69\x6e\x5f\145\155\141\x69\154", $bz);
        update_option("\155\x6f\137\163\x61\x6d\x6c\137\141\144\155\x69\x6e\137\160\x68\x6f\156\x65", $VP);
        if (strcmp($Sc, $Q8) == 0) {
            goto xe;
        }
        update_option("\155\157\x5f\x73\141\x6d\x6c\137\155\x65\x73\x73\x61\x67\x65", "\x50\x61\x73\x73\x77\157\162\144\163\x20\x64\157\x20\x6e\x6f\x74\40\155\x61\164\x63\150\x2e");
        delete_option("\155\157\x5f\x73\141\x6d\154\x5f\x76\x65\162\151\x66\x79\137\x63\165\163\x74\x6f\155\145\x72");
        $this->mo_saml_show_error_message();
        goto zK;
        xe:
        update_option("\x6d\157\137\x73\141\155\x6c\x5f\x61\144\155\151\156\137\x70\141\x73\163\x77\157\162\x64", $Sc);
        $bz = get_option("\155\157\137\x73\x61\x6d\154\137\x61\144\155\151\x6e\137\x65\x6d\141\x69\x6c");
        $G0 = new CustomerSaml();
        $ys = $G0->check_customer();
        if ($ys) {
            goto eE;
        }
        return;
        eE:
        $ys = json_decode($ys, true);
        if (strcasecmp($ys["\x73\x74\141\164\165\163"], "\103\x55\123\124\x4f\x4d\105\x52\x5f\x4e\x4f\x54\x5f\106\117\x55\116\104") == 0) {
            goto X9;
        }
        $this->get_current_customer();
        goto pm;
        X9:
        $ys = $G0->send_otp_token($bz, '');
        if ($ys) {
            goto D9;
        }
        return;
        D9:
        $ys = json_decode($ys, true);
        if (strcasecmp($ys["\163\x74\141\164\x75\x73"], "\123\x55\103\103\105\x53\123") == 0) {
            goto C9;
        }
        update_option("\155\x6f\137\x73\141\155\154\137\x6d\145\163\x73\141\x67\x65", "\124\150\145\x72\x65\x20\167\x61\163\40\x61\x6e\x20\145\162\x72\x6f\162\x20\151\156\x20\163\x65\156\144\x69\156\x67\x20\x65\155\141\x69\154\x2e\40\x50\154\145\x61\x73\x65\40\x76\x65\x72\151\146\171\40\x79\157\165\x72\40\145\155\x61\x69\154\x20\x61\x6e\x64\40\x74\162\171\40\x61\x67\x61\151\x6e\x2e");
        update_option("\x6d\x6f\137\x73\x61\x6d\x6c\137\162\145\147\151\163\164\162\x61\164\151\x6f\x6e\137\x73\164\x61\x74\x75\x73", "\115\117\137\117\x54\120\137\104\x45\x4c\111\126\105\x52\105\104\137\106\101\x49\x4c\125\x52\x45\137\105\115\101\111\x4c");
        $this->mo_saml_show_error_message();
        goto vh;
        C9:
        update_option("\x6d\x6f\137\x73\141\155\x6c\x5f\x6d\x65\163\163\141\x67\145", "\40\101\40\x6f\156\145\40\164\151\x6d\145\x20\160\x61\x73\x73\143\157\144\x65\40\x69\x73\x20\163\145\x6e\164\40\164\x6f\x20" . get_option("\155\x6f\137\x73\141\155\154\137\x61\x64\155\x69\156\137\x65\x6d\141\x69\x6c") . "\56\40\120\x6c\x65\x61\x73\145\x20\145\x6e\164\145\x72\40\x74\150\x65\40\157\164\x70\40\150\145\162\x65\x20\164\x6f\x20\166\x65\162\151\146\171\40\171\157\x75\x72\40\145\155\x61\x69\154\x2e");
        update_option("\x6d\x6f\x5f\x73\x61\155\154\137\x74\x72\x61\156\163\x61\x63\164\151\157\156\111\x64", $ys["\164\x78\111\x64"]);
        update_option("\x6d\157\x5f\163\x61\155\x6c\137\x72\x65\x67\151\x73\164\162\141\x74\x69\x6f\x6e\x5f\163\x74\141\164\x75\x73", "\115\117\137\117\124\120\x5f\104\105\x4c\x49\126\105\x52\x45\104\x5f\123\125\x43\103\x45\123\x53\137\x45\115\101\111\114");
        $this->mo_saml_show_success_message();
        vh:
        pm:
        zK:
        WP:
        if (self::mo_check_option_admin_referer("\x6d\157\137\x73\x61\155\154\137\166\x61\x6c\151\144\141\164\x65\137\157\x74\x70")) {
            goto jf;
        }
        if (self::mo_check_option_admin_referer("\x6d\157\137\x73\x61\155\x6c\x5f\x76\x65\x72\151\x66\171\137\x6c\151\143\145\156\163\x65")) {
            goto Gp;
        }
        if (self::mo_check_option_admin_referer("\155\157\x5f\163\141\155\154\137\143\157\156\164\x61\x63\164\x5f\165\163\x5f\x71\x75\145\162\x79\137\x6f\160\164\x69\x6f\156")) {
            goto iq;
        }
        if (self::mo_check_option_admin_referer("\155\x6f\x5f\x73\141\155\x6c\x5f\x72\145\x73\x65\x6e\144\x5f\157\164\x70\137\x65\155\x61\151\x6c")) {
            goto k1;
        }
        if (self::mo_check_option_admin_referer("\x6d\x6f\x5f\163\x61\155\154\x5f\162\145\x73\x65\x6e\144\137\x6f\164\x70\137\160\x68\x6f\x6e\x65")) {
            goto SF;
        }
        if (self::mo_check_option_admin_referer("\155\x6f\137\163\x61\155\x6c\x5f\147\x6f\x5f\142\141\143\x6b")) {
            goto jx;
        }
        if (self::mo_check_option_admin_referer("\x6d\157\137\x73\141\155\x6c\137\162\145\147\151\x73\x74\145\x72\137\x77\151\164\150\x5f\x70\150\x6f\x6e\145\x5f\x6f\160\x74\151\x6f\x6e")) {
            goto lj;
        }
        if (self::mo_check_option_admin_referer("\x6d\x6f\137\163\x61\155\x6c\137\162\145\x67\x69\163\x74\x65\162\145\x64\x5f\157\156\x6c\x79\137\x61\143\x63\x65\x73\x73\x5f\x6f\160\164\151\x6f\156")) {
            goto XK;
        }
        if (self::mo_check_option_admin_referer("\155\157\x5f\x73\141\x6d\154\x5f\x66\x6f\x72\x63\145\137\x61\165\x74\x68\x65\156\x74\151\143\x61\164\x69\157\x6e\x5f\x6f\x70\x74\151\157\156")) {
            goto l0;
        }
        if (self::mo_check_option_admin_referer("\155\157\x5f\x73\x61\155\x6c\137\x65\156\141\142\154\x65\137\162\163\163\x5f\141\x63\x63\x65\x73\163\137\157\160\164\151\157\x6e")) {
            goto T1;
        }
        if (self::mo_check_option_admin_referer("\x6d\157\137\x73\x61\155\x6c\137\145\156\141\x62\x6c\x65\x5f\x6c\157\147\151\x6e\137\162\145\144\x69\162\x65\x63\x74\137\157\x70\x74\x69\157\156")) {
            goto Hr;
        }
        if (self::mo_check_option_admin_referer("\x6d\x6f\x5f\163\141\x6d\x6c\137\141\154\x6c\157\167\137\167\x70\x5f\x73\x69\147\x6e\151\156\137\157\x70\x74\151\x6f\156")) {
            goto DK;
        }
        if (isset($_POST["\157\x70\x74\x69\x6f\156"]) && $_POST["\x6f\160\x74\151\157\x6e"] == "\155\x6f\x5f\x73\x61\x6d\154\137\x66\157\x72\147\157\164\137\x70\141\x73\x73\167\157\x72\144\x5f\x66\x6f\162\x6d\137\x6f\x70\x74\151\157\156") {
            goto FK;
        }
        if (!self::mo_check_option_admin_referer("\155\x6f\137\x73\141\x6d\x6c\x5f\x76\x65\x72\151\146\171\137\143\165\x73\164\157\x6d\145\162")) {
            goto NJ;
        }
        if (mo_saml_is_extension_installed("\143\x75\162\154")) {
            goto qy;
        }
        update_option("\155\157\137\163\x61\x6d\154\x5f\155\145\x73\x73\x61\147\x65", "\105\122\x52\117\122\x3a\x20\120\x48\120\x20\x63\125\x52\114\x20\x65\x78\164\145\x6e\x73\x69\x6f\x6e\x20\x69\x73\40\x6e\x6f\x74\40\151\156\163\x74\x61\x6c\154\x65\144\40\157\162\x20\144\151\163\141\142\154\x65\144\x2e\40\x4c\x6f\147\151\x6e\x20\146\141\x69\x6c\145\144\56");
        $this->mo_saml_show_error_message();
        return;
        qy:
        $bz = '';
        $Sc = '';
        if ($this->mo_saml_check_empty_or_null($_POST["\x65\155\x61\x69\154"]) || $this->mo_saml_check_empty_or_null($_POST["\x70\141\163\x73\x77\157\162\x64"])) {
            goto pc;
        }
        if ($this->checkPasswordPattern(strip_tags($_POST["\160\x61\163\x73\x77\x6f\162\144"]))) {
            goto aa;
        }
        $bz = sanitize_email($_POST["\145\x6d\141\x69\154"]);
        $Sc = stripslashes(strip_tags($_POST["\x70\141\163\x73\x77\x6f\x72\x64"]));
        goto Y0;
        aa:
        update_option("\155\x6f\x5f\x73\141\x6d\x6c\x5f\x6d\x65\163\163\x61\147\145", "\115\x69\156\151\155\165\x6d\x20\x36\40\x63\x68\141\162\141\143\164\145\x72\x73\40\163\150\x6f\165\x6c\144\x20\142\145\40\x70\x72\145\x73\145\156\x74\56\x20\115\x61\x78\x69\155\x75\x6d\40\61\65\x20\143\150\141\x72\x61\x63\164\x65\x72\163\x20\x73\150\x6f\x75\x6c\144\x20\142\x65\x20\x70\162\145\163\x65\x6e\164\x2e\x20\117\x6e\154\x79\x20\146\157\x6c\154\157\167\x69\x6e\x67\40\163\171\155\142\x6f\x6c\163\40\x28\x21\100\x23\56\x24\45\136\x26\52\x2d\x5f\x29\x20\x73\150\x6f\165\x6c\144\x20\x62\x65\x20\160\162\x65\x73\145\156\x74\56");
        $this->mo_saml_show_error_message();
        return;
        Y0:
        goto x4;
        pc:
        update_option("\155\157\137\x73\141\x6d\154\x5f\x6d\145\x73\x73\141\147\x65", "\101\x6c\x6c\40\164\x68\145\40\146\x69\x65\x6c\x64\163\x20\141\162\x65\40\162\145\x71\165\151\x72\x65\144\x2e\x20\x50\154\x65\141\163\x65\x20\x65\x6e\164\145\162\40\166\x61\154\x69\x64\x20\145\156\x74\x72\151\145\163\x2e");
        $this->mo_saml_show_error_message();
        return;
        x4:
        update_option("\155\x6f\137\163\141\155\154\137\141\144\155\x69\156\x5f\145\x6d\141\151\x6c", $bz);
        update_option("\155\157\137\163\x61\155\154\x5f\141\x64\x6d\151\156\x5f\160\x61\163\163\167\x6f\162\144", $Sc);
        $G0 = new Customersaml();
        $ys = $G0->get_customer_key();
        if ($ys) {
            goto Y_;
        }
        return;
        Y_:
        $e6 = json_decode($ys, true);
        if (json_last_error() == JSON_ERROR_NONE) {
            goto rl;
        }
        update_option("\x6d\157\x5f\x73\141\155\154\137\155\x65\x73\x73\141\x67\x65", "\111\x6e\166\141\154\151\144\x20\x75\163\x65\162\156\x61\x6d\145\40\157\x72\40\x70\141\x73\x73\x77\x6f\x72\144\x2e\x20\x50\154\145\141\163\x65\x20\164\162\171\x20\141\x67\x61\x69\156\x2e");
        $this->mo_saml_show_error_message();
        goto ay;
        rl:
        update_option("\x6d\157\x5f\x73\x61\x6d\x6c\137\x61\144\155\x69\156\x5f\x63\x75\x73\x74\x6f\155\145\x72\137\153\x65\171", $e6["\151\144"]);
        update_option("\155\157\137\163\x61\x6d\154\x5f\x61\x64\x6d\x69\156\137\141\x70\151\137\153\x65\x79", $e6["\x61\160\x69\113\x65\x79"]);
        update_option("\x6d\x6f\137\x73\141\155\x6c\137\143\165\163\x74\x6f\x6d\145\162\137\x74\x6f\153\x65\156", $e6["\164\157\x6b\x65\156"]);
        if (empty($e6["\x70\x68\157\x6e\x65"])) {
            goto bh;
        }
        update_option("\x6d\x6f\137\x73\x61\155\154\x5f\141\x64\155\151\x6e\x5f\x70\150\157\156\x65", $e6["\x70\x68\x6f\x6e\145"]);
        bh:
        update_option("\155\x6f\137\163\x61\x6d\154\x5f\141\144\x6d\x69\156\x5f\160\x61\163\163\x77\x6f\x72\x64", '');
        update_option("\155\157\137\163\x61\155\154\x5f\x6d\145\x73\x73\x61\147\145", "\103\165\x73\x74\x6f\x6d\145\x72\40\162\145\x74\x72\151\x65\x76\x65\144\40\x73\x75\x63\143\x65\x73\x73\x66\x75\x6c\154\171");
        update_option("\155\x6f\137\x73\141\x6d\x6c\137\162\x65\147\151\x73\x74\162\141\164\151\157\156\x5f\x73\x74\x61\164\x75\x73", "\x45\x78\151\x73\164\151\156\x67\x20\x55\x73\145\x72");
        delete_option("\x6d\157\x5f\163\x61\155\x6c\x5f\x76\x65\x72\151\146\x79\137\143\x75\x73\164\157\155\145\x72");
        if (get_option("\163\155\x6c\x5f\x6c\x6b")) {
            goto EW;
        }
        $this->mo_saml_show_success_message();
        goto mU;
        EW:
        $uZ = get_option("\x6d\157\137\163\x61\x6d\x6c\x5f\143\x75\x73\x74\157\155\x65\162\137\x74\157\153\x65\156");
        $HP = AESEncryption::decrypt_data(get_option("\163\155\x6c\137\154\x6b"), $uZ);
        $ys = $G0->mo_saml_vl($HP, false);
        if ($ys) {
            goto qC;
        }
        return;
        qC:
        $ys = json_decode($ys, true);
        update_option("\166\154\x5f\143\150\145\143\153\x5f\x74", time());
        if (strcasecmp($ys["\163\x74\141\164\165\163"], "\x53\125\x43\x43\105\x53\x53") == 0) {
            goto nb;
        }
        update_option("\155\157\x5f\163\x61\155\x6c\x5f\155\x65\163\x73\x61\147\x65", "\x4c\151\143\145\x6e\x73\x65\x20\x6b\145\x79\40\x66\157\162\x20\x74\x68\151\163\40\151\x6e\163\164\x61\156\143\145\40\151\163\40\151\156\143\x6f\162\162\145\x63\x74\56\x20\115\141\153\x65\40\x73\x75\162\145\40\171\157\x75\x20\150\141\x76\x65\x20\x6e\x6f\164\x20\164\x61\x6d\x70\145\x72\x65\144\x20\167\151\x74\x68\40\151\164\x20\141\x74\40\x61\x6c\x6c\56\40\120\x6c\145\141\163\145\x20\x65\156\164\x65\x72\40\141\x20\166\141\x6c\151\x64\40\x6c\x69\143\x65\156\163\145\x20\x6b\x65\171\56");
        delete_option("\x73\x6d\x6c\137\154\153");
        $this->mo_saml_show_error_message();
        goto zF;
        nb:
        $PS = plugin_dir_path(__FILE__);
        $kV = home_url();
        $kV = trim($kV, "\x2f");
        if (preg_match("\x23\x5e\x68\164\164\160\x28\163\51\x3f\x3a\57\x2f\x23", $kV)) {
            goto Jq;
        }
        $kV = "\x68\164\164\160\72\x2f\57" . $kV;
        Jq:
        $fp = parse_url($kV);
        $Oh = preg_replace("\57\x5e\x77\167\167\x5c\x2e\x2f", '', $fp["\x68\x6f\163\164"]);
        $Af = wp_upload_dir();
        $pg = $Oh . "\x2d" . $Af["\142\141\x73\145\x64\x69\162"];
        $Ca = hash_hmac("\x73\150\141\x32\65\x36", $pg, "\x34\104\110\146\152\x67\146\x6a\141\x73\x6e\144\x66\163\141\x6a\146\x48\107\112");
        $f_ = $this->djkasjdksa();
        $X1 = round(strlen($f_) / rand(2, 20));
        $f_ = substr_replace($f_, $Ca, $X1, 0);
        $iH = base64_decode($f_);
        if (is_writable($PS . "\x6c\151\143\145\156\163\145")) {
            goto p6;
        }
        $f_ = str_rot13($f_);
        $Nw = base64_decode("\x62\x47\x4e\x6b\x61\x6d\x74\150\x63\62\x70\x6b\141\x33\x4e\150\x59\x32\x77\75");
        update_option($Nw, $f_);
        goto a_;
        p6:
        file_put_contents($PS . "\x6c\151\143\x65\x6e\163\x65", $iH);
        a_:
        update_option("\x6c\143\x77\162\x74\154\146\x73\141\x6d\x6c", true);
        $this->mo_saml_show_success_message();
        zF:
        mU:
        ay:
        update_option("\155\157\x5f\x73\141\155\154\137\141\144\155\151\156\137\160\x61\x73\x73\x77\x6f\x72\x64", '');
        NJ:
        goto gL;
        FK:
        if (mo_saml_is_extension_installed("\143\x75\162\x6c")) {
            goto Yt;
        }
        update_option("\x6d\x6f\137\x73\x61\x6d\x6c\x5f\155\x65\163\163\x61\147\x65", "\x45\x52\122\x4f\122\72\x20\x50\x48\120\x20\x63\x55\122\114\40\x65\170\164\145\x6e\x73\151\x6f\156\x20\x69\x73\40\x6e\x6f\x74\40\151\156\x73\x74\141\x6c\x6c\145\x64\x20\x6f\x72\40\144\151\163\141\142\154\x65\x64\x2e\40\122\x65\163\x65\x6e\144\40\117\x54\x50\x20\x66\x61\x69\x6c\145\144\x2e");
        $this->mo_saml_show_error_message();
        return;
        Yt:
        $bz = get_option("\x6d\157\137\163\x61\x6d\x6c\137\141\144\x6d\x69\156\137\145\155\141\x69\x6c");
        $G0 = new Customersaml();
        $ys = $G0->mo_saml_forgot_password($bz);
        if ($ys) {
            goto yM;
        }
        return;
        yM:
        $ys = json_decode($ys, true);
        if (strcasecmp($ys["\x73\x74\141\x74\165\x73"], "\x53\125\x43\103\105\x53\123") == 0) {
            goto gZ;
        }
        update_option("\x6d\157\137\163\x61\x6d\x6c\137\155\145\x73\x73\141\147\145", "\101\x6e\x20\145\162\x72\157\x72\40\x6f\143\143\x75\162\x65\144\x20\x77\x68\151\x6c\145\40\x70\x72\157\x63\x65\163\163\x69\x6e\x67\40\x79\x6f\165\x72\x20\162\x65\161\165\145\163\x74\56\x20\120\154\x65\x61\x73\145\x20\124\162\171\x20\x61\147\141\x69\156\x2e");
        $this->mo_saml_show_error_message();
        goto Fr;
        gZ:
        update_option("\155\x6f\137\163\141\155\x6c\137\x6d\145\163\163\141\147\145", "\131\157\x75\x72\x20\x70\x61\x73\163\x77\157\162\x64\40\x68\141\x73\x20\142\x65\x65\x6e\x20\162\145\x73\x65\x74\40\163\x75\x63\x63\x65\163\x73\146\x75\154\x6c\171\56\40\x50\x6c\x65\x61\163\145\x20\145\156\164\x65\162\x20\164\150\x65\x20\156\x65\167\40\160\x61\163\x73\x77\157\162\144\x20\x73\145\156\x74\x20\x74\x6f\40" . $bz . "\x2e");
        $this->mo_saml_show_success_message();
        Fr:
        gL:
        goto GA;
        DK:
        $P3 = "\146\141\x6c\x73\145";
        if (array_key_exists("\x6d\157\137\x73\141\x6d\x6c\137\x61\x6c\154\x6f\x77\137\167\160\137\x73\151\x67\156\151\x6e", $_POST)) {
            goto P8;
        }
        $xp = "\146\x61\154\163\x65";
        goto UZ;
        P8:
        $xp = htmlspecialchars($_POST["\x6d\157\x5f\163\141\x6d\x6c\137\x61\154\154\x6f\x77\x5f\167\160\137\163\x69\147\156\x69\156"]);
        UZ:
        if ($xp == "\x74\x72\165\145") {
            goto RL;
        }
        update_option("\x6d\157\x5f\163\x61\x6d\154\137\x61\154\154\157\167\x5f\x77\x70\137\163\151\x67\x6e\x69\x6e", "\106\x61\154\163\145");
        goto P3;
        RL:
        update_option("\155\x6f\137\163\141\155\154\x5f\141\154\x6c\157\x77\137\167\160\137\x73\x69\x67\x6e\x69\x6e", "\164\x72\165\145");
        P3:
        if (!array_key_exists("\x6d\x6f\137\x73\x61\155\x6c\x5f\x62\x61\x63\x6b\144\157\x6f\x72\137\x75\x72\x6c", $_POST)) {
            goto C1;
        }
        $P3 = htmlspecialchars(trim($_POST["\x6d\x6f\137\163\141\155\x6c\137\142\141\x63\x6b\x64\x6f\x6f\x72\x5f\x75\162\154"]));
        C1:
        update_option("\155\x6f\137\x73\141\x6d\x6c\x5f\x62\141\143\x6b\144\157\157\x72\137\165\162\x6c", $P3);
        update_option("\155\x6f\x5f\x73\x61\155\x6c\137\x6d\x65\163\x73\141\x67\x65", "\123\x69\147\156\x20\111\x6e\x20\163\145\x74\164\151\x6e\x67\x73\x20\x75\x70\144\x61\x74\145\x64\x2e");
        $this->mo_saml_show_success_message();
        GA:
        goto vG;
        Hr:
        if (mo_saml_is_sp_configured()) {
            goto W0;
        }
        update_option("\x6d\x6f\137\163\141\155\x6c\137\x6d\x65\163\163\x61\147\145", "\120\x6c\145\x61\x73\x65\40\143\157\155\160\154\145\164\145\x20" . addLink("\123\145\x72\x76\151\143\145\x20\x50\x72\157\166\x69\144\x65\x72", add_query_arg(array("\x74\141\x62" => "\163\141\x76\x65"), $_SERVER["\x52\105\121\x55\x45\x53\124\x5f\x55\122\x49"])) . "\x20\x63\x6f\156\x66\151\147\x75\162\x61\x74\x69\x6f\x6e\40\x66\151\162\163\x74\56");
        $this->mo_saml_show_error_message();
        goto sC;
        W0:
        if (array_key_exists("\155\157\137\x73\x61\155\x6c\137\145\156\x61\142\x6c\x65\x5f\x6c\x6f\147\x69\156\x5f\162\x65\144\x69\x72\145\143\164", $_POST)) {
            goto Fx;
        }
        $Yw = "\x66\141\x6c\x73\145";
        goto hl;
        Fx:
        $Yw = htmlspecialchars($_POST["\155\x6f\137\x73\x61\155\x6c\x5f\145\x6e\x61\142\x6c\x65\x5f\x6c\x6f\x67\x69\x6e\137\x72\x65\144\151\x72\x65\x63\x74"]);
        hl:
        if ($Yw == "\164\x72\165\145") {
            goto tC;
        }
        update_option("\x6d\157\137\163\x61\155\x6c\x5f\x65\x6e\141\142\154\145\x5f\x6c\157\147\x69\x6e\137\162\145\144\x69\162\x65\143\x74", "\146\141\x6c\x73\145");
        update_option("\x6d\x6f\137\163\141\x6d\x6c\x5f\141\154\x6c\x6f\x77\137\x77\x70\x5f\163\151\147\x6e\151\156", "\x46\x61\154\x73\145");
        goto wT;
        tC:
        update_option("\155\x6f\137\163\141\155\x6c\x5f\x65\x6e\141\x62\154\145\137\x6c\x6f\x67\x69\x6e\137\162\145\144\x69\162\145\143\x74", "\164\162\x75\145");
        update_option("\x6d\157\137\163\141\x6d\154\x5f\x61\154\x6c\157\167\137\x77\x70\x5f\163\151\147\x6e\x69\x6e", "\x74\162\x75\145");
        wT:
        update_option("\x6d\157\137\163\x61\155\x6c\x5f\155\145\x73\163\141\147\145", "\123\151\147\156\40\151\156\40\x6f\160\164\x69\157\156\163\40\165\x70\x64\141\164\145\x64\56");
        $this->mo_saml_show_success_message();
        sC:
        vG:
        goto Q2;
        T1:
        if (mo_saml_is_sp_configured()) {
            goto Od;
        }
        update_option("\x6d\x6f\137\x73\x61\155\x6c\x5f\155\145\163\x73\x61\x67\145", "\x50\154\x65\x61\163\x65\x20\x63\x6f\x6d\x70\154\145\x74\x65\x20" . addLink("\x53\x65\162\x76\151\143\x65\x20\x50\x72\157\166\151\144\x65\162", add_query_arg(array("\x74\x61\x62" => "\163\x61\166\x65"), $_SERVER["\122\105\121\125\105\x53\124\x5f\x55\122\111"])) . "\x20\143\157\156\146\x69\147\165\162\141\164\151\157\156\x20\x66\x69\x72\x73\164\56");
        $this->mo_saml_show_error_message();
        goto F4;
        Od:
        if (array_key_exists("\155\x6f\x5f\x73\x61\x6d\154\x5f\x65\x6e\141\x62\x6c\145\137\x72\x73\163\x5f\141\143\143\145\163\163", $_POST)) {
            goto cR;
        }
        $AH = false;
        goto tm;
        cR:
        $AH = htmlspecialchars($_POST["\155\x6f\x5f\x73\141\x6d\154\137\145\156\141\x62\x6c\145\137\x72\x73\x73\x5f\141\x63\143\x65\163\x73"]);
        tm:
        if ($AH == "\164\x72\165\x65") {
            goto az;
        }
        update_option("\x6d\157\x5f\x73\x61\x6d\154\137\145\156\x61\x62\x6c\145\137\162\163\x73\137\x61\143\x63\x65\x73\163", "\146\x61\154\x73\145");
        goto SW;
        az:
        update_option("\155\157\x5f\x73\x61\155\x6c\137\x65\156\x61\142\x6c\145\137\x72\x73\x73\x5f\141\x63\143\145\x73\163", "\164\162\x75\x65");
        SW:
        update_option("\x6d\x6f\x5f\x73\141\x6d\x6c\137\155\x65\163\163\141\147\145", "\122\x53\123\40\x46\145\x65\144\x20\x6f\x70\164\x69\157\x6e\x20\x75\x70\x64\x61\164\145\x64\x2e");
        $this->mo_saml_show_success_message();
        F4:
        Q2:
        goto dd;
        l0:
        if (mo_saml_is_sp_configured()) {
            goto uY;
        }
        update_option("\155\157\x5f\163\141\x6d\154\137\x6d\x65\163\x73\141\147\x65", "\x50\x6c\x65\x61\x73\145\40\143\157\x6d\160\154\145\164\145\x20" . addLink("\x53\145\x72\x76\151\143\145\40\x50\162\157\x76\x69\x64\x65\162", add_query_arg(array("\164\141\142" => "\x73\141\x76\145"), $_SERVER["\x52\x45\121\125\x45\x53\x54\137\x55\122\x49"])) . "\x20\x63\157\x6e\x66\151\147\x75\162\x61\x74\x69\157\x6e\40\x66\x69\x72\163\164\56");
        $this->mo_saml_show_error_message();
        goto Mk;
        uY:
        if (array_key_exists("\x6d\157\x5f\x73\x61\155\x6c\x5f\x66\157\162\x63\145\137\141\165\164\x68\x65\156\164\x69\x63\141\x74\151\157\156", $_POST)) {
            goto Np;
        }
        $Yw = "\x66\141\x6c\x73\145";
        goto Cs;
        Np:
        $Yw = htmlspecialchars($_POST["\155\x6f\x5f\163\141\x6d\x6c\x5f\146\x6f\162\x63\x65\x5f\141\x75\164\150\x65\x6e\164\151\143\x61\x74\151\157\156"]);
        Cs:
        if ($Yw == "\x74\162\165\145") {
            goto Ue;
        }
        update_option("\x6d\x6f\137\x73\x61\x6d\x6c\x5f\x66\157\x72\143\x65\137\x61\165\164\150\145\x6e\x74\151\143\x61\164\x69\157\156", "\146\141\154\163\145");
        goto dh;
        Ue:
        update_option("\x6d\157\137\163\x61\155\x6c\x5f\x66\x6f\x72\143\145\x5f\141\x75\164\150\145\x6e\164\x69\x63\x61\x74\151\157\156", "\164\162\x75\x65");
        dh:
        update_option("\155\157\x5f\163\x61\155\154\137\155\145\x73\x73\x61\x67\145", "\123\151\147\156\40\x69\156\40\x6f\160\164\x69\x6f\156\163\x20\x75\x70\x64\x61\x74\145\x64\x2e");
        $this->mo_saml_show_success_message();
        Mk:
        dd:
        goto AU;
        XK:
        if (mo_saml_is_sp_configured()) {
            goto G2;
        }
        update_option("\x6d\157\137\163\141\155\x6c\137\155\x65\x73\x73\141\x67\145", "\x50\x6c\145\141\x73\145\x20\143\x6f\x6d\160\154\x65\164\145\40" . addLink("\x53\145\x72\x76\151\x63\x65\x20\120\x72\x6f\166\151\144\145\x72", add_query_arg(array("\164\141\142" => "\163\x61\x76\145"), $_SERVER["\x52\x45\x51\x55\x45\123\124\x5f\125\122\111"])) . "\40\x63\x6f\x6e\146\151\x67\x75\162\x61\164\x69\x6f\x6e\40\x66\x69\x72\163\x74\56");
        $this->mo_saml_show_error_message();
        goto LI;
        G2:
        if (array_key_exists("\155\157\x5f\x73\141\155\x6c\137\162\x65\147\151\x73\164\x65\162\145\x64\137\x6f\156\154\x79\x5f\141\x63\x63\145\x73\x73", $_POST)) {
            goto tE;
        }
        $Yw = "\x66\x61\154\163\145";
        goto wc;
        tE:
        $Yw = htmlspecialchars($_POST["\155\x6f\x5f\x73\141\155\154\x5f\x72\x65\x67\151\163\x74\x65\162\145\x64\x5f\157\x6e\154\171\137\x61\x63\x63\145\163\163"]);
        wc:
        if ($Yw == "\164\162\x75\145") {
            goto sE;
        }
        update_option("\x6d\157\x5f\163\x61\155\154\x5f\x72\145\147\151\163\x74\145\x72\x65\144\137\157\x6e\x6c\x79\x5f\x61\143\143\145\163\x73", "\146\141\x6c\163\145");
        goto ha;
        sE:
        update_option("\x6d\157\x5f\163\141\155\x6c\x5f\162\x65\x67\x69\x73\164\x65\162\145\x64\137\x6f\x6e\x6c\171\137\x61\143\143\x65\163\x73", "\x74\x72\x75\x65");
        ha:
        update_option("\155\157\x5f\x73\141\x6d\154\137\155\x65\163\163\x61\x67\x65", "\123\x69\147\x6e\x20\151\156\x20\x6f\160\x74\x69\x6f\x6e\163\40\x75\160\144\141\x74\145\x64\x2e");
        $this->mo_saml_show_success_message();
        LI:
        AU:
        goto ve;
        lj:
        if (mo_saml_is_extension_installed("\143\x75\x72\154")) {
            goto sl;
        }
        update_option("\x6d\157\x5f\x73\x61\x6d\154\137\x6d\145\x73\163\x61\x67\x65", "\105\x52\122\117\x52\x3a\40\120\x48\x50\40\x63\125\x52\114\40\x65\x78\164\x65\156\x73\x69\157\x6e\40\151\x73\x20\156\157\x74\40\x69\156\163\x74\141\x6c\x6c\145\x64\x20\x6f\x72\x20\144\x69\x73\x61\142\154\x65\144\x2e\40\122\x65\163\x65\156\144\40\117\x54\x50\40\146\x61\x69\154\145\x64\x2e");
        $this->mo_saml_show_error_message();
        return;
        sl:
        $VP = sanitize_text_field($_POST["\x70\150\157\x6e\x65"]);
        $VP = str_replace("\x20", '', $VP);
        $VP = str_replace("\55", '', $VP);
        update_option("\x6d\x6f\x5f\163\x61\x6d\154\x5f\141\x64\x6d\151\x6e\x5f\160\x68\x6f\156\x65", $VP);
        $G0 = new CustomerSaml();
        $ys = $G0->send_otp_token('', $VP, FALSE, TRUE);
        if ($ys) {
            goto GW;
        }
        return;
        GW:
        $ys = json_decode($ys, true);
        if (strcasecmp($ys["\x73\164\141\x74\165\163"], "\123\x55\103\103\105\123\x53") == 0) {
            goto yd;
        }
        update_option("\x6d\157\137\x73\141\155\x6c\137\155\145\x73\x73\x61\x67\x65", "\124\x68\x65\162\x65\40\x77\141\x73\40\x61\x6e\40\145\162\x72\157\162\x20\x69\156\40\x73\x65\156\144\x69\x6e\147\40\123\x4d\123\x2e\x20\120\154\145\x61\x73\x65\40\x63\154\151\143\153\40\x6f\156\40\122\x65\163\x65\156\x64\x20\x4f\124\120\x20\164\157\40\164\x72\171\40\x61\147\141\x69\156\x2e");
        update_option("\x6d\157\x5f\163\141\155\x6c\x5f\x72\145\x67\x69\x73\164\162\x61\164\x69\157\x6e\x5f\163\164\x61\164\x75\x73", "\115\117\137\117\124\120\137\x44\105\114\111\126\x45\x52\x45\104\137\106\101\x49\x4c\x55\x52\x45\x5f\120\110\117\x4e\x45");
        $this->mo_saml_show_error_message();
        goto Mv;
        yd:
        update_option("\155\157\137\163\x61\155\x6c\137\155\x65\x73\163\x61\147\145", "\40\x41\40\x6f\x6e\145\40\x74\151\155\145\x20\160\x61\x73\x73\x63\157\144\145\40\151\x73\40\x73\145\x6e\164\x20\x74\157\40" . get_option("\155\x6f\x5f\x73\x61\x6d\154\137\141\144\155\x69\x6e\137\x70\150\x6f\156\x65") . "\56\40\x50\154\x65\x61\x73\145\x20\145\156\164\x65\x72\40\164\150\x65\40\157\x74\x70\40\x68\145\162\x65\x20\164\157\40\166\x65\162\151\146\171\x20\x79\x6f\165\x72\x20\145\x6d\x61\151\154\x2e");
        update_option("\155\157\137\x73\141\x6d\154\137\164\x72\141\x6e\x73\x61\143\x74\151\x6f\x6e\111\144", $ys["\164\x78\111\144"]);
        update_option("\155\157\137\163\141\x6d\x6c\137\162\145\x67\151\x73\164\x72\141\x74\151\157\156\137\x73\164\141\x74\x75\163", "\115\x4f\x5f\117\124\120\137\104\105\x4c\111\x56\x45\122\x45\104\x5f\123\125\103\x43\105\123\123\137\120\110\117\116\105");
        $this->mo_saml_show_success_message();
        Mv:
        ve:
        goto JC;
        jx:
        update_option("\155\x6f\x5f\x73\141\155\x6c\x5f\x72\x65\147\151\163\164\162\x61\164\x69\x6f\x6e\137\x73\x74\x61\x74\x75\x73", '');
        update_option("\155\x6f\137\163\x61\155\x6c\x5f\x76\x65\162\x69\146\x79\x5f\143\x75\x73\x74\157\x6d\145\162", '');
        delete_option("\155\157\x5f\x73\x61\155\x6c\x5f\156\145\167\137\162\x65\147\151\x73\x74\x72\141\164\x69\x6f\x6e");
        delete_option("\155\x6f\x5f\163\141\x6d\x6c\137\141\144\x6d\151\156\137\145\155\x61\x69\154");
        delete_option("\x6d\157\137\x73\141\x6d\x6c\x5f\141\x64\155\151\156\x5f\x70\x68\x6f\156\x65");
        delete_site_option("\163\x6d\x6c\x5f\x6c\153");
        delete_site_option("\164\137\x73\x69\x74\x65\x5f\x73\x74\x61\164\x75\163");
        delete_site_option("\163\x69\164\145\137\143\x6b\137\154");
        JC:
        goto QY;
        SF:
        if (mo_saml_is_extension_installed("\x63\x75\162\x6c")) {
            goto vP;
        }
        update_option("\x6d\157\x5f\x73\x61\x6d\154\x5f\x6d\145\163\x73\141\147\x65", "\105\122\122\117\x52\x3a\40\x50\x48\x50\x20\x63\125\122\x4c\x20\x65\170\x74\145\x6e\x73\x69\157\x6e\x20\x69\x73\x20\x6e\x6f\x74\x20\x69\156\163\x74\141\x6c\154\x65\144\40\157\x72\40\144\151\163\x61\x62\x6c\145\144\x2e\x20\122\145\x73\x65\x6e\x64\40\x4f\124\x50\40\x66\x61\151\x6c\145\x64\56");
        $this->mo_saml_show_error_message();
        return;
        vP:
        $VP = get_option("\155\157\x5f\163\141\x6d\x6c\137\x61\x64\x6d\151\x6e\x5f\160\x68\x6f\156\145");
        $G0 = new CustomerSaml();
        $ys = $G0->send_otp_token('', $VP, FALSE, TRUE);
        if ($ys) {
            goto mN;
        }
        return;
        mN:
        $ys = json_decode($ys, true);
        if (strcasecmp($ys["\163\164\x61\x74\165\x73"], "\123\x55\x43\103\x45\x53\123") == 0) {
            goto xK;
        }
        update_option("\155\x6f\x5f\163\x61\155\x6c\x5f\x6d\145\163\x73\141\x67\x65", "\x54\150\x65\x72\x65\x20\167\141\x73\x20\141\156\x20\145\162\162\157\x72\40\151\156\40\163\x65\x6e\144\x69\156\x67\x20\145\x6d\x61\x69\154\x2e\40\x50\154\145\x61\163\x65\40\143\154\151\x63\x6b\40\157\156\x20\122\145\x73\145\x6e\x64\40\117\124\120\40\x74\157\40\164\162\x79\40\x61\x67\x61\x69\x6e\56");
        update_option("\155\x6f\137\x73\x61\x6d\154\x5f\162\x65\x67\151\x73\x74\x72\141\x74\x69\x6f\x6e\x5f\x73\164\x61\164\x75\163", "\x4d\x4f\137\117\124\x50\137\104\105\114\x49\126\105\x52\x45\x44\137\106\101\111\x4c\125\122\105\x5f\x50\x48\x4f\x4e\105");
        $this->mo_saml_show_error_message();
        goto R4;
        xK:
        update_option("\x6d\x6f\137\x73\141\155\154\x5f\155\145\163\x73\141\x67\145", "\x20\101\x20\x6f\x6e\x65\x20\164\x69\x6d\145\x20\160\141\163\163\x63\x6f\x64\x65\40\151\x73\x20\x73\x65\x6e\x74\x20\164\157\40" . $VP . "\40\x61\147\x61\151\x6e\x2e\x20\x50\x6c\x65\141\x73\x65\40\x63\150\x65\143\153\40\x69\x66\x20\171\157\x75\40\147\157\164\x20\x74\x68\x65\40\x6f\x74\160\40\141\x6e\144\x20\145\x6e\164\x65\x72\40\x69\x74\x20\x68\x65\162\145\x2e");
        update_option("\x6d\157\137\x73\x61\x6d\x6c\x5f\x74\x72\141\156\163\x61\x63\x74\151\157\156\x49\x64", $ys["\x74\170\x49\x64"]);
        update_option("\155\x6f\x5f\x73\x61\155\154\137\162\x65\x67\x69\x73\x74\x72\x61\164\x69\157\x6e\137\x73\164\x61\x74\165\x73", "\x4d\x4f\x5f\117\124\120\137\x44\105\114\111\x56\105\x52\x45\x44\137\123\125\x43\103\x45\x53\123\137\x50\110\117\x4e\x45");
        $this->mo_saml_show_success_message();
        R4:
        QY:
        goto il;
        k1:
        if (mo_saml_is_extension_installed("\143\x75\162\x6c")) {
            goto Gj;
        }
        update_option("\155\x6f\x5f\163\x61\x6d\154\137\155\145\x73\x73\141\x67\x65", "\x45\122\x52\117\x52\x3a\40\120\x48\120\40\x63\125\x52\114\40\x65\170\x74\145\x6e\163\x69\157\x6e\40\x69\163\x20\156\x6f\164\x20\151\156\x73\164\141\x6c\154\x65\x64\x20\157\x72\40\144\151\x73\x61\x62\x6c\145\144\x2e\40\x52\x65\163\145\x6e\x64\40\117\124\x50\40\146\x61\151\154\145\144\56");
        $this->mo_saml_show_error_message();
        return;
        Gj:
        $bz = get_option("\x6d\x6f\x5f\x73\141\x6d\x6c\x5f\x61\x64\155\151\x6e\x5f\145\155\x61\151\x6c");
        $G0 = new CustomerSaml();
        $ys = $G0->send_otp_token($bz, '');
        if ($ys) {
            goto Fb;
        }
        return;
        Fb:
        $ys = json_decode($ys, true);
        if (strcasecmp($ys["\x73\x74\x61\x74\x75\x73"], "\x53\125\x43\x43\x45\x53\123") == 0) {
            goto YN;
        }
        update_option("\155\x6f\x5f\163\x61\155\x6c\x5f\x6d\x65\163\x73\141\147\145", "\124\150\145\x72\x65\40\x77\x61\163\x20\x61\156\40\145\x72\x72\157\x72\x20\x69\156\40\x73\x65\156\144\x69\156\x67\x20\145\x6d\141\151\154\x2e\x20\x50\154\145\x61\163\145\40\x63\154\151\x63\x6b\40\x6f\156\x20\122\145\x73\x65\x6e\144\x20\117\124\x50\40\x74\x6f\x20\164\162\171\40\141\x67\x61\x69\156\56");
        update_option("\x6d\157\x5f\x73\x61\155\154\137\x72\x65\x67\x69\x73\164\162\x61\x74\x69\x6f\156\137\x73\x74\141\164\165\163", "\115\117\x5f\117\124\120\137\104\x45\x4c\x49\x56\105\x52\105\104\x5f\x46\101\111\x4c\x55\122\x45\137\105\x4d\101\111\114");
        $this->mo_saml_show_error_message();
        goto Vq;
        YN:
        update_option("\x6d\x6f\137\x73\x61\x6d\x6c\x5f\155\x65\x73\x73\x61\147\145", "\40\101\40\x6f\x6e\x65\40\164\x69\155\145\x20\160\141\163\163\x63\x6f\144\x65\40\x69\163\40\163\x65\x6e\x74\x20\x74\x6f\40" . get_option("\x6d\157\137\x73\141\x6d\x6c\137\141\x64\155\151\x6e\137\x65\x6d\141\151\154") . "\40\141\x67\141\x69\x6e\56\40\x50\x6c\145\141\163\145\40\143\150\x65\x63\153\x20\151\146\40\171\x6f\165\40\147\x6f\164\x20\164\x68\145\40\157\x74\160\40\141\156\144\x20\x65\x6e\164\x65\162\40\x69\164\x20\x68\145\x72\x65\x2e");
        update_option("\155\157\x5f\163\x61\x6d\x6c\137\164\162\141\156\x73\x61\x63\x74\151\x6f\156\x49\144", $ys["\x74\x78\x49\x64"]);
        update_option("\155\157\137\163\x61\x6d\x6c\137\x72\x65\x67\x69\163\164\x72\141\164\x69\157\x6e\137\163\164\141\x74\x75\x73", "\115\117\137\117\x54\120\x5f\x44\x45\114\x49\126\105\x52\x45\x44\x5f\123\125\103\x43\105\x53\x53\137\x45\115\101\111\x4c");
        $this->mo_saml_show_success_message();
        Vq:
        il:
        goto ku;
        iq:
        if (mo_saml_is_extension_installed("\143\165\162\x6c")) {
            goto hW;
        }
        update_option("\x6d\157\137\163\141\x6d\154\x5f\x6d\145\x73\163\141\147\x65", "\x45\122\x52\x4f\122\72\40\120\110\x50\40\143\125\x52\x4c\x20\145\x78\164\145\156\163\151\157\x6e\x20\x69\163\x20\156\x6f\164\x20\151\156\163\164\141\154\154\145\144\40\157\x72\40\144\151\x73\141\x62\154\x65\x64\56\40\x51\165\x65\x72\171\40\163\165\x62\x6d\x69\x74\x20\x66\141\x69\154\145\144\56");
        $this->mo_saml_show_error_message();
        return;
        hW:
        $bz = htmlspecialchars($_POST["\x6d\x6f\137\163\x61\x6d\x6c\137\x63\157\156\x74\x61\x63\x74\137\165\163\x5f\145\x6d\x61\x69\154"]);
        $VP = htmlspecialchars($_POST["\x6d\157\137\163\141\155\154\x5f\143\x6f\x6e\x74\141\143\x74\x5f\x75\x73\x5f\x70\x68\x6f\156\145"]);
        $jz = htmlspecialchars($_POST["\155\157\137\x73\141\x6d\x6c\x5f\143\157\x6e\x74\x61\143\x74\137\165\x73\137\161\165\x65\x72\x79"]);
        if (array_key_exists("\163\145\x6e\144\137\x70\x6c\165\147\x69\156\x5f\143\x6f\156\x66\x69\147", $_POST) === true) {
            goto Hn;
        }
        update_option("\163\x65\156\x64\137\x70\154\x75\x67\x69\156\137\143\x6f\x6e\x66\x69\147", "\157\x66\x66");
        goto Qw;
        Hn:
        $sz = miniorange_import_export(true, true);
        $jz .= $sz;
        delete_option("\x73\145\x6e\144\137\160\x6c\165\147\x69\156\x5f\x63\x6f\156\146\151\147");
        Qw:
        $G0 = new CustomerSaml();
        if ($this->mo_saml_check_empty_or_null($bz) || $this->mo_saml_check_empty_or_null($jz)) {
            goto ww;
        }
        if (!filter_var($bz, FILTER_VALIDATE_EMAIL)) {
            goto A7;
        }
        $hL = $G0->submit_contact_us($bz, $VP, $jz);
        if ($hL) {
            goto ZV;
        }
        return;
        ZV:
        update_option("\x6d\x6f\137\163\141\x6d\154\x5f\x6d\145\163\x73\141\x67\x65", "\124\x68\x61\x6e\x6b\163\40\x66\x6f\x72\40\x67\x65\x74\x74\151\x6e\147\40\x69\x6e\x20\x74\157\165\x63\150\41\40\127\x65\x20\163\x68\x61\154\x6c\40\147\x65\164\40\142\x61\143\153\x20\164\157\40\x79\157\x75\40\x73\x68\157\162\x74\154\171\56");
        $this->mo_saml_show_success_message();
        goto j9;
        A7:
        update_option("\x6d\157\137\163\x61\155\154\137\x6d\x65\x73\163\x61\x67\145", "\120\x6c\x65\141\163\145\40\x65\156\x74\145\162\40\x61\40\x76\x61\154\x69\x64\x20\x65\155\x61\151\x6c\x20\141\144\x64\162\x65\x73\163\56");
        $this->mo_saml_show_error_message();
        j9:
        goto np;
        ww:
        update_option("\x6d\157\x5f\163\x61\155\x6c\x5f\x6d\145\x73\163\x61\147\x65", "\x50\x6c\145\141\163\x65\x20\146\x69\154\x6c\40\165\x70\x20\x45\x6d\141\x69\x6c\40\x61\x6e\144\40\121\165\145\162\171\40\x66\151\x65\154\144\x73\x20\x74\x6f\x20\163\165\142\x6d\151\x74\40\x79\157\165\x72\40\161\x75\x65\162\x79\x2e");
        $this->mo_saml_show_error_message();
        np:
        ku:
        goto l_;
        Gp:
        if (!$this->mo_saml_check_empty_or_null($_POST["\x73\x61\x6d\x6c\x5f\x6c\151\143\145\x6e\x63\145\137\153\x65\171"])) {
            goto Pl;
        }
        update_option("\155\x6f\x5f\x73\141\x6d\154\x5f\x6d\x65\x73\163\141\x67\x65", "\101\154\154\x20\164\150\145\40\x66\x69\x65\x6c\x64\x73\40\x61\x72\145\x20\162\145\161\x75\x69\162\145\144\x2e\x20\120\x6c\x65\141\163\x65\x20\x65\156\x74\145\x72\40\x76\x61\154\151\x64\40\154\151\143\145\x6e\x73\x65\x20\x6b\145\x79\56");
        $this->mo_saml_show_error_message();
        return;
        Pl:
        $HP = htmlspecialchars(trim($_POST["\x73\x61\x6d\154\x5f\154\151\x63\145\156\x63\x65\137\x6b\145\171"]));
        $G0 = new Customersaml();
        $ys = $G0->check_customer_ln();
        if ($ys) {
            goto jv;
        }
        return;
        jv:
        $ys = json_decode($ys, true);
        if (strcasecmp($ys["\x73\164\141\x74\x75\163"], "\x53\x55\103\x43\x45\123\123") == 0) {
            goto X4;
        }
        $uZ = get_option("\155\x6f\137\x73\141\155\x6c\137\143\x75\x73\164\157\155\145\162\x5f\x74\x6f\x6b\x65\156");
        update_option("\163\x69\164\145\x5f\143\153\137\154", AESEncryption::encrypt_data("\146\x61\154\163\145", $uZ));
        $Q2 = add_query_arg(array("\164\x61\x62" => "\154\x69\143\x65\x6e\x73\151\156\147"), $_SERVER["\x52\x45\121\125\x45\123\x54\137\x55\x52\x49"]);
        update_option("\155\157\x5f\x73\x61\155\x6c\137\155\x65\x73\x73\141\147\145", "\x59\x6f\x75\40\150\141\166\145\40\156\157\164\40\165\160\147\162\x61\144\145\144\40\x79\145\164\x2e\x20" . addLink("\103\154\151\143\x6b\x20\150\x65\x72\145", $Q2) . "\x20\164\x6f\40\x75\160\147\162\141\144\x65\40\x74\x6f\x20\160\162\145\155\x69\165\x6d\x20\166\x65\x72\163\151\x6f\156\x2e");
        $this->mo_saml_show_error_message();
        goto Qu;
        X4:
        $ys = $G0->mo_saml_vl($HP, false);
        if ($ys) {
            goto Fp;
        }
        return;
        Fp:
        $ys = json_decode($ys, true);
        update_option("\166\154\137\143\150\x65\143\153\x5f\x74", time());
        if (strcasecmp($ys["\x73\164\141\164\165\x73"], "\x53\x55\x43\103\x45\123\123") == 0) {
            goto Li;
        }
        if (strcasecmp($ys["\163\164\141\x74\165\163"], "\x46\101\x49\114\105\x44") == 0) {
            goto Gx;
        }
        update_option("\155\x6f\137\163\x61\x6d\x6c\137\x6d\145\x73\163\x61\147\145", "\101\x6e\x20\x65\x72\x72\157\162\x20\x6f\143\x63\165\162\145\x64\x20\x77\x68\151\154\145\40\160\162\157\143\145\163\163\x69\156\147\x20\171\x6f\x75\x72\x20\x72\145\x71\165\x65\163\164\x2e\x20\120\154\x65\x61\x73\x65\40\x54\162\x79\x20\x61\x67\x61\151\x6e\x2e");
        $this->mo_saml_show_error_message();
        goto mG;
        Gx:
        if (strcasecmp($ys["\x6d\145\x73\x73\141\147\145"], "\103\157\144\145\40\x68\x61\163\40\105\170\x70\151\162\145\x64") == 0) {
            goto C8;
        }
        update_option("\155\157\x5f\163\x61\x6d\x6c\137\x6d\x65\163\x73\141\x67\145", "\x59\x6f\x75\40\x68\141\166\145\40\x65\156\x74\x65\162\145\144\40\x61\x6e\x20\x69\156\166\141\154\x69\144\x20\x6c\151\x63\x65\156\163\145\x20\x6b\x65\171\56\40\120\x6c\145\x61\163\x65\x20\145\156\x74\x65\162\40\141\x20\x76\x61\x6c\151\x64\40\154\151\143\x65\156\x73\145\x20\153\x65\171\x2e");
        goto gR;
        C8:
        $Q2 = add_query_arg(array("\164\141\142" => "\154\151\143\145\156\x73\x69\156\147"), $_SERVER["\x52\105\x51\125\x45\123\x54\x5f\125\x52\111"]);
        update_option("\155\x6f\137\163\141\155\x6c\137\x6d\145\163\x73\x61\147\145", "\114\x69\x63\145\x6e\x73\x65\x20\x6b\x65\171\x20\171\x6f\x75\40\150\x61\166\145\40\145\156\164\145\162\145\x64\40\x68\141\x73\x20\141\154\x72\x65\x61\x64\x79\40\x62\145\x65\156\40\x75\163\x65\144\x2e\40\120\x6c\145\x61\x73\x65\40\145\x6e\164\145\162\40\141\x20\153\145\171\x20\167\150\151\x63\x68\x20\x68\141\163\40\156\157\x74\x20\142\145\145\x6e\x20\165\163\145\x64\40\142\145\146\x6f\162\145\x20\157\156\x20\x61\x6e\x79\40\x6f\x74\150\145\x72\x20\151\156\163\x74\141\x6e\143\145\40\x6f\x72\x20\151\146\x20\x79\x6f\x75\x20\x68\x61\x76\x65\40\x65\x78\x61\x75\163\164\x65\144\40\141\x6c\154\x20\171\x6f\165\x72\x20\153\145\171\163\x20\x74\150\x65\156\40" . addLink("\x43\x6c\x69\143\x6b\40\x68\145\162\x65", $Q2) . "\40\164\157\x20\142\x75\171\40\x6d\157\162\145\x2e");
        gR:
        $this->mo_saml_show_error_message();
        mG:
        goto If1;
        Li:
        $uZ = get_option("\155\157\137\x73\141\x6d\x6c\x5f\143\x75\163\164\x6f\155\x65\162\x5f\x74\x6f\x6b\145\x6e");
        update_option("\x73\155\154\137\154\x6b", AESEncryption::encrypt_data($HP, $uZ));
        $AA = "\x59\x6f\165\162\40\x6c\x69\143\x65\x6e\163\x65\x20\x69\x73\40\x76\x65\162\151\146\151\145\144\56\40\131\x6f\x75\x20\143\141\156\40\x6e\157\x77\40\x73\145\164\x75\x70\x20\164\x68\145\40\160\154\165\147\151\156\56";
        update_option("\155\157\x5f\x73\141\x6d\154\137\x6d\145\163\x73\141\x67\145", $AA);
        $uZ = get_option("\155\157\x5f\x73\141\155\x6c\x5f\x63\x75\163\164\x6f\x6d\145\x72\137\164\157\x6b\145\x6e");
        update_option("\163\x69\x74\145\137\x63\x6b\x5f\154", AESEncryption::encrypt_data("\164\162\165\x65", $uZ));
        update_option("\164\137\163\x69\x74\145\137\163\164\141\x74\165\x73", AESEncryption::encrypt_data("\x66\141\x6c\x73\145", $uZ));
        $PS = plugin_dir_path(__FILE__);
        $kV = home_url();
        $kV = trim($kV, "\57");
        if (preg_match("\x23\136\150\164\164\160\50\x73\51\x3f\72\x2f\x2f\43", $kV)) {
            goto Gy;
        }
        $kV = "\150\164\164\x70\x3a\57\57" . $kV;
        Gy:
        $fp = parse_url($kV);
        $Oh = preg_replace("\57\x5e\x77\x77\167\x5c\56\57", '', $fp["\x68\x6f\163\x74"]);
        $Af = wp_upload_dir();
        $pg = $Oh . "\x2d" . $Af["\x62\141\x73\x65\144\x69\x72"];
        $Ca = hash_hmac("\163\x68\141\x32\x35\x36", $pg, "\x34\x44\x48\x66\x6a\147\146\x6a\141\163\156\144\x66\163\x61\x6a\x66\x48\x47\x4a");
        $f_ = $this->djkasjdksa();
        $X1 = round(strlen($f_) / rand(2, 20));
        $f_ = substr_replace($f_, $Ca, $X1, 0);
        $iH = base64_decode($f_);
        if (is_writable($PS . "\x6c\151\x63\x65\156\x73\145")) {
            goto QL;
        }
        $f_ = str_rot13($f_);
        $Nw = base64_decode("\142\x47\116\x6b\x61\x6d\x74\x68\x63\62\x70\x6b\141\x33\x4e\150\x59\x32\x77\x3d");
        update_option($Nw, $f_);
        goto B8;
        QL:
        file_put_contents($PS . "\x6c\151\143\145\x6e\163\145", $iH);
        B8:
        update_option("\154\143\x77\x72\164\x6c\x66\x73\x61\155\154", true);
        $Q2 = add_query_arg(array("\x74\x61\x62" => "\x67\x65\x6e\145\162\141\154"), $_SERVER["\122\x45\121\x55\x45\x53\124\x5f\125\122\x49"]);
        $this->mo_saml_show_success_message();
        If1:
        Qu:
        l_:
        goto M5;
        jf:
        if (mo_saml_is_extension_installed("\x63\165\162\154")) {
            goto pv;
        }
        update_option("\155\157\x5f\163\x61\x6d\154\137\x6d\145\x73\x73\141\147\145", "\105\x52\122\117\x52\72\x50\x48\120\40\x63\x55\122\x4c\x20\145\170\164\x65\156\x73\x69\157\x6e\40\151\x73\x20\x6e\x6f\164\x20\x69\x6e\x73\164\141\x6c\154\x65\144\x20\157\162\40\144\x69\x73\141\x62\154\145\x64\56\40\126\x61\x6c\x69\144\x61\x74\x65\x20\x4f\124\120\x20\146\x61\x69\154\x65\x64\x2e");
        $this->mo_saml_show_error_message();
        return;
        pv:
        $WS = '';
        if ($this->mo_saml_check_empty_or_null($_POST["\x6f\164\160\137\164\157\x6b\145\156"])) {
            goto mF;
        }
        $WS = sanitize_text_field($_POST["\157\x74\160\x5f\164\157\x6b\145\x6e"]);
        goto B3;
        mF:
        update_option("\x6d\x6f\137\x73\141\x6d\154\137\x6d\x65\x73\163\141\147\x65", "\x50\154\x65\x61\x73\x65\x20\145\x6e\x74\x65\x72\x20\141\40\166\x61\154\x75\145\40\151\156\x20\x6f\164\x70\x20\x66\151\145\x6c\144\56");
        $this->mo_saml_show_error_message();
        return;
        B3:
        $G0 = new CustomerSaml();
        $ys = $G0->validate_otp_token(get_option("\155\x6f\x5f\x73\141\155\154\137\164\x72\x61\x6e\x73\x61\x63\x74\151\x6f\x6e\x49\144"), $WS);
        if ($ys) {
            goto u1;
        }
        return;
        u1:
        $ys = json_decode($ys, true);
        if (strcasecmp($ys["\x73\164\141\x74\x75\163"], "\x53\x55\103\x43\105\x53\x53") == 0) {
            goto Co;
        }
        update_option("\x6d\x6f\137\163\x61\155\154\x5f\x6d\145\x73\x73\x61\x67\145", "\x49\x6e\x76\x61\154\x69\x64\40\x6f\x6e\145\40\x74\x69\x6d\145\40\160\x61\x73\163\143\x6f\x64\x65\56\x20\120\154\145\141\163\145\40\145\x6e\x74\x65\162\x20\141\40\x76\141\154\151\144\40\x6f\164\x70\x2e");
        $this->mo_saml_show_error_message();
        goto Ju;
        Co:
        $this->create_customer();
        Ju:
        M5:
        if (!self::mo_check_option_admin_referer("\155\157\137\x73\x61\155\x6c\137\x66\162\x65\x65\x5f\164\x72\x69\141\x6c")) {
            goto mX;
        }
        if (decryptSamlElement()) {
            goto vs;
        }
        $HP = postResponse();
        $G0 = new Customersaml();
        $ys = $G0->mo_saml_vl($HP, false);
        if ($ys) {
            goto tw;
        }
        return;
        tw:
        $ys = json_decode($ys, true);
        if (strcasecmp($ys["\x73\x74\x61\164\x75\x73"], "\123\x55\103\103\x45\x53\x53") == 0) {
            goto lx;
        }
        if (strcasecmp($ys["\163\164\141\164\165\x73"], "\106\x41\111\x4c\x45\x44") == 0) {
            goto l2;
        }
        update_option("\x6d\x6f\x5f\163\x61\155\154\137\155\x65\x73\163\x61\x67\145", "\101\x6e\40\145\162\162\x6f\x72\x20\x6f\143\x63\x75\x72\145\144\40\x77\x68\x69\154\x65\40\160\x72\157\143\145\163\x73\x69\x6e\x67\40\171\157\x75\x72\40\162\x65\x71\x75\145\x73\x74\56\x20\120\x6c\145\141\163\145\40\124\x72\171\40\x61\147\141\x69\156\56");
        $this->mo_saml_show_error_message();
        goto zc;
        l2:
        update_option("\155\x6f\x5f\x73\141\x6d\x6c\x5f\155\x65\163\x73\x61\x67\145", "\124\x68\145\x72\145\40\x77\141\x73\x20\141\156\x20\145\x72\x72\157\x72\40\x61\143\164\x69\166\x61\164\151\x6e\x67\40\171\157\x75\x72\40\124\x52\111\x41\x4c\40\x76\145\162\x73\x69\x6f\x6e\x2e\x20\x50\154\x65\x61\x73\145\40\143\157\x6e\x74\141\143\x74\40\151\x6e\146\157\100\170\145\143\165\x72\151\x66\171\56\x63\157\155\40\x66\157\162\40\x67\145\x74\164\151\x6e\x67\x20\x6e\145\x77\40\154\151\143\145\x6e\x73\x65\40\x66\x6f\x72\40\x74\162\151\141\x6c\x20\166\x65\162\x73\x69\x6f\156\56");
        $this->mo_saml_show_error_message();
        zc:
        goto br;
        lx:
        $uZ = get_option("\x6d\x6f\x5f\163\x61\155\x6c\x5f\x63\165\x73\x74\x6f\x6d\x65\x72\x5f\x74\x6f\153\145\x6e");
        $uZ = get_option("\x6d\157\x5f\163\x61\x6d\154\x5f\143\x75\x73\x74\157\155\x65\x72\x5f\164\x6f\x6b\145\156");
        update_option("\164\137\163\151\x74\x65\x5f\x73\164\141\164\x75\x73", AESEncryption::encrypt_data("\164\x72\x75\145", $uZ));
        update_option("\x6d\x6f\x5f\x73\x61\155\x6c\x5f\x6d\x65\x73\x73\x61\147\145", "\x59\x6f\x75\162\x20\x35\40\144\x61\171\163\x20\x54\122\x49\101\114\40\151\163\x20\x61\143\x74\151\166\141\x74\x65\144\x2e\40\131\x6f\x75\x20\143\x61\156\x20\156\x6f\x77\x20\163\145\164\165\x70\40\x74\x68\x65\40\x70\x6c\x75\147\x69\156\x2e");
        $this->mo_saml_show_success_message();
        br:
        goto rH;
        vs:
        update_option("\x6d\157\137\163\141\x6d\x6c\x5f\155\145\163\163\x61\147\x65", "\x54\x68\x65\x72\145\40\x77\x61\x73\x20\x61\156\40\x65\162\x72\x6f\162\x20\x61\x63\x74\x69\166\141\x74\151\156\147\40\171\x6f\x75\x72\x20\124\x52\111\x41\x4c\40\166\x65\162\163\x69\x6f\156\56\x20\x45\151\x74\150\x65\x72\40\x79\157\x75\x72\x20\x74\x72\151\141\x6c\40\x70\145\162\x69\157\144\x20\151\163\x20\x65\170\x70\151\162\x65\144\40\157\x72\x20\x79\157\165\40\141\x72\145\40\165\x73\x69\156\x67\40\x77\162\x6f\x6e\x67\x20\x74\162\151\141\154\x20\166\145\x72\x73\151\x6f\156\56\x20\120\x6c\145\141\163\x65\x20\143\157\x6e\x74\x61\143\164\40\x69\156\146\x6f\100\170\x65\143\x75\x72\151\146\x79\56\x63\157\155\40\146\157\x72\40\x67\145\x74\164\x69\156\x67\40\x6e\x65\x77\40\154\151\x63\145\156\163\145\x20\x66\157\x72\40\164\x72\x69\141\x6c\40\x76\x65\x72\163\x69\x6f\x6e\56");
        $this->mo_saml_show_error_message();
        rH:
        mX:
        if (!self::mo_check_option_admin_referer("\155\x6f\137\x73\x61\x6d\154\x5f\143\x68\145\143\x6b\137\x6c\151\x63\145\x6e\x73\145")) {
            goto y8;
        }
        $G0 = new Customersaml();
        $ys = $G0->check_customer_ln();
        if ($ys) {
            goto C_;
        }
        return;
        C_:
        $ys = json_decode($ys, true);
        if (strcasecmp($ys["\x73\164\x61\164\x75\x73"], "\123\125\x43\x43\x45\x53\x53") == 0) {
            goto AF;
        }
        $uZ = get_option("\155\x6f\137\x73\x61\x6d\x6c\x5f\143\165\x73\164\157\x6d\x65\x72\x5f\x74\157\153\x65\156");
        update_option("\163\151\x74\x65\x5f\x63\153\137\154", AESEncryption::encrypt_data("\146\x61\x6c\x73\x65", $uZ));
        $Q2 = add_query_arg(array("\x74\141\142" => "\154\x69\x63\145\x6e\163\x69\156\x67"), $_SERVER["\122\x45\x51\125\105\123\124\137\125\122\111"]);
        update_option("\155\157\x5f\x73\x61\155\154\137\155\x65\x73\163\141\147\x65", "\131\157\x75\x20\x68\141\166\x65\40\x6e\157\x74\x20\165\x70\x67\x72\141\x64\145\x64\x20\x79\145\x74\x2e\x20" . addLink("\x43\x6c\151\x63\153\40\150\x65\x72\145", $Q2) . "\x20\x74\x6f\x20\165\160\147\162\x61\144\145\40\164\157\x20\x70\162\x65\x6d\x69\165\155\40\x76\145\x72\163\151\x6f\x6e\x2e");
        $this->mo_saml_show_error_message();
        goto Gm;
        AF:
        if (array_key_exists("\154\151\x63\x65\156\163\145\x50\x6c\x61\x6e", $ys) && !$this->mo_saml_check_empty_or_null($ys["\154\151\x63\145\156\x73\x65\120\154\x61\x6e"])) {
            goto FS;
        }
        $uZ = get_option("\155\157\x5f\163\x61\155\x6c\x5f\x63\165\x73\x74\x6f\x6d\145\162\137\x74\x6f\153\145\x6e");
        update_option("\x73\x69\164\145\137\x63\153\x5f\x6c", AESEncryption::encrypt_data("\146\x61\154\x73\145", $uZ));
        $Q2 = add_query_arg(array("\x74\x61\x62" => "\x6c\151\x63\x65\x6e\163\x69\156\x67"), $_SERVER["\x52\x45\x51\125\x45\x53\124\137\125\x52\x49"]);
        update_option("\x6d\x6f\137\x73\x61\x6d\154\x5f\x6d\x65\163\163\x61\147\145", "\131\157\165\40\x68\141\166\x65\40\x6e\x6f\164\40\x75\160\x67\x72\x61\x64\145\144\x20\x79\x65\164\56\40" . addLink("\103\154\151\x63\153\40\x68\x65\162\145", $Q2) . "\x20\164\x6f\40\x75\160\147\162\x61\x64\x65\40\164\157\40\x70\x72\x65\x6d\x69\165\155\40\x76\145\162\x73\151\157\156\56");
        $this->mo_saml_show_error_message();
        goto Qt;
        FS:
        update_option("\155\x6f\137\163\x61\x6d\154\x5f\x6c\x69\143\x65\x6e\x73\x65\137\156\141\x6d\x65", base64_encode($ys["\154\151\x63\x65\156\x73\145\x50\x6c\x61\156"]));
        $uZ = get_option("\155\157\x5f\x73\x61\155\x6c\x5f\143\x75\163\164\157\155\145\x72\x5f\164\157\153\145\156");
        if (!(array_key_exists("\156\x6f\117\146\125\x73\x65\x72\x73", $ys) && !$this->mo_saml_check_empty_or_null($ys["\x6e\x6f\x4f\x66\x55\163\145\x72\x73"]))) {
            goto Qs;
        }
        update_option("\155\x6f\137\163\141\155\x6c\137\165\163\x72\x5f\x6c\x6d\164", AESEncryption::encrypt_data($ys["\x6e\x6f\117\146\x55\163\145\162\163"], $uZ));
        Qs:
        update_option("\163\151\x74\x65\137\x63\153\x5f\x6c", AESEncryption::encrypt_data("\164\x72\x75\145", $uZ));
        $PS = plugin_dir_path(__FILE__);
        $kV = home_url();
        $kV = trim($kV, "\x2f");
        if (preg_match("\x23\136\150\x74\x74\x70\x28\163\x29\x3f\72\57\57\43", $kV)) {
            goto J9;
        }
        $kV = "\x68\x74\x74\160\72\57\x2f" . $kV;
        J9:
        $fp = parse_url($kV);
        $Oh = preg_replace("\57\136\167\x77\167\x5c\56\x2f", '', $fp["\150\157\163\164"]);
        $Af = wp_upload_dir();
        $pg = $Oh . "\x2d" . $Af["\142\x61\x73\x65\x64\x69\162"];
        $Ca = hash_hmac("\x73\x68\141\62\x35\66", $pg, "\x34\104\110\146\152\147\x66\152\141\163\x6e\144\x66\x73\x61\152\146\x48\x47\112");
        $f_ = $this->djkasjdksa();
        $X1 = round(strlen($f_) / rand(2, 20));
        $f_ = substr_replace($f_, $Ca, $X1, 0);
        $iH = base64_decode($f_);
        if (is_writable($PS . "\154\151\143\x65\156\163\145")) {
            goto Mp;
        }
        $f_ = str_rot13($f_);
        $Nw = base64_decode("\142\x47\x4e\153\x61\155\164\x68\143\62\160\153\141\x33\116\x68\131\62\167\x3d");
        update_option($Nw, $f_);
        goto Wt;
        Mp:
        file_put_contents($PS . "\x6c\151\x63\x65\156\163\145", $iH);
        Wt:
        update_option("\x6c\143\x77\x72\x74\x6c\x66\x73\141\x6d\154", true);
        $Q2 = add_query_arg(array("\164\x61\x62" => "\147\145\x6e\x65\x72\x61\154"), $_SERVER["\122\105\x51\125\105\123\124\x5f\125\122\111"]);
        update_option("\x6d\x6f\137\163\141\155\x6c\137\x6d\145\x73\x73\141\147\145", "\x59\157\x75\x20\150\x61\166\145\x20\163\x75\x63\x63\145\x73\163\146\165\x6c\154\x79\x20\x75\160\147\162\141\144\145\144\40\171\157\x75\162\x20\x6c\x69\143\x65\x6e\x73\x65\56");
        $this->mo_saml_show_success_message();
        Qt:
        Gm:
        y8:
        if (!self::mo_check_option_admin_referer("\155\157\x5f\163\x61\x6d\x6c\137\x72\145\155\157\x76\145\x5f\141\x63\x63\x6f\x75\x6e\x74")) {
            goto GN;
        }
        $this->mo_sso_saml_deactivate();
        add_option("\x6d\157\x5f\x73\141\x6d\x6c\x5f\x72\145\x67\x69\x73\164\162\x61\x74\151\157\156\137\x73\x74\x61\164\x75\x73", "\x72\145\x6d\157\166\x65\x64\x5f\141\143\143\x6f\x75\156\164");
        $Q2 = add_query_arg(array("\x74\141\x62" => "\154\x6f\x67\x69\156"), $_SERVER["\x52\x45\121\125\x45\123\x54\x5f\x55\x52\x49"]);
        header("\114\x6f\143\x61\x74\x69\157\x6e\x3a\40" . $Q2);
        GN:
        S5:
    }
    function create_customer()
    {
        $G0 = new CustomerSaml();
        $e6 = $G0->create_customer();
        if ($e6) {
            goto w7;
        }
        return;
        w7:
        $e6 = json_decode($e6, true);
        if (strcasecmp($e6["\x73\x74\141\x74\x75\x73"], "\x43\125\123\x54\117\x4d\x45\x52\x5f\x55\123\x45\x52\116\101\x4d\x45\x5f\101\114\x52\x45\101\x44\131\x5f\105\x58\111\x53\x54\123") == 0) {
            goto oo;
        }
        if (!(strcasecmp($e6["\x73\x74\141\164\165\163"], "\x53\125\103\x43\x45\123\x53") == 0)) {
            goto Yo;
        }
        update_option("\155\x6f\x5f\163\141\x6d\x6c\x5f\141\x64\155\x69\x6e\x5f\x63\165\163\x74\x6f\x6d\x65\162\137\x6b\x65\171", $e6["\151\x64"]);
        update_option("\x6d\157\137\163\x61\x6d\x6c\137\x61\144\155\x69\156\x5f\141\160\x69\x5f\x6b\x65\171", $e6["\141\160\151\113\x65\171"]);
        update_option("\155\157\x5f\x73\x61\155\154\137\143\165\x73\164\x6f\155\145\162\137\164\x6f\x6b\x65\156", $e6["\x74\157\x6b\x65\156"]);
        update_option("\x6d\157\137\x73\141\155\154\137\x61\x64\155\x69\x6e\x5f\x70\x61\163\x73\167\x6f\x72\144", '');
        update_option("\x6d\157\137\163\x61\x6d\154\x5f\155\x65\x73\163\141\147\x65", "\x54\150\141\x6e\153\40\171\157\x75\40\x66\157\x72\40\x72\145\147\x69\163\x74\x65\162\151\156\147\40\167\151\164\150\x20\130\x65\x63\165\x72\x69\146\x79\56");
        update_option("\x6d\157\x5f\163\x61\x6d\154\137\162\x65\x67\x69\163\x74\x72\x61\x74\x69\x6f\156\x5f\163\164\x61\164\x75\x73", '');
        delete_option("\x6d\157\x5f\x73\141\155\154\137\166\x65\162\x69\x66\x79\137\143\165\163\x74\157\x6d\145\x72");
        delete_option("\x6d\x6f\137\163\x61\x6d\154\x5f\156\145\167\x5f\x72\x65\147\151\163\x74\x72\x61\x74\151\x6f\x6e");
        $this->mo_saml_show_success_message();
        Yo:
        goto zE;
        oo:
        $this->get_current_customer();
        zE:
        update_option("\x6d\x6f\137\163\x61\x6d\x6c\x5f\x61\x64\155\151\156\137\x70\x61\163\163\x77\157\x72\144", '');
    }
    function get_current_customer()
    {
        $G0 = new CustomerSaml();
        $ys = $G0->get_customer_key();
        if ($ys) {
            goto Az;
        }
        return;
        Az:
        $e6 = json_decode($ys, true);
        if (json_last_error() == JSON_ERROR_NONE) {
            goto XG;
        }
        update_option("\x6d\x6f\137\x73\141\155\154\137\x6d\x65\x73\163\141\x67\x65", "\131\x6f\165\x20\141\x6c\x72\145\141\x64\171\x20\150\141\x76\145\40\141\156\x20\x61\x63\143\157\x75\156\164\40\167\x69\164\150\40\155\x69\156\151\117\x72\141\156\147\x65\56\40\x50\154\x65\x61\x73\145\40\x65\156\164\x65\x72\x20\141\x20\x76\141\154\x69\144\40\x70\x61\x73\x73\x77\x6f\x72\x64\x2e");
        update_option("\x6d\157\x5f\163\x61\155\x6c\x5f\x76\x65\162\x69\146\x79\137\143\165\x73\164\157\155\x65\162", "\x74\162\x75\145");
        delete_option("\155\x6f\137\163\141\x6d\154\x5f\x6e\145\167\x5f\x72\145\x67\151\163\x74\x72\141\x74\151\x6f\x6e");
        $this->mo_saml_show_error_message();
        goto i6;
        XG:
        update_option("\x6d\157\137\163\141\x6d\154\x5f\141\x64\x6d\x69\156\137\x63\x75\163\164\x6f\x6d\145\162\137\x6b\145\x79", $e6["\151\x64"]);
        update_option("\x6d\x6f\x5f\x73\x61\155\x6c\137\141\144\x6d\x69\156\x5f\x61\160\151\x5f\153\x65\x79", $e6["\x61\160\x69\113\145\x79"]);
        update_option("\155\157\137\x73\x61\155\x6c\137\x63\x75\163\164\x6f\x6d\x65\x72\x5f\164\x6f\153\x65\x6e", $e6["\164\x6f\153\145\156"]);
        update_option("\x6d\157\137\x73\x61\155\x6c\137\141\144\155\x69\x6e\137\160\141\163\x73\x77\157\162\x64", '');
        update_option("\x6d\x6f\137\163\x61\x6d\154\137\155\145\163\x73\x61\147\145", "\131\157\x75\x72\x20\x61\143\143\x6f\165\x6e\164\x20\150\141\163\40\x62\145\145\156\x20\x72\145\x74\x72\151\145\166\x65\x64\40\x73\x75\143\143\145\x73\163\146\x75\154\x6c\x79\x2e");
        delete_option("\x6d\157\x5f\x73\x61\155\x6c\x5f\166\145\x72\x69\x66\x79\137\143\x75\163\164\x6f\155\145\x72");
        delete_option("\155\x6f\137\163\x61\x6d\x6c\137\x6e\x65\x77\x5f\162\145\147\x69\163\164\162\x61\164\151\157\156");
        $this->mo_saml_show_success_message();
        i6:
    }
    public function mo_saml_check_empty_or_null($Ka)
    {
        if (!(!isset($Ka) || empty($Ka))) {
            goto pX;
        }
        return true;
        pX:
        return false;
    }
    function miniorange_sso_menu()
    {
        $Xz = add_menu_page("\x4d\117\40\x53\x41\115\x4c\40\x53\x65\x74\x74\x69\x6e\147\x73\x20" . __("\103\x6f\x6e\146\151\x67\165\162\145\x20\123\x41\x4d\114\40\111\144\x65\x6e\164\x69\164\x79\40\120\162\157\x76\151\x64\145\x72\40\x66\x6f\x72\40\123\123\x4f", "\155\x6f\x5f\x73\141\x6d\x6c\137\x73\x65\164\164\151\x6e\x67\x73"), "\155\151\156\x69\117\162\x61\156\147\x65\x20\x53\x41\x4d\x4c\x20\x32\56\60\x20\x53\x53\117", "\x61\x64\x6d\x69\156\x69\163\x74\162\141\164\157\x72", "\x6d\x6f\137\163\x61\x6d\154\137\x73\145\x74\164\151\156\147\x73", array($this, "\x6d\157\x5f\154\x6f\147\151\x6e\137\x77\x69\x64\147\x65\x74\x5f\x73\x61\x6d\x6c\137\157\x70\x74\151\157\x6e\x73"), plugin_dir_url(__FILE__) . "\x69\155\141\x67\145\x73\x2f\x6d\151\x6e\x69\157\162\141\x6e\x67\145\x2e\x70\156\147");
    }
    function mo_saml_redirect_for_authentication($ml)
    {
        if (!mo_saml_is_customer_license_key_verified()) {
            goto nR;
        }
        if (!(mo_saml_is_sp_configured() && !is_user_logged_in())) {
            goto sn;
        }
        $Ko = get_option("\155\x6f\x5f\163\141\x6d\x6c\137\163\160\137\x62\141\163\x65\x5f\x75\162\154");
        if (!empty($Ko)) {
            goto uH;
        }
        $Ko = home_url();
        uH:
        if (!(get_option("\x6d\x6f\137\163\141\x6d\154\137\x72\x65\x6c\141\171\137\x73\x74\x61\164\145") && get_option("\x6d\157\137\163\141\x6d\x6c\x5f\162\x65\154\141\171\137\x73\164\x61\x74\x65") != '')) {
            goto DF;
        }
        $ml = get_option("\x6d\157\137\163\141\155\154\137\162\x65\x6c\x61\171\x5f\x73\164\x61\x74\145");
        DF:
        $ml = parse_url($ml, PHP_URL_PATH);
        $KI = empty($ml) ? "\57" : $ml;
        $c9 = get_option("\x73\x61\155\x6c\137\154\x6f\147\151\x6e\x5f\165\x72\154");
        $ut = get_option("\163\x61\155\154\137\x6c\x6f\x67\151\156\x5f\x62\x69\x6e\x64\151\x6e\147\x5f\164\x79\x70\x65");
        $Vb = get_option("\x6d\157\137\163\141\x6d\154\137\146\157\162\143\x65\137\141\x75\164\150\145\156\x74\151\143\141\x74\x69\157\x6e");
        $pH = $Ko . "\57";
        $Eq = get_option("\x6d\157\x5f\163\x61\155\x6c\x5f\x73\x70\137\145\x6e\164\151\x74\171\x5f\151\144");
        $Ss = get_option("\x73\x61\155\x6c\x5f\156\141\x6d\145\151\x64\x5f\x66\157\162\155\141\164");
        if (!empty($Ss)) {
            goto tS;
        }
        $Ss = "\61\56\x31\x3a\156\141\155\x65\151\144\x2d\146\x6f\162\155\141\x74\72\145\155\x61\x69\x6c\x41\144\x64\162\145\163\163";
        tS:
        if (!empty($Eq)) {
            goto l1;
        }
        $Eq = $Ko . "\57\x77\160\55\143\157\x6e\x74\x65\x6e\164\57\160\154\x75\147\x69\156\163\x2f\155\x69\x6e\x69\157\162\x61\156\x67\145\x2d\163\x61\x6d\154\x2d\62\x30\x2d\163\151\156\x67\x6c\x65\x2d\x73\x69\x67\156\x2d\x6f\156\57";
        l1:
        $oe = SAMLSPUtilities::createAuthnRequest($pH, $Eq, $c9, $Vb, $ut, $Ss);
        if (empty($ut) || $ut == "\110\164\164\x70\x52\145\x64\x69\x72\x65\x63\x74") {
            goto qf;
        }
        if (!(get_option("\x73\141\155\x6c\137\x72\145\x71\x75\145\x73\164\x5f\x73\151\147\156\x65\x64") == "\165\156\143\150\x65\143\x6b\145\x64")) {
            goto eD;
        }
        $wu = base64_encode($oe);
        SAMLSPUtilities::postSAMLRequest($c9, $wu, $KI);
        die;
        eD:
        $V2 = '';
        $xD = '';
        $wu = SAMLSPUtilities::signXML($oe, "\116\141\155\x65\x49\104\x50\157\154\x69\143\171");
        SAMLSPUtilities::postSAMLRequest($c9, $wu, $KI);
        goto s8;
        qf:
        $QL = $c9;
        if (strpos($c9, "\x3f") !== false) {
            goto gp;
        }
        $QL .= "\x3f";
        goto qB;
        gp:
        $QL .= "\46";
        qB:
        if (!(get_option("\x73\141\x6d\x6c\137\162\145\x71\165\145\x73\x74\137\x73\151\147\156\x65\144") == "\165\x6e\x63\x68\145\x63\153\x65\x64")) {
            goto pY;
        }
        $QL .= "\x53\x41\115\x4c\122\145\161\x75\x65\x73\x74\x3d" . $oe . "\46\122\145\154\x61\171\123\164\x61\164\145\x3d" . urlencode($KI);
        header("\x4c\x6f\x63\x61\x74\151\x6f\156\x3a\x20" . $QL);
        die;
        pY:
        $oe = "\x53\x41\x4d\114\122\x65\161\x75\x65\x73\164\75" . $oe . "\46\x52\x65\154\141\171\x53\x74\141\x74\x65\x3d" . urlencode($KI) . "\46\123\151\x67\101\154\x67\75" . urlencode(XMLSecurityKey::RSA_SHA256);
        $nT = array("\164\171\x70\x65" => "\160\162\151\166\141\164\x65");
        $uZ = new XMLSecurityKey(XMLSecurityKey::RSA_SHA256, $nT);
        $wO = get_option("\155\x6f\137\163\141\155\x6c\137\143\165\162\162\145\x6e\x74\x5f\x63\145\162\164\137\x70\162\151\x76\x61\164\145\137\x6b\x65\x79");
        $uZ->loadKey($wO, FALSE);
        $cG = new XMLSecurityDSig();
        $dZ = $uZ->signData($oe);
        $dZ = base64_encode($dZ);
        $QL .= $oe . "\x26\x53\x69\x67\156\141\x74\x75\x72\145\x3d" . urlencode($dZ);
        header("\x4c\x6f\143\141\x74\x69\x6f\x6e\x3a\x20" . $QL);
        die;
        s8:
        sn:
        nR:
    }
    function mo_saml_authenticate()
    {
        $bU = '';
        if (!isset($_REQUEST["\x72\x65\x64\151\x72\x65\x63\x74\x5f\164\157"])) {
            goto qW;
        }
        $bU = htmlspecialchars($_REQUEST["\162\x65\144\151\162\145\x63\x74\x5f\164\157"]);
        qW:
        if (!is_user_logged_in()) {
            goto d0;
        }
        if (!empty($bU)) {
            goto Cm;
        }
        header("\x4c\x6f\143\x61\x74\151\157\156\72\x20" . home_url());
        goto GK;
        Cm:
        header("\x4c\157\x63\141\164\151\x6f\x6e\72\40" . $bU);
        GK:
        die;
        d0:
        if (!(get_option("\x6d\x6f\x5f\x73\x61\155\154\x5f\x65\156\141\142\x6c\x65\137\x6c\157\147\x69\156\x5f\162\145\144\151\162\x65\x63\164") == "\164\162\x75\x65")) {
            goto Or1;
        }
        $db = get_option("\155\157\137\163\141\x6d\154\137\x62\141\x63\x6b\144\x6f\x6f\x72\x5f\x75\162\154") ? trim(get_option("\155\157\x5f\163\141\155\x6c\x5f\142\141\143\x6b\144\x6f\x6f\x72\137\x75\162\x6c")) : "\146\x61\x6c\x73\145";
        if (isset($_GET["\154\x6f\x67\147\x65\x64\157\x75\164"]) && $_GET["\154\x6f\x67\x67\x65\x64\157\x75\x74"] == "\x74\x72\165\x65") {
            goto dI;
        }
        if (get_option("\x6d\157\x5f\163\x61\155\154\137\141\x6c\154\x6f\167\137\167\160\137\163\x69\147\x6e\x69\x6e") == "\x74\x72\165\145") {
            goto LP;
        }
        goto J3;
        dI:
        header("\x4c\157\143\141\x74\151\157\x6e\x3a\x20" . home_url());
        die;
        goto J3;
        LP:
        if (isset($_GET["\163\141\155\x6c\x5f\x73\x73\x6f"]) && $_GET["\163\141\155\154\137\x73\163\157"] == $db || isset($_POST["\x73\141\155\154\x5f\163\163\157"]) && $_POST["\x73\141\x6d\154\x5f\x73\x73\x6f"] == $db) {
            goto jb;
        }
        if (isset($_REQUEST["\162\145\x64\x69\x72\145\x63\x74\x5f\x74\x6f"])) {
            goto xb;
        }
        goto Fv;
        jb:
        return;
        goto Fv;
        xb:
        $bU = htmlspecialchars($_REQUEST["\162\x65\144\151\x72\x65\143\x74\137\x74\x6f"]);
        if (!(strpos($bU, "\167\160\x2d\141\144\155\x69\x6e") !== false && strpos($bU, "\x73\141\x6d\154\x5f\x73\163\x6f\75" . $db) !== false)) {
            goto qq;
        }
        return;
        qq:
        Fv:
        J3:
        $this->mo_saml_redirect_for_authentication($bU);
        Or1:
    }
    function mo_saml_auto_redirect()
    {
        if (!current_user_can("\162\x65\x61\x64")) {
            goto h2;
        }
        return;
        h2:
        if (!(get_option("\155\157\137\x73\141\x6d\154\x5f\x72\x65\147\x69\x73\164\x65\x72\145\144\x5f\157\156\154\171\x5f\x61\x63\x63\145\x73\163") == "\x74\162\x75\x65")) {
            goto w8;
        }
        if (!(get_option("\155\157\x5f\163\141\155\x6c\x5f\x65\x6e\141\142\x6c\x65\x5f\x72\163\x73\x5f\x61\143\x63\145\x73\163") == "\x74\x72\165\x65" && is_feed())) {
            goto Yr;
        }
        return;
        Yr:
        $ml = saml_get_current_page_url();
        $this->mo_saml_redirect_for_authentication($ml);
        w8:
    }
    function mo_saml_modify_login_form()
    {
        $db = get_option("\155\x6f\137\x73\x61\155\x6c\137\142\141\143\x6b\144\157\x6f\162\x5f\x75\162\154") ? trim(get_option("\155\x6f\x5f\163\x61\x6d\x6c\x5f\142\141\143\x6b\144\x6f\157\162\x5f\x75\x72\x6c")) : "\146\x61\154\x73\x65";
        echo "\74\151\x6e\160\x75\164\x20\x74\171\x70\145\75\x22\x68\x69\144\x64\x65\156\x22\x20\156\x61\x6d\x65\75\42\x73\x61\x6d\x6c\x5f\x73\163\x6f\42\x20\x76\141\x6c\x75\x65\x3d\42" . $db . "\42\x3e" . "\xa";
    }
    function djkasjdksa()
    {
        $dq = "\41\176\x40\43\44\x25\136\x26\52\x28\51\137\53\174\x7b\175\74\76\x3f\x30\61\62\x33\x34\x35\x36\67\x38\71\x61\142\x63\x64\145\x66\x67\x68\x69\x6a\x6b\154\x6d\x6e\157\160\x71\162\163\164\165\x76\167\x78\171\x7a\101\102\103\104\105\x46\107\x48\111\112\113\x4c\115\116\117\120\121\122\123\x54\x55\x56\x57\130\131\132";
        $EF = strlen($dq);
        $As = '';
        $LH = 0;
        vV:
        if (!($LH < 10000)) {
            goto ui;
        }
        $As .= $dq[rand(0, $EF - 1)];
        gb:
        $LH++;
        goto vV;
        ui:
        return $As;
    }
    function mo_get_saml_shortcode()
    {
        if (!is_user_logged_in()) {
            goto EH;
        }
        $current_user = wp_get_current_user();
        $Oc = "\x48\145\154\x6c\x6f\x2c";
        if (!get_option("\155\157\137\163\141\155\154\137\x63\165\163\x74\x6f\155\137\x67\x72\x65\x65\x74\x69\156\x67\x5f\164\145\x78\164")) {
            goto Ws;
        }
        $Oc = get_option("\155\157\137\x73\x61\x6d\x6c\x5f\x63\165\x73\x74\x6f\x6d\137\147\162\145\x65\164\x69\156\147\x5f\164\x65\x78\164");
        Ws:
        $xl = '';
        if (!get_option("\x6d\157\x5f\x73\141\155\x6c\x5f\x67\162\145\x65\x74\151\x6e\x67\137\156\141\x6d\x65")) {
            goto aY;
        }
        switch (get_option("\155\x6f\x5f\x73\x61\155\x6c\x5f\x67\162\145\145\164\x69\x6e\x67\137\x6e\x61\155\x65")) {
            case "\x55\123\x45\122\116\101\x4d\105":
                $xl = $current_user->user_login;
                goto Gn;
            case "\105\x4d\x41\x49\x4c":
                $xl = $current_user->user_email;
                goto Gn;
            case "\106\x4e\x41\115\105":
                $xl = $current_user->user_firstname;
                goto Gn;
            case "\x4c\116\101\x4d\105":
                $xl = $current_user->user_lastname;
                goto Gn;
            case "\106\116\101\x4d\x45\x5f\x4c\x4e\x41\115\x45":
                $xl = $current_user->user_firstname . "\x20" . $current_user->user_lastname;
                goto Gn;
            case "\114\116\x41\115\x45\x5f\x46\116\101\115\105":
                $xl = $current_user->user_lastname . "\40" . $current_user->user_firstname;
                goto Gn;
            default:
                $xl = $current_user->user_login;
        }
        Ji:
        Gn:
        aY:
        if (!empty(trim($xl))) {
            goto P1;
        }
        $xl = $current_user->user_login;
        P1:
        $i5 = $Oc . "\40" . $xl;
        $gG = "\x4c\x6f\x67\x6f\x75\164";
        if (!get_option("\155\157\x5f\x73\x61\x6d\x6c\137\143\x75\163\x74\x6f\x6d\137\x6c\157\x67\x6f\x75\164\x5f\x74\145\170\164")) {
            goto sH;
        }
        $gG = get_option("\x6d\x6f\x5f\163\x61\x6d\x6c\137\x63\165\163\x74\157\x6d\137\x6c\x6f\147\157\165\164\137\x74\145\x78\x74");
        sH:
        $rV = $i5 . "\40\x7c\40\x3c\141\x20\150\x72\x65\146\x3d\x22" . wp_logout_url(home_url()) . "\x22\40\x74\151\164\x6c\145\x3d\42\x6c\x6f\x67\x6f\x75\x74\x22\x20\x3e" . $gG . "\74\57\x61\x3e\74\57\154\x69\x3e";
        $Q2 = saml_get_current_page_url();
        update_option("\154\157\147\x6f\x75\164\x5f\162\x65\144\151\162\x65\143\x74\x5f\x75\x72\154", $Q2);
        goto vH;
        EH:
        $Ko = get_option("\x6d\157\x5f\x73\141\x6d\154\137\163\160\137\142\141\163\x65\x5f\165\x72\154");
        if (!empty($Ko)) {
            goto EN;
        }
        $Ko = home_url();
        EN:
        if (mo_saml_is_sp_configured() && mo_saml_is_customer_license_key_verified()) {
            goto vA;
        }
        $rV = "\123\x50\40\x69\163\40\156\157\x74\40\143\157\x6e\x66\x69\147\165\162\x65\144\x2e";
        goto J8;
        vA:
        $EW = "\x4c\x6f\147\x69\156\x20\167\151\x74\x68\40" . get_option("\x73\x61\x6d\154\x5f\151\x64\x65\x6e\x74\151\x74\x79\137\156\x61\155\x65");
        if (!get_option("\155\157\x5f\163\141\x6d\154\x5f\x63\165\x73\x74\x6f\x6d\137\x6c\157\147\x69\156\137\x74\x65\x78\x74")) {
            goto lk;
        }
        $EW = get_option("\155\x6f\137\x73\141\155\x6c\x5f\x63\165\x73\164\x6f\155\x5f\x6c\x6f\x67\x69\x6e\x5f\x74\x65\170\164");
        lk:
        $dg = get_option("\x73\141\155\154\x5f\151\144\x65\x6e\164\x69\164\x79\x5f\x6e\x61\155\145");
        $EW = str_replace("\43\x23\111\104\x50\43\43", $dg, $EW);
        $bU = urlencode(saml_get_current_page_url());
        $rV = "\74\x61\40\x68\x72\x65\x66\x3d\x22" . $Ko . "\x2f\77\157\160\x74\151\157\x6e\x3d\163\x61\x6d\x6c\x5f\x75\163\145\162\137\154\157\147\x69\156\46\x72\145\x64\x69\162\x65\143\164\x5f\x74\157\75" . $bU . "\x22\76" . $EW . "\x3c\x2f\141\x3e";
        J8:
        vH:
        return $rV;
    }
    function _handle_upload_metadata()
    {
        if (!(isset($_FILES["\x6d\x65\164\x61\144\141\164\141\x5f\146\151\x6c\x65"]) || isset($_POST["\155\145\164\x61\x64\141\164\141\x5f\x75\x72\x6c"]))) {
            goto Ed;
        }
        if (!empty($_FILES["\155\x65\164\x61\x64\x61\x74\141\137\x66\151\154\x65"]["\x74\x6d\160\x5f\x6e\x61\155\145"])) {
            goto b9;
        }
        if (mo_saml_is_extension_installed("\143\165\162\154")) {
            goto tk;
        }
        update_option("\155\157\x5f\163\x61\x6d\154\x5f\x6d\x65\163\163\141\147\145", "\120\110\120\x20\143\125\122\114\40\145\170\164\145\156\x73\x69\x6f\x6e\x20\x69\x73\40\156\157\164\x20\x69\x6e\x73\164\x61\154\154\145\144\x20\x6f\x72\40\x64\151\163\x61\142\x6c\x65\x64\56\x20\x43\x61\x6e\156\x6f\x74\x20\146\x65\x74\143\150\40\x6d\145\x74\141\x64\141\x74\x61\40\x66\x72\x6f\155\x20\125\x52\114\56");
        $this->mo_saml_show_error_message();
        return;
        tk:
        $Q2 = filter_var(htmlspecialchars($_POST["\155\x65\164\141\x64\141\164\x61\x5f\x75\162\x6c"]), FILTER_SANITIZE_URL);
        $HG = SAMLSPUtilities::mo_saml_wp_remote_call($Q2, array("\x73\163\154\x76\x65\162\x69\x66\x79" => false), true);
        if (!is_null($HG)) {
            goto Ru;
        }
        $wz = null;
        goto AQ;
        Ru:
        $wz = $HG;
        AQ:
        goto W7;
        b9:
        $wz = @file_get_contents($_FILES["\x6d\145\164\141\x64\x61\x74\x61\137\x66\151\154\x65"]["\164\155\x70\x5f\156\141\155\x65"]);
        W7:
        if (!is_null($wz)) {
            goto So;
        }
        update_option("\155\157\137\x73\141\155\x6c\137\155\x65\x73\x73\x61\147\x65", "\111\x6e\166\141\x6c\x69\x64\40\x4d\145\x74\x61\x64\x61\x74\x61\x20\106\151\154\x65\40\x6f\x72\x20\125\x52\114");
        return;
        goto eL;
        So:
        $this->upload_metadata($wz);
        eL:
        Ed:
    }
    function upload_metadata($wz)
    {
        $Nl = set_error_handler(array($this, "\x68\x61\x6e\144\x6c\145\130\155\x6c\105\x72\162\157\x72"));
        $PG = new DOMDocument();
        $PG->loadXML($wz);
        restore_error_handler();
        $F8 = $PG->firstChild;
        if (!empty($F8)) {
            goto av;
        }
        if (!empty($_FILES["\155\x65\x74\141\144\141\164\141\x5f\146\151\x6c\145"]["\164\x6d\x70\137\156\x61\155\x65"])) {
            goto I_;
        }
        if (!empty($_POST["\155\145\164\x61\144\141\164\x61\137\x75\x72\154"])) {
            goto S4;
        }
        update_option("\x6d\x6f\x5f\x73\x61\155\x6c\x5f\x6d\145\163\x73\141\x67\x65", "\x50\154\145\141\163\x65\40\160\162\x6f\x76\x69\144\145\40\x61\40\x76\x61\x6c\151\144\x20\x6d\x65\x74\141\x64\x61\x74\x61\x20\146\x69\x6c\145\40\x6f\162\40\x61\40\166\x61\154\x69\x64\x20\125\122\114\x2e");
        $this->mo_saml_show_error_message();
        return;
        goto y3;
        S4:
        update_option("\155\157\137\163\141\155\154\137\x6d\x65\x73\163\x61\147\x65", "\x50\x6c\145\141\163\145\40\x70\x72\157\x76\151\144\145\x20\x61\x20\166\x61\x6c\151\x64\40\155\145\x74\141\144\x61\164\141\40\x55\x52\114\x2e");
        $this->mo_saml_show_error_message();
        return;
        y3:
        goto wY;
        I_:
        update_option("\x6d\157\x5f\163\x61\155\154\137\x6d\145\163\x73\x61\x67\145", "\120\154\x65\x61\x73\x65\x20\x70\x72\x6f\x76\x69\144\x65\40\x61\40\x76\141\154\x69\144\40\155\145\x74\x61\144\x61\x74\x61\x20\x66\151\154\x65\56");
        $this->mo_saml_show_error_message();
        return;
        wY:
        goto wm;
        av:
        $Am = new IDPMetadataReader($PG);
        $ed = $Am->getIdentityProviders();
        if (!(empty($ed) && !empty($_FILES["\x6d\x65\164\141\x64\141\164\141\137\x66\151\x6c\145"]["\164\x6d\x70\137\x6e\141\155\x65"]))) {
            goto aW;
        }
        update_option("\155\x6f\x5f\163\x61\x6d\x6c\x5f\155\145\x73\163\141\x67\145", "\120\154\x65\x61\x73\x65\x20\160\162\157\166\151\144\x65\40\x61\40\166\141\x6c\x69\144\x20\155\145\x74\x61\144\141\x74\x61\40\146\151\x6c\x65\x2e");
        $this->mo_saml_show_error_message();
        return;
        aW:
        if (!(empty($ed) && !empty($_POST["\x6d\x65\164\141\x64\x61\x74\141\137\165\162\x6c"]))) {
            goto z0;
        }
        update_option("\x6d\x6f\x5f\163\141\x6d\154\137\x6d\145\x73\x73\141\x67\x65", "\x50\x6c\x65\141\x73\x65\x20\160\x72\x6f\x76\151\144\145\x20\141\x20\x76\141\154\151\x64\x20\x6d\145\x74\141\144\141\164\x61\40\125\x52\114\56");
        $this->mo_saml_show_error_message();
        return;
        z0:
        foreach ($ed as $uZ => $KC) {
            $Ov = htmlspecialchars($_POST["\163\141\x6d\x6c\x5f\x69\x64\145\x6e\164\151\164\x79\x5f\155\145\x74\141\x64\x61\164\141\x5f\x70\x72\x6f\166\151\144\145\162"]);
            $nJ = "\110\x74\164\160\x52\x65\x64\151\162\145\143\x74";
            $yK = '';
            if (array_key_exists("\110\124\x54\x50\x2d\122\145\x64\151\x72\145\143\164", $KC->getLoginDetails())) {
                goto M4;
            }
            if (!array_key_exists("\x48\x54\124\120\55\120\117\123\124", $KC->getLoginDetails())) {
                goto zC;
            }
            $nJ = "\110\164\x74\160\x50\157\163\x74";
            $yK = $KC->getLoginURL("\x48\x54\124\x50\x2d\x50\x4f\x53\124");
            zC:
            goto Pw;
            M4:
            $yK = $KC->getLoginURL("\x48\124\x54\120\x2d\x52\145\144\x69\162\145\x63\x74");
            Pw:
            $xM = "\110\x74\x74\x70\x52\x65\x64\151\x72\145\x63\164";
            $je = '';
            if (array_key_exists("\110\x54\x54\120\x2d\x52\x65\144\x69\x72\145\x63\x74", $KC->getLogoutDetails())) {
                goto CC;
            }
            if (!array_key_exists("\110\x54\x54\120\x2d\120\x4f\x53\x54", $KC->getLogoutDetails())) {
                goto dk;
            }
            $xM = "\110\164\164\x70\120\157\163\164";
            $je = $KC->getLogoutURL("\110\124\x54\120\x2d\120\117\123\x54");
            dk:
            goto mL;
            CC:
            $je = $KC->getLogoutURL("\x48\x54\x54\x50\55\122\145\x64\x69\162\x65\x63\164");
            mL:
            $xQ = $KC->getEntityID();
            $tV = $KC->getSigningCertificate();
            update_option("\163\x61\x6d\154\137\x69\x64\145\156\x74\x69\164\171\x5f\x6e\x61\155\x65", $Ov);
            update_option("\163\x61\155\x6c\137\154\x6f\x67\x69\156\x5f\142\x69\x6e\x64\151\156\x67\137\164\171\160\145", $nJ);
            update_option("\163\x61\155\154\x5f\x6c\x6f\x67\x69\156\x5f\165\x72\154", $yK);
            update_option("\x73\141\155\x6c\x5f\154\157\147\157\x75\164\137\x62\x69\x6e\144\151\156\x67\x5f\x74\171\x70\145", $xM);
            update_option("\x73\x61\x6d\154\x5f\x6c\157\x67\157\165\x74\137\x75\x72\x6c", $je);
            update_option("\x73\141\x6d\x6c\x5f\x69\163\x73\165\x65\162", $xQ);
            update_option("\x73\x61\155\x6c\137\156\x61\x6d\x65\151\144\137\146\x6f\162\155\x61\164", "\x31\x2e\x31\x3a\x6e\x61\x6d\145\x69\x64\x2d\146\x6f\x72\155\x61\x74\72\x75\x6e\x73\160\145\143\x69\146\151\x65\x64");
            update_option("\163\x61\x6d\154\x5f\x78\65\x30\71\137\143\x65\x72\x74\151\x66\151\x63\x61\x74\145", maybe_serialize($tV));
            goto xj;
            KL:
        }
        xj:
        update_option("\x6d\157\x5f\163\141\x6d\154\x5f\x6d\x65\x73\163\141\x67\145", "\111\144\145\156\x74\151\164\x79\x20\120\x72\x6f\x76\x69\144\145\162\40\144\145\164\141\x69\x6c\163\40\x73\x61\x76\x65\144\x20\x73\165\143\143\x65\163\163\146\165\x6c\x6c\x79\x2e");
        $this->mo_saml_show_success_message();
        wm:
    }
    function handleXmlError($tO, $bF, $Kd, $o8)
    {
        if ($tO == E_WARNING && substr_count($bF, "\x44\x4f\x4d\104\x6f\x63\x75\155\x65\x6e\x74\72\x3a\154\157\x61\144\x58\x4d\x4c\x28\51") > 0) {
            goto R3;
        }
        return false;
        goto gn;
        R3:
        return;
        gn:
    }
    function mo_saml_plugin_action_links($m7)
    {
        $m7 = array_merge(array("\74\x61\x20\x68\x72\x65\x66\x3d\x22" . esc_url(admin_url("\141\144\155\151\x6e\56\x70\x68\x70\77\160\x61\x67\x65\75\x6d\157\137\x73\141\155\x6c\137\163\x65\164\x74\151\156\x67\x73")) . "\x22\76" . __("\x53\145\x74\x74\x69\x6e\147\x73", "\164\145\170\164\x64\157\155\141\x69\156") . "\74\57\141\x3e"), $m7);
        return $m7;
    }
    function checkPasswordPattern($Sc)
    {
        $b5 = "\x2f\x5e\133\x28\x5c\x77\51\x2a\x28\x5c\41\x5c\x40\134\x23\134\x24\x5c\x25\x5c\x5e\x5c\x26\x5c\x2a\134\56\x5c\x2d\134\137\x29\x2a\x5d\53\44\x2f";
        return !preg_match($b5, $Sc);
    }
}
new saml_mo_login();
