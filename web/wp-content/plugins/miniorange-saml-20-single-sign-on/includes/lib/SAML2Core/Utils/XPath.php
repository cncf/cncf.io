<?php


namespace RobRichards\XMLSecLibs\Utils;

class XPath
{
    const ALPHANUMERIC = "\x5c\167\x5c\144";
    const NUMERIC = "\x5c\x64";
    const LETTERS = "\134\x77";
    const EXTENDED_ALPHANUMERIC = "\134\x77\134\x64\134\x73\x5c\55\x5f\72\x5c\x2e";
    const SINGLE_QUOTE = "\47";
    const DOUBLE_QUOTE = "\42";
    const ALL_QUOTES = "\x5b\47\x22\x5d";
    public static function filterAttrValue($g2, $zu = self::ALL_QUOTES)
    {
        return preg_replace("\x23" . $zu . "\x23", '', $g2);
    }
    public static function filterAttrName($AF, $T0 = self::EXTENDED_ALPHANUMERIC)
    {
        return preg_replace("\x23\133\x5e" . $T0 . "\135\x23", '', $AF);
    }
}
