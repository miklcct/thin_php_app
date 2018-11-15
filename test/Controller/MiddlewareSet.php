<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Test\Controller;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;

class MiddlewareSet {
    /** @var MiddlewareInterface[] */
    public $middlewares;

    /** @var ServerRequestInterface */
    public $finalRequest;
}