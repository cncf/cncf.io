<?php


include "\x41\163\163\x65\162\164\x69\157\x6e\x2e\160\150\160";
class SAML2SPResponse
{
    private $assertions;
    private $destination;
    private $certificates;
    private $signatureData;
    public function __construct(DOMElement $pX = NULL)
    {
        $this->assertions = array();
        $this->certificates = array();
        if (!($pX === NULL)) {
            goto p2;
        }
        return;
        p2:
        $yL = SAMLSPUtilities::validateElement($pX);
        if (!($yL !== FALSE)) {
            goto zq;
        }
        $this->certificates = $yL["\103\145\x72\164\151\146\x69\143\x61\x74\145\x73"];
        $this->signatureData = $yL;
        zq:
        if (!$pX->hasAttribute("\104\x65\163\x74\x69\156\141\x74\x69\x6f\156")) {
            goto cK;
        }
        $this->destination = $pX->getAttribute("\x44\145\x73\164\151\x6e\141\164\x69\x6f\156");
        cK:
        $rf = $pX->firstChild;
        Oe:
        if (!($rf !== NULL)) {
            goto Co;
        }
        if (!($rf->namespaceURI !== "\165\162\156\x3a\157\141\x73\x69\x73\72\156\x61\x6d\x65\163\x3a\x74\143\72\x53\101\x4d\114\x3a\x32\x2e\60\x3a\141\163\163\145\x72\164\x69\157\x6e")) {
            goto CB;
        }
        goto in;
        CB:
        if (!($rf->localName === "\x41\x73\163\145\162\164\x69\157\156" || $rf->localName === "\105\156\143\x72\x79\x70\164\x65\x64\x41\163\163\x65\162\164\151\x6f\156")) {
            goto TB;
        }
        $this->assertions[] = new SAML2SPAssertion($rf);
        TB:
        in:
        $rf = $rf->nextSibling;
        goto Oe;
        Co:
    }
    public function getAssertions()
    {
        return $this->assertions;
    }
    public function setAssertions(array $gn)
    {
        $this->assertions = $gn;
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
