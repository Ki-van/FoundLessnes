<?php


namespace app\core;


use app\core\middlewares\BaseMiddleware;

class Controller
{
    public string $layout = 'main';
    public string $action = '';
    /**
     * @var BaseMiddleware[]
     */
    protected array $middlewares = [];

    /**
     * @param string $layout
     */
    public function setLayout(string $layout): void
    {
        $this->layout = $layout;
    }

    public function renderView($view, $params = []){
        return Application::$app->view->renderView($view, $params);
    }

    public function registerMiddleware(BaseMiddleware $middleware)
    {
        $this->middlewares[] = $middleware;
    }

    /**
     * @return BaseMiddleware[]
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }


}