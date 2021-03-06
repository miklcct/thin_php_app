<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Test\Utility;

use PHPUnit\Framework\TestCase;
use function Miklcct\ThinPhpApp\Utility\nullable;

class FunctionsTest extends TestCase {
    public function testNullableNull() : void {
        self::assertNull(
            nullable(
                NULL
                , static function (int $x) : int {
                    return $x + 1;
                }
            )
        );
    }

    public function testNullableNotNull() : void {
        self::assertSame(
            3
            , nullable(
                2
                , static function (int $x) : int {
                    return $x + 1;
                }
            )
        );
    }
}
