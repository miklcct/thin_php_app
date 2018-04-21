<?php
declare(strict_types=1);

use Miklcct\ThinPhpApp\Exception\HttpExceptionInterface;
use Miklcct\ThinPhpApp\Http\Response;
use Miklcct\ThinPhpApp\View\View;

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

function get_exception_handler_for_view(string $view_class) {
    return function (Throwable $e) use ($view_class) {
        while (ob_get_level()) {
            ob_end_clean();
        }
        $view = new $view_class($e);
        assert($view instanceof View);
        (
            new Response(
                $view->render()
                , $e instanceof HttpExceptionInterface
                    ? $e->getStatusCode()
                    : Response::HTTP_INTERNAL_SERVER_ERROR
            )
        )->send();
    };
}

function nullable($object, callable $callback) {
    return $object !== NULL ? $callback($object) : NULL;
}