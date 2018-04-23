<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\View;

use Throwable;

/**
 * Interface for exception views
 *
 * Applications are recommended to set up exception response returning an object implementing this
 *
 * @package Miklcct\ThinPhpApp\View
 */
interface ExceptionView extends View {
    public function setException(Throwable $exception);
}