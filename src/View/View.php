<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\View;

use Psr\Http\Message\StreamInterface;

interface View {
    public function render() : StreamInterface;
}