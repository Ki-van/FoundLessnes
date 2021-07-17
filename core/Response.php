<?php


namespace app\core;


use JetBrains\PhpStorm\NoReturn;

class Response
{
    public function setStatusCode($code){
        http_response_code($code);
    }

    #[NoReturn] public function redirect(string $url)
    {
        header('Location: '.$url);
        exit();
    }

    public function sendJson(array $message)
    {
        $this->setStatusCode(200);
        header('Content-Type: application/json');
        echo json_encode($message);
        exit();
    }
}