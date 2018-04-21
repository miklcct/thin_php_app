<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Demo;

use Miklcct\ThinPhpApp\View\View;

class HelloView extends View {
    public function __construct(string $ipAddress, string $url) {
        $this->ipAddress = $ipAddress;
        $this->url = $url;
    }

    public function getPathToTemplate() : string {
        return __DIR__ . '/hello.phtml';
    }

    /** @var string */
    protected $ipAddress;
    /** @var string */
    protected $url;
}