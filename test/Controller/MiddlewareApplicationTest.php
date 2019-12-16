<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Test\Controller;

use Miklcct\ThinPhpApp\Controller\MiddlewareApplication;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class MiddlewareApplicationTest extends TestCase {
    use MiddlewaresTrait;

    public function testBindMultiple() : void {
        $request = $this->createMock(ServerRequestInterface::class);
        $count = 5;
        $middleware_set = $this->createMiddlewares($request, $count);
        $request_handler = $this->createMock(RequestHandlerInterface::class);
        $request_handler->expects(self::once())->method('handle')
            ->with(self::identicalTo($middleware_set->finalRequest));
        $app = MiddlewareApplication::bindMultiple($middleware_set->middlewares, $request_handler);
        $app->handle($request);
    }

    public function testHandle() : void {
        $request = $this->createMock(ServerRequestInterface::class);
        $response = $this->createMock(ResponseInterface::class);
        $request_handler = $this->createMock(RequestHandlerInterface::class);
        $middleware = $this->createMock(MiddlewareInterface::class);
        $middleware
            ->expects(self::once())
            ->method('process')
            ->with(self::identicalTo($request), self::identicalTo($request_handler))
            ->willReturn($response);
        $app = new MiddlewareApplication($middleware, $request_handler);
        self::assertSame($response, $app->handle($request));
    }
}