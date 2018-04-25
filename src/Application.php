<?php

declare(strict_types=1);

namespace Miklcct\ThinPhpApp;
use Closure;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * A simple PSR-15 compliant PHP application
 *
 * {@link getMiddlewares()} defines the middlewares used in the application.
 * {@link run()} contains the main controller code.
 *
 * Routing is not provided by default, instead, there are a few main approaches for routing:
 *
 * * Create a controller implementing <code>RequestHandlerInterface</code> for each route, run it directly from the file system
 * * Install a PSR-15 compliant router middleware in the main application from a single entry point, which in turns loads other controllers
 * * Run a PSR-15 compliant router application from a single entry point
 *
 * The legacy approach of directly instantiating the router and run it in the index.php is no longer recommended,
 * unless it implements <code>RequestHandlerInterface</code>
 *
 * @package Miklcct\ThinPhpApp
 */
abstract class Application implements RequestHandlerInterface
{
    /**
     * Handle a request and return a response.
     *
     * The application will first pass the request through the defined middlewares sequentially.
     * The {@link run()} method is only called from the innermost middleware.
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request) : ResponseInterface {
        $handle = Closure::fromCallable([$this, 'run']);
        return MiddlewareApplication::bindMultiple(
            $this->getMiddlewares()
            , new class($handle) implements RequestHandlerInterface {
                public function __construct(callable $handle) {
                    $this->handle = $handle;
                }

                public function handle(ServerRequestInterface $request) : ResponseInterface {
                    return ($this->handle)($request);
                }

                /** @var callable */
                private $handle;
            }
        )->handle($request);
    }

    /**
     * Process the request after passed through the middlewares
     *
     * This the main controller. The request processed by the middlewares before it reaches this method,
     * and the response is processed by the middlewares before it is send out.
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    abstract protected function run(ServerRequestInterface $request) : ResponseInterface;

    /**
     * Get the middlewares for this application.
     *
     * The middlewares must be sorted from the outermost to the innermost order, i.e. the beginning middleware
     * will process the initial request and create the final response.
     *
     * To disable middlewares of an existing application, override this method to return an empty array.
     *
     * @return MiddlewareInterface[]
     */
    protected function getMiddlewares() : array {
        return [];
    }
}