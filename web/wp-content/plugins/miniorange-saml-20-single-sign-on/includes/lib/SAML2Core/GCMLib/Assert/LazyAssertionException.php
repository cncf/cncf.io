<?php


namespace Assert;

class LazyAssertionException extends InvalidArgumentException
{
    private $errors = array();
    public static function fromErrors(array $errors)
    {
        $AA = \sprintf("\x54\150\x65\40\146\157\154\x6c\157\x77\151\x6e\147\40\x25\x64\40\x61\163\163\145\x72\164\x69\x6f\156\163\40\146\x61\151\154\x65\x64\72", \count($errors)) . "\xa";
        $LH = 1;
        foreach ($errors as $G7) {
            $AA .= \sprintf("\x25\144\51\x20\45\163\72\40\x25\163\xa", $LH++, $G7->getPropertyPath(), $G7->getMessage());
            rI:
        }
        Wa:
        return new static($AA, $errors);
    }
    public function __construct($AA, array $errors)
    {
        parent::__construct($AA, 0, null, null);
        $this->errors = $errors;
    }
    public function getErrorExceptions()
    {
        return $this->errors;
    }
}
