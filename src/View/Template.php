<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\View;

interface Template extends View {
    public function getPathToTemplate() : string;
}