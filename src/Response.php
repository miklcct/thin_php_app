<?php

declare(strict_types=1);

namespace Miklcct\ThinPhpApp;

/**
 * Class Response
 * @package Miklcct\ThinPhpApp
 */
class Response
{
    /* The following constants are copied from Symfony HttpFoundation package

    Copyright (c) 2004-2018 Fabien Potencier

    Permission is hereby granted, free of charge, to any person obtaining a copy
    of this software and associated documentation files (the "Software"), to deal
    in the Software without restriction, including without limitation the rights
    to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
    copies of the Software, and to permit persons to whom the Software is furnished
    to do so, subject to the following conditions:

    The above copyright notice and this permission notice shall be included in all
    copies or substantial portions of the Software.

    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
    IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
    FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
    AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
    LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
    OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
    THE SOFTWARE.
    */

    const HTTP_CONTINUE = 100;
    const HTTP_SWITCHING_PROTOCOLS = 101;
    const HTTP_PROCESSING = 102; // RFC2518
    const HTTP_EARLY_HINTS = 103;
    const HTTP_OK = 200;
    const HTTP_CREATED = 201;
    const HTTP_ACCEPTED = 202;
    const HTTP_NON_AUTHORITATIVE_INFORMATION = 203;
    const HTTP_NO_CONTENT = 204;
    const HTTP_RESET_CONTENT = 205;
    const HTTP_PARTIAL_CONTENT = 206;
    const HTTP_MULTI_STATUS = 207; // RFC4918
    const HTTP_ALREADY_REPORTED = 208; // RFC5842
    const HTTP_IM_USED = 226; // RFC3229
    const HTTP_MULTIPLE_CHOICES = 300;
    const HTTP_MOVED_PERMANENTLY = 301;
    const HTTP_FOUND = 302;
    const HTTP_SEE_OTHER = 303;
    const HTTP_NOT_MODIFIED = 304;
    const HTTP_USE_PROXY = 305;
    const HTTP_RESERVED = 306;
    const HTTP_TEMPORARY_REDIRECT = 307;
    const HTTP_PERMANENTLY_REDIRECT = 308; // RFC7238
    const HTTP_BAD_REQUEST = 400;
    const HTTP_UNAUTHORIZED = 401;
    const HTTP_PAYMENT_REQUIRED = 402;
    const HTTP_FORBIDDEN = 403;
    const HTTP_NOT_FOUND = 404;
    const HTTP_METHOD_NOT_ALLOWED = 405;
    const HTTP_NOT_ACCEPTABLE = 406;
    const HTTP_PROXY_AUTHENTICATION_REQUIRED = 407;
    const HTTP_REQUEST_TIMEOUT = 408;
    const HTTP_CONFLICT = 409;
    const HTTP_GONE = 410;
    const HTTP_LENGTH_REQUIRED = 411;
    const HTTP_PRECONDITION_FAILED = 412;
    const HTTP_REQUEST_ENTITY_TOO_LARGE = 413;
    const HTTP_REQUEST_URI_TOO_LONG = 414;
    const HTTP_UNSUPPORTED_MEDIA_TYPE = 415;
    const HTTP_REQUESTED_RANGE_NOT_SATISFIABLE = 416;
    const HTTP_EXPECTATION_FAILED = 417;
    const HTTP_I_AM_A_TEAPOT = 418; // RFC2324
    const HTTP_MISDIRECTED_REQUEST = 421; // RFC7540
    const HTTP_UNPROCESSABLE_ENTITY = 422; // RFC4918
    const HTTP_LOCKED = 423; // RFC4918
    const HTTP_FAILED_DEPENDENCY = 424; // RFC4918
    const HTTP_RESERVED_FOR_WEBDAV_ADVANCED_COLLECTIONS_EXPIRED_PROPOSAL = 425; // RFC2817
    const HTTP_UPGRADE_REQUIRED = 426; // RFC2817
    const HTTP_PRECONDITION_REQUIRED = 428; // RFC6585
    const HTTP_TOO_MANY_REQUESTS = 429; // RFC6585
    const HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE = 431; // RFC6585
    const HTTP_UNAVAILABLE_FOR_LEGAL_REASONS = 451;
    const HTTP_INTERNAL_SERVER_ERROR = 500;
    const HTTP_NOT_IMPLEMENTED = 501;
    const HTTP_BAD_GATEWAY = 502;
    const HTTP_SERVICE_UNAVAILABLE = 503;
    const HTTP_GATEWAY_TIMEOUT = 504;
    const HTTP_VERSION_NOT_SUPPORTED = 505;
    const HTTP_VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL = 506; // RFC2295
    const HTTP_INSUFFICIENT_STORAGE = 507; // RFC4918
    const HTTP_LOOP_DETECTED = 508; // RFC5842
    const HTTP_NOT_EXTENDED = 510; // RFC2774
    const HTTP_NETWORK_AUTHENTICATION_REQUIRED = 511; // RFC6585

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
        self::HTTP_CONTINUE => 'Continue',
        self::HTTP_SWITCHING_PROTOCOLS => 'Switching Protocols',
        self::HTTP_PROCESSING => 'Processing', // RFC2518
        self::HTTP_EARLY_HINTS => 'Early Hints',
        self::HTTP_OK => 'OK',
        self::HTTP_CREATED => 'Created',
        self::HTTP_ACCEPTED => 'Accepted',
        self::HTTP_NON_AUTHORITATIVE_INFORMATION => 'Non-Authoritative Information',
        self::HTTP_NO_CONTENT => 'No Content',
        self::HTTP_RESET_CONTENT => 'Reset Content',
        self::HTTP_PARTIAL_CONTENT => 'Partial Content',
        self::HTTP_MULTI_STATUS => 'Multi-Status', // RFC4918
        self::HTTP_ALREADY_REPORTED => 'Already Reported', // RFC5842
        self::HTTP_IM_USED => 'IM Used', // RFC3229
        self::HTTP_MULTIPLE_CHOICES => 'Multiple Choices',
        self::HTTP_MOVED_PERMANENTLY => 'Moved Permanently',
        self::HTTP_FOUND => 'Found',
        self::HTTP_SEE_OTHER => 'See Other',
        self::HTTP_NOT_MODIFIED => 'Not Modified',
        self::HTTP_USE_PROXY => 'Use Proxy',
        self::HTTP_RESERVED => 'Reserved',
        self::HTTP_TEMPORARY_REDIRECT => 'Temporary Redirect',
        self::HTTP_PERMANENTLY_REDIRECT => 'Permanent Redirect', // RFC7238
        self::HTTP_BAD_REQUEST => 'Bad Request',
        self::HTTP_UNAUTHORIZED => 'Unauthorized',
        self::HTTP_PAYMENT_REQUIRED => 'Payment Required',
        self::HTTP_FORBIDDEN => 'Forbidden',
        self::HTTP_NOT_FOUND => 'Not Found',
        self::HTTP_METHOD_NOT_ALLOWED => 'Method Not Allowed',
        self::HTTP_NOT_ACCEPTABLE => 'Not Acceptable',
        self::HTTP_PROXY_AUTHENTICATION_REQUIRED => 'Proxy Authentication Required',
        self::HTTP_REQUEST_TIMEOUT => 'Request Timeout',
        self::HTTP_CONFLICT => 'Conflict',
        self::HTTP_GONE => 'Gone',
        self::HTTP_LENGTH_REQUIRED => 'Length Required',
        self::HTTP_PRECONDITION_FAILED => 'Precondition Failed',
        self::HTTP_REQUEST_ENTITY_TOO_LARGE => 'Payload Too Large',
        self::HTTP_REQUEST_URI_TOO_LONG => 'URI Too Long',
        self::HTTP_UNSUPPORTED_MEDIA_TYPE => 'Unsupported Media Type',
        self::HTTP_REQUESTED_RANGE_NOT_SATISFIABLE => 'Range Not Satisfiable',
        self::HTTP_EXPECTATION_FAILED => 'Expectation Failed',
        self::HTTP_I_AM_A_TEAPOT => 'I\'m a teapot', // RFC2324
        self::HTTP_MISDIRECTED_REQUEST => 'Misdirected Request', // RFC7540
        self::HTTP_UNPROCESSABLE_ENTITY => 'Unprocessable Entity', // RFC4918
        self::HTTP_LOCKED => 'Locked', // RFC4918
        self::HTTP_FAILED_DEPENDENCY => 'Failed Dependency', // RFC4918
        self::HTTP_RESERVED_FOR_WEBDAV_ADVANCED_COLLECTIONS_EXPIRED_PROPOSAL => 'Reserved for WebDAV advanced collections expired proposal', // RFC2817
        self::HTTP_UPGRADE_REQUIRED => 'Upgrade Required', // RFC2817
        self::HTTP_PRECONDITION_REQUIRED => 'Precondition Required', // RFC6585
        self::HTTP_TOO_MANY_REQUESTS => 'Too Many Requests', // RFC6585
        self::HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE => 'Request Header Fields Too Large', // RFC6585
        self::HTTP_UNAVAILABLE_FOR_LEGAL_REASONS => 'Unavailable For Legal Reasons', // RFC7725
        self::HTTP_INTERNAL_SERVER_ERROR => 'Internal Server Error',
        self::HTTP_NOT_IMPLEMENTED => 'Not Implemented',
        self::HTTP_BAD_GATEWAY => 'Bad Gateway',
        self::HTTP_SERVICE_UNAVAILABLE => 'Service Unavailable',
        self::HTTP_GATEWAY_TIMEOUT => 'Gateway Timeout',
        self::HTTP_VERSION_NOT_SUPPORTED => 'HTTP Version Not Supported',
        self::HTTP_VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL => 'Variant Also Negotiates', // RFC2295
        self::HTTP_INSUFFICIENT_STORAGE => 'Insufficient Storage', // RFC4918
        self::HTTP_LOOP_DETECTED => 'Loop Detected', // RFC5842
        self::HTTP_NOT_EXTENDED => 'Not Extended', // RFC2774
        self::HTTP_NETWORK_AUTHENTICATION_REQUIRED => 'Network Authentication Required', // RFC6585
    ];

    public function __construct(
        int $status = self::HTTP_OK
        , string $content = ''
        , array $headers = []
        , array $cookies = []
    ) {
        $this->status = $status;
        $this->statusText = self::HTTP_STATUS_TEXTS[$status] ?? '';
        $this->content = $content;
        $this->headers = $headers;
        $this->cookies = $cookies;
    }

    public function send() {

    }

    public function getStatus() : int {
        return $this->status;
    }

    public function getStatusText() : string {
        return $this->statusText;
    }

    public function getContent() : string {
        return $this->content;
    }

    public function getHeaders() : array {
        return $this->headers;
    }

    public function getCookies() : array {
        return $this->cookies;
    }

    /** @var int */
    private $status;
    /** @var string */
    private $statusText;
    /** @var string */
    private $content;
    /** @var array */
    private $headers;
    /** @var array */
    private $cookies;

}