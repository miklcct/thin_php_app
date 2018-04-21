<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Exception;

interface HttpExceptionInterface {
    function getStatusCode() : int;
}