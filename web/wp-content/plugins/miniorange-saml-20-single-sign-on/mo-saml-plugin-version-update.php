<?php


require_once dirname(__FILE__) . "\x2f\x69\x6e\x63\154\165\144\145\x73\57\x6c\151\142\57\155\x6f\x2d\157\x70\x74\151\157\x6e\x73\55\145\x6e\165\x6d\56\x70\x68\x70";
add_action("\x61\144\x6d\x69\156\x5f\151\x6e\151\x74", "\155\157\137\163\141\x6d\x6c\137\165\x70\144\x61\164\x65");
class mo_saml_update_framework
{
    private $current_version;
    private $update_path;
    private $plugin_slug;
    private $slug;
    private $plugin_file;
    private $new_version_changelog;
    public function __construct($KN, $sU = "\57", $wD = "\x2f")
    {
        $this->current_version = $KN;
        $this->update_path = $sU;
        $this->plugin_slug = $wD;
        list($T7, $jN) = explode("\x2f", $wD);
        $this->slug = $T7;
        $this->plugin_file = $jN;
        add_filter("\x70\x72\x65\x5f\x73\145\x74\x5f\x73\x69\x74\x65\x5f\x74\162\x61\156\163\x69\x65\156\164\137\x75\160\144\141\164\x65\x5f\x70\154\x75\147\151\x6e\163", array(&$this, "\x6d\x6f\x5f\x73\x61\x6d\154\137\x63\150\x65\143\153\x5f\165\x70\144\141\164\x65"));
        add_filter("\x70\x6c\165\x67\x69\156\x73\x5f\x61\x70\x69", array(&$this, "\155\x6f\x5f\163\141\x6d\154\137\x63\x68\145\x63\153\137\151\x6e\146\157"), 10, 3);
    }
    public function mo_saml_check_update($b_)
    {
        if (!empty($b_->checked)) {
            goto al;
        }
        return $b_;
        al:
        $zc = $this->getRemote();
        if ($zc["\x73\164\x61\x74\x75\163"] == "\x53\125\103\103\x45\x53\x53") {
            goto he;
        }
        if (!($zc["\x73\x74\x61\164\x75\x73"] == "\x44\105\116\111\x45\x44")) {
            goto E9;
        }
        if (!version_compare($this->current_version, $zc["\x6e\145\x77\126\x65\x72\163\151\x6f\156"], "\x3c")) {
            goto je;
        }
        $T3 = new stdClass();
        $T3->slug = $this->slug;
        $T3->new_version = $zc["\156\x65\x77\126\x65\x72\x73\x69\157\156"];
        $T3->url = "\150\x74\x74\x70\163\x3a\57\x2f\x6d\151\x6e\151\x6f\x72\141\x6e\147\145\56\143\157\155";
        $T3->plugin = $this->plugin_slug;
        $T3->tested = $zc["\143\x6d\163\x43\x6f\x6d\160\141\164\x69\142\x69\x6c\151\164\171\126\145\162\163\151\x6f\156"];
        $T3->icons = array("\61\x78" => $zc["\x69\x63\157\x6e"]);
        $T3->status_code = $zc["\163\x74\x61\x74\x75\163"];
        $T3->license_information = $zc["\154\151\x63\x65\x6e\x73\145\x49\156\x66\157\162\x6d\x61\x74\x69\x6f\x6e"];
        update_option("\x6d\x6f\x5f\163\x61\x6d\154\x5f\x6c\151\143\145\x6e\x73\x65\137\x65\170\160\151\162\x79\137\x64\141\x74\x65", $zc["\x6c\x69\x63\145\x6e\x65\105\x78\160\x69\x72\171\x44\141\x74\145"]);
        $b_->response[$this->plugin_slug] = $T3;
        $ai = true;
        update_option("\155\x6f\x5f\163\x61\x6d\154\137\x73\x6c\145", $ai);
        set_transient("\x75\160\x64\141\x74\x65\137\x70\x6c\165\147\151\156\x73", $b_);
        return $b_;
        je:
        E9:
        goto jy;
        he:
        $ai = false;
        update_option("\155\x6f\137\x73\x61\155\154\137\x73\x6c\145", $ai);
        if (!version_compare($this->current_version, $zc["\x6e\145\167\x56\145\162\x73\x69\157\156"], "\74")) {
            goto oR1;
        }
        ini_set("\155\141\x78\x5f\x65\170\145\143\165\x74\151\157\156\137\x74\151\155\145", 600);
        ini_set("\x6d\145\155\x6f\x72\171\137\x6c\x69\155\151\164", "\61\x30\62\x34\115");
        $this->mo_saml_create_backup_dir();
        $jx = $this->getAuthToken();
        $Jd = round(microtime(true) * 1000);
        $Jd = number_format($Jd, 0, '', '');
        $T3 = new stdClass();
        $T3->slug = $this->slug;
        $T3->new_version = $zc["\x6e\145\x77\126\x65\162\x73\x69\157\x6e"];
        $T3->url = "\x68\164\164\x70\x73\x3a\57\x2f\155\x69\156\151\157\162\141\156\147\x65\x2e\x63\157\x6d";
        $T3->plugin = $this->plugin_slug;
        $T3->package = mo_options_plugin_constants::HOSTNAME . "\x2f\x6d\x6f\x61\163\x2f\x70\x6c\165\x67\x69\x6e\57\x64\157\x77\156\154\x6f\x61\x64\x2d\x75\160\x64\x61\164\145\x3f\160\x6c\x75\x67\x69\x6e\123\x6c\x75\x67\x3d" . $this->plugin_slug . "\46\x6c\x69\143\x65\156\163\145\120\154\141\x6e\116\141\155\145\x3d" . mo_options_plugin_constants::LICENSE_PLAN_NAME . "\46\143\x75\163\x74\157\x6d\x65\162\111\x64\75" . get_option("\x6d\x6f\x5f\163\x61\155\x6c\x5f\x61\144\x6d\x69\156\x5f\x63\x75\x73\164\x6f\x6d\x65\162\x5f\153\x65\x79") . "\46\x6c\151\143\145\156\x73\x65\x54\171\160\145\75" . mo_options_plugin_constants::LICENSE_TYPE . "\x26\141\x75\x74\x68\x54\157\153\x65\x6e\x3d" . $jx . "\x26\157\x74\160\x54\x6f\153\145\156\x3d" . $Jd;
        $T3->tested = $zc["\x63\155\x73\x43\157\x6d\160\x61\x74\151\x62\151\x6c\151\164\171\126\145\x72\x73\x69\x6f\156"];
        $T3->icons = array("\x31\x78" => $zc["\x69\x63\157\156"]);
        $T3->new_version_changelog = $zc["\x63\x68\x61\x6e\147\145\x6c\157\147"];
        $T3->status_code = $zc["\163\164\x61\x74\x75\x73"];
        update_option("\155\x6f\137\x73\x61\155\x6c\x5f\x6c\151\x63\145\x6e\x73\x65\x5f\145\x78\160\x69\x72\x79\137\x64\141\164\x65", $zc["\x6c\x69\143\145\156\145\x45\x78\160\x69\162\171\104\141\164\145"]);
        $b_->response[$this->plugin_slug] = $T3;
        set_transient("\x75\160\144\x61\164\x65\137\x70\x6c\x75\147\151\156\163", $b_);
        return $b_;
        oR1:
        jy:
        return $b_;
    }
    public function mo_saml_check_info($T3, $x3, $v9)
    {
        if (!(($x3 == "\x71\x75\145\x72\x79\x5f\x70\x6c\x75\147\151\156\163" || $x3 == "\x70\x6c\165\x67\x69\156\137\x69\x6e\146\x6f\x72\155\141\x74\x69\x6f\x6e") && isset($v9->slug) && ($v9->slug === $this->slug || $v9->slug === $this->plugin_file))) {
            goto Sg;
        }
        $RP = $this->getRemote();
        remove_filter("\160\154\165\147\x69\x6e\x73\137\141\x70\x69", array($this, "\x6d\x6f\137\x73\x61\155\154\137\143\x68\x65\143\x6b\x5f\x69\156\x66\157"));
        $n8 = plugins_api("\x70\x6c\x75\147\151\156\x5f\x69\x6e\x66\157\x72\x6d\141\x74\151\x6f\x6e", array("\163\x6c\165\x67" => $this->slug, "\146\x69\145\154\x64\x73" => array("\141\x63\x74\151\166\x65\x5f\x69\156\163\164\x61\154\x6c\x73" => true, "\156\165\155\x5f\x72\x61\164\151\x6e\147\x73" => true, "\x72\x61\x74\151\x6e\x67" => true, "\162\141\164\151\156\147\163" => true, "\162\145\x76\151\145\x77\163" => true)));
        $ki = false;
        $yc = false;
        $DH = false;
        $Oq = false;
        $QH = '';
        $BB = '';
        if (is_wp_error($n8)) {
            goto lv;
        }
        $ki = $n8->active_installs;
        $yc = $n8->rating;
        $DH = $n8->ratings;
        $Oq = $n8->num_ratings;
        $QH = $n8->sections["\144\x65\x73\143\162\151\x70\x74\x69\x6f\156"];
        $BB = $n8->sections["\162\145\x76\x69\x65\167\x73"];
        lv:
        add_filter("\x70\154\x75\147\151\156\163\137\x61\160\x69", array($this, "\155\x6f\137\x73\x61\x6d\x6c\137\x63\x68\x65\143\x6b\137\151\156\146\x6f"), 10, 3);
        if ($RP["\x73\164\x61\x74\165\163"] == "\123\125\x43\103\x45\123\x53") {
            goto oF;
        }
        if (!($RP["\x73\164\x61\164\x75\x73"] == "\104\105\116\x49\x45\x44")) {
            goto Rw;
        }
        if (!version_compare($this->current_version, $RP["\x6e\x65\x77\x56\145\x72\x73\151\x6f\156"], "\74")) {
            goto CS;
        }
        $NB = new stdClass();
        $NB->slug = $this->slug;
        $NB->plugin = $this->plugin_slug;
        $NB->name = $RP["\160\x6c\x75\147\151\x6e\116\141\155\145"];
        $NB->version = $RP["\x6e\x65\x77\126\x65\x72\163\x69\157\156"];
        $NB->new_version = $RP["\x6e\145\167\x56\x65\x72\163\151\157\156"];
        $NB->tested = $RP["\x63\155\x73\x43\x6f\155\160\141\164\x69\142\x69\x6c\x69\x74\x79\x56\145\162\163\151\x6f\x6e"];
        $NB->requires = $RP["\x63\155\x73\115\151\x6e\126\145\x72\163\x69\157\x6e"];
        $NB->requires_php = $RP["\160\150\x70\115\151\x6e\x56\x65\x72\163\x69\x6f\x6e"];
        $NB->compatibility = array($RP["\x63\x6d\x73\x43\157\x6d\160\141\164\x69\142\151\x6c\151\164\171\126\x65\x72\163\x69\157\156"]);
        $NB->url = $RP["\x63\155\x73\120\154\165\x67\x69\x6e\x55\162\154"];
        $NB->author = $RP["\x70\x6c\165\147\151\x6e\101\x75\x74\x68\x6f\x72"];
        $NB->author_profile = $RP["\x70\x6c\x75\147\x69\156\x41\165\164\x68\157\162\x50\162\157\x66\151\x6c\145"];
        $NB->last_updated = $RP["\154\x61\x73\x74\x55\x70\x64\x61\164\x65\144"];
        $NB->banners = array("\x6c\x6f\167" => $RP["\142\141\x6e\x6e\x65\162"]);
        $NB->icons = array("\x31\x78" => $RP["\x69\x63\x6f\x6e"]);
        $NB->sections = array("\143\x68\141\x6e\147\145\x6c\x6f\x67" => $RP["\143\150\141\156\x67\x65\x6c\157\147"], "\x6c\x69\x63\145\x6e\x73\145\137\x69\x6e\146\157\x72\x6d\141\x74\151\x6f\156" => _x($RP["\x6c\x69\143\145\x6e\163\x65\x49\156\146\x6f\162\x6d\141\164\x69\157\156"], "\x50\154\165\x67\x69\156\x20\x69\x6e\x73\x74\141\154\154\x65\x72\40\163\145\x63\164\x69\157\156\40\164\x69\164\154\145"), "\144\145\x73\x63\x72\151\x70\164\151\x6f\156" => $QH, "\x52\x65\166\151\145\x77\x73" => $BB);
        $NB->external = '';
        $NB->homepage = $RP["\150\x6f\x6d\145\x70\x61\x67\145"];
        $NB->reviews = true;
        $NB->active_installs = $ki;
        $NB->rating = $yc;
        $NB->ratings = $DH;
        $NB->num_ratings = $Oq;
        update_option("\155\x6f\137\x73\141\155\x6c\137\154\151\x63\x65\156\x73\x65\x5f\x65\x78\x70\x69\162\x79\x5f\144\141\x74\x65", $RP["\154\x69\143\x65\156\145\x45\170\160\151\162\x79\104\x61\164\x65"]);
        return $NB;
        CS:
        Rw:
        goto Mu;
        oF:
        $ai = false;
        update_option("\155\157\x5f\x73\x61\155\154\x5f\x73\154\145", $ai);
        if (!version_compare($this->current_version, $RP["\x6e\145\167\126\x65\x72\163\x69\157\x6e"], "\x3c\x3d")) {
            goto YU;
        }
        $NB = new stdClass();
        $NB->slug = $this->slug;
        $NB->name = $RP["\160\154\165\147\151\x6e\x4e\x61\x6d\x65"];
        $NB->plugin = $this->plugin_slug;
        $NB->version = $RP["\x6e\145\167\x56\x65\x72\x73\x69\157\156"];
        $NB->new_version = $RP["\x6e\x65\167\126\x65\162\x73\x69\x6f\156"];
        $NB->tested = $RP["\143\155\x73\x43\157\x6d\160\x61\164\151\x62\151\x6c\x69\164\171\x56\x65\162\x73\x69\157\x6e"];
        $NB->requires = $RP["\143\x6d\163\115\151\x6e\x56\x65\162\163\x69\x6f\156"];
        $NB->requires_php = $RP["\x70\150\160\115\x69\x6e\126\x65\x72\163\151\x6f\x6e"];
        $NB->compatibility = array($RP["\x63\155\163\103\x6f\x6d\x70\x61\x74\151\x62\x69\x6c\x69\x74\171\x56\x65\162\163\x69\x6f\x6e"]);
        $NB->url = $RP["\143\x6d\x73\x50\x6c\165\147\x69\x6e\125\162\x6c"];
        $NB->author = $RP["\160\x6c\x75\x67\151\x6e\x41\x75\164\150\157\x72"];
        $NB->author_profile = $RP["\160\x6c\x75\147\151\x6e\x41\165\x74\150\x6f\x72\x50\162\x6f\x66\151\154\145"];
        $NB->last_updated = $RP["\154\x61\163\164\x55\160\144\141\x74\145\144"];
        $NB->banners = array("\x6c\157\x77" => $RP["\142\141\x6e\156\145\162"]);
        $NB->icons = array("\61\170" => $RP["\x69\143\x6f\156"]);
        $NB->sections = array("\x63\150\x61\x6e\x67\x65\154\x6f\x67" => $RP["\x63\x68\x61\156\x67\145\x6c\x6f\x67"], "\x6c\151\143\145\x6e\163\x65\137\151\156\146\157\162\x6d\x61\x74\151\157\156" => _x($RP["\154\151\143\x65\x6e\x73\145\111\x6e\x66\157\162\x6d\141\x74\x69\157\x6e"], "\120\x6c\165\147\x69\156\40\x69\156\x73\164\x61\x6c\x6c\x65\162\x20\x73\x65\x63\x74\151\157\156\x20\x74\x69\164\x6c\145"), "\x64\x65\x73\143\162\x69\160\164\x69\157\x6e" => $QH, "\x52\x65\x76\x69\x65\167\163" => $BB);
        $jx = $this->getAuthToken();
        $Jd = round(microtime(true) * 1000);
        $Jd = number_format($Jd, 0, '', '');
        $NB->download_link = mo_options_plugin_constants::HOSTNAME . "\x2f\x6d\x6f\x61\x73\x2f\160\154\x75\x67\x69\x6e\57\144\157\x77\156\154\157\141\x64\55\x75\x70\x64\x61\x74\x65\77\160\x6c\165\x67\x69\x6e\x53\154\165\147\75" . $this->plugin_slug . "\x26\154\x69\143\x65\156\x73\x65\x50\154\x61\x6e\x4e\141\155\145\x3d" . mo_options_plugin_constants::LICENSE_PLAN_NAME . "\46\143\x75\163\x74\x6f\155\145\x72\x49\x64\x3d" . get_option("\155\x6f\137\x73\x61\x6d\x6c\137\141\x64\155\151\156\137\143\x75\163\164\x6f\155\x65\x72\137\x6b\145\x79") . "\46\154\151\143\x65\x6e\163\145\x54\171\160\145\x3d" . mo_options_plugin_constants::LICENSE_TYPE . "\x26\141\x75\164\x68\x54\157\x6b\145\x6e\75" . $jx . "\46\157\x74\160\124\x6f\153\x65\x6e\75" . $Jd;
        $NB->package = $NB->download_link;
        $NB->external = '';
        $NB->homepage = $RP["\150\157\x6d\145\x70\141\x67\145"];
        $NB->reviews = true;
        $NB->active_installs = $ki;
        $NB->rating = $yc;
        $NB->ratings = $DH;
        $NB->num_ratings = $Oq;
        update_option("\x6d\157\137\163\x61\155\154\137\154\151\x63\x65\156\x73\145\137\145\x78\x70\x69\162\171\x5f\144\x61\x74\145", $RP["\x6c\151\x63\145\156\x65\x45\x78\160\151\162\171\x44\141\x74\x65"]);
        return $NB;
        YU:
        Mu:
        Sg:
        return $T3;
    }
    private function getRemote()
    {
        $e6 = get_option("\x6d\157\137\x73\x61\x6d\x6c\137\141\x64\x6d\151\156\x5f\143\x75\x73\x74\157\x6d\x65\x72\137\153\x65\x79");
        $Mc = get_option("\155\x6f\x5f\x73\x61\155\154\x5f\141\x64\155\151\156\x5f\x61\x70\151\x5f\x6b\145\171");
        $Jd = round(microtime(true) * 1000);
        $m1 = $e6 . number_format($Jd, 0, '', '') . $Mc;
        $jx = hash("\x73\x68\x61\x35\61\x32", $m1);
        $Jd = number_format($Jd, 0, '', '');
        $Aq = array("\160\x6c\165\147\151\x6e\123\x6c\165\x67" => $this->plugin_slug, "\x6c\x69\143\x65\156\x73\145\x50\x6c\x61\156\116\141\155\x65" => mo_options_plugin_constants::LICENSE_PLAN_NAME, "\143\x75\x73\164\157\155\145\x72\x49\144" => $e6, "\x6c\x69\143\145\x6e\x73\145\124\171\x70\x65" => mo_options_plugin_constants::LICENSE_TYPE);
        $vW = array("\x68\145\141\144\x65\x72\163" => array("\103\157\x6e\x74\x65\x6e\164\55\124\171\160\x65" => "\x61\160\160\154\x69\143\x61\164\x69\x6f\156\x2f\152\x73\x6f\x6e\x3b\x20\x63\150\x61\x72\163\145\x74\75\x75\164\146\55\x38", "\x43\x75\x73\x74\157\x6d\145\x72\x2d\113\x65\171" => $e6, "\x54\151\x6d\x65\163\164\141\155\x70" => $Jd, "\x41\165\x74\150\x6f\x72\151\172\141\x74\151\x6f\x6e" => $jx), "\142\x6f\x64\171" => json_encode($Aq), "\x6d\145\x74\x68\x6f\x64" => "\x50\x4f\123\x54", "\x64\141\x74\x61\x5f\146\x6f\x72\155\x61\164" => "\142\x6f\144\171", "\x73\x73\x6c\166\145\x72\151\146\171" => false);
        $HG = wp_remote_post($this->update_path, $vW);
        if (!(!is_wp_error($HG) || wp_remote_retrieve_response_code($HG) === 200)) {
            goto SP;
        }
        $Ks = json_decode($HG["\142\157\144\x79"], true);
        return $Ks;
        SP:
        return false;
    }
    private function getAuthToken()
    {
        $e6 = get_option("\155\157\137\163\141\155\x6c\x5f\141\144\x6d\x69\x6e\x5f\143\165\163\164\157\x6d\x65\x72\x5f\x6b\x65\171");
        $Mc = get_option("\x6d\x6f\x5f\x73\x61\155\154\137\141\x64\155\151\156\x5f\x61\160\151\137\153\x65\x79");
        $Jd = round(microtime(true) * 1000);
        $m1 = $e6 . number_format($Jd, 0, '', '') . $Mc;
        $jx = hash("\163\150\141\65\x31\x32", $m1);
        return $jx;
    }
    function mo_saml_plugin_update_message($FE, $HG)
    {
        if (array_key_exists("\x73\x74\141\164\x75\163\x5f\143\157\x64\145", $FE)) {
            goto vQ;
        }
        return;
        vQ:
        if ($FE["\x73\164\x61\164\x75\x73\x5f\x63\157\x64\145"] == "\x53\125\103\x43\x45\123\123") {
            goto Ti;
        }
        if (!($FE["\163\164\141\164\x75\x73\137\143\x6f\144\x65"] == "\104\105\x4e\x49\x45\x44")) {
            goto ej;
        }
        echo sprintf(__($FE["\x6c\x69\x63\145\156\x73\x65\x5f\151\x6e\x66\x6f\162\155\141\x74\x69\157\156"]));
        ej:
        goto RC;
        Ti:
        $AL = wp_upload_dir();
        $p1 = $AL["\x62\x61\x73\145\144\151\x72"];
        $AL = rtrim($p1, "\57");
        $PS = $AL . DIRECTORY_SEPARATOR . "\x62\x61\143\x6b\165\160";
        $rL = "\x6d\x69\156\151\x6f\x72\141\x6e\147\x65\55\163\x61\x6d\x6c\55\x32\x30\55\x73\151\x6e\x67\x6c\145\55\163\x69\x67\x6e\x2d\x6f\x6e\x2d\163\x74\141\x6e\x64\x61\162\144\x2d\142\141\x63\x6b\165\160\55" . $this->current_version;
        $Yb = explode("\x3c\57\165\154\x3e", $FE["\156\x65\167\137\x76\145\x72\163\x69\x6f\156\137\x63\x68\x61\156\x67\145\154\157\x67"]);
        $Qw = $Yb[0];
        $rV = $Qw . "\74\x2f\x75\x6c\76";
        echo "\x3c\x64\151\x76\76";
        if (is_writable($AL)) {
            goto Q6;
        }
        echo "\x3c\142\162\57\x3e\74\x73\x70\x61\156\x20\x73\x74\x79\154\145\x3d\42\143\157\154\157\162\72\162\x65\x64\42\x3e\x3c\x62\76\x4e\117\124\x45\72\40\x49\164\40\x73\145\x65\x6d\x73\40\x74\x68\x65\40\x75\x70\154\x6f\141\x64\163\x20\x64\151\x72\x65\143\x74\157\x72\171\x20\x69\163\40\x6e\x6f\x74\x20\167\x72\151\x74\141\x62\154\x65\56\x20\102\x61\143\153\x75\160\x20\157\146\x20\x74\150\145\40\x63\x75\162\x72\x65\156\x74\x20\160\154\165\x67\151\x6e\x20\x76\x65\162\163\x69\157\156\x20\x63\x6f\x75\x6c\144\156\47\164\40\x62\145\x20\143\162\145\x61\164\x65\x64\x2e\x3c\142\162\57\x3e\x49\x74\40\151\x73\x20\162\145\x63\x6f\x6d\x6d\145\156\144\145\x64\40\164\157\40\160\x72\x6f\x76\151\x64\x65\40\x77\x72\151\164\145\40\x70\x65\162\155\151\163\163\151\157\x6e\x20\x74\x6f\x20\164\150\x65\x20\125\x70\154\157\141\144\x73\40\x64\x69\x72\145\143\x74\x6f\x72\x79\40\50\40" . $AL . "\x20\x29\40\142\145\x66\x6f\162\x65\x20\143\x68\145\143\x6b\151\156\147\40\x66\157\162\x20\x75\x70\144\x61\164\x65\x2e\74\57\142\x3e\74\57\163\x70\141\x6e\76";
        goto BJ;
        Q6:
        echo "\x3c\x62\76" . __("\x3c\x62\162\40\x2f\76\101\x6e\40\x61\x75\x74\157\x6d\141\164\x69\143\x20\142\141\x63\x6b\x75\x70\x20\x6f\x66\x20\x63\165\x72\x72\x65\156\x74\40\x76\145\x72\163\151\157\x6e\40" . $this->current_version . "\x20\150\x61\163\x20\x62\145\145\156\x20\x63\x72\145\141\x74\145\x64\x20\141\164\x20\164\x68\145\40\x6c\157\143\141\164\151\157\156\x20" . $PS . "\40\167\x69\x74\150\40\x74\x68\145\40\156\141\x6d\145\40\x3c\163\160\141\x6e\40\163\x74\x79\x6c\x65\x3d\42\143\x6f\154\x6f\162\x3a\x23\x30\x30\67\63\x61\141\x3b\x22\x3e" . $rL . "\x3c\57\163\160\x61\x6e\x3e\x2e\40\x49\x6e\x20\x63\x61\163\x65\x2c\40\163\x6f\155\x65\x74\x68\x69\156\x67\x20\x62\162\145\x61\x6b\163\x20\x64\165\162\151\x6e\x67\x20\x74\150\x65\x20\x75\x70\x64\141\164\x65\x2c\40\x79\157\165\40\143\x61\156\x20\x72\145\x76\x65\162\164\x20\164\x6f\x20\x79\x6f\165\162\x20\x63\165\x72\162\x65\x6e\x74\40\166\145\x72\163\151\157\156\x20\142\x79\x20\162\145\160\x6c\141\x63\x69\156\x67\x20\164\150\145\40\x62\x61\x63\153\165\x70\x20\165\x73\x69\x6e\x67\40\x46\124\x50\x20\x61\x63\x63\x65\163\x73\x2e", "\155\151\x6e\x69\x6f\x72\x61\x6e\x67\x65\55\163\x61\x6d\x6c\x2d\x32\60\x2d\x73\151\156\147\x6c\x65\55\163\x69\x67\156\55\157\156") . "\x3c\57\x62\76";
        BJ:
        echo "\74\57\x64\151\166\x3e\x3c\144\x69\166\x20\x73\x74\x79\154\145\x3d\x22\x63\x6f\154\157\162\x3a\x20\x23\x66\60\60\73\x22\x3e" . __("\x3c\x62\x72\x20\x2f\x3e\124\141\x6b\145\40\x61\40\155\x69\156\x75\164\145\x20\164\x6f\x20\x63\x68\145\x63\153\40\164\x68\x65\40\x63\150\141\x6e\x67\145\154\x6f\147\40\x6f\x66\x20\154\x61\x74\145\163\x74\x20\166\145\162\163\x69\x6f\156\x20\157\146\x20\164\x68\x65\x20\x70\x6c\165\147\x69\156\56\x20\110\145\x72\145\47\x73\x20\x77\150\171\x20\x79\157\165\x20\156\145\145\x64\x20\164\157\x20\x75\160\x64\x61\x74\x65\72", "\x6d\151\x6e\151\x6f\162\141\x6e\147\x65\55\x73\x61\155\154\55\62\60\55\163\x69\x6e\147\154\145\x2d\163\x69\147\156\55\x6f\x6e") . "\74\57\x64\151\166\x3e";
        echo "\x3c\144\x69\x76\x20\x73\x74\x79\x6c\x65\75\x22\146\157\x6e\x74\x2d\x77\145\x69\147\150\x74\72\40\x6e\157\162\x6d\141\x6c\x3b\42\76" . $rV . "\74\57\x64\x69\x76\76\74\142\x3e\116\x6f\x74\145\72\x3c\57\142\x3e\x20\x50\154\x65\141\163\145\40\143\x6c\151\x63\x6b\40\x6f\156\x20\x3c\x62\76\126\x69\145\167\40\126\x65\x72\163\x69\157\156\40\144\x65\x74\141\x69\x6c\163\x3c\x2f\x62\76\x20\154\151\x6e\153\x20\x74\157\x20\147\x65\x74\x20\143\157\x6d\160\154\145\164\145\40\x63\150\141\x6e\x67\x65\x6c\157\147\40\141\156\x64\40\x6c\151\x63\145\x6e\x73\x65\40\x69\x6e\x66\157\162\x6d\x61\164\x69\x6f\x6e\x2e\40\x43\154\151\143\153\40\x6f\x6e\x20\74\x62\76\x55\x70\144\141\164\x65\x20\116\x6f\x77\74\57\x62\x3e\x20\154\x69\156\153\x20\x74\157\40\165\160\x64\x61\x74\x65\x20\164\x68\145\x20\160\154\x75\147\x69\x6e\x20\x74\157\40\154\141\164\145\163\164\x20\x76\145\x72\163\151\x6f\156\56";
        RC:
    }
    public function mo_saml_license_key_notice()
    {
        if (!array_key_exists("\x6d\157\163\x61\155\154\x2d\144\x69\x73\x6d\x69\163\163", $_GET)) {
            goto Xe;
        }
        return;
        Xe:
        if (!(get_option("\155\157\137\163\x61\155\x6c\137\163\x6c\145") && new DateTime() > get_option("\x6d\157\x2d\163\141\155\154\55\x70\x6c\165\147\x69\x6e\55\164\x69\155\145\x72"))) {
            goto p5;
        }
        $Q2 = esc_url(add_query_arg(array("\x6d\157\163\141\155\154\x2d\x64\x69\163\155\151\x73\x73" => wp_create_nonce("\x73\x61\x6d\x6c\x2d\x64\x69\163\x6d\151\163\163"))));
        echo "\x3c\x73\143\x72\x69\x70\164\x3e\xd\12\x9\11\11\x9\146\x75\156\x63\164\x69\157\x6e\40\155\x6f\x53\x41\x4d\x4c\120\141\x79\155\145\156\x74\123\x74\145\160\x73\50\51\x20\x7b\15\xa\11\x9\x9\x9\11\166\x61\x72\x20\x61\x74\164\x72\x20\75\40\x64\x6f\143\165\x6d\145\x6e\164\56\147\145\164\105\x6c\145\x6d\x65\156\164\x42\171\x49\x64\50\42\x6d\157\x73\x61\x6d\154\160\x61\171\155\145\x6e\164\163\164\145\160\x73\42\51\56\x73\164\x79\154\145\56\144\x69\x73\160\x6c\x61\x79\x3b\xd\12\x9\11\11\11\11\151\146\50\x61\164\x74\x72\40\x3d\75\x20\42\x6e\157\x6e\x65\42\51\173\15\xa\x9\11\x9\x9\x9\x9\x64\x6f\x63\165\155\145\156\x74\56\147\x65\164\105\x6c\145\155\x65\156\164\x42\x79\x49\x64\50\42\155\x6f\163\x61\155\154\x70\141\x79\x6d\145\x6e\x74\x73\x74\145\x70\163\x22\51\x2e\163\164\171\154\145\56\x64\151\163\x70\x6c\x61\171\40\x3d\x20\x22\x62\x6c\157\x63\153\x22\73\xd\12\x9\x9\11\x9\x9\175\145\x6c\163\x65\173\xd\12\11\x9\11\11\x9\11\x64\157\x63\x75\155\145\x6e\164\56\147\145\164\105\x6c\x65\x6d\145\x6e\x74\x42\x79\111\x64\50\42\155\x6f\163\141\155\x6c\x70\141\x79\155\145\x6e\x74\x73\x74\145\x70\x73\x22\x29\x2e\x73\164\x79\x6c\x65\56\x64\151\x73\160\154\141\171\40\x3d\x20\x22\156\157\156\145\x22\73\15\xa\x9\11\11\11\x9\x7d\15\12\11\x9\11\11\x7d\xd\xa\x9\x9\x9\x9\xd\xa\11\11\x9\x9\15\12\x9\11\x9\x3c\x2f\163\143\162\151\x70\x74\76";
        echo "\15\xa\74\144\x69\166\40\x69\x64\75\x22\155\145\x73\163\141\x67\x65\x22\x20\163\164\171\x6c\x65\x3d\x22\160\157\163\151\164\x69\157\x6e\x3a\x72\x65\154\141\164\x69\x76\x65\42\40\x63\x6c\141\x73\163\x3d\x22\x6e\157\x74\x69\143\145\40\x6e\x6f\164\x69\143\145\x20\156\x6f\x74\x69\x63\x65\x2d\167\x61\162\x6e\x69\x6e\x67\42\76\x3c\x62\x72\x20\57\x3e\74\163\x70\x61\156\x20\x63\x6c\x61\163\x73\x3d\42\x61\154\x69\147\156\154\145\x66\x74\x22\40\x73\x74\x79\x6c\145\75\42\x63\x6f\x6c\157\x72\x3a\x23\x61\60\60\73\x66\x6f\156\164\55\x66\x61\155\151\154\171\72\40\x2d\x77\x65\142\153\151\x74\55\160\151\143\164\x6f\x67\x72\x61\160\150\x3b\146\x6f\x6e\x74\55\163\x69\172\x65\72\40\62\x35\x70\x78\x3b\42\76\x49\x4d\x50\x4f\x52\124\x41\116\124\x21\74\57\x73\x70\x61\156\76\74\x62\x72\40\57\76\74\151\155\147\x20\163\x72\x63\x3d\42" . plugin_dir_url(__FILE__) . "\151\155\x61\147\145\x73\57\x6d\151\156\x69\x6f\x72\x61\156\x67\145\x2d\154\157\x67\157\x2e\160\156\147" . "\x22\x20\x63\x6c\x61\163\163\75\x22\x61\x6c\151\147\x6e\x6c\x65\146\164\42\40\x68\145\x69\147\150\164\75\42\x38\x37\x22\40\167\x69\x64\x74\150\75\42\x36\x36\x22\40\x61\154\164\x3d\42\155\151\x6e\x69\x4f\x72\x61\x6e\x67\x65\x20\154\x6f\147\x6f\x22\x20\163\164\x79\154\145\75\x22\155\141\x72\x67\x69\x6e\72\61\60\x70\170\x20\61\x30\160\170\40\x31\60\160\x78\x20\60\73\x20\150\x65\151\147\x68\x74\72\x31\62\70\160\170\x3b\x20\x77\x69\144\x74\x68\72\40\x31\62\x38\x70\170\73\42\76\74\150\x33\76\155\151\x6e\151\117\162\141\156\147\145\x20\123\101\115\x4c\x20\62\56\60\x20\x53\151\156\x67\x6c\145\x20\x53\151\x67\156\x2d\117\x6e\x20\x53\x75\160\160\x6f\162\164\40\x26\40\115\141\151\156\x74\x65\156\141\156\143\x65\40\x4c\x69\x63\x65\156\163\145\40\x45\170\160\151\x72\x65\144\74\x2f\x68\63\x3e\74\x70\76\x59\x6f\x75\162\40\x6d\x69\156\151\117\x72\x61\x6e\147\x65\40\123\x41\x4d\114\x20\62\56\60\x20\123\151\x6e\147\154\145\x20\x53\x69\x67\x6e\55\117\156\40\x6c\151\x63\145\x6e\163\x65\x20\151\163\x20\145\170\x70\151\162\x65\x64\x2e\40\124\150\x69\163\40\x6d\x65\x61\156\163\40\171\157\165\xe2\x80\231\162\145\x20\155\151\x73\x73\151\x6e\x67\x20\157\165\164\40\x6f\x6e\40\154\141\x74\x65\x73\x74\x20\163\x65\143\x75\x72\151\x74\x79\x20\160\141\x74\143\x68\145\163\54\x20\x63\x6f\155\160\141\164\x69\x62\151\154\151\x74\171\x20\167\x69\164\x68\40\164\150\x65\x20\x6c\x61\164\145\x73\x74\x20\120\110\120\x20\166\x65\x72\163\x69\157\x6e\163\40\141\156\144\x20\127\157\x72\144\x70\162\145\163\x73\x2e\40\x4d\157\x73\x74\40\x69\155\160\157\x72\164\141\x6e\164\154\x79\40\x79\x6f\165\xe2\200\231\154\x6c\x20\142\x65\40\x6d\x69\x73\x73\151\156\147\x20\x6f\165\164\40\157\156\x20\x6f\165\x72\40\x61\x77\145\x73\157\x6d\x65\40\163\x75\x70\160\x6f\x72\x74\x21\x20\x3c\x2f\160\x3e\15\12\11\11\x3c\x70\x3e\x3c\x61\40\150\x72\x65\x66\75\x22" . mo_options_plugin_constants::HOSTNAME . "\x2f\155\x6f\141\x73\x2f\x6c\x6f\147\151\x6e\77\x72\145\144\x69\162\x65\x63\x74\125\x72\154\x3d" . mo_options_plugin_constants::HOSTNAME . "\57\x6d\157\x61\163\x2f\x61\x64\155\x69\156\57\143\x75\x73\x74\157\x6d\145\162\x2f\154\x69\143\x65\156\163\145\162\x65\156\x65\x77\141\x6c\163\77\x72\x65\x6e\x65\167\141\154\162\145\x71\x75\145\163\164\75" . mo_options_plugin_constants::LICENSE_TYPE . "\x22\x20\x63\154\141\163\x73\75\42\142\165\x74\x74\157\x6e\x20\142\x75\164\164\157\x6e\55\160\162\x69\155\141\x72\x79\x22\40\164\x61\162\147\x65\164\x3d\42\137\x62\x6c\141\x6e\x6b\42\x3e\122\x65\x6e\x65\167\40\171\x6f\x75\x72\40\x73\x75\160\x70\x6f\162\164\40\154\151\143\145\x6e\163\x65\74\57\141\76\x26\x6e\x62\x73\x70\73\x26\x6e\142\x73\160\x3b\74\142\76\x3c\x61\x20\x68\x72\x65\x66\x3d\42\43\x22\40\x6f\156\x63\154\151\143\x6b\75\x22\x6d\x6f\123\x41\115\x4c\120\x61\171\x6d\145\x6e\164\x53\x74\x65\160\x73\x28\x29\42\x3e\x43\154\151\143\153\x20\x68\145\162\145\x3c\57\x61\76\x20\164\157\x20\x6b\x6e\157\167\x20\x68\x6f\x77\x20\x74\157\40\162\x65\156\x65\x77\x3f\x3c\57\x62\76\74\x64\x69\166\40\151\144\75\42\155\157\163\x61\155\x6c\160\x61\x79\155\x65\x6e\x74\x73\164\145\x70\x73\x22\x20\40\163\x74\171\x6c\145\75\x22\x64\151\163\x70\154\141\x79\x3a\40\156\x6f\x6e\145\x3b\42\76\x3c\142\162\x20\x2f\76\74\165\154\x20\x73\164\x79\x6c\145\75\42\154\151\163\x74\x2d\163\164\171\x6c\145\x3a\x20\x64\151\163\143\73\155\x61\x72\147\x69\x6e\55\x6c\x65\x66\164\x3a\x20\x31\x35\x70\x78\73\42\x3e\xd\12\x3c\154\151\76\x43\x6c\151\x63\x6b\40\x6f\x6e\40\141\x62\x6f\x76\145\x20\142\x75\164\164\x6f\x6e\40\x74\x6f\x20\x6c\x6f\x67\x69\x6e\40\151\156\164\157\x20\155\x69\x6e\151\117\162\141\156\x67\x65\56\x3c\x2f\x6c\x69\76\15\xa\74\x6c\x69\x3e\x59\x6f\165\40\x77\151\154\x6c\x20\142\145\40\162\x65\x64\x69\162\x65\143\x74\x65\144\40\164\157\x20\160\154\165\x67\151\156\x20\162\145\156\x65\167\141\x6c\x20\x70\141\x67\145\x20\141\146\x74\145\162\40\x6c\x6f\147\x69\x6e\56\x3c\x2f\x6c\x69\x3e\xd\12\x3c\154\x69\x3e\x49\x66\x20\x74\x68\145\x20\x70\x6c\165\147\x69\x6e\40\x6c\151\143\145\156\x73\145\40\160\x6c\x61\156\40\x69\x73\x20\x6e\x6f\x74\x20\x73\145\154\145\x63\x74\145\x64\x20\164\150\x65\156\x20\143\150\x6f\157\163\x65\40\164\x68\x65\x20\162\x69\147\x68\164\x20\157\156\x65\40\x66\162\x6f\x6d\40\164\150\x65\40\144\x72\157\160\x64\157\167\156\x2c\x20\157\164\x68\145\x72\167\x69\x73\x65\x20\x63\x6f\x6e\x74\141\x63\x74\40\74\x62\76\74\x61\x20\x68\162\145\x66\x3d\x22\155\x61\151\x6c\164\x6f\x3a\x69\x6e\146\157\x40\170\145\x63\x75\x72\x69\x66\x79\56\x63\157\155\42\x3e\x69\156\146\157\100\170\x65\143\x75\162\151\146\171\56\x63\x6f\155\x3c\x2f\x61\x3e\74\x2f\142\x3e\x20\164\157\40\x6b\x6e\157\167\40\x61\142\x6f\165\164\x20\171\x6f\165\162\40\x6c\151\x63\145\x6e\163\x65\x20\x70\x6c\141\x6e\x2e\x3c\57\154\x69\76\xd\12\x3c\154\x69\76\131\x6f\x75\x20\x77\151\x6c\x6c\x20\163\x65\145\40\x74\150\x65\40\160\x6c\x75\147\x69\x6e\40\162\x65\x6e\x65\x77\x61\154\40\x61\x6d\157\165\x6e\x74\56\74\x2f\154\x69\76\xd\xa\x3c\154\151\x3e\106\x69\154\154\40\x75\160\x20\171\x6f\x75\x72\40\x43\x72\145\x64\x69\x74\40\x43\141\x72\x64\x20\151\156\146\157\x72\155\x61\x74\151\157\156\x20\x74\157\40\155\141\153\145\x20\x74\x68\x65\x20\x70\141\171\155\x65\x6e\164\56\x3c\57\x6c\151\76\15\xa\74\154\151\76\117\x6e\143\x65\x20\x74\x68\145\x20\160\x61\171\x6d\x65\156\x74\40\x69\163\x20\144\x6f\156\x65\x2c\x20\x63\x6c\x69\143\153\40\157\x6e\x20\x3c\x62\76\103\x68\145\x63\153\40\101\x67\x61\151\156\x3c\x2f\142\76\x20\x62\165\164\164\x6f\x6e\40\x66\162\157\x6d\40\164\150\145\40\x46\157\162\143\x65\x20\125\160\144\141\x74\145\40\141\x72\x65\141\40\157\146\x20\x79\x6f\165\162\x20\x57\157\x72\x64\120\x72\145\x73\x73\x20\141\144\155\151\x6e\40\144\141\163\150\x62\157\141\162\x64\x20\x6f\x72\40\167\x61\x69\x74\x20\x66\x6f\162\x20\141\x20\x64\x61\171\x20\x74\x6f\40\147\x65\x74\x20\164\150\x65\x20\141\165\x74\157\155\141\164\x69\143\x20\165\x70\x64\x61\x74\x65\56\74\x2f\x6c\151\x3e\xd\12\x3c\154\x69\x3e\x43\154\x69\x63\x6b\x20\x6f\x6e\40\74\x62\76\125\x70\144\141\164\x65\x20\116\x6f\x77\x3c\57\x62\x3e\40\x6c\x69\x6e\153\x20\x74\157\40\x69\x6e\x73\x74\141\154\x6c\x20\x74\x68\145\x20\x6c\x61\x74\145\x73\x74\x20\x76\145\162\x73\x69\x6f\156\x20\x6f\x66\40\164\150\x65\40\x70\x6c\165\147\151\156\x20\146\162\x6f\155\40\x70\x6c\x75\147\x69\156\40\x6d\141\156\141\147\145\x72\x20\141\x72\145\141\40\x6f\146\x20\x79\x6f\165\x72\x20\x61\x64\155\x69\156\40\144\141\163\x68\142\157\x61\x72\144\x2e\x3c\x2f\154\x69\76\xd\12\x3c\57\x75\x6c\76\x49\x6e\40\x63\x61\163\x65\x2c\40\171\157\165\x20\141\162\x65\x20\x66\141\x63\x69\x6e\x67\x20\x61\156\x79\40\144\151\x66\146\x69\x63\x75\154\164\x79\x20\151\156\x20\x69\156\x73\164\x61\154\154\151\156\x67\x20\164\x68\145\40\165\x70\x64\x61\164\145\54\x20\160\x6c\145\141\163\145\x20\143\x6f\x6e\x74\x61\x63\x74\40\74\x62\76\74\x61\40\x68\x72\145\x66\x3d\42\x6d\141\151\x6c\x74\157\x3a\151\x6e\146\157\x40\x78\145\x63\165\162\151\146\x79\x2e\143\157\x6d\x2e\143\x6f\155\42\x3e\151\156\146\x6f\100\170\x65\x63\165\x72\x69\146\x79\x2e\143\x6f\155\56\143\x6f\155\74\57\141\x3e\74\57\142\x3e\x2e\15\12\117\165\x72\x20\123\x75\x70\160\157\x72\164\x20\105\x78\x65\x63\165\164\x69\166\145\40\x77\x69\154\154\40\141\x73\163\151\x73\164\x20\x79\x6f\x75\40\x69\x6e\x20\151\x6e\163\x74\141\154\x6c\151\x6e\147\40\164\x68\x65\x20\165\x70\144\x61\164\145\163\56\x3c\142\162\x20\x2f\76\74\151\76\106\157\162\40\x6d\x6f\162\145\x20\151\156\146\157\x72\155\x61\164\x69\x6f\x6e\54\x20\160\154\145\141\x73\145\40\x63\157\x6e\x74\x61\x63\164\40\x3c\x62\76\x3c\x61\x20\x68\162\145\146\x3d\42\x6d\x61\151\154\x74\157\x3a\151\156\x66\157\x40\170\x65\x63\x75\x72\x69\x66\x79\56\x63\157\155\56\x63\x6f\x6d\42\x3e\x69\156\146\x6f\100\170\x65\x63\x75\x72\x69\x66\171\x2e\x63\x6f\x6d\56\x63\157\x6d\x3c\57\x61\x3e\74\57\x62\x3e\x2e\x3c\57\x69\x3e\74\57\144\x69\166\76\74\x61\40\x68\162\x65\146\75\42" . $Q2 . "\42\x20\143\154\141\x73\163\75\x22\141\154\151\147\156\x72\151\147\x68\x74\x20\x62\165\x74\164\157\156\40\x62\165\x74\164\157\x6e\x2d\154\151\156\153\x22\76\104\151\x73\x6d\151\x73\x73\x3c\57\141\x3e\x3c\x2f\160\x3e\xd\xa\11\11\74\144\151\166\x20\143\x6c\x61\x73\163\75\x22\x63\x6c\145\141\162\x22\x3e\74\57\x64\x69\166\76\x3c\x2f\x64\151\166\76";
        p5:
    }
    public function mo_saml_dismiss_notice()
    {
        if (!empty($_GET["\x6d\157\163\x61\x6d\x6c\x2d\144\x69\163\155\151\163\x73"])) {
            goto WY;
        }
        return;
        WY:
        if (wp_verify_nonce($_GET["\155\157\x73\x61\x6d\x6c\x2d\144\x69\x73\x6d\x69\x73\163"], "\x73\x61\155\154\x2d\x64\x69\x73\x6d\x69\163\163")) {
            goto uw;
        }
        return;
        uw:
        if (!(isset($_GET["\155\x6f\x73\141\155\154\x2d\144\151\163\x6d\x69\163\163"]) && wp_verify_nonce($_GET["\155\x6f\163\141\x6d\154\x2d\144\151\163\x6d\151\x73\163"], "\x73\x61\x6d\x6c\55\144\151\163\x6d\x69\x73\163"))) {
            goto k4;
        }
        $F2 = new DateTime();
        $F2->modify("\x2b\x31\40\x64\x61\171");
        update_option("\155\x6f\55\x73\x61\x6d\x6c\x2d\160\154\x75\147\151\x6e\55\164\x69\155\145\x72", $F2);
        k4:
    }
    function mo_saml_create_backup_dir()
    {
        $PS = plugin_dir_path(__FILE__);
        $PS = rtrim($PS, "\57");
        $PS = rtrim($PS, "\x5c");
        $FE = get_plugin_data(__FILE__);
        $hZ = $FE["\124\145\170\164\104\157\x6d\x61\151\156"];
        $AL = wp_upload_dir();
        $p1 = $AL["\142\141\x73\x65\x64\151\162"];
        $AL = rtrim($p1, "\57");
        if (is_writable($AL)) {
            goto LF;
        }
        return;
        LF:
        $zj = $AL . DIRECTORY_SEPARATOR . "\142\141\143\x6b\x75\x70" . DIRECTORY_SEPARATOR . $hZ . "\x2d\x73\164\141\156\144\x61\x72\144\55\142\141\x63\x6b\x75\160\55" . $this->current_version;
        if (file_exists($zj)) {
            goto yN;
        }
        mkdir($zj, 511, true);
        yN:
        $Ru = $PS;
        $un = $zj;
        $this->mo_saml_copy_files_to_backup_dir($Ru, $un);
    }
    function mo_saml_copy_files_to_backup_dir($PS, $zj)
    {
        if (!is_dir($PS)) {
            goto O6;
        }
        $TM = scandir($PS);
        O6:
        if (!empty($TM)) {
            goto za;
        }
        return;
        za:
        foreach ($TM as $ys) {
            if (!($ys == "\x2e" || $ys == "\56\56")) {
                goto nc;
            }
            goto Dp;
            nc:
            $ED = $PS . DIRECTORY_SEPARATOR . $ys;
            $cW = $zj . DIRECTORY_SEPARATOR . $ys;
            if (is_dir($ED)) {
                goto Kr;
            }
            copy($ED, $cW);
            goto u5;
            Kr:
            if (file_exists($cW)) {
                goto jp;
            }
            mkdir($cW, 511, true);
            jp:
            $this->mo_saml_copy_files_to_backup_dir($ED, $cW);
            u5:
            Dp:
        }
        F0:
    }
}
function mo_saml_update()
{
    $FI = mo_options_plugin_constants::HOSTNAME;
    $hE = mo_options_plugin_constants::Version;
    $Op = $FI . "\x2f\x6d\157\x61\163\x2f\141\160\151\x2f\160\154\165\147\x69\x6e\x2f\155\x65\x74\x61\144\x61\164\141";
    $wD = plugin_basename(dirname(__FILE__) . "\57\154\157\x67\151\156\x2e\x70\150\x70");
    $K5 = new mo_saml_update_framework($hE, $Op, $wD);
    add_action("\x69\x6e\x5f\x70\154\x75\x67\151\156\137\165\x70\144\x61\x74\x65\137\x6d\145\163\x73\141\147\x65\x2d{$wD}", array($K5, "\155\x6f\x5f\x73\x61\x6d\154\x5f\160\154\165\147\151\156\x5f\x75\x70\144\141\x74\145\x5f\155\145\163\163\141\x67\145"), 10, 2);
    add_action("\x61\144\155\151\156\137\x68\x65\x61\144", array($K5, "\155\157\137\163\x61\x6d\x6c\137\154\x69\x63\x65\x6e\x73\x65\137\153\x65\171\x5f\x6e\x6f\x74\x69\x63\145"));
    add_action("\x61\x64\155\151\156\x5f\156\157\x74\151\143\x65\x73", array($K5, "\155\157\137\163\x61\x6d\x6c\x5f\x64\151\163\x6d\x69\x73\x73\137\156\x6f\164\x69\143\x65"), 50);
    if (!get_option("\x6d\157\x5f\163\141\155\x6c\137\163\x6c\145")) {
        goto o7;
    }
    update_option("\155\x6f\x5f\x73\141\155\x6c\x5f\x73\x6c\x65\137\x6d\145\x73\x73\x61\147\x65", "\x59\x6f\165\162\40\123\101\115\114\x20\x70\x6c\165\x67\x69\x6e\40\x6c\x69\x63\x65\x6e\x73\x65\x20\150\141\x73\x65\x20\x62\x65\x65\156\40\x65\170\x70\151\x72\x65\144\56\40\x59\x6f\165\40\x61\x72\x65\x20\155\151\x73\163\x69\156\x67\x20\157\x75\164\40\x6f\x6e\x20\165\160\144\x61\x74\x65\x73\40\x61\156\x64\x20\x73\x75\x70\160\x6f\x72\x74\41\x20\x50\154\x65\x61\x73\145\40\x3c\x61\40\x68\x72\x65\146\75\42" . mo_options_plugin_constants::HOSTNAME . "\x2f\x6d\157\x61\x73\57\x6c\157\147\151\156\77\162\x65\144\151\x72\x65\x63\164\x55\x72\x6c\75" . mo_options_plugin_constants::HOSTNAME . "\x2f\x6d\157\141\x73\x2f\141\144\x6d\x69\156\x2f\143\165\163\164\x6f\155\x65\162\x2f\x6c\x69\x63\145\156\163\x65\x72\x65\156\x65\x77\141\154\x73\77\x72\145\156\145\x77\x61\x6c\x72\145\161\x75\x65\x73\x74\75" . mo_options_plugin_constants::LICENSE_TYPE . "\40\42\x20\164\x61\162\147\145\164\75\42\137\x62\154\141\156\x6b\42\x3e\74\142\76\103\x6c\x69\143\x6b\40\x48\x65\x72\145\x3c\x2f\142\76\x3c\57\x61\76\x20\x74\157\40\162\x65\156\x65\167\40\x74\150\x65\x20\x53\165\160\x70\x6f\162\164\40\141\x6e\144\x20\x4d\141\151\x6e\164\x65\156\141\x63\x65\40\x70\154\x61\156\56");
    o7:
}
