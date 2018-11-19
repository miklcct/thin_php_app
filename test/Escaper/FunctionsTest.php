<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Test\Escaper;

use PHPUnit\Framework\TestCase;
use stdClass;
use function Miklcct\ThinPhpApp\Escaper\html;
use function Miklcct\ThinPhpApp\Escaper\js;
use function Miklcct\ThinPhpApp\Escaper\json;
use function Miklcct\ThinPhpApp\Escaper\xml;

class FunctionsTest extends TestCase {
    public function testHtml() {
        self::assertSame('F &amp; B', html('F & B'));
    }

    public function testXml() {
        self::assertSame('F &amp; B', xml('F & B'));
    }

    public function testJs() {
        self::assertSame('\\"\\\'\\"', js('"\'"'));
    }

    public function testJsonNull() {
        self::assertSame('null', json(NULL));
    }

    public function testJsonInteger() {
        self::assertSame('-3', json(-3));
    }

    public function testJsonFloat() {
        self::assertSame('0.0', json(0.0));
    }

    public function testJsonBoolean() {
        self::assertSame('true', json(TRUE));
    }

    public function testJsonArray() {
        self::assertSame('[]', json([]));
    }

    public function testJsonObject() {
        self::assertSame('{}', json(new stdClass()));
    }
}