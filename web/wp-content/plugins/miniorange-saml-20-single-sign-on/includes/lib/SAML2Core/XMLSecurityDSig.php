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
    const XMLDSIGNS = "\x68\x74\164\x70\x3a\x2f\57\x77\167\x77\56\167\x33\56\157\162\147\x2f\62\x30\x30\x30\x2f\x30\71\x2f\x78\x6d\x6c\144\163\151\x67\x23";
    const SHA1 = "\x68\164\x74\x70\72\57\x2f\x77\167\167\x2e\x77\63\56\157\162\147\x2f\x32\x30\x30\x30\57\60\x39\x2f\x78\155\154\144\163\151\x67\x23\163\150\141\61";
    const SHA256 = "\x68\x74\164\x70\x3a\57\x2f\167\x77\167\x2e\167\x33\x2e\157\162\147\x2f\x32\60\60\x31\x2f\x30\x34\57\x78\x6d\154\x65\156\143\x23\163\x68\141\x32\65\66";
    const SHA384 = "\150\x74\164\160\x3a\x2f\x2f\167\167\167\56\x77\x33\56\157\162\147\x2f\x32\60\60\x31\57\x30\x34\x2f\170\x6d\x6c\144\163\x69\147\55\x6d\157\x72\145\x23\163\150\141\x33\x38\x34";
    const SHA512 = "\150\164\164\160\72\57\x2f\x77\167\167\56\x77\63\x2e\x6f\x72\x67\x2f\62\x30\60\x31\57\60\x34\x2f\170\x6d\x6c\145\x6e\143\43\x73\x68\x61\65\x31\x32";
    const RIPEMD160 = "\150\164\164\160\x3a\57\x2f\167\x77\x77\56\167\x33\56\157\x72\x67\x2f\x32\60\x30\61\57\60\64\57\x78\x6d\x6c\145\156\x63\43\162\x69\x70\145\155\x64\61\x36\60";
    const C14N = "\x68\164\164\x70\72\x2f\57\167\167\x77\56\167\x33\56\x6f\162\x67\57\124\122\x2f\x32\x30\x30\x31\57\x52\105\103\x2d\170\x6d\x6c\x2d\143\x31\64\x6e\x2d\x32\60\60\x31\x30\x33\x31\65";
    const C14N_COMMENTS = "\150\164\x74\x70\72\57\57\x77\x77\167\x2e\167\63\x2e\x6f\162\147\x2f\124\x52\57\x32\x30\60\61\57\x52\x45\x43\55\170\x6d\154\x2d\143\x31\x34\156\55\62\x30\x30\61\60\63\x31\65\43\x57\x69\x74\150\x43\157\155\155\145\x6e\164\163";
    const EXC_C14N = "\150\164\164\160\72\57\57\x77\167\167\56\167\63\56\x6f\x72\x67\x2f\x32\x30\60\x31\57\61\x30\x2f\170\x6d\154\55\145\170\x63\55\143\x31\64\x6e\43";
    const EXC_C14N_COMMENTS = "\x68\x74\x74\x70\x3a\57\x2f\167\167\167\56\x77\x33\x2e\x6f\162\147\x2f\62\x30\60\x31\x2f\61\x30\57\170\x6d\154\x2d\145\x78\x63\x2d\x63\61\x34\156\43\x57\151\x74\150\103\157\155\x6d\x65\156\164\163";
    const template = "\x3c\x64\x73\x3a\123\x69\x67\156\x61\x74\x75\162\x65\40\x78\x6d\x6c\x6e\163\72\x64\x73\x3d\42\150\x74\164\160\72\57\x2f\x77\167\x77\56\167\63\56\157\162\147\x2f\62\60\60\60\57\x30\x39\57\x78\155\154\144\163\x69\x67\43\x22\76\xd\xa\40\x20\x3c\x64\x73\x3a\123\151\x67\x6e\x65\x64\x49\x6e\146\157\x3e\xd\12\x20\x20\40\x20\x3c\x64\163\72\123\151\147\156\x61\164\165\x72\x65\x4d\145\x74\x68\x6f\x64\x20\x2f\x3e\xd\12\x20\40\74\57\x64\163\x3a\123\x69\147\x6e\145\x64\111\x6e\x66\x6f\x3e\15\xa\74\x2f\144\x73\x3a\x53\x69\147\156\x61\x74\x75\x72\145\x3e";
    const BASE_TEMPLATE = "\x3c\123\151\x67\x6e\141\x74\x75\162\x65\40\x78\155\154\156\x73\75\42\150\164\164\x70\72\57\57\167\167\x77\56\x77\63\56\157\x72\x67\57\62\x30\60\x30\57\60\x39\57\170\x6d\x6c\144\163\151\147\43\42\x3e\xd\xa\x20\x20\74\x53\x69\x67\156\145\144\x49\156\146\x6f\x3e\15\xa\40\x20\x20\x20\x3c\x53\151\147\x6e\x61\x74\x75\162\145\115\145\x74\150\157\x64\40\x2f\x3e\15\12\40\40\74\x2f\x53\x69\147\156\x65\144\111\156\x66\157\x3e\xd\12\x3c\57\123\x69\147\x6e\141\164\165\x72\x65\76";
    public $sigNode = null;
    public $idKeys = array();
    public $idNS = array();
    private $signedInfo = null;
    private $xPathCtx = null;
    private $canonicalMethod = null;
    private $prefix = '';
    private $searchpfx = "\x73\145\x63\144\x73\151\x67";
    private $validatedNodes = null;
    public function __construct($TL = "\144\x73")
    {
        $pI = self::BASE_TEMPLATE;
        if (empty($TL)) {
            goto sZ;
        }
        $this->prefix = $TL . "\x3a";
        $CC = array("\74\x53", "\x3c\57\123", "\x78\155\154\156\163\x3d");
        $Qn = array("\x3c{$TL}\x3a\x53", "\x3c\x2f{$TL}\x3a\x53", "\x78\x6d\154\156\163\x3a{$TL}\75");
        $pI = str_replace($CC, $Qn, $pI);
        sZ:
        $ph = new DOMDocument();
        $ph->loadXML($pI);
        $this->sigNode = $ph->documentElement;
    }
    private function resetXPathObj()
    {
        $this->xPathCtx = null;
    }
    private function getXPathObj()
    {
        if (!(empty($this->xPathCtx) && !empty($this->sigNode))) {
            goto zv;
        }
        $K_ = new DOMXPath($this->sigNode->ownerDocument);
        $K_->registerNamespace("\163\145\143\144\x73\151\147", self::XMLDSIGNS);
        $this->xPathCtx = $K_;
        zv:
        return $this->xPathCtx;
    }
    public static function generateGUID($TL = "\x70\x66\170")
    {
        $UQ = md5(uniqid(mt_rand(), true));
        $CY = $TL . substr($UQ, 0, 8) . "\55" . substr($UQ, 8, 4) . "\55" . substr($UQ, 12, 4) . "\55" . substr($UQ, 16, 4) . "\55" . substr($UQ, 20, 12);
        return $CY;
    }
    public static function generate_GUID($TL = "\x70\146\170")
    {
        return self::generateGUID($TL);
    }
    public function locateSignature($S2, $nm = 0)
    {
        if ($S2 instanceof DOMDocument) {
            goto xH;
        }
        $wP = $S2->ownerDocument;
        goto Sc;
        xH:
        $wP = $S2;
        Sc:
        if (!$wP) {
            goto jE;
        }
        $K_ = new DOMXPath($wP);
        $K_->registerNamespace("\x73\145\143\144\x73\151\x67", self::XMLDSIGNS);
        $jz = "\56\57\x2f\x73\145\143\144\x73\x69\147\72\123\151\x67\156\x61\x74\165\x72\145";
        $L5 = $K_->query($jz, $S2);
        $this->sigNode = $L5->item($nm);
        return $this->sigNode;
        jE:
        return null;
    }
    public function createNewSignNode($XE, $Ka = null)
    {
        $wP = $this->sigNode->ownerDocument;
        if (!is_null($Ka)) {
            goto dM;
        }
        $Dg = $wP->createElementNS(self::XMLDSIGNS, $this->prefix . $XE);
        goto aI;
        dM:
        $Dg = $wP->createElementNS(self::XMLDSIGNS, $this->prefix . $XE, $Ka);
        aI:
        return $Dg;
    }
    public function setCanonicalMethod($Vp)
    {
        switch ($Vp) {
            case "\x68\x74\164\160\x3a\57\x2f\167\x77\167\56\x77\x33\56\157\162\x67\x2f\x54\122\57\62\60\60\x31\x2f\x52\x45\x43\x2d\x78\155\x6c\55\143\x31\64\156\x2d\62\60\x30\61\60\x33\61\x35":
            case "\x68\x74\164\x70\72\57\x2f\x77\x77\167\x2e\167\63\56\157\x72\x67\x2f\x54\122\57\62\x30\x30\x31\x2f\x52\105\x43\x2d\x78\x6d\154\55\143\61\x34\156\x2d\62\60\60\x31\x30\x33\x31\65\x23\127\x69\x74\x68\x43\x6f\x6d\x6d\x65\156\x74\x73":
            case "\x68\x74\164\160\72\x2f\57\x77\167\167\x2e\167\x33\x2e\157\x72\x67\x2f\62\x30\60\x31\x2f\61\x30\57\x78\155\154\55\x65\170\143\x2d\x63\61\x34\156\43":
            case "\x68\x74\164\160\x3a\x2f\57\167\167\167\56\x77\63\56\157\162\147\x2f\x32\60\60\x31\x2f\x31\60\57\x78\155\154\55\x65\x78\x63\x2d\143\61\64\x6e\x23\127\x69\x74\150\x43\x6f\155\x6d\x65\x6e\164\x73":
                $this->canonicalMethod = $Vp;
                goto ri;
            default:
                throw new Exception("\111\156\166\x61\x6c\x69\x64\x20\x43\141\x6e\157\156\x69\x63\x61\154\x20\115\x65\x74\x68\x6f\x64");
        }
        Iu:
        ri:
        if (!($K_ = $this->getXPathObj())) {
            goto AV;
        }
        $jz = "\56\x2f" . $this->searchpfx . "\x3a\123\x69\147\156\x65\144\x49\x6e\146\157";
        $L5 = $K_->query($jz, $this->sigNode);
        if (!($EN = $L5->item(0))) {
            goto Nk;
        }
        $jz = "\x2e\x2f" . $this->searchpfx . "\103\141\x6e\157\x6e\151\143\x61\x6c\x69\172\x61\x74\x69\157\156\115\x65\164\x68\157\144";
        $L5 = $K_->query($jz, $EN);
        if ($sy = $L5->item(0)) {
            goto AY;
        }
        $sy = $this->createNewSignNode("\x43\x61\156\157\x6e\x69\143\141\x6c\151\x7a\x61\x74\151\157\x6e\x4d\x65\x74\x68\157\144");
        $EN->insertBefore($sy, $EN->firstChild);
        AY:
        $sy->setAttribute("\x41\x6c\147\x6f\162\x69\164\x68\x6d", $this->canonicalMethod);
        Nk:
        AV:
    }
    private function canonicalizeData($Dg, $pm, $Mk = null, $a2 = null)
    {
        $es = false;
        $ha = false;
        switch ($pm) {
            case "\150\164\164\x70\x3a\x2f\57\167\167\x77\x2e\x77\63\x2e\157\x72\147\57\124\122\x2f\62\x30\60\x31\57\122\x45\x43\x2d\x78\155\x6c\x2d\x63\x31\x34\156\x2d\62\x30\x30\61\x30\x33\x31\x35":
                $es = false;
                $ha = false;
                goto KF;
            case "\x68\x74\x74\160\x3a\x2f\57\x77\167\x77\x2e\x77\63\56\x6f\x72\x67\x2f\124\122\x2f\62\60\60\x31\57\x52\105\103\55\170\155\x6c\55\143\x31\x34\156\55\62\60\x30\61\x30\x33\x31\65\x23\127\151\164\150\103\x6f\155\155\145\156\x74\163":
                $ha = true;
                goto KF;
            case "\x68\x74\164\x70\x3a\x2f\x2f\x77\167\x77\56\167\x33\x2e\157\162\147\57\62\x30\60\61\57\61\60\x2f\x78\155\154\x2d\145\170\x63\x2d\143\x31\64\x6e\43":
                $es = true;
                goto KF;
            case "\x68\164\x74\x70\x3a\x2f\57\167\x77\167\56\x77\63\x2e\157\162\x67\57\x32\x30\x30\x31\57\x31\x30\57\170\x6d\x6c\55\x65\x78\143\55\143\x31\64\x6e\43\x57\151\x74\x68\x43\x6f\x6d\x6d\x65\x6e\x74\x73":
                $es = true;
                $ha = true;
                goto KF;
        }
        cp:
        KF:
        if (!(is_null($Mk) && $Dg instanceof DOMNode && $Dg->ownerDocument !== null && $Dg->isSameNode($Dg->ownerDocument->documentElement))) {
            goto FU;
        }
        $j2 = $Dg;
        xq:
        if (!($Aw = $j2->previousSibling)) {
            goto Cv;
        }
        if (!($Aw->nodeType == XML_PI_NODE || $Aw->nodeType == XML_COMMENT_NODE && $ha)) {
            goto xP;
        }
        goto Cv;
        xP:
        $j2 = $Aw;
        goto xq;
        Cv:
        if (!($Aw == null)) {
            goto B2;
        }
        $Dg = $Dg->ownerDocument;
        B2:
        FU:
        return $Dg->C14N($es, $ha, $Mk, $a2);
    }
    public function canonicalizeSignedInfo()
    {
        $wP = $this->sigNode->ownerDocument;
        $pm = null;
        if (!$wP) {
            goto p4;
        }
        $K_ = $this->getXPathObj();
        $jz = "\x2e\x2f\163\145\143\144\163\151\147\72\x53\151\x67\x6e\145\144\111\x6e\x66\157";
        $L5 = $K_->query($jz, $this->sigNode);
        if (!($NS = $L5->item(0))) {
            goto kS;
        }
        $jz = "\x2e\x2f\x73\x65\143\144\x73\x69\x67\x3a\103\x61\156\157\x6e\x69\143\141\154\x69\x7a\x61\x74\x69\x6f\156\115\x65\164\x68\x6f\144";
        $L5 = $K_->query($jz, $NS);
        if (!($sy = $L5->item(0))) {
            goto Xu;
        }
        $pm = $sy->getAttribute("\101\x6c\147\x6f\162\x69\x74\x68\x6d");
        Xu:
        $this->signedInfo = $this->canonicalizeData($NS, $pm);
        return $this->signedInfo;
        kS:
        p4:
        return null;
    }
    public function calculateDigest($p3, $uY, $My = true)
    {
        switch ($p3) {
            case self::SHA1:
                $PQ = "\x73\150\x61\61";
                goto eG;
            case self::SHA256:
                $PQ = "\163\150\141\x32\65\66";
                goto eG;
            case self::SHA384:
                $PQ = "\163\150\x61\x33\x38\64";
                goto eG;
            case self::SHA512:
                $PQ = "\163\150\141\x35\61\62";
                goto eG;
            case self::RIPEMD160:
                $PQ = "\x72\x69\160\x65\x6d\144\61\66\x30";
                goto eG;
            default:
                throw new Exception("\x43\141\156\x6e\157\164\x20\x76\x61\x6c\x69\x64\x61\x74\x65\x20\144\x69\x67\x65\x73\x74\72\40\125\156\163\x75\x70\160\x6f\x72\x74\145\144\40\x41\154\147\x6f\x72\x69\x74\150\x6d\40\x3c{$p3}\76");
        }
        ji:
        eG:
        $cz = hash($PQ, $uY, true);
        if (!$My) {
            goto ch;
        }
        $cz = base64_encode($cz);
        ch:
        return $cz;
    }
    public function validateDigest($GZ, $uY)
    {
        $K_ = new DOMXPath($GZ->ownerDocument);
        $K_->registerNamespace("\163\x65\x63\x64\x73\x69\x67", self::XMLDSIGNS);
        $jz = "\163\164\162\x69\x6e\x67\x28\x2e\x2f\163\145\143\x64\x73\151\x67\72\104\151\x67\x65\163\x74\115\x65\x74\x68\x6f\144\x2f\x40\101\154\x67\x6f\x72\x69\164\x68\155\51";
        $p3 = $K_->evaluate($jz, $GZ);
        $UT = $this->calculateDigest($p3, $uY, false);
        $jz = "\x73\164\162\x69\156\147\50\56\57\163\145\x63\x64\163\x69\x67\72\x44\151\x67\145\x73\164\126\141\x6c\x75\145\51";
        $E1 = $K_->evaluate($jz, $GZ);
        return $UT === base64_decode($E1);
    }
    public function processTransforms($GZ, $kx, $nx = true)
    {
        $uY = $kx;
        $K_ = new DOMXPath($GZ->ownerDocument);
        $K_->registerNamespace("\163\x65\143\x64\163\x69\x67", self::XMLDSIGNS);
        $jz = "\x2e\57\x73\145\143\x64\x73\x69\147\x3a\x54\x72\x61\156\x73\146\157\162\155\163\x2f\163\145\143\x64\163\151\x67\x3a\124\x72\x61\156\x73\146\x6f\162\155";
        $TG = $K_->query($jz, $GZ);
        $SR = "\150\164\164\x70\x3a\57\57\x77\167\x77\56\167\63\x2e\157\162\147\57\124\122\x2f\x32\60\60\x31\57\122\105\103\55\170\155\154\55\x63\x31\x34\156\x2d\62\x30\x30\x31\x30\63\x31\x35";
        $Mk = null;
        $a2 = null;
        foreach ($TG as $Uq) {
            $YK = $Uq->getAttribute("\x41\x6c\147\157\162\x69\x74\150\x6d");
            switch ($YK) {
                case "\x68\164\x74\160\72\x2f\x2f\x77\167\167\x2e\167\63\56\x6f\x72\x67\57\62\60\x30\61\x2f\61\60\x2f\170\x6d\154\x2d\x65\170\143\55\x63\61\64\156\43":
                case "\x68\x74\164\x70\x3a\57\57\167\x77\167\x2e\167\63\x2e\x6f\x72\147\x2f\x32\60\x30\61\x2f\61\x30\57\170\155\x6c\55\x65\170\x63\x2d\143\61\64\x6e\43\x57\151\x74\x68\103\157\155\x6d\x65\156\x74\x73":
                    if (!$nx) {
                        goto Kd;
                    }
                    $SR = $YK;
                    goto LT;
                    Kd:
                    $SR = "\150\164\164\160\72\x2f\x2f\x77\x77\167\x2e\x77\63\x2e\x6f\x72\x67\x2f\x32\x30\60\x31\57\61\60\57\170\155\x6c\55\145\x78\x63\55\x63\x31\x34\x6e\x23";
                    LT:
                    $Dg = $Uq->firstChild;
                    K0:
                    if (!$Dg) {
                        goto ce;
                    }
                    if (!($Dg->localName == "\x49\156\x63\154\165\163\x69\x76\x65\x4e\141\155\145\163\160\x61\143\145\x73")) {
                        goto UW;
                    }
                    if (!($TX = $Dg->getAttribute("\120\162\145\146\151\170\114\151\163\164"))) {
                        goto oA;
                    }
                    $rv = array();
                    $VM = explode("\x20", $TX);
                    foreach ($VM as $TX) {
                        $JK = trim($TX);
                        if (empty($JK)) {
                            goto el;
                        }
                        $rv[] = $JK;
                        el:
                        uR:
                    }
                    oe:
                    if (!(count($rv) > 0)) {
                        goto R1;
                    }
                    $a2 = $rv;
                    R1:
                    oA:
                    goto ce;
                    UW:
                    $Dg = $Dg->nextSibling;
                    goto K0;
                    ce:
                    goto lU;
                case "\150\x74\x74\160\72\x2f\x2f\x77\167\x77\x2e\x77\63\56\x6f\x72\147\57\x54\x52\57\62\x30\60\x31\57\x52\x45\103\x2d\x78\155\x6c\x2d\x63\x31\x34\156\55\62\x30\60\61\60\63\x31\x35":
                case "\150\164\164\160\x3a\x2f\x2f\x77\167\167\56\x77\63\x2e\157\x72\147\x2f\124\122\x2f\62\x30\60\x31\x2f\x52\105\x43\x2d\x78\155\x6c\55\x63\61\x34\156\55\x32\60\60\x31\x30\x33\61\65\x23\127\151\x74\x68\103\157\x6d\155\145\x6e\164\x73":
                    if (!$nx) {
                        goto Aj;
                    }
                    $SR = $YK;
                    goto xW;
                    Aj:
                    $SR = "\x68\164\x74\x70\72\x2f\x2f\x77\167\x77\56\167\x33\x2e\157\x72\x67\57\124\122\x2f\x32\x30\60\61\x2f\x52\105\103\55\x78\x6d\x6c\x2d\x63\61\64\x6e\55\62\x30\60\x31\60\63\x31\65";
                    xW:
                    goto lU;
                case "\150\x74\x74\x70\x3a\x2f\x2f\167\167\167\56\x77\x33\x2e\157\162\147\x2f\x54\x52\57\x31\x39\x39\x39\57\x52\105\x43\x2d\x78\x70\x61\x74\x68\x2d\x31\x39\x39\71\61\61\x31\66":
                    $Dg = $Uq->firstChild;
                    hb:
                    if (!$Dg) {
                        goto lc;
                    }
                    if (!($Dg->localName == "\x58\120\x61\164\150")) {
                        goto vk;
                    }
                    $Mk = array();
                    $Mk["\161\x75\x65\162\x79"] = "\50\x2e\57\57\x2e\x20\x7c\x20\x2e\57\57\100\x2a\x20\174\40\x2e\x2f\x2f\x6e\141\x6d\145\x73\160\x61\x63\145\x3a\72\52\x29\x5b" . $Dg->nodeValue . "\135";
                    $s3["\156\141\x6d\x65\163\160\x61\143\145\163"] = array();
                    $bX = $K_->query("\56\x2f\x6e\x61\x6d\145\x73\160\x61\143\x65\x3a\x3a\52", $Dg);
                    foreach ($bX as $Lg) {
                        if (!($Lg->localName != "\170\155\154")) {
                            goto e7;
                        }
                        $Mk["\156\x61\155\x65\x73\x70\141\143\145\x73"][$Lg->localName] = $Lg->nodeValue;
                        e7:
                        Qp:
                    }
                    Vm:
                    goto lc;
                    vk:
                    $Dg = $Dg->nextSibling;
                    goto hb;
                    lc:
                    goto lU;
            }
            Bs:
            lU:
            cb:
        }
        qJ:
        if (!$uY instanceof DOMNode) {
            goto Sq;
        }
        $uY = $this->canonicalizeData($kx, $SR, $Mk, $a2);
        Sq:
        return $uY;
    }
    public function processRefNode($GZ)
    {
        $hH = null;
        $nx = true;
        if ($XK = $GZ->getAttribute("\125\122\111")) {
            goto xL;
        }
        $nx = false;
        $hH = $GZ->ownerDocument;
        goto HR;
        xL:
        $WP = parse_url($XK);
        if (!empty($WP["\160\141\x74\x68"])) {
            goto wB;
        }
        if ($T9 = $WP["\146\x72\141\x67\x6d\x65\x6e\x74"]) {
            goto fD;
        }
        $hH = $GZ->ownerDocument;
        goto kH;
        fD:
        $nx = false;
        $VF = new DOMXPath($GZ->ownerDocument);
        if (!($this->idNS && is_array($this->idNS))) {
            goto F5;
        }
        foreach ($this->idNS as $kd => $qw) {
            $VF->registerNamespace($kd, $qw);
            mv:
        }
        Px:
        F5:
        $Vk = "\100\111\x64\x3d\42" . XPath::filterAttrValue($T9, XPath::DOUBLE_QUOTE) . "\x22";
        if (!is_array($this->idKeys)) {
            goto ep;
        }
        foreach ($this->idKeys as $gn) {
            $Vk .= "\x20\157\x72\x20\100" . XPath::filterAttrName($gn) . "\75\x22" . XPath::filterAttrValue($T9, XPath::DOUBLE_QUOTE) . "\x22";
            KJ:
        }
        QA:
        ep:
        $jz = "\x2f\x2f\52\x5b" . $Vk . "\135";
        $hH = $VF->query($jz)->item(0);
        kH:
        wB:
        HR:
        $uY = $this->processTransforms($GZ, $hH, $nx);
        if ($this->validateDigest($GZ, $uY)) {
            goto xS;
        }
        return false;
        xS:
        if (!$hH instanceof DOMNode) {
            goto FZ;
        }
        if (!empty($T9)) {
            goto Ow;
        }
        $this->validatedNodes[] = $hH;
        goto M8;
        Ow:
        $this->validatedNodes[$T9] = $hH;
        M8:
        FZ:
        return true;
    }
    public function getRefNodeID($GZ)
    {
        if (!($XK = $GZ->getAttribute("\x55\122\x49"))) {
            goto Ww;
        }
        $WP = parse_url($XK);
        if (!empty($WP["\x70\x61\164\150"])) {
            goto rr;
        }
        if (!($T9 = $WP["\146\162\x61\147\x6d\145\156\x74"])) {
            goto Bz;
        }
        return $T9;
        Bz:
        rr:
        Ww:
        return null;
    }
    public function getRefIDs()
    {
        $B3 = array();
        $K_ = $this->getXPathObj();
        $jz = "\56\57\x73\x65\143\x64\163\151\147\72\123\x69\147\156\145\x64\x49\156\146\157\x2f\x73\x65\143\x64\x73\x69\x67\x3a\x52\145\146\145\x72\x65\x6e\143\145";
        $L5 = $K_->query($jz, $this->sigNode);
        if (!($L5->length == 0)) {
            goto BQ;
        }
        throw new Exception("\122\145\x66\x65\162\145\x6e\x63\145\40\156\x6f\144\145\x73\40\x6e\157\x74\40\x66\x6f\165\x6e\144");
        BQ:
        foreach ($L5 as $GZ) {
            $B3[] = $this->getRefNodeID($GZ);
            Zw:
        }
        Yb:
        return $B3;
    }
    public function validateReference()
    {
        $WC = $this->sigNode->ownerDocument->documentElement;
        if ($WC->isSameNode($this->sigNode)) {
            goto Qg;
        }
        if (!($this->sigNode->parentNode != null)) {
            goto Z3;
        }
        $this->sigNode->parentNode->removeChild($this->sigNode);
        Z3:
        Qg:
        $K_ = $this->getXPathObj();
        $jz = "\56\57\x73\145\x63\144\x73\x69\x67\x3a\123\151\147\156\x65\144\x49\x6e\x66\157\x2f\163\145\x63\x64\x73\151\147\72\x52\x65\146\145\162\145\x6e\x63\145";
        $L5 = $K_->query($jz, $this->sigNode);
        if (!($L5->length == 0)) {
            goto G3;
        }
        throw new Exception("\x52\x65\146\145\162\x65\x6e\143\x65\40\156\157\144\x65\x73\40\156\157\x74\40\146\x6f\x75\x6e\144");
        G3:
        $this->validatedNodes = array();
        foreach ($L5 as $GZ) {
            if ($this->processRefNode($GZ)) {
                goto A1;
            }
            $this->validatedNodes = null;
            throw new Exception("\122\x65\x66\145\x72\x65\156\143\145\x20\166\141\x6c\x69\144\141\x74\x69\157\x6e\x20\x66\141\x69\x6c\145\144");
            A1:
            nW:
        }
        mW:
        return true;
    }
    private function addRefInternal($Gt, $Dg, $YK, $jl = null, $iu = null)
    {
        $TL = null;
        $LP = null;
        $eA = "\x49\144";
        $Bw = true;
        $I5 = false;
        if (!is_array($iu)) {
            goto V4;
        }
        $TL = empty($iu["\x70\x72\145\x66\151\170"]) ? null : $iu["\x70\162\145\146\151\x78"];
        $LP = empty($iu["\x70\x72\145\x66\x69\x78\x5f\x6e\x73"]) ? null : $iu["\160\x72\x65\x66\x69\x78\137\x6e\163"];
        $eA = empty($iu["\x69\x64\x5f\x6e\141\155\145"]) ? "\111\144" : $iu["\x69\x64\x5f\x6e\141\155\x65"];
        $Bw = !isset($iu["\x6f\166\x65\x72\167\x72\151\x74\x65"]) ? true : (bool) $iu["\x6f\x76\145\162\167\162\151\x74\145"];
        $I5 = !isset($iu["\x66\157\x72\143\x65\x5f\x75\x72\x69"]) ? false : (bool) $iu["\146\x6f\162\x63\x65\x5f\165\x72\151"];
        V4:
        $Td = $eA;
        if (empty($TL)) {
            goto fR;
        }
        $Td = $TL . "\x3a" . $Td;
        fR:
        $GZ = $this->createNewSignNode("\122\145\x66\145\162\x65\x6e\143\145");
        $Gt->appendChild($GZ);
        if (!$Dg instanceof DOMDocument) {
            goto b3;
        }
        if ($I5) {
            goto gg;
        }
        goto EE;
        b3:
        $XK = null;
        if ($Bw) {
            goto jF;
        }
        $XK = $LP ? $Dg->getAttributeNS($LP, $eA) : $Dg->getAttribute($eA);
        jF:
        if (!empty($XK)) {
            goto XA;
        }
        $XK = self::generateGUID();
        $Dg->setAttributeNS($LP, $Td, $XK);
        XA:
        $GZ->setAttribute("\x55\122\x49", "\x23" . $XK);
        goto EE;
        gg:
        $GZ->setAttribute("\x55\x52\111", '');
        EE:
        $mc = $this->createNewSignNode("\124\162\141\156\x73\x66\x6f\x72\x6d\163");
        $GZ->appendChild($mc);
        if (is_array($jl)) {
            goto kx;
        }
        if (!empty($this->canonicalMethod)) {
            goto CA;
        }
        goto Lz;
        kx:
        foreach ($jl as $Uq) {
            $Hh = $this->createNewSignNode("\124\x72\141\x6e\x73\x66\157\x72\155");
            $mc->appendChild($Hh);
            if (is_array($Uq) && !empty($Uq["\150\x74\164\160\72\x2f\57\x77\167\x77\x2e\x77\x33\56\x6f\162\x67\x2f\124\122\x2f\x31\x39\x39\x39\x2f\x52\105\103\x2d\x78\x70\x61\x74\x68\55\x31\71\71\71\61\61\61\x36"]) && !empty($Uq["\x68\x74\164\x70\x3a\x2f\57\167\167\167\56\x77\x33\x2e\157\x72\x67\x2f\124\x52\x2f\x31\x39\71\71\57\x52\105\x43\55\x78\x70\141\x74\x68\x2d\61\x39\71\71\x31\x31\x31\x36"]["\x71\x75\x65\x72\x79"])) {
                goto CQ;
            }
            $Hh->setAttribute("\101\x6c\x67\x6f\162\x69\164\x68\155", $Uq);
            goto tj;
            CQ:
            $Hh->setAttribute("\101\x6c\147\x6f\x72\x69\x74\x68\155", "\150\x74\x74\160\72\x2f\57\167\x77\167\56\x77\x33\x2e\157\162\147\57\124\122\x2f\x31\x39\x39\x39\x2f\122\105\103\x2d\x78\160\x61\x74\x68\x2d\61\x39\71\71\x31\61\x31\x36");
            $cn = $this->createNewSignNode("\x58\120\141\164\x68", $Uq["\150\x74\x74\x70\x3a\57\x2f\x77\167\167\x2e\167\63\x2e\x6f\162\x67\x2f\124\122\x2f\x31\x39\71\71\57\122\x45\x43\55\x78\x70\x61\x74\150\x2d\61\x39\x39\x39\x31\61\61\66"]["\x71\x75\145\x72\171"]);
            $Hh->appendChild($cn);
            if (empty($Uq["\150\164\164\160\72\57\57\x77\167\167\x2e\167\63\x2e\157\162\147\57\x54\x52\x2f\61\71\71\71\x2f\122\x45\x43\55\x78\160\141\x74\x68\x2d\61\71\x39\71\x31\61\61\66"]["\156\x61\155\145\x73\x70\x61\x63\x65\x73"])) {
                goto AB;
            }
            foreach ($Uq["\x68\x74\164\x70\72\x2f\x2f\x77\167\x77\x2e\167\x33\56\x6f\x72\147\57\x54\122\x2f\x31\x39\x39\x39\57\x52\105\x43\x2d\x78\160\141\x74\x68\55\x31\71\71\71\61\61\61\66"]["\156\x61\155\x65\x73\x70\141\x63\x65\163"] as $TL => $ty) {
                $cn->setAttributeNS("\150\164\164\160\72\x2f\x2f\167\x77\167\x2e\x77\63\56\x6f\162\x67\57\x32\60\60\x30\x2f\170\x6d\154\156\x73\x2f", "\x78\x6d\154\x6e\x73\72{$TL}", $ty);
                dl:
            }
            yh:
            AB:
            tj:
            b0:
        }
        QT:
        goto Lz;
        CA:
        $Hh = $this->createNewSignNode("\124\162\141\156\x73\146\x6f\x72\155");
        $mc->appendChild($Hh);
        $Hh->setAttribute("\101\154\147\x6f\x72\x69\x74\150\x6d", $this->canonicalMethod);
        Lz:
        $AM = $this->processTransforms($GZ, $Dg);
        $UT = $this->calculateDigest($YK, $AM);
        $Ab = $this->createNewSignNode("\104\151\x67\x65\x73\164\x4d\145\164\150\157\x64");
        $GZ->appendChild($Ab);
        $Ab->setAttribute("\x41\x6c\147\157\x72\151\164\x68\x6d", $YK);
        $E1 = $this->createNewSignNode("\x44\x69\x67\x65\x73\x74\126\141\x6c\x75\x65", $UT);
        $GZ->appendChild($E1);
    }
    public function addReference($Dg, $YK, $jl = null, $iu = null)
    {
        if (!($K_ = $this->getXPathObj())) {
            goto hg;
        }
        $jz = "\x2e\x2f\x73\145\x63\x64\x73\151\x67\x3a\x53\151\147\x6e\x65\144\111\x6e\146\157";
        $L5 = $K_->query($jz, $this->sigNode);
        if (!($w_ = $L5->item(0))) {
            goto U3;
        }
        $this->addRefInternal($w_, $Dg, $YK, $jl, $iu);
        U3:
        hg:
    }
    public function addReferenceList($MD, $YK, $jl = null, $iu = null)
    {
        if (!($K_ = $this->getXPathObj())) {
            goto JY;
        }
        $jz = "\56\x2f\x73\x65\x63\x64\163\151\147\72\x53\x69\x67\x6e\145\144\111\x6e\x66\157";
        $L5 = $K_->query($jz, $this->sigNode);
        if (!($w_ = $L5->item(0))) {
            goto pk;
        }
        foreach ($MD as $Dg) {
            $this->addRefInternal($w_, $Dg, $YK, $jl, $iu);
            MS:
        }
        hi:
        pk:
        JY:
    }
    public function addObject($uY, $W_ = null, $ZU = null)
    {
        $t9 = $this->createNewSignNode("\x4f\x62\152\145\x63\x74");
        $this->sigNode->appendChild($t9);
        if (empty($W_)) {
            goto qD;
        }
        $t9->setAttribute("\115\151\155\x65\x54\x79\160\x65", $W_);
        qD:
        if (empty($ZU)) {
            goto vt;
        }
        $t9->setAttribute("\105\156\x63\157\x64\151\x6e\x67", $ZU);
        vt:
        if ($uY instanceof DOMElement) {
            goto g3;
        }
        $V1 = $this->sigNode->ownerDocument->createTextNode($uY);
        goto RM;
        g3:
        $V1 = $this->sigNode->ownerDocument->importNode($uY, true);
        RM:
        $t9->appendChild($V1);
        return $t9;
    }
    public function locateKey($Dg = null)
    {
        if (!empty($Dg)) {
            goto i1;
        }
        $Dg = $this->sigNode;
        i1:
        if ($Dg instanceof DOMNode) {
            goto e3;
        }
        return null;
        e3:
        if (!($wP = $Dg->ownerDocument)) {
            goto pd;
        }
        $K_ = new DOMXPath($wP);
        $K_->registerNamespace("\163\x65\143\x64\163\151\147", self::XMLDSIGNS);
        $jz = "\163\x74\x72\151\156\x67\50\x2e\x2f\x73\x65\143\144\163\x69\x67\72\123\151\x67\156\145\x64\x49\156\x66\x6f\57\163\x65\x63\144\163\151\147\72\123\x69\147\x6e\x61\x74\165\x72\145\x4d\145\164\150\x6f\x64\57\x40\101\x6c\x67\157\x72\151\164\150\x6d\51";
        $YK = $K_->evaluate($jz, $Dg);
        if (!$YK) {
            goto k7;
        }
        try {
            $JP = new XMLSecurityKey($YK, array("\x74\x79\160\145" => "\x70\165\x62\154\151\x63"));
        } catch (Exception $LR) {
            return null;
        }
        return $JP;
        k7:
        pd:
        return null;
    }
    public function verify($JP)
    {
        $wP = $this->sigNode->ownerDocument;
        $K_ = new DOMXPath($wP);
        $K_->registerNamespace("\x73\x65\x63\144\x73\151\147", self::XMLDSIGNS);
        $jz = "\x73\164\162\x69\156\x67\x28\x2e\57\x73\x65\x63\x64\163\x69\x67\72\x53\151\x67\x6e\x61\164\165\x72\145\x56\141\x6c\165\x65\x29";
        $MH = $K_->evaluate($jz, $this->sigNode);
        if (!empty($MH)) {
            goto QK;
        }
        throw new Exception("\125\156\141\142\154\145\x20\x74\157\40\x6c\157\x63\x61\x74\x65\x20\x53\x69\147\x6e\x61\164\165\162\x65\x56\x61\154\x75\x65");
        QK:
        return $JP->verifySignature($this->signedInfo, base64_decode($MH));
    }
    public function signData($JP, $uY)
    {
        return $JP->signData($uY);
    }
    public function sign($JP, $oj = null)
    {
        if (!($oj != null)) {
            goto hC;
        }
        $this->resetXPathObj();
        $this->appendSignature($oj);
        $this->sigNode = $oj->lastChild;
        hC:
        if (!($K_ = $this->getXPathObj())) {
            goto GP;
        }
        $jz = "\x2e\x2f\x73\145\143\144\163\151\x67\x3a\x53\151\x67\156\145\144\x49\x6e\146\157";
        $L5 = $K_->query($jz, $this->sigNode);
        if (!($w_ = $L5->item(0))) {
            goto hm;
        }
        $jz = "\56\x2f\x73\x65\x63\144\x73\x69\147\72\x53\151\x67\156\141\164\x75\162\145\x4d\x65\x74\x68\157\144";
        $L5 = $K_->query($jz, $w_);
        $Uv = $L5->item(0);
        $Uv->setAttribute("\101\154\147\157\162\x69\x74\150\x6d", $JP->type);
        $uY = $this->canonicalizeData($w_, $this->canonicalMethod);
        $MH = base64_encode($this->signData($JP, $uY));
        $Jt = $this->createNewSignNode("\123\x69\x67\x6e\141\164\x75\162\x65\126\141\154\165\x65", $MH);
        if ($dk = $w_->nextSibling) {
            goto CE;
        }
        $this->sigNode->appendChild($Jt);
        goto fq;
        CE:
        $dk->parentNode->insertBefore($Jt, $dk);
        fq:
        hm:
        GP:
    }
    public function appendCert()
    {
    }
    public function appendKey($JP, $n5 = null)
    {
        $JP->serializeKey($n5);
    }
    public function insertSignature($Dg, $D9 = null)
    {
        $PG = $Dg->ownerDocument;
        $Ny = $PG->importNode($this->sigNode, true);
        if ($D9 == null) {
            goto L9;
        }
        return $Dg->insertBefore($Ny, $D9);
        goto Df;
        L9:
        return $Dg->insertBefore($Ny);
        Df:
    }
    public function appendSignature($B6, $JB = false)
    {
        $D9 = $JB ? $B6->firstChild : null;
        return $this->insertSignature($B6, $D9);
    }
    public static function get509XCert($eV, $fz = true)
    {
        $WG = self::staticGet509XCerts($eV, $fz);
        if (empty($WG)) {
            goto m2;
        }
        return $WG[0];
        m2:
        return '';
    }
    public static function staticGet509XCerts($WG, $fz = true)
    {
        if ($fz) {
            goto la;
        }
        return array($WG);
        goto Yq;
        la:
        $uY = '';
        $h1 = array();
        $u3 = explode("\xa", $WG);
        $Iu = false;
        foreach ($u3 as $Jn) {
            if (!$Iu) {
                goto GB;
            }
            if (!(strncmp($Jn, "\x2d\55\55\x2d\55\x45\x4e\104\40\x43\x45\122\x54\111\x46\x49\x43\x41\124\105", 20) == 0)) {
                goto Hf;
            }
            $Iu = false;
            $h1[] = $uY;
            $uY = '';
            goto Jx;
            Hf:
            $uY .= trim($Jn);
            goto DP;
            GB:
            if (!(strncmp($Jn, "\55\55\x2d\x2d\55\102\105\107\111\x4e\40\103\x45\122\x54\x49\106\111\x43\101\124\x45", 22) == 0)) {
                goto Hv;
            }
            $Iu = true;
            Hv:
            DP:
            Jx:
        }
        mr:
        return $h1;
        Yq:
    }
    public static function staticAdd509Cert($cR, $eV, $fz = true, $r5 = false, $K_ = null, $iu = null)
    {
        if (!$r5) {
            goto Vp;
        }
        $eV = file_get_contents($eV);
        Vp:
        if ($cR instanceof DOMElement) {
            goto Ic;
        }
        throw new Exception("\x49\x6e\166\x61\154\x69\x64\40\160\x61\162\x65\x6e\164\x20\x4e\157\144\x65\x20\x70\141\162\141\155\145\164\x65\x72");
        Ic:
        $Hv = $cR->ownerDocument;
        if (!empty($K_)) {
            goto fg;
        }
        $K_ = new DOMXPath($cR->ownerDocument);
        $K_->registerNamespace("\x73\145\x63\x64\x73\x69\147", self::XMLDSIGNS);
        fg:
        $jz = "\x2e\x2f\x73\145\x63\x64\x73\151\x67\x3a\113\x65\171\111\156\146\x6f";
        $L5 = $K_->query($jz, $cR);
        $zm = $L5->item(0);
        $dj = '';
        if (!$zm) {
            goto fX;
        }
        $TX = $zm->lookupPrefix(self::XMLDSIGNS);
        if (empty($TX)) {
            goto BU;
        }
        $dj = $TX . "\72";
        BU:
        goto I1;
        fX:
        $TX = $cR->lookupPrefix(self::XMLDSIGNS);
        if (empty($TX)) {
            goto BH;
        }
        $dj = $TX . "\72";
        BH:
        $lb = false;
        $zm = $Hv->createElementNS(self::XMLDSIGNS, $dj . "\x4b\x65\171\x49\x6e\146\x6f");
        $jz = "\x2e\57\x73\x65\x63\x64\163\151\x67\72\x4f\142\x6a\145\x63\x74";
        $L5 = $K_->query($jz, $cR);
        if (!($Qr = $L5->item(0))) {
            goto D4;
        }
        $Qr->parentNode->insertBefore($zm, $Qr);
        $lb = true;
        D4:
        if ($lb) {
            goto Rl;
        }
        $cR->appendChild($zm);
        Rl:
        I1:
        $WG = self::staticGet509XCerts($eV, $fz);
        $Pj = $Hv->createElementNS(self::XMLDSIGNS, $dj . "\x58\x35\x30\71\x44\141\164\141");
        $zm->appendChild($Pj);
        $uj = false;
        $rx = false;
        if (!is_array($iu)) {
            goto CK;
        }
        if (empty($iu["\151\x73\x73\165\x65\x72\x53\x65\x72\151\x61\x6c"])) {
            goto mx;
        }
        $uj = true;
        mx:
        if (empty($iu["\163\165\142\152\145\143\164\116\x61\x6d\x65"])) {
            goto WS;
        }
        $rx = true;
        WS:
        CK:
        foreach ($WG as $m2) {
            if (!($uj || $rx)) {
                goto eO;
            }
            if (!($ia = openssl_x509_parse("\x2d\55\55\55\55\102\x45\x47\x49\x4e\x20\103\x45\122\x54\111\x46\111\103\x41\x54\x45\55\55\55\55\55\12" . chunk_split($m2, 64, "\xa") . "\55\55\x2d\55\55\x45\x4e\104\x20\x43\x45\x52\124\111\106\x49\103\101\x54\x45\55\x2d\55\55\x2d\12"))) {
                goto Iv;
            }
            if (!($rx && !empty($ia["\x73\x75\142\x6a\x65\143\x74"]))) {
                goto rm;
            }
            if (is_array($ia["\163\x75\142\x6a\x65\x63\x74"])) {
                goto yW;
            }
            $c0 = $ia["\x69\163\163\x75\x65\162"];
            goto bp;
            yW:
            $rX = array();
            foreach ($ia["\x73\x75\142\152\145\x63\x74"] as $uZ => $Ka) {
                if (is_array($Ka)) {
                    goto U7;
                }
                array_unshift($rX, "{$uZ}\x3d{$Ka}");
                goto ya;
                U7:
                foreach ($Ka as $AF) {
                    array_unshift($rX, "{$uZ}\75{$AF}");
                    eF:
                }
                lg:
                ya:
                O0:
            }
            AS1:
            $c0 = implode("\x2c", $rX);
            bp:
            $Pa = $Hv->createElementNS(self::XMLDSIGNS, $dj . "\130\65\60\x39\x53\165\x62\152\145\x63\x74\x4e\141\155\145", $c0);
            $Pj->appendChild($Pa);
            rm:
            if (!($uj && !empty($ia["\151\x73\x73\165\x65\x72"]) && !empty($ia["\163\145\x72\x69\x61\154\x4e\165\155\142\x65\x72"]))) {
                goto tL;
            }
            if (is_array($ia["\x69\163\163\x75\x65\162"])) {
                goto Fy;
            }
            $NA = $ia["\x69\163\163\x75\145\x72"];
            goto Kn;
            Fy:
            $rX = array();
            foreach ($ia["\151\163\163\165\145\162"] as $uZ => $Ka) {
                array_unshift($rX, "{$uZ}\75{$Ka}");
                tD:
            }
            qz:
            $NA = implode("\x2c", $rX);
            Kn:
            $SN = $Hv->createElementNS(self::XMLDSIGNS, $dj . "\130\65\x30\x39\111\x73\163\x75\x65\x72\x53\x65\x72\x69\x61\x6c");
            $Pj->appendChild($SN);
            $CL = $Hv->createElementNS(self::XMLDSIGNS, $dj . "\130\x35\60\71\111\163\x73\165\145\162\116\x61\155\x65", $NA);
            $SN->appendChild($CL);
            $CL = $Hv->createElementNS(self::XMLDSIGNS, $dj . "\x58\x35\60\71\123\145\x72\151\141\x6c\116\165\155\x62\145\162", $ia["\163\145\x72\151\141\154\116\165\155\142\145\x72"]);
            $SN->appendChild($CL);
            tL:
            Iv:
            eO:
            $Wd = $Hv->createElementNS(self::XMLDSIGNS, $dj . "\x58\65\x30\x39\103\x65\162\x74\151\x66\x69\143\141\164\145", $m2);
            $Pj->appendChild($Wd);
            Nr:
        }
        uj:
    }
    public function add509Cert($eV, $fz = true, $r5 = false, $iu = null)
    {
        if (!($K_ = $this->getXPathObj())) {
            goto J2;
        }
        self::staticAdd509Cert($this->sigNode, $eV, $fz, $r5, $K_, $iu);
        J2:
    }
    public function appendToKeyInfo($Dg)
    {
        $cR = $this->sigNode;
        $Hv = $cR->ownerDocument;
        $K_ = $this->getXPathObj();
        if (!empty($K_)) {
            goto wL;
        }
        $K_ = new DOMXPath($cR->ownerDocument);
        $K_->registerNamespace("\163\145\143\144\x73\x69\147", self::XMLDSIGNS);
        wL:
        $jz = "\x2e\57\x73\x65\143\144\x73\x69\147\x3a\x4b\145\171\x49\156\x66\157";
        $L5 = $K_->query($jz, $cR);
        $zm = $L5->item(0);
        if ($zm) {
            goto du;
        }
        $dj = '';
        $TX = $cR->lookupPrefix(self::XMLDSIGNS);
        if (empty($TX)) {
            goto kW;
        }
        $dj = $TX . "\x3a";
        kW:
        $lb = false;
        $zm = $Hv->createElementNS(self::XMLDSIGNS, $dj . "\x4b\145\x79\x49\x6e\146\157");
        $jz = "\56\x2f\163\x65\143\144\x73\151\147\x3a\x4f\x62\152\145\143\x74";
        $L5 = $K_->query($jz, $cR);
        if (!($Qr = $L5->item(0))) {
            goto ZT;
        }
        $Qr->parentNode->insertBefore($zm, $Qr);
        $lb = true;
        ZT:
        if ($lb) {
            goto aS1;
        }
        $cR->appendChild($zm);
        aS1:
        du:
        $zm->appendChild($Dg);
        return $zm;
    }
    public function getValidatedNodes()
    {
        return $this->validatedNodes;
    }
}
