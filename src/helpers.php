<?php
declare(strict_types=1);

/**
 * Escape text for safe output
 *
 * @param string $text
 * @param callable|NULL $escaper if NULL escape for XHTML
 * @return string
 */
function e(string $text, callable $escaper = NULL) : string {
    return $escaper !== NULL ? $escaper($text) : htmlspecialchars($text, ENT_QUOTES | ENT_XHTML);
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
        throw new ErrorException($message, 0, $severity, $line, $file);
    }
}