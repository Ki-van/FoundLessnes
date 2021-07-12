<?php


namespace app\core\middlewares;


use app\core\Application;

abstract class BaseMiddleware
{
    protected array $actions;
    protected $restrictFor;
    protected $callback;

    abstract public function __construct($restrictFor, array $actions = [], Callable $callback = null);
    abstract public function execute();

    public function restrict(string $exception)
    {
        if (empty($this->actions) || in_array(Application::$app->controller->action, $this->actions)) {
            if ($this->callback !== null)
                call_user_func($this->callback);
            else
                throw new $exception();
        }
    }
}