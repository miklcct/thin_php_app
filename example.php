<?php

declare(strict_types=1);

use DI\Container;
use Miklcct\ThinPhpApp\Demo\ExceptionView;
use Miklcct\ThinPhpApp\Demo\HelloApp;
use Miklcct\ThinPhpApp\Http\Request;

require 'vendor/autoload.php';

// set up error handler
set_error_handler('exception_error_handler');
set_exception_handler(get_exception_handler_for_view(ExceptionView::class));

// Subclass the application and replace the reference
(new Container())->get(HelloApp::class)->run(new Request())->send();
