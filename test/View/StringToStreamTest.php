<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Test\View;

use Miklcct\ThinPhpApp\View\StringToStream;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use Zend\Diactoros\StreamFactory;

class StringToStreamTest extends TestCase {
    public function testRender() : void {
        $string = 'test';
        $iut = new class($string) {
            use StringToStream;
            public function __construct(string $string) {
                $this->string = $string;
            }

            public function __toString() : string {
                return $this->string;
            }

            protected function getStreamFactory() : StreamFactoryInterface {
                return new StreamFactory();
            }

            /** @var string */
            private $string;
        };
        /** @var StreamInterface $result */
        $result = $iut->render();
        self::assertSame($string, $result->__toString());
    }
}