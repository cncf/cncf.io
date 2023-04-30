'use strict';

/** ShortPixel: Changed punycode to sp_punycode in order to prevent possible conflicts with other WP plugins that use punycode
 *              Also moved all the functions inside the sp_punycode const for the same reason and changed const's to let's */

// 5.0 Deprecated ** Let's see if the modern world works without this **/ 
var sp_punycode = function(){

    /** Highest positive signed 32-bit float value */
    var maxInt = 2147483647; // aka. 0x7FFFFFFF or 2^31-1

    /** Bootstring parameters */
    var base = 36;
    var tMin = 1;
    var tMax = 26;
    var skew = 38;
    var damp = 700;
    var initialBias = 72;
    var initialN = 128; // 0x80
    var delimiter = '-'; // '\x2D'

    /** Regular expressions */
    var regexPunycode = /^xn--/;
    var regexNonASCII = /[^\0-\x7E]/; // non-ASCII chars
    var regexSeparators = /[\x2E\u3002\uFF0E\uFF61]/g; // RFC 3490 separators

    /** Error messages */
    var errors = {
            'overflow': 'Overflow: input needs wider integers to process',
            'not-basic': 'Illegal input >= 0x80 (not a basic code point)',
            'invalid-input': 'Invalid input'
    };

    /** Convenience shortcuts */
    var baseMinusTMin = base - tMin;
    var floor = Math.floor;
    var stringFromCharCode = String.fromCharCode;

    /*--------------------------------------------------------------------------*/

    /**
     * A generic error utility function.
     * @private
     * @param {String} type The error type.
     * @returns {Error} Throws a `RangeError` with the applicable error message.
     */
    function error(type) {
            throw new RangeError(errors[type]);
    }

    /**
     * A generic `Array#map` utility function.
     * @private
     * @param {Array} array The array to iterate over.
     * @param {Function} callback The function that gets called for every array
     * item.
     * @returns {Array} A new array of values returned by the callback function.
     */
    function map(array, fn) {
            var result = [];
            var length = array.length;
            while (length--) {
                    result[length] = fn(array[length]);
            }
            return result;
    }

    /**
     * A simple `Array#map`-like wrapper to work with domain name strings or email
     * addresses.
     * @private
     * @param {String} domain The domain name or email address.
     * @param {Function} callback The function that gets called for every
     * character.
     * @returns {Array} A new string of characters returned by the callback
     * function.
     */
    function mapDomain(string, fn) {
            var parts = string.split('@');
            var result = '';
            if (parts.length > 1) {
                    // In email addresses, only the domain name should be punycoded. Leave
                    // the local part (i.e. everything up to `@`) intact.
                    result = parts[0] + '@';
                    string = parts[1];
            }
            // Avoid `split(regex)` for IE8 compatibility. See #17.
            string = string.replace(regexSeparators, '\x2E');
            var labels = string.split('.');
            var encoded = map(labels, fn).join('.');
            return result + encoded;
    }

    /**
     * Creates an array containing the numeric code points of each Unicode
     * character in the string. While JavaScript uses UCS-2 internally,
     * this function will convert a pair of surrogate halves (each of which
     * UCS-2 exposes as separate characters) into a single code point,
     * matching UTF-16.
     * @see `punycode.ucs2.encode`
     * @see <https://mathiasbynens.be/notes/javascript-encoding>
     * @memberOf punycode.ucs2
     * @name decode
     * @param {String} string The Unicode input string (UCS-2).
     * @returns {Array} The new array of code points.
     */
    function ucs2decode(string) {
            var output = [];
            var counter = 0;
            var length = string.length;
            while (counter < length) {
                    var value = string.charCodeAt(counter++);
                    if (value >= 0xD800 && value <= 0xDBFF && counter < length) {
                            // It's a high surrogate, and there is a next character.
                            var extra = string.charCodeAt(counter++);
                            if ((extra & 0xFC00) == 0xDC00) { // Low surrogate.
                                    output.push(((value & 0x3FF) << 10) + (extra & 0x3FF) + 0x10000);
                            } else {
                                    // It's an unmatched surrogate; only append this code unit, in case the
                                    // next code unit is the high surrogate of a surrogate pair.
                                    output.push(value);
                                    counter--;
                            }
                    } else {
                            output.push(value);
                    }
            }
            return output;
    }

    /**
     * Creates a string based on an array of numeric code points.
     * @see `punycode.ucs2.decode`
     * @memberOf punycode.ucs2
     * @name encode
     * @param {Array} codePoints The array of numeric code points.
     * @returns {String} The new Unicode string (UCS-2).
     */
    //const ucs2encode = array => String.fromCodePoint(...array);
    var ucs2encode = array => String.fromCodePoint.prototype.apply(null, array);

    /**
     * Converts a basic code point into a digit/integer.
     * @see `digitToBasic()`
     * @private
     * @param {Number} codePoint The basic numeric code point value.
     * @returns {Number} The numeric value of a basic code point (for use in
     * representing integers) in the range `0` to `base - 1`, or `base` if
     * the code point does not represent a value.
     */
    var basicToDigit = function(codePoint) {
            if (codePoint - 0x30 < 0x0A) {
                    return codePoint - 0x16;
            }
            if (codePoint - 0x41 < 0x1A) {
                    return codePoint - 0x41;
            }
            if (codePoint - 0x61 < 0x1A) {
                    return codePoint - 0x61;
            }
            return base;
    };

    /**
     * Converts a digit/integer into a basic code point.
     * @see `basicToDigit()`
     * @private
     * @param {Number} digit The numeric value of a basic code point.
     * @returns {Number} The basic code point whose value (when used for
     * representing integers) is `digit`, which needs to be in the range
     * `0` to `base - 1`. If `flag` is non-zero, the uppercase form is
     * used; else, the lowercase form is used. The behavior is undefined
     * if `flag` is non-zero and `digit` has no uppercase form.
     */
    var digitToBasic = function(digit, flag) {
            //  0..25 map to ASCII a..z or A..Z
            // 26..35 map to ASCII 0..9
            return digit + 22 + 75 * (digit < 26) - ((flag != 0) << 5);
    };

    /**
     * Bias adaptation function as per section 3.4 of RFC 3492.
     * https://tools.ietf.org/html/rfc3492#section-3.4
     * @private
     */
    var adapt = function(delta, numPoints, firstTime) {
            var k = 0;
            delta = firstTime ? floor(delta / damp) : delta >> 1;
            delta += floor(delta / numPoints);
            for (/* no initialization */; delta > baseMinusTMin * tMax >> 1; k += base) {
                    delta = floor(delta / baseMinusTMin);
            }
            return floor(k + (baseMinusTMin + 1) * delta / (delta + skew));
    };

    /**
     * Converts a Punycode string of ASCII-only symbols to a string of Unicode
     * symbols.
     * @memberOf punycode
     * @param {String} input The Punycode string of ASCII-only symbols.
     * @returns {String} The resulting string of Unicode symbols.
     */
    var decode = function(input) {
            // Don't use UCS-2.
            var output = [];
            var inputLength = input.length;
            var i = 0;
            var n = initialN;
            var bias = initialBias;

            // Handle the basic code points: let `basic` be the number of input code
            // points before the last delimiter, or `0` if there is none, then copy
            // the first basic code points to the output.

            var basic = input.lastIndexOf(delimiter);
            if (basic < 0) {
                    basic = 0;
            }

            for (var j = 0; j < basic; ++j) {
                    // if it's not a basic code point
                    if (input.charCodeAt(j) >= 0x80) {
                            error('not-basic');
                    }
                    output.push(input.charCodeAt(j));
            }

            // Main decoding loop: start just after the last delimiter if any basic code
            // points were copied; start at the beginning otherwise.

            for (var index = basic > 0 ? basic + 1 : 0; index < inputLength; /* no final expression */) {

                    // `index` is the index of the next character to be consumed.
                    // Decode a generalized variable-length integer into `delta`,
                    // which gets added to `i`. The overflow checking is easier
                    // if we increase `i` as we go, then subtract off its starting
                    // value at the end to obtain `delta`.
                    var oldi = i;
                    for (var w = 1, k = base; /* no condition */; k += base) {

                            if (index >= inputLength) {
                                    error('invalid-input');
                            }

                            var digit = basicToDigit(input.charCodeAt(index++));

                            if (digit >= base || digit > floor((maxInt - i) / w)) {
                                    error('overflow');
                            }

                            i += digit * w;
                            var t = k <= bias ? tMin : (k >= bias + tMax ? tMax : k - bias);

                            if (digit < t) {
                                    break;
                            }

                            var baseMinusT = base - t;
                            if (w > floor(maxInt / baseMinusT)) {
                                    error('overflow');
                            }

                            w *= baseMinusT;

                    }

                    var out = output.length + 1;
                    bias = adapt(i - oldi, out, oldi == 0);

                    // `i` was supposed to wrap around from `out` to `0`,
                    // incrementing `n` each time, so we'll fix that now:
                    if (floor(i / out) > maxInt - n) {
                            error('overflow');
                    }

                    n += floor(i / out);
                    i %= out;

                    // Insert `n` at position `i` of the output.
                    output.splice(i++, 0, n);

            }

            //return String.fromCodePoint(...output);
            return String.fromCodePoint.prototype.apply(null, output);
    };

    /**
     * Converts a string of Unicode symbols (e.g. a domain name label) to a
     * Punycode string of ASCII-only symbols.
     * @memberOf punycode
     * @param {String} input The string of Unicode symbols.
     * @returns {String} The resulting Punycode string of ASCII-only symbols.
     */
    var encode = function(input) {
            var output = [];

            // Convert the input in UCS-2 to an array of Unicode code points.
            input = ucs2decode(input);

            // Cache the length.
            var inputLength = input.length;

            // Initialize the state.
            var n = initialN;
            var delta = 0;
            var bias = initialBias;

            // Handle the basic code points.
            for (var currentValue of input) {
                    if (currentValue < 0x80) {
                            output.push(stringFromCharCode(currentValue));
                    }
            }

            var basicLength = output.length;
            var handledCPCount = basicLength;

            // `handledCPCount` is the number of code points that have been handled;
            // `basicLength` is the number of basic code points.

            // Finish the basic string with a delimiter unless it's empty.
            if (basicLength) {
                    output.push(delimiter);
            }

            // Main encoding loop:
            while (handledCPCount < inputLength) {

                    // All non-basic code points < n have been handled already. Find the next
                    // larger one:
                    var m = maxInt;
                    for (var currentValue of input) {
                            if (currentValue >= n && currentValue < m) {
                                    m = currentValue;
                            }
                    }

                    // Increase `delta` enough to advance the decoder's <n,i> state to <m,0>,
                    // but guard against overflow.
                    var handledCPCountPlusOne = handledCPCount + 1;
                    if (m - n > floor((maxInt - delta) / handledCPCountPlusOne)) {
                            error('overflow');
                    }

                    delta += (m - n) * handledCPCountPlusOne;
                    n = m;

                    for (var currentValue of input) {
                            if (currentValue < n && ++delta > maxInt) {
                                    error('overflow');
                            }
                            if (currentValue == n) {
                                    // Represent delta as a generalized variable-length integer.
                                    var q = delta;
                                    for (var k = base; /* no condition */; k += base) {
                                            var t = k <= bias ? tMin : (k >= bias + tMax ? tMax : k - bias);
                                            if (q < t) {
                                                    break;
                                            }
                                            var qMinusT = q - t;
                                            var baseMinusT = base - t;
                                            output.push(
                                                    stringFromCharCode(digitToBasic(t + qMinusT % baseMinusT, 0))
                                            );
                                            q = floor(qMinusT / baseMinusT);
                                    }

                                    output.push(stringFromCharCode(digitToBasic(q, 0)));
                                    bias = adapt(delta, handledCPCountPlusOne, handledCPCount == basicLength);
                                    delta = 0;
                                    ++handledCPCount;
                            }
                    }

                    ++delta;
                    ++n;

            }
            return output.join('');
    };

    /**
     * Converts a Punycode string representing a domain name or an email address
     * to Unicode. Only the Punycoded parts of the input will be converted, i.e.
     * it doesn't matter if you call it on a string that has already been
     * converted to Unicode.
     * @memberOf punycode
     * @param {String} input The Punycoded domain name or email address to
     * convert to Unicode.
     * @returns {String} The Unicode representation of the given Punycode
     * string.
     */
    var toUnicode = function(input) {
            return mapDomain(input, function(string) {
                    return regexPunycode.test(string)
                            ? decode(string.slice(4).toLowerCase())
                            : string;
            });
    };

    /**
     * Converts a Unicode string representing a domain name or an email address to
     * Punycode. Only the non-ASCII parts of the domain name will be converted,
     * i.e. it doesn't matter if you call it with a domain that's already in
     * ASCII.
     * @memberOf punycode
     * @param {String} input The domain name or email address to convert, as a
     * Unicode string.
     * @returns {String} The Punycode representation of the given domain name or
     * email address.
     */
    var toASCII = function(input) {
            return mapDomain(input, function(string) {
                    return regexNonASCII.test(string)
                            ? 'xn--' + encode(string)
                            : string;
            });
    };

    /*--------------------------------------------------------------------------*/

    /** Define the public API */
    return {
        /**
         * A string representing the current Punycode.js version number.
         * @memberOf punycode
         * @type String
         */
        version: '2.1.0',
        /**
         * An object of methods to convert from JavaScript's internal character
         * representation (UCS-2) to Unicode code points, and back.
         * @see <https://mathiasbynens.be/notes/javascript-encoding>
         * @memberOf punycode
         * @type Object
         */
        ucs2: {
                'decode': ucs2decode,
                'encode': ucs2encode
        },
        decode: decode,
        encode: encode,
        toASCII: toASCII,
        toUnicode: toUnicode
    }
}();

//module.exports = sp_punycode;
