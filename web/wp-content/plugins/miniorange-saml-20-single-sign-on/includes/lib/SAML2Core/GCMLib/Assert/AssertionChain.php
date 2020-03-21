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
    private $assertionClassName = "\101\x73\163\145\162\x74\134\x41\x73\163\x65\x72\x74\x69\x6f\156";
    public function __construct($g2, $CB = null, $u6 = null)
    {
        $this->value = $g2;
        $this->defaultMessage = $CB;
        $this->defaultPropertyPath = $u6;
    }
    public function __call($E2, $vP)
    {
        if (!(true === $this->alwaysValid)) {
            goto w23;
        }
        return $this;
        w23:
        if (\method_exists($this->assertionClassName, $E2)) {
            goto YpQ;
        }
        throw new \RuntimeException("\101\x73\x73\x65\x72\x74\151\x6f\x6e\x20\47" . $E2 . "\x27\x20\x64\x6f\145\163\40\156\x6f\x74\40\x65\x78\151\x73\164\56");
        YpQ:
        $pa = new ReflectionClass($this->assertionClassName);
        $R2 = $pa->getMethod($E2);
        \array_unshift($vP, $this->value);
        $po = $R2->getParameters();
        foreach ($po as $xK => $hO) {
            if (!isset($vP[$xK])) {
                goto qDm;
            }
            goto yRE;
            qDm:
            if (!("\x6d\x65\x73\x73\x61\147\x65" == $hO->getName())) {
                goto cM4;
            }
            $vP[$xK] = $this->defaultMessage;
            cM4:
            if (!("\160\162\x6f\160\145\x72\x74\171\x50\x61\x74\150" == $hO->getName())) {
                goto fqd;
            }
            $vP[$xK] = $this->defaultPropertyPath;
            fqd:
            yRE:
        }
        CSG:
        if (!$this->all) {
            goto hFh;
        }
        $E2 = "\141\154\154" . $E2;
        hFh:
        \call_user_func_array(array($this->assertionClassName, $E2), $vP);
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
            goto epZ;
        }
        $this->alwaysValid = true;
        epZ:
        return $this;
    }
    public function setAssertionClassName($vw)
    {
        if (\is_string($vw)) {
            goto MLd;
        }
        throw new LogicException("\105\170\143\145\160\x74\x69\157\156\40\x63\154\x61\x73\x73\x20\156\x61\155\145\40\155\x75\163\x74\40\x62\x65\x20\160\x61\163\x73\x65\x64\x20\x61\163\40\x61\x20\163\x74\x72\x69\156\147");
        MLd:
        if (!("\101\163\x73\x65\162\164\134\x41\x73\163\145\x72\164\x69\x6f\156" !== $vw && !\is_subclass_of($vw, "\x41\x73\163\x65\x72\x74\x5c\101\163\x73\x65\x72\x74\151\157\156"))) {
            goto Y6a;
        }
        throw new LogicException($vw . "\40\x69\163\x20\x6e\x6f\164\40\50\x61\40\163\x75\x62\x63\154\x61\163\163\x20\157\x66\51\x20\101\163\163\x65\162\164\x5c\101\163\163\x65\162\x74\x69\x6f\x6e");
        Y6a:
        $this->assertionClassName = $vw;
        return $this;
    }
}
