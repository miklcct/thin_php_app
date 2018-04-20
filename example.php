<?php

declare(strict_types=1);

use DI\Container;
use Miklcct\ThinPhpApp\Application;
use Miklcct\ThinPhpApp\Request;

require 'vendor/autoload.php';

// Subclass the application and replace the reference
(new Container())->get(Application::class)->run(new Request())->send();
