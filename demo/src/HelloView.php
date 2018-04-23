<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Demo;

use Miklcct\ThinPhpApp\View\PhpTemplate;

class HelloView extends PhpTemplate {
    public function __construct(string $ipAddress, string $url) {
        $this->ipAddress = $ipAddress;
        $this->url = $url;
    }

    public function getPathToTemplate() : string {
        return __DIR__ . '/../view/hello.phtml';
    }

    /** @var string */
    protected $ipAddress;
    /** @var string */
    protected $url;
}