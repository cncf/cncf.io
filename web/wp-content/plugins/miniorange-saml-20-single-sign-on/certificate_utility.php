<?php


class CertificateUtility
{
    public static function generate_certificate($Ns, $kL, $f7)
    {
        $Xl = openssl_pkey_new();
        $gu = openssl_csr_new($Ns, $Xl, $kL);
        $rb = openssl_csr_sign($gu, null, $Xl, $f7, $kL, time());
        openssl_csr_export($gu, $Nc);
        openssl_x509_export($rb, $nu);
        openssl_pkey_export($Xl, $w8);
        I55:
        if (!(($A4 = openssl_error_string()) !== false)) {
            goto rqU;
        }
        error_log("\103\145\x72\x74\x69\146\151\143\141\x74\x65\125\164\x69\x6c\x69\164\171\72\x20\x45\x72\x72\x6f\162\40\x67\145\x6e\145\162\141\x74\151\156\147\x20\143\x65\x72\x74\x69\x66\x69\143\141\164\145\x2e\40" . $A4);
        goto I55;
        rqU:
        $E7 = array("\160\x75\142\x6c\151\143\x5f\x6b\x65\171" => $nu, "\160\x72\x69\166\x61\x74\x65\x5f\153\x65\171" => $w8);
        return $E7;
    }
}
