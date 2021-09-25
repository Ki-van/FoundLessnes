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

    #[NoReturn] public function sendJson(array $message)
    {
        $this->setStatusCode(200);
        header('Content-Type: application/json');
        echo json_encode($message);
        exit();
    }

    #[NoReturn] public function sendText(string $message)
    {
        $this->setStatusCode(200);
        header('Content-Type: text/html');
        echo $message;
        exit();
    }
}