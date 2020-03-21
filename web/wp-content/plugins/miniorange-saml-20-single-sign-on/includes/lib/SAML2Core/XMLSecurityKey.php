<?php


namespace RobRichards\XMLSecLibs;

require_once "\x47\103\x4d\114\x69\142" . DIRECTORY_SEPARATOR . "\x41\105\123\x47\x43\115\x2e\160\150\x70";
use AESGCM\AESGCM;
use DOMElement;
use Exception;
class XMLSecurityKey
{
    const TRIPLEDES_CBC = "\x68\164\x74\x70\72\57\57\167\167\x77\56\x77\63\x2e\x6f\x72\x67\x2f\x32\x30\x30\61\x2f\60\x34\57\x78\x6d\x6c\x65\x6e\143\x23\164\162\151\160\154\x65\x64\x65\x73\55\x63\x62\x63";
    const AES128_CBC = "\x68\164\x74\160\x3a\x2f\57\167\167\167\56\167\x33\56\x6f\x72\147\57\62\x30\60\x31\x2f\60\64\57\x78\155\154\145\x6e\x63\43\141\145\163\61\x32\70\x2d\x63\142\143";
    const AES192_CBC = "\150\164\x74\x70\x3a\57\57\x77\x77\x77\56\x77\x33\x2e\x6f\x72\x67\57\x32\x30\x30\x31\x2f\60\x34\57\170\155\x6c\x65\x6e\x63\x23\141\145\163\61\x39\62\55\143\142\143";
    const AES256_CBC = "\150\164\164\160\x3a\x2f\57\x77\167\167\56\167\x33\56\x6f\x72\x67\x2f\62\x30\60\x31\x2f\x30\x34\x2f\x78\155\154\x65\x6e\143\43\141\x65\x73\x32\65\66\55\143\x62\x63";
    const RSA_1_5 = "\150\164\164\160\72\57\x2f\x77\x77\x77\56\x77\x33\x2e\157\x72\147\x2f\62\60\x30\61\x2f\60\64\x2f\170\155\154\145\x6e\x63\43\162\163\141\55\61\137\x35";
    const RSA_OAEP_MGF1P = "\x68\x74\164\x70\x3a\57\57\167\x77\167\x2e\x77\x33\56\x6f\162\147\57\62\x30\x30\x31\57\x30\x34\x2f\170\155\154\145\156\143\x23\x72\163\x61\x2d\157\x61\x65\x70\55\x6d\x67\x66\x31\x70";
    const DSA_SHA1 = "\x68\x74\x74\160\x3a\x2f\57\167\x77\x77\x2e\x77\x33\x2e\157\162\147\x2f\62\60\x30\x30\x2f\60\x39\57\x78\155\154\x64\163\x69\x67\x23\144\163\141\x2d\x73\150\x61\x31";
    const RSA_SHA1 = "\150\164\x74\160\x3a\x2f\57\x77\x77\x77\56\167\63\56\157\x72\147\57\62\60\60\x30\x2f\60\x39\57\170\x6d\x6c\144\163\151\147\x23\x72\163\141\55\163\150\141\61";
    const RSA_SHA256 = "\150\164\x74\160\72\x2f\x2f\x77\x77\x77\56\167\x33\56\x6f\162\147\57\x32\60\x30\61\x2f\60\x34\x2f\x78\155\154\144\163\151\x67\55\x6d\x6f\x72\x65\43\162\163\x61\x2d\163\150\141\x32\65\66";
    const RSA_SHA384 = "\150\164\164\160\72\57\57\167\x77\x77\56\167\x33\56\x6f\x72\147\x2f\x32\60\x30\61\x2f\60\64\57\x78\x6d\x6c\x64\163\151\147\x2d\x6d\x6f\x72\x65\x23\162\163\141\55\x73\x68\x61\63\70\x34";
    const RSA_SHA512 = "\x68\x74\x74\x70\x3a\x2f\57\167\x77\167\56\x77\x33\56\x6f\162\147\x2f\62\x30\x30\x31\57\60\64\x2f\170\155\154\144\163\151\x67\x2d\x6d\x6f\162\x65\x23\x72\x73\x61\x2d\163\150\x61\65\61\62";
    const HMAC_SHA1 = "\x68\x74\164\x70\72\x2f\57\167\x77\167\56\167\63\56\157\162\147\x2f\62\x30\60\60\57\60\x39\x2f\x78\x6d\154\x64\163\151\147\43\150\155\x61\x63\55\x73\x68\141\61";
    const AES128_GMC = "\x68\164\164\160\x3a\x2f\57\x77\167\x77\x2e\167\63\x2e\x6f\x72\147\x2f\x32\60\60\71\x2f\170\x6d\154\x65\156\x63\x31\61\x23\x61\145\163\x31\x32\x38\x2d\x67\143\x6d";
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
    public function __construct($fH, $po = null)
    {
        switch ($fH) {
            case self::TRIPLEDES_CBC:
                $this->cryptParams["\x6c\151\142\162\x61\x72\x79"] = "\157\160\x65\156\x73\163\154";
                $this->cryptParams["\x63\x69\x70\x68\x65\x72"] = "\x64\x65\163\x2d\145\x64\x65\x33\55\x63\142\143";
                $this->cryptParams["\x74\171\160\x65"] = "\163\171\x6d\155\x65\164\x72\x69\x63";
                $this->cryptParams["\155\x65\164\x68\157\x64"] = "\150\164\x74\x70\72\57\x2f\167\x77\x77\56\x77\x33\x2e\x6f\x72\x67\57\62\x30\x30\x31\x2f\x30\64\57\170\155\154\x65\x6e\143\43\x74\x72\x69\x70\x6c\x65\x64\x65\163\x2d\143\142\x63";
                $this->cryptParams["\153\x65\x79\x73\x69\x7a\145"] = 24;
                $this->cryptParams["\x62\x6c\x6f\x63\153\x73\x69\172\145"] = 8;
                goto an;
            case self::AES128_GMC:
                $this->cryptParams["\154\x69\x62\162\x61\x72\x79"] = "\157\x70\x65\x6e\163\163\x6c";
                $this->cryptParams["\143\x69\160\150\x65\x72"] = "\141\x65\163\x2d\61\x32\70\x2d\147\x63\155";
                $this->cryptParams["\x74\171\x70\x65"] = "\163\x79\x6d\155\x65\164\162\151\143";
                $this->cryptParams["\x6d\145\x74\150\157\144"] = "\x68\164\x74\x70\x3a\57\57\167\167\x77\56\x77\x33\x2e\157\x72\x67\57\x32\60\x30\x39\57\x78\155\154\x65\156\143\61\x31\43\141\x65\x73\x31\62\x38\x2d\147\x63\x6d";
                $this->cryptParams["\x6b\x65\x79\x73\x69\172\x65"] = 16;
                $this->cryptParams["\x62\x6c\x6f\143\x6b\x73\151\x7a\145"] = 16;
                goto an;
            case self::AES128_CBC:
                $this->cryptParams["\154\151\142\162\141\x72\171"] = "\157\x70\145\x6e\163\x73\154";
                $this->cryptParams["\x63\151\x70\150\145\162"] = "\x61\x65\163\x2d\61\62\70\x2d\x63\142\143";
                $this->cryptParams["\164\x79\160\145"] = "\163\171\155\x6d\145\164\x72\151\143";
                $this->cryptParams["\155\x65\164\x68\157\144"] = "\150\164\164\x70\72\x2f\57\167\167\167\56\167\x33\x2e\157\162\x67\57\x32\60\x30\x31\x2f\60\x34\57\x78\155\x6c\145\x6e\x63\x23\141\145\x73\x31\62\x38\x2d\143\x62\143";
                $this->cryptParams["\x6b\x65\171\163\x69\x7a\145"] = 16;
                $this->cryptParams["\x62\x6c\x6f\143\153\x73\151\x7a\x65"] = 16;
                goto an;
            case self::AES192_CBC:
                $this->cryptParams["\154\151\142\162\141\x72\x79"] = "\x6f\x70\145\156\x73\x73\x6c";
                $this->cryptParams["\x63\151\160\x68\145\162"] = "\x61\x65\163\55\x31\x39\62\55\x63\142\x63";
                $this->cryptParams["\x74\171\x70\145"] = "\x73\x79\x6d\155\145\164\x72\151\143";
                $this->cryptParams["\x6d\x65\x74\150\157\144"] = "\150\164\164\x70\x3a\57\57\167\167\x77\x2e\x77\x33\56\157\x72\147\x2f\62\60\x30\x31\57\x30\64\57\170\x6d\x6c\145\x6e\x63\43\141\x65\x73\x31\x39\62\x2d\x63\142\x63";
                $this->cryptParams["\153\145\x79\163\151\x7a\x65"] = 24;
                $this->cryptParams["\142\x6c\157\143\x6b\x73\x69\x7a\145"] = 16;
                goto an;
            case self::AES256_CBC:
                $this->cryptParams["\154\151\142\x72\141\162\171"] = "\x6f\x70\145\x6e\x73\x73\154";
                $this->cryptParams["\143\x69\160\150\x65\x72"] = "\141\145\x73\x2d\62\65\66\x2d\143\142\143";
                $this->cryptParams["\164\x79\x70\x65"] = "\x73\171\x6d\155\145\x74\162\151\143";
                $this->cryptParams["\155\145\164\150\157\x64"] = "\x68\164\x74\x70\x3a\57\57\x77\167\x77\x2e\x77\63\x2e\x6f\x72\147\57\62\x30\x30\x31\57\60\64\57\170\x6d\154\x65\156\x63\x23\x61\145\x73\62\x35\66\x2d\x63\142\143";
                $this->cryptParams["\153\145\171\x73\151\172\x65"] = 32;
                $this->cryptParams["\x62\x6c\157\x63\153\163\151\172\x65"] = 16;
                goto an;
            case self::RSA_1_5:
                $this->cryptParams["\154\x69\142\162\x61\x72\171"] = "\157\x70\x65\156\163\x73\154";
                $this->cryptParams["\160\x61\144\x64\x69\156\x67"] = OPENSSL_PKCS1_PADDING;
                $this->cryptParams["\x6d\x65\164\150\157\x64"] = "\x68\x74\164\160\x3a\x2f\57\x77\167\x77\x2e\167\x33\x2e\x6f\x72\147\57\62\x30\60\x31\57\60\x34\x2f\x78\x6d\154\145\x6e\143\x23\162\163\x61\x2d\x31\x5f\65";
                if (!(is_array($po) && !empty($po["\164\x79\x70\x65"]))) {
                    goto M0;
                }
                if (!($po["\164\171\x70\145"] == "\x70\165\x62\x6c\151\143" || $po["\164\171\160\x65"] == "\x70\x72\x69\x76\x61\x74\145")) {
                    goto Ax;
                }
                $this->cryptParams["\164\171\x70\145"] = $po["\164\171\x70\145"];
                goto an;
                Ax:
                M0:
                throw new Exception("\x43\145\x72\164\x69\146\151\x63\141\x74\x65\x20\42\164\171\x70\145\42\40\50\160\162\x69\166\x61\164\145\x2f\160\x75\142\154\151\143\x29\40\x6d\165\x73\x74\40\x62\145\x20\x70\141\163\x73\145\144\40\166\x69\x61\40\160\x61\162\x61\155\145\x74\x65\x72\x73");
            case self::RSA_OAEP_MGF1P:
                $this->cryptParams["\x6c\151\x62\x72\x61\162\171"] = "\x6f\160\x65\156\163\x73\154";
                $this->cryptParams["\x70\141\144\144\151\x6e\147"] = OPENSSL_PKCS1_OAEP_PADDING;
                $this->cryptParams["\x6d\145\x74\150\x6f\x64"] = "\x68\x74\164\160\x3a\57\57\x77\x77\x77\56\x77\x33\x2e\x6f\x72\147\x2f\62\x30\x30\x31\x2f\x30\64\57\x78\155\154\x65\x6e\143\43\162\163\141\x2d\157\141\x65\x70\55\x6d\147\146\61\160";
                $this->cryptParams["\x68\141\163\x68"] = null;
                if (!(is_array($po) && !empty($po["\x74\171\x70\x65"]))) {
                    goto HD;
                }
                if (!($po["\x74\x79\x70\145"] == "\160\165\x62\154\x69\x63" || $po["\164\171\x70\145"] == "\x70\162\x69\166\141\x74\145")) {
                    goto fq;
                }
                $this->cryptParams["\x74\x79\160\145"] = $po["\164\x79\x70\145"];
                goto an;
                fq:
                HD:
                throw new Exception("\103\145\x72\x74\x69\146\x69\143\x61\164\145\40\x22\x74\171\160\145\42\40\50\x70\162\151\166\141\164\145\57\x70\x75\x62\154\151\143\x29\40\x6d\165\x73\164\40\x62\145\40\160\141\163\163\145\144\40\x76\x69\x61\40\160\x61\162\141\155\x65\x74\x65\162\x73");
            case self::RSA_SHA1:
                $this->cryptParams["\x6c\151\x62\162\141\162\171"] = "\x6f\x70\145\x6e\x73\163\x6c";
                $this->cryptParams["\x6d\145\x74\150\157\144"] = "\150\164\x74\160\72\57\x2f\167\167\x77\x2e\x77\63\56\x6f\162\147\57\62\x30\x30\x30\x2f\60\x39\x2f\170\155\x6c\144\163\151\147\43\x72\x73\x61\55\x73\150\141\61";
                $this->cryptParams["\160\x61\x64\x64\151\x6e\147"] = OPENSSL_PKCS1_PADDING;
                if (!(is_array($po) && !empty($po["\x74\171\160\145"]))) {
                    goto NE;
                }
                if (!($po["\164\171\160\145"] == "\160\x75\142\154\x69\x63" || $po["\x74\171\160\145"] == "\x70\x72\x69\x76\141\164\x65")) {
                    goto wp;
                }
                $this->cryptParams["\164\171\160\x65"] = $po["\164\x79\x70\145"];
                goto an;
                wp:
                NE:
                throw new Exception("\x43\x65\162\x74\151\x66\x69\x63\x61\x74\145\x20\x22\x74\171\160\145\x22\x20\50\160\x72\151\166\141\x74\145\x2f\160\x75\x62\154\x69\x63\x29\x20\155\x75\163\164\40\x62\x65\x20\x70\x61\163\163\x65\x64\x20\166\151\141\40\160\141\162\141\155\x65\164\145\162\163");
            case self::RSA_SHA256:
                $this->cryptParams["\x6c\151\x62\x72\x61\162\x79"] = "\x6f\x70\145\x6e\x73\x73\x6c";
                $this->cryptParams["\x6d\x65\x74\x68\157\x64"] = "\x68\x74\164\160\x3a\x2f\x2f\x77\x77\x77\x2e\167\x33\x2e\157\x72\147\57\x32\60\x30\61\x2f\x30\x34\x2f\170\x6d\154\144\x73\151\x67\55\x6d\157\162\145\x23\162\163\x61\55\163\150\141\x32\65\66";
                $this->cryptParams["\160\x61\x64\144\151\x6e\x67"] = OPENSSL_PKCS1_PADDING;
                $this->cryptParams["\x64\x69\x67\145\163\x74"] = "\123\110\x41\x32\x35\x36";
                if (!(is_array($po) && !empty($po["\x74\171\x70\x65"]))) {
                    goto oE;
                }
                if (!($po["\x74\x79\x70\x65"] == "\x70\165\x62\x6c\151\143" || $po["\x74\x79\x70\145"] == "\x70\162\x69\x76\x61\164\145")) {
                    goto df;
                }
                $this->cryptParams["\164\x79\160\x65"] = $po["\x74\171\160\145"];
                goto an;
                df:
                oE:
                throw new Exception("\x43\x65\162\164\151\146\151\143\141\164\x65\40\x22\164\171\160\x65\42\x20\50\x70\x72\x69\166\x61\x74\145\57\x70\x75\142\x6c\x69\143\x29\x20\155\x75\163\164\x20\x62\x65\x20\160\141\163\x73\145\144\x20\x76\x69\x61\40\160\x61\162\141\155\x65\164\145\x72\163");
            case self::RSA_SHA384:
                $this->cryptParams["\154\151\142\162\x61\x72\171"] = "\x6f\160\x65\156\163\163\x6c";
                $this->cryptParams["\x6d\145\x74\x68\x6f\x64"] = "\150\x74\164\160\x3a\x2f\57\167\167\x77\56\167\63\56\157\x72\x67\57\x32\60\60\x31\x2f\60\x34\57\170\155\154\x64\163\x69\147\55\155\157\162\145\x23\x72\163\x61\x2d\x73\x68\x61\x33\70\x34";
                $this->cryptParams["\x70\x61\x64\x64\x69\x6e\x67"] = OPENSSL_PKCS1_PADDING;
                $this->cryptParams["\x64\151\147\145\163\164"] = "\x53\x48\101\63\x38\64";
                if (!(is_array($po) && !empty($po["\164\171\x70\145"]))) {
                    goto Sq;
                }
                if (!($po["\164\x79\x70\145"] == "\160\165\x62\154\151\x63" || $po["\x74\x79\x70\x65"] == "\160\x72\151\x76\x61\x74\x65")) {
                    goto w7;
                }
                $this->cryptParams["\164\171\160\145"] = $po["\164\171\x70\x65"];
                goto an;
                w7:
                Sq:
                throw new Exception("\x43\145\162\164\x69\146\151\x63\x61\164\x65\x20\x22\x74\171\160\x65\42\x20\x28\160\162\x69\166\x61\164\145\x2f\160\x75\142\154\x69\143\x29\40\155\165\163\164\40\x62\145\40\160\141\163\x73\145\x64\x20\166\151\x61\40\160\141\x72\x61\x6d\145\x74\x65\x72\x73");
            case self::RSA_SHA512:
                $this->cryptParams["\x6c\151\x62\162\141\162\171"] = "\157\160\x65\x6e\163\x73\154";
                $this->cryptParams["\x6d\145\164\x68\157\144"] = "\150\x74\x74\x70\x3a\x2f\57\x77\x77\167\56\x77\63\56\x6f\x72\x67\57\x32\x30\60\61\57\60\x34\57\170\155\154\x64\163\x69\147\x2d\155\157\162\x65\x23\162\x73\x61\55\x73\x68\141\65\61\x32";
                $this->cryptParams["\160\141\144\x64\151\x6e\147"] = OPENSSL_PKCS1_PADDING;
                $this->cryptParams["\x64\x69\x67\145\x73\x74"] = "\x53\x48\x41\65\x31\x32";
                if (!(is_array($po) && !empty($po["\164\171\x70\145"]))) {
                    goto XD;
                }
                if (!($po["\x74\171\160\145"] == "\160\165\142\154\151\x63" || $po["\x74\x79\160\x65"] == "\160\x72\x69\166\x61\x74\x65")) {
                    goto QJ;
                }
                $this->cryptParams["\x74\x79\x70\145"] = $po["\x74\171\x70\x65"];
                goto an;
                QJ:
                XD:
                throw new Exception("\x43\x65\162\164\x69\x66\x69\143\141\164\145\x20\42\x74\x79\x70\145\x22\40\50\160\x72\151\166\141\164\145\57\x70\x75\142\x6c\x69\x63\x29\40\155\x75\x73\x74\40\142\145\40\160\141\163\163\145\x64\x20\x76\151\x61\x20\x70\141\162\141\155\x65\x74\x65\162\x73");
            case self::HMAC_SHA1:
                $this->cryptParams["\x6c\151\142\162\141\162\x79"] = $fH;
                $this->cryptParams["\155\x65\164\150\x6f\144"] = "\150\x74\164\160\x3a\x2f\x2f\167\x77\x77\56\x77\63\56\x6f\x72\147\x2f\62\x30\60\x30\57\60\71\x2f\170\x6d\154\144\x73\151\147\43\x68\155\x61\143\x2d\x73\150\141\x31";
                goto an;
            default:
                throw new Exception("\x49\x6e\166\x61\154\x69\x64\x20\x4b\x65\x79\40\124\171\160\x65");
        }
        Jc:
        an:
        $this->type = $fH;
    }
    public function getSymmetricKeySize()
    {
        if (isset($this->cryptParams["\x6b\x65\171\x73\x69\x7a\x65"])) {
            goto ZX;
        }
        return null;
        ZX:
        return $this->cryptParams["\x6b\145\171\163\x69\172\145"];
    }
    public function generateSessionKey()
    {
        if (isset($this->cryptParams["\x6b\145\x79\163\x69\x7a\x65"])) {
            goto By;
        }
        throw new Exception("\x55\x6e\x6b\x6e\x6f\x77\156\x20\x6b\x65\171\40\x73\151\172\x65\40\x66\x6f\x72\40\x74\171\x70\x65\x20\42" . $this->type . "\42\56");
        By:
        $VC = $this->cryptParams["\x6b\145\x79\x73\x69\172\145"];
        $ld = openssl_random_pseudo_bytes($VC);
        if (!($this->type === self::TRIPLEDES_CBC)) {
            goto hL;
        }
        $oM = 0;
        DL:
        if (!($oM < strlen($ld))) {
            goto Is;
        }
        $Zs = ord($ld[$oM]) & 254;
        $L4 = 1;
        $RY = 1;
        aG:
        if (!($RY < 8)) {
            goto Gy;
        }
        $L4 ^= $Zs >> $RY & 1;
        jK:
        $RY++;
        goto aG;
        Gy:
        $Zs |= $L4;
        $ld[$oM] = chr($Zs);
        UZ:
        $oM++;
        goto DL;
        Is:
        hL:
        $this->key = $ld;
        return $ld;
    }
    public static function getRawThumbprint($wA)
    {
        $iu = explode("\xa", $wA);
        $rL = '';
        $fw = false;
        foreach ($iu as $t_) {
            if (!$fw) {
                goto Mo;
            }
            if (!(strncmp($t_, "\x2d\x2d\55\x2d\x2d\105\116\104\x20\103\x45\x52\124\x49\x46\x49\x43\101\x54\x45", 20) == 0)) {
                goto um;
            }
            goto RS;
            um:
            $rL .= trim($t_);
            goto jA;
            Mo:
            if (!(strncmp($t_, "\55\x2d\x2d\x2d\x2d\x42\x45\107\x49\116\40\x43\105\122\124\x49\106\111\103\101\x54\x45", 22) == 0)) {
                goto qn;
            }
            $fw = true;
            qn:
            jA:
            C6:
        }
        RS:
        if (empty($rL)) {
            goto KI;
        }
        return strtolower(sha1(base64_decode($rL)));
        KI:
        return null;
    }
    public function loadKey($ld, $YO = false, $H2 = false)
    {
        if ($YO) {
            goto dj;
        }
        $this->key = $ld;
        goto mf;
        dj:
        $this->key = file_get_contents($ld);
        mf:
        if ($H2) {
            goto Yb;
        }
        $this->x509Certificate = null;
        goto vu;
        Yb:
        $this->key = openssl_x509_read($this->key);
        openssl_x509_export($this->key, $q_);
        $this->x509Certificate = $q_;
        $this->key = $q_;
        vu:
        if (!($this->cryptParams["\154\x69\x62\162\x61\x72\x79"] == "\157\x70\145\x6e\x73\163\x6c")) {
            goto SG;
        }
        switch ($this->cryptParams["\164\x79\160\x65"]) {
            case "\160\165\x62\154\x69\143":
                if (!$H2) {
                    goto Hd;
                }
                $this->X509Thumbprint = self::getRawThumbprint($this->key);
                Hd:
                $this->key = openssl_get_publickey($this->key);
                if ($this->key) {
                    goto gc;
                }
                throw new Exception("\125\x6e\x61\x62\154\x65\x20\x74\157\x20\x65\x78\164\x72\141\143\164\40\x70\165\x62\x6c\x69\x63\x20\153\x65\171");
                gc:
                goto AJ;
            case "\160\x72\x69\166\141\x74\145":
                $this->key = openssl_get_privatekey($this->key, $this->passphrase);
                goto AJ;
            case "\163\171\x6d\x6d\x65\164\162\x69\143":
                if (!(strlen($this->key) < $this->cryptParams["\153\x65\x79\x73\151\172\145"])) {
                    goto X3;
                }
                throw new Exception("\x4b\x65\x79\40\155\x75\163\164\40\143\x6f\156\x74\141\151\156\x20\141\164\40\x6c\145\x61\163\164\40\62\x35\x20\x63\x68\x61\x72\x61\143\164\x65\x72\x73\x20\146\157\162\x20\x74\150\151\x73\x20\143\x69\x70\x68\x65\162");
                X3:
                goto AJ;
            default:
                throw new Exception("\x55\x6e\x6b\156\157\167\x6e\40\x74\x79\160\145");
        }
        D1:
        AJ:
        SG:
    }
    private function padISO10126($rL, $j_)
    {
        if (!($j_ > 256)) {
            goto HO;
        }
        throw new Exception("\x42\154\157\x63\153\40\163\x69\x7a\145\x20\x68\x69\147\x68\x65\162\x20\164\150\141\156\x20\62\65\x36\x20\156\x6f\x74\x20\x61\x6c\154\157\167\x65\x64");
        HO:
        $hm = $j_ - strlen($rL) % $j_;
        $U6 = chr($hm);
        return $rL . str_repeat($U6, $hm);
    }
    private function unpadISO10126($rL)
    {
        $hm = substr($rL, -1);
        $q0 = ord($hm);
        return substr($rL, 0, -$q0);
    }
    private function encryptSymmetric($rL)
    {
        $this->iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->cryptParams["\143\x69\x70\x68\145\x72"]));
        $rL = $this->padISO10126($rL, $this->cryptParams["\142\154\157\143\153\163\151\x7a\x65"]);
        $wK = openssl_encrypt($rL, $this->cryptParams["\143\x69\x70\150\x65\x72"], $this->key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $this->iv);
        if (!(false === $wK)) {
            goto Ks;
        }
        throw new Exception("\x46\141\x69\154\165\162\x65\x20\145\x6e\x63\162\171\160\164\151\x6e\x67\40\104\141\164\141\x20\50\157\x70\x65\x6e\163\163\x6c\x20\163\171\155\x6d\145\x74\x72\151\x63\51\x20\55\40" . openssl_error_string());
        Ks:
        return $this->iv . $wK;
    }
    private function decryptSymmetric($rL)
    {
        if (!($this->cryptParams["\143\151\x70\x68\145\162"] === "\141\x65\163\55\61\x32\70\x2d\147\x63\155")) {
            goto k_;
        }
        return $this->decryptSymmetricAESGCM($rL);
        k_:
        $qh = openssl_cipher_iv_length($this->cryptParams["\x63\x69\160\x68\145\x72"]);
        $this->iv = substr($rL, 0, $qh);
        $rL = substr($rL, $qh);
        $iX = openssl_decrypt($rL, $this->cryptParams["\143\151\160\x68\145\x72"], $this->key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $this->iv);
        if (!(false === $iX)) {
            goto F4;
        }
        throw new Exception("\106\141\151\x6c\165\162\145\40\x64\145\143\162\171\x70\164\151\x6e\147\x20\x44\x61\x74\x61\x20\50\x6f\x70\x65\156\163\163\154\40\x73\x79\x6d\x6d\x65\x74\x72\151\x63\51\40\55\40" . openssl_error_string());
        F4:
        return $this->unpadISO10126($iX);
    }
    private function decryptSymmetricAESGCM($rL)
    {
        $qh = openssl_cipher_iv_length($this->cryptParams["\143\151\x70\150\x65\x72"]);
        $this->iv = substr($rL, 0, $qh);
        $rL = substr($rL, $qh);
        $iX = AESGCM::decryptWithAppendedTag($this->key, $this->iv, $rL, null, 128);
        if (!(false === $iX)) {
            goto IB;
        }
        throw new Exception("\x46\x61\x69\154\165\x72\x65\x20\x64\x65\x63\x72\x79\160\x74\151\x6e\x67\x20\x44\141\164\141\x20\50\157\x70\145\156\163\x73\154\x20\x73\x79\155\155\145\164\x72\x69\x63\x29\40\x2d\x20" . openssl_error_string());
        IB:
        return $iX;
    }
    private function encryptPublic($rL)
    {
        if (openssl_public_encrypt($rL, $wK, $this->key, $this->cryptParams["\160\x61\144\144\151\156\147"])) {
            goto dX;
        }
        throw new Exception("\x46\141\151\154\165\x72\145\x20\145\156\x63\162\x79\x70\x74\151\156\x67\x20\x44\141\164\x61\x20\50\157\160\x65\x6e\163\x73\154\x20\x70\165\142\154\151\x63\51\40\x2d\x20" . openssl_error_string());
        dX:
        return $wK;
    }
    private function decryptPublic($rL)
    {
        if (openssl_public_decrypt($rL, $iX, $this->key, $this->cryptParams["\160\141\x64\144\151\x6e\147"])) {
            goto EW;
        }
        throw new Exception("\106\x61\x69\154\165\x72\x65\40\x64\x65\143\162\171\x70\164\x69\x6e\147\40\104\141\164\141\40\50\x6f\x70\x65\156\163\x73\154\40\x70\x75\142\x6c\x69\143\x29\40\55\x20" . openssl_error_string());
        EW:
        return $iX;
    }
    private function encryptPrivate($rL)
    {
        if (openssl_private_encrypt($rL, $wK, $this->key, $this->cryptParams["\x70\x61\x64\144\x69\156\x67"])) {
            goto IZ;
        }
        throw new Exception("\106\141\151\154\x75\162\x65\40\x65\x6e\143\162\x79\x70\164\x69\x6e\147\40\x44\141\164\141\40\x28\157\160\145\156\163\x73\x6c\40\160\x72\x69\166\141\x74\x65\51\40\x2d\x20" . openssl_error_string());
        IZ:
        return $wK;
    }
    private function decryptPrivate($rL)
    {
        if (openssl_private_decrypt($rL, $iX, $this->key, $this->cryptParams["\160\141\144\144\x69\x6e\x67"])) {
            goto c_;
        }
        throw new Exception("\x46\x61\x69\x6c\x75\x72\145\x20\144\145\x63\162\171\160\164\151\156\x67\40\x44\141\x74\x61\x20\50\x6f\x70\x65\156\163\163\154\x20\160\162\x69\166\x61\164\145\x29\x20\55\40" . openssl_error_string());
        c_:
        return $iX;
    }
    private function signOpenSSL($rL)
    {
        $S8 = OPENSSL_ALGO_SHA1;
        if (empty($this->cryptParams["\144\x69\147\145\163\x74"])) {
            goto hM;
        }
        $S8 = $this->cryptParams["\144\151\x67\145\x73\x74"];
        hM:
        if (openssl_sign($rL, $fJ, $this->key, $S8)) {
            goto uK;
        }
        throw new Exception("\106\x61\151\154\x75\162\145\x20\x53\x69\x67\156\x69\x6e\147\x20\104\141\x74\x61\x3a\40" . openssl_error_string() . "\40\x2d\40" . $S8);
        uK:
        return $fJ;
    }
    private function verifyOpenSSL($rL, $fJ)
    {
        $S8 = OPENSSL_ALGO_SHA1;
        if (empty($this->cryptParams["\x64\x69\147\145\163\x74"])) {
            goto jW;
        }
        $S8 = $this->cryptParams["\x64\x69\x67\x65\x73\x74"];
        jW:
        return openssl_verify($rL, $fJ, $this->key, $S8);
    }
    public function encryptData($rL)
    {
        if (!($this->cryptParams["\x6c\x69\142\162\x61\162\x79"] === "\157\x70\x65\x6e\x73\x73\154")) {
            goto Fu;
        }
        switch ($this->cryptParams["\164\171\x70\x65"]) {
            case "\x73\x79\x6d\155\x65\x74\x72\151\143":
                return $this->encryptSymmetric($rL);
            case "\160\165\142\x6c\151\143":
                return $this->encryptPublic($rL);
            case "\x70\162\x69\166\141\164\145":
                return $this->encryptPrivate($rL);
        }
        cg:
        BM:
        Fu:
    }
    public function decryptData($rL)
    {
        if (!($this->cryptParams["\x6c\x69\142\162\x61\162\171"] === "\157\x70\x65\x6e\163\163\x6c")) {
            goto ab;
        }
        switch ($this->cryptParams["\164\x79\160\x65"]) {
            case "\x73\171\155\155\145\164\162\x69\x63":
                return $this->decryptSymmetric($rL);
            case "\x70\x75\x62\x6c\151\x63":
                return $this->decryptPublic($rL);
            case "\160\x72\x69\x76\141\164\x65":
                return $this->decryptPrivate($rL);
        }
        e0:
        LB:
        ab:
    }
    public function signData($rL)
    {
        switch ($this->cryptParams["\154\x69\x62\x72\141\162\x79"]) {
            case "\157\160\x65\x6e\163\163\x6c":
                return $this->signOpenSSL($rL);
            case self::HMAC_SHA1:
                return hash_hmac("\x73\150\x61\x31", $rL, $this->key, true);
        }
        Yh:
        CR:
    }
    public function verifySignature($rL, $fJ)
    {
        switch ($this->cryptParams["\x6c\x69\x62\162\141\x72\171"]) {
            case "\x6f\160\x65\x6e\x73\x73\154":
                return $this->verifyOpenSSL($rL, $fJ);
            case self::HMAC_SHA1:
                $yg = hash_hmac("\163\x68\x61\x31", $rL, $this->key, true);
                return strcmp($fJ, $yg) == 0;
        }
        f9:
        WU:
    }
    public function getAlgorith()
    {
        return $this->getAlgorithm();
    }
    public function getAlgorithm()
    {
        return $this->cryptParams["\155\145\x74\150\x6f\144"];
    }
    public static function makeAsnSegment($fH, $JU)
    {
        switch ($fH) {
            case 2:
                if (!(ord($JU) > 127)) {
                    goto wM;
                }
                $JU = chr(0) . $JU;
                wM:
                goto AT;
            case 3:
                $JU = chr(0) . $JU;
                goto AT;
        }
        xi:
        AT:
        $G_ = strlen($JU);
        if ($G_ < 128) {
            goto ji;
        }
        if ($G_ < 256) {
            goto Y4;
        }
        if ($G_ < 65536) {
            goto N7;
        }
        $cO = null;
        goto h9;
        N7:
        $cO = sprintf("\x25\x63\x25\143\x25\143\45\x63\45\163", $fH, 130, $G_ / 256, $G_ % 256, $JU);
        h9:
        goto r6;
        Y4:
        $cO = sprintf("\x25\143\x25\143\45\143\45\x73", $fH, 129, $G_, $JU);
        r6:
        goto Ip;
        ji:
        $cO = sprintf("\45\143\45\x63\x25\163", $fH, $G_, $JU);
        Ip:
        return $cO;
    }
    public static function convertRSA($H5, $Z_)
    {
        $s5 = self::makeAsnSegment(2, $Z_);
        $r2 = self::makeAsnSegment(2, $H5);
        $P7 = self::makeAsnSegment(48, $r2 . $s5);
        $fb = self::makeAsnSegment(3, $P7);
        $YR = pack("\x48\52", "\63\x30\x30\104\x30\66\x30\71\62\x41\x38\66\64\70\70\x36\106\67\60\104\60\x31\x30\61\x30\61\x30\65\x30\60");
        $j2 = self::makeAsnSegment(48, $YR . $fb);
        $mK = base64_encode($j2);
        $hs = "\55\55\55\x2d\x2d\102\105\x47\x49\x4e\40\x50\125\102\114\x49\x43\x20\x4b\x45\x59\55\55\55\x2d\x2d\xa";
        $qy = 0;
        P8V:
        if (!($YT = substr($mK, $qy, 64))) {
            goto TSq;
        }
        $hs = $hs . $YT . "\xa";
        $qy += 64;
        goto P8V;
        TSq:
        return $hs . "\55\55\55\55\55\105\116\x44\40\120\x55\x42\114\111\x43\x20\x4b\105\131\x2d\x2d\55\55\x2d\12";
    }
    public function serializeKey($ME)
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
    public static function fromEncryptedKeyElement(DOMElement $z2)
    {
        $Dj = new XMLSecEnc();
        $Dj->setNode($z2);
        if ($In = $Dj->locateKey()) {
            goto yML;
        }
        throw new Exception("\125\x6e\141\142\x6c\145\x20\164\x6f\40\154\x6f\x63\x61\x74\x65\40\141\x6c\x67\157\x72\151\164\x68\x6d\40\x66\x6f\x72\x20\x74\150\151\x73\40\x45\x6e\x63\x72\171\x70\x74\145\144\40\x4b\x65\171");
        yML:
        $In->isEncrypted = true;
        $In->encryptedCtx = $Dj;
        XMLSecEnc::staticLocateKeyInfo($In, $z2);
        return $In;
    }
}
