<?php


namespace app\core;


class Request
{
    public function getPath()
    {
        $path = $_SERVER["REQUEST_URI"];
        if (!$path || $path === '/')
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

    public function getJsonData()
    {
        return json_decode(file_get_contents("php://input"), );
    }

    public function getFile(int $i, string $userfile): array|null
    {
        $fileFields = [];
        if ($this->containsFile($userfile)) {
            foreach ($_FILES[$userfile] as $key => $value) {
                if (is_array($value))
                    if (array_key_exists($i, $value))
                        $fileFields[$key] = $value[$i];
                    else return null;
                else
                    $fileFields[$key] = $value;
            }
        } else
            return null;

        return $fileFields;
    }

    public function getFirstFile(string $userfile)
    {
        return $this->getFile(0, $userfile);
    }


    public function containsFile($userfile): bool
    {
        return !empty($_FILES[$userfile]);
    }

    public function getCookie(string $cookieName)
    {
        return $_COOKIE[$cookieName] ?? null;
    }

    public function getHeader(string $headerName)
    {
        return $this->getHeaders()[$headerName] ?? null;
    }

    public function getFromServer(string $prop)
    {
        return filter_input(INPUT_SERVER, $prop, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }
    private function getHeaders(): array
    {
        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
        return $headers;
    }
}