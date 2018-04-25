<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\View;

abstract class AbstractView implements View {
    public function includeView(View $other) : void {
        echo $other->render()->getContents();
    }
}