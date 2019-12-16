<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Test\Request;

use Http\Psr7Test\ServerRequestIntegrationTest;
use Miklcct\ThinPhpApp\Request\ServerRequest;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\ServerRequest as ZendServerRequest;

class ServerRequestTest extends ServerRequestIntegrationTest {
    public function createSubject() : ServerRequest {
        return new ServerRequest(new ZendServerRequest($_SERVER));
    }

    public function testGetOriginalRequest() : void {
        $original = $this->createMock(ServerRequestInterface::class);
        self::assertSame($original, (new ServerRequest($original))->getOriginalRequest());
    }

    public function testGetGatewayInterface() : void {
        $interface = 'CGI/1.1';
        $original = $this->getRequestWithServer(['GATEWAY_INTERFACE' => $interface]);
        self::assertSame($interface, (new ServerRequest($original))->getGatewayInterface());
    }

    public function testGetServerAddress() : void {
        $address = '::1';
        $original = $this->getRequestWithServer(['SERVER_ADDR' => $address]);
        self::assertSame($address, (new ServerRequest($original))->getServerAddress());
    }

    public function testGetServerName() : void {
        $name = 'localhost';
        $original = $this->getRequestWithServer(['SERVER_NAME' => $name]);
        self::assertSame($name, (new ServerRequest($original))->getServerName());
    }

    public function testGetProtocol() : void {
        $protocol = 'HTTP/1.1';
        $original = $this->getRequestWithServer(['SERVER_PROTOCOL' => $protocol]);
        self::assertSame($protocol, (new ServerRequest($original))->getProtocol());
    }

    public function testGetTime() : void {
        $time = microtime(TRUE);
        $original = $this->getRequestWithServer(['REQUEST_TIME_FLOAT' => $time]);
        self::assertSame($time, (new ServerRequest($original))->getTime());
    }

    public function testGetQueryString() : void {
        $query_string = 'a=b&c=d';
        $original = $this->getRequestWithServer(['QUERY_STRING' => $query_string]);
        self::assertSame($query_string, (new ServerRequest($original))->getQueryString());
    }

    public function testGetHost() : void {
        $host = 'example.com';
        $original = $this->getRequestWithHeaders(['Host' => $host]);
        self::assertSame($host, (new ServerRequest($original))->getHost());
    }

    public function testGetReferrer() : void {
        $referrer = 'https://www.example.com/';
        $original = $this->getRequestWithHeaders(['Referer' => $referrer]);
        self::assertSame($referrer, (new ServerRequest($original))->getReferrer());
    }

    public function testGetUserAgent() : void {
        $user_agent = 'Mozilla/5.0 (X11; FreeBSD) AppleWebKit/537.21 (KHTML, like Gecko) konqueror/4.14.3 Safari/537.21';
        $original = $this->getRequestWithHeaders(['User-Agent' => $user_agent]);
        self::assertSame($user_agent, (new ServerRequest($original))->getUserAgent());
    }

    public function testGetClientAddress() : void {
        $address = '2001:db8::dead:face';
        $original = $this->getRequestWithServer(['REMOTE_ADDR' => $address]);
        self::assertSame($address, (new ServerRequest($original))->getClientAddress());
    }

    public function testGetClientName() : void {
        $name = 'example.com';
        $original = $this->getRequestWithServer(['REMOTE_HOST' => $name]);
        self::assertSame($name, (new ServerRequest($original))->getClientName());
    }

    public function testGetClientPort() : void {
        $port = 43511;
        $original = $this->getRequestWithServer(['REMOTE_PORT' => "$port"]);
        self::assertSame($port, (new ServerRequest($original))->getClientPort());
    }

    public function testGetScriptPath() : void {
        $path = __FILE__;
        $original = $this->getRequestWithServer(['SCRIPT_FILENAME' => $path]);
        self::assertSame($path, (new ServerRequest($original))->getScriptPath());
    }

    public function testGetRequestUri() : void {
        $uri = '/index.php?foo=bar';
        $original = $this->getRequestWithServer(['REQUEST_URI' => $uri]);
        self::assertSame($uri, (new ServerRequest($original))->getRequestUri());
    }

    public function testGetExternalAuthenticatedUser() : void {
        $user = 'mary';
        $original = $this->getRequestWithServer(['REMOTE_USER' => $user]);
        self::assertSame($user, (new ServerRequest($original))->getExternalAuthenticatedUser());
    }

    public function testGetExternalAuthenticationType() : void {
        $authentication_type = 'digest';
        $original = $this->getRequestWithServer(['AUTH_TYPE' => $authentication_type]);
        self::assertSame($authentication_type, (new ServerRequest($original))->getExternalAuthenticationType());
    }

    public function testGetAuthenticationUser() : void {
        $user = 'mary';
        $original = $this->getRequestWithServer(['PHP_AUTH_USER' => $user]);
        self::assertSame($user, (new ServerRequest($original))->getAuthenticationUser());
    }

    public function testGetAuthenticationPassword() : void {
        $password = 'P@$$w0rd';
        $original = $this->getRequestWithServer(['PHP_AUTH_PW' => $password]);
        self::assertSame($password, (new ServerRequest($original))->getAuthenticationPassword());
    }

    public function testGetAuthenticationDigest() : void {
        $digest = 'for internal use only';
        $original = $this->getRequestWithServer(['PHP_AUTH_DIGEST' => $digest]);
        self::assertSame($digest, (new ServerRequest($original))->getAuthenticationDigest());
    }

    public function testGetPathInfo() : void {
        $path_info = '/a/b/c';
        $original = $this->getRequestWithServer(['PATH_INFO' => $path_info]);
        self::assertSame($path_info, (new ServerRequest($original))->getPathInfo());
    }

    public function testGetTranslatedPathInfo() : void {
        $translated_path_info = __DIR__ . '/a/b/c';
        $original = $this->getRequestWithServer(['PATH_TRANSLATED' => $translated_path_info]);
        self::assertSame($translated_path_info, (new ServerRequest($original))->getTranslatedPathInfo());
    }

    public function testGetUrl() : void {
        $url = 'http://example.com:8080/index.php/a-good-article?lang=en';
        $original = new ZendServerRequest([], [], $url);
        self::assertSame($url, (new ServerRequest($original))->getUrl());
    }

    public function testIsOnDefaultPortTrueHttp() : void {
        $url = 'http://example.com:80/';
        $original = new ZendServerRequest([], [], $url);
        self::assertTrue((new ServerRequest($original))->isOnDefaultPort());
    }

    public function testIsOnDefaultPortFalseHttp() : void {
        $url = 'http://example.com:443/';
        $original = new ZendServerRequest([], [], $url);
        self::assertFalse((new ServerRequest($original))->isOnDefaultPort());
    }

    public function testIsOnDefaultPortTrueHttps() : void {
        $url = 'https://example.com:443/';
        $original = new ZendServerRequest([], [], $url);
        self::assertTrue((new ServerRequest($original))->isOnDefaultPort());
    }

    public function testIsOnDefaultPortFalseHttps() : void {
        $url = 'https://example.com:80/';
        $original = new ZendServerRequest([], [], $url);
        self::assertFalse((new ServerRequest($original))->isOnDefaultPort());
    }

    public function testGetServerPort() : void {
        $port = 80;
        $original = $this->getRequestWithServer(['SERVER_PORT' => "$port"]);
        self::assertSame($port, (new ServerRequest($original))->getServerPort());
    }

    public function testIsSecureTrue() : void {
        $original = $this->getRequestWithServer(['HTTPS' => 'on']);
        self::assertTrue((new ServerRequest($original))->isSecure());
    }

    public function testIsSecureFalse() : void {
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