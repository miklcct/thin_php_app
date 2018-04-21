<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Http;

use function setcookie;

class Cookie {
    public function __construct(
        string $name
        , string $value
        , int $expire = 0
        , string $path = ''
        , string $domain = ''
        , bool $secure = FALSE
        , bool $httpOnly = FALSE
    ) {
        $this->name = $name;
        $this->value = $value;
        $this->expire = $expire;
        $this->path = $path;
        $this->domain = $domain;
        $this->secure = $secure;
        $this->httpOnly = $httpOnly;
    }

    public function getName() : string {
        return $this->name;
    }

    public function getValue() : string {
        return $this->value;
    }

    public function send() : void {
        setcookie($this->name, $this->value, $this->expire, $this->path, $this->domain, $this->secure, $this->httpOnly);
    }

    public function getExpire() : int {
        return $this->expire;
    }

    public function getPath() : string {
        return $this->path;
    }

    public function getDomain() : string {
        return $this->domain;
    }

    public function isSecure() : bool {
        return $this->secure;
    }

    public function isHttpOnly() : bool {
        return $this->httpOnly;
    }

    /** @var string */
    private $name;
    /** @var string */
    private $value;
    /** @var int */
    private $expire;
    /** @var string */
    private $path;
    /** @var string */
    private $domain;
    /** @var bool */
    private $secure;
    /** @var bool */
    private $httpOnly;
}