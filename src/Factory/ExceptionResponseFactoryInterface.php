<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Factory;

use Psr\Http\Message\ResponseInterface;
use Throwable;

interface ExceptionResponseFactoryInterface {
    function __invoke(Throwable $exception) : ResponseInterface;
}