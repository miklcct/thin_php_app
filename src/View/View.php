<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\View;

/**
 * Base class for all views
 *
 * In order to create a view, extend this class, pass the view data in constructor
 * @package Miklcct\ThinPhpApp\View
 */
abstract class View {
    abstract public function getPathToTemplate() : string;

    public function render() : string {
        ob_start();
        require $this->getPathToTemplate();
        $result = ob_get_contents();
        ob_end_clean();
        return $result;
    }
}