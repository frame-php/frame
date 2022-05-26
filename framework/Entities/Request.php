<?php

namespace Framework\Entities;

class Request
{
    /**
     * @return string|null
     */
    public function uri(): ?string
    {
        return $this->server('REQUEST_URI');
    }

    public function line(): ?string
    {
        $argv = $this->argv();
        array_shift($argv);
        return implode(' ', $argv);
    }

    /**
     * @param null $key
     * @param null $default
     * @return mixed|string|array|null
     */
    public function argv($key = null, $default = null)
    {
        $argv = $this->server('argv', []);
        if ($key !== null) {
            return $argv[$key] ?? $default;
        }
        return $argv;
    }

    /**
     * @param string|int|null $key
     * @param mixed $default
     * @return mixed|string|array|null
     */
    public function get($key = null, $default = null)
    {
        if ($key !== null) {
            return $_GET[$key] ?? $default;
        }
        return $_GET;
    }

    /**
     * @param string|int|null $key
     * @param mixed $default
     * @return mixed|string|array|null
     */
    public function post($key = null, $default = null)
    {
        if ($key !== null) {
            return $_POST[$key] ?? $default;
        }
        return $_POST;
    }

    /**
     * @param mixed $default
     * @return string|null
     */
    public function input($default = null)
    {
        $input = file_get_contents('php://input');
        if (is_string($input)) {
            return $input;
        }
        return $default;
    }

    /**
     * @param string|int|null $key
     * @param mixed $default
     * @return array|mixed|null
     */
    public function json($key = null, $default = null)
    {
        $data = @json_decode($this->input(), true);
        if (!is_array($data)) {
            return $default;
        }
        if ($key !== null) {
            return $data[$key] ?? $default;
        }
        return $data;
    }

    /**
     * @param string|int|null $key
     * @param mixed $default
     * @return mixed|string|array|null
     */
    public function server($key = null, $default = null)
    {
        if ($key !== null) {
            return $_SERVER[$key] ?? $default;
        }
        return $_SERVER;
    }

    /**
     * @param string|int|null $key
     * @param mixed $default
     * @return mixed|string|array|null
     */
    public function all($key = null, $default = null)
    {
        if ($key !== null) {
            return $_REQUEST[$key] ?? $default;
        }
        return $_REQUEST;
    }

    public function isGet(): bool
    {
        return $this->server('REQUEST_METHOD', 'GET') === 'GET';
    }

    public function isPost(): bool
    {
        return $this->server('REQUEST_METHOD', 'GET') === 'POST';
    }

    public function isHead(): bool
    {
        return $this->server('REQUEST_METHOD', 'GET') === 'HEAD';
    }

    public function isPut(): bool
    {
        return $this->server('REQUEST_METHOD', 'GET') === 'PUT';
    }
}
