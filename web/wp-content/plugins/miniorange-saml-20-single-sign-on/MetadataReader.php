<?php


include_once "\x55\x74\x69\154\x69\x74\151\x65\x73\56\x70\150\160";
class IDPMetadataReader
{
    private $identityProviders;
    private $serviceProviders;
    public function __construct(DOMNode $Cr = NULL)
    {
        $this->identityProviders = array();
        $this->serviceProviders = array();
        $yn = SAMLSPUtilities::xpQuery($Cr, "\x2e\57\x73\x61\x6d\154\137\155\x65\164\x61\x64\141\164\x61\x3a\x45\156\164\151\x74\171\104\x65\163\143\x72\151\x70\164\157\162");
        foreach ($yn as $Pe) {
            $O4 = SAMLSPUtilities::xpQuery($Pe, "\56\57\x73\x61\155\x6c\137\155\145\164\x61\144\x61\164\141\72\111\x44\120\123\123\117\104\x65\163\x63\162\x69\160\164\x6f\x72");
            if (!(isset($O4) && !empty($O4))) {
                goto fl;
            }
            array_push($this->identityProviders, new IdentityProviders($Pe));
            fl:
            OP:
        }
        bN:
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
    public function __construct(DOMElement $Cr = NULL)
    {
        $this->idpName = '';
        $this->nameIDFormat = '';
        $this->loginDetails = array();
        $this->logoutDetails = array();
        $this->signingCertificate = array();
        $this->encryptionCertificate = array();
        if (!$Cr->hasAttribute("\x65\156\x74\x69\164\x79\111\x44")) {
            goto wE;
        }
        $this->entityID = $Cr->getAttribute("\x65\x6e\x74\x69\164\x79\x49\104");
        wE:
        if (!$Cr->hasAttribute("\127\x61\x6e\164\x41\165\x74\x68\156\x52\x65\x71\165\x65\163\x74\163\x53\151\x67\156\145\144")) {
            goto gi;
        }
        $this->signedRequest = $Cr->getAttribute("\x57\x61\156\164\101\x75\164\x68\156\122\145\161\x75\145\x73\164\x73\x53\x69\x67\156\x65\x64");
        gi:
        $O4 = SAMLSPUtilities::xpQuery($Cr, "\56\x2f\163\141\x6d\154\x5f\155\x65\x74\x61\144\141\164\x61\x3a\x49\x44\x50\x53\123\x4f\104\x65\163\143\162\x69\x70\x74\157\x72");
        if (count($O4) > 1) {
            goto LG;
        }
        if (empty($O4)) {
            goto uA;
        }
        goto xJ;
        LG:
        throw new Exception("\115\157\162\145\40\x74\150\141\x6e\x20\157\156\x65\x20\74\x49\x44\x50\x53\x53\117\x44\145\163\143\162\x69\160\x74\x6f\x72\x3e\x20\x69\156\x20\x3c\105\x6e\164\151\164\171\104\x65\x73\x63\162\x69\x70\164\157\162\76\x2e");
        goto xJ;
        uA:
        throw new Exception("\x4d\151\x73\163\x69\156\x67\x20\x72\145\x71\x75\x69\162\145\144\x20\74\x49\x44\x50\123\x53\117\x44\145\x73\143\x72\x69\160\164\x6f\162\76\x20\151\x6e\x20\74\x45\156\164\x69\164\171\104\145\x73\143\162\151\x70\x74\157\162\x3e\x2e");
        xJ:
        $NE = $O4[0];
        $vb = SAMLSPUtilities::xpQuery($Cr, "\56\57\x73\141\155\x6c\x5f\155\145\164\141\x64\141\164\141\72\105\x78\164\145\156\x73\151\x6f\x6e\x73");
        if (!$vb) {
            goto S0;
        }
        $this->parseInfo($NE);
        S0:
        $this->parseSSOService($NE);
        $this->parseSLOService($NE);
        $this->parsex509Certificate($NE);
    }
    private function parseInfo($Cr)
    {
        $sH = SAMLSPUtilities::xpQuery($Cr, "\56\x2f\x6d\144\x75\x69\72\x55\111\x49\156\146\157\x2f\x6d\x64\x75\x69\x3a\x44\x69\x73\160\x6c\141\171\x4e\x61\155\145");
        foreach ($sH as $XE) {
            if (!($XE->hasAttribute("\x78\155\x6c\72\154\141\156\147") && $XE->getAttribute("\170\x6d\154\72\154\x61\x6e\147") == "\145\x6e")) {
                goto fH;
            }
            $this->idpName = $XE->textContent;
            fH:
            JA:
        }
        Sk:
    }
    private function parseSSOService($Cr)
    {
        $E9 = SAMLSPUtilities::xpQuery($Cr, "\x2e\x2f\x73\141\155\x6c\137\x6d\145\x74\141\x64\x61\x74\x61\72\x53\x69\x6e\x67\x6c\x65\x53\151\147\156\x4f\x6e\123\x65\x72\x76\151\x63\145");
        foreach ($E9 as $en) {
            $hQ = str_replace("\165\162\156\x3a\x6f\141\x73\151\163\72\156\141\x6d\145\163\x3a\x74\143\x3a\x53\x41\115\x4c\72\x32\56\60\x3a\x62\x69\156\144\151\x6e\x67\163\72", '', $en->getAttribute("\x42\x69\x6e\x64\x69\x6e\147"));
            $this->loginDetails = array_merge($this->loginDetails, array($hQ => $en->getAttribute("\114\x6f\x63\141\x74\151\157\x6e")));
            dn:
        }
        qb:
    }
    private function parseSLOService($Cr)
    {
        $LS = SAMLSPUtilities::xpQuery($Cr, "\56\57\163\141\x6d\x6c\137\155\x65\x74\x61\x64\x61\164\141\x3a\x53\151\156\147\154\145\114\157\x67\x6f\165\164\x53\x65\162\x76\151\143\145");
        if (!empty($LS)) {
            goto ie;
        }
        $this->logoutDetails = array("\110\x54\124\x50\x2d\122\x65\144\151\x72\145\x63\164" => '');
        goto Fw;
        ie:
        foreach ($LS as $RZ) {
            $hQ = str_replace("\165\x72\156\72\157\x61\163\x69\x73\72\156\x61\155\145\163\72\x74\x63\x3a\123\101\115\x4c\72\x32\56\60\72\x62\151\156\144\x69\x6e\147\x73\x3a", '', $RZ->getAttribute("\102\x69\156\144\151\156\x67"));
            $this->logoutDetails = array_merge($this->logoutDetails, array($hQ => $RZ->getAttribute("\x4c\157\x63\141\164\x69\157\x6e")));
            qr:
        }
        T8:
        Fw:
    }
    private function parsex509Certificate($Cr)
    {
        foreach (SAMLSPUtilities::xpQuery($Cr, "\x2e\57\x73\141\155\x6c\x5f\155\145\164\x61\x64\141\164\x61\x3a\113\x65\171\x44\x65\x73\143\x72\x69\x70\164\157\162") as $ZP) {
            if ($ZP->hasAttribute("\165\x73\145")) {
                goto zb;
            }
            $this->parseSigningCertificate($ZP);
            goto vS;
            zb:
            if ($ZP->getAttribute("\x75\163\x65") == "\145\x6e\143\x72\x79\x70\x74\x69\157\156") {
                goto Ln;
            }
            $this->parseSigningCertificate($ZP);
            goto Wg;
            Ln:
            $this->parseEncryptionCertificate($ZP);
            Wg:
            vS:
            zA:
        }
        tW:
    }
    private function parseSigningCertificate($Cr)
    {
        $Dh = SAMLSPUtilities::xpQuery($Cr, "\x2e\x2f\144\x73\72\113\x65\171\111\156\x66\157\x2f\144\163\x3a\130\x35\x30\x39\104\141\x74\x61\57\144\x73\x3a\130\x35\x30\x39\x43\x65\x72\164\151\146\151\x63\x61\x74\145");
        $ia = trim($Dh[0]->textContent);
        $ia = str_replace(array("\15", "\xa", "\11", "\x20"), '', $ia);
        if (empty($Dh)) {
            goto AA;
        }
        array_push($this->signingCertificate, SAMLSPUtilities::sanitize_certificate($ia));
        AA:
    }
    private function parseEncryptionCertificate($Cr)
    {
        $Dh = SAMLSPUtilities::xpQuery($Cr, "\56\57\144\163\x3a\x4b\145\171\x49\156\x66\157\x2f\144\x73\72\x58\65\x30\71\104\x61\164\141\57\x64\x73\x3a\x58\x35\60\71\x43\x65\x72\x74\x69\146\151\143\141\164\x65");
        $ia = trim($Dh[0]->textContent);
        $ia = str_replace(array("\15", "\12", "\11", "\40"), '', $ia);
        if (empty($Dh)) {
            goto VM;
        }
        array_push($this->encryptionCertificate, $ia);
        VM:
    }
    public function getIdpName()
    {
        return $this->idpName;
    }
    public function getEntityID()
    {
        return $this->entityID;
    }
    public function getLoginURL($hQ)
    {
        return $this->loginDetails[$hQ];
    }
    public function getLogoutURL($hQ)
    {
        return $this->logoutDetails[$hQ];
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
