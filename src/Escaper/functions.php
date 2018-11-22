<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Escaper;
use InvalidArgumentException;
use RuntimeException;

/**
 * Escape text for HTML5
 *
 * @param string|mixed $text
 * @return string
 */
function html($text) : string {
    return htmlspecialchars((string)$text, ENT_QUOTES | ENT_HTML5);
}

/**
 * Escape text for XML
 *
 * @param string|mixed $text
 * @return string
 */
function xml($text) : string {
    return htmlspecialchars((string)$text, ENT_QUOTES | ENT_XML1);
}

/**
 * Escape text for Javascript string
 *
 * The result is to be inserted into a Javascript string literal.
 *
 * If the value is to be inserted in embedded script in HTML documents, set $escape_slash to be TRUE to prevent
 * </ sequence ending the script prematurely.
 *
 * If the value is to be inserted into inline event handlers (e.g. onclick attribute), please also escape it with
 * {@link html()}.
 *
 * @see json()
 *
 * @param string|mixed $text
 * @param bool $escape_slash
 * @return string
 */
function js($text, bool $escape_slash = FALSE) : string {
    $json = json((string)$text, $escape_slash);
    $result = preg_replace("#'#u", "\\'", substr($json, 1, -1));
    if ($result === NULL) {
        throw new RuntimeException('preg_replace() does not work properly');
    }
    return $result;
}

/**
 * Escape value for Javascript / JSON
 *
 * number, string, boolean, null, object and numerical array are preserved, associative array is converted to object.
 *
 * This produces a valid Javascript value so do not put the result in string literals.
 *
 * If the value is to be inserted in embedded script in HTML documents, set $escape_slash to be TRUE to prevent
 * </ sequence ending the script prematurely.
 *
 * If the value is to be inserted into inline event handlers (e.g. onclick attribute), please also escape it with
 * {@link html()}.
 *
 * @see js()
 *
 * @param mixed $value
 * @param bool $escape_slash
 * @throws InvalidArgumentException if the value cannot be represented with JSON
 * @return string
 */
function json($value, bool $escape_slash = FALSE) : string {
    $result = json_encode(
        $value
        , JSON_UNESCAPED_UNICODE | ($escape_slash ? JSON_UNESCAPED_SLASHES : 0) | JSON_PRESERVE_ZERO_FRACTION
    );
    if ($result === FALSE) {
        if (json_last_error()) {
            throw new InvalidArgumentException(json_last_error_msg());
        }
        throw new RuntimeException('json_encode() does not perform properly');
    }
    return $result;
}

/**
 * Escape for URL
 *
 * @param string|mixed $text
 * @return string
 */
function url($text) : string {
    return rawurlencode((string)$text);
}

/**
 * Escape for CSS
 *
 * This function works for UTF-8 only
 *
 * @see https://drafts.csswg.org/cssom/#serialize-an-identifier
 *
 * @param string|mixed $text
 * @return string
 */
function css($text) : string {
    $escape_code_point = function (int $code) : string {
        return sprintf('\%x ', $code);
    };
    $result = '';
    $characters = str_split((string)$text);
    foreach ($characters as $i => $char) {
        $code = ord($char);
        if ($code === 0) {
            $result .= "\u{fffd}";
        } elseif ($code >= 1 && $code <= 0x1f) {
            $result .= $escape_code_point($code);
        } elseif ($i === 0 && $code >= 0x30 && $code <= 0x39) {
            $result .= $escape_code_point($code);
        } elseif ($i === 1 && $code >= 0x30 && $code <= 0x39 && $characters[0] === '-') {
            $result .= $escape_code_point($code);
        } elseif ($i === 0 && $char === '-' && !isset($characters[1])) {
            $result .= "\\$char";
        } elseif (
            $code >= 0x80
            || $char === '-'
            || $char === '_'
            || ($code >= 0x30 && $code <= 0x39)
            || ($code >= 0x41 && $code <= 0x5a)
            || ($code >= 0x61 && $code <= 0x7a)
        ) {
            $result .= $char;
        } else {
            $result .= "\\$char";
        }
    }
    return $result;
}