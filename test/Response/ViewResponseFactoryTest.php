<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Test\Response;

use Interop\Http\Factory\ResponseFactoryInterface;
use Miklcct\ThinPhpApp\Response\ViewResponseFactory;
use Miklcct\ThinPhpApp\View\View;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class ViewResponseFactoryTest extends TestCase {
    public function testWithoutContentType() {
        $view = $this->createMock(View::class);
        $stream = $this->createMock(StreamInterface::class);
        $empty_response = $this->createMock(ResponseInterface::class);
        $response = $this->createMock(ResponseInterface::class);
        $view->method('getContentType')->willReturn(NULL);
        $view->method('render')->willReturn($stream);
        $response_factory = $this->createMock(ResponseFactoryInterface::class);
        $response_factory->method('createResponse')
            ->with(self::identicalTo(200))
            ->willReturn($empty_response);
        $empty_response->method('withBody')
            ->with(self::identicalTo($stream))
            ->willReturn($response);
        $factory = new ViewResponseFactory($response_factory);
        self::assertSame($response, $factory($view));
    }
}