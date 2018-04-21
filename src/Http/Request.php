<?php

declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Http;

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
        $this->files = [];
        foreach ($files ?? $_FILES as $key => $data) {
            $this->files[$key] = new File($key, $data);
        }
        $this->server = $server ?? $_SERVER;
        $this->input = $input ?? file_get_contents('php://input');
    }

    public function get() : array {
        return $this->get;
    }

    public function post() : array {
        return $this->post;
    }

    public function cookie() : array {
        return $this->cookie;
    }

    public function files() : array {
        return $this->files;
    }

    public function server() : array {
        return $this->server;
    }

    public function getRemoteIpAddress() : string {
        return $this->server()['REMOTE_ADDR'];
    }

    /** @var array */
    private $get;
    /** @var array */
    private $post;
    /** @var array */
    private $cookie;
    /** @var File[] */
    private $files;
    /** @var array */
    private $server;
    /** @var string */
    private $input;
}