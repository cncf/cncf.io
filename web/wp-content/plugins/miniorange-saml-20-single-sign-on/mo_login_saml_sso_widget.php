<?php


include_once dirname(__FILE__) . "\57\x55\x74\151\154\151\x74\x69\145\x73\56\x70\x68\x70";
include_once dirname(__FILE__) . "\57\122\145\163\x70\157\x6e\x73\x65\x2e\x70\x68\x70";
include_once "\x78\155\x6c\x73\145\143\x6c\151\x62\163\x2e\x70\150\160";
use RobRichards\XMLSecLibs\XMLSecurityKey;
use RobRichards\XMLSecLibs\XMLSecurityDSig;
use RobRichards\XMLSecLibs\XMLSecEnc;
if (class_exists("\x41\x45\x53\105\156\x63\x72\x79\x70\x74\151\x6f\156")) {
    goto Gk;
}
require_once dirname(__FILE__) . "\x2f\x69\x6e\x63\154\165\x64\x65\x73\x2f\x6c\x69\142\x2f\145\156\x63\162\171\x70\x74\151\x6f\156\56\160\x68\x70";
Gk:
class mo_login_wid extends WP_Widget
{
    public function __construct()
    {
        $Ay = get_option("\163\x61\x6d\154\137\151\144\x65\x6e\x74\x69\164\171\x5f\156\x61\x6d\x65");
        parent::__construct("\x53\141\155\154\137\114\x6f\147\151\156\137\x57\x69\x64\147\145\164", "\114\x6f\147\151\156\40\x77\x69\x74\x68\x20" . $Ay, array("\x64\x65\163\143\162\151\x70\164\151\157\156" => __("\124\150\151\163\x20\151\163\x20\x61\40\155\151\156\151\x4f\162\141\x6e\147\145\x20\123\x41\x4d\x4c\x20\154\157\147\151\156\40\167\x69\144\147\x65\164\56", "\x6d\x6f\x73\x61\155\x6c")));
    }
    public function widget($vP, $PB)
    {
        extract($vP);
        $r1 = apply_filters("\167\x69\x64\x67\x65\x74\137\164\151\x74\x6c\x65", $PB["\x77\x69\x64\137\x74\151\x74\154\145"]);
        echo $vP["\142\145\x66\x6f\x72\145\x5f\x77\x69\144\147\x65\164"];
        if (empty($r1)) {
            goto PV;
        }
        echo $vP["\142\x65\146\157\x72\x65\x5f\x74\x69\164\x6c\145"] . $r1 . $vP["\x61\x66\164\145\x72\137\164\151\164\x6c\x65"];
        PV:
        $this->loginForm();
        echo $vP["\141\146\164\145\x72\x5f\167\151\x64\147\x65\x74"];
    }
    public function update($fO, $MD)
    {
        $PB = array();
        $PB["\167\151\144\x5f\x74\x69\164\154\x65"] = strip_tags($fO["\x77\x69\144\137\164\x69\164\x6c\145"]);
        return $PB;
    }
    public function form($PB)
    {
        $r1 = '';
        if (!array_key_exists("\167\x69\144\137\x74\x69\x74\x6c\x65", $PB)) {
            goto NR;
        }
        $r1 = $PB["\x77\x69\x64\137\164\151\164\x6c\145"];
        NR:
        echo "\12\11\11\x3c\x70\76\x3c\x6c\141\142\145\154\40\146\x6f\162\x3d\42" . $this->get_field_id("\x77\151\x64\137\164\151\x74\154\x65") . "\x20\42\76" . _e("\124\x69\164\x6c\145\72") . "\40\74\57\154\141\142\x65\154\x3e\12\11\x9\74\151\156\x70\165\x74\40\143\x6c\x61\x73\x73\x3d\42\167\151\x64\145\x66\x61\164\x22\x20\151\x64\75\x22" . $this->get_field_id("\167\x69\x64\x5f\164\x69\x74\x6c\x65") . "\x22\40\156\x61\x6d\145\75\x22" . $this->get_field_name("\x77\151\x64\137\x74\x69\x74\154\x65") . "\42\x20\164\171\x70\x65\75\x22\x74\145\170\164\x22\x20\x76\x61\x6c\165\145\75\42" . $r1 . "\x22\40\57\76\xa\x9\x9\x3c\x2f\x70\76";
    }
    public function loginForm()
    {
        if (!is_user_logged_in()) {
            goto LM;
        }
        $current_user = wp_get_current_user();
        $FX = "\x48\145\154\x6c\x6f\54";
        if (!get_option("\x6d\157\x5f\x73\x61\x6d\154\137\x63\165\x73\164\x6f\x6d\137\147\162\x65\x65\164\x69\156\x67\x5f\x74\145\x78\x74")) {
            goto FV;
        }
        $FX = get_option("\155\x6f\137\163\x61\x6d\x6c\x5f\x63\x75\x73\164\x6f\x6d\137\x67\162\x65\x65\164\x69\x6e\x67\137\x74\145\x78\x74");
        FV:
        $rM = '';
        if (!get_option("\x6d\x6f\x5f\163\141\x6d\154\x5f\147\x72\x65\145\164\x69\x6e\147\x5f\156\x61\155\145")) {
            goto dn;
        }
        switch (get_option("\x6d\x6f\137\x73\141\x6d\154\x5f\x67\x72\x65\145\x74\x69\x6e\147\137\156\x61\x6d\145")) {
            case "\125\x53\105\x52\x4e\x41\x4d\x45":
                $rM = $current_user->user_login;
                goto TA;
            case "\105\x4d\101\x49\114":
                $rM = $current_user->user_email;
                goto TA;
            case "\x46\116\101\x4d\105":
                $rM = $current_user->user_firstname;
                goto TA;
            case "\114\116\x41\x4d\x45":
                $rM = $current_user->user_lastname;
                goto TA;
            case "\x46\x4e\x41\x4d\x45\x5f\114\x4e\x41\115\x45":
                $rM = $current_user->user_firstname . "\40" . $current_user->user_lastname;
                goto TA;
            case "\114\116\101\115\x45\137\x46\x4e\101\x4d\x45":
                $rM = $current_user->user_lastname . "\x20" . $current_user->user_firstname;
                goto TA;
            default:
                $rM = $current_user->user_login;
        }
        kS:
        TA:
        dn:
        if (!empty(trim($rM))) {
            goto ql;
        }
        $rM = $current_user->user_login;
        ql:
        $EW = $FX . "\x20" . $rM;
        $FB = "\x4c\x6f\x67\x6f\165\x74";
        if (!get_option("\155\157\x5f\163\x61\155\154\x5f\143\x75\163\164\157\x6d\137\154\157\x67\x6f\165\164\x5f\164\x65\170\164")) {
            goto eU;
        }
        $FB = get_option("\x6d\157\x5f\x73\141\155\154\x5f\x63\165\163\x74\157\x6d\x5f\154\157\x67\157\x75\x74\137\164\x65\170\x74");
        eU:
        echo $EW . "\40\174\40\74\141\40\150\162\145\146\75\x22" . wp_logout_url(home_url()) . "\x22\x20\164\x69\164\154\145\x3d\x22\x6c\157\x67\157\165\x74\42\40\x3e" . $FB . "\x3c\x2f\x61\x3e\x3c\57\154\x69\76";
        $px = saml_get_current_page_url();
        update_option("\x6c\x6f\x67\x6f\x75\x74\137\x72\x65\144\151\x72\x65\x63\x74\x5f\x75\x72\x6c", $px);
        goto PB;
        LM:
        $Kz = saml_get_current_page_url();
        echo "\12\11\x9\x3c\x73\x63\x72\x69\160\164\x3e\12\x9\11\x66\x75\156\143\164\x69\x6f\156\40\163\x75\x62\x6d\151\164\123\141\155\x6c\x46\157\162\x6d\50\51\173\40\x64\157\143\x75\x6d\145\x6e\164\x2e\147\x65\164\x45\154\x65\x6d\145\x6e\x74\x42\171\111\x64\x28\x22\155\151\x6e\x69\x6f\x72\141\x6e\x67\145\x2d\x73\x61\155\x6c\x2d\163\x70\55\163\x73\157\55\x6c\x6f\147\x69\156\55\x66\157\x72\155\42\x29\56\x73\165\142\x6d\151\164\50\x29\73\x20\x7d\xa\11\x9\x3c\x2f\x73\143\x72\151\160\x74\76\xa\11\x9\74\x66\157\162\155\x20\156\141\155\145\75\42\x6d\x69\x6e\x69\x6f\x72\141\x6e\147\145\x2d\x73\141\155\x6c\x2d\163\160\55\x73\163\157\55\x6c\x6f\x67\x69\156\x2d\146\157\x72\x6d\x22\x20\151\144\75\42\x6d\x69\156\x69\x6f\162\x61\x6e\x67\x65\x2d\x73\141\x6d\x6c\x2d\163\160\x2d\x73\x73\x6f\55\154\157\147\x69\x6e\x2d\146\157\x72\x6d\x22\40\155\145\x74\150\157\x64\75\x22\x70\x6f\163\x74\42\x20\x61\x63\164\x69\157\x6e\75\42\42\76\12\11\11\74\151\x6e\x70\x75\164\40\164\171\x70\145\x3d\x22\150\x69\x64\x64\145\x6e\42\40\156\x61\155\x65\x3d\x22\x6f\160\x74\151\157\x6e\x22\x20\x76\x61\x6c\165\145\x3d\42\163\141\x6d\154\137\x75\163\x65\x72\137\x6c\157\147\151\156\x22\x20\57\x3e\xa\x9\11\74\151\x6e\x70\x75\x74\40\x74\x79\160\x65\x3d\x22\x68\151\144\x64\x65\156\x22\x20\x6e\141\x6d\145\x3d\x22\x72\145\x64\x69\x72\x65\143\x74\137\164\x6f\42\40\166\141\x6c\x75\145\x3d\42" . $Kz . "\x22\x20\57\x3e\xa\12\x9\11\74\146\x6f\156\x74\40\163\151\x7a\145\x3d\x22\x2b\x31\42\x20\163\164\x79\154\x65\75\x22\x76\x65\162\x74\x69\x63\141\x6c\x2d\x61\154\x69\x67\156\72\x74\x6f\x70\x3b\42\76\x20\74\57\146\x6f\x6e\x74\76";
        $h7 = get_option("\x73\x61\155\x6c\137\x69\144\x65\x6e\x74\151\x74\171\137\156\x61\x6d\145");
        if (!empty($h7)) {
            goto W2;
        }
        echo "\x50\x6c\x65\141\x73\145\40\x63\157\156\146\x69\147\165\x72\x65\x20\x74\x68\145\x20\155\x69\156\151\117\x72\141\x6e\x67\x65\x20\x53\x41\x4d\114\x20\120\154\x75\147\x69\x6e\x20\x66\151\162\x73\164\56";
        goto yN;
        W2:
        $K2 = "\114\x6f\x67\x69\x6e\x20\167\x69\x74\x68\40\43\43\111\x44\x50\43\43";
        if (!get_option("\x6d\157\137\163\141\x6d\154\x5f\x63\165\163\x74\157\155\x5f\x6c\157\147\151\156\x5f\x74\145\x78\x74")) {
            goto OX;
        }
        $K2 = get_option("\155\x6f\137\x73\141\x6d\x6c\137\143\165\163\164\x6f\x6d\137\154\x6f\147\x69\x6e\137\164\x65\170\164");
        OX:
        $K2 = str_replace("\x23\43\x49\x44\x50\43\43", $h7, $K2);
        echo "\x3c\141\40\x68\162\145\146\75\42\43\x22\x20\157\x6e\x43\x6c\x69\143\x6b\75\42\x73\165\x62\155\x69\164\123\x61\155\x6c\x46\157\162\155\50\51\x22\76" . $K2 . "\x3c\57\141\x3e\x3c\57\x66\x6f\x72\155\76";
        yN:
        if ($this->mo_saml_check_empty_or_null_val(get_option("\155\157\137\x73\141\x6d\154\x5f\162\x65\144\151\162\x65\x63\x74\137\x65\162\162\x6f\162\137\143\157\144\x65"))) {
            goto mH;
        }
        echo "\x3c\x64\x69\x76\x3e\x3c\57\x64\x69\x76\76\x3c\144\x69\166\40\164\x69\164\154\x65\75\42\114\157\147\151\x6e\40\105\162\162\x6f\162\42\x3e\x3c\146\x6f\156\164\40\x63\x6f\154\157\162\75\42\162\x65\x64\42\x3e\x57\x65\x20\143\157\165\x6c\x64\40\156\157\x74\x20\163\x69\x67\156\40\171\x6f\x75\x20\151\156\x2e\40\x50\x6c\x65\x61\x73\x65\x20\143\x6f\156\164\141\x63\164\x20\x79\157\x75\x72\40\x41\x64\x6d\x69\x6e\151\163\164\x72\x61\164\x6f\162\56\74\x2f\x66\x6f\156\164\x3e\74\57\144\x69\166\x3e";
        delete_option("\x6d\157\137\x73\x61\155\x6c\x5f\162\x65\x64\x69\162\145\143\164\x5f\x65\x72\x72\x6f\162\137\x63\157\144\145");
        delete_option("\155\157\137\x73\141\x6d\154\x5f\x72\x65\x64\151\x72\x65\x63\164\x5f\145\162\162\157\x72\x5f\x72\x65\141\163\x6f\x6e");
        mH:
        echo "\74\x61\40\150\162\x65\146\x3d\x22\150\164\x74\160\72\57\57\x6d\151\x6e\x69\157\162\141\x6e\147\x65\56\x63\x6f\155\x2f\167\x6f\x72\x64\160\162\145\163\x73\55\x6c\144\x61\160\55\154\x6f\147\151\156\x22\x20\x73\164\171\x6c\145\75\42\144\x69\x73\160\x6c\141\171\72\156\x6f\x6e\145\x22\x3e\114\157\x67\151\x6e\40\164\x6f\x20\x57\157\x72\x64\120\x72\x65\x73\x73\40\165\x73\151\156\x67\x20\x4c\x44\101\120\x3c\x2f\x61\76\12\x9\x9\74\x61\x20\x68\x72\x65\146\x3d\x22\150\164\164\x70\72\x2f\x2f\x6d\x69\156\151\x6f\162\141\156\147\145\56\x63\157\x6d\57\x63\x6c\x6f\165\x64\x2d\x69\x64\145\156\x74\x69\x74\171\55\x62\162\157\x6b\x65\162\55\163\145\162\x76\151\x63\145\42\40\163\x74\x79\154\145\x3d\42\144\151\x73\160\x6c\141\171\x3a\156\x6f\156\145\42\76\103\154\157\165\144\x20\x49\x64\x65\156\164\151\x74\x79\x20\x62\162\157\153\x65\x72\40\163\x65\x72\x76\x69\x63\145\x3c\x2f\141\x3e\xa\x9\x9\74\x61\x20\150\x72\x65\146\x3d\x22\150\164\x74\160\72\57\57\155\x69\156\x69\157\x72\141\x6e\x67\145\56\x63\157\155\57\163\x74\162\x6f\x6e\x67\x5f\x61\x75\164\150\42\x20\x73\x74\x79\x6c\x65\x3d\42\x64\x69\x73\160\x6c\141\171\x3a\156\157\156\x65\73\42\x3e\x3c\x2f\x61\76\12\x9\11\x3c\141\x20\x68\x72\x65\x66\75\x22\x68\x74\164\x70\72\57\57\x6d\151\x6e\151\157\x72\x61\156\147\x65\56\x63\x6f\155\57\x73\151\156\x67\154\x65\x2d\x73\151\x67\156\55\x6f\x6e\x2d\x73\x73\157\42\x20\x73\x74\x79\154\x65\75\42\x64\x69\163\160\x6c\141\171\72\156\x6f\156\x65\73\42\x3e\x3c\57\x61\x3e\12\11\x9\74\141\40\150\162\145\146\x3d\x22\x68\164\x74\160\x3a\x2f\57\x6d\151\156\151\157\x72\141\156\x67\145\x2e\x63\x6f\x6d\x2f\x66\x72\x61\x75\x64\42\40\163\x74\171\x6c\x65\x3d\x22\x64\x69\163\160\x6c\141\171\x3a\x6e\x6f\x6e\145\73\x22\x3e\x3c\57\141\76\12\12\x9\11\x9\x3c\57\165\x6c\76\xa\11\11\x3c\57\x66\157\162\155\x3e";
        PB:
    }
    public function mo_saml_check_empty_or_null_val($g2)
    {
        if (!(!isset($g2) || empty($g2))) {
            goto cp;
        }
        return true;
        cp:
        return false;
    }
}
function mo_login_validate()
{
    if (!(isset($_REQUEST["\x6f\160\164\151\x6f\x6e"]) && $_REQUEST["\157\x70\x74\x69\157\x6e"] == "\x6d\157\163\141\x6d\x6c\x5f\x6d\145\164\141\144\141\x74\141")) {
        goto ON;
    }
    miniorange_generate_metadata();
    ON:
    if (!(isset($_REQUEST["\x6f\x70\x74\x69\x6f\x6e"]) && $_REQUEST["\x6f\x70\164\151\157\x6e"] == "\145\170\160\157\x72\164\137\x63\x6f\156\x66\151\147\x75\x72\141\164\x69\157\x6e")) {
        goto Uv;
    }
    if (!current_user_can("\155\x61\156\x61\147\x65\137\x6f\x70\164\151\x6f\156\163")) {
        goto KF;
    }
    miniorange_import_export(true);
    KF:
    die;
    Uv:
    if (!mo_saml_is_customer_license_verified()) {
        goto cO;
    }
    if (!(isset($_REQUEST["\x6f\x70\164\151\x6f\x6e"]) && $_REQUEST["\157\x70\x74\x69\157\156"] == "\x73\x61\x6d\x6c\137\165\163\x65\x72\x5f\x6c\x6f\x67\151\x6e" || isset($_REQUEST["\x6f\160\164\x69\157\156"]) && $_REQUEST["\157\x70\164\x69\x6f\x6e"] == "\x74\x65\x73\164\x69\x64\x70\143\157\156\x66\x69\147" || isset($_REQUEST["\157\160\164\151\157\156"]) && $_REQUEST["\x6f\160\164\x69\157\x6e"] == "\x67\x65\164\163\x61\155\x6c\x72\x65\x71\165\x65\x73\164" || isset($_REQUEST["\x6f\160\164\x69\157\x6e"]) && $_REQUEST["\x6f\x70\x74\151\x6f\x6e"] == "\x67\145\164\163\141\155\x6c\x72\x65\163\160\x6f\x6e\163\x65")) {
        goto GI;
    }
    if (!mo_saml_is_sp_configured()) {
        goto CM;
    }
    $co = get_option("\155\157\137\163\x61\155\154\137\x73\x70\x5f\142\141\x73\145\x5f\x75\x72\x6c");
    if (!empty($co)) {
        goto eC;
    }
    $co = home_url();
    eC:
    if ($_REQUEST["\157\x70\x74\x69\157\156"] == "\x74\x65\163\164\151\x64\x70\x63\157\156\x66\151\x67") {
        goto ce;
    }
    if ($_REQUEST["\x6f\x70\x74\x69\x6f\x6e"] == "\147\x65\164\163\x61\155\154\x72\x65\x71\x75\x65\x73\x74") {
        goto OP;
    }
    if ($_REQUEST["\157\x70\x74\x69\x6f\x6e"] == "\147\145\x74\x73\141\x6d\154\x72\145\x73\x70\157\156\x73\x65") {
        goto ZG;
    }
    if (get_option("\x6d\157\137\163\x61\x6d\154\137\162\145\154\141\171\137\163\x74\x61\164\145") && get_option("\155\157\137\x73\x61\155\154\137\x72\x65\154\141\x79\x5f\163\x74\x61\164\145") != '') {
        goto zL;
    }
    if (isset($_REQUEST["\x72\145\x64\x69\x72\x65\x63\164\x5f\164\157"])) {
        goto ag;
    }
    $lB = wp_get_referer();
    goto XY;
    ag:
    $lB = htmlspecialchars($_REQUEST["\162\x65\144\x69\x72\x65\x63\x74\x5f\x74\157"]);
    XY:
    goto TX;
    zL:
    $lB = get_option("\x6d\157\137\x73\141\x6d\x6c\x5f\162\x65\x6c\141\171\x5f\163\164\x61\164\x65");
    TX:
    goto ZE;
    ZG:
    $lB = "\144\151\163\160\x6c\x61\171\123\x41\115\114\x52\x65\x73\x70\x6f\156\163\145";
    ZE:
    goto oV;
    OP:
    $lB = "\144\151\163\x70\x6c\141\171\x53\x41\115\114\122\145\x71\x75\145\x73\x74";
    oV:
    goto s9;
    ce:
    $lB = "\164\x65\163\x74\x56\141\x6c\151\x64\x61\x74\x65";
    s9:
    if (!empty($lB)) {
        goto Xp;
    }
    $lB = $co;
    Xp:
    $ef = get_option("\x73\x61\x6d\x6c\137\x6c\x6f\147\151\156\137\x75\162\x6c");
    $jR = get_option("\163\x61\155\154\x5f\x6c\x6f\147\x69\x6e\137\x62\151\x6e\144\x69\x6e\x67\x5f\x74\x79\160\145");
    $eJ = get_option("\x6d\157\137\x73\141\x6d\154\137\146\157\x72\x63\145\137\141\165\164\150\145\156\x74\x69\x63\x61\x74\x69\x6f\156");
    $dZ = $co . "\57";
    $J4 = get_option("\x6d\157\x5f\163\x61\155\154\137\x73\160\x5f\145\x6e\x74\151\x74\171\137\x69\x64");
    if (!empty($J4)) {
        goto S5;
    }
    $J4 = $co . "\57\167\x70\x2d\x63\x6f\x6e\164\x65\156\x74\57\x70\x6c\x75\147\151\156\163\x2f\x6d\x69\156\151\157\x72\x61\x6e\x67\145\55\163\141\155\x6c\x2d\62\60\55\x73\151\x6e\x67\x6c\145\x2d\163\151\147\x6e\55\x6f\156\57";
    S5:
    $oz = get_option("\163\141\x6d\x6c\137\156\x61\155\145\x69\x64\137\x66\157\162\155\141\164");
    if (!empty($oz)) {
        goto F0;
    }
    $oz = "\61\x2e\x31\72\x6e\x61\155\x65\x69\x64\55\146\x6f\x72\155\141\164\x3a\x65\155\141\151\x6c\101\144\144\x72\x65\163\163";
    F0:
    $Qo = SAMLSPUtilities::createAuthnRequest($dZ, $J4, $ef, $eJ, $jR, $oz);
    if (!($lB == "\144\x69\163\x70\154\x61\171\x53\x41\115\x4c\122\x65\161\x75\x65\163\164")) {
        goto nz;
    }
    mo_saml_show_SAML_log(SAMLSPUtilities::createAuthnRequest($dZ, $J4, $ef, $eJ, "\x48\x54\124\120\120\x6f\x73\x74", $oz), $lB);
    nz:
    $sy = $ef;
    if (strpos($ef, "\x3f") !== false) {
        goto o5;
    }
    $sy .= "\77";
    goto jU;
    o5:
    $sy .= "\x26";
    jU:
    cldjkasjdksalc();
    $lB = parse_url($lB, PHP_URL_PATH);
    $lB = empty($lB) ? "\57" : $lB;
    if (empty($jR) || $jR == "\x48\164\164\x70\122\145\144\151\162\x65\143\164") {
        goto gE;
    }
    if (!(empty(get_option("\x73\x61\155\x6c\x5f\162\x65\x71\165\145\x73\164\137\163\x69\147\x6e\145\x64")) || get_option("\163\x61\155\154\137\x72\x65\161\x75\145\163\x74\137\163\x69\147\156\x65\144") == "\x75\x6e\x63\150\x65\143\153\x65\144")) {
        goto OF;
    }
    $VR = base64_encode($Qo);
    SAMLSPUtilities::postSAMLRequest($ef, $VR, $lB);
    die;
    OF:
    $X3 = plugin_dir_path(__FILE__) . "\162\x65\x73\157\x75\x72\143\x65\x73" . DIRECTORY_SEPARATOR . "\163\x70\x2d\x6b\145\x79\x2e\153\x65\171";
    $p2 = plugin_dir_path(__FILE__) . "\162\145\163\x6f\165\x72\143\x65\163" . DIRECTORY_SEPARATOR . "\x73\160\55\143\x65\162\x74\x69\x66\x69\143\x61\164\x65\56\143\x72\x74";
    $VR = SAMLSPUtilities::signXML($Qo, $p2, $X3, "\116\x61\155\145\111\x44\x50\157\154\151\143\x79");
    SAMLSPUtilities::postSAMLRequest($ef, $VR, $lB);
    goto z0;
    gE:
    if (!(empty(get_option("\x73\141\155\x6c\x5f\x72\145\x71\165\x65\x73\164\137\163\151\x67\x6e\145\144")) || get_option("\x73\141\x6d\x6c\137\x72\x65\x71\165\145\x73\164\137\x73\x69\x67\x6e\x65\144") == "\x75\x6e\x63\x68\x65\x63\x6b\145\144")) {
        goto ka;
    }
    $sy .= "\x53\101\115\x4c\x52\x65\161\x75\145\163\x74\75" . $Qo . "\x26\x52\145\x6c\141\x79\x53\x74\x61\x74\x65\x3d" . urlencode($lB);
    header("\x4c\157\x63\x61\164\x69\157\156\x3a\x20" . $sy);
    die;
    ka:
    $Qo = "\123\x41\115\x4c\122\x65\161\165\x65\x73\164\75" . $Qo . "\x26\x52\145\154\141\x79\123\x74\141\164\145\x3d" . urlencode($lB) . "\x26\123\x69\x67\x41\x6c\147\75" . urlencode(XMLSecurityKey::RSA_SHA256);
    $hO = array("\164\171\160\145" => "\160\162\151\166\x61\164\145");
    $ld = new XMLSecurityKey(XMLSecurityKey::RSA_SHA256, $hO);
    $x0 = plugin_dir_path(__FILE__) . "\162\x65\163\157\x75\x72\143\145\163" . DIRECTORY_SEPARATOR . "\x73\160\55\x6b\145\x79\56\153\145\x79";
    $ld->loadKey($x0, TRUE);
    $E9 = new XMLSecurityDSig();
    $fJ = $ld->signData($Qo);
    $fJ = base64_encode($fJ);
    $sy .= $Qo . "\x26\123\151\147\x6e\x61\164\x75\x72\x65\x3d" . urlencode($fJ);
    header("\114\157\x63\141\x74\x69\157\156\x3a\40" . $sy);
    die;
    z0:
    CM:
    GI:
    if (!(array_key_exists("\x53\101\115\x4c\122\145\x73\160\x6f\x6e\x73\145", $_REQUEST) && !empty($_REQUEST["\x53\101\x4d\x4c\122\x65\x73\160\x6f\x6e\x73\145"]))) {
        goto HV;
    }
    if (array_key_exists("\x52\145\154\x61\171\123\164\x61\x74\x65", $_POST) && !empty($_POST["\122\x65\x6c\x61\171\x53\x74\x61\164\145"]) && $_POST["\122\x65\154\141\x79\x53\164\141\x74\x65"] != "\57") {
        goto Pa;
    }
    $VS = '';
    goto CC;
    Pa:
    $VS = htmlspecialchars($_POST["\x52\x65\154\x61\171\123\x74\x61\164\145"]);
    CC:
    $co = get_option("\155\x6f\x5f\163\141\x6d\x6c\137\x73\160\x5f\x62\141\163\145\137\165\162\x6c");
    if (!empty($co)) {
        goto gj;
    }
    $co = home_url();
    gj:
    $j1 = htmlspecialchars($_REQUEST["\x53\x41\115\114\x52\145\x73\x70\157\156\x73\145"]);
    $j1 = base64_decode($j1);
    if (!($VS == "\x64\x69\x73\x70\154\141\171\x53\x41\x4d\114\x52\145\x73\160\x6f\156\x73\145")) {
        goto ms;
    }
    mo_saml_show_SAML_log($j1, $VS);
    ms:
    if (!(array_key_exists("\x53\101\115\x4c\122\x65\x73\160\157\156\x73\145", $_GET) && !empty($_GET["\123\101\x4d\114\x52\x65\163\x70\157\156\x73\145"]))) {
        goto AI;
    }
    $j1 = gzinflate($j1);
    AI:
    $BE = new DOMDocument();
    $BE->loadXML($j1);
    $Ka = $BE->firstChild;
    $Yf = $BE->documentElement;
    $Cu = new DOMXpath($BE);
    $Cu->registerNamespace("\x73\141\155\x6c\x70", "\165\162\x6e\x3a\x6f\141\x73\151\x73\x3a\156\141\x6d\145\163\72\164\x63\x3a\123\101\x4d\114\72\62\x2e\x30\72\x70\162\157\x74\x6f\143\x6f\x6c");
    $Cu->registerNamespace("\163\141\155\x6c", "\165\162\156\x3a\157\141\163\x69\x73\x3a\156\x61\x6d\145\163\72\164\143\72\x53\x41\115\114\72\62\x2e\60\x3a\x61\x73\x73\x65\162\164\x69\x6f\x6e");
    if ($Ka->localName == "\x4c\x6f\147\x6f\165\x74\x52\145\163\160\157\156\163\145") {
        goto DT;
    }
    $Ad = $Cu->query("\x2f\163\141\x6d\154\160\72\122\x65\x73\x70\x6f\x6e\x73\x65\x2f\163\x61\x6d\154\x70\x3a\x53\x74\141\164\x75\x73\57\163\x61\x6d\x6c\160\72\123\x74\141\164\x75\x73\x43\157\144\145", $Yf);
    $dF = $Ad->item(0)->getAttribute("\x56\x61\154\x75\145");
    $tN = $Cu->query("\x2f\x73\141\155\154\160\72\x52\145\163\x70\x6f\x6e\163\145\x2f\x73\x61\155\x6c\x70\72\123\164\141\164\x75\x73\x2f\163\141\x6d\x6c\x70\x3a\123\164\141\164\165\163\x4d\145\163\x73\141\147\145", $Yf)->item(0);
    if (empty($tN)) {
        goto ZF;
    }
    $tN = $tN->nodeValue;
    ZF:
    $Zh = explode("\72", $dF);
    $Ad = $Zh[7];
    if (array_key_exists("\x52\x65\154\x61\x79\x53\x74\141\164\145", $_POST) && !empty($_POST["\122\145\154\x61\171\x53\164\x61\x74\145"]) && $_POST["\122\145\x6c\x61\171\123\x74\x61\x74\145"] != "\57") {
        goto iu;
    }
    $VS = '';
    goto K2;
    iu:
    $VS = htmlspecialchars($_POST["\122\x65\154\141\x79\123\164\141\x74\145"]);
    K2:
    if (!($Ad != "\x53\165\x63\x63\x65\x73\x73")) {
        goto Cd;
    }
    show_status_error($Ad, $VS, $tN);
    Cd:
    $on = maybe_unserialize(get_option("\163\x61\155\x6c\x5f\170\x35\60\x39\x5f\143\145\x72\x74\151\146\x69\x63\x61\164\145"));
    $dZ = $co . "\57";
    update_option("\x4d\x4f\137\123\101\115\x4c\x5f\x52\x45\x53\x50\117\116\123\x45", base64_encode($j1));
    $j1 = new SAML2SPResponse($Ka);
    $LH = $j1->getSignatureData();
    $Dp = current($j1->getAssertions())->getSignatureData();
    if (!(empty($Dp) && empty($LH))) {
        goto mN;
    }
    if ($VS == "\164\x65\163\164\x56\141\x6c\x69\x64\141\x74\x65") {
        goto wO;
    }
    wp_die("\127\x65\x20\x63\157\x75\154\144\40\156\x6f\164\40\x73\x69\147\156\40\x79\x6f\165\40\x69\156\x2e\x20\120\154\x65\x61\x73\145\x20\143\157\156\x74\141\143\x74\40\x61\x64\x6d\x69\x6e\151\x73\x74\x72\141\x74\x6f\162", "\105\162\162\x6f\162\72\40\111\x6e\x76\x61\x6c\151\x64\x20\x53\x41\115\114\x20\x52\145\163\160\x6f\156\163\145");
    goto EK;
    wO:
    $mz = mo_options_error_constants::Error_no_certificate;
    $Or = mo_options_error_constants::Cause_no_certificate;
    echo "\74\x64\151\166\x20\x73\164\171\154\x65\75\x22\x66\157\x6e\x74\55\146\141\x6d\x69\154\171\x3a\103\x61\x6c\x69\142\x72\151\73\160\141\x64\x64\151\x6e\x67\72\60\40\63\x25\x3b\x22\x3e\12\x9\x9\x9\11\x3c\144\151\166\40\x73\x74\171\x6c\145\75\42\x63\157\x6c\x6f\x72\x3a\40\43\141\x39\64\x34\x34\62\73\142\x61\143\x6b\x67\x72\157\165\x6e\x64\55\x63\157\154\x6f\x72\x3a\40\x23\146\62\144\145\x64\145\73\x70\141\144\144\151\156\147\x3a\x20\x31\65\160\x78\73\x6d\141\x72\147\x69\156\x2d\142\157\164\164\157\x6d\x3a\x20\62\x30\x70\170\x3b\x74\145\x78\164\55\141\154\x69\147\156\72\143\x65\156\164\x65\x72\x3b\x62\x6f\x72\144\x65\x72\x3a\61\x70\170\40\x73\157\154\x69\x64\40\x23\105\x36\102\x33\x42\x32\x3b\x66\157\x6e\164\x2d\x73\x69\x7a\145\x3a\x31\x38\x70\x74\x3b\42\x3e\x20\105\x52\x52\x4f\x52\74\x2f\x64\151\x76\76\12\11\11\x9\11\x3c\x64\151\166\x20\x73\164\171\x6c\x65\x3d\x22\x63\157\154\157\x72\72\40\x23\x61\x39\64\x34\64\62\x3b\x66\x6f\156\x74\55\x73\151\x7a\145\x3a\x31\64\160\x74\x3b\x20\155\x61\x72\147\151\156\55\142\157\164\164\x6f\155\x3a\x32\60\160\x78\x3b\42\76\74\160\76\x3c\163\x74\162\x6f\x6e\x67\76\x45\162\162\157\x72\x20\x20\72" . $mz . "\40\74\x2f\163\x74\162\x6f\156\x67\x3e\74\57\x70\76\12\11\x9\11\x9\xa\11\11\x9\x9\x3c\160\76\x3c\163\x74\x72\157\156\x67\76\120\x6f\163\x73\x69\x62\x6c\145\x20\103\x61\x75\163\145\x3a\x20" . $Or . "\x3c\x2f\x73\164\x72\157\x6e\147\x3e\74\57\160\76\xa\x9\11\x9\11\xa\11\11\11\x9\74\x2f\x64\151\166\x3e\74\x2f\x64\x69\x76\76";
    mo_saml_download_logs($mz, $Or);
    die;
    EK:
    mN:
    $Uu = '';
    if (is_array($on)) {
        goto IQ;
    }
    $x1 = XMLSecurityKey::getRawThumbprint($on);
    $x1 = mo_saml_convert_to_windows_iconv($x1);
    $x1 = preg_replace("\57\x5c\163\x2b\x2f", '', $x1);
    if (empty($LH)) {
        goto VN;
    }
    $Uu = SAMLSPUtilities::processResponse($dZ, $x1, $LH, $j1, 0, $VS);
    VN:
    if (empty($Dp)) {
        goto Qv;
    }
    $Uu = SAMLSPUtilities::processResponse($dZ, $x1, $Dp, $j1, 0, $VS);
    Qv:
    goto h0;
    IQ:
    foreach ($on as $ld => $g2) {
        $x1 = XMLSecurityKey::getRawThumbprint($g2);
        $x1 = mo_saml_convert_to_windows_iconv($x1);
        $x1 = preg_replace("\57\x5c\163\x2b\x2f", '', $x1);
        if (empty($LH)) {
            goto te;
        }
        $Uu = SAMLSPUtilities::processResponse($dZ, $x1, $LH, $j1, $ld, $VS);
        te:
        if (empty($Dp)) {
            goto Mr;
        }
        $Uu = SAMLSPUtilities::processResponse($dZ, $x1, $Dp, $j1, $ld, $VS);
        Mr:
        if (!$Uu) {
            goto Rt;
        }
        goto gk;
        Rt:
        i_:
    }
    gk:
    h0:
    if ($LH) {
        goto ci;
    }
    if ($Dp) {
        goto Dh;
    }
    goto Kb;
    ci:
    $X5 = $LH["\103\145\x72\x74\x69\x66\x69\143\141\x74\145\163"][0];
    goto Kb;
    Dh:
    $X5 = $Dp["\103\x65\162\x74\x69\x66\151\x63\x61\x74\145\x73"][0];
    Kb:
    if ($Uu) {
        goto wFN;
    }
    if ($VS == "\164\x65\163\164\126\141\x6c\x69\144\x61\164\145") {
        goto br;
    }
    wp_die("\127\145\x20\143\x6f\x75\154\144\x20\x6e\x6f\x74\40\x73\151\x67\x6e\x20\171\x6f\x75\x20\x69\x6e\56\40\x50\154\x65\141\x73\145\x20\143\157\156\164\141\x63\164\40\141\144\x6d\x69\x6e\x69\x73\x74\162\141\164\x6f\x72", "\105\x72\162\x6f\162\72\x20\x49\x6e\166\141\x6c\x69\144\40\123\101\115\x4c\x20\122\145\x73\160\157\156\x73\145");
    goto sW;
    br:
    $mz = mo_options_error_constants::Error_wrong_certificate;
    $Or = mo_options_error_constants::Cause_wrong_certificate;
    $ox = "\55\55\x2d\x2d\55\102\105\107\111\116\x20\103\105\x52\x54\x49\106\x49\103\x41\124\x45\55\55\55\x2d\55\x3c\142\162\x3e" . chunk_split($X5, 64) . "\74\142\162\x3e\x2d\x2d\55\55\x2d\x45\116\x44\40\x43\x45\x52\x54\x49\x46\x49\103\101\124\105\x2d\x2d\x2d\55\55";
    echo "\74\144\151\x76\40\x73\x74\x79\x6c\x65\75\42\146\x6f\156\x74\55\x66\x61\x6d\x69\154\171\x3a\x43\141\x6c\x69\142\x72\x69\x3b\x70\141\144\144\151\156\x67\72\60\x20\x33\45\x3b\x22\76";
    echo "\74\x64\151\x76\x20\163\164\x79\154\x65\x3d\x22\x63\x6f\x6c\x6f\x72\72\40\x23\x61\x39\x34\64\64\62\73\x62\141\x63\x6b\x67\162\157\165\x6e\144\x2d\143\x6f\154\157\162\x3a\40\x23\x66\62\x64\x65\144\145\x3b\x70\x61\144\144\151\156\x67\x3a\x20\x31\x35\x70\170\x3b\x6d\141\162\147\x69\x6e\55\x62\x6f\164\x74\x6f\x6d\x3a\x20\x32\60\160\x78\73\x74\145\170\164\x2d\x61\x6c\x69\x67\x6e\72\x63\x65\x6e\x74\145\162\73\142\x6f\x72\144\145\162\x3a\x31\160\x78\x20\x73\157\x6c\151\144\x20\43\x45\x36\102\x33\102\x32\73\146\157\x6e\164\55\x73\x69\172\145\72\61\x38\x70\x74\73\x22\76\40\105\122\122\117\x52\74\x2f\144\x69\x76\76\xa\x9\x9\11\x3c\x64\x69\x76\x20\x73\164\x79\x6c\x65\x3d\42\x63\x6f\x6c\x6f\x72\x3a\x20\x23\x61\x39\x34\x34\x34\x32\73\146\x6f\x6e\x74\55\x73\151\172\x65\72\61\64\160\164\73\40\155\141\162\x67\x69\x6e\55\x62\x6f\x74\x74\x6f\155\72\62\x30\160\170\x3b\x22\x3e\x3c\x70\76\x3c\x73\x74\x72\157\156\x67\x3e\105\x72\x72\157\x72\72" . $mz . "\x20\74\x2f\x73\164\x72\157\156\x67\76\x3c\x2f\160\x3e\xa\11\x9\x9\12\11\x9\x9\74\160\76\x3c\163\x74\x72\157\x6e\x67\76\x50\157\163\x73\151\x62\154\145\40\x43\x61\165\163\145\72\x20" . $Or . "\74\57\163\x74\162\157\156\147\x3e\x3c\x2f\x70\76\12\x9\x9\x9\x3c\160\x3e\x3c\163\x74\162\157\x6e\x67\x3e\x43\145\x72\164\x69\x66\151\143\x61\x74\x65\x20\x66\x6f\x75\x6e\x64\40\x69\156\40\123\101\115\x4c\x20\122\x65\163\x70\x6f\x6e\163\145\x3a\x20\74\x2f\x73\164\x72\157\x6e\147\76\74\146\x6f\156\164\x20\x66\141\143\x65\x3d\x22\x43\x6f\x75\x72\x69\x65\162\40\116\x65\167\42\x3b\146\x6f\x6e\164\x2d\x73\151\172\x65\72\61\60\160\x74\76\x3c\x62\x72\x3e\x3c\x62\162\x3e" . $ox . "\74\x2f\160\76\74\57\x66\157\x6e\x74\76\12\x9\x9\11\74\x70\76\x3c\x73\x74\162\x6f\x6e\147\76\x53\157\x6c\165\x74\x69\157\156\x3a\x20\x3c\x2f\163\164\162\x6f\156\x67\76\x3c\x2f\x70\x3e\xa\x9\11\11\x20\x3c\157\154\x3e\12\x20\x20\x20\40\x20\40\x20\x20\x20\40\40\40\40\x20\x20\40\74\x6c\151\x3e\x43\x6f\160\x79\40\160\x61\163\164\x65\x20\164\x68\145\40\143\145\162\164\x69\x66\151\143\141\164\145\x20\x70\x72\157\166\151\x64\x65\x64\x20\x61\x62\x6f\x76\x65\40\x69\156\40\x58\65\x30\71\40\x43\145\x72\164\x69\x66\151\143\141\164\145\40\165\156\x64\x65\x72\40\123\145\162\x76\x69\x63\145\40\x50\x72\x6f\x76\151\x64\145\x72\40\x53\145\x74\165\160\x20\x74\x61\142\x2e\74\57\x6c\151\x3e\xa\40\x20\x20\40\40\40\x20\40\40\40\40\40\x20\40\40\40\x3c\x6c\x69\76\x49\146\x20\x69\163\163\165\x65\40\x70\x65\162\x73\151\163\164\163\40\x64\x69\163\141\x62\154\145\x20\x3c\x62\x3e\103\150\141\x72\141\x63\x74\145\x72\x20\145\x6e\143\157\x64\151\156\x67\x3c\57\x62\76\x20\x75\156\144\x65\x72\x20\x53\x65\162\x76\151\143\145\x20\x50\162\x6f\x76\x64\x65\x72\x20\123\x65\x74\x75\x70\x20\x74\141\x62\56\x3c\57\154\151\x3e\xa\x20\40\40\x20\x20\40\40\x20\40\x20\x20\x20\x20\74\57\x6f\x6c\x3e\40\11\11\xa\x9\x9\11\x3c\x2f\144\x69\x76\76\xa\x20\x20\x20\x20\40\40\x20\40\40\x20\40\40\40\40\40\40\x20\40\40\40\74\57\144\x69\x76\x3e";
    mo_saml_download_logs($mz, $Or);
    die;
    sW:
    wFN:
    $DR = get_option("\x73\141\x6d\154\x5f\151\163\x73\x75\x65\x72");
    $J4 = get_option("\x6d\x6f\137\163\141\155\154\x5f\x73\x70\x5f\145\x6e\x74\151\164\171\137\x69\x64");
    if (!empty($J4)) {
        goto io;
    }
    $J4 = $co . "\57\167\x70\x2d\143\157\156\164\x65\156\x74\x2f\160\154\165\147\151\156\163\57\155\151\x6e\x69\x6f\162\141\156\x67\x65\55\163\x61\x6d\154\x2d\62\60\55\163\x69\156\147\x6c\145\55\163\151\x67\156\x2d\x6f\156\57";
    io:
    SAMLSPUtilities::validateIssuerAndAudience($j1, $J4, $DR, $VS);
    $uk = current(current($j1->getAssertions())->getNameId());
    $tJ = current($j1->getAssertions())->getAttributes();
    $tJ["\116\x61\155\x65\111\x44"] = array("\x30" => $uk);
    $u4 = current($j1->getAssertions())->getSessionIndex();
    mo_saml_checkMapping($tJ, $VS, $u4);
    goto Z0;
    DT:
    wp_logout();
    header("\x4c\157\x63\141\164\151\x6f\156\x3a\40" . home_url());
    die;
    Z0:
    HV:
    if (!(array_key_exists("\123\x41\115\114\x52\145\161\165\145\163\x74", $_REQUEST) && !empty($_REQUEST["\123\101\x4d\114\122\145\161\165\145\x73\164"]))) {
        goto Yz;
    }
    $Qo = htmlspecialchars($_REQUEST["\x53\101\x4d\x4c\x52\145\x71\165\x65\x73\x74"]);
    $VS = "\x2f";
    if (!array_key_exists("\x52\145\x6c\141\x79\123\164\141\164\x65", $_REQUEST)) {
        goto lJ;
    }
    $VS = htmlspecialchars($_REQUEST["\x52\x65\154\x61\x79\x53\x74\x61\x74\145"]);
    lJ:
    $Qo = base64_decode($Qo);
    if (!(array_key_exists("\123\x41\x4d\x4c\x52\x65\161\x75\145\x73\x74", $_GET) && !empty($_GET["\x53\x41\115\114\x52\x65\161\165\x65\x73\164"]))) {
        goto mS;
    }
    $Qo = gzinflate($Qo);
    mS:
    $BE = new DOMDocument();
    $BE->loadXML($Qo);
    $G4 = $BE->firstChild;
    Yz:
    if (!(isset($_REQUEST["\x6f\x70\x74\151\x6f\156"]) and strpos($_REQUEST["\157\x70\x74\151\157\x6e"], "\162\145\141\x64\x73\141\155\x6c\154\157\147\151\156") !== false)) {
        goto bU;
    }
    require_once dirname(__FILE__) . "\57\x69\156\x63\154\x75\144\x65\x73\x2f\154\x69\x62\57\x65\156\143\162\x79\x70\x74\151\157\x6e\x2e\160\150\x70";
    if (isset($_POST["\123\124\x41\124\x55\123"]) && $_POST["\x53\x54\101\x54\x55\123"] == "\x45\122\122\x4f\x52") {
        goto Lw;
    }
    if (!(isset($_POST["\x53\x54\x41\x54\125\123"]) && $_POST["\123\x54\101\124\125\x53"] == "\123\125\103\x43\x45\123\x53")) {
        goto tA;
    }
    $Kz = '';
    if (!(isset($_REQUEST["\162\145\144\x69\x72\145\x63\164\x5f\164\x6f"]) && !empty($_REQUEST["\x72\145\144\x69\x72\145\143\164\x5f\x74\x6f"]) && $_REQUEST["\x72\145\144\151\162\145\143\164\x5f\164\157"] != "\x2f")) {
        goto bz;
    }
    $Kz = htmlspecialchars($_REQUEST["\x72\x65\x64\151\162\x65\143\164\137\x74\x6f"]);
    bz:
    delete_option("\x6d\157\137\x73\x61\155\x6c\137\x72\x65\x64\x69\x72\x65\143\x74\137\145\x72\162\x6f\x72\x5f\143\157\x64\145");
    delete_option("\155\x6f\137\x73\141\x6d\x6c\x5f\x72\x65\144\151\x72\x65\143\164\x5f\x65\162\x72\x6f\162\137\162\145\141\x73\157\x6e");
    try {
        $nb = get_option("\x73\141\155\154\x5f\x61\x6d\x5f\145\155\x61\151\x6c");
        $vl = get_option("\x73\141\x6d\154\137\141\155\137\x75\163\x65\162\x6e\x61\155\145");
        $Nm = get_option("\163\x61\x6d\x6c\x5f\141\x6d\x5f\146\151\x72\x73\x74\137\156\x61\155\145");
        $S1 = get_option("\x73\x61\x6d\154\137\x61\155\x5f\x6c\141\x73\164\137\156\141\155\x65");
        $R0 = get_option("\163\141\155\154\x5f\x61\x6d\x5f\x67\x72\x6f\x75\x70\x5f\x6e\x61\155\145");
        $Xo = get_option("\x73\141\155\154\137\141\155\x5f\x64\x65\x66\x61\x75\154\x74\x5f\x75\x73\145\162\137\162\157\x6c\x65");
        $Gj = get_option("\x73\141\x6d\154\137\x61\155\x5f\x64\157\x6e\164\x5f\x61\154\x6c\157\167\137\x75\156\154\x69\x73\x74\145\144\x5f\x75\163\x65\x72\137\162\x6f\x6c\x65");
        $j0 = get_option("\x73\x61\155\154\x5f\141\x6d\137\141\x63\143\x6f\165\x6e\x74\137\x6d\141\164\143\150\x65\x72");
        $WM = '';
        $rE = '';
        $Nm = str_replace("\x2e", "\137", $Nm);
        $Nm = str_replace("\x20", "\x5f", $Nm);
        if (!(!empty($Nm) && array_key_exists($Nm, $_POST))) {
            goto yI;
        }
        $Nm = htmlspecialchars($_POST[$Nm]);
        yI:
        $S1 = str_replace("\x2e", "\x5f", $S1);
        $S1 = str_replace("\x20", "\x5f", $S1);
        if (!(!empty($S1) && array_key_exists($S1, $_POST))) {
            goto lh;
        }
        $S1 = htmlspecialchars($_POST[$S1]);
        lh:
        $vl = str_replace("\56", "\x5f", $vl);
        $vl = str_replace("\x20", "\137", $vl);
        if (!empty($vl) && array_key_exists($vl, $_POST)) {
            goto OI;
        }
        $rE = htmlspecialchars($_POST["\116\141\x6d\x65\x49\x44"]);
        goto Lt;
        OI:
        $rE = htmlspecialchars($_POST[$vl]);
        Lt:
        $WM = str_replace("\x2e", "\137", $nb);
        $WM = str_replace("\40", "\x5f", $nb);
        if (!empty($nb) && array_key_exists($nb, $_POST)) {
            goto LV;
        }
        $WM = htmlspecialchars($_POST["\116\141\x6d\x65\111\x44"]);
        goto q8;
        LV:
        $WM = htmlspecialchars($_POST[$nb]);
        q8:
        $R0 = str_replace("\x2e", "\x5f", $R0);
        $R0 = str_replace("\40", "\x5f", $R0);
        if (!(!empty($R0) && array_key_exists($R0, $_POST))) {
            goto EJ;
        }
        $R0 = htmlspecialchars($_POST[$R0]);
        EJ:
        if (!empty($j0)) {
            goto ZI;
        }
        $j0 = "\x65\155\x61\x69\x6c";
        ZI:
        $ld = get_option("\x6d\x6f\x5f\x73\141\155\x6c\137\x63\165\163\164\x6f\155\x65\x72\137\164\157\x6b\x65\x6e");
        if (!(isset($ld) || trim($ld) != '')) {
            goto zl;
        }
        $uJ = AESEncryption::decrypt_data($WM, $ld);
        $WM = $uJ;
        zl:
        if (!(!empty($Nm) && !empty($ld))) {
            goto j9;
        }
        $xM = AESEncryption::decrypt_data($Nm, $ld);
        $Nm = $xM;
        j9:
        if (!(!empty($S1) && !empty($ld))) {
            goto VK;
        }
        $kf = AESEncryption::decrypt_data($S1, $ld);
        $S1 = $kf;
        VK:
        if (!(!empty($rE) && !empty($ld))) {
            goto SA;
        }
        $cl = AESEncryption::decrypt_data($rE, $ld);
        $rE = $cl;
        SA:
        if (!(!empty($R0) && !empty($ld))) {
            goto w0;
        }
        $PO = AESEncryption::decrypt_data($R0, $ld);
        $R0 = $PO;
        w0:
    } catch (Exception $A4) {
        echo sprintf("\101\x6e\x20\145\162\x72\x6f\162\40\x6f\143\143\x75\162\x72\x65\144\40\167\x68\x69\154\145\x20\x70\162\157\x63\145\x73\163\151\156\147\40\164\150\x65\x20\123\x41\115\114\x20\x52\145\x73\160\x6f\x6e\163\145\56");
        die;
    }
    $oj = array($R0);
    mo_saml_login_user($WM, $Nm, $S1, $rE, $oj, $Gj, $Xo, $Kz, $j0);
    tA:
    goto pq;
    Lw:
    update_option("\155\157\137\x73\x61\155\x6c\137\162\145\144\151\162\145\x63\164\x5f\145\162\162\x6f\162\137\143\157\x64\145", htmlspecialchars($_POST["\x45\122\x52\117\122\x5f\122\x45\101\x53\117\x4e"]));
    update_option("\155\x6f\137\x73\x61\155\154\x5f\x72\x65\x64\151\162\145\x63\x74\137\x65\x72\162\x6f\162\137\162\x65\x61\x73\157\156", htmlspecialchars($_POST["\x45\x52\122\x4f\x52\x5f\115\105\x53\123\x41\x47\105"]));
    pq:
    bU:
    cO:
}
function cldjkasjdksalc()
{
    $R4 = plugin_dir_path(__FILE__);
    $OI = wp_upload_dir();
    $Fw = home_url();
    $Fw = trim($Fw, "\57");
    if (preg_match("\43\136\x68\164\x74\x70\x28\163\x29\x3f\x3a\57\57\43", $Fw)) {
        goto eB;
    }
    $Fw = "\x68\164\164\x70\72\x2f\57" . $Fw;
    eB:
    $jh = parse_url($Fw);
    $Js = preg_replace("\x2f\x5e\x77\167\167\x5c\56\x2f", '', $jh["\150\157\163\164"]);
    $D9 = $Js . "\x2d" . $OI["\142\x61\x73\x65\x64\151\x72"];
    $yu = hash_hmac("\x73\150\x61\x32\65\x36", $D9, "\64\104\110\146\152\x67\146\152\x61\x73\156\x64\x66\x73\x61\152\x66\110\x47\x4a");
    if (is_writable($R4 . "\x6c\151\x63\145\156\x73\x65")) {
        goto QO;
    }
    $FO = base64_decode("\142\107\116\153\x61\x6d\x74\x68\143\62\160\153\141\x33\116\x68\131\x32\x77\75");
    $su = get_option($FO);
    if (empty($su)) {
        goto vT;
    }
    $cx = str_rot13($su);
    vT:
    goto E6;
    QO:
    $su = file_get_contents($R4 . "\154\x69\143\x65\x6e\163\145");
    if (!$su) {
        goto Um;
    }
    $cx = base64_encode($su);
    Um:
    E6:
    if (!empty($su)) {
        goto ch;
    }
    $VZ = base64_decode("\x54\x47\154\152\132\127\65\172\132\123\102\107\x61\x57\x78\x6c\111\x47\x31\x70\x63\63\x4e\160\x62\155\143\x67\x5a\156\112\x76\142\123\x42\x30\141\107\125\147\143\107\x78\61\x5a\x32\x6c\165\x4c\x67\75\75");
    wp_die($VZ);
    ch:
    if (strpos($cx, $yu) !== false) {
        goto KK;
    }
    $ko = new Customersaml();
    $ld = get_option("\155\x6f\137\x73\x61\155\x6c\137\x63\x75\163\x74\x6f\155\145\x72\137\x74\x6f\x6b\x65\x6e");
    $V5 = AESEncryption::decrypt_data(get_option("\x73\x6d\x6c\137\x6c\153"), $ld);
    $Gs = $ko->mo_saml_vl($V5, false);
    if ($Gs) {
        goto PJ;
    }
    return;
    PJ:
    $Gs = json_decode($Gs, true);
    if (strcasecmp($Gs["\163\x74\x61\164\165\x73"], "\x53\x55\103\x43\105\x53\123") == 0) {
        goto xF;
    }
    $Pv = base64_decode("\x53\127\65\62\x59\x57\x78\x70\132\103\x42\x4d\141\x57\116\x6c\142\x6e\116\x6c\111\105\132\x76\144\127\x35\153\114\x69\x42\121\142\x47\x56\x68\143\62\125\147\131\x32\x39\x75\144\x47\106\152\144\x43\102\x35\142\x33\x56\x79\x49\x47\106\153\x62\127\x6c\165\141\130\x4e\x30\x63\155\x46\x30\x62\x33\x49\147\x64\x47\x38\x67\x64\x58\116\154\x49\x48\122\157\x5a\123\x42\152\142\x33\x4a\171\x5a\x57\x4e\60\111\107\170\x70\131\62\126\x75\143\x32\x55\x75\111\105\132\x76\143\x69\102\164\x62\x33\x4a\x6c\111\x47\122\x6c\144\107\106\x70\x62\110\x4d\x73\111\110\102\x79\142\63\x5a\160\132\x47\x55\x67\x64\x47\x68\154\111\x46\x4a\154\x5a\155\x56\x79\x5a\127\65\x6a\132\123\102\x4a\x52\104\x6f\x67\x54\125\70\x79\x4e\104\111\x34\115\x54\101\171\115\x54\143\x77\116\x53\102\60\x62\x79\x42\65\x62\63\x56\x79\x49\107\x46\x6b\x62\x57\x6c\x75\141\x58\116\x30\143\155\106\60\142\x33\x49\147\144\x47\70\x67\131\x32\x68\x6c\131\62\x73\147\x61\130\121\147\144\127\65\x6b\132\130\111\147\123\x47\126\163\x63\x43\101\x6d\x49\x45\132\102\x55\123\102\60\131\127\x49\147\141\127\x34\x67\144\x47\150\x6c\111\x48\102\x73\x64\127\144\x70\142\151\x34\x3d");
    $Pv = str_replace("\110\x65\x6c\160\40\46\40\106\101\121\40\164\x61\x62\40\x69\156", "\106\x41\121\x73\40\163\145\143\164\x69\157\x6e\40\x6f\146", $Pv);
    $MF = base64_decode("\122\130\x4a\171\142\x33\111\66\x49\105\154\x75\x64\x6d\x46\x73\141\127\x51\x67\124\107\x6c\152\x5a\x57\x35\172\132\121\x3d\x3d");
    wp_die($Pv, $MF);
    goto nl;
    xF:
    $R4 = plugin_dir_path(__FILE__);
    $Fw = home_url();
    $Fw = trim($Fw, "\57");
    if (preg_match("\x23\136\150\x74\164\160\x28\x73\x29\x3f\72\x2f\x2f\43", $Fw)) {
        goto bQ;
    }
    $Fw = "\x68\x74\x74\x70\72\57\57" . $Fw;
    bQ:
    $jh = parse_url($Fw);
    $Js = preg_replace("\x2f\136\167\x77\x77\134\x2e\x2f", '', $jh["\150\x6f\163\164"]);
    $OI = wp_upload_dir();
    $D9 = $Js . "\55" . $OI["\142\141\x73\145\x64\x69\x72"];
    $yu = hash_hmac("\163\150\141\x32\65\x36", $D9, "\x34\104\110\x66\152\147\x66\x6a\141\163\x6e\x64\x66\163\141\152\x66\110\107\x4a");
    $aT = djkasjdksa();
    $Sl = round(strlen($aT) / rand(2, 20));
    $aT = substr_replace($aT, $yu, $Sl, 0);
    $EK = base64_decode($aT);
    if (is_writable($R4 . "\x6c\151\x63\x65\x6e\x73\145")) {
        goto yK;
    }
    $aT = str_rot13($aT);
    $FO = base64_decode("\142\107\x4e\153\141\155\164\x68\x63\x32\x70\x6b\x61\63\x4e\x68\x59\x32\x77\75");
    update_option($FO, $aT);
    goto Cw;
    yK:
    file_put_contents($R4 . "\x6c\151\x63\x65\156\x73\145", $EK);
    Cw:
    return true;
    nl:
    goto uE;
    KK:
    return true;
    uE:
}
function djkasjdksa()
{
    $tn = "\x21\x7e\x40\43\44\45\x5e\46\x2a\x28\x29\137\53\x7c\173\175\74\76\77\60\61\62\63\x34\65\x36\67\x38\71\x61\x62\143\144\145\x66\147\150\x69\x6a\x6b\x6c\155\x6e\157\x70\x71\162\163\164\165\166\167\170\171\x7a\101\102\103\x44\x45\x46\107\x48\x49\x4a\x4b\114\x4d\116\x4f\x50\x51\122\123\x54\x55\126\127\130\131\x5a";
    $m9 = strlen($tn);
    $m3 = '';
    $oM = 0;
    RV:
    if (!($oM < 10000)) {
        goto FZ;
    }
    $m3 .= $tn[rand(0, $m9 - 1)];
    Uz:
    $oM++;
    goto RV;
    FZ:
    return $m3;
}
function mo_saml_show_SAML_log($G4, $fH)
{
    header("\103\157\x6e\x74\145\x6e\x74\x2d\x54\171\x70\145\72\x20\164\x65\170\x74\57\x68\164\155\x6c");
    $Yf = new DOMDocument();
    $Yf->preserveWhiteSpace = false;
    $Yf->formatOutput = true;
    $Yf->loadXML($G4);
    if ($fH == "\x64\x69\163\160\x6c\141\x79\123\x41\x4d\x4c\122\145\161\165\145\163\164") {
        goto jg;
    }
    $lm = "\123\x41\x4d\114\x20\122\x65\x73\160\x6f\x6e\x73\145";
    goto Mu;
    jg:
    $lm = "\123\x41\x4d\x4c\40\122\145\x71\x75\145\163\164";
    Mu:
    $tA = $Yf->saveXML();
    $SI = htmlentities($tA);
    $SI = rtrim($SI);
    $pX = simplexml_load_string($tA);
    $uu = json_encode($pX);
    $Lc = json_decode($uu);
    $px = plugins_url("\151\156\143\x6c\x75\x64\145\163\57\x63\x73\x73\57\163\x74\171\154\145\137\x73\145\164\164\151\156\147\163\56\143\x73\x73\x3f\166\145\x72\x3d\64\56\x38\x2e\64\60", __FILE__);
    echo "\x3c\x6c\x69\x6e\x6b\x20\x72\145\x6c\x3d\x27\x73\164\x79\x6c\145\163\x68\145\x65\164\x27\x20\x69\144\x3d\x27\155\x6f\x5f\163\141\155\x6c\x5f\141\x64\x6d\151\156\x5f\163\x65\164\164\151\x6e\x67\x73\137\163\x74\171\154\x65\55\143\x73\x73\x27\x20\40\150\162\145\146\75\x27" . $px . "\x27\40\164\171\x70\145\x3d\x27\164\145\x78\164\57\143\x73\x73\x27\40\155\145\x64\151\x61\x3d\x27\141\154\x6c\47\40\x2f\76\xa\40\40\40\40\40\40\x20\x20\x20\x20\40\40\xa\x9\x9\x9\x3c\x64\x69\166\40\143\154\x61\x73\x73\x3d\42\x6d\x6f\x2d\144\x69\x73\x70\x6c\x61\171\55\154\157\147\163\x22\x20\x3e\74\160\x20\164\x79\x70\145\75\x22\x74\145\x78\164\42\x20\x20\40\x69\x64\x3d\42\x53\x41\115\x4c\137\x74\x79\x70\145\x22\76" . $lm . "\74\x2f\x70\x3e\74\57\x64\151\x76\x3e\xa\11\11\x9\x9\xa\11\x9\11\x3c\x64\x69\x76\x20\x74\x79\x70\145\75\42\x74\x65\170\x74\42\40\x69\x64\75\x22\123\x41\115\114\x5f\144\151\163\x70\x6c\x61\x79\x22\x20\x63\x6c\141\163\x73\x3d\x22\x6d\157\x2d\144\x69\163\160\x6c\x61\171\x2d\x62\x6c\x6f\143\x6b\42\x3e\x3c\160\162\x65\x20\143\154\x61\x73\x73\x3d\47\142\162\165\163\150\x3a\40\170\155\x6c\73\47\76" . $SI . "\74\x2f\160\x72\145\x3e\74\57\144\x69\x76\76\xa\11\11\11\74\x62\x72\x3e\xa\x9\11\x9\x3c\x64\151\166\11\40\163\x74\171\x6c\x65\75\42\155\141\162\x67\x69\x6e\72\x33\45\73\x64\151\x73\x70\x6c\x61\x79\x3a\x62\154\x6f\143\153\73\164\x65\170\x74\x2d\x61\154\151\147\x6e\x3a\143\145\156\x74\x65\x72\x3b\42\76\xa\x20\x20\x20\x20\40\40\x20\40\40\x20\40\x20\12\11\x9\x9\x3c\x64\x69\x76\40\163\x74\x79\154\145\75\42\x6d\141\x72\x67\151\156\72\x33\x25\73\144\x69\163\x70\x6c\x61\171\72\x62\154\x6f\x63\x6b\x3b\164\x65\x78\164\x2d\141\x6c\x69\147\x6e\72\x63\x65\156\x74\x65\x72\x3b\x22\40\76\12\x9\xa\x20\40\40\x20\x20\x20\40\x20\40\x20\x20\40\74\x2f\144\x69\x76\x3e\12\11\11\x9\x3c\x62\165\x74\x74\157\156\40\x69\144\75\x22\x63\x6f\160\171\42\40\157\x6e\143\154\151\143\153\x3d\42\x63\157\x70\x79\104\x69\x76\x54\x6f\x43\154\151\x70\x62\x6f\x61\162\144\50\51\42\x20\40\x73\x74\x79\x6c\145\x3d\x22\x70\x61\x64\144\151\x6e\x67\x3a\61\45\x3b\167\151\x64\164\x68\72\x31\60\x30\160\x78\x3b\142\141\143\153\x67\x72\157\165\x6e\144\x3a\40\43\x30\x30\x39\x31\x43\104\40\156\x6f\156\145\40\x72\145\x70\x65\x61\x74\40\x73\143\x72\157\x6c\x6c\40\x30\x25\40\60\x25\x3b\143\165\162\x73\157\162\x3a\x20\160\157\151\x6e\164\145\x72\x3b\x66\157\x6e\x74\55\x73\151\172\x65\72\61\x35\160\x78\x3b\142\157\x72\x64\145\162\55\167\151\144\164\150\x3a\40\x31\160\x78\73\x62\157\162\x64\145\162\55\x73\x74\171\x6c\145\x3a\40\x73\157\154\x69\144\x3b\x62\x6f\162\x64\x65\x72\x2d\x72\x61\x64\x69\165\x73\x3a\40\x33\x70\170\73\167\150\151\164\x65\x2d\163\160\141\143\145\x3a\40\x6e\x6f\167\x72\141\160\x3b\142\x6f\x78\55\x73\x69\x7a\x69\x6e\147\72\40\x62\157\162\144\x65\x72\55\142\x6f\x78\x3b\x62\x6f\162\x64\145\x72\x2d\143\157\x6c\157\x72\x3a\40\43\x30\60\67\x33\101\101\x3b\142\x6f\170\55\163\150\x61\144\157\167\x3a\40\60\160\x78\x20\61\x70\170\40\x30\160\170\x20\162\147\142\x61\x28\61\x32\60\x2c\40\x32\x30\x30\54\40\x32\x33\60\54\x20\60\x2e\x36\51\x20\151\156\163\145\164\73\143\157\x6c\x6f\x72\x3a\40\43\106\106\x46\x3b\x22\40\x3e\103\x6f\x70\171\74\57\x62\165\x74\164\x6f\156\76\xa\x9\x9\11\46\x6e\142\x73\160\x3b\12\40\40\x20\40\x20\40\x20\40\40\x20\x20\x20\x20\x20\40\x3c\151\x6e\160\x75\x74\x20\x69\x64\x3d\42\144\167\156\55\x62\x74\x6e\x22\40\x73\164\171\x6c\x65\x3d\42\x70\141\x64\x64\151\x6e\147\x3a\x31\x25\x3b\x77\151\x64\x74\x68\x3a\x31\x30\x30\x70\170\73\x62\141\x63\153\x67\x72\x6f\165\156\x64\x3a\x20\43\60\x30\x39\61\x43\104\x20\156\157\x6e\x65\40\x72\x65\x70\x65\x61\x74\x20\163\143\x72\x6f\x6c\x6c\40\60\45\x20\x30\45\73\143\x75\x72\x73\157\162\72\40\x70\157\x69\x6e\164\x65\162\x3b\146\x6f\x6e\x74\x2d\163\x69\172\145\x3a\61\x35\160\170\73\142\x6f\x72\x64\145\x72\55\167\151\144\164\150\72\x20\x31\x70\170\x3b\142\157\162\144\x65\162\x2d\163\x74\171\x6c\x65\72\40\163\x6f\x6c\151\144\x3b\142\x6f\x72\144\x65\162\x2d\162\141\144\151\165\x73\72\40\63\160\x78\x3b\x77\150\151\x74\145\x2d\163\160\x61\143\145\72\x20\156\157\x77\162\x61\160\x3b\142\x6f\x78\55\x73\x69\172\151\156\x67\x3a\40\x62\157\x72\x64\x65\x72\55\142\x6f\170\73\x62\157\162\x64\x65\162\55\143\x6f\154\x6f\162\x3a\x20\43\x30\60\x37\63\101\x41\x3b\142\x6f\170\x2d\163\x68\x61\x64\157\167\72\40\60\x70\170\40\x31\x70\170\40\60\x70\170\x20\x72\x67\x62\141\x28\x31\62\60\54\x20\62\60\x30\54\40\x32\x33\x30\x2c\x20\x30\56\x36\x29\40\151\x6e\x73\145\x74\73\x63\157\x6c\157\162\x3a\x20\43\x46\x46\x46\x3b\x22\x74\171\160\145\75\x22\x62\x75\x74\164\157\x6e\42\40\x76\141\x6c\165\145\x3d\x22\104\157\167\x6e\x6c\x6f\141\x64\x22\x20\xa\x20\x20\x20\x20\40\40\x20\x20\40\x20\x20\x20\40\x20\x20\x22\x3e\12\x9\x9\11\74\x2f\x64\151\166\76\xa\x9\11\11\74\x2f\144\151\166\76\xa\x9\11\x9\12\11\11\12\11\11\11";
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
function mo_saml_checkMapping($tJ, $VS, $u4)
{
    try {
        $nb = get_option("\163\x61\x6d\154\137\141\155\137\145\x6d\x61\x69\154");
        $vl = get_option("\163\x61\155\x6c\x5f\x61\155\137\165\163\x65\x72\156\x61\155\x65");
        $Nm = get_option("\x73\141\x6d\154\x5f\141\155\137\x66\151\162\x73\x74\x5f\x6e\141\155\145");
        $S1 = get_option("\x73\141\x6d\x6c\137\141\x6d\x5f\x6c\141\x73\164\137\156\141\155\x65");
        $R0 = get_option("\163\x61\155\154\x5f\141\155\x5f\x67\162\157\x75\160\137\156\x61\x6d\x65");
        $Xo = get_option("\163\x61\x6d\154\x5f\x61\155\x5f\x64\145\146\141\x75\x6c\164\137\x75\163\145\162\137\162\x6f\154\x65");
        $Gj = get_option("\163\x61\x6d\154\x5f\x61\155\137\x64\x6f\156\x74\137\141\x6c\x6c\157\x77\x5f\165\156\154\151\163\x74\x65\x64\x5f\x75\x73\145\162\137\x72\157\154\145");
        $j0 = get_option("\x73\141\155\x6c\x5f\141\155\x5f\141\143\x63\157\165\x6e\x74\137\x6d\141\164\143\150\x65\x72");
        $WM = '';
        $rE = '';
        if (empty($tJ)) {
            goto Bn;
        }
        if (!empty($Nm) && array_key_exists($Nm, $tJ)) {
            goto C_;
        }
        $Nm = '';
        goto GX;
        C_:
        $Nm = $tJ[$Nm][0];
        GX:
        if (!empty($S1) && array_key_exists($S1, $tJ)) {
            goto Un;
        }
        $S1 = '';
        goto rJ;
        Un:
        $S1 = $tJ[$S1][0];
        rJ:
        if (!empty($vl) && array_key_exists($vl, $tJ)) {
            goto U0;
        }
        $rE = $tJ["\116\141\155\145\x49\104"][0];
        goto yu;
        U0:
        $rE = $tJ[$vl][0];
        yu:
        if (!empty($nb) && array_key_exists($nb, $tJ)) {
            goto ZP;
        }
        $WM = $tJ["\116\x61\155\145\111\104"][0];
        goto aI;
        ZP:
        $WM = $tJ[$nb][0];
        aI:
        if (!empty($R0) && array_key_exists($R0, $tJ)) {
            goto sa;
        }
        $R0 = array();
        goto qE;
        sa:
        $R0 = $tJ[$R0];
        qE:
        if (!empty($j0)) {
            goto vp;
        }
        $j0 = "\x65\155\x61\x69\x6c";
        vp:
        Bn:
        if ($VS == "\x74\x65\x73\164\x56\141\x6c\151\x64\x61\x74\145") {
            goto Be;
        }
        mo_saml_login_user($WM, $Nm, $S1, $rE, $R0, $Gj, $Xo, $VS, $j0, $u4, $tJ["\x4e\x61\x6d\x65\111\x44"][0], $tJ);
        goto cu;
        Be:
        update_option("\x4d\117\137\x53\x41\115\x4c\137\124\x45\123\124", "\124\145\163\164\x20\163\165\143\x63\x65\x73\x73\146\x75\x6c");
        update_option("\x4d\x4f\137\x53\x41\115\x4c\x5f\124\105\123\124\137\x53\124\x41\x54\125\123", 1);
        mo_saml_show_test_result($Nm, $S1, $WM, $R0, $tJ);
        cu:
    } catch (Exception $A4) {
        echo sprintf("\101\x6e\40\x65\x72\162\x6f\x72\x20\x6f\x63\143\165\162\x72\x65\144\40\167\150\x69\154\x65\x20\x70\x72\x6f\x63\145\x73\163\151\156\x67\40\164\x68\145\40\x53\101\x4d\114\40\122\x65\x73\160\x6f\156\x73\145\x2e");
        die;
    }
}
function mo_saml_show_test_result($Nm, $S1, $WM, $R0, $tJ)
{
    echo "\74\144\151\x76\x20\163\x74\171\x6c\145\75\x22\146\157\x6e\x74\55\x66\x61\155\151\x6c\x79\72\103\x61\154\x69\x62\162\151\x3b\x70\141\x64\x64\x69\156\x67\72\x30\40\x33\x25\x3b\42\x3e";
    if (!empty($WM)) {
        goto h2;
    }
    echo "\74\144\x69\x76\x20\163\x74\x79\154\x65\x3d\42\x63\157\x6c\x6f\x72\72\x20\43\x61\x39\x34\x34\x34\x32\x3b\142\x61\143\153\147\162\157\165\156\144\55\x63\x6f\154\157\162\72\x20\x23\x66\62\144\145\144\145\x3b\160\x61\x64\x64\151\156\x67\x3a\40\61\65\160\x78\73\155\141\x72\147\x69\156\55\x62\x6f\x74\164\157\155\x3a\x20\62\60\160\170\73\164\x65\x78\164\x2d\x61\154\151\x67\156\x3a\143\x65\156\x74\x65\162\x3b\x62\157\x72\x64\145\162\72\x31\x70\x78\40\163\157\x6c\x69\144\x20\x23\x45\x36\102\63\x42\x32\73\146\157\x6e\x74\55\163\151\172\x65\72\x31\70\x70\x74\73\x22\76\x54\x45\x53\124\40\106\101\111\114\x45\x44\74\57\144\151\166\76\xa\11\11\x9\x9\x3c\144\x69\166\40\x73\164\171\154\x65\75\x22\143\157\x6c\157\x72\72\40\x23\x61\x39\64\x34\x34\x32\x3b\x66\x6f\x6e\164\55\163\151\x7a\x65\72\x31\x34\x70\x74\73\40\155\x61\162\x67\151\x6e\x2d\x62\157\x74\x74\x6f\x6d\x3a\62\60\x70\x78\73\x22\76\x57\x41\122\x4e\111\116\107\x3a\40\x53\x6f\x6d\145\40\101\x74\x74\162\151\142\165\x74\x65\163\40\104\x69\144\x20\x4e\157\x74\40\x4d\x61\164\143\150\56\74\x2f\144\x69\166\76\12\x9\11\11\x9\x3c\x64\x69\166\40\x73\x74\171\154\145\75\x22\x64\151\x73\x70\154\141\171\x3a\x62\x6c\x6f\x63\x6b\x3b\164\145\170\164\55\x61\x6c\x69\x67\156\72\x63\x65\x6e\164\145\162\73\x6d\141\x72\x67\x69\x6e\x2d\142\x6f\164\164\x6f\x6d\x3a\x34\x25\73\x22\x3e\x3c\151\155\x67\x20\x73\164\171\x6c\x65\x3d\42\167\x69\x64\x74\x68\x3a\61\65\x25\73\42\x73\x72\x63\x3d\42" . plugin_dir_url(__FILE__) . "\151\x6d\141\147\x65\163\57\x77\x72\x6f\156\x67\x2e\160\x6e\x67\x22\76\x3c\x2f\144\x69\x76\x3e";
    goto Qf;
    h2:
    update_option("\155\x6f\x5f\163\141\155\154\137\164\145\163\x74\137\x63\x6f\156\146\151\147\x5f\141\164\x74\162\x73", $tJ);
    echo "\74\144\151\x76\x20\163\x74\171\x6c\145\75\42\x63\157\x6c\x6f\162\72\x20\43\x33\143\67\66\63\x64\x3b\12\x9\11\11\11\142\x61\x63\x6b\147\x72\157\x75\156\144\55\x63\x6f\154\x6f\x72\x3a\40\x23\x64\146\x66\60\144\70\x3b\x20\160\141\144\144\151\156\x67\72\x32\45\x3b\x6d\141\x72\147\x69\x6e\x2d\x62\x6f\164\164\157\155\x3a\x32\x30\x70\x78\x3b\164\145\170\x74\55\x61\154\x69\x67\156\x3a\x63\x65\156\x74\x65\x72\x3b\40\142\x6f\x72\x64\x65\162\x3a\x31\x70\x78\x20\163\157\154\151\144\40\43\x41\105\x44\102\x39\x41\73\40\x66\157\156\x74\55\x73\x69\x7a\145\72\61\x38\x70\x74\73\x22\76\x54\105\x53\124\40\123\125\103\x43\x45\x53\123\106\x55\x4c\x3c\57\x64\151\x76\76\12\x9\x9\x9\x9\x3c\x64\x69\x76\40\x73\x74\x79\154\x65\75\x22\x64\x69\x73\x70\154\141\x79\72\x62\x6c\157\143\x6b\x3b\164\145\170\164\x2d\x61\x6c\151\x67\156\x3a\143\145\156\164\145\x72\x3b\x6d\141\x72\x67\x69\x6e\x2d\x62\x6f\x74\164\157\x6d\x3a\64\x25\73\x22\76\x3c\151\x6d\x67\40\x73\x74\171\154\145\75\x22\x77\151\144\x74\x68\72\61\x35\x25\73\x22\163\x72\143\x3d\x22" . plugin_dir_url(__FILE__) . "\151\155\x61\147\x65\x73\57\x67\162\x65\x65\x6e\137\x63\x68\145\143\153\x2e\x70\156\x67\x22\76\74\57\144\x69\x76\76";
    Qf:
    $cE = get_option("\163\x61\x6d\154\137\x61\x6d\137\141\x63\x63\157\x75\156\164\x5f\155\141\x74\x63\150\145\x72") ? get_option("\163\141\155\x6c\x5f\141\x6d\137\x61\143\x63\157\165\156\164\x5f\x6d\141\x74\143\150\145\162") : "\145\x6d\141\151\x6c";
    if (!($cE == "\x65\x6d\141\151\x6c" && !filter_var($WM, FILTER_VALIDATE_EMAIL))) {
        goto vW;
    }
    echo "\x3c\x70\76\74\146\157\156\164\40\143\157\154\x6f\162\x3d\42\x23\x46\106\60\x30\60\x30\42\40\163\x74\x79\x6c\x65\75\42\x66\x6f\156\x74\x2d\163\151\172\145\x3a\x31\64\x70\164\x22\76\x28\127\x61\x72\156\151\156\147\x3a\x20\124\x68\x65\x20\x41\x74\x74\162\x69\x62\x75\x74\145\x20\42";
    echo get_option("\163\x61\x6d\154\137\141\x6d\x5f\145\155\x61\x69\154") ? get_option("\x73\141\155\154\x5f\x61\155\x5f\145\x6d\141\x69\x6c") : "\116\141\x6d\145\x49\104";
    echo "\42\40\144\x6f\x65\163\40\x6e\157\x74\x20\x63\157\x6e\164\x61\151\x6e\40\166\x61\x6c\151\x64\40\105\155\x61\151\154\x20\111\104\x29\x3c\57\x66\x6f\156\x74\x3e\74\57\160\76";
    vW:
    echo "\74\x73\160\141\x6e\x20\163\x74\x79\154\x65\75\x22\146\x6f\156\164\x2d\x73\151\x7a\145\72\61\x34\160\164\x3b\x22\76\x3c\142\x3e\x48\145\154\154\x6f\x3c\57\x62\76\x2c\x20" . $WM . "\74\57\163\x70\x61\156\x3e\x3c\x62\x72\57\76\74\x70\x20\x73\x74\171\154\145\75\42\146\x6f\x6e\164\x2d\x77\x65\x69\x67\x68\164\72\x62\157\154\144\x3b\x66\157\x6e\x74\x2d\163\151\x7a\x65\x3a\61\64\x70\164\x3b\155\x61\x72\147\x69\156\x2d\x6c\x65\146\164\72\x31\45\x3b\42\x3e\x41\124\124\x52\111\x42\x55\x54\x45\123\40\x52\x45\103\x45\111\126\105\x44\72\74\x2f\x70\x3e\12\x9\x9\x9\11\74\164\141\x62\154\145\40\163\164\171\x6c\x65\75\42\142\157\x72\144\145\162\x2d\x63\x6f\x6c\x6c\141\x70\163\x65\x3a\x63\x6f\x6c\154\x61\x70\163\x65\x3b\142\x6f\162\x64\145\x72\x2d\163\160\141\x63\x69\156\147\x3a\60\x3b\x20\144\151\x73\160\154\141\171\72\164\x61\x62\x6c\145\73\x77\151\x64\x74\150\x3a\x31\60\x30\x25\x3b\x20\x66\x6f\x6e\164\x2d\x73\x69\x7a\145\72\x31\64\x70\164\x3b\x62\141\143\x6b\x67\x72\157\x75\x6e\144\x2d\143\x6f\x6c\157\x72\x3a\43\105\x44\105\x44\105\104\73\42\x3e\xa\11\x9\x9\11\74\x74\x72\40\x73\x74\x79\154\x65\75\42\x74\145\170\164\55\141\154\x69\147\x6e\72\143\145\x6e\164\145\162\x3b\x22\76\x3c\x74\x64\x20\163\164\x79\154\145\x3d\42\x66\x6f\x6e\x74\55\167\145\x69\x67\x68\x74\72\142\157\154\x64\x3b\x62\x6f\162\144\x65\x72\x3a\x32\160\170\x20\x73\x6f\x6c\x69\144\40\x23\x39\64\x39\x30\71\60\73\160\141\x64\x64\151\x6e\x67\x3a\62\x25\x3b\42\x3e\101\x54\x54\x52\x49\102\x55\x54\x45\40\x4e\x41\x4d\x45\74\x2f\x74\144\x3e\x3c\x74\144\x20\163\164\171\x6c\145\75\x22\x66\x6f\156\164\55\167\145\x69\147\150\x74\x3a\142\157\154\x64\73\x70\141\x64\144\151\x6e\x67\x3a\62\45\73\x62\157\x72\144\x65\162\72\62\x70\x78\40\163\x6f\x6c\x69\x64\x20\43\71\64\x39\x30\71\60\73\x20\167\x6f\162\144\x2d\x77\162\141\x70\x3a\142\x72\x65\141\153\55\167\x6f\162\144\73\x22\x3e\x41\124\x54\122\x49\x42\x55\x54\105\40\126\101\x4c\x55\x45\x3c\x2f\x74\x64\76\x3c\57\164\x72\x3e";
    if (!empty($tJ)) {
        goto R_;
    }
    echo "\x4e\x6f\x20\x41\x74\164\x72\151\x62\165\x74\145\163\40\122\145\143\145\151\166\x65\x64\x2e";
    goto ik;
    R_:
    foreach ($tJ as $ld => $g2) {
        echo "\74\164\x72\76\x3c\164\x64\x20\163\x74\171\154\x65\x3d\47\x66\x6f\x6e\164\x2d\x77\145\x69\x67\150\164\x3a\x62\157\x6c\144\73\142\157\x72\144\145\162\x3a\x32\x70\x78\x20\x73\x6f\x6c\151\144\x20\x23\x39\x34\71\x30\x39\x30\x3b\x70\x61\x64\x64\151\156\147\x3a\62\45\x3b\x20\167\x6f\x72\144\x2d\x77\162\x61\x70\72\x62\x72\145\141\x6b\x2d\x77\x6f\x72\144\x3b\47\76" . $ld . "\x3c\57\164\x64\76\74\x74\x64\x20\163\164\x79\154\x65\x3d\47\160\x61\144\x64\151\156\x67\72\62\x25\73\x62\x6f\x72\144\x65\x72\72\62\160\170\40\x73\157\154\x69\144\x20\43\71\64\71\60\71\x30\x3b\40\x77\157\162\x64\x2d\x77\x72\141\160\x3a\142\x72\145\141\x6b\55\x77\157\x72\144\x3b\x27\76" . implode("\x3c\150\x72\x2f\76", $g2) . "\74\57\x74\144\x3e\x3c\57\x74\x72\x3e";
        tB:
    }
    I8:
    ik:
    echo "\x3c\57\164\x61\142\154\145\x3e\74\57\x64\151\166\x3e\x3c\144\151\166\x20\x73\x74\x79\x6c\x65\75\x22\155\141\x72\x67\151\x6e\72\63\x25\x3b\144\151\163\x70\x6c\x61\x79\x3a\142\154\x6f\143\153\x3b\x74\x65\170\x74\55\x61\x6c\x69\147\x6e\x3a\x63\x65\x6e\x74\x65\x72\x3b\42\x3e\xa\x9\x9\x3c\x69\156\160\x75\x74\40\163\x74\171\x6c\145\75\42\160\x61\144\x64\x69\156\x67\72\x31\45\73\x77\x69\x64\x74\x68\x3a\x32\65\60\160\x78\73\142\141\143\x6b\147\162\157\x75\x6e\x64\x3a\40\x23\x30\60\x39\x31\103\x44\x20\156\x6f\156\145\40\x72\x65\x70\145\x61\x74\x20\163\143\162\157\x6c\154\40\60\45\x20\60\45\73\143\x75\x72\163\x6f\162\x3a\x20\x70\x6f\151\x6e\164\x65\x72\x3b\x66\x6f\x6e\x74\55\x73\151\x7a\145\72\x31\65\160\x78\x3b\142\157\162\x64\x65\x72\55\167\151\144\x74\x68\x3a\x20\61\x70\170\73\142\157\162\144\145\162\55\x73\164\x79\x6c\x65\72\40\x73\157\x6c\x69\144\73\x62\x6f\x72\144\145\x72\55\x72\141\x64\151\165\x73\72\40\63\x70\x78\x3b\x77\x68\x69\164\145\x2d\163\x70\141\x63\x65\x3a\40\x6e\157\x77\x72\141\x70\73\x62\x6f\170\55\x73\151\x7a\x69\156\147\72\x20\x62\x6f\162\144\x65\162\55\142\157\x78\x3b\142\157\x72\x64\x65\x72\x2d\143\x6f\x6c\x6f\x72\72\40\43\60\x30\67\63\x41\x41\73\x62\x6f\x78\55\x73\150\x61\144\157\x77\72\x20\x30\x70\170\40\61\160\170\x20\60\160\x78\40\162\x67\x62\x61\x28\x31\62\x30\x2c\40\62\60\x30\x2c\40\x32\63\60\54\x20\x30\56\x36\51\x20\x69\x6e\163\145\164\x3b\143\x6f\154\x6f\162\72\40\x23\x46\106\106\73\42\xa\40\40\40\40\x20\x20\40\40\x20\x20\40\40\x74\171\x70\x65\x3d\42\x62\165\x74\x74\157\x6e\42\x20\x76\x61\154\165\145\75\x22\103\x6f\x6e\146\151\x67\x75\x72\x65\x20\x41\164\164\x72\x69\142\165\x74\145\57\x52\157\154\145\x20\115\x61\160\x70\x69\x6e\x67\42\x20\157\156\103\154\x69\143\153\75\42\143\x6c\x6f\x73\x65\x5f\141\x6e\144\x5f\x72\x65\144\151\x72\x65\x63\164\50\x29\x3b\42\x3e\x20\x26\x6e\x62\163\x70\73\40\x3c\151\156\x70\x75\x74\x20\163\x74\x79\x6c\x65\75\x22\160\141\144\x64\151\156\147\72\61\45\x3b\167\151\144\x74\x68\x3a\x31\x30\x30\160\x78\x3b\142\x61\143\x6b\147\x72\157\x75\156\x64\x3a\40\43\x30\x30\x39\61\x43\104\x20\x6e\x6f\156\145\x20\162\x65\160\145\x61\164\x20\163\143\162\x6f\154\154\40\60\x25\x20\x30\x25\73\143\165\x72\163\x6f\x72\72\x20\160\x6f\x69\x6e\x74\145\162\x3b\146\157\156\164\x2d\163\151\172\x65\x3a\61\x35\160\170\73\142\x6f\162\x64\145\162\x2d\x77\x69\144\x74\150\72\40\x31\x70\x78\73\142\x6f\x72\x64\x65\x72\x2d\x73\x74\x79\x6c\145\x3a\40\x73\x6f\x6c\x69\x64\x3b\x62\157\x72\x64\x65\162\55\x72\141\144\151\x75\163\x3a\40\63\160\x78\x3b\167\x68\151\164\145\55\x73\x70\x61\x63\145\x3a\40\156\x6f\167\162\141\x70\73\x62\157\170\55\163\x69\x7a\151\x6e\147\x3a\40\142\157\162\144\145\x72\55\142\x6f\170\x3b\x62\x6f\162\x64\145\x72\55\x63\157\x6c\x6f\162\x3a\x20\43\x30\x30\x37\63\x41\101\73\x62\x6f\x78\55\163\150\x61\x64\x6f\x77\x3a\40\x30\x70\170\40\61\x70\x78\40\60\x70\170\x20\162\147\x62\x61\x28\61\62\x30\x2c\x20\x32\x30\60\x2c\x20\x32\63\x30\x2c\40\x30\56\x36\x29\x20\x69\x6e\163\145\x74\73\143\157\x6c\157\x72\72\x20\x23\x46\x46\x46\x3b\x22\x74\x79\160\x65\75\42\x62\165\164\x74\x6f\156\42\x20\x76\x61\154\x75\x65\x3d\x22\x44\157\156\145\42\x20\x6f\156\103\154\151\143\x6b\x3d\x22\163\x65\154\146\56\x63\154\x6f\163\x65\x28\51\73\x22\x3e\xa\x20\x20\40\x20\x20\x20\x20\x20\12\x20\40\40\x20\40\x20\40\x20\40\40\40\40\x3c\x2f\x64\151\166\x3e\xa\x20\x20\40\x20\40\x20\40\40\x20\x20\x20\x20\12\40\40\40\40\x20\x20\x20\x20\40\x20\40\40\x3c\163\x63\162\151\x70\164\76\12\x20\40\x20\x20\x20\x20\40\40\40\40\40\x20\xa\40\x20\40\40\x20\x20\40\x20\40\40\x20\x20\40\x66\165\156\143\x74\x69\x6f\x6e\x20\143\154\x6f\x73\x65\137\141\156\x64\x5f\x72\145\144\151\162\145\143\164\x28\51\173\xa\40\x20\x20\40\x20\x20\40\40\x20\40\40\40\x20\x20\x20\x20\40\167\x69\156\x64\157\x77\x2e\157\x70\145\156\x65\x72\56\162\145\x64\151\x72\145\143\164\137\164\x6f\137\141\x74\164\162\151\x62\x75\164\145\137\155\141\x70\x70\x69\156\147\50\51\73\xa\40\x20\x20\x20\40\40\40\x20\x20\x20\40\x20\40\x20\x20\40\x20\163\145\x6c\146\x2e\x63\x6c\157\163\145\x28\51\x3b\xa\40\40\x20\40\40\x20\x20\x20\40\40\40\40\x20\x7d\12\40\x20\x20\x20\x20\x20\x20\40\x20\x20\40\x20\12\74\57\163\x63\162\x69\160\x74\76\12\x20\40\40\x20\40\x20\x20\x20\40\40\x20\40\12\40\40\40\x20\x20\x20\40\40\x20\40\x20\40";
    die;
}
function mo_saml_convert_to_windows_iconv($x1)
{
    $ue = get_option("\155\157\137\x73\141\x6d\154\x5f\x65\x6e\143\157\x64\151\156\x67\x5f\145\156\x61\x62\x6c\x65\x64");
    if (!($ue === '' || !mo_saml_is_extension_installed("\151\x63\x6f\x6e\166"))) {
        goto fj;
    }
    return $x1;
    fj:
    return iconv("\125\124\106\55\x38", "\x43\x50\61\x32\65\x32\x2f\x2f\x49\x47\x4e\x4f\122\x45", $x1);
}
function mo_saml_login_user($WM, $Nm, $S1, $rE, $R0, $Gj, $Xo, $VS, $j0, $u4 = '', $RQ = '', $tJ = null)
{
    $co = get_option("\x6d\x6f\137\x73\x61\x6d\154\x5f\x73\x70\137\x62\141\x73\x65\x5f\165\x72\154");
    if (!empty($co)) {
        goto RQ;
    }
    $co = home_url();
    RQ:
    do_action("\x6d\x6f\137\163\141\155\x6c\137\x61\x74\x74\x72\x69\x62\x75\164\145\x73", $rE, $WM, $Nm, $S1, $R0);
    if ($j0 == "\165\163\x65\x72\156\x61\x6d\145" && username_exists($rE) || username_exists($rE)) {
        goto Sh;
    }
    if (email_exists($WM)) {
        goto Ap;
    }
    if (!username_exists($rE) && !email_exists($WM)) {
        goto fr;
    }
    if (username_exists($rE) && !email_exists($WM)) {
        goto zx;
    }
    goto iy;
    Sh:
    $user = get_user_by("\154\157\x67\151\x6e", $rE);
    $bk = $user->ID;
    if (empty($Nm)) {
        goto Nb;
    }
    $Hc = wp_update_user(array("\111\x44" => $bk, "\146\x69\162\x73\164\x5f\156\x61\155\145" => $Nm));
    Nb:
    if (empty($S1)) {
        goto cv;
    }
    $Hc = wp_update_user(array("\111\104" => $bk, "\154\x61\163\164\137\x6e\141\x6d\145" => $S1));
    cv:
    if (empty($WM)) {
        goto M9;
    }
    $Hc = wp_update_user(array("\111\104" => $bk, "\x75\x73\x65\162\x5f\145\155\x61\x69\154" => $WM));
    M9:
    if (!get_option("\155\x6f\137\163\x61\x6d\x6c\x5f\x63\x75\163\164\157\x6d\x5f\x61\164\x74\162\x73\x5f\x6d\x61\160\x70\x69\x6e\x67")) {
        goto Ty;
    }
    $Ss = get_option("\155\x6f\x5f\x73\141\155\154\137\143\x75\163\164\157\155\x5f\x61\x74\x74\162\163\137\155\141\x70\x70\x69\x6e\x67");
    $Ss = maybe_unserialize($Ss);
    foreach ($Ss as $ld => $g2) {
        if (!array_key_exists($g2, $tJ)) {
            goto jd;
        }
        $ty = $tJ[$g2][0];
        update_user_meta($bk, $ld, $ty);
        jd:
        It:
    }
    o3:
    Ty:
    $hp = get_option("\x73\141\x6d\154\x5f\141\x6d\137\x64\157\156\164\137\165\160\144\141\164\145\x5f\145\170\x69\x73\x74\151\156\x67\137\165\x73\145\x72\137\162\157\x6c\x65");
    if (!empty($hp)) {
        goto vF;
    }
    $hp = "\143\150\145\143\x6b\145\144";
    vF:
    if (!(empty($hp) || $hp != "\143\150\145\x63\153\x65\144")) {
        goto jN;
    }
    $AC = get_option("\x73\x61\x6d\154\137\x61\155\x5f\x72\157\x6c\x65\137\x6d\141\160\x70\x69\156\147");
    $UO = assign_roles_to_user($user, $AC, $R0);
    if ($UO !== true && !is_administrator_user($user) && !empty($Gj) && $Gj == "\x63\x68\145\x63\153\145\x64") {
        goto js;
    }
    if ($UO !== true && !is_administrator_user($user) && !empty($Xo)) {
        goto ea;
    }
    goto Cm;
    js:
    $Hc = wp_update_user(array("\x49\104" => $bk, "\162\157\x6c\145" => false));
    goto Cm;
    ea:
    $Hc = wp_update_user(array("\x49\104" => $bk, "\162\157\x6c\x65" => $Xo));
    Cm:
    jN:
    if (is_null($tJ)) {
        goto QA;
    }
    update_user_meta($bk, "\155\157\x5f\x73\x61\155\x6c\x5f\165\x73\x65\x72\137\x61\164\164\x72\151\x62\165\164\145\163", $tJ);
    $fT = get_option("\x73\x61\155\x6c\137\141\x6d\x5f\x64\151\x73\160\x6c\x61\171\137\156\141\155\145");
    if (empty($fT)) {
        goto oL;
    }
    if (strcmp($fT, "\125\123\105\122\x4e\x41\115\105") == 0) {
        goto sc;
    }
    if (strcmp($fT, "\106\x4e\101\115\x45") == 0 && !empty($Nm)) {
        goto vJ;
    }
    if (strcmp($fT, "\114\x4e\101\115\105") == 0 && !empty($S1)) {
        goto aH;
    }
    if (strcmp($fT, "\106\116\x41\115\105\x5f\114\116\x41\x4d\105") == 0 && !empty($S1) && !empty($Nm)) {
        goto V9;
    }
    if (!(strcmp($fT, "\114\x4e\x41\115\105\137\x46\x4e\x41\x4d\105") == 0 && !empty($S1) && !empty($Nm))) {
        goto ne;
    }
    $Hc = wp_update_user(array("\x49\x44" => $bk, "\144\151\163\160\x6c\141\171\137\156\141\x6d\x65" => $S1 . "\x20" . $Nm));
    ne:
    goto Yd;
    V9:
    $Hc = wp_update_user(array("\x49\104" => $bk, "\144\151\163\x70\154\x61\171\137\x6e\141\155\145" => $Nm . "\x20" . $S1));
    Yd:
    goto Zz;
    aH:
    $Hc = wp_update_user(array("\x49\104" => $bk, "\144\151\x73\x70\x6c\x61\x79\137\x6e\x61\x6d\145" => $S1));
    Zz:
    goto Dp;
    vJ:
    $Hc = wp_update_user(array("\111\104" => $bk, "\144\x69\x73\160\154\141\171\x5f\156\141\155\145" => $Nm));
    Dp:
    goto ee;
    sc:
    $Hc = wp_update_user(array("\111\104" => $bk, "\144\x69\163\x70\x6c\141\171\137\156\x61\x6d\145" => $user->user_login));
    ee:
    oL:
    QA:
    wp_set_current_user($bk);
    wp_set_auth_cookie($bk);
    $user = get_user_by("\151\x64", $bk);
    do_action("\x77\x70\x5f\x6c\x6f\x67\151\156", $user->user_login, $user);
    if (empty($u4)) {
        goto zj;
    }
    update_user_meta($bk, "\155\157\x5f\163\x61\155\x6c\137\163\x65\163\x73\x69\x6f\156\x5f\151\156\144\x65\x78", $u4);
    zj:
    if (empty($RQ)) {
        goto l6;
    }
    update_user_meta($bk, "\155\x6f\137\163\141\155\x6c\137\x6e\x61\155\x65\137\151\144", $RQ);
    l6:
    if (!(!session_id() || session_id() == '' || !isset($_SESSION))) {
        goto VI;
    }
    session_start();
    VI:
    $_SESSION["\x6d\x6f\137\x73\x61\155\x6c"]["\154\x6f\147\x67\145\x64\137\x69\156\137\x77\x69\164\x68\137\x69\x64\160"] = TRUE;
    $rn = get_option("\155\x6f\137\163\141\x6d\154\x5f\162\145\x6c\141\x79\x5f\163\164\141\x74\145");
    if (!empty($rn)) {
        goto O3;
    }
    if (!empty($VS)) {
        goto qA;
    }
    wp_redirect($co);
    goto WJ;
    qA:
    if (filter_var($VS, FILTER_VALIDATE_URL) === FALSE) {
        goto N_;
    }
    if (strpos($VS, home_url()) !== false) {
        goto gv;
    }
    wp_redirect($co);
    goto Cj;
    gv:
    wp_redirect($VS);
    Cj:
    goto Dz;
    N_:
    wp_redirect($VS);
    Dz:
    WJ:
    goto ll;
    O3:
    wp_redirect($rn);
    ll:
    die;
    goto iy;
    Ap:
    $user = get_user_by("\145\x6d\x61\x69\154", $WM);
    $bk = $user->ID;
    if (empty($Nm)) {
        goto to;
    }
    $Hc = wp_update_user(array("\x49\104" => $bk, "\146\x69\162\x73\x74\x5f\156\141\155\x65" => $Nm));
    to:
    if (empty($S1)) {
        goto Eo;
    }
    $Hc = wp_update_user(array("\x49\x44" => $bk, "\x6c\141\x73\164\x5f\156\x61\x6d\x65" => $S1));
    Eo:
    if (!get_option("\x6d\157\137\x73\141\x6d\154\x5f\x63\165\x73\164\157\x6d\x5f\x61\164\164\162\x73\137\x6d\x61\160\x70\x69\156\147")) {
        goto bo;
    }
    $Ss = get_option("\155\157\x5f\163\x61\x6d\154\x5f\x63\165\x73\164\157\155\137\x61\x74\164\x72\x73\137\155\x61\x70\x70\151\x6e\x67");
    $Ss = maybe_unserialize($Ss);
    foreach ($Ss as $ld => $g2) {
        if (!array_key_exists($g2, $tJ)) {
            goto fO;
        }
        $ty = $tJ[$g2][0];
        update_user_meta($bk, $ld, $ty);
        fO:
        G1:
    }
    Ej:
    bo:
    $AC = get_option("\x73\x61\x6d\154\137\141\x6d\137\x72\157\x6c\145\x5f\155\x61\x70\160\151\156\147");
    $hp = get_option("\x73\x61\155\x6c\x5f\x61\155\137\144\x6f\156\164\137\x75\160\144\x61\x74\x65\x5f\145\x78\x69\163\x74\x69\156\147\137\x75\x73\145\x72\x5f\162\x6f\154\145");
    if (!empty($hp)) {
        goto AA;
    }
    $hp = "\x63\x68\145\x63\x6b\x65\144";
    AA:
    if (!(empty($hp) || $hp != "\x63\x68\145\143\x6b\x65\x64")) {
        goto ZL;
    }
    $UO = assign_roles_to_user($user, $AC, $R0);
    if ($UO !== true && !is_administrator_user($user) && !empty($Gj) && $Gj == "\143\150\x65\143\x6b\x65\x64") {
        goto vl;
    }
    if ($UO !== true && !is_administrator_user($user) && !empty($Xo)) {
        goto ir;
    }
    goto Zg;
    vl:
    $Hc = wp_update_user(array("\111\x44" => $bk, "\x72\157\x6c\x65" => false));
    goto Zg;
    ir:
    $Hc = wp_update_user(array("\x49\104" => $bk, "\x72\157\154\145" => $Xo));
    Zg:
    ZL:
    if (is_null($tJ)) {
        goto Bv;
    }
    update_user_meta($bk, "\x6d\x6f\x5f\x73\141\155\x6c\x5f\x75\x73\145\162\137\141\164\164\x72\151\142\x75\x74\x65\x73", $tJ);
    $fT = get_option("\x73\141\155\154\x5f\141\155\x5f\x64\x69\163\x70\154\141\x79\137\x6e\x61\155\x65");
    if (empty($fT)) {
        goto dx;
    }
    if (strcmp($fT, "\x55\x53\x45\x52\x4e\101\115\x45") == 0) {
        goto Ey;
    }
    if (strcmp($fT, "\x46\116\x41\115\105") == 0 && !empty($Nm)) {
        goto Jy;
    }
    if (strcmp($fT, "\114\116\x41\115\105") == 0 && !empty($S1)) {
        goto r4;
    }
    if (strcmp($fT, "\x46\116\x41\115\x45\x5f\114\x4e\x41\x4d\x45") == 0 && !empty($S1) && !empty($Nm)) {
        goto SQ;
    }
    if (!(strcmp($fT, "\114\116\x41\115\x45\137\106\116\101\x4d\x45") == 0 && !empty($S1) && !empty($Nm))) {
        goto pJ;
    }
    $Hc = wp_update_user(array("\111\104" => $bk, "\144\151\x73\160\x6c\x61\x79\x5f\x6e\141\x6d\145" => $S1 . "\x20" . $Nm));
    pJ:
    goto XI;
    SQ:
    $Hc = wp_update_user(array("\111\x44" => $bk, "\144\151\x73\160\154\x61\171\x5f\156\x61\x6d\x65" => $Nm . "\40" . $S1));
    XI:
    goto eE;
    r4:
    $Hc = wp_update_user(array("\x49\104" => $bk, "\x64\151\x73\160\x6c\141\x79\x5f\156\141\x6d\145" => $S1));
    eE:
    goto a7;
    Jy:
    $Hc = wp_update_user(array("\111\104" => $bk, "\x64\151\x73\160\154\x61\x79\137\x6e\x61\155\x65" => $Nm));
    a7:
    goto YT;
    Ey:
    $Hc = wp_update_user(array("\x49\x44" => $bk, "\x64\x69\163\x70\x6c\x61\x79\x5f\156\x61\155\145" => $user->user_login));
    YT:
    dx:
    Bv:
    wp_set_current_user($bk);
    wp_set_auth_cookie($bk);
    $user = get_user_by("\151\x64", $bk);
    do_action("\x77\x70\x5f\154\x6f\147\151\156", $user->user_login, $user);
    if (empty($u4)) {
        goto M8;
    }
    update_user_meta($bk, "\155\x6f\137\x73\x61\x6d\154\137\x73\x65\163\163\151\x6f\x6e\137\x69\156\144\145\x78", $u4);
    M8:
    if (empty($RQ)) {
        goto FK;
    }
    update_user_meta($bk, "\x6d\157\x5f\x73\141\155\x6c\137\x6e\141\155\x65\x5f\151\x64", $RQ);
    FK:
    if (!(!session_id() || session_id() == '' || !isset($_SESSION))) {
        goto NQ;
    }
    session_start();
    NQ:
    $_SESSION["\155\157\x5f\163\x61\155\x6c"]["\154\x6f\147\147\145\144\137\151\x6e\x5f\x77\x69\164\150\137\x69\x64\160"] = TRUE;
    $rn = get_option("\155\157\137\x73\141\x6d\x6c\137\x72\145\x6c\141\171\x5f\163\164\141\164\x65");
    if (!empty($rn)) {
        goto oj;
    }
    if (!empty($VS)) {
        goto eR;
    }
    wp_redirect($co);
    goto yj;
    eR:
    if (filter_var($VS, FILTER_VALIDATE_URL) === FALSE) {
        goto XN;
    }
    if (strpos($VS, home_url()) !== false) {
        goto ED;
    }
    wp_redirect($co);
    goto Uy;
    ED:
    wp_redirect($VS);
    Uy:
    goto ta;
    XN:
    wp_redirect($VS);
    ta:
    yj:
    goto Fk;
    oj:
    wp_redirect($rn);
    Fk:
    die;
    goto iy;
    fr:
    $AC = get_option("\x73\141\155\154\x5f\x61\x6d\x5f\x72\x6f\x6c\x65\x5f\x6d\141\x70\160\x69\x6e\147");
    $i2 = true;
    $Cv = get_option("\x6d\157\137\163\x61\x6d\x6c\137\x64\x6f\156\164\137\x63\x72\145\x61\x74\145\x5f\165\163\x65\x72\137\x69\x66\x5f\162\x6f\x6c\x65\x5f\x6e\x6f\x74\x5f\x6d\141\x70\160\x65\144");
    if (!(!empty($Cv) && strcmp($Cv, "\x63\150\145\x63\x6b\x65\144") == 0)) {
        goto kc;
    }
    $D7 = is_role_mapping_configured_for_user($AC, $R0);
    $i2 = $D7;
    kc:
    if ($i2 === true) {
        goto VB;
    }
    $WZ = "\127\145\x20\x63\157\165\154\144\x20\156\157\x74\40\163\151\147\x6e\40\x79\x6f\165\x20\x69\x6e\56\40\120\x6c\x65\x61\x73\145\40\143\157\x6e\164\x61\143\164\x20\x79\157\x75\x72\40\101\x64\155\x69\x6e\151\163\x74\x72\141\x74\157\x72\56";
    wp_die($WZ, "\105\x72\162\157\162\x3a\40\116\157\x74\x20\141\x20\127\x6f\162\144\x50\162\x65\x73\163\40\115\x65\x6d\x62\145\x72");
    die;
    goto kH;
    VB:
    $Ai = wp_generate_password(10, false);
    if (!empty($rE)) {
        goto H4;
    }
    $bk = wp_create_user($WM, $Ai, $WM);
    goto nQ;
    H4:
    $bk = wp_create_user($rE, $Ai, $WM);
    nQ:
    if (!is_wp_error($bk)) {
        goto iX;
    }
    wp_die($bk->get_error_message());
    iX:
    $user = get_user_by("\151\144", $bk);
    $UO = assign_roles_to_user($user, $AC, $R0);
    if ($UO !== true && !empty($Gj) && $Gj == "\143\150\x65\x63\x6b\145\144") {
        goto n7;
    }
    if ($UO !== true && !empty($Xo)) {
        goto mq;
    }
    if ($UO !== true) {
        goto Nw;
    }
    goto iL;
    n7:
    $Hc = wp_update_user(array("\x49\104" => $bk, "\x72\x6f\x6c\x65" => false));
    goto iL;
    mq:
    $Hc = wp_update_user(array("\x49\104" => $bk, "\162\x6f\x6c\x65" => $Xo));
    goto iL;
    Nw:
    $Xo = get_option("\144\x65\x66\x61\165\x6c\x74\x5f\x72\x6f\x6c\145");
    $Hc = wp_update_user(array("\111\x44" => $bk, "\x72\x6f\x6c\145" => $Xo));
    iL:
    if (empty($Nm)) {
        goto GV;
    }
    $Hc = wp_update_user(array("\111\x44" => $bk, "\146\151\x72\x73\x74\x5f\156\141\x6d\145" => $Nm));
    GV:
    if (empty($S1)) {
        goto fI;
    }
    $Hc = wp_update_user(array("\111\104" => $bk, "\x6c\x61\x73\164\x5f\x6e\141\x6d\x65" => $S1));
    fI:
    if (is_null($tJ)) {
        goto lz;
    }
    update_user_meta($bk, "\x6d\x6f\x5f\x73\141\155\x6c\137\x75\163\x65\162\x5f\141\164\x74\x72\151\x62\165\164\145\163", $tJ);
    $fT = get_option("\163\x61\x6d\154\x5f\141\x6d\137\x64\151\163\x70\154\x61\x79\137\x6e\141\x6d\145");
    if (empty($fT)) {
        goto ad;
    }
    if (strcmp($fT, "\125\x53\x45\122\x4e\101\115\105") == 0) {
        goto X7;
    }
    if (strcmp($fT, "\106\116\x41\115\x45") == 0 && !empty($Nm)) {
        goto aX;
    }
    if (strcmp($fT, "\x4c\116\x41\x4d\105") == 0 && !empty($S1)) {
        goto cF;
    }
    if (strcmp($fT, "\106\116\101\x4d\x45\137\114\116\x41\115\x45") == 0 && !empty($S1) && !empty($Nm)) {
        goto pP;
    }
    if (!(strcmp($fT, "\x4c\116\101\x4d\x45\x5f\x46\116\x41\x4d\105") == 0 && !empty($S1) && !empty($Nm))) {
        goto DB;
    }
    $Hc = wp_update_user(array("\111\x44" => $bk, "\x64\x69\163\x70\154\141\171\x5f\x6e\141\x6d\x65" => $S1 . "\x20" . $Nm));
    DB:
    goto qV;
    pP:
    $Hc = wp_update_user(array("\111\x44" => $bk, "\144\151\x73\x70\x6c\141\x79\137\x6e\x61\x6d\145" => $Nm . "\x20" . $S1));
    qV:
    goto Ji;
    cF:
    $Hc = wp_update_user(array("\x49\x44" => $bk, "\144\151\x73\160\x6c\x61\171\137\x6e\x61\x6d\x65" => $S1));
    Ji:
    goto Fp;
    aX:
    $Hc = wp_update_user(array("\x49\104" => $bk, "\144\151\163\x70\154\141\x79\x5f\x6e\x61\155\145" => $Nm));
    Fp:
    goto Rl;
    X7:
    $Hc = wp_update_user(array("\111\104" => $bk, "\x64\151\x73\x70\154\141\x79\x5f\156\x61\x6d\x65" => $user->user_login));
    Rl:
    ad:
    lz:
    wp_set_current_user($bk);
    wp_set_auth_cookie($bk);
    $user = get_user_by("\x69\x64", $bk);
    do_action("\167\x70\137\x6c\157\147\151\x6e", $user->user_login, $user);
    if (empty($u4)) {
        goto Qy;
    }
    update_user_meta($bk, "\x6d\157\x5f\163\141\155\x6c\x5f\x73\145\163\163\x69\x6f\156\x5f\x69\x6e\144\145\170", $u4);
    Qy:
    if (empty($RQ)) {
        goto Jo;
    }
    update_user_meta($bk, "\x6d\x6f\137\163\141\155\x6c\x5f\156\141\x6d\145\137\x69\x64", $RQ);
    Jo:
    if (!get_option("\x6d\x6f\x5f\x73\141\155\154\x5f\x63\165\x73\x74\157\x6d\x5f\x61\164\164\x72\163\x5f\x6d\141\x70\160\151\x6e\147")) {
        goto cs;
    }
    $Ss = get_option("\155\157\137\163\x61\155\154\x5f\x63\x75\x73\164\x6f\155\x5f\x61\164\x74\x72\163\x5f\155\141\160\160\x69\156\x67");
    $Ss = maybe_unserialize($Ss);
    foreach ($Ss as $ld => $g2) {
        if (!array_key_exists($g2, $tJ)) {
            goto Db;
        }
        $ty = $tJ[$g2][0];
        update_user_meta($bk, $ld, $ty);
        Db:
        BA:
    }
    aB:
    cs:
    if (!(!session_id() || session_id() == '' || !isset($_SESSION))) {
        goto dv;
    }
    session_start();
    dv:
    $_SESSION["\155\157\137\x73\141\x6d\154"]["\x6c\x6f\x67\x67\145\x64\x5f\x69\x6e\x5f\167\151\x74\x68\x5f\x69\x64\x70"] = TRUE;
    kH:
    $rn = get_option("\x6d\x6f\x5f\163\141\155\x6c\x5f\x72\145\x6c\x61\171\x5f\163\x74\141\164\145");
    if (!empty($rn)) {
        goto JF;
    }
    if (!empty($VS)) {
        goto Ub;
    }
    wp_redirect($co);
    goto k5;
    Ub:
    if (filter_var($VS, FILTER_VALIDATE_URL) === FALSE) {
        goto Vv;
    }
    if (strpos($VS, home_url()) !== false) {
        goto sk;
    }
    wp_redirect($co);
    goto Y0;
    sk:
    wp_redirect($VS);
    Y0:
    goto Wq;
    Vv:
    wp_redirect($VS);
    Wq:
    k5:
    goto Oc;
    JF:
    wp_redirect($rn);
    Oc:
    die;
    goto iy;
    zx:
    wp_die("\122\x65\147\x69\x73\x74\162\141\x74\151\157\156\40\x68\x61\163\40\146\x61\x69\154\x65\x64\x20\x61\163\40\x61\40\165\163\x65\x72\40\x77\x69\164\x68\40\164\150\145\40\x73\x61\155\145\x20\165\x73\145\162\156\x61\x6d\x65\40\141\154\x72\x65\141\144\171\40\145\x78\151\163\x74\x73\40\151\x6e\40\x57\x6f\x72\x64\x50\162\x65\163\163\x2e\40\120\x6c\145\141\x73\145\40\x61\x73\153\x20\x79\157\165\162\x20\141\144\x6d\x69\156\x69\163\x74\x72\141\164\x6f\162\40\x74\157\40\x63\162\x65\x61\164\145\40\141\156\40\x61\143\x63\x6f\165\x6e\164\40\x66\157\x72\40\x79\157\x75\40\x77\x69\164\x68\40\x61\x20\x75\156\x69\x71\165\x65\40\x75\x73\x65\162\x6e\x61\x6d\x65\56", "\x45\x72\162\x6f\162");
    iy:
}
function assign_roles_to_user($user, $AC, $R0)
{
    $UO = false;
    if (!(!empty($R0) && !empty($AC) && !is_administrator_user($user))) {
        goto za;
    }
    $user->set_role(false);
    $zY = '';
    $Vh = false;
    foreach ($AC as $dt => $Oi) {
        $Oz = explode("\73", $Oi);
        foreach ($Oz as $ZY) {
            foreach ($R0 as $CX) {
                $CX = trim($CX);
                if (!(!empty($CX) && $CX == $ZY)) {
                    goto ES;
                }
                $UO = true;
                $user->add_role($dt);
                ES:
                mh:
            }
            P0:
            hJ:
        }
        Aj:
        Tw:
    }
    oM:
    za:
    return $UO;
}
function is_role_mapping_configured_for_user($AC, $R0)
{
    if (!(!empty($R0) && !empty($AC))) {
        goto oa;
    }
    foreach ($AC as $dt => $Oi) {
        $Oz = explode("\x3b", $Oi);
        foreach ($Oz as $ZY) {
            foreach ($R0 as $CX) {
                $CX = trim($CX);
                if (!(!empty($CX) && $CX == $ZY)) {
                    goto bD;
                }
                return true;
                bD:
                iG:
            }
            Vx:
            g8:
        }
        Q5:
        FY:
    }
    CI:
    oa:
    return false;
}
function is_administrator_user($user)
{
    $iT = $user->roles;
    if (!is_null($iT) && in_array("\141\x64\x6d\151\156\151\x73\x74\x72\x61\x74\157\162", $iT, TRUE)) {
        goto EQ;
    }
    return false;
    goto su;
    EQ:
    return true;
    su:
}
function mo_saml_is_customer_license_verified()
{
    $ld = get_option("\x6d\157\x5f\x73\141\x6d\154\137\143\165\163\164\x6f\155\x65\162\x5f\x74\157\x6b\x65\156");
    $ec = AESEncryption::decrypt_data(get_option("\x74\137\163\x69\164\x65\137\163\x74\x61\164\165\163"), $ld);
    $mq = get_option("\x73\155\154\x5f\154\x6b");
    $hy = get_option("\155\x6f\137\163\141\155\154\137\x61\144\155\151\x6e\x5f\145\155\141\151\x6c");
    $zs = get_option("\x6d\157\x5f\x73\141\155\154\x5f\141\144\155\x69\x6e\x5f\x63\x75\x73\x74\157\x6d\x65\162\137\x6b\145\x79");
    if (!$ec && !$mq || !$hy || !$zs || !is_numeric(trim($zs))) {
        goto fl;
    }
    return 1;
    goto Ur;
    fl:
    return 0;
    Ur:
}
function saml_get_current_page_url()
{
    $VB = $_SERVER["\x48\x54\124\120\137\x48\x4f\123\124"];
    if (!(substr($VB, -1) == "\57")) {
        goto Zl;
    }
    $VB = substr($VB, 0, -1);
    Zl:
    $UX = $_SERVER["\x52\x45\x51\125\105\x53\x54\137\x55\122\x49"];
    if (!(substr($UX, 0, 1) == "\57")) {
        goto kG;
    }
    $UX = substr($UX, 1);
    kG:
    $JA = isset($_SERVER["\x48\x54\124\120\123"]) && strcasecmp($_SERVER["\x48\124\124\x50\123"], "\x6f\x6e") == 0;
    $f6 = "\150\x74\164\x70" . ($JA ? "\x73" : '') . "\72\x2f\x2f" . $VB . "\x2f" . $UX;
    return $f6;
}
function show_status_error($sQ, $VS, $BA)
{
    $sQ = strip_tags($sQ);
    $BA = strip_tags($BA);
    if ($VS == "\x74\145\163\164\126\x61\x6c\x69\144\x61\x74\145") {
        goto Za;
    }
    wp_die("\127\x65\x20\x63\157\165\154\x64\x20\x6e\157\164\x20\x73\x69\x67\x6e\x20\x79\x6f\165\x20\151\x6e\x2e\x20\x50\154\145\141\x73\145\40\143\x6f\156\x74\141\x63\x74\x20\171\x6f\x75\x72\x20\101\144\155\151\x6e\151\x73\164\162\x61\x74\x6f\162\x2e", "\x45\x72\x72\x6f\x72\72\40\x49\x6e\x76\141\x6c\151\144\40\x53\x41\115\x4c\40\122\x65\x73\x70\x6f\x6e\x73\145\40\x53\x74\141\x74\x75\163");
    goto gp;
    Za:
    echo "\x3c\144\151\166\x20\x73\x74\x79\x6c\145\x3d\x22\146\x6f\156\164\55\x66\x61\155\151\x6c\x79\x3a\103\x61\x6c\x69\x62\162\151\73\160\141\144\144\151\156\147\72\60\x20\63\45\x3b\42\76";
    echo "\74\144\151\x76\x20\x73\164\171\154\145\x3d\42\x63\x6f\x6c\157\162\72\40\x23\141\71\64\64\x34\62\73\x62\x61\x63\x6b\x67\x72\157\165\x6e\x64\x2d\x63\157\x6c\157\162\72\x20\x23\146\62\144\145\144\145\x3b\x70\141\144\144\x69\x6e\x67\x3a\40\61\x35\160\x78\73\155\141\x72\x67\151\x6e\55\x62\x6f\164\x74\157\x6d\x3a\x20\62\x30\x70\170\73\164\x65\x78\164\55\141\x6c\x69\147\156\x3a\x63\x65\156\164\145\x72\x3b\x62\157\x72\144\x65\x72\x3a\61\160\170\40\163\x6f\x6c\x69\144\x20\43\x45\66\x42\63\102\62\x3b\x66\157\x6e\x74\55\163\x69\x7a\x65\72\x31\70\x70\164\73\42\x3e\40\105\x52\x52\x4f\122\74\57\x64\x69\x76\76\xa\x20\x20\40\x20\x20\40\x20\40\x20\40\40\40\40\x20\40\x20\74\x64\x69\166\40\163\164\171\154\145\75\42\x63\x6f\x6c\x6f\162\72\40\x23\141\71\64\64\64\62\73\x66\x6f\156\164\x2d\163\151\172\x65\x3a\x31\x34\160\164\73\x20\155\141\162\147\151\x6e\55\x62\x6f\164\x74\157\155\72\x32\x30\x70\x78\73\42\x3e\74\x70\76\74\163\x74\162\x6f\x6e\x67\x3e\105\x72\162\x6f\162\x3a\x20\74\57\x73\164\x72\157\156\x67\x3e\x20\111\156\x76\x61\154\x69\144\40\x53\101\x4d\114\40\x52\145\163\x70\157\156\163\145\x20\x53\164\x61\164\x75\163\x2e\x3c\x2f\x70\76\12\x20\x20\x20\x20\x20\40\40\40\40\40\40\x20\x20\x20\40\x20\74\160\x3e\74\163\x74\162\157\156\x67\76\103\x61\165\x73\145\x73\x3c\x2f\x73\x74\162\x6f\156\147\76\x3a\x20\x49\144\x65\x6e\x74\x69\x74\x79\40\120\162\157\x76\x69\144\x65\162\40\150\141\x73\x20\163\x65\x6e\x74\x20\x27" . $sQ . "\x27\x20\163\x74\x61\x74\165\163\40\143\x6f\x64\x65\40\x69\x6e\40\123\x41\115\x4c\x20\122\145\163\x70\x6f\x6e\163\145\x2e\x20\74\x2f\x70\76\12\11\11\11\11\11\11\x9\11\74\x70\76\74\x73\164\x72\157\156\x67\76\x52\145\x61\163\x6f\156\74\57\163\164\x72\157\156\x67\x3e\72\x20" . get_status_message($sQ) . "\74\57\x70\x3e\x20";
    if (empty($BA)) {
        goto jc;
    }
    echo "\x3c\x70\x3e\x3c\x73\164\162\x6f\156\147\76\123\x74\x61\x74\165\163\x20\x4d\x65\163\x73\x61\147\145\40\x69\156\x20\x74\150\145\x20\x53\x41\115\114\x20\x52\x65\163\160\x6f\x6e\x73\x65\72\74\57\x73\x74\x72\x6f\x6e\147\76\40\x3c\142\x72\57\76" . $BA . "\74\57\160\76";
    jc:
    echo "\74\142\x72\76\12\x9\x9\11\11\x3c\x2f\144\x69\x76\x3e\12\xa\40\40\40\x20\40\40\x20\x20\40\x20\40\40\40\x20\x20\40\x3c\144\x69\166\x20\163\164\x79\154\145\75\42\155\x61\162\x67\x69\x6e\x3a\x33\x25\73\x64\x69\163\160\x6c\141\171\72\142\154\x6f\143\153\x3b\x74\x65\170\x74\x2d\x61\154\151\x67\x6e\x3a\143\145\156\x74\145\x72\73\x22\x3e\xa\x20\x20\x20\x20\x20\x20\40\x20\40\40\40\40\x20\40\40\x20\x3c\144\x69\x76\40\163\x74\171\x6c\145\x3d\x22\155\x61\162\x67\x69\x6e\x3a\63\45\73\x64\x69\163\160\x6c\x61\x79\x3a\142\x6c\x6f\x63\x6b\73\164\x65\x78\x74\x2d\141\154\x69\147\156\72\x63\x65\x6e\164\x65\x72\73\42\x3e\74\151\x6e\x70\x75\164\40\163\x74\x79\154\145\x3d\x22\x70\x61\144\144\x69\156\x67\72\x31\45\73\x77\151\144\x74\150\72\x31\x30\x30\160\170\73\142\x61\143\x6b\147\x72\157\x75\156\x64\x3a\40\x23\x30\60\x39\61\x43\104\x20\156\157\156\x65\40\162\x65\x70\x65\x61\x74\x20\163\143\x72\x6f\x6c\154\40\x30\x25\40\x30\x25\x3b\143\165\x72\x73\157\162\x3a\40\160\157\151\x6e\x74\x65\162\73\146\157\156\x74\x2d\x73\x69\172\x65\72\x31\65\x70\x78\73\x62\157\x72\144\x65\x72\55\x77\x69\144\x74\x68\72\40\61\x70\x78\73\x62\157\162\x64\x65\162\55\x73\x74\171\154\145\72\40\163\157\154\x69\144\73\142\x6f\162\144\x65\x72\55\x72\141\144\x69\165\x73\x3a\x20\63\160\170\x3b\167\x68\x69\164\145\x2d\163\x70\141\x63\145\x3a\40\x6e\x6f\x77\162\x61\x70\x3b\x62\157\x78\x2d\x73\151\172\x69\x6e\147\x3a\40\x62\157\162\x64\145\x72\55\142\x6f\x78\x3b\142\157\x72\x64\x65\162\55\x63\157\x6c\x6f\162\72\x20\43\60\60\67\63\101\101\x3b\x62\157\170\55\x73\150\141\144\x6f\x77\x3a\40\x30\160\x78\40\x31\x70\170\x20\60\160\170\40\x72\147\142\141\x28\61\x32\60\54\40\62\60\x30\54\40\x32\63\60\54\x20\60\x2e\66\51\40\151\x6e\163\x65\x74\73\143\157\154\157\x72\x3a\40\43\106\x46\106\x3b\42\164\x79\160\145\x3d\x22\142\x75\x74\x74\157\x6e\42\40\166\141\x6c\165\145\x3d\42\104\157\156\x65\x22\x20\157\156\x43\154\x69\143\x6b\75\42\163\145\154\x66\56\x63\x6c\x6f\x73\145\50\x29\x3b\42\x3e\74\x2f\144\151\x76\x3e";
    die;
    gp:
}
function get_status_message($sQ)
{
    switch ($sQ) {
        case "\x52\x65\x71\x75\x65\163\x74\x65\162":
            return "\124\150\145\40\162\x65\161\x75\145\x73\164\40\x63\157\x75\x6c\144\40\156\x6f\x74\40\x62\x65\x20\160\x65\162\146\x6f\x72\155\145\x64\40\144\x75\145\x20\x74\x6f\40\x61\x6e\x20\145\162\x72\x6f\162\x20\x6f\156\x20\x74\150\x65\x20\160\x61\162\x74\x20\157\146\x20\164\x68\145\40\162\145\161\165\145\x73\164\145\162\x2e";
            goto at;
        case "\x52\x65\163\x70\x6f\x6e\144\x65\162":
            return "\124\x68\x65\40\162\x65\x71\x75\x65\x73\164\40\x63\x6f\165\154\x64\40\x6e\x6f\x74\x20\142\x65\40\160\x65\162\146\x6f\x72\155\x65\x64\x20\144\x75\145\x20\164\x6f\x20\x61\x6e\40\145\162\x72\x6f\x72\40\157\x6e\40\x74\x68\x65\40\x70\141\162\164\x20\157\146\x20\164\x68\145\x20\123\101\115\114\x20\x72\x65\163\160\157\156\x64\x65\x72\40\157\162\40\123\x41\115\x4c\40\141\x75\x74\150\157\162\151\164\x79\56";
            goto at;
        case "\x56\x65\x72\x73\x69\x6f\x6e\x4d\x69\x73\155\141\164\143\150":
            return "\124\x68\x65\40\x53\101\115\x4c\x20\x72\145\x73\x70\x6f\156\x64\x65\x72\x20\x63\x6f\165\154\x64\x20\156\157\x74\x20\160\x72\x6f\143\145\163\163\x20\164\x68\x65\40\x72\x65\x71\x75\145\x73\x74\40\142\x65\143\141\165\163\x65\40\x74\150\x65\x20\x76\145\x72\163\x69\157\x6e\x20\157\x66\x20\164\150\x65\x20\x72\x65\161\165\145\x73\x74\40\155\x65\163\163\141\147\x65\x20\x77\x61\163\40\x69\x6e\x63\157\x72\162\145\143\164\x2e";
            goto at;
        default:
            return "\125\156\153\x6e\157\x77\x6e";
    }
    oh:
    at:
}
function mo_saml_register_widget()
{
    register_widget("\155\x6f\x5f\x6c\x6f\x67\151\x6e\137\167\151\x64");
}
function addLink($B6, $z9)
{
    $bZ = "\74\141\x20\150\162\x65\x66\75\42" . $z9 . "\42\76" . $B6 . "\x3c\57\x61\76";
    return $bZ;
}
add_action("\167\151\x64\147\x65\x74\x73\137\x69\156\151\x74", "\x6d\157\x5f\163\141\155\154\137\x72\x65\147\151\163\164\x65\162\x5f\x77\x69\144\x67\145\x74");
add_action("\x69\156\151\x74", "\x6d\x6f\x5f\x6c\x6f\x67\151\x6e\137\166\141\154\151\x64\141\164\x65");
?>
