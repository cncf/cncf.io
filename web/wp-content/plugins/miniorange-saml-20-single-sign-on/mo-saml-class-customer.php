<?php


class Customersaml
{
    public $email;
    public $phone;
    private $defaultCustomerKey = "\61\66\65\65\x35";
    private $defaultApiKey = "\x66\x46\144\62\x58\143\x76\124\x47\x44\x65\155\132\x76\x62\167\61\x62\x63\x55\x65\163\116\x4a\x57\x45\x71\113\142\142\125\161";
    function create_customer()
    {
        $Q2 = mo_options_plugin_constants::HOSTNAME . "\x2f\155\x6f\x61\163\x2f\162\x65\163\x74\57\x63\x75\163\x74\x6f\155\145\x72\57\141\x64\144";
        $current_user = wp_get_current_user();
        $this->email = get_option("\155\157\x5f\x73\141\x6d\154\x5f\x61\144\x6d\151\156\137\145\155\x61\151\x6c");
        $this->phone = get_option("\155\x6f\137\163\x61\155\x6c\137\x61\x64\155\x69\x6e\x5f\160\150\157\156\145");
        $Sc = get_option("\x6d\x6f\x5f\163\x61\x6d\x6c\137\x61\144\x6d\151\156\137\x70\141\x73\163\x77\157\162\144");
        $Dl = array("\143\x6f\x6d\160\x61\x6e\x79\116\141\155\145" => $_SERVER["\x53\105\122\x56\105\x52\x5f\x4e\101\115\x45"], "\141\x72\x65\141\117\x66\x49\x6e\164\x65\x72\x65\163\164" => "\127\x50\x20\x6d\151\x6e\151\117\162\x61\156\147\x65\x20\x53\x41\x4d\x4c\40\62\x2e\60\40\x53\x53\117\x20\120\154\165\147\x69\156", "\x66\151\x72\x73\x74\156\x61\155\145" => $current_user->user_firstname, "\154\x61\x73\x74\156\x61\x6d\145" => $current_user->user_lastname, "\x65\155\x61\151\154" => $this->email, "\160\x68\157\x6e\145" => $this->phone, "\x70\141\163\x73\x77\157\162\144" => $Sc);
        $bt = json_encode($Dl);
        $Z4 = array("\103\157\156\x74\145\x6e\164\55\124\x79\160\x65" => "\141\160\160\x6c\151\x63\141\x74\151\x6f\156\x2f\x6a\x73\157\x6e", "\x63\x68\141\x72\163\x65\164" => "\125\x54\x46\55\70", "\101\x75\164\x68\157\162\x69\x7a\141\164\151\157\x6e" => "\x42\141\163\x69\x63");
        $Gf = array("\155\x65\x74\150\x6f\x64" => "\120\117\123\124", "\x62\x6f\144\x79" => $bt, "\164\x69\155\145\x6f\165\x74" => "\x35", "\x72\145\144\151\162\x65\143\164\x69\157\x6e" => "\65", "\150\164\x74\x70\x76\145\162\163\151\157\x6e" => "\61\x2e\x30", "\142\x6c\157\143\153\x69\156\147" => true, "\150\x65\x61\x64\145\162\x73" => $Z4);
        $HG = SAMLSPUtilities::mo_saml_wp_remote_call($Q2, $Gf);
        return $HG;
    }
    function get_customer_key()
    {
        $Q2 = mo_options_plugin_constants::HOSTNAME . "\x2f\x6d\157\141\163\x2f\x72\x65\x73\164\57\x63\165\163\164\x6f\155\145\x72\x2f\153\145\x79";
        $bz = get_option("\155\x6f\137\163\141\x6d\154\137\141\144\155\x69\156\137\145\155\141\151\x6c");
        $Sc = get_option("\155\157\137\163\141\155\x6c\137\x61\x64\x6d\x69\x6e\137\x70\x61\163\x73\167\157\x72\x64");
        $Dl = array("\145\x6d\141\151\154" => $bz, "\x70\141\163\163\167\x6f\162\x64" => $Sc);
        $bt = json_encode($Dl);
        $Z4 = array("\x43\x6f\156\164\x65\x6e\x74\x2d\124\x79\x70\x65" => "\x61\x70\160\154\151\x63\141\164\x69\157\x6e\57\152\x73\157\156", "\143\150\x61\162\163\145\x74" => "\125\x54\106\55\70", "\x41\165\164\x68\x6f\x72\x69\x7a\x61\164\x69\157\x6e" => "\102\x61\163\151\143");
        $Gf = array("\x6d\x65\164\150\157\144" => "\120\x4f\x53\x54", "\142\157\144\x79" => $bt, "\x74\151\155\x65\x6f\165\x74" => "\65", "\x72\145\x64\x69\x72\145\143\164\x69\157\x6e" => "\x35", "\150\x74\164\160\166\145\x72\x73\x69\x6f\x6e" => "\x31\x2e\60", "\142\x6c\157\143\153\x69\x6e\x67" => true, "\x68\x65\x61\144\145\x72\x73" => $Z4);
        $HG = SAMLSPUtilities::mo_saml_wp_remote_call($Q2, $Gf);
        return $HG;
    }
    function check_customer()
    {
        $Q2 = mo_options_plugin_constants::HOSTNAME . "\x2f\155\157\x61\163\x2f\162\145\x73\164\57\x63\x75\163\164\x6f\x6d\145\162\x2f\x63\x68\145\143\x6b\55\x69\x66\x2d\x65\x78\151\163\164\x73";
        $bz = get_option("\x6d\x6f\137\x73\141\x6d\x6c\x5f\x61\x64\x6d\x69\x6e\x5f\145\x6d\141\151\x6c");
        $Dl = array("\145\155\x61\x69\x6c" => $bz);
        $bt = json_encode($Dl);
        $Z4 = array("\103\x6f\156\164\x65\156\x74\x2d\x54\171\160\x65" => "\141\160\x70\x6c\x69\x63\x61\164\x69\157\x6e\x2f\x6a\163\157\x6e", "\x63\150\141\x72\163\x65\x74" => "\125\124\106\55\70", "\101\165\164\150\x6f\162\x69\172\141\164\151\x6f\156" => "\102\x61\x73\151\x63");
        $Gf = array("\155\x65\x74\150\157\144" => "\x50\x4f\123\124", "\142\x6f\144\x79" => $bt, "\x74\151\155\x65\157\x75\x74" => "\65", "\x72\x65\x64\x69\162\x65\143\x74\x69\157\156" => "\65", "\x68\164\x74\160\166\x65\x72\163\x69\x6f\x6e" => "\x31\56\x30", "\142\154\157\x63\x6b\151\156\147" => true, "\150\x65\x61\144\145\x72\163" => $Z4);
        $HG = SAMLSPUtilities::mo_saml_wp_remote_call($Q2, $Gf);
        return $HG;
    }
    function send_otp_token($bz, $VP, $V4 = TRUE, $si = FALSE)
    {
        $Q2 = mo_options_plugin_constants::HOSTNAME . "\57\155\x6f\141\x73\57\x61\160\x69\x2f\141\x75\x74\x68\57\143\150\141\x6c\x6c\x65\x6e\x67\145";
        $e6 = $this->defaultCustomerKey;
        $Mc = $this->defaultApiKey;
        $Jd = round(microtime(true) * 1000);
        $m1 = $e6 . number_format($Jd, 0, '', '') . $Mc;
        $jx = hash("\x73\150\x61\x35\61\x32", $m1);
        $Jd = number_format($Jd, 0, '', '');
        if ($V4) {
            goto NR;
        }
        $Dl = array("\x63\165\163\164\x6f\x6d\145\162\x4b\x65\x79" => $e6, "\x70\x68\157\x6e\x65" => $VP, "\141\x75\164\150\x54\x79\x70\x65" => "\123\115\123", "\164\162\x61\156\163\141\143\x74\151\157\156\x4e\x61\x6d\145" => "\x57\120\x20\x6d\151\x6e\151\117\x72\x61\156\147\x65\40\123\x41\115\x4c\x20\62\56\x30\40\123\x53\117\x20\120\x6c\165\147\151\x6e");
        goto OC;
        NR:
        $Dl = array("\x63\x75\163\164\157\x6d\x65\162\x4b\145\x79" => $e6, "\x65\155\141\x69\x6c" => $bz, "\x61\165\x74\150\x54\171\x70\145" => "\105\x4d\x41\x49\x4c", "\164\162\x61\156\163\x61\x63\164\151\x6f\156\116\x61\x6d\x65" => "\x57\120\x20\155\151\156\x69\117\x72\x61\156\147\145\x20\123\x41\x4d\114\40\x32\x2e\x30\x20\123\123\x4f\40\x50\x6c\165\147\x69\x6e");
        OC:
        $bt = json_encode($Dl);
        $Z4 = array("\x43\157\156\x74\x65\x6e\x74\x2d\x54\x79\160\145" => "\141\x70\160\x6c\151\143\x61\164\151\x6f\156\57\152\163\157\x6e", "\x43\165\x73\164\x6f\x6d\145\x72\x2d\x4b\145\x79" => $e6, "\x54\151\155\x65\x73\164\141\x6d\160" => $Jd, "\x41\165\x74\x68\x6f\162\151\x7a\141\164\151\x6f\156" => $jx);
        $Gf = array("\155\x65\x74\150\x6f\x64" => "\x50\x4f\x53\x54", "\x62\157\x64\x79" => $bt, "\x74\x69\155\145\x6f\x75\x74" => "\65", "\162\x65\144\151\x72\145\143\x74\x69\157\156" => "\x35", "\150\164\164\x70\x76\145\x72\x73\x69\157\x6e" => "\61\x2e\60", "\142\154\157\143\x6b\x69\x6e\x67" => true, "\x68\145\141\x64\x65\162\163" => $Z4);
        $HG = SAMLSPUtilities::mo_saml_wp_remote_call($Q2, $Gf);
        return $HG;
    }
    function validate_otp_token($Hm, $eI)
    {
        $Q2 = mo_options_plugin_constants::HOSTNAME . "\x2f\x6d\157\x61\x73\57\141\160\x69\x2f\141\165\x74\150\x2f\x76\x61\154\x69\x64\x61\164\x65";
        $e6 = $this->defaultCustomerKey;
        $Mc = $this->defaultApiKey;
        $h3 = get_option("\x6d\157\137\x73\141\155\154\137\x61\144\x6d\151\x6e\x5f\145\x6d\141\x69\x6c");
        $Jd = round(microtime(true) * 1000);
        $m1 = $e6 . number_format($Jd, 0, '', '') . $Mc;
        $jx = hash("\x73\x68\141\x35\61\x32", $m1);
        $Jd = number_format($Jd, 0, '', '');
        $Dl = '';
        $Dl = array("\x74\x78\111\x64" => $Hm, "\164\157\x6b\x65\x6e" => $eI);
        $bt = json_encode($Dl);
        $Z4 = array("\103\157\x6e\x74\145\156\x74\x2d\124\171\160\145" => "\x61\x70\160\154\x69\143\141\164\x69\x6f\156\57\x6a\x73\157\x6e", "\103\x75\x73\164\x6f\x6d\x65\x72\x2d\113\x65\x79" => $e6, "\124\151\x6d\x65\x73\x74\x61\x6d\x70" => $Jd, "\101\165\164\150\x6f\x72\151\172\141\x74\151\x6f\156" => $jx);
        $Gf = array("\155\x65\x74\150\157\x64" => "\x50\x4f\123\124", "\142\157\144\171" => $bt, "\164\151\x6d\x65\x6f\165\x74" => "\65", "\162\145\x64\x69\x72\x65\x63\164\x69\x6f\x6e" => "\x35", "\150\x74\164\160\x76\x65\x72\x73\151\x6f\156" => "\x31\56\60", "\x62\x6c\x6f\143\x6b\x69\x6e\x67" => true, "\150\145\141\144\x65\x72\x73" => $Z4);
        $HG = SAMLSPUtilities::mo_saml_wp_remote_call($Q2, $Gf);
        return $HG;
    }
    function submit_contact_us($bz, $VP, $jz)
    {
        $current_user = wp_get_current_user();
        $jz = "\x5b\127\120\40\123\x41\115\x4c\x20\62\x2e\60\x20\x53\x50\40\x53\x53\x4f\x20\x53\164\x61\156\144\x61\x72\x64\40\x50\154\x75\x67\x69\x6e\135\x20" . $jz;
        $Dl = array("\146\151\162\x73\164\x4e\141\x6d\145" => $current_user->user_firstname, "\x6c\x61\163\164\116\x61\155\x65" => $current_user->user_lastname, "\x63\x6f\x6d\160\141\x6e\x79" => $_SERVER["\x53\105\122\126\x45\x52\x5f\116\x41\x4d\105"], "\x63\x63\105\155\x61\x69\154" => "\x73\x61\x6d\154\163\x75\x70\x70\x6f\162\164\x40\x78\x65\x63\165\x72\151\x66\x79\x2e\x63\x6f\x6d", "\x65\155\x61\x69\154" => $bz, "\160\x68\157\x6e\x65" => $VP, "\161\x75\145\162\171" => $jz);
        $bt = json_encode($Dl);
        $Q2 = mo_options_plugin_constants::HOSTNAME . "\x2f\x6d\157\x61\163\57\x72\x65\163\164\57\x63\165\x73\164\x6f\155\x65\162\57\143\157\x6e\x74\x61\x63\x74\55\165\163";
        $Z4 = array("\103\x6f\156\x74\145\x6e\x74\x2d\124\171\160\x65" => "\141\160\x70\154\151\x63\x61\164\x69\157\x6e\x2f\152\x73\x6f\x6e", "\143\x68\x61\162\x73\145\x74" => "\x55\x54\x46\55\x38", "\101\x75\x74\x68\x6f\162\x69\x7a\x61\x74\x69\x6f\156" => "\102\x61\x73\151\143");
        $Gf = array("\x6d\145\164\150\157\x64" => "\120\x4f\x53\124", "\x62\x6f\x64\x79" => $bt, "\164\151\x6d\x65\157\x75\x74" => "\x35", "\162\x65\x64\x69\162\x65\143\x74\x69\157\156" => "\x35", "\150\x74\164\x70\x76\x65\x72\x73\x69\157\x6e" => "\61\x2e\60", "\x62\x6c\157\x63\153\151\x6e\x67" => true, "\x68\x65\141\144\x65\x72\x73" => $Z4);
        $HG = SAMLSPUtilities::mo_saml_wp_remote_call($Q2, $Gf);
        return $HG;
    }
    function mo_saml_send_alert_email($uV)
    {
        $Q2 = mo_options_plugin_constants::HOSTNAME . "\x2f\x6d\x6f\141\x73\57\x61\160\x69\57\x6e\x6f\x74\151\146\x79\x2f\163\x65\156\x64";
        $e6 = get_option("\155\x6f\137\163\141\x6d\154\x5f\x61\144\x6d\151\x6e\x5f\143\165\x73\164\x6f\155\x65\162\x5f\x6b\145\171");
        $Mc = get_option("\155\x6f\137\x73\141\155\x6c\x5f\x61\144\x6d\151\156\x5f\x61\x70\151\137\153\145\171");
        $Jd = round(microtime(true) * 1000);
        $m1 = $e6 . number_format($Jd, 0, '', '') . $Mc;
        $jx = hash("\163\150\x61\x35\x31\x32", $m1);
        $Ts = get_option("\155\x6f\137\x73\141\155\x6c\x5f\141\x64\x6d\151\x6e\137\145\x6d\141\151\x6c");
        $ys = "\110\x65\154\154\157\54\74\x62\x72\x3e\74\x62\x72\x3e\x59\157\x75\x72\40\x3c\142\76\106\122\105\105\40\124\x72\x69\x61\154\x3c\57\x62\x3e\40\x77\x69\154\x6c\40\x65\170\x70\x69\162\145\40\x69\156\x20" . $uV . "\x20\144\141\x79\x73\x20\x66\157\x72\x20\x6d\151\156\x69\117\162\141\x6e\147\x65\x20\123\x41\115\114\x20\x70\154\x75\147\x69\x6e\40\157\x6e\40\171\x6f\165\x72\40\x77\145\x62\163\x69\164\145\x20\x3c\x62\x3e" . get_bloginfo() . "\74\x2f\142\x3e\56\x3c\x62\162\x3e\x3c\x62\162\76" . addLink("\x43\154\151\143\x6b\x20\x68\x65\x72\x65", "\150\x74\x74\x70\x73\x3a\x2f\x2f\141\165\x74\150\x2e\155\151\x6e\x69\157\162\141\156\x67\145\x2e\143\x6f\x6d\57\155\x6f\141\x73\57\154\157\x67\151\x6e\x3f\162\145\x64\x69\162\x65\143\164\125\x72\x6c\75\150\164\164\x70\x73\72\x2f\x2f\x61\x75\164\x68\x2e\x6d\x69\156\x69\157\162\x61\x6e\x67\145\x2e\143\x6f\155\x2f\155\157\141\x73\x2f\151\x6e\151\164\151\141\x6c\151\x7a\145\160\141\x79\x6d\x65\156\164\46\162\x65\x71\x75\x65\x73\x74\x4f\162\x69\147\x69\156\x3d\x77\x70\x5f\x73\x61\155\x6c\x5f\163\x73\x6f\x5f\x62\x61\163\151\x63\137\160\x6c\141\x6e") . "\40\x74\x6f\40\165\x70\147\x72\141\x64\145\40\x74\157\x20\x6f\x75\x72\40\160\162\x65\155\x69\x75\x6d\40\160\x6c\x61\156\x20\x73\157\x6f\156\40\x69\x66\40\x79\157\x75\40\x77\141\156\164\40\164\x6f\x20\x63\157\156\164\151\x6e\165\x65\40\165\x73\x69\156\147\40\157\165\x72\x20\x70\x6c\x75\x67\151\x6e\x2e\40\x59\157\165\40\143\x61\156\40\162\x65\146\x65\x72\40\114\151\143\x65\x6e\x73\x69\156\147\x20\164\x61\x62\40\x66\x6f\162\40\x6f\x75\x72\x20\160\x72\145\x6d\x69\x75\x6d\x20\160\x6c\141\x6e\x73\56\74\142\162\76\x3c\x62\162\x3e\x54\150\x61\x6e\x6b\x73\x2c\x3c\x62\x72\76\x6d\x69\x6e\x69\117\x72\x61\x6e\147\x65";
        $Jd = number_format($Jd, 0, '', '');
        $z2 = "\x54\162\151\x61\154\x20\x76\145\162\x73\x69\x6f\156\x20\145\170\160\x69\x72\x69\156\147\40\x69\x6e\x20" . $uV . "\40\144\141\x79\x73\40\x66\x6f\x72\40\155\151\156\x69\117\x72\x61\x6e\x67\145\40\123\101\115\114\x20\x70\154\x75\147\x69\x6e\40\174\x20" . get_bloginfo();
        if (!($uV == 1)) {
            goto EJ;
        }
        $ys = str_replace("\144\x61\171\163", "\144\x61\x79", $ys);
        $z2 = str_replace("\x64\x61\x79\163", "\144\141\x79", $z2);
        EJ:
        $Dl = array("\143\x75\x73\164\157\x6d\x65\162\113\145\x79" => $e6, "\163\x65\156\x64\x45\x6d\x61\x69\x6c" => true, "\145\155\141\151\x6c" => array("\x63\x75\163\x74\x6f\155\x65\162\113\x65\171" => $e6, "\x66\x72\157\x6d\105\x6d\141\151\154" => "\151\156\146\157\x40\x78\145\143\165\162\151\x66\x79\56\x63\x6f\155", "\x62\x63\143\105\x6d\141\151\154" => "\x61\x6e\x69\x72\x62\x61\156\100\170\145\143\165\x72\x69\146\x79\x2e\143\x6f\155", "\146\162\x6f\x6d\116\141\155\145" => "\x6d\151\x6e\x69\117\162\x61\156\147\145", "\x74\x6f\x45\155\141\151\154" => $Ts, "\164\x6f\116\141\155\145" => $Ts, "\163\165\x62\x6a\145\143\164" => $z2, "\x63\x6f\x6e\164\x65\156\x74" => $ys));
        $bt = json_encode($Dl);
        $Z4 = array("\x43\x6f\156\164\145\x6e\x74\x2d\124\x79\160\145" => "\x61\160\160\154\151\x63\141\x74\x69\x6f\156\x2f\152\163\x6f\x6e", "\103\x75\163\x74\x6f\x6d\145\x72\x2d\113\x65\x79" => $e6, "\x54\x69\x6d\145\x73\164\141\x6d\x70" => $Jd, "\x41\x75\x74\x68\157\x72\x69\x7a\141\x74\x69\157\x6e" => $jx);
        $Gf = array("\x6d\x65\x74\150\x6f\144" => "\120\x4f\123\124", "\142\x6f\x64\x79" => $bt, "\x74\x69\155\x65\x6f\165\x74" => "\65", "\162\145\x64\x69\162\x65\x63\x74\x69\x6f\x6e" => "\65", "\150\x74\x74\160\x76\145\x72\163\x69\x6f\x6e" => "\61\x2e\60", "\142\x6c\x6f\143\x6b\x69\156\x67" => true, "\150\145\141\x64\x65\x72\163" => $Z4);
        $HG = SAMLSPUtilities::mo_saml_wp_remote_call($Q2, $Gf);
        return $HG;
    }
    function mo_saml_forgot_password($bz)
    {
        $Q2 = mo_options_plugin_constants::HOSTNAME . "\57\155\x6f\141\163\57\162\x65\x73\x74\x2f\143\165\x73\x74\x6f\x6d\x65\162\57\x70\x61\163\163\x77\x6f\162\x64\x2d\162\145\x73\x65\164";
        $e6 = get_option("\155\157\x5f\x73\x61\155\x6c\x5f\x61\x64\155\x69\x6e\137\143\165\x73\164\157\155\145\x72\x5f\153\145\x79");
        $Mc = get_option("\x6d\157\x5f\x73\141\x6d\x6c\137\x61\x64\155\x69\156\137\x61\160\x69\137\153\x65\x79");
        $Jd = round(microtime(true) * 1000);
        $m1 = $e6 . number_format($Jd, 0, '', '') . $Mc;
        $jx = hash("\163\x68\x61\65\61\62", $m1);
        $Jd = number_format($Jd, 0, '', '');
        $Dl = '';
        $Dl = array("\x65\155\141\151\154" => $bz);
        $bt = json_encode($Dl);
        $Z4 = array("\x43\x6f\156\x74\145\156\164\55\124\171\x70\145" => "\141\x70\160\x6c\x69\143\141\x74\x69\157\x6e\x2f\x6a\163\157\x6e", "\x43\x75\x73\x74\157\155\x65\x72\x2d\x4b\x65\171" => $e6, "\124\x69\155\145\163\x74\x61\155\160" => $Jd, "\101\165\x74\x68\157\162\151\x7a\x61\164\x69\157\156" => $jx);
        $Gf = array("\155\145\164\150\x6f\x64" => "\x50\x4f\123\124", "\x62\x6f\144\171" => $bt, "\164\151\x6d\145\157\x75\164" => "\x35", "\162\x65\144\x69\x72\145\143\x74\151\x6f\x6e" => "\65", "\150\x74\164\x70\x76\x65\162\163\151\157\x6e" => "\x31\56\60", "\x62\x6c\x6f\143\153\x69\156\x67" => true, "\x68\x65\141\x64\145\162\163" => $Z4);
        $HG = SAMLSPUtilities::mo_saml_wp_remote_call($Q2, $Gf);
        return $HG;
    }
    function mo_saml_vl($HP, $FY)
    {
        $Q2 = '';
        if ($FY) {
            goto zz;
        }
        $Q2 = mo_options_plugin_constants::HOSTNAME . "\x2f\x6d\157\141\x73\x2f\141\160\x69\57\142\141\143\153\x75\160\x63\157\x64\x65\x2f\x76\145\162\151\x66\171";
        goto mC;
        zz:
        $Q2 = mo_options_plugin_constants::HOSTNAME . "\x2f\155\157\x61\163\x2f\141\x70\x69\57\142\x61\x63\x6b\165\160\143\x6f\x64\x65\57\143\x68\145\143\x6b";
        mC:
        $e6 = get_option("\x6d\157\137\163\141\155\x6c\137\x61\144\155\x69\x6e\x5f\x63\165\x73\x74\x6f\x6d\145\162\137\x6b\x65\x79");
        $Mc = get_option("\x6d\x6f\x5f\163\x61\x6d\x6c\137\x61\144\x6d\151\156\x5f\141\160\151\137\153\x65\x79");
        $Jd = round(microtime(true) * 1000);
        $m1 = $e6 . number_format($Jd, 0, '', '') . $Mc;
        $jx = hash("\x73\x68\x61\x35\x31\x32", $m1);
        $Jd = number_format($Jd, 0, '', '');
        $Dl = '';
        $Dl = array("\143\157\x64\x65" => $HP, "\143\x75\x73\164\x6f\x6d\x65\162\113\145\171" => $e6, "\141\144\144\x69\x74\151\157\x6e\x61\154\106\x69\145\154\144\163" => array("\x66\x69\x65\154\144\x31" => home_url()));
        $bt = json_encode($Dl);
        $Z4 = array("\103\157\x6e\164\145\156\164\55\124\x79\160\x65" => "\x61\160\x70\154\151\143\x61\164\151\x6f\x6e\x2f\x6a\x73\157\x6e", "\x43\165\x73\164\x6f\155\145\x72\x2d\x4b\x65\171" => $e6, "\124\x69\x6d\145\163\164\141\155\160" => $Jd, "\x41\x75\164\150\157\162\151\172\141\164\x69\157\x6e" => $jx);
        $Gf = array("\155\145\164\x68\157\144" => "\x50\117\x53\124", "\142\x6f\x64\171" => $bt, "\x74\151\x6d\145\157\165\x74" => "\x35", "\x72\x65\x64\151\162\145\x63\164\151\157\156" => "\65", "\x68\164\x74\160\x76\145\x72\x73\x69\157\156" => "\61\56\60", "\142\154\x6f\x63\153\151\156\147" => true, "\150\x65\141\x64\145\162\163" => $Z4);
        $HG = SAMLSPUtilities::mo_saml_wp_remote_call($Q2, $Gf);
        return $HG;
    }
    function check_customer_ln()
    {
        $Q2 = mo_options_plugin_constants::HOSTNAME . "\x2f\155\157\141\163\x2f\162\145\x73\164\57\x63\x75\x73\164\157\155\145\162\57\154\151\143\145\x6e\x73\x65";
        $e6 = get_option("\x6d\157\137\163\x61\x6d\x6c\137\x61\144\x6d\151\x6e\137\x63\x75\x73\x74\157\x6d\145\162\x5f\x6b\x65\171");
        $Mc = get_option("\155\x6f\x5f\163\x61\x6d\154\x5f\141\144\155\151\x6e\x5f\141\x70\151\137\x6b\145\171");
        $Jd = round(microtime(true) * 1000);
        $m1 = $e6 . number_format($Jd, 0, '', '') . $Mc;
        $jx = hash("\x73\150\x61\65\x31\x32", $m1);
        $Jd = number_format($Jd, 0, '', '');
        $Dl = '';
        $Dl = array("\143\x75\x73\164\x6f\x6d\145\x72\111\x64" => $e6, "\141\x70\160\x6c\151\x63\x61\x74\151\x6f\156\x4e\141\155\145" => "\167\x70\137\x73\x61\155\154\x5f\x73\163\x6f\137\x73\164\141\156\x64\x61\162\144\137\160\154\141\156");
        $bt = json_encode($Dl);
        $Z4 = array("\x43\x6f\156\164\x65\x6e\x74\x2d\x54\x79\x70\x65" => "\141\x70\160\x6c\151\x63\x61\x74\151\157\x6e\x2f\152\x73\157\x6e", "\x43\x75\163\164\157\155\145\162\55\113\145\x79" => $e6, "\x54\151\x6d\x65\x73\164\x61\x6d\x70" => $Jd, "\101\165\x74\x68\x6f\162\x69\x7a\x61\164\151\x6f\156" => $jx);
        $Gf = array("\155\145\164\150\x6f\144" => "\x50\117\123\124", "\142\157\x64\x79" => $bt, "\164\151\x6d\x65\157\165\x74" => "\65", "\162\x65\x64\x69\x72\x65\143\164\151\x6f\156" => "\65", "\x68\x74\164\160\x76\x65\x72\163\151\157\x6e" => "\x31\56\60", "\x62\154\x6f\x63\153\151\156\147" => true, "\x68\145\x61\144\145\x72\163" => $Z4);
        $HG = SAMLSPUtilities::mo_saml_wp_remote_call($Q2, $Gf);
        return $HG;
    }
    function mo_saml_update_status()
    {
        $Q2 = mo_options_plugin_constants::HOSTNAME . "\x2f\155\x6f\x61\163\x2f\x61\160\x69\x2f\142\141\x63\x6b\x75\x70\x63\157\x64\145\x2f\x75\160\144\x61\164\x65\x73\164\x61\x74\165\x73";
        $e6 = get_option("\155\x6f\x5f\x73\141\x6d\154\x5f\x61\x64\155\x69\x6e\x5f\143\x75\163\x74\x6f\x6d\x65\x72\137\153\x65\171");
        $Mc = get_option("\x6d\157\137\x73\141\x6d\x6c\137\x61\144\155\151\156\137\141\160\x69\137\153\145\x79");
        $Jd = round(microtime(true) * 1000);
        $m1 = $e6 . number_format($Jd, 0, '', '') . $Mc;
        $jx = hash("\x73\x68\x61\x35\61\62", $m1);
        $uZ = get_option("\155\157\137\x73\x61\x6d\x6c\137\x63\x75\163\x74\x6f\x6d\145\x72\x5f\x74\x6f\153\x65\x6e");
        $HP = AESEncryption::decrypt_data(get_option("\163\x6d\x6c\x5f\x6c\153"), $uZ);
        $Dl = array("\143\x6f\x64\x65" => $HP, "\x63\x75\163\164\157\x6d\x65\162\113\145\171" => $e6, "\141\144\144\x69\164\151\157\x6e\x61\x6c\106\151\145\x6c\x64\163" => array("\146\x69\145\154\144\61" => home_url()));
        $bt = json_encode($Dl);
        $Jd = number_format($Jd, 0, '', '');
        $Z4 = array("\x43\x6f\x6e\164\x65\156\164\55\x54\x79\x70\145" => "\x61\160\x70\x6c\x69\x63\141\x74\x69\157\156\57\152\x73\x6f\156", "\x43\165\x73\164\x6f\155\x65\x72\55\113\145\171" => $e6, "\124\x69\155\x65\x73\164\x61\155\x70" => $Jd, "\x41\165\164\150\x6f\162\151\172\x61\164\151\157\156" => $jx);
        $Gf = array("\x6d\145\x74\x68\x6f\144" => "\120\x4f\123\124", "\x62\x6f\x64\171" => $bt, "\164\x69\155\x65\157\x75\x74" => "\65", "\x72\x65\144\x69\x72\145\143\x74\151\x6f\x6e" => "\x35", "\150\164\164\x70\166\x65\162\x73\151\157\x6e" => "\61\56\60", "\142\x6c\157\x63\153\151\x6e\x67" => true, "\150\145\x61\x64\145\x72\x73" => $Z4);
        $HG = SAMLSPUtilities::mo_saml_wp_remote_call($Q2, $Gf);
        return $HG;
    }
}
?>
