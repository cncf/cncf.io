<?php


include_once "\x78\155\154\x73\x65\143\154\x69\142\x73\56\160\x68\160";
use RobRichards\XMLSecLibs\XMLSecurityKey;
use RobRichards\XMLSecLibs\XMLSecurityDSig;
use RobRichards\XMLSecLibs\XMLSecEnc;
class SAMLSPUtilities
{
    public static function generateID()
    {
        return "\137" . self::stringToHex(self::generateRandomBytes(21));
    }
    public static function stringToHex($nn)
    {
        $YE = '';
        $oM = 0;
        YK:
        if (!($oM < strlen($nn))) {
            goto Vk;
        }
        $YE .= sprintf("\x25\60\62\x78", ord($nn[$oM]));
        Y1:
        $oM++;
        goto YK;
        Vk:
        return $YE;
    }
    public static function generateRandomBytes($G_, $ll = TRUE)
    {
        return openssl_random_pseudo_bytes($G_);
    }
    public static function createAuthnRequest($dZ, $DR, $yV, $eJ = "\x66\141\154\x73\x65", $jR = "\110\x74\x74\160\122\145\x64\151\162\145\143\x74", $oz = '')
    {
        $oz = "\x75\162\x6e\x3a\x6f\x61\x73\x69\x73\x3a\156\x61\155\145\x73\72\x74\143\x3a\x53\x41\115\114\72" . $oz;
        $VD = "\74\x3f\x78\155\154\40\166\145\162\x73\x69\x6f\x6e\75\42\61\x2e\x30\x22\40\x65\x6e\x63\157\144\x69\x6e\147\75\42\125\124\106\55\x38\x22\77\76" . "\74\163\141\x6d\154\x70\x3a\101\165\164\x68\156\122\145\161\165\x65\163\164\x20\x78\x6d\x6c\x6e\163\x3a\x73\141\155\x6c\160\75\x22\165\162\x6e\72\x6f\141\163\x69\x73\x3a\x6e\141\155\x65\x73\72\164\143\x3a\x53\101\115\x4c\x3a\62\56\60\72\160\x72\157\x74\157\143\157\x6c\x22\x20\170\155\154\156\x73\x3d\42\165\x72\156\72\157\x61\x73\151\x73\72\x6e\141\155\145\163\x3a\x74\x63\x3a\123\101\115\114\72\62\56\x30\72\141\x73\x73\145\x72\164\x69\157\156\x22\40\x49\104\x3d\x22" . self::generateID() . "\x22\x20\x56\145\x72\x73\x69\157\x6e\75\42\x32\x2e\60\42\x20\x49\163\163\x75\x65\111\156\163\164\141\x6e\164\x3d\42" . self::generateTimestamp() . "\x22";
        if (!($eJ == "\x74\162\165\145")) {
            goto Ie;
        }
        $VD .= "\40\x46\x6f\x72\143\x65\x41\165\164\150\156\75\x22\164\162\x75\x65\42";
        Ie:
        $VD .= "\40\x50\162\157\164\157\x63\157\154\102\x69\156\144\151\156\x67\x3d\42\x75\162\156\72\x6f\x61\x73\151\x73\72\x6e\141\155\x65\x73\x3a\164\x63\72\123\101\x4d\114\72\x32\56\x30\x3a\x62\x69\156\x64\151\x6e\147\x73\72\x48\x54\124\120\x2d\120\x4f\123\x54\42\40\101\163\x73\x65\162\164\151\157\x6e\103\157\x6e\163\x75\x6d\x65\x72\123\145\x72\166\151\143\x65\125\122\114\75\x22" . $dZ . "\42\40\104\x65\x73\164\x69\156\141\x74\151\157\x6e\x3d\42" . $yV . "\x22\76\74\163\141\x6d\x6c\x3a\x49\163\x73\x75\145\162\40\x78\155\154\156\x73\x3a\x73\x61\155\154\x3d\42\x75\162\156\72\157\x61\x73\151\163\x3a\156\141\x6d\x65\163\72\x74\143\72\123\x41\x4d\x4c\x3a\62\x2e\60\72\x61\163\x73\145\x72\x74\x69\x6f\x6e\42\76" . $DR . "\74\57\x73\141\x6d\154\72\x49\x73\163\165\145\x72\76\x3c\163\x61\x6d\154\x70\x3a\x4e\x61\155\x65\111\104\120\157\x6c\151\x63\x79\x20\101\x6c\154\157\167\103\x72\x65\x61\x74\145\75\x22\164\x72\x75\145\42\x20\106\x6f\x72\x6d\141\164\75\42" . $oz . "\42\12\x20\x20\40\x20\x20\x20\x20\x20\x20\40\40\40\x20\40\x20\x20\40\40\40\40\x20\x20\x20\40\x2f\x3e\x3c\x2f\163\141\x6d\x6c\x70\x3a\101\x75\x74\150\156\x52\x65\x71\165\145\x73\164\76";
        if (empty($jR) || $jR == "\110\164\164\160\x52\145\144\x69\162\145\x63\x74") {
            goto lZ;
        }
        $gT = gzdeflate($VD);
        $xc = base64_encode($gT);
        goto nZ;
        lZ:
        $gT = gzdeflate($VD);
        $xc = base64_encode($gT);
        $GF = urlencode($xc);
        $VD = $GF;
        nZ:
        update_option("\x4d\117\137\x53\101\115\x4c\137\x52\x45\x51\125\x45\123\124", $xc);
        return $VD;
    }
    public static function generateTimestamp($LC = NULL)
    {
        if (!($LC === NULL)) {
            goto qv;
        }
        $LC = time();
        qv:
        return gmdate("\x59\x2d\155\x2d\x64\x5c\x54\x48\72\151\72\x73\x5c\x5a", $LC);
    }
    public static function xpQuery(DOMNode $rf, $ye)
    {
        static $EV = NULL;
        if ($rf instanceof DOMDocument) {
            goto Hj;
        }
        $Yf = $rf->ownerDocument;
        goto Wr;
        Hj:
        $Yf = $rf;
        Wr:
        if (!($EV === NULL || !$EV->document->isSameNode($Yf))) {
            goto Ni;
        }
        $EV = new DOMXPath($Yf);
        $EV->registerNamespace("\x73\x6f\141\160\55\x65\x6e\166", "\x68\x74\164\160\x3a\57\57\163\143\x68\145\x6d\x61\163\x2e\x78\155\154\x73\x6f\x61\160\56\x6f\x72\147\57\x73\x6f\x61\x70\57\x65\x6e\166\x65\x6c\x6f\x70\145\57");
        $EV->registerNamespace("\163\x61\x6d\154\137\160\162\157\x74\157\x63\x6f\154", "\165\162\156\x3a\x6f\x61\163\151\163\72\x6e\x61\x6d\145\x73\x3a\x74\143\72\x53\x41\115\x4c\72\x32\x2e\x30\72\x70\162\x6f\164\157\x63\157\x6c");
        $EV->registerNamespace("\x73\x61\x6d\154\137\x61\163\163\x65\162\x74\x69\157\156", "\165\x72\x6e\x3a\x6f\141\x73\151\163\72\x6e\x61\x6d\145\x73\72\x74\x63\x3a\123\x41\115\x4c\x3a\62\56\60\72\141\163\163\145\x72\164\151\x6f\x6e");
        $EV->registerNamespace("\x73\141\155\154\137\x6d\145\x74\141\x64\141\x74\x61", "\165\x72\156\x3a\157\x61\x73\x69\163\72\x6e\x61\155\145\x73\72\164\143\72\123\x41\x4d\114\72\x32\56\60\72\x6d\x65\x74\x61\x64\141\x74\141");
        $EV->registerNamespace("\144\163", "\x68\164\x74\160\x3a\57\57\x77\167\167\56\x77\x33\x2e\157\x72\147\x2f\x32\60\x30\x30\x2f\x30\71\57\x78\155\154\144\x73\x69\147\43");
        $EV->registerNamespace("\170\x65\x6e\143", "\150\x74\164\160\x3a\x2f\x2f\167\x77\167\56\x77\63\x2e\157\162\x67\57\62\x30\60\61\x2f\x30\64\57\x78\155\154\x65\156\143\43");
        Ni:
        $lY = $EV->query($ye, $rf);
        $YE = array();
        $oM = 0;
        HJ:
        if (!($oM < $lY->length)) {
            goto w3;
        }
        $YE[$oM] = $lY->item($oM);
        WV:
        $oM++;
        goto HJ;
        w3:
        return $YE;
    }
    public static function parseNameId(DOMElement $pX)
    {
        $YE = array("\x56\x61\x6c\x75\x65" => trim($pX->textContent));
        foreach (array("\x4e\141\155\x65\121\165\x61\x6c\x69\x66\x69\x65\162", "\123\x50\x4e\141\x6d\x65\x51\x75\141\154\x69\146\x69\x65\162", "\x46\x6f\x72\155\x61\x74") as $aU) {
            if (!$pX->hasAttribute($aU)) {
                goto dH;
            }
            $YE[$aU] = $pX->getAttribute($aU);
            dH:
            Vo:
        }
        f6:
        return $YE;
    }
    public static function xsDateTimeToTimestamp($sq)
    {
        $rp = array();
        $sl = "\x2f\x5e\50\x5c\x64\134\x64\134\144\x5c\x64\x29\x2d\x28\134\144\x5c\x64\51\x2d\x28\134\x64\x5c\x64\x29\x54\50\x5c\x64\134\x64\x29\72\50\134\x64\x5c\x64\x29\x3a\50\x5c\144\134\x64\x29\50\x3f\x3a\x5c\x2e\x5c\144\53\x29\x3f\132\x24\57\x44";
        if (!(preg_match($sl, $sq, $rp) == 0)) {
            goto TS;
        }
        echo sprintf("\x6e\x76\141\154\151\144\x20\x53\x41\115\114\x32\x20\x74\151\155\145\x73\x74\x61\x6d\160\x20\160\141\163\163\145\144\x20\164\157\40\170\x73\104\141\x74\145\x54\x69\155\x65\x54\157\124\151\155\x65\x73\164\x61\x6d\160\72\x20" . $sq);
        die;
        TS:
        $Mk = intval($rp[1]);
        $XO = intval($rp[2]);
        $ns = intval($rp[3]);
        $bo = intval($rp[4]);
        $bT = intval($rp[5]);
        $eI = intval($rp[6]);
        $sI = gmmktime($bo, $bT, $eI, $XO, $ns, $Mk);
        return $sI;
    }
    public static function extractStrings(DOMElement $ME, $bn, $TF)
    {
        $YE = array();
        $rf = $ME->firstChild;
        DG:
        if (!($rf !== NULL)) {
            goto Lj;
        }
        if (!($rf->namespaceURI !== $bn || $rf->localName !== $TF)) {
            goto Go;
        }
        goto DS;
        Go:
        $YE[] = trim($rf->textContent);
        DS:
        $rf = $rf->nextSibling;
        goto DG;
        Lj:
        return $YE;
    }
    public static function validateElement(DOMElement $F4)
    {
        $wg = new XMLSecurityDSig();
        $wg->idKeys[] = "\x49\104";
        $EN = self::xpQuery($F4, "\x2e\x2f\x64\x73\x3a\123\x69\x67\156\141\164\x75\162\x65");
        if (count($EN) === 0) {
            goto g_;
        }
        if (count($EN) > 1) {
            goto W4;
        }
        goto fV;
        g_:
        return FALSE;
        goto fV;
        W4:
        echo sprintf("\x58\x4d\114\x53\145\x63\72\x20\x6d\157\162\145\x20\164\150\141\x6e\40\157\156\145\40\163\x69\x67\x6e\x61\x74\x75\162\145\x20\145\x6c\x65\x6d\x65\x6e\x74\40\x69\156\40\162\x6f\157\164\56");
        die;
        fV:
        $EN = $EN[0];
        $wg->sigNode = $EN;
        $wg->canonicalizeSignedInfo();
        if ($wg->validateReference()) {
            goto DK;
        }
        echo sprintf("\130\x4d\x4c\163\145\143\x3a\40\144\x69\147\x65\163\164\40\x76\141\154\x69\144\x61\x74\151\157\x6e\40\x66\x61\151\x6c\x65\x64");
        die;
        DK:
        $bi = FALSE;
        foreach ($wg->getValidatedNodes() as $Do) {
            if ($Do->isSameNode($F4)) {
                goto NP;
            }
            if ($F4->parentNode instanceof DOMDocument && $Do->isSameNode($F4->ownerDocument)) {
                goto xl;
            }
            goto Jw;
            NP:
            $bi = TRUE;
            goto Kj;
            goto Jw;
            xl:
            $bi = TRUE;
            goto Kj;
            Jw:
            bI:
        }
        Kj:
        if ($bi) {
            goto cB;
        }
        echo sprintf("\130\115\x4c\x53\145\143\x3a\40\124\x68\145\40\162\x6f\157\x74\40\x65\154\145\x6d\x65\x6e\x74\40\151\163\40\x6e\x6f\x74\x20\x73\151\147\156\x65\144\x2e");
        die;
        cB:
        $E7 = array();
        foreach (self::xpQuery($EN, "\x2e\x2f\144\x73\72\113\x65\x79\111\156\146\157\x2f\144\x73\x3a\130\65\x30\71\x44\x61\x74\x61\57\144\163\72\x58\65\60\x39\x43\145\x72\164\x69\146\151\x63\141\x74\x65") as $Un) {
            $Ej = trim($Un->textContent);
            $Ej = str_replace(array("\15", "\xa", "\x9", "\40"), '', $Ej);
            $E7[] = $Ej;
            cb:
        }
        HF:
        $YE = array("\123\151\x67\156\141\x74\x75\x72\145" => $wg, "\103\x65\162\x74\x69\x66\151\143\x61\164\145\163" => $E7);
        return $YE;
    }
    public static function validateSignature(array $pP, XMLSecurityKey $ld)
    {
        $wg = $pP["\123\151\x67\156\x61\164\x75\162\x65"];
        $ZO = self::xpQuery($wg->sigNode, "\56\57\144\163\x3a\x53\151\x67\156\x65\x64\x49\x6e\x66\157\x2f\x64\163\72\123\x69\x67\x6e\141\164\165\162\145\115\145\x74\x68\x6f\144");
        if (!empty($ZO)) {
            goto xo;
        }
        echo sprintf("\x4d\x69\x73\x73\x69\156\147\40\x53\151\147\x6e\x61\164\165\162\145\x4d\x65\x74\x68\157\144\40\x65\154\x65\155\x65\x6e\x74");
        die;
        xo:
        $ZO = $ZO[0];
        if ($ZO->hasAttribute("\101\x6c\x67\157\162\x69\x74\x68\155")) {
            goto P7;
        }
        echo sprintf("\115\x69\x73\x73\x69\156\147\40\x41\x6c\x67\157\162\x69\164\x68\155\55\141\164\164\x72\x69\x62\x75\164\145\x20\x6f\x6e\x20\123\151\147\156\x61\x74\165\162\x65\x4d\x65\x74\150\157\144\x20\145\x6c\145\155\145\x6e\x74\x2e");
        die;
        P7:
        $S8 = $ZO->getAttribute("\101\154\x67\157\x72\x69\164\150\x6d");
        if (!($ld->type === XMLSecurityKey::RSA_SHA1 && $S8 !== $ld->type)) {
            goto y3;
        }
        $ld = self::castKey($ld, $S8);
        y3:
        if ($wg->verify($ld)) {
            goto yV;
        }
        echo sprintf("\125\156\141\x62\154\145\40\164\x6f\40\166\141\x6c\151\x64\x61\164\145\40\x53\151\x67\156\141\164\x75\x72\x65");
        die;
        yV:
    }
    public static function castKey(XMLSecurityKey $ld, $RV, $fH = "\160\x75\142\x6c\x69\x63")
    {
        if (!($ld->type === $RV)) {
            goto b6;
        }
        return $ld;
        b6:
        $qf = openssl_pkey_get_details($ld->key);
        if (!($qf === FALSE)) {
            goto Rd;
        }
        echo sprintf("\125\x6e\141\142\154\x65\x20\164\x6f\x20\x67\x65\164\x20\153\145\x79\x20\144\x65\x74\141\x69\154\163\x20\x66\162\x6f\155\x20\x58\x4d\114\x53\145\x63\x75\162\x69\164\171\x4b\x65\171\56");
        die;
        Rd:
        if (isset($qf["\x6b\145\171"])) {
            goto Cs;
        }
        echo sprintf("\x4d\x69\163\x73\151\x6e\147\40\153\x65\x79\40\x69\156\40\x70\x75\x62\x6c\151\x63\x20\x6b\145\x79\x20\x64\145\x74\x61\x69\x6c\x73\56");
        die;
        Cs:
        $qk = new XMLSecurityKey($RV, array("\x74\x79\160\145" => $fH));
        $qk->loadKey($qf["\x6b\145\171"]);
        return $qk;
    }
    public static function processResponse($Aw, $uB, $Fu, SAML2SPResponse $CS, $nv, $VS)
    {
        $vL = current($CS->getAssertions());
        $UL = $vL->getNotBefore();
        if (!($UL !== NULL && $UL > time() + 60)) {
            goto ec;
        }
        wp_die("\x52\145\143\145\151\166\145\144\x20\141\x6e\x20\x61\x73\163\145\162\164\x69\x6f\x6e\x20\164\x68\x61\x74\x20\151\x73\40\166\x61\x6c\x69\144\x20\x69\x6e\x20\164\x68\145\40\146\x75\x74\x75\162\x65\x2e\x20\x43\150\145\143\153\40\143\154\x6f\143\153\40\163\x79\x6e\143\150\x72\x6f\x6e\x69\x7a\x61\x74\151\157\x6e\x20\x6f\156\x20\x49\144\x50\40\x61\156\144\x20\123\x50\56");
        ec:
        $LP = $vL->getNotOnOrAfter();
        if (!($LP !== NULL && $LP <= time() - 60)) {
            goto VU;
        }
        wp_die("\122\x65\143\145\151\166\x65\144\x20\141\x6e\40\x61\163\163\x65\x72\164\151\x6f\156\x20\164\x68\141\164\40\x68\x61\163\x20\145\170\160\x69\162\x65\x64\x2e\40\x43\150\x65\x63\x6b\40\143\x6c\157\143\x6b\x20\x73\171\156\143\x68\x72\157\x6e\151\172\141\x74\x69\157\x6e\40\157\x6e\40\x49\x64\x50\x20\x61\156\x64\x20\123\120\x2e");
        VU:
        $Ir = $vL->getSessionNotOnOrAfter();
        if (!($Ir !== NULL && $Ir <= time() - 60)) {
            goto CT;
        }
        wp_die("\x52\145\x63\x65\x69\166\x65\144\40\141\156\40\141\163\x73\145\162\x74\151\157\156\x20\167\151\x74\150\x20\141\x20\163\x65\x73\163\x69\157\x6e\40\164\150\x61\x74\40\x68\141\163\x20\145\x78\160\x69\x72\145\x64\56\x20\x43\150\x65\143\153\40\x63\x6c\x6f\143\x6b\40\163\171\x6e\x63\150\x72\x6f\156\151\172\141\164\x69\x6f\156\40\157\156\40\x49\x64\120\40\141\x6e\x64\x20\123\x50\x2e");
        CT:
        $G9 = $CS->getDestination();
        if (!(substr($G9, -1) == "\x2f")) {
            goto Tx;
        }
        $G9 = substr($G9, 0, -1);
        Tx:
        if (!(substr($Aw, -1) == "\57")) {
            goto gD;
        }
        $Aw = substr($Aw, 0, -1);
        gD:
        if (!($G9 !== NULL && $G9 !== $Aw)) {
            goto i6;
        }
        echo "\x44\145\163\x74\151\156\x61\x74\x69\157\x6e\x20\151\x6e\x20\162\145\163\x70\x6f\156\163\x65\x20\144\157\145\163\x6e\x27\164\40\x6d\141\x74\x63\x68\x20\x74\x68\145\x20\143\x75\x72\162\x65\x6e\x74\x20\x55\122\114\x2e\40\x44\145\x73\164\x69\x6e\x61\x74\x69\x6f\x6e\x20\151\163\40\42" . htmlspecialchars($G9) . "\42\54\x20\x63\165\x72\x72\x65\x6e\x74\40\125\122\114\40\x69\x73\40\x22" . htmlspecialchars($Aw) . "\x22\56";
        die;
        i6:
        $Qn = self::checkSign($uB, $Fu, $nv, $VS);
        return $Qn;
    }
    public static function checkSign($uB, $Fu, $nv, $VS)
    {
        $E7 = $Fu["\x43\x65\x72\164\151\x66\x69\x63\141\x74\145\x73"];
        if (count($E7) === 0) {
            goto Sw;
        }
        $ar = array();
        $ar[] = $uB;
        $aP = self::findCertificate($ar, $E7, $VS);
        if (!($aP == false)) {
            goto CW;
        }
        return false;
        CW:
        goto Je;
        Sw:
        $gM = maybe_unserialize(get_option("\163\141\155\154\x5f\x78\x35\x30\71\x5f\x63\145\x72\164\x69\x66\x69\143\141\164\x65"));
        $aP = $gM[$nv];
        Je:
        $cn = NULL;
        $ld = new XMLSecurityKey(XMLSecurityKey::RSA_SHA1, array("\164\171\160\145" => "\160\165\142\154\151\143"));
        $ld->loadKey($aP);
        try {
            self::validateSignature($Fu, $ld);
            return TRUE;
        } catch (Exception $A4) {
            $cn = $A4;
        }
        if ($cn !== NULL) {
            goto b8;
        }
        return FALSE;
        goto B8;
        b8:
        throw $cn;
        B8:
    }
    public static function validateIssuerAndAudience($j1, $Vu, $uY, $VS)
    {
        $DR = current($j1->getAssertions())->getIssuer();
        $vL = current($j1->getAssertions());
        $Vc = $vL->getValidAudiences();
        if (strcmp($uY, $DR) === 0) {
            goto Yj;
        }
        if ($VS == "\164\x65\163\164\126\141\x6c\151\x64\x61\x74\145") {
            goto qN;
        }
        wp_die("\127\x65\x20\x63\x6f\165\x6c\144\40\x6e\157\164\40\163\151\147\x6e\x20\171\157\165\40\151\x6e\56\40\120\154\x65\x61\163\145\x20\x63\157\x6e\164\x61\143\x74\40\171\157\165\162\x20\101\x64\x6d\x69\156\x69\x73\x74\x72\141\x74\157\162", "\105\162\162\157\x72\x20\72\111\163\x73\x75\145\x72\x20\x63\x61\x6e\x6e\157\x74\40\142\145\40\x76\x65\162\x69\146\x69\x65\144");
        goto aK;
        qN:
        $mz = mo_options_error_constants::Error_issuer_not_verfied;
        $Or = mo_options_error_constants::Cause_issuer_not_verfied;
        echo "\x3c\x64\151\166\40\163\x74\171\154\145\75\42\x66\x6f\x6e\164\55\146\141\x6d\x69\154\x79\x3a\x43\x61\154\x69\142\162\151\73\160\141\144\144\151\156\x67\x3a\x30\40\63\45\x3b\x22\x3e";
        echo "\x3c\x64\151\x76\x20\x73\164\x79\154\x65\75\42\x63\x6f\154\157\x72\x3a\x20\x23\x61\71\x34\x34\64\62\73\142\x61\143\153\x67\x72\x6f\x75\156\x64\55\x63\157\154\x6f\x72\x3a\40\x23\x66\62\144\x65\144\145\73\160\141\144\144\x69\156\x67\72\40\x31\x35\x70\x78\x3b\x6d\141\x72\147\151\156\55\x62\157\x74\x74\x6f\x6d\72\40\62\60\x70\x78\73\164\x65\x78\x74\x2d\x61\x6c\151\147\x6e\72\x63\x65\156\x74\x65\x72\x3b\x62\157\162\144\145\162\72\x31\x70\170\40\163\x6f\154\151\144\x20\43\x45\66\102\x33\102\x32\x3b\x66\x6f\x6e\x74\x2d\x73\x69\x7a\x65\72\61\x38\x70\164\x3b\42\x3e\40\x45\x52\x52\117\122\x3c\x2f\x64\x69\x76\x3e\12\x20\40\x20\40\x20\x20\x20\x20\40\x20\x20\x20\x20\40\40\x20\x3c\144\x69\x76\40\163\164\x79\x6c\145\x3d\x22\x63\x6f\x6c\157\162\x3a\x20\x23\141\71\64\64\x34\x32\73\x66\157\156\164\55\x73\x69\172\145\x3a\61\x34\x70\x74\73\40\x6d\141\x72\x67\151\156\55\x62\157\x74\164\157\x6d\72\62\x30\160\170\x3b\x74\x65\x78\x74\x2d\x61\x6c\151\147\x6e\x3a\40\x6a\x75\x73\x74\151\146\x79\x22\x3e\x3c\160\76\74\163\164\162\157\156\147\x3e\x45\x72\162\157\162\72" . $mz . "\x20\74\57\x73\x74\x72\x6f\x6e\x67\76\x3c\57\x70\x3e\xa\40\x20\x20\40\40\x20\x20\40\x20\40\40\x20\x20\40\x20\x20\xa\x20\40\40\x20\x20\40\40\40\40\40\x20\40\x20\x20\40\40\x3c\160\76\74\x73\x74\x72\157\x6e\147\76\x50\x6f\163\x73\x69\x62\154\x65\40\103\x61\x75\163\145\x3a" . $Or . "\40\x3c\57\x73\x74\x72\157\x6e\x67\76\74\x2f\x70\76\xa\40\x20\x20\x20\40\40\40\x20\40\40\x20\40\40\40\40\40\x3c\x70\76\x3c\x73\164\x72\157\x6e\x67\x3e\x45\x6e\x74\151\x74\171\40\111\x44\x20\151\x6e\x20\x53\x41\x4d\114\x20\x52\x65\x73\160\157\x6e\x73\145\x3a\40\74\x2f\x73\x74\x72\157\x6e\x67\x3e" . $DR . "\74\160\76\12\x20\40\x20\40\x20\x20\x20\40\40\x20\x20\40\x20\x20\40\40\x3c\x70\x3e\x3c\x73\164\x72\x6f\156\x67\x3e\x45\x6e\x74\x69\164\171\40\111\x44\x20\x43\x6f\x6e\x66\x69\x67\165\162\145\144\40\151\156\x20\164\x68\x65\x20\x70\x6c\165\x67\151\156\72\40\x3c\x2f\163\x74\x72\157\156\x67\76" . $uY . "\x3c\57\x70\x3e\12\x9\x9\x9\11\x3c\160\x3e\x3c\x73\x74\162\x6f\156\147\76\123\157\x6c\165\x74\151\x6f\156\x3a\74\x2f\163\164\x72\157\x6e\x67\76\74\57\160\x3e\xa\x9\11\x9\11\x3c\x6f\154\76\12\11\x9\11\11\11\x3c\x6c\151\76\103\x6f\x70\171\40\x74\150\x65\x20\x45\156\x74\151\164\171\40\111\104\x20\157\x66\40\123\x41\115\114\40\122\x65\163\160\x6f\x6e\163\145\40\x66\162\x6f\x6d\x20\141\x62\157\166\145\40\x61\156\x64\40\160\x61\163\164\145\x20\151\164\40\x69\x6e\40\105\156\164\151\x74\171\x20\x49\104\x20\157\x72\x20\x49\163\x73\165\x65\x72\40\146\151\145\x6c\x64\x20\x75\156\144\145\162\x20\x53\145\162\166\151\x63\145\40\x50\162\157\166\151\x64\x65\162\40\123\145\164\x75\160\40\164\x61\142\x2e\74\x2f\x6c\x69\x3e\12\x9\x9\x9\11\74\57\x6f\154\76\xa\11\x9\11\x9\74\x2f\144\151\166\x3e\xa\x20\x20\40\40\x20\40\40\40\40\40\40\40\x20\x20\x20\40\x3c\x2f\x64\151\166\76";
        mo_saml_download_logs($mz, $Or);
        die;
        aK:
        goto KX;
        Yj:
        if (empty($Vc)) {
            goto yp;
        }
        if (in_array($Vu, $Vc, TRUE)) {
            goto ut;
        }
        if ($VS == "\164\x65\163\164\126\141\154\x69\x64\x61\x74\x65") {
            goto G5;
        }
        wp_die("\127\x65\40\x63\x6f\165\x6c\x64\x20\x6e\x6f\x74\40\163\151\x67\x6e\40\x79\157\x75\40\151\x6e\x2e\40\120\154\x65\x61\x73\145\40\143\x6f\156\x74\x61\x63\164\40\x79\157\x75\x72\40\101\144\x6d\151\156\151\163\164\162\x61\x74\x6f\162", "\x45\162\162\x6f\x72\40\x3a\x49\x6e\166\141\154\151\144\x20\x41\165\144\x69\x65\x6e\143\145\x20\x55\x52\111");
        goto dk;
        G5:
        $mz = mo_options_error_constants::Error_invalid_audience;
        $Or = mo_options_error_constants::Cause_invalid_audience;
        echo "\74\144\x69\x76\x20\163\164\x79\x6c\x65\75\x22\146\x6f\156\x74\55\146\141\x6d\151\x6c\171\72\103\x61\x6c\x69\x62\x72\x69\x3b\x70\141\144\x64\151\x6e\x67\72\60\x20\x33\45\x3b\x22\76";
        echo "\74\144\x69\x76\x20\163\164\171\154\145\75\42\x63\157\x6c\x6f\x72\72\40\x23\x61\71\64\x34\x34\62\73\142\141\x63\x6b\147\x72\157\x75\x6e\x64\55\143\157\x6c\x6f\162\x3a\40\x23\146\x32\144\145\144\145\x3b\x70\x61\x64\144\x69\156\x67\72\x20\61\65\160\x78\73\155\x61\162\x67\x69\156\55\142\157\x74\x74\157\155\72\x20\x32\x30\160\170\x3b\x74\x65\170\x74\55\x61\x6c\151\x67\156\72\x63\145\156\x74\145\x72\73\142\157\162\144\x65\162\72\61\160\170\40\163\x6f\154\151\144\40\x23\x45\x36\102\x33\x42\x32\x3b\146\x6f\x6e\164\x2d\x73\151\172\145\72\x31\70\x70\164\73\42\x3e\40\105\122\x52\x4f\122\x3c\x2f\x64\x69\166\x3e\xa\40\40\40\x20\x20\x20\40\x20\x20\x20\40\40\40\40\40\40\x20\40\40\x20\74\x64\x69\166\x20\163\164\171\x6c\145\x3d\42\143\157\154\x6f\x72\x3a\40\x23\141\x39\x34\x34\x34\62\73\146\x6f\x6e\x74\55\163\x69\x7a\x65\x3a\x31\x34\160\164\73\40\x6d\x61\162\x67\x69\156\x2d\x62\157\164\x74\157\155\72\x32\60\x70\170\x3b\42\76\x3c\160\76\x3c\x73\x74\162\157\x6e\147\76\x45\x72\162\157\162\x3a\x20\x3c\x2f\163\164\162\157\156\x67\76" . $mz . "\x3c\57\x70\x3e\xa\40\40\40\40\40\x20\x20\x20\x20\40\40\x20\40\x20\x20\40\x20\40\x20\40\12\40\x20\x20\x20\x20\40\x20\x20\40\x20\x20\x20\40\x20\x20\x20\40\x20\40\40\x3c\x70\x3e\x3c\x73\164\x72\x6f\156\147\x3e\120\157\x73\163\151\x62\x6c\145\40\x43\x61\x75\163\x65\x3a\40\74\x2f\x73\164\x72\x6f\x6e\x67\x3e" . $Or . "\74\57\x70\76\xa\x20\x20\x20\x20\40\x20\40\x20\40\x20\x20\x20\40\x20\x20\x20\x20\x20\40\40\x3c\x70\76\x45\170\x70\145\x63\164\145\x64\x20\157\x6e\x65\40\x6f\146\x20\x74\150\145\x20\101\x75\x64\x69\x65\156\143\x65\x73\40\x74\157\40\142\x65\72\x20" . $Vu . "\74\x70\76\12\x9\x9\x9\11\11\x3c\160\x3e\74\163\x74\x72\157\156\147\x3e\123\x6f\x6c\165\x74\x69\x6f\x6e\x3a\x3c\57\163\164\x72\157\156\x67\x3e\x3c\57\x70\76\12\x9\x9\11\11\x9\74\157\x6c\76\xa\11\x9\x9\x9\x9\11\x3c\x6c\x69\76\103\x6f\160\x79\x20\x74\x68\145\40\x45\170\x70\x65\143\x74\145\x64\40\101\x75\144\x69\x65\x6e\x63\x65\40\125\122\x49\40\146\162\x6f\x6d\40\141\142\157\166\x65\40\x61\156\x64\40\x70\141\163\164\x65\40\151\x74\x20\151\156\40\164\x68\x65\x20\x41\x75\x64\x69\x65\x6e\143\x65\x20\x55\x52\x49\40\x66\151\145\154\x64\40\x61\164\x20\x49\144\145\x6e\164\x69\164\171\40\120\162\x6f\x76\151\144\x65\162\40\x73\x69\x64\x65\56\x3c\57\154\151\76\xa\x9\x9\x9\x9\x9\74\57\157\x6c\x3e\xa\x9\x9\11\x9\x9\74\57\x64\x69\x76\76";
        mo_saml_download_logs($mz, $Or);
        die;
        dk:
        goto nT;
        ut:
        return TRUE;
        nT:
        yp:
        KX:
    }
    private static function findCertificate(array $se, array $E7, $VS)
    {
        $Mr = array();
        foreach ($E7 as $wA) {
            $JQ = strtolower(sha1(base64_decode($wA)));
            if (in_array($JQ, $se, TRUE)) {
                goto rd;
            }
            $Mr[] = $JQ;
            return false;
            rd:
            $ox = "\55\x2d\x2d\x2d\x2d\x42\105\107\111\x4e\x20\x43\105\122\x54\x49\106\x49\x43\x41\x54\105\x2d\55\55\x2d\55\xa" . chunk_split($wA, 64) . "\55\55\55\x2d\x2d\105\116\x44\40\x43\x45\x52\124\x49\106\x49\x43\x41\x54\105\55\55\55\55\55\xa";
            return $ox;
            Ah:
        }
        zB:
        if ($VS == "\x74\x65\163\x74\126\141\x6c\x69\x64\141\x74\145") {
            goto hl;
        }
        wp_die("\x57\x65\40\x63\157\165\x6c\144\40\x6e\157\164\40\x73\151\x67\x6e\40\x79\x6f\x75\40\151\156\56\x20\120\x6c\145\x61\163\x65\40\143\x6f\x6e\x74\141\x63\x74\x20\x79\x6f\165\x72\x20\101\144\x6d\x69\156\151\x73\x74\x72\x61\164\157\162", "\105\162\162\x6f\x72\x20\72\103\145\x72\164\151\x66\x69\143\x61\164\x65\40\156\x6f\164\x20\146\157\x75\x6e\144");
        goto Sa;
        hl:
        $ox = "\55\x2d\55\x2d\55\102\105\107\x49\x4e\40\103\x45\x52\x54\x49\106\111\x43\x41\124\105\55\55\55\55\55\74\x62\x72\x3e" . chunk_split($wA, 64) . "\74\x62\x72\x3e\x2d\55\x2d\x2d\55\105\116\104\x20\x43\105\122\x54\x49\106\111\x43\101\x54\x45\55\55\55\55\55";
        echo "\x3c\144\x69\x76\x20\163\x74\x79\154\x65\75\x22\146\157\x6e\x74\55\x66\141\155\x69\x6c\x79\x3a\x43\x61\154\x69\x62\x72\151\x3b\160\141\x64\144\151\x6e\x67\72\60\x20\63\45\x3b\42\76";
        echo "\74\x64\x69\x76\40\x73\x74\x79\154\145\75\42\143\157\154\157\162\72\x20\x23\141\71\x34\64\64\x32\73\142\141\143\x6b\x67\162\157\x75\156\x64\55\x63\x6f\154\157\162\x3a\x20\43\146\62\x64\x65\144\x65\x3b\x70\x61\144\x64\x69\156\x67\72\x20\61\65\x70\x78\x3b\155\x61\162\x67\151\156\55\142\157\164\164\157\155\72\40\62\60\160\x78\x3b\x74\145\170\164\x2d\141\154\151\x67\x6e\72\143\x65\x6e\x74\x65\162\73\142\x6f\x72\144\x65\x72\x3a\61\x70\x78\40\x73\x6f\154\x69\x64\x20\43\105\x36\102\63\102\x32\x3b\x66\x6f\156\x74\55\163\x69\x7a\x65\72\61\x38\x70\164\x3b\42\76\x20\105\x52\122\x4f\x52\x3c\x2f\144\151\166\x3e\12\11\x9\x9\74\x64\151\x76\x20\x73\164\171\x6c\145\x3d\42\143\157\x6c\x6f\x72\x3a\x20\x23\141\71\64\64\x34\x32\73\146\157\x6e\x74\x2d\x73\x69\172\145\x3a\x31\x34\x70\164\x3b\40\155\x61\162\x67\151\156\55\142\157\x74\164\157\x6d\72\62\x30\160\x78\73\x22\x3e\x3c\160\76\x3c\x73\x74\162\157\x6e\x67\x3e\105\x72\162\x6f\x72\x3a\x20\74\57\x73\164\162\157\156\x67\76\125\x6e\x61\x62\x6c\145\x20\164\157\x20\146\151\156\144\40\x61\40\143\x65\x72\x74\x69\x66\x69\x63\x61\x74\x65\x20\x6d\x61\x74\143\x68\x69\156\147\x20\164\x68\145\x20\x63\157\156\146\x69\x67\x75\162\x65\144\x20\146\151\x6e\147\x65\x72\x70\x72\151\x6e\164\x2e\x3c\57\160\x3e\12\11\11\x9\x3c\x70\x3e\x50\x6c\145\x61\163\x65\40\x63\157\156\x74\141\x63\164\x20\171\157\165\162\x20\141\x64\155\x69\156\x69\x73\164\x72\x61\164\x6f\162\40\x61\156\x64\40\162\145\160\x6f\x72\x74\x20\164\150\x65\40\146\157\154\154\x6f\167\151\156\x67\40\x65\162\162\157\162\x3a\74\x2f\160\76\12\11\x9\x9\74\160\x3e\x3c\163\164\x72\157\156\147\76\120\x6f\x73\163\x69\142\154\145\40\103\x61\165\163\x65\72\40\x3c\x2f\x73\x74\x72\x6f\x6e\147\76\x27\x58\56\65\60\x39\x20\103\145\x72\x74\x69\x66\x69\x63\141\164\x65\x27\40\x66\151\x65\154\x64\x20\x69\156\x20\160\154\165\x67\151\x6e\x20\144\x6f\x65\x73\x20\156\157\164\x20\155\141\x74\143\150\x20\x74\x68\x65\40\143\145\162\164\151\x66\x69\143\x61\x74\145\40\146\x6f\x75\x6e\144\x20\x69\156\40\123\101\x4d\x4c\40\x52\145\x73\x70\157\156\x73\145\56\x3c\x2f\x70\x3e\xa\11\x9\x9\74\160\76\74\x73\x74\x72\157\156\x67\x3e\103\145\x72\164\x69\x66\x69\143\141\164\145\40\x66\x6f\165\156\x64\40\151\x6e\x20\x53\101\115\114\40\x52\145\x73\x70\157\x6e\163\x65\72\40\x3c\57\163\x74\x72\157\156\x67\76\74\142\162\x3e\x3c\142\162\x3e" . $ox . "\74\x2f\160\x3e\12\11\x9\x9\11\11\x3c\x2f\144\x69\166\x3e\12\11\x9\11\x9\11\x3c\x64\151\x76\40\163\x74\171\x6c\145\x3d\42\x6d\141\x72\147\x69\x6e\x3a\x33\45\x3b\x64\151\x73\x70\x6c\x61\171\72\x62\154\x6f\x63\x6b\x3b\164\x65\170\164\x2d\141\x6c\151\147\x6e\72\x63\x65\x6e\x74\145\x72\73\42\x3e\xa\xa\x9\11\x9\11\11\74\x64\x69\x76\x20\163\x74\171\x6c\x65\75\x22\155\x61\x72\x67\x69\156\72\x33\45\x3b\144\x69\163\x70\154\x61\171\72\x62\154\157\143\x6b\73\x74\x65\170\164\55\x61\154\151\147\x6e\x3a\x63\x65\156\x74\145\x72\x3b\42\76\x3c\x69\x6e\160\165\164\40\x73\164\x79\154\145\75\x22\x70\141\144\x64\151\x6e\147\72\x31\x25\73\167\x69\144\x74\x68\72\x31\x30\60\160\x78\73\142\x61\143\x6b\147\x72\x6f\x75\156\144\72\x20\x23\60\x30\71\61\x43\104\40\156\x6f\x6e\145\40\162\x65\160\145\141\164\40\163\x63\162\x6f\x6c\x6c\x20\x30\x25\40\x30\x25\73\x63\x75\x72\x73\x6f\162\x3a\40\160\x6f\151\156\164\x65\x72\73\146\x6f\x6e\x74\x2d\163\151\x7a\145\x3a\x31\65\x70\x78\x3b\x62\x6f\162\x64\x65\162\x2d\x77\x69\144\x74\150\72\40\61\160\x78\x3b\x62\157\162\x64\x65\x72\x2d\163\x74\171\x6c\145\x3a\40\163\157\x6c\x69\144\x3b\x62\157\x72\x64\x65\162\x2d\162\x61\144\151\165\x73\x3a\x20\63\x70\x78\x3b\167\x68\151\164\x65\x2d\163\160\141\143\145\72\40\x6e\x6f\167\162\x61\x70\x3b\x62\x6f\170\55\163\x69\x7a\151\x6e\147\x3a\x20\x62\157\162\x64\x65\162\55\x62\x6f\170\x3b\142\157\162\144\x65\162\x2d\143\x6f\154\157\162\x3a\x20\x23\x30\60\x37\x33\101\x41\x3b\142\157\x78\55\163\x68\141\x64\157\167\x3a\40\x30\x70\170\x20\x31\x70\170\x20\x30\x70\170\40\x72\x67\142\141\50\61\62\60\54\x20\x32\x30\x30\x2c\40\x32\63\60\54\x20\60\x2e\x36\x29\x20\x69\x6e\163\145\x74\x3b\143\x6f\154\x6f\x72\x3a\40\x23\106\106\106\x3b\42\x74\x79\160\145\75\x22\x62\165\x74\x74\157\156\42\40\x76\x61\x6c\165\145\75\42\x44\x6f\156\x65\x22\40\157\156\103\x6c\151\x63\x6b\75\x22\x73\145\x6c\146\56\143\154\x6f\x73\145\50\51\x3b\x22\76\74\x2f\144\x69\x76\76";
        die;
        Sa:
    }
    private static function doDecryptElement(DOMElement $oU, XMLSecurityKey $Z4, array &$hu)
    {
        $rg = new XMLSecEnc();
        $rg->setNode($oU);
        $rg->type = $oU->getAttribute("\124\171\160\x65");
        $fP = $rg->locateKey($oU);
        if ($fP) {
            goto kk;
        }
        echo sprintf("\103\x6f\x75\x6c\x64\40\x6e\x6f\x74\x20\x6c\157\143\141\x74\145\x20\x6b\x65\171\40\141\154\x67\x6f\x72\151\164\150\x6d\x20\x69\x6e\40\145\x6e\x63\x72\x79\160\164\x65\144\40\x64\141\164\x61\56");
        die;
        kk:
        $eF = $rg->locateKeyInfo($fP);
        if ($eF) {
            goto PT;
        }
        echo sprintf("\x43\x6f\165\154\x64\x20\156\157\x74\40\154\157\x63\x61\x74\x65\x20\74\144\163\151\147\x3a\113\145\x79\x49\x6e\146\157\x3e\40\146\x6f\162\40\164\150\x65\40\x65\156\143\x72\171\160\164\145\144\x20\153\x65\171\56");
        die;
        PT:
        $Wt = $Z4->getAlgorith();
        if ($eF->isEncrypted) {
            goto In;
        }
        $Ry = $fP->getAlgorith();
        if (!($Wt !== $Ry)) {
            goto IK;
        }
        echo sprintf("\101\154\x67\157\162\151\x74\150\x6d\x20\x6d\x69\x73\155\x61\x74\143\150\x20\142\x65\164\x77\145\x65\156\40\x69\x6e\x70\165\x74\x20\x6b\145\x79\x20\141\156\x64\40\153\145\171\x20\151\x6e\x20\x6d\x65\x73\163\x61\x67\145\56\40" . "\x4b\145\171\40\167\141\x73\72\x20" . var_export($Wt, TRUE) . "\x3b\x20\x6d\x65\163\163\x61\x67\x65\x20\167\141\x73\72\40" . var_export($Ry, TRUE));
        die;
        IK:
        $fP = $Z4;
        goto iK;
        In:
        $b1 = $eF->getAlgorith();
        if (!in_array($b1, $hu, TRUE)) {
            goto OO;
        }
        echo sprintf("\101\154\x67\157\162\x69\164\x68\x6d\40\x64\151\x73\x61\142\154\x65\x64\x3a\40" . var_export($b1, TRUE));
        die;
        OO:
        if (!($b1 === XMLSecurityKey::RSA_OAEP_MGF1P && $Wt === XMLSecurityKey::RSA_1_5)) {
            goto JQ;
        }
        $Wt = XMLSecurityKey::RSA_OAEP_MGF1P;
        JQ:
        if (!($Wt !== $b1)) {
            goto sj;
        }
        echo sprintf("\x41\154\147\157\162\151\x74\x68\155\40\x6d\x69\x73\155\x61\164\x63\x68\40\142\x65\x74\167\x65\x65\x6e\40\151\x6e\x70\165\164\40\x6b\x65\x79\x20\141\156\x64\x20\153\x65\171\40\165\163\x65\144\40\164\x6f\x20\145\x6e\x63\x72\x79\x70\x74\40" . "\40\164\150\145\40\x73\x79\x6d\155\x65\x74\162\x69\143\40\153\145\x79\x20\x66\x6f\162\x20\164\x68\x65\x20\x6d\x65\x73\x73\x61\x67\x65\x2e\x20\x4b\x65\x79\40\167\141\163\x3a\40" . var_export($Wt, TRUE) . "\x3b\40\x6d\145\163\x73\141\x67\145\x20\x77\141\x73\x3a\x20" . var_export($b1, TRUE));
        die;
        sj:
        $Wb = $eF->encryptedCtx;
        $eF->key = $Z4->key;
        $Gl = $fP->getSymmetricKeySize();
        if (!($Gl === NULL)) {
            goto hC;
        }
        echo sprintf("\125\x6e\153\x6e\x6f\x77\x6e\40\153\145\171\40\x73\x69\172\145\x20\x66\x6f\x72\x20\x65\156\x63\162\x79\x70\164\151\x6f\x6e\40\141\154\147\x6f\x72\151\x74\150\155\x3a\x20" . var_export($fP->type, TRUE));
        die;
        hC:
        try {
            $ld = $Wb->decryptKey($eF);
            if (!(strlen($ld) != $Gl)) {
                goto P_;
            }
            echo sprintf("\125\156\145\x78\160\145\x63\164\x65\144\x20\153\x65\171\x20\163\x69\x7a\145\40\50" . strlen($ld) * 8 . "\142\151\x74\163\x29\40\x66\157\x72\x20\145\x6e\x63\x72\171\x70\164\151\157\x6e\x20\x61\154\x67\x6f\162\151\x74\x68\x6d\x3a\40" . var_export($fP->type, TRUE));
            die;
            P_:
        } catch (Exception $A4) {
            $fV = $Wb->getCipherValue();
            $f_ = openssl_pkey_get_details($eF->key);
            $f_ = sha1(serialize($f_), TRUE);
            $ld = sha1($fV . $f_, TRUE);
            if (strlen($ld) > $Gl) {
                goto ri;
            }
            if (strlen($ld) < $Gl) {
                goto T8;
            }
            goto HQ;
            ri:
            $ld = substr($ld, 0, $Gl);
            goto HQ;
            T8:
            $ld = str_pad($ld, $Gl);
            HQ:
        }
        $fP->loadkey($ld);
        iK:
        $RV = $fP->getAlgorith();
        if (!in_array($RV, $hu, TRUE)) {
            goto o_;
        }
        echo sprintf("\101\154\147\157\162\151\x74\150\155\x20\144\x69\x73\141\142\154\145\x64\x3a\x20" . var_export($RV, TRUE));
        die;
        o_:
        $iX = $rg->decryptNode($fP, FALSE);
        $pX = "\74\162\157\x6f\164\x20\x78\x6d\154\x6e\163\x3a\x73\x61\155\x6c\x3d\x22\165\x72\x6e\72\157\x61\163\x69\163\72\156\141\x6d\x65\163\72\164\143\x3a\123\101\115\x4c\x3a\62\56\60\x3a\x61\x73\163\145\162\164\151\x6f\x6e\x22\x20" . "\170\155\x6c\x6e\163\x3a\x78\163\x69\75\x22\x68\x74\x74\x70\72\57\57\167\167\167\56\x77\63\x2e\x6f\x72\147\x2f\x32\60\x30\x31\x2f\130\115\x4c\123\143\x68\x65\155\x61\55\151\156\x73\164\x61\x6e\143\145\x22\76" . $iX . "\74\57\162\x6f\x6f\x74\76";
        $h0 = new DOMDocument();
        if (@$h0->loadXML($pX)) {
            goto jI;
        }
        echo sprintf("\x46\x61\x69\154\145\x64\40\164\157\x20\x70\141\162\163\x65\40\x64\145\x63\x72\x79\160\x74\145\144\x20\130\x4d\x4c\56\40\115\141\171\x62\x65\40\x74\x68\x65\40\167\x72\157\156\x67\40\163\150\x61\x72\145\144\153\x65\x79\40\167\x61\163\x20\x75\x73\x65\144\77");
        throw new Exception("\106\141\151\154\x65\x64\x20\164\157\40\160\x61\162\163\145\x20\144\x65\x63\162\x79\160\x74\x65\144\x20\x58\x4d\114\56\x20\x4d\141\171\142\x65\40\x74\x68\145\x20\x77\162\x6f\156\x67\40\x73\x68\141\162\x65\x64\153\x65\x79\40\167\x61\163\40\165\163\145\x64\77");
        jI:
        $GV = $h0->firstChild->firstChild;
        if (!($GV === NULL)) {
            goto wL;
        }
        echo sprintf("\115\151\x73\163\151\x6e\x67\x20\145\156\x63\162\x79\160\164\145\x64\40\x65\x6c\145\155\145\156\x74\x2e");
        throw new Exception("\x4d\x69\163\163\151\156\147\40\145\156\x63\x72\171\x70\x74\145\144\40\145\x6c\x65\x6d\x65\x6e\164\x2e");
        wL:
        if ($GV instanceof DOMElement) {
            goto ts;
        }
        echo sprintf("\104\x65\x63\x72\x79\x70\164\x65\144\x20\x65\154\145\155\x65\x6e\164\40\167\141\x73\40\156\x6f\x74\x20\141\143\x74\x75\141\x6c\154\171\40\141\x20\x44\117\115\105\x6c\145\155\x65\x6e\x74\56");
        ts:
        return $GV;
    }
    public static function decryptElement(DOMElement $oU, XMLSecurityKey $Z4, array $hu = array(), XMLSecurityKey $FL = NULL)
    {
        try {
            return self::doDecryptElement($oU, $Z4, $hu);
        } catch (Exception $A4) {
            try {
                return self::doDecryptElement($oU, $FL, $hu);
            } catch (Exception $vE) {
            }
            echo sprintf("\x46\141\151\154\x65\144\x20\x74\x6f\40\x64\145\x63\x72\171\160\x74\40\130\x4d\x4c\40\x65\154\x65\155\x65\156\x74\x2e");
            die;
        }
    }
    public static function getEncryptionAlgorithm($R2)
    {
        switch ($R2) {
            case "\150\164\x74\160\x3a\57\57\167\x77\167\x2e\x77\x33\56\157\162\x67\57\62\x30\60\x31\57\60\64\57\170\155\154\x65\156\x63\43\x74\162\151\160\154\x65\144\x65\163\55\x63\x62\x63":
                return XMLSecurityKey::TRIPLEDES_CBC;
                goto wJ;
            case "\x68\164\x74\x70\x3a\57\x2f\x77\167\167\x2e\167\x33\56\x6f\x72\147\x2f\62\x30\60\61\x2f\x30\64\x2f\x78\155\x6c\145\156\143\43\x61\145\163\61\x32\x38\x2d\143\142\143":
                return XMLSecurityKey::AES128_CBC;
            case "\150\164\x74\x70\x3a\57\57\167\167\167\x2e\167\63\x2e\157\162\147\x2f\62\x30\60\x31\57\x30\x34\57\170\x6d\x6c\145\156\x63\43\x61\145\x73\x31\x39\62\55\143\x62\x63":
                return XMLSecurityKey::AES192_CBC;
                goto wJ;
            case "\150\x74\x74\160\72\x2f\57\x77\167\x77\56\x77\x33\x2e\x6f\162\147\x2f\62\60\x30\61\x2f\60\x34\x2f\x78\155\x6c\x65\x6e\143\x23\x61\145\163\62\65\x36\x2d\143\x62\x63":
                return XMLSecurityKey::AES256_CBC;
                goto wJ;
            case "\150\x74\164\160\x3a\57\57\x77\167\167\56\x77\x33\56\157\162\147\x2f\x32\x30\x30\x31\x2f\x30\x34\x2f\x78\155\x6c\x65\x6e\x63\43\162\x73\x61\x2d\61\137\x35":
                return XMLSecurityKey::RSA_1_5;
                goto wJ;
            case "\150\164\x74\160\x3a\x2f\57\x77\167\x77\x2e\x77\x33\x2e\x6f\x72\147\x2f\x32\60\60\61\x2f\60\64\x2f\x78\155\x6c\x65\156\x63\43\162\x73\x61\x2d\x6f\141\x65\160\x2d\x6d\147\146\x31\160":
                return XMLSecurityKey::RSA_OAEP_MGF1P;
                goto wJ;
            case "\150\164\164\x70\x3a\x2f\57\167\167\167\x2e\x77\63\56\157\162\x67\x2f\62\60\x30\60\57\x30\71\57\x78\155\154\144\163\x69\x67\x23\144\163\141\55\163\150\141\x31":
                return XMLSecurityKey::DSA_SHA1;
                goto wJ;
            case "\150\x74\x74\160\72\57\x2f\x77\x77\167\56\x77\x33\x2e\x6f\162\147\x2f\x32\x30\x30\60\x2f\60\x39\57\170\155\x6c\x64\x73\151\x67\x23\x72\163\141\55\163\150\141\61":
                return XMLSecurityKey::RSA_SHA1;
                goto wJ;
            case "\150\164\x74\x70\x3a\57\x2f\x77\167\x77\56\x77\63\x2e\157\162\x67\57\x32\x30\x30\x31\x2f\x30\64\57\170\155\x6c\144\x73\151\147\x2d\155\157\162\145\x23\162\x73\141\55\163\x68\141\x32\x35\x36":
                return XMLSecurityKey::RSA_SHA256;
                goto wJ;
            case "\150\164\x74\160\x3a\57\57\x77\x77\167\56\x77\63\x2e\x6f\x72\147\57\x32\x30\60\61\57\60\x34\57\170\155\x6c\144\163\x69\147\x2d\155\157\162\145\x23\162\x73\x61\55\x73\x68\x61\63\70\64":
                return XMLSecurityKey::RSA_SHA384;
                goto wJ;
            case "\x68\164\164\x70\x3a\57\x2f\167\167\167\x2e\167\63\56\x6f\x72\147\57\62\x30\x30\x31\x2f\60\64\x2f\170\x6d\154\144\163\x69\147\55\155\x6f\x72\x65\43\x72\163\x61\55\163\x68\x61\65\x31\62":
                return XMLSecurityKey::RSA_SHA512;
                goto wJ;
            default:
                echo sprintf("\111\156\x76\x61\x6c\151\144\40\105\156\x63\162\171\x70\164\151\x6f\x6e\40\115\145\x74\150\157\144\x3a\40" . $R2);
                die;
                goto wJ;
        }
        ds:
        wJ:
    }
    public static function insertSignature(XMLSecurityKey $ld, array $E7, DOMElement $F4, DOMNode $cd = NULL)
    {
        $wg = new XMLSecurityDSig();
        $wg->setCanonicalMethod(XMLSecurityDSig::EXC_C14N);
        switch ($ld->type) {
            case XMLSecurityKey::RSA_SHA256:
                $fH = XMLSecurityDSig::SHA256;
                goto KP;
            case XMLSecurityKey::RSA_SHA384:
                $fH = XMLSecurityDSig::SHA384;
                goto KP;
            case XMLSecurityKey::RSA_SHA512:
                $fH = XMLSecurityDSig::SHA512;
                goto KP;
            default:
                $fH = XMLSecurityDSig::SHA1;
        }
        Ya:
        KP:
        $wg->addReferenceList(array($F4), $fH, array("\150\x74\164\x70\72\57\57\x77\167\x77\x2e\167\63\56\157\162\x67\x2f\x32\60\x30\x30\x2f\x30\x39\57\x78\x6d\x6c\144\x73\x69\x67\x23\145\156\166\x65\x6c\157\160\x65\144\55\x73\151\x67\x6e\x61\164\165\162\145", XMLSecurityDSig::EXC_C14N), array("\x69\144\x5f\156\141\x6d\x65" => "\111\x44", "\157\166\145\162\167\x72\x69\164\x65" => FALSE));
        $wg->sign($ld);
        foreach ($E7 as $Sy) {
            $wg->add509Cert($Sy, TRUE);
            SL:
        }
        Wi:
        $wg->insertSignature($F4, $cd);
    }
    public static function signXML($pX, $p2, $X3, $Rw = '')
    {
        $hO = array("\164\171\160\x65" => "\160\x72\x69\x76\141\x74\145");
        $ld = new XMLSecurityKey(XMLSecurityKey::RSA_SHA256, $hO);
        $ld->loadKey($X3, TRUE);
        $NY = file_get_contents($p2);
        $BE = new DOMDocument();
        $BE->loadXML($pX);
        $z2 = $BE->firstChild;
        if (!empty($Rw)) {
            goto xZ;
        }
        self::insertSignature($ld, array($NY), $z2);
        goto wI;
        xZ:
        $JT = $BE->getElementsByTagName($Rw)->item(0);
        self::insertSignature($ld, array($NY), $z2, $JT);
        wI:
        $Pm = $z2->ownerDocument->saveXML($z2);
        $VR = base64_encode($Pm);
        return $VR;
    }
    public static function postSAMLRequest($px, $G4, $VS)
    {
        echo "\74\150\x74\155\x6c\76\x3c\150\x65\141\144\x3e\74\x73\143\162\151\x70\164\x20\x73\162\143\75\47\x68\164\x74\x70\x73\72\57\57\x63\157\144\145\x2e\152\161\165\145\162\171\56\143\x6f\x6d\57\152\x71\x75\145\162\171\x2d\x31\56\61\61\56\x33\x2e\155\x69\156\x2e\152\x73\x27\76\74\57\163\x63\162\x69\160\164\76\x3c\x73\x63\x72\x69\160\x74\40\x74\171\x70\x65\75\42\164\145\170\x74\57\x6a\x61\166\x61\x73\x63\x72\151\160\x74\x22\76\44\x28\x66\165\156\x63\x74\x69\x6f\156\x28\51\x7b\x64\157\x63\165\155\x65\x6e\164\x2e\146\157\162\x6d\163\133\47\x73\x61\x6d\154\x2d\x72\x65\161\x75\x65\x73\164\55\x66\x6f\x72\x6d\47\135\56\x73\165\x62\155\x69\x74\x28\x29\x3b\x7d\x29\x3b\x3c\57\x73\143\162\151\160\x74\76\74\x2f\150\145\141\144\x3e\74\142\157\144\x79\x3e\120\x6c\x65\x61\x73\145\40\167\141\151\x74\56\x2e\56\74\146\157\162\155\40\x61\143\x74\151\157\156\x3d\x22" . $px . "\42\40\155\145\x74\x68\x6f\144\x3d\x22\160\157\x73\x74\x22\x20\151\x64\x3d\x22\x73\141\x6d\154\55\x72\145\161\x75\145\163\164\x2d\146\157\x72\x6d\42\76\74\x69\x6e\160\165\164\x20\164\171\x70\145\x3d\42\150\x69\144\144\x65\156\x22\x20\156\x61\155\145\x3d\42\x53\x41\x4d\x4c\122\145\161\x75\x65\x73\x74\42\40\166\141\x6c\165\145\x3d\42" . $G4 . "\42\40\x2f\76\74\x69\156\x70\165\x74\x20\x74\x79\x70\x65\75\x22\x68\151\x64\144\x65\x6e\42\x20\156\141\155\145\x3d\x22\x52\x65\154\x61\x79\x53\164\x61\164\x65\x22\x20\x76\x61\154\165\145\x3d\x22" . htmlentities($VS) . "\42\40\x2f\x3e\x3c\x2f\x66\x6f\162\155\x3e\74\57\142\x6f\144\171\x3e\74\x2f\150\164\x6d\x6c\76";
        die;
    }
    public static function postSAMLResponse($px, $yQ, $VS)
    {
        echo "\74\150\164\155\154\x3e\x3c\x68\x65\141\144\76\x3c\163\143\162\151\160\164\40\x73\x72\x63\75\x27\150\x74\164\x70\x73\72\57\57\143\157\x64\x65\56\152\161\165\145\x72\x79\56\143\157\x6d\57\152\161\165\145\162\171\55\61\56\61\61\56\x33\56\155\x69\156\x2e\152\163\47\76\74\57\x73\143\162\x69\160\164\76\x3c\163\x63\x72\x69\160\164\40\x74\x79\160\145\x3d\42\164\x65\x78\x74\57\x6a\x61\166\x61\x73\x63\x72\151\160\x74\x22\76\44\x28\x66\x75\x6e\x63\x74\151\157\156\50\x29\x7b\x64\157\143\165\x6d\145\x6e\164\x2e\x66\157\x72\x6d\x73\x5b\x27\x73\x61\x6d\154\55\162\145\x71\x75\x65\x73\164\x2d\x66\x6f\162\x6d\47\x5d\56\163\x75\x62\x6d\151\x74\x28\51\x3b\x7d\51\73\x3c\57\163\x63\162\x69\160\164\x3e\x3c\57\150\145\141\x64\76\x3c\142\157\x64\x79\x3e\x50\x6c\x65\141\x73\145\x20\167\141\x69\x74\x2e\x2e\x2e\74\x66\x6f\162\155\40\141\143\164\151\x6f\156\75\42" . $px . "\42\40\x6d\x65\x74\x68\x6f\144\x3d\42\160\157\x73\164\42\x20\x69\144\x3d\42\163\x61\x6d\x6c\x2d\162\x65\161\x75\x65\x73\164\x2d\146\157\162\x6d\x22\76\74\151\x6e\x70\x75\x74\x20\164\171\160\145\x3d\42\x68\151\x64\x64\x65\156\x22\x20\156\141\155\x65\x3d\x22\x53\x41\x4d\114\122\145\x73\160\157\x6e\x73\145\42\x20\x76\141\x6c\165\x65\x3d\x22" . $yQ . "\42\x20\57\76\x3c\151\x6e\x70\x75\x74\40\x74\171\x70\145\x3d\x22\150\151\144\x64\145\156\x22\x20\156\x61\155\145\x3d\x22\122\x65\154\141\171\x53\164\141\x74\145\x22\40\x76\141\154\x75\x65\x3d\x22" . htmlentities($VS) . "\42\x20\57\x3e\x3c\57\146\x6f\x72\x6d\x3e\74\x2f\x62\157\x64\171\x3e\74\57\150\164\x6d\x6c\x3e";
        die;
    }
    public static function sanitize_certificate($Sy)
    {
        $Sy = trim($Sy);
        $Sy = preg_replace("\57\133\15\12\x5d\x2b\57", '', $Sy);
        $Sy = str_replace("\x2d", '', $Sy);
        $Sy = str_replace("\102\x45\107\111\x4e\x20\103\105\122\x54\111\x46\x49\x43\x41\124\x45", '', $Sy);
        $Sy = str_replace("\105\x4e\x44\x20\103\x45\x52\x54\111\x46\111\103\x41\124\x45", '', $Sy);
        $Sy = str_replace("\x20", '', $Sy);
        $Sy = chunk_split($Sy, 64, "\xd\xa");
        $Sy = "\55\55\55\x2d\x2d\x42\x45\107\x49\116\x20\x43\x45\x52\x54\111\106\111\103\101\x54\105\55\x2d\x2d\x2d\55\15\xa" . $Sy . "\55\55\x2d\55\55\x45\x4e\x44\x20\x43\105\x52\124\111\106\111\103\101\x54\105\x2d\x2d\55\55\x2d";
        return $Sy;
    }
    public static function desanitize_certificate($Sy)
    {
        $Sy = preg_replace("\57\x5b\15\12\135\x2b\x2f", '', $Sy);
        $Sy = str_replace("\55\x2d\x2d\55\x2d\102\105\x47\111\x4e\x20\103\x45\x52\124\x49\106\111\x43\x41\124\105\x2d\55\x2d\55\55", '', $Sy);
        $Sy = str_replace("\x2d\x2d\55\x2d\x2d\x45\x4e\x44\40\103\x45\x52\124\x49\106\x49\103\101\x54\105\55\55\x2d\x2d\x2d", '', $Sy);
        $Sy = str_replace("\40", '', $Sy);
        return $Sy;
    }
    public static function mo_saml_wp_remote_call($px, $vP = array(), $q9 = false)
    {
        if (!$q9) {
            goto ny;
        }
        $CS = wp_remote_get($px, $vP);
        goto Pb;
        ny:
        $CS = wp_remote_post($px, $vP);
        Pb:
        if (!is_wp_error($CS)) {
            goto EP;
        }
        $Sm = new saml_mo_login();
        update_option("\155\157\x5f\x73\x61\x6d\154\x5f\155\145\163\163\141\147\145", "\x55\x6e\x61\142\x6c\145\40\x74\x6f\x20\x63\x6f\156\x6e\145\x63\164\40\x74\157\40\x74\x68\x65\40\x49\156\x74\x65\x72\x6e\145\x74\x2e\40\x50\154\145\x61\x73\145\40\164\x72\x79\x20\141\147\x61\x69\x6e\x2e");
        $Sm->mo_saml_show_error_message();
        return false;
        goto x8;
        EP:
        return $CS["\x62\157\144\171"];
        x8:
    }
}
?>
