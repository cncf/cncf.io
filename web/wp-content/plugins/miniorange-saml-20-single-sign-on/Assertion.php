<?php


include_once "\x55\x74\x69\154\151\x74\x69\x65\x73\56\160\x68\x70";
include_once "\x78\155\154\x73\145\143\154\151\x62\163\x2e\x70\x68\x70";
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
    public function __construct(DOMElement $Cr = NULL, $QE)
    {
        $this->id = SAMLSPUtilities::generateId();
        $this->issueInstant = SAMLSPUtilities::generateTimestamp();
        $this->issuer = '';
        $this->authnInstant = SAMLSPUtilities::generateTimestamp();
        $this->attributes = array();
        $this->nameFormat = "\x75\162\x6e\x3a\157\x61\x73\151\163\72\x6e\141\155\x65\x73\72\164\143\72\123\101\x4d\114\72\61\56\x31\x3a\x6e\x61\155\x65\151\144\55\x66\x6f\x72\x6d\141\x74\72\x75\x6e\x73\160\x65\143\151\x66\151\145\x64";
        $this->certificates = array();
        $this->AuthenticatingAuthority = array();
        $this->SubjectConfirmation = array();
        if (!($Cr === NULL)) {
            goto mO;
        }
        return;
        mO:
        if (!($Cr->localName === "\105\x6e\x63\x72\x79\160\164\145\x64\101\x73\163\x65\x72\164\151\157\156")) {
            goto bX;
        }
        $uY = SAMLSPUtilities::xpQuery($Cr, "\x2e\x2f\170\145\156\x63\x3a\x45\156\143\x72\x79\x70\164\x65\144\104\x61\x74\141");
        $iT = SAMLSPUtilities::xpQuery($Cr, "\57\x2f\52\x5b\x6c\x6f\143\x61\x6c\55\x6e\141\155\145\50\x29\75\47\105\156\143\x72\171\x70\x74\145\x64\x4b\x65\171\x27\x5d\x2f\52\133\x6c\157\x63\x61\x6c\55\156\141\155\145\x28\51\75\47\105\x6e\x63\162\171\160\164\151\157\x6e\x4d\x65\x74\x68\x6f\144\x27\135\57\x40\101\154\147\x6f\x72\x69\x74\150\x6d");
        $Vp = $iT[0]->value;
        $YE = SAMLSPUtilities::getEncryptionAlgorithm($Vp);
        if (count($uY) === 0) {
            goto tF;
        }
        if (count($uY) > 1) {
            goto fh;
        }
        goto t0;
        tF:
        throw new Exception("\115\x69\x73\163\x69\156\x67\40\145\156\x63\x72\171\160\164\145\144\40\144\141\x74\141\40\151\156\40\74\163\x61\x6d\154\x3a\105\156\143\x72\171\160\164\145\x64\x41\x73\x73\x65\162\164\151\x6f\x6e\x3e\56");
        goto t0;
        fh:
        throw new Exception("\x4d\157\x72\145\x20\164\150\x61\x6e\x20\157\x6e\145\40\x65\x6e\x63\x72\x79\160\x74\x65\144\x20\x64\x61\164\141\x20\145\x6c\145\x6d\x65\156\164\40\151\156\x20\74\163\x61\155\x6c\x3a\105\156\x63\162\x79\x70\164\x65\x64\x41\x73\x73\145\x72\x74\x69\x6f\x6e\76\56");
        t0:
        $uZ = new XMLSecurityKey($YE, array("\x74\171\x70\145" => "\160\x72\151\166\141\x74\145"));
        $uZ->loadKey($QE, FALSE);
        $aK = array();
        $Cr = SAMLSPUtilities::decryptElement($uY[0], $uZ, $aK);
        bX:
        if ($Cr->hasAttribute("\111\104")) {
            goto tK;
        }
        throw new Exception("\115\151\x73\163\x69\156\147\x20\111\104\x20\141\x74\164\162\x69\142\165\164\x65\40\x6f\x6e\40\123\101\115\114\40\x61\163\163\x65\x72\164\x69\x6f\156\x2e");
        tK:
        $this->id = $Cr->getAttribute("\111\104");
        if (!($Cr->getAttribute("\x56\x65\162\163\x69\x6f\156") !== "\x32\x2e\60")) {
            goto B6;
        }
        throw new Exception("\x55\156\163\x75\x70\160\157\162\164\145\144\x20\166\x65\162\x73\151\x6f\x6e\x3a\40" . $Cr->getAttribute("\x56\x65\162\163\151\157\x6e"));
        B6:
        $this->issueInstant = SAMLSPUtilities::xsDateTimeToTimestamp($Cr->getAttribute("\111\163\163\x75\x65\x49\156\163\x74\x61\156\x74"));
        $o3 = SAMLSPUtilities::xpQuery($Cr, "\x2e\57\163\141\155\x6c\137\141\x73\x73\145\162\x74\x69\157\156\x3a\111\x73\x73\165\145\x72");
        if (!empty($o3)) {
            goto sR;
        }
        throw new Exception("\x4d\x69\163\163\151\156\x67\x20\74\163\x61\155\154\72\x49\x73\163\x75\x65\x72\x3e\x20\x69\x6e\40\141\x73\x73\145\162\x74\151\157\156\56");
        sR:
        $this->issuer = trim($o3[0]->textContent);
        $this->parseConditions($Cr);
        $this->parseAuthnStatement($Cr);
        $this->parseAttributes($Cr);
        $this->parseEncryptedAttributes($Cr);
        $this->parseSignature($Cr);
        $this->parseSubject($Cr);
    }
    private function parseSubject(DOMElement $Cr)
    {
        $z2 = SAMLSPUtilities::xpQuery($Cr, "\x2e\57\163\x61\x6d\x6c\x5f\x61\163\x73\145\162\164\x69\157\x6e\x3a\123\x75\142\x6a\x65\143\x74");
        if (empty($z2)) {
            goto T3;
        }
        if (count($z2) > 1) {
            goto FB;
        }
        goto Z9;
        T3:
        return;
        goto Z9;
        FB:
        throw new Exception("\115\157\162\x65\x20\164\x68\x61\156\x20\157\156\x65\x20\x3c\163\x61\x6d\154\x3a\x53\165\x62\152\145\143\164\x3e\x20\x69\156\x20\x3c\163\141\x6d\154\72\101\163\x73\145\x72\x74\151\157\156\76\56");
        Z9:
        $z2 = $z2[0];
        $dN = SAMLSPUtilities::xpQuery($z2, "\56\57\163\141\155\154\x5f\x61\163\x73\145\162\164\x69\157\x6e\72\116\x61\x6d\145\x49\x44\40\x7c\40\56\57\163\x61\x6d\x6c\137\x61\x73\x73\145\162\x74\151\157\156\72\x45\156\x63\162\x79\160\x74\x65\x64\111\104\57\170\145\156\143\x3a\x45\x6e\143\162\x79\160\x74\x65\144\x44\141\x74\x61");
        if (empty($dN)) {
            goto Bm;
        }
        if (count($dN) > 1) {
            goto kZ;
        }
        goto bu;
        Bm:
        if ($_POST["\122\145\154\x61\x79\123\x74\141\x74\x65"] == "\164\145\163\164\126\141\x6c\151\x64\141\164\145" or $_POST["\x52\145\x6c\x61\171\123\x74\x61\164\145"] == "\164\x65\163\x74\116\x65\167\x43\145\162\x74\151\146\151\x63\x61\x74\145") {
            goto ai;
        }
        wp_die("\127\145\x20\143\157\165\x6c\144\40\156\x6f\x74\x20\163\151\x67\x6e\x20\171\157\165\x20\151\x6e\56\40\x50\x6c\x65\x61\163\145\x20\143\157\x6e\x74\141\x63\x74\40\171\157\x75\x72\40\x61\144\155\151\x6e\151\x73\x74\162\141\164\157\162");
        goto DV;
        ai:
        echo "\74\144\x69\166\x20\x73\x74\171\154\x65\x3d\x22\146\x6f\x6e\164\55\x66\141\155\x69\154\x79\72\x43\141\154\x69\142\x72\151\73\x70\x61\144\144\151\156\147\72\x30\x20\x33\x25\x3b\x22\76";
        echo "\74\144\151\166\40\163\x74\171\154\145\75\42\143\x6f\154\x6f\162\x3a\x20\x23\141\71\x34\x34\x34\62\x3b\x62\x61\143\153\147\x72\157\x75\x6e\144\x2d\x63\x6f\x6c\157\x72\72\x20\43\x66\x32\x64\145\x64\x65\73\160\141\x64\144\x69\x6e\x67\x3a\40\61\x35\160\170\x3b\x6d\141\162\x67\x69\156\x2d\142\x6f\164\164\157\x6d\72\x20\x32\60\x70\x78\x3b\x74\x65\x78\x74\x2d\x61\x6c\151\x67\x6e\72\143\x65\x6e\164\145\x72\x3b\142\157\162\144\145\x72\x3a\x31\x70\170\x20\x73\157\154\151\144\40\x23\105\x36\102\63\102\x32\x3b\146\157\x6e\164\x2d\163\151\172\x65\72\x31\x38\160\164\73\42\x3e\40\x45\x52\122\117\x52\x3c\x2f\x64\x69\166\x3e\xd\xa\x20\x20\40\x20\x20\x20\x20\40\40\x20\40\74\x64\x69\x76\x20\x73\x74\x79\154\145\75\x22\143\157\154\x6f\x72\72\40\43\141\71\x34\64\x34\x32\x3b\146\x6f\156\x74\55\163\151\x7a\x65\72\61\64\160\164\x3b\x20\x6d\141\162\x67\x69\156\55\x62\157\164\x74\157\x6d\x3a\x32\60\x70\170\73\x22\76\x3c\160\76\x3c\x73\x74\162\157\156\147\76\x45\x72\162\157\x72\x3a\x20\x3c\57\163\164\x72\157\156\x67\x3e\115\x69\x73\163\151\156\x67\40\x20\x4e\x61\155\x65\111\x44\40\151\156\x20\123\x41\115\x4c\40\122\x65\163\x70\x6f\156\x73\x65\x2e\x3c\x2f\x70\76\xd\xa\x20\40\x20\40\x20\40\x20\x20\x20\40\40\40\x20\40\x20\x20\74\x70\x3e\x50\x6c\x65\141\x73\145\x20\x63\157\156\x74\x61\143\164\x20\171\x6f\165\162\40\x61\x64\155\x69\x6e\x69\x73\164\x72\x61\164\157\x72\40\141\x6e\x64\40\162\145\x70\x6f\x72\164\x20\x74\x68\x65\x20\146\x6f\154\154\157\167\x69\x6e\147\x20\145\162\x72\157\x72\72\x3c\x2f\x70\76\xd\xa\x20\40\x20\x20\40\40\x20\40\x20\x20\x20\40\x20\x20\40\40\74\160\76\x3c\163\164\x72\157\156\x67\x3e\x50\x6f\x73\163\151\x62\154\145\x20\x43\141\165\163\145\x3a\74\x2f\163\x74\162\157\156\147\x3e\x20\116\x61\155\145\x49\x44\40\156\x6f\x74\x20\146\x6f\x75\156\144\40\151\156\40\x53\101\115\x4c\x20\x52\145\x73\x70\x6f\x6e\163\x65\40\163\x75\142\152\x65\x63\164\x2e\x3c\57\x70\x3e\xd\xa\40\40\x20\x20\x20\x20\x20\40\40\40\40\x20\x20\x20\40\40\74\x2f\x64\x69\x76\76\15\xa\x20\x20\x20\x20\x20\40\x20\x20\40\x20\x20\40\40\40\40\40\74\x64\151\x76\40\x73\x74\x79\154\145\75\42\155\x61\x72\147\151\x6e\72\63\45\73\144\x69\x73\x70\154\x61\x79\72\x62\154\x6f\143\x6b\x3b\164\x65\170\164\55\141\x6c\151\x67\x6e\x3a\143\145\156\x74\145\x72\x3b\x22\76\xd\12\x20\x20\x20\40\x20\40\40\x20\40\x20\x20\40\40\x20\40\xd\12\x20\40\x20\x20\x20\x20\x20\x20\x20\40\x20\40\x20\40\x20\40\74\144\151\x76\40\163\164\171\154\145\75\x22\x6d\x61\162\147\x69\x6e\72\63\45\73\x64\151\x73\160\154\141\171\x3a\142\x6c\x6f\143\x6b\73\x74\x65\x78\164\x2d\141\x6c\x69\147\x6e\72\143\145\156\x74\x65\162\x3b\42\x3e\x3c\151\x6e\x70\165\x74\x20\x73\x74\171\154\x65\75\42\160\x61\144\x64\x69\156\147\72\x31\x25\73\x77\151\x64\164\x68\x3a\x31\x30\x30\160\x78\73\142\x61\143\x6b\147\x72\157\x75\x6e\144\x3a\40\43\x30\x30\71\61\103\104\x20\x6e\157\x6e\145\40\x72\x65\x70\x65\x61\164\x20\163\x63\162\x6f\x6c\154\40\x30\x25\40\60\45\x3b\x63\165\162\163\x6f\162\72\40\x70\157\x69\x6e\x74\x65\x72\73\x66\157\156\x74\x2d\x73\x69\172\x65\x3a\61\x35\x70\170\73\142\x6f\x72\x64\x65\x72\55\167\151\144\x74\150\72\40\61\160\x78\x3b\x62\x6f\162\x64\145\162\x2d\163\164\x79\154\145\72\x20\x73\x6f\x6c\x69\x64\x3b\142\157\162\144\145\x72\55\x72\141\x64\x69\x75\163\72\x20\63\x70\170\73\167\x68\x69\164\x65\x2d\x73\160\x61\x63\145\72\40\156\157\167\x72\141\160\x3b\142\x6f\x78\55\x73\x69\172\151\156\147\x3a\x20\142\157\162\144\145\x72\x2d\142\x6f\170\x3b\142\157\162\144\x65\x72\55\x63\157\154\x6f\162\x3a\40\43\x30\x30\67\x33\x41\101\x3b\142\x6f\170\x2d\163\x68\141\144\x6f\167\72\40\x30\x70\x78\40\61\x70\x78\40\60\x70\170\x20\162\x67\x62\x61\50\x31\62\x30\x2c\x20\x32\60\x30\x2c\x20\x32\x33\60\54\40\x30\x2e\66\x29\x20\x69\x6e\x73\145\x74\73\143\157\154\157\162\72\40\43\106\106\x46\73\42\164\x79\x70\x65\75\x22\x62\165\x74\164\157\x6e\42\x20\166\141\154\165\145\75\x22\104\157\x6e\145\42\x20\x6f\x6e\x43\154\151\143\153\75\x22\163\145\x6c\146\56\143\x6c\157\163\145\x28\51\x3b\x22\76\74\x2f\144\x69\166\x3e";
        die;
        DV:
        goto bu;
        kZ:
        throw new Exception("\115\x6f\x72\x65\40\x74\x68\x61\x6e\40\x6f\x6e\145\40\x3c\x73\141\x6d\x6c\72\x4e\141\x6d\x65\x49\x44\76\x20\x6f\x72\40\74\163\x61\x6d\x6c\x3a\105\156\143\x72\x79\160\x74\145\144\x44\x3e\40\x69\x6e\40\x3c\x73\141\155\x6c\72\123\x75\142\x6a\x65\x63\164\x3e\56");
        bu:
        $dN = $dN[0];
        if ($dN->localName === "\105\x6e\x63\x72\171\x70\164\x65\x64\104\141\x74\x61") {
            goto BG;
        }
        $this->nameId = SAMLSPUtilities::parseNameId($dN);
        goto ST;
        BG:
        $this->encryptedNameId = $dN;
        ST:
    }
    private function parseConditions(DOMElement $Cr)
    {
        $h_ = SAMLSPUtilities::xpQuery($Cr, "\x2e\x2f\163\141\x6d\154\137\141\x73\x73\145\x72\x74\x69\157\156\x3a\x43\x6f\x6e\144\x69\164\x69\157\x6e\x73");
        if (empty($h_)) {
            goto JI;
        }
        if (count($h_) > 1) {
            goto SH;
        }
        goto LL;
        JI:
        return;
        goto LL;
        SH:
        throw new Exception("\115\x6f\x72\x65\40\x74\150\141\156\x20\157\156\x65\40\x3c\x73\141\x6d\154\x3a\103\157\x6e\x64\x69\x74\151\157\156\x73\76\x20\151\x6e\x20\x3c\163\x61\155\x6c\72\x41\x73\x73\145\162\x74\x69\157\x6e\76\x2e");
        LL:
        $h_ = $h_[0];
        if (!$h_->hasAttribute("\116\x6f\x74\x42\x65\x66\x6f\162\x65")) {
            goto Mw;
        }
        $eh = SAMLSPUtilities::xsDateTimeToTimestamp($h_->getAttribute("\x4e\157\164\x42\x65\146\x6f\162\145"));
        if (!($this->notBefore === NULL || $this->notBefore < $eh)) {
            goto Xt;
        }
        $this->notBefore = $eh;
        Xt:
        Mw:
        if (!$h_->hasAttribute("\x4e\157\x74\117\156\x4f\x72\101\x66\164\145\162")) {
            goto J_;
        }
        $qA = SAMLSPUtilities::xsDateTimeToTimestamp($h_->getAttribute("\x4e\x6f\x74\117\x6e\117\x72\101\x66\164\x65\x72"));
        if (!($this->notOnOrAfter === NULL || $this->notOnOrAfter > $qA)) {
            goto nO;
        }
        $this->notOnOrAfter = $qA;
        nO:
        J_:
        $Dg = $h_->firstChild;
        HN:
        if (!($Dg !== NULL)) {
            goto xR;
        }
        if (!$Dg instanceof DOMText) {
            goto rX;
        }
        goto PM;
        rX:
        if (!($Dg->namespaceURI !== "\165\x72\156\72\157\x61\163\x69\x73\72\x6e\141\x6d\145\163\72\164\143\72\x53\x41\x4d\114\72\62\x2e\x30\x3a\x61\163\x73\145\162\164\x69\157\156")) {
            goto RX;
        }
        throw new Exception("\125\156\x6b\x6e\x6f\167\156\x20\x6e\x61\x6d\145\163\x70\141\143\145\x20\157\x66\x20\143\x6f\x6e\144\151\164\151\x6f\156\72\40" . var_export($Dg->namespaceURI, TRUE));
        RX:
        switch ($Dg->localName) {
            case "\101\165\x64\151\x65\x6e\x63\145\x52\x65\163\x74\x72\x69\x63\x74\151\157\x6e":
                $lh = SAMLSPUtilities::extractStrings($Dg, "\x75\x72\156\x3a\157\x61\163\x69\163\x3a\x6e\141\x6d\145\163\x3a\x74\143\72\x53\x41\115\114\x3a\62\x2e\x30\x3a\x61\163\x73\145\162\164\x69\x6f\x6e", "\x41\x75\x64\151\145\156\143\x65");
                if ($this->validAudiences === NULL) {
                    goto jH;
                }
                $this->validAudiences = array_intersect($this->validAudiences, $lh);
                goto Qo;
                jH:
                $this->validAudiences = $lh;
                Qo:
                goto Bx;
            case "\117\x6e\145\x54\x69\x6d\145\125\x73\x65":
                goto Bx;
            case "\x50\x72\x6f\x78\x79\122\145\163\164\x72\151\143\164\151\157\156":
                goto Bx;
            default:
                throw new Exception("\x55\156\153\156\x6f\167\x6e\40\143\157\x6e\144\x69\164\x69\x6f\x6e\72\40" . var_export($Dg->localName, TRUE));
        }
        g_:
        Bx:
        PM:
        $Dg = $Dg->nextSibling;
        goto HN;
        xR:
    }
    private function parseAuthnStatement(DOMElement $Cr)
    {
        $l5 = SAMLSPUtilities::xpQuery($Cr, "\56\57\x73\x61\155\154\x5f\x61\163\163\145\162\x74\151\157\x6e\x3a\101\x75\164\x68\x6e\x53\164\x61\164\145\155\x65\x6e\x74");
        if (empty($l5)) {
            goto w1;
        }
        if (count($l5) > 1) {
            goto Fd;
        }
        goto Us;
        w1:
        $this->authnInstant = NULL;
        return;
        goto Us;
        Fd:
        throw new Exception("\115\157\162\x65\40\164\150\x61\164\40\157\156\145\x20\74\163\x61\x6d\x6c\x3a\101\x75\x74\150\x6e\x53\x74\x61\x74\145\x6d\x65\156\164\76\x20\x69\x6e\40\74\x73\141\155\x6c\x3a\x41\163\x73\x65\x72\164\151\x6f\156\76\40\156\x6f\164\40\163\165\160\160\157\x72\164\145\144\x2e");
        Us:
        $bY = $l5[0];
        if ($bY->hasAttribute("\x41\165\x74\x68\156\111\156\x73\x74\x61\156\x74")) {
            goto OX;
        }
        throw new Exception("\115\x69\x73\163\151\x6e\x67\40\162\145\x71\x75\x69\x72\145\x64\x20\101\x75\164\150\156\111\156\163\x74\x61\156\x74\40\x61\164\164\162\x69\x62\165\x74\145\x20\157\156\x20\x3c\x73\141\x6d\154\72\101\x75\x74\x68\x6e\123\x74\141\164\145\155\145\156\x74\x3e\56");
        OX:
        $this->authnInstant = SAMLSPUtilities::xsDateTimeToTimestamp($bY->getAttribute("\101\x75\x74\150\156\x49\156\163\x74\x61\156\164"));
        if (!$bY->hasAttribute("\x53\x65\163\x73\x69\157\156\x4e\x6f\x74\x4f\x6e\117\x72\x41\x66\x74\x65\162")) {
            goto C3;
        }
        $this->sessionNotOnOrAfter = SAMLSPUtilities::xsDateTimeToTimestamp($bY->getAttribute("\x53\145\x73\x73\151\x6f\x6e\116\x6f\x74\x4f\x6e\x4f\162\x41\146\x74\145\x72"));
        C3:
        if (!$bY->hasAttribute("\123\x65\163\163\x69\157\156\x49\156\x64\145\170")) {
            goto JH;
        }
        $this->sessionIndex = $bY->getAttribute("\x53\145\163\x73\x69\157\156\x49\x6e\x64\145\170");
        JH:
        $this->parseAuthnContext($bY);
    }
    private function parseAuthnContext(DOMElement $Zf)
    {
        $XQ = SAMLSPUtilities::xpQuery($Zf, "\x2e\x2f\163\x61\155\x6c\137\x61\163\x73\145\162\x74\x69\x6f\x6e\x3a\101\x75\x74\150\x6e\103\157\x6e\x74\x65\x78\x74");
        if (count($XQ) > 1) {
            goto fz;
        }
        if (empty($XQ)) {
            goto N3;
        }
        goto KE;
        fz:
        throw new Exception("\115\157\162\x65\40\164\150\x61\x6e\x20\x6f\x6e\x65\40\74\163\141\x6d\x6c\72\101\165\x74\x68\x6e\x43\x6f\156\x74\x65\x78\164\x3e\x20\151\156\40\74\163\x61\155\154\72\x41\x75\x74\150\x6e\x53\x74\x61\164\x65\x6d\x65\x6e\x74\x3e\56");
        goto KE;
        N3:
        throw new Exception("\115\151\x73\163\x69\156\147\40\x72\145\161\165\151\x72\x65\144\40\x3c\x73\x61\155\154\72\x41\x75\x74\150\x6e\x43\157\156\164\145\170\x74\76\x20\x69\x6e\x20\74\163\141\x6d\154\x3a\101\165\164\150\x6e\123\164\x61\x74\x65\155\x65\x6e\x74\76\x2e");
        KE:
        $Cm = $XQ[0];
        $jq = SAMLSPUtilities::xpQuery($Cm, "\56\57\x73\141\x6d\154\137\141\163\163\x65\162\164\x69\x6f\156\x3a\x41\165\164\x68\x6e\103\157\x6e\164\145\x78\x74\x44\145\143\x6c\122\145\x66");
        if (count($jq) > 1) {
            goto GU;
        }
        if (count($jq) === 1) {
            goto Ea;
        }
        goto Qa;
        GU:
        throw new Exception("\x4d\157\162\x65\40\x74\150\x61\156\x20\x6f\156\145\x20\74\163\141\x6d\154\72\101\165\164\150\156\103\x6f\156\x74\145\x78\x74\x44\x65\x63\x6c\122\145\146\76\40\146\157\165\x6e\144\77");
        goto Qa;
        Ea:
        $this->setAuthnContextDeclRef(trim($jq[0]->textContent));
        Qa:
        $r4 = SAMLSPUtilities::xpQuery($Cm, "\x2e\x2f\x73\x61\x6d\154\137\x61\163\163\x65\162\164\151\x6f\156\72\x41\x75\x74\x68\156\103\157\156\x74\145\x78\164\x44\x65\143\x6c");
        if (count($r4) > 1) {
            goto h0;
        }
        if (count($r4) === 1) {
            goto uZ;
        }
        goto rd;
        h0:
        throw new Exception("\115\x6f\x72\145\x20\164\150\x61\x6e\x20\157\156\x65\40\74\x73\x61\x6d\x6c\72\x41\165\164\x68\x6e\x43\157\156\164\145\x78\164\104\x65\143\154\76\x20\146\x6f\165\x6e\x64\x3f");
        goto rd;
        uZ:
        $this->setAuthnContextDecl(new SAML2_XML_Chunk($r4[0]));
        rd:
        $nP = SAMLSPUtilities::xpQuery($Cm, "\56\x2f\x73\141\x6d\154\x5f\x61\163\x73\x65\x72\164\151\157\156\72\x41\x75\x74\x68\x6e\x43\x6f\x6e\164\145\170\x74\103\154\x61\x73\163\122\x65\146");
        if (count($nP) > 1) {
            goto MG;
        }
        if (count($nP) === 1) {
            goto Yx;
        }
        goto yZ;
        MG:
        throw new Exception("\115\x6f\162\145\40\x74\x68\141\x6e\40\157\156\145\x20\74\x73\141\x6d\x6c\x3a\x41\x75\164\150\156\x43\157\156\164\145\x78\164\x43\154\x61\163\x73\122\x65\x66\x3e\x20\151\x6e\x20\x3c\163\141\x6d\154\x3a\101\x75\164\150\156\103\157\156\x74\145\x78\164\76\56");
        goto yZ;
        Yx:
        $this->setAuthnContextClassRef(trim($nP[0]->textContent));
        yZ:
        if (!(empty($this->authnContextClassRef) && empty($this->authnContextDecl) && empty($this->authnContextDeclRef))) {
            goto kk;
        }
        throw new Exception("\115\x69\163\163\x69\x6e\x67\40\145\151\164\x68\145\x72\40\x3c\163\x61\x6d\154\72\x41\165\164\x68\x6e\x43\157\156\x74\145\x78\x74\x43\154\x61\163\163\x52\x65\x66\76\x20\x6f\x72\40\74\x73\141\x6d\154\72\x41\x75\x74\x68\156\x43\x6f\x6e\164\145\x78\164\104\x65\x63\x6c\122\x65\146\76\40\157\x72\x20\x3c\x73\x61\x6d\154\x3a\x41\165\164\x68\x6e\103\157\156\164\145\170\164\x44\145\143\154\76");
        kk:
        $this->AuthenticatingAuthority = SAMLSPUtilities::extractStrings($Cm, "\x75\x72\156\72\157\141\163\151\163\72\x6e\x61\155\145\x73\x3a\164\x63\72\123\x41\115\x4c\x3a\x32\56\x30\72\x61\163\163\145\x72\x74\x69\x6f\x6e", "\x41\165\164\150\x65\156\x74\x69\143\141\x74\x69\x6e\147\101\x75\164\x68\157\x72\x69\164\171");
    }
    private function parseAttributes(DOMElement $Cr)
    {
        $He = TRUE;
        $Cz = SAMLSPUtilities::xpQuery($Cr, "\56\57\163\x61\155\154\137\x61\x73\163\145\162\164\x69\157\156\x3a\x41\x74\x74\x72\x69\x62\165\x74\x65\x53\x74\141\x74\x65\155\145\156\164\57\163\141\x6d\x6c\x5f\x61\163\163\x65\x72\x74\x69\x6f\x6e\x3a\101\x74\x74\x72\151\x62\165\x74\145");
        foreach ($Cz as $u9) {
            if ($u9->hasAttribute("\116\x61\x6d\x65")) {
                goto BW;
            }
            throw new Exception("\115\151\x73\x73\x69\156\x67\x20\x6e\x61\155\145\40\157\156\40\x3c\163\x61\155\x6c\72\x41\164\164\x72\x69\142\x75\164\x65\76\40\145\154\145\155\x65\156\164\x2e");
            BW:
            $XE = $u9->getAttribute("\x4e\141\155\145");
            if ($u9->hasAttribute("\116\x61\x6d\x65\x46\x6f\162\155\x61\x74")) {
                goto ke;
            }
            $Z5 = "\165\162\x6e\72\x6f\141\x73\151\x73\72\x6e\x61\x6d\145\163\x3a\164\x63\72\x53\x41\115\x4c\x3a\61\x2e\x31\x3a\156\141\155\x65\151\144\55\x66\x6f\x72\x6d\141\164\x3a\165\x6e\x73\x70\145\x63\x69\146\151\x65\144";
            goto oU;
            ke:
            $Z5 = $u9->getAttribute("\116\141\155\x65\x46\157\162\155\x61\164");
            oU:
            if ($He) {
                goto hB;
            }
            if (!($this->nameFormat !== $Z5)) {
                goto EM;
            }
            $this->nameFormat = "\165\x72\156\72\157\x61\163\151\x73\x3a\156\141\155\x65\x73\72\164\x63\x3a\x53\101\x4d\114\x3a\61\x2e\61\72\x6e\141\x6d\145\x69\144\55\x66\157\162\155\141\164\x3a\165\x6e\x73\160\145\x63\151\146\x69\x65\x64";
            EM:
            goto UG;
            hB:
            $this->nameFormat = $Z5;
            $He = FALSE;
            UG:
            if (array_key_exists($XE, $this->attributes)) {
                goto WT;
            }
            $this->attributes[$XE] = array();
            WT:
            $rd = SAMLSPUtilities::xpQuery($u9, "\x2e\57\x73\141\x6d\154\x5f\141\x73\x73\145\162\x74\x69\157\x6e\x3a\101\164\x74\162\x69\142\165\164\x65\126\x61\x6c\165\145");
            foreach ($rd as $Ka) {
                $this->attributes[$XE][] = trim($Ka->textContent);
                kX:
            }
            Ga:
            H1:
        }
        jz:
    }
    private function parseEncryptedAttributes(DOMElement $Cr)
    {
        $this->encryptedAttribute = SAMLSPUtilities::xpQuery($Cr, "\x2e\57\x73\141\155\x6c\137\141\163\x73\145\x72\164\x69\x6f\x6e\72\101\164\x74\x72\151\142\x75\x74\145\x53\164\141\164\145\155\x65\156\x74\57\163\x61\x6d\x6c\137\141\163\163\x65\162\x74\151\x6f\x6e\x3a\x45\156\x63\x72\x79\160\164\145\144\x41\164\164\x72\151\x62\165\164\145");
    }
    private function parseSignature(DOMElement $Cr)
    {
        $DD = SAMLSPUtilities::validateElement($Cr);
        if (!($DD !== FALSE)) {
            goto sA;
        }
        $this->wasSignedAtConstruction = TRUE;
        $this->certificates = $DD["\103\x65\162\x74\x69\x66\x69\143\x61\x74\145\163"];
        $this->signatureData = $DD;
        sA:
    }
    public function validate(XMLSecurityKey $uZ)
    {
        if (!($this->signatureData === NULL)) {
            goto Y1;
        }
        return FALSE;
        Y1:
        SAMLSPUtilities::validateSignature($this->signatureData, $uZ);
        return TRUE;
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
    public function getIssuer()
    {
        return $this->issuer;
    }
    public function setIssuer($o3)
    {
        $this->issuer = $o3;
    }
    public function getNameId()
    {
        if (!($this->encryptedNameId !== NULL)) {
            goto wP;
        }
        throw new Exception("\101\x74\x74\x65\x6d\160\164\145\144\40\x74\x6f\40\x72\x65\x74\x72\151\145\166\145\x20\145\156\x63\x72\x79\160\x74\x65\x64\40\x4e\x61\155\x65\111\104\40\167\151\x74\150\x6f\165\x74\40\144\145\x63\162\x79\x70\164\151\x6e\147\x20\151\164\x20\146\x69\x72\163\x74\56");
        wP:
        return $this->nameId;
    }
    public function setNameId($dN)
    {
        $this->nameId = $dN;
    }
    public function isNameIdEncrypted()
    {
        if (!($this->encryptedNameId !== NULL)) {
            goto Xk;
        }
        return TRUE;
        Xk:
        return FALSE;
    }
    public function encryptNameId(XMLSecurityKey $uZ)
    {
        $wP = new DOMDocument();
        $pZ = $wP->createElement("\162\157\157\x74");
        $wP->appendChild($pZ);
        SAMLSPUtilities::addNameId($pZ, $this->nameId);
        $dN = $pZ->firstChild;
        SAMLSPUtilities::getContainer()->debugMessage($dN, "\145\156\x63\162\171\x70\x74");
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
            goto GJ;
        }
        return;
        GJ:
        $dN = SAMLSPUtilities::decryptElement($this->encryptedNameId, $uZ, $aK);
        SAMLSPUtilities::getContainer()->debugMessage($dN, "\144\145\x63\x72\x79\x70\x74");
        $this->nameId = SAMLSPUtilities::parseNameId($dN);
        $this->encryptedNameId = NULL;
    }
    public function decryptAttributes(XMLSecurityKey $uZ, array $aK = array())
    {
        if (!($this->encryptedAttribute === NULL)) {
            goto OK;
        }
        return;
        OK:
        $He = TRUE;
        $Cz = $this->encryptedAttribute;
        foreach ($Cz as $Jg) {
            $u9 = SAMLSPUtilities::decryptElement($Jg->getElementsByTagName("\105\156\x63\x72\171\160\x74\145\x64\104\x61\164\141")->item(0), $uZ, $aK);
            if ($u9->hasAttribute("\116\x61\x6d\x65")) {
                goto v6;
            }
            throw new Exception("\115\151\163\163\151\x6e\147\x20\x6e\141\155\x65\40\157\x6e\40\x3c\x73\x61\155\x6c\72\101\x74\x74\162\x69\x62\165\x74\145\76\40\x65\154\x65\155\x65\156\x74\56");
            v6:
            $XE = $u9->getAttribute("\116\141\155\x65");
            if ($u9->hasAttribute("\x4e\141\155\145\106\x6f\162\x6d\x61\164")) {
                goto nG;
            }
            $Z5 = "\165\162\x6e\72\157\141\163\151\163\x3a\x6e\141\x6d\x65\x73\72\x74\143\72\123\x41\115\x4c\x3a\x32\x2e\x30\72\141\164\164\x72\156\141\155\145\55\146\x6f\x72\x6d\141\x74\72\165\x6e\163\x70\x65\143\151\x66\151\145\144";
            goto Cn;
            nG:
            $Z5 = $u9->getAttribute("\x4e\x61\x6d\145\106\157\162\x6d\x61\164");
            Cn:
            if ($He) {
                goto fA;
            }
            if (!($this->nameFormat !== $Z5)) {
                goto ee;
            }
            $this->nameFormat = "\165\x72\x6e\72\157\141\163\x69\163\72\x6e\141\x6d\x65\x73\x3a\164\143\x3a\123\x41\x4d\114\x3a\x32\56\60\x3a\x61\x74\164\x72\156\141\155\x65\55\146\157\x72\155\141\x74\72\x75\156\x73\160\145\143\x69\146\151\145\144";
            ee:
            goto vL;
            fA:
            $this->nameFormat = $Z5;
            $He = FALSE;
            vL:
            if (array_key_exists($XE, $this->attributes)) {
                goto OA;
            }
            $this->attributes[$XE] = array();
            OA:
            $rd = SAMLSPUtilities::xpQuery($u9, "\56\57\x73\x61\x6d\154\x5f\141\163\163\145\162\x74\151\x6f\x6e\x3a\x41\164\164\162\151\142\x75\164\145\x56\141\x6c\165\145");
            foreach ($rd as $Ka) {
                $this->attributes[$XE][] = trim($Ka->textContent);
                bA:
            }
            tI:
            rW:
        }
        t4:
    }
    public function getNotBefore()
    {
        return $this->notBefore;
    }
    public function setNotBefore($eh)
    {
        $this->notBefore = $eh;
    }
    public function getNotOnOrAfter()
    {
        return $this->notOnOrAfter;
    }
    public function setNotOnOrAfter($qA)
    {
        $this->notOnOrAfter = $qA;
    }
    public function setEncryptedAttributes($SO)
    {
        $this->requiredEncAttributes = $SO;
    }
    public function getValidAudiences()
    {
        return $this->validAudiences;
    }
    public function setValidAudiences(array $TY = NULL)
    {
        $this->validAudiences = $TY;
    }
    public function getAuthnInstant()
    {
        return $this->authnInstant;
    }
    public function setAuthnInstant($WD)
    {
        $this->authnInstant = $WD;
    }
    public function getSessionNotOnOrAfter()
    {
        return $this->sessionNotOnOrAfter;
    }
    public function setSessionNotOnOrAfter($um)
    {
        $this->sessionNotOnOrAfter = $um;
    }
    public function getSessionIndex()
    {
        return $this->sessionIndex;
    }
    public function setSessionIndex($T5)
    {
        $this->sessionIndex = $T5;
    }
    public function getAuthnContext()
    {
        if (empty($this->authnContextClassRef)) {
            goto b1;
        }
        return $this->authnContextClassRef;
        b1:
        if (empty($this->authnContextDeclRef)) {
            goto zI;
        }
        return $this->authnContextDeclRef;
        zI:
        return NULL;
    }
    public function setAuthnContext($I8)
    {
        $this->setAuthnContextClassRef($I8);
    }
    public function getAuthnContextClassRef()
    {
        return $this->authnContextClassRef;
    }
    public function setAuthnContextClassRef($wI)
    {
        $this->authnContextClassRef = $wI;
    }
    public function setAuthnContextDecl(SAML2_XML_Chunk $ln)
    {
        if (empty($this->authnContextDeclRef)) {
            goto Hy;
        }
        throw new Exception("\x41\x75\164\150\x6e\103\x6f\156\x74\x65\170\164\104\145\x63\x6c\x52\145\x66\x20\151\163\x20\141\x6c\x72\x65\x61\x64\171\40\162\x65\x67\151\163\x74\x65\162\x65\x64\x21\40\x4d\141\x79\x20\x6f\156\x6c\171\x20\x68\x61\166\x65\40\x65\151\x74\x68\x65\162\40\x61\x20\x44\x65\x63\154\40\157\x72\x20\141\40\104\145\x63\154\x52\145\x66\x2c\40\x6e\x6f\x74\40\142\x6f\164\x68\x21");
        Hy:
        $this->authnContextDecl = $ln;
    }
    public function getAuthnContextDecl()
    {
        return $this->authnContextDecl;
    }
    public function setAuthnContextDeclRef($fo)
    {
        if (empty($this->authnContextDecl)) {
            goto TD;
        }
        throw new Exception("\101\x75\x74\150\156\103\157\156\164\x65\x78\164\x44\x65\143\154\40\151\163\x20\141\154\x72\145\x61\144\x79\x20\x72\x65\147\x69\163\x74\x65\x72\x65\x64\41\40\x4d\141\x79\x20\x6f\156\154\171\x20\x68\x61\166\x65\40\x65\x69\x74\x68\x65\162\x20\141\40\104\x65\143\154\x20\x6f\162\x20\141\40\104\x65\x63\154\x52\x65\146\x2c\40\156\157\164\x20\142\157\164\150\x21");
        TD:
        $this->authnContextDeclRef = $fo;
    }
    public function getAuthnContextDeclRef()
    {
        return $this->authnContextDeclRef;
    }
    public function getAuthenticatingAuthority()
    {
        return $this->AuthenticatingAuthority;
    }
    public function setAuthenticatingAuthority($rf)
    {
        $this->AuthenticatingAuthority = $rf;
    }
    public function getAttributes()
    {
        return $this->attributes;
    }
    public function setAttributes(array $Cz)
    {
        $this->attributes = $Cz;
    }
    public function getAttributeNameFormat()
    {
        return $this->nameFormat;
    }
    public function setAttributeNameFormat($Z5)
    {
        $this->nameFormat = $Z5;
    }
    public function getSubjectConfirmation()
    {
        return $this->SubjectConfirmation;
    }
    public function setSubjectConfirmation(array $aE)
    {
        $this->SubjectConfirmation = $aE;
    }
    public function getSignatureKey()
    {
        return $this->signatureKey;
    }
    public function setSignatureKey(XMLsecurityKey $g7 = NULL)
    {
        $this->signatureKey = $g7;
    }
    public function getEncryptionKey()
    {
        return $this->encryptionKey;
    }
    public function setEncryptionKey(XMLSecurityKey $yb = NULL)
    {
        $this->encryptionKey = $yb;
    }
    public function setCertificates(array $BH)
    {
        $this->certificates = $BH;
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
    public function toXML(DOMNode $rm = NULL)
    {
        if ($rm === NULL) {
            goto OD;
        }
        $PG = $rm->ownerDocument;
        goto vT;
        OD:
        $PG = new DOMDocument();
        $rm = $PG;
        vT:
        $pZ = $PG->createElementNS("\165\162\x6e\72\157\x61\163\151\163\72\x6e\x61\x6d\145\x73\72\x74\143\x3a\123\x41\x4d\x4c\72\62\56\60\x3a\141\163\163\x65\x72\x74\151\157\x6e", "\163\x61\155\154\x3a" . "\101\163\163\x65\162\164\x69\x6f\156");
        $rm->appendChild($pZ);
        $pZ->setAttributeNS("\165\x72\x6e\x3a\x6f\x61\x73\151\163\x3a\156\141\x6d\145\x73\x3a\164\x63\x3a\x53\101\x4d\114\x3a\62\x2e\x30\72\x70\x72\157\164\157\x63\157\x6c", "\163\x61\155\154\160\72\164\155\x70", "\x74\155\160");
        $pZ->removeAttributeNS("\165\x72\156\x3a\157\x61\x73\x69\163\72\x6e\x61\155\x65\x73\72\164\143\x3a\123\101\x4d\x4c\72\x32\56\60\x3a\x70\x72\157\x74\157\x63\157\154", "\x74\x6d\x70");
        $pZ->setAttributeNS("\150\164\x74\160\72\57\x2f\167\167\x77\56\x77\x33\x2e\157\162\x67\57\x32\60\x30\61\x2f\130\115\114\123\143\x68\145\x6d\141\x2d\x69\x6e\163\x74\x61\156\x63\145", "\x78\x73\x69\x3a\x74\155\160", "\x74\x6d\160");
        $pZ->removeAttributeNS("\150\164\164\160\72\x2f\x2f\167\x77\167\56\x77\63\x2e\x6f\162\147\x2f\62\60\60\61\x2f\x58\115\x4c\123\x63\x68\x65\155\x61\55\151\x6e\x73\164\x61\x6e\143\x65", "\164\155\160");
        $pZ->setAttributeNS("\150\164\x74\160\72\57\x2f\x77\x77\167\x2e\x77\63\x2e\157\162\x67\x2f\62\x30\x30\x31\57\x58\115\x4c\x53\143\150\145\x6d\x61", "\x78\163\72\x74\x6d\160", "\164\155\x70");
        $pZ->removeAttributeNS("\x68\164\164\x70\x3a\x2f\x2f\x77\167\167\56\x77\x33\x2e\157\162\147\x2f\62\60\x30\x31\57\x58\115\x4c\123\143\150\x65\155\141", "\x74\155\160");
        $pZ->setAttribute("\111\x44", $this->id);
        $pZ->setAttribute("\126\145\x72\x73\x69\157\x6e", "\x32\x2e\60");
        $pZ->setAttribute("\x49\163\163\x75\x65\111\x6e\x73\164\141\x6e\164", gmdate("\x59\55\155\55\144\x5c\124\x48\72\x69\72\163\x5c\132", $this->issueInstant));
        $o3 = SAMLSPUtilities::addString($pZ, "\x75\162\156\x3a\157\141\163\x69\x73\x3a\156\x61\155\145\x73\x3a\x74\x63\72\x53\101\115\114\72\62\x2e\x30\72\x61\x73\x73\145\x72\164\151\x6f\x6e", "\163\x61\155\x6c\x3a\x49\x73\x73\165\x65\162", $this->issuer);
        $this->addSubject($pZ);
        $this->addConditions($pZ);
        $this->addAuthnStatement($pZ);
        if ($this->requiredEncAttributes == FALSE) {
            goto m4;
        }
        $this->addEncryptedAttributeStatement($pZ);
        goto Fo;
        m4:
        $this->addAttributeStatement($pZ);
        Fo:
        if (!($this->signatureKey !== NULL)) {
            goto qI;
        }
        SAMLSPUtilities::insertSignature($this->signatureKey, $this->certificates, $pZ, $o3->nextSibling);
        qI:
        return $pZ;
    }
    private function addSubject(DOMElement $pZ)
    {
        if (!($this->nameId === NULL && $this->encryptedNameId === NULL)) {
            goto QM;
        }
        return;
        QM:
        $z2 = $pZ->ownerDocument->createElementNS("\165\162\x6e\x3a\x6f\141\163\x69\x73\x3a\x6e\141\155\145\163\72\164\143\72\123\x41\x4d\x4c\72\62\56\x30\x3a\x61\163\x73\x65\x72\164\x69\x6f\156", "\163\x61\155\x6c\x3a\123\165\142\152\145\143\x74");
        $pZ->appendChild($z2);
        if ($this->encryptedNameId === NULL) {
            goto Ve;
        }
        $z9 = $z2->ownerDocument->createElementNS("\165\162\x6e\x3a\157\141\x73\x69\x73\x3a\x6e\x61\155\145\x73\x3a\164\143\72\x53\x41\x4d\x4c\72\62\56\x30\72\141\163\163\x65\162\164\x69\x6f\x6e", "\x73\141\155\x6c\x3a" . "\x45\156\143\x72\x79\160\164\145\144\111\104");
        $z2->appendChild($z9);
        $z9->appendChild($z2->ownerDocument->importNode($this->encryptedNameId, TRUE));
        goto fM;
        Ve:
        SAMLSPUtilities::addNameId($z2, $this->nameId);
        fM:
        foreach ($this->SubjectConfirmation as $sJ) {
            $sJ->toXML($z2);
            XN:
        }
        A8:
    }
    private function addConditions(DOMElement $pZ)
    {
        $PG = $pZ->ownerDocument;
        $h_ = $PG->createElementNS("\165\x72\156\72\x6f\x61\163\x69\x73\x3a\156\x61\x6d\145\163\72\x74\143\x3a\x53\x41\115\114\72\62\x2e\60\x3a\141\163\163\145\162\x74\151\157\x6e", "\163\141\x6d\x6c\x3a\103\157\x6e\144\x69\164\x69\x6f\156\163");
        $pZ->appendChild($h_);
        if (!($this->notBefore !== NULL)) {
            goto Sm;
        }
        $h_->setAttribute("\x4e\x6f\x74\102\145\x66\x6f\162\145", gmdate("\x59\x2d\155\55\144\134\124\x48\x3a\151\72\163\x5c\x5a", $this->notBefore));
        Sm:
        if (!($this->notOnOrAfter !== NULL)) {
            goto a6;
        }
        $h_->setAttribute("\x4e\157\164\117\x6e\117\x72\x41\146\164\145\x72", gmdate("\131\55\x6d\55\144\x5c\124\x48\72\151\72\x73\134\132", $this->notOnOrAfter));
        a6:
        if (!($this->validAudiences !== NULL)) {
            goto YK;
        }
        $WQ = $PG->createElementNS("\165\x72\x6e\72\x6f\x61\x73\x69\x73\72\x6e\x61\x6d\x65\x73\72\164\x63\72\123\101\115\x4c\x3a\x32\56\x30\x3a\x61\163\163\x65\x72\164\151\x6f\x6e", "\163\x61\155\154\72\101\165\x64\151\x65\156\x63\x65\122\x65\163\x74\162\x69\143\x74\x69\x6f\x6e");
        $h_->appendChild($WQ);
        SAMLSPUtilities::addStrings($WQ, "\x75\x72\156\x3a\x6f\x61\x73\x69\x73\x3a\x6e\141\155\145\163\72\164\x63\x3a\123\101\x4d\x4c\72\x32\56\x30\72\141\163\x73\x65\x72\x74\x69\x6f\x6e", "\163\141\155\x6c\x3a\x41\165\x64\x69\x65\x6e\143\145", FALSE, $this->validAudiences);
        YK:
    }
    private function addAuthnStatement(DOMElement $pZ)
    {
        if (!($this->authnInstant === NULL || $this->authnContextClassRef === NULL && $this->authnContextDecl === NULL && $this->authnContextDeclRef === NULL)) {
            goto Pn;
        }
        return;
        Pn:
        $PG = $pZ->ownerDocument;
        $Zf = $PG->createElementNS("\x75\x72\156\72\x6f\141\163\151\x73\x3a\x6e\141\x6d\145\163\x3a\164\143\x3a\x53\x41\x4d\114\72\x32\56\60\x3a\x61\163\x73\x65\x72\164\151\157\x6e", "\163\141\155\154\x3a\101\x75\x74\150\x6e\x53\164\141\164\145\155\145\x6e\x74");
        $pZ->appendChild($Zf);
        $Zf->setAttribute("\x41\x75\x74\150\x6e\111\x6e\x73\x74\x61\156\x74", gmdate("\x59\x2d\155\55\x64\x5c\124\x48\x3a\x69\x3a\163\134\x5a", $this->authnInstant));
        if (!($this->sessionNotOnOrAfter !== NULL)) {
            goto z3;
        }
        $Zf->setAttribute("\123\145\163\163\x69\157\156\116\x6f\164\x4f\x6e\117\162\101\x66\164\145\162", gmdate("\x59\55\155\x2d\x64\x5c\x54\110\x3a\151\x3a\x73\134\x5a", $this->sessionNotOnOrAfter));
        z3:
        if (!($this->sessionIndex !== NULL)) {
            goto zi;
        }
        $Zf->setAttribute("\123\145\163\163\151\157\x6e\111\156\x64\145\x78", $this->sessionIndex);
        zi:
        $Cm = $PG->createElementNS("\x75\x72\x6e\x3a\x6f\141\x73\151\x73\x3a\156\x61\155\x65\x73\x3a\x74\x63\x3a\123\101\x4d\114\x3a\62\x2e\60\72\x61\x73\x73\x65\162\x74\x69\157\156", "\163\x61\x6d\154\72\x41\x75\x74\150\x6e\x43\x6f\156\164\145\170\x74");
        $Zf->appendChild($Cm);
        if (empty($this->authnContextClassRef)) {
            goto lf;
        }
        SAMLSPUtilities::addString($Cm, "\x75\x72\x6e\x3a\x6f\141\163\x69\163\72\156\x61\x6d\x65\163\72\x74\143\72\123\101\115\x4c\72\x32\x2e\x30\72\141\x73\163\145\x72\164\x69\x6f\x6e", "\163\x61\x6d\154\x3a\x41\165\164\x68\156\x43\157\x6e\164\x65\170\x74\103\154\x61\163\x73\x52\x65\146", $this->authnContextClassRef);
        lf:
        if (empty($this->authnContextDecl)) {
            goto Uu;
        }
        $this->authnContextDecl->toXML($Cm);
        Uu:
        if (empty($this->authnContextDeclRef)) {
            goto sQ;
        }
        SAMLSPUtilities::addString($Cm, "\x75\x72\156\x3a\157\141\163\x69\x73\x3a\x6e\141\155\x65\163\72\x74\143\72\123\x41\x4d\x4c\72\x32\56\60\x3a\x61\x73\163\x65\162\x74\151\157\156", "\163\x61\x6d\154\x3a\x41\x75\x74\x68\x6e\103\157\156\164\x65\x78\164\x44\x65\x63\154\x52\x65\146", $this->authnContextDeclRef);
        sQ:
        SAMLSPUtilities::addStrings($Cm, "\165\x72\156\x3a\x6f\x61\x73\151\163\x3a\156\x61\x6d\x65\163\72\x74\x63\x3a\123\x41\115\114\72\62\56\x30\x3a\x61\x73\x73\145\x72\x74\151\x6f\x6e", "\163\x61\155\x6c\x3a\x41\165\x74\150\145\156\x74\151\143\141\x74\151\156\x67\101\165\x74\x68\157\162\151\x74\x79", FALSE, $this->AuthenticatingAuthority);
    }
    private function addAttributeStatement(DOMElement $pZ)
    {
        if (!empty($this->attributes)) {
            goto yQ;
        }
        return;
        yQ:
        $PG = $pZ->ownerDocument;
        $zw = $PG->createElementNS("\165\162\156\x3a\x6f\x61\x73\x69\x73\72\156\x61\x6d\x65\163\72\x74\x63\72\123\x41\x4d\x4c\72\62\x2e\60\72\141\163\x73\x65\x72\x74\x69\157\x6e", "\163\x61\155\154\72\x41\x74\164\162\x69\x62\165\164\x65\x53\164\x61\x74\145\x6d\145\x6e\164");
        $pZ->appendChild($zw);
        foreach ($this->attributes as $XE => $rd) {
            $u9 = $PG->createElementNS("\x75\162\156\x3a\x6f\x61\x73\151\163\72\x6e\x61\x6d\145\x73\x3a\x74\143\72\x53\101\115\x4c\72\x32\56\60\72\x61\163\x73\x65\x72\x74\151\157\156", "\x73\x61\155\x6c\x3a\101\164\x74\x72\151\x62\165\164\x65");
            $zw->appendChild($u9);
            $u9->setAttribute("\116\x61\x6d\x65", $XE);
            if (!($this->nameFormat !== "\165\162\x6e\72\x6f\x61\163\151\x73\72\156\x61\x6d\145\x73\x3a\164\x63\72\123\x41\x4d\114\72\62\56\x30\x3a\x61\x74\164\x72\x6e\x61\x6d\145\55\x66\x6f\x72\155\x61\164\x3a\165\x6e\x73\x70\x65\x63\x69\146\151\x65\144")) {
                goto uO;
            }
            $u9->setAttribute("\x4e\x61\155\145\x46\157\x72\x6d\141\x74", $this->nameFormat);
            uO:
            foreach ($rd as $Ka) {
                if (is_string($Ka)) {
                    goto ps;
                }
                if (is_int($Ka)) {
                    goto R_;
                }
                $u8 = NULL;
                goto CO;
                ps:
                $u8 = "\x78\163\72\x73\164\x72\x69\x6e\x67";
                goto CO;
                R_:
                $u8 = "\x78\x73\x3a\151\156\164\145\147\x65\x72";
                CO:
                $A3 = $PG->createElementNS("\x75\162\x6e\72\x6f\x61\x73\x69\x73\72\156\x61\x6d\145\163\x3a\x74\143\x3a\123\x41\x4d\x4c\x3a\62\x2e\x30\72\141\163\x73\145\x72\x74\x69\157\x6e", "\x73\141\x6d\x6c\x3a\x41\164\x74\x72\x69\x62\165\164\145\126\141\154\x75\x65");
                $u9->appendChild($A3);
                if (!($u8 !== NULL)) {
                    goto bI;
                }
                $A3->setAttributeNS("\150\x74\164\160\72\57\x2f\x77\167\x77\56\x77\63\x2e\157\x72\147\57\62\60\x30\x31\57\x58\115\114\123\x63\150\145\155\x61\x2d\x69\x6e\163\x74\141\156\143\145", "\170\x73\151\x3a\x74\171\x70\x65", $u8);
                bI:
                if (!is_null($Ka)) {
                    goto ja;
                }
                $A3->setAttributeNS("\x68\164\164\x70\x3a\57\57\167\x77\167\x2e\x77\63\56\157\x72\x67\x2f\x32\x30\x30\61\x2f\x58\115\x4c\x53\x63\150\145\155\x61\55\x69\156\x73\164\x61\156\143\145", "\x78\163\x69\72\156\x69\x6c", "\x74\162\x75\145");
                ja:
                if ($Ka instanceof DOMNodeList) {
                    goto yu;
                }
                $A3->appendChild($PG->createTextNode($Ka));
                goto lQ;
                yu:
                $LH = 0;
                i5:
                if (!($LH < $Ka->length)) {
                    goto hu;
                }
                $Dg = $PG->importNode($Ka->item($LH), TRUE);
                $A3->appendChild($Dg);
                z1:
                $LH++;
                goto i5;
                hu:
                lQ:
                UL:
            }
            dL:
            KD:
        }
        TC:
    }
    private function addEncryptedAttributeStatement(DOMElement $pZ)
    {
        if (!($this->requiredEncAttributes == FALSE)) {
            goto BB;
        }
        return;
        BB:
        $PG = $pZ->ownerDocument;
        $zw = $PG->createElementNS("\x75\x72\x6e\x3a\x6f\141\163\151\163\x3a\x6e\x61\x6d\x65\163\72\164\143\x3a\x53\101\x4d\x4c\x3a\x32\56\x30\72\141\163\x73\x65\x72\x74\151\157\156", "\x73\141\155\154\72\101\164\164\x72\151\142\165\164\145\123\x74\x61\x74\145\155\x65\x6e\164");
        $pZ->appendChild($zw);
        foreach ($this->attributes as $XE => $rd) {
            $gj = new DOMDocument();
            $u9 = $gj->createElementNS("\165\162\156\x3a\157\x61\163\x69\x73\72\x6e\x61\x6d\145\163\72\x74\143\72\123\x41\x4d\x4c\x3a\62\x2e\x30\72\x61\x73\163\x65\x72\x74\151\x6f\x6e", "\163\141\x6d\154\72\x41\164\x74\162\x69\142\165\164\x65");
            $u9->setAttribute("\x4e\x61\155\145", $XE);
            $gj->appendChild($u9);
            if (!($this->nameFormat !== "\165\x72\156\x3a\157\141\x73\151\163\x3a\156\141\155\x65\x73\x3a\x74\143\72\123\x41\115\x4c\x3a\62\56\x30\x3a\141\164\164\x72\x6e\x61\155\x65\55\146\x6f\162\x6d\141\x74\72\x75\x6e\163\160\x65\x63\151\x66\x69\145\x64")) {
                goto Ai;
            }
            $u9->setAttribute("\116\x61\x6d\x65\106\x6f\162\x6d\x61\164", $this->nameFormat);
            Ai:
            foreach ($rd as $Ka) {
                if (is_string($Ka)) {
                    goto LZ;
                }
                if (is_int($Ka)) {
                    goto kl;
                }
                $u8 = NULL;
                goto IY;
                LZ:
                $u8 = "\x78\x73\x3a\163\x74\x72\151\156\147";
                goto IY;
                kl:
                $u8 = "\170\163\x3a\151\x6e\x74\x65\x67\145\162";
                IY:
                $A3 = $gj->createElementNS("\165\162\156\x3a\x6f\x61\163\x69\x73\x3a\x6e\141\x6d\145\163\x3a\164\143\x3a\123\101\x4d\114\72\62\56\60\72\x61\163\x73\x65\x72\164\x69\x6f\156", "\163\141\x6d\154\x3a\101\x74\164\x72\x69\142\x75\x74\145\126\x61\154\165\x65");
                $u9->appendChild($A3);
                if (!($u8 !== NULL)) {
                    goto g1;
                }
                $A3->setAttributeNS("\x68\164\164\160\x3a\x2f\x2f\167\x77\x77\56\167\63\56\x6f\x72\x67\57\62\60\60\x31\x2f\130\115\114\123\143\x68\x65\155\x61\55\x69\156\x73\x74\x61\x6e\x63\145", "\x78\163\x69\x3a\x74\171\160\x65", $u8);
                g1:
                if ($Ka instanceof DOMNodeList) {
                    goto r4;
                }
                $A3->appendChild($gj->createTextNode($Ka));
                goto n1;
                r4:
                $LH = 0;
                R7:
                if (!($LH < $Ka->length)) {
                    goto sP;
                }
                $Dg = $gj->importNode($Ka->item($LH), TRUE);
                $A3->appendChild($Dg);
                WZ:
                $LH++;
                goto R7;
                sP:
                n1:
                z9:
            }
            oI:
            $YY = new XMLSecEnc();
            $YY->setNode($gj->documentElement);
            $YY->type = "\x68\164\x74\x70\72\x2f\x2f\x77\x77\x77\x2e\x77\x33\x2e\157\x72\147\57\62\x30\60\x31\x2f\60\64\57\x78\155\154\x65\156\x63\x23\105\x6c\x65\x6d\145\x6e\164";
            $dV = new XMLSecurityKey(XMLSecurityKey::AES256_CBC);
            $dV->generateSessionKey();
            $YY->encryptKey($this->encryptionKey, $dV);
            $Qq = $YY->encryptNode($dV);
            $hz = $PG->createElementNS("\x75\162\156\72\x6f\x61\163\151\x73\x3a\x6e\141\x6d\145\x73\x3a\x74\143\x3a\x53\x41\115\114\x3a\62\56\x30\72\141\x73\x73\145\162\x74\151\x6f\x6e", "\x73\x61\155\154\x3a\105\x6e\143\162\x79\160\164\145\144\x41\x74\x74\162\x69\142\165\x74\x65");
            $zw->appendChild($hz);
            $if = $PG->importNode($Qq, TRUE);
            $hz->appendChild($if);
            F2:
        }
        Bj:
    }
}
