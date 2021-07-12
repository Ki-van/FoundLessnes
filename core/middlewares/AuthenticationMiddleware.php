<?php


namespace app\core\middlewares;


use app\core\Application;
use app\core\exception\ForbiddenException;

class AuthenticationMiddleware extends BaseMiddleware
{
    const GUEST = 1;
    const NOT_GUEST = 2;


    /**
     * AuthenticationMiddleware constructor.
     * @param $restrictFor *const from AuthenticationMiddleware class
     * @param array $actions
     * @param callable|null $callback
     */
    public function __construct($restrictFor, array $actions = [], Callable $callback = null)
    {
        $this->actions = $actions;
        $this->restrictFor = $restrictFor;
        $this->callback = $callback;
    }

    public function execute()
    {
        if ((Application::isGuest() && $this->restrictFor === self::GUEST) ||
            (!Application::isGuest() && $this->restrictFor === self::NOT_GUEST)) {
            if (empty($this->actions) || in_array(Application::$app->controller->action, $this->actions)) {
                if ($this->callback !== null)
                    call_user_func($this->callback);
                else
                    throw new ForbiddenException();
            }
        }
    }

}