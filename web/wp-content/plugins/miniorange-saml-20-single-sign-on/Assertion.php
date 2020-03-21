<?php


include_once "\125\x74\x69\x6c\151\x74\151\x65\163\x2e\160\x68\x70";
include_once "\170\x6d\x6c\x73\x65\x63\x6c\x69\x62\163\56\x70\150\x70";
use RobRichards\XMLSecLibs\XMLSecurityKey;
use RobRichards\XMLSecLibs\XMLSecurityDSig;
use RobRichards\XMLSecLibs\XMLSecEnc;
class SAML2SPAssertion
{
    private $id;
    private $issueInstant;
    private $issuer;
    private $nameId;
    private $encryptedNameId;
    private $encryptedAttribute;
    private $encryptionKey;
    private $notBefore;
    private $notOnOrAfter;
    private $validAudiences;
    private $sessionNotOnOrAfter;
    private $sessionIndex;
    private $authnInstant;
    private $authnContextClassRef;
    private $authnContextDecl;
    private $authnContextDeclRef;
    private $AuthenticatingAuthority;
    private $attributes;
    private $nameFormat;
    private $signatureKey;
    private $certificates;
    private $signatureData;
    private $requiredEncAttributes;
    private $SubjectConfirmation;
    protected $wasSignedAtConstruction = FALSE;
    public function __construct(DOMElement $pX = NULL)
    {
        $this->id = SAMLSPUtilities::generateId();
        $this->issueInstant = SAMLSPUtilities::generateTimestamp();
        $this->issuer = '';
        $this->authnInstant = SAMLSPUtilities::generateTimestamp();
        $this->attributes = array();
        $this->nameFormat = "\165\162\156\x3a\157\x61\x73\x69\x73\x3a\x6e\x61\x6d\x65\x73\72\x74\143\72\x53\101\115\114\x3a\61\56\x31\72\156\x61\x6d\x65\x69\x64\55\146\157\x72\x6d\x61\164\72\165\156\x73\x70\145\143\x69\x66\151\x65\x64";
        $this->certificates = array();
        $this->AuthenticatingAuthority = array();
        $this->SubjectConfirmation = array();
        if (!($pX === NULL)) {
            goto oi;
        }
        return;
        oi:
        if (!($pX->localName === "\x45\x6e\x63\x72\171\x70\x74\x65\x64\101\x73\x73\x65\162\x74\151\x6f\x6e")) {
            goto wq;
        }
        $rL = SAMLSPUtilities::xpQuery($pX, "\56\x2f\x78\145\156\143\72\x45\x6e\x63\162\x79\160\164\145\x64\x44\x61\x74\141");
        $xr = SAMLSPUtilities::xpQuery($pX, "\x2f\x2f\x2a\x5b\154\x6f\143\x61\154\x2d\156\x61\x6d\x65\50\x29\75\47\x45\156\x63\162\x79\x70\164\145\x64\113\x65\x79\47\135\57\52\x5b\x6c\x6f\x63\x61\x6c\x2d\x6e\x61\155\145\50\51\75\47\105\156\x63\x72\x79\x70\164\x69\x6f\156\115\x65\164\150\157\x64\x27\x5d\x2f\x40\x41\154\x67\x6f\x72\x69\x74\x68\x6d");
        $R2 = $xr[0]->value;
        $S8 = SAMLSPUtilities::getEncryptionAlgorithm($R2);
        if (count($rL) === 0) {
            goto iJ;
        }
        if (count($rL) > 1) {
            goto i9;
        }
        goto AF;
        iJ:
        throw new Exception("\115\x69\163\163\x69\156\147\x20\145\x6e\143\162\171\x70\164\x65\x64\x20\144\141\164\141\40\x69\x6e\x20\74\163\141\155\154\x3a\105\x6e\x63\x72\171\160\164\x65\x64\x41\163\x73\145\162\164\151\157\156\x3e\56");
        goto AF;
        i9:
        throw new Exception("\115\x6f\x72\145\40\164\x68\x61\x6e\40\x6f\x6e\145\40\x65\x6e\x63\162\171\160\164\145\144\40\x64\x61\164\x61\x20\x65\x6c\x65\155\x65\x6e\x74\40\151\156\40\x3c\x73\141\155\154\x3a\105\x6e\x63\162\x79\160\164\x65\x64\101\x73\163\x65\162\164\151\157\156\x3e\x2e");
        AF:
        $ld = new XMLSecurityKey($S8, array("\164\171\160\x65" => "\x70\x72\151\x76\x61\x74\145"));
        $px = plugin_dir_path(__FILE__) . "\x72\145\x73\x6f\x75\162\143\x65\163" . DIRECTORY_SEPARATOR . "\163\x70\55\153\145\x79\x2e\153\x65\x79";
        $ld->loadKey($px, TRUE);
        $FL = new XMLSecurityKey($S8, array("\x74\x79\160\x65" => "\160\x72\x69\x76\x61\164\x65"));
        $WU = plugin_dir_path(__FILE__) . "\162\x65\163\x6f\165\162\x63\x65\163" . DIRECTORY_SEPARATOR . "\155\x69\x6e\151\157\x72\x61\156\147\x65\137\x73\160\137\x70\x72\x69\166\137\153\x65\171\56\153\x65\x79";
        $FL->loadKey($WU, TRUE);
        $hu = array();
        $pX = SAMLSPUtilities::decryptElement($rL[0], $ld, $hu, $FL);
        wq:
        if ($pX->hasAttribute("\x49\x44")) {
            goto W5;
        }
        throw new Exception("\115\x69\163\x73\151\x6e\147\40\111\104\40\141\164\x74\x72\x69\x62\x75\164\145\x20\x6f\156\x20\x53\101\x4d\x4c\40\141\163\163\x65\162\164\x69\x6f\x6e\x2e");
        W5:
        $this->id = $pX->getAttribute("\111\104");
        if (!($pX->getAttribute("\x56\x65\x72\x73\x69\157\x6e") !== "\62\x2e\x30")) {
            goto Ze;
        }
        throw new Exception("\125\156\x73\165\x70\x70\x6f\x72\x74\x65\144\x20\x76\145\x72\163\151\x6f\156\72\x20" . $pX->getAttribute("\126\x65\x72\x73\151\x6f\156"));
        Ze:
        $this->issueInstant = SAMLSPUtilities::xsDateTimeToTimestamp($pX->getAttribute("\111\163\163\165\x65\x49\x6e\163\164\x61\156\x74"));
        $DR = SAMLSPUtilities::xpQuery($pX, "\56\57\x73\x61\155\154\137\141\163\x73\x65\x72\x74\x69\157\156\x3a\x49\163\163\x75\145\162");
        if (!empty($DR)) {
            goto Cc;
        }
        throw new Exception("\115\x69\163\x73\x69\156\147\x20\x3c\163\x61\x6d\x6c\72\111\163\163\x75\x65\x72\x3e\x20\x69\156\40\141\163\163\145\x72\x74\151\x6f\x6e\x2e");
        Cc:
        $this->issuer = trim($DR[0]->textContent);
        $this->parseConditions($pX);
        $this->parseAuthnStatement($pX);
        $this->parseAttributes($pX);
        $this->parseEncryptedAttributes($pX);
        $this->parseSignature($pX);
        $this->parseSubject($pX);
    }
    private function parseSubject(DOMElement $pX)
    {
        $gq = SAMLSPUtilities::xpQuery($pX, "\56\57\163\141\155\154\137\141\163\x73\x65\x72\164\x69\x6f\156\x3a\123\x75\x62\152\145\x63\164");
        if (empty($gq)) {
            goto sN;
        }
        if (count($gq) > 1) {
            goto kN;
        }
        goto Hs;
        sN:
        return;
        goto Hs;
        kN:
        throw new Exception("\115\157\x72\145\40\x74\x68\141\156\x20\157\156\x65\40\x3c\163\141\x6d\154\72\123\165\x62\x6a\x65\143\164\76\40\x69\x6e\x20\x3c\x73\x61\x6d\154\x3a\101\163\163\x65\162\164\x69\157\x6e\x3e\x2e");
        Hs:
        $gq = $gq[0];
        $RQ = SAMLSPUtilities::xpQuery($gq, "\56\57\x73\141\x6d\x6c\137\141\x73\x73\x65\162\x74\151\157\156\72\116\141\x6d\145\x49\x44\40\x7c\40\x2e\x2f\163\x61\155\154\137\141\163\x73\x65\162\x74\x69\157\156\72\105\x6e\x63\162\171\160\164\x65\144\x49\x44\57\x78\x65\x6e\143\72\x45\x6e\143\162\171\x70\x74\x65\x64\104\x61\164\x61");
        if (empty($RQ)) {
            goto gL;
        }
        if (count($RQ) > 1) {
            goto kI;
        }
        goto Nl;
        gL:
        if ($_POST["\x52\x65\x6c\x61\x79\123\164\x61\164\145"] == "\164\x65\163\x74\126\x61\x6c\151\x64\x61\x74\145") {
            goto Lv;
        }
        wp_die("\x57\145\40\x63\157\x75\x6c\x64\40\156\x6f\x74\40\x73\x69\x67\156\x20\171\x6f\x75\40\151\x6e\56\x20\120\x6c\145\141\x73\145\x20\x63\x6f\156\164\141\x63\164\x20\171\x6f\x75\162\x20\x61\x64\x6d\151\x6e\151\163\x74\162\141\x74\x6f\162");
        goto yS;
        Lv:
        echo "\x3c\x64\x69\x76\40\163\x74\x79\x6c\x65\75\42\146\157\x6e\164\x2d\x66\x61\x6d\x69\x6c\171\72\x43\x61\154\151\x62\162\151\x3b\x70\141\x64\x64\151\x6e\147\x3a\x30\x20\x33\45\x3b\42\76";
        echo "\x3c\144\151\x76\40\163\x74\171\154\x65\x3d\x22\143\x6f\x6c\157\x72\x3a\40\43\x61\x39\x34\64\64\x32\73\142\x61\143\153\x67\162\157\165\x6e\x64\55\143\x6f\154\x6f\x72\72\40\x23\x66\x32\x64\145\144\145\x3b\x70\141\x64\x64\x69\156\x67\72\40\x31\65\160\170\73\155\x61\x72\147\x69\x6e\55\x62\157\164\x74\x6f\x6d\72\40\x32\x30\160\170\x3b\x74\x65\x78\x74\x2d\141\x6c\x69\147\156\x3a\143\x65\156\x74\145\x72\73\142\x6f\x72\144\145\162\x3a\x31\x70\170\x20\x73\157\x6c\151\144\40\43\105\66\x42\63\102\x32\x3b\x66\x6f\x6e\x74\55\163\x69\172\145\72\x31\x38\160\164\73\x22\x3e\x20\x45\122\122\x4f\x52\x3c\57\144\151\x76\x3e\xa\x20\x20\40\40\x20\40\x20\x20\x20\x20\x20\x3c\x64\x69\166\40\163\x74\171\x6c\145\x3d\x22\143\157\154\x6f\x72\72\x20\43\x61\71\64\64\64\62\x3b\146\x6f\156\x74\x2d\x73\151\172\145\72\61\64\160\x74\x3b\40\x6d\x61\162\147\151\x6e\55\142\x6f\164\x74\x6f\155\72\62\x30\x70\170\x3b\x22\76\x3c\x70\76\x3c\x73\x74\162\157\x6e\x67\x3e\105\162\x72\157\162\72\x20\74\x2f\x73\164\x72\x6f\x6e\147\76\x4d\x69\163\x73\151\x6e\x67\40\40\116\x61\x6d\x65\111\x44\x20\151\x6e\x20\123\101\x4d\114\40\x52\x65\163\160\x6f\x6e\163\145\56\74\x2f\160\x3e\12\40\x20\x20\40\40\x20\x20\40\x20\x20\x20\40\x20\40\x20\x20\x3c\160\76\120\x6c\145\141\x73\145\40\143\157\x6e\164\x61\143\x74\40\x79\157\165\162\x20\x61\x64\155\151\x6e\x69\x73\164\162\x61\x74\157\x72\x20\x61\x6e\x64\x20\162\145\160\157\x72\164\40\x74\150\145\40\x66\157\154\x6c\x6f\167\151\156\147\40\145\162\162\x6f\162\x3a\74\57\x70\x3e\12\40\40\40\40\40\x20\x20\40\40\x20\40\40\40\40\x20\40\x3c\160\76\74\163\164\162\x6f\156\x67\x3e\x50\x6f\x73\x73\151\x62\154\x65\x20\x43\x61\165\163\x65\72\x3c\57\x73\x74\x72\x6f\156\x67\x3e\40\116\141\155\145\111\104\x20\156\157\164\40\x66\157\x75\156\144\40\x69\156\40\123\x41\115\114\x20\122\x65\x73\160\157\156\163\145\x20\x73\165\x62\x6a\x65\x63\164\56\x3c\57\x70\76\12\x20\40\x20\40\40\x20\40\40\x20\40\40\40\40\40\x20\x20\x3c\x2f\x64\x69\x76\x3e\12\x20\40\x20\40\x20\40\x20\40\x20\x20\x20\x20\40\40\40\x20\x3c\x64\151\166\40\163\164\x79\x6c\x65\x3d\42\x6d\x61\162\x67\151\156\x3a\63\x25\x3b\144\x69\163\x70\x6c\x61\x79\72\x62\154\157\x63\153\x3b\x74\x65\x78\164\x2d\141\154\151\x67\x6e\72\x63\145\x6e\x74\145\162\x3b\x22\76\12\40\40\40\x20\40\x20\x20\40\x20\40\x20\x20\x20\40\x20\xa\40\x20\x20\40\x20\x20\40\40\x20\x20\x20\x20\x20\40\40\x20\x3c\144\151\x76\x20\x73\164\x79\154\x65\75\42\155\x61\162\x67\x69\156\x3a\63\x25\x3b\144\151\x73\x70\x6c\141\171\x3a\x62\154\x6f\x63\x6b\x3b\x74\145\170\164\55\141\x6c\151\147\156\x3a\x63\145\x6e\164\x65\162\73\x22\76\x3c\x69\156\160\165\x74\40\163\x74\171\x6c\x65\75\x22\160\141\x64\144\x69\156\147\72\61\x25\73\167\151\x64\x74\150\72\x31\x30\60\x70\x78\x3b\142\x61\x63\153\x67\162\x6f\165\156\x64\x3a\40\x23\x30\x30\71\61\x43\104\40\156\157\156\x65\x20\162\x65\160\x65\141\x74\x20\163\x63\162\157\154\154\40\x30\x25\x20\60\45\73\x63\165\x72\x73\157\x72\x3a\x20\x70\157\x69\x6e\x74\145\162\x3b\x66\x6f\156\x74\55\x73\x69\x7a\145\72\61\x35\x70\x78\73\142\157\162\144\x65\x72\x2d\x77\x69\x64\x74\150\x3a\x20\x31\160\x78\x3b\142\x6f\162\144\145\162\55\163\164\x79\x6c\145\x3a\x20\163\x6f\154\151\x64\73\142\x6f\x72\x64\x65\x72\x2d\x72\141\144\x69\x75\163\x3a\x20\x33\160\x78\x3b\167\x68\x69\164\x65\55\163\x70\x61\143\x65\72\x20\x6e\157\x77\x72\141\160\x3b\x62\x6f\x78\55\x73\151\x7a\151\156\x67\72\40\142\x6f\x72\144\x65\x72\x2d\x62\x6f\x78\x3b\142\157\162\144\x65\x72\x2d\143\157\154\x6f\x72\72\x20\43\x30\60\67\63\x41\x41\x3b\x62\157\170\x2d\x73\x68\x61\144\157\x77\72\x20\x30\x70\170\40\x31\x70\x78\x20\x30\x70\x78\40\x72\147\142\x61\x28\61\x32\60\54\x20\x32\60\x30\54\40\x32\x33\x30\54\40\60\x2e\x36\x29\x20\151\x6e\163\145\164\x3b\143\x6f\154\x6f\162\x3a\40\43\x46\x46\106\73\x22\164\171\x70\145\75\42\142\165\x74\x74\157\156\42\x20\166\x61\154\165\x65\x3d\42\104\157\156\145\x22\x20\157\156\103\154\x69\143\x6b\75\42\x73\145\x6c\x66\x2e\143\x6c\x6f\x73\145\x28\51\73\42\76\74\57\144\x69\x76\x3e";
        die;
        yS:
        goto Nl;
        kI:
        throw new Exception("\115\x6f\162\x65\40\164\x68\141\156\x20\157\x6e\x65\x20\x3c\163\x61\x6d\x6c\72\x4e\141\x6d\145\111\x44\x3e\x20\157\162\x20\74\163\x61\155\x6c\72\x45\x6e\143\x72\171\160\x74\145\x64\104\76\40\151\156\40\x3c\x73\141\x6d\x6c\72\x53\165\x62\x6a\x65\143\164\x3e\x2e");
        Nl:
        $RQ = $RQ[0];
        if ($RQ->localName === "\x45\x6e\143\162\x79\160\164\x65\144\x44\141\164\141") {
            goto d1;
        }
        $this->nameId = SAMLSPUtilities::parseNameId($RQ);
        goto XU;
        d1:
        $this->encryptedNameId = $RQ;
        XU:
    }
    private function parseConditions(DOMElement $pX)
    {
        $vk = SAMLSPUtilities::xpQuery($pX, "\x2e\x2f\163\x61\x6d\154\137\141\163\163\x65\x72\x74\151\157\156\72\x43\x6f\156\144\151\x74\151\157\x6e\x73");
        if (empty($vk)) {
            goto fT;
        }
        if (count($vk) > 1) {
            goto Ox;
        }
        goto d9;
        fT:
        return;
        goto d9;
        Ox:
        throw new Exception("\115\157\162\x65\x20\x74\x68\141\x6e\x20\157\x6e\145\40\x3c\163\141\155\x6c\x3a\x43\157\x6e\144\x69\164\151\x6f\x6e\x73\x3e\40\x69\x6e\40\74\x73\141\x6d\x6c\72\101\x73\x73\145\162\164\x69\157\x6e\76\56");
        d9:
        $vk = $vk[0];
        if (!$vk->hasAttribute("\x4e\157\x74\x42\145\146\x6f\x72\145")) {
            goto PP;
        }
        $UL = SAMLSPUtilities::xsDateTimeToTimestamp($vk->getAttribute("\116\157\x74\x42\x65\x66\157\162\x65"));
        if (!($this->notBefore === NULL || $this->notBefore < $UL)) {
            goto K6;
        }
        $this->notBefore = $UL;
        K6:
        PP:
        if (!$vk->hasAttribute("\116\157\x74\117\x6e\117\162\101\x66\164\145\162")) {
            goto k6;
        }
        $LP = SAMLSPUtilities::xsDateTimeToTimestamp($vk->getAttribute("\x4e\x6f\x74\117\156\117\x72\x41\146\x74\x65\x72"));
        if (!($this->notOnOrAfter === NULL || $this->notOnOrAfter > $LP)) {
            goto AV;
        }
        $this->notOnOrAfter = $LP;
        AV:
        k6:
        $rf = $vk->firstChild;
        wt:
        if (!($rf !== NULL)) {
            goto Gx;
        }
        if (!$rf instanceof DOMText) {
            goto fY;
        }
        goto Ba;
        fY:
        if (!($rf->namespaceURI !== "\x75\x72\x6e\72\157\141\163\x69\163\x3a\156\x61\x6d\145\163\72\x74\x63\x3a\x53\x41\x4d\114\72\x32\56\60\x3a\141\163\x73\x65\162\164\151\x6f\156")) {
            goto hF;
        }
        throw new Exception("\125\x6e\153\x6e\x6f\167\156\x20\156\x61\x6d\145\163\160\141\x63\x65\x20\157\146\x20\143\x6f\x6e\x64\151\164\151\157\156\x3a\x20" . var_export($rf->namespaceURI, TRUE));
        hF:
        switch ($rf->localName) {
            case "\101\x75\x64\x69\145\156\x63\x65\x52\x65\x73\164\x72\151\x63\x74\151\157\x6e":
                $Vc = SAMLSPUtilities::extractStrings($rf, "\x75\x72\156\x3a\x6f\141\x73\151\x73\x3a\156\x61\155\145\163\72\x74\x63\72\123\x41\x4d\x4c\x3a\x32\56\x30\72\x61\x73\163\x65\x72\x74\151\x6f\x6e", "\x41\165\144\x69\145\x6e\143\145");
                if ($this->validAudiences === NULL) {
                    goto ls;
                }
                $this->validAudiences = array_intersect($this->validAudiences, $Vc);
                goto zb;
                ls:
                $this->validAudiences = $Vc;
                zb:
                goto eL;
            case "\117\x6e\145\124\151\x6d\145\125\163\x65":
                goto eL;
            case "\120\162\157\x78\x79\x52\145\163\x74\x72\151\x63\x74\x69\157\x6e":
                goto eL;
            default:
                throw new Exception("\x55\x6e\153\x6e\x6f\x77\x6e\40\143\157\x6e\x64\151\x74\x69\157\156\x3a\40" . var_export($rf->localName, TRUE));
        }
        rj:
        eL:
        Ba:
        $rf = $rf->nextSibling;
        goto wt;
        Gx:
    }
    private function parseAuthnStatement(DOMElement $pX)
    {
        $i1 = SAMLSPUtilities::xpQuery($pX, "\56\x2f\x73\x61\x6d\154\x5f\141\163\163\x65\x72\x74\x69\x6f\156\x3a\101\x75\164\x68\x6e\x53\164\141\164\145\155\x65\x6e\164");
        if (empty($i1)) {
            goto SR;
        }
        if (count($i1) > 1) {
            goto R0;
        }
        goto o4;
        SR:
        $this->authnInstant = NULL;
        return;
        goto o4;
        R0:
        throw new Exception("\115\x6f\x72\x65\x20\x74\x68\x61\x74\x20\157\x6e\145\x20\74\x73\x61\155\154\x3a\x41\165\x74\x68\156\123\x74\x61\x74\145\x6d\145\156\164\76\x20\x69\x6e\40\x3c\163\x61\155\154\x3a\101\163\x73\x65\x72\164\x69\157\x6e\x3e\x20\156\x6f\164\40\x73\x75\160\160\157\x72\x74\145\x64\x2e");
        o4:
        $Q2 = $i1[0];
        if ($Q2->hasAttribute("\x41\x75\164\150\x6e\111\x6e\x73\164\x61\x6e\x74")) {
            goto pW;
        }
        throw new Exception("\x4d\x69\x73\163\151\x6e\147\40\x72\x65\161\165\x69\162\145\144\40\x41\165\164\x68\x6e\111\x6e\x73\164\x61\156\x74\40\x61\x74\164\x72\x69\142\x75\x74\x65\x20\157\156\x20\x3c\x73\x61\155\x6c\x3a\101\x75\164\150\156\x53\164\x61\164\145\x6d\145\x6e\x74\76\x2e");
        pW:
        $this->authnInstant = SAMLSPUtilities::xsDateTimeToTimestamp($Q2->getAttribute("\101\165\x74\150\x6e\x49\156\163\x74\x61\156\x74"));
        if (!$Q2->hasAttribute("\123\145\x73\x73\x69\157\156\x4e\157\x74\117\x6e\x4f\x72\101\x66\164\x65\162")) {
            goto ME;
        }
        $this->sessionNotOnOrAfter = SAMLSPUtilities::xsDateTimeToTimestamp($Q2->getAttribute("\x53\145\163\163\x69\157\x6e\116\x6f\x74\x4f\156\x4f\x72\x41\x66\x74\x65\x72"));
        ME:
        if (!$Q2->hasAttribute("\x53\x65\x73\163\151\157\x6e\111\x6e\x64\145\x78")) {
            goto IH;
        }
        $this->sessionIndex = $Q2->getAttribute("\123\145\x73\163\x69\x6f\156\111\156\144\x65\170");
        IH:
        $this->parseAuthnContext($Q2);
    }
    private function parseAuthnContext(DOMElement $zj)
    {
        $P3 = SAMLSPUtilities::xpQuery($zj, "\56\x2f\x73\141\155\x6c\137\141\x73\163\145\162\164\151\x6f\x6e\72\101\165\x74\150\156\103\x6f\156\164\x65\170\x74");
        if (count($P3) > 1) {
            goto uf;
        }
        if (empty($P3)) {
            goto x1;
        }
        goto dY;
        uf:
        throw new Exception("\115\157\x72\x65\x20\164\x68\x61\156\x20\157\x6e\x65\40\74\x73\141\x6d\154\x3a\x41\x75\164\150\156\x43\x6f\156\x74\x65\x78\164\x3e\x20\x69\x6e\40\74\163\141\155\154\x3a\101\x75\x74\150\x6e\x53\164\141\164\x65\155\x65\x6e\164\x3e\56");
        goto dY;
        x1:
        throw new Exception("\115\151\x73\x73\151\x6e\x67\40\162\x65\x71\x75\151\x72\x65\x64\x20\74\x73\x61\x6d\154\72\101\165\164\150\x6e\103\157\156\x74\145\170\x74\76\40\x69\x6e\40\x3c\x73\141\155\x6c\72\101\x75\x74\x68\x6e\123\x74\x61\x74\x65\155\145\x6e\164\76\56");
        dY:
        $EC = $P3[0];
        $oP = SAMLSPUtilities::xpQuery($EC, "\56\57\x73\x61\155\154\137\141\163\163\145\x72\x74\151\157\x6e\x3a\x41\165\164\x68\156\103\x6f\x6e\164\145\170\x74\104\x65\x63\154\x52\x65\x66");
        if (count($oP) > 1) {
            goto wT;
        }
        if (count($oP) === 1) {
            goto i1;
        }
        goto kq;
        wT:
        throw new Exception("\115\x6f\162\145\x20\164\150\141\x6e\40\x6f\156\x65\x20\x3c\163\x61\x6d\154\x3a\101\165\164\x68\x6e\x43\x6f\156\x74\145\170\164\104\145\x63\x6c\x52\145\146\x3e\x20\x66\157\x75\156\144\x3f");
        goto kq;
        i1:
        $this->setAuthnContextDeclRef(trim($oP[0]->textContent));
        kq:
        $tQ = SAMLSPUtilities::xpQuery($EC, "\56\57\163\141\x6d\154\x5f\141\x73\163\145\x72\x74\151\x6f\x6e\72\x41\x75\x74\x68\156\x43\x6f\156\x74\145\170\164\x44\145\x63\x6c");
        if (count($tQ) > 1) {
            goto bq;
        }
        if (count($tQ) === 1) {
            goto wa;
        }
        goto LR;
        bq:
        throw new Exception("\x4d\x6f\162\145\x20\164\x68\x61\x6e\x20\x6f\156\145\x20\x3c\163\x61\x6d\154\x3a\x41\x75\164\x68\156\x43\157\x6e\x74\145\x78\x74\104\x65\x63\x6c\76\x20\146\x6f\x75\x6e\144\77");
        goto LR;
        wa:
        $this->setAuthnContextDecl(new SAML2_XML_Chunk($tQ[0]));
        LR:
        $xL = SAMLSPUtilities::xpQuery($EC, "\56\57\x73\141\155\x6c\x5f\x61\x73\163\145\162\164\151\157\x6e\x3a\101\x75\x74\150\x6e\x43\x6f\156\164\x65\170\x74\103\154\x61\163\x73\x52\145\x66");
        if (count($xL) > 1) {
            goto Zr;
        }
        if (count($xL) === 1) {
            goto s8;
        }
        goto iF1;
        Zr:
        throw new Exception("\x4d\x6f\162\x65\40\x74\150\141\156\40\157\x6e\145\x20\x3c\x73\x61\155\154\72\101\x75\x74\x68\156\x43\157\156\x74\x65\170\164\103\x6c\141\163\163\x52\145\146\76\x20\x69\x6e\x20\x3c\163\x61\155\154\x3a\101\x75\164\150\x6e\x43\x6f\156\x74\x65\x78\164\76\56");
        goto iF1;
        s8:
        $this->setAuthnContextClassRef(trim($xL[0]->textContent));
        iF1:
        if (!(empty($this->authnContextClassRef) && empty($this->authnContextDecl) && empty($this->authnContextDeclRef))) {
            goto uy;
        }
        throw new Exception("\x4d\x69\163\163\x69\x6e\x67\x20\145\151\164\x68\145\x72\x20\x3c\163\141\155\x6c\72\x41\165\x74\x68\156\x43\x6f\156\164\x65\x78\x74\103\154\x61\x73\x73\122\x65\x66\x3e\40\x6f\x72\40\x3c\x73\x61\x6d\154\x3a\101\165\164\150\156\x43\x6f\156\x74\x65\170\x74\x44\x65\x63\x6c\122\145\x66\76\40\x6f\162\40\x3c\x73\141\155\x6c\72\x41\x75\164\x68\156\x43\x6f\x6e\164\x65\170\164\x44\145\x63\x6c\x3e");
        uy:
        $this->AuthenticatingAuthority = SAMLSPUtilities::extractStrings($EC, "\x75\x72\x6e\72\x6f\x61\163\x69\163\72\x6e\141\155\x65\x73\72\x74\143\72\x53\101\115\x4c\x3a\62\x2e\60\72\141\x73\x73\145\162\x74\151\x6f\156", "\101\x75\x74\x68\145\156\164\x69\x63\x61\x74\151\x6e\147\101\x75\x74\150\x6f\x72\151\164\171");
    }
    private function parseAttributes(DOMElement $pX)
    {
        $wJ = TRUE;
        $Vp = SAMLSPUtilities::xpQuery($pX, "\x2e\57\163\x61\155\x6c\x5f\141\163\163\x65\x72\164\151\x6f\x6e\72\x41\164\x74\x72\151\142\165\164\145\123\164\x61\164\x65\155\x65\x6e\x74\x2f\163\x61\155\x6c\137\x61\163\x73\145\x72\x74\x69\x6f\156\x3a\101\x74\164\162\151\142\165\164\x65");
        foreach ($Vp as $kD) {
            if ($kD->hasAttribute("\x4e\x61\x6d\145")) {
                goto TZ;
            }
            throw new Exception("\x4d\151\x73\x73\151\156\147\x20\156\x61\x6d\145\40\157\x6e\x20\74\x73\141\155\x6c\x3a\101\x74\x74\x72\151\142\165\164\145\76\40\x65\154\145\155\x65\x6e\164\x2e");
            TZ:
            $AF = $kD->getAttribute("\x4e\x61\x6d\145");
            if ($kD->hasAttribute("\x4e\x61\x6d\x65\106\157\x72\155\x61\164")) {
                goto vB;
            }
            $zf = "\x75\x72\156\x3a\157\x61\x73\x69\163\x3a\x6e\141\155\x65\163\72\164\x63\72\x53\x41\115\114\x3a\x31\56\61\72\156\x61\x6d\x65\151\144\55\146\x6f\162\x6d\141\x74\72\165\x6e\163\x70\145\x63\x69\x66\x69\145\144";
            goto RT;
            vB:
            $zf = $kD->getAttribute("\116\x61\x6d\145\106\x6f\x72\x6d\x61\164");
            RT:
            if ($wJ) {
                goto cD;
            }
            if (!($this->nameFormat !== $zf)) {
                goto PO;
            }
            $this->nameFormat = "\165\x72\156\72\x6f\141\163\151\163\x3a\156\x61\x6d\x65\x73\72\x74\x63\72\123\101\115\x4c\x3a\x31\x2e\x31\x3a\156\141\x6d\x65\151\x64\x2d\146\x6f\x72\155\x61\x74\72\165\x6e\x73\160\145\143\151\146\x69\145\144";
            PO:
            goto tS;
            cD:
            $this->nameFormat = $zf;
            $wJ = FALSE;
            tS:
            if (array_key_exists($AF, $this->attributes)) {
                goto A0;
            }
            $this->attributes[$AF] = array();
            A0:
            $aq = SAMLSPUtilities::xpQuery($kD, "\x2e\x2f\163\141\155\x6c\x5f\141\163\163\x65\x72\x74\151\157\x6e\x3a\x41\x74\x74\162\x69\x62\165\164\x65\x56\141\154\165\145");
            foreach ($aq as $g2) {
                $this->attributes[$AF][] = trim($g2->textContent);
                qg:
            }
            vA:
            ht:
        }
        gl:
    }
    private function parseEncryptedAttributes(DOMElement $pX)
    {
        $this->encryptedAttribute = SAMLSPUtilities::xpQuery($pX, "\56\x2f\163\141\x6d\x6c\x5f\x61\x73\163\145\162\164\x69\157\156\72\101\164\164\x72\x69\142\x75\x74\x65\x53\x74\141\x74\145\155\145\156\164\x2f\x73\141\x6d\x6c\x5f\x61\x73\163\145\162\164\x69\x6f\156\x3a\105\x6e\143\162\171\x70\x74\x65\144\101\164\164\x72\151\x62\165\x74\x65");
    }
    private function parseSignature(DOMElement $pX)
    {
        $yL = SAMLSPUtilities::validateElement($pX);
        if (!($yL !== FALSE)) {
            goto Ds;
        }
        $this->wasSignedAtConstruction = TRUE;
        $this->certificates = $yL["\103\x65\162\164\x69\x66\151\143\x61\164\145\x73"];
        $this->signatureData = $yL;
        Ds:
    }
    public function validate(XMLSecurityKey $ld)
    {
        if (!($this->signatureData === NULL)) {
            goto Im;
        }
        return FALSE;
        Im:
        SAMLSPUtilities::validateSignature($this->signatureData, $ld);
        return TRUE;
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
    public function getIssuer()
    {
        return $this->issuer;
    }
    public function setIssuer($DR)
    {
        $this->issuer = $DR;
    }
    public function getNameId()
    {
        if (!($this->encryptedNameId !== NULL)) {
            goto RD;
        }
        throw new Exception("\x41\164\x74\x65\x6d\160\164\145\x64\40\164\157\40\162\145\x74\x72\x69\x65\166\x65\x20\145\156\143\x72\171\160\x74\x65\x64\x20\116\141\x6d\x65\x49\104\x20\167\151\164\150\157\x75\164\40\144\145\143\x72\x79\160\164\151\x6e\x67\40\151\x74\x20\146\151\x72\163\164\x2e");
        RD:
        return $this->nameId;
    }
    public function setNameId($RQ)
    {
        $this->nameId = $RQ;
    }
    public function isNameIdEncrypted()
    {
        if (!($this->encryptedNameId !== NULL)) {
            goto kX;
        }
        return TRUE;
        kX:
        return FALSE;
    }
    public function encryptNameId(XMLSecurityKey $ld)
    {
        $Yf = new DOMDocument();
        $F4 = $Yf->createElement("\162\x6f\x6f\164");
        $Yf->appendChild($F4);
        SAMLSPUtilities::addNameId($F4, $this->nameId);
        $RQ = $F4->firstChild;
        SAMLSPUtilities::getContainer()->debugMessage($RQ, "\x65\156\143\x72\171\x70\164");
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
            goto Ta;
        }
        return;
        Ta:
        $RQ = SAMLSPUtilities::decryptElement($this->encryptedNameId, $ld, $hu);
        SAMLSPUtilities::getContainer()->debugMessage($RQ, "\x64\x65\x63\x72\171\160\164");
        $this->nameId = SAMLSPUtilities::parseNameId($RQ);
        $this->encryptedNameId = NULL;
    }
    public function decryptAttributes(XMLSecurityKey $ld, array $hu = array())
    {
        if (!($this->encryptedAttribute === NULL)) {
            goto v5;
        }
        return;
        v5:
        $wJ = TRUE;
        $Vp = $this->encryptedAttribute;
        foreach ($Vp as $wj) {
            $kD = SAMLSPUtilities::decryptElement($wj->getElementsByTagName("\x45\x6e\143\162\171\160\164\145\144\104\141\164\141")->item(0), $ld, $hu);
            if ($kD->hasAttribute("\116\x61\155\145")) {
                goto a5;
            }
            throw new Exception("\x4d\x69\x73\163\151\156\147\40\x6e\x61\155\x65\x20\x6f\156\40\x3c\163\141\155\154\x3a\x41\164\164\162\x69\142\x75\164\x65\x3e\40\145\x6c\x65\155\x65\x6e\164\56");
            a5:
            $AF = $kD->getAttribute("\116\x61\x6d\x65");
            if ($kD->hasAttribute("\x4e\x61\155\x65\106\x6f\x72\155\141\164")) {
                goto x9;
            }
            $zf = "\x75\162\x6e\72\x6f\141\163\151\163\x3a\x6e\141\x6d\145\x73\72\164\143\72\x53\101\115\114\72\x32\x2e\60\72\141\164\x74\x72\x6e\141\155\x65\x2d\146\157\x72\155\x61\x74\72\x75\x6e\x73\x70\145\143\x69\x66\151\145\144";
            goto uj;
            x9:
            $zf = $kD->getAttribute("\116\141\155\x65\106\157\162\155\x61\164");
            uj:
            if ($wJ) {
                goto Hw;
            }
            if (!($this->nameFormat !== $zf)) {
                goto tr;
            }
            $this->nameFormat = "\x75\162\x6e\x3a\x6f\141\x73\151\163\72\x6e\x61\155\145\x73\72\x74\143\72\x53\101\x4d\114\72\x32\56\60\72\141\164\164\x72\156\x61\155\145\x2d\x66\157\162\155\141\164\x3a\165\156\163\160\145\x63\151\x66\x69\x65\144";
            tr:
            goto LK;
            Hw:
            $this->nameFormat = $zf;
            $wJ = FALSE;
            LK:
            if (array_key_exists($AF, $this->attributes)) {
                goto jP;
            }
            $this->attributes[$AF] = array();
            jP:
            $aq = SAMLSPUtilities::xpQuery($kD, "\x2e\x2f\163\x61\x6d\154\137\x61\x73\x73\x65\x72\164\x69\x6f\156\72\x41\x74\x74\x72\151\142\165\x74\x65\x56\141\154\x75\145");
            foreach ($aq as $g2) {
                $this->attributes[$AF][] = trim($g2->textContent);
                KZ:
            }
            zQ:
            tz:
        }
        Mj:
    }
    public function getNotBefore()
    {
        return $this->notBefore;
    }
    public function setNotBefore($UL)
    {
        $this->notBefore = $UL;
    }
    public function getNotOnOrAfter()
    {
        return $this->notOnOrAfter;
    }
    public function setNotOnOrAfter($LP)
    {
        $this->notOnOrAfter = $LP;
    }
    public function setEncryptedAttributes($g_)
    {
        $this->requiredEncAttributes = $g_;
    }
    public function getValidAudiences()
    {
        return $this->validAudiences;
    }
    public function setValidAudiences(array $kB = NULL)
    {
        $this->validAudiences = $kB;
    }
    public function getAuthnInstant()
    {
        return $this->authnInstant;
    }
    public function setAuthnInstant($SV)
    {
        $this->authnInstant = $SV;
    }
    public function getSessionNotOnOrAfter()
    {
        return $this->sessionNotOnOrAfter;
    }
    public function setSessionNotOnOrAfter($Ir)
    {
        $this->sessionNotOnOrAfter = $Ir;
    }
    public function getSessionIndex()
    {
        return $this->sessionIndex;
    }
    public function setSessionIndex($u4)
    {
        $this->sessionIndex = $u4;
    }
    public function getAuthnContext()
    {
        if (empty($this->authnContextClassRef)) {
            goto SV;
        }
        return $this->authnContextClassRef;
        SV:
        if (empty($this->authnContextDeclRef)) {
            goto WE;
        }
        return $this->authnContextDeclRef;
        WE:
        return NULL;
    }
    public function setAuthnContext($RK)
    {
        $this->setAuthnContextClassRef($RK);
    }
    public function getAuthnContextClassRef()
    {
        return $this->authnContextClassRef;
    }
    public function setAuthnContextClassRef($sA)
    {
        $this->authnContextClassRef = $sA;
    }
    public function setAuthnContextDecl(SAML2_XML_Chunk $cs)
    {
        if (empty($this->authnContextDeclRef)) {
            goto XV;
        }
        throw new Exception("\101\165\164\x68\x6e\103\157\156\x74\145\170\164\x44\145\x63\x6c\x52\x65\x66\40\151\x73\40\x61\154\162\x65\x61\144\171\x20\162\145\x67\x69\x73\164\145\162\x65\x64\41\40\x4d\141\x79\x20\x6f\156\154\171\x20\150\x61\x76\145\x20\x65\x69\x74\x68\x65\162\x20\141\40\x44\x65\x63\x6c\x20\157\x72\40\141\40\x44\x65\143\x6c\x52\x65\146\54\40\156\x6f\x74\40\x62\157\164\x68\41");
        XV:
        $this->authnContextDecl = $cs;
    }
    public function getAuthnContextDecl()
    {
        return $this->authnContextDecl;
    }
    public function setAuthnContextDeclRef($GB)
    {
        if (empty($this->authnContextDecl)) {
            goto y8;
        }
        throw new Exception("\x41\165\x74\150\x6e\103\x6f\x6e\164\145\170\x74\104\145\x63\x6c\40\x69\x73\x20\141\154\x72\145\141\x64\171\x20\162\x65\x67\x69\163\x74\x65\x72\145\144\x21\40\x4d\x61\x79\40\157\x6e\154\x79\40\150\141\166\x65\40\x65\x69\164\x68\145\162\x20\x61\x20\104\145\x63\x6c\40\x6f\x72\x20\141\x20\104\145\143\x6c\x52\x65\x66\x2c\x20\156\x6f\x74\x20\x62\x6f\164\150\x21");
        y8:
        $this->authnContextDeclRef = $GB;
    }
    public function getAuthnContextDeclRef()
    {
        return $this->authnContextDeclRef;
    }
    public function getAuthenticatingAuthority()
    {
        return $this->AuthenticatingAuthority;
    }
    public function setAuthenticatingAuthority($Xy)
    {
        $this->AuthenticatingAuthority = $Xy;
    }
    public function getAttributes()
    {
        return $this->attributes;
    }
    public function setAttributes(array $Vp)
    {
        $this->attributes = $Vp;
    }
    public function getAttributeNameFormat()
    {
        return $this->nameFormat;
    }
    public function setAttributeNameFormat($zf)
    {
        $this->nameFormat = $zf;
    }
    public function getSubjectConfirmation()
    {
        return $this->SubjectConfirmation;
    }
    public function setSubjectConfirmation(array $Vd)
    {
        $this->SubjectConfirmation = $Vd;
    }
    public function getSignatureKey()
    {
        return $this->signatureKey;
    }
    public function setSignatureKey(XMLsecurityKey $Wx = NULL)
    {
        $this->signatureKey = $Wx;
    }
    public function getEncryptionKey()
    {
        return $this->encryptionKey;
    }
    public function setEncryptionKey(XMLSecurityKey $i7 = NULL)
    {
        $this->encryptionKey = $i7;
    }
    public function setCertificates(array $E7)
    {
        $this->certificates = $E7;
    }
    public function getCertificates()
    {
        return $this->certificates;
    }
    public function getSignatureData()
    {
        return $this->signatureData;
    }
    public function getWasSignedAtConstruction()
    {
        return $this->wasSignedAtConstruction;
    }
    public function toXML(DOMNode $Ox = NULL)
    {
        if ($Ox === NULL) {
            goto cX;
        }
        $BE = $Ox->ownerDocument;
        goto S7;
        cX:
        $BE = new DOMDocument();
        $Ox = $BE;
        S7:
        $F4 = $BE->createElementNS("\x75\162\156\x3a\x6f\x61\163\x69\x73\x3a\156\141\x6d\x65\x73\72\x74\143\72\123\101\x4d\114\72\62\x2e\60\72\x61\163\163\x65\162\x74\151\x6f\156", "\163\x61\155\154\72" . "\101\163\x73\x65\x72\164\x69\157\x6e");
        $Ox->appendChild($F4);
        $F4->setAttributeNS("\165\x72\x6e\72\157\141\x73\x69\163\72\x6e\x61\155\x65\163\72\164\143\x3a\x53\101\x4d\x4c\x3a\62\56\x30\x3a\160\162\157\164\x6f\x63\x6f\x6c", "\163\141\155\x6c\x70\72\164\x6d\160", "\164\x6d\160");
        $F4->removeAttributeNS("\165\x72\156\72\157\x61\x73\151\x73\x3a\156\141\x6d\x65\163\72\164\143\72\123\101\115\114\72\62\x2e\x30\72\x70\162\157\164\157\143\x6f\x6c", "\164\x6d\160");
        $F4->setAttributeNS("\x68\164\x74\x70\x3a\57\x2f\x77\167\167\56\x77\63\56\x6f\162\147\57\x32\x30\x30\x31\57\130\115\x4c\x53\143\x68\x65\155\141\55\151\156\x73\164\141\x6e\143\x65", "\x78\163\x69\72\164\155\x70", "\x74\x6d\160");
        $F4->removeAttributeNS("\150\164\164\160\x3a\x2f\57\x77\167\167\x2e\167\x33\x2e\x6f\x72\x67\57\x32\x30\60\61\x2f\130\x4d\114\x53\143\x68\145\x6d\141\55\151\156\x73\x74\x61\156\143\145", "\164\x6d\x70");
        $F4->setAttributeNS("\150\164\164\x70\72\x2f\x2f\x77\x77\x77\x2e\x77\63\x2e\x6f\162\x67\57\62\60\x30\61\x2f\130\115\114\x53\x63\x68\145\x6d\x61", "\170\x73\x3a\164\x6d\160", "\x74\x6d\160");
        $F4->removeAttributeNS("\x68\x74\164\x70\x3a\57\x2f\x77\167\167\56\x77\63\x2e\157\162\147\57\x32\60\x30\61\57\x58\x4d\114\x53\143\x68\x65\155\x61", "\x74\155\x70");
        $F4->setAttribute("\x49\104", $this->id);
        $F4->setAttribute("\x56\145\162\x73\151\157\156", "\x32\x2e\x30");
        $F4->setAttribute("\x49\x73\x73\x75\145\x49\156\x73\x74\x61\x6e\164", gmdate("\131\x2d\155\55\144\134\124\110\x3a\x69\x3a\163\x5c\x5a", $this->issueInstant));
        $DR = SAMLSPUtilities::addString($F4, "\x75\162\156\72\x6f\x61\163\151\x73\x3a\156\141\x6d\145\x73\72\164\143\x3a\123\101\x4d\x4c\72\x32\x2e\x30\x3a\x61\x73\x73\145\162\164\x69\157\156", "\163\141\155\x6c\72\111\x73\x73\x75\145\162", $this->issuer);
        $this->addSubject($F4);
        $this->addConditions($F4);
        $this->addAuthnStatement($F4);
        if ($this->requiredEncAttributes == FALSE) {
            goto JU;
        }
        $this->addEncryptedAttributeStatement($F4);
        goto T2;
        JU:
        $this->addAttributeStatement($F4);
        T2:
        if (!($this->signatureKey !== NULL)) {
            goto Sp;
        }
        SAMLSPUtilities::insertSignature($this->signatureKey, $this->certificates, $F4, $DR->nextSibling);
        Sp:
        return $F4;
    }
    private function addSubject(DOMElement $F4)
    {
        if (!($this->nameId === NULL && $this->encryptedNameId === NULL)) {
            goto W7;
        }
        return;
        W7:
        $gq = $F4->ownerDocument->createElementNS("\165\162\156\x3a\x6f\x61\x73\151\x73\72\x6e\x61\x6d\x65\163\x3a\x74\143\72\123\x41\115\x4c\72\62\x2e\60\x3a\141\x73\x73\145\162\164\x69\157\156", "\x73\141\155\154\x3a\x53\165\142\x6a\x65\x63\164");
        $F4->appendChild($gq);
        if ($this->encryptedNameId === NULL) {
            goto N5;
        }
        $ij = $gq->ownerDocument->createElementNS("\165\x72\156\72\157\141\x73\x69\163\72\156\x61\155\145\x73\72\164\143\72\x53\x41\115\114\72\62\56\60\72\141\163\163\x65\162\x74\x69\157\x6e", "\x73\x61\155\154\72" . "\x45\156\x63\x72\171\x70\164\x65\x64\111\104");
        $gq->appendChild($ij);
        $ij->appendChild($gq->ownerDocument->importNode($this->encryptedNameId, TRUE));
        goto T6;
        N5:
        SAMLSPUtilities::addNameId($gq, $this->nameId);
        T6:
        foreach ($this->SubjectConfirmation as $VV) {
            $VV->toXML($gq);
            M2:
        }
        iI:
    }
    private function addConditions(DOMElement $F4)
    {
        $BE = $F4->ownerDocument;
        $vk = $BE->createElementNS("\x75\x72\156\x3a\x6f\141\x73\151\163\72\156\141\x6d\x65\x73\72\164\x63\72\x53\x41\115\114\x3a\62\x2e\x30\72\141\x73\x73\x65\162\x74\151\157\156", "\163\141\155\154\x3a\x43\x6f\156\x64\x69\x74\151\x6f\156\163");
        $F4->appendChild($vk);
        if (!($this->notBefore !== NULL)) {
            goto Ot;
        }
        $vk->setAttribute("\116\157\164\x42\x65\146\x6f\162\x65", gmdate("\x59\55\x6d\55\x64\x5c\x54\x48\72\151\x3a\163\x5c\x5a", $this->notBefore));
        Ot:
        if (!($this->notOnOrAfter !== NULL)) {
            goto Ki;
        }
        $vk->setAttribute("\x4e\x6f\164\x4f\x6e\x4f\162\x41\x66\164\x65\x72", gmdate("\131\x2d\155\55\x64\x5c\x54\110\72\x69\x3a\163\134\x5a", $this->notOnOrAfter));
        Ki:
        if (!($this->validAudiences !== NULL)) {
            goto Ab;
        }
        $Gv = $BE->createElementNS("\x75\x72\x6e\72\x6f\x61\163\151\163\x3a\156\x61\155\x65\x73\x3a\164\143\x3a\x53\x41\115\x4c\x3a\62\x2e\60\x3a\141\x73\x73\x65\x72\x74\151\157\x6e", "\163\141\155\x6c\x3a\x41\165\x64\x69\x65\156\x63\x65\x52\145\163\x74\162\x69\x63\164\x69\x6f\x6e");
        $vk->appendChild($Gv);
        SAMLSPUtilities::addStrings($Gv, "\x75\162\x6e\72\157\x61\x73\151\163\x3a\156\x61\155\x65\163\72\x74\143\x3a\x53\101\x4d\114\72\62\56\x30\x3a\x61\163\x73\x65\162\x74\151\157\x6e", "\x73\141\155\154\72\101\x75\144\151\145\156\143\145", FALSE, $this->validAudiences);
        Ab:
    }
    private function addAuthnStatement(DOMElement $F4)
    {
        if (!($this->authnInstant === NULL || $this->authnContextClassRef === NULL && $this->authnContextDecl === NULL && $this->authnContextDeclRef === NULL)) {
            goto Ry;
        }
        return;
        Ry:
        $BE = $F4->ownerDocument;
        $zj = $BE->createElementNS("\x75\x72\x6e\x3a\x6f\141\x73\x69\x73\x3a\156\x61\155\145\x73\x3a\164\x63\x3a\x53\101\115\x4c\x3a\62\56\60\x3a\x61\163\x73\145\162\x74\151\157\x6e", "\x73\141\155\x6c\72\x41\x75\164\150\x6e\x53\164\141\164\x65\155\145\156\x74");
        $F4->appendChild($zj);
        $zj->setAttribute("\x41\x75\x74\150\156\x49\x6e\163\x74\141\156\164", gmdate("\x59\x2d\155\x2d\x64\x5c\124\110\x3a\151\x3a\163\134\x5a", $this->authnInstant));
        if (!($this->sessionNotOnOrAfter !== NULL)) {
            goto J8;
        }
        $zj->setAttribute("\123\x65\163\x73\151\x6f\x6e\116\x6f\164\x4f\x6e\117\162\101\146\164\145\x72", gmdate("\131\x2d\x6d\55\144\134\124\110\x3a\x69\72\163\134\x5a", $this->sessionNotOnOrAfter));
        J8:
        if (!($this->sessionIndex !== NULL)) {
            goto Jf;
        }
        $zj->setAttribute("\123\x65\x73\163\x69\157\156\x49\x6e\x64\x65\170", $this->sessionIndex);
        Jf:
        $EC = $BE->createElementNS("\x75\162\156\72\157\141\x73\x69\163\x3a\x6e\141\x6d\x65\x73\72\x74\143\72\123\x41\115\x4c\x3a\x32\x2e\60\x3a\141\x73\163\145\x72\164\151\157\156", "\163\141\x6d\x6c\x3a\101\x75\164\150\x6e\x43\x6f\x6e\164\x65\170\x74");
        $zj->appendChild($EC);
        if (empty($this->authnContextClassRef)) {
            goto b0;
        }
        SAMLSPUtilities::addString($EC, "\x75\x72\x6e\x3a\157\x61\x73\x69\x73\72\156\141\155\145\163\x3a\x74\143\x3a\123\x41\115\x4c\x3a\62\x2e\x30\72\141\163\163\x65\x72\164\151\157\156", "\163\x61\155\x6c\x3a\x41\x75\164\150\x6e\x43\157\156\x74\145\x78\164\103\154\x61\x73\163\x52\145\146", $this->authnContextClassRef);
        b0:
        if (empty($this->authnContextDecl)) {
            goto eT;
        }
        $this->authnContextDecl->toXML($EC);
        eT:
        if (empty($this->authnContextDeclRef)) {
            goto qQ;
        }
        SAMLSPUtilities::addString($EC, "\165\x72\x6e\x3a\x6f\141\x73\x69\x73\72\x6e\x61\155\145\163\72\x74\x63\72\x53\101\x4d\x4c\72\62\x2e\x30\x3a\x61\163\163\145\x72\164\x69\x6f\156", "\163\141\155\154\72\101\x75\164\150\x6e\103\157\156\164\145\x78\164\104\x65\x63\x6c\x52\x65\146", $this->authnContextDeclRef);
        qQ:
        SAMLSPUtilities::addStrings($EC, "\x75\x72\156\72\157\141\x73\151\163\72\x6e\141\155\145\163\x3a\x74\x63\x3a\x53\101\x4d\x4c\x3a\62\x2e\x30\72\x61\x73\163\145\x72\x74\x69\x6f\156", "\x73\x61\155\x6c\72\x41\165\164\150\145\x6e\x74\x69\143\x61\164\151\156\147\101\x75\x74\x68\x6f\x72\151\x74\171", FALSE, $this->AuthenticatingAuthority);
    }
    private function addAttributeStatement(DOMElement $F4)
    {
        if (!empty($this->attributes)) {
            goto i0;
        }
        return;
        i0:
        $BE = $F4->ownerDocument;
        $dd = $BE->createElementNS("\165\x72\156\72\157\141\x73\x69\x73\x3a\x6e\x61\x6d\145\x73\72\164\x63\x3a\x53\101\x4d\x4c\x3a\62\56\x30\72\x61\163\163\x65\162\164\151\x6f\156", "\163\141\x6d\154\x3a\101\164\x74\162\x69\x62\165\x74\x65\123\x74\x61\164\145\155\145\156\x74");
        $F4->appendChild($dd);
        foreach ($this->attributes as $AF => $aq) {
            $kD = $BE->createElementNS("\165\x72\x6e\x3a\x6f\x61\163\151\x73\72\x6e\x61\x6d\x65\163\x3a\164\x63\72\123\101\x4d\114\x3a\62\56\x30\72\x61\x73\163\x65\162\164\x69\x6f\x6e", "\163\141\155\x6c\x3a\101\x74\x74\162\151\x62\165\164\145");
            $dd->appendChild($kD);
            $kD->setAttribute("\116\141\155\145", $AF);
            if (!($this->nameFormat !== "\165\x72\156\72\x6f\x61\x73\151\163\72\x6e\141\155\x65\163\x3a\x74\143\72\123\x41\115\114\72\62\56\60\x3a\x61\164\x74\x72\156\x61\x6d\145\x2d\x66\157\x72\x6d\141\x74\72\x75\x6e\163\x70\145\143\x69\146\x69\145\144")) {
                goto VA;
            }
            $kD->setAttribute("\x4e\x61\x6d\145\106\157\x72\x6d\x61\164", $this->nameFormat);
            VA:
            foreach ($aq as $g2) {
                if (is_string($g2)) {
                    goto K_;
                }
                if (is_int($g2)) {
                    goto qd;
                }
                $fH = NULL;
                goto CF;
                K_:
                $fH = "\170\163\72\x73\164\x72\x69\x6e\x67";
                goto CF;
                qd:
                $fH = "\x78\163\72\151\156\x74\145\147\145\x72";
                CF:
                $gQ = $BE->createElementNS("\x75\x72\x6e\72\157\x61\x73\151\x73\x3a\x6e\141\155\145\163\72\164\143\x3a\123\101\115\x4c\x3a\62\56\x30\x3a\x61\x73\163\145\162\x74\151\157\x6e", "\163\141\x6d\x6c\72\101\164\x74\162\151\142\165\164\x65\126\x61\x6c\165\145");
                $kD->appendChild($gQ);
                if (!($fH !== NULL)) {
                    goto Hv;
                }
                $gQ->setAttributeNS("\150\164\164\160\x3a\x2f\x2f\x77\x77\167\56\167\x33\x2e\157\162\147\57\62\60\x30\x31\x2f\130\115\x4c\123\x63\x68\x65\155\141\55\151\x6e\x73\164\141\x6e\143\145", "\170\x73\151\72\x74\171\160\x65", $fH);
                Hv:
                if (!is_null($g2)) {
                    goto sQ;
                }
                $gQ->setAttributeNS("\150\x74\x74\160\x3a\57\x2f\167\167\x77\56\167\63\x2e\157\x72\147\x2f\x32\60\x30\x31\x2f\130\x4d\x4c\x53\x63\x68\x65\155\x61\55\151\x6e\163\x74\141\x6e\x63\x65", "\170\x73\x69\x3a\x6e\x69\154", "\x74\162\165\x65");
                sQ:
                if ($g2 instanceof DOMNodeList) {
                    goto FX;
                }
                $gQ->appendChild($BE->createTextNode($g2));
                goto MG;
                FX:
                $oM = 0;
                M7:
                if (!($oM < $g2->length)) {
                    goto DH;
                }
                $rf = $BE->importNode($g2->item($oM), TRUE);
                $gQ->appendChild($rf);
                BK:
                $oM++;
                goto M7;
                DH:
                MG:
                jh:
            }
            z2:
            Sb:
        }
        Ld:
    }
    private function addEncryptedAttributeStatement(DOMElement $F4)
    {
        if (!($this->requiredEncAttributes == FALSE)) {
            goto v9;
        }
        return;
        v9:
        $BE = $F4->ownerDocument;
        $dd = $BE->createElementNS("\165\x72\156\72\x6f\x61\163\151\163\72\x6e\x61\155\145\163\x3a\164\x63\x3a\x53\x41\115\114\72\x32\56\60\x3a\x61\163\163\x65\x72\x74\x69\x6f\x6e", "\x73\x61\155\x6c\72\101\x74\x74\162\151\x62\165\x74\145\x53\164\x61\164\145\x6d\145\156\x74");
        $F4->appendChild($dd);
        foreach ($this->attributes as $AF => $aq) {
            $Rm = new DOMDocument();
            $kD = $Rm->createElementNS("\x75\162\156\x3a\x6f\141\x73\151\x73\72\156\141\155\x65\163\72\164\143\72\123\x41\115\114\x3a\62\56\x30\72\141\x73\163\145\162\x74\x69\x6f\156", "\x73\141\155\154\x3a\101\x74\x74\x72\x69\142\x75\164\x65");
            $kD->setAttribute("\116\x61\x6d\145", $AF);
            $Rm->appendChild($kD);
            if (!($this->nameFormat !== "\x75\162\156\x3a\x6f\x61\x73\151\163\x3a\x6e\141\x6d\x65\x73\x3a\x74\143\x3a\x53\101\115\114\x3a\x32\x2e\60\72\141\x74\x74\x72\156\x61\155\145\x2d\146\157\x72\155\x61\164\x3a\165\156\163\160\145\143\x69\146\x69\x65\144")) {
                goto Aa;
            }
            $kD->setAttribute("\116\141\x6d\145\x46\x6f\x72\x6d\141\x74", $this->nameFormat);
            Aa:
            foreach ($aq as $g2) {
                if (is_string($g2)) {
                    goto tW;
                }
                if (is_int($g2)) {
                    goto M6;
                }
                $fH = NULL;
                goto im;
                tW:
                $fH = "\x78\163\72\x73\164\x72\x69\x6e\147";
                goto im;
                M6:
                $fH = "\x78\x73\x3a\x69\x6e\164\x65\147\x65\x72";
                im:
                $gQ = $Rm->createElementNS("\165\162\x6e\72\x6f\x61\x73\151\163\72\x6e\141\x6d\x65\x73\x3a\x74\143\72\x53\101\115\x4c\x3a\62\56\60\72\141\x73\x73\145\x72\x74\x69\x6f\x6e", "\x73\141\x6d\x6c\72\x41\x74\164\x72\x69\x62\165\164\145\126\x61\154\165\145");
                $kD->appendChild($gQ);
                if (!($fH !== NULL)) {
                    goto t2;
                }
                $gQ->setAttributeNS("\x68\x74\x74\x70\x3a\57\57\167\167\167\56\x77\x33\x2e\157\162\147\57\x32\60\60\61\x2f\130\x4d\x4c\x53\x63\x68\x65\x6d\141\55\x69\156\x73\x74\x61\x6e\143\x65", "\170\x73\x69\x3a\164\171\160\x65", $fH);
                t2:
                if ($g2 instanceof DOMNodeList) {
                    goto Pm;
                }
                $gQ->appendChild($Rm->createTextNode($g2));
                goto lH;
                Pm:
                $oM = 0;
                Ja:
                if (!($oM < $g2->length)) {
                    goto sB;
                }
                $rf = $Rm->importNode($g2->item($oM), TRUE);
                $gQ->appendChild($rf);
                Q9:
                $oM++;
                goto Ja;
                sB:
                lH:
                jC:
            }
            Ix:
            $mC = new XMLSecEnc();
            $mC->setNode($Rm->documentElement);
            $mC->type = "\150\x74\x74\160\72\57\57\167\167\x77\56\167\x33\56\x6f\x72\x67\x2f\x32\x30\60\x31\57\60\64\57\170\x6d\x6c\x65\156\x63\x23\105\x6c\145\155\145\156\x74";
            $fP = new XMLSecurityKey(XMLSecurityKey::AES256_CBC);
            $fP->generateSessionKey();
            $mC->encryptKey($this->encryptionKey, $fP);
            $IE = $mC->encryptNode($fP);
            $Lt = $BE->createElementNS("\x75\x72\156\x3a\157\141\x73\151\163\72\x6e\x61\x6d\145\x73\x3a\x74\x63\x3a\x53\101\x4d\x4c\x3a\x32\x2e\x30\72\141\163\x73\x65\x72\x74\x69\157\x6e", "\x73\x61\x6d\154\72\105\156\x63\x72\x79\160\x74\x65\x64\101\x74\164\162\151\142\x75\x74\145");
            $dd->appendChild($Lt);
            $tK = $BE->importNode($IE, TRUE);
            $Lt->appendChild($tK);
            Vr:
        }
        aj:
    }
}
