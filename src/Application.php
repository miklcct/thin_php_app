<?php

declare(strict_types=1);

namespace Miklcct\ThinPhpApp;

/**
 * Main application class
 *
 * To create a PHP application, subclass this, create an instance in the entry point, and call the run method
 * @package Miklcct\ThinPhpApp
 */
class Application
{
    /**
     * Run the application
     *
     * @param Request $request
     * @return Response
     */
    public function run(Request $request) : Response {
        return new Response();
    }
}