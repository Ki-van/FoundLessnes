<?php


namespace app\core;


class Request
{
    public function getPath()
    {
        $path = $_SERVER["REQUEST_URI"];
        if (!$path)
            return '/';

        $path = urldecode($path);
        $position = strpos($path, '?');
        if ($position === false) {
            if (str_ends_with($path, '/')) {
                return substr($path, 0, strlen($path) - 1);
            } else {
                return $path;
            }
        } else
            return substr($path, 0, $position);
    }

    public function isGet(): bool
    {
        return $this->method() === 'get';
    }

    public function method(): string
    {
        return strtolower($_SERVER["REQUEST_METHOD"]);
    }

    public function isPost(): bool
    {
        return $this->method() === 'post';
    }

    public function getBody(): array
    {
        $body = [];

        if ($this->method() === 'get') {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        if ($this->method() === 'post') {
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $body;
    }

}