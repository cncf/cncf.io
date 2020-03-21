<?php


abstract class BasicEnum
{
    private static $constCacheArray = NULL;
    public static function getConstants()
    {
        if (!(self::$constCacheArray == NULL)) {
            goto tVi;
        }
        self::$constCacheArray = array();
        tVi:
        $QM = get_called_class();
        if (array_key_exists($QM, self::$constCacheArray)) {
            goto ACx;
        }
        $s6 = new ReflectionClass($QM);
        self::$constCacheArray[$QM] = $s6->getConstants();
        ACx:
        return self::$constCacheArray[$QM];
    }
    public static function isValidName($AF, $m8 = false)
    {
        $X9 = self::getConstants();
        if (!$m8) {
            goto bqn;
        }
        return array_key_exists($AF, $X9);
        bqn:
        $uE = array_map("\x73\x74\162\x74\x6f\x6c\x6f\167\145\162", array_keys($X9));
        return in_array(strtolower($AF), $uE);
    }
    public static function isValidValue($g2, $m8 = true)
    {
        $aq = array_values(self::getConstants());
        return in_array($g2, $aq, $m8);
    }
}
