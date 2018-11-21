<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Request;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;
use function Miklcct\ThinPhpApp\Utility\nullable;

class ServerRequest implements ServerRequestInterface {
    public const DEFAULT_PORTS = [
        'acap' => 674,
        'afp' => 548,
        'dict' => 2628,
        'dns' => 53,
        'file' => NULL,
        'ftp' => 21,
        'git' => 9418,
        'gopher' => 70,
        'http' => 80,
        'https' => 443,
        'imap' => 143,
        'ipp' => 631,
        'ipps' => 631,
        'irc' => 194,
        'ircs' => 6697,
        'ldap' => 389,
        'ldaps' => 636,
        'mms' => 1755,
        'msrp' => 2855,
        'msrps' => NULL,
        'mtqp' => 1038,
        'nfs' => 111,
        'nntp' => 119,
        'nntps' => 563,
        'pop' => 110,
        'prospero' => 1525,
        'redis' => 6379,
        'rsync' => 873,
        'rtsp' => 554,
        'rtsps' => 322,
        'rtspu' => 5005,
        'sftp' => 22,
        'smb' => 445,
        'snmp' => 161,
        'ssh' => 22,
        'steam' => NULL,
        'svn' => 3690,
        'telnet' => 23,
        'ventrilo' => 3784,
        'vnc' => 5900,
        'wais' => 210,
        'ws' => 80,
        'wss' => 443,
        'xmpp' => NULL,
    ];

    public function __construct(ServerRequestInterface $request) {
        $this->request = $request;
    }

    /**
     * Get the original request
     *
     * @return ServerRequestInterface
     */
    public function getOriginalRequest() : ServerRequestInterface {
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
     * @return string e.g. <code>"POST"</code>
     */
    public function getMethod() : string {
        return $this->request->getMethod();
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

    // TODO: accept headers

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
        $port = $this->getUri()->getPort();
        return $port === NULL || $port === (static::DEFAULT_PORTS[$this->getUri()->getScheme()] ?? NULL);
    }

    /**
     * Get the server port of the request
     *
     * @return int|null e.g. <code>80</code>
     */
    public function getServerPort() : ?int {
        return nullable(
            $this->request->getServerParams()['SERVER_PORT'] ?? NULL
            , function ($x) {
                return (int)$x;
            }
        );
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
     * Retrieves the HTTP protocol version as a string.
     *
     * The string MUST contain only the HTTP version number (e.g., "1.1", "1.0").
     *
     * @return string HTTP protocol version.
     */
    public function getProtocolVersion() {
        return $this->request->getProtocolVersion();
    }

    /**
     * Return an instance with the specified HTTP protocol version.
     *
     * The version string MUST contain only the HTTP version number (e.g.,
     * "1.1", "1.0").
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * new protocol version.
     *
     * @param string $version HTTP protocol version
     * @return static
     */
    public function withProtocolVersion($version) : self {
        return new static($this->request->withProtocolVersion($version));
    }

    /**
     * Retrieves all message header values.
     *
     * The keys represent the header name as it will be sent over the wire, and
     * each value is an array of strings associated with the header.
     *
     *     // Represent the headers as a string
     *     foreach ($message->getHeaders() as $name => $values) {
     *         echo $name . ": " . implode(", ", $values);
     *     }
     *
     *     // Emit headers iteratively:
     *     foreach ($message->getHeaders() as $name => $values) {
     *         foreach ($values as $value) {
     *             header(sprintf('%s: %s', $name, $value), false);
     *         }
     *     }
     *
     * While header names are not case-sensitive, getHeaders() will preserve the
     * exact case in which headers were originally specified.
     *
     * @return string[][] Returns an associative array of the message's headers. Each
     *     key MUST be a header name, and each value MUST be an array of strings
     *     for that header.
     */
    public function getHeaders() {
        return $this->request->getHeaders();
    }

    /**
     * Checks if a header exists by the given case-insensitive name.
     *
     * @param string $name Case-insensitive header field name.
     * @return bool Returns true if any header names match the given header
     *     name using a case-insensitive string comparison. Returns false if
     *     no matching header name is found in the message.
     */
    public function hasHeader($name) {
        return $this->request->hasHeader($name);
    }

    /**
     * Retrieves a message header value by the given case-insensitive name.
     *
     * This method returns an array of all the header values of the given
     * case-insensitive header name.
     *
     * If the header does not appear in the message, this method MUST return an
     * empty array.
     *
     * @param string $name Case-insensitive header field name.
     * @return string[] An array of string values as provided for the given
     *    header. If the header does not appear in the message, this method MUST
     *    return an empty array.
     */
    public function getHeader($name) {
        return $this->request->getHeader($name);
    }

    /**
     * Retrieves a comma-separated string of the values for a single header.
     *
     * This method returns all of the header values of the given
     * case-insensitive header name as a string concatenated together using
     * a comma.
     *
     * NOTE: Not all header values may be appropriately represented using
     * comma concatenation. For such headers, use getHeader() instead
     * and supply your own delimiter when concatenating.
     *
     * If the header does not appear in the message, this method MUST return
     * an empty string.
     *
     * @param string $name Case-insensitive header field name.
     * @return string A string of values as provided for the given header
     *    concatenated together using a comma. If the header does not appear in
     *    the message, this method MUST return an empty string.
     */
    public function getHeaderLine($name) {
        return $this->request->getHeaderLine($name);
    }

    /**
     * Return an instance with the provided value replacing the specified header.
     *
     * While header names are case-insensitive, the casing of the header will
     * be preserved by this function, and returned from getHeaders().
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * new and/or updated header and value.
     *
     * @param string $name Case-insensitive header field name.
     * @param string|string[] $value Header value(s).
     * @return static
     * @throws \InvalidArgumentException for invalid header names or values.
     */
    public function withHeader($name, $value) : self {
        return new static($this->request->withHeader($name, $value));
    }

    /**
     * Return an instance with the specified header appended with the given value.
     *
     * Existing values for the specified header will be maintained. The new
     * value(s) will be appended to the existing list. If the header did not
     * exist previously, it will be added.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * new header and/or value.
     *
     * @param string $name Case-insensitive header field name to add.
     * @param string|string[] $value Header value(s).
     * @return static
     * @throws \InvalidArgumentException for invalid header names or values.
     */
    public function withAddedHeader($name, $value) : self {
        return new static($this->request->withAddedHeader($name, $value));
    }

    /**
     * Return an instance without the specified header.
     *
     * Header resolution MUST be done without case-sensitivity.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that removes
     * the named header.
     *
     * @param string $name Case-insensitive header field name to remove.
     * @return static
     */
    public function withoutHeader($name) : self {
        return new static($this->request->withoutHeader($name));
    }

    /**
     * Gets the body of the message.
     *
     * @return StreamInterface Returns the body as a stream.
     */
    public function getBody() {
        return $this->request->getBody();
    }

    /**
     * Return an instance with the specified message body.
     *
     * The body MUST be a StreamInterface object.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return a new instance that has the
     * new body stream.
     *
     * @param StreamInterface $body Body.
     * @return static
     * @throws \InvalidArgumentException When the body is not valid.
     */
    public function withBody(StreamInterface $body) : self {
        return new static($this->request->withBody($body));
    }

    /**
     * Retrieves the message's request target.
     *
     * Retrieves the message's request-target either as it will appear (for
     * clients), as it appeared at request (for servers), or as it was
     * specified for the instance (see withRequestTarget()).
     *
     * In most cases, this will be the origin-form of the composed URI,
     * unless a value was provided to the concrete implementation (see
     * withRequestTarget() below).
     *
     * If no URI is available, and no request-target has been specifically
     * provided, this method MUST return the string "/".
     *
     * @return string
     */
    public function getRequestTarget() {
        return $this->request->getRequestTarget();
    }

    /**
     * Return an instance with the specific request-target.
     *
     * If the request needs a non-origin-form request-target — e.g., for
     * specifying an absolute-form, authority-form, or asterisk-form —
     * this method may be used to create an instance with the specified
     * request-target, verbatim.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * changed request target.
     *
     * @link http://tools.ietf.org/html/rfc7230#section-5.3 (for the various
     *     request-target forms allowed in request messages)
     * @param mixed $requestTarget
     * @return static
     */
    public function withRequestTarget($requestTarget) : self {
        return new static($this->request->withRequestTarget($requestTarget));
    }

    /**
     * Return an instance with the provided HTTP method.
     *
     * While HTTP method names are typically all uppercase characters, HTTP
     * method names are case-sensitive and thus implementations SHOULD NOT
     * modify the given string.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * changed request method.
     *
     * @param string $method Case-sensitive method.
     * @return static
     * @throws \InvalidArgumentException for invalid HTTP methods.
     */
    public function withMethod($method) : self {
        return new static($this->request->withMethod($method));
    }

    /**
     * Retrieves the URI instance.
     *
     * This method MUST return a UriInterface instance.
     *
     * @link http://tools.ietf.org/html/rfc3986#section-4.3
     * @return UriInterface Returns a UriInterface instance
     *     representing the URI of the request.
     */
    public function getUri() {
        return $this->request->getUri();
    }

    /**
     * Returns an instance with the provided URI.
     *
     * This method MUST update the Host header of the returned request by
     * default if the URI contains a host component. If the URI does not
     * contain a host component, any pre-existing Host header MUST be carried
     * over to the returned request.
     *
     * You can opt-in to preserving the original state of the Host header by
     * setting `$preserveHost` to `true`. When `$preserveHost` is set to
     * `true`, this method interacts with the Host header in the following ways:
     *
     * - If the Host header is missing or empty, and the new URI contains
     *   a host component, this method MUST update the Host header in the returned
     *   request.
     * - If the Host header is missing or empty, and the new URI does not contain a
     *   host component, this method MUST NOT update the Host header in the returned
     *   request.
     * - If a Host header is present and non-empty, this method MUST NOT update
     *   the Host header in the returned request.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * new UriInterface instance.
     *
     * @link http://tools.ietf.org/html/rfc3986#section-4.3
     * @param UriInterface $uri New request URI to use.
     * @param bool $preserveHost Preserve the original state of the Host header.
     * @return static
     */
    public function withUri(UriInterface $uri, $preserveHost = FALSE) : self {
        return new static($this->request->withUri($uri));
    }

    /**
     * Retrieve server parameters.
     *
     * Retrieves data related to the incoming request environment,
     * typically derived from PHP's $_SERVER superglobal. The data IS NOT
     * REQUIRED to originate from $_SERVER.
     *
     * @return array
     */
    public function getServerParams() {
        return $this->request->getServerParams();
    }

    /**
     * Retrieve cookies.
     *
     * Retrieves cookies sent by the client to the server.
     *
     * The data MUST be compatible with the structure of the $_COOKIE
     * superglobal.
     *
     * @return array
     */
    public function getCookieParams() {
        return $this->request->getCookieParams();
    }

    /**
     * Return an instance with the specified cookies.
     *
     * The data IS NOT REQUIRED to come from the $_COOKIE superglobal, but MUST
     * be compatible with the structure of $_COOKIE. Typically, this data will
     * be injected at instantiation.
     *
     * This method MUST NOT update the related Cookie header of the request
     * instance, nor related values in the server params.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * updated cookie values.
     *
     * @param array $cookies Array of key/value pairs representing cookies.
     * @return static
     */
    public function withCookieParams(array $cookies) : self {
        return new static($this->request->withCookieParams($cookies));
    }

    /**
     * Retrieve query string arguments.
     *
     * Retrieves the deserialized query string arguments, if any.
     *
     * Note: the query params might not be in sync with the URI or server
     * params. If you need to ensure you are only getting the original
     * values, you may need to parse the query string from `getUri()->getQuery()`
     * or from the `QUERY_STRING` server param.
     *
     * @return array
     */
    public function getQueryParams() {
        return $this->request->getQueryParams();
    }

    /**
     * Return an instance with the specified query string arguments.
     *
     * These values SHOULD remain immutable over the course of the incoming
     * request. They MAY be injected during instantiation, such as from PHP's
     * $_GET superglobal, or MAY be derived from some other value such as the
     * URI. In cases where the arguments are parsed from the URI, the data
     * MUST be compatible with what PHP's parse_str() would return for
     * purposes of how duplicate query parameters are handled, and how nested
     * sets are handled.
     *
     * Setting query string arguments MUST NOT change the URI stored by the
     * request, nor the values in the server params.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * updated query string arguments.
     *
     * @param array $query Array of query string arguments, typically from
     *     $_GET.
     * @return static
     */
    public function withQueryParams(array $query) : self {
        return new static($this->request->withQueryParams($query));
    }

    /**
     * Retrieve normalized file upload data.
     *
     * This method returns upload metadata in a normalized tree, with each leaf
     * an instance of Psr\Http\Message\UploadedFileInterface.
     *
     * These values MAY be prepared from $_FILES or the message body during
     * instantiation, or MAY be injected via withUploadedFiles().
     *
     * @return array An array tree of UploadedFileInterface instances; an empty
     *     array MUST be returned if no data is present.
     */
    public function getUploadedFiles() {
        return $this->request->getUploadedFiles();
    }

    /**
     * Create a new instance with the specified uploaded files.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * updated body parameters.
     *
     * @param array $uploadedFiles An array tree of UploadedFileInterface instances.
     * @return static
     * @throws \InvalidArgumentException if an invalid structure is provided.
     */
    public function withUploadedFiles(array $uploadedFiles) : self {
        return new static($this->request->withUploadedFiles($uploadedFiles));
    }

    /**
     * Retrieve any parameters provided in the request body.
     *
     * If the request Content-Type is either application/x-www-form-urlencoded
     * or multipart/form-data, and the request method is POST, this method MUST
     * return the contents of $_POST.
     *
     * Otherwise, this method may return any results of deserializing
     * the request body content; as parsing returns structured content, the
     * potential types MUST be arrays or objects only. A null value indicates
     * the absence of body content.
     *
     * @return null|array|object The deserialized body parameters, if any.
     *     These will typically be an array or object.
     */
    public function getParsedBody() {
        return $this->request->getParsedBody();
    }

    /**
     * Return an instance with the specified body parameters.
     *
     * These MAY be injected during instantiation.
     *
     * If the request Content-Type is either application/x-www-form-urlencoded
     * or multipart/form-data, and the request method is POST, use this method
     * ONLY to inject the contents of $_POST.
     *
     * The data IS NOT REQUIRED to come from $_POST, but MUST be the results of
     * deserializing the request body content. Deserialization/parsing returns
     * structured data, and, as such, this method ONLY accepts arrays or objects,
     * or a null value if nothing was available to parse.
     *
     * As an example, if content negotiation determines that the request data
     * is a JSON payload, this method could be used to create a request
     * instance with the deserialized parameters.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * updated body parameters.
     *
     * @param null|array|object $data The deserialized body data. This will
     *     typically be in an array or object.
     * @return static
     * @throws \InvalidArgumentException if an unsupported argument type is
     *     provided.
     */
    public function withParsedBody($data) : self {
        return new static($this->request->withParsedBody($data));
    }

    /**
     * Retrieve attributes derived from the request.
     *
     * The request "attributes" may be used to allow injection of any
     * parameters derived from the request: e.g., the results of path
     * match operations; the results of decrypting cookies; the results of
     * deserializing non-form-encoded message bodies; etc. Attributes
     * will be application and request specific, and CAN be mutable.
     *
     * @return array Attributes derived from the request.
     */
    public function getAttributes() {
        return $this->request->getAttributes();
    }

    /**
     * Retrieve a single derived request attribute.
     *
     * Retrieves a single derived request attribute as described in
     * getAttributes(). If the attribute has not been previously set, returns
     * the default value as provided.
     *
     * This method obviates the need for a hasAttribute() method, as it allows
     * specifying a default value to return if the attribute is not found.
     *
     * @see getAttributes()
     * @param string $name The attribute name.
     * @param mixed $default Default value to return if the attribute does not exist.
     * @return mixed
     */
    public function getAttribute($name, $default = NULL) {
        return $this->request->getAttribute($name, $default);
    }

    /**
     * Return an instance with the specified derived request attribute.
     *
     * This method allows setting a single derived request attribute as
     * described in getAttributes().
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * updated attribute.
     *
     * @see getAttributes()
     * @param string $name The attribute name.
     * @param mixed $value The value of the attribute.
     * @return static
     */
    public function withAttribute($name, $value) : self {
        return new static($this->request->withAttribute($name, $value));
    }

    /**
     * Return an instance that removes the specified derived request attribute.
     *
     * This method allows removing a single derived request attribute as
     * described in getAttributes().
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that removes
     * the attribute.
     *
     * @see getAttributes()
     * @param string $name The attribute name.
     * @return static
     */
    public function withoutAttribute($name) : self {
        return new static($this->request->withoutAttribute($name));
    }

    /**
     * @var ServerRequestInterface
     */
    private $request;
}