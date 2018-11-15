<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Test\Exception;

use Miklcct\ThinPhpApp\Exception\ResponseFactoryExceptionHandler;
use Miklcct\ThinPhpApp\Response\ExceptionResponseFactoryInterface;
use Miklcct\ThinPhpApp\Response\ResponseSenderInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class ResponseFactoryExceptionHandlerTest extends TestCase {
    public function test() {
        $exception = $this->createMock(Throwable::class);
        $response = $this->createMock(ResponseInterface::class);
        $factory = $this->createMock(ExceptionResponseFactoryInterface::class);
        $factory->expects(self::once())->method('__invoke')->with(self::identicalTo($exception))->willReturn($response);
        $sender = $this->createMock(ResponseSenderInterface::class);
        $sender->expects(self::once())->method('__invoke')->with(self::identicalTo($response));
        $handler = new ResponseFactoryExceptionHandler($factory, $sender);
        $handler($exception);
    }
}