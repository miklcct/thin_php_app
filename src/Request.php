<?php

declare(strict_types=1);

namespace Miklcct\ThinPhpApp;

/**
 * An HTTP request
 * @package Miklcct\ThinPhpApp
 */
class Request
{
    /**
     * Construct an HTTP request.
     *
     * If the argument is not specified, it will be created from the corresponding superglobal.
     *
     * @param array|NULL $get
     * @param array|NULL $post
     * @param array|NULL $cookie
     * @param array|NULL $files
     * @param array|NULL $server
     * @param string|NULL $input
     */
    public function __construct(
        array $get = NULL
        , array $post = NULL
        , array $cookie = NULL
        , array $files = NULL
        , array $server = NULL
        , string $input = NULL
    ) {
        $this->get = $get ?? $_GET;
        $this->post = $post ?? $_POST;
        $this->cookie = $cookie ?? $_COOKIE;
        $this->files = $files ?? $_FILES;
        $this->server = $server ?? $_SERVER;
        $this->input = $input ?? file_get_contents('php://input');
    }

    /** @var array */
    private $get;
    /** @var array */
    private $post;
    /** @var array */
    private $cookie;
    /** @var array */
    private $files;
    /** @var array */
    private $server;
    /** @var string */
    private $input;
}