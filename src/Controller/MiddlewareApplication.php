<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * An application with a middleware bounded
 */
class MiddlewareApplication implements RequestHandlerInterface {
    /**
     * Bind multiple middlewares on top of an application
     *
     * @param array $middlewares Middleware sorted from the outermost (first in last out).
     * @param RequestHandlerInterface $application The original application
     * @return RequestHandlerInterface The application with the middlewares added
     */
    public static function bindMultiple(array $middlewares, RequestHandlerInterface $application) : RequestHandlerInterface {
        return array_reduce(
            array_reverse($middlewares)
            , function (RequestHandlerInterface $carry, MiddlewareInterface $middleware) : RequestHandlerInterface {
                return new static($middleware, $carry);
            }
            , $application
        );
    }

    /**
     * Bind a middleware on top of an application
     *
     * @param MiddlewareInterface $middleware
     * @param RequestHandlerInterface $application
     */
    public final function __construct(MiddlewareInterface $middleware, RequestHandlerInterface $application) {
        $this->middleware = $middleware;
        $this->application = $application;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface {
        return $this->middleware->process($request, $this->application);
    }

    /** @var MiddlewareInterface */
    private $middleware;
    /** @var RequestHandlerInterface */
    private $application;
}