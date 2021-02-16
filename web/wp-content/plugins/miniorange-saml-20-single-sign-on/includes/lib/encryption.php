<?php


class AESEncryption
{
    public static function encrypt_data($uY, $uZ)
    {
        $uZ = openssl_digest($uZ, "\x73\150\x61\x32\65\x36");
        $Vp = "\x41\x45\x53\x2d\x31\62\x38\x2d\x45\x43\x42";
        $gb = openssl_encrypt($uY, $Vp, $uZ, OPENSSL_RAW_DATA || OPENSSL_ZERO_PADDING);
        return base64_encode($gb);
    }
    public static function decrypt_data($uY, $uZ)
    {
        $VN = base64_decode($uY);
        $uZ = openssl_digest($uZ, "\163\x68\x61\x32\x35\x36");
        $Vp = "\101\105\123\55\61\x32\x38\x2d\x45\x43\x42";
        $qR = openssl_cipher_iv_length($Vp);
        $ML = substr($VN, 0, $qR);
        $uY = substr($VN, $qR);
        $Jq = openssl_decrypt($uY, $Vp, $uZ, OPENSSL_RAW_DATA || OPENSSL_ZERO_PADDING, $ML);
        return $Jq;
    }
}
?>
