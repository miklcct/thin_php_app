<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Test\Utility;

use function Miklcct\ThinPhpApp\Utility\nullable;
use PHPUnit\Framework\TestCase;

class FunctionsTest extends TestCase {
    public function testNullableNull() {
        self::assertSame(
            'test'
            , nullable(
                NULL
                , function (int $x) {
                    return $x + 1;
                }
                , 'test'
            )
        );
    }

    public function testNullableNotNull() {
        self::assertSame(
            3
            , nullable(
                2
                , function (int $x) {
                    return $x + 1;
                }
                , 'test'
            )
        );
    }
}