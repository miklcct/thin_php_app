<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Test\Controller;


use Miklcct\ThinPhpApp\Controller\Application;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ApplicationTest extends TestCase {
    use MiddlewaresTrait;
    public function testHandle() {
        $app = $this->getMockBuilder(Application::class)
            ->setMethods(['run', 'getMiddlewares'])
            ->getMock();
        $request = $this->createMock(ServerRequestInterface::class);
        $response = $this->createMock(ResponseInterface::class);
        $middleware_set = $this->createMiddlewares($request, 5);
        $app->method('getMiddlewares')->willReturn($middleware_set->middlewares);
        $app->expects(self::once())->method('run')->with(self::identicalTo($middleware_set->finalRequest))
            ->willReturn($response);
        self::assertSame($response, $app->handle($request));
    }
}