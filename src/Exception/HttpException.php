<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Exception;

use Exception;
use Throwable;

class HttpException extends Exception implements HttpExceptionInterface {
    public function __construct(int $statusCode, string $message = '', int $code = 0, Throwable $previous = NULL) {
        parent::__construct($message, $code, $previous);
        $this->statusCode = $statusCode;
    }

    function getStatusCode() : int {
        return $this->statusCode;
    }

    /** @var int */
    private $statusCode;
}