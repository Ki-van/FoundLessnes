<?php


namespace app\core;


class Controller
{
    public string $layout = 'main';

    /**
     * @param string $layout
     */
    public function setLayout(string $layout): void
    {
        $this->layout = $layout;
    }

    public function render($view, $params = []){
        return Application::$app->router->renderView($view, $params);
    }
}