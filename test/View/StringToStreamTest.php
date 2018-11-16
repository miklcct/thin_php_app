<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Test\View;

use Miklcct\ThinPhpApp\View\StringToStream;
use PHPUnit\Framework\TestCase;
use Zend\Diactoros\StreamFactory;

class StringToStreamTest extends TestCase {
    public function testRender() {
        $string = 'test';
        $iut = $this->getMockForTrait(StringToStream::class);
        $iut->method('__toString')->willReturn($string);
        $iut->method('getStreamFactory')->willReturn(new StreamFactory());
        self::assertSame($string, $iut->render()->__toString());
    }
}