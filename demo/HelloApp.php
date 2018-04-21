<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Demo;

use Miklcct\ThinPhpApp\Application;
use Miklcct\ThinPhpApp\Request;
use Miklcct\ThinPhpApp\Response;

class HelloApp extends Application {
    public function run(Request $request) : Response {
        return new Response((new HelloView($request->getRemoteIpAddress()))->render());
    }
}