<?php


namespace Assert;

class LazyAssertionException extends InvalidArgumentException
{
    private $errors = array();
    public static function fromErrors(array $errors)
    {
        $QT = \sprintf("\x54\x68\145\40\146\157\154\154\x6f\x77\151\x6e\x67\40\45\x64\40\x61\163\x73\145\x72\164\151\157\156\x73\40\146\141\151\154\x65\x64\72", \count($errors)) . "\12";
        $oM = 1;
        foreach ($errors as $vH) {
            $QT .= \sprintf("\45\x64\x29\40\45\163\x3a\x20\x25\x73\12", $oM++, $vH->getPropertyPath(), $vH->getMessage());
            Gcn:
        }
        b12:
        return new static($QT, $errors);
    }
    public function __construct($QT, array $errors)
    {
        parent::__construct($QT, 0, null, null);
        $this->errors = $errors;
    }
    public function getErrorExceptions()
    {
        return $this->errors;
    }
}
