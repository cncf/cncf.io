<?php


namespace AESGCM;

require_once "\x41\163\163\x65\162\x74\57\x41\x73\x73\145\x72\x74\151\157\x6e\x2e\160\x68\160";
use Assert\Assertion;
final class AESGCM
{
    public static function encrypt($RY, $Jc, $AZ = null, $R7 = null, $Hf = 128)
    {
        Assertion::string($RY, "\124\x68\x65\40\153\x65\171\x20\x65\x6e\143\x72\171\x70\x74\151\157\156\x20\153\x65\171\40\155\165\163\164\x20\x62\x65\40\x61\x20\x62\x69\156\x61\162\171\40\x73\x74\162\151\x6e\147\x2e");
        $sh = mb_strlen($RY, "\70\142\151\164") * 8;
        Assertion::inArray($sh, array(128, 192, 256), "\x42\x61\x64\x20\153\x65\x79\x20\x65\156\x63\x72\x79\160\164\x69\157\156\40\x6b\x65\x79\40\x6c\x65\x6e\x67\164\x68\x2e");
        Assertion::string($Jc, "\124\x68\x65\40\x49\156\151\x74\151\x61\154\151\x7a\x61\x74\151\157\x6e\x20\126\145\143\x74\x6f\162\40\155\x75\163\x74\40\x62\x65\40\141\x20\142\151\156\141\x72\x79\x20\x73\x74\162\x69\x6e\x67\x2e");
        Assertion::nullOrString($AZ, "\124\150\x65\x20\x64\x61\164\141\x20\x74\157\40\145\156\x63\162\171\160\x74\40\155\x75\x73\164\x20\x62\x65\x20\x6e\165\154\x6c\x20\x6f\162\40\x61\x20\x62\151\156\x61\162\171\40\163\164\x72\x69\156\147\x2e");
        Assertion::nullOrString($R7, "\124\x68\x65\x20\101\144\x64\151\x74\151\x6f\156\x61\154\x20\101\x75\164\150\145\x6e\164\151\143\141\x74\x69\157\x6e\40\x44\x61\x74\x61\x20\x6d\x75\x73\x74\40\142\145\40\156\x75\154\x6c\x20\157\162\x20\x61\x20\x62\151\x6e\x61\x72\171\40\163\x74\x72\x69\156\147\x2e");
        Assertion::integer($Hf, "\111\156\x76\x61\154\x69\144\x20\x74\x61\x67\40\x6c\145\156\x67\x74\150\56\40\x53\x75\x70\x70\x6f\x72\x74\145\144\x20\x76\x61\154\165\145\x73\x20\141\x72\145\x3a\40\61\x32\70\54\40\x31\x32\60\54\x20\61\61\62\54\40\x31\60\x34\x20\x61\x6e\x64\x20\71\66\x2e");
        Assertion::inArray($Hf, array(128, 120, 112, 104, 96), "\111\156\x76\141\154\x69\x64\40\x74\141\147\40\154\145\x6e\147\x74\x68\x2e\40\123\x75\x70\x70\x6f\162\164\x65\144\x20\x76\x61\154\x75\145\163\40\x61\162\145\x3a\40\61\62\70\54\x20\x31\62\60\x2c\x20\61\61\x32\x2c\40\x31\60\x34\x20\x61\156\x64\x20\x39\x36\x2e");
        if (version_compare(PHP_VERSION, "\x37\x2e\61\x2e\60\x52\x43\65") >= 0 && null !== $AZ) {
            goto Mx;
        }
        if (class_exists("\x5c\103\x72\171\x70\x74\157\134\103\151\160\150\x65\x72")) {
            goto EA;
        }
        goto S6;
        Mx:
        return self::encryptWithPHP71($RY, $sh, $Jc, $AZ, $R7, $Hf);
        goto S6;
        EA:
        return self::encryptWithCryptoExtension($RY, $sh, $Jc, $AZ, $R7, $Hf);
        S6:
        return self::encryptWithPHP($RY, $sh, $Jc, $AZ, $R7, $Hf);
    }
    public static function encryptAndAppendTag($RY, $Jc, $AZ = null, $R7 = null, $Hf = 128)
    {
        return implode(self::encrypt($RY, $Jc, $AZ, $R7, $Hf));
    }
    private static function encryptWithPHP71($RY, $sh, $Jc, $AZ = null, $R7 = null, $Hf = 128)
    {
        $dF = "\141\x65\163\55" . $sh . "\55\147\143\155";
        $i9 = null;
        $U8 = openssl_encrypt($AZ, $dF, $RY, OPENSSL_RAW_DATA, $Jc, $i9, $R7, $Hf / 8);
        Assertion::true(false !== $U8, "\x55\156\x61\x62\154\x65\x20\164\157\x20\145\156\143\162\171\x70\164\40\x74\150\x65\x20\144\x61\164\141\56");
        return array($U8, $i9);
    }
    private static function encryptWithPHP($RY, $sh, $Jc, $AZ = null, $R7 = null, $Hf = 128)
    {
        list($OQ, $c1, $LI, $Yi) = self::common($RY, $sh, $Jc, $R7);
        $U8 = self::getGCTR($RY, $sh, self::getInc(32, $OQ), $AZ);
        $yk = self::calcVector($U8);
        $Ej = self::addPadding($U8);
        $Ap = self::getHash($Yi, $R7 . str_pad('', $c1 / 8, "\0") . $U8 . str_pad('', $yk / 8, "\0") . $LI . $Ej);
        $i9 = self::getMSB($Hf, self::getGCTR($RY, $sh, $OQ, $Ap));
        return array($U8, $i9);
    }
    private static function encryptWithCryptoExtension($RY, $sh, $Jc, $AZ = null, $R7 = null, $Hf = 128)
    {
        $mK = \Crypto\Cipher::aes(\Crypto\Cipher::MODE_GCM, $sh);
        $mK->setAAD($R7);
        $mK->setTagLength($Hf / 8);
        $U8 = $mK->encrypt($AZ, $RY, $Jc);
        $i9 = $mK->getTag();
        return array($U8, $i9);
    }
    public static function decrypt($RY, $Jc, $U8, $R7, $i9)
    {
        Assertion::string($RY, "\124\x68\x65\x20\153\145\171\40\145\x6e\143\162\x79\x70\x74\x69\157\156\40\x6b\x65\171\40\155\x75\x73\x74\40\x62\145\40\141\40\142\151\156\141\162\171\40\163\164\x72\x69\156\147\x2e");
        $sh = mb_strlen($RY, "\70\x62\x69\x74") * 8;
        Assertion::inArray($sh, array(128, 192, 256), "\102\x61\144\x20\x6b\x65\x79\x20\x65\x6e\143\162\x79\160\164\151\x6f\x6e\40\x6b\145\171\40\x6c\x65\156\147\164\150\x2e");
        Assertion::string($Jc, "\124\150\145\40\111\156\x69\x74\x69\141\x6c\151\x7a\141\x74\151\157\x6e\40\x56\145\x63\x74\157\x72\40\x6d\165\x73\164\40\x62\145\40\141\x20\x62\x69\x6e\x61\162\171\x20\x73\x74\162\x69\156\147\x2e");
        Assertion::nullOrString($U8, "\124\150\145\40\144\x61\164\141\x20\x74\x6f\x20\145\x6e\x63\162\x79\160\164\40\x6d\x75\x73\164\x20\x62\x65\40\156\x75\154\x6c\40\x6f\162\x20\141\40\x62\x69\156\141\162\x79\x20\x73\x74\162\x69\x6e\147\56");
        Assertion::nullOrString($R7, "\124\x68\145\x20\x41\x64\144\151\164\151\157\156\141\154\x20\x41\x75\x74\150\145\156\x74\151\x63\x61\x74\x69\x6f\156\40\x44\141\x74\x61\x20\155\x75\163\x74\40\142\145\40\156\165\x6c\154\40\x6f\162\x20\141\x20\x62\x69\156\141\x72\x79\40\163\164\162\x69\156\147\x2e");
        $Hf = self::getLength($i9);
        Assertion::integer($Hf, "\111\156\x76\141\154\151\x64\x20\164\141\147\40\x6c\145\x6e\147\x74\150\56\x20\123\165\160\x70\157\162\x74\145\x64\x20\x76\x61\x6c\x75\145\163\40\141\162\145\x3a\x20\61\x32\70\x2c\40\x31\62\x30\x2c\40\x31\61\x32\54\40\61\60\x34\x20\141\x6e\144\40\71\x36\x2e");
        Assertion::inArray($Hf, array(128, 120, 112, 104, 96), "\111\x6e\166\x61\x6c\151\x64\x20\164\x61\x67\x20\154\145\x6e\147\164\150\56\x20\123\165\160\160\x6f\x72\164\x65\144\x20\x76\x61\154\x75\145\x73\x20\x61\x72\145\x3a\x20\61\x32\70\54\x20\x31\62\x30\54\x20\x31\61\x32\54\x20\x31\60\64\40\x61\156\x64\x20\x39\66\56");
        if (version_compare(PHP_VERSION, "\x37\x2e\x31\x2e\60\x52\x43\65") >= 0 && null !== $U8) {
            goto Yl;
        }
        if (class_exists("\x5c\x43\162\171\160\x74\157\134\103\151\160\x68\145\x72")) {
            goto yc;
        }
        goto cE;
        Yl:
        return self::decryptWithPHP71($RY, $sh, $Jc, $U8, $R7, $i9);
        goto cE;
        yc:
        return self::decryptWithCryptoExtension($RY, $sh, $Jc, $U8, $R7, $i9, $Hf);
        cE:
        return self::decryptWithPHP($RY, $sh, $Jc, $U8, $R7, $i9, $Hf);
    }
    public static function decryptWithAppendedTag($RY, $Jc, $nd = null, $R7 = null, $Hf = 128)
    {
        $ss = $Hf / 8;
        $U8 = mb_substr($nd, 0, -$ss, "\x38\142\x69\164");
        $i9 = mb_substr($nd, -$ss, null, "\70\x62\151\164");
        return self::decrypt($RY, $Jc, $U8, $R7, $i9);
    }
    private static function decryptWithPHP71($RY, $sh, $Jc, $U8, $R7, $i9)
    {
        $dF = "\141\x65\x73\x2d" . $sh . "\55\147\143\155";
        $AZ = openssl_decrypt(null === $U8 ? '' : $U8, $dF, $RY, OPENSSL_RAW_DATA, $Jc, $i9, null === $R7 ? '' : $R7);
        Assertion::true(false !== $AZ, "\125\156\x61\x62\x6c\x65\40\164\157\x20\144\x65\143\162\171\160\164\x20\x6f\162\40\164\157\40\166\x65\x72\x69\x66\171\x20\164\150\145\40\164\141\x67\56");
        return $AZ;
    }
    private static function decryptWithPHP($RY, $sh, $Jc, $U8, $R7, $i9, $Hf = 128)
    {
        list($OQ, $c1, $LI, $Yi) = self::common($RY, $sh, $Jc, $R7);
        $AZ = self::getGCTR($RY, $sh, self::getInc(32, $OQ), $U8);
        $yk = self::calcVector($U8);
        $Ej = self::addPadding($U8);
        $Ap = self::getHash($Yi, $R7 . str_pad('', $c1 / 8, "\0") . $U8 . str_pad('', $yk / 8, "\0") . $LI . $Ej);
        $ko = self::getMSB($Hf, self::getGCTR($RY, $sh, $OQ, $Ap));
        Assertion::eq($ko, $i9, "\125\156\141\x62\x6c\145\x20\164\x6f\x20\144\x65\x63\162\171\x70\164\x20\x6f\162\x20\x74\x6f\x20\x76\x65\162\x69\146\171\x20\x74\x68\145\40\x74\x61\x67\56");
        return $AZ;
    }
    private static function decryptWithCryptoExtension($RY, $sh, $Jc, $U8, $R7, $i9, $Hf = 128)
    {
        $mK = \Crypto\Cipher::aes(\Crypto\Cipher::MODE_GCM, $sh);
        $mK->setTag($i9);
        $mK->setAAD($R7);
        $mK->setTagLength($Hf / 8);
        return $mK->decrypt($U8, $RY, $Jc);
    }
    private static function common($RY, $sh, $Jc, $R7)
    {
        $Yi = openssl_encrypt(str_repeat("\x0", 16), "\x61\x65\163\55" . $sh . "\x2d\145\x63\x62", $RY, OPENSSL_NO_PADDING | OPENSSL_RAW_DATA);
        $nV = self::getLength($Jc);
        if (96 === $nV) {
            goto BZ;
        }
        $GC = self::calcVector($Jc);
        Assertion::eq(($GC + 64) % 8, 0, "\125\156\141\x62\x6c\145\40\x74\x6f\40\x64\145\143\x72\171\160\x74\x20\x6f\x72\x20\164\x6f\40\x76\145\162\x69\x66\x79\x20\x74\x68\145\x20\164\141\147\56");
        $ax = pack("\116", $nV);
        $SK = str_pad($ax, 8, "\x0", STR_PAD_LEFT);
        $JC = $Jc . str_pad('', ($GC + 64) / 8, "\x0") . $SK;
        $OQ = self::getHash($Yi, $JC);
        goto eu;
        BZ:
        $OQ = $Jc . pack("\x48\52", "\x30\x30\x30\x30\60\60\60\61");
        eu:
        $c1 = self::calcVector($R7);
        $LI = self::addPadding($R7);
        return array($OQ, $c1, $LI, $Yi);
    }
    private static function calcVector($Ka)
    {
        return 128 * ceil(self::getLength($Ka) / 128) - self::getLength($Ka);
    }
    private static function addPadding($Ka)
    {
        return str_pad(pack("\116", self::getLength($Ka)), 8, "\x0", STR_PAD_LEFT);
    }
    private static function getLength($jY)
    {
        return mb_strlen($jY, "\x38\x62\151\x74") * 8;
    }
    private static function getMSB($Ol, $jY)
    {
        $qE = $Ol / 8;
        return mb_substr($jY, 0, $qE, "\70\x62\x69\x74");
    }
    private static function getLSB($Ol, $jY)
    {
        $qE = $Ol / 8;
        return mb_substr($jY, -$qE, null, "\70\x62\x69\x74");
    }
    private static function getInc($Uy, $jY)
    {
        $XH = self::getLSB($Uy, $jY);
        $GO = self::toUInt32Bits($XH) + 1;
        $II = self::getMSB(self::getLength($jY) - $Uy, $jY) . pack("\x4e", $GO);
        return $II;
    }
    private static function toUInt32Bits($nE)
    {
        list(, $Yg, $Cj) = unpack("\156\x2a", $nE);
        return $Cj + $Yg * 65536;
    }
    private static function getProduct($GO, $JE)
    {
        $ri = pack("\110\52", "\105\x31") . str_pad('', 15, "\0");
        $OC = str_pad('', 16, "\x0");
        $RB = $JE;
        $rX = str_split($GO, 4);
        $jY = sprintf("\45\x30\x33\x32\142\45\x30\63\x32\x62\x25\x30\x33\62\x62\x25\60\63\x32\x62", self::toUInt32Bits($rX[0]), self::toUInt32Bits($rX[1]), self::toUInt32Bits($rX[2]), self::toUInt32Bits($rX[3]));
        $D7 = "\1";
        $LH = 0;
        I7:
        if (!($LH < 128)) {
            goto xQ;
        }
        if (!$jY[$LH]) {
            goto jK;
        }
        $OC = self::getBitXor($OC, $RB);
        jK:
        $eB = mb_substr($RB, -1, null, "\x38\x62\151\164");
        if (ord($eB & $D7)) {
            goto MP;
        }
        $RB = self::shiftStringToRight($RB);
        goto L5;
        MP:
        $RB = self::getBitXor(self::shiftStringToRight($RB), $ri);
        L5:
        TF:
        $LH++;
        goto I7;
        xQ:
        return $OC;
    }
    private static function shiftStringToRight($lB)
    {
        $Ip = 4;
        $rX = array_map("\163\x65\x6c\x66\72\x3a\x74\157\125\111\156\x74\63\x32\102\151\x74\163", str_split($lB, $Ip));
        $rC = count($rX);
        $LH = $rC - 1;
        PF:
        if (!($LH >= 0)) {
            goto HE;
        }
        if (!$LH) {
            goto aq;
        }
        $Le = $rX[$LH - 1] & 1;
        if (!$Le) {
            goto Bp;
        }
        $rX[$LH] = $rX[$LH] >> 1 | 2147483648;
        $rX[$LH] = pack("\x4e", $rX[$LH]);
        goto fK;
        Bp:
        aq:
        $rX[$LH] = $rX[$LH] >> 1 & 2147483647;
        $rX[$LH] = pack("\x4e", $rX[$LH]);
        fK:
        $LH--;
        goto PF;
        HE:
        $II = implode('', $rX);
        return $II;
    }
    private static function getHash($Yi, $GO)
    {
        $JE = array();
        $JE[0] = str_pad('', 16, "\x0");
        $d4 = (int) (mb_strlen($GO, "\70\x62\x69\x74") / 16);
        $LH = 1;
        lT:
        if (!($LH <= $d4)) {
            goto t2;
        }
        $JE[$LH] = self::getProduct(self::getBitXor($JE[$LH - 1], mb_substr($GO, ($LH - 1) * 16, 16, "\70\142\x69\x74")), $Yi);
        xN:
        $LH++;
        goto lT;
        t2:
        return $JE[$d4];
    }
    private static function getGCTR($RY, $sh, $JJ, $GO)
    {
        if (!empty($GO)) {
            goto Mj;
        }
        return '';
        Mj:
        $if = (int) ceil(self::getLength($GO) / 128);
        $t4 = array();
        $JE = array();
        $t4[1] = $JJ;
        $LH = 2;
        AD:
        if (!($LH <= $if)) {
            goto iw;
        }
        $t4[$LH] = self::getInc(32, $t4[$LH - 1]);
        B7:
        $LH++;
        goto AD;
        iw:
        $dF = "\141\145\163\x2d" . $sh . "\55\145\143\142";
        $LH = 1;
        Ls:
        if (!($LH < $if)) {
            goto ro;
        }
        $U8 = openssl_encrypt($t4[$LH], $dF, $RY, OPENSSL_NO_PADDING | OPENSSL_RAW_DATA);
        $JE[$LH] = self::getBitXor(mb_substr($GO, ($LH - 1) * 16, 16, "\70\x62\x69\164"), $U8);
        pa:
        $LH++;
        goto Ls;
        ro:
        $kk = mb_substr($GO, ($if - 1) * 16, null, "\70\142\151\x74");
        $U8 = openssl_encrypt($t4[$if], $dF, $RY, OPENSSL_NO_PADDING | OPENSSL_RAW_DATA);
        $JE[$if] = self::getBitXor($kk, self::getMSB(self::getLength($kk), $U8));
        return implode('', $JE);
    }
    private static function getBitXor($Xr, $Ry)
    {
        $xL = PHP_INT_SIZE;
        $Xr = str_split($Xr, $xL);
        $Ry = str_split($Ry, $xL);
        $II = '';
        $rC = count($Xr);
        $LH = 0;
        lN:
        if (!($LH < $rC)) {
            goto ir;
        }
        $II .= $Xr[$LH] ^ $Ry[$LH];
        UD:
        $LH++;
        goto lN;
        ir:
        return $II;
    }
}
