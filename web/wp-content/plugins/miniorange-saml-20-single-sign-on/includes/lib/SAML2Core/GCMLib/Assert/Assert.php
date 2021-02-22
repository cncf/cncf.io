<?php


namespace Assert;

abstract class Assert
{
    protected static $lazyAssertionExceptionClass = "\101\163\x73\x65\x72\x74\x5c\x4c\x61\172\171\101\163\x73\145\162\x74\151\x6f\x6e\x45\170\143\x65\160\164\x69\157\x6e";
    protected static $assertionClass = "\101\163\163\145\162\x74\134\101\x73\x73\x65\162\164\151\157\x6e";
    public static function that($Ka, $UA = null, $LZ = null)
    {
        $lI = new AssertionChain($Ka, $UA, $LZ);
        return $lI->setAssertionClassName(static::$assertionClass);
    }
    public static function thatAll($rd, $UA = null, $LZ = null)
    {
        return static::that($rd, $UA, $LZ)->all();
    }
    public static function thatNullOr($Ka, $UA = null, $LZ = null)
    {
        return static::that($Ka, $UA, $LZ)->nullOr();
    }
    public static function lazy()
    {
        $Y_ = new LazyAssertion();
        return $Y_->setAssertClass(\get_called_class())->setExceptionClass(static::$lazyAssertionExceptionClass);
    }
}
