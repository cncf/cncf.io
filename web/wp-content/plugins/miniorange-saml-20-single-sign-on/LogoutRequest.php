<?php


include_once "\125\164\151\x6c\151\164\x69\145\x73\x2e\160\150\160";
include_once "\x78\x6d\x6c\163\145\x63\x6c\x69\x62\x73\x2e\x70\x68\160";
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
    public function __construct(DOMElement $pX = NULL)
    {
        $this->tagName = "\114\x6f\147\x6f\x75\164\x52\145\x71\x75\x65\x73\x74";
        $this->id = SAMLSPUtilities::generateID();
        $this->issueInstant = time();
        $this->certificates = array();
        $this->validators = array();
        if (!($pX === NULL)) {
            goto Oz;
        }
        return;
        Oz:
        if ($pX->hasAttribute("\111\104")) {
            goto eu;
        }
        throw new Exception("\115\x69\163\x73\x69\156\x67\40\x49\x44\40\x61\x74\x74\x72\151\142\165\164\145\40\157\156\x20\123\101\x4d\x4c\x20\x6d\145\163\163\141\x67\x65\56");
        eu:
        $this->id = $pX->getAttribute("\111\104");
        if (!($pX->getAttribute("\126\x65\x72\163\x69\157\156") !== "\x32\56\60")) {
            goto U1;
        }
        throw new Exception("\125\156\x73\165\160\160\x6f\x72\164\145\144\x20\x76\145\x72\x73\151\157\156\72\40" . $pX->getAttribute("\126\x65\162\x73\x69\x6f\156"));
        U1:
        $this->issueInstant = SAMLSPUtilities::xsDateTimeToTimestamp($pX->getAttribute("\111\163\x73\165\145\111\x6e\163\x74\x61\156\164"));
        if (!$pX->hasAttribute("\x44\145\163\x74\x69\156\x61\x74\x69\157\x6e")) {
            goto K9;
        }
        $this->destination = $pX->getAttribute("\x44\145\x73\164\151\156\x61\164\151\x6f\156");
        K9:
        $DR = SAMLSPUtilities::xpQuery($pX, "\56\x2f\x73\x61\x6d\154\x5f\x61\x73\163\145\162\x74\151\x6f\156\x3a\111\x73\163\165\145\x72");
        if (empty($DR)) {
            goto NT;
        }
        $this->issuer = trim($DR[0]->textContent);
        NT:
        try {
            $yL = SAMLSPUtilities::validateElement($pX);
            if (!($yL !== FALSE)) {
                goto B9;
            }
            $this->certificates = $yL["\x43\145\x72\164\151\146\151\143\141\164\145\x73"];
            $this->validators[] = array("\106\x75\156\x63\x74\x69\157\156" => array("\x55\x74\x69\x6c\x69\164\151\x65\x73", "\x76\141\154\x69\144\x61\x74\145\123\x69\x67\x6e\x61\x74\x75\162\145"), "\104\141\x74\x61" => $yL);
            B9:
        } catch (Exception $A4) {
        }
        $this->sessionIndexes = array();
        if (!$pX->hasAttribute("\x4e\x6f\x74\117\x6e\117\x72\101\x66\x74\x65\162")) {
            goto CZ;
        }
        $this->notOnOrAfter = SAMLSPUtilities::xsDateTimeToTimestamp($pX->getAttribute("\116\157\164\117\x6e\x4f\162\101\146\x74\x65\x72"));
        CZ:
        $RQ = SAMLSPUtilities::xpQuery($pX, "\56\x2f\x73\x61\x6d\154\x5f\x61\x73\x73\x65\162\x74\151\157\x6e\72\116\x61\x6d\x65\111\104\40\174\x20\x2e\57\x73\x61\x6d\x6c\137\x61\163\163\x65\x72\164\x69\x6f\156\72\105\156\x63\x72\171\x70\164\x65\x64\111\x44\x2f\x78\x65\156\x63\x3a\x45\x6e\143\x72\171\x70\x74\x65\144\104\x61\x74\141");
        if (empty($RQ)) {
            goto nf;
        }
        if (count($RQ) > 1) {
            goto J0;
        }
        goto Sk;
        nf:
        throw new Exception("\x4d\151\x73\163\151\x6e\147\40\x3c\x73\x61\x6d\x6c\x3a\116\x61\x6d\145\x49\104\76\40\x6f\162\x20\x3c\x73\x61\x6d\x6c\x3a\105\156\x63\x72\171\160\x74\145\144\x49\x44\x3e\40\x69\156\x20\x3c\163\141\155\x6c\x70\72\114\x6f\147\x6f\165\164\x52\x65\x71\x75\145\163\x74\76\x2e");
        goto Sk;
        J0:
        throw new Exception("\115\x6f\x72\x65\x20\x74\150\141\x6e\x20\x6f\x6e\x65\x20\74\x73\x61\x6d\154\x3a\116\141\155\x65\x49\x44\76\x20\157\x72\x20\74\163\141\155\154\72\105\156\143\162\171\160\164\145\x64\104\x3e\x20\151\156\40\74\163\141\155\154\x70\72\x4c\157\147\x6f\x75\164\x52\145\x71\165\x65\x73\164\76\56");
        Sk:
        $RQ = $RQ[0];
        if ($RQ->localName === "\105\x6e\x63\x72\x79\x70\164\145\144\x44\x61\164\141") {
            goto Xf;
        }
        $this->nameId = SAMLSPUtilities::parseNameId($RQ);
        goto pn;
        Xf:
        $this->encryptedNameId = $RQ;
        pn:
        $O2 = SAMLSPUtilities::xpQuery($pX, "\56\57\163\141\x6d\x6c\137\160\x72\x6f\164\157\x63\157\154\72\123\x65\x73\163\151\157\156\111\x6e\144\145\170");
        foreach ($O2 as $u4) {
            $this->sessionIndexes[] = trim($u4->textContent);
            ox:
        }
        MW:
    }
    public function getNotOnOrAfter()
    {
        return $this->notOnOrAfter;
    }
    public function setNotOnOrAfter($LP)
    {
        $this->notOnOrAfter = $LP;
    }
    public function isNameIdEncrypted()
    {
        if (!($this->encryptedNameId !== NULL)) {
            goto Xc;
        }
        return TRUE;
        Xc:
        return FALSE;
    }
    public function encryptNameId(XMLSecurityKey $ld)
    {
        $Yf = new DOMDocument();
        $F4 = $Yf->createElement("\162\x6f\x6f\164");
        $Yf->appendChild($F4);
        SAML2_Utils::addNameId($F4, $this->nameId);
        $RQ = $F4->firstChild;
        SAML2_Utils::getContainer()->debugMessage($RQ, "\145\156\x63\x72\171\160\164");
        $rg = new XMLSecEnc();
        $rg->setNode($RQ);
        $rg->type = XMLSecEnc::Element;
        $fP = new XMLSecurityKey(XMLSecurityKey::AES128_CBC);
        $fP->generateSessionKey();
        $rg->encryptKey($ld, $fP);
        $this->encryptedNameId = $rg->encryptNode($fP);
        $this->nameId = NULL;
    }
    public function decryptNameId(XMLSecurityKey $ld, array $hu = array())
    {
        if (!($this->encryptedNameId === NULL)) {
            goto nb;
        }
        return;
        nb:
        $RQ = SAML2_Utils::decryptElement($this->encryptedNameId, $ld, $hu);
        SAML2_Utils::getContainer()->debugMessage($RQ, "\x64\145\x63\162\171\x70\164");
        $this->nameId = SAML2_Utils::parseNameId($RQ);
        $this->encryptedNameId = NULL;
    }
    public function getNameId()
    {
        if (!($this->encryptedNameId !== NULL)) {
            goto PA;
        }
        throw new Exception("\x41\x74\x74\145\x6d\x70\164\145\144\40\x74\157\40\162\x65\164\x72\151\145\166\x65\x20\x65\156\143\x72\171\x70\164\x65\x64\40\x4e\141\x6d\x65\x49\104\40\x77\x69\164\x68\x6f\165\x74\x20\x64\145\143\x72\x79\x70\164\x69\156\x67\40\151\x74\40\146\151\162\x73\x74\56");
        PA:
        return $this->nameId;
    }
    public function setNameId($RQ)
    {
        $this->nameId = $RQ;
    }
    public function getSessionIndexes()
    {
        return $this->sessionIndexes;
    }
    public function setSessionIndexes(array $O2)
    {
        $this->sessionIndexes = $O2;
    }
    public function getSessionIndex()
    {
        if (!empty($this->sessionIndexes)) {
            goto Qw;
        }
        return NULL;
        Qw:
        return $this->sessionIndexes[0];
    }
    public function setSessionIndex($u4)
    {
        if (is_null($u4)) {
            goto hI;
        }
        $this->sessionIndexes = array($u4);
        goto uk;
        hI:
        $this->sessionIndexes = array();
        uk:
    }
    public function getId()
    {
        return $this->id;
    }
    public function setId($tr)
    {
        $this->id = $tr;
    }
    public function getIssueInstant()
    {
        return $this->issueInstant;
    }
    public function setIssueInstant($Yx)
    {
        $this->issueInstant = $Yx;
    }
    public function getDestination()
    {
        return $this->destination;
    }
    public function setDestination($yV)
    {
        $this->destination = $yV;
    }
    public function getIssuer()
    {
        return $this->issuer;
    }
    public function setIssuer($DR)
    {
        $this->issuer = $DR;
    }
}
