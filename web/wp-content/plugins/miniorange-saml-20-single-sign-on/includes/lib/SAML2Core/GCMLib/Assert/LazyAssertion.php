<?php


namespace Assert;

use LogicException;
class LazyAssertion
{
    private $currentChainFailed = false;
    private $alwaysTryAll = false;
    private $thisChainTryAll = false;
    private $currentChain;
    private $errors = array();
    private $assertClass = "\x41\163\x73\x65\x72\164\134\101\163\163\145\162\164";
    private $exceptionClass = "\x41\163\x73\x65\x72\164\134\114\x61\x7a\171\101\163\x73\145\162\x74\x69\157\x6e\x45\x78\x63\x65\x70\x74\x69\x6f\x6e";
    public function that($g2, $pE, $CB = null)
    {
        $this->currentChainFailed = false;
        $this->thisChainTryAll = false;
        $fy = $this->assertClass;
        $this->currentChain = $fy::that($g2, $CB, $pE);
        return $this;
    }
    public function tryAll()
    {
        if ($this->currentChain) {
            goto HWu;
        }
        $this->alwaysTryAll = true;
        HWu:
        $this->thisChainTryAll = true;
        return $this;
    }
    public function __call($R2, $vP)
    {
        if (!(false === $this->alwaysTryAll && false === $this->thisChainTryAll && true === $this->currentChainFailed)) {
            goto p37;
        }
        return $this;
        p37:
        try {
            \call_user_func_array(array($this->currentChain, $R2), $vP);
        } catch (AssertionFailedException $A4) {
            $this->errors[] = $A4;
            $this->currentChainFailed = true;
        }
        return $this;
    }
    public function verifyNow()
    {
        if (!$this->errors) {
            goto fCD;
        }
        throw \call_user_func(array($this->exceptionClass, "\x66\162\x6f\x6d\x45\162\162\157\x72\x73"), $this->errors);
        fCD:
        return true;
    }
    public function setAssertClass($vw)
    {
        if (\is_string($vw)) {
            goto dX_;
        }
        throw new LogicException("\101\x73\x73\x65\x72\164\40\x63\154\x61\163\x73\40\x6e\x61\x6d\x65\40\155\x75\163\164\40\142\x65\x20\x70\x61\163\163\x65\x64\x20\x61\163\40\141\x20\x73\164\x72\x69\x6e\x67");
        dX_:
        if (!("\101\x73\x73\145\x72\x74\134\x41\x73\x73\x65\162\164" !== $vw && !\is_subclass_of($vw, "\101\x73\163\145\x72\164\134\101\163\x73\x65\162\164"))) {
            goto ZcX;
        }
        throw new LogicException($vw . "\x20\x69\x73\x20\156\x6f\x74\x20\x28\x61\40\x73\165\x62\143\154\141\163\163\x20\157\146\51\40\101\x73\163\145\162\164\x5c\x41\x73\x73\x65\162\164");
        ZcX:
        $this->assertClass = $vw;
        return $this;
    }
    public function setExceptionClass($vw)
    {
        if (\is_string($vw)) {
            goto yKo;
        }
        throw new LogicException("\x45\170\143\x65\160\x74\x69\157\156\x20\143\154\x61\163\x73\40\156\141\x6d\145\40\155\x75\x73\x74\40\142\x65\40\160\141\163\x73\145\x64\40\141\163\x20\141\40\x73\x74\x72\151\x6e\147");
        yKo:
        if (!("\101\x73\163\145\x72\x74\x5c\x4c\141\172\171\x41\163\163\145\162\164\151\x6f\156\x45\170\x63\145\160\164\151\x6f\x6e" !== $vw && !\is_subclass_of($vw, "\x41\163\x73\x65\162\164\134\114\x61\x7a\171\x41\x73\x73\x65\x72\164\151\157\156\105\x78\x63\x65\x70\164\151\157\156"))) {
            goto W_d;
        }
        throw new LogicException($vw . "\40\151\163\40\156\x6f\x74\40\x28\141\x20\163\165\x62\x63\154\x61\x73\x73\40\x6f\146\51\40\101\x73\163\145\162\x74\x5c\114\x61\x7a\x79\x41\163\163\145\x72\x74\x69\157\156\105\x78\143\x65\160\164\151\157\x6e");
        W_d:
        $this->exceptionClass = $vw;
        return $this;
    }
}
