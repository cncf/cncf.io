<?php


include_once "\x55\164\x69\x6c\151\164\151\x65\x73\x2e\x70\150\x70";
include_once "\x78\155\x6c\163\145\143\154\151\142\x73\56\x70\150\160";
use RobRichards\XMLSecLibs\XMLSecurityKey;
use RobRichards\XMLSecLibs\XMLSecurityDSig;
use RobRichards\XMLSecLibs\XMLSecEnc;
class SAML2SPLogoutRequest
{
    private $tagName;
    private $id;
    private $issuer;
    private $destination;
    private $issueInstant;
    private $certificates;
    private $validators;
    private $notOnOrAfter;
    private $encryptedNameId;
    private $nameId;
    private $sessionIndexes;
    public function __construct(DOMElement $Cr = NULL)
    {
        $this->tagName = "\x4c\x6f\x67\157\165\x74\122\145\161\165\145\163\164";
        $this->id = SAMLSPUtilities::generateID();
        $this->issueInstant = time();
        $this->certificates = array();
        $this->validators = array();
        if (!($Cr === NULL)) {
            goto t9;
        }
        return;
        t9:
        if ($Cr->hasAttribute("\x49\104")) {
            goto D7;
        }
        throw new Exception("\115\151\163\x73\x69\156\x67\40\x49\x44\40\141\x74\x74\162\151\x62\x75\164\145\x20\x6f\x6e\x20\x53\101\x4d\x4c\40\155\145\163\163\141\x67\145\x2e");
        D7:
        $this->id = $Cr->getAttribute("\x49\104");
        if (!($Cr->getAttribute("\x56\x65\x72\x73\x69\x6f\156") !== "\x32\x2e\x30")) {
            goto Y2;
        }
        throw new Exception("\x55\x6e\163\165\160\160\x6f\x72\x74\x65\144\40\166\145\x72\163\x69\157\156\72\x20" . $Cr->getAttribute("\x56\x65\x72\163\x69\157\x6e"));
        Y2:
        $this->issueInstant = SAMLSPUtilities::xsDateTimeToTimestamp($Cr->getAttribute("\x49\x73\163\165\145\111\156\163\x74\141\x6e\x74"));
        if (!$Cr->hasAttribute("\x44\145\x73\164\x69\156\x61\164\x69\x6f\x6e")) {
            goto yv;
        }
        $this->destination = $Cr->getAttribute("\x44\x65\163\164\x69\156\x61\164\x69\157\x6e");
        yv:
        $o3 = SAMLSPUtilities::xpQuery($Cr, "\x2e\x2f\x73\x61\155\154\x5f\141\163\x73\x65\x72\164\151\x6f\x6e\x3a\111\163\163\165\145\162");
        if (empty($o3)) {
            goto l5;
        }
        $this->issuer = trim($o3[0]->textContent);
        l5:
        try {
            $DD = SAMLSPUtilities::validateElement($Cr);
            if (!($DD !== FALSE)) {
                goto ny;
            }
            $this->certificates = $DD["\103\x65\x72\x74\151\x66\x69\x63\x61\x74\145\163"];
            $this->validators[] = array("\x46\165\x6e\x63\x74\151\x6f\156" => array("\x55\x74\x69\154\x69\x74\x69\145\163", "\166\x61\154\x69\x64\x61\x74\145\x53\151\x67\x6e\x61\164\165\x72\x65"), "\x44\141\164\141" => $DD);
            ny:
        } catch (Exception $LR) {
        }
        $this->sessionIndexes = array();
        if (!$Cr->hasAttribute("\x4e\157\x74\117\x6e\x4f\x72\x41\x66\164\145\x72")) {
            goto XX;
        }
        $this->notOnOrAfter = SAMLSPUtilities::xsDateTimeToTimestamp($Cr->getAttribute("\x4e\157\164\x4f\156\117\162\x41\146\x74\145\x72"));
        XX:
        $dN = SAMLSPUtilities::xpQuery($Cr, "\56\x2f\163\x61\155\x6c\x5f\141\x73\163\145\162\164\x69\x6f\x6e\72\116\x61\x6d\x65\x49\x44\x20\174\40\56\x2f\163\x61\x6d\x6c\x5f\x61\x73\x73\x65\x72\164\x69\x6f\156\x3a\105\156\143\162\171\x70\164\145\x64\111\104\57\x78\x65\156\143\72\105\x6e\143\x72\171\160\x74\145\144\x44\x61\x74\x61");
        if (empty($dN)) {
            goto gU;
        }
        if (count($dN) > 1) {
            goto Hp;
        }
        goto o2;
        gU:
        throw new Exception("\115\151\x73\163\151\x6e\x67\x20\x3c\163\141\x6d\154\x3a\x4e\141\155\x65\111\104\x3e\40\157\162\40\x3c\x73\x61\x6d\x6c\x3a\105\x6e\143\x72\x79\x70\x74\145\144\x49\x44\x3e\x20\151\x6e\x20\x3c\163\141\x6d\154\160\72\x4c\157\x67\x6f\165\164\x52\x65\x71\x75\x65\x73\164\x3e\56");
        goto o2;
        Hp:
        throw new Exception("\115\x6f\x72\x65\40\x74\150\141\156\x20\157\x6e\145\40\74\x73\141\155\154\x3a\116\x61\155\145\x49\104\x3e\x20\x6f\x72\40\x3c\x73\141\x6d\x6c\x3a\105\156\143\162\x79\160\x74\145\x64\104\x3e\40\x69\156\40\74\x73\x61\155\x6c\x70\x3a\x4c\x6f\147\x6f\x75\164\x52\x65\x71\x75\x65\163\x74\x3e\56");
        o2:
        $dN = $dN[0];
        if ($dN->localName === "\105\x6e\x63\x72\171\160\x74\x65\x64\104\141\164\141") {
            goto ze;
        }
        $this->nameId = SAMLSPUtilities::parseNameId($dN);
        goto Jt;
        ze:
        $this->encryptedNameId = $dN;
        Jt:
        $wt = SAMLSPUtilities::xpQuery($Cr, "\x2e\x2f\163\x61\155\154\137\x70\x72\x6f\164\157\143\x6f\154\72\x53\145\163\163\x69\x6f\x6e\111\156\144\145\170");
        foreach ($wt as $T5) {
            $this->sessionIndexes[] = trim($T5->textContent);
            Qy:
        }
        e6:
    }
    public function getNotOnOrAfter()
    {
        return $this->notOnOrAfter;
    }
    public function setNotOnOrAfter($qA)
    {
        $this->notOnOrAfter = $qA;
    }
    public function isNameIdEncrypted()
    {
        if (!($this->encryptedNameId !== NULL)) {
            goto s1;
        }
        return TRUE;
        s1:
        return FALSE;
    }
    public function encryptNameId(XMLSecurityKey $uZ)
    {
        $wP = new DOMDocument();
        $pZ = $wP->createElement("\x72\x6f\x6f\164");
        $wP->appendChild($pZ);
        SAML2_Utils::addNameId($pZ, $this->nameId);
        $dN = $pZ->firstChild;
        SAML2_Utils::getContainer()->debugMessage($dN, "\145\x6e\x63\162\171\x70\164");
        $GV = new XMLSecEnc();
        $GV->setNode($dN);
        $GV->type = XMLSecEnc::Element;
        $dV = new XMLSecurityKey(XMLSecurityKey::AES128_CBC);
        $dV->generateSessionKey();
        $GV->encryptKey($uZ, $dV);
        $this->encryptedNameId = $GV->encryptNode($dV);
        $this->nameId = NULL;
    }
    public function decryptNameId(XMLSecurityKey $uZ, array $aK = array())
    {
        if (!($this->encryptedNameId === NULL)) {
            goto EV;
        }
        return;
        EV:
        $dN = SAML2_Utils::decryptElement($this->encryptedNameId, $uZ, $aK);
        SAML2_Utils::getContainer()->debugMessage($dN, "\144\145\x63\x72\171\x70\164");
        $this->nameId = SAML2_Utils::parseNameId($dN);
        $this->encryptedNameId = NULL;
    }
    public function getNameId()
    {
        if (!($this->encryptedNameId !== NULL)) {
            goto n3;
        }
        throw new Exception("\101\164\x74\145\x6d\x70\164\145\x64\x20\x74\157\40\162\x65\x74\162\x69\x65\x76\145\40\x65\x6e\143\162\171\160\x74\x65\144\x20\x4e\141\x6d\145\x49\104\x20\167\151\164\x68\x6f\165\x74\40\x64\145\x63\162\171\160\x74\x69\x6e\147\x20\x69\x74\x20\x66\151\x72\163\164\x2e");
        n3:
        return $this->nameId;
    }
    public function setNameId($dN)
    {
        $this->nameId = $dN;
    }
    public function getSessionIndexes()
    {
        return $this->sessionIndexes;
    }
    public function setSessionIndexes(array $wt)
    {
        $this->sessionIndexes = $wt;
    }
    public function getSessionIndex()
    {
        if (!empty($this->sessionIndexes)) {
            goto ov;
        }
        return NULL;
        ov:
        return $this->sessionIndexes[0];
    }
    public function setSessionIndex($T5)
    {
        if (is_null($T5)) {
            goto OU;
        }
        $this->sessionIndexes = array($T5);
        goto MW;
        OU:
        $this->sessionIndexes = array();
        MW:
    }
    public function getId()
    {
        return $this->id;
    }
    public function setId($Jy)
    {
        $this->id = $Jy;
    }
    public function getIssueInstant()
    {
        return $this->issueInstant;
    }
    public function setIssueInstant($Kx)
    {
        $this->issueInstant = $Kx;
    }
    public function getDestination()
    {
        return $this->destination;
    }
    public function setDestination($un)
    {
        $this->destination = $un;
    }
    public function getIssuer()
    {
        return $this->issuer;
    }
    public function setIssuer($o3)
    {
        $this->issuer = $o3;
    }
}
