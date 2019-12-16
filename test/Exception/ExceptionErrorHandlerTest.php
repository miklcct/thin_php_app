<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Test\Exception;

use ErrorException;
use Miklcct\ThinPhpApp\Exception\ExceptionErrorHandler;
use PHPUnit\Framework\TestCase;

class ExceptionErrorHandlerTest extends TestCase {

    /** @var ErrorException */
    private $exception;

    /** @var int */
    private $error_reporting;

    protected function setUp() : void {
        parent::setUp();
        $this->exception = new ErrorException('test', 0, E_NOTICE);
        $this->error_reporting = error_reporting();
    }

    protected function tearDown() : void {
        error_reporting($this->error_reporting);
        parent::tearDown();
    }

    public function testPositive() : void {
        error_reporting($this->exception->getSeverity());
        $this->expectExceptionObject($this->exception);
        $handler = new ExceptionErrorHandler();
        $handler(
            $this->exception->getSeverity()
            , $this->exception->getMessage()
            , $this->exception->getFile()
            , $this->exception->getLine()
        );
    }

    public function testNegative() : void {
        error_reporting(~$this->exception->getSeverity());
        $this->expectNotToPerformAssertions();
        $handler = new ExceptionErrorHandler();
        $handler(
            $this->exception->getSeverity()
            , $this->exception->getMessage()
            , $this->exception->getFile()
            , $this->exception->getLine()
        );
    }
}