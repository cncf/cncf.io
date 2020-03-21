<?php


namespace RobRichards\XMLSecLibs;

use DOMDocument;
use DOMNode;
use DOMXPath;
use Exception;
use RobRichards\XMLSecLibs\Utils\XPath;
class XMLSecEnc
{
    const template = "\x3c\x78\145\156\x63\72\105\x6e\x63\162\x79\x70\164\x65\x64\104\x61\x74\141\40\170\155\154\x6e\x73\x3a\170\145\156\143\x3d\47\150\164\164\160\72\x2f\x2f\x77\x77\x77\56\x77\x33\56\157\x72\147\x2f\62\60\60\x31\57\60\x34\x2f\170\x6d\x6c\x65\x6e\143\x23\x27\x3e\12\40\x20\x20\x3c\x78\x65\x6e\x63\x3a\103\x69\160\150\145\x72\x44\x61\x74\141\x3e\12\40\x20\x20\x20\40\40\x3c\x78\145\156\143\72\103\151\160\150\145\162\126\141\154\165\145\76\74\57\170\x65\x6e\x63\x3a\x43\x69\x70\x68\145\162\126\x61\154\x75\x65\x3e\xa\40\40\x20\74\x2f\170\x65\156\143\72\103\x69\x70\150\145\162\104\141\164\x61\76\12\x3c\57\170\145\156\143\72\105\x6e\143\162\171\160\164\145\x64\x44\141\x74\141\76";
    const Element = "\x68\164\x74\x70\72\57\x2f\167\167\x77\x2e\x77\63\x2e\x6f\162\147\x2f\62\x30\x30\x31\57\60\64\57\x78\155\x6c\x65\x6e\x63\43\105\x6c\x65\155\x65\x6e\164";
    const Content = "\150\x74\x74\160\x3a\57\57\167\167\167\56\x77\x33\56\x6f\162\x67\x2f\62\60\60\61\57\x30\x34\57\170\155\154\x65\156\x63\43\103\x6f\x6e\164\x65\156\x74";
    const URI = 3;
    const XMLENCNS = "\x68\x74\164\160\72\57\x2f\x77\167\x77\x2e\x77\x33\x2e\157\x72\x67\x2f\62\60\x30\61\x2f\x30\64\x2f\170\155\154\145\x6e\x63\43";
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
    public function addReference($AF, $rf, $fH)
    {
        if ($rf instanceof DOMNode) {
            goto ttQ;
        }
        throw new Exception("\44\156\157\144\x65\x20\151\x73\40\x6e\x6f\164\40\157\x66\x20\x74\x79\160\x65\x20\104\117\x4d\x4e\157\144\145");
        ttQ:
        $sw = $this->encdoc;
        $this->_resetTemplate();
        $rl = $this->encdoc;
        $this->encdoc = $sw;
        $kK = XMLSecurityDSig::generateGUID();
        $z2 = $rl->documentElement;
        $z2->setAttribute("\111\144", $kK);
        $this->references[$AF] = array("\x6e\x6f\144\145" => $rf, "\164\171\x70\145" => $fH, "\x65\156\x63\156\157\x64\x65" => $rl, "\x72\145\146\165\x72\x69" => $kK);
    }
    public function setNode($rf)
    {
        $this->rawNode = $rf;
    }
    public function encryptNode($In, $Nb = true)
    {
        $rL = '';
        if (!empty($this->rawNode)) {
            goto eHb;
        }
        throw new Exception("\116\157\144\x65\x20\x74\x6f\40\x65\156\143\x72\x79\x70\164\40\x68\x61\163\x20\156\157\x74\x20\x62\145\145\x6e\40\163\145\164");
        eHb:
        if ($In instanceof XMLSecurityKey) {
            goto XLK;
        }
        throw new Exception("\x49\156\x76\141\x6c\151\x64\x20\113\145\x79");
        XLK:
        $Yf = $this->rawNode->ownerDocument;
        $Rs = new DOMXPath($this->encdoc);
        $Uv = $Rs->query("\x2f\x78\x65\x6e\143\72\x45\x6e\143\162\171\160\x74\145\x64\104\x61\164\141\57\x78\145\x6e\x63\x3a\x43\x69\x70\150\x65\162\x44\141\x74\141\x2f\x78\x65\156\x63\72\103\151\x70\150\x65\162\126\x61\154\x75\145");
        $Os = $Uv->item(0);
        if (!($Os == null)) {
            goto FrY;
        }
        throw new Exception("\x45\162\162\x6f\162\x20\x6c\157\x63\141\x74\x69\x6e\147\40\103\x69\160\x68\145\162\126\x61\x6c\165\145\40\145\x6c\145\155\x65\156\164\x20\167\x69\164\x68\151\156\x20\x74\x65\x6d\160\x6c\141\164\145");
        FrY:
        switch ($this->type) {
            case self::Element:
                $rL = $Yf->saveXML($this->rawNode);
                $this->encdoc->documentElement->setAttribute("\124\x79\160\x65", self::Element);
                goto RNw;
            case self::Content:
                $Gk = $this->rawNode->childNodes;
                foreach ($Gk as $TI) {
                    $rL .= $Yf->saveXML($TI);
                    a9J:
                }
                m8O:
                $this->encdoc->documentElement->setAttribute("\124\x79\160\145", self::Content);
                goto RNw;
            default:
                throw new Exception("\x54\171\160\x65\40\151\x73\x20\x63\165\162\x72\145\x6e\164\x6c\x79\40\156\157\x74\40\163\x75\x70\160\x6f\162\x74\145\144");
        }
        RPi:
        RNw:
        $Z5 = $this->encdoc->documentElement->appendChild($this->encdoc->createElementNS(self::XMLENCNS, "\x78\x65\156\143\72\x45\x6e\143\162\x79\x70\x74\x69\157\156\x4d\145\164\150\157\144"));
        $Z5->setAttribute("\101\x6c\x67\x6f\162\151\164\x68\155", $In->getAlgorithm());
        $Os->parentNode->parentNode->insertBefore($Z5, $Os->parentNode->parentNode->firstChild);
        $Pg = base64_encode($In->encryptData($rL));
        $g2 = $this->encdoc->createTextNode($Pg);
        $Os->appendChild($g2);
        if ($Nb) {
            goto Xso;
        }
        return $this->encdoc->documentElement;
        goto Nfa;
        Xso:
        switch ($this->type) {
            case self::Element:
                if (!($this->rawNode->nodeType == XML_DOCUMENT_NODE)) {
                    goto pEg;
                }
                return $this->encdoc;
                pEg:
                $Fl = $this->rawNode->ownerDocument->importNode($this->encdoc->documentElement, true);
                $this->rawNode->parentNode->replaceChild($Fl, $this->rawNode);
                return $Fl;
            case self::Content:
                $Fl = $this->rawNode->ownerDocument->importNode($this->encdoc->documentElement, true);
                DPy:
                if (!$this->rawNode->firstChild) {
                    goto Bj_;
                }
                $this->rawNode->removeChild($this->rawNode->firstChild);
                goto DPy;
                Bj_:
                $this->rawNode->appendChild($Fl);
                return $Fl;
        }
        P4e:
        KzD:
        Nfa:
    }
    public function encryptReferences($In)
    {
        $jv = $this->rawNode;
        $ic = $this->type;
        foreach ($this->references as $AF => $Du) {
            $this->encdoc = $Du["\145\156\143\x6e\x6f\144\x65"];
            $this->rawNode = $Du["\x6e\157\x64\145"];
            $this->type = $Du["\x74\171\160\145"];
            try {
                $U1 = $this->encryptNode($In);
                $this->references[$AF]["\x65\x6e\x63\x6e\x6f\x64\x65"] = $U1;
            } catch (Exception $A4) {
                $this->rawNode = $jv;
                $this->type = $ic;
                throw $A4;
            }
            gbp:
        }
        DnU:
        $this->rawNode = $jv;
        $this->type = $ic;
    }
    public function getCipherValue()
    {
        if (!empty($this->rawNode)) {
            goto beT;
        }
        throw new Exception("\116\x6f\144\x65\x20\x74\157\40\x64\x65\143\162\171\x70\x74\x20\x68\141\x73\40\156\157\164\40\142\145\145\x6e\x20\163\145\x74");
        beT:
        $Yf = $this->rawNode->ownerDocument;
        $Rs = new DOMXPath($Yf);
        $Rs->registerNamespace("\x78\x6d\154\145\x6e\143\x72", self::XMLENCNS);
        $ye = "\x2e\57\x78\155\154\x65\156\143\x72\x3a\x43\x69\160\x68\145\x72\104\141\164\141\x2f\170\x6d\x6c\145\x6e\143\162\72\x43\x69\160\x68\145\x72\x56\141\154\165\x65";
        $fU = $Rs->query($ye, $this->rawNode);
        $rf = $fU->item(0);
        if ($rf) {
            goto jOE;
        }
        return null;
        jOE:
        return base64_decode($rf->nodeValue);
    }
    public function decryptNode($In, $Nb = true)
    {
        if ($In instanceof XMLSecurityKey) {
            goto t75;
        }
        throw new Exception("\111\x6e\x76\141\x6c\151\144\x20\113\145\x79");
        t75:
        $oU = $this->getCipherValue();
        if ($oU) {
            goto mQt;
        }
        throw new Exception("\x43\x61\x6e\x6e\x6f\x74\40\154\157\143\141\x74\145\x20\145\x6e\x63\x72\171\160\164\x65\144\40\x64\x61\x74\141");
        goto oO8;
        mQt:
        $iX = $In->decryptData($oU);
        if ($Nb) {
            goto WV7;
        }
        return $iX;
        goto UNd;
        WV7:
        switch ($this->type) {
            case self::Element:
                $ay = new DOMDocument();
                $ay->loadXML($iX);
                if (!($this->rawNode->nodeType == XML_DOCUMENT_NODE)) {
                    goto f9B;
                }
                return $ay;
                f9B:
                $Fl = $this->rawNode->ownerDocument->importNode($ay->documentElement, true);
                $this->rawNode->parentNode->replaceChild($Fl, $this->rawNode);
                return $Fl;
            case self::Content:
                if ($this->rawNode->nodeType == XML_DOCUMENT_NODE) {
                    goto Gvw;
                }
                $Yf = $this->rawNode->ownerDocument;
                goto Suz;
                Gvw:
                $Yf = $this->rawNode;
                Suz:
                $Sx = $Yf->createDocumentFragment();
                $Sx->appendXML($iX);
                $ME = $this->rawNode->parentNode;
                $ME->replaceChild($Sx, $this->rawNode);
                return $ME;
            default:
                return $iX;
        }
        CRe:
        J04:
        UNd:
        oO8:
    }
    public function encryptKey($ob, $xW, $cG = true)
    {
        if (!(!$ob instanceof XMLSecurityKey || !$xW instanceof XMLSecurityKey)) {
            goto ALE;
        }
        throw new Exception("\111\x6e\166\141\154\151\144\x20\113\145\171");
        ALE:
        $Ez = base64_encode($ob->encryptData($xW->key));
        $F4 = $this->encdoc->documentElement;
        $Wb = $this->encdoc->createElementNS(self::XMLENCNS, "\x78\x65\x6e\x63\x3a\x45\156\143\x72\171\x70\x74\145\x64\x4b\145\171");
        if ($cG) {
            goto kYk;
        }
        $this->encKey = $Wb;
        goto NvC;
        kYk:
        $qf = $F4->insertBefore($this->encdoc->createElementNS("\150\164\x74\x70\x3a\x2f\x2f\167\167\167\56\x77\63\56\x6f\162\x67\x2f\62\x30\x30\60\57\x30\x39\57\x78\155\154\x64\x73\x69\x67\x23", "\144\163\x69\x67\x3a\x4b\145\171\111\156\x66\x6f"), $F4->firstChild);
        $qf->appendChild($Wb);
        NvC:
        $Z5 = $Wb->appendChild($this->encdoc->createElementNS(self::XMLENCNS, "\x78\x65\x6e\x63\72\105\156\143\162\x79\160\x74\x69\x6f\156\x4d\145\x74\x68\x6f\144"));
        $Z5->setAttribute("\x41\x6c\147\x6f\162\x69\164\x68\x6d", $ob->getAlgorith());
        if (empty($ob->name)) {
            goto eSF;
        }
        $qf = $Wb->appendChild($this->encdoc->createElementNS("\x68\164\164\x70\72\x2f\x2f\x77\x77\x77\x2e\x77\x33\x2e\157\x72\x67\57\x32\x30\x30\60\57\60\x39\x2f\x78\155\x6c\144\x73\x69\147\43", "\144\163\x69\147\72\113\x65\171\111\156\146\x6f"));
        $qf->appendChild($this->encdoc->createElementNS("\x68\164\x74\x70\72\57\x2f\x77\167\167\56\167\x33\x2e\157\162\147\x2f\x32\60\60\x30\57\60\71\x2f\x78\x6d\154\x64\x73\151\x67\43", "\144\x73\x69\147\x3a\113\x65\171\x4e\141\155\145", $ob->name));
        eSF:
        $t3 = $Wb->appendChild($this->encdoc->createElementNS(self::XMLENCNS, "\170\x65\156\x63\72\x43\x69\x70\x68\x65\x72\x44\x61\164\141"));
        $t3->appendChild($this->encdoc->createElementNS(self::XMLENCNS, "\x78\145\156\x63\72\x43\x69\160\x68\145\162\126\141\x6c\165\x65", $Ez));
        if (!(is_array($this->references) && count($this->references) > 0)) {
            goto kTc;
        }
        $de = $Wb->appendChild($this->encdoc->createElementNS(self::XMLENCNS, "\170\x65\x6e\x63\x3a\122\145\146\x65\x72\145\156\143\145\114\151\163\164"));
        foreach ($this->references as $AF => $Du) {
            $kK = $Du["\x72\145\x66\165\x72\151"];
            $Ug = $de->appendChild($this->encdoc->createElementNS(self::XMLENCNS, "\x78\145\156\143\x3a\x44\x61\164\141\x52\145\146\145\162\x65\x6e\x63\x65"));
            $Ug->setAttribute("\125\122\111", "\x23" . $kK);
            Ll6:
        }
        a4s:
        kTc:
        return;
    }
    public function decryptKey($Wb)
    {
        if ($Wb->isEncrypted) {
            goto F1_;
        }
        throw new Exception("\113\x65\171\x20\151\x73\40\156\157\x74\x20\105\156\143\x72\171\x70\164\x65\x64");
        F1_:
        if (!empty($Wb->key)) {
            goto y75;
        }
        throw new Exception("\x4b\145\x79\x20\151\163\x20\x6d\x69\163\163\151\156\147\40\x64\141\164\x61\x20\x74\x6f\x20\160\145\x72\x66\x6f\x72\x6d\40\x74\150\145\x20\x64\145\143\x72\x79\x70\164\x69\x6f\x6e");
        y75:
        return $this->decryptNode($Wb, false);
    }
    public function locateEncryptedData($z2)
    {
        if ($z2 instanceof DOMDocument) {
            goto HmF;
        }
        $Yf = $z2->ownerDocument;
        goto H1o;
        HmF:
        $Yf = $z2;
        H1o:
        if (!$Yf) {
            goto BZm;
        }
        $Cu = new DOMXPath($Yf);
        $ye = "\57\57\52\133\154\157\x63\141\154\x2d\156\x61\x6d\145\50\x29\75\47\x45\156\143\x72\171\x70\164\x65\144\104\141\164\x61\x27\40\x61\x6e\x64\x20\156\x61\155\x65\x73\160\141\x63\145\55\165\x72\151\x28\51\75\47" . self::XMLENCNS . "\47\135";
        $fU = $Cu->query($ye);
        return $fU->item(0);
        BZm:
        return null;
    }
    public function locateKey($rf = null)
    {
        if (!empty($rf)) {
            goto NaY;
        }
        $rf = $this->rawNode;
        NaY:
        if ($rf instanceof DOMNode) {
            goto rcR;
        }
        return null;
        rcR:
        if (!($Yf = $rf->ownerDocument)) {
            goto HWG;
        }
        $Cu = new DOMXPath($Yf);
        $Cu->registerNamespace("\170\155\154\163\x65\x63\145\156\x63", self::XMLENCNS);
        $ye = "\x2e\57\57\170\155\154\x73\x65\x63\145\x6e\x63\72\x45\156\x63\162\x79\x70\x74\x69\157\156\115\x65\164\150\157\144";
        $fU = $Cu->query($ye, $rf);
        if (!($et = $fU->item(0))) {
            goto I4F;
        }
        $q3 = $et->getAttribute("\x41\x6c\147\x6f\162\x69\164\x68\x6d");
        try {
            $In = new XMLSecurityKey($q3, array("\x74\x79\160\x65" => "\x70\x72\151\166\141\164\x65"));
        } catch (Exception $A4) {
            return null;
        }
        return $In;
        I4F:
        HWG:
        return null;
    }
    public static function staticLocateKeyInfo($q8 = null, $rf = null)
    {
        if (!(empty($rf) || !$rf instanceof DOMNode)) {
            goto ZLI;
        }
        return null;
        ZLI:
        $Yf = $rf->ownerDocument;
        if ($Yf) {
            goto cSE;
        }
        return null;
        cSE:
        $Cu = new DOMXPath($Yf);
        $Cu->registerNamespace("\170\x6d\x6c\163\145\x63\x65\x6e\143", self::XMLENCNS);
        $Cu->registerNamespace("\x78\155\154\163\x65\x63\x64\x73\x69\x67", XMLSecurityDSig::XMLDSIGNS);
        $ye = "\56\57\x78\x6d\x6c\x73\x65\x63\x64\x73\151\147\72\113\x65\171\x49\x6e\x66\157";
        $fU = $Cu->query($ye, $rf);
        $et = $fU->item(0);
        if ($et) {
            goto ybC;
        }
        return $q8;
        ybC:
        foreach ($et->childNodes as $TI) {
            switch ($TI->localName) {
                case "\x4b\x65\171\x4e\x61\155\x65":
                    if (empty($q8)) {
                        goto Q_A;
                    }
                    $q8->name = $TI->nodeValue;
                    Q_A:
                    goto Ui1;
                case "\x4b\145\x79\x56\141\154\x75\145":
                    foreach ($TI->childNodes as $eo) {
                        switch ($eo->localName) {
                            case "\104\x53\101\x4b\145\x79\126\141\154\x75\x65":
                                throw new Exception("\x44\x53\x41\x4b\x65\x79\126\141\x6c\x75\145\x20\x63\165\162\162\x65\x6e\164\154\171\x20\156\x6f\164\40\163\165\x70\160\157\x72\x74\x65\144");
                            case "\122\123\101\113\145\x79\126\141\x6c\x75\145":
                                $H5 = null;
                                $Z_ = null;
                                if (!($cj = $eo->getElementsByTagName("\115\x6f\144\165\x6c\x75\163")->item(0))) {
                                    goto que;
                                }
                                $H5 = base64_decode($cj->nodeValue);
                                que:
                                if (!($yk = $eo->getElementsByTagName("\x45\170\x70\x6f\x6e\145\156\164")->item(0))) {
                                    goto Tnb;
                                }
                                $Z_ = base64_decode($yk->nodeValue);
                                Tnb:
                                if (!(empty($H5) || empty($Z_))) {
                                    goto Kna;
                                }
                                throw new Exception("\115\x69\163\163\x69\x6e\x67\x20\115\157\144\x75\x6c\165\163\x20\157\x72\40\105\x78\x70\157\x6e\145\x6e\164");
                                Kna:
                                $MX = XMLSecurityKey::convertRSA($H5, $Z_);
                                $q8->loadKey($MX);
                                goto jX2;
                        }
                        snI:
                        jX2:
                        D1h:
                    }
                    MDI:
                    goto Ui1;
                case "\122\x65\x74\x72\151\145\166\141\154\115\145\164\x68\x6f\x64":
                    $fH = $TI->getAttribute("\x54\171\160\145");
                    if (!($fH !== "\x68\164\x74\160\x3a\x2f\57\x77\167\167\x2e\167\63\x2e\157\x72\147\x2f\x32\60\x30\x31\57\x30\64\x2f\170\155\154\x65\156\x63\x23\105\156\x63\162\171\160\164\x65\x64\x4b\x65\171")) {
                        goto O07;
                    }
                    goto Ui1;
                    O07:
                    $Ue = $TI->getAttribute("\x55\x52\111");
                    if (!($Ue[0] !== "\x23")) {
                        goto vhZ;
                    }
                    goto Ui1;
                    vhZ:
                    $tr = substr($Ue, 1);
                    $ye = "\57\x2f\x78\155\154\163\145\x63\145\x6e\143\x3a\105\156\x63\162\171\160\164\x65\144\113\145\x79\x5b\x40\x49\144\x3d\42" . XPath::filterAttrValue($tr, XPath::DOUBLE_QUOTE) . "\x22\x5d";
                    $Wo = $Cu->query($ye)->item(0);
                    if ($Wo) {
                        goto s13;
                    }
                    throw new Exception("\x55\x6e\141\x62\154\x65\x20\x74\157\x20\154\x6f\x63\x61\x74\x65\x20\105\156\x63\162\x79\160\164\x65\144\113\x65\171\40\167\x69\164\x68\40\x40\x49\x64\75\x27{$tr}\x27\x2e");
                    s13:
                    return XMLSecurityKey::fromEncryptedKeyElement($Wo);
                case "\105\156\x63\x72\x79\160\164\x65\x64\113\x65\x79":
                    return XMLSecurityKey::fromEncryptedKeyElement($TI);
                case "\x58\65\x30\x39\104\141\x74\141":
                    if (!($ah = $TI->getElementsByTagName("\x58\65\x30\x39\103\145\162\164\x69\x66\151\143\x61\164\x65"))) {
                        goto O8l;
                    }
                    if (!($ah->length > 0)) {
                        goto Cub;
                    }
                    $De = $ah->item(0)->textContent;
                    $De = str_replace(array("\xd", "\xa", "\40"), '', $De);
                    $De = "\x2d\55\x2d\55\x2d\102\105\x47\111\x4e\40\x43\105\122\x54\111\x46\x49\103\x41\x54\105\x2d\55\55\55\55\12" . chunk_split($De, 64, "\12") . "\55\55\x2d\x2d\x2d\x45\116\104\40\103\105\x52\x54\x49\x46\x49\x43\x41\124\105\x2d\55\55\x2d\55\xa";
                    $q8->loadKey($De, false, true);
                    Cub:
                    O8l:
                    goto Ui1;
            }
            PJS:
            Ui1:
            fVW:
        }
        iW9:
        return $q8;
    }
    public function locateKeyInfo($q8 = null, $rf = null)
    {
        if (!empty($rf)) {
            goto uuQ;
        }
        $rf = $this->rawNode;
        uuQ:
        return self::staticLocateKeyInfo($q8, $rf);
    }
}
