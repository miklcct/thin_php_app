<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Test\Response;

use Miklcct\ThinPhpApp\Response\ViewResponseFactory;
use Miklcct\ThinPhpApp\View\View;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\StreamInterface;
use Laminas\Diactoros\ResponseFactory;

class ViewResponseFactoryTest extends TestCase {
    public function testWithoutContentType() : void {
        $view = $this->createMock(View::class);
        $stream = $this->createMock(StreamInterface::class);
        $view->method('getContentType')->willReturn(NULL);
        $view->method('render')->willReturn($stream);
        $response_factory = new ResponseFactory();
        $factory = new ViewResponseFactory($response_factory);
        $result = $factory($view);
        self::assertSame(200, $result->getStatusCode());
        self::assertSame($stream, $result->getBody());
    }

    public function testWithContentType() : void {
        $view = $this->createMock(View::class);
        $stream = $this->createMock(StreamInterface::class);
        $content_type = 'text/plain';
        $view->method('getContentType')->willReturn($content_type);
        $view->method('render')->willReturn($stream);
        $response_factory = new ResponseFactory();
        $factory = new ViewResponseFactory($response_factory);
        $result = $factory($view);
        self::assertSame(200, $result->getStatusCode());
        self::assertSame($stream, $result->getBody());
        self::assertSame($content_type, $result->getHeaderLine('Content-Type'));
    }
}