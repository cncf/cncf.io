<?php


namespace Assert;

use BadMethodCallException;
class Assertion
{
    const INVALID_FLOAT = 9;
    const INVALID_INTEGER = 10;
    const INVALID_DIGIT = 11;
    const INVALID_INTEGERISH = 12;
    const INVALID_BOOLEAN = 13;
    const VALUE_EMPTY = 14;
    const VALUE_NULL = 15;
    const VALUE_NOT_NULL = 25;
    const INVALID_STRING = 16;
    const INVALID_REGEX = 17;
    const INVALID_MIN_LENGTH = 18;
    const INVALID_MAX_LENGTH = 19;
    const INVALID_STRING_START = 20;
    const INVALID_STRING_CONTAINS = 21;
    const INVALID_CHOICE = 22;
    const INVALID_NUMERIC = 23;
    const INVALID_ARRAY = 24;
    const INVALID_KEY_EXISTS = 26;
    const INVALID_NOT_BLANK = 27;
    const INVALID_INSTANCE_OF = 28;
    const INVALID_SUBCLASS_OF = 29;
    const INVALID_RANGE = 30;
    const INVALID_ALNUM = 31;
    const INVALID_TRUE = 32;
    const INVALID_EQ = 33;
    const INVALID_SAME = 34;
    const INVALID_MIN = 35;
    const INVALID_MAX = 36;
    const INVALID_LENGTH = 37;
    const INVALID_FALSE = 38;
    const INVALID_STRING_END = 39;
    const INVALID_UUID = 40;
    const INVALID_COUNT = 41;
    const INVALID_NOT_EQ = 42;
    const INVALID_NOT_SAME = 43;
    const INVALID_TRAVERSABLE = 44;
    const INVALID_ARRAY_ACCESSIBLE = 45;
    const INVALID_KEY_ISSET = 46;
    const INVALID_VALUE_IN_ARRAY = 47;
    const INVALID_E164 = 48;
    const INVALID_BASE64 = 49;
    const INVALID_DIRECTORY = 101;
    const INVALID_FILE = 102;
    const INVALID_READABLE = 103;
    const INVALID_WRITEABLE = 104;
    const INVALID_CLASS = 105;
    const INVALID_INTERFACE = 106;
    const INVALID_EMAIL = 201;
    const INTERFACE_NOT_IMPLEMENTED = 202;
    const INVALID_URL = 203;
    const INVALID_NOT_INSTANCE_OF = 204;
    const VALUE_NOT_EMPTY = 205;
    const INVALID_JSON_STRING = 206;
    const INVALID_OBJECT = 207;
    const INVALID_METHOD = 208;
    const INVALID_SCALAR = 209;
    const INVALID_LESS = 210;
    const INVALID_LESS_OR_EQUAL = 211;
    const INVALID_GREATER = 212;
    const INVALID_GREATER_OR_EQUAL = 213;
    const INVALID_DATE = 214;
    const INVALID_CALLABLE = 215;
    const INVALID_KEY_NOT_EXISTS = 216;
    const INVALID_SATISFY = 217;
    const INVALID_IP = 218;
    const INVALID_BETWEEN = 219;
    const INVALID_BETWEEN_EXCLUSIVE = 220;
    const INVALID_EXTENSION = 222;
    const INVALID_CONSTANT = 221;
    const INVALID_VERSION = 223;
    const INVALID_PROPERTY = 224;
    const INVALID_RESOURCE = 225;
    protected static $exceptionClass = "\101\163\163\145\x72\x74\134\x49\156\166\141\154\x69\x64\x41\x72\x67\x75\x6d\x65\156\164\x45\x78\x63\145\160\164\151\157\156";
    protected static function createException($g2, $QT, $V5, $pE = null, array $J3 = array())
    {
        $te = static::$exceptionClass;
        return new $te($QT, $V5, $pE, $g2, $J3);
    }
    public static function eq($g2, $LR, $QT = null, $pE = null)
    {
        if (!($g2 != $LR)) {
            goto rs0;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\126\141\x6c\x75\x65\40\x22\45\x73\x22\40\x64\157\x65\163\x20\156\157\164\x20\145\x71\165\141\x6c\x20\x65\x78\160\145\143\x74\145\144\x20\x76\141\x6c\165\145\x20\42\45\x73\42\56"), static::stringify($g2), static::stringify($LR));
        throw static::createException($g2, $QT, static::INVALID_EQ, $pE, array("\x65\x78\x70\145\x63\x74\x65\x64" => $LR));
        rs0:
        return true;
    }
    public static function same($g2, $LR, $QT = null, $pE = null)
    {
        if (!($g2 !== $LR)) {
            goto kI3;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\126\x61\154\165\145\40\42\x25\163\42\x20\x69\163\40\x6e\157\164\x20\164\150\145\x20\163\x61\x6d\x65\40\x61\163\x20\145\170\160\145\143\x74\145\x64\40\166\x61\154\165\145\x20\x22\45\163\x22\x2e"), static::stringify($g2), static::stringify($LR));
        throw static::createException($g2, $QT, static::INVALID_SAME, $pE, array("\145\x78\x70\x65\143\x74\145\x64" => $LR));
        kI3:
        return true;
    }
    public static function notEq($uP, $LR, $QT = null, $pE = null)
    {
        if (!($uP == $LR)) {
            goto ZB7;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\126\x61\154\165\145\x20\42\x25\163\x22\x20\151\x73\x20\145\x71\x75\x61\154\40\x74\157\40\x65\x78\x70\x65\143\x74\x65\144\40\x76\x61\154\165\x65\x20\x22\x25\163\x22\x2e"), static::stringify($uP), static::stringify($LR));
        throw static::createException($uP, $QT, static::INVALID_NOT_EQ, $pE, array("\145\170\x70\145\x63\164\145\x64" => $LR));
        ZB7:
        return true;
    }
    public static function notSame($uP, $LR, $QT = null, $pE = null)
    {
        if (!($uP === $LR)) {
            goto lLq;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\126\x61\154\x75\145\40\x22\x25\163\x22\x20\151\163\40\164\150\145\x20\163\x61\x6d\x65\x20\141\163\40\145\x78\x70\145\143\164\x65\x64\40\x76\141\x6c\165\x65\x20\42\45\x73\x22\x2e"), static::stringify($uP), static::stringify($LR));
        throw static::createException($uP, $QT, static::INVALID_NOT_SAME, $pE, array("\x65\x78\x70\145\143\164\145\144" => $LR));
        lLq:
        return true;
    }
    public static function notInArray($g2, array $JF, $QT = null, $pE = null)
    {
        if (!(true === \in_array($g2, $JF))) {
            goto vOH;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\126\141\x6c\165\145\40\x22\45\163\x22\40\151\x73\x20\x69\156\x20\x67\151\166\145\x6e\x20\42\x25\x73\x22\x2e"), static::stringify($g2), static::stringify($JF));
        throw static::createException($g2, $QT, static::INVALID_VALUE_IN_ARRAY, $pE, array("\x63\x68\157\151\143\x65\x73" => $JF));
        vOH:
        return true;
    }
    public static function integer($g2, $QT = null, $pE = null)
    {
        if (\is_int($g2)) {
            goto qrn;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\126\x61\x6c\165\x65\40\42\45\x73\x22\40\x69\163\x20\x6e\157\x74\40\141\x6e\x20\151\156\164\145\147\x65\x72\56"), static::stringify($g2));
        throw static::createException($g2, $QT, static::INVALID_INTEGER, $pE);
        qrn:
        return true;
    }
    public static function float($g2, $QT = null, $pE = null)
    {
        if (\is_float($g2)) {
            goto MpJ;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\126\x61\x6c\165\x65\x20\42\x25\163\42\40\x69\163\40\156\x6f\x74\40\141\40\146\154\157\141\164\x2e"), static::stringify($g2));
        throw static::createException($g2, $QT, static::INVALID_FLOAT, $pE);
        MpJ:
        return true;
    }
    public static function digit($g2, $QT = null, $pE = null)
    {
        if (\ctype_digit((string) $g2)) {
            goto XYK;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\126\x61\154\165\x65\40\42\45\163\x22\40\151\163\x20\x6e\x6f\x74\40\x61\40\144\151\147\151\x74\x2e"), static::stringify($g2));
        throw static::createException($g2, $QT, static::INVALID_DIGIT, $pE);
        XYK:
        return true;
    }
    public static function integerish($g2, $QT = null, $pE = null)
    {
        if (!(\is_resource($g2) || \is_object($g2) || \is_bool($g2) || \is_null($g2) || \is_array($g2) || \is_string($g2) && '' == $g2 || \strval(\intval($g2)) !== \strval($g2) && \strval(\intval($g2)) !== \strval(\ltrim($g2, "\x30")) && '' !== \strval(\intval($g2)) && '' !== \strval(\ltrim($g2, "\60")))) {
            goto u5O;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\126\141\154\165\x65\x20\x22\x25\163\42\x20\151\x73\40\156\157\164\x20\x61\x6e\40\x69\x6e\164\x65\147\x65\162\40\157\162\x20\x61\x20\x6e\x75\155\x62\x65\162\40\143\141\163\x74\x61\x62\x6c\x65\x20\164\157\x20\151\x6e\164\145\147\x65\162\56"), static::stringify($g2));
        throw static::createException($g2, $QT, static::INVALID_INTEGERISH, $pE);
        u5O:
        return true;
    }
    public static function boolean($g2, $QT = null, $pE = null)
    {
        if (\is_bool($g2)) {
            goto C_S;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\126\141\154\x75\x65\40\42\45\163\42\x20\151\x73\40\156\x6f\164\40\x61\40\142\157\157\x6c\145\141\x6e\56"), static::stringify($g2));
        throw static::createException($g2, $QT, static::INVALID_BOOLEAN, $pE);
        C_S:
        return true;
    }
    public static function scalar($g2, $QT = null, $pE = null)
    {
        if (\is_scalar($g2)) {
            goto lgA;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\126\x61\154\165\x65\40\42\x25\163\x22\40\x69\x73\40\156\157\x74\40\x61\40\x73\x63\x61\x6c\x61\x72\56"), static::stringify($g2));
        throw static::createException($g2, $QT, static::INVALID_SCALAR, $pE);
        lgA:
        return true;
    }
    public static function notEmpty($g2, $QT = null, $pE = null)
    {
        if (!empty($g2)) {
            goto qk0;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\x56\x61\154\165\145\x20\x22\45\163\42\x20\x69\163\40\x65\x6d\160\164\x79\54\40\142\165\x74\40\156\x6f\x6e\40\x65\155\160\x74\x79\40\166\141\x6c\x75\145\40\x77\x61\x73\40\x65\170\160\145\x63\x74\x65\144\56"), static::stringify($g2));
        throw static::createException($g2, $QT, static::VALUE_EMPTY, $pE);
        qk0:
        return true;
    }
    public static function noContent($g2, $QT = null, $pE = null)
    {
        if (empty($g2)) {
            goto ZLc;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\126\141\154\x75\x65\x20\x22\45\163\42\40\x69\163\40\x6e\x6f\x74\40\x65\x6d\x70\164\171\54\x20\142\165\x74\x20\145\x6d\160\164\171\x20\x76\141\x6c\x75\145\x20\167\141\x73\x20\145\x78\x70\x65\143\164\145\x64\56"), static::stringify($g2));
        throw static::createException($g2, $QT, static::VALUE_NOT_EMPTY, $pE);
        ZLc:
        return true;
    }
    public static function null($g2, $QT = null, $pE = null)
    {
        if (!(null !== $g2)) {
            goto aua;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\x56\x61\x6c\165\145\40\x22\x25\163\x22\40\x69\163\x20\x6e\157\164\x20\x6e\165\154\x6c\54\x20\x62\165\164\40\156\165\x6c\x6c\x20\x76\141\154\x75\145\40\x77\x61\163\x20\x65\170\160\145\x63\164\145\144\x2e"), static::stringify($g2));
        throw static::createException($g2, $QT, static::VALUE_NOT_NULL, $pE);
        aua:
        return true;
    }
    public static function notNull($g2, $QT = null, $pE = null)
    {
        if (!(null === $g2)) {
            goto Lnz;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\x56\x61\154\165\145\x20\x22\45\x73\x22\x20\x69\x73\40\x6e\x75\154\154\54\40\142\165\x74\x20\x6e\157\156\x20\x6e\165\154\x6c\x20\x76\x61\154\165\145\x20\167\141\163\40\145\x78\x70\145\143\x74\x65\x64\x2e"), static::stringify($g2));
        throw static::createException($g2, $QT, static::VALUE_NULL, $pE);
        Lnz:
        return true;
    }
    public static function string($g2, $QT = null, $pE = null)
    {
        if (\is_string($g2)) {
            goto uFP;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\x56\x61\154\x75\x65\x20\42\x25\x73\42\x20\145\x78\x70\145\143\164\145\144\x20\164\157\40\x62\x65\x20\x73\x74\162\x69\156\147\54\40\164\171\160\x65\x20\45\163\x20\x67\x69\166\x65\156\56"), static::stringify($g2), \gettype($g2));
        throw static::createException($g2, $QT, static::INVALID_STRING, $pE);
        uFP:
        return true;
    }
    public static function regex($g2, $U6, $QT = null, $pE = null)
    {
        static::string($g2, $QT, $pE);
        if (\preg_match($U6, $g2)) {
            goto tEG;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\x56\141\x6c\x75\x65\40\x22\45\163\42\x20\144\157\145\x73\40\x6e\x6f\x74\x20\155\x61\x74\143\150\x20\145\x78\160\x72\145\x73\163\x69\157\x6e\56"), static::stringify($g2));
        throw static::createException($g2, $QT, static::INVALID_REGEX, $pE, array("\x70\141\164\164\x65\162\156" => $U6));
        tEG:
        return true;
    }
    public static function length($g2, $G_, $QT = null, $pE = null, $hs = "\x75\164\x66\70")
    {
        static::string($g2, $QT, $pE);
        if (!(\mb_strlen($g2, $hs) !== $G_)) {
            goto jzy;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\x56\141\x6c\165\145\x20\x22\45\x73\x22\40\150\141\x73\x20\x74\x6f\40\142\145\x20\45\x64\x20\145\x78\141\143\x74\154\171\x20\x63\150\141\x72\x61\143\164\x65\162\163\x20\x6c\x6f\x6e\x67\54\x20\x62\x75\x74\40\x6c\x65\156\x67\164\x68\40\x69\163\x20\x25\144\56"), static::stringify($g2), $G_, \mb_strlen($g2, $hs));
        throw static::createException($g2, $QT, static::INVALID_LENGTH, $pE, array("\x6c\x65\x6e\x67\164\150" => $G_, "\x65\156\143\x6f\x64\x69\x6e\147" => $hs));
        jzy:
        return true;
    }
    public static function minLength($g2, $uv, $QT = null, $pE = null, $hs = "\165\164\146\x38")
    {
        static::string($g2, $QT, $pE);
        if (!(\mb_strlen($g2, $hs) < $uv)) {
            goto Z1Y;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\126\x61\x6c\x75\145\x20\42\x25\x73\x22\40\x69\x73\x20\164\x6f\x6f\40\x73\150\x6f\162\164\54\40\x69\x74\x20\x73\x68\157\165\154\144\40\x68\x61\x76\145\40\x61\x74\40\154\x65\x61\163\x74\x20\x25\144\40\x63\x68\x61\x72\141\x63\164\145\x72\163\x2c\40\x62\165\x74\x20\157\x6e\154\171\x20\x68\141\163\40\x25\x64\x20\143\150\x61\162\141\143\164\x65\162\163\56"), static::stringify($g2), $uv, \mb_strlen($g2, $hs));
        throw static::createException($g2, $QT, static::INVALID_MIN_LENGTH, $pE, array("\155\x69\156\x5f\154\x65\x6e\x67\164\150" => $uv, "\x65\156\143\157\x64\x69\x6e\147" => $hs));
        Z1Y:
        return true;
    }
    public static function maxLength($g2, $ii, $QT = null, $pE = null, $hs = "\165\x74\x66\x38")
    {
        static::string($g2, $QT, $pE);
        if (!(\mb_strlen($g2, $hs) > $ii)) {
            goto u6F;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\126\x61\154\165\145\x20\42\x25\x73\42\x20\x69\163\x20\x74\x6f\157\x20\x6c\x6f\156\147\54\40\x69\164\x20\163\150\x6f\x75\x6c\144\40\150\x61\x76\x65\x20\x6e\x6f\x20\155\157\162\145\40\x74\x68\x61\x6e\40\45\x64\x20\x63\x68\141\162\x61\143\x74\x65\162\x73\x2c\x20\142\165\x74\40\150\x61\163\x20\x25\144\40\x63\x68\x61\162\x61\143\x74\x65\x72\x73\56"), static::stringify($g2), $ii, \mb_strlen($g2, $hs));
        throw static::createException($g2, $QT, static::INVALID_MAX_LENGTH, $pE, array("\155\x61\170\x5f\x6c\x65\156\147\164\150" => $ii, "\x65\156\x63\157\x64\x69\x6e\x67" => $hs));
        u6F:
        return true;
    }
    public static function betweenLength($g2, $uv, $ii, $QT = null, $pE = null, $hs = "\165\x74\146\70")
    {
        static::string($g2, $QT, $pE);
        static::minLength($g2, $uv, $QT, $pE, $hs);
        static::maxLength($g2, $ii, $QT, $pE, $hs);
        return true;
    }
    public static function startsWith($JU, $dk, $QT = null, $pE = null, $hs = "\165\x74\146\x38")
    {
        static::string($JU, $QT, $pE);
        if (!(0 !== \mb_strpos($JU, $dk, null, $hs))) {
            goto BWQ;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\126\141\154\165\145\40\x22\45\163\42\x20\x64\157\145\163\40\x6e\x6f\x74\x20\x73\164\x61\x72\164\40\x77\151\164\150\x20\42\45\x73\42\56"), static::stringify($JU), static::stringify($dk));
        throw static::createException($JU, $QT, static::INVALID_STRING_START, $pE, array("\x6e\145\145\144\154\x65" => $dk, "\145\156\143\157\x64\151\x6e\147" => $hs));
        BWQ:
        return true;
    }
    public static function endsWith($JU, $dk, $QT = null, $pE = null, $hs = "\x75\x74\146\x38")
    {
        static::string($JU, $QT, $pE);
        $VA = \mb_strlen($JU, $hs) - \mb_strlen($dk, $hs);
        if (!(\mb_strripos($JU, $dk, null, $hs) !== $VA)) {
            goto GFG;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\x56\x61\x6c\165\145\40\42\45\163\42\40\x64\157\145\x73\40\x6e\157\164\40\x65\x6e\x64\x20\x77\x69\x74\150\40\42\45\163\x22\56"), static::stringify($JU), static::stringify($dk));
        throw static::createException($JU, $QT, static::INVALID_STRING_END, $pE, array("\x6e\x65\145\x64\154\x65" => $dk, "\145\156\x63\157\x64\151\156\x67" => $hs));
        GFG:
        return true;
    }
    public static function contains($JU, $dk, $QT = null, $pE = null, $hs = "\x75\x74\x66\x38")
    {
        static::string($JU, $QT, $pE);
        if (!(false === \mb_strpos($JU, $dk, null, $hs))) {
            goto qj9;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\126\x61\154\x75\145\40\42\45\x73\42\x20\x64\157\x65\163\x20\156\x6f\x74\x20\x63\157\156\x74\x61\151\156\x20\42\x25\x73\42\56"), static::stringify($JU), static::stringify($dk));
        throw static::createException($JU, $QT, static::INVALID_STRING_CONTAINS, $pE, array("\x6e\x65\145\x64\x6c\x65" => $dk, "\x65\156\143\x6f\x64\151\156\x67" => $hs));
        qj9:
        return true;
    }
    public static function choice($g2, array $JF, $QT = null, $pE = null)
    {
        if (\in_array($g2, $JF, true)) {
            goto sMv;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\x56\x61\154\x75\x65\40\x22\x25\x73\x22\40\151\163\40\156\157\164\40\x61\x6e\40\145\x6c\145\155\x65\156\x74\40\157\x66\x20\164\x68\x65\40\x76\x61\x6c\x69\144\40\x76\141\154\165\x65\163\x3a\40\45\x73"), static::stringify($g2), \implode("\x2c\x20", \array_map(array(\get_called_class(), "\x73\164\x72\x69\x6e\147\x69\x66\171"), $JF)));
        throw static::createException($g2, $QT, static::INVALID_CHOICE, $pE, array("\143\x68\x6f\151\143\145\x73" => $JF));
        sMv:
        return true;
    }
    public static function inArray($g2, array $JF, $QT = null, $pE = null)
    {
        return static::choice($g2, $JF, $QT, $pE);
    }
    public static function numeric($g2, $QT = null, $pE = null)
    {
        if (\is_numeric($g2)) {
            goto QnV;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\x56\141\154\165\145\x20\42\x25\x73\42\40\x69\163\x20\156\x6f\164\x20\156\x75\155\145\162\x69\143\x2e"), static::stringify($g2));
        throw static::createException($g2, $QT, static::INVALID_NUMERIC, $pE);
        QnV:
        return true;
    }
    public static function isResource($g2, $QT = null, $pE = null)
    {
        if (\is_resource($g2)) {
            goto Jjo;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\x56\x61\154\x75\x65\40\x22\x25\x73\42\40\151\163\x20\156\x6f\164\40\141\40\162\x65\163\157\165\x72\x63\145\56"), static::stringify($g2));
        throw static::createException($g2, $QT, static::INVALID_RESOURCE, $pE);
        Jjo:
        return true;
    }
    public static function isArray($g2, $QT = null, $pE = null)
    {
        if (\is_array($g2)) {
            goto AGB;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\x56\x61\x6c\165\145\40\x22\x25\x73\42\x20\151\163\x20\x6e\x6f\x74\x20\x61\156\40\x61\162\x72\141\171\x2e"), static::stringify($g2));
        throw static::createException($g2, $QT, static::INVALID_ARRAY, $pE);
        AGB:
        return true;
    }
    public static function isTraversable($g2, $QT = null, $pE = null)
    {
        if (!(!\is_array($g2) && !$g2 instanceof \Traversable)) {
            goto bhJ;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\126\141\154\165\145\x20\42\x25\163\42\40\x69\x73\x20\x6e\x6f\164\x20\x61\156\x20\141\x72\x72\141\x79\40\141\156\x64\40\x64\157\x65\163\x20\x6e\x6f\x74\x20\x69\155\x70\x6c\x65\155\145\x6e\164\x20\124\162\x61\166\145\x72\163\x61\x62\154\x65\x2e"), static::stringify($g2));
        throw static::createException($g2, $QT, static::INVALID_TRAVERSABLE, $pE);
        bhJ:
        return true;
    }
    public static function isArrayAccessible($g2, $QT = null, $pE = null)
    {
        if (!(!\is_array($g2) && !$g2 instanceof \ArrayAccess)) {
            goto wUg;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\x56\x61\154\x75\x65\40\x22\x25\163\x22\40\x69\163\40\156\x6f\x74\40\141\x6e\x20\141\x72\162\141\x79\40\141\x6e\x64\x20\144\157\145\163\x20\156\157\x74\x20\151\x6d\160\x6c\x65\155\145\x6e\164\40\x41\x72\x72\x61\171\101\x63\143\145\163\163\x2e"), static::stringify($g2));
        throw static::createException($g2, $QT, static::INVALID_ARRAY_ACCESSIBLE, $pE);
        wUg:
        return true;
    }
    public static function keyExists($g2, $ld, $QT = null, $pE = null)
    {
        static::isArray($g2, $QT, $pE);
        if (\array_key_exists($ld, $g2)) {
            goto SGq;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\101\x72\162\141\x79\x20\x64\157\145\x73\x20\156\157\x74\x20\x63\x6f\x6e\164\x61\x69\x6e\40\141\x6e\x20\x65\x6c\145\x6d\x65\156\x74\x20\167\x69\x74\x68\40\x6b\x65\x79\40\x22\x25\163\42"), static::stringify($ld));
        throw static::createException($g2, $QT, static::INVALID_KEY_EXISTS, $pE, array("\x6b\145\x79" => $ld));
        SGq:
        return true;
    }
    public static function keyNotExists($g2, $ld, $QT = null, $pE = null)
    {
        static::isArray($g2, $QT, $pE);
        if (!\array_key_exists($ld, $g2)) {
            goto Wlg;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\101\162\x72\141\171\40\x63\157\156\164\141\151\x6e\163\x20\x61\x6e\x20\x65\x6c\x65\x6d\145\156\164\x20\x77\x69\164\x68\x20\153\x65\171\40\x22\x25\163\42"), static::stringify($ld));
        throw static::createException($g2, $QT, static::INVALID_KEY_NOT_EXISTS, $pE, array("\153\145\171" => $ld));
        Wlg:
        return true;
    }
    public static function keyIsset($g2, $ld, $QT = null, $pE = null)
    {
        static::isArrayAccessible($g2, $QT, $pE);
        if (isset($g2[$ld])) {
            goto FMW;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\x54\x68\145\x20\145\x6c\145\155\x65\x6e\x74\x20\167\x69\164\150\x20\153\145\x79\40\42\45\x73\42\40\x77\141\x73\x20\156\x6f\x74\x20\x66\157\x75\156\x64"), static::stringify($ld));
        throw static::createException($g2, $QT, static::INVALID_KEY_ISSET, $pE, array("\x6b\x65\x79" => $ld));
        FMW:
        return true;
    }
    public static function notEmptyKey($g2, $ld, $QT = null, $pE = null)
    {
        static::keyIsset($g2, $ld, $QT, $pE);
        static::notEmpty($g2[$ld], $QT, $pE);
        return true;
    }
    public static function notBlank($g2, $QT = null, $pE = null)
    {
        if (!(false === $g2 || empty($g2) && "\x30" != $g2 || \is_string($g2) && '' === \trim($g2))) {
            goto Y8T;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\126\x61\x6c\x75\x65\x20\42\x25\x73\42\x20\151\x73\40\142\154\x61\156\x6b\54\40\142\165\x74\x20\x77\141\163\x20\145\x78\160\x65\143\164\145\144\40\164\x6f\40\143\157\156\x74\141\151\156\40\x61\x20\x76\x61\x6c\x75\145\x2e"), static::stringify($g2));
        throw static::createException($g2, $QT, static::INVALID_NOT_BLANK, $pE);
        Y8T:
        return true;
    }
    public static function isInstanceOf($g2, $vw, $QT = null, $pE = null)
    {
        if ($g2 instanceof $vw) {
            goto Jyo;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\103\154\141\163\163\x20\x22\45\x73\42\x20\167\141\x73\x20\145\170\160\145\143\164\145\x64\40\x74\157\40\142\145\x20\151\156\163\164\141\156\143\145\x6f\146\x20\x6f\x66\40\42\x25\163\x22\40\142\165\164\x20\151\163\x20\x6e\157\x74\56"), static::stringify($g2), $vw);
        throw static::createException($g2, $QT, static::INVALID_INSTANCE_OF, $pE, array("\x63\154\141\x73\163" => $vw));
        Jyo:
        return true;
    }
    public static function notIsInstanceOf($g2, $vw, $QT = null, $pE = null)
    {
        if (!$g2 instanceof $vw) {
            goto Ze5;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\x43\x6c\x61\x73\163\40\42\x25\163\42\x20\167\x61\163\x20\x6e\x6f\x74\40\145\x78\160\145\143\x74\145\144\x20\x74\x6f\40\x62\145\x20\151\x6e\x73\x74\x61\156\143\145\x6f\x66\40\x6f\146\x20\42\x25\163\x22\56"), static::stringify($g2), $vw);
        throw static::createException($g2, $QT, static::INVALID_NOT_INSTANCE_OF, $pE, array("\x63\154\x61\163\x73" => $vw));
        Ze5:
        return true;
    }
    public static function subclassOf($g2, $vw, $QT = null, $pE = null)
    {
        if (\is_subclass_of($g2, $vw)) {
            goto gg6;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\x43\154\x61\x73\x73\x20\42\x25\x73\x22\x20\167\x61\x73\40\145\170\x70\x65\143\x74\145\x64\x20\164\157\40\x62\145\40\163\x75\x62\143\x6c\141\x73\x73\x20\x6f\146\40\42\x25\x73\42\56"), static::stringify($g2), $vw);
        throw static::createException($g2, $QT, static::INVALID_SUBCLASS_OF, $pE, array("\x63\154\141\163\163" => $vw));
        gg6:
        return true;
    }
    public static function range($g2, $bB, $Ei, $QT = null, $pE = null)
    {
        static::numeric($g2, $QT, $pE);
        if (!($g2 < $bB || $g2 > $Ei)) {
            goto FqZ;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\116\x75\155\142\x65\162\40\42\x25\163\x22\40\x77\x61\163\x20\145\x78\x70\x65\143\x74\x65\144\40\x74\x6f\40\x62\x65\x20\141\164\40\x6c\145\x61\x73\164\x20\42\x25\x64\42\40\x61\x6e\144\x20\x61\x74\40\x6d\157\x73\164\x20\x22\45\144\42\x2e"), static::stringify($g2), static::stringify($bB), static::stringify($Ei));
        throw static::createException($g2, $QT, static::INVALID_RANGE, $pE, array("\x6d\x69\156" => $bB, "\155\141\170" => $Ei));
        FqZ:
        return true;
    }
    public static function min($g2, $bB, $QT = null, $pE = null)
    {
        static::numeric($g2, $QT, $pE);
        if (!($g2 < $bB)) {
            goto Pay;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\x4e\165\155\142\145\x72\x20\x22\x25\163\42\x20\167\141\163\40\x65\x78\160\145\x63\164\x65\144\40\x74\x6f\x20\142\145\x20\x61\164\x20\154\145\x61\163\x74\40\42\x25\x73\x22\x2e"), static::stringify($g2), static::stringify($bB));
        throw static::createException($g2, $QT, static::INVALID_MIN, $pE, array("\x6d\x69\x6e" => $bB));
        Pay:
        return true;
    }
    public static function max($g2, $Ei, $QT = null, $pE = null)
    {
        static::numeric($g2, $QT, $pE);
        if (!($g2 > $Ei)) {
            goto SOz;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\116\165\155\x62\x65\162\x20\x22\x25\163\x22\40\x77\141\x73\40\145\x78\160\x65\x63\164\145\144\40\164\157\40\142\x65\x20\141\x74\x20\x6d\x6f\163\x74\x20\42\x25\163\42\x2e"), static::stringify($g2), static::stringify($Ei));
        throw static::createException($g2, $QT, static::INVALID_MAX, $pE, array("\155\141\x78" => $Ei));
        SOz:
        return true;
    }
    public static function file($g2, $QT = null, $pE = null)
    {
        static::string($g2, $QT, $pE);
        static::notEmpty($g2, $QT, $pE);
        if (\is_file($g2)) {
            goto iWq;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\x46\151\x6c\x65\40\42\x25\163\42\x20\167\x61\x73\40\145\x78\160\x65\x63\164\x65\144\40\164\157\x20\145\x78\x69\163\164\x2e"), static::stringify($g2));
        throw static::createException($g2, $QT, static::INVALID_FILE, $pE);
        iWq:
        return true;
    }
    public static function directory($g2, $QT = null, $pE = null)
    {
        static::string($g2, $QT, $pE);
        if (\is_dir($g2)) {
            goto IxX;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\x50\x61\164\150\40\x22\x25\163\42\40\x77\x61\163\x20\145\170\160\x65\143\164\x65\x64\40\x74\157\40\x62\145\x20\x61\x20\144\151\162\145\x63\x74\x6f\162\x79\56"), static::stringify($g2));
        throw static::createException($g2, $QT, static::INVALID_DIRECTORY, $pE);
        IxX:
        return true;
    }
    public static function readable($g2, $QT = null, $pE = null)
    {
        static::string($g2, $QT, $pE);
        if (\is_readable($g2)) {
            goto gtQ;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\x50\x61\164\150\x20\42\45\163\42\x20\x77\141\163\40\x65\170\160\145\x63\164\145\x64\x20\164\x6f\40\x62\x65\40\x72\145\x61\x64\x61\142\154\145\x2e"), static::stringify($g2));
        throw static::createException($g2, $QT, static::INVALID_READABLE, $pE);
        gtQ:
        return true;
    }
    public static function writeable($g2, $QT = null, $pE = null)
    {
        static::string($g2, $QT, $pE);
        if (\is_writable($g2)) {
            goto dnw;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\120\x61\x74\150\x20\42\45\x73\x22\x20\167\141\x73\x20\x65\x78\160\x65\143\164\145\144\40\164\157\40\x62\x65\40\x77\162\x69\x74\145\x61\x62\154\145\x2e"), static::stringify($g2));
        throw static::createException($g2, $QT, static::INVALID_WRITEABLE, $pE);
        dnw:
        return true;
    }
    public static function email($g2, $QT = null, $pE = null)
    {
        static::string($g2, $QT, $pE);
        if (!\filter_var($g2, FILTER_VALIDATE_EMAIL)) {
            goto IzW;
        }
        $Li = \substr($g2, \strpos($g2, "\x40") + 1);
        if (!(\version_compare(PHP_VERSION, "\x35\56\63\56\63", "\74") && false === \strpos($Li, "\56"))) {
            goto i3R;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\x56\141\154\x75\145\x20\42\45\x73\x22\40\x77\141\x73\x20\x65\170\x70\145\143\x74\x65\x64\40\164\x6f\x20\x62\145\x20\x61\x20\x76\141\x6c\151\144\40\x65\55\x6d\x61\151\154\40\x61\144\144\162\145\x73\x73\x2e"), static::stringify($g2));
        throw static::createException($g2, $QT, static::INVALID_EMAIL, $pE);
        i3R:
        goto cZj;
        IzW:
        $QT = \sprintf(static::generateMessage($QT ?: "\x56\141\154\x75\145\40\x22\x25\163\x22\x20\x77\x61\163\x20\145\x78\160\x65\x63\164\145\x64\40\x74\x6f\x20\x62\x65\x20\x61\40\x76\141\154\151\x64\40\145\55\x6d\x61\x69\x6c\40\x61\144\x64\x72\x65\x73\163\56"), static::stringify($g2));
        throw static::createException($g2, $QT, static::INVALID_EMAIL, $pE);
        cZj:
        return true;
    }
    public static function url($g2, $QT = null, $pE = null)
    {
        static::string($g2, $QT, $pE);
        $vp = array("\x68\x74\x74\x70", "\150\x74\x74\160\x73");
        $U6 = "\x7e\x5e\xa\x20\x20\40\40\x20\x20\x20\40\x20\40\x20\x20\x28\x25\163\x29\72\x2f\x2f\40\40\40\40\x20\40\40\40\40\40\x20\40\x20\40\40\x20\x20\x20\40\40\40\40\x20\x20\x20\40\40\40\40\40\40\40\40\40\40\40\x20\x23\x20\x70\x72\x6f\164\x6f\143\x6f\154\12\40\x20\x20\40\x20\x20\x20\x20\x20\40\40\40\x28\50\x5b\x5c\x2e\134\160\114\134\160\x4e\55\x5d\53\x3a\51\77\x28\133\x5c\56\x5c\x70\x4c\x5c\160\x4e\55\x5d\x2b\x29\100\51\77\40\40\40\x20\x20\40\40\40\40\x20\43\40\142\x61\163\x69\x63\x20\x61\x75\x74\x68\12\40\40\x20\x20\40\40\40\x20\x20\40\40\40\x28\12\40\x20\x20\40\40\x20\40\40\40\x20\40\x20\x20\x20\x20\40\x28\x5b\134\160\x4c\134\x70\116\134\x70\123\x2d\x5c\56\x5d\51\x2b\50\x5c\x2e\77\50\x5b\134\x70\x4c\x5c\160\x4e\135\174\x78\156\x5c\x2d\x5c\x2d\133\134\x70\114\x5c\x70\x4e\55\x5d\53\x29\53\x5c\x2e\77\51\40\x23\x20\x61\x20\x64\x6f\x6d\141\x69\x6e\x20\x6e\x61\155\x65\xa\x20\x20\40\40\40\x20\x20\40\x20\40\40\x20\40\40\x20\40\x20\40\x20\40\174\40\40\40\x20\40\x20\x20\x20\x20\40\x20\x20\x20\x20\40\40\40\40\x20\x20\x20\x20\x20\40\40\40\x20\40\x20\x20\x20\40\40\40\40\x20\40\x20\40\x20\x20\40\x20\x20\x20\x20\x20\x20\40\x23\40\157\x72\12\40\x20\40\x20\x20\40\40\40\x20\x20\40\40\x20\40\40\40\x5c\x64\x7b\61\x2c\63\x7d\x5c\56\x5c\144\x7b\x31\54\63\175\x5c\x2e\x5c\x64\173\61\54\63\x7d\134\56\134\144\x7b\x31\x2c\63\x7d\40\x20\40\40\40\40\40\x20\40\x20\x20\x20\40\40\x20\x20\40\x20\x20\x20\43\x20\141\x6e\x20\111\120\40\x61\144\x64\162\145\x73\163\12\40\40\40\x20\x20\40\x20\40\40\40\40\x20\40\x20\x20\40\40\x20\x20\40\174\x20\40\40\40\40\x20\x20\40\40\x20\40\x20\40\x20\x20\x20\40\x20\40\x20\40\40\x20\40\40\40\x20\40\40\40\x20\40\40\40\x20\40\x20\40\40\40\40\40\x20\x20\x20\x20\x20\40\x20\43\40\x6f\x72\12\40\40\40\x20\x20\40\x20\40\40\40\40\x20\40\x20\40\40\134\133\xa\40\x20\40\x20\40\40\x20\40\x20\x20\40\x20\40\40\x20\40\x20\40\x20\40\50\77\x3a\x28\x3f\72\x28\x3f\72\50\77\72\50\77\72\50\77\72\50\x3f\72\133\60\x2d\71\x61\x2d\x66\135\x7b\x31\x2c\64\x7d\x29\x29\72\x29\173\66\175\x29\x28\77\x3a\x28\x3f\x3a\50\77\72\50\77\x3a\50\x3f\72\133\60\55\x39\x61\x2d\146\135\x7b\x31\54\64\175\51\51\72\50\77\72\50\77\72\133\x30\x2d\x39\x61\55\x66\135\x7b\x31\x2c\x34\175\51\x29\x29\174\50\77\x3a\50\x3f\x3a\x28\77\x3a\x28\77\x3a\x28\77\72\x32\x35\133\60\x2d\x35\x5d\x7c\50\x3f\72\x5b\61\x2d\71\135\174\61\133\60\x2d\71\x5d\x7c\x32\133\x30\55\64\x5d\51\77\x5b\x30\55\x39\x5d\x29\x29\x5c\x2e\51\173\63\x7d\x28\77\72\x28\x3f\x3a\x32\x35\x5b\60\55\65\x5d\174\x28\x3f\72\133\61\x2d\x39\135\174\61\133\x30\x2d\71\x5d\174\x32\133\x30\x2d\64\x5d\x29\x3f\x5b\60\x2d\x39\x5d\x29\51\x29\x29\51\x29\51\x7c\50\77\72\x28\77\72\x3a\x3a\x28\x3f\72\x28\77\x3a\50\77\72\133\60\x2d\x39\141\x2d\146\x5d\x7b\61\54\x34\x7d\x29\51\x3a\x29\173\x35\175\51\x28\x3f\72\x28\77\x3a\x28\x3f\x3a\x28\x3f\x3a\50\x3f\72\133\60\55\x39\x61\55\146\135\173\x31\54\64\x7d\x29\x29\x3a\50\x3f\72\x28\x3f\x3a\x5b\60\x2d\71\141\55\146\x5d\x7b\x31\x2c\64\x7d\x29\x29\51\174\50\x3f\72\50\x3f\x3a\x28\77\72\50\x3f\72\x28\x3f\72\x32\x35\133\x30\55\x35\x5d\x7c\50\x3f\72\x5b\x31\x2d\x39\135\174\61\133\x30\55\x39\135\x7c\62\x5b\60\55\x34\x5d\51\77\x5b\60\55\71\x5d\x29\51\x5c\56\51\x7b\x33\x7d\x28\77\x3a\50\77\72\x32\65\x5b\x30\55\x35\x5d\x7c\50\77\x3a\133\x31\x2d\x39\135\174\x31\133\60\x2d\x39\x5d\174\62\x5b\60\x2d\64\x5d\51\77\133\60\55\x39\x5d\51\51\x29\51\51\x29\x29\174\x28\77\x3a\x28\77\72\50\x3f\x3a\x28\x3f\x3a\50\77\72\x5b\x30\55\71\x61\55\x66\135\x7b\x31\54\x34\175\51\51\x29\77\x3a\x3a\x28\77\x3a\x28\77\x3a\x28\x3f\x3a\133\x30\55\71\x61\55\x66\135\x7b\61\54\64\x7d\x29\x29\72\x29\173\64\175\x29\x28\77\x3a\x28\77\x3a\x28\x3f\x3a\50\x3f\x3a\50\x3f\x3a\x5b\x30\x2d\71\141\x2d\x66\135\173\x31\x2c\64\x7d\51\51\x3a\50\77\x3a\x28\77\x3a\133\60\55\71\x61\55\x66\135\173\x31\x2c\64\175\x29\51\x29\x7c\50\77\x3a\x28\x3f\72\50\x3f\x3a\x28\77\x3a\x28\x3f\x3a\x32\65\x5b\x30\x2d\65\x5d\174\x28\x3f\x3a\x5b\x31\55\71\135\x7c\61\133\60\55\x39\135\174\x32\133\60\55\x34\x5d\x29\77\x5b\x30\x2d\x39\x5d\x29\x29\134\x2e\51\x7b\x33\x7d\x28\x3f\72\x28\x3f\72\62\x35\x5b\x30\x2d\65\135\x7c\x28\77\72\x5b\x31\55\71\135\x7c\61\x5b\x30\x2d\71\135\x7c\x32\x5b\x30\55\x34\x5d\51\x3f\x5b\x30\x2d\71\x5d\x29\51\51\51\x29\51\x29\174\x28\x3f\x3a\x28\77\x3a\50\77\72\x28\x3f\x3a\x28\77\72\x28\x3f\x3a\133\60\55\x39\141\x2d\146\x5d\173\61\x2c\64\x7d\x29\x29\x3a\51\173\x30\54\61\x7d\x28\77\72\x28\x3f\x3a\x5b\x30\55\71\x61\x2d\x66\x5d\173\x31\54\64\175\x29\51\x29\77\x3a\x3a\50\77\72\50\x3f\x3a\x28\77\72\x5b\x30\x2d\71\141\x2d\146\135\x7b\x31\x2c\64\175\x29\51\72\x29\173\63\175\51\50\77\x3a\50\77\72\50\x3f\72\50\x3f\72\x28\x3f\x3a\133\60\x2d\x39\x61\55\146\135\173\61\x2c\x34\x7d\51\51\72\x28\x3f\72\50\x3f\x3a\133\60\55\x39\x61\x2d\x66\x5d\173\61\54\x34\x7d\51\x29\51\x7c\50\x3f\x3a\x28\77\x3a\50\77\x3a\50\x3f\x3a\50\x3f\72\62\65\133\x30\x2d\65\x5d\174\50\77\x3a\133\x31\55\x39\x5d\174\x31\133\60\x2d\x39\x5d\174\x32\133\x30\55\x34\135\51\x3f\x5b\x30\x2d\x39\x5d\x29\x29\x5c\x2e\51\x7b\x33\x7d\50\77\x3a\50\x3f\x3a\62\65\133\60\x2d\65\135\x7c\50\77\72\x5b\x31\55\x39\135\x7c\61\133\60\55\71\135\174\62\133\60\55\64\x5d\x29\x3f\x5b\60\x2d\71\x5d\51\x29\x29\x29\x29\x29\51\x7c\x28\x3f\x3a\50\x3f\72\x28\77\x3a\50\x3f\x3a\x28\77\x3a\x28\x3f\72\133\x30\55\71\141\55\x66\x5d\x7b\61\54\64\175\x29\51\72\x29\173\60\x2c\x32\175\50\77\72\50\x3f\x3a\x5b\x30\55\71\141\x2d\146\x5d\173\61\x2c\64\175\x29\x29\x29\x3f\x3a\72\x28\x3f\72\50\x3f\72\50\77\72\x5b\60\55\x39\141\55\x66\x5d\x7b\61\x2c\64\x7d\51\x29\72\x29\x7b\62\x7d\51\50\x3f\72\50\77\x3a\x28\x3f\72\x28\x3f\72\x28\77\x3a\x5b\60\55\71\141\55\x66\x5d\173\61\x2c\64\175\x29\51\72\50\x3f\x3a\50\x3f\72\133\60\55\71\141\x2d\146\x5d\x7b\x31\54\64\175\51\51\x29\x7c\x28\77\x3a\50\x3f\72\50\77\72\x28\77\x3a\x28\x3f\x3a\62\65\x5b\60\55\x35\135\x7c\50\77\x3a\x5b\61\55\71\x5d\174\x31\133\x30\55\71\135\174\62\133\x30\x2d\64\135\51\77\x5b\60\x2d\x39\x5d\51\x29\x5c\56\x29\173\x33\175\50\x3f\x3a\x28\x3f\x3a\x32\65\133\x30\55\x35\x5d\x7c\50\77\72\x5b\61\x2d\x39\135\174\61\133\x30\x2d\71\135\174\62\133\x30\55\64\x5d\x29\77\x5b\x30\55\x39\x5d\51\51\x29\51\51\51\51\174\50\x3f\x3a\50\x3f\72\50\77\x3a\x28\77\72\x28\77\72\x28\77\x3a\x5b\60\x2d\71\x61\55\146\x5d\x7b\61\54\x34\x7d\x29\51\72\51\173\x30\54\63\x7d\50\x3f\x3a\50\x3f\72\133\x30\x2d\71\x61\55\x66\x5d\173\61\54\x34\175\x29\x29\x29\77\x3a\x3a\x28\77\x3a\50\77\x3a\133\x30\55\x39\x61\55\146\135\173\x31\54\x34\175\51\51\x3a\51\x28\77\x3a\50\x3f\72\x28\77\x3a\x28\77\72\x28\x3f\72\x5b\x30\55\x39\141\x2d\x66\135\173\61\x2c\x34\175\51\x29\72\50\x3f\72\50\77\72\x5b\x30\55\71\141\x2d\x66\135\173\x31\54\x34\x7d\51\51\51\x7c\50\77\72\x28\x3f\x3a\50\x3f\x3a\x28\x3f\x3a\x28\77\x3a\x32\x35\x5b\x30\x2d\x35\135\174\50\x3f\x3a\133\61\55\x39\x5d\x7c\61\x5b\60\55\x39\135\174\62\133\x30\x2d\64\x5d\51\x3f\133\60\x2d\71\135\x29\x29\134\x2e\x29\x7b\63\175\x28\77\72\50\x3f\72\62\x35\133\x30\55\x35\135\174\x28\x3f\72\x5b\61\55\x39\135\x7c\x31\133\60\55\x39\x5d\174\x32\x5b\60\x2d\x34\135\x29\x3f\x5b\x30\55\x39\135\51\x29\x29\x29\51\x29\x29\174\50\x3f\x3a\x28\77\x3a\x28\x3f\72\x28\77\x3a\x28\x3f\x3a\50\77\72\133\x30\x2d\71\x61\x2d\x66\135\x7b\61\x2c\64\x7d\51\51\72\51\x7b\60\54\x34\175\50\x3f\x3a\x28\x3f\72\x5b\x30\x2d\71\x61\x2d\146\135\173\61\54\64\175\x29\51\51\x3f\72\x3a\51\x28\77\72\50\77\72\x28\77\72\x28\77\72\x28\77\x3a\x5b\x30\55\71\x61\55\x66\x5d\x7b\61\54\x34\175\x29\51\x3a\50\x3f\x3a\x28\77\72\x5b\x30\55\x39\141\x2d\x66\x5d\173\x31\x2c\64\175\51\x29\x29\174\50\77\x3a\50\x3f\72\50\x3f\72\x28\x3f\72\x28\x3f\72\x32\65\x5b\60\55\65\x5d\x7c\50\x3f\x3a\133\x31\55\71\x5d\x7c\61\x5b\x30\55\x39\135\x7c\x32\133\x30\55\64\x5d\x29\x3f\133\x30\55\x39\x5d\x29\51\x5c\x2e\x29\x7b\x33\x7d\x28\77\x3a\50\77\x3a\62\65\x5b\60\x2d\65\135\x7c\50\77\x3a\133\61\x2d\x39\135\174\61\x5b\x30\55\71\x5d\174\x32\x5b\60\55\64\x5d\x29\77\133\x30\55\71\135\51\51\51\x29\x29\x29\51\174\50\77\72\50\x3f\x3a\50\x3f\72\x28\77\x3a\x28\77\72\50\77\72\x5b\60\x2d\x39\x61\55\x66\x5d\173\x31\x2c\64\175\51\x29\72\51\173\x30\x2c\x35\x7d\x28\x3f\x3a\x28\x3f\x3a\133\x30\x2d\71\141\55\146\135\173\x31\x2c\64\175\51\51\51\77\x3a\x3a\51\50\x3f\72\x28\77\72\133\x30\x2d\71\141\55\x66\135\x7b\x31\x2c\64\175\x29\x29\51\174\50\77\x3a\x28\77\72\x28\77\x3a\x28\x3f\x3a\x28\x3f\x3a\50\x3f\x3a\x5b\x30\55\71\141\x2d\x66\135\173\x31\x2c\64\175\51\x29\72\x29\173\x30\54\66\x7d\x28\77\x3a\x28\x3f\72\133\x30\x2d\71\x61\55\146\135\x7b\61\x2c\x34\175\51\51\51\77\x3a\72\x29\51\51\51\xa\x20\40\40\40\40\40\40\x20\40\x20\x20\x20\x20\40\x20\40\134\x5d\x20\40\43\x20\x61\156\x20\x49\x50\x76\x36\x20\x61\144\144\162\145\x73\x73\xa\x20\x20\x20\40\40\x20\x20\x20\x20\x20\x20\x20\x29\xa\x20\x20\40\x20\x20\40\40\x20\40\40\x20\x20\x28\x3a\x5b\60\55\71\135\53\51\x3f\40\x20\x20\40\x20\40\x20\40\x20\40\x20\40\x20\x20\x20\40\40\40\40\40\40\x20\x20\x20\x20\40\40\x20\x20\x20\43\x20\x61\x20\160\x6f\162\164\x20\50\x6f\x70\x74\151\157\x6e\141\x6c\51\xa\x20\40\x20\x20\40\x20\x20\x20\x20\x20\40\40\50\57\x3f\x7c\x2f\134\x53\x2b\174\x5c\77\x5c\123\x2a\x7c\x5c\x23\134\123\x2a\x29\40\x20\x20\x20\40\40\x20\40\x20\40\40\x20\40\40\x20\40\40\40\x20\x23\40\x61\x20\x2f\x2c\x20\x6e\x6f\164\150\x69\x6e\x67\54\40\x61\40\57\40\167\151\164\150\x20\x73\x6f\155\x65\164\150\151\x6e\x67\x2c\x20\x61\x20\x71\x75\145\x72\171\x20\157\162\40\141\40\146\162\x61\x67\155\145\x6e\164\xa\40\x20\40\x20\40\40\x20\40\44\x7e\151\x78\x75";
        $U6 = \sprintf($U6, \implode("\x7c", $vp));
        if (\preg_match($U6, $g2)) {
            goto efF;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\126\x61\x6c\x75\x65\40\42\45\163\42\x20\167\x61\x73\x20\x65\x78\x70\x65\x63\x74\x65\x64\40\x74\x6f\40\x62\145\40\141\40\166\141\x6c\x69\x64\40\125\x52\x4c\40\163\x74\141\x72\164\x69\156\147\40\x77\151\x74\x68\x20\150\164\x74\160\x20\157\162\40\150\164\x74\160\163"), static::stringify($g2));
        throw static::createException($g2, $QT, static::INVALID_URL, $pE);
        efF:
        return true;
    }
    public static function alnum($g2, $QT = null, $pE = null)
    {
        try {
            static::regex($g2, "\x28\x5e\50\x5b\141\x2d\x7a\x41\55\132\x5d\x7b\61\x7d\133\141\55\x7a\x41\x2d\132\60\x2d\71\x5d\52\x29\x24\x29", $QT, $pE);
        } catch (AssertionFailedException $A4) {
            $QT = \sprintf(static::generateMessage($QT ?: "\126\141\x6c\x75\x65\x20\42\x25\163\x22\x20\x69\163\40\x6e\157\x74\x20\x61\154\160\150\141\156\x75\x6d\145\x72\151\x63\54\40\163\x74\x61\x72\164\151\x6e\147\x20\x77\151\164\150\40\154\145\164\164\145\x72\163\40\141\156\x64\40\143\157\x6e\x74\141\x69\x6e\x69\156\x67\x20\157\156\154\x79\40\x6c\145\164\164\x65\x72\x73\40\x61\156\x64\x20\x6e\x75\x6d\142\145\x72\163\56"), static::stringify($g2));
            throw static::createException($g2, $QT, static::INVALID_ALNUM, $pE);
        }
        return true;
    }
    public static function true($g2, $QT = null, $pE = null)
    {
        if (!(true !== $g2)) {
            goto BMV;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\126\x61\x6c\165\145\40\x22\x25\163\42\40\x69\x73\x20\x6e\x6f\164\x20\124\122\125\105\56"), static::stringify($g2));
        throw static::createException($g2, $QT, static::INVALID_TRUE, $pE);
        BMV:
        return true;
    }
    public static function false($g2, $QT = null, $pE = null)
    {
        if (!(false !== $g2)) {
            goto uj2;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\x56\141\154\165\x65\40\42\45\163\42\40\151\163\40\x6e\157\164\40\x46\101\x4c\x53\x45\x2e"), static::stringify($g2));
        throw static::createException($g2, $QT, static::INVALID_FALSE, $pE);
        uj2:
        return true;
    }
    public static function classExists($g2, $QT = null, $pE = null)
    {
        if (\class_exists($g2)) {
            goto UId;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\x43\154\x61\163\x73\40\42\x25\163\42\40\x64\157\145\163\40\156\157\x74\40\145\x78\151\x73\164\56"), static::stringify($g2));
        throw static::createException($g2, $QT, static::INVALID_CLASS, $pE);
        UId:
        return true;
    }
    public static function interfaceExists($g2, $QT = null, $pE = null)
    {
        if (\interface_exists($g2)) {
            goto Rqd;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\x49\156\x74\x65\x72\146\141\x63\145\40\x22\45\163\x22\40\144\x6f\145\x73\40\x6e\x6f\164\40\145\170\x69\163\164\56"), static::stringify($g2));
        throw static::createException($g2, $QT, static::INVALID_INTERFACE, $pE);
        Rqd:
        return true;
    }
    public static function implementsInterface($jN, $Ev, $QT = null, $pE = null)
    {
        $OV = new \ReflectionClass($jN);
        if ($OV->implementsInterface($Ev)) {
            goto oqr;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\103\x6c\x61\163\x73\40\x22\45\x73\42\x20\x64\x6f\145\163\x20\x6e\x6f\164\x20\x69\x6d\160\154\x65\155\x65\156\x74\x20\x69\156\164\x65\x72\146\141\x63\x65\x20\42\x25\163\42\x2e"), static::stringify($jN), static::stringify($Ev));
        throw static::createException($jN, $QT, static::INTERFACE_NOT_IMPLEMENTED, $pE, array("\151\156\x74\145\x72\x66\141\143\145" => $Ev));
        oqr:
        return true;
    }
    public static function isJsonString($g2, $QT = null, $pE = null)
    {
        if (!(null === \json_decode($g2) && JSON_ERROR_NONE !== \json_last_error())) {
            goto BJR;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\x56\141\154\165\x65\x20\42\x25\x73\x22\x20\x69\163\x20\x6e\x6f\x74\40\141\x20\166\141\154\151\144\x20\x4a\123\x4f\x4e\x20\163\164\x72\151\x6e\147\56"), static::stringify($g2));
        throw static::createException($g2, $QT, static::INVALID_JSON_STRING, $pE);
        BJR:
        return true;
    }
    public static function uuid($g2, $QT = null, $pE = null)
    {
        $g2 = \str_replace(array("\x75\162\x6e\x3a", "\165\x75\x69\144\x3a", "\173", "\175"), '', $g2);
        if (!("\x30\60\60\60\x30\60\x30\60\55\60\60\x30\60\x2d\x30\60\60\x30\55\x30\x30\x30\x30\x2d\x30\60\60\x30\x30\x30\x30\x30\x30\60\60\60" === $g2)) {
            goto fxg;
        }
        return true;
        fxg:
        if (\preg_match("\57\136\133\x30\55\71\x41\x2d\106\141\x2d\146\135\173\70\x7d\x2d\133\x30\55\x39\101\x2d\x46\x61\x2d\x66\x5d\x7b\64\175\55\133\x30\x2d\71\101\55\106\141\x2d\x66\x5d\173\64\175\x2d\x5b\x30\x2d\x39\x41\55\106\141\55\x66\x5d\173\x34\175\x2d\133\60\x2d\x39\101\x2d\106\141\x2d\146\135\173\61\62\x7d\44\57", $g2)) {
            goto Po3;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\x56\141\x6c\165\x65\40\42\x25\x73\x22\x20\x69\x73\x20\x6e\x6f\x74\x20\141\40\166\141\154\151\x64\40\x55\125\111\104\56"), static::stringify($g2));
        throw static::createException($g2, $QT, static::INVALID_UUID, $pE);
        Po3:
        return true;
    }
    public static function e164($g2, $QT = null, $pE = null)
    {
        if (\preg_match("\x2f\x5e\134\x2b\x3f\x5b\61\55\x39\135\134\x64\173\x31\x2c\61\x34\175\x24\57", $g2)) {
            goto cL8;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\x56\x61\x6c\165\145\x20\42\x25\x73\42\40\x69\x73\40\x6e\157\164\40\141\x20\166\141\x6c\x69\x64\40\105\61\66\64\56"), static::stringify($g2));
        throw static::createException($g2, $QT, static::INVALID_E164, $pE);
        cL8:
        return true;
    }
    public static function count($ts, $nZ, $QT = null, $pE = null)
    {
        if (!($nZ !== \count($ts))) {
            goto xyh;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\x4c\x69\163\x74\40\x64\157\x65\163\x20\156\157\164\40\x63\x6f\156\164\141\151\x6e\40\x65\x78\x61\x63\x74\x6c\171\40\x25\144\x20\145\x6c\x65\155\x65\x6e\x74\x73\x20\50\x25\x64\x20\x67\x69\166\145\156\x29\56"), static::stringify($nZ), static::stringify(\count($ts)));
        throw static::createException($ts, $QT, static::INVALID_COUNT, $pE, array("\143\x6f\165\156\x74" => $nZ));
        xyh:
        return true;
    }
    public static function __callStatic($R2, $vP)
    {
        if (!(0 === \strpos($R2, "\156\165\x6c\x6c\117\162"))) {
            goto s07;
        }
        if (\array_key_exists(0, $vP)) {
            goto Nun;
        }
        throw new BadMethodCallException("\115\151\x73\163\151\x6e\x67\40\x74\150\x65\x20\x66\x69\x72\163\164\40\141\162\x67\x75\155\x65\156\164\x2e");
        Nun:
        if (!(null === $vP[0])) {
            goto DFq;
        }
        return true;
        DFq:
        $R2 = \substr($R2, 6);
        return \call_user_func_array(array(\get_called_class(), $R2), $vP);
        s07:
        if (!(0 === \strpos($R2, "\141\x6c\154"))) {
            goto xwj;
        }
        if (\array_key_exists(0, $vP)) {
            goto m3K;
        }
        throw new BadMethodCallException("\115\151\163\163\x69\x6e\x67\40\x74\x68\x65\40\x66\151\162\x73\x74\40\x61\162\x67\165\155\145\x6e\x74\56");
        m3K:
        static::isTraversable($vP[0]);
        $R2 = \substr($R2, 3);
        $aq = \array_shift($vP);
        $QM = \get_called_class();
        foreach ($aq as $g2) {
            \call_user_func_array(array($QM, $R2), \array_merge(array($g2), $vP));
            xr4:
        }
        syr:
        return true;
        xwj:
        throw new BadMethodCallException("\x4e\x6f\x20\141\163\163\145\162\x74\x69\157\156\x20\101\163\163\x65\162\x74\x69\x6f\x6e\x23" . $R2 . "\40\x65\x78\151\163\x74\163\56");
    }
    public static function choicesNotEmpty(array $aq, array $JF, $QT = null, $pE = null)
    {
        static::notEmpty($aq, $QT, $pE);
        foreach ($JF as $mI) {
            static::notEmptyKey($aq, $mI, $QT, $pE);
            N0a:
        }
        I1G:
        return true;
    }
    public static function methodExists($g2, $OD, $QT = null, $pE = null)
    {
        static::isObject($OD, $QT, $pE);
        if (\method_exists($OD, $g2)) {
            goto osx;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\105\x78\x70\145\143\164\145\144\x20\x22\x25\x73\42\x20\x64\157\x65\x73\40\156\x6f\x74\x20\145\x78\x69\163\164\40\x69\156\40\x70\x72\x6f\166\151\x64\x65\144\x20\157\142\152\145\x63\x74\x2e"), static::stringify($g2));
        throw static::createException($g2, $QT, static::INVALID_METHOD, $pE, array("\x6f\142\152\145\143\164" => \get_class($OD)));
        osx:
        return true;
    }
    public static function isObject($g2, $QT = null, $pE = null)
    {
        if (\is_object($g2)) {
            goto niW;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\x50\162\157\166\x69\x64\x65\144\x20\x22\45\163\x22\x20\x69\163\40\x6e\x6f\164\40\x61\40\166\x61\x6c\151\x64\40\157\142\152\145\x63\x74\56"), static::stringify($g2));
        throw static::createException($g2, $QT, static::INVALID_OBJECT, $pE);
        niW:
        return true;
    }
    public static function lessThan($g2, $h8, $QT = null, $pE = null)
    {
        if (!($g2 >= $h8)) {
            goto N5G;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\120\162\x6f\x76\x69\x64\x65\x64\x20\42\x25\x73\x22\40\151\163\40\x6e\x6f\x74\x20\154\145\163\x73\40\164\x68\141\x6e\x20\42\45\163\42\56"), static::stringify($g2), static::stringify($h8));
        throw static::createException($g2, $QT, static::INVALID_LESS, $pE, array("\x6c\x69\x6d\x69\x74" => $h8));
        N5G:
        return true;
    }
    public static function lessOrEqualThan($g2, $h8, $QT = null, $pE = null)
    {
        if (!($g2 > $h8)) {
            goto lfJ;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\x50\x72\x6f\166\151\x64\145\x64\40\42\45\x73\42\40\151\x73\40\x6e\157\164\x20\x6c\145\163\163\x20\157\162\40\145\x71\x75\141\x6c\40\164\150\141\x6e\x20\42\x25\x73\x22\56"), static::stringify($g2), static::stringify($h8));
        throw static::createException($g2, $QT, static::INVALID_LESS_OR_EQUAL, $pE, array("\x6c\151\x6d\x69\x74" => $h8));
        lfJ:
        return true;
    }
    public static function greaterThan($g2, $h8, $QT = null, $pE = null)
    {
        if (!($g2 <= $h8)) {
            goto avl;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\x50\162\x6f\166\x69\x64\145\144\x20\42\45\163\x22\40\151\x73\40\x6e\157\164\x20\x67\162\x65\x61\164\x65\162\x20\164\150\141\156\40\x22\45\163\x22\56"), static::stringify($g2), static::stringify($h8));
        throw static::createException($g2, $QT, static::INVALID_GREATER, $pE, array("\x6c\x69\x6d\x69\x74" => $h8));
        avl:
        return true;
    }
    public static function greaterOrEqualThan($g2, $h8, $QT = null, $pE = null)
    {
        if (!($g2 < $h8)) {
            goto JYp;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\120\x72\x6f\166\x69\144\145\144\x20\42\x25\163\42\40\151\x73\40\x6e\x6f\x74\x20\x67\x72\x65\141\x74\145\162\x20\157\162\40\145\161\x75\141\154\40\x74\150\141\156\x20\42\x25\163\x22\56"), static::stringify($g2), static::stringify($h8));
        throw static::createException($g2, $QT, static::INVALID_GREATER_OR_EQUAL, $pE, array("\154\151\x6d\151\164" => $h8));
        JYp:
        return true;
    }
    public static function between($g2, $Qx, $Hs, $QT = null, $pE = null)
    {
        if (!($Qx > $g2 || $g2 > $Hs)) {
            goto wXG;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\x50\x72\157\x76\151\144\x65\144\40\42\x25\x73\x22\40\151\163\40\156\x65\x69\x74\150\x65\162\x20\x67\162\x65\x61\164\145\x72\x20\164\x68\141\x6e\40\157\162\x20\x65\161\x75\x61\154\x20\x74\157\x20\x22\x25\x73\42\x20\x6e\157\162\40\154\x65\x73\163\40\x74\x68\141\156\40\x6f\162\40\145\161\x75\x61\154\40\164\x6f\40\x22\x25\163\42\x2e"), static::stringify($g2), static::stringify($Qx), static::stringify($Hs));
        throw static::createException($g2, $QT, static::INVALID_BETWEEN, $pE, array("\154\157\167\145\x72" => $Qx, "\165\160\160\145\162" => $Hs));
        wXG:
        return true;
    }
    public static function betweenExclusive($g2, $Qx, $Hs, $QT = null, $pE = null)
    {
        if (!($Qx >= $g2 || $g2 >= $Hs)) {
            goto DRw;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\120\162\x6f\166\x69\144\145\x64\40\x22\x25\163\42\x20\x69\x73\x20\x6e\145\x69\164\150\145\162\x20\x67\x72\145\x61\x74\x65\162\40\x74\x68\141\156\40\42\45\x73\42\x20\156\157\x72\x20\x6c\145\x73\163\x20\164\150\141\156\x20\42\45\163\42\x2e"), static::stringify($g2), static::stringify($Qx), static::stringify($Hs));
        throw static::createException($g2, $QT, static::INVALID_BETWEEN_EXCLUSIVE, $pE, array("\x6c\157\x77\145\162" => $Qx, "\x75\160\160\145\162" => $Hs));
        DRw:
        return true;
    }
    public static function extensionLoaded($g2, $QT = null, $pE = null)
    {
        if (\extension_loaded($g2)) {
            goto Nyb;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\x45\170\164\x65\x6e\163\x69\157\156\x20\42\x25\x73\42\x20\x69\163\40\162\x65\x71\x75\151\x72\x65\x64\56"), static::stringify($g2));
        throw static::createException($g2, $QT, static::INVALID_EXTENSION, $pE);
        Nyb:
        return true;
    }
    public static function date($g2, $pN, $QT = null, $pE = null)
    {
        static::string($g2, $QT, $pE);
        static::string($pN, $QT, $pE);
        $sO = \DateTime::createFromFormat("\41" . $pN, $g2);
        if (!(false === $sO || $g2 !== $sO->format($pN))) {
            goto L74;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\104\141\x74\145\40\42\45\x73\42\x20\151\163\40\x69\156\166\x61\154\151\x64\x20\x6f\x72\40\144\157\145\x73\x20\x6e\x6f\x74\x20\155\141\x74\x63\x68\40\x66\157\x72\155\x61\164\40\42\x25\x73\x22\x2e"), static::stringify($g2), static::stringify($pN));
        throw static::createException($g2, $QT, static::INVALID_DATE, $pE, array("\146\x6f\162\155\141\164" => $pN));
        L74:
        return true;
    }
    public static function objectOrClass($g2, $QT = null, $pE = null)
    {
        if (\is_object($g2)) {
            goto wdU;
        }
        static::classExists($g2, $QT, $pE);
        wdU:
        return true;
    }
    public static function propertyExists($g2, $Ws, $QT = null, $pE = null)
    {
        static::objectOrClass($g2);
        if (\property_exists($g2, $Ws)) {
            goto vl5;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\103\x6c\x61\x73\163\x20\42\45\x73\x22\40\144\157\145\163\40\x6e\157\164\40\x68\141\166\x65\40\160\x72\157\x70\x65\x72\164\171\x20\42\x25\x73\42\x2e"), static::stringify($g2), static::stringify($Ws));
        throw static::createException($g2, $QT, static::INVALID_PROPERTY, $pE, array("\x70\x72\x6f\160\145\162\x74\171" => $Ws));
        vl5:
        return true;
    }
    public static function propertiesExist($g2, array $iQ, $QT = null, $pE = null)
    {
        static::objectOrClass($g2);
        static::allString($iQ, $QT, $pE);
        $S4 = array();
        foreach ($iQ as $Ws) {
            if (\property_exists($g2, $Ws)) {
                goto iEp;
            }
            $S4[] = $Ws;
            iEp:
            kVC:
        }
        cpM:
        if (!$S4) {
            goto pDu;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\103\x6c\141\x73\x73\40\42\45\163\x22\x20\x64\x6f\x65\163\x20\156\157\x74\40\150\x61\x76\145\x20\164\x68\145\x73\145\40\160\162\157\x70\145\x72\x74\151\x65\163\x3a\40\x25\x73\x2e"), static::stringify($g2), static::stringify(\implode("\54\40", $S4)));
        throw static::createException($g2, $QT, static::INVALID_PROPERTY, $pE, array("\160\162\157\x70\x65\162\164\151\x65\163" => $iQ));
        pDu:
        return true;
    }
    public static function version($uM, $xJ, $gm, $QT = null, $pE = null)
    {
        static::notEmpty($xJ, "\x76\x65\162\x73\151\x6f\156\103\x6f\x6d\160\x61\162\145\40\x6f\x70\x65\162\141\164\157\x72\40\x69\x73\x20\x72\x65\161\x75\x69\x72\145\x64\40\x61\x6e\144\40\x63\x61\x6e\156\x6f\x74\x20\x62\x65\x20\145\x6d\160\164\171\56");
        if (!(true !== \version_compare($uM, $gm, $xJ))) {
            goto mtY;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\x56\145\x72\163\151\x6f\x6e\40\42\45\163\42\x20\151\x73\x20\156\x6f\x74\40\42\x25\163\42\x20\166\x65\162\x73\151\157\x6e\40\x22\45\x73\42\x2e"), static::stringify($uM), static::stringify($xJ), static::stringify($gm));
        throw static::createException($uM, $QT, static::INVALID_VERSION, $pE, array("\x6f\160\145\162\141\164\x6f\x72" => $xJ, "\x76\145\162\163\151\x6f\x6e" => $gm));
        mtY:
        return true;
    }
    public static function phpVersion($xJ, $sP, $QT = null, $pE = null)
    {
        static::defined("\x50\x48\120\137\126\x45\122\123\111\x4f\116");
        return static::version(PHP_VERSION, $xJ, $sP, $QT, $pE);
    }
    public static function extensionVersion($F9, $xJ, $sP, $QT = null, $pE = null)
    {
        static::extensionLoaded($F9, $QT, $pE);
        return static::version(\phpversion($F9), $xJ, $sP, $QT, $pE);
    }
    public static function isCallable($g2, $QT = null, $pE = null)
    {
        if (\is_callable($g2)) {
            goto Xqt;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\120\162\x6f\166\151\x64\x65\x64\x20\x22\x25\x73\42\x20\151\163\40\156\157\164\40\x61\x20\143\141\x6c\x6c\x61\142\154\145\56"), static::stringify($g2));
        throw static::createException($g2, $QT, static::INVALID_CALLABLE, $pE);
        Xqt:
        return true;
    }
    public static function satisfy($g2, $UE, $QT = null, $pE = null)
    {
        static::isCallable($UE);
        if (!(false === \call_user_func($UE, $g2))) {
            goto Ze0;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\120\x72\x6f\x76\x69\144\145\x64\40\42\x25\163\42\40\x69\163\x20\151\156\x76\x61\154\x69\x64\40\141\143\x63\157\162\144\x69\x6e\147\x20\x74\x6f\40\x63\165\163\164\x6f\x6d\x20\162\x75\154\145\x2e"), static::stringify($g2));
        throw static::createException($g2, $QT, static::INVALID_SATISFY, $pE);
        Ze0:
        return true;
    }
    public static function ip($g2, $r3 = null, $QT = null, $pE = null)
    {
        static::string($g2, $QT, $pE);
        if (\filter_var($g2, FILTER_VALIDATE_IP, $r3)) {
            goto avk;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\x56\141\x6c\165\x65\40\42\x25\163\x22\x20\x77\141\x73\40\x65\x78\x70\x65\143\164\x65\144\x20\164\157\40\x62\145\x20\141\x20\166\x61\154\151\x64\40\x49\120\x20\x61\144\144\x72\145\163\x73\56"), static::stringify($g2));
        throw static::createException($g2, $QT, static::INVALID_IP, $pE, array("\146\x6c\141\147" => $r3));
        avk:
        return true;
    }
    public static function ipv4($g2, $r3 = null, $QT = null, $pE = null)
    {
        static::ip($g2, $r3 | FILTER_FLAG_IPV4, static::generateMessage($QT ?: "\126\141\x6c\x75\x65\x20\42\x25\x73\42\40\x77\x61\163\x20\145\170\x70\145\x63\x74\145\144\x20\x74\x6f\x20\x62\145\40\x61\x20\x76\x61\154\x69\144\x20\x49\120\166\64\x20\141\x64\x64\x72\x65\163\163\56"), $pE);
        return true;
    }
    public static function ipv6($g2, $r3 = null, $QT = null, $pE = null)
    {
        static::ip($g2, $r3 | FILTER_FLAG_IPV6, static::generateMessage($QT ?: "\126\x61\x6c\165\145\40\x22\x25\x73\42\40\x77\x61\x73\x20\145\170\x70\x65\143\164\145\x64\x20\164\157\x20\142\x65\x20\141\x20\x76\141\x6c\151\x64\x20\111\x50\166\x36\40\141\x64\x64\x72\145\x73\x73\56"), $pE);
        return true;
    }
    protected static function stringify($g2)
    {
        $eA = \gettype($g2);
        if (\is_bool($g2)) {
            goto bCI;
        }
        if (\is_scalar($g2)) {
            goto Mve;
        }
        if (\is_array($g2)) {
            goto mun;
        }
        if (\is_object($g2)) {
            goto tOs;
        }
        if (\is_resource($g2)) {
            goto RfQ;
        }
        if (null === $g2) {
            goto xOf;
        }
        goto bnw;
        bCI:
        $eA = $g2 ? "\74\124\122\125\105\76" : "\74\106\x41\x4c\x53\x45\76";
        goto bnw;
        Mve:
        $VK = (string) $g2;
        if (!(\strlen($VK) > 100)) {
            goto y14;
        }
        $VK = \substr($VK, 0, 97) . "\x2e\x2e\x2e";
        y14:
        $eA = $VK;
        goto bnw;
        mun:
        $eA = "\x3c\101\x52\122\x41\131\x3e";
        goto bnw;
        tOs:
        $eA = \get_class($g2);
        goto bnw;
        RfQ:
        $eA = \get_resource_type($g2);
        goto bnw;
        xOf:
        $eA = "\x3c\116\x55\x4c\114\x3e";
        bnw:
        return $eA;
    }
    public static function defined($NT, $QT = null, $pE = null)
    {
        if (\defined($NT)) {
            goto oFE;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\x56\x61\154\x75\145\40\x22\45\x73\x22\40\x65\170\160\145\x63\x74\145\144\40\164\157\40\x62\145\x20\141\x20\x64\x65\x66\151\156\145\144\x20\x63\x6f\x6e\163\164\x61\156\x74\x2e"), $NT);
        throw static::createException($NT, $QT, static::INVALID_CONSTANT, $pE);
        oFE:
        return true;
    }
    public static function base64($g2, $QT = null, $pE = null)
    {
        if (!(false === \base64_decode($g2, true))) {
            goto M6f;
        }
        $QT = \sprintf(static::generateMessage($QT ?: "\126\141\154\x75\x65\40\42\45\163\x22\x20\x69\x73\x20\156\157\164\40\x61\x20\166\x61\154\151\144\40\142\141\163\x65\66\64\40\163\x74\x72\151\156\x67\x2e"), $g2);
        throw static::createException($g2, $QT, static::INVALID_BASE64, $pE);
        M6f:
        return true;
    }
    protected static function generateMessage($QT = null)
    {
        if (!\is_callable($QT)) {
            goto Zc1;
        }
        $Ko = \debug_backtrace(0);
        $vZ = array();
        $OV = new \ReflectionClass($Ko[1]["\143\154\141\x73\x73"]);
        $R2 = $OV->getMethod($Ko[1]["\146\x75\x6e\143\164\x69\157\x6e"]);
        foreach ($R2->getParameters() as $MN => $Nw) {
            if (!("\155\x65\x73\163\141\147\x65" !== $Nw->getName())) {
                goto f7T;
            }
            $vZ[$Nw->getName()] = \array_key_exists($MN, $Ko[1]["\141\x72\147\163"]) ? $Ko[1]["\141\162\147\x73"][$MN] : $Nw->getDefaultValue();
            f7T:
            RRE:
        }
        Bk_:
        $vZ["\72\72\x61\163\x73\x65\x72\x74\151\157\x6e"] = \sprintf("\x25\x73\45\163\45\163", $Ko[1]["\143\154\141\163\163"], $Ko[1]["\x74\x79\x70\x65"], $Ko[1]["\146\165\x6e\x63\164\151\157\156"]);
        $QT = \call_user_func_array($QT, array($vZ));
        Zc1:
        return \is_null($QT) ? null : (string) $QT;
    }
}
