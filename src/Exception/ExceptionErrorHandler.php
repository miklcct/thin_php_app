<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Exception;

use ErrorException;

/**
 * Error handler to convert errors to exceptions
 *
 * Object of this class can be passed directly to <code>set_error_handler()</code>
 */
class ExceptionErrorHandler {
    /**
     * Throw an exception when an error occurs
     *
     * @param int $severity
     * @param string $message
     * @param string $file
     * @param int $line
     * @throws ErrorException
     */
    function __invoke(int $severity, string $message, string $file, int $line) : void {
        if (error_reporting() & $severity) {
            throw new ErrorException($message, 0, $severity, $file, $line);
        }
    }
}