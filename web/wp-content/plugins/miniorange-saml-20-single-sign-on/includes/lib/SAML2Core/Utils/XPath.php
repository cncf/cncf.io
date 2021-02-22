<?php


namespace RobRichards\XMLSecLibs\Utils;

class XPath
{
    const ALPHANUMERIC = "\x5c\167\x5c\x64";
    const NUMERIC = "\x5c\x64";
    const LETTERS = "\134\167";
    const EXTENDED_ALPHANUMERIC = "\x5c\x77\134\144\x5c\x73\134\55\x5f\x3a\134\x2e";
    const SINGLE_QUOTE = "\47";
    const DOUBLE_QUOTE = "\x22";
    const ALL_QUOTES = "\x5b\x27\42\135";
    public static function filterAttrValue($Ka, $s1 = self::ALL_QUOTES)
    {
        return preg_replace("\43" . $s1 . "\x23", '', $Ka);
    }
    public static function filterAttrName($XE, $fZ = self::EXTENDED_ALPHANUMERIC)
    {
        return preg_replace("\x23\x5b\x5e" . $fZ . "\x5d\x23", '', $XE);
    }
}
