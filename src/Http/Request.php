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

    /**
     * @return File[]
     */
    public function files() : array {
        return $this->files;
    }

    public function server() : array {
        return $this->server;
    }

    public function getGatewayInterface() : ?string {
        return $this->server['GATEWAY_INTERFACE'] ?? NULL;
    }

    public function getServerAddress() : ?string {
        return $this->server['SERVER_ADDR'] ?? NULL;
    }

    public function getServerPort() : ?int {
        return nullable(
            $this->server['SERVER_PORT']
            , function ($x) {
                return (int)$x;
            }
        );
    }

    public function getServerHostName() : ?string {
        return $this->server['SERVER_NAME'] ?? NULL;
    }

    public function getProtocol() : ?string {
        return $this->server['SERVER_PROTOCOL'] ?? NULL;
    }

    public function getMethod() : ?string {
        return $this->server['REQUEST_METHOD'] ?? NULL;
    }

    public function getTime() : ?float {
        return $this->server['REQUEST_TIME_FLOAT'] ?? NULL;
    }

    public function getQueryString() : ?string {
        return $this->server['QUERY_STRING'] ?? NULL;
    }

    // TODO: accept headers

    public function getHost() : ?string {
        return $this->server['HTTP_HOST'] ?? NULL;
    }

    public function getReferrer() : ?string {
        return $this->server['HTTP_REFERER'] ?? NULL;
    }

    public function getUserAgent() : ?string {
        return $this->server['HTTP_USER_AGENT'] ?? NULL;
    }

    public function isSecure() : bool {
        return !empty($this->server['HTTPS']) && $this->server['HTTPS'] !== 'off';
    }

    public function getClientAddress() : ?string {
        return $this->server['REMOTE_ADDR'] ?? NULL;
    }

    public function getClientHostName() : ?string {
        return $this->server['REMOTE_HOST'] ?? NULL;
    }

    public function getClientPort() : ?int {
        return nullable(
            $this->server['REMOTE_PORT']
            , function ($x) {
                return (int)$x;
            }
        );
    }

    public function getScriptPath() : ?string {
        return $this->server['SCRIPT_FILENAME'] ?? NULL;
    }

    public function getRequestUri() : ?string {
        return $this->server['REQUEST_URI'] ?? NULL;
    }

    public function getRemoteUser() : ?string {
        return $this->server['REMOTE_USER'] ?? $this->server['REDIRECT_REMOTE_USER'] ?? NULL;
    }

    public function getAuthUser() : ?string {
        return $this->server['PHP_AUTH_USER'] ?? NULL;
    }

    public function getAuthPassword() : ?string {
        return $this->server['PHP_AUTH_PW'] ?? NULL;
    }

    public function getAuthDigest() : ?string {
        return $this->server['PHP_AUTH_DIGEST'] ?? NULL;
    }

    public function getAuthType() : ?string {
        return $this->server['AUTH_TYPE'] ?? NULL;
    }

    public function getPathInfo() : ?string {
        return $this->server['ORIG_PATH_INFO'] ?? $this->server['PATH_INFO'] ?? NULL;
    }

    public function getUrl() : string {
        return ($this->isSecure() ? 'https://' : 'http://')
            . ($this->getHost() ?? $this->getServerHostName() ?? $this->getServerAddress() ?? 'localhost')
            . ($this->isOnDefaultPort() === FALSE ? ':' . $this->getServerPort() : '')
            . $this->getRequestUri();
    }

    public function isOnDefaultPort() : ?bool {
        return nullable(
            $this->getServerPort()
            , function (int $port) {
                return $this->isSecure() ? $port === 443 : $port === 80;
            }
        );
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