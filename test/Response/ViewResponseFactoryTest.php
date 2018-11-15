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

    public function testWithContentType() {
        $view = $this->createMock(View::class);
        $stream = $this->createMock(StreamInterface::class);
        $empty_response = $this->createMock(ResponseInterface::class);
        $response_with_stream = $this->createMock(ResponseInterface::class);
        $response_with_content_type = $this->createMock(ResponseInterface::class);
        $response = $this->createMock(ResponseInterface::class);
        $view->method('getContentType')->willReturn('text/plain');
        $view->method('render')->willReturn($stream);
        $response_factory = $this->createMock(ResponseFactoryInterface::class);
        $response_factory->method('createResponse')
            ->with(self::identicalTo(200))
            ->willReturn($empty_response);
        $empty_response->method('withBody')
            ->with(self::identicalTo($stream))
            ->willReturn($response_with_stream);
        $response_with_content_type->method('withBody')
            ->with(self::identicalTo($stream))
            ->willReturn($response);
        $empty_response->method('withHeader')
            ->with(self::identicalTo('Content-Type'), self::identicalTo('text/plain'))
            ->willReturn($response_with_content_type);
        $response_with_stream->method('withHeader')
            ->with(self::identicalTo('Content-Type'), self::identicalTo('text/plain'))
            ->willReturn($response);
        $factory = new ViewResponseFactory($response_factory);
        self::assertSame($response, $factory($view));
    }
}