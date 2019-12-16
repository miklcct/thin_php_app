<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Exception;

use Miklcct\ThinPhpApp\Response\ExceptionResponseFactoryInterface;
use Miklcct\ThinPhpApp\Response\ResponseSenderInterface;
use Throwable;

/**
 * Exception handler for sending an exception response generated from a factory
 *
 * Object of this class can be passed directly to <code>set_exception_handler()</code>
 */
class ResponseFactoryExceptionHandler {
    public function __construct(
        ExceptionResponseFactoryInterface $exceptionResponseFactory
        , ResponseSenderInterface $responseSender
    ) {
        $this->exceptionResponseFactory = $exceptionResponseFactory;
        $this->responseSender = $responseSender;
    }

    /**
     * Send an exception response
     *
     * @param Throwable $exception
     */
    public function __invoke(Throwable $exception) : void {
        $factory = $this->exceptionResponseFactory;
        $send = $this->responseSender;
        $send($factory($exception));
    }

    /** @var ExceptionResponseFactoryInterface */
    private $exceptionResponseFactory;
    /**
     * @var ResponseSenderInterface
     */
    private $responseSender;
}