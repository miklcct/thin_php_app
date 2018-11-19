<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Request;

use function Miklcct\ThinPhpApp\Utility\nullable;
use Psr\Http\Message\ServerRequestInterface;

class RequestHelpers {
    public function __construct(ServerRequestInterface $request) {
        $this->request = $request;
    }

    /**
     * Get the original request
     *
     * @return ServerRequestInterface
     */
    public function getRequest() : ServerRequestInterface {
        return $this->request;
    }

    /**
     * Get the gateway interface of the request
     *
     * @return null|string e.g. <code>"CGI/1.1"</code>
     */
    public function getGatewayInterface() : ?string {
        return $this->request->getServerParams()['GATEWAY_INTERFACE'] ?? NULL;
    }

    /**
     * Get the server IP address of the request
     *
     * @return null|string e.g. <code>"2001:db8::dead:face"</code>
     */
    public function getServerAddress() : ?string {
        return $this->request->getServerParams()['SERVER_ADDR'] ?? NULL;
    }

    /**
     * Get the server port of the request
     *
     * @return int|null e.g. <code>80</code>
     */
    public function getServerPort() : ?int {
        return nullable(
            $this->request->getServerParams()['SERVER_PORT']
            , function ($x) {
                return (int)$x;
            }
        );
    }

    /**
     * Get the server name of the request
     *
     * According to Apache documentation, this name is used to construct a self-referential URL.
     * If <code>UseCanonicalName on</code>, this value is retrieved from <code>ServerName</code> set in the Apache config.
     * However, if <code>UseCanonicalName off</code>, the client-supplied host name is used.
     *
     * @return null|string e.g. <code>"www.example.com"</code>
     */
    public function getServerName() : ?string {
        return $this->request->getServerParams()['SERVER_NAME'] ?? NULL;
    }

    /**
     * Get the protocol of the request
     *
     * @return null|string e.g. <code>"HTTP/1.1"</code>
     */
    public function getProtocol() : ?string {
        return $this->request->getServerParams()['SERVER_PROTOCOL'] ?? NULL;
    }

    /**
     * Get the method of the request
     *
     * @return null|string e.g. <code>"POST"</code>
     */
    public function getMethod() : ?string {
        return $this->request->getServerParams()['REQUEST_METHOD'] ?? NULL;
    }

    /**
     * Get the time (in UNIX timestamp) of the request
     *
     * @return float|null e.g. <code>1388273645.193</code>
     */
    public function getTime() : ?float {
        return $this->request->getServerParams()['REQUEST_TIME_FLOAT'] ?? NULL;
    }

    /**
     * Get the query string of the request
     *
     * The <code>?</code> symbol is not part of the query string, therefore it is not returned.
     *
     * @return null|string e.g. <code>foo=1&bar=2</code>
     */
    public function getQueryString() : ?string {
        return $this->request->getServerParams()['QUERY_STRING'] ?? NULL;
    }

    // TODO: accept headers

    /**
     * Get the host name as sent in HTTP Host: header
     *
     * If the client has not supplied a value, empty is returned.
     *
     * @return string e.g. <code>"example.com"</code>, <code>"www.example.com:8080"</code>
     */
    public function getHost() : string {
        return $this->request->getHeaderLine('Host');
    }

    /**
     * Get the client-supplied referrer
     *
     * If the client has not supplied a value, empty is returned.
     *
     * @return string e.g. <code>"http://example.com"</code>
     */
    public function getReferrer() : string {
        return $this->request->getHeaderLine('Referer');
    }

    /**
     * Get the user agent of the client
     *
     * If the client has not supplied a value, empty is returned
     *
     * @return string e.g. <code>"Mozilla/5.0 (X11; FreeBSD) AppleWebKit/537.21 (KHTML, like Gecko) konqueror/4.14.3 Safari/537.21"</code>
     */
    public function getUserAgent() : string {
        return $this->request->getHeaderLine('User-Agent');
    }

    /**
     * Is the request secure (i.e. using HTTPS)
     *
     * @return bool
     */
    public function isSecure() : bool {
        return !empty($this->request->getServerParams()['HTTPS']) && $this->request->getServerParams()['HTTPS'] !== 'off';
    }

    /**
     * Get the client IP address
     *
     * @return null|string e.g. <code>"2001:db8::dead:face"</code>
     */
    public function getClientAddress() : ?string {
        return $this->request->getServerParams()['REMOTE_ADDR'] ?? NULL;
    }

    /**
     * Get the client host name
     *
     * The web server must be configured to do a reverse DNS lookup on the clients in order for this value to be given
     *
     * @return null|string e.g. <code>"example.com"</code>
     */
    public function getClientName() : ?string {
        return $this->request->getServerParams()['REMOTE_HOST'] ?? NULL;
    }

    /**
     * Get the client port
     *
     * @return int|null e.g. <code>43511</code>
     */
    public function getClientPort() : ?int {
        return nullable(
            $this->request->getServerParams()['REMOTE_PORT']
            , function ($x) {
                return (int)$x;
            }
        );
    }

    /**
     * Get the file system path of the script handling the request
     *
     * On web servers, it is given as an absolute path inside the document root. Symbolic link is not resolved.
     *
     * If run using CLI, it may contain relative path.
     *
     * @return null|string e.g. <code>"/var/www/html/index.php"</code>
     */
    public function getScriptPath() : ?string {
        return $this->request->getServerParams()['SCRIPT_FILENAME'] ?? NULL;
    }

    /**
     * Get the request URI (the string sent in the HTTP message after the method)
     *
     * It is composed of a path and a query string.
     *
     * @return null|string e.g. "/index.php?foo=bar"
     */
    public function getRequestUri() : ?string {
        return $this->request->getServerParams()['REQUEST_URI'] ?? NULL;
    }

    /**
     * Get the external authenticated (authenticated by the web serer) user
     *
     * @return null|string e.g. "john"
     */
    public function getExternalAuthenticatedUser() : ?string {
        return $this->request->getServerParams()['REMOTE_USER'] ?? $this->request->getServerParams()['REDIRECT_REMOTE_USER'] ?? NULL;
    }

    /**
     * Get the authentication type from the web server
     *
     * This value is only given for external authentication
     *
     * @return null|string
     */
    public function getExternalAuthenticationType() : ?string {
        return $this->request->getServerParams()['AUTH_TYPE'] ?? NULL;
    }

    /**
     * Get the HTTP authentication user name for processing by the script
     *
     * If external authentication is used, the value is not given
     *
     * @return null|string
     */
    public function getAuthenticationUser() : ?string {
        return $this->request->getServerParams()['PHP_AUTH_USER'] ?? NULL;
    }

    /**
     * Get the HTTP authentication password for processing by the script
     *
     * If external authentication is used, the value is not given
     *
     * @return null|string
     */
    public function getAuthenticationPassword() : ?string {
        return $this->request->getServerParams()['PHP_AUTH_PW'] ?? NULL;
    }

    /**
     * Get the HTTP authentication digest for processing by the script
     *
     * If external authentication is used, the value is not given
     *
     * @return null|string
     */
    public function getAuthenticationDigest() : ?string {
        return $this->request->getServerParams()['PHP_AUTH_DIGEST'] ?? NULL;
    }

    /**
     * Get the path info of the request
     *
     * The path info is defined as the path segments after the script.
     * For example, if your script is located at <code>/example/index.php</code> under the document root,
     * and the request URI is <code>/example/index.php/2010/03/02/hello-world</code>,
     * the path info would be "<code>/2010/03/02/hello-world</code>"
     *
     * @return null|string
     */
    public function getPathInfo() : ?string {
        return $this->request->getServerParams()['ORIG_PATH_INFO'] ?? $this->request->getServerParams()['PATH_INFO'] ?? NULL;
    }

    /**
     * Get the translated path info of the request
     *
     * The translated path info is the path info under the document root. This is useful to scripts which need to
     * take files under the document root for further processing.
     *
     * For example, if the document root is <code>/srv/http</code>,
     * your script is located at <code>/srv/http/tools/convert_to_pdf.php</code>,
     * and the request URI is <code>/tools/convert_to_pdf.php/documents/report.docx</code>,
     * the translated path info would be <code>/srv/http/documents/report.docx</code>
     *
     * @return null|string
     */
    public function getTranslatedPathInfo() : ?string {
        return $this->request->getServerParams()['PATH_TRANSLATED'] ?? NULL;
    }

    /**
     * Get the complete URL of the request
     *
     * @return string e.g. <code>"http://example.com:8080/index.php/a-good-article?lang=en"</code>
     */
    public function getUrl() : string {
        return $this->request->getUri()->__toString();
    }

    /**
     * Is the request on the default port of the protocol
     *
     * The default port is 80 for non-secure http, 443 for secure https
     *
     * NULL is returned if the request is not done through a server port
     *
     * @return bool|null
     */
    public function isOnDefaultPort() : ?bool {
        return nullable(
            $this->getServerPort()
            , function (int $port) {
                return $this->isSecure() ? $port === 443 : $port === 80;
            }
        );
    }

    /**
     * @var ServerRequestInterface
     */
    private $request;
}