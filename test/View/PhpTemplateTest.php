<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Test\View;

use ErrorException;
use Miklcct\ThinPhpApp\View\PhpTemplate;
use PHPUnit\Framework\TestCase;
use Throwable;
use Zend\Diactoros\StreamFactory;
use function ob_get_contents;
use function ob_get_level;

class PhpTemplateTest extends TestCase {
    public function test__toString() : void {
        $view = $this->getMockForAbstractClass(PhpTemplate::class, [new StreamFactory()]);
        $view->method('getPathToTemplate')->willReturn(__DIR__ . '/test.phtml');
        $content = "Hello from " . __DIR__ . "/test.phtml";
        self::assertSame($content, $view->__toString());
    }

    public function testRender() : void {
        $view = $this->getMockForAbstractClass(PhpTemplate::class, [new StreamFactory()]);
        $view->method('getPathToTemplate')->willReturn(__DIR__ . '/test.phtml');
        $content = "Hello from " . __DIR__ . "/test.phtml";
        self::assertSame($content, $view->render()->__toString());
    }

    public function test__toStringDoesntLeakOutputBufferUnderException() {
        $view = $this->getMockForAbstractClass(PhpTemplate::class, [new StreamFactory()]);
        $view->method('getPathToTemplate')->willReturn(__DIR__ . '/error.phtml');
        $level = ob_get_level();
        $content = ob_get_contents();
        try {
            $view->__toString();
        } catch (Throwable $exception) {
        }
        self::assertSame($level, ob_get_level());
        self::assertSame($content, ob_get_contents());
    }
}
