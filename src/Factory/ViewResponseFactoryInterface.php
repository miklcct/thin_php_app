<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Factory;
use Miklcct\ThinPhpApp\View\View;
use Psr\Http\Message\ResponseInterface;

/**
 * Interface for factory generating response from view
 */
interface ViewResponseFactoryInterface {
    /**
     * Create a response from a view
     *
     * @param View $view
     * @return ResponseInterface
     */
    public function __invoke(View $view) : ResponseInterface;
}