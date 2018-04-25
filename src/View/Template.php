<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\View;

/**
 * A view from a template file stored externally
 *
 * Template renderers are expected to extend this class and implement {@link render()}.
 * Afterwards, the user can extend the template renderer, supply the template file
 * and implement {@link getPathToTemplate()} to complete the concrete view.
 *
 *
 */
abstract class Template implements View {
    /**
     * Get the file system path to the template.
     *
     * @return string
     */
    abstract protected function getPathToTemplate() : string;

    public function getContentType() : ?string {
        return NULL;
    }
}