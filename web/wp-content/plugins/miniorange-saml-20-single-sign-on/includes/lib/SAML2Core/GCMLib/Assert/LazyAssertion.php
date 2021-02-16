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
    private $assertClass = "\101\163\x73\145\162\x74\x5c\101\x73\163\145\x72\164";
    private $exceptionClass = "\101\x73\163\x65\162\x74\134\114\x61\172\171\101\163\x73\x65\x72\164\151\157\x6e\105\x78\x63\145\160\164\151\x6f\x6e";
    public function that($Ka, $YT, $UA = null)
    {
        $this->currentChainFailed = false;
        $this->thisChainTryAll = false;
        $Cw = $this->assertClass;
        $this->currentChain = $Cw::that($Ka, $UA, $YT);
        return $this;
    }
    public function tryAll()
    {
        if ($this->currentChain) {
            goto Qz;
        }
        $this->alwaysTryAll = true;
        Qz:
        $this->thisChainTryAll = true;
        return $this;
    }
    public function __call($Vp, $Gf)
    {
        if (!(false === $this->alwaysTryAll && false === $this->thisChainTryAll && true === $this->currentChainFailed)) {
            goto wi;
        }
        return $this;
        wi:
        try {
            \call_user_func_array(array($this->currentChain, $Vp), $Gf);
        } catch (AssertionFailedException $LR) {
            $this->errors[] = $LR;
            $this->currentChainFailed = true;
        }
        return $this;
    }
    public function verifyNow()
    {
        if (!$this->errors) {
            goto W9;
        }
        throw \call_user_func(array($this->exceptionClass, "\x66\162\157\x6d\x45\x72\x72\157\x72\163"), $this->errors);
        W9:
        return true;
    }
    public function setAssertClass($nW)
    {
        if (\is_string($nW)) {
            goto cs;
        }
        throw new LogicException("\x41\x73\163\145\x72\164\40\x63\154\141\x73\x73\x20\x6e\x61\155\x65\40\x6d\165\x73\x74\40\x62\x65\x20\160\141\163\x73\x65\144\x20\x61\x73\40\x61\x20\x73\164\x72\x69\x6e\147");
        cs:
        if (!("\101\x73\163\145\162\x74\134\101\x73\x73\145\162\164" !== $nW && !\is_subclass_of($nW, "\x41\163\x73\x65\162\164\134\x41\163\163\145\162\x74"))) {
            goto Xq;
        }
        throw new LogicException($nW . "\40\x69\163\x20\156\x6f\164\40\50\141\40\x73\x75\142\x63\154\141\163\163\x20\x6f\146\51\40\x41\163\x73\145\162\x74\134\x41\x73\163\x65\x72\164");
        Xq:
        $this->assertClass = $nW;
        return $this;
    }
    public function setExceptionClass($nW)
    {
        if (\is_string($nW)) {
            goto lF;
        }
        throw new LogicException("\105\170\x63\145\160\164\151\x6f\x6e\x20\143\154\x61\163\163\x20\x6e\x61\x6d\x65\x20\x6d\x75\x73\x74\40\x62\x65\x20\x70\x61\163\x73\145\144\40\141\x73\x20\x61\x20\163\x74\162\x69\156\x67");
        lF:
        if (!("\101\163\x73\x65\162\164\x5c\114\x61\x7a\x79\101\x73\163\145\162\x74\x69\157\x6e\105\170\x63\x65\160\x74\x69\157\156" !== $nW && !\is_subclass_of($nW, "\101\x73\x73\145\x72\164\x5c\x4c\x61\x7a\x79\101\x73\x73\145\x72\x74\151\157\156\x45\170\143\x65\x70\x74\x69\157\156"))) {
            goto JF;
        }
        throw new LogicException($nW . "\x20\151\163\40\x6e\157\164\40\x28\141\x20\x73\x75\x62\x63\x6c\x61\x73\x73\x20\x6f\x66\51\x20\101\163\163\145\x72\164\134\114\x61\172\x79\101\x73\x73\x65\x72\164\151\x6f\x6e\x45\170\x63\x65\160\x74\151\157\x6e");
        JF:
        $this->exceptionClass = $nW;
        return $this;
    }
}
