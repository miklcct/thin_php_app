<?php

declare(strict_types=1);

namespace Miklcct\ThinPhpApp;
use Closure;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Main application class
 *
 * To create a PHP application, subclass this, implement the run method with controller code, add middlewares into
 * getMiddlewares, create an instance in the entry point and call the handle method.
 *
 * @package Miklcct\ThinPhpApp
 */
abstract class Application implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request) : ResponseInterface {
        $handle = Closure::fromCallable([$this, 'run']);
        return MiddlewareApplication::bindMultiple(
            $this->getMiddlewares()
            , new class($handle) implements RequestHandlerInterface {
                public function __construct(callable $handle) {
                    $this->handle = $handle;
                }

                public function handle(ServerRequestInterface $request) : ResponseInterface {
                    return $this->handle($request);
                }

                /** @var callable */
                private $handle;
            }
        )->handle($request);
    }

    abstract protected function run(ServerRequestInterface $request) : ResponseInterface;

    protected function getMiddlewares() : array {
        return [];
    }
}