<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Demo;

use Miklcct\ThinPhpApp\View\ExceptionView as Base;

class ExceptionView extends Base {
    public function getPathToTemplate() : string {
        return __DIR__ . '/exception.phtml';
    }
}