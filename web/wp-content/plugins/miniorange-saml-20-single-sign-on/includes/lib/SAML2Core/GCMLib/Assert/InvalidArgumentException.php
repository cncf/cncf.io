<?php


namespace Assert;

class InvalidArgumentException extends \InvalidArgumentException implements AssertionFailedException
{
    private $propertyPath;
    private $value;
    private $constraints;
    public function __construct($AA, $HP, $YT, $Ka, array $zS = array())
    {
        parent::__construct($AA, $HP);
        $this->propertyPath = $YT;
        $this->value = $Ka;
        $this->constraints = $zS;
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
