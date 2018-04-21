<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Http;

use RuntimeException;

class SessionException extends RuntimeException {
    const OPEN_FAILED = 1;
    const CLOSE_FAILED = 2;
    const ABORT_FAILED = 3;
    const DESTROY_FAILED = 4;
    const MIGRATE_FAILED = 5;
    const INVALID_STATUS = 6;
}