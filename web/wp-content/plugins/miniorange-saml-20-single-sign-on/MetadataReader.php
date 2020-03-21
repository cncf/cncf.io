<?php


include_once "\x55\x74\x69\x6c\x69\164\151\x65\x73\x2e\160\150\x70";
class IDPMetadataReader
{
    private $identityProviders;
    private $serviceProviders;
    public function __construct(DOMNode $pX = NULL)
    {
        $this->identityProviders = array();
        $this->serviceProviders = array();
        $l6 = SAMLSPUtilities::xpQuery($pX, "\56\x2f\163\x61\155\154\x5f\155\145\164\x61\x64\141\164\x61\72\105\156\x74\x69\164\171\104\x65\163\x63\x72\151\x70\x74\x6f\162");
        foreach ($l6 as $RB) {
            $Av = SAMLSPUtilities::xpQuery($RB, "\x2e\x2f\x73\141\x6d\154\x5f\155\145\x74\141\144\x61\164\141\72\x49\x44\120\x53\123\117\x44\145\163\143\x72\151\160\164\157\x72");
            if (!(isset($Av) && !empty($Av))) {
                goto h4;
            }
            array_push($this->identityProviders, new IdentityProviders($RB));
            h4:
            xd:
        }
        ae:
    }
    public function getIdentityProviders()
    {
        return $this->identityProviders;
    }
    public function getServiceProviders()
    {
        return $this->serviceProviders;
    }
}
class IdentityProviders
{
    private $idpName;
    private $entityID;
    private $loginDetails;
    private $logoutDetails;
    private $signingCertificate;
    private $encryptionCertificate;
    private $signedRequest;
    public function __construct(DOMElement $pX = NULL)
    {
        $this->idpName = '';
        $this->nameIDFormat = '';
        $this->loginDetails = array();
        $this->logoutDetails = array();
        $this->signingCertificate = array();
        $this->encryptionCertificate = array();
        if (!$pX->hasAttribute("\145\156\x74\x69\164\171\111\104")) {
            goto ot;
        }
        $this->entityID = $pX->getAttribute("\x65\x6e\x74\151\x74\x79\x49\x44");
        ot:
        if (!$pX->hasAttribute("\x57\x61\x6e\x74\x41\x75\x74\150\x6e\x52\x65\161\x75\145\x73\164\x73\123\x69\147\156\145\144")) {
            goto xP;
        }
        $this->signedRequest = $pX->getAttribute("\127\141\x6e\x74\101\165\164\x68\156\122\x65\x71\x75\x65\x73\x74\163\123\x69\147\x6e\145\144");
        xP:
        $Av = SAMLSPUtilities::xpQuery($pX, "\56\57\x73\141\x6d\154\x5f\x6d\145\164\x61\144\x61\x74\x61\x3a\x49\104\120\123\123\x4f\104\x65\x73\x63\x72\151\x70\x74\x6f\162");
        if (count($Av) > 1) {
            goto MT;
        }
        if (empty($Av)) {
            goto At;
        }
        goto Jk;
        MT:
        throw new Exception("\115\x6f\162\145\40\164\x68\141\x6e\x20\x6f\156\145\40\74\111\104\120\123\123\117\x44\145\x73\x63\162\151\x70\x74\x6f\x72\76\40\151\x6e\x20\x3c\105\x6e\x74\151\164\171\104\145\163\143\162\x69\160\164\x6f\162\x3e\56");
        goto Jk;
        At:
        throw new Exception("\x4d\151\163\163\x69\x6e\147\x20\162\x65\161\165\151\162\145\x64\x20\74\x49\x44\x50\123\x53\117\x44\145\163\143\x72\x69\160\164\157\x72\x3e\x20\x69\156\40\x3c\x45\x6e\x74\x69\x74\x79\104\145\x73\x63\x72\151\160\164\157\x72\x3e\56");
        Jk:
        $Uc = $Av[0];
        $pP = SAMLSPUtilities::xpQuery($pX, "\x2e\x2f\163\x61\155\154\137\155\x65\164\x61\144\141\x74\141\72\x45\170\x74\145\156\163\151\x6f\156\x73");
        if (!$pP) {
            goto Ee;
        }
        $this->parseInfo($Uc);
        Ee:
        $this->parseSSOService($Uc);
        $this->parseSLOService($Uc);
        $this->parsex509Certificate($Uc);
    }
    private function parseInfo($pX)
    {
        $F2 = SAMLSPUtilities::xpQuery($pX, "\56\57\x6d\x64\x75\x69\72\x55\111\x49\x6e\146\x6f\x2f\155\144\165\x69\72\x44\x69\x73\x70\x6c\141\171\116\x61\155\145");
        foreach ($F2 as $AF) {
            if (!($AF->hasAttribute("\170\155\x6c\72\x6c\141\156\147") && $AF->getAttribute("\170\x6d\x6c\x3a\x6c\x61\x6e\147") == "\145\156")) {
                goto xY;
            }
            $this->idpName = $AF->textContent;
            xY:
            vr:
        }
        pI:
    }
    private function parseSSOService($pX)
    {
        $xN = SAMLSPUtilities::xpQuery($pX, "\x2e\57\x73\141\x6d\154\x5f\x6d\x65\164\x61\144\141\x74\x61\72\123\151\156\147\x6c\145\123\x69\x67\x6e\117\156\x53\x65\x72\x76\x69\143\145");
        foreach ($xN as $cp) {
            $L8 = str_replace("\x75\162\x6e\72\x6f\x61\163\x69\163\x3a\156\x61\x6d\145\x73\x3a\164\x63\72\x53\x41\115\x4c\x3a\62\56\60\72\x62\x69\156\144\151\156\147\x73\72", '', $cp->getAttribute("\x42\x69\x6e\144\151\156\x67"));
            $this->loginDetails = array_merge($this->loginDetails, array($L8 => $cp->getAttribute("\114\x6f\x63\141\x74\151\x6f\156")));
            m3:
        }
        X2:
    }
    private function parseSLOService($pX)
    {
        $oG = SAMLSPUtilities::xpQuery($pX, "\56\57\x73\141\155\154\137\155\x65\164\141\x64\141\164\141\72\x53\x69\156\147\154\145\114\x6f\x67\157\165\x74\123\x65\x72\166\151\x63\145");
        if (!empty($oG)) {
            goto cZ;
        }
        $this->logoutDetails = array("\110\x54\124\120\55\x52\145\x64\151\x72\145\143\164" => '');
        goto Ov;
        cZ:
        foreach ($oG as $OW) {
            $L8 = str_replace("\165\162\x6e\x3a\x6f\141\163\x69\163\x3a\156\x61\155\x65\x73\x3a\x74\143\72\123\x41\115\x4c\x3a\x32\x2e\x30\x3a\142\x69\x6e\x64\x69\x6e\147\163\x3a", '', $OW->getAttribute("\102\151\x6e\144\151\156\x67"));
            $this->logoutDetails = array_merge($this->logoutDetails, array($L8 => $OW->getAttribute("\x4c\157\x63\141\164\x69\x6f\x6e")));
            sd:
        }
        n9:
        Ov:
    }
    private function parsex509Certificate($pX)
    {
        foreach (SAMLSPUtilities::xpQuery($pX, "\56\57\163\141\155\154\137\155\x65\x74\x61\x64\141\164\141\72\113\x65\x79\x44\x65\x73\143\162\x69\160\164\x6f\162") as $S6) {
            if ($S6->hasAttribute("\x75\x73\x65")) {
                goto yY;
            }
            $this->parseSigningCertificate($S6);
            goto cR;
            yY:
            if ($S6->getAttribute("\x75\x73\145") == "\145\156\143\162\171\x70\x74\x69\157\x6e") {
                goto bs;
            }
            $this->parseSigningCertificate($S6);
            goto l9;
            bs:
            $this->parseEncryptionCertificate($S6);
            l9:
            cR:
            xh:
        }
        eg:
    }
    private function parseSigningCertificate($pX)
    {
        $Un = SAMLSPUtilities::xpQuery($pX, "\x2e\57\x64\163\x3a\x4b\145\171\111\x6e\146\x6f\57\x64\163\x3a\130\x35\x30\x39\x44\x61\x74\x61\57\144\x73\x3a\130\x35\x30\71\103\x65\x72\164\151\x66\151\143\141\164\x65");
        $Ej = trim($Un[0]->textContent);
        $Ej = str_replace(array("\xd", "\xa", "\11", "\40"), '', $Ej);
        if (empty($Un)) {
            goto X6;
        }
        array_push($this->signingCertificate, SAMLSPUtilities::sanitize_certificate($Ej));
        X6:
    }
    private function parseEncryptionCertificate($pX)
    {
        $Un = SAMLSPUtilities::xpQuery($pX, "\56\57\144\x73\x3a\113\x65\x79\x49\x6e\146\157\x2f\144\163\72\x58\x35\x30\71\104\141\x74\x61\x2f\x64\163\72\130\65\60\x39\x43\145\162\164\x69\x66\x69\x63\141\164\x65");
        $Ej = trim($Un[0]->textContent);
        $Ej = str_replace(array("\15", "\xa", "\x9", "\x20"), '', $Ej);
        if (empty($Un)) {
            goto zR;
        }
        array_push($this->encryptionCertificate, $Ej);
        zR:
    }
    public function getIdpName()
    {
        return $this->idpName;
    }
    public function getEntityID()
    {
        return $this->entityID;
    }
    public function getLoginURL($L8)
    {
        return $this->loginDetails[$L8];
    }
    public function getLogoutURL($L8)
    {
        return $this->logoutDetails[$L8];
    }
    public function getLoginDetails()
    {
        return $this->loginDetails;
    }
    public function getLogoutDetails()
    {
        return $this->logoutDetails;
    }
    public function getSigningCertificate()
    {
        return $this->signingCertificate;
    }
    public function getEncryptionCertificate()
    {
        return $this->encryptionCertificate[0];
    }
    public function isRequestSigned()
    {
        return $this->signedRequest;
    }
}
