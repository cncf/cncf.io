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
    protected static $exceptionClass = "\101\x73\x73\x65\x72\x74\x5c\111\156\166\x61\x6c\x69\144\101\x72\x67\x75\x6d\x65\156\x74\105\x78\x63\x65\x70\x74\151\157\156";
    protected static function createException($Ka, $AA, $HP, $YT = null, array $zS = array())
    {
        $Ji = static::$exceptionClass;
        return new $Ji($AA, $HP, $YT, $Ka, $zS);
    }
    public static function eq($Ka, $kp, $AA = null, $YT = null)
    {
        if (!($Ka != $kp)) {
            goto HF;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\x56\141\154\165\145\x20\x22\45\x73\42\x20\144\157\145\x73\x20\x6e\157\x74\x20\x65\x71\165\141\154\40\x65\x78\x70\x65\x63\x74\x65\x64\40\166\141\x6c\165\x65\x20\x22\x25\163\42\x2e"), static::stringify($Ka), static::stringify($kp));
        throw static::createException($Ka, $AA, static::INVALID_EQ, $YT, array("\x65\170\160\x65\x63\x74\145\x64" => $kp));
        HF:
        return true;
    }
    public static function same($Ka, $kp, $AA = null, $YT = null)
    {
        if (!($Ka !== $kp)) {
            goto xz;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\x56\x61\x6c\165\145\x20\x22\x25\x73\42\40\x69\x73\40\156\157\x74\x20\x74\x68\x65\40\x73\141\x6d\x65\x20\x61\x73\40\x65\170\160\145\143\x74\145\x64\40\x76\141\x6c\165\x65\40\x22\x25\163\x22\56"), static::stringify($Ka), static::stringify($kp));
        throw static::createException($Ka, $AA, static::INVALID_SAME, $YT, array("\145\170\x70\x65\143\164\x65\x64" => $kp));
        xz:
        return true;
    }
    public static function notEq($OI, $kp, $AA = null, $YT = null)
    {
        if (!($OI == $kp)) {
            goto MK;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\126\x61\154\x75\145\x20\42\45\x73\42\x20\151\163\x20\145\161\165\141\154\x20\x74\157\x20\x65\x78\x70\145\143\164\x65\x64\x20\166\141\154\x75\145\40\42\45\x73\x22\x2e"), static::stringify($OI), static::stringify($kp));
        throw static::createException($OI, $AA, static::INVALID_NOT_EQ, $YT, array("\x65\170\160\145\x63\164\145\144" => $kp));
        MK:
        return true;
    }
    public static function notSame($OI, $kp, $AA = null, $YT = null)
    {
        if (!($OI === $kp)) {
            goto pW;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\x56\x61\154\x75\145\x20\x22\x25\x73\x22\40\151\x73\40\x74\x68\145\x20\x73\141\155\145\40\141\x73\40\x65\170\160\145\x63\164\145\144\40\166\x61\x6c\x75\145\40\42\x25\x73\x22\x2e"), static::stringify($OI), static::stringify($kp));
        throw static::createException($OI, $AA, static::INVALID_NOT_SAME, $YT, array("\x65\x78\x70\145\143\164\145\144" => $kp));
        pW:
        return true;
    }
    public static function notInArray($Ka, array $Je, $AA = null, $YT = null)
    {
        if (!(true === \in_array($Ka, $Je))) {
            goto VP;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\x56\x61\154\165\x65\x20\x22\x25\x73\x22\x20\x69\163\40\151\x6e\40\x67\x69\166\x65\x6e\40\42\45\x73\42\x2e"), static::stringify($Ka), static::stringify($Je));
        throw static::createException($Ka, $AA, static::INVALID_VALUE_IN_ARRAY, $YT, array("\x63\x68\x6f\x69\143\x65\163" => $Je));
        VP:
        return true;
    }
    public static function integer($Ka, $AA = null, $YT = null)
    {
        if (\is_int($Ka)) {
            goto UM;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\x56\x61\154\x75\x65\x20\42\45\163\x22\40\x69\163\x20\156\x6f\164\40\141\x6e\40\x69\x6e\164\x65\147\x65\162\56"), static::stringify($Ka));
        throw static::createException($Ka, $AA, static::INVALID_INTEGER, $YT);
        UM:
        return true;
    }
    public static function float($Ka, $AA = null, $YT = null)
    {
        if (\is_float($Ka)) {
            goto L2;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\x56\x61\154\x75\145\x20\x22\45\x73\42\x20\151\x73\x20\156\157\164\40\x61\40\146\x6c\x6f\x61\x74\56"), static::stringify($Ka));
        throw static::createException($Ka, $AA, static::INVALID_FLOAT, $YT);
        L2:
        return true;
    }
    public static function digit($Ka, $AA = null, $YT = null)
    {
        if (\ctype_digit((string) $Ka)) {
            goto lX;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\x56\x61\x6c\165\x65\40\42\x25\163\x22\40\x69\x73\x20\156\157\164\40\141\40\x64\151\147\x69\164\56"), static::stringify($Ka));
        throw static::createException($Ka, $AA, static::INVALID_DIGIT, $YT);
        lX:
        return true;
    }
    public static function integerish($Ka, $AA = null, $YT = null)
    {
        if (!(\is_resource($Ka) || \is_object($Ka) || \is_bool($Ka) || \is_null($Ka) || \is_array($Ka) || \is_string($Ka) && '' == $Ka || \strval(\intval($Ka)) !== \strval($Ka) && \strval(\intval($Ka)) !== \strval(\ltrim($Ka, "\x30")) && '' !== \strval(\intval($Ka)) && '' !== \strval(\ltrim($Ka, "\60")))) {
            goto GZ;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\126\x61\x6c\165\145\40\42\45\x73\42\40\x69\x73\x20\156\x6f\164\40\141\156\x20\151\x6e\x74\145\147\145\162\40\157\162\x20\141\40\x6e\x75\155\x62\145\162\x20\143\141\x73\164\x61\x62\154\x65\x20\164\x6f\40\x69\156\164\145\147\x65\162\56"), static::stringify($Ka));
        throw static::createException($Ka, $AA, static::INVALID_INTEGERISH, $YT);
        GZ:
        return true;
    }
    public static function boolean($Ka, $AA = null, $YT = null)
    {
        if (\is_bool($Ka)) {
            goto yl;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\x56\x61\154\165\145\40\42\x25\163\x22\40\x69\x73\40\x6e\x6f\x74\40\141\40\x62\x6f\x6f\x6c\x65\x61\156\x2e"), static::stringify($Ka));
        throw static::createException($Ka, $AA, static::INVALID_BOOLEAN, $YT);
        yl:
        return true;
    }
    public static function scalar($Ka, $AA = null, $YT = null)
    {
        if (\is_scalar($Ka)) {
            goto MZ;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\126\141\154\x75\145\x20\42\45\x73\x22\40\151\163\x20\156\157\x74\40\x61\40\x73\143\141\154\141\162\x2e"), static::stringify($Ka));
        throw static::createException($Ka, $AA, static::INVALID_SCALAR, $YT);
        MZ:
        return true;
    }
    public static function notEmpty($Ka, $AA = null, $YT = null)
    {
        if (!empty($Ka)) {
            goto vC;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\126\141\154\x75\x65\x20\x22\x25\163\42\x20\151\x73\x20\x65\x6d\x70\x74\x79\x2c\x20\x62\x75\x74\x20\x6e\x6f\x6e\40\145\x6d\160\164\x79\40\166\141\154\165\x65\x20\x77\x61\163\40\x65\x78\160\x65\143\x74\145\144\56"), static::stringify($Ka));
        throw static::createException($Ka, $AA, static::VALUE_EMPTY, $YT);
        vC:
        return true;
    }
    public static function noContent($Ka, $AA = null, $YT = null)
    {
        if (empty($Ka)) {
            goto bY;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\x56\141\x6c\165\145\x20\x22\45\x73\x22\x20\151\x73\x20\x6e\157\164\x20\x65\x6d\x70\164\x79\54\40\x62\165\x74\40\x65\x6d\x70\x74\171\40\166\141\x6c\x75\x65\x20\167\141\x73\40\x65\x78\x70\x65\143\x74\145\x64\56"), static::stringify($Ka));
        throw static::createException($Ka, $AA, static::VALUE_NOT_EMPTY, $YT);
        bY:
        return true;
    }
    public static function null($Ka, $AA = null, $YT = null)
    {
        if (!(null !== $Ka)) {
            goto jd;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\x56\x61\x6c\165\145\x20\x22\x25\x73\42\x20\151\163\40\156\157\164\x20\x6e\165\x6c\x6c\x2c\40\142\165\164\40\x6e\165\154\154\40\166\141\154\x75\x65\40\167\141\163\40\145\x78\x70\x65\x63\164\145\144\x2e"), static::stringify($Ka));
        throw static::createException($Ka, $AA, static::VALUE_NOT_NULL, $YT);
        jd:
        return true;
    }
    public static function notNull($Ka, $AA = null, $YT = null)
    {
        if (!(null === $Ka)) {
            goto Bf;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\126\141\154\165\x65\40\42\x25\x73\42\40\151\x73\x20\156\x75\x6c\154\54\40\x62\x75\x74\x20\156\157\x6e\x20\x6e\165\154\154\40\166\x61\x6c\165\x65\x20\x77\141\x73\40\145\x78\160\x65\x63\x74\x65\x64\56"), static::stringify($Ka));
        throw static::createException($Ka, $AA, static::VALUE_NULL, $YT);
        Bf:
        return true;
    }
    public static function string($Ka, $AA = null, $YT = null)
    {
        if (\is_string($Ka)) {
            goto ZE;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\126\141\154\165\145\x20\x22\x25\x73\42\x20\x65\170\160\x65\143\164\x65\144\x20\164\157\40\142\145\x20\x73\x74\x72\x69\156\147\x2c\x20\x74\x79\x70\145\40\45\x73\40\147\151\166\145\156\56"), static::stringify($Ka), \gettype($Ka));
        throw static::createException($Ka, $AA, static::INVALID_STRING, $YT);
        ZE:
        return true;
    }
    public static function regex($Ka, $b5, $AA = null, $YT = null)
    {
        static::string($Ka, $AA, $YT);
        if (\preg_match($b5, $Ka)) {
            goto PO;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\x56\141\x6c\165\145\x20\42\x25\163\42\40\144\157\x65\x73\x20\x6e\157\164\x20\155\141\x74\143\150\40\x65\170\x70\x72\x65\163\163\151\157\x6e\56"), static::stringify($Ka));
        throw static::createException($Ka, $AA, static::INVALID_REGEX, $YT, array("\160\x61\x74\164\x65\162\156" => $b5));
        PO:
        return true;
    }
    public static function length($Ka, $bK, $AA = null, $YT = null, $ZU = "\165\x74\146\70")
    {
        static::string($Ka, $AA, $YT);
        if (!(\mb_strlen($Ka, $ZU) !== $bK)) {
            goto qs;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\126\141\x6c\x75\145\x20\x22\x25\x73\42\x20\150\x61\x73\40\x74\157\40\142\145\40\45\144\x20\x65\170\141\x63\x74\x6c\x79\x20\x63\x68\x61\x72\141\143\164\x65\x72\x73\40\154\x6f\x6e\x67\54\40\x62\x75\164\x20\154\x65\156\x67\164\150\40\151\x73\x20\45\144\x2e"), static::stringify($Ka), $bK, \mb_strlen($Ka, $ZU));
        throw static::createException($Ka, $AA, static::INVALID_LENGTH, $YT, array("\154\145\156\147\164\150" => $bK, "\145\156\143\x6f\144\151\156\x67" => $ZU));
        qs:
        return true;
    }
    public static function minLength($Ka, $N2, $AA = null, $YT = null, $ZU = "\x75\x74\x66\x38")
    {
        static::string($Ka, $AA, $YT);
        if (!(\mb_strlen($Ka, $ZU) < $N2)) {
            goto Ep;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\126\x61\154\165\x65\x20\x22\x25\163\42\x20\x69\163\40\x74\157\157\40\163\150\x6f\162\x74\54\40\151\x74\x20\x73\x68\x6f\165\x6c\144\40\x68\141\x76\x65\x20\141\x74\x20\x6c\145\x61\163\164\40\45\144\x20\x63\x68\141\162\141\x63\x74\145\x72\163\54\40\x62\165\164\x20\x6f\x6e\154\x79\40\150\141\x73\40\x25\x64\40\x63\150\141\x72\141\143\164\x65\x72\x73\x2e"), static::stringify($Ka), $N2, \mb_strlen($Ka, $ZU));
        throw static::createException($Ka, $AA, static::INVALID_MIN_LENGTH, $YT, array("\x6d\151\x6e\x5f\x6c\145\156\x67\164\x68" => $N2, "\145\156\x63\157\144\151\x6e\x67" => $ZU));
        Ep:
        return true;
    }
    public static function maxLength($Ka, $zq, $AA = null, $YT = null, $ZU = "\x75\x74\146\x38")
    {
        static::string($Ka, $AA, $YT);
        if (!(\mb_strlen($Ka, $ZU) > $zq)) {
            goto iz;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\126\141\x6c\165\145\40\x22\x25\163\42\40\151\x73\x20\x74\x6f\157\x20\154\x6f\x6e\147\54\40\x69\x74\x20\x73\x68\157\165\154\x64\40\x68\x61\166\x65\40\156\x6f\40\x6d\157\x72\x65\40\x74\x68\x61\x6e\40\x25\144\40\143\x68\x61\162\141\143\164\x65\x72\163\54\x20\x62\165\164\40\150\x61\x73\x20\x25\144\x20\143\x68\x61\162\x61\143\164\x65\x72\x73\56"), static::stringify($Ka), $zq, \mb_strlen($Ka, $ZU));
        throw static::createException($Ka, $AA, static::INVALID_MAX_LENGTH, $YT, array("\155\141\x78\137\x6c\x65\x6e\147\x74\x68" => $zq, "\145\x6e\143\x6f\x64\151\156\147" => $ZU));
        iz:
        return true;
    }
    public static function betweenLength($Ka, $N2, $zq, $AA = null, $YT = null, $ZU = "\165\164\x66\x38")
    {
        static::string($Ka, $AA, $YT);
        static::minLength($Ka, $N2, $AA, $YT, $ZU);
        static::maxLength($Ka, $zq, $AA, $YT, $ZU);
        return true;
    }
    public static function startsWith($u2, $P4, $AA = null, $YT = null, $ZU = "\x75\x74\146\70")
    {
        static::string($u2, $AA, $YT);
        if (!(0 !== \mb_strpos($u2, $P4, null, $ZU))) {
            goto op;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\x56\x61\154\165\145\40\42\x25\x73\x22\x20\x64\157\145\163\40\156\157\x74\x20\x73\164\141\162\164\x20\x77\151\164\150\40\x22\45\163\42\x2e"), static::stringify($u2), static::stringify($P4));
        throw static::createException($u2, $AA, static::INVALID_STRING_START, $YT, array("\x6e\x65\145\x64\x6c\145" => $P4, "\145\156\143\x6f\144\151\156\x67" => $ZU));
        op:
        return true;
    }
    public static function endsWith($u2, $P4, $AA = null, $YT = null, $ZU = "\165\164\x66\70")
    {
        static::string($u2, $AA, $YT);
        $Uk = \mb_strlen($u2, $ZU) - \mb_strlen($P4, $ZU);
        if (!(\mb_strripos($u2, $P4, null, $ZU) !== $Uk)) {
            goto eZ;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\x56\x61\154\165\x65\40\42\x25\x73\42\x20\x64\x6f\145\163\40\156\x6f\x74\40\145\x6e\144\40\167\151\164\150\40\x22\x25\163\x22\56"), static::stringify($u2), static::stringify($P4));
        throw static::createException($u2, $AA, static::INVALID_STRING_END, $YT, array("\x6e\145\x65\144\154\145" => $P4, "\x65\156\143\157\144\x69\x6e\x67" => $ZU));
        eZ:
        return true;
    }
    public static function contains($u2, $P4, $AA = null, $YT = null, $ZU = "\x75\x74\x66\x38")
    {
        static::string($u2, $AA, $YT);
        if (!(false === \mb_strpos($u2, $P4, null, $ZU))) {
            goto Af;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\126\x61\x6c\165\x65\40\x22\x25\x73\x22\x20\x64\x6f\x65\163\40\156\157\164\40\x63\157\156\x74\141\151\x6e\x20\x22\x25\x73\x22\56"), static::stringify($u2), static::stringify($P4));
        throw static::createException($u2, $AA, static::INVALID_STRING_CONTAINS, $YT, array("\156\x65\x65\144\154\145" => $P4, "\145\x6e\143\x6f\x64\x69\x6e\147" => $ZU));
        Af:
        return true;
    }
    public static function choice($Ka, array $Je, $AA = null, $YT = null)
    {
        if (\in_array($Ka, $Je, true)) {
            goto rZ;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\126\x61\x6c\165\x65\40\x22\45\x73\42\40\151\163\x20\x6e\x6f\x74\40\141\x6e\x20\145\x6c\145\x6d\145\x6e\164\x20\x6f\146\x20\164\x68\x65\x20\166\x61\154\151\x64\40\166\141\154\x75\x65\x73\72\40\45\x73"), static::stringify($Ka), \implode("\54\x20", \array_map(array(\get_called_class(), "\x73\x74\x72\x69\x6e\x67\151\x66\x79"), $Je)));
        throw static::createException($Ka, $AA, static::INVALID_CHOICE, $YT, array("\x63\150\x6f\x69\x63\x65\163" => $Je));
        rZ:
        return true;
    }
    public static function inArray($Ka, array $Je, $AA = null, $YT = null)
    {
        return static::choice($Ka, $Je, $AA, $YT);
    }
    public static function numeric($Ka, $AA = null, $YT = null)
    {
        if (\is_numeric($Ka)) {
            goto kd;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\x56\x61\154\165\x65\40\42\45\163\42\x20\x69\x73\x20\156\x6f\x74\x20\156\x75\155\145\162\151\143\56"), static::stringify($Ka));
        throw static::createException($Ka, $AA, static::INVALID_NUMERIC, $YT);
        kd:
        return true;
    }
    public static function isResource($Ka, $AA = null, $YT = null)
    {
        if (\is_resource($Ka)) {
            goto bD;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\126\x61\x6c\165\145\x20\42\x25\163\x22\x20\x69\163\40\156\x6f\x74\40\141\x20\162\145\x73\x6f\x75\x72\143\145\x2e"), static::stringify($Ka));
        throw static::createException($Ka, $AA, static::INVALID_RESOURCE, $YT);
        bD:
        return true;
    }
    public static function isArray($Ka, $AA = null, $YT = null)
    {
        if (\is_array($Ka)) {
            goto lM;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\x56\141\154\165\145\40\42\x25\163\x22\40\x69\163\40\156\x6f\164\x20\141\x6e\40\x61\162\162\141\171\x2e"), static::stringify($Ka));
        throw static::createException($Ka, $AA, static::INVALID_ARRAY, $YT);
        lM:
        return true;
    }
    public static function isTraversable($Ka, $AA = null, $YT = null)
    {
        if (!(!\is_array($Ka) && !$Ka instanceof \Traversable)) {
            goto u7;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\126\141\x6c\x75\145\x20\42\x25\163\x22\40\151\163\x20\156\157\x74\40\x61\156\40\x61\x72\x72\141\x79\x20\141\x6e\x64\40\x64\x6f\145\x73\x20\156\157\164\x20\x69\x6d\160\154\x65\155\x65\x6e\x74\40\124\162\x61\x76\x65\x72\163\141\142\154\145\56"), static::stringify($Ka));
        throw static::createException($Ka, $AA, static::INVALID_TRAVERSABLE, $YT);
        u7:
        return true;
    }
    public static function isArrayAccessible($Ka, $AA = null, $YT = null)
    {
        if (!(!\is_array($Ka) && !$Ka instanceof \ArrayAccess)) {
            goto T0;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\126\141\154\x75\x65\40\42\x25\163\x22\x20\151\x73\40\156\157\164\x20\x61\x6e\40\141\x72\x72\x61\x79\x20\141\x6e\x64\x20\144\157\x65\x73\x20\x6e\x6f\x74\x20\x69\155\x70\154\145\x6d\x65\156\164\40\x41\162\x72\x61\x79\101\143\x63\145\163\x73\56"), static::stringify($Ka));
        throw static::createException($Ka, $AA, static::INVALID_ARRAY_ACCESSIBLE, $YT);
        T0:
        return true;
    }
    public static function keyExists($Ka, $uZ, $AA = null, $YT = null)
    {
        static::isArray($Ka, $AA, $YT);
        if (\array_key_exists($uZ, $Ka)) {
            goto Z2;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\101\162\162\x61\171\40\x64\157\145\x73\40\156\157\x74\x20\x63\x6f\156\164\x61\x69\156\40\x61\x6e\40\x65\154\x65\x6d\x65\x6e\164\40\x77\x69\x74\150\40\153\x65\171\x20\x22\x25\x73\42"), static::stringify($uZ));
        throw static::createException($Ka, $AA, static::INVALID_KEY_EXISTS, $YT, array("\x6b\145\x79" => $uZ));
        Z2:
        return true;
    }
    public static function keyNotExists($Ka, $uZ, $AA = null, $YT = null)
    {
        static::isArray($Ka, $AA, $YT);
        if (!\array_key_exists($uZ, $Ka)) {
            goto g4;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\101\162\x72\141\x79\x20\x63\x6f\x6e\x74\141\151\156\163\x20\x61\156\x20\145\x6c\x65\155\x65\x6e\x74\40\167\151\x74\150\40\153\x65\x79\x20\42\45\x73\42"), static::stringify($uZ));
        throw static::createException($Ka, $AA, static::INVALID_KEY_NOT_EXISTS, $YT, array("\153\x65\x79" => $uZ));
        g4:
        return true;
    }
    public static function keyIsset($Ka, $uZ, $AA = null, $YT = null)
    {
        static::isArrayAccessible($Ka, $AA, $YT);
        if (isset($Ka[$uZ])) {
            goto zY;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\124\x68\x65\x20\145\154\145\x6d\145\x6e\x74\40\x77\151\x74\x68\40\x6b\145\171\40\x22\45\163\42\40\167\141\163\40\156\157\164\x20\146\x6f\x75\x6e\144"), static::stringify($uZ));
        throw static::createException($Ka, $AA, static::INVALID_KEY_ISSET, $YT, array("\x6b\145\171" => $uZ));
        zY:
        return true;
    }
    public static function notEmptyKey($Ka, $uZ, $AA = null, $YT = null)
    {
        static::keyIsset($Ka, $uZ, $AA, $YT);
        static::notEmpty($Ka[$uZ], $AA, $YT);
        return true;
    }
    public static function notBlank($Ka, $AA = null, $YT = null)
    {
        if (!(false === $Ka || empty($Ka) && "\60" != $Ka || \is_string($Ka) && '' === \trim($Ka))) {
            goto c5;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\x56\x61\154\165\x65\40\42\x25\x73\x22\40\x69\x73\x20\x62\x6c\x61\156\x6b\x2c\x20\142\x75\x74\40\167\141\163\40\x65\x78\x70\x65\x63\x74\x65\144\40\x74\x6f\x20\x63\157\x6e\x74\141\151\x6e\40\141\40\x76\x61\154\x75\x65\56"), static::stringify($Ka));
        throw static::createException($Ka, $AA, static::INVALID_NOT_BLANK, $YT);
        c5:
        return true;
    }
    public static function isInstanceOf($Ka, $nW, $AA = null, $YT = null)
    {
        if ($Ka instanceof $nW) {
            goto Go;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\x43\x6c\141\x73\163\40\42\45\163\42\x20\x77\141\163\40\x65\170\160\x65\x63\164\145\144\x20\x74\157\x20\142\145\40\151\156\163\164\141\156\143\145\157\x66\x20\157\x66\40\42\45\163\x22\x20\x62\165\164\40\x69\163\40\156\x6f\164\56"), static::stringify($Ka), $nW);
        throw static::createException($Ka, $AA, static::INVALID_INSTANCE_OF, $YT, array("\x63\154\141\x73\x73" => $nW));
        Go:
        return true;
    }
    public static function notIsInstanceOf($Ka, $nW, $AA = null, $YT = null)
    {
        if (!$Ka instanceof $nW) {
            goto R8;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\x43\154\x61\163\x73\40\x22\45\163\x22\x20\x77\141\x73\x20\x6e\x6f\164\40\x65\x78\x70\145\143\164\145\144\40\164\157\x20\142\x65\40\151\156\163\x74\x61\156\143\x65\x6f\x66\x20\157\x66\x20\x22\x25\x73\x22\56"), static::stringify($Ka), $nW);
        throw static::createException($Ka, $AA, static::INVALID_NOT_INSTANCE_OF, $YT, array("\x63\x6c\141\x73\163" => $nW));
        R8:
        return true;
    }
    public static function subclassOf($Ka, $nW, $AA = null, $YT = null)
    {
        if (\is_subclass_of($Ka, $nW)) {
            goto jA;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\x43\154\x61\x73\x73\x20\x22\x25\163\x22\x20\167\x61\x73\40\x65\x78\160\145\143\164\x65\144\x20\x74\x6f\x20\142\145\x20\x73\165\142\x63\154\141\x73\163\x20\x6f\x66\x20\x22\45\x73\42\56"), static::stringify($Ka), $nW);
        throw static::createException($Ka, $AA, static::INVALID_SUBCLASS_OF, $YT, array("\143\154\x61\163\x73" => $nW));
        jA:
        return true;
    }
    public static function range($Ka, $LC, $Es, $AA = null, $YT = null)
    {
        static::numeric($Ka, $AA, $YT);
        if (!($Ka < $LC || $Ka > $Es)) {
            goto UU;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\x4e\x75\155\x62\145\162\x20\42\x25\x73\x22\40\167\141\x73\40\x65\170\160\x65\143\164\x65\144\40\164\x6f\40\x62\145\40\x61\x74\40\x6c\x65\x61\163\x74\40\42\45\144\42\40\141\156\x64\40\141\x74\40\x6d\157\x73\164\40\42\45\x64\x22\56"), static::stringify($Ka), static::stringify($LC), static::stringify($Es));
        throw static::createException($Ka, $AA, static::INVALID_RANGE, $YT, array("\x6d\x69\x6e" => $LC, "\x6d\x61\x78" => $Es));
        UU:
        return true;
    }
    public static function min($Ka, $LC, $AA = null, $YT = null)
    {
        static::numeric($Ka, $AA, $YT);
        if (!($Ka < $LC)) {
            goto Rd;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\116\165\x6d\x62\x65\x72\40\42\45\x73\x22\40\x77\141\x73\x20\145\x78\160\145\x63\164\145\144\x20\164\157\x20\x62\145\x20\x61\x74\40\154\x65\141\163\x74\40\42\x25\163\x22\x2e"), static::stringify($Ka), static::stringify($LC));
        throw static::createException($Ka, $AA, static::INVALID_MIN, $YT, array("\155\151\156" => $LC));
        Rd:
        return true;
    }
    public static function max($Ka, $Es, $AA = null, $YT = null)
    {
        static::numeric($Ka, $AA, $YT);
        if (!($Ka > $Es)) {
            goto d6;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\116\x75\155\x62\145\x72\x20\x22\x25\x73\x22\x20\x77\141\x73\x20\x65\x78\160\x65\x63\164\x65\144\40\x74\157\x20\142\145\x20\x61\164\40\155\157\x73\x74\40\x22\x25\x73\x22\56"), static::stringify($Ka), static::stringify($Es));
        throw static::createException($Ka, $AA, static::INVALID_MAX, $YT, array("\155\141\x78" => $Es));
        d6:
        return true;
    }
    public static function file($Ka, $AA = null, $YT = null)
    {
        static::string($Ka, $AA, $YT);
        static::notEmpty($Ka, $AA, $YT);
        if (\is_file($Ka)) {
            goto nz;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\x46\151\x6c\145\x20\42\x25\x73\x22\x20\x77\x61\x73\x20\x65\x78\160\x65\143\164\145\x64\x20\x74\157\x20\145\x78\151\x73\x74\x2e"), static::stringify($Ka));
        throw static::createException($Ka, $AA, static::INVALID_FILE, $YT);
        nz:
        return true;
    }
    public static function directory($Ka, $AA = null, $YT = null)
    {
        static::string($Ka, $AA, $YT);
        if (\is_dir($Ka)) {
            goto vb;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\120\x61\164\x68\40\42\x25\x73\x22\x20\167\141\x73\40\145\170\160\x65\143\164\145\144\x20\164\157\40\142\x65\40\x61\x20\144\x69\x72\145\143\164\157\x72\x79\56"), static::stringify($Ka));
        throw static::createException($Ka, $AA, static::INVALID_DIRECTORY, $YT);
        vb:
        return true;
    }
    public static function readable($Ka, $AA = null, $YT = null)
    {
        static::string($Ka, $AA, $YT);
        if (\is_readable($Ka)) {
            goto DN;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\120\x61\164\150\x20\x22\x25\163\42\40\x77\141\163\40\145\x78\160\145\143\164\145\x64\40\164\x6f\x20\142\x65\x20\x72\145\141\144\x61\142\154\145\56"), static::stringify($Ka));
        throw static::createException($Ka, $AA, static::INVALID_READABLE, $YT);
        DN:
        return true;
    }
    public static function writeable($Ka, $AA = null, $YT = null)
    {
        static::string($Ka, $AA, $YT);
        if (\is_writable($Ka)) {
            goto Nw;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\120\141\164\150\x20\42\x25\163\42\x20\x77\x61\163\40\145\x78\160\x65\143\x74\145\x64\40\x74\x6f\x20\x62\145\40\167\162\151\x74\x65\141\142\x6c\x65\x2e"), static::stringify($Ka));
        throw static::createException($Ka, $AA, static::INVALID_WRITEABLE, $YT);
        Nw:
        return true;
    }
    public static function email($Ka, $AA = null, $YT = null)
    {
        static::string($Ka, $AA, $YT);
        if (!\filter_var($Ka, FILTER_VALIDATE_EMAIL)) {
            goto bG;
        }
        $rz = \substr($Ka, \strpos($Ka, "\x40") + 1);
        if (!(\version_compare(PHP_VERSION, "\x35\56\x33\56\x33", "\74") && false === \strpos($rz, "\x2e"))) {
            goto cd;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\x56\141\154\165\145\40\x22\x25\x73\x22\40\x77\141\163\x20\145\170\x70\145\143\x74\145\x64\x20\164\x6f\40\142\145\x20\x61\40\x76\141\x6c\x69\x64\x20\x65\55\x6d\x61\x69\154\40\141\144\144\162\145\x73\x73\56"), static::stringify($Ka));
        throw static::createException($Ka, $AA, static::INVALID_EMAIL, $YT);
        cd:
        goto rK;
        bG:
        $AA = \sprintf(static::generateMessage($AA ?: "\x56\141\154\x75\x65\x20\42\45\163\x22\x20\x77\141\163\x20\x65\x78\x70\x65\x63\x74\145\x64\x20\x74\x6f\x20\x62\x65\x20\141\40\166\141\x6c\151\x64\40\x65\55\155\141\x69\x6c\40\141\x64\x64\x72\x65\x73\163\56"), static::stringify($Ka));
        throw static::createException($Ka, $AA, static::INVALID_EMAIL, $YT);
        rK:
        return true;
    }
    public static function url($Ka, $AA = null, $YT = null)
    {
        static::string($Ka, $AA, $YT);
        $TA = array("\x68\x74\164\x70", "\x68\164\x74\160\163");
        $b5 = "\x7e\x5e\15\12\40\x20\40\40\x20\x20\x20\40\x20\x20\40\x20\50\x25\x73\51\72\x2f\x2f\x20\40\x20\x20\x20\40\40\x20\40\40\40\x20\x20\40\x20\40\x20\40\40\40\x20\x20\x20\40\40\x20\40\40\40\x20\40\x20\x20\40\40\x20\40\43\x20\160\x72\157\x74\x6f\143\157\154\15\xa\40\x20\x20\40\x20\x20\x20\x20\40\x20\40\40\x28\x28\133\x5c\56\134\x70\114\x5c\x70\116\55\x5d\53\x3a\x29\x3f\x28\133\x5c\56\134\160\114\x5c\x70\116\55\x5d\53\51\x40\x29\77\x20\40\x20\x20\x20\x20\x20\40\x20\40\x23\40\x62\141\x73\x69\143\40\x61\x75\164\150\xd\xa\x20\x20\40\x20\x20\x20\40\x20\40\40\x20\x20\x28\xd\xa\x20\40\40\x20\40\x20\40\40\40\x20\x20\40\x20\x20\x20\x20\50\x5b\x5c\x70\x4c\134\160\x4e\134\160\123\x2d\x5c\56\x5d\51\53\50\x5c\x2e\77\x28\133\x5c\x70\x4c\x5c\160\116\x5d\x7c\x78\156\134\x2d\x5c\55\133\134\x70\x4c\134\160\x4e\x2d\135\x2b\x29\x2b\x5c\56\x3f\x29\x20\43\x20\x61\x20\144\x6f\x6d\141\x69\x6e\40\x6e\x61\155\145\xd\12\40\40\40\x20\40\x20\x20\40\40\x20\x20\40\40\x20\40\40\40\x20\40\40\x7c\x20\x20\x20\x20\40\x20\x20\x20\40\40\40\40\x20\x20\x20\x20\40\40\x20\x20\x20\40\x20\40\40\x20\40\40\40\40\x20\x20\x20\40\x20\40\40\x20\40\40\40\40\x20\x20\x20\x20\40\x20\x20\x23\x20\x6f\162\xd\12\x20\40\40\40\x20\x20\x20\40\x20\x20\40\x20\x20\x20\40\40\134\144\x7b\61\54\63\175\134\x2e\x5c\x64\x7b\x31\x2c\x33\x7d\x5c\x2e\x5c\144\x7b\x31\x2c\63\x7d\134\x2e\x5c\144\x7b\x31\x2c\63\x7d\x20\40\x20\40\40\x20\40\40\40\40\40\x20\40\x20\40\x20\40\40\x20\x20\x23\40\x61\156\40\x49\120\40\x61\144\144\162\145\x73\163\15\xa\40\x20\40\x20\x20\x20\40\40\40\x20\x20\x20\40\40\40\40\x20\40\40\40\174\40\40\40\x20\40\40\x20\40\40\x20\40\x20\40\40\x20\x20\40\x20\x20\x20\x20\x20\40\40\x20\40\40\40\x20\x20\x20\40\x20\x20\x20\40\x20\x20\x20\40\40\40\x20\40\x20\40\40\40\x20\43\40\157\x72\xd\xa\40\40\x20\40\x20\x20\40\x20\40\x20\40\x20\x20\40\x20\40\x5c\133\15\xa\40\40\40\40\40\x20\40\x20\x20\40\x20\40\40\x20\x20\x20\40\40\x20\x20\50\77\x3a\x28\77\72\x28\77\x3a\x28\x3f\x3a\50\77\72\50\x3f\72\x28\x3f\x3a\133\60\x2d\x39\x61\x2d\x66\135\x7b\x31\x2c\64\175\x29\51\72\51\x7b\66\175\51\50\77\x3a\x28\77\x3a\x28\x3f\72\x28\x3f\72\x28\x3f\72\133\60\x2d\x39\x61\55\x66\135\173\61\54\64\175\x29\x29\72\50\x3f\x3a\50\x3f\72\x5b\60\x2d\71\x61\x2d\146\x5d\173\61\54\64\175\x29\x29\x29\x7c\x28\x3f\72\50\x3f\x3a\50\x3f\72\x28\77\x3a\x28\77\72\x32\x35\133\x30\55\65\x5d\x7c\50\77\x3a\x5b\x31\55\x39\135\174\x31\133\x30\55\71\135\x7c\x32\x5b\x30\x2d\x34\x5d\x29\77\x5b\60\x2d\x39\x5d\51\x29\134\56\x29\x7b\x33\175\x28\77\x3a\50\77\x3a\x32\x35\x5b\60\x2d\65\x5d\174\x28\x3f\x3a\133\x31\55\x39\135\x7c\61\x5b\60\55\x39\x5d\174\62\133\x30\55\x34\x5d\51\x3f\x5b\x30\x2d\71\135\x29\x29\51\51\x29\51\x29\x7c\50\77\x3a\50\x3f\x3a\72\x3a\50\x3f\72\50\x3f\72\x28\x3f\x3a\133\x30\55\71\141\x2d\146\x5d\x7b\x31\x2c\64\x7d\x29\x29\x3a\51\x7b\x35\x7d\x29\x28\x3f\x3a\50\77\72\50\x3f\x3a\x28\77\72\x28\x3f\x3a\133\x30\55\71\x61\x2d\x66\x5d\173\x31\x2c\64\175\x29\51\72\50\77\72\x28\77\72\133\x30\55\x39\x61\x2d\146\x5d\x7b\61\x2c\64\x7d\x29\51\x29\174\x28\77\72\50\77\x3a\50\x3f\x3a\50\77\72\x28\77\72\x32\x35\x5b\60\55\65\x5d\x7c\50\x3f\x3a\x5b\x31\55\x39\x5d\174\61\133\x30\x2d\x39\135\174\62\133\x30\x2d\x34\135\51\x3f\x5b\x30\55\x39\135\51\x29\134\56\51\173\x33\x7d\x28\77\72\50\77\72\62\x35\x5b\x30\x2d\x35\135\x7c\50\x3f\72\x5b\61\x2d\x39\x5d\174\x31\133\x30\x2d\71\135\x7c\62\x5b\x30\x2d\64\x5d\x29\x3f\133\x30\x2d\x39\x5d\x29\x29\51\51\x29\51\x29\174\50\77\x3a\x28\77\72\50\x3f\72\x28\x3f\x3a\50\x3f\72\133\x30\55\71\141\55\x66\135\173\61\54\x34\175\51\x29\x29\x3f\x3a\72\x28\77\72\x28\x3f\72\x28\77\72\x5b\x30\55\x39\x61\x2d\x66\x5d\173\61\x2c\64\x7d\51\x29\x3a\51\173\x34\175\51\x28\x3f\72\x28\x3f\x3a\50\x3f\72\50\77\72\x28\77\72\133\x30\x2d\x39\x61\x2d\146\x5d\x7b\61\54\x34\175\x29\x29\72\x28\x3f\72\x28\77\x3a\133\60\x2d\x39\x61\x2d\x66\135\x7b\x31\x2c\x34\x7d\51\x29\51\x7c\x28\x3f\72\x28\77\x3a\x28\77\x3a\50\77\72\50\77\x3a\x32\x35\x5b\60\x2d\x35\x5d\x7c\x28\x3f\72\x5b\x31\x2d\x39\135\x7c\x31\x5b\x30\x2d\x39\135\174\x32\x5b\x30\55\64\135\x29\77\x5b\60\55\x39\135\x29\x29\x5c\56\x29\x7b\x33\x7d\50\77\72\x28\77\x3a\x32\65\x5b\x30\x2d\x35\x5d\x7c\50\x3f\72\x5b\x31\55\71\x5d\x7c\x31\133\60\x2d\x39\x5d\174\x32\133\60\x2d\64\135\x29\x3f\x5b\60\x2d\x39\135\x29\51\x29\51\x29\51\x29\174\50\77\72\50\77\72\50\77\x3a\x28\x3f\x3a\50\x3f\x3a\x28\x3f\72\133\x30\x2d\x39\x61\55\x66\135\173\61\54\x34\x7d\x29\51\x3a\51\x7b\x30\x2c\61\175\50\77\x3a\x28\x3f\72\133\60\x2d\x39\141\55\146\135\x7b\x31\54\64\x7d\x29\x29\51\77\x3a\72\x28\77\72\50\x3f\x3a\x28\x3f\72\x5b\x30\x2d\71\141\55\x66\135\x7b\61\54\64\x7d\x29\51\72\x29\173\63\175\x29\50\77\72\50\77\x3a\50\77\72\50\77\72\x28\77\72\x5b\60\x2d\71\x61\x2d\146\135\x7b\x31\54\x34\x7d\51\x29\72\50\77\72\50\x3f\x3a\x5b\60\55\x39\x61\x2d\x66\x5d\173\x31\54\64\x7d\x29\51\51\174\50\77\72\50\77\x3a\50\77\x3a\x28\77\x3a\x28\x3f\72\x32\65\133\x30\55\x35\135\174\x28\77\x3a\133\x31\55\71\x5d\x7c\x31\x5b\x30\x2d\x39\135\174\x32\133\x30\x2d\x34\135\x29\x3f\133\x30\55\x39\135\x29\x29\134\56\x29\x7b\x33\x7d\x28\77\x3a\50\77\x3a\62\x35\133\60\55\x35\x5d\174\x28\x3f\72\133\61\x2d\71\135\174\x31\133\x30\55\x39\135\x7c\62\x5b\60\x2d\x34\135\51\x3f\x5b\x30\x2d\x39\135\x29\x29\x29\51\x29\51\x29\174\50\x3f\72\x28\x3f\72\50\77\x3a\50\77\72\50\77\72\x28\x3f\72\133\60\x2d\71\x61\55\146\135\x7b\61\54\x34\x7d\x29\51\x3a\51\x7b\60\54\62\x7d\50\77\x3a\x28\77\72\x5b\x30\x2d\71\141\55\146\135\173\61\54\64\175\x29\51\x29\x3f\72\x3a\50\x3f\x3a\50\77\x3a\50\77\72\x5b\x30\x2d\71\x61\55\146\x5d\173\x31\54\64\175\x29\51\72\51\x7b\62\175\51\x28\77\72\50\x3f\x3a\x28\77\72\x28\77\72\50\77\x3a\x5b\x30\55\71\x61\x2d\146\135\173\x31\54\x34\x7d\51\x29\72\x28\x3f\72\x28\x3f\x3a\x5b\60\55\71\x61\x2d\x66\135\173\61\x2c\x34\x7d\51\51\51\174\50\77\72\x28\77\x3a\x28\77\x3a\50\x3f\72\x28\x3f\72\x32\x35\x5b\x30\55\65\x5d\174\50\77\x3a\x5b\x31\55\x39\135\x7c\x31\133\x30\55\71\x5d\x7c\62\x5b\x30\55\64\135\x29\x3f\133\x30\55\71\x5d\x29\51\134\56\x29\x7b\63\175\x28\77\72\x28\x3f\x3a\62\65\133\x30\x2d\65\135\x7c\50\x3f\x3a\133\x31\55\71\x5d\x7c\61\x5b\60\55\71\135\174\62\x5b\x30\x2d\64\x5d\51\x3f\x5b\60\x2d\71\x5d\51\51\51\51\51\51\51\174\x28\x3f\72\50\x3f\72\x28\x3f\72\50\77\72\50\x3f\72\50\x3f\x3a\x5b\x30\55\71\x61\55\146\x5d\173\61\x2c\x34\x7d\51\51\72\51\x7b\60\54\63\x7d\50\77\x3a\50\x3f\x3a\x5b\x30\x2d\71\141\55\x66\135\x7b\x31\54\64\175\x29\51\51\x3f\x3a\x3a\x28\x3f\72\50\77\x3a\133\x30\55\71\x61\x2d\146\135\x7b\x31\x2c\64\x7d\51\x29\72\51\x28\x3f\x3a\x28\77\x3a\x28\x3f\72\x28\77\x3a\x28\x3f\x3a\x5b\x30\55\71\141\55\x66\x5d\x7b\x31\54\64\x7d\x29\51\72\x28\x3f\x3a\50\x3f\x3a\133\x30\55\71\141\x2d\x66\135\173\x31\x2c\x34\175\51\x29\x29\x7c\50\x3f\x3a\50\x3f\72\x28\x3f\72\50\77\72\x28\x3f\x3a\x32\x35\133\x30\55\x35\x5d\x7c\x28\77\x3a\x5b\x31\55\x39\135\x7c\x31\x5b\x30\x2d\x39\x5d\x7c\62\x5b\x30\55\x34\135\x29\x3f\x5b\x30\55\71\135\51\x29\x5c\56\x29\173\63\x7d\50\77\72\50\x3f\72\62\x35\x5b\x30\x2d\x35\135\x7c\50\77\72\133\61\x2d\x39\135\x7c\61\x5b\60\55\71\x5d\x7c\x32\x5b\60\55\x34\135\x29\x3f\133\60\x2d\x39\135\x29\51\51\x29\x29\x29\51\x7c\50\x3f\72\50\x3f\x3a\x28\x3f\72\50\77\72\50\x3f\x3a\x28\77\x3a\133\60\x2d\71\141\55\146\x5d\173\x31\54\x34\175\51\x29\x3a\51\173\x30\54\x34\175\x28\77\72\50\77\x3a\133\60\55\x39\141\x2d\146\135\173\x31\54\x34\x7d\51\51\51\77\x3a\x3a\51\x28\x3f\72\x28\x3f\72\50\x3f\72\50\77\x3a\50\77\72\x5b\60\55\x39\x61\x2d\146\x5d\x7b\61\54\x34\x7d\x29\51\72\50\77\72\x28\x3f\x3a\x5b\60\x2d\71\141\55\146\135\x7b\61\54\64\175\51\x29\51\x7c\50\x3f\x3a\x28\x3f\72\50\x3f\x3a\50\x3f\72\50\x3f\72\x32\x35\133\60\55\65\x5d\174\x28\77\x3a\x5b\x31\x2d\x39\x5d\174\61\133\x30\55\71\135\x7c\62\133\x30\x2d\x34\135\x29\x3f\x5b\x30\x2d\71\x5d\51\x29\x5c\56\x29\173\63\175\x28\x3f\x3a\x28\77\72\62\x35\133\x30\55\65\x5d\174\x28\77\72\x5b\61\55\x39\x5d\174\x31\133\x30\x2d\71\x5d\174\x32\x5b\x30\55\x34\135\51\x3f\133\x30\55\x39\135\x29\x29\x29\x29\51\x29\51\174\x28\x3f\72\x28\77\72\x28\77\72\50\77\x3a\50\77\x3a\50\77\72\x5b\x30\55\71\x61\x2d\x66\x5d\x7b\61\54\64\x7d\x29\51\72\51\173\60\x2c\65\175\x28\77\72\x28\77\x3a\133\60\x2d\x39\x61\x2d\x66\x5d\173\x31\54\64\175\x29\x29\x29\77\72\x3a\x29\x28\x3f\72\x28\x3f\72\x5b\x30\x2d\x39\141\x2d\x66\135\x7b\x31\54\64\x7d\51\x29\51\174\50\77\x3a\50\77\x3a\x28\77\x3a\x28\x3f\72\x28\77\x3a\50\x3f\72\x5b\x30\x2d\x39\141\55\x66\135\x7b\x31\x2c\x34\x7d\x29\51\72\x29\173\x30\x2c\66\175\x28\77\72\50\77\72\x5b\60\x2d\71\141\x2d\146\x5d\x7b\x31\54\x34\175\x29\x29\51\x3f\72\72\x29\x29\51\x29\xd\12\x20\40\x20\40\40\40\x20\40\40\40\x20\40\40\40\x20\x20\x5c\135\x20\x20\x23\40\x61\156\40\x49\120\x76\66\x20\x61\x64\x64\x72\145\x73\x73\xd\xa\x20\x20\x20\x20\x20\40\x20\40\40\40\40\40\x29\15\xa\40\x20\x20\x20\40\x20\40\x20\40\40\40\40\x28\72\x5b\x30\55\x39\x5d\x2b\51\x3f\40\40\x20\40\x20\40\40\40\40\40\x20\x20\x20\x20\x20\40\x20\40\x20\x20\40\x20\40\x20\40\40\40\40\40\x20\x23\40\x61\40\160\157\162\164\x20\50\157\160\164\x69\157\156\x61\x6c\x29\xd\xa\x20\x20\40\40\x20\40\x20\x20\40\x20\40\40\50\57\x3f\x7c\x2f\134\x53\x2b\174\x5c\77\134\123\52\x7c\134\x23\x5c\x53\x2a\51\x20\40\x20\x20\40\40\40\40\x20\40\40\x20\x20\x20\x20\40\x20\x20\x20\x23\40\141\x20\57\54\x20\x6e\157\x74\150\151\156\x67\x2c\x20\141\40\57\x20\167\x69\164\x68\40\x73\x6f\155\145\164\x68\x69\156\x67\54\x20\x61\40\161\165\x65\x72\x79\x20\157\x72\x20\x61\x20\x66\162\x61\147\x6d\145\x6e\x74\15\12\40\40\x20\x20\x20\40\40\40\44\176\x69\170\x75";
        $b5 = \sprintf($b5, \implode("\x7c", $TA));
        if (\preg_match($b5, $Ka)) {
            goto hA;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\x56\x61\154\165\145\x20\x22\x25\x73\x22\40\167\141\x73\x20\x65\170\x70\x65\x63\164\x65\144\40\164\157\40\x62\x65\x20\141\40\x76\x61\154\x69\x64\40\125\x52\x4c\40\163\x74\x61\x72\x74\151\156\x67\x20\x77\x69\x74\x68\40\x68\x74\164\x70\x20\157\x72\x20\150\x74\164\160\163"), static::stringify($Ka));
        throw static::createException($Ka, $AA, static::INVALID_URL, $YT);
        hA:
        return true;
    }
    public static function alnum($Ka, $AA = null, $YT = null)
    {
        try {
            static::regex($Ka, "\50\x5e\x28\133\x61\55\172\x41\55\132\x5d\x7b\61\175\133\x61\55\172\101\55\132\x30\55\71\135\x2a\51\x24\x29", $AA, $YT);
        } catch (AssertionFailedException $LR) {
            $AA = \sprintf(static::generateMessage($AA ?: "\x56\x61\154\165\x65\x20\x22\x25\x73\42\40\x69\163\x20\x6e\157\164\x20\x61\154\x70\x68\x61\156\165\155\x65\x72\151\x63\x2c\40\x73\x74\x61\x72\164\x69\x6e\147\x20\x77\x69\x74\x68\40\x6c\x65\164\x74\x65\162\x73\40\141\156\144\x20\143\157\156\x74\141\151\x6e\x69\156\x67\x20\x6f\x6e\154\x79\40\x6c\x65\x74\164\x65\162\x73\40\x61\x6e\x64\40\156\x75\155\x62\x65\162\163\56"), static::stringify($Ka));
            throw static::createException($Ka, $AA, static::INVALID_ALNUM, $YT);
        }
        return true;
    }
    public static function true($Ka, $AA = null, $YT = null)
    {
        if (!(true !== $Ka)) {
            goto YO;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\x56\141\x6c\165\x65\x20\42\45\163\x22\40\x69\163\40\x6e\157\164\40\x54\x52\x55\x45\x2e"), static::stringify($Ka));
        throw static::createException($Ka, $AA, static::INVALID_TRUE, $YT);
        YO:
        return true;
    }
    public static function false($Ka, $AA = null, $YT = null)
    {
        if (!(false !== $Ka)) {
            goto vy;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\x56\x61\x6c\x75\x65\x20\x22\x25\163\42\40\x69\x73\x20\156\x6f\x74\40\x46\x41\x4c\x53\x45\56"), static::stringify($Ka));
        throw static::createException($Ka, $AA, static::INVALID_FALSE, $YT);
        vy:
        return true;
    }
    public static function classExists($Ka, $AA = null, $YT = null)
    {
        if (\class_exists($Ka)) {
            goto iR;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\103\154\141\163\x73\x20\x22\45\163\42\40\144\157\x65\163\40\x6e\157\x74\x20\x65\170\x69\x73\x74\56"), static::stringify($Ka));
        throw static::createException($Ka, $AA, static::INVALID_CLASS, $YT);
        iR:
        return true;
    }
    public static function interfaceExists($Ka, $AA = null, $YT = null)
    {
        if (\interface_exists($Ka)) {
            goto dU;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\x49\x6e\164\x65\162\146\x61\143\x65\x20\x22\x25\163\42\40\144\157\145\x73\x20\156\157\164\x20\145\x78\151\x73\x74\x2e"), static::stringify($Ka));
        throw static::createException($Ka, $AA, static::INVALID_INTERFACE, $YT);
        dU:
        return true;
    }
    public static function implementsInterface($So, $rY, $AA = null, $YT = null)
    {
        $V7 = new \ReflectionClass($So);
        if ($V7->implementsInterface($rY)) {
            goto E2;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\103\x6c\141\163\163\x20\x22\x25\x73\x22\x20\x64\157\x65\x73\40\156\x6f\x74\x20\151\155\160\154\145\155\145\156\164\x20\151\156\x74\145\x72\x66\141\x63\x65\x20\42\x25\163\x22\56"), static::stringify($So), static::stringify($rY));
        throw static::createException($So, $AA, static::INTERFACE_NOT_IMPLEMENTED, $YT, array("\151\156\x74\x65\162\146\141\x63\145" => $rY));
        E2:
        return true;
    }
    public static function isJsonString($Ka, $AA = null, $YT = null)
    {
        if (!(null === \json_decode($Ka) && JSON_ERROR_NONE !== \json_last_error())) {
            goto EO;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\126\141\154\165\145\40\42\45\163\42\x20\x69\x73\x20\156\x6f\164\x20\x61\x20\x76\x61\154\x69\144\x20\112\123\x4f\x4e\40\163\164\162\x69\156\x67\x2e"), static::stringify($Ka));
        throw static::createException($Ka, $AA, static::INVALID_JSON_STRING, $YT);
        EO:
        return true;
    }
    public static function uuid($Ka, $AA = null, $YT = null)
    {
        $Ka = \str_replace(array("\x75\162\x6e\72", "\x75\x75\151\144\72", "\x7b", "\175"), '', $Ka);
        if (!("\x30\x30\x30\60\60\60\x30\60\x2d\x30\60\x30\x30\x2d\60\60\x30\60\55\60\60\x30\60\x2d\60\60\x30\x30\x30\x30\60\x30\60\60\x30\x30" === $Ka)) {
            goto es;
        }
        return true;
        es:
        if (\preg_match("\x2f\x5e\133\60\x2d\x39\101\55\106\141\55\146\x5d\x7b\x38\x7d\x2d\x5b\60\55\71\x41\55\106\x61\55\146\135\x7b\x34\175\55\133\x30\55\x39\x41\55\x46\141\x2d\x66\135\173\x34\x7d\x2d\133\x30\55\x39\x41\55\x46\141\x2d\146\x5d\173\64\175\x2d\x5b\x30\x2d\x39\101\55\106\141\x2d\146\135\173\x31\x32\x7d\x24\x2f", $Ka)) {
            goto rf;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\x56\141\154\165\145\40\x22\45\163\42\40\151\x73\40\156\157\x74\x20\x61\40\166\x61\154\151\144\x20\125\125\x49\104\56"), static::stringify($Ka));
        throw static::createException($Ka, $AA, static::INVALID_UUID, $YT);
        rf:
        return true;
    }
    public static function e164($Ka, $AA = null, $YT = null)
    {
        if (\preg_match("\x2f\x5e\134\53\77\133\61\55\x39\x5d\134\x64\173\61\x2c\x31\x34\175\x24\x2f", $Ka)) {
            goto V1;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\x56\141\x6c\x75\145\x20\42\x25\163\x22\x20\x69\x73\40\x6e\157\x74\x20\141\40\x76\x61\x6c\x69\144\x20\x45\61\66\x34\56"), static::stringify($Ka));
        throw static::createException($Ka, $AA, static::INVALID_E164, $YT);
        V1:
        return true;
    }
    public static function count($Xu, $RS, $AA = null, $YT = null)
    {
        if (!($RS !== \count($Xu))) {
            goto ND;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\114\151\163\x74\x20\144\157\145\163\x20\x6e\x6f\x74\x20\143\157\156\x74\x61\x69\156\40\145\x78\x61\143\164\154\x79\x20\45\x64\40\x65\154\x65\155\x65\156\164\163\x20\50\x25\x64\x20\147\x69\x76\x65\156\51\56"), static::stringify($RS), static::stringify(\count($Xu)));
        throw static::createException($Xu, $AA, static::INVALID_COUNT, $YT, array("\143\x6f\165\x6e\x74" => $RS));
        ND:
        return true;
    }
    public static function __callStatic($Vp, $Gf)
    {
        if (!(0 === \strpos($Vp, "\x6e\165\154\x6c\x4f\162"))) {
            goto uW;
        }
        if (\array_key_exists(0, $Gf)) {
            goto eX;
        }
        throw new BadMethodCallException("\115\151\163\x73\151\x6e\147\x20\x74\150\x65\40\x66\x69\162\163\164\40\x61\162\147\x75\x6d\x65\156\x74\56");
        eX:
        if (!(null === $Gf[0])) {
            goto Qd;
        }
        return true;
        Qd:
        $Vp = \substr($Vp, 6);
        return \call_user_func_array(array(\get_called_class(), $Vp), $Gf);
        uW:
        if (!(0 === \strpos($Vp, "\141\154\x6c"))) {
            goto mi;
        }
        if (\array_key_exists(0, $Gf)) {
            goto gQ;
        }
        throw new BadMethodCallException("\115\151\x73\163\x69\x6e\x67\x20\x74\150\145\x20\146\x69\x72\163\164\40\141\162\147\x75\155\145\156\x74\56");
        gQ:
        static::isTraversable($Gf[0]);
        $Vp = \substr($Vp, 3);
        $rd = \array_shift($Gf);
        $n7 = \get_called_class();
        foreach ($rd as $Ka) {
            \call_user_func_array(array($n7, $Vp), \array_merge(array($Ka), $Gf));
            fB:
        }
        Q4:
        return true;
        mi:
        throw new BadMethodCallException("\x4e\x6f\40\x61\x73\x73\x65\x72\x74\x69\x6f\156\x20\x41\163\x73\145\162\164\151\x6f\156\x23" . $Vp . "\40\x65\x78\151\163\164\x73\56");
    }
    public static function choicesNotEmpty(array $rd, array $Je, $AA = null, $YT = null)
    {
        static::notEmpty($rd, $AA, $YT);
        foreach ($Je as $oo) {
            static::notEmptyKey($rd, $oo, $AA, $YT);
            oc:
        }
        ig:
        return true;
    }
    public static function methodExists($Ka, $GE, $AA = null, $YT = null)
    {
        static::isObject($GE, $AA, $YT);
        if (\method_exists($GE, $Ka)) {
            goto zO;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\x45\170\160\145\143\x74\145\x64\40\42\45\x73\42\x20\144\x6f\x65\163\x20\x6e\x6f\164\40\x65\x78\x69\163\x74\x20\x69\x6e\x20\160\x72\157\166\151\144\x65\144\40\157\x62\152\145\143\x74\56"), static::stringify($Ka));
        throw static::createException($Ka, $AA, static::INVALID_METHOD, $YT, array("\x6f\x62\152\x65\x63\164" => \get_class($GE)));
        zO:
        return true;
    }
    public static function isObject($Ka, $AA = null, $YT = null)
    {
        if (\is_object($Ka)) {
            goto DU;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\x50\x72\157\166\x69\x64\x65\x64\40\42\x25\x73\x22\x20\151\163\40\156\157\x74\40\141\40\166\x61\x6c\x69\144\x20\x6f\x62\x6a\145\143\x74\x2e"), static::stringify($Ka));
        throw static::createException($Ka, $AA, static::INVALID_OBJECT, $YT);
        DU:
        return true;
    }
    public static function lessThan($Ka, $Nf, $AA = null, $YT = null)
    {
        if (!($Ka >= $Nf)) {
            goto eQ;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\x50\162\x6f\x76\151\144\145\144\40\x22\45\x73\42\x20\151\x73\40\x6e\x6f\x74\x20\x6c\x65\x73\x73\x20\x74\150\x61\x6e\x20\x22\x25\163\42\x2e"), static::stringify($Ka), static::stringify($Nf));
        throw static::createException($Ka, $AA, static::INVALID_LESS, $YT, array("\x6c\x69\155\x69\164" => $Nf));
        eQ:
        return true;
    }
    public static function lessOrEqualThan($Ka, $Nf, $AA = null, $YT = null)
    {
        if (!($Ka > $Nf)) {
            goto hI;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\x50\162\x6f\x76\x69\144\145\144\x20\x22\45\x73\x22\40\151\x73\40\156\x6f\x74\x20\x6c\x65\x73\x73\x20\157\162\x20\145\161\x75\x61\154\40\x74\x68\x61\x6e\40\x22\45\x73\42\x2e"), static::stringify($Ka), static::stringify($Nf));
        throw static::createException($Ka, $AA, static::INVALID_LESS_OR_EQUAL, $YT, array("\x6c\151\155\x69\x74" => $Nf));
        hI:
        return true;
    }
    public static function greaterThan($Ka, $Nf, $AA = null, $YT = null)
    {
        if (!($Ka <= $Nf)) {
            goto DA;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\x50\162\157\x76\x69\144\x65\144\40\42\45\x73\42\x20\x69\x73\x20\156\157\164\x20\147\x72\145\x61\164\145\162\40\164\x68\x61\156\x20\x22\45\163\42\56"), static::stringify($Ka), static::stringify($Nf));
        throw static::createException($Ka, $AA, static::INVALID_GREATER, $YT, array("\154\151\x6d\x69\164" => $Nf));
        DA:
        return true;
    }
    public static function greaterOrEqualThan($Ka, $Nf, $AA = null, $YT = null)
    {
        if (!($Ka < $Nf)) {
            goto zl;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\x50\162\157\166\x69\144\145\144\40\x22\45\x73\42\x20\151\x73\x20\x6e\x6f\164\x20\x67\x72\145\141\x74\145\x72\40\x6f\x72\40\145\161\x75\141\x6c\x20\x74\x68\141\x6e\x20\42\x25\163\x22\x2e"), static::stringify($Ka), static::stringify($Nf));
        throw static::createException($Ka, $AA, static::INVALID_GREATER_OR_EQUAL, $YT, array("\x6c\x69\x6d\x69\x74" => $Nf));
        zl:
        return true;
    }
    public static function between($Ka, $HA, $bg, $AA = null, $YT = null)
    {
        if (!($HA > $Ka || $Ka > $bg)) {
            goto Xp;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\x50\162\157\x76\x69\x64\145\144\x20\42\x25\163\42\x20\151\163\x20\156\x65\x69\x74\x68\x65\162\x20\x67\x72\x65\x61\164\145\x72\40\164\150\141\x6e\x20\157\x72\40\x65\161\165\x61\x6c\40\164\157\40\x22\45\163\x22\x20\x6e\157\x72\x20\x6c\145\163\x73\x20\164\x68\x61\x6e\x20\157\162\x20\145\x71\x75\x61\154\x20\x74\157\x20\42\x25\163\x22\56"), static::stringify($Ka), static::stringify($HA), static::stringify($bg));
        throw static::createException($Ka, $AA, static::INVALID_BETWEEN, $YT, array("\154\x6f\167\x65\x72" => $HA, "\165\x70\160\x65\162" => $bg));
        Xp:
        return true;
    }
    public static function betweenExclusive($Ka, $HA, $bg, $AA = null, $YT = null)
    {
        if (!($HA >= $Ka || $Ka >= $bg)) {
            goto l8;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\x50\162\157\166\151\144\145\144\x20\x22\45\x73\42\x20\x69\163\40\x6e\x65\151\164\x68\145\162\x20\147\162\x65\x61\164\x65\162\x20\x74\150\x61\156\x20\x22\45\163\42\40\x6e\x6f\162\x20\x6c\145\x73\x73\40\164\150\141\156\40\x22\x25\163\42\56"), static::stringify($Ka), static::stringify($HA), static::stringify($bg));
        throw static::createException($Ka, $AA, static::INVALID_BETWEEN_EXCLUSIVE, $YT, array("\x6c\157\167\145\x72" => $HA, "\x75\160\x70\145\x72" => $bg));
        l8:
        return true;
    }
    public static function extensionLoaded($Ka, $AA = null, $YT = null)
    {
        if (\extension_loaded($Ka)) {
            goto aK;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\x45\x78\164\145\x6e\x73\151\157\x6e\40\x22\45\x73\42\x20\x69\x73\40\162\x65\x71\165\151\162\145\x64\56"), static::stringify($Ka));
        throw static::createException($Ka, $AA, static::INVALID_EXTENSION, $YT);
        aK:
        return true;
    }
    public static function date($Ka, $AK, $AA = null, $YT = null)
    {
        static::string($Ka, $AA, $YT);
        static::string($AK, $AA, $YT);
        $F2 = \DateTime::createFromFormat("\x21" . $AK, $Ka);
        if (!(false === $F2 || $Ka !== $F2->format($AK))) {
            goto wV;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\104\x61\164\145\40\42\x25\x73\42\40\x69\x73\40\151\156\166\x61\154\x69\x64\x20\x6f\x72\x20\x64\x6f\145\163\40\x6e\157\x74\x20\x6d\x61\164\143\150\40\x66\157\162\x6d\x61\164\x20\42\x25\x73\42\56"), static::stringify($Ka), static::stringify($AK));
        throw static::createException($Ka, $AA, static::INVALID_DATE, $YT, array("\x66\157\x72\155\x61\164" => $AK));
        wV:
        return true;
    }
    public static function objectOrClass($Ka, $AA = null, $YT = null)
    {
        if (\is_object($Ka)) {
            goto aV;
        }
        static::classExists($Ka, $AA, $YT);
        aV:
        return true;
    }
    public static function propertyExists($Ka, $qO, $AA = null, $YT = null)
    {
        static::objectOrClass($Ka);
        if (\property_exists($Ka, $qO)) {
            goto Cu;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\103\154\141\163\x73\x20\42\x25\x73\42\40\x64\157\x65\x73\x20\x6e\157\x74\x20\150\141\166\145\x20\160\x72\x6f\160\145\x72\x74\x79\40\42\45\163\x22\x2e"), static::stringify($Ka), static::stringify($qO));
        throw static::createException($Ka, $AA, static::INVALID_PROPERTY, $YT, array("\x70\x72\x6f\x70\x65\162\164\x79" => $qO));
        Cu:
        return true;
    }
    public static function propertiesExist($Ka, array $g1, $AA = null, $YT = null)
    {
        static::objectOrClass($Ka);
        static::allString($g1, $AA, $YT);
        $bR = array();
        foreach ($g1 as $qO) {
            if (\property_exists($Ka, $qO)) {
                goto uI;
            }
            $bR[] = $qO;
            uI:
            dC:
        }
        ht:
        if (!$bR) {
            goto pB;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\x43\x6c\x61\x73\x73\x20\42\45\163\42\40\x64\157\145\163\x20\156\157\x74\40\150\141\166\145\40\x74\150\x65\x73\145\40\x70\162\x6f\160\145\x72\164\x69\x65\x73\x3a\x20\45\x73\56"), static::stringify($Ka), static::stringify(\implode("\54\x20", $bR)));
        throw static::createException($Ka, $AA, static::INVALID_PROPERTY, $YT, array("\x70\162\157\x70\x65\x72\x74\151\145\x73" => $g1));
        pB:
        return true;
    }
    public static function version($eW, $Ub, $J7, $AA = null, $YT = null)
    {
        static::notEmpty($Ub, "\x76\145\x72\x73\x69\x6f\x6e\103\157\x6d\x70\141\162\145\x20\x6f\x70\x65\x72\141\164\157\x72\40\151\163\x20\x72\145\161\165\151\x72\x65\144\40\141\156\144\40\143\x61\156\156\x6f\164\40\x62\x65\x20\x65\x6d\160\164\171\x2e");
        if (!(true !== \version_compare($eW, $J7, $Ub))) {
            goto p7;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\x56\x65\x72\163\x69\157\156\x20\x22\45\163\x22\x20\x69\x73\x20\x6e\157\164\40\42\45\x73\42\40\166\145\162\x73\x69\x6f\156\40\42\45\x73\42\56"), static::stringify($eW), static::stringify($Ub), static::stringify($J7));
        throw static::createException($eW, $AA, static::INVALID_VERSION, $YT, array("\157\160\x65\x72\141\x74\x6f\162" => $Ub, "\166\x65\x72\163\151\x6f\x6e" => $J7));
        p7:
        return true;
    }
    public static function phpVersion($Ub, $Lc, $AA = null, $YT = null)
    {
        static::defined("\120\x48\x50\x5f\126\105\x52\x53\111\117\116");
        return static::version(PHP_VERSION, $Ub, $Lc, $AA, $YT);
    }
    public static function extensionVersion($rF, $Ub, $Lc, $AA = null, $YT = null)
    {
        static::extensionLoaded($rF, $AA, $YT);
        return static::version(\phpversion($rF), $Ub, $Lc, $AA, $YT);
    }
    public static function isCallable($Ka, $AA = null, $YT = null)
    {
        if (\is_callable($Ka)) {
            goto QJ;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\x50\162\157\166\x69\144\x65\x64\x20\x22\45\x73\x22\x20\151\163\40\156\x6f\x74\40\x61\x20\143\141\154\x6c\x61\142\154\x65\x2e"), static::stringify($Ka));
        throw static::createException($Ka, $AA, static::INVALID_CALLABLE, $YT);
        QJ:
        return true;
    }
    public static function satisfy($Ka, $xr, $AA = null, $YT = null)
    {
        static::isCallable($xr);
        if (!(false === \call_user_func($xr, $Ka))) {
            goto gB;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\x50\162\157\x76\151\x64\145\x64\x20\x22\x25\163\x22\x20\x69\x73\x20\x69\x6e\166\x61\x6c\x69\x64\40\x61\143\143\157\x72\144\x69\156\x67\x20\x74\157\40\143\165\x73\x74\157\155\x20\x72\x75\154\x65\x2e"), static::stringify($Ka));
        throw static::createException($Ka, $AA, static::INVALID_SATISFY, $YT);
        gB:
        return true;
    }
    public static function ip($Ka, $xG = null, $AA = null, $YT = null)
    {
        static::string($Ka, $AA, $YT);
        if (\filter_var($Ka, FILTER_VALIDATE_IP, $xG)) {
            goto mY;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\126\141\154\165\145\40\42\45\x73\x22\40\x77\141\163\x20\145\170\x70\145\143\x74\145\144\x20\164\x6f\40\142\145\x20\x61\x20\x76\141\x6c\x69\144\x20\x49\x50\x20\141\144\144\x72\145\163\163\x2e"), static::stringify($Ka));
        throw static::createException($Ka, $AA, static::INVALID_IP, $YT, array("\x66\154\141\147" => $xG));
        mY:
        return true;
    }
    public static function ipv4($Ka, $xG = null, $AA = null, $YT = null)
    {
        static::ip($Ka, $xG | FILTER_FLAG_IPV4, static::generateMessage($AA ?: "\x56\x61\x6c\x75\145\40\x22\x25\163\42\40\167\x61\x73\x20\x65\x78\x70\x65\143\164\145\144\40\x74\157\x20\142\145\x20\x61\40\x76\x61\154\x69\x64\40\x49\x50\166\64\40\141\x64\x64\162\145\x73\x73\x2e"), $YT);
        return true;
    }
    public static function ipv6($Ka, $xG = null, $AA = null, $YT = null)
    {
        static::ip($Ka, $xG | FILTER_FLAG_IPV6, static::generateMessage($AA ?: "\x56\141\x6c\165\x65\x20\x22\x25\x73\x22\x20\x77\x61\x73\x20\x65\170\160\x65\143\164\x65\144\x20\164\157\40\142\x65\40\141\40\x76\141\x6c\151\144\40\111\120\x76\x36\x20\x61\144\x64\x72\x65\x73\163\x2e"), $YT);
        return true;
    }
    protected static function stringify($Ka)
    {
        $TJ = \gettype($Ka);
        if (\is_bool($Ka)) {
            goto Ex;
        }
        if (\is_scalar($Ka)) {
            goto bM;
        }
        if (\is_array($Ka)) {
            goto J4;
        }
        if (\is_object($Ka)) {
            goto tA;
        }
        if (\is_resource($Ka)) {
            goto K8;
        }
        if (null === $Ka) {
            goto tV;
        }
        goto kA;
        Ex:
        $TJ = $Ka ? "\74\124\x52\125\105\76" : "\x3c\106\x41\x4c\123\x45\x3e";
        goto kA;
        bM:
        $JK = (string) $Ka;
        if (!(\strlen($JK) > 100)) {
            goto NB;
        }
        $JK = \substr($JK, 0, 97) . "\x2e\x2e\x2e";
        NB:
        $TJ = $JK;
        goto kA;
        J4:
        $TJ = "\x3c\101\x52\x52\x41\131\76";
        goto kA;
        tA:
        $TJ = \get_class($Ka);
        goto kA;
        K8:
        $TJ = \get_resource_type($Ka);
        goto kA;
        tV:
        $TJ = "\x3c\116\x55\114\x4c\x3e";
        kA:
        return $TJ;
    }
    public static function defined($Rb, $AA = null, $YT = null)
    {
        if (\defined($Rb)) {
            goto yG;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\126\141\x6c\165\x65\x20\42\x25\163\42\40\145\x78\x70\x65\x63\x74\x65\144\x20\x74\157\40\142\x65\40\x61\x20\144\x65\x66\x69\156\x65\144\40\143\157\x6e\x73\x74\x61\156\164\56"), $Rb);
        throw static::createException($Rb, $AA, static::INVALID_CONSTANT, $YT);
        yG:
        return true;
    }
    public static function base64($Ka, $AA = null, $YT = null)
    {
        if (!(false === \base64_decode($Ka, true))) {
            goto Oy;
        }
        $AA = \sprintf(static::generateMessage($AA ?: "\126\x61\154\165\145\40\x22\45\163\x22\40\x69\x73\40\x6e\157\x74\x20\x61\x20\166\141\154\151\144\40\x62\x61\x73\145\x36\64\x20\163\x74\162\151\x6e\147\56"), $Ka);
        throw static::createException($Ka, $AA, static::INVALID_BASE64, $YT);
        Oy:
        return true;
    }
    protected static function generateMessage($AA = null)
    {
        if (!\is_callable($AA)) {
            goto Oz;
        }
        $Bo = \debug_backtrace(0);
        $nj = array();
        $V7 = new \ReflectionClass($Bo[1]["\143\x6c\x61\163\x73"]);
        $Vp = $V7->getMethod($Bo[1]["\x66\x75\x6e\x63\164\x69\x6f\156"]);
        foreach ($Vp->getParameters() as $JS => $k2) {
            if (!("\155\145\x73\x73\141\147\145" !== $k2->getName())) {
                goto q_;
            }
            $nj[$k2->getName()] = \array_key_exists($JS, $Bo[1]["\141\x72\x67\x73"]) ? $Bo[1]["\141\162\x67\163"][$JS] : $k2->getDefaultValue();
            q_:
            dx:
        }
        ID:
        $nj["\x3a\x3a\141\163\163\145\x72\x74\x69\x6f\156"] = \sprintf("\45\163\x25\163\x25\163", $Bo[1]["\143\x6c\x61\x73\x73"], $Bo[1]["\x74\171\x70\x65"], $Bo[1]["\x66\x75\x6e\x63\x74\151\157\156"]);
        $AA = \call_user_func_array($AA, array($nj));
        Oz:
        return \is_null($AA) ? null : (string) $AA;
    }
}
