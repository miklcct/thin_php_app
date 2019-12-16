<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Test\View;

use Miklcct\ThinPhpApp\View\StreamToString;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\StreamInterface;
use Zend\Diactoros\StreamFactory;

class StreamToStringTest extends TestCase {
    public function test__toString() : void {
        $string = 'test';
        $iut = new class($string) {
            use StreamToString;

            public function __construct(string $string) {
                $this->string = $string;
            }

            public function render() : StreamInterface {
                return (new StreamFactory())->createStream($this->string);
            }

            /** @var string */
            private $string;
        };
        self::assertSame($string, $iut->__toString());
    }
}