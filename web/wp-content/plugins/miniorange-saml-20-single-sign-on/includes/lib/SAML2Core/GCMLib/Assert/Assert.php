<?php


namespace Assert;

abstract class Assert
{
    protected static $lazyAssertionExceptionClass = "\101\163\163\x65\x72\x74\x5c\x4c\x61\x7a\x79\x41\163\x73\x65\162\x74\x69\157\x6e\105\170\143\x65\x70\164\x69\x6f\156";
    protected static $assertionClass = "\101\x73\163\x65\x72\164\x5c\101\x73\163\145\x72\164\151\157\x6e";
    public static function that($g2, $CB = null, $u6 = null)
    {
        $g0 = new AssertionChain($g2, $CB, $u6);
        return $g0->setAssertionClassName(static::$assertionClass);
    }
    public static function thatAll($aq, $CB = null, $u6 = null)
    {
        return static::that($aq, $CB, $u6)->all();
    }
    public static function thatNullOr($g2, $CB = null, $u6 = null)
    {
        return static::that($g2, $CB, $u6)->nullOr();
    }
    public static function lazy()
    {
        $fs = new LazyAssertion();
        return $fs->setAssertClass(\get_called_class())->setExceptionClass(static::$lazyAssertionExceptionClass);
    }
}
