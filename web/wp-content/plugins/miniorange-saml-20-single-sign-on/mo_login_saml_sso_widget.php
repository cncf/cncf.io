<?php


include_once dirname(__FILE__) . "\57\125\x74\151\x6c\x69\x74\x69\145\163\56\x70\x68\x70";
include_once dirname(__FILE__) . "\x2f\x52\x65\163\x70\157\x6e\163\x65\56\160\150\x70";
include_once "\170\x6d\x6c\163\x65\143\154\151\x62\163\56\x70\x68\160";
use RobRichards\XMLSecLibs\XMLSecurityKey;
use RobRichards\XMLSecLibs\XMLSecurityDSig;
use RobRichards\XMLSecLibs\XMLSecEnc;
if (class_exists("\101\105\x53\x45\x6e\x63\x72\171\x70\x74\x69\157\x6e")) {
    goto zP;
}
require_once dirname(__FILE__) . "\57\x69\x6e\143\154\x75\144\145\x73\57\154\x69\142\x2f\x65\156\143\x72\171\160\x74\x69\x6f\x6e\56\160\x68\x70";
zP:
class mo_login_wid extends WP_Widget
{
    public function __construct()
    {
        $jS = get_option("\x73\x61\x6d\x6c\137\x69\x64\145\156\164\151\164\171\x5f\156\141\x6d\x65");
        parent::__construct("\123\x61\x6d\154\137\114\157\x67\151\156\137\127\x69\x64\147\x65\164", "\x4c\x6f\x67\151\x6e\x20\167\151\x74\x68\40" . $jS, array("\144\145\163\x63\x72\x69\160\x74\x69\157\x6e" => __("\124\150\x69\x73\x20\151\x73\40\x61\40\155\151\x6e\151\117\x72\x61\x6e\x67\145\x20\123\101\115\114\x20\154\157\147\151\x6e\40\167\x69\144\147\145\x74\56", "\155\x6f\x73\x61\155\x6c")));
    }
    public function widget($Gf, $ts)
    {
        extract($Gf);
        $QI = apply_filters("\x77\151\x64\x67\x65\x74\x5f\164\x69\x74\x6c\x65", $ts["\167\x69\x64\137\164\x69\164\154\145"]);
        echo $Gf["\142\x65\146\x6f\162\x65\x5f\x77\x69\144\x67\x65\x74"];
        if (empty($QI)) {
            goto zo;
        }
        echo $Gf["\x62\145\x66\x6f\x72\x65\x5f\x74\x69\x74\154\145"] . $QI . $Gf["\141\x66\x74\x65\x72\x5f\x74\x69\x74\154\x65"];
        zo:
        $this->loginForm();
        echo $Gf["\141\146\x74\145\x72\137\x77\x69\144\147\145\x74"];
    }
    public function update($dv, $qT)
    {
        $ts = array();
        $ts["\167\151\144\137\x74\x69\164\154\x65"] = strip_tags($dv["\167\x69\144\137\x74\x69\164\x6c\x65"]);
        return $ts;
    }
    public function form($ts)
    {
        $QI = '';
        if (!array_key_exists("\x77\151\144\x5f\x74\x69\164\x6c\x65", $ts)) {
            goto Lv;
        }
        $QI = $ts["\167\x69\x64\137\x74\151\x74\x6c\x65"];
        Lv:
        echo "\15\12\x9\11\x3c\x70\x3e\x3c\x6c\x61\142\145\x6c\40\146\157\162\75\x22" . $this->get_field_id("\167\x69\x64\x5f\164\x69\164\x6c\145") . "\x20\x22\76" . _e("\x54\151\164\x6c\x65\x3a") . "\x20\x3c\x2f\x6c\141\x62\x65\x6c\76\xd\12\x9\11\x3c\x69\x6e\x70\x75\164\40\143\x6c\x61\x73\163\75\42\167\151\x64\x65\146\x61\164\42\x20\x69\x64\75\x22" . $this->get_field_id("\167\151\x64\x5f\164\x69\164\154\145") . "\42\x20\156\x61\155\x65\75\42" . $this->get_field_name("\167\151\x64\x5f\164\151\x74\x6c\x65") . "\42\40\x74\171\160\x65\75\x22\164\145\170\x74\42\40\x76\x61\154\165\x65\x3d\42" . $QI . "\x22\40\x2f\76\15\xa\11\x9\74\57\x70\x3e";
    }
    public function loginForm()
    {
        if (!is_user_logged_in()) {
            goto Tq;
        }
        $current_user = wp_get_current_user();
        $Oc = "\110\x65\x6c\154\157\54";
        if (!get_option("\155\157\137\163\141\x6d\x6c\x5f\x63\165\163\164\x6f\x6d\x5f\x67\x72\145\145\x74\x69\x6e\x67\137\x74\x65\170\x74")) {
            goto n2;
        }
        $Oc = get_option("\x6d\x6f\137\163\x61\x6d\x6c\137\143\165\x73\164\x6f\155\x5f\x67\x72\x65\145\x74\151\156\x67\x5f\164\x65\x78\164");
        n2:
        $xl = '';
        if (!get_option("\155\157\137\163\141\x6d\154\x5f\147\x72\145\x65\x74\x69\x6e\147\x5f\156\x61\155\145")) {
            goto oO;
        }
        switch (get_option("\155\x6f\x5f\163\141\155\x6c\x5f\147\x72\145\145\x74\151\x6e\147\137\156\x61\x6d\145")) {
            case "\x55\123\105\x52\x4e\x41\x4d\x45":
                $xl = $current_user->user_login;
                goto E8;
            case "\x45\x4d\x41\111\114":
                $xl = $current_user->user_email;
                goto E8;
            case "\106\x4e\101\x4d\x45":
                $xl = $current_user->user_firstname;
                goto E8;
            case "\x4c\x4e\101\x4d\x45":
                $xl = $current_user->user_lastname;
                goto E8;
            case "\106\116\x41\x4d\105\x5f\x4c\x4e\101\x4d\x45":
                $xl = $current_user->user_firstname . "\40" . $current_user->user_lastname;
                goto E8;
            case "\x4c\116\x41\115\105\x5f\106\116\x41\115\105":
                $xl = $current_user->user_lastname . "\40" . $current_user->user_firstname;
                goto E8;
            default:
                $xl = $current_user->user_login;
        }
        Xr:
        E8:
        oO:
        if (!empty(trim($xl))) {
            goto Gi;
        }
        $xl = $current_user->user_login;
        Gi:
        $i5 = $Oc . "\x20" . $xl;
        $gG = "\114\x6f\147\x6f\x75\x74";
        if (!get_option("\155\157\137\x73\x61\155\154\x5f\143\165\163\164\x6f\x6d\x5f\x6c\x6f\147\157\165\x74\137\164\145\x78\164")) {
            goto M0;
        }
        $gG = get_option("\155\157\137\163\x61\x6d\x6c\x5f\143\165\x73\x74\157\x6d\137\x6c\x6f\x67\x6f\x75\164\137\164\145\170\x74");
        M0:
        echo $i5 . "\x20\x7c\40\x3c\x61\x20\150\x72\145\146\75\x22" . wp_logout_url(home_url()) . "\x22\x20\x74\151\164\x6c\145\75\42\x6c\x6f\x67\x6f\x75\x74\42\x20\x3e" . $gG . "\74\x2f\x61\76\74\57\154\151\x3e";
        $Q2 = saml_get_current_page_url();
        update_option("\x6c\x6f\147\x6f\165\x74\x5f\162\x65\144\151\162\x65\143\x74\x5f\165\162\154", $Q2);
        goto fW;
        Tq:
        $bU = saml_get_current_page_url();
        echo "\xd\12\x9\11\74\x73\x63\x72\151\x70\164\x3e\15\xa\x9\11\146\x75\156\143\164\x69\x6f\156\40\163\x75\142\x6d\151\164\x53\141\x6d\154\x46\x6f\x72\x6d\x28\51\x7b\40\x64\x6f\x63\x75\x6d\x65\156\164\56\147\145\164\105\x6c\145\155\145\x6e\x74\x42\x79\x49\144\50\42\155\151\x6e\151\x6f\162\141\156\x67\145\55\163\141\155\154\55\163\x70\x2d\x73\x73\x6f\55\154\157\147\x69\156\x2d\146\157\162\x6d\42\x29\56\163\x75\142\155\151\x74\x28\x29\73\x20\175\xd\12\x9\11\74\57\163\x63\x72\151\160\x74\76\xd\12\x9\11\74\x66\x6f\162\155\40\x6e\141\x6d\145\x3d\x22\x6d\x69\156\151\x6f\x72\x61\156\x67\x65\x2d\163\x61\x6d\x6c\x2d\163\x70\55\x73\163\x6f\55\154\157\x67\151\156\55\146\157\162\x6d\42\x20\151\144\75\42\x6d\x69\156\x69\x6f\162\141\x6e\147\x65\55\163\x61\155\154\55\x73\160\55\163\163\x6f\x2d\x6c\x6f\x67\x69\156\55\x66\x6f\162\x6d\x22\x20\x6d\x65\164\150\x6f\x64\75\42\160\x6f\x73\x74\x22\x20\x61\143\x74\151\157\x6e\75\x22\42\x3e\15\12\x9\x9\x3c\151\x6e\160\x75\x74\x20\x74\171\x70\145\x3d\42\150\151\144\144\x65\156\42\x20\x6e\x61\x6d\x65\75\x22\157\160\164\151\x6f\156\42\x20\166\141\x6c\165\x65\x3d\x22\x73\141\155\x6c\x5f\165\x73\x65\162\137\x6c\x6f\147\x69\156\42\x20\x2f\76\xd\12\11\11\x3c\151\156\x70\x75\x74\40\164\x79\x70\145\75\x22\x68\x69\x64\x64\x65\x6e\42\x20\x6e\x61\x6d\145\x3d\42\162\x65\x64\151\x72\145\143\x74\x5f\x74\x6f\x22\x20\166\x61\154\165\145\75\42" . $bU . "\x22\x20\x2f\x3e\xd\12\15\xa\11\11\74\x66\157\156\x74\40\x73\x69\x7a\145\75\x22\53\61\x22\x20\163\164\171\154\145\x3d\x22\166\x65\x72\164\151\143\x61\154\55\x61\x6c\x69\x67\x6e\72\164\157\160\x3b\x22\76\x20\x3c\x2f\x66\x6f\156\164\x3e";
        $dg = get_option("\x73\141\155\154\x5f\151\x64\x65\156\164\x69\x74\171\x5f\x6e\141\155\145");
        if (!empty($dg)) {
            goto bg;
        }
        echo "\x50\154\145\141\163\145\x20\x63\157\x6e\146\151\x67\x75\162\145\x20\x74\150\145\x20\x6d\151\x6e\x69\117\x72\141\x6e\147\145\40\123\x41\115\x4c\x20\120\x6c\165\147\151\156\x20\x66\x69\162\x73\164\x2e";
        goto Vt;
        bg:
        $UK = "\x4c\x6f\x67\151\x6e\40\x77\151\164\x68\40\43\43\111\x44\x50\x23\43";
        if (!get_option("\155\x6f\137\163\141\x6d\x6c\137\143\165\163\x74\x6f\155\137\154\x6f\147\x69\156\137\x74\145\x78\x74")) {
            goto Z8;
        }
        $UK = get_option("\x6d\157\x5f\163\141\155\x6c\x5f\143\165\163\x74\157\x6d\x5f\154\x6f\147\x69\156\137\164\145\170\164");
        Z8:
        $UK = str_replace("\x23\43\111\x44\120\x23\43", $dg, $UK);
        echo "\x3c\x61\x20\150\162\x65\146\x3d\42\43\42\40\157\x6e\x43\154\x69\143\153\x3d\42\163\165\142\x6d\151\x74\x53\x61\x6d\x6c\106\x6f\x72\x6d\50\51\x22\x3e" . $UK . "\74\57\x61\x3e\74\57\146\157\162\x6d\76";
        Vt:
        if ($this->mo_saml_check_empty_or_null_val(get_option("\x6d\157\x5f\x73\141\x6d\154\x5f\162\145\x64\151\x72\x65\x63\x74\x5f\x65\x72\x72\x6f\x72\x5f\x63\157\144\x65"))) {
            goto c0;
        }
        echo "\x3c\x64\x69\166\76\74\57\x64\151\x76\76\74\x64\x69\166\40\164\x69\164\154\145\x3d\x22\114\157\x67\x69\x6e\40\105\162\x72\157\162\42\x3e\x3c\x66\x6f\156\164\40\143\157\154\157\x72\75\x22\x72\145\144\42\x3e\127\x65\40\x63\157\x75\154\x64\x20\x6e\x6f\x74\x20\163\x69\147\x6e\x20\171\x6f\165\40\151\x6e\56\x20\x50\154\x65\x61\163\145\40\x63\157\x6e\x74\x61\143\x74\x20\171\157\165\162\x20\x41\144\155\151\x6e\151\163\164\x72\141\164\x6f\162\56\x3c\x2f\146\157\x6e\x74\76\74\57\x64\x69\x76\x3e";
        delete_option("\x6d\x6f\137\163\141\155\154\137\162\x65\144\x69\162\145\143\x74\x5f\145\162\162\x6f\x72\137\143\157\x64\x65");
        delete_option("\x6d\157\137\163\x61\x6d\154\137\162\145\144\x69\x72\x65\x63\164\x5f\145\x72\x72\157\162\x5f\162\x65\x61\163\x6f\x6e");
        c0:
        echo "\x3c\141\x20\x68\162\145\x66\75\x22\x68\x74\x74\x70\x3a\57\57\x6d\151\x6e\151\157\162\141\x6e\x67\x65\56\143\157\155\57\167\x6f\162\144\x70\162\145\x73\163\55\x6c\x64\141\160\55\154\x6f\147\151\156\x22\x20\x73\x74\x79\154\145\x3d\x22\144\x69\x73\160\154\141\x79\72\156\x6f\156\x65\42\76\114\157\147\x69\x6e\x20\164\157\40\127\157\x72\144\120\x72\145\163\163\40\165\x73\151\x6e\147\x20\x4c\x44\101\x50\74\x2f\141\76\15\xa\x9\x9\74\x61\x20\150\162\145\146\x3d\x22\150\x74\164\160\72\x2f\x2f\155\x69\x6e\x69\x6f\162\141\x6e\147\145\56\143\157\155\x2f\143\154\157\x75\144\x2d\x69\x64\145\156\x74\x69\164\171\55\x62\x72\157\153\145\162\55\x73\x65\x72\166\x69\x63\145\x22\x20\163\x74\171\154\x65\x3d\42\x64\151\x73\x70\154\141\x79\72\156\157\156\x65\x22\76\103\x6c\x6f\165\x64\40\x49\144\x65\156\x74\151\x74\x79\x20\142\x72\157\x6b\145\162\40\x73\x65\162\x76\151\143\145\x3c\57\x61\x3e\xd\xa\x9\x9\74\141\40\x68\162\x65\x66\75\42\x68\164\x74\160\x3a\x2f\57\x6d\151\156\x69\157\162\x61\x6e\x67\145\x2e\x63\157\x6d\x2f\x73\164\x72\157\156\147\x5f\x61\165\164\x68\x22\40\x73\x74\171\154\145\x3d\42\144\x69\x73\x70\x6c\x61\x79\72\156\x6f\156\145\x3b\x22\76\x3c\57\141\76\xd\xa\11\x9\x3c\141\x20\x68\x72\x65\146\x3d\x22\x68\x74\x74\160\x3a\57\x2f\x6d\x69\x6e\x69\x6f\x72\141\x6e\x67\x65\x2e\143\x6f\x6d\57\163\151\156\147\x6c\145\55\x73\x69\147\156\55\x6f\156\55\x73\163\157\42\x20\163\x74\171\x6c\145\75\42\144\x69\163\160\x6c\x61\x79\72\x6e\x6f\x6e\145\x3b\x22\76\74\x2f\x61\x3e\xd\xa\x9\x9\74\141\x20\150\x72\x65\x66\x3d\x22\150\164\164\x70\x3a\x2f\x2f\x6d\x69\156\x69\x6f\162\x61\x6e\x67\145\x2e\143\157\x6d\x2f\x66\162\x61\x75\144\x22\40\163\x74\171\x6c\145\x3d\x22\x64\x69\163\160\154\141\171\72\x6e\x6f\x6e\x65\73\x22\x3e\74\57\x61\76\15\12\15\12\x9\11\x9\x3c\x2f\165\154\x3e\15\xa\11\x9\x3c\x2f\146\157\x72\155\76";
        fW:
    }
    public function mo_saml_check_empty_or_null_val($Ka)
    {
        if (!(!isset($Ka) || empty($Ka))) {
            goto Ab;
        }
        return true;
        Ab:
        return false;
    }
}
function mo_login_validate()
{
    if (!(isset($_REQUEST["\x6f\160\x74\x69\x6f\156"]) && $_REQUEST["\x6f\x70\x74\x69\x6f\x6e"] == "\x6d\157\x73\x61\155\154\x5f\155\145\164\x61\144\141\x74\141")) {
        goto Zy;
    }
    miniorange_generate_metadata();
    Zy:
    if (!(isset($_REQUEST["\157\x70\164\151\x6f\156"]) && $_REQUEST["\x6f\160\164\x69\x6f\x6e"] == "\145\170\x70\x6f\x72\164\137\x63\157\x6e\146\151\x67\x75\x72\x61\x74\151\x6f\x6e")) {
        goto ER;
    }
    if (!current_user_can("\x6d\141\156\x61\147\145\137\157\160\x74\151\x6f\x6e\163")) {
        goto fN1;
    }
    miniorange_import_export(true);
    fN1:
    die;
    ER:
    if (!mo_saml_is_customer_license_verified()) {
        goto p8;
    }
    if (!(isset($_REQUEST["\x6f\160\x74\151\157\156"]) && $_REQUEST["\157\160\x74\151\157\156"] == "\x73\141\155\154\x5f\165\163\145\162\x5f\x6c\157\147\151\x6e" || isset($_REQUEST["\157\x70\164\151\x6f\156"]) && $_REQUEST["\x6f\x70\x74\x69\157\x6e"] == "\x74\145\x73\164\x69\144\160\143\x6f\x6e\x66\151\147" || isset($_REQUEST["\157\x70\164\x69\157\x6e"]) && $_REQUEST["\157\x70\x74\x69\157\x6e"] == "\x67\x65\x74\x73\x61\155\154\162\x65\161\x75\x65\163\164" || isset($_REQUEST["\157\160\x74\x69\157\156"]) && $_REQUEST["\x6f\160\164\151\157\x6e"] == "\x67\x65\164\163\141\x6d\154\162\x65\163\x70\157\156\163\x65")) {
        goto ZJ;
    }
    if (!mo_saml_is_sp_configured()) {
        goto xr;
    }
    $Ko = get_option("\x6d\157\x5f\163\x61\155\154\x5f\x73\x70\x5f\142\141\x73\x65\137\165\162\x6c");
    if (!empty($Ko)) {
        goto II;
    }
    $Ko = home_url();
    II:
    if ($_REQUEST["\x6f\x70\164\151\x6f\156"] == "\164\x65\x73\164\151\144\x70\143\x6f\x6e\146\x69\147" and array_key_exists("\x6e\145\167\x63\145\x72\164", $_REQUEST)) {
        goto Lx;
    }
    if ($_REQUEST["\157\160\164\x69\x6f\156"] == "\164\x65\x73\164\151\144\x70\143\x6f\156\x66\x69\147") {
        goto m9;
    }
    if ($_REQUEST["\157\x70\164\x69\157\x6e"] == "\147\x65\164\x73\141\x6d\154\x72\145\x71\165\x65\163\x74") {
        goto hQ;
    }
    if ($_REQUEST["\x6f\160\164\x69\x6f\x6e"] == "\x67\x65\x74\163\x61\155\154\x72\145\163\x70\x6f\x6e\x73\145") {
        goto ym;
    }
    if (get_option("\x6d\x6f\137\x73\141\x6d\x6c\x5f\162\x65\154\141\171\137\x73\164\141\164\x65") && get_option("\x6d\x6f\137\163\141\155\x6c\137\162\145\154\x61\x79\137\163\164\141\164\145") != '') {
        goto Kk;
    }
    if (isset($_REQUEST["\162\x65\x64\151\x72\145\143\164\x5f\164\x6f"])) {
        goto Yh;
    }
    $KI = wp_get_referer();
    goto WH;
    Yh:
    $KI = htmlspecialchars($_REQUEST["\x72\145\x64\x69\162\145\143\164\x5f\x74\157"]);
    WH:
    goto QP;
    Kk:
    $KI = get_option("\155\x6f\x5f\163\x61\x6d\x6c\137\x72\145\154\x61\x79\x5f\x73\164\141\164\145");
    QP:
    goto Cb;
    ym:
    $KI = "\x64\x69\163\x70\x6c\x61\x79\x53\x41\x4d\114\x52\x65\x73\160\157\156\163\x65";
    Cb:
    goto yV;
    hQ:
    $KI = "\x64\151\x73\160\154\141\x79\123\x41\x4d\x4c\122\x65\161\x75\145\x73\x74";
    yV:
    goto l3;
    m9:
    $KI = "\164\x65\x73\164\x56\141\x6c\x69\144\x61\x74\145";
    l3:
    goto TU;
    Lx:
    $KI = "\x74\x65\x73\164\x4e\x65\x77\x43\x65\162\x74\151\146\x69\x63\141\164\x65";
    TU:
    if (!empty($KI)) {
        goto Ja;
    }
    $KI = $Ko;
    Ja:
    $c9 = get_option("\x73\141\155\x6c\x5f\x6c\x6f\147\151\156\137\x75\162\x6c");
    $ut = get_option("\163\141\155\154\x5f\x6c\x6f\147\151\156\137\x62\151\156\144\151\156\147\x5f\x74\x79\160\145");
    $Vb = get_option("\x6d\157\x5f\163\x61\x6d\154\137\146\x6f\162\143\x65\x5f\x61\165\164\150\145\156\164\151\143\141\x74\151\157\x6e");
    $pH = $Ko . "\57";
    $Eq = get_option("\155\x6f\137\163\141\155\154\x5f\163\160\137\x65\156\x74\x69\164\171\x5f\151\x64");
    if (!empty($Eq)) {
        goto Jy;
    }
    $Eq = $Ko . "\x2f\x77\x70\55\x63\x6f\x6e\164\x65\156\164\57\160\x6c\165\x67\x69\x6e\x73\57\x6d\151\156\151\157\162\141\156\147\x65\55\163\x61\x6d\x6c\55\x32\x30\x2d\163\151\x6e\147\x6c\x65\55\x73\151\147\x6e\x2d\x6f\x6e\x2f";
    Jy:
    $Ss = get_option("\163\x61\x6d\154\137\x6e\x61\x6d\145\151\144\137\146\x6f\x72\x6d\141\x74");
    if (!empty($Ss)) {
        goto yT;
    }
    $Ss = "\61\56\x31\x3a\x6e\141\x6d\x65\151\144\x2d\x66\x6f\x72\155\141\164\72\145\x6d\x61\151\x6c\x41\x64\x64\162\x65\x73\x73";
    yT:
    $oe = SAMLSPUtilities::createAuthnRequest($pH, $Eq, $c9, $Vb, $ut, $Ss);
    if (!($KI == "\144\x69\x73\160\x6c\141\171\123\x41\115\114\x52\x65\161\165\145\163\164")) {
        goto Nb;
    }
    mo_saml_show_SAML_log(SAMLSPUtilities::createAuthnRequest($pH, $Eq, $c9, $Vb, "\x48\x54\124\x50\x50\157\163\x74", $Ss), $KI);
    Nb:
    $QL = $c9;
    if (strpos($c9, "\77") !== false) {
        goto WR;
    }
    $QL .= "\x3f";
    goto eT;
    WR:
    $QL .= "\46";
    eT:
    cldjkasjdksalc();
    $KI = parse_url($KI, PHP_URL_PATH);
    $KI = empty($KI) ? "\x2f" : $KI;
    if (empty($ut) || $ut == "\110\164\x74\x70\x52\x65\x64\x69\x72\145\143\x74") {
        goto Cl;
    }
    if (!(empty(get_option("\x73\x61\155\x6c\137\162\x65\161\x75\145\163\164\137\x73\151\x67\x6e\x65\x64")) || get_option("\163\141\x6d\x6c\x5f\162\x65\x71\165\x65\x73\x74\137\x73\151\147\156\x65\144") == "\x75\156\143\x68\x65\143\153\145\144")) {
        goto IN;
    }
    $wu = base64_encode($oe);
    SAMLSPUtilities::postSAMLRequest($c9, $wu, $KI);
    die;
    IN:
    $V2 = '';
    $xD = '';
    if ($_REQUEST["\157\160\x74\x69\157\156"] == "\164\x65\163\164\151\144\x70\143\157\x6e\x66\x69\147" && array_key_exists("\x6e\145\x77\143\x65\x72\x74", $_REQUEST)) {
        goto cP;
    }
    $wu = SAMLSPUtilities::signXML($oe, "\116\141\x6d\145\111\104\x50\157\154\151\x63\171");
    goto R6;
    cP:
    $wu = SAMLSPUtilities::signXML($oe, "\116\x61\155\145\111\x44\x50\157\154\151\x63\x79", true);
    R6:
    SAMLSPUtilities::postSAMLRequest($c9, $wu, $KI);
    update_option("\155\x6f\x5f\163\141\x6d\x6c\137\156\145\x77\x5f\143\x65\x72\x74\x5f\164\145\x73\164", true);
    goto PN;
    Cl:
    if (!(empty(get_option("\163\x61\x6d\x6c\x5f\162\145\161\x75\145\163\164\x5f\x73\x69\147\x6e\145\144")) || get_option("\163\x61\155\154\137\162\x65\161\165\x65\163\x74\137\163\151\147\156\145\144") == "\x75\x6e\143\x68\x65\143\153\145\144")) {
        goto lw;
    }
    $QL .= "\123\101\115\x4c\122\x65\161\x75\145\163\164\75" . $oe . "\x26\x52\145\154\141\171\123\164\141\x74\145\75" . urlencode($KI);
    header("\114\x6f\x63\x61\164\x69\x6f\156\72\40" . $QL);
    die;
    lw:
    $oe = "\x53\x41\x4d\114\122\x65\x71\x75\x65\163\x74\75" . $oe . "\46\122\x65\x6c\141\x79\123\x74\141\x74\145\75" . urlencode($KI) . "\x26\123\151\x67\x41\154\147\75" . urlencode(XMLSecurityKey::RSA_SHA256);
    $nT = array("\x74\171\160\x65" => "\x70\x72\151\166\141\164\x65");
    $uZ = new XMLSecurityKey(XMLSecurityKey::RSA_SHA256, $nT);
    if ($_REQUEST["\157\160\164\x69\x6f\156"] == "\164\145\x73\x74\x69\144\x70\x63\x6f\156\x66\151\x67" && array_key_exists("\x6e\145\x77\x63\x65\162\x74", $_REQUEST)) {
        goto PY;
    }
    $wO = get_option("\155\x6f\137\163\x61\155\x6c\137\x63\165\x72\162\145\x6e\164\x5f\x63\x65\162\x74\137\x70\162\x69\166\x61\x74\145\x5f\153\x65\171");
    goto Vj;
    PY:
    $wO = file_get_contents(plugin_dir_path(__FILE__) . "\162\x65\x73\157\165\x72\x63\x65\163" . DIRECTORY_SEPARATOR . "\x6d\x69\156\151\157\162\x61\x6e\147\145\x5f\163\x70\137\62\x30\x32\x30\137\160\x72\x69\166\x2e\x6b\145\x79");
    Vj:
    $uZ->loadKey($wO, FALSE);
    $cG = new XMLSecurityDSig();
    $dZ = $uZ->signData($oe);
    $dZ = base64_encode($dZ);
    $QL .= $oe . "\x26\123\151\x67\156\x61\x74\165\162\145\x3d" . urlencode($dZ);
    header("\x4c\x6f\143\x61\x74\x69\157\156\72\x20" . $QL);
    die;
    PN:
    xr:
    ZJ:
    if (!(array_key_exists("\x53\x41\115\114\122\145\x73\160\157\156\x73\x65", $_REQUEST) && !empty($_REQUEST["\123\x41\115\114\x52\x65\163\x70\157\x6e\163\145"]))) {
        goto Y8;
    }
    if (array_key_exists("\122\145\154\141\x79\x53\164\x61\x74\x65", $_POST) && !empty($_POST["\x52\x65\x6c\x61\171\x53\x74\141\164\x65"]) && $_POST["\x52\145\x6c\x61\x79\x53\x74\x61\164\x65"] != "\57") {
        goto MQ;
    }
    $KH = '';
    goto Nv;
    MQ:
    $KH = htmlspecialchars($_POST["\122\x65\x6c\141\x79\123\x74\x61\164\145"]);
    Nv:
    $Ko = get_option("\155\x6f\137\x73\x61\x6d\154\x5f\163\160\x5f\142\141\x73\x65\x5f\165\x72\154");
    if (!empty($Ko)) {
        goto Zp;
    }
    $Ko = home_url();
    Zp:
    $FO = htmlspecialchars($_REQUEST["\123\101\115\x4c\122\145\x73\x70\x6f\156\x73\x65"]);
    $FO = base64_decode($FO);
    if (!($KH == "\144\x69\x73\160\x6c\141\171\123\x41\x4d\x4c\x52\145\x73\x70\157\x6e\163\x65")) {
        goto oa;
    }
    mo_saml_show_SAML_log($FO, $KH);
    oa:
    if (!(array_key_exists("\x53\x41\115\x4c\x52\x65\163\160\157\x6e\x73\x65", $_GET) && !empty($_GET["\x53\101\x4d\x4c\122\x65\163\x70\x6f\x6e\x73\x65"]))) {
        goto eq;
    }
    $FO = gzinflate($FO);
    eq:
    $PG = new DOMDocument();
    $PG->loadXML($FO);
    $da = $PG->firstChild;
    $wP = $PG->documentElement;
    $K_ = new DOMXpath($PG);
    $K_->registerNamespace("\x73\x61\x6d\154\160", "\165\162\156\x3a\x6f\141\x73\151\163\72\156\141\155\x65\163\x3a\164\x63\72\x53\101\115\x4c\x3a\62\56\x30\x3a\x70\162\x6f\164\157\x63\x6f\x6c");
    $K_->registerNamespace("\x73\x61\155\154", "\165\162\156\x3a\x6f\141\x73\151\x73\x3a\x6e\141\155\145\x73\x3a\x74\143\x3a\123\101\x4d\114\x3a\x32\x2e\60\72\x61\163\163\x65\162\x74\151\x6f\x6e");
    if ($da->localName == "\114\157\147\157\x75\x74\x52\145\163\160\157\x6e\163\145") {
        goto ff;
    }
    $WL = $K_->query("\x2f\x73\141\x6d\x6c\160\72\122\x65\x73\160\x6f\x6e\x73\x65\x2f\x73\141\155\x6c\160\72\x53\x74\x61\x74\165\163\x2f\x73\x61\155\x6c\160\x3a\x53\164\141\164\165\163\103\157\x64\145", $wP);
    $SW = $WL->item(0)->getAttribute("\126\x61\154\165\x65");
    $CS = $K_->query("\x2f\x73\x61\155\x6c\160\72\122\x65\x73\x70\157\x6e\x73\x65\x2f\163\x61\x6d\x6c\160\x3a\123\164\x61\164\165\x73\x2f\x73\141\x6d\x6c\x70\72\123\x74\x61\164\165\163\x4d\145\x73\163\x61\x67\145", $wP)->item(0);
    if (empty($CS)) {
        goto AO;
    }
    $CS = $CS->nodeValue;
    AO:
    $EK = explode("\72", $SW);
    $WL = $EK[7];
    if (array_key_exists("\x52\145\x6c\141\171\x53\x74\x61\164\145", $_POST) && !empty($_POST["\x52\145\154\x61\171\123\164\141\164\x65"]) && $_POST["\x52\145\x6c\141\171\123\164\x61\x74\145"] != "\x2f") {
        goto I0;
    }
    $KH = '';
    goto VU;
    I0:
    $KH = htmlspecialchars($_POST["\x52\145\154\x61\171\x53\x74\141\x74\x65"]);
    VU:
    if (!($WL != "\123\x75\x63\143\145\x73\x73")) {
        goto Wb;
    }
    show_status_error($WL, $KH, $CS);
    Wb:
    $ZA = maybe_unserialize(get_option("\163\141\155\154\137\170\65\60\x39\x5f\143\x65\x72\x74\x69\x66\151\143\141\164\x65"));
    $pH = $Ko . "\x2f";
    update_option("\x4d\117\x5f\123\x41\115\114\x5f\122\105\123\120\x4f\x4e\x53\x45", base64_encode($FO));
    if ($KH == "\164\145\163\x74\x4e\145\x77\x43\x65\x72\164\x69\146\151\x63\x61\x74\x65") {
        goto jq;
    }
    $FO = new SAML2SPResponse($da, get_option("\155\157\137\163\141\x6d\x6c\x5f\x63\x75\162\x72\x65\x6e\x74\137\x63\x65\x72\164\x5f\x70\x72\151\x76\x61\x74\145\x5f\x6b\x65\171"));
    goto YM;
    jq:
    $yD = file_get_contents(plugin_dir_path(__FILE__) . "\x72\x65\x73\157\165\x72\143\145\163" . DIRECTORY_SEPARATOR . "\155\151\x6e\151\x6f\162\141\156\147\x65\x5f\163\x70\137\x32\60\x32\60\x5f\160\162\151\166\x2e\x6b\145\171");
    $FO = new SAML2SPResponse($da, $yD);
    YM:
    $DG = $FO->getSignatureData();
    $TN = current($FO->getAssertions())->getSignatureData();
    if (!(empty($TN) && empty($DG))) {
        goto Ay;
    }
    if ($KH == "\x74\145\x73\x74\126\x61\x6c\151\x64\x61\164\145" or $KH == "\x74\145\163\164\x4e\x65\x77\x43\145\x72\164\x69\x66\151\143\141\x74\145") {
        goto WD;
    }
    wp_die("\127\x65\x20\143\x6f\165\x6c\144\x20\156\x6f\x74\40\x73\151\147\x6e\40\171\157\165\x20\x69\156\56\40\120\x6c\145\x61\163\145\x20\143\x6f\156\x74\x61\143\x74\40\x61\144\155\x69\x6e\x69\163\x74\162\141\x74\157\x72", "\105\162\x72\x6f\x72\x3a\x20\x49\156\166\x61\154\x69\x64\40\x53\x41\x4d\x4c\40\122\x65\163\160\157\x6e\163\x65");
    goto h3;
    WD:
    $fe = mo_options_error_constants::Error_no_certificate;
    $Ki = mo_options_error_constants::Cause_no_certificate;
    echo "\74\x64\x69\x76\x20\x73\164\x79\x6c\145\x3d\42\146\x6f\x6e\164\x2d\146\x61\x6d\x69\154\171\72\x43\x61\x6c\x69\142\162\151\x3b\x70\x61\144\144\x69\x6e\x67\72\x30\x20\63\45\x3b\x22\76\15\xa\x9\11\x9\11\74\144\x69\166\40\x73\x74\171\154\145\x3d\x22\143\157\154\x6f\162\x3a\x20\x23\x61\71\x34\x34\x34\62\73\x62\141\x63\153\x67\162\157\165\156\144\x2d\x63\x6f\x6c\x6f\x72\x3a\40\x23\146\62\x64\145\x64\145\x3b\160\141\144\144\151\156\147\x3a\x20\x31\65\x70\170\73\x6d\141\x72\147\151\156\x2d\142\x6f\164\164\x6f\155\x3a\x20\62\x30\160\x78\73\164\145\170\164\x2d\141\x6c\151\147\x6e\x3a\143\145\156\164\145\162\x3b\142\157\162\x64\x65\x72\x3a\61\x70\170\40\x73\x6f\154\x69\x64\40\43\105\66\x42\x33\102\x32\x3b\x66\x6f\156\x74\x2d\163\151\172\x65\72\x31\x38\x70\164\x3b\42\x3e\40\105\122\x52\117\x52\74\57\144\151\166\76\xd\12\11\11\11\x9\x3c\144\151\166\x20\163\164\x79\x6c\145\x3d\x22\143\157\x6c\x6f\x72\72\40\x23\x61\x39\x34\x34\64\62\x3b\146\157\156\164\x2d\x73\x69\x7a\145\x3a\x31\x34\x70\x74\x3b\x20\x6d\141\162\x67\151\x6e\x2d\x62\x6f\164\x74\x6f\155\x3a\x32\60\160\170\x3b\x22\x3e\x3c\160\76\x3c\163\164\x72\157\x6e\147\76\105\x72\x72\x6f\x72\x20\40\x3a" . $fe . "\40\74\x2f\163\x74\x72\x6f\156\x67\76\x3c\x2f\x70\76\15\xa\11\11\x9\x9\15\12\x9\11\x9\11\74\160\x3e\x3c\x73\x74\162\x6f\156\x67\76\120\x6f\x73\x73\x69\x62\154\x65\x20\103\x61\165\x73\x65\72\40" . $Ki . "\x3c\x2f\163\x74\x72\157\x6e\147\x3e\74\x2f\x70\x3e\xd\xa\x9\11\11\11\15\xa\11\x9\11\x9\x3c\57\144\x69\166\76\x3c\x2f\x64\x69\x76\x3e";
    mo_saml_download_logs($fe, $Ki);
    die;
    h3:
    Ay:
    $mU = '';
    if (is_array($ZA)) {
        goto W6;
    }
    $Co = XMLSecurityKey::getRawThumbprint($ZA);
    $Co = mo_saml_convert_to_windows_iconv($Co);
    $Co = preg_replace("\x2f\134\x73\x2b\57", '', $Co);
    if (empty($DG)) {
        goto SQ;
    }
    $mU = SAMLSPUtilities::processResponse($pH, $Co, $DG, $FO, 0, $KH);
    SQ:
    if (empty($TN)) {
        goto IM;
    }
    $mU = SAMLSPUtilities::processResponse($pH, $Co, $TN, $FO, 0, $KH);
    IM:
    goto HB;
    W6:
    foreach ($ZA as $uZ => $Ka) {
        $Co = XMLSecurityKey::getRawThumbprint($Ka);
        $Co = mo_saml_convert_to_windows_iconv($Co);
        $Co = preg_replace("\57\x5c\x73\53\x2f", '', $Co);
        if (empty($DG)) {
            goto EQ;
        }
        $mU = SAMLSPUtilities::processResponse($pH, $Co, $DG, $FO, $uZ, $KH);
        EQ:
        if (empty($TN)) {
            goto sw;
        }
        $mU = SAMLSPUtilities::processResponse($pH, $Co, $TN, $FO, $uZ, $KH);
        sw:
        if (!$mU) {
            goto P0;
        }
        goto j4;
        P0:
        a9:
    }
    j4:
    HB:
    if ($DG) {
        goto Rh;
    }
    if ($TN) {
        goto zS;
    }
    goto JW;
    Rh:
    $RD = $DG["\x43\x65\x72\x74\151\146\151\x63\x61\164\145\x73"][0];
    goto JW;
    zS:
    $RD = $TN["\103\145\162\164\151\x66\151\x63\x61\164\145\163"][0];
    JW:
    if ($mU) {
        goto FY;
    }
    if ($KH == "\x74\x65\x73\x74\126\141\154\x69\x64\x61\x74\145" or $KH == "\164\145\163\x74\x4e\145\167\x43\145\x72\x74\x69\x66\151\x63\x61\x74\x65") {
        goto Lw;
    }
    wp_die("\x57\x65\40\x63\157\x75\x6c\x64\40\x6e\157\164\x20\163\x69\147\156\x20\x79\157\x75\x20\x69\156\x2e\40\120\x6c\x65\x61\x73\x65\x20\x63\x6f\x6e\164\141\143\x74\x20\141\x64\x6d\151\x6e\x69\163\164\162\141\164\x6f\162", "\105\162\162\x6f\x72\72\40\111\x6e\x76\x61\154\151\x64\x20\x53\101\x4d\x4c\40\x52\145\x73\x70\x6f\x6e\x73\x65");
    goto U1;
    Lw:
    $fe = mo_options_error_constants::Error_wrong_certificate;
    $Ki = mo_options_error_constants::Cause_wrong_certificate;
    $c4 = "\x2d\x2d\x2d\55\x2d\x42\x45\107\x49\116\x20\x43\105\x52\124\111\106\x49\x43\101\124\x45\x2d\x2d\x2d\55\55\x3c\142\x72\76" . chunk_split($RD, 64) . "\74\142\x72\76\x2d\55\x2d\55\x2d\x45\116\x44\40\103\x45\122\x54\x49\106\111\103\101\x54\x45\x2d\x2d\55\x2d\x2d";
    echo "\74\x64\151\166\x20\163\164\x79\x6c\x65\75\x22\146\x6f\156\164\x2d\x66\x61\155\x69\154\171\x3a\103\x61\154\151\x62\x72\x69\x3b\160\x61\x64\144\x69\156\x67\x3a\x30\40\x33\45\73\42\76";
    echo "\x3c\144\151\166\40\x73\164\171\154\x65\x3d\42\x63\x6f\154\x6f\x72\x3a\x20\43\141\x39\64\x34\64\x32\73\142\x61\x63\153\x67\162\x6f\x75\x6e\x64\x2d\x63\x6f\154\157\162\x3a\40\43\x66\62\x64\145\144\145\73\160\x61\x64\144\151\156\147\72\x20\61\x35\160\170\x3b\155\x61\x72\147\151\x6e\55\x62\x6f\x74\x74\x6f\155\72\x20\x32\60\x70\x78\x3b\x74\145\170\164\x2d\141\x6c\x69\x67\156\72\143\145\x6e\164\145\162\x3b\142\157\x72\x64\145\x72\x3a\61\x70\170\40\163\157\x6c\x69\144\40\43\105\x36\102\x33\102\x32\x3b\146\x6f\x6e\164\x2d\x73\x69\172\x65\x3a\61\70\x70\x74\x3b\x22\x3e\40\105\122\x52\117\122\74\57\x64\x69\166\x3e\xd\xa\11\x9\x9\x3c\144\x69\166\40\x73\164\171\x6c\x65\x3d\42\143\x6f\x6c\157\162\72\x20\43\x61\71\x34\64\x34\x32\73\146\x6f\156\164\x2d\x73\151\172\x65\72\61\x34\160\164\73\x20\x6d\141\x72\147\x69\x6e\55\142\x6f\x74\164\x6f\155\72\62\60\160\x78\73\42\x3e\x3c\x70\x3e\74\163\x74\162\157\x6e\147\x3e\x45\x72\x72\x6f\162\72" . $fe . "\x20\74\x2f\x73\164\x72\157\x6e\147\76\74\x2f\x70\x3e\15\12\11\11\11\xd\xa\11\11\11\74\160\x3e\74\x73\164\x72\157\x6e\147\x3e\x50\x6f\x73\163\x69\x62\154\145\40\103\x61\x75\x73\145\x3a\x20" . $Ki . "\x3c\57\x73\164\162\157\156\x67\x3e\x3c\57\x70\76\xd\xa\x9\x9\11\74\160\76\x3c\x73\164\x72\157\x6e\147\76\x43\145\x72\x74\x69\146\x69\143\x61\164\x65\x20\146\x6f\165\x6e\144\40\151\156\x20\x53\x41\x4d\114\x20\x52\145\163\x70\x6f\x6e\x73\145\72\40\74\x2f\x73\164\x72\157\156\x67\x3e\x3c\146\x6f\156\164\x20\146\141\143\145\75\42\103\x6f\x75\162\x69\x65\x72\x20\116\x65\x77\x22\73\x66\157\x6e\x74\55\x73\x69\x7a\145\72\61\x30\160\x74\x3e\74\142\x72\76\74\x62\x72\x3e" . $c4 . "\74\57\160\x3e\x3c\x2f\146\x6f\156\164\x3e\xd\12\x9\x9\x9\74\160\76\74\x73\x74\162\x6f\x6e\x67\76\123\x6f\x6c\x75\164\151\x6f\156\x3a\40\74\x2f\x73\x74\x72\x6f\x6e\147\76\74\57\160\x3e\xd\12\x9\11\11\40\74\x6f\x6c\x3e\15\xa\x20\40\40\x20\40\40\x20\x20\x20\40\x20\x20\40\x20\x20\40\74\154\x69\x3e\x43\x6f\160\171\x20\160\x61\163\164\145\x20\x74\x68\145\40\x63\145\x72\x74\151\146\151\143\141\x74\x65\40\160\x72\x6f\166\151\144\x65\144\40\141\142\x6f\166\x65\x20\151\156\40\130\x35\x30\71\x20\103\x65\162\x74\x69\x66\151\x63\x61\164\145\x20\165\x6e\x64\x65\x72\40\123\145\162\166\151\143\145\x20\120\x72\x6f\x76\151\144\145\162\40\x53\145\164\x75\x70\40\x74\141\142\56\74\x2f\154\x69\x3e\15\12\40\40\40\40\x20\x20\x20\x20\x20\x20\40\40\x20\40\x20\x20\x3c\154\151\76\x49\146\40\x69\x73\x73\x75\x65\40\x70\x65\x72\163\151\163\x74\x73\40\144\x69\x73\x61\x62\x6c\x65\40\x3c\142\76\x43\x68\x61\162\x61\x63\164\145\x72\40\145\156\x63\157\144\x69\156\147\x3c\57\x62\76\40\x75\x6e\144\x65\x72\40\x53\145\x72\166\x69\143\145\x20\120\162\x6f\166\x64\145\162\40\123\145\164\165\160\x20\164\x61\x62\56\x3c\57\x6c\151\x3e\xd\12\40\40\x20\40\40\x20\x20\40\x20\x20\x20\x20\x20\74\57\157\154\76\40\x9\11\15\xa\11\11\11\x3c\x2f\144\x69\166\76\15\12\x20\40\40\x20\40\x20\40\x20\x20\x20\x20\40\x20\40\x20\x20\40\x20\40\40\x3c\x2f\x64\151\166\x3e";
    mo_saml_download_logs($fe, $Ki);
    die;
    U1:
    FY:
    $o3 = get_option("\163\141\155\154\x5f\x69\x73\x73\165\145\x72");
    $Eq = get_option("\155\157\x5f\x73\141\x6d\154\x5f\x73\x70\137\145\x6e\164\151\x74\171\x5f\151\x64");
    if (!empty($Eq)) {
        goto bH;
    }
    $Eq = $Ko . "\x2f\x77\x70\x2d\143\157\156\164\x65\156\164\x2f\160\154\165\x67\x69\x6e\163\x2f\155\151\156\x69\157\x72\141\x6e\147\145\x2d\x73\x61\155\x6c\x2d\62\60\x2d\x73\151\x6e\147\x6c\145\x2d\163\151\147\156\55\x6f\x6e\57";
    bH:
    SAMLSPUtilities::validateIssuerAndAudience($FO, $Eq, $o3, $KH);
    $GJ = current(current($FO->getAssertions())->getNameId());
    $Ef = current($FO->getAssertions())->getAttributes();
    $Ef["\x4e\x61\x6d\x65\x49\104"] = array("\x30" => $GJ);
    $T5 = current($FO->getAssertions())->getSessionIndex();
    mo_saml_checkMapping($Ef, $KH, $T5);
    goto up;
    ff:
    wp_logout();
    header("\x4c\157\143\141\164\151\x6f\156\72\40" . home_url());
    die;
    up:
    Y8:
    if (!(array_key_exists("\123\x41\x4d\x4c\x52\145\x71\165\145\163\x74", $_REQUEST) && !empty($_REQUEST["\123\x41\115\x4c\x52\145\161\165\145\x73\x74"]))) {
        goto gk;
    }
    $oe = htmlspecialchars($_REQUEST["\x53\101\x4d\x4c\122\145\x71\165\145\163\x74"]);
    $KH = "\57";
    if (!array_key_exists("\x52\145\x6c\x61\x79\x53\164\141\164\x65", $_REQUEST)) {
        goto q0;
    }
    $KH = htmlspecialchars($_REQUEST["\x52\145\154\141\x79\x53\x74\141\x74\145"]);
    q0:
    $oe = base64_decode($oe);
    if (!(array_key_exists("\x53\x41\x4d\114\122\x65\x71\x75\x65\163\x74", $_GET) && !empty($_GET["\x53\x41\115\x4c\122\x65\161\x75\145\163\x74"]))) {
        goto US;
    }
    $oe = gzinflate($oe);
    US:
    $PG = new DOMDocument();
    $PG->loadXML($oe);
    $wq = $PG->firstChild;
    gk:
    if (!(isset($_REQUEST["\x6f\x70\164\x69\157\x6e"]) and strpos($_REQUEST["\157\160\164\x69\157\156"], "\x72\145\x61\144\163\141\x6d\154\x6c\157\147\151\x6e") !== false)) {
        goto RT;
    }
    require_once dirname(__FILE__) . "\x2f\151\156\x63\x6c\165\x64\x65\163\57\154\x69\142\x2f\145\x6e\143\162\171\x70\164\151\157\x6e\x2e\x70\150\x70";
    if (isset($_POST["\123\124\x41\124\x55\x53"]) && $_POST["\123\124\x41\x54\125\123"] == "\105\122\x52\x4f\122") {
        goto RI;
    }
    if (!(isset($_POST["\x53\x54\101\x54\125\123"]) && $_POST["\123\124\x41\124\125\x53"] == "\123\125\x43\x43\105\x53\123")) {
        goto GQ;
    }
    $bU = '';
    if (!(isset($_REQUEST["\x72\145\144\151\162\145\143\164\137\164\157"]) && !empty($_REQUEST["\162\145\144\x69\x72\145\x63\164\x5f\164\x6f"]) && $_REQUEST["\x72\145\x64\x69\x72\145\143\x74\137\164\157"] != "\57")) {
        goto gJ;
    }
    $bU = htmlspecialchars($_REQUEST["\162\x65\x64\x69\x72\x65\x63\x74\137\164\157"]);
    gJ:
    delete_option("\155\x6f\x5f\x73\x61\155\154\x5f\x72\145\144\x69\162\145\x63\x74\x5f\x65\162\x72\157\162\137\143\x6f\144\x65");
    delete_option("\155\157\137\163\141\x6d\154\137\162\x65\144\151\162\x65\143\164\137\145\162\162\x6f\x72\x5f\162\x65\x61\163\157\x6e");
    try {
        $K9 = get_option("\x73\x61\155\154\x5f\x61\155\x5f\145\155\x61\x69\x6c");
        $ud = get_option("\x73\x61\x6d\x6c\x5f\x61\155\137\x75\163\145\x72\x6e\141\x6d\x65");
        $SV = get_option("\163\141\155\154\x5f\x61\155\x5f\x66\x69\x72\x73\x74\x5f\156\141\155\x65");
        $W3 = get_option("\x73\141\x6d\x6c\137\x61\x6d\x5f\x6c\x61\163\164\x5f\156\x61\155\x65");
        $JW = get_option("\x73\141\x6d\x6c\137\x61\155\137\147\162\157\x75\160\x5f\156\x61\x6d\145");
        $BI = get_option("\163\x61\155\x6c\x5f\x61\x6d\x5f\144\x65\x66\141\165\154\164\137\x75\163\x65\x72\x5f\162\157\154\145");
        $pG = get_option("\163\x61\155\x6c\x5f\x61\x6d\137\144\157\156\x74\x5f\x61\x6c\x6c\157\x77\137\165\x6e\154\151\x73\164\x65\144\137\x75\x73\x65\x72\x5f\x72\x6f\x6c\145");
        $EJ = get_option("\163\x61\x6d\154\x5f\141\x6d\x5f\141\x63\143\157\x75\156\x74\x5f\155\141\164\x63\x68\145\x72");
        $gB = '';
        $vg = '';
        $SV = str_replace("\56", "\x5f", $SV);
        $SV = str_replace("\40", "\137", $SV);
        if (!(!empty($SV) && array_key_exists($SV, $_POST))) {
            goto iD;
        }
        $SV = htmlspecialchars($_POST[$SV]);
        iD:
        $W3 = str_replace("\56", "\x5f", $W3);
        $W3 = str_replace("\x20", "\137", $W3);
        if (!(!empty($W3) && array_key_exists($W3, $_POST))) {
            goto HT;
        }
        $W3 = htmlspecialchars($_POST[$W3]);
        HT:
        $ud = str_replace("\56", "\x5f", $ud);
        $ud = str_replace("\x20", "\x5f", $ud);
        if (!empty($ud) && array_key_exists($ud, $_POST)) {
            goto QI;
        }
        $vg = htmlspecialchars($_POST["\x4e\141\x6d\145\x49\x44"]);
        goto r_;
        QI:
        $vg = htmlspecialchars($_POST[$ud]);
        r_:
        $gB = str_replace("\56", "\x5f", $K9);
        $gB = str_replace("\x20", "\137", $K9);
        if (!empty($K9) && array_key_exists($K9, $_POST)) {
            goto Xc;
        }
        $gB = htmlspecialchars($_POST["\116\141\155\145\x49\x44"]);
        goto xF;
        Xc:
        $gB = htmlspecialchars($_POST[$K9]);
        xF:
        $JW = str_replace("\56", "\x5f", $JW);
        $JW = str_replace("\x20", "\x5f", $JW);
        if (!(!empty($JW) && array_key_exists($JW, $_POST))) {
            goto bQ;
        }
        $JW = htmlspecialchars($_POST[$JW]);
        bQ:
        if (!empty($EJ)) {
            goto XI;
        }
        $EJ = "\x65\155\141\x69\154";
        XI:
        $uZ = get_option("\155\x6f\137\163\141\x6d\x6c\x5f\143\165\x73\164\157\155\x65\x72\137\x74\x6f\153\145\156");
        if (!(isset($uZ) || trim($uZ) != '')) {
            goto Wr;
        }
        $Pr = AESEncryption::decrypt_data($gB, $uZ);
        $gB = $Pr;
        Wr:
        if (!(!empty($SV) && !empty($uZ))) {
            goto Gv;
        }
        $ih = AESEncryption::decrypt_data($SV, $uZ);
        $SV = $ih;
        Gv:
        if (!(!empty($W3) && !empty($uZ))) {
            goto pL;
        }
        $Ro = AESEncryption::decrypt_data($W3, $uZ);
        $W3 = $Ro;
        pL:
        if (!(!empty($vg) && !empty($uZ))) {
            goto hH;
        }
        $Hp = AESEncryption::decrypt_data($vg, $uZ);
        $vg = $Hp;
        hH:
        if (!(!empty($JW) && !empty($uZ))) {
            goto Kj;
        }
        $l0 = AESEncryption::decrypt_data($JW, $uZ);
        $JW = $l0;
        Kj:
    } catch (Exception $LR) {
        echo sprintf("\101\x6e\x20\145\162\x72\157\x72\40\157\x63\x63\x75\162\162\145\144\40\167\x68\x69\154\x65\40\x70\162\157\x63\x65\163\163\x69\156\x67\x20\x74\150\x65\40\123\101\115\114\x20\122\145\x73\x70\157\156\163\x65\x2e");
        die;
    }
    $Ni = array($JW);
    mo_saml_login_user($gB, $SV, $W3, $vg, $Ni, $pG, $BI, $bU, $EJ);
    GQ:
    goto CL;
    RI:
    update_option("\155\157\137\163\x61\155\154\137\x72\x65\x64\151\x72\145\x63\x74\137\145\x72\x72\x6f\162\x5f\x63\157\x64\145", htmlspecialchars($_POST["\105\x52\122\117\122\x5f\x52\x45\x41\x53\x4f\x4e"]));
    update_option("\x6d\157\x5f\x73\x61\155\x6c\137\162\145\x64\x69\x72\x65\143\164\x5f\x65\162\162\x6f\x72\137\x72\145\x61\163\x6f\156", htmlspecialchars($_POST["\105\x52\122\x4f\x52\x5f\115\105\123\x53\x41\x47\105"]));
    CL:
    RT:
    p8:
}
function cldjkasjdksalc()
{
    $PS = plugin_dir_path(__FILE__);
    $Af = wp_upload_dir();
    $kV = home_url();
    $kV = trim($kV, "\x2f");
    if (preg_match("\x23\x5e\x68\x74\164\160\50\x73\x29\77\x3a\57\x2f\x23", $kV)) {
        goto XU;
    }
    $kV = "\x68\164\164\160\x3a\x2f\x2f" . $kV;
    XU:
    $fp = parse_url($kV);
    $Oh = preg_replace("\x2f\136\167\x77\x77\x5c\56\57", '', $fp["\x68\x6f\x73\x74"]);
    $pg = $Oh . "\x2d" . $Af["\x62\x61\x73\x65\x64\x69\162"];
    $Ca = hash_hmac("\x73\x68\141\x32\x35\x36", $pg, "\64\104\110\146\152\x67\146\x6a\x61\x73\156\x64\x66\163\x61\x6a\x66\110\107\112");
    if (is_writable($PS . "\x6c\x69\143\145\156\x73\145")) {
        goto zW;
    }
    $Nw = base64_decode("\142\x47\116\x6b\141\155\164\150\143\62\x70\x6b\141\x33\116\150\x59\x32\167\x3d");
    $wz = get_option($Nw);
    if (empty($wz)) {
        goto RN;
    }
    $qy = str_rot13($wz);
    RN:
    goto zU;
    zW:
    $wz = file_get_contents($PS . "\x6c\151\143\x65\x6e\163\145");
    if (!$wz) {
        goto U6;
    }
    $qy = base64_encode($wz);
    U6:
    zU:
    if (!empty($wz)) {
        goto zq;
    }
    $Ky = base64_decode("\124\x47\154\152\x5a\x57\x35\x7a\132\123\x42\107\x61\127\x78\154\111\107\61\x70\x63\x33\116\160\x62\155\x63\147\132\156\112\166\142\123\x42\x30\141\x47\125\x67\x63\107\170\61\x5a\62\x6c\x75\x4c\147\75\75");
    wp_die($Ky);
    zq:
    if (strpos($qy, $Ca) !== false) {
        goto jB;
    }
    $G0 = new Customersaml();
    $uZ = get_option("\x6d\157\x5f\163\141\x6d\154\137\x63\x75\163\x74\x6f\x6d\145\162\137\x74\157\153\x65\156");
    $HP = AESEncryption::decrypt_data(get_option("\x73\155\x6c\x5f\x6c\x6b"), $uZ);
    $ys = $G0->mo_saml_vl($HP, false);
    if ($ys) {
        goto UK;
    }
    return;
    UK:
    $ys = json_decode($ys, true);
    if (strcasecmp($ys["\x73\x74\141\164\x75\x73"], "\123\x55\x43\103\105\123\123") == 0) {
        goto U5;
    }
    $to = base64_decode("\x53\127\x35\x32\131\x57\170\x70\x5a\103\102\x4d\x61\127\116\x6c\x62\x6e\116\x6c\111\105\132\x76\x64\127\65\x6b\114\151\102\121\142\x47\126\x68\143\x32\x55\x67\x59\x32\x39\165\x64\x47\106\x6a\144\x43\x42\x35\x62\63\x56\171\111\107\x46\153\x62\127\x6c\165\x61\x58\x4e\60\143\155\106\x30\142\x33\x49\147\x64\107\x38\x67\144\130\x4e\154\111\x48\122\x6f\132\x53\x42\152\x62\63\x4a\x79\x5a\127\x4e\x30\x49\107\170\x70\x59\62\126\165\x63\x32\125\165\x49\x45\132\x76\x63\x69\x42\164\x62\x33\x4a\x6c\111\107\x52\154\144\107\106\160\142\110\115\163\111\110\x42\171\x62\x33\132\x70\132\x47\125\x67\144\x47\150\x6c\111\x46\112\154\132\x6d\126\x79\x5a\127\65\152\132\x53\102\112\x52\104\157\x67\124\125\70\x79\116\104\x49\64\115\124\x41\171\115\x54\143\x77\x4e\123\x42\60\142\171\102\65\142\63\126\171\x49\107\x46\153\x62\127\x6c\x75\141\x58\116\x30\143\x6d\x46\x30\x62\x33\111\x67\144\107\70\x67\131\62\150\154\x59\x32\x73\x67\141\x58\x51\x67\x64\127\x35\153\x5a\130\x49\x67\123\107\126\163\x63\103\101\x6d\x49\105\132\x42\125\x53\x42\x30\x59\127\111\147\x61\x57\64\x67\x64\x47\150\154\x49\x48\102\163\144\x57\x64\x70\x62\x69\x34\x3d");
    $to = str_replace("\x48\145\154\x70\40\46\40\106\x41\121\x20\164\x61\142\40\151\156", "\106\x41\x51\x73\40\163\145\x63\x74\151\x6f\156\x20\x6f\146", $to);
    $ON = base64_decode("\x52\x58\x4a\171\142\63\x49\66\x49\105\x6c\165\144\x6d\106\x73\x61\x57\121\147\124\107\x6c\x6a\x5a\127\65\x7a\x5a\121\x3d\x3d");
    wp_die($to, $ON);
    goto CR;
    U5:
    $PS = plugin_dir_path(__FILE__);
    $kV = home_url();
    $kV = trim($kV, "\x2f");
    if (preg_match("\x23\136\150\x74\164\x70\50\x73\x29\77\x3a\x2f\x2f\x23", $kV)) {
        goto PH;
    }
    $kV = "\x68\x74\164\160\x3a\x2f\57" . $kV;
    PH:
    $fp = parse_url($kV);
    $Oh = preg_replace("\57\x5e\167\x77\167\x5c\x2e\x2f", '', $fp["\x68\157\163\164"]);
    $Af = wp_upload_dir();
    $pg = $Oh . "\55" . $Af["\x62\x61\x73\x65\x64\x69\162"];
    $Ca = hash_hmac("\163\150\141\62\x35\x36", $pg, "\x34\x44\110\146\x6a\147\x66\152\141\163\x6e\144\x66\163\x61\152\x66\x48\107\112");
    $f_ = djkasjdksa();
    $X1 = round(strlen($f_) / rand(2, 20));
    $f_ = substr_replace($f_, $Ca, $X1, 0);
    $iH = base64_decode($f_);
    if (is_writable($PS . "\154\151\143\145\x6e\x73\145")) {
        goto Um;
    }
    $f_ = str_rot13($f_);
    $Nw = base64_decode("\142\x47\x4e\153\141\155\x74\150\x63\62\160\153\x61\63\x4e\150\131\62\x77\x3d");
    update_option($Nw, $f_);
    goto E5;
    Um:
    file_put_contents($PS . "\x6c\x69\x63\x65\x6e\163\x65", $iH);
    E5:
    return true;
    CR:
    goto N4;
    jB:
    return true;
    N4:
}
function djkasjdksa()
{
    $dq = "\x21\176\100\x23\44\45\x5e\46\x2a\x28\51\137\53\174\x7b\x7d\74\x3e\x3f\x30\61\x32\x33\x34\x35\66\x37\x38\x39\141\142\x63\144\145\146\x67\150\x69\152\153\x6c\155\156\157\x70\161\162\x73\x74\x75\166\167\x78\171\172\101\x42\103\x44\105\106\x47\x48\111\x4a\x4b\114\x4d\116\117\120\121\x52\x53\x54\125\x56\x57\x58\x59\x5a";
    $EF = strlen($dq);
    $As = '';
    $LH = 0;
    tc:
    if (!($LH < 10000)) {
        goto QC;
    }
    $As .= $dq[rand(0, $EF - 1)];
    vO:
    $LH++;
    goto tc;
    QC:
    return $As;
}
function mo_saml_show_SAML_log($wq, $u8)
{
    header("\103\157\x6e\164\x65\x6e\164\55\124\171\160\x65\72\40\x74\x65\170\164\x2f\x68\x74\155\154");
    $wP = new DOMDocument();
    $wP->preserveWhiteSpace = false;
    $wP->formatOutput = true;
    $wP->loadXML($wq);
    if ($u8 == "\x64\x69\163\160\x6c\141\x79\123\101\x4d\114\122\145\x71\165\145\x73\164") {
        goto kQ;
    }
    $vC = "\123\x41\115\x4c\40\122\145\x73\160\157\x6e\163\145";
    goto Xv;
    kQ:
    $vC = "\x53\x41\115\x4c\x20\x52\145\161\x75\x65\x73\164";
    Xv:
    $v7 = $wP->saveXML();
    $TR = htmlentities($v7);
    $TR = rtrim($TR);
    $Cr = simplexml_load_string($v7);
    $AE = json_encode($Cr);
    $lA = json_decode($AE);
    $Q2 = plugins_url("\x69\156\x63\x6c\165\144\145\x73\x2f\143\163\163\57\x73\x74\171\154\x65\x5f\x73\145\164\164\151\x6e\147\x73\56\143\163\163\x3f\166\x65\162\75\64\x2e\x38\56\64\60", __FILE__);
    echo "\74\154\x69\156\x6b\40\162\x65\154\75\x27\163\x74\x79\154\x65\163\x68\x65\145\x74\x27\x20\151\x64\x3d\47\x6d\157\137\x73\x61\155\x6c\137\x61\x64\x6d\x69\x6e\x5f\163\x65\x74\x74\x69\156\147\x73\137\163\x74\171\x6c\x65\x2d\x63\x73\163\47\x20\x20\150\x72\145\x66\x3d\x27" . $Q2 . "\x27\40\164\171\x70\145\75\47\x74\145\170\164\57\143\x73\x73\47\40\x6d\x65\144\x69\x61\75\47\x61\154\x6c\47\x20\x2f\x3e\15\12\40\x20\40\x20\x20\40\40\x20\40\40\40\40\xd\12\11\11\11\x3c\x64\151\166\40\x63\154\141\163\163\x3d\x22\155\157\55\x64\151\163\160\x6c\141\171\x2d\154\157\x67\x73\x22\40\76\74\x70\x20\164\x79\x70\x65\x3d\x22\164\x65\x78\164\42\x20\40\40\x69\144\75\42\123\101\x4d\114\137\164\x79\x70\145\x22\x3e" . $vC . "\x3c\x2f\160\76\x3c\57\x64\151\x76\76\15\xa\x9\x9\x9\x9\xd\12\11\11\x9\x3c\144\x69\x76\x20\164\x79\x70\x65\75\x22\164\145\170\164\x22\x20\151\144\75\x22\x53\101\115\x4c\137\144\151\x73\x70\x6c\x61\x79\42\x20\143\154\x61\x73\163\75\42\155\x6f\55\144\x69\x73\160\x6c\141\171\55\142\154\x6f\143\x6b\x22\76\x3c\x70\162\x65\x20\143\154\141\x73\163\x3d\47\x62\162\x75\x73\x68\x3a\x20\170\x6d\154\73\x27\x3e" . $TR . "\x3c\x2f\160\x72\x65\x3e\x3c\57\144\x69\x76\x3e\xd\xa\11\11\11\x3c\x62\162\76\xd\12\11\x9\11\x3c\x64\151\166\11\40\x73\x74\x79\154\x65\x3d\42\x6d\x61\x72\147\151\156\72\63\x25\73\144\151\x73\x70\x6c\x61\x79\72\142\x6c\x6f\143\153\x3b\x74\x65\170\x74\x2d\141\154\x69\x67\156\72\143\145\156\x74\x65\x72\x3b\x22\x3e\15\xa\40\x20\x20\x20\40\40\x20\40\40\40\x20\40\xd\12\11\11\x9\x3c\x64\151\166\40\163\x74\x79\x6c\x65\x3d\x22\155\141\x72\x67\151\x6e\x3a\x33\x25\73\x64\x69\x73\160\x6c\x61\x79\x3a\x62\x6c\157\x63\x6b\x3b\164\145\170\164\55\141\154\151\147\x6e\x3a\143\145\156\x74\145\162\x3b\42\x20\x3e\15\12\x9\15\xa\x20\x20\40\40\x20\x20\40\40\40\40\40\x20\x3c\x2f\144\x69\166\76\xd\xa\11\11\11\x3c\x62\165\x74\164\x6f\156\x20\x69\x64\75\42\x63\157\160\x79\x22\x20\x6f\x6e\143\x6c\151\x63\153\75\42\143\157\160\171\104\x69\x76\x54\157\103\x6c\151\x70\x62\157\x61\x72\144\x28\51\42\40\40\163\164\171\154\145\x3d\x22\x70\x61\144\144\x69\x6e\147\72\61\x25\73\167\151\144\164\150\x3a\61\60\x30\x70\170\x3b\x62\141\x63\153\x67\x72\x6f\165\x6e\144\72\x20\43\x30\60\x39\x31\x43\104\40\x6e\157\156\145\40\162\x65\x70\x65\141\164\40\x73\143\x72\157\x6c\x6c\40\60\45\40\60\x25\73\143\x75\162\x73\157\x72\72\40\x70\157\x69\156\164\145\x72\x3b\x66\x6f\156\164\55\163\151\x7a\x65\72\x31\x35\160\x78\73\142\x6f\x72\144\x65\x72\x2d\167\151\144\x74\150\72\x20\x31\x70\x78\73\142\157\162\x64\x65\162\55\x73\x74\171\x6c\x65\72\40\163\157\x6c\x69\x64\73\x62\x6f\162\x64\145\162\55\162\141\144\151\x75\x73\x3a\40\x33\x70\170\73\x77\x68\151\164\x65\55\x73\160\141\143\x65\x3a\40\156\157\167\162\141\x70\73\x62\x6f\x78\55\163\x69\172\151\156\147\72\40\x62\157\162\144\x65\162\x2d\x62\x6f\170\x3b\x62\157\162\144\145\x72\x2d\x63\157\x6c\157\162\x3a\40\x23\x30\x30\x37\x33\101\101\73\142\157\x78\x2d\163\150\x61\144\157\167\x3a\x20\60\160\170\x20\x31\160\170\x20\60\x70\170\x20\x72\x67\x62\141\50\x31\x32\x30\54\x20\x32\x30\x30\x2c\40\62\63\x30\x2c\x20\60\56\x36\51\x20\x69\x6e\163\145\x74\x3b\143\157\154\157\x72\x3a\40\x23\106\x46\106\x3b\42\40\76\x43\157\160\x79\74\x2f\x62\165\164\x74\x6f\x6e\76\15\xa\x9\x9\11\x26\x6e\x62\163\x70\73\xd\xa\x20\x20\x20\40\40\x20\x20\40\x20\x20\40\40\x20\x20\40\74\151\x6e\160\x75\x74\x20\x69\x64\75\x22\144\x77\156\x2d\x62\x74\x6e\x22\x20\163\164\171\x6c\145\x3d\42\x70\141\144\x64\151\156\147\x3a\61\x25\73\167\x69\x64\x74\150\x3a\61\60\60\x70\170\73\142\x61\x63\x6b\x67\162\x6f\165\x6e\144\x3a\40\x23\60\x30\x39\61\103\x44\40\x6e\157\156\x65\x20\162\x65\160\145\141\x74\x20\x73\143\x72\157\x6c\x6c\x20\60\45\40\60\45\x3b\x63\165\x72\x73\157\162\x3a\x20\x70\x6f\x69\x6e\x74\x65\x72\73\146\x6f\x6e\x74\55\x73\151\x7a\x65\72\61\x35\x70\x78\x3b\x62\157\162\144\145\x72\55\x77\151\x64\x74\x68\72\x20\61\x70\170\x3b\x62\x6f\x72\x64\145\x72\x2d\x73\x74\x79\x6c\x65\x3a\x20\x73\x6f\x6c\x69\x64\x3b\142\x6f\x72\144\x65\162\x2d\x72\x61\144\x69\x75\163\x3a\40\x33\160\x78\73\167\150\151\164\145\55\x73\160\141\x63\145\x3a\40\156\157\x77\162\x61\160\x3b\x62\157\170\x2d\163\151\172\151\x6e\x67\72\x20\x62\x6f\162\144\145\x72\x2d\x62\x6f\x78\x3b\x62\157\162\x64\145\162\55\x63\157\154\x6f\x72\x3a\40\43\x30\60\x37\63\x41\x41\x3b\x62\157\170\x2d\163\x68\141\144\x6f\167\72\x20\60\x70\170\x20\x31\x70\170\40\x30\x70\x78\x20\x72\147\x62\x61\x28\x31\x32\60\x2c\x20\x32\60\60\54\x20\62\x33\60\x2c\40\x30\x2e\x36\51\40\x69\x6e\163\x65\x74\73\x63\157\x6c\157\162\x3a\x20\x23\106\x46\106\73\42\x74\171\160\x65\75\x22\x62\x75\x74\164\157\x6e\x22\x20\x76\x61\x6c\165\x65\75\42\104\157\x77\x6e\154\157\x61\144\x22\40\xd\12\40\40\40\40\x20\x20\40\40\x20\40\x20\x20\40\40\x20\42\76\15\xa\x9\11\x9\x3c\x2f\x64\151\x76\76\15\xa\11\x9\x9\74\x2f\144\x69\166\x3e\15\xa\11\11\11\xd\12\x9\11\15\xa\x9\11\11";
    ob_end_flush();
    ?>

	<script>

        function copyDivToClipboard() {
            var aux = document.createElement("input");
            aux.setAttribute("value", document.getElementById("SAML_display").textContent);
            document.body.appendChild(aux);
            aux.select();
            document.execCommand("copy");
            document.body.removeChild(aux);
            document.getElementById('copy').textContent = "Copied";
            document.getElementById('copy').style.background = "grey";
            window.getSelection().selectAllChildren( document.getElementById( "SAML_display" ) );

        }

        function download(filename, text) {
            var element = document.createElement('a');
            element.setAttribute('href', 'data:Application/octet-stream;charset=utf-8,' + encodeURIComponent(text));
            element.setAttribute('download', filename);

            element.style.display = 'none';
            document.body.appendChild(element);

            element.click();

            document.body.removeChild(element);
        }

        document.getElementById("dwn-btn").addEventListener("click", function () {

            var filename = document.getElementById("SAML_type").textContent+".xml";
            var node = document.getElementById("SAML_display");
            htmlContent = node.innerHTML;
            text = node.textContent;
            console.log(text);
            download(filename, text);
        }, false);





    </script>
<?php 
    die;
}
function mo_saml_checkMapping($Ef, $KH, $T5)
{
    try {
        $K9 = get_option("\x73\x61\x6d\x6c\137\141\155\x5f\145\155\x61\x69\x6c");
        $ud = get_option("\x73\141\155\x6c\x5f\141\155\x5f\x75\163\145\162\156\x61\155\145");
        $SV = get_option("\x73\x61\155\154\137\x61\x6d\137\x66\151\162\163\164\137\156\141\x6d\x65");
        $W3 = get_option("\x73\141\x6d\x6c\x5f\141\155\x5f\154\141\163\164\x5f\156\x61\155\145");
        $JW = get_option("\x73\141\x6d\154\137\141\x6d\x5f\147\x72\157\165\x70\137\156\x61\155\145");
        $BI = get_option("\163\x61\x6d\154\x5f\x61\x6d\137\144\x65\x66\141\x75\x6c\164\137\x75\x73\145\162\x5f\x72\157\x6c\x65");
        $pG = get_option("\163\141\x6d\x6c\x5f\x61\x6d\x5f\144\x6f\156\164\137\x61\154\x6c\157\x77\x5f\165\156\x6c\x69\x73\x74\145\144\137\x75\x73\x65\x72\x5f\162\x6f\x6c\145");
        $EJ = get_option("\163\x61\155\154\137\x61\x6d\x5f\x61\143\143\x6f\165\156\164\137\155\x61\x74\143\150\x65\162");
        $gB = '';
        $vg = '';
        if (empty($Ef)) {
            goto Zm;
        }
        if (!empty($SV) && array_key_exists($SV, $Ef)) {
            goto WC;
        }
        $SV = '';
        goto M2;
        WC:
        $SV = $Ef[$SV][0];
        M2:
        if (!empty($W3) && array_key_exists($W3, $Ef)) {
            goto T5;
        }
        $W3 = '';
        goto Ho;
        T5:
        $W3 = $Ef[$W3][0];
        Ho:
        if (!empty($ud) && array_key_exists($ud, $Ef)) {
            goto dg;
        }
        $vg = $Ef["\x4e\x61\155\145\x49\x44"][0];
        goto rq;
        dg:
        $vg = $Ef[$ud][0];
        rq:
        if (!empty($K9) && array_key_exists($K9, $Ef)) {
            goto ft;
        }
        $gB = $Ef["\116\x61\155\145\111\104"][0];
        goto qg;
        ft:
        $gB = $Ef[$K9][0];
        qg:
        if (!empty($JW) && array_key_exists($JW, $Ef)) {
            goto Lq;
        }
        $JW = array();
        goto E7;
        Lq:
        $JW = $Ef[$JW];
        E7:
        if (!empty($EJ)) {
            goto lu;
        }
        $EJ = "\x65\155\141\151\154";
        lu:
        Zm:
        if ($KH == "\164\145\x73\164\x56\x61\154\151\144\x61\x74\x65") {
            goto rU;
        }
        if ($KH == "\164\x65\163\164\116\145\167\x43\x65\x72\x74\x69\146\x69\143\x61\x74\145") {
            goto eU;
        }
        mo_saml_login_user($gB, $SV, $W3, $vg, $JW, $pG, $BI, $KH, $EJ, $T5, $Ef["\x4e\141\x6d\145\x49\x44"][0], $Ef);
        goto cm;
        rU:
        update_option("\155\157\x5f\163\141\155\154\137\164\145\x73\164", "\124\x65\163\164\40\163\165\x63\x63\145\x73\163\146\x75\154");
        mo_saml_show_test_result($SV, $W3, $gB, $JW, $Ef, $KH);
        goto cm;
        eU:
        update_option("\155\x6f\137\x73\x61\155\x6c\x5f\x74\x65\163\x74\137\x6e\145\x77\137\x63\145\x72\164", "\124\x65\x73\164\40\x73\x75\143\x63\x65\x73\x73\x66\x75\x6c");
        mo_saml_show_test_result($SV, $W3, $gB, $JW, $Ef, $KH);
        cm:
    } catch (Exception $LR) {
        echo sprintf("\101\156\x20\145\162\x72\157\x72\40\x6f\143\x63\x75\x72\x72\145\x64\x20\167\x68\x69\154\x65\40\160\162\157\x63\x65\163\163\151\156\147\40\x74\150\x65\x20\x53\101\115\x4c\40\x52\145\163\160\157\156\x73\x65\x2e");
        die;
    }
}
function mo_saml_show_test_result($SV, $W3, $gB, $JW, $Ef, $KH)
{
    echo "\74\144\x69\x76\x20\163\x74\171\154\x65\75\42\x66\157\156\x74\x2d\x66\x61\x6d\151\154\x79\72\103\x61\154\x69\142\x72\151\x3b\160\141\x64\x64\x69\x6e\147\x3a\60\x20\63\45\x3b\42\x3e";
    if (!empty($gB)) {
        goto kt;
    }
    echo "\74\144\x69\x76\x20\163\x74\x79\x6c\145\x3d\42\143\x6f\x6c\x6f\162\72\x20\43\x61\x39\x34\64\x34\62\73\142\x61\x63\153\x67\x72\x6f\165\x6e\x64\x2d\x63\x6f\x6c\x6f\162\x3a\x20\x23\x66\62\144\145\144\145\73\160\141\x64\144\151\x6e\x67\x3a\x20\x31\x35\160\170\x3b\155\141\x72\147\151\156\55\142\157\164\164\x6f\x6d\72\x20\62\60\160\170\x3b\x74\145\x78\x74\55\141\154\151\147\156\72\143\145\156\x74\145\162\73\x62\x6f\162\144\145\162\x3a\x31\160\x78\x20\163\x6f\x6c\151\x64\40\x23\105\x36\102\63\102\x32\73\146\x6f\x6e\x74\55\x73\151\172\145\x3a\61\x38\160\x74\73\42\x3e\124\x45\x53\124\40\x46\x41\111\114\105\104\74\x2f\x64\151\x76\76\15\12\11\x9\11\x9\x3c\x64\151\x76\x20\x73\164\x79\154\145\x3d\x22\143\157\x6c\157\162\x3a\x20\x23\141\71\64\64\x34\62\73\x66\157\x6e\164\55\163\x69\x7a\145\72\x31\64\160\x74\73\x20\x6d\141\162\x67\x69\156\x2d\142\157\164\x74\157\x6d\72\62\60\160\170\73\42\x3e\127\101\x52\116\x49\x4e\107\x3a\40\123\x6f\x6d\145\x20\x41\164\x74\162\151\x62\x75\x74\x65\163\x20\x44\x69\144\x20\116\157\164\40\115\141\x74\143\x68\56\74\x2f\144\151\x76\x3e\15\12\x9\x9\11\11\x3c\144\x69\x76\x20\163\164\171\x6c\x65\75\42\x64\151\163\x70\x6c\141\171\72\142\154\x6f\x63\x6b\73\164\145\170\x74\x2d\141\154\151\147\156\72\x63\x65\156\x74\145\x72\x3b\155\x61\162\147\x69\x6e\55\x62\x6f\164\x74\157\155\72\x34\x25\x3b\x22\76\x3c\151\155\147\x20\x73\x74\171\154\145\75\x22\x77\x69\144\164\150\72\61\65\45\x3b\42\163\x72\x63\75\x22" . plugin_dir_url(__FILE__) . "\x69\x6d\x61\147\145\x73\x2f\x77\162\x6f\x6e\147\56\x70\156\147\x22\76\x3c\x2f\144\x69\x76\76";
    goto Pr;
    kt:
    update_option("\155\x6f\137\x73\141\x6d\x6c\x5f\164\145\163\164\x5f\x63\157\156\146\x69\147\x5f\x61\164\164\162\163", $Ef);
    echo "\x3c\144\151\166\40\x73\x74\x79\154\x65\75\42\x63\157\154\157\x72\x3a\x20\43\63\143\x37\66\63\x64\73\xd\xa\11\x9\11\x9\x62\141\143\153\147\162\x6f\165\156\x64\55\143\x6f\154\x6f\x72\72\x20\43\144\146\x66\x30\144\x38\x3b\40\x70\x61\x64\x64\151\156\x67\x3a\x32\45\73\x6d\x61\x72\147\x69\x6e\55\142\x6f\164\x74\157\x6d\72\x32\60\x70\170\x3b\x74\x65\x78\164\x2d\x61\154\x69\147\156\72\143\145\156\164\145\162\x3b\x20\x62\x6f\162\x64\x65\162\72\61\160\x78\40\x73\x6f\154\151\x64\40\43\101\x45\x44\x42\71\101\73\40\146\x6f\156\x74\55\x73\151\x7a\145\x3a\x31\x38\160\x74\x3b\x22\76\x54\x45\123\124\x20\123\x55\x43\x43\x45\123\x53\106\x55\114\x3c\57\144\x69\166\76\15\12\11\x9\11\11\74\x64\151\166\40\163\x74\171\x6c\x65\x3d\x22\144\151\163\160\154\141\x79\72\142\154\x6f\143\x6b\73\164\x65\x78\x74\55\141\x6c\x69\x67\156\x3a\143\x65\156\x74\145\162\x3b\155\141\x72\147\x69\x6e\55\142\157\164\x74\157\155\72\x34\45\73\42\x3e\x3c\151\x6d\x67\40\x73\164\x79\x6c\145\x3d\x22\x77\x69\144\x74\150\x3a\61\x35\45\x3b\42\x73\x72\143\x3d\x22" . plugin_dir_url(__FILE__) . "\x69\x6d\x61\x67\145\x73\57\147\x72\x65\x65\x6e\137\x63\x68\x65\143\x6b\x2e\x70\156\x67\x22\76\x3c\57\144\151\166\x3e";
    Pr:
    $cX = get_option("\x73\x61\x6d\x6c\137\141\155\x5f\141\143\x63\157\165\x6e\x74\x5f\x6d\x61\x74\143\150\x65\162") ? get_option("\x73\141\155\x6c\x5f\x61\x6d\x5f\141\x63\143\x6f\x75\156\164\137\x6d\x61\164\143\150\x65\x72") : "\145\155\x61\151\x6c";
    $B1 = $KH == "\x74\145\x73\x74\116\145\167\103\145\x72\164\151\x66\151\x63\x61\x74\145" ? "\x64\151\163\x70\154\141\x79\x3a\156\157\156\x65" : '';
    if (!($cX == "\x65\x6d\x61\151\154" && !filter_var($gB, FILTER_VALIDATE_EMAIL))) {
        goto LC;
    }
    echo "\74\x70\x3e\74\x66\x6f\x6e\164\40\143\x6f\154\157\162\x3d\x22\43\106\x46\x30\60\x30\x30\42\x20\163\164\x79\x6c\x65\x3d\x22\x66\157\x6e\164\55\x73\x69\x7a\145\x3a\x31\64\x70\164\42\76\50\127\141\162\156\151\156\147\x3a\x20\x54\150\145\40\101\164\x74\x72\151\x62\x75\164\145\x20\42";
    echo get_option("\163\141\x6d\x6c\x5f\x61\x6d\x5f\x65\x6d\141\151\154") ? get_option("\163\x61\x6d\154\137\141\x6d\137\145\x6d\x61\x69\x6c") : "\116\141\x6d\145\111\104";
    echo "\42\x20\x64\x6f\x65\163\x20\x6e\157\164\40\143\157\156\164\x61\x69\156\40\166\x61\154\151\144\x20\105\155\x61\151\x6c\40\x49\x44\x29\x3c\57\x66\157\156\164\x3e\x3c\57\160\x3e";
    LC:
    echo "\74\x73\160\x61\156\x20\x73\164\171\x6c\x65\75\x22\146\x6f\156\164\55\x73\x69\x7a\145\72\61\x34\x70\164\x3b\42\x3e\74\x62\x3e\110\145\x6c\154\x6f\74\x2f\x62\x3e\x2c\x20" . $gB . "\x3c\x2f\163\160\x61\x6e\76\74\x62\x72\57\x3e\x3c\160\x20\x73\x74\x79\x6c\x65\75\x22\146\157\x6e\164\x2d\167\x65\151\x67\150\x74\x3a\x62\x6f\154\x64\73\x66\157\x6e\164\x2d\163\151\172\145\x3a\x31\x34\160\x74\73\155\141\x72\147\x69\156\x2d\154\145\x66\164\x3a\x31\x25\73\42\76\101\x54\x54\x52\111\x42\125\x54\105\x53\x20\x52\x45\103\x45\111\126\105\104\x3a\x3c\x2f\x70\x3e\15\12\11\11\11\11\74\164\x61\142\x6c\x65\x20\163\164\x79\154\x65\x3d\42\142\157\x72\x64\145\162\x2d\143\157\154\154\141\160\x73\145\72\143\157\x6c\154\x61\x70\163\x65\x3b\142\157\162\144\145\162\x2d\163\160\141\x63\151\156\147\72\x30\x3b\x20\x64\x69\x73\x70\x6c\141\x79\72\164\x61\142\154\145\x3b\x77\x69\x64\x74\x68\x3a\x31\x30\x30\45\x3b\40\146\157\156\x74\x2d\163\x69\172\x65\x3a\61\64\x70\x74\x3b\142\x61\143\153\147\162\157\165\156\x64\55\143\157\154\x6f\x72\72\x23\x45\104\105\x44\x45\104\x3b\x22\76\15\12\11\11\x9\x9\x3c\x74\x72\40\163\x74\171\x6c\x65\x3d\42\164\x65\x78\x74\x2d\x61\154\151\x67\x6e\72\143\145\156\164\145\x72\73\x22\76\74\x74\144\40\x73\164\x79\154\x65\75\x22\146\x6f\x6e\x74\55\167\145\151\x67\x68\164\72\x62\157\154\144\73\142\157\162\144\145\x72\72\62\160\x78\40\163\157\x6c\x69\x64\x20\x23\x39\64\x39\60\71\x30\x3b\x70\141\x64\x64\151\156\x67\x3a\62\x25\x3b\x22\x3e\101\x54\124\x52\x49\102\x55\x54\105\40\x4e\101\115\x45\x3c\57\164\144\76\74\164\144\x20\x73\164\x79\154\145\75\x22\146\157\x6e\164\x2d\x77\x65\x69\x67\x68\164\x3a\x62\157\154\144\73\160\141\144\144\x69\156\x67\72\62\45\x3b\142\157\162\x64\145\162\x3a\x32\160\x78\40\x73\x6f\x6c\151\144\40\x23\71\x34\x39\x30\x39\60\73\x20\x77\157\x72\144\55\x77\x72\141\x70\72\x62\162\145\x61\153\x2d\167\x6f\x72\144\x3b\42\x3e\x41\x54\x54\x52\x49\x42\125\124\105\40\126\101\114\125\105\74\x2f\164\144\x3e\74\x2f\164\162\x3e";
    if (!empty($Ef)) {
        goto dw;
    }
    echo "\116\157\40\x41\x74\164\x72\x69\142\x75\164\145\x73\x20\x52\x65\x63\x65\151\166\x65\144\x2e";
    goto Bh;
    dw:
    foreach ($Ef as $uZ => $Ka) {
        echo "\74\x74\162\x3e\x3c\164\x64\40\x73\x74\x79\154\145\75\x27\x66\157\x6e\164\55\167\145\151\x67\x68\x74\72\x62\x6f\x6c\144\x3b\142\x6f\x72\x64\x65\x72\x3a\x32\x70\170\40\x73\x6f\x6c\x69\x64\x20\x23\71\x34\71\60\71\60\x3b\x70\x61\144\x64\x69\156\x67\x3a\x32\45\x3b\x20\x77\x6f\x72\144\55\x77\x72\x61\160\72\142\162\x65\x61\x6b\x2d\x77\157\x72\x64\73\47\x3e" . $uZ . "\74\57\164\x64\x3e\x3c\x74\144\40\x73\164\171\x6c\145\x3d\x27\160\141\144\144\x69\156\x67\72\x32\45\73\x62\x6f\x72\144\145\162\x3a\x32\x70\x78\x20\163\x6f\x6c\x69\x64\x20\43\x39\64\71\x30\71\60\73\40\167\157\x72\144\55\x77\162\x61\x70\72\x62\x72\145\141\153\55\x77\157\162\144\x3b\x27\76" . implode("\74\x68\162\57\76", $Ka) . "\74\57\164\144\x3e\x3c\57\x74\162\76";
        iX:
    }
    L3:
    Bh:
    echo "\74\57\x74\x61\142\x6c\145\76\x3c\57\144\151\x76\x3e\x3c\x64\x69\x76\x20\x73\x74\171\x6c\145\75\42\x6d\x61\x72\x67\151\156\72\63\45\73\x64\151\x73\x70\x6c\141\x79\72\x62\154\157\143\153\73\164\145\x78\164\x2d\x61\x6c\151\x67\156\x3a\143\x65\x6e\164\145\x72\73\42\x3e\15\12\11\x9\x3c\151\x6e\x70\165\x74\40\163\x74\171\154\145\x3d\42\x70\141\144\144\151\x6e\x67\72\61\x25\x3b\167\x69\x64\x74\x68\x3a\x32\x35\x30\x70\x78\x3b\142\x61\x63\x6b\x67\x72\x6f\x75\x6e\x64\x3a\x20\x23\60\60\x39\x31\x43\104\x20\156\157\156\x65\x20\x72\x65\160\x65\141\x74\x20\x73\x63\x72\157\x6c\x6c\x20\x30\x25\x20\60\x25\73\xd\12\x9\11\x63\165\162\x73\x6f\x72\72\40\160\x6f\151\x6e\x74\x65\162\x3b\x66\x6f\x6e\164\55\163\x69\x7a\x65\72\61\x35\x70\170\73\142\x6f\162\x64\x65\162\55\x77\151\144\x74\150\72\x20\61\160\170\73\142\157\x72\144\x65\x72\x2d\163\164\x79\154\x65\72\x20\x73\x6f\x6c\x69\144\x3b\x62\157\162\x64\145\162\55\162\141\x64\151\x75\163\72\40\63\x70\170\73\167\150\x69\x74\145\x2d\163\160\141\x63\145\72\xd\xa\x9\11\x20\x6e\x6f\167\162\141\160\73\x62\x6f\x78\x2d\x73\151\172\x69\x6e\147\72\40\142\x6f\x72\144\x65\162\55\142\157\170\x3b\x62\x6f\x72\x64\145\162\x2d\143\157\154\x6f\x72\x3a\40\x23\x30\60\x37\x33\x41\x41\73\142\x6f\170\55\163\150\141\x64\157\167\72\x20\x30\160\170\x20\x31\160\x78\40\x30\x70\170\x20\x72\147\x62\141\x28\61\62\x30\54\40\x32\x30\x30\x2c\40\x32\63\60\x2c\40\x30\x2e\x36\x29\40\x69\156\x73\x65\164\73\x63\x6f\154\157\x72\x3a\40\43\x46\106\106\x3b" . $B1 . "\x22\xd\12\x20\x20\40\40\40\40\x20\x20\40\40\40\x20\x74\171\160\145\75\42\142\x75\164\164\157\156\x22\x20\x76\141\x6c\165\145\75\42\x43\x6f\x6e\146\x69\147\x75\162\145\x20\x41\x74\164\162\151\x62\x75\164\145\57\122\157\x6c\145\x20\x4d\141\160\160\151\x6e\147\42\x20\157\156\x43\x6c\x69\x63\x6b\x3d\42\x63\x6c\x6f\163\x65\137\x61\x6e\x64\137\x72\145\144\x69\162\x65\x63\164\x28\x29\x3b\42\76\x20\x26\x6e\x62\x73\160\73\x20\40\74\151\x6e\x70\x75\164\40\x73\164\171\x6c\145\x3d\42\x70\x61\144\x64\x69\x6e\x67\72\x31\x25\73\167\151\144\164\x68\x3a\x31\x30\x30\x70\170\x3b\142\141\x63\x6b\147\162\x6f\165\x6e\x64\x3a\40\43\x30\60\x39\x31\x43\104\x20\156\157\156\145\40\162\x65\x70\145\x61\164\x20\163\143\x72\x6f\x6c\x6c\x20\x30\45\40\x30\x25\x3b\x63\165\x72\x73\157\162\x3a\40\x70\x6f\151\156\x74\145\162\73\146\x6f\x6e\164\x2d\163\151\172\x65\x3a\x31\65\x70\x78\73\x62\157\162\x64\145\x72\x2d\167\151\x64\x74\150\72\40\x31\x70\170\73\142\157\162\x64\x65\162\x2d\163\x74\171\154\145\72\40\163\x6f\154\x69\144\x3b\x62\x6f\162\144\145\162\55\162\141\144\x69\165\163\x3a\x20\63\x70\170\x3b\x77\150\x69\164\145\x2d\163\x70\141\143\x65\x3a\x20\156\157\x77\x72\141\x70\73\x62\157\x78\x2d\x73\151\x7a\x69\x6e\x67\x3a\40\x62\x6f\x72\144\x65\x72\x2d\142\157\x78\73\142\157\x72\x64\x65\x72\55\143\157\x6c\x6f\x72\x3a\40\43\x30\x30\67\x33\101\x41\73\142\x6f\170\x2d\163\x68\141\144\157\x77\72\x20\60\x70\x78\x20\x31\160\170\40\x30\160\170\40\162\x67\x62\x61\50\61\62\60\54\40\62\60\x30\54\40\x32\x33\x30\x2c\x20\60\x2e\66\x29\x20\151\x6e\163\145\x74\x3b\143\157\x6c\x6f\162\x3a\40\x23\106\x46\x46\x3b\42\x74\171\160\145\75\x22\x62\165\164\x74\157\x6e\x22\x20\x76\x61\x6c\x75\145\x3d\x22\x44\157\x6e\145\42\40\x6f\156\103\x6c\x69\143\x6b\x3d\42\x73\145\154\146\x2e\x63\x6c\x6f\163\x65\x28\51\x3b\42\76\xd\12\40\40\40\40\40\x20\x20\40\xd\xa\x20\x20\x20\40\40\x20\x20\x20\40\x20\40\x20\x3c\x2f\144\151\x76\76\xd\xa\x20\x20\40\x20\x20\40\x20\x20\40\40\x20\40\xd\12\40\x20\x20\x20\40\40\40\x20\x20\40\40\x20\x3c\163\143\x72\151\160\164\x3e\15\xa\x20\x20\x20\x20\x20\40\x20\40\x20\40\40\x20\xd\xa\40\40\x20\x20\40\x20\40\x20\x20\x20\40\40\40\x66\x75\156\x63\164\151\157\x6e\x20\x63\154\157\x73\x65\137\x61\x6e\144\137\162\x65\x64\x69\162\x65\x63\x74\x28\51\173\xd\12\x20\40\x20\40\x20\x20\40\40\40\40\x20\x20\x20\40\x20\40\x20\x77\151\x6e\x64\157\167\x2e\157\x70\x65\156\x65\162\56\x72\x65\144\x69\162\145\143\x74\137\x74\x6f\137\141\164\164\x72\x69\x62\165\164\145\137\x6d\141\x70\x70\151\156\147\50\51\x3b\xd\12\x20\x20\40\x20\40\x20\x20\x20\x20\x20\40\x20\x20\40\x20\x20\40\163\x65\x6c\x66\x2e\143\154\x6f\x73\145\x28\51\73\xd\12\x9\11\x9\11\x7d\x20\x20\40\15\12\11\x9\x9\11\167\x69\x6e\x64\157\x77\x2e\157\156\x75\156\154\157\x61\144\40\x3d\40\x72\145\x66\162\x65\163\150\120\141\162\x65\156\x74\x3b\xd\xa\11\x20\40\x20\x66\x75\156\x63\164\x69\157\156\x20\162\145\x66\162\145\163\150\x50\141\x72\145\x6e\164\50\51\40\173\15\12\x9\x9\x20\x20\40\x77\151\156\144\157\167\56\x6f\x70\145\x6e\x65\x72\56\154\157\143\x61\164\x69\x6f\156\x2e\x72\x65\x6c\157\141\144\x28\x29\73\x20\x20\x20\40\40\40\40\15\12\x9\40\40\x20\x7d\40\40\x20\x20\x20\xd\12\x3c\x2f\x73\x63\162\151\160\164\x3e";
    die;
}
function mo_saml_convert_to_windows_iconv($Co)
{
    $K2 = get_option("\x6d\x6f\137\x73\x61\x6d\x6c\x5f\x65\x6e\143\x6f\x64\x69\x6e\x67\x5f\x65\x6e\141\x62\x6c\145\x64");
    if (!($K2 === '' || !mo_saml_is_extension_installed("\x69\x63\x6f\x6e\166"))) {
        goto g6;
    }
    return $Co;
    g6:
    return iconv("\125\124\x46\x2d\x38", "\103\120\61\x32\x35\x32\57\x2f\x49\107\116\117\122\105", $Co);
}
function mo_saml_login_user($gB, $SV, $W3, $vg, $JW, $pG, $BI, $KH, $EJ, $T5 = '', $dN = '', $Ef = null)
{
    $Ko = get_option("\x6d\x6f\137\x73\x61\x6d\154\137\163\160\137\x62\141\x73\x65\x5f\x75\x72\x6c");
    if (!empty($Ko)) {
        goto vu;
    }
    $Ko = home_url();
    vu:
    do_action("\155\157\x5f\163\x61\x6d\x6c\137\x61\x74\x74\162\151\x62\x75\x74\145\x73", $vg, $gB, $SV, $W3, $JW);
    if ($EJ == "\x75\x73\x65\x72\x6e\x61\155\x65" && username_exists($vg) || username_exists($vg)) {
        goto hO;
    }
    if (email_exists($gB)) {
        goto jX;
    }
    if (!username_exists($vg) && !email_exists($gB)) {
        goto Xh;
    }
    if (username_exists($vg) && !email_exists($gB)) {
        goto Sl;
    }
    goto ii;
    hO:
    $user = get_user_by("\154\x6f\147\x69\x6e", $vg);
    $eD = $user->ID;
    if (empty($SV)) {
        goto Vl;
    }
    $EO = wp_update_user(array("\x49\104" => $eD, "\146\x69\x72\163\164\137\156\x61\155\x65" => $SV));
    Vl:
    if (empty($W3)) {
        goto gK;
    }
    $EO = wp_update_user(array("\111\104" => $eD, "\x6c\141\163\164\137\156\141\x6d\145" => $W3));
    gK:
    if (empty($gB)) {
        goto td;
    }
    $EO = wp_update_user(array("\111\x44" => $eD, "\165\x73\x65\x72\137\x65\155\141\x69\x6c" => $gB));
    td:
    if (!get_option("\155\x6f\x5f\x73\x61\155\x6c\137\x63\x75\x73\x74\x6f\x6d\x5f\141\x74\164\162\x73\137\x6d\141\160\x70\x69\x6e\x67")) {
        goto A6;
    }
    $sM = get_option("\155\x6f\x5f\x73\x61\155\154\x5f\143\x75\x73\x74\157\155\x5f\141\164\x74\162\163\137\x6d\141\x70\160\x69\x6e\x67");
    $sM = maybe_unserialize($sM);
    foreach ($sM as $uZ => $Ka) {
        if (!array_key_exists($Ka, $Ef)) {
            goto uc;
        }
        $ju = $Ef[$Ka][0];
        update_user_meta($eD, $uZ, $ju);
        uc:
        Zd:
    }
    SA:
    A6:
    $e9 = get_option("\x73\x61\x6d\x6c\137\141\155\x5f\x64\x6f\x6e\x74\137\165\x70\x64\141\x74\145\137\x65\170\151\163\x74\151\x6e\x67\137\x75\x73\x65\x72\x5f\x72\x6f\154\x65");
    if (!empty($e9)) {
        goto Gu;
    }
    $e9 = "\x63\150\145\x63\x6b\x65\x64";
    Gu:
    if (!(empty($e9) || $e9 != "\x63\150\x65\x63\x6b\145\x64")) {
        goto ma;
    }
    $ey = get_option("\163\x61\x6d\x6c\x5f\141\x6d\137\x72\x6f\x6c\145\137\x6d\x61\160\x70\x69\x6e\147");
    $Gx = assign_roles_to_user($user, $ey, $JW);
    if ($Gx !== true && !is_administrator_user($user) && !empty($pG) && $pG == "\143\x68\145\x63\153\145\x64") {
        goto LM;
    }
    if ($Gx !== true && !is_administrator_user($user) && !empty($BI)) {
        goto VL;
    }
    goto PQ;
    LM:
    $EO = wp_update_user(array("\x49\104" => $eD, "\162\x6f\x6c\x65" => false));
    goto PQ;
    VL:
    $EO = wp_update_user(array("\x49\104" => $eD, "\x72\157\154\145" => $BI));
    PQ:
    ma:
    if (is_null($Ef)) {
        goto QF;
    }
    update_user_meta($eD, "\x6d\x6f\137\x73\x61\155\154\137\165\x73\x65\x72\x5f\x61\164\164\162\151\142\x75\x74\x65\x73", $Ef);
    $Jz = get_option("\x73\141\155\154\137\x61\155\x5f\144\151\x73\160\x6c\x61\171\137\x6e\141\155\145");
    if (empty($Jz)) {
        goto LH;
    }
    if (strcmp($Jz, "\125\x53\x45\x52\116\x41\115\x45") == 0) {
        goto I4;
    }
    if (strcmp($Jz, "\x46\x4e\101\115\105") == 0 && !empty($SV)) {
        goto uB;
    }
    if (strcmp($Jz, "\114\116\101\x4d\105") == 0 && !empty($W3)) {
        goto Yk;
    }
    if (strcmp($Jz, "\x46\116\101\x4d\105\x5f\114\116\101\115\x45") == 0 && !empty($W3) && !empty($SV)) {
        goto nU;
    }
    if (!(strcmp($Jz, "\x4c\x4e\x41\x4d\105\x5f\106\116\x41\115\105") == 0 && !empty($W3) && !empty($SV))) {
        goto OJ;
    }
    $EO = wp_update_user(array("\x49\x44" => $eD, "\x64\x69\163\x70\154\141\171\x5f\x6e\x61\x6d\145" => $W3 . "\x20" . $SV));
    OJ:
    goto m1;
    nU:
    $EO = wp_update_user(array("\111\x44" => $eD, "\144\x69\x73\x70\154\x61\171\x5f\x6e\x61\155\145" => $SV . "\40" . $W3));
    m1:
    goto cS;
    Yk:
    $EO = wp_update_user(array("\x49\x44" => $eD, "\x64\x69\x73\x70\154\141\x79\137\x6e\x61\x6d\x65" => $W3));
    cS:
    goto a4;
    uB:
    $EO = wp_update_user(array("\111\x44" => $eD, "\144\x69\x73\x70\x6c\141\x79\x5f\156\x61\x6d\145" => $SV));
    a4:
    goto UE;
    I4:
    $EO = wp_update_user(array("\x49\x44" => $eD, "\x64\x69\x73\160\x6c\x61\x79\137\156\x61\155\145" => $user->user_login));
    UE:
    LH:
    QF:
    wp_set_current_user($eD);
    wp_set_auth_cookie($eD);
    $user = get_user_by("\151\x64", $eD);
    do_action("\167\x70\x5f\x6c\x6f\147\151\156", $user->user_login, $user);
    if (empty($T5)) {
        goto Ne;
    }
    update_user_meta($eD, "\155\157\x5f\x73\x61\155\154\137\x73\x65\163\163\x69\157\156\x5f\x69\156\144\145\x78", $T5);
    Ne:
    if (empty($dN)) {
        goto KM;
    }
    update_user_meta($eD, "\x6d\157\137\x73\141\155\x6c\137\x6e\x61\155\x65\137\151\144", $dN);
    KM:
    if (!(!session_id() || session_id() == '' || !isset($_SESSION))) {
        goto Gt;
    }
    session_start();
    Gt:
    $_SESSION["\155\x6f\137\163\x61\155\154"]["\x6c\x6f\x67\147\x65\x64\137\x69\x6e\137\x77\151\x74\150\x5f\x69\144\x70"] = TRUE;
    $Ik = get_option("\155\157\137\x73\x61\155\154\x5f\x72\145\x6c\141\171\x5f\x73\164\141\x74\145");
    if (!empty($Ik)) {
        goto im;
    }
    if (!empty($KH)) {
        goto dv;
    }
    wp_redirect($Ko);
    goto r6;
    dv:
    if (filter_var($KH, FILTER_VALIDATE_URL) === FALSE) {
        goto Jf;
    }
    if (strpos($KH, home_url()) !== false) {
        goto iK;
    }
    wp_redirect($Ko);
    goto XF;
    iK:
    wp_redirect($KH);
    XF:
    goto xO;
    Jf:
    wp_redirect($KH);
    xO:
    r6:
    goto NI;
    im:
    wp_redirect($Ik);
    NI:
    die;
    goto ii;
    jX:
    $user = get_user_by("\x65\x6d\x61\x69\x6c", $gB);
    $eD = $user->ID;
    if (empty($SV)) {
        goto iJ;
    }
    $EO = wp_update_user(array("\111\104" => $eD, "\146\151\162\163\164\137\x6e\x61\x6d\x65" => $SV));
    iJ:
    if (empty($W3)) {
        goto ye;
    }
    $EO = wp_update_user(array("\111\104" => $eD, "\154\141\163\164\137\156\141\x6d\145" => $W3));
    ye:
    if (!get_option("\x6d\157\x5f\x73\x61\155\x6c\x5f\x63\x75\163\x74\157\155\x5f\x61\164\164\x72\x73\137\x6d\x61\160\160\x69\156\147")) {
        goto ix;
    }
    $sM = get_option("\155\x6f\137\x73\141\155\x6c\x5f\x63\x75\163\164\x6f\155\x5f\x61\x74\x74\162\163\137\155\x61\160\x70\151\x6e\x67");
    $sM = maybe_unserialize($sM);
    foreach ($sM as $uZ => $Ka) {
        if (!array_key_exists($Ka, $Ef)) {
            goto XV;
        }
        $ju = $Ef[$Ka][0];
        update_user_meta($eD, $uZ, $ju);
        XV:
        LU:
    }
    rh:
    ix:
    $ey = get_option("\163\141\x6d\154\x5f\141\155\x5f\x72\x6f\154\x65\x5f\155\x61\160\160\151\x6e\147");
    $e9 = get_option("\x73\x61\x6d\x6c\137\x61\155\137\x64\157\x6e\x74\137\165\x70\144\x61\164\x65\137\145\x78\x69\163\x74\151\156\147\137\x75\x73\145\162\137\162\157\x6c\145");
    if (!empty($e9)) {
        goto TB;
    }
    $e9 = "\x63\150\x65\x63\x6b\145\x64";
    TB:
    if (!(empty($e9) || $e9 != "\143\x68\145\x63\153\145\x64")) {
        goto su;
    }
    $Gx = assign_roles_to_user($user, $ey, $JW);
    if ($Gx !== true && !is_administrator_user($user) && !empty($pG) && $pG == "\143\150\x65\143\x6b\145\x64") {
        goto JN;
    }
    if ($Gx !== true && !is_administrator_user($user) && !empty($BI)) {
        goto pS;
    }
    goto Y4;
    JN:
    $EO = wp_update_user(array("\111\x44" => $eD, "\162\x6f\x6c\145" => false));
    goto Y4;
    pS:
    $EO = wp_update_user(array("\x49\x44" => $eD, "\162\x6f\154\145" => $BI));
    Y4:
    su:
    if (is_null($Ef)) {
        goto pP;
    }
    update_user_meta($eD, "\x6d\157\137\163\x61\x6d\x6c\x5f\165\163\x65\162\x5f\x61\x74\164\162\151\142\x75\x74\145\163", $Ef);
    $Jz = get_option("\163\141\x6d\x6c\137\141\x6d\x5f\144\x69\163\x70\154\141\171\137\x6e\x61\155\x65");
    if (empty($Jz)) {
        goto fo;
    }
    if (strcmp($Jz, "\x55\x53\105\122\116\101\x4d\105") == 0) {
        goto nd;
    }
    if (strcmp($Jz, "\106\116\x41\x4d\105") == 0 && !empty($SV)) {
        goto ln;
    }
    if (strcmp($Jz, "\x4c\116\x41\x4d\105") == 0 && !empty($W3)) {
        goto EZ;
    }
    if (strcmp($Jz, "\x46\x4e\x41\115\x45\x5f\x4c\116\101\x4d\x45") == 0 && !empty($W3) && !empty($SV)) {
        goto PA;
    }
    if (!(strcmp($Jz, "\114\116\x41\115\x45\x5f\106\x4e\101\115\x45") == 0 && !empty($W3) && !empty($SV))) {
        goto ah;
    }
    $EO = wp_update_user(array("\111\x44" => $eD, "\x64\151\x73\160\154\141\x79\137\156\x61\155\x65" => $W3 . "\x20" . $SV));
    ah:
    goto rP;
    PA:
    $EO = wp_update_user(array("\111\x44" => $eD, "\x64\x69\163\160\154\x61\171\137\156\141\155\x65" => $SV . "\x20" . $W3));
    rP:
    goto V3;
    EZ:
    $EO = wp_update_user(array("\111\104" => $eD, "\144\x69\x73\x70\154\141\171\x5f\x6e\x61\155\145" => $W3));
    V3:
    goto zs;
    ln:
    $EO = wp_update_user(array("\x49\x44" => $eD, "\144\151\x73\x70\154\x61\171\137\x6e\x61\155\x65" => $SV));
    zs:
    goto zn;
    nd:
    $EO = wp_update_user(array("\x49\x44" => $eD, "\144\x69\x73\x70\154\141\171\137\156\x61\x6d\x65" => $user->user_login));
    zn:
    fo:
    pP:
    wp_set_current_user($eD);
    wp_set_auth_cookie($eD);
    $user = get_user_by("\x69\144", $eD);
    do_action("\167\x70\x5f\154\157\x67\151\x6e", $user->user_login, $user);
    if (empty($T5)) {
        goto mA;
    }
    update_user_meta($eD, "\155\x6f\x5f\x73\141\x6d\154\x5f\163\x65\x73\x73\151\x6f\x6e\137\x69\156\x64\x65\170", $T5);
    mA:
    if (empty($dN)) {
        goto bf;
    }
    update_user_meta($eD, "\x6d\x6f\137\163\x61\x6d\154\x5f\156\141\155\x65\x5f\x69\x64", $dN);
    bf:
    if (!(!session_id() || session_id() == '' || !isset($_SESSION))) {
        goto rQ;
    }
    session_start();
    rQ:
    $_SESSION["\155\x6f\137\163\141\155\x6c"]["\x6c\157\147\147\145\144\137\151\156\137\167\151\164\150\137\151\x64\160"] = TRUE;
    $Ik = get_option("\155\157\x5f\163\141\155\154\137\162\145\x6c\x61\x79\x5f\x73\164\141\164\x65");
    if (!empty($Ik)) {
        goto Sp;
    }
    if (!empty($KH)) {
        goto nt;
    }
    wp_redirect($Ko);
    goto e2;
    nt:
    if (filter_var($KH, FILTER_VALIDATE_URL) === FALSE) {
        goto GE;
    }
    if (strpos($KH, home_url()) !== false) {
        goto zu;
    }
    wp_redirect($Ko);
    goto Uq;
    zu:
    wp_redirect($KH);
    Uq:
    goto sc;
    GE:
    wp_redirect($KH);
    sc:
    e2:
    goto Py;
    Sp:
    wp_redirect($Ik);
    Py:
    die;
    goto ii;
    Xh:
    $ey = get_option("\163\x61\155\x6c\x5f\141\155\137\x72\x6f\x6c\145\x5f\155\141\x70\160\151\156\x67");
    $hw = true;
    $zp = get_option("\x6d\157\137\163\141\x6d\x6c\137\144\157\x6e\x74\x5f\143\x72\x65\141\x74\x65\137\165\x73\x65\x72\137\151\146\137\x72\x6f\154\145\x5f\156\157\x74\x5f\x6d\x61\160\160\145\x64");
    if (!(!empty($zp) && strcmp($zp, "\143\150\145\143\153\145\144") == 0)) {
        goto kC;
    }
    $br = is_role_mapping_configured_for_user($ey, $JW);
    $hw = $br;
    kC:
    if ($hw === true) {
        goto o3;
    }
    $eg = "\127\x65\40\143\x6f\165\x6c\x64\x20\156\x6f\x74\x20\163\x69\147\156\x20\171\x6f\x75\x20\151\156\x2e\x20\120\154\x65\x61\163\145\x20\143\x6f\156\164\x61\x63\x74\x20\x79\157\x75\162\x20\x41\144\155\x69\x6e\151\x73\x74\162\141\x74\x6f\162\x2e";
    wp_die($eg, "\x45\162\162\157\x72\x3a\40\116\157\x74\x20\141\40\x57\x6f\162\144\x50\x72\x65\163\x73\x20\x4d\x65\x6d\x62\145\x72");
    die;
    goto Di;
    o3:
    $qc = wp_generate_password(10, false);
    if (!empty($vg)) {
        goto ux;
    }
    $eD = wp_create_user($gB, $qc, $gB);
    goto VO;
    ux:
    $eD = wp_create_user($vg, $qc, $gB);
    VO:
    if (!is_wp_error($eD)) {
        goto p3;
    }
    wp_die($eD->get_error_message());
    p3:
    $user = get_user_by("\x69\144", $eD);
    $Gx = assign_roles_to_user($user, $ey, $JW);
    if ($Gx !== true && !empty($pG) && $pG == "\x63\x68\145\x63\x6b\145\x64") {
        goto u0;
    }
    if ($Gx !== true && !empty($BI)) {
        goto xc;
    }
    if ($Gx !== true) {
        goto Rt;
    }
    goto UB;
    u0:
    $EO = wp_update_user(array("\x49\104" => $eD, "\162\x6f\154\145" => false));
    goto UB;
    xc:
    $EO = wp_update_user(array("\x49\x44" => $eD, "\162\x6f\154\x65" => $BI));
    goto UB;
    Rt:
    $BI = get_option("\x64\145\146\141\165\154\164\137\x72\x6f\154\x65");
    $EO = wp_update_user(array("\111\104" => $eD, "\x72\x6f\x6c\x65" => $BI));
    UB:
    if (empty($SV)) {
        goto d1;
    }
    $EO = wp_update_user(array("\111\104" => $eD, "\x66\151\x72\x73\164\x5f\156\141\155\x65" => $SV));
    d1:
    if (empty($W3)) {
        goto Ku;
    }
    $EO = wp_update_user(array("\x49\x44" => $eD, "\154\x61\163\164\137\156\x61\x6d\145" => $W3));
    Ku:
    if (is_null($Ef)) {
        goto hV;
    }
    update_user_meta($eD, "\155\157\x5f\x73\x61\x6d\154\137\x75\163\145\162\137\141\x74\164\162\x69\x62\x75\164\145\163", $Ef);
    $Jz = get_option("\163\141\155\x6c\137\x61\155\x5f\x64\x69\x73\x70\154\x61\x79\x5f\x6e\141\155\145");
    if (empty($Jz)) {
        goto Qr;
    }
    if (strcmp($Jz, "\125\123\x45\122\116\101\115\x45") == 0) {
        goto oY;
    }
    if (strcmp($Jz, "\x46\x4e\101\x4d\105") == 0 && !empty($SV)) {
        goto Hh;
    }
    if (strcmp($Jz, "\x4c\116\x41\x4d\105") == 0 && !empty($W3)) {
        goto Rk;
    }
    if (strcmp($Jz, "\106\116\x41\115\105\x5f\x4c\116\101\115\x45") == 0 && !empty($W3) && !empty($SV)) {
        goto QV;
    }
    if (!(strcmp($Jz, "\114\116\x41\x4d\105\137\x46\x4e\101\x4d\105") == 0 && !empty($W3) && !empty($SV))) {
        goto Ca;
    }
    $EO = wp_update_user(array("\111\x44" => $eD, "\x64\151\x73\160\x6c\x61\171\x5f\156\x61\x6d\x65" => $W3 . "\x20" . $SV));
    Ca:
    goto NP;
    QV:
    $EO = wp_update_user(array("\111\104" => $eD, "\x64\x69\163\x70\154\x61\171\x5f\x6e\141\155\x65" => $SV . "\40" . $W3));
    NP:
    goto K3;
    Rk:
    $EO = wp_update_user(array("\x49\104" => $eD, "\x64\151\163\x70\154\x61\171\x5f\156\141\x6d\145" => $W3));
    K3:
    goto cT;
    Hh:
    $EO = wp_update_user(array("\x49\104" => $eD, "\144\151\163\x70\x6c\141\171\137\156\x61\x6d\145" => $SV));
    cT:
    goto ex;
    oY:
    $EO = wp_update_user(array("\111\x44" => $eD, "\144\151\163\160\x6c\141\x79\x5f\156\x61\155\145" => $user->user_login));
    ex:
    Qr:
    hV:
    wp_set_current_user($eD);
    wp_set_auth_cookie($eD);
    $user = get_user_by("\x69\x64", $eD);
    do_action("\165\163\x65\x72\137\162\x65\147\151\x73\x74\x65\x72", $eD);
    do_action("\x77\160\x5f\154\x6f\147\x69\x6e", $user->user_login, $user);
    if (empty($T5)) {
        goto xl;
    }
    update_user_meta($eD, "\x6d\157\x5f\x73\x61\155\154\x5f\x73\145\163\x73\x69\x6f\156\137\151\156\x64\145\x78", $T5);
    xl:
    if (empty($dN)) {
        goto XB;
    }
    update_user_meta($eD, "\155\157\137\x73\x61\155\x6c\137\156\x61\x6d\x65\x5f\x69\x64", $dN);
    XB:
    if (!get_option("\155\157\137\x73\141\x6d\x6c\x5f\143\x75\163\x74\x6f\155\137\x61\164\x74\x72\x73\137\x6d\141\160\160\151\156\147")) {
        goto O9;
    }
    $sM = get_option("\x6d\x6f\x5f\x73\141\x6d\154\137\x63\165\x73\164\x6f\x6d\x5f\141\164\164\x72\163\x5f\155\x61\x70\160\151\x6e\147");
    $sM = maybe_unserialize($sM);
    foreach ($sM as $uZ => $Ka) {
        if (!array_key_exists($Ka, $Ef)) {
            goto tp;
        }
        $ju = $Ef[$Ka][0];
        update_user_meta($eD, $uZ, $ju);
        tp:
        V8:
    }
    Xy:
    O9:
    if (!(!session_id() || session_id() == '' || !isset($_SESSION))) {
        goto DE;
    }
    session_start();
    DE:
    $_SESSION["\155\157\137\163\141\x6d\x6c"]["\x6c\157\147\147\145\144\x5f\x69\x6e\x5f\167\x69\164\150\137\x69\144\x70"] = TRUE;
    Di:
    $Ik = get_option("\155\x6f\x5f\x73\x61\155\154\x5f\162\x65\154\141\171\137\x73\x74\141\x74\145");
    if (!empty($Ik)) {
        goto eY;
    }
    if (!empty($KH)) {
        goto ar;
    }
    wp_redirect($Ko);
    goto gT;
    ar:
    if (filter_var($KH, FILTER_VALIDATE_URL) === FALSE) {
        goto yB;
    }
    if (strpos($KH, home_url()) !== false) {
        goto Tv;
    }
    wp_redirect($Ko);
    goto cH;
    Tv:
    wp_redirect($KH);
    cH:
    goto vi;
    yB:
    wp_redirect($KH);
    vi:
    gT:
    goto Ef;
    eY:
    wp_redirect($Ik);
    Ef:
    die;
    goto ii;
    Sl:
    wp_die("\x52\145\147\x69\x73\164\x72\x61\164\x69\x6f\x6e\40\x68\x61\163\40\x66\141\151\154\x65\144\40\141\163\x20\141\40\x75\163\145\162\x20\x77\x69\164\150\40\x74\x68\x65\40\x73\x61\155\145\x20\165\x73\145\x72\x6e\x61\x6d\145\x20\141\154\162\x65\141\x64\171\40\145\x78\151\x73\x74\163\40\151\x6e\x20\127\157\162\x64\x50\162\145\x73\x73\x2e\x20\120\154\x65\x61\163\145\x20\x61\x73\x6b\40\171\x6f\x75\x72\40\141\x64\x6d\x69\156\x69\x73\164\162\141\164\x6f\x72\x20\x74\157\40\x63\x72\145\141\x74\145\40\x61\156\x20\x61\x63\x63\x6f\x75\x6e\164\40\146\157\162\x20\171\x6f\x75\40\167\151\164\x68\x20\141\x20\165\x6e\151\x71\165\145\40\x75\x73\145\162\x6e\x61\155\x65\56", "\105\x72\162\x6f\x72");
    ii:
}
function assign_roles_to_user($user, $ey, $JW)
{
    $Gx = false;
    if (!(!empty($JW) && !empty($ey) && !is_administrator_user($user))) {
        goto mp;
    }
    $user->set_role(false);
    $cD = '';
    $j1 = false;
    foreach ($ey as $dE => $Hn) {
        $T_ = explode("\73", $Hn);
        foreach ($T_ as $wr) {
            foreach ($JW as $jW) {
                $jW = trim($jW);
                if (!(!empty($jW) && $jW == $wr)) {
                    goto pu;
                }
                $Gx = true;
                $user->add_role($dE);
                pu:
                G7:
            }
            Xz:
            iH:
        }
        Ps:
        S9:
    }
    xt:
    mp:
    return $Gx;
}
function is_role_mapping_configured_for_user($ey, $JW)
{
    if (!(!empty($JW) && !empty($ey))) {
        goto Ok;
    }
    foreach ($ey as $dE => $Hn) {
        $T_ = explode("\73", $Hn);
        foreach ($T_ as $wr) {
            foreach ($JW as $jW) {
                $jW = trim($jW);
                if (!(!empty($jW) && $jW == $wr)) {
                    goto K2;
                }
                return true;
                K2:
                HZ:
            }
            vp:
            Gf:
        }
        qh:
        tB:
    }
    Gc:
    Ok:
    return false;
}
function is_administrator_user($user)
{
    $gX = $user->roles;
    if (!is_null($gX) && in_array("\141\144\155\x69\x6e\x69\x73\x74\x72\141\x74\157\162", $gX, TRUE)) {
        goto eo;
    }
    return false;
    goto dj;
    eo:
    return true;
    dj:
}
function mo_saml_is_customer_license_verified()
{
    $uZ = get_option("\x6d\x6f\x5f\x73\x61\155\x6c\137\x63\165\163\164\157\x6d\145\162\x5f\x74\157\153\x65\x6e");
    $gw = AESEncryption::decrypt_data(get_option("\164\137\x73\x69\164\145\x5f\163\164\x61\x74\165\x73"), $uZ);
    $v4 = get_option("\163\155\x6c\137\154\x6b");
    $bz = get_option("\155\x6f\137\x73\x61\155\154\x5f\x61\x64\155\x69\156\x5f\x65\x6d\x61\151\154");
    $e6 = get_option("\155\157\x5f\163\x61\x6d\x6c\x5f\x61\144\x6d\151\156\x5f\x63\165\163\x74\x6f\x6d\145\x72\137\x6b\145\171");
    if (!$gw && !$v4 || !$bz || !$e6 || !is_numeric(trim($e6))) {
        goto Iz;
    }
    return 1;
    goto Rg;
    Iz:
    return 0;
    Rg:
}
function saml_get_current_page_url()
{
    $Ut = $_SERVER["\x48\124\124\120\x5f\x48\117\123\124"];
    if (!(substr($Ut, -1) == "\57")) {
        goto LV;
    }
    $Ut = substr($Ut, 0, -1);
    LV:
    $m5 = $_SERVER["\x52\x45\x51\x55\105\123\x54\x5f\125\x52\x49"];
    if (!(substr($m5, 0, 1) == "\x2f")) {
        goto fk;
    }
    $m5 = substr($m5, 1);
    fk:
    $qM = isset($_SERVER["\x48\124\124\120\x53"]) && strcasecmp($_SERVER["\110\124\124\120\123"], "\x6f\x6e") == 0;
    $ml = "\150\164\164\x70" . ($qM ? "\163" : '') . "\x3a\x2f\x2f" . $Ut . "\x2f" . $m5;
    return $ml;
}
function show_status_error($RR, $KH, $f1)
{
    $RR = strip_tags($RR);
    $f1 = strip_tags($f1);
    if ($KH == "\164\145\163\x74\x56\x61\154\151\x64\141\x74\145" or $KH == "\x74\x65\x73\x74\116\145\x77\103\145\x72\x74\x69\146\x69\x63\141\x74\x65") {
        goto rR;
    }
    wp_die("\x57\x65\x20\143\x6f\165\154\x64\x20\156\x6f\x74\40\163\x69\147\156\40\x79\157\165\40\151\x6e\56\40\120\x6c\x65\141\x73\x65\x20\143\x6f\156\x74\x61\143\164\x20\x79\x6f\165\162\40\x41\144\x6d\x69\x6e\x69\163\x74\x72\x61\164\157\x72\56", "\x45\162\x72\157\x72\x3a\x20\111\156\166\x61\154\151\x64\40\x53\101\115\114\40\122\x65\163\160\x6f\156\163\145\x20\x53\x74\141\164\x75\x73");
    goto Hm;
    rR:
    echo "\74\x64\x69\166\40\x73\x74\x79\154\x65\75\42\146\157\x6e\x74\x2d\146\x61\155\x69\x6c\x79\x3a\x43\x61\154\151\x62\162\151\73\160\x61\x64\x64\151\x6e\147\x3a\60\x20\x33\45\73\42\76";
    echo "\74\x64\151\166\x20\x73\x74\x79\x6c\145\x3d\x22\143\157\154\157\162\x3a\40\43\141\71\64\x34\64\x32\73\142\141\143\x6b\147\x72\x6f\x75\x6e\144\x2d\143\157\154\x6f\162\x3a\40\43\146\x32\x64\145\x64\x65\x3b\x70\x61\x64\144\151\x6e\147\x3a\x20\61\x35\x70\x78\x3b\x6d\x61\x72\x67\151\x6e\55\142\x6f\x74\164\157\155\72\x20\62\x30\x70\170\73\x74\x65\170\164\55\x61\154\151\x67\x6e\x3a\143\x65\x6e\164\x65\x72\73\x62\157\162\144\x65\162\72\x31\x70\170\40\x73\157\x6c\x69\144\x20\43\x45\66\x42\x33\102\x32\73\146\x6f\x6e\x74\x2d\x73\151\x7a\145\72\x31\x38\160\x74\x3b\42\76\x20\105\122\122\x4f\122\x3c\57\x64\x69\166\x3e\xd\xa\40\40\x20\40\x20\x20\x20\40\40\40\40\40\x20\x20\40\x20\x3c\x64\151\x76\x20\x73\164\x79\x6c\145\x3d\42\x63\157\154\x6f\x72\x3a\40\43\x61\x39\x34\x34\64\62\73\x66\x6f\x6e\164\55\x73\x69\172\145\72\61\64\160\x74\73\40\x6d\x61\x72\147\151\x6e\55\142\x6f\x74\164\157\155\72\62\60\x70\170\x3b\x22\76\74\x70\x3e\x3c\x73\164\x72\157\x6e\147\76\x45\162\x72\x6f\162\x3a\x20\74\57\163\x74\162\157\156\147\76\40\x49\156\166\141\154\151\x64\x20\x53\101\x4d\x4c\x20\122\x65\x73\x70\157\156\163\x65\40\123\x74\x61\164\165\x73\56\74\x2f\160\x3e\xd\xa\x20\x20\40\40\x20\40\x20\40\x20\x20\40\40\x20\x20\x20\40\74\160\76\x3c\x73\x74\x72\157\x6e\x67\76\x43\x61\x75\163\145\x73\74\x2f\163\164\162\157\156\147\76\x3a\x20\111\x64\145\x6e\164\151\164\x79\40\120\162\x6f\x76\151\x64\145\162\40\x68\x61\x73\40\163\x65\x6e\x74\40\x27" . $RR . "\47\40\x73\x74\141\164\x75\x73\40\143\157\x64\x65\40\151\x6e\40\x53\x41\x4d\114\40\x52\145\163\x70\157\x6e\163\x65\x2e\x20\x3c\57\x70\76\15\12\x9\x9\x9\x9\11\11\11\11\74\x70\x3e\x3c\x73\x74\x72\x6f\x6e\x67\76\x52\x65\x61\163\157\x6e\74\x2f\x73\164\162\157\x6e\x67\x3e\72\x20" . get_status_message($RR) . "\x3c\57\160\x3e\x20";
    if (empty($f1)) {
        goto Iq;
    }
    echo "\x3c\160\x3e\x3c\x73\164\x72\157\x6e\x67\76\123\x74\x61\164\165\x73\40\115\145\163\163\141\x67\145\x20\x69\156\40\164\150\x65\40\x53\101\x4d\114\40\x52\145\163\x70\x6f\156\x73\145\72\74\x2f\x73\x74\x72\157\x6e\147\76\40\74\142\162\x2f\76" . $f1 . "\x3c\x2f\160\x3e";
    Iq:
    echo "\x3c\142\162\x3e\15\xa\11\11\x9\x9\74\57\x64\x69\166\76\15\xa\xd\xa\40\x20\x20\x20\40\40\x20\40\40\40\x20\40\40\x20\x20\40\74\144\x69\166\40\163\x74\171\x6c\145\75\42\155\x61\x72\147\151\x6e\72\x33\x25\x3b\x64\151\163\160\154\141\x79\72\x62\154\157\143\x6b\x3b\164\145\170\164\55\141\154\x69\x67\156\72\x63\x65\156\x74\145\x72\73\x22\x3e\15\xa\40\40\x20\40\x20\x20\x20\40\40\40\x20\40\40\x20\40\x20\74\144\x69\x76\x20\163\x74\171\154\x65\75\42\155\x61\x72\147\151\x6e\x3a\x33\45\x3b\144\151\x73\160\x6c\x61\x79\72\142\x6c\x6f\x63\x6b\73\164\x65\170\164\x2d\x61\154\151\x67\x6e\72\143\145\156\x74\x65\x72\73\42\76\x3c\151\x6e\x70\x75\164\40\x73\x74\x79\154\x65\x3d\x22\160\x61\x64\x64\x69\x6e\147\x3a\61\45\73\x77\x69\x64\164\x68\x3a\x31\60\x30\160\x78\x3b\x62\x61\x63\153\147\162\x6f\x75\x6e\x64\x3a\x20\43\60\60\71\x31\x43\104\40\x6e\x6f\156\145\x20\x72\x65\x70\x65\141\164\x20\163\x63\x72\157\x6c\154\40\60\x25\40\60\45\x3b\x63\x75\x72\163\157\x72\72\40\x70\157\151\156\x74\x65\162\73\x66\x6f\x6e\x74\x2d\x73\x69\172\x65\72\61\65\x70\170\x3b\142\x6f\x72\x64\x65\162\55\x77\x69\x64\164\150\x3a\x20\x31\160\x78\x3b\142\157\162\144\x65\162\x2d\163\x74\171\x6c\145\x3a\x20\163\157\x6c\x69\144\73\x62\157\162\x64\145\162\x2d\162\141\x64\151\165\x73\x3a\x20\63\x70\170\73\167\150\151\164\145\55\x73\x70\141\x63\x65\72\x20\156\157\x77\162\x61\x70\73\142\x6f\170\x2d\x73\151\172\x69\156\147\x3a\40\x62\157\x72\x64\145\162\x2d\x62\x6f\170\x3b\x62\x6f\x72\x64\x65\x72\55\x63\157\154\x6f\162\x3a\x20\43\60\60\x37\x33\x41\x41\x3b\x62\157\170\55\163\150\x61\144\157\x77\x3a\x20\60\160\x78\x20\x31\160\x78\x20\x30\x70\170\x20\x72\x67\x62\x61\50\61\62\60\54\x20\x32\x30\x30\x2c\40\62\x33\60\x2c\40\60\x2e\66\x29\40\x69\x6e\163\x65\x74\73\x63\x6f\x6c\157\162\72\40\43\x46\106\x46\x3b\x22\x74\x79\160\145\x3d\42\x62\x75\x74\x74\x6f\x6e\x22\40\x76\x61\154\165\145\x3d\x22\x44\x6f\156\145\x22\40\157\x6e\103\x6c\151\143\x6b\x3d\x22\x73\x65\154\146\56\143\x6c\x6f\163\145\x28\51\73\x22\x3e\x3c\x2f\x64\x69\x76\76";
    die;
    Hm:
}
function get_status_message($RR)
{
    switch ($RR) {
        case "\122\145\161\165\x65\x73\164\145\162":
            return "\124\150\145\x20\162\x65\x71\x75\145\x73\x74\40\x63\x6f\165\154\144\40\x6e\x6f\x74\40\x62\x65\x20\x70\145\162\146\157\162\155\145\144\40\144\165\x65\x20\164\x6f\x20\x61\156\40\145\162\x72\157\162\x20\157\x6e\40\164\150\x65\x20\x70\141\162\x74\x20\x6f\x66\x20\164\x68\x65\x20\162\145\x71\165\x65\163\x74\x65\162\56";
            goto BR;
        case "\122\x65\163\x70\157\x6e\144\145\x72":
            return "\124\150\145\x20\162\145\161\165\x65\163\164\40\143\157\x75\x6c\x64\40\156\157\164\x20\x62\x65\x20\x70\x65\x72\x66\x6f\162\155\x65\x64\40\144\165\145\40\x74\157\40\141\x6e\x20\x65\162\162\157\162\x20\157\x6e\x20\164\150\145\x20\160\x61\x72\164\x20\x6f\146\40\164\x68\145\40\123\101\x4d\x4c\40\162\x65\x73\x70\157\x6e\144\145\162\x20\x6f\x72\x20\x53\x41\115\x4c\40\x61\x75\x74\150\x6f\162\x69\x74\171\x2e";
            goto BR;
        case "\x56\x65\162\x73\151\157\x6e\x4d\151\x73\x6d\x61\x74\143\150":
            return "\124\150\x65\40\x53\x41\115\x4c\x20\x72\145\163\160\157\x6e\x64\x65\162\40\x63\x6f\165\154\144\x20\156\157\x74\x20\x70\x72\x6f\143\x65\x73\163\40\164\x68\145\40\162\145\161\165\145\163\164\40\x62\145\x63\141\165\x73\x65\40\164\x68\x65\40\x76\x65\162\x73\151\157\156\40\x6f\146\x20\x74\150\x65\40\162\145\x71\x75\145\163\x74\x20\x6d\145\x73\x73\141\147\145\40\167\x61\163\x20\x69\156\x63\x6f\x72\x72\145\143\164\x2e";
            goto BR;
        default:
            return "\125\x6e\153\x6e\x6f\x77\156";
    }
    cr:
    BR:
}
function mo_saml_register_widget()
{
    register_widget("\x6d\x6f\x5f\x6c\x6f\147\x69\x6e\x5f\x77\151\x64");
}
function addLink($QX, $qt)
{
    $rV = "\74\141\40\150\162\145\146\75\42" . $qt . "\42\x3e" . $QX . "\74\57\141\x3e";
    return $rV;
}
add_action("\167\151\x64\147\145\x74\x73\x5f\x69\x6e\151\164", "\155\157\137\163\141\x6d\154\137\162\x65\x67\151\x73\164\x65\162\x5f\167\x69\x64\x67\x65\164");
add_action("\151\156\151\x74", "\x6d\157\137\154\x6f\x67\151\156\x5f\x76\x61\x6c\x69\x64\141\x74\145");
?>
