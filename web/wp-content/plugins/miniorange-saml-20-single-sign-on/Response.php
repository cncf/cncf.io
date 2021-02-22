<?php


include "\x41\163\x73\145\x72\164\151\157\156\x2e\x70\150\x70";
class SAML2SPResponse
{
    private $assertions;
    private $destination;
    private $certificates;
    private $signatureData;
    public function __construct(DOMElement $Cr = NULL, $QE)
    {
        $this->assertions = array();
        $this->certificates = array();
        if (!($Cr === NULL)) {
            goto ol;
        }
        return;
        ol:
        $DD = SAMLSPUtilities::validateElement($Cr);
        if (!($DD !== FALSE)) {
            goto Dx;
        }
        $this->certificates = $DD["\103\x65\162\x74\151\x66\151\143\x61\x74\145\163"];
        $this->signatureData = $DD;
        Dx:
        if (!$Cr->hasAttribute("\104\x65\163\164\151\x6e\x61\x74\151\157\x6e")) {
            goto aT;
        }
        $this->destination = $Cr->getAttribute("\x44\145\163\164\151\x6e\x61\x74\x69\157\156");
        aT:
        $Dg = $Cr->firstChild;
        Uz:
        if (!($Dg !== NULL)) {
            goto Qk;
        }
        if (!($Dg->namespaceURI !== "\x75\x72\156\x3a\x6f\141\163\x69\x73\72\156\x61\x6d\145\x73\72\164\x63\72\123\x41\115\x4c\x3a\x32\x2e\x30\72\141\163\163\x65\162\164\x69\157\156")) {
            goto fv;
        }
        goto Pf;
        fv:
        if (!($Dg->localName === "\x41\x73\163\x65\162\164\x69\157\x6e" || $Dg->localName === "\105\x6e\x63\162\x79\x70\x74\x65\x64\101\163\163\x65\x72\x74\151\x6f\x6e")) {
            goto Rb;
        }
        $this->assertions[] = new SAML2SPAssertion($Dg, $QE);
        Rb:
        Pf:
        $Dg = $Dg->nextSibling;
        goto Uz;
        Qk:
    }
    public function getAssertions()
    {
        return $this->assertions;
    }
    public function setAssertions(array $f2)
    {
        $this->assertions = $f2;
    }
    public function getDestination()
    {
        return $this->destination;
    }
    public function getCertificates()
    {
        return $this->certificates;
    }
    public function getSignatureData()
    {
        return $this->signatureData;
    }
}
