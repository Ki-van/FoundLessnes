<?php


namespace app\core\middlewares;


use app\core\Application;
use app\core\exception\ForbiddenException;

class AuthorizationMiddleware extends BaseMiddleware
{
    /**
     * AuthorizationMiddleware constructor.
     * @param $restrictFor  *role const from User class
     * @param array $actions
     * @param callable|null $callback
     */
    public function __construct($restrictFor, array $actions = [], Callable $callback = null)
    {
        $this->actions = $actions;
        $this->restrictFor = $restrictFor;
        $this->callback = $callback;
    }

    public function execute(array $params)
    {
        if(empty($this->methods)) {
            if (!Application::isAdmin() && $this->restrictFor === Application::$app->userClass::ROLE_USER) {
                $this->restrict(ForbiddenException::class);
            }
        }
    }

}