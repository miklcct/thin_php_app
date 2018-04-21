<?php
/*
 * This file should be placed accessible under your document root
 */

declare(strict_types=1);

use DI\Container;
use Miklcct\ThinPhpApp\Demo\ExceptionView;
use Miklcct\ThinPhpApp\Demo\HelloApp;
use Miklcct\ThinPhpApp\Http\Request;

// require the autoloader
require '../../vendor/autoload.php';

// set up error handler
set_error_handler('exception_error_handler');
set_exception_handler(get_exception_handler_for_view(ExceptionView::class));

// Create the app, run it with the request and send the response
(new Container())->get(HelloApp::class)->run(new Request())->send();
