<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp;

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