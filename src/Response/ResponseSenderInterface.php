<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Response;

use Psr\Http\Message\ResponseInterface;

/**
 * Callable interface to send a response
 */
interface ResponseSenderInterface {
    /**
     * Send a response
     * @param ResponseInterface $response
     */
    public function __invoke(ResponseInterface $response) : void;
}