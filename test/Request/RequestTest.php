<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Test\Request;

use Miklcct\ThinPhpApp\Request\Request;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\ServerRequest;

class RequestTest extends TestCase {
    public function testGetOriginalRequest() {
        $original = $this->createMock(ServerRequestInterface::class);
        self::assertSame($original, (new Request($original))->getOriginalRequest());
    }

    public function testGetGatewayInterface() {
        $interface = 'CGI/1.1';
        $original = $this->getRequestWithServer(['GATEWAY_INTERFACE' => $interface]);
        self::assertSame($interface, (new Request($original))->getGatewayInterface());
    }

    public function testGetServerAddress() {
        $address = '::1';
        $original = $this->getRequestWithServer(['SERVER_ADDR' => $address]);
        self::assertSame($address, (new Request($original))->getServerAddress());
    }

    public function testGetServerName() {
        $name = 'localhost';
        $original = $this->getRequestWithServer(['SERVER_NAME' => $name]);
        self::assertSame($name, (new Request($original))->getServerName());
    }

    public function testGetProtocol() {
        $protocol = 'HTTP/1.1';
        $original = $this->getRequestWithServer(['SERVER_PROTOCOL' => $protocol]);
        self::assertSame($protocol, (new Request($original))->getProtocol());
    }

    public function testGetMethod() {
        $method = 'GET';
        $original = $this->getStubRequest(['getMethod' => $method]);
        self::assertSame($method, (new Request($original))->getMethod());
    }

    public function testGetTime() {
        $time = microtime(TRUE);
        $original = $this->getRequestWithServer(['REQUEST_TIME_FLOAT' => $time]);
        self::assertSame($time, (new Request($original))->getTime());
    }

    public function testGetQueryString() {
        $query_string = 'a=b&c=d';
        $original = $this->getRequestWithServer(['QUERY_STRING' => $query_string]);
        self::assertSame($query_string, (new Request($original))->getQueryString());
    }

    public function testGetHost() {
        $host = 'example.com';
        $original = $this->getRequestWithHeaders(['Host' => $host]);
        self::assertSame($host, (new Request($original))->getHost());
    }

    public function testGetReferrer() {
        $referrer = 'https://www.example.com/';
        $original = $this->getRequestWithHeaders(['Referer' => $referrer]);
        self::assertSame($referrer, (new Request($original))->getReferrer());
    }

    public function testGetUserAgent() {
        $user_agent = 'Mozilla/5.0 (X11; FreeBSD) AppleWebKit/537.21 (KHTML, like Gecko) konqueror/4.14.3 Safari/537.21';
        $original = $this->getRequestWithHeaders(['User-Agent' => $user_agent]);
        self::assertSame($user_agent, (new Request($original))->getUserAgent());
    }

    public function testGetClientAddress() {
        $address = '2001:db8::dead:face';
        $original = $this->getRequestWithServer(['REMOTE_ADDR' => $address]);
        self::assertSame($address, (new Request($original))->getClientAddress());
    }

    public function testGetClientName() {
        $name = 'example.com';
        $original = $this->getRequestWithServer(['REMOTE_HOST' => $name]);
        self::assertSame($name, (new Request($original))->getClientName());
    }

    public function testGetClientPort() {
        $port = 43511;
        $original = $this->getRequestWithServer(['REMOTE_PORT' => "$port"]);
        self::assertSame($port, (new Request($original))->getClientPort());
    }

    public function testGetScriptPath() {
        $path = __FILE__;
        $original = $this->getRequestWithServer(['SCRIPT_FILENAME' => $path]);
        self::assertSame($path, (new Request($original))->getScriptPath());
    }

    public function testGetRequestUri() {
        $uri = '/index.php?foo=bar';
        $original = $this->getRequestWithServer(['REQUEST_URI' => $uri]);
        self::assertSame($uri, (new Request($original))->getRequestUri());
    }

    public function testGetExternalAuthenticatedUser() {
        $user = 'mary';
        $original = $this->getRequestWithServer(['REMOTE_USER' => $user]);
        self::assertSame($user, (new Request($original))->getExternalAuthenticatedUser());
    }

    public function testGetExternalAuthenticationType() {
        $authentication_type = 'digest';
        $original = $this->getRequestWithServer(['AUTH_TYPE' => $authentication_type]);
        self::assertSame($authentication_type, (new Request($original))->getExternalAuthenticationType());
    }

    public function testGetAuthenticationUser() {
        $user = 'mary';
        $original = $this->getRequestWithServer(['PHP_AUTH_USER' => $user]);
        self::assertSame($user, (new Request($original))->getAuthenticationUser());
    }

    public function testGetAuthenticationPassword() {
        $password = 'P@$$w0rd';
        $original = $this->getRequestWithServer(['PHP_AUTH_PW' => $password]);
        self::assertSame($password, (new Request($original))->getAuthenticationPassword());
    }

    public function testGetAuthenticationDigest() {
        $digest = 'for internal use only';
        $original = $this->getRequestWithServer(['PHP_AUTH_DIGEST' => $digest]);
        self::assertSame($digest, (new Request($original))->getAuthenticationDigest());
    }

    public function testGetPathInfo() {
        $path_info = '/a/b/c';
        $original = $this->getRequestWithServer(['PATH_INFO' => $path_info]);
        self::assertSame($path_info, (new Request($original))->getPathInfo());
    }

    public function testGetTranslatedPathInfo() {
        $translated_path_info = __DIR__ . '/a/b/c';
        $original = $this->getRequestWithServer(['PATH_TRANSLATED' => $translated_path_info]);
        self::assertSame($translated_path_info, (new Request($original))->getTranslatedPathInfo());
    }

    public function testGetUrl() {
        $url = 'http://example.com:8080/index.php/a-good-article?lang=en';
        $original = new ServerRequest([], [], $url);
        self::assertSame($url, (new Request($original))->getUrl());
    }

    public function testIsOnDefaultPortTrueHttp() {
        $url = 'http://example.com:80/';
        $original = new ServerRequest([], [], $url);
        self::assertTrue((new Request($original))->isOnDefaultPort());
    }

    public function testIsOnDefaultPortFalseHttp() {
        $url = 'http://example.com:443/';
        $original = new ServerRequest([], [], $url);
        self::assertFalse((new Request($original))->isOnDefaultPort());
    }

    public function testIsOnDefaultPortTrueHttps() {
        $url = 'https://example.com:443/';
        $original = new ServerRequest([], [], $url);
        self::assertTrue((new Request($original))->isOnDefaultPort());
    }

    public function testIsOnDefaultPortFalseHttps() {
        $url = 'https://example.com:80/';
        $original = new ServerRequest([], [], $url);
        self::assertFalse((new Request($original))->isOnDefaultPort());
    }

    public function testGetServerPort() {
        $port = 80;
        $original = $this->getRequestWithServer(['SERVER_PORT' => "$port"]);
        self::assertSame($port, (new Request($original))->getServerPort());
    }

    public function testIsSecureTrue() {
        $original = $this->getRequestWithServer(['HTTPS' => 'on']);
        self::assertTrue((new Request($original))->isSecure());
    }

    public function testIsSecureFalse() {
        $original = $this->getRequestWithServer([]);
        self::assertFalse((new Request($original))->isSecure());
    }

    private function getRequestWithHeaders(array $headers) : ServerRequestInterface {
        return new ServerRequest([], [], NULL, 'GET', 'php://input', $headers);
    }

    private function getRequestWithServer(array $server) : ServerRequestInterface {
        return $this->getStubRequest(['getServerParams' => $server]);
    }

    private function getStubRequest(array $stubbed_methods) : ServerRequestInterface {
        $request = $this->createMock(ServerRequestInterface::class);
        foreach ($stubbed_methods as $method => $return_value) {
            $request->method($method)->willReturn($return_value);
        }
        return $request;
    }
}