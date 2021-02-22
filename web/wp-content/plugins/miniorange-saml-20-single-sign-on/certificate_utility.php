<?php


class CertificateUtility
{
    public static function generate_certificate($YV, $sv, $XO)
    {
        $oc = openssl_pkey_new();
        $h2 = openssl_csr_new($YV, $oc, $sv);
        $wJ = openssl_csr_sign($h2, null, $oc, $XO, $sv, time());
        openssl_csr_export($h2, $d_);
        openssl_x509_export($wJ, $LG);
        openssl_pkey_export($oc, $oC);
        jAl:
        if (!(($LR = openssl_error_string()) !== false)) {
            goto lpq;
        }
        error_log("\103\145\x72\x74\x69\146\x69\143\x61\x74\145\125\x74\x69\154\x69\x74\171\x3a\40\105\x72\162\x6f\162\40\147\x65\x6e\x65\x72\x61\x74\x69\x6e\x67\40\x63\x65\162\x74\x69\146\151\x63\x61\164\x65\x2e\x20" . $LR);
        goto jAl;
        lpq:
        $BH = array("\x70\165\x62\154\151\143\x5f\x6b\145\171" => $LG, "\x70\x72\x69\x76\141\x74\x65\137\x6b\145\171" => $oC);
        return $BH;
    }
}
