<?php


namespace RobRichards\XMLSecLibs;

use DOMDocument;
use DOMNode;
use DOMXPath;
use Exception;
use RobRichards\XMLSecLibs\Utils\XPath;
class XMLSecEnc
{
    const template = "\74\x78\145\x6e\x63\72\105\x6e\x63\x72\171\160\x74\x65\144\104\141\164\x61\x20\170\155\154\156\163\x3a\x78\145\156\x63\75\x27\x68\164\164\160\x3a\57\57\167\167\x77\x2e\167\63\56\157\x72\x67\57\x32\60\x30\x31\x2f\x30\64\x2f\x78\x6d\x6c\x65\x6e\143\x23\47\76\15\12\40\40\x20\x3c\170\x65\156\143\x3a\103\x69\x70\150\145\x72\x44\141\x74\141\x3e\15\12\x20\40\x20\40\40\40\x3c\170\145\x6e\143\x3a\x43\151\160\150\x65\x72\x56\141\154\x75\x65\x3e\74\x2f\170\145\156\143\x3a\x43\151\160\x68\x65\162\x56\141\154\165\x65\x3e\15\12\40\40\x20\74\x2f\x78\x65\156\x63\x3a\x43\151\160\150\145\x72\104\141\164\141\x3e\15\12\74\57\x78\145\156\143\72\105\156\143\x72\171\160\x74\145\144\x44\141\164\x61\x3e";
    const Element = "\x68\x74\x74\x70\x3a\57\x2f\x77\167\167\x2e\167\63\x2e\x6f\x72\147\x2f\62\60\x30\x31\x2f\x30\x34\57\x78\155\154\x65\x6e\143\x23\x45\154\x65\x6d\x65\x6e\164";
    const Content = "\150\x74\164\160\72\57\x2f\x77\167\x77\56\x77\63\56\157\x72\x67\57\x32\60\x30\x31\57\x30\64\x2f\170\155\154\x65\x6e\143\43\x43\157\156\164\145\156\164";
    const URI = 3;
    const XMLENCNS = "\150\164\x74\160\x3a\x2f\57\x77\x77\167\x2e\167\x33\56\157\x72\147\57\x32\x30\x30\61\57\60\x34\57\170\x6d\154\145\x6e\x63\43";
    private $encdoc = null;
    private $rawNode = null;
    public $type = null;
    public $encKey = null;
    private $references = array();
    public function __construct()
    {
        $this->_resetTemplate();
    }
    private function _resetTemplate()
    {
        $this->encdoc = new DOMDocument();
        $this->encdoc->loadXML(self::template);
    }
    public function addReference($XE, $Dg, $u8)
    {
        if ($Dg instanceof DOMNode) {
            goto HpP;
        }
        throw new Exception("\x24\156\157\144\x65\x20\151\x73\x20\x6e\157\x74\40\x6f\146\40\x74\171\160\145\x20\104\x4f\x4d\116\157\144\x65");
        HpP:
        $kD = $this->encdoc;
        $this->_resetTemplate();
        $Sa = $this->encdoc;
        $this->encdoc = $kD;
        $gz = XMLSecurityDSig::generateGUID();
        $j2 = $Sa->documentElement;
        $j2->setAttribute("\x49\x64", $gz);
        $this->references[$XE] = array("\156\157\x64\145" => $Dg, "\164\171\x70\x65" => $u8, "\145\156\x63\156\157\x64\x65" => $Sa, "\x72\145\146\x75\x72\x69" => $gz);
    }
    public function setNode($Dg)
    {
        $this->rawNode = $Dg;
    }
    public function encryptNode($JP, $Qn = true)
    {
        $uY = '';
        if (!empty($this->rawNode)) {
            goto U70;
        }
        throw new Exception("\116\157\x64\x65\40\x74\157\40\145\x6e\x63\x72\x79\x70\164\40\150\x61\163\40\x6e\157\164\x20\142\145\145\x6e\40\x73\x65\x74");
        U70:
        if ($JP instanceof XMLSecurityKey) {
            goto GQE;
        }
        throw new Exception("\x49\156\x76\141\x6c\x69\x64\x20\113\145\x79");
        GQE:
        $wP = $this->rawNode->ownerDocument;
        $VF = new DOMXPath($this->encdoc);
        $RU = $VF->query("\x2f\x78\145\156\x63\72\x45\x6e\x63\x72\x79\160\164\x65\144\x44\141\164\141\x2f\x78\145\x6e\143\x3a\103\151\x70\150\x65\x72\x44\141\x74\141\x2f\x78\145\156\x63\x3a\x43\151\x70\150\x65\162\x56\x61\x6c\x75\145");
        $lK = $RU->item(0);
        if (!($lK == null)) {
            goto YqP;
        }
        throw new Exception("\105\162\162\x6f\x72\40\x6c\x6f\143\141\x74\151\x6e\x67\40\103\x69\160\150\145\x72\126\141\x6c\x75\145\40\145\154\145\x6d\x65\156\x74\40\167\x69\164\x68\x69\x6e\x20\x74\x65\155\160\154\141\164\145");
        YqP:
        switch ($this->type) {
            case self::Element:
                $uY = $wP->saveXML($this->rawNode);
                $this->encdoc->documentElement->setAttribute("\x54\x79\x70\x65", self::Element);
                goto h0O;
            case self::Content:
                $X5 = $this->rawNode->childNodes;
                foreach ($X5 as $BL) {
                    $uY .= $wP->saveXML($BL);
                    Yyr:
                }
                XWo:
                $this->encdoc->documentElement->setAttribute("\124\x79\160\145", self::Content);
                goto h0O;
            default:
                throw new Exception("\124\171\160\x65\x20\x69\163\40\143\x75\162\x72\x65\x6e\164\154\x79\40\156\157\x74\x20\x73\165\160\160\x6f\x72\x74\145\144");
        }
        RbE:
        h0O:
        $dm = $this->encdoc->documentElement->appendChild($this->encdoc->createElementNS(self::XMLENCNS, "\170\x65\x6e\x63\72\105\x6e\143\x72\171\160\164\151\157\156\x4d\x65\x74\150\157\x64"));
        $dm->setAttribute("\x41\x6c\147\x6f\x72\x69\x74\x68\x6d", $JP->getAlgorithm());
        $lK->parentNode->parentNode->insertBefore($dm, $lK->parentNode->parentNode->firstChild);
        $JI = base64_encode($JP->encryptData($uY));
        $Ka = $this->encdoc->createTextNode($JI);
        $lK->appendChild($Ka);
        if ($Qn) {
            goto Pb5;
        }
        return $this->encdoc->documentElement;
        goto VWG;
        Pb5:
        switch ($this->type) {
            case self::Element:
                if (!($this->rawNode->nodeType == XML_DOCUMENT_NODE)) {
                    goto S97;
                }
                return $this->encdoc;
                S97:
                $k3 = $this->rawNode->ownerDocument->importNode($this->encdoc->documentElement, true);
                $this->rawNode->parentNode->replaceChild($k3, $this->rawNode);
                return $k3;
            case self::Content:
                $k3 = $this->rawNode->ownerDocument->importNode($this->encdoc->documentElement, true);
                KZl:
                if (!$this->rawNode->firstChild) {
                    goto rjP;
                }
                $this->rawNode->removeChild($this->rawNode->firstChild);
                goto KZl;
                rjP:
                $this->rawNode->appendChild($k3);
                return $k3;
        }
        OzK:
        w6_:
        VWG:
    }
    public function encryptReferences($JP)
    {
        $Xx = $this->rawNode;
        $Qd = $this->type;
        foreach ($this->references as $XE => $Y2) {
            $this->encdoc = $Y2["\x65\156\143\x6e\x6f\144\x65"];
            $this->rawNode = $Y2["\x6e\157\x64\x65"];
            $this->type = $Y2["\x74\171\160\x65"];
            try {
                $Rp = $this->encryptNode($JP);
                $this->references[$XE]["\x65\x6e\x63\156\157\x64\145"] = $Rp;
            } catch (Exception $LR) {
                $this->rawNode = $Xx;
                $this->type = $Qd;
                throw $LR;
            }
            S3P:
        }
        OIc:
        $this->rawNode = $Xx;
        $this->type = $Qd;
    }
    public function getCipherValue()
    {
        if (!empty($this->rawNode)) {
            goto yN1;
        }
        throw new Exception("\x4e\157\x64\x65\x20\164\157\40\x64\x65\143\x72\171\160\x74\x20\x68\141\x73\x20\156\157\164\x20\x62\x65\x65\156\x20\163\145\x74");
        yN1:
        $wP = $this->rawNode->ownerDocument;
        $VF = new DOMXPath($wP);
        $VF->registerNamespace("\x78\x6d\x6c\x65\x6e\x63\x72", self::XMLENCNS);
        $jz = "\x2e\57\x78\x6d\154\x65\x6e\143\162\72\103\x69\x70\x68\x65\162\104\x61\164\141\x2f\170\155\154\x65\x6e\x63\x72\72\x43\x69\160\150\x65\162\x56\141\x6c\x75\145";
        $L5 = $VF->query($jz, $this->rawNode);
        $Dg = $L5->item(0);
        if ($Dg) {
            goto UwX;
        }
        return null;
        UwX:
        return base64_decode($Dg->nodeValue);
    }
    public function decryptNode($JP, $Qn = true)
    {
        if ($JP instanceof XMLSecurityKey) {
            goto r5u;
        }
        throw new Exception("\x49\156\166\141\x6c\x69\x64\40\x4b\145\x79");
        r5u:
        $Wt = $this->getCipherValue();
        if ($Wt) {
            goto kpM;
        }
        throw new Exception("\x43\x61\x6e\156\157\164\x20\x6c\x6f\x63\x61\164\x65\x20\145\156\x63\x72\x79\x70\164\x65\x64\x20\144\x61\164\x61");
        goto bVi;
        kpM:
        $nr = $JP->decryptData($Wt);
        if ($Qn) {
            goto sNI;
        }
        return $nr;
        goto JEc;
        sNI:
        switch ($this->type) {
            case self::Element:
                $WZ = new DOMDocument();
                $WZ->loadXML($nr);
                if (!($this->rawNode->nodeType == XML_DOCUMENT_NODE)) {
                    goto l13;
                }
                return $WZ;
                l13:
                $k3 = $this->rawNode->ownerDocument->importNode($WZ->documentElement, true);
                $this->rawNode->parentNode->replaceChild($k3, $this->rawNode);
                return $k3;
            case self::Content:
                if ($this->rawNode->nodeType == XML_DOCUMENT_NODE) {
                    goto LPM;
                }
                $wP = $this->rawNode->ownerDocument;
                goto oZH;
                LPM:
                $wP = $this->rawNode;
                oZH:
                $VO = $wP->createDocumentFragment();
                $VO->appendXML($nr);
                $n5 = $this->rawNode->parentNode;
                $n5->replaceChild($VO, $this->rawNode);
                return $n5;
            default:
                return $nr;
        }
        X9Q:
        aJG:
        JEc:
        bVi:
    }
    public function encryptKey($Tz, $Y5, $Q5 = true)
    {
        if (!(!$Tz instanceof XMLSecurityKey || !$Y5 instanceof XMLSecurityKey)) {
            goto OYo;
        }
        throw new Exception("\x49\156\x76\x61\x6c\x69\144\40\x4b\145\x79");
        OYo:
        $fW = base64_encode($Tz->encryptData($Y5->key));
        $pZ = $this->encdoc->documentElement;
        $xA = $this->encdoc->createElementNS(self::XMLENCNS, "\x78\x65\156\x63\x3a\x45\156\x63\162\x79\160\164\145\x64\x4b\x65\x79");
        if ($Q5) {
            goto Ctk;
        }
        $this->encKey = $xA;
        goto WoI;
        Ctk:
        $zm = $pZ->insertBefore($this->encdoc->createElementNS("\x68\164\x74\x70\72\x2f\x2f\x77\x77\x77\x2e\167\63\56\157\162\147\x2f\x32\x30\x30\60\57\60\x39\57\170\x6d\154\144\163\151\147\43", "\144\x73\x69\147\72\x4b\x65\171\x49\156\x66\x6f"), $pZ->firstChild);
        $zm->appendChild($xA);
        WoI:
        $dm = $xA->appendChild($this->encdoc->createElementNS(self::XMLENCNS, "\x78\145\156\x63\72\x45\x6e\143\162\x79\160\164\x69\x6f\x6e\115\145\x74\150\157\x64"));
        $dm->setAttribute("\x41\x6c\147\x6f\162\x69\x74\x68\x6d", $Tz->getAlgorith());
        if (empty($Tz->name)) {
            goto f8N;
        }
        $zm = $xA->appendChild($this->encdoc->createElementNS("\150\164\164\160\x3a\57\57\167\167\x77\56\167\x33\x2e\157\162\x67\57\x32\x30\60\60\x2f\60\x39\x2f\170\155\154\144\163\x69\147\x23", "\x64\x73\x69\147\72\113\x65\x79\x49\156\146\x6f"));
        $zm->appendChild($this->encdoc->createElementNS("\150\164\x74\160\72\x2f\x2f\167\x77\x77\56\167\63\x2e\x6f\162\147\x2f\62\60\x30\x30\57\x30\x39\x2f\170\x6d\154\x64\x73\151\x67\43", "\x64\x73\x69\147\x3a\x4b\145\x79\116\x61\x6d\x65", $Tz->name));
        f8N:
        $rH = $xA->appendChild($this->encdoc->createElementNS(self::XMLENCNS, "\x78\145\156\x63\72\x43\x69\160\150\145\x72\x44\141\x74\x61"));
        $rH->appendChild($this->encdoc->createElementNS(self::XMLENCNS, "\x78\145\156\143\72\103\x69\x70\x68\145\162\x56\x61\154\165\145", $fW));
        if (!(is_array($this->references) && count($this->references) > 0)) {
            goto Ozr;
        }
        $Gi = $xA->appendChild($this->encdoc->createElementNS(self::XMLENCNS, "\x78\145\x6e\143\72\122\x65\x66\145\162\x65\156\143\x65\x4c\x69\x73\x74"));
        foreach ($this->references as $XE => $Y2) {
            $gz = $Y2["\x72\145\146\x75\x72\151"];
            $hl = $Gi->appendChild($this->encdoc->createElementNS(self::XMLENCNS, "\170\x65\156\x63\72\x44\141\x74\141\x52\145\146\145\x72\145\156\x63\x65"));
            $hl->setAttribute("\x55\x52\x49", "\x23" . $gz);
            y3i:
        }
        qVN:
        Ozr:
        return;
    }
    public function decryptKey($xA)
    {
        if ($xA->isEncrypted) {
            goto Mfi;
        }
        throw new Exception("\113\145\x79\40\151\163\40\x6e\157\x74\40\105\x6e\143\162\x79\x70\x74\x65\x64");
        Mfi:
        if (!empty($xA->key)) {
            goto Txj;
        }
        throw new Exception("\113\x65\x79\40\x69\163\40\x6d\151\x73\x73\151\x6e\147\x20\144\x61\164\x61\40\164\157\x20\x70\145\162\146\x6f\162\x6d\40\x74\150\145\40\x64\x65\143\x72\x79\160\164\151\x6f\156");
        Txj:
        return $this->decryptNode($xA, false);
    }
    public function locateEncryptedData($j2)
    {
        if ($j2 instanceof DOMDocument) {
            goto ddV;
        }
        $wP = $j2->ownerDocument;
        goto EQh;
        ddV:
        $wP = $j2;
        EQh:
        if (!$wP) {
            goto eCV;
        }
        $K_ = new DOMXPath($wP);
        $jz = "\57\57\x2a\133\x6c\157\x63\141\154\55\x6e\141\155\145\50\x29\75\47\x45\x6e\143\x72\171\x70\164\145\x64\x44\141\x74\x61\47\x20\141\156\144\x20\156\x61\x6d\145\x73\x70\x61\x63\145\55\x75\162\151\50\51\75\x27" . self::XMLENCNS . "\x27\135";
        $L5 = $K_->query($jz);
        return $L5->item(0);
        eCV:
        return null;
    }
    public function locateKey($Dg = null)
    {
        if (!empty($Dg)) {
            goto RyH;
        }
        $Dg = $this->rawNode;
        RyH:
        if ($Dg instanceof DOMNode) {
            goto VzT;
        }
        return null;
        VzT:
        if (!($wP = $Dg->ownerDocument)) {
            goto uVk;
        }
        $K_ = new DOMXPath($wP);
        $K_->registerNamespace("\x78\155\154\x73\x65\143\145\x6e\x63", self::XMLENCNS);
        $jz = "\x2e\x2f\57\x78\x6d\154\163\x65\143\145\x6e\x63\x3a\x45\156\x63\162\171\x70\164\x69\157\156\115\145\x74\150\157\x64";
        $L5 = $K_->query($jz, $Dg);
        if (!($pU = $L5->item(0))) {
            goto vwS;
        }
        $A8 = $pU->getAttribute("\101\x6c\147\157\x72\151\x74\x68\x6d");
        try {
            $JP = new XMLSecurityKey($A8, array("\164\171\x70\x65" => "\x70\162\x69\166\x61\x74\x65"));
        } catch (Exception $LR) {
            return null;
        }
        return $JP;
        vwS:
        uVk:
        return null;
    }
    public static function staticLocateKeyInfo($ng = null, $Dg = null)
    {
        if (!(empty($Dg) || !$Dg instanceof DOMNode)) {
            goto wOd;
        }
        return null;
        wOd:
        $wP = $Dg->ownerDocument;
        if ($wP) {
            goto OIm;
        }
        return null;
        OIm:
        $K_ = new DOMXPath($wP);
        $K_->registerNamespace("\x78\155\x6c\x73\145\x63\145\156\143", self::XMLENCNS);
        $K_->registerNamespace("\170\155\x6c\x73\x65\x63\x64\x73\151\147", XMLSecurityDSig::XMLDSIGNS);
        $jz = "\x2e\x2f\170\155\x6c\x73\145\143\x64\163\151\147\x3a\113\145\x79\x49\156\146\x6f";
        $L5 = $K_->query($jz, $Dg);
        $pU = $L5->item(0);
        if ($pU) {
            goto gy1;
        }
        return $ng;
        gy1:
        foreach ($pU->childNodes as $BL) {
            switch ($BL->localName) {
                case "\113\145\171\116\x61\155\x65":
                    if (empty($ng)) {
                        goto Xml;
                    }
                    $ng->name = $BL->nodeValue;
                    Xml:
                    goto RbP;
                case "\113\x65\x79\126\x61\154\x75\145":
                    foreach ($BL->childNodes as $JU) {
                        switch ($JU->localName) {
                            case "\x44\x53\101\113\145\x79\126\x61\154\165\145":
                                throw new Exception("\104\123\x41\113\145\x79\x56\141\154\x75\145\40\143\x75\x72\x72\x65\x6e\164\154\x79\40\x6e\157\x74\40\163\x75\x70\160\157\162\164\x65\x64");
                            case "\122\123\101\113\x65\x79\x56\141\154\165\145":
                                $tP = null;
                                $Vy = null;
                                if (!($kM = $JU->getElementsByTagName("\115\157\144\165\154\165\163")->item(0))) {
                                    goto inS;
                                }
                                $tP = base64_decode($kM->nodeValue);
                                inS:
                                if (!($Rs = $JU->getElementsByTagName("\x45\x78\160\157\156\x65\x6e\x74")->item(0))) {
                                    goto BO6;
                                }
                                $Vy = base64_decode($Rs->nodeValue);
                                BO6:
                                if (!(empty($tP) || empty($Vy))) {
                                    goto K_E;
                                }
                                throw new Exception("\115\x69\163\163\x69\156\147\x20\115\x6f\144\165\x6c\x75\x73\40\157\162\40\105\170\x70\x6f\x6e\145\156\164");
                                K_E:
                                $NL = XMLSecurityKey::convertRSA($tP, $Vy);
                                $ng->loadKey($NL);
                                goto UD1;
                        }
                        UXj:
                        UD1:
                        Vl5:
                    }
                    XYu:
                    goto RbP;
                case "\x52\145\164\162\151\145\166\141\154\x4d\145\164\150\x6f\x64":
                    $u8 = $BL->getAttribute("\124\171\160\145");
                    if (!($u8 !== "\x68\x74\164\160\72\57\57\x77\x77\x77\56\x77\63\56\157\x72\147\57\x32\x30\60\x31\x2f\x30\x34\x2f\170\155\x6c\x65\156\x63\x23\x45\156\143\162\171\x70\164\x65\x64\113\145\171")) {
                        goto LBc;
                    }
                    goto RbP;
                    LBc:
                    $XK = $BL->getAttribute("\125\x52\x49");
                    if (!($XK[0] !== "\43")) {
                        goto CM5;
                    }
                    goto RbP;
                    CM5:
                    $Jy = substr($XK, 1);
                    $jz = "\57\x2f\170\155\154\163\x65\x63\145\x6e\x63\x3a\x45\x6e\x63\x72\171\160\164\x65\144\113\145\x79\133\x40\111\144\75\42" . XPath::filterAttrValue($Jy, XPath::DOUBLE_QUOTE) . "\x22\135";
                    $wW = $K_->query($jz)->item(0);
                    if ($wW) {
                        goto vka;
                    }
                    throw new Exception("\125\x6e\x61\x62\x6c\145\40\164\x6f\x20\154\157\x63\x61\x74\145\40\x45\x6e\x63\x72\171\160\164\x65\144\x4b\145\171\40\x77\151\x74\x68\40\x40\x49\144\75\47{$Jy}\47\x2e");
                    vka:
                    return XMLSecurityKey::fromEncryptedKeyElement($wW);
                case "\x45\x6e\143\162\x79\x70\x74\x65\x64\x4b\x65\171":
                    return XMLSecurityKey::fromEncryptedKeyElement($BL);
                case "\130\x35\60\x39\x44\141\x74\141":
                    if (!($va = $BL->getElementsByTagName("\x58\65\60\x39\103\x65\x72\x74\151\146\151\x63\x61\164\x65"))) {
                        goto x9n;
                    }
                    if (!($va->length > 0)) {
                        goto fGY;
                    }
                    $CF = $va->item(0)->textContent;
                    $CF = str_replace(array("\15", "\xa", "\x20"), '', $CF);
                    $CF = "\x2d\55\x2d\55\55\x42\105\107\111\116\40\x43\x45\122\124\x49\x46\111\103\x41\x54\105\55\x2d\x2d\x2d\55\xa" . chunk_split($CF, 64, "\12") . "\55\x2d\x2d\55\55\105\116\x44\x20\103\105\122\x54\x49\x46\x49\x43\101\124\105\x2d\x2d\55\55\55\xa";
                    $ng->loadKey($CF, false, true);
                    fGY:
                    x9n:
                    goto RbP;
            }
            ot_:
            RbP:
            aCQ:
        }
        mUX:
        return $ng;
    }
    public function locateKeyInfo($ng = null, $Dg = null)
    {
        if (!empty($Dg)) {
            goto Zt6;
        }
        $Dg = $this->rawNode;
        Zt6:
        return self::staticLocateKeyInfo($ng, $Dg);
    }
}
