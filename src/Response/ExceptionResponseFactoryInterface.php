<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Response;

use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * Interface for factory making response from exception
 */
interface ExceptionResponseFactoryInterface {
    function __invoke(Throwable $exception) : ResponseInterface;
}