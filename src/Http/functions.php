<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Http;

use Psr\Http\Message\ServerRequestInterface;
use function Miklcct\ThinPhpApp\nullable;

/**
 * Status codes translation table.
 *
 * The list of codes is complete according to the
 * {@link http://www.iana.org/assignments/http-status-codes/ Hypertext Transfer Protocol (HTTP) Status Code Registry}
 * (last updated 2016-03-01).
 *
 * Unless otherwise noted, the status code is defined in RFC2616.
 */
const HTTP_STATUS_TEXTS = [
    100 => 'Continue',
    101 => 'Switching Protocols',
    102 => 'Processing',            // RFC2518
    103 => 'Early Hints',
    200 => 'OK',
    201 => 'Created',
    202 => 'Accepted',
    203 => 'Non-Authoritative Information',
    204 => 'No Content',
    205 => 'Reset Content',
    206 => 'Partial Content',
    207 => 'Multi-Status',          // RFC4918
    208 => 'Already Reported',      // RFC5842
    226 => 'IM Used',               // RFC3229
    300 => 'Multiple Choices',
    301 => 'Moved Permanently',
    302 => 'Found',
    303 => 'See Other',
    304 => 'Not Modified',
    305 => 'Use Proxy',
    307 => 'Temporary Redirect',
    308 => 'Permanent Redirect',    // RFC7238
    400 => 'Bad Request',
    401 => 'Unauthorized',
    402 => 'Payment Required',
    403 => 'Forbidden',
    404 => 'Not Found',
    405 => 'Method Not Allowed',
    406 => 'Not Acceptable',
    407 => 'Proxy Authentication Required',
    408 => 'Request Timeout',
    409 => 'Conflict',
    410 => 'Gone',
    411 => 'Length Required',
    412 => 'Precondition Failed',
    413 => 'Payload Too Large',
    414 => 'URI Too Long',
    415 => 'Unsupported Media Type',
    416 => 'Range Not Satisfiable',
    417 => 'Expectation Failed',
    418 => 'I\'m a teapot',                                               // RFC2324
    421 => 'Misdirected Request',                                         // RFC7540
    422 => 'Unprocessable Entity',                                        // RFC4918
    423 => 'Locked',                                                      // RFC4918
    424 => 'Failed Dependency',                                           // RFC4918
    425 => 'Reserved for WebDAV advanced collections expired proposal',   // RFC2817
    426 => 'Upgrade Required',                                            // RFC2817
    428 => 'Precondition Required',                                       // RFC6585
    429 => 'Too Many Requests',                                           // RFC6585
    431 => 'Request Header Fields Too Large',                             // RFC6585
    451 => 'Unavailable For Legal Reasons',                               // RFC7725
    500 => 'Internal Server Error',
    501 => 'Not Implemented',
    502 => 'Bad Gateway',
    503 => 'Service Unavailable',
    504 => 'Gateway Timeout',
    505 => 'HTTP Version Not Supported',
    506 => 'Variant Also Negotiates',                                     // RFC2295
    507 => 'Insufficient Storage',                                        // RFC4918
    508 => 'Loop Detected',                                               // RFC5842
    510 => 'Not Extended',                                                // RFC2774
    511 => 'Network Authentication Required',                             // RFC6585
];

/**
 * Get the gateway interface of the request
 *
 * @param ServerRequestInterface $request
 * @return null|string e.g. <code>"CGI/1.1"</code>
 */
function get_gateway_interface(ServerRequestInterface $request) : ?string {
    return $request->getServerParams()['GATEWAY_INTERFACE'] ?? NULL;
}

/**
 * Get the server IP address of the request
 *
 * @param ServerRequestInterface $request
 * @return null|string e.g. <code>"2001:db8::dead:face"</code>
 */
function get_server_address(ServerRequestInterface $request) : ?string {
    return $request->getServerParams()['SERVER_ADDR'] ?? NULL;
}

/**
 * Get the server port of the request
 *
 * @param ServerRequestInterface $request
 * @return int|null e.g. <code>80</code>
 */
function get_server_port(ServerRequestInterface $request) : ?int {
    return nullable(
        $request->getServerParams()['SERVER_PORT']
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
 * @param ServerRequestInterface $request
 * @return null|string e.g. <code>"www.example.com"</code>
 */
function get_server_name(ServerRequestInterface $request) : ?string {
    return $request->getServerParams()['SERVER_NAME'] ?? NULL;
}

/**
 * Get the protocol of the request
 *
 * @param ServerRequestInterface $request
 * @return null|string e.g. <code>"HTTP/1.1"</code>
 */
function get_protocol(ServerRequestInterface $request) : ?string {
    return $request->getServerParams()['SERVER_PROTOCOL'] ?? NULL;
}

/**
 * Get the method of the request
 *
 * @param ServerRequestInterface $request
 * @return null|string e.g. <code>"POST"</code>
 */
function get_method(ServerRequestInterface $request) : ?string {
    return $request->getServerParams()['REQUEST_METHOD'] ?? NULL;
}

/**
 * Get the time (in UNIX timestamp) of the request
 *
 * @param ServerRequestInterface $request
 * @return float|null e.g. <code>1388273645.193</code>
 */
function get_time(ServerRequestInterface $request) : ?float {
    return $request->getServerParams()['REQUEST_TIME_FLOAT'] ?? NULL;
}

/**
 * Get the query string of the request
 *
 * The <code>?</code> symbol is not part of the query string, therefore it is not returned.
 *
 * @param ServerRequestInterface $request
 * @return null|string e.g. <code>foo=1&bar=2</code>
 */
function get_query_string(ServerRequestInterface $request) : ?string {
    return $request->getServerParams()['QUERY_STRING'] ?? NULL;
}

// TODO: accept headers

/**
 * Get the host name as sent in HTTP Host: header
 *
 * If the client has not supplied a value, empty is returned.
 *
 * @param ServerRequestInterface $request
 * @return string e.g. <code>"example.com"</code>, <code>"www.example.com:8080"</code>
 */
function get_host(ServerRequestInterface $request) : string {
    return $request->getHeaderLine('Host');
}

/**
 * Get the client-supplied referrer
 *
 * If the client has not supplied a value, empty is returned.
 *
 * @param ServerRequestInterface $request
 * @return string e.g. <code>"http://example.com"</code>
 */
function get_referrer(ServerRequestInterface $request) : string {
    return $request->getHeaderLine('Referer');
}

/**
 * Get the user agent of the client
 *
 * If the client has not supplied a value, empty is returned
 *
 * @param ServerRequestInterface $request
 * @return string e.g. <code>"Mozilla/5.0 (X11; FreeBSD) AppleWebKit/537.21 (KHTML, like Gecko) konqueror/4.14.3 Safari/537.21"</code>
 */
function get_user_agent(ServerRequestInterface $request) : string {
    return $request->getHeaderLine('User-Agent');
}

/**
 * Is the request secure (i.e. using HTTPS)
 *
 * @param ServerRequestInterface $request
 * @return bool
 */
function is_secure(ServerRequestInterface $request) : bool {
    return !empty($request->getServerParams()['HTTPS']) && $request->getServerParams()['HTTPS'] !== 'off';
}

/**
 * Get the client IP address
 *
 * @param ServerRequestInterface $request
 * @return null|string e.g. <code>"2001:db8::dead:face"</code>
 */
function get_client_address(ServerRequestInterface $request) : ?string {
    return $request->getServerParams()['REMOTE_ADDR'] ?? NULL;
}

/**
 * Get the client host name
 *
 * The web server must be configured to do a reverse DNS lookup on the clients in order for this value to be given
 *
 * @param ServerRequestInterface $request
 * @return null|string e.g. <code>"example.com"</code>
 */
function get_client_name(ServerRequestInterface $request) : ?string {
    return $request->getServerParams()['REMOTE_HOST'] ?? NULL;
}

/**
 * Get the client port
 *
 * @param ServerRequestInterface $request
 * @return int|null e.g. <code>43511</code>
 */
function get_client_port(ServerRequestInterface $request) : ?int {
    return nullable(
        $request->getServerParams()['REMOTE_PORT']
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
 * @param ServerRequestInterface $request
 * @return null|string e.g. <code>"/var/www/html/index.php"</code>
 */
function get_script_path(ServerRequestInterface $request) : ?string {
    return $request->getServerParams()['SCRIPT_FILENAME'] ?? NULL;
}

/**
 * Get the request URI (the string sent in the HTTP message after the method)
 *
 * It is composed of a path and a query string.
 *
 * @param ServerRequestInterface $request
 * @return null|string e.g. "/index.php?foo=bar"
 */
function get_request_uri(ServerRequestInterface $request) : ?string {
    return $request->getServerParams()['REQUEST_URI'] ?? NULL;
}

/**
 * Get the external authenticated (authenticated by the web serer) user
 *
 * @param ServerRequestInterface $request
 * @return null|string e.g. "john"
 */
function get_remote_user(ServerRequestInterface $request) : ?string {
    return $request->getServerParams()['REMOTE_USER'] ?? $request->getServerParams()['REDIRECT_REMOTE_USER'] ?? NULL;
}

/**
 * Get the HTTP authentication user name for processing by the script
 *
 * If external authentication is used, the value is not given
 *
 * @param ServerRequestInterface $request
 * @return null|string
 */
function get_auth_user(ServerRequestInterface $request) : ?string {
    return $request->getServerParams()['PHP_AUTH_USER'] ?? NULL;
}

/**
 * Get the HTTP authentication password for processing by the script
 *
 * If external authentication is used, the value is not given
 *
 * @param ServerRequestInterface $request
 * @return null|string
 */
function get_auth_password(ServerRequestInterface $request) : ?string {
    return $request->getServerParams()['PHP_AUTH_PW'] ?? NULL;
}

/**
 * Get the HTTP authentication digest for processing by the script
 *
 * If external authentication is used, the value is not given
 *
 * @param ServerRequestInterface $request
 * @return null|string
 */
function get_auth_digest(ServerRequestInterface $request) : ?string {
    return $request->getServerParams()['PHP_AUTH_DIGEST'] ?? NULL;
}

/**
 * Get the authentication type of the script from the web server
 *
 * This value is only given for external authentication
 *
 * @param ServerRequestInterface $request
 * @return null|string
 */
function get_auth_type(ServerRequestInterface $request) : ?string {
    return $request->getServerParams()['AUTH_TYPE'] ?? NULL;
}

/**
 * Get the path info of the request
 *
 * The path info is defined as the path segments after the script.
 * For example, if your script is located at <code>"/example/index.php"</code> under the document root,
 * and the request URI is <code>"/example/index.php/2010/03/02/hello-world"</code>,
 * the path info would be "<code>/2010/03/02/hello-world</code>"
 *
 * @param ServerRequestInterface $request
 * @return null|string
 */
function get_path_info(ServerRequestInterface $request) : ?string {
    return $request->getServerParams()['ORIG_PATH_INFO'] ?? $request->getServerParams()['PATH_INFO'] ?? NULL;
}

/**
 * Get the complete URL of the request
 *
 * @param ServerRequestInterface $request
 * @return string e.g. <code>"http://example.com:8080/index.php/a-good-article?lang=en"</code>
 */
function get_url(ServerRequestInterface $request) : string {
    return $request->getUri()->__toString();
}

/**
 * Is the request on the default port of the protocol
 *
 * The default port is 80 for non-secure http, 443 for secure https
 *
 * NULL is returned if the request is not done through a server port
 *
 * @param ServerRequestInterface $request
 * @return bool|null
 */
function is_on_default_port(ServerRequestInterface $request) : ?bool {
    return nullable(
        get_server_port($request)
        , function (int $port) use ($request) {
            return is_secure($request) ? $port === 443 : $port === 80;
        }
    );
}
