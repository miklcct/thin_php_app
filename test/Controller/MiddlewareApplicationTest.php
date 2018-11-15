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
    public function testBindMultiple() {
        $request = $this->createMock(ServerRequestInterface::class);
        $count = 5;
        $middleware_requests = array_map(
            function () : ServerRequestInterface {
                return $this->createMock(ServerRequestInterface::class);
            },
            range(0, $count - 1)
        );
        $middlewares = array_map(
            function (int $position) use ($request, $middleware_requests) {
                $middleware = $this->createMock(MiddlewareInterface::class);
                $middleware
                    ->expects(self::once())
                    ->method('process')
                    ->with(
                        self::identicalTo($position ? $middleware_requests[$position - 1] : $request)
                        , self::anything()
                    )
                    ->willReturnCallback(
                        function (
                            ServerRequestInterface $request,
                            RequestHandlerInterface $request_handler
                        ) use ($middleware_requests, $position) : ResponseInterface {
                            return $request_handler->handle($middleware_requests[$position]);
                        }
                    );
                return $middleware;
            }
            , range(0, $count - 1)
        );
        $request_handler = $this->createMock(RequestHandlerInterface::class);
        $request_handler->expects(self::once())->method('handle')
            ->with(self::identicalTo($middleware_requests[$count - 1]));
        $app = MiddlewareApplication::bindMultiple($middlewares, $request_handler);
        $app->handle($request);
    }

    public function testHandle() {
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