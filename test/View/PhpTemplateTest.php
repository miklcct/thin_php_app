<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Test\View;

use Miklcct\ThinPhpApp\View\PhpTemplate;
use PHPUnit\Framework\TestCase;
use Zend\Diactoros\StreamFactory;

class PhpTemplateTest extends TestCase {
    public function test__toString() {
        $view = $this->getMockForAbstractClass(PhpTemplate::class, [new StreamFactory()]);
        $view->method('getPathToTemplate')->willReturn(__DIR__ . '/test.phtml');
        $content = "Hello from " . __DIR__ . "/test.phtml";
        self::assertSame($content, $view->__toString());
    }

    public function testRender() {
        $view = $this->getMockForAbstractClass(PhpTemplate::class, [new StreamFactory()]);
        $view->method('getPathToTemplate')->willReturn(__DIR__ . '/test.phtml');
        $content = "Hello from " . __DIR__ . "/test.phtml";
        self::assertSame($content, $view->render()->__toString());
    }
}
