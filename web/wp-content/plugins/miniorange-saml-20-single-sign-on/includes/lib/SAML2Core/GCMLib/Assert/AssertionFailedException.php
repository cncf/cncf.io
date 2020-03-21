<?php


namespace Assert;

interface AssertionFailedException
{
    public function getPropertyPath();
    public function getValue();
    public function getConstraints();
}
