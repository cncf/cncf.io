<?php


class AESEncryption
{
    public static function encrypt_data($rL, $ld)
    {
        $ld = openssl_digest($ld, "\x73\150\x61\x32\x35\x36");
        $R2 = "\x41\105\x53\x2d\61\x32\70\x2d\105\103\102";
        $ou = openssl_encrypt($rL, $R2, $ld, OPENSSL_RAW_DATA || OPENSSL_ZERO_PADDING);
        return base64_encode($ou);
    }
    public static function decrypt_data($rL, $ld)
    {
        $G6 = base64_decode($rL);
        $ld = openssl_digest($ld, "\x73\x68\x61\x32\65\66");
        $R2 = "\101\105\123\55\61\x32\70\55\105\103\102";
        $IC = openssl_cipher_iv_length($R2);
        $Xn = substr($G6, 0, $IC);
        $rL = substr($G6, $IC);
        $jW = openssl_decrypt($rL, $R2, $ld, OPENSSL_RAW_DATA || OPENSSL_ZERO_PADDING, $Xn);
        return $jW;
    }
}
?>
