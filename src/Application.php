<?php

declare(strict_types=1);

namespace Miklcct\ThinPhpApp;
use Miklcct\ThinPhpApp\Http\Request;
use Miklcct\ThinPhpApp\Http\Response;

/**
 * Main application class
 *
 * To create a PHP application, subclass this, create an instance in the entry point, and call the run method
 * @package Miklcct\ThinPhpApp
 */
abstract class Application
{
    /**
     * Run the application
     *
     * @param Request $request
     * @return Response
     */
    abstract public function run(Request $request);
}