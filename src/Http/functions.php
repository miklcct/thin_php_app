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

function get_gateway_interface(ServerRequestInterface $request) : ?string {
    return $request->getServerParams()['GATEWAY_INTERFACE'] ?? NULL;
}

function get_server_address(ServerRequestInterface $request) : ?string {
    return $request->getServerParams()['SERVER_ADDR'] ?? NULL;
}

function get_server_port(ServerRequestInterface $request) : ?int {
    return nullable(
        $request->getServerParams()['SERVER_PORT']
        , function ($x) {
            return (int)$x;
        }
    );
}

function get_server_name(ServerRequestInterface $request) : ?string {
    return $request->getServerParams()['SERVER_NAME'] ?? NULL;
}

function get_protocol(ServerRequestInterface $request) : ?string {
    return $request->getServerParams()['SERVER_PROTOCOL'] ?? NULL;
}

function get_method(ServerRequestInterface $request) : ?string {
    return $request->getServerParams()['REQUEST_METHOD'] ?? NULL;
}

function get_time(ServerRequestInterface $request) : ?float {
    return $request->getServerParams()['REQUEST_TIME_FLOAT'] ?? NULL;
}

function get_query_string(ServerRequestInterface $request) : ?string {
    return $request->getServerParams()['QUERY_STRING'] ?? NULL;
}

// TODO: accept headers

function get_host(ServerRequestInterface $request) : string {
    return $request->getHeaderLine('Host');
}

function get_referrer(ServerRequestInterface $request) : string {
    return $request->getHeaderLine('Referer');
}

function get_user_agent(ServerRequestInterface $request) : string {
    return $request->getHeaderLine('User-Agent');
}

function is_secure(ServerRequestInterface $request) : bool {
    return !empty($request->getServerParams()['HTTPS']) && $request->getServerParams()['HTTPS'] !== 'off';
}

function get_client_address(ServerRequestInterface $request) : ?string {
    return $request->getServerParams()['REMOTE_ADDR'] ?? NULL;
}

function get_client_name(ServerRequestInterface $request) : ?string {
    return $request->getServerParams()['REMOTE_HOST'] ?? NULL;
}

function get_client_port(ServerRequestInterface $request) : ?int {
    return nullable(
        $request->getServerParams()['REMOTE_PORT']
        , function ($x) {
            return (int)$x;
        }
    );
}

function get_script_path(ServerRequestInterface $request) : ?string {
    return $request->getServerParams()['SCRIPT_FILENAME'] ?? NULL;
}

function get_request_uri(ServerRequestInterface $request) : ?string {
    return $request->getServerParams()['REQUEST_URI'] ?? NULL;
}

function get_remote_user(ServerRequestInterface $request) : ?string {
    return $request->getServerParams()['REMOTE_USER'] ?? $request->getServerParams()['REDIRECT_REMOTE_USER'] ?? NULL;
}

function get_auth_user(ServerRequestInterface $request) : ?string {
    return $request->getServerParams()['PHP_AUTH_USER'] ?? NULL;
}

function get_auth_password(ServerRequestInterface $request) : ?string {
    return $request->getServerParams()['PHP_AUTH_PW'] ?? NULL;
}

function get_auth_digest(ServerRequestInterface $request) : ?string {
    return $request->getServerParams()['PHP_AUTH_DIGEST'] ?? NULL;
}

function get_auth_type(ServerRequestInterface $request) : ?string {
    return $request->getServerParams()['AUTH_TYPE'] ?? NULL;
}

function get_path_info(ServerRequestInterface $request) : ?string {
    return $request->getServerParams()['ORIG_PATH_INFO'] ?? $request->getServerParams()['PATH_INFO'] ?? NULL;
}

function get_url(ServerRequestInterface $request) : string {
    return $request->getUri()->__toString();
}

function is_on_default_port(ServerRequestInterface $request) : ?bool {
    return nullable(
        get_server_port($request)
        , function (int $port) use ($request) {
            return is_secure($request) ? $port === 443 : $port === 80;
        }
    );
}
