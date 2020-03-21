<?php


namespace AESGCM;

require_once "\101\x73\x73\145\162\x74\57\x41\163\163\145\162\x74\151\x6f\156\56\160\150\160";
use Assert\Assertion;
final class AESGCM
{
    public static function encrypt($bP, $Ie, $dV = null, $wi = null, $cu = 128)
    {
        Assertion::string($bP, "\x54\x68\x65\40\153\145\x79\40\x65\156\x63\x72\171\160\x74\x69\157\156\x20\153\x65\x79\x20\x6d\x75\163\x74\x20\142\145\x20\141\x20\x62\x69\x6e\x61\x72\171\x20\x73\164\162\x69\156\x67\56");
        $iM = mb_strlen($bP, "\x38\142\151\164") * 8;
        Assertion::inArray($iM, array(128, 192, 256), "\x42\141\144\40\x6b\x65\x79\40\145\x6e\x63\x72\x79\160\164\x69\157\x6e\x20\x6b\x65\171\x20\154\145\x6e\147\x74\150\x2e");
        Assertion::string($Ie, "\124\x68\x65\40\111\x6e\x69\x74\x69\x61\x6c\151\172\141\164\151\157\x6e\40\x56\x65\x63\164\157\162\40\x6d\165\x73\x74\x20\142\x65\x20\x61\40\x62\151\x6e\141\162\x79\40\x73\164\162\151\x6e\x67\x2e");
        Assertion::nullOrString($dV, "\x54\150\145\40\144\141\164\x61\40\x74\157\40\145\x6e\x63\162\171\160\x74\x20\155\x75\x73\x74\40\142\x65\x20\156\165\154\154\40\157\x72\40\141\x20\x62\x69\156\x61\x72\171\x20\163\164\162\x69\156\147\x2e");
        Assertion::nullOrString($wi, "\124\x68\145\40\x41\x64\144\x69\164\x69\157\156\141\x6c\x20\101\165\x74\150\x65\156\x74\151\143\141\164\x69\x6f\156\40\104\x61\x74\x61\40\x6d\165\163\164\40\142\145\40\156\x75\154\x6c\40\157\162\40\141\40\x62\151\156\x61\162\171\40\x73\x74\x72\151\x6e\x67\56");
        Assertion::integer($cu, "\x49\156\x76\x61\154\x69\144\x20\164\141\147\x20\154\x65\x6e\147\164\x68\x2e\40\123\x75\160\x70\157\x72\164\x65\x64\x20\166\x61\x6c\x75\145\163\x20\141\x72\145\72\x20\x31\x32\70\x2c\40\61\62\x30\54\40\61\61\x32\x2c\40\x31\60\64\x20\141\x6e\x64\40\x39\x36\56");
        Assertion::inArray($cu, array(128, 120, 112, 104, 96), "\111\x6e\166\x61\154\151\x64\40\164\141\x67\40\x6c\x65\x6e\x67\x74\150\56\40\123\x75\160\x70\x6f\162\164\145\144\40\166\x61\x6c\x75\145\163\x20\141\162\x65\x3a\x20\x31\62\70\x2c\x20\x31\x32\x30\54\x20\61\61\x32\54\40\x31\x30\x34\40\141\156\144\x20\x39\66\56");
        if (version_compare(PHP_VERSION, "\x37\x2e\61\x2e\60\x52\103\65") >= 0 && null !== $dV) {
            goto EJd;
        }
        if (class_exists("\134\103\x72\x79\x70\x74\x6f\x5c\x43\x69\160\150\145\x72")) {
            goto rR1;
        }
        goto ctj;
        EJd:
        return self::encryptWithPHP71($bP, $iM, $Ie, $dV, $wi, $cu);
        goto ctj;
        rR1:
        return self::encryptWithCryptoExtension($bP, $iM, $Ie, $dV, $wi, $cu);
        ctj:
        return self::encryptWithPHP($bP, $iM, $Ie, $dV, $wi, $cu);
    }
    public static function encryptAndAppendTag($bP, $Ie, $dV = null, $wi = null, $cu = 128)
    {
        return implode(self::encrypt($bP, $Ie, $dV, $wi, $cu));
    }
    private static function encryptWithPHP71($bP, $iM, $Ie, $dV = null, $wi = null, $cu = 128)
    {
        $Pr = "\141\145\163\55" . $iM . "\55\x67\x63\155";
        $Kr = null;
        $t5 = openssl_encrypt($dV, $Pr, $bP, OPENSSL_RAW_DATA, $Ie, $Kr, $wi, $cu / 8);
        Assertion::true(false !== $t5, "\125\156\x61\142\154\x65\40\x74\x6f\x20\x65\x6e\x63\162\x79\x70\164\40\164\150\x65\40\x64\141\x74\141\56");
        return array($t5, $Kr);
    }
    private static function encryptWithPHP($bP, $iM, $Ie, $dV = null, $wi = null, $cu = 128)
    {
        list($n8, $LN, $Rq, $gd) = self::common($bP, $iM, $Ie, $wi);
        $t5 = self::getGCTR($bP, $iM, self::getInc(32, $n8), $dV);
        $pJ = self::calcVector($t5);
        $LJ = self::addPadding($t5);
        $je = self::getHash($gd, $wi . str_pad('', $LN / 8, "\0") . $t5 . str_pad('', $pJ / 8, "\x0") . $Rq . $LJ);
        $Kr = self::getMSB($cu, self::getGCTR($bP, $iM, $n8, $je));
        return array($t5, $Kr);
    }
    private static function encryptWithCryptoExtension($bP, $iM, $Ie, $dV = null, $wi = null, $cu = 128)
    {
        $ib = \Crypto\Cipher::aes(\Crypto\Cipher::MODE_GCM, $iM);
        $ib->setAAD($wi);
        $ib->setTagLength($cu / 8);
        $t5 = $ib->encrypt($dV, $bP, $Ie);
        $Kr = $ib->getTag();
        return array($t5, $Kr);
    }
    public static function decrypt($bP, $Ie, $t5, $wi, $Kr)
    {
        Assertion::string($bP, "\x54\150\x65\40\153\x65\x79\40\145\x6e\x63\x72\171\x70\164\x69\157\x6e\x20\x6b\145\x79\x20\x6d\165\x73\164\x20\142\145\40\x61\x20\x62\x69\156\141\x72\171\x20\x73\164\x72\151\x6e\x67\56");
        $iM = mb_strlen($bP, "\x38\x62\151\164") * 8;
        Assertion::inArray($iM, array(128, 192, 256), "\x42\141\144\x20\x6b\145\x79\40\x65\156\143\x72\x79\160\x74\x69\x6f\156\x20\153\145\x79\x20\x6c\145\156\x67\164\x68\x2e");
        Assertion::string($Ie, "\124\x68\145\x20\x49\156\151\x74\x69\141\154\151\x7a\x61\x74\151\x6f\x6e\x20\126\x65\x63\x74\x6f\162\40\x6d\x75\x73\164\x20\x62\145\x20\x61\40\x62\151\x6e\x61\x72\171\40\x73\164\x72\x69\x6e\x67\56");
        Assertion::nullOrString($t5, "\x54\x68\145\40\144\141\x74\141\40\x74\x6f\x20\145\x6e\x63\x72\x79\160\164\40\x6d\165\x73\x74\x20\x62\145\x20\x6e\x75\x6c\x6c\40\x6f\x72\40\x61\x20\142\151\x6e\141\162\171\x20\163\x74\162\x69\x6e\147\56");
        Assertion::nullOrString($wi, "\124\150\145\x20\x41\144\x64\x69\x74\151\x6f\x6e\141\x6c\40\x41\x75\164\150\x65\156\x74\x69\143\141\x74\151\x6f\x6e\x20\x44\141\x74\141\x20\x6d\x75\x73\x74\x20\x62\x65\40\156\x75\x6c\x6c\40\x6f\162\40\x61\x20\x62\x69\156\x61\162\171\40\163\164\162\x69\x6e\147\x2e");
        $cu = self::getLength($Kr);
        Assertion::integer($cu, "\111\156\x76\x61\154\x69\144\x20\x74\x61\x67\40\x6c\145\156\x67\x74\150\56\x20\x53\165\160\160\157\x72\x74\x65\144\x20\166\141\154\x75\145\163\40\x61\162\x65\72\x20\x31\62\x38\x2c\x20\x31\62\x30\54\40\61\61\62\54\40\x31\x30\x34\40\141\x6e\x64\40\x39\x36\56");
        Assertion::inArray($cu, array(128, 120, 112, 104, 96), "\111\x6e\x76\141\154\x69\144\40\164\x61\147\x20\154\x65\156\147\x74\x68\x2e\x20\123\x75\160\x70\x6f\162\164\145\x64\40\166\141\x6c\x75\x65\x73\40\141\x72\x65\x3a\x20\x31\62\70\54\40\61\x32\x30\x2c\40\x31\61\62\54\x20\61\x30\x34\x20\x61\156\144\40\x39\x36\x2e");
        if (version_compare(PHP_VERSION, "\x37\56\61\56\60\x52\x43\65") >= 0 && null !== $t5) {
            goto YFw;
        }
        if (class_exists("\x5c\x43\x72\171\x70\x74\157\x5c\x43\151\x70\x68\x65\162")) {
            goto L3M;
        }
        goto TUO;
        YFw:
        return self::decryptWithPHP71($bP, $iM, $Ie, $t5, $wi, $Kr);
        goto TUO;
        L3M:
        return self::decryptWithCryptoExtension($bP, $iM, $Ie, $t5, $wi, $Kr, $cu);
        TUO:
        return self::decryptWithPHP($bP, $iM, $Ie, $t5, $wi, $Kr, $cu);
    }
    public static function decryptWithAppendedTag($bP, $Ie, $lc = null, $wi = null, $cu = 128)
    {
        $i_ = $cu / 8;
        $t5 = mb_substr($lc, 0, -$i_, "\70\x62\x69\164");
        $Kr = mb_substr($lc, -$i_, null, "\x38\x62\x69\164");
        return self::decrypt($bP, $Ie, $t5, $wi, $Kr);
    }
    private static function decryptWithPHP71($bP, $iM, $Ie, $t5, $wi, $Kr)
    {
        $Pr = "\x61\x65\163\x2d" . $iM . "\55\x67\143\155";
        $dV = openssl_decrypt(null === $t5 ? '' : $t5, $Pr, $bP, OPENSSL_RAW_DATA, $Ie, $Kr, null === $wi ? '' : $wi);
        Assertion::true(false !== $dV, "\125\156\141\x62\x6c\145\40\164\157\x20\144\x65\143\x72\x79\160\x74\x20\x6f\x72\40\164\157\x20\166\145\162\x69\x66\x79\40\164\150\x65\40\164\x61\147\56");
        return $dV;
    }
    private static function decryptWithPHP($bP, $iM, $Ie, $t5, $wi, $Kr, $cu = 128)
    {
        list($n8, $LN, $Rq, $gd) = self::common($bP, $iM, $Ie, $wi);
        $dV = self::getGCTR($bP, $iM, self::getInc(32, $n8), $t5);
        $pJ = self::calcVector($t5);
        $LJ = self::addPadding($t5);
        $je = self::getHash($gd, $wi . str_pad('', $LN / 8, "\0") . $t5 . str_pad('', $pJ / 8, "\x0") . $Rq . $LJ);
        $cT = self::getMSB($cu, self::getGCTR($bP, $iM, $n8, $je));
        Assertion::eq($cT, $Kr, "\x55\x6e\x61\142\x6c\145\40\164\157\x20\x64\x65\143\x72\x79\x70\164\40\157\x72\40\164\x6f\40\166\x65\x72\x69\x66\171\40\164\150\145\40\x74\141\x67\x2e");
        return $dV;
    }
    private static function decryptWithCryptoExtension($bP, $iM, $Ie, $t5, $wi, $Kr, $cu = 128)
    {
        $ib = \Crypto\Cipher::aes(\Crypto\Cipher::MODE_GCM, $iM);
        $ib->setTag($Kr);
        $ib->setAAD($wi);
        $ib->setTagLength($cu / 8);
        return $ib->decrypt($t5, $bP, $Ie);
    }
    private static function common($bP, $iM, $Ie, $wi)
    {
        $gd = openssl_encrypt(str_repeat("\0", 16), "\x61\x65\163\55" . $iM . "\55\145\143\142", $bP, OPENSSL_NO_PADDING | OPENSSL_RAW_DATA);
        $h1 = self::getLength($Ie);
        if (96 === $h1) {
            goto nc6;
        }
        $sx = self::calcVector($Ie);
        Assertion::eq(($sx + 64) % 8, 0, "\125\x6e\x61\142\x6c\x65\x20\164\157\40\x64\145\143\x72\x79\160\164\x20\157\162\x20\x74\x6f\40\166\145\162\151\x66\171\x20\164\150\145\x20\x74\141\x67\x2e");
        $ZF = pack("\x4e", $h1);
        $g1 = str_pad($ZF, 8, "\0", STR_PAD_LEFT);
        $NC = $Ie . str_pad('', ($sx + 64) / 8, "\x0") . $g1;
        $n8 = self::getHash($gd, $NC);
        goto KVo;
        nc6:
        $n8 = $Ie . pack("\110\x2a", "\x30\60\x30\60\60\60\x30\61");
        KVo:
        $LN = self::calcVector($wi);
        $Rq = self::addPadding($wi);
        return array($n8, $LN, $Rq, $gd);
    }
    private static function calcVector($g2)
    {
        return 128 * ceil(self::getLength($g2) / 128) - self::getLength($g2);
    }
    private static function addPadding($g2)
    {
        return str_pad(pack("\x4e", self::getLength($g2)), 8, "\x0", STR_PAD_LEFT);
    }
    private static function getLength($pI)
    {
        return mb_strlen($pI, "\70\142\151\164") * 8;
    }
    private static function getMSB($we, $pI)
    {
        $TW = $we / 8;
        return mb_substr($pI, 0, $TW, "\x38\x62\151\164");
    }
    private static function getLSB($we, $pI)
    {
        $TW = $we / 8;
        return mb_substr($pI, -$TW, null, "\x38\142\151\x74");
    }
    private static function getInc($WX, $pI)
    {
        $ZV = self::getLSB($WX, $pI);
        $h2 = self::toUInt32Bits($ZV) + 1;
        $ZK = self::getMSB(self::getLength($pI) - $WX, $pI) . pack("\116", $h2);
        return $ZK;
    }
    private static function toUInt32Bits($lC)
    {
        list(, $x7, $f3) = unpack("\156\52", $lC);
        return $f3 + $x7 * 65536;
    }
    private static function getProduct($h2, $IS)
    {
        $w7 = pack("\x48\x2a", "\x45\61") . str_pad('', 15, "\0");
        $CA = str_pad('', 16, "\0");
        $vt = $IS;
        $e1 = str_split($h2, 4);
        $pI = sprintf("\45\60\x33\62\x62\45\x30\x33\x32\142\45\60\x33\x32\142\45\60\63\62\x62", self::toUInt32Bits($e1[0]), self::toUInt32Bits($e1[1]), self::toUInt32Bits($e1[2]), self::toUInt32Bits($e1[3]));
        $PZ = "\1";
        $oM = 0;
        qvK:
        if (!($oM < 128)) {
            goto Fdv;
        }
        if (!$pI[$oM]) {
            goto ppx;
        }
        $CA = self::getBitXor($CA, $vt);
        ppx:
        $zS = mb_substr($vt, -1, null, "\x38\142\x69\x74");
        if (ord($zS & $PZ)) {
            goto lw9;
        }
        $vt = self::shiftStringToRight($vt);
        goto KWa;
        lw9:
        $vt = self::getBitXor(self::shiftStringToRight($vt), $w7);
        KWa:
        lXG:
        $oM++;
        goto qvK;
        Fdv:
        return $CA;
    }
    private static function shiftStringToRight($Br)
    {
        $QB = 4;
        $e1 = array_map("\x73\x65\154\x66\72\x3a\x74\157\x55\111\156\164\63\62\x42\x69\164\x73", str_split($Br, $QB));
        $rF = count($e1);
        $oM = $rF - 1;
        r9x:
        if (!($oM >= 0)) {
            goto anF;
        }
        if (!$oM) {
            goto NeT;
        }
        $o0 = $e1[$oM - 1] & 1;
        if (!$o0) {
            goto RgW;
        }
        $e1[$oM] = $e1[$oM] >> 1 | 2147483648;
        $e1[$oM] = pack("\116", $e1[$oM]);
        goto WJG;
        RgW:
        NeT:
        $e1[$oM] = $e1[$oM] >> 1 & 2147483647;
        $e1[$oM] = pack("\116", $e1[$oM]);
        WJG:
        $oM--;
        goto r9x;
        anF:
        $ZK = implode('', $e1);
        return $ZK;
    }
    private static function getHash($gd, $h2)
    {
        $IS = array();
        $IS[0] = str_pad('', 16, "\0");
        $Gr = (int) (mb_strlen($h2, "\70\142\151\164") / 16);
        $oM = 1;
        X0S:
        if (!($oM <= $Gr)) {
            goto oEd;
        }
        $IS[$oM] = self::getProduct(self::getBitXor($IS[$oM - 1], mb_substr($h2, ($oM - 1) * 16, 16, "\70\x62\151\x74")), $gd);
        vVL:
        $oM++;
        goto X0S;
        oEd:
        return $IS[$Gr];
    }
    private static function getGCTR($bP, $iM, $sX, $h2)
    {
        if (!empty($h2)) {
            goto KLv;
        }
        return '';
        KLv:
        $tK = (int) ceil(self::getLength($h2) / 128);
        $lp = array();
        $IS = array();
        $lp[1] = $sX;
        $oM = 2;
        uhv:
        if (!($oM <= $tK)) {
            goto pTz;
        }
        $lp[$oM] = self::getInc(32, $lp[$oM - 1]);
        C25:
        $oM++;
        goto uhv;
        pTz:
        $Pr = "\x61\x65\x73\x2d" . $iM . "\x2d\145\143\x62";
        $oM = 1;
        CxU:
        if (!($oM < $tK)) {
            goto trs;
        }
        $t5 = openssl_encrypt($lp[$oM], $Pr, $bP, OPENSSL_NO_PADDING | OPENSSL_RAW_DATA);
        $IS[$oM] = self::getBitXor(mb_substr($h2, ($oM - 1) * 16, 16, "\70\142\x69\x74"), $t5);
        qz2:
        $oM++;
        goto CxU;
        trs:
        $mU = mb_substr($h2, ($tK - 1) * 16, null, "\70\142\x69\x74");
        $t5 = openssl_encrypt($lp[$tK], $Pr, $bP, OPENSSL_NO_PADDING | OPENSSL_RAW_DATA);
        $IS[$tK] = self::getBitXor($mU, self::getMSB(self::getLength($mU), $t5));
        return implode('', $IS);
    }
    private static function getBitXor($UN, $Yn)
    {
        $a0 = PHP_INT_SIZE;
        $UN = str_split($UN, $a0);
        $Yn = str_split($Yn, $a0);
        $ZK = '';
        $rF = count($UN);
        $oM = 0;
        d0d:
        if (!($oM < $rF)) {
            goto Zat;
        }
        $ZK .= $UN[$oM] ^ $Yn[$oM];
        aNG:
        $oM++;
        goto d0d;
        Zat:
        return $ZK;
    }
}
