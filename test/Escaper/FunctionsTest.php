<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Test\Escaper;

use JsonException;
use PHPUnit\Framework\TestCase;
use stdClass;
use function Miklcct\ThinPhpApp\Escaper\css;
use function Miklcct\ThinPhpApp\Escaper\html;
use function Miklcct\ThinPhpApp\Escaper\js;
use function Miklcct\ThinPhpApp\Escaper\json;
use function Miklcct\ThinPhpApp\Escaper\url;
use function Miklcct\ThinPhpApp\Escaper\xml;

class FunctionsTest extends TestCase {
    public function testHtml() : void {
        self::assertSame('F &amp; B', html('F & B'));
    }

    public function testXml() : void {
        self::assertSame('F &amp; B', xml('F & B'));
    }

    public function testJs() : void {
        self::assertSame('\\"\\\'\\"', js('"\'"'));
    }

    public function testJsonNull() : void {
        self::assertSame('null', json(NULL));
    }

    public function testJsonInteger() : void {
        self::assertSame('-3', json(-3));
    }

    public function testJsonFloat() : void {
        self::assertSame('0.0', json(0.0));
    }

    public function testJsonBoolean() : void {
        self::assertSame('true', json(TRUE));
    }

    public function testJsonString() : void {
        $string = "123\"\"/\\\\n&外الْأَبْجَدِيَّة";
        self::assertSame($string, json_decode(json($string)));
    }

    public function testJsonArray() : void {
        $array = ['foo', 'bar', 'baz'];
        self::assertSame($array, json_decode(json($array)));
    }

    public function testJsonObject() : void {
        $object = new stdClass;
        $object->foo = 'bar';
        self::assertEquals($object, json_decode(json($object)));
    }

    public function testJsonSelfReferencingObject() : void {
        $object = new stdClass;
        $object->foo = $object;
        $this->expectException(JsonException::class);
        json($object);
    }

    public function testUrl() : void {
        self::assertSame('F%20%26%20B', url('F & B'));
    }

    public function testCss() : void {
        self::assertSame('F\\ \\&\\ B', css('F & B'));
    }
}