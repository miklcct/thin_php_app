<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Response;

use function Http\Response\send;
use Psr\Http\Message\ResponseInterface;

class ResponseSender implements ResponseSenderInterface {
    public function __invoke(ResponseInterface $response) : void {
        send($response);
    }
}