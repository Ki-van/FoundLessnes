<?php

namespace app\core;

class Application
{
    public static $ROOT_DIR;
    public  $router;
    public  $request;
    public  $response;
    public static $app;
    public $controller;

    public function __construct($root_dir)
    {
        self::$ROOT_DIR = $root_dir;
        self::$app = $this;

        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
    }

    public function run(){
       echo $this->router->resolve();
    }
}