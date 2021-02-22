<?php


namespace RobRichards\XMLSecLibs;

require_once "\x47\x43\115\114\x69\x62" . DIRECTORY_SEPARATOR . "\101\x45\123\107\x43\x4d\x2e\x70\x68\160";
use AESGCM\AESGCM;
use DOMElement;
use Exception;
class XMLSecurityKey
{
    const TRIPLEDES_CBC = "\150\x74\164\160\x3a\57\57\x77\167\167\56\x77\63\x2e\157\162\147\57\x32\60\x30\x31\x2f\x30\x34\x2f\x78\155\154\x65\156\143\43\x74\162\x69\x70\x6c\x65\144\145\x73\x2d\143\142\143";
    const AES128_CBC = "\x68\x74\164\160\x3a\57\x2f\x77\167\167\56\167\63\56\157\x72\x67\x2f\62\x30\x30\61\x2f\60\64\x2f\170\155\x6c\145\x6e\143\43\141\x65\163\61\62\70\55\143\142\x63";
    const AES192_CBC = "\150\x74\x74\x70\x3a\57\x2f\167\x77\x77\x2e\x77\x33\x2e\x6f\162\x67\x2f\x32\x30\x30\61\x2f\x30\64\x2f\x78\155\x6c\145\156\143\x23\141\x65\x73\61\x39\62\55\x63\x62\x63";
    const AES256_CBC = "\150\x74\164\160\x3a\57\57\x77\167\x77\56\167\63\x2e\157\x72\147\57\x32\60\x30\x31\57\x30\x34\x2f\170\155\154\x65\156\143\43\141\x65\x73\62\65\x36\55\x63\142\x63";
    const RSA_1_5 = "\x68\x74\x74\x70\72\57\x2f\167\167\167\56\167\63\56\x6f\162\x67\x2f\x32\x30\60\x31\57\x30\64\x2f\170\155\154\145\x6e\x63\43\162\163\141\55\61\137\x35";
    const RSA_OAEP_MGF1P = "\150\x74\164\160\x3a\x2f\57\x77\x77\167\x2e\x77\x33\56\x6f\x72\147\57\62\x30\x30\x31\57\60\x34\57\x78\155\154\x65\x6e\x63\x23\x72\x73\141\x2d\157\x61\145\x70\x2d\155\x67\146\61\160";
    const DSA_SHA1 = "\150\164\164\x70\x3a\x2f\57\167\x77\x77\x2e\x77\63\x2e\157\x72\x67\57\x32\x30\x30\60\x2f\x30\x39\x2f\x78\x6d\x6c\144\163\151\x67\43\144\163\x61\55\163\150\141\61";
    const RSA_SHA1 = "\x68\x74\x74\160\72\x2f\57\167\x77\x77\x2e\167\63\x2e\157\162\x67\57\x32\60\x30\x30\x2f\x30\x39\57\x78\x6d\154\144\163\151\147\x23\x72\163\141\55\163\x68\x61\x31";
    const RSA_SHA256 = "\150\x74\164\160\72\x2f\x2f\x77\x77\167\56\167\x33\x2e\157\162\147\57\62\60\x30\x31\x2f\60\x34\x2f\170\x6d\154\x64\x73\151\x67\x2d\x6d\x6f\162\145\x23\x72\163\x61\x2d\x73\x68\x61\x32\65\66";
    const RSA_SHA384 = "\150\164\x74\160\x3a\x2f\x2f\x77\167\x77\56\167\x33\56\157\x72\x67\57\x32\60\60\61\x2f\60\64\x2f\170\155\x6c\x64\x73\x69\147\55\155\157\x72\x65\43\162\163\141\x2d\x73\x68\141\x33\x38\x34";
    const RSA_SHA512 = "\x68\164\164\x70\x3a\x2f\57\167\x77\167\56\x77\x33\x2e\x6f\x72\147\57\x32\60\60\61\x2f\60\x34\x2f\x78\x6d\x6c\x64\x73\x69\147\55\x6d\157\162\x65\43\x72\x73\141\55\163\150\141\65\x31\62";
    const HMAC_SHA1 = "\150\x74\x74\x70\72\57\x2f\167\167\167\x2e\x77\63\56\157\x72\x67\x2f\62\60\x30\60\x2f\60\71\57\170\155\154\144\x73\x69\x67\43\x68\x6d\141\143\x2d\x73\x68\141\x31";
    const AES128_GMC = "\x68\164\164\x70\72\57\x2f\x77\x77\x77\x2e\167\63\56\x6f\162\x67\57\x32\x30\60\71\x2f\170\x6d\154\x65\x6e\x63\x31\x31\43\x61\145\163\x31\62\70\x2d\x67\x63\x6d";
    private $cryptParams = array();
    public $type = 0;
    public $key = null;
    public $passphrase = '';
    public $iv = null;
    public $name = null;
    public $keyChain = null;
    public $isEncrypted = false;
    public $encryptedCtx = null;
    public $guid = null;
    private $x509Certificate = null;
    private $X509Thumbprint = null;
    public function __construct($u8, $vW = null)
    {
        switch ($u8) {
            case self::TRIPLEDES_CBC:
                $this->cryptParams["\154\x69\x62\x72\141\x72\171"] = "\157\160\x65\156\x73\x73\154";
                $this->cryptParams["\143\x69\160\x68\145\162"] = "\144\x65\163\x2d\x65\x64\x65\x33\x2d\143\142\143";
                $this->cryptParams["\x74\171\160\145"] = "\163\x79\x6d\155\145\164\162\151\143";
                $this->cryptParams["\x6d\145\x74\150\157\x64"] = "\x68\164\x74\x70\x3a\x2f\57\x77\x77\167\56\x77\x33\x2e\x6f\x72\147\x2f\62\x30\x30\61\57\x30\64\x2f\170\x6d\154\x65\x6e\143\x23\x74\x72\x69\160\154\x65\144\x65\x73\55\143\142\143";
                $this->cryptParams["\x6b\x65\171\x73\x69\x7a\x65"] = 24;
                $this->cryptParams["\142\154\x6f\x63\x6b\x73\x69\172\145"] = 8;
                goto Dl;
            case self::AES128_GMC:
                $this->cryptParams["\154\x69\142\162\141\162\171"] = "\157\160\x65\156\163\163\154";
                $this->cryptParams["\x63\x69\160\x68\x65\162"] = "\x61\145\163\55\x31\62\x38\55\x67\x63\x6d";
                $this->cryptParams["\164\171\x70\x65"] = "\x73\x79\155\x6d\x65\164\x72\x69\143";
                $this->cryptParams["\155\145\x74\150\157\144"] = "\150\x74\x74\160\72\57\x2f\x77\x77\x77\x2e\167\x33\x2e\157\x72\x67\x2f\62\x30\x30\71\57\x78\x6d\x6c\x65\156\143\61\61\43\141\x65\x73\61\62\x38\x2d\147\143\155";
                $this->cryptParams["\x6b\145\x79\x73\x69\172\145"] = 16;
                $this->cryptParams["\142\x6c\x6f\x63\153\x73\151\172\x65"] = 16;
                goto Dl;
            case self::AES128_CBC:
                $this->cryptParams["\154\151\142\x72\141\162\171"] = "\157\x70\145\x6e\x73\163\154";
                $this->cryptParams["\143\x69\x70\x68\145\162"] = "\141\145\163\55\x31\62\70\x2d\x63\x62\x63";
                $this->cryptParams["\164\x79\x70\145"] = "\x73\x79\155\x6d\x65\164\x72\x69\x63";
                $this->cryptParams["\x6d\145\164\150\x6f\x64"] = "\150\x74\x74\160\72\x2f\x2f\x77\167\167\56\x77\63\x2e\x6f\162\x67\57\x32\x30\60\x31\x2f\x30\64\x2f\170\155\x6c\x65\x6e\143\43\x61\x65\x73\61\62\x38\55\143\x62\x63";
                $this->cryptParams["\153\x65\171\163\151\x7a\x65"] = 16;
                $this->cryptParams["\142\x6c\157\x63\153\x73\x69\x7a\x65"] = 16;
                goto Dl;
            case self::AES192_CBC:
                $this->cryptParams["\x6c\151\x62\162\141\162\x79"] = "\157\160\x65\x6e\163\x73\154";
                $this->cryptParams["\x63\151\x70\x68\x65\x72"] = "\141\x65\x73\55\61\71\x32\x2d\143\142\143";
                $this->cryptParams["\164\171\160\145"] = "\163\171\x6d\x6d\145\164\162\x69\143";
                $this->cryptParams["\x6d\145\164\x68\157\x64"] = "\x68\164\x74\x70\x3a\x2f\x2f\167\167\x77\x2e\x77\x33\56\x6f\162\x67\57\x32\60\60\61\57\x30\64\x2f\x78\x6d\x6c\145\156\x63\x23\141\x65\163\x31\71\x32\x2d\143\142\143";
                $this->cryptParams["\153\x65\x79\x73\151\x7a\145"] = 24;
                $this->cryptParams["\142\x6c\157\x63\153\163\151\172\x65"] = 16;
                goto Dl;
            case self::AES256_CBC:
                $this->cryptParams["\154\151\x62\162\141\x72\x79"] = "\157\x70\145\x6e\x73\x73\x6c";
                $this->cryptParams["\143\151\160\150\145\x72"] = "\x61\145\x73\x2d\62\x35\x36\55\x63\x62\x63";
                $this->cryptParams["\164\x79\x70\145"] = "\163\171\x6d\x6d\145\x74\162\151\143";
                $this->cryptParams["\x6d\145\164\150\157\x64"] = "\x68\x74\x74\160\x3a\57\57\167\x77\x77\x2e\x77\63\56\157\162\147\x2f\x32\60\60\61\57\x30\64\57\170\x6d\x6c\145\x6e\x63\43\141\x65\163\62\x35\x36\x2d\143\142\x63";
                $this->cryptParams["\x6b\145\x79\163\x69\x7a\145"] = 32;
                $this->cryptParams["\142\154\157\143\x6b\x73\x69\172\145"] = 16;
                goto Dl;
            case self::RSA_1_5:
                $this->cryptParams["\154\x69\x62\162\x61\x72\171"] = "\x6f\x70\x65\x6e\163\163\154";
                $this->cryptParams["\x70\141\x64\144\151\156\147"] = OPENSSL_PKCS1_PADDING;
                $this->cryptParams["\155\x65\164\x68\x6f\x64"] = "\x68\164\164\160\x3a\x2f\57\167\x77\x77\56\167\63\x2e\157\162\x67\x2f\62\60\x30\61\57\60\64\57\170\155\x6c\x65\156\143\43\162\163\141\x2d\x31\x5f\x35";
                if (!(is_array($vW) && !empty($vW["\164\x79\x70\x65"]))) {
                    goto cJ;
                }
                if (!($vW["\164\171\160\x65"] == "\160\165\x62\154\x69\143" || $vW["\164\x79\x70\x65"] == "\160\x72\151\166\141\164\x65")) {
                    goto Bq;
                }
                $this->cryptParams["\x74\x79\160\145"] = $vW["\x74\171\160\145"];
                goto Dl;
                Bq:
                cJ:
                throw new Exception("\x43\145\162\164\151\146\151\x63\141\x74\145\40\42\x74\171\x70\x65\x22\x20\x28\160\162\151\x76\141\x74\x65\57\160\165\142\154\x69\x63\51\x20\155\165\163\164\x20\142\145\40\160\x61\163\x73\145\x64\x20\166\151\x61\40\160\x61\162\141\155\145\x74\145\x72\x73");
            case self::RSA_OAEP_MGF1P:
                $this->cryptParams["\154\x69\142\162\141\x72\171"] = "\157\160\145\x6e\163\163\x6c";
                $this->cryptParams["\160\x61\x64\144\151\x6e\147"] = OPENSSL_PKCS1_OAEP_PADDING;
                $this->cryptParams["\x6d\x65\164\150\x6f\144"] = "\150\164\x74\x70\72\x2f\x2f\167\167\x77\56\x77\x33\56\x6f\x72\x67\57\x32\60\x30\x31\x2f\x30\64\57\x78\155\154\x65\x6e\143\x23\x72\163\141\55\157\x61\145\160\55\x6d\147\146\x31\x70";
                $this->cryptParams["\x68\x61\163\x68"] = null;
                if (!(is_array($vW) && !empty($vW["\164\x79\160\x65"]))) {
                    goto Tp;
                }
                if (!($vW["\x74\171\x70\145"] == "\160\x75\142\154\151\143" || $vW["\164\x79\x70\x65"] == "\160\162\x69\166\141\164\145")) {
                    goto hZ;
                }
                $this->cryptParams["\x74\171\x70\145"] = $vW["\x74\x79\x70\145"];
                goto Dl;
                hZ:
                Tp:
                throw new Exception("\x43\145\162\164\151\146\151\x63\141\164\x65\40\42\x74\x79\160\145\42\x20\x28\160\162\151\x76\x61\164\145\x2f\160\x75\142\154\x69\x63\51\x20\x6d\x75\x73\164\40\142\x65\40\160\x61\163\x73\145\x64\40\x76\151\x61\x20\160\141\x72\x61\155\x65\164\145\162\163");
            case self::RSA_SHA1:
                $this->cryptParams["\154\151\x62\x72\x61\162\x79"] = "\x6f\x70\145\156\163\x73\x6c";
                $this->cryptParams["\x6d\145\x74\x68\157\x64"] = "\x68\164\x74\160\x3a\57\57\x77\x77\x77\56\167\x33\56\157\162\147\57\x32\60\60\60\x2f\60\x39\x2f\x78\155\x6c\x64\x73\x69\147\x23\x72\x73\x61\55\163\150\x61\x31";
                $this->cryptParams["\160\141\x64\144\151\156\x67"] = OPENSSL_PKCS1_PADDING;
                if (!(is_array($vW) && !empty($vW["\x74\171\160\145"]))) {
                    goto RY;
                }
                if (!($vW["\x74\x79\x70\x65"] == "\x70\165\142\x6c\151\143" || $vW["\164\x79\160\145"] == "\x70\162\151\166\141\164\x65")) {
                    goto mT;
                }
                $this->cryptParams["\164\x79\160\145"] = $vW["\164\171\x70\145"];
                goto Dl;
                mT:
                RY:
                throw new Exception("\x43\145\x72\x74\x69\146\x69\143\x61\x74\145\40\42\164\x79\x70\145\x22\40\50\160\162\x69\x76\x61\164\145\x2f\x70\165\142\x6c\151\x63\x29\x20\x6d\x75\x73\x74\x20\142\x65\40\x70\141\x73\163\x65\144\x20\x76\x69\141\x20\160\x61\x72\x61\155\145\164\x65\162\x73");
            case self::RSA_SHA256:
                $this->cryptParams["\x6c\151\x62\x72\x61\x72\171"] = "\157\160\x65\x6e\x73\163\x6c";
                $this->cryptParams["\x6d\x65\x74\150\157\x64"] = "\150\x74\x74\160\x3a\x2f\x2f\167\x77\x77\56\167\x33\x2e\x6f\162\x67\x2f\62\60\x30\61\x2f\x30\64\x2f\170\155\154\144\163\151\x67\x2d\155\157\x72\x65\x23\162\163\141\55\163\x68\141\62\65\66";
                $this->cryptParams["\x70\141\144\x64\x69\x6e\147"] = OPENSSL_PKCS1_PADDING;
                $this->cryptParams["\144\x69\x67\145\x73\164"] = "\123\x48\x41\x32\x35\x36";
                if (!(is_array($vW) && !empty($vW["\x74\x79\x70\x65"]))) {
                    goto fI;
                }
                if (!($vW["\x74\171\x70\x65"] == "\x70\x75\142\x6c\x69\143" || $vW["\164\x79\160\145"] == "\x70\162\151\166\141\164\x65")) {
                    goto FN1;
                }
                $this->cryptParams["\164\x79\160\145"] = $vW["\164\171\x70\145"];
                goto Dl;
                FN1:
                fI:
                throw new Exception("\103\145\162\x74\151\x66\x69\x63\141\x74\x65\x20\x22\164\x79\160\145\x22\40\x28\x70\x72\x69\166\x61\x74\x65\57\x70\165\142\x6c\x69\143\51\x20\x6d\165\163\164\40\142\145\x20\160\x61\163\x73\x65\144\40\x76\x69\x61\x20\160\x61\x72\x61\155\x65\164\145\162\x73");
            case self::RSA_SHA384:
                $this->cryptParams["\154\151\142\x72\x61\x72\x79"] = "\x6f\160\145\156\163\163\154";
                $this->cryptParams["\155\145\x74\x68\157\144"] = "\x68\164\x74\160\72\x2f\57\167\x77\x77\x2e\x77\63\x2e\157\x72\147\x2f\x32\x30\60\61\57\x30\64\57\x78\x6d\x6c\x64\163\x69\x67\55\x6d\x6f\162\145\x23\162\x73\141\55\163\x68\x61\63\x38\64";
                $this->cryptParams["\160\141\x64\144\151\156\147"] = OPENSSL_PKCS1_PADDING;
                $this->cryptParams["\144\151\147\x65\x73\x74"] = "\123\110\101\63\x38\64";
                if (!(is_array($vW) && !empty($vW["\164\x79\x70\145"]))) {
                    goto xC;
                }
                if (!($vW["\x74\171\160\145"] == "\160\165\142\154\x69\143" || $vW["\164\x79\x70\x65"] == "\160\x72\151\166\141\164\x65")) {
                    goto R9;
                }
                $this->cryptParams["\x74\x79\x70\145"] = $vW["\x74\171\160\145"];
                goto Dl;
                R9:
                xC:
                throw new Exception("\x43\145\162\164\151\146\151\143\141\x74\x65\40\42\164\x79\x70\x65\42\40\x28\x70\x72\x69\166\x61\164\145\57\160\x75\142\154\151\143\x29\40\x6d\x75\163\164\40\x62\145\x20\x70\x61\x73\163\x65\x64\x20\166\x69\x61\x20\160\141\162\141\155\145\164\x65\x72\163");
            case self::RSA_SHA512:
                $this->cryptParams["\x6c\x69\x62\x72\141\162\x79"] = "\157\160\x65\x6e\x73\x73\x6c";
                $this->cryptParams["\x6d\145\164\x68\x6f\144"] = "\x68\x74\x74\160\x3a\57\57\167\x77\x77\56\x77\x33\x2e\157\162\x67\x2f\x32\60\x30\x31\57\x30\64\x2f\x78\155\x6c\144\x73\x69\147\x2d\155\157\162\145\x23\x72\x73\x61\x2d\x73\x68\141\x35\x31\x32";
                $this->cryptParams["\160\141\144\144\151\x6e\x67"] = OPENSSL_PKCS1_PADDING;
                $this->cryptParams["\x64\151\x67\145\x73\164"] = "\x53\110\x41\x35\x31\x32";
                if (!(is_array($vW) && !empty($vW["\164\x79\160\145"]))) {
                    goto xw;
                }
                if (!($vW["\164\171\160\x65"] == "\160\165\x62\x6c\x69\143" || $vW["\164\x79\160\145"] == "\160\x72\151\166\141\164\145")) {
                    goto lA;
                }
                $this->cryptParams["\164\x79\x70\x65"] = $vW["\x74\x79\160\x65"];
                goto Dl;
                lA:
                xw:
                throw new Exception("\x43\x65\162\x74\x69\146\151\x63\141\164\x65\40\42\x74\171\x70\x65\42\40\x28\x70\162\151\166\x61\x74\x65\x2f\160\x75\x62\x6c\151\143\x29\x20\155\165\x73\x74\40\142\145\x20\160\x61\163\163\x65\144\40\166\x69\141\x20\x70\141\x72\141\155\145\x74\145\x72\x73");
            case self::HMAC_SHA1:
                $this->cryptParams["\x6c\x69\142\x72\141\x72\171"] = $u8;
                $this->cryptParams["\x6d\x65\x74\150\x6f\144"] = "\150\x74\x74\x70\72\x2f\57\x77\x77\x77\56\167\63\56\157\162\x67\57\62\x30\x30\60\57\x30\x39\57\170\x6d\154\144\163\151\x67\x23\x68\155\x61\x63\55\163\150\141\61";
                goto Dl;
            default:
                throw new Exception("\x49\x6e\x76\x61\x6c\151\x64\x20\x4b\145\x79\x20\x54\x79\160\x65");
        }
        NS:
        Dl:
        $this->type = $u8;
    }
    public function getSymmetricKeySize()
    {
        if (isset($this->cryptParams["\153\x65\x79\163\x69\172\145"])) {
            goto qU;
        }
        return null;
        qU:
        return $this->cryptParams["\x6b\x65\171\163\151\172\145"];
    }
    public function generateSessionKey()
    {
        if (isset($this->cryptParams["\x6b\x65\x79\163\x69\x7a\x65"])) {
            goto Fm;
        }
        throw new Exception("\125\156\153\x6e\157\x77\x6e\x20\x6b\x65\171\x20\x73\151\x7a\x65\x20\146\x6f\x72\x20\x74\x79\160\x65\x20\42" . $this->type . "\x22\56");
        Fm:
        $cU = $this->cryptParams["\153\x65\x79\x73\x69\x7a\x65"];
        $uZ = openssl_random_pseudo_bytes($cU);
        if (!($this->type === self::TRIPLEDES_CBC)) {
            goto pM;
        }
        $LH = 0;
        mf:
        if (!($LH < strlen($uZ))) {
            goto UC;
        }
        $Fu = ord($uZ[$LH]) & 254;
        $Ee = 1;
        $NC = 1;
        bs:
        if (!($NC < 8)) {
            goto Ir;
        }
        $Ee ^= $Fu >> $NC & 1;
        X0:
        $NC++;
        goto bs;
        Ir:
        $Fu |= $Ee;
        $uZ[$LH] = chr($Fu);
        ZG:
        $LH++;
        goto mf;
        UC:
        pM:
        $this->key = $uZ;
        return $uZ;
    }
    public static function getRawThumbprint($eV)
    {
        $u3 = explode("\xa", $eV);
        $uY = '';
        $Iu = false;
        foreach ($u3 as $Jn) {
            if (!$Iu) {
                goto Bd;
            }
            if (!(strncmp($Jn, "\x2d\x2d\55\55\55\105\x4e\104\40\x43\x45\x52\124\x49\106\x49\103\101\124\x45", 20) == 0)) {
                goto IA;
            }
            goto qw;
            IA:
            $uY .= trim($Jn);
            goto cw;
            Bd:
            if (!(strncmp($Jn, "\55\x2d\x2d\x2d\55\102\x45\x47\x49\x4e\40\103\x45\x52\124\111\106\111\103\101\124\x45", 22) == 0)) {
                goto Je;
            }
            $Iu = true;
            Je:
            cw:
            uG:
        }
        qw:
        if (empty($uY)) {
            goto Ko;
        }
        return strtolower(sha1(base64_decode($uY)));
        Ko:
        return null;
    }
    public function loadKey($uZ, $mt = false, $oF = false)
    {
        if ($mt) {
            goto KR;
        }
        $this->key = $uZ;
        goto z_;
        KR:
        $this->key = file_get_contents($uZ);
        z_:
        if ($oF) {
            goto N5;
        }
        $this->x509Certificate = null;
        goto Z0;
        N5:
        $this->key = openssl_x509_read($this->key);
        openssl_x509_export($this->key, $tw);
        $this->x509Certificate = $tw;
        $this->key = $tw;
        Z0:
        if (!($this->cryptParams["\x6c\151\142\162\141\162\171"] == "\x6f\160\x65\x6e\163\163\x6c")) {
            goto x2;
        }
        switch ($this->cryptParams["\164\171\x70\x65"]) {
            case "\160\x75\x62\x6c\x69\x63":
                if (!$oF) {
                    goto xp;
                }
                $this->X509Thumbprint = self::getRawThumbprint($this->key);
                xp:
                $this->key = openssl_get_publickey($this->key);
                if ($this->key) {
                    goto FV;
                }
                throw new Exception("\125\x6e\x61\x62\154\x65\x20\x74\x6f\x20\x65\170\164\x72\141\x63\164\40\160\165\x62\154\x69\143\40\153\x65\171");
                FV:
                goto yO;
            case "\160\162\151\x76\x61\x74\145":
                $this->key = openssl_get_privatekey($this->key, $this->passphrase);
                goto yO;
            case "\163\x79\x6d\155\x65\x74\x72\151\143":
                if (!(strlen($this->key) < $this->cryptParams["\x6b\x65\x79\163\151\x7a\145"])) {
                    goto jV;
                }
                throw new Exception("\x4b\x65\171\x20\x6d\x75\x73\x74\40\x63\157\x6e\x74\141\151\x6e\x20\141\x74\x20\154\145\141\x73\164\x20\62\x35\x20\143\x68\x61\162\x61\143\x74\x65\162\163\40\x66\157\162\x20\x74\150\x69\163\x20\x63\x69\x70\150\145\162");
                jV:
                goto yO;
            default:
                throw new Exception("\x55\x6e\x6b\x6e\x6f\167\x6e\40\164\x79\x70\x65");
        }
        et:
        yO:
        x2:
    }
    private function padISO10126($uY, $WT)
    {
        if (!($WT > 256)) {
            goto bt;
        }
        throw new Exception("\102\x6c\157\x63\x6b\x20\x73\x69\x7a\x65\x20\150\151\147\150\x65\162\x20\x74\150\x61\x6e\x20\62\x35\x36\x20\156\157\164\x20\x61\154\x6c\x6f\167\x65\144");
        bt:
        $h8 = $WT - strlen($uY) % $WT;
        $b5 = chr($h8);
        return $uY . str_repeat($b5, $h8);
    }
    private function unpadISO10126($uY)
    {
        $h8 = substr($uY, -1);
        $x9 = ord($h8);
        return substr($uY, 0, -$x9);
    }
    private function encryptSymmetric($uY)
    {
        $this->iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->cryptParams["\143\151\x70\x68\145\x72"]));
        $uY = $this->padISO10126($uY, $this->cryptParams["\142\x6c\157\143\x6b\163\x69\172\x65"]);
        $HH = openssl_encrypt($uY, $this->cryptParams["\x63\151\x70\150\145\x72"], $this->key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $this->iv);
        if (!(false === $HH)) {
            goto f5;
        }
        throw new Exception("\106\141\x69\154\165\162\x65\40\145\x6e\x63\x72\x79\160\x74\151\x6e\x67\40\x44\x61\164\x61\40\50\157\x70\x65\x6e\x73\x73\x6c\x20\x73\171\155\x6d\145\164\x72\x69\143\x29\40\x2d\x20" . openssl_error_string());
        f5:
        return $this->iv . $HH;
    }
    private function decryptSymmetric($uY)
    {
        if (!($this->cryptParams["\x63\x69\160\x68\145\x72"] === "\x61\x65\x73\55\61\62\x38\x2d\x67\x63\x6d")) {
            goto Lk;
        }
        return $this->decryptSymmetricAESGCM($uY);
        Lk:
        $fv = openssl_cipher_iv_length($this->cryptParams["\x63\x69\160\150\x65\x72"]);
        $this->iv = substr($uY, 0, $fv);
        $uY = substr($uY, $fv);
        $nr = openssl_decrypt($uY, $this->cryptParams["\143\x69\160\150\145\x72"], $this->key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $this->iv);
        if (!(false === $nr)) {
            goto Zh;
        }
        throw new Exception("\106\141\151\x6c\x75\x72\x65\x20\x64\145\143\162\x79\x70\x74\151\x6e\x67\40\104\141\x74\x61\x20\x28\x6f\160\145\156\x73\x73\154\x20\163\171\155\x6d\x65\x74\162\151\143\x29\40\55\40" . openssl_error_string());
        Zh:
        return $this->unpadISO10126($nr);
    }
    private function decryptSymmetricAESGCM($uY)
    {
        $fv = openssl_cipher_iv_length($this->cryptParams["\143\151\x70\x68\x65\162"]);
        $this->iv = substr($uY, 0, $fv);
        $uY = substr($uY, $fv);
        $nr = AESGCM::decryptWithAppendedTag($this->key, $this->iv, $uY, null, 128);
        if (!(false === $nr)) {
            goto gl;
        }
        throw new Exception("\106\141\x69\x6c\165\x72\145\x20\x64\145\x63\162\x79\x70\x74\x69\156\x67\40\104\x61\x74\141\40\50\157\x70\x65\x6e\163\x73\154\x20\163\171\155\155\145\x74\x72\151\143\x29\x20\55\40" . openssl_error_string());
        gl:
        return $nr;
    }
    private function encryptPublic($uY)
    {
        if (openssl_public_encrypt($uY, $HH, $this->key, $this->cryptParams["\x70\x61\144\x64\x69\156\147"])) {
            goto N7;
        }
        throw new Exception("\106\141\151\154\x75\162\145\x20\145\x6e\143\x72\x79\x70\164\151\x6e\147\40\104\141\x74\x61\40\x28\x6f\160\x65\x6e\163\x73\154\x20\x70\x75\142\154\151\143\51\40\55\x20" . openssl_error_string());
        N7:
        return $HH;
    }
    private function decryptPublic($uY)
    {
        if (openssl_public_decrypt($uY, $nr, $this->key, $this->cryptParams["\x70\141\x64\x64\x69\156\147"])) {
            goto jC;
        }
        throw new Exception("\x46\x61\x69\x6c\165\x72\x65\40\144\145\143\x72\171\x70\164\x69\156\147\40\x44\141\x74\141\40\50\157\x70\145\x6e\163\163\154\40\x70\x75\142\x6c\x69\143\51\40\55\40" . openssl_error_string());
        jC:
        return $nr;
    }
    private function encryptPrivate($uY)
    {
        if (openssl_private_encrypt($uY, $HH, $this->key, $this->cryptParams["\160\x61\144\x64\151\x6e\x67"])) {
            goto sv;
        }
        throw new Exception("\106\141\x69\x6c\x75\x72\x65\40\145\x6e\143\x72\x79\x70\164\151\156\147\x20\x44\141\x74\141\x20\x28\x6f\160\x65\156\163\163\154\x20\x70\x72\151\x76\x61\x74\145\51\x20\x2d\x20" . openssl_error_string());
        sv:
        return $HH;
    }
    private function decryptPrivate($uY)
    {
        if (openssl_private_decrypt($uY, $nr, $this->key, $this->cryptParams["\160\x61\144\144\151\x6e\x67"])) {
            goto Fi;
        }
        throw new Exception("\106\141\151\x6c\x75\x72\145\x20\144\x65\x63\162\171\x70\x74\x69\x6e\147\x20\x44\x61\164\141\x20\x28\x6f\160\145\x6e\x73\163\x6c\40\x70\x72\x69\166\x61\x74\145\51\x20\55\x20" . openssl_error_string());
        Fi:
        return $nr;
    }
    private function signOpenSSL($uY)
    {
        $YE = OPENSSL_ALGO_SHA1;
        if (empty($this->cryptParams["\x64\151\x67\x65\163\x74"])) {
            goto rG;
        }
        $YE = $this->cryptParams["\144\x69\147\x65\163\x74"];
        rG:
        if (openssl_sign($uY, $dZ, $this->key, $YE)) {
            goto ko;
        }
        throw new Exception("\x46\x61\151\154\165\x72\145\40\x53\x69\x67\x6e\x69\x6e\x67\40\104\141\164\x61\72\40" . openssl_error_string() . "\x20\x2d\40" . $YE);
        ko:
        return $dZ;
    }
    private function verifyOpenSSL($uY, $dZ)
    {
        $YE = OPENSSL_ALGO_SHA1;
        if (empty($this->cryptParams["\x64\x69\147\145\163\164"])) {
            goto E3;
        }
        $YE = $this->cryptParams["\144\x69\x67\145\x73\164"];
        E3:
        return openssl_verify($uY, $dZ, $this->key, $YE);
    }
    public function encryptData($uY)
    {
        if (!($this->cryptParams["\x6c\x69\142\162\x61\x72\x79"] === "\157\160\145\x6e\x73\163\x6c")) {
            goto rN;
        }
        switch ($this->cryptParams["\164\171\160\145"]) {
            case "\163\171\155\155\145\x74\x72\151\143":
                return $this->encryptSymmetric($uY);
            case "\160\x75\142\x6c\151\x63":
                return $this->encryptPublic($uY);
            case "\160\162\x69\166\x61\x74\x65":
                return $this->encryptPrivate($uY);
        }
        rt:
        sm:
        rN:
    }
    public function decryptData($uY)
    {
        if (!($this->cryptParams["\x6c\151\142\x72\x61\162\171"] === "\157\x70\145\x6e\163\163\x6c")) {
            goto cg;
        }
        switch ($this->cryptParams["\x74\x79\160\x65"]) {
            case "\163\171\155\x6d\145\x74\162\x69\x63":
                return $this->decryptSymmetric($uY);
            case "\x70\165\x62\154\151\143":
                return $this->decryptPublic($uY);
            case "\160\x72\x69\x76\x61\x74\x65":
                return $this->decryptPrivate($uY);
        }
        Es:
        I6:
        cg:
    }
    public function signData($uY)
    {
        switch ($this->cryptParams["\154\151\x62\162\x61\x72\171"]) {
            case "\157\160\145\x6e\x73\x73\154":
                return $this->signOpenSSL($uY);
            case self::HMAC_SHA1:
                return hash_hmac("\163\x68\x61\x31", $uY, $this->key, true);
        }
        vJ:
        o0:
    }
    public function verifySignature($uY, $dZ)
    {
        switch ($this->cryptParams["\154\151\142\x72\141\162\171"]) {
            case "\x6f\160\x65\x6e\x73\163\x6c":
                return $this->verifyOpenSSL($uY, $dZ);
            case self::HMAC_SHA1:
                $ii = hash_hmac("\x73\150\x61\61", $uY, $this->key, true);
                return strcmp($dZ, $ii) == 0;
        }
        vm:
        VH:
    }
    public function getAlgorith()
    {
        return $this->getAlgorithm();
    }
    public function getAlgorithm()
    {
        return $this->cryptParams["\155\x65\x74\x68\x6f\144"];
    }
    public static function makeAsnSegment($u8, $u2)
    {
        switch ($u8) {
            case 2:
                if (!(ord($u2) > 127)) {
                    goto Xs;
                }
                $u2 = chr(0) . $u2;
                Xs:
                goto Gq;
            case 3:
                $u2 = chr(0) . $u2;
                goto Gq;
        }
        nv:
        Gq:
        $bK = strlen($u2);
        if ($bK < 128) {
            goto xn;
        }
        if ($bK < 256) {
            goto eS;
        }
        if ($bK < 65536) {
            goto TO;
        }
        $tH = null;
        goto fb;
        TO:
        $tH = sprintf("\45\x63\x25\x63\x25\x63\45\143\x25\163", $u8, 130, $bK / 256, $bK % 256, $u2);
        fb:
        goto hF;
        eS:
        $tH = sprintf("\45\143\45\x63\45\x63\45\x73", $u8, 129, $bK, $u2);
        hF:
        goto jN;
        xn:
        $tH = sprintf("\45\x63\x25\143\45\163", $u8, $bK, $u2);
        jN:
        return $tH;
    }
    public static function convertRSA($tP, $Vy)
    {
        $j_ = self::makeAsnSegment(2, $Vy);
        $Xv = self::makeAsnSegment(2, $tP);
        $E2 = self::makeAsnSegment(48, $Xv . $j_);
        $ev = self::makeAsnSegment(3, $E2);
        $mF = pack("\x48\52", "\x33\x30\60\x44\x30\66\x30\x39\62\101\x38\x36\64\x38\x38\66\x46\67\x30\x44\x30\x31\x30\x31\x30\61\60\65\x30\60");
        $Nj = self::makeAsnSegment(48, $mF . $ev);
        $pK = base64_encode($Nj);
        $ZU = "\x2d\x2d\x2d\55\55\102\x45\107\x49\x4e\x20\120\x55\x42\x4c\x49\x43\x20\113\x45\x59\55\55\55\x2d\55\xa";
        $Vf = 0;
        zJ:
        if (!($wS = substr($pK, $Vf, 64))) {
            goto kU;
        }
        $ZU = $ZU . $wS . "\xa";
        $Vf += 64;
        goto zJ;
        kU:
        return $ZU . "\x2d\55\55\x2d\55\105\116\x44\x20\x50\x55\102\114\111\x43\x20\x4b\x45\x59\55\55\x2d\x2d\x2d\12";
    }
    public function serializeKey($n5)
    {
    }
    public function getX509Certificate()
    {
        return $this->x509Certificate;
    }
    public function getX509Thumbprint()
    {
        return $this->X509Thumbprint;
    }
    public static function fromEncryptedKeyElement(DOMElement $j2)
    {
        $DP = new XMLSecEnc();
        $DP->setNode($j2);
        if ($JP = $DP->locateKey()) {
            goto aX;
        }
        throw new Exception("\x55\156\141\x62\x6c\145\40\164\x6f\x20\x6c\157\x63\141\x74\145\40\x61\x6c\147\x6f\x72\x69\164\150\155\40\x66\x6f\x72\x20\x74\150\151\163\40\x45\156\143\x72\x79\x70\164\x65\144\x20\113\145\x79");
        aX:
        $JP->isEncrypted = true;
        $JP->encryptedCtx = $DP;
        XMLSecEnc::staticLocateKeyInfo($JP, $j2);
        return $JP;
    }
}
