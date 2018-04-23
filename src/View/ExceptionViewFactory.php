<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\View;

use Throwable;

/**
 * Interface for generating exception views
 *
 * Applications are recommended to set up exception response returning an object implementing this
 *
 * @package Miklcct\ThinPhpApp\View
 */
interface ExceptionViewFactory {
    public function __invoke(Throwable $exception) : View;
}