<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Test\View;

use Miklcct\ThinPhpApp\View\StreamToString;
use PHPUnit\Framework\TestCase;
use Zend\Diactoros\StreamFactory;

class StreamToStringTest extends TestCase {
    public function test__toString() : void {
        $iut = $this->getMockForTrait(StreamToString::class);
        $string = 'test';
        $stream = (new StreamFactory())->createStream($string);
        $iut->method('render')->willReturn($stream);
        self::assertSame($string, $iut->__toString());
    }
}