<?php


namespace Assert;

class InvalidArgumentException extends \InvalidArgumentException implements AssertionFailedException
{
    private $propertyPath;
    private $value;
    private $constraints;
    public function __construct($QT, $V5, $pE, $g2, array $J3 = array())
    {
        parent::__construct($QT, $V5);
        $this->propertyPath = $pE;
        $this->value = $g2;
        $this->constraints = $J3;
    }
    public function getPropertyPath()
    {
        return $this->propertyPath;
    }
    public function getValue()
    {
        return $this->value;
    }
    public function getConstraints()
    {
        return $this->constraints;
    }
}
