<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Http;

use Psr\Http\Message\ServerRequestInterface;
use function Miklcct\ThinPhpApp\nullable;

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

function get_server_host_name(ServerRequestInterface $request) : ?string {
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

function get_host(ServerRequestInterface $request) : ?string {
    return $request->getServerParams()['HTTP_HOST'] ?? NULL;
}

function get_referrer(ServerRequestInterface $request) : ?string {
    return $request->getServerParams()['HTTP_REFERER'] ?? NULL;
}

function get_user_agent(ServerRequestInterface $request) : ?string {
    return $request->getServerParams()['HTTP_USER_AGENT'] ?? NULL;
}

function is_secure(ServerRequestInterface $request) : bool {
    return !empty($request->getServerParams()['HTTPS']) && $request->getServerParams()['HTTPS'] !== 'off';
}

function get_client_address(ServerRequestInterface $request) : ?string {
    return $request->getServerParams()['REMOTE_ADDR'] ?? NULL;
}

function get_client_host_name(ServerRequestInterface $request) : ?string {
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
    return (is_secure($request) ? 'https://' : 'http://')
        . (get_host($request) ?? get_server_host_name($request) ?? get_server_address($request) ?? 'localhost')
        . (is_on_default_port($request) === FALSE ? ':' . get_server_port($request) : '')
        . get_request_uri($request);
}

function is_on_default_port(ServerRequestInterface $request) : ?bool {
    return nullable(
        get_server_port($request)
        , function (int $port) use ($request) {
            return is_secure($request) ? $port === 443 : $port === 80;
        }
    );
}
