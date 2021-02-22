<?php


namespace Assert;

use LogicException;
use ReflectionClass;
class AssertionChain
{
    private $value;
    private $defaultMessage;
    private $defaultPropertyPath;
    private $alwaysValid = false;
    private $all = false;
    private $assertionClassName = "\x41\x73\163\x65\162\x74\134\101\163\x73\x65\162\x74\151\x6f\156";
    public function __construct($Ka, $UA = null, $LZ = null)
    {
        $this->value = $Ka;
        $this->defaultMessage = $UA;
        $this->defaultPropertyPath = $LZ;
    }
    public function __call($vT, $Gf)
    {
        if (!(true === $this->alwaysValid)) {
            goto T6;
        }
        return $this;
        T6:
        if (\method_exists($this->assertionClassName, $vT)) {
            goto S7;
        }
        throw new \RuntimeException("\101\163\x73\145\162\164\151\157\156\40\x27" . $vT . "\47\40\x64\x6f\145\x73\x20\x6e\157\x74\40\145\x78\x69\x73\164\56");
        S7:
        $KY = new ReflectionClass($this->assertionClassName);
        $Vp = $KY->getMethod($vT);
        \array_unshift($Gf, $this->value);
        $vW = $Vp->getParameters();
        foreach ($vW as $Ok => $nT) {
            if (!isset($Gf[$Ok])) {
                goto Kp;
            }
            goto x3;
            Kp:
            if (!("\x6d\145\x73\163\141\147\145" == $nT->getName())) {
                goto x6;
            }
            $Gf[$Ok] = $this->defaultMessage;
            x6:
            if (!("\x70\x72\157\x70\145\162\x74\171\x50\141\x74\150" == $nT->getName())) {
                goto IQ;
            }
            $Gf[$Ok] = $this->defaultPropertyPath;
            IQ:
            x3:
        }
        bB:
        if (!$this->all) {
            goto k6;
        }
        $vT = "\x61\154\154" . $vT;
        k6:
        \call_user_func_array(array($this->assertionClassName, $vT), $Gf);
        return $this;
    }
    public function all()
    {
        $this->all = true;
        return $this;
    }
    public function nullOr()
    {
        if (!(null === $this->value)) {
            goto Z6;
        }
        $this->alwaysValid = true;
        Z6:
        return $this;
    }
    public function setAssertionClassName($nW)
    {
        if (\is_string($nW)) {
            goto G1;
        }
        throw new LogicException("\x45\x78\143\x65\x70\x74\151\157\156\x20\x63\x6c\141\x73\x73\40\x6e\x61\155\x65\40\155\165\163\164\x20\x62\145\x20\x70\141\x73\163\145\144\40\141\x73\x20\x61\40\x73\x74\x72\x69\x6e\x67");
        G1:
        if (!("\x41\163\163\145\x72\164\134\x41\x73\163\x65\162\164\x69\x6f\x6e" !== $nW && !\is_subclass_of($nW, "\x41\163\x73\x65\162\x74\134\x41\163\x73\x65\162\164\x69\157\156"))) {
            goto dA;
        }
        throw new LogicException($nW . "\40\151\x73\40\156\x6f\164\40\50\x61\40\163\x75\x62\x63\154\141\163\163\40\157\146\x29\40\x41\x73\163\145\162\x74\134\x41\x73\x73\x65\162\164\x69\x6f\156");
        dA:
        $this->assertionClassName = $nW;
        return $this;
    }
}
