<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\View;

use Throwable;

/**
 * Factory for generating exception views
 *
 * An instance of this factory can be used in the exception handler to produce views for exceptions.
 *
 * @package Miklcct\ThinPhpApp\View
 */
interface ExceptionViewFactory {
    /**
     * Make a view for an exception
     *
     * @param Throwable $exception
     * @return View
     */
    public function __invoke(Throwable $exception) : View;
}