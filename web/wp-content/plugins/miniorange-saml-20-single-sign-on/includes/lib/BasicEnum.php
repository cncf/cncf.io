<?php


abstract class BasicEnum
{
    private static $constCacheArray = NULL;
    public static function getConstants()
    {
        if (!(self::$constCacheArray == NULL)) {
            goto NEz;
        }
        self::$constCacheArray = array();
        NEz:
        $n7 = get_called_class();
        if (array_key_exists($n7, self::$constCacheArray)) {
            goto ydK;
        }
        $yN = new ReflectionClass($n7);
        self::$constCacheArray[$n7] = $yN->getConstants();
        ydK:
        return self::$constCacheArray[$n7];
    }
    public static function isValidName($XE, $zW = false)
    {
        $EU = self::getConstants();
        if (!$zW) {
            goto aed;
        }
        return array_key_exists($XE, $EU);
        aed:
        $jw = array_map("\x73\164\x72\164\x6f\154\157\x77\145\x72", array_keys($EU));
        return in_array(strtolower($XE), $jw);
    }
    public static function isValidValue($Ka, $zW = true)
    {
        $rd = array_values(self::getConstants());
        return in_array($Ka, $rd, $zW);
    }
}
