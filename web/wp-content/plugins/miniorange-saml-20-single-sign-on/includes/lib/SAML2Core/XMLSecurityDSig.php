<?php


namespace RobRichards\XMLSecLibs;

use DOMDocument;
use DOMElement;
use DOMNode;
use DOMXPath;
use Exception;
use RobRichards\XMLSecLibs\Utils\XPath;
class XMLSecurityDSig
{
    const XMLDSIGNS = "\150\164\x74\x70\x3a\x2f\57\167\167\x77\x2e\x77\63\x2e\x6f\x72\147\x2f\62\60\60\x30\57\60\x39\x2f\170\x6d\154\144\x73\151\x67\43";
    const SHA1 = "\150\164\164\160\72\57\x2f\167\x77\167\x2e\167\63\x2e\157\x72\147\57\62\60\x30\x30\57\x30\71\x2f\x78\155\x6c\x64\x73\151\x67\x23\163\x68\x61\x31";
    const SHA256 = "\x68\x74\164\160\72\57\57\x77\167\x77\56\167\63\x2e\157\162\x67\57\x32\x30\x30\x31\57\60\64\57\170\155\x6c\145\x6e\143\x23\x73\x68\x61\62\x35\x36";
    const SHA384 = "\x68\164\164\160\72\57\57\167\x77\167\56\x77\63\56\157\x72\x67\x2f\62\60\x30\x31\x2f\x30\64\x2f\170\155\x6c\x64\163\151\147\55\x6d\157\x72\145\x23\x73\150\x61\63\70\64";
    const SHA512 = "\150\x74\x74\160\72\57\57\167\x77\x77\x2e\x77\63\56\157\x72\147\x2f\x32\x30\x30\x31\57\60\x34\57\x78\155\x6c\x65\x6e\x63\43\163\x68\141\x35\61\x32";
    const RIPEMD160 = "\150\164\x74\160\x3a\x2f\57\x77\x77\x77\x2e\x77\x33\56\157\162\147\57\62\60\x30\61\57\x30\x34\x2f\x78\155\154\x65\x6e\x63\x23\162\151\160\x65\155\144\61\66\60";
    const C14N = "\150\164\x74\x70\72\57\57\167\167\x77\x2e\x77\63\x2e\157\162\147\x2f\124\x52\57\x32\x30\x30\61\57\x52\x45\x43\x2d\x78\155\x6c\x2d\x63\x31\x34\x6e\55\x32\x30\x30\61\60\63\x31\x35";
    const C14N_COMMENTS = "\150\164\164\160\x3a\x2f\57\x77\167\167\56\167\x33\56\157\162\x67\x2f\124\x52\57\62\60\x30\61\x2f\122\x45\103\55\170\155\x6c\x2d\x63\61\64\x6e\55\62\60\60\x31\x30\63\x31\65\43\127\x69\x74\150\103\157\x6d\155\x65\x6e\164\163";
    const EXC_C14N = "\150\164\x74\x70\72\x2f\x2f\x77\167\x77\56\x77\x33\x2e\157\x72\x67\57\x32\x30\x30\x31\57\x31\60\x2f\x78\x6d\154\55\x65\170\x63\55\143\x31\x34\x6e\43";
    const EXC_C14N_COMMENTS = "\150\164\164\x70\x3a\x2f\57\167\167\167\x2e\x77\x33\x2e\157\162\x67\57\62\x30\60\x31\x2f\61\x30\57\170\155\154\x2d\x65\170\143\x2d\143\61\64\x6e\x23\127\x69\164\x68\x43\157\x6d\155\x65\156\x74\163";
    const template = "\x3c\144\x73\72\123\x69\x67\156\x61\164\x75\x72\145\40\x78\x6d\154\156\x73\x3a\x64\x73\x3d\x22\x68\164\164\x70\72\57\x2f\x77\167\167\56\167\63\56\157\162\x67\57\62\x30\60\x30\x2f\60\71\x2f\170\155\x6c\x64\163\x69\147\43\x22\x3e\xa\x20\40\x3c\x64\x73\72\123\x69\x67\156\145\144\111\156\x66\x6f\76\xa\40\x20\40\x20\74\x64\163\x3a\123\151\147\x6e\x61\x74\165\162\145\115\145\x74\x68\x6f\x64\40\x2f\x3e\xa\x20\40\74\x2f\x64\x73\72\123\151\x67\156\145\144\111\x6e\146\157\x3e\xa\x3c\x2f\144\x73\x3a\x53\151\x67\156\x61\x74\165\x72\145\x3e";
    const BASE_TEMPLATE = "\x3c\x53\151\x67\x6e\x61\x74\x75\x72\x65\x20\170\x6d\154\x6e\163\x3d\x22\150\x74\x74\160\x3a\57\x2f\167\167\167\56\167\63\x2e\x6f\x72\147\57\62\x30\60\60\57\60\71\57\x78\x6d\x6c\144\163\x69\147\x23\42\76\xa\40\40\x3c\x53\151\147\x6e\145\144\x49\x6e\146\157\x3e\xa\x20\x20\40\x20\x3c\123\x69\147\156\141\x74\165\x72\x65\x4d\x65\x74\x68\x6f\144\40\57\x3e\12\40\40\74\57\x53\151\x67\156\145\x64\x49\156\x66\x6f\76\xa\x3c\57\x53\151\147\156\x61\164\165\162\x65\76";
    public $sigNode = null;
    public $idKeys = array();
    public $idNS = array();
    private $signedInfo = null;
    private $xPathCtx = null;
    private $canonicalMethod = null;
    private $prefix = '';
    private $searchpfx = "\x73\x65\x63\144\x73\151\x67";
    private $validatedNodes = null;
    public function __construct($Qg = "\x64\163")
    {
        $xD = self::BASE_TEMPLATE;
        if (empty($Qg)) {
            goto rVI;
        }
        $this->prefix = $Qg . "\x3a";
        $tv = array("\x3c\x53", "\x3c\57\x53", "\x78\x6d\154\x6e\163\75");
        $Nb = array("\74{$Qg}\x3a\123", "\x3c\57{$Qg}\x3a\123", "\170\155\x6c\x6e\163\72{$Qg}\x3d");
        $xD = str_replace($tv, $Nb, $xD);
        rVI:
        $IT = new DOMDocument();
        $IT->loadXML($xD);
        $this->sigNode = $IT->documentElement;
    }
    private function resetXPathObj()
    {
        $this->xPathCtx = null;
    }
    private function getXPathObj()
    {
        if (!(empty($this->xPathCtx) && !empty($this->sigNode))) {
            goto ceW;
        }
        $Cu = new DOMXPath($this->sigNode->ownerDocument);
        $Cu->registerNamespace("\x73\x65\x63\x64\x73\x69\147", self::XMLDSIGNS);
        $this->xPathCtx = $Cu;
        ceW:
        return $this->xPathCtx;
    }
    public static function generateGUID($Qg = "\160\x66\x78")
    {
        $He = md5(uniqid(mt_rand(), true));
        $vY = $Qg . substr($He, 0, 8) . "\x2d" . substr($He, 8, 4) . "\55" . substr($He, 12, 4) . "\55" . substr($He, 16, 4) . "\x2d" . substr($He, 20, 12);
        return $vY;
    }
    public static function generate_GUID($Qg = "\x70\x66\170")
    {
        return self::generateGUID($Qg);
    }
    public function locateSignature($G8, $Te = 0)
    {
        if ($G8 instanceof DOMDocument) {
            goto h83;
        }
        $Yf = $G8->ownerDocument;
        goto so1;
        h83:
        $Yf = $G8;
        so1:
        if (!$Yf) {
            goto poS;
        }
        $Cu = new DOMXPath($Yf);
        $Cu->registerNamespace("\163\145\x63\x64\x73\151\147", self::XMLDSIGNS);
        $ye = "\56\57\x2f\x73\145\x63\144\163\x69\x67\72\x53\x69\x67\156\x61\x74\165\x72\x65";
        $fU = $Cu->query($ye, $G8);
        $this->sigNode = $fU->item($Te);
        return $this->sigNode;
        poS:
        return null;
    }
    public function createNewSignNode($AF, $g2 = null)
    {
        $Yf = $this->sigNode->ownerDocument;
        if (!is_null($g2)) {
            goto j6t;
        }
        $rf = $Yf->createElementNS(self::XMLDSIGNS, $this->prefix . $AF);
        goto CIo;
        j6t:
        $rf = $Yf->createElementNS(self::XMLDSIGNS, $this->prefix . $AF, $g2);
        CIo:
        return $rf;
    }
    public function setCanonicalMethod($R2)
    {
        switch ($R2) {
            case "\150\x74\x74\160\72\57\x2f\167\x77\x77\x2e\167\x33\x2e\157\162\147\57\124\122\x2f\62\x30\60\61\x2f\122\x45\103\55\x78\155\154\x2d\143\x31\x34\156\x2d\x32\x30\60\x31\x30\63\61\65":
            case "\x68\x74\164\160\72\x2f\x2f\167\167\x77\56\167\63\56\x6f\162\x67\57\124\122\57\62\60\60\x31\57\x52\x45\103\55\170\155\154\55\143\x31\64\156\x2d\x32\60\x30\x31\x30\63\x31\65\x23\x57\x69\164\150\x43\157\x6d\x6d\145\156\164\x73":
            case "\x68\164\164\160\x3a\57\x2f\x77\167\x77\56\x77\x33\x2e\x6f\x72\x67\x2f\62\x30\x30\61\57\61\60\x2f\170\155\x6c\55\145\170\143\x2d\143\x31\64\x6e\x23":
            case "\150\x74\x74\x70\72\x2f\x2f\167\167\x77\56\167\x33\x2e\x6f\162\x67\57\x32\x30\60\61\x2f\x31\x30\57\x78\155\x6c\x2d\x65\x78\x63\55\x63\x31\64\x6e\43\x57\x69\x74\x68\x43\x6f\155\x6d\145\x6e\x74\163":
                $this->canonicalMethod = $R2;
                goto BQT;
            default:
                throw new Exception("\111\156\166\141\x6c\151\144\40\x43\141\x6e\157\156\151\143\x61\x6c\x20\x4d\145\x74\x68\157\144");
        }
        KEe:
        BQT:
        if (!($Cu = $this->getXPathObj())) {
            goto lAD;
        }
        $ye = "\56\57" . $this->searchpfx . "\x3a\x53\x69\147\156\x65\x64\111\156\146\x6f";
        $fU = $Cu->query($ye, $this->sigNode);
        if (!($rH = $fU->item(0))) {
            goto D0B;
        }
        $ye = "\x2e\x2f" . $this->searchpfx . "\x43\141\x6e\x6f\x6e\x69\143\141\x6c\x69\x7a\141\164\x69\157\156\115\x65\164\x68\x6f\x64";
        $fU = $Cu->query($ye, $rH);
        if ($oK = $fU->item(0)) {
            goto ixd;
        }
        $oK = $this->createNewSignNode("\103\x61\x6e\x6f\156\x69\143\141\154\x69\x7a\141\164\151\x6f\x6e\x4d\145\164\x68\157\144");
        $rH->insertBefore($oK, $rH->firstChild);
        ixd:
        $oK->setAttribute("\101\x6c\147\x6f\162\x69\164\150\x6d", $this->canonicalMethod);
        D0B:
        lAD:
    }
    private function canonicalizeData($rf, $Nj, $Q9 = null, $Jl = null)
    {
        $gS = false;
        $Io = false;
        switch ($Nj) {
            case "\150\x74\164\x70\x3a\x2f\57\167\167\x77\x2e\x77\63\56\x6f\x72\147\57\124\x52\57\62\x30\x30\61\x2f\x52\x45\x43\x2d\x78\155\x6c\x2d\x63\x31\x34\x6e\55\x32\x30\60\x31\60\63\61\65":
                $gS = false;
                $Io = false;
                goto z0t;
            case "\150\x74\164\x70\x3a\57\57\x77\167\167\56\x77\63\x2e\157\162\147\57\x54\x52\x2f\62\60\60\x31\x2f\122\105\103\x2d\x78\155\154\x2d\x63\61\64\x6e\55\62\x30\60\61\60\x33\x31\65\x23\x57\x69\164\x68\103\157\155\x6d\x65\x6e\164\163":
                $Io = true;
                goto z0t;
            case "\x68\x74\x74\x70\x3a\57\x2f\167\x77\x77\56\x77\x33\x2e\x6f\162\x67\57\x32\x30\60\61\57\x31\60\57\x78\155\x6c\55\x65\x78\x63\x2d\143\x31\64\x6e\x23":
                $gS = true;
                goto z0t;
            case "\150\x74\x74\x70\x3a\x2f\57\167\x77\167\56\x77\63\56\157\x72\147\57\x32\x30\x30\x31\x2f\x31\x30\57\x78\155\154\x2d\x65\x78\143\x2d\143\x31\x34\156\x23\x57\151\x74\x68\x43\157\x6d\155\x65\156\164\x73":
                $gS = true;
                $Io = true;
                goto z0t;
        }
        HEv:
        z0t:
        if (!(is_null($Q9) && $rf instanceof DOMNode && $rf->ownerDocument !== null && $rf->isSameNode($rf->ownerDocument->documentElement))) {
            goto ygs;
        }
        $z2 = $rf;
        s29:
        if (!($Pn = $z2->previousSibling)) {
            goto GPf;
        }
        if (!($Pn->nodeType == XML_PI_NODE || $Pn->nodeType == XML_COMMENT_NODE && $Io)) {
            goto TXV;
        }
        goto GPf;
        TXV:
        $z2 = $Pn;
        goto s29;
        GPf:
        if (!($Pn == null)) {
            goto Ruc;
        }
        $rf = $rf->ownerDocument;
        Ruc:
        ygs:
        return $rf->C14N($gS, $Io, $Q9, $Jl);
    }
    public function canonicalizeSignedInfo()
    {
        $Yf = $this->sigNode->ownerDocument;
        $Nj = null;
        if (!$Yf) {
            goto Ttc;
        }
        $Cu = $this->getXPathObj();
        $ye = "\56\x2f\163\x65\x63\144\163\151\x67\72\x53\x69\x67\x6e\x65\x64\x49\x6e\146\157";
        $fU = $Cu->query($ye, $this->sigNode);
        if (!($d5 = $fU->item(0))) {
            goto fpL;
        }
        $ye = "\x2e\x2f\x73\145\143\x64\163\x69\x67\72\103\x61\156\157\x6e\x69\143\141\154\x69\x7a\x61\164\x69\x6f\156\115\x65\164\150\157\x64";
        $fU = $Cu->query($ye, $d5);
        if (!($oK = $fU->item(0))) {
            goto eH0;
        }
        $Nj = $oK->getAttribute("\x41\154\147\x6f\x72\x69\x74\150\155");
        eH0:
        $this->signedInfo = $this->canonicalizeData($d5, $Nj);
        return $this->signedInfo;
        fpL:
        Ttc:
        return null;
    }
    public function calculateDigest($It, $rL, $fq = true)
    {
        switch ($It) {
            case self::SHA1:
                $zO = "\163\x68\141\x31";
                goto WD3;
            case self::SHA256:
                $zO = "\163\150\141\62\x35\x36";
                goto WD3;
            case self::SHA384:
                $zO = "\x73\150\141\63\x38\x34";
                goto WD3;
            case self::SHA512:
                $zO = "\163\150\141\65\61\62";
                goto WD3;
            case self::RIPEMD160:
                $zO = "\x72\151\x70\145\155\x64\x31\x36\x30";
                goto WD3;
            default:
                throw new Exception("\x43\141\156\x6e\157\x74\x20\x76\x61\x6c\151\144\x61\x74\145\x20\144\151\147\145\x73\164\x3a\x20\125\x6e\163\165\160\x70\x6f\162\x74\145\x64\40\x41\154\147\157\162\151\x74\150\x6d\40\x3c{$It}\76");
        }
        o5Y:
        WD3:
        $BM = hash($zO, $rL, true);
        if (!$fq) {
            goto Hol;
        }
        $BM = base64_encode($BM);
        Hol:
        return $BM;
    }
    public function validateDigest($Lv, $rL)
    {
        $Cu = new DOMXPath($Lv->ownerDocument);
        $Cu->registerNamespace("\163\x65\143\x64\x73\151\x67", self::XMLDSIGNS);
        $ye = "\x73\164\x72\151\x6e\x67\50\56\x2f\x73\145\143\x64\163\151\x67\x3a\104\151\147\145\163\x74\x4d\145\164\x68\x6f\144\57\x40\x41\x6c\147\157\162\151\164\x68\155\51";
        $It = $Cu->evaluate($ye, $Lv);
        $ot = $this->calculateDigest($It, $rL, false);
        $ye = "\163\x74\162\151\x6e\x67\x28\x2e\x2f\x73\145\x63\x64\x73\151\147\x3a\x44\151\147\x65\x73\164\126\x61\x6c\165\x65\x29";
        $Bx = $Cu->evaluate($ye, $Lv);
        return $ot === base64_decode($Bx);
    }
    public function processTransforms($Lv, $Ak, $I_ = true)
    {
        $rL = $Ak;
        $Cu = new DOMXPath($Lv->ownerDocument);
        $Cu->registerNamespace("\x73\145\143\x64\x73\151\x67", self::XMLDSIGNS);
        $ye = "\x2e\x2f\x73\145\143\144\163\x69\147\x3a\124\x72\x61\x6e\163\x66\x6f\x72\x6d\x73\57\163\145\x63\144\163\x69\147\72\x54\162\141\x6e\163\x66\x6f\162\155";
        $hC = $Cu->query($ye, $Lv);
        $HG = "\150\x74\x74\x70\72\57\57\x77\x77\167\56\x77\63\x2e\157\x72\147\57\124\x52\57\x32\x30\60\x31\x2f\122\105\103\55\170\x6d\x6c\55\x63\x31\x34\x6e\55\62\x30\x30\61\x30\63\61\65";
        $Q9 = null;
        $Jl = null;
        foreach ($hC as $T7) {
            $RV = $T7->getAttribute("\x41\x6c\x67\x6f\x72\151\x74\x68\155");
            switch ($RV) {
                case "\150\x74\x74\x70\72\57\57\167\167\167\x2e\x77\63\x2e\157\x72\x67\57\62\60\60\x31\x2f\61\x30\x2f\x78\x6d\154\x2d\x65\x78\x63\55\x63\x31\64\156\43":
                case "\x68\x74\x74\160\72\x2f\57\167\x77\167\56\167\63\x2e\x6f\x72\x67\57\x32\60\60\x31\57\61\60\57\x78\155\154\55\145\170\143\55\x63\x31\x34\x6e\x23\127\x69\x74\150\103\x6f\155\x6d\x65\156\x74\163":
                    if (!$I_) {
                        goto Kfd;
                    }
                    $HG = $RV;
                    goto Edk;
                    Kfd:
                    $HG = "\x68\164\x74\160\x3a\x2f\x2f\167\167\x77\x2e\x77\63\x2e\x6f\162\x67\57\x32\x30\x30\x31\x2f\x31\x30\57\x78\x6d\x6c\x2d\x65\x78\143\x2d\x63\x31\x34\156\x23";
                    Edk:
                    $rf = $T7->firstChild;
                    OE1:
                    if (!$rf) {
                        goto r2N;
                    }
                    if (!($rf->localName == "\x49\x6e\143\x6c\x75\x73\151\166\x65\116\141\155\x65\163\x70\x61\143\145\x73")) {
                        goto hax;
                    }
                    if (!($r7 = $rf->getAttribute("\120\162\145\x66\151\x78\114\151\x73\x74"))) {
                        goto ZP2;
                    }
                    $Nx = array();
                    $SH = explode("\40", $r7);
                    foreach ($SH as $r7) {
                        $VK = trim($r7);
                        if (empty($VK)) {
                            goto eSk;
                        }
                        $Nx[] = $VK;
                        eSk:
                        bgS:
                    }
                    uSl:
                    if (!(count($Nx) > 0)) {
                        goto EmZ;
                    }
                    $Jl = $Nx;
                    EmZ:
                    ZP2:
                    goto r2N;
                    hax:
                    $rf = $rf->nextSibling;
                    goto OE1;
                    r2N:
                    goto CcS;
                case "\x68\164\x74\x70\72\x2f\x2f\x77\167\x77\56\x77\63\x2e\x6f\x72\x67\x2f\124\x52\x2f\x32\60\60\x31\x2f\x52\x45\103\55\170\x6d\x6c\x2d\143\61\x34\x6e\x2d\62\60\x30\x31\60\x33\61\x35":
                case "\150\x74\x74\160\x3a\57\x2f\x77\167\167\x2e\x77\63\56\x6f\x72\x67\57\124\x52\57\x32\60\x30\61\57\x52\x45\103\55\170\155\x6c\x2d\x63\x31\x34\x6e\x2d\62\x30\x30\61\x30\63\x31\x35\x23\x57\151\x74\150\x43\157\x6d\155\x65\156\x74\163":
                    if (!$I_) {
                        goto QfP;
                    }
                    $HG = $RV;
                    goto nCv;
                    QfP:
                    $HG = "\150\164\x74\x70\72\57\x2f\167\x77\167\56\167\x33\x2e\157\x72\147\57\124\122\x2f\x32\60\x30\61\x2f\122\105\x43\55\x78\x6d\154\x2d\x63\x31\64\x6e\x2d\62\x30\x30\x31\60\63\x31\65";
                    nCv:
                    goto CcS;
                case "\x68\x74\x74\160\72\x2f\x2f\x77\x77\x77\56\167\x33\56\x6f\x72\x67\x2f\124\x52\x2f\61\x39\x39\71\57\x52\x45\x43\55\170\x70\141\x74\150\x2d\x31\71\71\71\x31\61\61\x36":
                    $rf = $T7->firstChild;
                    kLX:
                    if (!$rf) {
                        goto Fsd;
                    }
                    if (!($rf->localName == "\130\120\x61\x74\x68")) {
                        goto IQq;
                    }
                    $Q9 = array();
                    $Q9["\x71\165\145\162\171"] = "\x28\56\57\x2f\56\x20\x7c\40\56\x2f\x2f\100\x2a\40\174\40\x2e\57\x2f\x6e\141\155\145\163\x70\141\x63\x65\x3a\72\x2a\51\133" . $rf->nodeValue . "\x5d";
                    $ca["\x6e\141\x6d\x65\163\160\141\143\x65\x73"] = array();
                    $H0 = $Cu->query("\56\57\x6e\141\155\145\163\160\141\143\x65\72\x3a\52", $rf);
                    foreach ($H0 as $OA) {
                        if (!($OA->localName != "\x78\x6d\x6c")) {
                            goto hRZ;
                        }
                        $Q9["\x6e\x61\155\x65\163\160\141\143\145\x73"][$OA->localName] = $OA->nodeValue;
                        hRZ:
                        Qug:
                    }
                    THw:
                    goto Fsd;
                    IQq:
                    $rf = $rf->nextSibling;
                    goto kLX;
                    Fsd:
                    goto CcS;
            }
            jjh:
            CcS:
            P95:
        }
        xyW:
        if (!$rL instanceof DOMNode) {
            goto wKJ;
        }
        $rL = $this->canonicalizeData($Ak, $HG, $Q9, $Jl);
        wKJ:
        return $rL;
    }
    public function processRefNode($Lv)
    {
        $Ye = null;
        $I_ = true;
        if ($Ue = $Lv->getAttribute("\x55\x52\111")) {
            goto ibn;
        }
        $I_ = false;
        $Ye = $Lv->ownerDocument;
        goto iwB;
        ibn:
        $WN = parse_url($Ue);
        if (!empty($WN["\x70\141\164\150"])) {
            goto UFE;
        }
        if ($wD = $WN["\146\x72\141\x67\155\145\156\164"]) {
            goto W1V;
        }
        $Ye = $Lv->ownerDocument;
        goto BCp;
        W1V:
        $I_ = false;
        $Rs = new DOMXPath($Lv->ownerDocument);
        if (!($this->idNS && is_array($this->idNS))) {
            goto xsf;
        }
        foreach ($this->idNS as $CV => $Tt) {
            $Rs->registerNamespace($CV, $Tt);
            ZJa:
        }
        Y1n:
        xsf:
        $Uq = "\100\111\x64\x3d\x22" . XPath::filterAttrValue($wD, XPath::DOUBLE_QUOTE) . "\42";
        if (!is_array($this->idKeys)) {
            goto NMS;
        }
        foreach ($this->idKeys as $TA) {
            $Uq .= "\40\x6f\162\40\x40" . XPath::filterAttrName($TA) . "\75\x22" . XPath::filterAttrValue($wD, XPath::DOUBLE_QUOTE) . "\42";
            MAJ:
        }
        jrf:
        NMS:
        $ye = "\57\57\x2a\133" . $Uq . "\135";
        $Ye = $Rs->query($ye)->item(0);
        BCp:
        UFE:
        iwB:
        $rL = $this->processTransforms($Lv, $Ye, $I_);
        if ($this->validateDigest($Lv, $rL)) {
            goto tTk;
        }
        return false;
        tTk:
        if (!$Ye instanceof DOMNode) {
            goto hE_;
        }
        if (!empty($wD)) {
            goto rMC;
        }
        $this->validatedNodes[] = $Ye;
        goto RPp;
        rMC:
        $this->validatedNodes[$wD] = $Ye;
        RPp:
        hE_:
        return true;
    }
    public function getRefNodeID($Lv)
    {
        if (!($Ue = $Lv->getAttribute("\125\x52\111"))) {
            goto MMH;
        }
        $WN = parse_url($Ue);
        if (!empty($WN["\x70\141\x74\x68"])) {
            goto XjE;
        }
        if (!($wD = $WN["\x66\162\x61\147\x6d\x65\156\x74"])) {
            goto dpx;
        }
        return $wD;
        dpx:
        XjE:
        MMH:
        return null;
    }
    public function getRefIDs()
    {
        $sT = array();
        $Cu = $this->getXPathObj();
        $ye = "\56\57\163\x65\143\144\163\x69\147\72\123\x69\x67\156\145\x64\x49\156\146\157\x2f\163\x65\x63\x64\163\x69\x67\x3a\x52\145\146\x65\x72\x65\x6e\143\x65";
        $fU = $Cu->query($ye, $this->sigNode);
        if (!($fU->length == 0)) {
            goto UCH;
        }
        throw new Exception("\x52\x65\x66\145\162\x65\156\x63\x65\40\156\x6f\144\145\x73\40\156\157\x74\x20\x66\x6f\165\156\x64");
        UCH:
        foreach ($fU as $Lv) {
            $sT[] = $this->getRefNodeID($Lv);
            ucC:
        }
        RQT:
        return $sT;
    }
    public function validateReference()
    {
        $Me = $this->sigNode->ownerDocument->documentElement;
        if ($Me->isSameNode($this->sigNode)) {
            goto Utu;
        }
        if (!($this->sigNode->parentNode != null)) {
            goto dxl;
        }
        $this->sigNode->parentNode->removeChild($this->sigNode);
        dxl:
        Utu:
        $Cu = $this->getXPathObj();
        $ye = "\56\57\163\x65\x63\x64\163\x69\147\72\123\x69\x67\156\x65\144\111\156\x66\157\x2f\163\x65\x63\x64\163\x69\147\x3a\122\145\146\x65\x72\145\156\x63\145";
        $fU = $Cu->query($ye, $this->sigNode);
        if (!($fU->length == 0)) {
            goto csi;
        }
        throw new Exception("\122\145\146\x65\x72\145\156\143\145\x20\x6e\x6f\144\x65\163\x20\156\157\164\40\x66\157\165\x6e\x64");
        csi:
        $this->validatedNodes = array();
        foreach ($fU as $Lv) {
            if ($this->processRefNode($Lv)) {
                goto pfD;
            }
            $this->validatedNodes = null;
            throw new Exception("\122\145\146\145\x72\145\x6e\143\x65\40\166\141\154\151\144\x61\x74\x69\157\156\40\146\x61\x69\x6c\x65\144");
            pfD:
            Uf2:
        }
        LER:
        return true;
    }
    private function addRefInternal($nk, $rf, $RV, $zI = null, $u8 = null)
    {
        $Qg = null;
        $n2 = null;
        $V2 = "\x49\x64";
        $vf = true;
        $HZ = false;
        if (!is_array($u8)) {
            goto FIK;
        }
        $Qg = empty($u8["\x70\162\x65\x66\151\x78"]) ? null : $u8["\160\x72\145\146\151\170"];
        $n2 = empty($u8["\160\x72\145\x66\151\170\137\156\x73"]) ? null : $u8["\160\162\145\146\x69\x78\x5f\x6e\x73"];
        $V2 = empty($u8["\151\144\137\156\141\x6d\x65"]) ? "\x49\144" : $u8["\x69\x64\x5f\x6e\x61\x6d\145"];
        $vf = !isset($u8["\157\x76\x65\x72\167\162\151\x74\145"]) ? true : (bool) $u8["\157\x76\145\x72\x77\162\x69\x74\145"];
        $HZ = !isset($u8["\x66\x6f\162\143\145\x5f\165\162\x69"]) ? false : (bool) $u8["\x66\x6f\162\x63\x65\137\165\162\x69"];
        FIK:
        $xq = $V2;
        if (empty($Qg)) {
            goto Fn3;
        }
        $xq = $Qg . "\x3a" . $xq;
        Fn3:
        $Lv = $this->createNewSignNode("\122\145\146\145\162\x65\156\x63\145");
        $nk->appendChild($Lv);
        if (!$rf instanceof DOMDocument) {
            goto iXU;
        }
        if ($HZ) {
            goto vuo;
        }
        goto Oty;
        iXU:
        $Ue = null;
        if ($vf) {
            goto fJ9;
        }
        $Ue = $n2 ? $rf->getAttributeNS($n2, $V2) : $rf->getAttribute($V2);
        fJ9:
        if (!empty($Ue)) {
            goto uZt;
        }
        $Ue = self::generateGUID();
        $rf->setAttributeNS($n2, $xq, $Ue);
        uZt:
        $Lv->setAttribute("\125\122\x49", "\43" . $Ue);
        goto Oty;
        vuo:
        $Lv->setAttribute("\x55\x52\x49", '');
        Oty:
        $Cf = $this->createNewSignNode("\124\162\141\156\163\146\x6f\x72\x6d\163");
        $Lv->appendChild($Cf);
        if (is_array($zI)) {
            goto waI;
        }
        if (!empty($this->canonicalMethod)) {
            goto Qa9;
        }
        goto c51;
        waI:
        foreach ($zI as $T7) {
            $tL = $this->createNewSignNode("\x54\x72\141\156\x73\x66\157\x72\155");
            $Cf->appendChild($tL);
            if (is_array($T7) && !empty($T7["\150\164\x74\x70\x3a\x2f\x2f\x77\167\167\x2e\x77\x33\56\x6f\x72\147\x2f\124\x52\57\61\x39\71\x39\57\x52\x45\103\x2d\x78\x70\141\164\150\x2d\61\x39\x39\71\61\x31\61\x36"]) && !empty($T7["\x68\164\164\160\72\57\x2f\167\167\x77\56\167\63\56\x6f\162\147\x2f\x54\x52\57\x31\x39\71\71\x2f\122\105\x43\x2d\x78\160\x61\164\x68\x2d\61\71\71\x39\61\x31\61\66"]["\161\165\145\x72\x79"])) {
                goto YJ0;
            }
            $tL->setAttribute("\101\154\147\157\162\151\164\x68\155", $T7);
            goto LWf;
            YJ0:
            $tL->setAttribute("\x41\x6c\x67\x6f\x72\151\x74\x68\x6d", "\x68\x74\164\x70\x3a\x2f\57\x77\x77\x77\56\167\63\56\157\x72\x67\57\x54\122\x2f\x31\71\71\x39\57\x52\105\103\55\x78\160\x61\164\x68\55\61\x39\x39\x39\61\x31\61\66");
            $WJ = $this->createNewSignNode("\x58\120\141\x74\x68", $T7["\x68\x74\164\x70\x3a\x2f\57\167\167\x77\x2e\167\63\x2e\157\x72\147\57\x54\122\57\x31\x39\x39\x39\x2f\x52\x45\103\55\x78\160\141\164\x68\55\61\x39\71\x39\x31\x31\x31\66"]["\x71\165\145\x72\171"]);
            $tL->appendChild($WJ);
            if (empty($T7["\x68\x74\164\160\x3a\x2f\57\x77\x77\x77\56\x77\x33\56\157\162\147\x2f\x54\122\x2f\x31\71\x39\71\x2f\x52\x45\103\x2d\x78\x70\141\164\x68\55\x31\x39\x39\71\x31\61\x31\x36"]["\156\x61\x6d\x65\x73\160\141\x63\145\x73"])) {
                goto QPE;
            }
            foreach ($T7["\x68\164\x74\x70\72\57\x2f\167\167\x77\x2e\x77\x33\56\x6f\162\147\x2f\124\x52\57\x31\71\71\71\x2f\122\x45\103\55\x78\160\141\164\x68\55\x31\x39\71\71\x31\61\61\x36"]["\x6e\141\155\x65\x73\x70\141\x63\x65\x73"] as $Qg => $j4) {
                $WJ->setAttributeNS("\x68\164\x74\x70\72\57\x2f\x77\x77\x77\x2e\x77\63\56\x6f\x72\147\57\62\60\60\60\57\170\155\154\156\x73\57", "\170\x6d\x6c\156\x73\x3a{$Qg}", $j4);
                f4o:
            }
            o2Y:
            QPE:
            LWf:
            wrG:
        }
        GG9:
        goto c51;
        Qa9:
        $tL = $this->createNewSignNode("\124\162\x61\x6e\163\146\x6f\162\155");
        $Cf->appendChild($tL);
        $tL->setAttribute("\x41\x6c\x67\157\x72\x69\164\x68\155", $this->canonicalMethod);
        c51:
        $cB = $this->processTransforms($Lv, $rf);
        $ot = $this->calculateDigest($RV, $cB);
        $k5 = $this->createNewSignNode("\104\x69\147\x65\x73\x74\x4d\145\x74\150\x6f\x64");
        $Lv->appendChild($k5);
        $k5->setAttribute("\101\x6c\x67\x6f\162\x69\x74\x68\155", $RV);
        $Bx = $this->createNewSignNode("\x44\151\147\x65\x73\164\x56\x61\x6c\x75\145", $ot);
        $Lv->appendChild($Bx);
    }
    public function addReference($rf, $RV, $zI = null, $u8 = null)
    {
        if (!($Cu = $this->getXPathObj())) {
            goto XuO;
        }
        $ye = "\x2e\x2f\163\145\143\144\163\151\147\72\123\x69\147\156\x65\144\x49\156\146\157";
        $fU = $Cu->query($ye, $this->sigNode);
        if (!($Nd = $fU->item(0))) {
            goto QwU;
        }
        $this->addRefInternal($Nd, $rf, $RV, $zI, $u8);
        QwU:
        XuO:
    }
    public function addReferenceList($RX, $RV, $zI = null, $u8 = null)
    {
        if (!($Cu = $this->getXPathObj())) {
            goto Y57;
        }
        $ye = "\56\x2f\163\145\x63\x64\x73\151\x67\x3a\x53\151\x67\156\x65\x64\x49\156\146\157";
        $fU = $Cu->query($ye, $this->sigNode);
        if (!($Nd = $fU->item(0))) {
            goto ZMy;
        }
        foreach ($RX as $rf) {
            $this->addRefInternal($Nd, $rf, $RV, $zI, $u8);
            B8f:
        }
        zkb:
        ZMy:
        Y57:
    }
    public function addObject($rL, $FV = null, $hs = null)
    {
        $KW = $this->createNewSignNode("\117\x62\x6a\x65\x63\164");
        $this->sigNode->appendChild($KW);
        if (empty($FV)) {
            goto Evl;
        }
        $KW->setAttribute("\x4d\151\x6d\x65\x54\171\160\x65", $FV);
        Evl:
        if (empty($hs)) {
            goto uCd;
        }
        $KW->setAttribute("\x45\x6e\x63\157\x64\151\156\x67", $hs);
        uCd:
        if ($rL instanceof DOMElement) {
            goto hGv;
        }
        $w2 = $this->sigNode->ownerDocument->createTextNode($rL);
        goto Dll;
        hGv:
        $w2 = $this->sigNode->ownerDocument->importNode($rL, true);
        Dll:
        $KW->appendChild($w2);
        return $KW;
    }
    public function locateKey($rf = null)
    {
        if (!empty($rf)) {
            goto l3q;
        }
        $rf = $this->sigNode;
        l3q:
        if ($rf instanceof DOMNode) {
            goto I7R;
        }
        return null;
        I7R:
        if (!($Yf = $rf->ownerDocument)) {
            goto V_Q;
        }
        $Cu = new DOMXPath($Yf);
        $Cu->registerNamespace("\x73\x65\x63\x64\x73\x69\x67", self::XMLDSIGNS);
        $ye = "\163\164\162\151\156\x67\50\56\x2f\163\x65\143\x64\163\151\x67\x3a\x53\x69\x67\156\x65\x64\111\156\146\x6f\x2f\x73\145\143\x64\163\151\147\x3a\123\x69\147\x6e\141\x74\165\x72\145\115\x65\x74\150\157\144\x2f\100\x41\154\x67\x6f\162\x69\164\x68\x6d\x29";
        $RV = $Cu->evaluate($ye, $rf);
        if (!$RV) {
            goto jBL;
        }
        try {
            $In = new XMLSecurityKey($RV, array("\164\x79\x70\145" => "\x70\x75\142\x6c\x69\x63"));
        } catch (Exception $A4) {
            return null;
        }
        return $In;
        jBL:
        V_Q:
        return null;
    }
    public function verify($In)
    {
        $Yf = $this->sigNode->ownerDocument;
        $Cu = new DOMXPath($Yf);
        $Cu->registerNamespace("\163\x65\x63\x64\163\x69\147", self::XMLDSIGNS);
        $ye = "\x73\164\x72\x69\156\147\50\56\57\163\145\x63\x64\x73\x69\147\72\123\151\147\156\x61\x74\165\x72\x65\126\141\x6c\x75\x65\x29";
        $ul = $Cu->evaluate($ye, $this->sigNode);
        if (!empty($ul)) {
            goto R7f;
        }
        throw new Exception("\x55\x6e\x61\142\154\x65\x20\x74\x6f\40\154\x6f\x63\x61\164\145\x20\123\x69\x67\x6e\x61\164\165\162\145\x56\141\x6c\165\x65");
        R7f:
        return $In->verifySignature($this->signedInfo, base64_decode($ul));
    }
    public function signData($In, $rL)
    {
        return $In->signData($rL);
    }
    public function sign($In, $W1 = null)
    {
        if (!($W1 != null)) {
            goto oPy;
        }
        $this->resetXPathObj();
        $this->appendSignature($W1);
        $this->sigNode = $W1->lastChild;
        oPy:
        if (!($Cu = $this->getXPathObj())) {
            goto mbV;
        }
        $ye = "\x2e\57\163\x65\143\x64\x73\x69\x67\72\123\151\147\x6e\145\144\x49\x6e\146\x6f";
        $fU = $Cu->query($ye, $this->sigNode);
        if (!($Nd = $fU->item(0))) {
            goto fyZ;
        }
        $ye = "\x2e\x2f\163\x65\143\x64\x73\x69\147\x3a\123\151\x67\x6e\141\164\x75\x72\x65\x4d\145\x74\x68\x6f\144";
        $fU = $Cu->query($ye, $Nd);
        $fQ = $fU->item(0);
        $fQ->setAttribute("\x41\154\147\157\162\151\x74\150\155", $In->type);
        $rL = $this->canonicalizeData($Nd, $this->canonicalMethod);
        $ul = base64_encode($this->signData($In, $rL));
        $qm = $this->createNewSignNode("\x53\151\x67\156\141\x74\165\162\145\x56\141\154\x75\145", $ul);
        if ($NP = $Nd->nextSibling) {
            goto DKo;
        }
        $this->sigNode->appendChild($qm);
        goto ygo;
        DKo:
        $NP->parentNode->insertBefore($qm, $NP);
        ygo:
        fyZ:
        mbV:
    }
    public function appendCert()
    {
    }
    public function appendKey($In, $ME = null)
    {
        $In->serializeKey($ME);
    }
    public function insertSignature($rf, $MI = null)
    {
        $BE = $rf->ownerDocument;
        $EN = $BE->importNode($this->sigNode, true);
        if ($MI == null) {
            goto bMw;
        }
        return $rf->insertBefore($EN, $MI);
        goto N3A;
        bMw:
        return $rf->insertBefore($EN);
        N3A:
    }
    public function appendSignature($u3, $cd = false)
    {
        $MI = $cd ? $u3->firstChild : null;
        return $this->insertSignature($u3, $MI);
    }
    public static function get509XCert($wA, $L2 = true)
    {
        $al = self::staticGet509XCerts($wA, $L2);
        if (empty($al)) {
            goto vGq;
        }
        return $al[0];
        vGq:
        return '';
    }
    public static function staticGet509XCerts($al, $L2 = true)
    {
        if ($L2) {
            goto oM0;
        }
        return array($al);
        goto xuq;
        oM0:
        $rL = '';
        $aw = array();
        $iu = explode("\12", $al);
        $fw = false;
        foreach ($iu as $t_) {
            if (!$fw) {
                goto dbi;
            }
            if (!(strncmp($t_, "\x2d\x2d\x2d\x2d\55\x45\116\104\x20\x43\105\x52\124\x49\106\111\x43\101\x54\x45", 20) == 0)) {
                goto NxA;
            }
            $fw = false;
            $aw[] = $rL;
            $rL = '';
            goto g5T;
            NxA:
            $rL .= trim($t_);
            goto iGQ;
            dbi:
            if (!(strncmp($t_, "\55\x2d\55\55\55\102\x45\x47\x49\116\x20\103\105\x52\124\111\x46\x49\103\101\124\x45", 22) == 0)) {
                goto oA4;
            }
            $fw = true;
            oA4:
            iGQ:
            g5T:
        }
        LSm:
        return $aw;
        xuq:
    }
    public static function staticAdd509Cert($D0, $wA, $L2 = true, $tW = false, $Cu = null, $u8 = null)
    {
        if (!$tW) {
            goto pVh;
        }
        $wA = file_get_contents($wA);
        pVh:
        if ($D0 instanceof DOMElement) {
            goto D2C;
        }
        throw new Exception("\x49\156\x76\141\154\151\144\x20\x70\141\x72\x65\156\x74\40\116\157\144\x65\40\160\141\162\x61\x6d\145\x74\145\162");
        D2C:
        $yN = $D0->ownerDocument;
        if (!empty($Cu)) {
            goto SJB;
        }
        $Cu = new DOMXPath($D0->ownerDocument);
        $Cu->registerNamespace("\x73\x65\143\144\163\151\147", self::XMLDSIGNS);
        SJB:
        $ye = "\56\57\x73\145\x63\144\163\x69\147\x3a\113\145\x79\111\156\146\x6f";
        $fU = $Cu->query($ye, $D0);
        $qf = $fU->item(0);
        $x3 = '';
        if (!$qf) {
            goto dUM;
        }
        $r7 = $qf->lookupPrefix(self::XMLDSIGNS);
        if (empty($r7)) {
            goto gcn;
        }
        $x3 = $r7 . "\x3a";
        gcn:
        goto aJH;
        dUM:
        $r7 = $D0->lookupPrefix(self::XMLDSIGNS);
        if (empty($r7)) {
            goto H4Y;
        }
        $x3 = $r7 . "\72";
        H4Y:
        $Yw = false;
        $qf = $yN->createElementNS(self::XMLDSIGNS, $x3 . "\113\145\x79\x49\x6e\146\157");
        $ye = "\x2e\x2f\163\x65\x63\x64\x73\x69\147\x3a\x4f\142\x6a\x65\143\164";
        $fU = $Cu->query($ye, $D0);
        if (!($ej = $fU->item(0))) {
            goto Jt8;
        }
        $ej->parentNode->insertBefore($qf, $ej);
        $Yw = true;
        Jt8:
        if ($Yw) {
            goto yb3;
        }
        $D0->appendChild($qf);
        yb3:
        aJH:
        $al = self::staticGet509XCerts($wA, $L2);
        $yt = $yN->createElementNS(self::XMLDSIGNS, $x3 . "\x58\65\x30\71\104\141\164\x61");
        $qf->appendChild($yt);
        $N3 = false;
        $n5 = false;
        if (!is_array($u8)) {
            goto hhe;
        }
        if (empty($u8["\x69\163\x73\165\145\x72\123\145\x72\151\x61\x6c"])) {
            goto j8p;
        }
        $N3 = true;
        j8p:
        if (empty($u8["\x73\x75\x62\152\145\x63\x74\x4e\x61\155\145"])) {
            goto bTF;
        }
        $n5 = true;
        bTF:
        hhe:
        foreach ($al as $x5) {
            if (!($N3 || $n5)) {
                goto d7P;
            }
            if (!($Ej = openssl_x509_parse("\55\55\x2d\55\x2d\x42\105\x47\111\x4e\40\103\x45\122\x54\x49\x46\111\x43\101\124\105\55\55\x2d\55\55\xa" . chunk_split($x5, 64, "\12") . "\55\x2d\55\x2d\55\105\x4e\x44\40\x43\105\x52\124\x49\x46\111\x43\x41\124\x45\55\x2d\x2d\x2d\55\xa"))) {
                goto n21;
            }
            if (!($n5 && !empty($Ej["\163\165\142\x6a\145\143\164"]))) {
                goto Cy9;
            }
            if (is_array($Ej["\x73\165\x62\152\145\143\x74"])) {
                goto Jze;
            }
            $cX = $Ej["\151\x73\163\x75\x65\162"];
            goto K2u;
            Jze:
            $e1 = array();
            foreach ($Ej["\163\x75\142\x6a\145\x63\x74"] as $ld => $g2) {
                if (is_array($g2)) {
                    goto rrX;
                }
                array_unshift($e1, "{$ld}\75{$g2}");
                goto aaR;
                rrX:
                foreach ($g2 as $wW) {
                    array_unshift($e1, "{$ld}\75{$wW}");
                    GCO:
                }
                Ot7:
                aaR:
                ODo1:
            }
            qJ7:
            $cX = implode("\x2c", $e1);
            K2u:
            $pR = $yN->createElementNS(self::XMLDSIGNS, $x3 . "\130\x35\60\71\123\x75\x62\x6a\x65\x63\x74\116\x61\x6d\x65", $cX);
            $yt->appendChild($pR);
            Cy9:
            if (!($N3 && !empty($Ej["\x69\x73\x73\x75\145\162"]) && !empty($Ej["\x73\145\x72\x69\141\154\116\165\155\x62\x65\162"]))) {
                goto XBA;
            }
            if (is_array($Ej["\x69\163\x73\x75\x65\162"])) {
                goto rdw;
            }
            $aM = $Ej["\x69\x73\x73\165\x65\x72"];
            goto B13;
            rdw:
            $e1 = array();
            foreach ($Ej["\x69\163\x73\x75\x65\x72"] as $ld => $g2) {
                array_unshift($e1, "{$ld}\x3d{$g2}");
                pr9:
            }
            sxt:
            $aM = implode("\54", $e1);
            B13:
            $En = $yN->createElementNS(self::XMLDSIGNS, $x3 . "\130\x35\60\71\x49\x73\163\x75\x65\162\123\145\162\x69\x61\154");
            $yt->appendChild($En);
            $me = $yN->createElementNS(self::XMLDSIGNS, $x3 . "\x58\65\x30\x39\111\163\x73\x75\x65\162\116\x61\x6d\x65", $aM);
            $En->appendChild($me);
            $me = $yN->createElementNS(self::XMLDSIGNS, $x3 . "\130\65\x30\x39\x53\x65\x72\x69\141\154\116\165\x6d\142\145\x72", $Ej["\163\x65\x72\x69\x61\154\116\x75\155\x62\x65\x72"]);
            $En->appendChild($me);
            XBA:
            n21:
            d7P:
            $wo = $yN->createElementNS(self::XMLDSIGNS, $x3 . "\x58\65\x30\x39\103\145\x72\x74\x69\146\x69\143\x61\164\x65", $x5);
            $yt->appendChild($wo);
            Yuj:
        }
        XdO1:
    }
    public function add509Cert($wA, $L2 = true, $tW = false, $u8 = null)
    {
        if (!($Cu = $this->getXPathObj())) {
            goto HF2;
        }
        self::staticAdd509Cert($this->sigNode, $wA, $L2, $tW, $Cu, $u8);
        HF2:
    }
    public function appendToKeyInfo($rf)
    {
        $D0 = $this->sigNode;
        $yN = $D0->ownerDocument;
        $Cu = $this->getXPathObj();
        if (!empty($Cu)) {
            goto Q08;
        }
        $Cu = new DOMXPath($D0->ownerDocument);
        $Cu->registerNamespace("\163\145\x63\144\x73\x69\147", self::XMLDSIGNS);
        Q08:
        $ye = "\56\57\x73\x65\143\144\163\151\x67\x3a\x4b\145\171\x49\156\x66\157";
        $fU = $Cu->query($ye, $D0);
        $qf = $fU->item(0);
        if ($qf) {
            goto FS4;
        }
        $x3 = '';
        $r7 = $D0->lookupPrefix(self::XMLDSIGNS);
        if (empty($r7)) {
            goto QNv;
        }
        $x3 = $r7 . "\x3a";
        QNv:
        $Yw = false;
        $qf = $yN->createElementNS(self::XMLDSIGNS, $x3 . "\x4b\x65\x79\x49\156\146\157");
        $ye = "\56\x2f\x73\145\143\144\163\x69\147\72\117\x62\152\145\143\x74";
        $fU = $Cu->query($ye, $D0);
        if (!($ej = $fU->item(0))) {
            goto b5O;
        }
        $ej->parentNode->insertBefore($qf, $ej);
        $Yw = true;
        b5O:
        if ($Yw) {
            goto Ack;
        }
        $D0->appendChild($qf);
        Ack:
        FS4:
        $qf->appendChild($rf);
        return $qf;
    }
    public function getValidatedNodes()
    {
        return $this->validatedNodes;
    }
}
