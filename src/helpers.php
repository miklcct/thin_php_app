<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp;

use ErrorException;
use Miklcct\ThinPhpApp\Factory\ExceptionResponseFactoryInterface;
use Throwable;
use function Http\Response\send;

/**
 * Escape text for HTML5
 *
 * @param string $text
 * @param callable|NULL $escaper
 * @return string
 */
function html5($text) : string {
    return htmlspecialchars((string)$text, ENT_QUOTES | ENT_HTML5);
}

/**
 * Escape text for XML
 *
 * @param $text
 * @return string
 */
function xml($text) : string {
    return htmlspecialchars((string)$text, ENT_QUOTES | ENT_XML1);
}

/**
 * Escape for Javascript
 *
 * This produces a valid Javascript value so do not put the result in Javascript quotes.
 *
 * @param $text
 * @return string
 */
function js($text) : string {
    return json_encode($text);
}

/**
 * Error handler to convert errors to exceptions
 *
 * @param int $severity
 * @param string $message
 * @param string $file
 * @param int $line
 * @throws ErrorException
 */
function exception_error_handler(int $severity, string $message, string $file, int $line) : void {
    if (error_reporting() & $severity) {
        throw new ErrorException($message, 0, $severity, $file, $line);
    }
}

function get_exception_handler_from_response_factory(ExceptionResponseFactoryInterface $factory) {
    return function (Throwable $exception) use ($factory) {
        send($factory($exception));
    };
}

function nullable($object, callable $callback) {
    return $object !== NULL ? $callback($object) : NULL;
}