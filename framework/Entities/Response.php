<?php

namespace Framework\Entities;

class Response
{
    public const DEFAULT_STATUS_CODE = self::STATUS_CODE_OK;
    public const DEFAULT_CONTENT_TYPE = self::CONTENT_TYPE_TEXT_HTML;

    public const CONTENT_TYPE_APPLICATION_JSON = 'application/json';
    public const CONTENT_TYPE_TEXT_HTML = 'text/html';

    public const STATUS_CODE_CONTINUE = 100;
    public const STATUS_CODE_SWITCHING_PROTOCOLS = 101;
    public const STATUS_CODE_PROCESSING = 102;
    public const STATUS_CODE_EARLY_HINTS = 103;
    public const STATUS_CODE_OK = 200;
    public const STATUS_CODE_CREATED = 201;
    public const STATUS_CODE_ACCEPTED = 202;
    public const STATUS_CODE_NON_AUTHORITATIVE_INFORMATION = 203;
    public const STATUS_CODE_NO_CONTENT = 204;
    public const STATUS_CODE_RESET_CONTENT = 205;
    public const STATUS_CODE_PARTIAL_CONTENT = 206;
    public const STATUS_CODE_MULTI_STATUS = 207;
    public const STATUS_CODE_ALREADY_REPORTED = 208;
    public const STATUS_CODE_IM_USED = 226;
    public const STATUS_CODE_MULTIPLE_CHOICES = 300;
    public const STATUS_CODE_MOVED_PERMANENTLY = 301;
    public const STATUS_CODE_FOUND = 302;
    public const STATUS_CODE_SEE_OTHER = 303;
    public const STATUS_CODE_NOT_MODIFIED = 304;
    public const STATUS_CODE_USE_PROXY = 305;
    public const STATUS_CODE_RESERVED = 306;
    public const STATUS_CODE_TEMPORARY_REDIRECT = 307;
    public const STATUS_CODE_PERMANENTLY_REDIRECT = 308;
    public const STATUS_CODE_BAD_REQUEST = 400;
    public const STATUS_CODE_UNAUTHORIZED = 401;
    public const STATUS_CODE_PAYMENT_REQUIRED = 402;
    public const STATUS_CODE_FORBIDDEN = 403;
    public const STATUS_CODE_NOT_FOUND = 404;
    public const STATUS_CODE_METHOD_NOT_ALLOWED = 405;
    public const STATUS_CODE_NOT_ACCEPTABLE = 406;
    public const STATUS_CODE_PROXY_AUTHENTICATION_REQUIRED = 407;
    public const STATUS_CODE_REQUEST_TIMEOUT = 408;
    public const STATUS_CODE_CONFLICT = 409;
    public const STATUS_CODE_GONE = 410;
    public const STATUS_CODE_LENGTH_REQUIRED = 411;
    public const STATUS_CODE_PRECONDITION_FAILED = 412;
    public const STATUS_CODE_REQUEST_ENTITY_TOO_LARGE = 413;
    public const STATUS_CODE_REQUEST_URI_TOO_LONG = 414;
    public const STATUS_CODE_UNSUPPORTED_MEDIA_TYPE = 415;
    public const STATUS_CODE_REQUESTED_RANGE_NOT_SATISFIABLE = 416;
    public const STATUS_CODE_EXPECTATION_FAILED = 417;
    public const STATUS_CODE_I_AM_A_TEAPOT = 418;
    public const STATUS_CODE_MISDIRECTED_REQUEST = 421;
    public const STATUS_CODE_UNPROCESSABLE_ENTITY = 422;
    public const STATUS_CODE_LOCKED = 423;
    public const STATUS_CODE_FAILED_DEPENDENCY = 424;
    public const STATUS_CODE_TOO_EARLY = 425;
    public const STATUS_CODE_UPGRADE_REQUIRED = 426;
    public const STATUS_CODE_PRECONDITION_REQUIRED = 428;
    public const STATUS_CODE_TOO_MANY_REQUESTS = 429;
    public const STATUS_CODE_REQUEST_HEADER_FIELDS_TOO_LARGE = 431;
    public const STATUS_CODE_UNAVAILABLE_FOR_LEGAL_REASONS = 451;
    public const STATUS_CODE_INTERNAL_SERVER_ERROR = 500;
    public const STATUS_CODE_NOT_IMPLEMENTED = 501;
    public const STATUS_CODE_BAD_GATEWAY = 502;
    public const STATUS_CODE_SERVICE_UNAVAILABLE = 503;
    public const STATUS_CODE_GATEWAY_TIMEOUT = 504;
    public const STATUS_CODE_VERSION_NOT_SUPPORTED = 505;
    public const STATUS_CODE_VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL = 506;
    public const STATUS_CODE_INSUFFICIENT_STORAGE = 507;
    public const STATUS_CODE_LOOP_DETECTED = 508;
    public const STATUS_CODE_NOT_EXTENDED = 510;
    public const STATUS_CODE_NETWORK_AUTHENTICATION_REQUIRED = 511;

    /** @var string */
    protected $contentType = self::DEFAULT_CONTENT_TYPE;
    /** @var int */
    protected $statusCode = self::DEFAULT_STATUS_CODE;
    /** @var string */
    protected $content = '';

    /**
     * @param string $name
     * @param array $params
     * @param int $statusCode
     * @return $this
     */
    public function view(string $name, array $params = [], int $statusCode = self::DEFAULT_STATUS_CODE): self
    {
        $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

        switch ($ext) {
            case 'php':
                return $this->viewPhp($name, $params, $statusCode);
            case 'html':
            case 'htm':
                return $this->viewHtml($name, $params, $statusCode);
        }

        $path = VIEW_DIR . DIRECTORY_SEPARATOR . $name;
        if (file_exists("{$path}.php")) {
            return $this->viewPhp("{$name}.php", $params, $statusCode);
        }
        if (file_exists("{$path}.html")) {
            return $this->viewHtml("{$name}.html", $params, $statusCode);
        }
        if (file_exists("{$path}.htm")) {
            return $this->viewHtml("{$name}.htm", $params, $statusCode);
        }
        return $this;
    }

    protected function viewPhp(string $name, array $params = [], int $statusCode = self::DEFAULT_STATUS_CODE): self
    {
        $this->contentType = self::CONTENT_TYPE_TEXT_HTML;
        $fn = static function ($___params___lADpMgqRxWSoV7HB, $___name___lADpMgqRxWSoV7HB) {
            extract($___params___lADpMgqRxWSoV7HB, EXTR_OVERWRITE);
            ob_start();
            require VIEW_DIR . DIRECTORY_SEPARATOR . $___name___lADpMgqRxWSoV7HB;
            return ob_get_clean();
        };
        $this->content = $fn($params, $name);
        $this->statusCode = $statusCode;
        return $this;
    }

    protected function viewHtml(string $name, array $params = [], int $statusCode = self::DEFAULT_STATUS_CODE): self
    {
        $this->contentType = self::CONTENT_TYPE_TEXT_HTML;
        $html_file = file_get_contents(VIEW_DIR . DIRECTORY_SEPARATOR . $name);
        $param_keys = array_keys($params);
        $param_values = array_values($params);
        array_walk($param_keys, static function (&$value) {
            $value = "{{$value}}";
        });
        $this->content = str_replace(
            $param_keys,
            $param_values,
            $html_file
        );
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * @param string $html
     * @param int $statusCode
     * @return $this
     */
    public function html(string $html, int $statusCode = self::DEFAULT_STATUS_CODE): self
    {
        $this->contentType = self::CONTENT_TYPE_TEXT_HTML;
        $this->content = $html;
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * @param string|object|array $json
     * @param int $statusCode
     * @return $this
     */
    public function json($json, int $statusCode = self::DEFAULT_STATUS_CODE): self
    {
        $this->contentType = self::CONTENT_TYPE_APPLICATION_JSON;
        $this->content = is_string($json) ? $json : json_encode($json);
        $this->statusCode = $statusCode;
        return $this;
    }

    public function render(): void
    {
        @header("Content-Type: {$this->contentType}");
        @http_response_code($this->statusCode);
        echo $this->content;
        exit();
    }
}
