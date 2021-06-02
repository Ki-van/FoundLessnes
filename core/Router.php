<?php

namespace app\core;

class Router
{
    protected array $routes = [];
    public Request $request;

    /**
     * Router constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    public function get($path, $callback){
        $this->routes['get'][$path] = $callback;
    }

    public function resolve()
    {
       $path = $this->request->getPath();
       $method = $this->request->getMethod();
       $callback = $this->routes[$method][$path] ?? false;

       if($callback === false) {
           echo "Ты зашел далеко, 404 (";
           exit;
       }

       echo call_user_func($callback);
    }
}