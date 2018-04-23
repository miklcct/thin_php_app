<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp;

use ErrorException;
use Interop\Http\Factory\ResponseFactoryInterface;
use Miklcct\ThinPhpApp\View\ExceptionViewFactory;
use Teapot\HttpException;
use Teapot\StatusCode;
use function Http\Response\send;
use Throwable;

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
        throw new ErrorException($message, 0, $severity, $file, $line);
    }
}

function get_exception_handler_for_view(ExceptionViewFactory $view_factory, ResponseFactoryInterface $response_factory) {
    return function (Throwable $exception) use ($view_factory, $response_factory) {
        while (ob_get_level()) {
            ob_end_clean();
        }
        $response = $response_factory->createResponse(
            $exception instanceof HttpException ? $exception->getCode() : StatusCode::INTERNAL_SERVER_ERROR
        )->withBody($view_factory->makeView($exception)->render());
        send($response);
    };
}

function nullable($object, callable $callback) {
    return $object !== NULL ? $callback($object) : NULL;
}