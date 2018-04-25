<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\View;

/**
 * A view from a template file stored externally
 *
 * Template renderers are expected to implement this interface and implement {@link render()}.
 * Afterwards, the user can extend the template renderer, supply the template file
 * and implement {@link getPathToTemplate()} to complete the concrete view.
 *
 * @package Miklcct\ThinPhpApp\View
 */
interface Template extends View {

    /**
     * Get the file system path to the template.
     *
     * @return string
     */
    public function getPathToTemplate() : string;
}