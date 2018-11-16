<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Test\View;

use Miklcct\ThinPhpApp\View\StaticTemplate;
use PHPUnit\Framework\TestCase;
use Zend\Diactoros\StreamFactory;

class StaticTemplateTest extends TestCase {
    public function test__toString() {
        $view = $this->getMockForAbstractClass(StaticTemplate::class, [new StreamFactory()]);
        $path = __DIR__ . '/test.html';
        $view->method('getPathToTemplate')->willReturn($path);
        self::assertSame(file_get_contents($path), $view->__toString());
    }

    public function testRender() {
        $view = $this->getMockForAbstractClass(StaticTemplate::class, [new StreamFactory()]);
        $path = __DIR__ . '/test.html';
        $view->method('getPathToTemplate')->willReturn($path);
        self::assertSame(file_get_contents($path), $view->render()->__toString());
    }
}