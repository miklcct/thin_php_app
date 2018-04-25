<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Exception;

use function Http\Response\send;
use Miklcct\ThinPhpApp\Response\ExceptionResponseFactoryInterface;
use Throwable;

/**
 * Exception handler for sending an exception response generated from a factory
 *
 * Object of this class can be passed directly to <code>set_exception_handler()</code>
 */
class ResponseFactoryExceptionHandler {
    public function __construct(ExceptionResponseFactoryInterface $exceptionResponseFactory) {
        $this->exceptionResponseFactory = $exceptionResponseFactory;
    }

    /**
     * Send an exception response
     *
     * @param Throwable $exception
     */
    public function __invoke(Throwable $exception) {
        $factory = $this->exceptionResponseFactory;
        send($factory($exception));
    }

    /** @var ExceptionResponseFactoryInterface */
    private $exceptionResponseFactory;
}