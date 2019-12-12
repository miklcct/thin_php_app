<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Test\Utility;

use PHPUnit\Framework\TestCase;
use function Miklcct\ThinPhpApp\Utility\nullable;

class FunctionsTest extends TestCase {
    public function testNullableNull() {
        self::assertSame(
            NULL
            , nullable(
                NULL
                , function (int $x) {
                    return $x + 1;
                }
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
            )
        );
    }
}
