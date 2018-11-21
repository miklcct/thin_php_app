<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Test\Request;

use Http\Psr7Test\ServerRequestIntegrationTest;
use Miklcct\ThinPhpApp\Request\ServerRequest;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\ServerRequest as ZendServerRequest;

class ServerRequestTest extends ServerRequestIntegrationTest {
    public function createSubject() {
        return new ServerRequest(new ZendServerRequest($_SERVER));
    }

    public function testGetOriginalRequest() {
        $original = $this->createMock(ServerRequestInterface::class);
        self::assertSame($original, (new ServerRequest($original))->getOriginalRequest());
    }

    public function testGetGatewayInterface() {
        $interface = 'CGI/1.1';
        $original = $this->getRequestWithServer(['GATEWAY_INTERFACE' => $interface]);
        self::assertSame($interface, (new ServerRequest($original))->getGatewayInterface());
    }

    public function testGetServerAddress() {
        $address = '::1';
        $original = $this->getRequestWithServer(['SERVER_ADDR' => $address]);
        self::assertSame($address, (new ServerRequest($original))->getServerAddress());
    }

    public function testGetServerName() {
        $name = 'localhost';
        $original = $this->getRequestWithServer(['SERVER_NAME' => $name]);
        self::assertSame($name, (new ServerRequest($original))->getServerName());
    }

    public function testGetProtocol() {
        $protocol = 'HTTP/1.1';
        $original = $this->getRequestWithServer(['SERVER_PROTOCOL' => $protocol]);
        self::assertSame($protocol, (new ServerRequest($original))->getProtocol());
    }

    public function testGetTime() {
        $time = microtime(TRUE);
        $original = $this->getRequestWithServer(['REQUEST_TIME_FLOAT' => $time]);
        self::assertSame($time, (new ServerRequest($original))->getTime());
    }

    public function testGetQueryString() {
        $query_string = 'a=b&c=d';
        $original = $this->getRequestWithServer(['QUERY_STRING' => $query_string]);
        self::assertSame($query_string, (new ServerRequest($original))->getQueryString());
    }

    public function testGetHost() {
        $host = 'example.com';
        $original = $this->getRequestWithHeaders(['Host' => $host]);
        self::assertSame($host, (new ServerRequest($original))->getHost());
    }

    public function testGetReferrer() {
        $referrer = 'https://www.example.com/';
        $original = $this->getRequestWithHeaders(['Referer' => $referrer]);
        self::assertSame($referrer, (new ServerRequest($original))->getReferrer());
    }

    public function testGetUserAgent() {
        $user_agent = 'Mozilla/5.0 (X11; FreeBSD) AppleWebKit/537.21 (KHTML, like Gecko) konqueror/4.14.3 Safari/537.21';
        $original = $this->getRequestWithHeaders(['User-Agent' => $user_agent]);
        self::assertSame($user_agent, (new ServerRequest($original))->getUserAgent());
    }

    public function testGetClientAddress() {
        $address = '2001:db8::dead:face';
        $original = $this->getRequestWithServer(['REMOTE_ADDR' => $address]);
        self::assertSame($address, (new ServerRequest($original))->getClientAddress());
    }

    public function testGetClientName() {
        $name = 'example.com';
        $original = $this->getRequestWithServer(['REMOTE_HOST' => $name]);
        self::assertSame($name, (new ServerRequest($original))->getClientName());
    }

    public function testGetClientPort() {
        $port = 43511;
        $original = $this->getRequestWithServer(['REMOTE_PORT' => "$port"]);
        self::assertSame($port, (new ServerRequest($original))->getClientPort());
    }

    public function testGetScriptPath() {
        $path = __FILE__;
        $original = $this->getRequestWithServer(['SCRIPT_FILENAME' => $path]);
        self::assertSame($path, (new ServerRequest($original))->getScriptPath());
    }

    public function testGetRequestUri() {
        $uri = '/index.php?foo=bar';
        $original = $this->getRequestWithServer(['REQUEST_URI' => $uri]);
        self::assertSame($uri, (new ServerRequest($original))->getRequestUri());
    }

    public function testGetExternalAuthenticatedUser() {
        $user = 'mary';
        $original = $this->getRequestWithServer(['REMOTE_USER' => $user]);
        self::assertSame($user, (new ServerRequest($original))->getExternalAuthenticatedUser());
    }

    public function testGetExternalAuthenticationType() {
        $authentication_type = 'digest';
        $original = $this->getRequestWithServer(['AUTH_TYPE' => $authentication_type]);
        self::assertSame($authentication_type, (new ServerRequest($original))->getExternalAuthenticationType());
    }

    public function testGetAuthenticationUser() {
        $user = 'mary';
        $original = $this->getRequestWithServer(['PHP_AUTH_USER' => $user]);
        self::assertSame($user, (new ServerRequest($original))->getAuthenticationUser());
    }

    public function testGetAuthenticationPassword() {
        $password = 'P@$$w0rd';
        $original = $this->getRequestWithServer(['PHP_AUTH_PW' => $password]);
        self::assertSame($password, (new ServerRequest($original))->getAuthenticationPassword());
    }

    public function testGetAuthenticationDigest() {
        $digest = 'for internal use only';
        $original = $this->getRequestWithServer(['PHP_AUTH_DIGEST' => $digest]);
        self::assertSame($digest, (new ServerRequest($original))->getAuthenticationDigest());
    }

    public function testGetPathInfo() {
        $path_info = '/a/b/c';
        $original = $this->getRequestWithServer(['PATH_INFO' => $path_info]);
        self::assertSame($path_info, (new ServerRequest($original))->getPathInfo());
    }

    public function testGetTranslatedPathInfo() {
        $translated_path_info = __DIR__ . '/a/b/c';
        $original = $this->getRequestWithServer(['PATH_TRANSLATED' => $translated_path_info]);
        self::assertSame($translated_path_info, (new ServerRequest($original))->getTranslatedPathInfo());
    }

    public function testGetUrl() {
        $url = 'http://example.com:8080/index.php/a-good-article?lang=en';
        $original = new ZendServerRequest([], [], $url);
        self::assertSame($url, (new ServerRequest($original))->getUrl());
    }

    public function testIsOnDefaultPortTrueHttp() {
        $url = 'http://example.com:80/';
        $original = new ZendServerRequest([], [], $url);
        self::assertTrue((new ServerRequest($original))->isOnDefaultPort());
    }

    public function testIsOnDefaultPortFalseHttp() {
        $url = 'http://example.com:443/';
        $original = new ZendServerRequest([], [], $url);
        self::assertFalse((new ServerRequest($original))->isOnDefaultPort());
    }

    public function testIsOnDefaultPortTrueHttps() {
        $url = 'https://example.com:443/';
        $original = new ZendServerRequest([], [], $url);
        self::assertTrue((new ServerRequest($original))->isOnDefaultPort());
    }

    public function testIsOnDefaultPortFalseHttps() {
        $url = 'https://example.com:80/';
        $original = new ZendServerRequest([], [], $url);
        self::assertFalse((new ServerRequest($original))->isOnDefaultPort());
    }

    public function testGetServerPort() {
        $port = 80;
        $original = $this->getRequestWithServer(['SERVER_PORT' => "$port"]);
        self::assertSame($port, (new ServerRequest($original))->getServerPort());
    }

    public function testIsSecureTrue() {
        $original = $this->getRequestWithServer(['HTTPS' => 'on']);
        self::assertTrue((new ServerRequest($original))->isSecure());
    }

    public function testIsSecureFalse() {
        $original = $this->getRequestWithServer([]);
        self::assertFalse((new ServerRequest($original))->isSecure());
    }

    private function getRequestWithHeaders(array $headers) : ServerRequestInterface {
        return new ZendServerRequest([], [], NULL, 'GET', 'php://input', $headers);
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