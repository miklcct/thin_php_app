<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp;

use ErrorException;
use Miklcct\ThinPhpApp\Factory\ExceptionResponseFactoryInterface;
use Throwable;
use function Http\Response\send;

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

/**
 * Get an exception handler for sending response from a given factory
 *
 * @param ExceptionResponseFactoryInterface $factory
 * @return \Closure
 */
function get_exception_handler_from_response_factory(ExceptionResponseFactoryInterface $factory) {
    return function (Throwable $exception) use ($factory) {
        send($factory($exception));
    };
}

/**
 * Run a callback on an object if it is not NULL
 *
 * @param $object
 * @param callable $callback
 * @return mixed|null
 */
function nullable($object, callable $callback) {
    return $object !== NULL ? $callback($object) : NULL;
}