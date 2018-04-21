<?php

declare(strict_types=1);

use DI\Container;
use Miklcct\ThinPhpApp\Demo\HelloApp;
use Miklcct\ThinPhpApp\Request;

require 'vendor/autoload.php';

// set up error handler
set_error_handler('exception_error_handler');

// Subclass the application and replace the reference
(new Container())->get(HelloApp::class)->run(new Request())->send();
