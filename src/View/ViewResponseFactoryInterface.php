<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\View;
use Psr\Http\Message\ResponseInterface;

/**
 * Response factory to create from view
 *
 * Class ViewResponseFactory
 * @package Miklcct\ThinPhpApp\View
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