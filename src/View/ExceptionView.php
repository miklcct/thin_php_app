<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\View;

use Throwable;

/**
 * Base class for exception views
 *
 * Applications are recommended to set up exception response returning a subclass object of this view
 *
 * @package Miklcct\ThinPhpApp\View
 */
abstract class ExceptionView extends View {
    public function __construct(Throwable $exception) {
        $this->exception = $exception;
    }

    /** @var Throwable */
    protected $exception;
}